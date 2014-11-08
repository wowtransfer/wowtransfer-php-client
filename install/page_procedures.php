<?php

$fields = array('submit', 'back');

if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$template->writeSubmitedFields();
	header('Location: index.php?page=struct');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$db = new InstallerDatabaseManager($template);

	if ($db->createProcedures() && !$template->hasErrors())
	{
		$template->writeSubmitedFields();
		header('Location: index.php?page=privileges');
		exit;
	}
}

?>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<div class="alert alert-info">
		На этом шаге будут созданы хранимые процедуры в базе данных с персонажами.
	</div>

	<pre class="sql-code" style="height: 400px;"><?php echo $template->loadDbProcedures(); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>