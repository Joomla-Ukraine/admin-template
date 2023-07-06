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

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   array  $options     Optional parameters
 * @var   string $id          The id of the input this label is for
 * @var   string $name        The name of the input this label is for
 * @var   string $label       The html code for the label
 * @var   string $input       The input field html code
 * @var   string $description An optional description to use as in–line help text
 * @var   string $descClass   The class name to use for the description
 */

if(!empty($options[ 'showonEnabled' ]))
{
	/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
	$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
	$wa->useScript('showon');
}

$class           = empty($options[ 'class' ]) ? '' : ' ' . $options[ 'class' ];
$rel             = empty($options[ 'rel' ]) ? '' : ' ' . $options[ 'rel' ];
$id              = ($id ?? $name) . '-desc';
$hideLabel       = !empty($options[ 'hiddenLabel' ]);
$hideDescription = empty($options[ 'hiddenDescription' ]) ? false : $options[ 'hiddenDescription' ];
$descClass       = ($options[ 'descClass' ] ?? '') ? : (!empty($options[ 'inlineHelp' ]) ? 'hide-aware-inline-help d-none' : '');

if(!empty($parentclass))
{
	$class .= ' ' . $parentclass;
}

?>
<div class="uk-margin<?php echo $class; ?>"<?php echo $rel; ?>>
	<?php if($hideLabel) : ?>
		<div class="uk-hidden"><?php echo $label; ?></div>
	<?php else : ?>
		<div class="uk-visible"><?php echo $label; ?></div>
	<?php endif; ?>
	<div class="uk-form-controls">
		<?php echo $input; ?>
		<?php if(!$hideDescription && !empty($description)) : ?>
			<div id="<?php echo $id; ?>" class="<?php echo $descClass ?>">
				<small class="uk-text-small">
					<?php echo $description; ?>
				</small>
			</div>
		<?php endif; ?>
	</div>
</div>
