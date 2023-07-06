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

/** @var array $displayData */
$data = (object) $displayData;

$section = '';
if(isset($data->section))
{
	$section = ' uk-section-' . $data->section;
}

$style_title   = 'tm-box-border-flat uk-background-default';
$style_content = 'tm-box-border-flat';
if(isset($data->style) == 1)
{
	$style_title   = 'tm-box-border-flat-blue uk-background-default';
	$style_content = 'tm-box-border-flat tm-bg-greyblue';
}

?>
<ul class="uk-accordion uk-margin-remove" data-uk-accordion>
	<?php
	$i = 1;
	foreach($data->items as $item): ?>
		<li<?php echo($i == 1 ? ' class="uk-open"' : ''); ?>>
			<a class="uk-accordion-title tm-text-semibold tm-font-medium uk-padding-small uk-border-rounded <?php echo $style_title; ?>" href="#"><?php echo $item[ 'title' ]; ?></a>
			<div class="uk-accordion-content uk-padding-small uk-border-rounded tm-article <?php echo $style_content; ?>">
				<?php echo $item[ 'text' ]; ?>
			</div>
		</li>
		<?php
		$i++;
	endforeach; ?>
</ul>