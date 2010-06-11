<?php
require_once('DOLib.php');

function getPasswordForUser($user) {
	connect();
	$query="select * from user where username='$user'";
	$query=stripslashes($query);
	$result=mysql_query($query) or
	die(sqlError(__FILE__, __LINE__,$query));
	if (!empty($result)) {
		$userrow = mysql_fetch_row($result);
		return $userrow[2];
	}
	return "";
}

function validate($challenge, $response, $password) {
	return md5($challenge . $password) == $response;
}

function endIt($error) {
	header("Location:../../index.php?error=".urlencode($error));
	exit;
}

function authenticate() {
	if (isset($_SESSION[challenge]) &&
	isset($_POST[username]) &&
	isset($_POST[response])) {
		$password = getPasswordForUser($_POST[username]);
		if (empty($password)) endIt("Wrong user name/password");
		if (validate($_SESSION[challenge], $_POST[response], $password)) {
			$_SESSION[s_username]=$GLOBALS['DOCUMENT_ROOT'].$_POST[username];
			unset($_SESSION[challenge]);
		} else {
			endIt("Wrong user name/password");
		}
	} else {
		endIt("Session expired");
	}
}
session_start();
authenticate();
header("Location:../../view.php");
exit();
?>
