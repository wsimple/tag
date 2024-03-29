<?php include 'inc/header.php'; ?>
<div id="page-signUp" data-role="page" data-cache="false" class="no-header">
	<div data-role="content">
		<img class="bg" src="css/smt/bgorange.png"/>
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div id="buttons"><div class="_tt"><div class="_tc">
					<div id="logo_image ">
						<a data-inline="true" data-theme="f" >
							<img src="css/newdesign/tagbum_white_logo.png" alt="" style="max-height:100px;"><br>
							<span id="msgLogo" style="color:#FFF; font-weight:normal;">create.share</span><span id="msgLogob" style="color:#FFF;font-weight:bold;">.reward</span>
						</a>
					</div>
				</div></div></div>
				<form id="frmRegister" name="frmRegister" method="post" style="display:block;">
					<div id="divDialog" data-role="dialog" style="display: none"></div>
					<input type="hidden" value="1" name="mobile"/>
					<input type="hidden" value="0" id="company" name="company"/>
					<div class="smt-formfields">
						<div class="ui-grid-a" id="nameBox">
							<div class="ui-block-a">
								<input id="name" name="name" type="text" class="intext"/>
							</div>
							<div class="ui-block-b single">
								<input id="lastName" name="lastName" type="text" class="intext"/>
							</div>
						</div>
						<div>
							<input id="email" name="email" type="email" class="intext"/>
							<input id="password" name="password" type="password" class="password-field intext" />
							<input id="repassword" name="confiPassword" type="password" class="password-field intext"/>
							<div class="ui-grid-b" style="margin: 0px !important;">
								<div class="ui-block-a" style="margin: 0px !important;">
									<select id="month" name="month" data-theme="n" data-icon="false"  style="margin: 0px !important;"></select>
								</div>
								<div class="ui-block-b">
									<select id="day" name="day" data-theme="n" data-icon="false"></select>
								</div>
								<div class="ui-block-c">
									<select id="year" name="year" data-theme="n" data-icon="false"></select>
								</div>
							</div>
							<div class="ui-grid-solo single">
								<select id="gender" name="gender" data-theme="n" data-icon="false"></select>
							</div>
							<p id="msgCreatedAccount" style="font-weight:bold;"></p><br/>
						</div>
					</div>
					<div id="buttons">
						<div class="_tt">
							<div class="_tl">
								<a id="btn-back" class="btn-orange" data-role="button" data-inline="true" data-theme="f" onclick="goBack()"  data-iconpos="right"></a>
							</div>
							<div class="_tr">
								<a id="btn-signup" class="btn-orange" data-role="button" data-inline="true" data-theme="f" onclick="$('#frmRegister').submit();"  data-iconpos="right">Sign Up</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a id="showFormIndividual" href="#"></a></li>
				<li><a id="showFormEnterprise" href="#"></a></li>
			</ul>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-signUp',
			before:function(){ 
				$('#nameLabel,#dateLabel').addClass('single');
				$('#nameEnter,#bussinesDate').addClass('enterp');
				$('.single,.enterp').hide();
				//traducciones de la etiquetas
				$('#buttonSign').html(lang.MNU_REGISTER);
				$('#msgLogo').html(lan('create.share'));
				$('#btn-back').html(lan('Back'));
				$('#msgLogob').html(lan('.reward'));
				$('#btn-signup').html(lang.MNU_REGISTER);
				$('#nameLabel').html(lang.SIGNUP_LBLFIRSTNAME);
				$("#name").attr("placeholder", lang.SIGNUP_LBLFIRSTNAME);
				$('#gender').html('<option value="" selected>'+lan('Gender')+'</option>');
				$("#phone").attr("placeholder", lan('Phone Number (Optional)'));
				$("#lastName").attr("placeholder", lang.SIGNUP_LBLLASTNAME);
				$('#nameEnter').html(lang.JS_SIGNUP_LBLADVERTISERNAME);
				$('#lastNameLabel').html(lang.SIGNUP_LBLLASTNAME);
				$('#dateLabel').html(lang.SIGNUP_LBLBIRTHDATE);
				$('#bussinesDate').html(lang.JS_SIGNUP_LBLBUSINESSSINCE);
				$('#month').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLMONTH+'</option>');
				$('#day').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLDAY+'</option>');
				$('#year').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLYEAR+'</option>');
				$('#emailLabel').html(lang.SIGNUP_LBLEMAIL);
				$("#email").attr("placeholder", lang.SIGNUP_LBLEMAIL);
				$("#password").attr("placeholder", lang.SIGNUP_PASSWORD);
				$("#repassword").attr("placeholder", lang.SIGNUP_PASSWORD2);
				$('#passwordLabel').html(lang.SIGNUP_PASSWORD);
				$('#repasswordLabel').html(lang.SIGNUP_PASSWORD2);
				$('#msgPassword').html(lang.USERPROFILE_PASSWORD);
				$('#msgRequired').html(lang.REQUIRED);
				$('#msgCreatedAccount').html(lang.TEXT_TERMS+'&nbsp;<a href="#" id="getTerms" data-rel="dialog" data-transition="pop">'+lang.TEXT_LINKTERMS+'</a>');
				$('#showFormIndividual').html('<span><img src="css/smt/signup_personal.png" width="20" height="20" style="position: relative;top: 2px"/></span> '+lang.JS_SIGNUP_INDIVIDUAL);
				$('#showFormEnterprise').html('<span><img src="css/smt/signup_business.png" width="20" height="20"/></span> '+lang.JS_SIGNUP_ENTERPRISE);
				$('#name,#lastName').attr({
					'autocapitalize':'word'
				});
				$('label').append(':');
				$('label.needed').prepend('(*)&nbsp;');
				if(is['android']) $('#password,#repassword').attr('type','text').addClass('password-field');
			},
			login:function(logged){
				if(logged) redir(PAGE['home']);
			},
			after:function(){
				if($('#company').val()=='1')
					$('.enterp').show();
				else
					$('.single').show();
				if(!is['limited']){
					$('.fs-wrapper').jScroll({hScroll:false});
					setTimeout(function(){$('.fs-wrapper').jScroll('refresh');},100);
				}else
					$('#page-signUp').addClass('default');
				var str='',i=1;
				// Combos: Year, Month and Day
				do{
					str+='<option value="'+i+'">'+i+'</option>';
				}while(++i<13);
				$('#month').append(str);
				do{
					str+='<option value="'+i+'">'+i+'</option>';
				}while(++i<32);
				$('#day').append(str);
				date=new Date();
				for(str='',i=date.getFullYear()-10;i>1929;i--)
					str+='<option value="'+i+'">'+i+'</option>';
				$('#year').append(str);
				// Combo Genero
				str='<option value="2">'+lan('Female')+'</option>';
				str+='<option value="1">'+lan('Male')+'</option>';
				$('#gender').append(str);
				$('#showFormEnterprise').click(function(){
					$("#nameBox").attr('class', 'ui-grid-solo');
					$('.single').hide();
					$('.enterp').show();
					$('#company').val('1');
					$("#name").attr("placeholder", lang.JS_SIGNUP_LBLADVERTISERNAME);
					if(!is['limited']) setTimeout(function(){$('.fs-wrapper').jScroll('refresh');},500);
				});
				$('#showFormIndividual').click(function(){
					$("#nameBox").attr('class', 'ui-grid-a');
					$('.enterp').hide();
					$('.single').show();
					$('#company').val('0');
					$("#name").attr("placeholder", lang.SIGNUP_LBLFIRSTNAME);
					if(!is['limited']) setTimeout(function(){$('.fs-wrapper').jScroll('refresh');},500);
				});
				$('#frmRegister').submit(function(){
					//alert($('#month').val()+'/'+$('#day').val()+'/'+$('#year').val());
					var single=$('#company').val()!='1';
//					if(!single) Data.lastName='';
					myAjax({
						url		:DOMINIO+'controls/users/register.json.php',
						type	:'POST',
						dataType:'json',
						data	:{
							name		:$('#name').val(),
							lastName	:$('#lastName').val(),
							month		:$('#month').val(),
							day			:$('#day').val(),
							year		:$('#year').val(),
							email		:$('#email').val(),
							password	:$('#password').val(),
							repassword	:$('#repassword').val(),
							company		:$('#company').val(),
							sex 		:$('#gender').val()
						},
						success:function(data){
							console.log(data['msg']+data['email']);
							if(data['msg']=='1'){
								myDialog(single?lang.SIGNUP_CTRERRORNAME:lang.SIGNUP_CTRERRORNAMENTER);
							}else if(data['msg']=='2'){
								myDialog(lang.SIGNUP_CTRERRORLASTNAME);
							}else if(data['msg']=='3'){
								myDialog(lang.SIGNUP_CTRERROREMAIL);
							}else if(data['msg']=='4'){
								myDialog(lang.SIGNUP_CTRERRORPASS);
							}else if(data['msg']=='5'){
								myDialog(lang.SIGNUP_CTRERROREMAIL2);
							}else if(data['msg']=='6'){
								myDialog(lang.SIGNUP_CTRERRORBIRTHDATE);
							}else if(data['msg']=='7'){
								myDialog(lang.USERPROFILE_PASSWORD);
							}else if(data['msg']=='8'){
								myDialog(lang.SIGNUP_CONFIRMPASSWORD);
							}else if(data['msg']=='9'){
								myDialog(lang.SMT_SIGNUP_PASSWORDNOTMATCH);
							}else if(data['msg']=='10'){
								myDialog(lang.SIGNUP_CTRERRORBIRTHDATE);
							}else{
								myDialog({
									id:'#singleRedirDialog',
									content:lang.SMT_SIGNUP_EXITOREGISTER,
									buttons:{
										Ok:function(){
											redir(PAGE.ini);
										}
									}
								});
							}
						},
						error:function(){
							myDialog('error');
						}
					});
					return false;
				});
				var terms=lang.DIALOG_TERMS;
				$('#getTerms').click(function(){
					$('html,body').animate({scrollTop:0},'fast',function(){
						myDialog({
							id:'get-terms',
							content:terms+'<br/>',
							style:{'max-height':200,height:200,padding:'0px 10px'},
							scroll:{hScroll:false}
						});
					});
				});
			}
		});
	</script>
</div>
<?php include('inc/footer.php'); ?>
