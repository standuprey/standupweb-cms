<?php
require_once($GLOBALS['DOCUMENT_ROOT']."/swcms/lib/php/DOLib.php");
class StructuredField {
	// format keywords:
	// @@#: value number #
	// @@rank: include field rank
	// @@a#: include asset number #
	// @@t#: include asset title for asset number #
	public static function printField($name, $formattedString) {
		if (swValidate('edit')) {
			echo "<div style='position:absolute'><a target='_top' class='edit' href='swcms/editrecord.php?edittype=record&name=$name' class='edit'></a></div>";
		}
		$fieldList = StructuredField::getSortedRecords(StructuredUnit::getUnitId($name), true);
		$rank = 1;
		if ($fieldList) foreach ($fieldList as $field) {
			$output = $formattedString;
			$output = str_replace("@@rank", $rank++, $output);
			$values = StructuredFieldValue::getValues($field[0]);
			$index = 1;
			if ($values) foreach ($values as $value) {
				$output = str_replace("@@".$index++, displayValue($value[3]), $output);
			}
			$index = 1;
			$assets = StructuredFieldAsset::getAssets($field[0]);
			if ($assets) foreach ($assets as $asset) {
				$output = str_replace("@@a".$index, displayValue($asset[2]), $output);
				$output = str_replace("@@t".$index, displayValue($asset[1]), $output);
				$index++;
			}
			echo $output;
		}
	}

	public static function createRecord($structuredUnitId, $name, $rank) {
		if (!$structuredUnitId) return 0;
		// find the right rank value
		if (!$rank) {
			$query="SELECT count(*) from structured_field where structured_unit_id=$structuredUnitId LIMIT 1;";
			$result=mysql_query($query) or
			die(sqlError(__FILE__, __LINE__,$query));
			$row=mysql_fetch_row($result);
			if ($row[0]) {
				$query = "SELECT MAX(rank) from structured_field where structured_unit_id=$structuredUnitId;";
				$result=mysql_query($query) or
				die(sqlError(__FILE__, __LINE__,$query));
				$row=mysql_fetch_row($result);
				$rank=$row[0]+1;
			}  else $rank=1;
		} else if (StructuredField::findRecord($structuredUnitId,$rank)) {
			StructuredField::moveRankUp($structuredUnitId, $rank);
		}

		// create structured field
		$query="INSERT INTO structured_field (structured_unit_id, rank, name) VALUES ($structuredUnitId, $rank, '$name');";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));

		// create field values and field assets
		$id=mysql_insert_id();
		StructuredFieldValue::initValues($structuredUnitId, $id);
		StructuredFieldAsset::initAssets($structuredUnitId, $id);

		return $id;
	}

	public static function updateRecord($id, $name, $rank, $lock = 0) {
		$thisRecord = StructuredField::readRecord($id);
		if ($name && strcmp($thisRecord[3], $name)!=0) {
			$value[]= "name='".urlencode($name)."'";
		}
		if ($rank && $rank!=$thisRecord[2]) {
			StructuredField::moveRankUp($thisRecord[1], $rank);
			$value[]="rank=$rank";
		}
		if (empty($lock)) $lock=0;
		$value[]="adminlock=$lock";

		// create structured field
		if ($value) {
			$query = "UPDATE structured_field SET ".implode(", ", $value)." WHERE id=$id;";
			$result=mysql_query($query) or
			die(sqlError(__FILE__, __LINE__,$query));
		}
		return $rank;
	}

	public static function moveRankUp($structuredUnitId, $rank) {
		$records=StructuredField::getSortedRecords($structuredUnitId);
		if (!records) return;
		$lastRank=$rank;
		foreach ($records as $record) {
			if ($record[2]==$lastRank) {
				$lastRank++;
				$query = "UPDATE structured_field SET rank=$lastRank WHERE id=".$record[0].";";
				$result = mysql_query($query)
				or die(sqlError(__FILE__, __LINE__,$query));
			} else if ($record[2]>$lastRank) {
				return;
			}
		}
	}

	public static function readRecord($id) {
		$query="select * from structured_field where id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

	public static function getSortedRecords($structuredUnitId, $isAdmin=0) {
		if (!$structuredUnitId) return;
		if ($isAdmin) {
			$query="select * from structured_field where structured_unit_id=$structuredUnitId order by rank";
		} else {
			$query="select * from structured_field where structured_unit_id=$structuredUnitId AND adminlock=0 order by rank";
		}
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		while ($row=mysql_fetch_row($result)) {
			$records[]=$row;
		}
		return $records;
	}

	public static function switchRank($id1, $id2)  {
		$record1=StructuredField::readRecord($id1);
		$record2=StructuredField::readRecord($id2);
		$rank1=$record1[2];
		$rank2=$record2[2];
		$query = "UPDATE structured_field SET rank=$rank2 WHERE id=$id1;";
		$result1 = mysql_query($query)
		or die(sqlError(__FILE__, __LINE__,$query));
		$query = "UPDATE structured_field SET rank=$rank1 WHERE id=$id2;";
		$result2 = mysql_query($query)
		or die(sqlError(__FILE__, __LINE__,$query));
	}

	public static function deleteRecord($id) {
		$query="delete from structured_field where id=$id";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		// delete values and assets
		StructuredFieldValue::deleteAll($id);
		StructuredFieldAsset::deleteAll($id);
	}

	// private methods
	private static function findRecord($structuredUnitId, $rank) {
		$query="select * from structured_field WHERE structured_unit_id=$structuredUnitId AND rank=$rank";
		$result=mysql_query($query) or
		die(sqlError(__FILE__, __LINE__,$query));
		$row=mysql_fetch_row($result);
		return $row;
	}

}
?>