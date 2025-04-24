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
            'icon'=>$data['weather'][0][icon],
            'date'=>now()->format('js F Y'),
            'wind_speed'=>$data['wind']['speed'],
            'wind_direction'=>$this->convertDegreesToDirection($data['wind']['deg']),
            'humidity'=>$data['main']['humidity']
        ]);

    }

}