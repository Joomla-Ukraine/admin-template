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

use Joomla\CMS\Layout\FileLayout;

defined('JPATH_BASE') or die;

$msgList = $displayData[ 'msgList' ];

if(is_array($msgList) && !empty($msgList))
{
	foreach($msgList as $type => $msgs)
	{
		switch($type)
		{
			case 'message':
				$_sfx  = 'success';
				$_icon = 'settings-cog-check';
				break;
			case 'warning':
				$_sfx  = 'warning';
				$_icon = 'alert-circle';
				break;
			case 'error':
				$_sfx  = 'danger';
				$_icon = 'alert-circle';
				break;
			case 'notice':
				$_sfx  = 'primary';
				$_icon = 'scroll-text';
				break;
			default:
				$_sfx  = $type;
				$_icon = 'check';
				break;
		}

		if(!empty($msgs))
		{
			$html = '<script>';
			$html .= '(function(){document.addEventListener(\'DOMContentLoaded\', function(){';

			foreach($msgs as $msg)
			{
				$icon    = (new FileLayout('tpl.icon'))->render([
					'icon' => $_icon,
					'size' => 32
				]);
				$massage = '<div class="uk-grid uk-grid-small uk-flex uk-flex-middle" data-grid><div class="uk-width-auto">' . str_replace("\n", '', $icon) . '</div><div class="uk-width-expand">' . $msg . '</div></div>';
				$html    .= "UIkit.notification({message: '" . $massage . "', status: '" . $_sfx . "', pos: 'top-center'});";
			}

			$html .= '});})();';
			$html .= '</script>';

			echo $html;
		}
	}
}