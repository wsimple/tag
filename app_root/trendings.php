<?php include 'inc/header.php'; ?>
<div id="page-trendings" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
        <div id="profile" style="position:absolute;top:0px;left:0;padding:5px;">
        <span class="photo"></span> 
        <span class="info">
            <span class="name"></span>
            <span class="points"></span>
        </span>
        </div>
        <div id="sub-menu"><ul class="ui-grid-d"></ul></div>   
    </div>
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
			// buttons:{showmenu:true,home:true},
			before:function(){
                newMenu();
                $('#sub-menu ul').html(
                    '<li class="ui-block-a timeline hover"><a href="timeLine.html">'+lan('timeline','ucw')+'</a></li>'+
                    '<li class="ui-block-b store"><a href="store.html">'+lan('store','ucw')+'</a></li>'+
                    '<li class="ui-block-c points"></li>'+
                    '<li class="ui-block-d newtag"><a href="newtag.html">'+lan('newTag','ucw')+'</a></li>'
                );
                $('#profile span.info .name').html($.local('full_name'));
                $('#profile .photo').html('<a href="profile.html"><img src="'+$.local('display_photo')+'"></a>');
			},
			after:function(){
				$('.fs-wrapper').jScroll({hScroll:false});
                getTrendings();
			}
	   });
	</script>
</div>
<?php include 'inc/footer.php'; ?>
