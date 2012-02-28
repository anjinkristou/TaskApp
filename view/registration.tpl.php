<script type="text/javascript">
<!--
$(function() {
	$('button[type="submit"]').button();
	$('button[type="reset"]').button();

	$('input[name="password2"]').keyup(function(event) {
		var pass2 = $(this).val();
		var pass = $('input[name="password"]').val();
		if(pass == pass2)
			$(this).css("background-color", "#B9FF8A");
		else
			$(this).css("background-color", "white");
	});

	$('button[type="submit"]').click(function(event) {
		var has_error = false;
		var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var email = $('input[name="email"]').val();
        if(email == '') {
            has_error = true;
            $(this).nextAll('.error').remove();
            $(this).after('<span class="error">Please enter your email address.<\/span>');
        } else if(!email_reg.test(email)) {
        	has_error = true;
        	$(this).nextAll('.error').remove();
        	$(this).after('<span class="error">Enter a valid email address.<\/span>');
        }

        if(has_error)
            event.preventDefault();
	});

});
//-->
</script>

<div id="registration">

	<div class="title">Registration</div>

<form method="post" action="index.php?c=registration&amp;a=register">

<div style="overflow: hidden; clear: both; ">

	<!--
	<label>Name</label>
	<input type="text" name="name">
	-->

	<label>E-mail</label>
	<input type="text" name="email">

	<label>Password</label>
	<input type="password" name="password">

	<label>Re-enter password</label>
	<input type="password" name="password2">

</div>

<div style="float: right; margin-right: 150px;">
	<button type="reset">Reset</button>
	<button type="submit">Register</button>
</div>

</form>
</div>
