<?php
/**
 * Page Model
 *
 * @property Room $Room
 * @property Page $ParentPage
 * @property Box $Box
 * @property Page $ChildPage
 * @property Box $Box
 * @property Container $Container
 * @property Language $Language
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppModel', 'Pages.Model');

/**
 * Summary for Page Model
 */
class Page extends PagesAppModel {

/**
 * Default behaviors
 *
 * @var array
 */
	public $actsAs = array('Tree');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentPage' => array(
			'className' => 'Page',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Box' => array(
			'className' => 'Boxes.Box',
			'foreignKey' => 'page_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ChildPage' => array(
			'className' => 'Page',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContainersPage' => array(
			'className' => 'Pages.ContainersPage',
			'foreignKey' => 'page_id',
<<<<<<< HEAD
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BoxesPage' => array(
			'className' => 'Pages.BoxesPage',
			'foreignKey' => 'page_id',
=======
>>>>>>> refs/heads/trialCode
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Box' => array(
			'className' => 'Boxes.Box',
			'joinTable' => 'boxes_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'box_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Container' => array(
			'className' => 'Containers.Container',
			'joinTable' => 'containers_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'container_id',
			'unique' => 'keepExisting',
			'conditions' => array('ContainersPage.is_visible' => true),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Language' => array(
			'className' => 'Language',
			'joinTable' => 'languages_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'language_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

/**
<<<<<<< HEAD
 * Override beforeValidate method
 *
 * @param array $options Options passed from Model::save().
 * @return boolean True if validate operation should continue, false to abort
 */
	public function beforeValidate($options = array()) {
		if (!isset($this->data['Page']['slug'])) {
			return true;
		}

		if (empty($this->data['Page']['parent_id'])) {
			$this->data['Page']['permalink'] = $this->data['Page']['slug'];
			return true;
		}

		$params = array(
			'conditions' => array('id' => $this->data['Page']['parent_id']),
			'recursive' => -1,
			'fields' => array('permalink')
		);
		$parentPage = $this->find('first', $params);
		if (!empty($parentPage)) {
			$this->data['Page']['permalink'] = $parentPage['Page']['permalink']
												. '/' . $this->data['Page']['slug'];
		}

		return true;
	}

/**
 * Override beforeSave method.
 *
 * @param array $options Options passed from Model::save().
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		$dataSource = $this->getDataSource();
		$dataSource->begin();
	}

/**
 * Override beforeSave method.
 *
 * @param boolean $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 */
	public function afterSave($created, $options = array()) {
		if (!$created) {
			return;
		}

		$this->Container->create();
		$data = array(
			'Container' => array(
				'type' => Configure::read('Containers.type.main')
			)
		);
		$this->Container->save($data);

		$pageId = $this->__getPageIdOfDefaultContainersPage();
		if (empty($pageId)) {
			return;
		}

		$params = array(
			'conditions' => array(
				'Page.id' => $pageId,
				'Container.type !=' => Configure::read('Containers.type.main')
			)
		);
		$containersPages = $this->ContainersPage->find('all', $params);
		if (empty($containersPages)) {
			return;
		}

		$this->ContainersPage->create();
		unset($data);
		foreach ($containersPages as $containersPage) {
			$data[] = array(
				'ContainersPage' => array(
					'page_id' => $this->getLastInsertID(),
					'container_id' => $containersPage['ContainersPage']['container_id'],
					'is_visible' => $container['ContainersPage']['is_visible']
				)
			);
		}
		$data[] = array(
			'ContainersPage' => array(
				'page_id' => $this->getLastInsertID(),
				'container_id' => $this->Container->getLastInsertID(),
				'is_visible' => true
			)
		);
		$this->ContainersPage->save($data);


		$this->Box->create();
		$data = array(
			'Box' => array(
				'container_id' => $this->Container->getLastInsertID(),
				'type' => Box::TYPE_WITH_PAGE,
				'space_id' => '1',	// TODO:: Temporary
				'room_id' => $this->data['Page']['room_id'],
				'page_id' => $this->getLastInsertID()
			),
			
		);
		$this->Box->save($data);

=======
 * Override create method.
 *
 * @param boolean|array $data Optional data array to assign to the model after it is created. If null or false,
 *   schema data defaults are not merged.
 * @param boolean $filterKey If true, overwrites any primary key input with an empty value
 */
	public function create($data = array(), $filterKey = false) {
		parent::create($data, $filterKey);

		$pageId = $this->__getPageIdOfDefaultContainersPage();
		if (empty($pageId)) {
			return $this->data;
		}

		$this->hasAndBelongsToMany['Container']['conditions'] = array(
			'Container.type !=' => Configure::read('Containers.type.main')
		);
		$params = array(
			'conditions' => array(
				'Page.id' => $pageId
			)
		);
		$page = $this->find('first', $params);
		$this->hasAndBelongsToMany['Container']['conditions'] = '';
		if (empty($page)) {
			return $this->data;
		}

		/* foreach ($page['Container'] as $container) {
			$this->data['Container'][] = array(
				'id' => $container['ContainersPage']['container_id'],
				'ContainersPage' => array(
					'container_id' => $container['ContainersPage']['container_id'],
					'is_visible' => $container['ContainersPage']['is_visible']
				)
			);
		} */
		/* $this->data['Container'][] = array(
			'id' => false,
			'type' => Configure::read('Containers.type.main'),
			'ContainersPage' => array('container_id' => false,'is_visible' => true)
		); */
		$this->data['Container']= array(
			'type' => Configure::read('Containers.type.main')
		);
		
		unset($this->data['Language']);
		foreach ($this->data as $key => $value) {
			$aa[] = array($key => $value);
		};
		$this->data = array();
		$this->data = $aa;
//var_Dump($this->data);
//exit;
		return $this->data;
	}

/**
 * Override beforeValidate method
 *
 * @param array $options Options passed from Model::save().
 * @return boolean True if validate operation should continue, false to abort
 */
	public function beforeValidate($options = array()) {
		if (!isset($this->data['Page']['slug'])) {
			return true;
		}

		if (empty($this->data['Page']['parent_id'])) {
			$this->data['Page']['permalink'] = $this->data['Page']['slug'];
			return true;
		}

		$params = array(
			'conditions' => array('id' => $this->data['Page']['parent_id']),
			'recursive' => -1,
			'fields' => array('permalink')
		);
		$parentPage = $this->find('first', $params);
		if (!empty($parentPage)) {
			$this->data['Page']['permalink'] = $parentPage['Page']['permalink']
												. '/' . $this->data['Page']['slug'];
		}

		return true;
	}

/**
 * Override beforeSave method
 *
 * @param array $options Options passed from Model::save().
 * @return boolean True if the operation should continue, false if it should abort
 */
	public function beforeSave($options = array()) {
		$pageId = $this->__getPageIdOfDefaultContainersPage();
		if (empty($pageId)) {
			return $this->data;
		}

		$this->Container->hasAndBelongsToMany['Page']['conditions'] = array(
			'Page.id' => $pageId
		);
		$params = array(
			'conditions' => array(
				'Container.type !=' => Configure::read('Containers.type.main')
			)
		);
		$containers = $this->Container->find('all', $params);
		if (empty($containers)) {
			return $this->data;
		}
var_dump($containers);
exit;
		/* foreach ($page['Container'] as $container) {
			$this->data['Container'][] = array(
				'id' => $container['ContainersPage']['container_id'],
				'ContainersPage' => array(
					'container_id' => $container['ContainersPage']['container_id'],
					'is_visible' => $container['ContainersPage']['is_visible']
				)
			);
		} */
		/* $this->data['Container'][] = array(
			'id' => false,
			'type' => Configure::read('Containers.type.main'),
			'ContainersPage' => array('container_id' => false,'is_visible' => true)
		); */
		$this->data['Container']= array(
			'type' => Configure::read('Containers.type.main')
		);
		
		unset($this->data['Language']);
		foreach ($this->data as $key => $value) {
			$aa[] = array($key => $value);
		};
		$this->data = array();
		$this->data = $aa;
//var_Dump($this->data);
//exit;
		return $this->data;

		return true;
>>>>>>> refs/heads/trialCode
	}

/**
 * Get page ID of default containers_pages. Return top page ID if it has no parent.
 *
 * @return string
 */
	private function __getPageIdOfDefaultContainersPage() {
		if (!empty($this->data['Page']['parent_id'])) {
			return $this->data['Page']['parent_id'];
		}

		$topPageId = null;
		$params = array(
			'conditions' => array('Page.lft' => 1),
			'recursive' => -1,
			'fields' => array('id')
		);
		$topPage = $this->find('first', $params);
		if (!empty($topPage)) {
			$topPageId = $topPage['Page']['id'];
		}

		return $topPageId;
	}

}
