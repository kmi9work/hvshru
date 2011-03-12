<?php
	function global_replace($st) {
		$st = htmlspecialchars($st, ENT_QUOTES);
		$st = stripslashes($st);
		$st = str_replace("\t","",$st);
		$st = str_replace("\r","",$st);
		$st = str_replace("&nbsp;", " ", $st);
		return $st;
	}
	if ($Siteman->userinfo["level"] >= 4) {
		
		if (isset($_GET["mdo"])) {
			$mdo = $_GET["mdo"];
		}
		else {
			$mdo = "default";
		}
	
		switch ($mdo) {
		
			case "savereply":
				$id = $_GET["id"];
				$db->update(array("db" => "siteman","table" => "guestbook","where" => array("id = $id"),"values" => array("reply" => global_replace($_POST["reply"]))));
				$mdo = "default";
				break 1;

			case "delete":
				$delete = $_GET["id"];
				$db->delete(array("table" => "guestbook","where" => array("id = $delete"),"db" => "siteman"));
				$mdo = "default";
				break 1;

			case "reply":
				$nav_links .= "<b> >> Ответ на сообщение</b>";
				break 1;
		}
	
	}

?>