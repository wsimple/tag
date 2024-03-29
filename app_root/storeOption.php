<?php include 'inc/header.php'; ?>
<div id="page-lstStoreOption" data-role="page" data-cache="false" class="no-footer">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-d"></div>
	</div><!-- header -->
	<div data-role="content" class="list-content">
			<div id="storeOption"></div>
			<ul data-role="listview" id="lstStoreOption" data-divider-theme="b" class="list-info"></ul>
	</div><!-- content -->
	<script>
		pageShow({
			id:'#page-lstStoreOption',
			before:function(){
                newMenu();
                if ($_GET['option']){
                    switch($_GET['option']){
                        case '1': menuStore(5);
                            $('#page-lstStoreOption').addClass('shipping');
			                var formulario='<div id="scroller">'+
				                              '<div style="margin: 20px 0;">'+
                                                    '<form action="" method="get">'+
                                                        '<select name="country" id="country">'+
                                                            '<option value="">'+lang.STORE_COUNTRY+'</option>'+
                                                        '</select>'+
                                                        '<input type="text" name="city" id="city" placeholder="'+lang.BUSINESSCARD_LBLCITY+'" value="">'+
                                                        '<input type="text" name="zipCode" id="zipCode" placeholder="'+lang.SIGNUP_ZIPCODE+'" value="">'+
                                                        '<input name="address" id="address" placeholder="'+lang.BUSINESSCARD_LBLADDRESS+'"/>';
                                                        // '<textarea cols="40" rows="8" name="address" id="address" placeholder="'+lang.BUSINESSCARD_LBLADDRESS+'"></textarea>';
                            if ($('#menu .opc').hasClass('user')) 
                                            formulario+='<div class="ui-grid-a"><div class="ui-block-a">'+
                                                            '<select name="home_code" id="home_code" class="short">'+
                                                                '<option value="">'+lang.USERPROFILE_LBLCBOAREASCODE+'</option>'+
                                                            '</select>'+
                                                        '</div><div class="ui-block-b">'+
                                                            '<input data-mini="true" type="text" name="phoneHome" id="phoneHome" placeholder="'+lang.USERPROFILE_LBLHOMEPHONE+'" value="" onkeypress="return enterNumber(event)">'+
                                                        '</div></div>';
                                            formulario+='<div class="ui-grid-a"><div class="ui-block-a">'+
                                                            '<select name="work_code" id="work_code" class="short">'+
                                                                '<option value="">'+lang.USERPROFILE_LBLCBOAREASCODE+'</option>'+
                                                            '</select>'+                                                        
                                                        '</div><div class="ui-block-b">'+
                                                            '<input data-mini="true" type="text" name="phoneWork" id="phoneWork" placeholder="'+lang.USERPROFILE_LBLWORKPHONE+'" value="" onkeypress="return enterNumber(event)">'+
                                                        '</div></div>'+
                                                        '<div class="ui-grid-a"><div class="ui-block-a">'+
                                                            '<select name="mobile_code" id="mobile_code" class="short">'+
                                                                '<option value="">'+lang.USERPROFILE_LBLCBOAREASCODE+'</option>'+
                                                            '</select>'+
                                                        '</div><div class="ui-block-b">'+
                                                            '<input data-mini="true" type="text" name="phoneMobile" id="phoneMobile" placeholder="'+lang.USERPROFILE_LBLMOBILEPHONE+'" value="" onkeypress="return enterNumber(event)">'+
                                                        '</div></div>'+
                                                    '</form>'+
                                                '</div>'+
                                                '<div id="error"></div>'+
                                                '<div class="iconButtons">'+
                                                    '<div class="ui-grid-a"><div class="ui-block-a">'+
                                                        '<a id="buttonCheckOutOption" href="#"><img src="css/newdesign/newtag/publish.png"><br/>'+lan('STORE_SHOPPING_CHECKOUT')+'</a>'+
                                                    '</div><div class="ui-block-b">'+
                                                        '<a id="cancel" href="storeCartList.html"><img src="css/newdesign/newtag/cancel.png"><br/>'+lan('cancel')+'</a>'+
                                                    '</div></div>'+
                                                '</div>'+
			                               '</div>';
                                $('#storeOption').html(formulario).addClass('fs-wrapper');
                                $('#lstStoreOption').remove();
                        break;
                    }   
                }else{ 
                    $('#shopping').html(lang.STORE_SHOPPING_CART); 
                    $('#storeOption').remove();
                    menuStore(4);
                }
			},
			after:function(){
                if ($_GET['option']){
                    switch($_GET['option']){
                        case '1': 
                            $('.fs-wrapper').jScroll({hScroll:false});
                            myAjax({
                        		type: 'GET',
                        		url: DOMINIO+'controls/store/shoppingCart.json.php?action=16',
                        		dataType: 'json',
                                error	:function(/*resp,status,error*/){
                        			myDialog('#singleDialog',lang.conectionFail);
                        		},
                        		success: function(data){
                        		    if (!data['exitSC']){ redir(PAGE['storeCat']); }
                                    else{
                                        var timer;
                                        $('#country').append(data['datosCar']['npais']+data['datosCar']['option']);
                                        if (data['datosCar']['thome']){ 
                                            $('#home_code').append(data['datosCar']['thome']+data['datosCar']['option']); 
                                            $('#phoneHome').val(data['datosCar']['nhome']);
                                        }else { $('#home_code,#phoneHome').remove(); }
                                        $('#work_code').append(data['datosCar']['twork']+data['datosCar']['option']);
                                        $('#mobile_code').append(data['datosCar']['tmobile']+data['datosCar']['option']);
                            		    var myselect = $("#mobile_code,#work_code,#home_code,#country" );
                                        myselect.selectmenu( "refresh" );
                                        $('#city').val(data['datosCar']['city2']);
                                        $('#zipCode').val(data['datosCar']['zipCode']);
                                        $('#address').val(data['datosCar']['address']);
                                        $('#phoneWork').val(data['datosCar']['nwork']);
                                        $('#phoneMobile').val(data['datosCar']['nmobile']);
                                        // $('#buttonCheckOutOption').css('display','inline-block');
                                        $('#storeOption form select.short').change();
                                    }
                                }
                        	});
                            $('#storeOption form select.short').change(function(){
                                var obj=$(this).prev('span.ui-btn-inner').find('.ui-btn-text span'),
                                    text=$(obj).text().trim().split('(');
                                if (text[1]) $(obj).html('('+text[1]);
                                else $(obj).html(text[0]);
                            });
                            $('#buttonCheckOutOption').click(function(){
                                var string='';
                                if ($('#country').val()==''){   string+=lang.STORE_COUNTRY+'<br/>'; }
                                if ($('#city').val()==''){      string+=lang.BUSINESSCARD_LBLCITY+'<br/>'; }
                                if ($('#zipCode').val()==''){   string+=lang.SIGNUP_ZIPCODE+'<br/>'; }
                                if ($('#address').val()==''){   string+=lang.BUSINESSCARD_LBLADDRESS+'<br/>'; }
                                if ($('#phoneWork').val()=='' && ($('#phoneHome').length>0 && $('#phoneHome').val()!='' ) && $('#mobile_code').val()!=''){
                                    string+=lang.STORE_NOT_NUM_PHONE+'<br/>';
                                }else{
                                    if ($('#phoneHome').val()=='' && $('#phoneHome').val()!=$('#home_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLHOMEPHONE+'<br/>'; }
                                    if ($('#phoneWork').val()=='' && $('#phoneWork').val()!=$('#work_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLWORKPHONE+'<br/>'; }
                                    if ($('#phoneMobile').val()=='' && $('#phoneMobile').val()!=$('#mobile_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLMOBILEPHONE+'<br/>'; }
                                    if ($('#home_code').val()=='' && $('#phoneHome').val()!=$('#home_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLHOMEPHONE+'<br/>'; }
                                    if ($('#work_code').val()=='' && $('#phoneWork').val()!=$('#work_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLWORKPHONE+'<br/>'; }
                                    if ($('#mobile_code').val()=='' && $('#phoneMobile').val()!=$('#mobile_code').val()){ string+=lang.USERPROFILE_LBLCBOAREASCODE+'---'+lang.USERPROFILE_LBLMOBILEPHONE+'<br/>'; }
                                }
                                if (string!=''){ 
                                    myDialog('#singleDialog','<div class="msgShipp"><strong>'+lang.STORE_NO_COMPLETE+'</strong><p>'+string+'<br/><strong>'+lang.STORE_NO_COMPLETE_2+'</strong></p></div>');
                                }else{
                                    myAjax({
                                		type: 'POST',
                                		url: DOMINIO+'controls/store/shoppingCart.json.php?action=6',
                                		dataType: 'json',
                                        data:{
                							city	        :$('#city').val(),
                							home_code		:$('#home_code').val(),
                							mobile_code	    :$('#mobile_code').val(),
                							country	        :$('#country').val(),
                							work_code	    :$('#work_code').val(),
                							addres	        :$('#address').val(),
                							phoneWork	    :$('#phoneWork').val(),
                                            phoneHome	    :$('#phoneHome').val(),
                                            zipCode     	:$('#zipCode').val(),
                                            phoneMobile	    :$('#phoneMobile').val()
                						},
                                        error	:function(/*resp,status,error*/){
                                			
                                		},
                                		success: function(data){
                                            console.log(data);
                                            // if (data['rescity']){ myDialog('#singleDialog',data['rescity']);
                                            // }else{
                                                if (data['havePaypalPayment']){
                                                    myDialog({
                                            			id:'defaultDialog',
                                                        content:lang.STORE_NOT_CHET_DOLLAR,
                                            			buttons:[{
                                                    			name:'ok',
                                                    			action:function(){ redir(PAGE['storeCat']); }
                                                    		}]
                                            		});
                                                }else{  checkOutShoppingCart();  }
                                            // }
                                        }
                                	});
                                }   
            				});
                            actionMenuStore();
                        break;
                    }  
                    //selectFriendsDialog( 
                }else{ 
                    var info='#lstStoreOption';
    				$(info).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
    				$('.list-wrapper').jScroll({hScroll:false});
                    makeListWish();
                    function makeListWish(){
                    	myAjax({
                    		url: DOMINIO+'controls/store/shoppingCart.json.php?lisWihs=1&appMobile',
                    		dataType: 'json',
                            error	:function(/*resp,status,error*/){
                    			myDialog('#singleDialog',lang.conectionFail);
                    		},
                    		success: function(data){
                                if (data['wish'] && data['wish']['body']){
                                    $('#lstStoreOption').html(data['wish']['body']).listview('refresh');
                                    if (data['wish']['emergency']){ myDialog('#singleDialog',data['wish']['emergency']); }
                                    actionButtonsStore();
                                }else{ myDialog('#singleDialog','<div><strong>'+lang.STORE_NO_WL+'</strong></div>'); }
                                $('.list-wrapper').jScroll('refresh');
                                actionMenuStore();
                    		}
                    	});
                    }
                }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
