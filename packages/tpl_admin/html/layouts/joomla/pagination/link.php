<?php
/**
 * MCIT Template
 *
 * @package          Joomla.Site
 * @subpackage       a
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2016-2023 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;

$item    = $displayData[ 'data' ];
$display = $item->text;
$app     = Factory::getApplication();

switch((string) $item->text)
{
	// Check for "Start" item
	case Text::_('JLIB_HTML_START'):
		$icon = $app->getLanguage()->isRtl() ? 'arrow-right' : 'arrow-left';
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		break;

	// Check for "Prev" item
	case $item->text === Text::_('JPREV'):
		$item->text = Text::_('JPREVIOUS');
		$icon       = $app->getLanguage()->isRtl() ? 'chevron-right' : 'chevron-left';
		$aria       = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		break;

	// Check for "Next" item
	case Text::_('JNEXT'):
		$icon = $app->getLanguage()->isRtl() ? 'chevron-left' : 'chevron-right';
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		break;

	// Check for "End" item
	case Text::_('JLIB_HTML_END'):
		$icon = $app->getLanguage()->isRtl() ? 'arrow-left' : 'arrow-right';
		$aria = Text::sprintf('JLIB_HTML_GOTO_POSITION', strtolower($item->text));
		break;

	default:
		$icon = null;
		$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', strtolower($item->text));
		break;
}

if($icon !== null)
{
	$display = (new FileLayout('tpl.icon'))->render([
		'icon' => $icon,
		'size' => 34
	]);
}

if($displayData[ 'active' ])
{
	if($item->base > 0)
	{
		$limit = 'limitstart.value=' . $item->base;
	}
	else
	{
		$limit = 'limitstart.value=0';
	}

	$class = 'active';

	if($app->isClient('administrator'))
	{
		$link = 'href="#" onclick="document.adminForm.' . $item->prefix . $limit . '; Joomla.submitform();return false;"';
	}
	elseif($app->isClient('site'))
	{
		$link = 'href="' . $item->link . '"';
	}
}
else
{
	$class = (property_exists($item, 'active') && $item->active) ? 'uk-active' : 'uk-disabled';
}

?>
<?php if($displayData[ 'active' ]) : ?>
	<li>
		<a aria-label="<?php echo $aria; ?>" <?php echo $link; ?>>
			<?php echo $display; ?>
		</a>
	</li>
<?php elseif(isset($item->active) && $item->active) : ?>
	<?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', strtolower($item->text)); ?>
	<li class="<?php echo $class; ?>">
		<a aria-current="true" aria-label="<?php echo $aria; ?>" href="#"><?php echo $display; ?></a>
	</li>
<?php endif; ?>
