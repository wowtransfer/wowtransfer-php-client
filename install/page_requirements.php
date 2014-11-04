<?php
$requirements = array(
	'php_version' => array(
		'value' => 'Версия РНР',
		'result' => version_compare(phpversion(), '5.4', '>=') > 0,
		'comment' => 'Версия должна быть больше 5.4',
	),
	'ext_json' => array(
		'value' => 'Расширение json',
		'result' => extension_loaded('json'),
		'comment' => 'Функции для работы с json',
	),
	'ext_pdo' => array(
		'value' => 'Расширение PDO',
		'result' => extension_loaded('pdo'),
		'comment' => 'Функции для работы с json',
	),
	'ext_pdo_mysql' => array(
		'value' => 'Расширение PDO MySQL',
		'result' => extension_loaded('pdo_mysql'),
		'comment' => 'Необходимо для работы с MySQL',
	),
);

?>

<h1><?php echo $page['title']; ?></h1>

<table class="table">
	<thead>
		<tr>
			<th>Значение</th>
			<th>Результат</th>
			<th>Комментарий</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($requirements as $name => $requirement): ?>
		<tr>
			<td><?php echo $requirement['value']; ?></td>
			<td>
<?php
				$resultClass = 'warning';
				$resultTitle = 'Предупреждение';
				if (isset($requirement['result']) && $requirement['result'])
				{
					$resultClass = 'success';
					$resultTitle = 'OK';
				}
?>
				<span class="label label-<?php echo $resultClass; ?>"><?php echo $resultTitle; ?></span>
			</td>
			<td><?php echo isset($requirement['comment']) ? $requirement['comment'] : ''; ?></td>
		</tr>
		<?php endforeach; ?>
		
	</tbody>
</table>


<div>
	<a class="btn btn-default" title="Back" href="index.php">Назад</a>
	<a class="btn btn-primary" title="Next" href="index.php?page=connect">Далее</a>
</div>