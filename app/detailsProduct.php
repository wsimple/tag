<?php include 'inc/header.php'; ?>
<div id="page-detailsProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-b" style="top:0px;left:0;padding:0 5px;"></div>
        <!-- <h1></h1> -->
		<!-- <a id="buttonShopping" href="#" data-icon="arrow-2" style="display: none;"></a> -->
	</div><!-- header -->
	<div data-role="content" class="list-content">
		<div id="infoDetails"></div>
	</div><!-- content -->
<!-- 	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div> -->
    <?php include 'inc/mainmenu.php'; ?>
<!--     <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
				<li><a href="#"  opc="2"></a></li>
			</ul>
		</div>
	</div> -->
	<script type="text/javascript">
		pageShow({
			id:'#page-detailsProducts',
			// title:lang['STORE_DETAILS'],
			// backButton:true,
			before:function(){
				//languaje
				// $('#category').html(lang.STORE_CATEGORY);
				// $('#buttonShopping').html(lang.STORE_SHOPPING_ADD);				
				// $('#cart-footer ul').html(
				// 	'<li>'+
				// 		'<a class="ui-btn-active">'+
				// 			lang.STORE_VIEWORDERINCART+
				// 		'</a>'+
				// 	'</li>'
				// );
                $('#menu').html(
                    '<span class="ui-block-a menu-button hover" style="width: 20%;"><a href="storeCategory.html"><img src="css/newdesign/submenu/store.png"><br>'+lan('store','ucw')+'</a></span>'+
                    // '<span class="ui-block-b"></span>'+
                    '<span class="ui-block-b" style="width: 60%"><br/><strong>'+lang.STORE_DETAILS+'</strong></span>'+
                    // '<span class="ui-block-d"></span>'+
                    '<span class="ui-block-c menu-button cart" style="width: 20%;"><a href="storeCartList.html" title="cart"><span></span><img src="css/newdesign/menu/store.png"><br>'+lan('cart','ucw')+'</a></span>'
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
                    			var i,photo,product,outLi='',hashS='',video='',stock='',basePhoto='',divPhotos='',nPhotos=0;
                    			product=data['prod'][0];
                                if(product['typeVideo']){
    								var href='';
                                    // $video=$('.tag-buttons #'+product['typeVideo']).fadeIn('slow');								
                                    if(openVideo){ href='nohref="'+product['video']+'"';
    								}else{ href='href="'+product['video']+'" target="_blank"'; }
                                    video='<a id="'+product['typeVideo']+'"	'+href+' class="video" data-ajax="false" data-role="button" data-theme="e">'+
                                        '<img src="css/newdesign/video.png" alt="" width="27" height="27">'+
                                    '</a>';                                
    							}
        //                         if(product['stock']>0){
								// 	if(product['idse']!==product['id_user']){
								// 		$('#buttonShopping').css('display','inline-block'); 	
								// 	}
								// }
                    			outLi+=
                    				'<div id="idProductContent">'+
                    				'<span id="title">'+product['name']+'</span><br>'+
                    				// '<span id="CateSub">'+product['category']+' > '+product['subCategory']+'</span><br><br>'+
                                    // (video!=''?'<div id="productVideo">'+video+'</div>':'')+
                    				'<div class="photosp">';
                                    //<div id="titleVideo">'+lang.Video+':</div>
                    			if(product['place']=='1'){
                    				for(i in product['photo']){ nPhotos++;
                    					photo=product['photo'][i];
                                        divPhotos+='<div><img src="'+photo['pic']+'" width = "150" /></div>';
                                        if (basePhoto=='') basePhoto+='<div class="pic" style="background-image:url(\''+photo['pic']+'\');"></div>';
                                    }
                                }else{ nPhotos++;
                    				divPhotos+='<div><img src="'+product['photo']+'" width = "150" /></div>';
                                    basePhoto+='<div class="pic" style="background-image:url(\''+product['photo']+'\');"></div>';  
                                }
                    			// }else{ outLi+='<img src ="'+product['photo']+'" />'; }
                                if (data['hash']){ 
                                    for (var jj=0;jj<data['hash'].length;jj++){
                                        hashS+='<a href="#" hashT="'+data['hash'][jj]+'">'+data['hash'][jj]+'</a>&nbsp;&nbsp;';
                                    }
    						    }
                                console.log(hashS);
                    			outLi+=basePhoto+
                    				'</div>'+
                    				'<div id="priceApp">'+(product['pago']=='0'?'<span id="points">'+product['cost']+'</span>pts':'$<span id="points">'+product['cost']+'</span>')+'</div>'+
                                    '<div id="titleDescription">'+lang.STORE_SHOPPING_DESCRIPTION+':</div>'+
                                    '<section id="description">'+product['description']+'</section>'+
                                    (hashS!=''?'<div id="titleHash">'+lang.STORE_SUGGEST+':</div><div class="tag-solo-hash">'+hashS+'</div>':'')+
                                    '<span id="seller">'+lang.STORE_SHOPPING_SELLER+': '+product['seller']+'</span>'+
                                    // '<div id="user">'+product['seller']+'</div>'+
                                    // '<div id="stock">'+lan('stock','ucw')+': '+product['stock']+'</div>'+
                                    '';
                    				// '</div>';
                                for (var i=1;i<=product['stock'];i++) stock+='<option value="'+i+'">'+i+'</option>';
                                /*modelo del stock con select
                                <form>
                                    <div data-role="fieldcontain">
                                        <label for="select-native-1">Basic:</label>
                                        <select name="select-native-1" id="select-native-1">';
                    
                                        </select>
                                    </div>
                                </form>
                                */
                                outLi+='<div class="buttonsDetails"><div class="ui-grid-a">'+
                                            '<div class="ui-block-a" style="width: 35%">'+
                                                '<button data-theme="c">'+product['stock']+'</button>'+                                        
                                            '</div>'+
                                            '<div class="ui-block-b" style="width: 65%">'+
                                                '<button id="buttonShopping" data-theme="e">'+lang.STORE_SHOPPING_ADD+'</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '<div class="'+(video!=''?'ui-grid-a':'ui-grid-solo')+'">'+
                                        (video!=''?
                                        '<div class="ui-block-a video" style="width: 20%;">'+video+'</div>'+
                                        '<div class="ui-block-b" style="width: 75%;"><button data-theme="c" id="buttonWish">'+lang.STORE_WISH_LIST_ADD+'</button></div>':
                                        '<div class="ui-block-a"><button data-theme="c" id="buttonWish">'+lang.STORE_WISH_LIST_ADD+'</button></div>')+
                                    '</div></div></div>';
                    
                    			$(layer).html(outLi);
                                // $('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+category+'</span></span>').attr('code',idcategory);
                    			$( ".buttonsDetails button,.buttonsDetails a" ).button();
                                numItemsCart();
                                $('.list-wrapper').jScroll('refresh');
                    			$(".photosp").on("click",".pic",function(){
                                    var html=
                    					'<div style="text-align: center;">'+
                    						'<strong>'+product['name']+'</strong></div>'+
                    						'<div id="contentImgs" style="width: '+(nPhotos*100)+'%">'+
                                               divPhotos+
                                            '</div>'+
                    					'</div>';
                                    myDialog({
                                        id:'#singleDialogProducts',
                                        content:html,
                                        after:function(){
                                            $('#contentImgs div').css('width',(100/nPhotos)+'%');
                                            var vright=0;
                                            if (nPhotos>1)
                                            $("#contentImgs img").swipe({
                                                swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
                                                    if (vright>=0 && vright<((nPhotos-1)*100)){
                                                        vright=vright+100;
                                                        console.log(vright);
                                                        $(this[0]).parents('div#contentImgs').animate({right: '+=100%'},500);
                                                    }
                                                },threshold:0,
                                                swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
                                                    if (vright>0 && vright<=((nPhotos-1)*100)){
                                                        vright=vright-100;
                                                        console.log(vright);
                                                        $(this[0]).parents('div#contentImgs').animate({right: '-=100%'},500);
                                                    } 
                                                },threshold:0
                                            });
                                        }
                                    });
                    			});

								if(product['idse']===product['id_user']){									
                                    $('#buttonShopping').html(lang.goback+' '+lang.store).attr('id','gotoStore').prev('span').html(lang.goback+' '+lang.store);
									$('#buttonWish').html(lang.goback+' '+lang.STORE_MYPUBLICATIONS).attr('id','gotoMyPublications').prev('span').html(lang.goback+' '+lang.STORE_MYPUBLICATIONS);
                                    $('#gotoStore').click(function(){
                                        redir(PAGE['storeCat']);
                                    });
                                    $('#gotoMyPublications').click(function(){
                                        redir(PAGE['storeMypubli']);
                                    });
                                    // $('#storeNav #goBack').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.STORE_MYPUBLICATIONS+'</span></span>');
									// $('#storeNav li a[opc="2"]').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.newTag+'</span></span>');
									// $('#storeNav').on('click','li a[opc]',function(){
									// 	switch($(this).attr('opc')){
									// 		case '1': redir(PAGE['storeMypubli']); break;
									// 		case '2': redir(PAGE['newtag']+'?product='+product['id']); break;
									// 	}
									// });
								}else{
                                    if (product['stock']>0){
    									$('#buttonShopping').click(function(){
                                            addProductShoppingCart($_GET['id']);
                                        });
                                    }else{
                                        $('#buttonShopping').html('No '+lan('stock')).prev('span').html('No '+lan('stock'));
                                    }
                                    $('#buttonWish').click(function(){
                                        moveToWish($_GET['id'],'',true);
                                    });
                                    // $('#storeNav #goBack').html('<span class="ui-btn-inner"><span class="ui-btn-text">'+lang.goback+' '+lang.store+'</span></span>');
									// $('#storeNav').on('click','li a[opc]',function(){
									// 	switch($(this).attr('opc')){
									// 		case '1': redir(PAGE['storeCat']); break;
									// 		case '2': redir(PAGE['storeSubCate']+'?id='+$(this).attr('code')); break;
									// 	}
									// });
								}
                                $('#points').formatCurrency({symbol:''}); //Formato de moneda
                                if (product['pago']=='0'){
                                    var cost=$('#points').html();
                                    var aux=cost.split('.');
                                    $('#points').html(aux[0]);
                                }
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
