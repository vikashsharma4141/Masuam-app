<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Weather::index');
$routes->get('weather', 'Weather::index');
$routes->post('weather/getWeather', 'Weather::getWeather');
$routes->post('weather/deleteHistory', 'Weather::deleteHistory');
