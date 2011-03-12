<?php
	if ($Siteman->userinfo["level"] >= 4) {
	
		switch ($mdo) {
		case "help":
			echo "<h4>Как использовать функцию:</h4>
				As a modul it easy to use the badword-db.<br/>
				You have only to add these code lines in the modul:<br/><br />";
		  echo "<table width=550 height=70 ><tr><td>function Badwordcutter(&#36;text) &#123;<br/>
            <div style='margin-left: 40px;'>&nbsp;global &#36;db;<br/>
            &nbsp;&#36;badwords = &#36;db-&gt;select(array(&quot;table&quot; =&gt; &quot;badwords&quot;,&quot;db&quot; =&gt; &quot;siteman&quot;));<br/>
            &nbsp;foreach(&#36;badwords as &#36;badword) {<br/>";
      echo "<div style='margin-left: 40px;'>&nbsp;&#36;text = str_replace(&#36;badword[&quot;word&quot;], &#36;badword[&quot;good&quot;], &#36;text);<br/>
            </div>}<br/>
            return &#36;text;<br/>
            </div>
						}</td></tr></table>";
      echo "<br />Now you can use the function with:<br /><br />        		
						<b>&#36;text = Badwordcutter(&#36;textbad);</b><br /><br />
						In &#36;textbad is the text that have to be check.";
			break 1;
		default:
		  	$words = $db->select(array("table" => "badwords","db" => "siteman"));
				echo"<h4>Цензура</h4><br />
				Чтобы удалить одно или несколько запрещённых в Гостевой книге сайта слов - просло удалите ненужное слово (очистите строчку со словом и заменой), и нажмите 'Сохранить список'.<br /><br /><br />
				<form action=\"admin.php?module=badwords&amp;mdo=savebw\" method=\"post\">
				<table cellspacing=\"0\" cellpadding=\"1\"><tr><td></td><td>Запрещённые слова:</td><td>Замена:</td></tr>";
				foreach ($words as $word) {
					echo"<tr><td></td>
					<td><input type=\"text\" name=\"word[".$word["id"]."]\" size=\"30\" value=\"".$word["word"]."\" /></td><td><input type=\"text\" name=\"good[".$word["id"]."]\" size=\"30\" value=\"".$word["good"]."\" /></td></tr>";
				}
				echo"<tr><td>Новое слово</td><td><input type=\"text\" name=\"neword\" size=\"30\" /></td><td><input type=\"text\" name=\"newgood\" size=\"30\" /></td></tr><tr><td>&nbsp;</td><td colspan=2>&nbsp;</td></tr>
				<tr><td colspan=\"3\" align=\"right\"><input type=\"submit\" value=\"Сохранить список\" /></td></tr></table></form>";
				echo "<br /><br /><a href='admin.php?module=badword&amp;mdo=help'>How to use</a>";
				break 1;

		}
	}
?>