<?php
// Modernized salesummary.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\InventoryService;
use App\Core\Database;

$inventoryService = new InventoryService();
$db = Database::getInstance();

$pNameHere = $_GET['for'] ?? 'Otar';
$filters = [
    'startDate' => $_POST['txtDateFrom'] ?? date('Y-m-d'),
    'endDate' => $_POST['txtDateTo'] ?? date('Y-m-d'),
    'employee' => $_POST['EmpSelect'] ?? '---',
    'subType' => $_POST['SubPselect'] ?? '---'
];

// Data fetching
$transactions = [];
if ($pNameHere === 'Otar' || $pNameHere === 'mfs') {
    $transactions = $inventoryService->getTransactions($pNameHere, $filters);
} else {
    $transactions = $inventoryService->getDetailedSales($pNameHere, $filters['startDate'], $filters['endDate'], $filters['employee'], $filters['subType']);
}

// Fetch all product names for the top navigation bar
$productTypesRes = $db->query("SELECT pName FROM products")->fetchAll();

// Legacy session support
$currentActiveUser = $_SESSION['login_user'] ?? '';
$currentUserType = $_SESSION['login_type'] ?? '';
$isMonthLocked = false; // Legacy check placeholder
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Summary - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-indigo-50/30 text-slate-900 antialiased">
    
    <!-- Navbar -->
    <div class="bg-indigo-700 text-white py-2 px-4 shadow-lg mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
             <div class="flex items-center space-x-6">
                 <a href="summary.php" class="font-bold text-lg hover:text-indigo-200 transition">NadirCom Dashboard</a>
                 <nav class="hidden md:flex space-x-4 text-sm font-medium">
                     <a href="dosales.php?name=DO" class="hover:text-indigo-200">Sales</a>
                     <a href="salesummary.php?for=Otar" class="text-white border-b-2 border-white pb-1">Summary</a>
                     <a href="stock.php?for=Otar" class="hover:text-indigo-200 text-indigo-100">Stock</a>
                 </nav>
             </div>
             <div class="flex items-center space-x-4 text-sm">
                 <span class="text-indigo-100">Welcome, <b><?php echo htmlspecialchars($currentActiveUser); ?></b></span>
                 <a href="../logout.php" class="bg-indigo-800 hover:bg-indigo-900 px-3 py-1 rounded transition line-clamp-1">Logout</a>
             </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Sales Intelligence</h1>
                <p class="mt-2 text-slate-500 font-medium">Granular transaction logs and performance metrics.</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-black uppercase text-indigo-400 tracking-[0.2em]">Context</span>
                <p class="text-sm font-bold text-indigo-900"><?php echo htmlspecialchars($pNameHere); ?> Portfolio</p>
            </div>
        </div>

        <!-- Category Picker -->
        <div class="flex flex-wrap items-center gap-2 mb-10 p-1.5 bg-indigo-100/50 rounded-2xl w-fit">
            <?php foreach ($productTypesRes as $pt): ?>
                <a href="salesummary.php?for=<?php echo urlencode($pt['pName']); ?>" class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition <?php echo $pNameHere === $pt['pName'] ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:bg-indigo-200/50'; ?>">
                    <?php echo htmlspecialchars($pt['pName']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Multi-Filter Board -->
        <form method="POST" class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-indigo-100/20 border border-slate-100 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 items-end">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Filter by Personnel</label>
                    <select name="EmpSelect" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-2xl focus:ring-2 focus:ring-indigo-500 p-3 font-bold">
                        <option value="---">Full Team</option>
                        <?php
                            $employees = $db->query("SELECT EmpName FROM empinfo WHERE EmpStatus='Active' ORDER BY sort_order ASC")->fetchAll();
                            foreach ($employees as $emp) {
                                $sel = ($emp['EmpName'] == $filters['employee']) ? 'selected' : '';
                                echo "<option $sel>" . htmlspecialchars($emp['EmpName']) . "</option>";
                            }
                        ?>
                    </select>
                </div>

                <?php if (!($pNameHere === 'Otar' || $pNameHere === 'mfs')): ?>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Product Variant</label>
                    <select name="SubPselect" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-2xl focus:ring-2 focus:ring-indigo-500 p-3 font-bold">
                        <option value="---">Global Inventory</option>
                        <?php
                            $variants = $db->query("SELECT typeName FROM types WHERE productName=? AND isActive=1", [$pNameHere])->fetchAll();
                            foreach ($variants as $v) {
                                $sel = ($v['typeName'] == $filters['subType']) ? 'selected' : '';
                                echo "<option $sel>" . htmlspecialchars($v['typeName']) . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <?php endif; ?>

                <div class="flex gap-4 lg:col-span-2">
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Period Start</label>
                        <input type="date" name="txtDateFrom" value="<?php echo $filters['startDate']; ?>" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-2xl focus:ring-2 focus:ring-indigo-500 p-3 font-bold">
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Period End</label>
                        <input type="date" name="txtDateTo" value="<?php echo $filters['endDate']; ?>" class="w-full bg-slate-50 border-none text-slate-900 text-sm rounded-2xl focus:ring-2 focus:ring-indigo-500 p-3 font-bold">
                    </div>
                    <button type="submit" name="<?php echo ($pNameHere === 'Otar' || $pNameHere === 'mfs') ? "Show{$pNameHere}Sales" : ($pNameHere === 'Card' ? 'Showtbl_cardss' : "Show{$pNameHere}Sales"); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition shadow-lg shadow-indigo-200">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Insights Grid (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Total Volume</p>
                <p class="text-2xl font-black text-slate-900"><?php echo count($transactions); ?> <span class="text-xs font-bold text-slate-400">Trans.</span></p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Gross Value</p>
                <?php 
                    $grossVal = array_sum(array_map(function($t) use ($pNameHere) {
                        return $pNameHere === 'Otar' ? $t['loadAmnt'] : ($pNameHere === 'mfs' ? $t['mfsAmnt'] : $t['amount']);
                    }, $transactions));
                ?>
                <p class="text-2xl font-black text-indigo-600 font-mono">Rs. <?php echo number_format($grossVal); ?></p>
            </div>
            <div class="bg-emerald-500 p-6 rounded-3xl text-white shadow-lg shadow-emerald-100">
                <p class="text-[10px] font-black text-emerald-100 uppercase tracking-wider mb-1">Total Profit</p>
                <?php 
                    $totalPL = array_sum(array_map(function($t) { return $t['proLoss'] ?? 0; }, $transactions));
                ?>
                <p class="text-2xl font-black font-mono">Rs. <?php echo number_format($totalPL); ?></p>
            </div>
        </div>

        <!-- Transaction Journal -->
        <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Temporal</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Entity / Channel</th>
                            <?php if (!($pNameHere === 'Otar' || $pNameHere === 'mfs')): ?>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Variant</th>
                                <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Units</th>
                            <?php endif; ?>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Gross (PKR)</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Auditor</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50/30">Yield</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black text-rose-500 uppercase tracking-widest">Ctrl</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($transactions)): ?>
                            <tr><td colspan="10" class="px-8 py-20 text-center text-slate-300 font-bold italic h-64">The ledger is silent. Try adjusting your filters.</td></tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): 
                                $date = $pNameHere === 'Otar' ? $t['loadDate'] : ($pNameHere === 'mfs' ? $t['mfsDate'] : ($t['csDate'] ?? $t['sDate']));
                                $ent = $pNameHere === 'Otar' ? $t['loadEmp'] : ($pNameHere === 'mfs' ? $t['mfsEmp'] : ($t['csEmp'] ?? $t['customer']));
                                $val = $pNameHere === 'Otar' ? $t['loadAmnt'] : ($pNameHere === 'mfs' ? $t['mfsAmnt'] : $t['amount']);
                                $id = $pNameHere === 'Otar' ? $t['loadID'] : ($pNameHere === 'mfs' ? $t['mfsID'] : ($t['csID'] ?? $t['sID']));
                                $yield = $t['proLoss'] ?? 0;
                            ?>
                                <tr class="hover:bg-slate-50 transition group">
                                    <td class="px-8 py-5 whitespace-nowrap text-xs font-bold text-slate-500"><?php echo date("d M Y", strtotime($date)); ?></td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm font-black text-slate-900"><?php echo htmlspecialchars($ent); ?></td>
                                    <?php if (!($pNameHere === 'Otar' || $pNameHere === 'mfs')): ?>
                                        <td class="px-8 py-5 whitespace-nowrap text-xs font-bold text-indigo-600 bg-indigo-50/30 rounded-full px-3 inline-block m-4 select-none"><?php echo htmlspecialchars($t['csType'] ?? $t['pSubType']); ?></td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-center font-mono font-bold text-slate-600"><?php echo number_format($t['csQty'] ?? $t['qty']); ?></td>
                                    <?php endif; ?>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm text-right font-black font-mono text-indigo-700 tracking-tighter">Rs. <?php echo number_format($val); ?></td>
                                    <td class="px-8 py-5 whitespace-nowrap text-xs font-medium text-slate-400 italic"><?php echo htmlspecialchars($t['User']); ?></td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm text-right font-bold text-emerald-600 bg-emerald-50/10 font-mono">+<?php echo number_format($yield); ?></td>
                                    <td class="px-8 py-5 whitespace-nowrap text-center">
                                        <?php if ($currentUserType == "Admin" || (date("Y-m-d") == $date)): ?>
                                            <a href="delete/delsalesummary.php?ID=<?php echo $id; ?>&for=<?php echo urlencode($pNameHere); ?>" class="opacity-0 group-hover:opacity-100 bg-rose-50 text-rose-600 text-[10px] font-black uppercase px-4 py-1.5 rounded-xl transition hover:bg-rose-600 hover:text-white" onclick="return confirm('Purge record #<?php echo $id; ?>?')">Purge</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>