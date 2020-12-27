<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2020 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

function Module($position, $style = 'raw', $class)
{
	$document = Factory::getDocument();
	$renderer = $document->loadRenderer('module');
	$params   = [ 'style' => $style ];

	$contents = '';

	if(ModuleHelper::getModules($position))
	{
		$contents .= '<div' . ($class != '' ? ' class="' . $class . '"' : '') . '>';

		foreach(ModuleHelper::getModules($position) as $mod)
		{
			$contents .= $renderer->render($mod, $params);
		}

		$contents .= '</div>';
	}

	return $contents;
}