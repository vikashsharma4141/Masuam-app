<?php

namespace App\Controllers;

use App\Models\WeatherHistoryModel;

class Weather extends BaseController
{
    public function index()
    {
        return view('weather_form', ['data' => null, 'error' => null]);
    }

    public function getWeather()
    {
       
        $city = $this->request->getPost('city');
        $apiKey = 'ed64d126c3069b8154e2a6e6a80ad3fb';
    
        try {
            $client = \Config\Services::curlrequest();
    
            // Get current weather data
            $response = $client->get("https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric");
            $weatherData = json_decode($response->getBody(), true);
    
            if ($weatherData['cod'] != 200) {
                throw new \Exception('City not found.');
            }
    
            
            $lat = $weatherData['coord']['lat'];
            $lon = $weatherData['coord']['lon'];
    
     
            $aqiResponse = $client->get("http://api.openweathermap.org/data/2.5/air_pollution?lat={$lat}&lon={$lon}&appid={$apiKey}");
            $aqiData = json_decode($aqiResponse->getBody(), true);
    
          
            $weatherData['aqi'] = $aqiData['list'][0]['main']['aqi'];
           
        
            $model = new \App\Models\WeatherHistoryModel();
            $model->insert([
                'city_name' => $weatherData['name'],
                'searched_at' => date('Y-m-d H:i:s')
            ]);
    
       
            $history = $model->orderBy('searched_at', 'DESC')->limit(5)->findAll();
    
      
            return view('dashboard', [
                'data' => $weatherData,
                'error' => null,
                'history' => $history
            ]);
    
        } catch (\Exception $e) {
            return view('dashboard', [
                'data' => null,
                'error' => 'Failed to fetch weather: ' . $e->getMessage(),
                'history' => []
            ]);
        }
    }
    public function deleteHistory()
{
    $id = $this->request->getPost('id');

    if ($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('weather_history');
        $builder->where('id', $id);
        $deleted = $builder->delete();

        if ($deleted) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Record deleted successfully.']);
        }
    }

    return $this->response->setJSON(['status' => 'error', 'message' => 'Unable to delete.']);
}

          
   }
