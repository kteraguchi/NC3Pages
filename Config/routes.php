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
