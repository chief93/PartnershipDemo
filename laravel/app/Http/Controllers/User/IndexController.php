<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

/**
 * Class IndexController
 *
 * https://laravel.com/docs/5.0/authentication#protecting-routes
 *
 * @package App\Http\Controllers\User
 */
class IndexController extends Controller {
	/**
	 * Create a new controller instance.
	 */
	public function __construct () {
		$this->middleware('auth');
	}

	/**
	 * https://stackoverflow.com/a/37559664/2097055
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Get (Request $request) {
		$user = $request->user();
		$userLeader = $user->leader()->first();
		$userFollowers = $user->followers;

		return view('User\Index', array(
			'user' => $user,
			'userLeader' => $userLeader,
			'userFollowers' => $userFollowers
		));
	}
}