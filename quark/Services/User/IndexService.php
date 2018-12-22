<?php
namespace Services\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;

use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\ErrorAccessDeniedView;
use ViewModels\ErrorNotFoundView;
use ViewModels\LayoutView;
use ViewModels\User\IndexView;

/**
 * Class IndexService
 *
 * @package Services\User
 */
class IndexService implements IQuarkGetService, IQuarkAuthorizableServiceWithAuthentication {
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
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		$userId = $request->URI()->Route(1);

		/**
		 * @var QuarkModel|User $user
		 */
		$user = $userId == ''
			? $session->User()
			: QuarkModel::FindOneById(new User(), $userId);

		if ($user == null)
			return QuarkView::InLayout(new ErrorNotFoundView(), new LayoutView());

		$userLeader = $user->Leader();
		$userFollowers = $user->Followers();

		return QuarkView::InLayout(new IndexView(), new LayoutView(), array(
			'user' => $user,
			'userLeader' => $userLeader,
			'userFollowers' => $userFollowers
		));
	}
}