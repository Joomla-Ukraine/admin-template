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

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$v = '?v=@version@';

$db        = Factory::getDBO();
$app       = Factory::getApplication();
$doc       = Factory::getDocument();
$user      = Factory::getUser();
$menu = Factory::getApplication()->getMenu();
$lang      = Factory::getLanguage();
$short_lng = explode('-', $this->params->get('lng_redir'));

if($this->params->get('lng_redir') && ($this->language !== strtolower($this->params->get('lng_redir'))))
{
	$app->redirect('/' . $short_lng[ 0 ] . '/account');
}

$sitename = $app->get('sitename');
$site_url = Uri::base();

$Itemid  = $app->input->getCmd('Itemid');
$id      = $app->input->getCmd('id');
$view    = $app->input->getCmd('view');
$layout  = $app->input->getCmd('layout');
$option  = $app->input->getCmd('option');

$headdata = $doc->getHeadData();
$params   = $app->getParams();

$this->setHtml5(true);
$this->setGenerator(null);

/*
 * add js/css & template option
 */
JHtml::_('jquery.framework');

$doc->addScript(Uri::base(true) . 'templates/admin/js/uikit/uikit.min.js' . $v);
$doc->addScript(Uri::base(true) . 'templates/admin/js/uikit/uikit-icons.min.js' . $v);
$doc->addScript(Uri::base(true) . 'templates/admin/js/uikit/uikit-icons-admin.min.js' . $v);
$doc->addScript(Uri::base(true) . 'templates/admin/js/jq.js' . $v);

$doc->addStyleSheet(Uri::base(true) . 'templates/admin/css/uikit.admin.css' . $v);

// preload js
$doc->addHeadLink(Uri::base(true) . 'templates/admin/js/uikit/uikit.min.js' . $v, 'preload', 'rel', [ 'as' => 'script' ]);
$doc->addHeadLink(Uri::base(true) . 'templates/admin/js/uikit/uikit-icons.min.js' . $v, 'preload', 'rel', [ 'as' => 'script' ]);
$doc->addHeadLink(Uri::base(true) . 'templates/admin/js/uikit/uikit-icons-admin.min.js' . $v, 'preload', 'rel', [ 'as' => 'script' ]);
$doc->addHeadLink(Uri::base(true) . 'templates/admin/js/jq.js' . $v, 'preload', 'rel', [ 'as' => 'script' ]);

// preload css
$doc->addHeadLink(Uri::base(true) . 'templates/admin/css/uikit.admin.css' . $v, 'preload', 'rel', [ 'as' => 'style' ]);

/*
 * tmpl setting
 */
$ac_edit = 0;
if($option === 'com_cck' && $view === 'form')
{
	$ac_edit = 1;
}

/*
 * Account button menu
 */
$account_button = 0;
if($this->params->get('but_stats', 0) == 1 || $this->params->get('but_soc', 0) == 1)
{
	$account_button = 1;
}

/*
 * Count Users
 */
if($this->params->get('count_users', 0))
{
	$result      = [];
	$user_array  = 0;
	$guest_array = 0;

	$query = $db->getQuery(true);
	$query->select([ 'guest', 'client_id' ]);
	$query->from('#__session');
	$query->where('client_id = 0');
	$query->group('userid');
	$db->setQuery($query);

	try
	{
		$sessions = (array) $db->loadObjectList();
	}
	catch (RuntimeException $e)
	{
		$sessions = [];
	}

	if(count($sessions))
	{
		foreach($sessions as $session)
		{
			if($session->guest == 0)
			{
				$user_array++;
			}
		}
	}

	$result[ 'user' ] = $user_array;
	$users_count      = $result[ 'user' ];
}

/*
 * Avatar User
 */
$query = $db->getQuery(true);
$query->select([ 'avatar' ]);
$query->from('#__cck_store_item_users');
$query->where('id = ' . $user->id);
$db->setQuery($query);
$_avatar = $db->loadResult();

if(!$_avatar)
{
	$_avatar = 'templates/admin/images/user.svg';
}

$avatar = '<img src="' . $this->baseurl . '/' . $_avatar . '" width="30" height="30" class="uk-border-circle uk-margin-small-right" alt="' . $user->name . '" title="' . $user->name . '">';

/*
 * Logo Panel
 */
$logo = $sitename;
if($this->params->get('logo'))
{
	$logo = '<img src="' . Uri::root() . $this->params->get('logo') . '" alt="' . $sitename . '" width="' . $this->params->get('logo_w', '70') . '">';
}
elseif($this->params->get('sitetitle'))
{
	$logo = $this->params->get('sitetitle');
}

/*
 * Logo Login
 */
$logo2 = $sitename;
if($this->params->get('logo2'))
{
	$logo2 = '<img src="' . Uri::root() . $this->params->get('logo2') . '" alt="' . $sitename . '" width="' . $this->params->get('logo2_w', '180') . '" class="uk-align-center">';
}
elseif($this->params->get('sitetitle'))
{
	$logo2 = $this->params->get('sitetitle');
}

/*
 * Color panel
 */
if($this->params->get('color'))
{
	$style = '.tm-sidebar-left {background-color:' . $this->params->get('color') . ';}';
	$doc->addStyleDeclaration($style);
}

/*
 * Logout
 */
$logout  = 'index.php?option=com_users&task=user.logout&' . JSession::getFormToken() . '=1&return=' . base64_encode(Uri::base() . 'account');
$profile = JRoute::_('index.php?option=com_users&view=profile&layout=edit');
if($this->params->get('edit_profile') == 1)
{
	$profile = $this->params->get('edit_profile_link') . $user->id . '&return=' . base64_encode(Uri::base() . 'account');
}

/*
 * Clear code
 */
// js
if(isset($this->_script[ 'text/javascript' ]))
{
	$this->_script[ 'text/javascript' ] = preg_replace('%jQuery\(window\)\.on\(\'load\',\s*function\(\)\s*{\s*new\s*JCaption\(\'img.caption\'\);\s*}\);\s*%', '', $this->_script[ 'text/javascript' ]);

	$this->_script[ 'text/javascript' ] = preg_replace('%jQuery\(function\(\$\) {\s*\$\(\'\.hasTip\'\)\.each\(function\(\) {\s*var title = \$\(this\)\.attr\(\'title\'\);\s*if \(title\) {\s*var parts = title\.split\(\'\:\:\', 2\);\s*var mtelement = document\.id\(this\);\s*mtelement\.store\(\'tip\:title\', parts\[0\]\);\s*mtelement\.store\(\'tip\:text\', parts\[1\]\);\s*}\s*}\);\s*var JTooltips = new Tips\(\$\(\'\.hasTip\'\)\.get\(\), {"maxTitleChars"\: 50,"fixed"\: false}\);\s*}\);%', '', $this->_script[ 'text/javascript' ]);

	if(empty($this->_script[ 'text/javascript' ]))
	{
		unset($this->_script[ 'text/javascript' ]);
	}
}

// js libs
unset($this->_scripts[ Uri::base(true) . '/media/jui/js/jquery.min.js' ], $this->_scripts[ Uri::root(true) . '/media/jui/js/jquery-noconflict.js' ], $this->_scripts[ Uri::root(true) . '/media/jui/js/jquery-migrate.min.js' ], $this->_scripts[ Uri::root(true) . '/media/jui/js/bootstrap.min.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/mootools-core.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/mootools-more.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/html5fallback.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/caption.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/modal.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/validate.js' ], $this->_scripts[ Uri::root(true) . '/media/system/js/punycode.js' ], $this->_scripts[ Uri::root(true) . '/media/cck/scripts/jquery-colorbox/js/jquery.colorbox-min.js' ], $this->_scripts[ Uri::root(true) . '/plugins/cck_field/calendar/assets/js/jscal2.js' ], $this->_scripts[ Uri::root(true) . '/plugins/cck_field/calendar/assets/js/lang/ru.js' ], $this->_styleSheets[ Uri::root(true) . '/plugins/cck_field/calendar/assets/css/jscal2.css' ], $this->_styleSheets[ Uri::root(true) . '/plugins/cck_field/calendar/assets/css/border-radius.css' ], $this->_styleSheets[ Uri::root(true) . '/plugins/cck_field/calendar/assets/css/theme/steel/steel.css' ], $this->_styleSheets[ Uri::root(true) . '/templates/seb_table/css/style.css' ], $this->_styleSheets[ Uri::root(true) . '/media/cck/css/cck.site.css' ], $this->_styleSheets[ Uri::root(true) . '/plugins/cck_field/wysiwyg_editor/assets/css/cck_wysiwyg_editor.css' ], $this->_styleSheets[ Uri::root(true) . '/media/cck/scripts/jquery-colorbox/styles/style0/colorbox.css' ]);