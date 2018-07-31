<?php

require_once("ENV_local.php");
$conn = Db_Connect();

//取引先区分から本社に指定されているFCの情報を抽出
$sql  = "SELECT";
$sql .= "   attach_gid,";
$sql .= "   shop_name";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_div = '3'";
$sql .= "   AND";
$sql .= "   shop_div = '1'";
$sql .= ";";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);

for($i = 0; $i < $data_num; $i++){
    $data[]   = pg_fetch_array($result, $i , PGSQL_NUM);
}

//本社に指定されているFCのショップ名をグループ名として登録
Db_Query($conn, "BEGIN");

for($i = 0; $i < $data_num; $i++){
    $sql  = "UPDATE t_shop_gr SET";
    $sql .= "   shop_gname = '".trim($data[$i][1])."グループ'";
    $sql .= " WHERE";
    $sql .= "   shop_gid = ".$data[$i][0]."";
    $sql .= ";";

    $resutl = Db_Query($conn, $sql);
    if($result === false){
print $sql ."<br>";
        Db_Query($conn, "ROLLBACK");
        exit;
    }

}
Db_Query($conn, "COMMIT");

?>
