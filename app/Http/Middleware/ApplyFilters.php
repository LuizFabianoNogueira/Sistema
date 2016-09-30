<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\Filter as Filter;


/**
 * Apply Filters to Routes
 *
 * @package Onvard\Filter\Middleware
 */
class ApplyFilters extends Filter
{
    /**
     * @var Response $response
     */
    protected $response;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        #nome da rota
        $routeName = $request->route()->getName();
        // Get Route's Actions
        $action = $request->route()->getAction();

        if(isset($action['filter']['before'])) {
            // Apply 'Before' Filters
            foreach ($action['filter']['before'] as $key => $value) {
                if (is_string($value)) {
                    if (function_exists(parent::$value($routeName))) {
                        $this->$value();
                    }
                }
            }
        }

        // Handle Request
        $this->response = $next($request);

        if(isset($action['filter']['after'])) {
            // Apply 'After' Filters
            foreach ($action['filter']['after'] as $key => $value) {
                if (is_string($value)) {
                    if (function_exists(parent::$value($routeName))) {
                        $this->$value();
                    }
                }
            }
        }

        // Return Response
        return $this->response;
    }
}
