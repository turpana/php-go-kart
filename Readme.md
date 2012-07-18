# PHP Go Kart!

Hop on and come for a short ride! PHP Go Kart will not take you far,
but it will let you get moving quick (at least that's the purpose).
Basically, you put in files in the 'app' folder and they get picked
based on the filename. The reason I put this together was to quickly
prototype javascript code and reuse html snippets. I use a naming
convention _"inspired"_ by drupal's theming engine to keep things
organized.

## How It Works

Start writing javascript files in the app folder. For example,
write a file called go.js and then go to index.php?q=go to
see it in action. Now copy the basetemplate body.php file to
the app/templates directory, but name it body--go.php. Make
you edits. Your markup should fill up the body of the page now.
You can override the head template also in the same way. You
can also override the vars template to provide some more
variables for the templates.
