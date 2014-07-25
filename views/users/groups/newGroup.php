<?php
	$edit=false;
	if(isset($_GET['grp'])){ $edit=true; }
?>
<div id="loading_groups"><span class="store-span-loader"><?=JS_LOADING?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>
<div class="ui-box" id="newEditGroup" style="display: none;">
	<form id="frmAddGroup" method="post" enctype="multipart/form-data" action="controls/groups/actionsGroups.json.php" style="margin:8px;">
		<ul class="newGroup" style="border-radius: 5px;">
			<li>
				<div id="errorFileInes" class="error_file_group"><?=GROUPS_ERRORUNEXPECTEDUPLOAD?></div>
				<h3><?=GROUPS_NEWGROUPNAME?></h3>
				<input name="name" placeholder="<?=$edit?'':GROUPS_NEWGROUPNAME?>" id="name" type="text" class="txt_box" style="width:20em" value="" requerido="<?=GROUPS_NEWGROUPNAME?>" />
				<h3>Logo</h3>
				<div id="logoUpload">
					<select id="logoSelect" name="logoSelect" class="txt_box" style="width: 265px;padding: 0px;">
					</select><br>
					<input type="file" id="photo_g" name="photo_g" value="" class="invisible" />
					<div id="errorFile" class="error_file_group"><?=GROUPS_ERRORUPLOADINGFILE?></div>
					<br>
					<?php if($edit){ ?>
					<div class="bkgGroup" ></div>
					<input name="bgkphoto" id="bgkphoto" type="hidden" value=""/>
					<?php } ?>
					<div class="clearfix"></div>
				<div class="clearfix"></div>
				</div>
				<div class="legend text" style="color: #999; width: 260px;">
					<?=GROUPS_MSGIMG?>
				</div>
				<h3><?=GROUPS_NEWORIENTED?></h3>
				<select name="type_content" id="type_content" style="width: 265px;"></select>
				<h3><?=GROUPS_NEWPRIVACY?></h3>
				<div id="radioPrivacy"></div>
			</li>
			<li>
				<h3><?=GRP_DESCRIPTION?></h3>
				<textarea class="txt_box" name="description" id="description" requerido="<?=GRP_DESCRIPTION?>" cols="21" rows="6" placeholder="<?=$edit? '':GROUPSDESCRIPTEXT?>" style="width: 205px;"></textarea>
				<h3><?=STORE_CATEGORIES?></h3>
				<select name="category_group" id="category_group" style="width: 265px;"></select>
                <?php if ($edit){ ?>
					<h3><?=GROUPS_NEWMEMBERS?></h3>
					<select name="members_update" id="members_update"></select>
					<h3><?=GROUPS_NEWADMINISTRATOR?></h3>
					<select name="admins" id="admins"></select>
				<?php } ?>
				<input name="action" id="action" type="hidden" value="<?=($edit?'2':'1')?>" />
				<input name="ng" id="ng" type="hidden" value="<?=$_GET['ng']?>" />
				<input name="grp" id="grp" type="hidden" value="" />
				<input name="code_g" id="code_g" type="hidden" value="" />
				<div name="idFirstInsert" id="idFirstInsert"></div>
				<div class="clearfix"></div>
			</li>
			<div class="clearfix"></div>
		</ul>
	</form>
</div>
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<script>
	$(document).ready(function(){
		/*Select Upload Logo*/
		var idP='<?=$_GET['grp']?$_GET['grp']:''?>';
		if (idP!=''){ infoGroups('2',idP); }
        else{ infoGroups('1'); }
		$('#logoSelect').empty().html(selectPhoto());
		$('#logoSelect').change(function(){
			if($(this).val()=='file'){
				if(idP!='') $('#logoSelect').empty().html(selectPhoto());
				$('#photo_g').click();
			}else{
				$('#photo_g').val(null);
				if($('input#bgkphoto')) $('input#bgkphoto').val('');
				$('#logoSelect').empty().html(selectPhoto());
			}
		});
		if(idP!=''){
			$('#photo_g').on('change',function(){
				$('input#action').val('0');
				$('#frmAddGroup').submit();
			});
		}
		/*END Select Upload Logo*/		
		function selectPhoto(){
			return('<option value="default"><?=GROUPS_DEFAULTIMG?></option><option value="file"><?=$edit?BC_CHANGELOGO:GROUPS_UPLOADFROMFILE?></option>');
		}
		function actionDialog(conten,action,id){
			$.dialog({
				title	: '<?=SIGNUP_CTRTITLEMSGNOEXITO?>',
				content	: '<div style="text-align:center;">'+conten+'</div>',
				height	: 200,
				width	: 300,
				close	: function(){
					$("#default-dialog").dialog('close');
					switch(action){
						case 1: redir('creation?group='+id); break;
						case 2: location.reload(); break;
					}
				}
			});
		}
        function infoGroups(action,group){
            var get=group?'gid='+group+'&':'';
            switch(action){
                case '1': get+='infoG=1';break;
                case '2': get+='infoG=1&menbers=1';break;
                case '3': get+='profile=1';break;
            }
        	$.ajax({
        		type	:"GET",
        		url		:"controls/groups/listGroups.json.php?"+get,
        		dataType:"json",
        		success	:function(data){
                    if (action!=3){
                        var selects='',group;
                        if(data['list']){
                            group=data['list'][0];
                            $('input#name').val(data['list'][0]['name']);
                			$('input#grp').val(data['list'][0]['id']);
                			$('input#code_g').val(data['list'][0]['code']);
                			$('#description').html(data['list'][0]['des']);
                			if (data['list'][0]['photo']!=''){
                				$('div.bkgGroup').css('background-image','url("'+data['list'][0]['photo2']+'")');
                				$('input#bgkphoto').val(data['list'][0]['photothis']);
                			}
                            $('#members_update').fcbkcomplete({
                				json_url: 'includes/friendsHelp.php?value=1',
                				newel:true,
                				filter_selected:true,
                				addontab : false,
                				filter_hide: true
                			});
                			$('#admins').fcbkcomplete({
                				json_url: 'includes/friendsHelp.php?value=1',
                				newel:true,
                				filter_selected:true,
                				addontab : false,
                				filter_hide: true
                			});
                			if (data['list'][0]['listAdmins']){
                				for (var i=0;i<data['list'][0]['listAdmins'].length;i++){
                					$("#admins").trigger("addItem",[{"title": data['list'][0]['listAdmins'][i]['label'], "value": data['list'][0]['listAdmins'][i]['id']}]);
                					$("#members_update").trigger("addItem",[{"title": data['list'][0]['listAdmins'][i]['label'], "value": data['list'][0]['listAdmins'][i]['id']}]);
                				}
                			}
                			if (data['list'][0]['listMembers']){
                				for (var i=0;i<data['list'][0]['listMembers'].length;i++){
                					$("#members_update").trigger("addItem",[{"title": data['list'][0]['listMembers'][i]['label'], "value": data['list'][0]['listMembers'][i]['id']}]);
                				}
                			}    
                        }
                        if (data['privacy']){
                            var i=0,radio='';
            				for(i=0;i<data['privacy'].length;i++){
            					radio+='<input type="radio" value="'+data['privacy'][i]['id']+'" id="privacy'+data['privacy'][i]['id']+'" '+(group && group['privacy']==data['privacy'][i]['id']?'checked="checked"':(!group && i==0?'checked="checked"':''))+' name="privacy" />'
            						+'<label class="privacy'+data['privacy'][i]['id']+'" for="privacy'+data['privacy'][i]['id']+'">'+data['privacy'][i]['name']+'</label><br>';
            				}
                            $('div#radioPrivacy').html(radio);
                        }
                        if (data['oriented']){
                            var i=0,select='';
                            for(i=0;i<data['oriented'].length;i++){
            					select+='<option value="'+data['oriented'][i]['id']+'" '+(group && group['oriented']==data['oriented'][i]['id']?'selected':'')+'>'+data['oriented'][i]['des']+'</option>';
            				}
                            $('select#type_content').html(select);
            				selects+=',#type_content';
                        }
                        if (data['category']){
                            var i=0,select='';
                            for(i=0;i<data['category'].length;i++){
            					select+='<option value="'+data['category'][i]['id']+'" '+(group && group['category']==data['category'][i]['id']?'selected':'')+'>'+data['category'][i]['name']+'</option>';
            				}
                            $('select#category_group').html(select);
            				selects+=',#category_group';
                        }
                        $('#logoSelect'+selects).chosen({
            				menuWidth:150,
            				width:150,
            				disableSearch:true
            			});
            			$('div#newEditGroup').css('display','block');
            			$('div#loading_groups').css('display','none');
            			$('#default-dialog').css('height', 'auto');
            		}else{
                		  if (data['list']){
            				if (data['list'][0]['isAdmin']){
                                $('#info-top-groups').html(det_info(data['list'][0]));
                                $('#info-top-groups a').unbind('click').click(function(){
                                    if ($(this).parents('article').hasClass('info')){ dialog_info(data['list'][0]); }
                                    else if ($(this).parents('article').hasClass('member')){ membersGroups('','<?=$_GET['grp']?>');  }
                                    return false;
                                });
            				}else{
            					if (data['list'][0]['noti']['body']){
            						$('.tags-list').hide().after('<div id="info">'+data['list'][0]['noti']['body']+'</div>');
            						$('.btn input#back').click(function(){ history.back(); });
            					}
            				}
            			}
            		}
                }
        	});
        }
		var options = {
            dataType: 'json',
			success: function(data){
				console.log(data);
				switch(data['action']){
					case '0':
						if (!data['error']){
							$('input#action').val('2');
							$('input#bgkphoto').val(data['photo']);
							$('div.bkgGroup').css('background-image','url("<?=FILESERVER?>img/groups/'+data['photo']+'")');
						}else{
							switch(data['error']){
								case 'pesoMax':     var content='<?=USERPROFILE_CTRERRORUSERBIGIMAGE?>'; break;
								case 'formatError': var content='<?=SPONSORTAG_SPANERROR2?>'; break;
								case 'noFile':      var content='<?=NEWTAG_CTRERRORFILEFORMAT?>'; break;
							}
							actionDialog(content);
						}
					break;
					case '1':
						if (data['insert']=='true'){
							if (!data['nopUpload']){
								var conten='<?=GROUPS_CTRNEWMSGEXITO.'<br>'.NEW_GROUP_CREATE_TAG?>';
								actionDialog(conten,1,data['id']);
							}else{
								var conten='<?=GROUPS_CTRNEWMSGEXITO?>, <?=NEWTAG_CTRERRORUPLOAD?>';
								actionDialog(conten,1,data['id']);
							}
						}else{
							var conten='<?=GROUPS_ERRORUNEXPECTEDUPLOAD?>';
							actionDialog(conten,2);
						}
					break;
					case '2':
						$("#default-dialog").dialog('close');
						$('#groupTitleStyle').html($('input#name').val());
						$('#groupTitleStyle').attr('title', $('input#name').val());
                        $('#info-top-groups .side-box header').next('div').empty().html('<img src="css/smt/loader.gif" width="32" height="32" class="loader" style="display: inline;">');
                        infoGroups('3',idP);
					break;
				}
			}
		};
		$('#frmAddGroup').ajaxForm(options);

	});
</script>
