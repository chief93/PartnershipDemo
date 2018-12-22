<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as AbstractUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class User
 *
 * https://laravel.io/forum/05-21-2014-how-to-disable-remember-token
 * https://stackoverflow.com/a/38689351/2097055
 * https://stackoverflow.com/questions/22297240/temporary-property-for-laravel-eloquent-model
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property User|int $leader
 * @property string $promo
 *
 * @property string $password_clear
 * @property string $password_confirmation
 *
 * @package App\Models
 */
class User extends AbstractUser {
	const PASSWORD_LENGTH_MIN = 8;
	const PROMO_LENGTH = 8;

	use Notifiable;

	/**
	 * @var string $_passwordClear = ''
	 */
	private $_passwordClear = '';

	/**
	 * @return string
	 */
	public function getPassword_clear () {
		return $this->_passwordClear;
	}

	/**
	 * @param $value
	 */
	public function setPassword_clear ($value) {
		$this->_passwordClear = $value;
	}

	/**
	 * @return string
	 */
	public function getPassword_confirmation () {
		return $this->_passwordClear;
	}

	/**
	 * @param $value
	 */
	public function setPassword_confirmation ($value) {
		$this->_passwordClear = $value;
	}

	/**
	 * @var string $_passwordConfirmation = ''
	 */
	private $_passwordConfirmation = '';

	/**
	 * @var string[] $fillable
	 */
	protected $fillable = array(
		'email',
		'password'
	);

	/**
	 * https://stackoverflow.com/a/35861719/2097055
	 *
	 * @var array $rules
	 */
	protected $rules = array(
		'email' => array('required', 'string', 'email', 'unique:User'),
		'password' => array('required', 'string', 'min:' . self::PASSWORD_LENGTH_MIN)
	);

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = array(
		'password',
		'created_at',
		'leader',
		'promo'
	);

	/**
	 * @var string $table = 'User'
	 */
	public $table = 'User';

	/**
	 * @var bool $timestamps = false
	 */
	public $timestamps = false;

	/**
	 * @param string $value
	 */
	public function setPasswordAttribute ($value) {
		$this->attributes['password'] = self::Password($this->attributes['email'], $value);
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
	 * @return null
	 */
	public function getRememberToken () {
		return null; // mark as not supported
	}

	/**
	 * @param string $value
	 */
	public function setRememberToken ($value) {
		// mark as not supported
	}

	/**
	 * @return null
	 */
	public function getRememberTokenName () {
		return null; // mark as not supported
	}

	/**
	 * @param string $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public function setAttribute ($key, $value) {
		$exclude = array(
			$this->getRememberTokenName(),
			'password_clear',
			'password_confirmation'
		);

		if (!in_array($key, $exclude))
			parent::setAttribute($key, $value);

		if ($key == 'password')
			$this->_passwordClear = $value;

		if ($key == 'password_confirmation')
			$this->_passwordConfirmation = $value;
	}

	/**
	 * https://stackoverflow.com/a/20953235/2097055
	 *
	 * User -> User(leader) relation
	 */
	public function leader () {
		return $this->belongsTo('App\Models\User', 'leader');
	}

	/**
	 * @return User[]
	 */
	public function followers () {
		return $this->hasMany('App\Models\User', 'leader', 'id');
	}

	/**
	 * ORM callbacks
	 */
	public static function boot () {
		parent::boot();

		self::creating(function (User $user) {
			$user->created_at = gmdate('Y-m-d H:i:s');
			$user->promo = self::Promo(self::PROMO_LENGTH);
		});
	}

	/**
	 * @return array
	 */
	public function Validate () {
		$attributes = $this->attributes + array(
			'password_clear' => $this->_passwordClear,
			'password_confirmation' => $this->_passwordConfirmation
		);

		$rules = $this->rules + array(
			'password_clear' => array('required', 'string', 'min:8'),
			'password_confirmation' => array('required', 'string', 'same:password_clear')
		);

		return Validator::make($attributes, $rules)->validate();
	}

	/**
	 * https://laravel.com/docs/5.7/queries
	 *
	 * @return float
	 */
	public function Balance () {
		$balance = DB::table('UserBalanceTransaction')
			->select(DB::raw('SUM(amount) AS amount'))
			->where('user', '=', $this->id)
			->where('status', '=', UserBalanceTransaction::STATUS_FINISHED)
			->groupBy('user')
			->limit(1)
			->get();

		return $balance == null || sizeof($balance) == 0 ? 0.0 : $balance[0]->amount;
	}

	/**
	 * @param float $amount = 0.0
	 *
	 * @return UserBalanceTransaction
	 */
	public function BalanceResupply ($amount = 0.0) {
		$transaction = new UserBalanceTransaction();

		$transaction->date = gmdate('Y-m-d H:i:s');
		$transaction->user = $this->id;
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
	 * https://laracasts.com/discuss/channels/eloquent/how-to-select-single-field-and-get-a-single-result-with-eloquent-no-id-know
	 *
	 * @param string $code = ''
	 *
	 * @return User
	 */
	public static function FindLeader ($code = '') {
		if ($code == '') return null;

		$promo = explode('-', $code);

		return sizeof($promo) != 2
			? null
			: self::where('id', '=', (int)$promo[0])
				  ->where('promo', '=', $promo[1])
				  ->first();
	}
}