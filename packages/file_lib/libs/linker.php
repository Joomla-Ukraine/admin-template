<?php
/**
 * @author           Denys Nosov, web@denysdesign.com / http://denysdesign.com
 * @copyright        2018-2020 (C) EVOLVENS, https://evolvens.net. All rights reserved.
 * @copyright        2018-2020 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          commerce
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class linker
{
	protected $_blocks;

	protected $counter;

	/**
	 * linker constructor.
	 *
	 * @since 1.5
	 */
	public function __construct()
	{
	}

	/**
	 * @param        $text
	 * @param        $metakey
	 * @param null   $defaultmetakeys
	 * @param string $link
	 *
	 * @return null|string|string[]
	 *
	 * @throws \Exception
	 * @since 1.5
	 */
	public function prepare($text, $metakey, $defaultmetakeys = null, $link = '/topics/')
	{
		$app    = Factory::getApplication();
		$option = $app->input->get('option');
		$view   = $app->input->get('view');

		if(!($option === 'com_content' && $view === 'article'))
		{
			return true;
		}

		$this->counter   = 0;
		$this->link      = '';
		$this->_blocks[] = [];

		$metakey = ($defaultmetakeys ? $defaultmetakeys . ', ' : '') . $metakey;
		$metakey = ltrim($metakey, ',');
		$metakey = rtrim($metakey, ',');
		$matches = explode(',', $metakey);

		$reg = 'code|pre|textarea|script|style|embed|abbr|acronym|address|applet|area|audio|video|canvas|form|label|legend|link|map|noscript|object|picture|svg|frame|hr|figure|figcaption|blockquote|a|iframe|meta|img';

		preg_match_all('!(<(?:' . $reg . ').*?>.*?</(?:' . $reg . ')>)!si', $text, $pre);
		$text = preg_replace('!<(?:' . $reg . ').*?>.*?</(?:' . $reg . ')>!si', '#pre#', $text);

		if(!empty($matches))
		{
			foreach($matches as $match)
			{
				$keywords_str = null;
				$href         = null;

				list($keywords_str) = preg_split('~[=\|]~isu', $match);

				$keywords = explode(',', $keywords_str);
				foreach($keywords as $keyword)
				{
					$keyword = trim($keyword);
					$href    = $link . $keyword;

					if((strpos($keyword, '[') !== false) && (strpos($keyword, ']') !== false))
					{
						$keyword = str_replace([
							'[',
							']',
							':'
						], [
							'(?:',
							')',
							'|'
						], $keyword);
					}

					$regex      = '#(\s|[\>\'\"\«\‘\“\„])(' . $keyword . ')(\s|[\<\.,\'\"\»\’\”\;\:\!\?\)]){1}#iu';
					$this->link = '${1}<a href="' . $href . '">${2}</a>${3}';
					$text       = preg_replace($regex, $this->link, $text, 1);
				}
			}
		}

		if(!empty($pre[ 0 ]))
		{
			foreach($pre[ 0 ] as $tag)
			{
				$text = preg_replace('!#pre#!', $tag, $text, 1);
			}
		}

		return $text;
	}
}