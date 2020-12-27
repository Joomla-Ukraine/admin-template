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

header('Content-type: application/json; charset=utf-8');

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__, 3));

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

use Joomla\CMS\Factory;

$app    = Factory::getApplication('site');
$app->loadDispatcher();

echo (new tags())->run();

class tags
{
	/**
	 * @throws \Exception
	 * @since 1.0
	 */
	public function __construct()
	{
		$this->user   = Factory::getUser();
		$this->app    = Factory::getApplication();
		$this->db     = Factory::getDbo();
		$this->search = $this->app->input->getString('term');
	}

	/**
	 * @return string
	 *
	 * @since 1.0
	 */
	public function run()
	{

		if($this->user->id < 1)
		{
			return false;
		}

		if(isset($this->search))
		{
			$query = $this->db->getQuery(true);

			$query->select([ 'a.metakey' ]);
			$query->from($this->db->quoteName('#__content') . ' AS a');
			$query->where(($this->db->quoteName('a.metakey') . ' LIKE ' . $this->db->quote('%' . $this->search . '%') . ' OR ' . $this->db->quoteName('a.metakey') . ' LIKE ' . $this->db->quote($this->search . '%')));
			$query->group('a.metakey');
			$query->order('a.metakey ASC');
			$this->db->setQuery($query, 0, 30);
			$rows = $this->db->loadObjectList();

			sort($rows);
			$data = [];
			foreach($rows as $mod)
			{
				sort($arr);
				$arr = explode(',', $mod->metakey);
				$i   = 0;
				foreach($arr as $row)
				{
					if(trim($row) != '' && $i <= 15)
					{
						$pos = strpos(mb_strtolower(trim($row)), mb_strtolower($this->search));
						if($pos !== false)
						{
							$str    = trim($row);
							$str    = str_replace([
								'"',
								'»',
								'«',
								'”',
								'“'
							], '', $str);
							$data[] = $str;
						}
					}

					$i++;
				}
			}

			$inputs = array_unique($data, SORT_LOCALE_STRING);

			$keyword = [];
			foreach($inputs as $k => $v)
			{
				$keyword[] = $v;
			}

			return json_encode($keyword);
		}

		return false;
	}
}