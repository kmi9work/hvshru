<?php
$failed = 0;
if ($Siteman->userinfo["level"] >= 4) {
	if (isset($_GET["mdo"])) {
		$mdo = $_GET["mdo"];
	}
	else {
		$mdo = "default";
	}
	switch ($mdo) {

		case "deletecat":
			if ($_POST["really"] == "y"){
				$delete = $_POST["cat_id"];
				$db->delete(array("table" => "ig_cat","where" => array("id = $delete"),"db" => "modules"));
				$db->delete(array("table" => "ig_img","where" => array("id_cat = $delete"),"db" => "modules"));
				$status = "Категория <b>".$delete."</b> и все изображения в ней удалены.";
			}
			else {
				$status = "Категория <b>".$delete."</b> не удалена!";
			}
			$mdo = "default";
		break 1;

		case "deleteimg":
			$delete = $_POST["imgid"];
			if (!isset($delete)){ break 1;}
				if ($_POST["really"] == "y"){
				$db->delete(array("table" => "ig_img","where" => array("id = $delete"),"db" => "modules"));
				$status = "Изображение <b>".$delete."</b> удалено.";
			}
			else {
				$status = "Изображение <b>".$delete."</b> не удалено!";
			}
			$mdo = "default";
		break 1;

		case "updatecat":
			$db->update(array("table" => "ig_cat","db" => "modules","where" => array("id = $id"),"values" => array("catname" => stripslashes($_POST["cat_name"]),"catdesc" => $_POST["cat_desc"],"level" => $_POST["level"])));
			$status = "Данные обновлены...";
			$mdo = "default";
		break 1;

		case "savecat":
			$db->insert(array("table" => "ig_cat","db" => "modules","values" => array("catname" => stripslashes($_POST["cat_name"]),"catdesc" => $_POST["cat_desc"],"level" => $_POST["level"])));
			$status = "Категория сохранена...";
			$mdo = "default";
		break 1;

		case "updateimg":
			$db->update(array("table" => "ig_img","db" => "modules","where" => array("id = $id"),"values" => array("name" => stripslashes($_POST["img_name"]),"id_cat" => $_POST["cat_id"],"desc" => stripslashes($_POST["img_desc"]),"link" => stripslashes($_POST["img_link"]),"poster" => stripslashes($_POST["img_poster"]))));
			$status = "Данные обновлены...";
			$mdo = "default";
		break 1;

		case "saveimg":
			if ($_POST["catid"] == "none" || $_POST["imglink"] == "" || $_POST["imgname"] == ""){
				$status = "<b>Пожалуйста, выберите категорию и имя файла с изображением</b>";
				$failed = 1;
			}
			else {
				$db->insert(array("table" => "ig_img","db" => "modules","values" => array("name" => stripslashes($_POST["imgname"]),"id_cat" => $_POST["catid"],"desc" => stripslashes($_POST["imgdesc"]),"link" => stripslashes($_POST["imglink"]),"count" => 0,"poster" => stripslashes($_POST["imgposter"]))));
				$status = "...сохранение изображения...";
				$failed = 0;
			}
			$mdo = "default";
		break 1;

	}
}
?>