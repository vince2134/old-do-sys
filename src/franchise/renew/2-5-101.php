<?php
/*******************************************
 *  修正履歴
 *  2007-04-13              fukuda      履歴表示を30件から60件に変更
*******************************************/

/*******************************************/
// ページ内定義
/*******************************************/

// ページタイトル
$page_title = "日次更新履歴";

// 環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$conn = Db_Connect();

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// 権限チェック
$auth       = Auth_Check($conn);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

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
$page_menu = Create_Menu_f('renew','1');

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// フォームパーツ定義
/****************************/

/*******************************************/
// ページ読込時処理
/*******************************************/

/****************************/
// 外部変数取得
/****************************/

/****************************/
// 判定
/****************************/

/****************************/
// 描画データ取得/出力
/****************************/
// ショップ内の支店リスト取得
$sql  = "SELECT \n";
$sql .= "   branch_id, \n";
$sql .= "   t_branch.branch_cd || ' : ' || t_branch.branch_name AS branch \n";
$sql .= "FROM \n";
$sql .= "   t_branch \n";
$sql .= "WHERE \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= "ORDER BY \n";
$sql .= "   branch_cd \n";
$sql .= ";";
$res  = Db_Query($conn, $sql);
$num_list  = pg_num_rows($res);
if ($num_list > 0){

    // 支店リスト作成
    $branch_list = Get_Data($res, 2, "ASSOC");

    // 支店単位でループ
    foreach ($branch_list as $key_branch => $value_branch){

        // 支店単位の日次更新データ取得
        $sql  = "SELECT     to_date(t_sys_renew.renew_time, 'YYYY-MM-DD') || ' ' || to_char(t_sys_renew.renew_time, 'hh24:mi:ss') AS date, \n";
        $sql .= "           t_sys_renew.close_day, \n";
        $sql .= "           t_sys_renew.operation_staff_name \n";
        $sql .= "FROM       t_sys_renew \n";
        $sql .= "INNER JOIN  t_branch ON t_sys_renew.branch_id = t_branch.branch_id \n";
        $sql .= "WHERE      t_sys_renew.renew_div = '1' \n";      // renew_div = '1' : 日次
        $sql .= "AND        t_sys_renew.shop_id = ".$_SESSION["client_id"]." \n";
        $sql .= "AND        t_branch.branch_id = ".$value_branch["branch_id"]." \n";
        $sql .= "ORDER BY   t_branch.branch_cd ASC, t_sys_renew.renew_time DESC \n";
        $sql .= "LIMIT      60 \n";
        $sql .= "OFFSET     0 \n";
        $sql .= ";";
        $res  = Db_Query($conn, $sql);
        $num[$key_branch] = pg_num_rows($res);

        // 一覧用データ作成
        $rec_data[$key_branch] = Get_Data($res, 2, "ASSOC");

    }

    $html_l = "";

    // 支店単位でループ
    foreach ($branch_list as $key_branch => $value_branch){

        $html_l .= "<td>\n";
        $html_l .= "<span style=\"font: bold 16px; color: #555555;\">【".htmlspecialchars($value_branch["branch"])."】</span>\n";
        $html_l .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
        $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
        $html_l .= "        <td class=\"Title_Green\">No.</td>";
        $html_l .= "        <td class=\"Title_Green\">日次更新日</td>\n";
        $html_l .= "        <td class=\"Title_Green\">作業実施日時</td>\n";
        $html_l .= "        <td class=\"Title_Green\">更新者</td>\n";
        $html_l .= "    </tr>\n";

        $i = 0; // 行No.用カウンタ

        // 各支店の日次更新データがある場合
        if ($num[$key_branch] > 0){
            // 各支店の日次更新データでループ
            foreach ($rec_data[$key_branch] as $key_data => $value_data){
                $html_l .= "    <tr class=\"Result1\">\n";
                $html_l .= "        <td align=\"right\">".++$i."</td>\n";
                $html_l .= "        <td align=\"center\">".$value_data["close_day"]."</td>\n";
                $html_l .= "        <td align=\"center\">".$value_data["date"]."</td>\n";
                $html_l .= "        <td>".htmlspecialchars($value_data["operation_staff_name"])."</td>\n";
                $html_l .= "    </tr>\n";
            }
        }

        $html_l .= "</table>\n";
        $html_l .= "</td>\n";

    }

}

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
));

// 一覧用レコードデータをテンプレートへ渡す
$smarty->assign("html_l", $html_l);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
