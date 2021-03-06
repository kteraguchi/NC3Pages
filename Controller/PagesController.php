<?php
/**
 * Pages Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
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
	public $uses = array(
		'Pages.Page',
		'Rooms.PluginsRoom'
	);

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		Configure::write('Pages.isSetting', Page::isSetting());

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

		//プラグイン追加用のデータ取得
		if (Page::isSetting()) {
			$roomId = 1;
			$langId = 2;
			$plugins = $this->PluginsRoom->getPlugins($roomId, $langId);
			$this->set('plugins', $plugins);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Page->create();
			$page = $this->Page->savePage($this->request->data);
			if ($page) {
				$this->Session->setFlash(__('The page has been saved.'));
				return $this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
				// It should review error handling
				return $this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			}
		}
	}

}
