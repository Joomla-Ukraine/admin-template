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

		return true;
	}
}