<div class="inside-box">
	<div id="tablaNoti"></div>
	<div class="clearfix"></div>
	<input name="reviewx" id="reviewx" type="hidden" value="" />
</div><!-- inside-box -->
<script>
	$(document).ready(function(){
		var posi=false;
		var $info=$('<?=$dialog?'#divNoti':'container'?> #tablaNoti'),
			opc={
				layer:$info[0],
				data:{}
			};
		function peopleFormat(usr,num){
			if(!usr) return '';
			num=num||usr.length;
			var	i,max=3,len=num>max?max:num,ult=len-1,
				usrs='',imgs='',action;
			for(i=0;i<len;i++){
				if(i===ult && num>max){
					usrs+=' [_AND_] <b>'+(num-ult)+' [_MORE_]</b>';
				}else{
					if(i>0) usrs+=i<ult?', ':' [_AND_] ';
					action=(' action="profile,'+usr[i]['uid']+'"');
					if(usr[i]['photo']){
						imgs=imgs||('<div'+action+' class="usr-pic" style="background-image:url('+FILESERVER+usr[i]['photo']+');"'+'"></div>');
					}
					usrs+='<span'+action+'>'+usr[i]['name']+'</span>';
				}
			}
			imgs=imgs||('<div'+action+' class="usr-pic"></div>');
			return [imgs,usrs];
		}
		function newsFormat(d){return(
				'<div '+(d.rev<='1'?'action="viewNoti,'+d.source+','+d.tipo+'"':'')+' type="'+d.type+'" date="'+d.date+'" source="'+d.source+'" class="border-b'+(d.rev<='1'?' notiNoRevi':' notiRevi')+'">'
				+	'<div l="1">'+(d.photos||'')+'</div>'
				+	'<div m="1" class="limitComent'+(d.type=='order'?' order':'')+'">'
				+		'<p>'+d.txt+' (<span class="dateNoti">'+(d.date||'').replace(/\s+/g,'&nbsp;')+'</span>)</p>'
				+		'<div class="clearfix"></div>'
				+	'</div>'
				+	'<div r="1">'
				+		'<img src="css/smt/news/finishedwork'+(d.rev<='1'?'':'1')+'.png" width="25" height="25" border="0"/>'
				+	'</div>'
				+	'<div class="clearfix"></div>'
				+'</div>'
		);}
		function updateNews(action,opc,loader){
			if(!opc.on) opc.on={};
			var act,
				tmp=action,
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
				if(act.more===false && action!='refresh'){ return onca(false); } //checked&
				var url='controls/notifications/notifications.json.php?action='+action+(opc.date?'&date='+opc.date:'')+get
				$.ajax({
					url		:url,
					data	:$.extend({},act,opc.data),
					dataType:'json',
					error	:function(/*resp, status, error*/) {
						console.log('<?=JS_ERROR?>','<?=CONECTIONFAIL?>');
					},
					success	:function(data){
						eval(data.txtFormat);
						opc.date=data['date'];
						if(action=='more'&&(!data['info']||data['info'].length<1)) opc.more=false;
						if(!cancel()&&data['info']&&data['info'].length>0){
							//if(!opc.refresh)
								act.start=(act.start||0)+data['info'].length;
							var i,j,out='',info,d,people,dialog='<?=$dialog?$dialog:''?>';
							if (dialog!='') viewUserNotifications(data['push']);
							for(i=0;i<data['info'].length;i++){
								info=data['info'][i];
								
								d={
									type:info['type'],
									date:info['fdate'],
									icon:info['icon'],
									rev:info['revised'],
									tipo:info['id_type'],
									source:info['source']
								};
								people=peopleFormat(info['friends'],info['num_friends']);
								switch(d.type){
									case 'usr':
										for(j=0;j<info['friends'].length;j++){
											people=peopleFormat([info['friends'][j]]);
											//d.source = info['friends'][j]['code'];
											d.photos = people[0];
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
												txt:data['txt']
											});
											out+=newsFormat(d);
										}
									break;
									case 'tag':
										//if (info['owner']){
											var ac=' action="comment,'+info['idsource']+'"',
												tag=' <img'+ac+' src="'+FILESERVER+'img/tags/'+info['source'].substr(-16)+'.m.jpg" style="height:25px;"/>';
											d.photos=people[0]+tag;
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
												num:info['num_friends'],
												txt:data['txt'],
												tag:'<span'+ac+'>[_TAG_]</span>'
											});
											out+=newsFormat(d);
										//}
									break;
									case 'group':
										//if(info['group']){
											d.photos = people[0];
											act='action="groupsDetails,'+info['group']['Mid']+'"';
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
												num:info['num_friends'],
												txt:data['txt'],
												group:'<u '+act+'>'+info['group']['name']+'</u>'
											});
											for(j in info['friends']){
												if(!d.photo&&info['friends'][j]['photo']) d.photo = info['friends'][j]['photo'];
											}
											out+=newsFormat(d);
										//}
									break;
									case 'order':
										d.photos='';
										d.txt=txtFormat({
											type:info['id_type'],
											people:people[1],
											num:info['num_friends'],
											txt:data['txt'],
											order:'<span action="ordersViews,'+info['source']+'">'+info['order']+'</span>'
										});
										out+=newsFormat(d);
									break;
									case 'product':
										//d.photos='';
										d.photos = people[0];
										d.txt=txtFormat({
											type:info['id_type'],
											people:people[1],
											num:info['num_friends'],
											txt:data['txt'],
											prod:'<span action="detailProd,'+info['source']+'">[_PROD_]</span>'
										});
										out+=newsFormat(d);
									break;
									case 'raffle':
										//if(info['raffle']){
											d.photos = people[0];
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
												num:info['num_friends'],
												txt:data['txt'],
												raffle:'<span action="detailProd,'+info['raffle']['product']+'&rfl=1">[_RAFFLE_]</span>'
											});
											out+=newsFormat(d);
										//}
									break;
									default:
										d.photos='';
										d.txt=txtFormat({
											type:info['id_type'],
											people:people[1],
											num:info['num_friends'],
											txt:data['txt']
										});
										out+=newsFormat(d);
								}
							}
							
							if(action=='more') $(layer).append(out);
							else $(layer).prepend(out);
							<?php if ($dialog){ ?>
								$('#tablaNoti div[source]:gt(8)',layer).remove();
								$('#menu_notifications').show();
							<?php }else{ ?>
								$('#notifications-box').css('display','block');
							<?php } ?>
							
						}
					},
					complete:function(){
						if(loader) $.loader('hide');
						onca(false);
					}
				});
				return true;
			}
			return false;
		}
		updateNews('reload',opc);
		var action={refresh:{refresh:true},more:{}},$info=$('container #tablaNoti, #divNoti #tablaNoti'),on={};
		action.more={};
		
		function viewUserNotifications(number){
			var aux,titulo;
			if (number>0){
				if(number>50) number='50+';
				$('#numNoti').addClass('more').children().empty().html(number);
				titulo = document.title.split('-');
				aux = titulo[0].split(')');
				if (aux[1]){ document.title = "("+ number +") " +aux[1] +' - '+titulo[1]; }
                else{ document.title = "("+ number +") " + titulo[0] +' - '+titulo[1]; }
			}else{
				$('#numNoti').removeClass('more').children().empty().html(0);
				titulo = document.title.split('-');
				aux = titulo[0].split(')'); //alert(aux[0]+', '+aux[1]);
				document.title = (aux[1]?aux[1]:titulo[0]) +' - '+titulo[1];
			}
		}

<?php if(!$dialog){?>
	$(document).on('scroll',function(){
		if ((window.location.hash=='#home')||(window.location.hash=='')){
			if ($(document).scrollTop() >= ($(document).height() - $(window).height())*0.8){
				if(!posi){
					posi=true;
					updateNews('more',opc);
				}
			}else{ posi=false; }
		}
	});
<?php }else{ ?>
		setInterval(function(){
			updateNews('refresh',opc);
		}, 30000);
<?php } ?>
	});
</script>
