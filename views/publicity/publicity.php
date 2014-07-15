<article id="adsListPublicity" class="side-box imagenPub">
	<header><span><?=USERPUBLICITY_ABSINDEX?></span></header>
	<?php
	 $like = "";
     //selecci�n de preferencias del usuario en session
	 $preferences = explode('|', usersPreferences());
	 foreach ($preferences as $value){
			  $like .= " _datox_ LIKE '%".replaceCharacters($value)."%' OR ";
	 }
	 $publicitys = $GLOBALS['cn']->query("
		SELECT md5(id) AS id,
			   id AS id_valida,
			   link,
			   picture,
			   title,
			   message
		FROM users_publicity
		WHERE status = '1' AND click_max >= click_current
			  AND id_type_publicity = '".$typePublicity."'
			  AND (".str_replace("_datox_", "title", rtrim($like, ' OR '))." OR ".str_replace("_datox_", "message", rtrim($like, ' OR ')).")
		ORDER BY RAND()
		LIMIT 0, $limit_p
	 ");
	  $i = 0;
	  while ($publicity = mysql_fetch_assoc($publicitys)){
			 $lst_publix .= "'".$publicity[id_valida]."',";
			 
		     $cad_des = strlen($publicity['message']);
			 $messagePubli = ($cad_des>90)? substr($publicity['message'], 0,90)."..." : $publicity['message'];
			 
			 $borde = ($i==4)?'style="border-bottom:0"':''
	  ?>
		<div id="bordePublicity" <?=$borde?>>
			<a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()">
				<div id="imgPublicity">
					<?php
						//if (file_exists('img/publicity/'.$publicity['picture'])) {
						//	$img = 'includes/imagen.php?ancho=90&tipo=3&img='.FILESERVER.'img/publicity/'.$publicity['picture'];
						//	$class = '';
						//}else{
						//	$img = 'img/publicity/publicity_nofile.png';
						//	$class = 'style="width:45px; height:45px; padding-left: 2px;padding-top: 4px;"';
						//}
						//$class = 'style="width:52px; height:52px; "';

					?>

					<!-- <img src="<?=$img?>" <?=$class?>> -->
					
					<img src="<?='.?resizeimg&ancho=70&tipo=3&img='.FILESERVER.getPublicityPicture('img/publicity/'.$publicity['picture'],'img/publicity/publicity_nofile.png')?>"/>

				</div>
			</a>
			<div id="namePublicity">
				  <strong><div style="text-align: left"><a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()"><?=$publicity['title']?></a></div></strong>
				  <br />
				  <!--0-->
				  <?=$messagePubli?>

			</div>
			<div class="linkPubliseemore"><a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()"><?=USER_BTNSEEMORE?>...</a></div>
		</div>
	 <?php
		$i++;
		}
		 //echo $lst_publix."<br><br>";
		 $limitNOPreference = $limit_p + 4;
		 //relleno con publicidades aleatorias que no tienen que ver con las preferencias del usuario en session
		 $limit_relleno = (mysql_num_rows($publicitys) < $limitNOPreference) ? $limit_p-mysql_num_rows($publicitys) : 0; //limite de registro por consulta
		 $where = (mysql_num_rows($publicitys)==0) ? "" : " AND id NOT IN (".rtrim($lst_publix,',').") ";
		 $rellenos = $GLOBALS['cn']->query(" SELECT md5(id) AS id, link, picture, title, message
											 FROM users_publicity
											 WHERE status = '1' AND click_max >= click_current AND id_type_publicity = '".$typePublicity."' $where
											 ORDER BY RAND()
											 LIMIT 0, $limit_relleno
										   ");

		if ($limit_relleno>0){
			$limit_border = mysql_num_rows($rellenos) - 1;
			$a = 0;
			while ($publicity = mysql_fetch_assoc($rellenos)){
			$cad_des = strlen($publicity['message']);
			$messagePubli = ($cad_des>90)? substr($publicity['message'], 0,90)."..." : $publicity['message'];
			$bordeR = ($a==$limit_border)?'style="border-bottom:0"':'';
	  ?>
		<div id="bordePublicity" <?=$bordeR?> class="yo">
				<a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()">
					<div id="imgPublicity">

						<?php
							// getUserPicture('img/users/'.$_SESSION['ws-tags']['ws-user']['code'].'/'.$_SESSION['ws-tags']['ws-user']['photo'],'img/users/default.png')

							//if (file_exists('img/publicity/'.$publicity['picture'])) {
							//	$img = 'includes/imagen.php?ancho=90&tipo=3&img='.FILESERVER.'img/publicity/'.$publicity['picture'];
							//	$class = '';
							//}else{
							//	$img = 'img/publicity/publicity_nofile.png';
							//	$class = 'style="width:45px; height:45px; padding-left: 2px;padding-top: 4px;"';
							//}
						?>
						<!-- <img src="<?=$img?>" <?=$class?>> -->
						
						<img src="<?='.?resizeimg&ancho=70&tipo=3&img='.FILESERVER.getPublicityPicture('img/publicity/'.$publicity['picture'],'img/publicity/publicity_nofile.png')?>"/>

					</div>
				</a>
				<div id="namePublicity">
					<strong><div style="text-align: left"><a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()"><?=$publicity['title']?></a></div></strong>
					 <br />
					 <?=$messagePubli?>
				</div>
				<div class="linkPubliseemore"><a href="<?=$publicity['link']?>" target="_blank" onclick="showPublicityWb('<?=$publicity['id']?>')" onfocus="this.blur()"><?=USER_BTNSEEMORE?>...</a></div>
		        <div class="clearfix"></div>
           </div>
		<?php $a++;
			}
		}//if limite
	if (mysql_num_rows($publicitys)== 0 && mysql_num_rows($rellenos)==0)
		echo '<img src="imgs/banner_publicity_mini.png" style="-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; border: 1px solid #ddd; margin: 0 0 10px 14px;" />';
	?>
	<div class="clearfix"></div>
</div>
</article>