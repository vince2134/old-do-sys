<?php
/**
 *
 * �Ұ���Ͽ���ѹ�
 *
 * 1.0.0 (2006/08/31) ��������
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/31)
 *
 */

$page_title = "�Ұ���Ͽ���ѹ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();


/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];


/****************************/
//������
/****************************/
//�Ұ�����ɽ��������ץȥѥ�
$path_shain = HEAD_DIR."system/1-1-301-3.php?shop_id=".$shop_id;

//�����̡ʼ��ҥץ�ե�������̡�
$page_name = "1-1-301.php";


/****************************/
//�������
/****************************/
//����...�ʥ��åץ��ɡ˥ܥ���
$form->addElement("file", "file_shain", "�Ұ�", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");

$form->addElement("submit","form_entry","�С�Ͽ","onClick=\"javascript:return dialogue5('�Ұ�����Ͽ���ޤ���');\"");
$form->addElement("button","form_cancel","����󥻥�","onClick=\"location.href('$page_name')\"");


/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry"] != null){

    /****************************/
    //���顼�����å�
    /****************************/
    /*** �Ұ� ***/
    $form->addRule("file_shain", "�����ʲ����ե�����Ǥ���", "mimetype", array("image/jpeg", "image/jpeg", "image/pjpeg"));

    if($form->validate()){

        //���åץ��ɤ򸡾�
        if(is_uploaded_file($_FILES['file_shain']['tmp_name'])){
            $up_file = COMPANY_SEAL_DIR.$shop_id.".jpg";
            //���åץ���
            $chk_up_flg = move_uploaded_file($_FILES['file_shain']['tmp_name'], $up_file);
            header("Location: $page_name");
        }
    }
}

/*
print_array($_FILES);
print_array($_POST);
*/

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();


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
    'path_shain'    => "$path_shain",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
