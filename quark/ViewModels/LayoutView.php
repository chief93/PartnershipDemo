<?php
namespace ViewModels;

use Quark\IQuarkViewResource;

use Quark\QuarkView;

use Quark\ViewResources\Quark\QuarkPresence\QuarkPresence;

/**
 * Class LayoutView
 *
 * @package ViewModels
 */
class LayoutView implements IPSView {
	use ViewBehavior;

	/**
	 * @return string
	 */
	public function View () {
		return 'Layout';
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewStylesheet () {
		return $this->ThemeResource('/static/layout.css');
	}

	/**
	 * @return IQuarkViewResource|string
	 */
	public function ViewController () {
		return $this->ThemeResource('/static/layout.js');
	}

	/**
	 * @return IQuarkViewResource[]
	 */
	public function ViewResources () {
		return array(
			new QuarkPresence()
		);
	}

	/**
	 * @return string
	 */
	public function PSTitle () {
		/**
		 * @var QuarkView|IPSView $child
		 */
		$child = $this->Child();

		return $child->PSTitle();
	}
}