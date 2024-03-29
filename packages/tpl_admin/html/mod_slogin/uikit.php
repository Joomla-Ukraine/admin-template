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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

?>
<div class="jlslogin">

	<?php if($type === 'logout') : ?>
		<form action="<?php echo Route::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">

			<?php if($params->get('slogin_link_auch_edit', 1) == 1) : ?>
				<a href="<?php echo Route::_('index.php?option=com_users&view=profile&layout=edit'); ?>"><?php echo Text::_('MOD_SLOGIN_EDIT_YOUR_PROFILE'); ?></a>
			<?php endif; ?>

			<?php if($params->get('slogin_link_profile', 1) == 1) : ?>
				<a href="<?php echo Route::_('index.php?option=com_slogin&view=fusion'); ?>"><?php echo Text::_('MOD_SLOGIN_EDIT_YOUR_SOCIAL_AUCH'); ?></a>
			<?php endif; ?>

			<?php if($show_fusion_form == 1) : ?>
				<ul class="uk-child-width-expand uk-grid-small uk-grid" data-uk-grid>
					<li>
						<div class="uk-text-success uk-margin"><?php echo Text::_('TPL_ADMIN_DETACH_PROVIDERS_MODULE') ?></div>
						<div id="slogin-buttons-unattach" class="slogin-buttons slogin-compact">
							<?php foreach($unattachedProviders as $provider) : ?>
								<a href="<?php echo Route::_($provider[ 'link' ]); ?>" title="<?php echo $provider[ 'plugin_title' ]; ?>">
									<span class="<?php echo $provider[ 'class' ]; ?>">&nbsp;</span>
								</a>
							<?php endforeach; ?>
						</div>
					</li>
					<li>
						<div class="uk-text-warning uk-margin"><?php echo Text::_('TPL_ADMIN_ATTACH_PROVIDERS_MODULE') ?></div>
						<div id="slogin-buttons-attach" class="slogin-buttons slogin-compact">
							<?php
							foreach($attachedProviders as $provider) :

								if($provider[ 'plugin_name' ] === 'ulogin')
								{
									continue;
								}

								$linkParams = '';
								if(isset($provider[ 'params' ]))
								{
									foreach($provider[ 'params' ] as $k => $v)
									{
										$linkParams .= ' ' . $k . '="' . $v . '"';
									}
								}
								?>
								<a <?php echo $linkParams; ?> href="<?php echo Route::_($provider[ 'link' ]); ?>" title="<?php echo $provider[ 'plugin_title' ]; ?>">
									<span class="<?php echo $provider[ 'class' ]; ?>">&nbsp;</span>
								</a>
							<?php endforeach; ?>
						</div>
					</li>
					<li class="uk-width-auto uk-text-right">
						<?php
						$logout = 'index.php?option=com_users&task=user.logout&' . Session::getFormToken() . '=1&return=' . base64_encode(Uri::base() . 'account');
						?>
						<a href="<?php echo $logout; ?>" class="uk-button uk-button-default uk-button-small uk-margin-large-top">
							<?php echo Text::_('TPL_ADMIN_LOGOUT'); ?>
						</a>
					</li>
				</ul>
			<?php endif; ?>
		</form>
	<?php else : ?>
		<?php if($params->get('inittext')): ?>
			<div class="pretext">
				<p><?php echo $params->get('inittext'); ?></p>
			</div>
		<?php endif; ?>
		<div id="slogin-buttons" class="slogin-buttons slogin-default">

			<?php if(count($plugins)): ?>
				<?php
				foreach($plugins as $link):
					$linkParams = '';
					if(isset($link[ 'params' ]))
					{
						foreach($link[ 'params' ] as $k => $v)
						{
							$linkParams .= ' ' . $k . '="' . $v . '"';
						}
					}
					$title = !empty($link[ 'plugin_title' ]) ? ' title="' . $link[ 'plugin_title' ] . '"' : '';
					?>
					<a rel="nofollow" class="link<?php echo $link[ 'class' ]; ?>" <?php echo $linkParams . $title; ?> href="<?php echo Route::_($link[ 'link' ]); ?>"><span class="<?php echo $link[ 'class' ]; ?> slogin-ico">&nbsp;</span><span class="text-socbtn"><?php echo $link[ 'plugin_title' ]; ?></span></a>
				<?php endforeach; ?>
			<?php endif; ?>

		</div>
		<div class="slogin-clear"></div>
		<?php if($params->get('pretext')): ?>
			<div class="pretext">
				<p><?php echo $params->get('pretext'); ?></p>
			</div>
		<?php endif; ?>
		<?php if($params->get('show_login_form')): ?>
			<form action="<?php echo Route::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
				<fieldset class="userdata">
					<p id="form-login-username">
						<label for="modlgn-username"><?php echo Text::_('MOD_SLOGIN_VALUE_USERNAME') ?></label>
						<input id="modlgn-username" type="text" name="username" class="inputbox" size="18" />
					</p>
					<p id="form-login-password">
						<label for="modlgn-passwd"><?php echo Text::_('JGLOBAL_PASSWORD') ?></label>
						<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" />
					</p>
					<?php if(PluginHelper::isEnabled('system', 'remember')) : ?>
						<p id="form-login-remember">
							<label for="modlgn-remember">
								<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" />
								<?php echo Text::_('MOD_SLOGIN_REMEMBER_ME') ?>
							</label>
						</p>
						<div class="slogin-clear"></div>
					<?php endif; ?>
					<input type="submit" name="Submit" class="button" value="<?php echo Text::_('JLOGIN') ?>" />
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo HTMLHelper::_('form.token'); ?>
				</fieldset>
				<ul class="ul-jlslogin">
					<li>
						<a rel="nofollow" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
							<?php echo Text::_('MOD_SLOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
					</li>
					<li>
						<a rel="nofollow" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
							<?php echo Text::_('MOD_SLOGIN_FORGOT_YOUR_USERNAME'); ?></a>
					</li>
					<?php
					$usersConfig = ComponentHelper::getParams('com_users');
					if($usersConfig->get('allowUserRegistration')) : ?>
						<li>
							<a rel="nofollow" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
								<?php echo Text::_('MOD_SLOGIN_REGISTER'); ?></a>
						</li>
					<?php endif; ?>
				</ul>
				<?php if($params->get('posttext')): ?>
					<div class="posttext">
						<p><?php echo $params->get('posttext'); ?></p>
					</div>
				<?php endif; ?>
			</form>
		<?php endif; ?>
	<?php endif; ?>
</div>
