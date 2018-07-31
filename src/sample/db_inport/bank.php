<?php
/*
    ������ޥ����ο�����Ԥ�text���Ϥ��ѹ����뤳�Ȥˤ�ꡢ���ߤζ��ID����̾�ˤ��������륹����ץ�
    ��2006/04/26��
*/


/*
amenity=# SELECT COUNT(client_id) FROM t_client WHERE client_div = '2';
 count 
-------
   305
(1 row)

amenity=# SELECT COUNT(client_id) FROM t_client WHERE client_div = '2' AND bank_id IS NOT NULL;
 count 
-------
     8
(1 row)

SELECT client_cd1 FROM t_client WHERE client_div = '2' AND bank_id IS NOT NULL;
 client_cd1 
------------
 123456
 165165
 005003
 111111
 000009
 745331
 787978
 654165
(8 rows)
*/

require_once("ENV_local.php");
$conn = Db_Connect();

//���������Ͽ����Ƥ�����Ԥ����
$sql  = "SELECT";
$sql .= "   t_client.client_id,";
$sql .= "   t_bank.bank_name";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= "       INNER JOIN";
$sql .= "   t_bank";
$sql .= "       ON t_client.bank_id = t_bank.bank_id";
$sql .= " WHERE";
$sql .= "   t_client.client_div = '2'";
$sql .= ";";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);

for($i = 0; $i < $data_num; $i++){
    $data[]   = pg_fetch_array($result, $i , PGSQL_NUM);
}

Db_Query($conn, "BEGIN");

//�嵭����Ф������̾����Ͽ
for($i = 0; $i < $data_num; $i++){
    $sql  = "UPDATE t_client SET";
    $sql .= "   bank_name = '".$data[$i][1]."'";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$data[$i][0]."";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }
}

Db_Query($conn, "COMMIT");

?>
