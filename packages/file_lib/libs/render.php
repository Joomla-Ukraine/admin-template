<?php
/**
 * @author           Denys Nosov, web@denysdesign.com / http://denysdesign.com
 * @copyright        2018-2019 (C) EVOLVENS, https://evolvens.net. All rights reserved.
 * @copyright        2018-2019 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          commerce
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class Render
{
	/**
	 * @param     $position
	 * @param int $style
	 *
	 * @return string
	 *
	 * @since 1.5
	 */
	public function _module($position, $style = -2)
	{
		$document = Factory::getDocument();
		$renderer = $document->loadRenderer('module');
		$params   = [ 'style' => $style ];
		$contents = '';

		foreach(JModuleHelper::getModules($position) as $mod)
		{
			$contents .= $renderer->render($mod, $params);
		}

		return $contents;
	}

	/**
	 * @param        $addTo
	 * @param        $add
	 * @param int    $cntRep
	 * @param string $after
	 *
	 * @return string
	 *
	 * @since 1.5
	 */
	public function _context($addTo, $add, $cntRep = 6, $after = '</p>')
	{
		$posAfter = 0;
		for($i = 0; $i < $cntRep; $i++)
		{
			$pos      = stripos($addTo, $after, $posAfter);
			$posAfter = $pos + strlen($after);
			if($pos === false)
			{
				return $addTo;
			}
		}
		$beforeAdding = substr($addTo, 0, $posAfter);
		$afterAdding  = substr($addTo, $posAfter);

		return $beforeAdding . $add . $afterAdding;
	}

	/**
	 * @param        $html
	 * @param        $add
	 * @param        $cntRep
	 * @param string $after
	 *
	 * @return string
	 *
	 * @since 1.5
	 */
	public function _content($html, $add, $cntRep, $after = '</p>')
	{
		$contents = explode($after, $html);
		$result   = [];
		$i        = 0;

		foreach($contents as $content)
		{
			if($i == $cntRep)
			{
				$result[] = $add;
				$i        = 0;
			}

			$result[] = $content . $after;

			$i++;
		}

		$result = implode($result);
		$result = str_replace([
			'</p></p>',
			'</p> </p>',
			'</table></p>',
			'</ul></p>',
			'</ol></p>'
		], [
			'</p>',
			'</p>',
			'</table>',
			'</ul>',
			'</ol>'
		], $result);

		return $result;
	}

	/**
	 * @param $url
	 *
	 * @return bool|string
	 *
	 * @since 1.5
	 */
	public static function video($url)
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
			$v_path = explode('/', $urls[ 'path' ]);
			$yid    = end($v_path);
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
				$v_query = explode('v=', $urls[ 'query' ]);
				$yid     = end($v_query);
				$arr     = explode('&', $yid);
				$yid     = $arr[ 0 ];
			}
		}

		if($yid)
		{
			return 'https://img.youtube.com/vi/' . $yid . '/hqdefault.jpg';
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
}