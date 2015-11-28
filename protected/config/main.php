<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', realpath(__DIR__ . '/../extensions/yiistrap'));
Yii::setPathOfAlias('common-views', realpath(__DIR__ . '/../views/common'));
Yii::setPathOfAlias('vendor.twbs.bootstrap.dist', realpath(__DIR__ . '/../vendor/twbs/bootstrap/dist'));

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
	'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
	'defaultController' => 'site',
	'name' => 'Перенос персонажей WoW',
	'timeZone' => 'Europe/Moscow',

	'behaviors' => [
		'runEnd' => [
			'class'=>'application.behaviors.WebApplicationEndBehavior',
		],
	],

	// preloading 'log' component
	'preload' => ['log'],

	'sourceLanguage' => 'en',
	'language' => 'ru', // to app.php

	// autoloading model and component classes
	'import' => [
		'application.models.*',
		'application.components.*',
		'bootstrap.components.TbApi',
		'bootstrap.behaviors.TbWidget',
		'bootstrap.form.*',
		'bootstrap.helpers.*',
		//'bootstrap.widgets.*',
	],

	'modules' => [
		// uncomment the following to enable the Gii tool

		'gii' => [
			'class' => 'system.gii.GiiModule',
			'password' => '123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => ['127.0.0.1','::1'],
			'generatorPaths' => ['bootstrap.gii'],
			'import' => [
				'bootstrap.gii.bootstrap.BootstrapCode',
			],
		],
	],

	// application components
	'components' => [
		'user' => [
			'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => false,
		],

		'bootstrap' => [
			'class' => '\TbApi',
		],

		// uncomment the following to enable URLs in path-format
		'urlManager' => [
			'urlFormat' => 'path',
			'rules' => [
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			],
			'showScriptName' => true,
		],

		'authManager' => [
			'class'=>'PhpAuthManager',
			'defaultRoles' => ['guest'],
		],

		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		// to app.php
		'db' => require __DIR__ . '/db.php',

		'errorHandler' => [
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		],

		'log' => [
			'class' => 'CLogRouter',
			'routes' => [
				[
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				],
				// uncomment the following to show log messages on web pages

				/*array(
					'class'=>'CWebLogRoute',
				),//*/
			],
		],
	],

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => require __DIR__ . '/params.php',
];
