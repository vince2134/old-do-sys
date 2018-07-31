<?php
/*
 * 履歴：
 *  日付        担当者          内容
 *-----------------------------------------------
 *  2007-10-27  watanabe-k      新規作成
 *
 */
//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

/****************************/
//フォームオブジェクト作成
/****************************/
//HTMLパーツ作成
Mk_Form($db_con, $form);

//エラーメッセージ作成
Err_Chk_Date_YM ($form, "form_trade_ym_s");

/****************************/
//POST情報取得
/****************************/
$form_data = $form->exportValues();

/****************************/
//表示ボタン押下処理
/****************************/
//表示ボタンが押下された場合 & エラーなし
if($form_data["form_display"] == "表　示" && $form->validate()){

    //表示データ抽出
    $result = Select_Each_SG_Amount($db_con, "goods", $form_data);

    //表示データ集計
    $disp_data = Edit_Query_Data( $result, $form_data);

    //表のヘッダを取得
    $disp_head  = Get_Header_YM($form_data["form_trade_ym_s"]["y"],
                             $form_data["form_trade_ym_s"]["m"],
                             $form_data["form_trade_ym_e"]);
    //画面表示フラグ
    $disp_flg   = true;

    //粗利表示フラグ
    $margin_flg = ($form_data["form_margin"] == 1)? true : false;
    
    /****************************/
    //CSV出力処理
    /****************************/
    //出力形式がCSVの場合
    if($form_data["form_output_type"] == "2"){

        $csvobj = new Analysis_Csv_Class($margin_flg);
        $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

        //CSV項目名作成
        $csv_head = array("商品コード", "商品名");

        $csvobj->Make_Csv_Head($disp_head, $csv_head);
        $csvobj->Make_Csv_Data($disp_data);

        //csv出力
        Header("Content-disposition: attachment; filename=".$csvobj->filename);
        Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
        print $csvobj->res_csv;
        exit;
    }
}

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_f('analysis','1');

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
	'disp_flg'      => "$disp_flg",
	'margin_flg'    => "$margin_flg",
));

//表示データをassign
$smarty->assign("disp_head", $disp_head);
$smarty->assign("disp_data", $disp_data);

//テンプレートへ値を渡す
$smarty->display("101.php.tpl");

#print_array($_POST);

?>
