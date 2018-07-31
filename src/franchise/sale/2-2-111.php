<?php
/**
 *
 * 商品予定出荷（一覧）
 *
 *   予定データから巡回担当者ごとに必要な商品を集計し、
 *   巡回担当者の担当倉庫に商品を移動する
 *
 *   集計条件は
 *   ・伝票番号が振ってある伝票だけを集計
 *   ・ログインユーザのショップの伝票（担当支店）を集計
 *   ・削除伝票は抽出しない
 *
 *
 *
 * ■履歴
 * 1.0.0 (2006/08/01) 新規作成
 * 1.0.1 (2006/08/08) スタッフに担当倉庫が設定されていない場合は、基本出荷倉庫を表示するよう変更
 * 1.0.2 (2006/08/18) 担当倉庫が設定されていない場合は基本出荷倉庫、設定されている場合は担当倉庫を表示
 *                    受注ヘッダ更新する項目に出荷倉庫名（履歴用）を追加
 * 1.0.3 (2006/08/29) 配列の添え字抜けてたのを追加
 *                    抽出のSQLに代行の条件をつける
 * 1.0.4 (2006/09/06) 引当てるときは「引当を出庫」、引当て解除は「引当を入庫」
 * 1.0.5 (2006/10/12) 伝票番号が振ってあるのだけ集計するように
 * 1.0.6 (2006/11/02) カレンダー表示期間分表示<suzuki>
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2006/09/06)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/07      02-047      suzuki      日付検索処理が行えるように修正
 *  2006/11/07      02-048      suzuki      担当者開始を指定し検索できるように修正
 *  2006/11/07      02-052      suzuki      担当者ごとに倉庫の移動が行えるように修正
 *  2006/11/07      02-057      suzuki      担当者検索処理ができるように修正
 *  2006/11/11      02-051      suzuki      合計ボタン押下時にPOSTの数量がなければ、DBの数量を表示
 *  2006/12/04      ssl-0049    kajioka-h   合計ボタン押下時に担当者ごとのレコード数をhiddenに格納する処理抜け修正
 *  2006/12/10      02-070      suzuki      受注のみの商品でも、合計数が表示されるように修正
 *  2006/12/11      02-064      suzuki      処理の途中で予定データが変更された場合にエラー表示するように修正
 *  2007/02/16      要件5-1     kajioka-h   商品の移動元を担当支店の拠点倉庫、移動先を担当者の担当倉庫に変更
 *  2007/02/22      xx-xxx      kajioka-h   帳票出力機能を削除
 *  2007/02/26      B0702-011   kajioka-h   表示ボタン押下時にJSエラーが出ていたのを修正
 *  2007/02/27      xx-xxx      kajioka-h   商品名は略称表示に変更
 *  2007/03/21      要件21      kajioka-h   削除伝票は抽出しないように変更
 *  2007/03/28      要件21他    kajioka-h   商品予定出荷時の処理は以下の動作に変更
 *                                              ・以前の引当を全削除
 *                                              ・担当者倉庫に引当
 *                                              ・受注ヘッダの出荷倉庫は担当者の拠点倉庫に更新
 *  2007/03/30      その他106   kajioka-h   Ｍ区分、管理区分、商品分類、商品CDでソートに変更
 *                  その他109   kajioka-h   全担当者の合計は一番上に表示
 *  2007/04/04      xx-xxx      kajioka-h   商品名（略称）から商品名に表示変更
 *  2007/04/13      その他      kajioka-h   「配送日」→「予定巡回日」に表示変更
 *                  その他126   kajioka-h   「数量」→「予定出荷数」に表示変更
 *  2007/04/16      その他      kajioka-h   検索項目変更
 *  2007/04/30      その他      fukuda      印刷用改ページを追加（A3縦）
 *  2007/05/22      その他      watanabe-k  ボタン名を変更　代行集計表　⇒　代行期間集計表
 *  2007/06/23      xx-xxx      kajioka-h   付番前集計を可能に
 *
 */

//$page_title = "商品予定出荷一覧";
$page_title = "商品予定出荷";

//環境設定ファイル
require_once("ENV_local.php");

//検索項目の関数とか
require_once(INCLUDE_DIR."common_quickform.inc");


//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_attach_branch"=> "",
    "form_round_staff"  => array("cd" => "", "select" => ""),
    "form_part"         => "",
    "form_multi_staff"  => "",
    "form_ware"         => "",
    "form_round_day"    => array(
/*
        "sy" => "",
        "sm" => "",
        "sd" => "",
        "ey" => "",
        "em" => "",
        "ed" => "",
*/
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => "01",
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y"))),
    ),
    "form_not_multi_staff"  => "",
    "form_count_radio"      => "1",
);



/****************************/
//外部変数取得
/****************************/
$group_kind = $_SESSION["group_kind"];


//処理完了時のメッセージ表示
if($_GET["done_flg"] == "true"){
    $html = "<font color=\"blue\"><b>完了しました。</b></font>";
}elseif($_GET["err_flg"] == "true"){
    $html  = "<font color=\"red\"><b>処理中に予定データの変更が発生しました。<br>";
    $html .= "もう一度始めから操作してください</font>";
}else{
    $html = null;
}


/****************************/
// 初期値設定
/****************************/
// 改ページ単位カウント
$page_return = 0;
// 改ページ行数（担当者毎用）
$return_num  = 53;


/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */
Search_Form($db_con, $form, $ary_form_list);

// 表示件数を削除
$form->removeElement("form_display_num");
// 顧客担当支店を削除
$form->removeElement("form_client_branch");
// 得意先を削除
$form->removeElement("form_client");
// 請求先を削除
$form->removeElement("form_claim");
// 請求日を削除
$form->removeElement("form_claim_day");
// 委託先FCを削除
$form->removeElement("form_charge_fc");

// 除外巡回担当者コード（カンマ区切り）
$form->addElement("text", "form_not_multi_staff", "", "size=\"40\" style=\"$g_form_style\" $g_form_option");

//集計区分
$form_count_radio = NULL;
$form_count_radio[] =& $form->createElement("radio", NULL, NULL, "付番後", "1", "");
$form_count_radio[] =& $form->createElement("radio", NULL, NULL, "付番前", "2", "");
$form->addGroup($form_count_radio, "form_count_radio", "集計区分");



/*
// 巡回担当者コード
$text44_1[] =& $form->createElement("text", "scd", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_charge[scd]','form_charge[ecd]',4)\" $g_form_option");
$text44_1[] =& $form->createElement("static", "", "", "　〜　");
$text44_1[] =& $form->createElement("text", "ecd", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text44_1, "form_charge", "");
*/

// 表示ボタン
$form->addElement("submit", "form_display", "表　示", null);

// クリアボタン
$form->addElement("button", "form_clear", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//画面タイトル横の画面切替ボタン
$form->addElement("button", "href_2-2-113", "集計日報", "onClick=\"javascript:location.href('2-2-113.php')\"");
if($group_kind == "2"){
    $form->addElement("button", "href_2-2-116", "代行期間集計表", "onClick=\"javascript:location.href('2-2-116.php')\"");
}
$form->addElement("button", "href_2-2-204", "予定伝票発行", "onClick=\"javascript:location.href('2-2-204.php')\"");
$form->addElement("button", "href_2-2-111", "商品予定出荷", $g_button_color." onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");


/*
//基本出荷倉庫名を取得
$sql  = "SELECT ";
$sql .= "    t_ware.ware_id, ";
$sql .= "    t_ware.ware_name ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "    INNER JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
$sql .= "WHERE ";
$sql .= "    t_client.client_id = ".$_SESSION["client_id"]." ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if($result == false) {
    exit();
}
$basic_ware_id   = pg_fetch_result($result, 0, "ware_id");          //基本出荷倉庫ID
$basic_ware_name = pg_fetch_result($result, 0, "ware_name");        //基本出荷倉庫名

//$form->addElement("hidden", "hdn_basic_ware_id", $basic_ware_id);   //基本出荷倉庫ID
*/


//hidden作成
$form->addElement("hidden", "hdn_move_staff_id");       //移動するスタッフのID


//予定出荷を行っている最中かどうかを確認するためのユニークなチェックコード生成
$form->addElement("hidden", "hdn_ship_chk_cd", "");
if($_POST["form_display"] != ""){
    //$microtime    = NULL;
    $microtime   = explode(" ",microtime());
    $ship_chk_cd = $microtime[1].substr("$microtime[0]", 2, 5);     //チェックコード
}else{
    $ship_chk_cd = $_POST["hdn_ship_chk_cd"];
}
$con_data["hdn_ship_chk_cd"] = $ship_chk_cd;
//echo "チェックコード：$ship_chk_cd<br>";

//「表示ボタン」押下時に取得したレコード数格納用
$form->addElement("hidden", "hdn_ship_chk_num");

//集計区分ラジオボタン
$form->addElement("hidden", "hdn_count_div");

//if($_POST["form_display"] == ""){
if($_POST["form_display"] == "表　示"){
    $con_data["hdn_ship_chk_num"]   = $_POST["hdn_ship_chk_num"];
    $count_div                      = $_POST["form_count_radio"];
    $con_data["hdn_count_div"]      = $count_div;
}elseif($_POST != null){
    $count_div                      = $_POST["hdn_count_div"];
    $con_data["form_count_radio"]   = $count_div;
}

$form->setConstants($con_data);



//////////////////////////////
//エラーチェック
//  以下のボタン押下時
//  ・担当者の移動ボタン
//  ・全移動ボタン
//  ・表示ボタン
//  ・合計ボタン
//////////////////////////////
$err_flg = false;

if($_POST["move_button"] != "" || $_POST["move_all_button"] != "" || $_POST["form_display"] != "" || $_POST["sum_button"] != "" ){

    // ■共通フォームチェック
    Search_Err_Chk($form);

    // ■除外巡回担当者（複数選択）
    Err_Chk_Delimited($form, "form_not_multi_staff", "除外巡回担当者（複数選択） は数値と「,」のみ入力可能です。");


    //予定巡回日（始め）
    $ord_sdate  = str_pad($_POST["form_round_day"]["sy"], 4, "0", STR_PAD_LEFT);
    $ord_sdate .= "-"; 
    $ord_sdate .= str_pad($_POST["form_round_day"]["sm"], 2, "0", STR_PAD_LEFT);
    $ord_sdate .= "-"; 
    $ord_sdate .= str_pad($_POST["form_round_day"]["sd"], 2, "0", STR_PAD_LEFT);
    //予定巡回日（終わり）
    $ord_edate  = str_pad($_POST["form_round_day"]["ey"], 4, "0", STR_PAD_LEFT);
    $ord_edate .= "-";
    $ord_edate .= str_pad($_POST["form_round_day"]["em"], 2, "0", STR_PAD_LEFT);
    $ord_edate .= "-"; 
    $ord_edate .= str_pad($_POST["form_round_day"]["ed"], 2, "0", STR_PAD_LEFT);

    //予定巡回日の妥当性チェック
    $ord_sdate_y = (int)$_POST["form_round_day"]["sy"];
    $ord_sdate_m = (int)$_POST["form_round_day"]["sm"];
    $ord_sdate_d = (int)$_POST["form_round_day"]["sd"];
    $ord_edate_y = (int)$_POST["form_round_day"]["ey"];
    $ord_edate_m = (int)$_POST["form_round_day"]["em"];
    $ord_edate_d = (int)$_POST["form_round_day"]["ed"];
/*
    $check_ord_sdate = checkdate($ord_sdate_m,$ord_sdate_d,$ord_sdate_y);
    if($check_ord_sdate == false && $ord_sdate != "0000-00-00"){
        $form->setElementError("form_round_day","予定巡回日は妥当ではありません。");
        $err_flg = true;
    }
    $check_ord_edate = checkdate($ord_edate_m,$ord_edate_d,$ord_edate_y);
    if($check_ord_edate == false && $ord_edate != "0000-00-00"){
        $form->setElementError("form_round_day","予定巡回日は妥当ではありません。");
        $err_flg = true;
    }
*/

	/*
	 * 履歴：
	 * 　日付　　　　B票No.　　　　担当者　　　内容　
	 * 　2006/11/02　02-040　　　　suzuki-t　　カレンダー表示期間分表示
	 *
	*/
	$ord_date = str_pad($ord_edate_y,4,"0", STR_PAD_LEFT)."-".str_pad($ord_edate_m,2,"0", STR_PAD_LEFT)."-".str_pad($ord_edate_d,2,"0", STR_PAD_LEFT);

	//カレンダ表示期間取得
	require_once(INCLUDE_DIR."function_keiyaku.inc");
	$cal_array = Cal_range($db_con,$_SESSION[client_id],true);
	$check_edate   = $cal_array[1];     //対象終了期間

	if($check_edate != "0000-00-00" && $ord_date > $check_edate){
        $form->setElementError("form_round_day","予定巡回日 はカレンダー表示期間内を指定して下さい。");
        $err_flg = true;
    }

/*
	//担当者コードの半角数字チェック
	if(!ereg("^[0-9]+$",$_POST["form_charge"]["scd"]) && $_POST["form_charge"]["scd"] != NULL){
		$charges_msg = "巡回担当者コード(開始) は半角数字のみです。";
        $err_flg = true;
	}
	if(!ereg("^[0-9]+$",$_POST["form_charge"]["ecd"])  && $_POST["form_charge"]["ecd"] != NULL){
		$chargee_msg = "巡回担当者コード(終了) は半角数字のみです。";
        $err_flg = true;
	}

	//巡回担当者（複数選択）の半角数字チェック
    if($_POST["form_multi_staff"] != null){
        $array_charge = explode(",",$_POST["form_multi_staff"]);
        $count = count($array_charge);
        for($i=0;$i<$count;$i++){
			if(!ereg("^[0-9]+$",$array_charge[$i])){
				$decimal_msg = "巡回担当者（複数選択）は半角数字と「,」のみです。";
        		$err_flg = true;
				break;
			}
        }
    }

    //除外巡回担当者（複数選択）が指定されている場合
    if($_POST["form_not_multi_staff"] != null){
        $array_nocharge = explode(",",$_POST["form_not_multi_staff"]);
        $count = count($array_nocharge);
        for($i=0;$i<$count;$i++){
			if(!ereg("^[0-9]+$",$array_nocharge[$i])){
				$nodecimal_msg = "除外巡回担当者コード（複数選択）は半角数字と「,」のみです。";
        		$err_flg = true;
				break;
			}
        }
    }
*/

    if($_POST["move_button"] != "" || $_POST["move_all_button"] != "" || $_POST["sum_button"] != "" ){

        //移動対象のスタッフIDを取得
        if($_POST["hdn_move_staff_id"] == "ALL" || $_POST["hdn_move_staff_id"] == ""){
            $form_staff_keys = array_keys($_POST["form_num"]);
        }else{
            $form_staff_keys[0] = $_POST["hdn_move_staff_id"];
        }
        $array_count_staff = count($form_staff_keys);   //回す分

        //スタッフIDだけループする
        for($i=0;$i<$array_count_staff;$i++){
            $form_count_goods = count($_POST["form_num"][$form_staff_keys[$i]]);       //商品IDだけループ
            $form_goods_keys  = array_keys($_POST["form_num"][$form_staff_keys[$i]]);  //商品IDを取得

            //商品IDだけループ
            for($j=0;$j<$form_count_goods;$j++){
                // 半角数字チェック
                if(!ereg("^[0-9]+$", $_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]])){
                    $err_flg_num = true;
                    break 2;
                }
            }
        }

        if($err_flg_num === true){
            $form_num_mess = "予定出荷数は半角数字のみです。";
        }else{
            $form_num_mess = null;
        }

    }


    //////////////////////////////
    // エラーチェック結果集計
    //////////////////////////////

    // チェック適用
    $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : $err_flg;


}//エラーチェック終わり



/****************************/
//移動、全移動ボタン押下
/****************************/
if(($_POST["move_button"] != "" || $_POST["move_all_button"] != "") && (!$err_flg && !$err_flg_num) && $count_div == "1"){
/* suzuki  */
	//各担当者の移動ボタン押下判定
	if($_POST["hdn_move_staff_id"] != "ALL"){
		//対象期間の移動数（引当）を取得
	    $array_tmp = L_List_SQL_Get(
	            $form,
	            $count_div,
	            $ord_sdate,
	            $ord_edate,
	            $_POST["form_round_staff"]["cd"],
	            $_POST["form_round_staff"]["select"],
	            $_POST["form_multi_staff"],
	            $_POST["form_not_multi_staff"],
	            $_POST["form_part"],
	            $_POST["form_ware"],
	            $_POST["form_attach_branch"],
	            "t_aorder_d.aord_d_id",
	            $err_flg,
				$_POST["hdn_move_staff_id"]
	        );
	}else{
		//対象期間の移動数（引当）を取得
	    $array_tmp = L_List_SQL_Get(
	            $form,
	            $count_div,
	            $ord_sdate,
	            $ord_edate,
	            $_POST["form_round_staff"]["cd"],
	            $_POST["form_round_staff"]["select"],
	            $_POST["form_multi_staff"],
	            $_POST["form_not_multi_staff"],
	            $_POST["form_part"],
	            $_POST["form_ware"],
	            $_POST["form_attach_branch"],
	            "t_aorder_d.aord_d_id",
	            $err_flg
	        );
	}
	$sql = $array_tmp[0];
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result == false) {
        //Db_Query($db_con, "ROLLBACK;");
        exit();
    }

    $record_count = pg_num_rows($result);   //全レコード数（受払に書かないといけない数）
    $array_query = Get_Data($result);

    //受注IDの重複を取り除く
    for($i=0;$i<$record_count;$i++){
        $array_vacuum[$array_query[$i][5]] = 0;
    }
//print_array($array_vacuum, "対象の全受注ID");exit();
    //$array_tmp_count = count(array_unique($array_vacuum)); //受注IDの数
    $array_tmp_count = count($array_vacuum); //受注IDの数
//echo "行数：$array_tmp_count<br>";
//echo "行数2：".$_POST["hdn_ship_chk_num"]."<br>";
//echo "行数3：".$_POST["hdn_ship_chk_cd"]."<br>";
    $sql = "SELECT COUNT(aord_id) FROM t_aorder_h WHERE ship_chk_cd = ".$_POST["hdn_ship_chk_cd"].";";
//echo "$sql<br>";
    $result = Db_Query($db_con, $sql);
    if($result == false) {
        exit();
    }
    $chk_record_count = pg_fetch_result($result, 0, 0);     //表示ボタン押下時にコードを設定したレコード数
//echo "行数：$chk_record_count<br>";

    //表示ボタン押下時のレコード数を比較し、異なる場合はエラー
    if($_POST["hdn_ship_chk_num"] != $chk_record_count || (($_POST["hdn_ship_chk_num"] != $array_tmp_count) && $_POST["hdn_move_staff_id"] == "ALL") || (($_POST["hdn_ship_staff_num"][$_POST["hdn_move_staff_id"]] != $array_tmp_count) && $_POST["hdn_move_staff_id"] != "ALL")){
        //$err_ship_chk = true;
        //$err_ship_chk_mess = "対象の予定データが変更されました。<br>始めからもう一度やり直してください。";
//print_array($_POST["hdn_ship_chk_num"]);
//print_array($chk_record_count);
//print_array($_POST["hdn_ship_chk_num"]);
//print_array($array_tmp_count);
//print_array($_POST["hdn_move_staff_id"]);
//print_array($_POST["hdn_ship_staff_num"][$_POST["hdn_move_staff_id"]]);
//print_array($_POST["hdn_move_staff_id"]);
//print_array($array_tmp_count);
//print_array($_POST["hdn_move_staff_id"]);
        header("Location: $_SERVER[PHP_SELF]?err_flg=true");
        exit();
    }



    //エラーがなければ、受払、受注ヘッダのSQLを実施
    if($err_flg !== true && $err_flg_num !== true){

        //トランザクション開始（スタッフごとに登録）
        Db_Query($db_con, "BEGIN;");

        //対象の受注IDをカンマ区切りで
        $str_aord_id = "";
        foreach($array_vacuum as $key => $value){
            $str_aord_id .= $key.", ";
        }
        $str_aord_id = substr($str_aord_id, 0, (strlen($str_aord_id) - 2));

        //対象の受注の受払を全削除
        $sql  = "DELETE FROM t_stock_hand \n";
        $sql .= "WHERE aord_d_id IN ( \n";
        $sql .= "    SELECT aord_d_id FROM t_aorder_d WHERE aord_id IN (".$str_aord_id.") \n";
        $sql .= "    ) \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        if($result == false){
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }


        //レコード数分ループ
        for($i=0, $array_update_ware=array();$i<$record_count;$i++){

            //$staff_ware_id = ($array_query[$i][3] == null) ? $basic_ware_id : $array_query[$i][3];  //スタッフの担当倉庫ID
            $staff_ware_id = $array_query[$i][3];       //スタッフの担当倉庫ID
            $ord_no        = $array_query[$i][6];       //伝票番号
            $aord_d_id     = $array_query[$i][7];       //受注データID
            $goods_id      = $array_query[$i][8];       //商品ID
            $reserve_num   = $array_query[$i][11];      //移動数（引当数）
            $bases_ware_id = $array_query[$i][15];      //拠点倉庫ID

/*
            //拠点倉庫から引当移動の入庫SQL
            $sql  = "INSERT INTO ";
            $sql .= "    t_stock_hand ( ";
            $sql .= "        goods_id, ";
            $sql .= "        enter_day, ";
            $sql .= "        work_day, ";
            $sql .= "        work_div, ";
            $sql .= "        ware_id, ";
            $sql .= "        io_div, ";
            $sql .= "        num, ";
            $sql .= "        slip_no, ";
            $sql .= "        aord_d_id, ";
            $sql .= "        staff_id, ";
            $sql .= "        shop_id ";
            $sql .= "    ) VALUES ( ";
            $sql .= "        ".$goods_id.", ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        '1', ";
            $sql .= "        ".$bases_ware_id.", ";
            $sql .= "        '1', ";
            $sql .= "        ".$reserve_num.", ";
            $sql .= "        '".$ord_no."', ";
            $sql .= "        ".$aord_d_id.", ";
            $sql .= "        ".$_SESSION["staff_id"].", ";
            $sql .= "        ".$_SESSION["client_id"]." ";
            $sql .= "    ) ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
*/

            //担当倉庫へ引当移動の出庫SQL
            $sql  = "INSERT INTO ";
            $sql .= "    t_stock_hand ( ";
            $sql .= "        goods_id, ";
            $sql .= "        enter_day, ";
            $sql .= "        work_day, ";
            $sql .= "        work_div, ";
            $sql .= "        ware_id, ";
            $sql .= "        io_div, ";
            $sql .= "        num, ";
            $sql .= "        slip_no, ";
            $sql .= "        aord_d_id, ";
            $sql .= "        staff_id, ";
            $sql .= "        shop_id ";
            $sql .= "    ) VALUES ( ";
            $sql .= "        ".$goods_id.", ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        CURRENT_TIMESTAMP, ";
            $sql .= "        '1', ";
            $sql .= "        ".$staff_ware_id.", ";
            $sql .= "        '2', ";
            $sql .= "        ".$reserve_num.", ";
            $sql .= "        '".$ord_no."', ";
            $sql .= "        ".$aord_d_id.", ";
            $sql .= "        ".$_SESSION["staff_id"].", ";
            $sql .= "        ".$_SESSION["client_id"]." ";
            $sql .= "    ) ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //受注ヘッダ更新用に担当倉庫IDを取得
            //$array_update_ware[$array_query[$i][5]] = $array_query[$i][3];

            //受注ヘッダ更新用に拠点倉庫IDを取得
            $array_update_ware[$array_query[$i][5]] = $array_query[$i][15];

        }

        //受注IDごとに移動済フラグ、出荷倉庫を更新
        $array_aord_id       = array_keys($array_update_ware);
        $array_aord_id_count = count($array_update_ware);

        for($i=0;$i<$array_aord_id_count;$i++){

            //$ware_id = ($array_update_ware[$array_aord_id[$i]] == null) ? $basic_ware_id : $array_update_ware[$array_aord_id[$i]];
            $ware_id = $array_update_ware[$array_aord_id[$i]];

            //契約区分、取消フラグを取得
            $sql = "SELECT contract_div, cancel_flg FROM t_aorder_h WHERE aord_id = ".$array_aord_id[$i].";";
            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
            $contract_div   = pg_fetch_result($result, 0, "contract_div");
            $cancel_flg     = pg_fetch_result($result, 0, "cancel_flg");

            $sql  = "UPDATE ";
            $sql .= "    t_aorder_h ";
            $sql .= "SET ";
            //オンライン代行で、取消フラグがtrueの伝票は出荷倉庫を更新しない（一度報告したため、出荷倉庫は更新済）
            if(!($contract_div == "2" && $cancel_flg == "t")){
                $sql .= "    ware_id = ".$ware_id.", ";
                //1.0.2 (2006/08/18) 受注ヘッダ更新する項目に出荷倉庫名（履歴用）を追加
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ".$ware_id."), ";
            }
            $sql .= "    move_flg = true ";
            $sql .= "WHERE ";
            $sql .= "    aord_id = ".$array_aord_id[$i]." ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }
        }


        /*** ここから在庫移動SQL ***/

        //スタッフIDだけループする
        for($i=0;$i<$array_count_staff;$i++){

            $form_count_goods = count($_POST["form_num"][$form_staff_keys[$i]]);       //商品IDだけループ
            $form_goods_keys  = array_keys($_POST["form_num"][$form_staff_keys[$i]]);  //商品IDを取得
//print_array($form_goods_keys);

            for($j=0;$j<$form_count_goods;$j++){
                //拠点倉庫から在庫移動の出庫SQL
                $sql  = "INSERT INTO ";
                $sql .= "    t_stock_hand ( ";
                $sql .= "        goods_id, ";
                $sql .= "        enter_day, ";
                $sql .= "        work_day, ";
                $sql .= "        work_div, ";
                $sql .= "        ware_id, ";
                $sql .= "        io_div, ";
                $sql .= "        num, ";
                $sql .= "        staff_id, ";
                $sql .= "        shop_id ";
                $sql .= "    ) VALUES ( ";
                $sql .= "        ".$form_goods_keys[$j].", ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        '5', ";
                //$sql .= "        ".$basic_ware_id.", ";
                $sql .= "        ".$_POST["hdn_bases_ware_id"][$form_staff_keys[$i]].", ";
                $sql .= "        '2', ";
                $sql .= "        ".$_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]].", ";
                $sql .= "        ".$_SESSION["staff_id"].", ";
                $sql .= "        ".$_SESSION["client_id"]." ";
                $sql .= "    ) ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }


                //担当倉庫へ在庫移動の入庫SQL
                $sql  = "INSERT INTO ";
                $sql .= "    t_stock_hand ( ";
                $sql .= "        goods_id, ";
                $sql .= "        enter_day, ";
                $sql .= "        work_day, ";
                $sql .= "        work_div, ";
                $sql .= "        ware_id, ";
                $sql .= "        io_div, ";
                $sql .= "        num, ";
                $sql .= "        staff_id, ";
                $sql .= "        shop_id ";
                $sql .= "    ) VALUES ( ";
                $sql .= "        ".$form_goods_keys[$j].", ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        CURRENT_TIMESTAMP, ";
                $sql .= "        '5', ";
                $sql .= "        ".$_POST["hdn_staff_ware_id"][$form_staff_keys[$i]].", ";
                $sql .= "        '1', ";
                $sql .= "        ".$_POST["form_num"][$form_staff_keys[$i]][$form_goods_keys[$j]].", ";
                $sql .= "        ".$_SESSION["staff_id"].", ";
                $sql .= "        ".$_SESSION["client_id"]." ";
                $sql .= "    ) ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

            }

        }//スタッフIDループ終わり（在庫移動SQL）

        /*** ここまで在庫移動SQL ***/


        //正常終了時
        $result = Db_Query($db_con, "COMMIT;");
        //$result = Db_Query($db_con, "ROLLBACK;");
        if($result != false){
            header("Location: $_SERVER[PHP_SELF]?done_flg=true");
        }

    }//入力エラーがなかった場合のSQL終わり

}//移動ボタン処理ココまで



/****************************/
//表示、合計ボタン押下
//移動、全移動ボタン押下かつエラー時（画面再表示）
/****************************/
//if($_POST["form_display"] != ""){
if($_POST["form_display"] != "" || $_POST["sum_button"] != "" || ($_POST["hdn_move_staff_id"] != "" && $err_flg_num)){

    //エラーではない場合、画面描画処理
    if($err_flg != true){

        /*** ここからSQLを生成、実行 ***/

/* suzuki  */
		//各担当者の移動ボタン押下判定
		if($_POST["hdn_move_staff_id"] != "ALL"){
	        $array_tmp = L_List_SQL_Get(
	                $form, 
	                $count_div,
	                $ord_sdate, 
	                $ord_edate, 
                    $_POST["form_round_staff"]["cd"],
                    $_POST["form_round_staff"]["select"],
                    $_POST["form_multi_staff"],
                    $_POST["form_not_multi_staff"],
                    $_POST["form_part"],
                    $_POST["form_ware"],
                    $_POST["form_attach_branch"],
	                //"t_goods.goods_cd", 
	                "t_g_goods.g_goods_cd, t_product.product_cd, t_g_product.g_product_cd, t_goods.goods_cd", 
	                $err_flg,
					$_POST["hdn_move_staff_id"]
	            );
		}else{
			$array_tmp = L_List_SQL_Get(
	                $form, 
	                $count_div,
	                $ord_sdate, 
	                $ord_edate, 
                    $_POST["form_round_staff"]["cd"],
                    $_POST["form_round_staff"]["select"],
                    $_POST["form_multi_staff"],
                    $_POST["form_not_multi_staff"],
                    $_POST["form_part"],
                    $_POST["form_ware"],
                    $_POST["form_attach_branch"],
	                //"t_goods.goods_cd", 
	                "t_g_goods.g_goods_cd, t_product.product_cd, t_g_product.g_product_cd, t_goods.goods_cd", 
	                $err_flg
	            );
		}
        $sql = $array_tmp[0];
//echo "$sql<br>";
        $ord_sdate = $array_tmp[1];
        $ord_edate = $array_tmp[2];

        $result = Db_Query($db_con, $sql);
            if($result == false) {
            exit();
        }

        /*** ここまでSQLを生成、実行 ***/

        /*** ここからHTMLを生成 ***/

        $array_query = Get_Data($result);
//print_array($array_query);

        $record_count = pg_num_rows($result);   //全レコード数（受払に書かないといけない数）

        //0件だった場合
        if($record_count == 0){
            $html  = "<font color=\"blue\"><b>";
            $html .= "予定データがありません。";
            $html .= "</b></font>";
        }else{
            //各担当者の出荷予定（SQLの結果行数分回す）
            //for($i=0, $array_goods=array(), $array_sum=array();$i<$record_count;$i++){
            for($i=0, $array_goods=array(), $array_sum=array(), $array_hidden_aord_id=array();$i<$record_count;$i++){
                $staff_id        = $array_query[$i][0];     //スタッフID
				$staff_cd        = $array_query[$i][1];     //スタッフCD
                $staff_name      = $array_query[$i][2];     //スタッフ名
                //$ware_id    = ($array_query[$i][3] == null) ? $basic_ware_id : $array_query[$i][3];     //担当倉庫ID
                //$ware_name  = ($array_query[$i][4] == null) ? $basic_ware_name : $array_query[$i][4];   //担当倉庫名
                $ware_id         = $array_query[$i][3];     //担当倉庫ID
                $ware_name       = $array_query[$i][4];     //担当倉庫名
                $goods_id        = $array_query[$i][8];     //商品ID
                $goods_cd        = $array_query[$i][9];     //商品CD
                $goods_name      = $array_query[$i][10];    //商品名
                $goods_num       = $array_query[$i][11];    //予定出荷数
                $bases_ware_id   = $array_query[$i][15];    //拠点倉庫ID
                $bases_ware_name = $array_query[$i][16];    //拠点倉庫
                $g_goods_name    = $array_query[$i][17];    //Ｍ区分
                $product_name    = $array_query[$i][18];    //管理区分
                $g_product_name  = $array_query[$i][19];    //商品分類

                //各担当者ごとにカウント
                $array_goods[$staff_id][$goods_id]["staff_name"] = $staff_name;
                $array_goods[$staff_id][$goods_id]["staff_cd"]   = $staff_cd;
                $array_goods[$staff_id][$goods_id]["ware_id"]    = $ware_id;
                $array_goods[$staff_id][$goods_id]["ware_name"]  = $ware_name;
                $array_goods[$staff_id][$goods_id]["goods_cd"]   = $goods_cd;
                $array_goods[$staff_id][$goods_id]["goods_name"] = $goods_name;
                //(2006/08/29) kaji 配列の添え字抜けてたのを追加
                //$array_goods[$staff_id][$goods_id]["num"]        = $array_goods[$goods_id]["num"] + $goods_num;
                $array_goods[$staff_id][$goods_id]["num"]        = $array_goods[$staff_id][$goods_id]["num"] + $goods_num;
                $array_goods[$staff_id][$goods_id]["bases_ware_id"]   = $bases_ware_id;
                $array_goods[$staff_id][$goods_id]["bases_ware_name"] = $bases_ware_name;
                $array_goods[$staff_id][$goods_id]["g_goods_name"]      = $g_goods_name;
                $array_goods[$staff_id][$goods_id]["product_name"]      = $product_name;
                $array_goods[$staff_id][$goods_id]["g_product_name"]    = $g_product_name;

                //合計テーブル用のカウント
                //$array_sum[$goods_id]["num"] = $array_sum[$goods_id]["num"] + $goods_num;

                //表示ボタン押下時はレコード数を格納
                if($_POST["form_display"] != ""){
                    //チェックコード更新用に受注IDだけ取得
                    //$array_aord_id[$i] = $array_query[$i][5];
                    $array_aord_id[$i] = $array_query[$i][5];

					//担当者ごとの受注IDの件数
					$staff_aord_id[$staff_id][] = $array_query[$i][5];
                }

            }//合計カウント終わり
//print_array($array_goods);
//print_array($array_hidden_aord_id);


            //表示ボタン押下時はレコード数を格納
            if($_POST["form_display"] != ""){
                //チェックコード用の受注IDの配列から重複をとる
                $array_tmp = array_unique($array_aord_id);
                $array_aord = array_values($array_tmp);
//print_array($array_aord);
                $array_aord_count = count($array_aord);
//echo "行数（前）：$array_aord_count<br>";

                //表示ボタン押下時は取得したレコード数をチェック用にhiddenに格納
                $form->setConstants(array("hdn_ship_chk_num" => $array_aord_count));

				//表示ボタン押下時は取得した担当者ごとのレコード数をチェック用にhiddenに格納
				while($staff_data = each($staff_aord_id)){
					$staff_num = $staff_data[0];
					//チェックコード用の受注IDの配列から重複をとる
                	$staff_check = array_unique($staff_aord_id[$staff_num]);
                	$staff_n = array_values($staff_check);
					$staff_aord_num = count($staff_n);
					$form->addElement("hidden", "hdn_ship_staff_num[$staff_num]", "");
					$set_staff["hdn_ship_staff_num[$staff_num]"] = $staff_aord_num;
                	$form->setConstants($set_staff);
				}

                for($i=0,$str_aord="";$i<$array_aord_count;$i++){
                    $str_aord .= $array_aord[$i];
                    $str_aord .= ($i != $array_aord_count-1) ? ", " : "";
                }
//echo "チェックコード：$str_aord<br>";

                //取得した受注ヘッダにチェックコードを付与
                $sql  = "UPDATE ";
                $sql .= "    t_aorder_h ";
                $sql .= "SET ";
                $sql .= "    ship_chk_cd = ".$ship_chk_cd." ";
                $sql .= "WHERE ";
                $sql .= "    aord_id IN (".$str_aord.") ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con, $sql);
                    if($result == false) {
                    exit();
                }
            //チェックコード確認終わり

            //合計ボタン押下時に担当者ごとのレコード数をhiddenに格納
            }elseif($_POST["sum_button"] != ""){
                foreach($_POST["hdn_ship_staff_num"] as $staff_num => $staff_aord_num){
                    $form->addElement("hidden", "hdn_ship_staff_num[$staff_num]");
                    $set_staff["hdn_ship_staff_num[$staff_num]"] = $staff_aord_num;
                }
                $form->setConstants($set_staff);
            }


            $array_staff_count = count($array_goods);
            $array_staff_keys  = array_keys($array_goods);

            //各担当者の出荷予定（カウントした配列分回す）
            for($i=0;$i<$array_staff_count;$i++){

                $array_goods_count = count($array_goods[$array_staff_keys[$i]]);
                $array_goods_keys  = array_keys($array_goods[$array_staff_keys[$i]]);

                //各担当者の商品分ループ
                for($j=0;$j<$array_goods_count;$j++){

                    //合計ボタン、移動ボタンまたは全移動ボタン押下してエラーの場合、POSTのデータを入れる
                    if($_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]] != NULL && ($_POST["sum_button"] != "" || $_POST["move_button"] != "" || $_POST["move_all_button"] != "")){
                        $goods_num = $_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]];
                    }else{
                        $goods_num = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["num"];
                    }

                    $tmp = "form_num[".$array_staff_keys[$i]."][".$array_goods_keys[$j]."]";
                    $con_data_num[$tmp] = $goods_num;
                }
            }
            $form->setConstants($con_data_num);


            //各担当者の出荷予定（カウントした配列分回す）
            for($i=0, $html="", $goods_num_sum=0, $array_sum=array();$i<$array_staff_count;$i++){

                $array_goods_count = count($array_goods[$array_staff_keys[$i]]);
                $array_goods_keys  = array_keys($array_goods[$array_staff_keys[$i]]);

//for($b=0;$b<20;$b++){   // fukuda test

                //各担当者の商品分ループ
                for($j=0;$j<$array_goods_count;$j++){

                    //1行目はテーブルのヘッダを表示
                    if($j == 0){
                        // 担当者名テーブル作成
                        $html .= "<br>";
                        $ary_return = L_Html_U_Table_Header(
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["staff_name"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["staff_cd"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_name"], 
                            $ord_sdate, 
                            $ord_edate, 
                            $form, 
                            $array_staff_keys[$i], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_id"], 
                            $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["bases_ware_id"],
                            $return_num,
                            $page_return
                        );
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];
                        // 列タイトル作成
                        $ary_return = L_Html_Table_Header($return_num, $page_return);
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];
                    }

                    //合計ボタン、移動ボタンまたは全移動ボタン押下してエラーの場合、POSTのデータを入れる
                    if($_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]] != NULL && ($_POST["sum_button"] != "" || $_POST["move_button"] != "" || $_POST["move_all_button"] != "")){
                        $goods_num = $_POST["form_num"][$array_staff_keys[$i]][$array_goods_keys[$j]];

                    }else{
                        $goods_num = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["num"];
                    }

                    //合計テーブル用のカウント
                    $array_sum[$array_goods_keys[$j]]["num"] = $array_sum[$array_goods_keys[$j]]["num"] + $goods_num;

//for($a=0;$a<10;$a++){   // fukuda test
                    // 商品行作成
                    $ary_return = L_Html_Draw_Row(
                        $j+1,                               //行No.
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["goods_cd"], //商品コード
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["goods_name"],     //商品名
                        $goods_num,                         //商品数
                        $form, 
                        $array_staff_keys[$i],              //スタッフID 
                        $array_goods_keys[$j],              //商品ID
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["g_goods_name"],     //Ｍ区分
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["product_name"],     //管理区分
                        $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["g_product_name"],   //商品分類
                        $return_num,
                        $page_return,
                        $count_div
                    );
                    $html .= $ary_return[0];
                    $page_return = $ary_return[1];
//}   // fukuda test

                    //合計行用のカウント
                    $goods_num_sum = $goods_num_sum + $goods_num;

                    //最終行の場合、合計を表示
                    if($j == $array_goods_count-1){
                        //1.0.1 (2006/08/08) 担当倉庫が設定されていない場合は、基本出荷倉庫を表示
                        //$staff_ware_name = ($staff_ware_name == null) ? $basic_ware_name : $staff_ware_name;
                        //1.0.2 (2006/08/18) 担当倉庫が設定されていない場合は基本出荷倉庫、設定されている場合は担当倉庫を表示（判定は上でやってます）
                        $staff_ware_name = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["ware_name"];
                        $bases_ware_name = $array_goods[$array_staff_keys[$i]][$array_goods_keys[$j]]["bases_ware_name"];
                        // 合計行作成
                        $ary_return = L_Html_Table_Footer(
                            $goods_num_sum,
                            $bases_ware_name,
                            $staff_ware_name,
                            $form,
                            $array_staff_keys[$i],
                            $disabled,
                            $return_num, 
                            $page_return,
                            $count_div
                        );
                        $html .= $ary_return[0];
                        $page_return = $ary_return[1];

                        //合計行用のカウント変数初期化
                        $goods_num_sum = 0;
                    }

                }//商品分のループ終わり

//}   // fukuda test

            }//スタッフ分のループ終わり

            //$html .= "<hr>\n";

            //合計に表示する商品の商品IDを取得し、「,」区切りにする
            $array_sum_goods_keys = array_keys($array_sum);
            $count_array_sum_goods_keys = count($array_sum_goods_keys);
            for($i=0,$string_goods_sum_keys="";$i<$count_array_sum_goods_keys;$i++){
                $string_sum_goods_keys .= $array_sum_goods_keys[$i];
                $string_sum_goods_keys .= ($i!=$count_array_sum_goods_keys-1) ? ", " : "" ;
            }
//echo $string_goods_sum_keys;

            //合計に使う拠点倉庫IDを全て取得し、「,」区切りにする
            $sql = "SELECT bases_ware_id FROM t_branch WHERE shop_id = ".$_SESSION["client_id"].";";
            $result = Db_Query($db_con, $sql);
                if($result == false) {
                exit();
            }
            $array_bases_tmp = pg_fetch_all($result);
            $array_bases_tmp_count = pg_num_rows($result);
            for($i=0;$i<$array_bases_tmp_count;$i++){
                $array_bases_tmp2[] = $array_bases_tmp[$i]["bases_ware_id"];
            }
            $array_all_bases_ware_id = array_unique($array_bases_tmp2);
            $all_bases_ware_id = "";
            foreach($array_all_bases_ware_id as $value){
                $all_bases_ware_id .= "$value, ";
            }
            $all_bases_ware_id = substr($all_bases_ware_id, 0, (strlen($all_bases_ware_id) - 2));


            //合計に表示する商品IDの在庫数、発注残を取得
            $sql  = "SELECT \n";
            $sql .= "    t_goods.goods_id, \n";
            $sql .= "    t_goods.goods_cd, \n";
            //$sql .= "    t_goods.goods_name, \n";
            //$sql .= "    t_goods.goods_cname, \n";
            $sql .= "    t_goods.goods_name, \n";
            $sql .= "    COALESCE (t_stock.stock_num,0) AS stock_num, \n";
            $sql .= "    COALESCE (t_inventory_on_order.inventory_on_order_num, 0) AS inventory_on_order_num, \n";
            $sql .= "    t_g_goods.g_goods_name, \n";       // 5 Ｍ区分名
            $sql .= "    t_product.product_name, \n";       // 6 管理区分名
            $sql .= "    t_g_product.g_product_name \n";    // 7 商品分類名
            $sql .= "FROM \n";
			$sql .= "    t_goods \n";
            $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
			$sql .= "    LEFT JOIN \n";
            $sql .= "    ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            goods_id, \n";
            $sql .= "            SUM(stock_num) AS stock_num \n";
            $sql .= "        FROM \n";
            $sql .= "            t_stock \n";
            $sql .= "        WHERE \n";
            $sql .= "            shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            //$sql .= "            ware_id = $basic_ware_id \n";
            $sql .= "            ware_id IN (".$all_bases_ware_id.") \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            goods_id \n";
            $sql .= "    ) AS t_stock ON t_stock.goods_id = t_goods.goods_id \n";
            $sql .= "    LEFT JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            goods_id, \n";
            $sql .= "            SUM( \n";
            $sql .= "                CASE io_div \n";
            $sql .= "                    WHEN 1 THEN num \n";
            $sql .= "                    WHEN 2 THEN num * (-1) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS inventory_on_order_num \n";
            $sql .= "            FROM \n";
            $sql .= "            t_stock_hand \n";
            $sql .= "        WHERE \n";
/*
            $sql .= "            goods_id IN ($string_sum_goods_keys) \n";
            $sql .= "            AND \n";
*/
            $sql .= "            shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            //$sql .= "            ware_id = $basic_ware_id \n";
            $sql .= "            ware_id IN (".$all_bases_ware_id.") \n";
            $sql .= "            AND \n";
            $sql .= "            work_div = '3' \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            goods_id \n";
            $sql .= "    ) AS t_inventory_on_order ON t_stock.goods_id = t_inventory_on_order.goods_id \n";
			$sql .= "WHERE \n";
			$sql .= "    t_goods.goods_id IN ($string_sum_goods_keys) \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_g_goods.g_goods_cd, \n";
            $sql .= "    t_product.product_cd, \n";
            $sql .= "    t_g_product.g_product_cd, \n";
            $sql .= "    t_goods.goods_cd \n";
            $sql .= ";";
//print_array($sql, "合計");

            $result = Db_Query($db_con, $sql);
                if($result == false) {
                exit();
            }

            $array_sum_query = Get_Data($result);

            //移動する商品の合計をカウントした配列に在庫数、発注残を追加
            for($i=0;$i<$count_array_sum_goods_keys;$i++){
                $goods_id = $array_sum_query[$i][0];

                //合計ボタン、移動ボタンまたは全移動ボタン押下してエラーの場合、POSTのデータを入れる
                if($err_flg_num){
                    $goods_num_sum = $_POST["form_num_all"][$goods_id];
                }else{
                    $goods_num_sum = $array_sum[$goods_id]["num"];
                }

                $array_goods_sum[$i]["goods_id"]   = $goods_id;                             //商品ID
                $array_goods_sum[$i]["goods_cd"]   = $array_sum_query[$i][1];               //商品CD
                $array_goods_sum[$i]["goods_name"] = $array_sum_query[$i][2];               //商品名
                $array_goods_sum[$i]["stock_num"]  = $array_sum_query[$i][3];               //在庫数
                $array_goods_sum[$i]["inventory_on_order_num"] = $array_sum_query[$i][4];   //発注残
                $array_goods_sum[$i]["num"] = $goods_num_sum;                               //引当数
                $array_goods_sum[$i]["g_goods_name"]    = $array_sum_query[$i][5];          //Ｍ区分
                $array_goods_sum[$i]["product_name"]    = $array_sum_query[$i][6];          //管理区分
                $array_goods_sum[$i]["g_product_name"]  = $array_sum_query[$i][7];          //商品分類

                $tmp = "form_num_all[".$goods_id."]";
                $con_data_sum[$tmp] = $goods_num_sum;
            }

            $form->setConstants($con_data_sum);

            //合計のテーブル生成
            //$html .= L_Html_SumTable($ord_sdate, $ord_edate, $basic_ware_name, $array_goods_sum, $form, $err_flg_num,$disabled);
            $page_return = 15;
            $ary_sum_table   = L_Html_SumTable($ord_sdate, $ord_edate, $array_goods_sum, $form, $err_flg_num,$disabled, $page_return, $count_div);
            $html_sum_table  = $ary_sum_table[0];
            $html_sum_table .= "<br><br><hr><br>";

            /*** ここまでHTMLを生成 ***/
        }

    }//エラーではない場合の描画処理ここまで

}//表示ボタン押下処理ここまで



/****************************/
// HTML作成（検索部）
/****************************/
// 共通検索テーブル
$html_s = Search_Table($form);



/****************************/
//HTMLヘッダ
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title,"amenity.js", "global.css", "", "ie8");

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
//$page_menu = Create_Menu_f('sale','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["href_2-2-113"]]->toHtml();
if($group_kind == "2"){
    $page_title .= "　".$form->_elements[$form->_elementIndex["href_2-2-116"]]->toHtml();
}
$page_title .= "　".$form->_elements[$form->_elementIndex["href_2-2-204"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["href_2-2-111"]]->toHtml();
$page_header = Create_Header($page_title);


/****************************/
//ページ作成
/****************************/

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
    'html'          => "$html",
    'html_sum_table'    => "$html_sum_table",
    'form_num_mess' => "$form_num_mess",
	'auth_r_msg'    => "$auth_r_msg",
	//'charges_msg'   => "$charges_msg",
    //'chargee_msg'   => "$chargee_msg",
	//'decimal_msg'   => "$decimal_msg",
    //'nodecimal_msg' => "$nodecimal_msg",
));

// htmlをassign
$smarty->assign("html", array(
    "html_s"        =>  $html_s,
));


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_POST);


/***   全処理おわり   ***/

/*** 以下ローカル関数 ***/


/**
 *
 * 各担当者のテーブル（担当者名とかの）を生成
 *
 * @param       string      $staff_name     スタッフ名
 * @param       string      $staff_cd       スタッフCD
 * @param       string      $ware_name      担当倉庫名
 * @param       string      $ord_sdate      表示期間（始め）
 * @param       string      $ord_edate      表示期間（終わり）
 * @param       object      $form           QuickFormのオブジェクト
 * @param       int         $staff_id       スタッフID
 * @param       int         $staff_ware_id  担当倉庫ID
 * @param       int         $basesware_id   拠点倉庫ID
 * @param       int         $return_num     改ページを挿入する行数
 * @param       int         $page_return    現在の行数
 *
 * @return      string      生成したHTML
 * @return      int         現在の行数
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/02/16)
 *
 */
function L_Html_U_Table_Header($staff_name,$staff_cd,$ware_name, $ord_sdate, $ord_edate, $form, $staff_id, $staff_ware_id, $bases_ware_id, $return_num, $page_return)
{
	$staff_cd = str_pad($staff_cd,4,"0", STR_PAD_LEFT);

    $page_return += 3;

    if (bcmod($page_return-2, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else
    if (bcmod($page_return-1, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else
    if (bcmod($page_return-0, $return_num) == 0 && $page_return != 0){
        $page_return_print = " style=\"page-break-before: always;\"";
    }else{
        $page_return_print = null;
    }

    $page_return += 1;

    $html  = "<br".$page_return_print.">";
    $html .= "<table width=\"970px\" valign=\"top\"><tr><td align=\"left\">";

    $html .= "<table  class=\"Data_Table\" border=\"1\" width=\"500\">\n";
    $html .= "    <tr>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>担当者</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">".$staff_cd." : ".$staff_name."</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>担当倉庫</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ware_name</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>予定巡回日</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ord_sdate 〜 $ord_edate</td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    $form->addElement("hidden", "hdn_staff_ware_id[$staff_id]", $staff_ware_id);
    $form->addElement("hidden", "hdn_bases_ware_id[$staff_id]", $bases_ware_id);

    return array($html, $page_return);

}


/**
 *
 * 各担当者のテーブルヘッダ（各商品の）を生成
 *
 * @param       int         $return_num     改ページを挿入する行数
 * @param       int         $page_return    現在の行数
 *
 * @return      string      生成したHTML
 * @return      int         現在の行数
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Table_Header($return_num, $page_return)
{

    $page_return_print = (bcmod($page_return, $return_num) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "<br".$page_return_print.">";
    //$html  = "<table class=\"List_Table\" border=\"1\" width=\"650\">\n";
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"970\">\n";
    $html .= "    <tr align=\"center\">\n";
    $html .= "        <td class=\"Title_Pink\"><b>No.</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品コード</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>Ｍ区分</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>管理区分</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品分類</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品名</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>予定出荷数</b></td>\n";
    $html .= "    </tr>\n";

    return array($html, $page_return);

}


/**
 *
 * テーブルの1行生成
 * @param       int         $no             テーブルに表示する行番号
 * @param       string      $goods_cd       商品CD
 * @param       string      $goods_name     商品名
 * @param       int         $goods_num      在庫移動フォームに商品数
 * @param       object      $form           QuickFormのオブジェクト
 * @param       int         $staff_id       スタッフID
 * @param       int         $goods_id       商品ID
 * @param       string      $g_goods_name   Ｍ区分名
 * @param       string      $product_name   管理区分名
 * @param       string      $g_product_name 商品分類名
 * @param       int         $return_num     改ページを挿入する行数
 * @param       int         $page_return    現在の行数
 * @param       string      $count_div      集計区分
 *
 * @return      string      生成したHTML
 * @return      int         現在の行数
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Draw_Row($no, $goods_cd, $goods_name, $goods_num, $form, $staff_id, $goods_id, $g_goods_name, $product_name, $g_product_name, $return_num, $page_return, $count_div)
{
    global $g_form_style, $g_form_option;

    $page_return_print = (bcmod($page_return, $return_num) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "    <tr class=\"Result1\"".$page_return_print.">\n";
    $html .= "        <td align=\"right\">$no</td>\n";
    $html .= "        <td align=\"left\">$goods_cd</td>\n";
    $html .= "        <td align=\"left\">$g_goods_name</td>\n";
    $html .= "        <td align=\"left\">$product_name</td>\n";
    $html .= "        <td align=\"left\">$g_product_name</td>\n";
    $html .= "        <td align=\"left\">$goods_name</td>\n";

    //$form->setConstants(array("form_num[$staff_id][$goods_id]" => $goods_num));

    $html .= "        <td align=\"right\">";
    if($count_div == "1"){
        $form_num_style = "style=\"text-align:right; $g_form_style\" $g_form_option";
    }else{
        $form_num_style = "style=\"text-align:right; $g_form_style border: #ffffff 1px solid; background-color: #ffffff;\" readonly tabindex=\"-1\"";
    }
    $form->addElement(
        "text", 
        "form_num[$staff_id][$goods_id]", 
        "", 
        "size=\"6\" maxLength=\"5\" $form_num_style"
    );
    $html .= $form->_elements[$form->_elementIndex["form_num[$staff_id][$goods_id]"]]->toHtml();
    $html .= "</td>\n";

    $html .= "    </tr>\n";

    return array($html, $page_return);

}


/**
 *
 * 各担当者のテーブルフッタ（各商品の）を生成
 *
 * @param       int         $goods_num_sum      商品合計数
 * @param       string      $basic_ware_name    基本出荷倉庫名
 * @param       string      $staff_ware_name    巡回担当者の担当倉庫名
 * @param       object      $form               QuickFormのオブジェクト
 * @param       int         $staff_id           スタッフID
 * @param       int         $disabled           読取り権限
 * @param       int         $return_num         改ページを挿入する行数
 * @param       int         $page_return        現在の行数
 * @param       string      $count_div          集計区分
 *
 * @return      string      生成したHTML
 * @return      int         現在の行数
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/01)
 *
 */
function L_Html_Table_Footer($goods_num_sum, $basic_ware_name, $staff_ware_name, $form, $staff_id,$disabled, $return_num, $page_return, $count_div)
{

    $page_return_print = (bcmod($page_return, $return_num) == 0 && $page_return != 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;

    $html  = "    <tr class=\"Result2\"".$page_return_print.">\n";
    $html .= "        <td align=\"left\"><b>合計</b></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"><b>$goods_num_sum</b></td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    //集計が付番後の場合のみ移動ボタン表示
    if($count_div == "1"){

        $html .= "<table border=\"0\" width=\"100%\">\n";
        $html .= "    <tr>\n";
        $html .= "        <td align=\"right\" valign=\"middle\">";
        $html .=             "<font color = \"#555555\">".$basic_ware_name." から ".$staff_ware_name." へ </font>";

        //移動ボタン
        $form->addElement(
            "submit","move_button[$staff_id]","移　動",
            "onClick=\"javascript:return Dialogue_2('移動します。','".$_SERVER["PHP_SELF"]."', '$staff_id', 'hdn_move_staff_id')\" $disabled"
        );
        $html .= $form->_elements[$form->_elementIndex["move_button[$staff_id]"]]->toHtml();
        $html .=         "</td>\n";
        $html .= "    </tr>\n";
        $html .= "</table>\n";

    }

    $html .= "</td></tr></table>\n";
    $html .= "<br>\n";

    return array($html, $page_return);

}


/**
 *
 * 商品合計のテーブルを生成
 *
 * @param       string      $ord_sdate          表示期間（始め）
 * @param       string      $ord_edate          表示期間（終わり）
 * @param       string      $basic_ware_name    基本出荷倉庫名
 * @param       array       $array_goods_sum    テーブルに表示する商品の配列
 * @param       object      $form               QuickFormのオブジェクト
 * @param       boolean     $err_flg_num        エラーフラグ（半角数値チェック）
 * @param       int         $disabled           読取り権限
 * @param       int         $page_return        現在の行数
 * @param       string      $count_div          集計区分
 *
 * @return      string      生成したHTML
 * @return      int         現在の行数
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/02/16)
 *
 */
//function L_Html_SumTable($ord_sdate, $ord_edate, $basic_ware_name, $array_goods_sum, $form, $err_flg_num,$disabled)
function L_Html_SumTable($ord_sdate, $ord_edate, $array_goods_sum, $form, $err_flg_num,$disabled, $page_return, $count_div)
{

    $html  = "<fieldset style=\"width:970px;\">\n";
    $html .= "<legend><font color=\"#555555\" style=\"font-size:16px\"><b>全担当者</b></font></legend>\n";
    $html .= "<br>\n";

    $html .= "<table width=\"100%\"><tr><td align=\"left\">";

    $html .= "<table class=\"Data_Table\" border=\"1\" width=\"380\">\n";
    $html .= "    <tr>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>担当者</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">全担当者計</td>\n";
    $html .= "        <td class=\"Title_Pink\" align=\"center\"><b>予定巡回日</b></td>\n";
    $html .= "        <td class=\"Value\" align=\"center\">$ord_sdate 〜 $ord_edate</td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";
    $html .= "<br>\n";

    //$html .= "<font color = \"#555555\">※ ".$basic_ware_name." の現在庫数・発注残を表示しています</font>\n";
    $html .= "<font color = \"#555555\">※ 各拠点倉庫の現在庫数・発注残の合計を表示しています</font>\n";
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html .= "    <tr align=\"center\">\n";
    $html .= "        <td class=\"Title_Pink\"><b>No.</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品コード</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>Ｍ区分</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>管理区分</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品分類</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>商品名</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>現在庫数</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>発注残</b></td>\n";
    $html .= "        <td class=\"Title_Pink\"><b>予定出荷数</b></td>\n";
    $html .= "    </tr>\n";

    // 改ページ単位カウント
    $page_return += 5;

    //1行表示
    $array_count = count($array_goods_sum);

//for($a=0;$a<10;$a++){   // fukuda test
    for($i=0, $stock_num_sum=0, $inventory_on_order_num_sum=0, $num_sum=0;$i<$array_count;$i++){
        $page_return_print = (bcmod($page_return, 58) == 0) ? " style=\"page-break-before: always;\"" : null;
        $page_return += 1;
        $html .= "    <tr class=\"Result1\" $page_return_print>\n";
        $html .= "        <td align=\"right\">".(string)($i+1)."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["goods_cd"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["g_goods_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["product_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["g_product_name"]."</td>\n";
        $html .= "        <td align=\"left\">".$array_goods_sum[$i]["goods_name"]."</td>\n";
        $html .= "        <td align=\"right\">".$array_goods_sum[$i]["stock_num"]."</td>\n";
        $html .= "        <td align=\"right\">".$array_goods_sum[$i]["inventory_on_order_num"]."</td>\n";
        $html .= "        <td align=\"right\">";

        $goods_id = $array_goods_sum[$i]["goods_id"];

/*
        if(!$err_flg_num){
            $form->setConstants(array("form_num_all[$goods_id]" => $array_goods_sum[$i]["num"]));
        }
*/

        $form->addElement(
            "text", 
            "form_num_all[$goods_id]", 
            "", 
            "size=\"6\" maxLength=\"5\" style=\"text-align:right; $g_form_style border: #ffffff 1px solid; background-color: #ffffff;\" readonly tabindex=\"-1\""
        );
        $html .= $form->_elements[$form->_elementIndex["form_num_all[$goods_id]"]]->toHtml();
        $html .=         "</td>\n";
        $html .= "    </tr>\n";

        $stock_num_sum = $stock_num_sum + $array_goods_sum[$i]["stock_num"];
        $inventory_on_order_num_sum = $inventory_on_order_num_sum + $array_goods_sum[$i]["inventory_on_order_num"];
        $num_sum = $num_sum + $array_goods_sum[$i]["num"];
    }
//}   // fukuda test

    //合計行表示
    $page_return_print = (bcmod($page_return, 58) == 0) ? " style=\"page-break-before: always;\"" : null;
    $page_return += 1;
    $html .= "    <tr class=\"Result2\" $page_return_print>\n";
    $html .= "        <td align=\"left\"><b>合計</b></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"></td>\n";
    $html .= "        <td align=\"right\"><b>$stock_num_sum</b></td>\n";
    $html .= "        <td align=\"right\"><b>$inventory_on_order_num_sum</b></td>\n";
    $html .= "        <td align=\"right\"><b>$num_sum</b></td>\n";
    $html .= "    </tr>\n";
    $html .= "</table>\n";

    $html .= "</td></tr><tr><td align=\"right\">";

    //集計が付番後の場合のみ合計、全移動ボタン表示
    if($count_div == "1"){

        $html .= "<table border=\"0\" width=\"650\">\n";
        $html .= "    <tr>\n";
        $html .= "        <td align=\"right\" valign=\"middle\">";
        $html .=             "<font color=\"#555555\">担当者の予定出荷数を変更した場合は、全移動ボタンを押す前に合計ボタンを押して下さい。</font>";
        //合計ボタン
        $form->addElement("submit","sum_button","合計", "$disabled");
        $html .= $form->_elements[$form->_elementIndex["sum_button"]]->toHtml();
        $html .= "<br>\n";
        $html .=             "<font color = \"#555555\">各拠点倉庫 から 各担当倉庫 へ </font>";
        //移動ボタン
        $form->addElement(
            "submit","move_all_button","全　移　動",
            "onClick=\"javascript:return Dialogue_2('移動します。','".$_SERVER[PHP_SELF]."', 'ALL', 'hdn_move_staff_id')\" $disabled"
        );
        $html .= $form->_elements[$form->_elementIndex["move_all_button"]]->toHtml();
        $html .= "        </td>\n";
        $html .= "    </tr>\n";
        $html .= "</table>";

        $page_return += 2;
    }

    $html .= "</td></tr></table>";

    $html .= "</fieldset>\n";

    // 改ページ単位カウント
    $page_return += 3;

    return array($html, $page_return);

}



/**
 *
 * 移動数表示用のSQL生成
 *
 * @param       object      $form               QuickFormのオブジェクト
 * @param       string      $count_div          集計区分
 *                                                  "1" ：付番後
 *                                                  "2" ：付番前
 * @param       string      $ord_sdate          予定巡回日（始め）
 * @param       string      $ord_edate          予定巡回日（終わり）
 * @param       string      $charge_cd          担当者コード（テキスト）
 * @param       string      $charge_id          担当者ID（セレクト）
 * @param       string      $charge_decimal     担当者コード（カンマ区切り）
 * @param       string      $charge_nodecimal   除外担当者コード（カンマ区切り）
 * @param       string      $part_id            部署ID
 * @param       string      $bases_ware_id      担当者の拠点倉庫ID
 * @param       int         $branch_id          担当支店ID
 * @param       string      $order_sql          SQLのORDER句に指定するカラム
 * @param       boolean     $err_flg            エラーフラグ（予定巡回日の妥当性チェック）
 * @param       int         $staff_id           移動ボタン押下した担当者のID
 *
 * @return      array       0 => 生成したSQL
 *                          1 => 表示期間（始め）（yyyy-mm-dd形式）
 *                          2 => 表示期間（終わり）（yyyy-mm-dd形式）
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.2.0 (2007/04/16)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/16      その他      kajioka-h   検索項目変更に対応
 *  2007/06/22      xx-xxx      kajioka-h   付番前集計を可能に
 */
function L_List_SQL_Get($form, $count_div, $ord_sdate, $ord_edate, $charge_cd, $charge_id, $charge_decimal, $charge_nodecimal, $part_id, $bases_ware_id, $branch_id, $order_sql, $err_flg, $staff_id = NULL)
{
    global $db_con;

    $where_sql = "";

    //エラーではない場合、画面描画処理
    if($err_flg != true){

        /*** ここから各検索条件を付与 ***/

        //予定巡回日の初めが指定されている場合
        if($ord_sdate != "0000-00-00"){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_aorder_h.ord_time >= '$ord_sdate' \n";
        }else{
            //テーブルの期間に利用するため、初期化
            $ord_sdate = "";
        }

		/*
		 * 履歴：
		 * 　日付　　　　B票No.　　　　担当者　　　内容　
		 * 　2006/11/02　02-040　　　　suzuki-t　　カレンダー表示期間分表示
		 *
		*/
		//予定巡回日の終わりが指定されていない場合、カレンダー表示期間のデータを設定
        if($ord_edate == "0000-00-00"){
			//カレンダ表示期間取得
			require_once(INCLUDE_DIR."function_keiyaku.inc");
			$cal_array = Cal_range($db_con,$_SESSION[client_id],true);
			$ord_edate   = $cal_array[1];     //対象終了期間

			$ord_cal["form_round_day"]["ey"] = str_pad(substr($ord_edate,0,4),4,"0", STR_PAD_LEFT);
			$ord_cal["form_round_day"]["em"] = str_pad(substr($ord_edate,5,2),2,"0", STR_PAD_LEFT);
			$ord_cal["form_round_day"]["ed"] = str_pad(substr($ord_edate,8,2),2,"0", STR_PAD_LEFT);
			$form->setConstants($ord_cal);

		}

        $where_sql .= "    AND \n";
        $where_sql .= "    t_aorder_h.ord_time <= '$ord_edate' \n";

        //担当者コードが指定されている場合
        if($charge_cd != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_staff.charge_cd = ".(int)$charge_cd." \n";
        }

        //担当者IDが指定されている場合
        if($charge_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_staff.staff_id = ".(int)$charge_id." \n";
        }

        //担当者コード（カンマ区切り）が指定されている場合
        if($charge_decimal != null){
            $array_charge = explode(",",$charge_decimal);
            $where_sql .= "    AND ( \n";

            $count = count($array_charge);
            for($i=0;$i<$count;$i++){
                $where_sql .= "    t_staff.charge_cd = ".(int)$array_charge[$i]." \n";
                $where_sql .= ($i != $count-1) ? " OR \n" : " ) \n";
            }
        }

        //除外担当者コード（カンマ区切り）が指定されている場合
        if($charge_nodecimal != null){
            $array_nocharge = explode(",",$charge_nodecimal);
            $where_sql .= "    AND ( \n";

            $count = count($array_nocharge);
            for($i=0;$i<$count;$i++){
                $where_sql .= "    t_staff.charge_cd != ".(int)$array_nocharge[$i]." \n";
                $where_sql .= ($i != $count-1) ? " AND \n" : " ) \n";
            }
        }

        //部署
        if($part_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_part.part_id = $part_id \n";
        }

        //拠点倉庫
        if($bases_ware_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_bases_ware.ware_id = $bases_ware_id \n";
        }

        //担当支店
        if($branch_id != null){
            $where_sql .= "    AND \n";
            $where_sql .= "    t_branch.branch_id = $branch_id \n";
        }
//echo $where_sql;

        /*** ここまで各検索条件を付与 ***/

        /*** ここからSQLを生成 ***/
        $sql  = "SELECT \n";
        $sql .= "    t_aorder_staff.staff_id, \n";      // 0 スタッフID
        $sql .= "    t_staff.charge_cd, \n";            // 1 スタッフCD
        $sql .= "    t_staff.staff_name, \n";           // 2 スタッフ名
        //$sql .= "    t_ware.ware_id, \n";             //担当者の担当倉庫ID
        //$sql .= "    t_ware.ware_name, \n";           //担当者の担当倉庫名
        $sql .= "    t_charge_ware.ware_id AS charge_ware_id, \n";      // 3 担当倉庫ID
        $sql .= "    t_charge_ware.ware_name AS charge_ware_name, \n";  // 4 担当倉庫名
        $sql .= "    t_aorder_h.aord_id, \n";           // 5 受注ID
        $sql .= "    t_aorder_h.ord_no, \n";            // 6 受注番号
        $sql .= "    t_aorder_d.aord_d_id, \n";         // 7 受注データID
        $sql .= "    t_aorder_ship.goods_id, \n";       // 8 商品ID
        $sql .= "    t_goods.goods_cd, \n";             // 9 商品CD
        $sql .= "    t_goods.goods_name, \n";           //10 商品名
        //$sql .= "    t_goods.goods_cname, \n";           //10 商品名（略称）
        $sql .= "    t_aorder_ship.num, \n";            //11 商品数量
        $sql .= "    t_branch.branch_id, \n";           //12 支店ID
        $sql .= "    t_branch.branch_cd, \n";           //13 支店CD
        $sql .= "    t_branch.branch_name, \n";         //14 支店名
        $sql .= "    t_bases_ware.ware_id AS bases_ware_id, \n";        //15 拠点倉庫ID
        $sql .= "    t_bases_ware.ware_name AS bases_ware_name, \n";    //16 拠点倉庫名
        $sql .= "    t_g_goods.g_goods_name, \n";       //17 Ｍ区分名
        $sql .= "    t_product.product_name, \n";       //18 管理区分名
        $sql .= "    t_g_product.g_product_name \n";    //19 商品分類名

        $sql .= "FROM \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";
        $sql .= "        AND t_aorder_h.move_flg = 'f' \n";         //移動済でない
        $sql .= "    INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "        AND t_aorder_staff.staff_div = '0' \n";    //巡回担当者はメイン1だけ（サブも含めると重複する）
        $sql .= "    INNER JOIN t_aorder_ship ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id \n";
        $sql .= "    INNER JOIN t_goods ON t_aorder_ship.goods_id = t_goods.goods_id \n";
        $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
        $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
        $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
        $sql .= "    INNER JOIN t_staff ON t_aorder_staff.staff_id = t_staff.staff_id \n";
        $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
        $sql .= "        AND t_attach.shop_id = ".$_SESSION["client_id"]." \n";
        //$sql .= "    LEFT JOIN t_ware ON t_attach.ware_id = t_ware.ware_id \n";
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "    INNER JOIN t_branch ON t_part.branch_id = t_branch.branch_id \n";
        $sql .= "    INNER JOIN t_ware AS t_bases_ware ON t_branch.bases_ware_id = t_bases_ware.ware_id \n";
        $sql .= "    INNER JOIN t_ware AS t_charge_ware ON t_attach.ware_id = t_charge_ware.ware_id \n";

        $sql .= "WHERE \n";
        //(2006/08/29) kaji 代行の条件をつける
        $sql .= "    ( \n";
        $sql .= "        (t_aorder_h.contract_div = '1' AND t_aorder_h.shop_id = ".$_SESSION["client_id"]." AND t_aorder_h.confirm_flg = 'f') \n";
        $sql .= "        OR \n";
        $sql .= "        (t_aorder_h.contract_div = '2' AND t_aorder_h.act_id = ".$_SESSION["client_id"]." AND (t_aorder_h.trust_confirm_flg = 'f' AND t_aorder_h.cancel_flg = 'f')) \n";
        $sql .= "    ) \n";

        $sql .= "    AND \n";
        if($count_div == "1"){
            $sql .= "    t_aorder_h.ord_no IS NOT NULL \n";
        }else{
            $sql .= "    t_aorder_h.ord_no IS NULL \n";
        }

        //削除した予定伝票は集計しない
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.del_flg = false \n";

        $sql .= $where_sql;
/* suzuki  */
		//各担当者の移動ボタン押下判定
        if($staff_id != NULL){
			//移動ボタン押下した担当者のID
			$sql .= " AND t_staff.staff_id = $staff_id \n";
		}

        $sql .= "ORDER BY \n";
        $sql .= "    t_staff.charge_cd, \n";
        $sql .= "    ".$order_sql." \n";

        $sql .= ";\n";
//print_array($sql);
        $return = array($sql, $ord_sdate, $ord_edate);

        /*** ここまでSQLを生成 ***/

    }else{
        $return = false;
    }

    return $return;

}

?>
