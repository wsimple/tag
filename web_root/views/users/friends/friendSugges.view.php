<?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){ ?>

<script type="text/javascript">
	//ScrollPane Favoroites
	$(function(){
		$('#suggest_friends ul').jScrollPane();
	});


</script>

<?php }else{ ?>

		<script type="text/javascript" src="js/jscroll.js"></script>

        <script type="text/javascript">
			var myScroll;

			function loaded() {
				setTimeout( function() {
					 document.ontouchmove = function(e) { }
							// document.ontouchmove = function(e)
					myScroll = new iScroll( document.getElementById('scroller') );
				}, 100);

			}

			window.addEventListener('load', loaded, true);
			</script>
<?php } ?>

<div id="suggest_friends" style="float:right;  width:248px; height:294px;  margin:0 5px 5px 0;">
	<h3 class="title_orange_section" ><?=FRIENDS_LBLTITLESUGGESTPEOPLE?></h3>
	<div style="float:right;position:relative;z-index:1;width:250px;height:268px;margin:0 5px 0 0;<?php if($_SESSION['ws-tags']['ws-user']['fullversion']==1){?>overflow:auto;<?php }?>">
		<ul style=" list-style:none; margin:0; padding:0; font-size:11px; width:100%; <?php if($_SESSION['ws-tags']['ws-user']['fullversion']!=1){?> height:270px; <?php }?>" id="scroller">
		<?php
			$rands=view_friendsOfFriends();//listado de sugerencias, (home page)
			if(mysql_num_rows($rands)>0){
				while($rand=mysql_fetch_assoc($rands)){
		?>
			<li id="li_s<?=md5($rand[id_friend])?>" style="margin:5px 0 5px 10px;padding:2px;background-color:#F4F4F4;border:1px solid #CCC; width:220px;height:75px;border-radius:5px;behavior:url(css/border-radius.htc);-moz-border-radius:5px;-webkit-border-radius:5px;z-index:-2;">
				<a href="javascript:void(0);" class="inner_border" onclick="userProfile('<?=$rand[name_user]?>','Close','<?=md5($rand[id_friend])?>')"><img src="<?=FILESERVER.getUserPicture($rand['code_friend'].'/'.$rand['photo_friend'])?>" width="60" height="60"/></a>
				<h3><a href="javascript:void(0);" onclick="userProfile('<?=$rand[name_user]?>','Close','<?=md5($rand[id_friend])?>')" style="font-size:11px; font-weight:normal" ><?=$rand[name_user]?></a></h3>
				<p><?=$rand[description]?></p>
				<p>
					<?php if ($_SESSION['ws-tags']['ws-user'][id]!=''){ ?>
					<!--<input name="btn_link_<?=md5($rand[id_friend])?>" id="btn_link_<?=md5($rand[id_friend])?>" type="button" value="<?=USER_BTNLINK?>" onclick="linkUserSuggestion('#li_s<?=md5($rand[id_friend])?>', '<?=md5($rand[id_friend])?>', '<?=md5(rand())?>');" style="font-size:10px; .position:static;"  />-->
					<input name="btn_link_<?=md5($rand[id_friend])?>" id="btn_link_<?=md5($rand[id_friend])?>" type="button" value="<?=USER_BTNLINK?>"  style="font-size:10px; position:static;"  action="linkUser,'',<?=md5($friend[id_friend])?>"/>
					<?php }else{
						echo "&nbsp;";
					} ?>
				</p>
				<div class="clear"></div>
			</li>
        <?php
                  }//fin while sugerencias
			  }else{
	    ?>
			            <p class="alert" style="margin-top:40px; margin-left:20px; text-align:center; width:220px; height:75px;">
				        <?=FRIENDSUGGEST_NOFRIEND1?><br />
				        <a href="<?=base_url('friends')?>" title="<?=FRIENDSUGGEST_NOFRIEND1_TITLE?>"><?=FRIENDSUGGEST_NOFRIEND2?></a>
			            </p>
        <?php
		      }
			$viewsMySql = array(
				'view_friends_level01',
				'view_friends_level02',
				'view_friends_level03',
				'view_friends_level04',
				'view_friends_level05',
				'view_friends_level06',
				'view_friends_level07'
			);
			dropViews($viewsMySql);
	    ?>
	</ul>
    </div>
</div>