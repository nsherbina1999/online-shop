<?php

namespace App\Providers;

use App\Services\CourierServiceInterface;
use App\Services\NovaPoshtaService;
use App\Services\UkrposhtaService;
use Illuminate\Support\ServiceProvider;

/**
 * Class CourierServiceProvider
 * @package App\Providers
 *
 * Service provider for binding the courier service interface to its implementation.
 */
class CourierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CourierServiceInterface::class, function () {
            $courier = config('courier.default');
            switch ($courier) {
                case 'ukrposhta':
                    return new UkrposhtaService();
                case 'novaposhta':
                default:
                    return new NovaPoshtaService();
            }
        });
    }
}
