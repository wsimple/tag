<?php include 'inc/header.php'; ?>
<div id="page-profile" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" data-theme="d" class="no-footer">
		<img class="bg" src="img/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<div>
					<div style="height:60px;margin:19px;">
						<img id="userPicture" style="float:left;height:60px;width:60px;" />
						<div id="userInfo" style="float:left;margin-left:13px;"></div>
					</div>
					<a id="pictureButton" style="display:none;" data-role="button" data-theme="c">&nbsp;</a>
					<div id="globalButtons">
						<div id="userFriends" data-role="button" data-theme="c">&nbsp;</div>
						<div id="userFollowers" data-role="button" data-theme="c">&nbsp;</div>
						<div id="userFollowing" data-role="button" data-theme="c">&nbsp;</div>
						<div id="userTags" data-role="button" data-theme="c">&nbsp;</div>
						<div id="userPersonalTags" data-role="button" data-theme="c">&nbsp;</div>
						<div id="userPreferences" data-role="button" data-theme="c">&nbsp;</div>
					</div>
					<a id="followButton" style="display:none;" data-role="button" data-theme="e" data-icon="plus" data-iconpos="right" style="margin-top:25px;">&nbsp;</a>
				</div>
				<div id="error"></div>
			</div>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-profile',
			buttons:{back:true,home:true},
			title:lang.USER_PROFILE,
			before:function(){
				function buttonText(id,text){ $(id).html(text+' (<b><loader/></b>)'); }
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
				$('#userPreferences').html(lang.USERPROFILE_PREFERENCES_TITLE);
				$('#pictureButton').html(lan(CORDOVA?'change picture':'edit thumbnail','ucw'));
			},
			after:function(){
				console.log('test');
				var code=$_GET['id']||$.local('code'),
					me=(code==$.local('code'));//me=true si es el perfil del usuario loggeado
				$('.fs-wrapper').jScroll({hScroll:false});
				function loadProfile(data){
					console.log('load profile');
					console.log(data);
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
						var theme='e',text=lang.follow,icon='ui-icon-plus';
						if(follow){
							theme='a';
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
						fillButton('#userFriends',	data['friends']);
						fillButton('#userFollowers',data['admirers']);
						fillButton('#userFollowing',data['admired']);
					}
					setFriendsButtons(data);
					fillButton('#userTags',			data['numTags']);
					fillButton('#userPersonalTags',	data['numPersTags']);
					if(data['thumb']) $('#userPicture').attr('src',data['thumb']);

					var birth=lan(data['birthday'],'ucw'),
						txt='<div><strong>'+(data['userName']||'')+'</strong></div>';
					if(data['type']=='0')
						txt+=(birth!='none'?'<div><strong>'+lang.PROFILE_BIRTHDATE+':</strong> '+birth+'</div>':'');
					else
						txt+=(data['birthday']!='none'?'<div><strong>'+lang.FOUNDATION_DATE+':</strong> '+data['birthday']+'</div>':'');
					txt+=(data['country']!='none'?'<div><strong>'+lan('From')+':</strong> '+data['country']+'</div>':'');
					$('#userInfo').html(txt);
					$('.fs-wrapper').jScroll('refresh');
					$('#globalButtons').on('click','div',function(){
						if($(this).attr('num')>0){
							switch(this.id){
								case 'userFriends': redir(PAGE['userfriends']+'?type=1&id_user='+code); break;
								case 'userFollowers': redir(PAGE['userfriends']+'?type=2&id_user='+code); break;
								case 'userFollowing': redir(PAGE['userfriends']+'?type=3&id_user='+code); break;
								case 'userTags': redir(PAGE['tagslist']+'?current=tagsUser&id='+md5(data['id'])); break;
								case 'userPersonalTags': redir(PAGE['tagslist']+'?current=personalTags&id='+md5(data['id'])); break;
							}
						}
					});
					$('#userPreferences').click(function(){
						if(me)
							redir(PAGE['preferences']);
						else
							preferencesUsers(4,code);
					});
					if(me){
						$('#followButton').remove();
						if(data['thumb']){
							$('#pictureButton').fadeIn('slow').click(function(){
								redir(PAGE['profilepic']);
							});
						}
					}else{
						$('#pictureButton').remove();
						var $follow=$('#followButton');
						setFollowButton(data['follow']);
						$follow.fadeIn('slow').click(function(){
							var get='';
							if($follow.attr('data-theme')==='a') get='&unfollow';
							setFriendsButtons({});
							myAjax({
								type:'GET',
								url:DOMINIO+'controls/users/follow.json.php?uid='+md5(data['id'])+get,
								error:function() {
									console.log('follow button ERROR');
								},
								success:function(data){
									if(!data['error']){
										setFriendsButtons(data['friend']);
										$follow.fadeOut('slow', function () {
											setFollowButton(get=='');//si get esta vacio, se hizo seguidos
											$follow.fadeIn('slow');
										});
									}
								}
							});
						});
					}
				}
				myAjax({
					url:DOMINIO+'controls/users/getProfile.json.php?code='+code,
					success:function(data){
						console.log('success '+data['userName']);
						loadProfile(data);
					},
					error:function(){
						console.log('error');
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
