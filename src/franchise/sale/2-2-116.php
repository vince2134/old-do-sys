<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-03-22                  watanabe-k  削除伝票を表示しないように修正
 *  2007-03-22                  watanabe-k  ヘッダに表示するボタンを表示
 *  2007-04-12                  fukuda      検索条件復元処理追加
 *  2007-05-14                  watanabe-k  集計日報の発行日を表示
 *  2007-05-15                  watanabe-k  予定伝票発行機能を追加
 *  2007-05-22                  watanabe-k  画面のタイトルを変更
 *  2007-05-23                  watanabe-k  表示するデータのグルーピングを変更
 *
*/

$page_title = "代行期間集計表";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// 契約関数定義
require_once(INCLUDE_DIR."function_keiyaku.inc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"], "", "target=_self");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_day"    => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => date("d"),
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("d"),
    ),
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
);

// 検索条件復元
Restore_Filter2($form, "contract", "form_show_button", $ary_form_list);


/****************************/
// セッションチェック
/****************************/
if ($_SESSION["group_kind"] != "2"){
    header("Location: ".FC_DIR."top.php");
}

/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"]; 


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

// 不必要なフォームを削除
$form->removeElement("form_attach_branch");
$form->removeElement("form_round_staff");
$form->removeElement("form_multi_staff");
$form->removeElement("form_part");
$form->removeElement("form_ware");
$form->removeElement("form_claim_day");

/* モジュール別フォーム */
// 表示ボタン
/*
$form->addElement("button", "form_show_button", "表　示",
    "onClick=\"javascript: Button_Submit('show_button_flg', '".$_SERVER["PHP_SELF"]."', 'true');\""
);
*/
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 一括チェック用チェックボックス
$form->addElement("checkbox", "aord_prefix_all", "付番前", "前集計日報(0)",
    "onClick=\"javascript:All_Check_Preslip('aord_prefix_all');\""
);
$form->addElement("checkbox", "aord_unfix_all", "集計日報", "付番集計日報(1)",
    "onClick=\"javascript:All_Check_Unslip('aord_unfix_all');\""
);
$form->addElement("checkbox", "aord_fix_all", "再発行", "(1)再発行",
    "onClick=\"javascript:All_Check_Slip('aord_fix_all');\""
);
$form->addElement("checkbox", "slip_out_all", "売上伝票発行", "売上伝票発行",
    "onClick=\"javascript:All_Slip_Check('slip_out_all');\""
);
$form->addElement("checkbox", "reslip_out_all", "再発行", "再発行",
    "onClick=\"javascript:All_Reslip_Check('reslip_out_all');\""
);





// 集計日報印刷ボタン
$form->addElement("button", "form_preslipout_button", "前集計日報(0)",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit','付番前発行');\""
);
$form->addElement("button", "form_slipout_button", "付番集計日報(1)",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit','集計日報発行');\""
);
$form->addElement("button", "form_reslipout_button", "(1)再発行",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit', '　再　発　行　');\""
);

$form->addElement("button", "slip_out_button", "売上伝票発行",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '売上伝票発行');\""
);

$form->addElement("button", "reslip_out_button", "　再　発　行　",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '再発行');\""
);

// ヘッダに表示するボタン
$form->addElement("button", "2-2-113_button", "集計日報",     "onClick=\"location.href='./2-2-113.php'\"");
$form->addElement("button", "2-2-116_button", "代行期間集計表",   "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");
$form->addElement("button", "2-2-204_button", "予定伝票発行", "onClick=\"location.href='./2-2-204.php'\"");
$form->addElement("button", "2-2-111_button", "商品予定出荷", "onClick=\"location.href='./2-2-111.php'\"");


// 表示ボタン押下フラグ
$form->addElement("hidden", "show_button_flg");

// 帳票出力ボタンフラグ
$form->addElement("hidden", "form_hdn_submit");

// 初期表示フラグ
$form->addElement("hidden", "renew_flg", "t");

// モジュール判別用（売上伝票発行で使用）
$form->addElement("hidden", "src_module", "代行集計表");

/****************************/
// イベント判別フラグ設定
/****************************/
/*
$show_button_flg = ($_POST["show_button_flg"] == "true") ? true : false;
$submit_flg      = ($show_button_flg == false  && $_POST["renew_flg"] == "t") ? true : false;
*/
$show_button_flg = ($_POST["form_show_button"] != null) ? true : false;
$submit_flg      = ($_POST["form_show_button"] == null && $_POST != null) ? true : false;


/****************************/
// 各イベント処理
/****************************/
//表示ボタン押下
if($show_button_flg == true){

    // 日付POSTデータの0埋め
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $form->addGroupRule('form_round_day', array(
            'sy' => array(
                    array('予定巡回日は必須入力です。', 'required')
            ),      
            'sm' => array(
                    array('予定巡回日は必須入力です。','required')
            ),      
            'sd' => array(
                    array('予定巡回日は必須入力です。','required')
            ),         
            'ey' => array(
                    array('予定巡回日は必須入力です。','required')
            ),         
            'em' => array(
                    array('予定巡回日は必須入力です。','required')
            ),         
            'ed' => array(
                    array('予定巡回日は必須入力です。','required')
            ),         
    ));

    /****************************/
    // エラーチェック
    /****************************/
    // ■共通フォームチェック
    Search_Err_Chk($form);

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

    //表示ボタンフラグクリア
    $set_data["show_button_flg"] = "";

}


/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時、その他のPOST時
/****************************/
if (($show_button_flg == true && $err_flg != true) || $submit_flg == true){

    // 日付POSTデータの0埋め
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $where["display_num"]       = $_POST["form_display_num"];
    $where["client_branch"]     = $_POST["form_client_branch"];
    $where["client_cd1"]        = $_POST["form_client"]["cd1"];
    $where["client_cd2"]        = $_POST["form_client"]["cd2"];
    $where["client_name"]       = $_POST["form_client"]["name"];
    $where["claim_cd1"]         = $_POST["form_claim"]["cd1"];
    $where["claim_cd2"]         = $_POST["form_claim"]["cd2"];
    $where["claim_name"]        = $_POST["form_claim"]["name"];
    $where["round_day_sy"]      = $_POST["form_round_day"]["sy"];
    $where["round_day_sm"]      = $_POST["form_round_day"]["sm"];
    $where["round_day_sd"]      = $_POST["form_round_day"]["sd"];
    $where["round_day_ey"]      = $_POST["form_round_day"]["ey"];
    $where["round_day_em"]      = $_POST["form_round_day"]["em"];
    $where["round_day_ed"]      = $_POST["form_round_day"]["ed"];
    $where["charge_fc_cd1"]     = $_POST["form_charge_fc"]["cd1"];
    $where["charge_fc_cd2"]     = $_POST["form_charge_fc"]["cd2"];
    $where["charge_fc_name"]    = $_POST["form_charge_fc"]["name"];
    $where["charge_fc_select"]  = $_POST["form_charge_fc"]["select"]["1"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true){

    // 該当件数取得
    $total_count = Get_Aord_Data($db_con, $where, "", "", "count");

    // 1ページの表示件数が全件の場合
    if ($where["display_num"] == "1") {
        $range = $total_count;
    } else {
        $range = "100";
    }

    // 現在のページ数をチェックする
    $page_info = Check_Page($total_count, $range, $_POST["f_page1"]);
    $page      = $page_info[0]; //現在のページ数
    $page_snum = $page_info[1]; //表示開始件数
    $page_enum = $page_info[2]; //表示終了件数

    // ページプルダウン表示判定
    if($page == "1"){
        // ページ数が１ならページプルダウンを非表示
        $c_page = NULL;
    }else{
        // ページ数分プルダウンに表示
        $c_page = $page;
    }

    // ページ作成
    $html_page  = Html_Page2($total_count, $c_page, 1, $range);
    $html_page2 = Html_Page2($total_count, $c_page, 2, $range);

    // 請求書データ取得
    $aord_data  = Get_Aord_Data($db_con, $where, $page_snum, $page_enum);

    // 表示形式に修正
    $result_data  = Get_Aord_Html_Data($db_con, $aord_data, $form, $page_snum);

    $aord_data  = $result_data[0];   //表示データ
    $preslip_id = $result_data[1];   //付番前対象ID
    $unslip_id  = $result_data[2];   //集計日報対象ID
    $slip_id    = $result_data[3];   //再発行対象ID
    $sheet_id   = $result_data[4];   //売上伝票発行ID
    $resheet_id = $result_data[5];   //伝票再発行ID

}




/****************************/
// html
/****************************/
/* 検索テーブル */
$html_s .= "\n";
$html_s .= "<table>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td>\n";
// 共通検索テーブル
$html_s .= Search_Table($form);
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";

/****************************/
// js
/****************************/
// 付番前（ALLチェックJSを作成）
$javascript .= Create_Allcheck_Js("All_Check_Preslip", "form_preslip_out", $preslip_id);
// 集計日報(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js("All_Check_Unslip",  "form_unslip_out",  $unslip_id);
// 再発行(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js("All_Check_Slip",    "form_slip_out",    $slip_id);
// 伝票発行(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js("All_Slip_Check",    "form_slip_check",    $sheet_id);
// 伝票再発行(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js("All_Reslip_Check",    "form_reslip_check",    $resheet_id);

// ボタンのPOSTを渡す
$javascript  .= "function Post_Next_Page(page,hidden_form, mesg){\n";
$javascript  .= "   var hdn = hidden_form;\n";
$javascript  .= "   document.dateForm.elements[hdn].value = mesg;\n";
$javascript  .= "   //別画面でウィンドウを開く\n";
$javascript  .= "   document.dateForm.target=\"_blank\";\n";
$javascript  .= "   document.dateForm.action=page;\n";
$javascript  .= "   //POST情報を送信する\n";
$javascript  .= "   document.dateForm.submit();\n";
$javascript  .= "   document.dateForm.target=\"_self\";\n";
$javascript  .= "   document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$javascript  .= "}\n";


/****************************/
//関数作成
/****************************/
//代行データ抽出
function Get_Aord_Data($db_con, $where, $page_snum, $page_enum, $kind=""){
    //カレンダ表示期間取得
    $cal_array = Cal_range($db_con,$_SESSION["client_id"],true);
    $end_day   = $cal_array[1];     //対象終了期間

    $offset = $page_snum-1; //表示しない件数
    $limit  = ($page_enum - $page_snum) +1;    //一ページあたりの件数

    //**************************//
    //HTMLのvalue値をSQL用に加工
    //**************************//
    $round_day_s = $where["round_day_sy"]."-".$where["round_day_sm"]."-".$where["round_day_sd"];
    $round_day_e = $where["round_day_ey"]."-".$where["round_day_em"]."-".$where["round_day_ed"];

    /****************************/
    //受注データを抽出SQL
    /****************************/
    $sql_column = "
        SELECT
            t_aorder_h.ord_time,
            CAST(t_aorder_h.act_cd1 AS text) || '-' || CAST(t_aorder_h.act_cd2 AS text) AS shop_cd,
            t_client.shop_name,
            COUNT(t_aorder_h.ord_time) AS count, 
            t_aorder_h.act_id,
--            t_aorder_h.act_name 
            MAX(t_aorder_h.daily_slip_out_day) AS daily_slip_out_day,
            MAX(t_aorder_h.slip_out_day) AS slip_out_day,
            daily_slip_id 
    ";

    $sql = "
        FROM 
            t_aorder_h
                INNER JOIN
            t_client
            ON t_aorder_h.act_id = t_client.client_id 
            AND (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') 
                INNER JOIN
            t_client AS t_client1
            ON t_aorder_h.client_id = t_client1.client_id
        WHERE
            t_aorder_h.shop_id IN (".Rank_Sql().")
            AND
            t_aorder_h.del_flg = false
            AND
            t_aorder_h.ord_time <= '$end_day' 
    ";

    // 検索条件追加
    // 巡回配送日（開始）
    if($round_day_s != "--"){
        $sql .= "AND t_aorder_h.ord_time >= '$round_day_s' ";
    }

    // 巡回配送日（終了）
    if($round_day_e != "--"){
        $sql .= "AND t_aorder_h.ord_time <= '$round_day_e' ";
    }

    // 得意先
    // 得意先コード１が入力された場合
    if($where["client_cd1"] != null){
        $sql .= "AND t_aorder_h.client_cd1 LIKE '".$where["client_cd1"]."%' ";
    }

    // 得意先コード２が入力された場合
    if($where["client_cd2"] != null){
        $sql .= "AND t_aorder_h.client_cd2 LIKE '".$where["client_cd2"]."%' ";
    }

    // 得意先名が入力された場合
    if($where["client_name"] != null){
        // 得意先名
        $sql .= "AND (t_aorder_h.client_name  LIKE '%".$where["client_name"]."%' ";
        // 得意先名２
        $sql .= "OR t_aorder_h.client_name2 LIKE '%".$where["client_name"]."%' ";
        // 得意先名（略称）
        $sql .= "OR t_aorder_h.client_cname LIKE '%".$where["client_name"]."%' ";
        // 得意先名（フリガナ）
        $sql .= "OR t_aorder_h.client_id IN (
                    SELECT 
                        t_client.client_id 
                    FROM 
                        t_client 
                    WHERE 
                        t_client.client_div = '1' 
                        AND
                        t_client.client_read LIKE '%".$where["client_name"]."%'
                        AND
                        t_client.shop_id IN (".Rank_Sql().")
                    )
                ) 
            ";
    }

    // 請求先
    if($where["claim_cd1"] != null || $where["claim_cd2"] != null || $where["claim_name"] != null){
        $sql .= "AND t_aorder_h.claim_id IN (
                SELECT 
                    t_client.client_id 
                FROM 
                    t_client 
                WHERE 
                    t_client.client_div = '1' 
                    AND
                    t_client.shop_id IN (".Rank_Sql().") 
        ";

        // 請求先コード１
        if($where["claim_cd1"] != null){
            $sql .= "AND t_client.client_cd1 LIKE '".$where["claim_cd1"]."%' ";
        }

        // 請求先コード２
        if($where["claim_cd2"] != null){
            $sql .= "AND t_client.client_cd2 LIKE '".$where["claim_cd2"]."%' ";
        }

        // 請求先名
        if($where["claim_name"] != null){
            // 請求先名
            $sql .= "AND (t_client.client_name LIKE '%".$where["claim_name"]."%' ";
            // 請求先名２
            $sql .= "OR t_client.client_name2  LIKE '%".$where["claim_name"]."%' ";
            // 請求先名（略称）
            $sql .= "OR t_client.client_cname  LIKE '%".$where["claim_name"]."%' ";
            // 請求先名（フリガナ）
            $sql .= "OR t_client.client_read   LIKE '%".$where["claim_name"]."%')";
        }

        $sql .= ") ";
    }

    //委託先FC
    // 委託先FCコード１
    if($where["charge_fc_cd1"] != null){
        $sql .= "AND t_aorder_h.act_cd1 LIKE '".$where["charge_fc_cd1"]."%' ";
    }

    // 委託先FCコード２
    if($where["charge_fc_cd2"] != null){
        $sql .= "AND t_aorder_h.act_cd2 LIKE '".$where["charge_fc_cd2"]."%' ";
    }

    // 委託先FC名
/*
    if($where["charge_fc_name"] != null){
        // 委託先FC名
        $sql .= "AND (t_aorder_h.act_name LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR  t_aorder_h.act_id IN (
                        SELECT 
                            t_client.client_id 
                        FROM 
                            t_client 
                        WHERE 
                            t_client.client_div = '3' 
            ";
        // 委託先FC名2
        $sql .= "AND (t_client.client_name2 LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR   t_client.client_cname LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR   t_client.client_read  LIKE '%".$where["charge_fc_name"]."%')";
        $sql .= ")) ";
    }
*/
    if ($where["charge_fc_name"] != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.act_name   LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.shop_name    LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name  LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "   ) \n";
    }

    // 委託先FCセレクト
    if ($where["charge_fc_select"] != null){
        $sql .= "AND t_aorder_h.act_id = ".$where["charge_fc_select"]." \n";
    }

    // 顧客担当支店
    if($where["client_branch"] != null){
        $sql .= "AND t_aorder_h.client_id IN ( ";
        $sql .= "       SELECT ";
        $sql .= "           t_client.client_id ";
        $sql .= "       FROM ";
        $sql .= "           t_client ";
        $sql .="        WHERE ";
        $sql .= "           t_client.charge_branch_id = ".$where["client_branch"]." ";
        $sql .= "   )";
    }

    $group_by = "
        GROUP BY
            t_aorder_h.daily_slip_id, 
            t_aorder_h.ord_time,
            t_aorder_h.act_id,
            t_aorder_h.act_cd1,
            t_aorder_h.act_cd2,
            t_client.shop_name
--            t_aorder_h.act_name 
    ";

    $order_by = "
        ORDER BY
            t_aorder_h.act_cd1,
            t_aorder_h.act_cd2,
            t_aorder_h.ord_time
    ";

    if ($where["count_select"] != "all") {
        $limit_sql .= "LIMIT $limit OFFSET $offset ";
    }


    //検索に該当した「件数」を返して終了
    if ($kind == "count") {
        $sql_column = "SELECT COUNT(t_aorder_h.aord_id) AS count ";
        $exec_sql   = "SELECT COUNT(count.count) FROM (".$sql_column.$sql.$group_by." ) AS count";
        $result     = Db_Query($db_con, $exec_sql);
        $data       = pg_fetch_result($result, 0 ,0);
        return $data;

    //一覧用 請求書データを取得
    } else {
        $exec_sql   = "$sql_column"."$sql"."$group_by"."$order_by"."$limit_sql";
        $result = Db_Query($db_con, $exec_sql);
    }

    if(pg_num_rows($result) > 0){
        $aord_data = pg_fetch_all($result);
    }
    return $aord_data;
}

//代行ごとの伝票データ抽出
function Get_Aord_Html_Data($db_con, $aord_data, $form, $page_snum){
    //カレンダ表示期間取得
    $cal_array = Cal_range($db_con,$_SESSION["client_id"],true);
    $end_day   = $cal_array[1];     //対象終了期間

    $count = count($aord_data);

    $k = 0;     //チェックボックスカウンタ
    for($i = 0; $i < $count; $i++){
        //代行伝票ごとの伝票枚数
        $sql  = "SELECT\n";
        $sql .= "   t_aorder_h.aord_id, \n";
        $sql .= "   t_aorder_h.ord_no,  \n";
        $sql .= "   t_client.slip_out, \n";
        $sql .= "   t_aorder_h.slip_out_day \n";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_client ";
        $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
        $sql .= "WHERE\n";
        $sql .= "   t_aorder_h.act_id = ".$aord_data[$i]["act_id"]."\n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time = '".$aord_data[$i]["ord_time"]."'\n";
        $sql .= "   AND\n";
//        $sql .= "   t_aorder_h.reserve_del_flg = false \n";
        $sql .= "   t_aorder_h.del_flg = false \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        if($aord_data[$i]["daily_slip_id"] != null){
            $sql .= "   AND";
            $sql .= "   t_aorder_h.daily_slip_id = ".$aord_data[$i]["daily_slip_id"]." \n";
        }else{
            $sql .= "   AND";
            $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
        }

        $sql .= "ORDER BY t_aorder_h.route\n";
        $sql .= ";";

        $result      = Db_Query($db_con, $sql);
        $aord_d_data = pg_fetch_all($result);

        $d_count = count($aord_d_data);

        //伝票枚数初期化
        $slip_out_count = 0;
        $unslip_out_count = 0;

        for($j = 0; $j < $d_count; $j++){
            //付番している伝票数
            if($aord_d_data[$j]["ord_no"] != null){
                $slip_out_count++;
            //付番前伝票数               
            }else{
                $unslip_out_count++;
            }
            $aord_data[$i]["aord_id"][] = $aord_d_data[$j]["aord_id"];

            //得意先マスタで伝票発行有に指定しているもの
            if($aord_d_data[$j]["slip_out"] == '1'){
                $aord_data[$i]["slip_id"][] = $aord_d_data[$j]["aord_id"];
                $aord_data[$i]["slip_day"][] = $aord_d_data[$j]["slip_out_day"];
            }
        }

        //付番済み
        $aord_data[$i]["slip_out_count"]    = $slip_out_count;
        //付番前
        $aord_data[$i]["unslip_out_count"] = $unslip_out_count;

        //配列をシリアライズ化
        $aord_data[$i]["uni_aord_id"]       = urlencode(serialize($aord_data[$i]["aord_id"]));

        //サニタイジング
        $aord_data[$i]["shop_name"]     = htmlspecialchars($aord_data[$i]["shop_name"]);
        $aord_data[$i]["client_name"]   = htmlspecialchars($aord_data[$i]["client_name"]);

        //リンク
        $aord_data[$i]["ord_time"]  = "<a href=\"./2-2-106.php?aord_id_array=".$aord_data[$i]["uni_aord_id"]."&back_display=act_count\">".$aord_data[$i]["ord_time"]."</a>";

        //行の背景色
        if($i % 2){
            $aord_data[$i]["bg_color"] = "Result2";
        }else{
            $aord_data[$i]["bg_color"] = "Result1";
        }

        //動的フォーム作成
        //■付番前
        // 付番前の伝票がある場合
        if ($aord_data[$i]["unslip_out_count"] > 0) {
            // 付番前
            $form->addElement("advcheckbox", "form_preslip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $preslip_id[$k] = $aord_data[$i]["uni_aord_id"];
            // 集計日報発行
            $form->addElement("advcheckbox", "form_unslip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $unslip_id[$k] = $aord_data[$i]["uni_aord_id"];

        }else{
            // 集計日報発行日
            $form->addElement("static", "form_unslip_out[$k]", "",$aord_data[$i]["daily_slip_out_day"]);
            $set_data["form_unslip_out"][$k] = $aord_data[$i]["daily_slip_out_day"];

            // 再発行
            $form->addElement("advcheckbox", "form_slip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $slip_id[$k] = $aord_data[$i]["uni_aord_id"];

            //発行する伝票が存在する場合
            if(is_array($aord_data[$i]["slip_id"])){

                $target_id = null;
                $target_id = implode(',', $aord_data[$i]["slip_id"]);

                //まだ配列内に発行していない伝票がある場合
                if(in_array("",$aord_data[$i]["slip_day"])){
                    // 伝票発行
                    $form->addElement("advcheckbox", "form_slip_check[$k]",   NULL, NULL, NULL, array("f", $target_id));
                    $sheet_id[$k] = $target_id;
                }else{
                    //伝票発行日
                    $form->addElement("static","form_slip_check[$k]", "", $aord_data[$i]["slip_out_day"]);
                    $set_data["form_slip_check"][$k] = $aord_data[$i]["slip_out_day"];

                    // 再発行
                    $form->addElement("advcheckbox", "form_reslip_check[$k]", NULL, NULL, NULL, array("f", $target_id));
                    $resheet_id[$k] = $target_id;
                }
            }
        }

        $form->setConstants($set_data);

        $aord_data[$i]["no"] = $page_snum++;
        $k++;

    }

    return array($aord_data, $preslip_id, $unslip_id, $slip_id, $sheet_id, $resheet_id);
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
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-113_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-116_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();
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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'javascript'    => "$javascript",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));
$smarty->assign('aord_data',$aord_data);
$smarty->assign("html", array(
    "html_s"        => $html_s,
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
