etiqueta video normal (mismo video varias veces consecutivas)
<video controls width="650" height="300" preload="metadata">
	<source src="<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4" type="video/mp4" />
</video>
<video controls width="650" height="300" preload="metadata">
	<source src="<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4" type="video/mp4" />
</video>
<video controls width="650" height="300" preload="metadata">
	<source src="<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4" type="video/mp4" />
</video>

<?php /*
player
<object id="f4Player" width="650" height="300" type="application/x-shockwave-flash" data="css/player.swf?v1.3.5">
	<param name="movie" value="css/player.swf?v1.3.5" />
	<param name="quality" value="high"/>
	<param name="menu" value="false" />
	<param name="scale" value="noscale" />
	<param name="allowfullscreen" value="true"/>
	<param name="allowscriptaccess" value="always"/>
	<param name="cachebusting" value="false"/>
	<param name="flashvars"   value="skin=css/skin.swf&video=<?=$setting->video_server?>videos/not-found.mp4"/>
</object>
<!-- 	<a href="http://www.adobe.com/go/flashplayer/">Download it from Adobe.</a>
	<a href="http://gokercebeci.com/dev/f4player" title="flv player">flv player</a> 
 -->

<br/>
smp 10.1
<object type="application/x-shockwave-flash" data="css/smp10.1.swf" width="650" height="300">
	<param name="movie" value="css/smp10.1.swf"/>
	<param name="allowFullScreen" value="true"/>
	<param name="wmode" value="transparent"/>
	<param name="flashVars" value="src=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4"/>
</object>

<br/>
smp10.1 modo 2
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="650" height="300">
	<param name="movie" value="css/smp10.1.swf"/>
	<param name="flashvars"
		value="src=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4
			&autoPlay=true
			&playButtonOverlay=false
			&controlBarAutoHide=false"/>
	<param name="allowFullScreen" value="true"/>
	<param name="allowscriptaccess" value="always"/>
	<embed
		src="css/smp10.1.swf"
		type="application/x-shockwave-flash"
		allowscriptaccess="always" allowfullscreen="true" width="650" height="300"
		flashvars="src=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4
			&autoPlay=true
			&playButtonOverlay=false
			&controlBarAutoHide=false">
	</embed>
</object>

<br/>
flvplayer modo 2
flvplayer modo 1
<object type="application/x-shockwave-flash" data="css/flvplayer.swf" width="650" height="300">
	<param name="movie" value="css/flvplayer.swf"/>
	<param name="allowFullScreen" value="true"/>
	<param name="wmode" value="transparent"/>
	<param name="flashVars" value="video_url=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4"/>
</object>

<br/>
flvplayer modo 2
<embed
	src="css/flvplayer.swf"
	type="application/x-shockwave-flash"
	allowscriptaccess="always" allowfullscreen="true" width="650" height="300"
	flashvars="video_hdpath=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4">
</embed>

<br/>
hdplayer
<embed
	src="css/hdplayer.swf" type="application/x-shockwave-flash"
	wmode="opaque"
	allowscriptaccess="always" allowfullscreen="true" width="650" height="300"
	flashvars="baserefWP=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4">
</embed>

<br/>
smp 10.0
<object type="application/x-shockwave-flash" data="css/smp.swf" width="650" height="300">
	<param name="movie" value="css/smp.swf"/>
	<param name="allowFullScreen" value="true"/>
	<param name="wmode" value="transparent"/>
	<param name="flashVars" value="src=<?=$setting->video_server?>videos/6a14efaf2015d80ee386d5ce40331bad/9db44ab8_20141003150747_0.mp4"/>
</object>

<?php /* ?>
<br/>
video
<video controls="controls" poster="http://sandbox.thewikies.com/vfe-generator/images/big-buck-bunny_poster.jpg" width="650" height="300">
	<source src="<?=$setting->video_server?>videos/not-found.mp4" type="video/mp4" />
	<!-- <source src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.webm" type="video/webm" /> -->
	<!-- <source src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.ogv" type="video/ogg" /> -->
</video>
<script>
	$('video').each(function(){
		console.log(this);
		if(!this.canPlayType('video/mp4')){
			var source=$('source[type=video/mp4]',this).attr('src');
			$(this).after(
				'<object type="application/x-shockwave-flash" data="StrobeMediaPlayback.swf" width="650" height="300">'+
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

<?php /**/
