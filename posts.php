<?php
/* ================================================================
 *
 *	Gets all posts.
 *
 *	#Authors: The Kumor
 * 
 * ================================================================ */

include "database.php";

$contents = [];
$conn = Connect();

// #TODO: Change this in the future for pages!
$query = "SELECT posts.id, posts.author, posts.title, posts.created_at, posts.category, posts.tags, posts.content, posts.version, users.nick FROM posts INNER JOIN users ON posts.author = users.id;";
if ($result = $conn->query($query))
{
	while($row = $result->fetch_row())
	{
		$id = $row[0];
		$authorID = $row[1];
		$title = $row[2];
		$createdAt = $row[3];
		$categoryID = $row[4];
		$tags = $row[5];
		$content = $row[6];
		$version = $row[7];
		$authorNick = $row[8];

		$content = base64_decode($content);

		$postData = [];
		$postContent = "SetTitle(\"{$title}\"); SetAuthor(\"{$authorNick}\"); SetTime(\"{$createdAt}\"); SetTags(\"{$tags}\"); SetCategory(\"{$categoryID}\");";
		$postContent = $postContent . $content;

		$postData["Content"] = $postContent;

		array_push($contents, $postData);
	}
}
else
{
	$failContents = [];
	$failContents["Content"] = "Text(\"Uaaah, I failed to load. >_<\")";
	echo json_encode($failContents);
}

/*
for ($i = 0; $i < count($files); $i++) {
	$file = fopen($files[$i], "r");

	$fileData = [];
	$fileData["Name"] = basename($files[$i]);
	$fileData["Content"] = fread($file, filesize($files[$i]));

	array_push($contents, $fileData);
	fclose($file);
}
*/

echo json_encode($contents);
?>