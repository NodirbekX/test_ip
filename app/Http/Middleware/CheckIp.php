<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AllowedIp;

class CheckIp
{
    public function handle($request, Closure $next)
    {
        $forwarded = $request->header('x-forwarded-for');

        $ip = trim(explode(',', $forwarded)[0]);

        $allowed = AllowedIp::where('ip', $ip)->exists();

        if (!$allowed) {
            return response("🚫 Sizga ruxsat berilmagan. IP: ", 403);
        }

        return $next($request);
    }
}
