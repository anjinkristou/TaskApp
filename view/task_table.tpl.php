<script type="text/javascript">
<!--
$(function() {
	// Initial actions
	$("#new_task").hide();

	// Bindings
	$("#new_task_button").toggle(function() {
		$("#new_task").show('slow')
		$(this).text("Cancel");
	}, function() {
		$("#new_task").hide('fast');
		$(this).text("New");
	});

});
//-->
</script>

<div id="new_task_button" class="icon-newtask ui-corner-all">New</div>

<div id="new_task">
	<form method="post" action="<?php Link::ShowURL("index", "newtask"); ?>">
		<label for="title">Title</label>
		<input id="title" type="text" name="title" />
		<br />
		<label for="description">Description</label>
		<textarea id="description" name="description" rows="5"></textarea>
		<br />
		<label>Estimated time</label>
		<div class="estimate_time">

			<input type="text" size="4" name="estimate_days" />
			<label>days</label>

			<input type="text" size="2" name="estimate_hours" />
			<label>hours</label>

			<input type="text" size="2" name="estimate_minutes" />
			<label>minutes</label>

		</div>
		<button type="submit" class="ui-corner-all">Create</button>
	</form>
</div>

<div id="task_table">
<?php
if(!empty($this->rows))
	foreach($this->rows as $task) {
		$task->displayTemplate();
	}
else
	echo '<div id="notasks">No tasks to be shown.</div>';
?>

</div>