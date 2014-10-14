<?php
/**
 * FramesLanguageFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for FramesLanguageFixture
 */
class FramesLanguageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'frame_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_id' => 1,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 1,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 2,
			'frame_id' => 1,
			'language_id' => 2,
			'name' => 'Test frame name 1',
			'created_user' => 2,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 2,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 3,
			'frame_id' => 2,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 3,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 3,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 4,
			'frame_id' => 2,
			'language_id' => 2,
			'name' => 'Test frame name 2',
			'created_user' => 4,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 4,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 5,
			'frame_id' => 3,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 5,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 5,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 6,
			'frame_id' => 3,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 6,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 6,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 7,
			'frame_id' => 4,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 7,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 7,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 8,
			'frame_id' => 4,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 8,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 8,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 9,
			'frame_id' => 5,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 9,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 9,
			'modified' => '2014-07-29 03:53:10'
		),
		array(
			'id' => 10,
			'frame_id' => 5,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 10,
			'created' => '2014-07-29 03:53:10',
			'modified_user' => 10,
			'modified' => '2014-07-29 03:53:10'
		),
	);

}
