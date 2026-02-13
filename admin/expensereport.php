<?php
// Modernized expensereport.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\ExpenseService;
use App\Core\Database;

$expenseService = new ExpenseService();
$db = Database::getInstance();

$currentActiveUser = $_SESSION['login_user'] ?? '';
$currentUserType = $_SESSION['login_type'] ?? '';

// Date Handling
$selectedDate = $_POST['DT'] ?? date('Y-m-d');
$queryFD = date('Y-m-01', strtotime($selectedDate));
$queryLD = date('Y-m-t', strtotime($selectedDate));

// Data Fetching
$expenses = $expenseService->getExpenses($queryFD, $queryLD);
$sum = array_sum(array_column($expenses, 'amnt'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Archive - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">
    
    <!-- Navbar (Integrated simple version) -->
    <header class="bg-white border-b border-slate-200 py-4 px-8 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="summary.php" class="font-black text-xl tracking-tighter text-indigo-600">NadirCom.</a>
                <nav class="hidden md:flex space-x-4">
                    <a href="expenses.php" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition">Current Month</a>
                    <a href="expensereport.php" class="text-sm font-black text-indigo-600 border-b-2 border-indigo-600 pb-1">Archive</a>
                    <a href="petty.php" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition">Petty Cash</a>
                </nav>
            </div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">
                Luminous Internal Systems
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-12">
        <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Fiscal Journal</h1>
                <p class="mt-2 text-slate-500 font-medium">Historical expenditure analysis for <span class="text-indigo-600 font-bold"><?php echo date('F Y', strtotime($selectedDate)); ?></span>.</p>
            </div>
            
            <form method="POST" class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                <input type="date" name="DT" value="<?php echo $selectedDate; ?>" class="bg-slate-50 border-none rounded-xl text-sm font-bold p-3 focus:ring-2 focus:ring-indigo-500 transition">
                <button type="submit" name="showReport" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest text-[10px] px-6 py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                    Query Archive
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-indigo-600 p-8 rounded-3xl text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-1 relative z-10">Period Total</p>
                <p class="text-3xl font-black font-mono tracking-tighter relative z-10">Rs. <?php echo number_format($sum); ?></p>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm col-span-1 md:col-span-3">
                <div class="flex flex-col md:flex-row justify-between items-center h-full gap-8">
                    <div class="text-center md:text-left">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Health Matrix</p>
                        <?php $avg = count($expenses) > 0 ? $sum / count($expenses) : 0; ?>
                        <p class="text-sm font-medium text-slate-600 italic">Average transaction size in this period: <span class="text-slate-900 font-black not-italic">Rs. <?php echo number_format($avg, 2); ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ledger Table -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">
                            <th class="px-8 py-5">Temporal</th>
                            <th class="px-8 py-5">Context / Narrative</th>
                            <th class="px-8 py-5 text-right">Debit (PKR)</th>
                            <th class="px-8 py-5">Auditor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if (empty($expenses)): ?>
                            <tr><td colspan="4" class="px-8 py-32 text-center text-slate-300 font-bold italic h-64">The vault is silent for this period.</td></tr>
                        <?php else: ?>
                            <?php foreach ($expenses as $e): ?>
                                <tr class="hover:bg-indigo-50/30 transition group">
                                    <td class="px-8 py-6 whitespace-nowrap text-xs font-bold text-slate-500 uppercase"><?php echo date('d M Y', strtotime($e['expDate'])); ?></td>
                                    <td class="px-8 py-6 font-black text-slate-900 text-sm italic group-hover:not-italic group-hover:text-indigo-700 transition"><?php echo htmlspecialchars($e['description']); ?></td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right font-black font-mono text-slate-900 tracking-tighter">Rs. <?php echo number_format($e['amnt']); ?></td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-500 px-3 py-1 rounded-full"><?php echo htmlspecialchars($e['savedby']); ?></span>
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
