<?php
if ($Siteman->userinfo["level"] >= 4) {
	if (!isset($lang_status)){
		$lang_status = "Ничего не выбрано";
	}
	echo "<b>Редактирование языковой базы данных</b><br /><br />";
	switch ($mdo) {
		case "edit":
			echo "<form action=\"admin.php?module=language&amp;mdo=save\" method=\"post\">
			<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">";
			foreach ($lang as $languse) {
				if ($languse["section"] != $old_section) {
					echo "<td align=\"center\" colspan=\"2\">Расположение: <b>".$languse["section"]."</b></td></tr>
					<tr><td>".$languse['key']."</td>";			
				}
				else { 
					echo "<tr><td>".$languse["key"]."</td>";		
				}
				echo "<td><input type=\"text\" name=\"action[".$languse['key']."]\" size=\"70\" value=\"".htmlspecialchars($languse['phrase'])."\" /></td></tr>";
				$old_section = $languse["section"];	
			}
			echo "<tr><td align=\"center\" colspan=\"2\">Использовать языковую базу: <input type=\"text\" name=\"langdb\" size=\"5\" value=\"".$_POST["language"]."\" readonly=\"true\" />
			&nbsp;&nbsp;<input type=\"submit\" value=\"Сохранить\" /></td></tr></table></form>
			<br />Пожалуйста, дождитесь окончания записи новых данных в базу!";			
		break 1;

		case "save":
			echo "Языковая база данных обновлена<br />Теперь вы можете использовать одну из этих:";
		break 1;

		default:
			echo "<form action=\"admin.php?module=language&amp;mdo=edit\" method=\"post\">
			<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\">
			<tr><td><b>Язык</b></td>
			<td><select name=\"language\">";
			foreach ($langs as $lang) {
				if ($lang == $Siteman->settings["language"]) {
					$selected = " selected";
				}
				else {
					$selected = "";
				}
				echo"<option value=\"$lang\"".$selected.">$lang</option>";
			}
			echo"</select></td></tr>			
			<tr><td colspan=2><input type=\"submit\" value=\"Редактировать\" /></td></tr></table></form><br />";
			echo "<form action=\"admin.php?module=language&amp;mdo=create\" method=\"post\">
			<table cellspacing=\"0\" cellpadding=\"2\" border=\"1\">
			<tr><td><b>Краткое обозначение</b>:</td>
			<td><input type=\"text\" name=\"new_lang\" size=\"5\"/ value=\"Новый\"></td></tr>
			<tr><td colspan=2 align=\"center\">Например: de, uk, ru...<br /><a href=\"#\" onClick=\"window.open('./modules/language/lancode.php','','width=300, height=450, left=150, top=50, scrollbars=yes, resizable=no');\">Коды языков</a></td></tr>		
			<tr><td colspan=2 align=\"center\"><input type=\"submit\" value=\"Создать\" /></td></tr></table></form><br />";
		break 1;

	}
	echo "<br /><div align=center>Статус: ".$lang_status."<hr width=80%>Модуль 'Администрирование языковой базы данных' (версия 1.0.1) для Siteman 2 разработал <i>cyber</i>wulf<br />Перевод на русский язык <a href=\"http://siteman.alfaspace.net/\" target=\"_blank\" title=\"Siteman Russian Support\">Mr. D.M.Black</a></div>";
}
?>