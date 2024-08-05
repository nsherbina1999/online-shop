<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class NovaPoshtaService
 * @package App\Services
 *
 * Implementation of the CourierServiceInterface for Nova Poshta.
 */
class NovaPoshtaService implements CourierServiceInterface
{
    /**
     * @inheritDoc
     */
    public function send(array $data): bool
    {
        $response = Http::post('https://novaposhta.test/api/delivery', $data);
        return $response->successful();
    }
}
