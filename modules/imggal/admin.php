<?php
if ($Siteman->userinfo["level"] >= 4) {
	if (!isset($status)){
		$status = "������ �� �������";
	}
	switch ($mdo) {
		case "deleteimg":
			echo "<b>������� �����������:</b> ";
			$imgs = $db->select(array("table" => "ig_img","db" => "modules"));
			$cats = $db->select(array("table" => "ig_cat","db" => "modules"));
			if ($imgs[0]['name'] == ""){
				echo "<br /><br />����������� ����������� � ���� ������!<br />";
			}
			else {
				foreach ($imgs as $img) {
					echo "<form action=\"admin.php?module=imggal&amp;mdo=deleteimg\" method=\"post\">
					<table><tr><input type=\"hidden\" name=\"imgid\" value=\"".$img["id"]."\">
					<td>".$img['name']."</td><td>".$img['desc']."</td>
					<td><img src=\"".$img['link']."\" width=100 height=60></td>
					<td><table cellspacing=\"0\" cellpadding=\"1\"><tr><td><input type=\"radio\" name=\"really\" value=\"y\" /></td><td>��&nbsp;</td></tr></table></td>
					<td>&nbsp;<input type=\"submit\" value=\" ������� \" /></td></tr></table></form>";
				}
			}
		break 1;

		default:
			echo"<b>����������������� ����-�������</b><br /><br />
			<b>������� ���������:</b>";
			$cats = $db->select(array("table" => "ig_cat","db" => "modules"));
			if ($cats[0]['catname'] == ""){
				echo "����������� ��������� � ���� ������!<br />";
			}
			else {
				echo "<form action=\"admin.php?module=imggal&amp;mdo=deletecat\" method=\"post\">
				<table><tr><td><b>���������:</b></td><td><select name=\"cat_id\">";
				foreach ($cats as $cat) {
					echo "<option value=\"".$cat['id']."\">".$cat['catname']."</option>";
				}
				echo "</select></td><td><table cellspacing=\"0\" cellpadding=\"1\"><tr><td><input type=\"radio\" name=\"really\" value=\"y\" /></td><td>��&nbsp;</td>
				</tr></table></td><td>&nbsp;<input type=\"submit\" value=\" ��������� \" /></td></tr></table></form><br />";
			}
			echo "<b>������� ���������:</b>
			<form action=\"admin.php?module=imggal&amp;mdo=savecat\" method=\"post\">
			<table><tr><td>��������:</td><td><input type=\"text\" name=\"cat_name\" size=\"30\" /></td>
			<td>� ����������� �������� ��� linux-�������</td></tr>
			<tr><td>��������:</td><td><input type=\"text\" name=\"cat_desc\" size=\"30\" /></td>
			<td>��������� �������� ���������</td></tr>
			<tr><td>������� ������������, ��� ��������� ���������*:</td><td>";
			draw_levelbox($cats[0]["level"]);
			echo "</td><td></td></tr>
			<tr><td colspan=2 align=center><input type=\"submit\" value=\"���������\" /></td>
			<td>&nbsp;</td></tr></table></form><br />
			<b>�������� �����������:</b>";
			if ($cats[0]['catname'] == ""){
				echo "������� �������� ���������!<br />";
			}
			else {
				echo "<form action=\"admin.php?module=imggal&amp;mdo=saveimg\" method=\"post\">
				<table><tr><td><b>���������*:</b></td>
				<td><select name=\"catid\"><option value=\"none\" selected>����������, ��������</option>";
				foreach ($cats as $cat) {
					echo "<option value=\"".$cat['id']."\">".$cat['catname']."</option>";
				}
				echo "</select></td><td>�������� ���������</td></tr>";
				if ($failed == 0){
					echo "<tr><td>��������*:</td><td><input type=\"text\" name=\"imgname\" size=\"25\" /></td>
					<td>��� ����� �����������.</td></tr>
					<tr><td>��������:</td><td><input type=\"text\" name=\"imgdesc\" size=\"40\" /></td>
					<td>��������� �������� �����������</td></tr>
					<tr><td>URL*:</td><td><input type=\"text\" name=\"imglink\" size=\"40\" /></td>
					<td>��������������� ����� �����������.<br>��������, �� ��������� ���� ����������� 'foto.jpg' � ����� 'my_foto'.<br>����� ����� ������� ������� './my_foto/foto.jpg'</td></tr>
					<tr><td>�����:</td><td><input type=\"text\" name=\"imgposter\" size=\"20\" value=\"".$Siteman->userinfo['username']."\" /></td>
					<td>��, ��� ��� ���-��?</td></tr>";
				}
				else {
					echo"<tr><td>��������*:</td><td><input type=\"text\" name=\"imgname\" size=\"25\" value=\"".$_POST["imgname"]."\" /></td>
					<td>��� ����� �����������.</td></tr>
					<tr><td>��������:</td><td><input type=\"text\" name=\"imgdesc\" size=\"40\" value=\"".$_POST["imgdesc"]."\" /></td>
					<td>��������� �������� �����������</td></tr>
					<tr><td>URL*:</td><td><input type=\"text\" name=\"imglink\" size=\"40\" value=\"".$_POST["imglink"]."\" /></td>
					<td>��������������� ����� �����������.<br>��������, �� ��������� ���� ����������� 'foto.jpg' � ����� 'my_foto'.<br>����� ����� ������� ������� './my_foto/foto.jpg'</td></tr>
					<tr><td>�����:</td><td><input type=\"text\" name=\"imgposter\" size=\"20\" value=\"".$_POST["imgposter"]."\" /></td>
					<td>��, ��� ��� ���-��?</td></tr>";
				}
				echo"<tr><td colspan=3 align=center>&nbsp;<input type=\"submit\" value=\" ��������� \" /></td></tr></table></form><br />";
			}
			echo"<br /><a href=\"admin.php?module=imggal&amp;mdo=deleteimg\">�������� �����������</a><br /><br />������� ��� ��������������� �������� �����������:";
			if ($versionGD == 0) {
				$testGD = get_extension_funcs("gd");
				if (!$testGD) {
					echo '<br /><b>������ � GD-����������� �� �������������� �� ����� ��������...</b><br />';
				}
				else {
					echo '<br /><b>������ GD-���������� ���������� �� ����� ��������...</b><br />';
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
						echo "<br />������ � GD-����������� �� �������������� �� ����� ��������...<br />";
						$versionGD = 0;
					}
				}
			}
		break 1;
	}
	echo "<br /><div align=center>������: ". $status."<hr width=80%>������ '����-�������' (������ 1.0.7.11) ��� Siteman 2 ���������� <i>mutan</i>wulf<br />������� �� ������� ���� <a href=\"http://siteman.alfaspace.net/\" target=\"_blank\" title=\"Siteman Russian Support\">Mr. D.M.Black</a></div>";
}
?>