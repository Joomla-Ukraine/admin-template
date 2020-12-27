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
<div class="uk-flex uk-flex-middle" data-uk-height-viewport>
	<div class="tm-container uk-width-xxlarge uk-align-center">
		<div class="uk-section-default uk-box-shadow-medium uk-padding-<?php echo($data->section === true ? 'large' : 'small'); ?>">
			<h1 class="uk-h3">
				<a href="<?php echo URI::base(); ?>" target="_blank">
					<?php echo $data->logo; ?>
				</a>
			</h1>
			<jdoc:include type="component" />
		</div>
	</div>
</div>