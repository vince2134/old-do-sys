<?php

require_once("ENV_local.php");

$conn = DB_Connect("amenity_demo_new");

Db_Query($conn, "BEGIN;");

//本部を仕入先として登録する
//本部の取引先マスタの情報を抽出
$sql  = "SELECT\n";
$sql .= "    t_client.client_cd1,\n";       //ショップコード1
$sql .= "    t_client.client_name,\n";      //ショップ名
$sql .= "    t_client.client_cname,\n";     //略称
$sql .= "    t_client.post_no1,\n";         //郵便番号
$sql .= "    t_client.post_no2,\n";         //郵便番号
$sql .= "    t_client.address1,\n";         //住所1
$sql .= "    t_client.area_id,\n";          //地区
$sql .= "    t_client.tel,\n";              //TEL
$sql .= "    t_client.rep_name,\n";         //代表者氏名
$sql .= "    t_client.trade_cd,\n";         //取引区分
$sql .= "    t_client.close_day,\n";        //締日
$sql .= "    t_client.pay_m,\n";            //集金日(月)
$sql .= "    t_client.pay_d,\n";            //集金日(日)
$sql .= "    t_client.coax,\n";             //まるめ区分
$sql .= "    t_client.tax_div,\n";          //課税単位
$sql .= "    t_client.tax_franct,\n";       //端数区分
$sql .= "    t_client.sbtype_id\n";         //業種
$sql .= " FROM\n";
$sql .= "    t_client\n";
$sql .= " WHERE\n";
$sql .= "    t_client.client_div = '0'\n";
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$h_client_data = pg_fetch_array($result, 0);

//東陽を得意先として登録する
//東陽の情報を抽出
$sql  = "SELECT\n";
$sql .= "    t_client.client_cd1,\n";       //ショップコード1
$sql .= "    t_client.client_cd2,\n";       //ショップコード２
$sql .= "    t_client.client_name,\n";      //ショップ名
$sql .= "    t_client.client_cname,\n";     //略称
$sql .= "    t_client.post_no1,\n";         //郵便番号
$sql .= "    t_client.post_no2,\n";         //郵便番号
$sql .= "    t_client.address1,\n";         //住所1
$sql .= "    t_client.area_id,\n";          //地区
$sql .= "    t_client.tel,\n";              //TEL
$sql .= "    t_client.rep_name,\n";         //代表者氏名
$sql .= "    t_client.trade_cd,\n";         //取引区分
$sql .= "    t_client.close_day,\n";        //締日
$sql .= "    t_client.pay_m,\n";            //集金日(月)
$sql .= "    t_client.pay_d,\n";            //集金日(日)
$sql .= "    t_client.coax,\n";             //まるめ区分
$sql .= "    t_client.tax_div,\n";          //課税単位
$sql .= "    t_client.tax_franct,\n";       //端数区分
$sql .= "    t_client.sbtype_id\n";         //業種
$sql .= " FROM\n";
$sql .= "    t_client\n";
$sql .= " WHERE\n";
$sql .= "    t_client.client_id = 93\n";    //東陽のデータ
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$fc_client_data = pg_fetch_array($result, 0);

//全ショップの件数を抽出
$sql  = "SELECT";
$sql .= "   client_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_div = '3'";
$sql .= ";";

$fc_res = Db_Query($conn, $sql);
$fc_num = pg_num_rows($fc_res);


$count = 0;

//ショップ分ループ
for($i = 0; $i < $fc_num; $i++){
    //ショップID
    $shop_id = pg_fetch_result($fc_res,$i,0);

    //自分の所属する顧客区分を取得
    $sql  = "SELECT";   
    $sql .= "   t_rank.group_kind";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= "       INNER JOIN";
    $sql .= "   t_rank";
    $sql .= "   ON t_client.rank_cd = t_rank.rank_cd";
    $sql .= " WHERE";
    $sql .= "   t_client.client_id =$shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $group_kind = pg_fetch_result($result, 0,0);

    //顧客区分が直営の場合は処理しない
    if($group_kind != '2'){
        //地区マスタに本部用の地区を登録
        $sql  = "INSERT INTO t_area(\n";
        $sql .= "   area_id,\n";
        $sql .= "   area_cd,\n";
        $sql .= "   area_name,\n";
        $sql .= "   shop_id\n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(area_id),0)+1 FROM t_area),\n";
        $sql .= "   '0001',\n";
        $sql .= "   '本部地区',\n";
        $sql .= "   $shop_id";
        $sql .= ");\n";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //地区IDを取得
        $sql  = "SELECT";
        $sql .= "   area_id\n";
        $sql .= " FROM\n";
        $sql .= "   t_area\n";
        $sql .= " WHERE\n";
        $sql .= "   area_cd = '0001'\n";
        $sql .= "   AND\n";
        $sql .= "   shop_id = $shop_id\n";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $area_id = pg_fetch_result($result, 0);

        //本部のデータを登録
        $sql  = "INSERT INTO t_client(\n";
        $sql .= "    shop_id,\n";          //取引先マスタ
        $sql .= "    client_id,\n";        //仕入先ID
        $sql .= "    client_cd1,\n";       //仕入先CD
        $sql .= "    client_cd2,\n";       //仕入先CD２
        $sql .= "    state,\n";            //状態
        $sql .= "    client_div,\n";       //取引先区分
        $sql .= "    create_day,\n";       //作成日
        $sql .= "    shop_div,\n";         //本社・支社区分
        $sql .= "    client_name,\n";      //得意先名
        $sql .= "    client_cname,\n";     //略称
        $sql .= "    client_read,\n";      //得意先名（フリガナ）
        $sql .= "    post_no1,\n";         //郵便番号１
        $sql .= "    post_no2,\n";         //郵便番号２
        $sql .= "    address1,\n";         //住所１
        $sql .= "    area_id,\n";          //地区  
        $sql .= "    sbtype_id,\n";        //業種
        $sql .= "    tel,\n";              //電話番号
        $sql .= "    rep_name,\n";         //代表者名
        $sql .= "    close_day,\n";        //締日  
        $sql .= "    pay_m,\n";            //支払日(月)
        $sql .= "    pay_d,\n";            //支払日(日)
        $sql .= "    coax,\n";             //金額(丸め区分)
        $sql .= "    tax_div,\n";          //消費税(課税単位)
        $sql .= "    tax_franct,\n";        //消費税(端数)
        $sql .= "    head_flg\n";
        $sql .= ")VALUES(\n";
        $sql .= "    $shop_id,\n";
        $sql .= "    (SELECT COALESCE(MAX(client_id),0)+1 FROM t_client),\n";
        $sql .= "    '$h_client_data[client_cd1]',\n";
        $sql .= "    '0000',\n";
        $sql .= "    '1',\n";
        $sql .= "    '2',\n";
        $sql .= "    NOW(),\n";
        $sql .= "    '1',\n";
        $sql .= "    '$h_client_data[client_name]',\n";
        $sql .= "    '$h_client_data[client_cname]',\n";
        $sql .= "    '$h_client_data[client_read]',\n";
        $sql .= "    '$h_client_data[post_no1]',\n";
        $sql .= "    '$h_client_data[post_no2]',\n";
        $sql .= "    '$h_client_data[address1]',\n";
        $sql .= "    $area_id,\n";
        $sql .= "    62,\n";
        $sql .= "    '$h_client_data[tel]',\n";
        $sql .= "    '$h_client_data[rep_name]',\n";
        $sql .= "    '$h_client_data[close_day]',\n";
        $sql .= "    '$h_client_data[pay_m]',\n";
        $sql .= "    '$h_client_data[payd]',\n";
        $sql .= "    '$h_client_data[coax]',\n";
        $sql .= "    '$h_client_data[tax_div]',\n";
        $sql .= "    '$h_client_data[tax_franct]',\n";
        $sql .= "    't'";
        $sql .= ");\n";
        $result = Db_Query($conn, $sql);

        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //東陽のデータを登録
        $sql  = "INSERT INTO t_client(\n";
        $sql .= "    client_id,\n";        //得意先ID
        $sql .= "    shop_id,\n";
        $sql .= "    client_cd1,\n";       //得意先CD１
        $sql .= "    client_cd2,\n";       //得意先CD２
        $sql .= "    state,\n";            //状態
        $sql .= "    client_div,\n";       //取引先区分
        $sql .= "    create_day,\n";       //作成日
        $sql .= "    shop_div,\n";         //本社・支社区分
        $sql .= "    client_name,\n";      //得意先名
        $sql .= "    client_cname,\n";     //略称
        $sql .= "    post_no1,\n";         //郵便番号１
        $sql .= "    post_no2,\n";         //郵便番号２
        $sql .= "    address1,\n";         //住所１
        $sql .= "    area_id,\n";          //地区
        $sql .= "    sbtype_id,\n";        //業態ID
        $sql .= "    tel,\n";              //電話番号
        $sql .= "    rep_name,\n";         //代表者名
        $sql .= "    trade_cd,\n";         //取引区分コード
        $sql .= "    close_day,\n";        //締日
        $sql .= "    pay_m,\n";            //支払日(月)
        $sql .= "    pay_d,\n";            //支払日(日)
        $sql .= "    coax,\n";             //金額(丸め区分)
        $sql .= "    tax_div,\n";          //消費税(課税単位)
        $sql .= "    tax_franct\n";        //消費税(端数)
        $sql .= ")VALUES(\n";
        $sql .= "    (SELECT COALESCE(MAX(client_id),0)+1 FROM t_client),\n";
        $sql .= "    $shop_id,\n";
        $sql .= "    '$fc_client_data[client_cd1]',\n";
        $sql .= "    '$fc_client_data[client_cd2]',\n";
        $sql .= "    '1',\n";
        $sql .= "    '1',\n";
        $sql .= "    NOW(),\n";
        $sql .= "    '1',\n";
        $sql .= "    '$fc_client_data[client_name]',\n";
        $sql .= "    '$fc_client_data[client_cname]',\n";
        $sql .= "    '$fc_client_data[post_no1]',\n";
        $sql .= "    '$fc_client_data[post_no2]',\n";
        $sql .= "    '$fc_client_data[address1]',\n";
        $sql .= "    $fc_client_data[area_id],\n";
        $sql .= "    $fc_client_data[sbtype_id],\n";
        $sql .= "    '$fc_client_data[tel]',\n";
        $sql .= "    '$fc_client_data[rep_name]',\n";
        $sql .= "    '$fc_client_data[trade_cd]',\n";
        $sql .= "    '$fc_client_data[close_day]',\n";
        $sql .= "    '$fc_client_data[pay_m]',\n";
        $sql .= "    '$fc_client_data[payd]',\n";
        $sql .= "    '$fc_client_data[coax]',\n";
        $sql .= "    '$fc_client_data[tax_div]',\n";
        $sql .= "    '$fc_client_data[tax_franct]'\n";
        $sql .= ");\n";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //東陽のデータを得意先情報テーブルに登録
        $sql  = "INSERT INTO t_client_info (";
        $sql .= "   client_id,";
        $sql .= "   claim_id,";
        $sql .= "   cclient_shop";
        $sql .= ")VALUES(";
        $sql .= "   (SELECT";
        $sql .= "       client_id";
        $sql .= "   FROM";
        $sql .= "       t_client";
        $sql .= "   WHERE";
        $sql .= "       client_cd1 = '$fc_client_data[client_cd1]'";
        $sql .= "       AND";
        $sql .= "       client_cd2 = '$fc_client_data[client_cd2]'";
        $sql .= "       AND";
        $sql .= "       client_div = '1'";
        $sql .= "       AND";
        $sql .= "       shop_id = $shop_id";
        $sql .= "   ),";
        $sql .= "   93,";
        $sql .= "   $shop_id";
        $sql .= ");";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //既に自分の顧客区分の単価が登録されている商品を抽出
        $sql  = "SELECT";
        $sql .= "   goods_id";
        $sql .= " FROM";
        $sql .= "   t_price";
        $sql .= " WHERE";
        $sql .= "   rank_cd = '$rank_cd'";
        $sql .= "   AND";
        $sql .= "   r_price IS NOT NULL";
        $sql .= "   AND";
        $sql .= "   shop_id = 1\n";     //本部のデータ
        $sql .= ";";

        $goods_res = Db_Query($conn, $sql);
        $goods_num = pg_num_rows($goods_res);

    }
}

Db_Query($conn, "COMMIT;");

?>
