<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class ViewUrl {
	public static function getViewUrl($name) {
		$query="select url from view_url where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row[0];
	}
	public static function setViewUrl($name, $url) {
		$query="select * from view_url where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		if ($row=mysql_fetch_row($result)) {
			$query = "UPDATE view_url SET url='$url' WHERE name='$name';";
			$result = mysql_query($query)
			or die(sqlError(__FILE__, __LINE__,$query));
		} else {
			$query="INSERT INTO view_url (name, url) VALUES ('$name', '$url')";
			$result=mysql_query($query) or
			die(sqlError(__FILE__, __LINE__,$query));
		}
		return $row;
	}
}
?>