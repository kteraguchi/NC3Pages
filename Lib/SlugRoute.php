<?php
/**
 * SlugRoute
 *
 * Automatically slugs routes based on named parameters
 *
 */
class SlugRoute  extends CakeRoute {

/**
 * parse
 *
 * @param string $url The URL to attempt to parse.
 * @return mixed Boolean false on failure, otherwise an array or parameters
 */
	function parse($url) {
		$params = parent::parse($url);

		if (empty($params)) {
			return false;
		}

		$path = implode('/', $params['pass']);
		$Page = new Page();
		$count = $Page->find('count', array(
			'conditions' => array('Page.permalink' => $path),
			'recursive' => -1
		));

		if ($count) {
			return $params;
		}

		return false;
	}

}

?>