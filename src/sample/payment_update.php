<?php
/*****************************/
//  
// ���ߺ�������Ƥ�������ǡ����ǡ��������������ޤǤ˲��ͽ������������λ�ʧͽ��ۤ���
//(2006/10/24)<watanabe-k>
//
//
/*****************************/

require_once("ENV_local.php");

$db_con = Db_Connect();


if($_POST[submit] == "START"){

    //�ѹ��оݤȤʤ�ǡ��������
    $sql  = "SELECT\n";
    $sql .= "   t_bill.bill_id,\n";
    $sql .= "   t_bill.collect_day,\n";
    $sql .= "   t_bill_d.payment_extraction_e \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_bill_d\n";
    $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_bill.collect_day < t_bill_d.payment_extraction_e \n";
    $sql .= "   AND\n";
    $sql .= "   t_bill_d.close_day IS NOT NULL \n";
    $sql .= "   AND\n";
    $sql .= "   t_bill.first_set_flg = 'f'\n";
    $sql .= "GROUP BY\n";
    $sql .= "   t_bill.bill_id,\n";
    $sql .= "   t_bill.collect_day,\n";
    $sql .= "   t_bill_d.payment_extraction_e \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_bill.bill_id\n";
    $sql .= ";";

    print_array($sql); 
}


?>

<html>
    <head>
        <title>�����ʧ�۽���</title>
    </head>
<body>

<form action="./payment_update.php" method="POST">
    <input type="submit" value="START" name="submit">
</form>

</body>
</html>







