<?php
/**
 *
 * 社印登録・変更
 *
 * 1.0.0 (2006/08/31) 新規作成
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/31)
 *
 */

$page_title = "社印登録・変更";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();


/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];


/****************************/
//定数定義
/****************************/
//社印画像表示スクリプトパス
$path_shain = HEAD_DIR."system/1-1-301-3.php?shop_id=".$shop_id;

//元画面（自社プロフィール画面）
$page_name = "1-1-301.php";


/****************************/
//部品定義
/****************************/
//参照...（アップロード）ボタン
$form->addElement("file", "file_shain", "社印", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");

$form->addElement("submit","form_entry","登　録","onClick=\"javascript:return dialogue5('社印を登録します。');\"");
$form->addElement("button","form_cancel","キャンセル","onClick=\"location.href('$page_name')\"");


/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry"] != null){

    /****************************/
    //エラーチェック
    /****************************/
    /*** 社印 ***/
    $form->addRule("file_shain", "不正な画像ファイルです。", "mimetype", array("image/jpeg", "image/jpeg", "image/pjpeg"));

    if($form->validate()){

        //アップロードを検証
        if(is_uploaded_file($_FILES['file_shain']['tmp_name'])){
            $up_file = COMPANY_SEAL_DIR.$shop_id.".jpg";
            //アップロード
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
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();


/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());


//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'path_shain'    => "$path_shain",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
