<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiStaticKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('api-static-key');
        $key = config('app.api_static_key');

        if ($apiKey !== $key) {
            return response()->json([
                'error' => 'api-static-key',
                'message' => 'Invalid Api Static Key',
                'status' => Response::HTTP_UNAUTHORIZED
            ]);
        }

        return $next($request);

    }

}
