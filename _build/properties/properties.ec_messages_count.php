<?php

$properties = array();

$tmp = array(
    'thread' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'threads' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'subject' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'showUnpublished' => array(
        'type' => 'combo-boolean',
        'value' => false,
    ),
    'showDeleted' => array(
        'type' => 'combo-boolean',
        'value' => false,
    ),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;