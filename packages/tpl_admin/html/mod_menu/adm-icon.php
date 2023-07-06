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

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;

$app        = Factory::getApplication();
$tpl_params = $app->getTemplate(true)->params;

?>
<ul class="tm-sidebar-nav uk-nav uk-nav-default">
	<?php
	foreach($list as $i => $item) :

		$class = '';
		$attr  = '';

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
				$class .= '';
			}
		}

		if($item->parent)
		{
			$class .= ' uk-parent';
		}

		if($item->type === 'separator')
		{
			if($item->title === 'separator')
			{
				$class .= ' divider';
			}
			else
			{
				$class .= ' uk-nav-header';
			}
		}

		if(!empty($class))
		{
			$class = ' class="' . trim($class) . '"';
		}

		$icon = '';
		if($item->anchor_css)
		{
			$_icon_class = [];
			if($item->level == 2)
			{
				$_icon_class = [ 'class' => 'tm-margin-xsmall-right uk-text-middle' ];
			}

			$_icon_size = [];
			if($item->level == 2)
			{
				$_icon_size = [ 'size' => 19 ];
			}

			$icon = (new FileLayout('tpl.icon'))->render(array_merge([
				'icon' => $item->anchor_css
			], $_icon_class, $_icon_size));
		}

		$adm_icon = '';
		if($item->access == '3' && $item->level <= $tpl_params[ 'access_level' ] && $tpl_params[ 'access_icon' ] == 1)
		{
			$_adm_icon = (new FileLayout('tpl.icon'))->render([
				'icon' => 'lock',
				'size' => 17
			]);
			$adm_icon  = ' <span class="tm-label-sidebar uk-text-top">' . $_adm_icon . '</span>';
		}

		echo '<li' . $class . '>';

		// Render the menu item.
		switch($item->type) :
			case 'separator':
			case 'url':
			case 'component':
				require JModuleHelper::getLayoutPath('mod_menu', 'adm-icon_' . $item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'adm-icon_url');
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
	endforeach;
	?>
</ul>
