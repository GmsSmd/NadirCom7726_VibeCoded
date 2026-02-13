<?php
// Modernized empinfo.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../session.php';

use App\Services\EmployeeService;

$employeeService = new EmployeeService();
$employees = $employeeService->getAllEmployees();

// For legacy navbar support
$parentCompany = $_SESSION['company_name'] ?? '';
$childOrganization = $_SESSION['organization_name'] ?? '';
$currentActiveUser = $_SESSION['login_user'] ?? '';
$currentUserType = $_SESSION['login_type'] ?? '';
$defaultBankName = $_SESSION['default_bank'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information - NadirCom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased">
    
    <!-- Navbar placeholder - including legacy for now to keep links working -->
    <div class="bg-indigo-700 text-white py-2 px-4 shadow-lg mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
             <div class="flex items-center space-x-6">
                 <a href="summary.php" class="font-bold text-lg hover:text-indigo-200 transition">NadirCom Dashboard</a>
                 <nav class="hidden md:flex space-x-4 text-sm font-medium">
                     <a href="dosales.php?name=DO" class="hover:text-indigo-200">Sales</a>
                     <a href="dodues.php?name=DO" class="hover:text-indigo-200">Payments</a>
                     <a href="lifting.php" class="hover:text-indigo-200">Purchase</a>
                     <a href="empinfo.php" class="text-indigo-200 border-b-2 border-indigo-200">Personnel</a>
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
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Personnel Directory</h1>
                <p class="mt-2 text-base text-gray-500">Manage your workforce, salaries, and joining details.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="addemp.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    New Employee
                </a>
            </div>
        </div>

        <!-- Metric Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Active</p>
                <p class="mt-2 text-3xl font-bold text-gray-900"><?php echo count($employees); ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Avg. Monthly Cost</p>
                <?php 
                    $totalSalary = array_sum(array_column($employees, 'EmpFixedSalary'));
                    $avgSalary = count($employees) > 0 ? $totalSalary / count($employees) : 0;
                ?>
                <p class="mt-2 text-3xl font-bold text-gray-900">Rs. <?php echo number_format($avgSalary); ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Payroll</p>
                <p class="mt-2 text-3xl font-bold text-indigo-600">Rs. <?php echo number_format($totalSalary); ?></p>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">ID</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Employee Name</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Joining Date</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Fixed Salary</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php if (empty($employees)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/20">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        No active employees found in the system.
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($employees as $emp): ?>
                                <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400">#<?php echo str_pad($emp['EmpID'], 3, '0', STR_PAD_LEFT); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                <?php echo substr($emp['EmpName'], 0, 1); ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($emp['EmpName']); ?></div>
                                                <div class="text-xs text-gray-500">Personnel</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium"><?php echo htmlspecialchars($emp['EmpJoinDate']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-slate-700">
                                        Rs. <?php echo number_format($emp['EmpFixedSalary']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                <p class="text-xs text-gray-400">Showing <?php echo count($employees); ?> active employees.</p>
            </div>
        </div>
    </main>
</body>
</html>
