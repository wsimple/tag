<?php include 'inc/header.php'; ?>
<div id="page-profile" data-role="page" data-cache="false">
	<div id="sub-menu" style="position:absolute;top:0px;left:0;padding:0px;" data-position="fixed"  >
		<ul class="ui-grid-d"></ul>
	</div>
	<div data-role="content" data-theme="d" class="no-footer">
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">

				<div style="height:60px;margin:19px;">
					<div id="wrap">
					   <div id="contents">
							<img id="userPicture" style="float:left;height:60px;width:60px;" class="userBR" />
							<div id="userInfo" style="float:left;margin-left:13px;"></div>
							<div style="clear: both;"></div>
					   </div>
					</div>
				</div>

				<div id="globalButtons" align="center">
					<!-- style="display:none;"  -->
					<a id="pictureButton" data-role="button" data-theme="m" class="intext" style="display:none;">&nbsp;</a>
					<div id="userFriends" data-role="button" data-theme="m">&nbsp;</div>
					<div id="userFollowers" data-role="button" data-theme="m">&nbsp;</div>
					<div id="userFollowing" data-role="button" data-theme="m">&nbsp;</div>
					<div id="userPreferences" data-role="button" data-theme="m">&nbsp;</div>
					<div class="ui-grid-a" id="nameBox" style="width:80%">
						<div class="ui-block-a">
							<div id="userTags" data-role="button" data-theme="n">&nbsp;</div>
						</div>
						<div class="ui-block-b">
							<div id="userPersonalTags" data-role="button" data-theme="n">&nbsp;</div>
						</div>
					</div>
					<a id="followButton" style="display:none;" data-role="button" data-theme="l" data-icon="plus" data-iconpos="right" style="margin-top:25px;">&nbsp;</a>
				</div>
				<div id="error"></div>
			</div>
		</div>
	</div>

	<!-- Dialogs -->
	<div id="shareTagDialog" class="myDialog"><div class="table"><div class="cell">
		<div class="window">
			<div class="container" style="font-size: 50%;height:340px;">
				<div class="title"></div>
				<div class="list-wrapper" style="top:20px">
					<div id="scroller">
						<div class="this-search" style="margin-bottom:10px;width:100%;height:20px;">
							<input id="like_friend" name="like_friend" type="text" placeholder="Search" value="" data-inline="true" class="no-disable" style="font-size: 12px" />
						</div>
						<ul id="ulListFriends" data-role="listview" data-inset="true" class="ui-grid-b"></ul>
				</div>
			</div>
		</div>
		<div class="buttons">
			<a href="#" id="closeBtn" data-role="button" onclick="closeDialogmembersGroup('#shareTagDialog')" data-theme="n">Ok</a>
		</div>
	</div>

	<script>
		pageShow({
			id:'#page-profile',
			buttons:{showmenu:true,creation:true},
			title:lang.USER_PROFILE,
			before:function(){
				newMenu();
				createSearchPopUp('#page-profile');
				function buttonText(id,text){ $(id).html(
					'<div class="imagebox"></div><div class="textbox" >'+
					text+' (<b><loader/></b>)</div>'); 
				};
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="#">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c points"><a href="#searchPopUp" data-rel="popup" data-position-to="window">'+lan('search','ucw')+'</a></li>'+
					'<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newTag','ucw')+'</a></li>'
				);

				$('#userInfo').html(
					'<div><strong><loader/></strong></div>'+
					'<div><strong>'+lang.PROFILE_BIRTHDATE+':</strong> <loader/></div>'+
					'<div><strong>'+lan('From')+':</strong> <loader/></div>'
				);
				buttonText('#userFriends',lan('friends','ucw'));
				buttonText('#userFollowers',lan('admirers','ucw'));
				buttonText('#userFollowing',lan('admired','ucw'));
				buttonText('#userTags','Tags');
                $('#userPicture').attr('src',FILESERVER+'img/users/default.png');
				buttonText('#userPersonalTags',lang.PROFILE_PERSONALTAGS);
				$('#userPreferences').html(
					'<div class="imagebox"></div><div class="textbox" >'+
					lang.USERPROFILE_PREFERENCES_TITLE+' </div>');
				$('#pictureButton').html(lan(CORDOVA?'change picture':'edit thumbnail','ucw'));
				$('#shareTagDialog .buttons a').html(lan('exit','ucw'));
			},
			after:function(){
				$('#page-profile .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				var code=$_GET['id']||$.local('code'), me=(code==$.local('code')),opc={
					user:code,
					layer:'#ulListFriends',
					get:'&offset=20',
					mod:"friends",
					noCount:true,
					userN:'',pag:1,perpag:20
				};
				$('.fs-wrapper').jScroll({hScroll:false});

				function loadProfile(data){
					console.log('load profile');
					//cambia el tema de los botones (solo funciona con botones)
					function changeButtonTheme(theme,obj){
						$(obj)
						.attr('data-theme',theme)
						.removeClass(function(index,list){
							var matches=list.match(/ui-btn-(up|hover)-./g) || [];
							return (matches.join(' '));
						}).addClass('ui-btn-up-'+theme);
					}
					//esta funcion define tema y texto del boton follow/unfollow
					function setFollowButton(follow){
						var theme='l',text=lang.follow,icon='ui-icon-plus';
						if(follow){
							theme='u';
							text=lang.unfollow;
							icon='ui-icon-minus';
						}
						changeButtonTheme(theme,'#followButton');
						$('#followButton .ui-btn-text').html(text);
						$('#followButton .ui-icon').removeClass('ui-icon-plus ui-icon-minus').addClass(icon);
					}
					//funcion para llenar el numero de los botones con numeracion
					function fillButton(button,num){
						//if(!num>0) changeButtonTheme('a',button);
						if(num>0)
							$(button).attr('num',num);
						else
							$(button).removeAttr('num');
						if(num===undefined||num===null||num<0) num='<loader/>';
						$('.ui-btn-text b',button).html(num||0);
					}
					function setFriendsButtons(data){data=data||{};
						fillButton('#userFriends',	data['friends_count']?data['friends_count']:data['friends']);
						fillButton('#userFollowers',data['followers_count']?data['followers_count']:data['admirers']);
						fillButton('#userFollowing',data['following_count']?data['following_count']:data['admired']);
					}
					setFriendsButtons(data);
					fillButton('#userTags',			data['numTags']);
					fillButton('#userPersonalTags',	data['numPersTags']);
					if(data['photo_friend']!=data['FILESERVER']+'img/users/default.png') $('#userPicture').attr('src',data['photo_friend']);

					var birth=lan(data['birthday'],'ucw'),
						txt='<div><strong>'+(data['name_user']||data['username'])+'</strong></div>';
					if(data['type']=='0')
						txt+=((birth!='none' && data['birthday']!='private')?'<div><strong>'+lang.PROFILE_BIRTHDATE+':</strong> '+birth+'</div>':'');
					else
						txt+=(data['birthday']!='none'?'<div><strong>'+lang.FOUNDATION_DATE+':</strong> '+data['birthday']+'</div>':'');
					txt+=(data['country'] && data['country']!='none' && data['country']!=''?'<div><strong>'+lan('From')+':</strong> '+data['country']+'</div>':'');
					$('#userInfo').html(txt);
					$('.fs-wrapper').jScroll('refresh');
					$('#globalButtons').on('click','div',function(){
						opc.userN=(data['name_user']||data['username']);
						opc.get='&offset=20';
						if($(this).attr('num')>0){
							switch(this.id){
								case 'userFriends': opc.mod="friends"; profileFriendsDialog("refresh",opc); break;
								case 'userFollowers': opc.mod="follow"; profileFriendsDialog("refresh",opc); break;
								case 'userFollowing': opc.mod="unfollow"; profileFriendsDialog("refresh",opc); break;
								// case 'userFriends': redir(PAGE['userfriends']+'?type=friends&id_user='+code); break;
								// case 'userFollowers': redir(PAGE['userfriends']+'?type=follow&id_user='+code); break;
								// case 'userFollowing': redir(PAGE['userfriends']+'?type=unfollow&id_user='+code); break;
								case 'userTags': redir(PAGE['tagslist']+'?current=tagsUser&id='+md5(data['id'])); break;
								case 'userPersonalTags': redir(PAGE['tagslist']+'?current=personalTags&id='+md5(data['id'])); break;
							}
						}
					});
					linkUser('#ulListFriends');
					$('#ulListFriends').on('click','[code]',function(){
						redir(PAGE['profile']+'?id='+$(this).attr('code'));
					});
					$('#ulListFriends').on('click','#seemore', function(event) {
						opc.get = '&offset='+opc.perpag+'&limit='+(opc.perpag*opc.pag++);
						viewFriends('more',opc);
					});
					$('#userPreferences').click(function(){
						if(me) redir(PAGE['preferences']);
						else preferencesUsers(code,data['name_user']||data['username']);
					});
					if(me){
						$('#followButton').remove();
						if (CORDOVA)
							if(data['photo_friend']){
								$('#pictureButton').fadeIn('slow').click(function(){
									redir(PAGE['profilepic']);
								});
							}
						else $('#pictureButton').remove();
					}else{
						$('#pictureButton').remove();
						var $follow=$('#followButton');
						setFollowButton(data['follow']);
						$follow.fadeIn('slow').click(function(){
							setFriendsButtons({});
							$follow.fadeOut('slow', function () {
								setFollowButton($follow.attr('data-theme')=="l");
								$follow.fadeIn('slow');
							});
							myAjax({
								type:'GET',
								url:DOMINIO+'controls/users/follow.json.php?uid='+md5(data['id']),
								error:function() {
									console.log('follow button ERROR');
								},
								success:function(data){
									if(!data['error']){
										setFriendsButtons(data['friend']);
										// $follow.fadeOut('slow', function () {
											// setFollowButton(!data['unlink']);
											// $follow.fadeIn('slow');
										// });
									}else{
										$follow.fadeOut('slow', function () {
											setFollowButton($follow.attr('data-theme')=="u");
											$follow.fadeIn('slow');
										});u
									}
								}
							});
						});
					}
				}
				myAjax({
					url:DOMINIO+'controls/users/people.json.php?action=specific&code',
					data:{uid:code},
					success:function(data){
						if (!data['error']){
							console.log('success name: '+data.datos[0]['name_user']);
							loadProfile(data.datos[0]);
						}
					},
					error:function(){
						console.log('error');
					}
				});
			}
		});

		function profileFriendsDialog(method, opc){
			console.log('selectfriendsdialog');
			opc.pag=1,opc.perpag=20;
			var idDialog='shareTagDialog',titles=[];  
			titles['unfollow']=lan('admired','ucw');
			titles['follow']=lan('admirers','ucw');
			titles['friends']=lan('friends','ucw');
			$(opc.layer).html('').listview('refresh');
			// userN
			myDialog({
				id:idDialog,
				style:{'min-height':175},
				buttons:{},
				after:function(options,dialog){
					$('#like_friend',dialog).val('');
					$('.title',dialog).html(opc.userN+' '+titles[opc.mod]);
					viewFriends(method, opc);
					var timer;
					$('#like_friend',dialog).unbind('keyup').bind('keyup',function(event){
						if(event.which==8||event.which>40){
							if(timer) clearTimeout(timer);
							timer=setTimeout(function(){
								opc.get+='&like='+$('#like_friend',dialog).val();
								viewFriends(method, opc);
							},1000);
						}
					});
				}
			});
		}
	</script>
</div>
<?php include 'inc/footer.php'; ?>