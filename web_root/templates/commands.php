<div>Results from command: <?=$_GET['command']?></div><br/>
<div id="results"></div>
<?php
	switch($_GET['command']){
		case 'createTags':
			//$GLOBALS['cn']->query('ALTER TABLE  `tags` CHANGE  `img`  `img` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  "";');
			if(isset($_GET['removeUsers'])) $GLOBALS['cn']->query('DELETE FROM `tags` WHERE `id_user` not in (select id from users);');//borra las tag de usuarios que no existan
			if(isset($_GET['clear'])){ $GLOBALS['cn']->query('UPDATE `tags` SET `img`="" WHERE '.($_GET['id']==''?'1':'id="'.$_GET['id'].'"')); echo 'cleared'; }
		?>
			<script>
				$(function(){
					var url='cronjobs/createTags.php<?=$_GET['id']==''?'':'?id='.$_GET['id']?>',
						stop=false;
					console.log('url='+url);
					function createTags(){
						if(stop) return;
						console.log('calling');
						$('#results').prepend('<div>Calling...</div>');
						$.ajax({
							url:url,
							type: 'get',
							dataType: 'json',
							success: function(data){
								console.log('success');
								console.log(data);
								var len=data['num'];
								if(len>0){
									var i,txt='',tag;
									for(i=0;i<len;i++){
										tag=data['tags'][i];
										txt+='<div>'+tag['id']+' -> '+tag['tag']+'</div>';
									}
									$('#results').prepend('<div>'+txt+'</div>');
								}else
									$('#results').prepend('<div>No tags created.</div>');
								$('#results').prepend('<div>done='+data['done']+', left:'+data['more']+'</div>');
								if(data['more']>0) createTags();
								else $('#results').prepend('<div>Finish.</div>');
							},
							error: function(){
								console.log('error');
								$('#results').prepend('<div>Error.</div>');
							}
						});
					}
					createTags();
					window.stop=function(){ stop=true; };
					window.start=function(){ stop=false; createTags(); };
				});
			</script>
		<?php break;
	}
?>
