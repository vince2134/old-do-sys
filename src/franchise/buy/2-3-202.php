<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/04/12) ����κݤˡ�ȯ��ǡ����Υ��ơ������ѹ�(suzuki-t)
 *       (2006/05/17) ȯ���鵯�������ǡ�����ȯ������ɽ�����롣    
 *       (2006/09/25) �������Ǹ����������ˡ��ڡ������ܸ塢�ǡ������������ɽ������ʤ��Х��ν�����watanabe-k��
 *       (2006\)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-100      ��          �����Υ���ɤǺǿ���ɼ���������Ƥ��ޤ��Х�����
 *  2006/11/11      03-091      ��          ���������Ѥλ�����ɼ���������ʤ��褦����
 *  2006/12/07      ban_0040    suzuki      ���դΥ������
 *  2007/03/05      ��ȹ���12  �դ���      �ݡ�����ι�פ����
 *  2007-05-07                  fukuda      �����Ƚ�����դξ�����ѹ�
 *  2007-06-21                  fukuda      ��׹Ԥγۤ�ܤȡݤ�ʬ��
 *  2007-08-06                  watanabe-k  CSV�����
 *  2007-08-30                  watanabe-k  ����������ζ�����λ���������ʤ��Х��ν���
 *  2008-08-02                  watanabe-k  ��������򤷤����˥����ꥨ�顼��ɽ�������Х��ν���
 *
 *
 */

$page_title = "�����Ȳ�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


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
    "form_c_staff"          => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_buy_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_trade"            => "",
    "form_multi_staff"      => "",
    "form_ware"             => "",
    "form_slip_no"          => array("s" => "", "e" => ""),
    "form_renew"            => "1",
    "form_ord_no"           => array("s" => "", "e" => ""),
    "form_ord_day"          => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_goods"            => array("cd" => "", "name" => ""), 
    "form_g_goods"          => "",  
    "form_product"          => "",  
    "form_g_product"        => "",  
    "form_buy_amount"       => array("s" => "", "e" => ""),
);

// �����������
Restore_Filter2($form, array("buy", "ord"), "show_button", $ary_form_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$buy_id     = $_POST["buy_h_id"];


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Buy($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// ��ɼ�ֹ�ʳ��ϡ���λ��
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// ��������
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤�»�", "2");
$obj[]  =&  $form->createElement("radio", null, null, "�»ܺ�", "3");
$form->addGroup($obj, "form_renew", "", "");

// ȯ���ֹ�ʳ��ϡ���λ��
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "��");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_ord_no", "", "");

// ȯ�����ʳ��ϡ���λ��
Addelement_Date_Range($form, "form_ord_day", "ȯ����", "-");

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

// ������ۡ��ǹ��ˡʳ��ϡ���λ��
Addelement_Money_Range($form, "form_buy_amount", "", "");

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "�����襳����",
    "sl_client_name"    => "������̾",
    "sl_slip"           => "��ɼ�ֹ�",
    "sl_buy_day"        => "������",
    "sl_ord_no"         => "ȯ���ֹ�",
    "sl_ord_day"        => "ȯ����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_buy_day");

// ɽ��
$form->addElement("submit", "show_button", "ɽ����",
    "onClick=\"javascript:Which_Type('form_output_type','2-3-203.php','".$_SERVER["PHP_SELF"]."');\""
);

// ���ꥢ
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ����
$form->addElement("button", "new_button", "������","onClick=\"location.href('2-3-201.php')\"");

// �Ȳ�
$form->addElement("button", "chg_button", "�Ȳ��ѹ�", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// �����ե饰hidden
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","buy_h_id");
$form->addElement("hidden","hdn_del_enter_date");

// ���顼��å������������ѥե�����
$form->addElement("text", "err_renew_slip");


/****************************/
//�����󥯲�������
/****************************/
if($_POST["data_delete_flg"] == "true"){

    // ���򤵤줿��ɼ�κ������������
    $enter_date = $_POST["hdn_del_enter_date"];

    // ���򤵤줿��ɼ������������ɼ���������򸵤ˡ�Ĵ�٤�
    $valid_flg = Update_check($db_con, "t_buy_h", "buy_id", $buy_id, $enter_date);

    // �����ʾ��Τ߽�����Ԥ�
    if ($valid_flg == true){

        // �����������Ԥ��Ƥ��ʤ���Ĵ�٤�����������Ѣ�renew_flg = false��
        $renew_flg = Renew_Check($db_con, "t_buy_h", "buy_id", $buy_id);

        // ���������Ѥξ��
        if ($renew_flg == false){

            // ���������Ѥξ��Υ��顼��å������򥻥å�
            $form->setElementError("err_renew_slip", "���������������Ԥ��Ƥ���١�����Ǥ��ޤ���");

        // ��������̤�»ܤξ��
        }else{

            // �����ǡ����δ�ˤʤ롢ȯ��ǡ���ID���������SQL
            $sql  = "SELECT\n";
            $sql .= "   t_order_d.ord_d_id,\n";
            $sql .= "   rest_flg, \n";
            $sql .= "   finish_flg, \n";
            $sql .= "   t_buy_d.num \n";
            $sql .= "FROM\n";
            $sql .= "   t_buy_d\n";
            $sql .= "       LEFT JOIN\n";
            $sql .= "   t_order_d\n";
            $sql .= "   ON t_buy_d.ord_d_id = t_order_d.ord_d_id\n";
            $sql .= "WHERE\n";
            $sql .= "   buy_id = $buy_id;";

            $result   = Db_Query($db_con, $sql);
            $ord_d_data = pg_fetch_all($result);
            Db_Query($db_con, "BEGIN;");
            for($i = 0; $i < count($ord_d_data); $i++){
                //ȯ��ǡ������Ф��롢ȯ��ID����

                if($ord_d_data[$i]["ord_d_id"] != NULL){
                    $sql  = "SELECT ";
                    $sql .= "    ord_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_order_d ";
                    $sql .= "WHERE ";
                    $sql .= "    ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";
                    $result = Db_Query($db_con,$sql);
                    $ord_id = Get_Data($result);

                    //������ʬǼ����Ƥ��뤫Ƚ��
                    $sql  = "SELECT ";
                    $sql .= "    buy_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_buy_h ";
                    $sql .= "WHERE ";
                    $sql .= "    ord_id = ".$ord_id[0][0].";";
                    $result = Db_Query($db_con,$sql);
                    if(pg_numrows($result) == 1){
                        //ʬǼ���Ƥ��ʤ�����̤����
                        $ps_stat = '1';
                    }else{
                        //ʬǼ���Ƥ�����Ͻ�����
                        $ps_stat = '2';
                    }
        
                    //��������ȯ��ǡ�����ȯ��ĥե饰������
                    //���������� ������������λ̤�»ܡ�������ȯ���̵��
                    if($ord_d_data[$i]["rest_flg"] == "f" && $ord_d_data[$i]["finish_flg"] == "f" && $ord_d_data[$i]["num"] == "0"){
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        reason = null,
                                        rest_flg = 'f',
                                        finish_flg = 'f' 
                                    WHERE 
                                        ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql3    = "UPDATE t_order_h SET ps_stat = $ps_stat, finish_flg = 'f' WHERE ord_id = ".$ord_id[0][0].";";
                    //���������� ������������λ�»ܡ�������ȯ���̵��
                    }elseif($ord_d_data[$i]["rest_flg"] == "f" && $ord_d_data[$i]["finish_flg"] == "t" && $ord_d_data[$i]["num"] == "0"){

                        //������ʬǼ���Ƥ�����
                        if($ps_stat == "2"){
                            $rest_flg   = 'f';  
                            $finish_flg = 't';
                        }else{  
                            //������ʬǼ���Ƥ��ʤ����϶�����λ����
                            $reason     = 'reason = null,';
                            $rest_flg   = 't';  
                            $finish_flg = 'f';
                            $sql2 = "DELETE FROM t_stock_hand WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"]." AND work_div = '3' AND io_div = '2'";
                        }
  
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        $reason
                                        rest_flg = '$rest_flg', 
                                        finish_flg = '$finish_flg' 
                                    WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql4    = "UPDATE t_order_h SET ps_stat = $ps_stat WHERE ord_id = ".$ord_id[0][0].";";

                    //�嵭�ʳ�
                    }else{
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        reason = null,
                                        rest_flg = 't', 
                                        finish_flg = 'f' 
                                    WHERE 
                                        ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql3    = "UPDATE t_order_h SET ps_stat = $ps_stat, finish_flg = 'f' WHERE ord_id = ".$ord_id[0][0].";";

                        //������λ��ԤäƤ�����
                        if($ord_d_data[$i]["finish_flg"] == "t"){
                            $sql2 = "DELETE FROM t_stock_hand WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"]." AND work_div = '3' AND io_div = '2'";
                        }
                    }

 
                    $result  = Db_Query($db_con, $sql);
                    if($result == false){ 
                        Db_Query($db_con, "ROLLBACK;");
                        exit;   
                    }       
                }
            }

            if($sql2 != null){
                $result = Db_Query($db_con, $sql2);
                if($result == "false"){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }
            if($sql4 != null ){
                //��������ȯ��إå��ν����������ѹ�
                $result = Db_Query($db_con,$sql4);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }elseif($sql3 != null){
                //��������ȯ��إå��ν����������ѹ�
                $result = Db_Query($db_con,$sql3);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }

            $delete_renew_flg = true;
    
            $data_delete  = " DELETE FROM ";
            $data_delete .= "   t_buy_h ";
            $data_delete .= "   where ";
            $data_delete .= "   buy_id = $_POST[buy_h_id] ";
            $data_delete .= ";";
            $result = @Db_Query($db_con, $data_delete);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                print $data_delete;
                exit;
            }
            Db_Query($db_con, "COMMIT;");

        }

    }

    $set_date["data_delete_flg"]    = "";
    $set_date["hdn_del_enter_date"] = "";
    $form->setConstants($set_date);

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲�����
/****************************/
if ($_POST["show_button"] == "ɽ����"){

    // ����POST�ǡ�����0���
    $_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ������ô����
    $err_msg = "����ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ��������
    $err_msg = "������ �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_buy_day", $err_msg);

    // ������ô���ԡ�ʣ�������
    $err_msg = "����ô���ԡ�ʣ������� �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ��ȯ����
    $err_msg = "ȯ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ���������
    $err_msg = "������� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_buy_amount", $err_msg);

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
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num    = $_POST["form_display_num"];
    $output_type    = $_POST["form_output_type"];
    $client_branch  = $_POST["form_client_branch"];
    $attach_branch  = $_POST["form_attach_branch"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $part           = $_POST["form_part"];
    $buy_day_sy     = $_POST["form_buy_day"]["sy"];
    $buy_day_sm     = $_POST["form_buy_day"]["sm"];
    $buy_day_sd     = $_POST["form_buy_day"]["sd"];
    $buy_day_ey     = $_POST["form_buy_day"]["ey"];
    $buy_day_em     = $_POST["form_buy_day"]["em"];
    $buy_day_ed     = $_POST["form_buy_day"]["ed"];
    $trade          = $_POST["form_trade"];
    $multi_staff    = $_POST["form_multi_staff"];
    $ware           = $_POST["form_ware"];
    $slip_no_s      = $_POST["form_slip_no"]["s"];
    $slip_no_e      = $_POST["form_slip_no"]["e"];
    $renew          = $_POST["form_renew"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $goods_cd       = $_POST["form_goods"]["cd"];
    $goods_name     = $_POST["form_goods"]["name"];
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $buy_amount_s   = $_POST["form_buy_amount"]["s"];
    $buy_amount_e   = $_POST["form_buy_amount"]["e"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // �ܵ�ô����Ź
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n"; 
        $sql .= "   ) \n";
    }
    // ��°�ܻ�Ź
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.c_staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // �����襳����1
    $sql .= ($client_cd1 != null) ? "AND t_buy_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳����2
    $sql .= ($client_cd2 != null) ? "AND t_buy_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_buy_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_buy_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_buy_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ����ô���ԥ�����
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // ����ô���ԥ��쥯��
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // �������ʳ��ϡ�
    $buy_day_s = $buy_day_sy."-".$buy_day_sm."-".$buy_day_sd;
    $sql .= ($buy_day_s != "--") ? "AND '$buy_day_s' <= t_buy_h.buy_day \n" : null;
    // �������ʽ�λ��
    $buy_day_e = $buy_day_ey."-".$buy_day_em."-".$buy_day_ed;
    $sql .= ($buy_day_e != "--") ? "AND t_buy_h.buy_day <= '$buy_day_e' \n" : null;
    // �����ʬ
    $sql .= ($trade != null) ? "AND t_buy_h.trade_id = $trade \n" : null;
    // ����ô���ԡ�ʣ�������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_buy_h.ware_id = $ware \n" : null;
    // ��ɼ�ֹ�ʳ��ϡ�
    $sql .= ($slip_no_s != null) ? "AND t_buy_h.buy_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��ɼ�ֹ�ʽ�λ��
    $sql .= ($slip_no_e != null) ? "AND t_buy_h.buy_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ��������
    if ($renew == "2"){
        $sql .= "AND t_buy_h.renew_flg = 'f' \n";
    }elseif ($renew == "3"){
        $sql .= "AND t_buy_h.renew_flg = 't' \n";
    }
    // ȯ���ֹ�ʳ��ϡ�
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ȯ���ֹ�ʽ�λ��
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ȯ�����ʳ��ϡ�
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
    // ȯ�����ʽ�λ��
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // ���ʥ�����
    if ($goods_cd != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "                          AND t_buy_d.goods_cd LIKE '$goods_cd%' \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // ����̾
    if ($goods_name != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "                          AND t_buy_d.goods_name LIKE '%$goods_name%' \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // �Ͷ�ʬ
    if ($g_goods != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_goods_id = $g_goods \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // ������ʬ
    if ($product != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.product_id = $product \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // ����ʬ��
    if ($g_product != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_product_id = $g_product \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // ������ۡ��ǹ��ˡʳ��ϡ�
    if ($buy_amount_s != null){
        $sql .= "AND \n";
        $sql .= "   $buy_amount_s <= \n";
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
        $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
        $sql .= "   END \n";
    }
    // ������ۡ��ǹ��ˡʽ�λ��
    if ($buy_amount_e != null){
        $sql .= "AND \n";
        $sql .= "   $buy_amount_e >= \n";
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
        $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
        $sql .= "   END \n";
    }
    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // �����襳����
        case "sl_client_cd":
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no \n";
            break;  
        // ������̾
        case "sl_client_name":
            $sql .= "   t_buy_h.client_cname, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // ��ɼ�ֹ�
        case "sl_slip":
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // ������
        case "sl_buy_day":
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // ȯ���ֹ�
        case "sl_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // ȯ����
        case "sl_ord_day":
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql; 

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true && $output_type != '3'){

    $sql  = "SELECT \n";
    if ($group_kind == "2"){
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL \n";
    $sql .= "       THEN t_buy_h.client_cd1||'-'||t_buy_h.client_cd2 \n";
    $sql .= "       ELSE t_buy_h.client_cd1 \n";
    $sql .= "   END \n";
    $sql .= "   AS client_cd1, \n";
    }else{
    $sql .= "   t_buy_h.client_cd1, \n";
    }
    $sql .= "   t_buy_h.client_cname, \n";
    $sql .= "   t_buy_h.buy_id, \n";
    $sql .= "   t_buy_h.buy_no, \n";
    $sql .= "   t_buy_h.buy_day, \n";
    $sql .= "   t_buy_h.trade_id, \n";
    $sql .= "   t_buy_h.net_amount, \n";
    $sql .= "   t_buy_h.tax_amount, \n";
    $sql .= "   t_buy_h.net_amount + t_buy_h.tax_amount AS intax_amount, \n";
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_buy_h.renew_flg, \n";
    $sql .= "   t_order_h.finish_flg, \n";
    $sql .= "   to_char(t_order_h.ord_time,'yyyy-mm-dd'), \n";
    $sql .= "   t_buy_h.total_split_num, \n";
    $sql .= "   to_char(t_buy_h.renew_day, 'yyyy-mm-dd'), \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN intro_sale_id IS NOT NULL OR act_sale_id IS NOT NULL \n";
    $sql .= "       THEN 't'\n";
    $sql .= "       ELSE 'f' \n";
    $sql .= "   END \n";
    $sql .= "   AS intro_act_flg, \n";
    $sql .= "   t_buy_h.enter_day, \n";
    if ($group_kind == "2"){
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL \n";
    $sql .= "       THEN 't' \n";
    $sql .= "       ELSE 'f' \n";
    $sql .= "   END \n";
    $sql .= "   AS fc_flg \n";
    }else{
    $sql .= "   'f' \n";
    }
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   LEFT  JOIN t_order_h    ON t_buy_h.ord_id = t_order_h.ord_id \n";
    $sql .= "   LEFT  JOIN t_staff      ON t_buy_h.c_staff_id = t_staff.staff_id \n";

	//�������򤵤줿���
	if($part){
		$sql .= "	LEFT  JOIN t_attach	ON t_staff.staff_id = t_attach.staff_id AND t_attach.shop_id = $shop_id ";
	}

    $sql .= "   LEFT JOIN t_sale_h AS t_act_sale_h ON t_buy_h.act_sale_id = t_act_sale_h.sale_id \n";
    $sql .= "   LEFT JOIN t_sale_h AS t_intro_sale_h ON t_buy_h.intro_sale_id = t_intro_sale_h.sale_id \n";

    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);
    $limit          = $total_count;

    // OFFSET������
    if ($post_flg == true && $err_flg != true){

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

    }

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

#print_array($sql);
    /****************************/
    // �����ǡ�����������
    /****************************/
    //��׶�۷׻�
    for($i = 0; $i < $row_count; $i++){
        if($page_data[$i][5] == '21' || $page_data[$i][5] == '71' || $page_data[$i][5] == '25'){
            $sum1 = bcadd($sum1,$page_data[$i][6],2);
            $sum2 = bcadd($sum2,$page_data[$i][7],2);
            $sum3 = bcadd($sum3,$page_data[$i][8],2);
        }else{
            $sum1 = bcsub($sum1,$page_data[$i][6],2);
            $sum2 = bcsub($sum2,$page_data[$i][7],2);
            $sum3 = bcsub($sum3,$page_data[$i][8],2);
        }
    }
    $sum1 = number_format($sum1);
    $sum2 = number_format($sum2);
    $sum3 = number_format($sum3);

    //������ۡ������ǳۤΥ����
    for($i = 0; $i < $row_count; $i++){

        // �ݡ�����ι�׻���
        switch ($page_data[$i][5]){
            case "21":
            case "25":
                $kake_nuki_amount   += $page_data[$i][6];
                $kake_tax_amount    += $page_data[$i][7];
                $kake_komi_amount   += $page_data[$i][8];
                break;  
            case "23":
            case "24":
                $kake_nuki_amount   -= $page_data[$i][6];
                $kake_tax_amount    -= $page_data[$i][7];
                $kake_komi_amount   -= $page_data[$i][8];
                break;  
            case "71":
                $genkin_nuki_amount += $page_data[$i][6];
                $genkin_tax_amount  += $page_data[$i][7];
                $genkin_komi_amount += $page_data[$i][8];
                break;  
            case "73":
            case "74":
                $genkin_nuki_amount -= $page_data[$i][6];
                $genkin_tax_amount  -= $page_data[$i][7];
                $genkin_komi_amount -= $page_data[$i][8];
                break;  
        }

        // ��׹��Ѥζ�ۻ���
        switch ($page_data[$i][5]){
            case "21":
            case "25":
                $gross_notax_amount += $page_data[$i][6];
                $gross_tax_amount   += $page_data[$i][7];
                $gross_ontax_amount += $page_data[$i][8];
                break;  
            case "23":
            case "24":
                $minus_notax_amount -= $page_data[$i][6];
                $minus_tax_amount   -= $page_data[$i][7];
                $minus_ontax_amount -= $page_data[$i][8];
                break;  
            case "71":
                $gross_notax_amount += $page_data[$i][6];
                $gross_tax_amount   += $page_data[$i][7];
                $gross_ontax_amount += $page_data[$i][8];
                break;  
            case "73":
            case "74":
                $minus_notax_amount -= $page_data[$i][6];
                $minus_tax_amount   -= $page_data[$i][7];
                $minus_ontax_amount -= $page_data[$i][8];
                break;  
        }

        if (!($page_data[$i][5] == '21' || $page_data[$i][5] == '71' || $page_data[$i][5] == '25')){
            $page_data[$i][6] = $page_data[$i][6]*(-1);
            $page_data[$i][7] = $page_data[$i][7]*(-1);
            $page_data[$i][8] = $page_data[$i][8]*(-1);
        }
            $page_data[$i][6] = number_format($page_data[$i][6]);
            $page_data[$i][7] = number_format($page_data[$i][7]);
            $page_data[$i][8] = number_format($page_data[$i][8]);
        if($page_data_f[$i][5] == '21' || $page_data_f[$i][5] == '71' || $page_data_f[$i][5] == '25'){
            $sum_all1 = bcadd($sum_all1,$page_data_f[$i][6]);
            $sum_all2 = bcadd($sum_all2,$page_data_f[$i][7]);
            $sum_all3 = bcadd($sum_all3,$page_data_f[$i][8]);
            $page_data_f[$i][6]    = number_format($page_data_f[$i][6]);       //�������(��ȴ)
            $page_data_f[$i][7]    = number_format($page_data_f[$i][7]);       //�����ǳ�
            $page_data_f[$i][8]    = number_format($page_data_f[$i][8]);       //�������(�ǹ�)
        }else if($page_data_f[$i][5] == '22' || $page_data_f[$i][5] == '23' || $page_data_f[$i][5] == '24' || $page_data_f[$i][5] == '72' || $page_data_f[$i][5] == '73' || $page_data_f[$i][5] == '74'){
            $sum_all1 = bcsub($sum_all1,$page_data_f[$i][6]);
            $sum_all2 = bcsub($sum_all2,$page_data_f[$i][7]);
            $sum_all3 = bcsub($sum_all3,$page_data_f[$i][8]);
            $page_data_f[$i][6]    = number_format($page_data_f[$i][6]);       //�������(��ȴ)
            $page_data_f[$i][7]    = number_format($page_data_f[$i][7]);       //�����ǳ�
            $page_data_f[$i][8]    = number_format($page_data_f[$i][8]);       //�������(�ǹ�)
        }

        //�����ʬ���ִ�
        if($page_data[$i][5] == "21"){
            $page_data[$i][5] = "�ݻ���";
        }elseif($page_data[$i][5] == "23"){
            $page_data[$i][5] = "������";
        }elseif($page_data[$i][5] == "24"){
            $page_data[$i][5] = "���Ͱ�";
        }elseif($page_data[$i][5] == "25"){
            $page_data[$i][5] = "�������";
        }elseif($page_data[$i][5] == "71"){
            $page_data[$i][5] = "�������";
        }elseif($page_data[$i][5] == "73"){
            $page_data[$i][5] = "��������";
        }elseif($page_data[$i][5] == "74"){
            $page_data[$i][5] = "�����Ͱ�";
        }

        //���������˽��Ϥ����å�����
        if($page_data[$i][12] == 't'){
            $dialog_message = "��ɼ�κ���ȶ�����λ���ä���Ԥ��ޤ���";
        }else{
            $dialog_message = "������ޤ���";
        }

        if($page_data[$i][11] != 't'){
            $order_delete .= " function Order_Delete".$i."(hidden1,hidden2,buy_id,hidden3,enter_date){\n";
            $order_delete .= "    res = window.confirm(\"".$dialog_message."\\n������Ǥ�����\");\n";
            $order_delete .= "    if (res == true){\n";
            $order_delete .= "        var id    = buy_id;\n";
            $order_delete .= "        var edate = enter_date;\n";
            $order_delete .= "        var hdn1  = hidden1;\n";
            $order_delete .= "        var hdn2  = hidden2;\n";
            $order_delete .= "        var hdn3  = hidden3;\n";
            $order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
            $order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
            $order_delete .= "        document.dateForm.elements[hdn3].value = edate;\n";
            $order_delete .= "        // Ʊ��������ɥ������ܤ���\n";
            $order_delete .= "        document.dateForm.target=\"_self\";\n";
            $order_delete .= "        // �����̤����ܤ���\n";
            $order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
            $order_delete .= "        // POST�������������\n";
            $order_delete .= "        document.dateForm.submit();\n";
            $order_delete .= "        return true;\n";
            $order_delete .= "    }else{\n";
            $order_delete .= "        return false;\n";
            $order_delete .= "    }\n";
            $order_delete .= "}\n";
        }
    }
//CSV���Ϥξ��
}elseif($output_type == '3'){
    $sql  = "SELECT \n";
    $sql .= "   CASE t_buy_h.buy_div \n";
    $sql .= "      WHEN '1' THEN t_buy_h.client_cd1 \n";
    $sql .= "      WHEN '2' THEN t_buy_h.client_cd1 || '-' || t_buy_h.client_cd2 \n";
    $sql .= "   END AS client_cd1, \n";         // 0    �����襳����
    $sql .= "   t_buy_h.client_cname, \n";      // 1    ������̾
    $sql .= "   t_buy_h.buy_no, \n";            // 2    �����ֹ�
    $sql .= "   t_buy_h.buy_day, \n";           // 3    ������
    $sql .= "   t_buy_h.arrival_day, \n";       // 4    ������
    $sql .= "   t_trade.trade_name, \n";        // 5    �����ʬ
    $sql .= "   t_buy_h.direct_name, \n";       // 6    ľ����̾
    $sql .= "   t_buy_h.ware_name, \n";         // 7    �Ҹ�̾
    $sql .= "   t_buy_h.c_staff_name, \n";      // 8    ����ô����
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_h.net_amount ";
    $sql .= "       ELSE t_buy_h.net_amount ";
    $sql .= "   END AS trade_net_amount, \n";   // 9    �������
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_h.tax_amount ";
    $sql .= "       ELSE t_buy_h.tax_amount ";
    $sql .= "   END AS trade_tax_amount, \n";   //10    �����ǳ�
    $sql .= "   (t_buy_h.net_amount + t_buy_h.tax_amount) * CASE \n";
    $sql .= "                               WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 ";
    $sql .= "                               ELSE 1 \n";
    $sql .= "                            END AS all_amount, ";  //11    ������ۡ��ǹ���
    $sql .= "   t_buy_d.goods_cd, \n";          //15    ���ʥ�����
    $sql .= "   t_buy_d.goods_name, \n";        //14    ����̾
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,73) THEN -1 * t_buy_d.num ";
    $sql .= "       ELSE t_buy_d.num ";
    $sql .= "   END AS num, \n";                //15    ����
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (24,74) THEN -1 * t_buy_d.buy_price ";
    $sql .= "       ELSE t_buy_d.buy_price ";
    $sql .= "   END AS buy_price, \n";          //16    ñ��
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_d.buy_amount ";
    $sql .= "       ELSE t_buy_d.buy_amount ";
    $sql .= "   END AS buy_amount,";             //17    �������

    $sql .= "   CASE t_buy_h.trade_id ";
    $sql .= "       WHEN '25' THEN t_buy_h.total_split_num ";
    $sql .= "   END AS total_split_num,\n";     //18    ʬ����

    $sql .= "   to_char(t_buy_h.renew_day, 'yyyy-mm-dd') AS renew_day \n";  //19    //����������
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_trade \n";
    $sql .= "   ON t_buy_h.trade_id = t_trade.trade_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_staff \n";
    $sql .= "   ON t_buy_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_buy_d \n";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id \n";
	//�������򤵤줿���
	if($part){
		$sql .= "	LEFT  JOIN t_attach	ON t_staff.staff_id = t_attach.staff_id AND t_attach.shop_id = $shop_id ";
	}
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data = pg_fetch_all($result);

    $csv_file_name = "�����Ȳ�.csv";
    $csv_header = array(
            "�����襳����",
            "������̾",
            "��ɼ�ֹ�",
            "������",
            "������",
            "�����ʬ",
            "ľ����̾",
            "�Ҹ�̾",
            "����ô����",
            "������ۡ���ȴ��",
            "�����ǳ�",
            "������ۡ��ǹ���",
            "���ʥ�����",
            "����̾",
            "����",
            "����ñ��",
            "�������",
            "ʬ����",
            "��������"
    );

    //CSV�ǡ�������
    for($i=0;$i<count($page_data);$i++){
        $buy_data[$i][0]  = $page_data[$i]["client_cd1"];
        $buy_data[$i][1]  = $page_data[$i]["client_cname"];
        $buy_data[$i][2]  = $page_data[$i]["buy_no"];
        $buy_data[$i][3]  = $page_data[$i]["buy_day"];
        $buy_data[$i][4]  = $page_data[$i]["arrival_day"];
        $buy_data[$i][5]  = $page_data[$i]["trade_name"];
        $buy_data[$i][6]  = $page_data[$i]["direct_name"];
        $buy_data[$i][7]  = $page_data[$i]["ware_name"];
        $buy_data[$i][8]  = $page_data[$i]["c_staff_name"];
        $buy_data[$i][9]  = $page_data[$i]["trade_net_amount"];
        $buy_data[$i][10] = $page_data[$i]["trade_tax_amount"];
        $buy_data[$i][11] = $page_data[$i]["all_amount"];
        $buy_data[$i][12] = $page_data[$i]["goods_cd"];
        $buy_data[$i][13] = $page_data[$i]["goods_name"];
        $buy_data[$i][14] = $page_data[$i]["num"];
        $buy_data[$i][15] = $page_data[$i]["buy_price"];
        $buy_data[$i][16] = $page_data[$i]["buy_amount"];
        $buy_data[$i][17] = $page_data[$i]["total_split_num"];
        $buy_data[$i][18] = $page_data[$i]["renew_day"];
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($buy_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;


}



/****************************/
// HTML�����ʸ�������
/****************************/
// �⥸�塼����̥ơ��֥�ζ�����ʬ��
$html_s_tps  = "<br style=\"font-size: 4px;\">\n";
$html_s_tps .= "\n";
$html_s_tps .= "<table class=\"Table_Search\">\n";
$html_s_tps .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"300px\">\n";
$html_s_tps .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"250px\">\n";
$html_s_tps .= "    <tr>\n";
// �⥸�塼����̥ơ��֥�ζ�����ʬ��
$html_s_tpe .= "    </tr>\n";
$html_s_tpe .= "</table>\n";
$html_s_tpe .= "\n";

// ���̸����ơ��֥�
$html_s .= Search_Table_Buy($form);
// �⥸�塼����̸����ơ��֥룱
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">��ɼ�ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">��������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_renew"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// �⥸�塼����̸����ơ��֥룲
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">ȯ���ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">ȯ����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_day"]]->toHtml()."</td>\n";
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
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�������<br>���ǹ���</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_buy_amount"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
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
$page_menu = Create_Menu_f("buy", "2");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[chg_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'     => "$html_header",
    'page_menu'       => "$page_menu",
    'page_header'     => "$page_header",
    'html_footer'     => "$html_footer",
    'html_page'       => "$html_page",
    'html_page2'      => "$html_page2",
    'buy_day_err'     => "$buy_day_err",
    'sum1'            => "$sum1",
    'sum2'            => "$sum2",
    'sum3'            => "$sum3",
    'sum_all1'        => "$sum_all1",
    'sum_all2'        => "$sum_all2",
    'sum_all3'        => "$sum_all3",
    'total_count'     => "$total_count",
    'order_delete'    => "$order_delete",
    'buy_all_day_err' => "$buy_all_day_err",
    'ord_all_day_err' => "$ord_all_day_err",
    'hidden_submit'   => "$hidden_submit",
    'row_count'       => "$row_count",
    'javascript'      => "$javascript",
    "auth_r"          => $auth[0],
    "no"                => ($page_count * $limit - $limit) + 1,
    "kake_nuki_amount"      => number_format($kake_nuki_amount),
    "kake_tax_amount"       => number_format($kake_tax_amount),
    "kake_komi_amount"      => number_format($kake_komi_amount),
    "genkin_nuki_amount"    => number_format($genkin_nuki_amount),
    "genkin_tax_amount"     => number_format($genkin_tax_amount),
    "genkin_komi_amount"    => number_format($genkin_komi_amount),
    "total_nuki_amount"     => number_format($kake_nuki_amount + $genkin_nuki_amount),
    "total_tax_amount"      => number_format($kake_tax_amount + $genkin_tax_amount),
    "total_komi_amount"     => number_format($kake_komi_amount + $genkin_komi_amount),
    "post_flg"              => "$post_flg",
    "err_flg"               => "$err_flg",
    "gross_notax_amount"    => Numformat_Ortho($gross_notax_amount),
    "gross_tax_amount"      => Numformat_Ortho($gross_tax_amount),
    "gross_ontax_amount"    => Numformat_Ortho($gross_ontax_amount),
    "minus_notax_amount"    => Numformat_Ortho($minus_notax_amount),
    "minus_tax_amount"      => Numformat_Ortho($minus_tax_amount),
    "minus_ontax_amount"    => Numformat_Ortho($minus_ontax_amount),
));

$smarty->assign('row',$page_data);

// html��assign
$smarty->assign("html", array(
    "html_s"    => "$html_s",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
