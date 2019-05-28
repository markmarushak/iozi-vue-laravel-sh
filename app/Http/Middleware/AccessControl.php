<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Laratrust;
use Mockery\Exception;
use Route;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessKey = Route::currentRouteName();
        $message   = (app()->environment() !== 'production') ? 'Access denied for ' . @$accessKey : 'Access denied';
        try {
            /* If route doesn't have name, we didn't check permissions in this case */
            if (empty($accessKey) || Laratrust::can($accessKey)) {
                return $next($request);
            } else {

                if ($request->ajax() || $request->pjax()) {
                    abort(403, $message);
                } else {
                    if (Auth::check()) {
                        return redirect()->route('login');
                    } else {
                        return redirect()->home();
                    }
                }
            }
        } catch (Exception $e) {
            abort(403, $message);
        }
    }
}