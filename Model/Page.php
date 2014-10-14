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
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppModel', 'Pages.Model');

/**
 * Summary for Page Model
 */
class Page extends PagesAppModel {

/**
 * constant value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * is setting mode true
 *
 * @var boolean
 */
	private static $__isSetting = null;

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
			'conditions' => array('ContainersPage.is_published' => true),
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
 * Check setting mode
 *
 * @return bool
 */
	public static function isSetting() {
		if (isset(self::$__isSetting)) {
			return self::$__isSetting;
		}

		$offset = strlen(Router::url('/'));
		$pos = strpos(Router::url(), self::SETTING_MODE_WORD, $offset);
		$pos = $pos - $offset;
		self::$__isSetting = ($pos === 0);

		return self::$__isSetting;
	}

/**
 * Unset setting mode value. Use for test.
 *
 * @return void
 */
	public static function unsetIsSetting() {
		self::$__isSetting = null;
	}

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
				'Box' => $this->Box->getContainableQueryNotAssociatedPage(),
				'Container' => array(
					'conditions' => array(
						// It must check settingmode
						'ContainersPage.is_published' => true
					)
				),
				'Language' => array(
					'conditions' => array(
						'Language.code' => 'ja'
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
	private function __getTopPageId() {
		$topPageId = null;
		$topPage = $this->findByLft('1', array('id'));
		if (!empty($topPage)) {
			$topPageId = $topPage['Page']['id'];
		}

		return $topPageId;
	}

/**
 * Save page each association model
 *
 * @param array $data request data
 * @throws Exception
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function savePage($data) {
		$this->ContainersPage = ClassRegistry::init('Pages.ContainersPage');
		$this->BoxesPage = ClassRegistry::init('Pages.BoxesPage');

		$this->setDataSource('master');
		$this->Container->setDataSource('master');
		$this->Box->setDataSource('master');
		$this->ContainersPage->setDataSource('master');
		$this->BoxesPage->setDataSource('master');

		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			$exists = $this->exists();
			$page = $this->__savePage($data);
			if (!$page) {
				throw new Exception();
			}

			if (!$exists) {
				if (!$this->__saveContainer()) {
					throw new Exception();
				}
				if (!$this->__saveBox()) {
					throw new Exception();
				}
				if (!$this->__saveContainersPage()) {
					throw new Exception();
				}
				if (!$this->__saveBoxesPage()) {
					throw new Exception();
				}
			}

			$dataSource->commit();
			return $page;

		} catch (Exception $e) {
			$dataSource->rollback();
			return false;
		}
	}

/**
 * Save page
 *
 * @param array $data request data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	private function __savePage($data) {
		$this->set($data);

		$referencePageId = $this->__getReferencePageId();

		$fields = array(
			'room_id',
			'permalink'
		);
		$targetPage = $this->findById($referencePageId, $fields);
		if (empty($targetPage)) {
			return false;
		}

		$this->set('room_id', $targetPage['Page']['room_id']);

		$slug = $this->data['Page']['slug'];
		if (!isset($slug)) {
			$slug = '';
		}
		$this->set('slug', $slug);

		$permalink = '';
		if (strlen($targetPage['Page']['permalink']) !== 0) {
			$permalink = $targetPage['Page']['permalink'] . '/';
		}
		$permalink .= $slug;
		$this->set('permalink', $permalink);

		// It should check parts
		$this->set('is_published', true);

		return $this->save();
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
				'type' => Container::TYPE_MAIN
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
			)
		);

		return $this->Box->save($data);
	}

/**
 * Save containersPage for page
 *
 * @return boolean True on success
 */
	private function __saveContainersPage() {
		$query = array(
			'conditions' => array(
				'ContainersPage.page_id' => $this->__getReferencePageId(),
				'Container.type !=' => Container::TYPE_MAIN
			)
		);
		$containersPages = $this->ContainersPage->find('all', $query);
		$containersPages[] = array(
			'ContainersPage' => array(
				'page_id' => $this->getLastInsertID(),
				'container_id' => $this->Container->getLastInsertID(),
				'is_published' => true
			)
		);

		foreach ($containersPages as $containersPage) {
			$data = array(
				'page_id' => $this->getLastInsertID(),
				'container_id' => $containersPage['ContainersPage']['container_id'],
				'is_published' => $containersPage['ContainersPage']['is_published']
			);

			$this->ContainersPage->create();
			if (!$this->ContainersPage->save($data)) {
				return false;
			}
		}

		return true;
	}

/**
 * Save boxesPage for page
 *
 * @return boolean True on success
 */
	private function __saveBoxesPage() {
		$query = array(
			'conditions' => array(
				'BoxesPage.page_id' => $this->__getReferencePageId(),
				'Box.type !=' => Box::TYPE_WITH_PAGE
			)
		);
		$boxesPages = $this->BoxesPage->find('all', $query);
		$boxesPages[] = array(
			'BoxesPage' => array(
				'page_id' => $this->getLastInsertID(),
				'box_id' => $this->Box->getLastInsertID(),
				'is_published' => true
			)
		);

		foreach ($boxesPages as $boxesPage) {
			$data = array(
				'page_id' => $this->getLastInsertID(),
				'box_id' => $boxesPage['BoxesPage']['box_id'],
				'is_published' => $boxesPage['BoxesPage']['is_published']
			);

			$this->BoxesPage->create();
			if (!$this->BoxesPage->save($data)) {
				return false;
			}
		}

		return true;
	}

/**
 * Get Reference page ID. Return top page ID if it has no parent.
 *
 * @return string
 */
	private function __getReferencePageId() {
		if (!empty($this->data['Page']['parent_id'])) {
			return $this->data['Page']['parent_id'];
		}

		return $this->__getTopPageId();
	}

}
