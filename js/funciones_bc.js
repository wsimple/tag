function paymentBusinessCard(titulo, msj_send) {

	$('body').append('<div id="paymentBusinessCard"></div>');
	$("#paymentBusinessCard").html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
	$("#paymentBusinessCard").dialog({
		title		: titulo,
		resizable	: false,
		width		: 450,
		height		: 300,
		modal		: true,
		show		: "fade",
		hide		: "fade",
		buttons		: {
			Cancel	: function() {
				$( this ).dialog( "close" );
			},

			Pay		: function() {
				// $("#content_payment_bc").html('<div id="loading"><img src="css/smt/loader.gif" width="32" height="32" /><br/><strong>'+msj_send+'</strong></div>');
				// $.ajax({type : "POST",
				// 	url		: "views/users/account/business_card/paymentBusinessCard.view.php?pay=1",
				// 	dataType: "text",
				// 	success	: function (data) {
				// 		$("#content_payment_bc").append(data);
				// 		$(this).dialog("close");
				// 	}
				// });
				window.location = 'views/pay.view.php?payAcc=businesscards';
			}
		},

		open:function() {
			/*this is the text inside the window*/
			$("#paymentBusinessCard").load("views/users/account/business_card/paymentBusinessCard.view.php");
		}
	});
}

function actionsBusinessCard(opc, id_businessCard, window_title, id_user, id_tag) {
	switch (opc) {
		//Make Default
		case 0:
			$.ajax({
				type	:	"POST",
				url		:	"controls/business_card/setDefaultBusinessCard.controls.php?id_bc="+id_businessCard,
				dataType:	"text",
				success	:	function (data) {
								data = data.split("-");
								$("#liDefaultBc_"+data[0]).html('<img src="img/menu_businessCard/default.png"/>');
								$("#liDefaultBc_"+data[1]).html('<img style="cursor: pointer" src="img/menu_businessCard/makeDefault.png"/>');

							}
			});
		break;

		//edit
		case 1:
			redir("profile?sc=3&bc="+id_businessCard);
		break;

		//New Business Card
		case 2:
			$.ajax({
				type	:	"POST",
				url		:	'controls/business_card/businessCard.control.php?addBC',
				dataType:	"text",
				success	:	function (responseText) {
					redir(responseText);

				}
			});
		break;

		//addToAnExistingTag - when you have a BC and you want to add it to a personal tag from the menu located at businessCardPicker.php
		case 3:
			$.ajax({
				type	:	"POST",
				url		:	"controls/business_card/addToAnExistingTag.controls.php?id_bc="+id_businessCard,
				dataType:	"text",
				success	:	function (data) {

					data = data.split('|');
					//data[0] -> idTag
					//data[1] -> idBC

					if( data[1] != '' ) {
						$("#selected_tag_"+data[0]).html('<img style="cursor: pointer" src="img/menu_businessCard/default.png"/>');
						$("#bc_tag_"+data[0]).html('<img src="img/menu_tag/business_card.png" border="0" onclick="message(\'messages\', \'haaa\', \'\', \'\',  430, 300, \''+DOMINIO+'views/business_card/businessCard_dialog.view.php?bc='+data[1]+'\');"/>');
					} else {
						$("#selected_tag_"+data[0]).html('<img style="cursor: pointer" src="img/menu_businessCard/makeDefault.png"/>');
						$("#bc_tag_"+data[0]).html('<img src="img/menu_tag/no_business_card.png" border="0"/>');
					}

				}
			});
		break;

		//createATagToThisCard
		case 4:
			redir('creation?bc='+id_businessCard);
		break;

		case 5:

		break;

		//it's the list that is launched from a new personal tag creation -> button -add to business card-
		case 6:
			$('body').append('<div id="businessCardList"></div>');
			$("#businessCardList").html('<div style="padding: 250px; padding-left: 350px;" id="loading_"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
			$("#businessCardList").dialog({

					title		: window_title,
					resizable	: false,
					width		: 800,
					height		: 600,
					modal		: true,
					show		: "fade",
					hide		: "fade",
					buttons		: {
						Close  : function() {
								$("#businessCardList").html('<div id="loading_"><img src="css/smt/loader.gif" width="32" height="32" /></div>');
								$(this).dialog("close");
						}
					},

					open: function() {
						if( id_user )
							$("#businessCardList").load("views/business_card/businessCardList.view.php?id_user="+id_user);
						else if( id_tag )
							$("#businessCardList").load("views/business_card/businessCardList.view.php?id_tag="+id_tag);
						else
							$("#businessCardList").load("views/business_card/businessCardList.view.php");
					}
			});
		break;

		//Delete Business Card
		case 7:
			$.ajax({
				type	: "POST",
				url		: "controls/business_card/businessCard.control.php?id_delete_bc="+id_businessCard,
				dataType: "text",
				success	: function ( data ) {
								$("#"+id_businessCard).fadeOut('slow');
						  }
			});
		break;
	}
}

function updateBCTagLink(idTag, idBc) {
	$.ajax({
		type	:	"POST",
		url		:	'controls/business_card/businessCard.control.php?updateTagLink='+idTag+(idBc ? '&idBc='+idBc : ''),
		dataType:	"html"
	});
}
