<?php
/**
 * @author           Denys Nosov, web@denysdesign.com / http://denysdesign.com
 * @copyright        2018-2019 (C) EVOLVENS, https://evolvens.net. All rights reserved.
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          commerce
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Static class to handle loading of libraries.
 *
 * @package          Joomla.Site
 * @subpackage       seblod
 * @since            1.5
 */
class FBS
{
	/**
	 * @param      $config
	 * @param      $fields
	 * @param      $f_text
	 *
	 * @param int  $tags
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function typography($config, $fields, $f_text, $tags = 1)
	{
		require_once __DIR__ . '/emt/EMT.php';

		$text = $fields[ $f_text ]->value;

		$text = str_replace([
			'<p><br />',
			'<br /></p>',
			'<li>—',
			'<li>-',
			'&nbsp;'
		], [
			'<p>',
			'</p>',
			'<li>',
			'<li>',
			' '
		], $text);

		preg_match_all('!(\[socpost\].*?\[/socpost\])!si', $text, $pre);
		$text = preg_replace('!\[socpost\].*?\[/socpost\]!si', '#pre#', $text);

		$typograf = new EMTypograph();
		$typograf->set_text($text);
		$typograf->setup([
			'Text.paragraphs'                  => 'off',
			'Text.breakline'                   => 'off',
			'OptAlign.all'                     => 'off',
			'Nobr.spaces_nobr_in_surname_abbr' => 'off',
			'Etc.split_number_to_triads'       => 'off'
		]);

		$result = $typograf->apply();

		if($tags == 0)
		{
			$result = html_entity_decode(strip_tags($result));
		}
		else
		{
			$result = str_replace('<p></p>', '', $result);

			if(!empty($pre[ 0 ]))
			{
				foreach($pre[ 0 ] as $tag)
				{
					$result = preg_replace('!#pre#!', $tag, $result, 1);
				}
			}
		}

		$result = preg_replace_callback('/\[quote\](.*?)\[\/quote\]/is', static function ($matches)
		{
			return '<blockquote><p class="uk-margin-small-bottom">' . trim($matches[ 1 ]) . '</p></blockquote>';
		}, $result);

		$result = preg_replace_callback('/\[quote=(.*?)\](.*?)\[\/quote\]/is', static function ($matches)
		{
			return '<blockquote><p class="uk-margin-small-bottom">' . trim($matches[ 2 ]) . '</p><footer>' . trim($matches[ 1 ]) . '</footer></blockquote>';

		}, $result);

		$name                                    = $fields[ $f_text ]->storage_field;
		$table                                   = $fields[ $f_text ]->storage_table;
		$config[ 'storages' ][ $table ][ $name ] = $result;

		return true;
	}

	/**
	 * @param $config
	 * @param $fields
	 * @param $f_desc
	 * @param $f_gal
	 * @param $f_img
	 *
	 *
	 * @since 1.5
	 */
	public function gallery($config, $fields, $f_desc, $f_gal, $f_img)
	{
		if($fields[ $f_img ]->value == '')
		{
			$regex = "/{gallery\s+(.*?)}/i";
			preg_match_all($regex, $fields[ $f_desc ]->value, $matches, PREG_SET_ORDER);

			if(is_array($matches) && count($matches))
			{
				$folder = $matches[ 0 ][ 1 ];
			}
			else
			{
				$folder = $fields[ $f_gal ]->value;
			}

			$root       = JPATH_ROOT . '/';
			$img_folder = $root . $folder;

			if(is_dir($img_folder))
			{
				$images                                  = glob($img_folder . '/{*.[jJ][pP][gG],*.[jJ][pP][eE][gG],*.[gG][iI][fF],*.[pP][nN][gG],*.[bB][mM][pP],*.[tT][iI][fF],*.[tT][iI][fF][fF]}', GLOB_BRACE);
				$images                                  = str_replace($root, '', $images);
				$name                                    = $fields[ $f_img ]->storage_field;
				$table                                   = $fields[ $f_img ]->storage_table;
				$config[ 'storages' ][ $table ][ $name ] = $images[ 0 ];
			}
		}
	}

	/**
	 * @param        $config
	 * @param        $fields
	 * @param        $f_lat
	 * @param        $f_lng
	 * @param        $address
	 * @param string $lang
	 * @param string $rand
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function geo($config, $fields, $f_lat, $f_lng, $address, $lang = 'ru', $rand = '0')
	{
		if(!($fields[ $f_lat ]->value || $fields[ $f_lng ]->value))
		{
			$address  = implode(', ', $address);
			$url      = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=' . $lang . '&address=' . urlencode($address);
			$lat_long = get_object_vars(json_decode(@file_get_contents($url)));

			$lat = $lat_long[ 'results' ][ 0 ]->geometry->location->lat;
			$this->_geoloc($config, $fields, $lat, $f_lat, $rand);

			$lng = $lat_long[ 'results' ][ 0 ]->geometry->location->lng;
			$this->_geoloc($config, $fields, $lng, $f_lng, $rand);
		}

		if(!($fields[ $f_lat ]->value || $fields[ $f_lng ]->value))
		{
			$url      = 'http://www.mapquestapi.com/geocoding/v1/address?key=tYxpXFUGl1Eexk27FSAP1P98OAgJNjUV&location=' . urlencode($address);
			$lat_long = get_object_vars(json_decode(@file_get_contents($url)));

			$lat = $lat_long[ 'results' ][ 0 ]->locations[ 0 ]->latLng->lat;
			$this->_geoloc($config, $fields, $lat, $f_lat, $rand);

			$lng = $lat_long[ 'results' ][ 0 ]->locations[ 0 ]->latLng->lng;
			$this->_geoloc($config, $fields, $lng, $f_lng, $rand);
		}

		return true;
	}

	/**
	 * @param        $config
	 * @param        $fields
	 * @param        $latlng
	 * @param        $f_loc
	 * @param string $rand
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	private function _geoloc($config, $fields, $latlng, $f_loc, $rand = '0')
	{
		if($latlng)
		{
			if($rand == '1')
			{
				if(mt_rand(0, 1) == 1)
				{
					$rand   = mt_rand(0, 5);
					$latlng = round($latlng, $rand);
				}
				else
				{
					$rand   = mt_rand(1, 5);
					$latlng = substr($latlng, 0, '-' . $rand);
				}
			}

			$name                                    = $fields[ $f_loc ]->storage_field;
			$table                                   = $fields[ $f_loc ]->storage_table;
			$config[ 'storages' ][ $table ][ $name ] = $latlng;
		}

		return true;
	}

	/**
	 * @param $config
	 * @param $fields
	 * @param $f_user_id
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function user_id($config, $fields, $f_user_id)
	{
		if($config[ 'isNew' ] == 1)
		{
			$name                                    = $fields[ $f_user_id ]->storage_field;
			$table                                   = $fields[ $f_user_id ]->storage_table;
			$config[ 'storages' ][ $table ][ $name ] = Factory::getUser()->id;
		}

		return true;
	}

	/**
	 * Fix publish_up
	 *
	 * @param $config
	 *
	 * @param $fields
	 * @param $f_created
	 * @param $f_publish_up
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function publish_up($config, $fields, $f_created, $f_publish_up)
	{
		$name  = $fields[ $f_publish_up ]->storage_field;
		$table = $fields[ $f_publish_up ]->storage_table;

		if($config[ 'isNew' ] == 1)
		{
			if($fields[ $f_created ]->value)
			{
				$config[ 'storages' ][ $table ][ $name ] = $fields[ $f_created ]->value;
			}
			else
			{
				date_default_timezone_set('UTC');
				$config[ 'storages' ][ $table ][ $name ] = date('Y-m-d H:i:s');
			}
		}
		elseif($fields[ $f_created ]->value == '')
		{
			date_default_timezone_set('UTC');
			$datenow = date('Y-m-d H:i:s');

			$config[ 'storages' ][ $table ][ $name ] = $datenow;

			$c_name  = $fields[ $f_created ]->storage_field;
			$c_table = $fields[ $f_created ]->storage_table;

			$config[ 'storages' ][ $c_table ][ $c_name ] = $datenow;
		}

		return true;
	}

	/**
	 * Check video
	 *
	 * @param $config
	 * @param $fields
	 * @param $f_check_video
	 * @param $f_desc
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function check_video($config, $fields, $f_check_video, $f_desc)
	{
		$text = $fields[ $f_desc ]->value;

		$regex1 = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^>"&?/ ]{11})%i';
		$regex2 = '#(player.vimeo.com)/video/([\d]+)#i';

		$check_video = '0';
		if(preg_match($regex1, $text) || preg_match($regex2, $text))
		{
			$check_video = '1';
		}

		$name                                    = $fields[ $f_check_video ]->storage_field;
		$table                                   = $fields[ $f_check_video ]->storage_table;
		$config[ 'storages' ][ $table ][ $name ] = $check_video;

		return true;
	}

	/**
	 * Check gallery
	 *
	 * @param $config
	 * @param $fields
	 * @param $f_check_gallery
	 * @param $f_desc
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function check_gallery($config, $fields, $f_check_gallery, $f_desc)
	{
		$text = $fields[ $f_desc ]->value;

		$regex = '/{gallery\s+(.*?)}/i';

		$check_gallery = '0';
		if(preg_match($regex, $text))
		{
			$check_gallery = '1';
		}

		$name                                    = $fields[ $f_check_gallery ]->storage_field;
		$table                                   = $fields[ $f_check_gallery ]->storage_table;
		$config[ 'storages' ][ $table ][ $name ] = $check_gallery;

		return true;
	}

	/**
	 * Fix YouTube URL for plugin YouTube
	 *
	 * @param $config
	 * @param $fields
	 * @param $f_youtube
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function yt_url($config, $fields, $f_youtube)
	{
		$url = $fields[ $f_youtube ]->value;

		if($url)
		{
			$url = preg_replace("/http(s)?:\/\/youtu\.be\/([^\40\t\r\n\<]+)/i", 'https://www.youtube.com/watch?v=$2', $url);
			$url = preg_replace("/http(s)?:\/\/(w{3}\.)?youtube\.com\/watch\/?\?v=([^\40\t\r\n\<]+)/i", 'https://www.youtube.com/watch?v=$3', $url);

			parse_str(parse_url($url, PHP_URL_QUERY), $youtube_array);
			$url = 'https://www.youtube.com/watch?v=' . $youtube_array[ 'v' ];

			$name                                    = $fields[ $f_youtube ]->storage_field;
			$table                                   = $fields[ $f_youtube ]->storage_table;
			$config[ 'storages' ][ $table ][ $name ] = $url;

			return true;
		}

		return '';
	}

	/**
	 * Create YouTube default image for field *_ytimage
	 *
	 * @param $config
	 * @param $fields
	 * @param $f_img
	 * @param $f_youtube
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function yt_cover($config, $fields, $f_img, $f_youtube)
	{
		$name                                    = $fields[ $f_img ]->storage_field;
		$table                                   = $fields[ $f_img ]->storage_table;
		$config[ 'storages' ][ $table ][ $name ] = self::_video($fields[ $f_youtube ]->value);

		return true;
	}

	/**
	 * @param $config
	 * @param $fields
	 * @param $f_youtube
	 *
	 * @return bool
	 *
	 * @since 1.5
	 */
	public function yt_watch($config, $fields, $f_youtube)
	{
		$url = $fields[ $f_youtube ]->value;

		if($url)
		{
			$name                                    = $fields[ $f_youtube ]->storage_field;
			$table                                   = $fields[ $f_youtube ]->storage_table;
			$config[ 'storages' ][ $table ][ $name ] = self::_yt_link($fields[ $f_youtube ]->value);

			return true;
		}

		return false;
	}

	/**
	 * Function for YouTube or Vimeo
	 *
	 * @param $url
	 *
	 * @return bool|string
	 *
	 * @since 1.5
	 */
	public static function _video($url)
	{
		$urls = parse_url($url);
		$yid  = '';
		$vid  = '';

		if($urls[ 'host' ] === 'vimeo.com')
		{
			$vid = ltrim($urls[ 'path' ], '/');
		}
		elseif($urls[ 'host' ] === 'youtu.be')
		{
			$yid = ltrim($urls[ 'path' ], '/');
		}
		elseif(strpos($urls[ 'path' ], 'embed') == 1)
		{
			$yend = explode('/', $urls[ 'path' ]);
			$yid  = end($yend);
		}
		elseif(strpos($url, '/') === false)
		{
			$yid = $url;
		}
		else
		{
			$feature = '';

			parse_str($urls[ 'query' ], $output);
			$yid = $output[ 'v' ];
			if(!empty($feature))
			{
				$yend = explode('v=', $urls[ 'query' ]);
				$yid  = end($yend);
				$arr  = explode('&', $yid);
				$yid  = $arr[ 0 ];
			}
		}

		if($yid)
		{
			$ytpath = 'https://img.youtube.com/vi/' . $yid;

			if(self::_http($ytpath . '/maxresdefault.jpg') == '200')
			{
				$img = $ytpath . '/maxresdefault.jpg';
			}
			elseif(self::_http($ytpath . '/hqdefault.jpg') == '200')
			{
				$img = $ytpath . '/hqdefault.jpg';
			}
			elseif(self::_http($ytpath . '/mqdefault.jpg') == '200')
			{
				$img = $ytpath . '/mqdefault.jpg';
			}
			else
			{
				$img = $ytpath . '/default.jpg';
			}

			return $img;
		}

		if($vid)
		{
			$vimeoObject = json_decode(file_get_contents('http://vimeo.com/api/v2/video/' . $vid . '.json'));

			if(!empty($vimeoObject))
			{
				return $vimeoObject[ 0 ]->thumbnail_large;
			}
		}

		return true;
	}

	/**
	 * @param $url
	 *
	 * @return bool|string
	 *
	 * @since 1.5
	 */
	public static function _yt_link($url)
	{
		$urls = parse_url($url);

		if($urls[ 'host' ] === 'youtu.be')
		{
			$yid = ltrim($urls[ 'path' ], '/');
		}
		elseif(strpos($urls[ 'path' ], 'embed') == 1)
		{
			$yend = explode('/', $urls[ 'path' ]);
			$yid  = end($yend);
		}
		elseif(strpos($url, '/') === false)
		{
			$yid = $url;
		}
		else
		{
			$feature = '';
			parse_str($urls[ 'query' ], $output);
			$yid = $output[ 'v' ];
			if(!empty($feature))
			{
				$yend = explode('v=', $urls[ 'query' ]);
				$yid  = end($yend);
				$arr  = explode('&', $yid);
				$yid  = $arr[ 0 ];
			}
		}

		if($yid)
		{
			return 'https://www.youtube.com/watch?v=' . $yid;
		}

		return true;
	}

	/**
	 * @param $url
	 *
	 * @return bool|string
	 *
	 * @since 1.5
	 */
	public static function _http($url)
	{
		$header = get_headers($url);

		return substr($header[ 0 ], 9, 3);
	}
}