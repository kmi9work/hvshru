<?php
		if ($Siteman->userinfo["level"] >= 4) {
		
		if (isset($_GET["mdo"])) {
			$mdo = $_GET["mdo"];
		}
		else {
			$mdo = "default";
		}
	
		switch ($mdo) {
		
			case "savebw":
				$words = $db->select(array("table" => "badwords","db" => "siteman"));
				foreach ($words as $word) {
					$id = $word["id"];
					if (strlen($_POST["word"][$id]) == 0) {
						$db->delete(array("table" => "badwords","db" => "siteman","where" => array("id = $id")));
					}
					else {
						$db->update(array("table" => "badwords","db" => "siteman","where" => array("id = $id"),"values" => array("word" => $_POST["word"][$id],"good" => $_POST["good"][$id])));
					}
				}
				if (strlen($_POST["neword"]) > 0) {
					$db->insert(array("table" => "badwords","db" => "siteman","values" => array("word" => $_POST["neword"],"good" => $_POST["goodword"])));
				}
				$mdo = "badwords";
				$nav_links .= "<b> >> Запрещённые слова</b>";
			break 1;

		}
	
	}

?>