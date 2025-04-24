<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class WeatherController extends Controller
{
    protected $apiKey;
    public function __construct()
    {
        $this ->apiKey = config('');
    }
    // getting current weather
    public function getWeather(Request $request)
    {
        $city = $request -> query('city','Nairobi');
        $units = $request ->query('units','metric');
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather",[
            'q'=> $city,
            'appid'=>$this ->apiKey,
            'units' => $units,

        ]);
        if ($response -> failed()){
            return response() ->json(['error' => 'could not fetch weather data'],500);
        }
        $data =$response ->json();
        return response()->json([
            'city'=>$data['name'],
            'temperature'=>round($data['main']['temp']),
            'weather'=>$data['weather'][0]['main'],
            'icon'=>$data['weather'][0]['icon'],
            'date' => now()->format('jS F Y'),
            'wind_speed'=>$data['wind']['speed'],
            'wind_direction'=>$this->convertDegreesToDirection($data['wind']['deg']),
            'humidity'=>$data['main']['humidity']
        ]);

    }
    // getting 3 days weather forecast
    public function getForecast(Request $request)

    {
        $city = $request-> query('city','Nairobi');
        $units =$request -> query ('units','metric');
        $geo=$this -> getCoordinates($city);
        if (!$geo){
            return response()->json(['error'=> 'Invalid city name'],400);
        }
        [$lat,$lon]=$geo;
        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast",[
            'lat'=>$lat,
            'lon'=>$lon,
            'appid'=>$this->apiKey,
            'units'=>$units,
        ]);
        if ($response->failed()){
            return response()-> json(['error'=>'could not fetch forecast data'],500);
        }
        $data =$response->json();
        $daily=[];
        foreach ($data['list'] as $forecast){
            $date = date ('Y-m-d',strtotime($forecast['dt_txt']));
            if (!isset($daily[$date])){
                $daily[$date]=[
                    'date'=>$date,
                    'min_temp'=>$forecast['main']['temp_min'],
                    'max_temp'=>$forecast['main']['temp_max'],
                    'icon'=>$forecast['weather'][0]['icon'],
                    'description' => $forecast['weather'][0]['main']

                ];
            }
        }
        return response()->json(array_values(array_slice($daily,1,3)));
    }
}