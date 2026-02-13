<?php
// Modernized expenses.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\ExpenseService;
use App\Core\Database;

$expenseService = new ExpenseService();
$db = Database::getInstance();

// Legacy session variables
$currentActiveUser = $_SESSION['login_user'] ?? '';
$currentUserType = $_SESSION['login_type'] ?? '';
// Note: Fetch default bank from config or session
$defaultBankName = $_SESSION['default_bank'] ?? 'Meezan Bank';

// Action Handling
$message = '';
if (isset($_POST['AddIntoIncomeExp'])) {
    $dt = $_POST['DT'];
    $desc = $_POST['txtDesc'];
    $amnt = (float)$_POST['txtAmnt'];
    
    if ($expenseService->addExpense($dt, $desc, $amnt, $currentActiveUser, $defaultBankName)) {
        $message = "Expense recorded successfully!";
    } else {
        $message = "Error: Please fill all fields correctly.";
    }
}

// Data Fetching
$queryStartDate = date('Y-m-01');
$queryEndDate = date('Y-m-t');
$expenses = $expenseService->getExpenses($queryStartDate, $queryEndDate);
$totalExpense = array_sum(array_column($expenses, 'amnt'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 min-h-screen">
    
    <!-- Hero / Header -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white pb-32 pt-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <nav class="flex items-center space-x-2 text-indigo-300 text-xs font-bold uppercase tracking-[0.2em] mb-4">
                    <a href="summary.php" class="hover:text-white transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-white">Expenses</span>
                </nav>
                <h1 class="text-5xl font-extrabold tracking-tight">Financial Flow</h1>
                <p class="text-slate-400 mt-2 font-medium">Track operational costs and maintain fiscal hygiene.</p>
            </div>
            <div class="flex items-center space-x-6">
                <div class="text-right">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Current Portal</p>
                    <p class="text-sm font-bold"><?php echo htmlspecialchars($currentActiveUser); ?> <span class="text-slate-500 font-normal">[<?php echo $currentUserType; ?>]</span></p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <span class="text-xl font-black">NC</span>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 -mt-24 pb-20">
        
        <?php if ($message): ?>
            <div class="mb-8 p-4 rounded-2xl <?php echo strpos($message, 'Error') !== false ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100'; ?> flex justify-between items-center animate-bounce">
                <span class="font-bold text-sm tracking-wide"><?php echo $message; ?></span>
                <button onclick="this.parentElement.remove()" class="hover:scale-110 transition">✕</button>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Entry Form Card -->
            <div class="lg:col-span-4">
                <div class="glass border border-white p-8 rounded-[2.5rem] shadow-2xl shadow-slate-200/50">
                    <div class="flex items-center space-x-4 mb-10">
                        <div class="h-10 w-10 rounded-xl bg-slate-900 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-60h-6"></path></svg>
                        </div>
                        <h2 class="text-xl font-black uppercase tracking-tighter">New Entry</h2>
                    </div>

                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Event Date</label>
                            <input type="date" name="DT" value="<?php echo date('Y-m-d'); ?>" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Narrative</label>
                            <textarea name="txtDesc" placeholder="Describe the expenditure..." class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 transition h-32"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Quantum (PKR)</label>
                            <input type="number" step="0.01" name="txtAmnt" placeholder="0.00" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-black text-2xl text-indigo-600 focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        
                        <div class="pt-4">
                            <p class="text-[10px] font-bold text-slate-400 mb-4 px-1 italic">Note: All entries are synchronized with the <b><?php echo $defaultBankName; ?></b> ledger.</p>
                            <button type="submit" name="AddIntoIncomeExp" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-[0.2em] py-5 rounded-2xl transition shadow-xl shadow-slate-300 hover:scale-[1.01] active:scale-95 text-xs">
                                Authorize Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ledger View -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                
                <!-- Quick stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-indigo-600 p-8 rounded-[2rem] text-white shadow-xl shadow-indigo-200">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-1">Monthly Burn Rate</p>
                        <p class="text-3xl font-black font-mono tracking-tighter">Rs. <?php echo number_format($totalExpense); ?></p>
                        <div class="mt-4 h-1.5 w-full bg-indigo-400/30 rounded-full overflow-hidden">
                            <div class="bg-white h-full" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Transaction Velocity</p>
                        <p class="text-3xl font-black text-slate-900"><?php echo count($expenses); ?> <span class="text-xs text-slate-400 font-bold uppercase">Entries</span></p>
                        <p class="text-[10px] font-bold text-emerald-500 mt-2">Active Ledger</p>
                    </div>
                </div>

                <!-- Data Table Card -->
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-500">Expenditure Log [<?php echo date('M Y'); ?>]</h3>
                        <a href="expensereport.php" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline transition">Full Archive</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">
                                    <th class="px-8 py-4">Timeline</th>
                                    <th class="px-8 py-4">Entity/Narrative</th>
                                    <th class="px-8 py-4 text-right">Debit (PKR)</th>
                                    <th class="px-8 py-4 text-center">Ctrl</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php if (empty($expenses)): ?>
                                    <tr><td colspan="4" class="px-8 py-32 text-center text-slate-300 font-bold italic tracking-wider">No transactional activity detected in this cycle.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($expenses as $e): ?>
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-8 py-6 whitespace-nowrap text-xs font-bold text-slate-500"><?php echo date('d M Y', strtotime($e['expDate'])); ?></td>
                                            <td class="px-8 py-6">
                                                <p class="text-sm font-black text-slate-900"><?php echo htmlspecialchars($e['description']); ?></p>
                                                <p class="text-[10px] text-slate-400 font-medium italic">Logged by <?php echo htmlspecialchars($e['savedby']); ?></p>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right font-black font-mono text-rose-600 tracking-tighter">Rs. <?php echo number_format($e['amnt']); ?></td>
                                            <td class="px-8 py-6 text-center">
                                                <?php if ($currentUserType == "Admin" || (date("Y-m-d") == $e['expDate'])): ?>
                                                    <a href="delete/delexp.php?ID=<?php echo $e['id']; ?>" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition" onclick="return confirm('Purge record #<?php echo $e['id']; ?>?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
