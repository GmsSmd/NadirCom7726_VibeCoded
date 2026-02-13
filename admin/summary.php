<?php
session_start();
require_once __DIR__ . '/../config.php';

// Authentication Check
if (!isset($_SESSION['login_user'])) {
    header("location: ../login.php");
    exit();
}

use App\Services\SummaryService;

$service = new SummaryService();
$currentUserType = $_SESSION['login_type'];
$dateNow = date('Y-m-d');
$currentMonth = date('M-Y');
$dateFrom = date('Y-m-01');
$dateTo = date('Y-m-t'); // Last day of month

// Fetch Data
$openings = $service->getOpeningBalances($currentMonth);
$targets = $service->getTargets($currentMonth);
$achieved = $service->getAchievedStats($dateFrom, $dateTo);
$profits = $service->getProfits($dateFrom, $dateTo);
$investments = $service->getInvestments($currentMonth, $dateFrom, $dateTo);
$expenses = $service->getExpenses($dateFrom, $dateTo);

// Metrics Calculations
$totalProfit = $profits['Otar'] + $profits['MFS'] + $profits['OtherCommission'] + $profits['Cards'] + $profits['Mobile'] + $profits['SIM'];
$totalExpenses = $expenses['Fixed'] + $expenses['Regular'] + $expenses['Tax'] + $expenses['Salary'];
$netVisibility = $totalProfit - $totalExpenses;

$totalInvestment = $investments['Otar'] + $investments['MFS'] + $investments['Card'] + $investments['Mobile'] + $investments['SIM'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="#" class="text-indigo-600 px-3 py-2 rounded-md text-sm font-medium bg-indigo-50">Summary</a>
                    <a href="dosales.php?name=DO" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Sales</a>
                    <a href="dodues.php?name=DO" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Payments</a>
                    <a href="lifting.php" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Purchase</a>
                    <a href="../logout.php" class="text-red-500 hover:text-red-700 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                 </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500">Performance Overview for <?php echo $currentMonth; ?></p>
        </div>

        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Net Visibility -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 <?php echo $netVisibility >= 0 ? 'border-green-500' : 'border-red-500'; ?>">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Net Visibility</p>
                        <p class="text-2xl font-bold <?php echo $netVisibility >= 0 ? 'text-green-700' : 'text-red-700'; ?>"><?php echo number_format($netVisibility); ?></p>
                    </div>
                    <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-500">Profit - Expenses</div>
            </div>

            <!-- Total Investment -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                 <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Inventory</p>
                        <p class="text-2xl font-bold text-blue-700"><?php echo number_format($totalInvestment); ?></p>
                    </div>
                     <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                 <div class="mt-2 text-xs text-gray-500">Stock Value</div>
            </div>

             <!-- Expenses -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
                 <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Expenses</p>
                        <p class="text-2xl font-bold text-orange-700"><?php echo number_format($totalExpenses); ?></p>
                    </div>
                     <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                 <div class="mt-2 text-xs text-gray-500">Fixed + Regular + Salary</div>
            </div>
            
             <!-- Bank -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                 <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Bank / Cash</p>
                        <p class="text-2xl font-bold text-purple-700"><?php echo number_format($investments['Bank']); ?></p>
                    </div>
                     <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </div>
                </div>
                 <div class="mt-2 text-xs text-gray-500">Cash Flow Closing</div>
            </div>
        </div>
        
        <!-- Detailed Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Targets vs Achieved -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Targets vs Achieved</h3>
                <div class="space-y-4">
                    <!-- Otar -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Otar Load</span>
                            <span class="font-medium"><?php echo number_format($achieved['Otar']); ?> / <?php echo number_format($targets['Otar']); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo ($targets['Otar'] > 0 ? ($achieved['Otar']/$targets['Otar'])*100 : 0); ?>%"></div>
                        </div>
                    </div>
                     <!-- Cards -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Cards</span>
                            <span class="font-medium"><?php echo number_format($achieved['Card']); ?> / <?php echo number_format($targets['Card']); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: <?php echo ($targets['Card'] > 0 ? ($achieved['Card']/$targets['Card'])*100 : 0); ?>%"></div>
                        </div>
                    </div>
                     <!-- Mobile -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Mobile Devices</span>
                            <span class="font-medium"><?php echo number_format($achieved['Mobile']); ?> / <?php echo number_format($targets['Mobile']); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-pink-600 h-2.5 rounded-full" style="width: <?php echo ($targets['Mobile'] > 0 ? ($achieved['Mobile']/$targets['Mobile'])*100 : 0); ?>%"></div>
                        </div>
                    </div>
                     <!-- SIM -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>SIMs</span>
                            <span class="font-medium"><?php echo number_format($achieved['SIM']); ?> / <?php echo number_format($targets['SIM']); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: <?php echo ($targets['SIM'] > 0 ? ($achieved['SIM']/$targets['SIM'])*100 : 0); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Breakdown -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Inventory Value</h3>
                <div class="relative h-64">
                    <canvas id="investChart"></canvas>
                </div>
            </div>
            
            <!-- Profit Breakdown Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden lg:col-span-2">
                 <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Profitability Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100 text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3 text-right">Profit</th>
                                <th class="px-6 py-3 text-right">Investment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-3 font-medium">Otar / Load</td>
                                <td class="px-6 py-3 text-right text-green-600"><?php echo number_format($profits['Otar']); ?></td>
                                <td class="px-6 py-3 text-right"><?php echo number_format($investments['Otar']); ?></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 font-medium">MFS (JazzCash/EasyPaisa)</td>
                                <td class="px-6 py-3 text-right text-green-600"><?php echo number_format($profits['MFS']); ?></td>
                                <td class="px-6 py-3 text-right"><?php echo number_format($investments['MFS']); ?></td>
                            </tr>
                             <tr>
                                <td class="px-6 py-3 font-medium">Cards</td>
                                <td class="px-6 py-3 text-right text-green-600"><?php echo number_format($profits['Cards']); ?></td>
                                <td class="px-6 py-3 text-right"><?php echo number_format($investments['Card']); ?></td>
                            </tr>
                             <tr>
                                <td class="px-6 py-3 font-medium">Other Commission</td>
                                <td class="px-6 py-3 text-right text-green-600"><?php echo number_format($profits['OtherCommission']); ?></td>
                                <td class="px-6 py-3 text-right">-</td>
                            </tr>
                             <tr class="bg-gray-50 font-bold">
                                <td class="px-6 py-3">Total</td>
                                <td class="px-6 py-3 text-right"><?php echo number_format($totalProfit); ?></td>
                                <td class="px-6 py-3 text-right"><?php echo number_format($totalInvestment); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-400 text-sm">
            &copy; <?php echo date('Y'); ?> VibeCoded Modern App. 
        </div>
    </footer>

    <script>
        const ctx = document.getElementById('investChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Otar', 'MFS', 'Card', 'Mobile', 'SIM'],
                datasets: [{
                    data: [
                        <?php echo $investments['Otar']; ?>, 
                        <?php echo $investments['MFS']; ?>, 
                        <?php echo $investments['Card']; ?>, 
                        <?php echo $investments['Mobile']; ?>, 
                        <?php echo $investments['SIM']; ?>
                    ],
                    backgroundColor: [
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#8b5cf6', // purple
                        '#ec4899', // pink
                        '#f59e0b'  // yellow
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>
</html>