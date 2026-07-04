<?php
/* ================================================================
*
*	Gets all posts.
*
*	#Authors: The Kumor
* 
* ================================================================ */

$files = glob("posts/*.js");
$contents = [];

for ($i = 0; $i < count($files); $i++) {
	$file = fopen($files[$i], "r");

	$fileData = [];
	$fileData["Name"] = basename($files[$i]);
	$fileData["Content"] = fread($file, filesize($files[$i]));

	array_push($contents, $fileData);
	fclose($file);
}

echo json_encode($contents);
?>