<?php
//Smarty+QuickForm
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

$smarty = new Smarty();                // Smarty���֥������Ȥ�����
$smarty->template_dir = "templates";   // �ƥ�ץ졼��DIR�λ���
$smarty->compile_dir  = "templates_c"; // ����å���DIR�λ���


//HTML_QuickForm���֥������Ⱥ���
$form =& new HTML_QuickForm( "test_form","POST");

//�˥å��͡���
$form->addElement("text","nick_name","�˥å��͡��ࡧ",'size="40"');

//����ץ�ǡ��������
$money = array(100, 240, 390, 410, 40);
$name = array("����","˭��","����","����","���");
$age  = array("29","49","42","38","15");
for($i = 0; $i < 5; $i++){
    $row[] = array($name[$i], $age[$i], $money[$i]);
}


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//�ѿ���assign
$smarty->assign("data",$row);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
