<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2020 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          GNU General Public License version 2 or later
 */


defined('_JEXEC') or die();

?>
<?php if($type != 'logout') : ?>
	<div class="uk-card tm-box-border uk-margin-medium-bottom">

		<?php if($params->get('inittext')): ?>
			<h4 class="uk-h4 uk-text-center">
				<?php echo $params->get('inittext'); ?>
			</h4>
		<?php endif; ?>

		<ul id="slogin-buttons" class="uk-flex uk-flex-center uk-text-center uk-child-width-1-2 uk-child-width-auto@m uk-grid-small" uk-grid>
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

					switch($link[ 'plugin_name' ])
					{
						case 'facebook':
							$p_class = 'tm-share-fb';
							$p_icon  = 'facebook';
							break;

						case 'google':
							$p_class = 'tm-share-gp';
							$p_icon  = 'google-plus';
							break;

						case 'twitter':
							$p_class = 'tm-share-tw';
							$p_icon  = 'twitter';
							break;

						case 'vkontakte':
							$p_class = 'tm-share-vk';
							$p_icon  = 'tm-vk';
							break;

						case 'linkedin':
							$p_class = 'tm-share-li';
							$p_icon  = 'linkedin';
							break;
					}

					?>
					<li>
						<a class="uk-button uk-button-small <?php echo $p_class; ?> uk-width-1-1 uk-width-auto@m" href="<?php echo JRoute::_($link[ 'link' ]); ?>" rel="nofollow" <?php echo $linkParams; ?>>
							<small><span class="uk-margin-small-top" uk-icon="icon: <?php echo $p_icon; ?>; ratio: 1.5"></span><br><?php echo $link[ 'plugin_title' ]; ?>
							</small>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>

		<?php if($params->get('pretext')): ?>
			<p class="tm-text-medium tm-text-grey uk-margin uk-margin-remove-bottom uk-text-center">
				<?php echo $params->get('pretext'); ?>
			</p>
		<?php endif; ?>

		<?php if($params->get('show_login_form')): ?>
			<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
				<fieldset class="userdata">
					<p id="form-login-username">
						<label for="modlgn-username"><?php echo JText::_('MOD_SLOGIN_VALUE_USERNAME') ?></label>
						<input id="modlgn-username" type="text" name="username" class="inputbox" size="18" />
					</p>
					<p id="form-login-password">
						<label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
						<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" />
					</p>
					<?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
						<p id="form-login-remember">
							<label for="modlgn-remember">
								<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" />
								<?php echo JText::_('MOD_SLOGIN_REMEMBER_ME') ?>
							</label>
						</p>
						<div class="slogin-clear"></div>
					<?php endif; ?>
					<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</fieldset>
				<ul class="ul-jlslogin">
					<li>
						<a rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
							<?php echo JText::_('MOD_SLOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
					</li>
					<li>
						<a rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
							<?php echo JText::_('MOD_SLOGIN_FORGOT_YOUR_USERNAME'); ?></a>
					</li>
					<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if($usersConfig->get('allowUserRegistration')) : ?>
						<li>
							<a rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
								<?php echo JText::_('MOD_SLOGIN_REGISTER'); ?></a>
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
	</div>
<?php endif; ?>