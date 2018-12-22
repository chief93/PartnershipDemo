<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

/**
 * Class ErrorNotFoundView
 *
 * @package ViewModels
 */
class ErrorNotFoundView implements IPSView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'ErrorNotFound';
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
		return $this->CurrentLocalizationOf('view.title.error.notFound');
	}
}