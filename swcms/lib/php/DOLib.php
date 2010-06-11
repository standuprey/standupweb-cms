<?php
// Settings:
$ROOT_FOLDER = preg_replace('`.+(\\\|/){1}(.+)(\\\|/){1}swcms(\\\|/){1}.+`', '\1\2', dirname(__FILE__));

$DB_LOCATION = "localhost";
$DB_NAME = "standupw_cms";
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'].$ROOT_FOLDER;

// different username/password if on the server or local
if (substr($_SERVER['DOCUMENT_ROOT'],0,2) == 'D:') {
	$DB_USER = "root";
	$DB_PASSWORD = "";
} else {
	$DB_USER = "standupw_stan";
	$DB_PASSWORD = "stan2007";
}

function swValidate($sessionVariable){
	$sessionVar = $_SESSION[$sessionVariable];
	if (empty($sessionVar)) return false;
	$rootFolder = $GLOBALS['DOCUMENT_ROOT'];
	if (strcmp(substr($sessionVar, 0, strlen($rootFolder)),$rootFolder)==0) {
		return true;
	}
	return false;
}

function swIsAdmin() {
	if (swValidate('s_username') && strcmp($_SESSION['type'], 'admin')==0) return true;
	return false;
}

function connect() {
	mysql_connect($GLOBALS['DB_LOCATION'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'])
	or die ("impossible de se connecter a mysql");
	mysql_select_db($GLOBALS['DB_NAME'])
	or die ("impossible de trouver la db");
}

function __autoload($class_name) {
	require_once ($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/class/$class_name.php");
}

function formatValue($value) {
	// HTML injection for superuser only
	if (swIsAdmin()) return addslashes(str_replace("\n", "<br/>", $value));
	return addslashes(str_replace("\n", "<br/>", htmlentities($value)));
}

function restoreValue($value) {
	return stripslashes(str_replace("<br/>", "\n", html_entity_decode(urldecode($value))));
}

function displayValue($value, $transform = true) {
	$link = stripslashes(urldecode($value));
	if ($tranform)
	{
		// replace http;// links by <a href../a>
		$link = preg_replace("`(http|ftp)+(s)?:(//)((\w|\.|\-|_)+)(/)?(\S+)?`i", "<a href=\"\\0\" title=\"\\0\">\\0</a>", $link);
		// replace email address by mailto link
		$link = preg_replace("`([-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]{2,6})`i","<a href=\"mailto:\\1\" title=\"mailto:\\1\">\1</a>", $link);
	}
	return $link;
}

function sqlError($file, $line, $query) {
	die("Standupweb CMS error at line ".$line. " in file ".$file.", sql error:".mysql_error()." - The query : ".$query);
}
?>