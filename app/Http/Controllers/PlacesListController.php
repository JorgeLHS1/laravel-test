<?php

namespace App\Http\Controllers;

use App\Repository\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            return view('places_list');
        } else {
            return redirect()->route('home');
        }
    }

    public function list(Request $request)
    {

        if ($request->isMethod('get')) {
            return redirect()->route('index');
        }

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
            if (session()->has('apiErrors')) {
                return view('places_list', ['apiError' => session()->get('apiErrors')]);
            } else {
                return view('places_list', ['apiError' => 'Não foi possível realizar sua consulta, tente novamente mais tarde!']);
            }
        }
    }
}
