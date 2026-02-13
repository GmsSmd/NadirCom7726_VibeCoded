<?php
// Modernized dodues.php
session_start();
require_once __DIR__ . '/../config.php';

// Authentication Check
if(!isset($_SESSION['login_user'])){
    header("location: ../login.php");
    exit();
}

use App\Services\PaymentService;

// Initialize Service
$paymentService = new PaymentService();

// Handle Legacy Includes for variables (Date logic mainly)
include_once('includes/dbcon.php'); 
include_once('includes/variables.php');
// We do NOT include formula2.php anymore, we handle logic here.

$currentUser = $_SESSION['login_user'];
$employeeName = mysqli_real_escape_string($con, $_GET['name'] ?? '');
if (empty($employeeName)) {
    $employeeName = 'Select DO';
}

// Handle Form Submissions
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionDate = $_POST['txtDate'] ?? date('Y-m-d');
    $mode = $_POST['modeSelect'] ?? '---';
    
    try {
        if (isset($_POST['SaveDuePaid'])) {
            // Pay To DO
            $amount = $_POST['txtAmntPaid'];
            $notes = $_POST['txtNotesP'];
            
            if ($mode == '---' || empty($amount)) {
                throw new Exception("Please select a mode and enter an amount.");
            }
            
            $paymentService->addTransaction('DO Dues', $transactionDate, 'PaidTo', $employeeName, $amount, $mode, $currentUser, $notes);
            $message = "Payment of $amount successfully recorded.";
            $messageType = "success";
        }
        elseif (isset($_POST['SaveDueReceived'])) {
            // Receive From DO
            $amount = $_POST['txtAmntReceived'];
            $notes = $_POST['txtNotesR'];
            
            if ($mode == '---' || empty($amount)) {
                throw new Exception("Please select a mode and enter an amount.");
            }
            
            $paymentService->addTransaction('DO Dues', $transactionDate, 'ReceivedFrom', $employeeName, $amount, $mode, $currentUser, $notes);
            $message = "Receipt of $amount successfully recorded.";
            $messageType = "success";
        }
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "error";
    }
}

// Fetch Data for Report
$openingBalance = $paymentService->getDuesOpening($employeeName, $CurrentMonth);
$dailyDues = $paymentService->getDailyDues($employeeName, $date_from, $date_to);

// Calculate Totals and Running Balance
$reportData = [];
$currentBalance = $openingBalance;
$totalPaid = 0;
$totalReceived = 0;

foreach ($dailyDues as $day) {
    // Logic from legacy: Closing = (Opening + Paid) - Received
    // Opening for next day = Closing
    
    $paid = $day['paid'];
    $received = $day['received'];
    
    $closing = ($currentBalance + $paid) - $received;
    
    $reportData[] = [
        'date' => date("d-M-Y", strtotime($day['date'])),
        'opening' => $currentBalance,
        'paid' => $paid,
        'paidNotes' => $day['paidNotes'],
        'received' => $received,
        'receivedNotes' => $day['receivedNotes'],
        'closing' => $closing
    ];
    
    $totalPaid += $paid;
    $totalReceived += $received;
    $currentBalance = $closing;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DO Dues - <?php echo htmlspecialchars($employeeName); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-slate-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                         <span class="font-bold text-xl text-indigo-600">NadirCom</span>
                    </div>
                </div>
                 <div class="hidden md:flex items-center space-x-4">
                    <a href="../admin/summary.php" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Summary</a>
                    <a href="../admin/dosales.php?name=DO" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Sales</a>
                    <a href="../admin/dodues.php?name=DO" class="text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">DO Dues</a>
                    <a href="../logout.php" class="text-red-500 hover:text-red-700 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                 </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <?php if (!empty($message)): ?>
            <div class="mb-4 rounded-md p-4 <?php echo $messageType === 'success' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'; ?> border">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Header & Employee Selection -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">DO Dues: <?php echo htmlspecialchars($employeeName); ?></h1>
            <div class="mt-4 md:mt-0 flex space-x-2 overflow-x-auto pb-2 max-w-full">
                <?php
                $employees = $paymentService->getDuesEmployees();
                foreach($employees as $emp) {
                    $isActive = ($emp['EmpName'] == $employeeName) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
                    echo '<a href="dodues.php?name='.urlencode($emp['EmpName']).'" 
                             class="px-3 py-1 rounded-full shadow-sm text-xs font-semibold whitespace-nowrap border border-gray-200 ' . $isActive . '">
                             '.htmlspecialchars($emp['EmpName']).'
                          </a>';
                }
                ?>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Payment / Receipt Form -->
            <div class="md:col-span-2 bg-white shadow-lg rounded-xl border border-gray-100 p-6">
                <form action="" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        <!-- Common Fields -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="txtDate" value="<?php echo date('Y-m-d'); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mode</label>
                            <select name="modeSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                <option>---</option>
                                <option>Cash</option>
                                <?php
                                $bankQ = mysqli_query($con, "SELECT Name from company WHERE Type='BNK'");
                                while($row = mysqli_fetch_assoc($bankQ)) {
                                    $selected = ($row['Name'] == $defaultBankName) ? 'selected' : '';
                                    echo "<option $selected>{$row['Name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="hidden md:block"></div>
                        <div class="hidden md:block"></div>
                    </div>

                    <div class="border-t pt-4 grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Pay To DO Section -->
                        <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                            <h3 class="text-md font-semibold text-red-800 mb-3">Pay To DO (Withdraw)</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-red-700">Amount</label>
                                    <input type="text" name="txtAmntPaid" placeholder="Amount" class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm border p-2">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-red-700">Comments</label>
                                    <div class="flex space-x-2">
                                        <input type="text" name="txtNotesP" class="mt-1 block w-full rounded-md border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm border p-2">
                                        <button type="submit" name="SaveDuePaid" class="mt-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Pay
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Receive From DO Section -->
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <h3 class="text-md font-semibold text-green-800 mb-3">Receive From DO (Deposit)</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-green-700">Amount</label>
                                    <input type="text" name="txtAmntReceived" placeholder="Amount" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm border p-2">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-green-700">Comments</label>
                                    <div class="flex space-x-2">
                                        <input type="text" name="txtNotesR" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm border p-2">
                                        <button type="submit" name="SaveDueReceived" class="mt-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Receive
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Ledger Table -->
        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Opening</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-red-600 uppercase tracking-wider">Paid (Withdraw)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-green-600 uppercase tracking-wider">Received (Deposit)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-900 uppercase tracking-wider font-bold">Closing</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($reportData as $row): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $row['date']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right"><?php echo number_format($row['opening']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium text-right"><?php echo $row['paid'] ? number_format($row['paid']) : '-'; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 italic"><?php echo $row['paidNotes']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium text-right"><?php echo $row['received'] ? number_format($row['received']) : '-'; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 italic"><?php echo $row['receivedNotes']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right"><?php echo number_format($row['closing']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900">TOTAL</td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3 text-sm font-bold text-red-700 text-right"><?php echo number_format($totalPaid); ?></td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3 text-sm font-bold text-green-700 text-right"><?php echo number_format($totalReceived); ?></td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3 text-sm font-bold text-gray-900 text-right"><?php echo number_format($currentBalance); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-sm">
            &copy; <?php echo date('Y'); ?> VibeCoded Modern App. 
        </div>
    </footer>
</body>
</html>