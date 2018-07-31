<?php

// 環境設定ファイル指定
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect("amenity_demo_new");

// t_goods_info.in_num取得
$vacc_sql   = "SELECT goods_id, in_num ";
$vacc_sql  .= "FROM   t_goods_info ";
$vacc_sql  .= "WHERE  shop_id = 1 ";
$vacc_sql  .= ";";
$res        = Db_Query($db_con, $vacc_sql);

$i = 0;
while ($goods_info_data = pg_fetch_array($res)){
    $ary_in_num[$i][0] = $goods_info_data[0];   // goods_id
    $ary_in_num[$i][1] = $goods_info_data[1];   // in_num
    $i++;
}

print "取得SQL： $vacc_sql<br>";
print "取得件数： ".count($ary_in_num)."<hr>";

// 実行ボタン押下時
if (isset($_POST["submit"])){

    Db_Query($db_con, "BEGIN;");

    // 商品毎ループ
    for ($i=0; $i<count($ary_in_num); $i++){

        // t_goods.in_numアップデート
        $up_sql  = "UPDATE t_goods ";
        $up_sql .= "SET    in_num = '".$ary_in_num[$i][1]."' ";
        $up_sql .= "WHERE  goods_id = ".$ary_in_num[$i][0]." ";
        $up_sql .= ";";
        $res     = Db_Query($db_con, $up_sql);

        // エラー時
        ($res == false) ? Db_Query($db_con, "ROLLBACK;") : null;
        ($res == false) ? exit : null;

        print "更新： $up_sql<br>";

    }

    Db_Query($db_con, "COMMIT;");

}

?>

<html>
<head></head>
<body>

<form name="form" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
<input type="submit" name="submit" value="実行" >

</body>
</html>
