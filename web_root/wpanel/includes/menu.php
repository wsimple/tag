<table border="0" cellspacing="0" cellpadding="0" style="width:150px;">
	<tr>
        <td class="td_menu"><strong style="font-size:12px">Home Page</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" id="td-H1" onClick="inicio('../#creation&wpanel')">&raquo;&nbsp;Add Tags</td>
    </tr>
    <tr>
        <td class="td_submenu" id="td-H2" onClick="inicio('?url=vistas/viewTagWpanel.php')">&raquo;&nbsp;View Tags</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Users</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/users/usersRegistered.vista.php')">&nbsp;&raquo;&nbsp;Registered</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/users/usersDevices.vista.php')">&nbsp;&raquo;&nbsp;Devices</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/users/costs.vista.php')">&nbsp;&raquo;&nbsp;Subscription Plans</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/users/manage.nonprofit.php')">&nbsp;&raquo;&nbsp;Nonprofit Account</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Payments</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/payments/paypal.php')">&nbsp;&raquo;&nbsp;PayPal</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Languages</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/languages/master.php')">&nbsp;&raquo;&nbsp;Master</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/languages/sections.php')">&nbsp;&raquo;&nbsp;Sections Page</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/languages/template.php')">&nbsp;&raquo;&nbsp;Template</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/languages/translations.php')">&nbsp;&raquo;&nbsp;Translations</td>
    </tr>
    <?php if ($_SESSION['wpanel_user']['tipo']=='1'){?>
    <tr>
        <td class="td_submenu" onClick="inicio('../new.php?generate&language&wpanel')">&nbsp;&raquo;&nbsp;Generate</td>
    </tr>
    <?php } ?>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <!-- MENU EN ZEN CODING --> 
    <!-- tr>td.td_menu>strong[style=font-size:12px]{TITULO MENU}
    tr*9>td.td_submenu[onClick=inicio('?url=vistas/dialogs.view.php?sc=$')]{&nbsp;&raquo;&nbsp;Contenido SubMenu}
    tr>td[width=95%]{$nbsp;} -->
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Publicity</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/publicity/currency.php')">&nbsp;&raquo;&nbsp;Currency</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/publicity/type_publicity.php')">&nbsp;&raquo;&nbsp;Types</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/publicity/cost.php')">&nbsp;&raquo;&nbsp;Costs</td>
    </tr>
	<tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/publicity/manage.php')">&nbsp;&raquo;&nbsp;Manage</td>
    </tr>
	<tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/publicity/banners.php')">&nbsp;&raquo;&nbsp;Banners</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Backgrounds</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/tags/backgrounds.vista.php')">&nbsp;&raquo;&nbsp;Tags</td>
    </tr>
    <tr>
        <td class="td_submenu" id="td18" onClick="inicio('?url=vistas/bc_templates/bc_backgrounds.vista.php')">&nbsp;&raquo;&nbsp;Business Card</td>
    </tr>

    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
	
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Store</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/store/category.php')">&nbsp;&raquo;&nbsp;Category</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/store/sub_category.php')">&nbsp;&raquo;&nbsp;Sub-Category</td>
    </tr>
	<tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/store/products.php')">&nbsp;&raquo;&nbsp;Products</td>
    </tr>
	<tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/store/cost_points.php')">&nbsp;&raquo;&nbsp;Points</td>
    </tr>
	 <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Groups</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/groups/category.php')">&nbsp;&raquo;&nbsp;Category</td>
    </tr>
	 <tr>
        <td width="95%">&nbsp;</td>
    </tr>
	 <tr>
        <td class="td_menu"><strong style="font-size:12px">Tour</strong></td>
    </tr>
<!--    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/tour/tourActivate.view.php')">&nbsp;&raquo;&nbsp;Activate Section</td>
    </tr>-->
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/tour/createTourSection.view.php')">&nbsp;&raquo;&nbsp;Create Tour Section</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Tags</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/tags/reporTags.view.php')">&nbsp;&raquo;&nbsp;Report Tags</td>
    </tr>
    <tr>
        <td width="95%">&nbsp;</td>
    </tr>
    <tr>
        <td class="td_menu"><strong style="font-size:12px">Config</strong></td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/dialogs.view.php')">&nbsp;&raquo;&nbsp;Dialogs</td>
    </tr>
    <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/config_system.view.php')">&nbsp;&raquo;&nbsp;System</td>
    </tr>
	 <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/actions_points.view.php')">&nbsp;&raquo;&nbsp;Actions Points</td>
    </tr>
	 <tr>
        <td class="td_submenu" onClick="inicio('?url=vistas/losg_users.view.php')">&nbsp;&raquo;&nbsp;Logs User</td>
    </tr>
	<?php
	if( $_SESSION['wpanel_user']['tipo']=='0' ) { ?>
			<tr>
				<td	id="td00"
                    class="td_submenu"
					onClick="inicio('?url=vistas/super_users.view.php')">
					&nbsp;&raquo;&nbsp;Super Users				</td>
			</tr>

			<tr>
				<td	id="tdx"
                    class="td_submenu"
					onClick="inicio('?url=vistas/newsletters/newsletters.view.php')">
					&nbsp;&raquo;&nbsp;Newsletters				</td>
			</tr>

			<tr>
				<td	id="td20"
                    class="td_submenu"
					onClick="inicio('?url=vistas/spam/sendmails.view.php')">
					&nbsp;&raquo;&nbsp;Spam				</td>
			</tr>
	<?php } ?>
			<tr style="display:none">
              <td	id="td14"
                    class="td_submenu"
					onclick="inicio('?url=vistas/helps.view.php')">&nbsp;&raquo;&nbsp;Helps </td>
            </tr>


    <tr>

        <td width="95%">&nbsp;</td>
    </tr>

    <tr>

        <td width="95%">&nbsp;</td>
    </tr>
    <tr>

        <td class="td_submenu" onClick="inicio('controladores/logout.php')">&nbsp;&raquo;&nbsp;Exit</td>
    </tr>

</table>

<!--

      + --------------------------------------------------------------- +

	  |                                                                 |

	  |  Desarrollado por: websarrollo.com                              |

	  |  Tel�fono: 0414-4284230 / 0416-7301061                          |

	  |  Email: gustavoocanto@gmail.com - miharbihernandez@gmail.com    |

	  |                                                                 |

	  + --------------------------------------------------------------- +

-->