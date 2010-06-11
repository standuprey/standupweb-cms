it is standupweb CMS

1/ What can it do, how does it work?

Simple PHP CMS that can handle assets, text, and lists
Simply add some PHP snippets in your HTML to make it work
mySQL DB needed

Go to http://standupweb.net/cms to see the live demo

2/ How to install it?

- Checkout and copy the files on your server
- import doc/standupweb_cms_tables_and_demo.sql into a database named standupweb-cms
- Check DB configuration in swcms\lib\php\DOLib.php

3/ PHP snippets:

- include pictures: StaticAsset::includePicture('name')
- include text: StaticField::includeText('name')
- include lists: StructuredField::printField('listOfContents', "<li>\n@@1\n</li>\n")
	printField is parsing the string and identifies:
	   @@#: value number #
	   @@rank: include field rank
	   @@a#: include asset number #
	   @@t#: include asset title for asset number #		
	   @@#: include value number #