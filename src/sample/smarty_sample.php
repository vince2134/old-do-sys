<?php
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

$money = array(100, 240, 390, 410, 40);
$name = array("����","˭��","����","����","���");
$age  = array("29","49","42","38","15");

//�ڡ�����ɽ������ǡ��������
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
