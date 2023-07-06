<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

header('Content-type: application/json; charset=utf-8');

$data = [
	'data' => [
		[
			'tag'   => "Bikes4Ukraine",
			'count' => rand(0, 100),
		],
		[
			'tag'   => "find Bikes4Ukraine",
			'count' => rand(0, 100),
		],
		[
			'tag'   => "Venezuela",
			'count' => rand(0, 100),
		],
		[
			'tag'   => "Rodrigo Figueredo",
			'count' => rand(0, 100),
		],
		[
			'tag'   => "CERT-UA",
			'count' => rand(0, 100),
		],
		[
			'tag'   => "Bushmaster",
			'count' => rand(0, 100),
		]
	]
];

echo json_encode($data);

die;
define('_JEXEC', 1);
define('JPATH_BASE', $_SERVER[ 'DOCUMENT_ROOT' ]);

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

error_reporting(1);
ini_set('display_errors', 1);

use Joomla\CMS\Factory;

$_app = Factory::getApplication('site');
$user = Factory::getUser();

$_app->initialise();

if($user->get('id') < 1)
{
	return;
}

$app    = Factory::getApplication();
$search = $app->input->getString('term');

if(isset($search))
{
	$db    = Factory::getDbo();
	$query = $db->getQuery(true);

	$query->select([ 'a.metakey' ]);
	$query->from($db->quoteName('#__content') . ' AS a');
	$query->where(($db->quoteName('a.metakey') . ' LIKE ' . $db->quote('%' . $search . '%') . ' OR ' . $db->quoteName('a.metakey') . ' LIKE ' . $db->quote($search . '%')));
	$query->group('a.metakey');
	$query->order('a.metakey ASC');
	$db->setQuery($query, 0, 30);
	$rows = $db->loadObjectList();

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
				$pos = strpos(mb_strtolower(trim($row)), mb_strtolower($search));
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

	echo json_encode($keyword);
}