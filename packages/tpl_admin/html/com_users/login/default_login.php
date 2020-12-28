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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

?>
<?php if($mod = ModuleHelper::getModules('slogin')): ?>
	<hr class="uk-divider-small uk-text-center">
	<div class="uk-margin-medium uk-margin-remove-top">
		<?php echo ModuleHelper::renderModule($mod[ 0 ], [ 'style' => 'raw' ]); ?>
	</div>
<?php endif; ?>

<hr class="uk-divider-icon">

<form class="form-validate uk-margin-medium-top" id="login" action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post">

	<?php foreach($this->form->getFieldset('credentials') as $field) : ?>

		<?php if(!$field->hidden) : ?>
			<?php
			$label        = str_replace('<span class="star">&#160;*</span>', ' <span class="uk-text-danger">*</span>', $field->label);
			$paleceholder = str_replace('<span class="star">&#160;*</span>', '', $field->label);
			$paleceholder = trim(strip_tags($paleceholder));
			?>
			<div class="uk-margin">

				<label class="uk-form-label uk-hidden">
					<?php echo $label; ?>
				</label>

				<div class="uk-form-controls uk-inline uk-width-1-1 <?php echo($field->name === 'password' ? 'uk-style-pass' : ''); ?>">
					<?php
					switch($field->name)
					{
						case 'username':
							echo '<span class="uk-form-icon"><svg width="20" height="20" aria-hidden="true"><use xlink:href="' . Uri::base() . 'templates/admin/assets/icons/icons.svg#user"></use></svg></span>';
							break;
						case 'password':
							echo '<span class="uk-form-icon"><svg width="20" height="20" aria-hidden="true"><use xlink:href="' . Uri::base() . 'templates/admin/assets/icons/icons.svg#lock"></use></svg></span>';
							break;
					}

					echo str_replace('class="', 'placeholder="' . $paleceholder . '" class="uk-input uk-width-1-1 validate[required] ', $field->input);
					?>
				</div>

			</div>
		<?php endif; ?>

	<?php endforeach; ?>

	<?php if($this->tfa): ?>
		<div class="uk-margin">
			<label class="uk-form-label">
				<?php echo $this->form->getField('secretkey')->label; ?>
			</label>
			<div class="uk-form-controls">
				<?php echo str_replace('class="', 'class="uk-input uk-width-1-1 ', $this->form->getField('secretkey')->input); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if(PluginHelper::isEnabled('system', 'remember')) : ?>
		<div class="uk-margin">
			<div class="uk-form-controls">
				<input id="remember" class="uk-checkbox" type="checkbox" name="remember" value="yes" />
				<label for="remember">
					<?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME') ?>
				</label>
			</div>
		</div>
	<?php endif; ?>

	<div class="uk-margin">
		<div class="uk-form-controls">
			<button type="submit" class="uk-button uk-button-secondary uk-width-2-3 uk-align-center">
				<?php echo Text::_('JLOGIN'); ?>
			</button>
		</div>
	</div>

	<?php if($this->params->get('lodirect_url')) : ?>
		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>">
	<?php else : ?>
		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_menuitem', $this->form->getValue('return'))); ?>">
	<?php endif; ?>

	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="uk-margin-top">
	<ul class="uk-child-width-1-1@s uk-child-width-1-2@m uk-text-meta uk-text-center uk-flex uk-flex-center uk-grid-small" uk-grid>
		<li>
			<a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
				<svg width="17" height="17" class="uk-text-muted" aria-hidden="true">
					<use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#tm-key"></use>
				</svg> <?php echo Text::_('COM_USERS_LOGIN_RESET'); ?>
			</a>
		</li>
		<li>
			<a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
				<svg width="17" height="17" class="uk-text-muted" aria-hidden="true">
					<use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#user"></use>
				</svg> <?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?>
			</a>
		</li>
	</ul>
	<?php
	if(!$mod) :
		$usersConfig = ComponentHelper::getParams('com_users');
		if($usersConfig->get('allowUserRegistration')) : ?>
			<hr>
			<div class="uk-text-center">
				<a class="uk-text-muted" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>