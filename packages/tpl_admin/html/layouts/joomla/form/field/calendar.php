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

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Utilities\ArrayHelper;

extract($displayData);

$document = Factory::getApplication()->getDocument();
$lang     = Factory::getApplication()->getLanguage();

$attributes = [];

empty($size) ? null : $attributes[ 'size' ] = $size;
empty($maxlength) ? null : $attributes[ 'maxlength' ] = $maxLength;
empty($class) ? $attributes[ 'class' ] = 'js-calendar' : $attributes[ 'class' ] = 'js-calendar ' . $class;
!$readonly ? null : $attributes[ 'readonly' ] = 'readonly';
!$disabled ? null : $attributes[ 'disabled' ] = 'disabled';
empty($onchange) ? null : $attributes[ 'onchange' ] = $onchange;

if($required)
{
	$attributes[ 'required' ] = '';
}

if(strtoupper($value) === 'NOW')
{
	$value = Factory::getDate()->format('Y-m-d H:i:s');
}

$readonly = isset($attributes[ 'readonly' ]) && $attributes[ 'readonly' ] === 'readonly';
$disabled = isset($attributes[ 'disabled' ]) && $attributes[ 'disabled' ] === 'disabled';

if(is_array($attributes))
{
	$attributes = ArrayHelper::toString($attributes);
}

?>
<div class="uk-position-relative">
	<span class="uk-form-icon uk-form-icon-flip">
		<?php
		echo (new FileLayout('tpl.icon'))->render([
			'icon'  => 'calendar',
			'size'  => 26,
			'class' => 'uk-text-primary'
		]);
		?>
	</span>

	<input type="text"
			id="<?php echo $id; ?>"
			name="<?php echo $name; ?>"
			value="<?php echo htmlspecialchars(($value !== '0000-00-00 00:00:00') ? $value : '', ENT_COMPAT); ?>"
		<?php echo !empty($description) ? ' aria-describedby="' . ($id ? : $name) . '-desc"' : ''; ?>
		<?php echo $attributes; ?>
		<?php echo $dataAttribute ?? ''; ?>
		<?php echo !empty($hint) ? 'placeholder="' . htmlspecialchars($hint, ENT_COMPAT, 'UTF-8') . '"' : ''; ?>
	>
</div>