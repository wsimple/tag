<?php

	include ("../../../includes/session.php");
	include ("../../../class/Mobile_Detect.php");
	include ("../../../includes/config.php");
	include ("../../../includes/functions.php");
	include ("../../../class/wconecta.class.php");
	include ("../../../includes/languages.config.php");
	include ("../../../class/forms.class.php");


	/*if ($_SESSION['ws-tags']['ws-user']['fullversion']!=1){
?>
	<!--script type="text/javascript">
		$(function(){
			$("#borderequestGroup").jScrollPane();
		});
	</script-->
<?php }else{ ?>

	<!--script type="text/javascript" src="js/jscroll.js"></script>
	<script type="text/javascript">
		var myScroll;
		function loaded() {
			setTimeout( function() {
				document.ontouchmove = function(e) { }
				myScroll = new iScroll( document.getElementById("borderequestGroup") );
			}, 100);
		}
		window.addEventListener("load", loaded, true);
	</script-->

<?php } */ ?>

<script type="text/javascript">
	$(document).ready(function(){
//		$("button, input:submit, input:reset, input:button").button();
	});
</script>

<div id="bordeasigAdmin1"
	 style="
	 border: #ccc 1px solid;
	 background-color: #FFF;
	 padding-top: 10px;
	 border-radius:5px;
	-moz-border-radius:5px;
	height: 110px;
 ">

	<div style=" margin: 0 auto; height: 110px">
		<div  style=" height: 30px;">
			<div style="float: left; margin-left: 15px; margin-top: 5px; padding-left: 15px;
				height: 20px; width: 165px;color: #D27405; padding-top:6px; font-weight: bold; font-size: 12px">
				<?=GROUPS_ASIGADMINMEMBERS?>
			</div>
			<div style="
						padding-right: 17px;
						padding-top: 14px;
						width: 270px;
						margin: 0 auto;
						text-align: justify;
						float: right;
						font-size: 10px; ">
					<?=GROUPS_SELECTADMINMEMBERS?>
			</div>
		</div>

		<br>
		<div style=" width: 500px; border-bottom: 1px solid #e5e3e3; margin-left: 10px;"></div>
		<div  style=" height: 40px; ">
			<div style="float: left; margin-left: 15px; margin-top: 12px;padding-top: 10px; padding-left: 15px; height: 20px; width: 115px; color: #D27405; padding-top:6px; font-weight: bold; font-size: 12px">
				<?=GROUPS_LEAVEGROUPADMINMEMBERS?>
			</div>
			<div style="padding: 5px; width: 280px; margin: 0 auto; text-align: justify; float: right; font-size: 10px; padding-right: 10px; padding-top: 9px;">
				<?=GROUPS_CONFIRMLEAVE?>
			</div>
		</div>

	</div>

</div>
