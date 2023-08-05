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

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;

class Pkg_AdminInstallerScript
{
	/**
	 * @return bool
	 *
	 * @throws \Exception
	 * @since 7.0
	 */
	public function preflight()
	{
		$app = Factory::getApplication();

		if(version_compare(JVERSION, '4.0', 'lt'))
		{
			$app->enqueueMessage('Update for Joomla! 4.0 +', 'error');

			return false;
		}

		$path = JPATH_SITE . '/templates/admin/';
		$folders = [
			$path . 'app'
		];

		foreach($folders as $folder)
		{
			if(Folder::exists($folder))
			{
				Folder::delete($folder);
			}
		}

		return true;
	}
}