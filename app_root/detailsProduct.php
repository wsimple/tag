<?php include 'inc/header.php'; ?>
<div id="page-detailsProducts" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f">
		<div id="menu" class="ui-grid-d"></div>
	</div><!-- header -->
	<div data-role="content" class="list-content">
		<div id="infoDetails"></div>
	</div><!-- content -->
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
			before:function(){
                newMenu();
                menuStore(5);
			},
			after:function(){
				var info='#infoDetails';
				$(info).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('.list-wrapper').jScroll('refresh');
				viewProductDetails($_GET['id'],info,$_GET['fp']);
                function viewProductDetails(id,layer,module){
                    module=(module!==undefined)?'raffle':'store';
                	myAjax({
                		type	:'GET',
                		url		:DOMINIO+'controls/store/listProd.json.php?source=mobile&module='+module+'&idp='+id,
                		dataType:'json',
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},
                		success	:function(data){
                		  if (data['prod']){
                    			var i,photo,product,outLi='',hashS='',video='',stock='',basePhoto='',divPhotos='',nPhotos=0,picClass='',action=false;
                    			product=data['prod'][0];
                                if(product['typeVideo']){
    								var href='';
                                    if(openVideo){ href='nohref="'+product['video']+'"';
    								}else{ href='href="'+product['video']+'" target="_blank"'; }
                                    video='<a id="'+product['typeVideo']+'"	'+href+'>';
                                        // '<img src="css/newdesign/video.png" alt="" width="27" height="27">'+
                                    // '</a>';                                
    							}
                                if(product['place']=='1'){
                                    nPhotos=product['photo'].length;
                                    if (video!='') nPhotos++;
                                    for(i in product['photo']){ 
                                        photo=product['photo'][i];
                                        picClass=(i*1===0)?' first':(i*1===(nPhotos-1))?' last':'';
                                        // divPhotos+='<div><img src="'+photo['pic']+'" width = "150" /></div>';
                                        // basePhoto+='<div class="pic" style="width:'+(100/nPhotos)+'%;"><span><img src="'+photo['pic']+'" /></span></div>';
                                        basePhoto+='<div class="pic'+picClass+'" style="width:'+(100/nPhotos)+'%;"><a href="#"></a><img src="'+photo['pic']+'" /><a href="#"></a></div>';
                                        // if (basePhoto=='') basePhoto+='<div class="pic" style="background-image:url(\''+photo['pic']+'\');"></div>';
                                        if (video!='' && (i*1===0))
                                            video='<div class="vid" style="width:'+(100/nPhotos)+'%;"><a href="#" class="lastVideo"></a>'+video+'<img src="css/newdesign/video.png" alt="" width="70" height="60" style="background-image: url('+photo['pic']+')"></a><a href="#" class="lastVideo no"></a></div>';
                                    }
                                }else{ nPhotos=1;
                                    // divPhotos+='<div><img src="'+product['photo']+'" width = "150" /></div>';
                                    basePhoto+='<div class="pic"><img src="'+photo['pic']+'" style="width 100%"/></div>';  
                                    // basePhoto+='<div class="pic" style="background-image:url(\''+product['photo']+'\');"></div>';  
                                }
                                if (data['hash']){ 
                                    for (var jj=0;jj<data['hash'].length;jj++){
                                        hashS+='<a href="#" hashT="'+data['hash'][jj]+'">'+data['hash'][jj]+'</a>&nbsp;&nbsp;';
                                    }
                                }
                    			outLi+=
                    				'<div id="idProductContent">'+
                    				'<span id="title">'+product['name']+'</span><br>'+
                    				'<div class="photosp" style="width: '+(nPhotos*100)+'%">'+
                                        basePhoto+video+
                    				'</div>'+
                    				'<div id="priceApp">'+(product['pago']=='0'||module=='raffle'?'<span id="points">'+product['cost']+'</span>pts':'$<span id="points">'+product['cost']+'</span>')+'</div>'+
                                    '<div id="titleDescription">'+lang.STORE_SHOPPING_DESCRIPTION+':</div>'+
                                    '<section id="description">'+product['description']+'</section>'+
                                    (module=='raffle'?'<div id="start_date">'+lan('start date','ucw')+': '+product['start_date']+'</div>'+
                                        ((!product['end_date'])?'':'<div id="end_date">'+lan('end date','ucw')+': '+product['end_date']+'</div>'):'')+
                                    (hashS!=''?'<div id="titleHash">'+lang.STORE_SUGGEST+':</div><div class="tag-solo-hash">'+hashS+'</div>':'')+
                                    '<span id="seller">'+lang.STORE_SHOPPING_SELLER+': '+product['seller']+'</span>';
                                outLi+='<div class="buttonsDetails"><div class="ui-grid-a">'+
                                            '<div class="ui-block-a" style="width: 35%">'+
                                                '<button data-theme="c">'+(module!='raffle'?product['stock']:product['cant_users'])+'</button>'+                                        
                                            '</div>'+
                                            '<div class="ui-block-b" style="width: 65%">'+
                                                '<button id="buttonShopping" data-theme="e">'+lang.STORE_SHOPPING_ADD+'</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '<div class="ui-grid-solo">'+
                                        '<div class="ui-block-a"><button data-theme="c" id="buttonWish">'+lang.STORE_WISH_LIST_ADD+'</button></div>'+
                                    '</div></div></div>';
                    
                    			$(layer).html(outLi);
                                $( ".buttonsDetails button,.buttonsDetails a" ).button();
                                $('.list-wrapper').jScroll('refresh');
                                if (nPhotos>1){
                                    var vright=0;
                                    $(".photosp img,.photosp .vid img").swipe({
                                        swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
                                            if (vright>=0 && vright<((nPhotos-1)*100)){
                                                vright=vright+100;
                                                $(this[0]).parents('div.photosp').animate({right: '+=100%'},500);
                                            }
                                        },threshold:0,
                                        swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
                                            if (vright>0 && vright<=((nPhotos-1)*100)){
                                                vright=vright-100;
                                                $(this[0]).parents('div.photosp').animate({right: '-=100%'},500);
                                            } 
                                        },threshold:0
                                    })
                                    $(".photosp a:nth-child(3)").click(function(){
                                        if (vright>=0 && vright<((nPhotos-1)*100)){
                                            vright=vright+100;
                                            $(this).parents('div.photosp').animate({right: '+=100%'},500);
                                        }
                                    });
                                    $(".photosp a:nth-child(1)").click(function(){
                                        if (vright>0 && vright<=((nPhotos-1)*100)){
                                            vright=vright-100;
                                            $(this).parents('div.photosp').animate({right: '-=100%'},500);
                                        }
                                    });
                                    setTimeout(function(){ 
                                        var h=$('.photosp .pic.first').height();
                                        $('#infoDetails #idProductContent .photosp .pic a:nth-child(1),'+
                                           '#infoDetails #idProductContent .photosp a.lastVideo,'+
                                           '#infoDetails #idProductContent .photosp .pic a:nth-child(3)').css('display','inline-block').css('margin','0 15px '+(h/2)+'px');
                                        if (h>60) $('#infoDetails #idProductContent .photosp .vid img').css('padding',((h-60)/2)+'px 45px');
                                    }, 1500);
                                    
                                }
								if(product['idse']===product['id_user']){
                                    action=1;									
                                    if (module=='raffle'){
                                        action=2;
                                        $('#buttonShopping').html(lan('participants')).addClass('exist').prev('span').html(lan('participants','ucw'));
                                        $('#buttonShopping').click(function(){
                                            myDialog({
                                                id:'#friendsListDialog',
                                                style:{'min-height':200},
                                                buttons:{},
                                                after: function (options,dialog){
                                                    participantsFreeProducts(product['rid']) 
                                                }
                                            });
                                        });
                                        $('#buttonWish').html(lang.goback+' '+lang.STORE_MYPUBLICATIONS).attr('id','gotoMyFP').prev('span').html(lang.goback+' '+lang.STORE_MY_FREE_PRODUCTS);
                                        $('#gotoMyFP').click(function(){
                                            redir(PAGE.storeFreeProducts+'?module=myFp');
                                        });
                                    }else{
                                        $('#buttonShopping').html(lang.goback+' '+lang.store).attr('id','gotoStore').prev('span').html(lang.goback+' '+lang.store);
    									$('#buttonWish').html(lang.goback+' '+lang.STORE_MYPUBLICATIONS).attr('id','gotoMyPublications').prev('span').html(lang.goback+' '+lang.STORE_MYPUBLICATIONS);
                                        $('#gotoStore').click(function(){
                                            redir(PAGE['storeCat']);
                                        });
                                        $('#gotoMyPublications').click(function(){
                                            redir(PAGE['storeMypubli']);
                                        });
                                    }
                                }else{
                                    if (module=='raffle'){
                                        action=3;
                                        if (product['end_date']) $('#buttonShopping').html(lan('closed','ucw')).addClass('exist').prev('span').html(lan('closed','ucw'));
                                        else if (product['joined']){
                                            $('#buttonShopping').html(lan('participants')).addClass('exist').prev('span').html(lan('participants','ucw'));
                                       }else $('#buttonShopping').html(lang.GROUPS_JOIN).prev('span').html(lang.GROUPS_JOIN);
                                        $('#buttonShopping').click(function(){
                                             if ($(this).hasClass('exist')){
                                                myDialog({
                                                    id:'#friendsListDialog',
                                                    style:{'min-height':200},
                                                    buttons:{},
                                                    after: function (options,dialog){
                                                        participantsFreeProducts(product['rid']) 
                                                    }
                                                });
                                             }else joinFreeProducts(product['rid']);
                                        });
                                    }else if (product['stock']>0)
                                        $('#buttonShopping').click(function(){
                                            addProductShoppingCart($_GET['id']);
                                        });
                                    else $('#buttonShopping').html('No '+lan('stock')).prev('span').html('No '+lan('stock'));
                                    $('#buttonWish').html(lang.goback+' '+lang.STORE_FREE_PRODUCTS).attr('id','gotoFP').prev('span').html(lang.goback+' '+lang.STORE_FREE_PRODUCTS);
                                    $('#gotoFP').click(function(){
                                        redir(PAGE.storeFreeProducts);
                                    });
								}
                                $('#points').formatCurrency({symbol:''}); //Formato de moneda
                                if (product['pago']=='0'||module=='raffle'){
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
                                actionMenuStore(action);
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
                        },
                        error   : function() {
                            myDialog('#singleDialog', 'ERROR-getMemberGroup');
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
                                                $('#buttonShopping').html(lan('participants')).addClass('exist').prev('span').html(lan('participants','ucw'));
                                            break;
                                            case 'end': 
                                                myDialog('#msgDialog',lan('STORE_THANKYOUFINALMEMBERS')); 
                                                $('#buttonShopping').html(lan('participants')).addClass('exist').prev('span').html(lan('participants','ucw'));
                                            break;
                                            case 'no-points': myDialog('#msgDialog',lan('STORE_SHOPPING_NOPOINTS')); break;
                                            case 'exist': myDialog('#msgDialog',lan('STORE_EXIST_RAFFLE')); break;
                                            case 'no-id-update': myDialog('#msgDialog',lan('TAG_DELETEDERROR')); break;
                                        }
                                    }
                                });
                            }
                            },{
                            name:'No',
                            action:function(){ this.close(); }
                        }]
                    });
                }			
            }
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
