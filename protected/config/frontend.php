<?php
return CMap::mergeArray(

require_once(dirname(__FILE__).'/main.php'),

array(
	'defaultController' => 'site',

	'components' => array(
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'error, trace',
					//'categories'=>'system.db.*',
				),//*/
			),
		),
	),
));