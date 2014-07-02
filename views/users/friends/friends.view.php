<?php
if(isset($_POST[asyn])){

	include ("../../includes/session.php");
	include ("../../class/Mobile_Detect.php");
	include ("../../includes/config.php");
	include ("../../includes/functions.php");
	include ("../../class/wconecta.class.php");
	include ("../../includes/languages.config.php");
	include ("../../class/forms.class.php");

}
?>
<script>
	$(function()
	{
		$("#tabs").tabs({
			select: function(event, ui) {
			var tabID = "#"+ui.panel.id;
			$(tabID).html('<div id="loading"><img src="img/loader.gif" width="32" height="32" /></div>');
		}
		});
		<?php

			if( isset($_GET[find]) )
			{?>	$("#tabs").tabs( "select" , 1 );
<?php		}

			if( isset($_GET[redirected]) )
			{?>
				$('#txtBusAll').val("");
				<?php $param= "views/users/findFriendsView.php?current=".$_GET[current]."&redirected&dato=".$_GET[dato];?>
				$( "#tabs" ).tabs( "select" , 1 );<?php
			} else {
				$param= "views/users/findFriendsView.php";
			} ?>


			splitted = document.location.hash.split('_');

			if (splitted[1]!=''){
			    $( "#tabs" ).tabs( "select" , 1 );

			    $('#txtSearch').focus();
			}

	});
</script>

<?php $frm = new forms(); ?>

<div id="ws_content" style="font-size:11px; margin-left:5px; padding-top:10px; width:898px; height:405px">
    <div id="tabs" style="margin-left:5px; margin-right:5px; height:450px">
        <ul>
            <li><a href="views/users/yourFriendsView.php"><?=MAINMNU_FINDFRIENDS?></a></li>
            <li><a href="views/users/findFriendsView.php?dato=<?=$_GET[dato]?>"><?=EDITFRIEND_VIEWTAB1?></a></li>
            <li><a href="views/users/inviteFriends.view.php"><?=EDITFRIEND_VIEWTAB2?></a></li>
            <li><a href="views/users/addressBook.view.php"><?=ADDRESSBOOK_VIEWTAB3?></a></li>
        </ul>
	</div>
</div>