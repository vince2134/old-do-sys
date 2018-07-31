<?php

/*
 * 履歴：
 *  日付        担当者      内容
 *-----------------------------------------------
 *  2007-10-05  aizawa-m    新規作成
 *
 * @file        103.php
 *  
 * 適用範囲：   FC先別売上推移( 1-6-103.php )
 *              得意先別売上推移( 2-6-103.php ) 
 *              
 */


/***************************/
// 外部変数取得
/***************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

//グループ種別が本部の場合
if ( $group_kind == "1" ) {
    //ページタイトル
    $page_title = "FC別売上推移";

    //csvタイトル
    $csv_head[]= "FC・取引先コード";
    $csv_head[]= "FC・取引先名";
    $csv_head[]= "FC・取引先区分コード";
    $csv_head[]= "FC・取引先区分名";

} else {
    //ページタイトル
    $page_title = "得意先別売上推移";

    //csvタイトル
    $csv_head[]= "得意先コード";
    $csv_head[]= "得意先名";
}


/***************************/
// 基本設定
/***************************/
//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();


/***************************/
// 権限のチェック
/***************************/
// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// フォームパーツ定義
/****************************/
// フォーム作成関数 
Mk_Form($db_con, $form);


/***************************/
// 表示ボタン押下
/***************************/
$out_flg    = false; //一覧出力フラグ
$rate_flg   = false; //粗利率出力フラグ

if ($_POST["form_display"] == "表　示"){
    //日付のエラーチェック関数
    Err_Chk_Date_YM( $form , "form_trade_ym_s" );

    /**********************/
    // エラー無し
    /**********************/
    if ($form->validate()) {
        
        $period = $_POST["form_trade_ym_e"];
        
        //クエリ実行関数
        $result     = Select_Each_Customer_Amount( $db_con , "sale" , $_POST );
        //表のヘッダを出力
        $disp_head  = Get_Header_YM($_POST["form_trade_ym_s"]["y"],
                                    $_POST["form_trade_ym_s"]["m"],
                                    $_POST["form_trade_ym_e"]);
        //データの編集関数
        $disp_data  = Edit_Query_Data ($result, $_POST);
 

        //粗利率が「表示」の場合
        if ( $_POST["form_margin"] == "1" ) {
                $rate_flg = true;
        }
        //出力フラグをtrueにする
        $out_flg    = true;
 
        /********************************/       
        // 出力形式が「CSV」の場合
        /********************************/
        if ( $_POST["form_output_type"] == "2" ) {

            $csvobj = new Analysis_Csv_Class($rate_flg,false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            //CSV項目名作成
            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data);
       
            //CSV出力 
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type: application/octet-stream; name=".$csvobj->filename);
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
if ( $group_kind == "1" ) {
    $page_menu = Create_Menu_f('analysis','1');
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
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'group_kind'    => "$group_kind",
));

//表示データをassign
$smarty->assign("disp_head", $disp_head);   //ヘッダー
$smarty->assign("disp_data", $disp_data);   //一覧データ
$smarty->assign("disp_foot", $disp_foot);   //フッダー
$smarty->assign("out_flg"  , $out_flg);     //出力フラグ
$smarty->assign("rate_flg" , $rate_flg);    //粗利率フラグ

//テンプレートへ値を渡す
$smarty->display(basename("103.php.tpl"));
//print_array($disp_data);

//下記の関数はanalysis.fncに移動しました<watanabe-k>
/**
 * CSV形式のデータを作成
 *
 * 配列の要素ごとにカンマを挿入する。
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 * 1.0.1 (2006/02/01) 編集（ふくだ）
 * 1.0.2 (2006/02/18) 修正（鈴木）
 * 1.0.3 (2006/10/17) str_replace → mb_ereg_replace（かじ）
 * 1.0.4 (2006/12/07) SJISへ文字コード変換を最後にした（かじ）
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.4 (2006/12/07)
 *
 * @param               array           $row        CSV化するレコードのリスト
 * @param               string          $header     CSVファイルの1行目に追加するヘッダ
 *
 * @return              array
 *
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      12-004      kajioka-h   mb_ereg_replaceをstr_replaceに戻した
 *                  12-018      kajioka-h   同上
 */
//function Make_Csv($row ,$header,$sub_header=NULL){

/**************鈴木修正*******************************/
    //レコードが無い場合は、CSVデータにNULLを表示させる
    //$row = (count($row) == 0) ? "" : $row;
//    if(count($row)==0){
//        $row[] = array("","");
//    }
/****************************************************/
/*
    // 配列にヘッダ行を追加
    $count = array_unshift($row, $header);

    if ($sub_header !== NULL ) {
    } 

        
    //置換する文字
    $trans = array("\n" => "　", "\r" => "　");


    // 整形
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){


            //改行コードを全角スペースで置換
            $row[$i][$j] = strtr($row[$i][$j], $trans);

            // エンコーディング
            //$row[$i][$j] = mb_convert_encoding($row[$i][$j], "SJIS", "EUC-JP");
            // "→""
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            //$row[$i][$j] = mb_ereg_replace("\"", "\"\"", $row[$i][$j]);
            // ""で囲む
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }
        // 配列をカンマ区切りで結合
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // エンコーディング
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}
*/

?>
