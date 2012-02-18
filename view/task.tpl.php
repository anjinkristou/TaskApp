<div class="task_item">
<form action="<?php Link::ShowURL("index", "update")?>">
<input type="hidden" value="<?php echo $this->id; ?>">

<div class="task_header">

	<?php if(!$this->is_form) echo $this->title; ?>
	<input <?php if(!$this->is_form) echo 'class="hidden"'; ?> type="text" value="<?php echo $this->title; ?>">

	<div class="task_counter">
		<a href="#">Start</a>
		<a href="#">Pause</a>
		<a href="#">Stop</a>
	</div>

</div>

<div class="task_detail">

<?php if(!$this->is_form) echo $this->description; ?>
<input <?php if(!$this->is_form) echo 'class="hidden"'; ?> type="text" value="<?php echo $this->description; ?>">

</div>

</form>
</div>