<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Debug\ExceptionHandler::class);
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Kitchen;
use Illuminate\Support\Facades\Gate;

$user = User::find(1);
$kitchen = Kitchen::find(1);

if (!$user) {
    echo "Error: User 1 not found\n";
    exit(1);
}

if (!$kitchen) {
    echo "Error: Kitchen 1 not found\n";
    exit(1);
}

echo "User: {$user->email} (Admin: " . ($user->is_admin ? 'YES' : 'NO') . ")\n";
echo "Kitchen: {$kitchen->nama} (ID: {$kitchen->id})\n";
echo "\n=== Authorization Checks ===\n";
echo "viewAny: " . (Gate::forUser($user)->allows('viewAny', Kitchen::class) ? 'ALLOWED' : 'DENIED') . "\n";
echo "view: " . (Gate::forUser($user)->allows('view', $kitchen) ? 'ALLOWED' : 'DENIED') . "\n";
echo "create: " . (Gate::forUser($user)->allows('create', Kitchen::class) ? 'ALLOWED' : 'DENIED') . "\n";
echo "update: " . (Gate::forUser($user)->allows('update', $kitchen) ? 'ALLOWED' : 'DENIED') . "\n";
echo "delete: " . (Gate::forUser($user)->allows('delete', $kitchen) ? 'ALLOWED' : 'DENIED') . "\n";
