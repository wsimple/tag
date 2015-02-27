<?php	
	// $precios = priceListPoints(); //Vieja manera de traer puntos
	$query = "SELECT
				cost_per_point 
			  FROM config_system WHERE id=1";
	$costPerPoint = $GLOBALS['cn']->queryRow($query); 
	$costPerPoint = $costPerPoint['cost_per_point'];
?>
<div id="borderSpansorTag">
	<div id="sponsor_msgeexito">
		<div id="loading">
			<img src="img/loader.gif" width="32" height="32" />
			<br/><strong><?=EXPIREDACCOUNT_MSGBOXWINDOWSWARNING?></strong>
		</div>
	</div>
	<div id="sponsorTableTag">
		<table width="100%" border="0" align="center">
		<tr>
		  <td>
			  <div id="sponsor_msgerror1"><?=SPONSORTAG_SPANERROR3?></div>
		  </td>
		</tr>
		<tr>
			<td>
				(*)&nbsp;<?=SPONSORTAG_LBLINVESTMENT?>:
			</td>
		</tr>
		<tr>
			<td>
				<input name="amount" size="16" type="text" onkeypress="return numbersonly(event, false);" id="amount" maxlength="10" tipo="real" value="1" />
				<div class="msgPointsbuy">
					<div style="padding-bottom: 4px;"><?=SPONSORTAG_MSGINVESTMENT?></div>
					<input name="points" size="16" type="text" onkeypress="return numbersonly(event, false);" id="points" value="10" maxlength="12"> <?=STORE_VIEWPOINTS?>
				</div>
			</td>
		</tr>	
		<tr>
			<td>
				<div class="descripBuyPoints">
					<?=SPONSORTAG_MSGDESCRIPBUYPO?>
				</div>
			</td>
		</tr>
		<tr>
		  <td>
			  <div class="text_content" align="center"> <?=REQUIRED?> </div>
		  </td>
		</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#amount').blur(function(){
			var costPerPoint= <?=$costPerPoint?>;
			var val = $(this).val().replace(',','');
			$(this).val( ( val<1?1:val ) ); //Minimo de inversion 10
			val = $(this).val().replace(',','');

			//Da formato, quita decimales y actualiza la equivalencia entre dolares a puntos
			$(this).formatCurrency({symbol:''}).val( $(this).val().split(".")[0] );
			$('#points').val( val/costPerPoint ).formatCurrency({symbol:''}).html( $('#points').html().split(".")[0] );
		});
		
		$('#points').blur(function(){
			var costPerPoint= <?=$costPerPoint?>;
			var val = $(this).val().replace(',','');
			$(this).val( ( val<0.100?0.100:val ) ); //Minimo de inversion 10
			val = $(this).val().replace(',','');

			//Da formato, quita decimales y actualiza la equivalencia entre dolares a puntos
			$(this).formatCurrency({symbol:''}).val( $(this).val().split(".")[0] );
			$('#amount').val( val*costPerPoint ).formatCurrency({symbol:''}).html( $('#amount').html().split(".")[0] );
		});
		
		
	});
</script>
