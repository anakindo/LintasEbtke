<?php

namespace Mcamara\LaravelLocalization\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaravelLocalizationRoutes extends LaravelLocalizationMiddlewareBase
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $app = app();
        if (app()->router->currentRouteName() !== '') {
            $routeName = 'routes.'.app()->router->currentRouteName();
        } else {
            $routeName = $app['laravellocalization']->getRouteNameFromAPath($request->getUri());
        }
        
        $app['laravellocalization']->setRouteName($routeName);

        return $next($request);
    }
}
