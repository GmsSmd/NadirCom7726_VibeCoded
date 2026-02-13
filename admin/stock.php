<?php
// Modernized stock.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\InventoryService;
use App\Core\Database;

$inventoryService = new InventoryService();
$db = Database::getInstance();

$pNameHere = $_GET['for'] ?? 'Otar';
$filters = [
    'startDate' => $_POST['txtDateFrom'] ?? date('Y-m-01'),
    'endDate' => $_POST['txtDateTo'] ?? date('Y-m-d'),
    'employee' => $_POST['EmpSelect'] ?? '---'
];

// Data fetching based on category
$data = [];
if ($pNameHere === 'Otar' || $pNameHere === 'mfs') {
    $data = $inventoryService->getTransactions($pNameHere, $filters);
} else {
    $data = $inventoryService->getStockSummary($pNameHere, $filters['startDate'], $filters['endDate']);
    $collection = $inventoryService->getCollection($pNameHere, $filters['startDate'], $filters['endDate']);
}

// Fetch all product names for the top navigation bar
$productTypesRes = $db->query("SELECT pName FROM products WHERE pName!='Otar' AND pName!='mfs'")->fetchAll();

// Legacy session support
$currentActiveUser = $_SESSION['login_user'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Summary - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans">
    
    <!-- Navbar -->
    <div class="bg-indigo-700 text-white py-2 px-4 shadow-lg mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
             <div class="flex items-center space-x-6">
                 <a href="summary.php" class="font-bold text-lg hover:text-indigo-200 transition">NadirCom Dashboard</a>
                 <nav class="hidden md:flex space-x-4 text-sm font-medium">
                     <a href="dosales.php?name=DO" class="hover:text-indigo-200">Sales</a>
                     <a href="lifting.php" class="hover:text-indigo-200 text-indigo-100">Purchases</a>
                     <a href="stock.php?for=Otar" class="text-white border-b-2 border-white pb-1">Stock</a>
                     <a href="empinfo.php" class="hover:text-indigo-200 text-indigo-100">Personnel</a>
                 </nav>
             </div>
             <div class="flex items-center space-x-4 text-sm">
                 <span class="text-indigo-100">Welcome, <b><?php echo htmlspecialchars($currentActiveUser); ?></b></span>
                 <a href="../logout.php" class="bg-indigo-800 hover:bg-indigo-900 px-3 py-1 rounded transition line-clamp-1">Logout</a>
             </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Stock Inventory</h1>
            <p class="mt-2 text-slate-500">Comprehensive summary of assets, transactions, and stock levels.</p>
        </div>

        <!-- Category Toggle -->
        <div class="flex flex-wrap items-center gap-2 mb-8 p-1 bg-slate-200/50 rounded-2xl w-fit">
            <a href="stock.php?for=Otar" class="px-6 py-2.5 rounded-xl text-sm font-bold transition <?php echo $pNameHere === 'Otar' ? 'bg-white text-indigo-700 shadow-md' : 'text-slate-600 hover:bg-slate-200'; ?>">Otar</a>
            <a href="stock.php?for=mfs" class="px-6 py-2.5 rounded-xl text-sm font-bold transition <?php echo $pNameHere === 'mfs' ? 'bg-white text-indigo-700 shadow-md' : 'text-slate-600 hover:bg-slate-200'; ?>">MFS</a>
            <?php foreach ($productTypesRes as $pt): ?>
                <a href="stock.php?for=<?php echo urlencode($pt['pName']); ?>" class="px-6 py-2.5 rounded-xl text-sm font-bold transition <?php echo $pNameHere === $pt['pName'] ? 'bg-white text-indigo-700 shadow-md' : 'text-slate-600 hover:bg-slate-200'; ?>">
                    <?php echo htmlspecialchars($pt['pName']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Filters (Context Dependent) -->
        <form method="POST" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 mb-8 flex flex-wrap items-end gap-6">
            <?php if ($pNameHere === 'Otar' || $pNameHere === 'mfs'): ?>
                <div class="w-full md:w-auto min-w-[200px]">
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Filter by Personnel</label>
                    <select name="EmpSelect" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-2.5 font-medium">
                        <option value="---">All Employees</option>
                        <?php
                            $employees = $db->query("SELECT EmpName FROM empinfo ORDER BY EmpName ASC")->fetchAll();
                            foreach ($employees as $emp) {
                                $sel = ($emp['EmpName'] == $filters['employee']) ? 'selected' : '';
                                echo "<option $sel>" . htmlspecialchars($emp['EmpName']) . "</option>";
                            }
                        ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <div class="flex gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Date From</label>
                    <input type="date" name="txtDateFrom" value="<?php echo $filters['startDate']; ?>" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-2.5 font-medium">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Date To</label>
                    <input type="date" name="txtDateTo" value="<?php echo $filters['endDate']; ?>" class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-2.5 font-medium">
                </div>
            </div>
            
            <button type="submit" name="<?php echo ($pNameHere === 'Otar' || $pNameHere === 'mfs') ? "Show{$pNameHere}Sales" : 'Showstock'; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-xl font-bold text-sm transition shadow-indigo-100 shadow-xl ml-auto">
                Generate View
            </button>
        </form>

        <!-- Data Visualization / Tables -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-slate-200">
            <?php if ($pNameHere === 'Otar' || $pNameHere === 'mfs'): ?>
                <!-- Transaction Style View -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50/80">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Transaction Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Employee / Channel</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Value (PKR)</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Reference / Comments</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php 
                            $totalValue = 0;
                            if (empty($data)): 
                            ?>
                                <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50/20 font-inter">No transactions recorded for this period.</td></tr>
                            <?php else: ?>
                                <?php foreach ($data as $row): 
                                    $date = $pNameHere === 'Otar' ? $row['loadDate'] : $row['mfsDate'];
                                    $emp = $pNameHere === 'Otar' ? $row['loadEmp'] : $row['mfsEmp'];
                                    $amnt = $pNameHere === 'Otar' ? $row['loadAmnt'] : $row['mfsAmnt'];
                                    $cmnts = $pNameHere === 'Otar' ? $row['loadComments'] : $row['mfsComments'];
                                    $id = $pNameHere === 'Otar' ? $row['loadID'] : $row['mfsID'];
                                    $totalValue += $amnt;
                                ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-slate-600"><?php echo date("d M Y", strtotime($date)); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-slate-900"><?php echo htmlspecialchars($emp); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-black font-mono text-indigo-700">Rs. <?php echo number_format($amnt); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-500 italic"><?php echo htmlspecialchars($cmnts); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <a href="delete/delsalesummary.php?ID=<?php echo $id; ?>&for=<?php echo $pNameHere; ?>" class="text-rose-600 hover:text-rose-800 font-bold text-xs ring-1 ring-rose-100 px-3 py-1 rounded-full transition" onclick="return confirm('Delete this record?')">Remove</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($data)): ?>
                        <tfoot class="bg-slate-900 text-white border-t-2 border-slate-700">
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm font-black uppercase tracking-widest text-right">Aggregated Total</td>
                                <td class="px-6 py-4 text-right font-black text-amber-400 text-lg font-mono tracking-tight">Rs. <?php echo number_format($totalValue); ?></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            <?php else: ?>
                <!-- Stock Summary Style View -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50/80">
                                <th rowspan="2" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Product Variant</th>
                                <th colspan="2" class="px-6 py-3 text-center text-[10px] font-black text-indigo-400 uppercase border-l border-slate-100 tracking-[0.2em] bg-indigo-50/20">Opening Balance</th>
                                <th colspan="2" class="px-6 py-3 text-center text-[10px] font-black text-emerald-400 uppercase border-l border-slate-100 tracking-[0.2em] bg-emerald-50/20">Period Lifting</th>
                                <th colspan="2" class="px-6 py-3 text-center text-[10px] font-black text-rose-400 uppercase border-l border-slate-100 tracking-[0.2em] bg-rose-50/20">Period Sales</th>
                                <th colspan="2" class="px-6 py-3 text-center text-[10px] font-black text-indigo-900 uppercase border-l border-slate-100 tracking-[0.2em] bg-slate-100/50">Ending Inventory</th>
                            </tr>
                            <tr class="bg-slate-50/30 text-[10px] font-bold text-slate-400">
                                <th class="px-6 py-2 border-l border-slate-100">Qty</th><th class="px-6 py-2">Val</th>
                                <th class="px-6 py-2 border-l border-slate-100">Qty</th><th class="px-6 py-2">Val</th>
                                <th class="px-6 py-2 border-l border-slate-100">Qty</th><th class="px-6 py-2 text-right">Avg Val</th>
                                <th class="px-6 py-3 border-l border-slate-100 bg-slate-100 text-indigo-900">Qty</th><th class="px-6 py-3 bg-slate-100 text-indigo-900 text-right">Asset Val</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php 
                            $totals = [
                                'opQty' => 0, 'opVal' => 0,
                                'pQty' => 0, 'pVal' => 0,
                                'sQty' => 0, 'sVal' => 0,
                                'cQty' => 0, 'cVal' => 0
                            ];
                            foreach ($data as $row): 
                                $totals['opQty'] += $row['opening']['qty'];
                                $totals['opVal'] += $row['opening']['amount'];
                                $totals['pQty'] += $row['purchase']['qty'];
                                $totals['pVal'] += $row['purchase']['amount'];
                                $totals['sQty'] += $row['sale']['qty'];
                                $totals['sVal'] += $row['sale']['amount'];
                                $totals['cQty'] += $row['closing']['qty'];
                                $totals['cVal'] += $row['closing']['amount'];
                            ?>
                                <tr class="hover:bg-indigo-50/30 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 bg-slate-50/50 ring-1 ring-inset ring-slate-100"><?php echo htmlspecialchars($row['type']); ?></td>
                                    <td class="px-6 py-4 text-center text-sm font-medium border-l border-slate-50"><?php echo number_format($row['opening']['qty']); ?></td>
                                    <td class="px-6 py-4 text-xs text-slate-400 font-mono"><?php echo number_format($row['opening']['amount']); ?></td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-emerald-600 border-l border-emerald-50"><?php echo number_format($row['purchase']['qty']); ?></td>
                                    <td class="px-6 py-4 text-xs text-slate-400 font-mono"><?php echo number_format($row['purchase']['amount']); ?></td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-rose-600 border-l border-rose-50"><?php echo number_format($row['sale']['qty']); ?></td>
                                    <td class="px-6 py-4 text-right text-xs text-slate-400 font-mono font-inter"><?php echo number_format($row['sale']['amount']); ?></td>
                                    <td class="px-6 py-4 text-center text-sm font-black text-indigo-900 bg-indigo-50/50 border-l border-slate-200"><?php echo number_format($row['closing']['qty']); ?></td>
                                    <td class="px-6 py-4 text-right text-sm font-black text-slate-700 bg-indigo-50/50 font-mono italic">Rs. <?php echo number_format($row['closing']['amount']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-indigo-950 text-white font-mono text-[11px] font-bold">
                            <tr>
                                <td class="px-6 py-5 text-xs font-black uppercase tracking-widest bg-indigo-900 border-r border-indigo-800">Grand Portfolio Total</td>
                                <td class="px-6 py-5 text-center"><?php echo number_format($totals['opQty']); ?></td>
                                <td class="px-6 py-5 text-slate-400"><?php echo number_format($totals['opVal']); ?></td>
                                <td class="px-6 py-5 text-center text-emerald-400"><?php echo number_format($totals['pQty']); ?></td>
                                <td class="px-6 py-5 text-slate-400"><?php echo number_format($totals['pVal']); ?></td>
                                <td class="px-6 py-5 text-center text-rose-400"><?php echo number_format($totals['sQty']); ?></td>
                                <td class="px-6 py-5 text-right text-slate-400"><?php echo number_format($totals['sVal']); ?></td>
                                <td class="px-6 py-5 text-center text-indigo-200 bg-indigo-900/50"><?php echo number_format($totals['cQty']); ?></td>
                                <td class="px-6 py-5 text-right text-amber-400 text-sm font-black bg-indigo-900/50">Rs. <?php echo number_format($totals['cVal']); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!($pNameHere === 'Otar' || $pNameHere === 'mfs')): ?>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-emerald-600 p-8 rounded-[2rem] text-white shadow-xl flex items-center justify-between overflow-hidden relative group">
                <div class="relative z-10">
                    <p class="text-emerald-100 text-xs font-black uppercase tracking-widest mb-1">Portfolio Collection</p>
                    <h3 class="text-3xl font-black tracking-tight">Rs. <?php echo number_format($collection); ?></h3>
                    <p class="text-emerald-200 text-xs mt-3 flex items-center font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Incoming cash for <?php echo htmlspecialchars($pNameHere); ?>
                    </p>
                </div>
                <div class="text-emerald-500 absolute -right-4 -bottom-4 transform group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.82v-1.91c-1.84-.18-3.41-1.12-4.14-2.58l1.46-.6c.55 1.15 1.83 1.88 3.09 1.88 1.41 0 2.21-.73 2.21-1.63 0-.91-.77-1.44-2.51-2.06-2.12-.76-3.8-1.57-3.8-3.92 0-2.16 1.44-3.52 3.69-3.81V4h2.82v1.92c1.78.23 3.01 1.25 3.5 2.54l-1.45.61c-.34-.97-1.41-1.63-2.52-1.63-1.15 0-2.11.66-2.11 1.58 0 .86.73 1.34 2.5 1.94 2.37.8 4.07 1.77 4.07 4.22.01 2.54-1.74 3.73-3.95 3.91z"></path></svg>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>
</body>
</html>