<?php
require_once __DIR__ . '/config.php';
use App\Services\SummaryService;

echo "Initializing SummaryService...\n";
try {
    $service = new SummaryService();
    echo "SummaryService initialized successfully.\n";

    $month = date('M-Y'); // e.g., Feb-2026
    $dateFrom = date('Y-m-01');
    $dateTo = date('Y-m-d');

    echo "Fetching Opening Balances for $month...\n";
    $openings = $service->getOpeningBalances($month);
    print_r($openings);

    echo "Fetching Targets for $month...\n";
    $targets = $service->getTargets($month);
    print_r($targets);

    echo "Fetching Achieved Stats ($dateFrom to $dateTo)...\n";
    $stats = $service->getAchievedStats($dateFrom, $dateTo);
    print_r($stats);

    echo "Fetching Profits...\n";
    $profits = $service->getProfits($dateFrom, $dateTo);
    print_r($profits);
    
    echo "Fetching Investments...\n";
    $invest = $service->getInvestments($month, $dateFrom, $dateTo);
    print_r($invest);

    echo "Fetching Expenses...\n";
    $exp = $service->getExpenses($dateFrom, $dateTo);
    print_r($exp);


} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
