<?php
	if ($_REQUEST['sumito']=='si')
	{ echo $_REQUEST['cookies'].'////';
        mysql_query("UPDATE translations_template SET text = '".trim($_REQUEST['about'])."' WHERE label LIKE 'INDEX_DIALOGABOUT' ") or die('1 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".str_replace("'","\\'",$_REQUEST['terms'])."' WHERE label LIKE 'DIALOG_TERMS' ") or die('2 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".str_replace("'","\\'",$_REQUEST['privacity'])."' WHERE label LIKE 'DIALOG_PRIVACITY' ") or die('3 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".trim($_REQUEST['developers'])."' WHERE label LIKE 'DIALOG_DEVELOPERS' ") or die('4 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".trim($_REQUEST['help'])."' WHERE label LIKE 'DIALOG_HELP' ") or die('5 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".str_replace("'","\\'",$_REQUEST['cookies'])."' WHERE label LIKE 'DIALOG_COOKIES' ") or die('6 - '.mysql_error());
        mysql_query("UPDATE translations_template SET text = '".trim($_REQUEST['paypal'])."' WHERE label LIKE 'INDEX_DIALOGPAYPAL' ") or die('7 - '.mysql_error());
		mensajes("Processed Sucessfully", "index.php?url=vistas/dialogs.view.php");
	}
	
	$query = mysql_query("SELECT * FROM dialogs WHERE id = '1'") or die (mysql_error());
	$array = mysql_fetch_assoc($query);

    $sc = 0;
    if(isset( $_GET['sc'] )) $sc = $_GET['sc'];
?>
<fieldset>
    <legend>System Messages</legend>
    <form id="frmGetUrTag" name="frmGetUrTag" method="post" action="">
        <table id="configsDialogs" width="650" border="0" align="center" cellpadding="2" cellspacing="2">
            <tr class="dialog" id="trAbout">
                <td style="height:310px" valign="top">
                    About
                    <?php 
                        $oFCKeditor = new FCKeditor('about') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value    = campo('translations_template', 'label', $array['about'], 'text');  
                        $oFCKeditor->Create();
                    ?>
                </td>
            </tr>
            <tr class="dialog" id="trCookies">
                <td style="height:310px" valign="top">
                    Cookies
                    <?php 
                        $oFCKeditor = new FCKeditor('cookies') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value    = campo('translations_template', 'label', $array['cookies'], 'text');

                        $oFCKeditor->Create();
                    ?> 
                </td>
            </tr>
            <tr class="dialog" id="trDevelopers">
                <td style="height:310px" valign="top">
                    Developers
                    <?php 
                        $oFCKeditor = new FCKeditor('developers') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value	  = campo('translations_template', 'label', $array['developers'], 'text');
                        $oFCKeditor->Create();
                    ?> 	
                </td>
            </tr>
            <tr class="dialog" id="trHelp">
                <td style="height:310px" valign="top">
                    Help
                    <?php 
                        $oFCKeditor = new FCKeditor('help') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value	  = campo('translations_template', 'label', $array['help'], 'text'); 
                        $oFCKeditor->Create();
                    ?> 
                </td>
            </tr>
            <tr class="dialog" id="trTerms">
                <td style="height:310px" valign="top">
                    Terms
                    <?php 
                        $oFCKeditor = new FCKeditor('terms') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value	  = campo('translations_template', 'label', $array['terms'], 'text'); 
                        $oFCKeditor->Create();
                    ?> 	
                </td>
            </tr>
            <tr class="dialog" id="trPrivacity">
                <td style="height:310px" valign="top">
                    Privacity
                    <?php 
                        $oFCKeditor = new FCKeditor('privacity') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value	  = campo('translations_template', 'label', $array['privacity'], 'text'); 
                        $oFCKeditor->Create();
                    ?>	
                </td>
            </tr>
            <tr class="dialog" id="trPaypal">
                <td style="height:310px" valign="top">
                    Paypal Message (Business Account)
                    <?php 
                        $oFCKeditor = new FCKeditor('paypal') ;
                        $oFCKeditor->BasePath = 'fckeditor/';
                        $oFCKeditor->Width    = '650';
                        $oFCKeditor->Height   = '300';
                        $oFCKeditor->Value    = campo('translations_template', 'label', $array['paypal'], 'text'); 
                        $oFCKeditor->Create();
                    ?>  
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <input name="sumito" type="hidden" id="sumito" value="si" />
                    <input type="submit" name="button" id="button" value="Submit" />
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </form>
</fieldset>