<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleMapsController extends Controller
{
    public function autocomplete(Request $request)
    {
        $input = $request->input('address');

        // Initialize the Guzzle client
        $client = new Client();

        // Call the Google Places API Autocomplete endpoint with the input address
        $response = $client->get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'query' => [
                'input' => $input,
                'types' => 'address',
                'key' => config('services.google_maps.api_key'),
            ],
        ]);

        // Decode the JSON response and extract the autocomplete predictions
        $locations = json_decode($response->getBody(), true)['predictions'];
        // Return the predictions as a JSON response
        return response()->json($locations);
    }
    public function getDetail($placeId)
    {
        // Initialize the Guzzle client
        $client = new Client();

        // Call the Google Places API Autocomplete endpoint with the input address
        $response = $client->get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'query' => [
                'place_id' => $placeId,
                'fields' => 'formatted_address,geometry',
                'key' => config('services.google_maps.api_key'),
            ],
        ]);
        // Decode the JSON response and extract the autocomplete predictions
        $result = json_decode($response->getBody(), true);

        // Return the predictions as a JSON response
        return response()->json($result);
    }
}
