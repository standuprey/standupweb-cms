<?php
// admin header
session_start();
require_once('../../lib/php/DOLib.php');
if (!swValidate('s_username')) {header("location: ../index.php");}
connect();

$type = $_POST["type"];
$name = $_POST["name"];
$id = $_POST["id"];
$id_switch = $_POST["id_switch"];
$assets[] = $_POST["asset1"];
if ($type) {
	switch ($type) {
		case 'create':
			StructuredFieldAssetLabel::create($id);
			$result="structured field asset label with name=$name created";
			break;
		case 'update':
			StructuredFieldAssetLabel::update($id, $assets);
			$result="structured field asset label with name=$name updated";
			break;
		case 'read':
			$asset = StructuredFieldAssetLabel::read($id);
			$result="The asset label with id=$id is '".implode(', ', $asset)."'";
			break;
		case 'delete':
			StructuredFieldAssetLabel::delete($id);
			$result="structured field asset label with id=$id deleted";
			break;
		case 'getsorted':
			$assetArray = StructuredFieldAssetLabel::getSorted($id);
			if (!$assetArray) {
				$result="no unit for the id=$id";
			} else {
				foreach ($assetArray as $v) {
					$vArray[]=implode (",", $v);
				}
				$result="getSorted result:\n".implode("<br/>", $vArray);
			}
			break;
		case 'switchrank':
			StructuredFieldAssetLabel::switchRank($id, $id_switch);
			$result="structured field asset lael $id and $id_switch have switched their ranks";
			break;
		case 'getstructure':
			$result = StructuredFieldAssetLabel::getStructure();
			$result="structured of structured_field_asset_label: ".implode(', ', $result);
			break;
	};
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>standupweb CMS - structured field asset label test</title>
<link rel="shortcut icon" href="../images/favicon.ico" />

</head>
<body>
<form method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
<table cellspacing=20>
	<tr>
		<td><strong>see table structured_field_asset_label in mySQL</strong></td>
	</tr>
	<tr>
		<td>result</td>
		<td><?php echo($result);?></td>
	</tr>
	<tr>
		<td>id</td>
		<td><input type="text" name="id" width="11"></input></td>
	</tr>
	<tr>
		<td>id_switch</td>
		<td><input type="text" name="id_switch" width="11"></input></td>
	</tr>
	<tr>
		<td>name</td>
		<td><input type="text" name="name" width="20"></input></td>
	</tr>
	<tr>
		<td>asset1 (label)</td>
		<td><textarea name="asset1" rows="5" cols="20"></textarea></td>
	</tr>
	<tr>
		<td><INPUT TYPE=RADIO NAME="type" VALUE="create" CHECKED>create(unitId)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="read">read(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="update">update(id, assets)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="delete">delete(id)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getsorted">getSorted(unitId)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="switchrank">switchRank(id, id_switch)</INPUT><br />
		<INPUT TYPE=RADIO NAME="type" VALUE="getstructure">getStructure()</INPUT></td>
	</tr>
	<tr>
		<td><input type="submit" asset="SubmitStructuredFieldAssetLabelTest" /></td>
	</tr>
</table>
</form>
</BODY>
</HTML>
