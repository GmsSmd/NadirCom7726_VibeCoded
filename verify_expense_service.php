<?php
require_once __DIR__ . '/config.php';
use App\Services\ExpenseService;

$service = new ExpenseService();
$date = date('Y-m-d');
$user = 'AdminTest';
$bank = 'Meezan Bank'; // From legacy defaults or DB

echo "--- Expense Service Verification ---\n";

// 1. Test Add Expense
echo "\nTesting addExpense...\n";
$success = $service->addExpense($date, "Test Purchase for verification", 500, $user, $bank);
echo $success ? "✅ Expense added successfully.\n" : "❌ Failed to add expense.\n";

// 2. Test Fetch Expenses
echo "\nTesting getExpenses...\n";
$expenses = $service->getExpenses(date('Y-m-01'), date('Y-m-t'));
echo "Count: " . count($expenses) . "\n";
if (count($expenses) > 0) {
    echo "Latest Description: " . $expenses[0]['description'] . "\n";
}

// 3. Test Petty Cash
echo "\nTesting managePettyCash (Add)...\n";
$pSuccess = $service->managePettyCash($date, 'AddIntopetty', 'Cash', 1000, "Refilling petty cash", $user);
echo $pSuccess ? "✅ Petty cash refill recorded.\n" : "❌ Failed to refill petty cash.\n";

// 4. Test Petty Balance (Opening)
echo "\nTesting getPettyOpeningBalance...\n";
$balance = $service->getPettyOpeningBalance(date('M-Y'));
echo "Opening Balance for " . date('M-Y') . ": " . $balance . "\n";
?>
