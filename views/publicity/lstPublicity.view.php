<?php
	if( isset($_POST['asyn']) ) {
	    include ("../../includes/session.php");
		include ("../../class/Mobile_Detect.php");
		include ("../../includes/config.php");
		include ("../../includes/functions.php");
		include ("../../class/wconecta.class.php");
		include ("../../includes/languages.config.php");
	}

function NumeroDProducts(){
    $sql = 'SELECT COUNT(id) AS registros
	FROM users_publicity p
	WHERE  p.id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'"';

	$query = mysql_query($sql) or die (mysql_error());
	$array = mysql_fetch_assoc($query);
	$NumeroR=$array['registros'];  
    return $NumeroR;
} 
?>
<script>
 $(document).ready(function() {
 	//$("#productList").load("controls/products/products.json.php");
	var c=1;
	var NR=<?=NumeroDProducts()?>;
    if (NR<10){ $('#ver').slideUp();}
	$('#ver').click(function(){
        send_ajax("controls/publicity/publicitylist.php?c="+c+"", '#publicitylist', 15, "html");
        if (NR/(c+1)<10){
                c=1;
                $('#ver').slideUp();
        }else c++;
	});
	send_ajax("controls/publicity/publicitylist.php",'#publicitylist',0,"html");
});
</script>

<div class="ui-single-box">
        <div class="ui-single-box-title">
            <?=PUBLICITY_TITLESECTION?>
                <a  id      = "btnSalePubli" class="plus"
                    onclick = "sellPublicity('views/publicity/sellPublicity.php?tipo=2', '<?=PUBLICITY_TITLEWINDOWS?>');">
                    <?=PUBLICITY_BTNNEWPUBLI?>
                </a>
            
        </div>
        <div class="clearfix"></div>
        <div>
            <div id="publicity_details">
                <div style="width: 80px; border-top-left-radius: 10px;"><?=PUBLICITY_TITLETABLE_TYPE?></div>
                <div><?=PUBLICITY_TITLETABLE_TITLE?></div>
                <div><?=PUBLICITY_TITLETABLE_INVES?></div>
                <div style="width: 60px;"><?=PUBLICITY_CTREMAILDATO4?></div>
                <div style="width: 60px;"><?=PUBLICITY_CTREMAILDATO3?></div>
                <div style="width: 85px;"><?=PUBLICITY_TITLETABLE_STATUS?></div>
                <div style="width: 80px; border-top-right-radius: 10px;"><?=PUBLICITY_TITLETABLE_ACTIONS?></div>
            </div>
            <div class="clearfix"></div>
            <div id="publicitylist" >
            </div>
            <div class="clearfix"></div>
            <a id="ver" class="plus" href="<?=HREF_DEFAULT?>" style="padding-right: 10px;"><?=USER_BTNSEEMORE?></a>
            <div class="clearfix"></div>
        </div>         
</div>