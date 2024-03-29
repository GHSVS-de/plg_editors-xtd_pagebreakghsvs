<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;

class plgButtonPagebreakGhsvs extends CMSPlugin
{
	protected $autoloadLanguage = true;
	protected $app;

	function onDisplay($editorname, $asset, $author)
	{
		if (!$this->app->isClient('administrator')) {
			return false;
		}

		$user = Factory::getUser();

		$extension = $this->app->input->get('option');

		if ($extension === 'com_categories')
		{
			$parts = explode('.', $this->app->input->get('extension', 'com_content'));
			$extension = $parts[0];
		}

		$asset = $asset !== '' ? $asset : $extension;

		if (
			!(
				$user->authorise('core.edit', $asset)
				|| $user->authorise('core.create', $asset)
				|| (count($user->getAuthorisedCategories($asset, 'core.create')) > 0)
				|| ($user->authorise('core.edit.own', $asset) && $author === $user->id)
				|| (count($user->getAuthorisedCategories($extension, 'core.edit')) > 0)
				|| (count($user->getAuthorisedCategories($extension, 'core.edit.own')) > 0 && $author === $user->id)
			)
		){
			return false;
		}

		$tagsOptions = '';
		$warning = '';

		if (!PluginHelper::isEnabled('system', 'bs3ghsvs'))
		{
			$warning = 'PLG_XTD_PAGEBREAKGHSVS_SYSTEM_PLUGIN_HELPER_NOT_FOUND';
		}


		$popupDir = 'media/plg_editors-xtd_pagebreakghsvs/html/';

		$popupTmpl = file_get_contents(JPATH_SITE . '/' . $popupDir .  'insertcode_tmpl.html');

		$replaceWith = array(
			'PLG_XTD_PAGEBREAKGHSVS_HEADLINE' => Text::_('PLG_XTD_PAGEBREAKGHSVS_HEADLINE'),
			'WARNING' => '<p><strong style="color:red">' . Text::_($warning) . '</strong></p>',
			'PLG_XTD_PAGEBREAKGHSVS_FINISH_SLIDES' => Text::_('PLG_XTD_PAGEBREAKGHSVS_FINISH_SLIDES'),
			'PLG_XTD_PAGEBREAKGHSVS_SLIDER_TITLE' => Text::_('PLG_XTD_PAGEBREAKGHSVS_SLIDER_TITLE'),
			'PLG_XTD_PAGEBREAKGHSVS_SLIDER_TITLE2' => Text::_('PLG_XTD_PAGEBREAKGHSVS_SLIDER_TITLE2'),
			'PLG_XTD_PAGEBREAKGHSVS_INSERTTAG' => Text::_('PLG_XTD_PAGEBREAKGHSVS_INSERTTAG'),
			'PLG_XTD_PAGEBREAKGHSVS_MINIFIED_JS' => JDEBUG ? '' : '.min',
			'[VERSION]' => '?' . time(),
		);

		foreach ($replaceWith as $replace => $with)
		{
			$popupTmpl = str_replace($replace, $with, $popupTmpl);
		}

		$lang = Factory::getLanguage();
		$popupFile = $popupDir . 'insertcode_popup.' . $lang->getTag() . '.html';

		file_put_contents(JPATH_SITE . '/' . $popupFile, $popupTmpl);

		HTMLHelper::_('behavior.core');
		Factory::getDocument()->addScriptOptions('xtd-pagebreakghsvs', array('editor' => $editorname));

		$root = '';

		// Editors prepend JUri::base() to $link. Whyever.
		if ($this->app->isClient('administrator'))
		{
			$root = '../';
		}

		$button = new CMSObject;
		$button->set('class', 'btn');
		$button->modal = true;
		$button->link = $root . $popupFile . '?editor=' . urlencode($editorname);
		$button->set('text', Text::_('PLG_XTD_PAGEBREAKGHSVS_BUTTON'));
		// BC break in Joomla 4.2.7. Use unique name.
		// $button->name = 'file-add'; // icon class without 'icon-'
		$button->name = $this->_type . '_' . $this->_name;
		$button->options = "{handler: 'iframe', size: {x: 800, y: 550}}";
		return $button;
	}
}
