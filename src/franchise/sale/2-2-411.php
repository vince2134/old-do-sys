<?php
/*
 *
 *
 *
 *
 */

$page_title = "����������";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();


/*****************************/
// ���´�Ϣ����
/*****************************/
// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("advance");
}


/*****************************/
// �����ѿ�����
/*****************************/
// SESSION
$shop_id        = $_SESSION["client_id"];           // ����å�ID
$group_kind     = $_SESSION["group_kind"];          // ���롼�׼���
$staff_id       = $_SESSION["staff_id"];            // �����å�ID
$staff_name     = $_SESSION["staff_name"];          // �����å�̾

// POST
$advance_id     = $_POST["hdn_advance_id"];         // ������ID����ɼ�ѹ����˻��ѡ�
$client_id      = $_POST["hdn_client_id"];          // ������ID����ɼ�ѹ����˻��ѡ�
$enter_day      = $_POST["hdn_enter_day"];          // �ǡ�����Ͽ��������ɼ�ѹ����˻��ѡ�


/****************************/
// GET����ID�������������å�
/****************************/
// ���ɽ������GET��ID��������
if ($_POST["post_flg"] != "true" && $_GET["advance_id"] != null){

    // GET������ʧID�������������å�
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["advance_id"], "advance_id", "t_advance", "num", "shop_id = $shop_id");
    if ($safe_flg === false){ 
        header("Location:../top.php");
        exit;   
    }

    $advance_id = $_GET["advance_id"];      // ������ID

    // hidden��������ID�򥻥å�
    $hdn_set["hdn_advance_id"] = $advance_id;
    $form->setConstants($hdn_set);

}


/****************************/
// GET����ID����ɼ�ǡ�������
/****************************/
// ���ɽ������GET��ID��������
if ($_POST["post_flg"] != "true" && $_GET["advance_id"] != null){

    // ��ɼ�ǡ�������������
    $sql  = "SELECT \n";
    $sql .= "   t_advance.advance_id, \n";                                      // ������ID
    $sql .= "   t_advance.advance_no, \n";                                      // ��ɼ�ֹ�
    $sql .= "   t_advance.pay_day, \n";                                         // ������

    $sql .= "   t_advance.client_id, \n";                                       // ������ID
    $sql .= "   t_client.client_cd1, \n";                                       // �����襳���ɣ�
    $sql .= "   t_client.client_cd2, \n";                                       // �����襳���ɣ�
    $sql .= "   t_client.client_cname, \n";                                     // ������̾ά��
    $sql .= "   t_advance.client_cd1            AS client_cd1_fix, \n";         // �����襳���ɣ��ʳ�����ѡ�
    $sql .= "   t_advance.client_cd2            AS client_cd2_fix, \n";         // �����襳���ɣ��ʳ�����ѡ�
    $sql .= "   t_advance.client_cname          AS client_cname_fix, \n";       // ������̾ά�Ρʳ�����ѡ�

    $sql .= "   t_advance.claim_div, \n";                                       // �������ʬ
    $sql .= "   t_advance.claim_id, \n";                                        // ������ID
    $sql .= "   t_advance.claim_cd1             AS claim_cd1_fix, \n";          // �����襳���ɣ��ʳ�����ѡ�
    $sql .= "   t_advance.claim_cd2             AS claim_cd2_fix, \n";          // �����襳���ɣ��ʳ�����ѡ�
    $sql .= "   t_advance.claim_cname           AS claim_cname_fix, \n";        // ������̾ά�Ρʳ�����ѡ�

    $sql .= "   t_advance.amount, \n";                                          // ���
    $sql .= "   t_advance.bank_id, \n";                                         // ���ID
    $sql .= "   t_advance.bank_cd               AS bank_cd_fix, \n";            // ��ԥ����ɡʳ�����ѡ�
    $sql .= "   t_advance.bank_name             AS bank_name_fix, \n";          // ���̾�ʳ�����ѡ�
    $sql .= "   t_advance.b_bank_id, \n";                                       // ��ŹID
    $sql .= "   t_advance.b_bank_cd             AS b_bank_cd_fix, \n";          // ��Ź�����ɡʳ�����ѡ�
    $sql .= "   t_advance.b_bank_name           AS b_bank_name_fix, \n";        // ��Ź̾�ʳ�����ѡ�
    $sql .= "   t_advance.account_id, \n";                                      // ����ID
    $sql .= "   CASE t_advance.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "   END                             AS deposit_kind_fix, \n";       // �¶���ܡʳ�����ѡ�
    $sql .= "   t_advance.account_no            AS account_no_fix, \n";         // �����ֹ�ʳ�����ѡ�

    $sql .= "   t_advance.staff_id, \n";                                        // ô����ID
    $sql .= "   t_advance.note, \n";                                            // ����
    $sql .= "   t_advance.fix_day, \n";                                         // �����������
    $sql .= "   t_advance.enter_day \n";                                        // ��ɼ��������

    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "   LEFT JOIN t_client \n";
    $sql .= "       ON t_advance.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_client AS t_c_claim \n";
    $sql .= "       ON t_advance.client_id = t_c_claim.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_advance.advance_id = $advance_id \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �쥳���ɤ�������
    if ($num > 0){

        // �ǡ�������
        $get_data = Get_Data($res, "2", "ASSOC");

        // �����ǡ������ѿ��˥��å�
        $client_id  = $get_data[0]["client_id"];                           // ������ID
        $fix_flg    = ($get_data[0]["fix_day"] != null) ? true : false;    // ����ե饰

        // �����ǡ�����ե����ࡦhidden�˥��å�
        $form_set["hdn_client_id"]          = $get_data[0]["client_id"];
        $form_set["form_advance_no"]        = $get_data[0]["advance_no"];
        $form_set["form_pay_day"]["y"]      = substr($get_data[0]["pay_day"], 0, 4);
        $form_set["form_pay_day"]["m"]      = substr($get_data[0]["pay_day"], 5, 2);
        $form_set["form_pay_day"]["d"]      = substr($get_data[0]["pay_day"], 8, 2);
        if ($fix_flg != true){
            // ̤�����
            $form_set["form_client"]["cd1"] = $get_data[0]["client_cd1"];
            $form_set["form_client"]["cd2"] = $get_data[0]["client_cd2"];
            $form_set["form_client"]["name"]= $get_data[0]["client_cname"];
            $form_set["form_claim"]         = $get_data[0]["claim_div"];
            $form_set["form_bank"][0]       = $get_data[0]["bank_id"];
            $form_set["form_bank"][1]       = $get_data[0]["b_bank_id"];
            $form_set["form_bank"][2]       = $get_data[0]["account_id"];
            $form_set["form_amount"]        = $get_data[0]["amount"];
        }else{
            // ����ѻ�
            $form_set["form_client"]["cd1"] = $get_data[0]["client_cd1_fix"];
            $form_set["form_client"]["cd2"] = $get_data[0]["client_cd2_fix"];
            $form_set["form_client"]["name"]= $get_data[0]["client_cname_fix"];
            $form_set["form_claim"]         = $get_data[0]["claim_cd1_fix"]."-";
            $form_set["form_claim"]        .= $get_data[0]["claim_cd2_fix"]." ";
            $form_set["form_claim"]        .= htmlspecialchars($get_data[0]["claim_cname_fix"]);
            // ��Ԥ���Ͽ����Ƥ�����
            if ($get_data[0]["bank_id"] != null){
                $form_set["form_bank"]      = $get_data[0]["bank_cd_fix"]." �� ";
                $form_set["form_bank"]     .= htmlspecialchars($get_data[0]["bank_name_fix"])."��";
                $form_set["form_bank"]     .= $get_data[0]["b_bank_cd_fix"]." �� ";
                $form_set["form_bank"]     .= htmlspecialchars($get_data[0]["bank_name_fix"])."��";
                $form_set["form_bank"]     .= $get_data[0]["deposit_kind_fix"]." �� ";
                $form_set["form_bank"]     .= $get_data[0]["account_no_fix"];
            // ��Ԥ���Ͽ����Ƥ��ʤ����
            }else{
                $form_set["form_bank"]      = null;
            }
            $form_set["form_amount"]        = number_format($get_data[0]["amount"]);
        }
        $form_set["form_staff"]             = $get_data[0]["staff_id"];
        $form_set["form_note"]              = $get_data[0]["note"];
        $form_set["hdn_enter_day"]          = $get_data[0]["enter_day"];
        $form->setConstants($form_set);

    }

}


/****************************/
// ������ե���������ϡ��䴰����
/****************************/
// �����踡���ե饰��true�ξ��
if ($_POST["client_search_flg"] == "true"){

    // POST���줿�����襳���ɤ��ѿ�������
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // ������ξ�������
    $sql  = "SELECT \n";
    $sql .= "   client_id,\n";
    $sql .= "   client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id IN ".Rank_Sql2()." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����ǡ�����������
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // ������ID
        $client_name    = pg_fetch_result($res, 0, 1);      // ������̾��ά�Ρ�
        $claim_div      = 1;                                // �������ʬ����ǥե���ȤȤ���
    }else{
        $client_id      = "";
        $client_name    = "";
        $claim_div      = "";
    }
    // �����襳�������ϥե饰�򥯥ꥢ
    // ������ID��������̾��ά�Ρˡ���������֡��������ʬ��ե�����˥��å�
    $set_client_data["client_search_flg"]   = "";
    $set_client_data["hdn_client_id"]       = $client_id;
    $set_client_data["form_client"]["name"] = $client_name;
    $set_client_data["form_claim_select"]   = $claim_div;
    $form->setConstants($set_client_data);

}


/*****************************/
// ��ǧ���̤ǥʥ�С��ե����ޥåȤ��줿�ե�����ο��ͤ��饫��ޤ����
/*****************************/
// ��ǧ�ܥ��󲡲�������ǧ���̤����ܥ��󲡲���
if ($_POST["ok_button"] != null || $_POST["confirm_flg"] == "false"){

    // �ʥ�С��ե����ޥåȤ���Ƥ����ۤ�POST�ǡ������饫��ޤ����
    $_POST["form_amount"] = $form_set["form_amount"] = str_replace(",", "", $_POST["form_amount"]);

    // �ե�����˥��å�
    $form->setConstants($form_set);

}


/*****************************/
// �ե�����ѡ������
/*****************************/
// ��ɼ�ֹ�
$form->addElement("text", "form_advance_no", "", "size=\"11\" maxLength=\"8\" tabindex=\"-1\"
    style=\"color: #525552; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly
");

// ������
Addelement_Date($form, "form_pay_day", "������", "-");

// ��������
$form->addElement("link", "form_client_link", "", "#", "������", "taxindex=\"-1\"
    onClick=\"return Open_SubWin('../dialog/2-0-402.php',
        Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]', 'client_search_flg'),
        500, 450, 5, 1
    );\"
");

// ������
$text   =   null; 
$text[] =&  $form->createElement("text", "cd1", "", "
    size=\"7\" maxLength=\"6\" class=\"ime_disabled\" $g_form_option
    onChange=\"javascript:Change_Submit('client_search_flg', '#', 'true', 'form_client[cd2]');\"
    onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]', 6);\"
");
$text[] =&  $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "
    size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option
    onChange=\"javascript:Button_Submit('client_search_flg', '#', 'true');\"
");
$text[] =&  $form->createElement("static", "", "", " ");
$text[] =&  $form->createElement("text", "name", "", "size=\"34\" onKeyDown=\"chgKeycode();\" $g_text_readonly");
$form->addGroup($text, "form_client", "", "");

// ������
if ($fix_flg != true){
    $item   =   null;
    $item   =   ($client_id != null) ? Select_Get($db_con, "claim_payin", "t_claim.client_id = $client_id ") : null;
    unset($item[null]);
    $form->addElement("select", "form_claim", "", $item, $g_form_option_select);
}else{
    $form->addElement("static", "form_claim", "", "");
}

// ���
if ($fix_flg != true){
    $item   =   null;
    $item   =   Make_Ary_Bank($db_con);
    $obj    =   null;
    $obj    =&  $form->addElement("hierselect", "form_bank", "", "", "��", $g_form_option_select);
    $obj->setOptions($item);
}else{
    $form->addElement("static", "form_bank", "", "");
}

// ���
$form->addElement("text", "form_amount", "", "
    class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
");

// ô����
$item   =   null;
$item   =   Select_Get($db_con, "round_staff_ms");
$form->addElement("select", "form_staff", "", $item, $g_form_option_select);

// ����
$form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"20\" $g_form_option");

// ��ǧ���̤إܥ���
$form->addElement("button", "confirm_button", "��ǧ���̤�", "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled");

// ��Ͽ�ܥ���
$form->addElement("button", "hdn_ok_button", "�С�Ͽ", "onClick=\"javascript: Double_Post_Prevent2(this);\" $disabled");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./2-2-412.php", "������" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list, 2);

// hidden
$form->addElement("hidden", "hdn_advance_id");      // ������ID
$form->addElement("hidden", "hdn_client_id");       // ������ID
$form->addElement("hidden", "hdn_enter_day");       // ��ɼ��������
$form->addElement("hidden", "client_search_flg");   // �����踡���ե饰
$form->addElement("hidden", "ok_button");           // ��Ͽ�ܥ��󲡲�
$form->addElement("hidden", "confirm_flg");         // ��ǧ���̤إܥ��󲡲��ե饰�ʳ�ǧ���̤������ܥ���򲡲���������false��
$form->addElement("hidden", "post_flg", "true");    // ������POST��ǧ�ե饰�ʽ��ɽ�����Τ�null��

// ���顼���å���
$form->addElement("text", "err_illegal_post");      // �����襳�����ѹ���˳�ǧ���̤إܥ��󤬲����줿���˥��顼��å��������å�


/****************************/
// ���̥��顼�����å�
/****************************/
// ��ǧ���̤إܥ��󡢳�ǧ�ܥ��󲡲���
if ($_POST["confirm_flg"] == "true" || $_POST["ok_button"] != null){

    // ��ǧ���̤إܥ��󲡲��ե饰�򥯥ꥢ
    // ��ǧ�ܥ��󲡲��ե饰�򥯥ꥢ
    $hdn_clear["confirm_flg"]   = "";
    $hdn_clear["ok_button"]     = "";
    $form->setConstants($hdn_clear);

    /****************************/
    // ���顼�����å�������
    /****************************/
    // ���դ�0���
    $_POST["form_pay_day"] = Str_Pad_Date($_POST["form_pay_day"]);

    // ���դ��ѿ���
    $pay_day_y  = $_POST["form_pay_day"]["y"];
    $pay_day_m  = $_POST["form_pay_day"]["m"];
    $pay_day_d  = $_POST["form_pay_day"]["d"];
    $pay_day    = $pay_day_y."-".$pay_day_m."-".$pay_day_d;

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��������

        // ɬ�ܥ����å�
        if ($pay_day_y == null && $pay_day_m == null && $pay_day_d == null){
            $form->setElementError("form_pay_day", "������ ��ɬ�ܤǤ���");
        }

        // Ⱦü���ϥ����å�
        elseif (!($pay_day_y != null && $pay_day_m != null && $pay_day_d != null)){
            $form->setElementError("form_pay_day", "������ �����դ������ǤϤ���ޤ���");
        }

        // ���ͥ����å�
        elseif (!ereg("^[0-9]+$", $pay_day_y) || !ereg("^[0-9]+$", $pay_day_m) || !ereg("^[0-9]+$", $pay_day_d)){
            $form->setElementError("form_pay_day", "������ �����դ������ǤϤ���ޤ���");
        }

        // ���դ������������å�
        elseif (!checkdate((int)$pay_day_m, (int)$pay_day_d, (int)$pay_day_y)){
            $form->setElementError("form_pay_day", "������ �����դ������ǤϤ���ޤ���");
        }

        // ����ޤǤ����դΥ��顼���ʤ����
        if ($form->getElementError("form_pay_day") == null){

            // �����ƥ೫�����ʹߥ����å��ؿ��¹�
            $sysup_chk = Sys_Start_Date_Chk($pay_day_y, $pay_day_m, $pay_day_d, "������");

            // ������ID���������ʬ��������
            if ($client_id != null && $_POST["form_claim"] != null){

                // ���������ʹߥ����å��ؿ��¹�
                $close_chk = Check_Bill_Close_Day_Claim($db_con, $client_id, $_POST["form_claim"], $pay_day_y, $pay_day_m, $pay_day_d);

                // ����������껦���ʹߥ����å��ؿ��¹�
                $offset_chk = Check_Adv_Offset_Day($db_con, $client_id, $_POST["form_claim"], $pay_day_y, $pay_day_m, $pay_day_d);

            }

            // ̤�����ե����å�
            if ($pay_day > date("Y-m-d")){
                $form->setElementError("form_pay_day", "������ ��̤������դ����Ϥ���Ƥ��ޤ���");
            }

            // �����ƥ೫�����ʹߥ����å�
            elseif ($sysup_chk != null){
                $form->setElementError("form_pay_day", "$sysup_chk");
            }

            // ���������ʹߥ����å�
            elseif ($close_chk === false){
                $form->setElementError("form_pay_day", "������ ����������������������դ����Ϥ���Ƥ��ޤ���");
            }

            // ����������껦���ʹߥ����å�
            elseif ($offset_chk === false){
                $form->setElementError("form_pay_day", "������ ������������껦�����������դ����Ϥ���Ƥ��ޤ���");
            }

        }

    // ��������

        // ɬ�ܥ����å�
        if ($_POST["form_client"]["cd1"] == null && $_POST["form_client"]["cd2"] == null){
            $form->setElementError("form_client", "������ ��ɬ�ܤǤ���");
        }

        // ����ޤǤ˥��顼���ʤ����
        if ($form->getElementError("form_client") == null){

            // ������������������å�
            if ($client_id == null){
                $form->setElementError("form_client", "������ �������ǤϤ���ޤ���");
            }

            // �����踡����Ʊ���˳�ǧ���̤إܥ��󤬲������줿���Υ����å�
            elseif ($_POST["client_search_flg"] == "true" && $_POST["confirm_flg"] == "true"){
                $form->setElementError("form_client", "���������������� ��ǧ���̤إܥ��� ��������ޤ�����<br>������ľ���Ƥ���������");
                $client_search_confirm_flg = true;
            }

        }

    // ��������

        // ɬ�ܥ����å��������褬null�������踡����Ʊ���˳�ǧ���̤إܥ��󤬲�������Ƥ��ʤ�����
        if ($_POST["form_claim"] == null && $client_search_confirm_flg != true){
            $form->setElementError("form_claim", "������ ��ɬ�ܤǤ���");
        }

        // ������¸�ߥ����å�
        elseif ($_POST["form_claim"] != null && $client_id != null){
            if (Check_Claim_Alive($db_con, $client_id, $_POST["form_claim"]) === false){
                $form->setElementError("form_claim", "¸�ߤ��ʤ�������Ǥ���");
            }
        }

    // �����

        // ɬ�ܥ����å�
        if ($_POST["form_amount"] == null){
            $form->setElementError("form_amount", "��� ��ɬ�ܤǤ���");
        }

        // �����������å�
        elseif (!ereg("^[-]?[0-9]+$", $_POST["form_amount"])){
            $form->setElementError("form_amount", "��� �������ǤϤ���ޤ���");
        }

    // �����

        // Ⱦü���ϥ����å�
        if ($_POST["form_bank"][0] != null && $_POST["form_bank"][2] == null){
            $form->setElementError("form_bank", "���������ϸ��¤ޤǻ��ꤷ�Ƥ���������");
        }

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


/****************************/
// �ǽ����顼�����å�
/****************************/
// OK�ܥ��󲡲��ܥ��顼�Τʤ����
if ($_POST["ok_button"] != null && $err_flg != true){

    // ��ɼ�ѹ���
    if ($advance_id != null){

        // ����ɼ�������������å��ʺ�������å���
        if (Update_Check($db_con, "t_advance", "advance_id", $advance_id, $enter_day) === false){
            header("Location: ./2-2-413.php?err=1");
            exit;
        }

        // ���������������å�
        elseif (Fixed_Check($db_con, "t_advance", "advance_id", $advance_id) === false){
            header("Location: ./2-2-413.php?err=2");
            exit;
        }

    }

}


/****************************/
// DB��Ͽ
/****************************/
// OK�ܥ��󲡲��ܥ��顼�Τʤ����
if ($_POST["ok_button"] != null && $err_flg != true){

    // POST���ѿ��˥��å�
    $post_advance_no    = $_POST["form_advance_no"];
    $post_pay_day       = $_POST["form_pay_day"]["y"]."-".$_POST["form_pay_day"]["m"]."-".$_POST["form_pay_day"]["d"];
    $post_client_id     = $_POST["hdn_client_id"];
    $post_claim_div     = $_POST["form_claim"];
    $post_amount        = $_POST["form_amount"];
    $post_bank_id       = $_POST["form_bank"][0];
    $post_b_bank_id     = $_POST["form_bank"][1];
    $post_account_id    = $_POST["form_bank"][2];
    $post_staff_id      = $_POST["form_staff"];
    $post_note          = $_POST["form_note"];

    // �ȥ�󥶥�����󳫻�
    Db_Query($db_con, "BEGIN;");

    // ������Ͽ��
    if ($advance_id == null){

        $sql  = "INSERT INTO \n";
        $sql .= "   t_advance \n";
        $sql .= "( \n";
        $sql .= "   advance_id, \n";            // ������ID
        $sql .= "   advance_no, \n";            // ��ɼ�ֹ�
        $sql .= "   pay_day, \n";               // ������
        $sql .= "   client_id, \n";             // ������ID
        $sql .= "   client_cd1, \n";            // �����襳���ɣ�
        $sql .= "   client_cd2, \n";            // �����襳���ɣ�
        $sql .= "   client_name1, \n";          // ������̾��
        $sql .= "   client_name2, \n";          // ������̾��
        $sql .= "   client_cname, \n";          // ������̾ά��
        $sql .= "   claim_div, \n";             // �������ʬ
        $sql .= "   claim_id, \n";              // ������ID
        $sql .= "   claim_cd1, \n";             // �����襳���ɣ�
        $sql .= "   claim_cd2, \n";             // �����襳���ɣ�
        $sql .= "   claim_cname, \n";           // ������̾ά��
        $sql .= "   amount, \n";                // ���
        $sql .= "   bank_id, \n";               // ���ID
        $sql .= "   bank_cd, \n";               // ��ԥ�����
        $sql .= "   bank_name, \n";             // ���̾
        $sql .= "   b_bank_id, \n";             // ��ŹID
        $sql .= "   b_bank_cd, \n";             // ��Ź������
        $sql .= "   b_bank_name, \n";           // ��Ź̾
        $sql .= "   account_id, \n";            // ����ID
        $sql .= "   deposit_kind, \n";          // �¶����
        $sql .= "   account_no, \n";            // �����ֹ�
        $sql .= "   staff_id, \n";              // ô����ID
        $sql .= "   staff_name, \n";            // ô����̾
        $sql .= "   note, \n";                  // ����
        $sql .= "   input_day, \n";             // ������
        $sql .= "   input_staff_id, \n";        // ���ϼ�ID
        $sql .= "   input_staff_name, \n";      // ���ϼ�̾
        $sql .= "   fix_day, \n";               // �����������
        $sql .= "   fix_staff_id, \n";          // ����������ID
        $sql .= "   fix_staff_name, \n";        // ����������̾
        $sql .= "   shop_id \n";                // ����å�ID
        $sql .= ") \n";
        $sql .= "VALUES \n";
        $sql .= "( \n";
        $sql .= "   (SELECT COALESCE(MAX(advance_id), 0) + 1 FROM t_advance), \n";
        $sql .= "   '$post_advance_no', \n";
        $sql .= "   '$post_pay_day', \n";
        $sql .= "   $post_client_id, \n";
        $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_name  FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   '$post_claim_div', \n";
        $ary_col = array("id", "cd1", "cd2", "cname \n");
        foreach ($ary_col as $value){
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_client.client_$value \n";
        $sql .= "       FROM \n";
        $sql .= "           t_claim \n";
        $sql .= "       INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
        $sql .= "                           AND t_claim.client_id = $post_client_id \n";
        $sql .= "                           AND t_claim.claim_div = '$post_claim_div' \n";
        $sql .= "                           AND t_client.shop_id IN ".Rank_Sql2()." \n";
        $sql .= "   ), \n";
        }
        $sql .= "   $post_amount, \n";
        if ($post_bank_id != null){
        $sql .= "   $post_bank_id, \n";
        $sql .= "   (SELECT bank_cd      FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   (SELECT bank_name    FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   $post_b_bank_id, \n";
        $sql .= "   (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   $post_account_id, \n";
        $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = $post_account_id), \n";
        $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = $post_account_id), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        if ($post_staff_id != null){
        $sql .= "   $post_staff_id, \n";
        $sql .= "   (SELECT staff_name   FROM t_staff   WHERE staff_id   = $post_staff_id), \n";
        }else{
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        }
        $sql .= "   '$post_note', \n";
        $sql .= "   NOW(), \n";
        $sql .= "   $staff_id, \n";
        $sql .= "   '".addslashes($staff_name)."', \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   NULL, \n";
        $sql .= "   $shop_id \n";
        $sql .= ") \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        // ���顼��
        if ($res === false){
            $err_msg = pg_last_error();         // ���顼��å���������
            Db_Query($db_con, "ROLLBACK;");     // ����Хå�
            // ���顼��å������˽�ʣ���ޤޤ�Ƥ�����
            if (strstr($err_msg, "t_advance_advance_no_key") == true){
                $duplicate_flg = true;
            }else{
                exit;
            }
        }

    // ��ɼ�ѹ���
    }else{

        $sql  = "UPDATE \n";
        $sql .= "   t_advance \n";
        $sql .= "SET \n";
        $sql .= "   pay_day         = '$post_pay_day', \n";
        $sql .= "   client_id       = $post_client_id, \n";
        $sql .= "   client_cd1      = (SELECT client_cd1   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_cd2      = (SELECT client_cd2   FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_name1    = (SELECT client_name  FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_name2    = (SELECT client_name2 FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   client_cname    = (SELECT client_cname FROM t_client WHERE client_id = $post_client_id), \n";
        $sql .= "   claim_div       = '$post_claim_div', \n";
        $ary_col = array("id", "cd1", "cd2", "cname \n");
        foreach ($ary_col as $value){
        $sql .= "   claim_$value    = \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_client.client_$value \n";
        $sql .= "       FROM \n";
        $sql .= "           t_claim \n";
        $sql .= "       INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
        $sql .= "                           AND t_claim.client_id = $post_client_id \n";
        $sql .= "                           AND t_claim.claim_div = '$post_claim_div' \n";
        $sql .= "                           AND t_client.shop_id IN ".Rank_Sql2()." \n";
        $sql .= "   ), \n";
        }
        $sql .= "   amount          = $post_amount, \n";
        if ($post_bank_id != null){
        $sql .= "   bank_id         = $post_bank_id, \n";
        $sql .= "   bank_cd         = (SELECT bank_cd      FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   bank_name       = (SELECT bank_name    FROM t_bank    WHERE bank_id    = $post_bank_id), \n";
        $sql .= "   b_bank_id       = $post_b_bank_id, \n";
        $sql .= "   b_bank_cd       = (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   b_bank_name     = (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = $post_b_bank_id), \n";
        $sql .= "   account_id      = $post_account_id, \n";
        $sql .= "   deposit_kind    = (SELECT deposit_kind FROM t_account WHERE account_id = $post_account_id), \n";
        $sql .= "   account_no      = (SELECT account_no   FROM t_account WHERE account_id = $post_account_id), \n";
        }else{
        $sql .= "   bank_id         = NULL, \n";
        $sql .= "   bank_cd         = NULL, \n";
        $sql .= "   bank_name       = NULL, \n";
        $sql .= "   b_bank_id       = NULL, \n";
        $sql .= "   b_bank_cd       = NULL, \n";
        $sql .= "   b_bank_name     = NULL, \n";
        $sql .= "   account_id      = NULL, \n";
        $sql .= "   deposit_kind    = NULL, \n";
        $sql .= "   account_no      = NULL, \n";
        }
        if ($post_staff_id != null){
        $sql .= "   staff_id        = $post_staff_id, \n";
        $sql .= "   staff_name      = (SELECT staff_name   FROM t_staff   WHERE staff_id   = $post_staff_id), \n";
        }else{
        $sql .= "   staff_id        = NULL, \n";
        $sql .= "   staff_name      = NULL, \n";
        }
        if ($post_note != null){
        $sql .= "   note            = '$post_note', \n";
        }else{
        $sql .= "   note            = NULL, \n";
        }
        $sql .= "   input_day       = NOW(), \n";
        $sql .= "   input_staff_id  = $staff_id, \n";
        $sql .= "   input_staff_name= '".addslashes($staff_name)."', \n";
        $sql .= "   fix_day         = NULL, \n";
        $sql .= "   fix_staff_id    = NULL, \n";
        $sql .= "   fix_staff_name  = NULL, \n";
        $sql .= "   shop_id         = $shop_id \n";
        $sql .= "WHERE \n";
        $sql .= "   advance_id = $advance_id \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);

        if ($res === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

    }

    // ��ɼ�ֹ��ʣ���顼�Τʤ����
    if ($duplicate_flg != true){

        // �ȥ�󥶥�����󴰷�
        Db_Query($db_con, "COMMIT;");

        // ��λ���̤إڡ�������
        if ($advance_id == null){
            header("Location: ./2-2-413.php?ps=1");
        }else{
            header("Location: ./2-2-413.php?ps=2");
        }

    }

}


/****************************/
// �ǿ���ɼ�ֹ����
/****************************/
// ���ɽ������GET��ID���ʤ������̾����
// ��ɼ�ֹ��ʣ��
if (($_POST["post_flg"] != "true" && $advance_id == null) || $duplicate_flg == true){

    // �ǿ��λ�ʧ�ֹ����������û�
    $sql  = "SELECT \n";
    $sql .= "   MAX(advance_no) AS max \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $advance_data   = pg_fetch_array($res);
    $advance_no_max = $advance_data["max"];
    $advance_no_new = ($advance_no_max != "") ? $advance_no_max + 1 : 1;
    $advance_no_new = str_pad($advance_no_new, 8, "0", STR_PAD_LEFT);

    // �ե�����˥��å�
    $form_set["form_advance_no"] = $advance_no_new;
    $form->setConstants($form_set);

}


/****************************/
// ���ϥ�å���������
/****************************/
// ��ǧ�ܥ��󲡲��ܥ��顼�Τʤ����
if ($_POST["confirm_flg"] == "true" && $err_flg != true && $duplicate_flg != true){

    // �ե꡼���ե饰��true��
    $freeze_flg = true;

    // ��ǧ��å���������
    if ($advance_id == null){
        $form->addElement("static", "confirm_msg", "", "<span style=\"font: bold 16px;\">�ʲ������Ƥ���Ͽ���ޤ�����</span><br><br>");
    }else{
        $form->addElement("static", "confirm_msg", "", "<span style=\"font: bold 16px;\">�ʲ������Ƥ��ѹ����ޤ�����</span><br><br>");
    }

}elseif ($duplicate_flg == true){

    // ��ʣ��å���������
    $form->addElement("text", "err_duplicate");
    $form->setElementError("err_duplicate", "Ʊ���������Ԥä����ᡢ��ɼ�ֹ�����֤˼��Ԥ��ޤ�����<br>�⤦���������ԤäƤ���������");

}


/****************************/
// ưŪ�ե�������� ���ܥ���
/****************************/
// ���ܥ���
// �������ɼ�ξ��
if ($fix_flg == true){
    $form->addElement("button", "back_button", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}else
// �ѹ����ܳ�ǧ���̤Ǥʤ����
if ($advance_id != null && $_POST["confirm_flg"] != "true"){
    $form->addElement("button", "back_button", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}
// �ѹ����ܥ��顼�ξ��
if ($advance_id != null && $_POST["confirm_flg"] == "true" && ($err_flg == true || $duplicate_flg == true)){
    $form->addElement("button", "back_button", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("advance")."'\"");
}else
// ��ǧ���̤إܥ��󲡲��ܥ��顼�Τʤ����
if ($_POST["confirm_flg"] == "true" && $err_flg != true && $duplicate_flg != true){
    $form->addElement("button", "back_button", "�ᡡ��", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false');\"");
}


/****************************/
// �ե꡼�����ꡦ���ϥǡ�������
/****************************/
// ���������ե饰��true���ե꡼���ե饰�ʳ�ǧ�ˤ�true�ξ��
if ($fix_flg == true || $freeze_flg == true){

    // �ե꡼��
    $form->freeze();

    // ��ǧ���̻�
    if ($freeze_flg == true){

        // ���ͥե�������ͤ�ʥ�С��ե����ޥå�
        $num_format["form_amount"] = number_format($_POST["form_amount"]);
        $form->setConstants($num_format);

    }

}


/****************************/
// �ؿ�
/****************************/
// ����������Ԥ��Ƥ��ʤ��������å�
function Fixed_Check($db_con, $table, $column, $p_id){ 

    $sql  = "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM \n";
    $sql .= "   $table \n";
    $sql .= "WHERE \n";
    $sql .= "   $column = $p_id \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NULL \n";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0, 0);

    //�����쥳���ɤ�������
    if($row_num > 0){
        return true;
    //�����쥳���ɤ��ʤ����
    }else{  
        return false;
    }

}


/****************************/
// ������ID�ξ��ּ���
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


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
//$page_menu = Create_Menu_f("sale", "4");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ���顼��assign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// ����¾���ѿ���assign
$smarty->assign("var", array(
    // ����
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    // �ե饰
    "fix_flg"       => "$fix_flg",
    "freeze_flg"    => "$freeze_flg",
    // ����¾
    "client_state_print"    => "$client_state_print",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
