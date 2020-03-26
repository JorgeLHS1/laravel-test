<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Place extends Model
{
    private $name;
    private $placeId;
    private $adress;
    private $reviews;
    private $rating;
    private $categories;
    private $type;
    private $tel;
    private $website;

    public function getPlacesList($apiKey, $query, $pageToken = null, $results = [])
    {

        $params = [
            'key' => $apiKey,
            'query' => $query,
            'pagetoken' => $pageToken,
        ];

        $response = $this->apiConnect('https://maps.googleapis.com/maps/api/place/textsearch/json', $params);
        $pageToken = $this->verifyToken($response);

        if ($pageToken) {
            array_push($results, json_decode($response->body()));
            //tem que esperar para chamar segunda página, se não recebe invalid_request
            $this->m_sleep(500);
            return $this->getPlacesList($apiKey, $query, $pageToken, $results);
        } else {
            array_push($results, json_decode($response->body()));
        }
        return $results;
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
