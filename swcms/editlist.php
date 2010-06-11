<?php
// admin header
session_start();
require_once('lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: index.php");}
connect();

function insertRecords($records, $name, $init, $type) {
	if ($records) {
		echo "<h3>$type labels:</h3>\n<table>\n";
		$firsttime=true;
		$lastItem = count($records)-1;
		$index = 0;
		foreach ($records as $record) {
			if ($record[0]==$init) $selected="class='selected'"; else $selected='';
			echo "<tr><td class='label'>\n<a $selected href='".$_SERVER['PHP_SELF']."?name=$name&type=$type&init=".$record[0]."'>".displayValue($record[2])."</a></td>\n";
			echo "<td><a class='delete' href='".$_SERVER['PHP_SELF']."?name=$name&type=$type&delete=".$record[0]."'></a></td>";
			if ($firsttime || $index==$lastItem) {
				$firsttime = false;
				echo "<td>&nbsp;</td><td>&nbsp;</td>";
			} else {
				echo "<td><a class='up' href='".$_SERVER['PHP_SELF']."?name=$name&type=$type&moveup=".$index."'></a></td>";
				echo "<td><a class='down' href='".$_SERVER['PHP_SELF']."?name=$name&type=$type&movedown=".$index."'></a></td>";
			}
			echo  "</tr>\n";
			$index++;
		}
		echo "</table>\n";
	}
	echo "<br/>Create a new $type label:&nbsp;<a class='new' href='".$_SERVER['PHP_SELF']."?name=$name&new=1&type=$type'></a><br/><br/>\n";
}

// 2 types of data attached to the record: asset or value
// could be post in case of form submitting, or get in case of 'new', 'delete'...
$type = $_POST['type'];
$type = empty($type)?$_GET['type']:$type;

// save new value and redirect to the page to view the change
$save=$_POST['save'];
if ($save) {
	$name = $_POST['name'];
	$index=1;
	while ($value = $_POST['value'.$index++]) {
		$values[]=$value;
	}
	// save new value label
	if (strcmp($type,'value')==0) {
		StructuredFieldValueLabel::update($save, $values);
	}
	// save new asset label
	else {
		StructuredFieldAssetLabel::update($save, $values);
	}
	$message = "$type label ".$values[0]." updated in the list $name";
	// redirect if needed
	if ($_POST['submitAndEdit']) {
		header("location: editrecord.php?name=".$name);
	}
	$init = $save;
} else {
	$init = $_GET['init'];
	$name=$_GET['name'];
}

// get the unit id
$id=StructuredUnit::getUnitId($name);

// create a new value label record
$new = $_GET['new'];
if ($new) {
	// create new value label
	if (strcmp($type,'value')==0) {
		StructuredFieldValueLabel::create($id);
	}
	// create new asset label
	else {
		StructuredFieldAssetLabel::create($id);
	}
	$message="A new $type label has been created";
}

//delete record
$delete=$_GET['delete'];
if ($delete) {
	// delete value label
	if (strcmp($type,'value')==0) {
		StructuredFieldValueLabel::delete($delete);
	}
	// save new asset label
	else {
		StructuredFieldAssetLabel::delete($delete);
	}
	$message="$type label deleted";
}

// get the list of record labels
// retrieve asset labels and value labels
if ($id) {
	// retrieve value labels
	$valueLabels=StructuredFieldValueLabel::getSorted($id);
	// retrieve asset labels
	$assetLabels=StructuredFieldAssetLabel::getSorted($id);
}
// create unit
else {
	if (empty($name)) header('location:index.php');
	StructuredUnit::createUnit($name);
	$message="The list $name has been created";
}

//move rank up
$moveRankUp = $_GET['moveup'];
if ($moveRankUp) {
	// move value label up
	if (strcmp($type,'value')==0) {
		StructuredFieldValueLabel::switchRank($valueLabels[$moveRankUp][0], $valueLabels[$moveRankUp-1][0]);
		$valueLabels=StructuredFieldValueLabel::getSorted($id);
	}
	// move asset label up
	else {
		StructuredFieldAssetLabel::switchRank($assetLabels[$moveRankUp][0], $assetLabels[$moveRankUp-1][0]);
		$assetLabels=StructuredFieldAssetLabel::getSorted($id);
	}
}

//move rank down
$moveRankDown = $_GET['movedown'];
if ($moveRankDown) {
	// move value label down
	if (strcmp($type,'value')==0) {
		StructuredFieldValueLabel::switchRank($valueLabels[$moveRankUp][0], $valueLabels[$moveRankUp+1][0]);
		$valueLabels=StructuredFieldValueLabel::getSorted($id);
	}
	// move asset label down
	else {
		StructuredFieldAssetLabel::switchRank($assetLabels[$moveRankUp][0], $assetLabels[$moveRankUp+1][0]);
		$assetLabels=StructuredFieldAssetLabel::getSorted($id);
	}
}

//get default values for the textareas (either from the selecting record, or from the first record)
if ($init) {
	// init with value label
	if (strcmp($type,'value')==0) {
		$selectedRecord = StructuredFieldValueLabel::read($init);
		$recordStructure =  StructuredFieldValueLabel::getStructure();
	}
	// init with asset label
	else {
		$selectedRecord = StructuredFieldAssetLabel::read($init);
		$recordStructure =  StructuredFieldAssetLabel::getStructure();
	}
	$selectedRecordName = displayValue($selectedRecord[2]);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - edit list: <?php echo $name; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/roar.css" type="text/css" media="all" />
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
<div class="admin-content">
<?php
if ($name) {
	// nav
	echo "<div class='admin-nav'>\n";
	echo "<H2>Edit list definition: <strong>$name</strong> <a href='editrecord.php?name=$name'>(values)</a></H2>\n";
	insertRecords($valueLabels, $name, $init, 'value');
	insertRecords($assetLabels, $name, $init, 'asset');
	echo "</div>\n";
	// content
	echo "<div class='admin-content-edit'>\n";
	if ($selectedRecordName) {
		echo "<h2>Edit the following properties for '$selectedRecordName' and save</h2>\n";
		echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";
		// update label
		$index=1;
		foreach ($recordStructure as $field) {
			echo "<h3>".$field."</h3>\n";
			echo "<input type='text' name='value".$index++."' value='".$selectedRecord[$index]."' width=40></input><br/>\n";
		}
		echo "<input type='hidden' name='name' value='$name' />\n";
		echo "<input type='hidden' name='save' value='$init' />\n";
		echo "<input type='hidden' name='type' value='$type' />\n";
		echo "<br />\n<br />\n<input type='submit' value='Submit and edit values' name='submitAndEdit'/>\n<br />\n<input type='submit' value='Submit and continue' name='submitAndContinue' />";
		echo "</form>\n</div>\n";
	}
}
echo "</div>\n";
if ($message) {
?>
<script type="text/javascript"
	src="lib/mootools/mootools-1.2.1-core-jm.js"></script>
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
