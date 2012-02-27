<div class="task_item ui-widget ui-corner-all">
<form action="<?php Link::ShowURL("index", "update")?>">
<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
<?php
	if($this->started != '0000-00-00 00:00:00')
		echo '<input type="hidden" name="started" value="true" />';
?>

<div class="task_header">

	<div class="task_is_done ui-corner-all">
		<input type="hidden" name="is_done" value="<?php echo $this->is_done; ?>" />
	</div>

	<div class="task_title editable ui-corner-all">
		<div class="editable_data icon-down" style="display: inline-block"><?php echo $this->title; ?></div>
		<input type="text" name="title" />
		<div class="edit icon-pencil" style="display: inline-block"></div>
	</div>

	<div class="task_delete icon-delete"></div>

	<div class="task_counter">
		<input type="hidden" name="duration" value="<?php echo $this->duration; ?>" />
		<a href="#"></a>
		<div class="task_counter_clock"></div>
	</div>

</div>

<div class="task_detail ui-widget-content ui-corner-all">

<div style="float: left; width: 50%; height: 100%;">

	<div class="editable description">
		<label>Description</label>
		<div class="editable_data"><?php echo $this->description; ?></div>
		<textarea name="description"></textarea>
	</div>

</div>
<div style="float:left; height: 100%; width: 50%;">

	<div class="editable datetime">
		<label>Start</label>
		<div class="editable_data"><?php echo $this->start; ?></div>
		<input type="text" name="start" />
	</div>

	<div class="editable datetime">
		<label>End</label>
		<span class="editable_data"><?php echo $this->end; ?></span>
		<input type="text" name="end" />
	</div>

	<div class="editable estimate">
		<label>Estimated time</label>

		<div class="estimate_time">

			<span class="editable_data"><?php echo $this->estimate_days; ?></span>
			<input type="text" size="4" name="estimate_days" />
			<label>days</label>

			<span class="editable_data"><?php echo $this->estimate_hours; ?></span>
			<input type="text" size="2" name="estimate_hours" />
			<label>hours</label>

			<span class="editable_data"><?php echo $this->estimate_minutes; ?></span>
			<input type="text" size="2" name="estimate_minutes" />
			<label>minutes</label>

		</div>
	</div>

</div>

</div>

</form>
</div>