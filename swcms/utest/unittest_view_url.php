<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$id = $_POST["id"];
$url = $_POST["url"];
if ($type) {
	switch ($type) {
		case 'getViewUrl':
			$result=ViewUrl::getViewUrl($name);
			break;
		case 'setViewUrl':
			ViewUrl::setViewUrl($name, $url);
			$result="URL set:".ViewUrl::getViewUrl($name);
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit test</title>
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
		<td>url</td>
		<td><input type="text" name="url" width="2"></input></td>
	</tr>
	<tr><td>
		<INPUT TYPE=RADIO NAME="type" VALUE="getViewUrl">getViewUrl</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="setViewUrl" CHECKED>setViewUrl</INPUT>
		</td>
	</tr>
	<tr>
		<td><input type="submit" value="SubmitViewUrlTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
