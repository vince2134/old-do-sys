<?php

require_once("ENV_local.php");
$conn = Db_Connect();

//������ʬ�����ܼҤ˻��ꤵ��Ƥ���FC�ξ�������
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

//�ܼҤ˻��ꤵ��Ƥ���FC�Υ���å�̾�򥰥롼��̾�Ȥ�����Ͽ
Db_Query($conn, "BEGIN");

for($i = 0; $i < $data_num; $i++){
    $sql  = "UPDATE t_shop_gr SET";
    $sql .= "   shop_gname = '".trim($data[$i][1])."���롼��'";
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
