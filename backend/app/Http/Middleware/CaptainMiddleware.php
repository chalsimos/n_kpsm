<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Crypt;
use App\Models\User;
class CaptainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $decryptedId = Crypt::decrypt($token);
        $user = User::find($decryptedId);
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if ($user->type !== 'captain') {
            return response()->json(['error' => 'User is not Captain'], 403);
        }
        return $next($request);

    }
}
