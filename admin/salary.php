<?php
// Modernized salary.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\EmployeeService;

$employeeService = new EmployeeService();

// Date range logic (simplified for modernization, can be expanded)
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

// Handle SaveClosing if needed (via include)
if (isset($_POST['SaveClosing'])) {
    include_once('includes/openclose.php');
}

$salaryGrid = $employeeService->getSalaryGrid($startDate, $endDate);

// Legacy UI support variables
$currentActiveUser = $_SESSION['login_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Projections - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">
    
    <div class="bg-indigo-700 text-white py-2 px-4 shadow-lg mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
             <div class="flex items-center space-x-6">
                 <a href="summary.php" class="font-bold text-lg hover:text-indigo-200 transition">NadirCom Dashboard</a>
                 <nav class="hidden md:flex space-x-4 text-sm font-medium">
                     <a href="dosales.php?name=DO" class="hover:text-indigo-200">Sales</a>
                     <a href="dodues.php?name=DO" class="hover:text-indigo-200">Payments</a>
                     <a href="salary.php" class="text-indigo-200 border-b-2 border-indigo-200">Salary</a>
                     <a href="empinfo.php" class="hover:text-indigo-200">Personnel</a>
                 </nav>
             </div>
             <div class="flex items-center space-x-4 text-sm">
                 <span class="text-indigo-100">Welcome, <b><?php echo htmlspecialchars($currentActiveUser); ?></b></span>
                 <a href="../logout.php" class="bg-indigo-800 hover:bg-indigo-900 px-3 py-1 rounded transition">Logout</a>
             </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Salary Projections</h1>
                <p class="mt-2 text-base text-gray-500">Projected payroll and commissions for <b><?php echo date('F Y'); ?></b>.</p>
            </div>
            
            <form method="POST" class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Closing month</label>
                    <select name="cMonthSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2">
                        <?php
                            $date = mktime(0, 0, 0, date('m'), 1, date('Y'));
                            for ($i = -2; $i <= 2; $i++) {
                                $val = strftime('%b-%Y', strtotime(($i >= 0 ? "+$i" : "$i") . ' month', $date));
                                $sel = ($i == 0) ? 'selected' : '';
                                echo "<option $sel>$val</option>";
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Opening month</label>
                    <select name="oMonthSelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2">
                         <?php
                            for ($i = -2; $i <= 2; $i++) {
                                $val = strftime('%b-%Y', strtotime(($i >= 0 ? "+$i" : "$i") . ' month', $date));
                                $sel = ($i == 1) ? 'selected' : '';
                                echo "<option $sel>$val</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="pt-5">
                    <button type="submit" name="SaveClosing" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm">
                        Perform Month Closing
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Employee</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Basic</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Otar Com.</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">MFS Com.</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Other Com.</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Gross Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 italic">
                        <?php 
                        $totals = ['basic' => 0, 'otar' => 0, 'mfs' => 0, 'other' => 0, 'gross' => 0];
                        foreach ($salaryGrid as $row): 
                            $totals['basic'] += $row['basic'];
                            $totals['otar'] += $row['coms']['otar'];
                            $totals['mfs'] += $row['coms']['mfs'];
                            $totals['other'] += ($row['coms']['market'] + $row['coms']['activity'] + $row['coms']['device'] + $row['coms']['postpaid'] + $row['coms']['other']);
                            $totals['gross'] += $row['gross'];
                        ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono"><?php echo number_format($row['basic']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-indigo-600"><?php echo number_format($row['coms']['otar']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-indigo-600"><?php echo number_format($row['coms']['mfs']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-indigo-600"><?php echo number_format($row['coms']['market'] + $row['coms']['activity'] + $row['coms']['device'] + $row['coms']['postpaid'] + $row['coms']['other']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-slate-800 bg-gray-50/30 font-mono">Rs. <?php echo number_format($row['gross']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-900 text-white">
                        <tr>
                            <td class="px-6 py-4 text-sm font-black uppercase tracking-widest">Grand Total</td>
                            <td class="px-6 py-4 text-right font-mono text-sm"><?php echo number_format($totals['basic']); ?></td>
                            <td class="px-6 py-4 text-right font-mono text-sm"><?php echo number_format($totals['otar']); ?></td>
                            <td class="px-6 py-4 text-right font-mono text-sm"><?php echo number_format($totals['mfs']); ?></td>
                            <td class="px-6 py-4 text-right font-mono text-sm"><?php echo number_format($totals['other']); ?></td>
                            <td class="px-6 py-4 text-right font-black text-amber-400 text-lg font-mono">Rs. <?php echo number_format($totals['gross']); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>
</body>
</html>