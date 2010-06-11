<?php
session_start();
require_once('../lib/php/DOLib.php');

$pattern = $_POST["pattern"];
$replacement = $_POST["replacement"];
$input = $_POST["input"];
if ($pattern) $output = preg_replace($pattern, $replacement, $output)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>preg_replace</title>
<link rel="shortcut icon" href="images/favicon.ico" />

</head>
<body>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<table cellspacing=20>
	<tr>
		<td><strong>preg_replace</strong></td>
	</tr>
	<tr>
		<td>result</td>
		<td><?php echo($output);?></td>
	</tr>
	<tr>
		<td>pattern</td>
		<td><input type="pattern" name="id" width="11" value="<?php echo $pattern; ?>"></input></td>
	</tr>
	<tr>
		<td>replacement</td>
		<td><input type="replacement" name="name" width="20" value="<?php echo $replacement; ?>"></input></td>
	</tr>
	<tr>
		<td>input</td>
		<td><textarea name="input" rows="5" cols="20" value="<?php echo $input; ?>"></textarea></td>
	</tr>
	<tr>
		<td><input type="submit" value="GO!!" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
