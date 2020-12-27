<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2020 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          GNU General Public License version 2 or later
 */

error_reporting(0);
ini_set('display_errors', 0);

echo (new cache())->run();

class cache
{
	/**
	 * @since 1.0
	 */
	public function __construct()
	{
		$this->root = dirname(__DIR__, 3);
	}

	/**
	 * @return string
	 *
	 * @since 1.0
	 */
	public function run()
	{
		$html = $this->unlinkRecursive($this->root . '/cache/com_cck**', '1');

		if(is_dir($this->root . '/cache/com_home/'))
		{
			$html .= $this->unlinkRecursive($this->root . '/cache/com_home/', '1');
		}

		return $html;
	}

	/**
	 * @param      $dir
	 * @param null $deleteRootToo
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	private function unlinkRecursive($dir, $deleteRootToo = null)
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

				$notification[] = '<span data-uk-icon="icon: check"></span> ' . trim(str_replace($this->root . '/cache/', '', $folder), '/') . '<br>';

				if(!unlink($folder . '/' . $obj))
				{
					$this->unlinkRecursive($folder . '/' . $obj, true);
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
}