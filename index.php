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

	<link rel="stylesheet" href="style.css" />
	<script src="posts.js"></script>
</head>

<body onload="OnLoad()">
	<div class="container" id="header-container">
		<div class="container" id="top-header-container">
			<img class="logo" src="https://thekumor.com/img/kumor_logo.svg" />

			<h1>
				<?php
				echo $config["Name"];
				?>
			</h1>
		</div>

		<h3><i>
				<?php
				echo $config["Motto"];
				?>
			</i>
		</h3>
	</div>

	<div class="container" id="main-container"></div>

	<footer>
		<p>Blog - The Kumor 2026</p>
	</footer>
</body>

</html>