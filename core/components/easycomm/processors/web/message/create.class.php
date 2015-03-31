<?php

/**
 * Create an ecMessage
 */
class easyCommMessageCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'ecMessage';
	public $classKey = 'ecMessage';
	public $languageTopics = array('easycomm');
	//public $permission = 'create';

    /** @var ecMessage $object */
    public $object;

    private $thread;

	/**
	 * @return bool
	 */
	public function beforeSet() {
        $threadId = $this->getProperty('thread');

		if (!$this->thread = $this->modx->getObject('ecThread', $threadId)) {
			$this->modx->error->addField('thread', $this->modx->lexicon('ec_message_err_thread'));
		}
        $requiredFields = $this->getProperty('requiredFields', null);
        if($requiredFields) {
            foreach($requiredFields as $rf) {
                $p = $this->getProperty($rf);
                if(empty($p)) {
                    $this->modx->error->addField($rf, $this->modx->lexicon('ec_message_err_'.$rf));
                }
            }
        }

        $now = date('Y-m-d H:i:s');
        $this->setProperties(array(
            'date' => $now,
            'createdon' => $now,
            'createdby' => $this->modx->user->isAuthenticated($this->modx->context->key) ? $this->modx->user->id : 0,
            'editedon' => null,
            'editedby' => 0
        ));
        if($this->getProperty('published')) {
            $this->setProperties(array(
                'publishedon' => $now,
                'publishedby' => $this->modx->user->isAuthenticated($this->modx->context->key) ? $this->modx->user->id : 0,
            ));
        }
		return parent::beforeSet();
	}

    /** {@inheritDoc} */
    public function afterSave() {
        $this->thread->updateLastMessage();
        return parent::afterSave();
    }

}

return 'easyCommMessageCreateProcessor';