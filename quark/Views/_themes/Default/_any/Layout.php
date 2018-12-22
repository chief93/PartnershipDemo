<?php
/**
 * Created by PhpStorm.
 * User: alex0
 * Date: 17.12.2018
 * Time: 22:44
 *
 * @var QuarkView|LayoutView $this
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\LayoutView;

/**
 * @var QuarkModel|User $user
 */
$user = $this->User();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->PSTitle(); ?></title>

	<?php echo $this->Resources(); ?>
</head>
<body>
	<div class="quark-presence-screen" id="ps-header">
		<div class="quark-presence-container ps-container">
			<a class="quark-presence-column left" id="ps-header-logo" href="/">
				Partnership
			</a>
			<div class="quark-presence-column right" id="ps-header-user">
				<div class="quark-presence-container">
				<?php
				echo $user == null
					? '
						<a class="quark-button" href="/user/create">Register</a>
						<a class="quark-button" href="/user/login">Log in</a>
					'
					: ('
						<h4><a class="quark-button" href="/user" title="User profile">' . $user->email . '</a></h4>
						<a class="quark-button" href="'. $this->Link('/user/logout', true) . '">Exit</a>
					');
				?>
				</div>
			</div>
		</div>
	</div>

	<?php echo $this->View(); ?>

	<div class="quark-presence-screen" id="ps-footer">
		<div class="quark-presence-container ps-container"
	</div>
</body>
</html>