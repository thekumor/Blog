/* --------------------------------------------------------
*	#Section: Meta
* -------------------------------------------------------- */
SetTitle("Code blocks");
SetAuthor("The Kumor");
SetTime("2026-07-04 19:03");

/* --------------------------------------------------------
*	#Section: Content
* -------------------------------------------------------- */
Text("Today I added code blocks to this blog. I can now put code here with it being highlighted. Highlighting is handled by Highlight.js library. Mainly, I'll use it for <b>C, C++, Lua, HTML/CSS and PHP</b>. And as this blog gets bigger, I must write a module that'll allow me to create these posts in a more automated way. I'm also thinking of adding comments and likes/visit counter. For now, I'm happy with what I have.");
Text("Some example code:")
CodeBlock("cpp", "int main() {\n\tstd::cout << \"Hello World!\" << std::endl;\n\treturn 0;\n}");
Text("It's dark and with a custom border around it for now. This is unironically something I'll need the most and I'm happy that libraries like these exist so that I don't have to implement them myself. 🙂");