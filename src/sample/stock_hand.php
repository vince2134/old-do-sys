<?php

//ȯ����Ǿä��������ְ�äƤ������ᡢ�ǡ�������

require_once("ENV_local.php");

$conn = Db_Connect();


if($_POST["submit"] == "�¹�"){

    Db_Query($conn, "BEGIN;");

    //ȯ����Ф��ƣ�
    $sql  = "SELECT\n";
    //$sql .= "   count(buy_d_id),\n";
    $sql .= "   buy_d_id\n";
    $sql .= " FROM\n";
    $sql .= "   t_stock_hand\n";
    $sql .= " GROUP BY buy_d_id\n";
    $sql .= " HAVING count(buy_d_id) = 2\n";
    $sql .= ";";

    $res = Db_Query($conn, $sql);
    $data_num = pg_num_rows($res);

    //�������롼��
    for($i = 0; $i < $data_num; $i++){
        $buy_d_id = pg_fetch_result($res, $i, 0);   //�����ǡ���ID

        //ȯ��Ĥ��Ǥ��ä����̤�������ǥ��åץǡ���
        $sql  = "UPDATE\n";
        $sql .= "   t_stock_hand \n";
        $sql .= "SET\n";
        $sql .= "   num = (\n";
        $sql .= "           SELECT\n";
        $sql .= "               num\n";
        $sql .= "           FROM\n";
        $sql .= "               t_stock_hand\n";
        $sql .= "           WHERE\n";
        $sql .= "               work_div = '4'\n";
        $sql .= "               AND\n";
        $sql .= "               buy_d_id = $buy_d_id\n";
        $sql .= "         )\n";
        $sql .= " WHERE\n";
        $sql .= "   work_div = '3'\n";
        $sql .= "   AND\n";
        $sql .= "   buy_d_id = $buy_d_id\n";
        $sql .= ";\n";

        $result = Db_Query($conn, $sql);

        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }else{
            print_array($sql); 
        }
    }
    Db_Query($conn, "COMMIT;");
}


?>
<html>
<head>
<title></title>
</head>
<body>

<form action="./stock_hand.php" method="post">
    <input type="submit" value="�¹�" name="submit">
</form>

</body>
</html>
