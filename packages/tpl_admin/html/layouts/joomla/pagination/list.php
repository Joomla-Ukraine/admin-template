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

use Joomla\CMS\Language\Text;

$list = $displayData[ 'list' ];

?>
<nav class="uk-margin-medium-top uk-margin-medium-bottom" aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>">
	<hr class="uk-align-center uk-margin-remove-bottom uk-width-medium">
	<ul class="uk-pagination uk-flex uk-flex-middle uk-flex-center">
		<?php echo $list[ 'start' ][ 'data' ]; ?>
		<?php echo $list[ 'previous' ][ 'data' ]; ?>
		<?php foreach($list[ 'pages' ] as $page) : ?>
			<?php echo $page[ 'data' ]; ?>
		<?php endforeach; ?>
		<?php echo $list[ 'next' ][ 'data' ]; ?>
		<?php echo $list[ 'end' ][ 'data' ]; ?>
	</ul>
</nav>