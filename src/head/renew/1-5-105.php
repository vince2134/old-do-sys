<?php

/*
 *  ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-04-13      ����¾159   fukuda      ���״��ֽ�λ�����������դ�ǥե���Ȥǥ��å�
 *  2009-10-17                  aoyama-n    ���״��ֳ����������ϲ�ǽ�˽���
 *  2009-10-21                  hashimoto-y setConstants���Ƥʤ����ᥨ�顼���ϻ������դ�����ͤ����Х����������ߥХ���
 * 
 * 
 */

// �ڡ���̾
$page_title = "�Хå�ɽ";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."1-5-105.php.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB��³
$db_con = Db_Connect();


/****************************/
// ���´�Ϣ����
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = null;


//2009-10-17 aoyama-n
/****************************/
// ����/������ǡ�������
/****************************/
// �ǽ������
$monthly_renew_day  = Renew_Day($db_con, "monthly", $shop_id);
$mon_renew_day["y"] = substr($monthly_renew_day, 0, 4);
$mon_renew_day["m"] = substr($monthly_renew_day, 5, 2);
$mon_renew_day["d"] = substr($monthly_renew_day, 8,2);

/****************************/
// ���������
/****************************/
$def_fdata = array(
    "form_end_day"  => array("y" => date("Y"), "m" => date("m"), "d" => date("d")),
    "hdn_end_day"   => array("y" => date("Y"), "m" => date("m"), "d" => date("d")),
    //2009-10-17 aoyama-n
    "form_start_day"  => array("y" => $mon_renew_day["y"], "m" => $mon_renew_day["m"], "d" => $mon_renew_day["d"])
);
$form->setDefaults($def_fdata);

//2009-10-17 aoyama-n
// ���״��ֳ�������
$start_day = $monthly_renew_day;

// ���״��ֽ�λ����
$end_day = date("Y-m-d");


/****************************/
// GET�ͥ����å�
/****************************/
if ($_GET != null){
    header("Location: ../top.php");
    exit;
}


/****************************/
// �ե�������������
/****************************/
// POST�ǡ��������ꡢɽ���ܥ���̤��������ô���԰������̤������POST������줿����
if ($_POST != null && $_POST["form_show_button"] == null){
    $def_data["form_end_day"]["y"]  = $_POST["hdn_end_day"]["y"];
    $def_data["form_end_day"]["m"]  = $_POST["hdn_end_day"]["m"];
    $def_data["form_end_day"]["d"]  = $_POST["hdn_end_day"]["d"];
    $def_data["form_branch"]        = $_POST["hdn_branch"];
    $form->setConstants($def_data);
}


/****************************/
// �ե�����ѡ������
/****************************/

//2009-10-17 aoyama-n
// ���״���
Addelement_Date($form, "form_start_day", "", "-");

// ���״���
Addelement_Date($form, "form_end_day", "��������", "-");

// ���������ܥ���
$form->addElement("button", "form_renew_button", "���������»�", "
    onClick=\"javascript: return Dialogue_1('�¹Ԥ��ޤ���', 'true', 'renew_flg');\"
    $disabled
");

// hidden ���������ե饰���å���
$form->addElement("hidden", "renew_flg");

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// ô���԰����ܥ���
$form->addElement("button", "form_list_button", "ô���԰�����", "onClick=\"javascript: Submit_Page('./1-5-109.php');\"");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"javascript: location.href('".$_SERVER[PHP_SELF]."');\"");

// hidden ���״���
$hdn_end_day[] = $form->createElement("hidden", "y", "", "");
$hdn_end_day[] = $form->createElement("hidden", "m", "", "");
$hdn_end_day[] = $form->createElement("hidden", "d", "", "");
$form->addGroup($hdn_end_day, "hdn_end_day", "", " - ");

// hidden ��Ź
$form->addElement("hidden", "hdn_branch", "", "");


/****************************/
// ����/������ǡ�������
/****************************/
// �ǽ�����������
$daily_renew_day    = Renew_Day($db_con, "daily", $shop_id);

// �ǽ������
//2009-10-17 aoyama-n
#$monthly_renew_day  = Renew_Day($db_con, "monthly", $shop_id);


/****************************/
// POST�����ѿ�����
/****************************/
// ɽ���ܥ��󲡲���
if ($_POST["form_show_button"] != null || $_POST["renew_flg"] == "true"){

    //2009-10-17 aoyama-n
    $start_y      = ($_POST["form_start_day"]["y"] != null) ? str_pad($_POST["form_start_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
    $start_m      = ($_POST["form_start_day"]["m"] != null) ? str_pad($_POST["form_start_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
    $start_d      = ($_POST["form_start_day"]["d"] != null) ? str_pad($_POST["form_start_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
    $start_day    = ($start_y != null && $start_m != null && $start_d != null) ? $start_y."-".$start_m."-".$start_d : null;

    $end_y      = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
    $end_m      = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
    $end_d      = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
    $branch_id  = $_POST["form_branch"];

    #2009-10-21 hashimoto-y
    $form_set["form_start_day"]["y"] = $start_y;
    $form_set["form_start_day"]["m"] = $start_m;
    $form_set["form_start_day"]["d"] = $start_d;
    $form_set["form_end_day"]["y"] = $end_y;
    $form_set["form_end_day"]["m"] = $end_m;
    $form_set["form_end_day"]["d"] = $end_d;
    $form_set["form_branch"]       = $branch_id;
    $form->setConstants($form_set);

// ô���԰������̤������POST������줿���
// ô���԰������̤���ô���ԥ��POST������줿���
}elseif ($_POST != null && $_POST["form_show_button"] == null){

    $end_y      = $_POST["hdn_end_day"]["y"];
    $end_m      = $_POST["hdn_end_day"]["m"];
    $end_d      = $_POST["hdn_end_day"]["d"];
    $end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;
    $branch_id  = $_POST["hdn_branch"];

    #2009-10-21 hashimoto-y
    $form_set["form_end_day"]["y"] = $end_y;
    $form_set["form_end_day"]["m"] = $end_m;
    $form_set["form_end_day"]["d"] = $end_d;
    $form_set["form_branch"]       = $branch_id;
    $form->setConstants($form_set);

}


/****************************/
// ɽ���ܥ��󲡲�������
/****************************/
if (isset($_POST["form_show_button"]) || $_POST["renew_flg"] == "true"){

    /****************************/
    // ���顼�����å�
    /****************************/
    //2009-10-17 aoyama-n
    //���״���ɬ�ܥ����å�
    if ($start_day == null){
        $form->setElementError("form_start_day", "���״���(����) ��ɬ�ܤǤ���");
    }
    if($end_day == null){
        $form->setElementError("form_end_day", "���״���(��λ) ��ɬ�ܤǤ���");
    }

    // �ɤ줫1�ĤǤ����Ϥ�������
    //2009-10-17 aoyama-n
    #if ($end_y != null || $end_m != null || $end_d != null){
    //���״��֤γ��ϡ���λ�����Ϥ���Ƥ�����
    if ($start_day != null && $end_day != null){

        // ���顼��å�����
        //2009-10-17 aoyama-n
        #$err_msg = "���״��֤����դ������ǤϤ���ޤ���";
        $startday_err_msg = "���״���(����) �����դ������ǤϤ���ޤ���";
        $endday_err_msg = "���״���(��λ) �����դ������ǤϤ���ޤ���";

        // ɬ�ܥ����å�
        //2009-10-17 aoyama-n
        #$form->addGroupRule("form_end_day", $err_msg, "required");

        // ���ͥ����å�
        //2009-10-17 aoyama-n
        $form->addGroupRule("form_start_day", $startday_err_msg, "regex", "/^[0-9]+$/");
        $form->addGroupRule("form_end_day", $endday_err_msg, "regex", "/^[0-9]+$/");

        // ���������������å�
        //2009-10-17 aoyama-n
        if (!checkdate((int)$start_m, (int)$start_d, (int)$start_y)){
            $form->setElementError("form_start_day", $startday_err_msg);
        }
        if (!checkdate((int)$end_m, (int)$end_d, (int)$end_y)){
            $form->setElementError("form_end_day", $endday_err_msg);
        }       

        // ����η������������դ������å�
        //2009-10-17 aoyama-n
        #if ((mb_substr($monthly_renew_day, 0, 10) > $end_day) && $err_flg != true){
        #    $form->setElementError("form_end_day", $err_msg);
        #}

    }

    // ���������»ܥܥ��󲡲���
    if ($_POST["renew_flg"] == "true"){

        // ɬ�ܥ����å�
        //2009-10-17 aoyama-n
        #if ($end_day == null){
        #    $form->setElementError("form_end_day", "���״��� ��ɬ�ܤǤ���");
        #}

        // ������դ������å�
        //2009-10-17 aoyama-n
        if (date("Y-m-d") < $start_day){
            $form->setElementError("form_start_day", "���״���(����) ��̤������դˤʤäƤ��ޤ���");
        }
        if (date("Y-m-d") < $end_day){
            //2009-10-17 aoyama-n
            #$form->setElementError("form_end_day", "���״��� ��̤������դˤʤäƤ��ޤ���");
            $form->setElementError("form_end_day", "���״���(��λ) ��̤������դˤʤäƤ��ޤ���");
        }

    }

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();
    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;
    
    /****************************/
    // ���顼��̵�����ν���
    /****************************/
    // ���顼�Τʤ����
    if ($err_flg != true){

        // �ե�����ǡ�����hidden�˥��åȡ�ô���԰������̤Υե����ॻ�å��ѡ�
        $hdn_set["hdn_end_day"]["y"] = $end_y; 
        $hdn_set["hdn_end_day"]["m"] = $end_m; 
        $hdn_set["hdn_end_day"]["d"] = $end_d; 
        $hdn_set["hdn_branch"]       = $_POST["form_branch"];
        $form->setConstants($hdn_set);

    }

}

/****************************/
// ���������»ܥܥ��󲡲���
/****************************/
if ($_POST["renew_flg"] == "true"){

    // ������������hidden�����
    $clear_hdn["renew_flg"] = "";
    $form->setConstants($clear_hdn);

    // ���顼��̵�����
    if ($err_flg != true){

        // ���������»�
        //2009-10-17 aoyama-n
        #$return_renew = Renew_Operate($db_con, $end_day);
        $return_renew = Renew_Operate($db_con, $start_day ,$end_day);

        // ����������λ��å�����
        $renew_msg = ($return_renew == true) ? "����������λ���ޤ�����" : null;

    }

}


/****************************/
// ����/��׶�ۼ���
/****************************/
// ���顼�Τʤ����
if ($err_flg != true){

    //2009-10-17 aoyama-n
    // ����̤�»��߷׶�ۼ���
    #$ary_total_daily    = Get_Total_Amount($db_con, "daily",   $staff_id, $shop_id, $monthly_renew_day, $end_day);
    // �����»ܺ��߷׶�ۼ���
    #$ary_total_halfway  = Get_Total_Amount($db_con, "halfway", $staff_id, $shop_id, $monthly_renew_day, $end_day);
    // ��ס���ȴ��ۡ˶�ۼ���
    #$ary_total_notax    = Get_Total_Amount($db_con, "notax",   $staff_id, $shop_id, $monthly_renew_day, $end_day);
    // ��סʾ����ǳۡ˶�ۼ���
    #$ary_total_tax      = Get_Total_Amount($db_con, "tax",     $staff_id, $shop_id, $monthly_renew_day, $end_day);
    // ��סʰ������ǡ˶�ۼ���
    #$ary_total_lump     = Get_Lump_Amount ($db_con, $staff_id, $shop_id, $monthly_renew_day, $end_day, "2");
    // ��סʥ����ƥ��˶�ۼ���
    #$ary_total_royalty  = Get_Royal_Amount($db_con, $staff_id, $shop_id, $monthly_renew_day, $end_day, "1");
    // ��סʹ�ס˶�ۼ���
    #$ary_total_monthly  = Get_Total_Amount($db_con, "monthly", $staff_id, $shop_id, $monthly_renew_day, $end_day);

    // ����̤�»��߷׶�ۼ���
    $ary_total_daily    = Get_Total_Amount($db_con, "daily",   $staff_id, $shop_id, $start_day, $end_day);
    // �����»ܺ��߷׶�ۼ���
    $ary_total_halfway  = Get_Total_Amount($db_con, "halfway", $staff_id, $shop_id, $start_day, $end_day);
    // ��ס���ȴ��ۡ˶�ۼ���
    $ary_total_notax    = Get_Total_Amount($db_con, "notax",   $staff_id, $shop_id, $start_day, $end_day);
    // ��סʾ����ǳۡ˶�ۼ���
    $ary_total_tax      = Get_Total_Amount($db_con, "tax",     $staff_id, $shop_id, $start_day, $end_day);
    // ��סʰ������ǡ˶�ۼ���
    $ary_total_lump     = Get_Lump_Amount ($db_con, $staff_id, $shop_id, $start_day, $end_day, "2");
    // ��סʥ����ƥ��˶�ۼ���
    $ary_total_royalty  = Get_Royal_Amount($db_con, $staff_id, $shop_id, $start_day, $end_day, "1");
    // ��סʹ�ס˶�ۼ���
    $ary_total_monthly  = Get_Total_Amount($db_con, "monthly", $staff_id, $shop_id, $start_day, $end_day);

}

/****************************/
// ����/��׶�۽���html����
/****************************/
// ���顼�Τʤ����
if ($err_flg != true){

    $td_opt  = " class=\"Value\" align=\"right\"";

    $html_t  = "<table class=\"Data_Table\" border=\"1\">\n";
    $html_t .= "<col width=\"40\" style=\"font-weight: bold;\">\n";
    $html_t .= "<col width=\"100\" style=\"font-weight: bold;\">\n";
    $html_t .= "<col span=\"4\" width=\"100\">\n";
    $html_t .= "<tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_t .= "    <td class=\"Title_Green\" colspan=\"2\"></td>\n";
    $html_t .= "    <td class=\"Title_Green\">�����</td>\n";
    $html_t .= "    <td class=\"Title_Green\">������</td>\n";
    $html_t .= "    <td class=\"Title_Green\">�������</td>\n";
    $html_t .= "    <td class=\"Title_Green\">��ʧ���</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\" colspan=\"2\">����̤�»��߷�</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_daily[0])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_daily[1])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_daily[2])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_daily[3])."</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\" colspan=\"2\">�����»ܺ��߷�</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_halfway[0])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_halfway[1])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_halfway[2])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_halfway[3])."</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\" rowspan=\"5\">���</td>\n";
    $html_t .= "    <td class=\"Title_Green\">��ȴ���</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_notax[0])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_notax[2])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\">�����ǳ�</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_tax[0])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_tax[2])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\">��������</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_lump[0])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_lump[1])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\">�����ƥ�</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_royalty[0])."</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "    <td class=\"Value\" align=\"center\">-</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "<tr>\n";
    $html_t .= "    <td class=\"Title_Green\">�ǹ����</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_monthly[0] + $ary_total_lump[0] + $ary_total_royalty[0])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_monthly[1])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_monthly[2] + $ary_total_lump[1])."</td>\n";
    $html_t .= "    <td$td_opt>".Numformat_Ortho($ary_total_monthly[3])."</td>\n";
    $html_t .= "</tr>\n";
    $html_t .= "</table>\n";

}


/****************************/
// ���ٶ�ۼ���
/****************************/
// ���顼��̵�����
if ($err_flg != true){

    /* ������ٶ�ۼ��� */
    // ����̤�»��߷�
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Sale_Sql("daily",   $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("daily",   $staff_id, $shop_id, $start_day, $end_day);
    $res_sale_daily         = Db_Query($db_con, $sql);
    $num_sale_daily         = pg_num_rows($res_sale_daily);
    $ary_sale_daily         = Two_To_Linear(Get_Data($res_sale_daily,   "2", "ASSOC"));
    // �����»ܺ��߷�
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Sale_Sql("halfway", $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("halfway", $staff_id, $shop_id, $start_day, $end_day);
    $res_sale_halfway       = Db_Query($db_con, $sql);
    $num_sale_halfway       = pg_num_rows($res_sale_halfway);
    $ary_sale_halfway       = Two_To_Linear(Get_Data($res_sale_halfway, "2", "ASSOC"));
    // ���
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Sale_Sql("monthly", $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Sale_Sql("monthly", $staff_id, $shop_id, $start_day, $end_day);
    $res_sale_monthly       = Db_Query($db_con, $sql);
    $num_sale_monthly       = pg_num_rows($res_sale_monthly);
    $ary_sale_monthly       = Two_To_Linear(Get_Data($res_sale_monthly, "2", "ASSOC"));

    /* �������ٶ�ۼ��� */
    // ����̤�»��߷�
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Buy_Sql("daily",   $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Buy_Sql("daily",   $staff_id, $shop_id, $start_day, $end_day);
    $res_buy_daily          = Db_Query($db_con, $sql);
    $num_buy_daily          = pg_num_rows($res_buy_daily);
    $ary_buy_daily          = Two_To_Linear(Get_Data($res_buy_daily,   "2", "ASSOC"));
    // �����»ܺ��߷�
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Buy_Sql("halfway", $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Buy_Sql("halfway", $staff_id, $shop_id, $start_day, $end_day);
    $res_buy_halfway        = Db_Query($db_con, $sql);
    $num_buy_halfway        = pg_num_rows($res_buy_halfway);
    $ary_buy_halfway        = Two_To_Linear(Get_Data($res_buy_halfway, "2", "ASSOC"));
    // ���
    //2009-10-17 aoyama-n
    #$sql                    = Particular_Buy_Sql("monthly", $staff_id, $shop_id, $monthly_renew_day, $end_day);
    $sql                    = Particular_Buy_Sql("monthly", $staff_id, $shop_id, $start_day, $end_day);
    $res_buy_monthly        = Db_Query($db_con, $sql);
    $num_buy_monthly        = pg_num_rows($res_buy_monthly);
    $ary_buy_monthly        = Two_To_Linear(Get_Data($res_buy_monthly, "2", "ASSOC"));

    /* �������ٶ�ۼ��� */
    // ��Ԥ���Ϥ�������ʬ������
    $payin_bank_trade_list = array("32", "33", "35");
    // ��Ԥ�ɽ����������ʬ�ǥ롼��
    foreach ($payin_bank_trade_list as $key => $trade){
        // ��Ծ������
        //2009-10-17 aoyama-n
        #$sql                            = Bank_Payin_Sql($shop_id, $trade, $monthly_renew_day, $end_day);
        $sql                            = Bank_Payin_Sql($shop_id, $trade, $start_day, $end_day);
        $res_bank_list_payin            = Db_Query($db_con, $sql);
        $num_bank_list_payin            = pg_num_rows($res_bank_list_payin);
        $ary_bank_list_payin[$trade]    = Get_Data($res_bank_list_payin, "2", "ASSOC");
    }
    // �����ʬ��˼���������Ծ���ǥ롼��
    foreach ($ary_bank_list_payin as $key => $value){
        // ���������ʬ�˥ǡ�����������
        if ($value != null){
            // ����������Ծ���ǥ롼��
            for ($i=0; $i<count($value); $i++){
                // ������Ԥ����٤����
                //2009-10-17 aoyama-n
                #$sql                    = Particular_Payin_Bank_Sql($shop_id, $value[$i], $monthly_renew_day, $end_day);
                $sql                    = Particular_Payin_Bank_Sql($shop_id, $value[$i], $start_day, $end_day);
                $res_payin_bank         = Db_Query($db_con, $sql);
                $num_payin_bank         = pg_num_rows($res_payin_bank);
                $ary_payin_bank[$key][] = Two_To_Linear(Get_Data($res_payin_bank, "2", "ASSOC"));
            }
        // ���������ʬ�˥ǡ������ʤ����
        }else{
            // �����ͤ�����
            $ary_payin_bank[$key] = null;
        }
    }
    // ��Ԥ���Ϥ��ʤ������ʬ������
    $payin_nobank_trade_list = array("39", "31", "34", "36", "37", "38");
    // ��Ԥ���Ϥ��ʤ������ʬ�ǥ롼��
    foreach ($payin_nobank_trade_list as $key => $trade){
        // ��Ծ������
        //2009-10-17 aoyama-n
        #$sql                            = Particular_Payin_Nobank_Sql($shop_id, $staff_id, $trade, $monthly_renew_day, $end_day);
        $sql                            = Particular_Payin_Nobank_Sql($shop_id, $staff_id, $trade, $start_day, $end_day);
        $res_payin_nobank               = Db_Query($db_con, $sql);
        $num_payin_nobank               = pg_num_rows($res_payin_nobank);
        $ary_payin_nobank[$trade]       = Two_To_Linear(Get_Data($res_payin_nobank, "2", "ASSOC"));
    }


    /* ��ʧ���ٶ�ۼ��� */
    // ��Ԥ���Ϥ�������ʬ������
    $payout_bank_trade_list = array("43", "44", "48");
    // ��Ԥ�ɽ����������ʬ�ǥ롼��
    foreach ($payout_bank_trade_list as $key => $trade){
        // ��Ծ������
        //2009-10-17 aoyama-n
        #$sql                            = Bank_Payout_Sql($shop_id, $trade, $monthly_renew_day, $end_day);
        $sql                            = Bank_Payout_Sql($shop_id, $trade, $start_day, $end_day);
        $res_bank_list_payout           = Db_Query($db_con, $sql);
        $num_bank_list_payout           = pg_num_rows($res_bank_list_payout);
        $ary_bank_list_payout[$trade]   = Get_Data($res_bank_list_payout, "2", "ASSOC");
    }
    // �����ʬ��˼���������Ծ���ǥ롼��
    foreach ($ary_bank_list_payout as $key => $value){
        // ���������ʬ�˥ǡ�����������
        if ($value != null){
            // ����������Ծ���ǥ롼��
            for ($i=0; $i<count($value); $i++){
                // ������Ԥ����٤����
                //2009-10-17 aoyama-n
                #$sql                    = Particular_Payout_Bank_Sql($shop_id, $value[$i], $monthly_renew_day, $end_day);
                $sql                    = Particular_Payout_Bank_Sql($shop_id, $value[$i], $start_day, $end_day);
                $res_payout_bank        = Db_Query($db_con, $sql);
                $num_payout_bank        = pg_num_rows($res_payout_bank);
                $ary_payout_bank[$key][]= Two_To_Linear(Get_Data($res_payout_bank, "2", "ASSOC"));
            }
        // ���������ʬ�˥ǡ������ʤ����
        }else{
            // �����ͤ�����
            $ary_payout_bank[$key] = null;
        }
    }
    // ��Ԥ���Ϥ��ʤ������ʬ������
    $payout_nobank_trade_list = array("49", "41", "45", "46", "47");
    // ��Ԥ���Ϥ��ʤ������ʬ�ǥ롼��
    foreach ($payout_nobank_trade_list as $key => $trade){
        // ��Ծ������
        //2009-10-17 aoyama-n
        #$sql                            = Particular_Payout_Nobank_Sql($shop_id, $trade, $monthly_renew_day, $end_day);
        $sql                            = Particular_Payout_Nobank_Sql($shop_id, $trade, $start_day, $end_day);
        $res_payout_nobank              = Db_Query($db_con, $sql);
        $num_payout_nobank              = pg_num_rows($res_payout_nobank);
        $ary_payout_nobank[$trade]      = Two_To_Linear(Get_Data($res_payout_nobank, "2", "ASSOC"));
    }


    /****************************/
    // �����ǡ���������Ѥ�����
    /****************************/
    /* �������� */
    // �����ʬ��˼���������ԥǡ����ǥ롼��
    foreach ($ary_payin_bank as $key_trade => $value_trade){
        // ���������ʬ�˥ǡ�����������
        if ($value_trade != null){
            // �����˥롼��
            foreach ($value_trade as $key_bank => $value_bank){
                // ��ԥ����ɡ���Ź������
                $ary_payin_bank[$key_trade][$key_bank]["bank_b_bank_cd"]    = $value_bank["bank_cd"]."-".
                                                                              $value_bank["b_bank_cd"];
                // ���̾����Ź̾�������ֹ�
                $ary_payin_bank[$key_trade][$key_bank]["bank_b_bank_name"]  = htmlspecialchars($value_bank["bank_name"])." ".
                                                                              htmlspecialchars($value_bank["b_bank_name"])." ".
                                                                              $value_bank["account_no"];
            }
        }
    }

    /* ��ʧ���� */
    // ��Ԥ���Ϥ�������ʬ��˼��������ǡ����Υ롼��
    foreach ($ary_payout_bank as $key_trade => $value_trade){
        // ���������ʬ�μ����ǡ�����������
        if ($value_trade != null){
            // �����˥롼��
            foreach ($value_trade as $key_bank => $value_bank){
                // ��ԥ����ɡ���Ź������
                $ary_payout_bank[$key_trade][$key_bank]["bank_b_bank_cd"]   = $value_bank["bank_cd"]."-".
                                                                              $value_bank["b_bank_cd"];
                // ���̾����Ź̾�������ֹ�
                $ary_payout_bank[$key_trade][$key_bank]["bank_b_bank_name"] = htmlspecialchars($value_bank["bank_name"])." ".
                                                                              htmlspecialchars($value_bank["b_bank_name"])." ".
                                                                              $value_bank["account_no"];
            }
        }
    }


    /****************************/
    // �Ƽ����ʬ�ι�פ򻻽�
    /****************************/
    /* ������� */
    // �롼���������������������ʬ��
    $ary_sale_div   = array("00");
    foreach ($ary_sale_div as $key => $value){
        // ������� - ��ۡ�����̤�»��߷ס�
        $ary_sale_total["genkin_sale"]          += $ary_sale_daily["genkin_".$value."_sale"];
        // ������� - ��ۡ������»ܺ��߷ס�
        $ary_sale_total["genkin_halfway"]       += $ary_sale_halfway["genkin_".$value."_sale"];
        // ������� - ����ʹ�ס�
        $ary_sale_total["genkin_count"]         += $ary_sale_monthly["genkin_".$value."_count"];
        // ������� - �����ʹ�ס�
        $ary_sale_total["genkin_cost"]          += $ary_sale_monthly["genkin_".$value."_cost"];
        // ������� - ��ۡʹ�ס�
        $ary_sale_total["genkin_monthly"]       += $ary_sale_monthly["genkin_".$value."_sale"];
        // ����� - ��ۡ�����̤�»��߷ס�
        $ary_sale_total["kake_sale"]            += $ary_sale_daily["kake_".$value."_sale"];
        // ����� - ��ۡ������»ܺ��߷ס�
        $ary_sale_total["kake_halfway"]         += $ary_sale_halfway["kake_".$value."_sale"];
        // ����� - ����ʹ�ס�
        $ary_sale_total["kake_count"]           += $ary_sale_monthly["kake_".$value."_count"];
        // ����� - �����ʹ�ס�
        $ary_sale_total["kake_cost"]            += $ary_sale_monthly["kake_".$value."_cost"];
        // ����� - ��ۡʹ�ס�
        $ary_sale_total["kake_monthly"]         += $ary_sale_monthly["kake_".$value."_sale"];
    }
    // ������� - ��ۡ�����̤�»��߷ס�
    $ary_sale_total["genkin_sale"]              += $ary_sale_daily["genkin_tax"];
    // ������� - ��ۡ�����̤�»��߷ס�
    $ary_sale_total["genkin_halfway"]           += $ary_sale_halfway["genkin_tax"];
    // ������� - ��ۡʹ�ס�
    $ary_sale_total["genkin_monthly"]           += $ary_sale_monthly["genkin_tax"];
    // ����� - ��ۡ�����̤�»��߷ס�
    $ary_sale_total["kake_sale"]                += $ary_sale_daily["kake_tax"];
    // ����� - ��ۡ������»ܺ��߷ס�
    $ary_sale_total["kake_halfway"]             += $ary_sale_halfway["kake_tax"];
    // ����� - ��ۡʹ�ס�
    $ary_sale_total["kake_monthly"]             += $ary_sale_monthly["kake_tax"];

    /* �������� */
    // ������� - ��ۡ�����̤�»��߷ס�
    $ary_buy_total["genkin_amount"]             = $ary_buy_daily["genkin_amount"]
                                                + $ary_buy_daily["genkin_tax"];
    // ������� - ��ۡ������»ܺ��߷ס�
    $ary_buy_total["genkin_halfway"]            = $ary_buy_halfway["genkin_amount"]
                                                + $ary_buy_halfway["genkin_tax"];
    // ������� - ����ʹ�ס�
    $ary_buy_total["genkin_count"]              = $ary_buy_monthly["genkin_count"];
    // ������� - ��ۡʹ�ס�
    $ary_buy_total["genkin_monthly"]            = $ary_buy_monthly["genkin_amount"]
                                                + $ary_buy_monthly["genkin_tax"];
    // �ݻ��� - ��ۡ�����̤�»��߷ס�
    $ary_buy_total["kake_amount"]               = $ary_buy_daily["kake_amount"]
                                                + $ary_buy_daily["kake_tax"];
    // �ݻ��� - ��ۡ������»ܺ��߷ס�
    $ary_buy_total["kake_halfway"]              = $ary_buy_halfway["kake_amount"]
                                                + $ary_buy_halfway["kake_tax"];
    // �ݻ��� - ����ʹ�ס�
    $ary_buy_total["kake_count"]                = $ary_buy_monthly["kake_count"];
    // �ݻ��� - ��ۡʹ�ס�
    $ary_buy_total["kake_monthly"]              = $ary_buy_monthly["kake_amount"]
                                                + $ary_buy_monthly["kake_tax"];

    /* �������� */
    // ��Ԥ���Ϥ�������ʬ��˼��������ǡ����Υ롼��
    foreach ($ary_payin_bank as $key_trade => $value_trade){
        // ���������ʬ�μ����ǡ�����������
        if ($value_trade != null){
            // �����˥롼��
            foreach ($value_trade as $key_bank => $value_bank){
                // ��ۡ�����̤�»��߷ס�
                $ary_payin_total[$key_trade]["daily_amount"]    += $value_bank["daily_amount"];
                // ��ۡ������»ܺ��߷ס�
                $ary_payin_total[$key_trade]["halfway_amount"]  += $value_bank["halfway_amount"];
                // ���ٷ���ʹ�ס�
                $ary_payin_total[$key_trade]["monthly_count"]   += $value_bank["monthly_count"];
                // ��ۡʹ�ס�
                $ary_payin_total[$key_trade]["monthly_amount"]  += $value_bank["monthly_amount"];
            }
        // ���������ʬ�μ����ǡ�����������
        }else{
            // ��ۡ�����̤�»��߷ס�
            $ary_payin_total[$key_trade]["daily_amount"]        += 0;
            // ��ۡ������»ܺ��߷ס�
            $ary_payin_total[$key_trade]["halfway_amount"]      += 0;
            // ���ٷ���ʹ�ס�
            $ary_payin_total[$key_trade]["monthly_count"]       += 0;
            // ��ۡʹ�ס�
            $ary_payin_total[$key_trade]["monthly_amount"]      += 0;
        }
    }
    // ��Ԥ���Ϥ��ʤ������ʬ��˼��������ǡ����Υ롼��
    foreach ($ary_payin_nobank as $key_trade => $value_trade){
        // ��ۡ�����̤�»��߷ס�
        $ary_payin_total[$key_trade]["daily_amount"]            = $value_trade["daily_amount"];
        // ��ۡ������»ܺ��߷ס�
        $ary_payin_total[$key_trade]["halfway_amount"]          = $value_trade["halfway_amount"];
        // ���ٷ���ʹ�ס�
        $ary_payin_total[$key_trade]["monthly_count"]           = $value_trade["monthly_count"];
        // ��ۡʹ�ס�
        $ary_payin_total[$key_trade]["monthly_amount"]          = $value_trade["monthly_amount"];
    }

    /* ��ʧ���� */
    // ��Ԥ���Ϥ�������ʬ��˼��������ǡ����Υ롼��
    foreach ($ary_payout_bank as $key_trade => $value_trade){
        // ���������ʬ�μ����ǡ�����������
        if ($value_trade != null){
            // �����˥롼��
            foreach ($value_trade as $key_bank => $value_bank){
                // ��ۡ�����̤�»��߷ס�
                $ary_payout_total[$key_trade]["daily_amount"]   += $value_bank["daily_amount"];
                // ��ۡ������»ܺ��߷ס�
                $ary_payout_total[$key_trade]["halfway_amount"] += $value_bank["halfway_amount"];
                // ���ٷ���ʹ�ס�
                $ary_payout_total[$key_trade]["monthly_count"]  += $value_bank["monthly_count"];
                // ��ۡʹ�ס�
                $ary_payout_total[$key_trade]["monthly_amount"] += $value_bank["monthly_amount"];
            }
        // ���������ʬ�μ����ǡ�����������
        }else{
            // ��ۡ�����̤�»��߷ס�
            $ary_payout_total[$key_trade]["daily_amount"]       += 0;
            // ��ۡ������»ܺ��߷ס�
            $ary_payout_total[$key_trade]["halfway_amount"]     += 0;
            // ���ٷ���ʹ�ס�
            $ary_payout_total[$key_trade]["monthly_count"]      += 0;
            // ��ۡʹ�ס�
            $ary_payout_total[$key_trade]["monthly_amount"]     += 0;
        }
    }
    // ��Ԥ���Ϥ��ʤ������ʬ��˼��������ǡ����Υ롼��
    foreach ($ary_payout_nobank as $key_trade => $value_trade){
        // ��ۡ�����̤�»��߷ס�
        $ary_payout_total[$key_trade]["daily_amount"]           = $value_trade["daily_amount"];
        // ��ۡ������»ܺ��߷ס�
        $ary_payout_total[$key_trade]["halfway_amount"]         = $value_trade["halfway_amount"];
        // ���ٷ���ʹ�ס�
        $ary_payout_total[$key_trade]["monthly_count"]          = $value_trade["monthly_count"];
        // ��ۡʹ�ס�
        $ary_payout_total[$key_trade]["monthly_amount"]         = $value_trade["monthly_amount"];
    }


    /****************************/
    // HTML����
    /****************************/
    $html_m = null; 

    /* ������� */
    $row   = 0;
    $ary_genkin_kake    = array(
        "genkin"    => "����", 
        "kake"      => "��");
    $ary_sale_div       = array(
        "00"        => "��",
    );
    // ���html����
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">��������١�</td> \n";
    $html_m .= "</tr>\n";
    foreach ($ary_genkin_kake as $key_g_k => $value_g_k){
        foreach ($ary_sale_div as $key_s_d => $value_s_d){
            if ($key_g_k != "genkin" || $key_s_d != "08"){
    // �����ʬ��
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value_g_k."����</td>\n";
    $html_m .= "    <td>��".$value_s_d."��</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_".$key_s_d."_sale"])."</td>\n";
    $html_m .= "</tr>\n";
            }
        }
    // ��ɼ������
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value_g_k."����</td>\n";
    $html_m .= "    <td>����ɼ�����ǡ�</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_tax"])."</td>\n";
    $html_m .= "</tr>\n";
    // ���������
    $html_m .= "<tr class=\"Result5\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td>��������������ʡ�</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_daily[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_halfway[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_monthly[$key_g_k."_gai_sale"])."</td>\n";
    $html_m .= "</tr>\n";
    // ��ɼ������
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>�ڹ�ס�</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_sale"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_halfway"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_count"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_cost"])."</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_sale_total[$key_g_k."_monthly"])."</td>\n";
    $html_m .= "</tr>\n";
        if ($key_g_k == "genkin"){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "<td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        }
    }

    /* �������� */
    $row = 0;
    $ary_payin_trade = array(
        // "�����ʬ������" => array(��Խ���̵ͭ�ե饰, "�����ʬ̾")
        "39" => array(false, "�������"),
        "31" => array(false, "����"),
        "32" => array(true,  "��������"),
        "33" => array(true,  "�������"),
        "34" => array(false, "�껦"),
        "35" => array(true,  "�����"),
        "36" => array(false, "����¾����"),
        "37" => array(false, "�����å��껦"),
        "38" => array(false, "����Ĵ��"),
    );
    // ����html����
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">���������١�</td>\n";
    $html_m .= "</tr>\n";
    foreach ($ary_payin_trade as $key_trade1 => $value_trade1){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value_trade1[1]."��</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        if ($value_trade1[0] == true){
            foreach ($ary_payin_bank as $key_trade2 => $value_trade2){
                if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                    foreach ($value_trade2 as $key_bank => $value_bank){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td>".$value_bank["bank_b_bank_cd"]."<br>".$value_bank["bank_b_bank_name"]."<br></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
                    }
                }
            }
        }
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>�ڹ�ס�</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payin_total[$key_trade1]["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
    }

    /* �������� */
    $row = 0;
    $ary_genkin_kake    = array(
        "genkin"    => "����",
        "kake"      => "��",
    );
    // ����html����
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">�ڻ������١�</td>\n";
    $html_m .= "</tr>\n";
    foreach ($ary_genkin_kake as $key => $value){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value."������</td>\n";
    $html_m .= "    <td>�ھ��ʡ�</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_daily[$key."_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_halfway[$key."_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_amount"])."</td>\n";
    $html_m .= "</tr>\n";
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value."������</td>\n";
    $html_m .= "    <td>����ɼ�����ǡ�</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_daily[$key."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_halfway[$key."_tax"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_monthly[$key."_tax"])."</td>\n";
    $html_m .= "</tr>\n";
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>�ڹ�ס�</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_halfway"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_buy_total[$key."_monthly"])."</td>\n";
    $html_m .= "</tr>\n";
        if ($key == "genkin"){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        }
    }

    /* ��ʧ���� */
    $row = 0;
    $ary_payout_trade = array(
        // "�����ʬ������" => array(��Խ���̵ͭ�ե饰, "�����ʬ̾")
        "49" => array(false, "�������"),
        "41" => array(false, "�����ʧ"),
        "43" => array(true,  "������ʧ"),
        "44" => array(false, "�����ʧ"),
        "45" => array(true,  "�껦"),
        "46" => array(false, "��ʧĴ��"),
        "47" => array(false, "����¾��ʧ"),
        "48" => array(false, "�����"),
    );
    // ��ʧhtml����
    $html_m .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
    $html_m .= "    <td colspan=\"11\">�ڻ�ʧ���١�</td>\n";
    $html_m .= "</tr>\n";
    foreach ($ary_payout_trade as $key_trade1 => $value_trade1){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td>��".$value_trade1[1]."��</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "</tr>\n";
        if ($value[0] == true){
            foreach ($ary_payout_bank as $key_trade2 => $value_trade2){
                if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                    foreach ($value_trade2 as $key_bank => $value_bank){
    $html_m .= "<tr class=\"Result1\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td>".$value_bank["bank_b_bank_cd"]."<br>".$value_bank["bank_b_bank_name"]."<br></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($value_bank["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
                    }
                }
            }
        }
    $html_m .= "<tr class=\"Result2\">\n";
    $html_m .= "    <td align=\"right\">".++$row."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td><b>�ڹ�ס�</b></td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["daily_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["halfway_amount"])."</td>\n";
    $html_m .= "    <td></td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["monthly_count"])."</td>\n";
    $html_m .= "    <td align=\"center\">-</td>\n";
    $html_m .= "    <td align=\"right\">".Numformat_Ortho($ary_payout_total[$key_trade1]["monthly_amount"])."</td>\n";
    $html_m .= "</tr>\n";
    }

}

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
$page_menu = Create_Menu_h("renew", "1");

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",
    "err_flg"           => "$err_flg",
    "renew_msg"         => "$renew_msg",
));
$smarty->assign("print", array(
    "monthly_renew_day" => "$monthly_renew_day",
    "end_day"           => "$end_day",
    "staff_name"        => $ary_total_daily[1],
));
$smarty->assign("html", array(
    "html_t"            => "$html_t",
    "html_m"            => "$html_m",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
