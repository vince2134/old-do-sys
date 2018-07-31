<?php
// 変更しないで下さい

// パスの定義
define(PATH , "../../../");
define(MODEL_PATH , "../model/");
define(FNC_PATH , "../function/");

// 関数ファイルの読込み
require_once(FNC_PATH ."INCLUDE.php");
//require_once(PATH ."function/INCLUDE.php");

//セッションのチェック
Session_Check_h();

require_once("Smarty/Smarty.class.php");
require_once("HTML/QuickForm.php");
require_once("HTML/QuickForm/Renderer/ArraySmarty.php");

$smarty = new Smarty();
$smarty->template_dir = "../templates";
$smarty->compile_dir = "../templates_c";
//自作のテンプレート関数があるディレクトリを読込む
$smarty->plugins_dir = array("plugins",FNC_PATH."plugins");

?>
