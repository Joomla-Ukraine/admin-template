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

$class    = $item->anchor_title ? 'class="' . $item->anchor_title . '" ' : '';
$linktype = $item->title;
if($item->menu_image)
{
	$item->params->get('menu_text', 1) ? $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' : $linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}

$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

$caret = '';
if($item->parent && ($item->level == 1))
{
	$caret = ' <i class="fa fa-caret-down" aria-hidden="true"></i>';
}

switch($item->browserNav)
{
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
}