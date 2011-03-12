 <?php
  if (substr_count($_SERVER["SCRIPT_FILENAME"],"install.php")) {
    exit("You are not allowed to access this file directly.");
  }
  switch ($mode) {
    case "install":
  echo "<br/>Creating table <b>'badwords'</b>...".str_repeat("    ",1024);
	$db->selectdb("siteman");
	$iddef = array("type" => "int","auto_increment" => 1,"primary" => 1,"permanent" => 1);
	$string = array("type" => "string");
	if (!$db->createtable(array("table" => "badwords",
					"columns" => array("id" => $iddef,
					"word" => $string,
					"good" => $string))) ){
		echo "<br />An error occurred, txtSQL said: ".$db->get_last_error(); 
	} else {
	$db->insert(array("table" => "badwords","values" => array("word" => "fuck", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "sex", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "asshole", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "stupid", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "arsch", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "arschloch", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "penner", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "vixer", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "blödmann", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "gay", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "bitch", "good" => "love")));
	$db->insert(array("table" => "badwords","values" => array("word" => "hurre", "good" => "love")));
	echo "done.<br />badwords table is now created.";
	}
	echo"<br />You can now delete the file <b>'install.php'</b> (in the 'modules/badwords' directory) to save diskspace.";

    break 1;

    case "uninstall":
      	$db->droptable(array('db' => 'siteman', 'table' => 'badwords'));
      
    break 1;
  }
?>