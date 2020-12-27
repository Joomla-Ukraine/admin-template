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
<ul class="menu<?php echo $class_sfx; ?>"<?php
$tag = '';
if ($params->get('tag_id') != null)
{
	$tag = $params->get('tag_id') . '';
	echo ' id="' . $tag . '"';
}
?>>
	<li class="uk-padding-remove-right">
		<a class="uk-padding-remove-right" title="Быстрый переход на сайт">
			<span uk-icon="icon: forward" class="uk-text-success"></span>
		</a>
	</li>
	<?php
	foreach ($list as $i => &$item) :

		//if($item->route == 'home') continue;

		$class = 'item-' . $item->id;
		if ($item->id == $active_id)
		{
			$class .= ' current';
		}

		if (in_array($item->id, $path))
		{
			$class .= ' active';
		}
        elseif ($item->type === 'alias')
		{
			$aliasToId = $item->params->get('aliasoptions');
			if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
			{
				$class .= ' active';
			}
            elseif (in_array($aliasToId, $path))
			{
				$class .= ' alias-parent-active';
			}
		}

		if ($item->deeper)
		{
			$class .= ' deeper';
		}

		if ($item->parent)
		{
			$class .= ' parent';
		}

		if (!empty($class))
		{
			$class = ' class="' . trim($class) . '"';
		}

		echo '<li' . $class . '>';

		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
				require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				break;
		endswitch;

		// The next item is deeper.
		if ($item->deeper)
		{
			echo '<ul>';
		}
		// The next item is shallower.
        elseif ($item->shallower)
		{
			echo '</li>';
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else
		{
			echo '</li>';
		}
	endforeach;
	?></ul>
