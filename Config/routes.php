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

$defaults = array('action' => 'index');
$pluginOptions = array();
$shortOptions = array();
$controllerOptions = array();

if ($plugins = CakePlugin::loaded()) {
	App::uses('PluginShortRoute', 'Routing/Route');
	foreach ($plugins as $key => $value) {
		$plugins[$key] = Inflector::underscore($value);
	}
	$pattern = implode('|', $plugins);
	$pluginOptions = array('plugin' => $pattern);
	$shortOptions = array('routeClass' => 'PluginShortRoute', 'plugin' => $pattern);
}

if ($controllers = App::objects('controller')) {
	foreach ($controllers as $key => $value) {
		$pos = strrpos($value, 'Controller');
		$controllers[$key] = Inflector::underscore(substr($value, 0, $pos));
	}
	$pattern = implode('|', $controllers);
	$controllerOptions = array('controller' => $pattern);
}

Router::connect('/' . Page::SETTING_MODE_WORD . '/:plugin', $defaults, $shortOptions);
Router::connect('/' . Page::SETTING_MODE_WORD . '/:plugin/:controller', $defaults, $pluginOptions);
Router::connect('/' . Page::SETTING_MODE_WORD . '/:plugin/:controller/:action/*', array(), $pluginOptions);

Router::connect('/' . Page::SETTING_MODE_WORD . '/:controller', $defaults, $controllerOptions);
Router::connect('/' . Page::SETTING_MODE_WORD . '/:controller/:action/*', array(), $controllerOptions);

$pageDefaults = array(
	'plugin' => 'pages',
	'controller' => 'pages',
	'action' => 'index');
Router::connect('/' . Page::SETTING_MODE_WORD . '/*', $pageDefaults);

Router::connect('/:plugin', $defaults, $shortOptions);
Router::connect('/:plugin/:controller', $defaults, $pluginOptions);
Router::connect('/:plugin/:controller/:action/*', array(), $pluginOptions);

Router::connect('/:controller', array('action' => 'index'), $controllerOptions);
Router::connect('/:controller/:action/*', array(), $controllerOptions);

Router::connect('/*', $pageDefaults);

unset($defaults, $pluginOptions, $shortOptions, $controllerOptions, $pattern, $pos, $pageDefaults);
