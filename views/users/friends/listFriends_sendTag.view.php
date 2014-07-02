<?php session_start(); ?>
<link type="text/css" rel="stylesheet" href="js/fcbkListSelection/fcbklistselection.css" />
<script type="text/javascript" src="js/fcbkListSelection/fcbklistselection.js"></script>
<script type="text/javascript" language="JavaScript">
    $(document).ready(function() {
      //id(ul id),width,height(element height),row(elements in row)
      $.fcbkListSelection("#fcbklist","570","90","4");
      });
</script>

<?php
	 include ("../../includes/functions.php");
	 include ("../../includes/config.php");
	 include ("../../class/wconecta.class.php");
	 include ("../../includes/languages.config.php");

	 $friends    = view_friends();
	// $followers  = followers();
	// $followings = following();

	//echo $_GET['adds'];
?>

<ul id="fcbklist">
	<?php
		while($friend=mysql_fetch_assoc($friends)){
			if($friend['email']!=''){
	?>
	<li onclick="actionCheckbox_listFriends('chk_friend_<?=$friend['id_friend']?>','#list_mail');">
		<strong><?=$friend[name_user]?></strong><br/>
		<span class="fcbkitem_text">
			<img src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'])?>" border="0" width="60" height="60" style=" margin:3px;border:1px solid #6DA916;background-color:#D3ED72;padding:3px;"/>
		</span>
		<input type="checkbox"  id="chk_friend_<?=$friend['id_friend']?>"  name="chk_friend_<?=$friend['id_friend']?>" value="<?=$friend['email']?>" style="display:none" <?php if(strpos('  '.$_GET['adds'],$friend['email'])){?> checked="checked"<?php }?> />
	</li>
	<?php
			}
		}
	?>
</ul>
<input name="hiddenLstMails" id="hiddenLstMails" type="hidden" value=""/>
<a href="javascript:void(0);" id="selectAll">All</a>
