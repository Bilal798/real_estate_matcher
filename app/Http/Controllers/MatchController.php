<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\ProfileMatchService;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    protected ProfileMatchService $profileMatchService;

    /**
     * Description: Constructor method used for initializing profile service instance.
     */
    public function __construct()
    {
        $this->profileMatchService = new ProfileMatchService();
    }

    /**
     * @param Property $property
     * @return JsonResponse
     */
    public function index(Property $property): JsonResponse
    {
        // Get property fields
        $propertyFields = $property->propertyFields->toArray();

        // Get all profiles related to the property type.
        $potentialProfiles = $property->potentialProfiles();

        // Filter all the profiles and return the matched one.
        $data = $this->profileMatchService->matchProfiles($propertyFields, $potentialProfiles);

        return response()->json(['data' => $data]);
    }
}
