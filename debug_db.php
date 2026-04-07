<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$queries = [
    'show tables',
    'show create table bakeries',
    "show table status like 'bakeries'",
    "show tables like 'custom_cake_requests'",
    "show create table custom_cake_requests",
    'select * from migrations order by id',
];

foreach ($queries as $query) {
    echo "=== {$query} ===\n";

    try {
        $rows = Illuminate\Support\Facades\DB::select($query);
        echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n\n";
    } catch (Throwable $e) {
        echo $e->getMessage(), "\n\n";
    }
}
