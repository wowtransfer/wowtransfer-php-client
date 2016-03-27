<?php

return CMap::mergeArray(
	require __DIR__ . '/main.php',
	[
		'components' => [
			'fixture' => [
				'class'=>'system.test.CDbFixtureManager',
			],
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		],
	]
);
