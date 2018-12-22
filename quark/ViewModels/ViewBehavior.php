<?php
namespace ViewModels;

use Quark\QuarkViewBehavior;

/**
 * Class ViewBehavior
 *
 * @package ViewModels
 */
trait ViewBehavior {
	use QuarkViewBehavior;

	/**
	 * @return string
	 */
	public function ViewTheme () {
		return 'Default';
	}
}