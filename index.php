<!-- ================================================================
--
--	Entry point of web app.
--
--	#Authors: The Kumor
--
-- ================================================================ -->

<?php
	include "config.php";
?>

<html>
<head>
	<title>Kumor blog</title>
	<meta charset="UTF-8" />

	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<h1>
		<?php
			echo $config["Name"];
		?>
	</h1>
</body>
</html>