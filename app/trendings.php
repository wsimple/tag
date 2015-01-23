<?php include 'inc/header.php'; ?>
<div id="page-trendings" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" >
        <div id="fs-wrapper" class="fs-wrapper">
    		<div id="scroller">
                <ul id="trendings" data-role="listview"  data-filter="true" data-divider-theme="e"></ul>
            </div>
        </div>
	</div>
	<script>
		pageShow({
			id:'#page-trendings',
			title:lan('hot','ucw'),
			buttons:{showmenu:true,home:true},
			before:function(){

			},
			after:function(){
				$('.fs-wrapper').jScroll({hScroll:false});
                $('#trendings').on('click','li[result]',function(){
				    redir(PAGE['search']+'?srh='+$(this).attr('result').replace('#','%23').replace('<br>',' '));
				});	
                getTrendings();
                function getTrendings(){
                    myAjax({
                		type	:'POST',
                		url		:DOMINIO+'controls/search/search.json.php',
                        data    :{trendings:true},
                		error	:function(/*resp,status,error*/){
                			myDialog('#singleDialog',lang.conectionFail);
                		},
                		success	:function(data){
                            var outH='';
                            if (data['trendings']){
                                for(i in data['datos']) 
                                    if(i){
        								pref = data['datos'][i];  
        								outH +='<li result="'+pref+'">'+pref+'</li>';
        							}
                                if (outH!=''){ $('#trendings').append(outH).listview('refresh'); }
                                else myDialog('#singleDialog',lang.TAG_CONTENTUNAVAILABLE); 
                                $('.fs-wrapper').jScroll('refresh');
                	        }else myDialog('#singleDialog',lang.conectionFail);
                        }
                	});   
                }
			}
	   });
	</script>
</div>
<?php include 'inc/footer.php'; ?>
