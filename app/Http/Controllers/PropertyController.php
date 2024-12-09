<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
   public function index() {
     $properties = Property::get();
    if($properties->count() > 0){
        return PropertyResource::collection($properties);
    } else {
        return response()->json(['message' => 'No property available'], 200);
    }
   }

   public function store(Request $request) {

     // Validate the incoming request data
     $validator = Validator::make($request->all(), [
        'image' => 'nullable|string',
        'price' => 'required|numeric',
        'bedrooms' => 'required|integer',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'All fields are mandatory',
            'error' => $validator->errors(), 422,
        ]); // Return validation errors
    }

    // Check if the property already exists
    $existingProperty = Property::where('title', $request->title)
                                ->where('address', $request->address)
                                ->first();

    if ($existingProperty) {
        return response()->json(['message' => 'Property already exists'], 409); // Conflict status
    }

     // Create a new property
     $property = Property::create($request->all());

     return response()->json([
        'message' => 'Property added successfully',
        'data' => $property
     ], 200);
   }

   public function show($id)
{
    // Find the property by ID
    $property = Property::find($id);

    // Check if the property exists
    if (!$property) {
        return response()->json(['message' => 'Property not found'], 404); // Not Found status
    }

    return new PropertyResource($property);
}

   public function update(Request $request, Property $property) {
    $validator = Validator::make($request->all(), [
        'image' => 'nullable|string',
        'price' => 'required|numeric',
        'bedrooms' => 'required|integer',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'All fields are mandatory',
            'error' => $validator->errors(), 422,
        ]); // Return validation errors
    }

     // Create a new property
     $property->update($request->all());

     return response()->json([
        'message' => 'Property updated successfully',
        'data' => $property
     ], 200);

   }

   public function destroy(Property $property) {
    $property->delete();
    return response()->json([
        'message' => 'Property deleted successfully',
     ], 200);
   }




}
