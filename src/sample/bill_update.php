<?php
/*****************************/
//  
//  
//
//
//
/*****************************/

require_once("ENV_local.php");

$db_con = Db_Connect();


if($_POST[submit] == "START"){



//�����褴�Ȥ���ݻĹ�ۤ����

$sql  = "SELECT";
$sql .= "   t_client.client_id,\n";     //������ID 
$sql .= "   claim_id,\n";               //������ID
$sql .= "   ar_balance \n";            //��ݻĹ�
$sql .= "FROM\n";
$sql .= "   t_first_ar_balance \n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_client\n";
$sql .= "   ON t_first_ar_balance.client_id = t_client.client_id \n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_claim\n";
$sql .= "   ON t_client.client_id = t_claim.client_id \n";
$sql .= "WHERE\n";
//$sql .= "   t_client.shop_id IN (SELECT client_id FROM t_client WHERE rank_cd = '0003')\n";
$sql .= "   t_client.shop_id = 93\n";
$sql .= "   AND\n";
$sql .= "   t_claim.claim_div = 1\n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);

$data = pg_fetch_all($result);

//������ơ��֥����Ͽ
for($i = 0; $i < count($data); $i++){

    //���˥쥳���ɤ����뤫̵�������ǧ
    $sql  = "SELECT\n";    
    $sql .= "   t_bill_d.bill_d_id \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_bill_d\n";
    $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_bill.first_set_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_bill.shop_id = 93\n";
    $sql .= "   AND\n";
    $sql .= "   t_bill_d.client_id = ".$data[$i][client_id]."\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $add_count = pg_num_rows($result);

    //����¸�ߤ�����
    if($add_count > 0){

        $bill_d_id = pg_fetch_result($result, 0,0);

        $sql  = "UPDATE\n ";
        $sql .= "   t_bill_d\n ";
        $sql .= "SET\n";
        $sql .= "   bill_amount_this = ".$data[$i][ar_balance]."\n";
        $sql .= "WHERE\n";
        $sql .= "   t_bill_d.bill_id = ".$bill_d_id."\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        print_array($sql);

    //¸�ߤ��ʤ�������Ͽ
    }else{

        //������ֹ����
        $sql  = "SELECT";
        $sql .= "   MAX(bill_no)\n";
        $sql .= "FROM";
        $sql .= "   t_bill\n";
        $sql .= "WHERE\n";
        $sql .= "   first_set_flg = 't'\n";
        $sql .= "   AND\n";
        $sql .= "   shop_id = 93\n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        $max_no = pg_fetch_result($result,0,0)+1;            //��Ф���Ϣ�֤�8��ˤʤ�褦�˺�¦��0��᤹��

        $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);

        $sql  = "INSERT INTO t_bill(\n";
        $sql .= "   bill_id,\n";              //����ID
        $sql .= "   bill_no,\n";              //������ֹ�
        $sql .= "   fix_flg,\n";              //����ե饰
        $sql .= "   last_update_flg,\n";      //�����ե饰
        $sql .= "   last_update_day,\n";      //�����»���
        $sql .= "   create_staff_name,\n";    //����ǥǡ���������
        $sql .= "   fix_day,\n";              //������
        $sql .= "   shop_id,\n";              //�����ID
        $sql .= "   first_set_flg\n";         //�Ĺ�����ե饰
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),\n";
        $sql .= "   '$claim_sheet_no',\n";
        $sql .= "   't',\n";
        $sql .= "   't',\n";
        $sql .= "   NOW(),\n";
        $sql .= "   '����˧��',\n";
        $sql .= "   NOW(),\n";
        $sql .= "   93,\n";
        $sql .= "   't'\n";
        $sql .= ");\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){ 
            Db_Query($db_con, "ROLLBACK");
            exit;   
        }

        //����ǡ�������Ͽ
        $sql  = "INSERT INTO t_bill_d(\n";
        $sql .= "   bill_d_id,\n";
        $sql .= "   bill_id,\n";
        $sql .= "   bill_close_day_this,\n";
        $sql .= "   client_id,\n";
        $sql .= "   claim_div,\n";
        $sql .= "   bill_amount_this\n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(bill_d_id),0)+1 FROM t_bill_d),\n";
        $sql .= "   (SELECT\n";
        $sql .= "       bill_id\n";
        $sql .= "   FROM\n";
        $sql .= "       t_bill\n";
        $sql .= "   WHERE\n";
        $sql .= "       shop_id = 93\n";
        $sql .= "       AND\n";
        $sql .= "       bill_no = '$claim_sheet_no'\n";
        $sql .= "       AND\n";
        $sql .= "       first_set_flg = 't'\n";
        $sql .= "   ),\n";
        $sql .= "   '2005-10-31',\n";
        $sql .= "   ".$data[$i][client_id].",\n";
        $sql .= "   '1',\n";
        $sql .= "   ".$data[$i][ar_balance]."\n";
        $sql .= ");\n";

        print_array($sql);
        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }

}



}


?>

<html>
    <head>
        <title>aaaa</title>
    </head>
<body>

<form action="./bill_update.php" method="POST">
    <input type="submit" value="START" name="submit">
</form>

</body>
</html>







