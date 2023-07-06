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

use Joomla\CMS\Layout\FileLayout;

defined('_JEXEC') or die;

$class = $item->anchor_title ? 'class="' . $item->anchor_title . ' uk-inline" ' : 'class="uk-inline" ';

if($item->menu_image)
{
	$item->params->get('menu_text', 1) ? $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' : $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

$caret = '';
if($item->parent)
{
	$caret = (new FileLayout('tpl.icon'))->render([
		'icon'  => 'chevron-down',
		'size'  => 17,
		'class' => 'uk-position-center-left tm-sidebar-icon'
	]);
}

switch($item->browserNav) :
	default:
	case 0:
		?>
		<a <?php echo $class; ?>href="<?php echo $item->flink; ?>"><?php echo $icon; ?>
			<span class="uk-text-middle"><?php echo $linktype . $adm_icon; ?></span><?php echo $caret; ?>
		</a>
		<?php
		break;
	case 1:
		?>
	<a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank">
		<?php echo $icon; ?>
		<span class="uk-text-middle"><?php echo $linktype . $adm_icon; ?></span>
		<?php echo $caret; ?>
		</a><?php
		break;
	case 2:
		?>
		<a <?php echo $class; ?>href="<?php echo $item->flink; ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;"><span class="uk-text-middle"><?php echo $linktype . $adm_icon; ?></span><?php echo $caret; ?>
		</a>
		<?php
		break;
endswitch;
