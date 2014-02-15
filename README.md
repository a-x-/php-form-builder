# PHP JSON HTML5 Json2Form generator
This is a small PHP class that makes it easy to build and output forms as HTML5. Forms are tedious and can be difficult to build just right. Also, there are so many different option possible that it's easy to forget what you can do with them. 

**Forked from [joshcanhelp/php-form-builder](https://github.com/joshcanhelp/php-form-builder).**
 [ I ](https://github.com/a-x-) want make JSON based server-side HTML5 form generator.

**Documentation may be obsolete**

**Also, There is [Pear simple HTML form generator](http://pear.php.net/manual/en/package.html.html-form.intro.php)**

## Working with the form builder

The process for creating a form is simple:

1) Instantiate the class
2) Change any form attributes, if desired
3) Add inputs, in order you want to see them
4) Output the form

Let's walk through these one by one

### 1) Instantiate the class

### 2) Change any form attributes, if desired

### 3) Add inputs, in order you want to see them

Inputs can be added one at a time or as a group. Either way, the order they are added is the order in which they'll show up.

Add fields using their label (in human-readable form), an array of settings, and a name/id slug, if needed.

```php
$new_form->add_input('I am a little field', 'little_field', array())
```

* Argument 1: A human-readable label that is parsed and turned into the name and id, if these options aren't explicitly set.
 If you use a simple label like "email" here, make sure to set a more specific name in argument 2. Set up **label**
* Argument 2: A string, valid for an HTML attribute, used as the name and id.
 This lets you set specific submission names that differ from the field label. Set up **id** and **name**
* Argument 3: An array of settings that are merged with the default settings to control the display and type of field.
 See below for default and potential settings here.

Default and possible settings for field inputs (argument 3):

####<code>type</code>

* Default is "text"
* Can be set to anything and, unless mentioned below, is used as the "type" for an input field
* Setting this to "textarea" will build a text area field
* Using "select" in combination with the "options" argument will create a dropdown or multiline list.

####<code>value</code>

* Default is empty
* If a $_REQUEST index is found with the same name, the value is replaced with that value found

####<code>placeholder</code>

* Default is empty
* HTML5 attribute to show text that disappears on field focus

####<code>class</code>

* Default is an empty string
* Add multiple classes using an space splitted string of valid class names

####<code>options</code>

* Default is an empty array
* The options array is used for fields of type "select," "checkbox," and "radio." For other inputs, this argument is ignored
* The array should be an associative array with the value as the key and the label name as the value
 like <code>array('value' => 'Name to show')</code>
* The label name for the field is used as a header for the multiple options (set "add_label" to "false" to suppress)

####<code>range</code>
<code>["min"=>000, "max"=>000, "step"=>""]</code>

* Default are empty
* Used for types "range" and "number"

####<code>autofocus</code>

* Default is "false"
* A "true" value simply adds the HTML5 "autofocus" attribute

####<code>checked</code>

* Default is "false"
* A "true" value simply adds the "checked" attribute

####<code>required</code>

* Default is "false"
* A "true" value simply adds the HTML5 "required" attribute

### 4) Output the form

One quick statement outputs the form as HTML:

```php
$new_form->build_form();
```

## Roadmap
### @joshcanhelp's TODOs
There are a few things that I'd like to correct here and a few features to add. In order of priority:

* ~~Validation for adding classes and ids~~ [done]
* Add fieldsets and legends [may be...]
* Function to change the default field settings
* Add ability to set selected and checked for select and multiple checkboxes [what it's?]
* More strict name generation [to check]
* ~~Ability to add HTML within the form~~ [canceled]
* ~~`html_before` and `html_after` for form attributes~~ [canceled]

### New items
* Add JSON adapter
* Clean up build_form()
* Take out html from php code into external templates
