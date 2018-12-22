<?php
namespace Services\User\Balance;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;
use Quark\IQuarkSignedPostService;

use Quark\Quark;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;
use Models\UserBalanceTransaction;

use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorCSRFView;
use ViewModels\LayoutView;
use ViewModels\User\Balance\ResupplyView;

/**
 * Class ResupplyService
 *
 * @package Services\User\Balance
 */
class ResupplyService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication, IQuarkSignedPostService {
	/**
	 * @param QuarkDTO $request
	 *
	 * @return string
	 */
	public function AuthorizationProvider (QuarkDTO $request) {
		return PS_SESSION;
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return bool|mixed
	 */
	public function AuthorizationCriteria (QuarkDTO $request, QuarkSession $session) {
		return $session->User() != null;
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkView::InLayout(new ErrorAccessDeniedView(), new LayoutView());
	}

	/**
	 * @param QuarkDTO $request
	 *
	 * @return mixed
	 */
	public function SignatureCheckFailedOnPost (QuarkDTO $request) {
		return QuarkView::InLayout(new ErrorCSRFView(), new LayoutView());
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|UserBalanceTransaction $transaction
		 */
		$transaction = new QuarkModel(new UserBalanceTransaction());

		return QuarkView::InLayout(new ResupplyView(), new LayoutView(), array(
			'transaction' => $transaction
		));
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Post (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|User $user
		 */
		$user = $session->User();

		/**
		 * @var QuarkModel|UserBalanceTransaction $transaction
		 */
		$transaction = $user->BalanceResupply(abs($request->amount));

		if (!$transaction->Validate())
			return QuarkView::InLayout(new ResupplyView(), new LayoutView(), array(
				'transaction' => $transaction
			));

		if (!$transaction->Create())
			return QuarkView::InLayout(new ResupplyView(), new LayoutView(), array(
				'transaction' => $transaction,
				'error' => 'transaction'
			));

		$leader = $user->Leader();

		if ($leader != null) {
			$leaderResupply = $leader->BalanceResupply(User::BalanceRoyalty($transaction->amount));

			if (!$leaderResupply->Create())
				Quark::Log('Can not proceed resupplying transaction for leader of user ' . $user->id, Quark::LOG_WARN);
		}

		return QuarkDTO::ForRedirect('/user');
	}
}