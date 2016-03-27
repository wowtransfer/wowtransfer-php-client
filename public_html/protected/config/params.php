<?php

return array_merge(
	require __DIR__ . DIRECTORY_SEPARATOR . 'app.php',
	require __DIR__ . DIRECTORY_SEPARATOR . 'app-local.php',
	require __DIR__ . DIRECTORY_SEPARATOR . 'service.php',
	require __DIR__ . DIRECTORY_SEPARATOR . 'service-local.php'
);
