<?php
// Modernized petty.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\ExpenseService;
use App\Core\Database;

$expenseService = new ExpenseService();
$db = Database::getInstance();

$currentActiveUser = $_SESSION['login_user'] ?? '';
$currentUserType = $_SESSION['login_type'] ?? '';
$defaultBankName = $_SESSION['default_bank'] ?? 'Meezan Bank';
$currentMonthStr = date('M-Y');

// Action Handling
$message = '';
if (isset($_POST['Addit'])) {
    $dt = $_POST['DT'];
    $typ = $_POST['Tselect'];
    $amnt = (float)$_POST['txtAmnt'];
    $cmnt = $_POST['txtCmnt'];
    $mod = $_POST['modeSelect'];
    
    if ($expenseService->managePettyCash($dt, $typ, $mod, $amnt, $cmnt, $currentActiveUser)) {
        $message = "Petty cash transaction recorded!";
    } else {
        $message = "Error: Transaction failed. Please check inputs.";
    }
}

// Data Fetching
$queryStartDate = date('Y-m-01');
$queryEndDate = date('Y-m-t');
$pettyHistory = $expenseService->getPettyHistory($queryStartDate, $queryEndDate);
$openingBalance = $expenseService->getPettyOpeningBalance($currentMonthStr);

// Calculate current balance (simplified for display)
$netChange = 0;
foreach($pettyHistory as $p) {
    if ($p['status'] === 'Add') $netChange += $p['amnt'];
    else $netChange -= $p['amnt'];
}
$currentBalance = $openingBalance + $netChange;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfdfe] text-slate-900 min-h-screen">
    
    <div class="bg-indigo-900 text-white py-12 px-8 mb-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-end">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tighter uppercase mb-2">Petty Cash Portal</h1>
                <p class="text-indigo-300 font-medium">Manage micro-expenditures and cash refills.</p>
            </div>
            <div class="bg-indigo-800/50 p-6 rounded-3xl border border-indigo-700/50 backdrop-blur-md mt-6 md:mt-0 min-w-[200px]">
                <p class="text-[10px] font-black tracking-widest text-indigo-400 uppercase mb-1">Available Reserve</p>
                <p class="text-3xl font-black font-mono">Rs. <?php echo number_format($currentBalance); ?></p>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-8 pb-20">
        
        <?php if ($message): ?>
            <div class="mb-8 p-4 rounded-2xl <?php echo strpos($message, 'Error') !== false ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100'; ?> font-bold text-sm">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            
            <!-- Entry Form -->
            <div class="lg:col-span-1">
                <form method="POST" class="space-y-6 sticky top-24">
                    <h2 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-8 border-b pb-4">Authorization</h2>
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Timeline</label>
                        <input type="date" name="DT" value="<?php echo date('Y-m-d'); ?>" class="w-full bg-slate-100 border-none rounded-xl p-4 font-bold text-sm">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Direction</label>
                        <select name="Tselect" class="w-full bg-slate-100 border-none rounded-xl p-4 font-bold text-sm">
                            <option value="AddIntopetty">📥 Refill (From Bank/Cash)</option>
                            <option value="SubtractFrompetty">📤 Outflow (Spent/Returned)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Channel</label>
                        <select name="modeSelect" class="w-full bg-slate-100 border-none rounded-xl p-4 font-bold text-sm">
                            <option>Cash</option>
                            <?php
                                $banks = $db->query("SELECT Name from company WHERE Type='BNK'")->fetchAll();
                                foreach($banks as $b) {
                                    $sel = ($b['Name'] == $defaultBankName) ? 'selected' : '';
                                    echo "<option $sel>" . htmlspecialchars($b['Name']) . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Quantum (PKR)</label>
                        <input type="number" name="txtAmnt" placeholder="0" class="w-full bg-indigo-50 border-none rounded-xl p-4 font-black text-xl text-indigo-700">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Annotations</label>
                        <input type="text" name="txtCmnt" placeholder="Optional notes..." class="w-full bg-slate-100 border-none rounded-xl p-4 font-bold text-sm">
                    </div>

                    <button type="submit" name="Addit" class="w-full bg-indigo-600 hover:bg-slate-900 text-white font-black uppercase tracking-widest text-xs py-5 rounded-2xl transition-all shadow-xl shadow-indigo-100 active:scale-95">
                        Log Transaction
                    </button>
                </form>
            </div>

            <!-- Detailed Ledger -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-500">Activity Journal</h3>
                        <div class="flex items-center space-x-4">
                            <span class="text-[10px] font-bold text-slate-400 italic">Opening: Rs. <?php echo number_format($openingBalance); ?></span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50">
                                <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">State</th>
                                    <th class="px-8 py-4">Origin/Dest</th>
                                    <th class="px-8 py-4 text-right">Amnt (PKR)</th>
                                    <th class="px-8 py-4">Notes</th>
                                    <th class="px-8 py-4 text-center">X</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php if (empty($pettyHistory)): ?>
                                    <tr><td colspan="6" class="px-8 py-32 text-center text-slate-200 font-bold italic">No recorded movements.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($pettyHistory as $h): ?>
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-8 py-6 whitespace-nowrap text-xs font-bold text-slate-500 uppercase"><?php echo date('d M Y', strtotime($h['date'])); ?></td>
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full <?php echo $h['status'] === 'Add' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'; ?>">
                                                    <?php echo $h['status']; ?>
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap text-sm font-bold text-slate-700"><?php echo htmlspecialchars($h['fromTo']); ?></td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right font-black font-mono <?php echo $h['status'] === 'Add' ? 'text-emerald-700' : 'text-slate-900'; ?>">
                                                <?php echo $h['status'] === 'Add' ? '+' : '-'; ?> <?php echo number_format($h['amnt']); ?>
                                            </td>
                                            <td class="px-8 py-6 text-xs text-slate-500 font-medium italic truncate max-w-[200px]"><?php echo htmlspecialchars($h['comments']); ?></td>
                                            <td class="px-8 py-6 text-center">
                                                <a href="delete/delpetty.php?ID=<?php echo $h['id']; ?>" class="text-rose-200 hover:text-rose-600 transition" onclick="return confirm('Purge record #<?php echo $h['id']; ?>?')">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </a>
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
