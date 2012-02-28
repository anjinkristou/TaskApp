<div class="header">

	<div id="user-info">
		<span id="username"><?php echo Session::$UserName; ?></span>
		<?php Link::ShowAnchor("Logout", "login", "logout", array("class"=>"ui-corner-all")); ?>
	</div>

</div>
