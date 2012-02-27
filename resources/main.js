$(function() {
	initTasks();
});

function initTasks() {
	
	$(":input").addClass('ui-corner-all');
	
	/**
	 * Task TIMER logic
	 */
	$(".task_counter").each(function() {
		$("a", this).addClass('icon-play');
		//$("button", this).button("options", "icons", {primary: 'icon-play', secondary: 'icon-pause'});
		var is_done = $(this).prevAll('.task_is_done').children('input[name="is_done"]').val();
		if(is_done == 0)
			$("a", this).toggle(startButton, pauseButton);
		else {
			$(this).css('color', '#CECECE');
			$("a", this).click(function(event) {
				event.preventDefault();
			});
		}
		// create timer
		var timer = new StopWatch(function(clock) {
			$(clock).text(this.getCurrentFormattedDuration());
		}, $('.task_counter_clock', this));
		// set already spent time
		var dur_so_far = $('input[name="duration"]', this).val();
		timer.initTo(dur_so_far);
		// store timer into counter
		$(this).data('timer', timer);
		// show timer
		$(".task_counter_clock", this).text(timer.getFormattedDuration());
	});
	/**
	 * EDITABLE fields logic
	 */
	var editables = $(".editable");
	editables.click(edit);
	$(":input", editables)	.hide() // hide all editable input fields
							.keydown(function(event) {
								if(event.which === 13 && event.ctrlKey) {
									ajaxSubmitTask(this);
								}
							});
	/**
	 * Task IS_DONE logic - check and bullet indicators
	 */
	$(".task_is_done")	.each(function() {
							var is_done = $('input[name="is_done"]', this).val();
							if(is_done == 1)
								$(this).addClass('icon-checked');
							else
								$(this).addClass('icon-unchecked');
						})
						.click(ajaxTaskDone)
						.click(pauseButton);
	/**
	 * Title click actions - toggling DETAIL logic
	 */
	$('.task_title').unbind('click', edit);
	$('.task_title .icon-pencil').click(function() {
		var parent = $(this).parents('.task_title');
		var input = $(':input', parent);
		var div = $('.editable_data', parent);
		input.val(div.text());
		// show/hide
		div.hide();
		input.show();
		$(this).hide();
	});
	$(".task_detail").hide();
	$('.task_title .editable_data').toggle(
			function() {
				$(this).parentsUntil('.task_item').nextAll('.task_detail')
						.show('fast');
				$(this).removeClass('icon-down');
				$(this).addClass('icon-up');
			},
			function() {
				$(this).parentsUntil('.task_item').nextAll(".task_detail")
						.hide('fast');
				$(this).removeClass('icon-up');
				$(this).addClass('icon-down');
			});
	/**
	 * Delete handler
	 */
	$('.task_delete').click(function() {
		var dialog = $('<div></div>').html("Are you sure you want to delete the task?");
		var id = $(this).parents('.task_item > form').children('input[name="id"]').val();
		dialog.dialog({
			resizable: false,
			height:160,
			modal: true,
			buttons: {
				Yes: function() {
					$( this ).dialog( "close" );
					$.post('index?m=ajax&c=task_ajax&a=delete',
							{'id': id},
							ajaxDeleteHandler);
				},
				"No": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
	});
	
	distinguishTasks();
	/**
	 * Create date picker on datetime inputs
	 */
	$('.task_item .editable.datetime > input').datepicker({ dateFormat: 'yy-mm-dd 00:00:00' });
	/**
	 * 
	 */
	$('.estimate_time').each(function() {
		var arr = $('.editable_data', this).text();
		if(arr == '000') {
			$(this)
				.after('<span class="no_estimate" style="font-weight:bold">none set</span>')
				.hide()
				.next().click(function() { $(this).hide(); $(this).prev().show(); });
				
		}
	});
	/**
	 * 
	 */
	$('.task_item').has('input[name="started"][value="true"]').find('.task_counter > a').click();
	/**
	 * Help, tooltips
	 */
	$('.editable_data')
		.attr('title', "Click to edit")
		.nextAll(':input').attr('title', "ctrl-enter to save");
	
}

function ajaxSubmitTask(context) {
	var form = $(context).parents("form");
	var data = serializeFormData(form);
	$.post('index.php?m=ajax&c=task_ajax&a=edit', 
			data,
			ajaxSubmitTaskHandler);
}

function serializeFormData(form) {
	var data = {};
	$(':input', form).each(function() {
		var value = '';
		if($(this).val() == '')
			value = $(this).prev('.editable_data').text();
		else
			value = $(this).val();
		data[$(this).attr('name')] = value;
	});
	return data;
}

function ajaxSubmitTaskHandler(xml) {
	var id = $("id", xml).text();
	var task_item = $('.task_item').has('input[name="id"][value="' + id + '"]');
	$(xml).children().each(function() {
		$(':input[name="'+this.nodeName.toLowerCase()+'"]', task_item)
			.prev('.editable_data').html($(this).html());
	});
	$('.editable_data, .editable > .icon-pencil').show(); // handle title pencil icon special case
	$('.editable :input', task_item).hide();
}

function distinguishTasks() {
	$('.task_item:odd')
		.removeClass('task_even')
		.addClass('task_odd');
	$('.task_item:even')
		.removeClass('task_odd')
		.addClass('task_even');
}

function edit() {
	$('.editable_data', this).each(function() {
		var input = $(this).next(':input');
		input.val(input.prev('.editable_data').text());
		// show/hide
		$(this).hide();
		input.show();
	});
}

function ajaxDeleteHandler(xml) {
	var id = $("id", xml).text();
	var form = $('.task_item').has('input[name="id"][value="' + id + '"]');
	form.remove();
	distinguishTasks();
}

function ajaxTaskDone() {
	var id = $(this).parents('form').children('input[name="id"]').val();
	/** 
	 * Global var, can be used in ajax callback,
	 * although it's not very safe.
	 * User can click on another checkbox is_done
	 * and send another ajax post
	 * before the response of the first one arrives.
	 */
	input = $('input[name="is_done"]', this);
	var is_done = $(input).val();
	if(is_done == 0)
		is_done = 1;
	else
		is_done = 0;
	// Ajax post
	$.post('index.php?m=ajax&c=task_ajax&a=done',
			{ 'id': id, 'is_done': is_done },
			ajaxTaskDoneHandler);
}

function ajaxTaskDoneHandler(xml) {
	var id = $("id", xml).text();
	var form = $('.task_item > form').has('input[name="id"][value="' + id + '"]');
	var is_done = $("done", xml).text();
	$('.task_is_done > input[name="is_done"]', form).val(is_done);
	$('input[name="end"]', form).prev('.editable_data').html($("end", xml).html());
	var elem = $('.task_is_done', form);
	if(is_done == 1) {
		elem.removeClass('icon-unchecked');
		elem.addClass('icon-checked');
		$('.task_counter > a', form).off('click');
		$('.task_counter > a', form).click(function(event) {
			event.preventDefault();
		});
		$('.task_counter', form).css('color', '#CECECE');
	} else {
		elem.removeClass('icon-checked');
		elem.addClass('icon-unchecked');
		$('.task_counter > a', form).toggle(startButton, pauseButton);
		$('.task_counter', form).css('color', 'black');
	}
}

function startButton() {
	var counter = $(this).parents(".task_counter");
	var timer = counter.data('timer');
	if (!timer)
		alert("There is a problem with timing session");
	timer.start();
	// change button style
	$(this).removeClass('icon-play');
	$(this).addClass('icon-pause');
	
	// post ajax request to store STARTED state of a task
	var id = $(this).parents('form').children('input[name="id"]').val();
	var now = new TimeSpan();
	$.post('index.php?m=ajax&c=task_ajax&a=started',
			{'id': id, 'started': now.getUnixTime()},
			ajaxTaskStartedHandler);
}

function ajaxTaskStartedHandler(xml) {
	var id = $("id", xml).text();
	var form = $('.task_item > form').has('input[name="id"][value="' + id + '"]');
	$('input[name="start"]', form).prev('.editable_data').html($("start", xml).html());
}

function pauseButton() {
	var parent = $(this).parents('.task_item');
	var counter = $(parent).find('.task_counter');
	var timer = counter.data('timer');
	if(timer.isRunning)
		timer.stop();
	else
		return;
	
	// set visible div clock value and input hidden field
	$('.task_counter_clock', counter).text(timer.getFormattedDuration());
	$('input[name="duration"]', counter).val(timer.timespan.getDuration());
	
	// change button icon
	$('a', counter).removeClass('icon-pause');
	$('a', counter).addClass('icon-play');
	
	// send ajax request for the server to store elapsed time
	var id = $(parent).find('input[name="id"]').val();
	$.post('index.php?m=ajax&c=task_ajax&a=stopped',
			{'id': id, 'duration': timer.timespan.getDuration()},
			ajaxTaskStoppedHandler);
}

function ajaxTaskStoppedHandler(xml) {
	// TODO: implement error handling
}

/*
 * DEPRECATED
 */
function ajaxEditableHandler(xml) {
	var id = $('id', xml).text();
	var attr = $('attribute', xml).text();
	var value = $('value', xml).html();
	var form = $('.task_item > form').has('input[name="id"][value="' + id + '"]');
	$('.editable > :input[name="'+attr+'"]', form)
		.val(value).hide()
		.prevAll(".editable_data").html(value).show()
		.nextAll('.icon-pencil').show();
}

function TimeSpan() {
	this.start_time;
	this.duration = 0;
	
	this.addSeconds = function(seconds) {
		this.duration += parseInt(seconds);
	};
	
	this.start = function() {
		this.start_time = this.getUnixTime();
	};
	
	this.stop = function() {
		var now = this.getUnixTime();
		this.duration += now - this.start_time;
	};
	
	this.getDuration = function() {
		return this.duration;
	};
	
	this.getDurationNow = function() {
		var now = this.getUnixTime();
		return now - this.start_time + this.duration;
	};
	
	this.getUnixTime = function() {
		var now = new Date;
		var unixtime_ms = now.getTime();
		return parseInt(unixtime_ms / 1000);
	};
}

function Timer(callback, miliseconds, context) {
	
	this.context = context;
	this.callback = callback;
	this.miliseconds = miliseconds;
	this.handle;
	
	this.start = function() {
		this.handle = setInterval(this.callback, this.miliseconds, this.context);
	};
	
	this.stop = function() {
		clearInterval(this.handle);
	};
}

function StopWatch(callback, context) {
	
	this.isRunning = false;
	
	this.initTo = function(value) {
		this.timespan.addSeconds(value);
	};
	
	this.start = function() {
		this.timespan.start();
		this.timer.start();
		this.isRunning = true;
	};
	
	this.tick = function(object) {
		object.callback(object.context);
	};
	
	this.stop = function() {
		this.timespan.stop();
		this.timer.stop();
		this.isRunning = false;
	};
	
	this.timespan = new TimeSpan();
	
	this.getFormattedDuration = function() {
		return this.formatTime(this.timespan.getDuration());
	};
	
	this.getCurrentFormattedDuration = function() {
		return this.formatTime(this.timespan.getDurationNow());
	};
	
	this.formatTime = function(time) {
		var total = time;
		var days = Math.floor(total / this.DAY_SECS);
		if(days.toString().length == 1) days = '00' + days;
		else if(days.toString().length == 2) days = '0' + days;
		total = total % this.DAY_SECS;
		var hours = Math.floor(total / this.HOUR_SECS);
		if(hours.toString().length == 1) hours = '0' + hours;
		total = total % this.HOUR_SECS;
		var minutes = Math.floor(total / this.MINUTE_SECS);
		if(minutes.toString().length == 1) minutes = '0' + minutes;
		total = total %	 this.MINUTE_SECS;
		var seconds = total;
		if(seconds.toString().length <= 1) seconds = '0' + seconds;
		return days+':'+hours+':'+minutes+':'+seconds;
	};
	
	// Init
	this.DAY_SECS = 86400;
	this.HOUR_SECS = 3600;
	this.MINUTE_SECS = 60;
	this.callback = callback;
	this.context = context;
	this.timer = new Timer(this.tick, 1000, this);
}
