<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/18                  kajioka-h   「Ｍ区分」→「大分類」に表現変更
 */

$page_title = "業種マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);

/****************************/
//外部変数取得
/****************************/
$get_btype_id = $_GET["btype_id"];

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
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_lbtype.note,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name,";
$sql .= "   t_sbtype.note";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       lbtype_id,";
$sql .= "       lbtype_cd,";
$sql .= "       lbtype_name,";
$sql .= "       note";
$sql .= "   FROM";
$sql .= "       t_lbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_lbtype";
$sql .= "       LEFT JOIN";
$sql .= "   (SELECT";
$sql .= "       sbtype_id,";
$sql .= "       lbtype_id,";
$sql .= "       sbtype_cd,";
$sql .= "       sbtype_name,";
$sql .= "       note";
$sql .= "   FROM";
$sql .= "       t_sbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_sbtype";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= "   ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

for($i = 0 ; $i < $total_count; $i++){
    for($j = 0 ; $j < $total_count; $j++){
        if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
            $page_data[$j][0] = "";
            $page_data[$j][1] = "";
            $page_data[$j][2] = "";
        }
    }
}

for($i = 0; $i < $total_count; $i++){
    if($page_data[$i][0] == null){        $tr[$i] = $tr[$i-1];
    }else{  
        if($tr[$i-1] == "Result1"){
            $tr[$i] = "Result2";
        }else{  
            $tr[$i] = "Result1";
        }       
    }
}


$sql  = "SELECT";
$sql .= "   COUNT(sbtype_id)";
$sql .= "FROM";
$sql .= "   t_sbtype";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_fetch_result($result,0,0);

/*****************************/
//CSVボタン押下処理
/*****************************/
if($_POST["form_csv_button"] == "CSV出力"){
	$sql  = "SELECT";
	$sql .= "   t_lbtype.lbtype_cd,";
	$sql .= "   t_lbtype.lbtype_name,";
	$sql .= "   t_lbtype.note,";
	$sql .= "   t_sbtype.sbtype_cd,";
	$sql .= "   t_sbtype.sbtype_name,";
	$sql .= "   t_sbtype.note";
	$sql .= " FROM";
    $sql .= "   (SELECT";
    $sql .= "       lbtype_id,";
    $sql .= "       lbtype_cd,";
    $sql .= "       lbtype_name,";
    $sql .= "       note";
    $sql .= "   FROM";
    $sql .= "       t_lbtype";
    $sql .= "   WHERE";
    $sql .= "       accept_flg = '1'";
    $sql .= "   ) AS t_lbtype";
	$sql .= "       LEFT JOIN";
    $sql .= "   (SELECT";
    $sql .= "       lbtype_id,";
    $sql .= "       sbtype_id,";
    $sql .= "       sbtype_cd,";
    $sql .= "       sbtype_name,";
    $sql .= "       note";
    $sql .= "   FROM";
    $sql .= "       t_sbtype";
    $sql .= "   WHERE";
    $sql .= "       accept_flg = '1'";
    $sql .= "   ) AS t_sbtype";
	$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
	$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
	$sql .= ";";

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $page_data = Get_Data($result);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][1];
        $csv_page_data[$i][2] = $page_data[$i][2];
        $csv_page_data[$i][3] = $page_data[$i][3];
        $csv_page_data[$i][4] = $page_data[$i][4];
        $csv_page_data[$i][5] = $page_data[$i][5];
    }

    $csv_file_name = "業種マスタ".date("Ymd").".csv";
    $csv_header = array(
        "大分類業種コード",
        "大分類業種名",
        "大分類備考",
        "小分類業種コード",
        "小分類業種名",
        "小分類備考",
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
$smarty->assign("tr", $tr);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
