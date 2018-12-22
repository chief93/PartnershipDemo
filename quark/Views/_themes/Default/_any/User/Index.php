<?php
/**
 * Created by PhpStorm.
 * User: alex0
 * Date: 18.12.2018
 * Time: 1:26
 *
 * @var QuarkView|IndexView $this
 * @var QuarkModel|User $user
 * @var QuarkModel|User $userLeader
 * @var QuarkCollection|User[] $userFollowers
 */
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\User\IndexView;

$promo = $this->WebLocation('/user/create/' . $user->id . '-' . $user->promo);
?>
<div class="quark-presence-screen">
	<div class="quark-presence-container ps-container">
		<div class="quark-presence-column" id="ps-user-index">
			<div class="quark-presence-container">
				<h1>User "<?php echo $user->email; ?>"</h1>
				<h4>Balance: <b><?php echo number_format($user->Balance(), 2); ?></b> <a class="quark-button quark-link" href="/user/balance/resupply">Resupply</a></a></h4>
				<br />
				<?php
				if ($userLeader == null)
					echo 'Promo link: <a class="quark-button quark-link inline" href="', $promo, '">', $promo, '</a>';
				?>
			</div>
			<div class="quark-presence-container" id="user-index-network">
				<h3>Network</h3>
				<div class="quark-presence-column" id="user-index-network-follower-list">
					<?php
					if ($userLeader != null) {
						echo '<div class="quark-message info fa fa-info-circle">This user has been invited by "', $userLeader->email, '", so he can not invite others</div>';
					}
					else {
						if (sizeof($userFollowers) == 0)
							echo '<div class="quark-message info fa fa-info-circle">There are no any followers of this user yet</div>';

						foreach ($userFollowers as $follower)
							echo '
								<div class="quark-presence-column materialized user-index-network-follower-list-item">
									<div class="quark-presence-container">
										<b>', $follower->email, '</b><br />
										', $follower->created_at->Format('d.m.Y H:i:s'), '
									</div>
								</div>
							';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>