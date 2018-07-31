<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickForm作成
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

/****************************/
//Db接続
/****************************/

$db_name = "amenity_watanabe";

$db_con = Db_Connect('db_name');


print "<font color=\"red\">せつぞくDB：".$db_name."</font><br><br>";


/***************************/
//FCのデータ不良修正
/***************************/

print "<font color=\"red\">表示されている数字がすべて０であれば正常に処理が終了していることを示します。</font>";

Db_Query($db_con, "BEGIN");

//ボタン押下処理
if($_POST[set_button] == "データ修正開始"){

//-----------------------------------------------------------------------------------------------------------------------------
//■請求書フォーマット設定を行っていないFCを抽出
//-----------------------------------------------------------------------------------------------------------------------------
$sql  = "SELECT\n";
$sql .= "   t_client.client_id \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "       LEFT JOIN\n";
$sql .= "   t_claim_sheet\n";
$sql .= "   ON t_client.client_id = t_claim_sheet.shop_id\n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_div = '3'\n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= "   AND\n";
$sql .= "   t_claim_sheet.shop_id IS NULL\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);

$max = pg_num_rows($result);

//print_array(pg_fetch_all($result), "請求書フォーマット設定をしていないリスト");
$claim_client_id = pg_fetch_all($result);

for($i = 0; $i < $max; $i++){
    $sql  = "INSERT INTO t_claim_sheet(\n";
    $sql .= "   c_pattern_id,\n";
    $sql .= "   c_pattern_name,\n";
    $sql .= "   c_memo1,\n";
    $sql .= "   c_memo2,\n";
    $sql .= "   c_memo3,\n";
    $sql .= "   c_memo4,\n";
    $sql .= "   c_memo5,\n";
    $sql .= "   c_memo6,\n";
    $sql .= "   c_memo7,\n";
    $sql .= "   c_memo8,\n";
    $sql .= "   c_memo9,\n";
    $sql .= "   c_memo10,\n";
    $sql .= "   c_memo11,\n";
    $sql .= "   c_memo12,\n";
    $sql .= "   c_memo13,\n";
    $sql .= "   c_fsize1,\n";
    $sql .= "   c_fsize2,\n";
    $sql .= "   c_fsize3,\n";
    $sql .= "   c_fsize4,\n";
    $sql .= "   shop_id\n";
    $sql .= ")VALUES(\n";
    $sql .= "   (SELECT COALESCE(MAX(c_pattern_id),0)+1 FROM t_claim_sheet),\n";
    $sql .= "   (SELECT shop_name FROM t_client WHERE client_id = ".$claim_client_id[$i][client_id]."),\n";
    $sql .= "   '株式会社　ア メ ニ テ ィ',\n";
    $sql .= "   '代表取締役　山　戸　里　志',\n";
    $sql .= "   '〒221-0863 横 浜 市 神 奈 川区 羽 沢 町 685',\n";
    $sql .= "   'ＴＥＬ  045-371-7676   ＦＡＸ  045-371-7717',\n";
    $sql .= "   'みずほ銀行　横浜西口支店　　　　　当座預金　*******',\n";
    $sql .= "   'みずほ銀行　横浜駅前支店　　　　　当座預金　*******',\n";
    $sql .= "   '東京三菱銀行　新横浜支店　　　　　当座預金　*******',\n";
    $sql .= "   '横浜銀行　西谷支店　　　　　 　　 当座預金　*******',\n";
    $sql .= "   '商工中金　横浜西口支店　　 　 　　当座預金　*******',\n";
    $sql .= "   '横浜信用金庫　西谷支店　　　　　  当座預金　*******',\n";
    $sql .= "   '西日本シティ銀行　本店　営業部　　当座預金　*******',\n";
    $sql .= "   '',\n";
    $sql .= "   '※　振り込み手数料は誠に申し訳ございませんが、貴社にて御負担下さるようお願い致します。',\n";
    $sql .= "   '12',\n";
    $sql .= "   '9',\n";
    $sql .= "   '6',\n";
    $sql .= "   '6',\n";
    $sql .= "   ".$claim_client_id[$i][client_id]."\n";
    $sql .= ");\n"; 

    $result = Db_Query($db_con, $sql);
    if($result === false){ 
        Db_Query($db_con, "ROLLBACK;");
        exit;   
    }

    //登録した請求書IDを抽出
    $sql  = "SELECT\n";
    $sql .= "   MAX(c_pattern_id) AS c_pattern_id \n";
    $sql .= "FROM\n";
    $sql .= "   t_claim_sheet \n";
    $sql .= "WHERE\n";
    $sql .= "   shop_id = ".$claim_client_id[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $c_pattern_id = pg_fetch_result($result, 0,0);

    //請求書フォーマット設定をしていなかったFCの得意先に対し、
    //請求書フォーマットIDを登録する
    $sql  = "UPDATE";
    $sql .= "   t_client \n";
    $sql .= "SET\n";
    $sql .= "   c_pattern_id = ".$c_pattern_id."\n";
    $sql .= "WHERE\n";
    $sql .= "   shop_id = ".$claim_client_id[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    } 
}

/***************************************/
//登録確認
/***************************************/
$sql  = "SELECT\n";
$sql .= "   COUNT(t_client.client_id) \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "       LEFT JOIN\n";
$sql .= "   t_claim_sheet\n";
$sql .= "   ON t_client.client_id = t_claim_sheet.shop_id\n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_div = '3'\n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= "   AND\n";
$sql .= "   t_claim_sheet.shop_id IS NULL\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$count  = pg_fetch_result($result,0,0);

print "<br>".$count."<br>";

//-----------------------------------------------------------------------------------------------------------------------------
//■売上伝票フォーマット設定を行っていないFCを抽出
//-----------------------------------------------------------------------------------------------------------------------------

$sql  = "SELECT\n";
$sql .= "   t_client.client_id \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "       LEFT JOIN\n";
$sql .= "   t_slip_sheet\n";
$sql .= "   ON t_client.client_id = t_slip_sheet.shop_id\n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_div = '3'\n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= "   AND\n";
$sql .="    t_slip_sheet.shop_id IS NULL\n";

$result = Db_Query($db_con, $sql);

$max = pg_num_rows($result);

$slip_client_id = pg_fetch_all($result);
//print_array(pg_fetch_all($result), "売上伝票フォーマット設定をしていないリスト");

for($i = 0; $i < $max; $i++){
    //売上伝票フォーマット設定
    $sql  = "INSERT INTO t_slip_sheet(\n";
    $sql .= "   s_pattern_id,\n";
    $sql .= "   s_pattern_name,\n";
    $sql .= "   s_memo1,\n";
    $sql .= "   s_memo2,\n";
    $sql .= "   s_memo3,\n";
    $sql .= "   s_memo4,\n";
    $sql .= "   s_memo5,\n";
    $sql .= "   s_memo6,\n";
    $sql .= "   s_memo7,\n";
    $sql .= "   s_memo8,\n";
    $sql .= "   s_memo9,\n";
    $sql .= "   s_fsize1,\n";
    $sql .= "   s_fsize2,\n";
    $sql .= "   s_fsize3,\n";
    $sql .= "   s_fsize4,\n";
    $sql .= "   s_fsize5,\n";
    $sql .= "   shop_id\n";
    $sql .= ")VALUES(\n";
    $sql .= "   (SELECT COALESCE(MAX(s_pattern_id),0)+1 FROM t_slip_sheet),\n";
    $sql .= "   (SELECT shop_name FROM t_client WHERE client_id = ".$slip_client_id[$i][client_id]."),\n";
    $sql .= "   '株式会社アメニティ',\n";
    $sql .= "   '',\n";
    $sql .= "   '代表取締役',\n";
    $sql .= "   '山戸里志',\n";
    $sql .= "   '〒221-0863　横浜市神奈川区羽沢町６８５
ＴＦＬ045-371-7676　ＦＡＸ045-371-7717 ',";
    $sql .= "   '',\n";
    $sql .= "   '取引銀行　　みずほ銀行　横浜西口支店　　　　　当座預金　*******
　　　　　　みずほ銀行　横浜駅前支店　　　　　当座預金　*******
　　　　　　東京三菱銀行　新横浜支店　　　　　当座預金　*******
　　　　　　横浜銀行　西谷支店　　　　　 　　 当座預金　******
　　　　　　商工中金　横浜西口支店　　 　 　　当座預金　*******
　　　　　　横浜信用金庫　西谷支店　　　　　  当座預金　******
　　　　　　西日本シティ銀行　本店　営業部　　当座預金　*******',\n";
    $sql .= "   '',\n";
    $sql .= "   '',\n";
    $sql .= "   '10',\n";
    $sql .= "   '10',\n";
    $sql .= "   '8',\n";
    $sql .= "   '10',\n";
    $sql .= "   '6',\n";
    $sql .= "   ".$slip_client_id[$i][client_id]."\n";
    $sql .= ");\n";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    //登録した売上伝票IDを抽出
    $sql  = "SELECT\n";
    $sql .= "   MAX(s_pattern_id) AS s_pattern_id\n ";
    $sql .= "FROM\n";
    $sql .= "   t_slip_sheet\n ";
    $sql .= "WHERE\n";
    $sql .= "   shop_id = ".$slip_client_id[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $s_pattern_id = pg_fetch_result($result, 0,0);
}

/***************************************/
//登録確認
/***************************************/
$sql  = "SELECT\n";
$sql .= "   COUNT(t_client.client_id) \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "       LEFT JOIN\n";
$sql .= "   t_slip_sheet\n";
$sql .= "   ON t_client.client_id = t_slip_sheet.shop_id\n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_div = '3'\n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= "   AND\n";
$sql .= "   t_slip_sheet.shop_id IS NULL\n";
$sql .= ";";

$result = Db_Query($db_con,$sql);
$count  = pg_fetch_result($result, 0,0);

print "<br>".$count."<br>";

//-----------------------------------------------------------------------------------------------------------------------------
//■基本出荷倉庫を登録していないFCを抽出
//-----------------------------------------------------------------------------------------------------------------------------
$sql  = "SELECT";
$sql .= "   t_client.client_id \n";
$sql .= "FROM\n";
$sql .= "   t_client\n";
$sql .= "WHERE\n";
$sql .= "   ware_id IS NULL\n";
$sql .= "   AND\n";
$sql .= "   client_div = '3' \n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);

$max = pg_num_rows($result);

//print_array(pg_fetch_all($result), "基本出荷倉庫を設定していないリスト");
$ware_client_id = pg_fetch_all($result);

//基本出荷倉庫を登録していないFCでマスタに倉庫の登録をしていないものを抽出
for($i = 0; $i < $max; $i++){
    $sql  = "SELECT\n";
    $sql .= "   COUNT(*)\n";
    $sql .= "FROM\n";
    $sql .= "   t_ware\n";
    $sql .= "WHERE\n";
    $sql .= "   shop_id = ".$ware_client_id[$i][client_id]." \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $ware_count = pg_fetch_result($result, 0,0);    

    //倉庫を登録していない場合は登録する。
    if($ware_count == 0){
        $sql  = "INSERT INTO t_ware(";
        $sql .= "   ware_id,\n";
        $sql .= "   ware_cd,\n";
        $sql .= "   ware_name,\n";
        $sql .= "   own_shop_id,\n";
        $sql .= "   shop_id\n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(ware_id),0)+1 FROM t_ware),";
        $sql .= "   '001',\n";
        $sql .= "   '初期倉庫',\n";
        $sql .= "   ".$ware_client_id[$i][client_id].", \n";
        $sql .= "   ".$ware_client_id[$i][client_id]." \n";
        $sql .= ");\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        $sql  = "SELECT\n";
        $sql .= "   ware_id \n";
        $sql .= "FROM\n";
        $sql .= "   t_ware \n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = ".$ware_client_id[$i][client_id]."\n";
        $sql .= "   AND\n";
        $sql .= "   ware_cd = '001'\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $ware_id = pg_fetch_result($result, 0,0);

    //登録している場合はテキトーな倉庫を抽出
    }else{
        $sql  = "SELECT \n";
        $sql .= "   ware_id\n";
        $sql .= "FROM\n";
        $sql .= "   t_ware\n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = ".$ware_client_id[$i][client_id]."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $ware_id = pg_fetch_result($result ,0,0);
    }

//    取引先マスタに倉庫を登録
    $sql  = "UPDATE";
    $sql .= "   t_client \n";
    $sql .= "SET\n";
    $sql .= "   ware_id = $ware_id\n";
    $sql .= "WHERE\n";
    $sql .= "   client_id = ".$ware_client_id[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
}

/***************************************/
//登録確認
/***************************************/
$sql  = "SELECT";
$sql .= "   COUNT(t_client.client_id) \n";
$sql .= "FROM\n";
$sql .= "   t_client\n";
$sql .= "WHERE\n";
$sql .= "   ware_id IS NULL\n";
$sql .= "   AND\n";
$sql .= "   client_div = '3' \n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003' \n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);
$count  = pg_fetch_result($result, 0,0);

print "<br>".$count."<br>";

//-----------------------------------------------------------------------------------------------------------------------------
//■自社プロフィールにおいて下記の項目で登録がないものに関しては、FC登録時の情報を登録
//■FCマスタでは登録しないが、自社プロフィールでは必要なデータを登録
//-----------------------------------------------------------------------------------------------------------------------------
//    自社端数区分
//    自社まるめ区分
//    自社支払日(月)
//    自社支払日(日)
//    締日
$sql  = "UPDATE";
$sql .= "   t_client \n";
$sql .= "SET";
$sql .= "   my_coax         = t_fc_client.coax,";
$sql .= "   my_tax_franct   = t_fc_client.tax_franct,\n";
$sql .= "   my_pay_m        = t_fc_client.pay_m,\n";
$sql .= "   my_pay_d        = t_fc_client.pay_d,\n";
$sql .= "   my_close_day    = t_fc_client.close_day, \n";
$sql .= "   claim_set       = '1',";
$sql .= "   cal_peri        = '1' ";
$sql .= "FROM\n";
$sql .= "   (SELECT\n";
$sql .= "       t_client.client_id,\n";
$sql .= "       t_client.coax,\n";
$sql .= "       t_client.tax_franct,\n";
$sql .= "       t_client.pay_m,\n";
$sql .= "       t_client.pay_d,\n";
$sql .= "       t_client.close_day\n";
$sql .= "   FROM\n";
$sql .= "       t_client\n";
$sql .= "   WHERE\n";
$sql .= "       client_div = '3'\n";
$sql .= "       AND\n";
$sql .= "       rank_cd <> '0003'\n";
$sql .= "       AND\n";
$sql .= "       (";
$sql .= "       my_coax IS NULL\n";
$sql .= "       OR\n";
$sql .= "       my_tax_franct IS NULL\n";
$sql .= "       OR\n";
$sql .= "       my_pay_m IS NULL\n";
$sql .= "       OR\n";
$sql .= "       my_pay_d IS NULL\n";
$sql .= "       OR\n";
$sql .= "       my_close_day IS NULL\n";
$sql .= "       )";
$sql .= "   ) AS t_fc_client ";
$sql .= "WHERE\n";
$sql .= "   t_client.client_id = t_fc_client.client_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if($result === false){
    Db_Query($db_con, "ROLLBACK;");
    exit;
}

/**********************************/
//登録確認
/**********************************/
$sql  = "SELECT\n";
$sql .= "   COUNT(client_id) \n";
/*
$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
$sql .= "   t_client.pay_m,\n";
$sql .= "   t_client.pay_d,\n";
$sql .= "   t_client.my_pay_m,\n";
$sql .= "   t_client.my_pay_d,\n";
$sql .= "   t_client.close_day,\n";
$sql .= "   t_client.my_close_day,\n";
$sql .= "   t_client.coax,\n";
$sql .= "   t_client.my_coax,\n";
$sql .= "   t_client.tax_franct,\n";
$sql .= "   t_client.my_tax_franct,\n";
$sql .= "   t_client.claim_set,\n";
$sql .= "   t_client.cal_peri \n";
*/
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";
$sql .= "   client_div = '3'\n";
$sql .= "   AND\n";
$sql .= "   rank_cd <> '0003'\n";
$sql .= "   AND\n";
$sql .= "   (";
$sql .= "   my_coax IS NULL\n";
$sql .= "   OR\n";
$sql .= "   my_tax_franct IS NULL\n";
$sql .= "   OR\n";
$sql .= "   my_pay_m IS NULL\n";
$sql .= "   OR\n";
$sql .= "   my_pay_d IS NULL\n";
$sql .= "   OR\n";
$sql .= "   my_close_day IS NULL\n";
$sql .= "   ) \n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$count  = pg_fetch_result($result , 0,0);

print "<br>".$count."<br>";

//----------------------------------------------------------------------------------------------------------------------
//地区を登録
//----------------------------------------------------------------------------------------------------------------------
$sql  = "SELECT\n";
$sql .= "   t_client.client_id, \n";
$sql .= "   t_client.shop_id \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";
//$sql .= "   area_id IS NULL\n";
//$sql .= "   AND\n";
$sql .= "   act_flg = 't'\n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);
$max = pg_num_rows($result);
$area_client_id = pg_fetch_all($result);

//地区IDを登録していなかった得意先東陽に対して地区を登録
for($i = 0; $i < $max; $i++){

    $sql  = "UPDATE\n";
    $sql .= "   t_client \n";
    $sql .= "SET\n";
    $sql .= "   area_id = (SELECT area_id FROM t_area WHERE area_cd = '0001' AND shop_id = ".$area_client_id[$i][shop_id].") ";
    $sql .= "WHERE\n";
    $sql .= "   client_id = ".$area_client_id[$i][client_id]." ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
}   

$sql  = "SELECT\n";
$sql .= "   COUNT(client_id) \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";
$sql .= "   area_id IS NULL \n";
$sql .= "   AND\n";
$sql .= "   act_flg = 't'\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$count  = pg_fetch_result($result , 0,0);

print "<br>".$count."<br>";

//----------------------------------------------------------------------------------------------------------------------
Db_Query($db_con, "COMMIT;");

}
?>

<html>
<head>
    <title>FCデータ修正</title>
</head>
<body>
    <form action="./fc_data_update.php" method="post">
        <input type="submit" name="set_button" value="データ修正開始">
    </form>
</body>
</html>















