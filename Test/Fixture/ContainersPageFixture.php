<?php
/**
 * ContainersPageFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for ContainersPageFixture
 */
class ContainersPageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'page_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'container_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_visible' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'id' => '1',
			'page_id' => '1',
			'container_id' => '1',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '2',
			'page_id' => '1',
			'container_id' => '2',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '3',
			'page_id' => '1',
			'container_id' => '3',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '4',
			'page_id' => '1',
			'container_id' => '4',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '5',
			'page_id' => '1',
			'container_id' => '5',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '6',
			'page_id' => '2',
			'container_id' => '1',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		array(
			'id' => '7',
			'page_id' => '2',
			'container_id' => '3',
			'is_visible' => 1,
			'created_user_id' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user_id' => null,
			'modified' => '2014-05-12 05:04:42'
		),
	);

}
