<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class StructuredFieldValue {
	public static function createValue ($id, $value, $name) {
		$query="INSERT INTO structured_field_value (structured_field_id, name, value) VALUES ($id, '$name', '".formatValue($value)."');";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function readValue ($id, $name) {
		$query="SELECT value FROM structured_field_value WHERE structured_field_id=$id AND name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return urldecode($row[0]);
	}

	public static function getValues ($id) {
		$query="SELECT * FROM structured_field_value INNER JOIN structured_field_value_label ON structured_field_value.name=structured_field_value_label.label INNER JOIN structured_field ON structured_field_value.structured_field_id = structured_field.id WHERE structured_field_value.structured_field_id = $id AND structured_field.structured_unit_id = structured_field_value_label.unit_id ORDER BY structured_field_value_label.rank";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		while ($row=mysql_fetch_row($result))  {
			$valueArray[]=$row;
		}
		return $valueArray;
	}

	public static function updateValue ($id, $value, $name) {
		$query = "UPDATE structured_field_value SET value='".formatValue($value)."', name='$name' WHERE id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteValue($id, $name) {
		$query="delete from structured_field_value where structured_field_id=$id and name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteAll($id) {
		$query="delete from structured_field_value where structured_field_id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}


	public static function initValues($unitId, $id) {
		$query="select label from structured_field_value_label where unit_id=$unitId";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		while ($row=mysql_fetch_row($result))  {
			$query="INSERT INTO structured_field_value (structured_field_id, name) VALUES ($id, '".$row[0]."')";
			$result2=mysql_query($query) or
			die(sqlError(__FILE__, __LINE__,$query));
		}
	}
	
	public static function getType($name) {
		$query="select type from structured_field_value_label where label='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row[0];
	}
}
?>