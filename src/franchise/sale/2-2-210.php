<?php
/*
 * ����
 *   ����        BɼNo.        ô����      ����
 *  -----------------------------------------------------------
 *  2015/05/01                  amano  Dialogue,Button_Submit�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 * * */
$page_title = "�����ɼ��������";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//�����Υѥ�����
$path_sale_slip     = IMAGE_DIR."sale_slip.png";    //�������ɼ
$path_claim_slip    = IMAGE_DIR."claim_slip.png";   //�����
$path_deli_slip     = IMAGE_DIR."deli_slip.png";    //Ǽ�ʽ�
$path_receive_slip  = IMAGE_DIR."receive_slip.png"; //�μ���

/****************************/
// �ǥե������
/****************************/
$def_data["preview_radio"]          = "1";
$def_data["bill_send_radio"]        = "1";
$def_data["font_size_select_0"]     = "10";
$def_data["font_size_select_1"]     = "10";
$def_data["font_size_select_2"]     = "8";
$def_data["font_size_select_3"]     = "10";
$def_data["font_size_select_4"]     = "6";
$form->setDefaults($def_data);

// �饸���ܥ��������
if ($_POST["bill_send_radio"] != null){
    $radio_post["commit_freeze"]["bill_send_radio"] = $_POST["bill_send_radio"];
    $form->setConstants($radio_post);
}
/****************************/
// �����ѿ�����
/****************************/
$client_id  = $_SESSION["client_id"];

/****************************/
// �������
/****************************/
// ������1
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo1", "", "size=\"25\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// ������2
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo2", "", "size=\"40\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// ������3
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo3", "", "size=\"25\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// ������4
$freeze = $commit_freeze[] = $form->addElement("text", "s_memo4", "", "size=\"40\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");
$freeze->freeze();

// ������5
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo5", "", "rows=\"5\" cols=\"78\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// ������6
$commit_freeze[] = $form->addElement("textarea", "s_memo6", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// ������7
$commit_freeze[] = $form->addElement("textarea", "s_memo7", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// ������8
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo8", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// ������9
$freeze = $commit_freeze[] = $form->addElement("textarea", "s_memo9", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");
$freeze->freeze();

// �ѥ����󥻥쥯�ȥܥå���
$select_value = Select_Get($db_con, "pattern");
$form->addElement("select", "pattern_select", "", $select_value, "size=\"10\" style=\"width: 350;\"");

// �ѥ�����̾
$freeze = $commit_freeze[] = $form->addElement("text", "pattern_name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
$freeze->freeze();

// �ѥ������ֹ�
$freeze = $commit_freeze[] = $form->addElement("text", "pattern_no", "", "size=\"2\" maxLength=\"2\" $g_form_option");
$freeze->freeze();

// �����饸���ܥ���
$radio = null;
$radio[] = $form->createElement("radio", null, null, "�Ϥ�", "1");
$radio[] = $form->createElement("radio", null, null, "�Ϥ��ʤ�", "2");
$freeze = $commit_freeze[] = $form->addGroup($radio, "bill_send_radio", "");
$freeze->freeze();

//�ץ�ӥ塼���̥饸���ܥ���
$radio = null;
$radio[] = $form->createElement("radio",null,null,"�����","1");
$radio[] = $form->createElement("radio",null,null,"�μ���","2");
$form->addGroup($radio,"preview_radio","");

// ��ɼ���ϥܥ���
$form->addElement("submit", "preview_button", "�ץ�ӥ塼", "onClick=\"javascript:PDF_POST('".FC_DIR."system/2-1-309.php')\"");

// ��Ͽ�ܥ���
$form->addElement("submit", "new_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled ");

// �ѹ��ܥ���
if($_POST[change_button] == "�ѡ���"){
    $form->addElement("submit", "change_button", "�ѡ���", "onClick=\"javascript:Button_Submit('form_update_flg','#','true', this)\" $disabled $g_button_color");
}else{
    $form->addElement("submit", "change_button", "�ѡ���", "onClick=\"javascript:Button_Submit('form_update_flg','#','true', this)\" $disabled ");
}

// ���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// OK�ܥ���
$form->addElement("button", "ok_button", "�ϡ���", "onClick=javascript:location.href='$_SERVER[PHP_SELF]' $disabled");

// hidden
$form->addElement("hidden", "form_new_flg");       // ������Ͽ�ܥ���ե饰
$form->addElement("hidden", "form_update_flg");    // �ѹ��ܥ���ե饰
$form->addElement("hidden", "h_pattern_id");       // �ѥ�����

// �ե���ȥ�����
for($i=0; $i<5; $i++){
    $data["5"]  = "5";
    $data["6"]  = "6";
    $data["7"]  = "7";
    $data["8"]  = "8";
    $data["9"]  = "9";
    $data["10"] = "10";
    $data["11"] = "11";
    $data["12"] = "12";
    $data["13"] = "13";
    $data["14"] = "14";
    $data["15"] = "15";
    $form->addElement("select", "font_size_select_".$i, "", $data);
}

// �ѹ��ܥ��󤬲����줿���
if($_POST["change_button"] == "�ѡ���"){

    if($_POST[pattern_select]!=null){
        $sql  = "SELECT ";
        $sql .= "    s_pattern_name,";  // �ѥ�����̾
        $sql .= "    bill_send_flg,";   // �����
        $sql .= "    s_memo1, ";        // �����ɼ������1
        $sql .= "    s_memo2, ";        // �����ɼ������2
        $sql .= "    s_memo3, ";        // �����ɼ������3
        $sql .= "    s_memo4, ";        // �����ɼ������4
        $sql .= "    s_memo5, ";        // �����ɼ������5
        $sql .= "    s_fsize1,";        // ������1�ե���ȥ�����
        $sql .= "    s_fsize2,";        // ������2�ե���ȥ�����
        $sql .= "    s_fsize3,";        // ������3�ե���ȥ�����
        $sql .= "    s_fsize4,";        // ������4�ե���ȥ�����
        $sql .= "    s_fsize5,";        // ������5�ե���ȥ�����
        $sql .= "    s_memo6, ";        // �����ɼ������6
        $sql .= "    s_memo7, ";        // �����ɼ������7
        $sql .= "    s_memo8, ";        // �����ɼ������8
        $sql .= "    s_memo9, ";        // �����ɼ������9
        $sql .= "    s_pattern_no ";    // �ѥ������ֹ�
        $sql .= "FROM ";
        $sql .= "    t_slip_sheet ";
        $sql .= "WHERE ";
        $sql .= "    shop_id = $client_id ";
        $sql .= "AND ";
        $sql .= "    s_pattern_id = $_POST[pattern_select];";

        $result = Db_Query($db_con,$sql);
        // DB���ͤ��������¸
        $s_memo = Get_Data($result,2);

        // �ǡ�����ե�����˥��åȤ���
        $update_button_data["pattern_name"]        = $s_memo[0][0];
        $update_button_data["pattern_no"]          = $s_memo[0][16];
        $update_button_data["bill_send_radio"]     = ($s_memo[0][1] == "t") ? "1" : "2";
        $update_button_data["s_memo1"]             = $s_memo[0][2];
        $update_button_data["s_memo2"]             = $s_memo[0][3];
        $update_button_data["s_memo3"]             = $s_memo[0][4];
        $update_button_data["s_memo4"]             = $s_memo[0][5];
        $update_button_data["s_memo5"]             = $s_memo[0][6];
        $update_button_data["font_size_select_0"]  = $s_memo[0][7];
        $update_button_data["font_size_select_1"]  = $s_memo[0][8];
        $update_button_data["font_size_select_2"]  = $s_memo[0][9];
        $update_button_data["font_size_select_3"]  = $s_memo[0][10];
        $update_button_data["font_size_select_4"]  = $s_memo[0][11];
        $update_button_data["s_memo6"]             = $s_memo[0][12];
        $update_button_data["s_memo7"]             = $s_memo[0][13];
        $update_button_data["s_memo8"]             = $s_memo[0][14];
        $update_button_data["s_memo9"]             = $s_memo[0][15];
        $update_button_data["form_new_flg"]        = false;
        $update_button_data["h_pattern_id"]        = $_POST["pattern_select"];    // ���򤵤줿�ѥ������hidden�˥��åȤ���
    }else{
        $pattern_err = "�ѹ�����ѥ���������򤷤Ƥ���������";
    }
}
$form->setConstants($update_button_data);

/****************************/
// ��Ͽ�ܥ��󲡲�����
/****************************/
if (isset($_POST["new_button"])){

    /****************************/
    // ���顼�����å�
    /****************************/
    // ������5
    // ��ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // ������6
    // ��ʸ���������å�
    $form->addRule("s_memo6", "�������ɼ�����ͤ�290ʸ������Ǥ���", "mb_maxlength", "290");

    // ������7
    // ��ʸ���������å�
    $form->addRule("s_memo7", "�������Ԥ�290ʸ������Ǥ���", "mb_maxlength", "290");

    $qf_err_flg = ($form->validate() == false) ? true : false;
}

if($_POST["new_button"] == "�С�Ͽ" && $qf_err_flg === false){
    $s_pattern_name = $_POST["pattern_name"];        // �ѥ�����̾
    $bill_send_flg  = ($_POST["bill_send_radio"] == "1") ? "t" : "f";     // �����
    $s_memo6        = $_POST["s_memo6"];             // ������6
    $s_memo7        = $_POST["s_memo7"];             // ������7
    $pattern_id     = $_POST["h_pattern_id"];

    Db_Query($db_con, "BEGIN;");

    $sql  = "UPDATE ";
    $sql .= "    t_slip_sheet ";
    $sql .= "SET ";
    $sql .= "    s_memo6 = '$s_memo6', ";
    $sql .= "    s_memo7 = '$s_memo7', ";
    $sql .= "    s_memo8 = '$s_memo6', ";
    $sql .= "    s_memo9 = '$s_memo6' ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $client_id ";
    $sql .= "AND ";
    $sql .= "    s_pattern_id = $pattern_id;";

    $result = Db_Query($db_con, $sql);
    if($result == false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    $commit_flg = true;
    Db_Query($db_con, "COMMIT;");
}

if ($commit_flg == true){
    $commit_freeze_form = $form->addGroup($commit_freeze, "commit_freeze", "");
    $commit_freeze_form->freeze();
}

/****************************/
// HTML�إå�
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title, "amenity.js", "global.css", "slip.css");

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
$page_menu = Create_Menu_f("system", "2");

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "pattern_err"   => "$pattern_err",
    "qf_err_flg"    => "$qf_err_flg",
    "commit_flg"    => "$commit_flg",
    "path_sale_slip"    => "$path_sale_slip",
    "path_claim_slip"   => "$path_claim_slip",
    "path_deli_slip"    => "$path_deli_slip",
    "path_receive_slip" => "$path_receive_slip",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
