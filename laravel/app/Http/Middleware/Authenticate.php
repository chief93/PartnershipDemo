<?php
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Class Authenticate
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware {
	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	protected function redirectTo ($request) {
		if (!$request->expectsJson())
			return route('/user/login');
	}
}