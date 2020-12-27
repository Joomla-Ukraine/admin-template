<?php
/**
 * Bad Android Template
 *
 * @package          Joomla.Site
 * @subpackage       a
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2016-2019 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
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

