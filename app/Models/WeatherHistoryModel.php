<?php
namespace App\Models;
use CodeIgniter\Model;

class WeatherHistoryModel extends Model
{
    protected $table = 'weather_history';
    protected $allowedFields = ['city_name', 'searched_at'];
    public $timestamps = false;
}
