<div id="group-box">
<div id="tablaGroup">
	<div class="ui-single-box-title"><?=$_GET['sc']=='1'?GROUPS_LABELTABLSTMYGROUPS:GROUPS_LABELTABLSTALL?>
		<a id="btnNewGroup" class="plus"><?=GROUPS_TITLEWINDOWSNEW?></a>
	</div>
	<div class="listGroup"></div>
	</div>
	<div id="loading_groups" style="display:none"><span class="store-span-loader"><?=JS_LOADING.' '.MAINMNU_GROUPS?></span>&nbsp;&nbsp;<img src="css/smt/loader.gif" width="25" height="25" /></div>
	<div class="clearfix"></div>
</div>
<script>
$(function(){
	var ns='.ListGroup';
	$.on({
		open:function(){
			var getSC='<?=$_GET['sc']?>',get='',cate='<?=$_GET['cate']?'&cate='.$_GET['cate']:''?>',srh='';
			switch(getSC){
				case '1': get='list=my'; break;
				default : get='list=all';
			}
            get+=cate;
            listGroups('div.listGroup','',get,'div#loading_groups');
            
			//Accion del boton crear nuevo grupo
			$('#btnNewGroup').on('click',function(){
				addNewGroup('<?=GROUPS_TITLEWINDOWSNEW?>','');
				return false;
			});
            
			
			var layer=$('#group-box #tablaGroup')[0];//container
			var posi=false;
            
            //Carga Productos por categoria
			$(document).on('click','#menuGroups li a',function(){
                get=getSC=='1'?'sc=1&':'';
				if ($(this).attr('c')){
					get+='cate='+$(this).attr('c');
					redir('groups?'+get);
				}else{ redir('groups?'+get); } 
				return false;
			});
            var timeOut;
            function buscar(request,obj){
                limit=0;
                if (request!="" && obj.val().length>1) { 
                    srh='&srh='+request;
                    listGroups('div.listGroup','srh',get+srh,'div#loading_groups');
                }else{
                    srh='';
                    if (obj.val().length==0){ listGroups('div.listGroup','srh',get,'div#loading_groups');}
                }
            }
            $('#txtSearchGroups').keyup(function() {
				var request = $(this).val(),obj=$(this);
                timeOut&&clearTimeout(timeOut);
                timeOut=setTimeout(buscar(request,obj),2000);
			});
			$(window).on('scroll'+ns,function(){
					var $header=$('header',PAGE),//global
						scrollEnd=$(layer).height()-$header.offset().top-$header.height(),//window scroll ending position
						scroll=parseInt($(layer).offset().top),//actual content position
						offset=800;//when to
					if(scrollEnd+scroll<offset){
						if (!posi){
							posi=true;
							var vector=$('div.listGroup div.group_info');
							if (vector.length%6==0){
								var limit=vector.length;
								if (limit!=0){ listGroups('div.listGroup',limit,get+srh,'div#loading_groups'); }
							}
						}
					}else{ posi=false; }
			});
			},
			close:function(){
				$(window).off(ns);
				$(document).off('click','#menuGroups li a');
				$('#btnNewGroup').off();
			}
		});
});
</script>
