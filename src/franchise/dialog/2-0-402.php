<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/10      05-010      ふ          サニタイズ処理を追加
 *  2007/05/16                              状態を追加   
 *
 *
 */

$page_title = "得意先一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DBに接続
$conn = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$shop_id  = $_SESSION["client_id"];
$display  = $_GET["display"];
$group_kind = $_SESSION["group_kind"];

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

$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1",
    "form_state"    => "1"

);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品
/****************************/
//得意先コード
$text[] =& $form->createElement("text","cd1","",
    "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_client[cd1]', 'form_client[cd2]', 6)\"
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\"
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $text, "form_client", "form_client");

//得意先名
$form->addElement(
    "text","form_client_name","",
    'size="65" maxLength="50" 
    onFocus="onForm(this)" 
    onBlur="blurForm(this)"'
);


//振り込名義
$form->addElement(
    "text","form_account_name","",
    'size="34" maxLength="25" 
    onFocus="onForm(this)" 
    onBlur="blurForm(this)"'
);

//請求先名
$form->addElement(
    "text","form_claim_name","",
    'size="34" maxLength="25" 
    onFocus="onForm(this)" 
    onBlur="blurForm(this)"'
);

// 銀行カナ
$form->addElement("text", "form_bank_kana", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//地区
$select_value = Select_Get($conn, 'area');
$form->addElement('select', 'form_area_id',"", $select_value);

//状態
$radio[] =& $form->createElement( "radio",NULL,NULL, "取引中","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "解約・休止中","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","3");
$form->addGroup($radio, "form_state", "表示順");

//表示順
$radio3[] =& $form->createElement( "radio",NULL,NULL, "コード順","1");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "アイウエオ順","2");
$form->addGroup($radio3, "form_turn", "表示順");

//ボタン
$button[] = $form->createElement("submit","show_button","表　示");
$button[] = $form->createElement("button","close_button","閉じる","onClick=\"window.close()\"");
$form->addGroup($button, "form_button", "ボタン");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");

$form->addElement("hidden","hdn_client_cd1");
$form->addElement("hidden","hdn_client_cd2");
$form->addElement("hidden","hdn_client_name");
$form->addElement("hidden","hdn_area_id");
$form->addElement("hidden","hdn_turn");
$form->addElement("hidden","hdn_state");
$form->addElement("hidden","hdn_bank_kana");
$form->addElement("hidden","hdn_account_name");
$form->addElement("hidden","hdn_claim_name");

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){

    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //得意先コード1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //得意先コード2
    $client_name    = trim($_POST["form_client_name"]);     //得意先名
    $area_id        = $_POST["form_area_id"];               //地区ID
    $turn           = $_POST["form_turn"];                  //表示順
    $account_name   = trim($_POST["form_account_name"]);    //振込名義
    $bank_kana      = trim($_POST["form_bank_kana"]);       //銀行カナ
    $claim_name     = trim($_POST["form_claim_name"]);      //請求先名

    $state          = $_POST["form_state"];                 //状態


    $post_flg       = true;
    $offset         = 0;

}elseif(count($_POST) > 0 && $_POST["form_button"]["show_button"] != "表　示"){
    $page_count     = $_POST["f_page1"];
    $offset         = $page_count * 100 - 100;

    $client_cd1     = $_POST["hdn_client_cd1"];             //得意先コード1
    $client_cd2     = $_POST["hdn_client_cd2"];             //得意先コード2
    $client_name    = $_POST["hdn_client_name"];            //得意先名
    $bank_kana      = $_POST["hdn_bank_kana"];              //銀行カナ
    $account_name   = $_POST["hdn_account_name"];           //振込名義
    $area_id        = $_POST["hdn_area_id"];                //地区ID
    $turn           = $_POST["hdn_turn"];                   //表示順
    $claim_name     = $_POST["hdn_claim_name"];             //請求先名

    $state          = $_POST["hdn_state"];                 //状態

    $post_flg       = true;
}else{
    $offset         = 0;
    $turn           = 1;
    $state          = '1';

}

/****************************/
//データセット
/***************************/
$set_data["form_client"]["cd1"] = stripslashes($client_cd1);
$set_data["form_client"]["cd2"] = stripslashes($client_cd2);
$set_data["form_client_name"]   = stripslashes($client_name);
$set_data["form_area_id"]       = stripslashes($area_id);
$set_data["form_turn"]          = stripslashes($turn);
$set_data["form_bank_kana"]     = stripslashes($bank_kana);
$set_data["form_account_name"]  = stripslashes($account_name);
$set_data["form_claim_name"]    = stripslashes($claim_name);
$set_data["form_state"]         = $state;


$set_data["hdn_client_cd1"]     = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]     = stripslashes($client_cd2);
$set_data["hdn_client_name"]    = stripslashes($client_name);
$set_data["hdn_area_id"]        = stripslashes($area_id);
$set_data["hdn_turn"]           = stripslashes($turn);
$set_data["hdn_bank_kana"]      = stripslashes($bank_kana);
$set_data["hdn_claim_name"]     = stripslashes($claim_name);
$set_data["hdn_state"]          = $state;


$form->setConstants($set_data);

/****************************/
//WHERE_SQL作成
/****************************/
if($post_flg == true){

	//得意先コード1
	if($client_cd1 != null){
	    $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'";
	}

	//得意先コード2
	if($client_cd2 != null){
	    $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'";
	}

	//略称
	if($client_name != null){
            $client_name_sql   = " AND\n";
	        $client_name_sql  .= "( t_client.client_name LIKE '%$client_name%'";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_name2 LIKE '%$client_name%'";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_read LIKE '%$client_name%'";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_read2 LIKE '%$client_name%')";
    }

    //請求先名
    if($claim_name != null){
        $claim_name_sql  = " AND";
        $claim_name_sql .= " t_client.client_name LIKE '%$cliam_name%'";
    }

	//地区
	if($area_id != 0){
	    $area_id_sql = " AND t_area.area_id = $area_id";
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

    //振込名義
    if($account_name != null){
        $account_name_sql  = "AND\n";
        $account_name_sql .= "  (t_client.pay_name LIKE '%$account_name%'";
        $account_name_sql .= "  OR";
        $account_name_sql .= "  t_client.account_name LIKE '%$account_name%'";
        $account_name_sql .= "  )";
    }

    $where_sql  = $client_cd1_sql;
    $where_sql .= $client_cd2_sql;
    $where_sql .= $client_name_sql;
    $where_sql .= $account_name_sql;
    $where_sql .= $bank_kana_sql;
    $where_sql .= $area_id_sql;
}

if($state != '3'){
    $where_sql .= " AND t_client.state = '$state' ";
}



/****************************/
//SQL作成
/****************************/
//表示順
if($turn == 1){
	$turn_sql = " ORDER BY client_cd1,client_cd2 ASC";
}else{
	$turn_sql = " ORDER BY client_cname ASC";
}

//SQL判定
//請求先がしていされていない場合
if($claim_name == Null){
    $sql  = " SELECT";
    $sql .= "     t_client.client_cd1,";
    $sql .= "     t_client.client_cd2,";
    $sql .= "     t_client.client_name,";
    $sql .= "     t_client.client_cname,";
    $sql .= "     t_area.area_name,";
    $sql .= "     'true',";
	$sql .= "     t_client.client_id, ";
    $sql .= "     CASE t_client.state ";
    $sql .= "           WHEN '1' THEN '取引中'";
    $sql .= "           WHEN '2' THEN '解約・休止中'";
    $sql .= "     END AS state ";
    $sql .= " FROM";
    $sql .= "     t_client,";
    $sql .= "     t_area";
    $sql .= " WHERE";
    $sql .= "     t_client.area_id = t_area.area_id";
    $sql .= "     AND";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    //$sql .= "     AND";
    //$sql .= "     t_client.state = '1'";
    $sql .= "     AND";
    $sql .= "     t_client.client_div = '1'";
//請求先が指定された場合
}else{

    $sql  = "SELECT";
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_name,";
    $sql .= "    t_client.client_cname,";
    $sql .= "    t_area.area_name,";
    $sql .= "    'true', ";
	$sql .= "     t_client.client_id ";
    $sql .= "FROM";
    $sql .= "    (SELECT";
    $sql .= "        client_id";
    $sql .= "    FROM";
    $sql .= "        t_claim";
    $sql .= "    WHERE";
    $sql .= "        client_id = claim_id";
    $sql .= "    GROUP BY client_id, claim_id";
    $sql .= "    HAVING COUNT(client_id) = 1";
    $sql .= "    ) as t_claim";
    $sql .= "        INNER JOIN";
    $sql .= "    t_client ";
    $sql .= "    on t_claim.client_id = t_client.client_id";
    if($group_kind == 2){
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_client_info\n";
        $sql .= "   ON t_client.client_id = t_client_info.client_id";
        $sql .= "   AND t_client_info.cclient_shop = $shop_id\n";
    }else{
        $sql .= "   t_client.shop_id = $shop_id\n";
    }
    $sql .= "        INNER JOIN";
    $sql .= "    t_area";
    $sql .= "    ON t_client.area_id = t_area.area_id ";
    $sql .= "WHERE";
    $sql .= "     t_client.area_id = t_area.area_id";
    //$sql .= "     AND";
    //$sql .= "     t_client.state = '1'";
    $sql .= "     AND";
    $sql .= "     t_client.client_div = '1'";
    $sql .= "     AND\n";
    $sql .= "   (t_client.client_name LIKE '%$claim_name%'";
    $sql .= "       OR";
    $sql .= "   t_client.client_name2 LIKE '%$claim_name%'";
    $sql .= "       OR";
    $sql .= "   t_client.client_read LIKE '%$claim_name%'";
    $sql .= "       OR";
    $sql .= "   t_client.client_read2 LIKE '%$claim_name%'";
    $sql .= "   )";   
}

$sql .=       $where_sql;
$sql .=       $turn_sql;


/******************************/
//表示データ作成
/******************************/
//該当件数
$total_count_sql = $sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_num_rows($count_res);

//表示データ
$limit_sql = " LIMIT 100 OFFSET $offset";
$sql       = $sql.$limit_sql.";";
$result    = Db_Query($conn, $sql);
$page_data_html = Get_Data($result);    // htmlspecialchars
$page_data_js   = Get_Data($result, 4); // addslashes


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
$page_title .= "　（全".$t_count."件）";
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
//表示範囲指定
$range = "100";

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
	'display'       => "$display",
));
$smarty->assign('row_html',$page_data_html);
$smarty->assign('row_js',$page_data_js);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
