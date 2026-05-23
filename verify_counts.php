<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Debug\ExceptionHandler::class);
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Kitchen;

$totalUsers = User::count();
$totalKitchens = Kitchen::count();

echo "Total Users: {$totalUsers}\n";
echo "Total Kitchens: {$totalKitchens}\n";
