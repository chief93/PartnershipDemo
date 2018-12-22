<?php
/**
 * Created by PhpStorm.
 * User: alex0
 * Date: 18.12.2018
 * Time: 0:06
 *
 * @var QuarkView|CreateView $this
 * @var QuarkModel|User $user
 * @var QuarkModel|User $leader
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\User\CreateView;
?>
<div class="quark-presence-screen" id="ps-user-create">
	<div class="quark-presence-container ps-container">
		<form class="quark-presence-column" action="/user/create<?php echo $leader == null ? '' : '/' . $leader->id . '-' . $leader->promo; ?>" method="POST">
			<h1>Registration</h1>
			Fill in the fields below to create a new user account<br />
			<br />
			<?php
			if ($leader != null)
				echo '<div class="quark-message info fa fa-info-circle">You have been using the invite provided by <b>', $leader->email, '</b>.</div><br />';

			if (isset($error)) {
				if ($error == 'user')
					echo '<div class="quark-message fatal fa fa-times">There is a database error occurred during creating user account</div><br />';
			}
			?>
			<input class="quark-input" name="email" value="<?php echo $user->email; ?>" placeholder="E-mail" /><?php echo $this->FieldError($user, 'email'); ?><br />
			<br />
			<input class="quark-input" name="password" placeholder="Password" type="password" /><?php echo $this->FieldError($user, 'password'); ?><br />
			<input class="quark-input" name="password_confirm" placeholder="Password confirmation" type="password" /><?php echo $this->FieldError($user, 'password_confirm'); ?><br />
			<br />
			<button class="quark-button block ok" type="submit">Register</button>
		</form>
	</div>
</div>