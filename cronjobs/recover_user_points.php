<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<pre>
<?php
    $path='../';
    include $path.'includes/config.php';
    include $path.'includes/session.php';
    include $path.'includes/functions.php';
    include $path.'class/wconecta.class.php';
    include $path.'includes/languages.config.php';

    if (!is_debug()) die('c-error');
    if (!$_SESSION['ws-tags']['ws-user']['id'] || $_SESSION['ws-tags']['ws-user']['id']=='') die('u-error');

    $query=CON::query("SELECT id_type, points_owner,points_user FROM action_points ORDER BY id_type ASC");
    $points=array();
    while ($row=CON::fetchAssoc($query)) {
        $points[$row['id_type'].'_owner']=$row['points_owner']?$row['points_owner']:0;
        $points[$row['id_type'].'_user']=$row['points_user']?$row['points_user']:0;
    }
    $where="";
    if (isset($_GET['debug'])){
        print_r($points);
        if (isset($_GET['id']))  $where=safe_sql(" WHERE id=?",array($_GET['id']));
    }
    $query=CON::query("SELECT id,name,email FROM users $where");
    while ($row=CON::fetchAssoc($query)) {
        $id=$row['id'];
        $pRow=CON::getRow("SELECT
                            (SELECT COUNT(id) FROM tags WHERE id_creator=$id AND status=1) AS numTags,
                            (SELECT COUNT(id) FROM tags WHERE id_creator=$id AND status=9) AS numPersonalTags,
                            (SELECT COUNT(id) FROM likes WHERE id_user=$id) AS numLikes,
                            (SELECT COUNT(l.id) FROM likes l JOIN tags t ON t.id=l.id_source WHERE t.id_creator=$id) AS numLikesMyTags,
                            (SELECT COUNT(l.id) FROM dislikes l JOIN tags t ON t.id=l.id_source WHERE t.id_creator=$id) AS numDislikesMyTags,
                            (SELECT COUNT(id) FROM dislikes WHERE id_user=$id) AS numDislikes,
                            (SELECT COUNT(id) FROM comments WHERE id_type=4 AND id_user_from=$id) AS numComments,
                            (SELECT COUNT(id) FROM comments WHERE id_type=4 AND id_user_to=$id) AS numTocomments,
                            (SELECT COUNT(id) FROM store_products WHERE id_user=$id) AS numProducs,
                            (SELECT COUNT(id) FROM tags WHERE id_user=$id AND id_user!=id_creator AND id!=source) AS numRedist,
                            (SELECT COUNT(id) FROM tags WHERE id_creator=$id AND id_user!=id_creator AND id!=source) AS numMyTagsRedist,
                            (SELECT COUNT(id) FROM tags_report WHERE id_user_creator=$id) AS numReportMyTags,
                            (SELECT COUNT(id) FROM tags_report WHERE id_user_report=$id) AS numReportTags,
                            (SELECT SUM(od.price) FROM store_orders_detail od JOIN store_orders o ON od.id_order=o.id WHERE o.id_user=$id) AS buyStore,
                            (SELECT SUM(od.price) FROM store_orders o JOIN store_orders_detail od ON od.id_order=o.id WHERE od.id_user=$id) AS SellStore");
        $pRow['SellStore']=($pRow['SellStore']?$pRow['SellStore']:0);
        $pRow['buyStore']=($pRow['buyStore']?$pRow['buyStore']:0);
        if (isset($_GET['debug'])){
            echo '<pre>';
            print_r($pRow);
            echo '</pre>';
        }
        $puntos=(
                ($pRow['numLikesMyTags']*$points['2_owner'])+
                ($pRow['numLikes']*$points['2_user'])+
                ($pRow['numTocomments']*$points['4_owner'])+
                ($pRow['numComments']*$points['4_user'])+
                ($pRow['numMyTagsRedist']*$points['8_owner'])+
                ($pRow['numRedist']*$points['8_user'])+
                ($pRow['numDislikesMyTags']*$points['20_owner'])+
                ($pRow['numDislikes']*$points['20_user'])+
                ($pRow['numReportMyTags']*$points['21_owner'])+
                ($pRow['numReportTags']*$points['21_user'])+
                ($pRow['numTags']*$points['23_owner'])+
                ($pRow['numPersonalTags']*$points['24_user'])+
                ($pRow['SellStore']?$pRow['SellStore']:0)
                )-($pRow['buyStore']?$pRow['buyStore']:0);
        echo 'Name: '.$row['name'].' - Email: '.$row['email'].' - Puntos: '.$puntos.'<br>';
        if (!isset($_GET['no_update']))
            CON::update('users',"accumulated_points=$puntos,current_points=$puntos",'id=?',array($id));
    }
?>
</pre>
</body>
</html>