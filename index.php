<html>
    <head>
        <title>Hi, My Site</title>
        <link rel="stylesheet" href="mywebsite.css">
        <script src="js/jquery-2.1.4.js"></script>
        <script src="epiceditor/epiceditor.min.js"></script>
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
                <div id="epiceditor"></div>
                <form action="php/blog_view.php" method="post">
                    <input type="text" name="markdown" id="edittext" hidden="true">
                    <input type="submit" value="Commit">
                </form>
            </div>
        </div>

        <script>
			$(document).ready(function () {
				var opts = {
					container: 'epiceditor',
					textarea: 'edittext',
					basePath: 'epiceditor',
					clientSideStorage: false,
					localStorageName: 'epiceditor',
					useNativeFullscreen: true,
					parser: marked,
					file: {
						name: 'epiceditor',
						defaultContent: '',
						autoSave: false
					},
					theme: {
						base: '/themes/base/epiceditor.css',
						preview: '/themes/preview/preview-dark.css',
						editor: '/themes/editor/epic-dark.css'
					},
					button: {
						preview: true,
						fullscreen: true,
						bar: "auto"
					},
					focusOnLoad: false,
					shortcut: {
						modifier: 18,
						fullscreen: 70,
						preview: 80
					},
					string: {
						togglePreview: 'Toggle Preview Mode',
						toggleEdit: 'Toggle Edit Mode',
						toggleFullscreen: 'Enter Fullscreen'
					},
					autogrow: true
				}
				var editor = new EpicEditor(opts).load();

				$(".post").each(function () {
					$(this).click(function () {
						$.ajax("php/blog_view.php?entry=" + this.id)
								.success(function (msg) {
									$("#blog_view").append(msg);
								})
								.fail(function () {
									$("#blog_view").html("AJAX failure loading post: " + this.id);
								});
					})
							.mouseover(function () {
								this.style.fontWeight = "bold";
							})
							.mouseout(function () {
								this.style.fontWeight = "normal";
							});
				});

				$.ajax("php/blog_view.php?entry=")
						.success(function (msg) {
							$("#blog_view").append(msg);
						})
						.fail(function () {
							$("#blog_view").html("AJAX failure loading default bog posts");
						})
			});
        </script>
    </body>
</head>
</html>