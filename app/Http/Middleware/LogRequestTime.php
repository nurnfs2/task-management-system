<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestTime
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $end = microtime(true);
        $duration = round(($end - $start) * 1000, 2); // ms

        $log = [
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->ip(),
            'duration_ms' => $duration,
            'user_id' => optional($request->user())->id,
        ];

        Log::info('RequestLog', $log);

        return $response;
    }
}
