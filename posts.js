/* ================================================================
*
*	Parses post content and puts it on the screen.
*
*	#Authors: The Kumor
* 
* ================================================================ */

var postElements = [];

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

function PutOnScreen()
{
	var parent = document.body;

	postElements.forEach(element => {
		var container = document.createElement("div");
		container.className = "post-element-container";
		container.innerHTML = element;

		parent.appendChild(container);
	});

	// Clears the elements for new post.
	postElements = [];
}

function OnLoad()
{
	fetch("posts.php")
		.then(res => res.json())
		.then(files => {
			for (const file of files) {
				const script = document.createElement("script");
				script.src = file;

				script.onload = () => {
					console.log("Loaded post script: " + script.src);	
				};

				document.head.appendChild(script);
				
				PutOnScreen();
			}
		});
}