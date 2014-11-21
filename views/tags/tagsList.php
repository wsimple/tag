<?php
	$dialog=$dialog||isset($_GET['popup'])||isset($_GET['dialog']);
	$current=$_GET['current'];
	if($current!=''){
		//compatibilidad para links antiguos
		$search	=array('myTags','tagsUser',	'personalTags',	'tagUser'	);
		$replace=array('user',	'user',		'personal',		'personal'	);
		$current=str_replace($search,$replace,$current);
		unset($search,$replace);
	}
	if($idPage=='timeline'){
		$current=$current==''?'timeLine':$current;
		$titulos=array(
			'timeLine'	=> TIMELINE_TITLE,
			'user'		=> MAINMNU_MYTAGS,
			'favorites'	=> TIMELINE_FAVORITES,
			'personal'	=> MAINMNU_PERSONALTAGS,
			'privateTags'	=> MAINMNU_PRIVATETAG
		);
		$titulo=$titulos[$current];
	}elseif($idPage=='tags'){
		if(isset($_GET['personal'])) $current='personal';
		$uid=$_GET['uid']!=''?$_GET['uid']:$_SESSION['ws-tags']['ws-user']['id'];
		$usr=$GLOBALS['cn']->queryRow('SELECT id,screen_name FROM users WHERE md5(id)="'.intToMd5($uid).'"');
		if(count($usr)){
			$uid=$usr['id'];
			$titulo=$usr['screen_name'];
			if($current=='personal'){
				$titulo.=' ('.MAINMNU_PERSONALTAGS.')';
			}else{
				$current='user';
			}
		}else{
			$titulo='Nonexistent User';
		}
		unset($usr);
	}elseif($idPage=='toptag'){
		$range=$_GET['range']==''?5:$_GET['range'];
		$titulos=array(TOPTAGS_DAILY, TOPTAGS_WEEKLY, TOPTAGS_MONTHLY, TOPTAGS_YEARLY, TOPTAGS_ALWAYS);
		$titulo=TOPTAG_TITLE.': '.$titulos[$range-1];
	}
	//Si viene de referencia la tag...
	if(isset($_GET['tag'])&&isset($_GET['referee'])){
		$referee=$_GET['referee'];
		$tag=$_GET['tag'];
	}
	else $referee='';
	if ($current=='hash'){
		$srh = urldecode($_GET['hash']); //Fix De hashtags
		$srh = str_replace(' ', '%', $srh); 
		$srh=end(explode("#",$srh));
	}
?>
<div id="taglist-box" class="ui-single-box<?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0||$dialog?'':' mini'?>">
	<?php if(!$dialog){ ?>
	<div class="ui-single-box-title">
		<span id="titleHashAlways"><?=$titulo?></span><span id="titleHashCurrent"></span>
		<form>
			<?php if ($current=='privateTags'){ ?>
			<div id="timeline-inboxOutbox" class="tray">
				<input type="radio" id="tlInbox" name="private" checked="checked"/><label title="<?=RADIOBTN_INBOX?>" for="tlInbox"><?=RADIOBTN_INBOX?></label>
				<input type="radio" id="tlOutbox" name="private" /><label title="<?=RADIOBTN_OUTBOX?>" for="tlOutbox"><?=RADIOBTN_OUTBOX?></label>
			</div>
			<?php } ?>
			<div class="tags-size">
				<?=RADIOBTN_VIEW?>:
				<input type="radio" name="radio" id="normal" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'checked="checked"':''?>/><label title="Normal Tags" for="normal">&nbsp;</label>
				<input type="radio" name="radio" id="mini" <?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']!=0?'checked="checked"':''?>/><label title="Mini Tags" for="mini">&nbsp;</label>
			</div>
		</form>
	</div>
	<?php } ?>
	<div class="tags-list">
		<?php if(($current=='personal')&&!$dialog){ ?>
			<div style="margin-bottom:5px;text-align:center;font-size:16px;">
				<a href="<?php echo base_url('creation?personal'); ?>" title="<?=MNUUSER_TITLECREATION?>">
					<img src="img/menu_users/creation.png" border="0" /><?=TAGS_PERSONAL_TAG?>
				</a>
			</div>
		<?php }?>
		<?php if (isset($_GET['select'])){ ?> <h3 style="font-size:18px;text-align:center;"><?=SELECTTAG?></h3><?php } ?>
		<div class="tag-container <?php if((isset($_GET['select']))){ ?>noMenu <?php } ?>"></div>
		<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="display: none;" />
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript">
	//ScrollPane Favoroites
	$(function() {
		$.c('tags').log('current <?=$current?>');
		var $box,
			ref='<?=$referee?>',
			hash = location.href.split('t=#'),
			backSch ='',current='<?=$current?>';
		<?php if($dialog){ ?>
			$box=$('.ui-dialog #taglist-box').last();
		<?php }else{ ?>
			$box=$('#taglist-box').first();
		<?php }?>
		if(hash[1]){
			backSch = location.href.split('&');
			backSch = backSch[0].split('t=#');
			$('#titleHashCurrent').html('<a href="'+BASEURL+'searchall?srh=<?=$_GET['bck']?>"><?=SIGNUP_BTNBACK?></a>&nbsp;-&nbsp;<?=TIMELINE_RESULTHASH?> #'+backSch[1]);
			$('#titleHashAlways').hide();
		}
		var ns='.tagsList',//namespace
			layer=$box.find('.tag-container')[0],//ultimo container creado (en especial si hay dialogos, por si hay otros abiertos)
			opc={
				layer: layer
			};
	<?php if($idPage=='tags'){ ?>
		opc['current']=current;
		opc['get']="<?=isset($_GET['uid'])?'&uid='.$_GET['uid']:''?>";
	<?php }elseif($current=='privateTags'){ ?>
            opc.pBox='p-inbox';
            opc.pCont=1;
	<?php } if($current=='hash'){ ?>
		opc['get']="&hash=<?=$srh?>";
		opc['current']='hash';
	<?php }elseif($range!=''){ ?>
		opc['current']='top';
		opc['get']='&range=<?=$range?>';
	<?php }else{ ?>
		opc['current']=(backSch[1])? backSch[1]+'|' : current;
		opc['get']="<?=$current!='user'?($current!='personal'?'':'&uid='.$_GET['uid']):'&uid='.$_GET['uid']?>";
	<?php }?>
	<?php if($dialog){ ?>
		console.log(opc);
		updateTags('reload',opc);
	<?php }else{ ?>
		$('.tags-size,.tray').buttonset()
		.find('[title]').tipsy({html:true,gravity:'n'});
		var sizeTags='<?=$_SESSION['ws-tags']['ws-user']['view_type_timeline']==0?'normal':'mini'?>',interval,
//			firstTime=true,
			refresh=function(){//refresh the window
				updateTags('refresh',opc,false);
			};
		$.on({
			open: function(){
//				if(firstTime){
//					updateTags('reload',opc);
//					firstTime=false;
//				}else{
//					refresh();
//				}
				updateTags('reload',opc);
				interval=setInterval(refresh, 30000);
				//scrolling
				$(window).on('scroll'+ns,function(){
					if(opc.actions.more.more===false){
						$(window).off('scroll'+ns);
					}else{
						var $header=$('header',PAGE),//global
							scrollEnd=$(layer).height()-$header.offset().top-$header.height(),//window scroll ending position
							scroll=parseInt($(layer).offset().top),//actual content position
							offset=800;//when to
						if(scrollEnd+scroll<offset){
							updateTags('more',opc);
						}
					}
				});
				var bandera=true;
				$('.tags-size').on('click','input',function(){
					var id=this.id;
					if(sizeTags!=id){
						if(id=='normal'){
							$box.removeClass('mini');
						}else{
							$box.addClass('mini');
						}
						console.log(bandera);
						sizeTags=id;
						if(bandera){
							bandera=false;
							console.log(id);
							$$.ajax({
								url:'controls/users/viewTimeline.control.php?'+id,
								type:'get'
							}).done(function(){
								bandera=true;
							});
						}
					}
				});
				<?php if($current=='privateTags'){ ?>
				$('#timeline-inboxOutbox').on('click','input',function() {
					opc.type = '';
					var id=this.id;// checked="checked"
					$(id).attr('checked','checked');
                    opc.pCont++;
					if(id=='tlInbox'){
					    opc.pBox='p-inbox';
						opc.get = '&typeBox=inbox';
					}else{
					    opc.pBox='p-outbox';
						opc.get = '&typeBox=outbox';
						opc.type = 'out';
					}
                    delete opc.on;
					updateTags('reload',opc);
				});
				<?php } ?>
			},
			close: function(){
				$(window).off(ns);
				$box.off();
				clearInterval(interval);
			}
		});
	<?php } ?>

	<?php if (isset($_GET['select'])) {?>
		$(layer).addClass('pointer');
		$(layer).on('click','[tag]',function(){
					var uri='controls/business_card/addToAnExistingTag.controls.php?id_tag='+$(this).attr('tag')+'&id_bc=<?=$_GET['select']?>';
					$.ajax({
						url: uri,
						type: 'GET',
						success: function(data){
							message('messages', data,data,'', 350, 220);
						}
					});

					$('#tagsUser').dialog('destroy');
		});
	<?php } ?>
	if(ref){commentTag('Ver tag', '<?=$tag?>');}
        
        <?php if(isset($_GET['sponsored'])){?> 
            console.log('entro sponsored')
            message('messages','<?=MNUTAG_TITLESPONSOR?>','<?=MSG_TAGSPONSORED?>','', 350, 220);
        <?php }?>
	});
</script>
