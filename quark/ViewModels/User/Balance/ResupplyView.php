<?php
namespace ViewModels\User\Balance;

use Quark\IQuarkViewResource;

use ViewModels\IPSView;

use ViewModels\ViewBehavior;

/**
 * Class ResupplyView
 *
 * @package ViewModels\User\Balance
 */
class ResupplyView implements IPSView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'User/Balance/Resupply';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/user/balance/resupply.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/user/balance/resupply.js');
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		// TODO: Implement ViewResources() method.
	}

	/**
	 * @return string
	 */
	public function PSTitle () {
		return $this->CurrentLocalizationOf('view.title.user.balance.resupply');
	}
}