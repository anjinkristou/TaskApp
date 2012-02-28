<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->page->title ?></title>
<?php

foreach($this->page->javascripts as $javascript)
	Element::IncludeJavascript($javascript);

foreach($this->page->styles as $style)
	Element::IncludeStyle($style);

	?>
</head>
<body>

<div id="center">
	<div id="header"><?php include $this->getFileTemplate($this->page->header); ?></div>
	<div id="content">
	<?php $this->has_model ? $this->model->displayTemplate() : include $this->getFileTemplate($this->page->content); ?>
	</div>
</div>

<?php include $this->getFileTemplate($this->page->footer); ?>

</body>
</html>