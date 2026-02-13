<?php
require_once __DIR__ . '/config.php';
use App\Services\PurchaseService;

echo "Initializing PurchaseService...\n";
try {
    $service = new PurchaseService();
    echo "PurchaseService initialized successfully.\n";

    $date = date('Y-m-d');
    $user = 'TestUser';

    echo "Testing addLoad($date, 100, 'Test Load', 'Cash', '$user')...\n";
    if ($service->addLoad($date, 100, 'Test Load', 'Cash', $user)) {
        echo "Load added successfully.\n";
    } else {
        echo "Failed to add Load.\n";
    }

    echo "Testing addMfs($date, 500, 'Test MFS Refill', 'Cash', '$user')...\n";
    if ($service->addMfs($date, 500, 'Test MFS Refill', 'Cash', $user)) {
        echo "MFS Refill added successfully.\n";
    }

    echo "Testing debitMfs($date, 200, 'Test MFS Send', '$user')...\n";
    if ($service->debitMfs($date, 200, 'Test MFS Send', $user)) {
        echo "MFS Debit added successfully.\n";
    }

    // Checking Data
    echo "Checking Daily Load...\n";
    $loads = $service->getDailyLoad($date);
    echo "Found " . count($loads) . " loads.\n";
    if (count($loads) > 0) {
        print_r($loads[0]);
    }

    // Checking MFS
    echo "Checking Daily MFS Received...\n";
    $mfsRec = $service->getDailyMfsReceived($date);
    echo "Found " . count($mfsRec) . " MFS received records.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
