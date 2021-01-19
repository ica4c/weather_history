<?php

use App\Http\Procedures\V1\Util\UtilProcedure;
use App\Http\Procedures\V1\Weather\WeatherQueryProcedure;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
/**
 * @param \Illuminate\Routing\Router $router
 */ [
        'prefix' => 'v1',
        'namespace' => 'V1',
        'as' => 'v1.',
    ],
    static function(Router $router) {
        $router->rpc('rpc', [UtilProcedure::class, WeatherQueryProcedure::class])->name('rpc');
    }
);
