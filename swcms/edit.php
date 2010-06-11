<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}

if (empty($_SESSION['edit']))
$_SESSION['edit']=$GLOBALS['DOCUMENT_ROOT'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Edit mode</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="shortcut icon" href="images/favicon.ico" />

</head>
<body>
<div class="header">
<div id='options'>
	<div id='setting'>
		<a href="editsetting.php"></a>
	</div>
	<div id='logoff'>
		<a href="index.php?logoff=1"></a>
	</div>
</div>
<ul>
	<li><a href="view.php">view</a></li>
	<li><a href="edit.php" class='selected'>edit</a></li>
</ul>

</div>
<div class="hline"></div>
<div>
<IFRAME SRC="../index.php" width=100% height=700>
If you can see this, your browser doesn't understand IFRAME.<br/><br/>
<A target="_blank" HREF="../index.php">click here</A> to view the site in
another window. </IFRAME></div>
</div>
</BODY>
</HTML>

