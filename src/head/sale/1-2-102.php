<?php
/****************************
 *���ѹ�����
 *     (20060807) ������ȯ��ǡ�������Ф��Ƥ���Х�����<watanabe-k>
*****************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/31      08-025      ��          �������դ����եե�����˥ե����������碌�Ƥ����������դ�ɽ������ʤ��Х�����
 *  2006/11/01      08-018      ��          �ǿ���ɼ��ø�Ρ��֥饦���Υ���ɡʺ�SUBMIT�ˤˤ�꿷���˺������줿��ɼ����������Х�����
 *  2006/11/03      08-009      suzuki      ���˼���򵯤����Ƥ���ǡ������ä����Ȥ��˥��顼��å�����ɽ��
 *                  08-024      suzuki      ������CDɽ��
 *  2006/11/09      08-148      suzuki      ���顼���ˤϥǡ�����ɽ�����ʤ�
 *  2006/12/07      ban_0044    suzuki      ���դ򥼥����
 *  2007/02/05                  watanabe-k  ��FCȯ�����סִ�˾Ǽ���ס�������פ�ʲ����ѹ�
                                            �֥���å�̾�ס�FCȯ�����ס�ȯ���ֹ�סִ�˾Ǽ����
 *  2007/02/05                  watanabe-k  �ֽв�ͽ������������ϥܥ������ɼ��˰�Ĥ�Ż���
 *  2007/02/07                  watanabe-k  �ƣ�ȯ���Ϣ����ǲ�����ɽ��
 *  2007-04-05                  fukuda      ����������������ɲ�
 *
 *
 */

$page_title = "����Ǽ���ֿ�(����饤��)";

// Env setting file�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// Create HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// Register the template function�ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// Connect to DB DB��³
$db_con = Db_Connect();

// Authority check ���¥����å�
$auth       = Auth_Check($db_con);
// button disabled �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//  search condition restoration matters �������������Ϣ
/****************************/
// array Search form initial value �����ե�������������
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_ord_day"      => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
    ),
    "form_ord_no"       => array("s" => "", "e" => ""),
    "form_hope_day"     => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
);

// search condition restoration  �����������
Restore_Filter2($form, "aord", "show_button", $ary_form_list);


/****************************/
// acquire external variable �����ѿ�����
/****************************/
$staff_id = $_SESSION["staff_id"];
$shop_id  = $_SESSION["shop_id"];

//acquire the purchase order ID of data selected ���򤵤줿�ǡ�����ȯ��ID�����
$ord_id = $_POST["ord_id_flg"];


/****************************/
// initial value setting ���������
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // all items �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // pnumber of pages displayed ɽ���ڡ�����


/****************************/
// form parts definition �ե�����ѡ������
/****************************/
// display items ɽ�����
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����", "1");
$obj[]  =&  $form->createElement("radio", null, null, "100",  "2");
$form->addGroup($obj, "form_display_num", "", "");

// FC������� FC��business partner 
Addelement_Client_64n($form, "form_client", "FC�������", "-");

// FCȯ���� FC purchase order date 
Addelement_Date_Range($form, "form_ord_day", "FCȯ����", "-");

// FCȯ���ֹ� FC purchase order number 
Addelement_Slip_Range($form, "form_ord_no", "FCȯ���ֹ�", "-");

// ��˾Ǽ�� desired delivery date
Addelement_Date_Range($form, "form_hope_day", "��˾Ǽ��", "-");

// ľ���� direct destination
$form->addElement("text", "form_direct", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// ����Ǽ������ɽ list of received order and their dates
$form->addElement("button", "aord_limit", "����Ǽ������ɽ", "onClick=\"javascript:window.open('".HEAD_DIR."sale/1-2-109.php')\"");

// �����ȥ�� sort link
$ary_sort_item = array(
    "sl_client_cd"      => "FC������襳����",
    "sl_client_name"    => "FC�������̾",
    "sl_fc_ord_day"     => "FCȯ����",
    "sl_fc_ord_no"      => "FCȯ���ֹ�",
    "sl_direct"         => "ľ����",
    "sl_hope_day"       => "��˾Ǽ��",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_fc_ord_day");

// ɽ���ܥ��� display button
$form->addElement("submit", "show_button", "ɽ����");

// ���ꥢ�ܥ��� clear button
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �����ե饰 process flag
$form->addElement("hidden", "data_cancel_flg");
$form->addElement("hidden", "ord_id_flg");
$form->addElement("hidden", "hdn_del_enter_date");


/****************************/
// ��å�󥯲����� when the cancel link is pressed
/****************************/
if ($_POST["data_cancel_flg"] == "true"){

    $hdn_del_enter_date = $_POST["hdn_del_enter_date"];

    //����ǡ����򵯤����Ƥ��뤫Ƚ�� determine if the sales order data is recorded
    $sql  = "SELECT fc_ord_id FROM t_aorder_h WHERE fc_ord_id = $ord_id;";
    $result = Db_Query($db_con,$sql);
    $check_num = pg_num_rows($result);

    if ($check_num != 0){

        //���˼���򵯤����Ƥ���٥��顼ɽ�� error because sales order is already recorded 
        $error_msg = "���˼���ǡ�����¸�ߤ��Ƥ���ټ�äǤ��ޤ���";

    }else{
        //ȯ���ý��� process for cancelling purchase order

        Db_Query($db_con, "BEGIN;");

        $data_cancel  = "UPDATE \n";
        $data_cancel .= "   t_order_h \n";
        $data_cancel .= "SET \n";
        $data_cancel .= "   ord_stat = '3', \n";
        $data_cancel .= "   can_staff_id = $staff_id, \n";
        $data_cancel .= "   can_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id), \n";
        $data_cancel .= "   can_day = NOW() \n";
        $data_cancel .= "WHERE \n";
        $data_cancel .= "   ord_id = $ord_id \n";
        $data_cancel .= "AND \n";
        $data_cancel .= "   enter_day = '$hdn_del_enter_date' \n";
        $data_cancel .= ";";
        //�����ǡ������ corresponding number of data
        $result = Db_Query($db_con, $data_cancel);

        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        Db_Query($db_con, "COMMIT;");
    }

    // hidden�򥯥ꥢ clear the hidden 
    $clear_hdn["data_cancel_flg"]       = "";
    $clear_hdn["hdn_del_enter_date"]    = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲����� process when the display button is pressed 
/****************************/
if ($_POST["show_button"] == "ɽ����"){

    // ����POST�ǡ�����0��� fill the date POST data with 0s 
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    /****************************/
    // ���顼�����å� error check
    /****************************/
    // ��FCȯ���� FC purchase order date
    // ���顼��å����� error msg
    $err_msg = "FCȯ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ����˾Ǽ�� desired delivery date
    // ���顼��å����� error msg
    $err_msg = "��˾Ǽ�� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_hope_day", $err_msg);

    /****************************/
    // ���顼�����å���̽��� collect error result 
    /****************************/
    // �����å�Ŭ�� apply check
    $form->validate();
    // ��̤�ե饰�� flag the result
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���  when display button is pressed + when there is no error
// 2. �ڡ����ڤ��ؤ���  When page is switched 
/****************************/
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // ����POST�ǡ�����0��� Fill date POST data with 0s 
    $_POST["form_ord_day"]  = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_hope_day"] = Str_Pad_Date($_POST["form_hope_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å� Set the form's value in the variable 
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�  Set the value (Set within the search condition restoration function) of SESSION (for hidden) in the variable.
    // ����������������˻��� Use for query for acquiring the list
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];

    $post_flg = true;

}


/****************************/ 
// �����ǡ������������� create condition for acquiring list data  
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // FC������襳���ɣ� FC��business partner code 1 
    $sql .= ($client_cd1 != null) ? "AND t_client.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC������襳���ɣ� FC��business partner code 2
    $sql .= ($client_cd2 != null) ? "AND t_client.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC�������̾ FC��business partner name
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // FCȯ�����ʳ��ϡ�FC purchase order (start)
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
    // FCȯ�����ʽ�λ��FC purchase order (end)
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // FCȯ���ֹ�ʳ��ϡ�FC purchase order number (start)
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FCȯ���ֹ�ʽ�λ��FC purchase order number (end)
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��˾Ǽ���ʳ��ϡ�desired delivery date (start)
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND '$hope_day_s' <= t_order_h.hope_day \n" : null; 
    // ��˾Ǽ���ʽ�λ��desired delivery date (end)
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_order_h.hope_day <= '$hope_day_e' \n" : null;
    // ľ���� direct destination
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }

    // �ѿ��ͤ��ؤ� refill the variable
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ� sort order
    switch ($_POST["hdn_sort_col"]){
        // FC������襳���� FC��business partner code
        case "sl_client_cd":
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FC�������̾ FC��business partner name
        case "sl_client_name":
            $sql .= "   t_client.client_cname, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FCȯ���� FC purchase order date 
        case "sl_fc_ord_day":
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // FCȯ���ֹ� FC purchase order number 
        case "sl_fc_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // ľ���� direct destination
        case "sl_direct":
            $sql .= "   t_direct.direct_cname, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
        // ��˾Ǽ�� desired delivery date
        case "sl_hope_day":
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_h.send_date, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_client.client_cd1, \n";
            $sql .= "   t_client.client_cd2, \n";
            $sql .= "   t_order_d.line \n";
            break;
    }

    // �ѿ��ͤ��ؤ� refill variable
    $order_sql = $sql;

}


/****************************/
// ���Ϥ�����ɼ��ꥹ�ȥ��å� list up the slip to be outputted 
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.ord_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_client  ON t_order_h.shop_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.ord_stat = '1' \n";
    $sql .= $where_sql;

    // ��������� acquire all items 
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // ɽ����� display items 
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;  
        case "2":
            $limit = "100";
            break;  
    }       

    // �������ϰ��� starting position for acquiring
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н� response when there is no record to display when rows were deleted 
    if($page_count != null){
        // �Ժ����total_count��offset�δط������줿��� If the relationship of the total_ccount and offset has collapsed cos of row deletion 
        if ($total_count <= $offset){
            // ���ե��åȤ���������� offset before the item selection 
            $offset     = $offset - $limit; 
            // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ��� show the previous page (this does not respond to when 2 pages were deleted)
            $page_count = $page_count - 1;
            // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���) Do not output the page transition when it's fewer than the selected items (make it null)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }       
    }else{  
        $offset = 0;
    }       

    // �ڡ�����ǡ�������  acquire the data within the page
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null; 
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_list_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ȯ��ĥǡ�������SQL  SQL that acquire outstanding purchase orders
/****************************/
if ($match_count > 0 && $post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   to_char(t_order_h.send_date, 'yyyy-mm-dd') AS ord_day, \n";
    $sql .= "   to_char(t_order_h.send_date, 'hh24:mi') AS ord_day_time, \n";
    $sql .= "   t_order_h.hope_day, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_order_d.goods_cd, \n";
    $sql .= "   t_order_d.goods_name, \n";
    $sql .= "   t_order_d.buy_price, \n";
    $sql .= "   t_order_d.num, \n";
    $sql .= "   t_order_d.buy_amount, \n";
    $sql .= "   t_order_h.enter_day, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_order_h.note_your, \n";
    $sql .= "   t_direct.direct_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id \n";
    $sql .= "   INNER JOIN t_client  ON t_order_h.shop_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_direct  ON t_order_h.direct_id = t_direct.direct_id \n";
    $sql .= "   INNER JOIN t_goods   ON t_order_d.goods_id = t_goods.goods_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.ord_stat = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_order_h.ord_id IN (";
    foreach ($ary_list_data as $key => $value){
    $sql .= $value["ord_id"];
    $sql .= ($key+1 < count($ary_list_data)) ? ", " : ") \n"; 
    }
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);

    // �ڡ�����ǡ������� acquire the data within the page 
    $res        = Db_Query($db_con, $sql);
    $ary_data   = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������  create the data for display
/****************************/
if ($post_flg == true && $err_flg != true){

    /****************************/
    // ɽ���ѥǡ������� fix the data for display
    /****************************/
    // �ڡ�����ǡ����ǥ롼�� oop with the data within the page 
    if (count($ary_data) > 0){
        // No.����� No.initial value
        $i = 0;
        // �Կ������ initial value of number of rows
        $row = 0;
        // 
        $html_l = null;
        foreach ($ary_data as $key => $value){

            // �������λ��ȹԤ��ѿ�������ƻȤ��䤹�����Ƥ��� Put the previous and next reference row to the variable for easy usability
            $back = $ary_data[$key-1];
            $next = $ary_data[$key+1];

            // ��No.�ν�������  output setting for No.
            //  When the first value of array, or the previous purchase order ID is different with the current one ����κǽ顢�ޤ�������Ⱥ����ȯ��ID���ۤʤ���
            if ($key == 0 || $back["ord_id"] != $value["ord_id"]){
                $no             = ++$i;
            }else{
                $no             = null;
            }
            // ��FC������� FC��Business partenr 
            // No.�������� If there is a No.
            if ($no != null){
                $client         = $value["client_cd1"];
                $client        .= ($value["client_cd2"] != null) ? "-".$value["client_cd2"] : null;
                $client        .= "<br>";
                $client        .= htmlspecialchars($value["client_cname"]);
                $client        .= "<br>";
            }else{
                $client         = null;
            }
            // ��FCȯ���� FC purchase order date
            // No.�������� If there is a No.
            if ($no != null){
                $ord_date       = $value["ord_day"]."<br>".$value["ord_day_time"]."<br>";
            }else{
                $ord_date       = null;
            }
            // ��ľ���� Direct destination 
            // No.�������� If there is a No.
            if ($no != null){
                $direct         = htmlspecialchars($value["direct_cname"]);
            }else{
                $direct         = null;
            }
            // ��FCȯ���ֹ� FC purchase order number 
            // No.�������� If there is a No.
            if ($no != null){
                $ord_no         = $value["ord_no"];
            }else{
                $ord_no         = null;
            }
            // ����˾Ǽ�� Desired delivery date
            // No.�������� If there is a No.
            if ($no != null){
                $hope_day       = $value["hope_day"];
            }else{
                $hope_day       = null;
            }
            // ������ product 
            $goods              = $value["goods_cd"]."<br>".htmlspecialchars($value["goods_name"]);
            // ��ñ�� price per unit
            $buy_price          = number_format($value["buy_price"], 2);
            // ������ units of prod
            $num                = number_format($value["num"]);
            // ����׶�� total amount
            $buy_amount         = number_format($value["buy_amount"]);
            // ���̿������������ communication field (HQ)
            // No.�������� If there is a No.
            if ($no != null){
                $note_your      = htmlspecialchars($value["note_your"]);
            }else{
                $note_your      = null;
            }
            // ���в�ͽ�����ֿ���� scheduled delivery reply link
            // No.�������� If there is a No.
            if ($no != null){
                $arrival_link   = "<a href=\"./1-2-104.php?ord_id=".$value["ord_id"]."&return_flg=1\">����</a>";
            }else{
                $arrival_link   = null;
            }
            // ����å�� cancel link
            // No.�������礫�ĸ��¤������� If there is a No. and there is an authority
            if ($no != null && $disabled == null){
                $can_link       = "<a href=\"#\" onClick=\"Order_Cancel('data_cancel_flg', 'ord_id_flg', ".$value["ord_id"].", 'hdn_del_enter_date', '".$value["enter_day"]."');\">���</a></td>";
            }else{
                $can_link       = null;
            }
            // ���Կ�css row color CSS
            if ($no != null){
                $css            = (bcmod($no, 2) == 0) ? "Result2" : "Result1";
            }else{
                $css            = $css;
            }

            // ���ޤȤ� overall
            // �Կ�css row color CSS
            $disp_data[$row]["css"]             = $css;
            // No.
            $disp_data[$row]["no"]              = $no;
            // FC������� FC/business partner
            $disp_data[$row]["client"]          = $client;
            // FCȯ���� FC purchase order date
            $disp_data[$row]["ord_date"]        = $ord_date;
            // FCȯ���ֹ� FC purchase order number 
            $disp_data[$row]["ord_no"]          = $ord_no;
            // ľ���� Direct destination
            $disp_data[$row]["direct"]          = $direct;
            // ��˾Ǽ�� desired delivery date
            $disp_data[$row]["hope_day"]        = $hope_day;
            // ���� product
            $disp_data[$row]["goods"]           = $goods;
            // ñ�� price per unit
            $disp_data[$row]["buy_price"]       = $buy_price;
            // ���� number of units of prod
            $disp_data[$row]["num"]             = $num;
            // ��׶�� total amount
            $disp_data[$row]["buy_amount"]      = $buy_amount;
            // �̿������������communication field (HQ)
            $disp_data[$row]["note_your"]       = $note_your;
            // �в�ͽ�����ֿ���� scheduled shipment date reply link
            $disp_data[$row]["arrival_link"]    = $arrival_link;
            // ��å�� cancel link
            $disp_data[$row]["can_link"]        = $can_link;

            // ����html���� create list html
            $html_l .= "    <tr class=\"$css\">\n";
            $html_l .= "        <td align=\"right\">$no</td>\n";
            $html_l .= "        <td>$client</td>\n";
            $html_l .= "        <td align=\"center\">$ord_date</td>\n";
            $html_l .= "        <td align=\"center\">$ord_no</td>\n";
            $html_l .= "        <td>$direct</td>\n";
            $html_l .= "        <td align=\"center\">$hope_day</td>\n";
            $html_l .= "        <td>$goods</td>\n";
            $html_l .= "        <td align=\"right\">$buy_price</td>\n";
            $html_l .= "        <td align=\"right\">$num</td>\n";
            $html_l .= "        <td align=\"right\">$buy_amount</td>\n";
            $html_l .= "        <td>$note_your</td>\n";
            $html_l .= "        <td align=\"center\" class=\"color\">$arrival_link</td>\n";
            $html_l .= "        <td align=\"center\">$can_link</td>\n";
            $html_l .= "    </tr>\n";

            // �Կ��û� add row numbers
            $row++;

        }
    }

}


/****************************/
// js
/****************************/
$order_cancel  = " function Order_Cancel(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$order_cancel .= "    res = window.confirm(\"��ä��ޤ���������Ǥ�����\");\n";
$order_cancel .= "    if (res == true){\n";
$order_cancel .= "        var id = ord_id;\n";
$order_cancel .= "        var edate = enter_date;\n";
$order_cancel .= "        var hdn1 = hidden1;\n";
$order_cancel .= "        var hdn2 = hidden2;\n";
$order_cancel .= "        var hdn3 = hidden3;\n";
$order_cancel .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_cancel .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_cancel .= "        document.dateForm.elements[hdn3].value = edate;\n";
$order_cancel .= "        //Ʊ��������ɥ������ܤ���\n";
$order_cancel .= "        document.dateForm.target=\"_self\";\n";
$order_cancel .= "        //�����̤����ܤ���\n";
$order_cancel .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_cancel .= "        //POST�������������\n";
$order_cancel .= "        document.dateForm.submit();\n";
$order_cancel .= "        return true;\n";
$order_cancel .= "  }else{\n";
$order_cancel .= "        return false;\n";
$order_cancel .= "  }\n";
$order_cancel .= "}\n";


/****************************/
// HTML�����ʸ�������create HTML (search part)
/****************************/
// �������� search items 
$html_s .= "\n";
$html_s .= "<table width=\"100%\">\n";
$html_s .= "    <tr style=\"color: #555555;\">\n";
$html_s .= "        <td colspan=\"2\">\n";
$html_s .= "            <b>ɽ�����</b>".($form->_elements[$form->_elementIndex["form_display_num"]]->toHtml())."\n";
$html_s .= "            ����<span style=\"color: #0000ff; font-weight: bold;\">����FC�������׸�����̾���⤷����ά�ΤǤ�</span>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "<table class=\"Table_Search\" width=\"700px\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">FC�������</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_client"]]->toHtml())."</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">FCȯ����</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_ord_day"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "    </tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">FCȯ���ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml())."</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">��˾Ǽ��</td>\n";
$html_s .= "        <td class=\"Td_Search_1\">".($form->_elements[$form->_elementIndex["form_hope_day"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "    </tr>\n";
$html_s .= "        <td class=\"Td_Search_1\">ľ����</td>\n";
$html_s .= "        <td class=\"Td_Search_1\" colspan=\"3\">".($form->_elements[$form->_elementIndex["form_direct"]]->toHtml())."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �ܥ��� button 
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";

$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);


/****************************/
//HTML�إå� header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('sale','1');
/****************************/
//���̥إå������� create screen header
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//�ڡ������� create page
/****************************/
// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign the form related variable
$smarty->assign('form',$renderer->toArray());

//���ɽ��Ƚ�� determine the initial display
$smarty->assign('row',$page_data);

//����¾���ѿ���assign assign the other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'order_cancel'  => "$order_cancel",
    'ord_day_err'   => "$ord_day_err",
    'hope_day_err'  => "$hope_day_err",
    'auth_r_msg'    => "$auth_r_msg",
    'total_count'   => "$total_count",
    'disabled'      => "$disabled",
    'error_msg'     => "$error_msg",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
