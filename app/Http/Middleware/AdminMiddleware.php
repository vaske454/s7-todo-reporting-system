<?php

namespace App\Http\Middleware;

//use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Current approach:
         if (Auth::check() && Auth::user()->is_admin) {
             return $next($request);
         }

          return redirect('/'); // Redirect to home or any other page

        // Alternative approach:
//        $userId = Auth::user()->getAuthIdentifier();
//
//        $user = User::query()->where('id', $userId)->first();
//
//        if (Auth::check() && $user->is_admin === true) {
//            return $next($request);
//        }
//
//        return redirect('/'); // Redirect to home or any other page
    }
}
