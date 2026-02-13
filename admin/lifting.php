<?php
// Modernized lifting.php
session_start();
require_once __DIR__ . '/../config.php';

// Authentication Check
if (!isset($_SESSION['login_user'])) {
    header("location: ../login.php");
    exit();
}

use App\Services\PurchaseService;

$service = new PurchaseService();
$currentUser = $_SESSION['login_user'];
$dateNow = date('Y-m-d');

// Handle Form Submissions
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['txtDate'] ?? $dateNow;
    $notes = $_POST['txtNotes'] ?? '';
    
    try {
        // 1. LOAD
        if (isset($_POST['SaveSendliftingLoad'])) // Cash
            $service->addLoad($date, $_POST['txtAmntReceived'], $notes, 'Cash', $currentUser);
        elseif (isset($_POST['LoadFromMfs'])) // Debit MFS
            $service->addLoad($date, $_POST['txtAmntReceived'], $notes, 'Debit MFS', $currentUser);
        elseif (isset($_POST['SaveliftingLoad'])) // Credit
            $service->addLoad($date, $_POST['txtAmntReceived'], $notes, 'Credit', $currentUser);

        // 2. MFS (Purchase/Refill)
        elseif (isset($_POST['SaveSendliftingmfs'])) // Cash
            $service->addMfs($date, $_POST['txtAmntReceived'], $notes, 'Cash', $currentUser);
        elseif (isset($_POST['Saveliftingmfs'])) // Credit
            $service->addMfs($date, $_POST['txtAmntReceived'], $notes, 'Credit', $currentUser);

        // 3. MFS (Debit/Send)
        elseif (isset($_POST['DebitMFS']))
            $service->debitMfs($date, $_POST['txtAmntReceived'], $notes, $currentUser);

        // 4. CARDS
        elseif (isset($_POST['SaveSendliftingCard'])) // Cash
            $service->addCards($date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Cash', $currentUser);
        elseif (isset($_POST['SaveliftingCard'])) // Credit
            $service->addCards($date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Credit', $currentUser);

        // 5. SIMS
        elseif (isset($_POST['SaveSendliftingSIM'])) // Cash
            $service->addProductStock('SIM', $date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Cash', $currentUser);
        elseif (isset($_POST['SaveliftingSIM'])) // Credit
            $service->addProductStock('SIM', $date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Credit', $currentUser);

        // 6. PHONES
        elseif (isset($_POST['SaveSendliftingPhone'])) // Cash
            $service->addProductStock('Mobile', $date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Cash', $currentUser);
        elseif (isset($_POST['SaveliftingPhone'])) // Credit
            $service->addProductStock('Mobile', $date, $_POST['SubPselect'], $_POST['txtAmntReceived'], $notes, 'Credit', $currentUser);

        $message = "Transaction recorded successfully.";
        $messageType = "success";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "error";
    }
}

// Fetch Daily Data
$loads = $service->getDailyLoad($dateNow);
$mfsReceived = $service->getDailyMfsReceived($dateNow);
$mfsSent = $service->getDailyMfsSent($dateNow);
$cards = $service->getDailyCards($dateNow);
$sims = $service->getDailyProduct($dateNow, 'SIM');
$mobiles = $service->getDailyProduct($dateNow, 'Mobile');

// Fetch Types
$cardTypes = $service->getSubTypes('Card');
$simTypes = $service->getSubTypes('SIM');
$mobileTypes = $service->getSubTypes('Mobile');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase & Stock (Lifting)</title>
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

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Purchase & Stock (Lifting)</h1>

        <!-- LOAD & MFS Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <!-- Load Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-indigo-500">
                <h2 class="text-lg font-bold text-indigo-700 mb-4">Purchase Load</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <input type="number" step="any" name="txtAmntReceived" placeholder="Amount" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="SaveSendliftingLoad" class="flex-1 bg-green-600 text-white py-2 rounded shadow hover:bg-green-700 text-sm font-medium">Cash</button>
                        <button type="submit" name="LoadFromMfs" class="flex-1 bg-yellow-600 text-white py-2 rounded shadow hover:bg-yellow-700 text-sm font-medium">Debit MFS</button>
                        <button type="submit" name="SaveliftingLoad" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 text-sm font-medium">Credit</button>
                    </div>
                </form>
                
                <!-- Mini Table -->
                <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's Load</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Amnt</th><th class="px-2 py-1">Type</th></tr></thead>
                            <tbody>
                                <?php foreach($loads as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['loadAmnt']; ?></td>
                                    <td class="px-2 py-1 text-xs text-gray-500"><?php echo $row['purchaseType']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MFS Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-emerald-500">
                <h2 class="text-lg font-bold text-emerald-700 mb-4">Purchase MFS (Refill)</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <input type="number" step="any" name="txtAmntReceived" placeholder="Amount" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="SaveSendliftingmfs" class="flex-1 bg-green-600 text-white py-2 rounded shadow hover:bg-green-700 text-sm font-medium">Cash</button>
                        <button type="submit" name="Saveliftingmfs" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 text-sm font-medium">Credit</button>
                    </div>
                </form>

                <!-- Mini Table -->
                <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's MFS Received</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Amnt</th><th class="px-2 py-1">Type</th></tr></thead>
                            <tbody>
                                <?php foreach($mfsReceived as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['mfsAmnt']; ?></td>
                                    <td class="px-2 py-1 text-xs text-gray-500"><?php echo $row['purchaseType']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARDS & DEBIT MFS Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <!-- Cards Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-500">
                <h2 class="text-lg font-bold text-purple-700 mb-4">Purchase Cards</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <select name="SubPselect" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                         <?php foreach($cardTypes as $t) echo "<option>".$t['typeName']."</option>"; ?>
                    </select>
                    <input type="number" name="txtAmntReceived" placeholder="Quantity" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="SaveSendliftingCard" class="flex-1 bg-green-600 text-white py-2 rounded shadow hover:bg-green-700 text-sm font-medium">Cash</button>
                        <button type="submit" name="SaveliftingCard" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 text-sm font-medium">Credit</button>
                    </div>
                </form>

                 <!-- Mini Table -->
                 <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's Cards</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Type</th><th class="px-2 py-1">Qty</th><th class="px-2 py-1">Mode</th></tr></thead>
                            <tbody>
                                <?php foreach($cards as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['csType']; ?></td>
                                    <td class="px-2 py-1"><?php echo $row['csQty']; ?></td>
                                    <td class="px-2 py-1 text-xs text-gray-500"><?php echo $row['purchaseType']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Debit MFS Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-500">
                <h2 class="text-lg font-bold text-red-700 mb-4">Debit MFS (Send)</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <input type="number" step="any" name="txtAmntReceived" placeholder="Amount" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="DebitMFS" class="w-full bg-red-600 text-white py-2 rounded shadow hover:bg-red-700 text-sm font-medium">Debit</button>
                    </div>
                </form>

                 <!-- Mini Table -->
                 <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's MFS Sent</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Amnt</th><th class="px-2 py-1">Notes</th></tr></thead>
                            <tbody>
                                <?php foreach($mfsSent as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['mfsAmnt']; ?></td>
                                    <td class="px-2 py-1 text-xs text-gray-500"><?php echo $row['mfsComments']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIMS & PHONES Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <!-- SIMs Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-orange-500">
                <h2 class="text-lg font-bold text-orange-700 mb-4">Purchase SIMs</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <select name="SubPselect" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                         <?php foreach($simTypes as $t) echo "<option>".$t['typeName']."</option>"; ?>
                    </select>
                    <input type="number" name="txtAmntReceived" placeholder="Quantity" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="SaveSendliftingSIM" class="flex-1 bg-green-600 text-white py-2 rounded shadow hover:bg-green-700 text-sm font-medium">Cash</button>
                        <button type="submit" name="SaveliftingSIM" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 text-sm font-medium">Credit</button>
                    </div>
                </form>
                
                 <!-- Mini Table -->
                 <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's SIMs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Type</th><th class="px-2 py-1">Qty</th></tr></thead>
                            <tbody>
                                <?php foreach($sims as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['pSubType']; ?></td>
                                    <td class="px-2 py-1"><?php echo $row['qty']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Phones Section -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-pink-500">
                <h2 class="text-lg font-bold text-pink-700 mb-4">Purchase Phones</h2>
                <form method="POST" class="space-y-3">
                    <input type="date" name="txtDate" value="<?php echo $dateNow; ?>" class="block w-full rounded border-gray-300 shadow-sm p-2 bg-gray-50 text-sm">
                    <select name="SubPselect" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                         <?php foreach($mobileTypes as $t) echo "<option>".$t['typeName']."</option>"; ?>
                    </select>
                    <input type="number" name="txtAmntReceived" placeholder="Quantity" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm" required>
                    <input type="text" name="txtNotes" placeholder="Comments" class="block w-full rounded border-gray-300 shadow-sm p-2 text-sm">
                    <div class="flex space-x-2 pt-2">
                        <button type="submit" name="SaveSendliftingPhone" class="flex-1 bg-green-600 text-white py-2 rounded shadow hover:bg-green-700 text-sm font-medium">Cash</button>
                        <button type="submit" name="SaveliftingPhone" class="flex-1 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 text-sm font-medium">Credit</button>
                    </div>
                </form>

                 <!-- Mini Table -->
                 <div class="mt-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Today's Phones</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100"><tr><th class="px-2 py-1">Type</th><th class="px-2 py-1">Qty</th></tr></thead>
                            <tbody>
                                <?php foreach($mobiles as $row): ?>
                                <tr>
                                    <td class="px-2 py-1"><?php echo $row['pSubType']; ?></td>
                                    <td class="px-2 py-1"><?php echo $row['qty']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
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