<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2023 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', dirname(__DIR__, 3));
define('MAX_SIZE', '500');

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\Session\SessionInterface;

$container = Factory::getContainer();
$container->alias(SessionInterface::class, 'session.web.site');

$app        = $container->get(AdministratorApplication::class);
$joomlaUser = Factory::getUser();
$lang       = Factory::getLanguage();
$doc        = Factory::getDocument();

if($joomlaUser->get('id') < 1)
{
	return;
}

$root = dirname(__DIR__, 3);

echo unlinkRecursive($root . '/cache/com_cck**', '1');

if(is_dir($root . '/cache/com_home/'))
{
	echo unlinkRecursive($root . '/cache/com_home/', '1');
}

/**
 * @param         $dir
 * @param   null  $deleteRootToo
 *
 * @return string
 *
 * @since 1.0
 */
function unlinkRecursive($dir, $deleteRootToo = null)
{
	$folders = glob($dir, GLOB_BRACE);

	$notification = [];
	foreach($folders as $folder)
	{
		if(!$dh = opendir($folder))
		{
			return false;
		}

		while(false !== ($obj = readdir($dh)))
		{
			if($obj === '.' || $obj === '..')
			{
				continue;
			}

			$notification[] = trim(str_replace($_SERVER[ 'DOCUMENT_ROOT' ] . '/cache/', '', $folder), '/') . '<br>';

			if(!unlink($folder . '/' . $obj))
			{
				unlinkRecursive($folder . '/' . $obj, true);
			}
		}

		closedir($dh);

		if($deleteRootToo === '1')
		{
			rmdir($folder);
		}
	}

	$notify = array_unique($notification);
	$notify = implode($notify);

	return $notify;
}