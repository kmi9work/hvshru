<?
$img_status = "o.k.";
$mdo = (isset($_GET["mdo"])) ? $_GET["mdo"] : "default";
$cat = (isset($_GET["cat"])) ? $_GET["cat"] : "";
$image = (isset($_GET["image"])) ? $_GET["image"] : "";
switch ($mdo) {
	case "showimage":
		$imgone = $db->select(array("table" => "ig_img","db" => "modules","where" => array("id = $image")));
		$cats = $db->select(array("table" => "ig_cat","db" => "modules","where" => array("id = $cat")));
		echo '<a href="index.php?module=imggal">Фото-галерея</a> => <a href="index.php?module=imggal&amp;mdo=showcat&amp;cat='.$cats[0]['id'].'">'.$cats[0]['catname'].'</a>
		<table height="500" width="90%">
		<caption>'.$imgone[0]['name'].'</caption>
		<tr><td colspan="2"><a href="'.$imgone[0]['link'].'" target="_blank"><img src="'.$imgone[0]['link'].'" style="height: auto; max-width: 500px;" border="0" alt="'.$imgone[0]['name'].'"></a></td></tr>
		<tr><td colspan="2">'.$imgone[0]['desc'].'</td></tr>
		<tr><td>&copy; <i>'.$imgone[0]['poster'].'</i></td>
		<td>'.date($Siteman->settings['long_dateformat'],$imgone[0]['date']+$Siteman->settings['timezone_offset']).'
		<br />Просмотров: '.$imgone[0]['count'].'</td></tr></table>';
	break 1;

	case "showcat":
		$cats = $db->select(array("table" => "ig_cat","db" => "modules","where" => array("id = $cat")));
		$imgs = $db->select(array("table" => "ig_img","db" => "modules","where" => array("id_cat = $cat")));
		echo '<a href="index.php?module=imggal">Фото-галерея</a> => '.$cats[0]["catname"].'<br />';
		if($imgs[0]['name']== "") {
			$img_status = "В этой категории нет изображений!";
		}
		else if ($imgs[0]['name'] != "" && $Siteman->userinfo['level'] >= $cats[0]['level']) {
        	echo '<table width="90%" align="center" border="0" cellspacing="10">';
        	foreach ($imgs as $img) {
           		echo '<tr><td width=50 rowspan=2>
           		<a href="index.php?module=imggal&amp;mdo=showimage&amp;cat='.$cat.'&amp;image='.$img['id'].'"><img src="'.$img['link'].'" width="100" height="100" border="0"></a></td><td><b>'.$img['name'].'</b></td>
           		<td align="right">'.date($Siteman->settings['long_dateformat'],$img['date']+$Siteman->settings['timezone_offset']).'<br />Просмотров: '.$img['count'].'</td></tr>
           		<tr><td>'.$img['desc'].'</td>
           		<td align="right">&copy; <i>'.$img['poster'].'</i></td></tr>';
        	}
         	echo '</table>';
         }
		else {
			$img_status = 'Просмотр этой категории доступен только зарегистрированным пользователям!';
		}
	break 1;

	default:
		if ($cat == "all" || $cat == "") {
        	$cats = $db->select(array("table" => "ig_cat","db" => "modules"));
        	echo '<table width="90%" align="center" border="0" cellspacing="10">';
         	foreach ($cats as $cat) {
        		echo '<tr><td width="50" rowspan="2"><img src="./modules/imggal/ordner.gif" width="50" height="50" border="0"><br /></td>
				<td><a href="index.php?module=imggal&amp;mdo=showcat&amp;cat='.$cat['id'].'"><b>'.$cat['catname'].'</b></a></td></tr>
				<tr><td>'.$cat['catdesc'].'</td></tr>';
			}
        	echo '</table>';
		}
		else {
         	$img_status = "В галерее нет категорий.";
		}
	break 1;
}
echo '<br /><br /><hr>Статус галереи: '.$img_status;
?>