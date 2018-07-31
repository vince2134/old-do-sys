<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/10      05-010      ふ          サニタイズ処理を追加
 *  2007/05/17                  watanabe-k  状態の検索を追加
 *
 */

$page_title = "FC一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DBに接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$shop_id   = $_SESSION["client_id"];
$display   = $_GET["display"];
$select_id = $_GET['select_id'];

/****************************/
//デフォルト値設定
/****************************/

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

$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品
/****************************/
// ショップコード
$text[] =& $form->createElement("text", "cd1", "ショップコード", "size=\"7\" maxLength=\"6\" value=\"\" 
    onkeyup=\"changeText(this.form,'form_client[cd1]', 'form_client[cd2]', 6)\"
    style=\"$g_form_style\"
    $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_from_option");
$form->addGroup( $text, "form_client", "form_client");

// ショップ名
$form->addElement("text", "form_client_name", "", "size=\"50\" maxLength=\"50\" $g_form_option");

//振込名義
$form->addElement("text", "form_account_name", "","size=\"50\" maxLength=\"50\" $g_form_option");

// 銀行カナ
$form->addElement("text", "form_bank_kana", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//請求先名
$form->addElement("text", "form_claim_name", "","size=\"50\" maxLength=\"50\" $g_form_option");


// 地区
$select_value = Select_Get($conn, "area");
$form->addElement("select", "form_area_id", "",$select_value);

// 表示順
$radio3[] =& $form->createElement("radio", null, null, "コード順", "1");
$radio3[] =& $form->createElement("radio", null, null, "アイウエオ順", "2");
$form->addGroup($radio3, "form_turn", "表示順");

// 状態
$radio[] =& $form->createElement("radio", null, null, "取引中", "1");
$radio[] =& $form->createElement("radio", null, null, "休止・解約中", "2");
$radio[] =& $form->createElement("radio", null, null, "全て", "3");
$form->addGroup($radio, "form_state", "状態");

// ボタン
$button[] = $form->createElement("submit", "show_button", "表　示");
$button[] = $form->createElement("button", "close_button", "閉じる", "onClick=\"window.close()\"");
$form->addGroup($button, "form_button", "ボタン");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");

/****************************/
//表示ボタン押下処理
/****************************/
$client_cd1     = trim($_POST["form_client"]["cd1"]);   //ショップコード1
$client_cd2     = trim($_POST["form_client"]["cd2"]);   //ショップコード2
$client_name    = trim($_POST["form_client_name"]);     //ショップ名
$area_id        = $_POST["form_area_id"];               //地区ID
$turn           = $_POST["form_turn"];                  //表示順
$account_name   = $_POST["form_account_name"];          //口座名義
$bank_kana      = $_POST["form_bank_kana"];             //銀行カナ
$claim_name     = $_POST["form_claim_name"];            //請求先名
$state          = ($_POST["form_state"] != NULL)? $_POST["form_state"] : '1' ;

$client_cd1     = stripslashes($client_cd1);
$client_cd2     = stripslashes($client_cd2);
$client_name    = stripslashes($client_name);
$account_name   = stripslashes($account_name);
$bank_kana      = stripslashes($bank_kana);
$claim_name     = stripslashes($claim_name);

    //ショップコード1
    if($client_cd1 != null){
        $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'";
    }
   
    //ショップコード2
    if($client_cd2 != null){
        $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'";
    }
   
    //ショップ名
    if($client_name != null){
        $client_name_sql  = " AND\n";
        $client_name_sql .= "(\n";
        $client_name_sql .= "   t_client.client_name LIKE '%$client_name%'";
        $client_name_sql .= "   OR\n";
        $client_name_sql .= "   t_client.client_name2 LIKE '%$client_name%'";
        $client_name_sql .= "   OR\n";
        $client_name_sql .= "   t_client.client_read LIKE '%$client_name%'";
        $client_name_sql .= "   OR\n";
        $client_name_sql .= "   t_client.client_read2 LIKE '%$client_name%'";
        $client_name_sql .= ")\n";
    
//        $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
    }

    //口座名義
    if($account_name != null){
        $account_name_sql  = "AND";
        $account_name_sql .= "  (t_client.account_name LIKE '%$account_name%'";
        $account_name_sql .= "      OR\n";
        $account_name_sql .= "  t_client.pay_name LIKE '%$account_name%'";
        $account_name_sql .= ")";
    }

    // 銀行カナ
    if ($bank_kana != null){
        $sql  = "AND t_client.client_id IN \n";
        $sql .= "( \n"; 
        $sql .= "   SELECT \n";
        $sql .= "       t_claim.client_id \n";
        $sql .= "   FROM \n";
        $sql .= "       t_claim \n";
        $sql .= "       INNER JOIN t_client AS t_client_claim \n";
        $sql .= "           ON  t_claim.claim_id = t_client_claim.client_id \n";
        $sql .= "           AND t_client_claim.shop_id = ".$_SESSION["client_id"]." \n";
        $sql .= "       INNER JOIN t_account \n";
        $sql .= "           ON  t_client_claim.account_id = t_account.account_id \n";
        $sql .= "       INNER JOIN t_b_bank \n";
        $sql .= "           ON  t_account.b_bank_id = t_b_bank.b_bank_id \n";
        $sql .= "       INNER JOIN t_bank \n";
        $sql .= "           ON  t_b_bank.bank_id = t_bank.bank_id \n";
        $sql .= "           AND t_bank.bank_kana LIKE '%$bank_kana%' \n";
        $sql .= ") \n"; 

        $bank_kana_sql = $sql; 
    }

    //地区
    if($area_id != 0){
        $area_id_sql = " AND t_area.area_id = $area_id";
    }

    // 状態
    if($state != '3'){
        $state_sql = " AND t_client.state = '$state'";
    }

    //表示順
    if($turn != '2'){
        $turn_sql = " ORDER BY client_cd1,client_cd2 ASC";
    }else{
        $turn_sql = " ORDER BY shop_name ASC";
    }

$where_sql  = $client_cd1_sql;
$where_sql .= $client_cd2_sql;
$where_sql .= $client_name_sql;
$where_sql .= $area_id_sql;
$where_sql .= $account_name_sql;
$where_sql .= $bank_kana_sql;
$where_sql .= $state_sql;

/****************************/
//全件数取得
/****************************/
if($claim_name != null){
    $client_sql  = " SELECT";
    $client_sql .= "     t_client.client_cd1,";
    $client_sql .= "     t_client.client_cd2,";
    $client_sql .= "     t_client.client_name,";
    $client_sql .= "     t_client.client_cname,";
    $client_sql .= "     t_area.area_name,";
    $client_sql .= "     'true',";
    $client_sql .= "     CASE t_client.state ";
    $client_sql .= "        WHEN '1' THEN '取引中' ";
    $client_sql .= "        WHEN '2' THEN '解約・休止中'";
    $client_sql .= "     END AS state ";
    $client_sql .= " FROM";
    $client_sql .= "    (SELECT";
    $client_sql .= "        client_id";
    $client_sql .= "    FROM";
    $client_sql .= "        t_claim";
    $client_sql .= "    WHERE";
    $client_sql .= "        client_id = claim_id";
    $client_sql .= "    GROUP BY client_id, claim_id";
    $client_sql .= "    HAVING COUNT(client_id) = 1";
    $client_sql .= "    ) as t_claim";
    $client_sql .= "        INNER JOIN";
    $client_sql .= "    t_client ";
    $client_sql .= "    on t_claim.client_id = t_client.client_id";
    $client_sql .= "    AND\n";
    $client_sql .= "    t_client.shop_id = $shop_id";
    $client_sql .= "        INNER JOIN\n";
    $client_sql .= "    t_area";
    $client_sql .= "    ON t_client.area_id = t_area.area_id\n";
    $client_sql .= " WHERE";
    $client_sql .= "     t_client.area_id = t_area.area_id";
    $client_sql .= "     AND";
    $client_sql .= "     t_client.client_div = '3' ";
    //$client_sql .= "     AND";
    //$client_sql .= "     t_client.state = 1";
    $client_sql .= "     AND";
    $client_sql .= "     (t_client.client_name LIKE '%$claim_name%'";
    $client_sql .= "        OR";
    $client_sql .= "     t_client.client_name2 LIKE '%$claim_name%'";
    $client_sql .= "        OR";
    $client_sql .= "     t_client.client_read LIKE  '%$claim_name%'";
    $client_sql .= "        OR";
    $client_sql .= "     t_client.client_read2 LIKE '%$claim_name%'";
    $client_sql .= "    )";
}else{
    $client_sql  = " SELECT";
    $client_sql .= "     t_client.client_cd1,";
    $client_sql .= "     t_client.client_cd2,";
    $client_sql .= "     t_client.client_name,";
    $client_sql .= "     t_client.client_cname,";
    $client_sql .= "     t_area.area_name,";
    $client_sql .= "     'true',";
    $client_sql .= "     CASE t_client.state ";
    $client_sql .= "        WHEN '1' THEN '取引中' ";
    $client_sql .= "        WHEN '2' THEN '解約・休止中'";
    $client_sql .= "     END AS state ";
    $client_sql .= " FROM";
    $client_sql .= "     t_client,";
    $client_sql .= "     t_area";
    $client_sql .= " WHERE";
    $client_sql .= "     t_client.area_id = t_area.area_id";
    $client_sql .= "     AND";
    $client_sql .= "     t_client.client_div = '3' ";
    //$client_sql .= "     AND";
    //$client_sql .= "     t_client.state = 1";
}

$client_sql .=       $where_sql;
$client_sql .=       $turn_sql;

//該当件数
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$match_count = pg_num_rows($count_res);

$page_data_html = Get_Data($count_res);    // htmlspecialchars
$page_data_js   = Get_Data($count_res, 4); // addslashes
/*
//戻り値作成
for($i = 0; $i < $match_count; $i++){
    $page_data[] = @pg_fetch_array ($count_res, $i, PGSQL_NUM);
}
for($i = 0; $i < $match_count; $i++){
    for($j = 0; $j < count($page_data[$i]); $j++){
		//ショップコード1
		if($j==0){
			$return = "'".$page_data[$i][$j]."'";
		//ショップコード2
		}else if($j==1){
			$return = $return.",'".$page_data[$i][$j]."'";
		//ショップ名は'が入力される可能性がある為
		}else if($j==3){
			$single = addslashes($page_data[$i][$j]);
			$return = $return.",'".$single."'";
		}
        $page_data[$i][$j] = htmlspecialchars($page_data[$i][$j],ENT_QUOTES);
    }
	//戻り値にコード・名前・trueを返す
	$return_data[] = $return.",true";
}
*/


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
$page_title .= "　（全".$total_count."件）";
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
	'match_count'   => "$match_count",
	
));
//テンプレートへ値を渡す
$smarty->assign("row_html",$page_data_html);
$smarty->assign('row_js', $page_data_js);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
