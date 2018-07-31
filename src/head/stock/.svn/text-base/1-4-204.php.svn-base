<?php
/**
 *
 * 棚卸入力
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
 *
 * 1.0.0 (2006/04/27) 新規作成
 * 1.1.0 (2006/07/10) shop_gidをなくす
 * 1.1.1 (2006/07/11) 棚卸入力直前に棚卸ヘッダが消された場合に処理を中断する
 * 1.1.2 (2006/09/19) (kaji)
 *   ・商品IDの抽出が本部商品だとまずかったのを修正
 * 1.2.0 (2006/10/19) (kaji)
 *   ・差異理由を在庫調整の調整理由と同じに
 *   ・商品追加時に在庫単価ではなく、仕入単価を表示していたのを修正
 *   ・商品追加時に棚卸日の在庫数ではなく、現在の在庫数を取得していたのを修正
 *   ・商品分類を表示するようにした
 *   ・サニタイジング
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.x.x (2006/12/28)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      02-008      kajioka-h   在庫管理しない商品はダイアログに表示しない
 *                  02-009      kajioka-h   更新済の棚卸は登録できないように
 *                  02-010      kajioka-h   棚卸実施者一括設定開始行の数値チェック追加
 *                  02-011      kajioka-h   棚卸実施者一括設定終了行の数値チェック追加
 *                  02-012      kajioka-h   棚卸更新済の棚卸はTOPに飛ばす
 *                  02-021      kajioka-h   未承認の商品は表示しないように
 *                  02-022      kajioka-h   存在しない商品コード入力時の商品分類初期化
 *                  ssl-0042    kajioka-h   登録した差異原因が復元されないのを修正
 *                  ssl-0043    kajioka-h   在庫単価が全て同じ金額が登録されてしまうバグ修正
 *                  ssl-0051    kajioka-h   商品ダイアログに渡す引数を修正
 *  2006/12/08      02-024      kajioka-h   入力中に棚卸調査表が作り直されていないかチェックする処理を追加
 *  2006/12/21      xx-xxx      kajioka-h   表示順を倉庫、商品分類、商品CDにした
 *                  0002,0003   kajioka-h   商品追加時に表示される在庫数が棚卸調査表作成日「以前」ではなく「より前」になっていたのを修正（SQLに=抜け）
 *  2006/12/28      xx-xxx      kajioka-h   表示はしないがDBに登録する項目をhiddenからSESSIONに持たせるように変更
 *                  xx-xxx      kajioka-h   商品の行生成をtoHtmlからSmartyでループするように変更
 *                  xx-xxx      kajioka-h   棚卸実施者のセレクトボックスを1行ずつsetConstantsしていたのをまとめてするように変更
 *                  xx-xxx      kajioka-h   在庫単価をaddGroupしていたのを整数部、小数部でそれぞれaddElementするように変更
 *                  xx-xxx      kajioka-h   テンプレ側でHTMLのサイズを減らす（インデントしない、alignをなくすなど）
 *                  xx-xxx      kajioka-h   本部とFCでモジュールを同じにした（SESSIONのgroup_kindで本部画面かFC画面かを区別）
 *  2007/01/22      xx-xxx      kajioka-h   一時登録ボタン追加（在庫単価、実棚数、棚卸実施者、差異原因の必須チェックをせずに登録可）
 *                  xx-xxx      kajioka-h   棚卸実施者一括設定で空白を一括設定できるように変更
 *  2007/05/14      その他92    kajioka-h   50行ごとに表示・登録可能に
 *                  その他92    kajioka-h   50行ごとに表示・登録可能にしたため、一時登録機能削除
 *                  xx-xxx      kajioka-h   棚卸実施日の入力をなしに、棚卸調査表作成日を表示
 *  2007/05/15      xx-xxx      kajioka-h   ページ遷移時等に、棚卸実施者一括設定行に行番号をセットするように変更
 *                  B0702-053   kajioka-h   商品追加入力時、行削除した後のエラーメッセージの行番号が間違っているバグ修正
 *                  B0702-054   kajioka-h   商品追加入力時、行削除した後に棚卸実施者一括設定をすると、指定とは異なる行に設定されるバグ修正
 *  2007/05/18      xx-xxx      kajioka-h   差異原因に「調整」を追加
 *  2007/06/18      B0702-061   kajioka-h   商品追加時に何も追加せずに登録するとエラーになるのを修正
 *  2009/10/09                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 */


$page_title = "棚卸入力";

//環境設定ファイル
require_once("ENV_local.php");

//echo microtime()."<br>";

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;



/****************************/
//外部変数取得
/****************************/

$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$error_flg  = false;


//調査表番号
($_GET["invent_no"] == null || $_GET["ware_id"] == null) ? header("Location: ../top.php") : null;


//-------------------------//
//設定
//-------------------------//

//表示行数
$limit = 50;

//本部画面
if($group_kind == "1"){
    //棚卸調査表作成・一覧画面のURL（戻るボタン用）
    $pre_url = "1-4-201.php";
    //商品一覧ダイアログのURL
    $dialog_goods_url = "../dialog/1-0-210.php";
    //登録後遷移先URL
    $transition_url = "./1-4-201.php";
//FC画面
}else{
    //棚卸調査表作成・一覧画面のURL（戻るボタン用）
    $pre_url = "2-4-201.php";
    //商品一覧ダイアログのURL
    $dialog_goods_url = "../dialog/2-0-210.php";
    //登録後遷移先URL
    $transition_url = "./2-4-201.php";
}


/****************************/
//棚卸調査ID取得
/****************************/

$sql  = "SELECT ";
$sql .= "    t_invent.invent_id, ";
$sql .= "    MAX(t_invent.expected_day), ";
$sql .= "    MAX(t_invent.enter_day), ";
$sql .= "    COUNT(t_contents.goods_id) ";
$sql .= "FROM ";
$sql .= "    t_invent ";
$sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "WHERE ";
$sql .= "    t_invent.invent_no = '".$_GET["invent_no"]."' ";
$sql .= "AND ";
$sql .= "    t_invent.ware_id = ".(int)$_GET["ware_id"]." ";
$sql .= "AND ";
$sql .= "    t_invent.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    t_contents.add_flg = false ";
$sql .= "GROUP BY ";
$sql .= "    t_invent.invent_id ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if($result == false) {
    //Db_Query($db_con, "ROLLBACK;");
    exit();
}
Get_Id_Check($result);

$invent_id = pg_fetch_result($result, 0, 0);    //棚卸調査ID
$expected_day = pg_fetch_result($result, 0, 1); //棚卸日
//最初に画面を開いたときに、登録日を取得しhiddenに保持
if($_POST["hdn_enter_day"] == null){
    $enter_day = pg_fetch_result($result, 0, 2);    //登録日
    $form->setDefaults(array("hdn_enter_day" => "$enter_day"));
}else{
    $enter_day = $_POST["hdn_enter_day"];
}
$contents_num = pg_fetch_result($result, 0, 3);     //調査表作成時の商品数

//1.1.1 2006-07-11 kaji
//調査取消ボタンが押された（棚卸ヘッダが消された）場合、処理を中断
if($invent_id === false){
    exit();
}


/****************************/
//差異原因セレクトボックス用
/****************************/

$select_reason = array(
    0 => "",
    //1 => "システム開始在庫",
    2 => "破損",
    3 => "紛失",
    4 => "発見",
    7 => "調整",
    5 => "在庫記入ミス",
);



/*****************************/
//商品コード入力
/*****************************/

if($_POST["goods_search_row"] != null){

    $row = $_POST["goods_search_row"];

    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd, \n";     //0
    $sql .= "    t_goods.goods_name, \n";   //1
    $sql .= "    t_goods.unit, \n";         //2
    $sql .= "    t_price.r_price, \n";      //3
    $sql .= "    t_g_goods.g_goods_cd, \n"; //4
    $sql .= "    t_g_goods.g_goods_name, \n";   //5
    $sql .= "    t_goods.goods_id, \n";         //6
    $sql .= "    t_g_product.g_product_id, \n"; //7
    $sql .= "    t_g_product.g_product_cd, \n"; //8
    $sql .= "    t_g_product.g_product_name, \n";   //9
    $sql .= "    t_goods.goods_cname, \n";      //10
    $sql .= "    t_product.product_cd, \n";     //11
    $sql .= "    t_product.product_name \n";    //12
    $sql .= "FROM \n";
    $sql .= "    t_price \n";
    $sql .= "    INNER JOIN t_goods ON t_price.goods_id = t_goods.goods_id \n";
    $sql .= "    INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
    $sql .= "    INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "    INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";
    #2009-10-09 hashimoto-y
    $sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    $sql .= "WHERE \n";
    $sql .= "        t_goods.goods_cd = '".$_POST["form_goods_cd"][$row]."' \n";
    $sql .= "    AND \n";
    #2009-10-09 hashimoto-y
    #$sql .= "        t_goods.stock_manage = '1' \n";
    $sql .= "        t_goods_info.stock_manage = '1' \n";
    $sql .= "    AND \n";
    $sql .= "        t_goods_info.shop_id = $shop_id ";

    $sql .= "    AND \n";
    $sql .= ($group_kind == "1") ? "        t_price.rank_cd = '1' \n" : "        t_price.rank_cd = '3' \n"; //本部は付加、FCは在庫単価
    $sql .= "    AND \n";
    $sql .= "        t_goods.accept_flg = '1' \n";
    $sql .= "    AND \n";
    //本部の場合
    if($group_kind == "1"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id = $shop_id \n";
        $sql .= "            WHEN false THEN t_goods.shop_id = $shop_id \n";
        $sql .= "        END \n";
    //直営の場合
    }elseif($group_kind == "2"){
        $sql .= "        t_goods.state IN ('1', '3') \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id IN (".Rank_Sql().") \n";
        $sql .= "            WHEN false THEN t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "        END \n";
    //FCの場合
    }else{
        $sql .= "        t_goods.state = '1' \n";
        $sql .= "    AND \n";
        $sql .= "        CASE t_goods.public_flg \n";
        $sql .= "            WHEN true THEN t_price.shop_id = $shop_id \n";
        $sql .= "            WHEN false THEN t_goods.shop_id = $shop_id \n";
        $sql .= "        END \n";
    }
    $sql .= ";\n";
//print_array($sql, "商品追加SQL");

    $result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) == 1){
        $array_db = Get_Data($result, 2);
//print_array($array_db, "商品追加array");

        $set_goods_data["form_goods_cd"][$row] = $array_db[0][0];
        $set_goods_data["form_goods_name"][$row] = $array_db[0][1];
        $set_goods_data["form_unit"][$row] = $array_db[0][2];

        $temp = explode(".", $array_db[0][3]);
        $set_goods_data["form_price"][$row]["i"] = $temp[0];
        $set_goods_data["form_price"][$row]["d"] = $temp[1];

        $set_goods_data["form_g_product_cd"][$row] = $array_db[0][8];
        $set_goods_data["form_g_product_name"][$row] = $array_db[0][9];
        $set_goods_data["form_goods_cname"][$row] = addslashes($array_db[0][10]);
        $set_goods_data["form_product_cd"][$row] = $array_db[0][11];
        $set_goods_data["form_product_name"][$row] = addslashes($array_db[0][12]);

        $set_goods_data["form_add_flg"][$row] = "true";             //追加フラグ


        //棚卸日の在庫数を取得
        $sql  = "SELECT \n";
        $sql .= "    COALESCE( \n";
        $sql .= "        SUM(num * \n";
        $sql .= "            CASE io_div \n";
        $sql .= "                WHEN 1 THEN  1 \n";
        $sql .= "                WHEN 2 THEN -1 \n";
        $sql .= "            END \n";
        $sql .= "        ), 0 \n";
        $sql .= "    ) AS stock_num \n";
        $sql .= "FROM \n";
        $sql .= "    t_stock_hand \n";
        $sql .= "WHERE \n";
        $sql .= "    work_div NOT IN (1,3) \n";
        $sql .= "    AND \n";
        $sql .= "    work_day <= '$expected_day' \n";
        $sql .= "    AND \n";
        $sql .= "    goods_id = ".$array_db[0][6]." \n";
        $sql .= "    AND \n";
        $sql .= "    ware_id = ".(int)$_GET["ware_id"]." \n";
//        $sql .= "    AND \n";
//        $sql .= "    shop_id = $shop_id \n";
        $sql .= ";\n";
//print_array($sql);

        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) == 1){
            $array_db2 = Get_Data($result, 2);

            $set_goods_data["form_stock_num"][$row] = $array_db2[0][0];
            $set_goods_data["form_tstock_num"][$row] = $array_db2[0][0];
            $set_goods_data["form_diff_num"][$row] = "0";
        }else{
            $set_goods_data["form_stock_num"][$row] = "0";
            $set_goods_data["form_tstock_num"][$row] = "0";
            $set_goods_data["form_diff_num"][$row] = "0";
        }

        $set_goods_data["form_g_goods_cd"][$row] = $array_db[0][4];
        $set_goods_data["form_g_goods_name"][$row] = $array_db[0][5];
    }else{
        //該当する商品が存在しない場合、フォームを初期化
        $set_goods_data["form_g_product_name"][$row] = "";

        $set_goods_data["form_goods_cd"][$row] = "";

        $set_goods_data["form_goods_name"][$row] = "";
        $set_goods_data["form_unit"][$row] = "";

        $set_goods_data["form_price"][$row]["i"] = "";
        $set_goods_data["form_price"][$row]["d"] = "";

        $set_goods_data["form_stock_num"][$row] = "";
        $set_goods_data["form_tstock_num"][$row] = "";
        $set_goods_data["form_diff_num"][$row] = "";

        $set_goods_data["form_g_goods_cd"][$row] = "";
        $set_goods_data["form_g_goods_name"][$row] = "";

        $set_goods_data["form_add_flg"][$row] = "";             //追加フラグ
    }

    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);

}	//商品コード入力終わり



/*****************************/
//棚卸実施者一括設定（前処理）
/*****************************/

$staff_set   = null;
if($_POST["form_conf_button"] == "一括設定"){
    $line_start = $_POST["form_line"]["start"];
    $line_end   = $_POST["form_line"]["end"];
    if(mb_ereg("[^0-9]", $line_start) == 1 || mb_ereg("[^0-9]", $line_end) == 1 || $line_start == null || $line_end == null){
        $staff_line_err = "一括設定に指定する行数は半角数値のみです。";
    //}elseif($_POST["form_staff_set"] == null){
    //    $staff_select_err = "一括設定する棚卸実施者を設定してください。";
    }else{
        $staff_set = $_POST["form_staff_set"];
    }
}



/*****************************/
//登録処理
/*****************************/

//if($_POST["form_entry_button"] == "登　録"){
//if($_POST["form_entry_button"] == "登　録" || $_POST["form_temp_button"] == "一時登録"){
//登録して前へ、登録して次へ、登録して商品追加、登録完了ボタンが押されていて、商品コードが飛んできたとき
//if(($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null) && $_POST["form_goods_cd"] != null){
//登録して前へ、登録して次へ、登録して商品追加、登録完了ボタンが押されてい
if($_POST["form_entry_back"] != null || $_POST["form_entry_next"] != null || $_POST["form_entry_button"] != null || $_POST["form_entry_add_button"] != null){


    //商品コードが飛んできた
    if($_POST["form_goods_cd"] != null){

        //POSTで飛んできた行番号取得
        $line_no = array_keys($_POST["form_goods_cd"]);

        //行数
        $row_num = $_POST["offset_line"];


        //-- エラーチェック(PHP) --//
        //for($i=0,$error_flg=false;$i<$line_count;$i++){
        foreach($_POST["form_goods_cd"] as  $line => $goods_cd){

            //行番号
            $row_num++;
            $array_row_num[$line] = $row_num;   //行番号配列（エラーチェックで使う）


            //調査表作成時の商品、または商品追加画面で商品コードが空ではない行だけチェック
            if($_POST["add_flg"] == "false" || ($_POST["add_flg"] == "true" && $_POST["form_goods_cd"][$line] != "")){

                //在庫単価チェック
                if(!ereg("^[0-9]+$",$_POST["form_price"][$line]["i"]) || !ereg("^[0-9]+$",$_POST["form_price"][$line]["d"])){
                    $price_error_mess .= ($row_num)."行目 在庫単価は半角数字のみです。<br>";
                    $error_flg = true;
                }

                //実棚数チェック
                if(!ereg("^[\-]?[0-9]+$",$_POST["form_tstock_num"][$line])){
                    $tstock_error_mess .= ($row_num)."行目 実棚数は半角数字のみです。<br>";
                    $error_flg = true;
                }

                //棚卸実施者チェック
                if($_POST["form_staff"][$line] == ""){
                    $staff_error_mess .= ($row_num)."行目 棚卸実施者を選択してください。<br>";
                    $error_flg = true;
                }

                //差異原因登録チェック
                if($_POST["form_diff_num"][$line] != 0 && $_POST["form_cause"][$line] == 0){
                    $cause_error_mess .= ($row_num)."行目 差異原因を選択してください。<br>";
                    $error_flg = true;
                }


                //商品コードが空ではないものだけ取得
                $array_goods_cd[$line] = $_POST["form_goods_cd"][$line];

                //整数部、小数部との入力されている場合は単価を取得
                if($_POST["form_price"][$line]["i"] != null && $_POST["form_price"][$line]["d"] != null){
                    $stock_price[$line]  = $_POST["form_price"][$line]["i"];
                    $stock_price[$line] .= ".";
                    $stock_price[$line] .= str_pad($_POST["form_price"][$line]["d"], 2, 0, STR_PAD_RIGHT);
                }else{
                    $stock_price[$line]  = null;
                }

            }

        }
//print_array($array_row_num, "行番号");
//print_array($empty_line, "空行");
//print_array($array_goods_cd);

    }


    $goods_count = count($array_goods_cd);      //入力商品数


    //商品追加画面で商品の入力がある場合のチェック
    if($_POST["add_flg"] == "true" && $goods_count != 0){

        $injustice_error_mess = "";
        $goods_cd_str = "";
        foreach($array_goods_cd as $line => $goods_cd){

            //商品名等を取得
            $sql  = "SELECT \n";
            $sql .= "    t_goods.goods_id, \n";             //商品ID
            $sql .= "    t_goods.goods_name, \n";           //商品名
            $sql .= "    t_goods.goods_cname, \n";          //商品名（略称）
            $sql .= "    t_g_goods.g_goods_cd, \n";         //Ｍ区分CD
            $sql .= "    t_g_goods.g_goods_name, \n";       //Ｍ区分名
            $sql .= "    t_product.product_cd, \n";         //管理区分CD
            $sql .= "    t_product.product_name, \n";       //管理区分名
            $sql .= "    t_g_product.g_product_cd, \n";     //商品分類CD
            $sql .= "    t_g_product.g_product_name \n";    //商品分類名
            $sql .= "FROM \n";
            $sql .= "    t_goods \n";
            $sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";
            $sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $sql .= "WHERE \n";
            $sql .= "    t_goods.goods_cd = '".$goods_cd."' \n";
            $sql .= "    AND \n";
            if($group_kind == "2"){
                $sql .= "            t_goods_info.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "    t_goods_info.shop_id = $shop_id \n";
            }
            $sql .= ";";
//print_array($sql);

            $result = Db_Query($db_con, $sql);

            //該当データが存在しない場合、エラー
            if(pg_num_rows($result) != 1){
                $injustice_error_mess .= $array_row_num[$line]."行目 ";
                $error_flg = true;

            //データが1件あるとき
            }else{
                //登録時に使うデータ取得
                $array_goods_id[$line]          = pg_fetch_result($result, 0, "goods_id");
                $array_goods_name[$line]        = pg_fetch_result($result, 0, "goods_name");
                $array_goods_cname[$line]       = pg_fetch_result($result, 0, "goods_cname");
                $array_g_goods_cd[$line]        = pg_fetch_result($result, 0, "g_goods_cd");
                $array_g_goods_name[$line]      = pg_fetch_result($result, 0, "g_goods_name");
                $array_product_cd[$line]        = pg_fetch_result($result, 0, "product_cd");
                $array_product_name[$line]      = pg_fetch_result($result, 0, "product_name");
                $array_g_product_cd[$line]      = pg_fetch_result($result, 0, "g_product_cd");
                $array_g_product_name[$line]    = pg_fetch_result($result, 0, "g_product_name");

                //調査表作成時の商品との重複チェックに使う
                $goods_cd_str .= "'$goods_cd', ";
            }

        }

        $injustice_error_mess .= ($injustice_error_mess != "") ? "商品情報が取得できませんでした。再度操作を行って下さい。" : "";

        $goods_cd_str = substr($goods_cd_str, 0, strlen($goods_cd_str) - 2);

        //入力商品と同じ商品コードが、調査表作成時にないか
        $sql  = "SELECT \n";
        $sql .= "    t_contents.goods_cd \n";
        $sql .= "FROM \n";
        $sql .= "    t_invent \n";
        $sql .= "    INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_invent.invent_id = $invent_id \n";
        $sql .= "    AND \n";
        $sql .= "    t_contents.goods_cd IN ($goods_cd_str) \n";
        $sql .= "    AND \n";
        $sql .= "    t_contents.add_flg = false \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        //重複がある場合
        $same_goods_count = pg_num_rows($result);
        for($i=0, $db_unique_error_mess=""; $i<$same_goods_count; $i++){
            //重複した商品の 商品CD[行番号] を取得
            $array_same_line = array_intersect($array_goods_cd, array(pg_fetch_result($result, $i, 0)));

            //行番号配列から、No.を出力
            foreach($array_same_line as $key => $value){
                $db_unique_error_mess .= $array_row_num[$key]."行目 ";
            }

            $error_flg = true;
        }
        $db_unique_error_mess .= ($same_goods_count != 0) ? "の商品は棚卸調査表に存在するため、追加できません。<br>" : "";
//print_array($db_unique_error_mess, "調査表と重複チェック");


        //追加商品の中の重複チェック
        $diff_array = array_diff_assoc($array_goods_cd, array_unique($array_goods_cd));
        $diff_array_unique = array_unique($diff_array);     //3つ以上かぶってるかもしれないので、重複をはぶく
        foreach($diff_array_unique as $value){
            $diff_array_keys = array_keys($array_goods_cd, $value);
            foreach($diff_array_keys as $value2){
                $unique_error_mess .= $array_row_num[$value2]."行目 ";
            }
            $unique_error_mess .= "の商品が重複しています。<br>";
            $error_flg = true;
        }

    }
//print_array($unique_error_mess, "追加商品の重複チェック");


    //更新されていないかチェック
    $sql  = "SELECT ";
    $sql .= "    renew_flg ";
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    invent_id = $invent_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if(pg_fetch_result($result, 0, 0) == "t"){
        $renew_err_mess = "この棚卸調査表は既に棚卸更新されています。";
        $error_flg = true;
    }

    //棚卸入力中に調査表を削除・再作成されてないかチェック
    if(Update_Check($db_con, "t_invent", "invent_id", $invent_id, $enter_day) == false && $error_flg == false){
        $remake_err_mess = "棚卸調査表が変更されているため、登録できません。";
        $error_flg = true;
    }
//echo "エラーチェックおわり";exit();


    $error_flg = ($form->validate()) ? $error_flg : false;


    //エラーの場合はこれ以降の処理を行なわない
    if($error_flg == false){

        //-- 棚卸入力トランザクション開始 --//
        Db_Query($db_con, "BEGIN;");

        //棚卸ヘッダテーブル更新
        $sql  = "UPDATE ";
        $sql .= "    t_invent ";
        $sql .= "SET ";
        $sql .= "    staff_id = ".$_SESSION["staff_id"].", ";
        $sql .= "    staff_name = '".addslashes($_SESSION["staff_name"])."' ";
        $sql .= "WHERE ";
        $sql .= "    invent_id = $invent_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result == false) {
            Db_Query($db_con, "ROLLBACK;");
            exit();
        }


        //調査表にある商品の登録処理
        if($_POST["add_flg"] == "false"){

            foreach($array_goods_cd as $line => $goods_cd){
                $sql  = "UPDATE \n";
                $sql .= "    t_contents \n";
                $sql .= "SET \n";
                $sql .= "    tstock_num = ".$_POST["form_tstock_num"][$line].", \n";
                $sql .= "    price = ".$stock_price[$line].", \n";
                $sql .= "    staff_id = ".$_POST["form_staff"][$line].", \n";
                $sql .= "    staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".$_POST["form_staff"][$line]."), \n";
                $sql .= "    cause = "; 
                $sql .= ($_POST["form_cause"][$line] != null) ? "'".$select_reason[$_POST["form_cause"][$line]]."' \n" : "null \n"; 
                $sql .= "WHERE \n";
                $sql .= "    invent_id = $invent_id \n";
                $sql .= "    AND \n";
                $sql .= "    goods_cd = '$goods_cd' \n";
                $sql .= ";";
//print_array($sql);

                $result = Db_Query($db_con, $sql);
                if($result == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

            }

        //追加商品の登録処理
        }else{

            //追加商品データ全削除
            $sql = "DELETE FROM t_contents WHERE invent_id = $invent_id AND add_flg = true;";
            $result = Db_Query($db_con, $sql);
            if($result == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }


            //追加商品が0じゃない場合のみ登録
            if(count($array_goods_cd) > 0){

                foreach($array_goods_cd as $line => $goods_cd){

                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_contents \n";
                    $sql .= "( \n";
                    $sql .= "    invent_id, \n";    //棚卸調査ID 1
                    $sql .= "    goods_id, \n";     //商品ID 2
                    $sql .= "    stock_num, \n";    //帳簿数 3
                    $sql .= "    tstock_num, \n";   //実棚数 4
                    $sql .= "    price, \n";        //単価 5
                    $sql .= "    staff_id, \n";     //実棚確認者ID 6
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    cause, \n" : "";   //差異原因 7
                    $sql .= "    goods_cd, \n";     //商品CD 8
                    $sql .= "    goods_name, \n";   //商品名 9
                    $sql .= "    staff_name, \n";   //実棚確認者名 10
                    $sql .= "    g_goods_cd, \n";   //Ｍ区分CD 11
                    $sql .= "    g_goods_name, \n"; //Ｍ区分名 12
                    $sql .= "    add_flg, \n";      //追加フラグ 13
                    $sql .= "    g_product_cd, \n"; //商品分類CD 14
                    $sql .= "    g_product_name, \n";   //商品分類名 15
                    $sql .= "    goods_cname, \n";  //商品名（略称）16
                    $sql .= "    product_cd, \n";   //管理区分CD 17
                    $sql .= "    product_name \n";  //管理区分名 18

                    $sql .= ") VALUES ( \n";

                    $sql .= "    $invent_id, \n";                                       //棚卸調査ID 1
                    $sql .= "    ".$array_goods_id[$line].", \n";                       //商品ID 2
                    $sql .= "    ".$_POST["form_stock_num"][$line].", \n";              //帳簿数 3
                    $sql .= "    ".$_POST["form_tstock_num"][$line].", \n";             //実棚数 4
                    $sql .= "    ".$stock_price[$line].", \n";                          //単価 5
                    $sql .= "    ".$_POST["form_staff"][$line].", \n";                  //実棚確認者ID 6
                    $sql .= ($_POST["form_cause"][$line] != null) ? "    '".$select_reason[$_POST["form_cause"][$line]]."', \n" : "";   //差異原因 7
                    $sql .= "    '".$goods_cd."', \n";                                  //商品CD 8
                    $sql .= "    '".addslashes($array_goods_name[$line])."', \n";       //商品名 9
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$_POST["form_staff"][$line]."), \n";      //実棚確認者名 10
                    $sql .= "    '".$array_g_goods_cd[$line]."', \n";                   //Ｍ区分CD 11
                    $sql .= "    '".addslashes($array_g_goods_name[$line])."', \n";     //Ｍ区分名 12
                    $sql .= "    true, \n";                                             //追加フラグ 13
                    $sql .= "    '".$array_g_product_cd[$line]."', \n";                 //商品分類CD 14
                    $sql .= "    '".addslashes($array_g_product_name[$line])."', \n";   //商品分類名 15
                    $sql .= "    '".addslashes($array_goods_cname[$line])."', \n";      //商品名（略称） 16
                    $sql .= "    '".$array_product_cd[$line]."', \n";                   //管理区分CD 17
                    $sql .= "    '".addslashes($array_product_name[$line])."' \n";      //管理区分名 18
                    $sql .= ") \n";
                    $sql .= ";\n";
//print_array($sql);

                    $result = Db_Query($db_con, $sql);
                    if($result == false) {
                        Db_Query($db_con, "ROLLBACK;");
                        exit();
                    }
                }
            }

        }//追加商品の登録処理おわり

        //-- 棚卸入力トランザクション終了 --//
        Db_Query($db_con, "COMMIT;");
        //Db_Query($db_con, "ROLLBACK;");


    }//登録処理おわり

}

//登録完了ボタン押下時なら、調査表一覧画面へ遷移
if($_POST["form_entry_button"] != null && $error_flg == false){
    header("Location: $transition_url");
    exit();
}



//--------------------------//
//ページ数等設定
//--------------------------//

//POSTがないとき（初期表示時）
if($_POST == null){
    $offset_line = 0;       //表示開始行
    $page_num = 1;          //ページ番号
    $add_flg = "false";     //最初は固定の商品を表示

}else{

    //エラー時は前の状態
    if($error_flg == true){
        $offset_line = $_POST["offset_line"];
        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //次へボタンが押されている
    }elseif($_POST["form_entry_next"] != null){
        //前の開始行＋1ページの表示件数
        $offset_line = $_POST["offset_line"] + $limit;      //表示開始行

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] + 1;

    //前へボタンが押されている
    }elseif($_POST["form_entry_back"] != null){
        //前の開始行−1ページの表示件数
        $offset_line = $_POST["offset_line"] - $limit;      //表示開始行

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"] - 1;

    //登録して商品追加、商品追加ボタンが押されている
    }elseif($_POST["form_entry_add_button"] != null || $_POST["form_add_button"] != null){
        //調査表の商品数
        $offset_line = $contents_num;

    //行追加・削除リンク、商品コード入力、一括設定ボタン、または登録完了ボタン押下時
    }elseif($_POST["del_row"] != null || $_POST["add_row_flg"] != null || $_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null){
        //前の状態
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //ページ切替セレクト
    }elseif($_POST["f_page1"] != null){
        $offset_line = ($_POST["f_page1"] == null) ? 0 : ($_POST["f_page1"] - 1) * $limit;

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];

    //その他（商品ダイアログを開いて、閉じたときとか）
    }else{
        //前の状態
        $offset_line = $_POST["offset_line"];

        $page_num = ($_POST["f_page1"] == null) ? 1 : $_POST["f_page1"];
    }


    //エラー時は前の状態
    if($error_flg == true){
        $add_flg = $_POST["add_flg"];

    }elseif($_POST["form_add_button"] != null || $_POST["form_entry_add_button"] != null){
        //追加、登録して追加ボタンが押されていたら追加商品を表示
        $add_flg = "true";

    }else{
        //追加ボタンが押されていなかったら前の状態を表示
        $add_flg = $_POST["add_flg"];
    }
}
//print_array($offset_line, '$offset_line');
//print_array($page_num, '$page_num');
//print_array($add_flg, '$add_flg');


$con_data["offset_line"] = $offset_line;
$con_data["add_flg"] = $add_flg;
$con_data["f_page1"] = $page_num;
$con_data["f_page2"] = $page_num;



/****************************/
//フォーム作成
/****************************/

//棚卸実施者
$select_value_staff = Select_Get($db_con, "staff");
$form->addElement("select","form_staff_set","",$select_value_staff, $g_form_option_select);

//行（棚卸実施者）
$form_line[] =& $form->createElement(
    "text","start","","size=\"11\" maxLength=\"9\" 
     style=\"text-align: right; $g_form_style\" $g_form_option"); 
$form_line[] =& $form->createElement("static","","","行　〜　");
$form_line[] =& $form->createElement(
    "text","end","","size=\"11\" maxLength=\"9\"
     style=\"text-align: right; $g_form_style\" $g_form_option");
$form_line[] =& $form->createElement("static","","","行");
$form->addGroup($form_line, "form_line", "");

//一括設定
$form->addElement("submit","form_conf_button","一括設定");


//ページ切替セレクト
$page_num_all = (int)($contents_num / $limit);
$page_num_all = (($contents_num % $limit) == 0) ? $page_num_all : $page_num_all + 1;
//1ページだけじゃなかったら、セレクトボックス生成
if($page_num_all != 1){
    for($i=1; $i<=$page_num_all; $i++){
        $select_page[$i] = "$i";
    }
    $form->addElement("select", "f_page1", "", $select_page, " onChange=\"page_check(1); window.focus();\" onKeyDown=\"chgKeycode();\"");
    $form->addElement("select", "f_page2", "", $select_page, " onChange=\"page_check(2); window.focus();\" onKeyDown=\"chgKeycode();\"");
}


//登録ボタン
//$form->addElement("submit","form_entry_button","登　録", "$disabled");

//一時登録ボタン
//$form->addElement("submit","form_temp_button","一時登録", "$disabled");

//戻る
$form->addElement("button","form_back_button","戻　る", "onClick=\"javascript:location.href=('$pre_url');");


//次へボタン
$next_disabled = ($page_num == $page_num_all) ? "disabled" : $disabled;     //最終ページならdisabled
$form->addElement("submit", "form_entry_next", "登録して次へ", "$next_disabled");

//前へボタン
$back_disabled = ($page_num == 1) ? "disabled" : $disabled;     //1ページ目ならdisabled
$form->addElement("submit", "form_entry_back", "登録して前へ", "$back_disabled");

//調査表にある商品の入力時
if($add_flg == "false"){
    //追加ボタン
    $form->addElement("submit", "form_add_button", "商品追加");
//商品追加時
}else{
    //調査表入力ボタン
    $form->addElement("button", "form_input_button", "調査表入力", "onClick=\"javascript:location.href=('".$_SERVER["PHP_SELF"]."?invent_no=".$_GET["invent_no"]."&ware_id=".$_GET["ware_id"]."');");
}

//調査表商品入力画面で最終ページなら、登録して商品追加ボタン
if($add_flg == "false" && $page_num == $page_num_all){
    $form->addElement("submit", "form_entry_add_button", "登録して商品追加", "$disabled");
}

//完了ボタン
$form->addElement("submit", "form_entry_button","登録完了", "$disabled");


/****************************/
//初期設定
/****************************/
//表示行数
if($error_flg == true){
    $max_row = $_POST["max_row"];
}elseif($_POST["form_add_button"] != null || $_POST["form_entry_add_button"] != null){
    $max_row = 1;
}elseif(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
//}elseif($target_goods == "在庫数0"){
}else{
    $max_row = 0;
//}else{
//    $max_row = 1;
}
//削除行数
$del_history[] = null;


/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]==true){
    //最大行に、＋１する
    //$max_row = $_POST["max_row"]+1;
    $max_row = $_POST["max_row"]+10;
    //行数追加フラグをクリア
    $con_data["add_row_flg"] = "";
    //$form->setConstants($con_data);
}

/****************************/
//行削除処理
/****************************/
if(isset($_POST["del_row"])){

    //削除リストを取得
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);
}


/***************************/
//初期値設定
/***************************/
$con_data["max_row"] = $max_row;


/*****************************/
//画面表示
/*****************************/

//ヘッダ情報取得
$sql  = "SELECT ";
$sql .= "   ware_name, ";
$sql .= "   target_goods ";
$sql .= "FROM ";
$sql .= "   t_invent ";
$sql .= "WHERE ";
$sql .= "   invent_no = '".$_GET["invent_no"]."' ";
$sql .= "AND ";
$sql .= "   ware_id = ".(int)$_GET["ware_id"]." ";
$sql .= "AND ";
$sql .= "   shop_id = $shop_id ";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$array_header = Get_Data($result, 2);

//棚卸調査行番号
$invent_no = $_GET["invent_no"];

//倉庫名
$ware_name = htmlspecialchars($array_header[0][0]);

//対象商品
if($array_header[0][1] == "1"){
    $target_goods = "全商品";
} elseif($array_header[0][1] == "2"){
    $target_goods = "在庫数0以外";
} elseif($array_header[0][1] == "3"){
    $target_goods = "在庫数0";
}


/****************************/
//表示データ取得
/****************************/

//hidden
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "goods_search_row");    //商品コード入力行
$form->addElement("hidden", "hdn_enter_day");       //登録日

$form->addElement("hidden", "offset_line");         //表示開始行
$form->addElement("hidden", "add_flg");             //固定商品か追加商品か判定フラグ


//表示データ取得
$sql  = "SELECT \n";
$sql .= "    t_contents.goods_cd, \n";      //商品コード 0
$sql .= "    t_contents.goods_name, \n";    //商品名 1
$sql .= "    t_goods.unit, \n";             //単位 2
$sql .= "    t_contents.price, \n";         //単価 3
$sql .= "    t_contents.stock_num, \n";     //帳簿数 4
$sql .= "    t_contents.tstock_num, \n";    //実棚数 5
//$sql .= "    t_contents.stock_num - t_contents.tstock_num AS diff_num, ";   //差異 6
$sql .= "    t_contents.tstock_num - t_contents.stock_num AS diff_num, \n";     //差異 6
$sql .= "    t_staff.staff_id, \n";         //棚卸実施者スタッフID 7
$sql .= "    t_contents.cause, \n";         //差異原因 8
$sql .= "    t_contents.add_flg, \n";       //追加フラグ 9
$sql .= "    t_contents.staff_name, \n";    //入力者名（履歴用hidden） 10
$sql .= "    t_contents.g_goods_cd, \n";    //Ｍ区分コード（履歴用hidden）11
$sql .= "    t_contents.g_goods_name, \n";  //Ｍ区分名（履歴用hidden）12
$sql .= "    t_contents.g_product_cd, \n";  //商品分類コード（履歴用hidden）13
$sql .= "    t_contents.g_product_name, \n";//商品分類名 14
$sql .= "    t_contents.goods_cname, \n";   //商品名（略称）（履歴用hidden）15
$sql .= "    t_contents.product_cd, \n";    //管理区分コード（履歴用hidden）16
$sql .= "    t_contents.product_name \n";   //管理区分名（履歴用hidden）17
$sql .= "FROM \n";
$sql .= "    ( \n";
$sql .= "        ( \n";
$sql .= "        t_invent \n";
$sql .= "        INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id \n";
$sql .= "        ) INNER JOIN t_goods ON t_goods.goods_id = t_contents.goods_id \n";
$sql .= "    ) LEFT JOIN t_staff ON t_staff.staff_id = t_contents.staff_id \n";
$sql .= "WHERE \n";
$sql .= "    t_invent.invent_no = '".$_GET["invent_no"]."' \n";
$sql .= "AND \n";
$sql .= "    t_invent.ware_id = ".(int)$_GET["ware_id"]." \n";
$sql .= "AND \n";
$sql .= "    t_invent.shop_id = $shop_id \n";
//$sql .= "AND ";
//$sql .= "    t_invent.renew_flg = false ";
$sql .= "AND \n";
$sql .= "    t_contents.add_flg = $add_flg \n";
$sql .= "ORDER BY \n";
$sql .= "    t_contents.add_flg ASC, \n";
$sql .= "    t_contents.g_product_cd ASC, \n";
$sql .= "    t_contents.goods_cd ASC \n";
if($add_flg == "false"){
    $sql .= "OFFSET $offset_line \n";
    $sql .= "LIMIT $limit \n";
}
$sql .= ";";
//print_array($sql, "一覧取得SQL");

$result = Db_Query($db_con, $sql);
//Get_Id_Check($result);

$disp_num = pg_num_rows($result);   //表示行数

//HTML生成
$array_db = Get_Data($result, 2);
//print_array($array_db, "DB配列：");
$array_size = count($array_db);

//print_array($del_history, "削除履歴：");


/****************************/
//フォーム作成
/****************************/

//棚卸調査表作成時に生成したデータ
//if($add_flg == "false"){

for($i=0, $no=$offset_line+1, $row_num=$offset_line+1; $i<$array_size+$max_row; $i++, $no++){

    //削除行判定
    if(!in_array($no, $del_history)){

        //削除履歴
        $del_data = ($del_row == "") ? $no : $del_row.",".$no;

        //フォーム生成
        Draw_Row($add_flg, $no, $form, $select_value_staff, $select_reason, $del_data, $target_goods, $invent_id, $dialog_goods_url);


        //フォームにデータをセット
        $disp_data[$no]       = $row_num;        //行番号

        $def_data["form_g_product_name"][$no]   = $array_db[$i][14];    //商品分類
        $def_data["form_goods_cd"][$no]         = $array_db[$i][0];     //商品CD
        $def_data["form_goods_name"][$no]       = $array_db[$i][1];     //商品名
        $def_data["form_unit"][$no]             = $array_db[$i][2];     //単位

        $price = explode(".", $array_db[$i][3]);
        $def_data["form_price"][$no]["i"]       = $price[0];            //在庫単価（整数）
        $def_data["form_price"][$no]["d"]       = $price[1];            //在庫単価（小数）
        $def_data["form_stock_num"][$no]        = $array_db[$i][4];     //帳簿数
        $def_data["form_tstock_num"][$no]       = $array_db[$i][5];     //実棚数
        $def_data["form_diff_num"][$no]         = $array_db[$i][6];     //差異


        //棚卸実施者一括設定
        if($staff_set !== null){
            //範囲内の行なら設定
            if($line_start <= $row_num && $line_end >= $row_num){
                $staff_con_data["form_staff"][$no] = $staff_set;
            }
        //DBからの値を設定
        }else{
            $def_data["form_staff"][$no] = $array_db[$i][7];
        }
        $def_data["form_cause"][$no] = array_search($array_db[$i][8], $select_reason);

        if($array_db[$i][13] == "t"){
            $def_data["form_g_product_name"][$no] = $array_db[$i][15];
        }

        //行番号を＋１
        $row_num = $row_num+1;

    }

}
//print_array($i, "ループ");
//print_array($no, "行番号");
//print_array($disp_data);


//初期表示、ページ切替、行追加・削除リンク、次へ・前へ・登録して商品追加・商品追加・調査表入力の各ボタンが押された場合、
//（ページ切替セレクトの判定ができないため、上記以外の場合）
//一括設定行フォームを設定
if(!($_POST["goods_search_row"] != null || $_POST["form_conf_button"] != null || $_POST["form_entry_button"] != null)){
    //棚卸実施者一括設定の行番号にセットする用
    $con_data["form_line"]["start"] = $offset_line + 1;
    $con_data["form_line"]["end"]   = $row_num - 1;
}


$form->setDefaults($def_data);
$form->setConstants($staff_con_data);


$form->setConstants($con_data);



/****************************/
//ローカルJavaScript
/****************************/
$html_js = <<<JS

<script langage="javascript">
<!--

function InD(row)
{
    var SN = "form_stock_num["+row+"]";
    var TN = "form_tstock_num["+row+"]";
    var DN = "form_diff_num["+row+"]";

    //実棚数が数値の場合、帳簿数との差を表示
    if(isNaN(document.dateForm.elements[TN].value) == false && document.dateForm.elements[TN].value != ""){
        document.dateForm.elements[DN].value = document.dateForm.elements[TN].value - document.dateForm.elements[SN].value;

    //数値じゃない場合、何も表示しない
    }else{
        document.dateForm.elements[DN].value = "";
    }

    return true;
}

//-->
</script>

JS;



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
//$page_menu = Create_Menu_f('stock','2');

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
    //'html'          => "$html",
    'html_js'       => "$html_js",
    'invent_no'     => "$invent_no", 
    'expected_day'  => "$expected_day", 
    'ware_name'     => "$ware_name", 
    'target_goods'  => "$target_goods", 
    'price_error_mess'  => "$price_error_mess", 
    'tstock_error_mess' => "$tstock_error_mess", 
    'staff_error_mess'  => "$staff_error_mess", 
    'db_unique_error_mess'  => "$db_unique_error_mess", 
    'unique_error_mess' => "$unique_error_mess", 
    'injustice_error_mess'  => "$injustice_error_mess", 
    'staff_line_err'    => "$staff_line_err", 
    'staff_select_err'  => "$staff_select_err", 
    'cause_error_mess'  => "$cause_error_mess", 
    'renew_err_mess'    => "$renew_err_mess", 
    'remake_err_mess'   => "$remake_err_mess", 
    'add_flg'       => "$add_flg", 
));

$smarty->assign('disp_data', $disp_data);


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"] .".tpl"));

//echo microtime()."<br>";

//print_array($_SESSION);
//print_array($_POST, '$_POST');
//print_array($_GET);


/**
 *
 * 棚卸入力フォームを1行生成
 *
 * @param       array       $array                  1行分のデータ
 * @param       int         $i                      フォーム用行番号
 * @param       object      $form                   HTML_QuickFormのオブジェクト
 * @param       array       $select_value_staff     スタッフ名の配列
 * @param       array       $select_reason          差異理由の配列
 * @param       string      $del_data               削除履歴
 * @param       string      $target_goods           対象商品
 * @param       int         $invent_id              棚卸調査ID
 * @param       string      $dialog_goods_url       ダイアログURL
 *
 * @return      array       表示データ
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/05/12)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/05/10      xx-xxx      kajioka-h   ページ切替できるように変更
 *
 */
function Draw_Row($add_flg, $i, $form, $select_value_staff, $select_reason, $del_data, $target_goods, $invent_id, $dialog_goods_url)
{
//print_array($array);

    //グローバル変数
    global $g_form_option, $g_form_option_select, $g_form_style;

    //ReadOnlyフォームスタイル
    $form_ro_style = "color: #555555; border: #ffffff 1px solid; background-color: #ffffff;";


    //商品分類
    $freeze_data = $form->addElement(
        "text", "form_g_product_name[$i]", "テキストフォーム",
        "size=\"25\" maxLength=\"10\", readonly 
         style=\"$form_ro_style\""
    );

    //商品CD
    $form->addElement(
        "text", "form_goods_cd[$i]", "テキストフォーム",
        "size=\"10\" maxLength=\"8\", style=\"$g_form_style\" $g_form_option 
         onChange=\"javascript: goods_search_1(this.form, 'form_goods_cd', 'goods_search_row', $i);\""
    );

    //商品追加行の場合は、検索リンクも
    if($add_flg == "true"){
        $form->addElement("link","form_search[$i]","","#","検索",
            " onClick=\"return Open_SubWin('".$dialog_goods_url."',Array('form_goods_cd[$i]','goods_search_row'),500,450,'2','$invent_id','$i');\""
        );
    }

    //商品名
    $form->addElement(
        "text", "form_goods_name[$i]", "テキストフォーム",
        "size=\"70\" maxLength=\"35\", readonly"
    );

    //単位
    $form->addElement(
        "text", "form_unit[$i]", "テキストフォーム",
        "size=\"5\" maxLength=\"5\", readonly 
         style=\"$form_ro_style\""
    );


    //商品分類、単位をフリーズ
    $freeze_data = array(
        "form_g_product_name[$i]",
        "form_unit[$i]",
    );
    //商品追加の行じゃない場合、商品CD、商品名もフリーズ
    if($add_flg != "true"){
        $freeze_data[] = "form_goods_cd[$i]";
        $freeze_data[] = "form_goods_name[$i]";
    }
    $form->freeze($freeze_data);


    //在庫単価
    $price = explode(".", $array[3]);
    $form->addElement(
        "text", "form_price[$i][i]", "テキストフォーム", 
        "class=\"money\" size=\"11\" maxLength=\"9\" 
         onKeyup=\"changeText(this.form, 'form_price[$i][i]', 'form_price[$i][d]', 9, '00')\"
         $g_form_option style=\"text-align: right; $g_form_style\"" 
    );
    $form->addElement(
        "text", "form_price[$i][d]", "テキストフォーム", 
        "size=\"1\" maxLength=\"2\" 
         $g_form_option style=\"text-align: left; $g_form_style\""
    );


    //帳簿数
    $form->addElement("text", "form_stock_num[$i]", "テキストフォーム", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //実棚数
    $form->addElement("text", "form_tstock_num[$i]", "テキストフォーム", 
        "class=\"money\" size=\"11\" maxLength=\"9\", 
         $g_form_option style=\"text-align: right; $g_form_style\" onKeyup=\"return InD($i);\""
    );

    //差異
    $form->addElement("text", "form_diff_num[$i]", "テキストフォーム", 
        "size=\"11\" maxLength=\"9\", readonly 
         style=\"text-align: right; $form_ro_style $g_form_style\""
    );

    //棚卸実施者
    $form->addElement("select", "form_staff[$i]", "", $select_value_staff, $g_form_option_select);

    //差異原因
    $form->addElement("select", "form_cause[$i]", "", $select_reason, $g_form_option_select);

    //削除リンク
    //在庫数0の場合は行の追加、削除はなし
    if($target_goods != "在庫数0" && $add_flg == "true"){
        $form->addElement("link","add_row_del[$i]","","#","削除",
            " onClick=\"javascript:return Dialogue_1('削除します。', '$del_data', 'del_row')\""
        );
    }

/*
    $add_flg = ($add_flg == "t") ? "true" : "false";
    $form->addElement("hidden", "form_add_flg[$i]", $add_flg);      //追加フラグ
*/

    return "";

}


?>
