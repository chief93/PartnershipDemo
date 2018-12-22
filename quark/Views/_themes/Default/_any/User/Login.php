<?php
/**
 * Created by PhpStorm.
 * User: alex0
 * Date: 17.12.2018
 * Time: 23:55
 *
 * @var QuarkView|LoginView $this
 */
use Quark\QuarkView;

use ViewModels\User\LoginView;
?>
<div class="quark-presence-screen" id="ps-user-login">
	<div class="quark-presence-container ps-container">
		<form class="quark-presence-column" action="/user/login" method="POST">
			<h1>Authorization</h1>
			Use your authorization credentials for signing in<br />
			<br />
			<input class="quark-input" name="email" placeholder="E-mail" /><br />
			<input class="quark-input" name="password" type="password" placeholder="Password" /><br />
			<br />
			<button class="quark-button block ok">Log in</button>
		</form>
	</div>
</div>