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
$joomlaUser = Factory::getApplication()->getIdentity();
$lang       = Factory::getApplication()->getLanguage();
$doc        = Factory::getApplication()->getDocument();

if($joomlaUser->get('id') < 1)
{
	return;
}

$root = dirname(__DIR__, 3);

unlinkRecursive($root . '/cache/com_cck**', '1');

if(is_dir($root . '/cache/com_home/'))
{
	unlinkRecursive($root . '/cache/com_home/', '1');
}

/**
 * @param         $dir
 * @param   null  $deleteRootToo
 *
 * @return array|bool
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

			$notification[] = trim(str_replace($_SERVER[ 'DOCUMENT_ROOT' ] . '/cache/', '', $folder), '/');

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

	return implode($notification);
}