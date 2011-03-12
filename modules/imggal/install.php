<?php
if (substr_count($_SERVER["SCRIPT_FILENAME"],"install.php")) {
	exit("� ��� ��� ������� � ������� �������.");
}
switch ($mode) {
	case "install":
		$iddef = array("type" => "int","auto_increment" => 1,"primary" => 1,"permanent" => 1);
		$int = array("type" => "int");
		$string = array("type" => "string");
		$text = array("type" => "text");
		$date = array("type" => "date");
		if ($db->db_exists("modules") == "1") {
			echo '<br>�������� ��� ������ � ���� ������ "modules"!<br />';
		}
		else {
			$db->createdb(array("db" => "modules"));
		}
		$db->selectdb("modules");
		$db->createtable(array("table" => "ig_cat","db" => "modules","columns" => array("id" => $iddef,"catname" => $string,"catdesc" => $string,"level" => $int)));
		echo '���� ������ <b>image_category</b> �������<br />'.str_repeat("    ",1024);
		$db->insert(array("table" => "ig_cat","db" => "modules","values" => array("catname" => "������","catdesc" => "������ � ������������","level" => 0)));
		$db->createtable(array("table" => "ig_img","db" => "modules","columns" => array("id" => $iddef,"date" => $date,"name" => $string,"id_cat" => $int,"desc" => $text,"link" => $string,"count" => $int,"poster" => $string)));
		$db->insert(array("table" => "ig_img","db" => "modules","values" => array("name" => "Google Logo","id_cat" => 1,"desc" => "������� Google","link" => "http://www.google.de/intl/de_de/images/logo.gif","count" => 0,"poster" => "mutanwulf")));
		echo '���� ������ <b>image_gallery</b> �������<br />';
    break 1;

	case "uninstall":
		$db->droptable(array("db" => "modules","table" => "ig_cat"));
		$db->droptable(array("db" => "modules","table" => "ig_img"));
	break 1;
}
?>