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

$class    = $item->anchor_title ? 'class="' . $item->anchor_title . ' uk-inline" ' : 'class="uk-inline" ';
$linktype = $item->title;
if($item->menu_image)
{
	$item->params->get('menu_text', 1) ? $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' : $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}

$caret = '';
if($item->parent)
{
	$caret = '<span uk-icon="icon:  chevron-down; ratio: 0.8" class="uk-position-center-left tm-sidebar-icon" style="left: 200px"></span>';
}

switch($item->browserNav)
{
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
		<a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank"><?php echo $icon; ?>
		<span class="uk-text-middle"><?php echo $linktype . $adm_icon; ?></span><?php echo $caret; ?>
		</a><?php
		break;
	case 2:
		?>
		<a <?php echo $class; ?>href="<?php echo $item->flink; ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;"><span class="uk-text-middle"><?php echo $linktype . $adm_icon; ?></span><?php echo $caret; ?>
		</a>
		<?php
		break;
}