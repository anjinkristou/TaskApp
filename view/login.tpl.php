<style>
<!--
#taskapp_logo {
	font-style: italic;
	font-size: 2.8em;
	text-align: center;
	margin: 20px;
	paddin: 10px;
}

#login {
	position: absolute;
	top: 50%;
	left: 50%;
	height: 250px;
	width: 400px;
	margin-top: -125px;
	margin-left: -200px;
	background-color: #FFDFBD;
	border: solid black 1px;
	overflow: hidden;

}

#login label {
	float: left;
	clear: both;
	width: 30%;
	padding: 7px;
	margin: 3px;
	text-align: right;
}

#login input {
	float: left;
	width: 45%;
	padding: 5px;
	margin: 3px;
	text-align: left;
	font-size: 1.1em;
}

#login button, #login a {
	display: inline-block;
	width: 100px;
	text-align: center;
	margin-top: 15px;
}
-->
</style>
<script type="text/javascript">
<!--

$(function() {
	$('#login  button').button();
	$('#login  a').button();
});

//-->
</script>

<form method="post" action="index.php?c=login&a=login">

<div id="login" class="ui-corner-all">

	<div id="taskapp_logo">TaskApp</div>

	<div style="overflow: hidden;">
		<label>E-mail</label>
		<input type="text" name="email" />
		<label>Password</label>
		<input type="password" name="password" />
	</div>

	<div style="width: 220px; margin-right: 45px; margin-left: auto;">
		<a href="index.php?c=registration">Register</a>
		<button type="submit">Login</button>
	</div>

</div>

</form>
