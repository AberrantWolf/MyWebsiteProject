<html>
	<head>
		<title>Hi, My Site</title>
		<link rel="stylesheet" href="menu.css">
		<script src="js/jquery-2.1.4.js"></script>
		<body>
			<div id="blog_menu">
<?php
include_once "php/blog_menu.php";

make_menu("blog", "", "year");

//phpinfo();
?>
			</div>
			<div id="blog_view">
			</div>

			<script>
$(document).ready(function() {
	$(".post").each(function(){
		$(this).click(function() {
			$.ajax("php/blog_view.php?entry=" + this.id)
			.success(function(msg){
				$("#blog_view").html(msg);
			})
			.fail(function() {
				$("#blog_view").html("FAIL!");
			});
		});
	});
});
			</script>
		</body>
	</head>
</html>