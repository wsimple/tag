<?php include 'inc/header.php'; ?>
<div id="page-friendSearch" data-role="page">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div class="ui-listview-filter ui-bar-c">
			<input id="searchFriends" type="search" placeholder="Search" name="searchFriends" value="" />
		</div>
		<div class="list-wrapper">
			<div id="scroller">
				<!-- lista de contactos del tlf -->
				<ul data-role="listview" data-divider-theme="e" id="contactFilter" class="contacts"></ul>
				<ul data-role="listview" data-divider-theme="e" id="contactList" class="contacts"></ul>
				<!-- busqueda en fagbum -->
				<ul data-role="listview" data-divider-theme="e" id="friendsList"><li class="center"><loader class="s32"/></li></ul>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="friendsFooter"></ul>
		</div>
	</div>
</div><!-- /page -->
<script>
	pageShow({
		id:'#page-friendSearch',
		title:lang.friendSearh_title,
		buttons:{back:true,home:true},
		before:function(){
			$('#searchFriends').attr('placeholder',lang.inputPlaceHolder);
			$('#contactFilter').html('<li data-role="list-divider">'+lan('TAGBUM_CONTACTS','ucw')+'</li><li class="center"><loader class="s32"/></li>');
			$('#contactList').html('<li data-role="list-divider">'+lan('all contacts','ucw')+'</li><li class="center"><loader class="s32"/></li>');
			if(CORDOVA){
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
			var that=this.id;
			$(that).on('click','.ui-navbar a[data-opc]',function(){
				$('.ui-content ul').addClass('dnone').filter(this.dataset.opc).removeClass('dnone');
				$('.list-wrapper').jScroll('refresh');
			});
			var opc={layer:'#friendsList',mod:'find',user:$.local('code')};
			viewFriends(opc);
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
					viewFriends(opc);
					$.cordova(function(){
						viewContacsPhone('#contactList', val);    //Filtra elemntos tambien por agenda de contactos
					});
				}
				last=val;
			});
			$('#friendsList').on('click','[code]',function(){
				redir(PAGE['profile']+'?id='+$(this).attr('code'));
			});
			linkUser(opc.layer);
			linkUser('#contactFilter');
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
								type    :"POST",
								url     :DOMINIO+"controls/users/inviteFriends.json.php?email="+that.attr('email'),
								dataType:"json",
								success :function(data){
									mainDialog.close();
									if(data.status){
										// that.parents('li.userInList').remove();
										var emailSent=$.local('emails_sent')||[];
										that.find('.status-invitation').html(' '+lang.FIENDFRIENDS_INVITED);
										myDialog('#singleDialog','<?=INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIEND?>:'+that.find('h3.ui-li-heading').html());
										emailSent.push( that.attr('email') );
										$.local('emails_sent',emailSent);
									}else{
										myDialog('#singleDialog','<?=INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIENDERROR?>');
									};
								},
								error: function(){
									mainDialog.close();
									myDialog('#singleDialog','<?=INVITEUSERTOSYSTEM_CTRSSENDMAILTOFRIENDERROR?>');
								}
							});
						}
					},{
						name:lan('no','ucw'),
						action: 'close'
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
		filter=(filter||'');
		var out='',
			onSuccess=function(contacts){
				out='<li data-role="list-divider">'+lan('all contacts','ucw')+' <span class="ui-li-count">'+contacts.length+'</span></li>';
				var emailSent=$.local('emails_sent')||[];
				for(var i=0;i<contacts.length;i++){
					if(contacts[i].emails.length>0){
						var photo=(contacts[i].photos)?contacts[i].photos[0].value:'css/tbum/usr.png';
						out+=
						'<li class="userInList">'+
							'<a email="'+contacts[i].emails[0].value+'" data-theme="e">'+
								'<img src="'+photo+'"'+'class="ui-li-thumb" width="60" height="60"/>'+
								'<h3 class="ui-li-heading">'+contacts[i].name.formatted+'</h3>'+
								'<p class="ui-li-desc">'+
									'<img src="css/smt/phone.png" alt="'+lang.FIENDFRIENDS_PHONECONTACT+'" widt="16" height="16" />'+
									lang.FIENDFRIENDS_PHONECONTACT+
									'<span class="status-invitation">&nbsp;'+($.inArray(contacts[i].emails[0].value,emailSent)>-1?lang.FIENDFRIENDS_INVITED:'')+'</span>'+
								'</p>'+
							'</a>'+
						'</li>';
					}
				}
				$(idLayer).html(out).listview('refresh');
				$('.list-wrapper').jScroll('refresh');
				//se buscan los contactos ya existentes en tagbum y se remueven de la lista global 
				var i,j,data={email:[],phone:[]};
				console.log('contactos:',contacts);
				for(i=0;i<contacts.length;i++){
					if(contacts[i].emails) for(j=0;j<contacts[i].emails.length;j++)
						data.email.push(contacts[i].emails[j].value);
					if(contacts[i].phoneNumbers) for(j=0;j<contacts[i].phoneNumbers.length;j++)
						data.phone.push(contacts[i].phoneNumbers[j].value);
				}
				console.log('post data:',data);
				viewFriends({
					layer:'#contactFilter',
					mod:'find',
					divider:lan('TAGBUM_CONTACTS','ucw'),
					user:$.local('code'),
					post:{in:data}
				});
			},
			onError=function(contactError){ return false; };
		var options=new ContactFindOptions();
		options.filter=filter;
		options.multiple=true;
		var fields=["displayName","name","phoneNumbers","emails","photos"];
		navigator.contacts.find(fields,onSuccess,onError,options);
	}
</script>
<?php include 'inc/footer.php'; ?>
