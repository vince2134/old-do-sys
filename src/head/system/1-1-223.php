<?php
/*************************
*変更履歴
*   （2006/05/08）検索フォーム表示ボタンを追加(watanabe-kq)
*
*
*************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-01-24      仕様変更    watanabe-k  ボタンの色を変更
 */


$page_title = "製造品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];

/* GETしたIDの正当性チェック */
$where = " make_goods_flg = 't' AND shop_id = 1 ";
//if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_goods", "num", $where) != true){
//    header("Location: ../top.php");
//}

/****************************/
//フォーム生成
/****************************/
//出力形式
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "出力形式");

//商品コード
$form->addElement(
        "text","form_make_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""
    );

//商品名
$form->addElement(
        "text","form_make_goods_name","",'size="34" 
        '." $g_form_option"
    );

//登録
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('1-1-224.php')\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
    "submit","show_button","表　示"
    );
$button[] = $form->createElement(
    "button","clear_button","クリア",
    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"
    ");
$form->addGroup($button, "form_button", "");

//検索フォーム表示ボタン
$form->addElement("submit","form_search_button","検索フォームを表示");

//hidden
$form->addElement("hidden","form_hidden_output_type");
$form->addElement("hidden","form_hidden_goods_cd");
$form->addElement("hidden","form_hidden_goods_name");


/****************************/
//デフォルト値設定
/****************************/
$def_form= array(
    "form_output_type"   => "1",
    );
$form->setDefaults($def_form);

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];                   //出力形式
    $make_goods_cd       = trim($_POST["form_make_goods_cd"]);           //商品コード
    $make_goods_name     = trim($_POST["form_make_goods_name"]);         //商品名

    $post_flg = true;                                               //POSTフラグ
}

/****************************/
//POST情報取得
/****************************/
if(count($_POST) > 0 && !isset($_POST["form_button"]["show_button"])){
    $page_count     = $_POST["f_page1"];                            //ページ数
    $output_type    = $_POST["form_hidden_output_type"];            //出力形式
    $make_goods_cd       = $_POST["form_hidden_make_goods_cd"];     //商品コード    
    $make_goods_name     = $_POST["form_hidden_make_goods_name"];   //商品名

    $post_flg = true;                                               //POSTフラグ
}

/****************************/
//検索データセット。
/****************************/
$goods_form = array(
    "form_make_goods_cd"            => stripslashes($make_goods_cd),              //商品コード
    "form_make_goods_name"          => stripslashes($make_goods_name),            //商品名
    "form_hidden_goods_cd"          => stripslashes($make_goods_cd),              //商品コード
    "form_hidden_goods_name"        => stripslashes($make_goods_name),            //商品名
);

$form->setConstants($goods_form);

/****************************/
//where_sql作成
/****************************/
if($post_flg == true){

    //商品コード
    if($make_goods_cd != null){
        $make_goods_cd_sql  = " AND t_goods.goods_cd LIKE '$make_goods_cd%'";
    }

    //商品名
    if($make_goods_name != null){
        $make_goods_name_sql .= " AND t_goods.goods_name LIKE '%$make_goods_name%'";
    }

    $where_sql = $make_goods_cd_sql.$make_goods_name_sql;
}

/****************************/
//表示データ作成
/****************************/
if($output_type == 1 || $output_type == null){    
    if(isset($_POST["f_page1"])){
        $page_count  = $_POST["f_page1"];
        $offset = $page_count * 100 - 100;
    }else{
        $offset = 0;
    }

    $make_goods_sql  = " SELECT";
    $make_goods_sql .= "    t_goods.goods_cd,";
    $make_goods_sql .= "    t_goods.goods_id,";
    $make_goods_sql .= "    t_goods.goods_name";
    $make_goods_sql .= " FROM";
    $make_goods_sql .= "    t_goods";
    $make_goods_sql .= " WHERE";
    $make_goods_sql .= "    t_goods.shop_id = $shop_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.make_goods_flg = 't'";
    $make_goods_sql .= $where_sql;
    
    $make_goods_sql .= "ORDER BY goods_id LIMIT 100 OFFSET $offset";
    $make_goods_sql .= ";";

    $make_goods_res = Db_query($conn, $make_goods_sql);
	$search_num = pg_num_rows($make_goods_res);
    $make_goods_data = Get_Data($make_goods_res, $output_type);

/******************************/
//CSV出力
/******************************/
}elseif($output_type == 2){
    $make_goods_sql  = " SELECT";
    $make_goods_sql .= "    t_goods.goods_cd,";
    $make_goods_sql .= "    t_goods.goods_name,";
    $make_goods_sql .= "    t_parts.goods_cd,";
    $make_goods_sql .= "    t_parts.goods_name,";
    $make_goods_sql .= "    t_make_goods.numerator,";
    $make_goods_sql .= "    t_make_goods.denominator";
    $make_goods_sql .= " FROM";
    $make_goods_sql .= "    t_goods,";
    $make_goods_sql .= "    t_goods AS t_parts,";
    $make_goods_sql .= "    t_make_goods";
    $make_goods_sql .= " WHERE";
    $make_goods_sql .= "    t_goods.shop_id = $shop_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.make_goods_flg = 't'";
    $make_goods_sql .= $where_sql;
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_goods.goods_id = t_make_goods.goods_id";
    $make_goods_sql .= "    AND";
    $make_goods_sql .= "    t_make_goods.parts_goods_id = t_parts.goods_id";
    $make_goods_sql .= " ORDER BY t_goods.goods_cd, t_parts.goods_cd";
    $make_goods_sql .= ";";

    $make_goods_res = Db_query($conn, $make_goods_sql);
    $make_goods_data = Get_Data($make_goods_res, $output_type);

    $csv_file_name = "製造品マスタ".date("Ymd").".csv";
    $csv_header = array(
        "製造品コード",
        "製造品名",
        "部品コード", 
        "部品名",
        "分子",
        "分母"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($make_goods_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/****************************/
//全件数取得
/****************************/
$make_goods_sql  = " SELECT";
$make_goods_sql .= "    COUNT(t_goods.goods_id)";
$make_goods_sql .= " FROM";
$make_goods_sql .= "    t_goods";
$make_goods_sql .= " WHERE";
$make_goods_sql .= "    t_goods.shop_id = $shop_id";
$make_goods_sql .= "    AND";
$make_goods_sql .= "    t_goods.make_goods_flg = 't'";

//ヘッダーに表示させる全件数
$total_count_sql = $make_goods_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

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
$page_menu = Create_Menu_h('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
	"total_count"   => "$total_count",
    "search_num"    => "$search_num",
));
$smarty->assign('make_goods_data', $make_goods_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
