<?php

declare(strict_types=1);
require __DIR__ . '/../../bootstrap.php';

use App\Clients\BokunClient;

$bokun = new BokunClient(
    env('ACCESS_KEY'),
    env('SECRET_KEY'),
    env('APP_URL')
);

try {
    $result = $bokun->get('/product-list.json/list', ['lang' => 'EN']);
    dd($result['status'], $result['data']);
} catch (\Throwable $e) {
    dd('Error:', $e->getMessage());
}
