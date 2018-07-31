<?php
$page_title = "構成品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
//フォーム生成
/****************************/
//出力形式
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "出力形式");

//商品コード
$form->addElement(
        "text","form_compose_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" 
        ".$g_form_option."\"" 
    );

//商品名
$form->addElement(
        "text","form_compose_goods_name","",'size="34" 
        '." $g_form_option"
    );

//ボタン
//登録
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('2-1-230.php')\"");
//変更・一覧
$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
    "submit","show_button","表　示"
    );
$button[] = $form->createElement(
    "button","clear_button","クリア",
    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"
    ");
$form->addGroup($button, "form_button", "");

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
    $output_type    = $_POST["form_output_type"];                           //出力形式
    $compose_goods_cd       = trim($_POST["form_compose_goods_cd"]);        //商品コード
    $compose_goods_name     = trim($_POST["form_compose_goods_name"]);      //商品名

    $post_flg = true;                                                       //POSTフラグ
}

/****************************/
//POST情報取得
/****************************/
if(count($_POST) > 0 && !isset($_POST["form_button"]["show_button"])){
    $page_count             = $_POST["f_page1"];                            //ページ数
    $output_type            = $_POST["form_hidden_output_type"];            //出力形式
    $compose_goods_cd       = $_POST["form_hidden_compose_goods_cd"];       //商品コード    
    $compose_goods_name     = $_POST["form_hidden_compose_goods_name"];     //商品名

    $post_flg = true;                                                       //POSTフラグ
}

/****************************/
//検索データセット。
/****************************/
$goods_form = array(
    "form_compose_goods_cd"         => stripslashes($compose_goods_cd),                   //商品コード
    "form_compose_goods_name"       => stripslashes($compose_goods_name),                 //商品名
    "form_hidden_goods_cd"          => stripslashes($compose_goods_cd),                   //商品コード
    "form_hidden_goods_name"        => stripslashes($compose_goods_name),                 //商品名
);

$form->setConstants($goods_form);

/****************************/
//where_sql作成
/****************************/
if($post_flg == true){

    //商品コード
    if($compose_goods_cd != null){
        $compose_goods_cd_sql  = " AND t_goods.goods_cd LIKE '$compose_goods_cd%'";
    }

    //商品名
    if($compose_goods_name != null){
        $compose_goods_name_sql .= " AND t_goods.goods_name LIKE '%$compose_goods_name%'";
    }

    $where_sql = $compose_goods_cd_sql.$compose_goods_name_sql;
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

    $compose_goods_sql  = " SELECT";
    $compose_goods_sql .= " DISTINCT";
    $compose_goods_sql .= "    t_goods.goods_cd,";
    $compose_goods_sql .= "    t_goods.goods_id,";
    $compose_goods_sql .= "    t_goods.goods_name";
    $compose_goods_sql .= " FROM";
    $compose_goods_sql .= "    t_goods,";
    $compose_goods_sql .= "    t_compose";
    $compose_goods_sql .= " WHERE";
    $compose_goods_sql .= "    t_compose.goods_id = t_goods.goods_id ";
    $compose_goods_sql .= $where_sql;

    $compose_count_sql = $compose_goods_sql.";";
    $count_res = Db_query($conn, $compose_count_sql);
    $total_count = pg_num_rows($count_res);
	
    $compose_goods_sql .= "ORDER BY goods_cd LIMIT 100 OFFSET $offset";
    $compose_goods_sql .= ";";

    $compose_goods_res = Db_query($conn, $compose_goods_sql);
    $compose_goods_data = Get_Data($compose_goods_res, $output_type);

/******************************/
//CSV出力
/******************************/
}elseif($output_type == 2){
    $compose_goods_sql  = " SELECT";
    $compose_goods_sql .= "    t_goods.goods_cd,";
    $compose_goods_sql .= "    t_goods.goods_name,";
    $compose_goods_sql .= "    t_parts.goods_cd,";
    $compose_goods_sql .= "    t_parts.goods_name,";
    $compose_goods_sql .= "    t_compose.count";
    $compose_goods_sql .= " FROM";
    $compose_goods_sql .= "    t_goods,";
    $compose_goods_sql .= "    t_goods AS t_parts,";
    $compose_goods_sql .= "    t_compose,";
    $compose_goods_sql .= "    t_goods_info";
    $compose_goods_sql .= " WHERE";
    $compose_goods_sql .= ($group_kind == "2") ? " t_goods.shop_id IN (".Rank_Sql().") " : " t_goods.shop_id = $shop_id ";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods.goods_id = t_goods_info.goods_id";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods_info.compose_flg = 't'";
    $compose_goods_sql .= $where_sql;
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_goods.goods_id = t_compose.goods_id";
    $compose_goods_sql .= "    AND";
    $compose_goods_sql .= "    t_compose.parts_goods_id = t_parts.goods_id";
    $compose_goods_sql .= " ORDER BY t_goods.goods_cd, t_parts.goods_cd";
    $compose_goods_sql .= ";";

    $compose_goods_res = Db_query($conn, $compose_goods_sql);
    $compose_goods_data = Get_Data($compose_goods_res, $output_type);
    $csv_file_name = "製造品マスタ".date("Ymd").".csv";
    $csv_header = array(
        "親商品コード",
        "親商品名",
        "構成品コード",
        "構成品名",
        "数量"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($compose_goods_data, $csv_header);
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
	"total_count" => "$total_count",
));

$smarty->assign('compose_goods_data', $compose_goods_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
