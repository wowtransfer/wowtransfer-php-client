<?php
/* @var $this TransfersController frontend */
/* @var $model ChdTransfer model */
?>

<h1>Создание персонажа по заявке #<?php echo $model->id; ?></h1>

<div style="float: right; border: 1px solid blue; width: 260px; height: 400px;">
<a href="#">Clear character's data by GUID and ID</a> <span style="color: green;">safe</span><br>
<a href="#">Clear character's data by GUID</a> <span style="color: orange;">unsafe</span><br>
<a href="#">Show character's info by GUID</a><br>
<hr>
Список заявок<br>
Управление заявками<br>
</div>

<div style="margin: 5px 0; border: 1px solid blue; width: 400px; height: 60px;">
Transfer attributes...
</div>

<div style="margin: 5px 0; border: 1px solid blue; width: 400px; height: 100px;">
Transfer options...
</div>

<p>
<button type="link">Create</button> Create character by AJAX
</p>

<p>
Retrieve SQL... errors
</p>

<p>
Run SQL... first error
</p>


<div style="border: 1px solid blue; width: 400px; height: 100px;">
Result table
</div>


results:
<div id="dump-lua" style="border: 1px solid blue; width: 400px; height: 100px;">

<div>
<span style="float: left;">index (1, 2, ...)</span><br>
query (maximum 255 characters)<br>
status
</div>


</div>
