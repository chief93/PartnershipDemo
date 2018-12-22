<?php
namespace App\Http\Middleware;

use Closure;

/**
 * Class RedirectIfAuthenticated
 *
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated {
	/**
	 * @param $request
	 * @param Closure $next
	 * @param $guard = null
	 *
	 * @return mixed
	 */
	public function handle ($request, Closure $next, $guard = null) {
		return $next($request);
	}
}