<?php

namespace App\Repository;

use App\Place;
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
                switch ($key->status) {
                    case 'OK':
                        foreach ($key->results as $item) {
                            try {
                                DB::transaction(function () use ($item, $query) {
                                    $places = new Place();
                                    $places->id = $item->place_id;
                                    $places->name = $item->name;
                                    $places->address = $item->formatted_address;
                                    $places->reviews = (property_exists($item, 'user_ratings_total')) ? $item->user_ratings_total : 0;
                                    $places->rating = (property_exists($item, 'rating')) ? $item->rating : 0;
                                    $places->explicit_location = (property_exists($item, 'plus_code')) ? $item->plus_code->compound_code : '';
                                    $places->types = json_encode($item->types);
                                    $places->consult_text = $query;
                                    $places->save();
                                });
                            } catch (PDOException $th) {
                                if ($th->errorInfo[1] != 1062) {
                                    Log::error($th);
                                }
                                session()->flash('apiErrors', "Não foi possível salvar informações no banco de dados - {$th}");
                            }
                        }
                        break;
                    default:
                        session()->flash('apiErrors', "Não foi possível solicitar requisição - {$key->status}");
                        break;
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
