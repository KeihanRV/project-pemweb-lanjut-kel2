<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Debug\ExceptionHandler::class);
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Kitchen;
use Illuminate\Support\Facades\Gate;

$u = User::find(1);
if ($u) {
    echo 'user1 admin=' . ($u->is_admin ? '1' : '0') . PHP_EOL;
} else {
    echo 'user1 admin=null' . PHP_EOL;
}
$k = Kitchen::first();
if ($k) {
    echo 'kitchen=' . $k->id . PHP_EOL;
    if ($u) {
        echo 'allows update=' . (Gate::forUser($u)->allows('update', $k) ? '1' : '0') . PHP_EOL;
    }
} else {
    echo 'kitchen=null' . PHP_EOL;
}
