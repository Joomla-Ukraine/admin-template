<?php
/**
 * JU 2col
 *
 * @package          Joomla.Site
 * @subpackage       JU 2col
 *
 * @author           Denys Nosov, denys@joomla-ua.org
 * @copyright        2019-2021 (C) Joomla! Ukraine, http://joomla-ua.org. All rights reserved.
 * @license          GNU General Public License version 2 or later; see _LICENSE.php
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

// The markup around each field (label+value/form) can be Overridden.
// Remove the underscore [_] from the Filename. (filename = markup.php)
// Edit the function name:
//	- fields/markup.php 			=>	cckMarkup_[template]
//	- fields/[contenttype]/markup.php	=>	cckMarkup_[template]_[contenttype]
//	- fields/[searchtype]/markup.php	=>	cckMarkup_[template]_[searchtype]
// Write your Custom Markup code. (see default markup below)

/**
 * @param $cck
 * @param $html
 * @param $field
 * @param $options
 *
 * @return mixed|string
 *
 * @throws \Exception
 * @since 1.5
 */
function cckMarkup_ju_tab($cck, $html, $field, $options)
{
	return cckMarkup_seb_minima($cck, $html, $field, $options);
}

/**
 * @param $cck
 * @param $html
 * @param $field
 * @param $options
 *
 * @return mixed|string
 *
 * @throws \Exception
 * @since 1.5
 */
function cckMarkup_ju_minima($cck, $html, $field, $options)
{
	return cckMarkup_seb_minima($cck, $html, $field, $options);
}

/**
 * @param $cck
 * @param $html
 * @param $field
 * @param $options
 *
 * @return mixed|string
 *
 * @throws \Exception
 * @since 1.5
 */
function cckMarkup_ju_2col($cck, $html, $field, $options)
{
	return cckMarkup_seb_minima($cck, $html, $field, $options);
}

/**
 * @param $cck
 * @param $html
 * @param $field
 * @param $options
 *
 * @return mixed|string
 *
 * @throws \Exception
 * @since 1.5
 */
function cckMarkup_seb_one($cck, $html, $field, $options)
{
	return cckMarkup_seb_minima($cck, $html, $field, $options);
}

/**
 * @param $cck
 * @param $html
 * @param $field
 * @param $options
 *
 * @return mixed|string
 *
 * @throws \Exception
 * @since 1.5
 */
function cckMarkup_seb_minima($cck, $html, $field, $options)
{
	if($cck->mode !== 'form')
	{
		return $html;
	}

	// Computation
	if(isset($field->computation) && $field->computation)
	{
		$cck->setComputationRules($field);
	}

	// Conditional
	if(isset($field->conditional) && $field->conditional)
	{
		$cck->setConditionalStates($field);
	}

	$app = Factory::getApplication();

	if($app->isClient('administrator'))
	{
		include_once JPATH_ROOT . '/libraries/cck/rendering/fields/markup.php';

		$html = cckMarkup($cck, $html, $field, $options);
	}
	else
	{
		$desc = '';
		if($cck->getStyleParam('field_description', 0) && $field->description != '')
		{
			$desc = '<div class="uk-article-meta">' . strip_tags($field->description, '<br><a>') . '</div>';
		}

		$label = '';
		if($options->get('field_label', $cck->getStyleParam('field_label', 1)))
		{
			$label = $cck->getLabel($field->name, true, ($field->required ? '<span class="uk-text-danger">*</span>' : ''));
			$label = ($label != '') ? '<label class="uk-form-label">' . $label . '</label>' : '';
		}

		$html = '<div id="' . $cck->id . '_' . $cck->mode_property . '_' . $field->name . '">' . $html . '</div>';
		//  class="' . $field->markup_class . '"

		//echo $field->type .'<br>';

		switch($field->type)
		{
			case 'upload_image':
				$html = str_replace([
					'inputbox text',
					'cck_label'
				], [
					'uk-input uk-width-4-5@m',
					'uk-margin-top uk-form-label'
				], $html);
				$html = '<div class="uk-background-muted uk-padding-small">' . $html . '</div>';
				break;

			case 'upload_file':
				$_html = $field->form;

				$_html = str_replace([
					'inputbox text',
					'cck_label'
				], [
					'uk-file uk-width-4-5@m',
					'uk-margin-top'
				], $_html);

				$html = '<div class="uk-background-muted uk-padding-small">' . $_html . '</div>';
				break;

			case 'link':
				$_html = $field->form;

				$_html = str_replace([
					'inputbox text',
					'cck_label'
				], [
					'uk-input',
					'uk-margin-top'
				], $_html);

				$html = '<div class="uk-background-muted uk-padding-small"><div class="uk-grid" data-uk-grid>' . $_html . '</div></div>';
				break;

			case 'textarea':
				$html = str_replace('inputbox ', 'uk-textarea ', $field->form);
				break;

			case 'select_simple':
			case 'select_dynamic':
			case 'juselect_dynamic':
			case 'select_dynamic_cascade':
				$html = str_replace('inputbox ', 'uk-select ', $field->form);
				break;

			case 'checkbox_dynamic':
				preg_match_all('#<fieldset.*?class="checkboxes(.*?)">(.*?)</fieldset>#is', $field->form, $out);

				$vertical = '';
				if(count($out[ 1 ]) && trim($out[ 1 ][ 0 ]) === 'vertical')
				{
					$vertical = '<br>';
				}

				$html = preg_replace('#<fieldset.*?class="checkboxes(.*?)">(.*?)</fieldset>#is', '\\2', $field->form);

				$html = preg_replace('#<input type="checkbox"(.*?)class="inputbox checkbox(.*?)".*?/><label(.*?)>(.*?)</label>#is', '<label\\3 class="uk-margin-right"><input class="uk-checkbox\\2" type="checkbox" \\1> \\4</label>' . $vertical, $html);
				break;

			case 'radio':
				preg_match_all('#<fieldset.*?class="radios(.*?)">(.*?)</fieldset>#is', $field->form, $out);

				$vertical = '';
				if(count($out[ 1 ]) && trim($out[ 1 ][ 0 ]) === 'vertical')
				{
					$vertical = '<br>';
				}

				$html = preg_replace('#<fieldset.*?class="radios(.*?)">(.*?)</fieldset>#is', '\\2', $field->form);

				$html = preg_replace('#<input type="radio"(.*?)class="radio(.*?)".*?/><label(.*?)>(.*?)</label>#is', '<label\\3 class="uk-margin-right"><input class="uk-radio\\2" type="radio" \\1> \\4</label>' . $vertical, $html);
				break;

			case 'group_x':

				$pos = strpos($html, '<table');
				if($pos === false)
				{
					$html = str_replace([
						'cck_form cck_form_group_x',
						'cck_forms'
					], [
						'uk-card tm-card-flat-border uk-margin uk-padding-small',
						'uk-margin'
					], $html);
				}
				else
				{
					$html = str_replace([
						'<table border="0" cellpadding="0" cellspacing="0" class="table">',
						'class="cck_cgx cck_cgx_button'
					], [
						'<table class="uk-table uk-table-small uk-table-divider uk-table-striped uk-margin-remove-bottom">',
						'class="uk-width-small uk-text-nowrap uk-text-right cck_cgx cck_cgx_button'
					], $html);
				}

				// Select
				$html = str_replace('<select', '<select class="uk-select"', $html);

				break;

			case 'field_x':
				$html = str_replace('inputbox text', 'uk-input', $html);

				if($field->css)
				{
					$html = str_replace('adminformlist', 'adminformlist ' . $field->css, $html);
				}

				if($field->attributes)
				{
					$html = str_replace('id="sortable_', $field->attributes . ' id="sortable_', $html);
				}

				break;

			default:
				$html = str_replace('inputbox ', 'uk-input ', $html);
				break;
		}

		$html = '<div id="' . $cck->id . '_' . $field->name . '" class="uk-margin' . ($field->markup_class != '' ? ' ' . $field->markup_class : '') . '">' . $label . '<div class="uk-form-controls">' . $html . $desc . '</div></div>';

	}

	return $html;
}