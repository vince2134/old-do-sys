<?php
/******************************
*変更履歴
*   （2006/05/08）
*       検索フォーム表示ボタン追加（watanabe-k）
*       表示データの得意先名から略称に変更（watanabe-k）
*
*   （2006/07/07）
*       一覧にどの得意先か、FC名を追加（kaji）
*
*   （2006/08/11）
*       小分類業種マスタとの結合はLEFT JOINに修正(hashimoto)
*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0004     suzuki     地区のフォームをプルダウンからテキストに変更
 *  2006-12-07      ban_0096     suzuki     表示ボタン押下時に行NO初期化
 *  2006-12-07      ban_0095     suzuki     データ抽出結合条件修正
 *  2007-01-24      仕様変更     watanabe-k ボタンの色変更
 *  2007-01-24      仕様変更     watanabe-k ヘッダのボタン削除
 *  2007-02-22                   watanabe-k 不要機能の削除
 *  2007-05-16                   kaku-m     フォーム・検索項目の追加と削除。CSVの修正。
 *  2010-05-13      Rev.1.5     hashimoto-y 初期表示に検索項目だけ表示する修正
*/

$page_title = "得意先マスタ";

//environment setting file 環境設定ファイル
require_once("ENV_local.php");

//create HTML_QuickForm HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=return confirm(true)");

// register templace function テンプレート関数をレジスト
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//connect to Database DBに接続
$conn = Db_Connect();

// authorization check 権限チェック
$auth       = Auth_Check($conn);

/****************************/
//acquire outside variable 外部変数取得
/****************************/
$shop_id = $_SESSION[client_id];

/****************************/
//set default valueデフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"  => "1",
    "form_show_page"    => "1",
//    "form_display_num"  => "1",
//    "form_client_gr"    => "",
//    "form_parents_div"  => "3",
    "form_shop"         => array("cd1"=> "","cd2"=>""),
    "form_client"       => array("cd1" => "", "cd2" => ""),
//    "form_area_id"      => "",
    "form_tel"          => "",
//    "form_c_staff"      => "",
    "form_btype"        => "",
    "form_rank"         => "",
    "form_state_type"   => "1",
    "form_state_type_s"   => "1",
//    "form_trade"        => "",
);
// restore search condition 検索条件復元
//Restore_Filter2($form, "contract", "show_button", $def_fdata);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品 component for creating HTML image 
/****************************/
//ボタン button
//変更・一覧 edit・list
//$form->addElement("button", "new_button", "登録画面", "onClick=\"javascript:Referer('1-1-115.php')\"");

//登録(ヘッダ) register (header)
//$form->addElement("button", "change_button", "変更・一覧", $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//output format 出力形式
$radio1[] =& $form->createElement("radio", null, null, "画面", "1");
$radio1[] =& $form->createElement("radio", null, null, "CSV", "2");
$form->addGroup($radio1, "form_output_type", "出力形式");

//customer code 得意先コード
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" $g_form_option ");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text, "form_client", "form_client");

//shop code ショップコード
Addelement_Client_64($form, "form_shop", "ショップコード", " - ");
//ショップ名
$form->addElement("text", "form_shop_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//FC・customer classification FC・得意先区分
$select_value = Select_Get($conn, "rank");
$form->addElement("select", "form_rank", "FC・取引先区分", $select_value, $g_form_option_select);



//industry 業種
$sql  = "SELECT t_lbtype.lbtype_cd, t_lbtype.lbtype_name, t_sbtype.sbtype_id, t_sbtype.sbtype_cd, t_sbtype.sbtype_name ";
$sql .= "FROM   t_lbtype ";
$sql .= "       INNER JOIN t_sbtype ";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id ";
$sql .= "ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd ";
$sql .= ";";
$result = Db_Query($conn, $sql);
while($data_list = pg_fetch_array($result)){
    $max_len = ($max_len < mb_strwidth($data_list[1])) ? mb_strwidth($data_list[1]) : $max_len;
}
$result = Db_Query($conn, $sql);
$select_value = null;
$select_value[null] = null;
while($data_list = pg_fetch_array($result)){
    for($i = 0; $i< $max_len; $i++){
        $data_list[1] = (mb_strwidth($data_list[1]) <= $max_len && $i != 0) ? $data_list[1]."　" : $data_list[1];
    }
    $select_value[$data_list[2]] = $data_list[0]." ： ".$data_list[1]."　　 ".$data_list[3]." ： ".$data_list[4];
}
$form->addElement('select', 'form_btype',"", $select_value, $g_form_option_select);


//customer name 得意先名
$form->addElement("text", "form_client_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//TEL
$form->addElement("text", "form_tel", "", "size=\"15\" maxLength=\"13\" style=\"$g_form_style\" $g_form_option");

//map 地区
/*
$select_value = "";
$select_value = Select_Get($conn, "h_area");
$form->addElement("select", 'form_area_id', "", $select_value);
*/
$form->addElement("text", "form_area_id", "", "size=\"25\" maxLength=\"10\" $g_form_option");


//condition (customer) 状態（得意先）
$radio2[] =& $form->createElement("radio", null, null, "取引中", "1");
$radio2[] =& $form->createElement("radio", null, null, "解約・休止中", "2");
//$radio2[] =& $form->createElement("radio", null, null, "解約", "3");
$radio2[] =& $form->createElement("radio", null, null, "全て", "4");
$form->addGroup($radio2, "form_state_type", "状態");


//condition (shop) 状態（ショップ）
$radios[] =& $form->createElement("radio", null, null, "取引中", "1");
$radios[] =& $form->createElement("radio", null, null, "解約・休止中", "2");
//$radio2[] =& $form->createElement("radio", null, null, "解約", "3");
$radios[] =& $form->createElement("radio", null, null, "全て", "4");
$form->addGroup($radios, "form_state_type_s", "状態");




//type/classification 種別
//$form_type[] =& $form->createElement("radio", null, null, "リピート", "1");
//$form_type[] =& $form->createElement("radio", null, null, "リピート外", "2");
//$form_type[] =& $form->createElement("radio", null, null, "全て", "3");
//$form->addGroup($form_type, "form_type", "種別");

//page separation ページ分け
$radio4[] =& $form->createElement("radio", null, null, "100件表示", "1");
$radio4[] =& $form->createElement("radio", null, null, "全件表示", "2");
$form->addGroup($radio4, "form_show_page", "表示形式");

//button ボタン
$button[] = $form->createElement("submit", "show_button", "表　示");
$button[] = $form->createElement("button", "clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "ボタン");

//sort link ソートリンク
$ary_sort_item = array(
    "sl_rank"           => "FC・取引先区分",
    "sl_shop_cd"        => "ショップコード",
    "sl_shop_name"      => "ショップ名",
    "sl_client_cd"      => "得意先コード",
    "sl_client_name"    => "得意先名",
    //"sl_area"           => "地区", 
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_shop_cd");

//hidden
$form->addElement("hidden", "hdn_output_type", "", "");
$form->addElement("hidden", "hdn_client_cd1", "", "");
$form->addElement("hidden", "hdn_client_cd2", "", "");
$form->addElement("hidden", "hdn_client_name", "", "");
$form->addElement("hidden", "hdn_btype", "", "");
$form->addElement("hidden", "hdn_rank", "", "");
$form->addElement("hidden", "hdn_area_id", "", "");
$form->addElement("hidden", "hdn_tel", "", "");
$form->addElement("hidden", "hdn_shop_cd1","","");
$form->addElement("hidden", "hdn_shop_cd2","","");
$form->addElement("hidden", "hdn_shop_name", "", "");
$form->addElement("hidden", "hdn_show_page", "", "");
//$form->addElement("hidden", "hdn_type");            //type 種別
$form->addElement("hidden", "hdn_state");           //condition 状態
$form->addElement("hidden", "hdn_state_s");           //condition 状態

/****************************/
//全件数取得 acquire all items 
/****************************/
$count_sql  = " SELECT COUNT(client_id) FROM t_client WHERE t_client.client_div = '1';";

//ヘッダーに表示させる全件数 all items that will be displayed in the header
$total_count_sql = $count_sql;
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res, 0, 0);


/****************************/
//POST
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];           //出力形式 output format
    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //得意先コード1 customer code 1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //得意先コード2 customer code 2
    $client_name    = trim($_POST["form_client_name"]);     //得意先名 customer name 
    $btype          = $_POST["form_btype"];                 // 業種 industry
    $rank           = $_POST["form_rank"];
    $area_id        = $_POST["form_area_id"];               //地区ID district ID
    $state          = $_POST["form_state_type"];            //状態 condition 
    $state_s          = $_POST["form_state_type_s"];            //状態 condition 
    $tel            = $_POST["form_tel"];                   //TEL
    $shop_cd1       = trim($_POST["form_shop"]["cd1"]);
    $shop_cd2       = trim($_POST["form_shop"]["cd2"]);
    $shop_name      = trim($_POST["form_shop_name"]);             //ショップ名 shop name
    $show_page      = $_POST["form_show_page"];
    $post_flg       = true;                                 //POSTフラグ POST flag

    $sort_col       = $_POST["hdn_sort_col"];

    $offset = 0;

}elseif(count($_POST) > 0
    && $_POST["form_button"]["show_button"] != "表　示"){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;

    $output_type    = $_POST["hdn_output_type"];
    $client_cd1     = $_POST["hdn_client_cd1"];
    $client_cd2     = $_POST["hdn_client_cd2"];
    $btype          = $_POST["hdn_btype"];
    $rank           = $_POST["hdn_rank"];
    $client_name    = $_POST["hdn_client_name"];
    $area_id        = $_POST["hdn_area_id"];
    $state          = $_POST["hdn_state"];
    $state_s          = $_POST["hdn_state_s"];
    $tel            = $_POST["hdn_tel"];
    $shop_cd1       = $_POST["hdn_shop_cd1"];
    $shop_cd2       = $_POST["hdn_shop_cd2"];
    $shop_name      = $_POST["hdn_shop_name"];
    $show_page      = $_POST["hdn_show_page"];
    $post_flg       = true;

    $sort_col       = $_POST["hdn_sort_col"];


}else{
    $output_type    = '1';
    $state          = '1';
    $state_s        = '1';
    $show_page      = '1';
    $btype          = '0';
    $rank           = '0';
    $offset         = 0;

    $sort_col       = "sl_shop_cd";
}


/*****************************/
//検索条件セット set search condition
/*****************************/

$set_data["form_output_type"]       = stripslashes($output_type);
$set_data["form_client"]["cd1"]     = stripslashes($client_cd1);
$set_data["form_client"]["cd2"]     = stripslashes($client_cd2);
$set_data["form_client_name"]       = stripslashes($client_name);
$set_data["form_btype"]             = stripslashes($btype);
$set_data["form_rank"]              = stripslashes($rank);
$set_data["form_area_id"]           = stripslashes($area_id);
$set_data["form_state_type"]        = stripslashes($state);
$set_data["form_state_type_s"]      = stripslashes($state_s);
$set_data["form_tel"]               = stripslashes($tel);
$set_data["form_shop"]["cd1"]       = stripslashes($shop_cd1);
$set_data["form_shop"]["cd2"]       = stripslashes($shop_cd2);
$set_data["form_shop_name"]         = stripslashes($shop_name);
$set_data["form_show_page"]         = stripslashes($show_page);
$set_data["hdn_output_type"]        = stripslashes($output_type);
$set_data["hdn_client_cd1"]         = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]         = stripslashes($client_cd2);
$set_data["hdn_client_name"]        = stripslashes($client_name);
$set_data["hdn_btype"]              = stripslashes($btype);
$set_data["hdn_rank"]              = stripslashes($rank);
$set_data["hdn_shop_cd1"]           = stripslashes($shop_cd1);
$set_data["hdn_shop_cd2"]           = stripslashes($shop_cd2);
$set_data["hdn_shop_name"]          = stripslashes($shop_name);
$set_data["hdn_area_id"]            = stripslashes($area_id);
$set_data["hdn_state"]              = stripslashes($state);
$set_data["hdn_state_s"]              = stripslashes($state_s);
$set_data["hdn_tel"]                = stripslashes($tel);
$set_data["hdn_show_page"]          = stripslashes($show_page);
//$set_data["hdn_type"]               = stripslashes($type);      //type 種別

$form->setConstants($set_data);
if($post_flg == true){

    /****************************/
    //where_sql作成 create where_sql
    /****************************/
    if($post_flg == true){
        //ショップ名 shop name
        $where_sql .= ($shop_name != null) ? " AND (fc.client_name LIKE '%$shop_name%' OR fc.client_cname LIKE '%$shop_name%' OR fc.client_name2 LIKE '%$shop_name%')" : null;
        //得意先コード1 customer code 1
        $where_sql .= ($client_cd1 != null) ? " AND t_client.client_cd1 LIKE '$client_cd1%' " : null;
        //得意先コード2 customer code 2
        $where_sql .= ($client_cd2 != null) ? " AND t_client.client_cd2 LIKE '$client_cd2%' " : null;
        //得意先名・略称 customer name・abbreviation
        $where_sql .= ($client_name != null) ? " AND (t_client.client_name LIKE '%$client_name%' OR t_client.client_cname LIKE '%$client_name%' OR t_client.client_name2 LIKE '%$client_name%') " : null;

        //ショップコード１ shop code 1 
        $where_sql .= ($shop_cd1 != null)? " AND fc.client_cd1 LIKE '$shop_cd1%'":null;
        //ショップコード２ shop code 2
        $where_sql .= ($shop_cd2 != null)? " AND fc.client_cd2 LIKE '$shop_cd2%'":null;
        
/*        //ショップ名 shop name
        if($shop_name != null){
            $where_sql .= "AND (";
            $where_sql .= "     fc.client_name LIKE '$shop_name%'";
            $where_sql .= "     OR fc.client_name2 LIKE '$shop_name%'";
            $where_sql .= "     OR fc.client_cname LIKE '$shop_name%'";
            $where_sql .= ") ";
        }
*/


        //業種 industry
        $where_sql .= ($btype != 0) ? " AND t_sbtype.sbtype_id = $btype " : null;

        //FC・取引先区分 FC・transacting client classification
        $where_sql .= ($rank != 0) ? " AND fc.rank_cd = '$rank' " : null;

        //地区 district
        //$where_sql .= $area_id_sql      = ($area_id != 0) ? " AND t_area.area_id = $area_id " : null;
        $where_sql .= ($area_id != NULL) ? " AND t_area.area_name LIKE '%$area_id%' " : null;
        //TEL
        $where_sql .= ($tel != null) ? " AND t_client.tel LIKE '$tel%' " : null;
        //種別 type
//        $where_sql .= ($type != '3') ? " AND t_client.type = '$type' " : null;
    }
}

/****************************/
//表示データ作成 create display data
/****************************/

#2010-05-13 hashimoto-y
if($post_flg == true){


/****************************/
//全件数取得 acquire all items
/****************************/
$sql  = " SELECT";
$sql .= "     t_client.client_id,";                     // 0 customer ID 得意先ID
$sql .= "     t_client.client_cd1,";                    // 1 customer code 1 得意先コード１
$sql .= "     t_client.client_cd2,";                    // 2 customer code 2 得意先コード２
$sql .= "     t_client.client_name,";                   // 3 customer name 得意先名
$sql .= "     t_client.client_cname,";                  // 4 customer name (abbreviation) 得意先名（略称）
$sql .= "     t_area.area_name,";                       // 5 district name 地区名
$sql .= "     t_client.tel,";                           // 6 TEL
$sql .= "     t_client.state,";                         // 7 condition 状態
$sql .= "     t_client.type,";                          // 8 type 種別
$sql .= "     fc.client_name AS fc_name, ";             // 9 shop name ショップ名
$sql .= "     t_client_claim.client_name AS claim_name, ";// 10 invoicing client 請求先
$sql .= "     t_sbtype.sbtype_id, ";                    // 11 industry ID 業種ID
$sql .= "     fc.client_cd1, ";                         // 12 shop code1 ショップコード１
$sql .= "     fc.client_cd2, ";                         // 13 shop code2 ショップコード２
$sql .= "     t_client_claim.client_cd1,";              // 14 invoicing client 1 code 1請求先１コード１
$sql .= "     t_client_claim.client_cd2,";              // 15 invoicing client 1 code 2請求先１コード２
$sql .= "     t_client_claim2.client_cd1,";             // 16 invoicing vlient 2 code 1請求先２コード１
$sql .= "     t_client_claim2.client_cd2,";             // 17 invoicing client 2 code 2請求先２コード２
$sql .= "     t_client_claim2.client_name, ";           // 18 invoicing client 2 請求先２
$sql .= "     fc.state, ";                              // 19 condition (shop) 状態（ショップ）
$sql .= "     t_rank.rank_name ";                       // 20 FC・transacting client classification FC・取引先区分
if($output_type == 2){
$sql .= "   ,";
$sql .= "   t_lbtype.lbtype_name ||' '||t_sbtype.sbtype_name,";// 21  industry name 業種名
$sql .= "   t_inst.inst_name,";                         // 22  facility name 施設名
$sql .= "   t_bstruct.bstruct_name,";                   // 23  business type name 業態名
$sql .= "   t_client.client_read,";                     // 24  customer name 1 (phonetic in katakana) 得意先名１（フリガナ）
$sql .= "   t_client.client_name2,";                    // 25  customer name 2 得意先名２
$sql .= "   t_client.client_read2,";                    // 26  customer name 2 (phonetic in katakana) 得意先名２（フリガナ）
$sql .= "   t_client.client_cread,";                    // 27  abbreviation (phonetic in katakan) 略称（フリガナ）
$sql .= "   CASE t_client.compellation \n";
$sql .= "       WHEN '1' THEN '御中'\n";
$sql .= "       ELSE '様'\n";
$sql .= "   END \n";
$sql .= "   AS compellation, \n";                       // 28  honorific 敬称
$sql .= "   t_client.rep_name, \n";                     // 29  representative name 代表者氏名
$sql .= "   t_client.represe, \n";                      // 30  representative position 代表者役職
$sql .= "   t_client.post_no1, \n";                     // 31  postal code 1郵便番号１
$sql .= "   t_client.post_no2, \n";                     // 32  psotal code 2郵便番号２
$sql .= "   t_client.address1, \n";                     // 33  address 1 住所１
$sql .= "   t_client.address2, \n";                     // 34  address 2 住所２
$sql .= "   t_client.address3, \n";                     // 35  address 3 住所３
$sql .= "   t_client.address_read, \n";                 // 36  address (phonetic in katakana) 住所（フリガナ）
$sql .= "   t_client.fax, \n";                          // 37  FAX
$sql .= "   t_client.establish_day, \n";                // 38  establishment date 創業日
$sql .= "   t_client.email, \n";                        // 39  assigned staff email 担当者EMAIL
$sql .= "   t_client.company_name, \n";                 // 40  parent company name 親会社名
$sql .= "   t_client.company_tel, \n";                  // 41  parent company TEL 親会社TEL
$sql .= "   t_client.company_address, \n";              // 42  parent company address 親会社住所
$sql .= "   t_client.capital, \n";                      // 43  capital 資本金
$sql .= "   t_client.parent_establish_day, \n";         // 44  parent company establishment date 親会社創業日
$sql .= "   t_client.parent_rep_name, \n";              // 45  parent company representative name 親会社代表者氏名
$sql .= "   t_client.url, \n";                          // 46  URL
$sql .= "   t_client.charger_part1, \n";                // 47  assigned staff department 1担当部署１
$sql .= "   t_client.charger_part2, \n";                // 48  assigned staff department 2担当部署２
$sql .= "   t_client.charger_part3, \n";                // 49  assigned staff department 3担当部署３
$sql .= "   t_client.charger_represe1, \n";             // 50  assigned staff position 1担当役職１
$sql .= "   t_client.charger_represe2, \n";             // 51  assigned staff position 2担当役職２
$sql .= "   t_client.charger_represe3, \n";             // 52  assigned staff position 3担当役職３
$sql .= "   t_client.charger1, \n";                     // 53  assigned staff name 1担当者氏名１
$sql .= "   t_client.charger2, \n";                     // 54  assigned staff name 2担当者氏名２
$sql .= "   t_client.charger3, \n";                     // 55  assigned staff name 3担当者氏名３
$sql .= "   t_client.charger_note, \n";                 // 56  assigned staff remark 担当者備考
$sql .= "   t_client.trade_stime1, \n";                 // 57  operating hour (morning starting time) 営業時間（午前開始）
$sql .= "   t_client.trade_etime1, \n";                 // 58  operating hour (morning ending time) 営業時間（午前終了）
$sql .= "   t_client.trade_stime2, \n";                 // 59  operating hour (afternoon starting time) 営業時間（午後開始）
$sql .= "   t_client.trade_etime2, \n";                 // 60  operating hour (afternoon ending time) 営業時間（午後終了）
$sql .= "   t_client.holiday, \n";                      // 61  holiday 休日
$sql .= "   t_client.holiday, \n";                      // 62  holiday 休日
$sql .= "   t_client.credit_limit, \n";                 // 63  credit limit 与信限度
$sql .= "   t_client.col_terms, \n";                    // 64  collection condition回収条件
$sql .= "   t_trade.trade_name, \n";                    // 65  transaction classification 取引区分
$sql .= "   CASE t_client.close_day \n";
$sql .= "       WHEN '29' THEN '月末' \n";
$sql .= "       ELSE t_client.close_day || '日'\n";
$sql .= "   END AS close_day, \n";                      // 66  closing date 締日
$sql .= "   CASE t_client.pay_m \n";
$sql .= "       WHEN '0' THEN '当月' \n";
$sql .= "       WHEN '1' THEN '翌月' \n";
$sql .= "       ELSE t_client.pay_m || 'ヵ月後' \n";
$sql .= "   END AS pay_m, \n";                          // 67  collection date (month) 集金日（月）
$sql .= "   CASE t_client.pay_d \n";
$sql .= "       WHEN '29' THEN '月末' \n";
$sql .= "       ELSE t_client.pay_d || '日' \n";
$sql .= "   END AS pay_d, \n";                          // 68  collection date (day) 集金日（日）
$sql .= "   CASE t_client.pay_way \n";
$sql .= "       WHEN '1' THEN '自動引落' \n";
$sql .= "       WHEN '2' THEN '振込' \n";
$sql .= "       WHEN '3' THEN '訪問集金' \n";
$sql .= "       WHEN '4' THEN '手形' \n";
$sql .= "       WHEN '5' THEN 'その他' \n";
$sql .= "   END AS pay_way, \n";                        // 69  collection money method 集金方法
$sql .= "   CASE \n";
$sql .= "       WHEN t_client.account_id IS NOT NULL \n";
$sql .= "       THEN t_bank.bank_name || '　' || t_b_bank.b_bank_name || '　' ||     
                CASE t_account.deposit_kind  WHEN '1' THEN '普通 '     
                    WHEN '2' THEN '当座 ' END || t_account.account_no";
$sql .= "       ELSE '' \n";
$sql .= "   END \n";
$sql .= "   AS pay_bank, \n";                           // 70  transfer money bank account 振込銀行口座
$sql .= "   t_client.pay_name, \n";                     // 71  client name 1 whom money will be transferred 振込名義１
$sql .= "   t_client.account_name, \n";                 // 72  client name 2 whom money will be transferred 振込名義２
$sql .= "   CASE t_client.bank_div ";
$sql .= "       WHEN '1' THEN 'お客様負担' \n";
$sql .= "       WHEN '2' THEN '自社負担' \n";
$sql .= "   END AS bank_div, \n";                       // 73  bank transaction fee shoulder classification 銀行手数料負担区分
$sql .= "   t_client.cont_sday, \n";                    // 74  contracted date 契約年月日
$sql .= "   t_client.cont_rday, \n";                    // 75  contract updating date 契約更新日
$sql .= "   t_client.cont_eday, \n";                    // 76  contract ending date 契約終了日
$sql .= "   t_client.cont_peri, \n";                    // 77  contract period 契約期間
$sql .= "   CASE t_client.slip_out \n";
$sql .= "       WHEN '1' THEN '有' \n";
$sql .= "       WHEN '2' THEN '指定' \n";
$sql .= "       WHEN '3' THEN '無' \n";
$sql .= "   END AS slip_out, \n";                       // 78  issue slip 伝票発行
$sql .= "   t_slip_sheet.s_pattern_name, \n";           // 79  sales slip issue 売上伝票発行元
$sql .= "   CASE t_client.deliver_effect \n";
$sql .= "       WHEN '1' THEN 'コメント無効' \n";
$sql .= "       WHEN '2' THEN '個別コメント有効' \n";
$sql .= "       ELSE '全体コメント有効' \n";
$sql .= "   END AS deliver_effect, \n";                 // 80  sales slip comment effect 売上伝票コメント効果
$sql .= "   CASE t_client.claim_out \n";
$sql .= "       WHEN '1' THEN '明細請求書' \n";
$sql .= "       WHEN '2' THEN '合計請求書' \n";
$sql .= "       WHEN '3' THEN '出力しない' \n";
$sql .= "       ELSE '指定' \n";
$sql .= "   END AS claim_out, \n";                      // 81  issue invoice 請求書発行
$sql .= "   CASE t_client.claim_send \n";
$sql .= "       WHEN '1' THEN '郵送' \n";
$sql .= "       WHEN '2' THEN 'メール' \n";
$sql .= "       WHEN '4' THEN 'WEB' \n";
$sql .= "       ELSE '郵送・メール' \n";
$sql .= "   END AS claim_send, \n";                     // 82  send invoice 請求書送付
$sql .= "   t_claim_sheet.c_pattern_name, \n";          // 83  origin of the issued invoice 請求書発行元
$sql .= "   t_client.claim_note, \n";                   // 84  invoice remarks 請求書備考
$sql .= "   CASE t_client.coax \n";
$sql .= "       WHEN '1' THEN '切捨' \n";
$sql .= "       WHEN '2' THEN '四捨五入' \n";
$sql .= "       ELSE '切上' \n";
$sql .= "   END AS claim_note, \n";                     // 85  amount: round off decimals金額丸め区分
$sql .= "   CASE t_client.tax_div \n";
$sql .= "       WHEN '2' THEN '伝票単位' \n";
$sql .= "       ELSE '締日単位' \n";
$sql .= "   END AS tax_div, \n";                        // 86  consumption tax: taxation unit 消費税：課税単位
$sql .= "   CASE t_client.tax_franct \n";
$sql .= "       WHEN '1' THEN '切捨' \n";
$sql .= "       WHEN '2' THEN '四捨五入' \n";
$sql .= "       ELSE '切上' \n";
$sql .= "   END AS tax_franct, \n";                     // 87  consumption tax: fraction classification 消費税：端数区分
$sql .= "   CASE t_client.c_tax_div \n";
$sql .= "       WHEN '1' THEN '外税' \n";
$sql .= "       ELSE '内税' \n";
$sql .= "   END AS tax_div, \n";                        // 88  consumption tax: tax classification 消費税：課税区分
$sql .= "   t_client.note, \n";                         // 89  equipment information・others 設備情報等・その他
$sql .= "   t_branch.branch_name, \n";                  // 90  assigned branch 担当支店
$sql .= "   t_staff1.staff_name, \n";                   // 91  currenc contract assigned staff 現契約担当
$sql .= "   t_staff2.staff_name, \n";                   // 92  employee name 初期契約社員
$sql .= "   t_client.round_day, \n";                    // 93  patrol start date 巡回開始日
$sql .= "   t_client.deal_history, \n";                 // 94  transaction history 取引履歴
$sql .= "   t_client.importance, \n";                   // 95  important matter 重要事項
$sql .= "   t_client.parents_flg,\n";                   // 96 parent-child flag 親子フラグ
$sql .= "   t_client_gr.client_gr_name,";               // 97 group name グループ名
$sql .= "   t_client.deliver_note, ";                   // 98 sales slip comment 売上伝票コメント
$sql .= "   t_intro_ac.client_cd1,  \n";                // 99 bank account inquiry code 1 照会口座コード1
$sql .= "   t_intro_ac.client_name, \n";                // 100 introduced bank account name 紹介口座名
$sql .= "   t_client.intro_ac_name, \n";                // 101 bank account name for payment 振込先口座名
$sql .= "   t_client.intro_bank, \n";                   // 102 bank/branch 銀行/支店名
$sql .= "   t_client.intro_ac_num,\n";                  // 103 account number 口座番号
$sql .= "   t_intro_ac.client_cd2,";                    // 104 bank account inquiry code 2 照会口座コード２
$sql .= "   t_intro_ac.client_div, ";                    // 105 transaction classification of bank account inquiry 照会口座の取引区分

$sql .= "   CASE t_claim.month1_flg \n";         // 106 create january invoice1月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month2_flg \n";         // 107 create Feb invoice2月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month3_flg \n";         // 108 create March invoice3月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month4_flg \n";         // 109 create april invoice4月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month5_flg \n";         // 110 create May invoice5月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month6_flg \n";         // 111 create june invoice6月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month7_flg \n";         // 112 create july  invoice7月請求書作成    
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month8_flg \n";         // 113 create august invoice8月請求書作成    
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month9_flg \n";         // 114 create sept invoice9月請求書作成    
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month10_flg \n";        // 115 create oct invoice10月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month11_flg \n";        // 116 create Nov invoice11月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END , ";
$sql .= "   CASE t_claim.month12_flg \n";        // 117 create Dec invoice12月請求書作成
$sql .= "       WHEN 't' THEN '○' \n";
$sql .= "       WHEN 'f' THEN '×' \n";
$sql .= "   END  ";

}


$sql .= " FROM";
$sql .= "   t_client ";
$sql .= "   INNER JOIN t_claim ";
$sql .= "       ON t_client.client_id = t_claim.client_id AND t_claim.claim_div='1'";
$sql .= "   INNER JOIN t_client AS t_client_claim ";
$sql .= "       ON t_claim.claim_id = t_client_claim.client_id ";
$sql .= "   INNER JOIN t_sbtype ";
$sql .= "       ON t_client.sbtype_id = t_sbtype.sbtype_id ";
$sql .= "   INNER JOIN t_area ";
$sql .= "       ON t_client.area_id = t_area.area_id  ";
$sql .= "   INNER JOIN t_client AS fc";
$sql .= "       ON t_client.shop_id = fc.client_id AND (fc.client_div = '0' OR fc.client_div = '3')";
$sql .= "   INNER JOIN t_rank ";
$sql .= "       ON t_rank.rank_cd = fc.rank_cd ";
$sql .= "   LEFT JOIN t_claim AS t_claim2 ";
$sql .= "       ON t_client.client_id = t_claim2.client_id AND t_claim2.claim_div='2' ";
$sql .= "   LEFT JOIN t_client AS t_client_claim2 ";
$sql .= "       ON t_claim2.claim_id = t_client_claim2.client_id ";
if($output_type==2){
$sql .= "   LEFT JOIN t_inst ";
$sql .= "       ON t_inst.inst_id = t_client.inst_id";
$sql .= "   LEFT JOIN t_bstruct \n";
$sql .= "       ON t_bstruct.bstruct_id = t_client.b_struct \n";
$sql .= "   LEFT JOIN t_trade \n";
$sql .= "       ON t_trade.trade_id = t_client.trade_id \n";
$sql .= "   LEFT JOIN t_account \n";
$sql .= "       ON t_account.account_id = t_client.account_id \n";
$sql .= "   LEFT JOIN t_b_bank \n";
$sql .= "       ON t_b_bank.b_bank_id = t_account.b_bank_id \n";
$sql .= "   LEFT JOIN t_bank \n";
$sql .= "       ON t_bank.bank_id = t_b_bank.bank_id \n";
$sql .= "   LEFT JOIN t_slip_sheet \n";
$sql .= "       ON t_client.s_pattern_id = t_slip_sheet.s_pattern_id \n";
$sql .= "   LEFT JOIN t_claim_sheet \n";
$sql .= "       ON t_client.c_pattern_id = t_claim_sheet.c_pattern_id \n";
$sql .= "   LEFT JOIN t_branch \n";
$sql .= "       ON t_client.charge_branch_id = t_branch.branch_id \n";
$sql .= "   LEFT JOIN t_staff AS t_staff1 \n";
$sql .= "       ON t_staff1.staff_id = t_client.c_staff_id1 \n";
$sql .= "   LEFT JOIN t_staff AS t_staff2 \n";
$sql .= "       ON t_staff2.staff_id = t_client.c_staff_id2 \n";
$sql .= "   LEFT JOIN t_client_gr ";
$sql .= "       ON t_client_gr.client_gr_id = t_client.client_gr_id \n";
$sql .= "   INNER JOIN t_client_info \n";
$sql .= "   ON t_client.client_id = t_client_info.client_id \n";
$sql .= "   LEFT JOIN t_client AS t_intro_ac \n";
$sql .= "   ON t_client_info.intro_account_id = t_intro_ac.client_id \n";
$sql .= "   LEFT JOIN t_lbtype \n";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id \n";
}
$sql .= " WHERE ";
$sql .= "     t_client.client_div = '1' ";

//condition 状態
$sql .= ($state != null && $state != 4) ? " AND t_client.state = $state " : null;
$sql .= ($state_s != null && $state_s != 4) ? " AND fc.state = $state_s " : null;

//表示順 display order
// ショップ名で昇順時 shop name ascending order
if ($sort_col == "sl_shop_name"){
    $order_sql = " ORDER BY fc.client_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// 得意先コードで昇順時 client code ascending order
}elseif ($sort_col == "sl_client_cd"){
    $order_sql = " ORDER BY t_client.client_cd1, t_client.client_cd2 ASC ";
// 得意先名で昇順時 customer name ascending order
}elseif ($sort_col == "sl_client_name"){
    $order_sql = " ORDER BY t_client.client_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// 地区で昇順時 district ascending order
}elseif ($sort_col == "sl_area"){
    $order_sql = " ORDER BY t_area.area_name, t_client.client_cd1, t_client.client_cd2 ASC ";
// ショップコード shop code 
}elseif ($sort_col == "sl_shop_cd"){
    $order_sql = " ORDER BY fc.client_cd1, fc.client_cd2,t_client.client_cd1,t_client.client_cd2 ASC ";
// FC・取引先区分 FC・transacting client classification
}elseif ($sort_col == "sl_rank"){
    $order_sql = " ORDER BY fc.rank_cd, fc.client_cd1, fc.client_cd2 ,t_client.client_cd1, t_client.client_cd2 ASC ";
// デフォルトは得意先コードで昇順 by default sort with customer code in ascending order
}else{
    $order_sql = "ORDER BY t_client.client_cd1,t_client.client_cd2 ASC ";
}

//画面選択時 when a scren is selected
if($output_type == 1 || $output_type==""){

    $limit = ($show_page != '2') ? " LIMIT 100 OFFSET $offset " : null;

    //該当件数 matched items
    $sql .= $where_sql.$state_sql.$order_sql;
    $total_count_sql = $sql.";";
    $result = Db_Query($conn, $total_count_sql);
    $t_count = pg_num_rows($result);

    //表示件数 displaying items
    switch($show_page){
        case "1":
            $range = "100";
            break;
        case "2":
            $range = $t_count;
            break;
    }




    $sql = $sql.$limit.";";
    $count_res = Db_Query($conn, $sql);
    $match_count = pg_num_rows($count_res);
        
    $page_data = Get_Data($count_res, $output_type);
    for($i = 0; $i< $match_count; $i++){
        for($j = 0; $j < $match_count; $j++){
            if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
                $page_data[$j][0] = null;
            }
        }
    }

    for($i = 0; $i < $t_count; $i++){
        if($page_data[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{  
            $tr[$i] = ($tr[$i-1] == "Result1") ? "Result2" : "Result1";
        }
    }
}else if($output_type == 2){

    //該当件数 matched items
    $sql    .= $where_sql.$state_sql.$order_sql;
    $sql            = $sql.";";
    $count_res      = Db_Query($conn, $sql);
    $match_count    = pg_num_rows($count_res);    
    $page_data      = Get_Data($count_res, $output_type);
    //CSV作成 creat csv
    for($i = 0; $i < $match_count; $i++){
//print "<br>$i".$page_data[$i][96];
        $csv_page_data[$i][0] = ($page_data[$i][19] == "1") ? "取引中" : "解約・休止中"; //ショップ 状態 shop status
        $csv_page_data[$i][1] = $page_data[$i][12]."-".$page_data[$i][13];  //ショップコード shop code
        $csv_page_data[$i][2] = $page_data[$i][9];  //ショップ名 shop name
        $csv_page_data[$i][3] = ($page_data[$i][7] == "1") ? "取引中" : "解約・休止中"; //得意先 状態 customer status
        $csv_page_data[$i][4] = $page_data[$i][97]; //グループ名 group name
        $csv_page_data[$i][5] = (($page_data[$i][96] == 't')? "親":(($page_data[$i][96] == 'f')?"子":"独立"));    //親子区分 parent-child classification
        $csv_page_data[$i][6] = $page_data[$i][5];      //地区 district
        $csv_page_data[$i][7] = $page_data[$i][21];     //業種 industry
        $csv_page_data[$i][8] = $page_data[$i][22];     //施設 facility
        $csv_page_data[$i][9] = $page_data[$i][23];     //業態 business type
        $csv_page_data[$i][10] = $page_data[$i][1]."-".$page_data[$i][2];   //得意先コード customer code
        $csv_page_data[$i][11] = $page_data[$i][3];     //得意先名１ customer name 1
        $csv_page_data[$i][12] = $page_data[$i][25];    //得意先名２ customer name 2
        $csv_page_data[$i][13] = $page_data[$i][24];    //得意先名１（フリガナ） customer name 1 (phonetic in katakana)
        $csv_page_data[$i][14] = $page_data[$i][26];    //得意先名２（フリガナ） customer name 2 (phonetic in katakana)
        $csv_page_data[$i][15] = $page_data[$i][4];     //略称 abbreviation
        $csv_page_data[$i][16] = $page_data[$i][27];    //略称（フリガナ）abbreviation (phonetic in katakana)
        $csv_page_data[$i][17] = $page_data[$i][28];    //敬称 honorific
        $csv_page_data[$i][18] = $page_data[$i][29];    //代表者氏名 representative name
        $csv_page_data[$i][19] = $page_data[$i][30];    //代表者役職 representative position
        $csv_page_data[$i][20] = $page_data[$i][31]."-".$page_data[$i][32]; //郵便番号１ postal code 1
        $csv_page_data[$i][21] = $page_data[$i][33];    //住所１ address 1
        $csv_page_data[$i][22] = $page_data[$i][34];    //住所２ address 2
        $csv_page_data[$i][23] = $page_data[$i][35];    //住所３ address 3
        $csv_page_data[$i][24] = $page_data[$i][36];    //住所（フリガナ）address (phonetic in katakana)
        $csv_page_data[$i][25] = $page_data[$i][6];     //TEL
        $csv_page_data[$i][26] = $page_data[$i][37];    //FAX
        $csv_page_data[$i][27] = $page_data[$i][38];    //創業日 establishment date
        $csv_page_data[$i][28] = $page_data[$i][39];    //担当者EMAIL assigned staff email
        $csv_page_data[$i][29] = $page_data[$i][40];    //親会社名  parent company name
        $csv_page_data[$i][30] = $page_data[$i][41];    //親会社TEL parent company TEL
        $csv_page_data[$i][31] = $page_data[$i][42];    //親会社住所 parent company address
        $csv_page_data[$i][32] = $page_data[$i][43];    //資本金 capital
        $csv_page_data[$i][33] = $page_data[$i][44];    //親会社創業日 parent company establishment date
        $csv_page_data[$i][34] = $page_data[$i][45];    //親会社代表者氏名 parent company representative name
        $csv_page_data[$i][35] = $page_data[$i][46];    //URL
        $csv_page_data[$i][36] = $page_data[$i][47];    //担当１部署 assigned staff 1 department
        $csv_page_data[$i][37] = $page_data[$i][50];    //担当１役職 assigned staff 1 position
        $csv_page_data[$i][38] = $page_data[$i][53];    //担当１氏名 assigned staff 1 name
        $csv_page_data[$i][39] = $page_data[$i][48];    //担当２部署 assigned staff 2 department
        $csv_page_data[$i][40] = $page_data[$i][51];    //担当２役職 assigned staff 2 position 
        $csv_page_data[$i][41] = $page_data[$i][54];    //担当２氏名 assigned staff 2 name
        $csv_page_data[$i][42] = $page_data[$i][49];    //担当３部署 assigned staff 3 department
        $csv_page_data[$i][43] = $page_data[$i][52];    //担当３役職 assigned staff 3 position
        $csv_page_data[$i][44] = $page_data[$i][55];    //担当３氏名assigned staff 3 name
        $csv_page_data[$i][45] = $page_data[$i][56];    //担当者備考 assigned staff remark
        $csv_page_data[$i][46] = ($page_data[$i][57]!=null || $page_data[$i][58]!=null)?$page_data[$i][57]."〜".$page_data[$i][58]:"";    //operating hour (morning)営業時間（午前）
        $csv_page_data[$i][47] =  ($page_data[$i][59]!=null || $page_data[$i][60]!=null)?$page_data[$i][59]."〜".$page_data[$i][60]:"";    //operating hour (afternoon)営業時間（午後）
        $csv_page_data[$i][48] = $page_data[$i][61];    //休日 holiday
        $csv_page_data[$i][49] = $page_data[$i][14]."-".$page_data[$i][15]; //invoicing client 1 code請求先１コード
        $csv_page_data[$i][50] = $page_data[$i][10];    //請求先１ invoicing client 1
        $csv_page_data[$i][51] = ($page_data[$i][16]!=null)?$page_data[$i][16]."-".$page_data[$i][17]:null; //請求先２コード
        $csv_page_data[$i][52] = $page_data[$i][18];    //請求先２ invoicing client 2
        $csv_page_data[$i][53] = $page_data[$i][63];    //与信限度 credit limit
        $csv_page_data[$i][54] = $page_data[$i][64];    //回収条件 collection condition
        $csv_page_data[$i][55] = $page_data[$i][65];    //取引区分 transaction classification
        $csv_page_data[$i][56] = $page_data[$i][66];    //締日 closing date
        $csv_page_data[$i][57] = $page_data[$i][67]."の".$page_data[$i][68];    //collection date 集金日
        $csv_page_data[$i][58] = $page_data[$i][69];    //集金方法 collection method
        $csv_page_data[$i][59] = $page_data[$i][70];    //振込銀行口座 bank account for payment
        $csv_page_data[$i][60] = $page_data[$i][71];    //振込名義１ payment client name 1
        $csv_page_data[$i][61] = $page_data[$i][72];    //振込名義２ payment client name 2
        $csv_page_data[$i][62] = $page_data[$i][73];    //銀行手数料負担区分 bank transaction fee shoulder classification
        $csv_page_data[$i][63] = $page_data[$i][74];    //契約年月日 contracted date
        $csv_page_data[$i][64] = $page_data[$i][75];    //契約更新日 contract update date
        $csv_page_data[$i][65] = $page_data[$i][77];    //契約期間 contract period
        $csv_page_data[$i][66] = $page_data[$i][76];    //契約終了日 contract ending date
        $csv_page_data[$i][67] = $page_data[$i][78];    //伝票発行 issue slip 
        $csv_page_data[$i][68] = $page_data[$i][79];    //売上伝票発行元 origin of issued sales slip 
        $csv_page_data[$i][69] = $page_data[$i][80];    //売上伝票コメント効果 sales slip comment effect
        $csv_page_data[$i][70] = $page_data[$i][98];    //売上伝票コメント sales slip comment
        $csv_page_data[$i][71] = $page_data[$i][81];    //請求書発行 issue invoice
        $csv_page_data[$i][72] = $page_data[$i][82];    //請求書送付 send invoice
        $csv_page_data[$i][73] = $page_data[$i][83];    //請求書発行元 origin of issued invoice
        $csv_page_data[$i][74] = $page_data[$i][84];    //請求書備考 invoice remark
        $csv_page_data[$i][75] = $page_data[$i][85];    //金額丸め区分 amount decimal round off classification
        $csv_page_data[$i][76] = $page_data[$i][86];    //消費税：課税単位 consumption tax: taxation unit
        $csv_page_data[$i][77] = $page_data[$i][87];    //消費税：端数区分 consumption tax: fraction classification
        $csv_page_data[$i][78] = $page_data[$i][88];    //消費税：課税区分 consumption tax: tax classification
        $csv_page_data[$i][79] = $page_data[$i][89];    //設備情報等・その他 equipment information・others
        if($page_data[$i][105] == "3"){
            $page_data[$i][99] = $page_data[$i][99]."-".$page_data[$i][104];
        }
        $csv_page_data[$i][80] = $page_data[$i][99];    //ご紹介口座コード introduced bank account code
        $csv_page_data[$i][81] = $page_data[$i][100];   //ご紹介口座名 introduced bank account name
        $csv_page_data[$i][82] = $page_data[$i][101];   //お振込先口座名  bank account name for money transfer
        $csv_page_data[$i][83] = $page_data[$i][102];   //銀行/支店名 bank/branch name
        $csv_page_data[$i][84] = $page_data[$i][103];   //口座番号 bank account number 
        $csv_page_data[$i][85] = $page_data[$i][90];    //担当支店 assigned branch
        $csv_page_data[$i][86] = $page_data[$i][91];    //現契約担当 assigned staff for this contract 
        $csv_page_data[$i][87] = $page_data[$i][92];    //初期契約社員 employee name
        $csv_page_data[$i][88] = $page_data[$i][93];    //巡回開始日 patrol start date
        $csv_page_data[$i][89] = $page_data[$i][94];    //取引履歴 trade history
        $csv_page_data[$i][90] = $page_data[$i][95];    //重要事項 important matter

        //請求書作成月 invoice creation month
        $csv_page_data[$i][91] = $page_data[$i][106];
        $csv_page_data[$i][92] = $page_data[$i][107];
        $csv_page_data[$i][93] = $page_data[$i][108];
        $csv_page_data[$i][94] = $page_data[$i][109];
        $csv_page_data[$i][95] = $page_data[$i][110];
        $csv_page_data[$i][96] = $page_data[$i][111];
        $csv_page_data[$i][97] = $page_data[$i][112];
        $csv_page_data[$i][98] = $page_data[$i][113];
        $csv_page_data[$i][99] = $page_data[$i][114];
        $csv_page_data[$i][100] = $page_data[$i][115];
        $csv_page_data[$i][101] = $page_data[$i][116];
        $csv_page_data[$i][102] = $page_data[$i][117];
        


}
    $csv_file_name = "得意先マスタ".date("Ymd").".csv";
    $csv_header = array(
        "ショップ 状態",
        "ショップコード",
        "ショップ名",
        "得意先 状態",
        "グループ名",
        "親子区分",
        "地区",
        "業種",
        "施設",
        "業態",
        "得意先コード",
        "得意先名１",
        "得意先名２",
        "得意先名１（フリガナ）",
        "得意先名２（フリガナ）",
        "略称",
        "略称（フリガナ）",
        "敬称",
        "代表者氏名",
        "代表者役職",
        "郵便番号",
        "住所１",
        "住所２",
        "住所３",
        "住所２（フリガナ）",
        "TEL",
        "FAX",
        "創業日",
        "担当者Email",
        "親会社名",
        "親会社TEL",
        "親会社住所",
        "資本金",
        "親会社創業日",
        "親会社代表者氏名",
        "URL",
        "担当１部署",
        "担当１役職",
        "担当１氏名",
        "担当２部署",
        "担当２役職",
        "担当２氏名",
        "担当３部署",
        "担当３役職",
        "担当３氏名",
        "担当者備考",
        "営業時間（午前）",
        "営業時間（午後）",
        "休日",
        "請求先１（コード）",
        "請求先１（名前）",
        "請求先２（コード）",
        "請求先２（名前）",
        "与信限度",
        "回収条件",
        "取引区分",
        "締日",
        "集金日",
        "集金方法",
        "振込銀行口座",
        "振込名義１",
        "振込名義２",
        "銀行手数料負担区分",
        "契約年月日",
        "契約更新日",
        "契約期間",
        "契約終了日",
        "伝票発行",
        "売上伝票発行元",
        "売上伝票コメント効果",
        "売上伝票コメント",
        "請求書発行",
        "請求書送付",
        "請求書発行元",
        "請求書備考",
        "金額丸め区分",
        "消費税：課税単位",
        "消費税：端数区分",
        "消費税：課税区分",
        "設備情報等・その他",
        "ご紹介口座コード",
        "ご紹介口座名",
        "お振込先口座名",
        "銀行/支店名",
        "口座番号",
        "担当支店",
        "現契約担当",
        "初期契約社員",
        "巡回開始日",
        "取引履歴",
        "重要事項",
         "1月請求",
         "2月請求",
         "3月請求",
         "4月請求",
         "5月請求",
         "6月請求",
         "7月請求",
         "8月請求",
         "9月請求",
         "10月請求",
         "11月請求",
         "12月請求",
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


//print_array($_POST);


/****************************/
//状態を置換する replace the status/condition
/****************************/ 
if($state == "1"){
    $state_type = "取引中";
}else
if ($state == "2" || $state == "3"){
    $state_type = "解約・休止中";
}else
if ($state == "4"){
    $state_type = "全て";
}



#2010-05-13 hashimoto-y
$display_flg = true;
}


/****************************/
//HTMLヘッダ HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "(全".$total_count."件)";
//$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//ページ作成 create page
/****************************/
//表示範囲指定 specify display range
//$range = "100";

$html_page = Html_Page($t_count,$page_count,1,$range);
$html_page2 = Html_Page($t_count,$page_count,2,$range);

// Render関連の設定 render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variable
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variable
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'match_count'   => "$match_count",
    'state_type'    => "$state_type",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
$smarty->assign('tr',$tr);
//テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
