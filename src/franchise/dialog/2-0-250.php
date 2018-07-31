<?php

/*************************
 * 変更履歴
 *  ・（2006-11-28）サニタイジング処理追加<suzuki>
 *  2007-05-16  状態を追加<watanabe-k>
 *
**************************/

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

//得意先マスタで使用
$select_id = $_GET["select_id"];

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
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\"
    onkeyup=\"changeText(this.form,'form_client[cd1]', 'form_client[cd2]', 6)\""
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

// 銀行カナ
$form->addElement("text", "form_bank_kana", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//振込名義
$form->addElement(
    "text","form_account_name","",
    'size="34" maxLength="25" 
    onFocus="onForm(this)" 
    onBlur="blurForm(this)"'
);

//地区
$select_value = Select_Get($conn, 'area');
$form->addElement('select', 'form_area_id',"", $select_value);

//表示順
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
    $claim_name     = trim($_POST["form_claim_name"]);      //請求先名
    $bank_kana      = trim($_POST["form_bank_kana"]);       //銀行カナ
    $account_name   = trim($_POST["form_account_name"]);    //振込口座

    $state          = $_POST["form_state"];                 //状態

    $post_flg       = true;
    $offset         = 0;

}elseif(count($_POST) > 0 && $_POST["form_button"]["show_button"] != "表　示"){
    $page_count     = $_POST["f_page1"];
    $offset         = $page_count * 100 - 100;

    $client_cd1     = $_POST["hdn_client_cd1"];             //得意先コード1
    $client_cd2     = $_POST["hdn_client_cd2"];             //得意先コード2
    $client_name    = $_POST["hdn_client_name"];            //得意先名
    $claim_name     = $_POST["hdn_claim_name"];             //請求先名
    $bank_kana      = $_POST["form_bank_kana"];             //銀行カナ
    $account_name   = $_POST["form_account_name"];          //振込口座
    $area_id        = $_POST["hdn_area_id"];                //地区ID
    $turn           = $_POST["hdn_turn"];                   //表示順

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
$set_data["form_claim_name"]    = stripslashes($claim_name);
$set_data["form_bank_kana"]     = stripslashes($bank_kana);
$set_data["form_account_name"]  = stripslashes($account_name);
$set_data["form_state"]         = $state;

$set_data["hdn_client_cd1"]     = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]     = stripslashes($client_cd2);
$set_data["hdn_client_name"]    = stripslashes($client_name);
$set_data["hdn_area_id"]        = stripslashes($area_id);
$set_data["hdn_turn"]           = stripslashes($turn);
$set_data["hdn_claim_name"]     = stripslashes($claim_name);
$set_data["hdn_bank_kana"]      = stripslashes($bank_kana);
$set_data["hdn_account_name"]   = stripslashes($account_name);
$set_data["hdn_state"]          = $state;

$form->setConstants($set_data);

/****************************/
//WHERE_SQL作成
/****************************/
if($post_flg == true){

	//得意先コード1
	if($client_cd1 != null){
	    $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'\n";
	}

	//得意先コード2
	if($client_cd2 != null){
	    $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'\n";
	}

	//略称
	if($client_name != null){
            $client_name_sql   = " AND\n";
	        $client_name_sql  .= "( t_client.client_name LIKE '%$client_name%'\n";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_name2 LIKE '%$client_name%'\n";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_cname LIKE '%$client_name%'\n";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_read LIKE '%$client_name%'\n";
            $client_name_sql  .= "  OR\n";
            $client_name_sql  .= " t_client.client_read2 LIKE '%$client_name%')\n";
    }

    //請求先名
    if($claim_name != null){
        $claim_name_sql  = " AND";
        $claim_name_sql .= " t_client.client_name LIKE '%$cliam_name%'";
    }

    // 銀行カナ
    if ($bank_kana != null){
        $sql  = "AND t_client.account_id IN \n";
        $sql .= "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_account.account_id \n";
        $sql .= "   FROM \n";
        $sql .= "       t_account \n";
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

	//地区
	if($area_id != 0){
	    $area_id_sql = " AND t_area.area_id = $area_id\n";
	}

    $where_sql  = $client_cd1_sql;
    $where_sql .= $client_cd2_sql;
    $where_sql .= $client_name_sql;
    $where_sql .= $claim_name_sql;
    $where_sql .= $bank_kana_sql;
    $where_sql .= $account_name_sql;
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
	$turn_sql = " ORDER BY client_cd1,client_cd2 ASC\n";
}else{
	$turn_sql = " ORDER BY client_cname ASC\n";
}

//SQL判定
if($display == null || $display == 5){

	//指定なしor契約一覧
    $sql  = " SELECT";
    $sql .= "     t_client.client_cd1,";
    $sql .= "     t_client.client_cd2,";
    $sql .= "     t_client.client_name,";
    $sql .= "     t_client.client_cname,";
    $sql .= "     t_area.area_name,";
    $sql .= "     'true',";
    $sql .= "     '', ";
    $sql .= "     '', ";
    $sql .= "   CASE t_client.state ";
    $sql .= "       WHEN '1' THEN '取引中' ";
    $sql .= "       WHEN '2' THEN '解約・休止中' ";
    $sql .="    END AS state ";
    $sql .= " FROM";
    $sql .= "     t_client,";
    $sql .= "     t_area";
    $sql .= " WHERE";
    $sql .= "     t_client.area_id = t_area.area_id";
    $sql .= "     AND";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
//    $sql .= "     AND";
//    $sql .= "     t_client.state = '1'";
    $sql .= "     AND";
    $sql .= "     t_client.client_div = '1'";
    $sql .=       $where_sql;
    $sql .=       $turn_sql;

}elseif ($display == "2-503"){

	//指定なしor契約一覧
    $sql  = " SELECT";
    $sql .= "     t_client.client_cd1,";
    $sql .= "     t_client.client_cd2,";
    $sql .= "     t_client.client_name,";
    $sql .= "     t_client.client_cname,";
    $sql .= "     t_area.area_name,";
    $sql .= "     'true',";
    $sql .= "     '', ";
    $sql .= "     '', ";
    $sql .= "   CASE t_client.state ";
    $sql .= "       WHEN '1' THEN '取引中' ";
    $sql .= "       WHEN '2' THEN '解約・休止中' ";
    $sql .="    END AS state ";
    $sql .= " FROM";
    $sql .= "     t_client,";
    $sql .= "     t_area";
    $sql .= " WHERE";
    $sql .= "     t_client.area_id = t_area.area_id";
    $sql .= "     AND";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "     AND";
    $sql .= "     t_client.client_div = '1'";
    $sql .=       $where_sql;
    $sql .=       $turn_sql;

//請求書作成
}elseif($display == '3' || $display == "2-409" || $display == "2-405"){

    //請求先
    $sql  = "SELECT\n";
    $sql .= "    t_client.client_cd1,\n";
    $sql .= "    t_client.client_cd2,\n";
    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_client.client_cname,\n";
    $sql .= "    t_area.area_name,\n";
    $sql .= "    'true' AS claim_flg \n";
    $sql .= ($display == "2-409" || $display == "2-405") ? ", t_client.client_id, \n " : ",'', ";
    $sql .= "   '', ";
    $sql .= "   CASE t_client.state ";
    $sql .= "       WHEN '1' THEN '取引中' ";
    $sql .= "       WHEN '2' THEN '解約・休止中' ";
    $sql .="    END AS state ";

    if($display == '3'){
        $sql .= "   , CASE t_client.close_day";
        $sql .= "       WHEN '29' THEN '月末' ";
        $sql .= "       ELSE t_client.close_day||'日' ";
        $sql .= "   END AS close_day ";
    }

    if ($display == "2-405"){
        $sql .= "FROM\n";
        $sql .= "   (SELECT\n";
        $sql .= "       claim_id\n";
        $sql .= "   FROM\n";
        $sql .= "       t_claim\n";
        $sql .= "   GROUP BY \n";
        $sql .= "       claim_id \n";
        $sql .= "   HAVING \n";
        $sql .= "       COUNT(claim_id) > 1 \n";
        $sql .= "   ) AS t_claim \n";
    }else{
        $sql .= "FROM\n";
        $sql .= "    (SELECT\n";
        $sql .= "        claim_id\n";
        $sql .= "    FROM\n";
        $sql .= "        t_claim\n";
        $sql .= "    GROUP BY claim_id) AS t_claim\n";
    }
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_client\n";
    $sql .= "    ON t_claim.claim_id = t_client.client_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_area\n";
    $sql .= "    ON t_client.area_id = t_area.area_id \n";
/*
    if($group_kind == 2){
        $sql .= "   INNER JOIN \n";
        $sql .= "t_client_info \n";
        $sql .= "ON t_client.client_id = t_client_info.client_id \n";
    }
*/
    $sql .= "WHERE\n";
/*
    if($group_kind == 2){
        $sql .= " t_client_info.cclient_shop = $shop_id\n";
    }else{
    }
*/
    $sql .= " t_client.shop_id = $shop_id\n";
    $sql .=     $where_sql;
    $sql .=     $turn_sql;

}else{
	//請求先
    $sql  = "SELECT";
    $sql .= "   t_client.client_cd1,";
    $sql .= "   t_client.client_cd2,";
    $sql .= "   t_client.client_name,";
    $sql .= "   t_client.client_cname,";
    $sql .= "   t_area.area_name,";
    $sql .= "   CASE t_claim.claim_flg ";
    $sql .= "       WHEN 1 THEN 'true'";
    $sql .= "       ELSE 'false'";
    $sql .= "   END AS claim_flg, ";
    $sql .= "   t_client.pay_name, ";
    $sql .= "   t_client.account_name, ";
    $sql .= "   CASE t_client.state ";
    $sql .= "       WHEN '1' THEN '取引中' ";
    $sql .= "       WHEN '2' THEN '解約・休止中' ";
    $sql .="    END AS state ";
    $sql .= "FROM";
    $sql .= "   t_client";
    $sql .= "       LEFT JOIN";
    $sql .= "   (SELECT";
    $sql .= "       client_id,";
    $sql .= "       1 AS claim_flg";
    $sql .= "   FROM";
    $sql .= "       t_claim";
    $sql .= "   WHERE";
    $sql .= "       client_id IN (SELECT";
    $sql .= "                       client_id";
    $sql .= "                   FROM";
    $sql .= "                       t_claim";
    $sql .= "                   WHERE";
    $sql .= "                       client_id = claim_id";
    $sql .= "                   )";
    $sql .= "   GROUP BY client_id";
    $sql .= "   HAVING COUNT(client_id) = 1";
    $sql .= "   ) AS t_claim";
    $sql .= "   ON t_client.client_id = t_claim.client_id";
    $sql .= "       INNER JOIN";
    $sql .= "   t_area";
    $sql .= "   ON t_client.area_id = t_area.area_id ";
    $sql .= "WHERE";
    $sql .= "   t_client.client_div = '1'";
/*
    if ($display != "2-409" && $display != "2-405"){
    $sql .= "   AND";
    $sql .= "   t_client.state = '1'";
    }
*/
    $sql .= "   AND";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .=      $where_sql;
    $sql .=      $turn_sql;

}



//該当件数
$total_count_sql = $sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_num_rows($count_res);

/******************************/
//表示データ作成
/******************************/
//表示データ
$limit_sql = " LIMIT 100 OFFSET $offset";
$sql       = $sql.$limit_sql.";";
$result    = Db_Query($conn, $sql);

$match_count = pg_num_rows($result);
$page_data = Get_Data($result,2);
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
			$single = htmlspecialchars($single);
			//$single = htmlentities($page_data[$i][$j],ENT_COMPAT,EUC);
            $return = $return.",'".$single."'";
        }elseif($select_id == 2 && $j == 6){
            $pay_name1 = addslashes($page_data[$i][6]);
        }elseif($select_id == 2 && $j == 7){
            $pay_name2 = addslashes($page_data[$i][7]);
        } 
        $page_data[$i][$j] = htmlspecialchars($page_data[$i][$j],ENT_QUOTES);
    }

    //戻り値判定
    if ($display == "2-409" || $display == "2-405"){
		//入金入力
        $return_data[] = $return.",true,".$page_data[$i][6];

    }else if($display == '3'){
        $return_data[$i] = $return.",'".$page_data[$i][9]."'";
    }else if($display == 5){
		//契約マスタ  
        $return_data[] = $return.",true";
    }else{
        //得意先マスタ
        if($select_id == '2'){
            //請求先１の場合のみ
            $return_data[] = $single."','".$pay_name1."','".$pay_name2;
        }else{
		    $return_data[] = $single;
        }
	}
}
//print_r( $return_data );
// displayによるページタイトル設定
if ($display == "2-409" || $display == "2-405"){
    $page_title = "請求先一覧";
}else{
    $page_title = "得意先一覧";
}

//print_array($return_data);
/******************************/
//表示データ作成
/******************************/
/*
//表示データ
$limit_sql = " LIMIT 100 OFFSET $offset";
$sql       = $sql.$limit_sql.";";
$result    = Db_Query($conn, $sql);

$page_data = Get_Data($result);

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

//$html_page = Html_Page($total_count,$page_count,1,$range);
//$html_page2 = Html_Page($total_count,$page_count,2,$range);
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
$smarty->assign('row',$page_data);
$smarty->assign('return_data', $return_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
