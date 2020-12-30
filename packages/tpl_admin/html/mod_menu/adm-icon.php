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

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$app        = JFactory::getApplication();
$tpl_params = $app->getTemplate(true)->params;

?>
<ul class="tm-sidebar-nav uk-nav uk-nav-default">
	<?php
	foreach($list as $i => &$item)
	{
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
			$icon = '<svg width="20" height="20" ' . ($item->level == 2 ? 'class="uk-margin-small-right uk-text-middle "' : '') . ' aria-hidden="true"><use xlink:href="' . Uri::base() . 'templates/admin/assets/icons/icons.svg#' . $item->anchor_css . '"></use></svg>';
		}

		$adm_icon = '';
		if($item->access == '3' && $item->level <= $tpl_params[ 'access_level' ] && $tpl_params[ 'access_icon' ] == 1)
		{
			$adm_icon = ' <span class="tm-label-sidebar uk-text-top"><svg width="16" height="16" aria-hidden="true"><use xlink:href="' . Uri::base() . 'templates/admin/assets/icons/icons.svg#lock"></use></svg></span>';
		}

		echo '<li' . $class . '>';

		switch($item->type)
		{
			case 'separator':
			case 'url':
			case 'component':
				require JModuleHelper::getLayoutPath('mod_menu', 'adm-icon_' . $item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'adm-icon_url');
				break;
		}

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