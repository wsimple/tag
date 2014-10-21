<?php
include ('../includes/session.php');
include ("../includes/functions.php");
include ("../includes/config.php");
include ("../class/wconecta.class.php");
include ("../includes/languages.config.php");
global $config;

//Variables por defecto para paypal
$business      = 'elijose.c-facilitator@gmail.com'; //Cuenta de paypal de tagbum
$custom        = '';
$tax           = 0;
$currency_code = "USD";
$country       = "US";
$lc            = "en";
$cmd           = '_xclick';

//VARIABLE IMPORTANTE NOTIFICACION DE TODOS LOS PAGOS A PAYPAL (IPN)
// $notify_url    = "http://tagbum.com/controls/pay.controls.php";
$notify_url    = $config->dominio."controls/pay.controls.php";

//Producto/s que se pagaran por Paypal
$paypalProducts = array();
$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
//Verifica accion a realizar para pagos en paypal
if(isset($_GET['payAcc'])){
    switch ($_GET['payAcc']) {
        case 'store':
            $i = 0;
            if (isset($_GET['idOrder'])){
                createSessionCar('','','','',$_GET['idOrder']);
            }else{
                createSessionCar();
            }
            $noProduct=false;
            if (count($_SESSION['car'])<=1) $noProduct=true;
            else
            foreach ($_SESSION['car'] as $product){
                
                if ($product['formPayment']==1){
                    // $numItemsPaypal += 1;
                    // $totalpaypal += $product['sale_points'];

                    $paypalProducts[$i]['name']     = $product['name'];
                    $paypalProducts[$i]['amount']   = $product['sale_points'];
                    $paypalProducts[$i]['quantity'] = $product['cant'];
                    $paypalProducts[$i]['id']       = $product['id'];
                    $i+=1;
                }
                
            }
            if (!$noProduct){
                if (!isset($_GET['idOrder'])){
                    $GLOBALS['cn']->query("UPDATE store_orders SET id_status = '11', date=NOW() WHERE id_user = '".$_SESSION['car']['order']['comprador']."' AND id='".$_SESSION['car']['order']['order']."'");
                }
                if (!existe('users_notifications', 'id', 'WHERE id_type =17 AND id_source ="'.$_SESSION['car']['order']['order'].'" AND  id_user =427 AND id_friend="'.$_SESSION['car']['order']['comprador'].'"'))
                    notifications($_SESSION['ws-tags']['ws-user']['id'],$_SESSION['car']['order']['order'],17,'',$wid);
                //Datos para paypal, pago carrito de compras
                $custom        = '0|'.$_SESSION['ws-tags']['ws-user']['id'].'|'.$_SESSION['ws-tags']['ws-user']['email'].'|'.md5($_SESSION['car']['order']['order']);
                $return        = DOMINIO."#orders";
                $cancel_return = DOMINIO.'#store?sc=3';
                unset($_SESSION['havePaypalPayment']);unset($_SESSION['car']);
                // $quantity      = $totalpaypal;
                $cmd = '_cart';
            }else{
                header('Location: '.DOMINIO."#store?no-product=1");
            }
        break;
        case 'buyPoints':
            if (isset( $_GET['uid'] )) {
                //Busco los datos de la publicidad que se esta intentando pagar
                $purchase = $GLOBALS['cn']->queryRow('
                    SELECT 
                        id,
                        cost_investment,
                        points_bought
                    FROM users_points_purchase 
                    WHERE md5(id) = "'.$_GET['uid'].'" 
                    LIMIT 1
                ');
                
                //paypal
                $paypalProducts[0]['name']     = PAY_USER_POINTS;
                $paypalProducts[0]['amount']   = $purchase['cost_investment'];
                $paypalProducts[0]['quantity'] = 1;
                $paypalProducts[0]['id']       = "MIS".rand(1000,99999);
               
                $custom        = '1|'.md5($_SESSION['ws-tags']['ws-user']['id']).'|'.md5($purchase['id']);
                $return        = DOMINIO;
                $cancel_return = DOMINIO;            
            }
        break;
        case 'publicity':
            if (isset( $_GET['uid'] )) {
                //Busco los datos de la publicidad que se esta intentando pagar
                $monto_inversion = $GLOBALS['cn']->queryRow('SELECT cost_investment FROM users_publicity WHERE md5(id) = "'.$_GET['uid'].'" LIMIT 1;');
                $monto_inversion = $monto_inversion['cost_investment'];

                //paypal
                $paypalProducts[0]['name']     = PAY_PUBLICITY;
                $paypalProducts[0]['amount']   = number_format($monto_inversion, 0,'','');
                $paypalProducts[0]['quantity'] = 1;
                $paypalProducts[0]['id']       = "MIS".rand(1000,99999);

                $custom        = '2|'.$_GET['uid'];
                $return        = DOMINIO.'#publicity';
                $cancel_return = DOMINIO.'#publicity';
            }
        break;
        case 'personaltag':
            //Busco los datos de la publicidad que se esta intentando pagar
            $monto_inversion = $GLOBALS['cn']->queryRow('SELECT cost_investment FROM users_publicity WHERE id = "'.$_GET['uid'].'"  LIMIT 1;');
            $monto_inversion = $monto_inversion['cost_investment'];

            //paypal
            $paypalProducts[0]['name']     = PAY_PERSONAL_TAG;
            $paypalProducts[0]['amount']   = number_format($monto_inversion, 0,'','');
            $paypalProducts[0]['quantity'] = 1;
            $paypalProducts[0]['id']       = "MIS".rand(1000,99999);

            $custom        = '3|'.$_GET['uid'];
            $return        = DOMINIO.'#timeline?current=myTags&sponsored';
            $cancel_return = DOMINIO;
        break;
        case 'businesscards':
            //Busco los datos de la publicidad que se esta intentando pagar
            $card_price = $GLOBALS['cn']->queryRow('SELECT cost_company_bc FROM config_system WHERE id = 1 LIMIT 1;');
            $card_price = $card_price['cost_company_bc'];

            //paypal
            $paypalProducts[0]['name']     = PAY_BUSINESS_CARDS;
            $paypalProducts[0]['amount']   = $card_price;
            $paypalProducts[0]['quantity'] = 1;

            $item_number   = "MIS".rand(1000,99999);
            $custom        = '4|'.md5($_SESSION['ws-tags']['ws-user']['id']);
            $return        = DOMINIO.'#profile?sc=3';
            $cancel_return = DOMINIO;
        break;
    }
}else{ //Si la llamada a pagar no tiene variable es por que pagara cuenta business
    if (!isset($custom) || $custom == '' && isset( $_GET['uid'] ) ) {

        //Verifica si ya pago inscripcion
        $query = "SELECT id FROM users_plan_purchase WHERE id_user='".$_SESSION['business_payment']['ws-user']['id']."' AND id_plan > 0 ORDER BY id DESC LIMIT 1";

        $planPurchase = $GLOBALS['cn']->query($query);
        $incriptionCost = 0;
        if( mysql_num_rows($planPurchase) <= 0){
            $costSubcription = $GLOBALS['cn']->queryRow('SELECT cost_account_company FROM config_system WHERE id = 1 LIMIT 1;');
            $incriptionCost = $costSubcription['cost_account_company']; 
        }
        //Fin Verifica si ya pago inscripcion

        //Toma el precio de la cuenta business
        // $query = $GLOBALS['cn']->query('SELECT cost_account_company AS price FROM config_system WHERE id = 1;');
        $plans = $GLOBALS['cn']->query('SELECT price,name FROM subscription_plans WHERE id = '.$_GET['plan']);
        $plan = mysql_fetch_assoc($plans);
        // $price_account_business = $plan['price'];

        //Datos para paypal, pago de cuenta business
        $paypalProducts[0]['name']     = PAY_ACCOUNT_BUSINESS.': '.$plan['name'];
        $paypalProducts[0]['amount']   = $plan['price']+$incriptionCost;
        $paypalProducts[0]['quantity'] = 1;

        //Crea code del usuario para ser enviado para futuro login
        $query = $GLOBALS['cn']->queryRow('SELECT md5(concat(id,\'_\',email,\'_\',id)) AS code FROM users WHERE md5(id) = "'.$_GET['uid'].'" LIMIT 1;');

        $item_number   = "MIS".rand(1000,99999);
        $custom        = '5|'.$_GET['uid'].'|'.$_GET['plan'];
        $return        = DOMINIO."?current=payment&code=".$query['code'];
        $cancel_return = DOMINIO; 
    }  
}

?>

<form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post" name="paypal" id="paypal">
    <input type="hidden" name="cmd" value="<?=$cmd?>">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="<?=$business?>">
    <input type="hidden" name="image_url" value="<?=DOMINIO?>css/tbum/logo-white-orange.png">
    <input type="hidden" name="custom" id="custom" value="<?=$custom?>">
    <input type="hidden" name="return" value="<?=$return?>">
    <input type="hidden" name="notify_url" value="<?=$notify_url?>">
    <input type='hidden' name='cancel_return' value='<?=$cancel_return?>'>

    <!-- Products to paid -->
    <?php
    $i=1;
    $subFix = '';
    foreach ($paypalProducts as $p) {
        if ( $cmd == '_cart' ) $subFix = '_'.$i;
        echo '<input type="hidden" name="item_name'.$subFix.'"  value="'.$p['name'].'">';
        echo '<input type="hidden" name="quantity'.$subFix.'"  value="'.$p['quantity'].'">';
        echo '<input type="hidden" name="amount'.$subFix.'"  value="'.$p['amount'].'">';
        echo '<input type="hidden" name="item_number" value="'.$p['id'].'">';
        $i+=1;
    }
    ?>
    <!-- END Products to paid -->

    <input type="hidden" name="currency_code" value="<?=$currency_code?>">
    <!-- Enable override of payer’s stored PayPal address. -->
    <input type="hidden" name="address_override" value="0">
    <!-- Set prepopulation variables to override stored address. -->
    <input type="hidden" name="first_name" value="<?=$_SESSION['ws-tags']['ws-user'][name]?>">
    <input type="hidden" name="last_name" value="<?=$_SESSION['ws-tags']['ws-user'][last_name]?>">
    <input type="hidden" name="address1" value="">
    <input type="hidden" name="city" value="">
    <input type="hidden" name="state" value="">
    <input type="hidden" name="zip" value="">
    <input type="hidden" name="country" value="<?=$country?>">
    <input type='hidden' name='lc' value='<?=$lc?>'>
</form>
<script type="text/javascript">
      document.paypal.submit();
</script>
