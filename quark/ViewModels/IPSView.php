<?php
namespace ViewModels;

use Quark\IQuarkViewModel;
use Quark\IQuarkViewModelInLocalizedTheme;
use Quark\IQuarkViewModelWithComponents;
use Quark\IQuarkViewModelWithResources;

/**
 * Interface IPSView
 *
 * @package ViewModels
 */
interface IPSView extends IQuarkViewModel, IQuarkViewModelInLocalizedTheme, IQuarkViewModelWithComponents, IQuarkViewModelWithResources {
	/**
	 * @return string
	 */
	public function PSTitle();
}