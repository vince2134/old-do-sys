<?php
//変更はこのディレクトリ内のファイルに影響します

// パスの定義
define(PATH , "../../../");

// 関数ファイルの読込み
require_once(PATH ."function/INCLUDE.php");

// Smarty+QuickForm
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

$smarty = new Smarty();   // Smartyオブジェクトを生成
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";

?>
