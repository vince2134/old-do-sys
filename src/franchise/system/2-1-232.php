<?php
$page_title = "サービスマスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/******************************/
//CSV出力ボタン押下処理
/*****************************/
if($_POST["csv_button_flg"]==true){
    /** CSV作成SQL **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //サービスコード
    $sql .= "serv_name,";              //サービス名
	$sql .= "CASE tax_div ";           //課税区分
	$sql .= "    WHEN '1' THEN '外税'";
	$sql .= "    WHEN '2' THEN '内税'";
	$sql .= "    WHEN '3' THEN '非課税'";
    $sql .= "END,";
	$sql .= "note ";                   //備考
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "OR ";
    $sql .= "public_flg = true ";
    $sql .= " AND";
    $sql .= " accept_flg = '1'";
    $sql .= "ORDER BY ";
    $sql .= "serv_cd;";

    $result = Db_Query($db_con,$sql);

    //CSVデータ取得
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //サービスコード
        $serv_data[$i][0] = $data_list[0];
        //サービス名
        $serv_data[$i][1] = $data_list[1];
        //課税区分
        $serv_data[$i][2] = $data_list[2];
		//備考
        $serv_data[$i][3] = $data_list[3];
        $i++;
    }

    //CSVファイル名
    $csv_file_name = "サービスマスタ".date("Ymd").".csv";
    //CSVヘッダ作成
    $csv_header = array(
        "サービスコード", 
        "サービス名",
		"課税区分",
        "備考"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($serv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;    
}

/****************************/
//部品定義
/****************************/
//CSV出力
$form->addElement("button","csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

//CSV出力ボタン押下判定フラグ
$form->addElement("hidden", "csv_button_flg");

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** サービスマスタ取得SQL作成 **/
$sql = "SELECT ";
$sql .= "serv_id,";                //サービスID
$sql .= "serv_cd,";                //サービスコード
$sql .= "serv_name,";              //サービス名
$sql .= "CASE tax_div ";           //課税区分
$sql .= "    WHEN '1' THEN '外税'";
$sql .= "    WHEN '2' THEN '内税'";
$sql .= "    WHEN '3' THEN '非課税'";
$sql .= "END,";
$sql .= "note ";                   //備考
$sql .= "FROM ";
$sql .= "t_serv ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$sql .= "OR ";
$sql .= "public_flg = true ";
$sql .= " AND";
$sql .= " accept_flg = '1'";
$sql .= "ORDER BY ";
$sql .= "serv_cd;";

$result = Db_Query($db_con,$sql);
//全件数取得(ヘッダー)
$total_count = pg_num_rows($result);

//行データ部品を作成
$row = Get_Data($result);

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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
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
    'total_count'   => "$total_count",
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
