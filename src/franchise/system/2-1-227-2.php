<?php
$page_title = "�������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_gid  = $_SESSION[shop_gid];

/****************************/
//�������
/****************************/
// ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

//�ܥ���
// ɽ��
$form->addElement("submit","show_button","ɽ����","onClick=\"javascript:document.dateForm.submit()\"");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// �إå��ѥܥ���
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", "onClick=\"javascript:Referer('2-1-228.php')\"");

// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/****************************/
// ����ɽ�ѥǡ�������
/****************************/
$ary_list_item[0] = array(
    "0" =>  array(                          // ô������ǡ���
        "0" =>  "Result1",                  // �����طʿ�����
        "1" =>  array("0", "ô���ԣ�"),     // staff_id, staff_name
        "2" =>  array(                      // ��(A-D)��ǡ���
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "�ޥ졼����������", "�ե륳����", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "��������������������", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "��ҥ�����")
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "���⥳����", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        )
    )
);

$ary_list_item[1] = array(
    "0" =>  array(                          // ô������ǡ���
        "0" =>  "Result1",                  // �����طʿ�����
        "1" =>  array("0", "ô���ԣ�"),     // staff_id, staff_name
        "2" =>  array(                      // ��(A-D)��ǡ���
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "�ޥ졼����������", "�ե륳����", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "4" =>  array("����������")     // ����
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "��������������������", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "��ҥ�����"),
            "4" =>  array("-")              // ����
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "���⥳����", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "4" =>  array("-")              // ����
        )
    )
);

$ary_list_item[2] = array(
    "0" =>  array(                          // ô������ǡ���
        "0" =>  "Result1",                  // �����طʿ�����
        "1" =>  array("0", "ô���ԣ�"),     // staff_id, staff_name
        "2" =>  array(                      // ��(A-D)��ǡ���
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "-", "-", "�ޥ졼����������", "�ե륳����", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        ),
    ),
    "1" =>  array(
        "0" =>  "Result2",
        "1" =>  array("1", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("��������������", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "���ͥ�����", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "��������������������", "-", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "��ҥ�����")
        ),
    ),
    "2" =>  array(
        "0" =>  "Result1",
        "1" =>  array("2", "ô���ԣ�"),
        "2" =>  array(
            "0" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "1" =>  array("-", "-", "-", "-", "-", "-", "-"),
            "2" =>  array("-", "-", "���⥳����", "-", "-", "-", "-"),
            "3" =>  array("-", "-", "-", "-", "-", "-", "-")
        )
    )
);

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
$page_menu = Create_Menu_f('system','1');

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
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
	'comp_msg'   	=> "$comp_msg"
));

$smarty->assign("ary_list_item", $ary_list_item);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
