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

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die();

$data = (object) $displayData;

?>
<aside class="" id="offcanvas-slide" data-uk-offcanvas="overlay: true">
	<div class="uk-offcanvas-bar tm-sidebar-left">

		<button class="uk-offcanvas-close uk-light" type="button" data-uk-close></button>

		<div class="tm-sidebar-padding-bottom">

			<div class="uk-margin-small">
				<h1 class="uk-h3">
					<a href="<?php echo Uri::base(); ?>" class="uk-link-reset" target="_blank">
						<?php echo $data->logo; ?>
					</a>
				</h1>
			</div>

			<div class="uk-light uk-margin-small-top">
				<jdoc:include type="modules" name="account" style="raw" />
			</div>

		</div>

	</div>
</aside>
