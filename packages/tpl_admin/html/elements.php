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

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

function Module($position, $style = 'raw', $class)
{
	$document = Factory::getDocument();
	$renderer = $document->loadRenderer('module');
	$params   = array('style' => $style);

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