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

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die();

$data = (object) $displayData;

?>
<div class="uk-navbar-container tm-navbar-container uk-navbar-transparent uk-active">

	<div class="uk-container-expand">

		<?php if(!$data->user->guest && $data->this->countModules('account')): ?>
			<nav class="tm-navbar" data-uk-navbar>

				<div class="uk-navbar-left tm-navbar">
					<a class="uk-navbar-toggle <?php echo($data->ac_edit == 0 ? 'uk-hidden@m' : 'uk-hidden@xl'); ?>" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-slide"></a>

					<?php if($data->this->countModules('admin_lang')) : ?>
						<ul class="uk-navbar-nav uk-margin-left">
							<li class="uk-active uk-flex-middle">
								<jdoc:include type="modules" name="admin_lang" style="raw" />
							</li>
						</ul>
					<?php endif; ?>

					<?php if($data->this->params->get('count_users', 0)): ?>
						<ul class="uk-navbar-nav">
							<li class="uk-active uk-flex-middle">
								<a href="#">
									<span data-uk-icon="icon: users" class="uk-margin-small-right uk-text-primary"></span> <?php echo $data->users_count; ?>
								</a>
							</li>
						</ul>
					<?php endif; ?>

					<?php if($data->this->params->get('remove_cache', 0) == 1 && (in_array('7', $data->user->groups) || in_array('8', $data->user->groups))): ?>
						<ul class="uk-navbar-nav">
							<li class="uk-active uk-flex-middle">
								<a href="#" id="remove_cache" class="uk-text-danger">
									<span data-uk-icon="icon: bolt" class="uk-text-danger uk-margin-small-right"></span> <?php echo Text::_('TPL_ADMIN_CACHE_DELETE'); ?>
								</a>
							</li>
						</ul>
					<?php endif; ?>

					<?php if($data->this->params->get('html_tm')): ?>
						<?php echo eval('?> ' . $data->this->params->get('html_tm')); ?>
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
								<span class="uk-margin-small-right uk-visible@s"><?php echo($data->this->params->get('username', 0) == 0 ? $data->user->name : $data->user->email); ?></span>
								<span data-uk-icon="icon: chevron-down; ratio: .7" class="uk-visible@s"></span>
							</a>

							<div data-uk-dropdown="pos: bottom-right; mode: click; offset: -1;">
								<ul class="uk-nav uk-navbar-dropdown-nav">
									<li>
										<a href="<?php echo $data->profile; ?>"><span class="uk-margin-small-right" uk-icon="icon: user"></span> <?php echo Text::_('TPL_ADMIN_PROFILE'); ?>
										</a>
									</li>
									<li class="uk-nav-divider"></li>
									<li>
										<a href="<?php echo $data->logout; ?>"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> <?php echo Text::_('TPL_ADMIN_LOGOUT'); ?>
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