<div id="login-box">
	<form method="post" action="login.php" accept-charset="UTF-8">
		<p class="login-error" style="display:none;">
			<strong><?=LOGIN_ERROR?></strong>
		</p>
		<p>
			<strong><?=LOGIN_TITLEBUTTONCREATEACCOUNT?></strong>
			<input type="button" class="fb-buttom" value="<?=LOGIN_TEXTBUTTONCREATEACCOUNT?> <?=JS_OR.' '.BTN_LOGIN?>"/>
			<input type="button" id="lnkRegistro" value="<?=LOGIN_TEXTBUTTONCREATEACCOUNT?>" onclick="redir('signup')"/>
		</p>
		<div id="fb-root"></div>
		<p>
			<label for="txtLogin"><?=LBL_LOGIN?>:</label>
			<input type="email" name="txtLogin" id="txtLogin" class="text_box" placeholder="<?=LBL_LOGIN?>" value="<?=$_COOKIE['last']?>" requerido="<?=LBL_LOGIN?>" />
			<span class="legend">tagbum.com/<?=LOGIN_URLUSERSMYID?></span>
		</p>
		<p>
			<input type="password" name="txtPass" id="txtPass" class="text_box" placeholder="<?=LBL_PASS?>" value="" requerido="<?=LBL_PASS?>"/>
			<a href="<?=base_url('resendPassword')?>" id="lnkRecordar" onFocus="this.blur();"><?=MNU_LOSTPASS?></a>
		</p>
		<p>
			<input type="checkbox" name="keepLogin" id="keepLogin" <?=isset($_COOKIE['kl'])?' checked="checked"':''?> />
			<span><?=LOGIN_LBLREMEMBERMELOGIN?></span>
		</p>
		<p>
			<a href="<?=HREF_DEFAULT?>"><?=LOGIN_LBLLINKTROUBLELOGGIN?></a>
		</p>
		<p style="text-align:right;">
			<input type="submit" name="btnLogin" id="btnLogin" value="<?=BTN_LOGIN?>" style="width:100px;" />
		</p>
		<input type="hidden" name="hash" id="hash" value="" />
		<?php if($_GET['store']=='1'){ ?><input type="hidden" name="store" value="1" /><?php } ?>
		<?php if($_GET['wpAddTag']=='1'){ ?><input type="hidden" name="wpAddTag" value="1" /><?php } ?>
		<input type="hidden" name="goto" id="goto" value="<?=$bodyPage=='main/failure.php'?'':'//'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>" />
	</form>
	<!-- <div class="social-block">
		<?=LOGIN_TITLECREATEACCOUNTFB?><br>
	</div> -->
</div>
<script>
(function($){
	var wait=false,send=false,box=$('#login-box form')[0],$keep=$('#keepLogin',box),$go=$('#goto',box), urlFriends = 'friends?sc=2';
	var _login=function(){
		$('#hash',box).val(document.location.hash);
		if(!send&&!wait&&valida(this)){
			wait=true;
			var data={
				login:$('#txtLogin',box).val(),
				pwd:$('#txtPass',box).val()
			};
			if($keep.is(':checked')) data.keep=true;
			login({
				data:data,
				success:function(d){
					send=true;
					var exceptions=/^#(page|signup|home|$)/i,
						hash=document.location.hash;
					if(hash.match(exceptions)) hash='';
					var url=document.location.search+hash;
					if(url) $.session('login_url',url);
					if (d.numFriends==0) { $go.val(urlFriends)};
					$(box).submit();
				},
				fail:function(data){
					console.log('fail');
					if(data&&data['from']==='renewaccount'){//si renovar cuenta
						$.dialog({//Avisar sobre renovacion
							title:'<?=SIGNUP_CTRTITLEALERT?>',
							resizable:false,
							width:320,
							height:300,
							modal:true,
							show:'fade',
							hide:'fade',
							open:function(){
								$(this).html("<span><?=EXPIREDACCOUNT_TITLEWINDOWSWARNING?></span>");
							},
							buttons:{
								'<?=JS_OK?>':function(){
									data['from']='paypal';
									go_paypal(data);//Va a paypal para renovar cuenta
									$(this).dialog('close');
								},
								'<?=JS_CANCEL?>':function(){
									$(this).dialog('close');
								}
							}
						});
					}else if(data&&data['from']!='paypal'){
						$.dialog({
							title:'<?=SIGNUP_CTRTITLEALERT?>',
							resizable:false,
							width:300,
							modal:true,
							show:'fade',
							hide:'fade',
							open:function(){
								$(this).html(data['msg']);
							},
							buttons:{
								'<?=JS_OK?>':function(){
									$(this).dialog('close');
								}
							}
						});
					};
					go_paypal(data);//Va a paypal para cuenta nueva
					wait=false;
					$(box).one('submit',_login);
				}
			});
		}
		return send;
	};
	$(box).one('submit',_login);
	function go_paypal(d){
		if(d&&d['from']==='paypal'){
			redir('paybusiness?uid='+d['msg']+'&'+Math.random());
		}
	}
	function accountFb(){
		FB.login(function(response){
			if(response.authResponse){
				FB.api('/me',function(response){
					//console.log('Entraste: ' + response.name + '.');
					//redir('controls/actionfb.php');
					$.ajax({
						url:DOMINIO+'controls/facebook/fbuser.json.php',
						type:'post',
						data:{keep:$keep.is(':checked')},
						dataType:'json',
						success:function(data){
							<?php if(is_debug('fb')){ ?>
							$.debug('fb').log('FBuser success. data:',data);
							<?php }else{ ?>
								$(box).one('submit',_login);
							<?php } ?>
						}
					});
				});
			}else{
				//console.log('No has logueado correcatmente con fbb.');
			}
		},{scope:'email'});
	}
	$('.fb-buttom').off().on('click',accountFb);
	//Para login con facebook
	window.fbAsyncInit=function(){
		FB.init({
			appId:'<?=isset($config->facebook->appId)?$config->facebook->appId:''?>',
			cookie:true,
			xfbml:true,
			oauth:true,
			status:true
		});
	};
	(function(d,s,id){
		var js, fjs=d.getElementsByTagName(s)[0];
		if(d.getElementById(id)) return;
		js=d.createElement(s); js.id=id;
		js.src="//connect.facebook.net/en_Us/all.js";
		fjs.parentNode.insertBefore(js,fjs);
	}(document,'script','facebook-jssdk'));
	// window.fbAsyncInit=function(){
	// 	FB.init({
	// 		appId:'<?=isset($config->facebook->appId)?$config->facebook->appId:''?>',
	// 		xfbml:true,
	// 		version:'v2.2'
	// 	});
	// };
	// (function(d, s, id){
	// 	var js, fjs = d.getElementsByTagName(s)[0];
	// 	if (d.getElementById(id)) {return;}
	// 	js = d.createElement(s); js.id = id;
	// 	js.src = "//connect.facebook.net/en_US/sdk.js";
	// 	fjs.parentNode.insertBefore(js, fjs);
	// }(document, 'script', 'facebook-jssdk'));

})(jQuery);
</script>
