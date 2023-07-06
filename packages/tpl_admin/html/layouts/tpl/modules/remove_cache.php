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

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

?>
<?php if($data->params->get('remove_cache', 0) == 1 && (in_array('7', $data->user->groups) || in_array('8', $data->user->groups))): ?>
	<ul class="uk-navbar-nav">
		<li class="uk-active uk-flex-middle">
			<a href="#" id="remove_cache">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'comet',
					'size'  => 24,
					'class' => 'uk-text-danger tm-margin-xsmall-right'
				]);
				?>
				<span class="uk-text-middle uk-text-danger"><?php echo Text::_('TPL_ADMIN_CACHE_DELETE'); ?></span>
			</a>
		</li>
	</ul>
<?php endif; ?>