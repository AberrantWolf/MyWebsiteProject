<html>
	<head>
		<title>Hi, My Site</title>
		<link rel="stylesheet" href="mywebsite.css">
		<script src="js/jquery-2.1.4.js"></script>
		<body>
			<div id="page">
				<div id="blog_menu">
	<?php
	include_once "php/blog_menu.php";

	make_menu("blog", "", "year");

	//phpinfo();
	?>
				</div>
				<div id="blog_view">
				</div>
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
				$("#blog_view").html("AJAX failure loading post: " + this.id);
			});
		})
		.mouseover(function(){
			this.style.fontWeight = "bold";
		})
		.mouseout(function(){
			this.style.fontWeight = "normal";
		});
	});

	$.ajax("php/blog_view.php?entry=")
	.success(function(msg){
		$("#blog_view").html(msg);
	})
	.fail(function() {
		$("#blog_view").html("AJAX failure loading default bog posts");
	})
});
			</script>
		</body>
	</head>
</html>