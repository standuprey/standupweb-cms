<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class StructuredUnit {
	public static function createUnit($name) {
		$query="INSERT INTO structured_unit (name, random, defaultFieldValue) VALUES ('$name', 0, 'new-$name')";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function getUnitId($name) {
		if (empty($name)) return;
		$query="select id from structured_unit where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row[0];
	}
	
	public static function getUnit($id) {
		$query="select * from structured_unit where id='$id'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}
	
	public static function getUnitbyName($name) {
		$query="select * from structured_unit where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}
	
	public static function getUnitRandom($name) {
		$query="select random from structured_unit where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row[0];
	}

	public static function updateUnit($id, $name, $random) {
		$query = "UPDATE structured_unit SET name='$name', random=$random WHERE id=$id;";
		$result = mysql_query($query)
		or die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteUnit($name) {
		$query="delete from structured_unit where name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}
}
?>