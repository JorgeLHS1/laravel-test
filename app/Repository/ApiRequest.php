<?php

namespace App\Repository;

use App\Place;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PDOException;

class ApiRequest
{

    public function getPlacesList($apiKey, $query, $pageToken = null, $results = [])
    {

        $params = [
            'key' => $apiKey,
            'query' => $query,
            'language' => 'pt-BR',
            'pagetoken' => $pageToken,
        ];

        $this->getDataByQuery($query);

        $response = $this->apiConnect('https://maps.googleapis.com/maps/api/place/textsearch/json', $params);
        $pageToken = $this->verifyToken($response);

        if ($pageToken) {
            array_push($results, json_decode($response->body()));
            //tem que esperar para chamar proximas página, se não recebe invalid_request.
            //Detalhes: https://developers.google.com/places/web-service/search#PlaceSearchPaging
            $this->m_sleep(500);
            return $this->getPlacesList($apiKey, $query, $pageToken, $results);
        } else {
            array_push($results, json_decode($response->body()));
        }

        $this->saveData($results, $query);

        return $this->getDataByQuery($query);
    }


    public function getDataByQuery($query)
    {
        $places = new Place();
        $results = $places->all()->where('consult_text', 'LIKE', $query);
        return ($results);
    }

    public function saveData($results, $query)
    {
        if ($results) {
            foreach ($results as $key) {
                if ($key->status == 'OK') {
                    foreach ($key->results as $item) {
                        try {
                            DB::transaction(function () use ($item, $query) {
                                $places = new Place();
                                $places->id = $item->place_id;
                                $places->name = $item->name;
                                $places->address = $item->formatted_address;
                                $places->reviews = $item->user_ratings_total;
                                $places->rating = $item->rating;
                                $places->explicit_location = $item->plus_code->compound_code;
                                $places->types = json_encode($item->types);
                                $places->consult_text = $query;
                                $places->save();
                            });
                        } catch (PDOException $th) {
                            Log::error($th);
                        }
                    }
                } else {
                    session()->flash('apiErrors', 'Erro ao solicitar requisição');
                }
            }
        }
    }

    public function apiConnect($baseUrl, $params)
    {
        return Http::get($baseUrl, $params);
    }

    public function verifyToken($response)
    {
        return (isset(json_decode($response->body())->next_page_token)) ? json_decode($response->body())->next_page_token : null;
    }

    function m_sleep($milliseconds)
    {
        return usleep($milliseconds * 1000);
    }
}
