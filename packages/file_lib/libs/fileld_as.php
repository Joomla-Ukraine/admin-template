<?php
/**
 * @author           Denys Nosov, web@denysdesign.com / http://denysdesign.com
 * @copyright        2018-2019 (C) EVOLVENS, https://evolvens.net. All rights reserved.
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          commerce
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Nested;

/**
 * Static class to handle loading of libraries.
 *
 * @package          Joomla.Site
 * @subpackage       seblod
 * @since            1.5
 */
class FAS
{
	/**
	 * @return bool
	 *
	 * @since            1.5
	 */
	public function clearCache()
	{
		if(is_dir(JPATH_ROOT . '/cache/'))
		{
			if(is_dir(JPATH_ROOT . '/cache/com_modules/'))
			{
				$this->unlinkRecursive(JPATH_ROOT . '/cache/com_modules/', '1');
			}

			$this->unlinkRecursive(JPATH_ROOT . '/cache/com_cck**', '1');

			if(is_dir(JPATH_ROOT . '/cache/com_cck/'))
			{
				$this->unlinkRecursive(JPATH_ROOT . '/cache/com_cck/', '1');
			}

			if(is_dir(JPATH_ROOT . '/cache/com_home/'))
			{
				$this->unlinkRecursive(JPATH_ROOT . '/cache/com_home/', '1');
			}

			return true;
		}

		return false;
	}

	/**
	 * @param       $config
	 * @param       $fields
	 * @param       $f_text
	 * @param array $attr
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function addMenuItem($config, $fields, $f_text, array $attr = [])
	{
		$item = $fields[ $f_text ]->value;
		if($item == 0)
		{
			$data = [
				'menutype'          => $attr[ 'menutype' ],
				'title'             => $attr[ 'title' ],
				'alias'             => $attr[ 'alias' ] ? $attr[ 'alias' ] : '',
				'link'              => $attr[ 'link' ],
				'type'              => 'component',
				'published'         => $attr[ 'published' ],
				'parent_id'         => $attr[ 'parent_id' ],
				'level'             => $attr[ 'level' ],
				'component_id'      => $attr[ 'component_id' ],
				'access'            => 1,
				'template_style_id' => 0,
				'params'            => '{"show_list_title":"","tag_list_title":"h1","class_list_title":"","display_list_title":"0","title_list_title":"","show_list_desc":"","list_desc":"","tag_list_desc":"div","show_form":"","show_list":"","auto_redirect":"","auto_redirect_vars":"","limit2":"0","pagination2":"","ordering":"","order_by":"","ordering2":"","show_items_number":"","show_items_number_label":"Results","class_items_number":"total","show_pages_number":"","show_pagination":"","class_pagination":"pagination","live":"' . $attr[ 'cat_id' ] . '","variation":"","search2":"","limit":"0","raw_rendering":"1","sef":"","display_form_title":"","title_form_title":"","urlvars":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_image_css":"","menu_text":1,"menu_show":1,"page_title":"","show_page_heading":"","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}',
				'home'              => 0,
				'language'          => $attr[ 'lang' ],
				'client_id'         => 0
			];

			$table = Nested::getInstance('Menu');
			$table->setLocation($attr[ 'parent_id' ], 'last-child');

			if(!$table->save($data))
			{
				return false;
			}

			$db    = Factory::getDbo();
			$query = $db->getQuery(true);

			$query->select([ 'id' ]);
			$query->from('#__menu');
			$query->where($db->quoteName('menutype') . ' = ' . $db->quote($data[ 'menutype' ]));
			$query->where($db->quoteName('title') . ' = ' . $db->quote($data[ 'title' ]));

			if($data[ 'alias' ])
			{
				$query->where($db->quoteName('alias') . ' = ' . $db->quote($data[ 'alias' ]));
			}

			$query->where($db->quoteName('client_id') . ' = ' . $db->quote($data[ 'client_id' ]));
			$query->where($db->quoteName('link') . ' = ' . $db->quote($data[ 'link' ]));
			$query->where($db->quoteName('params') . ' LIKE ' . $db->quote('%' . $attr[ 'cat_id' ] . '%'));
			$query->where($db->quoteName('type') . ' = ' . $db->quote($data[ 'type' ]));
			$query->where($db->quoteName('parent_id') . ' = ' . $db->quote($data[ 'parent_id' ]));
			$query->where($db->quoteName('home') . ' = ' . $db->quote($data[ 'home' ]));
			$db->setQuery($query);

			$result = $db->loadResult();

			if($result)
			{
				$object                                      = new stdClass();
				$object->id                                  = $config[ 'pk' ];
				$object->{$fields[ $f_text ]->storage_field} = $result;

				$db->updateObject($fields[ $f_text ]->storage_table, $object, 'id');
			}

			return true;
		}

		return false;
	}

	/**
	 * @param $config
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function voteme($config)
	{
		$db   = Factory::getDbo();
		$id   = (int) $config[ 'pk' ];
		$rate = mt_rand(4, 5);

		$query = $db->getQuery(true);
		$query->select([ '*' ])->from('#__content_rating')->where($db->quoteName('content_id') . ' = ' . $db->quote($id));
		$db->setQuery($query);

		$rating = $db->loadObject();
		if(!$rating)
		{
			$rq = $db->getQuery(true);

			$columns = [
				'content_id',
				'rating_sum',
				'rating_count',
				'lastip'
			];

			$values = [
				$db->quote($id),
				$db->quote($rate),
				$db->quote('1'),
				$db->quote($this->get_ip())
			];

			$rq->insert($db->quoteName('#__content_rating'))->columns($db->quoteName($columns))->values(implode(',', $values));
			$db->setQuery($rq);
			$db->execute();
		}

		return true;
	}

	/**
	 *
	 * @return string
	 *
	 * @since 1.5
	 */
	public function get_ip()
	{
		if(!empty(getenv('HTTP_CLIENT_IP')))
		{
			$ipaddress = getenv('HTTP_CLIENT_IP');
		}
		elseif(!empty(getenv('HTTP_X_FORWARDED_FOR')))
		{
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif(!empty(getenv('HTTP_X_FORWARDED')))
		{
			$ipaddress = getenv('HTTP_X_FORWARDED');
		}
		elseif(!empty(getenv('HTTP_FORWARDED_FOR')))
		{
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		}
		elseif(!empty(getenv('HTTP_FORWARDED')))
		{
			$ipaddress = getenv('HTTP_FORWARDED');
		}
		elseif(!empty(getenv('REMOTE_ADDR')))
		{
			$ipaddress = getenv('REMOTE_ADDR');
		}
		else
		{
			$ipaddress = 'UNKNOWN';
		}
		$ips = explode(',', $ipaddress);

		return trim($ips[ 0 ]);
	}

	/**
	 * @param      $dir
	 * @param null $deleteRootToo
	 *
	 * @return bool
	 *
	 * @since            1.5
	 */
	public function unlinkRecursive($dir, $deleteRootToo = null)
	{
		$folders = glob($dir, GLOB_BRACE);

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

		return true;
	}
}