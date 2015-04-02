<?php

$properties = array();

$tmp = array(
    'thread' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'formId' => array(
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
    'antispamField' => array(
        'type' => 'textfield',
        'value' => 'address',
    ),
    'tplForm' => array(
		'type' => 'textfield',
		'value' => 'tpl.ecForm',
	),
    'tplSuccess' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.Success',
    ),
    'newEmailSubjUser' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplNewEmailUser' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.New.Email.User',
    ),
    'newEmailSubjManager' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplNewEmailManager' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.New.Email.Manager',
    ),
    'updateEmailSubjUser' => array(
        'type' => 'textfield',
        'value' => '',
    ),
    'tplUpdateEmailUser' => array(
        'type' => 'textfield',
        'value' => 'tpl.ecForm.Update.Email.User',
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