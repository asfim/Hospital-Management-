<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'admin@example.com')->first();
Illuminate\Support\Facades\Auth::login($user);

// Test beds/matrix
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(Illuminate\Http\Request::create('/beds/matrix', 'GET'));
    echo "BEDS MATRIX STATUS: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() != 200) {
        if ($response->exception) {
            echo "EXCEPTION: " . $response->exception->getMessage() . "\n";
            echo $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
        }
    }
} catch (\Throwable $e) {
    echo "CAUGHT: " . $e->getMessage() . "\n";
}

// Test pharmacy/pos
try {
    $response2 = $kernel->handle(Illuminate\Http\Request::create('/pharmacy/pos', 'GET'));
    echo "PHARMACY POS STATUS: " . $response2->getStatusCode() . "\n";
    if ($response2->getStatusCode() != 200) {
        if ($response2->exception) {
            echo "EXCEPTION: " . $response2->exception->getMessage() . "\n";
            echo $response2->exception->getFile() . ":" . $response2->exception->getLine() . "\n";
        }
    }
} catch (\Throwable $e) {
    echo "CAUGHT: " . $e->getMessage() . "\n";
}
