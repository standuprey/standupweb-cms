<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>simple CMS - unit test</title>
<link rel="shortcut icon" href="../images/favicon.ico" />

</head>
<body>
<h1>Unit test list:</h1>
<a href="unittest_static_field.php">unittest_static_field.php</a><br/>
<a href="unittest_view_url.php">unittest_view_url.php</a><br/>
<a href="unittest_structured_field.php">unittest_structured_field.php</a><br/>
<a href="unittest_structured_field_value.php">unittest_structured_field_value.php</a><br/>
<a href="unittest_structured_field_value_label.php">unittest_structured_field_value_label.php</a><br/>
<a href="unittest_structured_field_asset_label.php">unittest_structured_field_asset_label.php</a><br/>
<a href="unittest_structured_unit.php">unittest_structured_unit.php</a>
</body>
</html>