<?php
/**
 * Seblod Admin Template
 *
 * @version       2.x
 * @package       admin
 * @author        Denys D. Nosov (denys@joomla-ua.org)
 * @copyright (C) 2018-2023 by Denys D. Nosov (https://joomla-ua.org)
 * @license       GNU General Public License version 2 or later; see LICENSE.md
 *
 **/

defined('_JEXEC') or die;

use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;

require_once __DIR__ . '/inc/head.php';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
	<jdoc:include type="head" />
</head>
<body>
<main class="uk-container-expand">
	<div class="uk-grid-collapse" data-uk-grid data-uk-height-viewport="offset-top: true; offset-bottom: 0">

		<?php if(!$user->guest): ?>
			<aside class="tm-sidebar-left tm-bg-bluedark uk-width-auto uk-position-relative <?php echo($ac_edit == 0 ? 'uk-visible@m' : 'uk-visible@xl'); ?>">
				<div class="tm-sidebar-padding">
					<h1 class="uk-h3 tm-logo uk-light">
						<a href="<?php echo URI::base(); ?>" class="uk-logo" target="_blank">
							<?php echo $logo; ?>
						</a>
					</h1>

					<?php
					echo (new FileLayout('tpl.modules.account_button'))->render([
						'params' => $this->params
					]);
					?>

					<?php if($this->countModules('account')): ?>
						<div class="uk-light uk-margin-small-top">
							<jdoc:include type="modules" name="account" style="raw" />
						</div>
					<?php endif; ?>
				</div>
			</aside>
		<?php endif; ?>

		<div class="uk-width-1-1@s uk-width-expand tm-container-expand">

			<div class="uk-navbar-container tm-navbar-container uk-margin-bottom uk-navbar-transparent uk-active">

				<div class="uk-container-expand">

					<?php if(!$user->guest && $this->countModules('account')): ?>
						<nav class="tm-navbar uk-navbar" data-uk-navbar>

							<div class="uk-navbar-left tm-navbar tm-font-xxxsmall">
								<a class="uk-navbar-toggle <?php echo($ac_edit == 0 ? 'uk-hidden@m' : 'uk-hidden@xl'); ?>" data-uk-toggle="target: #offcanvas">
									<?php
									echo (new FileLayout('tpl.icon'))->render([
										'icon' => 'menu',
										'size' => 48
									]);
									?>
								</a>

								<?php if($this->countModules('admin_lang')) : ?>
									<ul class="uk-navbar-nav uk-margin-left">
										<li class="uk-active uk-flex-middle">
											<jdoc:include type="modules" name="admin_lang" style="raw" />
										</li>
									</ul>
								<?php endif; ?>

								<?php
								echo (new FileLayout('tpl.modules.users_count'))->render([
									'params' => $this->params,
									'db'     => $db
								]);

								echo (new FileLayout('tpl.modules.remove_cache'))->render([
									'params' => $this->params,
									'user'   => $user
								]);
								?>

								<?php if($this->params->get('html_tm')): ?>
									<?php echo eval('?> ' . $this->params->get('html_tm')); ?>
								<?php endif; ?>

								<jdoc:include type="modules" name="admin_menu" style="raw" />
							</div>

							<div class="uk-navbar-right tm-navbar">
								<?php
								echo (new FileLayout('tpl.modules.avatar'))->render([
									'params'  => $this->params,
									'baseurl' => $this->baseurl,
									'user'    => $user,
									'db'      => $db
								]);
								?>
							</div>

						</nav>
					<?php endif; ?>

				</div>
			</div>

			<?php if(($user->guest && $option === 'com_users') || ($user->guest && $option === 'com_cck')): ?>
				<div class="uk-flex uk-flex-middle" data-uk-height-viewport>
					<div class="tm-container uk-width-2xlarge uk-align-center">
						<div class="uk-section-default uk-box-shadow-medium uk-padding-large uk-border-rounded">
							<h1 class="uk-h3">
								<a href="<?php echo URI::base(); ?>" target="_blank">
									<?php echo $logo2; ?>
								</a>
							</h1>
							<jdoc:include type="message" />
							<jdoc:include type="component" />
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="tm-container">
					<jdoc:include type="message" />
					<jdoc:include type="component" />
				</div>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php if(!$user->guest && $this->countModules('account')): ?>
	<aside class="uk-offcanvas" id="offcanvas" data-uk-offcanvas="overlay: true; mode: slide">
		<div class="uk-offcanvas-bar tm-sidebar-left tm-bg-bluedark">
			<button class="uk-offcanvas-close uk-light tm-button-link" type="button">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'close',
					'class' => 'tm-light',
					'size'  => 24
				]);
				?>
			</button>
			<div class="tm-sidebar-padding-bottom">
				<div class="uk-margin-small">
					<h1 class="uk-h3 uk-light">
						<a href="<?php echo URI::base(); ?>" class="uk-link-reset" target="_blank">
							<?php echo $logo; ?>
						</a>
					</h1>
				</div>
				<div class="uk-light uk-margin-small-top">
					<jdoc:include type="modules" name="account" style="raw" />
				</div>
			</div>
		</div>
	</aside>
<?php endif; ?>
</body>
</html>