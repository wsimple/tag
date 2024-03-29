<?php include 'inc/header.php'; ?>
<style>
	.ui-page .ui-content{
		margin: 4px 0;
	}
</style>
<div id="page-friendUser" data-role="page" data-cache="false">
	<div  data-role="header" data-theme="f" data-position="fixed">
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;"></div>
	</div>
	<div data-role="content" class="list-content">
		<div id="rowTitleMove"><ul class="ui-grid-b"></ul></div>
		<div class="list-wrapper">
			<div id="scroller">
				<div id="friends" class="list">
					<ul class="list-friends ui-grid-b"></ul>
				</div>
				<div id="follow" class="list">
					<ul class="list-friends ui-grid-b"></ul>
				</div>
				<div id="unfollow" class="list">
					<ul class="list-friends ui-grid-b"></ul>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f" style="visibility: hidden;">
		<div data-role="navbar">
			<ul id="friendsFooter">
				<li><a href="#" id="seek" onclick="redir(PAGE['findfriends'])"></a></li>
			</ul>
		</div>
	</div>
</div>
<script>
	pageShow({
		id:'#page-friendUser',
		title:lan('friends','ucw'),
		buttons:{showmenu:false,creation:false},
		before:function(){
			newMenu();
			$('#searchFriends').attr('placeholder',lang.inputPlaceHolder);
			$('#seek').html(lang.seek);
			$('#menu').html(
				'<span class="ui-block-a menu-button hover"><a href="#"><img src="css/newdesign/friends.png"><br>'+lan('friends','ucw')+'</a></span>'+
				'<span class="ui-block-b menu-button"></span>'+
				'<span class="ui-block-c menu-button"></span>'+
				'<span class="ui-block-d menu-button"><a href="findFriends.html" title="Suggest"><img src="css/newdesign/menu/friends.png"><br>'+lan('suggest','ucw')+'</a></span>'+
				'<span class="ui-block-e menu-button"><a href="findFriends.html" title="Search"><img src="css/newdesign/search.png"><br>'+lan('search','ucw')+'</a></span>'
			);
			$('#rowTitleMove ul').html(
				'<li class="ui-block-a" opc="friends" >'+lan('friends','ucw')+'</li>'+
				'<li class="ui-block-b" opc="follow" >'+lan('admirers','ucw')+'</li>'+
				'<li class="ui-block-c" opc="unfollow" >'+lan('admired','ucw')+'</li>'+
				// '<li class="ui-block-d" opc="privateTags" >'+lang.JS_PRIVATETAGS+'</li>'+
				'<li class="ui-block-z" style="width:100%;"><a><img src="css/newdesign/menu.png"></a><span></span></li>'
			);
		},
		after:function(){
			$('#page-friendUser .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
			var $wrapper=$('.list-wrapper'), pag=1,perpag=21,
				type=$_GET['type']||'friends',
				opc={wrapper: $wrapper,get:'&offset='+perpag,user:$_GET['id_user']||'',perpag:21},
				modaux='',layeraux=null;
			var t=$('#rowTitleMove ul li[opc="'+type+'"]').addClass('ui-btn-active').text();
			$('#rowTitleMove ul li.ui-block-z').addClass('ui-btn-active').find('span').html(t);

			// $(opc.layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
			$('.list-wrapper').jScroll({hScroll:false});
			$('.list-content input').keyup(function() {
				$('.list-wrapper').jScroll('refresh');
			});


			$(this.id).on('click','#seemore', function(event) {
				opc.get = '&offset='+perpag+'&limit='+(perpag*pag++);
				viewFriends('more',$.extend({mod:modaux,layer:layeraux},opc));
			});
			
			$('#rowTitleMove ul').on('click','[opc]',function(){
				type=$(this).attr('opc');
				$('#rowTitleMove ul li[opc]').slideUp('fast',function(){
					$('#rowTitleMove ul li.ui-block-z').slideDown('fast');
				});
				$('#rowTitleMove ul li').removeClass('ui-btn-active');
				t=$('#rowTitleMove ul li[opc="'+type+'"]').addClass('ui-btn-active').text();
				$('#rowTitleMove ul li.ui-block-z').addClass('ui-btn-active').find('span').html(t);
				modaux=type;
				layeraux='#'+type+' ul';
				pag = Math.round( $(layeraux+' .userInList').length/perpag );
				if (pag == 0) { pag = 1};
				$wrapper.jScroll(function(){
					this.scrollTo(0,0,100);
				}).jScroll('refresh');
				$('#scroller > .list').hide();
				$('#'+type+'.list').show();
				$('.list-content input').val('');
			}).on('click','li.ui-block-z a',function(){
				$(this).parents('li').slideUp('fast',function(){
					$('#rowTitleMove ul li[opc]').slideDown('fast');
				});
			});
			$('#rowTitleMove ul li[opc='+type+']').click();

			viewFriends('refresh',$.extend({mod:'friends',layer:'#friends ul'},opc));
			viewFriends('refresh',$.extend({mod:'follow',layer:'#follow ul'},opc));
			viewFriends('refresh',$.extend({mod:'unfollow',layer:'#unfollow ul'},opc));
			//Acciones dialog user
			$('body').on('click','[code]',function(){
				redir(PAGE['profile']+'?id='+$(this).attr('code'));
			});
			linkUser(this.id, $wrapper);
			var scroller,v=true,y=-50;
			$('.list-wrapper').jScroll(function(){
				scroller=this;
			});
			$('.list-wrapper').bind('touchmove',function(){
				if (scroller.y>-60){
					$('#rowTitleMove').removeClass('no-v');
					$('#page-friendUser .list-wrapper').css('top','80px');
				}else{
					$('#page-friendUser .list-wrapper').css('top','46px');
					if (scroller.y<y){
						if (v){
							v=false;
							$('#rowTitleMove').addClass('no-v');
						}
					}else{
						if (!v){
							v=true;
							$('#rowTitleMove').removeClass('no-v');													
						}
					}
					y=scroller.y;
				} 
			})	
		}
	});
</script>
<?php include 'inc/footer.php'; ?>
