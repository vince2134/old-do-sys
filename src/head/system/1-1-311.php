<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "�����ɼ����";

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
$commit_freeze[] = $form->addElement("text", "s_memo1", "", "size=\"16\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");

// ������2
$commit_freeze[] = $form->addElement("text", "s_memo2", "", "size=\"50\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");

// ������3
$commit_freeze[] = $form->addElement("text", "s_memo3", "", "size=\"16\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");

// ������4
$commit_freeze[] = $form->addElement("text", "s_memo4", "", "size=\"50\" maxLength=\"46\" style=\"font-size:10px;\" $g_form_option");

// ������5
$commit_freeze[] = $form->addElement("textarea", "s_memo5", "", "rows=\"5\" cols=\"66\" style=\"font-size:10px;\" $g_form_option_area");

// ������6
$commit_freeze[] = $form->addElement("textarea", "s_memo6", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// ������7
$commit_freeze[] = $form->addElement("textarea", "s_memo7", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// ������8
$commit_freeze[] = $form->addElement("textarea", "s_memo8", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// ������9
$commit_freeze[] = $form->addElement("textarea", "s_memo9", "", "rows=\"8\" cols=\"70\" style=\"font-size:10px;\" $g_form_option_area");

// �ѥ����󥻥쥯�ȥܥå���
$select_value = Select_Get($db_con, "pattern");
$form->addElement("select", "pattern_select", "", $select_value, "size=\"5\" style=\"width: 350;\"");

// �ѥ�����̾
$commit_freeze[] = $form->addElement("text", "pattern_name", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// �����饸���ܥ���
$radio = null;
$radio[] = $form->createElement("radio", null, null, "�Ϥ�", "1");
$radio[] = $form->createElement("radio", null, null, "�Ϥ��ʤ�", "2");
$commit_freeze[] = $form->addGroup($radio, "bill_send_radio", "");

// ��ɼ���ϥܥ���
//$form->addElement("submit", "preview_button", "�ץ�ӥ塼", "onClick=\"javascript:PDF_POST('".FC_DIR."sale/2-2-214.php')\"");
$form->addElement("submit", "preview_button", "�ץ�ӥ塼", "onClick=\"javascript:PDF_POST('".HEAD_DIR."system/1-1-309.php')\"");

// ������Ͽ�ܥ���
$form->addElement("submit", "form_new_button", "������Ͽ", "onClick=\"javascript:Button_Submit('form_new_flg','#','true', this)\" $disabled");

// ��Ͽ�ܥ���
$form->addElement("submit", "new_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");

// �ѹ��ܥ���
$form->addElement("submit", "change_button", "�ѡ���", "onClick=\"javascript:Button_Submit('form_update_flg','#','true', this)\" $disabled");

// ���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// OK�ܥ���
$form->addElement("button", "ok_button", "�ϡ���", "onClick=javascript:location.href='1-1-311.php' $disabled");

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
        $sql .= "    s_memo9 ";         // �����ɼ������9
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
        $form->setConstants($update_button_data);
    }else{
        $pattern_err = "�ѹ�����ѥ���������򤷤Ƥ���������";
    }
}

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
    $form->addRule("s_memo5", "&#65533;���ꡦTEL��FAX��290ʸ������Ǥ���", "mb_maxlength", "290");

    // ������6
    // ��ʸ���������å�
    $form->addRule("s_memo6", "&#65533;�����ɼ�����ͤ�290ʸ������Ǥ���", "mb_maxlength", "290");

    // ������7
    // ��ʸ���������å�
    $form->addRule("s_memo7", "&#65533;�����Ԥ�290ʸ������Ǥ���", "mb_maxlength", "290");

    // ������8
    // ��ʸ���������å�
    $form->addRule("s_memo8", "&#65533;Ǽ�ʽ�����ͤ�290ʸ������Ǥ���", "mb_maxlength", "290");

    // ������9
    // ��ʸ���������å�
    $form->addRule("s_memo9", "&#65533;�μ�������ͤ�290ʸ������Ǥ���", "mb_maxlength", "290");

    // �ѥ�����̾
    // ��ɬ�ܥ����å�
    $form->addRule("pattern_name", "�ѥ�����̾��30ʸ������Ǥ���", "required");

    $qf_err_flg = ($form->validate() == false) ? true : false;

}

if($_POST["new_button"] == "�С�Ͽ" && $qf_err_flg === false){
    $s_pattern_name = $_POST["pattern_name"];        // �ѥ�����̾
    $bill_send_flg  = ($_POST["bill_send_radio"] == "1") ? "t" : "f";     // �����
    $s_memo1        = $_POST["s_memo1"];             // ������1
    $s_memo2        = $_POST["s_memo2"];             // ������2
    $s_memo3        = $_POST["s_memo3"];             // ������3
    $s_memo4        = $_POST["s_memo4"];             // ������4
    $s_memo5        = $_POST["s_memo5"];             // ������5
    $s_memo6        = $_POST["s_memo6"];             // ������6
    $s_memo7        = $_POST["s_memo7"];             // ������7
    $s_memo8        = $_POST["s_memo8"];             // ������8
    $s_memo9        = $_POST["s_memo9"];             // ������9
    $s_fsize1       = $_POST["font_size_select_0"];  // ������1ʸ��������
    $s_fsize2       = $_POST["font_size_select_1"];  // ������2ʸ��������
    $s_fsize3       = $_POST["font_size_select_2"];  // ������3ʸ��������
    $s_fsize4       = $_POST["font_size_select_3"];  // ������4ʸ��������
    $s_fsize5       = $_POST["font_size_select_4"];  // ������5ʸ��������
    $pattern_id     = $_POST["h_pattern_id"];        // �ѥ�����ID

    Db_Query($db_con, "BEGIN;");

    // ������Ͽ��
    if($_POST["form_new_flg"] ==true){
        $sql  = "INSERT INTO ";
        $sql .= "t_slip_sheet( ";
        $sql .=     "shop_id,";
        $sql .=     "s_pattern_id,";
        $sql .=     "s_pattern_name,";
        $sql .=     "bill_send_flg,";
        $sql .=     "s_memo1,";
        $sql .=     "s_memo2,";
        $sql .=     "s_memo3,";
        $sql .=     "s_memo4,";
        $sql .=     "s_memo5,";
        $sql .=     "s_fsize1,";
        $sql .=     "s_fsize2,";
        $sql .=     "s_fsize3,";
        $sql .=     "s_fsize4,";
        $sql .=     "s_fsize5,";
        $sql .=     "s_memo6,";
        $sql .=     "s_memo7,";
        $sql .=     "s_memo8,";
        $sql .=     "s_memo9";
        $sql .= ")VALUES(";
        $sql .= "    '$client_id',";
        $sql .= "    (SELECT COALESCE(MAX(s_pattern_id), 0)+1 FROM t_slip_sheet),";
        $sql .= "    '$s_pattern_name',";
        $sql .= "    '$bill_send_flg',";
        $sql .= "    '$s_memo1',";
        $sql .= "    '$s_memo2',";
        $sql .= "    '$s_memo3',";
        $sql .= "    '$s_memo4',";
        $sql .= "    '$s_memo5',";
        $sql .= "    '$s_fsize1',";
        $sql .= "    '$s_fsize2',";
        $sql .= "    '$s_fsize3',";
        $sql .= "    '$s_fsize4',";
        $sql .= "    '$s_fsize5',";
        $sql .= "    '$s_memo6',";
        $sql .= "    '$s_memo7',";
        $sql .= "    '$s_memo8',";
        $sql .= "    '$s_memo9') ";
    // �ѹ���
    }else{
        $sql  = "UPDATE ";
        $sql .= "    t_slip_sheet ";
        $sql .= "SET ";
        $sql .= "    s_pattern_name = '$s_pattern_name', ";
        $sql .= "    bill_send_flg = '$bill_send_flg', ";
        $sql .= "    s_memo1 = '$s_memo1', ";
        $sql .= "    s_memo2 = '$s_memo2', ";
        $sql .= "    s_memo3 = '$s_memo3', ";
        $sql .= "    s_memo4 = '$s_memo4', ";
        $sql .= "    s_memo5 = '$s_memo5', ";
        $sql .= "    s_fsize1 = '$s_fsize1', ";
        $sql .= "    s_fsize2 = '$s_fsize2', ";
        $sql .= "    s_fsize3 = '$s_fsize3', ";
        $sql .= "    s_fsize4 = '$s_fsize4', ";
        $sql .= "    s_fsize5 = '$s_fsize5', ";
        $sql .= "    s_memo6 = '$s_memo6', ";
        $sql .= "    s_memo7 = '$s_memo7', ";
        $sql .= "    s_memo8 = '$s_memo8', ";
        $sql .= "    s_memo9 = '$s_memo9' ";
        $sql .= "WHERE ";
        $sql .= "    shop_id = $client_id ";
        $sql .= "AND ";
        $sql .= "    s_pattern_id = $pattern_id;";
    }

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
$html_header = Html_Header($page_title);

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
    "auth_r_msg"    => "$auth_r_msg",
    "path_sale_slip"    => "$path_sale_slip",
    "path_claim_slip"   => "$path_claim_slip",
    "path_deli_slip"    => "$path_deli_slip",
    "path_receive_slip" => "$path_receive_slip",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
