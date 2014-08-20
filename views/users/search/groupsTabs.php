<div id="groupTabs">
<?php
if ($groups_count == 0) {
	mysqli_data_seek($groups, 0);
	echo $groups;
	$groupsTabs = $groups;
	echo '<div class="messageNoResultSearch">'.SEARCHALL_NORESULT.' <span style="font-weight:bold">'.$srh.',</span> <span style="font-size:12px">'.SEARCHALL_NORESULT_COMPLE.'</span></div><div class="ui-single-box-title">'.EDITFRIEND_VIEWTITLESUGGES.'</div>';
}else{
	$groupsTabs = groups($whereGroups,5);
}
?>
<?php
	while ($group = mysql_fetch_assoc($groupsTabs)){
		$num_members = $group['num_members'];
		//privacidad del grupo
        $photo=FILESERVER.'img/groups/'.$group['photo'];
        $photo=fileExistsRemote($photo)?$photo:'';
        $group['photo']= $photo!=''? 'style="background-image:url(\''.$photo.'\');"':'';
        $group['cname']=formatoCadena(constant($group['cname']));
        $group['photoi']= $photo!=''? 'src="'.$photo.'" ':'src="'.DOMINIO.'css/smt/groups_default.png"';
        $group['ctitle']=$group['cname'].': '.constant($group['csummary']);
        $group['cphoto']=$group['cphoto']!=''?DOMINIO.'img/groups/category/'.$group['cphoto']:DOMINIO.'css/smt/menu_left/groups.png';
		switch ($group['privacy']) {
			case 1:
				$classImgPrivacy = 'groupPublic';
				$privacyGrp = GROUPS_LABELOPEN;
			break;
			case 2:
				$classImgPrivacy = 'groupPrivate';
				$privacyGrp = GROUPS_LABELCLOSED;
			break;
			case 3:
				$classImgPrivacy = 'groupSecret';
				$privacyGrp = GROUPS_LABELPRIVATE;
			break;
		}
	//	$foto = getPicture(RELPATH."img/groups/".$group['photo'], '');
//			$classBackgroungGroup = ($foto!='')?"style='background-image:url("."img/groups/".$group['photo'].")'":""; 

		$idGroup = md5($group['id']);
		if($cad>300){$cad_c = substr($group['des'], 0,300)."..."; }
        else{ $cad_c = $group['des']; }
		//verificar si el usuario pertenece al grupo en lista
		$isInGroup = $GLOBALS['cn']->query("SELECT status FROM users_groups WHERE md5(id_group) = '".$idGroup."' and id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'");
		$status=mysql_fetch_assoc($isInGroup);
		switch ($status['status']){
			case '1': $userInGroup=0; $buttonGroup=1; break;
			case '2': $userInGroup=0; $buttonGroup=2; break;
			case '5': $userInGroup=1; break;
			default : $userInGroup=0; $buttonGroup=0;
		}
		if (groupsOriented($group['oriented'])){
			if ($group['privacy']==3){
				$validate = $GLOBALS['cn']->query("
					SELECT id_user
					FROM users_groups
					WHERE id_group = '".$group['id']."' AND id_user = '".$_SESSION['ws-tags']['ws-user']['id']."'");
				if (mysql_num_rows($validate)>0 || $group['creator'] == $_SESSION['ws-tags']['ws-user']['id']){ ?>
				<div class="group_info">
					<div class="bckOvergroup"  title="<?=$privacyGrp?>">
						<div class="bkgGroup" <?=$group['photo']?>></div>
						<div class="DescripGroupType">
							<div class="TitleTypeGruop">
								<div style="float: left">
									<img src="<?=$group['cphoto']?>" alt="Group Icons" title="<?=$group['ctitle']?>" width="20" height="20">
									<?=$group['name']?>
								</div>
								<div class="<?=$classImgPrivacy?>"></div>
							</div>
							<div class="complementGruop">
								<?=$cad_c?>
							</div>
						</div>
						<div class="GroupMembers">
							<div class="iconMember"><span><?=$num_members?></span></div>
							<div class="cantMember"><?=GROUPS_MEMBERSTITLE?></div>
						</div>
					</div>
					<div>
						<input type="button" value="Suggest a Group" name="suggestGroup<?=$idGroup?>" id="suggestGroup<?=$idGroup?>">
						<input type="button" class="viewGroup" action="groupsDetails,<?=$idGroup?>" value="<?=GROUPS_VIEWTHEGROUP?>">
					</div>
				</div>
				<div class="clearfix"></div>
		<?php	}//if mysql_num_rows
			}else{ ?>
				<div class="group_info">
					<div class="bckOvergroup" title="<?=$privacyGrp?>">
						<div class="bkgGroup" <?=$group['photo']?>></div>
						<div class="DescripGroupType">
							<div class="TitleTypeGruop">
								<div style="float: left">
									<img src="<?=$group['cphoto']?>" alt="Group Icons" title="<?=$group['ctitle']?>" width="20" height="20"/>
									<?=$group['name']?>
								</div>
								<div class="<?=$classImgPrivacy?>"></div>
							</div>
							<div class="complementGruop">
								<?=$cad_c?>
							</div>
						</div>
						<div class="GroupMembers">
							<div class="iconMember"><span><?=$num_members?></span></div>
							<div class="cantMember"><?=GROUPS_MEMBERSTITLE?></div>
						</div>
					</div>
					<?php if($userInGroup==0){?>
					<div id="btnJoinViewroup<?=$idGroup?>">
						<?php if($buttonGroup==0){ $onclickJoinGroup = 'action="groupsAction,'.$idGroup.'"'; ?>
							<input type="button" value="<?=GROUPS_JOINTOTHEGROUP?>" name="joinGroup<?=$idGroup?>" id="joinGroup<?=$idGroup?>" <?=$onclickJoinGroup?>>
							<div id="autoriGr<?=$idGroup?>" class="messageSuccessGroupo" style="display: none"><?=JS_GROUPS_WAITAPPROBATION?></div>
						<?php }elseif($buttonGroup==1){ ?>
							<input type="button" action="groupSuggest,<?=$idGroup?>" class="viewGroup suggestGroup" value="<?=GROUPS_SUGGESTGROUP?>">
							<input type="button" action="groupsDetails,<?=$idGroup?>" class="viewGroup" value="<?=GROUPS_VIEWTHEGROUP?>">
						<?php }elseif($buttonGroup==2){ ?>
							<input type="button" size="20" id="acep<?=$idGroup?>"
									value="<?=utf8_encode(GROUPS_ACCEPTUSERS)?>"
									action="acceptInv,<?=$idGroup?>,list">
							<input type="button" size="20" id="acepNo<?=$idGroup?>"
									value="<?=utf8_encode(GROUPS_REJECTTUSERS)?>"
									action="acceptInv,<?=$idGroup?>,list,none">
							<span class="msg" id="msg<?=$idGroup?>"><?=INVITE_GROUP_TRUE?></span>
							<input type="button" value="<?=GROUPS_JOINTOTHEGROUP?>" name="joinGroup<?=$idGroup?>" id="joinGroup<?=$idGroup?>" action="groupsAction,<?=$idGroup?>" style="display: none">
							<div id="autoriGr<?=$idGroup?>" class="messageSuccessGroupo" style="display: none"><?=JS_GROUPS_WAITAPPROBATION?></div>
						<?php } ?>
					</div>
					<?php }else{ ?>
						<div class="messageSuccessGroupo"><?=JS_GROUPS_WAITAPPROBATION?></div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			<?php
			}
		}
	}
?>
</div>

<?php if($groups_count==5){ ?>
<div id="smTabsGroups" class="seemoreSearch"><?=USER_BTNSEEMORE?></div>
<div class="clearfix"></div>
<div id="loading_groups_search"></div>
<?php } ?>