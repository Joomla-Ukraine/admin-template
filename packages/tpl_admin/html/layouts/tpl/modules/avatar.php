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
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

$query = $data->db->getQuery(true);
$query->select([ 'avatar' ]);
$query->from('#__cck_store_item_users');
$query->where($data->db->quoteName('id') . ' = ' . $data->db->quote((int) $data->user->id));
$data->db->setQuery($query);
$avatar = $data->db->loadResult();

if(!$avatar)
{
	$avatar = 'templates/admin/app/img/user.svg';
}

$avatar  = '<img src="' . $data->baseurl . '/' . $avatar . '" width="30" height="30" class="uk-border-circle uk-margin-small-right" alt="' . $data->user->name . '" title="' . $data->user->name . '">';
$profile = (new FileLayout('tpl.modules.profile'))->render([
	'params' => $data->params,
	'user'   => $data->user
]);
$logout  = 'index.php?option=com_users&task=user.logout&' . Session::getFormToken() . '=1&return=' . base64_encode(Uri::base() . 'account');

?>
<a href="#" class="uk-navbar-toggle">
	<span class="uk-inline uk-margin-small-right tm-status">
		<?php echo $avatar; ?>
		<span id="status" data-enabled="true" data-interval="60000" class="tm-status-bull uk-position-top-right uk-label uk-label-success"></span>
	</span>
	<span class="uk-margin-small-right uk-visible@s tm-font-xxxsmall"><?php echo($data->params->get('username', 0) == 0 ? $data->user->name : $data->user->email); ?></span>
	<?php
	echo (new FileLayout('tpl.icon'))->render([
		'icon'  => 'chevron-down',
		'class' => 'uk-visible@s'
	]);
	?>
</a>

<div class="uk-width-1-1@s uk-width-1-6@m uk-background-default uk-box-shadow-medium uk-border-rounded" data-uk-drop="pos: bottom-right; mode: click; offset: -1;">
	<ul class="uk-nav uk-dropdown-nav">
		<li>
			<a href="<?php echo $profile; ?>">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'user',
					'class' => 'uk-margin-small-right'
				]);
				?>
				<span class="uk-text-middle"><?php echo Text::_('TPL_ADMIN_PROFILE'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo $logout; ?>" class="uk-text-danger">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'logout-half-circle',
					'class' => 'uk-margin-small-right'
				]);
				?>
				<span class="uk-text-middle"><?php echo Text::_('TPL_ADMIN_LOGOUT'); ?></span>
			</a>
		</li>
	</ul>
</div>
