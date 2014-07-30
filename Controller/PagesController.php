<?php
/**
 * Pages Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppController', 'Pages.Controller');

class PagesController extends PagesAppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array('Pages.Page');

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		Configure::write('Pages.isSetting', $this->__isSettingMode());

		$paths = func_get_args();
		$path = implode('/', $paths);

		$page = $this->Page->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}

		$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
		$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');

		$this->set('path', $path);
		$this->set('page', $page);
	}

/**
 * Check setting mode
 *
 * @return bool
 */
	private function __isSettingMode() {
		$pos = strpos($this->request->url, Configure::read('Pages.settingModeWord'));

		return ($pos === 0);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Page->create();
			$page = $this->Page->save($this->request->data);
			if ($page) {
				$this->Session->setFlash(__('The page has been saved.'));
				return $this->redirect('/' . Configure::read('Pages.settingModeWord') . '/' . $page['Page']['permalink']);
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
				// It should review error handling
				return $this->redirect('/' . Configure::read('Pages.settingModeWord') . '/' . $page['Page']['permalink']);
			}
		}

		//$parentPages = $this->Page->ParentPage->find('list');
		//$this->set(compact('parentPages'));
	}

}
