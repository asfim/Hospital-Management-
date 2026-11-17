<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all();
foreach ($users as $u) {
    $hasDefaultPass = Illuminate\Support\Facades\Hash::check('password', $u->password);
    echo "User {$u->email}: password is 'password'? " . ($hasDefaultPass ? 'YES' : 'NO') . "\n";
    if (!$hasDefaultPass) {
        // Let's set password to 'password' or check what it is
        echo "Updating password to 'password' for consistency...\n";
        $u->password = Illuminate\Support\Facades\Hash::make('password');
        $u->save();
        echo "Updated!\n";
    }
}
