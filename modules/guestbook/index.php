<?php
function smiliehtml($text) {
	$text = str_replace(':)','<img src="modules/guestbook/smilies/smile.gif" border="0">',$text);
	$text = str_replace(':(','<img src="modules/guestbook/smilies/sad.gif" border="0">',$text);
	$text = str_replace(';)','<img src="modules/guestbook/smilies/wink.gif" border="0">',$text);
	$text = str_replace(':cool:','<img src="modules/guestbook/smilies/cool.gif" border="0">',$text);
	$text = str_replace(':mad:','<img src="modules/guestbook/smilies/mad.gif" border="0">',$text);
	$text = str_replace(':D','<img src="modules/guestbook/smilies/biggrin.gif" border="0">',$text);
	$text = str_replace(':rolleyes:','<img src="modules/guestbook/smilies/rolleyes.gif" border="0">',$text);
	return $text;
}
function bb_replace($st) {
	$st = str_replace("\n","<br />",$st);
	$st = str_replace("[b]","<b>",$st);
	$st = str_replace("[/b]","</b>",$st);
	$st = str_replace("[i]","<i>",$st);
	$st = str_replace("[/i]","</i>",$st);
	$st = str_replace("[u]","<u>",$st);
	$st = str_replace("[/u]","</u>",$st);
	return $st;
}
function url_replace($st) {
	$st = preg_replace("/(?<!\\/)(www\\.[\\S]+)/si",'<a href="http://\\1" target="_blank">\\1</a>',$st);
	$st = preg_replace("/(?<!\\/)(ftp\\.[\\S]+)/si",'<a href="ftp://\\1" target="_blank">\\1</a>',$st);
	$st = preg_replace("/(?<!\")(http|ftp):\\/\\/(\\S+)/si",'<a href="\\1://\\2" target="_blank">\\2</a>',$st);
	$st = preg_replace("/(?<!\\/)([0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,4})/si",'<a href="mailto:\\1">\\1</a>',$st);
	return $st;
}
if (isset($_GET["offset"])) {
	$offset = $_GET["offset"];
}
else {
	$offset = 0;
}
$postcount = $db->table_count("guestbook","siteman");
$start = $postcount-($offset+10);
if ($start < 0) {
	$start = 0;
}
$end = $postcount-($offset+1);
$posts = $db->select(array("table" => "guestbook","db" => "siteman","limit" => array($start,$end),"orderby" => array("id",DESC)));
$pages = ceil($postcount/10);
$page = ($offset/10)+1;
$Siteman->load_lang("guestbook");
if (!isset($_GET["form"])) {
	$_GET["form"] = 1;
}
if (!isset($_GET["flood"])) {
	$_GET["flood"] = 0;
}
if ($_GET["form"]) {
	if ( $Siteman->userinfo["hide_email"] != 1) {
		$guestbook_email = $Siteman->userinfo["email"];
	}
	echo $Siteman->lang["pleasesign"]."<br /><br /><script language=\"javascript\" type=\"text/javascript\" src=\"modules/guestbook/guestbook.js\"></script>
	<form action=\"index.php?module=guestbook\" method=\"post\" name=\"guestform\" id=\"guestform\">
	<table cellspacing=\"0\" cellpadding=\"2\"><tr><td>".$Siteman->lang["name"]."</td><td><input type=\"text\" name=\"name\" size=\"40\" value=\"".$Siteman->userinfo["username"]."\"   /></td></tr>
	<tr><td>".$Siteman->lang["location"]."</td><td><input type=\"text\" name=\"location\" size=\"40\" /></td></tr>
	<tr><td>".$Siteman->lang["email"]."</td><td><input type=\"text\" name=\"email\" size=\"40\" value=\"".$guestbook_email."\" /></td></tr>
	<tr><td>".$Siteman->lang["website"]."</td><td><input type=\"text\" name=\"website\" size=\"40\" value=\"http://\" /></td></tr>
	<tr><td>".$Siteman->lang["icq"]."</td><td><input type=\"text\" name=\"icq\" size=\"40\" /></td></tr>
	<tr><td>&nbsp;</td><td><small>".$Siteman->lang["textdecor"].": &nbsp; <a href=\"javascript:code('b')\" class=\"b\"><b>".$Siteman->lang["bold"]."</b></a> &nbsp;<a href=\"javascript:code('i')\" class=\"b\"><i>".$Siteman->lang["italic"]."</i></a> &nbsp;<a href=\"javascript:code('u')\" class=\"b\"><u>".$Siteman->lang["underline"]."</u></a></small></td></tr>
	<tr><td>".$Siteman->lang["text"]."</td><td><textarea name=\"text\" rows=\"7\" cols=\"38\"></textarea></td></tr>
	<tr><td></td><td><input type=\"submit\" value=\"".$Siteman->lang["sign"]."\" /></td></tr></table></form>";
}
else if ($_GET["flood"]) {
	echo $Siteman->lang["floodcontrol"];
}
else {
	echo $Siteman->lang["thankyou"];
}
echo"<br /><br /><b>".$Siteman->lang["previous"]."</b><br /><br />
<table cellspacing=\"0\" cellpadding=\"1\"><tr><td>:: </td>";
for ($i=1;$i<=$pages;$i++) {
	if ($i == $page) {
		echo"<td><b>$i</b></td>";
	}
	else {
		$nowoffset = ($i-1)*10;
		echo"<td><a href=\"index.php?module=guestbook&amp;offset=".$nowoffset."\">$i</a></td>";
	}
	echo"<td> :: </td>";
}
echo"</tr></table><br /><br />
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">";
foreach ($posts as $post) {
	$text = smiliehtml(bb_replace(url_replace($post["text"])));
	if ($post["location"] != ""){$post["location"] = $Siteman->lang["location"].": ".$post["location"];}
	if ($post["email"] != ""){$post["email"] = '<a href="mailto:'.$post["email"].'"><img src="modules/guestbook/img/amail.gif" alt="Mail to '.$post["email"].'" border="0" width="14" height="10"></a>';}
	if ($post["website"] != "http://"){$post["website"] = '<a href="'.$post["website"].'" target="_blank"><img src="modules/guestbook/img/aurl.gif" alt="'.$Siteman->lang["website"].': '.$post["website"].'" border="0" width="14" height="14"></a>';}
	else {$post["website"] = "";}
	if ($post["icq"] != ""){$post["icq"] = '<a href="http://www.icq.com/whitepages/about_me.php?uin='.$post["icq"].'" target="_blank"><img src="modules/guestbook/img/aicq.gif" alt="ICQ# '.$post["icq"].'" border="0" width="16" height="16"></a>';}
	if ($post["reply"] != ""){$post["reply"] = '<hr><i><u>'.$Siteman->lang["gbreply"].'</u>: '.smiliehtml(bb_replace($post["reply"])).'</i>';}
	$entrycode = file("themes/".$Siteman->settings["theme"]."/guestbook.tpl");
	foreach ($entrycode as $printing) {
		$printing = str_replace("%autor%","<img src=\"modules/guestbook/img/autorgb.gif\" border=\"0\"  width=\"12\" height=\"13\" alt=\"".$Siteman->lang["name"].": ".$post["name"]."\" /> ".$post["name"],$printing);
		$printing = str_replace("%location%",$post["location"],$printing);
		$printing = str_replace("%email%",$post["email"],$printing);
		$printing = str_replace("%website%",$post["website"],$printing);
		$printing = str_replace("%message%",$text,$printing);
		$printing = str_replace("%icq%",$post["icq"],$printing);
		$printing = str_replace("%reply%",$post["reply"],$printing);
		$printing = str_replace("%ip%",$post["ip"],$printing);
		$printdate = str_replace("%date%",date($Siteman->settings["long_dateformat"],$post["date"]+$Siteman->settings["timezone_offset"]),$Siteman->lang["messageposted"]);
		$printing = str_replace("%postdate%",$printdate,$printing);
		echo $printing;
	}
}
echo"</table><br /><br /><table cellspacing=\"0\" cellpadding=\"1\"><tr><td>:: </td>";
for ($i=1;$i<=$pages;$i++) {
	if ($i == $page) {
		echo"<td><b>$i</b></td>";
	}
	else {
		$nowoffset = ($i-1)*10;
		echo"<td><a href=\"index.php?module=guestbook&amp;offset=".$nowoffset."\">$i</a></td>";
	}
	echo"<td> :: </td>";
}
echo"</tr></table>";
?>