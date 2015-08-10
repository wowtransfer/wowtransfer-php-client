<?php

return CMap::mergeArray(

	require __DIR__ . '/main.php',

	[
		'theme'=>'backend',

		'import'=>array(
			'application.models.backend.*',
		),

		'components' => array(
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
	]
);