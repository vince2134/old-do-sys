<?php
/**
 *
 * ê������
 *
 *
 *
 *
 *
 *
 *
 *   !! ������FC���̤Ȥ��Ʊ�����������ƤǤ� !!
 *   !! �ѹ�������������򤤤��ä�¾���˥��ԤäƤ������� !!
 *
 *
 *
 *
 *
 *
 *
 *
 * 1.0.0 (2006/05/11) ��������
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/05/11)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      02-015      kajioka-h   �Ҹ˷פ���
 *                  02-016      kajioka-h   �����˥��������ɲ�
 *                  02-017      kajioka-h   ���Ҹ˥ơ��֥��ɽ������SQL�����Ҹ˻���ξ����ä�
 *                  02-019      kajioka-h   GET�ο��ͥ����å�
 *  2006/12/08      02-023      kajioka-h   ê���ǡ�����¸�ߤ��ʤ��ҸˤǸ����������˥ȥåפ����֤Τ���
 *  2007/03/06      ��ȹ���73  ��          ê�������Ⱥ������ٰ����򣱥⥸�塼��˽���
 *  2007/05/04      B0702-047   kajioka-h   ���ܥ���������褬�ְ�äƤ���Τ���
 *                  B0702-048   kajioka-h   �о��ҸˤΥ��쥯�Ȥˡ�0��0�פ�ɽ�����ʤ��褦�˽���
 *  2007/05/15      B0702-052   kajioka-h   �ѿ�̾�ߥ��ˤ�륵�˥�������ϳ�����
 *  2007/06/23      xx-xxx      kajioka-h   ���������ۤ�ʤ�����ê�����ϼԤ��ɲá�����߸˿����߸˶�ۡ�������ι�פ�ɽ��
 *  2007/08/27                  kajioka-h   ê�����ۿ����ê����Ģ������ѹ���ê�����ϼԤ�ɽ�����ʤ��ʲ��̡�CSV��
 */

$page_title = "ê������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$invent_no  = $_GET["invent_no"];
$ware_id    = ($_POST["form_ware"] == null) ? $_GET["ware_id"] : $_POST["form_ware"];
$get_id     = $_GET["ware_id"];
$group_kind = $_SESSION["group_kind"];

Get_Id_Check3($invent_no);
Get_Id_Check3($ware_id);


/****************************/
// ���������
/****************************/
$def_data["form_output_type"]   = "1";
$form->setDefaults($def_data);

// ����Ĵ���ֹ�ʣ�����
$last_no    = str_pad($invent_no - 1, 10, "0", STR_PAD_LEFT);
// ����Ĵ���ֹ�ʣ�����
$invent_no  = str_pad($invent_no, 10, 0, STR_POS_LEFT);


/****************************/
// �ե��������
/****************************/
// ɽ������
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "����", "1");
$radio[] =& $form->createElement("radio", null, null, "CSV",  "2");
$form->addGroup($radio, "form_output_type", "");

// �о��Ҹ�
$ware_where  = " WHERE ";
if($group_kind == "2"){
    //ľ�Ĥξ��
    $ware_where .= " shop_id IN (".Rank_Sql().") ";
}else{
    //������ľ�İʳ���FC�ξ��
    $ware_where .= " shop_id = $shop_id ";
}
$ware_where .= " AND staff_ware_flg = false ";
$ware_where .= " AND ware_id != 0 ";
$ware_where .= " AND nondisp_flg = false ";
$select_value = Select_Get($db_con, "ware", $ware_where);
$form->addElement("select", "form_ware", "", $select_value);

// ɽ���ܥ���
$form->addElement("submit", "show_button", "ɽ����");

if($group_kind == "1"){
    // ���ꥢ�ܥ���
    $form->addElement("button", "clear_button", "���ꥢ", "onClick=\"location.href='./1-4-208.php?invent_no=$invent_no'\"");

    // ���ܥ���
    if ($get_id == null){
        $form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"location.href='./1-4-205.php'\"");
    }else{
        $form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"location.href='./1-4-201.php'\"");
    }
}else{
    // ���ꥢ�ܥ���
    $form->addElement("button", "clear_button", "���ꥢ", "onClick=\"location.href='./2-4-208.php?invent_no=$invent_no'\"");

    // ���ܥ���
    if ($get_id == null){
        $form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"location.href='./2-4-205.php'\"");
    }else{
        $form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"location.href='./2-4-201.php'\"");
    }
}


/****************************/
// ɽ���ܥ��󤬲������줿���
/****************************/
if ($_POST["show_button"] == "ɽ����"){

    // POST�������
    $output_type    = $_POST["form_output_type"];        // ���Ϸ���

}
 

/****************************/
// SQL����
/****************************/
// ê��Ĵ��ɼ����������
$sql  = "SELECT \n";
$sql .= "   expected_day \n";
$sql .= "FROM \n";
$sql .= "   t_invent \n";
$sql .= "WHERE \n";
$sql .= "   shop_id = $shop_id \n";
$sql .= "AND \n";
$sql .= "   invent_no = '$invent_no' \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
Get_Id_Check($res);
$invent_day = pg_fetch_result($res, 0, 0);


// ê���ֹ���Ȥˡ�ê���»��Ҹ˥ꥹ�Ȥ����
$sql  = "SELECT \n";
$sql .= "   t_invent.ware_id, \n";
$sql .= "   t_ware.ware_name, \n";
$sql .= "   t_invent.exec_day \n";
$sql .= "FROM \n";
$sql .= "   t_invent \n";
$sql .= "   INNER JOIN t_ware ON t_invent.ware_id = t_ware.ware_id \n";
$sql .= "WHERE \n";
$sql .= "   t_invent.shop_id = $shop_id \n";
$sql .= "AND \n";
$sql .= "   t_invent.invent_no = '$invent_no' \n";
if ($ware_id != null){
$sql .= "AND \n";
$sql .= "   t_invent.ware_id = $ware_id \n";
}
$sql .= "ORDER BY \n";
$sql .= "   t_ware.ware_cd \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$ware_list_num = pg_num_rows($res);                                 // �»��Ҹ˿�
if ($ware_list_num != 0){
    for ($i = 0; $i < $ware_list_num; $i++){
        $ary_ware_list_id[]     = pg_fetch_result($res, $i ,0);     // �»��Ҹ�ID
        $ary_ware_list_name[]   = pg_fetch_result($res, $i ,1);     // �»��Ҹ�̾
    }
}


// �Ҹˤ��Ȥˡ�ê���ǡ��������ۥǡ��������
for ($i = 0; $i < $ware_list_num; $i++){
    $sql  = "SELECT \n";
    $sql .= "   a_invent.g_product_name, \n";                                                   // 0    ����ʬ��̾
    $sql .= "   a_invent.goods_name, \n";                                                       // 1    ����̾
    $sql .= "   a_invent.stock_num, \n";                                                        // 2    Ģ���
    $sql .= "   a_invent.tstock_num, \n";                                                       // 3    ��ê��
    $sql .= "   a_invent.invent_diff, \n";                                                      // 4    ê�����ۿ�
    $sql .= "   a_invent.price, \n";                                                            // 5    ê��ñ��
    $sql .= "   a_invent.money, \n";                                                            // 6    ê�����
    $sql .= "   b_invent.tstock_num AS last_tstock_num, \n";                                    // 7    ����߸˿�
    $sql .= "   b_invent.money                                          AS last_money, \n";     // 8    ����߸˶��
    $sql .= "   a_invent.tstock_num - COALESCE(b_invent.tstock_num, 0)  AS comp_num, \n";       // 9    ���������
    //$sql .= "   a_invent.money - COALESCE(b_invent.money, 0)            AS comp_money, \n";     // 10   ����������
    $sql .= "   a_invent.staff_name, \n";                                                       // 10   ê���»ܼ�
    $sql .= "   a_invent.input_staff_name, \n";                                                 // 11   ê�����ϼ�
    $sql .= "   a_invent.cause \n";                                                             // 12   ���۸���
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_invent.ware_id, \n";
    $sql .= "           t_invent.ware_cd, \n";
    $sql .= "           t_invent.staff_name AS input_staff_name, \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.goods_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           t_contents.stock_num, \n";
    $sql .= "           t_contents.tstock_num, \n";
    $sql .= "           t_contents.price, \n";
    $sql .= "           t_contents.tstock_num * t_contents.price AS money, \n";
    //$sql .= "           t_contents.stock_num - t_contents.tstock_num AS invent_diff, \n";
    $sql .= "           t_contents.tstock_num - t_contents.stock_num AS invent_diff, \n";
    $sql .= "           t_contents.staff_name, \n";
    $sql .= "           t_contents.cause \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.ware_id = ".$ary_ware_list_id[$i]." \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.invent_no = '$invent_no' \n";
    $sql .= "   ) \n";
    $sql .= "   AS a_invent \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_invent.ware_id, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.tstock_num, \n";
    $sql .= "           t_contents.tstock_num * t_contents.price AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.ware_id = ".$ary_ware_list_id[$i]." \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.invent_no = '$last_no' \n";
    $sql .= "   ) \n";
    $sql .= "   AS b_invent \n";
    $sql .= "   ON a_invent.ware_id = b_invent.ware_id \n";
    $sql .= "   AND a_invent.goods_id = b_invent.goods_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   a_invent.ware_cd, \n";
    $sql .= "   a_invent.g_product_cd, \n";
    $sql .= "   a_invent.goods_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ary_ware_num[] = pg_num_rows($res);
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){
        $ary_ware_data[$i][] = pg_fetch_array($res, $j);
    }
}


// ���Ҹ�
// GET���Ҹ�ID�����ä����ϡ����Ҹˤ�ɽ�����ʤ�
if ($get_id == null){
    $sql  = "SELECT \n";
    $sql .= "   a_invent.g_product_name, \n";                                                               // 0    ����ʬ��̾
    $sql .= "   a_invent.goods_name, \n";                                                                   // 1    ����̾
    $sql .= "   SUM(a_invent.stock_num)                                             AS stock_num, \n";      // 2    Ģ���
    $sql .= "   SUM(a_invent.tstock_num)                                            AS tstock_num, \n";     // 3    ��ê��
    $sql .= "   SUM(a_invent.invent_diff)                                           AS invent_diff, \n";    // 4    ê�����ۿ�
    $sql .= "   SUM(a_invent.price)                                                 AS price, \n";          // 5    ê��ñ��
    $sql .= "   SUM(a_invent.money)                                                 AS money, \n";          // 6    ê�����
    $sql .= "   SUM(b_invent.tstock_num)                                            AS last_tstock_num, \n";// 7    ����߸˿�
    $sql .= "   SUM(b_invent.money)                                                 AS last_money, \n";     // 8    ����߸˶��
    $sql .= "   SUM(a_invent.tstock_num) - SUM(COALESCE(b_invent.tstock_num, 0))    AS comp_num \n";        // 9    ���������
    //$sql .= "   SUM(a_invent.money)      - SUM(COALESCE(b_invent.money, 0))         AS comp_money \n";      // 10   ����������
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.goods_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           SUM(t_contents.stock_num)                               AS stock_num, \n";
    $sql .= "           SUM(t_contents.tstock_num)                              AS tstock_num, \n";
    //$sql .= "           SUM(t_contents.stock_num) - SUM(t_contents.tstock_num)  AS invent_diff, \n";
    $sql .= "           SUM(t_contents.tstock_num) - SUM(t_contents.stock_num)  AS invent_diff, \n";
    $sql .= "           CASE \n";
    $sql .= "               WHEN SUM(t_contents.tstock_num) != 0 \n";
    $sql .= "               THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) \n";
    $sql .= "               ELSE NULL \n";
    $sql .= "           END                                                     AS price, \n";
    $sql .= "           SUM(t_contents.tstock_num * t_contents.price)           AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.invent_no = '$invent_no' \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           t_contents.g_product_name, \n";
    $sql .= "           t_contents.g_product_cd, \n";
    $sql .= "           t_contents.goods_name, \n";
    $sql .= "           t_contents.goods_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS a_invent \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_contents.goods_id, \n";
    $sql .= "           SUM(t_contents.tstock_num) AS tstock_num, \n";
    $sql .= "           SUM(t_contents.tstock_num * t_contents.price) AS money \n";
    $sql .= "       FROM \n";
    $sql .= "           t_invent \n";
    $sql .= "           INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_invent.invent_no = '$last_no' \n";
    $sql .= "       AND \n";
    $sql .= "           t_invent.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_contents.goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS b_invent \n";
    $sql .= "   ON a_invent.goods_id = b_invent.goods_id \n";
    $sql .= "GROUP BY \n";
    $sql .= "a_invent.g_product_cd, \n";
    $sql .= "   a_invent.g_product_name, \n";
    $sql .= "   a_invent.goods_cd, \n";
    $sql .= "   a_invent.goods_name, \n";
    $sql .= "   a_invent.price \n";
    $sql .= "ORDER BY \n";
    $sql .= "   a_invent.g_product_cd, \n";
    $sql .= "   a_invent.goods_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $total_num = pg_num_rows($res);
    $ary_ware_num[$ware_list_num] = $total_num;
    for ($i = 0; $i < $ary_ware_num[$ware_list_num]; $i++){
        $ary_ware_data[$ware_list_num][] = pg_fetch_array($res, $i);
    }
}


// ê���ǡ�����¸�ߤ��ʤ���票�顼
if ($ware_list_num <= 0 && $total_num <= 0){
    $err_mess = "��������ê����¸�ߤ��ޤ���";
}


/****************************/
// ����ʬ��ν�ʣ���� && ����ʬ��ס��Ҹ˷פ򻻽�
/****************************/
$page_data = $ary_ware_data;

// �Ҹˤǥ롼��
for ($i = 0; $i <= $ware_list_num; $i++){

    // �Ҹ���ǡ����ǥ롼��
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){

        // �������ιԤξ���ʬ��̾��Ʊ�����
        if ($ary_ware_data[$i][$j]["g_product_name"] == $ary_ware_data[$i][$j-1]["g_product_name"]){

            // ���ͤ�û�
            $stock_num_total        += $ary_ware_data[$i][$j]["stock_num"];         // Ģ���
            $tstock_num_total       += $ary_ware_data[$i][$j]["tstock_num"];        // ��ê��
            $invent_diff_total      += $ary_ware_data[$i][$j]["invent_diff"];       // ê�����ۿ�
            $price_total            += $ary_ware_data[$i][$j]["price"];             // ê��ñ��
            $money_total            += $ary_ware_data[$i][$j]["money"];             // ê�����
            $last_tstock_num_total  += $ary_ware_data[$i][$j]["last_tstock_num"];   // ����߸˿�
            $last_money_total       += $ary_ware_data[$i][$j]["last_money"];        // ����߸˶��
            $comp_num_total         += $ary_ware_data[$i][$j]["comp_num"];          // ���������
            //$comp_money_total       += $ary_ware_data[$i][$j]["comp_money"];        // ����������
            $page_data[$i][$j][0] = null;

            // ���ȼ��ιԤξ���ʬ��̾���㤦���
            if ($ary_ware_data[$i][$j]["g_product_name"] != $ary_ware_data[$i][$j+1]["g_product_name"]){
                // ����ʬ���
                $g_product_total[$i][$j]  = array(
                    number_format($stock_num_total),                        // Ģ���
                    number_format($tstock_num_total),                       // ��ê��
                    number_format($invent_diff_total),                      // ê�����ۿ�
                    number_format($price_total, 2),                         // ê��ñ��
                    number_format($money_total, 2),                         // ê�����
                    number_format($last_tstock_num_total),                  // ����߸˿�
                    number_format($last_money_total, 2),                    // ����߸˶��
                    number_format($comp_num_total),                         // ���������
                    //number_format($comp_money_total, 2),                    // ����������
                );
                // ����ʬ��׽��ϥե饰true
                $page_data[$i][$j][90] = true;
                
            }

        // ���ȼ��ιԤξ���ʬ��̾���㤦���
        }elseif ($ary_ware_data[$i][$j]["g_product_name"] != $ary_ware_data[$i][$j+1]["g_product_name"]){

            // ���ͤ�����
            $stock_num_total        = $ary_ware_data[$i][$j]["stock_num"];          // Ģ���
            $tstock_num_total       = $ary_ware_data[$i][$j]["tstock_num"];         // ��ê��
            $invent_diff_total      = $ary_ware_data[$i][$j]["invent_diff"];        // ê�����ۿ�
            $price_total            = $ary_ware_data[$i][$j]["price"];              // ê��ñ��
            $money_total            = $ary_ware_data[$i][$j]["money"];              // ê�����
            $last_tstock_num_total  = $ary_ware_data[$i][$j]["last_tstock_num"];    // ����߸˿�
            $last_money_total       = $ary_ware_data[$i][$j]["last_money"];         // ����߸˶��
            $comp_num_total         = $ary_ware_data[$i][$j]["comp_num"];           // ���������
            //$comp_money_total       = $ary_ware_data[$i][$j]["comp_money"];         // ����������

            // ����ʬ���
            $g_product_total[$i][$j] = array(
                number_format($ary_ware_data[$i][$j]["stock_num"]),         // Ģ���
                number_format($ary_ware_data[$i][$j]["tstock_num"]),        // ��ê��
                number_format($ary_ware_data[$i][$j]["invent_diff"]),       // ê�����ۿ�
                number_format($ary_ware_data[$i][$j]["price"], 2),          // ê��ñ��
                number_format($ary_ware_data[$i][$j]["money"], 2),          // ê�����
                number_format($ary_ware_data[$i][$j]["last_tstock_num"]),   // ����߸˿�
                number_format($ary_ware_data[$i][$j]["last_money"], 2),     // ����߸˶��
                number_format($ary_ware_data[$i][$j]["comp_num"]),          // ���������
                //number_format($ary_ware_data[$i][$j]["comp_money"], 2),     // ����������
            );
            // ����ʬ��׽��ϥե饰true
            $page_data[$i][$j][90] = true;

        // ����ʳ�
        }else{

            // ���ͤ�����
            $stock_num_total        = $ary_ware_data[$i][$j]["stock_num"];          // Ģ���
            $tstock_num_total       = $ary_ware_data[$i][$j]["tstock_num"];         // ��ê��
            $invent_diff_total      = $ary_ware_data[$i][$j]["invent_diff"];        // ê�����ۿ�
            $price_total            = $ary_ware_data[$i][$j]["price"];              // ê��ñ��
            $money_total            = $ary_ware_data[$i][$j]["money"];              // ê�����
            $last_tstock_num_total  = $ary_ware_data[$i][$j]["last_tstock_num"];    // ����߸˿�
            $last_money_total       = $ary_ware_data[$i][$j]["last_money"];         // ����߸˶��
            $comp_num_total         = $ary_ware_data[$i][$j]["comp_num"];           // ���������
            //$comp_money_total       = $ary_ware_data[$i][$j]["comp_money"];         // ����������
        }

        // �Ҹ˷�
        $ware_total[$i][0] += $ary_ware_data[$i][$j]["stock_num"];          // Ģ���
        $ware_total[$i][1] += $ary_ware_data[$i][$j]["tstock_num"];         // ��ê��
        $ware_total[$i][2] += $ary_ware_data[$i][$j]["invent_diff"];        // ê�����ۿ�
        $ware_total[$i][3] += $ary_ware_data[$i][$j]["price"];              // ê��ñ��
        $ware_total[$i][4] += $ary_ware_data[$i][$j]["money"];              // ê�����
        $ware_total[$i][5] += $ary_ware_data[$i][$j]["last_tstock_num"];    // ����߸˿�
        $ware_total[$i][6] += $ary_ware_data[$i][$j]["last_money"];         // ����߸˶��
        $ware_total[$i][7] += $ary_ware_data[$i][$j]["comp_num"];           // ���������
        //$ware_total[$i][8] += $ary_ware_data[$i][$j]["comp_money"];         // ����������

    }
}


/****************************/
// �ʥ�С��ե����ޥå�
/****************************/
// �Ҹˤǥ롼��
for ($i = 0; $i <= $ware_list_num; $i++){

    // �Ҹ���ǡ����ǥ롼��
    for ($j = 0; $j < $ary_ware_num[$i]; $j++){
        $page_data[$i][$j][2]   = number_format($page_data[$i][$j][2]);         // Ģ���
        $page_data[$i][$j][3]   = number_format($page_data[$i][$j][3]);         // ��ê��
        $page_data[$i][$j][4]   = number_format($page_data[$i][$j][4]);         // ê�����ۿ�
        $page_data[$i][$j][5]   = number_format($page_data[$i][$j][5], 2);      // ê��ñ��
        $page_data[$i][$j][6]   = number_format($page_data[$i][$j][6], 2);      // ê�����
        $page_data[$i][$j][7]   = number_format($page_data[$i][$j][7]);         // ����߸˿�
        $page_data[$i][$j][8]   = number_format($page_data[$i][$j][8], 2);      // ����߸˶��
        $page_data[$i][$j][9]   = number_format($page_data[$i][$j][9]);         // ���������
        //$page_data[$i][$j][10]  = number_format($page_data[$i][$j][10], 2);     // ����������
    }

    $ware_total[$i][0]          = number_format($ware_total[$i][0]);            // Ģ���
    $ware_total[$i][1]          = number_format($ware_total[$i][1]);            // ��ê��
    $ware_total[$i][2]          = number_format($ware_total[$i][2]);            // ê�����ۿ�
    $ware_total[$i][3]          = number_format($ware_total[$i][3], 2);         // ê��ñ��
    $ware_total[$i][4]          = number_format($ware_total[$i][4], 2);         // ê�����
    $ware_total[$i][5]          = number_format($ware_total[$i][5]);            // ����߸˿�
    $ware_total[$i][6]          = number_format($ware_total[$i][6], 2);         // ����߸˶��
    $ware_total[$i][7]          = number_format($ware_total[$i][7]);            // ���������
    //$ware_total[$i][8]          = number_format($ware_total[$i][8], 2);         // ����������

}


/****************************/
// CSV�ǡ�������
/****************************/
if($output_type == "2"){

    $csv_file_name = "ê������".date("Ymd").".csv";

    $csv_header = array(
        "ê����",
        "ê��Ĵ���ֹ�",
        "����ê��Ĵ���ֹ�",
        "�Ҹ�̾",
        "����ʬ��̾",
        "����̾",
        "Ģ���",
        "��ê��",
        "ê�����ۿ�",
        "ê��ñ��",
        "ê�����",
        "����߸˿�",
        "����߸˶��",
        "���������",
        //"����������",
        "ê���»ܼ�",
        //"ê�����ϼ�",
        "���۸���",
    );

    $ary_ware_list_name[$ware_list_num] = "���Ҹ�";

    $s = 0;
    for($i = 0; $i <= $ware_list_num; $i++){
        for($j = 0; $j < count($ary_ware_data[$i]); $j++){
            $csv_data[$s] = array(
                (($s == 0) ? $invent_day : null),           // ê�����ʡ�
                (($s == 0) ? $invent_no  : null),           // ê��Ĵ���ֹ�
                (($s == 0) ? $last_no    : null),           // ����ê��Ĵ���ֹ�
                $ary_ware_list_name[$i],                    // �Ҹ�̾
                $ary_ware_data[$i][$j]["g_product_name"],   // ����ʬ��̾
                $ary_ware_data[$i][$j]["goods_name"],       // ����̾
                $ary_ware_data[$i][$j]["stock_num"],        // Ģ���
                $ary_ware_data[$i][$j]["tstock_num"],       // ��ê��
                $ary_ware_data[$i][$j]["invent_diff"],      // ê�����ۿ�
                (($ary_ware_list_name[$i] == "���Ҹ�" && $ary_ware_data[$i][$j]["tstock_num"] == 0) ? 
                "-" : $ary_ware_data[$i][$j]["price"]),     // ê��ñ�������ҸˤǼ�ê����0�ξ��ϥϥ��ե��
                $ary_ware_data[$i][$j]["money"],            // ê�����
                $ary_ware_data[$i][$j]["last_tstock_num"],  // ����߸˿�
                $ary_ware_data[$i][$j]["last_money"],       // ����߸˶��
                $ary_ware_data[$i][$j]["comp_num"],         // ���������
                //$ary_ware_data[$i][$j]["comp_money"],       // ����������
                $ary_ware_data[$i][$j]["staff_name"],       // ê���»ܼ�
                //$ary_ware_data[$i][$j]["input_staff_name"], // ê�����ϼ�
                $ary_ware_data[$i][$j]["cause"],            // ���۸���
            );
            $s = $s+1;
        }
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;   
}


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
//$page_menu = Create_Menu_h('stock','2');

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'invent_day'    => "$invent_day",
    'ware_list_num' => $ware_list_num,
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'last_no'       => "$last_no",
));

if($ware_list_num != 0){
    foreach($ary_ware_list_name as $key => $value){
        $ary_ware_list_name[$key] = htmlspecialchars($value);
    }
    foreach($page_data as $key1 => $value1){
        foreach($value1 as $key2 => $value2){
            foreach($value2 as $key3 => $value3){
                $page_data[$key1][$key2][$key3] = htmlspecialchars($value3);
            }
        }
    }
}

$smarty->assign('ary_ware_list_name',$ary_ware_list_name);
$smarty->assign('page_data',$page_data);
$smarty->assign('g_product_total',$g_product_total);
$smarty->assign('ware_total',$ware_total);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
