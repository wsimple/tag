<?php include 'inc/header.php'; ?>
<div id="page-start" data-role="page" class="no-header no-footer">
	<div data-role="content" class="smt-bg smt-center"><div class="_tt">
<?php if(isset($_GET['xdk'])){ ?>
		<div id="xdk-test" style="position:absolute;top:0;left:0;">XDK</div>
<?php } ?>
		<div class="ui-box-home _tc">
			<div class="logo-smt"></div>
			<div id="buttons" style="display:none;"><div class="_tt"><div class="_tc">
				<ul>
					<li>
						<a id="btn-login" class="btn-blue" data-role="button" data-inline="true" data-theme="f" onclick="redir(PAGE['login']);">&nbsp;</a>
					</li>
					<li>
						<a id="btn-signup" class="btn-orange" data-role="button" data-inline="true" data-theme="f" onclick="redir(PAGE['signup']);">Sign Up</a>
					</li>
<?php if((false&&isset($_GET['xdk']))||!isset($_GET['minify'])){ ?>
					<li>
						<a class="btn-facebook" id="btn-facebook" onclick="accountFb();" data-role="button" data-inline="true" data-theme="f"><?=LOGIN_TEXTBUTTONCREATEACCOUNT?> <?=JS_OR.' '.BTN_LOGIN?></a>
					</li>
<?php } ?>
				</ul>
				<a id="btn-fullVersion" data-role="button" data-inline="true" data-theme="c" style="display:none" onclick="redir(PAGE['fullversion']);">Full Version</a>
				<div class="store-info" style="margin-top: 15px; margin-bottom: 20px">
					<p id="app_download_msg"></p>
					<div class="googlePlay"></div>
					<!-- <a href="https://play.google.com/store/apps/details?id=org.app.seemytag"></a> -->
					<div class="appStore"></div>
					<!-- <a href="https://itunes.apple.com/us/app/semytag/id658430038?ls=1&mt=8"></a> -->
				</div>
			</div></div></div>
			<div id="noconection" style="display:none;"><div class="_tt"><div class="_tc">
				<div id="txtLoginError"></div>
				<a id="btn-reload" data-role="button" data-inline="true" data-theme="f" onclick="window.location.reload();">Retry</a>
			</div></div></div>
		</div>
	</div></div>
	<script>
		//$.session('countpage',0);
		pageShow({
			id:'page-start',
			before:function(){
				if($_GET['host']!==undefined){
					var host=null;
					if($_GET['host']=='p') host='tagbum.com';
					if(($_GET['host']||'').match(/\d{1,3}/i)) host='192.168.1.'+$_GET['host']+'/tag';
					if(host) host='http://'+host+'/';
					$.local('host',host);
				}
				var clear=false;
				if($_GET['appdebug']){
					$.session('debug',$_GET['appdebug']=='1');
				}
				if(clear){
					var i,local=['id','code','data','full_name','email','points'];
					for(i in local) $.local(local[i],null);
				}
				var exp=CORDOVA?365:1;
				$.cookie.defaults={expires:exp,path:'/'};
				$('#btn-signup').html(lang.signup);
				$('#app_download_msg').html(lang.LINK_DOWNLOADAPP);
				$('#btn-login').html(lang.login);
				$('#txtLoginError').html(lang.conectionFail);
				$('#btn-reload').html(lang.retry);
				if(is['tablet']&&!CORDOVA)
					$('#btn-fullVersion').show();
				$.loader('show');
				isLogged(isLogged());
			},
			login:function(logged){
				console.log('logged='+logged);
				$.loader('hide');
				if(logged) redir(PAGE['home'],true);
				else{
//					updateAndroidMarketLinks()
					$('div#buttons').show();
					if(CORDOVA)	$('.store-info').hide();
					else{
						if(is['iOS']) $('.googlePlay').hide();
						if(is['android']) $('.appStore').hide();
					}
				}
			},
			loginError:function(){
				console.log('login error');
				$.loader('hide');
				$('div#noconection').show();
			},
			after:function(){
				$('#btn-login-change .ui-btn-text').css('padding','0 10px');
			}
		});
//		function updateAndroidMarketLinks(){
//			var ua = navigator.userAgent.toLowerCase();
//			if (0 <= ua.indexOf("android")) {
//				// we have android
//				$("a[href^='https://play.google.com/']").each(function() {
//				this.href = this.href.replace(/^https:\/\/play.google.com\//,
//					"market://");
//				});
//			}
//		}

		//Login facebook
<?php if(false&&isset($_GET['xdk'])){ ?>
		document.addEventListener("intel.xdk.device.ready",function(e){
			document.addEventListener("intel.xdk.facebook.login",function(e){
				if(e.success==true){
					$('#xdk-test').html("Facebook Log in Successful");
				}else{
					$('#xdk-test').html("Unsuccessful Login");
				}
				$('#xdk-test').append('. Event:<pre>'+JSON.stringify(e)+'</pre>');
			},false);
			window.accountFb=intel.xdk.facebook&&intel.xdk.facebook.login?function(){
				intel.xdk.facebook.login("publish_stream,publish_actions,offline_access");
			}:function(){
				alert("Sorry, you can't login with facebook right now, try again later.");
			};
		},false);
<?php }elseif(!isset($_GET['minify'])){ ?>
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

		window.fbAsyncInit = function() {
			FB.init({
				appId:'<?=isset($config->facebook->appId)?$config->facebook->appId:''?>',
				cookie:true,
				xfbml:true,
				oauth:true,
				status:true
			});
		};
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "http://connect.facebook.net/en_Us/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		function accountFb(){
			FB.login(function(response){
				if(response.authResponse){
					FB.api('/me',function(response){
						$.ajax({
							url:DOMINIO+'controls/facebook/fbuser.json.php',
							dataType:'json',
							success:function(data){
								redir(PAGE.home);
							}
						});
					});
				// }else{
				// 	console.log('No has logueado correctamente con fbb.');
				}
			},{scope:'email'});
		}
<?php } ?>
		$('.googlePlay,.appStore').click(function(event) {
			myDialog({//Information lang.INVITE_GROUP_TRUE
				id:'#singleDialog',
				content:'<div style="text-align:center;"><span style="font-weight:bold">Information</span><br><br>This app is coming soon</div><br>'
			});
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
