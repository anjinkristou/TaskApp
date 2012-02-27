<style>

#registration {
	width: 100%; text-align: center; margin: 50px 50px 30px 50px;
	font-size: 1.8em;
	font-style: italic;
}

form {
	width: 70%;
	margin-right: auto;
	margin-left: auto;
}

form label {
	float: left; clear: both; width: 35%;
	text-align: right;
	margin: 5px; padding: 5px;
}

form input {
	float: left; width: 250px;
	margin: 5px; padding: 5px;
}

form button {
	margin: 10px;
}

form button[type="reset"] {
	background: #FF9A8A;
}

.error {
	display: block;
	color: red;
	margin: 10px;
}

</style>
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
            $(this).after('<span class="error">Please enter your email address.</span>');
        } else if(!email_reg.test(email)) {
        	has_error = true;
        	$(this).nextAll('.error').remove();
        	$(this).after('<span class="error">Enter a valid email address.</span>');
        }

        if(has_error)
            event.preventDefault();
	});

});
//-->
</script>

<div id="registration">Registration</div>

<form method="post" action="index.php?c=registration&a=register">

<div style="overflow: hidden; clear: both; ">

	<!--
	<label>Name</label>
	<input type="text" name="name" />
	-->

	<label>E-mail</label>
	<input type="text" name="email" />

	<label>Password</label>
	<input type="password" name="password" />

	<label>Re-enter password</label>
	<input type="password" name="password2" />

</div>

<div style="float: right; margin-right: 150px;">
	<button type="reset">Reset</button>
	<button type="submit">Register</button>
</div>

</form>
