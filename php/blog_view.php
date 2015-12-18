<?php
include_once "parsedown/Parsedown.php";
include_once "parsedown/ParsedownExtra.php";

$Extra = new ParsedownExtra();

$blog_root = "../";

$markdown = file_get_contents($blog_root.$_GET['entry']);

print($Extra->text($markdown));
?>