<?php
/*
 * 履歴：
 *  日付        担当者          内容
 *-----------------------------------------------
 *  2007-11-23  aizawa-m      新規作成
 *
 *  @model  113.php ( 業種別ABC分析 ）
 *
 */

/**************************/
// 基本設定
/*************************/
// ページタイトル
$page_title = "業種別ABC分析";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB接続
$db_con = Db_Connect();

// セッションから取得
$group_kind = $_SESSION["group_kind"];

// CSV項目名作成
$csv_head = array(  "業種コード",
                    "業種名",
                );

/*******************************/
// フォームオブジェクト作成
/*******************************/
// フォームの作成
Mk_Form($db_con, $form);

// エラーメッセージ作成
Err_Chk_Date_YM($form, "form_trade_ym_s");


/**************************/
// POST情報取得
/**************************/
$form_data = $form->exportValues();


/**************************/
// 表示ボタン押下
/**************************/
if ( $form_data["form_display"] == "表　示" AND $form->validate()) {

    // 表示ボタン押下フラグ
    $disp_flg   = true;

    // クエリ作成
    $result     = Select_Customer_Type_Abc_Amount($db_con, $form_data,"type");
    // ABCクラスのインスタンス生成
    $abcObj     = new Analysis_ABC();
    // クエリデータ抽出
    $abcObj->Result_Change_Array($result);
    // ABC表示用データ作成
    $abcObj->Set_Abc_Data();

    /*************************/
    // CSV出力処理
    /*************************/
    if ($form_data["form_output_type"] == "2") {
        $csvobj = new ABC_Csv_Class();
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        // CSV項目名作成
        $csvobj->Make_Csv_Head($csv_head);
        $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

        // CSV出力
        Header("Content-disposition: attachment; filename=".$csvobj->filename);
        Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
        print $csvobj->res_csv;
        exit;
    }
}

/*************************/
// HTMLヘッダ
/*************************/
$html_header = Html_Header($page_title);


/*************************/
// HTMLフッダ
/*************************/
$html_footer = Html_Footer();


/*************************/
// メニュー作成
/*************************/
$page_menu = Create_Menu_h("analysis","1");


/*************************/
// 画面ヘッダー作成
/*************************/
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
            'disp_flg'      => "$disp_flg",
            'group_kind'    => "$group_kind",
));
//オブジェクトをassign
$smarty->assign("disp_data", $abcObj->disp_data);

//テンプレートへ値を渡す
$smarty->display("113.php.tpl");

?>
