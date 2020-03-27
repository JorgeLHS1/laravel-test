<?php

namespace App\Http\Controllers;

use App\Place;
use App\Repository\ApiRequest;
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
        // if (session()->has('list')) {
        //     $list = json_decode(session('list'));
        //     return view('places_list', ['result' => $list]);
        // }
        return view('places_list');
    }

    public function list(Request $request)
    {

        $validatedData = $request->validate([
            'text_query' => 'required|max:255',
            'api_key' => 'required|min:39',
        ]);

        $api_key = $request->api_key;
        $query = $request->text_query;

        $place = new ApiRequest();
        $response = $place->getPlacesList($api_key, $query);

        if (sizeof($response) > 0) {
            //session(['list' => json_encode($response)]);
            return view('places_list', ['result' => $response]);
        } else {
            return view('places_list', ['apiError' => 'Não foi possível realizar sua consulta, tente novamente mais tarde!']);
        }

    }

    public function listTest(Place $place)
    {
        $results = $place::all();
        foreach ($results as $key) {
            return var_dump($key);
        }

    }
}
