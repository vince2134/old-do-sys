<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/24��04-007��������watanabe-k���������ṹ����Ԥʤ��ȡ�Ʊ���ǡ�����2��ɽ������롣
 *                                         ������������ṹ����Ԥʤ��ȡ�Ʊ���ǡ�����3��ɽ�������Х��ν���
 *
 * ��2006/10/25��04-025��������morita-d����ɽ���ܥ����button����submit���ѹ�
 *                                         (ɽ�������Ⱥ��������Ʊ���˼¹Ԥ�����ǽ�������뤿���
 * ��2006/12/14��      ��������suzuki��    �ڡ�����������
 * ��2007/01/27��      ��������morita-d�������ṹ���ε�ǽ���ɲ�
 * ��2007/01/27��      ��������morita-d�����ʲ��ε�ǽ���ɲ�
 *                                         �������ȯ�Բ��̤Ρֺ���פȤ���ɽ���ϡּ�áפ��ѹ����롣
 *                                         �ּ�áפ����򤷤����ˤϡ��������������������롣
 *   2007/03/08                watanabe-k  ������������������ä�Ǥ��ʤ��褦���ѹ�
 *   2007/03/14                watanabe-k  ������ȯ�Խ��������
 *   2007/03/27                watanabe-k  ������������ 
 *   2007/03/27                watanabe-k  �ܻ�Ź�Ǥθ�����ǽ�ɲ� 
 *   2007/03/30                watanabe-k  �������ٽ���� 
 *   2007/04/16                watanabe-k  ���ṹ���ѤߤΤ�Τ�������ä��ϤǤ��ʤ��褦�ˤ��롣 
 *   2007/04/16                watanabe-k  ���ṹ���굡ǽ�Ϻ�� 
 *   2007/05/07                watanabe-k  ���������������ǽ 
 */

$page_title = "�����ȯ�ԾȲ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�����Ϣ�ǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR."seikyu.inc");

require_once(INCLUDE_DIR."common_quickform.inc");

//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DB��³
$db_con = Db_Connect();

//�������ϻ���
$s_time = microtime();

/****************************/
//���¥����å�
/****************************/
$auth       = Auth_Check($db_con);

// ���ϡ��ѹ�����̵����å�����
if ($auth[0] == "r") {
    $disabled = "disabled";
} 


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
    "form_round_staff"      => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_claim"            => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_amount_this"      => array("s" => "", "e" => ""),
    "form_close_day"        => array("y" => date("Y"), "m" => date("m"), "d" => "0",),
    "form_collect_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_issue"            => "1",
    "form_claim_send"       => "1",
    "form_last_update"      => "1",
    "form_bill_no"          => array("s" => "", "e" => ""),
);

$ary_pass_list = array(
    "form_output_type"      => "1",
);

// �����������
Restore_Filter2($form, "claim", "hyouji_button", $ary_form_list);


/****************************/
// �ѿ�̾���֤������ʰʸ�$_POST�ϻ��Ѥ��ʤ���
/****************************/
// �桼������
//if ($_POST["renew_flg"] == "1" || $_GET["search"] != null){ 
if ($_POST["renew_flg"] == "1"){ 

    $display_num        = $_POST["form_display_num"];
    $output_type        = $_POST["form_output_type"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $amount_this_s      = $_POST["form_amount_this"]["s"];
    $amount_this_e      = $_POST["form_amount_this"]["e"];
    $close_day_y        = $_POST["form_close_day"]["y"];
    $close_day_m        = $_POST["form_close_day"]["m"];
    $close_day_d        = $_POST["form_close_day"]["d"];
    $collect_day_sy     = $_POST["form_collect_day"]["sy"];
    $collect_day_sm     = $_POST["form_collect_day"]["sm"];
    $collect_day_sd     = $_POST["form_collect_day"]["sd"];
    $collect_day_ey     = $_POST["form_collect_day"]["ey"];
    $collect_day_em     = $_POST["form_collect_day"]["em"];
    $collect_day_ed     = $_POST["form_collect_day"]["ed"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $issue              = $_POST["form_issue"];
    $claim_send         = $_POST["form_cliam_send"];
    $last_update        = $_POST["form_last_update"];
    $bill_no_s          = $_POST["form_bill_no"]["s"];
    $bill_no_e          = $_POST["form_bill_no"]["e"];

    $where              = $_POST;
    $claim_fix          = $_POST["claim_fix"];
    $claim_renew        = $_POST["claim_renew"];
    $claim_cancel       = $_POST["claim_cancel"];
    $branch_id          = $_POST["form_branch_id"];
 
    //����¾
    $f_page1            = $_POST["f_page1"];
    $hyouji_button      = $_POST["hyouji_button"];
    $fix_button         = $_POST["fix_button"];
    $renew_button       = $_POST["renew_button"];
    $cancel_button      = $_POST["cancel_button"];
    $bill_id            = $_POST["bill_id"];
    $link_action        = $_POST["link_action"];
    $renew_flg          = $_POST["renew_flg"];

    $post_flg           = true;

// ���ɽ��
}else{

    $f_page1            = ($_POST["f_page1"] != Null) ? $_POST["f_page1"] : 1;
    $display_num        = "1";

}


/****************************/
// �ե������������Ū��
/****************************/
/* ���̥ե����� */
Search_Form_Claim($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// �����ȯ��
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤ȯ��", "2");
$obj[]  =&  $form->createElement("radio", null, null, "ȯ�Ժ�", "3");
$form->addGroup($obj, "form_issue", "", " ");

// ���������
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",         "1");
$obj[]  =&  $form->createElement("radio", null, null, "͹��",         "2");
$obj[]  =&  $form->createElement("radio", null, null, "�᡼��",       "3");
$obj[]  =&  $form->createElement("radio", null, null, "WEB",          "5");
$obj[]  =&  $form->createElement("radio", null, null, "͹�����᡼��", "4");
$form->addGroup($obj, "form_claim_send", "", " ");

// ���ṹ��
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "̤�»�", "2");
$obj[]  =&  $form->createElement("radio", null, null, "�»ܺ�", "3");
$form->addGroup($obj, "form_last_update", "", " ");

// �����ֹ�
Addelement_Slip_Range($form, "form_bill_no", "�����ֹ�");

// �������ALL
$form->addElement("checkbox", "claim_fix_all",      "", "�������",   "onClick=\"javascript:All_Check_Claim_Fix('claim_fix_all');\"");

// �����ȯ��ALL
$form->addElement("checkbox", "claim_issue_all",    "", "�����ȯ��", "onClick=\"javascript:All_Check_Claim_Issue('claim_issue_all');\"");

// ������ȯ��ALL
$form->addElement("checkbox", "re_claim_issue_all", "", "��ȯ��",     "onClick=\"javascript:All_Re_Check_Claim_Issue('re_claim_issue_all');\"");

// ���ṹ��ALL
$form->addElement("checkbox", "claim_renew_all",    "", "���ṹ��",   "onClick=\"javascript:All_Check_Claim_Renew('claim_renew_all');\"");

// ������ALL
$form->addElement("checkbox", "claim_cancel_all",   "", "������",   "onClick=\"javascript:All_Check_Claim_Cancel('claim_cancel_all');\"");

// ɽ���ܥ���
$form->addElement("submit", "hyouji_button", "ɽ����", "onClick=\"return(Submit_If_Url('2-2-303.php', 'form_output_type'));\"");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// �������ܥ���
$form->addElement("submit", "fix_button", "�������", "
    onClick=\"javascript:return(Dialogue4('������ꤷ�ޤ���'));\" $disabled
");

// ���ṹ���ܥ���
$form->addElement("submit", "renew_button", "���ṹ��", "
    onClick=\"javascript:return(Dialogue4('���ṹ�����ޤ���'));\" $disabled
");

// �����åܥ���
$form->addElement("submit", "cancel_button", "������", "
    onClick=\"javascript:return(Dialogue4('�����ä��ȡ�������������塦������ɼ���������������Ԥʤ��ޤ���'));\" $disabled
");

// �����ȯ�ԥܥ���
$form->addElement("button", "pre_hakkou_button", "����ȯ����", "$g_button_color
     onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '��ȯ��';
    Submit_Blank_Window('2-2-307.php','������ȯ�Ԥ��ޤ���');\" $disabled"
);

// �����ȯ�ԥܥ���
$form->addElement("button", "hakkou_button", "�����ȯ��", "
    onClick=\"javascript:document.dateForm.elements['hdn_button'].value = ''; 
    Submit_Blank_Window('2-2-307.php','������ȯ�Ԥ��ޤ���');\" $disabled
");

// ��ȯ�ԥܥ���
$form->addElement("button", "re_hakkou_button", "��ȯ��", "
    onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '��ȯ��'; 
    Submit_Blank_Window('2-2-307.php','������ȯ�Ԥ��ޤ���');\" $disabled
");

// �����ȥ��
$ary_sort_item = array(
    "sl_slip"           => "�����ֹ�",
    "sl_close_day"      => "��������",
    "sl_claim_cd"       => "�����襳����",
    "sl_claim_name"     => "������̾",
    "sl_collect_day"    => "���ͽ����",
    "sl_staff"          => "ô����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_close_day");

// hidden
$form->addElement("hidden", "link_action");         // ��󥯥���å�����ư��
$form->addElement("hidden", "bill_id");             // �����ID
$form->addElement("hidden", "renew_flg", "1");      // ���̹����ե饰
$form->addElement("hidden", "hdn_button");          // ��ȯ�ԥܥ���


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

// �������ϥ����å��ܥå����Υ����å���Ϥ���
if ($renew_flg == "1") {
    $constants_data = array(
        "claim_fix_all"         => "0",
        "claim_issue_all"       => "0",
        "re_claim_issue_all"    => "0",
        "claim_renew_all"       => "0",
        "claim_cancel_all"      => "0",
    );
    $form->setConstants($constants_data);
}

// �������٤�����ä����������ȯ�ԤΥ����å��ܥå����Υ����å���Ϥ���
if ($_POST["hdn_back_btn"] == "post"){
    $clear_form["claim_issue"][0] = false;
    $form->setConstants($clear_form);
}


/****************************/
//���顼�����å�
/****************************/
if($_POST["hyouji_button"] == "ɽ����"){

    /****************************/
    // �饸���ܥ���������POST�����å�
    /****************************/
    $err_chk_radio = array(
        array($display_num,  "2"),      // ɽ�����
        array($output_type,  "2"),      // ���Ϸ���
        array($issue,        "3"),      // �����ȯ��
        array($claim_send,   "5"),      // ���������
        array($claim_update, "3"),      // ���ṹ��
    );

    foreach ($err_chk_radio as $key => $value){
        if (!("1" <= $value[0] || $value[0] <= $value[1])){
            print "�������ͤ����Ϥ���ޤ�����(".($key+1).")<br>";
            exit;
        }
    }

    // ����POST�ǡ�����0���
    $_POST["form_close_day"]    = Str_Pad_Date($_POST["form_close_day"]);
    $_POST["form_collect_day"]  = Str_Pad_Date($_POST["form_collect_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����ô����
    $err_msg = "���ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_round_staff", $err_msg);

    // �������
    $err_msg = "����� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_amount_this", $err_msg);

    // ����������
    $err_msg = "�������� �����դ������ǤϤ���ޤ���";
    // ʸ��������å�
    if (
        ($_POST["form_close_day"]["y"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["y"])) ||
        ($_POST["form_close_day"]["m"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["m"]))
    ){
        $form->setElementError("form_close_day", $err_msg);
    }else
    // �����������å�
    if ($_POST["form_close_day"]["m"] != null && ($_POST["form_close_day"]["m"] < 1 || $_POST["form_close_day"]["m"] > 12)){
        $form->setElementError("form_close_day", $err_msg);
    }

    // �����ͽ����
    $err_msg = "���ͽ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_collect_day", $err_msg);

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
// ����
/****************************/
// ���Ϸ����ֲ��̡פ�ɽ������
if ($hyouji_button == "ɽ����" && $output_type == "1") {

    // �����ʤ���¾�ν�����Ʊ���¹Ԥ��ɤ�����˵��ҡ�

}else
// ���Ϸ�����Ģɼ�פ�ɽ������
if ($hyouji_button == "ɽ����" && $output_type == "2") {

    // �����ʤ���¾�ν�����Ʊ���¹Ԥ��ɤ�����˵��ҡ�

}else
// ����������
if ($fix_button == "�������" && count($claim_fix) > 0) {

    Fix_Bill($db_con, $claim_fix);

}else
// ���ṹ������
if ($renew_button == "���ṹ��" && count($claim_renew) > 0) {

    Renew_Bill($db_con, $claim_renew);

}else
// �����ý���
if ($cancel_button == "������" && count($claim_cancel) > 0) {

    // ������û���������������褦�˽���
    // ����¾����δط��塢���ṹ����äȺ��������ʬ���Ƽ»ܤ����

    // ������
    $payin_data = Cancel_Bill($db_con, $claim_cancel);

    // ��������ε����äƤ���ǡ�����������
    if (count($payin_data) > 0){
        $i = 0;
        foreach ($payin_data AS $key => $val){
            // ���顼��å�����ɽ���ѥե�����
            $form->addElement("text", "payin_err[$i]");
            $form->setElementError("payin_err[$i]",
                "������ֹ桧".$val["bill_no"]." ���Ф��ƴ��� �����ֹ桧".$val["pay_no"]." �����⤬�����äƤ��뤿�����Ǥ��ޤ���"
            );
            $i++;
        }
    }else{
        // ������
        while ($cancel_id = each($claim_cancel)) {
            Delete_Bill($db_con, $cancel_id[1]);
        }
    }

}else
// �������
if ($link_action == "delete" && count($claim_cancel) > 0){

    $claim_cancel[] = $bill_id;

    // ������
    Cancel_Bill($db_con, $claim_cancel);

    // ������
    Delete_Bill($db_con, $bill_id);

}

// ����ɽ������
if ($post_flg == true && $err_flg != true){

    // �����������
    $total_count = Get_Claim_Data($db_con, $where, "", "", "count");

    switch ($display_num){
        case "1":
            $range = $total_count;
            break;
        case "2":
            $range = "100";
            break;
    }

    // ���ߤΥڡ�����������å�����
    $page_info = Check_Page($total_count, $range, $f_page1);
    $page      = $page_info[0];     // ���ߤΥڡ�����
    $page_snum = $page_info[1];     // ɽ�����Ϸ��
    $page_enum = $page_info[2];     // ɽ����λ���

    // �ڡ����ץ������ɽ��Ƚ��
    if($page == 1){
        // �ڡ����������ʤ�ڡ����ץ���������ɽ��
        $c_page = null;
    }else{
        // �ڡ�����ʬ�ץ�������ɽ��
        $c_page = $page;
    }
    
    // �ڡ�������
    $html_page  = Html_Page2($total_count, $c_page, 1, $range);
    $html_page2 = Html_Page2($total_count, $c_page, 2, $range);
    
    // �����ǡ�������
    $claim_data  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);

}


/****************************/
// �ǿ��η�����������(���ṹ���Υ����å��ܥå�����ɽ��Ƚ����)
/****************************/
$sql  = "SELECT \n";
$sql .= "   COALESCE(MAX(close_day), '".START_DAY."') \n";
$sql .= "FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "   renew_div = '2' \n";
$sql .= "AND \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$max_renew_day = pg_fetch_result($res, 0, 0);


/****************************/
// �ե���������ʸ�����̡�
/****************************/
$i = 0;
if (count($claim_data) > 0){
for ($j = $page_snum; $j <= $page_enum; $j++){

    $chk_bill_id = $claim_data[$i]["bill_id"];//����ID

    // �����Υե����ޥåȤ����Ϥ��ʤ�OR����ʳ��ξ��
    if($claim_data[$i]["bill_format"] != "3" && $claim_data[$i]["bill_format"] != "4"){

        //�������ե����ޥå�
        $format_arr = null;
        $format_arr[] =& $form->createElement("radio", null, null, "����", "1");
        $format_arr[] =& $form->createElement("radio", null, null, "���", "2");
        $format_arr[] =& $form->createElement("radio", null, null, "����", "5");
        $form->addGroup($format_arr, "format[$i]", "�����"," ");

        //���̤ξ����ͤ�3���֤�������(�����ν����˱ƶ����뤿��)
        $set_data["format[$i]"] = $claim_data[$i]["bill_format"];

        //�������ȯ��
        //�����Ƚ�̤Ϥʤ�
        if ($claim_data[$i][issue_day] == null) {
            // �����ȯ��
            $form->addElement("advcheckbox", "claim_issue[$i]", null, null, null, array("f", "$chk_bill_id"));
            $claim_issue_data[$i] = $chk_bill_id;
        //��������ȯ��
        }elseif($claim_data[$i][issue_day] != null){
            // �����ȯ��
            $form->addElement("static", "claim_issue[$i]", '', $claim_data[$i][issue_day] );
            $form->addElement("advcheckbox", "re_claim_issue[$i]", null, null, null, array("f", "$chk_bill_id"));
            $set_data["claim_issue"][$i] = $claim_data[$i][issue_day];
            $re_claim_issue_data[$i] = $chk_bill_id;
        }

    }

    //�����ṹ��
    //����Υ��ơ������ϴط��ʤ�
    if ($claim_data[$i]["last_update_flg"] == "f" && $auth[0] == "w") {
        // ������
        $form->addElement("advcheckbox", "claim_renew[$i]", null, null, null, array("f", "$chk_bill_id"));
        $claim_renew_data[$i] = $chk_bill_id;
    //�����Ѥξ��Ϲ�������ɽ������
    }else{
      $form->addElement("static", "claim_renew[$i]", null, $claim_data[$i]["last_update_day"], null, "");
    }

    //��������
    // �ֹ����ѡפ��ġֽ���߸��¤���פξ��
    //������ID��null����ʤ�����watanabe-k��
    if ($claim_data[$i]["last_update_flg"] == "t" && $auth[0] == "w" && $claim_data[$i]["cancel_bill_id"] != null) {
        $cancel_flg = true;
    }

    //�����
    // ��̤�����פ��ġֽ���߸��¤���פξ�硢�����󥯤�ɽ������
    if (($claim_data[$i]["last_update_flg"] == "f" && $auth[0] == "w")) {
        $delete_flg = true;
    }else{
        $delete_flg = false;
    }

    //�������ä���ǽ�פޤ��ϡ������������ǽ�פ������ä��ǽ�ˤ���
    //���������������Ͻ����塢����ե饰��false�ˤ���
    if ($max_renew_day < $claim_data[$i]["close_day"]){
        $disp_flg = "t";
    }

    if($disp_flg == "t" && $delete_flg === true){

        $form->addElement("advcheckbox", "claim_cancel[$i]", null, null, null, array("f", "$chk_bill_id"));
        $claim_cancel_data[$i] = $chk_bill_id;

    //�����ä��Բ�ǽ�ˤ���
    }else{
        //�����󥯤�ɽ�����ʤ�
        $claim_data[$i][delete] = "";   
    }
    
    $i++;

}
}

// �饸���ܥ���˥��å�
$form->setConstants($set_data);

// �������(ALL�����å�JS�����)
$javascript  = Create_Allcheck_Js ("All_Check_Claim_Fix",      "claim_fix",      $claim_fix_data);
// �����ȯ�ԡ�ALL�����å�JS�������
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Issue",    "claim_issue",    $claim_issue_data);
// ������ȯ�ԡ�ALL�����å�JS�������
$javascript .= Create_Allcheck_Js ("All_Re_Check_Claim_Issue", "re_claim_issue", $re_claim_issue_data);
// ������(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Cancel",   "claim_cancel",   $claim_cancel_data);
// ���ṹ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js ("All_Check_Claim_Renew",    "claim_renew",    $claim_renew_data);


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s .= Search_Table_Claim($form);
// �⥸�塼����̸����ơ��֥룱
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ȯ��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_issue"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">���������</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_claim_send"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �⥸�塼����̸����ơ��֥룲
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 90px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"350px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">���ṹ��</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_last_update"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����ֹ�</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_bill_no"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["hyouji_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["kuria_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
//$page_menu = Create_Menu_f('sale','3');

/****************************/
//���̥إå�������
/****************************/
//$page_header = Create_Header($page_title);
$page_header = Bill_Header($page_title);

/****************************/
//�ƥ�ץ졼�Ȥؤν���
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//���顼��assign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//�������
$smarty->assign('claim_data', $claim_data);

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'js'            => "$javascript", 
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));

$smarty->assign("html", array(
    "html_s"        => "$html_s",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
?>
