<?php
/**
 * Bad Android Template
 *
 * @package          Joomla.Site
 * @subpackage       a
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2016-2020 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          GNU General Public License version 2 or later
 */

use Joomla\CMS\Uri\Uri;

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

		if(!empty($msgs))
		{
			$html = '<script>';
			$html .= '(function(){document.addEventListener(\'DOMContentLoaded\', function(){';

			foreach($msgs as $msg)
			{
				$html .= "UIkit.notification({message: '<div class=\"uk-grid uk-grid-small uk-flex-middle\" data-uk-grid><div class=\"uk-width-auto\"><svg width=\"25\" height=\"25\" aria-hidden=\"true\"><use xlink:href=\"" . Uri::base() . "templates/admin/assets/icons/icons.svg#$_icon\"></use></svg></div><div class=\"uk-width-expand\">$msg</div></div>', status: '$_sfx', timeout : 6000, pos: 'top-center'});";
			}

			$html .= '});})();';
			$html .= '</script>';

			echo $html;
		}
	}
}