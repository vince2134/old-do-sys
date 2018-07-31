<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2016/01/22                amano  Dialogue 関数でボタン名が送られない IE11 バグ対応  
*/

$page_title = "商品組立明細";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id      = $_SESSION["client_id"];
$get_build_id = $_GET["build_id"];
$get_type     = $_GET["new_flg"];

Get_Id_Check3($get_build_id);
if($get_type == "true"){
    $mesg_color = "#0000FF";
    $mesg       = "登録しました。";
}


/****************************/
//初期値設定
/****************************/
$def_data = array(
                "hdn_build_id" => "$get_build_id"
            );
$form->setDefaults($def_data);

/****************************/
//フォーム作成
/****************************/
//ヘッダボタン
$form->addElement("button", "new_button", "登　録","onClick=\"location.href='./1-4-109.php'\"");
$form->addElement("button", "list_button", "一　覧",$g_button_color." onClick=\"location.href='./1-4-115.php'\"");

$form->addElement("hidden", "hdn_build_id");

//削除ボタン
$form->addElement("submit", "form_del_button", "削　除", "onClick=\"javascript:return Dialogue('削除します。','#', this)\"");

//戻るボタン
$form->addElement("button", "form_back_button", "戻　る", "onClick=\"location.href='./1-4-115.php'\"");

//O　Kボタン
$form->addElement("button", "form_ok_button", "Ｏ　Ｋ", "onClick=\"location.href='./1-4-109.php'\"");

/****************************/
//イベント処理
/****************************/
$del_button_flg = ($_POST["form_del_button"] == "削　除")? true : false;

//削除ボタン押下処理
if($del_button_flg == true){

    $del_build_id = $_POST["hdn_build_id"];

    //削除
    $del_result_flg = Del_Build_Data($db_con, $del_build_id);

    if($del_result_flg === true){
        $mesg = "削除しました。";
        $mesg_color = "#0000FF";
    }else{
        $mesg = "すでに削除済みです。";
        $mesg_color = "#FF0000";
    }
}else{
    /****************************/
    //表示データ抽出
    /****************************/
    //完成品商品データ抽出
    $build_goods_data = Get_Build_Goods_Data($db_con, $get_build_id);

    //サニタイジング
    $build_goods_data = Html_Build_Data($build_goods_data);

    //部品データ抽出
    $parts_goods_data = Get_Parts_Goods_Data($db_con, $get_build_id);

    //サニタイジング
    $parts_goods_data = Html_Build_Data($parts_goods_data);
}

/****************************/
//関数作成
/****************************/
function Get_Build_Goods_Data($db_con, $build_id){

    if($build_id == null){
        return;
    }

    // 変更SQL
    $sql  = "SELECT ";
    $sql .= "   t_build.build_id, ";
    $sql .= "   LPAD(t_build.build_id, 8, 0) AS build_cd, ";
    $sql .= "   t_build.build_day, ";
    $sql .= "   t_goods.goods_cd, ";
    $sql .= "   t_goods.goods_name, ";
    $sql .= "   t_output_ware.ware_cd || ' : ' || t_output_ware.ware_name AS output_ware_name, ";
    $sql .= "   t_input_ware.ware_cd || ' : ' || t_input_ware.ware_name AS input_ware_name, ";
    $sql .= "   t_build.build_num ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_goods ";
    $sql .= "   ON t_build.goods_id = t_goods.goods_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_ware AS t_output_ware ";
    $sql .= "   ON t_build.output_ware_id = t_output_ware.ware_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_ware AS t_input_ware ";
    $sql .= "   ON t_build.input_ware_id = t_input_ware.ware_id ";
    $sql .= "WHERE ";
    $sql .= "   t_build.build_id = $build_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);

    //データがある場合は結果を配列に登録
    if(pg_num_rows($result) != "0"){
        $build_goods_data = pg_fetch_all($result);
    }
    return $build_goods_data;
}

function Get_Parts_Goods_Data($db_con, $build_id){

    if($build_id == null){
        return;
    }

    $sql  = "SELECT";
    $sql .= "   t_goods.goods_cd, ";
    $sql .= "   t_goods.goods_name, ";
    $sql .= "   t_make_goods.numerator || '/' || t_make_goods.denominator AS parts_num, ";
    $sql .= "   t_stock_hand.num ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_stock_hand ";
    $sql .= "   ON t_build.build_id = t_stock_hand.build_id ";
    $sql .= "   AND ";
    $sql .= "   t_build.build_id = $build_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_goods ";
    $sql .= "   ON t_stock_hand.goods_id = t_goods.goods_id "; 
    $sql .= "   AND ";
    $sql .= "   t_stock_hand.io_div = '2'";
    $sql .= "       LEFT JOIN ";
    $sql .= "   t_make_goods ";
    $sql .= "   ON t_goods.goods_id = t_make_goods.parts_goods_id ";
    $sql .= "   AND ";
    $sql .= "   t_build.goods_id = t_make_goods.goods_id ";
    $sql .= "WHERE ";
    $sql .= "   t_stock_hand.work_day > '".Get_Monthly_Renew($db_con)."' ";
    $sql .= "ORDER BY goods_cd ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);

    //データがある場合は結果を配列に登録
    if(pg_num_rows($result) != "0"){
        $parts_goods_data = pg_fetch_all($result);
    }
    return $parts_goods_data;
}

function Html_Build_Data($data){

    $count = count($data);

    if($count == 0){
        return;
    }

    for($i = 0; $i < $count; $i++){
        $data[$i]["no"] = $i + 1;

        foreach($data[$i] AS $key => $var){
            $data[$i][$key] = htmlspecialchars($var);
        }
    }

    return $data;
}

function Del_Build_Data($db_con, $build_id){

    Db_Query($db_con, "BEGIN;");

    $sql  = "SELECT";
    $sql .= "   COUNT(build_id) ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "WHERE ";
    $sql .= "   build_id = $build_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $add_num = pg_fetch_result($result, 0, 0);

    if($add_num == 0){
        return false;
    }

    //削除
    $sql  = "DELETE FROM t_build WHERE build_id = $build_id;";

    $resuld = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    Db_Query($db_con, "COMMIT;");
    return true;
}

//最新の月次更新日を抽出
function Get_Monthly_Renew($db_con, $div=null){
    //最新の月次更新日を取得
    $plus1_flg = true;
    $sql  = "SELECT";
    $sql .= "   COALESCE(MAX(close_day), null) ";
    $sql .= "FROM";
    $sql .= "   t_sys_renew ";
    $sql .= "WHERE";
    $sql .= "   shop_id = $_SESSION[client_id]";
    $sql .= "   AND";
    $sql .= "   renew_div = '2'";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $max_close_day = pg_fetch_result($result, 0,0);

    if ($div == '1'){
        $ary_close_day = explode('-', $max_close_day);
        $renew_date    = date("Y-m-d", mktime(0, 0, 0, $ary_close_day[1] , $ary_close_day[2]+1, $ary_close_day[0]));
    }else{
        $renew_date    = $max_close_day;
    }

    return $renew_date;
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
$page_title .= "　".$form->_elements[$form->_elementIndex[list_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'del_button_flg'    => "$del_button_flg",
    'mesg'              => "$mesg",
    'mesg_color'        => "$mesg_color",
)); 
$smarty->assign("build_goods_data", $build_goods_data);
$smarty->assign("parts_goods_data", $parts_goods_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
