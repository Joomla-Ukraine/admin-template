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

if($data->params->get('logo2'))
{
	$logo2 = '<img src="' . Uri::root() . $data->params->get('logo2') . '" alt="' . $data->sitename . '" width="' . $data->params->get('logo2_w', '180') . '" class="uk-align-center" decoding="async">';
}
elseif($data->params->get('sitetitle'))
{
	$logo2 = $data->params->get('sitetitle');
}
else
{
	echo $data->sitename;
}