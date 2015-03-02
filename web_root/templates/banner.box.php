<?php
	$banners=$GLOBALS['cn']->queryArray('
		SELECT b.id,b.link,b.title, b.id_publi
		FROM banners b
		WHERE b.id_type=3 AND b.status=1
		ORDER BY RAND()
	');
	if(count($banners)>0){
?>
<div id="banner-box">
	<div class="banners slides_container">
		<?php
			foreach($banners as $banner){
				$pictures=$GLOBALS['cn']->queryArray('
					SELECT bp.text, bp.class, bp.picture
					FROM banners_picture bp
					WHERE bp.id_banner='.$banner['id'].' AND bp.status=1
					ORDER BY bp.order ASC
				');
				foreach ($pictures as $bp) {
					if(fileExistsRemote('img/publicity/banners/'.$bp['picture'])){
						list($widthImg,$heightImg,$tipoImagen,$atributesImagen)=getimagesize('img/publicity/banners/'.$bp['picture']);
						if($widthImg>840) $widthImg=830;
						if($heightImg>91) $heightImg=90;
						echo '<div style="background-image:url(img/publicity/banners/'.$bp['picture'].');background-size:'.$widthImg.'px '.$heightImg.'px;" action="banner,'.$banner['link'].','.md5($banner['id_publi']).'">&nbsp;</div>';
					}elseif( $bp['text'] != '' ){
						echo '<div class="'.$bp['class'].' font-b bold" action="banner,'.$banner['link'].'">'.$bp['text'].'</div>';
					}
				}
			}
        ?>
	</div>
</div>
<script>
	$(function(){
		$('#banner-box div.banners').carouFredSel({
			items:1,
			direction:'left',
			scroll:{
				duration:1000
			}
		});
	});
</script>
<?php
	}//$banners>0
?>