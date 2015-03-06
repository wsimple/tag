<?php include 'inc/header.php'; ?>
<script>
	//$.session('countpage',0);
	if($.session('_post_')){
		$.session('_post_',null);
		window.location.reload();
	}
</script>
<div id="singleRedirDialog" class="myDialog" style="display: none;">
	<div class="table">
		<div class="cell">
			<div class="window" style="max-height: 272px; display: block;">
				<div class="container" style="max-height: 272px;">
					<div id="scroller" class="content">
						
					</div>
				</div>
				<div class="buttons">
					<a action="0" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined">
						<span class="ui-btn-inner ui-btn-corner-all">
							<span class="ui-btn-text">Sí</span>
						</span>
					</a>
					<a action="1" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-hover-f ui-btn-up-f ui-btn-up-undefined">
						<span class="ui-btn-inner ui-btn-corner-all">
							<span class="ui-btn-text">No</span>
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>
<div class="closedialog" style="display:none"></div></div>
<div id="page-tagsList" data-role="page" data-cache="false" class="smt-no-scroll no-footer">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<div id="profile" style="position:absolute;top:0px;left:0;padding:5px;">
			<span class="photo"></span> 
			<span class="info">
				<span class="name"></span>
				<span class="points"></span>
			</span>
		</div>
		<div class="notificacion-area" id="notifications">
			<span class="notification-num"><a href="notifications.html">0</a></span>
		</div>
		<div id="sub-menu"><ul class="ui-grid-d"></ul></div>
		<div id="rowTitleMove"><ul class="ui-grid-c"></ul></div>
	</div>
	<div data-role="content">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div class="smt-tag-content"><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div></div>
				<div id="tagsList" class="cursor tags-list" style="min-height:300px;background:#fff;"></div>
				<div id="pullUp"><div class="smt-tag-content"><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
			</div>
		</div>
	</div>
	<div id="friendsListDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="container" style="font-size: 50%;height:300px;">
				<div class="this-search" style="display:inline-block;margin-right:5px;width:37%;">
					<input id="like_friend" name="like_friend" type="text" value="" data-inline="true" class="no-disable" />
				</div>
				<div class="this-button" style="display:inline-block;width:60%;">
					<input type="button" id="all" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(true,'#friendsListDialog')" class="no-disable" data-mini="true"  style="padding: 0;"/>
					<input type="button" id="none" data-inline="true" data-theme="f" onclick="checkAllCheckboxs(false,'#friendsListDialog')" class="no-disable" data-mini="true" style="padding: 0;"/>
				</div>
				<div class="clearfix"></div>
				<div class="list-wrapper" style="margin-top:5px;"><div id="scroller"><ul data-role="listview" data-inset="true"></ul><div class="clearfix"></div></div></div>
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
				newMenu();
				createSearchPopUp('#page-tagsList');
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c" >&nbsp;</li>'+
					'<li class="ui-block-d srcico"><a href="#searchPopUp" data-rel="popup" data-position-to="window">'+lan('search','ucw')+'</a></li>'+
					'<li class="ui-block-e newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'
				);				
				$('.pullDownLabel').html(lang.SCROLL_PULLDOWN);
				$('.pullUpLabel').html(lang.SCROLL_PULLUP);
				// $('#groupTitle').html(lang.GROUPS_MEMBERSTITLE2);
				$('#all,#all2').val(lan('All'));
				$('#none,#none2').val(lang.none);
				// $('#assignAdminGrp').val(lang.GROUPS_ASSIGNADMIN);
				$('#like_friend').attr('placeholder',lang.inputPlaceHolder);
				var current=$_GET['current']||'tagsUser';
				if(current=='tagsUser'){
					$('#rowTitleMove ul').html(
						'<li class="ui-block-z ui-btn-active" style="width:100%;"><span>'+lang.MAINMNU_MYTAGS+'</span></li>'
					);
					// $('#pageTitle').html(lang.MAINMNU_MYTAGS);
					// $('#pd-wrapper').css('top','30px');
					// $('div[data-role="content"]').prepend('<div class="ui-listview-filter ui-bar-c" style="margin: auto;"><div id="rowTitle">'+lang.MAINMNU_MYTAGS+'</div></div>');
				}else if(current=='personalTags'){
					$('#rowTitleMove ul').html(
						'<li class="ui-block-z ui-btn-active" style="width:100%;"><span>'+lang.MAINMNU_PERSONALTAGS+'</span></li>'
					);
					// $('#pageTitle').html(lang.MAINMNU_PERSONALTAGS);
					// $('#pd-wrapper').css('top','30px');
					// $('div[data-role="content"]').prepend('<div class="ui-listview-filter ui-bar-c" style="margin: auto;"><div id="rowTitle">'+lang.MAINMNU_PERSONALTAGS+'</div></div>');
				}else if(current=='group'){
					$('#rowTitleMove ul').html(
						'<li class="ui-block-a" opc="invite" >'+lang.GROUPS_INVITED+'</li>'+
						'<li class="ui-block-b" opc="members" >'+lang.GROUPS_MEMBERSTITLE+'</li>'+
						'<li class="ui-block-c" opc="leave" >'+lang.GROUPS_LEAVEABANDONAR+'</li>'+
						'<li class="ui-block-c" opc="close" >'+lan('Back','ucw')+'</li>'+
						'<li class="ui-block-z ui-btn-active" style="width:100%;"><a style="display:none;"><img src="css/newdesign/menu.png"></a><span>'+lan('group','ucw')+'</span></li>'
					);
				}else{ $('#rowTitleMove').remove(); }
				$('#profile span.info .name').html($.local('full_name'));
				$('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')+'"></a>');
			},//end before
			after:function(){
				var current=$_GET['current']||'tagsUser',layer='#tagsList',id=$_GET['id'];
				var opc={current:current,layer: layer };
				if((current=='tagsUser')||(current=='personalTags')){
					opc.get='&uid='+$_GET['id']+'&rtitle';
					opc.title=true;
				}
				if(current=='group'){
					opc.get='&grupo='+$_GET['id'];
					opc.id=$_GET['id'];
					opc.code=$.local('code');
				}
                if(current=='hash') opc.get='&hash='+$_GET['hash'];
				$('.list-wrapper').jScroll({hScroll:false});
				/*action menu tag*/
				actionsTags(opc.layer);
				/*and action menu tag*/

				$('#pd-wrapper',this.id).ptrScroll({
					onPullDown:function(){
						updateTags('refresh',opc);
					},
					onPullUp:function(){
						updateTags('more',opc);
					},
					onReload:function(){
						updateTags('reload',opc);
					}
				});
				$(opc.layer).on('click', 'menu #other-options', function(){
					$('.sub-menu-tag').find('ul').hide();
					$(this).find('ul').show();
				});
				if(current=='group'){
					var admin=false,numAdm=0;
					// $('#pageTitle').html(lan('group','ucw'));
					nameMenuGroups(id,0,function(data){
						$('#rowTitleMove .ui-block-z span').html(lan('group','ucw')+': '+data['name']);
						verifyGroupMembership(id,$.local('code'),function(data){
							if(data['isMember']){
								$('#rowTitleMove .ui-block-z a').show();
								$('#sub-menu .newtag a').attr('href',"newtag.html?group="+id);
								admin=data['admin']=='0'?false:true;
								numAdm=data['numAdm'];
							}else{
								$('#sub-menu .newtag').removeClass('newtag').addClass('groups')
								.html('<a>'+lang.GROUPS_JOIN+'</a>')
								.click(function(){
									insertUserGroup(id);
								});
							}
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
					$('#rowTitleMove').on('click','li a',function(){
						$(this).parents('li').slideUp('fast',function(){
							$('#rowTitleMove ul li[opc]').slideDown('fast');
						});
					}).on('click','li[opc="close"]',function(){
						$('#rowTitleMove ul li[opc]').slideUp('fast',function(){
							$('#rowTitleMove ul li.ui-block-z').slideDown('fast');
						});
					}).on('click','li[opc="invite"]',function(){
						selectFriendsDialog($.local('code'),id);
						$('#friendsListDialog .buttons a').attr('onclick',"sendInvitationMemberGrp('#friendsListDialog','"+id+"');");
						$('#friendsListDialog .this-button').show();
						$('#friendsListDialog .this-search').css('width','37%');
					}).on('click','li[opc="members"]',function(){
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
					}).on('click','li[opc="leave"]',function(){
						myDialog({
							id:'#leaveDialog',
							content: lang.GROUPS_LEAVEMESSAGE,
							style:{'min-height':30},
							buttons:[{
								name:lang.yes,
								action:function (){
									var that=this;
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
	console.log("insertUserGroup");
	myAjax({
		url:DOMINIO+'controls/groups/actionsGroups.json.php?action=3&grp='+idGroup,
		dataType:'JSON',
		error:function(/*resp,status,error*/){
			myDialog('#singleDialog',lang.conectionFail);
		},
		success	:function(data){
			switch(data.join){
				case 'true': case true: location.reload(); break;
				case 'existe': myDialog('#singleDialog', lang.GROUPS_CLOSE+' '+lang.GROUPS_RESQUEST_SENT); break;
				case 'private-nosent': myDialog('#singleDialog', lang.GROUPS_CLOSE+' '+lang.GROUPS_RESQUEST_WAIT); break;
				case 'secrete': myDialog('#singleDialog', lang.GROUPS_PRIVATE+' '+lang.GROUPS_RESQUEST_PRIVATE); break;
			}
		}
	});
}
	</script>
</div>
<?php include 'inc/footer.php'; ?>