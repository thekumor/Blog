/* --------------------------------------------------------
*	#Section: Meta
* -------------------------------------------------------- */
SetTitle("GitHub redirect");
SetAuthor("The Kumor");
SetTime("2026-07-03 9:35");

/* --------------------------------------------------------
*	#Section: Content
* -------------------------------------------------------- */
Text("I made a fancy little redirect (using Apache2) to GitHub where I store projects.");
Text("Whenever somebody writes either:");
List("thekumor.com/g/Minesweeper or,", "thekumor.com/git/Minesweeper");
Text("It's going to redirect them to github.com/thekumor/Minesweeper. It works for all projects, even the ones that don't exist.");
Text("It effectively shortens time needed to get there by 3 to 5 characters.");
CodeBlock("lua", "print('Hello, World!')");