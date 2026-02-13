<?php
require_once __DIR__ . '/config.php';
use App\Services\InventoryService;

$service = new InventoryService();
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

echo "--- Inventory Service Verification ---\n";

foreach (['Card', 'Mobile', 'SIM'] as $cat) {
    echo "\nCategory: $cat\n";
    try {
        $summary = $service->getStockSummary($cat, $startDate, $endDate);
        foreach ($summary as $row) {
            echo "Type: {$row['type']} \n";
            echo "  Open:  {$row['opening']['qty']} (@{$row['opening']['rate']})\n";
            echo "  Purch: {$row['purchase']['qty']}\n";
            echo "  Sale:  {$row['sale']['qty']} (Avg Rate: {$row['sale']['rate']})\n";
            echo "  Close: {$row['closing']['qty']}\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "\n--- Transaction Test (Otar) ---\n";
$trans = $service->getTransactions('Otar', ['startDate' => $startDate, 'endDate' => $endDate]);
echo "Otar Transactions Found: " . count($trans) . "\n";
