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
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		Configure::write('Pages.isSetting', $this->__isSettingMode());

		$paths = func_get_args();
		$path = implode('/', $paths);

		$this->Page->hasAndBelongsToMany['Language']['conditions'] = array('Language.code' => 'jpn');
		$page = $this->Page->findByPermalink($path);
		if (empty($page)) {
			throw new NotFoundException();
		}

		$containers = $this->__getContainersEachType($page['Container']);

		$this->set('path', $path);
		$this->set('page', $page);
		$this->set('containers', $containers);
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
 * Get containers each type
 *
 * @param array $containers Container record array
 * @return array
 */
	private function __getContainersEachType($containers) {
		$containersEachType = array();
		foreach ($containers as $container) {
			$type = $container['type'];
			$containersEachType[$type] = $container;
		}

		return $containersEachType;
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->__createContainersPage($this->request->data['Page']['parent_id']);

			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('The page has been saved.'));

				return $this->redirect(Configure::read('Pages.settingModeWord') . '/' . $this->Page->data['permalink']);
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
			}
		}
		//$parentPages = $this->Page->ParentPage->find('list');
		//$this->set(compact('parentPages'));
	}

/**
 * Create containers model belong parent page
 *
 * @param string $parentId Parent ID
 * @return array
 */
	private function __createContainersPage($parentId) {
		$pageId = null;
		if (!empty($parentId)) {
			$pageId = $parentId;
		}

		if (empty($pageId)) {
			$pageId = $this->__getTopPageId();
		}

		$params = array(
			'conditions' => array('page_id' => $pageId),
			'recursive' => -1,
			'fields' => array(
				'container_id',
				'is_visible'
			)
		);
		$containersPages = $this->Page->ContainersPage->find('all', $params);

		foreach ($containersPages as $containersPage) {
			$this->request->data['Container'][] = array(
				'id' => $containersPage['ContainersPage']['container_id'],
				'ContainersPage' => $containersPage['ContainersPage']
			);
		}

		return $this->request->data;
	}


/**
 * Get top page ID
 *
 * @return string
 */
	private function __getTopPageId() {
		$params = array(
			'conditions' => array('lft' => 1),
			'recursive' => -1,
			'fields' => array('id')
		);
		$page = $this->Page->find('first', $params);

		if (empty($page)) {
			$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
		}

		return $page['Page']['id'];
	}
}
