<?php
// �ѹ����ʤ��ǲ�����

// �ѥ������
define(PATH , "../../../");
define(MODEL_PATH , "../model/");
define(FNC_PATH , "../function/");

// �ؿ��ե�������ɹ���
require_once(FNC_PATH ."INCLUDE.php");
//require_once(PATH ."function/INCLUDE.php");

//���å����Υ����å�
Session_Check_h();

require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once("HTML/QuickForm/Renderer/ArraySmarty.php");

$smarty = new Smarty();
$smarty->template_dir = "../templates";
$smarty->compile_dir = "../templates_c";
//����Υƥ�ץ졼�ȴؿ�������ǥ��쥯�ȥ���ɹ���
$smarty->plugins_dir = array("plugins",FNC_PATH."plugins");

?>
