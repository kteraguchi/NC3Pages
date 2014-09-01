<?php
/**
 * Pages routes configuration
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

//require APP . 'Plugin' . DS . 'ThemeSettings' . DS . 'Config' . DS . 'routes.php';

Router::connect('/' . Configure::read('Pages.settingModeWord') . '/*',
	array(
		'plugin' => 'pages',
		'controller' => 'pages',
		'action' => 'index'));

Router::connect('/:plugin/:controller/:action/*',
	array());
Router::connect('/:plugin/:action/*',
	array());

Router::connect('/*',
	array(
		'plugin' => 'pages',
		'controller' => 'pages',
		'action' => 'index'));
