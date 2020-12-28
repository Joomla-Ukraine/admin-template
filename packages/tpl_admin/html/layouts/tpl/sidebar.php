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
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die();

$data = (object) $displayData;

?>
<aside class="tm-sidebar-left uk-width-auto uk-position-relative <?php echo($data->ac_edit == 0 ? 'uk-visible@m' : 'uk-visible@xl'); ?>">

	<div class="tm-sidebar-padding">

		<h1 class="uk-h3 tm-logo uk-logo">
			<a href="<?php echo Uri::base(); ?>" class="uk-light" target="_blank">
				<?php echo $data->logo; ?>
			</a>
		</h1>

		<div class="tm-b-panel uk-button-group uk-margin-small">

			<a href="/account" class="uk-button uk-button-secondary uk-button-small <?php echo($data->ac_button == 1 ? 'uk-width-3-4' : 'uk-width-1-1'); ?>">
				<svg width="20" height="20" aria-hidden="true"><use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#grid"></use></svg> <?php echo Text::_('TPL_ADMIN_ACCOUNT'); ?>
			</a>

			<?php if($data->ac_button == 1) : ?>
				<div class="uk-inline uk-width-1-3">

					<button class="tm-b-panel-drop uk-button uk-button-secondary uk-button-small uk-width-1-1">
						<svg width="20" height="20" aria-hidden="true"><use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#triangle-down"></use></svg>
					</button>

					<div data-uk-drop="pos: bottom-justify; boundary: .tm-b-panel; mode: click; boundary-align: true; offset: 1">

						<div class="uk-card uk-card-small uk-card-body uk-card-default">
							<ul class="uk-nav uk-dropdown-nav">

								<?php if($data->this->params->get('but_stats', 0) == 1): ?>
									<li>
										<a href="#">
											<svg width="20" height="20" class="uk-margin-small-right" aria-hidden="true"><use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#table"></use></svg> <?php echo Text::_('TPL_ADMIN_STATS'); ?>
										</a>
									</li>
								<?php endif; ?>

								<?php if($data->this->params->get('but_soc', 0) == 1): ?>
									<li>
										<a href="#">
											<svg width="20" height="20" class="uk-margin-small-right" aria-hidden="true"><use xlink:href="<?php echo Uri::base(); ?>templates/admin/assets/icons/icons.svg#social"></use></svg> <?php echo Text::_('TPL_ADMIN_SOCIAL'); ?>
										</a>
									</li>
								<?php endif; ?>

							</ul>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		<?php if($data->this->countModules('account')): ?>
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