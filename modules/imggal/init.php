<?php
$mdo = (isset($_GET["mdo"])) ? $_GET["mdo"] : "default";
$cat = (isset($_GET["cat"])) ? $_GET["cat"] : "";
$image = (isset($_GET["image"])) ? $_GET["image"] : "";
$cats = $db->select(array("table" => "ig_cat","db" => "modules","where" => array("id = $cat")));
switch ($mdo) {
	case "showimage":
		$Siteman->content = "Фото-галерея -> ".$cats[0]['catname'];
	break 1;

	case "showcat":
        $Siteman->content = "Фото-галерея -> ".$cats[0]['catname'];
    break 1;

	default:
		if ($cat == "all" || $cat == "") {
        	$Siteman->content = "Фото-галерея";
        } 
	break 1;
}
if (isset($image)){
	$clicks = $db->select(array("table" => "ig_img","db" => "modules","where" => array("id = $image")));
	$clicks[0]["count"]++;
	$db->update(array("table" => "ig_img","db" => "modules","where" => array("id = $image"),"values" => array("count" => $clicks[0]["count"])));
}
?>