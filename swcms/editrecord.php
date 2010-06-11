<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}
connect();

// save user type
$isAdmin = swIsAdmin();

// process upload
$message="";
if(count($_FILES) > 0)
{
	$target_encoding = "ISO-8859-1";
	$dest=$GLOBALS['DOCUMENT_ROOT']."/swcms/assets/";
	foreach ($_FILES as $arrfile) {
		if ($arrfile['name']) {
			// get the filename
			$filename = iconv("UTF-8", $target_encoding,basename($arrfile['name']));
			$filename= str_replace('\\', '', $filename);
			$filename= str_replace('/', '', $filename);
			// delete file if it exists
			while (file_exists($dest . $filename)) {
				unlink ($dest . $filename);
				// to avoid server cache problem we postfix the filename
				$filename="new_".$filename;
			}
			// store in array for display in the page
			$ext[] = substr(strrchr($filename, '.'), 1);
			$storedfile[] = $filename;
			// save the file
			if (!move_uploaded_file($arrfile['tmp_name'], $dest . $filename))
			$message .= "Upload $filename failed.<br/>";
			else
			$message .= "Upload $filename successful.<br/>";
		}
	}
}
// save new value and redirect to the page to view the change
$save = $_POST['save'];
if ($save) {
	// save values
	$index=0;
	$textArray = StructuredFieldValue::getValues($save);
	if ($textArray) foreach ($textArray as $textField) {
		StructuredFieldValue::updateValue($textField[0], $_POST['value'.$index++], $textField[2]);
	}
	// save assets
	$index=0;
	$assetArray = StructuredFieldAsset::getAssets($save);
	if ($assetArray) foreach ($assetArray as $asset) {
		if ($storedfile[$index]) {
			$asset[2]=$storedfile[$index];
			$asset[3]=$ext[$index];
		}
		StructuredFieldAsset::updateAsset($asset[0], $asset[2], $_POST['asset'.$index], $asset[3]);
		$index++;
	}
	// redirect if needed
	if ($_POST['submitAndView']) {
		$location = ViewUrl::getViewUrl($name);
		if ($location) {
			header("location: view.php?location=".$location);
		} else {
			header("location: view.php");
		}
	}
	$init = $save;
	$name = $_POST['name'];
	$message .= "The record has been updated";
} else {
	$init = $_GET['init'];
	$name=$_GET['name'];
}

// create a new record
$new = $_GET['new'];
if ($new) {
	$unit=StructuredUnit::getUnitByName($name);
	$init=StructuredField::createRecord($unit[0], $unit[3], 0);
	$message="A new record has been created";
}

//delete record
$delete=$_GET['delete'];
if ($delete) {
	StructuredField::deleteRecord($delete);
	$message="The record has been deleted";
}

//get the list of records
if ($name) {
	$id=StructuredUnit::getUnitId($name);
	if ($id) $records=StructuredField::getSortedRecords($id, $isAdmin);
	else header('location:editlist.php?name='.$name);
}

//move rank up
$moveRankUp = $_GET['moveup'];
if ($moveRankUp) {
	StructuredField::switchRank($records[$moveRankUp][0], $records[$moveRankUp-1][0]);
	$records=StructuredField::getSortedRecords($id, $isAdmin);
}

//move rank down
$moveRankDown = $_GET['movedown'];
if ($moveRankDown) {
	StructuredField::switchRank($records[$moveRankDown][0], $records[1+$moveRankDown][0]);
	$records=StructuredField::getSortedRecords($id, $isAdmin);
}

// rename/lock/unlock record
if ($save) {
	$recordName = $_POST['recordName'];
	$selectedRecord = StructuredField::readRecord($init);
	if ($isAdmin) {
		$lockVal=$_POST['lock'];
	} else {
		$lockVal = $selectedRecord[4];
	}
	StructuredField::updateRecord($selectedRecord[0], $recordName, $selectedRecord[2], $lockVal);
	$records=StructuredField::getSortedRecords($id, $isAdmin);
}

//get default values for the textareas (either from the selecting record, or from the first record)
if ($init) {
	$selectedRecord = StructuredField::readRecord($init);
} else {
	$selectedRecord=$records[0];
	$init = $selectedRecord[0];
}
if ($init) {
	$textArray = StructuredFieldValue::getValues($init);
	$assetArray = StructuredFieldAsset::getAssets($init);
	$selectedRecordName = displayValue($selectedRecord[3]);
	// don't show locked record for non-admin users or there is no record name in the URL
	$lock = $selectedRecord[4];
	if (empty($name) || ($lock==1 && !$isAdmin)) header('location:index.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - Edit <?php echo $name; ?> mode</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/roar.css" type="text/css" media="all" />
<link rel="shortcut icon" href="images/favicon.ico" />

</head>
<body>
<div class="header">
<div id='options'>
<div id='setting'><a href="editsetting.php"></a></div>
<div id='logoff'><a href="index.php?logoff=1"></a></div>
</div>
<ul>
	<li><a href="view.php">view</a></li>
	<li><a href="edit.php" class='selected'>edit</a></li>
</ul>
</div>
<div class="hline"></div>
<div class="admin-content"><?php
// display right content panel
echo "<div class='admin-nav'>\n";
echo "<H2>Edit list: <strong>$name</strong> <a href='editlist.php?name=$name'>(list definition)</a></H2>";
if ($records) {
	echo "<h3>records:</h3>\n<table>\n";
	$firsttime=true;
	$lastItem = count($records)-1;
	$index = 0;
	foreach ($records as $record) {
		if ($record[0]==$init) $selected="class='selected'"; else $selected='';
		echo "<tr><td class='label'>\n<a $selected href='".$_SERVER['PHP_SELF']."?name=$name&init=".$record[0]."'>".displayValue($record[3])."</a></td>\n";
		echo "<td><a class='delete' href='".$_SERVER['PHP_SELF']."?name=$name&delete=".$record[0]."'></a></td>";
		if ($firsttime || $index==$lastItem) {
			$firsttime = false;
			echo "<td>&nbsp;</td><td>&nbsp;</td>";
		} else {
			echo "<td><a class='up' href='".$_SERVER['PHP_SELF']."?name=$name&moveup=".$index."'></a></td>";
			echo "<td><a class='down' href='".$_SERVER['PHP_SELF']."?name=$name&movedown=".$index."'></a></td>";
		}
		echo  "</tr>\n";
		$index++;
	}
	echo "</table>\n";
}
echo "<br/><br/>Create a new record:&nbsp;<a class='new' href='".$_SERVER['PHP_SELF']."?name=$name&new=1'></a>";
echo "</div>\n";

// display left content panel
echo "<div class='admin-content-edit'>\n";
if ($selectedRecordName) {
	echo "<h2>Edit the following properties for '$selectedRecordName' and save</h2>\n";
	echo "<form method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
	// update values
	$index=0;
	if ($textArray) foreach ($textArray as $textField) {
		echo "<h3>".$textField[2]."</h3>\n";
		switch (StructuredFieldValue::getType($textField[2])) {
			case 'text':
				echo "<input type='text' name='value".$index++."' value='".restoreValue($textField[3])."' width=40></input><br/>\n";
				break;
			case 'textarea':
				echo "<textarea name='value".$index++."' rows='15' cols='70'>".restoreValue($textField[3])."</textarea>";
				break;
		}
	}
	// update assets
	$index=0;
	if ($assetArray) foreach ($assetArray as $asset) {
		echo "<h3>".$asset[5]."</h3>\n";
		echo "enter the title here<br/><input type='text' name='asset$index' value='".displayValue($asset[1])."' width=40></input><br/>\n";
		echo "<input type='file' name='file$index'></input>";
		if ($asset[2]) {
			echo " - (current uploaded file:".$asset[2].")";
		}
		echo "<br/>\n";
		$index++;
	}
	echo "<br/>\n";
	if ($isAdmin) {
		if ($lock) $lock=" CHECKED";
		echo "<INPUT TYPE=CHECKBOX NAME='lock' VALUE='1'$lock> Cannot be edited by non-admin users</INPUT>";
	}
	echo "<input type='hidden' name='name' value='$name' />";
	echo "<input type='hidden' name='save' value='".$selectedRecord[0]."' />\n";
	echo "<h3>update the record name if needed:</h3>\n";
	echo "<input type='text' name='recordName' value='$selectedRecordName' width=20></input>\n<br /><br />\n";
	echo "<input type='submit' value='Submit and view' name='submitAndView' />\n<br />\n";
	echo "<input type='submit' value='Submit and continue' name='submitAndContinue' />\n</form>\n";
} ?></div>
</div>
<?php if ($message) {?>
<script type="text/javascript" src="lib/mootools/mootools-1.2.1-core-jm.js"></script>
<script type="text/javascript" src="js/roar.js"></script>
<script language="JavaScript">
window.addEvent('load', function() {
 
	var roar = new Roar({
		position: 'lowerRight',
		duration: 3000
	});
 
	roar.alert('<?php echo $message; ?>', 'keep editing!');
});
</script>
<?php } ?>
</BODY>
</HTML>
