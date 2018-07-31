<?php
$page_title = "��󥿥�TO��󥿥�";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
//$auth       = Auth_Check($db_con);
//$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
//($auth[0] == "r") ? $form->freeze() : null;


/****************************/
// �ǥե����������
/****************************/
$def_fdata = array(
	"form_output_radio" =>  1,
    "form_state_check"  =>  array(
        "keiyakutyu"        => 1,
        "shinkishinsei"     => 1,
        "kaiyakushinsei"    => 1,
        "kaiyakuzumi"       => 0,
    ),
);
$form->setDefaults($def_fdata);


/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*** �إå��ե����ࡡ***/
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", "onClick=\"javascript:location.href='1-1-141.php'\"");

// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

/*** �ᥤ��ե����� ***/
// ���Ϸ���
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "����", "1");
$radio[] =& $form->createElement("radio", null, null, "Ģɼ", "2");
$form->addGroup($radio, "form_output_radio", "");

// ����
$check[] =& $form->addElement("checkbox", "keiyakutyu", "", "������");
$check[] =& $form->addElement("checkbox", "shinkishinsei", "", "��������");
$check[] =& $form->addElement("checkbox", "kaiyakushinsei", "", "������");
$check[] =& $form->addElement("checkbox", "kaiyakuzumi", "", "�����");
$form->addGroup($check, "form_state_check", "");

// ��󥿥��ֹ�
$form->addElement("text", "form_rental_no", "", "size=\"9\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����åץ�����
$form->addElement("text", "form_shop_cd", "", "size=\"14\" maxlength=\"6\" style=\"$g_form_style\" $g_form_option");

// ����å�̾
$form->addElement("text", "form_shop_name", "", "size=\"28\" maxlength=\"25\" $g_form_option");

// ���ʥ�����
$form->addElement("text", "form_goods_cd", "", "size=\"14\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����̾
$form->addElement("text", "form_goods_name", "", "size=\"28\" maxlength=\"35\" $g_form_option");

// ɽ���ܥ���
$form->addElement("button","form_show_button","ɽ����"); 

// ���ꥢ�ܥ���
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// ���ܥ���
$form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");


/****************************/
// ����ɽ���ѥǡ�������
/****************************/
$sql  = "SELECT ";
$sql .= "   t_rental_h.shop_id, ";
$sql .= "   t_rental_h.shop_name, ";
$sql .= "   t_rental_h.rental_amount, ";
$sql .= "   t_rental_h.user_amount, ";
$sql .= "   t_rental_h.client_id, ";
$sql .= "   t_rental_h.client_cd1, ";
$sql .= "   t_rental_h.client_cd2, ";
$sql .= "   t_rental_h.client_name, ";
$sql .= "   t_rental_h.client_name2, ";
$sql .= "   t_rental_h.rental_id, ";
$sql .= "   t_rental_h.rental_no, ";
$sql .= "   t_rental_h.forward_day, ";
$sql .= "   t_rental_h.apply_day, ";
$sql .= "   t_rental_d.rental_stat, ";
$sql .= "   t_rental_d.goods_id, ";
$sql .= "   t_rental_d.goods_cd, ";
$sql .= "   t_rental_d.goods_name, ";
$sql .= "   t_rental_d.num, ";
$sql .= "   t_rental_d.serial_no, ";
$sql .= "   t_rental_d.rental_price, ";
$sql .= "   t_rental_d.rental_amount, ";
$sql .= "   t_rental_d.user_price, ";
$sql .= "   t_rental_d.user_amount ";
//$sql .= "   * ";
$sql .= "FROM ";
$sql .= "   t_rental_h ";
$sql .= "   LEFT JOIN t_rental_d ON t_rental_h.rental_id = t_rental_d.rental_id ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$data_list = Get_Data($res, "", "ASSOC");
//print_array($data_list);

// �����������쥳���ɿ�ʬ�롼��
foreach ($data_list as $key => $value){
    // ������̤�Ϣ�����������
    $assoc_ary_data[$value["shop_id"]][$value["client_id"]][$value["rental_id"]][] = $value;
}

// ��������Ϣ�����󤫤�ƥ쥳���ɤ�rowspan�򻻽�
foreach ($assoc_ary_data as $shop_key => $shop_value){
    foreach ($shop_value as $client_key => $client_value){
        foreach ($client_value as $rental_key => $rental_value){
            // �����襫�����rowspan
            $ary_client_rowspan[$shop_key][$client_key] += count($rental_value);
            // ��󥿥��ֹ楫�����rowspan
            $ary_rental_rowspan[$shop_key][$client_key][$rental_key] = count($rental_value);
        }
    }
}
print_array($ary_client_rowspan, "�����襫�����rowspan");
print_array($ary_rental_rowspan, "��󥿥��ֹ楫�����rowspan");
print_array($assoc_ary_data, "�쥳���ɥǡ���");

// ���̽�����html�ѿ����
$html = null;

// ����å�IDñ�̤Υ롼��
foreach ($assoc_ary_data as $shop_key => $shop_value){

    // ����������ֹ楫����
    $j = 0;

    // �ƥ���åפΥإå������
    $html .= "<table>\n";
    $html .= "  <tr>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "  </tr>\n";
    $html .= "</table>\n";

    // ����å�ñ�̤Υ�󥿥�ǡ���
    $html .= "<table border=\"1\">\n";
    $html .= "  <tr>\n";
    $html .= "      <td>No.</td>\n";
    $html .= "      <td>������</td>\n";
    $html .= "      <td>��󥿥��ֹ�</td>\n";
    $html .= "      <td>�в���</td>\n";
    $html .= "      <td>�ѹ�����������</td>\n";
    $html .= "      <td>����</td>\n";
    $html .= "      <td>���ʥ�����<br>����̾</td>\n";
    $html .= "      <td>����</td>\n";
    $html .= "      <td>���ꥢ��</td>\n";
    $html .= "      <td>��󥿥�ñ��<br>�����������</td>\n";
    $html .= "      <td>�桼����ñ��<br>�������������</td>\n";
    $html .= "  </tr>\n";

    // ������IDñ�̤Υ롼��
    foreach ($shop_value as $client_key => $client_value){

        // ��󥿥��襫����
        $k = 0;

        // ��󥿥�IDñ�̤Υ롼��
        foreach ($client_value as $rental_key => $rental_value){

            $rs_c = $ary_client_rowspan[$shop_key][$client_key];
            $rs_r = $ary_rental_rowspan[$shop_key][$client_key][$rental_key];

            $html .= "<tr>\n";
            if ($j == 0 && $k == 0){
            $html .= "  <td rowspan=\"".$rs_c."\">".++$j."</td>\n";
            $html .= "  <td rowspan=\"".$rs_c."\">".$rental_value["client_name"]."<br>".$rental_value["client_name2"]."</td>\n";
            }
            if ($k == 0){
            $html .= "  <td rowspan=\"".$rs_r."\">ren</td>\n";
            $html .= "  <td rowspan=\"".$rs_r."\">ren</td>\n";
            }
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "</tr>";

            // ������ñ�̤ζ�۹�פ����

            $k++;

        }

    }

    $html .= "</table>";
    $html .= "<br><br>";

}

//print_array($ary_disp_data);

/****************************/
// ����ɽ����
/****************************/
$disp_data = array(             // ����å���ǡ�������
    "0" =>  array(                  // ����åף��ǡ�������
        "0" =>  "���ҎƎÎ����؎�����(���۾���)", // ����å�̾
        "1" =>  "40",                   // ��ץ�󥿥��
        "2" =>  "33,760",               // ��ץ�󥿥���
        "3" =>  "36,680",               // ��ץ桼���󶡶��
        "4" =>  array(                  // ��󥿥�����ǡ�������
            "0" =>  array(                  // ��󥿥��裱�ǡ�������
                "0" =>  "Result1",              // �Կ�css
                "1" =>  "������A",              // ������̾
                "2" =>  array(                  // �в�����ǡ�������
                    "0" =>  array(                  // �в������ǡ�������
                        "0" =>  "1",                    // ��󥿥�إå�ID
                        "1" =>  "chg_req",              // ���ơ�����
                        "2" =>  "2006-04-01",           // �в���
                        "3" =>  array(                  // ��󥿥뾦����ǡ�������
                            "0" =>  array(                  // ��󥿥뾦�ʣ��ǡ�������
                                "",                             // ��󥿥��ѹ���������
                                "������",                       // ����
                                "����XTOTO",                  // ����̾
                                "1",                            // ����
                                "A-1",                          // ���ꥢ��
                                array("1,000", "1,000"),        // ��󥿥�ñ�������
                                array("1,200", "1,200"),        // �桼����ñ�������
                                "",                             // ����
                            ),
                            "1" =>  array(                  // ��󥿥뾦�ʣ��ǡ�������
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "2006-04-20",
                                "�����",
                                "��ư���� �����餮",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "2006-07-01",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "2006-07-20",
                                "������",
                                "�����ȥ��꡼�ʡ�����",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(                  // �в������ǡ�������
                        "0" =>  "2",
                        "1" =>  "new_req",
                        "2" =>  "---",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "��������",
                                "��ư���� �����餮",
                                "1",
                                "",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "��������",
                                "�����ȥ��꡼�ʡ�����",
                                "4",
                                "",
                                array("200", "800"),
                                array("300", "1,200"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "��������",
                                "�ԥԥ���å�CT1",
                                "5",
                                "",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
            "1" =>  array(                  // ��󥿥��裲�ǡ�������
                "0" =>  "Result2",
                "1" =>  "������B",
                "2" =>  array(
                    "0" =>  array(
                        "0" =>  "3",
                        "1" =>  "non_req",
                        "2" =>  "2006-04-11",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "������",
                                "����XTOTO",
                                "1",
                                "A-1",
                                array("1,000", "1,000"),
                                array("1,200", "1,200"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(
                                "2006-07-01",
                                "�����",
                                "��ư���� �����餮",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(
                                "",
                                "������",
                                "�����ȥ��꡼�ʡ�����",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(
                        "0" =>  "4",
                        "1" =>  "new_req",
                        "2" =>  "---",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "��������",
                                "��ư���� �����餮",
                                "1",
                                "",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "��������",
                                "�����ȥ��꡼�ʡ�����",
                                "4",
                                "",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "��������",
                                "�ԥԥ���å�CT1",
                                "5",
                                "",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    "1" =>  array(                  // ����åף��ǡ�������
        "0" =>  "��ǥ�����",           // ����å�̾
        "1" =>  "40",                   // ��ץ�󥿥��
        "2" =>  "33,760",               // ��ץ�󥿥���
        "3" =>  "36,680",               // ��ץ桼���󶡶��
        "4" =>  array(                  // ��󥿥�����ǡ�������
            "0" =>  array(                  // ��󥿥��裱�ǡ�������
                "0" =>  "Result1",              // �Կ�css
                "1" =>  "������A",              // ������̾
                "2" =>  array(                  // �в�����ǡ�������
                    "0" =>  array(                  // �в������ǡ�������
                        "0" =>  "5",                    // ��󥿥�إå�ID
                        "1" =>  "non_req",              // ���ơ�����
                        "2" =>  "2006-04-01",           // �в���
                        "3" =>  array(                  // ��󥿥뾦����ǡ�������
                            "0" =>  array(                  // ��󥿥뾦�ʣ��ǡ�������
                                "",                             // ��󥿥��ѹ���������
                                "������",                       // ����
                                "����XTOTO",                  // ����̾
                                "1",                            // ����
                                "A-1",                          // ���ꥢ��
                                array("1,000", "1,000"),        // ��󥿥�ñ�������
                                array("1,200", "1,200"),        // �桼����ñ�������
                                "",                             // ����
                            ),
                            "1" =>  array(                  // ��󥿥뾦�ʣ��ǡ�������
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "2006-07-01",
                                "�����",
                                "��ư���� �����餮",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(                  // ��󥿥뾦�ʣ��ǡ���a����
                                "",
                                "������",
                                "�����ȥ��꡼�ʡ�����",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
            "1" =>  array(                  // ��󥿥��裲�ǡ�������
                "0" =>  "Result2",
                "1" =>  "������B",
                "2" =>  array(
                    "0" =>  array(
                        "0" =>  "6",
                        "1" =>  "non_req",
                        "2" =>  "2006-04-11",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "������",
                                "����XTOTO",
                                "1",
                                "A-1",
                                array("1,000", "1,000"),
                                array("1,200", "1,200"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "152",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "153",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(
                                "2006-07-01",
                                "�����",
                                "��ư���� �����餮",
                                "1",
                                "151",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(
                                "",
                                "������",
                                "�����ȥ��꡼�ʡ�����",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(
                        "0" =>  "7",
                        "1" =>  "non_req",
                        "2" =>  "2006-06-06",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "������",
                                "��ư���� �����餮",
                                "1",
                                "251",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "������",
                                "�����ȥ��꡼�ʡ�����",
                                "4",
                                "-",
                                array("200", "800"),
                                array("300", "1,200"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "������",
                                "�ԥԥ���å�CT1",
                                "5",
                                "B-1",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
    

// �����ѥǡ����θĿ��������(rowspan°���ͻ�����)
// ����å���롼��
for ($i = 0; $i < count($disp_data); $i++){
    // ��󥿥�����롼��
    for ($j = 0; $j < count($disp_data[$i][4]); $j++){
        // ��󥿥�إå�ID��롼��
        for ($k = 0; $k < count($disp_data[$i][4][$j][2]); $k++){
            // ���ʿ��������
            $count = count($disp_data[$i][4][$j][2][$k][3]);
            $disp_count[$i][$j] += $count;
        }
    }
}


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
$page_menu = Create_Menu_h("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
    "html"          => "$html",
));

//ɽ���ǡ���
$smarty->assign("disp_data", $disp_data);
$smarty->assign("disp_count", $disp_count);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
