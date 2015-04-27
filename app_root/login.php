<?php include 'inc/header.php'; ?>
<style>
	.ui-loader{
		top: 16px;
		right: 10px;
	}
</style>

<div id="page-login" data-role="page" data-cache="false" class="no-header">
	<div data-role="content">
		<img class="bg" src="css/smt/bgorange.png"/>
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller" style="margin-top:30px">
				<div id="buttons"><div class="_tt"><div class="_tc">
					<div id="logo_image ">
						<a data-inline="true" data-theme="f" >
							<img src="css/newdesign/tagbum_white_logo.png" alt="" style="max-height:100px;"><br>
							<span id="msgLogo" style="color:#FFF; font-weight:normal;">create.share</span><span id="msgLogob" style="color:#FFF;font-weight:bold;">.reward</span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="form">
			<form id="frmLogin" method="post">
				<div id="loginFields">
					<p>
						<input data-theme="b" name="login" id="txtLogin" value="" type="email" placeholder="email" onkeypress="return enterTab(event,this)" onfocus="inputFocus(this)" />
						<input data-theme="b" name="pwd" id="txtPass" value="" type="password" placeholder="password" class="password-field"  />
					</p>
					<div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LcziQUTAAAAACrwsmGrSfydtkzIG8RWl4O5TFkZ" style="display: none; transform:scale(0.77);transform-origin:0 0;"></div>
					<a id="forGot" onclick="redir(PAGE['forGot']);"></a><br/><br/>
					<div id="buttons">
						<div class="_tt">
							<div class="_tl">
								<a id="btn-back" class="btn-orange" data-role="button" data-inline="true" data-theme="f" onclick="goBack()"  data-iconpos="right"></a>
							</div>
							<div class="_tr">
								<input type="submit" id="btn-login" class="btn-orange" data-role="button" data-inline="true" data-theme="f" data-icon="arrow-r" data-iconpos="right" />
								<input type="hidden" name="gcaptcha" id="gcaptcha" value="false" />
								<input type="hidden" name="version" id="version" value="2" />
								<!-- <a id="btn-login2" class="btn-orange" data-role="button" data-inline="true" data-theme="f" data-icon="arrow-r" data-iconpos="right" href="#" onClick="$('#frmLogin').submit()"></a> -->
							</div>
						</div>
					</div>
				</div>
				<div id="loadingTL" style="display:none;color:#fff;padding-top:15px;"></div>
			</form>
		</div>
	</div>

	<script>
		pageShow({
			id:'page-login',
			before:function(){
				var exp=CORDOVA?365:1;
				$.cookie.defaults={expires:exp,path:'/'};
				$('#forGot').html(lang.MNU_LOSTPASS);
				$('#loadingTL').html('<loader class="s32"/><br/>'+lang.JS_APP_LOADING);
				$('#txtLogin').val($.cookie('last'));
				$('#btn-login').val(lang.login);
				$('#txtLogin').attr('placeholder',lan('email','ucf'));
				$('#txtPass').attr('placeholder',lan('password','ucf'));
				$('#btn-signup').html(lang.signup);
				$('#btn-back').html(lan('Back'));
				$('#msgLogo').html(lan('create.share'));
				$('#msgLogob').html(lan('.reward'));
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
								iscaptcha:$('#gcaptcha').val(),
								recaptcha:$('#g-recaptcha-response').val(),
								version:$('#version').val(),
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
									document.getElementById('g-recaptcha').style.display = ((data['iscaptcha'])?"block":"none");
									$('#gcaptcha').val( ((data['iscaptcha'])?true:false) );

									myDialog('#log-msg',data['msg']);

									if (data['iscaptcha']) grecaptcha.reset();
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