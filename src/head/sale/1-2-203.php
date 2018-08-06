<?php
/**************************
//�ѹ�����
//����20060904��ʬ������ɽ��<watanabe-k>
//����20060916��CSV��SQL�ѹ�<kaji>
//    ������۹�פ�t_sale_d.sale_amount���ѹ�
//    ��UNION ALL�Τ��Ȥ˥��ڡ��������Τ��Ȥ�SQL���礹�뤢����˥ɥåȤ����줿
//
//
/**************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/10/31      08-005      ��          ɽ�����褦�Ȥ��Ƥ�����ɼ���������»ܺѤǤ�������ѥ⥸�塼������ܤ�����������ɲ�
 *  2006/11/06      08-007      suzuki      �ǡ�����������ݤˡ������������줿��Ƚ��
 *  2006/11/06      08-020      suzuki      ������ɤˤ����ɼ����ɻߤΤ��ᡢ��ɼ���������ɼ���������ȾȤ餷��碌��
 *  2006/11/06      08-113      suzuki      CSV���ϻ��θ�������ͭ���ˤ���
 *  2006/11/06      08-053      suzuki      �ޥ��ʥ���ۤ򸡺��Ǥ���褦�˽���
 *  2006/11/06      08-054      suzuki      ɽ�����������ˤ���CSV���ϤǤ���褦�˽���
 *  2006/11/08      08-129      suzuki      �������ά��ɽ��
 *  2006/11/09      08-134      suzuki      �ǹ���۸�����̤�CSV���ϤǤ���褦�˽���
 *  2006/11/09      08-135      suzuki      ��ɼ�ֹ渡���Ǥ���褦�˽���
 *  2006/12/07      ban_0048    suzuki      ���դΥ������
 *  2007/01/25                  watanabe-k  �ܥ���ο��ѹ�
 *  2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *  2007/03/01                  morita-d    CSV�������ʬ��ɽ�����ʤ��褦�˽��� 
 *  2007/03/05      ��ȹ���12  �դ���      �ݡ�����ι�פ����
 *  2007-04-05                  fukuda      ����������������ɲ�
 *  2007-05-24                  watanabe-k  �������ʤ����ˤ���ɼ�ֹ椬ɽ�������Х��ν���
 *  2007-06-21                  fukuda      ��׹Ԥγۤ�ܤȡݤ�ʬ��
 *  2007/06/23      ����¾275   kajioka-h   CSV�˸���ñ����������ۤ��ɲ�
 *  2007/07/23                  watanabe-k  ������ɽ������褦�˽���
 *  2007/07/23                  watanabe-k  CSV�˼����ʬ���θ������ۤ�ɽ������褦�˽��� 
 *  2007-07-13                  fukuda      �⥸�塼��̾������Ȳ�פ�������ʳ���˾Ȳ�פ��ѹ�
 *  2007-09-11                  watanabe-k  CSV�˴�����ʬ����Ϥ���褦�˽���
 *	2009-06-18		����No.36	aizawa-m	CSV�˾��ʥ����ɤ���Ϥ���褦����
 *  2009/09/28      �ʤ�        hashimoto-y �����ʬ�����Ͱ������ѻ�
 *
 */

$page_title = "���ʳ���˾Ȳ�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_output_type"      => "1",
    "form_client_branch"    => "",
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_sale_staff"       => array("cd" => "", "select" => ""),
    "form_ware"             => "",
    "form_claim"            => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_multi_staff"      => "",
    "form_sale_day"         => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_claim_day"        => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_renew"            => "1",
    "form_sale_amount"      => array("s" => "", "e" => ""),
    "form_slip_no"          => array("s" => "", "e" => ""),
    "form_aord_no"          => array("s" => "", "e" => ""),
    "form_goods"            => array("cd" => "", "name" => ""),
    "form_g_goods"          => "",
    "form_product"          => "",
    "form_g_product"        => "",
    "form_slip_type"        => "1",
    "form_slip_out"         => "1",
    "form_trade"            => "",
    "form_installment_day"  => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_shop"             => "2",
);

$ary_pass_list = array(
    "form_output_type"      => "1",
);

// �����������
Restore_Filter2($form, array("sale", "aord"), "form_show_button", $ary_form_list, $ary_pass_list);


/*****************************/
// �����ѿ�����
/*****************************/
$shop_id    = $_SESSION["client_id"];


/****************************/
// ����ͥ��å�
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/*****************************/
// �ե�����ѡ������
/*****************************/
/* ���̥ե����� */
Search_Form_Sale_H($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// ��������
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����ʤ�", "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤�»�",   "2");
$obj[]  =&  $form->createElement("radio", null, null, "�»ܺ�",   "3");
$form->addGroup($obj, "form_renew", "");

// �ǹ����
Addelement_Money_Range($form, "form_sale_amount", "�ǹ����");

// ��ɼ�ֹ�
Addelement_Slip_Range($form, "form_slip_no", "��ɼ�ֹ�");

// �����ֹ�
Addelement_Slip_Range($form, "form_aord_no", "�����ֹ�");

// ����
$obj    =   null;
$obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_goods", "", "");

// �Ͷ�ʬ
$item   =   null;
$item   =   Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods", "", $item, $g_form_option_select);

// ������ʬ
$item   =   null;
$item   =   Select_Get($db_con, "product");
$form->addElement("select", "form_product", "", $item, $g_form_option_select);

// ����ʬ��
$item   =   null;
$item   =   Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "", $item, $g_form_option_select);

// ��ɼȯ��
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����", "1");
$obj[]  =&  $form->createElement("radio", null, null, "ͭ",   "2");
$obj[]  =&  $form->createElement("radio", null, null, "����", "3");
$obj[]  =&  $form->createElement("radio", null, null, "̵",   "4");
$form->addGroup($obj, "form_slip_type", "");

// ȯ�Ծ���
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤ȯ��", "2");
$obj[]  =&  $form->createElement("radio", null, null, "ȯ�Ժ�", "3");
$form->addGroup($obj, "form_slip_out", "");

// �����ʬ
$item   =   null;
$item   =   Select_Get($db_con, "trade_sale");
#2009-09-28 hashimoto-y
#$form->addElement("select", "form_trade", "", $item, $g_form_option_select);

$trade_form=$form->addElement('select', 'form_trade', null, null, $g_form_option_select);

#�Ͱ������ѻ�
$select_value_key = array_keys($item);
for($i = 0; $i < count($item); $i++){
    if( $select_value_key[$i] != 14 && $select_value_key[$i] != 64){
        $trade_form->addOption($item[$select_value_key[$i]], $select_value_key[$i]);
    }
}
#print_r($item);


// ��������
Addelement_Date_Range($form, "form_installment_day", "", "-");

// ����о�
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "���۰ʳ�", "1");
$obj[]  =&  $form->createElement("radio", null, null, "����",     "2");
$form->addGroup($obj, "form_shop", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "FC������襳����",
    "sl_client_name"    => "FC�������̾",
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_sale_day"       => "���׾���",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_sale_day");

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����",
    "onClick=\"javascript: Which_Type('form_output_type', '1-2-207.php', '".$_SERVER["PHP_SELF"]."');\""
);

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ��ɼȯ�ԥܥ���
$form->addElement("button", "output_slip_button", "��ɼȯ��", "
    onClick=\"javascript: document.dateForm.elements['hdn_button'].value = '��ɼȯ��';
    Post_book_vote('./1-2-206.php', '".$_SERVER["PHP_SELF"]."');\"
");

// ��ȯ�ԥܥ���
$form->addElement("button", "output_re_slip_button", "��ȯ��", "
    onClick=\"javascript: document.dateForm.elements['hdn_button'].value = '��ȯ��';
    Post_book_vote('./1-2-206.php', '".$_SERVER["PHP_SELF"]."');\"
");

// �إå�����󥯥ܥ���
$form->addElement("button", "203_button", "�Ȳ��ѹ�", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");
$form->addElement("button", "201_button", "������", "onClick=\"javascript: Referer('1-2-201.php');\"");

// �����ե饰
$form->addElement("hidden", "del_id");                  // ������ID
$form->addElement("hidden", "data_delete_flg");         // ����ܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "hdn_del_enter_date");      // ��ɼ��������
$form->addElement("hidden", "slip_button_flg");         // ��ɼȯ�ԥܥ��󲡲��ե饰
$form->addElement("hidden", "re_slip_button_flg");      // ��ȯ�ԥܥ��󲡲��ե饰
$form->addElement("hidden", "hdn_button");              // ȯ�ԥܥ���β���������


/*****************************/
// �����󥯲�����
/*****************************/
if ($_POST["data_delete_flg"] == "true"){

    /*** �����Ĵ�� ***/
    // ���򤵤줿�ǡ��������ID�����
    $del_id = $_POST["del_id"];                     // ����������ID
    // ���򤵤줿�����ɼ�κ������������
    $enter_date = $_POST["hdn_del_enter_date"];

    // POST���줿������ID������������ɼ���������򸵤ˡ�Ĵ�٤�
    $valid_flg = Update_check($db_con, "t_sale_h", "sale_id", $del_id, $enter_date);

    // ������ɼ�ʤ��������¹�
    if ($valid_flg == true){

        // ����ID�����
        $sql        = "SELECT aord_id FROM t_sale_h WHERE sale_id = $del_id AND renew_flg = 'f';";
        $result     = Db_Query($db_con,$sql);
        $aord_id    = Get_Data($result);

        //������������Ƥ��뤫Ƚ��
        if ($aord_id != NULL){

             Db_Query($db_con, "BEGIN;");

            // �������鵯�����Ƥ�����Ͻ���������̤�����ˤ�ɤ��Ƥ�����
            if($aord_id[0][0] != NULL){
                $sql    = "UPDATE t_aorder_h SET ps_stat = '1' WHERE aord_id = ".$aord_id[0][0].";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, $sql);
                    exit;
                }
            }
            // ��������Ԥ���SQL
            $sql = "DELETE FROM t_sale_h WHERE sale_id = $del_id;";

            $result     = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            Db_Query($db_con, "COMMIT;");

        }else{

            $del_error_msg = "������������������ԤäƤ���ٺ���Ǥ��ޤ���";

        }

    }

    // ����ǡ���������
    $del_data["del_id"]             = "";                                   
    $del_data["hdn_del_enter_date"] = "";                                    
    $del_data["data_delete_flg"]    = "";                                    
    $form->setConstants($del_data);

    $post_flg = true;

}


/***************************/
// ��ɼȯ�ԡ���ȯ�ԥܥ��󲡲���
/***************************/
if ($_POST["hdn_button"] != null){

    // ��ɼ����ID��������
    $sale_id = null;

    // ��ɼȯ�ԥܥ��󲡲���
    if ($_POST["slip_button_flg"] == "true"){
        $ary_check_id = $_POST["slip_check"];
    // ��ȯ�ԥܥ��󲡲���
    }else{
        $ary_check_id = $_POST["re_slip_check"];
    }

    // �����å�����Ƥ�����ɼ��ID�򥫥�޶��ڤ��SQL�ǻ��ѡ�
    if (count($ary_check_id) > 0){
        $i = 0;
        while ($check_num = each($ary_check_id)){
            // ����ź����ID����Ѥ���
            $check = $check_num[0];
            if ($check_num[1] != null && $check_num[1] != "f"){
                if ($i == 0){
                    $sale_id = $ary_check_id[$check];
                }else{
                    $sale_id .= ", ".$ary_check_id[$check];
                }
                $i++;
            }
        }
    }

    // �����å�¸��Ƚ��
    if ($sale_id != null){
        // �����å�����
        $check_flg = true;
    }else{
        // �����å��ʤ�
        $output_error = "ȯ�Ԥ�����ɼ�����򤵤�Ƥ��ޤ���";
        $check_flg = false;
    }

    // �����å������ä����
    // ȯ�Ծ�����ȯ�����򹹿�
    if ($check_flg == true){

        Db_Query($db_con, "BEGIN;");

        $sql  = "UPDATE \n";
        $sql .= "   t_sale_h \n";
        $sql .= "SET \n";
        $sql .= "   slip_flg = 't', \n";
        $sql .= "   slip_out_day = NOW() \n";
        $sql .= "WHERE \n";
        $sql .= "   t_sale_h.sale_id IN ($sale_id) \n";
        $sql .= "AND \n";
        $sql .= "   slip_flg ='f' \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        if($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        Db_Query($db_con, "COMMIT;");

    }

    // hidden�򥯥ꥢ
    $clear_hdn["hdn_button"] = "";
    $form->setConstants($clear_hdn);

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲�����
/****************************/
if ($_POST["form_show_button"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_sale_day"]         = Str_Pad_Date($_POST["form_sale_day"]);
    $_POST["form_claim_day"]        = Str_Pad_Date($_POST["form_claim_day"]);
    $_POST["form_installment_day"]  = Str_Pad_Date($_POST["form_installment_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����ô����
    $err_msg = "���ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_sale_staff", $err_msg);

    // �����ô��ʣ������
    $err_msg = "���ô��ʣ������ �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // �����׾���
    $err_msg = "���׾��� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_sale_day", $err_msg);

    // ��������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_claim_day", $err_msg);

    // ���ǹ����
    $err_msg = "�ǹ���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_sale_amount", $err_msg);

    // ����������
    $err_msg = "�������� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_installment_day", $err_msg);

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();
    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_sale_day"]         = Str_Pad_Date($_POST["form_sale_day"]);
    $_POST["form_claim_day"]        = Str_Pad_Date($_POST["form_claim_day"]);
    $_POST["form_installment_day"]  = Str_Pad_Date($_POST["form_installment_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num        = $_POST["form_display_num"];
    $output_type        = $_POST["form_output_type"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $sale_staff_cd      = $_POST["form_sale_staff"]["cd"];
    $sale_staff_select  = $_POST["form_sale_staff"]["select"];
    $ware               = $_POST["form_ware"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $multi_staff        = $_POST["form_multi_staff"];
    $sale_day_sy        = $_POST["form_sale_day"]["sy"];
    $sale_day_sm        = $_POST["form_sale_day"]["sm"];
    $sale_day_sd        = $_POST["form_sale_day"]["sd"];
    $sale_day_ey        = $_POST["form_sale_day"]["ey"];
    $sale_day_em        = $_POST["form_sale_day"]["em"];
    $sale_day_ed        = $_POST["form_sale_day"]["ed"];
    $claim_day_sy       = $_POST["form_claim_day"]["sy"];
    $claim_day_sm       = $_POST["form_claim_day"]["sm"];
    $claim_day_sd       = $_POST["form_claim_day"]["sd"];
    $claim_day_ey       = $_POST["form_claim_day"]["ey"];
    $claim_day_em       = $_POST["form_claim_day"]["em"];
    $claim_day_ed       = $_POST["form_claim_day"]["ed"];
    $renew              = $_POST["form_renew"];
    $sale_amount_s      = $_POST["form_sale_amount"]["s"];
    $sale_amount_e      = $_POST["form_sale_amount"]["e"];
    $slip_no_s          = $_POST["form_slip_no"]["s"];
    $slip_no_e          = $_POST["form_slip_no"]["e"];
    $aord_no_s          = $_POST["form_aord_no"]["s"];
    $aord_no_e          = $_POST["form_aord_no"]["e"];
    $goods_cd           = $_POST["form_goods"]["cd"];
    $goods_name         = $_POST["form_goods"]["name"];
    $g_goods            = $_POST["form_g_goods"];
    $product            = $_POST["form_product"];
    $g_product          = $_POST["form_g_product"];
    $slip_type          = $_POST["form_slip_type"];
    $slip_out           = $_POST["form_slip_out"];
    $trade              = $_POST["form_trade"];
    $installment_day_sy = $_POST["form_installment_day"]["sy"];
    $installment_day_sm = $_POST["form_installment_day"]["sm"];
    $installment_day_sd = $_POST["form_installment_day"]["sd"];
    $installment_day_ey = $_POST["form_installment_day"]["ey"];
    $installment_day_em = $_POST["form_installment_day"]["em"];
    $installment_day_ed = $_POST["form_installment_day"]["ed"];
    $shop               = $_POST["form_shop"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    /* WHERE */
    $sql = null;

    // FC������襳����1
    $sql .= ($client_cd1 != null) ? "AND t_sale_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // FC������襳����2
    $sql .= ($client_cd2 != null) ? "AND t_sale_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // FC�������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_sale_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_sale_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_sale_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ���ô���ԥ�����
    $sql .= ($sale_staff_cd != null) ? "AND t_staff.charge_cd = '$sale_staff_cd' \n" : null;
    // ���ô���ԥ��쥯��
    $sql .= ($sale_staff_select != null) ? "AND t_staff.staff_id = $sale_staff_select \n" : null;
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_sale_h.ware_id = $ware \n" : null;
    // �����襳���ɣ�   
    $sql .= ($claim_cd1 != null) ? "AND t_client_claim.client_cd1 LIKE '$claim_cd1%' \n" : null;
    // �����襳���ɣ�
    $sql .= ($claim_cd2 != null) ? "AND t_client_claim.client_cd2 LIKE '$claim_cd2%' \n" : null;
    // ������̾
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
    // ���ô��ʣ������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // ���׾����ʳ��ϡ�
    $sale_day_s  = $sale_day_sy."-".$sale_day_sm."-".$sale_day_sd;
    $sql .= ($sale_day_s != "--") ? "AND '$sale_day_s' <= t_sale_h.sale_day \n" : null;
    // ���׾����ʽ�λ��
    $sale_day_e  = $sale_day_ey."-".$sale_day_em."-".$sale_day_ed;
    $sql .= ($sale_day_e != "--") ? "AND t_sale_h.sale_day <= '$sale_day_e' \n" : null;
    // �������ʳ��ϡ�
    $claim_day_s  = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd;
    $sql .= ($claim_day_s != "--") ? "AND t_sale_h.claim_day >= '$claim_day_s' \n" : null; 
    // �������ʽ�λ��
    $claim_day_e  = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed;
    $sql .= ($claim_day_e != "--") ? "AND t_sale_h.claim_day <= '$claim_day_e' \n" : null; 
    // ��������
    if ($renew == "2"){
        $sql .= "AND t_sale_h.renew_flg = 'f' \n";
    }else
    if ($renew == "3"){
        $sql .= "AND t_sale_h.renew_flg = 't' \n";
    }
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($slip_no_s != null) ? "AND t_sale_h.sale_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($slip_no_e != null) ? "AND t_sale_h.sale_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // �����ֹ�ʳ��ϡ�
    $sql .= ($aord_no_s != null) ? "AND t_aorder_h.ord_no >= '".str_pad($aord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // �����ֹ�ʽ�λ��
    $sql .= ($aord_no_e != null) ? "AND t_aorder_h.ord_no <= '".str_pad($aord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null; 
    // ���ʥ�����
    if ($goods_cd != null){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_sale_h.sale_id FROM t_sale_h \n";
        $sql .= "       INNER JOIN t_sale_d ON  t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "                           AND t_sale_d.goods_cd LIKE '$goods_cd%' \n";
        $sql .= "       GROUP BY t_sale_h.sale_id \n";
        $sql .= "   ) \n";
    }
    // ����̾
    if ($goods_name != null){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_sale_h.sale_id FROM t_sale_h \n";
        $sql .= "       INNER JOIN t_sale_d ON  t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "                           AND t_sale_d.official_goods_name LIKE '%$goods_name%' \n";
        $sql .= "       GROUP BY t_sale_h.sale_id \n";
        $sql .= "   ) \n";
    }
    // �Ͷ�ʬ
    if ($g_goods != null){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_sale_h.sale_id FROM t_sale_h \n";
        $sql .= "       INNER JOIN t_sale_d ON  t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_sale_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_goods_id = $g_goods \n";
        $sql .= "       GROUP BY t_sale_h.sale_id \n";
        $sql .= "   ) \n";
    }
    // ������ʬ
    if ($product != null){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_sale_h.sale_id FROM t_sale_h \n";
        $sql .= "       INNER JOIN t_sale_d ON  t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_sale_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.product_id = $product \n";
        $sql .= "       GROUP BY t_sale_h.sale_id \n";
        $sql .= "   ) \n";
    }
    // ����ʬ��
    if ($g_product != null){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_sale_h.sale_id FROM t_sale_h \n";
        $sql .= "       INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_sale_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_product_id = $g_product \n";
        $sql .= "       GROUP BY t_sale_h.sale_id \n";
        $sql .= "   ) \n";
    }
/*
    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_sale_d.goods_cd LIKE '$goods_cd%' " : null;
    // ����̾
    $sql .= ($goods_name != null) ? "AND t_sale_d.official_goods_name LIKE '%$goods_name%' \n" : null;
    // �Ͷ�ʬ
    $sql .= ($g_goods != null) ? "AND t_g_goods.g_goods_id = $g_goods \n" : null;
    // ������ʬ
    $sql .= ($product != null) ? "AND t_product.product_id = $product \n" : null;
    // ����ʬ��
    $sql .= ($g_product != null) ? "AND t_g_product.g_product_id = $g_product \n" : null;
*/
    // ��ɼȯ��
    if ($slip_type == "2"){
        $sql .= "AND t_sale_h.slip_out = '1' \n";
    }else
    if ($slip_type == "3"){
        $sql .= "AND t_sale_h.slip_out = '2' \n";
    }else
    if ($slip_type == "4"){
        $sql .= "AND t_sale_h.slip_out = '3' \n";
    }
    // ȯ�Ծ���
    if ($slip_out == "2"){
        $sql .= "AND t_sale_h.slip_flg = 'f' \n";
    }else
    if ($slip_out == "3"){
        $sql .= "AND t_sale_h.slip_flg = 't' \n";
    }
    // �����ʬ
    $sql .= ($trade != null) ? "AND t_sale_h.trade_id = $trade \n" : null;
    // ���������ʳ��ϡ�
    // ���������ʽ�λ��
    $installment_day_s  = $installment_day_sy."-".$installment_day_sm."-".$installment_day_sd;
    $installment_day_e  = $installment_day_ey."-".$installment_day_em."-".$installment_day_ed;
    if ($installment_day_s != "--" || $installment_day_e != "--"){
        $sql .= "AND \n";
        $sql .= "   t_sale_h.sale_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           sale_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_installment_sales \n";
        $sql .= "       WHERE \n";
        $sql .= "           sale_id IS NOT NULL \n";
        $sql .= ($installment_day_s != "--") ? "       AND collect_day >= '$installment_day_s' \n" : null;
        $sql .= ($installment_day_e != "--") ? "       AND collect_day <= '$installment_day_e' \n" : null;
        $sql .= "       GROUP BY \n";
        $sql .= "           sale_id \n";
        $sql .= "   ) \n";
    }

    // �ѿ��ͤ��ؤ���CSV�����ѡ�
    $csv_where_sql = $sql;

    // �ǹ���ۡʳ��ϡ�
    if ($sale_amount_s != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "               THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
        $sql .= "               ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
        $sql .= "           END \n";
        $sql .= "   ) \n";
        $sql .= "   >= $sale_amount_s \n";
    }
    // �ǹ���ۡʽ�λ��
    if ($sale_amount_e != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "               THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
        $sql .= "               ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
        $sql .= "           END \n";
        $sql .= "   ) \n";
        $sql .= "   <= $sale_amount_e \n";
    }
    // ����о�
    if ($shop == "1"){
        $sql .= "AND t_sale_h.client_id != 93 \n";
    }

    // �ѿ��ͤ��ؤ��ʲ��̽����ѡ�
    $disp_where_sql = $sql;


    /* HAVING */

    $sql = null;

    // �ǹ���ۡʳ��ϡ� 
    if ($sale_amount_s != null){
        $sql  = "HAVING \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
        $sql .= "                   ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "   ) \n";
        $sql .= "   >= $sale_amount_s \n";
    }
    // �ǹ���ۡʽ�λ��
    if ($sale_amount_e != null){
        $sql .= ($sale_amount_s == null) ? "HAVING \n" : "AND \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
        $sql .= "                   ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "   ) \n";
        $sql .= "   <= $sale_amount_e \n";
    }

    // �ѿ��ͤ��ؤ���CSV�ѡ�
    $csv_having_sql = $sql;


    /* ORDER BY */
    $sql = null;

    // ���̽���
    // CSV����
    if ($output_type == "1" || $output_type == "3"){

        switch ($_POST["hdn_sort_col"]){
            // �����襳����
            case "sl_client_cd":
                $sql .= "   t_sale_h.client_cd1, \n";
                $sql .= "   t_sale_h.client_cd2, \n";
                $sql .= "   t_sale_h.sale_day, \n";
                $sql .= "   t_sale_h.sale_no \n";
                break;
            // ������̾
            case "sl_client_name":
                $sql .= "   t_sale_h.client_cname, \n";
                $sql .= "   t_sale_h.sale_day, \n";
                $sql .= "   t_sale_h.sale_no, \n";
                $sql .= "   t_sale_h.client_cd1, \n";
                $sql .= "   t_sale_h.client_cd2 \n";
                break;
            // ��ɼ�ֹ�
            case "sl_slip":
                $sql .= "   t_sale_h.sale_no \n";
                break;
            // ���׾���
            case "sl_sale_day":
                $sql .= "   t_sale_h.sale_day, \n";
                $sql .= "   t_sale_h.sale_no, \n";
                $sql .= "   t_sale_h.client_cd1, \n";
                $sql .= "   t_sale_h.client_cd2 \n";
                break;
        }

    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // ���̽��ϻ�
    if ($output_type == "1"){

        $sql  = "SELECT \n";
        $sql .= "   t_sale_h.sale_id, \n";              // ���ID
        $sql .= "   t_sale_h.sale_no, \n";              // ��ɼ�ֹ�
        $sql .= "   t_sale_h.client_cd1, \n";           // FC������襳���ɣ�
        $sql .= "   t_sale_h.client_cd2, \n";           // FC������襳���ɣ�
        $sql .= "   t_sale_h.client_cname, \n";         // FC�������̾
        $sql .= "   t_sale_h.sale_day, \n";             // ���׾���
        $sql .= "   t_sale_h.trade_id, \n";             // �����ʬID
        $sql .= "   t_trade.trade_name, \n";            // �����ʬ
        $sql .= "   ( \n";
        $sql .= "       CASE \n";
        $sql .= "           WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "           THEN (t_sale_h.net_amount) *  1 \n";
        $sql .= "           ELSE (t_sale_h.net_amount) * -1 \n";
        $sql .= "       END \n";
        $sql .= "   ) AS notax_amount, \n";             // ��ȴ���
        $sql .= "   ( \n";
        $sql .= "       CASE \n";
        $sql .= "           WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "           THEN (t_sale_h.tax_amount) *  1 \n";
        $sql .= "           ELSE (t_sale_h.tax_amount) * -1 \n";
        $sql .= "       END \n";
        $sql .= "   ) AS tax_amount, \n";               // �����ǳ�
        $sql .= "   ( \n";
        $sql .= "       CASE \n";
        $sql .= "           WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "           THEN (t_sale_h.net_amount + t_sale_h.tax_amount) *  1 \n";
        $sql .= "           ELSE (t_sale_h.net_amount + t_sale_h.tax_amount) * -1 \n";
        $sql .= "       END \n";
        $sql .= "   ) AS sale_amount, \n";              // �ǹ����
        $sql .= "   t_aorder_h.aord_id, \n";            // ����ID
        $sql .= "   t_aorder_h.ord_no, \n";             // �����ֹ�
        $sql .= "   t_sale_h.total_split_num, \n";      // ʬ����
        $sql .= "   t_sale_h.enter_day, \n";            // ��������
        $sql .= "   t_sale_h.renew_flg, \n";            // ���������ե饰
        $sql .= "   to_char(t_sale_h.renew_day, 'yyyy-mm-dd') AS renew_day, \n";

        $sql .= "   ( \n";
        $sql .= "       CASE \n";
        $sql .= "           WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "           THEN (t_sale_h.cost_amount) * 1 \n";
        $sql .= "           ELSE (t_sale_h.cost_amount) * -1 \n";
        $sql .= "       END \n";
        $sql .= "   ) AS cost_amount, ";
                                                        // ����������
        $sql .= "   t_sale_h.slip_out, \n";             // ��ɼ����
        $sql .= "   t_sale_h.slip_flg, \n";             // ȯ�Ծ���
        $sql .= "   t_sale_h.slip_out_day \n";          // ��ɼȯ����
        $sql .= "FROM \n";
        $sql .= "   t_sale_h \n";
        $sql .= "   LEFT  JOIN t_aorder_h                 ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
        $sql .= "   LEFT  JOIN t_client AS t_client_claim ON t_sale_h.claim_id = t_client_claim.client_id \n";
        $sql .= "   LEFT  JOIN t_staff                    ON t_sale_h.c_staff_id = t_staff.staff_id \n";
        $sql .= "   LEFT  JOIN t_trade                    ON t_sale_h.trade_id = t_trade.trade_id \n";
/*
        if ($goods_cd != null || $goods_name != null || $g_goods != null || $product != null || $g_product != null){
        $sql .= "   INNER JOIN t_sale_d     ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "   INNER JOIN t_goods      ON t_sale_d.goods_id = t_goods.goods_id \n";
        }
        if ($g_goods != null){
        $sql .= "   INNER JOIN t_g_goods    ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
        }
        if ($product != null){
        $sql .= "   INNER JOIN t_product    ON t_goods.product_id = t_product.product_id \n";
        }
        if ($g_product != null){
        $sql .= "   INNER JOIN t_g_product  ON t_goods.g_product_id = t_g_product.g_product_id \n";
        }
*/
        $sql .= "WHERE \n";
        $sql .= "   t_sale_h.shop_id = 1 \n";
        $sql .= $disp_where_sql;
        $sql .= "ORDER BY \n";
        $sql .= $order_sql;

    // CSV���ϻ�
    }elseif ($output_type == "3"){

        $sql  = "SELECT \n";
        $sql .= "   t_sale_h.client_cd1 || '-' || t_sale_h.client_cd2, \n";
        $sql .= "   t_sale_h.client_cname, \n";
        $sql .= "   t_sale_h.sale_no, \n";
        $sql .= "   t_sale_h.sale_day, \n";
        $sql .= "   t_sale_h.claim_day, \n";
        $sql .= "   t_sale_h.trade_name, \n";
        $sql .= "   t_sale_h.direct_cname, \n";
        $sql .= "   t_sale_h.trans_name, \n";
        $sql .= "   t_sale_h.ware_name, \n";
        $sql .= "   t_sale_h.c_staff_name, \n";
        $sql .= "   t_product.product_name, \n";
		//-- 2009/06/18 ����No.36 �ɲ�
		// ���ʥ�����
		$sql .= "	t_sale_d.goods_cd, \n";
		//--
        $sql .= "   t_sale_d.official_goods_name, \n";

        $sql .= "   CASE \n";
        $sql .= "       WHEN t_sale_h.trade_id IN (13, 63) THEN t_sale_d.num * -1 \n";
        $sql .= "       ELSE t_sale_d.num \n";
        $sql .= "   END AS num, \n";

        $sql .= "   CASE \n";
        $sql .= "       WHEN t_sale_h.trade_id IN (14, 64) THEN t_sale_d.cost_price * -1 \n";
        $sql .= "       ELSE t_sale_d.cost_price \n";
        $sql .= "   END AS cost_price, \n";

        $sql .= "   CASE \n";
        $sql .= "       WHEN t_sale_h.trade_id IN (14,13,64,63) THEN t_sale_d.cost_amount * -1 \n";
        $sql .= "       ELSE t_sale_d.cost_amount \n";
        $sql .= "   END AS cost_amount, \n";

        $sql .= "   CASE \n";
        $sql .= "       WHEN t_sale_h.trade_id IN (14,64) THEN t_sale_d.sale_price * -1\n";
        $sql .= "       ELSE t_sale_d.sale_price \n";
        $sql .= "   END AS sale_price, \n";

        $sql .= "   CASE \n";
        $sql .= "       WHEN t_sale_h.trade_id IN (14,13,64,63) THEN t_sale_d.sale_amount * -1 \n";
        $sql .= "       ELSE t_sale_d.sale_amount \n";
        $sql .= "   END AS sale_amount, \n";


        $sql .= "   CASE t_sale_h.total_split_num \n";
        $sql .= "       WHEN 1 THEN NULL \n";
        $sql .= "       ELSE t_sale_h.total_split_num \n";
        $sql .= "   END AS total_split_num, \n";
        $sql .= "   t_sale_h.slip_out_day, \n";
        $sql .= "   t_sale_h.renew_day \n";
        $sql .= "FROM \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_sale_h.sale_id, \n";
        $sql .= "           t_sale_h.client_cd1, \n";
        $sql .= "           t_sale_h.client_cd2, \n";
        $sql .= "           t_sale_h.client_cname, \n";
        $sql .= "           t_sale_h.sale_no, \n";
        $sql .= "           t_sale_h.sale_day, \n";
        $sql .= "           t_sale_h.claim_day, \n";
        $sql .= "           t_trade.trade_id, \n";
        $sql .= "           t_trade.trade_name, \n";
        $sql .= "           t_sale_h.direct_cname, \n";
        $sql .= "           t_sale_h.trans_name, \n";
        $sql .= "           t_sale_h.ware_name, \n";
        $sql .= "           t_sale_h.c_staff_name, \n";
        $sql .= "           sum(t_sale_h.net_amount + t_sale_h.tax_amount) AS total_amount, \n";
        $sql .= "           t_sale_h.total_split_num, \n";
        $sql .= "           t_sale_h.slip_out_day, \n";
        $sql .= "           to_char(t_sale_h.renew_day, 'yyyy-mm-dd') AS renew_day \n";
        $sql .= "       FROM \n";
        $sql .= "           t_sale_h \n";
        $sql .= "           LEFT  JOIN t_aorder_h                 ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
        $sql .= "           LEFT  JOIN t_client AS t_client_claim ON t_sale_h.claim_id = t_client_claim.client_id \n";
        $sql .= "           LEFT  JOIN t_staff                    ON t_sale_h.c_staff_id = t_staff.staff_id \n";
        $sql .= "           LEFT  JOIN t_trade                    ON t_sale_h.trade_id = t_trade.trade_id \n";
        $sql .= "           INNER JOIN t_sale_d                   ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_sale_h.shop_id = 1 \n";
        $sql .= $csv_where_sql;
        $sql .= "       GROUP BY \n";
        $sql .= "           t_sale_h.sale_id, \n";
        $sql .= "           t_sale_h.sale_day, \n";
        $sql .= "           t_sale_h.sale_no, \n";
        $sql .= "           t_sale_h.client_cname, \n";
        $sql .= "           t_sale_h.client_cd1, \n";
        $sql .= "           t_sale_h.client_cd2, \n";
        $sql .= "           t_sale_h.total_split_num, \n";
        $sql .= "           t_aorder_h.ord_no, \n";
        $sql .= "           t_aorder_h.aord_id, \n";
        $sql .= "           t_sale_h.renew_flg, \n";
        $sql .= "           t_sale_h.renew_day, \n";
        $sql .= "           t_sale_h.claim_day, \n";
        $sql .= "           t_trade.trade_id, \n";
        $sql .= "           t_trade.trade_name, \n";
        $sql .= "           t_sale_h.direct_cname, \n";
        $sql .= "           t_sale_h.trans_name, \n";
        $sql .= "           t_sale_h.ware_name, \n";
        $sql .= "           t_sale_h.c_staff_name, \n";
        $sql .= "           t_sale_h.slip_out_day \n";
        $sql .= $csv_having_sql;
        $sql .= "   ) \n";
        $sql .= "   AS t_sale_h \n";
        $sql .= "   INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "   INNER JOIN t_goods                    ON t_sale_d.goods_id = t_goods.goods_id \n";
        $sql .= "   INNER JOIN t_product                  ON t_goods.product_id = t_product.product_id \n";
        $sql .= "ORDER BY \n";
        $sql .= $order_sql;

    }

    // ���������
    $total_result   = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($total_result);

    // ɽ�����
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;
        case "2":
            $limit = "100";
            break;
    }

    // �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
    if($page_count != null){
        // �Ժ����total_count��offset�δط������줿���
        if ($total_count <= $offset){
            // ���ե��åȤ����������
            $offset     = $offset - $limit;
            // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
            $page_count = $page_count - 1;
            // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }   
    }else{ 
        $offset = 0;
    }

    // LIMITSQL
    $sql .= ($output_type == "1") ? "LIMIT $limit OFFSET $offset " : null;

    $result     = Db_Query($db_con, $sql.";");
    $data_num   = pg_num_rows($result);
    $page_data  = Get_Data($result, 2, "ASSOC");

}


/****************************/
// CSV����
/****************************/
if ($post_flg == true && $err_flg != true && $output_type == "3"){

    $page_data  = Get_Data($total_result, 2);

    // �ե�����̾
    $csv_file_name = "������ٰ���.csv";

    //CSV�إå�����
    $csv_header = array(
        "�����襳����",
        "������̾",
        "��ɼ�ֹ�",
        "���׾���",
        "������",
        "�����ʬ",
        "ľ����̾",
        "�����ȼ�̾",
        "�в��Ҹ�̾",
        "���ô����",
        "������ʬ",
		//-- 2009/06/18 ����No.36 �ɲ�
		"���ʥ�����",
		//--
        "����̾",
        "����",
        "����ñ��",
        "�������",
        "���ñ��",
        "�����",
        "ʬ����",
        "�����ɼȯ����",
        "����������",
    );

    //CSV�ǡ�������
    for($i=0;$i<count($page_data);$i++){
        $sale_data[$i][0]  = $page_data[$i][0];
        $sale_data[$i][1]  = $page_data[$i][1];
        $sale_data[$i][2]  = $page_data[$i][2];
        $sale_data[$i][3]  = $page_data[$i][3];
        $sale_data[$i][4]  = $page_data[$i][4];
        $sale_data[$i][5]  = $page_data[$i][5];
        $sale_data[$i][6]  = $page_data[$i][6];
        $sale_data[$i][7]  = $page_data[$i][7];
        $sale_data[$i][8]  = $page_data[$i][8];
        $sale_data[$i][9]  = $page_data[$i][9];
        $sale_data[$i][10] = $page_data[$i][10];
        $sale_data[$i][11] = $page_data[$i][11];
        $sale_data[$i][12] = $page_data[$i][12];
        $sale_data[$i][13] = $page_data[$i][13];
        $sale_data[$i][14] = $page_data[$i][14];
        $sale_data[$i][15] = $page_data[$i][15];
        $sale_data[$i][16] = $page_data[$i][16];
        $sale_data[$i][17] = $page_data[$i][17];
        $sale_data[$i][18] = $page_data[$i][18];
        $sale_data[$i][19] = $page_data[$i][19];
		//-- 2009/06/18 ����No.36 �ɲ�
        $sale_data[$i][20] = $page_data[$i][20];
		//-- 
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($sale_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


/****************************/
// HTML�Ѵؿ�
/****************************/
function Number_Format_Color($num){
    return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num)."</span>" : number_format($num);
}


/****************************/
// HTML�����ʰ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    /* �ڡ���ʬ�� */
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    $html_l = null;

    // �����ǡ����ǥ롼��
    if (count($page_data) > 0){
        foreach ($page_data as $key => $value){

            /* ������ */
            // �Կ�css
            $row_color      = (bcmod($key, 2) == 0) ? "Result1" : "Result2";
            // No.
            $no             = $page_count * $limit - $limit + 1 + $key;
            // FC�������
            $client         = $value["client_cd1"]."-".$value["client_cd2"]."<br>".htmlspecialchars($value["client_cname"])."<br>";
            // ��ɼ�ֹ���
            if ($value["renew_flg"] == "t"){
                $slip_no_link   = "<a href=\"./1-2-205.php?sale_id=".$value["sale_id"]."&slip_flg=true\">".$value["sale_no"]."</a>";
            }else{
                $slip_no_link   = "<a href=\"./1-2-201.php?sale_id=".$value["sale_id"]."\">".$value["sale_no"]."</a>";
            }
            // �����ֹ���
            if ($value["aord_id"] != null){
                $aord_no_link   = "<a href=\"./1-2-108.php?aord_id=".$value["aord_id"]."\">".$value["ord_no"]."</a>";
            }else{
                $aord_no_link   = null;
            }
            // ʬ�������
            if ($value["trade_id"] == "15"){
                $split_link     = "<a href=\"./1-2-208.php?sale_id=".$value["sale_id"]."&division_flg=true\">".$value["total_split_num"]."��</a>";
            }else{
                $split_link     = null;
            }
            // ������
            if ($value["renew_flg"] == "f" && $disabled == null){
                $del_link       = "<a href=\"#\" onClick=\"Order_Delete";
                $del_link      .= "('data_delete_flg', 'del_id', ".$value["sale_id"].", 'hdn_del_enter_date', '".$value["enter_day"]."');";
                $del_link      .= "\">���</a>";
            }else{
                $del_link       = null;
            }
            /*
            ���
                �����ʲ�������Ƥ˳���������ɼ�Τ���ɼȯ�Բ�ǽ
                    ����ɼȯ��"ͭ"�ʵ��̾���ɼ��
                �����嵭��狼��ȯ�Ծ�����"ȯ�Ժ�"�ξ��ϡֺ�ȯ�ԡפ�ȯ��
                ������ɼȯ��"̵"����ɼȯ�Ԥ��ʤ�
            */
            // �����ɼȯ�ԥ����å�
            // ��ɼȯ��"ͭ"��̤ȯ��
            if ($value["slip_out"] == "1" && $value["slip_flg"] == "f"){
                $form->addElement("advcheckbox", "slip_check[$key]", null, null, null, array(null, $value["sale_id"]));
                $slip_print[$key]   = "print";
                $slip_data[$key]    = $value["sale_id"];
                $ckear_check["slip_check[$key]"] = "";
            }else
            // ��ɼȯ��"ͭ"��ȯ�Ժ�
            if ($value["slip_out"] == "1" && $value["slip_flg"] == "t"){
                $form->addElement("static", "output_day[$key]", "", $value["slip_out_day"]);
                $slip_print[$key]   = "output_day";
            }else{
            }
            // ��ȯ�ԥ����å�
            // ��ɼȯ��"ͭ"��̤ȯ��
            if ($value["slip_out"] == "1" && $value["slip_flg"] == "t"){
                $form->addElement("advcheckbox", "re_slip_check[$key]", null, null, null, array(null, $value["sale_id"]));
                $re_slip_print[$key]= "print";
                $re_slip_data[$key] = $value["sale_id"];
                $ckear_check["re_slip_check[$key]"] = "";
            }

            /* ����html���� */
            $html_l .= "<tr class=\"$row_color\">\n";
            $html_l .= "    <td align=\"right\">$no</td>\n";
            $html_l .= "    <td>$client</td>\n";
            $html_l .= "    <td align=\"center\">$slip_no_link</td>\n";
            $html_l .= "    <td align=\"center\">".$value["sale_day"]."</td>\n";
            $html_l .= "    <td align=\"center\">".$value["trade_name"]."</td>\n";
            $html_l .= "    <td align=\"right\">".Number_Format_Color($value["cost_amount"])."</td>\n";
            $html_l .= "    <td align=\"right\">".Number_Format_Color($value["notax_amount"])."</td>\n";
            $html_l .= "    <td align=\"right\">".Number_Format_Color($value["tax_amount"])."</td>\n";
            $html_l .= "    <td align=\"right\">".Number_Format_Color($value["sale_amount"])."</td>\n";
            $html_l .= "    <td align=\"center\">$aord_no_link</td>\n";
            $html_l .= "    <td align=\"center\">$split_link</td>\n";
            $html_l .= "    <td align=\"center\">$del_link</td>\n";
            $html_l .= "    <td align=\"center\">".$value["renew_day"]."</td>\n";
            if ($slip_print[$key] == "print"){
            $html_l .= "    <td align=\"center\">".$form->_elements[$form->_elementIndex["slip_check[$key]"]]->toHtml()."</td>\n";
            }else
            if ($slip_print[$key] == "output_day"){
            $html_l .= "    <td align=\"center\">".$form->_elements[$form->_elementIndex["output_day[$key]"]]->toHtml()."</td>\n";
            }else{
            $html_l .= "    <td></td>\n";
            }
            if ($re_slip_print[$key] == "print"){
            $html_l .= "    <td align=\"center\">".$form->_elements[$form->_elementIndex["re_slip_check[$key]"]]->toHtml()."</td>\n";
            }else{
            $html_l .= "    <td></td>\n";
            }
            $html_l .= "</tr>\n";

            /* ��ץơ��֥��Ѥ˶�۲û� */
            switch ($value["trade_id"]){
                case "11":
                case "15":
                case "13":
                case "14":
                    $kake_notax_amount      += $value["notax_amount"];
                    $kake_tax_amount        += $value["tax_amount"];
                    $kake_ontax_amount      += $value["sale_amount"];
                    break;
                case "61":
                case "63":
                case "64":
                    $genkin_notax_amount    += $value["notax_amount"];
                    $genkin_tax_amount      += $value["tax_amount"];
                    $genkin_ontax_amount    += $value["sale_amount"];
                    break;
            }

            /* ��׹��Ѥ˶�۲û� */
            switch ($value["trade_id"]){
                case "11":
                case "15":
                    $gross_notax_amount     += $value["notax_amount"];
                    $gross_tax_amount       += $value["tax_amount"];
                    $gross_ontax_amount     += $value["sale_amount"];
                    $gross_cost_amount      += $value["cost_amount"];
                    break;
                case "13":
                case "14":
                    $minus_notax_amount     += $value["notax_amount"];
                    $minus_tax_amount       += $value["tax_amount"];
                    $minus_ontax_amount     += $value["sale_amount"];
                    $minus_cost_amount      += $value["cost_amount"];
                    break;
                case "61":
                    $gross_notax_amount     += $value["notax_amount"];
                    $gross_tax_amount       += $value["tax_amount"];
                    $gross_ontax_amount     += $value["sale_amount"];
                    $gross_cost_amount      += $value["cost_amount"];
                    break;
                case "63":
                case "64":
                    $minus_notax_amount     += $value["notax_amount"];
                    $minus_tax_amount       += $value["tax_amount"];
                    $minus_ontax_amount     += $value["sale_amount"];
                    $minus_cost_amount      += $value["cost_amount"];
                    break;
            }

        }
    }

    // �����å��ܥå����Υ����å��򥯥ꥢ
    $clear_check["slip_check_all"]      = "";
    $clear_check["re_slip_check_all"]   = "";
    $form->setConstants($clear_check);

    // �ݤȸ���ι�׻���
    $notax_amount   = $kake_notax_amount + $genkin_notax_amount;
    $tax_amount     = $kake_tax_amount   + $genkin_tax_amount;
    $ontax_amount   = $kake_ontax_amount + $genkin_ontax_amount;
    $cost_amount    = $gross_cost_amount + $minus_cost_amount;

    // ����html�եå�
    $html_m  = "    <tr class=\"Result3\">\n";
    $html_m .= "        <td><b>���</b></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td align=\"right\">\n";
    $html_m .= "            ".Numformat_Ortho($gross_cost_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($minus_cost_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($cost_amount)."<br>\n";
    $html_m .= "        </td>\n";
    $html_m .= "        <td align=\"right\">\n";
    $html_m .= "            ".Numformat_Ortho($gross_notax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($minus_notax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($notax_amount)."<br>\n";
    $html_m .= "        </td>\n";
    $html_m .= "        <td align=\"right\">\n";
    $html_m .= "            ".Numformat_Ortho($gross_tax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($minus_tax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($tax_amount)."<br>\n";
    $html_m .= "        </td>\n";
    $html_m .= "        <td align=\"right\">\n";
    $html_m .= "            ".Numformat_Ortho($gross_ontax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($minus_ontax_amount)."<br>\n";
    $html_m .= "            ".Numformat_Ortho($ontax_amount)."<br>\n";
    $html_m .= "        </td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m .= "        <td></td>\n";
    $html_m1  = $html_m;
    $html_m1 .= "        <td></td>\n";
    $html_m1 .= "        <td></td>\n";
    $html_m1 .= "    </tr>\n";
    $html_m2  = $html_m;
    $html_m2 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["output_slip_button"]]->toHtml()."</td>\n";
    $html_m2 .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["output_re_slip_button"]]->toHtml()."</td>\n";
    $html_m2 .= "    </tr>\n";

    // ȯ��ALL�����å��ե��������
    $form->addElement("checkbox", "slip_check_all",    "", "�����ɼȯ��", "onClick=\"javascript:All_Check_Slip('slip_check_all');\"");
    $form->addElement("checkbox", "re_slip_check_all", "", "��ȯ��",       "onClick=\"javascript:All_Check_Re_Slip('re_slip_check_all');\"");

    // �嵭ALL�����å��ե�������js�����
    $javascript .= Create_Allcheck_Js("All_Check_Slip",    "slip_check",    $slip_data);
    $javascript .= Create_Allcheck_Js("All_Check_Re_Slip", "re_slip_check", $re_slip_data);

    // ����html�إå�
    $html_h  = "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_h .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">\n";
    $html_h .= "            ".Make_Sort_Link($form, "sl_client_cd")."<br>\n";
    $html_h .= "            <br style=\"font-size: 4px;\">\n";
    $html_h .= "            ".Make_Sort_Link($form, "sl_client_name")."<br>\n";
    $html_h .= "        </td>\n";
    $html_h .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_slip")."</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">".Make_Sort_Link($form, "sl_sale_day")."</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">�������</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">�����(��ȴ)</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">�����(�ǹ�)</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">�����ֹ�</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">ʬ����</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">���</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">��������</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">".$form->_elements[$form->_elementIndex["slip_check_all"]]->toHtml()."</td>\n";
    $html_h .= "        <td class=\"Title_Pink\">".$form->_elements[$form->_elementIndex["re_slip_check_all"]]->toHtml()."</td>\n";
    $html_h .= "    </tr>\n";

    // �����ơ��֥����Τ�����
    $html_p  = "\n";
    $html_p .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html_p .= $html_h;
    $html_p .= $html_m1;
    $html_p .= $html_l;
    $html_p .= $html_m2;
    $html_p .= "</table>\n";

    // ��ץơ��֥�html����
    $html_g  = "<table class=\"List_Table\" border=\"1\" align=\"right\">\n";
    $html_g .= "<col width=\"80px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col width=\"80px\" align=\"right\">\n";
    $html_g .= "<col width=\"80px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col width=\"80px\" align=\"right\">\n";
    $html_g .= "<col width=\"80px\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col width=\"80px\" align=\"right\">\n";
    $html_g .= "    <tr class=\"Result1\">\n";
    $html_g .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($kake_notax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($kake_tax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($kake_ontax_amount)."</td>\n";
    $html_g .= "    </tr>\n";
    $html_g .= "    <tr class=\"Result1\">\n";
    $html_g .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($genkin_notax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">���������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($genkin_tax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_g .= "        <td>".Number_Format_Color($genkin_ontax_amount)."</td>\n";
    $html_g .= "    </tr>\n";
    $html_g .= "    <tr class=\"Result1\">\n";
    $html_g .= "        <td class=\"Title_Pink\">�ǹ����</td>\n";
    $html_g .= "        <td>".Number_Format_Color($notax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">�����ǹ��</td>\n";
    $html_g .= "        <td>".Number_Format_Color($tax_amount)."</td>\n";
    $html_g .= "        <td class=\"Title_Pink\">�ǹ����</td>\n";
    $html_g .= "        <td>".Number_Format_Color($ontax_amount)."</td>\n";
    $html_g .= "    </tr>\n";
    $html_g .= "</table>\n";

}


/****************************/
//JavaScript
/****************************/
$order_delete  = " function Order_Delete(hidden1,hidden2,ord_id,hidden3,enter_date){\n";
$order_delete .= "    res = window.confirm(\"������ޤ�����������Ǥ�����\");\n";
$order_delete .= "    if (res == true){\n";
$order_delete .= "        var id = ord_id;\n";
$order_delete .= "        var edate = enter_date;\n";
$order_delete .= "        var hdn1 = hidden1;\n";
$order_delete .= "        var hdn2 = hidden2;\n";
$order_delete .= "        var hdn3 = hidden3;\n";
$order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
$order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
$order_delete .= "        document.dateForm.elements[hdn3].value = edate;\n";
$order_delete .= "        //Ʊ��������ɥ������ܤ���\n";
$order_delete .= "        document.dateForm.target=\"_self\";\n";
$order_delete .= "        //�����̤����ܤ���\n";
$order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$order_delete .= "        //POST�������������\n";
$order_delete .= "        document.dateForm.submit();\n";
$order_delete .= "        return true;\n";
$order_delete .= "    }else{\n";
$order_delete .= "        return false;\n";
$order_delete .= "    }\n";
$order_delete .= "}\n";


/****************************/
// HTML�����ʸ�������
/****************************/
// �⥸�塼����̥ơ��֥�ζ�����ʬ��
$html_s_tps  = "<br style=\"font-size: 4px;\">\n";
$html_s_tps .= "\n";
$html_s_tps .= "<table class=\"Table_Search\">\n";
$html_s_tps .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"300px\">\n";
$html_s_tps .= "    <col width=\"130px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"300px\">\n";
$html_s_tps .= "    <tr>\n";
// �⥸�塼����̥ơ��֥�ζ�����ʬ��
$html_s_tpe .= "    </tr>\n";
$html_s_tpe .= "</table>\n";
$html_s_tpe .= "\n";

// ���̸����ơ��֥�
$html_s  = Search_Table_Sale_H($form);
// �⥸�塼����̸����ơ��֥룱
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">��������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_renew"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�ǹ����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_sale_amount"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룲
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">��ɼ�ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_aord_no"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룳
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_goods"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�Ͷ�ʬ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_g_goods"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룴
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">������ʬ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_product"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">����ʬ��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_g_product"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룵
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">��ɼȯ��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_type"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">ȯ�Ծ���</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_out"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룶
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">�����ʬ</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_trade"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_installment_day"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룷
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">����о�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_shop"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
$page_menu = Create_Menu_h("sale", "2");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["203_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["201_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
// �ڡ����������
$html_page =  Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    // ����
    "html_header"           => "$html_header",
    "page_menu"             => "$page_menu",
    "page_header"           => "$page_header",
    "html_footer"           => "$html_footer",
    // ���顼��å���������ɼ�������ɼȯ�ԡ�
    "del_error_msg"         => "$del_error_msg",
    "output_error_msg"      => "$output_error_msg",
    // js
    "order_delete"          => "$order_delete",
    "javascript"            => $javascript,
    // �ե饰
    "post_flg"              => "$post_flg",
    "err_flg"               => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => $html_s,
    "html_p"        => $html_p,
    "html_g"        => $html_g,
    "html_page"     => $html_page,
    "html_page2"    => $html_page2,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));
?>