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

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;



$tab_class = '';
if(isset($data->tab_class))
{
	$tab_class = ' class="' . $data->tab_class . '"';
}

$tab_ul_class = '';
if(isset($data->tab_ul_class))
{
	$tab_ul_class = ' class="' . $data->tab_ul_class . '"';
}

$tab_panel_class = '';
if(isset($data->tab_panel_class))
{
	$tab_panel_class = ' class="' . $data->tab_panel_class . '"';
}

$tab_item_class = '';
if(isset($data->tab_item_class))
{
	$tab_item_class = ' class="' . $data->tab_item_class . '"';
}

$id = uniqid('', false);
?>
<div id="tab<?php echo $id; ?>"<?php echo $tab_class; ?>>
	<ul<?php echo $tab_ul_class; ?> data-uk-tab role="tablist" aria-controls="tab<?php echo $id; ?>">
		<?php
		$i = 1;
		foreach($data->options as $option)
		{

			$title = $option[ 'title' ];
			$panel = 'panel' . hash('crc32b', $title);
			$icon  = '';

			if(isset($option[ 'panel' ]))
			{
				$panel = 'panel' . hash('crc32b', $option[ 'panel' ]);
			}

			if(isset($option[ 'icon' ]))
			{
				$icon  = '<span uk-icon="icon: ' . $option[ 'icon' ] . '; rstio: .9" aria-hidden="true"></span>';
				$title = '<span class="uk-text-middle uk-margin-small-left">' . $option[ 'title' ] . '</span>';
			}

			?>
			<li role="presentation">
				<a
						id="tab<?php echo $id . '_' . $i; ?>"
						href="#<?php echo $panel; ?>"
					<?php echo $tab_item_class; ?>
						tabindex="<?php echo($i == 1 ? '0' : '-1'); ?>"
						role="tab"
						aria-controls="<?php echo $panel; ?>"
						aria-selected="<?php echo($i == 1 ? 'false' : 'true'); ?>">
					<?php echo $icon . $title; ?>
				</a>
			</li>
			<?php

			$i++;
		}
		?>
	</ul>

	<ul id="tabpanel<?php echo $id; ?>"<?php echo $tab_panel_class; ?> aria-live="polite">
		<?php
		$i = 1;
		foreach($data->options as $option)
		{
			$title = $option[ 'title' ];
			$panel = 'panel' . hash('crc32b', $title);

			if(isset($option[ 'panel' ]))
			{
				$panel = 'panel' . hash('crc32b', $option[ 'panel' ]);
			}

			if(is_array($option[ 'content' ]) && count($option[ 'content' ]) > 0)
			{
				if($mods = ModuleHelper::getModules($option[ 'content' ][ 'position' ]))
				{
					foreach($mods as $mod)
					{
						$content = ModuleHelper::renderModule($mod, [ 'style' => $option[ 'content' ][ 'style' ] ]);
					}
				}
			}
			else
			{
				$content = $option[ 'content' ];
			}

			if(isset($data->tab_content_class))
			{
				$content = '<div class="' . $data->tab_content_class . '">' . $content . '</div>';
			}

			?>
			<li
					id="<?php echo $panel; ?>"
					role="tabpanel"
					aria-labelledby="tab<?php echo $id; ?>"
					aria-hidden="<?php echo($i == 1 ? 'false' : 'true'); ?>"
					tabindex="<?php echo($i == 1 ? '0' : '-1'); ?>">
				<?php echo $content; ?>
			</li>
			<?php
			$i++;
		}
		?>
	</ul>
</div>