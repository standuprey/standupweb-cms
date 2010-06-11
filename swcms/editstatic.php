<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}
connect();

// save new value and redirect to the page to view the change
$save = $_POST['save'];
if ($save) {
	StaticField::createStaticField($save, $_POST['value']);
	$location = ViewUrl::getViewUrl($save);
	if ($location) {
		header("location: view.php?location=".$location);
	} else {
		header("location: view.php");
	}
}

//get default value for the textarea (either from selecting an item in the history, or from the current active record)
$name=$_GET['name'];
if ($_GET['init']) {
	$row = StaticField::getStaticFieldById($_GET['init']);
} else {
	$row = StaticField::getStaticFieldByName($name);
}
if ($row) $initValue = restoreValue($row[2]);

//delete history entry
$delete=$_GET['delete'];
if ($delete) {
	StaticField::deleteStaticField($delete);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Edit static field mode</title>
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
<div class="admin-content"><?php
if ($name) {
	?>
<div class="admin-nav"><?php 
echo "<H2>Edit field: <strong>$name</strong></H2>";
$records=StaticField::getAllStaticFieldsByName($name);
if ($records) {
	echo "<h3>history:</h3>\n<table>\n";
	$firsttime=true;
	foreach ($records as $staticField) {
		echo "<tr><td class='label'>\n<a href='".$_SERVER['PHP_SELF']."?name=$name&init=".$staticField[0]."'>".$staticField[3]."</a></td>\n";
		if ($firsttime) {
			$firsttime = false;
			echo "<td>&nbsp;</td>";
		} else {
			echo "<td><a class='delete' href='".$_SERVER['PHP_SELF']."?name=$name&delete=".$staticField[0]."'></a></td>";
		}
		echo  "</tr>\n";
	}
	echo "</table>\n";
}
?></div>
<div class="admin-content-edit">
<h3>Enter/update the value for this field</h3>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<textarea name="value" rows="15" cols="70"><?php echo $initValue;?></textarea>
<input type='hidden' name='save' value='<?php echo $name;?>' />
<br />
<input type="submit" value="Submit and view" />
</form>
</div>
<?php } ?></div>
</BODY>
</HTML>

