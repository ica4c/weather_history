<?php

namespace App\Providers;

use App\Http\Controllers\FaultTolerantRPCController;
use Illuminate\Support\Facades\Route;
use Sajya\Server\JsonRpcController;
use Sajya\Server\ServerServiceProvider;

class RPCServiceProvider extends ServerServiceProvider
{
    public function register(): void
    {
        Route::macro(
            'rpc',
            fn(string $uri, array $procedures = []) => Route::post($uri, [JsonRpcController::class, '__invoke'])
                ->setDefaults([
                    'procedures' => $procedures,
                    'delimiter' => config('rpc.delimiter'),
                ])
        );
    }
}
