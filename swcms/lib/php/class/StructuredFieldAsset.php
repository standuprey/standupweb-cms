<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class StructuredFieldAsset {
	public static function readAsset ($id) {
		$query="SELECT * FROM structured_field_asset WHERE id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

	public static function getAssetByName ($fieldId, $name) {
		$query="SELECT * FROM structured_field_asset WHERE structured_field_id=$fieldId AND name='$name'";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

	public static function getAssets ($id) {
		$query = "SELECT * FROM structured_field_asset INNER JOIN structured_field_asset_label ON structured_field_asset.label=structured_field_asset_label.label INNER JOIN structured_field ON structured_field_asset.structured_field_id=structured_field.id WHERE structured_field_asset.structured_field_id = $id AND structured_field.structured_unit_id=structured_field_asset_label.unit_id ORDER BY structured_field_asset_label.rank";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		while ($row=mysql_fetch_row($result))  {
			$assetArray[]=$row;
		}
		return $assetArray;
	}

	public static function updateAsset ($id, $asset, $name, $ext) {
		$query = "UPDATE structured_field_asset SET asset='".formatValue($asset)."', name='$name', extension='$ext' WHERE id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteAsset($id) {
		$query="delete from structured_field_asset where id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteAll($id) {
		$query="delete from structured_field_asset where structured_field_id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function initAssets($unitId, $id) {
		$query="select label from structured_field_asset_label where unit_id=$unitId";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		while ($row=mysql_fetch_row($result))  {
			$query="INSERT INTO structured_field_asset (structured_field_id, label) VALUES ($id, '".$row[0]."')";
			$result2=mysql_query($query) or
			die(sqlError(__FILE__, __LINE__,$query));
		}
	}
}
?>