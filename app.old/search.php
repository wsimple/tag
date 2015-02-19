<?php include 'inc/header.php'; ?>
<div id="page-search" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" >
        <div id="fs-wrapper" class="fs-wrapper">
    		<div id="scroller">
        		<!--ul id="resultList" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends"></ul-->
                <div id="resultList" data-role="collapsible-set" data-inset="false"></div>
            </div>
        </div>
	</div>
	
	<script>
		pageShow({
			id:'#page-search',
			title:lang.searchtitle,
			buttons:{showmenu:true,home:true},
			before:function(){
				$('#seek').html(lang.seek);
				//$('#searchFooter').html('<li><a href="#" opc="store">'+lan('All')+'</a></li>');
			},
			after:function(){
				var el='#resultList',srh=$_GET['srh'],tipo=$_GET['tipo']?$_GET['tipo']:'';
//				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.fs-wrapper').jScroll({hScroll:false});
                $('#resultList').on('click','#resultSG li[group]',function(){
    				menuGroupsClose($(this).attr('group'));
    			}).on('click','#resultSP [code]',function(){
					redir(PAGE['profile']+'?id='+$(this).attr('code'));
				}).on('click','#resultSS li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				}).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				}).on('click','li.morebtn',function(){
					opc.limit='more';
                    opc.tipo=$(this).attr('opc');
                    $(this).slideUp();
                    getSearch(opc);
				}).on('click','li[hash]',function(){
				    redir(PAGE['tagslist']+'?current=hash&hash='+$(this).attr('hash').replace('#','%23').replace('<br>',' '));
				});	
                linkUser('#resultList');
                $('#resultList').on('collapse','div[data-role="collapsible"]',function(){
					$('.fs-wrapper').jScroll('refresh');
				});
                opc={
					layer:el,
                    srh:srh,
					limit:'basic',
                    tipo:tipo,
                    f_limitIni:0,
                    g_limitIni:0,
                    s_limitIni:0,
                    h_limitIni:0
				};
                function armarSeemore(limit,data,num,maxNum){
                    if (limit!='perso'){
                        if (num == maxNum) return '<li opc="'+data+'" class="morebtn">'+lan('see more','ucf')+'</li>';
                        else return '';
                    }else return '';
                }
                function getSearch(opc){
                    myAjax({
                		type	:'POST',
                		url		:DOMINIO+'controls/search/search.json.php?mobile&search='+opc.srh+(opc.limit!=''?'&limit='+opc.limit:'')+'&type='+opc.tipo,
                        data    :opc,
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},
                		success	:function(data){
                		      var i,out='',outP='',outG='',outH='',outS='',more='';
                                if (data['friends']!=''){
                                        out=  '<div data-role="collapsible" class="despliegue">'
                                                +'<h3>'+lan('peoples','ucw')+'</h3>'
                                                +'<ul id="resultSP" data-role="listview" data-filter="true" data-divider-theme="e" class="list-friends">';
                            			for(i=0;i<data['friends'].length;i++){
                            				friend=data['friends'][i];
                            				outP+=bodyFriendsList(friend);
                                            more+=armarSeemore(data['limit'],'friends',(i+1),data['f_maxR']);
                                            if (more!=''){ outP+=more; break;}
                            			}
                                        out+='   </ul>'
                                            +'</div>';
                                    opc.f_limitIni=opc.f_limitIni+((data['num_friends']==(data['f_maxR']+1))?data['num_friends']-1:data['num_friends']);
                    		      }
                    		      if (data['groups']!=''){ more='';
                    		          out+=  '<div data-role="collapsible" class="despliegue">'
                                                +'<h3>'+lan('group','ucw')+'</h3>'
                                                +'<ul id="resultSG" data-role="listview"  data-filter="true" data-divider-theme="e">';
                                      for(i=0;i<data['groups'].length;i++){
            								pref = data['groups'][i];

                                            switch (pref['idPri']) {
                                                case 1: pref['privacidad'] = lang.GROUPS_OPEN; break;
                                                case 2: pref['privacidad'] = lang.GROUPS_CLOSED; break;
                                                case 3: pref['privacidad'] = lang.GROUPS_PRIVATE; break;
                                            }
            								outG +=
            									'<li group="'+pref['id']+'">'+
            										'<img src="'+pref['icon']+'" class="ui-li-icon-group" width="19" height="19" />'+
            										'<a class="linkGroup">'+pref['name']+'<br>'+
            											'<div style="float: left; margin-left: 0px; font-size: 10px; text-align: left;font-weight: normal">'+pref['privacidad']+', '+lang.GROUPS_MEMBERS+' ('+pref['num_members']+'), '+lang.GROUPS_CREATED+' '+pref['fecha']+'</div>'+
            										'</a>'+
            									'</li>';
                                                more+=armarSeemore(data['limit'],'groups',(i+1),data['g_maxR']);
                                                if (more!=''){ outG+=more; break;}
            							}
                                        out+='   </ul>'
                                            +'</div>';
                                    opc.g_limitIni=opc.g_limitIni+((data['num_groups']==(data['g_maxR']+1))?data['num_groups']-1:data['num_groups']);
                    		      }
                                  if (data['hash']){
                                    out+=  '<div data-role="collapsible">'
                                                +'<h3>'+lan('hashTags','ucw')+'</h3>'
                                                +'<ul id="resultSH" data-role="listview"  data-filter="true" data-divider-theme="e">';
                                      for(i in data['hash']) if(i){
            								pref = data['hash'][i];  
            								outH +=
            									'<li hash="'+pref+'">'+
            										pref+
            									'</li>';
            							}
                                        out+='   </ul>'
                                            +'</div>';
                                    opc.h_limitIni=opc.h_limitIni+((data['num_hash']==(data['h_maxR']+1))?data['num_hash']-1:data['num_hash']);
                    		      }
                                  if (data['store']!=''){ more='';
                                        var prod= data['store'];
                                        out+=  '<div data-role="collapsible">'
                                                +'<h3>'+lan('store','ucw')+'</h3>'
                                                +'<ul id="resultSS" data-role="listview"  data-filter="true" data-divider-theme="e">';
                            			for(var i=0;i<prod.length;i++){
                            				outS+=
                            					'<li date="'+prod[i]['join_date']+'" idPro="'+prod[i]['id']+'">'+
                            						'<a><img src="'+prod[i]['photo']+'" style="width:100px;height:60px;margin:20px 0 0 8px;border-radius:10px">'+
                            							'<p class="nameProduct">'+prod[i]['name']+'</p>'+
                            							'<p class="descripProduct">'+prod[i]['description']+'</p>'+
                            							'<p class="date"><strong>Published:</strong> '+prod[i]['join_date']+'</p>'+
                            						'</a>'+
                            					'</li>';
                                                more+=armarSeemore(data['limit'],'store',(i+1),data['s_maxR']);
                                               if (more!=''){ outS+=more; break;}
                            			}
                                        out+='   </ul>'
                                            +'</div>';
                                        opc.s_limitIni=opc.s_limitIni+((data['num_store']==(data['s_maxR']+1))?data['num_store']-1:data['num_store']);
                    		      }
                                  if (out!=''){
                                    if (opc.limit=='basic'){
                                        $('#resultList').html(out).collapsibleset();
                                       if (outP!=''){ $('#resultList #resultSP').html(outP).listview(); }
                                       if (outG!=''){ $('#resultList #resultSG').html(outG).listview(); }
                                       if (outH!=''){ $('#resultList #resultSH').html(outH).listview(); }
                                       if (outS!=''){ $('#resultList #resultSS').html(outS).listview(); } 
                                    }else if(opc.limit=='more'){
                                       if (outP!=''){ $('#resultList #resultSP').append(outP).listview('refresh'); }
                                       if (outG!=''){ $('#resultList #resultSG').append(outG).listview('refresh'); }
                                       if (outH!=''){ $('#resultList #resultSH').append(outH).listview('refresh'); }
                                       if (outS!=''){ $('#resultList #resultSS').append(outS).listview('refresh'); }
                                       $('.fs-wrapper').jScroll('refresh');
                                    }
                                  }else{
                                        myDialog('#singleDialog',lang.noresultsearch_ini+' "'+opc.srh+'" '+lang.noresultsearch_end);
                                  }
                                   
                    		}
                	});   
                }
                if (srh!=''){ getSearch(opc);
                }else{ myDialog('#singleDialog',lang.noresultsearch_end); }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>