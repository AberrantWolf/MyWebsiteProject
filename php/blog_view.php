<?php

include_once "parsedown/Parsedown.php";
include_once "parsedown/ParsedownExtra.php";

$ParsedownExtra = new ParsedownExtra();

function load_blog_post($path) {
	$contents = file_get_contents($path);
	$first = strpos($path, "/", 3) + 1;
	$last = strrpos($path, "/");
	$length = $last - $first;
	$date_str = "### " . date("Y, F d - l", strtotime(substr($path, $first, $length)));
	//$date_str = $path;

	$result = str_replace('<<DATE>>', $date_str, $contents);

	return $result;
}

function read_blog_files($prefix, $current_path, $max_count, $result) {
	if (!isset($result)) {
		$result = array();
	}

	if (count($result) >= $max_count) {
		return $result;
	}

	$full_path = $prefix . "/" . $current_path;
	$files = scandir($full_path);
	$reverse_list = array_reverse($files); // access files most recent at top
	foreach ($reverse_list as $key => $filename) {
		if ($key > count($reverse_list) - 3) {
			continue;
		}
		if (substr($filename, 0, 1) === ".") {
			continue;
		}

		// skip '.' and '..' directories in a reverse-sorted list
		if (is_dir($full_path . $filename)) {
			$result = read_blog_files(
					$prefix, $current_path . $filename . "/", $max_count, $result);
		} else {
			$output = "";
			if (count($result) > 0) {
				$output .= "\n----\n";
			}
			$output .= load_blog_post($full_path . $filename);
			array_push($result, $output);
		}
	}

	return $result;
}

function handle_post() {
	$posting = filter_input(INPUT_POST, 'markdown');
	print("<br>Sample text...<br>" . $posting);
}

function handle_get() {
	$entry = filter_input(INPUT_GET, 'entry');
	if ($entry == "") {
		$markdown = "";
		$md_array = read_blog_files("../blog", "", 5, NULL);

		if (!is_array($md_array)) {
			$markdown = "Not an array";
		} else {
			foreach ($md_array as $key => $md_chunk) {
				$markdown .= "\n" . $md_chunk;
			}
		}
	} else {
		$markdown = load_blog_post("../" . $entry);
	}
}

// MAIN CODE
$requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($requestMethod === 'POST') {
	handle_post();
} elseif ($requestMethod === 'GET'){
	handle_get();
} else {
	print("ERROR: Unhandled request method! :(");
}

print($ParsedownExtra->text($markdown));
?>