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

$class = $item->anchor_title ? 'class="' . $item->anchor_title . '" ' : '';
if($item->menu_image)
{
	$item->params->get('menu_text', 1) ? $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' : $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}
$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

$caret = '';
if($item->parent && ($item->level == 1))
{
	$caret = ' <i class="fa fa-caret-down" aria-hidden="true"></i>';
}

switch($item->browserNav) :
	default:
	case 0:
		?>
		<a <?php echo $class; ?>href="<?php echo $flink; ?>"><?php echo $icon; ?><?php echo $linktype . $adm_icon . $caret; ?></a><?php
		break;
	case 1:
		?><a <?php echo $class; ?>href="<?php echo $flink; ?>"
		target="_blank"><?php echo $icon; ?><?php echo $linktype . $adm_icon . $caret; ?></a><?php
		break;
	case 2:
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');
		?><a <?php echo $class; ?>href="<?php echo $flink; ?>"
		onclick="window.open(this.href,'targetWindow','<?php echo $options; ?>');return false;"><?php echo $icon; ?><?php echo $linktype . $adm_icon . $caret; ?></a><?php
		break;
endswitch;
