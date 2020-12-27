<?php
/**
 * Admin Template
 *
 * @package          Joomla.Site
 * @subpackage       admin
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2018-2020 (C) Joomla! Ukraine, https://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die();

function pagination_list_footer($list)
{
	$html = "<div class=\"list-footer\">\n";

	$html .= "\n<div class=\"limit\">" . JText::_('Display Num') . $list[ 'limitfield' ] . '</div>';
	$html .= $list[ 'pageslinks' ];
	$html .= "\n<div class=\"counter\">" . $list[ 'pagescounter' ] . '</div>';

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"" . $list[ 'limitstart' ] . '" />';
	$html .= "\n</div>";

	return $html;
}

/**
 * @param $list
 *
 * @return string
 *
 * @throws \Exception
 * @since 1.5
 */
function pagination_list_render($list)
{
	$app = Factory::getApplication();
	$doc = Factory::getDocument();

	$start = $app->input->get('start');
	$tmpl  = $app->input->get('tmpl');

	$head = '';
	if($list[ 'previous' ][ 'data' ][ 'link' ] && $start > 0)
	{
		$head .= '<link href="' . $list[ 'previous' ][ 'data' ][ 'link' ] . '" rel="prev" />';
	}

	if($list[ 'next' ][ 'data' ][ 'link' ] && $start > 0)
	{
		$head .= '<link href="' . $list[ 'next' ][ 'data' ][ 'link' ] . '" rel="next" />';
	}

	if($start > 0)
	{
		$sitename = $app->get('sitename');
		$current  = str_replace($sitename, '', $doc->getTitle());
		$_page    = explode(' ', JTEXT::_('JLIB_HTML_PAGE_CURRENT_OF_TOTAL'));
		$title    = $current . '. ' . $_page[ 0 ] . ' #' . round($start / 10 + 1) . ' - ' . $sitename;
		$doc->setTitle($title);

		$head .= '<meta name="robots" content="noindex, nofollow" />';
	}

	$doc->addCustomTag($head);

	$html = '';
	$html .= '<div class="uk-margin-medium-top">';
	$html .= '<hr class="uk-divider-icon">';
	$html .= '<ul class="uk-pagination uk-flex uk-flex-middle uk-flex-center" data-uk-margin>';

	if($list[ 'start' ][ 'active' ])
	{
		$html .= '<li>' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<a\\1>&larr;</a> ', (count($list[ 'start' ][ 'data' ]) == 2 ? $list[ 'start' ][ 'data' ][ 'html' ] : $list[ 'start' ][ 'data' ])) . '</li>';
	}
	else
	{
		$html .= '<li class="uk-disabled">' . preg_replace('#<a.*?>.*?<\/a>#is', '<span>&larr;</span>', (count($list[ 'start' ][ 'data' ]) == 2 ? $list[ 'start' ][ 'data' ][ 'html' ] : $list[ 'start' ][ 'data' ])) . '</li>';
	}

	if($list[ 'previous' ][ 'active' ])
	{
		$html .= '<li>' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<a\\1 class="uk-pagination-previous">«</a>', (count($list[ 'previous' ][ 'data' ]) == 2 ? $list[ 'previous' ][ 'data' ][ 'html' ] : $list[ 'previous' ][ 'data' ])) . '</li>';
	}
	else
	{
		$html .= '<li class="uk-disabled">' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<span>&laquo;</span>', (count($list[ 'previous' ][ 'data' ]) == 2 ? $list[ 'previous' ][ 'data' ][ 'html' ] : $list[ 'previous' ][ 'data' ])) . '</li>';
	}

	$i = 0;
	foreach($list[ 'pages' ] as $page)
	{
		if($page[ 'data' ][ 'html' ] > 5)
		{
			$html .= '<li class="' . ($i < 5 ? 'uk-visible@s ' : '') . (($page[ 'active' ] == 1) ? '' : 'uk-active') . '">' . (count($page[ 'data' ]) == 2 ? $page[ 'data' ][ 'html' ] : $page[ 'data' ]) . ' </li>';
		}
		else
		{
			$html .= '<li class="' . ($i >= 6 ? 'uk-visible@s ' : '') . (($page[ 'active' ] == 1) ? '' : 'uk-active') . '">' . (count($page[ 'data' ]) == 2 ? $page[ 'data' ][ 'html' ] : $page[ 'data' ]) . ' </li>';
		}
		$i++;
	}

	if($list[ 'next' ][ 'active' ])
	{
		$html .= '<li>' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<a\\1 class="uk-pagination-next">»</a> ', (count($list[ 'next' ][ 'data' ]) == 2 ? $list[ 'next' ][ 'data' ][ 'html' ] : $list[ 'next' ][ 'data' ])) . '</li>';
	}
	else
	{
		$html .= '<li class="uk-disabled">' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<span>&raquo;</span>', (count($list[ 'next' ][ 'data' ]) == 2 ? $list[ 'next' ][ 'data' ][ 'html' ] : $list[ 'next' ][ 'data' ])) . '</li>';
	}

	if($list[ 'end' ][ 'active' ])
	{
		$html .= '<li>' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<a\\1>&rarr;</a> ', (count($list[ 'end' ][ 'data' ]) == 2 ? $list[ 'end' ][ 'data' ][ 'html' ] : $list[ 'end' ][ 'data' ])) . '</li>';
	}
	else
	{
		$html .= '<li class="uk-disabled">' . preg_replace('#<a(.*?)>(.*?)</a>#is', '<span>&rarr;</span> ', (count($list[ 'end' ][ 'data' ]) == 2 ? $list[ 'end' ][ 'data' ][ 'html' ] : $list[ 'end' ][ 'data' ])) . '</li>';
	}

	$html .= '</ul>';
	$html .= '</div>';

	if($tmpl === 'none')
	{
		$html = str_replace('?tmpl=none&amp;', '?', $html);
		$html = str_replace([
			'&amp;tmpl=none',
			'?tmpl=none'
		], '', $html);
	}

	return $html;
}

/**
 * @param $item
 *
 * @return array
 *
 * @since 1.5
 */
function pagination_item_active(&$item)
{
	$link  = str_replace([
		'&amp;limitstart=0',
		'?limitstart=0'
	], '', $item->link);
	$_link = JURI::base() . $link;
	$_link = str_replace('//', '/', $_link);


	$data = [
		'html' => '<a href="' . $link . '">' . $item->text . '</a>',
		'link' => $_link
	];

	return $data;
}

/**
 * @param $item
 *
 * @return string
 *
 * @since 1.5
 */
function pagination_item_inactive(&$item)
{
	return '<a>' . $item->text . '</a>';
}