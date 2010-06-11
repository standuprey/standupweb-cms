<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$id = $_POST["id"];
$value = $_POST["value"];
if ($type) {
	switch ($type) {
		case 'createValue':
			StructuredFieldValue::createValue($id, $value, $name);
			$result="structured field value with name=$name created";
			break;
		case 'readValue':
			$value = StructuredFieldValue::readValue($id);
			$result="The value with id=$id is '".implode(', ', $value)."'";
			break;
		case 'getValues':
			$valueArray = StructuredFieldValue::getValues($id);
			if (!$valueArray) {
				$result="no record for the name=$name";
			} else {
				foreach ($valueArray as $v) {
					$vArray[]=implode (",", $v);
				}
				$result="getValues result:\n".implode("<br/>", $vArray);
			}
						break;
		case 'updateValue':
			StructuredFieldValue::updateValue($id, $value, $name);
			$result="structured field value with id=$id updated with value=$value and name=$name updated";
			break;
		case 'deleteValue':
			StructuredFieldValue::deleteValue($id, $name);
			$result="structured field value with name=$name deleted";
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit field value test</title>
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
		<td>name</td>
		<td><input type="text" name="name" width="20"></input></td>
	</tr>
	<tr>
		<td>value</td>
		<td><textarea name="value" rows="5" cols="20"></textarea></td>
	</tr>
	<tr>
		<td><INPUT TYPE=RADIO NAME="type" VALUE="createValue" CHECKED>createValue(id,
		value, name)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="readValue">readValue(id, name)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getValues">getValues(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="updateValue">updateValue(id,
		value, name)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="deleteValue">deleteValue(id,
		name)</INPUT></td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitStructuredFieldValueTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
