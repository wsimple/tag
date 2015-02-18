<?php include 'inc/header.php'; ?>
<div id="page-detailsProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="buttonShopping" href="#" data-icon="arrow-2" style="display: none;"></a>
	</div><!-- header -->
	<div data-role="content" class="list-content">
		<div id="infoDetails"></div>
	</div><!-- content -->
	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div>
    <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
				<li><a href="#"  opc="2"></a></li>
			</ul>
		</div>
	</div>
    <!-- Dialogs -->
    <div id="friendsListDialog" class="myDialog"><div class="table"><div class="cell">
        <div class="window">
            <div class="container" style="font-size: 50%;height:220px;">
                <div class="list-wrapper" style="top: 0;"><div id="scroller"><ul data-role="listview" data-inset="true"></ul><div class="clearfix"></div></div></div>
            </div>
            <div class="buttons">
                <a href="#" data-role="button" onclick="closeDialogmembersGroup('#friendsListDialog')" data-theme="f">Ok</a>
            </div>
        </div>
    </div></div></div>
	<script type="text/javascript">
		pageShow({
			id:'#page-detailsProducts',
			title:lang['STORE_DETAILS'],
            showmenuButton:true,
            before:function(){
                //languaje
                if ($_GET['fp']!==undefined) $('#buttonShopping').html(lan('join','ucw'));
                else $('#buttonShopping').html(lang.STORE_SHOPPING_ADD);
                $('#cart-footer ul').html(
                    '<li>'+
                        '<a class="ui-btn-active">'+
                            lang.STORE_VIEWORDERINCART+
                        '</a>'+
                    '</li>'
                );
            },
            after:function(){
                var info='#infoDetails';
                $(info).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
                $('.list-wrapper').jScroll({hScroll:false});
                $('.list-wrapper').jScroll('refresh');

                viewProductDetails($_GET['id'],info,$_GET['fp']);
                
               
                $(info).on('click','div.tag-solo-hash',function(){ //
                    $(this).addClass('tag-solo-hash-complete');
                    var vector=$('a[hashT]',this);
                    $.each(vector, function(key,value){ $(this).attr('hash',$(this).attr('hashT')).removeAttr('hashT'); });
                }).on('click','div.tag-solo-hash a[hash]',function(){ //tag-solo-hash-complete
                    redir(PAGE['search']+'?srh='+$(this).attr('hash').replace('#','%23').replace('<br>',' '));
                }).on('click','div a[nohref]',function(){ //tag-solo-hash-complete
                    openVideo($(this).attr('nohref'),'#popupVideo');
                });

                function viewProductDetails(id,layer,fp){
                    var module=(fp!==undefined)?'raffle':'store';
                    myAjax({
                        type    :'GET',
                        url     :DOMINIO+'controls/store/listProd.json.php?source=mobile&module='+module+'&idp='+id,
                        dataType:'json',
                        error   :function(/*resp,status,error*/){
                            myDialog('#singleDialog',lang.conectionFail);
                        },
                        success :function(data){
                          if (data['prod']){
                                var i,photo,product,outLi='',category,idcategory,hashS='',video='';
                                product=data['prod'][0];
                                category=product['category'];
                                idcategory=product['mid_category'];
                                if(product['typeVideo']){
                                    var href='',$video=$('.tag-buttons #'+product['typeVideo']).fadeIn('slow');                             
                                    if(openVideo){ href='nohref="'+product['video']+'"';
                                    }else{ href='href="'+product['video']+'" target="_blank"'; }
                                    video='<a id="'+product['typeVideo']+'" '+href+' class="video" data-ajax="false"></a>';                                
                                }
                                if(product['stock']>0 && product['idse']!==product['id_user']){
                                    if (fp!==undefined && (product['end_date'] || product['joined']))
                                        $('#buttonShopping .ui-btn-text').html(lan('participants','ucw'));
                                    $('#buttonShopping').css('display','inline-block')
                                    .click(function(){
                                        if (fp!==undefined){
                                            if (!product['joined'] && !$(this).hasClass('exist')){
                                                joinFreeProducts(product['rid']);
                                            }else{ 
                                                myDialog({
                                                    id:'#friendsListDialog',
                                                    style:{'min-height':200},
                                                    buttons:{},
                                                    after: function (options,dialog){
                                                        participantsFreeProducts(product['rid']) 
                                                    }
                                                });
                                            }
                                        }else addProductShoppingCart($_GET['id']);
                                    });
                                }
                                outLi+='<div id="idProductContent">'+
                        				'<span id="title">'+product['name']+'</span><br>'+
                                        ((fp!==undefined)?'':'<span id="CateSub">'+product['category']+' > '+product['subCategory']+'</span><br><br>')+
                                        (video!=''?'<div id="productVideo">'+video+'</div>':'')+
                                        '<div class="photosp">';
                    			if(product['place']=='1'){
                    				for(i in product['photo']){
                    					photo=product['photo'][i];
                    					outLi+='<div photo="'+photo['pic']+'" class="pic" style="background-image:url(\''+photo['pic']+'\');"></div>';
                    				}
                    			}else{ outLi+='<img src ="'+product['photo']+'" />'; }
                                if (data['hash']){ 
                                    for (var jj=0;jj<data['hash'].length;jj++){
                                        hashS+='<a href="#" hashT="'+data['hash'][jj]+'">'+data['hash'][jj]+'</a>&nbsp;&nbsp;';
                                    }
    						    }
                    			outLi+=
                    				'</div>'+
                    				'<div id="priceApp">'+lang.STORE_SHOPPING_VALUE+': <span id="points">'+((fp!==undefined)?product['points']:product['cost'])+' '+lang.STORE_SHOPPING_POINTS+'.</span>'+
                    				'<span id="seller">'+lang.STORE_SHOPPING_SELLER+'</span></div>'+
                    				'<div id="user">'+product['seller']+'</div>'+
                                    ((fp!==undefined)?
                                        '<div id="start_date">'+lan('start date','ucw')+': '+product['start_date']+'</div>'+
                                        ((!product['end_date'])?'':'<div id="end_date">'+lan('end date','ucw')+': '+product['end_date']+'</div>'):
                                        '<div id="stock">'+lan('stock','ucw')+': '+product['stock']+'</div>')+
                    				'<div id="titleDescription">'+lang.STORE_SHOPPING_DESCRIPTION+':</div>'+
                    				'<div id="description">'+product['description']+'</div>'+
                                    (hashS!=''?'<div id="titleHash">'+lang.STORE_SUGGEST+':</div><div class="tag-solo-hash">'+hashS+'</div>':'')+
                    				'</div>';
                    			$(layer).html(outLi);
                                if (fp!==undefined)
                                    $('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+lang['STORE_FREE_PRODUCTS']+'</span></span>').attr('code','freeP');
                                else
                                    $('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+category+'</span></span>').attr('code',idcategory);
                    			$('.list-wrapper').jScroll('refresh');
                    			
                    			$(".photosp").on("click","[photo]",function(){
                    				var html=
                    					'<div>'+
                    						'<strong>'+product['name']+'</strong></div>'+
                    						'<div><img src="'+$(this).attr('photo')+'" width = "150" /></div>'+
                    					'</div>';
                    				myDialog('#singleDialog',html);
                    			});
								if(product['idse']===product['id_user']){
									
									$('#storeNav #goBack').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.STORE_MYPUBLICATIONS+'</span></span>');
									$('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.newTag+'</span></span>');
									
									$('#storeNav').on('click','li a[opc]',function(){
										switch($(this).attr('opc')){
											case '1': redir(PAGE['storeMypubli']); break;
											case '2': redir(PAGE['newtag']+'?product='+product['id']); break;
										}
									});
								}else{
									$('#storeNav #goBack').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+lang.store+'</span></span>');
									
									$('#storeNav').on('click','li a[opc]',function(){
										switch($(this).attr('opc')){
											case '1': redir(PAGE['storeCat']); break;
                                            case '2': 
                                                if (fp===undefined) redir(PAGE['storeCat']);
                                                else redir(PAGE['storeFreeProducts']); 
                                            break;
                                        }
                                    });
                                }
                                $('#points').formatCurrency({symbol:''}); //Formato de moneda
                                var cost=$('#points').html();
                                var aux=cost.split('.');
                                $('#points').html(aux[0]+' '+lang.STORE_SHOPPING_POINTS);
                            }else{ myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE); }
                        }
                    }); 
                }
                function joinFreeProducts(id){
                    console.log('joinFreeProducts');
                    myDialog({
                        content :lan('JOIN_CONFIN_R'),
                        scroll:true,
                        buttons:[{
                            name:lan('yes'),
                            action:function(){
                                var di=this;
                                myAjax({
                                    type    :'GET',
                                    url     :DOMINIO+'controls/store/acctionsProducts.json.php?acc=4&rfl='+id,
                                    dataType:'json',
                                    error   :function(/*resp,status,error*/){
                                        myDialog('#singleDialog',lang.conectionFail);
                                    },
                                    success :function(data){
                                        di.close();
                                        switch(data['action']){
                                            case 'join': 
                                                myDialog('#msgDialog',lan('STORE_THANKYOUMEMBERS')); 
                                                $('#buttonShopping').addClass('exist').find('.ui-btn-text').html(lan('participants','ucw'));
                                            break;
                                            case 'end': myDialog('#msgDialog',lan('STORE_THANKYOUFINALMEMBERS')); break;
                                            case 'no-points': myDialog('#msgDialog',lan('STORE_SHOPPING_NOPOINTS')); break;
                                            case 'exist': myDialog('#msgDialog',lan('STORE_EXIST_RAFFLE')); break;
                                            case 'no-id-update': myDialog('#msgDialog',lan('TAG_DELETEDERROR')); break;
                                        }
                                    }
                                });
                            }
                        },{
                            name:'No',
                            action:function(){
                                this.close();
                            }
                        }]
                    });
                }
                function participantsFreeProducts(id){
                    console.log('participantsFreeProducts');
                    myAjax({
                        loader  : true,
                        type    : 'POST',
                        url     : DOMINIO+'controls/users/people.json.php?action=usersLikesTags&withHtml&w=380&t=r&s='+id,
                        data    :{uid:$.local('code')},
                        dataType: 'json',
                        success : function(data) {
                            var i,friend,ret = '';
                            for(i in data['datos']){
                                friend=data['datos'][i];
                                ret +=
                                    '<li data-icon="false" code="'+friend['code_friend']+'" >'+
                                        '<img src="'+friend['photo_friend']+'" style="float:left; width:60px; height:60px;" class="userBR"/>'+
                                        '<div style="float: left; margin-left:5px; font-size:10px; text-align: left;">'+
                                            '<spam style="color:#E78F08; font-weight:bold; ">' + friend['name_user'] + '</spam><br/>'+
                                            (friend['country'] ? ''+lang.country+': '+friend['country']+'<br/>' : '')+
                                            ''+lan('friends','ucw')+'('+friend['friends_count']+')<br/>'+
                                            ''+lan('admirers','ucw')+'('+friend['followers_count']+')<br/>'+
                                        '</div>'+
                                    '</li>';
                            }
                            $('#friendsListDialog .container ul').html(ret).listview('refresh');
                            $('#friendsListDialog .list-wrapper').jScroll('refresh');
                            // $('#friendsListDialog').off().on('click','[code]',function(){
                            //     redir(PAGE['profile']+'?id='+$(this).attr('code'));
                            // });
                        },
                        error   : function() {
                            myDialog('#singleDialog', 'ERROR-getMemberGroup');
                        }
                    });
                }			
            }
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
