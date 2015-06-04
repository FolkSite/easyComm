<?php
$events = array();
$tmp = array(
    'OnBeforeEcMessageSave' => array(),
    'OnEcMessageSave' => array(),

    'OnBeforeEcMessagePublish' => array(),
    'OnEcMessagePublish' => array(),

    'OnBeforeEcMessageUnpublish' => array(),
    'OnEcMessageUnpublish' => array(),

    'OnBeforeEcMessageDelete' => array(),
    'OnEcMessageDelete' => array(),

    'OnBeforeEcMessageUndelete' => array(),
    'OnEcMessageUndelete' => array(),

    'OnBeforeEcMessageRemove' => array(),
    'OnEcMessageRemove' => array(),
);
foreach ($tmp as $k => $v) {
    /* @var modEvent $event */
    $event = $modx->newObject('modEvent');
    $event->fromArray(array_merge(array(
            'name' => $k,
            'service' => 6,
            'groupname' => PKG_NAME,
        ), $v)
        ,'', true, true);
    $events[] = $event;
}
return $events;