<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendParcelRequest;
use App\Services\CourierServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class DeliveryController
 * @package App\Http\Controllers
 *
 * Handles parcel delivery requests.
 */
class DeliveryController extends Controller
{
    protected CourierServiceInterface $courierService;

    /**
     * DeliveryController constructor.
     *
     * @param CourierServiceInterface $courierService
     */
    public function __construct(CourierServiceInterface $courierService)
    {
        $this->courierService = $courierService;
    }

    /**
     * Handle the incoming request to send parcel data.
     *
     * @param SendParcelRequest $request
     * @return JsonResponse
     */
    public function sendParcel(SendParcelRequest $request): JsonResponse
    {
        $parcelData = [
            'customer_name' => $request->input('customer_name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'sender_address' => config('app.sender_address', 'Kyiv, Ukraine'),
            'delivery_address' => $request->input('delivery_address')
        ];

        if ($this->courierService->send($parcelData)) {
            return response()->json(['message' => 'Parcel data sent successfully.']);
        } else {
            return response()->json(['message' => 'Failed to send parcel data.'], 500);
        }
    }
}
