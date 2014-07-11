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

//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'index', 'plugin' => 'pages'));
Router::connect('/' . Configure::read('Pages.settingModeWord') . '/*',
					array('controller' => 'pages', 'action' => 'index', 'plugin' => 'pages'));
