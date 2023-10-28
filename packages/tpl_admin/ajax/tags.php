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

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\Session\SessionInterface;

header('Content-type: application/json; charset=utf-8');

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', dirname(__DIR__, 3));
define('MAX_SIZE', '500');

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

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
		$arr = explode(',', $mod->metakey);
		sort($arr);

		$i = 0;
		foreach($arr as $row)
		{
			if(trim($row) != '' && $i <= 15)
			{
				$pos = strpos(mb_strtolower(trim($row)), mb_strtolower($search));
				if($pos !== false)
				{
					$str = trim($row);
					$str = str_replace([
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

	$items = [];
	foreach($inputs as $input)
	{
		$items[] = [ 'tag' => $input ];
	}

	$keyword = [];
	foreach($items as $k => $v)
	{
		$keyword[] = $v;
	}

	$keyword = [ 'data' => $keyword ];

	echo json_encode($keyword);
}