<?php
$page_title = "��󥿥�TO��󥿥�";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

//  DB��³
$db_con = Db_Connect();

//  ���¥����å�
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;

/****************************/
// �����ѿ�
/****************************/
$rental_h_id    = $_GET["rental_h_id"]; // ��󥿥�إå�ID
$state          = $_GET["state"];       // ����


/****************************/
// �����ѥǡ�������
/****************************/
// ������Ͽ�ʥ��ե饤�󥷥�å��ѡˤǤʤ����
if ($rental_h_id != null){

    // ������󥿥�إå�ID�Υ���å�ID�����
    // �ʲ��ν����ϤȤꤢ�����ʥ�ǥ����ݡᥪ�ե饤�󰷤���ά�Ρᥪ��饤�󰷤���
    $fshop_id = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7") ? "189" : "113";

    // ������󥿥�إå�ID�Υ���åפ�����饤�󤫥��ե饤��Ĵ�٤�
    // �ʲ��ν����ϤȤꤢ����
    $fshop_network = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7") ? "off" : "on";

    // ��������åפ������������
    // �ʲ��ν����ϤȤꤢ����
    $seikyu_date = "25��";

    /* ����åץǡ��� */
    $disp_fshop_data = array(
        $fshop_id,                      // ����å�ID
        $seikyu_date,                   // ������������
    );

}

/* �ơ��֥룱�ѥǡ��� */
if ($state != null){
    $disp_table1_data = array(
        "45",                           // ����ô����
        "44",                           // ���ô����
        "�Х���Ω���ե�",               // ������̾
        "045-xxx-xxxx",                 // ������TEL
        array("123", "4567"),           // �����ͽ����͹���ֹ棱��͹���ֹ棲��
        array("��������ͻ԰�Ҷ���", "�����ƥ�ץ饶���2���"),  
                                        // �����ͽ���ʽ��꣱�����ꣲ��
        "2006",                         // ��󥿥뿽������ǯ��
        "06",                           // ��󥿥뿽�����ʷ��
        "08",                           // ��󥿥뿽����������
    );
}

/* �ơ��֥룲�ѥǡ��� */
if ($state == null || $state == "new_req"){
    $disp_seikyu_data = date("m");      // �������ʷ��
}else{
    $disp_table2_data = array(
        "2006",                         // ��󥿥�в�����ǯ��
        "06",                           // ��󥿥�в����ʷ��
        "09",                           // ��󥿥�в���������
        "44",                           // ����ô����
        "���ͣ�",                       // ����
        "6",                            // �������ʷ��
        "25��",                         // ������������
    );
}

/* ���ʰ����ǡ��� */
// ������Ͽ���ʥ��ե饤���
// �ʲ�������ϤȤꤢ����
if ($state == null){
    $disp_goods_data = array(
        "0" =>  array(
            "Result1",
            "00000001",
            "����XTOTO",
            "1",
            array("0001"),
            array("1000", "1,000"),
            array("1200", "1,200"),
        ),
        "1" =>  array(
            "Result2",
            "00000002",
            "��ư���� �����餮",
            "3",
            array("1001", "1002", "1003"),
            array("1000", "1,000"),
            array("1200", "1,200"),
        ),
        "2" =>  array(
            "Result1",
            "00000003",
            "�����ȥ��꡼�ʡ�����",
            "6",
            array(""),
            array("200", "1,200"),
            array("300", "1,800"),
        ),
    );
}

// ��������ʥ��ե饤���
if ($state == "non_req" && $fshop_network == "off"){
    $disp_goods_data = array(           // ������ǡ���
        "0" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",                  // �Կ�css
            "1" =>  "00000001",                 // ���ʥ�����
            "2" =>  "����XTOTO",              // ����̾
            "3" =>  "1",                        // ������Υ��ꥢ���
            "4" =>  array(                      // ���ꥢ����ǡ���
                "0" =>  array(                      // ���ꥢ�룱�ǡ���
                    "������",                           // ����
                    "1",                                // ����
                    "",                                 // ������
                    "A-1",                              // ���ꥢ��
                ),
            ),
            "5" =>  array("1000", "1,000"),     // ��󥿥�ñ�������
            "6" =>  array("1200", "1,200"),     // �桼����ñ�������
        ),
        "1" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "��ư���� �����餮",
            "3" =>  "2",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "1",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "������",
                    "1",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "�����",
                    "1",
                    "2006-07-01",
                    "053",
                ),
            ),
            "5" =>  array("900", "1,800"),
            "6" =>  array("1000", "2,000"),
        ),
        "2" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "�����ȥ��꡼�ʡ�����",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "6",
                    "",
                    "-",
                ),
            ),
            "5" =>  array("1000", "1,000"),
            "6" =>  array("1200", "1,200"),
        ),
    );
}

// �����������ʥ���饤���
if ($state == "new_req"){
    $disp_goods_data = array(           // ������ǡ���
        "0" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",                  // �Կ�css
            "1" =>  "00000001",                 // ���ʥ�����
            "2" =>  "����XTOTO",              // ����̾
            "3" =>  array(                      // ���ꥢ����ǡ���
                array("1", "0001"),                 // ���̡����ꥢ��
                array("1", "0002"),
                array("1", "0003"),
            ),
            "4" =>  array("1000", "3,000"),     // ��󥿥�ñ�������
            "5" =>  array("1,200", "3,600"),
        ),
        "1" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "��ư���� �����餮",
            "3" =>  array(
                array("1", "1001"),
                array("1", "1002"),
            ),
            "4" =>  array("900", "1,800"),
            "5" =>  array("1,000", "2,000"),
        ),
        "2" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "�����ȥ��꡼�ʡ�����",
            "3" =>  array(
                array("6", "-"),
            ),
            "4" =>  array("200", "1,200"),
            "5" =>  array("300", "1,800"),
        ),
    );

    // �����ѥǡ����θĿ��������(rowspan°���ͻ�����)
    // ������롼��
    for ($i = 0; $i < count($disp_goods_data); $i++){
        // ���ꥢ����������
        $count = count($disp_goods_data[$i][3]);
        $disp_count[$i] += $count; 
    }

}

// ��������ʥ���饤���
if ($state == "non_req" && $fshop_network == "on"){
    $disp_goods_data = array(           // ������ǡ���
        "0" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",                  // �Կ�css
            "1" =>  "00000001",                 // ���ʥ�����
            "2" =>  "����XTOTO",              // ����̾
            "3" =>  "1",                        // ������Υ��ꥢ���
            "4" =>  array(                      // ���ꥢ����ǡ���
                "0" =>  array(                      //  ���ꥢ�룱�ǡ���
                    "������",                           // ����
                    "1",                                // ����
                    "",                                 // ������
                    "A-1",                              // ���ꥢ��
                ),
            ),
            "5" =>  array("1000", "1,000"),     // ��󥿥�ñ�������
            "6" =>  array("1,200", "1,200"),    // �桼����ñ�������
        ),
        "1" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "��ư���� �����餮",
            "3" =>  "2",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "1",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "������",
                    "1",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "�����",
                    "1",
                    "2006-07-01",
                    "053",
                ),
            ),
            "5" =>  array("900", "900"),
            "6" =>  array("1,000", "1,000"),
        ),
        "2" =>  array(
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "�����ȥ��꡼�ʡ�����",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "6",
                    "",
                    "-",
                ),
            ),
            "5" =>  array("200", "1,200"),
            "6" =>  array("300", "1,800"),
        ),
    );
}

// ���������ʥ���饤���
if ($state == "chg_req"){
    $disp_goods_data  = array(                // ������ǡ���
        "0" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result1",                  // �Կ�css
            "1" =>  "00000001",                 // ���ʥ�����
            "2" =>  "����XTOTO",              // ����̾
            "3" =>  "1",                        // ������Υ��ꥢ���
            "4" =>  array(                          // ���ꥢ����ǡ���
                "0" =>  array(                          // ���ꥢ�룱�ǡ���
                    "������",                               // ����
                    "1",                                    // ����
                    "",                                     // ��������
                    "",                                     // ������
                    "A-1",                                  // ���ꥢ��
                ),
            ),
            "5" =>  array("1000", "1,000"),     // ��󥿥�ñ�������
            "6" =>  array("1,200", "1,200"),    // �桼����ñ�������
        ),
        "1" =>  array(                      // ���ʣ��ǡ���
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "��ư���� �����餮",
            "3" =>  "3",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "1",
                    "",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "������",
                    "1",
                    "",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "������",
                    "1",
                    "",
                    "",
                    "053",
                ),
                "3" =>  array(
                    "�����",
                    "1",
                    "",
                    "2006-07-01",
                    "047"
                ),
                "4" =>  array(
                    "�����",
                    "1",
                    "",
                    "2006-07-01",
                    "048",
                ),
                "5" =>  array(
                    "�����",
                    "1",
                    "",
                    "2006-07-04",
                    "049",
                ),
                "6" =>  array(
                    "������",
                    "1",
                    "1",
                    "2006-07-20",
                    "050",
                ),
            ),
            "5" =>  array("900", "2,700"),
            "6" =>  array("1,000", "3,000"),
        ),
        "2" =>  array(
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "�����ȥ��꡼�ʡ�����",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "������",
                    "4",
                    "",
                    "",
                    "-",
                ),
                "1" =>  array(
                    "�����",
                    "1",
                    "",
                    "2006-07-01",
                    "-",
                ),
                "2" =>  array(
                    "�����",
                    "2",
                    "",
                    "2006-07-04",
                    "-",
                ),
            ),
            "5" =>  array("200", "300"),
            "6" =>  array("1,200", "1,800"),
        ),
    );
}
            

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*** �إå��ե����ࡡ***/
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:location.href='1-1-142.php'\"");

/*** �ᥤ��ե����� ***/
// ����å�̾
$select_value = Select_Get($db_con, "fshop");
$fshop = $form->addElement("select", "form_fshop_select", "", $select_value, $g_form_option_select);


// ����ô����
$select_value = Select_Get($db_con, "staff");
$table1_1[] = $form->addElement("select", "form_shinsei_tantou_select", "", $select_value, $g_form_option_select);

// ���ô����
$select_value = Select_Get($db_con, "staff");
$table1_1[] = $form->addElement("select", "form_junkai_tantou_select", "", $select_value, $g_form_option_select);

// ������̾
$table1_2[] = $form->addElement("text", "form_name", "", "size=\"30\" $g_form_option");

// ������TEL
$table1_2[] = $form->addElement("text", "form_tel", "", "size=\"30\" style=\"$g_form_style\" $g_form_option");

// �����ͽ����͹���ֹ��
$text = null;
$text[] = $form->createElement("static", "", "", "��");
$text[] = $form->createElement("text", "no1", "", "size=\"3\" style=\"$g_form_style\" $g_form_option");
$text[] = $form->createElement("static", "", "", "-");
$text[] = $form->createElement("text", "no2", "", "size=\"4\" style=\"$g_form_style\" $g_form_option");
$table1_2[] = $form->addGroup($text, "form_post", "");

// �����ͽ���ʽ��꣱�����ꣲ��
$table1_2[] = $form->addElement("text", "form_address2", "", "size=\"50\" $g_form_option");
$table1_2[] = $form->addElement("text", "form_address1", "", "size=\"50\" $g_form_option");

// ��󥿥뿽����
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_moushikomi_date[y]','form_moushikomi_date[m]',4)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_moushikomi_date[m]','form_moushikomi_date[d]',2)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" $g_form_option");
$table1_2[] = $form->addGroup($text, "form_moushikomi_date", "");


// ��󥿥�в���
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_syukka_date[y]','form_syukka_date[m]',4)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_syukka_date[m]','form_syukka_date[d]',2)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" $g_form_option");
$table2[] = $form->addGroup($text, "form_syukka_date", "");

// ����ô����
$select_value = Select_Get($db_con, "staff");
$table2[] = $form->addElement("select", "form_honbu_tantou_select", "", $select_value, $g_form_option_select);

// ����
$table2[] = $form->addElement("text", "form_note", "", "size=\"50\" style=\"$g_form_style\" $g_form_option");

// �������ʷ��
$array_month[null] = null;
for ($i=1; $i<=12; $i++){
    $array_month[$i] = $i;
};
$table2[] = $form->addElement("select", "form_seikyu_month_select", "", $array_month, $g_form_option_select);

// ������(��)
$table2[] = $form->addElement("static", "form_seikyu_date_static", "", "");


for ($i=0; $i<count($disp_goods_data); $i++){
    // ���ʥ�����
    $form->addElement("text", "form_goods_cd[$i]", "", "size=\"10\" maxlenght=\"8\" style=\"$g_form_style\" $g_form_option");   

    // ����̾
    $form->addElement("text", "form_goods_name[$i]", "", "size=\"40\" maxlength=\"35\" style=\"$g_form_style\" $g_form_option");

    // ����
    $form->addElement("text", "form_goods_num[$i]", "", "size=\"6\" style=\"text-align: right; $g_form_style\" $g_form_option");   

    // ��������ʥ��ե饤��ˤΤ�
    if ($state == "non_req" && $fshop_network == "off"){
        for ($j=0; $j<count($disp_goods_data[$i][4]); $j++){
            // ������"������"�ξ��Τ�
            if ($disp_goods_data[$i][4][$j][0] == "������"){
                // ��������å��ܥå���
                $form->addElement("checkbox", "form_kaiyaku_check[$i][$j]", "", "");
            }
            // ���ꥢ�뤬"-"�ξ��Τ�
            if ($disp_goods_data[$i][4][$j][3] == "-"){
                // �����
                $form->addElement("text", "form_kaiyaku_num[$i][$j]", "", "size=\"3\" style=\"$g_form_style\" $g_form_option");
            }
        }
    }

    // ����ǡ�����Υ��ꥢ���Key����
    $serial = ($state == null) ? 4 : $serial;                                   // ������Ͽ���ʥ��ե饤���
    $serial = ($state == "non_req" && $fshop_network == "off") ? 4 : $serial;   // ����������ʥ��ե饤���
    $serial = ($state == "new_req") ? 3 : $serial;                              // �����������ʥ���饤���
    $serial = ($state == "non_req" && $fshop_network == "on") ? 4 : $serial;    // ����������ʥ���饤���
    $serial = ($state == "chg_req") ? 4 : $serial;                              // ���������ʥ���饤���
    for ($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
        // ���ꥢ��
        $form->addElement("text", "form_serial[$i][$j]", "", "size=\"10\" style=\"$g_form_style\" $g_form_option");   
    }

    // ��󥿥�ñ��
    $form->addElement("text", "form_rental_price[$i]", "", "size=\"11\" maxLength=\"9\" class=\"money\" style=\"$g_form_style\" $g_form_option");

    // ��󥿥���
    $form->addElement("static", "form_rental_amount[$i]", "", "");   

    // �桼����ñ��
    $form->addElement("text", "form_user_price[$i]", "", "size=\"11\" maxLength=\"9\" class=\"money\" style=\"$g_form_style\" $g_form_option");

    // �桼���󶡶��
    $form->addElement("static", "form_user_amount[$i]",  "", "");   

}


// ��Ͽ�ܥ���ʿ�����Ͽ���ʥ��ե饤��ˡ�
$form->addElement("button", "form_add_button", "�С�Ͽ", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=5'\"");

// �ѹ��ܥ���ʷ�������ʥ��ե饤��ˡ�
$form->addElement("button", "form_chg_off_button", "�ѡ���", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=chg_req'\"");

// ��ǧ�ܥ���ʿ����������ʥ���饤��ˡ�
$form->addElement("button", "form_new_accept_button", "����ǧ", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=new_req'\"");

// �ѹ��ܥ���ʷ�������ʥ���饤��ˡ�
$form->addElement("button", "form_chg_on_button", "�ѡ���", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=chg_req'\"");

// ����ǧ�ܥ���ʲ��������ʥ���饤��ˡ�
$form->addElement("button", "form_chg_accept_button", "����ǧ", "onClick=\"javascript: location.href='1-1-142.php'\"");

// ���ܥ���
$form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");


/****************************/
// freeze
/****************************/
// ����å�̾
($state != null) ? $fshop->freeze() : null;

// �����������ʥ���饤���
if ($state == "new_req"){
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}

// ��������ʥ���饤���
if ($state == "non_req" && $fshop_network == "on"){
    $freeze_table1_1 = $form->addGroup($table1_1, "freeze_table1_1", "");
    $freeze_table1_1->freeze();
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}

// ���������ʥ���饤���
if ($state == "chg_req"){
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}


/****************************/
// �ե�����ǡ���SET�ʥ���å�̾��
/****************************/
// ������Ͽ���ʳ�
if ($state != null){
    $fshop_data["form_fshop_select"]        =   $disp_fshop_data[0];
    $fshop_data["form_seikyu_date_static"]  =   $disp_fshop_data[1];
    $form->setDefaults($fshop_data);
}

/****************************/
// �ե�����ǡ���SET�ʥơ��֥룱��
/****************************/
// ������Ͽ���ʳ�
if ($state != null){
    $def_table1_data = array(
        "form_shinsei_tantou_select"    =>  $disp_table1_data[0],
        "form_junkai_tantou_select"     =>  $disp_table1_data[1],
        "form_name"                     =>  $disp_table1_data[2],
        "form_tel"                      =>  $disp_table1_data[3],
        "form_post"                     =>  array(
            "no1"                       =>  $disp_table1_data[4][0],
            "no2"                       =>  $disp_table1_data[4][1],
        ),
        "form_address1"                 =>  $disp_table1_data[5][0],
        "form_address2"                 =>  $disp_table1_data[5][1],
        "form_moushikomi_date[y]"       =>  $disp_table1_data[6], 
        "form_moushikomi_date[m]"       =>  $disp_table1_data[7],
        "form_moushikomi_date[d]"       =>  $disp_table1_data[8],
    );
    $form->setDefaults($def_table1_data);
}

/****************************/
// �ե�����ǡ���SET�ʥơ��֥룲��
/****************************/
// �����桦��������
if ($state == "non_req" || $state == "chg_req"){
    $def_table2_data = array(
        "form_syukka_date[y]"           =>  "$disp_table2_data[0]", 
        "form_syukka_date[m]"           =>  "$disp_table2_data[1]",
        "form_syukka_date[d]"           =>  "$disp_table2_data[2]",
        "form_honbu_tantou_select"      =>  "$disp_table2_data[3]",
        "form_note"                     =>  "$disp_table2_data[4]",
        "form_seikyu_month_select"      =>  "$disp_table2_data[5]",
        "form_seikyu_date_static"       =>  "$disp_table2_data[6]",
    );
    $form->setDefaults($def_table2_data);
}

// ������Ͽ���ʥ��ե饤���
if($state == null || $state == "new_req"){
    $def_table2_data["form_seikyu_month_select"] =  $disp_seikyu_data;
    $form->setDefaults($def_table2_data);
}

/****************************/
// �ե�����ǡ���SET�ʰ���table��
/****************************/
// ������Ͽ���ʥ��ե饤���
// �ʲ��ν����ϤȤꤢ����
if ($state == null){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_goods_cd[$i]"         =>  $disp_goods_data[$i][1],
            "form_goods_name[$i]"       =>  $disp_goods_data[$i][2],
            "form_goods_num[$i]"        =>  $disp_goods_data[$i][3],
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
            "form_rental_amount[$i]"    =>  $disp_goods_data[$i][5][1],
            "form_user_price[$i]"       =>  $disp_goods_data[$i][6][0],
            "form_user_amount[$i]"      =>  $disp_goods_data[$i][6][1],
        );
        $form->setDefaults($def_goods_data);
    }
}

// ��������ʥ��ե饤���
if ($state == "non_req" && $fshop_network == "off"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][3],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
            "form_user_price[$i]"       =>  $disp_goods_data[$i][6][0],
        );
        $form->setDefaults($def_goods_data);
    }
}
    

// �����������ʥ���饤���
if ($state == "new_req"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_goods_num[$i]"    =>  $disp_goods_data[$i][3][$j][0],
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][1],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][4][0],
        );
        $form->setDefaults($def_goods_data);
    }
}

// ��������ʥ���饤���
if ($state == "non_req" && $fshop_network == "on"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][3],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_goods_name[$i]"       =>  $disp_goods_data[$i][2],
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
        );
        $form->setDefaults($def_goods_data);
    }
}

// ���������ʥ���饤���
if ($state == "chg_req"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][4],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
        );
        $form->setDefaults($def_goods_data);
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
$page_menu = Create_Menu_h("system", "1");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


//  Render��Ϣ������
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
    "state"         => "$state",  
    "fshop_network" => "$fshop_network",
    "disp_count"    => "$disp_count",
));

// ɽ���ǡ���
$smarty->assign("disp_table1_data", $disp_table1_data);
$smarty->assign("disp_table2_data", $disp_table2_data);
$smarty->assign("disp_goods_data", $disp_goods_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
