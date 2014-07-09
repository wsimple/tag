<video controls="controls" poster="http://sandbox.thewikies.com/vfe-generator/images/big-buck-bunny_poster.jpg" width="640" height="360">
	<source src="videos/homero.mp4" type="video/mp4" />
	<!-- <source src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.webm" type="video/webm" /> -->
	<!-- <source src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.ogv" type="video/ogg" /> -->
</video>
<script>
	$('video').each(function(){
		console.log(this);
		if(!this.canPlayType('video/avi')){
			var source=$('source[type=video/mp4]',this).attr('src');
			$(this).after(
				'<object type="application/x-shockwave-flash" data="StrobeMediaPlayback.swf" width="640" height="360">'+
					'<param name="movie" value="StrobeMediaPlayback.swf" />'+
					'<param name="allowFullScreen" value="true" />'+
					'<param name="wmode" value="transparent" />'+
					'<param name="flashVars" value="'+source+'" />'+
					//'<img alt="Big Buck Bunny" src="http://sandbox.thewikies.com/vfe-generator/images/big-buck-bunny_poster.jpg" width="640" height="360" title="No video playback capabilities, please download the video below" />'+
				'</object>'
			);
			$(this).remove();
		}
	});
</script>
