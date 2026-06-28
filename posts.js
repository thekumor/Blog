/* ================================================================
*
*	Parses post content and puts it on the screen.
*
*	#Authors: The Kumor
* 
* ================================================================ */

var postElements = [];
var metaInfo = {};

function SetTitle(title)
{
	metaInfo["Title"] = title;
	return Heading(title);
}

function SetAuthor(author)
{
	metaInfo["Author"] = author;
	return Text(author);
}

function SetTime(time)
{
	metaInfo["Time"] = time;
	return Text(time);
}

function Heading(text)
{
	var element = "<h2>" + text + "</h2>"

	postElements.push(element);
	return element;
}

function Image(src)
{
	var element = "<img src=\"" + src + "\">";

	postElements.push(element);
	return element;
}

function Text(content, color)
{
	var element = "";

	if (color)
		element = "<p class=\"colored-text\">" + content + "</p>";
	else
		element = "<p>" + content + "</p>";

	postElements.push(element);
	return element;
}

function List(...args)
{
	var listElements = "<ul>\n";
	args.forEach(arg => listElements += "<li>" + arg + "</li>\n");

	listElements += "</ul>";
}

function PutOnScreen(postName)
{
	var parent = document.getElementById("main-container");

	var postParent = document.createElement("div");
	postParent.className = "post-container";
	parent.appendChild(postParent);

	if (!metaInfo["Title"])
	{
		var title = document.createElement("h2");
		title.textContent = postName;

		parent.appendChild(title);
	}

	postElements.forEach(element => {
		var container = document.createElement("div");
		container.className = "post-element-container";
		container.innerHTML = element;

		parent.appendChild(container);
	});

	// Clears the elements for new post.
	postElements = [];
	metaInfo = {};
}

function OnLoad()
{
	fetch("posts.php")
		.then(res => res.json())
		.then(files => {
			for (const file of files) {
				const script = document.createElement("script");
				script.src = file;

				const name = file.split("/").pop().replace(".js", "");

				script.onload = () => {
					console.log("Loaded post script: " + script.src);
					PutOnScreen(name);
				};

				document.head.appendChild(script);
			}
		});
}