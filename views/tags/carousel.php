<div class="ui-single-box">
	<?php
		include 'templates/tags/carousel.php';
	?>
	<div id="notifications-box">
		<div class="title">
			<img src="css/smt/news/icon.png"/>
			<div><?=NOTIFICATIONS_TITLESECTION?></div>
		</div>
		<?php include 'views/users/notifications.php'; ?>
	</div>	
</div>
<script>
	$(function(){
		$.qajax('high',{
			type	: 'GET',
			dataType: 'json',
			url		: 'controls/tags/tagsList.json.php?current=timeLine&limit=10&action=reload',
			success	: function(data){
				if(data['tags']&&data['tags'].length>0){
//					$$('.tag-container').html(showTags(data['tags'],false,false));
					showCarousel(data['tags'],$('.tag-container'));
					$('.tag-container [title]').tipsy({html: true,gravity: 'n'});
				}
			}
		});
		//tour Tagbum
		<?php if($_SESSION['ws-tags']['ws-user']['super_user']==1){?>
			tour(SECTION);
		<?php } ?>
	});
</script>
