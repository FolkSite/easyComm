<?php

$properties = array();

$tmp = array(
    'thread' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.ecThreadRating',
	),
    'toPlaceholder' => array(
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