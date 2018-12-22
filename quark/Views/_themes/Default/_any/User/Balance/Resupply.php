<?php
/**
 * Created by PhpStorm.
 * User: alex0
 * Date: 18.12.2018
 * Time: 1:41
 *
 * @var QuarkView|ResupplyView $this
 * @var QuarkModel|UserBalanceTransaction $transaction
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\UserBalanceTransaction;

use ViewModels\User\Balance\ResupplyView;
?>
<div class="quark-presence-screen" id="ps-user-balance-resupply">
	<div class="quark-presence-container ps-container">
		<form class="quark-presence-column" action="/user/balance/resupply" method="POST">
			<h1>Balance resupply</h1>
			This is a placeholder resupplier, just enter a desired amount of money for adding them to your balance<br />
			<br />
			<?php
			if (isset($error)) {
				if ($error == 'transaction')
					echo '<div class="quark-message fatal fa fa-times">There is a database error occurred during initiating balance transaction</div><br />';
			}
			?>
			<input class="quark-input" name="amount" placeholder="Amount" /><?php echo $this->FieldError($transaction, 'amount'); ?><br />
			<br />
			<?php echo $this->Signature(); ?>
			<button class="quark-button block ok" type="submit">Add</button>
		</form>
	</div>
</div>