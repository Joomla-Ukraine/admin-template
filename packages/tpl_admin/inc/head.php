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

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;

//use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

$v = '2.0.2';

$app  = Factory::getApplication();
$wa   = $this->getWebAssetManager();
$lang = Factory::getLanguage();
$doc  = Factory::getDocument();
//$user = Factory::getUser();
$user = $app->getIdentity();
$db   = Factory::getDBO();
$menu = $app->getMenu();

$this->setHtml5(true);
$this->setGenerator(null);

$Itemid = $app->input->getCmd('Itemid');
$view   = $app->input->getCmd('view');
$layout = $app->input->getCmd('layout');
$option = $app->input->getCmd('option');

$sitename  = $app->get('sitename');
$site_url  = Uri::base();
$admin_app = Uri::base() . 'templates/' . $this->template . '/app';
$short_lng = explode('-', $this->params->get('lng_redir'));

$headdata = $doc->getHeadData();
$params   = $app->getParams();

if($this->params->get('lng_redir') && ($this->language !== strtolower($this->params->get('lng_redir'))))
{
	$app->redirect('/' . $short_lng[ 0 ] . '/account');
}

/*
 * Head
 */
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// JS
$wa->registerAndUseScript('app.uk', $admin_app . '/js/app.uk.' . $v . '.js', [ 'version' => false ], [
	'fetchpriority' => 'high'
]);

$wa->registerAndUseScript('app.main', $admin_app . '/js/app.main.' . $v . '.js', [ 'version' => false ], [
	'defer'         => 'defer',
	'fetchpriority' => 'auto'
]);
$wa->registerAndUseScript('app.vendors', $admin_app . '/js/app.vendors.' . $v . '.js', [ 'version' => false ], [
	'defer'         => 'defer',
	'fetchpriority' => 'auto'
]);

$jspreloads = [
	'uk',
	'main',
	'vendors'
];
foreach($jspreloads as $jspreload)
{
	$doc->addHeadLink($admin_app . '/js/app.' . $jspreload . '.' . $v . '.js', 'preload', 'rel', [
		'as' => 'script'
	]);
}

// CSS
$wa->registerAndUseStyle('app.main', $admin_app . '/css/app.main.' . $v . '.css', [ 'version' => false ], []);
$doc->addHeadLink($admin_app . '/css/app.main.' . $v . '.css', 'preload', 'rel', [
	'as' => 'style'
]);

// tmpl setting
$ac_edit = 0;
if($option === 'com_cck' && $view === 'form')
{
	$ac_edit = 1;
}

// Avatar User
$avatar = (new FileLayout('tpl.modules.avatar'))->render([
	'params'  => $this->params,
	'db'      => $db,
	'user'    => $user,
	'baseurl' => $this->baseurl,
]);

// Logo Panel
$logo = (new FileLayout('tpl.modules.logo'))->render([
	'params'    => $this->params,
	'sitename'  => $sitename,
	'logo'      => Uri::root() . $this->params->get('logo'),
	'width'     => $this->params->get('logo_w', '70'),
	'img_class' => 'uk-logo',
	'loading'   => false,
	'decoding'  => false
]);

// Logo Login
$logo2 = (new FileLayout('tpl.modules.logo2'))->render([
	'params'   => $this->params,
	'sitename' => $sitename
]);

// Color panel
if($this->params->get('color'))
{
	$style = '.tm-sidebar-left {background-color:' . $this->params->get('color') . ';}';
	$wa->addInlineStyle($style);
}
