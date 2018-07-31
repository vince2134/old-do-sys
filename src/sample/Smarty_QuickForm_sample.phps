<?php
//Smarty+QuickForm
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

$smarty = new Smarty();                // Smartyオブジェクトを生成
$smarty->template_dir = "templates";   // テンプレートDIRの指定
$smarty->compile_dir  = "templates_c"; // キャッシュDIRの指定


//HTML_QuickFormオブジェクト作成
$form =& new HTML_QuickForm( "test_form","POST");

//ニックネーム
$form->addElement("text","nick_name","ニックネーム：",'size="40"');

//サンプルデータを作成
$money = array(100, 240, 390, 410, 40);
$name = array("織田","豊臣","徳川","武田","上杉");
$age  = array("29","49","42","38","15");
for($i = 0; $i < 5; $i++){
    $row[] = array($name[$i], $age[$i], $money[$i]);
}


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//変数をassign
$smarty->assign("data",$row);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
