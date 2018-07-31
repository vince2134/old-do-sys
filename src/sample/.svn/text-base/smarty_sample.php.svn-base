<?php
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

$money = array(100, 240, 390, 410, 40);
$name = array("織田","豊臣","徳川","武田","上杉");
$age  = array("29","49","42","38","15");

//ページに表示するデータを作成
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
