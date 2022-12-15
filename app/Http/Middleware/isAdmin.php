<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->input('email'));
        $isAdmin = User::where('email', $request->input('email'))->first();
        // dd($isAdmin->role);
        // dd(response()->json($isAdmin));
        $message = '';

        if (!is_null($isAdmin)) {

            if ($isAdmin->role == 0) {
                $message = "User";
            } else {
                $message = "Admin";
            }
        }
        return response()->json([
            'message' => $message,
        ], 200);
    }
}
