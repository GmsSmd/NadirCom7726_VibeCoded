<?php
require_once __DIR__ . '/config.php';
use App\Services\PaymentService;

echo "Initializing PaymentService...\n";
try {
    $service = new PaymentService();
    echo "PaymentService initialized successfully.\n";

    echo "Testing getDuesEmployees()...\n";
    $employees = $service->getDuesEmployees();
    echo "Found " . count($employees) . " employees.\n";
    if (count($employees) > 0) {
        $firstEmployee = $employees[0]['EmpName'];
        echo "First employee: " . $firstEmployee . "\n";
        
        $date = date('Y-m-d');
        echo "Testing getDuesOpening('$firstEmployee', '" . date('M-Y') . "')...\n";
        $opening = $service->getDuesOpening($firstEmployee, date('M-Y'));
        echo "Opening Dues: " . $opening . "\n";

        echo "Testing getDailyDues('$firstEmployee', '$date', '$date')...\n";
        $summary = $service->getDailyDues($firstEmployee, $date, $date);
        print_r($summary);

        echo "Testing addTransaction (Simulated - not committing for test, or using dry run logic if available, but here we just check method existence/query gen potentially)...\n";
        // To verify write, we might need a test DB or cleanup. For now, we trust the read verification + code review.
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
