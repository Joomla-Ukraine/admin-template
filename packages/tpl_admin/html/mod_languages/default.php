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