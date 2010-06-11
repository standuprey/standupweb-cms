<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$id = $_POST["id"];
$id2 = $_POST["id2"];
$name = $_POST["name"];
$rank = $_POST["rank"];
if ($type) {
	switch ($type) {
		case 'createRecord':
			$rank = StructuredField::createRecord($id, $name, $rank);
			$result = "Record for unit with id $id at rank=$rank with name=$name has been created";
			break;
		case 'updateRecord':
			$rank = StructuredField::updateRecord($id, $name, $rank);
			$result = "Record $id has been updated with rank=$rank, and name=$name";
			break;
		case 'moveRankUp':
			StructuredField::moveRankUp($id, $rank);
			$result = "rank #$rank has been freed";
			break;
		case 'readRecord':
			$record = StructuredField::readRecord($id);
			if ($record) {
				$result = implode(",",$record);
			} else $result = "no record found";
			break;
		case 'getSortedRecords':
			$recordArray = StructuredField::getSortedRecords($id);
			if (!$recordArray) {
				$result="no record for the unit with id=$id";
			} else {
				foreach ($recordArray as $record) {
					$recordFields[]=implode (",", $record);
				}
				$result=implode("<br/>", $recordFields);
			}
			break;
		case 'switchRank':
			StructuredField::switchRank($id, $id2);
			$result="record at id=$id2 and id=$id have switched their ranks";
			break;
		case 'deleteRecord':
			StructuredField::deleteRecord($id, $rank);
			$result="record for unit with id=$id at rank=$rank have been deleted";
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit structured field test</title>
<link rel="shortcut icon" href="../images/favicon.ico" />

</head>
<body>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<table cellspacing=20>
	<tr>
		<td><strong>static_field</strong></td>
	</tr>
	<tr>
		<td>result</td>
		<td><?php echo($result);?></td>
	</tr>
	<tr>
		<td>id</td>
		<td><input type="text" name="id" width="11"></input></td>
	</tr>
	<tr>
		<td>id2 (for switch rank)</td>
		<td><input type="text" name="id2" width="11"></input></td>
	</tr>
	<tr>
		<td>name</td>
		<td><input type="text" name="name" width="20"></input></td>
	</tr>
	<tr>
		<td>rank</td>
		<td><input type="text" name="rank" width="11"></input></td>
	</tr>
	<tr>
		<td><INPUT TYPE=RADIO NAME="type" VALUE="createRecord" CHECKED>createRecord(id,
		name, rank)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="readRecord">readRecord(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="updateRecord">updateRecord(id,
		name, rank)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="deleteRecord">deleteRecord(id,
		rank)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="moveRankUp">moveRankUp(id, rank)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getSortedRecords">getSortedRecords(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="switchRank">switchRank(id, id2)</INPUT>
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitStaticFieldTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
