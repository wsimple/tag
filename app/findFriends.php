<?php include 'inc/header.php'; ?>
<div id="page-friendSearch" data-role="page" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div class="ui-listview-filter ui-bar-c">
			<input id="searchFriends" type="search" placeholder="Search" name="searchFriends" value="" />
		</div>
		<div class="list-wrapper">
			<div id="scroller">
				<ul data-role="listview" data-divider-theme="e" id="friendsList"></ul>
				<!-- lista de contactos del tlf -->
				<ul data-role="listview" data-divider-theme="e" id="contactList"></ul>
			</div>
		</div>
	</div>
	<script>		
		pageShow({
			id:'#page-friendSearch',
			title:lang.friendSearh_title,
			buttons:{back:true,home:true},
			before:function(){
				$('#searchFriends').attr('placeholder',lang.inputPlaceHolder);
			},
			after:function(){
				$('.list-wrapper').jScroll({hScroll:false});
				var opc={layer:'#friendsList',mod:'find',get:"",user:$.local('code')};
				viewFriends(opc);
				viewContacsPhone('#contactList', '');
				
				var last='';
				$('#searchFriends').change(function(/*event*/){
					$(this).keyup();
				}).keyup(function(/*event*/){
					var val=$.trim(this.value);
					if(val.length<3) val='';
					if(last!=val){
						opc.get="&search="+val;
						viewFriends(opc);
						if (CORDOVA) {
							viewContacsPhone('#contactList', val);    //Filtra elemntos tambien por agenda de contactos
						}
					}
					last=val;
				});
				$('#friendsList').on('click','a[code]',function(){
					redir(PAGE['profile']+'?id='+$(this).attr('code'));
				});

				$('#contactList').on('click','a[email]',function(){
					that = $(this);
					myDialog({
						// id:'#singleRedirDialog',
						content:lang.JS_INVITEPHONECONTACT,
						buttons:
							[{
								name: lang.yes,
								action:function(){
									var mainDialog = this;
									$.ajax({
										type    : "POST",
										url     : DOMINIO+"controls/users/inviteFriends.json.php?email="+that.attr('email'),
										dataType: "json",
										success : function (data) {
											mainDialog.close();
											if(data.status) {
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
								name: 'No',
								action: 'close'
							}
						]
					});
				});		
			}
		});
	</script>
</div><!-- /page -->
<?php include 'inc/footer.php'; ?>
