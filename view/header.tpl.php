<style>
<!--
.header {
	padding: 10px 10px 0px 10px;
	font-family: verdana,arial,sans-serif;
	overflow: hidden;
}

.header > #user-info {
	float: right;
}

.header > #user-info #username {
	display: inline-block;
	font-variant: small-caps; font-size: 1.2em;
	margin: 8px;
}

.header > #user-info > a {
	display: inline-block;
	width: 100px; padding: 5px; vertical-align: bottom;
	background-color: #7F6F5E;
	color: #FFBA70;
	text-decoration: none; text-align: center;
	font-size: 1.1em;
}
-->
</style>

<div class="header">

	<div id="user-info">
		<span id="username"><?php echo Session::$UserName; ?></span>
		<?php Link::ShowAnchor("Logout", "login", "logout", array("class"=>"ui-corner-top")); ?>
	</div>

</div>
