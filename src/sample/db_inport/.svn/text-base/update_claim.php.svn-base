<?php

//請求先にnullが指定されいるものを自社を請求先として登録し直すスクリプト

require_once("ENV_local.php");
$conn = Db_Connect();

Db_Query($conn, "BEGIN");

//得意先＝請求先のリストを８００件抽出

$sql  = "SELECT";
$sql .= "   t_client.client_id";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       client_id";
$sql .= "   FROM";
$sql .= "       t_client";
$sql .= "   WHERE";
$sql .= "       shop_gid = 43";
$sql .= "       AND";
$sql .= "       client_div = '1'";
$sql .= "       AND";
$sql .= "       state = '1'";
$sql .= "   ) AS t_client";
$sql .= "       INNER JOIN";
$sql .= "   (SELECT";
$sql .= "       client_id";
$sql .= "   FROM";
$sql .= "       t_client_info";
$sql .= "   WHERE";
$sql .= "       client_id = claim_id";
$sql .= "   ) AS t_client_info";
$sql .= "   ON t_client.client_id = t_client_info.client_id";
$sql .= " LIMIT 800";
$sql .= ";";

$result = Db_Query($conn,$sql);
for($i = 1; $i <= 800; $i++){
    $client_id[$i] = pg_fetch_result($result, $i-1, 0);
}

//請求先の親子関係を400件作成
for($i = 1; $i <= 800; $i = $i+2){
    $sql  = "UPDATE t_client_info SET";
    $sql .= "   claim_id = ".$client_id[$i+1]."";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id[$i]";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }else{
        print $sql ."<br>";
    }
}

Db_Query($conn, "COMMIT");

?>
