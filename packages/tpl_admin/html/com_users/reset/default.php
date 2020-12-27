<?php
/**
 * Bad Android Template
 *
 * @package          Joomla.Site
 * @subpackage       a
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2016-2019 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

?>
<div class="uk-article <?php echo $this->pageclass_sfx ?>">
	<form id="user-registration" action="<?php echo Route::_('index.php?option=com_users&task=reset.request'); ?>"
			method="post" class="form-validate uk-form">
		<?php foreach( $this->form->getFieldsets() as $fieldset ) : ?>
			<div class="uk-margin">
				<?php echo JText::_($fieldset->label); ?>
			</div>
			<div class="uk-margin">
				<?php foreach( $this->form->getFieldset($fieldset->name) as $name => $field ) : ?>
					<?php echo $field->label; ?>
					<div class="uk-form-controls">
						<?php echo $field->input; ?>
						<?php /* if($field->input): ?>
							<p class="uk-form-help-block uk-text-muted"><?php echo str_replace('<br />', ' ', JText::_($field->description)); ?></p>
						<?php endif; */ ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>

		<div class="uk-margin">
			<button type="submit" class="uk-button uk-button-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
		</div>
		<?php echo HTMLHelper::_('form.token'); ?>
	</form>
</div>