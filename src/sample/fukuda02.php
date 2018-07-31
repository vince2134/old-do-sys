<?php

// �Ķ�����ե��������
require_once("ENV_local.php");

// DB��³����
//$db_con = Db_Connect("amenity_demo_new");
//$db_con = Db_Connect("amenity_morita");
$db_con = Db_Connect();


/***************************************
    �ԥǡ���������������襳���ɤ�NULL�ιԡ�
***************************************/
// ���������򤵤줿���
if ($_POST["table"] == "t_buy"){
    // �����إå�
    $sql_h  = "SELECT ";
    $sql_h .= "     t_buy_h.buy_id, ";                              // ����ID
    $sql_h .= "     t_client.client_cd1, ";                         // �����襳����1
    $sql_h .= "     t_client.client_name, ";                        // ������̾
    $sql_h .= "     t_client.client_name2, ";                       // ľ����̾2
    $sql_h .= "     t_direct.direct_name, ";                        // ľ����̾
    $sql_h .= "     t_direct.direct_name2, ";                       // ľ����̾2
    $sql_h .= "     t_ware.ware_name, ";                            // �����Ҹ�̾
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // ô����̾
    $sql_h .= "     t_e_staff.staff_name AS e_staff_name, ";        // ���ϼ�̾
    $sql_h .= "     t_oc_staff.staff_name AS oc_staff_name ";       // ȯ��ô����̾
    $sql_h .= "FROM t_buy_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_buy_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_buy_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_buy_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_buy_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_e_staff ON t_buy_h.e_staff_id = t_e_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_oc_staff ON t_buy_h.oc_staff_id = t_oc_staff.staff_id ";
//    $sql_h .= "WHERE t_buy_h.client_name IS NULL ";
    $sql_h .= ";";
    // �����ǡ���
    $sql_d  = "SELECT ";
    $sql_d .= "     t_buy_d.buy_d_id, ";                            // �����ǡ���ID
    $sql_d .= "     t_goods.goods_cd, ";                            // ���ʥ�����
    $sql_d .= "     t_goods.in_num ";                               // ����
    $sql_d .= "FROM t_buy_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
//    $sql_d .= "WHERE t_buy_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// ȯ�����򤵤줿���
if ($_POST["table"] == "t_order"){
    // ȯ��إå�
    $sql_h  = "SELECT ";
    $sql_h .= "     t_order_h.ord_id, ";                            // ȯ��ID
    $sql_h .= "     t_client.client_cd1, ";                         // �����襳����1
    $sql_h .= "     t_client.client_cd2, ";                         // �����襳����2
    $sql_h .= "     t_client.client_name, ";                        // ������̾
    $sql_h .= "     t_client.client_name2, ";                       // ������̾2
    $sql_h .= "     t_client.post_no1 AS client_post_no1, ";        // �����袩1
    $sql_h .= "     t_client.post_no2 AS client_post_no2, ";        // �����袩2
    $sql_h .= "     t_client.address1 AS client_address1, ";        // �����轻��1
    $sql_h .= "     t_client.address2 AS client_address2, ";        // �����轻��2
    $sql_h .= "     t_client.address3 AS client_address3, ";        // �����轻��3
    $sql_h .= "     t_client.charger1 AS client_charger1, ";        // �����褴ô����̾
    $sql_h .= "     t_direct.direct_name, ";                        // ľ����̾
    $sql_h .= "     t_direct.direct_name2, ";                       // ľ����̾2
    $sql_h .= "     t_direct.post_no1 AS direct_post_no1, ";        // ľ���袩1
    $sql_h .= "     t_direct.post_no2 AS direct_post_no2, ";        // ľ���袩2
    $sql_h .= "     t_direct.address1 AS direct_address1, ";        // ľ���轻��1
    $sql_h .= "     t_direct.address2 AS direct_address2, ";        // ľ���轻��2
    $sql_h .= "     t_direct.address3 AS direct_address3, ";        // ľ���轻��3
    $sql_h .= "     t_trans.trans_name, ";                          // �����ȼ�̾
    $sql_h .= "     t_ware.ware_name, ";                            // �����Ҹ�̾
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // ô����̾
    $sql_h .= "     t_ord_staff.staff_name AS ord_staff_name, ";    // ȯ���̾
    $sql_h .= "     t_can_staff.staff_name AS can_staff_name, ";    // ��ü�̾
    $sql_h .= "     t_my_client.shop_name AS my_client_name, ";     // ����̾
    $sql_h .= "     t_my_client.shop_name2 AS my_client_name2 ";    // ����̾2
    $sql_h .= "FROM t_order_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_order_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_order_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_order_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_order_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_order_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ord_staff ON t_order_h.ord_staff_id = t_ord_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_can_staff ON t_order_h.ord_staff_id = t_can_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_client AS t_my_client ON t_order_h.shop_id = t_my_client.client_id ";
//    $sql_h .= "WHERE t_order_h.client_name IS NULL ";
    $sql_h .= ";";
    // ȯ��ǡ���
    $sql_d  = "SELECT ";
    $sql_d .= "     t_order_d.ord_d_id, ";                          // ȯ��ǡ���ID
    $sql_d .= "     t_goods.goods_cd, ";                            // ���ʥ�����
    $sql_d .= "     t_goods.goods_cname, ";                         // ����̾ά��
    $sql_d .= "     t_goods.in_num ";                               // ����
    $sql_d .= "FROM t_order_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
//    $sql_d .= "WHERE t_order_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// �������򤵤줿���
if ($_POST["table"] == "t_aorder"){
    // ����إå�
    $sql_h  = "SELECT ";
    $sql_h .= "     t_aorder_h.aord_id, ";                          // ����ID
    $sql_h .= "     t_client.client_cd1, ";                         // �����襳����1
    $sql_h .= "     t_client.client_cd2, ";                         // �����襳����2
    $sql_h .= "     t_client.client_name, ";                        // ������̾
    $sql_h .= "     t_client.client_name2, ";                       // ������̾2
    $sql_h .= "     t_client.client_cname, ";                       // ������̾ά��
    $sql_h .= "     t_direct.direct_name, ";                        // ľ����̾
    $sql_h .= "     t_direct.direct_name2, ";                       // ľ����̾2
    $sql_h .= "     t_trans.trans_name, ";                          // �����ȼ�̾
    $sql_h .= "     t_ware.ware_name, ";                            // �в��Ҹ�̾
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // ô����̾
    $sql_h .= "     t_ord_staff.staff_name AS ord_staff_name, ";    // ���ϼ�̾
    $sql_h .= "     t_can_staff.staff_name AS cancel_user_name, ";  // ��ü�̾
    $sql_h .= "     t_chk_staff.staff_name AS check_user_name, ";   // �����å���̾
    $sql_h .= "     t_rsn_staff.staff_name AS reason_user_name, ";  // ��α��ͳ���ϼ�̾
    $sql_h .= "     t_intro_staff.staff_name AS intro_ac_name, ";   // �Ҳ��̾
    $sql_h .= "     t_course.course_name ";                         // ������̾
    $sql_h .= "FROM t_aorder_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_aorder_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_aorder_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_aorder_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ord_staff ON t_aorder_h.ord_staff_id = t_ord_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_can_staff ON t_aorder_h.can_staff_id = t_can_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_chk_staff ON t_aorder_h.check_staff_id = t_chk_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_rsn_staff ON t_aorder_h.reason_staff_id = t_rsn_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_intro_staff ON t_aorder_h.intro_account_id = t_intro_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_course ON t_aorder_h.course_id = t_course.course_id ";
//    $sql_h .= "WHERE t_aorder_h.client_name IS NULL ";
    $sql_h .= ";";
    // ����ǡ���
    $sql_d  = "SELECT ";
    $sql_d .= "     t_aorder_d.aord_d_id, ";                        // ����ǡ���ID
    $sql_d .= "     t_goods.goods_cd, ";                            // ���ʥ�����
    $sql_d .= "     t_rgoods.goods_cd AS rgoods_cd, ";              // ���ξ��ʥ�����
    $sql_d .= "     t_egoods.goods_cd AS egoods_cd, ";              // �����ʥ�����
    $sql_d .= "     t_serv.serv_cd, ";                              // �����ӥ�������
    $sql_d .= "     t_serv.serv_name ";                             // �����ӥ�̾
    $sql_d .= "FROM t_aorder_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_egoods ON t_aorder_d.egoods_id = t_egoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_rgoods ON t_aorder_d.rgoods_id = t_rgoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_serv ON t_aorder_d.serv_id = t_serv.serv_id ";
//    $sql_d .= "WHERE t_aorder_d.goods_cd IS NULL ";
    $sql_s .= ";";
}

// ��夬���򤵤줿���
if ($_POST["table"] == "t_sale"){
    // ���إå�
    $sql_h  = "SELECT ";
    $sql_h .= "     t_sale_h.sale_id, ";                            // ���ID
    $sql_h .= "     t_client.client_cd1, ";                         // �����襳����1
    $sql_h .= "     t_client.client_cd2, ";                         // �����襳����2
    $sql_h .= "     t_client.client_name, ";                        // ������̾
    $sql_h .= "     t_client.client_name2, ";                       // ������̾2
    $sql_h .= "     t_client.post_no1 AS c_post_no1, ";             // �����袩1
    $sql_h .= "     t_client.post_no2 AS c_post_no2, ";             // �����袩2
    $sql_h .= "     t_client.address1 AS c_address1, ";             // �����轻��1
    $sql_h .= "     t_client.address2 AS c_address2, ";             // �����轻��2
    $sql_h .= "     t_client.address3 AS c_address3, ";             // �����轻��3
    $sql_h .= "     t_client.shop_name AS c_shop_name, ";           // �������̾
    $sql_h .= "     t_client.shop_name2 AS c_shop_name2, ";         // �������̾2
    $sql_h .= "     t_direct.direct_cd, ";                          // ľ���襳����
    $sql_h .= "     t_direct.direct_name, ";                        // ľ����̾
    $sql_h .= "     t_direct.direct_name2, ";                       // ľ����̾2
    $sql_h .= "     t_direct.direct_cname, ";                       // ľ����̾ά��
    $sql_h .= "     t_direct.post_no1 AS d_post_no1, ";             // ľ���袩1
    $sql_h .= "     t_direct.post_no2 AS d_post_no2, ";             // ľ���袩2
    $sql_h .= "     t_direct.address1 AS d_address1, ";             // ľ���轻��1
    $sql_h .= "     t_direct.address2 AS d_address2, ";             // ľ���轻��2
    $sql_h .= "     t_direct.address3 AS d_address3, ";             // ľ���轻��3
    $sql_h .= "     t_direct.tel AS d_tel, ";                       // ľ����TEL
    $sql_h .= "     t_direct.fax AS d_fax, ";                       // ľ����FAX
    $sql_h .= "     t_trans.trans_name, ";                          // �����ȼ�̾
    $sql_h .= "     t_trans.trans_cname, ";                         // �����ȼ�̾ά��
    $sql_h .= "     t_ware.ware_name, ";                            // �в��Ҹ�̾
    $sql_h .= "     t_c_staff.staff_name AS c_staff_name, ";        // ����ô����̾
    $sql_h .= "     t_e_staff.staff_name AS e_staff_name, ";        // ���ϼ�̾
    $sql_h .= "     t_ac_staff.staff_name AS ac_staff_name ";       // ���ô����̾
    $sql_h .= "FROM t_sale_h ";
    $sql_h .= "     LEFT JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql_h .= "     LEFT JOIN t_direct ON t_sale_h.direct_id = t_direct.direct_id ";
    $sql_h .= "     LEFT JOIN t_trans ON t_sale_h.trans_id = t_trans.trans_id ";
    $sql_h .= "     LEFT JOIN t_ware ON t_sale_h.ware_id = t_ware.ware_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_c_staff ON t_sale_h.c_staff_id = t_c_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_e_staff ON t_sale_h.e_staff_id = t_e_staff.staff_id ";
    $sql_h .= "     LEFT JOIN t_staff AS t_ac_staff ON t_sale_h.ac_staff_id = t_ac_staff.staff_id ";
//    $sql_h .= "WHERE t_sale_h.staff_name IS NULL ";
    $sql_h .= ";";
    // ���ǡ���
    $sql_d  = "SELECT ";
    $sql_d .= "     t_sale_d.sale_d_id, ";                          // ���ǡ���ID
    $sql_d .= "     t_goods.goods_cd, ";                            // ���ʥ�����
    $sql_d .= "     t_rgoods.goods_cd AS rgoods_cd, ";              // ���ξ��ʥ�����
    $sql_d .= "     t_serv.serv_name ";                             // �����ӥ�̾
    $sql_d .= "FROM t_sale_d ";
    $sql_d .= "     LEFT JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
    $sql_d .= "     LEFT JOIN t_goods AS t_rgoods ON t_sale_d.rgoods_id = t_rgoods.goods_id ";
    $sql_d .= "     LEFT JOIN t_serv ON t_sale_d.serv_id = t_serv.serv_id ";
//    $sql_d .= "WHERE t_sale_d.goods_cd IS NULL ";
    $sql_d .= ";";
}

// �إå�or�ǡ�������������򸵤ˡ����줵�줿�ѿ�($sql)��SQLʸ������
$sql = null;
$sql = ($_POST["type"] == "_h") ? $sql_h : $sql;
$sql = ($_POST["type"] == "_d") ? $sql_d : $sql;

// �¹ԥܥ��󲡲���SQL��������
if (isset($_POST["submit"]) && $sql != null){
    // �ǡ�������
    $res = Db_Query($db_con, $sql);
    $numrows = pg_num_rows($res);
    for ($i=0; $i<$numrows; $i++){
        $ary_src_data[] = @pg_fetch_array($res, $i, PGSQL_ASSOC);
    }
}

/***************************************
    ���åץǡ��Ƚ���
***************************************/
// �����ǡ�����1��ʾ夢���
if ($numrows > 0){

    // ���åץǡ����оݥơ��֥�̾
    $target_table = $_POST["table"].$_POST["type"];

    Db_Query($db_con, "BEGIN;");

    print "<b>���åץǡ����оݷ���� ".$numrows."�� (".$_POST["table"].$_POST["type"].")</b><hr>";

    // ���������ʥ��åץǡ��Ȥ���˹�ʬ�롼��
    for ($i=0; $i<$numrows; $i++){

        // �����1���ܤϥ��åץǡ����оݤΥץ饤�ޥꥭ���ʤΤǼ�����
        $ary_update_data[$i] = $ary_src_data[$i];
        $primary_id[$i] = array_shift($ary_update_data[$i]);

        // ���åץǡ���SQL
        $sql  = "UPDATE $target_table SET ";
        $j = 0;
        while(list($key, $value) = each($ary_update_data[$i])){
            // �ͤ����ξ���NULL�������
            $sql .= ($value != "") ? " $key = '$value' " : " $key = NULL ";
            // �ޤ����åץǡ��Ȥ���������ब������ϥ���ޤ����
            $sql .= ($j+1 != count($ary_update_data[$i])) ? ", " : null;
            $j++;
        }
        $sql .= "WHERE ".key($ary_src_data[$i])." = $primary_id[$i] ";
        $sql .= ";";
        print $sql."<br>";
        $res  = Db_Query($db_con, $sql);

        // ���Ԥ���������̵���ä����Ȥ�
        if($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }

    Db_Query($db_con, "COMMIT;");
    print "<hr>�����������ｪλ";

// �����ǡ�����̵�����
}else{

    print "<b>���åץǡ����оݤʤ�(".$_POST["table"].$_POST["type"].")<b><hr>";

}

?>

<html>
<head></head>
<body>

<form name="form" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
<select name="table">
    <option value="t_buy">����
    <option value="t_order">ȯ��
    <option value="t_aorder">����
    <option value="t_sale">���
</select>
<select name="type">
    <option value="_h">�إå��ơ��֥�
    <option value="_d">�ǡ����ơ��֥�
</select>
<input type="submit" name="submit" value="�� ��">


</body>
</html>
