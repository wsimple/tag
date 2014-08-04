<?php 
$disble=($section!='news')?'style="display:none;width:0px;height:0px"':''; ?>
<div class="ui-single-box mini" id="pageNews" <?php echo $disble; ?> >
    <div class="ui-single-box-title limitTitle"><?=MAINMNU_NEWS_TITLE?></div>
    <div class="news-wrapper">
        <div id="news-here"></div>
        <div id="newsloader" style="width: 555px;float: left;font-weight: bold;color: #ff8a28;">
        	<span class="news-span-loader"><?=JS_LOADING?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" />
       	</div>
        <div class="clearfix"></div>
    </div>
</div>
<script>	
$(function() {
	$.on({
        open:function(){
			//news
			var opc={
					layer:'#noticeInsertTop',
					get:''
				};
			if (SECTION=='news'){ opc.get='&all=1'; }
			$('.store-wrapper .mainMenu a').css('margin-bottom:','0px');$('aside').css('display','block');
			//event handlers
			var  interval,clearEvents=function(){
					clearInterval(interval);
				};
			//puntos
			this.intervalmsk = setInterval(function(){ mskPointsReload('#mskPoints'); },40000);

			//first run
			if($.smt.news){
				// $('#adsListPubli').show();
				$('#info-container').html($.smt.news);
				delete $.smt.news;
			}
			getNews('reload',opc);
			//fin-news

			// FUNCIONES NECESARIAS
	        function newsFormat(d){
	        	if (SECTION!='news')
	        		return(
		                '<tr'+d.clase+' data-info="'+d.id+'">'+
							'<td tipo="'+d.type+'" style="padding:10px; vertical-align:top; border-bottom: 1px solid #f8f8f8" align="center" width="16" height="16" border="0">'+
							'</td>'+
							'<td style="padding:4px 8px 2px 0; font-size:10px;  border-bottom: 1px solid #f8f8f8">'+
								d.txt+'<div class="extras">'+d.photos+'</div>'+
								'<em style="color:#CCC">'+d.date+'</em>'+
							'</td>'+
						'</tr>');
	        	else
	        		return(
	        			'<div'+d.clase+' data-info="'+d.id+'">'+
							'<div tipo="'+d.type+'" style="width:18px;height:18px;padding:10px; vertical-align:top; border-bottom: 1px solid #f8f8f8; display:inline-block;" align="center" border="0">'+
							'</div>'+d.photos+
							'<div style="padding:4px 8px 2px 5px; font-size:10px;  border-bottom: 1px solid #f8f8f8;display:inline-block">'+
								d.txt+'  <em style="color:#CCC">'+d.date+'</em>'+
							'</div>'+
						'</div>'
	        			);
	        }
	        function peopleFormat(usr,num,type){
				if(!usr) return '';
				num=num||usr.length;
				var	i,max=3,len=num>max?max:num,ult=len-1,
					usrs='',imgs='',action;
				for(i=0;i<len;i++){
					if(i===ult && num>max){
						usrs+=' [_AND_] <b>'+(num-ult)+' [_MORE_]</b>';
					}else{
						if(i>0) usrs+=i<ult?', ':' [_AND_] ';
						if (type && ['22','25','26','27'].indexOf(type)<0){ action=action||(' action="profile,'+usr[i]['uid']+'"'); }
	                    else {action=''; }
						if(usr[i]['photo']) 
							imgs=imgs||('<div'+action+'  class="usr-pic" style="background-image:url('+usr[i]['photo']+');width:30px;height:30px;"'+'"></div>');
						usrs+='<span'+(action?action+' style="color: #77c574;"':'')+' >'+usr[i]['name']+'</span>';
					}
					action=null;
				}
				imgs=imgs||('<div'+action+' class="usr-pic"></div>');
				return [imgs,usrs];
			}
			function getNews(action,opc){ 
				if(!opc.on) opc.on={};
				var limit=5,
					on=opc.on,
					layer=opc.layer,
					get=opc.get||'',
					cancel=function(){return (action!='reload'&&on['reload']);},//cancel action
					onca=function(val){if(val!==undefined)on[action]=val; return on[action];};//on current action
					if (opc.get) limit=opc.limite?opc.limite:0;
				if(!cancel()&&!onca()){
					onca(true);
					if(!opc.actions || action=='reload'){
						opc.actions={refresh:{},more:{}};
						opc.date='';
					}
					$.qajax('low',{
						type	: 'GET',
						url		: 'controls/news/newsjson.php?limit='+limit+'&action='+action+(opc.date?'&date='+opc.date:'')+get,
						dataType: 'json',
						complete: function(/*resp, status, error*/) {
							onca(false);
						},
						success	: function(data){
	                        eval(data.txtFormat);
	                        if(data['info'] && data['info'].length>0){
								var i,out='',info,txt,len,type,clase='';
								opc.date=data['fecha'];
								len=data['info'].length;
								if(action!='reload') clase=' style="animation:myfirst 3s; -webkit-animation:myfirst 5s; background:#FFF;"';
								for(i=0;i<len;i++){
									info = data['info'][i];
	                                d={
										type:info['id_type'],
										date:info['fdate'],
										source:info['source'],
	                                    id:info['id'],
	                                    clase:clase
									};
			                        var friends=peopleFormat(info['usrs'],null,info['id_type']),
	                                 	people=peopleFormat(info['friend'],null,info['id_type']);
	                                switch(info['type']){
										case 'tag':
											    var ac=' action="comment,'+info['idsource']+'"',
													tag=' <img'+ac+' src="'+FILESERVER+'img/tags/'+info['source'].substr(-16)+'.m.jpg" style="height:25px;"/>';
												d.photos=friends[0]+tag;
	                                            d.txt=txtFormat({
													type:info['id_type'],
													people:people[1],
	                                                friends:friends[1],
													num:info['num_friends'],
													txt:data['txt'],
													tag:'<span'+(ac?ac+' style="color: #77c574;"':'')+'>[_TAG_]</span>'
												});
												out+=newsFormat(d);										
										break;
										case 'usr':
											d.photos = friends[0];
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
	                                            friends:friends[1],
												txt:data['txt']
											});
											out+=newsFormat(d);
										break;
										case 'product':
											var ac=' action="detailProd,'+info['source']+'"',
												prod=info['photoS']?' <img'+ac+' src="'+info['photoS']+'" style="height:28px; border: 1px #c0c0c0 solid;border-radius: 5px;"/>':'';
											d.photos = people[0]+prod;
											d.txt=txtFormat({
												type:info['id_type'],
												people:people[1],
												num:info['num_friends'],
												txt:data['txt'],
												prod:'<span '+ac+' style="color: #77c574;">[_PROD_]</span>'
											});
											out+=newsFormat(d);
										break;

									}
								}
								if (SECTION!='news'){
									$('#adsListPubli').show();
									$('#news-loader').fadeOut('slow',function(){$(layer).after(out);});
									$('#info-container tr:gt(5)').remove();
									$('#NewsInfo').show();
									$('#waitNewsInfo').hide('fast');
								}else{
									if(action!='more') $('#pageNews #news-here').prepend(out);
									else $('#pageNews #news-here').append(out);
									$('#newsloader').hide();
									opc.limite=data['numResult'];
								}
							}else{
								if (SECTION!='news'){
									if(action=='reload')
									   $('#news-loader').fadeOut('slow',function(){$('#waitNewsInfo').fadeIn('fast');});
								}else{ $('#newsloader').hide(); }
							}
						}
					});
				} 
			}
			interval=setInterval(function(){
				if($(opc.layer).length>0){
					getNews('refresh',opc);
				}else clearEvents();
			}, 30000);
			if (SECTION=='news'){
				var posi=true;
				$(document).on('scroll',function(){
                    if ($(document).scrollTop() >= ($(document).height() - $(window).height())*0.4){
                        if(!posi){
                            posi=true;
                        	$('#newsloader').show();
                        	getNews('more',opc);
                        }
                    }else{ posi=false; }
	           });
			}
			// clearEvents();
		},close:function(){
			clearInterval(interval);
			clearInterval(this.intervalmsk);
		}
	});
});
</script>