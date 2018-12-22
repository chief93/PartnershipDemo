<?php
namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

use App\Models\User;

/**
 * https://stackoverflow.com/questions/42704782/changing-laravel-5-4-password-encryption-and-table-column-names
 *
 * Class PSUserProvider
 *
 * @package App\Providers
 */
class PSUserProvider extends EloquentUserProvider {
	/**
	 * @param Authenticatable  $user
	 * @param array $credentials
	 *
	 * @return bool
	 */
	public function validateCredentials (Authenticatable $user, array $credentials) {
		return $user->getAuthPassword() == User::Password($credentials['email'], $credentials['password']);
	}
}