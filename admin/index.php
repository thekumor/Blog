<!-- ================================================================
--
--	Entry point of web app.
--
--	#Authors: The Kumor
--
-- ================================================================ -->

<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include "../database.php";
?>

<html lang="en">

<head>
	<title><?php
	echo $config["Name"];
	?></title>
	<meta charset="UTF-8" />

	<!-- Highlight.js -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github-dark.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>

	<link rel="stylesheet" href="../style.css" />
</head>

<body onload="OnLoad()">
	<div class="container" id="header-container">
		<div class="container" id="admin-top-container">
			<img class="logo" src="https://thekumor.com/img/kumor_logo.svg" />

			<h1>
				<?php
				echo $config["Name"] . " admin panel";
				?>
			</h1>

			<h3><i>
					<?php
					echo $config["Motto"];
					?>
				</i>
			</h3>

			<div class="container" id="admin-container">
				<a href="settings.php">Blog settings</a>
				<a href="add_user.php">Manage users</a>
				<a href="add_category.php">Manage categories</a>
				<a href="add_post.php">Manage posts</a>
			</div>
			
			<a href="../">Back . . .</a>
		</div>
	</div>

	<footer>
		<p>Blog - The Kumor 2026</p>
	</footer>
</body>

</html>