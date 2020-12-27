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

defined('_JEXEC') or die;

function modChrome_html($module, &$params, &$attribs)
{
	if(!empty ($module->content)) :
		?>
		<div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
			<?php if($module->showtitle != 0) : ?>
				<h3><?php echo $module->title; ?></h3>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php
	endif;
}

function modChrome_main($module, &$params, &$attribs)
{
	if(!empty ($module->content)) :
		?>
		<li>
			<div class="uk-card uk-card-default uk-card-small<?php echo $params->get('moduleclass_sfx'); ?>">
				<?php if($module->showtitle != 0) : ?>
					<div class="uk-card-header">
						<h3 class="uk-card-title"><?php echo $module->title; ?></h3>
					</div>
				<?php endif; ?>
				<div class="uk-card-body">
					<?php echo $module->content; ?>
				</div>
			</div>
		</li>
	<?php
	endif;
}