/* ================================================================
*
*	Parses post content and puts it on the screen.
*
*	#Authors: The Kumor
* 
* ================================================================ */

var postElements = [];
var metaInfo = {};

var JUSTIFY_CENTER = "justify-center";
var JUSTIFY_LEFT = "justify-left";
var JUSTIFY_RIGHT = "justify-right";
var JUSTIFY_DEFAULT = JUSTIFY_LEFT;

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

function Text(content, justify, color)
{
	var element = "";

	if (!justify)
		justify = JUSTIFY_DEFAULT;

	var style = "";

	if (color)
		style = "style=\"color: " + color + "\"";

	element = "<p class=\"" + justify + "\" " + style + ">" + content + "</p>";

	postElements.push(element);
	return element;
}

function List(...args)
{
	var listElements = "<ul>\n";
	args.forEach(arg => listElements += "<li>" + arg + "</li>\n");

	listElements += "</ul>";

	postElements.push(listElements);
	return listElements;
}

function PutOnScreen(postName)
{
	var parentOfParent = document.getElementById("main-container");

	if (!metaInfo["Time"])
	{
		metaInfo["Time"] = "2026-06-25 0:00";
	}

	var postParent = document.createElement("div");
	postParent.className = "post-container";
	postParent.id = metaInfo["Time"];

	var thisDate = Date.parse(metaInfo["Time"]);

	var containers = document.getElementsByClassName("post-container");

	if (containers.length > 1)
	{
		var divTimes = {};
		for (var div of containers)
		{
			if (div == postParent)
				continue;

			const divTime = Date.parse(div.id);
			divTimes[div.id] = divTime;
		}
		const sorted = Object.entries(divTimes)
			.sort(([, dateA], [, dateB]) => dateA - dateB);

		const min = Object.entries(divTimes)
			.reduce((min, cur) => {
				return cur[1] < min[1] ? cur : min;
			});

		parentOfParent.insertBefore(postParent, getElementById(min[0]));
	}
	else
		parentOfParent.appendChild(postParent);

	if (!metaInfo["Title"])
	{
		var title = document.createElement("h2");
		title.textContent = postName;

		postParent.appendChild(title);
	}

	postElements.forEach(element => {
		var container = document.createElement("div");
		container.className = "post-element-container";
		container.innerHTML = element;

		postParent.appendChild(container);
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