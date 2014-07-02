<?php
	if ($_REQUEST['sumito']=='si')
	{
		$insert = mysql_query("	UPDATE dialogs SET	developers = '".$_REQUEST['developers']."',
                                                    cookies = '".$_REQUEST['cookies']."',
                                                    about = '".$_REQUEST['about']."',
													help       = '".$_REQUEST['help']."',
													terms      = '".$_REQUEST['terms']."',
													privacity  = '".$_REQUEST['privacity']."',
                                                    paypal     = '".$_REQUEST['paypal']."'
								WHERE id = '1' ") or die (mysql_error());

		  mensajes("Processed Sucessfully", "index.php?url=vistas/dialogs.view.php");
	}
	
	$query = mysql_query("SELECT * FROM dialogs WHERE id = '1'") or die (mysql_error());
	$array = mysql_fetch_assoc($query);

    $sc = 0;
    if(isset( $_GET['sc'] )) $sc = $_GET['sc'];
?>
<fieldset>
    <form style="display: inline-block;">
        <div id="option-list">
            Modify:
            <select name="pageoption" id="pageoption">
                <option value="trAbout">About</option>
                <option value="trCookies">Cookies</option>
                <option value="trDevelopers">Developers</option>
                <option value="trHelp">Help</option>
                <option value="trTerms">Terms</option>
                <option value="trPrivacity">Privacy</option>
                <option value="trPaypal">Paypal Message (Business Account)</option>
            </select>
        </div>
    </form><br><br>
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
                        $oFCKeditor->Value    = $array['about'];
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
                        $oFCKeditor->Value    = $array['cookies'];

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
                        $oFCKeditor->Value	  = $array['developers'];
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
                        $oFCKeditor->Value	  = $array['help'];
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
                        $oFCKeditor->Value	  = $array['terms'];
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
                        $oFCKeditor->Value	  = $array['privacity'];
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
                        $oFCKeditor->Value    = $array['paypal'];
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
<script>
    // var j = $.noConflict();t

    window.onload=function() {
        var sc = <?=$sc?>;

        var eles = document.getElementById('configsDialogs').getElementsByTagName('tr');
        for (var i = 0; i < eles.length-2; i++) {
            eles[i].style.display = 'none';
        };
        
        var lista = document.getElementById('pageoption');
        lista.selectedIndex = sc;
        var sel = lista.options[sc].value;
        // console.log('Esto es lo que tengo:'+sel);

        document.getElementById(sel).style.display = 'table-row';

        document.getElementById('pageoption').onchange = function(){
            console.log('ocultare:'+sel);
            document.getElementById(sel).style.display = 'none';

            sc = this.selectedIndex;
            sel = this.options[sc].value;
            document.getElementById(sel).style.display = 'table-row';
        }
    };

    // j(document).ready(function($) {
    //     var sc = <?=$sc?>;
    //     // j('#configsDialogs .dialog').hide();
    //     // var sel = j('#pageoption').prop('selectedIndex', sc).val();
    //     // $('#'+sel).show();

    //     // j('#pageoption').change(function(){
    //     //     $(this).each(function( i ){
    //     //         j( '#configsDialogs .dialog' ).hide(); 
    //     //     });

    //     //     var sel = j(this).val();
    //     //     $('#'+sel).show('fast');
    //     // });
    //     // 
    //     // 
        
    // });
</script>