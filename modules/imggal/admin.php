<?php
if ($Siteman->userinfo["level"] >= 4) {
	if (!isset($status)){
		$status = "Ничего не выбрано";
	}
	switch ($mdo) {
		case "deleteimg":
			echo "<b>Удалить изображение:</b> ";
			$imgs = $db->select(array("table" => "ig_img","db" => "modules"));
			$cats = $db->select(array("table" => "ig_cat","db" => "modules"));
			if ($imgs[0]['name'] == ""){
				echo "<br /><br />Отсутствуют изображения в базе данных!<br />";
			}
			else {
				foreach ($imgs as $img) {
					echo "<form action=\"admin.php?module=imggal&amp;mdo=deleteimg\" method=\"post\">
					<table><tr><input type=\"hidden\" name=\"imgid\" value=\"".$img["id"]."\">
					<td>".$img['name']."</td><td>".$img['desc']."</td>
					<td><img src=\"".$img['link']."\" width=100 height=60></td>
					<td><table cellspacing=\"0\" cellpadding=\"1\"><tr><td><input type=\"radio\" name=\"really\" value=\"y\" /></td><td>Да&nbsp;</td></tr></table></td>
					<td>&nbsp;<input type=\"submit\" value=\" Удалить \" /></td></tr></table></form>";
				}
			}
		break 1;

		default:
			echo"<b>Администрирование фото-галереи</b><br /><br />
			<b>Удалить категорию:</b>";
			$cats = $db->select(array("table" => "ig_cat","db" => "modules"));
			if ($cats[0]['catname'] == ""){
				echo "Отсутствуют категории в базе данных!<br />";
			}
			else {
				echo "<form action=\"admin.php?module=imggal&amp;mdo=deletecat\" method=\"post\">
				<table><tr><td><b>Категория:</b></td><td><select name=\"cat_id\">";
				foreach ($cats as $cat) {
					echo "<option value=\"".$cat['id']."\">".$cat['catname']."</option>";
				}
				echo "</select></td><td><table cellspacing=\"0\" cellpadding=\"1\"><tr><td><input type=\"radio\" name=\"really\" value=\"y\" /></td><td>Да&nbsp;</td>
				</tr></table></td><td>&nbsp;<input type=\"submit\" value=\" Сохранить \" /></td></tr></table></form><br />";
			}
			echo "<b>Создать категорию:</b>
			<form action=\"admin.php?module=imggal&amp;mdo=savecat\" method=\"post\">
			<table><tr><td>Название:</td><td><input type=\"text\" name=\"cat_name\" size=\"30\" /></td>
			<td>С соблюдением регистра для linux-сервера</td></tr>
			<tr><td>Описание:</td><td><input type=\"text\" name=\"cat_desc\" size=\"30\" /></td>
			<td>Небольшое описание категории</td></tr>
			<tr><td>Уровень пользователя, для просмотра категории*:</td><td>";
			draw_levelbox($cats[0]["level"]);
			echo "</td><td></td></tr>
			<tr><td colspan=2 align=center><input type=\"submit\" value=\"Сохранить\" /></td>
			<td>&nbsp;</td></tr></table></form><br />
			<b>Добавить изображение:</b>";
			if ($cats[0]['catname'] == ""){
				echo "Сначала создайте категорию!<br />";
			}
			else {
				echo "<form action=\"admin.php?module=imggal&amp;mdo=saveimg\" method=\"post\">
				<table><tr><td><b>Категория*:</b></td>
				<td><select name=\"catid\"><option value=\"none\" selected>Пожалуйста, выберите</option>";
				foreach ($cats as $cat) {
					echo "<option value=\"".$cat['id']."\">".$cat['catname']."</option>";
				}
				echo "</select></td><td>Выберите категорию</td></tr>";
				if ($failed == 0){
					echo "<tr><td>Название*:</td><td><input type=\"text\" name=\"imgname\" size=\"25\" /></td>
					<td>Имя файла изображения.</td></tr>
					<tr><td>Описание:</td><td><input type=\"text\" name=\"imgdesc\" size=\"40\" /></td>
					<td>Небольшое описание изображения</td></tr>
					<tr><td>URL*:</td><td><input type=\"text\" name=\"imglink\" size=\"40\" /></td>
					<td>Местонаходжение файла изображения.<br>Допустим, Вы загрузили файл изображения 'foto.jpg' в папку 'my_foto'.<br>Тогда здесь следует вписать './my_foto/foto.jpg'</td></tr>
					<tr><td>Автор:</td><td><input type=\"text\" name=\"imgposter\" size=\"20\" value=\"".$Siteman->userinfo['username']."\" /></td>
					<td>Вы, или ещё кто-то?</td></tr>";
				}
				else {
					echo"<tr><td>Название*:</td><td><input type=\"text\" name=\"imgname\" size=\"25\" value=\"".$_POST["imgname"]."\" /></td>
					<td>Имя файла изображения.</td></tr>
					<tr><td>Описание:</td><td><input type=\"text\" name=\"imgdesc\" size=\"40\" value=\"".$_POST["imgdesc"]."\" /></td>
					<td>Небольшое описание изображения</td></tr>
					<tr><td>URL*:</td><td><input type=\"text\" name=\"imglink\" size=\"40\" value=\"".$_POST["imglink"]."\" /></td>
					<td>Местонаходжение файла изображения.<br>Допустим, Вы загрузили файл изображения 'foto.jpg' в папку 'my_foto'.<br>Тогда здесь следует вписать './my_foto/foto.jpg'</td></tr>
					<tr><td>Автор:</td><td><input type=\"text\" name=\"imgposter\" size=\"20\" value=\"".$_POST["imgposter"]."\" /></td>
					<td>Вы, или ещё кто-то?</td></tr>";
				}
				echo"<tr><td colspan=3 align=center>&nbsp;<input type=\"submit\" value=\" Сохранить \" /></td></tr></table></form><br />";
			}
			echo"<br /><a href=\"admin.php?module=imggal&amp;mdo=deleteimg\">Удаление изображений</a><br /><br />Функция для автоматического создания изображений:";
			if ($versionGD == 0) {
				$testGD = get_extension_funcs("gd");
				if (!$testGD) {
					echo '<br /><b>Работа с GD-библиотекой не поддерживается на Вашем хостинге...</b><br />';
				}
				else {
					echo '<br /><b>Модуль GD-библиотеки установлен на Вашем хостинге...</b><br />';
				}
				if (function_exists("imagecreatetruecolor") || function_exists("imagecreatetruecolor()")) {
					$imTest1 = @imagecreatetruecolor(12,12);
				}
				if ($imTest1) {
					echo "Der Befehl imagecreatetruecolor funktioniert auf Ihrem Server, und wird verwendet<br />";
					$versionGD = 2;
					@imagedestroy($imTest1);
				}
				else {
					if (function_exists("imagecreate") || function_exists("imagecreate()")) {
						$imTest2 = @imagecreate(12,12);
					}
					if ($imTest2) {
						echo "Der Befehl imagecreate funktioniert auf Ihrem Server, und wird verwendet<br />";
						$versionGD = 1;
						@imagedestroy($imTest2);
					}
       				else {
						echo "<br />Работа с GD-библиотекой не поддерживается на Вашем хостинге...<br />";
						$versionGD = 0;
					}
				}
			}
		break 1;
	}
	echo "<br /><div align=center>Статус: ". $status."<hr width=80%>Модуль 'Фото-галерея' (версия 1.0.7.11) для Siteman 2 разработал <i>mutan</i>wulf<br />Перевод на русский язык <a href=\"http://siteman.alfaspace.net/\" target=\"_blank\" title=\"Siteman Russian Support\">Mr. D.M.Black</a></div>";
}
?>