<?php

/*************************
 *���ѹ�����
 *      ��2006/08/10�˷����ɽ������뤬���ǡ���ɽ������ʤ��Х��ν���
 *
 *
 *
 *
**************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/31      08-035      ��          �������դ����եե�����˥ե����������碌�Ƥ����������դ�ɽ������ʤ��Х�����
 *  2006/10/31      08-039      ��          ��ɼ�ֹ��󥯤Υ����⥸�塼��ְ㤤������1-2-101��1-2-110��
 *  2006/11/06      08-036      suzuki      ���������ͤ������ʾ�票�顼ɽ��
 *  2006/11/06      08-037      suzuki      ���������ͤ������ʾ���hidden�������ͤ����ꤷ�ʤ��褦�˽���
 *  2006/11/06      08-038      suzuki      ���ϥ����å���ɽ�������ѹ�
 *  2006/11/08      08-120      suzuki      �������ά��ɽ��
 *  2006/11/09      08-121      suzuki      �����襳���ɤ��ά���ʤ��褦�˽���
 *  2006/11/09      08-122      suzuki      ���ۤ�ʡ�����̡��Υڡ�����ɽ������褦�˽���
 *  2006/11/09      08-130      suzuki      ����̾�Ͽ��ͷ������ѹ����ʤ��褦�˽���
 *  2006/11/13      08-156      ��          ���ɽ�����������郎������פ�ɽ������Ƥ����Х�����
 *  2006/12/01      ssl-0047    ��          �в٤��Ƥ��ʤ��Τˡ��вٿ������ˤʤäƤ���Х��ν���
 *  2006/12/07      ban_0046    suzuki      ���դΥ������
 *  2007/01/07                  watanabe-k  ���ϥ����å������ɽ��
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007/02/07                  watanabe-k  ������ϤؤΥ�󥯤򤫤ʤ餺ɽ������褦�˽���
 *  2007-04-05                  fukuda      ����������������ɲ�
 *  2009-10-16                  hashimoto-y �����ե�����μ������ν���ͤ���ͤ��ѹ�
 *
 */

$page_title = "����İ���";

// environment setting �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// Create HTML_QuickForm HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// Register the template function �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// Connect to DB DB��³
$db_con = Db_Connect();

// Authority Check ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// Search condition restoration related �������������Ϣ
/****************************/
// array search form initial value �����ե�������������
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_c_staff"      => array("cd" => "", "select" => ""),
    "form_ware"         => "",
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"  => "",
    #2009-10-16 hashimoto-y
    #"form_aord_day"     => array(
    #    "sy" => date("Y"),
    #    "sm" => date("m"),
    #    "sd" => "01",
    #    "ey" => date("Y"),
    #    "em" => date("m"),
    #    "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    #),
    "form_aord_day"     => array(
        "sy" => "",
        "sm" => "",
        "sd" => "",
        "ey" => "",
        "em" => "",
        "ed" => ""
    ),
    "form_arrival_day"  => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"       => "",
    "form_aord_no"      => array("s" => "", "e" => ""),
    "form_ord_no"       => array("s" => "", "e" => ""),
    "form_goods"        => array("cd" => "", "name" => ""),
);

// search condition restoration �����������
Restore_Filter2($form, array("sale", "aord"), "show_button", $ary_form_list);


/****************************/
// acquire external variable �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];


/****************************/
// set initial value ���������
/****************************/
$total_count = 0;


/****************************/
// define the form parts �ե�����ѡ������
/****************************/
/* common form ���̥ե����� */
Search_Form_Aord($db_con, $form, $ary_form_list);

/* per module form �⥸�塼���̥ե����� */
// sales order number �����ֹ�
Addelement_Slip_Range($form, "form_aord_no", "�����ֹ�");

// purchase order number ȯ���ֹ�
Addelement_Slip_Range($form, "form_ord_no", "ȯ���ֹ�");

// Product code ���ʥ�����
$obj    =   null;
$obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
$form->addGroup($obj, "form_goods", "", "");

// �����ȥ�� sort link 
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_h_aord_no"      => "���������ֹ�",
    "sl_fc_ord_no"      => "FCȯ���ֹ�",
    "sl_direct"         => "ľ����",
    "sl_aord_day"       => "������",
    "sl_arrival_day"    => "�в�ͽ����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_client_cd");

// display button ɽ���ܥ���
$form->addElement("submit","show_button","ɽ����");

// clear ���ꥢ
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// header part link button �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-2-105.php", "������" => "./1-2-101.php", "����İ���" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);


/****************************/
// process when display button pressed ɽ���ܥ��󲡲�����
/****************************/
if ($_POST["show_button"] == "ɽ����"){

    // fill date POST data with 0s ����POST�ǡ�����0���
    $_POST["form_ord_day"]      = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    /****************************/
    // error check ���顼�����å�
    /****************************/
    // ��assigned staff for sales order ����ô����
    $err_msg = "����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ��select multiple staff ����ô��ʣ������
    $err_msg = "����ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ��sales order date ������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_aord_day", $err_msg);

    // ��scheduled deliver date �в�ͽ����
    $err_msg = "�в�ͽ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_arrival_day", $err_msg);

    /****************************/
    // collect error check result ���顼�����å���̽���
    /****************************/
    // Apply check �����å�Ŭ��
    $form->validate();
    // flag the result ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. when display button is pressed + when there is no error ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. When page is switched �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // Fill date POST data with 0s ����POST�ǡ�����0���
    $_POST["form_ord_day"]      = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    // 1. Set the form's value in the variable �ե�������ͤ��ѿ��˥��å�
    // 2. Set the value (Set within the search condition restoration function) of SESSION (for hidden) in the variable. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻��� Use for query for acquiring the list

    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $ware           = $_POST["form_ware"];
    $claim_cd1      = $_POST["form_claim"]["cd1"];
    $claim_cd2      = $_POST["form_claim"]["cd2"];
    $claim_name     = $_POST["form_claim"]["name"];
    $multi_staff    = $_POST["form_multi_staff"];
    $aord_day_sy    = $_POST["form_aord_day"]["sy"];
    $aord_day_sm    = $_POST["form_aord_day"]["sm"];
    $aord_day_sd    = $_POST["form_aord_day"]["sd"];
    $aord_day_ey    = $_POST["form_aord_day"]["ey"];
    $aord_day_em    = $_POST["form_aord_day"]["em"];
    $aord_day_ed    = $_POST["form_aord_day"]["ed"];
    $arrival_day_sy = $_POST["form_arrival_day"]["sy"];
    $arrival_day_sm = $_POST["form_arrival_day"]["sm"];
    $arrival_day_sd = $_POST["form_arrival_day"]["sd"];
    $arrival_day_ey = $_POST["form_arrival_day"]["ey"];
    $arrival_day_em = $_POST["form_arrival_day"]["em"];
    $arrival_day_ed = $_POST["form_arrival_day"]["ed"];
    $direct_name    = $_POST["form_direct"];
    $aord_no_s      = $_POST["form_aord_no"]["s"];
    $aord_no_e      = $_POST["form_aord_no"]["e"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $goods_cd       = $_POST["form_goods"]["cd"];
    $goods_name     = $_POST["form_goods"]["name"];

    $post_flg = true;

}


/****************************/
//create condition for acquiring list data  �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // FC��business partner code 1 FC������襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC��business partner code 2 FC������襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC��business partner name FC�������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // staff code of Sales order ����ô���ԥ�����
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // select sales order staff ����ô���ԥ��쥯��
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // warehouse �Ҹ�
    $sql .= ($ware != null) ? "AND t_aorder_h.ware_id = $ware \n" : null;
    // billing address code 1 �����襳���ɣ�
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // billing address code 2 �����襳���ɣ�
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // billing address name ������̾
    if ($claim_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client_claim.client_name  LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_name2 LIKE '%$claim_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client_claim.client_cname LIKE '%$claim_name%' \n";
        $sql .= "   ) \n";
    }
    // select multiple staff for sales order ����ô��ʣ������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // sales order date (start) �������ʳ��ϡ�
    $aord_day_s = $aord_day_sy."-".$aord_day_sm."-".$aord_day_sd;
    $sql .= ($aord_day_s != "--") ? "AND '$aord_day_s 00:00:00' <= t_aorder_h.ord_time \n" : null;
    // sales order date (end) �������ʽ�λ��
    $aord_day_e = $aord_day_ey."-".$aord_day_em."-".$aord_day_ed;
    $sql .= ($aord_day_e != "--") ? "AND t_aorder_h.ord_time <= '$aord_day_e 23:59:59' \n" : null;
    // scheduled shipment date (start) �в�ͽ�����ʳ��ϡ�
    $arrival_day_s = $arrival_day_sy."-".$arrival_day_sm."-".$arrival_day_sd;
    $sql .= ($arrival_day_s != "--") ? "AND '$arrival_day_s' <= t_aorder_h.arrival_day \n" : null;
    // scheduled delivery date (end) �в�ͽ�����ʽ�λ��
    $arrival_day_e = $arrival_day_ey."-".$arrival_day_em."-".$arrival_day_ed;
    $sql .= ($arrival_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$arrival_day_e' \n" : null;
    // direct destination ľ����
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_aorder_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }
    // HQ sales order number (start) ���������ֹ�ʳ��ϡ�
    $sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // HQ sales order number (end) ���������ֹ�ʽ�λ��
    $sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FC Purchase order number (start) FCȯ���ֹ�ʳ��ϡ�
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // FC purchase order number (end) FCȯ���ֹ�ʽ�λ��
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // Product code ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_aorder_d.goods_cd LIKE '$goods_cd%' \n" : null;
    // Product name ����̾
    $sql .= ($goods_name != null) ? "AND t_aorder_d.official_goods_name LIKE '%$goods_name%' \n" : null;

    // substitute the variable �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // sort order �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // customer code �����襳����
        case "sl_client_cd":
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // customer name ������̾
        case "sl_client_name":
            $sql .= "   t_aorder_h.client_cname, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // HQ sales order number ���������ֹ�
        case "sl_h_aord_no":
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // FC purchase order number FCȯ���ֹ�
        case "sl_fc_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // Direct destination ľ����
        case "sl_direct":
            $sql .= "   t_aorder_h.direct_cname, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // Sales order date ������
        case "sl_aord_day":
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
        // Scheduled shipment date �в�ͽ����
        case "sl_arrival_day":
            $sql .= "   t_aorder_h.arrival_day, \n";
            $sql .= "   t_aorder_h.client_cd1, \n";
            $sql .= "   t_aorder_h.client_cd2, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_aorder_h.ord_time, \n";
            $sql .= "   t_aorder_d.line \n";
            break;
    }

    // substitute the variable �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// list up the slip that will be in PDF ���Ϥ�����ɼ��ꥹ�ȥ��å�
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_aorder_d                 ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
    $sql .= "   LEFT  JOIN t_order_h                  ON t_aorder_h.fc_ord_id = t_order_h.ord_id \n";
    $sql .= "   INNER JOIN t_client                   ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_ware                     ON t_aorder_h.ware_id = t_ware.ware_id \n";
    $sql .= "   INNER JOIN t_goods                    ON t_aorder_d.goods_id = t_goods.goods_id \n";
    $sql .= "   LEFT  JOIN t_staff                    ON t_aorder_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "   LEFT  JOIN t_client AS t_client_claim ON t_aorder_h.claim_id = t_client_claim.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ps_stat IN ('1', '2') \n";
    $sql .= $where_sql;
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.aord_id \n";

    // acquire all items ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // display items ɽ�����
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;  
        case "2":
            $limit = "100";
            break;  
    }       

    // starting position for acquiring �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // response when there is no record to display when rows were deleted �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
    if($page_count != null){
        // If the relationship of the total_ccount and offset has collapsed cos of row deletion �Ժ����total_count��offset�δط������줿���
        if ($total_count <= $offset){
            // offset before the item selection ���ե��åȤ����������
            $offset     = $offset - $limit; 
            // show the previous page (this does not respond to when 2 pages were deleted) ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
            $page_count = $page_count - 1;
            // Do not output the page transition when it's fewer than the selected items (make it null) �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }       
    }else{  
        $offset = 0;
    }       

    // acquire the data within the page �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null; 
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_list_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// SQL that acquire outstanding purchase orders ȯ��ĥǡ�������SQL
/****************************/
if ($match_count > 0 && $post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.client_cd1, \n";
    $sql .= "   t_aorder_h.client_cd2, \n";
    $sql .= "   t_aorder_h.client_cname, \n";
    $sql .= "   t_aorder_h.aord_id, \n";
    $sql .= "   t_aorder_h.ord_no AS aord_no, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   to_char(t_aorder_h.ord_time, 'yyyy-mm-dd') AS aord_day, \n";
    $sql .= "   t_aorder_h.arrival_day, \n";
    $sql .= "   t_aorder_d.goods_cd, \n";
    $sql .= "   t_aorder_d.official_goods_name, \n";
    $sql .= "   t_aorder_d.num AS aorder_num, \n";
    $sql .= "   COALESCE(t_sale_d.sale_num,0) AS sale_num, \n";
    $sql .= "   t_aorder_d.num - COALESCE(t_sale_d.sale_num,0) AS backlog_num, \n";
    $sql .= "   t_aorder_h.ware_name, \n";
    $sql .= "   t_aorder_h.check_flg, \n";
    $sql .= "   t_aorder_h.fc_ord_id, \n";
    $sql .= "   t_aorder_h.ps_stat, \n";
    $sql .= "   t_aorder_h.check_user_name, \n";
    $sql .= "   t_aorder_h.direct_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT  JOIN t_order_h  ON t_order_h.ord_id = t_aorder_h.fc_ord_id \n";
    $sql .= "   INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
    $sql .= "   LEFT  JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_sale_d.aord_d_id, \n";
    $sql .= "           SUM(t_sale_d.num) AS sale_num \n";
    $sql .= "       FROM \n";
    $sql .= "           t_sale_h \n";
    $sql .= "           INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_sale_h.shop_id = 1 \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_sale_d.aord_d_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_d \n";
    $sql .= "   ON t_aorder_d.aord_d_id = t_sale_d.aord_d_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.aord_id IN (";
    foreach ($ary_list_data as $key => $value){
    $sql .= $value["aord_id"];
    $sql .= ($key+1 < count($ary_list_data)) ? ", " : ") \n";
    }
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);

    // acquire the data within the page �ڡ�����ǡ�������
    $res        = Db_Query($db_con, $sql);
    $ary_data   = Get_Data($res, 2, "ASSOC");

}


/****************************/
// create the data for display ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    /****************************/
    // fix the data for display ɽ���ѥǡ�������
    /****************************/
    // loop with the data within the page �ڡ�����ǡ����ǥ롼��
    if (count($ary_data) > 0){
        // No.initial value No.�����
        $i = 0;
        // initial value of number of rows �Կ������
        $row = 0;
        // 
        $html_l = null;
        foreach ($ary_data as $key => $value){

            // Put the previous and next reference row to the variable for easy usability �������λ��ȹԤ��ѿ�������ƻȤ��䤹�����Ƥ���
            $back = $ary_data[$key-1];
            $next = $ary_data[$key+1];

            // ��No.�ν������� output setting for No.
            // When the first value of array, or the previous purchase order ID is different with the current one ����κǽ顢�ޤ�������Ⱥ����ȯ��ID���ۤʤ���
            if ($key == 0 || $back["aord_id"] != $value["aord_id"]){
                $no             = ++$i;
            }else{
                $no             = null;
            }
            // ��FC��Business partenr FC�������
            // No.�������� If there is a No.
            if ($no != null){
                $client         = $value["client_cd1"]."-".$value["client_cd2"];
                $client        .= "<br>";
                $client        .= htmlspecialchars($value["client_cname"]);
                $client        .= "<br>";
            }else{
                $client         = null;
            }
            // ��HQ Sales order number link ���������ֹ���
            // If there is a No. No.��������
            if ($no != null){
                // If there is a FC purchase order ID FCȯ��ID��������
                if ($value["fc_ord_id"] == null){
                    $aord_no_link   = "<a href=\"./1-2-101.php?aord_id=".$value["aord_id"]."\">".$value["aord_no"]."</a>";
                }else{
                    $aord_no_link   = "<a href=\"./1-2-110.php?aord_id=".$value["aord_id"]."\">".$value["aord_no"]."</a>";
                }
            }else{
                $aord_no_link    = null;
            }
            // ��FCȯ���ֹ� FC purchase order number 
            if ($no != null){
                $ord_no         = $value["ord_no"];
            }else{
                $ord_no         = null;
            }
            // ��ľ���� direct destination
            if ($no != null){
                $direct         = htmlspecialchars($value["direct_cname"]);
            }else{
                $direct         = null;
            }
            // �������� sales order date 
            if ($no != null){
                $aord_day       = $value["aord_day"];
            }else{
                $aord_day       = null;
            }
            // ���в�ͽ���� scheduled delivery date 
            if ($no != null){
                $arrival_day    = $value["arrival_day"];
            }else{
                $arrival_day    = null;
            }
            // ������ product 
            $goods              = $value["goods_cd"]."<br>".htmlspecialchars($value["official_goods_name"])."<br>";
            // ������� received number of units ordered
            $aorder_num         = $value["aorder_num"];
            // ���вٿ� number of shipping units
            $sale_num           = $value["sale_num"];
            // ������� remaining orders not fulfilled 
            $backlog_num        = $value["backlog_num"];
            // ���Ҹ� warehouse
            $ware_name          = htmlspecialchars($value["ware_name"]);
            // ������� sales link 
            if ($no != null){
                $sale_link      = "<a href=\"./1-2-201.php?aord_id=".$value["aord_id"]."\">����</a>";
            }else{
                $sale_link      = null;
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
            // No. No.
            $disp_data[$row]["no"]              = $no;
            // FC������� FC��Business Partner
            $disp_data[$row]["client"]          = $client;
            // ���������ֹ��� HQ Sales order number link
            $disp_data[$row]["aord_no_link"]    = $aord_no_link;
            // FCȯ���ֹ��� FC purchase order number link
            $disp_data[$row]["ord_no"]          = $ord_no;
            // ľ���� Direct destination
            $disp_data[$row]["direct"]          = $direct;
            // ������ Sales order date
            $disp_data[$row]["aord_day"]        = $aord_day;
            // �в�ͽ���� scheduled delivery date
            $disp_data[$row]["arrival_day"]     = $ord_no_link;
            // ���� Product
            $disp_data[$row]["goods"]           = $goods;
            // ����� received number of units ordered
            $disp_data[$row]["aorder_num"]      = $aorder_num;
            // �вٿ� number of units to be shipped
            $disp_data[$row]["sale_num"]        = $sale_num;
            // ����� number of orders not yet fulfilled 
            $disp_data[$row]["backlog_num"]     = $backlog_num;
            // �Ҹ� warehouse
            $disp_data[$row]["ware_name"]       = $ware_name;
            // ����� sales link
            $disp_data[$row]["sale_link"]       = $sale_link;

            // ����html���� create list HTML
            $html_l .= "    <tr class=\"$css\">\n";
            $html_l .= "        <td align=\"right\">$no</td>\n";
            $html_l .= "        <td>$client</td>\n";
            $html_l .= "        <td align=\"center\">$aord_no_link</td>\n";
            $html_l .= "        <td align=\"center\">$ord_no</td>\n";
            $html_l .= "        <td>$direct</td>\n";
            $html_l .= "        <td align=\"center\">$aord_day</td>\n";
            $html_l .= "        <td align=\"center\">$arrival_day</td>\n";
            $html_l .= "        <td>$goods</td>\n";
            $html_l .= "        <td align=\"right\">$aorder_num</td>\n";
            $html_l .= "        <td align=\"right\">$sale_num</td>\n";
            $html_l .= "        <td align=\"right\">$backlog_num</td>\n";
            $html_l .= "        <td>$ware_name</td>\n";
            $html_l .= "        <td align=\"center\" class=\"color\">$sale_link</td>\n";
            $html_l .= "    </tr>\n";

            // �Կ��û� add row number 
            $row++;

        }
    }

}


/****************************/
// HTML�����ʸ�������Create HTML (for search)
/****************************/
// ���̸����ơ��֥� common search table
$html_s .= Search_Table_Aord($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룱 Per module search table 1 
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">���������ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">FCȯ���ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룲 Per module search table 2
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_goods"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �ܥ��� button
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";

$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);


/****************************/
// HTML�إå� HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå� HTML footer 
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h("sale", "1");

/****************************/
// ���̥إå������� create screen header
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign assign form related variable 
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign assign other variables
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "total_count"   => "$total_count",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("row", $row_data);

$smarty->assign("html", array(
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
