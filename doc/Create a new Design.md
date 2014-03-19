# How to create a new Design in PCMS
This tutorial will show you how to add a custom Design to your PCMS installation.

## Prerequisites
You need to have a working installation of PCMS and you need to know how to write HTML (and CSS if you don't want a design like fefe ;D)

## First step
The design is contained in a folder inside the designs folder. The first step is to create that folder, with a name that should be unique, maybe prepend it with your username.

## Fill the folder
### The information file
The CMS needs to know some things about the Design. For example which file should be used as error file and which should be used as main design file, and so on.

```php
<?php
class YOUR_PLUGIN_NAME_info implements DesignInfo
{
	public function getTemplateFile()
	{
		return 'main.tpl.php';
	}
	
	public function getPluginBoxes()
	{
		return array('boxNameOne', 'boxNameTwo');
	}
	
	public function getErrorTemplateFile()
	{
		return 'error.tpl.php';
	}
}
```

Now you can change some values, e.g. the template file or the box names (i'll explain that later)

### The main template file
Create a file named like the value in the getTemplateFile() function. Template files end per convention with .tpl.php, though only the .php is required.
As you can see in the default templates, there are a few placeholders for the CMS to fill. They all look like this:

```php
<?=$tpl_PLACEHOLDER_NAME?>
```

You don't need to use any of these, but then the CMS kind of looses it's point. Don't use placeholders not in this list, because they'll generate PHP notices.
Following placeholders are defined:

* root

The subdir the cms is installed in. Useful for referencing css, script or image files.

* title

A generated title for use in the title-Tag. Also useful for a breadcrumb.

* css

A list of CSS files to be included by the modules. This PHP snipped is normally enough to include the files:
```php
<?php foreach($tpl_css as $css) echo $css;?>
```

* meta

Module generated meta tags. Same as the CSS files, just put the out with:
```php
<?php foreach ($tpl_meta as $meta) echo $meta;?>
```

* header

The page title that usually goes into the header

* menu

All menu links. They are not preformatted to allow customization. You need a bit PHP:
```php
<ul>
	<?php 
		foreach ($tpl_menu as $entry)
		{
	?>
			<li><a href='<?=$entry->link?>'><?=$entry->text?></a></li>
	<?php 
		}
	?>
</ul>
```
This PHP-Code generates a unordered List. The foreach loops through all Menu entries. You can access the current entry with $entry. $entry->link is the current link destination, $entry->text the link text.

* content

The main content of the page

* (box name)

The content assigned to the box

**Remeber: All names must be prepended by $tpl_**

### The error file

Following placeholders are allowed on error pages:

* pagetitle
* root
* meta
* error_code
* error_description

**Remeber: All names must be prepended by $tpl_**

### The boxes
Boxes are places for content plugins to write their content to. Usual places for boxes are on the sidebar, on top of the main content, below the content, etc.

You write the box names in the information file. Then you can use these names as placeholders in your main file.

### Referencing external resources
You can include external resources in your main or error file such as style sheets like this:
```php
<link rel="stylesheet" href="<?=$tpl_root?>designs/YOUR_DESIGN_NAME/the/path/to/the/css/file.css">
```
The same applies to scripts and images. Referencing images in your css file is easy: just specify a relative path.

```
YOUR_DESIGN_NAME
	- image
		- img.png
	- css
		- style.css

```

You now want to use img.png in your css file. Do it like this. You have now avoided specifying the directory the CMS is installed in AND the directory your design is installed in. This makes it portable.

```css
.selector
{
	background-image: url('../image/img.png');
}
```

## Activate your design
Currently there is no way to change the design from the backend.
The value you need to change is in the database, the table prefix_Config with the ID "activeDesign". Just change the value to your folder's name. 