<?php
/**
 * ContainersPage Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('ContainersPage', 'Pages.Model');

/**
 * Summary for ContainersPage Test Case
 */
class ContainersPageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.containers_page',
		'plugin.pages.page',
		'plugin.pages.container'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ContainersPage = ClassRegistry::init('Pages.ContainersPage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ContainersPage);

		parent::tearDown();
	}

}
