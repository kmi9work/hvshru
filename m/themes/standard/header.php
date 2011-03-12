<table width="96%" border="0" align="center" cellpadding="4" cellspacing="4">
  <tr>
    <td height="66">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right"><img src="themes/<?php echo $Siteman->settings["theme"]; ?>/headleft.jpg" width="36" height="58"></td>
          
          <td width="100%" height="58" background="themes/<?php echo $Siteman->settings["theme"]; ?>/headmid.jpg"><font color="#666666" size="+3" face="Verdana, Arial, Helvetica, sans-serif">site<strong>man</strong></font><font color="#666666" size="+2" face="Verdana, Arial, Helvetica, sans-serif"><sup>2</sup></font></td>
          <td><img src="themes/<?php echo $Siteman->settings["theme"]; ?>/headright.jpg" width="36" height="58"></td>
        </tr>
      </table></td>
  </tr>
</table>

<table width="95%" cellspacing="0" align="center" cellpadding="4">
  <tr>
    <td width="26%" valign="top"> 
      <table width="100%"  cellpadding="0" cellspacing="0" class="border" >
        <tr> 
          <td > 
            <table width="100%"  cellpadding="0" cellspacing="1">
              <tr> 
                <td > <table cellspacing="0" cellpadding="1" width="100%">
                    <tr> 
                      <!-- Code to show the menu -->
                      <td class="menu-header" align="right"> Μενώ </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="menu"><?php $Siteman->show_menu(); ?></td>
                    </tr>
                    <tr > 
                      <td colspan="2" class="menu-footer" align="center"><?php $Siteman->show_loginbox(); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td width="74%" valign="top" >
	<table width="100%" cellpadding="0" cellspacing="0" class="border" >
        <tr> 
          <td> <table width="100%" cellspacing="1" cellpadding="0">
              <tr> 
                <td > <table width="100%" cellspacing="0" cellpadding="1">
                    <tr> 
                      <!-- Code to show the menu -->
                      <td class="content-header" > <?php echo $Siteman->content; ?> </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="content" > 
                        <!-- content start -->