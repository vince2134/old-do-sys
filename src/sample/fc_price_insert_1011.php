<?php

/*******************************/
//単価登録スクリプト（20061010）
//
//スタッフを登録していないFCの単価を一度削除し、再度登録しなおす
/*******************************/

require_once("ENV_local.php");



$db_con = Db_Connect();

print "現在の接続DBは<b><font color=\"red\">".pg_dbname ($db_con)."</font></b>です。";

print "<br>";
print "<br>";


//登録ボタン押下処理
if($_POST["start_button"] == "登録開始"){

    Db_Query($db_con, "BEGIN;");

    //スタッフと登録していないショップの情報を抽出(直営以外)
    $sql  = "SELECT\n";
    $sql .= "   t_client.client_id,\n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
    $sql .= "   t_client.client_name,\n";
    $sql .= "   t_client.rank_cd,\n";
    $sql .= "   t_attach.shop_id \n";
    $sql .= "FROM\n";
    $sql .= "   t_client\n";
    $sql .= "     LEFT JOIN\n";
    $sql .= "   t_attach\n";
    $sql .= "   ON t_client.client_id = t_attach.shop_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_client.client_div = '3' \n";
    $sql .= "   AND\n";
    $sql .= "   t_attach.shop_id IS NULL \n";
    $sql .= "   AND\n";
    $sql .= "   t_client.rank_cd != '0003' \n";
    $sql .= "GROUP BY\n";
    $sql .= "   t_client.client_id,\n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
    $sql .= "   t_client.client_name,\n";
    $sql .= "   t_client.rank_cd,\n";
    $sql .= "   t_attach.shop_id \n";
    $sql .= "ORDER BY\n";
    $sql .= "   rank_cd,\n";
    $sql .= "   client_cd1,\n";
    $sql .= "   client_cd2 \n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);

    $fc_data = pg_fetch_all($result);

    //登録されている単価を顧客区分ごとに抽出
    //■顧客区分　0001　CT
    $sql  = "SELECT\n";
    $sql .= "   rank_cd,\n";
    $sql .= "   goods_id,\n";
    $sql .= "   r_price \n";
    $sql .= "FROM\n";
    $sql .= "   t_price\n";
    $sql .= "WHERE\n";
    $sql .= "   rank_cd = '0001'\n";
    $sql .= "   ";

    $result = Db_Query($db_con, $sql);
    $CT = pg_fetch_all($result);

    //■顧客区分　0002　SP
    $sql  = "SELECT\n";
    $sql .= "   rank_cd,\n";
    $sql .= "   goods_id,\n";
    $sql .= "   r_price \n";
    $sql .= "FROM\n";
    $sql .= "   t_price\n";
    $sql .= "WHERE\n";
    $sql .= "   rank_cd = '0002'\n";
    $sql .= "   ";

    $result = Db_Query($db_con, $sql);
    $SP = pg_fetch_all($result);

    //■顧客区分　0004　KS
    $sql  = "SELECT\n";
    $sql .= "   rank_cd,\n";
    $sql .= "   goods_id,\n";
    $sql .= "   r_price \n";
    $sql .= "FROM\n";
    $sql .= "   t_price\n";
    $sql .= "WHERE\n";
    $sql .= "   rank_cd = '0004'\n";
    $sql .= "   ";

    $result = Db_Query($db_con, $sql);
    $KS = pg_fetch_all($result);
    
    //■顧客区分　0005　SS
    $sql  = "SELECT\n";
    $sql .= "   rank_cd,\n";
    $sql .= "   goods_id,\n";
    $sql .= "   r_price \n";
    $sql .= "FROM\n";
    $sql .= "   t_price\n";
    $sql .= "WHERE\n";
    $sql .= "   rank_cd = '0005'\n";
    $sql .= "   ";

    $result = Db_Query($db_con, $sql);
    $SS = pg_fetch_all($result);

    //抽出したFC分ループ
    foreach($fc_data AS $i => $val){

        //顧客区分単価を初期化
        $rank_price = null;

        //単価テーブルに登録されている情報を削除
        $sql  = "DELETE FROM\n";
        $sql .= "   t_price \n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $val[client_id]\n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        //ショップ別商品情報テーブルに登録されている情報を削除
        $sql  = "DELETE FROM\n";
        $sql .= "   t_goods_info\n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $val[client_id]\n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        //FCの該当する顧客区分単価をセット
        //CTの場合
        if($val[rank_cd] == '0001'){
            $rank_price = $CT;
        //SPの場合
        }elseif($val[rank_cd] == '0002'){
            $rank_price = $SP;
        //KSの場合
        }elseif($val[rank_cd] == '0004'){
            $rank_price = $KS;
        //SSの場合
        }elseif($val[rank_cd] == '0005'){
            $rank_price = $SS;
        }

        //登録されている単価分ループ
        foreach($rank_price AS $j => $price_val){

            //在庫営業単価を登録
            for($s = 2; $s < 4; $s++){
                $sql  = "INSERT INTO t_price(\n";
                $sql .= "   price_id,\n";
                $sql .= "   goods_id,\n";
                $sql .= "   r_price,\n";
                $sql .= "   rank_cd,\n";
                $sql .= "   shop_id\n";
                $sql .= ")VALUES(\n";
                $sql .= "   (SELECT COALESCE(MAX(price_id),0)+1  FROM t_price),\n";
                $sql .= "   $price_val[goods_id],\n";
                $sql .= "   $price_val[r_price],\n";
                $sql .= "   '$s',\n";
                $sql .= "   $val[client_id]\n";
                $sql .= ")\n";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }

            //ショップ別商品情報テーブルに登録
            $sql  = "INSERT INTO t_goods_info(\n";
            $sql .= "   goods_id,\n";
            $sql .= "   compose_flg,\n";
            $sql .= "   head_fc_flg,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   $price_val[goods_id],\n";
            $sql .= "   'f',\n";
            $sql .= "   'f',\n";
            $sql .= "   $val[client_id]\n";
            $sql .= ")\n";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }
        print "<hr>";
        print $i."　".$val["client_cd1"]."-".$val["client_cd2"]."　".$val["client_name"]."　の単価は登録完了しました。";
        print "<br>";
    }

    Db_Query($db_con, "COMMIT;");
}

?>

<html>
<head>
<title></title>
</head>
<body>

<form action="./fc_price_insert_1011.php" method="post">
    <input type="submit" name="start_button" value="登録開始">
</form>

</body>
</html>

