<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\User
 */
class LoginController extends Controller {
	/**
	 * Create a new controller instance.
	 */
	public function __construct () {
		$this->middleware('guest');
	}

	/**
	 * @return mixed
	 */
	public function Get () {
		return view('User\Login');
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 *
	 * @throws ValidationException
	 */
	public function Post (Request $request) {
		$request->validate(array(
			'email'=> 'required|string',
			'password' => 'required|string',
		));

		if (!Auth::guard()->attempt($request->only('email', 'password')))
			throw ValidationException::withMessages([
				'email' => array(trans('auth.failed'))
			]);

		$request->session()->regenerate();

		return redirect('/');
	}
}