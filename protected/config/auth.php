<?php

return array(
	'guest' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Guest',
		'bizRule' => null,
		'data' => null
	),
	'user' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'User',
		'children' => array(
			'guest',
		),
		'bizRule' => null,
		'data' => null
	),
	'moderator' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Moderator',
		'children' => array(
			'user',
		),
		'bizRule' => null,
		'data' => null
	),
	'admin' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Administrator',
		'children' => array(
			'moderator',
		),
		'bizRule' => null,
		'data' => null
	),
);