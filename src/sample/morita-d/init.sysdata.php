<?php
/**
 * ���� Do.sys2006�Υ����ƥ�ǡ������������ޤ���
 *
 * ���� 
 *
 */

//�о�DB
$l_db_name="watanabe-k_demo2";

//��������
$s_time = microtime();

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect($l_db_name);

$db_tables=array(
't_payin_d',
't_payin_h',
't_payin_no_serial',
't_bill',
't_bill_d',
't_bill_make_history',
't_bill_no_m_serial',
't_bill_no_serial',
't_bill_no_y_serial',
't_bill_renew',
't_sale_h',
't_sale_d',
't_sale_detail',
't_sale_ship',
't_sale_staff',
't_installment_sales',
't_aorder_h',
't_aorder_d',
't_aorder_detail',
't_aorder_no_serial',
't_aorder_no_serial_fc',
't_aorder_ship',
't_aorder_staff',

't_payout_h',
't_payout_d',
't_payout_no_serial',
't_schedule_payment',
't_buy_h',
't_buy_d',
't_amortization',
't_order_d',
't_order_h',

't_rental',
't_rental_d',
't_rental_h',
't_stock_hand',
't_first_ap_balance',
't_first_ar_balance',
't_ap_balance',
't_ar_balance',
't_invent',
't_contents',
't_mst_log',
't_sys_renew',
/*
*/
);

Db_Query($db_con, "BEGIN;");
foreach($db_tables  as $table_name ){

    //�������
    $sql = "DELETE FROM  $table_name;";
    $result = Db_Query($db_con, $sql);
    //echo "$table_name"."�������ޤ�����<br>";

    //�����η����0��ʤ�������
    $sql     = "SELECT COUNT(*) FROM $table_name;";
    $result2 = Db_Query($db_con, $sql);
    $row     = pg_fetch_result($result2,0,0);
    $t_data .= "<tr><td>$table_name</td><td>$row</td></tr>";
    

    //�ơ��֥������ʤɤˤ��ǡ�������˼��Ԥ������
    if ( $row != "0" ) {
       $error = "<font color=#ff0000>�ǡ����κ���˼��Ԥ����ơ��֥뤬����ޤ���</font>";
    }


}
Db_Query($db_con, "COMMIT;");


//��������
$e_time = microtime();

//������ɽ��
echo <<<PRINT_HTML
$error

�ڥǡ�������ơ��֥������
<table border=\"1\">
<th>�ơ��֥�̾</th>
<th>���</th>
$t_data
</table>
$s_time
$e_time
PRINT_HTML;



?>
