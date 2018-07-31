<?php
$page_title = "グループ作成";
//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB接続
$db_con = Db_Connect();
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/***************************/
//グループマスタ用sql
/***************************/
if($_POST['insert_btn'] != ""){
    Db_Query($db_con,"BEGIN;");
    //請求先抽出用
    $sql = "SELECT ";
    $sql .= "   claim_id,";
    $sql .= "   t_client.shop_id ";
    $sql .= "FROM ";
    $sql .= "   t_claim ";
    $sql .= "   INNER JOIN t_client ON t_client.client_id = t_claim.claim_id ";
    $sql .= "WHERE ";
    $sql .= "   claim_div = '1' ";
    $sql .= "   AND t_client.shop_id != 1 ";
    $sql .= "GROUP BY ";
    $sql .= "   claim_id,t_client.shop_id,client_cd1,client_cd2 ";
    $sql .= "HAVING ";
    $sql .= "   count(*) > 1";
    $sql .= "ORDER BY  client_cd1,client_cd2";
    $sql .= ";";
    
    $res = Db_Query($db_con,$sql);
    
    $c_data = pg_fetch_all($res);
    //print count($c_data);
    //print_array($c_data);
    
    for($i = 0;$i<count($c_data);$i++){
        $shop_id = $c_data[$i]['shop_id'];
        $claim_id = $c_data[$i]['claim_id'];
    
        $insert_sql = "INSERT INTO ";
        $insert_sql .= "    t_client_gr ";
        $insert_sql .= "    (client_gr_id,client_gr_cd,client_gr_name,note,shop_id,claim_id) ";
        $insert_sql .= "VALUES(";
        $insert_sql .= " (SELECT COALESCE(MAX(client_gr_id), 0)+1 FROM t_client_gr),";
        $insert_sql .= " (SELECT lpad(COALESCE(to_number(MAX(client_gr_cd),'000'), 0)+1,3,'0') FROM t_client_gr where shop_id = $shop_id),";
        $insert_sql .= " (SELECT client_name from t_client where client_id = $claim_id ),";
        $insert_sql .= " '',";
        $insert_sql .= "     $shop_id,";
        $insert_sql .= "    $claim_id ";
        $insert_sql .= ");";
    
        $res = Db_Query($db_con,$insert_sql);
        if($res === false){
            Db_Query($db_con,"ROLLBACK;");
            print $insert_sql;
            print "エラー";
            exit;
        }
    }

    Db_Query($db_con,"COMMIT;");
    print "INSERT完了";
}
if($_POST['select_btn'] != ""){
    Db_Query($db_con,"BEGIN;");

    //請求先と請求元のデータ抽出？
    $sql = "SELECT ";
    $sql .= "   t_claim.claim_id,";
    $sql .= "    m_claim.client_name,";
    $sql .= "    t_claim.client_id,";
    $sql .= "    t_client.client_name ";
    $sql .= "FROM ";
    $sql .= "    (SELECT ";
    $sql .= "        claim_id,";
    $sql .= "        t_client.client_name";
    $sql .= "    FROM ";
    $sql .= "        t_claim ";
    $sql .= "            INNER JOIN ";
    $sql .= "        t_client ";
    $sql .= "        ON t_client.client_id = t_claim.claim_id ";
    $sql .= "    WHERE claim_div = '1' ";
    $sql .= "    GROUP BY claim_id,";
    $sql .= "            client_name ";
    $sql .= "    HAVING count(*) > 1 ";
    $sql .= "    ) as m_claim ";
    $sql .= "        INNER JOIN ";
    $sql .= "    t_claim ";
    $sql .= "    ON m_claim.claim_id = t_claim.claim_id ";
    $sql .= "        INNER JOIN ";
    $sql .= "    t_client ";
    $sql .= "    ON t_claim.client_id = t_client.client_id ";
    $sql .= "WHERE";
    $sql .= "    t_claim.claim_div = '1' ";
    $sql .= "    AND t_client.shop_id != 1 ";
    $sql .= "ORDER BY claim_id,client_id;";
    $res = Db_Query($db_con,$sql);
    $data = pg_fetch_all($res);
    $d_count = pg_num_rows($res);
//    print_array($data[0]);
//    exit;
    for($i=0;$i<$d_count;$i++){
//    for($i=0;$i<1;$i++){
        if($data[$i]['claim_id'] == $data[$i]['client_id']){
            $parents_flg = 't';
        }else{
            $parents_flg = 'f';
        }
        $up_sql = "UPDATE ";
        $up_sql .= "    t_client ";
        $up_sql .= "SET ";
        $up_sql .= "    client_gr_id = (SELECT client_gr_id from t_client_gr where claim_id = ".$data[$i]['claim_id'].") ,";
        $up_sql .= "    parents_flg = '$parents_flg' ";
        $up_sql .= "WHERE ";
        $up_sql .= "    client_id = ".$data[$i]['client_id']." ";
        $up_sql .= ";";
        $res = Db_Query($db_con,$up_sql);
        if($res === false){
            Db_Query($db_con,"ROLLBACK;");
            print "エラー";
            exit;
        }
    }


    Db_Query($db_con,"COMMIT;");
    print "<br>UPDATE完了";
}
?>
<html><head><title>グループ作る用</title></head><body>
<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">

<BR><BR>
<input type="submit" value="インサート実行" name="insert_btn">
<BR><BR>
<input type="submit" value="アップデート実行" name="select_btn">
<BR><BR>
<input type="button" value="りせっとー" name="clear" onclick="javascript:location.href('<?php print($_SERVER['PHP_SELF']) ?>')">


</form>
</body></html>


