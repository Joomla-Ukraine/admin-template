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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

?>
<div class="uk-article <?php echo $this->pageclass_sfx ?>">
	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate uk-form">
		<?php foreach($this->form->getFieldsets() as $fieldset) : ?>
			<div class="uk-margin">
				<?php echo Text::_($fieldset->label); ?>
			</div>
			<div class="uk-margin">
				<?php foreach($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
					<?php echo $field->label; ?>
					<div class="uk-form-controls">
						<?php echo $field->input; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
		<div class="uk-margin">
			<button type="submit" class="uk-button uk-button-primary validate"><?php echo Text::_('JSUBMIT'); ?></button>
		</div>
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
</div>
