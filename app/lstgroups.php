<?php include 'inc/header.php'; ?>
<div id="page-lstGroups" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="profile" style="position:absolute;top:0px;left:0;padding:5px;">
			<span class="photo"></span> 
			<span class="info">
				<span class="name"></span>
				<span class="points"></span>
			</span>
		</div>
		<div id="sub-menu"><ul class="ui-grid-d"></ul></div>
	</div><!-- header -->

	<div data-role="content" class="list-content">
        <div id="pd-wrapper">
			<div id="scroller">
				<div id="pullDown"><!-- <div><span class="pullDownIcon"></span><span class="pullDownLabel"></span></div> --></div>
		        <div><ul data-role="listview" id="group_title" data-divider-theme="b" class="list-info"></ul></div>
                <div id="pullUp"><div><span class="pullUpIcon"></span><span class="pullUpLabel">Pull up to refresh...</span></div></div>
			</div>
		</div>
	</div><!-- content -->

	<script type="text/javascript">
		pageShow({
			id:'#page-lstGroups',
			// title:lang.MAINMNU_GROUPS,
			// showmenuButton:true,
			before:function(){
				newMenu();
				//languaje
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
				var el=$('#group_title'),$wrapper=$('#pd-wrapper',this.id);
				//getting group title
				//var action	= $_GET['action']||2;
                if ($_GET['action'] && $_GET['action']==2){
                    var action	= 'all';
                    $('#titleGroups').html(lang.GROUPS_ALLGROUPS);
                }else{
                    var action	= 'my';
                    $('#titleGroups').html(lang.GROUPS_MYGROUPS);
                }
				$('#group_title').on('click','li',function(){ menuGroupsClose($(this).attr('group')); });
                $wrapper.ptrScroll({
					// onPullDown:function(){},
					onPullUp:function(){
					   var cant=$('li',el);
                       if (cant.length>0 && cant.length%2==0) cargarList(action,cant.length);
                       else $wrapper.jScroll('refresh');
					},
					onReload:function(){ cargarList(action,''); }
				});
                function cargarList(action,limit){
                    var limit2='&'+(limit!=''?'limit='+limit:'limit=0');
                    myAjax({
    					type	: 'POST',
    					//url		: DOMINIO+'controls/groups/menuGroupUser.json.php?action='+action+'&code='+$.local('code'),
    					url		: DOMINIO+'controls/groups/listGroups.json.php?list='+action+limit2,
                        dataType: 'json',
    					error	: function(/*resp, status, error*/) {
    						myDialog('#singleDialog', lang.conectionFail);
    					},
    					success	: function(data) {
    						var i,out='',pref='';
                            console.log(data);
                            console.log('lenguaje '+lang.actual);

                            for(i in data['list']){
								pref = data['list'][i];
								pref['cname'] = (pref['cname']) ? pref['cname'] : 'General';
								
								switch (pref['idPri']) {
			        				case 1:
			        					pref['privacidad'] = lang.GROUPS_OPEN;
			        				break;
			        				case 2:
			        					pref['privacidad'] = lang.GROUPS_CLOSED;
			        				break;
			        				case 3:
			        					pref['privacidad'] = lang.GROUPS_PRIVATE;
			        				break;
								};
								console.log(pref['privacidad']);
								out +=
									'<li group="'+pref['id']+'">'+
										'<img '+pref['photoi']+' class="ui-li-icon-group" width="30" height="30" />'+
										'<a class="linkGroup">'+pref['name']+'<br>'+
											'<div style="float: left; margin-left: 0px; font-size: 10px; text-align: left;font-weight: normal"><img src="'+pref['cphoto']+'" class="ui-li-icon-group" width="20" height="20" style="float: none; margin: 0px 5px;"/><br>'+pref['privacidad']+', '+lang.GROUPS_MEMBERS+' ('+pref['num_members']+'), '+lang.GROUPS_CREATED+' '+pref['fecha']+
                                            ' '+lan('Category')+':'+pref['cname']+
                                            '</div>'+
										'</a>'+
									'</li>';
    						}    						
                            if (limit!='') $('#group_title').append(out).listview('refresh');
                            else $('#group_title').html(out).listview('refresh');
    						$wrapper.jScroll('refresh');
    					}
    				});   
                }
			}
		});
	</script>
</div><!-- page -->
<?php include 'inc/footer.php'; ?>