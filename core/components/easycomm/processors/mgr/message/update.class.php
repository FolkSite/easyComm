<?php

/**
 * Update an ecMessage
 */
class easyCommMessageUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'ecMessage';
	public $classKey = 'ecMessage';
	public $languageTopics = array('easycomm');
	//public $permission = 'save';

    /** @var ecMessage $object */
    public $object;

    /** @var ecThread $thread */
    private $thread;


	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return bool|string
	 */
	public function beforeSave() {
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}

		return true;
	}


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$id = (int)$this->getProperty('id');

		if (empty($id)) {
			return $this->modx->lexicon('ec_message_err_ns');
		}

        $threadId = $this->getProperty('thread');
        if (!$this->thread = $this->modx->getObject('ecThread', $threadId)) {
            $this->modx->error->addField('thread', $this->modx->lexicon('ec_message_err_thread'));
        }

        $now = date('Y-m-d H:i:s');
        $this->setProperties(array(
            'editedon' => $now,
            'editedby' => $this->modx->user->isAuthenticated($this->modx->context->key) ? $this->modx->user->id : 0,
        ));
        if($this->getProperty('published')) {
            $this->setProperties(array(
                'publishedon' => $now,
                'publishedby' => $this->modx->user->isAuthenticated($this->modx->context->key) ? $this->modx->user->id : 0,
            ));
        }
        else {
            $this->setProperties(array(
                'publishedon' => null,
                'publishedby' => 0,
            ));
        }
		return parent::beforeSet();
	}

    /** {@inheritDoc} */
    public function afterSave() {
        /*
        $this->thread->fromArray(array(
            'comment_last' => $this->object->get('id'),
            'comment_time' => $this->object->get('createdon'),
        ));
        $this->thread->save();
        */

        $this->thread->updateLastMessage();
        return parent::afterSave();
    }
}

return 'easyCommMessageUpdateProcessor';