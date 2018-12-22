<?php
namespace Services\User;

use Quark\IQuarkAuthorizableServiceWithAuthentication;
use Quark\IQuarkGetService;
use Quark\IQuarkPostService;

use Quark\QuarkDate;
use Quark\QuarkDTO;
use Quark\QuarkModel;
use Quark\QuarkSession;
use Quark\QuarkView;

use Models\User;

use ViewModels\LayoutView;
use ViewModels\User\CreateView;

/**
 * Class CreateService
 *
 * @package Services\User
 */
class CreateService implements IQuarkGetService, IQuarkPostService, IQuarkAuthorizableServiceWithAuthentication {
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
		return $session->User() == null;
	}

	/**
	 * @param QuarkDTO $request
	 * @param $criteria
	 *
	 * @return mixed
	 */
	public function AuthorizationFailed (QuarkDTO $request, $criteria) {
		return QuarkDTO::ForRedirect('/');
	}

	/**
	 * @param QuarkDTO $request
	 * @param QuarkSession $session
	 *
	 * @return mixed
	 */
	public function Get (QuarkDTO $request, QuarkSession $session) {
		/**
		 * @var QuarkModel|User $leader
		 */
		$leader = User::FindLeader($request->URI()->Route(2));

		/**
		 * @var QuarkModel|User $user
		 */
		$user = new QuarkModel(new User());

		return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
			'user' => $user,
			'leader' => $leader
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
		 * @var QuarkModel|User $leader
		 */
		$leader = User::FindLeader($request->URI()->Route(2));

		/**
		 * @var QuarkModel|User $user
		 */
		$user = new QuarkModel(new User(), $request->Data());
		$user->created_at = QuarkDate::GMTNow();
		$user->leader->value = $leader->id;

		if (!$user->Validate())
			return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
				'user' => $user,
				'leader' => $leader
			));

		if (!$user->Create())
			return QuarkView::InLayout(new CreateView(), new LayoutView(), array(
				'user' => $user,
				'leader' => $leader,
				'error' => 'user'
			));

		return QuarkDTO::ForRedirect('/');
	}
}