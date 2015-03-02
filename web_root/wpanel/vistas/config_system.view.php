<?php
	if( $_REQUEST['action']=='update' )
	{
		if($_REQUEST['cost_personal_bc']>=1&&$_REQUEST['cost_company_bc']>=1){
			$update = mysql_query("	UPDATE config_system SET
										cost_account_individual_old					= cost_account_individual,
										cost_account_company_old					= cost_account_company ,
										cost_individual_personal_tag_old			= cost_individual_personal_tag,
										cost_company_personal_tag_old				= cost_company_personal_tag,
										cost_personal_bc_old						= cost_personal_bc,
										cost_company_bc_old							= cost_company_bc,
										creating_tag_points_old						= creating_tag_points,
										redistributing_tag_points_old				= redistributing_tag_points,
										sending_tag_points_old						= sending_tag_points,
										redistributing_sponsor_tag_points_old		= redistributing_sponsor_tag_points,
										time_in_minutes_shopping_cart_active		= time_in_minutes_shopping_cart_active,
										time_in_minutes_pending_order_payable		= time_in_minutes_pending_order_payable,
										cost_per_point								= cost_per_point
									WHERE id = '1' ") or die ("1) ".mysql_error() );

			$update = mysql_query("	UPDATE config_system SET
										days_block									= '".$_REQUEST['days_block']."',
										cost_account_individual						= '".$_REQUEST['cost_account_individual']."',
										cost_account_company						= '".$_REQUEST['cost_account_company']."',
										cost_individual_personal_tag				= '".$_REQUEST['cost_individual_personal_tag']."',
										cost_company_personal_tag					= '".$_REQUEST['cost_company_personal_tag']."',
										cost_personal_bc							= '".$_REQUEST['cost_personal_bc']."',
										cost_company_bc								= '".$_REQUEST['cost_company_bc']."',
										creating_tag_points							= '".$_REQUEST['creating_tag_points']."',
										redistributing_tag_points					= '".$_REQUEST['redistributing_tag_points']."',
										sending_tag_points							= '".$_REQUEST['sending_tag_points']."',
										redistributing_sponsor_tag_points			= '".$_REQUEST['redistributing_sponsor_tag_points']."',
										time_in_minutes_shopping_cart_active		= '".$_REQUEST['time_in_minutes_shopping_cart_active']."',
										time_in_minutes_pending_order_payable		= '".$_REQUEST['time_in_minutes_pending_order_payable']."',
										cost_per_point								= '".$_REQUEST['cost_per_point']."'
									WHERE id = '1' ") or die ("2) ".mysql_error());

			mensajes("Processed Sucessfully", "index.php?url=".$_REQUEST[url]);
		}else{
			mensajes("The minimum price for business card is 1 dollar", $_SERVER['HTTP_REFERER'], "error");
		}
	}

	//_imprimir($_REQUEST);
?>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td>
			<?php
			
				$frm = new formulario('System Config', '?url='.$_GET[url], 'Send', 'System Config', $metodo='post');
				$frm->consulta=true;
				$frm->inicio();
				$frm->inputs("	SELECT	c.days_block								AS days_block_1,
										c.cost_account_individual					AS cost_account_individual_1,
										c.cost_account_company						AS cost_account_company_1,
										c.cost_individual_personal_tag				AS cost_individual_personal_tag_1,
										c.cost_company_personal_tag					AS cost_company_personal_tag_1,
										c.cost_personal_bc							AS cost_personal_bc_1,
										c.cost_company_bc							AS cost_company_bc_1,
										c.creating_tag_points						AS creating_tag_points_1,
										c.redistributing_tag_points					AS redistributing_tag_points_1,
										c.sending_tag_points						AS sending_tag_points_1,
										c.redistributing_sponsor_tag_points			AS redistributing_sponsor_tag_points_1,
										c.time_in_minutes_shopping_cart_active		AS time_in_minutes_shopping_cart_active_1,
										c.time_in_minutes_pending_order_payable		AS time_in_minutes_pending_order_payable_1,
										c.cost_per_point							AS cost_per_point_1
								FROM config_system c
								WHERE c.id = '1';");

				$frm->hidden('action', 'update');
				$frm->hidden('url', $_GET[url]);
				$frm->fin(false);
			?>
		</td>
	</tr>
</table>
<script type="text/javascript">
	$('Send').addEvent('click', function(){
		
		var veriP= (document.getElementById('system-config_cost_personal_bc').value>=1)? 'yes':'no';
		
		var veriC= (document.getElementById('system-config_cost_company_bc').value>=1)? 'yes':'no';
//		
		if(veriP=='yes'&&veriC=='yes'){
			document.getElementById("system-config").submit();
		}else{
			Alert.error('The minimum price for business card is 1 dollar'); 
			return false;
		}
	});
</script>