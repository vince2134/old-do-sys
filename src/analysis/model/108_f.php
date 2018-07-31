<?php
/**
 *
 * 担当者別商品別売上推移（FC）（model）
 *
 *
 * @author          かじ <kajioka-h@bhsk.co.jp>
 * @version
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/10/27                  kajioka-h   新規作成
 *  2007/12/01                  kajioka-h   デバッグモード追加
 *
 */

$debug_mode = false;

if($debug_mode){
    $start = microtime();
}

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続
$db_con = Db_Connect();


// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


//--------------------------//
// 外部変数取得
//--------------------------//
$shop_id = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];



//--------------------------//
// フォームパーツ定義
//--------------------------//
// 共通オブジェクト生成
Mk_Form($db_con, $form);

//個別フォーム生成
//所属本支店
$select_branch = Select_Get($db_con, "branch");
$form->addElement("select", "form_branch", "", $select_branch, $g_form_option_select);

//部署
$select_part = Select_Get($db_con, "part");
$form->addElement("select", "form_part", "", $select_part, $g_form_option_select);


/*
//初期値設定
$def_fdata = array(
    "f_r_output2"   => "1",
);

$form->setDefaults($def_fdata);
*/


//--------------------------//
// 集計
//--------------------------//
if($_POST["form_display"] == "表　示"){

    //日付のエラーチェック
    Err_Chk_Date_YM($form, "form_trade_ym_s");

    $form->validate();
    $error_flg = (count($form->_errors) > 0) ? true : false;


    //エラーがない場合
    if($error_flg == false){

        //一覧出力フラグ
        $out_flg = "true";

        //POST取得
        $form_data = $form->exportValues();
//print_array($form_data);

        //一覧テーブルのヘッダ（年月）を生成
        $disp_head = Get_Header_YM($form_data["form_trade_ym_s"]["y"], $form_data["form_trade_ym_s"]["m"], $form_data["form_trade_ym_e"]);

        //クエリ実行
//require_once("../function/analysis_query_kaji.fnc");

//require_once("../function/analysis_query_hashi_best.fnc");
//require_once("../function/analysis_query_hashi_better.fnc");

        $result = Select_Each_Staff_Goods_Amount_f($db_con, $form_data);
        //$result = Select_Each_Staff_Goods_Amount_f2($db_con, $form_data);

        //月合計、月平均、小計、合計など
        $disp_data = Edit_Query_Data_Hogepiyo($result, $form_data);
//print_array($disp_data);


        //CSV出力
        if($form_data["form_output_type"] == "2"){

            //粗利表示フラグ
            $margin_flg = ($form_data["form_margin"] == 1) ? true : false;

            $csvobj = new Analysis_Csv_Class($margin_flg, false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            //CSV項目名作成
            $csv_head = array("担当者コード", "スタッフ名", "商品コード", "商品名");

            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data);

            //csv出力
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type: application/octet-stream; name=".$csvobj->file_name);
            print $csvobj->res_csv;
            exit;

        }

    }//エラーがない場合おわり

}//表示ボタン押下処理おわり



//--------------------------//
//HTMLヘッダ
//--------------------------//
$html_header = Html_Header($page_title);

//--------------------------//
//HTMLフッタ
//--------------------------//
$html_footer = Html_Footer();

//--------------------------//
//画面ヘッダー作成
//--------------------------//
$page_header = Create_Header($page_title);


//--------------------------//
//ページ作成
//--------------------------//

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);



// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//表示データをassign
$smarty->assign("disp_head", $disp_head);   //一覧テーブルのヘッダ
$smarty->assign("disp_data", $disp_data);   //一覧テーブルのデータ
$smarty->assign("disp_foot", $disp_foot);   //フッダー
$smarty->assign("out_flg"  , $out_flg);     //出力フラグ
$smarty->assign("rate_flg" , $rate_flg);    //粗利率フラグ


//テンプレートへ値を渡す
//$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));
$smarty->display(basename("108.php.tpl"));


if($debug_mode){
    $end = microtime();

    echo Cnt_Microtime($end) - Cnt_Microtime($start);
}


?>
