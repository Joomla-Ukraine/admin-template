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

$class = '';
if(isset($data->class))
{
	$class = ' ' . $data->class;
}

?>
<div class="uk-slider" data-uk-slider>
	<div class="uk-position-relative uk-visible-toggle<?php echo $class; ?>" tabindex="-1">
		<div class="uk-slider-container">
			<ul class="uk-slider-items uk-text-center uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-4@m">
				<?php foreach($data->items as $item): ?>
					<li>
						<?php echo $item; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<ul class="uk-slider-nav uk-dotnav uk-flex uk-flex-center uk-hidden@s"></ul>
		<div class="uk-visible@s">
			<a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
			<a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		</div>
	</div>
</div>