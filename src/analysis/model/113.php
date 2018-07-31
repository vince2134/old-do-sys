<?php
/*
 * ����
 *  ����        ô����          ����
 *-----------------------------------------------
 *  2007-11-23  aizawa-m      ��������
 *
 *  @model  113.php ( �ȼ���ABCʬ�� ��
 *
 */

/**************************/
// ��������
/*************************/
// �ڡ��������ȥ�
$page_title = "�ȼ���ABCʬ��";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB��³
$db_con = Db_Connect();

// ���å���󤫤����
$group_kind = $_SESSION["group_kind"];

// CSV����̾����
$csv_head = array(  "�ȼ拾����",
                    "�ȼ�̾",
                );

/*******************************/
// �ե����४�֥������Ⱥ���
/*******************************/
// �ե�����κ���
Mk_Form($db_con, $form);

// ���顼��å���������
Err_Chk_Date_YM($form, "form_trade_ym_s");


/**************************/
// POST�������
/**************************/
$form_data = $form->exportValues();


/**************************/
// ɽ���ܥ��󲡲�
/**************************/
if ( $form_data["form_display"] == "ɽ����" AND $form->validate()) {

    // ɽ���ܥ��󲡲��ե饰
    $disp_flg   = true;

    // ���������
    $result     = Select_Customer_Type_Abc_Amount($db_con, $form_data,"type");
    // ABC���饹�Υ��󥹥�������
    $abcObj     = new Analysis_ABC();
    // ������ǡ������
    $abcObj->Result_Change_Array($result);
    // ABCɽ���ѥǡ�������
    $abcObj->Set_Abc_Data();

    /*************************/
    // CSV���Ͻ���
    /*************************/
    if ($form_data["form_output_type"] == "2") {
        $csvobj = new ABC_Csv_Class();
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        // CSV����̾����
        $csvobj->Make_Csv_Head($csv_head);
        $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

        // CSV����
        Header("Content-disposition: attachment; filename=".$csvobj->filename);
        Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
        print $csvobj->res_csv;
        exit;
    }
}

/*************************/
// HTML�إå�
/*************************/
$html_header = Html_Header($page_title);


/*************************/
// HTML�եå�
/*************************/
$html_footer = Html_Footer();


/*************************/
// ��˥塼����
/*************************/
$page_menu = Create_Menu_h("analysis","1");


/*************************/
// ���̥إå�������
/*************************/
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
            'disp_flg'      => "$disp_flg",
            'group_kind'    => "$group_kind",
));
//���֥������Ȥ�assign
$smarty->assign("disp_data", $abcObj->disp_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display("113.php.tpl");

?>
