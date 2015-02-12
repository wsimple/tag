<?php include 'inc/header.php'; ?>
<div id="page-detailsProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-d" style="top:0px;left:0;padding:0 5px;"></div>
        <!-- <h1></h1> -->
		<!-- <a id="buttonShopping" href="#" data-icon="arrow-2" style="display: none;"></a> -->
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
	<script type="text/javascript">
		pageShow({
			id:'#page-detailsProducts',
			title:lang['STORE_DETAILS'],
			// backButton:true,
			before:function(){
				//languaje
				// $('#category').html(lang.STORE_CATEGORY);
				// $('#buttonShopping').html(lang.STORE_SHOPPING_ADD);				
				$('#cart-footer ul').html(
					'<li>'+
						'<a class="ui-btn-active">'+
							lang.STORE_VIEWORDERINCART+
						'</a>'+
					'</li>'
				);
                $('#menu').html(
                    '<span class="ui-block-a menu-button"><a href="#"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
                    '<span class="ui-block-b"></span>'+
                    '<span class="ui-block-c"><strong>'+lang.STORE_DETAILS+'</strong></span>'+
                    '<span class="ui-block-d"></span>'+
                    '<span class="ui-block-e menu-button"><a href="findFriends.html" title="cart"><img src="css/newdesign/menu/store.png"><br>'+lan('vie cart','ucw')+'</a></span>'
                );
			},
			after:function(){
				var info='#infoDetails';
				$(info).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('.list-wrapper').jScroll('refresh');
				viewProductDetails(4,$_GET['id'],info);
                function viewProductDetails(action,id,layer){//aquiiiii
                	myAjax({
                		type	:'GET',
                		url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module=store&idp='+id,
                		dataType:'json',
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},
                		success	:function(data){
                		  if (data['prod']){
                    			var i,photo,product,outLi='',category,idcategory,hashS='',video='';
                    			product=data['prod'][0];
                                category=product['category'];
                                idcategory=product['mid_category'];
                                if(product['typeVideo']){
    								var href='',$video=$('.tag-buttons #'+product['typeVideo']).fadeIn('slow');								
                                    if(openVideo){ href='nohref="'+product['video']+'"';
    								}else{ href='href="'+product['video']+'" target="_blank"'; }
                                    video='<a id="'+product['typeVideo']+'"	'+href+' class="video" data-ajax="false"></a>';                                
    							}
                                if(product['stock']>0){
									if(product['idse']!==product['id_user']){
										$('#buttonShopping').css('display','inline-block'); 	
									}
								}
                    			outLi+=
                    				'<div id="idProductContent">'+
                    				'<span id="title">'+product['name']+'</span><br>'+
                    				// '<span id="CateSub">'+product['category']+' > '+product['subCategory']+'</span><br><br>'+
                                    // (video!=''?'<div id="productVideo">'+video+'</div>':'')+
                    				'<div class="photosp">';
                                    //<div id="titleVideo">'+lang.Video+':</div>
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
                    				'<div id="priceApp">: <span id="points">'+(product['pago']=='0'?product['cost']+'Pts':'$'+product['cost'])+'</span>'+
                    				'<span id="seller">'+lang.STORE_SHOPPING_SELLER+'</span></div>'+
                    				'<div id="user">'+product['seller']+'</div>'+
                                    '<div id="stock">'+lan('stock','ucw')+': '+product['stock']+'</div>'+
                    				'<div id="titleDescription">'+lang.STORE_SHOPPING_DESCRIPTION+':</div>'+
                    				'<div id="description">'+product['description']+'</div>'+
                                    (hashS!=''?'<div id="titleHash">'+lang.STORE_SUGGEST+':</div><div class="tag-solo-hash">'+hashS+'</div>':'')+
                    				'</div>';
                    
                    			$(layer).html(outLi);
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
											case '2': redir(PAGE['storeSubCate']+'?id='+$(this).attr('code')); break;
										}
									});
								}
								
                                $('#buttonShopping').click(function(){
                					addProductShoppingCart($_GET['id']);
                				});

                                $('#points').formatCurrency({symbol:''}); //Formato de moneda
                                var cost=$('#points').html();
                                var aux=cost.split('.');
                                $('#points').html(aux[0]+' '+lang.STORE_SHOPPING_POINTS);
                                 $(info).on('click','div.tag-solo-hash',function(){ //
                                    $(this).addClass('tag-solo-hash-complete');
                                    var vector=$('a[hashT]',this);
                                    $.each(vector, function(key,value){ $(this).attr('hash',$(this).attr('hashT')).removeAttr('hashT'); });
                                }).on('click','div.tag-solo-hash a[hash]',function(){ //tag-solo-hash-complete
                                    redir(PAGE['search']+'?srh='+$(this).attr('hash').replace('#','%23').replace('<br>',' '));
                                }).on('click','div a[nohref]',function(){ //tag-solo-hash-complete
                                    openVideo($(this).attr('nohref'),'#popupVideo');
                                });
                            }else{ myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE); }
                		}
                	}); 
                }
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
