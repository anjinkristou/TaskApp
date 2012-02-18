<style type="text/css">
<!--
#task_table {
	background-color: #fffff0;
}

#new_task_button {
	display: block;
	background-color: blue;
	padding: 10px;
}
-->
</style>

<script type="text/javascript">
<!--
$(function() {
	// Initial actions
	$("#new_task").hide();

	// Bindings
	$("#new_task_button").click(function() {
		$("#new_task").show('slow');
	});

});
//-->
</script>

<div id="task_table">
<?php
foreach($this->rows as $task) {
	$task->displayTemplate();
}
?>

<div id="new_task_button">New Task</div>
<div id="new_task">
<form method="post" action="<?php Link::ShowURL("index", "newtask"); ?>">
<label for="title">Title</label>
<input id="title" type="text" name="title" />
<br />
<label for="description">Description</label>
<textarea id="description" name="description" rows="10" cols="30"></textarea>
<input type="submit" value="Create" />
</form>
</div>

</div>