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

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

if($data->params->get('logo'))
{
	$loading = '';
	if(isset($data->loading) === false)
	{
		$loading = 'loading="lazy"';
	}

	$decoding = '';
	if(isset($data->decoding) === false)
	{
		$decoding = 'decoding="async"';
	}

	$img_class  = isset($data->img_class) ? 'class="' . $data->img_class . '"' : '';
	$attributes = array_filter([
		$loading,
		$decoding,
		$img_class
	]);

	?>
	<img
			src="<?php echo $data->logo; ?>"
			alt="<?php echo Factory::getApplication()->get('sitename'); ?>"
		<?php echo(isset($data->img_class) ? ' class="' . $data->img_class . '"' : ''); ?>
			aria-label="<?php echo Factory::getApplication()->get('sitename'); ?>"
			width="<?php echo $data->width; ?>"
			role="presentation"
		<?php echo implode(' ', $attributes); ?>>
	<?php
}
elseif($data->params->get('sitetitle'))
{
	echo $data->params->get('sitetitle');
}
else
{
	echo $data->sitename;
}