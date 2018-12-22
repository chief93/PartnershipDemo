<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

/**
 * Class ErrorAccessDeniedView
 *
 * @package ViewModels
 */
class ErrorAccessDeniedView implements IPSView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'ErrorAccessDenied';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		// TODO: Implement ViewStylesheet() method.
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		// TODO: Implement ViewController() method.
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
		return $this->CurrentLocalizationOf('view.title.error.accessDenied');
	}
}