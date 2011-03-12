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
	if ($Siteman->userinfo["level"] >= 4) {
	
		switch ($mdo) {

			case "reply":
				$id = $_GET["id"];
				$posts = $db->select(array("table" => "guestbook","db" => "siteman","where" => array("id = $id")));
				$Siteman->load_lang("guestbook");
				foreach ($posts as $post) {
					$text = smiliehtml(bb_replace($post["text"]));
					echo"<script language=\"javascript\" type=\"text/javascript\" src=\"modules/guestbook/guestbook.js\"></script><h4>Ответ на сообщение #".$post["id"]."</h4>
					<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\"><tr><td><table cellpadding=\"3\" width=\"55%\" cellspacing=\"0\">
					<tr><td><b>Оригинальное сообщение:</b></td></tr>
					<tr><td  class=\"dark\">".$text."</td></tr><tr><td>&nbsp;</td></tr></table></td></tr><tr><td>
					<form action=\"admin.php?module=guestbook&amp;mdo=savereply&amp;id=".$post["id"]."\" method=\"post\" name=\"mainform\" id=\"mainform\">
					<table cellpadding=\"3\" width=\"100%\" cellspacing=\"0\"><tr><td><b>Ваш ответ:</b></td></tr>
					<tr><td><small>".$Siteman->lang["textdecor"].": &nbsp; <a href=\"javascript:admcode('b')\" class=\"b\"><b>".$Siteman->lang["bold"]."</b></a> &nbsp;<a href=\"javascript:admcode('i')\" class=\"b\"><i>".$Siteman->lang["italic"]."</i></a> &nbsp;<a href=\"javascript:admcode('u')\" class=\"b\"><u>".$Siteman->lang["underline"]."</u></a></small></td></tr>
					<tr><td><textarea rows=\"10\" cols=\"60\" name=\"reply\" id=\"reply\">".$post["reply"]."</textarea></td></tr>
					<tr><td><table cellspacing=\"0\" cellpadding=\"2\"><tr><td><input type=\"submit\" name=\"save\" value=\"Сохранить\" /></td></tr></form></table></td></tr></table>";
				}
				break 1;
			
			default:
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
			echo"<table cellspacing=\"0\" cellpadding=\"1\"><tr><td>:: </td>";
			for ($i=1;$i<=$pages;$i++) {
				if ($i == $page) {
					echo"<td><b>$i</b></td>";
				}
				else {
					$nowoffset = ($i-1)*10;
					echo"<td><a href=\"admin.php?module=guestbook&amp;offset=".$nowoffset."\">$i</a></td>";
				}
				echo"<td> :: </td>";
			}
			echo"</tr></table><br /><br />
			<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">";
			foreach ($posts as $post) {
				$text = smiliehtml(bb_replace($post["text"]));
				if ($post["location"] != ""){$post["location"] = $Siteman->lang["location"].": ".$post["location"];}
				if ($post["email"] != ""){$post["email"] = '<a href="mailto:'.$post["email"].'"><img src="modules/guestbook/img/amail.gif" alt="Mail to '.$post["email"].'" border="0" width="14" height="10"></a>';}
				if ($post["website"] != "http://"){$post["website"] = '<a href="'.$post["website"].'" target="_blank"><img src="modules/guestbook/img/aurl.gif" alt="'.$Siteman->lang["website"].': '.$post["website"].'" border="0" width="14" height="14"></a>';}
				else {$post["website"] = "";}
				if ($post["icq"] != ""){$post["icq"] = '<a href="http://www.icq.com/whitepages/about_me.php?uin='.$post["icq"].'" target="_blank"><img src="modules/guestbook/img/aicq.gif" alt="ICQ# '.$post["icq"].'" border="0" width="16" height="16"></a>';}
				if ($post["reply"] != ""){$post["reply"] = '<hr><i><u>'.$Siteman->lang["gbreply"].'</u>: '.smiliehtml(bb_replace($post["reply"])).'</i>';}
				echo"<tr><td>IP: ".$post["ip"]." - <a href=\"admin.php?module=guestbook&amp;mdo=reply&amp;id=".$post["id"]."&amp;offset=".$offset."\">Ответить</a> | <a href=\"admin.php?module=guestbook&amp;mdo=delete&amp;id=".$post["id"]."&amp;offset=".$offset."\">Удалить</a></td></tr>";
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
					echo"<td><a href=\"admin.php?module=guestbook&amp;offset=".$nowoffset."\">$i</a></td>";
				}
				echo"<td> :: </td>";
			}
			echo"</tr></table>";
			break 1;
		}
	}
?>