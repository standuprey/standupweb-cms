<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}
connect();

// process upload
$message="";
$save = $_POST['save'];
if ((count($_FILES) > 0) && $save)
{
	$target_encoding = "ISO-8859-1";
	$dest=$GLOBALS['DOCUMENT_ROOT']."/swcms/assets/";
	foreach ($_FILES as $arrfile) {
		if ($arrfile['name']) {
			$filename = iconv("UTF-8", $target_encoding,basename($arrfile['name']));
			$filename= str_replace('\\', '', $filename);
			$filename= str_replace('/', '', $filename);
			// delete  file if it exists
			while (file_exists($dest . $filename)) {
				unlink ($dest . $filename);
				$filename="new_".$filename;
			}
			// save the file
			if (!move_uploaded_file($arrfile['tmp_name'], $dest . $filename))
			$message = "Upload $filename failed.<br/>";
			else {
				$ext = substr(strrchr($filename, '.'), 1);
				StaticAsset::createStaticAsset($save, $filename, $ext);
				$location = ViewUrl::getViewUrl($save);
				if ($location) {
					header("location: view.php?location=".$location);
				} else {
					header("location: view.php");
				}
			}
		}
	}
}

//get default value for the textarea (either from selecting an item in the history, or from the current active record)
$name=empty($save)?$_GET['name']:$save;
if ($_GET['init']) {
	$row = StaticAsset::getStaticAssetById($_GET['init']);
} else {
	$row = StaticAsset::getStaticAssetByName($name);
}
if ($row) $initValue = restoreValue($row[2]);

//delete history entry
$delete=$_GET['delete'];
if ($delete) {
	StaticAsset::deleteStaticAsset($delete);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Edit static asset mode</title>
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
	echo "<div class='admin-nav'>\n";
	echo "<H2>Edit asset: <strong>$name</strong></H2>\n";
	$records=StaticAsset::getAllStaticAssetsByName($name);
	if ($records) {
		echo "<h3>history:</h3>\n<table>\n";
		$firsttime=true;
		foreach ($records as $StaticAsset) {
			echo "<tr><td class='label'>\n<a href='".$_SERVER['PHP_SELF']."?name=$name&init=".$StaticAsset[0]."'>".$StaticAsset[2]."</a></td>\n";
			if ($firsttime) {
				$firsttime = false;
				echo "<td>&nbsp;</td>";
			} else {
				echo "<td><a class='delete' href='".$_SERVER['PHP_SELF']."?name=$name&delete=".$StaticAsset[0]."'></a></td>";
			}
			echo  "</tr>\n";
		}
		echo "</table>\n";
	}
	?></div>
	<div class="admin-content-edit">
	<h3>Upload a new file for this asset</h3>
	<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
	<?php
	// update asset
	echo "<input type='file' name='file1'></input>";
	if ($initValue) {
		echo " - (current uploaded file:".$initValue.")";
	}
	?>
	<input type='hidden' name='save' value='<?php echo $name;?>' />
	<br />
	<br />
	<input type="submit" value="Submit and view" />
	</form>
	</div>
<?php } ?>
</div>
<?php if ($message) {?>
<script type="text/javascript"
	src="lib/mootools/mootools-1.2.1-core-jm.js"></script>
<script type="text/javascript" src="js/roar.js"></script>
<script language="JavaScript">
window.addEvent('load', function() {
 
	var roar = new Roar({
		position: 'lowerLeft',
		duration: 3000
	});
 
	roar.alert('<?php echo $message; ?>', 'keep editing!');
});
</script>
<?php } ?>
</BODY>
</HTML>

