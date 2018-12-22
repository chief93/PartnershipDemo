<?php
namespace App\Http\Controllers\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

/**
 * Class RegisterController
 *
 * https://laravel.com/docs/5.7/validation
 *
 * @package App\Http\Controllers\User
 */
class RegisterController extends Controller {
	/**
     * Create a new controller instance.
     */
    public function __construct () {
        $this->middleware('guest');
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Get (Request $request) {
		$leader = User::FindLeader($request->route('promo'));

		return view('User\Register', array(
			'leader' => $leader
		));
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Post (Request $request) {
		$user = new User($request->all());
		$user->password_confirmation = $request->post('password_confirmation');

		$leader = User::FindLeader($request->route('promo'));

		if ($leader != null)
			$user->leader = $leader->id;

		$user->Validate();
		$user->save();

		event(new Registered($user));

		Auth::guard()->login($user);

		return redirect('/');
	}
}