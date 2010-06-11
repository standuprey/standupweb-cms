<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$value = $_POST["value"];
$id = $_POST["id"];
if ($type) {
	switch ($type) {
		case 'getStaticFieldValueByName':
			$result="getStaticFieldValue result:".StaticField::getStaticFieldValueByName($name);
			break;
		case 'getStaticFieldByName':
			$result="getStaticField result:".implode(",", StaticField::getStaticFieldByName($name));
			break;
		case 'getStaticFieldById':
			$result="getStaticFieldById result:".implode(",", StaticField::getStaticFieldById($id));
			break;
		case 'getAllStaticFieldsByName':
			$staticFields=StaticField::getAllStaticFieldsByName($name);
			if (!$staticFields) {
				$result="no record for the name=$name";
			} else {
				foreach ($staticFields as $sf) {
					$sfList[]=implode (",", $sf);
				}
				$result="getAllStaticFieldsByName result:\n".implode("<br/>", $sfList);
			}
			break;
		case 'createStaticField':
			StaticField::createStaticField($name, $value);
			$result="static field created: name=$name, value=$value";
			break;
		case 'deleteStaticField':
			if (StaticField::deleteStaticField($id)) {
				$result="static field deleted: id=$id";
			} else  {
				$result="cannot delete field with id=$id because it is the current static field for the name $name";
			}
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit static field test</title>
<link rel="shortcut icon" href="images/favicon.ico" />

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
		<td>
		<INPUT TYPE=RADIO NAME="type" VALUE="getStaticFieldValueByName">getStaticFieldValueByName</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getStaticFieldByName">getStaticFieldByName</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getStaticFieldById">getStaticFieldById</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getAllStaticFieldsByName">getAllStaticFieldsByName</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="createStaticField" CHECKED>createStaticField</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="deleteStaticField">deleteStaticField</INPUT><br />
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitStaticFieldTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
