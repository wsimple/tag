<?php include 'inc/header.php'; ?>
<div id="page-myOrders" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
        <div id="menu" class="ui-grid-d" ></div>
    </div>
	<div data-role="content" >
        <div class="ui-listview-filter ui-bar-c" style="margin: auto;"><div id="rowTitle">
            <div class="ui-grid-a">
                <div class="ui-block-a">
                    <div><a href="#" class="summary" data-theme="e"></a></div>
                </div>
                <div class="ui-block-b">
                    <div><a href="#" class="filter" data-theme="e"></a></div>
                </div>
            </div>
        </div></div>
        <div id="fs-wrapper" class="fs-wrapper">
    		<div id="scroller">
                <div id="resultList" data-role="collapsible-set" data-inset="false"></div>
            </div>
        </div>
	</div>
	<script>
		pageShow({
			id:'#page-myOrders',
			// title:lan('my orders','ucw'),
			// buttons:{showmenu:true,home:true},
			before:function(){
                newMenu();
                $('#rowTitle .summary').html(lan('summary','ucw'));
                $('#rowTitle .filter').html(lan(' filter','ucw'));
                menuStore(3);
            },after:function(){
				var el='#resultList';
				$('.fs-wrapper').jScroll({hScroll:false});
                $('#resultList').on('click','li[prod]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('prod'));
				});  
                $('#resultList').on('collapse','div[data-role="collapsible"]',function(){
                    $('.fs-wrapper').jScroll('refresh');
                });
                opc={get:'',data:[]};
                armarGet(opc);
                getOrders(opc);
                function armarGet(opc){
                    if ($_GET['y']){
                        opc.get+="&year="+$_GET['y'];
                        if ($_GET['m']) opc.get+="&month="+$_GET['m'];
                    }
                }
                function getOrders(opc){
                    myAjax({
                        url     :DOMINIO+'controls/store/shoppingCart.json.php?action=9'+opc.get,
                        error   :function(/*resp,status,error*/){
                            myDialog('#singleDialog',lang.conectionFail);
                        },
                        success :function(data){
                            var out='',outS=[],a=-1,i,totalMoney=0,totalPoints=0,numItems=0,numOrdes=0;
                            if (data.datosCar.length>0){
                                var order='-1';
                                for(i=0;i<data.datosCar.length;i++){
                                    if (data.datosCar[i]['pago']=='1') continue;
                                    if (order!=data.datosCar[i]['idOrder']){
                                        if (out!='') out+='   </ul></div>';
                                        outS[++a]='';numOrdes++;
                                        out+='<div data-role="collapsible">'
                                                +'<h3>'+lan('purchase','ucw')+' - '+lan('date','ucw')+' '+data.datosCar[i]['dateOrder']+'</h3>'
                                                +'<ul id="result'+a+'" data-role="listview"  data-filter="true" data-divider-theme="e">';
                                        if (data.datosCar[i]['pago']=='11') outS[a]+='<li>'+lang.STORE_PAYABLES+'</li>';
                                        order=data.datosCar[i]['idOrder'];
                                    }
                                    var tempEle = $('<span>'+data.datosCar[i]['product_price']+'</span>');
                                    var costFormated = $(tempEle).formatCurrency({symbol:''});
                                    var cost = costFormated.html();
                                    if (data.datosCar[i]['product_formPayment']=='0'){
                                        var auxi=cost.split('.');
                                        cost = auxi[0];
                                        totalPoints=totalPoints+((data.datosCar[i]['product_price']*1)*data.datosCar[i]['product_cant']);
                                        cost= cost+' Pts';
                                    }else{
                                        totalMoney=totalMoney+((data.datosCar[i]['product_price']*1)*data.datosCar[i]['product_cant']);
                                        cost= '$'+cost;
                                    }
                                    numItems=numItems+(data.datosCar[i]['product_cant']*1);
                                    tempEle = costFormated = null;
                                    outS[a]+='<li prod="'+data.datosCar[i]['product_id']+'">'+
                                                '<a><img src="'+data.datosCar[i]['product_photo']+'" style="width:100px;height:60px;margin:20px 0 0 8px;border-radius:10px">'+
                                                    '<p class="nameProduct"><strong>'+data.datosCar[i]['product_name']+'</strong></p>'+
                                                    '<p class="descripProduct">'+lan('seller','ucw')+': <strong>'+data.datosCar[i]['product_name_user']+'</strong></p>'+
                                                    '<p>'+lan('quantity','ucw')+': '+data.datosCar[i]['product_cant']+'</p>'+
                                                    '<p class="price">'+cost+'</p>'+
                                                '</a>'+
                                            '</li>';
                                }
                                if (out!=''){
                                    $('#resultList').html(out).collapsibleset();
                                    if (outS.length>0) 
                                        for (i=0;i<=a; i++) $('#resultList #result'+i).html(outS[i]).listview(); 
                                    if (totalPoints>0){
                                        tempEle = $('<span>'+totalPoints+'</span>');
                                        costFormated = $(tempEle).formatCurrency({symbol:''});
                                        totalPoints = costFormated.html();
                                        auxi=totalPoints.split('.');
                                        totalPoints = auxi[0];
                                    }
                                    if (totalMoney>0){
                                        tempEle = $('<span>'+totalMoney+'</span>');
                                        costFormated = $(tempEle).formatCurrency({symbol:''});
                                        totalMoney = costFormated.html(); 
                                    }
                                    $('#rowTitle .summary').click(function(){
                                        myDialog({
                                            content:'<div style="text-align: left;padding: 10px;">'+
                                                        '<strong>'+lan('total orders','ucw')+': <span style="color:#F57133;">'+numOrdes+'</span></strong><br/>'+
                                                        '<strong>'+lan('total products','ucw')+': <span style="color:#F57133;">'+numItems+'</span></strong><br/>'+
                                                        (totalMoney!=0?'<strong>'+lan('total money','ucw')+': <span style="color:#F57133;">'+totalMoney+'</span></strong><br/>':'')+
                                                        (totalPoints!=0?'<strong>'+lan('total points','ucw')+': <span style="color:#F57133;">'+totalPoints+'</span></strong><br/>':'')+
                                                    '</div>',
                                            buttons:{Ok:'close'},
                                        });
                                    });
                                    myAjax({
                                        url     :DOMINIO+'controls/store/shoppingCart.json.php?action=10&option=orders',
                                        error   :function(/*resp,status,error*/){ myDialog('#singleDialog',lang.conectionFail);
                                        },success :function(data){ opc.date=data.datosCar; }
                                    });
                                    $('#rowTitle .filter').click(function(){
                                        var optionY='',optionM=[],i,validaY=[],validaM=[];
                                        for (i=0;i<opc.date.length;i++){
                                            if(validaY.indexOf(opc.date[i]['year'])!=-1){
                                                if(validaM[opc.date[i]['year']].indexOf(opc.date[i]['month'])!=-1){
                                                    optionM[opc.date[i]['year']]+='<option value="'+opc.date[i]['month']+'">'+opc.date[i]['monthL']+'</option>';
                                                     validaM[opc.date[i]['year']][validaM[opc.date[i]['year']].length]=opc.date[i]['month'];
                                                }
                                            }else{
                                                validaY[validaY.length]=opc.date[i]['year'];
                                                validaM[opc.date[i]['year']]=[];
                                                validaM[opc.date[i]['year']][0]=opc.date[i]['month'];
                                                optionY+='<option value="'+opc.date[i]['year']+'">'+opc.date[i]['year']+'</option>';
                                                optionM[opc.date[i]['year']]='<option value="'+opc.date[i]['month']+'">'+opc.date[i]['monthL']+'</option>';
                                            }
                                        }
                                        myDialog({
                                            content:'<div><form>'+
                                                    '<fieldset data-role="controlgroup" data-type="horizontal">'+
                                                        '<select name="select-native-11" id="select-year">'+
                                                        optionY+
                                                        '</select>'+
                                                        '<select name="select-native-12" id="select-month">'+
                                                        optionM[validaY[0]]+
                                                        '</select>'+
                                                    '</fieldset>'+
                                                    '</form></div>',
                                            after: function (options,dialog){
                                                $( "#select-year,#select-month" ).selectmenu().selectmenu( "refresh" );
                                                $("#select-year").change(function(){
                                                    $("#select-month").html(optionM[this.value]).selectmenu( "refresh" );
                                                });
                                            },
                                            buttons:[{
                                                name:lan('search','ucw'),
                                                action:function (){
                                                    this.close();
                                                    redir(PAGE.myOrders+"?y="+$("#select-year").val()+"&m="+$("#select-month").val()); 
                                                }
                                            },{
                                                name:lan('search','ucw')+' '+lan('current'),
                                                action:function (){
                                                    this.close();
                                                    redir(PAGE["myOrders"]);
                                                }
                                            },{
                                                name:lang.close,
                                                action:function(){ this.close(); }
                                            }]
                                        });
                                    });
                                }
                            }else myDialog('#singleDialog',lang.STORE_NO_AVAILABLE_ORDERS);
                            actionMenuStore();                                
                    	}
                	});   
                }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>