<?php

/**
 * Remove an ecThread
 */
class easyCommecThreadRemoveProcessor extends modObjectProcessor {
	public $objectType = 'ecThread';
	public $classKey = 'ecThread';
	public $languageTopics = array('easycomm');
	//public $permission = 'remove';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('ec_thread_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var ecThread $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('ec_thread_err_nf'));
			}

			$object->remove();
		}

		return $this->success();
	}
}

return 'easyCommecThreadRemoveProcessor';