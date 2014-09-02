<?php
require 'controls/facebook/facebook.php';
$user=$facebook->getUser(); //Obtengo usuario de facebook para usar la api js
?>
<div id="login-box">
	<form method="post" action="login.php" accept-charset="UTF-8">
		<p class="login-error" style="display:none;">
			<strong><?=$lang->get('LOGIN_ERROR')?></strong>
		</p>
		<p>
			<strong><?=$lang->get('LOGIN_TITLEBUTTONCREATEACCOUNT')?></strong>
			<input type="button" class="fb-buttom" value="<?=$lang->get('LOGIN_TEXTBUTTONCREATEACCOUNT')?> <?=$lang->get('JS_OR')?> <?=$lang->get('BTN_LOGIN')?>"/>
			<input type="button" id="lnkRegistro" value="<?=$lang->get('LOGIN_TEXTBUTTONCREATEACCOUNT')?>" onclick="redir('signup')"/>
			<div id="fb-root"></div>
		</p>
		<p>
			<label for="txtLogin"><?=$lang->get('LBL_LOGIN')?>:</label>
			<input type="email" name="txtLogin" id="txtLogin" class="text_box" placeholder="<?=$lang->get('LBL_LOGIN')?>" value="<?=$_COOKIE['last']?>" requerido="<?=$lang->get('LBL_LOGIN')?>" />
			<span class="legend">tagbum.com/<?=$lang->get('LOGIN_URLUSERSMYID')?></span>
		</p>
		<p>
			<input type="password" name="txtPass" id="txtPass" class="text_box" placeholder="<?=$lang->get('LBL_PASS')?>" value="" requerido="<?=$lang->get('LBL_PASS')?>"/>
			<a href="<?=base_url('resendPassword')?>" id="lnkRecordar" onFocus="this.blur();"><?=$lang->get('MNU_LOSTPASS')?></a>
		</p>
		<p>
			<input type="checkbox" name="keepLogin" id="keepLogin" <?=isset($_COOKIE['kl'])?' checked="checked"':''?> />
			<span><?=$lang->get('LOGIN_LBLREMEMBERMELOGIN')?></span>
		</p>
		<p>
			<a href="<?=$lang->get('HREF_DEFAULT')?>"><?=$lang->get('LOGIN_LBLLINKTROUBLELOGGIN')?></a>
		</p>
		<p style="text-align:right;">
			<input type="submit" name="btnLogin" id="btnLogin" value="<?=$lang->get('BTN_LOGIN')?>" style="width:100px;" />
		</p>
		<input type="hidden" name="hash" id="hash" value="" />
		<?php if($_GET['store']=='1'){ ?><input type="hidden" name="store" value="1" /><?php } ?>
		<?php if($_GET['wpAddTag']=='1'){ ?><input type="hidden" name="wpAddTag" value="1" /><?php } ?>
		<input type="hidden" name="goto" value="<?=$bodyPage=='main/failure.php'?'':'//'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>" />
	</form>
	<!-- <div class="social-block">
		<?=$lang->get('LOGIN_TITLECREATEACCOUNTFB')?><br>
	</div> -->
</div>
<script>
(function(){
	var wait=false,send=false,box=$('#login-box form')[0],$keep=$('#keepLogin',box);
	$(function(){
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
					success:function(){
						send=true;
						var exceptions=/^#(page|signup|home|$)/i,
							hash=document.location.hash;
						if(hash.match(exceptions)) hash='';
						var url=document.location.search+hash;
						if(url) $.session('login_url',url);
						$(box).submit();
					},
					fail:function(data){
						console.log('fail');
						if(data&&data['from']==='renewaccount'){//si renovar cuenta
							$.dialog({//Avisar sobre renovacion
								title:'<?=$lang->get('SIGNUP_CTRTITLEALERT')?>',
								resizable:false,
								width:320,
								height:300,
								modal:true,
								show:'fade',
								hide:'fade',
								open:function(){
									$(this).html("<span><?=$lang->get('EXPIREDACCOUNT_TITLEWINDOWSWARNING')?></span>");
								},
								buttons:{
									'<?=$lang->get('JS_OK')?>':function(){
										data['from']='paypal';
										go_paypal(data);//Va a paypal para renovar cuenta
										$(this).dialog('close');
									},
									'<?=$lang->get('JS_CANCEL')?>':function(){
										$(this).dialog('close');
									}
								}
							});
						}else if(data&&data['from']!='paypal'){
							$.dialog({
								title:'<?=$lang->get('SIGNUP_CTRTITLEALERT')?>',
								resizable:false,
								width:300,
								modal:true,
								show:'fade',
								hide:'fade',
								open:function(){
									$(this).html(data['msg']);
								},
								buttons:{
									'<?=$lang->get('JS_OK')?>':function(){
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
	});
	//Para login con facebook
	window.fbAsyncInit=function(){
		FB.init({
			appId:'<?=$facebook->getAppID()?>',
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
							<?php if($control->is_debug('fb')){ ?>
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
	$('.fb-buttom').click(accountFb);
})();
</script>
