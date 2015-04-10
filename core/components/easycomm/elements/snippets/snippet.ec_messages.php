<?php
/** @var array $scriptProperties */
/** @var easyComm $easyComm */
if (!$easyComm = $modx->getService('easyComm', 'easyComm', $modx->getOption('ec_core_path', null, $modx->getOption('core_path') . 'components/easycomm/') . 'model/easycomm/', $scriptProperties)) {
    return 'Could not load easyComm class!';
}

/* @var string $thread */
$thread = $modx->getOption('thread', $scriptProperties, '');
if(empty($thread)) {
    $thread = 'resource-'.$modx->resource->get('id');
}

/* @var MODx $modx */
/* @var ecThread $thread */
$thread = $modx->getObject('ecThread', array('name' => $thread));

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
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");

$class = 'ecMessage';
$threadClass = 'ecThread';
// Query conditions
$select = array(
    $class => $modx->getSelectColumns($class, $class),
    $threadClass => $modx->getSelectColumns($threadClass, 'Thread', 'thread_'),
);
$innerJoin = array($threadClass => array('alias' => 'Thread', 'on' => "`$class`.`thread` = `Thread`.`id`"));
$where = array('`Thread`.`name`' => $thread->get('name'));

if(empty($showUnpublished)) {
    $where[$class.'.published'] = 1;
}

if(empty($showDeleted)) {
    $where[$class.'.deleted'] = 0;
}

if(!empty($subject)) {
    $where[$class.'.subject'] = $subject;
}

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
    'return' => 'data',
    'nestedChunkPrefix' => 'ec_'
);


// Merge all properties and run!
$pdoFetch->addTime('Query parameters ready');
$pdoFetch->setConfig(array_merge($default, $scriptProperties), false);


$messages = $pdoFetch->run();

$output = array();
$idx = 0;
foreach($messages as $row) {
    $row['idx'] = $idx++;
    $row['text_raw'] = $row['text'];
    $row['text'] = nl2br($row['text']);
    $row['reply_text_raw'] = $row['reply_text'];
    $row['reply_text'] = nl2br($row['reply_text']);
    $tpl = $pdoFetch->defineChunk($row);
    if (empty($tpl)) {
        $output[] = '<pre>'.$pdoFetch->getChunk('', $row).'</pre>';
    }
    else {
        $output[] = $pdoFetch->getChunk($tpl, $row, $fastMode);
    }
}
$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
    $log .= '<pre class="pdoResourcesLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

// Return output
if (!empty($toSeparatePlaceholders)) {
    $output['log'] = $log;
    $modx->setPlaceholders($output, $toSeparatePlaceholders);
}
else {
    $output = implode($outputSeparator, $output);
    $output .= $log;
    if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
        $data = array_merge(
            array('output' => $output),
            $thread->toArray(),
            array(
                'rating_wilson_percent' => number_format($thread->get('rating_wilson') / $ratingMax * 100, 3),
                'rating_simple_percent' => number_format($thread->get('rating_simple') / $ratingMax * 100, 3),
            )
        );
        $output = $pdoFetch->getChunk($tplWrapper, $data, $pdoFetch->config['fastMode']);
    }
    if (!empty($toPlaceholder)) {
        $modx->setPlaceholder($toPlaceholder, $output);
    }
    else {
        return $output;
    }
}