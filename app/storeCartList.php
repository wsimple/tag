<?php include 'inc/header.php'; ?>
<div id="page-lstStoreCarList" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
        <div id="menu" class="ui-grid-d"></div>
        <input id="dollarApp" value="no" type="hidden"/>
        <input id="productApp" value="no" type="hidden"/>
    </div>
    <div data-role="content" class="list-content">
		<div id="data-header" class="ui-grid-a"></div>
        <ul id="cartList" data-role="listview" class="list-friends"></ul>
	</div>
    <div data-role="footer" id="footerPay"></div>
	<script>
		pageShow({
			id:'#page-lstStoreCarList',
			before:function(){
                menuStore(5);
				$('#data-header').html(
                    '<div class="ui-block-a">'+lan('invoice','ucw')+'</div>'+
                    '<div class="ui-block-b date">'+lan('date','ucw')+' <span>'+lan('Day/Month/Year')+'</span></div>'+
                    '<div class="ui-block-a numF"><span></span></div>'+
                    '<div class="ui-block-b">'+lan('method','ucw')+' <span>'+lan('none selected','ucw')+'</span></div>'+
                    '<div class="ui-block-a name"></div>'+
                    '<div class="ui-block-b total">'+lan('total amount','ucw')+'<div></div></div>'
                );
			},
			after:function(){
				var el=$('#cartList')[0],msgShipp={msg:''};
				$(el).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$(el).on('click','a[code]',function(){
					redir(PAGE['storePorduct']+'?sc='+$(this).attr('code')+'&c='+$_GET['id']);
				});
				getCartList(msgShipp);
                function getCartList(msgShipp){
                    myAjax({
                        type    :'POST',
                        url     :DOMINIO+'controls/store/shoppingCart.json.php?action=16&noEditS=1&shop=1',
                        dataType:'json',
                        data:{infoI:true},
                        error   :function(/*resp,status,error*/){
                            myDialog('#singleDialog',lang.conectionFail);
                        },
                        success :function(data){
                			var out='';
                            if (data['datosCar'][0]['name']){
                                msgShipp.msg=data['msgShipp'];
                                $('#data-header .date span').html(data['inf']['date']);
                                $('#data-header .numF span').html(data['inf']['num']);
                                $('#data-header .name').html(data['inf']['user']);
                                out=bodyCart(data);                            
                                $('#cartList').html(out).listview('refresh');
                                if (out!=''){
                                    $('#footerPay').html('<div class="ui-grid-a">'+
                                                '<div class="ui-block-a" style="width: 40%">'+
                                                    '<button id="buttonCancelCheckOut" data-theme="c">'+lan('cancel')+'</button>'+                                        
                                                '</div>'+
                                                '<div class="ui-block-b" style="width: 60%">'+
                                                    '<button id="buttonCheckOut" data-theme="e">'+lan('pay now','ucw')+'</button>'+
                                                '</div>'+
                                            '</div>');
                                    $( "#footerPay button" ).button();
                                    $('#buttonCancelCheckOut').click(function(){
                                        goBack();
                                    });
                                    $('#footerPay').removeAttr('class');
                                    $('#buttonCheckOut').click(function(){
                                        if ($('#dollarApp').val()=='si'){ myDialog('#singleDialog',lang.STORE_NOT_CHET_DOLLAR);}
                                        else {
                                            if ($('#productApp').val()=='si'){ 
                                                if (msgShipp.msg!=''){
                                                    myDialog({
                                                        id:'defaultDialog',
                                                        content:msgShipp.msg+'<div>'+lang.STORE_SHIPPING_CHANGE+'</div>',
                                                        buttons:[{
                                                                name:lang.yes,
                                                                action:function(){ redir(PAGE['storeOption']+'?option=1'); }
                                                            },{
                                                                name:'No',
                                                                action:function(){ checkOutShoppingCart('&ned=1'); }
                                                            },{
                                                                name:lang.cancel,
                                                                action:'close'
                                                            }]
                                                    });
                                                }else{ redir(PAGE['storeOption']+'?option=1'); }
                                            }else{ checkOutShoppingCart(); } 
                                          }
                                    });
                                } 
                                var myselect = $( "select.cant-product" );
                                if (myselect){
                                    myselect.selectmenu();
                                    updateCantP(myselect);
                                }
                    			$('.list-wrapper').jScroll('refresh');
                                actionButtonsStore();
                                $('#deleteShopping').click(function(){
                                    if ($('#cartList li').length>0){
                                        myDialog({
                        					id:'#idDontStore',
                        					content:'<center><strong>'+lang.STORE_DELETESHOPPING+'</strong></center>',
                        					scroll:true,
                    						buttons:[{
                                                name:lang.yes,
                                                action:function(){ deleteAllCar(); }
                                            },{
                                                name:'No',
                                                action: 'close'
                                            }]
                        				});   
                                    }else{
                                        myDialog({
                                            id:'#singleDialog',
                                            content:'<div style="text-align: center;"><strong>'+lang.STORE_NO_SC+'</strong></div>',
                                            buttons:[{
                                                name:'Ok',
                                                action:function(){ redir(PAGE.storeCat); }
                                            }]
                                        }); 
                                    }
                                });
                                if (data['bodyEmerg']){  myDialog('#singleDialog',data['bodyEmerg']); }
                            }else{  
                                myDialog({
                                    id:'#singleDialog',
                                    content:'<div style="text-align: center;"><strong>'+lang.STORE_NO_SC+'</strong></div>',
                                    buttons:[{
                                        name:'Ok',
                                        action:function(){ redir(PAGE.storeCat); }
                                    }]
                                }); 
                                $('#buttonCheckOut,#footer li.ui-block-c').remove();
                                // $('#footer ul li').css('width','50%');
                            }
                        actionMenuStore();
                		}
                	});
                }
                function deleteAllCar(){
                    var get='&all=1&mod=car',obj={mod:'car'};
                     deleteItemCar('1',get,obj);
                }
                function bodyCart(data){
                    var i,out='',num=0,cost='';
                    // outDivider='<li data-role="list-divider" class="titleDivider">'+lan('STORE_SHOPPING_TOTAL')+' ('+data.nproduct+')';
                    for(i=0;i<data.datosCar.length;i++){
                        var select='';
                        if(data.datosCar[i].place=='1' && parseInt(data.datosCar[i].stock)>0){
                            $('#productApp').val('si');
                            var option='';
                            select='<select class="cant-product" name="select-choice-mini" id="select-choice-mini" data-mini="true" data-inline="true"'+
                                        ' cantAct="'+(data.datosCar[i].sale_points*data.datosCar[i].cant)+'" precio="'+data.datosCar[i].sale_points+'" '+((data.datosCar[i].formPayment=='1')?'fr="1"':'fr="0"')+'>';
                            for(var j=1;j<=(parseInt(data.datosCar[i].stock));j++){
                                option+='<option value="'+j+'" '+(data.datosCar[i].cant==j?'selected':'')+'>'+j+'</option>';
                            }
                            select=select+option+'</select>';
                        }else if(data.datosCar[i].place=='1' && data.datosCar[i].stock<=0){
                            $('#productApp').val('si');
                            select='<em class="info-top-p">'+lan('TAGS_WHENTAGNOEXIST')+'</em><input type="hidden" class="cant-product"  value="'+data.datosCar[i].cant+'">';
                        }
                        cost=(data.datosCar[i].sale_points*data.datosCar[i].cant);
                        if(data.datosCar[i].formPayment=='1'){ $('#dollarApp').val('si'); }
                        out+='<li id="'+data.datosCar[i].mId+'" '+(i+1==data.datosCar.length?'class="last"':'')+'>'+
                                '<div class="ui-grid-a">'+
                                    '<div class="ui-block-a" style="width: 80%;">'+
                                        '<div class="name">'+data.datosCar[i].name+'</div>'+
                                        '<div>'+lan('by','ucw')+' '+data.datosCar[i].nameUser+'</div>'+
                                        '<div class="stock">'+lan('in stock','ucw')+'</div>'+
                                        select+
                                        '<div class="links buttons">'+
                                            '<a func="details" href="#" >'+lan('STORE_SHOPPING_DETAILS','ucw')+'</a> | '+
                                            '<a func="delete" href="#" >'+lan('delete','ucw')+'</a> | '+
                                            '<a func="sendWish" href="#" >'+lan('STORE_WISH_LIST_ADD')+'</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="ui-block-b" style="width: 20%;">'+
                                        '<div class="price"> '+(data.datosCar[i].formPayment=='1'?'$'+cost:cost+'Pts')+'</div>'+
                                        // '<div class="price"> '+data.datosCar[i].sale_points+' '+(data.datosCar[i].formPayment=='1'?lan('STORE_SHOPPING_DOLLARS'):lan('STORE_SHOPPING_POINTSMA'))+'</div>'+
                                    '</div>'+
                                '</div>'+
                                // '<div class="contentItem">'+
                                //     '<div class="itemDes">'+
                                //         select+
                                //     '</div>'+
                                // '</div><br/>'+
                                // '<div class="buttons">'+
                                //     '<a func="details" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lan('STORE_SHOPPING_DETAILS')+'</span></span></a>'+
                                //     '<a func="delete" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lan('STORE_SHOPPING_ITEM')+'</span></span></a>'+
                                //     '<a func="sendWish" href="#" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-up-f"><span class="ui-btn-inner"><span class="ui-btn-text">'+lan('STORE_WISH_LIST_MOVE')+'</span></span></a>'+
                                // '</div>'+
                            '</li>';
                    }
                    if(data.totalpoints>0){
                        $('#data-header .total div').append('<div class="points">'+data.totalpoints+'Pts<input type="hidden" value="'+data.totalpoints+'"></div>');
                    }
                    if(data.totalmoney>0){
                        $('#data-header .total div').append('<div class="money">$'+data.totalpoints+'<input type="hidden" value="'+data.totalpoints+'"></div>');
                    }
                    // if(data.totalpoints>0){
                    //     outDivider+='<div class="point">'+
                    //                     lan('STORE_SHOPPING_TOTAL_PRODUCTS')+
                    //                     '<span>'+data.totalpoints+'</span>'+
                    //                     '<input type="hidden" value="'+data.totalpoints+'">'+
                    //                 '</div>';
                    // }
                    // if(data.totalmoney>0){
                    //     outDivider+='<div class="money">'+
                    //                     lan('STORE_SHOPPING_TOTAL_PRODUCTSD')+
                    //                     '<span>'+data.totalmoney+'</span>'+
                    //                     '<input type="hidden" value="'+data.totalmoney+'">'+
                    //                 '</div>';
                    // }
                    // outDivider+='</li>';
                    return out;
                    // return outDivider+out;
                }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
