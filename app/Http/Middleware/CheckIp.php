<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\AllowedIp;

class CheckIp
{
    public function handle($request, Closure $next)
    {
        return response()->json([
            'ip' => $request->ip(),
            'clientIp' => $request->getClientIp(),
            'x-forwarded-for' => $request->header('x-forwarded-for'),
            'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    }
}
