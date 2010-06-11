<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}
connect();

// save new value and redirect to the page to view the change
$save = $_POST['save'];
if ($save) {
	Setting::setSetting($save, $_POST['value']);
}

//get default value for the textarea (either from selecting an item in the history, or from the current active record)
$id=$_GET['id'];
$row = Setting::getSetting($id);
if ($row) {
	$initValue = restoreValue($row[2]);
	$initName = restoreValue($row[1]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Edit settings mode</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="shortcut icon" href="images/favicon.ico" />

</head>
<body>
<div class="header">
<div id='options'>
	<div id='setting'>
		<a class='selected' href="editsetting.php"></a>
	</div>
	<div id='logoff'>
		<a href="index.php?logoff=1"></a>
	</div>
</div>
<ul>
	<li><a href="view.php">view</a></li>
	<li><a href="edit.php">edit</a></li>
</ul>

</div>
<div class="hline"></div>
<div class="admin-content">
<div class="admin-nav"><?php 
$records=Setting::getSettings();
if ($records) {
	echo "<h3>available settings:</h3>\n<table>\n";
	$firsttime=true;
	foreach ($records as $setting) {
		echo "<tr><td class='label'>\n<a href='".$_SERVER['PHP_SELF']."?id=".$setting[0]."'>".$setting[1]."</a></td>\n</tr>\n";
	}
	echo "</table>\n";
}
?></div>
<div class="admin-content-edit">
<?php if ($id) { ?>
<h2><?php echo $initName;?></h2>
<h3>Enter/update the value for this setting</h3>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<textarea name="value" rows="15" cols="70"><?php echo $initValue;?></textarea>
<input type='hidden' name='save' value='<?php echo $id;?>' />
<br />
<input type="submit" value="Save" />
</form>
<?php } ?>
</div>
</div>
</BODY>
</HTML>

