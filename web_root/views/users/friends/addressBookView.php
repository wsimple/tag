<!--caja contenedora del archivo-->
<div id="adressbook" class="ui-single-box">
	
	<div class="ui-single-box-title">
				<?=MYADDRESSBOOK?>
	</div>

	<!--Caja contenedora de la libreta-->
	<div>
		<?php
		//consulta los datos de los amigos
			$friends =view_friends();
			//consulta el numero de columnas de la consulta
			if (mysql_num_rows($friends)>0){
				$noAddressBook=0;
				//siclo para mostrar los amigos
				while($friend=mysql_fetch_assoc($friends)){

					//verificacion si los amigos poseen numero de telefono registrado
					if($friend['home_phone']!="-" || $friend['mobile_phone']!="-" || $friend['work_phone']!="-"){
						if($friend['home_phone']!=NULL || $friend['mobile_phone']!=NULL || $friend['work_phone']!= NULL){
							$noAddressBook = 1;
		?>			
							
							<div id="div_<?=md5($friend['id_friend'])?>"  class="divYourFriends">
								
								<div style="float: left; width: 80px">
								<img onclick="userProfile('<?=$friend['name_user']?>','Close','<?=md5($friend['id_friend'])?>')" src="<?=FILESERVER.getUserPicture($friend['code_friend'].'/'.$friend['photo_friend'],'img/users/default.png')?>" border="0"  width="65" height="65"  style="border:1px solid #ccc; margin-up:2px" />
								</div>
								
								<div>
								
									<p >
									
									<a href="javascript:void(0);"  action="profile,<?=md5($friend['id_friend'])?>,<?=$friend['name_user']?>">
									<?= formatoCadena($friend['name_user'],1); ?> <br/>
									</a>

										<?php
										if($friend['home_phone']!="-"){
											if($friend['home_phone']!=NULL){
												echo "<strong>".HOMEPHONE.":</strong> ";
												echo $friend['home_phone']."<br/>";
											}
										}
										if($friend['mobile_phone']!="-"){
											if($friend['mobile_phone']!=NULL){
												echo "<strong>".MOBILEPHONE.":</strong> ";
												echo $friend['mobile_phone']."<br/>";
											}
										}

										if($friend['work_phone']!="-"){
											if($friend['work_phone']!=NULL){
												echo "<strong>".WORKPHONE.":</strong> ";
												echo $friend['work_phone']."<br/>";
											}
										}
										?>
										</p>
									</div>
								<div class="clearfix"></div>
								
							</div>
		<?php				
						
						}
					}
				}
				
			}

		?>
	</div>
</div>
