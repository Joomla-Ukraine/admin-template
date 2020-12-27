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

// No direct access.
defined('_JEXEC') or die;

$app        = JFactory::getApplication();
$tpl_params = $app->getTemplate(true)->params;

?>
<ul class="tm-sidebar-nav uk-nav uk-nav-default"<?php
$tag = '';
if($params->get('tag_id') != null)
{
	$tag = $params->get('tag_id') . '';
	echo ' id="' . $tag . '"';
}
?>>
	<?php
	foreach($list as $i => &$item) :

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
			$icon = '<span uk-icon="icon: ' . $item->anchor_css . ($item->level > 2 ? '; ratio: 0.8' : '') . '"' . ($item->level == 2 ? ' class="uk-margin-small-right uk-text-middle "' : '') . '></span> ';
		}

		$adm_icon = '';
		if($item->access == '3' && $item->level <= $tpl_params[ 'access_level' ] && $tpl_params[ 'access_icon' ] == 1)
		{
			$adm_icon = ' <span class="tm-label-sidebar uk-text-top"><i uk-icon="icon: lock; ratio: .75"></i></span>';
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
