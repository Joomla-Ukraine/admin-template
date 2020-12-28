<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

/**
 * Installation class to perform additional changes during install/uninstall/update
 *
 * @package  Template Site Admin
 * @since    1.5
 */
class Pkg_AdminInstallerScript
{
	/**
	 * @param $type
	 * @param $parent
	 *
	 * @return void
	 *
	 * @since 1.5
	 */
	public function preflight($type, $parent)
	{

	}

	/**
	 * @param $parent
	 *
	 *
	 * @since    1.5
	 */
	public function uninstall($parent)
	{

	}

	/**
	 * @param $parent
	 *
	 *
	 * @since    1.5
	 */
	public function update($parent)
	{

	}

	/**
	 * @param $type
	 * @param $parent
	 * @param $results
	 *
	 * @return bool
	 *
	 * @since    1.5
	 */
	public function postflight($type, $parent, $results): bool
	{
		$files = [
			'/templates/system_seblod/libs/emt/example.php',
		];

		$folders = [
			'/templates/admin/html/mod_jutabs',
			'/templates/admin/css',
			'/templates/admin/js',
		];

		jimport('joomla.filesystem.file');

		foreach($files as $file)
		{
			if(JFile::exists(JPATH_ROOT . $file) && !JFile::delete(JPATH_ROOT . $file))
			{
				echo JText::sprintf('FILES_JOOMLA_ERROR_FILE_FOLDER', $file) . '<br />';
			}
		}

		jimport('joomla.filesystem.folder');

		foreach($folders as $folder)
		{
			if(JFolder::exists(JPATH_ROOT . $folder) && !JFolder::delete(JPATH_ROOT . $folder))
			{
				echo JText::sprintf('FILES_JOOMLA_ERROR_FILE_FOLDER', $folder) . '<br />';
			}
		}

		return true;
	}
}