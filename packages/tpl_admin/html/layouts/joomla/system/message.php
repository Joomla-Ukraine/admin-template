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