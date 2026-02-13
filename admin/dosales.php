<?php
// Modernized dosales.php
session_start();
require_once __DIR__ . '/../config.php'; // Include global config (which includes src/autoload.php)
// If config.php is not used, use this:
// require_once __DIR__ . '/../src/autoload.php';

// Authentication Check (from legacy session.php)
if(!isset($_SESSION['login_user'])){
    header("location: ../login.php");
    exit();
}

Use App\Services\SalesService;
Use App\Services\LoadService;

// Initialize Services
$salesService = new SalesService();
$loadService = new LoadService();

// Handle Legacy Includes for variables and form processing
// We keep this temporarily to handle the POST logic without rewriting it all immediately.
// Note: doformula.php relies on global $con, so we need to ensure it's available or mocked if we want to remove it.
// For now, let's replicate the necessary global variables.
include_once('includes/dbcon.php'); // Provides $con
include_once('includes/variables.php'); // Provides dates, user info
include_once('includes/globalvar.php'); // Provides helper functions
include_once('includes/doformula.php'); // Processes POST requests

// Get Current Employee
$employeeName = mysqli_real_escape_string($con, $_GET['name'] ?? '');
if (empty($employeeName)) {
    // Default or Error
    $employeeName = 'Select DO';
}

$lineNumber = mysqli_real_escape_string($con, $_GET['num'] ?? '');

// Calculate Date Range (from globalvar/variables logic)
// $date_from and $date_to are set in variables.php
// $QueryFD, $QueryLD, $CurrentMonth, $dateNow are also set there.

// Fetch Data for the Report
$reportData = [];
$totals = [
    'load' => 0, 'transfer' => 0, 'profit' => 0,
    'mfsSend' => 0, 'mfsReceive' => 0, 'mfsClose' => 0,
    'taken' => 0, 'receivable' => 0, 'closing' => 0,
    'cardReceivables' => 0, 'mobileClose' => 0, 'simClose' => 0
];

// Initial Opening Balances
$openingCash = $salesService->getOpeningBalance($employeeName, $CurrentMonth, 'Cash');
$openingCard = $salesService->getOpeningBalance($employeeName, $CurrentMonth, 'Card');
$openingMobile = $salesService->getOpeningBalance($employeeName, $CurrentMonth, 'Mobile');
$openingSIM = $salesService->getOpeningBalance($employeeName, $CurrentMonth, 'SIM');

$currentOpening = $openingCash;
$currentOpeningCard = $openingCard;

// Loop through days
for ($i = $date_from; $i <= $date_to; $i += 86400) {
    $currentDate = date("Y-m-d", $i);
    $displayDate = date("d-m-Y", $i);

    // 1. Mobile Load Stats
    $loadStats = $loadService->getLoadStats($employeeName, $currentDate);
    $load = $loadStats['total_load'] ?? 0;
    $transfer = $loadStats['total_transfer'] ?? 0;
    $profit = ($loadStats['total_profit'] ?? 0) + ($loadStats['total_excess_profit'] ?? 0);

    // 2. MFS Stats
    $mfsStats = $salesService->getMfsStats($employeeName, $currentDate);
    $mfsSend = $mfsStats['sent'];
    $mfsReceive = $mfsStats['received'];
    $mfsClose = $mfsStats['close'];

    // 3. Card Stats (Profit/Loss not shown in table body but used in logic)
    $cardStats = $salesService->getCardStats($employeeName, $currentDate);
    $cardTotalAmount = $cardStats['total_amount'] ?? 0;

    // 4. Receivables Calculation
    $receivable = $currentOpening + $load + $mfsClose;
    $cardReceivable = $currentOpeningCard + $cardTotalAmount;

    // 5. Payments Received (Taken)
    $takenLMC = $salesService->getReceivedPayments($employeeName, $currentDate, 'LMC');
    $takenCard = $salesService->getReceivedPayments($employeeName, $currentDate, 'Card');
    
    // 6. Dues (Closing for the day)
    $dues = $receivable - $takenLMC;
    $cardReceivable -= $takenCard;

    // 7. Store Data
    $reportData[] = [
        'date' => $displayDate,
        'load' => $load,
        'transfer' => $transfer,
        'profit' => $profit,
        'mfsSend' => $mfsSend,
        'mfsReceive' => $mfsReceive,
        'opening' => $currentOpening,
        'receivable' => $receivable,
        'taken' => $takenLMC,
        'dues' => $dues,
        'cardReceivable' => $cardReceivable
    ];

    // Aggregate Totals
    $totals['load'] += $load;
    $totals['transfer'] += $transfer;
    $totals['profit'] += $profit;
    $totals['mfsSend'] += $mfsSend;
    $totals['mfsReceive'] += $mfsReceive;
    $totals['taken'] += $takenLMC;

    // Set Opening for next day
    $currentOpening = $dues;
    $currentOpeningCard = $cardReceivable;
}

// Final Closing Calculations for Mobile and SIM
// Mobile
$sumMobileSales = $salesService->getProductSalesSum($employeeName, $QueryFD, $CurrentDate, 'Mobile');
$takenMobile = $salesService->getReceivedPaymentsRange($employeeName, $QueryFD, $CurrentDate, 'mobile');
$mobileClose = ($openingMobile + $sumMobileSales) - $takenMobile;

// SIM
$sumSIMSales = $salesService->getProductSalesSum($employeeName, $QueryFD, $CurrentDate, 'SIM');
$takenSIM = $salesService->getReceivedPaymentsRange($employeeName, $QueryFD, $CurrentDate, 'SIM');
$simClose = ($openingSIM + $sumSIMSales) - $takenSIM;

// Final Card Closing
// Logic in dosales.php seems to use the running total result
$finalCardClose = $currentOpeningCard;

// Profitability (Admin Only)
$showProfitability = ($currentUserType == 'Admin');
if ($showProfitability) {
    $mobileProfit = $salesService->getProductProfitLoss($employeeName, 'Mobile', $QueryFD, $CurrentDate);
    $simProfit = $salesService->getProductProfitLoss($employeeName, 'SIM', $QueryFD, $CurrentDate);
    
    // Card Profit needs to be calculated similarly or summed from daily stats
    // dosales.php sums sumProLoss from query.
    // I should add this efficiently.
    // Ideally, I'd query the range sum directly.
    $sqlCardProfit = "SELECT sum(csProLoss) as pl FROM tbl_cards WHERE csStatus='Sent' AND csEmp='$employeeName' AND csDate BETWEEN '$QueryFD' AND '$CurrentDate'";
    $resCardPl = mysqli_query($con, $sqlCardProfit); // Using raw query for speed/legacy match
    $cardProfit = mysqli_fetch_assoc($resCardPl)['pl'] ?? 0;

    $netProfit = $totals['profit'] + $cardProfit + $mobileProfit + $simProfit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Sheet - <?php echo htmlspecialchars($employeeName); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar for table */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans">
    
    <!-- Navbar Component -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                         <span class="font-bold text-xl text-indigo-600">NadirCom</span>
                    </div>
                </div>
                <!-- Legacy Navbar Include (might need styling adjustments) -->
                 <div class="hidden md:flex items-center space-x-4">
                    <a href="../admin/summary.php" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Summary</a>
                    <a href="../admin/dosales.php?name=DO" class="text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Sales</a>
                    <a href="../logout.php" class="text-red-500 hover:text-red-700 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                 </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                <?php echo htmlspecialchars($employeeName); ?>'s Sales Sheet
            </h1>
            <div class="mt-4 md:mt-0 flex space-x-2 overflow-x-auto pb-2">
                <?php
                $activeEmployees = $salesService->getActiveEmployees();
                foreach($activeEmployees as $emp) {
                    $isActive = ($emp['EmpName'] == $employeeName) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
                    echo '<a href="dosales.php?name='.urlencode($emp['EmpName']).'&num='.urlencode($emp['doLine']).'" 
                             class="px-4 py-2 rounded-full shadow-sm text-sm font-semibold transition-colors duration-200 border border-gray-200 ' . $isActive . '">
                             '.htmlspecialchars($emp['EmpName']).'
                          </a>';
                }
                ?>
            </div>
        </div>

        <!-- Action Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Load + Payment Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 border-b pb-2">Load + Payment</h3>
                    <form action="" method="POST" class="space-y-4">
                        <input type="hidden" name="txtDate" value="<?php echo date('Y-m-d'); ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Load Amount</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="txtLoad" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-300 p-2 border" placeholder="0.00">
                                <button type="submit" name="AddLoad" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Send
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cash Receive</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="txtAmnTaken" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-300 p-2 border" placeholder="Amount">
                                <select name="modeSelect" class="focus:ring-indigo-500 focus:border-indigo-500 block w-24 sm:text-sm border-gray-300 border-t border-b border-gray-300 bg-white">
                                    <option>---</option>
                                    <?php
                                    $bankQ = mysqli_query($con, "SELECT modeName from rpmode");
                                    while($row = mysqli_fetch_assoc($bankQ)) {
                                        $selected = ($row['modeName'] == $defaultBankName) ? 'selected' : '';
                                        echo "<option $selected>{$row['modeName']}</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" name="AmntReceive" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-green-600 hover:bg-green-700">
                                    Receive
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MFS Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 border-b pb-2">MFS (Jazz/EasyPaisa)</h3>
                    <form action="" method="POST" class="space-y-4">
                        <input type="hidden" name="txtDate" value="<?php echo date('Y-m-d'); ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Send Money</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="txtmfsSend" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-300 p-2 border" placeholder="Amount">
                                <button type="submit" name="Addmfs" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Send
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Receive Money</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="txtmfsReceive" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-300 p-2 border" placeholder="Amount">
                                <button type="submit" name="Recmfs" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-green-600 hover:bg-green-700">
                                    Get
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cards Management -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="px-4 py-5 sm:p-6">
                     <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 border-b pb-2">Scratch Cards</h3>
                     <form action="" method="POST" class="space-y-2">
                        <input type="hidden" name="txtDate" value="<?php echo date('Y-m-d'); ?>">
                        
                        <select name="SubCselect" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                            <?php
                            $typeQ = mysqli_query($con, "SELECT typeName from types WHERE productName='Card' AND isActive=1");
                            while($row = mysqli_fetch_assoc($typeQ)) {
                                echo "<option>{$row['typeName']}</option>";
                            }
                            ?>
                        </select>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="txtCQty" placeholder="Qty" class="block w-full rounded-md border-gray-300 border p-2 text-sm">
                            <input type="text" name="txtCSaleRate" placeholder="Rate" class="block w-full rounded-md border-gray-300 border p-2 text-sm">
                        </div>

                        <div class="pt-2 border-t mt-2">
                            <label class="text-xs text-gray-500">Payment (Optional)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="txtCardAmntRec" placeholder="Amount" class="block w-full rounded-md border-gray-300 border p-2 text-sm">
                                <select name="modeSelect1" class="block w-full rounded-md border-gray-300 border p-2 text-sm">
                                    <option>---</option>
                                    <?php
                                    $bankQ = mysqli_query($con, "SELECT modeName from rpmode");
                                    while($row = mysqli_fetch_assoc($bankQ)) {
                                         echo "<option>".htmlspecialchars($row['modeName'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <button type="submit" name="AddCQty" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Process Card Sale
                        </button>
                     </form>
                </div>
            </div>

            <!-- Profitability (Admin Only) -->
            <?php if ($showProfitability): ?>
            <div class="bg-indigo-50 overflow-hidden shadow-lg rounded-xl border border-indigo-100 card-gradient">
                <div class="px-4 py-5 sm:p-6 opacity-90">
                    <h3 class="text-lg leading-6 font-bold text-indigo-900 mb-4 border-b border-indigo-200 pb-2">Profitability</h3>
                    <div class="space-y-2 text-indigo-800">
                        <div class="flex justify-between"><span>Load Profit:</span> <span class="font-semibold"><?php echo number_format($totals['profit'], 2); ?></span></div>
                        <div class="flex justify-between"><span>Card Profit:</span> <span class="font-semibold"><?php echo number_format($cardProfit, 2); ?></span></div>
                        <div class="flex justify-between"><span>Device Profit:</span> <span class="font-semibold"><?php echo number_format($mobileProfit, 2); ?></span></div>
                        <div class="flex justify-between"><span>SIM Profit:</span> <span class="font-semibold"><?php echo number_format($simProfit, 2); ?></span></div>
                        <div class="border-t border-indigo-300 pt-2 mt-2 flex justify-between text-lg font-bold">
                            <span>NET:</span> <span><?php echo number_format($netProfit, 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Data Table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Load</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Transfer</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MFS Sent</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MFS Get</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Opening</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Receivable</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">Takens</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Dues</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-green-700 uppercase tracking-wider hidden lg:table-cell">Card Dues</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($reportData as $row): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo $row['date']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $row['load']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell"><?php echo $row['transfer']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo $row['mfsSend']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo $row['mfsReceive']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-400 text-right hidden md:table-cell"><?php echo $row['opening']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700 text-right"><?php echo $row['receivable']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-bold text-green-600 text-right"><?php echo $row['taken']; ?></td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-bold <?php echo ($row['dues'] > 0) ? 'text-red-600' : 'text-gray-900'; ?> text-right">
                                        <?php echo $row['dues']; ?>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-right text-green-800 hidden lg:table-cell"><?php echo $row['cardReceivable']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-gray-100">
                                <tr class="font-bold text-sm">
                                    <td class="px-3 py-3">TOTAL</td>
                                    <td class="px-3 py-3"><?php echo $totals['load']; ?></td>
                                    <td class="px-3 py-3 hidden sm:table-cell"><?php echo $totals['transfer']; ?></td>
                                    <td class="px-3 py-3"><?php echo $totals['mfsSend']; ?></td>
                                    <td class="px-3 py-3"><?php echo $totals['mfsReceive']; ?></td>
                                    <td class="px-3 py-3 text-right hidden md:table-cell"><?php echo $reportData[0]['opening'] ?? 0; ?></td>
                                    <td class="px-3 py-3 text-right"><?php echo array_sum(array_column($reportData, 'receivable')); // Sum of receivables is weird conceptually, maybe last day? dosales uses sum. ?></td>
                                    <td class="px-3 py-3 text-right text-green-700"><?php echo $totals['taken']; ?></td>
                                    <td class="px-3 py-3 text-right"><?php echo $currentOpening; // Final Closing ?></td>
                                    <td class="px-3 py-3 text-right text-green-900 hidden lg:table-cell"><?php echo $finalCardClose; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-sm">
            &copy; <?php echo date('Y'); ?> VibeCoded Modern App. 
        </div>
    </footer>

</body>
</html>