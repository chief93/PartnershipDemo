<?php
namespace Models;

use Quark\IQuarkAuthorizableModel;
use Quark\IQuarkLinkedModel;
use Quark\IQuarkModel;
use Quark\IQuarkModelWithBeforeCreate;
use Quark\IQuarkModelWithAfterPopulate;
use Quark\IQuarkModelWithDataProvider;
use Quark\IQuarkNullableModel;
use Quark\IQuarkStrongModel;
use Quark\IQuarkStrongModelWithRuntimeFields;

use Quark\QuarkCollection;
use Quark\QuarkDate;
use Quark\QuarkField;
use Quark\QuarkKeyValuePair;
use Quark\QuarkLazyLink;
use Quark\QuarkModel;
use Quark\QuarkModelBehavior;
use Quark\QuarkSQL;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property QuarkDate $created_at
 * @property QuarkLazyLink|User $leader
 * @property string $promo
 *
 * @property string $password_clear
 * @property string $password_confirm
 *
 * @package Models
 */
class User implements IQuarkModel, IQuarkStrongModel, IQuarkStrongModelWithRuntimeFields, IQuarkModelWithDataProvider, IQuarkModelWithAfterPopulate, IQuarkModelWithBeforeCreate, IQuarkLinkedModel, IQuarkNullableModel, IQuarkAuthorizableModel {
	const PASSWORD_LENGTH_MIN = 8;
	const PROMO_LENGTH = 8;

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
			'email' => '',
			'password' => '',
			'created_at' => QuarkDate::GMTNow(),
			'leader' => $this->LazyLink(new User(), null),
			'promo' => ''
		);
	}

	/**
	 * @return mixed
	 */
	public function Rules () {
		return array(
			$this->LocalizedAssert(QuarkField::Email($this->email), 'validation.user.email', 'email'),
			$this->LocalizedAssert(mb_strlen($this->password_clear) >= self::PASSWORD_LENGTH_MIN, 'validation.user.password', 'password'),
			$this->LocalizedAssert($this->password_clear == $this->password_confirm, 'validation.user.password_confirm', 'password_confirm')
		);
	}

	/**
	 * @return mixed
	 */
	public function RuntimeFields () {
		return array(
			'password_clear' => '',
			'password_confirm' => ''
		);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function AfterPopulate ($raw) {
		$this->password_clear = $this->password;
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function BeforeCreate ($options) {
		$this->password = self::Password($this->email, $this->password);
		$this->promo = self::Promo(self::PROMO_LENGTH);
	}

	/**
	 * @param $raw
	 *
	 * @return mixed
	 */
	public function Link ($raw) {
		return QuarkModel::FindOneById(new User(), $raw);
	}

	/**
	 * @return mixed
	 */
	public function Unlink () {
		return $this->id;
	}

	/**
	 * @param string $name
	 * @param $session
	 *
	 * @return mixed
	 */
	public function Session ($name, $session) {
		return QuarkModel::FindOneById(new User(), $session->id);
	}

	/**
	 * @param string $name
	 * @param $criteria
	 * @param int $lifetime (seconds)
	 *
	 * @return QuarkModel|IQuarkAuthorizableModel
	 */
	public function Login ($name, $criteria, $lifetime) {
		return QuarkModel::FindOne(new User(), array(
			'email' => $criteria->email,
			'password' => self::Password($criteria->email, $criteria->password)
		));
	}

	/**
	 * @param string $name
	 * @param QuarkKeyValuePair $id
	 *
	 * @return bool
	 */
	public function Logout ($name, QuarkKeyValuePair $id) {
		// TODO: Implement Logout() method.
	}

	/**
	 * @param string $email = ''
	 * @param string $password = ''
	 *
	 * @return string
	 */
	public static function Password ($email = '', $password = '') {
		return sha1($email . sha1($password . $email) . md5($password));
	}

	/**
	 * https://stackoverflow.com/a/18890309/2097055
	 *
	 * @param int $length = self::PROMO_LENGTH
	 *
	 * @return string
	 */
	public static function Promo ($length = self::PROMO_LENGTH) {
		return bin2hex(openssl_random_pseudo_bytes($length));
	}

	/**
	 * @return float
	 */
	public function Balance () {
		/**
		 * @var QuarkModel|UserBalanceTransaction $balance
		 */
		$balance = QuarkModel::FindOne(
			new UserBalanceTransaction(),
			array(
				'user' => $this->id,
				'status' => UserBalanceTransaction::STATUS_FINISHED
			),
			array(
				QuarkSQL::OPTION_QUERY_REVIEWER => function ($query) {
					$query = str_replace('SELECT *', 'SELECT SUM(amount) AS amount', $query);
					//$query = str_replace('`UserBalanceTransaction`', '`UserBalanceTransaction` t', $query);
					$query = str_replace('LIMIT 1', 'GROUP BY user LIMIT 1', $query);

					return $query;
				}
			)
		);

		return $balance == null ? 0.0 : $balance->amount;
	}

	/**
	 * @param float $amount = 0.0
	 *
	 * @return QuarkModel|UserBalanceTransaction
	 */
	public function BalanceResupply ($amount = 0.0) {
		/**
		 * @var QuarkModel|UserBalanceTransaction $transaction
		 */
		$transaction = new QuarkModel(new UserBalanceTransaction());

		$transaction->user->value = $this->id;
		$transaction->amount = $amount;
		$transaction->status = UserBalanceTransaction::STATUS_FINISHED;

		return $transaction;
	}

	/**
	 * @param float $amount = 0.0
	 *
	 * @return float
	 */
	public static function BalanceRoyalty ($amount = 0.0) {
		return $amount == 0 ? 0.0 : $amount / 100 * 10;
	}

	/**
	 * @return QuarkCollection|User[]
	 */
	public function Followers () {
		return QuarkModel::Find(new User(), array(
			'leader' => $this->id
		));
	}

	/**
	 * @return QuarkModel|User
	 */
	public function Leader () {
		return $this->leader->value == null ? null : $this->leader->Retrieve();
	}

	/**
	 * @param string $code = ''
	 *
	 * @return QuarkModel|User
	 */
	public static function FindLeader ($code = '') {
		if ($code == '') return null;

		$promo = explode('-', $code);

		return sizeof($promo) != 2 ? null : QuarkModel::FindOne(new User(), array(
			'id' => (int)$promo[0],
			'promo' => $promo[1]
		));
	}
}