<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'admin@example.com')->first();
Illuminate\Support\Facades\Auth::login($user);

$routes = [
    '/dashboard',
    '/patients',
    '/appointments',
    '/admissions',
    '/emergency',
    '/beds/matrix',
    '/nursing',
    '/pharmacy/pos',
    '/invoices',
    '/staff',
];

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

foreach ($routes as $route) {
    $request = Illuminate\Http\Request::create($route, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();
    $hasSidebar = strpos($content, 'erp-sidebar') !== false;
    echo sprintf("[%d] %-20s -> %s\n", $status, $route, $hasSidebar ? 'OK (Deep Navy & Teal ERP)' : 'Check');
}
