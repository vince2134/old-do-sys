<?php
/*
 * ����
 *  ����        ô����          ����
 *-----------------------------------------------
 *  2007-11-18  watanabe-k      ��������
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
//SESSION�������
/****************************/
$group_kind = $_SESSION["group_kind"];

/****************************/
//POST�������
/****************************/
$form_data = $form->exportValues();

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
//ɽ���ܥ��󤬲������줿��� & ���顼�ʤ�
if($form_data["form_display"] == "ɽ����" && $form->validate()){

    //ɽ���ܥ��󲡲��ե饰
    $disp_flg = true;

    //���������
    //�����ξ��
    if($group_kind === "1"){
        $result = Select_Goods_Abc_Amount( $db_con, $form_data);
    //����åפξ��
    }else{
        $result = Select_Goods_Abc_Amount_Fc( $db_con, $form_data);
    }

    //ABC���饹�Υ��󥹥�������
    $abcObj = new Analysis_ABC();
    //������ǡ������
    $abcObj->Result_Change_Array($result);
    //ABCɽ���ѥǡ�������
    $abcObj->Set_Abc_Data();

    /****************************/
    //CSV���Ͻ���
    /****************************/
    //���Ϸ�����CSV�ξ��
    if($form_data["form_output_type"] == "2"){
        $csvobj = new Abc_Csv_Class($margin_flg);
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        //CSV����̾����
        $csv_head = array("���ʥ�����","����̾");

        $csvobj->Make_Csv_Head($csv_head);
        $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

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
));

//���֥������Ȥ�assign
$smarty->assign("disp_data", $abcObj->disp_data);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display("110.php.tpl");

#print_array($_POST);
?>
