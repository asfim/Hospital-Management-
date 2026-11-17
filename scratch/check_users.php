<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::with('roles')->get();
foreach ($users as $u) {
    echo sprintf(
        "ID: %d | Name: %-20s | Email: %-25s | Roles: %s\n",
        $u->id,
        $u->name,
        $u->email,
        $u->roles->pluck('name')->implode(', ')
    );
}
