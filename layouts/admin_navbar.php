<?php
$currentUserType = $_SESSION['login_type'] ?? 'Guest';
?>
<nav class="bg-white shadow-md border-b border-gray-200 relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-primary hover:text-blue-700 transition">NadirCom7726</span>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:ml-6 md:flex md:space-x-4 items-center">
                    
                    <!-- Summary Dropdown -->
                    <div class="relative group h-full flex items-center">
                        <button class="text-gray-500 group-hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
                            Summary
                        </button>
                        <div class="absolute left-0 top-16 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                            <a href="summary.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Summary Dashboard</a>
                            <a href="dailyactivity.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Daily Activity</a>
                            <a href="oldactivity.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Old Activity</a>
                        </div>
                    </div>

                    <!-- Sale & Purchase -->
                    <div class="relative group h-full flex items-center">
                        <button class="text-gray-500 group-hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
                            Sale & Purchase
                        </button>
                        <div class="absolute left-0 top-16 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                            <a href="lifting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Purchases</a>
                            <a href="dosales.php?name=DO" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sales</a>
                            <div class="relative group/nested border-t border-gray-100">
                                <a href="mfsupload.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between">
                                    Jazz MFS <span class="text-gray-400">&rsaquo;</span>
                                </a>
                                <div class="absolute left-full top-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover/nested:block">
                                    <a href="mfsupload.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sheet Upload</a>
                                    <a href="domfs.php?name=DO" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manual Entry</a>
                                    <a href="mfsupload_iq.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Initiator Query</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="relative group h-full flex items-center">
                        <button class="text-gray-500 group-hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
                            Payments
                        </button>
                        <div class="absolute left-0 top-16 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                            <a href="dodues.php?name=DO" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">DO Advance</a>
                            <div class="relative group/nested border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between">
                                    Commission <span class="text-gray-400">&rsaquo;</span>
                                </a>
                                <div class="absolute left-full top-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover/nested:block">
                                    <a href="getcomission.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Receive Commission</a>
                                    <a href="paycomission.php?name=do" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pay Commission</a>
                                </div>
                            </div>
                            <a href="companypayment.php?name=<?php echo $parentCompany ?? 'Franchise'; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Credit Clearance</a>
                            <a href="addtax.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pay Tax</a>
                        </div>
                    </div>

                    <!-- Salary & Expenses -->
                    <div class="relative group h-full flex items-center">
                        <button class="text-gray-500 group-hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
                            Expenses
                        </button>
                        <div class="absolute left-0 top-16 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                            <a href="expenses.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Daily Expenses</a>
                            <?php if($currentUserType=='Admin' OR $currentUserType=='Manager') { ?>
                            <div class="relative group/nested border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between">
                                    Salary <span class="text-gray-400">&rsaquo;</span>
                                </a>
                                <div class="absolute left-full top-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover/nested:block">
                                    <a href="currentsalary.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Current Salary</a>
                                    <a href="paysalary.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pay Salary</a>
                                    <a href="salarydeduction.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Salary Deduction</a>
                                </div>
                            </div>
                            <?php } ?>
                            <a href="expensesfix.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Fixed Expenses</a>
                        </div>
                    </div>

                    <!-- Manage -->
                    <div class="relative group h-full flex items-center">
                        <button class="text-gray-500 group-hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
                            Manage
                        </button>
                        <div class="absolute left-0 top-16 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover:block">
                            <a href="addusers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Users</a>
                            <div class="relative group/nested border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between">
                                    HR Management <span class="text-gray-400">&rsaquo;</span>
                                </a>
                                <div class="absolute left-full top-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover/nested:block">
                                    <?php if($currentUserType=='Admin') { ?>
                                    <a href="addemp.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Employees</a>
                                    <?php } ?>
                                    <a href="changeemporder.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Change Order</a>
                                    <a href="changeempvisibility.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visibility</a>
                                    <a href="addws.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Wholesaler</a>
                                    <a href="addrt.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Retailer</a>
                                </div>
                            </div>
                            <!-- Products Submenu -->
                            <div class="relative group/nested border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between">
                                    Products <span class="text-gray-400">&rsaquo;</span>
                                </a>
                                <div class="absolute left-full top-0 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden group-hover/nested:block">
                                    <a href="addproduct.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add Products</a>
                                    <a href="addproducttypes.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add Sub-Type</a>
                                    <a href="markproducttypes.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mark Active</a>
                                    <a href="setrate.php?name=Card" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Set Rates</a>
                                </div>
                            </div>
                            <a href="addcompany.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Company</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right side / User Info -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-semibold text-gray-700 px-3 py-1 bg-gray-100 rounded-full hidden lg:inline-block">
                    <?php echo $childOrganization ?? 'Organization'; ?>
                </span>
                <div class="flex flex-col text-right">
                    <span class="text-sm font-medium text-gray-900"><?php echo $currentActiveUser ?? 'User'; ?></span>
                    <a href="../logout.php" class="text-xs text-red-600 hover:text-red-800">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</nav>
