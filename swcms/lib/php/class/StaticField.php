<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
// static field methods
class StaticField {
	public static function getStaticFieldValueByName($name) {
		$query="select value from static_field where name='$name' and current=1";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return urldecode($row[0]);
	}
	public static function getStaticFieldByName($name) {
		$query="select * from static_field where name='$name' and current=1";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}
	public static function getAllStaticFieldsByName($name) {
		$query="select * from static_field where name='$name' order by creation_date desc";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$i=0;
		while ($row = mysql_fetch_row($result)) {
			$staticFields[$i++]=$row;
		}
		return $staticFields;
	}
	public static function getStaticFieldById($id) {
		$query="select * from static_field where id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

	public static function createStaticField($name, $value) {
		StaticField::releaseCurrentField($name);
		$query="INSERT INTO static_field (name, value, current) VALUES ('$name', '".formatValue($value)."', 1)";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteStaticField($id) {
		$query="select value from static_field where id='$id' AND current='1'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		if (mysql_fetch_row($result)) return false;
		$query="delete from static_field where id='$id'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		return true;
	}

	public static function includeText($name) {
		$value=StaticField::getStaticFieldValueByName($name);
		if (swValidate('edit')) {
							echo ("<a target='_top' class='edit' href='swcms/editstatic.php?name=$name' class='edit'></a>");
		}
		echo (displayValue($value));
	}
	
	// private methods
	private static function releaseCurrentField($name) {
		$query = "UPDATE static_field SET current='0' WHERE current='1' AND name='$name';";
		$result = mysql_query($query)
		or die(sqlError(__FILE__, __LINE__,$query));
	}
}
?>