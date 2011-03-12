<?php
error_reporting(E_ALL);

require_once('config.php');
require_once('function.php');

$pageOut = '=)';
if (isset($_GET['p'])){
	$p = trim($_GET['p']);
	$p = basename($p);
//$p = HTMLSpecialChar($p); -не стоит использовать в URL "<a href='test'>Test</a>" будет: &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt; 
//print '$p= '.$p;
	if ($p<>''){
		if (file_exists("pages/".$p.".php")) {
			$pageOut = file_get_contents('pages/'.$p.'.php');
		}else {
			header("Location: ".$http_full."404.php"); exit;
		}
	};
} else $pageOut = file_get_contents('pages/index.php');


include_once('theme/head.php');

?>