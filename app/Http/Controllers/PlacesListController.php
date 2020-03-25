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
        return view('placesList');
    }

    public function list(Request $request)
    {
        $api_key = $request->api_key;
        $query = $request->text_query;

        $place = new Place();
        $response = $place->getPlacesList($api_key, $query);
        $result = json_decode($response->body());
        if($result->status == 'OK'){
            return view('placesList', ['result' => $result]);
        } else {
            return view('placesList', ['error'=> "Erro ao processar sua consulta."]);
        }
    }
}
