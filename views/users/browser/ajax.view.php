<?php
	  include ("../../../includes/session.php");
	  include ("../../../includes/functions.php");
	  include ("../../../includes/config.php");
	  include ("../../../class/wconecta.class.php");
	  include ("../../../includes/languages.config.php");
	
	  switch ($_GET[brower_type]){
	          case 1: $friends = view_friends('',$_GET[like]); 
			          
			  break;
	  }
	  
	  
	  while ($friend = mysql_fetch_assoc($friends)){
			 $query = $GLOBALS['cn']->query("SELECT u.username AS username,
													(SELECT a.name FROM countries a WHERE a.id=u.country) AS pais,
													u.followers_count AS followers,
													u.friends_count AS friends 
											 FROM users u 
											 WHERE u.id = '".$friend[id_friend]."'");
											 
			 $array = mysql_fetch_assoc($query);
			 
			 $id_layer = md5($friend[id_friend]);
?>
                <li>
                    <div>
                        <strong style="color:#E78F08"><?=$friend[name_user]?></strong><br/>
                        <?php if (trim($array[username])!=''){ ?>
                        
						<?=USERS_BROWSERFRIENDSLABELEXTERNALPROFILE?>:&nbsp;<span><a href="<?=DOMINIO.$array[username]?>" onFocus="this.blur();" target="_blank"><?=DOMINIO.$array[username]?></a></span><br>
                        
						<?php } 
                              if (trim($array[pais])!=''){
                        ?>
                        
						<?=USERS_BROWSERFRIENDSLABELCOUNTRY?>:&nbsp;<span><?=$array[pais]?></span><br/>
                        
						<?php  } ?>
                        
                        <?=USERS_BROWSERFRIENDSLABELFRIENDS?>(<?=$array[friends]?>),&nbsp;<?=USERS_BROWSERFRIENDSLABELADMIRERS?>(<?=$array[followers]?>)
                    
                    </div>
                    <img src="<?=FILESERVER.getUserPicture($friend['code_friend']."/".$friend['photo_friend'])?>" border="0" width="60" height="60" />
                    <p>
                        <?php 
						     if (@in_array($friend[id_friend], $_SESSION['ws-tags']['lstUsrBrowser'])){
							     $checked = 'checked="checked"';
							 }else{
							     $checked = '';
							 }
						?>
                        
                        <input type="checkbox" <?=$checked?> id="chkLstUsersBroswer_<?=$id_layer?>"  name="chkLstUsersBroswer_<?=$id_layer?>" value="<?=$id_layer?>" />
                        <label for="chkLstUsersBroswer_<?=$id_layer?>"><?=USERS_BROWSERFRIENDSLABELBTNINVITE?></label>
                        
                        <script type="text/javascript">
                        $(document).ready(function(){
                            
                            //$("#chkLstUsersBroswer_<?=$id_layer?>").button();							
							
                        });
                        </script>
                    </p> 
                </li>
                <?php      
                      }//while friends
                ?>
