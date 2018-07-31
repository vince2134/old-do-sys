<?php
/***********************************/
//変更履歴
//  （2006/03/15）
//  ・一覧SQL変更
//　・shop_idをclient_idに変更
/***********************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0006     suzuki     CSV出力時にサニタイジングを行わないように修正
 *  2007-01-24      仕様変更     watanabe-k ボタンの色変更
 *
 *
*/

$page_title = "仕入先マスタ";

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
$shop_id  = $_SESSION[client_id];

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_state_type"     => "1",
    "form_turn"     => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品
/****************************/
//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio1, "form_output_type", "出力形式");

//仕入先コード
$form->addElement("text","form_client_cd","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\""." $g_form_option");

//仕入先名
$form->addElement("text","form_client_name","テキストフォーム",'size="34" maxLength="15"'." $g_form_option");

//略称
$form->addElement("text","form_client_cname","テキストフォーム",'size="21" maxLength="10"'." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//状態
$radio2[] =& $form->createElement( "radio",NULL,NULL, "取引中","1");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "休止中","2");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "解約","3");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "全て","4");
$form->addGroup($radio2, "form_state_type", "状態");

//地区
$select_value = Select_Get($conn, "area");
$form->addElement('select', 'form_area_id',"", $select_value);

//ボタン
$form->addElement("submit","form_search_button","検索フォームを表示","onClick=\"javascript:Button_Submit_1('search_button_flg', '#', 'true')\"");

$button[] = $form->createElement("submit","show_button","表　示");
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "ボタン");
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","登録画面","onClick=\"location.href='1-1-216.php'\"");

//hidden
$form->addElement("hidden", "search_button_flg");

/****************************/
//データ件数取得
/****************************/
$client_sql  = "SELECT";
$client_sql .= " t_client.client_id,";
$client_sql .= " t_client.client_cd1,";
$client_sql .= " t_client.client_name,";
$client_sql .= " t_area.area_name,";
$client_sql .= " t_client.tel,";
$client_sql .= " t_client.state";
$client_sql .= " FROM";
$client_sql .= " t_client";
$client_sql .= "  LEFT JOIN";
$client_sql .= " t_area ";
$client_sql .= " ON t_client.area_id = t_area.area_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_client.shop_id = $shop_id";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = 2";

//初期表示時・検索フォームを表示ボタンを押下時は取引中のデータのみ表示
if(($_POST["search_button_flg"]!=true && $_POST["show_button"]!="表　示") || $_POST["search_button_flg"]==true){
    $state_first_sql .= " AND t_client.state = '1'";
    $cons_data["search_button_flg"] = false;
    $form->setConstants($cons_data);
}

//データに表示させる全件数
$total_count_sql = $client_sql;
$count_res = Db_Query($conn, $total_count_sql.$state_first_sql." ORDER BY t_client.client_cd1;");
$page_data = Get_Data($count_res);
$match_count = pg_num_rows($count_res);

/****************************/
//全件数取得
/****************************/
$count_sql  = " SELECT";
$count_sql .= "     COUNT(client_id)";
$count_sql .= " FROM";
$count_sql .= "     t_client";
$count_sql .= " WHERE";
$count_sql .= "     t_client.shop_id = $shop_id";
$count_sql .= "     AND";
$count_sql .= "     t_client.client_div = 2";

//ヘッダーに表示させる全件数
$total_count_sql = $count_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);


/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];           //出力形式
    $client_cd      = trim($_POST["form_client_cd"]);       //仕入先コード1
    $client_name    = trim($_POST["form_client_name"]);     //仕入先名
    $area_id       = $_POST["form_area_id"];               //地区
	$tel            = $_POST["form_tel"];                   //TEL
    $state          = $_POST["form_state_type"];            //状態
    $post_flg       = true;                                 //POSTフラグ

/****************************/
//where_sql作成
/****************************/
	if($post_flg == true){
	    //仕入先コード1
	    if($client_cd != null){
	        $client_cd_sql  = " AND t_client.client_cd1 LIKE '$client_cd%'";
	    }
	   
	    //仕入先名
	    if($client_name != null){
	        $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
	    }
	    
	    //略称
	    if($client_cname != null){
	        $client_cname_sql  = " AND t_client.client_cname LIKE '%$client_cname%'";
	    }
	    
		//地区
	    if($area_id != 0){
	        $area_id_sql = " AND t_area.area_id = $area_id";
	    }

		//TEL
	    if($tel != null){
	        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
	    }

	    //状態
	    if($state != 4){
	        $state_sql = " AND t_client.state = $state";
	    }

	    $where_sql  = $client_cd_sql;
	    $where_sql .= $client_name_sql;
	    $where_sql .= $client_cname_sql;
	    $where_sql .= $area_id_sql;
		$where_sql .= $tel_sql;
	    $where_sql .= $state_sql;
	}
/****************************/
//表示データ作成
/****************************/
	//画面選択時
	if($output_type == 1){
		//該当件数
	    $client_sql .= $where_sql;
		$total_count_sql = $client_sql;
	    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
	    $match_count = pg_num_rows($count_res);
	    
	    $page_data = Get_Data($count_res, $output_type);
	}else if($output_type == 2){
		//該当件数
	    $client_sql .= $where_sql;
		$total_count_sql = $client_sql;
	    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
	    $match_count = pg_num_rows($count_res);
	    $page_data = Get_Data($count_res,$output_type);

	    //CSV作成
	    for($i = 0; $i < $match_count; $i++){
	        $csv_page_data[$i][0] = $page_data[$i][1];
	        $csv_page_data[$i][1] = $page_data[$i][2];
	        $csv_page_data[$i][2] = $page_data[$i][3];
	        $csv_page_data[$i][3] = $page_data[$i][4];
	        if($page_data[$i][5] == 1){
				$page_data[$i][5] = "取引中";
			}else{
				$page_data[$i][5] = "取引休止中";
			}
	        $csv_page_data[$i][5] = $page_data[$i][5];
	    }

	    $csv_file_name = "仕入先マスタ".date("Ymd").".csv";
	    $csv_header = array(
	        "仕入先コード",
	        "仕入先名",
	        "地区",
			"TEL",
	        "状態"
	      );

	    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	    $csv_data = Make_Csv($csv_page_data, $csv_header);
	    Header("Content-disposition: attachment; filename=$csv_file_name");
	    Header("Content-type: application/octet-stream; name=$csv_file_name");
	    print $csv_data;
	    exit;
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
	'match_count'   => "$match_count",
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
