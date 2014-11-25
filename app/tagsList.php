<?php include 'inc/header.php'; ?>
<div id="page-tagsList" data-role="page" data-cache="false" class="smt-no-scroll no-footer">
	<div data-role="header" data-position="fixed" data-theme="f">
		<a id="buttonBack" data-icon="arrow-l"></a>
		<h1 id="pageTitle"></h1>
		<a id="btnAddTag" data-icon="check" style="display:none;">&nbsp;</a>
	</div>
	<div data-role="content" style="background-color:#fff;">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div class="smt-tag-content"><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div></div>
				<div id="tagsList" class="cursor tags-list" style="min-height:300px;background:#fff;"></div>
				<div id="pullUp"><div class="smt-tag-content"><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f" class="dnone">
		<div data-role="navbar">
			<ul>
				<li><a id="members"></a></li>
				<li><a id="invite"></a></li>
				<!--<li><a id="leave"></a></li>-->
			</ul>
		</div>
	</div>
	<!-- Dialogs -->
	<div id="friendsListDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="header">
				<div id="groupTitle" class="optional dnone members center" style="font-weight:bold; padding: 5px 0px 10px;border-bottom: 1px solid #ccc;"></div>
				<div id="searcher" class="optional dnone invite">
					<div style="display:inline-block;margin-right:10px;width:85px;">
						<input id="like_friend_group" name="like_friend_group" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" style="width: 80px"/>
					</div>
					<input type="button" id="all" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true, '#friendsListDialog')" class="no-disable" data-mini="true" />
					<input type="button" id="none" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false, '#friendsListDialog')" class="no-disable" data-mini="true" />
				</div>
			</div>
			<div class="container">
				<div class="wrapper" style="height:150px" >
					<div id="scroller" >
						<div class="content" style="padding:5px; text-align: center;"></div>
					</div>
				</div>
			</div>
			<div class="buttons">
				<a data-role="button" class="optional dnone members" onclick="closeDialogmembersGroup('#friendsListDialog')" data-theme="f">Ok</a>
<!--				<a data-role="button" class="optional dnone invite" onclick="sendInvitationMemberGrp('#friendsListDialog')" data-theme="f">Send Invitation</a>-->
			</div>
		</div>
	</div></div></div>
	<!-- leave and assign -->
	<div id="adminLeaveDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="header">
				<div id="searcher" class="optional dnone leaveAd">
					<div style="display:inline-block;margin-right:10px;width:85px;">
						<input id="like_admin_group" name="like_admin_group" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" style="width: 80px"/>
					</div>
					<input type="button" id="all2" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true, '#adminLeaveDialog')" class="no-disable" data-mini="true" />
					<input type="button" id="none2" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false, '#adminLeaveDialog')" class="no-disable" data-mini="true" />
				</div>
			</div>
			<div class="container">
				<div class="wrapper" style="height:150px">
					<div id="scroller">
						<div class="content" style="padding:5px; text-align: center;"></div>
					</div>
				</div>
			</div>
			<div class="buttons">
				<a data-role="button" class="optional dnone leaveAd" id="assignAdminGrp" onclick="sendadminGroup('#adminLeaveDialog')" data-theme="f"></a>
			</div>
		</div>
	</div></div></div>
	<script>
		pageShow({
			id:'#page-tagsList',
			before:function(){
				$('.pullDownLabel').html(lang.SCROLL_PULLDOWN);
				$('.pullUpLabel').html(lang.SCROLL_PULLUP);
				$('#buttonBack').html(lan('Back'));
				$('#groupTitle').html(lang.GROUPS_MEMBERSTITLE2);
				$('#footer #invite').html(lang.GROUPS_INVITEDFRIENDS);
				$('#footer #members').html(lang.GROUPS_MEMBERSTITLE);
				$('#footer #leave').html(lang.GROUPS_LEAVE);
				$('#all,#all2').val(lan('All'));
				$('#none,#none2').val(lang.none);
				$('#assignAdminGrp').val(lang.GROUPS_ASSIGNADMIN);
				$('#like_friend_group, #like_admin_group').attr('placeholder',lang.inputPlaceHolder);
			},//end before
			after:function(){
				var current=$_GET['current']||'tagsUser',layer='#tagsList',id=$_GET['id'];
				var opc={current:current,layer: layer };
				if((current=='tagsUser')||(current=='personalTags')){
					opc.get='&uid='+$_GET['id'];
				}
				if(current=='group'){
					opc.get='&grupo='+$_GET['id'];
					opc.id=$_GET['id'];
					opc.code=$.local('code');
				}
                if(current=='hash') opc.get='&hash='+$_GET['hash'];
				$('#buttonBack').click(function(){
					($_GET['delete'])?((redir(PAGE['tagslist']+'?current=group&id='+id))):goBack();
				});
				$('#friendsListDialog .wrapper,#adminLeaveDialog .wrapper').jScroll({hScroll:false});
				// $(layer).on('click','[tag]',function(){
				// 	if($(this).attr('tag')!=''){
				// 		var get=['id='+$(this).attr('tag')];
				// 		if(current=='group') get.push('idGroup='+id);
				// 		redir(PAGE['tag']+'?'+get.join('&'));
				// 	}
				// });
				/*action menu tag*/
				actionsTags(opc.layer);
				/*and action menu tag*/

				$('#pd-wrapper',this.id).ptrScroll({
					onPullDown:function(){
						updateTagsOld('refresh',opc);
					},
					onPullUp:function(){
						updateTagsOld('more',opc);
					},
					onReload:function(){
						updateTagsOld('reload',opc);
					}
				});
				if(current=='tagsUser'){
					$('#pageTitle').html(lang.MAINMNU_MYTAGS);
				}else if(current=='personal'){
					$('#pageTitle').html(lang.MAINMNU_PERSONALTAGS);
				}else if(current=='group'){
					$('#pageTitle').html(lan('group','ucw'));
					nameMenuGroups(id,0,function(data){
						$('#pageTitle').html(lan('group','ucw')+': '+data['name']);
						verifyGroupMembership(id,$.local('code'),function(data){
							if(data['isMember']){
								$('.ui-page-active').removeClass('no-footer');
								$('#footer').show();
								$('#btnAddTag .ui-btn-text').html(lang.GROUPS_MENUADDTAG);
								$('#btnAddTag').click(function(){
									redir(PAGE['newtag']+'?group='+id);
								});
							}else{
								$('#btnAddTag .ui-btn-text').html(lang.GROUPS_JOIN);
								$('#btnAddTag').click(function(){
									insertUserGroup(id);
								});
							}
							$('#btnAddTag').show();
						});
					});
					function getMembersGroup(){
						console.log('getMembersGroup');
						myAjax({
							loader	: true,
							type	: 'POST',
							url		: DOMINIO+'controls/users/people.json.php?action=groupMembers&code&idGroup='+id,
							data 	:{uid:$.local('code')},
							dataType: 'json',
							success	: function(data) {
								var i,friend,ret = '';
								for(i in data['datos']){
									friend=data['datos'][i];
									ret	+=
										'<div code="'+friend['code_friend']+'" style="height: 60px; min-width: 200px; padding: 5px 0px 5px 0px; border-bottom: solid 1px #D4D4D4">'+
											'<img src="'+friend['photo_friend']+'" style="float:left; width:60px; height:60px;" class="userBR"/>'+
											'<div style="float: left; margin-left:5px; font-size:10px; text-align: left;">'+
												'<spam style="color:#E78F08; font-weight:bold; ">' + friend['name_user'] + '</spam><br/>'+
												(friend['country'] ? ''+lang.country+': '+friend['country']+'<br/>' : '')+
												''+lan('friends','ucw')+'('+friend['friends_count']+')<br/>'+
												''+lan('admirers','ucw')+'('+friend['followers_count']+')<br/>'+
												((friend['status'])?'<strong style="color:green">'+lan('active','ucw')+'</strong>':'<strong style="color:red">'+lan('inactive','ucw')+'</strong>')+
											'</div>'+
										'</div>';
								}
								$('#friendsListDialog').off().on('click','div[code]',function(){
									redir(PAGE['profile']+'?id='+$(this).attr('code'));
								});
								$('#friendsListDialog .content').html(ret);
								setTimeout(function(){$('.wrapper').jScroll('refresh');}, 1000);
							},
							error	: function() {
								myDialog('#singleDialog', 'ERROR-getMemberGroup');
							}
						});
					}
					function getFriendsGroup(like){
						console.log('getFriendsGroup');
						like=like?'&like='+like:'';
						myAjax({
							loader	:true,
							type	:'POST',
							url		:DOMINIO+'controls/users/people.json.php?nosugg&action=friendsAndFollow&mod=friends&code='+$.local('code')+like+'&idGroup='+id,
							dataType:'json',
							success	:function(data){
								var friend,ret='';
								for(var i in data['datos']){
									friend=data['datos'][i];
									//if(emails.join().indexOf(friend['email'])<0)
									ret+=
										'<div onclick="$(\'input\',this).is(\':checked\')?$(\'input\',this).removeProp(\'checked\'):$(\'input\',this).attr(\'checked\',true);" style="height: 60px; min-width: 200px; padding: 5px 0px 5px 0px; border-bottom: solid 1px #D4D4D4">'+
											'<div style="float: right; padding-top: 20px; margin-right: 15px;">'+
												'<fieldset data-role="controlgroup">'+
													'<input name="friend_'+friend['id']+'" '+
														'value="'+friend['email']+'|'+friend['id']+'|'+id+'" type="checkbox" />'+
												'</fieldset>'+
											'</div>'+
											'<img src="'+friend['photo_friend']+'" style="float: left; width: 60px; height: 60px;" class="userBR"/>'+
											'<div style="float: left; margin-left: 5px; font-size: 10px; text-align: left;">'+
												'<spam style="color: #E78F08; font-weight: bold; ">' + friend['name_user'] + '</spam><br/>'+
												(friend['country'] ? ''+lang.country+': '+friend['country']+'<br/>' : '')+
												''+lan('friends','ucw')+'('+friend['friends_count']+')<br/>'+
												''+lan('admirers','ucw')+'('+friend['followers_count']+')'+
											'</div>'+
										'</div>';
								}
								$('#friendsListDialog .content').html(ret);
								if(data==''){
									ret	=
										'<div id="message" style="height: 60px; min-width: 200px; padding: 5px 0px 5px 0px; border-bottom: solid 1px #D4D4D4">'+
											lang.GROUPS_MESSAGEMPTY+
										'</div>';
									$('.wrapper #scroller').html('<div style="padding:5px; text-align: center;">'+ret+'</div>');
								}
								$('.wrapper').jScroll('refresh');
							},
							error	: function() {
								myDialog('#singleDialog', 'ERROR-getFriends');
							}
						});
					}

					function assignAdminGroup(like) {
						console.log('assignAdminGroup');
						like = like ? '&like='+like : '';
						myAjax({
							loader	: true,
							type	: 'POST',
							url		: DOMINIO+'controls/groups/adminMemberGroup.json.php?id='+$.local('code')+like+'&idGroup='+id,
							dataType: 'json',
							success	: function(data) {
								var friend,ret	= '';
								for(var i in data){
									friend=data[i];
									//if(emails.join().indexOf(friend['email'])<0)
									ret	+=
										'<div id="'+friend['id']+'" onclick="$(\'#friend_'+friend['id']+'\').attr(\'checked\', ($(\'#friend_'+friend['id']+'\').is(\':checked\')) ? false : true);" style="height: 60px; min-width: 200px; padding: 5px 0px 5px 0px; border-bottom: solid 1px #D4D4D4">'+
											'<div style="float: right; padding-top: 20px; margin-right: 15px;">'+
												'<fieldset data-role="controlgroup">'+
													'<input id="friend_'+friend['id']+'" name="friend_'+friend['id']+'" '+
														'value="'+friend['email']+'|'+friend['id_user']+'|'+id+'" type="checkbox" />'+
												'</fieldset>'+
											'</div>'+
											'<img src="'+friend['photo']+'" style="float: left; width: 60px; height: 60px;"/>'+
											'<div style="float: left; margin-left: 5px; font-size: 10px; text-align: left;">'+
												'<spam style="color: #E78F08; font-weight: bold; ">' + friend['name'] + '</spam><br/>'+
												(friend['country'] ? ''+lang.country+': '+friend['country']+'<br/>' : '')+
												''+lan('friends','ucw')+'('+friend['friends_count']+')<br/>'+
												''+lan('admirers','ucw')+'('+friend['followers_count']+')'+
											'</div>'+
										'</div>';
								}
								$('#adminLeaveDialog .content').html(ret);
								if(data!=''){
								}else{
									ret	=
										'<div id="message" style="height: 60px; min-width: 200px; padding: 5px 0px 5px 0px; border-bottom: solid 1px #D4D4D4">'+
											lang.GROUPS_MESSAGEMPTY+
										'</div>';

									$('.wrapper #scroller').html('<div style="padding:5px; text-align: center;">'+ret+'</div>');
								}
								$('.wrapper').jScroll('refresh');
							},
							error	: function() {
								myDialog('#singleDialog', 'ERROR-getadminMembers');
							}
						});
					}
					$('#footer #invite').click(function(){
						myDialog({
							id:'#friendsListDialog',
							style:{'min-height':150},
							buttons:[{
								name:lang.GROUPS_SENDINVITATION,
								action: function(){ sendInvitationMemberGrp('#friendsListDialog')}
							},{
								name:lang.close,
								action:'close'
							}],
							after: function (options,dialog){
								$('#like_friend_group',dialog).unbind('keyup').bind('keyup',function(event) {
									if(event.which==8||event.which>40) getFriendsGroup($('#like_friend_group',dialog).val());
								});
								$('.optional',dialog).addClass('dnone');
								$('.invite',dialog).removeClass('dnone');
							}
						});
						getFriendsGroup();
					});

					$('#footer #members').click(function(){
						myDialog({
							id:'#friendsListDialog',
							style:{'min-height':150},
							buttons:{},
							after: function (options,dialog){
								 getMembersGroup();
								$('.optional',dialog).addClass('dnone');
								$('.members',dialog).removeClass('dnone');
							}
						});
					});
					$('#footer #leave').click(function(){
						myDialog({
							id:'#leaveDialog',
							content: lang.GROUPS_LEAVEMESSAGE,
							style:{'min-height':30},
							buttons:[
								{
									name:lang.yes,
									action:function (){
										var that=this;
										console.log('button yes');
										myAjax({
											type	: 'POST',
											url		: DOMINIO+'controls/groups/isAdminGroup.json.php?code='+$.local('code')+'&idGroup='+id,
											dataType: 'json',
											error	: function(resp, status, error) {
												myDialog("#singleDialog", lang.conectionFail);
											},
											success	: function(data) {
												//console.log(data['onlyAdmin']);
												//si eres admin, verificar si eres el unico o no
												if (data['verifyAdmin']=='1'){
													//si eres el unico, hay dos opcines: asiganr o abandonar
													if (data['onlyAdmin']=='1'){
														that.close(function(){
															myDialog({
																id:'#selectAdmin',
																scroll:true,
																content: '<strong>'+lang.GROUPS_LEAVEASIGNAR+': </strong>'+lang.GROUPS_LEAVEASIGNARMSG+'.<br><br><strong>'+lang.GROUPS_LEAVEABANDONAR+': </strong>'+lang.GROUPS_LEAVEABANDONARMSG,
																style:{'min-height':100},
																buttons:[{
																	name:lang.GROUPS_LEAVEASIGNAR,
																	action:function(){
																		$('#selectAdmin').fadeOut(300,function(){
																			myDialog({
																				id:'#adminLeaveDialog',
																				style:{'min-height':150},
																				buttons:{},
																				after: function (options,dialog){
																					$('#like_admin_group',dialog).unbind('keyup').bind('keyup',function(event) {
																						if(event.which==8||event.which>40) assignAdminGroup($('#like_admin_group',dialog).val());
																					});
																					$('.optional',dialog).addClass('dnone');
																					$('.leaveAd',dialog).removeClass('dnone');
																				}
																			});
																			assignAdminGroup();
																		});
																	}
																},{
																	name:lang.GROUPS_LEAVEABANDONAR,
																	action:function(){
																		$('#selectAdmin').fadeOut(300,function(){
																			console.log(lang.GROUPS_LEAVEABANDONAR);
																			myAjax({
																				type	: 'POST',
																				url		: DOMINIO+'controls/groups/isAdminGroup.json.php?code='+$.local('code')+'&idGroup='+id+'&act=leave',
																				dataType: 'json',
																				error	: function(/*resp, status, error*/) {
																					myDialog("#singleDialog", lang.conectionFail);
																				},
																				success	: function(/*data*/) {
																					myDialog({
																						id: '#deleteGroup',
																						content: lang.GROUPS_LEAVEBORRADO,
																						buttons:{
																							ok:function(){
																								redir('lstgroups.html?action=2');
																							}
																						}
																					});
																				}
																			});
																		});
																	}
																},{
																	name:'Close',
																	action:'close'
																}]
															});
														});
													}else{
														//si no eres el unico, abandonas el grupo sin problemas
														that.close(function(){
															myDialog({
																id: '#closeDialogAdminGrp',
																content: lang.GROUPS_LEAVEMESSAGEFINAL+' - admin but not only one',
																buttons:{
																	ok:function(){
																		redir('lstgroups.html?action=2');
																	}
																}
															});
														});
													}

												}else{
													//si no eres admin, abandonas el grupo sin problemas
													that.close(function(){
														myDialog({
															id: '#singleDialog',
															content: lang.GROUPS_LEAVEMESSAGEFINAL,
															buttons:{
																ok:function(){
																	redir('lstgroups.html?action=2');
																}
															}
														});
													});
												}
											}
										});
									}
								},
								{
									name:'No',
									action:function(){ this.close(); }
								}
							]
						});
					});
				}
			}//end after
		});

	</script>
</div>
<?php include 'inc/footer.php'; ?>