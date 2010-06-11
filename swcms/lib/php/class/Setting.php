<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class Setting {
	public static function getSetting($id) {
		$query="select * from settings where id='$id'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}
	public static function getIntSetting($id) {
		$row = Setting::getSetting($id);
		return intval($row[2]);
	}
	public static function setSetting($id, $value) {
		$query="select * from settings where id='$id'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$value=urlencode($value);
		if ($row=mysql_fetch_row($result)) {
			$query = "UPDATE settings SET value='$value' WHERE id='$id';";
			$result = mysql_query($query)
			or die(sqlError(__FILE__, __LINE__,$query));
		}
		return $row;
	}
	
	public static function getSettings() {
		$query="select * from settings";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$i=0;
		while ($row = mysql_fetch_row($result)) {
			$setting[$i++]=$row;
		}
		return $setting;
	}
}
?>