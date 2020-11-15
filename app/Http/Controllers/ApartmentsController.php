<?php

namespace App\Http\Controllers;

use App\Jobs\ApartmentsList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApartmentsController extends Controller
{
    private array $filterParamsValidators = [
        'name'      => '',
        'bedrooms'  => 'numeric',
        'bathrooms' => 'numeric',
        'storeys'   => 'numeric',
        'garages'   => 'numeric',
    ];

    public function getApartmentsList(Request $request) : JsonResponse
    {
        $validator = Validator::make(
            $request->all()['filter'] ?? [],
            $this->filterParamsValidators
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'title'   => 'Wrong Parameters',
                    'code'    => 400,
                    'message' => $validator->errors()->first()
                ], 400);
        }

        $apartments = ApartmentsList::dispatchNow($request);
        return response()->json($apartments);
    }
}
