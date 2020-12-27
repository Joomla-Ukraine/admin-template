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

defined('_JEXEC') or die;

?>
<ul class="d-mobile-menu uk-nav uk-nav-default">
	<li class="uk-nav-header"><?php echo Factory::getApplication()->get('sitename'); ?></li>
	<?php foreach($list as $i => &$item)
	{
		$class = 'item-' . $item->id;

		if($item->id == $default_id)
		{
			$class .= ' default';
		}

		if($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id))
		{
			$class .= ' current';
		}

		if(in_array($item->id, $path))
		{
			$class .= ' uk-active';
		}
		elseif($item->type === 'alias')
		{
			$aliasToId = $item->params->get('aliasoptions');

			if(count($path) > 0 && $aliasToId == $path[ count($path) - 1 ])
			{
				$class .= ' uk-active';
			}
			elseif(in_array($aliasToId, $path))
			{
				$class .= ' alias-parent-active uk-parent';
			}
		}

		if($item->type === 'separator')
		{
			$class .= ' uk-nav-divider';
		}

		if($item->deeper)
		{
			$class .= ' deeper';
		}

		if($item->parent)
		{
			$class .= ' uk-parent';
		}

		echo '<li class="' . $class . '">';

		switch($item->type) :
			case 'separator':
			case 'component':
			case 'heading':
			case 'url':
				require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				break;
		endswitch;

		if($item->deeper)
		{
			echo '<ul class="uk-nav-sub">';
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