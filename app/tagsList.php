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
				<li><a id="leave"></a></li>
			</ul>
		</div>
	</div>
	<!-- Dialogs -->
	<div id="friendsListDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="container" style="font-size: 50%;">
				<div class="this-search" style="display:inline-block;margin-right:5px;width:37%;">
					<input id="like_friend" name="like_friend" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" />
				</div>
				<div class="this-button" style="display:inline-block;width:60%;">
					<input type="button" id="all" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true,'#friendsListDialog')" class="no-disable" data-mini="true"  style="padding: 0;"/>
					<input type="button" id="none" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false,'#friendsListDialog')" class="no-disable" data-mini="true" style="padding: 0;"/>
				</div>
				<div class="list-wrapper" style="margin-top:5px;height:150px;">
					<div id="scroller"><ul data-role="listview" data-inset="true"></ul>
				</div></div>
			</div>
			<div class="buttons">
				<a href="#" data-role="button" onclick="closeDialogmembersGroup('#friendsListDialog')" data-theme="f">Ok</a>
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
				$('#friendsListDialog .list-wrapper').jScroll({hScroll:false});
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
					var admin=false,numAdm=0;
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
								admin=data['admin']=='0'?false:true;
								numAdm=data['numAdm'];
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
										'<li data-icon="false" code="'+friend['code_friend']+'" >'+
											'<img src="'+friend['photo_friend']+'" style="float:left; width:60px; height:60px;" class="userBR"/>'+
											'<div style="float: left; margin-left:5px; font-size:10px; text-align: left;">'+
												'<spam style="color:#E78F08; font-weight:bold; ">' + friend['name_user'] + '</spam><br/>'+
												(friend['country'] ? ''+lang.country+': '+friend['country']+'<br/>' : '')+
												''+lan('friends','ucw')+'('+friend['friends_count']+')<br/>'+
												''+lan('admirers','ucw')+'('+friend['followers_count']+')<br/>'+
												((friend['status'])?'<strong style="color:green">'+lan('active','ucw')+'</strong>':'<strong style="color:red">'+lan('inactive','ucw')+'</strong>')+
											'</div>'+
										'</li>';
								}
								$('#friendsListDialog .container ul').html(ret).listview('refresh');
								$('.list-wrapper').jScroll('refresh');
								$('#friendsListDialog').off().on('click','[code]',function(){
									redir(PAGE['profile']+'?id='+$(this).attr('code'));
								});
							},
							error	: function() {
								myDialog('#singleDialog', 'ERROR-getMemberGroup');
							}
						});
					}
					$('#footer #invite').click(function(){
						selectFriendsDialog($.local('code'),id);
						$('#friendsListDialog .buttons a').attr('onclick',"sendInvitationMemberGrp('#friendsListDialog','"+id+"');");
						$('#friendsListDialog .this-button').show();
						$('#friendsListDialog .this-search').css('width','37%');
					});

					$('#footer #members').click(function(){
						myDialog({
							id:'#friendsListDialog',
							style:{'min-height':200},
							buttons:{},
							after: function (options,dialog){
								 getMembersGroup();
								$('.buttons a',dialog).attr('onclick',"closeDialogmembersGroup('#friendsListDialog');");
								$('.optional',dialog).addClass('dnone');
								$('.members',dialog).removeClass('dnone');
								$('.this-button',dialog).hide();
								$('.this-search',dialog).css('width','100%');
							}
						});
					});
					$('#footer #leave').click(function(){
						myDialog({
							id:'#leaveDialog',
							content: lang.GROUPS_LEAVEMESSAGE,
							style:{'min-height':30},
							buttons:[{
								name:lang.yes,
								action:function (){
									var that=this;
									console.log(admin)
									if (admin && numAdm<=1){
										that.close();
										myDialog({
											id:'#selectAdmin',
											scroll:true,
											content: '<strong>'+lang.GROUPS_LEAVEASIGNAR+': </strong>'+lang.GROUPS_LEAVEASIGNARMSG+'.<br><br><strong>'+lang.GROUPS_LEAVEABANDONAR+': </strong>'+lang.GROUPS_LEAVEABANDONARMSG,
											style:{'min-height':100},
											buttons:[{
												name:lang.GROUPS_LEAVEASIGNAR,
												action:function(){
													this.close();
													selectFriendsDialog($.local('code'),[id,true]);
													$('#friendsListDialog .buttons a').attr('onclick',"sendadminGroup('#friendsListDialog','"+id+"');");
													$('#friendsListDialog .this-button').show();
													$('#friendsListDialog .this-search').css('width','37%');
												}
											},{
												name:lang.GROUPS_LEAVEABANDONAR,
												action:function(){
													myAjax({
														loader	: true,
														type	: 'POST',
														url		: DOMINIO+'controls/groups/actionsGroups.json.php?action=4&force=1&&admin=1&grp='+id,
														dataType: 'json',
														success	: function(data) {
															if (data.leave=='true')
																that.close(function(){
																	myDialog({
																		id: '#default',
																		content: lang.GROUPS_LEAVEMESSAGEFINAL,
																		buttons:{
																			ok:function(){
																				redir('lstgroups.html?action=2');
																			}
																		}
																	});
																});
														},
														error	: function() {
															myDialog('#singleDialog', 'ERROR-getadminMembers');
														}
													});
												}
											},
											{name:'Close',action:'close'}
											]
										});
									}else{
										myAjax({
											loader	: true,
											type	: 'POST',
											url		: DOMINIO+'controls/groups/actionsGroups.json.php?action=4&force=1&grp='+id,
											dataType: 'json',
											success	: function(data) {
												if (data.leave=='true')
													that.close(function(){
														myDialog({
															id: '#default',
															content: lang.GROUPS_LEAVEMESSAGEFINAL,
															buttons:{
																ok:function(){
																	redir('lstgroups.html?action=2');
																}
															}
														});
													});
											},
											error	: function() {
												myDialog('#singleDialog', 'ERROR-getadminMembers');
											}
										});
									}
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
	function sendadminGroup(idDialog,id){
	console.log('sendadminGroup');
	var friends=[],a=0;
	$('input:checkbox',idDialog).each(function(i,field){
		if ($(field).is(':checked')) {
			var userInfo=field.value.split('|');
			console.log(userInfo);
			friends[a++]=userInfo[0];
		};
	});
	if (friends.length>0){
		myAjax({
			url		:DOMINIO+'controls/groups/actionsGroups.json.php?action=6&grp='+id,
			data:{uemails:friends},
			dataType:'JSON',
			success	:function(data){
				if(data['asig']=='true') 
					myDialog({
						id: '#default',
						content: lang.GROUPS_LEAVEMESSAGEFINAL,
						buttons:{
							ok:function(){
								redir('lstgroups.html?action=2');
							}
						}
					});
				else myDialog('#singleDialog',lang.TAG_DELETEDERROR);
			},
			error	:function(){
				myDialog('#singleDialog','ERROR-invitedFriends');
			}
		});		
	}
	$('.closedialog',idDialog).click();
}
function sendInvitationMemberGrp(idDialog,id){
	console.log('sendInvitationMemberGrp');
	var friends=[],a=0;
	$('input:checkbox',idDialog).each(function(i,field){
		if ($(field).is(':checked')) {
			var userInfo=field.value.split('|');
			console.log(userInfo);
			friends[a++]=userInfo[0];
		};
	});
	if (friends.length>0){
		myAjax({
			url		:DOMINIO+'controls/groups/actionsGroups.json.php?action=5',
			data:{grp:id,friends:friends},
			dataType:'JSON',
			success	:function(data){
				if(data['mensj']=='invite') myDialog('#singleDialog',lang.GROUPS_SENDINVITATION);
			},
			error	:function(){
				myDialog('#singleDialog','ERROR-invitedFriends');
			}
		});		
	}
	$('.closedialog',idDialog).click();
}
function insertUserGroup(idGroup){
	console.log(DOMINIO+'controls/groups/actionsGroups.json?action=3&grp='+idGroup);
	myAjax({
		url:DOMINIO+'controls/groups/actionsGroups.json.php?action=3&grp='+idGroup,
		dataType:'JSON',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			switch(data.join){
				case 'true': case true: location.reload(); break;
				case 'existe': myDialog('#singleDialog', GROUPS_CLOSE+' '+GROUPS_RESQUEST_SENT); break;
				case 'private-nosent': myDialog('#singleDialog', GROUPS_CLOSE+' '+GROUPS_RESQUEST_WAIT); break;
				case 'secrete': myDialog('#singleDialog', GROUPS_PRIVATE+' '+GROUPS_RESQUEST_PRIVATE); break;
			}
		}
	});
}
	</script>
</div>
<?php include 'inc/footer.php'; ?>