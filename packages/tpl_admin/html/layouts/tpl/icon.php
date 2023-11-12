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

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

$v = '2.6';

$size = 20;
if(isset($data->size))
{
	$size = $data->size;
}

?>
<svg width="<?php echo $size; ?>" height="<?php echo $size; ?>"<?php echo(isset($data->class) && $data->class ? ' class="' . $data->class . '"' : ''); ?>>
	<use xlink:href="<?php Uri::base(true); ?>/templates/admin/app/icons/icons.svg?v=<?php echo $v; ?>#<?php echo $data->icon; ?>"></use>
</svg>