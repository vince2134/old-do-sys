<?php

//�������null�����ꤵ�줤���Τ򼫼Ҥ�������Ȥ�����Ͽ��ľ��������ץ�

require_once("ENV_local.php");
$conn = Db_Connect();

Db_Query($conn, "BEGIN");

//�����褬null�Ȥ�����Ͽ����Ƥ�������������
$sql  = "SELECT";
$sql .= "   client_id";
$sql .= " FROM";
$sql .= "   t_client_info";
$sql .= " WHERE";
$sql .= "   claim_id IS NULL";
$sql .= ";";

$result = Db_Query($conn, $sql); 
$data_num = pg_num_rows($result);
for($i = 0; $i < $data_num; $i++){
    $client_id[] = pg_fetch_result($result, $i, 0);
}

//������˼�ʬ����ꤷ����Ͽ
for($i = 0; $i < $data_num; $i++){
    $sql  = "UPDATE t_client_info";
    $sql .= "   SET";
    $sql .= "   claim_id = $client_id[$i]";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id[$i]";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }
}

Db_Query($conn, "COMMIT");

?>
