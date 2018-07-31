<?php
/**************************
*変更履歴
*   （2006/05/08）
*       検索フォーム表示ボタン追加（watanabe-k）
*       表示データを得意先名から略称に変更（watanabe-k）
*    (2006/08/10)
*       代行業者、巡回担当者メイン、サブ１〜３での検索項目追加（watanabe-k）
*       直営以外のショップに関しては上記の処理はなし
***************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-02-22                  watanabe-k  不要機能の削除
 *  2007-03-16                  watanabe-k  種別の削除
 *  2007-03-26                  morita-d    CSVで契約明細を出力するように修正
 *  2007-05-10                  watanabe-k  一覧に代行先と巡回担当者を表示 
 *  2007-05-30                  fukuda      検索項目「契約状態」のデフォルトを「取引中」に変更
 *  2007-07-26                  watanabe-k  行No.と件数が一致するように修正
 *  2007-07-31                  watanabe-k  代行料の固定額もCSVに表示するように修正
 *  2007-08-28                  watanabe-k  CSVに前受相殺額を表示 
 *  2009-06-19		改修No.35	aizawa-m  	CSVに非同期を表示 
 *  2010-05-12      Rev.1.5     hashimoto-y 初期表示に検索項目だけ表示する修正
 *  2011-06-23      バグ修正    aoyama-n    CSVに販売区分「工事」「その他」が正しく出力されない
 *
*/



$page_title = "契約マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

// テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);

//戻り先を登録
//$_SESSION["back_page"] = basename($_SERVER[PHP_SELF]);
Set_Rtn_Page("contract");

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1",
    "form_show_page"     => "1",
    "form_state"     => "取引中",
//    "form_type"     => "3"
);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品
/****************************/
//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio1, "form_output_type", "出力形式");

//得意先コード
$form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$form_client[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\""
        );
$form->addGroup( $form_client, "form_client", "");

//得意先名
$form->addElement("text","form_client_name","テキストフォーム",'size="34" maxLength="15" '." $g_form_option");

//代行業者コード
$form_trust[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_trust[cd1]','form_trust[cd2]',6)\"".$g_form_option."\""
        );
$form_trust[] =& $form->createElement(
        "static","","","-"
        );
$form_trust[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\""
        );
$form->addGroup( $form_trust, "form_trust", "");

//代行業者名
$form->addElement("text","form_trust_name","テキストフォーム",'size="34" maxLength="15" '." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//地区
$area_ary[] = "";

$area_sql  = " SELECT";
$area_sql .= "      area_id,";
$area_sql .= "      area_name";
$area_sql .= " FROM";
$area_sql .= "      t_area";
$area_sql .= " WHERE";
$area_sql .= "      shop_id = $shop_id";
$area_sql .= ";";

$area_res = Db_Query($conn, $area_sql);
for($i = 0; $i < pg_num_rows($area_res); $i++){
    $area[] = pg_fetch_array($area_res, $i, PGSQL_NUM);
    $area_ary[$area[$i][0]] = $area[$i][1];
}
$form->addElement('select', 'form_area_id',"", $area_ary);

//契約担当者1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id1',"", $select_ary, $g_form_option_select );

//巡回担当者
$form->addElement('select', 'form_con_staff', "",$select_ary, $g_form_option_select);

//表示順
$radio3[] =& $form->createElement( "radio",NULL,NULL, "コード順","1");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "アイウエオ順","2");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "契約担当者コード順","3");
$form->addGroup($radio3, "form_turn", "表示順");

//表示件数
$radio4[] =& $form->createElement( "radio",NULL,NULL, "100件表示","1");
$radio4[] =& $form->createElement( "radio",NULL,NULL, "全件表示","2");
$form->addGroup($radio4, "form_show_page", "表示件数");

// 契約状態
$radio5[] =& $form->createElement( "radio",NULL,NULL, "取引中","取引中");
$radio5[] =& $form->createElement( "radio",NULL,NULL, "休止中","休止中");
$radio5[] =& $form->createElement( "radio",NULL,NULL, "全て","全て");
$form->addGroup($radio5, "form_state", "契約状態");

// ソートリンク
$ary_sort_item = array(
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    "sl_area"           => "地区", 
    "sl_staff_cd"       => "契約担当者1",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_client_cd");

//ボタン
$button[] = $form->createElement("submit","show_button","表　示");
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "ボタン");

//登録(ヘッダー)
$form->addElement("button","input_button","登　録","onClick=\"location.href='2-1-104.php?flg=add'\"");
$form->addElement("button","change_button","変更・一覧",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addElement("submit","form_search_button","検索フォームを表示");

//hidden
$form->addElement("hidden", "hdn_output_type","","");
$form->addElement("hidden", "hdn_client_cd1","","");
$form->addElement("hidden", "hdn_client_cd2","","");
$form->addElement("hidden", "hdn_client_name","","");
$form->addElement("hidden", "hdn_area_id","","");
$form->addElement("hidden", "hdn_c_staff_id1","","");
$form->addElement("hidden", "hdn_tel","","");
$form->addElement("hidden", "hdn_state","","");
$form->addElement("hidden", "hdn_turn","","");
$form->addElement("hidden", "hdn_show_page","","");
$form->addElement("hidden", "hdn_search_flg");
$form->addElement("hidden", "hdn_trust_cd1","","");
$form->addElement("hidden", "hdn_trust_cd2","","");
$form->addElement("hidden", "hdn_trust_name","","");
$form->addElement("hidden", "hdn_con_staff","","");
$form->addElement("hidden", "hdn_state","","");

/****************************/
//全件数取得
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     DISTINCT(t_client.client_id) ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
if($_SESSION["group_kind"] == '2'){
    $client_sql .= "    t_client.shop_id IN (".Rank_Sql().")";
}else{
    $client_sql .= "     t_client.shop_id = $shop_id";
}
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";

//ヘッダーに表示させる全件数
$count_res = Db_Query($conn, $client_sql.";");
$total_count = pg_num_rows($count_res);

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){

    $output_type    = $_POST["form_output_type"];           //出力形式
    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //得意先コード1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //得意先コード2
    $client_name    = trim($_POST["form_client_name"]);     //得意先名
    $area_id        = $_POST["form_area_id"];               //地区ID
    $staff_id       = $_POST["form_c_staff_id1"];           //契約担当者１
    $tel            = $_POST["form_tel"];                   //TEL
    $turn           = $_POST["form_turn"];                  //表示順
    $show_page      = $_POST["form_show_page"];
    $search_flg     = $_POST["hdn_search_flg"];
    $trust_cd1      = trim($_POST["form_trust"]["cd1"]);    //代行業者コード１
    $trust_cd2      = trim($_POST["form_trust"]["cd2"]);    //代行業者コード２
    $trust_name     = trim($_POST["form_trust_name"]);      //代行業者名
    $con_staff      = $_POST["form_con_staff"];             //巡回担当者
    $state          = $_POST["form_state"];                 // 契約状態

    $offset = 0;
    $sort_col = $_POST["hdn_sort_col"];

    $post_flg       = true;                                 //POSTフラグ
//検索フォーム表示ボタン押下
}elseif($_POST["form_search_button"] == "検索フォームを表示"){
    $output_type    = '1';
    $turn           = '1';
    $show_page      = '1';
    $offset         = 0;
    $state          = "取引中";
    $search_flg     = true;
    $sort_col = $_POST["hdn_sort_col"];

}elseif(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "表　示"
    && $_POST["form_search_button"] != "検索フォームを表示"){

    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
    $output_type    = $_POST["form_output_type"];
    $client_cd1     = $_POST["hdn_client_cd1"];
    $client_cd2     = $_POST["hdn_client_cd2"];
    $client_name    = $_POST["hdn_client_name"];
    $area_id        = $_POST["hdn_area_id"];
    $staff_id       = $_POST["hdn_c_staff_id1"];
    $tel            = $_POST["hdn_tel"];
    $turn           = $_POST["hdn_turn"];
    $show_page      = $_POST["hdn_show_page"]; 
    $search_flg     = $_POST["hdn_search_flg"];
    $trust_cd1      = $_POST["hdn_trust_cd1"];
    $trust_cd2      = $_POST["hdn_trust_cd2"];
    $trust_name     = $_POST["hdn_trust_name"];
    $con_staff      = $_POST["hdn_con_staff"];
    $state          = $_POST["hdn_state"];
    $sort_col = $_POST["hdn_sort_col"];

    $post_flg       = true;
}else{
    $output_type    = '1';
    $turn           = '1';
    $show_page      = '1';
    $state          = "取引中";
    $offset         = 0;
    $sort_col = "sl_client_cd";
}

$set_data["form_output_type"]       = stripslashes($output_type);
$set_data["form_client"]["cd1"]     = stripslashes($client_cd1);
$set_data["form_client"]["cd2"]     = stripslashes($client_cd2);
$set_data["form_client_name"]       = stripslashes($client_name);
$set_data["form_area_id"]           = stripslashes($area_id);
$set_data["form_c_staff_id1"]       = stripslashes($staff_id);
$set_data["form_tel"]               = stripslashes($tel);
$set_data["form_trun"]              = stripslashes($turn);
$set_data["form_show_page"]         = stripslashes($show_page);
$set_data["form_trust"]["cd1"]      = stripslashes($trust_cd1);
$set_data["form_trust"]["cd2"]      = stripslashes($trust_cd2);
$set_data["form_trust_name"]        = stripslashes($trust_name);
$set_data["form_con_staff"]         = stripslashes($con_staff);
$set_data["form_state"]             = $state;
$set_data["hdn_output_type"]        = stripslashes($output_type);
$set_data["hdn_client_cd1"]         = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]         = stripslashes($client_cd2);
$set_data["hdn_client_name"]        = stripslashes($client_name);
$set_data["hdn_area_id"]            = stripslashes($area_id);
$set_data["hdn_c_staff_id1"]        = stripslashes($staff_id);
$set_data["hdn_tel"]                = stripslashes($tel);
$set_data["hdn_turn"]               = stripslashes($turn);
$set_data["hdn_show_page"]          = stripslashes($show_page);
$set_data["hdn_search_flg"]         = stripslashes($search_flg);
$set_data["hdn_trust_cd1"]          = stripslashes($trust_cd1);
$set_data["hdn_trust_cd2"]          = stripslashes($trust_cd2);
$set_data["hdn_trust_name"]         = stripslashes($trust_name);
$set_data["hdn_con_staff"]          = $con_staff;
$set_data["hdn_state"]              = $state;

$form->setConstants($set_data);

if($post_flg == true){
    /****************************/
    //where_sql作成
    /****************************/
    //得意先コード1
    if($client_cd1 != null){
        $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'";
    }
       
    //得意先コード2
    if($client_cd2 != null){
        $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'";
    }

    //得意先名
    if($client_name != null){
        $client_name_sql  = " AND (t_client.client_name LIKE '%$client_name%' OR t_client.client_name2 LIKE '%$client_name%' OR t_client.client_cname LIKE '%$client_name%') ";
    }

    //地区
    if($area_id != 0){
        $area_id_sql = " AND t_area.area_id = $area_id";
    }

    //契約担当者
    if($staff_id != 0){
        $staff_id_sql = " AND t_client.c_staff_id1 = $staff_id";
    }

    //TEL
    if($tel != null){
        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
    }

/*
    //種別
    if($type != '3'){
        $type_sql = " AND t_client.type = '$type'";
    } 
*/

    //代行業者コード OR　代行業者名
    if($trust_cd1 != null || $trust_cd2 != null || $trust_name != null){

        $trust_sql  = " AND ";
        $trust_sql .= " t_client.client_id IN (SELECT ";
        $trust_sql .= "                             client_id ";
        $trust_sql .= "                         FROM ";
        $trust_sql .= "                             t_contract ";
        $trust_sql .= "                         WHERE ";
        $trust_sql .= "                             t_contract.trust_id IN (SELECT \n";
        $trust_sql .= "                                                     client_id \n";
        $trust_sql .= "                                                  FROM \n";
        $trust_sql .= "                                                     t_client \n";
        $trust_sql .= "                                                 WHERE \n";
        $trust_sql .= "                                                     client_div = '3' \n";
        //代行業者コード１
        if($trust_cd1 != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 client_cd1 LIKE '$trust_cd1%' \n";
        }
        //代行業者コード２
        if($trust_cd2 != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 client_cd2 LIKE '$trust_cd2%' \n";
        }
        //代行業者名
        if($trust_name != null){
            $trust_sql .= "                                                 AND\n";
            $trust_sql .= "                                                 (client_name LIKE '%$trust_name%'\n";
            $trust_sql .= "                                                 OR\n";
            $trust_sql .= "                                                 client_cname LIKE '%$trust_name%')\n";
        }
        $trust_sql .= "                                             )\n";
        $trust_sql .= "                     ) \n";
    }

    //巡回担当者（巡回担当者1〜4が検索対象）
		//CSVの場合
		if($output_type == 2 && $con_staff != null){
        $con_staff_sql  = " AND(\n";
        $con_staff_sql .= " t_con_staff1.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff2.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff3.staff_id = $con_staff\n";
        $con_staff_sql .= " OR \n";
        $con_staff_sql .= " t_con_staff4.staff_id = $con_staff\n";
        $con_staff_sql .= " )\n";

		//画面出力の場合
    }elseif($con_staff != null){
        $con_staff_sql  = " AND";
        $con_staff_sql .= " t_contract.contract_id IN (SELECT ";
        $con_staff_sql .= "                             contract_id ";
        $con_staff_sql .= "                         FROM ";
        $con_staff_sql .= "                             t_con_staff ";
        $con_staff_sql .= "                         WHERE ";
        $con_staff_sql .= "                             t_con_staff.staff_id = $con_staff\n";
        $con_staff_sql .= "                         )";
    }

    $where_sql  = $client_cd1_sql;
    $where_sql .= $client_cd2_sql;
    $where_sql .= $client_name_sql;
    $where_sql .= $area_id_sql;
    $where_sql .= $staff_id_sql;
    $where_sql .= $tel_sql;
//    $where_sql .= $type_sql;
    $where_sql .= $trust_sql;
    $where_sql .= $con_staff_sql;
}

/****************************/
//表示データ作成
/****************************/

#2010-05-13 hashimoto-y
if($post_flg == true){


/****************************/
//全データ取得
/****************************/
$client_sql  = "SELECT DISTINCT \n";
$client_sql .= "    t_client.client_id,\n";
$client_sql .= "    t_client.client_cd1,\n";
$client_sql .= "    t_client.client_cd2,\n";
$client_sql .= "    t_client.client_name,\n";
$client_sql .= "    t_client.client_cname,\n";
$client_sql .= "    t_area.area_name,\n";
$client_sql .= "    t_client.tel,\n";
//$client_sql .= "    t_client.state,\n";
$client_sql .= "    t_staff.staff_name,\n";
$client_sql .= "    t_staff.charge_cd,\n";
//$client_sql .= "    t_staff.staff_cd1 || '-' ||t_staff.staff_cd2,\n";
//$client_sql .= "    t_client.type, \n";
$client_sql .= "    t_client.client_name2, \n";
//$client_sql .= "    t_client.address1, \n";
//$client_sql .= "    t_client.address2, \n";
//$client_sql .= "    t_client.address3, \n";
$client_sql .= "    CASE ";
$client_sql .= "        WHEN t_con_state.client_id IS NOT NULL THEN '取引中' ";
$client_sql .= "        ELSE '休止中' ";
$client_sql .= "    END AS state, ";
$client_sql .= "    t_staff2.staff_id AS staff2_id, \n";
$client_sql .= "    t_staff2.charge_cd AS staff2_charge_cd, \n";
$client_sql .= "    t_staff2.staff_name AS staff2_name, \n";
$client_sql .= "    t_trust_client.client_id AS trust_client_id, \n";
$client_sql .= "    t_trust_client.client_cd1 AS trust_client_cd1, \n";
$client_sql .= "    t_trust_client.client_cd2 AS trust_client_cd2, \n";
$client_sql .= "    t_trust_client.client_name AS trust_client_name, \n";
$client_sql .= "    t_area.area_cd \n";

$client_sql .= "FROM \n";
$client_sql .= "    t_contract\n";

//得意先マスタ抽出用
$client_sql .= "        INNER JOIN\n";
$client_sql .= "    t_client\n";
$client_sql .= "    ON t_client.client_id = t_contract.client_id\n ";
$client_sql .= "        INNER JOIN \n";

//地区抽出用
$client_sql .= "    t_area\n";
$client_sql .= "    ON t_client.area_id = t_area.area_id";

//契約担当１抽出用
$client_sql .= "        LEFT JOIN\n";
$client_sql .= "    t_staff\n";
$client_sql .= "    ON t_client.c_staff_id1 = t_staff.staff_id \n ";

//巡回担当者抽出用
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_con_staff\n";
$client_sql .= "    ON t_contract.contract_id = t_con_staff.contract_id\n";
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_staff AS t_staff2\n";
$client_sql .= "    ON t_con_staff.staff_id = t_staff2.staff_id \n";

//代行先抽出用
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    t_client AS t_trust_client ";
$client_sql .= "    ON t_contract.trust_id = t_trust_client.client_id ";

// 契約状態抽出用
$client_sql .= "        LEFT JOIN \n";
$client_sql .= "    (SELECT \n";
$client_sql .= "        client_id ";
$client_sql .= "    FROM ";
$client_sql .= "        t_contract ";
$client_sql .= "    WHERE ";
$client_sql .= "        state = '1' ";
$client_sql .= "    ) AS t_con_state ";
$client_sql .= "    ON t_client.client_id = t_con_state.client_id ";


$client_sql .= " WHERE\n";
$client_sql .= "     t_client.shop_id = $shop_id\n";
$client_sql .= "     AND\n";
$client_sql .= "     t_client.client_div = 1\n";
$client_sql .= "     AND\n";
$client_sql .= "     t_client.area_id = t_area.area_id \n";

// 契約状態
if ($state == "取引中"){
    $client_sql .= " AND t_con_state.client_id IS NOT NULL \n";
}else
if ($state == "休止中"){
    $client_sql .= " AND t_con_state.client_id IS NULL \n";
}else
if ($state == "全て"){
    $cleint_sql .= null;
}else
if ($state == null){
    $client_sql .= " AND t_con_state.client_id IS NOT NULL \n";
}
    
/*
if (($_POST["form_button"]["show_button"] != "表　示")){
    $client_sql .= "AND \n";
    $client_sql .= "    t_con_state.client_id IS NOT NULL \n";
}
*/

//表示順
//CSVの場合は「契約NO.」「行」のソートを付け加える
if($output_type == '2'){
	$csv_order = ",t_contract.line,t_con_info.line ";
}else{
	$csv_order = ",t_staff2.charge_cd, t_trust_client.client_cd1, t_trust_client.client_cd2 ";
}
/*
if($turn == '1'){
    $turn_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 $csv_order ASC\n";
}else if($turn == '2'){
    $turn_sql = " ORDER BY t_client.client_name $csv_order ASC\n";
}else{
    $turn_sql = " ORDER BY t_staff.charge_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
}
*/
switch ($sort_col){
    case "sl_client_cd":
        $turn_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 $csv_order ASC\n";
        break;
    case "sl_client_name":
        $turn_sql = " ORDER BY t_client.client_name $csv_order ASC\n";
        break;
    case "sl_area":
        $turn_sql = " ORDER BY t_area.area_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
        break;
    case "sl_staff_cd":
        $turn_sql = " ORDER BY t_staff.charge_cd, t_client.client_cd1, t_client.client_cd2 $csv_order ASC\n";
        break;
}


if($show_page == '1'){
//    $limit = " LIMIT 100 OFFSET $offset";
}

//画面選択時
if($output_type != '2'){
    
    //該当件数
    $client_sql .= $where_sql.$turn_sql;
    $total_count_sql = $client_sql.";";
    $result = Db_Query($conn, $total_count_sql);
    $page_data = Make_Show_Data($result);
    $t_count = count($page_data); 

    //ページ分けを行なう
    $page_data = Make_Page_Data($page_data, $show_page, $offset);
    $match_count = count($page_data);

/*
    $sql = $client_sql.$limit.";";
    $result = Db_Query($conn, $sql);
    $match_count = pg_num_rows($result);
    
    $page_data = Make_Show_Data($result);
    $match_count = count($page_data); 
*/
//CSV出力処理
}else if($output_type == 2){

	//直営は代行関連の項目を出力
	if($_SESSION["group_kind"] == '2'){
		$act_column ="
            t_trust_client.client_cd1||'-'||t_trust_client.client_cd2 AS trust_cd,
            t_trust_client.shop_name AS trust_name,
			CASE t_contract.contract_div
				WHEN '1' THEN '通常'
				WHEN '2' THEN 'オンライン代行'
				WHEN '3' THEN 'オフライン代行'
			END,
--			t_contract.act_request_rate || '%',
            CASE t_contract.act_div
                WHEN '2' THEN CAST(act_request_price AS varchar)
            END,
            CASE t_contract.act_div
                WHEN '3' THEN t_contract.act_request_rate || '%'
            END,
			t_contract.trust_ahead_note ,
			t_contract.trust_note       ,
--			CASE t_contract.request_state
--				WHEN '1' THEN '依頼中'
--				WHEN '2' THEN '受託済'
--			END,
            CASE
                WHEN contract_div IN ('2','3') THEN 
                                                CASE t_contract.request_state
                                				    WHEN '1' THEN '依頼中'
				                                    WHEN '2' THEN '受託済'
                                                END
            END,

		";
	}

	$sql = "
	SELECT 
	t_client.client_cd1 || '-' || t_client.client_cd2 ,
	t_contract.line             ,
	t_con_info.line               ,
	t_client.client_name,
	t_client.client_name2,
	t_client.client_cname,
	--t_contract.sale_amount      ,
	--t_contract.trade_amount     ,
	--t_con_staff.trade_amount     ,
    CASE t_contract.state 
        WHEN '1' THEN '取引中'
        WHEN '2' THEN '解約・休止中'
    END AS state,
	lpad(t_contract.route, 4, '0'),
	round_div AS 巡回区分,
	CASE     
	    WHEN round_div = '1' AND (abcd_week=1 OR abcd_week=2 OR abcd_week=3 OR abcd_week=4 ) THEN '4' || '週'
	    WHEN round_div = '1' AND (abcd_week=21 OR abcd_week=22 OR abcd_week=23 OR abcd_week=24 ) THEN '8' || '週'
	    WHEN round_div = '1' AND (abcd_week=5 OR abcd_week=6)  THEN '2' || '週'
	    WHEN round_div = '2' THEN '1' || 'ヶ月'
	    WHEN round_div = '3' THEN '1' || 'ヶ月'
	    WHEN round_div = '4' THEN cycle || '週'
	    WHEN round_div = '5' THEN cycle || 'ヶ月'
	    WHEN round_div = '6' THEN cycle || 'ヶ月'
	END AS 周期,
	
	CASE
	    WHEN round_div = '1' AND (abcd_week=1 OR abcd_week=21) THEN 'A週'
	    WHEN round_div = '1' AND (abcd_week=2 OR abcd_week=22) THEN 'B週'
	    WHEN round_div = '1' AND (abcd_week=3 OR abcd_week=23) THEN 'C週'
	    WHEN round_div = '1' AND (abcd_week=4 OR abcd_week=24) THEN 'D週'
	    WHEN round_div = '1' AND (abcd_week=5) THEN 'AC週'
	    WHEN round_div = '1' AND (abcd_week=6) THEN 'BD週'
	    WHEN round_div = '3' THEN '第' || cale_week || '週'
	END AS 週区分,
	
	CASE t_contract.round_div        
	    WHEN '2' THEN rday ||'日'  
	    WHEN '5' THEN rday ||'日'  
	    WHEN '7' THEN '変則日'  
	END AS 指定日,
	
	CASE t_contract.week_rday        
	    WHEN '1' THEN '月曜'
	    WHEN '2' THEN '火曜'
	    WHEN '3' THEN '水曜'
	    WHEN '4' THEN '木曜'
	    WHEN '5' THEN '金曜'
	    WHEN '6' THEN '土曜'
	    WHEN '7' THEN '日曜'
	END AS 指定曜日,
	t_contract.last_day         ,
	t_staff.staff_name,
	t_con_staff1.staff_name,
	t_con_staff1.sale_rate,
	t_con_staff2.staff_name,
	t_con_staff2.sale_rate,
	t_con_staff3.staff_name,
	t_con_staff3.sale_rate,
	t_con_staff4.staff_name,
	t_con_staff4.sale_rate,
	
	--t_contract.round_div        ,
	--t_contract.cycle            ,
	--t_contract.cycle_unit       ,
	--t_contract.rday             ,
	--t_contract.week_rday        ,
	--t_contract.shop_id          ,
	--t_contract.act_request_day  ,
	--t_contract.act_trust_day    ,
	--t_contract.trust_id         ,
	$act_column
	
	--t_contract.act_goods_id     ,
	--t_contract.trust_line       ,
	--t_contract.intro_ac_price   ,
	--t_contract.intro_ac_rate    ,
	--t_contract.claim_id         ,
	--t_contract.claim_div        ,
	--t_contract.state            ,
	--t_contract.intro            ,
	t_contract.enter_day        ,
	t_contract.contract_day     ,
	t_contract.stand_day        ,
	t_contract.update_day       ,
	t_contract.contract_eday    ,
	
	----------------------------------------------
	--t_con_info.con_info_id        ,
	--t_con_info.contract_id        ,
    --2011-06-23 aoyama-n
	CASE t_con_info.divide
		WHEN '01' THEN 'リピート'
		WHEN '02' THEN '商品'
		WHEN '03' THEN 'レンタル'
		WHEN '04' THEN 'リース'
		WHEN '05' THEN '工事'
		WHEN '06' THEN 'その他'
		--WHEN '05' THEN '卸'
		--WHEN '06' THEN '工事'
		--WHEN '07' THEN 'その他'
	END,
	--t_con_info.serv_id            ,
	t_serv.serv_cd,
	t_serv.serv_name,
	CASE t_con_info.serv_pflg
		WHEN 't' THEN 'する'
		ELSE 'しない'
	END,
	--t_con_info.goods_id           ,
	t_goods.goods_cd          ,
	t_con_info.official_goods_name         ,
	t_con_info.goods_name         ,
	CASE t_con_info.goods_pflg
		WHEN 't' THEN 'する'
		ELSE 'しない'
	END,
	t_con_info.num                ,
	CASE t_con_info.set_flg
		WHEN 't' THEN '○'
		ELSE ''
	END,
	t_con_info.trade_price        ,
	t_con_info.trade_amount       ,
	t_con_info.sale_price         ,
	t_con_info.sale_amount        ,
	--t_con_info.egoods_id          ,
	t_egoods.goods_cd          ,
	t_con_info.egoods_name        ,
	t_con_info.egoods_num         ,
	--t_con_info.rgoods_id          ,
	t_rgoods.goods_cd          ,
	t_con_info.rgoods_name        ,
	t_con_info.rgoods_num         ,
	t_con_info.account_price      ,
	CASE t_con_info.account_rate
		WHEN NULL THEN ''
		WHEN '' THEN ''
		ELSE t_con_info.account_rate || '%'
	END,
	--t_con_info.trust_trade_price  ,
	--t_con_info.trust_trade_amount 
    CASE t_con_info.advance_flg 
        WHEN '2' THEN advance_offset_amount
    END AS advance_total,
--	t_contract.note
-- 2009/06/19 改修No.35 追加
	t_contract.note,
	CASE t_con_info.mst_sync_flg
		WHEN 't' THEN '○'
		ELSE ''
	END
-- -----------------
	---------------------------------------
	FROM t_contract
	INNER JOIN t_con_info ON t_contract.contract_id = t_con_info.contract_id
	INNER JOIN t_client ON t_client.client_id = t_contract.client_id
    LEFT JOIN t_client AS t_trust_client ON t_contract.trust_id = t_trust_client.client_id 

-- 以下結合の必要なし
--        LEFT JOIN
--    (SELECT
--        (client_id)
--    FROM
--        t_contract
--    WHERE
--        state = '1'
--    ) AS t_con_state 
--    ON t_client.client_id = t_con_state.client_id 
	INNER JOIN t_area ON t_client.area_id = t_area.area_id
	LEFT JOIN t_staff ON t_client.c_staff_id1 = t_staff.staff_id 
	LEFT JOIN t_goods AS t_goods ON t_con_info.goods_id = t_goods.goods_id
	LEFT JOIN t_goods AS t_rgoods ON t_con_info.rgoods_id = t_rgoods.goods_id
	LEFT JOIN t_goods AS t_egoods ON t_con_info.egoods_id = t_egoods.goods_id
	LEFT JOIN t_serv  ON t_con_info.serv_id = t_serv.serv_id
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='0'
		) AS t_con_staff1
		ON t_contract.contract_id = t_con_staff1.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='1'
		) AS t_con_staff2
		ON t_contract.contract_id = t_con_staff2.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='2'
		) AS t_con_staff3
		ON t_contract.contract_id = t_con_staff3.contract_id
	
	LEFT JOIN 
		(
			SELECT t_con_staff.contract_id, t_con_staff.staff_id, staff_name, sale_rate 
			FROM t_con_staff 
			INNER JOIN t_staff ON t_con_staff.staff_id = t_staff.staff_id 
			WHERE t_con_staff.staff_div='3'
		) AS t_con_staff4
		ON t_contract.contract_id = t_con_staff4.contract_id
	WHERE t_contract.shop_id = $shop_id
	$where_sql
    ";
    // 契約状態
/*
    if ($state == "取引中"){
        $sql .= " AND t_contract.state = '' \n";
        $sql .= " AND t_con_state.client_id IS NOT NULL \n";
    }else
    if ($state == "休止中"){
        $sql .= " AND t_con_state.client_id IS NULL \n";
    }else
    if ($state == "全て"){
        $sql .= null;
    }else
    if ($state == null){
        $sql .= " AND t_con_state.client_id IS NOT NULL \n";
    }
*/
    if ($state == "取引中"){
        $sql .= " AND t_contract.state = '1' \n";

    } elseif ($state == "休止中"){
        $sql .= " AND t_contract.state = '2' \n";
    }


    $sql .= "
	$turn_sql
	;
	";

	$result      = Db_Query($conn, $sql);
    $i = 0;
	while($csv_page_data[] = pg_fetch_row($result));

    //該当件数
    //$client_sql .= $where_sql.$turn_sql;
    //$sql = $client_sql.";";
/*
    $count_res = Db_Query($conn, $sql);
    $match_count = pg_num_rows($count_res);    
    $page_data = Get_Data($count_res, $output_type);

    //CSV作成
    $result = Db_Query($conn, $sql);
        for($i = 0; $i < $match_count; $i++){
            $csv_page_data[$i][0] = $page_data[$i][1]."-".$page_data[$i][2];
            $csv_page_data[$i][1] = $page_data[$i][3];
            $csv_page_data[$i][2] = $page_data[$i][12];
            $csv_page_data[$i][3] = $page_data[$i][4];
            $csv_page_data[$i][4] = $page_data[$i][5];
            $csv_page_data[$i][5] = $page_data[$i][13];
            $csv_page_data[$i][6] = $page_data[$i][14];
            $csv_page_data[$i][7] = $page_data[$i][15];
            $csv_page_data[$i][8] = $page_data[$i][6];
            if($page_data[$i][7] == 1){
                $page_data[$i][7] = "取引中";
            }else{
                $page_data[$i][7] = "休止中";
            }
            $csv_page_data[$i][9] = $page_data[$i][7];

        }
*/
	$csv_file_name = "契約マスタ".date("Ymd").".csv";

	//------------------
	//CSVヘッダ作成
	//------------------
	$csv_header_1 = array(
	"得意先コード",
	"契約No.",
	"行",
	"得意先名1",
	"得意先名2",
	"略称",
	"契約状態",
	"順路",
	"巡回区分",
	"周期",
	"週区分",
	"指定日",
	"指定曜日",
	"変則最終日",
	"契約担当者",
	"巡回担当者1",
	"売上率1",
	"巡回担当者2",
	"売上率2",
	"巡回担当者3",
	"売上率3",
	"巡回担当者4",
	"売上率4",
	);

	$csv_header_2 = array(
	"委託先コード",
	"委託先名",
	"代行区分",
	"代行依頼料(固定額)",
	"代行依頼料(売上率)",
	"代行用備考（東陽欄）",
	"代行用備考（受託先欄）",
	"代行状況",
	);

	$csv_header_3 = array(
	"初回登録日",
	"登録日",
	"契約発効日",
	"修正発効日",
	"契約終了日",
	"販売区分",
	"サービスコード",
	"サービス名",
	"サービス印字",
	"アイテムコード",
	"アイテム名（正式）",
	"アイテム名（略称）",
	"アイテム印字",
	"アイテム数",
	"一式",
	"営業原価",
	"原価合計額",
	"売上単価",
	"売上合計額",
	"消耗品コード",
	"消耗品名",
	"消耗品数",
	"本体商品コード",
	"本体商品名",
	"本体商品数",
	"紹介口座額",
	"紹介口座率",
    "前受相殺額",
	"備考",
	"非同期",//--2009/06/19 改修No.35 追加
	);

	//直営は代行関連の項目を出力
	if($_SESSION["group_kind"] == '2'){
		$csv_header = array_merge($csv_header_1, $csv_header_2,$csv_header_3);

	//FCの場合
	}else{
		$csv_header = array_merge($csv_header_1, $csv_header_3);
	}
	
	
	$csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	//$csv_file_name = time().".csv";
	$csv_data = Make_Csv($csv_page_data, $csv_header);
	Header("Content-disposition: attachment; filename=$csv_file_name");
	Header("Content-type: application/octet-stream; name=$csv_file_name");
	print $csv_data;
	exit;
}

/*
//ページ分けリンク押下処理？
if(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "表　示" 
    && $_POST["form_search_button"] != "検索フォームを表示"){

    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }
    $sql = $client_sql.$limit.";";
}


//表示データ整形処理？
if ($_POST["form_button"]["show_button"] == "表　示" || $_POST["form_search_button"] == "検索フォームを表示"){

    for($i = 0; $i < $match_count; $i++){
    //担当者コードがあった場合、ハイフンをつける
        if($page_data[$i][8] != null){
            $page_data[$i][8] = $page_data[$i][8]."-";
        }
        $shop_state[$i][0] = 'f'.$page_data[$i][0];
        $shop_state[$i][1] = $page_data[$i][0];
    }
    $form->setConstants($update_data);
}

//ページ分けリンク押下処理
if(count($_POST) > 0 
    && $_POST["form_button"]["show_button"] != "表　示"  
    && $_POST["form_search_button"] != "検索フォームを表示"){
    $page_count  = $_POST["f_page1"];
    
    $offset = $page_count * 100 - 100;
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }

    $sql = $client_sql.$limit.";";
    $result = Db_Query($conn, $sql);
//  $t_count = pg_num_rows($result);
}

$result = Db_Query($conn, $sql);
$match_count = pg_num_rows($result);

//状態で検索時、状態変更によってページ数等が変わる場合
if($match_count == 0){
    if($_POST["f_page1"] == 2){
        //ページ数が１ページになる場合
        $offset = 0;
        $page_count  = 0;
    }else{
        //ページ数が１ページ以上の場合
        $page_count  = $_POST["f_page1"]-1;
        $offset = $page_count * 100 - 100;
    }
    if($show_page != '2'){
        $limit = " LIMIT 100 OFFSET $offset";
    }
    $sql = $client_sql.$limit.";";
    $page_change = true;
}
$result = Db_Query($conn, $sql);

$match_count = pg_num_rows($result);
$page_data = Get_Data($result, '1');


for($i = 0; $i < $match_count; $i++){
    //得意先コードにハイフンを付加
    $page_data[$i][1] = $page_data[$i][1]."-";

	if($page_data[$i][9] != NULL){
    $page_data[$i][9] = str_pad ($page_data[$i][9],4, "0", STR_PAD_LEFT);
  }
}
$form->setConstants($update1_data);
*/


#2010-05-12 hashimoto-y
$display_flg = true;
}


/****************************/
//データ生成関数
/****************************/
function Make_Show_Data($result){

    $page_data = pg_fetch_all($result);

    //データがない場合
    if(!is_array($page_data)){
        return;
    }

    $line = -1;
    $row  = 0 ; //行Ｎｏ．

    foreach($page_data AS $key => $var){

        //得意先が変わった場合
        if($client_id != $var["client_id"]){

            $client_id = $var["client_id"];

            $line++;

            $make_data[$line]["client_id"]          = $var["client_id"];
            $make_data[$line]["client_cd1"]         = $var["client_cd1"];
            $make_data[$line]["client_cd2"]         = $var["client_cd2"];
            $make_data[$line]["client_name"]        = htmlspecialchars($var["client_name"]);
            $make_data[$line]["client_cname"]       = htmlspecialchars($var["client_cname"]);
            $make_data[$line]["area_name"]          = htmlspecialchars($var["area_name"]);
            $make_data[$line]["tel"]                = $var["tel"];
            if($var["charge_cd"] != null){
                $make_data[$line]["charge_cd"]      = str_pad($var["charge_cd"], 4, "0", STR_PAD_LEFT) ;
            }

            $make_data[$line]["staff_name"]         = htmlspecialchars($var["staff_name"]);
            $make_data[$line]["state"]              = $var["state"];

            //巡回担当者がいる場合
            if($var["staff2_id"] != null){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]         = str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }

            //代行先がいる場合
            if($var["trust_client_id"] != null){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]          = $var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }

        //同じ得意先のデータの場合
        }else{
            //巡回担当
            if($var["staff2_id"] == null){
            }elseif(count($make_data[$line]["staff_id"]) == 0){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]         = str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }elseif(!in_array($var["staff_id"], $make_data[$line]["staff_id"])){
                $make_data[$line]["staff_id"][]     = $var["staff2_id"];
                $make_data[$line]["staff2"]        .= "<br>".str_pad($var["staff2_charge_cd"], 4, "0", STR_PAD_LEFT);
                $make_data[$line]["staff2"]        .= "<br>".htmlspecialchars($var["staff2_name"]);
            }

            //代行
            if($var["trust_client_id"] == null){
            }elseif(count($make_data[$line]["trust_id"]) == 0){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]          = $var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }elseif(!in_array($var["trust_client_id"], $make_data[$line]["trust_id"])){
                $make_data[$line]["trust_id"][]     = $var["trust_client_id"];
                $make_data[$line]["trust"]         .= "<br>".$var["trust_client_cd1"];
                $make_data[$line]["trust"]         .= "-".$var["trust_client_cd2"];
                $make_data[$line]["trust"]         .= "<br>".htmlspecialchars($var["trust_client_name"]);
            }
        }
    }

    return $make_data;
}


//ページごとのデータに纏める関数
function Make_Page_Data($make_data, $show_page, $offset=0){

    //100件表示ではない場合
    if($show_page != '1'){
        return $make_data;
    }
    for($i = $offset, $j=0; $i < $offset+100; $i++, $j++){

        if(!is_array($make_data[$i])){
            break;
        }

        $page_data[$j] = $make_data[$i];
    }

    return $page_data;
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
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[input_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
//表示範囲指定
$range = "100";

$html_page = Html_Page($t_count,$page_count,1,$range);
$html_page2 = Html_Page($t_count,$page_count,2,$range);

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
    'page_change'   => "$page_change",
    'display_flg'   => "$display_flg",
    
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
