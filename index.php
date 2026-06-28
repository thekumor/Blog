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
	
	include "config.php";
?>

<html>
<head>
	<title>Kumor blog</title>
	<meta charset="UTF-8" />

	<link rel="stylesheet" href="style.css" />
	<script src="posts.js"></script>
</head>

<body onload="OnLoad()">
	<h1>
		<?php
			echo $config["Name"];
		?>
	</h1>

	<h3>
		<?php
			echo $config["Motto"];
		?>
	</h3>

	<div class="container" id="main-container"></div>

	<footer>
		<p>Blog - The Kumor 2026</p>
	</footer>
</body>
</html>