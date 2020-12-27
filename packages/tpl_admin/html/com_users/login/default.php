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

use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$cookieLogin = $this->user->get('cookieLogin');

?>
<?php if($this->user->get('guest') || !empty($cookieLogin)): ?>
	<?php echo $this->loadTemplate('login'); ?>
<?php else: ?>
	<?php
	$db   = Factory::getDBO();
	$user = Factory::getUser();

	$query = $db->getQuery(true);
	$query->select('avatar');
	$query->from('#__cck_store_item_users');
	$query->where('id = ' . $user->id);
	$db->setQuery($query);
	$_avatar = $db->loadResult();

	if(!$_avatar)
	{
		$_avatar = 'templates/admin/images/user.svg';
	}

	$avatar = '<img src="' . $this->baseurl . '/' . $_avatar . '" class="uk-border-circle" width="110" alt="' . $user->name . '" title="' . $user->name . '">';

	$logout = 'index.php?option=com_users&task=user.logout&' . Session::getFormToken() . '=1&return=' . base64_encode(URI::base() . 'account');

	?>
	<div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin">
		<div class="uk-grid-divider uk-child-width-1-1@s uk-margin-medium uk-grid" uk-grid>
			<div class="uk-width-2-3@m uk-width-1-2@l uk-width-1-3@xl">
				<ul class="uk-child-width-expand uk-grid-medium uk-grid" uk-grid>
					<li class="uk-width-auto uk-margin-small-right">
						<?php echo $avatar; ?>
					</li>
					<li>
						<h3 class="uk-card-title uk-margin-remove">
							<?php echo jText::_('TPL_ADMIN_HELLO'); ?>, <?php echo $user->name; ?>!
						</h3>
						<div class="uk-margin-small-top uk-margin">
							<?php
							$grp_name = [];
							foreach($user->groups as $group)
							{
								$query = $db->getQuery(true);
								$query->select($db->quoteName('title'))->from('#__usergroups')->where($db->quoteName('id') . ' = ' . $db->quote((int) $group));
								$db->setQuery($query);
								$grp = $db->loadResult();

								switch($group)
								{
									case '8':
									case '7':
										$color = '-danger';
										break;
									case '10':
										$color = '-warning';
										break;
									case '11':
										$color = '-success';
										break;
									case '2':
										$color = '';
										break;
								}

								$grp_name[] = '<span class="uk-label uk-label' . $color . ' uk-label-small">' . $grp . '</span>';
							}

							echo implode(' ', $grp_name);
							?>
							<div class="uk-margin-small">
								<?php
								$app      = Factory::getApplication('site');
								$template = $app->getTemplate('tpl_admin');

								if($template->params->get('edit_profile') == 1)
								{
									$profile = $template->params->get('edit_profile_link') . $user->id . '&return=' . base64_encode(JURI::base() . 'account');
								}
								else
								{
									$profile = JRoute::_('index.php?option=com_users&view=profile&layout=edit');
								}

								?>
								<a href="<?php echo $profile; ?>" class="uk-button uk-button-default uk-button-small"><?php echo jText::_('TPL_ADMIN_PROFILE'); ?></a>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="uk-width-1-3@m uk-width-1-2@l uk-width-2-3@xl">
				<?php
				if($mods = JModuleHelper::getModules('account_slogin'))
				{
					foreach($mods as $mod)
					{
						echo JModuleHelper::renderModule($mod, [ 'style' => 'ukDividerSmall2Green' ]);
					}
				}
				else
				{
					?>
					<div class="uk-text-right">
						<a href="<?php echo $logout; ?>" class="uk-button uk-button-default uk-button-small">
							<?php echo jText::_('TPL_ADMIN_LOGOUT'); ?>
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>

	<?php
	if($mods = JModuleHelper::getModules('main_panel'))
	{
		echo '<div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin">';
		foreach($mods as $mod)
		{
			echo JModuleHelper::renderModule($mod, [ 'style' => 'main_panel' ]);
		}
		echo '</div>';
	}

	if($mods = JModuleHelper::getModules('account_main'))
	{
		echo '<ul class="uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@xl uk-margin-medium uk-grid-medium uk-grid" uk-grid uk-height-match="target: > div > .uk-card">';
		foreach($mods as $mod)
		{
			echo JModuleHelper::renderModule($mod, [ 'style' => 'main' ]);
		}
		echo '</ul>';
	}
	?>
<?php endif; ?>