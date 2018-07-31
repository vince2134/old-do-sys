<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickForm作成
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

/****************************/
//Db接続
/****************************/

$db_name = "watanabe-k_demo2";

$db_con = Db_Connect($db_name);


print "<font color=\"red\">せつぞくDB：".$db_name."</font><br><br>";


/***************************/
//FCのデータ不良修正
/***************************/

print "<font color=\"red\">すべてOKであれば正常に処理が終了していることを示します。</font><br>";

Db_Query($db_con, "BEGIN");

//ボタン押下処理
if($_POST[set_button] == "データ修正開始"){

//-----------------------------------------------------------------------------------------------------------------------------
//■FCマスタにおいて、不足していたデータを登録しなおす。
//-----------------------------------------------------------------------------------------------------------------------------
//全FCのショップIDを抽出
$sql  = "SELECT\n";
$sql .= "   t_client.client_id \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_div = '3' \n";
$sql .= "ORDER BY client_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$fc_shop_id = pg_fetch_all($result);

//抽出したFCごとに
foreach($fc_shop_id AS $key => $val){

    //請求書フォーマット設定を行っいない得意先を抽出
    $c_sql  = "SELECT\n";
    $c_sql .= "   t_client.client_id \n";
    $c_sql .= "FROM\n";
    $c_sql .= "   t_client \n";
    $c_sql .= "WHERE\n";
    $c_sql .= "   t_client.client_div = '1'\n";
    $c_sql .= "   AND\n";
    $c_sql .= "   t_client.shop_id = ".$val[client_id]."";
    $c_sql .= "   AND\n";
    $c_sql .= "   c_pattern_id IS NULL\n";
    $c_sql .= ";";

    $result = Db_Query($db_con, $c_sql);
     $c_count  = pg_num_rows($result);

    //該当する得意先が存在する場合
    //得意先の請求書フォーマット設定をアップデート
    if($c_count > 0){
        $c_client_id = pg_fetch_all($result);

        foreach($c_client_id AS $c_key => $c_val){

            $sql  = "UPDATE";
            $sql .= "   t_client ";
            $sql .= "SET";
            $sql .= "   c_pattern_id = (SELECT c_pattern_id FROM t_claim_sheet WHERE shop_id = ".$val[client_id]."), "; //請求書フォーマット設定
            $sql .= "   claim_out = '1',\n";                                                                            //請求書発行
            $sql .= "   claim_send = '1' \n";                                                                           //請求書送付
            $sql .= "WHERE";
            $sql .= "   client_id = $c_val[client_id]";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
    }else{
        print "請求書：".$val[client_id]."　OK<br>";
    }

    //登録確認
    $result  = Db_Query($db_con, $c_sql);
    $aft_c_count = pg_num_rows($result);

    if($aft_c_count > 0){
        Db_Query($db_con, "ROLLBACK");
        print $val[client_id]."　NG";
        break;
    }elseif($aft_c_count == 0 && $c_count != $aft_c_count){
        print "請求書：".$val[client_id]."　OK<br>";
    }

    //売上伝票フォーマット設定を行っいないFCを抽出
    $s_sql  = "SELECT\n";
    $s_sql .= "   t_client.client_id \n";
    $s_sql .= "FROM\n";
    $s_sql .= "   t_client \n";
    $s_sql .= "WHERE\n";
    $s_sql .= "   t_client.client_div = '1'\n";
    $s_sql .= "   AND\n";
    $s_sql .= "   t_client.shop_id = ".$val[client_id]."";
    $s_sql .= "   AND\n";
    $s_sql .= "   s_pattern_id IS NULL\n";
    $s_sql .= ";";

    $result = Db_Query($db_con, $sql);
    $s_count = pg_num_rows($result);

    //該当する得意先が存在する場合
    //得意先の請求書フォーマット設定をアップデート
    if($s_count > 0){
        $s_client_id = pg_fetch_all($result);

        foreach($s_client_id AS $s_key => $s_val){
            $sql  = "UPDATE";
            $sql .= "   t_client ";
            $sql .= "SET";
            $sql .= "   s_pattern_id = (SELECT s_pattern_id FROM t_slip_sheet WHERE shop_id = ".$val[client_id]."), ";  //売上伝票フォーマット設定
            $sql .= "   slip_out = '2',\n";
            $sql .= "   deliver_effect = '2' \n";
            $sql .= "WHERE\n";
            $sql .= "   client_id = $s_val[client_id]";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
    }else{
        print "売上伝票：".$val[client_id]."　OK<br>";
    }

    //登録確認
    $result  = Db_Query($db_con, $s_sql);
    $aft_s_count = pg_num_rows($result);

    if($aft_s_count > 0){
        Db_Query($db_con, "ROLLBACK");
        print $val[client_id]."　NG";
        break;
    }elseif($aft_s_count == 0 && $s_count != $aft_s_count){
        print "売上伝票：".$val[client_id]."　OK<br>";
    }

    //現在登録されている代行用の得意先（東陽）のデータをアップデート
    $sql  = "UPDATE";
    $sql .= "   t_client ";
    $sql .= "SET ";
    $sql .= "   compellation = '1',";
    $sql .= "   bank_div = '1',";
    $sql .= "   client_cd1      = (SELECT client_cd1        FROM t_client WHERE client_id = 93),";
    $sql .= "   client_cd2      = (SELECT client_cd2        FROM t_client WHERE client_id = 93),";
    $sql .= "   client_name     = (SELECT client_name       FROM t_client WHERE client_id = 93),";
    $sql .= "   client_read     = (SELECT client_read       FROM t_client WHERE client_id = 93),";
    $sql .= "   client_name2    = (SELECT client_name2      FROM t_client WHERE client_id = 93),";
    $sql .= "   client_read2    = (SELECT client_read2      FROM t_client WHERE client_id = 93),";
    $sql .= "   client_cname    = (SELECT client_cname      FROM t_client WHERE client_id = 93),";
    $sql .= "   address1        = (SELECT address1          FROM t_client WHERE client_id = 93),";
    $sql .= "   address2        = (SELECT address2          FROM t_client WHERE client_id = 93),";
    $sql .= "   address3        = (SELECT address3          FROM t_client WHERE client_id = 93),";
    $sql .= "   address_read    = (SELECT address_read      FROM t_client WHERE client_id = 93),";
    $sql .= "   post_no1        = (SELECT post_no1          FROM t_client WHERE client_id = 93),";
    $sql .= "   post_no2        = (SELECT post_no2          FROM t_client WHERE client_id = 93),";
    $sql .= "   tel             = (SELECT tel               FROM t_client WHERE client_id = 93),";
    $sql .= "   fax             = (SELECT fax               FROM t_client WHERE client_id = 93),";
    $sql .= "   rep_name        = (SELECT rep_name          FROM t_client WHERE client_id = 93),";
    $sql .= "   represe         = (SELECT represe           FROM t_client WHERE client_id = 93),";
    $sql .= "   email           = (SELECT email             FROM t_client WHERE client_id = 93),";
    $sql .= "   slip_out        = '2',";
    $sql .= "   claim_out       = '1',";
    $sql .= "   claim_send      = '1',";
    $sql .= "   deliver_effect  = '2'";
    $sql .= "WHERE ";
    $sql .= "   shop_id = ".$val[client_id]."";
    $sql .= "   AND";
    $sql .= "   act_flg = 't'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_Con, "ROLBLACK;");
        exit;
    }

    Db_Query($db_con, "COMMIT");
    //Db_Query($db_con, "ROLLBACK;");
}


}
?>


<html>
<head>
    <title>FCデータ修正</title>
</head>
<body>
    <form action="./fc_data_update2.php" method="post">
        <input type="submit" name="set_button" value="データ修正開始">
    </form>
</body>
</html>
