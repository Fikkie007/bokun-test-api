<?php

require __DIR__ . '/../../bootstrap.php';

use App\Clients\BokunClient;

$bokun = new BokunClient(
    env('ACCESS_KEY'),
    env('SECRET_KEY'),
    env('APP_URL')
);

try {
    $result = $bokun->post('/booking.json/product-booking-search', [
        'page' => 1,
        'pageSize' => 100
    ]);

    dd($result['status'], $result['data'], $result['data']['results'][0]);
} catch (\Throwable $e) {
    dd('Error:', $e->getMessage());
}
