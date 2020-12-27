<?php
/**
 * Bad Android Template
 *
 * @package          Joomla.Site
 * @subpackage       a
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2016-2019 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

defined('JPATH_BASE') or die;

$msgList = $displayData['msgList'];

if (is_array($msgList) && !empty($msgList))
{
	foreach ($msgList as $type => $msgs)
	{
		switch ($type)
		{
			case 'message':
				$_sfx  = 'success';
				$_icon = 'info';
				break;
			case 'warning':
				$_sfx  = 'warning';
				$_icon = 'warning';
				break;
			case 'error':
				$_sfx  = 'danger';
				$_icon = 'warning';
				break;
			case 'notice':
				$_sfx  = 'primary';
				$_icon = 'check';
				break;
			default:
				$_sfx  = $type;
				$_icon = 'check';
				break;
		}

		if (!empty($msgs))
		{
			$html = '<script>';
			$html .= '(function(){document.addEventListener(\'DOMContentLoaded\', function(){';

			foreach ($msgs as $msg)
			{
				$html .= "UIkit.notification({message: '<span uk-icon=\"icon:" . $_icon . '; ratio: 0.92"></span> <span class="uk-text-middle">' . $msg . "</span>', status: '" . $_sfx . "', timeout : 5000, pos: 'top-center'});";
			}

			$html .= '});})();';
			$html .= '</script>';

			echo $html;
		}
	}
}