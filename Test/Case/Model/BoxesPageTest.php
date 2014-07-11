<?php
/**
 * BoxesPage Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BoxesPage', 'Pages.Model');

/**
 * Summary for BoxesPage Test Case
 */
class BoxesPageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.boxes_page',
		'plugin.pages.page',
		'plugin.pages.box'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BoxesPage = ClassRegistry::init('Pages.BoxesPage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BoxesPage);

		parent::tearDown();
	}

}
