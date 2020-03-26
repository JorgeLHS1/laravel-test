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
    public function index()
    {
        if(session()->has('list')){
            $list = json_decode(session('list'));
            return view('placesList', ['result' => $list]);
        }
        return view('placesList');
    }

    public function list(Request $request)
    {

        $validatedData = $request->validate([
            'text_query' => 'required|max:255',
            'api_key' => 'required|min:39',
        ]);

        $api_key = $request->api_key;
        $query = $request->text_query;

        $place = new Place();
        $response = $place->getPlacesList($api_key, $query);
        $result = json_decode($response->body());
        if ($result->status == 'OK') {
            session(['list' => $response->body()]);
            return view('placesList', ['result' => $result]);
        } else {
            return view('placesList', ['apiError' => $result]);
        }
    }
}
