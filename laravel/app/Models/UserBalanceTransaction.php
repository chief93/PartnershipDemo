<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBalanceTransaction
 *
 * https://laravel.com/docs/5.7/eloquent-relationships
 * https://laravel-news.com/eloquent-tips-tricks
 * https://scotch.io/tutorials/a-guide-to-using-eloquent-orm-in-laravel
 *
 * @property int $id
 * @property string $date
 * @property User|int $user
 * @property float $amount
 * @property string $status
 *
 * @package App\Models
 */
class UserBalanceTransaction extends Model {
	const STATUS_INIT = 'init';
	const STATUS_FINISHED = 'finished';

	/**
	 * @var string $table = 'UserBalanceTransaction'
	 */
	protected $table = 'UserBalanceTransaction';

	/**
	 * @var string[] $fillable
	 */
	protected $fillable = array(
		'amount'
	);

	/**
	 * @var string[] $hidden
	 */
	protected $hidden = array(
		'date',
		'user',
		'status'
	);

	/**
	 * https://stackoverflow.com/a/19937699/2097055
	 *
	 * @var bool $timestamps = false
	 */
	public $timestamps = false;

	/**
	 * User -> Balance relation
	 */
	public function user () {
		$this->belongsTo('App\Models\User', 'user');
	}
}