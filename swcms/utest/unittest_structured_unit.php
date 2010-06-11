<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$id = $_POST["id"];
$random = $_POST["random"];
if ($type) {
	switch ($type) {
		case 'createUnit':
			StructuredUnit::createUnit($name);
			$result="structured unit with name=$name created";
			break;
		case 'getUnitId':
			$id = StructuredUnit::getUnitId($name);
			$result="The id for the unit $name is $id";
			break;
		case 'getUnit':
			$unit = StructuredUnit::getUnit($name);
			$result="unit: ".implode(', ', $unit);
			break;
		case 'getUnitRandom':
			$random = StructuredUnit::getUnitRandom($name);
			$result="The random for the unit $name is $random";
			break;
		case 'updateUnit':
			StructuredUnit::updateUnit($id, $name, $random);
			$result="structured unit with name=$name, id=$id, random=$random updated";
			break;
		case 'deleteUnit':
			StructuredUnit::deleteUnit($name);
			$result="structured unit with name=$name deleted";
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit structured unit test</title>
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
		<td>random</td>
		<td><input type="text" name="random" width="2"></input></td>
	</tr>
	<tr><td>
		<INPUT TYPE=RADIO NAME="type" VALUE="createUnit" CHECKED>createUnit(name, random=0)</INPUT><br/>
		<INPUT TYPE=RADIO NAME="type" VALUE="getUnitId">getUnitId(name)</INPUT><br/>
		<INPUT TYPE=RADIO NAME="type" VALUE="getUnit">getUnit(name)</INPUT><br/>
		<INPUT TYPE=RADIO NAME="type" VALUE="getUnitRandom">getUnitRandom(name)</INPUT><br/>
		<INPUT TYPE=RADIO NAME="type" VALUE="updateUnit">updateUnit(id, name,random)</INPUT><br/>
		<INPUT TYPE=RADIO NAME="type" VALUE="deleteUnit">deleteUnit(name)</INPUT>
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitStructuredUnitTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
