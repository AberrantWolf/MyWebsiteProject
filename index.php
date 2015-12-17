<html>
	<head>
		<title>Hi, My Site</title>
		<body>
			<div id="blog_menu">
				<?php
				$files = scandir("blog");
				foreach ($files as $key => $filename) {
					if ($key < 2)
						continue;
					
					$extension = end(explode(".", $filename));
					print("<div>" . basename($filename, ".".$extension) . "</div>");
				}
				?>
			</div>
		</body>
	</head>
</html>