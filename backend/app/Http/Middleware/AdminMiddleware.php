<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
class AdminMiddleware
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
        if ($user->type !== 'admin') {
            return response()->json(['error' => 'User is not an admin'], 403);
        }
        return $next($request);
    }
}
