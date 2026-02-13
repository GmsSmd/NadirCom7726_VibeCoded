<?php
// Modernized paysalary.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\EmployeeService;

$employeeService = new EmployeeService();

// Handle selection
$salMonth = $_POST['salMonthSelect'] ?? date('b-Y', strtotime('-1 month'));

// Data retrieval
$salaryRecords = $employeeService->getSalaryRecords($salMonth);
$pendingExpenses = $employeeService->getPendingExpenses();

// For legacy navbar support
$currentActiveUser = $_SESSION['login_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Salaries & Expenses - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    
    <div class="bg-indigo-700 text-white py-2 px-4 shadow-lg mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
             <div class="flex items-center space-x-6">
                 <a href="summary.php" class="font-bold text-lg hover:text-indigo-200 transition">NadirCom Dashboard</a>
                 <nav class="hidden md:flex space-x-4 text-sm font-medium text-indigo-100">
                     <a href="dosales.php?name=DO" class="hover:text-white transition">Sales</a>
                     <a href="salary.php" class="hover:text-white transition">Projections</a>
                     <a href="paysalary.php" class="text-white border-b-2 border-white pb-1">Payments</a>
                 </nav>
             </div>
             <div class="flex items-center space-x-4 text-sm">
                 <span class="text-indigo-100">User: <b><?php echo htmlspecialchars($currentActiveUser); ?></b></span>
                 <a href="../logout.php" class="bg-indigo-800 hover:bg-indigo-900 px-3 py-1 rounded transition">Logout</a>
             </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        
        <!-- Header & Filter -->
        <div class="mb-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Financial Disbursements</h1>
                <p class="mt-2 text-lg text-slate-500">Manage salary releases and pending operational expenses.</p>
            </div>
            
            <form method="POST" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-end gap-5">
                <div class="flex-1">
                    <label class="block text-xs font-black text-slate-400 uppercase mb-2">Salary Month</label>
                    <select name="salMonthSelect" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                        <?php
                            $date = mktime(0, 0, 0, date('m'), 1, date('Y'));
                            for ($i = -6; $i <= 0; $i++) {
                                $val = strftime('%b-%Y', strtotime("$i month", $date));
                                $sel = ($val == $salMonth) ? 'selected' : '';
                                echo "<option $sel>$val</option>";
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" name="Showsalary" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition shadow-indigo-200 shadow-lg">
                    Show Records
                </button>
            </form>
        </div>

        <!-- Salaries Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="h-8 w-1 bg-indigo-600 rounded-full mr-3"></div>
                <h2 class="text-2xl font-bold text-slate-800">Salary Disbursements</h2>
            </div>
            
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50/80">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Employee</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Basic</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Commissions</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest text-indigo-600">Gross</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest text-red-500">Cutting</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Net Pay</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 italic">
                            <?php if (empty($salaryRecords)): ?>
                                <tr><td colspan="8" class="px-6 py-12 text-center text-slate-400 bg-slate-50/30">No records found for <?php echo $salMonth; ?>.</td></tr>
                            <?php else: ?>
                                <?php foreach ($salaryRecords as $rec): 
                                    $totalComs = (float)$rec['otarCom'] + (float)$rec['mfsCom'] + (float)$rec['marketSimCom'] + (float)$rec['activitySimCom'] + (float)$rec['deviceHandsetCom'] + (float)$rec['postpaidCom'] + (float)$rec['otherCom'];
                                ?>
                                    <tr class="hover:bg-indigo-50/50 transition duration-150">
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-bold text-slate-900"><?php echo htmlspecialchars($rec['empName']); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-mono text-slate-500"><?php echo number_format($rec['bSal']); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-mono text-slate-500"><?php echo number_format($totalComs); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-mono font-bold text-indigo-700"><?php echo number_format($rec['grossSal']); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-mono text-red-500">-<?php echo number_format($rec['cutting']); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-right font-black text-slate-900 text-lg font-mono">Rs. <?php echo number_format($rec['netSal']); ?></td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold <?php echo $rec['status'] == 'Pending' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200'; ?>">
                                                <?php echo htmlspecialchars($rec['status']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            <?php if ($rec['status'] == 'Pending'): ?>
                                                <a href="edit/getsalarybnkrcpt.php?ID=<?php echo $rec['id']; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-md transition" onclick="return confirm('Confirm payment?')">Release Pay</a>
                                            <?php else: ?>
                                                <a href="edit/viewsalary.php?ID=<?php echo $rec['id']; ?>" class="text-indigo-600 hover:underline text-xs font-bold italic">View Voucher</a>
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

        <!-- Expenses Section -->
        <div>
            <div class="flex items-center mb-6">
                <div class="h-8 w-1 bg-emerald-600 rounded-full mr-3"></div>
                <h2 class="text-2xl font-bold text-slate-800">Operational Dues (Pending)</h2>
            </div>
            
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Month</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-widest">Description</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Amount</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        <?php if (empty($pendingExpenses)): ?>
                            <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 bg-slate-50/20">All operational dues are currently cleared.</td></tr>
                        <?php else: ?>
                            <?php foreach ($pendingExpenses as $exp): ?>
                                <tr class="hover:bg-emerald-50/30 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo htmlspecialchars($exp['expMonth']); ?></td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-700"><?php echo htmlspecialchars($exp['description']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-black text-slate-900 font-mono">Rs. <?php echo number_format($exp['amnt']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="edit/payexp.php?ID=<?php echo $exp['id']; ?>&dt=<?php echo date('Y-m-d'); ?>&amnt=<?php echo $exp['amnt']; ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-xs font-bold shadow-md transition" onclick="return confirm('Clear this expense?')">Pay Now</a>
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