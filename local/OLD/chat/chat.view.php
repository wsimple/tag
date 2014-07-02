<?php if($_SESSION['ws-tags']['ws-user'][id]!=""){?>
<link type="text/css" rel="stylesheet" media="all" href="chat/css/chat.css" />


 <div id="chatMainContainer"  >
    
 	<div class="chatListContainer" style=" <?=$_SESSION['ws-tags']['ws-user'][status_chat]!='1' ?'display:none;':'' ?> ">   

  </div>
  <div class="chatConfig">
  	<img src="img/ninimize.png" width="16" height="16" id="hideChat" style=" <?=$_SESSION['ws-tags']['ws-user'][status_chat]!='1' ?'display:none;':'' ?> " />
    <img src="img/maximize.png" width="16" height="16" id="showChat" style="display:none;" />
    <input name="online" type="button" id="online" value="Go online" style=" <?=$_SESSION['ws-tags']['ws-user'][status_chat]!='1' ?'':'display:none;' ?> "/>
    <input name="offline" type="button" id="offline" value="Go offline" style=" <?=$_SESSION['ws-tags']['ws-user'][status_chat]!='1' ?'display:none;':'' ?> "/>  
  </div>
</div>

<script type="text/javascript" src="chat/js/chat.js"></script>
<script type="text/javascript" >
	$(document).ready(function(){
			
			
			
			
		<?=$_SESSION['ws-tags']['ws-user'][status_chat]!='1' ?'':'startChatSession();listFriendsChat(1);' ?>	
	
	
	
	
			
});		

</script>
<?php }?>
