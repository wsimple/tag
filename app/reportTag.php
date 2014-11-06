<?php include 'inc/header.php'; ?>
<div id="page-reportTag" data-role="page" data-cache="false">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1></h1>
		<a id="btnReport" data-icon="check"></a>
	</div>
	<div data-role="content" class="no-footer">
		<img class="bg" src="img/bg.png" />
		<div id="fs-wrapper" class="fs-wrapper">
			<div id="scroller">
				<form id="frmReport" name="frmReport" method="post">
					<input name="mobile" type="hidden" value="1"/>
					<input id="id_tag" type="hidden"/>
					<div style="width: 90%; margin: 0 auto;">
						<div id="txt1" style="margin-top: 15px;"></div>
						<div id="txt2" style="margin-top: 15px;"></div>
						<div style="margin-top: 15px; margin-bottom: 30px;">
							<label id="txt3"></label>
							<div style="margin-top: 10px;">
								<select id="selectReport" name="selectReport">
									<option value="" selected id="selectReportFirst"></option>
								</select>
							</div>
						</div>
						<!--<input name="btnReport" type="button" id="btnReport" data-icon="arrow-r" value="Send" data-rel="dialog" data-iconpos="right" />-->
					</div>
				</form>
				<div id="tagReport" class="smt-tag-content"></div>
			</div>
		</div>
	</div>
	<script>
		pageShow({
			id:'#page-reportTag',
			title:lang.reportTagTitle,
			backButton:true,
			before:function(){
				//language constants
				$('#btnReport').html(lang.report);
				$('#selectReportFirst').html(lang.MNUTAGREPORT_SELECTONEFIRST);
				$('#txt1').html(lang.MNUTAGREPORT_TEXT1);
				$('#txt2').html(lang.MNUTAGREPORT_TEXT2);
				$('#txt3').html('<strong>'+lang.ACTIONSTAGS_REPORTTAG_TITLESELECT+'</strong>');
			},
			after:function(){
				$('#id_tag').val($_GET['id']);
				//$('#tagReport').html(showTag({'idTag':$('#id_tag').val()}));
				$('#fs-wrapper').jScroll({hScroll:false});
				$('#btnReport').click(function(){
					myAjax({
						type	: 'POST',
						url		: DOMINIO+'controls/tags/actionsTags.controls.php?action=8&tag='+$('#id_tag').val()+'&type_report='+md5($('#selectReport option:selected').val()),
						dataType: 'html',
						success	: function (data){
							myDialog({
								id:'#singleRedirDialog',
								content:data,
								buttons:{
									Ok:function(){
										redir(PAGE['timeline']);
									}
								}
							});
						}
					});
				});
				myAjax({
					type	: 'POST',
					url		: DOMINIO+'controls/tags/getTag.json.php?getReportCombo=A',
					dataType: 'json',
					success	: function( data ) {
						// Combo Month
						for(var x='',i=0; i<data.length; i+=2) {
							x += '<option value="' + data[i] + '">' + data[i+1] + '</option>';
						}
						$('#selectReport').html(x);
					}
				});

			myAjax({
					type	: 'POST',
					dataType: 'json',
					url		: DOMINIO+'controls/tags/tagsList.json.php?id='+$_GET['id'],
					error	: function(/*resp, status, error*/) {
						myDialog({
							id:'#singleRedirDialog',
							content:lang.TAG_CONTENTUNAVAILABLE,
							buttons:{
								Ok:function(){
									redir(PAGE['timeline']);
								}
							}
						});
					},
					success	: function( data ){
						var tag=data['tags'][0];
						//$('#tagReport').html(showTag(tag));
						windowFix();
						setTimeout(function(){$('#fs-wrapper').jScroll('refresh'),300});
					}
				});
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
