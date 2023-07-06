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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $cookieLogin */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');

$usersConfig = ComponentHelper::getParams('com_users');

?>

<?php if($mod = ModuleHelper::getModules('slogin')): ?>
	<hr class="uk-divider-small uk-text-center">
	<div class="uk-margin-medium uk-margin-remove-top">
		<?php echo ModuleHelper::renderModule($mod[ 0 ], [ 'style' => 'raw' ]); ?>
	</div>
	<hr class="uk-divider-icon">
<?php endif; ?>


<form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="com-users-login__form form-validate uk-margin-medium-top" id="com-users-login__form">

	<?php
	echo $this->form->renderFieldset('credentials', [ 'class' => 'com-users-login__input' ]);
	?>

	<?php if(PluginHelper::isEnabled('system', 'remember')) : ?>
		<div class="uk-margin com-users-login__remember">
			<div class="uk-form-controls form-check">
				<input class="uk-checkbox form-check-input" id="remember" type="checkbox" name="remember" value="yes">
				<label class="tm-font-xxxsmall uk-text-top tm-margin-xsmall-left" for="remember">
					<?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?>
				</label>
			</div>
		</div>
	<?php endif; ?>

	<?php foreach($this->extraButtons as $button) :
		$dataAttributeKeys = array_filter(array_keys($button), function ($key)
		{
			return substr($key, 0, 5) == 'data-';
		});
		?>
		<div class="uk-margin com-users-login__submit uk-margin">
			<div class="uk-form-controls">
				<button type="button" class="uk-button uk-button-secondary uk-width-1-1 <?php echo $button[ 'class' ] ?? '' ?>"
				<?php foreach($dataAttributeKeys as $key) : ?>
					<?php echo $key ?>="<?php echo $button[ $key ] ?>"
				<?php endforeach; ?>
				<?php if($button[ 'onclick' ]) : ?>
					onclick="<?php echo $button[ 'onclick' ] ?>"
				<?php endif; ?>
				title="<?php echo Text::_($button[ 'label' ]) ?>"
				id="<?php echo $button[ 'id' ] ?>"
				>
				<?php if(!empty($button[ 'icon' ])) : ?>
					<span class="<?php echo $button[ 'icon' ] ?>"></span>
				<?php elseif(!empty($button[ 'image' ])) : ?>
					<?php echo HTMLHelper::_('image', $button[ 'image' ], Text::_($button[ 'tooltip' ] ?? ''), [
						'class' => 'icon',
					], true) ?>
				<?php elseif(!empty($button[ 'svg' ])) : ?>
					<?php echo $button[ 'svg' ]; ?>
				<?php endif; ?>
				<?php echo Text::_($button[ 'label' ]) ?>
				</button>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="uk-margin com-users-login__submit">
		<div class="uk-form-controls">
			<button type="submit" class="uk-button uk-button-primary uk-width-2-3 uk-align-center">
				<?php echo Text::_('JLOGIN'); ?>
			</button>
		</div>
	</div>

	<?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem', ''))); ?>
	<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>">
	<?php echo HTMLHelper::_('form.token'); ?>

</form>

<div class="uk-margin-top">
	<ul class="uk-child-width-1-1@s uk-child-width-1-2@m uk-text-meta uk-text-center uk-flex uk-flex-center uk-grid-small" data-uk-grid>
		<li>
			<a class="com-users-login__reset" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'key',
					'size'  => 22,
					'class' => 'uk-text-muted'
				]);
				?>
				<?php echo Text::_('COM_USERS_LOGIN_RESET'); ?>
			</a>
		</li>
		<li>
			<a class="com-users-login__remind" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
				<?php
				echo (new FileLayout('tpl.icon'))->render([
					'icon'  => 'user',
					'size'  => 22,
					'class' => 'uk-text-muted'
				]);
				?>
				<?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?>
			</a>
		</li>
		<li>
			<?php if($usersConfig->get('allowUserRegistration')) : ?>
				<a class="com-users-login__register list-group-item" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
					<?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?>
				</a>
			<?php endif; ?>
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
