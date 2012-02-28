<?php

class Element {

	public static function IncludeStyle($resource_path) {
		Element::ShowElement("link", array(
			"rel" => "stylesheet",
			"type" => "text/css",
			"href" => $resource_path));
	}

	public static function IncludeJavascript($resource_path) {
		Element::ShowElement("script", array(
			"type" => "text/javascript",
			"src" => $resource_path), " ");
	}

	public static function ShowElement($node, $attributes, $content = "") {
		echo Element::MakeElement($node, $attributes, $content);
	}

	public static function MakeElement($node, $attributes, $content = "") {
		$result = "<$node";
		if(!empty($attributes))
			foreach ($attributes as $key => $value)
				$result .= " " . $key . '="' . $value . '"';
		if(!empty($content)) {
			$result .= ">$content</$node>";
		} else {
			$result .= ">";
		}
		return $result;
	}

}