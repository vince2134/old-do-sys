<?php
/**************************************/
/*変更履歴
 *  ・（2006-11-28）サニタイジング処理追加<suzuki>
 *  ・（2007-05-17）状態の検索を追加<watanabe-k>
 *
/**************************************/

$page_title = "仕入先一覧";

//環境設定ファイル
require_once("ENV_local.php");

//サンプル関数
//require_once(PATH."function/sample_func_watanabe.inc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DBに接続
$conn = Db_Connect();
/****************************/
//外部変数取得
/****************************/
session_start();
$shop_id    = $_SESSION["client_id"];

//submitをして、戻り値を変更する判定フラグ
$display = $_GET['display'];
$select_id = $_GET['select_id'];
$shop_aid = $_GET["shop_aid"];

//hiddenにより保持する
if($_GET['display'] != NULL){
	$set_id_data["hdn_display"] = $display;
	$form->setConstants($set_id_data);
}else{
	$display = $_POST["hdn_display"];
}

if($_GET['select_id'] != NULL){
	$set_id_data["hdn_select_id"] = $select_id;
	$form->setConstants($set_id_data);
}else{
	$select_id = $_POST["hdn_select_id"];
}

if($_GET['shop_aid'] != NULL){
	$set_id_data["hdn_shop_aid"] = $shop_aid;
	$form->setConstants($set_id_data);
}else{
	$shop_aid = $_POST["hdn_shop_aid"];
}

/****************************/
// フォームパーツ定義
/***************************/
// 仕入先コード
$form->addElement("text", "form_supplier_cd", "仕入先コード", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" $g_form_option");

// 仕入先名
$form->addElement("text", "form_supplier_name", "仕入先名", "size=\"34\" maxLength=\"15\" $g_form_option");

// 略称
$form->addElement("text","form_supplier_cname","","size=\"22\" maxLength=\"10\" $g_form_option");

// 業種
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_sbtype.sbtype_id,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name";
$sql .= " FROM";
$sql .= "   t_lbtype";
$sql .= "       INNER JOIN";
$sql .= "   t_sbtype";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

while($data_list = pg_fetch_array($result)){
    if($max_len < mb_strwidth($data_list[1])){
        $max_len = mb_strwidth($data_list[1]);
    }
}

$result = Db_Query($conn, $sql);
$select_value = "";
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $space = "";
    for($i = 0; $i< $max_len; $i++){
        if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                $data_list[1] = $data_list[1]."　";
        }
    }
    
    $select_value[$data_list[2]] = $data_list[0]." ： ".htmlspecialchars($data_list[1])."　　 ".$data_list[3]." ： ".htmlspecialchars($data_list[4]);
}
$form->addElement("select", "form_btype_name", "業種", $select_value, $g_form_option_select);
    
// 状態
$form_state[] =& $form->createElement("radio", null, null, "取引中", "1");
$form_state[] =& $form->createElement("radio", null, null, "解約・休止中", "2");
$form_state[] =& $form->createElement("radio", null, null, "全て", "3");
$form->addGroup($form_state, "form_state", "状態");

// ソート順
$form_sort[] =& $form->createElement("radio", null, null, "コード順", "1");
$form_sort[] =& $form->createElement("radio", null, null, "アイウエオ順", "2");
$form->addGroup($form_sort, "form_sort_type", "表示順");

$form->addElement("submit", "form_show_button", "表　示", "");
$form->addElement("button", "form_clear_button", "閉じる", "onClick=\"window.close()\"");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");
$form->addElement("hidden","hdn_shop_aid","","");

/****************************/
//全件取得
/***************************/
$supplier_sql  = " SELECT";
$supplier_sql .= "     t_client.client_cd1,";
$supplier_sql .= "     t_client.client_name,";
$supplier_sql .= "     t_client.client_cname,";
$supplier_sql .= "     t_sbtype.sbtype_name,";
$supplier_sql .= "     CASE t_client.state ";
$supplier_sql .= "      WHEN '1' THEN '取引中' ";
$supplier_sql .= "      WHEN '2' THEN '解約・休止中' ";
$supplier_sql .= "     END AS state ";
$supplier_sql .= " FROM";
$supplier_sql .= "     t_client";
$supplier_sql .= "  LEFT JOIN";
$supplier_sql .= "     t_sbtype";
$supplier_sql .= "  ON t_client.sbtype_id = t_sbtype.sbtype_id";
$supplier_sql .= " WHERE";
$supplier_sql .= "     t_client.shop_id = $shop_id";
//$supplier_sql .= "     AND";
//$supplier_sql .= "     t_client.state = 1";
$supplier_sql .= "     AND";
$supplier_sql .= "     t_client.client_div = 2";


$def_sql = " AND t_client.state = '1' ";

//ヘッダーに表示させる全件数
$total_count_sql = $supplier_sql;
$count_res = Db_Query($conn, $total_count_sql.$def_sql." ORDER BY t_client.client_cd1;");
$total_count = pg_num_rows($count_res);


/****************************/
//初期値設定
/****************************/
$def_data["form_sort_type"]  = "1";
$def_data["form_state"]  = "1";

$form->setDefaults($def_data);
/****************************/
//ボタン押下処理
/****************************/
if($_POST["form_show_button"] == "表　示"){
    $supplier_cd    = $_POST["form_supplier_cd"];
    $supplier_name  = $_POST["form_supplier_name"];
    $supplier_cname = $_POST["form_supplier_cname"];
    $btype_id       = $_POST["form_btype_name"];
    $sort           = $_POST["form_sort_type"];
    $state          = $_POST["form_state"];


    /****************************/
    //where_sql作成
    /****************************/
    //仕入先コード
    if($supplier_cd != null){
        $supplier_cd1_sql  = " AND t_client.client_cd1 LIKE '$supplier_cd%'";
    }
   
    //仕入先名
    if($supplier_name != null){
        $supplier_name_sql  = " AND t_client.client_name LIKE '%$supplier_name%'";
    }

    //略称
    if($supplier_cname != null){
        $supplier_cname_sql = " AND t_client.client_cname LIKE '%$supplier_cname%'";
    }

    //業種
    if($btype_id != null){
        $btype_id_sql = "AND t_sbtype.sbtype_id = $btype_id";
	}

    //状態
    if($state != '3'){
        $state_sql = " AND t_client.state = '$state'";
    }

}

$where_sql  = $supplier_cd1_sql;
$where_sql .= $supplier_name_sql;
$where_sql .= $supplier_cname_sql;
$where_sql .= $btype_id_sql;
$where_sql .= $state_sql;
$where_sql .= $sort_sql;

/****************************/
//表示データ作成
/****************************/
//該当件数
//表示順
if($sort == 2){
    $sort_sql = " ORDER BY t_client.client_name ASC";
}else{
    $sort_sql = " ORDER BY t_client.client_cd1";
}
$supplier_sql .= $where_sql.$sort_sql;
$total_count_sql = $supplier_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$match_count = pg_num_rows($count_res);

//戻り値作成
for($i = 0; $i < $match_count; $i++){
    $page_data[] = @pg_fetch_array ($count_res, $i, PGSQL_NUM);
}
for($i = 0; $i < $match_count; $i++){
    for($j = 0; $j < count($page_data[$i]); $j++){
		//仕入先コード
		if($j==0){
			$return = "'".$page_data[$i][$j]."'";
		//仕入先名は'が入力される可能性がある為
		}else if($j==2){
			$single = addslashes($page_data[$i][$j]);
			$return = $return.",'".htmlspecialchars($single)."'";
		}
        $page_data[$i][$j] = htmlspecialchars($page_data[$i][$j],ENT_QUOTES);
    }
	//発注入力は、戻り値にコード・名前・trueを返す
	if($display == 5){
		$return_data[] = $return.",true";
    }elseif($display == 1){
		$return_data[] = $return.",".$shop_aid;
	}else{
		$return_data[] = $return;
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
//画面ヘッダー作成
/****************************/
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
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'match_count'   => "$match_count",
));

//テンプレートへ値を渡す
$smarty->assign("page_data",$page_data);
$smarty->assign('return_data', $return_data);
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
