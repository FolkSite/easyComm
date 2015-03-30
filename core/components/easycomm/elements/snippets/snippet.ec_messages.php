<?php
/** @var array $scriptProperties */
/** @var easyComm $easyComm */
if (!$easyComm = $modx->getService('easyComm', 'easyComm', $modx->getOption('ec_core_path', null, $modx->getOption('core_path') . 'components/easycomm/') . 'model/easycomm/', $scriptProperties)) {
    return 'Could not load easyComm class!';
}

$thread = $modx->getOption('thread', $scriptProperties, '');
if(empty($thread)) {
    $thread = 'resource-'.$modx->resource->get('id');
}

/* @var pdoFetch $pdoFetch */
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
if ($pdoClass = $modx->loadClass($fqn, '', false, true)) {
    $pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . 'components/pdotools/model/', false, true)) {
    $pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".');
    return false;
}
$pdoFetch->addTime('pdoTools loaded');
$fastMode = !empty($fastMode);

$class = 'ecMessage';
$threadClass = 'ecThread';
// Query conditions
$select = array(
    $class => $modx->getSelectColumns($class, $class),
    $threadClass => $modx->getSelectColumns($threadClass, 'Thread', 'thread_'),
);
$innerJoin = array($threadClass => array('alias' => 'Thread', 'on' => "`$class`.`thread` = `Thread`.`id`"));
$where = array('`Thread`.`name`' => $thread);
// Add custom parameters
foreach (array('where','select', 'innerJoin') as $v) {
    if (!empty($scriptProperties[$v])) {
        $tmp = $modx->fromJSON($scriptProperties[$v]);
        if (is_array($tmp)) {
            $$v = array_merge($$v, $tmp);
        }
    }
    unset($scriptProperties[$v]);
}
$pdoFetch->addTime('Conditions prepared');

// Default parameters
$default = array(
    'class' => $class,
    //'loadModels' => 'easyComm',
    'disableConditions' => true,
    'where' => $modx->toJSON($where),
    'select' => $modx->toJSON($select),
    'innerJoin' => $modx->toJSON($innerJoin),
    //'groupby' => $class.'.id',
    'return' => 'chunks',
    'nestedChunkPrefix' => 'ec_'
);


// Merge all properties and run!
$pdoFetch->addTime('Query parameters ready');
$pdoFetch->setConfig(array_merge($default, $scriptProperties), false);


$output = $pdoFetch->run();

$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
    $log .= '<pre class="pdoResourcesLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

// Return output
if (!empty($returnIds)) {
    $modx->setPlaceholder('pdoUsers.log', $log);
    return $output;
}
elseif (!empty($toSeparatePlaceholders)) {
    $output['log'] = $log;
    $modx->setPlaceholders($output, $toSeparatePlaceholders);
}
else {
    $output .= $log;
    if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
        $output = $pdoFetch->getChunk($tplWrapper, array('output' => $output), $pdoFetch->config['fastMode']);
    }
    if (!empty($toPlaceholder)) {
        $modx->setPlaceholder($toPlaceholder, $output);
    }
    else {
        return $output;
    }
}