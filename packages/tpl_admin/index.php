<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Uri\Uri;

require_once __DIR__ . '/inc/head.php';

$doc = JFactory::getDocument();

// Select 2
$doc->addStyleSheet(JURI::base(true) . 'templates/admin/js/jui/jquery-ui.min.css');
$doc->addStyleSheet(JURI::base(true) . 'templates/admin/js/select2/css/select2.min.css');
$doc->addStyleSheet(JURI::base(true) . 'templates/admin/js/tageditor/jquery.tag-editor.css');

$doc->addScript(JURI::base(true) . 'templates/admin/js/select2/js/select2.min.js');
$doc->addScript(JURI::base(true) . 'templates/admin/js/jui/jquery-ui.min.js');
$doc->addScript(JURI::base(true) . 'templates/admin/js/tageditor/jquery.caret.min.js');
$doc->addScript(JURI::base(true) . 'templates/admin/js/tageditor/jquery.tag-editor.min.js');

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

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
	<jdoc:include type="head" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
</head>
<body>

<main class="uk-container-expand">
	<div class="uk-grid-collapse" uk-grid uk-height-viewport="offset-top: true; offset-bottom: 0">

		<?php if(!$user->guest): ?>
			<aside class="tm-sidebar-left uk-width-auto uk-position-relative <?php echo($ac_edit == 0 ? 'uk-visible@m' : 'uk-visible@xl'); ?>">

				<div class="tm-sidebar-padding">

					<h1 class="uk-h3 tm-logo uk-logo">
						<a href="<?php echo URI::base(); ?>" class="uk-link-reset" target="_blank">
							<?php echo $logo; ?>
						</a>
					</h1>

					<div class="tm-b-panel uk-button-group uk-margin-small">
						<a href="/account" class="uk-button uk-button-secondary uk-button-small <?php echo($account_button == 1 ? 'uk-width-3-4' : 'uk-width-1-1'); ?>">
							<span uk-icon="icon: grid"></span> <?php echo jText::_('TPL_ADMIN_ACCOUNT'); ?>
						</a>
						<?php if($account_button == 1) : ?>
							<div class="uk-inline uk-width-1-3">
								<button class="tm-b-panel-drop uk-button uk-button-secondary uk-button-small uk-width-1-1">
									<span uk-icon="icon: triangle-down"></span>
								</button>
								<div uk-drop="pos: bottom-justify; boundary: .tm-b-panel; mode: click; boundary-align: true; offset: 1">
									<div class="uk-card uk-card-small uk-card-body uk-card-default">
										<ul class="uk-nav uk-dropdown-nav">
											<?php if($this->params->get('but_stats', 0) == 1): ?>
												<li>
													<a href="#">
														<span class="uk-margin-small-right" uk-icon="icon: table"></span> <?php echo jText::_('TPL_ADMIN_STATS'); ?>
													</a>
												</li>
											<?php endif; ?>
											<?php if($this->params->get('but_soc', 0) == 1): ?>
												<li>
													<a href="#">
														<span class="uk-margin-small-right" uk-icon="icon: social"></span> <?php echo jText::_('TPL_ADMIN_SOCIAL'); ?>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php if($this->countModules('account')): ?>
						<div class="uk-light uk-margin-small-top">
							<jdoc:include type="modules" name="account" style="raw" />
						</div>
					<?php endif; ?>

				</div>

				<div class="uk-position-fixed uk-position-bottom-left">
					<div class="uk-padding-small uk-h6 uk-margin-remove">
						Build v@version@, @date@
					</div>
				</div>

			</aside>
		<?php endif; ?>

		<div class="uk-width-1-1@s uk-width-expand uk-background-muted">

			<div class="uk-navbar-container tm-navbar-container uk-navbar-transparent uk-active">

				<div class="uk-container-expand">

					<?php if(!$user->guest && $this->countModules('account')): ?>
						<nav class="tm-navbar" uk-navbar>

							<div class="uk-navbar-left tm-navbar">
								<a class="uk-navbar-toggle <?php echo($ac_edit == 0 ? 'uk-hidden@m' : 'uk-hidden@xl'); ?>" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-slide"></a>

								<?php if($this->countModules('admin_lang')) : ?>
									<ul class="uk-navbar-nav uk-margin-left">
										<li class="uk-active uk-flex-middle">
											<jdoc:include type="modules" name="admin_lang" style="raw" />
										</li>
									</ul>
								<?php endif; ?>

								<?php if($this->params->get('count_users', 0)): ?>
									<ul class="uk-navbar-nav">
										<li class="uk-active uk-flex-middle">
											<a href="#">
												<span uk-icon="icon: users" class="uk-margin-small-right uk-text-primary"></span> <?php echo $users_count; ?>
											</a>
										</li>
									</ul>
								<?php endif; ?>

								<?php if($this->params->get('remove_cache', 0) == 1 && (in_array('7', $user->groups) || in_array('8', $user->groups))): ?>
									<ul class="uk-navbar-nav">
										<li class="uk-active uk-flex-middle">
											<a href="#" id="remove_cache" class="uk-text-danger">
												<span uk-icon="icon: bolt" class="uk-text-danger uk-margin-small-right"></span> <?php echo jText::_('TPL_ADMIN_CACHE_DELETE'); ?>
											</a>
										</li>
									</ul>
								<?php endif; ?>

								<?php if($this->params->get('html_tm')): ?>
									<?php echo eval('?> ' . $this->params->get('html_tm')); ?>
								<?php endif; ?>

								<jdoc:include type="modules" name="admin_menu" style="raw" />
							</div>

							<div class="uk-navbar-right tm-navbar uk-margin-right">
								<ul class="uk-navbar-nav">
									<li class="uk-active uk-flex-middle">
										<a href="#" class="uk-padding-remove">
												<span class="uk-inline uk-margin-small-right tm-status">
                                                    <?php echo $avatar; ?>
													<span id="status" data-enabled="true" data-interval="60000" class="tm-status-bull uk-position-top-right uk-label uk-label-success"></span>
											    </span>
											<span class="uk-margin-small-right uk-visible@s"><?php echo($this->params->get('username', 0) == 0 ? $user->name : $user->email); ?></span>
											<span uk-icon="icon: chevron-down; ratio: .7" class="uk-visible@s"></span>
										</a>

										<div uk-dropdown="pos: bottom-right; mode: click; offset: -1;">
											<ul class="uk-nav uk-navbar-dropdown-nav">
												<li>
													<a href="<?php echo $profile; ?>"><span class="uk-margin-small-right" uk-icon="icon: user"></span> <?php echo jText::_('TPL_ADMIN_PROFILE'); ?>
													</a>
												</li>
												<li class="uk-nav-divider"></li>
												<li>
													<a href="<?php echo $logout; ?>"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> <?php echo jText::_('TPL_ADMIN_LOGOUT'); ?>
													</a>
												</li>
											</ul>
										</div>
									</li>
								</ul>
							</div>

						</nav>
					<?php endif; ?>

				</div>
			</div>

			<?php if($user->guest && $option === 'com_users'): ?>
				<div class="uk-flex uk-flex-middle" uk-height-viewport>
					<div class="tm-container uk-width-xxlarge uk-align-center">
						<div class="uk-section-default uk-box-shadow-medium uk-padding-large">
							<h1 class="uk-h3">
								<a href="<?php echo URI::base(); ?>" target="_blank">
									<?php echo $logo2; ?>
								</a>
							</h1>
							<jdoc:include type="component" />
						</div>
					</div>
				</div>
			<?php elseif($user->guest && $option === 'com_cck'): ?>
				<div class="uk-flex uk-flex-middle" uk-height-viewport>
					<div class="tm-container uk-width-xxlarge uk-align-center">
						<div class="uk-section-default uk-box-shadow-medium uk-padding-small">
							<h1 class="uk-h3">
								<a href="<?php echo URI::base(); ?>" target="_blank">
									<?php echo $logo2; ?>
								</a>
							</h1>
							<jdoc:include type="component" />
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="tm-container">
					<jdoc:include type="component" />
				</div>
			<?php endif; ?>

		</div>
	</div>

</main>

<?php if(!$user->guest && $this->countModules('account')): ?>
	<aside class="" id="offcanvas-slide" uk-offcanvas="overlay: true">
		<div class="uk-offcanvas-bar tm-sidebar-left">
			<button class="uk-offcanvas-close uk-light" type="button" uk-close></button>
			<div class="tm-sidebar-padding-bottom">
				<div class="uk-margin-small">
					<h1 class="uk-h3">
						<a href="<?php echo URI::base(); ?>" class="uk-link-reset" target="_blank">
							<?php echo $logo; ?>
						</a>
					</h1>
				</div>

				<div class="uk-light uk-margin-small-top">
					<jdoc:include type="modules" name="account" style="raw" />
				</div>
			</div>
		</div>
	</aside>
<?php endif; ?>
<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById("video-orig_uploadfile").addEventListener("click", function () {
                document.getElementById('video-orig_video-container').innerHTML = '';
                document.getElementById('video-orig_video-container').setAttribute('hidden', '');
            });

        });
    })();

    function ajaxStateAdmin(id, state) {
        axios.get('/video/video-delete.php?o=' + state + '&s=' + id).then(function (response) {
            console.log(response);
            console.log(response.data.success);

            if (response.data.success) {
                UIkit.notification({
                    message: '<span uk-icon=\"icon:info; ratio: 0.92\"></span> <span class=\"uk-text-middle\">' + response.data.message + '</span>',
                    status: response.data.status,
                    pos: 'top-center'
                });
            }

        }).catch(function (error) {
            console.log(error);
        });
    }
</script>
</body>
</html>