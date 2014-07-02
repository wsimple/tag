<?php include 'inc/header.php'; ?>
<div id="page-seekPreferences" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div class="ui-listview-filter ui-bar-c">
			<input id="searchPreferences" type="search" name="searchPreferences" value="" />
		</div>
		<input id="hiddenArrayPre" name="hiddenArrayPre" type="hidden" value="" />
		<input id="typePre" name="typePre" type="hidden" value="1" />
		<div class="list-wrapper">
			<div id="scroller">
				<ul data-role="listview" id="group_preferences"></ul>
			</div>
		</div>
	</div><!-- content -->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul>
				<li><a id="labelTypePrefe1" href="#" onclick="getPreferences(1,1,'');" class="ui-btn-active"></a></li>
				<li><a id="labelTypePrefe2" href="#" onclick="getPreferences(1,2,'');"></a></li>
				<li><a id="labelTypePrefe3" href="#" onclick="getPreferences(1,3,'');"></a></li>
			</ul>
		</div>
	</div><!-- footer -->
	<script type="text/javascript">
		pageShow({
			id:'#page-seekPreferences',
			title:lang.PREFERENCES_TITLESEEK,
			backButton:true,
			before:function(){
				//languaje
				$('#labelTypePrefe1').html(lang.PREFERENCES_WHATILIKE);
				$('#labelTypePrefe2').html(lang.PREFERENCES_WHATINEED);
				$('#labelTypePrefe3').html(lang.PREFERENCES_WHATIWANT);
				$("#searchPreferences").attr('placeholder',lang.seek);
				$('.list-wrapper').jScroll({hScroll:false});
			},
			after:function(){
				getPreferences(1,$('#typePre').val(),'');//call
				$('#group_preferences').on('click','li',function(){
					touchPreferences($('#typePre').val(),$(this).attr('pref'),this,$('a',this).html());
				});
				$('#searchPreferences').keyup(function(e){
					if(e.which!=13)
						getPreferences(1,$('#typePre').val(),$.trim(this.value));
				}).focus(function(){
					if($.trim(this.value)!='')
						getPreferences(1,$('#typePre').val(),'');
				}).blur(function(){
					if($.trim(this.value)=='')
						getPreferences(1,$('#typePre').val(),'');
				}).keyup(function(e){
					getPreferences(1,$('#typePre').val(),$.trim(this.value));
				});
			}
		});
	</script>
</div><!-- page -->
<?php include 'inc/footer.php'; ?>
