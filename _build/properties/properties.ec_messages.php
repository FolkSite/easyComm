<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.ecMessages.Row',
	),
    'tplWrapper' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'thread' => array(
        'type' => 'textfield',
        'value' => '',
    ),
	'sortby' => array(
		'type' => 'textfield',
		'value' => 'date',
	),
	'sortdir' => array(
		'type' => 'list',
		'options' => array(
			array('text' => 'ASC', 'value' => 'ASC'),
			array('text' => 'DESC', 'value' => 'DESC'),
		),
		'value' => 'DESC'
	),
	'limit' => array(
		'type' => 'numberfield',
		'value' => 10,
	),
	'outputSeparator' => array(
		'type' => 'textfield',
		'value' => "\n",
	),
	'toPlaceholder' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
    'toSeparatePlaceholders' => array(
        'type' => 'combo-boolean',
        'value' => false,
    ),
    'showLog' => array(
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