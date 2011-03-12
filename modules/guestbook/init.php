<?php
function Badwordcutter($text) {
	global $db;
	$badwords = $db->select(array("table" => "badwords","db" => "siteman"));
	foreach($badwords as $badword) {
		$text = str_replace($badword["word"], $badword["good"], $text);
	}
	return $text;
}
function global_replace($st) {
	$st = htmlspecialchars($st, ENT_QUOTES);
	$st = stripslashes($st);
	$st = str_replace("\t","",$st);
	$st = str_replace("\r","",$st);
	$st = str_replace("&nbsp;", " ", $st);
	return $st;
}
if (isset($_POST["text"]) && strlen($_POST["text"]) > 0 && strlen($_POST["name"]) > 0) {
	$posted = $db->select(array("table" => "guestbook","db" => "siteman","select" => array("id","ip","date"),"where" => array("ip = ".$_SERVER["REMOTE_ADDR"]),"orderby" => array("id",DESC)));
	if (strlen($posted[0]["date"]) == 10) {
		$difference = time()-$posted[0]["date"];
		if ($difference < 300) {
			header("Location: index.php?module=guestbook&form=0&flood=1");
			exit;
		}
	}
	$textbad = global_replace($_POST["text"]);
	$text = Badwordcutter($textbad);
	$new = array("ip" => $_SERVER["REMOTE_ADDR"],"name" => global_replace($_POST["name"]),"text" => $text,"email" => global_replace($_POST["email"]),"website" => global_replace($_POST["website"]),"location" => global_replace($_POST["location"]),"icq" => global_replace($_POST["icq"]));
	$db->insert(array("table" => "guestbook","db" => "siteman","values" => $new));
	header("Location: index.php?module=guestbook&form=0");
	exit;
}
?>