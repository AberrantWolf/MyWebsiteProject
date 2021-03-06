<?php
function make_menu($prefix, $current_path, $level) {
	$full_path = $prefix."/".$current_path;
	$files = scandir($full_path);
	$reverse_list = array_reverse($files); // access files most recent at top
	foreach ($reverse_list as $key => $filename) {
		// skip '.' and '..' directories in a reverse-sorted list
		if ($key > count($reverse_list)-3) {
			continue;
                }

		if (is_dir($full_path.$filename)) {
			$date = strtotime($current_path.$filename);
			$name = $filename;

			if($level == "month") {
				$name = date('F', $date);
			} elseif ($level == "day") {
				$name = date('l, d', $date);
			}

			printf("<div class=%s id=%s>%s", $level, $current_path.$filename, $name);
			
			$next_level = "";
			if ($level == "year") {
				$next_level = "month";
			} elseif ($level == "month") {
				$next_level = "day";
			} else {
				$next_level = "POST";
			}
			make_menu($prefix, $current_path.$filename."/", $next_level);
			printf("</div>");
		}
		else
		{
			$file_contents = file_get_contents($full_path.$filename);
			$firstline = str_replace("#", "", current(explode("\n", $file_contents)));
			printf("<div class='post' id='%s'>%s</div>", $full_path.$filename, $firstline);
		}
	}
}
?>