<?php
$settings = array();

$tmp = array(
	'show_templates' => array(
		'xtype' => 'textfield',
		'value' => '*',
		'area' => 'ec_main',
	),
    'show_resources' => array(
        'xtype' => 'textfield',
        'value' => '*',
        'area' => 'ec_main',
    ),
    'frontend_css' => array(
        'xtype' => 'textfield',
        'value' => '[[+cssUrl]]web/ec.default.css',
        'area' => 'ec_main',
    ),
    'frontend_js' => array(
        'xtype' => 'textfield',
        'value' => '[[+jsUrl]]web/ec.default.js',
        'area' => 'ec_main',
    ),
    'thread_grid_fields' => array(
        'xtype' => 'textfield',
        'value' => 'id,resource,name,title,count,rating_simple,rating_wilson',
        'area' => 'ec_main',
    ),
    'thread_window_fields' => array(
        'xtype' => 'textfield',
        'value' => 'resource,name,title,rating_simple,rating_wilson',
        'area' => 'ec_main',
    ),
    'message_grid_fields' => array(
        'xtype' => 'textfield',
        'value' => 'id,thread_name,subject,date,user_name,user_email,user_contacts,rating,text,reply_author,reply_text,ip',
        'area' => 'ec_main',
    ),
    'message_window_layout' => array(
        'xtype' => 'textfield',
        'value' => '{"main": {"name": "main","columns": {"column0":["user_name","user_email"],"column1":["date","user_contacts"]},"fields": ["subject","rating","text","published"]},"reply":{"name": "reply", "columns": {}, "fields": ["reply_author","reply_text","notify","notify_date"]},"settings":{"name": "settings", "columns": {}, "fields": [ "thread","ip","extended"]}}',
        'area' => 'ec_main',
    ),

    'auto_reply_author' => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => 'ec_main',
    ),

    'mail_notify_user' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'ec_mail',
    ),
    'mail_notify_manager' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'ec_mail',
    ),
    'mail_new_subject_manager' => array(
        'xtype' => 'textfield',
        'value' => 'Новое сообщение на сайте [[++site_url]]',
        'area' => 'ec_mail',
    ),
    'mail_new_subject_user' => array(
        'xtype' => 'textfield',
        'value' => 'Вы оставили сообщение на сайте [[++site_url]]',
        'area' => 'ec_mail',
    ),
    'mail_update_subject_user' => array(
        'xtype' => 'textfield',
        'value' => 'Уведомление о вашем сообщении на сайте [[++site_url]]',
        'area' => 'ec_mail',
    ),
    'mail_manager' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ec_mail',
    ),
    'mail_from' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ec_mail',
    ),
    'mail_from_name' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'ec_mail',
    ),


    'rating_max' => array(
        'xtype' => 'numberfield',
        'value' => '5',
        'area' => 'ec_rating',
    ),
    'rating_wilson_confidence' => array(
        'xtype' => 'numberfield',
        'value' => '1.6',
        'area' => 'ec_rating',
    ),


);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'ec_' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
