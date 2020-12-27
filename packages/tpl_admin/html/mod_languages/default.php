<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<form name="lang" method="post" action="<?php echo htmlspecialchars(JUri::current(), ENT_COMPAT, 'UTF-8'); ?>">
	<label>
		<select class="uk-select uk-form-small uk-width-auto tm-lang" onchange="document.location.replace(this.value);" title="">
			<?php foreach ( $list as $language ) : ?>
				<option value="<?php echo $language->link; ?>" <?php echo $language->active ? 'selected="selected"' : ''; ?>><?php echo $language->title_native; ?></option>
			<?php endforeach; ?>
		</select>
	</label>
</form>