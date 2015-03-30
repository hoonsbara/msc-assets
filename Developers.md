## Security Practices ##
There are a number of good practices we'll follow to ensure proper security.

### Global Variables ###
This should go without saying, but `register_globals` will not be available. Don't look for anything in `$GLOBALS`, and only use use the `global` keyword with class variables (`$debug`, `$db`, etc.) or for referencing the system configuration (`$config`). If you need to pass data around a lot, do it with function arguments or (even better, when appropriate) private variables within a class.

### Plaintext Passwords ###
This is a no-no. Do we even need to say this? All passwords should be stored as one-way hashes after being salted. We even like to use a bit of paprika every now and then. **No passwords should ever be stored in plain text.** In fact, at no point should the application store any passwords whatsoever.

### Safe Database Queries ###
SQL injection plagues many sites, and it's really pretty easy to avoid. We have a dedicated function (`db_prepare()`) that prepares a string for MySQL queries. Any time you're inserting foreign data, be it user input or even a value from a previous query, run the string though that function before interacting with the database.

### Server Side Validation ###
Client-side (Javascript) validation is an excellent tool for making form validation intuitive and user-friendly. However, it should not be perceived as a security measure. **Always do server-side validation of user input.**

### Unauthorized Code Execution ###
Each server-side child-level (included) file should check for the `_MSC` definition to ensure that only an authorized entry point is executing the file. And, accordingly, any entry point needs to define `_MSC`.

`defined('_MSC') or die('Unauthorized.');`


---


## Code Formatting ##
People's preferences for code format are pretty much like armpits. Most people have more than one, and most of those stink. Nonetheless, the value of having a consistent look and feel for code is essential for group-developed software. So, here are our standards...

Before we get into languages, let's establish the common denominator. Indents should be done with tabs rather than spaces. Spaces look more consistent, yes, but most IDEs these days are configurable so you can define how tabs look. I think most people would agree that 8-space tabs are a bit much, but if you're still using Notepad to code... At least try [Notepad++](http://notepad-plus.sourceforge.net/).

On to the languages themselves. Each one will address some ground rules, then illustrate an example, since that's the easiest way to communicate these kinds of standards.


### PHP ###
Functions and variables should be written in lowercase, with clear and concise English words (or recognized standards such as 'db'). If word separation is necessary, underscores are acceptable, but these should be avoided.

When appropriate, use classes. And within classes, precede names of private functions and variables with an underscore.

And lastly, be sure to include comments and tags according to the [PHPDoc Standards](http://www.phpdoc.org/tutorial.php) so we can all read/understand your code easily. IDEs such as Eclipse assist in this process greatly.

On to the examples.

```
<?php // note the use of full tags rather than short_tags

/**
 * The kids class contains some of the more common functions children perform
 * 
 **/
class kids
{ 
	/**
	 * contains whether the kid has friends present
	 * @var bool
	 */
	public $friends;

	/**
	 * contains the current parental annoyance factor
	 * @var array 
	 */
	private $_annoyance;

	/**
	 * constructor - creates all the necessary variables
	 * @return void
	 */
	function kids()
	{
		global $parents;
		if ($parent->tired)
		{
			$this->_annoyance = 1;
		}
		else
		{
			$this->_annoyance = 0;
		}
	}
}

$kids = new kids();

?>
```


### JavaScript ###
Lay out your JavaScript in the same manner as PHP. The only exception is that production JavaScript on release tags should be [YUI Compressed](http://refresh-sf.com/yui/).

Another difference is that the JavaScript world has embraced camelCase (as is made apparent even by the language name), which provides a convenient visual distinguishment from PHP. So, embrace it: use camelCase function and variable names.

### CSS ###
Inline CSS should be avoided wherever possible. When required, make sure to end each declaration with a semicolon (even the final one), and separate your declarations with a space.

Element classes should remain lowercase, but element ids should be capitalized with Title Case as if it were a proper noun. It is, after all, a unique name.

Otherwise, CSS should be formatted with value separation, indents, and line breaks.
```
.someclass {
	text-align: center;
}
#SomeID {
	background: url(foo.png) no-repeat center center;
}
```


### HTML ###
HTML must validate as XHTML 1.0 Strict. The most important thing to keep in mind about XHTML is that, as XML, all tags must close and must close in the exact inverse order of their opening. Of course, some elements (`<br>`) do not have separate closure tags, so you must self-close such elements (`<br/>`).

You'll also need to be mindful of block-vs-inline elements (don't try to put a div inside a span), but as long as you're using elements as they're designed, you shouldn't run into any issues.

On that note, try to keep block-level elements on a separate line. This makes the HTML _read_ more like it would in a browser. Child elements should be indented accordingly.

Any attributes should be defined using single-tick quotes rather than double-tick quotes. And, lastly, use `<strong>` and `<em>` rather than `<b>` and `<i>`.

```
<div class='hello'>
	<a href='#foo'><strong>That</strong> was a big bold word, whereas <em>this</a> ain't so much...
</div>
```


### Special Note: HTML/PHP ###
On a bit of a merging between languages note, when echoing HTML from PHP, be sure to encase the HTML with double-tick quotes (") so that you do not have to escape single-tick within HTML for attributes. Note that escaping double-quotes is still necessary in some JavaScript cases:
```
<?php

echo "<input type='text' name='foo' id='foo' onblur='validate(\"foo\");'/>";

?>
```

It's also appropriate that you keep HTML legible up within PHP as if it stood on its own. This sometimes means concatenating separate lines of code with newline separators (\n).
```
<php

echo "<h2>Separate Lines</h2>\n".
	"If we break up HTML within PHP like we'd do it if it weren't in PHP (even\n".
	"for the sake of word wrapping), it can help readability for everyone.";

?>
```