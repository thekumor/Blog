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
		content BLOB,

		FOREIGN KEY(author) REFERENCES users(id),
		FOREIGN KEY(category) REFERENCES categories(id)
	);");

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

function CreatePost($conn, $title, $authorName, $categoryName, $tags, $content, $timestamp = date("Y-m-d H:i:s"))
{
	$title = mysqli_real_escape_string($conn, $title);
	$authorName = mysqli_real_escape_string($conn, $authorName);
	$categoryName = mysqli_real_escape_string($conn, $categoryName);
	$tags = mysqli_real_escape_string($conn, $tags);
	$timestamp = mysqli_real_escape_string($conn, $timestamp);
	
	// Will this work?
	//$content = mysqli_real_escape_string($conn, $content);

//	$conn->query("INSERT INTO posts(author, title, created_at, category, tags, content) VALUES()");
}

function Disconnect($conn)
{
	$conn->close();
}