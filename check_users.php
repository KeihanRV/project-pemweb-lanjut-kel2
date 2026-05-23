<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Debug\ExceptionHandler::class);
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== DAFTAR USER ===" . PHP_EOL;
$users = User::all(['id', 'email', 'name', 'is_admin']);
foreach ($users as $u) {
    echo "ID: {$u->id} | Email: {$u->email} | Name: {$u->name} | Admin: " . ($u->is_admin ? 'YES' : 'NO') . PHP_EOL;
}

echo PHP_EOL . "=== MENGUBAH USER 1 KE ADMIN ===" . PHP_EOL;
$user = User::find(1);
if ($user) {
    $user->update(['is_admin' => true]);
    echo "User {$user->email} sekarang ADMIN" . PHP_EOL;
} else {
    echo "User 1 tidak ditemukan" . PHP_EOL;
}
