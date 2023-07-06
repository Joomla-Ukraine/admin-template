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

use Joomla\CMS\String\PunycodeHelper;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $autocomplete   Autocomplete attribute for the field.
 * @var   boolean $autofocus      Is autofocus enabled?
 * @var   string  $class          Classes for the input.
 * @var   string  $description    Description of the field.
 * @var   boolean $disabled       Is this field disabled?
 * @var   string  $group          Group the field belongs to. <fields> section in form XML.
 * @var   boolean $hidden         Is this field hidden in the form?
 * @var   string  $hint           Placeholder for the field.
 * @var   string  $id             DOM id of the field.
 * @var   string  $label          Label of the field.
 * @var   string  $labelclass     Classes to apply to the label.
 * @var   boolean $multiple       Does this field support multiple values?
 * @var   string  $name           Name of the input field.
 * @var   string  $onchange       Onchange attribute for the field.
 * @var   string  $onclick        Onclick attribute for the field.
 * @var   string  $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   boolean $readonly       Is this field read only?
 * @var   boolean $repeat         Allows extensions to duplicate elements.
 * @var   boolean $required       Is this field required?
 * @var   integer $size           Size attribute of the input.
 * @var   boolean $spellcheck     Spellcheck state for the form field.
 * @var   string  $validate       Validation rules to apply.
 * @var   string  $value          Value attribute of the field.
 * @var   array   $checkedOptions Options that will be set as checked.
 * @var   boolean $hasValue       Has this field a value assigned?
 * @var   array   $options        Options available for this field.
 * @var   array   $inputType      Options available for this field.
 * @var   string  $accept         File types that are accepted.
 * @var   string  $dataAttribute  Miscellaneous data attributes preprocessed for HTML output
 * @var   array   $dataAttributes Miscellaneous data attribute for eg, data-*.
 */

$attributes = [
	'type="email"',
	'inputmode="email"',
	'name="' . $name . '"',
	'class="uk-input validate-email' . (!empty($class) ? ' ' . $class : '') . '"',
	'id="' . $id . '"',
	'value="' . htmlspecialchars(PunycodeHelper::emailToUTF8($value), ENT_COMPAT, 'UTF-8') . '"',
	$spellcheck ? '' : 'spellcheck="false"',
	!empty($size) ? 'size="' . $size . '"' : '',
	!empty($description) ? 'aria-describedby="' . ($id ? : $name) . '-desc"' : '',
	$disabled ? 'disabled' : '',
	$readonly ? 'readonly' : '',
	$onchange ? 'onchange="' . $onchange . '"' : '',
	!empty($autocomplete) ? 'autocomplete="' . $autocomplete . '"' : '',
	$multiple ? 'multiple' : '',
	!empty($maxLength) ? 'maxlength="' . $maxLength . '"' : '',
	strlen($hint) ? 'placeholder="' . htmlspecialchars($hint, ENT_COMPAT, 'UTF-8') . '"' : '',
	$required ? 'required' : '',
	$autofocus ? 'autofocus' : '',
	$dataAttribute,
];

echo '<input ' . implode(' ', array_values(array_filter($attributes))) . '>';
