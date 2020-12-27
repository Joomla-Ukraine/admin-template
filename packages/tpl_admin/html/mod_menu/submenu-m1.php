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


defined('_JEXEC') or die;

?>
<ul class="uk-grid-collapse uk-child-width-1-3 uk-nav uk-dropdown-nav" uk-grid>
	<?php
	foreach($list as $i => &$item)
	{
		echo '<li>';

		switch($item->type) :
			case 'separator':
			case 'url':
			case 'component':
				require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
				break;
			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				break;
		endswitch;

		if($item->deeper)
		{
			echo '<ul>';
		}
		elseif($item->shallower)
		{
			echo '</li>';
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		else
		{
			echo '</li>';
		}
	}

	?>
</ul>