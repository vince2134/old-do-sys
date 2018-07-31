<?php
// 変更しないで下さい

// パスの定義
define(PATH , "../../../");         //関数ファイルパス
define(MODEL_PATH , "../model/");   //modelのファイルパス
define(FNC_PATH , "../function/");   //functionのファイルパス

// 関数ファイルの読込み
require_once(FNC_PATH ."INCLUDE.php");
//require_once(PATH ."function/INCLUDE.php");

//セッションのチェック(FC)
Session_Check_fc();

//SmartyとQuickFormのライブラリを読込む
require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

//↓↓modelを使用する場合は不要なため、コメントにする↓↓
$smarty = new Smarty();   // Smartyオブジェクトを生成
$smarty->template_dir = "../templates";
$smarty->compile_dir = "../templates_c";
//自作のテンプレート関数があるディレクトリを読込む
$smarty->plugins_dir = array("plugins",FNC_PATH."plugins");

?>
