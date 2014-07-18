<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Tagbum.com :: Control Panel</title>
        <script type="text/javascript" src="js/funciones.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>
        <script type="text/javascript" src="js/msgbox/mootools_.js"></script>
        <script type="text/javascript" src="js/msgbox/alert_box.js"></script>
        <script type="text/javascript" src="js/request.js"></script> 
        <script type="text/javascript" src="js/sortableTable.js"></script>
        <script type="text/javascript" src="js/calendar.js"></script>
        <link rel="shortcut icon" href="img/favicon.ico"/>
        <script type="text/javascript">
            window.addEvent('domready', function() {
                Alert = new AlertBox(); 
            });
        </script>	
        
        <style type="text/css">
            @import url("css/estilo.css");
            @import url("css/alert_box.css");
            @import url("css/sortableTable.css");
            @import url("css/paginator.css");
            @import url("css/calendar.css");
        </style>	
    </head>
<body>
	<?php
		include ('../includes/config.php');
		include ('../class/wconecta.class.php');
		include ('../includes/conexion.php');
		include ('includes/funciones.php');
		include ('class/class.formularios.php');
		include ('fckeditor/fckeditor.php');
		
		if (($_SESSION['wpanel_user']['tipo']=='1')&&isset($_GET['successlang']))
		{
			mensajes("Languaje Successfully Processed", ".", "info");
		}

		if ($_SESSION['wpanel_user']['nombre']!='')
		{?>	<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						
                        <div style="float:left; width:206px">
                        <img src="img/logo.png" border="0"  />  
                        </div>
                        
                        <div style="float:right; width:500px; height:80px; font-size:36px; font-weight:bold; letter-spacing:1px; text-align:right; padding-top:10px">
                        <?php 
								if ($_SESSION['wpanel_user']['tipo']=='0' && $_SESSION['wpanel_user']['code']==''){
								    include ("vistas/contador.vista.php"); 
								}else{
							    	echo "&nbsp;";
								}
						?>
                        </div>
                        
                          
					</td>
				</tr>
                
				<tr>
					<td width="108" valign="top"><?php include ('includes/menu.php');?></td>
					<td width="692" height="400" valign="top" bgcolor="#FFFFFF">
<?php					
					   
					   if ($_SERVER['SERVER_NAME']=="www.tagbum.com" || $_SERVER['SERVER_NAME']=="tagbum.com" || $_SERVER['SERVER_NAME']=="64.15.140.154"){

                           if ($_SESSION['wpanel_user']['tipo']=='0' && $_SESSION['wpanel_user']['code']==''){
						   
						       $file = ($_GET['url']) ? $_GET['url'] : "vistas/users/usersRegistered.vista.php";
							   
							   include($file);
							  
						   }elseif ($_SESSION['wpanel_user']['tipo']=='1' && $_SESSION['wpanel_user']['code']=='0987654321098'){
						   
						       if (in_array($_GET['url'], $_SESSION['wpanel_user']['uris'])){ 
							   
								  include($_GET['url']);
							   
							   }else{
							      
								  include('vistas/languages/master.php');
							   
							   }
						   
						   }
                        
					   }else{//else server
					   
					        if ($_GET['url'])
							    include ($_GET['url']);
						    else
							    include ('vistas/users/usersRegistered.vista.php'); 
					   
					   }
					  
					  ?>
					</td>
				</tr>
				
                <tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				
                <tr>
					<td colspan="2" style="padding:3px; text-align:center; background-color:#FFFFFF; color:#999999">
                    	<strong>Tagbum.com &copy;</strong> - All Rights Reserved, Tagamation, LLc :: <?=date('Y')?>
					</td>
				</tr>
			</table>
			<br/>
<?php	} else
		{	echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=vistas/login.vista.php\">";
		} ?>
	</body>
</html>