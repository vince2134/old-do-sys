<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
*/

$page_title = "商品組立一覧";

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
$shop_id = $_SESSION["client_id"];

/****************************/
//初期値設定
/****************************/
$def_count = "50";
$renew_day =  Get_Monthly_Renew($db_con,1);
$renew_day = explode("-", $renew_day);
$def_data = array(
                "form_select_count"    => $def_count,
                "form_build_day_s[y]"  => $renew_day[0],
                "form_build_day_s[m]"  => $renew_day[1],
                "form_build_day_s[d]"  => $renew_day[2],
            );
$form->setDefaults($def_data);

/****************************/
//フォーム作成
/****************************/
// 表示件数
$select_count_arr = array(
"10" => "10",
"50" => "50",
"100" => "100",
"all" => "全て",
);
$form->addElement("select", "form_select_count", "表示件数", $select_count_arr);

// 組立番号
$form->addElement("text", "form_build_no", "組立管理番号", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 組立日
$freeze = Addelement_Date($form,"form_build_day_s","組立日","-");
$freeze->freeze();

Addelement_Date($form,"form_build_day_e","組立日","-");

// 完成品コード
$form->addElement("text", "form_goods_cd", "完成品コード", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 完成品名
$form->addElement("text","form_goods_name","完成品名",'size="56"'." $g_form_option");

// 引落倉庫
$select_value = Select_Get($db_con,'ware',"WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$form->addElement('select', 'form_output_ware_id', '引落倉庫', $select_value);

// 入庫倉庫
$form->addElement('select', 'form_input_ware_id', '入庫倉庫', $select_value);

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示", "");

// 検索条件記憶用hidden
$form->addElement("hidden", "hdn_select_count");
$form->addElement("hidden", "hdn_build_cd");
$form->addElement("hidden", "hdn_build_day_s");
$form->addElement("hidden", "hdn_build_day_e");
$form->addElement("hidden", "hdn_goods_cd");
$form->addElement("hidden", "hdn_goods_name");
$form->addElement("hidden", "hdn_output_ware_id");
$form->addElement("hidden", "hdn_input_ware_id");

//ヘッダボタン
$form->addElement("button", "new_button", "登　録","onClick=\"location.href='./1-4-109.php'\"");
$form->addElement("button", "list_button", "一　覧",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/****************************/
//フォームルール定義
/****************************/
$form->registerRule("check_date","function","Check_Date");
$form->addRule("form_build_day_s", "組立日が妥当ではありません。",  "check_date",$_POST["form_build_day_s"]); 
$form->addRule("form_build_day_e", "組立日が妥当ではありません。",  "check_date",$_POST["form_build_day_e"]); 

/****************************/
//イベント処理
/****************************/
//表示ボタン押下フラグ
$add_button_flg = ($_POST["form_show_button"] == "表　示")? true : false;

//ページ分けリンククリックフラグ
$add_link_flg   = ($add_button_flg == false && count($_POST) > 0 )? true : false;

//表示ボタン押下処理
if($add_button_flg == true){
    //値検証
    if($form->validate()){
        //検索条件
        $where["select_count"]      = $_POST["form_select_count"];
        $where["build_cd"]          = $_POST["form_build_no"];
        $where["build_day_s"]       = ($_POST["form_build_day_s"]["y"] != null)? str_pad($_POST["form_build_day_s"]["y"],4,0,STR_PAD_LEFT) : null;
        $where["build_day_s"]      .= ($_POST["form_build_day_s"]["m"] != null)? str_pad($_POST["form_build_day_s"]["m"],2,0,STR_PAD_LEFT) : null;
        $where["build_day_s"]      .= ($_POST["form_build_day_s"]["d"] != null)? str_pad($_POST["form_build_day_s"]["d"],2,0,STR_PAD_LEFT) : null;
        $where["build_day_e"]       = ($_POST["form_build_day_e"]["y"] != null)? str_pad($_POST["form_build_day_e"]["y"],4,0,STR_PAD_LEFT) : null;
        $where["build_day_e"]      .= ($_POST["form_build_day_e"]["m"] != null)? str_pad($_POST["form_build_day_e"]["m"],2,0,STR_PAD_LEFT) : null;
        $where["build_day_e"]      .= ($_POST["form_build_day_e"]["d"] != null)? str_pad($_POST["form_build_day_e"]["d"],2,0,STR_PAD_LEFT) : null;
        $where["goods_cd"]          = $_POST["form_goods_cd"];
        $where["goods_name"]        = $_POST["form_goods_name"];
        $where["output_ware_id"]    = $_POST["form_output_ware_id"];
        $where["input_ware_id"]     = $_POST["form_input_ware_id"];
        $where["offset"]            = 0;
    
        //検索条件をhiddenにセット
        $set_data["hdn_select_count"]       = $where["select_count"];
        $set_data["hdn_build_cd"]           = $where["build_cd"];
        $set_data["hdn_build_day_s"]        = $where["build_day_s"];
        $set_data["hdn_build_day_e"]        = $where["build_day_e"];
        $set_data["hdn_goods_cd"]           = $where["goods_cd"];
        $set_data["hdn_goods_name"]         = $where["goods_name"];
        $set_data["hdn_output_ware_id"]     = $where["output_ware_id"];
        $set_data["hdn_input_ware_id"]      = $where["input_ware_id"];
    }
//ページ分けリンク押下処理
}elseif($add_link_flg == true){
    $where["select_count"]      = ($_POST["hdn_select_count"] != null)? $_POST["hdn_select_count"] : $def_count;
    $where["build_cd"]          = $_POST["hdn_build_cd"];
    $where["build_day_s"]       = $_POST["hdn_build_day_s"];
    $where["build_day_e"]       = $_POST["hdn_build_day_e"];
    $where["goods_cd"]          = $_POST["hdn_goods_cd"];
    $where["goods_name"]        = $_POST["hdn_goods_name"];
    $where["output_ware_id"]    = $_POST["hdn_output_ware_id"];
    $where["input_ware_id"]     = $_POST["hdn_input_ware_id"];
    $where["offset"]            = ($_POST["f_page1"] -1) * $where["select_count"];
    $where["page"]              = $_POST["f_page1"];

//初期表示
}else{
    $where["build_day_s"] = Get_Monthly_Renew($db_con,1);
}

$form->setConstants($set_data);

/****************************/
//表示データ抽出
/****************************/
//検索条件
$where          = Get_Where_Data($where);

//全件数
$total_count    = Get_Build_Data($db_con, $where, "count");

//ページ分けリンク、プルダウン作成
if($where["select_count"] == "all"){
    $range = $total_count;
}else{
    $range = $where["select_count"];
}

$html_page  = Html_Page($total_count,$where["page"],1,$range);
$html_page2 = Html_Page($total_count,$where["page"],2,$range);

//データ抽出
$build_data     = Get_Build_Data($db_con, $where);

//サニタイズ
$build_data     = Html_Build_Data($build_data, $where["offset"]);

/****************************/
//関数作成
/****************************/
function Get_Where_Data($where){

    if($where["build_cd"] != null){
        $sql .= "WHERE ";
        $sql .= "LPAD(t_build.build_id, 8, 0) LIKE '".$where[build_cd]."%' ";
    }

    if($where["build_day_s"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_build.build_day >= '".$where[build_day_s]."' "; 
    }

    if($where["build_day_e"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_build.build_day <= '".$where[build_day_e]."' "; 
    }

    if($where["goods_cd"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_goods.goods_cd LIKE '".$where[goods_cd]."%' ";
    }

    if($where["goods_name"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_goods.goods_name LIKE '%".$where[goods_name]."%' ";
    }

    if($where["output_ware_id"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_build.output_ware_id = ".$where[output_ware_id]." ";
    }

    if($where["input_ware_id"] != null){
        $sql .= ($sql != null)? "AND " : "WHERE ";
        $sql .= "t_build.input_ware_id = ".$where[input_ware_id]." ";
    }

    $where["page"]          = ($where["page"] != null)?         $where["page"]          : 0; 
    $where["offset"]        = ($where["offset"] != null)?       $where["offset"]        : 0;
    $where["select_count"]  = ($where["select_count"] != null)? $where["select_count"]  : 50;

    $limit = "LIMIT ".$where[select_count]." OFFSET ".$where[offset]."";

    $where["sql"] = $sql;
    $where["limit"] = $limit;

    return $where;
}

function Get_Build_Data($db_con, $where, $div=null){

    if($div == "count"){
        $sql_column  = "SELECT ";
        $sql_column .= "    COUNT(t_build.build_id) ";
    }else{
        $sql_column  = "SELECT ";
        $sql_column .= "   t_build.build_id, ";
        $sql_column .= "   LPAD(t_build.build_id, 8, 0) AS build_cd, ";
        $sql_column .= "   t_build.build_day, ";
        $sql_column .= "   t_goods.goods_cd, ";
        $sql_column .= "   t_goods.goods_name, ";
        $sql_column .= "   t_output_ware.ware_name AS output_ware_name, ";
        $sql_column .= "   t_input_ware.ware_name AS input_ware_name, ";
        $sql_column .= "   t_build.build_num ";
    }

    $sql  = "FROM ";
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
    $sql .= $where["sql"];

    if($div == "count"){
        $result = Db_Query($db_con, $sql_column.$sql.";");
        $total_count = pg_fetch_result($result, 0,0);

        return $total_count;
    }

    $sql .= "ORDER BY ";
    $sql .= "   build_id DESC, build_day DESC ";
    $sql .= $where["limit"];
    $sql .= ";";

    $result = Db_Query($db_con, $sql_column.$sql);

    //データがある場合は結果を配列に登録
    if(pg_num_rows($result) != "0"){
        $build_data = pg_fetch_all($result);
    }
    return $build_data;
}

function Html_Build_Data($build_data, $no){

    $count = count($build_data);

    for ($i=0;$i<$count;$i++){
        $build_data[$i]["no"]               = $no + $i + 1;
        $build_data[$i]["build_cd"]         = "<a href=\"./1-4-116.php?build_id=".$build_data[$i][build_id]."\">".$build_data[$i]["build_cd"]."</a>";
        $build_data[$i]["goods_name"]       = htmlspecialchars($build_data[$i][goods_name]);
        $build_data[$i]["output_ware_name"] = htmlspecialchars($build_data[$i][output_ware_name]);
        $build_data[$i]["input_ware_name"]  = htmlspecialchars($build_data[$i][input_ware_name]);

        if(($i%2) == 0){
            $build_data[$i]["color"] = "Result1";
        }else{
            $build_data[$i]["color"] = "Result2";
        }
    }

    return $build_data;
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
    'html_page'         => "$html_page",
    'html_page2'        => "$html_page2",
));
$smarty->assign("build_data", $build_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
