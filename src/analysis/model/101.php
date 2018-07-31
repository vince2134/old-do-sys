<?php
/*
 * ����
 *  ����        ô����          ����
 *-----------------------------------------------
 *  2007-10-27  watanabe-k      ��������
 *
 */
//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

/****************************/
//�ե����४�֥������Ⱥ���
/****************************/
//HTML�ѡ��ĺ���
Mk_Form($db_con, $form);

//���顼��å���������
Err_Chk_Date_YM ($form, "form_trade_ym_s");

/****************************/
//POST�������
/****************************/
$form_data = $form->exportValues();

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
//ɽ���ܥ��󤬲������줿��� & ���顼�ʤ�
if($form_data["form_display"] == "ɽ����" && $form->validate()){

    //ɽ���ǡ������
    $result = Select_Each_SG_Amount($db_con, "goods", $form_data);

    //ɽ���ǡ�������
    $disp_data = Edit_Query_Data( $result, $form_data);

    //ɽ�Υإå������
    $disp_head  = Get_Header_YM($form_data["form_trade_ym_s"]["y"],
                             $form_data["form_trade_ym_s"]["m"],
                             $form_data["form_trade_ym_e"]);
    //����ɽ���ե饰
    $disp_flg   = true;

    //����ɽ���ե饰
    $margin_flg = ($form_data["form_margin"] == 1)? true : false;
    
    /****************************/
    //CSV���Ͻ���
    /****************************/
    //���Ϸ�����CSV�ξ��
    if($form_data["form_output_type"] == "2"){

        $csvobj = new Analysis_Csv_Class($margin_flg);
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        //CSV����̾����
        $csv_head = array("���ʥ�����", "����̾");

        $csvobj->Make_Csv_Head($disp_head, $csv_head);
        $csvobj->Make_Csv_Data($disp_data);

        //csv����
        Header("Content-disposition: attachment; filename=".$csvobj->filename);
        Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
        print $csvobj->res_csv;
        exit;
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
$page_menu = Create_Menu_f('analysis','1');

/****************************/
//���̥إå�������
/****************************/
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
	'margin_flg'    => "$margin_flg",
));

//ɽ���ǡ�����assign
$smarty->assign("disp_head", $disp_head);
$smarty->assign("disp_data", $disp_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display("101.php.tpl");

#print_array($_POST);

?>
