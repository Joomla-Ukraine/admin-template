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

defined('_JEXEC') or die();

use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;

require_once __DIR__ . '/inc/head.php';

$doc = JFactory::getDocument();

// Select 2
$doc->addStyleSheet(Uri::base(true) . 'templates/admin/js/jui/jquery-ui.min.css');
$doc->addStyleSheet(Uri::base(true) . 'templates/admin/js/select2/css/select2.min.css');
$doc->addStyleSheet(Uri::base(true) . 'templates/admin/js/tageditor/jquery.tag-editor.css');

$doc->addScript(Uri::base(true) . 'templates/admin/js/select2/js/select2.min.js');
$doc->addScript(Uri::base(true) . 'templates/admin/js/jui/jquery-ui.min.js');
$doc->addScript(Uri::base(true) . 'templates/admin/js/tageditor/jquery.caret.min.js');
$doc->addScript(Uri::base(true) . 'templates/admin/js/tageditor/jquery.tag-editor.min.js');

$doc->addScriptDeclaration("jQuery(document).ready(function($){
    $('.select2').select2();
    $('.tags').tagEditor({ 
        placeholder: '+ тег',
        forceLowercase: false,
        autocomplete: { 
            source: '/templates/admin/ajax/tags.php', 
            minLength: 3 
        } 
    });
});");

$doc->addScript(Uri::base(true) . 'templates/admin/js/jq.js?' . $v);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
	<jdoc:include type="head" />
	<jdoc:include type="message" />
</head>
<body>
<main class="uk-container-expand">

	<div class="uk-grid-collapse" data-uk-grid data-uk-height-viewport="offset-top: true; offset-bottom: 0">

		<?php if(!$user->guest): ?>
			<?php echo (new FileLayout('tpl.sidebar'))->render([
				'this'      => $this,
				'logo'      => $logo,
				'ac_edit'   => $ac_edit,
				'ac_button' => $account_button
			]);
			?>
		<?php endif; ?>

		<div class="uk-width-1-1@s uk-width-expand uk-background-muted">

			<?php echo (new FileLayout('tpl.navbar'))->render([
				'this'        => $this,
				'avatar'      => $avatar,
				'user'        => $user,
				'users_count' => $users_count,
				'profile'     => $profile,
				'logout'      => $logout,
				'ac_edit'     => $ac_edit,
			]);
			?>

			<?php if($user->guest && $option === 'com_users'): ?>
				<?php echo (new FileLayout('tpl.component'))->render([
					'section' => true,
					'logo'    => $logo2
				]);
				?>
			<?php elseif($user->guest && $option === 'com_cck'): ?>
				<?php echo (new FileLayout('tpl.component'))->render([
					'section' => false,
					'logo'    => $logo2
				]);
				?>
			<?php else: ?>
				<div class="tm-container">
					<jdoc:include type="component" />
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>

<?php if(!$user->guest && $this->countModules('account')) : ?>
	<?php echo (new FileLayout('tpl.offcanvas'))->render([
		'logo' => $logo,
	]);
	?>
<?php endif; ?>

</body>
</html>