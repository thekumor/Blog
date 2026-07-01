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

var shouldInsert = true;

function SetTitle(title)
{
	metaInfo["Title"] = title;
	// return Heading(title);
}

function SetAuthor(author, color = "#ffdd55")
{
	metaInfo["Author"] = author;
	// return Text(author, color, JUSTIFY_LEFT);
}

function SetTime(time)
{
	metaInfo["Time"] = time;
	// return Text(time);
}

function SetCategory(cat)
{
	metaInfo["Category"] = cat;
	// return Text(cat);
}

function SetTags(...args)
{
	metaInfo["Tags"] = [...args];
	// return List(...args);
}

function Heading(text)
{
	var element = "<h2>" + text + "</h2>"

	if (shouldInsert)
		postElements.push(element);
	
	return element;
}

function Image(src)
{
	var element = "<img src=\"" + src + "\">";


	if (shouldInsert)
		postElements.push(element);
	
	return element;
}

function Spacer()
{
	var element = "<spacer />";
	
	if (shouldInsert)
		postElements.push(element);
	
	return element;
}

function Link(text, href)
{
	var element = "<a href=\"" + href + "\"> " + text + " </a>"

	if (shouldInsert)
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

	if (shouldInsert)
		postElements.push(element);
	
	return element;
}

function List(...args)
{
	var listElements = "<ul>\n";
	args.forEach(arg => listElements += "<li>" + arg + "</li>\n");

	listElements += "</ul>";

	if (shouldInsert)
		postElements.push(listElements);
	
	return listElements;
}

function PutOnScreen(postName)
{
	var parent  = document.getElementById("main-container");
	shouldInsert = false;
	
	if (!metaInfo["Time"])
		metaInfo["Time"] = "2026-06-30 0:00";
	
	var time = Text(metaInfo["Time"]);
	postElements.push(time);
	
	if (!metaInfo["Author"])
		metaInfo["Author"]= "unnamed";
	
	var author = Text(metaInfo["Author"])
	postElements.push(author);

	var postParent = document.createElement("div");
	postParent.className = "post-container";
	postParent.id = metaInfo["Time"];

	var thisDate = Date.parse(metaInfo["Time"]);

	const containers = Array.from(document.getElementsByClassName("post-container"));

    let inserted = false;

    for (const div of containers)
    {
        const divTime = Date.parse(div.id);

        if (divTime < thisDate)
        {
            parent.insertBefore(postParent, div);
            inserted = true;
            break;
        }
    }

    if (!inserted)
        parent.appendChild(postParent);

	if (!metaInfo["Title"])
		SetTitle(postName);
	
	var title = Text(metaInfo["Title"]);
	postElements.splice(0, 0, title);

	postElements.forEach(element => {
		var container = document.createElement("div");
		container.className = "post-element-container";
		container.innerHTML = element;

		postParent.appendChild(container);
	});

	// Clears the elements for new post.
	postElements = [];
	metaInfo = {};
	shouldInsert = true;
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