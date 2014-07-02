<?php 
	if ($_REQUEST['action']!=''){
		switch ($_REQUEST['action']){
			case 'insert': 
                                 if($_REQUEST['price']>=1){
                                    mysql_query("
                                            INSERT INTO subscription_plans SET 
                                                    name = '".$_REQUEST['name']."',
                                                    price = '".$_REQUEST['price']."', 
                                                    description = '".$_REQUEST['description']."',
                                                    days = '".$_REQUEST['days']."',
                                                    status = '1'
                                    ") or die (mysql_error());
                                    $id_plan = mysql_insert_id();
                                    //detail
                                    mysql_query("
                                            INSERT INTO subscription_plans_detail SET 
                                                    id_plan = '".$id_plan."',
                                                    ads = '".$_REQUEST['available_ads']."',
                                                    banners = '".$_REQUEST['available_banners']."', 
                                                    features = '".$_REQUEST['features']."'
                                    ") or die (mysql_error());
                                    mensajes("Sucessfully Process", "?url=".$_REQUEST['url'], "info");
                                }else{
                                    mensajes("The minimum price is 1 dollar", $_SERVER['HTTP_REFERER'], "error");
                                }
			break;
			case 'update': 
                                $varM = (($_REQUEST['price']>=1)? 'yes':($_REQUEST['id_consulta']==0)?'yes':'no');
                                
                                if($varM=='yes'){
                                    mysql_query("
                                            UPDATE subscription_plans SET 
                                                    name = '".$_REQUEST['name']."',
                                                    price = '".$_REQUEST['price']."',
                                                    description = '".$_REQUEST['description']."',
                                                    days = '".$_REQUEST['days']."',
                                                    status = '".$_REQUEST['status']."'
                                            WHERE id = '".$_REQUEST['id_consulta']."'
                                    ") or die (mysql_error());
                                    $id_plan = $_REQUEST['id_consulta'];
                                    //detail
                                    mysql_query("
                                            UPDATE subscription_plans_detail SET 
                                                    ads = '".$_REQUEST['available_ads']."',
                                                    banners = '".$_REQUEST['available_banners']."', 
                                                    features = '".$_REQUEST['features']."'
                                            WHERE id_plan = '".$id_plan."'
                                    ") or die (mysql_error());
                                     mensajes("Sucessfully Process", "?url=".$_REQUEST['url'], "info");
                                }else{
                                     mensajes("The minimum price is 1 dollar", $_SERVER['HTTP_REFERER'], "error");
                                }
			break;
		}
	}
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
			<?php
				$frm = new formulario('Costs Business Accounts', '?url='.$_GET[url], 'Send', 'Costs Business Accounts', $metodo='post');

				$frm->inicio();

				if ($_REQUEST['id_consulta']!=''){
					$frm->consulta=true;
					$where = " WHERE id = '".$_REQUEST['id_consulta']."'";
					$whereDetail = " WHERE id_plan = '".$_REQUEST['id_consulta']."'";
					$frm->hidden("id_consulta", $_REQUEST['id_consulta']);				
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
						| AND 
						id = '".campo("subscription_plans", "id", $_REQUEST['id_consulta'], 5)."'
					";
					//data
					$query = mysql_query("
						SELECT * 
						FROM subscription_plans
						WHERE id = '".$_REQUEST['id_consulta']."'
					") or die (mysql_error());
					$array = mysql_fetch_assoc($query);	
				}else{
					$status = "
						SELECT 
							id AS valor,
							name AS descripcion
						FROM status
						WHERE id IN ('1','2')
					";
				}				  

				$frm->inputs("
					SELECT 
						a.name AS name_1,
				        a.price AS price_1,
				        a.description AS description_1
				    FROM subscription_plans a
					$where
			    ");
				
				$frm->insertHtml('Type', '
					<select name="days" id="days" class="" requerido="Type">
					<option value="" selected ></option>
					<option value="30"  '.($array['days']=='30'?'selected':'').' >Monthly</option>
					<option value="60"  '.($array['days']=='60'?'selected':'').' >Bimonthly</option>
					<option value="90"  '.($array['days']=='90'?'selected':'').' >Quarterly</option>
					<option value="180" '.($array['days']=='180'?'selected':'').' >Semiannual</option>
					<option value="365" '.($array['days']=='365'?'selected':'').' >Annual</option>
					</select>
				');
				
				$frm->selects(array("status"=>$status));
				$frm->insertColspan();
				
				$frm->insertTitle('Plan detail');
				$frm->inputs("
					SELECT 
						a.ads AS available_ads_1,
				        a.banners AS available_banners_1,
				        a.features AS features_1
				    FROM subscription_plans_detail a
					$whereDetail
			    ");
				$frm->insertHtml('','put the features separated by commas (,)');
				
				$frm->insertColspan();
				$frm->hidden('action',(($_REQUEST['id_consulta']!='')?'update':'insert'));
				$frm->hidden('url',$_GET[url]);
				$frm->fin(false);  	
            ?>
        </td>
    </tr>
    <tr>
        <td>
			<?php
				$frm->grilla("
					SELECT
						id,
						name,
						price,
						days,
						description,
						(SELECT name FROM status WHERE id = subscription_plans.status) AS status
					FROM subscription_plans 
					ORDER BY days DESC, name ASC
				",1);
            ?>
        </td>
    </tr>
</table>
<script type="text/javascript">
	$('Send').addEvent('click', function(){
		
		var veri= (document.getElementById('costs-business-accounts_price').value>=1)? 'yes':(document.getElementById('id_consulta').value==0)?'yes':'no';
		
		if(veri=='yes'){
			document.getElementById("costs-business-accounts").submit();
		}else{
			Alert.error('The minimum price is 1 dollar'); 
			return false;
		}
	});
</script>