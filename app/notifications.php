<?php include 'inc/header.php'; ?>
<div id="page-notif" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><div><span class="pullDownIcon"></span><span class="pullDownLabel">Pull down to refresh...</span></div></div>
				<div><ul data-role="listview" id="infoList" data-divider-theme="b" class="list-info" data-autodividers="true"></ul></div>
				<div id="pullUp"><div><span class="pullUpIcon"></span><span class="pullUpLabel">Pull up to refresh...</span></div></div>
			</div>
		</div>
	</div><!-- content -->
	<script type="text/javascript">
		pageShow({
			id:'#page-notif',
			title:lang['NOTIFICATIONS']+'<span class="push-notifications" style="display:none;">0</span>',
			buttons:{back:true,home:true},
			before:function(){
				//languaje
				$('#labelGroups').html(lang.MAINMNU_GROUPS);
				$('#labelMyGroups').html(lang.GROUPS_MYGROUPS);
				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
				$('#searchPreferences').attr('placeholder',lang.PREFERENCES_HOLDERSEARCH);
			},
			after:function(){
				var $wrapper=$('#pd-wrapper'),
					$info=$('#infoList'),
					opc={
						layer:$info[0]
					};
				function peopleFormat(usr,num){
					if(!usr) return '';
					num=num||usr.length;
					var	i,max=3,len=num>max?max:num,ult=len-1,usrs='';
					for(i=0; i<len; i++){
						if(i==ult && num>max){
							usrs+=' [_AND_] <b>'+(num-ult)+' [_MORE_]</b>';
						}else{
							if(i>0) usrs+=i<ult?', ':' [_AND_] ';
							usrs+='<b>'+usr[i]['name']+'</b>';
						}
					}
					return usrs;
				}
				function newsFormat(d){return(
					'<li type="'+d.type+'" date="'+d.date+'" source="'+d.source+'" class="ui-li-has-thumb'+(d.rev>1?' notiRevi':' notiNoRevi')+'" '+(d.rev>1?'':'t="'+d.tipo+'" f="'+d.allsource+'"')+'>'+
						'<a>'+
//							'<img src="'+d.photo+'"/>'+
							'<div class="ui-li-thumb'+(d.pic?' '+d.pic:'')+'"'+(d.photo?' style="background-image:url('+FILESERVER+d.photo+');"':'')+'/>'+
							'<p class="title">'+d.txt+'</p>'+
							'<p class="date"><span class="'+d.icon+'"></span> '+d.date+'</p>'+
						'</a>'+
					'</li>'
				);}
				function updateNews(action,opc,loader){
					if(!opc.on) opc.on={};
					var act,
						on=opc.on,
						layer=opc.layer,
						get=opc.get||'',
						empty=opc.empty||'',
						//se cancela la action si se esta ejecutando reload
						cancel=function(){return (action!='reload'&&on['reload']);},
						//se asigna y/o devuelve el estatus de la accion actual
						onca=function(val){if(val!==undefined)on[action]=val;return on[action];};
					if(!opc.data){opc.data={
						limit:15
					};}
					if(!cancel()&&!onca()){
						onca(true);
						if(!opc.actions||action=='reload'){
							opc.actions={
								refresh:$.extend({},opc.data),
								more:$.extend({},opc.data)
							};
							opc.date='';
							$(layer).html('');
						}
						act=opc.actions[action=='refresh'?'refresh':'more'];
						if(loader) $.loader('show');
						//si no hay mas tag, se cancela la consulta
						if(act.more===false){ return onca(false); }
						myAjax({
							url		:DOMINIO+'controls/notifications/notifications.json.php?checked&action='+action+(opc.date?'&date='+opc.date:'')+get,
							data	:$.extend({},act,defaultNotificationTypes),
							error	:function(/*resp, status, error*/){
								myDialog('#singleDialog', lang.conectionFail);
							},
							success	:function(data){
								eval(data.txtFormat);
								if(action=='more'&&(!data['info']||data['info'].length<1)) opc.more=false;
								if(!cancel()&&data['info']&&data['info'].length>0){
									opc.date=data['date'];
									//if(!opc.refresh)
										act.start=(act.start||0)+data['info'].length;
									var i,j,out='',info,d;
									for(i=0;i<data['info'].length;i++){
										info=data['info'][i];
										d={
											type:info['type'],
											date:info['fdate'],
											icon:info['icon'],
											rev:info['revised'],
                                            tipo:info['id_type'],
									        allsource:info['source']
										};
										switch(d.type){
											case 'usr':
												d.pic='usr-pic';
												for(j=0;j<info['friends'].length;j++){
													d.source = info['friends'][j]['code'];
													d.photo = info['friends'][j]['photo'];
													d.txt=txtFormat({
														type:info['id_type'],
														people:peopleFormat([info['friends'][j]]),
														txt:data['txt']
													});
													out+=newsFormat(d);
												}
											break;
											case 'tag':
												d.pic='tag-pic-mini';
												d.source=info['source'];
												d.photo='img/tags/'+d.source.substr(-16)+'.m.jpg';
												d.txt=txtFormat({
													type:info['id_type'],
													people:peopleFormat(info['friends'],info['num_friends']),
													num:info['num_friends'],
													txt:data['txt']
												});
												out+=newsFormat(d);
											break;
											case 'group':
												if(info['group']){
													d.pic='usr-pic';
													d.source = info['group']['id'];
													d.txt=txtFormat({
														type:info['id_type'],
														people:peopleFormat(info['friends'],info['num_friends']),
														num:info['num_friends'],
														txt:data['txt'],
														group:'<u>'+info['group']['name']+'</u>'
													});
													for(j in info['friends']){
														if(!d.photo&&info['friends'][j]['photo']) d.photo = info['friends'][j]['photo'];
													}
													out+=newsFormat(d);
												}
											break;
											default:
												d.pic='usr-pic';
												d.source=info['source'];
												d.txt=txtFormat({
													type:info['id_type'],
													people:peopleFormat(info['friends'],info['num_friends']),
													num:info['num_friends'],
													txt:data['txt']
												});
										}
									}
									if(action=='more')
										$(layer).append(out);
									else
										$(layer).prepend(out);
									$(layer).listview('refresh');
								}
								$wrapper.jScroll('refresh');
							},
							complete:function(){
								if(loader) $.loader('hide');
								onca(false);
								windowFix();
								$.jScroll('refresh');
							}
						});
						return true;
					}
					return false;
				}
				$info.listview({
					autodividersCounter:true,
					//autodividersGroup:true,
					autodividersSelector: function ( $li ) {
						return $li.attr('date').match(/\w+(\s+\d+)?|\d+-\d+-\d+/)[0];
					}
				}).on('click','li[type]',function(){
					var type=$(this).attr('type'),source=$(this).attr('source');
					if ($(this).attr('t')){
					   $.session('notif',{type:$(this).attr('t'),source:$(this).attr('f')});
                       console.log($.session('notif'));
					}
                    switch(type){
						case 'usr': redir(PAGE['profile']+'?id='+source); break;
						case 'tag': redir(PAGE['tag']+'?id='+source); break;
						case 'group':
						case 'order':
						case 'product':
						default: alert(type);
					}
                    
				});
				$wrapper.ptrScroll({
					onPullDown:function(){
						console.log('refresh');
						updateNews('refresh',opc);
					},
					onPullUp:function(){
						console.log('more');
						updateNews('more',opc);
					},
					onReload:function(){
						console.log('reload');
						updateNews('reload',opc);
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
