<?php

    include ("includes/session.php");
	include ("includes/config.php");
	include ("includes/functions.php");
	include ("class/wconecta.class.php");

	$tags = $GLOBALS['cn']->query(" SELECT t.id AS id,
	                                       
										   (select concat(a.name,' ',a.last_name) from users a where a.id=t.id_user) AS user,
										   
										   (select concat(b.name,' ',b.last_name) from users b where b.id=t.id_creator) AS creator,
										   
										   t.background AS fondo,
										   
										   t.id_user AS id_user,
										   
										   t.id_creator AS id_creator,
										   
										   t.code_number AS code,
										   
										   t.text AS text,
										   
										   t.text2 AS text2
										   
									FROM tags t
									
									WHERE t.background LIKE 'defaults/%'
									
									ORDER BY t.id_user
	                              
								  ");
    
	$folders = array("defaults/", "defaults/Abstract/", "defaults/Fashion/", "defaults/Music/", "defaults/Politics/", "defaults/Sports/", "defaults/tvAndMovies/", "defaults/thanksgiven/", "defaults/holiday/");
    
	$cont = 1;
	
	foreach ($folders as $folder){
		
		     while ($tag = mysql_fetch_assoc($tags)){
				    
					$aux = explode('/', $tag[fondo]);
					
					$pic = end($aux);
	                
					if (!file_exists("img/templates/".$folder.$pic) && $tag[fondo]==$folder.$pic){
		   
					    echo "Tag: ".$tag[id]."<br>
							  User (".$tag[id_user]."): ".$tag[user]."<br>
							  Creator (".$tag[id_creator]."): ".$tag[creator]."<br>
							  Text: ".$tag[text]."<br>
							  Code: ".$tag[code]."<br>
							  Text: ".$tag[text2]."<br>
							  Fondo: ".$folder.$pic." <br>---<br><br>";
			        
					   $cont++; 
					}
	         }
			 
			 mysql_data_seek($tags, 0);
			 
			 echo "<br><br>";
		     
	}
	
	echo "<br><br>---<br>Total: ".$cont;
	
	

?>
