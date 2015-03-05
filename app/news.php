<?php include 'inc/header.php'; ?>
<div id="page-news" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="profile" style="position:absolute;top:0px;left:0;padding:5px;">
			<span class="photo"></span> 
			<span class="info">
				<span class="name"></span>
				<span class="points"></span>
			</span>
		</div>
		<div id="sub-menu"><ul class="ui-grid-d"></ul></div>
	</div>
	<div data-role="content" class="list-content">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div></div>
				<div><ul data-role="listview" id="infoList" data-divider-theme="b" class="list-info" data-autodividers="true"></ul></div>
				<div id="pullUp"><div><span class="pullUpIcon"></span><span class="pullUpLabel"></span></div></div>
			</div>
		</div>
	</div><!-- content -->
	<script type="text/javascript">
		pageShow({
			id:'#page-news',
			// title:lang['NEWS'],
			// buttons:{showmenu:true,creation:true},
			before:function(){
				newMenu();
				//languaje
				$('.pullDownLabel').html(lang.SCROLL_PULLDOWN);
				$('.pullUpLabel').html(lang.SCROLL_PULLUP);
				$('#buttonBack_groups').html(lan('Back'));
				$('#labelGroups').html(lang.MAINMNU_GROUPS);
				$('#labelMyGroups').html(lang.GROUPS_MYGROUPS);
				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
				$('#searchPreferences').attr('placeholder', lang.PREFERENCES_HOLDERSEARCH);
				$('#sub-menu ul').html(
					'<li class="ui-block-a timeline"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
					'<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
					'<li class="ui-block-c points"></li>'+
					'<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newtag','ucw')+'</a></li>'
				);
				$('#profile span.info .name').html($.local('full_name'));
				$('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')+'"></a>');
			},
			after:function(){
				$('#page-lstGroups .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				var action={refresh:{refresh:true},more:{}},$info=$('#infoList'),on={};
				$info.listview({
					autodividersCounter:true,
					//autodividersGroup:true,
					autodividersSelector: function ( $li ) {
						var out = $li.attr('date').match(/\w+(\s+\d+)?|\d+-\d+-\d+/)[0];
						return out;
					}
				}).on('click','li[data-type]',function(){
					var type=this.dataset.type,
						source=this.dataset.source,
						url='';
					switch(type){
						case 'tag':url=PAGE['tag']+'?id='+source; break;
						case 'usr':url=PAGE['profile']+'?id='+source; break;
						case 'product':url=PAGE['detailsproduct']+'?id='+source; break;
						default: alert(type);
					}
					if(url){
						redir(url);
					}
				});
				$('#pd-wrapper').ptrScroll({
					onPullDown:function(){
						console.log('refresh');
						action.refresh.date=action.refresh.date||action.more.date;
						getNews('refresh',action.refresh,on,$info);
					},
					onPullUp:function(){
						console.log('more');
						getNews('more',action.more,on,$info);
					},
					onReload:function(){
						console.log('reload');
						action.more={};
						$info.html('');
						getNews('reload',action.more,on,$info);
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
