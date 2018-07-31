<?php
/**
 *
 * 棚卸更新処理
 *
 *
 *
 *
 *
 *
 *
 *   !! 本部・FC画面ともに同じソース内容です !!
 *   !! 変更する場合は片方をいじって他方にコピってください !!
 *
 *
 *
 *
 *
 *
 *
 * 仕様
 * ・棚卸更新時に在庫数を調整する
 *   （在庫調整の受払を登録）
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.8 (2006/10/17)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      02-013      kajioka-h   更新対象の棚卸調査表が存在しない場合にメッセージを表示
 *  2007/01/22      xx-xxx      kajioka-h   棚卸が一時登録中だった場合にエラーメッセージを表示
 *  2007/01/30      0069        kajioka-h   棚卸更新完了後に遷移する画面が間違っているバグ修正
 *  2007/05/04      その他119   kajioka-h   棚卸差異を受払に登録
 *  2007/05/14      その他92    kajioka-h   棚卸入力を50行ごとに表示・登録可能にしたため、一時登録の判定を変更
 *  2007/05/18      xx-xxx      kajioka-h   棚卸入力の差異原因に「調整」を追加したため、受払に登録する調整理由にも追加
 */

$page_title = "棚卸更新処理";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//SESSION情報
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

//完了後に飛ぶURL
$pre_url = ($group_kind == "1") ? "./1-5-104.php" : "./2-5-104.php";

//完了フラグ
$complete_msg = ($_GET["done"] == "t") ? "棚卸更新完了しました。" : null;

//フォーム作成
$form->addElement("button","jikkou","実　行","onClick=\"javascript:Dialogue_1('実行します。','true','jikkou_button_flg')\" $disabled");

//hidden
$form->addElement("hidden","jikkou_button_flg");

//前回更新日付取得 
$sql  = "SELECT";
$sql .= "   MAX(to_char(renew_time,'yyyy/mm/dd hh24:mi'))";
$sql .= " FROM";
$sql .= "   t_sys_renew ";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " AND";
$sql .= "   renew_div=4 ";
$sql .= ";";

$result = Db_Query($conn, $sql);

$renew_before = pg_fetch_result($result,0,0);

//更新日付履歴取得(過去５０回分)
$sql  = "SELECT";
$sql .= "   close_day,";                                  //調査表作成日
$sql .= "   to_char(renew_time,'yyyy/mm/dd hh24:mi')";    //更新日時
$sql .= " FROM";
$sql .= "   t_sys_renew ";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " AND";
$sql .= "   renew_div=4 ";
$sql .= " ORDER BY renew_time DESC LIMIT 50 OFFSET 0;";

$result = Db_Query($conn, $sql);
$page_data = Get_Data($result);

//実行ボタンが押された場合
if($_POST["jikkou_button_flg"] == 'true'){

    //一時登録中の棚卸がないか
    $sql  = "SELECT \n";
    $sql .= "    COUNT(t_invent.invent_id) \n";
    $sql .= "FROM \n";
    $sql .= "    t_invent \n";
    $sql .= "    INNER JOIN \n";
    $sql .= "    ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            invent_id, \n";
    $sql .= "            COUNT(goods_id) AS all_num \n";
    $sql .= "        FROM \n";
    $sql .= "            t_contents \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            invent_id \n";
    $sql .= "    ) AS contents1 ON t_invent.invent_id = contents1.invent_id \n";
    $sql .= "    LEFT JOIN \n";
    $sql .= "    ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            invent_id, \n";
    $sql .= "            COUNT(goods_id) AS input_num \n";
    $sql .= "        FROM \n";
    $sql .= "            t_contents \n";
    $sql .= "        WHERE \n";
    $sql .= "            staff_id IS NOT NULL \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            invent_id \n";
    $sql .= "    ) AS contents2 ON t_invent.invent_id = contents2.invent_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_invent.renew_flg = false \n";
    $sql .= "    AND \n";
    $sql .= "    t_invent.shop_id = $shop_id \n";
    $sql .= "    AND \n";
    $sql .= "    contents1.all_num != contents2.input_num \n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    //一時登録中の棚卸がない場合
    if(pg_fetch_result($result, 0, 0) == 0){

        //調査表作成日を取得
        $sql = "SELECT ";
        $sql .= "   expected_day";
        $sql .= " FROM";
        $sql .= "   t_invent ";
        $sql .= " WHERE";
        $sql .= "   shop_id = $shop_id";
        $sql .= " AND";
        $sql .= "   renew_flg = 'f'";
        $result = Db_Query($conn, $sql);
        if(pg_num_rows($result) != 0){
            $expected_day = @pg_fetch_result($result,0,0);

            //調査表があった場合
            if($expected_day != null){

                Db_Query($conn, "BEGIN;");

                //棚卸差異を受払に登録
                $sql  = "INSERT INTO \n";
                $sql .= "    t_stock_hand \n";
                $sql .= "( \n";
                $sql .= "    goods_id, \n";         // 1 商品ID
                $sql .= "    enter_day, \n";        // 2 入力日
                $sql .= "    work_day, \n";         // 3 作業実施日
                $sql .= "    work_div, \n";         // 4 作業区分
                $sql .= "    ware_id, \n";          // 5 倉庫ID
                $sql .= "    io_div, \n";           // 6 入出庫区分
                $sql .= "    num, \n";              // 7 数量
                $sql .= "    adjust_price, \n";     // 8 調整単価
                $sql .= "    staff_id, \n";         // 9 作業者ID
                $sql .= "    shop_id, \n";          //10 ショップID
                $sql .= "    adjust_reason \n";     //11 調整理由
                $sql .= ") \n";

                $sql .= "SELECT \n";
                $sql .= "    t_contents.goods_id, \n";
                $sql .= "    CURRENT_TIMESTAMP, \n";
                $sql .= "    t_invent.expected_day, \n";
                $sql .= "    '6', \n";              // 4 作業区分「調整」
                $sql .= "    t_invent.ware_id, \n";
                $sql .= "    CASE \n";              // 6 入出庫区分
                $sql .= "        WHEN (t_contents.tstock_num - t_contents.stock_num) > 0 THEN 1 \n";    //帳簿数より実棚数が多い場合「入庫」
                $sql .= "        ELSE 2 \n";                                                            //それ以外は「出庫」
                $sql .= "    END, \n";
                $sql .= "    ABS(t_contents.tstock_num - t_contents.stock_num), \n";
                $sql .= "    t_price.r_price, \n";
                $sql .= "    ".$_SESSION["staff_id"].", \n";
                $sql .= "    t_invent.shop_id, \n";
                $sql .= "    CASE t_contents.cause \n";
                $sql .= "        WHEN '破損' THEN '2' \n";
                $sql .= "        WHEN '紛失' THEN '3' \n";
                $sql .= "        WHEN '発見' THEN '4' \n";
                $sql .= "        WHEN '在庫記入ミス' THEN '5' \n";
                $sql .= "        WHEN '調整' THEN '7' \n";
                $sql .= "    END \n";
                $sql .= "FROM \n";
                $sql .= "    t_invent \n";
                $sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
                $sql .= "    INNER JOIN t_price ON t_contents.goods_id = t_price.goods_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_invent.shop_id = $shop_id \n";
                $sql .= "    AND \n";
                $sql .= "    t_invent.renew_flg = false \n";
                $sql .= "    AND \n";
                $sql .= "    (t_contents.tstock_num - t_contents.stock_num) != 0 \n";
                $sql .= "    AND \n";
                if($group_kind == "1"){
                    //調整単価は本部は「付加」を登録
                    $sql .= "    t_price.rank_cd = '1' \n";
                }else{
                    //調整単価はFCは「在庫単価」を登録
                    $sql .= "    t_price.rank_cd = '3' \n";
                }
                $sql .= "    AND \n";
                $sql .= "    t_price.shop_id = $shop_id \n";

                $sql .= ";";

                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }


                //棚卸ヘッダテーブル更新
                $sql  = " UPDATE t_invent SET ";
                $sql .= "   renew_flg = 't',";
                $sql .= "   renew_time = NOW(),";
                $sql .= "   staff_name = (SELECT t_staff.staff_name FROM t_staff WHERE t_staff.staff_id = t_invent.staff_id)";
                $sql .= " WHERE ";
                $sql .= "   shop_id = $shop_id";
                $sql .= " AND";
                $sql .= "   renew_flg = 'f'";
                $sql .= " ;";
                $result = Db_Query($conn, $sql);

                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

                //更新処理履歴テーブルに登録
                $sql  = " INSERT INTO t_sys_renew( ";
                $sql .= "    renew_id,";
                $sql .= "    renew_div,";
                $sql .= "    renew_time,";
                $sql .= "    close_day,";            //調査表作成日
                $sql .= "    shop_id";
                $sql .= ")VALUES(";
                $sql .= "    (SELECT COALESCE(MAX(renew_id), 0)+1 FROM t_sys_renew),";
                $sql .= "    '4',";
                $sql .= "    NOW(),";
                $sql .= "    '$expected_day',";
                $sql .= "    '$shop_id'";
                $sql .= ");";
                $result = Db_Query($conn, $sql);

                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
                Db_Query($conn, "COMMIT;");
            header("Location: ".$pre_url."?done=t");
            }
        }else{
            $exec_err_mess = "更新可能な棚卸調査表はありません。";
        }

    //一時登録中の棚卸がある場合、エラーメッセージ表示
    }else{
        $temp_err_mess = "一時登録中の棚卸調査表があります。";
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
//$page_menu = Create_Menu_f('renew','1');

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
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'renew_before'  => "$renew_before",
    'complete_msg'  => "$complete_msg",
    'exec_err_mess' => "$exec_err_mess",
    'temp_err_mess' => "$temp_err_mess",
));

$smarty->assign("page_data",$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
