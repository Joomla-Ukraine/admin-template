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

<ul class="<?php echo $class_sfx; ?>"
        <?php
		$tag = '';
		if($params->get('tag_id') != null)
		{
			$tag = $params->get('tag_id') . '';
			echo ' id="' . $tag . '"';
		}
		?>>
	<?php
	$j = 0;
	foreach($list as $i => &$item)
	{
		if($j <= 7)
		{
			$class = 'item-' . $item->id;
			if($item->id == $active_id)
			{
				$class .= ' current';
			}

			if(in_array($item->id, $path))
			{
				$class .= ' active';
			}
            elseif($item->type == 'alias')
			{
				$aliasToId = $item->params->get('aliasoptions');
				if(count($path) > 0 && $aliasToId == $path[count($path) - 1])
				{
					$class .= ' active';
				}
                elseif(in_array($aliasToId, $path))
				{
					$class .= ' alias-parent-active';
				}
			}

			if($item->deeper)
			{
				$class .= ' deeper';
			}

			if($item->parent)
			{
				$class .= ' parent';
			}

			if(!empty($class))
			{
				$class = ' class="' . trim($class) . '"';
			}

			echo '<li' . $class . '>';

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

		$next = 0;
		if($i > 7)
		{
			$next = 1;
		}
		$j++;
	}
	?>
    <li class=" ">
        <a class="uk-navbar-item uk-navbar-toggle uk-text-danger">
            <i uk-icon="icon: chevron-down; ratio: 1.1"></i>
        </a>
	    <?php if($next == 1) : ?>
            <nav uk-dropdown="mode: click; pos: bottom-justify; boundary: .boundary-topic; boundary-align: true">
                <ul class="uk-grid-collapse uk-child-width-1-5@m uk-nav uk-dropdown-nav" uk-grid>
				    <?php
				    $j = 0;
				    foreach($list as $i => &$item)
				    {
					    if($j > 7)
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
					    $j++;
				    }
				    ?>
                </ul>
            </nav>
	    <?php endif; ?>

    </li>
</ul>

