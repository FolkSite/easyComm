<?php

/**
 * Mark ecMessage as deleted
 */
class easyCommMessageDeleteProcessor extends modObjectProcessor {
	public $objectType = 'ecMessage';
	public $classKey = 'ecMessage';
	public $languageTopics = array('easycomm');
	//public $permission = 'delete';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('ec_message_err_ns'));
		}

        $threadIds = array();
		foreach ($ids as $id) {
			/** @var ecMessage $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('ec_message_err_nf'));
			}
            $threadId = $object->get('thread');
            if(!array_key_exists($threadId, $threadIds)) {
                $threadIds[] = $threadId;
            }

            $object->set('deleted', 1);
            $object->set('deletedon', date('Y-m-d H:i:s'));
            $object->set('deletedby', $this->modx->user->isAuthenticated($this->modx->context->key) ? $this->modx->user->id : 0);

			$object->save();
		}

        $threads = $this->modx->getCollection('ecThread', array('id:IN' => $threadIds));
        /** @var ecThread $thread */
        foreach($threads as $thread){
            $thread->updateLastMessage();
        }

		return $this->success();
	}

}

return 'easyCommMessageDeleteProcessor';