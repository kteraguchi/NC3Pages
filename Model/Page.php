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
	public $actsAs = array(
		'Tree',
		'Containable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'permalink' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Permalink is already in use.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'from' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Please enter a valid date and time.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'to' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Please enter a valid date and time.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
 * Get page with frame
 *
 * @param string $permalink Permalink
 * @return array
 */
	public function getPageWithFrame($permalink) {
		$query = array(
			'conditions' => array(
				'Page.permalink' => $permalink
			),
			'contain' => array(
				'Box' => $this->Box->getContainableQuery(false),
				'Container' => array(
					'conditions' => array(
						// It must check settingmode
						'ContainersPage.is_visible' => true
					)
				),
				'Language' => array(
					'conditions' => array(
						'Language.code' => 'jpn'
					)
				)
			)
		);	

		return $this->find('first', $query);
	}

/**
 * Get page ID of top.
 *
 * @return string
 */
	private function __topPageId() {
		$topPageId = null;
		$topPage = $this->findByLft('1', array('id'));
		if (!empty($topPage)) {
			$topPageId = $topPage['Page']['id'];
		}

		return $topPageId;
	}

/**
 * Override beforeValidate method
 *
 * @param array $options Options passed from Model::save().
 * @return boolean True if validate operation should continue, false to abort
 */
	public function beforeValidate($options = array()) {
		$this->__setTakingOverData();

		return true;
	}

/**
 * Set taking over data before validate.
 *
 * @return void
 */
	private function __setTakingOverData() {
		$targetPageId = $this->data['Page']['parent_id'];
		if (empty($targetPageId)) {
			$targetPageId = $this->__topPageId();
		}

		$fields = array(
			'room_id',
			'permalink'
		);
		$targetPage = $this->findById($targetPageId, $fields);
		if (empty($targetPage)) {
			return;
		}

		$this->data['Page']['room_id'] = $targetPage['Page']['room_id'];

		if (!isset($this->data['Page']['slug'])) {
			$this->data['Page']['slug'] = '';
		}

		$this->data['Page']['permalink'] = '';
		if (strlen($targetPage['Page']['permalink']) !== 0) {
			$this->data['Page']['permalink'] = $targetPage['Page']['permalink'] . '/';
		}
		$this->data['Page']['permalink'] .= $this->data['Page']['slug'];
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

		$this->__setDefaultContainers();

		// It should check parts
		$this->data['Page']['is_published'] = true;

		return true;
	}

/**
 * Set default containers for page to $this->data
 *
 * @return void
 */
	private function __setDefaultContainers() {
		$pageId = $this->__getPageIdOfDefaultContainersPage();
		if (empty($pageId)) {
			return;
		}

		$this->hasAndBelongsToMany['Container']['conditions'] = array(
			'Container.type !=' => Configure::read('Containers.type.main')
		);
		$this->hasAndBelongsToMany['Box']['conditions'] = array(
			'Box.type !=' => Box::TYPE_WITH_PAGE
		);
		$params = array(
			'conditions' => array(
				'Page.id' => $pageId
			)
		);
		$pages = $this->find('first', $params);
		$this->hasAndBelongsToMany['Container']['conditions'] = '';
		$this->hasAndBelongsToMany['Box']['conditions'] = '';
		if (empty($pages['Container'])) {
			return;
		}

		foreach ($pages['Container'] as $container) {
			$this->data['Container'][] = array(
				'id' => $container['ContainersPage']['container_id'],
				'ContainersPage' => array(
					'container_id' => $container['ContainersPage']['container_id'],
					'is_visible' => $container['ContainersPage']['is_visible']
				)
			);
		}

		foreach ($pages['Box'] as $box) {
			$this->data['Box'][] = array(
				'id' => $box['BoxesPage']['box_id'],
				'BoxesPage' => array(
					'box_id' => $box['BoxesPage']['box_id'],
					'is_visible' => $box['BoxesPage']['is_visible']
				)
			);
		}
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

		return $this->__topPageId();
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

		if (!$this->__saveContainer()) {
			return;
		}

		if (!$this->__saveBox()) {
			return;
		}

		$dataSource = $this->getDataSource();
		$dataSource->commit();
	}

/**
 * Save container data.
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	private function __saveContainer() {
		$this->Container->create();
		$data = array(
			'Container' => array(
				'type' => Configure::read('Containers.type.main')
			),
			'Page' => array(
				array(
					'id' => $this->getLastInsertID(),
					'ContainersPage' => array(
						'page_id' => $this->getLastInsertID(),
						'is_visible' => true
					)
				)
			)
		);

		return $this->Container->save($data);
	}

/**
 * Save box data.
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	private function __saveBox() {
		$this->Box->create();
		$data = array(
			'Box' => array(
				'container_id' => $this->Container->getLastInsertID(),
				'type' => Box::TYPE_WITH_PAGE,
				'space_id' => '1',	// It should modify value
				'room_id' => $this->data['Page']['room_id'],
				'page_id' => $this->getLastInsertID()
			),
			'Page' => array(
				array(
					'id' => $this->getLastInsertID(),
					'BoxesPage' => array(
						'page_id' => $this->getLastInsertID(),
						'is_visible' => true
					)
				)
			)
		);

		return $this->Box->save($data);
	}

}
