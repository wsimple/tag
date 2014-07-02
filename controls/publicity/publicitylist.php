<?php
    include	('../../includes/session.php');
    include	('../../includes/config.php');
    include	('../../includes/functions.php');
    include	('../../class/wconecta.class.php');
    include	('../../includes/languages.config.php');
    include	('../../includes/qr/qrlib.php');
    include	('../../includes/tag.functions.php');
    header	('Cache-Control: no-cache, must-revalidate');
    header	('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header	('Content-type: application/json');

    $m=1;	
    $m2=10; 
    if (isset($_GET['c'])){
        $m+=$_GET['c'];
        $m2 =$m*10;
        if ($_GET['c']==0){
            $sql = 'SELECT COUNT(id) AS registros
                    FROM users_publicity p
                    WHERE  p.id_user = "'.$_SESSION['ws-tags']['ws-user']['id'].'"';

            $query = mysql_query($sql) or die (mysql_error());
            $array = mysql_fetch_assoc($query);
            $NumeroR=$array['registros'];
        
 ?>    

<script>  
        var NR=<?=$NumeroR?>;
        if (NR>10){
           $('#ver').slideDown();         
        }
</script>
<?php
        }
    }
        
if( $_GET[action]=='d' && $_GET[p] ) {
    $datos  = $GLOBALS['cn']->query("SELECT picture FROM users_publicity WHERE md5(id) = '".$_GET[p]."' ");

    $dato   = mysql_fetch_assoc($datos);

    deleteFTP(str_replace($_SESSION['ws-tags']['ws-user'][code].'/','',$dato[picture]),'publicity');

    $delete = $GLOBALS['cn']->query("DELETE FROM users_publicity WHERE md5(id) = '".$_GET[p]."' ");

        mensajes(PUBLICITY_MSGSUCCESSFULLY, PUBLICITY_TITLEMSGSUCCESS, "?current=".$_GET["current"]);
}//if action

if( $_GET["end"]=='1' ) {
        mensajes(PUBLICITY_MSGSUCCESSFULLY, PUBLICITY_TITLEMSGSUCCESS, "?current=".$_GET["current"]);
}


//seleccion de publicidades activas

$query = $GLOBALS['cn']->query("SELECT	(SELECT name FROM type_publicity a WHERE a.id = p.id_type_publicity) AS type,
                                                                                (SELECT concat(b.click_from, ' - ',b.click_to) FROM cost_publicity b WHERE b.id = p.id_cost) AS rank,
                                                                                (SELECT c.cost FROM cost_publicity c WHERE c.id = p.id_cost) AS cost,
                                                                                p.id AS id,
                                                                                p.title AS title,
                                                                                p.link AS link,
                                                                                p.cost_investment AS amount,
                                                                                p.click_max AS max,
                                                                                p.click_current AS current,
                                                                                (SELECT d.name FROM status d WHERE d.id = p.status) AS status,
                                                                                md5(p.id) AS id_p,
                                                                                p.picture AS photo,
                                                                                p.id_type_publicity AS id_type_p,
                                                                                p.id_tag AS id_tag,
                                                                                p.id_currency AS id_currency

                                                                FROM users_publicity p

                                                                WHERE p.id_user = '".$_SESSION['ws-tags']['ws-user'][id]."'

                                                                ORDER BY p.id DESC LIMIT ".($m2-10).",10");
?>


<?php
     $fila = 0;
     while( $array = mysql_fetch_assoc($query) )
     { ?>
        <div id="tr_<?=$array["id_p"]?>">

            <div id="publicityControlListPublicityDataBody">
                    <div style="width: 79px;">
                        <?=$array['type']?>
                    </div>

                    <div>
                        <?php
                            if (strlen(((trim($array['title'])!="")?$array['title']:"&nbsp;"))>=25){
                                    echo formatoCadena(substr(((trim($array['title'])!="")?$array['title']:"&nbsp;"),0,27))."<span style=cursor:pointer title=\"".$array['description']."\">...</span>";
                            }  else {
                                    echo formatoCadena(((trim($array['title'])!="")?$array['title']:"&nbsp;"));
                            }
                        ?>
                    </div>

                    <?php
                    $currency_name = $GLOBALS['cn']->query("SELECT name FROM currency WHERE id= '".$array['id_currency']."'");
                    $currency_name = mysql_fetch_assoc($currency_name);
                    ?>

                    <div><?=number_format($array['amount'], ($currency_name[name]=="points" ? 0 : 2))." ".$currency_name[name]?></div>

                    <div style="width: 59px;"><?=$array['current']?></div>

                    <div style="width: 59px;"><?=$array['max']?></div>

                    <div style="width: 84px;"><?=$array['status']?></div>

                    <div id="imagenPublicityAction" style="width: 75px;">    
                                <?php //view ?>
                                <img src	= "img/publicity/view.png"
                                    title	= "<?=PUBLICITY_HELPICONTABLE_VIEW?>"
                                    style	= "cursor:pointer"
                                    onclick= "	<?php if( $array['id_type_p']=='4' ) { ?>
                                                                commentTag('<?=PUBLICITY_TITLESEEATAG?>','<?=$array['id_tag']?>');
																
                                                <?php } else { ?>
                                                                message('messages', '<?=PUBLICITY_TITLEVIEWPUBLICITY?>', '', '',  500, 420, 'views/publicity/viewPublicity.view.php?p=<?=$array['id_p']?>');
                                                <?php } ?>">

                                <?php //edit ?>
                                <img src	= "img/publicity/edit.png"
                                    title	= "<?=PUBLICITY_HELPICONTABLE_EDIT?>"
                                    style	= "cursor:pointer"
                                    onclick= "	<?php if( $array['id_type_p']=='4' ) { ?>
                                                                           sponsorTag('views/tags/sponsor.php?tipo=2&type=<?=$array['id_type_p']?>&p=<?=$array['id_p']?>', '<?=PUBLICITY_TITLEWINDOWS?>', '<?=$array['id_tag']?>', true);
                                                           <?php } else { ?>
                                                                           sellPublicityUpdate('views/publicity/sellPublicity.php?p=<?=$array['id_p']?>&current=<?=$_GET["current"]?>&tipo=2', '<?=PUBLICITY_TITLEWINDOWS?>' <?php if ($array['photo']!=""){ ?> , true <?php }?>);
                                                           <?php }?>" />

                                <?php //delete ?>
                                <img src	= "img/publicity/delete.png"
                                        title	= "<?=PUBLICITY_HELPICONTABLE_DEL?>"
                                        style	= "cursor:pointer"
                                        onclick= "actionConfirm('<?=utf8_encode(INDEX_MSGCONFIRMATIONACTION)?>', '<?=INDEX_TITLECONFIRMACIONES?>', '', 'controls/publicity/delete.control.php?idPubli=<?=$array['id_p']?>|#tr_<?=$array["id_p"]?>');" />

                               <div id="<?=$array['id_p']?>" style="float: none; border-right: none; border-bottom: none; padding: 0px; display: inline-block; width: auto;">
                                <?php //promote
                                if( $array['current']>=$array['max'] ) { ?>
                                        <img src	= "img/publicity/resend.png"
                                            title	= "<?=PUBLICITY_LBLPROMOTEAGAIN?>"
                                            style	= "cursor:pointer"
                                            onclick= "	<?php if( $array['id_type_p']=='4' ) { ?>
                                                                        sponsorTag('views/tags/sponsor.php?tipo=2&type=<?=$array['id_type_p']?>&p=<?=$array['id_p']?>&resend=1', '<?=PUBLICITY_TITLEWINDOWS?>', '<?=$array['id_tag']?>');
                                                        <?php } else { ?>
                                                                        sellPublicityUpdate('views/publicity/sellPublicity.view.php?again&tipo=<?=$array['id_type_p']?>&resend=1&p=<?=$array['id_p']?>', '<?=PUBLICITY_TITLEWINDOWS?>', true);
                                                        <?php } ?>" />
                                <?php } else {?>

                                        <?php if( $array['status']=='Pending' ) { ?>

                                                <img src	= "img/publicity/publicity_play.png"
                                                    title	= "Continue promoting"
                                                    style	= "cursor:pointer; border-radius: 4px;"
                                                    onclick= "actionSellPublicity(0, '<?=$array['id_p']?>');"/>

                                        <?php } else { ?>

                                                <img src	= "img/publicity/publicity_pause.png"
                                                    title	= "Stop publicity for a while"
                                                    style	= "cursor:pointer; border-radius: 4px;"
                                                    onclick= "actionSellPublicity(1, '<?=$array['id_p']?>');"/>

                                        <?php } ?>
                                <?php }?>
                                </div>
                    </div>
               </div>
        </div>
        <div class="clearfix"></div>
<?php
    } 
?>


