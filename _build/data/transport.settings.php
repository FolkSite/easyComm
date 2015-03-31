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
