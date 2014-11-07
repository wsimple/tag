<?php include 'inc/header.php'; ?>
<div id="page-signUp" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a href="#" id="buttonSign" data-icon="arrow-r" onclick="$('#frmRegister').submit();" data-iconpos="right"></a>
		<br>
	</div>
	<div data-role="content">
		<img class="bg" src="img/bg.png"/>
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<form id="frmRegister" name="frmRegister" method="post" style="display:block;">
					<!--<a href="<?=base_url('divDialog')?>" data-rel="dialog">Open dialog</a>-->
					<div id="divDialog" data-role="dialog" style="display: none"></div>
					<input type="hidden" value="1" name="mobile"/>
					<input type="hidden" value="0" id="company" name="company"/>
					<div class="smt-formfields">
						<div>
							<strong>
								<label id="nameLabel" class="needed"></label>
								<label id="nameEnter" class="needed"></label>
							</strong>
							<input id="name" name="name" type="text"/>
						</div>
						<div class="single">
							<strong><label id="lastNameLabel" class="needed"></label></strong>
							<input id="lastName" name="lastName" type="text"/>
						</div>
						<div>
							<strong>
								<label id="dateLabel" class="needed"></label>
								<label id="bussinesDate" class="needed"></label>
							</strong>
							<select id="month" name="month"></select>
							<select id="day" name="day"></select>
							<select id="year" name="year"></select>
						</div>
						<div>
							<strong><label id="emailLabel" class="needed"></label></strong>
							<input id="email" name="email" type="email"/>
						</div>
						<div>
							<strong><label id="passwordLabel" class="needed"></label></strong>
							<input id="password" name="password" type="password" class="password-field"/>
							<strong><label id="repasswordLabel" class="needed"></label></strong>
							<input id="repassword" name="confiPassword" type="password" class="password-field"/>
							<div id="msgPassword" style="font-size: 12px"></div>
						</div>
						<p id="msgRequired"></p>
						<p id="msgCreatedAccount" style="font-weight:bold;"></p><br/>
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
			title:lang.JS_SIGNUP_PROFILE,
			backButton:true,
			before:function(){
				$('#nameLabel,#dateLabel').addClass('single');
				$('#nameEnter,#bussinesDate').addClass('enterp');
				$('.single,.enterp').hide();
				//traducciones de la etiquetas
				$('#buttonSign').html(lang.MNU_REGISTER);
				$('#nameLabel').html(lang.SIGNUP_LBLFIRSTNAME);
				$('#nameEnter').html(lang.JS_SIGNUP_LBLADVERTISERNAME);
				$('#lastNameLabel').html(lang.SIGNUP_LBLLASTNAME);
				$('#dateLabel').html(lang.SIGNUP_LBLBIRTHDATE);
				$('#bussinesDate').html(lang.JS_SIGNUP_LBLBUSINESSSINCE);
				$('#month').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLMONTH+'</option>');
				$('#day').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLDAY+'</option>');
				$('#year').html('<option value="0" selected>'+lang.JS_SIGNUP_LBLYEAR+'</option>');
				$('#emailLabel').html(lang.SIGNUP_LBLEMAIL);
				$('#passwordLabel').html(lang.SIGNUP_PASSWORD);
				$('#repasswordLabel').html(lang.SIGNUP_PASSWORD2);
				$('#msgPassword').html(lang.USERPROFILE_PASSWORD);
				$('#msgRequired').html(lang.REQUIRED);
				$('#msgCreatedAccount').html(lang.TEXT_TERMS+'&nbsp;<a href="#" id="getTerms" data-rel="dialog" data-transition="pop">'+lang.TEXT_LINKTERMS+'</a>');
				$('#showFormIndividual').html('<span><img src="img/signup_personal.png"/></span> '+lang.JS_SIGNUP_INDIVIDUAL);
				$('#showFormEnterprise').html('<span><img src="img/signup_business.png"/></span> '+lang.JS_SIGNUP_ENTERPRISE);
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
				$('#showFormEnterprise').click(function(){
					$('.single').hide();
					$('.enterp').show();
					$('#company').val('1');
					if(!is['limited']) setTimeout(function(){$('.fs-wrapper').jScroll('refresh');},500);
				});
				$('#showFormIndividual').click(function(){
					$('.enterp').hide();
					$('.single').show();
					$('#company').val('0');
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
							company		:$('#company').val()
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
											redir(PAGE['ini']);
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
