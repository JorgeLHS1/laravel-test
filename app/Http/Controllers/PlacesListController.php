<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class PlacesListController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Place $place)
    {
        $response = $place->getPlacesList('AIzaSyA6IyL73y4ryYZ00Dnw-T5o8NiMQDcAZUE', 'ideal trends');
        $result = json_decode($response->body());
        if($result->status == 'OK'){
            return view('placesList', ['result' => $result]);
        } else {
        }
        return $result;
    }
}
