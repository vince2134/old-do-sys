<?php
$page_title = "業種マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$get_btype_id = $_GET["btype_id"];
//Get_Id_Check2($get_btype_id);
/*****************************/
//オブジェクト作成
/*****************************/
//ボタン
//CSVボタン
$form->addElement(
        "submit","form_csv_button","CSV出力"
        );

/*****************************
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   btype_cd,";
$sql .= "   btype_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_btype";
$sql .= "   ORDER BY t_btype.btype_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSVボタン押下処理
/*****************************/
if($_POST["form_csv_button"] == "CSV出力"){

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $page_data = Get_Data($result);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][1];
        $csv_page_data[$i][2] = $page_data[$i][2];
    }

    $csv_file_name = "業種マスタ".date("Ymd").".csv";
    $csv_header = array(
        "業種コード",
        "業種名",
        "備考"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

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

$smarty->assign("page_data", $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
