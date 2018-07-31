<?php

require_once("ENV_local.php");




if($_POST["submit"] == "実行"){

    $db_con = Db_Connect("amenity");

    //初期設定
    $shop_id = 1;      //本部のID

    Db_Query($db_con, "BEGIN;");

    //単価を設定しているにもかかわらず、ショップ別商品情報テーブルに書き込めていなかったデータを抽出
    $sql  = "SELECT\n";
    $sql .= "    t_goods.goods_id\n";
    $sql .= "FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        t_price.goods_id\n";
    $sql .= "    FROM\n";
    $sql .= "        t_goods\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_price\n";
    $sql .= "        ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "    WHERE\n";
    $sql .= "        t_goods.public_flg = 't'\n";
    $sql .= "        AND\n";
    $sql .= "        t_price.shop_id = 1\n";
    $sql .= "        AND\n";
    $sql .= "        t_price.rank_cd = '0003'\n";
    $sql .= "        AND\n";
    $sql .= "        t_price.r_price IS NOT NULL\n";
    $sql .= "    ) AS t_goods\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id\n";
    $sql .= "    FROM\n";
    $sql .= "        t_goods_info\n";
    $sql .= "    WHERE\n";
    $sql .= "        shop_id IN (SELECT client_id FROM t_client WHERE rank_cd = '0003')\n";
    $sql .= "    ) AS t_goods_info\n";
    $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_goods_info.goods_id IS NULL\n";
    $sql .= ";\n";

    $result   = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

    //上記で抽出した商品ID数ループ
    for($i = 0; $i < $data_num; $i++){
        //商品ID
        $goods_id = pg_fetch_result($result, $i,0);

        //ショップ別商品情報テーブルに登録
        $sql  = "INSERT INTO t_goods_info (";
        $sql .= "   goods_id,";
        $sql .= "   compose_flg,";
        $sql .= "   head_fc_flg,";
        $sql .= "   shop_id";
        $sql .= ") VALUES (";
        $sql .= "   $goods_id,";
        $sql .= "   'f',";
        $sql .= "   'f',";
        $sql .= "   93";
        $sql .= ");";

        $res = Db_Query($db_con, $sql);
        if($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }
    Db_Query($db_con, "COMMIT;");
    print "完了";
}


?>
            
<html>
<head>
<title>直営の単価を設定しなおす</title>
</head>
<body>

<form method="post" action="./price_update_0801.php">
    <input type="submit" name="submit" value="実行">
</form>

</body>
</html>






