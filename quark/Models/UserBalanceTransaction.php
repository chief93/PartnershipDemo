<?php
namespace Models;

use Quark\IQuarkModel;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkStrongModel;

use Quark\QuarkDate;
use Quark\QuarkLazyLink;
use Quark\QuarkModelBehavior;

/**
 * Class UserBalanceTransaction
 *
 * @property int $id
 * @property QuarkDate $date
 * @property QuarkLazyLink|User $user
 * @property float $amount
 * @property string $status
 *
 * @package Models
 */
class UserBalanceTransaction implements IQuarkModel, IQuarkStrongModel, IQuarkModelWithDataProvider {
	const STATUS_INIT = 'init';
	const STATUS_FINISHED = 'finished';

	use QuarkModelBehavior;

	/**
	 * @return string
	 */
	public function DataProvider () {
		return PS_DATA;
	}

	/**
	 * @return mixed
	 */
	public function Fields () {
		return array(
			$this->DataProviderPk(),
			'date' => QuarkDate::GMTNow(),
			'user' => $this->LazyLink(new User()),
			'amount' => 0.0,
			'status' => self::STATUS_INIT
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		// TODO: Implement Rules() method.
	}
}