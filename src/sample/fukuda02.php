<?php

// 環境設定ファイル指定
require_once("ENV_local.php");

// DB接続設定
//$db_con = Db_Connect("amenity_demo_new");
//$db_con = Db_Connect("amenity_morita");
$db_con = Db_Connect();


/***************************************
    行データを取得（得意先コードがNULLの行）
***************************************/
// 仕入が選択された場合
if ($_POST["table"] == "t_buy"){
    // 仕入ヘッダ
    $sql_h  = "SELECT ";
    $sql_h .= "     t_buy_h.buy_id, ";                              // 仕入ID
    $sql_h .= "     t_client.client_cd1, ";                         // 得意先コード1
    $sql_h .= "     t_client.client_name, ";                        // 得意先名
    $sql_h .= "     t_client.client_name2, ";                       // 直送先名2
    $sql_h .= "     t_direct.direct_name, ";                        // 直送先名
    $sql_h .= "     t_direct.direct_name2, ";                       // 直送先名2
    $sql_h .= "     t_ware.ware_name, ";                            // 入荷倉庫名
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // 担当者名
    $sql_h .= "     t_e_staff.staff_name AS e_staff_name, ";        // 入力者名
    $sql_h .= "     t_oc_staff.staff_name AS oc_staff_name ";       // 発注担当者名
    $sql_h .= "FROM t_buy_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_buy_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_buy_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_buy_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_buy_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_e_staff ON t_buy_h.e_staff_id = t_e_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_oc_staff ON t_buy_h.oc_staff_id = t_oc_staff.staff_id ";
//    $sql_h .= "WHERE t_buy_h.client_name IS NULL ";
    $sql_h .= ";";
    // 仕入データ
    $sql_d  = "SELECT ";
    $sql_d .= "     t_buy_d.buy_d_id, ";                            // 仕入データID
    $sql_d .= "     t_goods.goods_cd, ";                            // 商品コード
    $sql_d .= "     t_goods.in_num ";                               // 入数
    $sql_d .= "FROM t_buy_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
//    $sql_d .= "WHERE t_buy_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// 発注が選択された場合
if ($_POST["table"] == "t_order"){
    // 発注ヘッダ
    $sql_h  = "SELECT ";
    $sql_h .= "     t_order_h.ord_id, ";                            // 発注ID
    $sql_h .= "     t_client.client_cd1, ";                         // 得意先コード1
    $sql_h .= "     t_client.client_cd2, ";                         // 得意先コード2
    $sql_h .= "     t_client.client_name, ";                        // 得意先名
    $sql_h .= "     t_client.client_name2, ";                       // 得意先名2
    $sql_h .= "     t_client.post_no1 AS client_post_no1, ";        // 得意先〒1
    $sql_h .= "     t_client.post_no2 AS client_post_no2, ";        // 得意先〒2
    $sql_h .= "     t_client.address1 AS client_address1, ";        // 得意先住所1
    $sql_h .= "     t_client.address2 AS client_address2, ";        // 得意先住所2
    $sql_h .= "     t_client.address3 AS client_address3, ";        // 得意先住所3
    $sql_h .= "     t_client.charger1 AS client_charger1, ";        // 得意先ご担当者名
    $sql_h .= "     t_direct.direct_name, ";                        // 直送先名
    $sql_h .= "     t_direct.direct_name2, ";                       // 直送先名2
    $sql_h .= "     t_direct.post_no1 AS direct_post_no1, ";        // 直送先〒1
    $sql_h .= "     t_direct.post_no2 AS direct_post_no2, ";        // 直送先〒2
    $sql_h .= "     t_direct.address1 AS direct_address1, ";        // 直送先住所1
    $sql_h .= "     t_direct.address2 AS direct_address2, ";        // 直送先住所2
    $sql_h .= "     t_direct.address3 AS direct_address3, ";        // 直送先住所3
    $sql_h .= "     t_trans.trans_name, ";                          // 運送業者名
    $sql_h .= "     t_ware.ware_name, ";                            // 入荷倉庫名
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // 担当者名
    $sql_h .= "     t_ord_staff.staff_name AS ord_staff_name, ";    // 発注者名
    $sql_h .= "     t_can_staff.staff_name AS can_staff_name, ";    // 取消者名
    $sql_h .= "     t_my_client.shop_name AS my_client_name, ";     // 自社名
    $sql_h .= "     t_my_client.shop_name2 AS my_client_name2 ";    // 自社名2
    $sql_h .= "FROM t_order_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_order_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_order_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_order_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_order_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_order_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ord_staff ON t_order_h.ord_staff_id = t_ord_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_can_staff ON t_order_h.ord_staff_id = t_can_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_client AS t_my_client ON t_order_h.shop_id = t_my_client.client_id ";
//    $sql_h .= "WHERE t_order_h.client_name IS NULL ";
    $sql_h .= ";";
    // 発注データ
    $sql_d  = "SELECT ";
    $sql_d .= "     t_order_d.ord_d_id, ";                          // 発注データID
    $sql_d .= "     t_goods.goods_cd, ";                            // 商品コード
    $sql_d .= "     t_goods.goods_cname, ";                         // 商品名略称
    $sql_d .= "     t_goods.in_num ";                               // 入数
    $sql_d .= "FROM t_order_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
//    $sql_d .= "WHERE t_order_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// 受注が選択された場合
if ($_POST["table"] == "t_aorder"){
    // 受注ヘッダ
    $sql_h  = "SELECT ";
    $sql_h .= "     t_aorder_h.aord_id, ";                          // 受注ID
    $sql_h .= "     t_client.client_cd1, ";                         // 得意先コード1
    $sql_h .= "     t_client.client_cd2, ";                         // 得意先コード2
    $sql_h .= "     t_client.client_name, ";                        // 得意先名
    $sql_h .= "     t_client.client_name2, ";                       // 得意先名2
    $sql_h .= "     t_client.client_cname, ";                       // 得意先名略称
    $sql_h .= "     t_direct.direct_name, ";                        // 直送先名
    $sql_h .= "     t_direct.direct_name2, ";                       // 直送先名2
    $sql_h .= "     t_trans.trans_name, ";                          // 運送業者名
    $sql_h .= "     t_ware.ware_name, ";                            // 出荷倉庫名
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // 担当者名
    $sql_h .= "     t_ord_staff.staff_name AS ord_staff_name, ";    // 入力者名
    $sql_h .= "     t_can_staff.staff_name AS cancel_user_name, ";  // 取消者名
    $sql_h .= "     t_chk_staff.staff_name AS check_user_name, ";   // チェック者名
    $sql_h .= "     t_rsn_staff.staff_name AS reason_user_name, ";  // 保留理由入力者名
    $sql_h .= "     t_intro_staff.staff_name AS intro_ac_name, ";   // 紹介者名
    $sql_h .= "     t_course.course_name ";                         // コース名
    $sql_h .= "FROM t_aorder_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_aorder_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_aorder_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_aorder_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ord_staff ON t_aorder_h.ord_staff_id = t_ord_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_can_staff ON t_aorder_h.can_staff_id = t_can_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_chk_staff ON t_aorder_h.check_staff_id = t_chk_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_rsn_staff ON t_aorder_h.reason_staff_id = t_rsn_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_intro_staff ON t_aorder_h.intro_account_id = t_intro_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_course ON t_aorder_h.course_id = t_course.course_id ";
//    $sql_h .= "WHERE t_aorder_h.client_name IS NULL ";
    $sql_h .= ";";
    // 受注データ
    $sql_d  = "SELECT ";
    $sql_d .= "     t_aorder_d.aord_d_id, ";                        // 受注データID
    $sql_d .= "     t_goods.goods_cd, ";                            // 商品コード
    $sql_d .= "     t_rgoods.goods_cd AS rgoods_cd, ";              // 本体商品コード
    $sql_d .= "     t_egoods.goods_cd AS egoods_cd, ";              // 消耗品コード
    $sql_d .= "     t_serv.serv_cd, ";                              // サービスコード
    $sql_d .= "     t_serv.serv_name ";                             // サービス名
    $sql_d .= "FROM t_aorder_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_egoods ON t_aorder_d.egoods_id = t_egoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_rgoods ON t_aorder_d.rgoods_id = t_rgoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_serv ON t_aorder_d.serv_id = t_serv.serv_id ";
//    $sql_d .= "WHERE t_aorder_d.goods_cd IS NULL ";
    $sql_s .= ";";
}

// 売上が選択された場合
if ($_POST["table"] == "t_sale"){
    // 売上ヘッダ
    $sql_h  = "SELECT ";
    $sql_h .= "     t_sale_h.sale_id, ";                            // 売上ID
    $sql_h .= "     t_client.client_cd1, ";                         // 得意先コード1
    $sql_h .= "     t_client.client_cd2, ";                         // 得意先コード2
    $sql_h .= "     t_client.client_name, ";                        // 得意先名
    $sql_h .= "     t_client.client_name2, ";                       // 得意先名2
    $sql_h .= "     t_client.post_no1 AS c_post_no1, ";             // 得意先〒1
    $sql_h .= "     t_client.post_no2 AS c_post_no2, ";             // 得意先〒2
    $sql_h .= "     t_client.address1 AS c_address1, ";             // 得意先住所1
    $sql_h .= "     t_client.address2 AS c_address2, ";             // 得意先住所2
    $sql_h .= "     t_client.address3 AS c_address3, ";             // 得意先住所3
    $sql_h .= "     t_client.shop_name AS c_shop_name, ";           // 得意先社名
    $sql_h .= "     t_client.shop_name2 AS c_shop_name2, ";         // 得意先社名2
    $sql_h .= "     t_direct.direct_cd, ";                          // 直送先コード
    $sql_h .= "     t_direct.direct_name, ";                        // 直送先名
    $sql_h .= "     t_direct.direct_name2, ";                       // 直送先名2
    $sql_h .= "     t_direct.direct_cname, ";                       // 直送先名略称
    $sql_h .= "     t_direct.post_no1 AS d_post_no1, ";             // 直送先〒1
    $sql_h .= "     t_direct.post_no2 AS d_post_no2, ";             // 直送先〒2
    $sql_h .= "     t_direct.address1 AS d_address1, ";             // 直送先住所1
    $sql_h .= "     t_direct.address2 AS d_address2, ";             // 直送先住所2
    $sql_h .= "     t_direct.address3 AS d_address3, ";             // 直送先住所3
    $sql_h .= "     t_direct.tel AS d_tel, ";                       // 直送先TEL
    $sql_h .= "     t_direct.fax AS d_fax, ";                       // 直送先FAX
    $sql_h .= "     t_trans.trans_name, ";                          // 運送業者名
    $sql_h .= "     t_trans.trans_cname, ";                         // 運送業者名略称
    $sql_h .= "     t_ware.ware_name, ";                            // 出荷倉庫名
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // 受注担当者名
    $sql_h .= "     t_e_staff.staff_name AS e_staff_name, ";        // 入力者名
    $sql_h .= "     t_ac_staff.staff_name AS ac_staff_name ";       // 売上担当者名
    $sql_h .= "FROM t_sale_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_sale_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_sale_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_sale_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_sale_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_e_staff ON t_sale_h.e_staff_id = t_e_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ac_staff ON t_sale_h.ac_staff_id = t_ac_staff.staff_id ";
//    $sql_h .= "WHERE t_sale_h.staff_name IS NULL ";
    $sql_h .= ";";
    // 売上データ
    $sql_d  = "SELECT ";
    $sql_d .= "     t_sale_d.sale_d_id, ";                          // 売上データID
    $sql_d .= "     t_goods.goods_cd, ";                            // 商品コード
    $sql_d .= "     t_rgoods.goods_cd AS rgoods_cd, ";              // 本体商品コード
    $sql_d .= "     t_serv.serv_name ";                             // サービス名
    $sql_d .= "FROM t_sale_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_rgoods ON t_sale_d.rgoods_id = t_rgoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_serv ON t_sale_d.serv_id = t_serv.serv_id ";
//    $sql_d .= "WHERE t_sale_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// ヘッダorデータの選択状況を元に、統一された変数($sql)へSQL文を代入
$sql = null;
$sql = ($_POST["type"] == "_h") ? $sql_h : $sql;
$sql = ($_POST["type"] == "_d") ? $sql_d : $sql;

// 実行ボタン押下＋SQLがある場合
if (isset($_POST["submit"]) && $sql != null){
    // データ取得
    $res = Db_Query($db_con, $sql);
    $numrows = pg_num_rows($res);
    for ($i=0; $i<$numrows; $i++){
        $ary_src_data[] = @pg_fetch_array($res, $i, PGSQL_ASSOC);
    }
}

/***************************************
    アップデート処理
***************************************/
// 取得データが1件以上あれば
if ($numrows > 0){

    // アップデート対象テーブル名
    $target_table = $_POST["table"].$_POST["type"];

    Db_Query($db_con, "BEGIN;");

    print "<b>アップデート対象件数： ".$numrows."件 (".$_POST["table"].$_POST["type"].")</b><hr>";

    // 取得した（アップデートする）行分ループ
    for ($i=0; $i<$numrows; $i++){

        // 配列の1番目はアップデート対象のプライマリキーなので取り除く
        $ary_update_data[$i] = $ary_src_data[$i];
        $primary_id[$i] = array_shift($ary_update_data[$i]);

        // アップデートSQL
        $sql  = "UPDATE $target_table SET ";
        $j = 0;
        while(list($key, $value) = each($ary_update_data[$i])){
            // 値が空の場合はNULLを入れる
            $sql .= ($value != "") ? " $key = '$value' " : " $key = NULL ";
            // まだアップデートしたいカラムがある場合はカンマを出力
            $sql .= ($j+1 != count($ary_update_data[$i])) ? ", " : null;
            $j++;
        }
        $sql .= "WHERE ".key($ary_src_data[$i])." = $primary_id[$i] ";
        $sql .= ";";
        print $sql."<br>";
        $res  = Db_Query($db_con, $sql);

        // 失敗したら全て無かったことに
        if($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }

    Db_Query($db_con, "COMMIT;");
    print "<hr>更新処理正常終了";

// 取得データが無い場合
}else{

    print "<b>アップデート対象なし(".$_POST["table"].$_POST["type"].")<b><hr>";

}

?>

<html>
<head></head>
<body>

<form name="form" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
<select name="table">
    <option value="t_buy">仕入
    <option value="t_order">発注
    <option value="t_aorder">受注
    <option value="t_sale">売上
</select>
<select name="type">
    <option value="_h">ヘッダテーブル
    <option value="_d">データテーブル
</select>
<input type="submit" name="submit" value="実 行">


</body>
</html>
