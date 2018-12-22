<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

/**
 * Class LogoutController
 *
 * https://laravel.com/docs/5.7/csrf
 *
 * @package App\Http\Controllers\User
 */
class LogoutController extends Controller {
	/**
	 * Create a new controller instance.
	 */
	public function __construct () {
		$this->middleware('auth');
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Get (Request $request) {
		Auth::guard()->logout();

		$request->session()->invalidate();

		return redirect('/');
	}
}