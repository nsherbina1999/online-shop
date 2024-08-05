<?php

namespace App\Services;

/**
 * Interface CourierServiceInterface
 * @package App\Services
 *
 * Defines the contract for courier services.
 */
interface CourierServiceInterface
{
    /**
     * Send parcel data to the courier service.
     *
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool;
}
