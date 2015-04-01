<?php

$properties = array();

$tmp = array(
	'tplForm' => array(
		'type' => 'textfield',
		'value' => 'tpl.ecForm',
	),
    'tplSuccess' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.Success',
    ),
    'newMessageEmailSubjectUser' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplNewMessageEmailUser' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.New.Email.User',
    ),
    'newMessageEmailSubjectManager' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplNewMessageEmailManager' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.New.Email.Manager',
    ),
    'publishMessageEmailSubjectUser' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplPublishMessageEmailUser' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.Publish.Email.User',
    ),
    'formId' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'thread' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'allowedFields' => array(
        'type' => 'textfield',
        'value' => 'user_name,user_email,user_contacts,subject,text',
    ),
    'requiredFields' => array(
        'type' => 'textfield',
        'value' => 'user_name,text',
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