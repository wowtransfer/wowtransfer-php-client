<?
return array_merge(
	[
		'connectionString'=>'mysql:host=127.0.0.1;dbname=characters',
		'emulatePrepare'=>true,
		'username'=>'',
		'password'=>'',
		'charset'=>'utf8',
		'enableParamLogging'=>true,
	],
	require __DIR__ . '/db-local.php'
);