<?php

/*
 * 履歴：
 *
 *  日付        担当者          内容
 *-----------------------------------------------
 *  2007-11-23  fukuda          新規作成
 *
 */

//-----------------------------------------------
// 初期設定
//-----------------------------------------------
// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB接続
$db_con = Db_Connect();

// ショップID
$shop_id    = $_SESSION["client_id"];

// フォームオブジェクト定義
Mk_Form($db_con, $form);


//-----------------------------------------------
// 表示ボタン押下時処理
//-----------------------------------------------
// 表示ボタンのPOSTデータがある場合
if ($_POST["form_display"] != null) {

    // POSTフラグ
    $post_flg = true;

    // POSTデータ取得
    $post = $form->exportValues();

    // エラーチェック処理
    Err_Chk_Date_YM($form);

    // エラーチェック適用
    $form->validate();

    // エラーチェック結果
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


//-----------------------------------------------
// データ抽出処理
//-----------------------------------------------
// POSTフラグがtrue＋エラーチェック結果がtrueでない場合
if ($post_flg === true && $err_flg !== true) {

    // クエリ作成
    if ($shop_id === "1") {
        // 本部機能クエリ
        $res = Select_Staff_Abc_Amount_h($db_con, $post, $shop_id);
    } else {

        #hashimoto-y 2007-12-02
        #require_once("../function/analysis_query_ABC_hashi.fnc");
        #$res = Select_Staff_Abc_Amount_f_hashi($db_con, $post, $shop_id);

        // FC機能クエリ
        $res = Select_Staff_Abc_Amount_f($db_con, $post, $shop_id);

    }

    // ABCクラスのインスタンス生成
    $abcObj = new Analysis_ABC();

    // クエリデータ抽出
    $abcObj->Result_Change_Array($res);

    // ABC表示用データ作成
    $abcObj->Set_Abc_Data();

    // 出力フラグ
    $out_flg = true;

}


//-----------------------------------------------
// CSV出力処理
//-----------------------------------------------
// CSV出力が選択されている＋errフラグがfalseの場合
if ($post["form_output_type"] === "2" && $err_flg === false) {

    $csvobj = new Abc_Csv_Class();
    $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

    // CSV項目名作成
    $csv_head = array("担当者コード", "スタッフ名");

    $csvobj->Make_Csv_Head($csv_head);
    $csvobj->Make_Csv_Data($abcObj->disp_data, $csv_head);

    // CSV出力して終了
    Header("Content-disposition: attachment; filename=".$csvobj->filename);
    Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
    print $csvobj->res_csv;
    exit;

}


//-----------------------------------------------
// HTMLテンプレート用データ
//-----------------------------------------------
// HTMLヘッダ
$html_header = Html_Header($page_title);

// HTMLフッタ
$html_footer = Html_Footer();

// 画面ヘッダー作成
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// データをassign
$smarty->assign("disp_data", $abcObj->disp_data);
$smarty->assign("out_flg",   $out_flg);

// その他のデータをassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
));

// テンプレートへ値を渡す
$smarty->display("114.php.tpl");

