<?php
/* ================================================================
*
*	Contains interface for connecting to database and retrieving
*	data from it as well as saving/modifying it.
*
*	#Authors: The Kumor
*
* ================================================================ */

include("config.php");

$dtb = $Config["Database"];
if (!$dtb)
	die("Couldn't retrieve database info!");

function Connect()
{
	global $dtb;

	$conn = new mysqli(
		$dtb["Host"],
		$dtb["User"],
		$dtb["Password"],
		$dtb["Databse"]
	);
	if (!$conn)
		die("Couldn't connect to database!");

	return $conn;
}

function Disconnect($conn)
{
	$conn->close();
}