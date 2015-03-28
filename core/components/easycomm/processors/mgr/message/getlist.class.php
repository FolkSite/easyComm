<?php

/**
 * Get a list of ecMessage
 */
class easyCommMessageGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'ecMessage';
	public $classKey = 'ecMessage';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	//public $permission = 'list';


	/**
	 * * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return boolean|string
	 */
	public function beforeQuery() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('ecThread','Thread','`ecMessage`.`thread` = `Thread`.`id`');
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, ''));
        $c->select('`Thread`.`name` as `thread_name`');

        $resource_id = intval($this->getProperty('resource_id'));
        if(!empty($resource_id)) {
            $c->where(array('`Thread`.`resource`' => $resource_id));
        }

		$query = trim($this->getProperty('query'));
		if ($query) {
			$c->where(array(
				'user_name:LIKE' => "%{$query}%",
				'OR:user_email:LIKE' => "%{$query}%",
                'OR:user_contacts:LIKE' => "%{$query}%",
                'OR:text:LIKE' => "%{$query}%",
                'OR:reply_author:LIKE' => "%{$query}%",
                'OR:reply_text:LIKE' => "%{$query}%",
			));
		}

		return $c;
	}

	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
        $array['thread_name'] = $array['thread_name'].' ('.$array['thread'].')';
		return $array;
	}

}

return 'easyCommMessageGetListProcessor';