<?php
namespace ViewModels\User;

use Quark\IQuarkViewResource;

use Quark\QuarkModel;

use Models\User;

use ViewModels\IPSView;
use ViewModels\ViewBehavior;

/**
 * Class IndexView
 *
 * @property QuarkModel|User $user
 *
 * @package ViewModels\User
 */
class IndexView implements IPSView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'User/Index';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/user/index.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/user/index.js');
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
		return $this->TemplatedCurrentLocalizationOf('view.title.user.index', array(
			'user' => $this->user
		));
	}
}