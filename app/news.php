<?php include 'inc/header.php'; ?>
<div id="page-lstGroups" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
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
			id:'#page-lstGroups',
			title:lang['NEWS'],
			buttons:{showmenu:true,creation:true},
			before:function(){
				//languaje
				$('.pullDownLabel').html(lang.SCROLL_PULLDOWN);
				$('.pullUpLabel').html(lang.SCROLL_PULLUP);
				$('#buttonBack_groups').html(lan('Back'));
				$('#labelGroups').html(lang.MAINMNU_GROUPS);
				$('#labelMyGroups').html(lang.GROUPS_MYGROUPS);
				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
				$('#searchPreferences').attr('placeholder', lang.PREFERENCES_HOLDERSEARCH);
			},
			after:function(){
				newMenu();
				$('#page-lstGroups .ui-btn-inner').css('padding-top',' 5px').css('padding-left', '5px');
				var action={refresh:{refresh:true},more:{}},$info=$('#infoList'),on={};
				function getNews(action,opc){
					function peopleFormat(usr,num){
						num=num||usr.length;
						var	txt='',len=num>3?3:num;
						for(var i=0; i<len; i++){
							if(i>1 && num>3)
								txt+='<b>'+(num-2)+' [_MORE_]</b>';
							else
								txt+='<b>'+usr[i]['name']+'</b>';
							if(len>1 && i<len-1)
								txt+=(i<len-2)?', ':' [_AND_] ';
						}
						return txt;
					}
					function newsFormat(d){return(
						'<li data-type="'+d.type+'" date="'+d.date+'" data-source="'+d.source+'">'+
							'<a>'+
								'<img src="'+d.photo+'"/>'+
								'<p class="title">'+d.txt+'</p>'+
								'<p class="date">'+d.date+'</p>'+
							'</a>'+
						'</li>'
					);}
					var cancel=function(){return action!='reload'&&on['reload'];};
					if(!cancel()&&!on[action]&&opc.more!==false){
						on[action]=true;
						myAjax({
							url		: DOMINIO+'controls/news/newsjson.php?action='+action,
							// url		: DOMINIO+'controls/news/news.json.php',
							dataType: 'json',
							data	: opc,
							error	: function(/*resp, status, error*/) {
								myDialog('#singleDialog', lang.conectionFail);
							},
							success	: function(data){
								eval(data.txtFormat);
								if(action=='more'&&(!data['info']||data['info'].length<1)) opc.more=false;
								if(!cancel()&&data['info']&&data['info'].length>0){
									opc.limit=data['numResult'];
									var i,j,out='',info,d;
									opc.date=data['fecha'];
									if(!opc.refresh) opc.start=(opc.start||0)+data['info'].length;
									for(i in data['info']){
										info = data['info'][i];
										d={
											type:info['type'],
											source:info['source'],
											// txt:lang.info({
											// 	type:info['id_type'],
											// 	friends:peopleFormat(info['friend']),
											// 	usr:'<b>'+info['usrs']['name']+'</b>'
											// }),
											date:info['fdate']
										};
										var friends=peopleFormat(info['usrs']),
  		                               	people=peopleFormat(info['friend']);
										switch(info['type']){
											case 'tag':
													d.photo=FILESERVER+'img/tags/'+info['source'].substr(-16)+'.m.jpg';
		                                            d.txt=txtFormat({
														type:info['id_type'],
														people:people,
		                                                friends:friends,
														txt:data['txt'],
														tag:'[_TAG_]'
													});
													out+=newsFormat(d);										
											break;
											case 'usr':
												d.source=info['keyUser'];
												d.photo =info['usrs'][0]['photo']+'" class="userBR" style="height:90%;';
												d.txt=txtFormat({
													type:info['id_type'],
													people:people,
		                                            friends:friends,
													txt:data['txt']
												});
												out+=newsFormat(d);
											break;
											case 'product':
												d.photo = info['photoS']+'" style="height:90%;';
												d.txt=txtFormat({
													type:info['id_type'],
													people:people,
													txt:data['txt'],
													prod:'[_PROD_]'
												});
												out+=newsFormat(d);
											break;
										}
										// switch(info['id_type']){
										// 	case '1': case '2': case '4': case '7': case '8': case '9': case '10':
										// 		d.type='tag';
										// 		d.source=info['source'];//info['id_source']
										// 		d.photo=FILESERVER+'img/tags/'+d.source.substr(-16)+'.m.jpg';
										// 		out+=newsFormat(d);
										// 	break;
										// 	case '5': case '6': case '11':
										// 		d.type='usrs';
										// 		d.source = info['usrs']['code'];
										// 		for(j in info['friend']){
										// 			if(!d.photo||d.photo.match(/default_thumb.jpg/)) d.photo=info['friend'][j]['photo'];
										// 		}
										// 		out+=newsFormat(d);
										// 	break;
										// }
									}
//									if(opc.refresh)
//										$info.prepend(out).listview('refresh');
//									else
//										$info.append(out).listview('refresh');
									$info[opc.refresh?'prepend':'append'](out).listview('refresh');
								}else{
									// $info.html('');
									if($info.html()==''){
										$info.append('<div class="emptyInfo">'+lang.EMPTY_INFO_NEWS+'<br><br><div id="findFriends" style="font-weight:bold">'+lang.FIND_FRIENDS_NOTIFICATION+'</div></div>');
										$('#pullUp').hide();
										$('#findFriends').click(function(event) {
											redir(PAGE['findfriends']);
										});
									}
								}
								on[action]=false;
								$('#pd-wrapper').jScroll('refresh');
							},
							complete:function(){
								on[action]=false;
							}
						});
					}
				}
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
						getNews('refresh',action.refresh);
					},
					onPullUp:function(){
						console.log('more');
						getNews('more',action.more);
					},
					onReload:function(){
						console.log('reload');
						action.more={};
						$info.html('');
						getNews('reload',action.more);
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
