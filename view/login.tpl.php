<script type="text/javascript">
<!--

$(function() {
	$('#login  button').button();
	$('#login  a').button();
});

//-->
</script>

<form method="post" action="index.php?c=login&amp;a=login">

<div id="login" class="ui-corner-all">

	<div id="taskapp_logo">TaskApp</div>

	<div style="overflow: hidden;">
		<label>E-mail</label>
		<input type="text" name="email">
		<label>Password</label>
		<input type="password" name="password">
	</div>

	<div style="width: 220px; margin-right: 45px; margin-left: auto;">
		<a href="index.php?c=registration">Register</a>
		<button type="submit">Login</button>
	</div>

</div>

</form>
