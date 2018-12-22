<?php
namespace App\Http\Controllers\User\Balance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Http\Controllers\Controller;

/**
 * Class ResupplyController
 *
 * https://ru.stackoverflow.com/questions/886118/laravel-5-7-%D0%BF%D1%80%D0%B8-%D0%BE%D0%B1%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%BA%D0%B5-post-%D0%B7%D0%B0%D0%BF%D1%80%D0%BE%D1%81%D0%B0-%D0%B2%D1%8B%D0%B4%D0%B0%D1%91%D1%82-%D0%BE%D1%88%D0%B8%D0%B1%D0%BA%D1%83-419-sorry-your-session-has
 * https://stackoverflow.com/questions/35630138/how-to-use-request-all-with-eloquent-models
 * https://hackernoon.com/eloquent-relationships-cheat-sheet-5155498c209
 * https://laravel.com/docs/5.7/eloquent
 *
 * @package App\Http\Controllers\User\Balance
 */
class ResupplyController extends Controller {
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
		return view('User/Balance/Resupply');
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Post (Request $request) {
		/**
		 * @var User $user
		 */
		$user = $request->user();

		$transaction = $user->BalanceResupply(abs($request->post('amount')));

		if (!$transaction->save())
			return view('User/Balance/Resupply');

		/**
		 * @var User $leader
		 */
		$leader = $user->leader()->first();

		if ($leader !== null) {
			$leaderResupply = $leader->BalanceResupply(User::BalanceRoyalty($transaction->amount));

			if (!$leaderResupply->save())
				Log::warning('Can not proceed resupplying transaction for leader of user ' . $user->id);
		}

		return redirect('/user');
	}
}