<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$id = $_POST["id"];
$id_switch = $_POST["id_switch"];
$values[] = $_POST["value1"];
$values[] = $_POST["value2"];
if ($type) {
	switch ($type) {
		case 'create':
			StructuredFieldValueLabel::create($id);
			$result="structured field value label with name=$name created";
			break;
		case 'update':
			StructuredFieldValueLabel::update($id, $values);
			$result="structured field value label with name=$name updated";
			break;
		case 'read':
			$value = StructuredFieldValueLabel::read($id);
			$result="The value label with id=$id is '".implode(', ', $value)."'";
			break;
		case 'delete':
			StructuredFieldValueLabel::delete($id);
			$result="structured field value label with id=$id deleted";
			break;
		case 'getsorted':
			$valueArray = StructuredFieldValueLabel::getSorted($id);
			if (!$valueArray) {
				$result="no unit for the id=$id";
			} else {
				foreach ($valueArray as $v) {
					$vArray[]=implode (",", $v);
				}
				$result="getSorted result:\n".implode("<br/>", $vArray);
			}
			break;
		case 'switchrank':
			StructuredFieldValueLabel::switchRank($id, $id_switch);
			$result="structured field value lael $id and $id_switch have switched their ranks";
			break;
		case 'getstructure':
			$result = StructuredFieldValueLabel::getStructure();
			$result="structured of structured_field_value_label: ".implode(', ', $result);
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - structured field value label test</title>
<link rel="shortcut icon" href="../images/favicon.ico" />

</head>
<body>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<table cellspacing=20>
	<tr>
		<td><strong>see table structured_field_value_label in mySQL</strong></td>
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
		<td>id_switch</td>
		<td><input type="text" name="id_switch" width="11"></input></td>
	</tr>
	<tr>
		<td>name</td>
		<td><input type="text" name="name" width="20"></input></td>
	</tr>
	<tr>
		<td>value1 (label)</td>
		<td><textarea name="value1" rows="5" cols="20"></textarea></td>
	</tr>
	<tr>
		<td>value2 (type)</td>
		<td><textarea name="value2" rows="5" cols="20"></textarea></td>
	</tr>
	<tr>
		<td><INPUT TYPE=RADIO NAME="type" VALUE="create" CHECKED>create(unitId)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="read">read(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="update">update(id, values)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="delete">delete(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getsorted">getSorted(unitId)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="switchrank">switchRank(id, id_switch)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getstructure">getStructure()</INPUT></td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitStructuredFieldValueLabelTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
