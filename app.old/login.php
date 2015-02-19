<?php include 'inc/header.php'; ?>
<style>
	.ui-loader{
		top: 16px;
		right: 10px;
	}
</style>
<div id="page-login" data-role="page" class="no-header no-footer">
	<div data-role="content" class="smt-bg smt-center">
		<div class="ui-box-login">
			<div class="title">
				<div class="logo-smt-login"></div>
				<strong id="titleTopLogin"></strong>
				<span id="titleMidleLogin"></span>
				<strong id="titleBottonLogin"></strong>
			</div>
			<div class="form">
				<form id="frmLogin" method="post">
					<div id="loginFields">
						<p>
							<input data-theme="b" name="login" id="txtLogin" value="" type="email" placeholder="email" onkeypress="return enterTab(event,this)" onfocus="inputFocus(this)" />
							<input data-theme="b" name="pwd" id="txtPass" value="" type="password" placeholder="password" class="password-field" onkeypress="return enterSubmit(event,this)" onfocus="inputFocus(this)" />
						</p>
						<a id="forGot" onclick="redir(PAGE['forGot']);"></a><br/><br/>
						<a id="btn-back" data-role="button" data-icon="arrow-l" data-inline="true" data-theme="f" onClick="redir(PAGE.ini)"></a>
						<a id="btn-login" data-role="button" data-inline="true" data-theme="f" data-icon="arrow-r" data-iconpos="right" href="#" onClick="$('#frmLogin').submit()">&nbsp;</a>
					</div>
					<div id="loadingTL" style="display:none;color:#fff;padding-top:15px;"></div>
				</form>
			</div>
		</div>
	</div>
	<script>
		pageShow({
			id:'page-login',
			before:function(){
				var exp=CORDOVA?365:1;
				$.cookie.defaults={expires:exp,path:'/'};
				$('#forGot').html(lang.MNU_LOSTPASS).css('cursor','pointer').css('color','black').css('text-decoration','underline').css('font-weight','initial').css('font-size','18px');
				$('#loadingTL').html('<loader class="s32"/><br/>'+lang.JS_APP_LOADING);
				$('#txtLogin').val($.cookie('last'));
				$('#btn-login').html(lang.login);
				$('#txtLogin').attr('placeholder',lan('email','ucf'));
				$('#txtPass').attr('placeholder',lan('password','ucf'));
				$('#btn-signup').html(lang.signup);
				$('#btn-back').html(lan('Back'));

				$('#titleTopLogin').html(lang.TITLETOPLOGIN);
				$('#titleMidleLogin').html(lang.TITLEMIDLELOGIN);
				$('#titleBottonLogin').html(lang.TITLEBOTTONLOGIN);
				if(is['android']) $('#txtPass').attr('type','text').addClass('password-field');
			},
			login:function(logged){
				if(logged) redir(PAGE['home']);
			},
			after:function(){
				$('.ui-box-home p a').css('padding','0 10px');
                $('#btn-login span.ui-btn-text').css('padding-left','10px');
                //Submit login. Return false to prevent normal browser submit and page navigation
				var wait=false,send=false,$form=$('#frmLogin');
				$form.attr('action',PAGE.ini);
				$form.submit(function(){
					if(!send&&!wait){
						wait=true;
						var data={
								login:$('#txtLogin').val(),
								pwd:$('#txtPass').val(),
								lng:lang['actual']
							};
						if(CORDOVA) data.keep=true;
						login({
							data:data,
							success:function(d){
								if (d.numFriends==0) { $form.attr('action',PAGE.findfriends); };
//								if(data.keep) $.cookie('kl',1);
//								else $.cookie('kl',null);
								send=true;
								$.session('_post_',1);
								//$.loader('show');
								//alert(JSON.stringify(d));
								$form.submit();
							},
							fail:function(data){
								wait=false;
								if(data['from']==='paypal'||data['from']=='renewaccount'){
									myDialog('#log-msg',lang['MSG_PAYPAL_HELP']+'<br><br><strong style="font-size: 13px;">'+lang['MSG_PAYPAL_HELP_APP']+'</strong>');
								}else{
									myDialog('#log-msg',data['msg']);
								}
							},
							error:function(data){
								wait=false;
								//console.log(data);
								myDialog('#log-msg',lang['CON_ERROR']);
							}
						},true);
					}
					return send;
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>