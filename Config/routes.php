<?php
/**
 * Pages routes configuration
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Page', 'Pages.Model');
App::uses('SlugRoute', 'Pages.Lib');

Router::connect('/' . Page::SETTING_MODE_WORD . '/', array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'), array('routeClass' => 'SlugRoute'));
Router::connect('/' . Page::SETTING_MODE_WORD . '/*', array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'), array('routeClass' => 'SlugRoute'));
Router::connect('/*', array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index'), array('routeClass' => 'SlugRoute'));

$params = array(Page::SETTING_MODE_WORD => false);
if (Page::isSetting()) {
	$params = array();
}
$indexParams = $params + array('action' => 'index');
if ($plugins = CakePlugin::loaded()) {
	App::uses('PluginShortRoute', 'Routing/Route');
	foreach ($plugins as $key => $value) {
		$plugins[$key] = Inflector::underscore($value);
	}
	$pluginPattern = implode('|', $plugins);
	$match = array('plugin' => $pluginPattern);
	$shortParams = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);

	Router::connect('/' . Page::SETTING_MODE_WORD  . '/:plugin', $indexParams, $shortParams);
	Router::connect('/' . Page::SETTING_MODE_WORD  . '/:plugin/:controller', $indexParams, $match);
	Router::connect('/' . Page::SETTING_MODE_WORD  . '/:plugin/:controller/:action/*', $params, $match);
}

Router::connect('/' . Page::SETTING_MODE_WORD  . '/:controller', $indexParams);
Router::connect('/' . Page::SETTING_MODE_WORD  . '/:controller/:action/*',  $params);
