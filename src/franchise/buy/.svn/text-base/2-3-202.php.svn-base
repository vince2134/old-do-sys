<?php
/*
 * 変更履歴
 * 1.0.0 (2006/04/12) 削除の際に、発注データのステータス変更(suzuki-t)
 *       (2006/05/17) 発注から起こしたデータは発注日も表示する。    
 *       (2006/09/25) 仕入日で検索した場合に、ページ遷移後、データがきちんと表示されないバグの修正＜watanabe-k＞
 *       (2006\)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-100      ふ          削除後のリロードで最新伝票が削除されてしまうバグを修正
 *  2006/11/11      03-091      ふ          日次更新済の仕入伝票が削除されないよう修正
 *  2006/12/07      ban_0040    suzuki      日付のゼロ埋め
 *  2007/03/05      作業項目12  ふくだ      掛・現金の合計を出力
 *  2007-05-07                  fukuda      ソート順を日付の昇順に変更
 *  2007-06-21                  fukuda      合計行の額を＋と−に分割
 *  2007-08-06                  watanabe-k  CSVを出力
 *  2007-08-30                  watanabe-k  仕入削除時の強制完了が解除されないバグの修正
 *  2008-08-02                  watanabe-k  部署を選択した場合にクエリエラーが表示されるバグの修正
 *
 *
 */

$page_title = "仕入照会";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_output_type"      => "1", 
    "form_client_branch"    => "",
    "form_attach_branch"    => "",
    "form_client"           => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_c_staff"          => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_buy_day"          => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_trade"            => "",
    "form_multi_staff"      => "",
    "form_ware"             => "",
    "form_slip_no"          => array("s" => "", "e" => ""),
    "form_renew"            => "1",
    "form_ord_no"           => array("s" => "", "e" => ""),
    "form_ord_day"          => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_goods"            => array("cd" => "", "name" => ""), 
    "form_g_goods"          => "",  
    "form_product"          => "",  
    "form_g_product"        => "",  
    "form_buy_amount"       => array("s" => "", "e" => ""),
);

// 検索条件復元
Restore_Filter2($form, array("buy", "ord"), "show_button", $ary_form_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$buy_id     = $_POST["buy_h_id"];


/****************************/
// 初期値設定
/****************************/
$form->setDefaults($ary_form_list);

$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // 全件数
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // 表示ページ数


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form_Buy($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 伝票番号（開始〜終了）
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_slip_no", "", "");

// 日次更新
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未実施", "2");
$obj[]  =&  $form->createElement("radio", null, null, "実施済", "3");
$form->addGroup($obj, "form_renew", "", "");

// 発注番号（開始〜終了）
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "s", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", "〜");
$obj[]  =&  $form->createElement("text", "e", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($obj, "form_ord_no", "", "");

// 発注日（開始〜終了）
Addelement_Date_Range($form, "form_ord_day", "発注日", "-");

// 商品
$obj    =   null;
$obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"15\" $g_form_option");
$form->addGroup($obj, "form_goods", "", "");

// Ｍ区分
$item   =   null;
$item   =   Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods", "", $item, $g_form_option_select);

// 管理区分
$item   =   null;
$item   =   Select_Get($db_con, "product");
$form->addElement("select", "form_product", "", $item, $g_form_option_select);

// 商品分類
$item   =   null;
$item   =   Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "", $item, $g_form_option_select);

// 仕入金額（税込）（開始〜終了）
Addelement_Money_Range($form, "form_buy_amount", "", "");

// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "仕入先コード",
    "sl_client_name"    => "仕入先名",
    "sl_slip"           => "伝票番号",
    "sl_buy_day"        => "仕入日",
    "sl_ord_no"         => "発注番号",
    "sl_ord_day"        => "発注日",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_buy_day");

// 表示
$form->addElement("submit", "show_button", "表　示",
    "onClick=\"javascript:Which_Type('form_output_type','2-3-203.php','".$_SERVER["PHP_SELF"]."');\""
);

// クリア
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// 入力
$form->addElement("button", "new_button", "入　力","onClick=\"location.href('2-3-201.php')\"");

// 照会
$form->addElement("button", "chg_button", "照会・変更", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 処理フラグhidden
$form->addElement("hidden","data_delete_flg");
$form->addElement("hidden","buy_h_id");
$form->addElement("hidden","hdn_del_enter_date");

// エラーメッセージ埋め込み用フォーム
$form->addElement("text", "err_renew_slip");


/****************************/
//削除リンク押下処理
/****************************/
if($_POST["data_delete_flg"] == "true"){

    // 選択された伝票の作成日時を取得
    $enter_date = $_POST["hdn_del_enter_date"];

    // 選択された伝票が正当か（伝票作成日時を元に）調べる
    $valid_flg = Update_check($db_con, "t_buy_h", "buy_id", $buy_id, $enter_date);

    // 正当な場合のみ処理を行う
    if ($valid_flg == true){

        // 日次更新が行われていないか調べる（日次更新済→renew_flg = false）
        $renew_flg = Renew_Check($db_con, "t_buy_h", "buy_id", $buy_id);

        // 日次更新済の場合
        if ($renew_flg == false){

            // 日次更新済の場合のエラーメッセージをセット
            $form->setElementError("err_renew_slip", "日次更新処理が行われている為、削除できません。");

        // 日次更新未実施の場合
        }else{

            // 仕入データの基になる、発注データIDを取得するSQL
            $sql  = "SELECT\n";
            $sql .= "   t_order_d.ord_d_id,\n";
            $sql .= "   rest_flg, \n";
            $sql .= "   finish_flg, \n";
            $sql .= "   t_buy_d.num \n";
            $sql .= "FROM\n";
            $sql .= "   t_buy_d\n";
            $sql .= "       LEFT JOIN\n";
            $sql .= "   t_order_d\n";
            $sql .= "   ON t_buy_d.ord_d_id = t_order_d.ord_d_id\n";
            $sql .= "WHERE\n";
            $sql .= "   buy_id = $buy_id;";

            $result   = Db_Query($db_con, $sql);
            $ord_d_data = pg_fetch_all($result);
            Db_Query($db_con, "BEGIN;");
            for($i = 0; $i < count($ord_d_data); $i++){
                //発注データに対する、発注ID取得

                if($ord_d_data[$i]["ord_d_id"] != NULL){
                    $sql  = "SELECT ";
                    $sql .= "    ord_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_order_d ";
                    $sql .= "WHERE ";
                    $sql .= "    ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";
                    $result = Db_Query($db_con,$sql);
                    $ord_id = Get_Data($result);

                    //仕入が分納されているか判定
                    $sql  = "SELECT ";
                    $sql .= "    buy_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_buy_h ";
                    $sql .= "WHERE ";
                    $sql .= "    ord_id = ".$ord_id[0][0].";";
                    $result = Db_Query($db_con,$sql);
                    if(pg_numrows($result) == 1){
                        //分納していない場合は未処理
                        $ps_stat = '1';
                    }else{
                        //分納している場合は処理中
                        $ps_stat = '2';
                    }
        
                    //該当する発注データの発注残フラグを初期化
                    //仕入数が０ ＆＆　強制完了未実施　＆＆　発注残無し
                    if($ord_d_data[$i]["rest_flg"] == "f" && $ord_d_data[$i]["finish_flg"] == "f" && $ord_d_data[$i]["num"] == "0"){
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        reason = null,
                                        rest_flg = 'f',
                                        finish_flg = 'f' 
                                    WHERE 
                                        ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql3    = "UPDATE t_order_h SET ps_stat = $ps_stat, finish_flg = 'f' WHERE ord_id = ".$ord_id[0][0].";";
                    //仕入数が０ ＆＆　強制完了実施　＆＆　発注残無し
                    }elseif($ord_d_data[$i]["rest_flg"] == "f" && $ord_d_data[$i]["finish_flg"] == "t" && $ord_d_data[$i]["num"] == "0"){

                        //仕入を分納している場合
                        if($ps_stat == "2"){
                            $rest_flg   = 'f';  
                            $finish_flg = 't';
                        }else{  
                            //仕入を分納していない場合は強制完了を解除
                            $reason     = 'reason = null,';
                            $rest_flg   = 't';  
                            $finish_flg = 'f';
                            $sql2 = "DELETE FROM t_stock_hand WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"]." AND work_div = '3' AND io_div = '2'";
                        }
  
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        $reason
                                        rest_flg = '$rest_flg', 
                                        finish_flg = '$finish_flg' 
                                    WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql4    = "UPDATE t_order_h SET ps_stat = $ps_stat WHERE ord_id = ".$ord_id[0][0].";";

                    //上記以外
                    }else{
                        $sql     = "UPDATE 
                                        t_order_d 
                                    SET 
                                        reason = null,
                                        rest_flg = 't', 
                                        finish_flg = 'f' 
                                    WHERE 
                                        ord_d_id = ".$ord_d_data[$i]["ord_d_id"].";";

                        $sql3    = "UPDATE t_order_h SET ps_stat = $ps_stat, finish_flg = 'f' WHERE ord_id = ".$ord_id[0][0].";";

                        //強制完了を行っている場合
                        if($ord_d_data[$i]["finish_flg"] == "t"){
                            $sql2 = "DELETE FROM t_stock_hand WHERE ord_d_id = ".$ord_d_data[$i]["ord_d_id"]." AND work_div = '3' AND io_div = '2'";
                        }
                    }

 
                    $result  = Db_Query($db_con, $sql);
                    if($result == false){ 
                        Db_Query($db_con, "ROLLBACK;");
                        exit;   
                    }       
                }
            }

            if($sql2 != null){
                $result = Db_Query($db_con, $sql2);
                if($result == "false"){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }
            if($sql4 != null ){
                //該当する発注ヘッダの処理状況を変更
                $result = Db_Query($db_con,$sql4);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }elseif($sql3 != null){
                //該当する発注ヘッダの処理状況を変更
                $result = Db_Query($db_con,$sql3);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }

            $delete_renew_flg = true;
    
            $data_delete  = " DELETE FROM ";
            $data_delete .= "   t_buy_h ";
            $data_delete .= "   where ";
            $data_delete .= "   buy_id = $_POST[buy_h_id] ";
            $data_delete .= ";";
            $result = @Db_Query($db_con, $data_delete);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                print $data_delete;
                exit;
            }
            Db_Query($db_con, "COMMIT;");

        }

    }

    $set_date["data_delete_flg"]    = "";
    $set_date["hdn_del_enter_date"] = "";
    $form->setConstants($set_date);

    $post_flg = true;

}


/****************************/
// 表示ボタン押下処理
/****************************/
if ($_POST["show_button"] == "表　示"){

    // 日付POSTデータの0埋め
    $_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    /****************************/
    // エラーチェック
    /****************************/
    // ■仕入担当者
    $err_msg = "仕入担当者 は数値のみ入力可能です。";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ■仕入日
    $err_msg = "仕入日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_buy_day", $err_msg);

    // ■仕入担当者（複数選択）
    $err_msg = "仕入担当者（複数選択） は数値と「,」のみ入力可能です。";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ■発注日
    $err_msg = "発注日 の日付が妥当ではありません。";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ■仕入金額
    $err_msg = "仕入金額 は数値のみ入力可能です。";
    Err_Chk_Int($form, "form_buy_amount", $err_msg);

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $form->validate();
    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}

/****************************/
// 1. 表示ボタン押下＋エラーなし時
// 2. ページ切り替え時
/****************************/
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){

    // 日付POSTデータの0埋め
    $_POST["form_buy_day"] = Str_Pad_Date($_POST["form_buy_day"]);
    $_POST["form_ord_day"] = Str_Pad_Date($_POST["form_ord_day"]);

    // 1. フォームの値を変数にセット
    // 2. SESSION（hidden用）の値（検索条件復元関数内でセット）を変数にセット
    // 一覧取得クエリ条件に使用
    $display_num    = $_POST["form_display_num"];
    $output_type    = $_POST["form_output_type"];
    $client_branch  = $_POST["form_client_branch"];
    $attach_branch  = $_POST["form_attach_branch"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $part           = $_POST["form_part"];
    $buy_day_sy     = $_POST["form_buy_day"]["sy"];
    $buy_day_sm     = $_POST["form_buy_day"]["sm"];
    $buy_day_sd     = $_POST["form_buy_day"]["sd"];
    $buy_day_ey     = $_POST["form_buy_day"]["ey"];
    $buy_day_em     = $_POST["form_buy_day"]["em"];
    $buy_day_ed     = $_POST["form_buy_day"]["ed"];
    $trade          = $_POST["form_trade"];
    $multi_staff    = $_POST["form_multi_staff"];
    $ware           = $_POST["form_ware"];
    $slip_no_s      = $_POST["form_slip_no"]["s"];
    $slip_no_e      = $_POST["form_slip_no"]["e"];
    $renew          = $_POST["form_renew"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $goods_cd       = $_POST["form_goods"]["cd"];
    $goods_name     = $_POST["form_goods"]["name"];
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $buy_amount_s   = $_POST["form_buy_amount"]["s"];
    $buy_amount_e   = $_POST["form_buy_amount"]["e"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // 顧客担当支店
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n"; 
        $sql .= "   ) \n";
    }
    // 所属本支店
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.c_staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // 仕入先コード1
    $sql .= ($client_cd1 != null) ? "AND t_buy_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // 仕入先コード2
    $sql .= ($client_cd2 != null) ? "AND t_buy_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    // 仕入先名
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_buy_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_buy_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_buy_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // 仕入担当者コード
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // 仕入担当者セレクト
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // 部署
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // 仕入日（開始）
    $buy_day_s = $buy_day_sy."-".$buy_day_sm."-".$buy_day_sd;
    $sql .= ($buy_day_s != "--") ? "AND '$buy_day_s' <= t_buy_h.buy_day \n" : null;
    // 仕入日（終了）
    $buy_day_e = $buy_day_ey."-".$buy_day_em."-".$buy_day_ed;
    $sql .= ($buy_day_e != "--") ? "AND t_buy_h.buy_day <= '$buy_day_e' \n" : null;
    // 取引区分
    $sql .= ($trade != null) ? "AND t_buy_h.trade_id = $trade \n" : null;
    // 仕入担当者（複数選択）
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // 倉庫
    $sql .= ($ware != null) ? "AND t_buy_h.ware_id = $ware \n" : null;
    // 伝票番号（開始）
    $sql .= ($slip_no_s != null) ? "AND t_buy_h.buy_no >= '".str_pad($slip_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 伝票番号（終了）
    $sql .= ($slip_no_e != null) ? "AND t_buy_h.buy_no <= '".str_pad($slip_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 日次更新
    if ($renew == "2"){
        $sql .= "AND t_buy_h.renew_flg = 'f' \n";
    }elseif ($renew == "3"){
        $sql .= "AND t_buy_h.renew_flg = 't' \n";
    }
    // 発注番号（開始）
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 発注番号（終了）
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // 発注日（開始）
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND '$ord_day_s 00:00:00' <= t_order_h.ord_time \n" : null;
    // 発注日（終了）
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // 商品コード
    if ($goods_cd != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "                          AND t_buy_d.goods_cd LIKE '$goods_cd%' \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // 商品名
    if ($goods_name != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "                          AND t_buy_d.goods_name LIKE '%$goods_name%' \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // Ｍ区分
    if ($g_goods != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_goods_id = $g_goods \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // 管理区分
    if ($product != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON  t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.product_id = $product \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // 商品分類
    if ($g_product != null){
        $sql .= "AND \n";
        $sql .= "   t_buy_h.buy_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT t_buy_h.buy_id FROM t_buy_h \n";
        $sql .= "       INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "       INNER JOIN t_goods ON  t_buy_d.goods_id = t_goods.goods_id \n";
        $sql .= "                          AND t_goods.g_product_id = $g_product \n";
        $sql .= "       GROUP BY t_buy_h.buy_id \n";
        $sql .= "   ) \n";
    }
    // 仕入金額（税込）（開始）
    if ($buy_amount_s != null){
        $sql .= "AND \n";
        $sql .= "   $buy_amount_s <= \n";
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
        $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
        $sql .= "   END \n";
    }
    // 仕入金額（税込）（終了）
    if ($buy_amount_e != null){
        $sql .= "AND \n";
        $sql .= "   $buy_amount_e >= \n";
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "       THEN (t_buy_h.net_amount + t_buy_h.tax_amount) \n";
        $sql .= "       ELSE (t_buy_h.net_amount + t_buy_h.tax_amount) * -1 \n";
        $sql .= "   END \n";
    }
    // 変数詰め替え
    $where_sql = $sql;


    $sql = null;

    // ソート順
    switch ($_POST["hdn_sort_col"]){
        // 仕入先コード
        case "sl_client_cd":
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no \n";
            break;  
        // 仕入先名
        case "sl_client_name":
            $sql .= "   t_buy_h.client_cname, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // 伝票番号
        case "sl_slip":
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // 仕入日
        case "sl_buy_day":
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // 発注番号
        case "sl_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
        // 発注日
        case "sl_ord_day":
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_buy_h.buy_no, \n";
            $sql .= "   t_buy_h.buy_day, \n";
            $sql .= "   t_buy_h.client_cd1, \n";
            $sql .= "   t_buy_h.client_cd2 \n";
            break;  
    }

    // 変数詰め替え
    $order_sql = $sql; 

}


/****************************/
// 一覧データ取得
/****************************/
if ($post_flg == true && $err_flg != true && $output_type != '3'){

    $sql  = "SELECT \n";
    if ($group_kind == "2"){
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL \n";
    $sql .= "       THEN t_buy_h.client_cd1||'-'||t_buy_h.client_cd2 \n";
    $sql .= "       ELSE t_buy_h.client_cd1 \n";
    $sql .= "   END \n";
    $sql .= "   AS client_cd1, \n";
    }else{
    $sql .= "   t_buy_h.client_cd1, \n";
    }
    $sql .= "   t_buy_h.client_cname, \n";
    $sql .= "   t_buy_h.buy_id, \n";
    $sql .= "   t_buy_h.buy_no, \n";
    $sql .= "   t_buy_h.buy_day, \n";
    $sql .= "   t_buy_h.trade_id, \n";
    $sql .= "   t_buy_h.net_amount, \n";
    $sql .= "   t_buy_h.tax_amount, \n";
    $sql .= "   t_buy_h.net_amount + t_buy_h.tax_amount AS intax_amount, \n";
    $sql .= "   t_order_h.ord_id, \n";
    $sql .= "   t_order_h.ord_no, \n";
    $sql .= "   t_buy_h.renew_flg, \n";
    $sql .= "   t_order_h.finish_flg, \n";
    $sql .= "   to_char(t_order_h.ord_time,'yyyy-mm-dd'), \n";
    $sql .= "   t_buy_h.total_split_num, \n";
    $sql .= "   to_char(t_buy_h.renew_day, 'yyyy-mm-dd'), \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN intro_sale_id IS NOT NULL OR act_sale_id IS NOT NULL \n";
    $sql .= "       THEN 't'\n";
    $sql .= "       ELSE 'f' \n";
    $sql .= "   END \n";
    $sql .= "   AS intro_act_flg, \n";
    $sql .= "   t_buy_h.enter_day, \n";
    if ($group_kind == "2"){
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL \n";
    $sql .= "       THEN 't' \n";
    $sql .= "       ELSE 'f' \n";
    $sql .= "   END \n";
    $sql .= "   AS fc_flg \n";
    }else{
    $sql .= "   'f' \n";
    }
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   LEFT  JOIN t_order_h    ON t_buy_h.ord_id = t_order_h.ord_id \n";
    $sql .= "   LEFT  JOIN t_staff      ON t_buy_h.c_staff_id = t_staff.staff_id \n";

	//部署が選択された場合
	if($part){
		$sql .= "	LEFT  JOIN t_attach	ON t_staff.staff_id = t_attach.staff_id AND t_attach.shop_id = $shop_id ";
	}

    $sql .= "   LEFT JOIN t_sale_h AS t_act_sale_h ON t_buy_h.act_sale_id = t_act_sale_h.sale_id \n";
    $sql .= "   LEFT JOIN t_sale_h AS t_intro_sale_h ON t_buy_h.intro_sale_id = t_intro_sale_h.sale_id \n";

    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    // 全件数取得
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);
    $limit          = $total_count;

    // OFFSET条件作成
    if ($post_flg == true && $err_flg != true){

        // 表示件数
        switch ($display_num){
            case "1":
                $limit = $total_count;
                break;
            case "2":
                $limit = "100";
                break;
        }

        // 取得開始位置
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // 行削除でページに表示するレコードが無くなる場合の対処
        if($page_count != null){
            // 行削除でtotal_countとoffsetの関係が崩れた場合
            if ($total_count <= $offset){
                // オフセットを選択件前に
                $offset     = $offset - $limit;
                // 表示するページを1ページ前に（一気に2ページ分削除されていた場合などには対応してないです）
                $page_count = $page_count - 1;
                // 選択件数以下時はページ遷移を出力させない(nullにする)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }
        }else{
            $offset = 0;
        }

    }

    // ページ内データ取得
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

#print_array($sql);
    /****************************/
    // 取得データの整形等
    /****************************/
    //合計金額計算
    for($i = 0; $i < $row_count; $i++){
        if($page_data[$i][5] == '21' || $page_data[$i][5] == '71' || $page_data[$i][5] == '25'){
            $sum1 = bcadd($sum1,$page_data[$i][6],2);
            $sum2 = bcadd($sum2,$page_data[$i][7],2);
            $sum3 = bcadd($sum3,$page_data[$i][8],2);
        }else{
            $sum1 = bcsub($sum1,$page_data[$i][6],2);
            $sum2 = bcsub($sum2,$page_data[$i][7],2);
            $sum3 = bcsub($sum3,$page_data[$i][8],2);
        }
    }
    $sum1 = number_format($sum1);
    $sum2 = number_format($sum2);
    $sum3 = number_format($sum3);

    //仕入金額・消費税額のカンマ
    for($i = 0; $i < $row_count; $i++){

        // 掛・現金の合計算出
        switch ($page_data[$i][5]){
            case "21":
            case "25":
                $kake_nuki_amount   += $page_data[$i][6];
                $kake_tax_amount    += $page_data[$i][7];
                $kake_komi_amount   += $page_data[$i][8];
                break;  
            case "23":
            case "24":
                $kake_nuki_amount   -= $page_data[$i][6];
                $kake_tax_amount    -= $page_data[$i][7];
                $kake_komi_amount   -= $page_data[$i][8];
                break;  
            case "71":
                $genkin_nuki_amount += $page_data[$i][6];
                $genkin_tax_amount  += $page_data[$i][7];
                $genkin_komi_amount += $page_data[$i][8];
                break;  
            case "73":
            case "74":
                $genkin_nuki_amount -= $page_data[$i][6];
                $genkin_tax_amount  -= $page_data[$i][7];
                $genkin_komi_amount -= $page_data[$i][8];
                break;  
        }

        // 合計行用の金額算出
        switch ($page_data[$i][5]){
            case "21":
            case "25":
                $gross_notax_amount += $page_data[$i][6];
                $gross_tax_amount   += $page_data[$i][7];
                $gross_ontax_amount += $page_data[$i][8];
                break;  
            case "23":
            case "24":
                $minus_notax_amount -= $page_data[$i][6];
                $minus_tax_amount   -= $page_data[$i][7];
                $minus_ontax_amount -= $page_data[$i][8];
                break;  
            case "71":
                $gross_notax_amount += $page_data[$i][6];
                $gross_tax_amount   += $page_data[$i][7];
                $gross_ontax_amount += $page_data[$i][8];
                break;  
            case "73":
            case "74":
                $minus_notax_amount -= $page_data[$i][6];
                $minus_tax_amount   -= $page_data[$i][7];
                $minus_ontax_amount -= $page_data[$i][8];
                break;  
        }

        if (!($page_data[$i][5] == '21' || $page_data[$i][5] == '71' || $page_data[$i][5] == '25')){
            $page_data[$i][6] = $page_data[$i][6]*(-1);
            $page_data[$i][7] = $page_data[$i][7]*(-1);
            $page_data[$i][8] = $page_data[$i][8]*(-1);
        }
            $page_data[$i][6] = number_format($page_data[$i][6]);
            $page_data[$i][7] = number_format($page_data[$i][7]);
            $page_data[$i][8] = number_format($page_data[$i][8]);
        if($page_data_f[$i][5] == '21' || $page_data_f[$i][5] == '71' || $page_data_f[$i][5] == '25'){
            $sum_all1 = bcadd($sum_all1,$page_data_f[$i][6]);
            $sum_all2 = bcadd($sum_all2,$page_data_f[$i][7]);
            $sum_all3 = bcadd($sum_all3,$page_data_f[$i][8]);
            $page_data_f[$i][6]    = number_format($page_data_f[$i][6]);       //仕入金額(税抜)
            $page_data_f[$i][7]    = number_format($page_data_f[$i][7]);       //消費税額
            $page_data_f[$i][8]    = number_format($page_data_f[$i][8]);       //仕入金額(税込)
        }else if($page_data_f[$i][5] == '22' || $page_data_f[$i][5] == '23' || $page_data_f[$i][5] == '24' || $page_data_f[$i][5] == '72' || $page_data_f[$i][5] == '73' || $page_data_f[$i][5] == '74'){
            $sum_all1 = bcsub($sum_all1,$page_data_f[$i][6]);
            $sum_all2 = bcsub($sum_all2,$page_data_f[$i][7]);
            $sum_all3 = bcsub($sum_all3,$page_data_f[$i][8]);
            $page_data_f[$i][6]    = number_format($page_data_f[$i][6]);       //仕入金額(税抜)
            $page_data_f[$i][7]    = number_format($page_data_f[$i][7]);       //消費税額
            $page_data_f[$i][8]    = number_format($page_data_f[$i][8]);       //仕入金額(税込)
        }

        //取引区分を置換
        if($page_data[$i][5] == "21"){
            $page_data[$i][5] = "掛仕入";
        }elseif($page_data[$i][5] == "23"){
            $page_data[$i][5] = "掛返品";
        }elseif($page_data[$i][5] == "24"){
            $page_data[$i][5] = "掛値引";
        }elseif($page_data[$i][5] == "25"){
            $page_data[$i][5] = "割賦仕入";
        }elseif($page_data[$i][5] == "71"){
            $page_data[$i][5] = "現金仕入";
        }elseif($page_data[$i][5] == "73"){
            $page_data[$i][5] = "現金返品";
        }elseif($page_data[$i][5] == "74"){
            $page_data[$i][5] = "現金値引";
        }

        //ダイアログに出力するメッセージ
        if($page_data[$i][12] == 't'){
            $dialog_message = "伝票の削除と強制完了取り消しを行います。";
        }else{
            $dialog_message = "削除します。";
        }

        if($page_data[$i][11] != 't'){
            $order_delete .= " function Order_Delete".$i."(hidden1,hidden2,buy_id,hidden3,enter_date){\n";
            $order_delete .= "    res = window.confirm(\"".$dialog_message."\\nよろしいですか？\");\n";
            $order_delete .= "    if (res == true){\n";
            $order_delete .= "        var id    = buy_id;\n";
            $order_delete .= "        var edate = enter_date;\n";
            $order_delete .= "        var hdn1  = hidden1;\n";
            $order_delete .= "        var hdn2  = hidden2;\n";
            $order_delete .= "        var hdn3  = hidden3;\n";
            $order_delete .= "        document.dateForm.elements[hdn1].value = 'true';\n";
            $order_delete .= "        document.dateForm.elements[hdn2].value = id;\n";
            $order_delete .= "        document.dateForm.elements[hdn3].value = edate;\n";
            $order_delete .= "        // 同じウィンドウで遷移する\n";
            $order_delete .= "        document.dateForm.target=\"_self\";\n";
            $order_delete .= "        // 自画面に遷移する\n";
            $order_delete .= "        document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
            $order_delete .= "        // POST情報を送信する\n";
            $order_delete .= "        document.dateForm.submit();\n";
            $order_delete .= "        return true;\n";
            $order_delete .= "    }else{\n";
            $order_delete .= "        return false;\n";
            $order_delete .= "    }\n";
            $order_delete .= "}\n";
        }
    }
//CSV出力の場合
}elseif($output_type == '3'){
    $sql  = "SELECT \n";
    $sql .= "   CASE t_buy_h.buy_div \n";
    $sql .= "      WHEN '1' THEN t_buy_h.client_cd1 \n";
    $sql .= "      WHEN '2' THEN t_buy_h.client_cd1 || '-' || t_buy_h.client_cd2 \n";
    $sql .= "   END AS client_cd1, \n";         // 0    仕入先コード
    $sql .= "   t_buy_h.client_cname, \n";      // 1    仕入先名
    $sql .= "   t_buy_h.buy_no, \n";            // 2    仕入番号
    $sql .= "   t_buy_h.buy_day, \n";           // 3    仕入日
    $sql .= "   t_buy_h.arrival_day, \n";       // 4    入荷日
    $sql .= "   t_trade.trade_name, \n";        // 5    取引区分
    $sql .= "   t_buy_h.direct_name, \n";       // 6    直送先名
    $sql .= "   t_buy_h.ware_name, \n";         // 7    倉庫名
    $sql .= "   t_buy_h.c_staff_name, \n";      // 8    仕入担当者
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_h.net_amount ";
    $sql .= "       ELSE t_buy_h.net_amount ";
    $sql .= "   END AS trade_net_amount, \n";   // 9    仕入金額
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_h.tax_amount ";
    $sql .= "       ELSE t_buy_h.tax_amount ";
    $sql .= "   END AS trade_tax_amount, \n";   //10    消費税額
    $sql .= "   (t_buy_h.net_amount + t_buy_h.tax_amount) * CASE \n";
    $sql .= "                               WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 ";
    $sql .= "                               ELSE 1 \n";
    $sql .= "                            END AS all_amount, ";  //11    仕入金額（税込）
    $sql .= "   t_buy_d.goods_cd, \n";          //15    商品コード
    $sql .= "   t_buy_d.goods_name, \n";        //14    商品名
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,73) THEN -1 * t_buy_d.num ";
    $sql .= "       ELSE t_buy_d.num ";
    $sql .= "   END AS num, \n";                //15    数量
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (24,74) THEN -1 * t_buy_d.buy_price ";
    $sql .= "       ELSE t_buy_d.buy_price ";
    $sql .= "   END AS buy_price, \n";          //16    単価
    $sql .= "   CASE  \n";
    $sql .= "       WHEN t_buy_h.trade_id IN (23,24,73,74) THEN -1 * t_buy_d.buy_amount ";
    $sql .= "       ELSE t_buy_d.buy_amount ";
    $sql .= "   END AS buy_amount,";             //17    仕入金額

    $sql .= "   CASE t_buy_h.trade_id ";
    $sql .= "       WHEN '25' THEN t_buy_h.total_split_num ";
    $sql .= "   END AS total_split_num,\n";     //18    分割回数

    $sql .= "   to_char(t_buy_h.renew_day, 'yyyy-mm-dd') AS renew_day \n";  //19    //日次更新日
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_trade \n";
    $sql .= "   ON t_buy_h.trade_id = t_trade.trade_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_staff \n";
    $sql .= "   ON t_buy_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "       INNER JOIN \n";
    $sql .= "   t_buy_d \n";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id \n";
	//部署が選択された場合
	if($part){
		$sql .= "	LEFT  JOIN t_attach	ON t_staff.staff_id = t_attach.staff_id AND t_attach.shop_id = $shop_id ";
	}
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data = pg_fetch_all($result);

    $csv_file_name = "仕入照会.csv";
    $csv_header = array(
            "仕入先コード",
            "仕入先名",
            "伝票番号",
            "仕入日",
            "入荷日",
            "取引区分",
            "直送先名",
            "倉庫名",
            "仕入担当者",
            "仕入金額（税抜）",
            "消費税額",
            "仕入金額（税込）",
            "商品コード",
            "商品名",
            "数量",
            "仕入単価",
            "仕入金額",
            "分割回数",
            "日次更新"
    );

    //CSVデータ取得
    for($i=0;$i<count($page_data);$i++){
        $buy_data[$i][0]  = $page_data[$i]["client_cd1"];
        $buy_data[$i][1]  = $page_data[$i]["client_cname"];
        $buy_data[$i][2]  = $page_data[$i]["buy_no"];
        $buy_data[$i][3]  = $page_data[$i]["buy_day"];
        $buy_data[$i][4]  = $page_data[$i]["arrival_day"];
        $buy_data[$i][5]  = $page_data[$i]["trade_name"];
        $buy_data[$i][6]  = $page_data[$i]["direct_name"];
        $buy_data[$i][7]  = $page_data[$i]["ware_name"];
        $buy_data[$i][8]  = $page_data[$i]["c_staff_name"];
        $buy_data[$i][9]  = $page_data[$i]["trade_net_amount"];
        $buy_data[$i][10] = $page_data[$i]["trade_tax_amount"];
        $buy_data[$i][11] = $page_data[$i]["all_amount"];
        $buy_data[$i][12] = $page_data[$i]["goods_cd"];
        $buy_data[$i][13] = $page_data[$i]["goods_name"];
        $buy_data[$i][14] = $page_data[$i]["num"];
        $buy_data[$i][15] = $page_data[$i]["buy_price"];
        $buy_data[$i][16] = $page_data[$i]["buy_amount"];
        $buy_data[$i][17] = $page_data[$i]["total_split_num"];
        $buy_data[$i][18] = $page_data[$i]["renew_day"];
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($buy_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;


}



/****************************/
// HTML作成（検索部）
/****************************/
// モジュール個別テーブルの共通部分１
$html_s_tps  = "<br style=\"font-size: 4px;\">\n";
$html_s_tps .= "\n";
$html_s_tps .= "<table class=\"Table_Search\">\n";
$html_s_tps .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"300px\">\n";
$html_s_tps .= "    <col width=\"100px\" style=\"font-weight: bold;\">\n";
$html_s_tps .= "    <col width=\"250px\">\n";
$html_s_tps .= "    <tr>\n";
// モジュール個別テーブルの共通部分２
$html_s_tpe .= "    </tr>\n";
$html_s_tpe .= "</table>\n";
$html_s_tpe .= "\n";

// 共通検索テーブル
$html_s .= Search_Table_Buy($form);
// モジュール個別検索テーブル１
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">伝票番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_slip_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">日次更新</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_renew"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// モジュール個別検索テーブル２
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">発注番号</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_no"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">発注日</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_ord_day"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// モジュール個別検索テーブル３
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">商品</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_goods"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">Ｍ区分</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_g_goods"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// モジュール個別検索テーブル４
$html_s .= $html_s_tps;
$html_s .= "        <td class=\"Td_Search_3\">管理区分</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_product"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">商品分類</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_g_product"]]->toHtml()."</td>\n";
$html_s .= $html_s_tpe;
// モジュール個別検索テーブル５
$html_s .= "<br style=\"font-size: 4px;\">\n";
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">仕入金額<br>（税込）</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_buy_amount"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// ボタン
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."　\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";


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
$page_menu = Create_Menu_f("buy", "2");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[chg_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
// ページ作成
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'     => "$html_header",
    'page_menu'       => "$page_menu",
    'page_header'     => "$page_header",
    'html_footer'     => "$html_footer",
    'html_page'       => "$html_page",
    'html_page2'      => "$html_page2",
    'buy_day_err'     => "$buy_day_err",
    'sum1'            => "$sum1",
    'sum2'            => "$sum2",
    'sum3'            => "$sum3",
    'sum_all1'        => "$sum_all1",
    'sum_all2'        => "$sum_all2",
    'sum_all3'        => "$sum_all3",
    'total_count'     => "$total_count",
    'order_delete'    => "$order_delete",
    'buy_all_day_err' => "$buy_all_day_err",
    'ord_all_day_err' => "$ord_all_day_err",
    'hidden_submit'   => "$hidden_submit",
    'row_count'       => "$row_count",
    'javascript'      => "$javascript",
    "auth_r"          => $auth[0],
    "no"                => ($page_count * $limit - $limit) + 1,
    "kake_nuki_amount"      => number_format($kake_nuki_amount),
    "kake_tax_amount"       => number_format($kake_tax_amount),
    "kake_komi_amount"      => number_format($kake_komi_amount),
    "genkin_nuki_amount"    => number_format($genkin_nuki_amount),
    "genkin_tax_amount"     => number_format($genkin_tax_amount),
    "genkin_komi_amount"    => number_format($genkin_komi_amount),
    "total_nuki_amount"     => number_format($kake_nuki_amount + $genkin_nuki_amount),
    "total_tax_amount"      => number_format($kake_tax_amount + $genkin_tax_amount),
    "total_komi_amount"     => number_format($kake_komi_amount + $genkin_komi_amount),
    "post_flg"              => "$post_flg",
    "err_flg"               => "$err_flg",
    "gross_notax_amount"    => Numformat_Ortho($gross_notax_amount),
    "gross_tax_amount"      => Numformat_Ortho($gross_tax_amount),
    "gross_ontax_amount"    => Numformat_Ortho($gross_ontax_amount),
    "minus_notax_amount"    => Numformat_Ortho($minus_notax_amount),
    "minus_tax_amount"      => Numformat_Ortho($minus_tax_amount),
    "minus_ontax_amount"    => Numformat_Ortho($minus_ontax_amount),
));

$smarty->assign('row',$page_data);

// htmlをassign
$smarty->assign("html", array(
    "html_s"    => "$html_s",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
