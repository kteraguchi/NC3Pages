<?php
/**
 * PagesController Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesController', 'Controller');

/**
 * Summary for PagesController Test Case
 */
class PagesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.SiteSetting',
		'app.SiteSettingValue',
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
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('NetCommons.installed', true);
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/', array('return' => 'view'));
		$this->assertTextContains('<header id="container-header">', $this->view);
		$this->assertEquals(5, count($this->vars['page']['Container']));
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testPermalink() {
		$this->testAction('/test', array('return' => 'vars'));
		$this->assertEquals(2, count($this->vars['page']['Container']));
	}

/**
 * testIndexNotFound method
 *
 * @return void
 */
	public function testIndexNotFound() {
		$this->setExpectedException('NotFoundException');
		$this->testAction('/notFound');
	}

/**
 * testIndexSetting method
 *
 * @return void
 */
	public function testIndexSetting() {
		$url = '/' . Configure::read('Pages.settingModeWord') . '/';
		$assertText = '<div class="modal fade" ' .
			'id="pluginList" ' .
			'tabindex="-1" ' .
			'role="dialog" ' .
			'aria-labelledby="pluginListLabel" ' .
			'aria-hidden="true">';

		$this->testAction($url, array('return' => 'view'));
		$this->assertTextContains($assertText, $this->view);
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$controller = $this->generate('Pages.Pages', array(
			'models' => array(
				'Pages.Page' => array('save')
			)
		));
		$controller->Page->expects($this->once())
			->method('save')
			->will($this->returnValue(true));

		$this->testAction('/pages/pages/add');
	}

}
