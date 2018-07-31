<?php

/*
 * 履歴：
 *  日付        担当者      内容
 *-----------------------------------------------
 *  2007-10-05  aizawa-m    新規作成
 *
 * @file       122.php
 *  
 * 適用範囲：   仕入先別仕入推移( 1-6-122.php, 2-6-122.php ) 
 *              
 */

//※※※※※※※※※※※※※※※※※※※※※//
//  modelでのENV_local.php読込はいらない
//※※※※※※※※※※※※※※※※※※※※※//

/****************************/
// 基本設定
/****************************/

//※※※※※※※※※※※※※※※※※※※//
//  本部とFCで画面名が違う場合がある
//※※※※※※※※※※※※※※※※※※※//
//画面名
$page_title = "仕入先別仕入推移";

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();


/****************************/
// 権限のチェック
/****************************/
$auth       = Auth_Check($db_con);
//入力・変更の権限なしのメッセージ
$auth_r_msg = ($auth[0] == "r" ) ? $auth[3] : null;
//ボタンのDisabled
$disabled   = ($auth[0] == "r" ) ? "disabled" : null;


/****************************/
// 外部変数の取得
/****************************/
//セッションから値を取得
$shop_id    = $_SESSION["client_id"];   //ショップID
$group_kind = $_SESSION["group_kind"];  //グループ種別


/****************************/
// フォームパーツ定義
/****************************/
//※※※※※※※※※※※※※※※※※※※//
// フォーム作成関数を使用する 
//※※※※※※※※※※※※※※※※※※※//
//フォーム作成の関数
Mk_Form( $db_con, $form );

//本部の場合
if ( $group_kind == "1" ) {

    //csvタイトル
    $csv_head[] = "FC・取引先コード";
    $csv_head[] = "FC・取引先名";
    $csv_head[] = "FC・取引先区分コード";
    $csv_head[] = "FC・取引先区分名";

} else {

    //FC用の仕入先オブジェクトの作成
    $obj    = null;
    $obj[]  = $form->createElement("text", "cd1", "", "size=\"7\" maxlength=\"6\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\" class=\"ime_disabled\"");
    $obj[]  =& $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\"");
    $form->addGroup($obj, "form_client");

    //csvタイトル
    $csv_head[] = "仕入先コード";
    $csv_head[] = "仕入先名";
} 

/***************************/
// 表示ボタン押下
/***************************/
$out_flg  = false;
if ( $_POST["form_display"] == "表　示" ) {
    //日付のエラーチェック関数
    Err_Chk_Date_YM( $form , "form_trade_ym_s" ); 

    //**********************/
    // エラーなし
    //**********************/
    if ($form->validate()) {

        //クエリ実行関数( DBコネクション , 区分 , $_POST )
        $result     = Select_Each_Customer_Amount( $db_con , "buy" , $_POST );
        //データ整形関数( $result , 集計期間 , 表示対象 )
        $disp_data  = Edit_Query_Data( $result, $_POST);
        //表のヘッダを取得
        $disp_head  = Get_Header_YM($_POST["form_trade_ym_s"]["y"],
                                    $_POST["form_trade_ym_s"]["m"],
                                    $_POST["form_trade_ym_e"]);
        //出力フラグをtrueにする
        $out_flg  = true;

        
        /*********************/
        // CSV出力
        /*********************/
        if ($_POST["form_output_type"] == "2") {
            
            $csvobj = new Analysis_Csv_Class(false,false,false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            //CSV項目名作成
            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data);

            //CSV出力
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
            print $csvobj->res_csv;
            exit;
        }
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
//※※※※※※※※※※※※※※※※※※※//
//  本部の場合の処理を記述する
//※※※※※※※※※※※※※※※※※※※//
// 本部の場合
if ( $group_kind == "1" ) {
    $page_menu = Create_Menu_h("analysis","1");
}


/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


/***************************/
// Smarty出力処理
/***************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form",$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
    'group_kind'    => "$group_kind" ,  //仕入先コードの出力判定用に使う    
));

//表示データをassign
$smarty->assign("disp_head", $disp_head);   //ヘッダー
$smarty->assign("disp_data", $disp_data);   //一覧データ
$smarty->assign("disp_foot", $disp_foot);   //フッダー
$smarty->assign("out_flg",   $out_flg);     //出力フラグ

//※※※※※※※※※※※※※※※※※※※//
// テンプレート名は固定で指定する
//※※※※※※※※※※※※※※※※※※※//
$smarty->display(basename("122.php.tpl"));

?>
