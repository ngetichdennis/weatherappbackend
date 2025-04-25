# Weather App Backend

This is the backend for the weather application built with **Laravel**. It provides an API to fetch real-time weather data, 3-day weather forecasts, and search functionality for cities using the **OpenWeatherMap API**.

## Features

- **Current Weather**: Fetches current weather data for a given city, including temperature, weather condition, wind speed, direction, and humidity.
- **3-Day Forecast**: Fetches the 3-day weather forecast for a given city.
- **Search City**: Allows searching for a city by name

## Technologies Used

- **Laravel**: PHP framework for backend development.
- **OpenWeatherMap API**: Used to fetch weather data.
- **HTTP Client (Laravel)**: Used for making HTTP requests to external services.

## Requirements

- PHP >= 7.4
- Composer
- Laravel >= 8.x

## Installation

### 1. Clone the Repository

Clone the backend repository to your local machine:

```bash
git clone git@github.com:ngetichdennis/weatherappbackend.git
cd weather-backend
2. Install Dependencies
Install the required dependencies using Composer:


composer install
3. Set Up Environment File

cp .env.example .env
4. Configure the API Key
You will need to obtain an API key from OpenWeatherMap. Once you have it, add the API key to your .env file:

OPENWEATHERMAP_API_KEY=your_api_key_here

5. Run the Laravel Development Server
Run the application locally:

php artisan serve
The backend should now be running at http://127.0.0.1:8000.

API Routes
The backend exposes the following routes:

1. Get Current Weather
GET /api/weather?city={city}&units={units}

city: The name of the city you want to fetch the weather for (e.g., "Nairobi").

units: The unit of temperature (either metric for Celsius or imperial for Fahrenheit). Default is metric.

Response Example:

{
  "city": "Nairobi",
  "temperature": 23,
  "weather": "Clouds",
  "icon": "04d",
  "date": "25th April 2025",
  "wind_speed": 3.97,
  "wind_direction": "E",
  "humidity": 54
}
2. Get 3-Day Weather Forecast
GET /api/forecast?city={city}&units={units}

city: The name of the city you want to fetch the weather forecast for.

units: The unit of temperature (metric for Celsius or imperial for Fahrenheit).

Response Example:

[
  {
    "date": "2025-04-25",
    "min_temp": 22.1,
    "max_temp": 26.3,
    "icon": "04d",
    "description": "Clouds"
  },
  {
    "date": "2025-04-26",
    "min_temp": 21.5,
    "max_temp": 27.2,
    "icon": "04d",
    "description": "Clouds"
  },
  {
    "date": "2025-04-27",
    "min_temp": 20.8,
    "max_temp": 28.0,
    "icon": "01d",
    "description": "Clear"
  }
]
3. Search City
GET /api/search-city?city={city}

city: The name of the city to search for.

Response Example:

{
  "city": "Nairobi",
  "lat": -1.286389,
  "lon": 36.817223
}
