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

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/** @var array $displayData */
$data = (object) $displayData;

if($data->params->get('edit_profile') == 1)
{
	echo $data->params->get('edit_profile_link') . $data->user->id . '&return=' . base64_encode(Uri::base() . 'account');
}
else
{
	echo Route::_('index.php?option=com_users&view=profile&layout=edit');
}