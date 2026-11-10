<?php
/* ================================================================
 *
 *	Contains interface for connecting to database and retrieving
 *	data from it as well as saving/modifying it.
 *
 *	#Authors: The Kumor
 *
 * ================================================================ */

include "config.php";

$dtb = $config["Database"];
if (!$dtb)
	die("Couldn't retrieve database info!");

function Disconnect($conn)
{
	$conn->close();
}

function Connect()
{
	global $dtb;

	$conn = new mysqli(
		$dtb["Host"],
		$dtb["User"],
		$dtb["Password"]
	);
	if (!$conn)
		die("Couldn't connect!");

	// Create this database.
	$conn->query("CREATE DATABASE IF NOT EXISTS {$dtb['Database']};");
	$conn->query("USE {$dtb['Database']};");

	$conn->query("CREATE TABLE IF NOT EXISTS users(
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		nick VARCHAR(64)
	);");

	$conn->query("CREATE TABLE IF NOT EXISTS categories(
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		name VARCHAR(64) UNIQUE
	);");

	$conn->query("CREATE TABLE IF NOT EXISTS posts(
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		author INT,
		title VARCHAR(64),
		created_at DATETIME,
		category INT,
		tags TEXT,
		content TEXT,
		version TEXT,

		FOREIGN KEY(author) REFERENCES users(id),
		FOREIGN KEY(category) REFERENCES categories(id)
	);");

	$conn->query("INSERT INTO users(id, nick) VALUES(1, \"Admin\") ON DUPLICATE KEY UPDATE id = 1");

	// Create a user and grant him privileges on this database.
	$conn->query("CREATE USER IF NOT EXISTS blog IDENTIFIED BY {$dtb['Password']};");
	$conn->query("GRANT ALL PRIVILEGES ON {$dtb['Database']}.* to 'blog'@'localhost' WITH GRANT OPTION;");

	Disconnect($conn);

	$conn = new mysqli(
		$dtb["Host"],
		"blog",
		$dtb["Password"]
	);
	if (!$conn)
		die("Couldn't connect!");

	return $conn;
}

function CreateUser($conn, $name)
{
	// #TODO: Make it not work if user already exists.
	$name = mysqli_real_escape_string($conn, $name);
	$conn->query("INSERT INTO users(name) VALUES({$name});");
}

function CreateCategory($conn, $category)
{
	// #TODO: Make it not work if category already exists.
	$category = mysqli_real_escape_string($conn, $category);
	$conn->query("INSERT INTO categories(name) VALUES({$category});");
}

function CreatePost($conn, $title, $authorName, $categoryName, $tags, $content, $timestamp, $version)
{
	$timestamp = $timestamp ? $timestamp : date("Y-m-d H:i:s");
	$version = $version ? $version : "0";

	$title = mysqli_real_escape_string($conn, $title);
	$authorName = mysqli_real_escape_string($conn, $authorName);
	$categoryName = mysqli_real_escape_string($conn, $categoryName);
	$tags = mysqli_real_escape_string($conn, $tags);
	$timestamp = mysqli_real_escape_string($conn, $timestamp);
	$version = mysqli_real_escape_string($conn, $version);

	$query = "SELECT id FROM users WHERE nick LIKE \"{$authorName}\";";
	$authorID = $conn->query($query)->fetch_row()[0];

	$query = "SELECT id FROM categories WHERE name LIKE \"{$categoryName}\";";
	$categoryID = $conn->query($query)->fetch_row()[0];

	$content = base64_encode($content);

	$query = "INSERT INTO posts(author, title, created_at, category, tags, content, version)
		VALUES({$authorID}, \"{$title}\", \"{$timestamp}\", {$categoryID}, \"{$tags}\", \"{$content}\", \"{$version}\");
	";

	$conn->query($query);
}