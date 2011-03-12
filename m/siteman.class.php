<?php
@error_reporting(E_ERROR | E_PARSE);

if (substr_count($_SERVER["SCRIPT_NAME"],"admin.php") == 0) {
	$remote = explode(".",$_SERVER["REMOTE_ADDR"]);
	$newip = "";
	foreach ($remote as $base) {
		$hex = dechex($base);
		if (strlen($hex) == 1) {
			$newip .= "0";
		}
		$newip .= $hex;
	}
	$saved = $db->select(array("table" => "banned","db" => "siteman","where" => array("ip = $newip")));
	if (strlen($saved[0]["ip"]) > 0) {
		if ($_GET["savecomplain"]) {
			$db->update(array("table" => "banned","db" => "siteman","where" => array("ip = $newip"),"values" => array("reply" => htmlspecialchars(stripslashes(substr($_POST["reply"],0,500))))));
			$saved[0]["reply"] = htmlspecialchars(stripslashes(substr($_POST["reply"],0,500)));
		}
		echo"<b><big>Внимание!</big></b><br /><br /><br />
		Администратор закрыл доступ к сайту для данного IP-адреса. Причина:<br /><br />
		<b>".$saved[0]["reason"]."</b><br /><br />
		Если Вам есть, что доступ закрыт безосновательно, напишите об этом Администрации сайта (максимум 500 символов).<br />Вы можете редактировать своё сообщение в любое время.<br /><br />
		<form action=\"index.php?savecomplain=1\" method=\"post\">
		<table cellspacing=\"0\" cellpadding=\"2\"><tr><td><textarea name=\"reply\" rows=\"10\" cols=\"60\">".$saved[0]["reply"]."</textarea></td></tr>
		<tr><td><input type=\"submit\" value=\"Отправить\" /></td></tr></table></form>";
		exit;
	}
}

class Website {

	var $loginok;
	var $userinfo;
	var $settings;
	var $content;
	var $version;
	var $loginmessage;
	var $loginerror;
	var $lang;
	var $loadstart;

	function Website($version) {
		$start = explode(" ",microtime());
		$startmsec = explode(".",$start[0]);
		$this->loadstart = $start[1] . substr($startmsec[1],0,3);
		global $db;
		$db->selectdb("siteman");
		$settings = $db->select(array("table" => "settings","db" => "siteman"));
		$this->settings = $settings[0];
		$this->level = 1;
		$this->version = $version;
		$identifier = $this->settings["identifier"];
		$this->loginok = 0;
		$this->userinfo["level"] = 1;
		$this->load_lang("general");
		if ($_GET["action"] == "login") {
			$this->login(0,$_POST["username"],$_POST["password"],$_POST["remember"]);
		}
		else if ($_GET["action"] == "logout") {
			$this->logout();
		}
		else if (isset($_COOKIE[$identifier])) {
			$info = explode(":",$_COOKIE[$identifier]);
			$this->login($info[0],"",$info[1],$info[2]);
		}
	}

	function login($id,$username,$password,$remember) {
		global $db;
		if ($id == 0) {
			$where = array("strLower(username) = ".strtolower($username));
		}
		else {
			$where = array("id = $id");
		}
		$userinfo = $db->select(array("table" => "users","db" => "siteman","where" => $where));
		if (strlen($userinfo[0]["username"]) > 0) {
			if ($userinfo[0]["level"] > 1) {
				if (md5($password) == $userinfo[0]["password"]) {
					$this->loginok = 1;
					$this->userinfo = $userinfo[0];
					$db->update(array("table" => "last_online","db" => "siteman","where" => array("id = ".$this->userinfo["id"]),"values" => array("last_online" => time())));
					$cookiedata = $this->userinfo["id"] . ":" . $password . ":" . $remember;
					if ($remember) {
						$this->cookie($this->settings["identifier"],$cookiedata,time()+604800);
					}
					else {
						$this->cookie($this->settings["identifier"],$cookiedata);
					}
				}
				else {
					$this->loginerror = "wrongpass";
				}
			}
			else {
				$this->loginerror = "notvalidated";
			}
		}
		else {
			$this->loginerror = "usernotfound";
		}
	}

	function logout() {
		$this->cookie($this->settings["identifier"],"");
		$this->loginok = 0;
	}

	function cookie($name,$value,$expires = 0) {
		if ((@setcookie($name,$value,$expires)) === FALSE) {
			echo"<script language=\"Javascript\" type=\"text/javascript\">
			var expire = new Date();
			expire.setTime(".$expires."000);
			document.cookie = \"".$name."=".$value;
			if ($expires > 0) {
				echo";expires=\"+expire.toGMTString()";
			}
			else {
				echo"\"";
			}
			echo";
			</script>";
		}
	}

	function load_lang($section) {
		global $db;
		if ($this->settings['multi_lang'] == 1) {
			$site_lang = (isset($_COOKIE['siteman_lang']) && $db->table_exists($_COOKIE['siteman_lang'],"language")) ? $_COOKIE['siteman_lang'] : $this->settings["language"];
			$data = $db->select(array("table" => $site_lang,"db" => "language","where" => array("section = $section")));
		}
		else {
			$data = $db->select(array("table" => $this->settings["language"],"db" => "language","where" => array("section = $section")));
		}
		foreach ($data as $line) {
			$key = $line["key"];
			$this->lang[$key] = $line["phrase"];
		}
	}

	function load_lang_list($imdir = './public/images/flags/') {
		global $db;
		$lang_tbs = $db->showtables(array('db' => 'language'));
		if (($this->settings['multi_lang'] == 1) && (count($lang_tbs) >= 2)) {
			foreach ($lang_tbs as $lang_im) {
				echo (file_exists($imdir.$lang_im.'.gif')) ? '<a href="index.php?lang='.$lang_im.'"><img src="'.$imdir.$lang_im.'.gif" border="0" alt="'.ucwords($lang_im).'" /></a>' : '<b><a href="index.php?lang='.$lang_im.'" title="'.ucwords($lang_im).'">'.ucwords($lang_im).'</a></b>';
			}
		}
	}

	function show_loginbox($linear = 0,$origin = "index.php") {
		global $db;
		$this->load_lang("users");
		$this->load_lang("levels");
		if ($origin == "index.php") {
			$origin .= "?module=".$this->settings["module"]."&amp;action=login";
		}
		else {
			$origin .= "?action=login";
		}
		$newip = $_SERVER["REMOTE_ADDR"];
		$times = time()-300;
		$db->delete(array("table" => "online","db" => "siteman","where" => array("time < ".$times)));
		if ($this->loginok) {
			$db->delete(array("table" => "online","db" => "siteman","where" => array("ip = ".$newip)));
			$level = $this->userinfo["level"];
			echo"<table cellspacing=\"0\" cellpadding=\"2\"><tr><td>".str_replace("%user%",$this->userinfo["username"],$this->lang["welcome"])."</td></tr>
			<tr><td>".str_replace("%level%",$level." (".str_replace($level,$this->lang[$level],$level).")",$this->lang["yourlevel"])."</td></tr>";
			if ($this->userinfo["level"] >= 4) {
				if ($this->settings["user_validation"]) {
					$need = $db->select(array("table" => "users","db" => "siteman","where" => array("level = 1")));
					if (isset($need[0]["username"])){
						echo"<tr><td>".str_replace("%users%",count($need),$this->lang["needvalidation"])."</td></tr>";
					}
				}
			}
			echo"<tr><td><a href=\"index.php?module=users\">".$this->lang["myaccount"]."</a></td></tr>
			<tr><td><a href=\"index.php?module=users&amp;do=mlist\">".$this->lang["mlist"]."</a></td></tr>";
			if ($this->userinfo["level"] >= 3) {
				echo"<tr><td><a href=\"admin.php\" target=\"_blank\">Админ-панель</a></td></tr>";
			}
			echo"<tr><td><a href=\"index.php?module=".$this->settings["module"]."&amp;action=logout\">".$this->lang["logout"]."</a></td></tr></table>";
		}
		else {
			$oldip = $db->select(array("table" => "online","db" => "siteman","where" => array("ip = ".$newip)));
			if (!isset($oldip[0]["time"])){
				$db->insert(array("table" => "online","db" => "siteman","values" => array("ip" => $newip,"time" => time())));
			}
			else {
				$db->update(array("table" => "online","db" => "siteman","where" => array("ip = ".$newip),"values" => array("time" => time())));
			}
			if (!$linear) {
				echo"<form action=\"".$origin."\" method=\"post\">
				<table cellspacing=\"0\" cellpadding=\"2\">";
				if (strlen($this->loginerror) > 0) {
					echo"<tr><td colspan=\"2\">".$this->lang[$this->loginerror]."</td></tr>";
				}
				echo"<tr><td colspan=\"2\" align=\"center\"><a href=\"index.php?module=users&amp;do=register\">".$this->lang["register"]."</a></td></tr>
				<tr><td>".$this->lang["username"].":</td><td><input type=\"text\" name=\"username\" size=\"12\" /></td></tr>
				<tr><td>".$this->lang["password"].":</td><td><input type=\"password\" name=\"password\" size=\"12\" /></td></tr>
				<tr><td colspan=\"2\" align=\"center\">".$this->lang["remember"]." &nbsp;<input type=\"checkbox\" name=\"remember\" value=\"1\" /></td></tr>
				<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"".$this->lang["login"]."\" /></td></tr>
				<tr><td colspan=\"2\" align=\"center\"><a href=\"index.php?module=users&amp;do=forgotpass\">".$this->lang["forgotpass"]."</a></td></tr></table></form>";
			}
		}
	}

	function show_menu($prefix = "",$width = "100%",$class = "menu") {
		global $db;
		$menu = $db->select(array("table" => "menu","db" => "siteman"));
		echo"<table width=\"$width\" cellspacing=\"0\" cellpadding=\"2\">";
		foreach ($menu as $lines) {
			$lv = $lines["level"];
			if ($this->userinfo["level"] >= $lv) {
				$link_target = ($lines['target'] == 1) ? ' target="_blank"' : '';
				echo"<tr><td class=\"$class\">";
				if ($lines["action"] == "[text]") {
					echo $lines["text"];
				}
				else if (substr($lines["action"],0,14) == "[module:pages:") {
					$md = explode(":",$lines["action"]);
					echo"<a href=\"".$prefix."index.php?module=pages&amp;page=".str_replace("]","",$md[2])."\" ".$link_target.">".$lines["text"]."</a>";
				}
				else if (substr($lines["action"],0,8) == "[module:") {
					$md = explode(":",$lines["action"]);
					echo"<a href=\"".$prefix."index.php?module=".str_replace("]","",$md[1])."\" ".$link_target.">".$lines["text"]."</a>";
				}
				else if ($lines["action"] == "[line]") {
					echo"<hr />";
				}
				else if ($lines["action"] == "[members]") {
					$this->show_loginbox();
				}
				else {
					echo"<a href=\"".$lines["action"]."\" ".$link_target.">".$lines["text"]."</a>";
				}
				echo"</td></tr>";
			}
		}
		echo"</table>";
	}

	function get_loadtime() {
		$start = $this->loadstart;
		$now = explode(" ",microtime());
		$nowmsec = explode(".",$now[0]);
		$nowtime = $now[1] . substr($nowmsec[1],0,3);
		$diff = ($nowtime-$start)/1000;
		return $diff;
	}

}
?>