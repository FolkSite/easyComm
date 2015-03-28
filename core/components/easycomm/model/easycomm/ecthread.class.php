<?php
class ecThread extends xPDOSimpleObject {

    public function updateLastMessage() {
        $count = 0;
        $last = null;

        $qCount = $this->xpdo->newQuery('ecMessage', array('thread' => $this->get('id'), 'published' => 1, 'deleted' => 0));
        $qCount->select('COUNT(`id`)');

        if ($qCount->prepare() && $qCount->stmt->execute()) {
            $count = $qCount->stmt->fetch(PDO::FETCH_COLUMN);
        }

        $qLast = $this->xpdo->newQuery('ecMessage', array('thread' => $this->get('id'), 'published' => 1, 'deleted' => 0));
        $qLast->sortby('date', 'DESC');
        $qLast->limit(1);
        $last = $this->xpdo->getObject('ecMessage', $qLast);

        if ($last) {
            $this->set('message_last', $last->get('id'));
            $this->set('message_last_date', $last->get('date'));
        }
        else {
            $this->set('message_last', 0);
            $this->set('message_last_date', null);
        }

        $this->set('count', $count);
        $this->save();
    }
}
