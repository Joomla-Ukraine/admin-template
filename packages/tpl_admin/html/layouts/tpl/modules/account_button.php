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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

?>
<div class="uk-margin uk-margin-medium-bottom">
	<a href="/account" class="uk-button uk-button-primary uk-button-small tm-text-semibold uk-width-1-1">
		<?php
		echo (new FileLayout('tpl.icon'))->render([
			'icon' => 'code-block',
			'size' => 22
		]);
		?>
		<span class="uk-text-middle tm-margin-xsmall-left"><?php echo Text::_('TPL_ADMIN_ACCOUNT'); ?></span>
	</a>
</div>
