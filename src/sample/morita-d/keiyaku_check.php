<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();
$sql = "SELECT COUNT(contract_id) FROM t_contract;";
$result = Db_Query($db_con, $sql);




?>
