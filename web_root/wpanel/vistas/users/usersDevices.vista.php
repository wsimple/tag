<?php 
	 //filtros
	 
	 $where = "";
	 
	 if ($_POST[fecha1]!="" && $_POST[fecha2]==""){
		 
		 $where = " WHERE DATE(date) = '".$_POST[fecha1]."'"; 
		 
	 }elseif($_POST[fecha1]=="" && $_POST[fecha2]!=""){
		 
		 $where = " WHERE DATE(date) = '".$_POST[fecha2]."'"; 
		 
	 }elseif($_POST[fecha1]!="" && $_POST[fecha2]!=""){
		 
		 $where = " WHERE DATE(date) BETWEEN '".$_POST[fecha1]."' AND '".$_POST[fecha2]."'"; 
		 
	 }
	 
	 $where                 = ($where!='') ? $where : ''; 
	 $_pagi_cuantos         = 8;
	 $_pagi_nav_num_enlaces = 3;
	 $_pagi_sql             = "SELECT (select concat(a.name, ' ', a.last_name) from users a where a.id=z.id_user) AS user,
									   z.id_user AS id_user,
									   z.agent AS agent,
									   z.remote_addr AS remote_addr,
									   z.remote_host AS remote_host,
									   z.remote_port AS remote_port,
									   z.language AS language,
									   z.is_mobile AS is_mobile,
									   z.date AS date
								
							   FROM users_device_login  z 
								
							   $where
								
							  ";
	
	 include('includes/paginator.inc.php');		  
?>

<form id="payments" name="payments" method="post" action="" class="formulario">

<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
        <td>
        <fieldset>
       	<legend>Filters</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                <td class="etiquetas" style="text-align:left">Date Range:</td>
                </tr>
                <tr>
                <td>
                  <input name="fecha1" type="text" id="fecha1" size="15" readonly="readonly" value="<?=(($_POST[fecha1]!="")?$_POST[fecha1]:date("Y-m-d"))?>"><img src="img/calendar.png" onClick="displayCalendar(document.payments.fecha1,'yyyy-m-d',this);" style="cursor:pointer" title="View calendar" width="16" height="16" border="0" />&nbsp;
                  <input name="fecha2" type="text" id="fecha2" size="15" readonly="readonly" value="<?=(($_POST[fecha2]!="")?$_POST[fecha2]:date("Y-m-d"))?>"><img src="img/calendar.png" onClick="displayCalendar(document.payments.fecha2,'yyyy-m-d',this);" style="cursor:pointer" title="View calendar" width="16" height="16" border="0" />
                  &nbsp;&nbsp;&nbsp;
                  <input type='button' class='boton' name='erase' id='erase' value='Clear' onclick="document.payments.fecha1.value='';document.payments.fecha2.value='';" />
                </td>
                </tr>
                
                <tr><td>&nbsp;</td></tr>
                
                <tr style="background-color:#F4F4F4">
                <td style="text-align:center">
                <input type='button' class='boton' name='atras' id='atras' value='Search' onclick='this.form.submit();' />  
                <input type='button' class='boton' name='atras' id='atras' value='Refresh' onclick="redirect('?url=<?=$_GET[url]?>');" />  
                </td>
                </tr>
                </table>
        </fieldset>
        </td>
    </tr>


    <tr>
        <td>
        <fieldset>
       	<legend>Users Devices</legend>
                <table width="680" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:11px; margin-top:10px; margin-bottom:10px; font-weight:normal; text-align:left; border:1px solid #FBCBA4; border-bottom:none">
                <tr style="background-color:#FDE2CC; color:#000000; font-weight:bold">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="55">User</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="173">Agent</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="67">Remote IP</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="124">Remote Host</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center" width="91">Remote Port</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4" width="54">Language</td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4;" width="55">Mobile</td>
                    <td style="border-bottom:1px solid #FBCBA4;" width="55">Date</td>
                </tr>  
                <?php 
					  while ($device = mysql_fetch_assoc($_pagi_result)){ 

			    ?>              
                <tr valign="top" style="font-size:10px">
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[user].'<br>(id:'.$device[id_user].')'?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; padding:2px">
                    	<?=$device[agent]?>
                    </td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[remote_addr]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[remote_host]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[remote_port]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[language]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; border-right:1px solid #FBCBA4; text-align:center; padding:2px"><?=$device[is_mobile]?></td>
                    <td style="border-bottom:1px solid #FBCBA4; text-align:center; padding:2px">
						<?php 
						      $fecha = explode(' ', $device['date']);
							  echo $fecha[0].'<br>'.$fecha[1];
					    ?>
                    </td>
                </tr>
                <?php } ?>  
                <tr>
                    <td colspan="8" style="text-align:left"><?php echo $_pagi_navegacion,$_pagi_info; ?></td>
                </tr>
                </table>
        </fieldset>
        </td>
    </tr>
    
</table>

</form>


