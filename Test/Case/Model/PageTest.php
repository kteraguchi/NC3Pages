<?php
/**
 * Page Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Page', 'Pages.Model');

/**
 * Summary for Page Test Case
 */
class PageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.Pages.Room',
		'plugin.Pages.Page',
		'plugin.Pages.Box',
		'plugin.Pages.BoxesPage',
		'plugin.Pages.Container',
		'plugin.Pages.ContainersPage',
		'plugin.Pages.Language',
		'plugin.Pages.LanguagesPage',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Page = ClassRegistry::init('Pages.Page');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Page);

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$data = array(
			'Page' => array(
				'parent_id' => null,
				'slug' => 'test01'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０１'
					)
				)
			)
		);

		$this->Page->create();
		$this->Page->save($data);
		$actualPage = $this->Page->findById($this->Page->getLastInsertID());

		$this->assertEquals('test01', $actualPage['Page']['permalink']);
		$actualContainer = array(
			$actualPage['Container'][0]['ContainersPage']['container_id'],
			$actualPage['Container'][1]['ContainersPage']['container_id'],
			$actualPage['Container'][2]['ContainersPage']['container_id'],
			$actualPage['Container'][3]['ContainersPage']['container_id'],
			$actualPage['Container'][4]['ContainersPage']['container_id'],
		);
		sort($actualContainer);
		$this->assertEquals('1', $actualContainer[0]);
		$this->assertEquals('2', $actualContainer[1]);
		$this->assertEquals('4', $actualContainer[2]);
		$this->assertEquals('5', $actualContainer[3]);
		$this->assertEquals('6', $actualContainer[4]);

		$this->assertEquals('1', $actualPage['Box'][0]['BoxesPage']['box_id']);
	}

/**
 * testPermalinkDuplicate method
 *
 * @return void
 */
	public function testPermalinkDuplicate() {
		$data = array(
			'Page' => array(
				'parent_id' => '1',
				'slug' => 'test'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０２'
					)
				)
			)
		);

		$this->Page->create();
		$this->assertFalse($this->Page->save($data));
	}

/**
 * testGeneratedPermalink method
 *
 * @return void
 */
	public function testGeneratedPermalink() {
		$data = array(
			'Page' => array(
				'parent_id' => '2',
				'slug' => 'test03'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０３'
					)
				)
			)
		);

		$this->Page->create();
		$actualPage = $this->Page->save($data);

		$this->assertEquals('test/test03', $actualPage['Page']['permalink']);
	}
}
