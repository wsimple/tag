<?php include 'inc/header.php'; ?>
<div id="page-friendSearch" data-role="page">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-c" style="top:0px;left:0;"></div>
	</div>
	<div data-role="content" class="list-content">
		<div class="ui-listview-filter ui-bar-c">
			<input id="searchFriends" type="search" placeholder="Search" name="searchFriends" value="" />
		</div>
		<div class="list-wrapper">		
			<div id="scroller">
				<!-- lista de contactos del tlf -->
				<ul data-role="listview" data-divider-theme="e" id="contactFilter" class="contacts menuCordova"></ul>
				<ul data-role="listview" data-divider-theme="e" id="contactList" class="contacts"></ul>
				<!-- busqueda en fagbum -->
				<ul class="list-friends ui-grid-b" id="friendsList"></ul>
			</div>
		</div>
	</div>
</div><!-- /page -->
<script>
	function usrImgError(img){
		img.onerror = "";
		img.src='css/tbum/usr.png';
		return true;
	}
	pageShow({
		id:'#page-friendSearch',
		title:'',
		buttons:{showmenu:false,home:false},
		before:function(){
			newMenu();
			$('#menu').html(
				'<span class="ui-block-a menu-button"><a href="userFriends.html'+'?type=friends&id_user='+$.local('code')+'"><img src="css/newdesign/friends.png"><br>'+lan('friends','ucw')+'</a></span>'+
				'<span class="ui-block-b"></span>'+
				'<span class="ui-block-c"></span>'+
				'<span class="ui-block-d menu-button hover"><a href="#" title="Suggest"><img src="css/newdesign/menu/friends.png"><br>'+lan('suggest','ucw')+'</a></span>'
			);
			$('#searchFriends').attr('placeholder',lang.inputPlaceHolder);
			$('#contactList').html('<li data-role="list-divider">'+lan('CONTACTS_LOADING','ucf')+'</li><li class="center"><loader class="s32"/></li>');
			if(CORDOVA){
				$("#scroller").prepend('<div data-role="navbar"><ul id="friendsFooter"></ul></div>');
				$('#friendsList',this.id).addClass('dnone');
				$('#friendsFooter').html(
					'<li><a href="#" data-opc=".contacts">'+lan('contacts','ucf')+'</a></li>'+
					'<li><a href="#" data-opc="#friendsList">Tagbum</a></li>'
				).find('li a:first').addClass('ui-btn-active');
			}else{
				$('ul.contacts',this.id).remove();
				$(this.id).addClass('no-footer').children('#footer').remove();
			}
		},
		after:function(){
			$('.list-wrapper').jScroll({hScroll:false});
			var that=this.id,pag=1,perpag=21;
			$(that).on('click','.ui-navbar a[data-opc]',function(){
				$('.ui-content ul').addClass('dnone').filter(this.dataset.opc).removeClass('dnone');
				$('.list-wrapper').jScroll('refresh');
			});
			var opc={layer:'#friendsList',wrapper:$('.list-wrapper'),mod:'find',user:$.local('code'),get:'&offset='+perpag,perpag:21};
			$(that).on('click','#seemore', function(event) {
				opc.get = '&offset='+perpag+'&limit='+(perpag*pag++);
				viewFriends('more',opc);
			});
			viewFriends('refresh',opc);
			$.cordova(function(){
				viewContacsPhone('#contactList','');
			});
			var last='';
			$('#searchFriends').change(function(/*event*/){
				$(this).keyup();
			}).keyup(function(/*event*/){
				var val=$.trim(this.value);
				if(val.length<3) val='';
				if(last!=val){
					opc.get="&search="+val;
					viewFriends('refresh',opc);
					$.cordova(function(){
						viewContacsPhone('#contactList',val);//Filtrar elementos tambien por agenda de contactos
					});
				}
				last=val;
			});
			$('#contactFilter,#friendsList').on('click','[code]',function(){
				redir(PAGE['profile']+'?id='+$(this).attr('code'));
			});
			linkUser('#contactFilter,#friendsList');
			$('#contactList').on('click','a[email]',function(){
				that = $(this);
				myDialog({
					// id:'#singleRedirDialog',
					content:lang.JS_INVITEPHONECONTACT,
					buttons:[{
						name:lan('yes','ucw'),
						action:function(){
							var mainDialog=this;
							$.ajax({
								type	:"POST",
								url		:DOMINIO+"controls/users/inviteFriends.json.php?email="+that.attr('email'),
								dataType:"json",
								success :function(data){
									mainDialog.close();
									if(data.status){
										// that.parents('li.userInList').remove();
										var emailSent=$.local('emails_sent')||[];
										that.find('.status-invitation').html(' '+lang.FIENDFRIENDS_INVITED);
										myDialog('#singleDialog',lan('EMAIL_SENT')+that.find('h3.ui-li-heading').html());
										emailSent.push( that.attr('email') );
										$.local('emails_sent',emailSent);
									}else{
										myDialog('#singleDialog',lan('EMAIL_ERROR_INVITE'));
									};
								},
								error: function(){
									mainDialog.close();
									myDialog('#singleDialog',lan('EMAIL_ERROR_INVITE'));
								}
							});
						}
					},{
						name:lan('no','ucw'),
						action:'close'
					}]
				});
			});		
		}
	});
	/**
	 * Muestra contactos agregados en la agenda del telefono
	 * @param  {string} idLayer [selector de elemnto donde se cargaran los contactos]
	 * @param  {[string]} filter  [filter cadena para filtrar contactos a buscar por: email, numero telefonio o nombre]
	 * @return {[boolean or none]}	[none]
	 */
	function viewContacsPhone(idLayer,filter){ 
		if (typeof ContactFindOptions === "undefined") return;
		var onSuccess=function(c){//c=contactos
				c=c||[];
				var i,j,out,data={email:[],phone:[]},
					emails,phones,phone,photo,name,
					emailSent=$.local('emails_sent')||[];
				for(i=0;i<c.length;i++){
					emails=[];
					if(c[i].emails) for(j=0;j<c[i].emails.length;j++){
						emails.push(c[i].emails[j].value);
						data.email.push(c[i].emails[j].value);
					}
					phones=[];
					if(c[i].phoneNumbers) for(j=0;j<c[i].phoneNumbers.length;j++){
						phone=c[i].phoneNumbers[j].value.replace(/^0+|\D/g,'');
						phones.push(phone);
						data.phone.push(phone);
					}
				}
				//se buscan los contactos ya existentes en tagbum y se remueven de la lista global
				if(!emails.length&&!phones.length)
					$('#contactFilter').html('');
				else
				viewFriends('refresh',{
					//layer:'#contactFilter',
					wrapper:$('.list-wrapper'),
					mod:'find',
					divider:lan('TAGBUM_CONTACTS','ucw'),
					user:$.local('code'),
					post:{in:data},
					success:function(data){
						var emails=(data.registered&&data.registered.emails)||[],
							phones=(data.registered&&data.registered.phones)||[],
							remove;
						for(i=c.length-1;i>=0;i--){
							remove=false;
							if(c[i].emails) for(j=0;j<c[i].emails.length&&!remove;j++){
								remove=remove||emails.indexOf(c[i].emails[j].value)>-1;
							}
							if(c[i].phoneNumbers) for(j=0;j<c[i].phoneNumbers.length&&!remove;j++){
								remove=remove||phones.indexOf(c[i].phoneNumbers[j].value.replace(/^0+|\D/g,''))>-1;
							}
							if(remove) c.splice(i,1);
						}
						out='<li data-role="list-divider">'+lan('all contacts','ucw')+' <span class="ui-li-count">'+c.length+'</span></li>';
						for(i=0;i<c.length;i++){
							emails=[];
							if(c[i].emails) for(j=0;j<c[i].emails.length;j++)
								emails.push(c[i].emails[j].value);
							if(emails.length){
								photo=(c[i].photos&&c[i].photos[0].value)||'css/tbum/usr.png';
								name=c[i].name.formatted||emails[0];
								out+=
								'<li class="userInList">'+
									'<a email="'+emails[0]+'" data-theme="e">'+
										'<img src="'+photo+'"'+'class="ui-li-thumb" onerror="usrImgError(this)" width="60" height="60"/>'+
										'<h3 class="ui-li-heading">'+name+'</h3>'+
										'<p class="ui-li-desc">'+
											'<img src="css/smt/phone.png" alt="'+lang.FIENDFRIENDS_PHONECONTACT+'" widt="16" height="16" />'+
											lang.FIENDFRIENDS_PHONECONTACT+
											'<span class="status-invitation">&nbsp;'+($.inArray(emails[0],emailSent)>-1?lang.FIENDFRIENDS_INVITED:'')+'</span>'+
										'</p>'+
									'</a>'+
								'</li>';
							}else{
								'<li class="userInList">'+
									lan('NOT_EMAIL_CONTACTS')+
								'</li>';
							}
						}
						$(idLayer).html(out).listview('refresh');
						// if(!data.datos.length) $('#contactFilter').html('');
						$('.list-wrapper').jScroll('refresh');
					}
				});
			},
			onError=function(contactError){ return false; };
		var options=new ContactFindOptions();
		options.multiple=true;
		if(filter) options.filter=filter;
		var fields=["displayName","name","phoneNumbers","emails","photos"];
		navigator.contacts.find(fields,onSuccess,onError,options);
	}
</script>
<?php include 'inc/footer.php'; ?>
