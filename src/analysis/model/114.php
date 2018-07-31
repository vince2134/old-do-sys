<?php

/*
 * ����
 *
 *  ����        ô����          ����
 *-----------------------------------------------
 *  2007-11-23  fukuda          ��������
 *
 */

//-----------------------------------------------
// �������
//-----------------------------------------------
// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ����å�ID
$shop_id    = $_SESSION["client_id"];

// �ե����४�֥����������
Mk_Form($db_con, $form);


//-----------------------------------------------
// ɽ���ܥ��󲡲�������
//-----------------------------------------------
// ɽ���ܥ����POST�ǡ�����������
if ($_POST["form_display"] != null) {

    // POST�ե饰
    $post_flg = true;

    // POST�ǡ�������
    $post = $form->exportValues();

    // ���顼�����å�����
    Err_Chk_Date_YM($form);

    // ���顼�����å�Ŭ��
    $form->validate();

    // ���顼�����å����
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


//-----------------------------------------------
// �ǡ�����н���
//-----------------------------------------------
// POST�ե饰��true�ܥ��顼�����å���̤�true�Ǥʤ����
if ($post_flg === true && $err_flg !== true) {

    // ���������
    if ($shop_id === "1") {
        // ������ǽ������
        $res = Select_Staff_Abc_Amount_h($db_con, $post, $shop_id);
    } else {

        #hashimoto-y 2007-12-02
        #require_once("../function/analysis_query_ABC_hashi.fnc");
        #$res = Select_Staff_Abc_Amount_f_hashi($db_con, $post, $shop_id);

        // FC��ǽ������
        $res = Select_Staff_Abc_Amount_f($db_con, $post, $shop_id);

    }

    // ABC���饹�Υ��󥹥�������
    $abcObj = new Analysis_ABC();

    // ������ǡ������
    $abcObj->Result_Change_Array($res);

    // ABCɽ���ѥǡ�������
    $abcObj->Set_Abc_Data();

    // ���ϥե饰
    $out_flg = true;

}


//-----------------------------------------------
// CSV���Ͻ���
//-----------------------------------------------
// CSV���Ϥ����򤵤�Ƥ����err�ե饰��false�ξ��
if ($post["form_output_type"] === "2" && $err_flg === false) {

    $csvobj = new Abc_Csv_Class();
    $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

    // CSV����̾����
    $csv_head = array("ô���ԥ�����", "�����å�̾");

    $csvobj->Make_Csv_Head($csv_head);
    $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

    // CSV���Ϥ��ƽ�λ
    Header("Content-disposition: attachment; filename=".$csvobj->filename);
    Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
    print $csvobj->res_csv;
    exit;

}


//-----------------------------------------------
// HTML�ƥ�ץ졼���ѥǡ���
//-----------------------------------------------
// HTML�إå�
$html_header = Html_Header($page_title);

// HTML�եå�
$html_footer = Html_Footer();

// ���̥إå�������
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// �ǡ�����assign
$smarty->assign("disp_data", $abcObj->disp_data);
$smarty->assign("out_flg",   $out_flg);

// ����¾�Υǡ�����assign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display("114.php.tpl");

