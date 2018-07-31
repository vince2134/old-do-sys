<?php

/*
 *  履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-04-23                  fukuda      2ページ目以降の結果が正しくない不具合の修正
 * 
 * 
 */

$page_title = "空きコード一覧";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "#");

// DBに接続
$db_con = Db_Connect();


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$display    = $_GET["display"];


/****************************/
// クリアボタン押下時処理
/****************************/
if ($_POST["hdn_clear_flg"] == "true"){

    // POSTをアンセット
    unset($_POST);

    // フォームをデフォルト状態に
    $def_set["form_range"]      = "1000";
    $def_set["hdn_range"]       = "1000";
    $def_set["form_method"]     = "1";
    $def_set["hdn_method"]      = "1";
    $def_set["hdn_clear_flg"]   = "";
    $form->setConstants($def_set);

}


/****************************/
// デフォルト値設定
/****************************/
// display
if($display != null){
	$set_id_data["hdn_display"] = $display;
	$form->setConstants($set_id_data);
}else{
	$display = $_POST["hdn_display"];
}

// 表示件数フォーム
$def_fdata = array(
    "form_range"    => "1000",
    "form_method"   => "1",
);
$form->setDefaults($def_fdata);

// オフセット
$offset     = 0;
// 表示ページ数
$page_count = 1;
// 検索方法
$method     = "1";


/****************************/
// 表示件数設定
/****************************/
// 表示ボタン押下時はPOSTされたフォーム値
if ($_POST["show_button"] != null){
    $range = $_POST["form_range"];
// 表示ボタン以外のPOST時はhiddenの値
}elseif ($_POST != null && $_POST["show_button"] == null){
    $range = $_POST["hdn_range"];
// POSTがない場合はデフォルト
}else{
    $range = 1000;
}


/****************************/
// フォームパーツ定義
/****************************/
// 表示件数
$ary_range_list = array("10" => "10", "50" => "50", "100" => "100", "500" => "500", "1000" => "1000", "5000" => "5000");
$form->addElement("select", "form_range", "", $ary_range_list, $g_form_option_select);

// 検索方法
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "上6桁検索", "1", "onClick=\"Select_Method();\"");
$radio[] =& $form->createElement("radio", null, null, "下4桁検索", "2", "onClick=\"Select_Method();\"");
$form->addGroup($radio, "form_method", "");

// 表示ボタン
$form->addElement("submit", "show_button", "表　示");

// クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:Button_Submit_1('hdn_clear_flg', '#', 'true')\"");

// デバッグ用ボタン
//$form->addElement("button", "clear_button",  "デバッグ用", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 閉じるボタン
$form->addElement("button", "close_button", "閉じる", "onClick=\"window.close()\"");

// hidden 値セット用
$form->addElement("hidden", "hdn_display");         // display
$form->addElement("hidden", "hdn_range");           // 表示件数
$form->addElement("hidden", "hdn_method");          // 検索方法
$form->addElement("hidden", "hdn_client_cd11_s");   // 上６桁検索用 得意先コード1（開始）
$form->addElement("hidden", "hdn_client_cd11_e");   // 上６桁検索用 得意先コード1（終了）
$form->addElement("hidden", "hdn_client_cd12");     // 下４桁検索用 得意先コード1
$form->addElement("hidden", "hdn_client_cd22_s");   // 下４桁検索用 得意先コード2（開始）
$form->addElement("hidden", "hdn_client_cd22_e");   // 下４桁検索用 得意先コード2（終了）
$form->addElement("hidden", "hdn_clear_flg");       // クリアボタン押下フラグ

// エラーセット用
$form->addElement("text", "err_client_cd1");        // 得意先コード1
$form->addElement("hidden", "err_no_msg");          // エラーメッセージを出力しないエラー用


/****************************/
// 表示ボタン押下時
/****************************/
if ($_POST["show_button"] == "表　示"){

    /****************************/
    // エラーチェック
    /****************************/
    // 上6桁検索の場合
    if ($_POST["form_method"] == "1"){

        // コード1（開始） 文字列チェック
        if ($_POST["form_client_cd11"]["s"] != null && !ereg("^[0-9]+$", $_POST["form_client_cd11"]["s"])){
            $form->setElementError("err_no_msg", null);
        }
        // コード1（終了） 文字列チェック
        if ($_POST["form_client_cd11"]["e"] != null && !ereg("^[0-9]+$", $_POST["form_client_cd11"]["e"])){
            $form->setElementError("err_no_msg", null);
        }
        // コード1（開始）＞コード1（終了）
        if (str_pad($_POST["form_client_cd11"]["s"], 6, "0", STR_PAD_RIGHT) >
            str_pad($_POST["form_client_cd11"]["e"], 6, "9", STR_PAD_RIGHT)
        ){
            $form->setElementError("err_no_msg", null);
        }

    // 下4桁検索の場合
    }else{

        $err_msg1 = "得意先コード上6桁 を入力して下さい。";

        // コード1 NULLチェック
        if ($_POST["form_client_cd12"] == null){
            $form->setElementError("err_client_cd1", $err_msg1);
    
        }
        // コード1 完全入力（6桁入力）チェック
        if (strlen($_POST["form_client_cd12"]) > 6){
            $form->setElementError("err_client_cd1", $err_msg1);
        }
        // コード1 文字列チェック
        if (!ereg("^[0-9]+$", $_POST["form_client_cd12"])){
            $form->setElementError("err_no_msg", null);
        }
        // コード2（開始） 文字列チェック
        if ($_POST["form_client_cd22"]["s"] != null && !ereg("^[0-9]+$", $_POST["form_client_cd22"]["s"])){
            $form->setElementError("err_no_msg", null);
        }
        // コード2（終了） 文字列チェック
        if ($_POST["form_client_cd22"]["e"] != null && !ereg("^[0-9]+$", $_POST["form_client_cd22"]["e"])){
            $form->setElementError("err_no_msg", null);
        }
        // コード2（開始）＞コード2（終了）
        if (str_pad($_POST["form_client_cd22"]["s"], 4, "0", STR_PAD_RIGHT) >
            str_pad($_POST["form_client_cd22"]["e"], 4, "9", STR_PAD_RIGHT)
        ){
            $form->setElementError("err_no_msg", null);
        }

    }

    // チェック結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    /****************************/
    // 変数・hiddenセット
    /****************************/
    // エラーなし時
    if ($err_flg != true){

        // POSTデータを変数へ代入
        $range                          = $_POST["form_range"];                     // 表示件数
        $method                         = $_POST["form_method"];                    // 検索方法
        $client_cd11_s                  = trim($_POST["form_client_cd11"]["s"]);    // 上６桁検索用 得意先コード1（開始）
        $client_cd11_e                  = trim($_POST["form_client_cd11"]["e"]);    // 上６桁検索用 得意先コード1（終了）
        $client_cd12                    = trim($_POST["form_client_cd12"]);         // 下４桁検索用 得意先コード1
        $client_cd22_s                  = trim($_POST["form_client_cd22"]["s"]);    // 下４桁検索用 得意先コード2（開始）
        $client_cd22_e                  = trim($_POST["form_client_cd22"]["e"]);    // 下４桁検索用 得意先コード2（終了）

        // POSTデータをhiddenへ代入
        $hdn_set["hdn_range"]           = $_POST["form_range"];                     // 表示件数
        $hdn_set["hdn_method"]          = $_POST["form_method"];                    // 検索方法
        $hdn_set["hdn_client_cd11_s"]   = trim($_POST["form_client_cd11"]["s"]);    // 上６桁検索用 得意先コード1（開始）
        $hdn_set["hdn_client_cd11_e"]   = trim($_POST["form_client_cd11"]["e"]);    // 上６桁検索用 得意先コード1（終了）
        $hdn_set["hdn_client_cd12"]     = trim($_POST["form_client_cd12"]);         // 下４桁検索用 得意先コード1
        $hdn_set["hdn_client_cd22_s"]   = trim($_POST["form_client_cd22"]["s"]);    // 下４桁検索用 得意先コード2（開始）
        $hdn_set["hdn_client_cd22_e"]   = trim($_POST["form_client_cd22"]["e"]);    // 下４桁検索用 得意先コード2（終了）
        $form->setConstants($hdn_set);

        // フラグとか
        $post_flg                       = true;

    }

}


/****************************/
//表示ボタン以外のPOST時
/****************************/
if ($_POST != null && $_POST["show_button"] != "表　示"){

    // hiddenデータを変数へ代入
    $range                              = $_POST["hdn_range"];                      // 表示件数
    $method                             = $_POST["hdn_method"];                     // 検索方法
    $client_cd11_s                      = $_POST["hdn_client_cd11_s"];              // 上６桁検索用 得意先コード1（開始）
    $client_cd11_e                      = $_POST["hdn_client_cd11_e"];              // 上６桁検索用 得意先コード1（終了）
    $client_cd12                        = $_POST["hdn_client_cd12"];                // 下４桁検索用 得意先コード1
    $client_cd22_s                      = $_POST["hdn_client_cd22_s"];              // 下４桁検索用 得意先コード2（開始）
    $client_cd22_e                      = $_POST["hdn_client_cd22_e"];              // 下４桁検索用 得意先コード2（終了）

    // hiddenデータをフォームへ復元
    $form_set["form_range"]             = $_POST["hdn_range"];                      // 表示件数
    $form_set["form_method"]            = $_POST["hdn_method"];                     // 検索方法
    $form->setConstants($form_set);

    // フラグとか
    $page_count                         = $_POST["f_page1"];
    $offset                             = $page_count * $range - $range;
    $post_flg                           = true;

}


/****************************/
// 検索条件作成
/****************************/
/*
if($post_flg == true){

    $where_sql  = null;

    // 上6桁検索時
    if ($method == "1"){

	    // 得意先コード1（開始）
        $where_sql .= ($client_cd11_s != null) ? "AND t_client.client_cd1 >= '".str_pad($client_cd11_s, 6, "0", STR_PAD_RIGHT)."' \n" : null;
	    // 得意先コード1（終了）
        $where_sql .= ($client_cd11_e != null) ? "AND t_client.client_cd1 <= '".str_pad($client_cd11_e, 6, "9", STR_PAD_RIGHT)."' \n" : null;

    // 下4桁検索時
    }else{

        // 得意先コード1
        $where_sql .= ($client_cd12   != null) ? "AND t_client.client_cd1  = '".$client_cd12."' \n" : null;
	    // 得意先コード2（開始）
        $where_sql .= ($client_cd22_s != null) ? "AND t_client.client_cd2 >= '".str_pad($client_cd22_s, 4, "0", STR_PAD_RIGHT)."' \n" : null;
	    // 得意先コード2（終了）
        $where_sql .= ($client_cd22_e != null) ? "AND t_client.client_cd2 <= '".str_pad($client_cd22_e, 4, "9", STR_PAD_RIGHT)."' \n" : null;

    }

}
*/

/****************************/
// 一覧データ取得・整形
/****************************/
if ($post_flg == true){

    /****************************/
    // ループの開始/終了値設定
    /****************************/
    $str_pad_cd11_s = str_pad($client_cd11_s, 6, "0", STR_PAD_RIGHT);
    $str_pad_cd11_e = str_pad($client_cd11_e, 6, "9", STR_PAD_RIGHT);
    $str_pad_cd22_s = str_pad($client_cd22_s, 4, "0", STR_PAD_RIGHT);
    $str_pad_cd22_e = str_pad($client_cd22_e, 4, "9", STR_PAD_RIGHT);

    // 上6桁検索時
    if ($method == "1"){
        // ループ開始値設定
        // 表示件数が全件の場合
        if ($range == null){
            $start  = $str_pad_cd11_s;                                      // 指定された開始コード
        }else{
            $start  = ($range * $page_count) - $range + $str_pad_cd11_s;    // (表示件数 * ページ数) - 表示件数 + 指定された開始コード
        }
        // ループ終了値設定
        // 表示件数が全件の場合
        if ($range == null){
            $stop   = $str_pad_cd11_e;                                      // 指定された終了コード
        }else{
            // 最終ページの場合
            if (($range * $page_count) + $str_pad_cd11_s > $str_pad_cd11_e){
                $stop   = $str_pad_cd11_e;                                  // 指定された終了コード
            }else{
                $stop   = ($range * $page_count) + $str_pad_cd11_s - 1;     // (表示件数 * ページ数) + 指定された開始コード - 1
            }
        }
        // 終了番号が9999を超える場合は指定された終了コードにする
        $stop = ($stop > 999999) ? $str_pad_cd11_e : $stop;
    // 下4桁検索時
    }else{
        // ループ開始値設定
        // 表示件数が全件の場合
        if ($range == null){
            $start  = $str_pad_cd22_s;                                      // 指定された開始コード
        }else{
            $start  = ($range * $page_count) - $range + $str_pad_cd22_s;    // (表示件数 * ページ数) - 表示件数 + 指定された開始コード
        }
        // ループ終了値設定
        // 表示件数が全件の場合
        if ($range == null){
            $stop   = $str_pad_cd22_e;                                      // 指定された終了コード
        }else{
            // 最終ページの場合
            if (($range * $page_count) + $client_cd22_s > $str_pad_cd22_e){
                $stop   = $str_pad_cd22_e;                                  // 指定された終了コード
            }else{
                $stop   = ($range * $page_count) + $str_pad_cd22_s - 1;     // (表示件数 * ページ数) + 指定された開始コード - 1
            }
        }
        // 終了番号が9999を超える場合は指定された終了コードにする
        $stop = ($stop > 9999) ? $str_pad_cd22_e : $stop;
    }

    /****************************/
    // 検索条件作成
    /****************************/
    if($post_flg == true){

        $where_sql  = null;

        // 上6桁検索時
        if ($method == "1"){

    	    // 得意先コード1（開始）
            $where_sql .= "AND t_client.client_cd1 >= '".str_pad($start, 6, "0", STR_PAD_LEFT)."' \n";
	        // 得意先コード1（終了）
            $where_sql .= "AND t_client.client_cd1 <= '".str_pad($stop,  6, "0", STR_PAD_LEFT)."' \n";

        // 下4桁検索時
        }else{

            // 得意先コード1
            $where_sql .= "AND t_client.client_cd1  = '".$client_cd12."' \n";
	        // 得意先コード2（開始）
            $where_sql .= "AND t_client.client_cd2 >= '".str_pad($start, 4, "0", STR_PAD_LEFT)."' \n";
	        // 得意先コード2（終了）
            $where_sql .= "AND t_client.client_cd2 <= '".str_pad($stop,  4, "0", STR_PAD_LEFT)."' \n";

        }

    }

    /****************************/
    // 存在する得意先コードを取得
    /****************************/
    $sql  = "SELECT \n";
    $sql .= ($method == "1") ? "   DISTINCT client_cd1 AS cd \n" : "   client_cd2 AS cd, \n";
    $sql .= ($method == "1") ? null : "   client_name AS name, \n";
    $sql .= ($method == "1") ? null : "   client_cname AS cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    if ($_SESSION["group_kind"] == "2"){
    $sql .= "   shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   shop_id = $shop_id \n";
    }
    $sql .= "AND \n";
    $sql .= "   client_div IN ('1') \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= ($method == "1") ? "   client_cd1 \n" : "   client_cd2 \n";
//    $sql .= ($range != null) ? "LIMIT $range \n" : null;
//    $sql .= ($range != null) ? "OFFSET $offset \n" : null;
    $sql .= "; \n";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_res_cd = Get_Data($res, 2, "ASSOC");
        foreach ($ary_res_cd as $key => $value){
            $ary_use_cd[]               = $value["cd"];                     // 使用中コード配列
            $ary_client[$value["cd"]]   = array(
                                            "cd"    => $value["cd"],        // 使用中コード
                                            "name"  => $value["name"],      // 得意先名
                                            "cname" => $value["cname"],     // 略称
                                          );
        }
    }else{
        $ary_use_cd = $ary_client = array(null);
    }

    /****************************/
    // 一覧用データ配列作成
    /****************************/
    // 指定された得意先コードの範囲でループ
    for ($cd = $start; $cd <= $stop; $cd++){

        // 0埋め
        $str_pad_cd = ($method == "1") ? str_pad($cd, 6, "0", STR_PAD_LEFT) : str_pad($cd, 4, "0", STR_PAD_LEFT);

        // 上6桁検索時
        if ($method == "1"){

            // 存在するコードの場合
            if (in_array($str_pad_cd, $ary_use_cd)){
                $ary_cd[]   = array(
                                "link"  => false,
                                "cd"    => $str_pad_cd,
                              );
            // 存在しないコードの場合
            }else{
                $ary_cd[]   = array(
                                "link"  => true,
                                "cd"    => $str_pad_cd,
                              );
            }

        // 下4桁検索時
        }else{

            // 存在するコードの場合
            if (in_array($str_pad_cd, $ary_use_cd)){
                $ary_cd[]   = array(
                                "link"  => false,
                                "cd"    => $str_pad_cd,
                                "name"  => $ary_client["$str_pad_cd"]["name"],
                                "cname" => $ary_client["$str_pad_cd"]["cname"],
                              );
            // 存在しないコードの場合
            }else{
                $ary_cd[]   = array(
                                "link"  => true,
                                "cd"    => $str_pad_cd,
                                "name"  => null,
                                "cname" => null,
                              );
            }

        }

    }

}


/******************************/
// 表示データ
/******************************/
if ($post_flg == true){

    /****************************/
    // html作成初期設定
    /****************************/
    // 行色初期設定
    $row_col        = "Result1";

    // 行No.初期設定
    $row_num        = ($page_count - 1) * $range;

    // トータル件数
    $total_count    = ($method == "1") ? $str_pad_cd11_e - $str_pad_cd11_s + 1 : $str_pad_cd22_e - $str_pad_cd22_s + 1;

    /****************************/
    // html作成
    /****************************/
    // 件数表示/ページ分け
    $html_page  = Html_Page($total_count, $page_count, 1, $range);
    $html_page2 = Html_Page($total_count, $page_count, 2, $range);


    // 一覧テーブル
    $html_l  = "<table class=\"List_Table\" border=\"1\" width=\"500\">\n";
    $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_l .= "        <td class=\"Title_Purple\">No.</td>\n";
    $html_l .= "        <td class=\"Title_Purple\">得意先コード</td>\n";
    if ($method != "1"){
        $html_l .= "        <td class=\"Title_Purple\">得意先名</td>\n";
        $html_l .= "        <td class=\"Title_Purple\">略称</td>\n";
    }
    $html_l .= "    </tr>\n";
    foreach ($ary_cd as $key => $value){
        $html_l .= "    <tr class=\"".$row_col."\">\n";
        $html_l .= "        <td align=\"right\" width=\"30\">".++$row_num."</td>\n";
        $html_l .= "        <td align=\"center\">\n";
        if ($value["link"] == true){
            if ($method == "1"){
                $html_l .= "            <a href=\"#\" onClick=\"returnValue=Array('".$value["cd"]."', ''); window.close();\">\n";
                $html_l .=              $value["cd"]."</a>\n";
            }else{
                $html_l .= "            <a href=\"#\" onClick=\"returnValue=Array('".$client_cd12."', '".$value["cd"]."'); window.close();\">\n";
                $html_l .=              $client_cd12."-".$value["cd"]."</a>\n";
            }
        }else{
            if ($method == "1"){
                $html_l .= "            ".$value["cd"]."\n";
            }else{
                $html_l .= "            ".$client_cd12."-".$value["cd"]."\n";
            }
        }
        $html_l .= "        </td>\n";
        if ($method != "1"){
            $html_l .= "        <td>".htmlspecialchars($value["name"])."</td>\n";
            $html_l .= "        <td>".htmlspecialchars($value["cname"])."</td>\n";
        }
        $html_l .= "    </tr>\n";
    }
    $html_l .= "</table>\n";

}


/******************************/
// js作成
/******************************/
// フォームのオプション
$form_option11_s    = "style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" ";
$form_option11_s   .= "onkeyup=\"changeText(this.form, \'form_client_cd11[s]\', \'form_client_cd11[e]\', 6)\"";
$form_option11_e    = "style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
$form_option12      = "style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
$form_option22_s    = "style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" ";
$form_option22_s   .= "onkeyup=\"changeText(this.form, \'form_client_cd22[s]\', \'form_client_cd22[e]\', 4)\"";
$form_option22_e    = "style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
$def_focus_form     = ($method == "1") ? "form_client_cd11[s]" : "form_client_cd12";

// フォームにセットする値
$form_set_client_cd11_s = ($err_flg != true) ? $client_cd11_s : $_POST["form_client_cd11"]["s"];
$form_set_client_cd11_e = ($err_flg != true) ? $client_cd11_e : $_POST["form_client_cd11"]["e"];
$form_set_client_cd12   = ($err_flg != true) ? $client_cd12   : $_POST["form_client_cd12"];
$form_set_client_cd22_s = ($err_flg != true) ? $client_cd22_s : $_POST["form_client_cd22"]["s"];
$form_set_client_cd22_e = ($err_flg != true) ? $client_cd22_e : $_POST["form_client_cd22"]["e"];

$js  = "

// デフォルトフォーカス
function Onload_Focus(){

    var form_client_cd11_s  = document.dateForm.elements[\"form_client_cd11[s]\"];
    var form_client_cd12    = document.dateForm.elements[\"form_client_cd12\"];

    if (form_client_cd11_s != undefined){
        var focus_form = form_client_cd11_s;
    }else if (form_client_cd12 != undefined){
        var focus_form = form_client_cd12;
    }
    focus_form.focus();

}

// 検索方法によるフォーム切替
function Select_Method(){

    var form_method = document.dateForm.elements[\"form_method\"];
    var method1     = document.getElementById(\"method1\");
    var method2     = document.getElementById(\"method2\");

    // 上6桁検索が選択された場合
    if (form_method[0].checked == true){

        // 上6桁範囲検索フォーム出力
        var print1 = '<input size=\"7\" maxlength=\"6\" ".$form_option11_s." name=\"form_client_cd11[s]\" type=\"text\" />';
        var print1 = print1 + ' 〜 <input size=\"7\" maxlength=\"6\" ".$form_option11_e." name=\"form_client_cd11[e]\" type=\"text\" />';
        method1.innerHTML   = print1;

        // 下4桁検索項目を非表示
        method2.innerHTML   = \"\";

        // 必須マーク非出力
        required.innerHTML  = \"\";

    // 下4桁検索が選択された場合
    }else if (form_method[1].checked == true){

        // 上6桁指定フォーム出力
        method1.innerHTML = '<input size=\"7\" maxlength=\"6\" ".$form_option12." name=\"form_client_cd12\" type=\"text\" />';

        // 下4桁範囲検索フォーム出力
        var print2 = '<input size=\"5\" maxlength=\"4\" ".$form_option22_s." name=\"form_client_cd22[s]\" type=\"text\" />';
        var print2 = print2 + ' 〜 <input size=\"5\" maxlength=\"4\" ".$form_option22_e." name=\"form_client_cd22[e]\" type=\"text\" />';
        method2.innerHTML = print2;

        // 必須マーク出力
        required.innerHTML  = \"※\";

    }

}

// オンロード時のフォーム値セット
function Form_Set(){

    // フォーム切替関数呼び出し
    Select_Method();

    var form_method = document.dateForm.elements[\"form_method\"];

    // 上6桁検索時
    if (form_method[0].checked == true){

        var form_client_cd11_s      = document.dateForm.elements[\"form_client_cd11[s]\"];
        var form_client_cd11_e      = document.dateForm.elements[\"form_client_cd11[e]\"];

        form_client_cd11_s.value    = \"".$form_set_client_cd11_s."\";
        form_client_cd11_e.value    = \"".$form_set_client_cd11_e."\";

    // 下4桁検索が選択された場合
    }else if (form_method[1].checked == true){

        var form_client_cd12        = document.dateForm.elements[\"form_client_cd12\"];
        var form_client_cd22_s      = document.dateForm.elements[\"form_client_cd22[s]\"];
        var form_client_cd22_e      = document.dateForm.elements[\"form_client_cd22[e]\"];

        form_client_cd12.value      = \"".$form_set_client_cd12."\";
        form_client_cd22_s.value    = \"".$form_set_client_cd22_s."\";
        form_client_cd22_e.value    = \"".$form_set_client_cd22_e."\";

    }

}

";

/*
$s_time = microtime();
$e_time = microtime();
print "s_time: ".$s_time."<br>";
print "e_time: ".$e_time."<br>";
*/

/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_f('system','1');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
));
// フラグをassign
$smarty->assign("flg", array(
    "post_flg"      => $post_flg,
    "err_flg"       => $err_flg,
));
// 出力内容をassign
$smarty->assign("html", array(
    "js"            => $js,
    "html_l"        => $html_l,
    "html_page"     => $html_page,
    "html_page2"    => $html_page2,
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
