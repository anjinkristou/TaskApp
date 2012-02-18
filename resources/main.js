
$(function() {
	taskUi();
});

function taskUi() {
	
	$(".task_item").addClass('ui-widget');
	$(".task_header").addClass('ui-widget-header');
	$(".task_header").addClass('ui-corner-tl');
	$(".task_header").addClass('ui-corner-tr');
	
	$(".task_detail").addClass('ui-widget-content');
	$(".task_detail").addClass('ui-corner-bl');
	$(".task_detail").addClass('ui-corner-br');
	//$(".task_item").addClass('ui-widget-overlay');
	//$(".task_item").addClass('ui-widget-shadow');
	
	$(".task_counter > a").button();
	
	$(".task_detail").hide();
	
	$(".task_item").toggle(function() {
		$(".task_detail", this).show('fast');
	}, function() {
		$(".task_detail", this).hide('fast');
	});
}