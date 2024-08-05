<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class UkrposhtaService
 * @package App\Services
 *
 * Implementation of the CourierServiceInterface for Ukrposhta.
 */
class UkrposhtaService implements CourierServiceInterface
{
    /**
     * @inheritDoc
     */
    public function send(array $data): bool
    {
        $response = Http::post('https://ukrposhta.test/api/delivery', $data);
        return $response->successful();
    }
}
