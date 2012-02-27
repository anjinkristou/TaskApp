<div class="header">
	<?php Link::ShowAnchor("Home", "", "", array("class" => "ui-corner-top"))?>
	<?php Link::ShowAnchor("Statistics", "", "", array("class" => "ui-corner-top"))?>

	<div id="user_info">
		<span><?php echo Session::$UserName; ?></span>
		<?php Link::ShowAnchor("Logout", "login", "logout"); ?>
	</div>

</div>
