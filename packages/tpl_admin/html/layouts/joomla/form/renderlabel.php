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

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $text     The label text
 * @var   string  $for      The id of the input this label is for
 * @var   boolean $required True if a required field
 * @var   array   $classes  A list of classes
 */

$classes[] = 'uk-form-label';

$classes = array_filter((array) $classes);
$id      = $for . '-lbl';

if($required)
{
	$classes[] = 'required';
}

?>
<label id="<?php echo $id; ?>" for="<?php echo $for; ?>"<?php if(!empty($classes))
{
	echo ' class="' . implode(' ', $classes) . '"';
} ?>>
	<?php echo $text; ?><?php if($required) :
		?><span class="uk-text-danger" aria-hidden="true">&#160;*</span><?php
	endif; ?>
</label>
