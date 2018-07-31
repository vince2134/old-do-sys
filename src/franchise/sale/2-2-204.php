<?php
/********************
 * 予定売上伝票発行
 *
 *
 * 変更履歴
 *    2006/09/11 (kaji)
 *      ・確定済の伝票の明細画面をそれぞれの変更画面のfreeze画面に変更
 *    2006/09/20 (kaji)
 *      ・画面名称変更（売上伝票一括発行→予定売上伝票発行）
 *    2006/10/10 (suzuki)
 *      ・０件を表示し、再度検索するとエラーになるのを修正
 *    2006/10/26 (suzuki)
 *      ・売上率が0%の担当者も表示するように変更
 *      ・巡回担当者（メイン）のみ表示
 *    2006-10-30 ・伝票パターンが設定されていない場合は発行済にしない<suzuki>
 *    2006-11-01 ・日付チェックの変数名が誤っていた為修正<suzuki>
 *    2006-11-02 ・カレンダー表示期間分表示<suzuki>
 *    2006-12-06 ・伝票形式に「全て」を追加<suzuki>
 *
 ********************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/10      02-058      suzuki      担当者コードに半角数字チェックを追加
 *  2006/12/07      bun_0060　　suzuki　　　日付をゼロ埋め
 *  2007/02/22      xx-xxx      kajioka-h   CSV出力機能を削除
 *  2007/03/01      xx-xxx      watanabe-k  ボタン名と画面名を変更
 *  2007/03/14      xx-xxx      watanabe-k  再発行処理を追加 
 *  2007/03/22      xx-xxx      watanabe-k  削除伝票を表示しない、ヘッダのボタン表示 
 *  2007/03/26      xx-xxx      watanabe-k  巡回担当者順にソートするように変更 
 *  2007/04/12      xx-xxx      morita-d    検索項目を他の画面と統一 
 *  2007/04/12      xx-xxx      morita-d    検索条件復元処理を追加 
 *  2007/04/12      xx-xxx      morita-d    抽出対象を「受注テーブル」のみとし「売上テーブル」は抽出対象としない 
 *  2007/04/13      xx-xxx      morita-d    代行先を表示するように変更
 *  2007/04/17      xx-xxx      morita-d    検索結果の奇数行を白、偶数行を緑と表示するように変更
 *  2007/05/22      xx-xxx      watanabe-k  ボタン名を代行集計表⇒代行期間集計表
 *  2007-06-20                  fukuda      ソートリンクつけた。
 *  2007-06-20                  fukuda      ページ数切り替え関数が検索テーブルと同じ幅で出ている不具合修正
 *  2007-06-20                  fukuda      遅い変数を７倍速くした
 *  2007-07-20                  watanabe-k  伝票発行形式はマスタを参照するように修正

 */
$page_title = "予定伝票発行";
$s_time = microtime();

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
require_once(INCLUDE_DIR."function_keiyaku.inc");
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));  // 現モジュール内のみで使用する関数ファイル

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth      = Auth_Check($db_con);


/****************************/
//検索条件復元
/****************************/
//検索フォーム初期値配列
$ary_form_list = array(	
    "form_display_num"  => "1", 	
    "form_client_branch"=> "",  	
    "form_attach_branch"=> "",  	
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""), 	
    "form_round_staff"  => array("cd" => "", "select" => ""), 	
    "form_part"         => "",  	
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""), 	
    "form_multi_staff"  => "",  	
    "form_ware"         => "",  	
    "form_round_day"    => array(	
        "sy" => date("Y"),	
        "sm" => date("m"),	
        "sd" => "01",	
        "ey" => date("Y"),	
        "em" => date("m"),	
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))),	
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_claim_day"    => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 	

    "slip_out"          => "0",
    "slip_flg"          => "0",
    "ord_no"            => "",
    "contract_div"      => "0",
);

// 検索条件復元
Restore_Filter($form, "form_show_button", $ary_form_list);


//************************************************
// 外部変数取得
//************************************************
$shop_id            = $_SESSION["client_id"];

$where              = $_POST;
$display_num        = $_POST["form_display_num"];
$f_page1            = $_POST["f_page1"];
$form_re_slip_check = $_POST["form_re_slip_check"];
$form_slip_check    = $_POST["form_slip_check"];


//************************************************
// フォーム定義
//************************************************
// 画面ヘッダの切替ボタン
$form->addElement("button", "2-2-113_button", "集計日報",       "onClick=\"location.href='2-2-113.php'\"");
$form->addElement("button", "2-2-116_button", "代行期間集計表", "onClick=\"location.href='2-2-116.php'\"");
$form->addElement("button", "2-2-204_button", "予定伝票発行",   $g_button_color."onClick=\"location.href='2-2-204.php'\"");
$form->addElement("button", "2-2-111_button", "商品予定出荷",   "onClick=\"location.href='2-2-111.php'\"");

// 標準検索フォーム
Search_Form($db_con, $form, $ary_form_list);

// 伝票形式
$text = null;
$text[] =& $form->createElement("radio", null, null, "全て",     "0");
$text[] =& $form->createElement("radio", null, null, "通常伝票", "1");
$text[] =& $form->createElement("radio", null, null, "指定伝票", "2");
$text[] =& $form->createElement("radio", null, null, "他票", "3");
$form->addGroup($text,"slip_out", "伝票形式");

// 発行状況
$text = null;
$text[] =& $form->createElement("radio", null, null, "全て",   "0");
$text[] =& $form->createElement("radio", null, null, "発行済", "t");
$text[] =& $form->createElement("radio", null, null, "未発行", "f");
$form->addGroup($text,"slip_flg", "発行状況");

// 伝票番号
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option class=\"num\"");
$text[] =& $form->createElement("text", "e", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option class=\"num\"");
$form->addGroup($text, "ord_no", "伝票番号", "　〜　");

// 契約区分
$text = null;
$text[] =& $form->createElement("radio", null, null, "全て",           "0");
$text[] =& $form->createElement("radio", null, null, "通常",           "1");
$text[] =& $form->createElement("radio", null, null, "オンライン代行", "2");
// 直営の場合
if ($_SESSION["group_kind"] == "2"){
	$text[] =& $form->createElement("radio", null, null, "オフライン代行", "3");
}
$form->addGroup($text,"contract_div", "契約区分");

// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_slip"           => "伝票番号",
    "sl_round_day"      => "予定巡回日",
    "sl_act_client_cd"  => "代行先コード",
    "sl_act_client_name"=> "代行先名",
    "sl_staff"          => "巡回担当者<br>（メイン1）",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_staff");

// 表示ボタン
$form->addElement("submit","form_show_button", "表　示");

// クリアボタン
$form->addElement("button","form_clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// 売上伝票発行ALL
$form->addElement("checkbox", "form_slip_all_check", "", "売上伝票発行", "onClick=\"javascript:All_Check_Slip('form_slip_all_check');\"");

// 再発行ALL
$form->addElement("checkbox", "form_re_slip_all_check", "", "再発行", "onClick=\"javascript:All_Check_Re_Slip('form_re_slip_all_check');\"");

// hidden
$form->addElement("hidden","src_module","予定伝票発行");    // 売上伝票（PDF）で遷移元を知るために定義
$form->addElement("hidden","hdn_button");                   // ?


//************************************************
// 処理内容判別
//************************************************
// 表示ボタンが押された、またはページ切替リンクが押された、またはソートリンクが押された場合
if ($_POST["form_show_button"] == "表　示" || $_POST["switch_page_flg"] == "t" || $_POST["hdn_sort_col"]){
	$action = "表示";

}elseif ($_POST["form_sale_slip"] == "売上伝票発行"){
	$action = "発行";

}elseif ($_POST["form_re_sale_slip"] == "再　発　行"){
	$action = "再発行";

}else{
	$action = "初期表示";
}


/***************************/
// 伝票発行ボタンが押された場合
/***************************/
if ($action == "表示"){
	// エラーチェック
	Search_Err_Chk($form);

}elseif ($action == "発行" || $action == "再発行"){

	// チェックがついてない場合
	if($_POST["hdn_button"] == "error"){
		$err_msg = "発行する伝票が一つも選択されていません。";
		//$form->setElementError(form_sale_slip, $err_msg);
	}

}


//************************************************
// HTML出力
//************************************************
$search_html = Search_Table($form);

// 初期表示以外は検索結果を取得
if($action != "初期表示"){

	// チェック適用
	$form->validate();
	$err_flg = (count($form->_errors) > 0) ? true : false;

	// エラーが無い場合
	if(!$err_flg){

		// 全件数
		$total_count = Get_Slip_Data($db_con, $where, $page_snum, $page_enum, $kind="count");
	
		// 表示件数が全件の場合
		if ($display_num == "1") {
		    $range = $total_count;
		} else {
		    $range = 100;
		}
		
		// 現在のページ数をチェックする
		$page_info = Check_Page($total_count, $range, $f_page1);
		$page      = $page_info[0];     // 現在のページ数
		$page_snum = $page_info[1];     // 表示開始件数
		$page_enum = $page_info[2];     // 表示終了件数
		
		// ページプルダウン表示判定
		if($page == 1){
		    // ページ数が１ならページプルダウンを非表示
		    $c_page = null;
		}else{
		    // ページ数分プルダウンに表示
		    $c_page = $page;
		}
	
		// ページ作成
		$html_page  = Html_Page2($total_count, $c_page, 1, $range);
		$html_page2 = Html_Page2($total_count, $c_page, 2, $range);

		// データ取得
		$search_data = Get_Slip_Data($db_con, $where, $page_snum, $page_enum);
	
		// 表示データ件数
		$match_count = count($search_data);
		$msg = "売上伝票を発行します。";
		$form->addElement("submit","form_sale_slip", "売上伝票発行", "
            onClick=\"javascript:document.dateForm.hdn_button.value = '発行';
		    return(Post_Blank('$msg','".$_SERVER["PHP_SELF"]."','".FC_DIR."sale/2-2-205.php','__form_slip_check',$match_count))\"
        ");
		
		$form->addElement("submit","form_re_sale_slip", "再　発　行", "
            onClick=\"javascript:document.dateForm.hdn_button.value = '再発行';
		    return(Post_Blank('$msg','".$_SERVER["PHP_SELF"]."','".FC_DIR."sale/2-2-205.php','__form_re_slip_check',$match_count))\"
        ");

	}

}

// 検索結果を出力用に変換
$html_search_data   = HTML_Slip_Data($search_data,$form);
$result_html        = $html_search_data["html"];
$result_js          = $html_search_data["js"];


/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-113_button"]]->toHtml();
if($_SESSION["group_kind"] == "2"){
    $page_title .= "　".$form->_elements[$form->_elementIndex["2-2-116_button"]]->toHtml();
}
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();
$page_header = Create_Header($page_title);


//****************************
// テンプレート処理
//****************************
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// 検索結果
$smarty->assign("result_html", $result_html);
$smarty->assign("result_js",   $result_js);

// その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
	"html_page"     => "$html_page",
	"html_page2"    => "$html_page2",
	"display_num"   => "$display_num",
	"display_num2"  => "$display_num2",
	"auth_r_msg"    => "$auth_r_msg",
	"search_html"   => "$search_html",
	"action"        => "$action",
	"err_msg"       => "$err_msg",
));

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";
print_array($_POST);
print_array($_SESSION);
*/

?>
