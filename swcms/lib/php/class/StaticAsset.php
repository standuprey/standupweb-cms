<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
// static field methods
class StaticAsset {
	public static function getStaticAssetByName($name) {
		$query="select * from static_asset where name='$name' and current=1";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}
	public static function getAllStaticAssetsByName($name) {
		$query="select * from static_asset where name='$name' order by creation_date desc";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$i=0;
		while ($row = mysql_fetch_row($result)) {
			$StaticAssets[$i++]=$row;
		}
		return $StaticAssets;
	}
	public static function getStaticAssetById($id) {
		$query="select * from static_asset where id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

	public static function createStaticAsset($name, $asset, $ext) {
		StaticAsset::releaseCurrentField($name);
		$query="INSERT INTO static_asset (name, asset, current, extension) VALUES ('$name', '".formatValue($asset)."', 1, '$ext')";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteStaticAsset($id) {
		$query="select asset from static_asset where id='$id' AND current='1'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		if (mysql_fetch_row($result)) return false;
		$query="delete from static_asset where id='$id'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		return true;
	}
	
	public static function includePicture($name) {
		$asset=StaticAsset::getStaticAssetByName($name);
		if (swValidate('edit')) {
			echo ("<a target='_top' class='edit' href='swcms/editstaticasset.php?name=$name' class='edit'></a>");
		}
		if ($asset) echo ("<img alt='".$asset[1]."' src='swcms/assets/".$asset[2]."'></img>");
	}
	
	// private methods
	private static function releaseCurrentField($name) {
		$query = "UPDATE static_asset SET current='0' WHERE current='1' AND name='$name';";
		$result = mysql_query($query)
		or die(sqlError(__FILE__, __LINE__,$query));
	}

}
?>