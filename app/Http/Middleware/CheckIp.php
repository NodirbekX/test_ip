<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\AllowedIp;

class CheckIp
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $allowed = AllowedIp::where('ip', $ip)->exists();

        if (!$allowed) {
            return response("🚫 Sizga ruxsat berilmagan", 403);
        }

        return $next($request);
    }
}
