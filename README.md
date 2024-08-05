# Online Shop Parcel Delivery

## Description
This project is a Laravel application that handles sending parcel data to courier services. It is designed for future enhancements and the addition of multiple courier integrations.

## Installation

1. **Clone this repository:**
   ```bash
   git clone <repository_url>
   cd online-shop
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Copy the example environment file and configure:**
   ```bash
   cp .env.example .env
   ```

4. **Set the sender address in the `.env` file:**
   ```env
   SENDER_ADDRESS="Your Sender Address Here"
   ```

5. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

6. **Serve the application:**
   ```bash
   php artisan serve
   ```

## Usage

To send parcel data, make a POST request to `/send-parcel` with the following fields:
- `width` (numeric): Width of the parcel.
- `height` (numeric): Height of the parcel.
- `length` (numeric): Length of the parcel.
- `weight` (numeric): Weight of the parcel.
- `customer_name` (string): Name of the recipient.
- `phone_number` (string): Phone number of the recipient.
- `email` (email): Email address of the recipient.
- `delivery_address` (string): Delivery address for the parcel.

### Example Request
```json
{
    "width": 10,
    "height": 20,
    "length": 30,
    "weight": 5,
    "customer_name": "John Doe",
    "phone_number": "+380960000000",
    "email": "john.doe@example.com",
    "delivery_address": "Prorizna St, 2, Kyiv, Ukraine, 01601"
}
```

### Example CURL Command
```bash
curl -X POST http://localhost:8000/send-parcel \
    -H "Content-Type: application/json" \
    -d '{
        "width": 10,
        "height": 20,
        "length": 30,
        "weight": 5,
        "customer_name": "John Doe",
        "phone_number": "+380950000000",
        "email": "john.doe@example.com",
        "delivery_address": "Prorizna St, 2, Kyiv, Ukraine, 01601"
    }'
```

## Adding New Couriers

1. **Create a new implementation of `CourierServiceInterface`:**
   ```php
   <?php

   namespace App\Services;

   use Illuminate\Support\Facades\Http;

   /**
    * Class OtherCourierService
    * @package App\Services
    *
    * Implementation of the CourierServiceInterface for another courier.
    */
   class OtherCourierService implements CourierServiceInterface
   {
       /**
        * @inheritDoc
        */
       public function send(array $data): bool
       {
           $response = Http::post('https://othercourier.test/api/delivery', $data);
           return $response->successful();
       }
   }
   ```

2. **Update the service provider to use the new courier:**
   ```php
   <?php

   namespace App\Providers;

   use Illuminate\Support\ServiceProvider;
   use App\Services\CourierServiceInterface;
   use App\Services\NovaPoshtaService;
   use App\Services\OtherCourierService;

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
       public function register()
       {
           $this->app->bind(CourierServiceInterface::class, function ($app) {
               $courier = config('courier.default');
               switch ($courier) {
                   case 'other':
                       return new OtherCourierService();
                   case 'novaposhta':
                   default:
                       return new NovaPoshtaService();
               }
           });
       }

       /**
        * Bootstrap services.
        *
        * @return void
        */
       public function boot()
       {
           //
       }
   }
   ```

3. **Add courier configuration in `config/courier.php`:**
   ```php
   return [
       'default' => env('COURIER_SERVICE', 'novaposhta'),
   ];
   ```

4. **Update the `.env` file:**
   ```env
   COURIER_SERVICE=novaposhta
   ```
