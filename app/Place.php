<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use function GuzzleHttp\json_decode;

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

    public function getPlacesList($apiKey, $query)
    {

        $params = [
                'key' => $apiKey,
                'query' => $query
            ];

        return Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', $params);
    }
}
