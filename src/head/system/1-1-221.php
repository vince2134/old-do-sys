<?php
/*********************
変更履歴
    (2006/05/23)URLを登録するように変更
    (2006/05/26)マークを登録するように変更
    (2006/07/31)課税区分を課税・非課税に変更
    (2006/08/01)略記を７文字に変更
    (2006/08/02)RtoR登録機能を追加
    (2006/08/21)変更後の遷移先を新規商品マスタ登録画面へ変更
    (2006/10/23)商品アルバムのURLをエスケープするように変更
    (2006/10/23)GETの型チェックを追加
    (2006/11/30)シリアル管理入力欄追加
*********************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-01-22      仕様変更　　watanabe-k　ボタンの色を変更
 *  2007-03-19              　　watanabe-k　変更後の遷移先を単価設定に修正
 *  2007-04-26      その他      kajioka-h   本部仕入先マスタがFCマスタに併合されたのに伴い、仕入先をFCに変更
 *  2007-06-25      その他      watanabe-k  商品マスタの変更を契約マスタ、予定データに反映する処理を追加
 *  2009-09-21      	        watanabe-k  入数のmaxlengthを5に変更
 *  2009-10-06                  hashimoto-y 在庫管理フラグを商品マスタからショップ別商品情報テーブルに変更
 *   2016/01/20                amano  Dialogue関数でボタン名が送られない IE11 バグ対応    
 */

$page_title = "商品マスタ";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数


//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DBに接続    
$conn = Db_connect();    

// 権限チェック
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];

$get_goods_id = $_GET["goods_id"];                          //GETした商品ID

/****************************/
//初期値設定
/****************************/
$defa_data["form_state"] = 1;
$defa_data["form_rental"] = 'f';
$defa_data["form_serial"] = 'f';
$defa_data["form_accept"] = 2;
$form->setDefaults($defa_data);

//GETがある場合
if($_GET["goods_id"] != null){
    $get_flg = true;                                            //GETフラグ

    Get_Id_Check3($_GET["goods_id"]);

    $sql  = " SELECT";
    $sql .= "   t_goods.goods_cd,";                             //商品コード
    $sql .= "   t_goods.goods_name,";                           //商品名
    $sql .= "   t_goods.goods_cname,";                          //略称
    $sql .= "   t_goods.attri_div,";                            //属性区分
    $sql .= "   t_g_goods.g_goods_id,";                         //Ｍ区分ID（Ｍ区分）
    $sql .= "   t_product.product_id,";                         //管理区分ID（管理区分）
    $sql .= "   t_goods.unit,";                                 //単位
    $sql .= "   t_goods.in_num,";                               //入数
    $sql .= "   client1.client_cd1,";                           //仕入先1コード1
    $sql .= "   client1.client_cname,";                         //仕入先名
    $sql .= "   client2.client_cd1,";                           //仕入先2コード1
    $sql .= "   client2.client_cname,";                         //仕入先名2
    $sql .= "   client3.client_cd1,";                           //仕入先3コード1
    $sql .= "   client3.client_cname,";                         //仕入先名3
    $sql .= "   t_goods.sale_manage,";                          //販売管理
    #2009-10-06 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";                         //在庫管理
    $sql .= "   t_goods_info.stock_manage,";                         //在庫管理
    $sql .= "   t_goods.stock_only,";                           //在庫限り品
    $sql .= "   t_goods_info.order_point,";                     //発注点
    $sql .= "   t_goods_info.order_unit, ";                     //発注単位数
    $sql .= "   t_goods_info.lead,";                            //リードタイム（日）
    $sql .= "   t_goods.name_change,";                          //品名変更
    $sql .= "   t_goods.tax_div,";                              //課税区分
    $sql .= "   t_goods.royalty,";                              //ロイヤリティ（有無）
    $sql .= "   t_goods_info.note, ";                           //備考
    $sql .= "   t_goods.state, ";                               //状態
    $sql .= "   t_goods.url,";
    $sql .= "   t_goods.mark_div,";
	$sql .= "   t_g_product.g_product_id,";                     //商品分類ID
    $sql .= "   t_goods.accept_flg,";                           //承認フラグ
    $sql .= "   t_goods.no_change_flg,";                        //変更不可フラグ
    $sql .= "   t_goods.rental_flg,";                           //RtoR
	$sql .= "   t_goods.serial_flg,";                           //シリアル管理
    $sql .= "   client1.client_cd2,";                           //仕入先1コード2 32
    $sql .= "   client2.client_cd2,";                           //仕入先2コード2 33
    $sql .= "   client3.client_cd2 ";                           //仕入先3コード2 34
    $sql .= " FROM";
    $sql .= "   t_goods,";                                      //商品マスタ
    $sql .= "   t_g_goods,";                                    //Ｍ区分マスタ
    $sql .= "   t_product,";                                    //管理区分マスタ
	$sql .= "   t_g_product,";                                  //商品分類マスタ
    $sql .= "   t_goods_info";                                  //ショップ別商品情報テーブル
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client1 ";                          //得意先マスタ
    $sql .= " ON t_goods_info.supplier_id = client1.client_id";
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client2 ";                          //得意先マスタ
    $sql .= " ON t_goods_info.supplier_id2 = client2.client_id";
    
    $sql .= " LEFT JOIN";
    $sql .= "   t_client AS client3 ";                          //得意先マスタ
    $sql .= " ON t_goods_info.supplier_id3 = client3.client_id";
    
    $sql .= " WHERE";
    $sql .= "   t_goods.goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.public_flg = 't'";
    $sql .= "   AND";
    $sql .= "   t_goods.g_goods_id = t_g_goods.g_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.product_id = t_product.product_id";
	$sql .= "   AND";
    $sql .= "   t_goods.g_product_id = t_g_product.g_product_id";
    $sql .= "   AND";
    $sql .= "   t_goods.goods_id = t_goods_info.goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods_info.shop_id = $shop_id";
    $sql .= " ;";

    //クエリ発行
    $result = Db_Query($conn, $sql) or die("クエリエラー");
    Get_Id_Check($result);

    //データ取得
    $get_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

    //初期値データ
    $def_data["form_goods_cd"]          = $get_data[0];         //商品コード
    $def_data["form_goods_name"]        = $get_data[1];         //商品名
    $def_data["form_goods_cname"]       = $get_data[2];         //略称
    $def_data["form_attri_div"]         = $get_data[3];         //属性区分
    $def_data["form_g_goods"]           = $get_data[4];         //Ｍ区分
    $def_data["form_product"]           = $get_data[5];         //管理区分
    $def_data["form_unit"]              = $get_data[6];         //単位
    $def_data["form_in_num"]            = $get_data[7];         //入数
    $def_data["form_supplier"]["cd1"]   = $get_data[8];         //仕入先1コード1
    $def_data["form_supplier"]["cd2"]   = $get_data[32];        //仕入先1コード2
    $def_data["form_supplier"]["name"]  = $get_data[9];         //仕入先名
    $def_data["form_supplier2"]["cd1"]  = $get_data[10];        //仕入先2コード1
    $def_data["form_supplier2"]["cd2"]  = $get_data[33];        //仕入先2コード2
    $def_data["form_supplier2"]["name"] = $get_data[11];        //仕入先名2
    $def_data["form_supplier3"]["cd1"]  = $get_data[12];        //仕入先3コード1
    $def_data["form_supplier3"]["cd2"]  = $get_data[34];        //仕入先3コード2
    $def_data["form_supplier3"]["name"] = $get_data[13];        //仕入先名3
    $def_data["form_sale_manage"]       = $get_data[14];        //販売管理
    $def_data["form_stock_manage"]      = $get_data[15];        //在庫管理
    $def_data["form_stock_only"]        = $get_data[16];        //在庫限り品
    $def_data["form_order_point"]       = $get_data[17];        //発注点
    $def_data["form_order_unit"]        = $get_data[18];        //発注単位数
    $def_data["form_lead"]              = $get_data[19];        //リードタイム（日）
    $def_data["form_name_change"]       = $get_data[20];        //品名変更
    $def_data["form_tax_div"]           = $get_data[21];        //課税区分
    $def_data["form_royalty"]           = $get_data[22];        //ロイヤリティ（有無）
    $def_data["form_note"]              = $get_data[23];        //備考
    $def_data["form_state"]             = $get_data[24];        //状態
    $def_data["form_url"]               = $get_data[25];        //url
    $def_data["form_mark_div"]          = $get_data[26];        //マーク
	$def_data["form_g_product"]         = $get_data[27];        //商品分類
	$def_data["form_accept"]            = $get_data[28];        //承認
	$accept_disp_flg = ($get_data[28] == '1')? true : false;        //表示フラグ

    $album_url = addslashes($get_data[25]); 
    $no_change_flg                      = $get_data[29];        //変更不可フラグ
    $def_data["form_rental"]            = $get_data[30];        //RtoR
	$def_data["form_serial"]            = $get_data[31];        //シリアル管理

    //初期値設定 

    $form->setDefaults($def_data);

    //次へ・前へボタン作成
    $id_data = Make_Get_Id($conn, "goods", $get_data[0],"1");
    $next_id = $id_data[0];
    $back_id = $id_data[1];


    if($no_change_flg == 't'){
        $freeze_flg = true;
    }


    //最新売上日を抽出
    $sql  = "SELECT";
    $sql .= "   MAX(work_day) ";
    $sql .= "FROM";
    $sql .= "   t_stock_hand ";
    $sql .= "WHERE";
    $sql .= "   work_div = '2'";
    $sql .= "   AND";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $max_sale_day = (pg_fetch_result($result, 0,0) != null)? pg_fetch_result($result, 0,0) : "売上はありません。";

    //最新仕入日を抽出
    $sql  = "SELECT";
    $sql .= "   MAX(work_day) ";
    $sql .= "FROM";
    $sql .= "   t_stock_hand ";
    $sql .= "WHERE";
    $sql .= "   work_div = '4'";
    $sql .= "   AND";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $max_buy_day = (pg_fetch_result($result, 0,0) != null)? pg_fetch_result($result, 0,0) : "仕入はありません。";

}else{
    //初期値データ

    $def_data["form_attri_div"]     = 1;                        //属性区分
    $def_data["form_mark_div"]      = 1;                        //マーク
    $def_data["form_sale_manage"]   = 1;                        //販売管理
    $def_data["form_stock_manage"]  = 1;                        //在庫管理
    $def_data["form_name_change"]   = 1;                        //品名変更
    $def_data["form_tax_div"]       = 1;                        //課税区分
    $def_data["form_royalty"]       = 1;                        //ロイヤリティ（有無）

    //初期値設定
    $form->setDefaults($def_data);
}

/****************************/
//フォーム作成
/****************************/
//状態
$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効","1");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "無効","2");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効（直営）","3");
$form->addGroup($form_state, "form_state", "");

//レンタル
$form_rental[] =& $form->createElement( "radio",NULL,NULL, "あり","t");
$form_rental[] =& $form->createElement( "radio",NULL,NULL, "なし","f");
$form->addGroup($form_rental, "form_rental", "");

//シリアル
$text = NULL;
$text[] =& $form->createElement("radio",NULL,NULL,"あり","t");
$text[] =& $form->createElement("radio",NULL,NULL,"なし","f");
$form->addGroup($text,"form_serial", "");

//承認
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "承認済","1");
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "未承認","2");
$freeze = $form->addGroup($form_accept, "form_accept", "");
if($accept_disp_flg == true){
    $freeze->freeze();
}

//商品コード
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        onKeyUp=\"javascript:display(this,'goods')\" 
        $g_form_option"
);

//商品名
$form->addElement(
        "text","form_goods_name","",'size="70" maxLength="30" 
        '." $g_form_option"
);

//略称
$form->addElement(
        "text","form_goods_cname","",'size="15" maxLength="7" 
        '." $g_form_option"
);

//URL
$form->addElement(
        "text","form_url","テキストフォーム","size=\"48\" maxLength=\"100\" style=\"$g_form_style\"
        $g_form_option"
);      

//属性区分
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "製品","1");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "部品","2");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "管理","3");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "道具・他","4");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "保険","5");
$form->addGroup( $attri_div, "form_attri_div", "属性区分");

//マーク
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "汎用","1");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "ＧＭ","2");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "ＥＣ","3");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "Ｇ適","4");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "劇物","5");
$form->addGroup( $mark_div, "form_mark_div", "マーク");

//Ｍ区分
$select_ary = Select_Get($conn, "g_goods");
$form->addElement("select", "form_g_goods", "", $select_ary, $g_form_option_select);

//管理区分
$select_ary = Select_Get($conn,"product");
$form->addElement("select", "form_product", "", $select_ary, $g_form_option_select);

//商品分類
$g_product_ary = Select_Get($conn, 'g_product');
$form->addElement('select', 'form_g_product',"", $g_product_ary);

//単位
$form->addElement(
        "text","form_unit","",'size="11" maxLength="5" 
        '." $g_form_option"
);

//入数
$form->addElement(
        "text","form_in_num","","size=\"11\" maxLength=\"5\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
);

//仕入先１
$jouken  = "WHERE";
$jouken .= " client_div = '3' ";
$jouken .= " AND";
$jouken .= " shop_id = $shop_id";

$code_value = Code_Value("t_client",$conn,$jouken,"9");
$supplier[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier[cd1]', 'form_supplier[cd2]' ,'form_supplier[name]')\" 
        $g_form_option"
);
$supplier[] =& $form->createElement("static","","","-");
$supplier[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier[cd1]', 'form_supplier[cd2]' ,'form_supplier[name]')\" 
        $g_form_option"
);
$supplier[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier, "form_supplier", "");

//仕入先２
$supplier2[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier2[cd1]', 'form_supplier2[cd2]' ,'form_supplier2[name]')\" 
        $g_form_option"
);
$supplier2[] =& $form->createElement("static","","","-");
$supplier2[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier2[cd1]', 'form_supplier2[cd2]' ,'form_supplier2[name]')\" 
        $g_form_option"
);
$supplier2[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier2, "form_supplier2", "");

//仕入先３
$supplier3[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier3[cd1]', 'form_supplier3[cd2]' ,'form_supplier3[name]')\" 
        $g_form_option"
);
$supplier3[] =& $form->createElement("static","","","-");
$supplier3[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_supplier3[cd1]', 'form_supplier3[cd2]' ,'form_supplier3[name]')\" 
        $g_form_option"
);
$supplier3[] =& $form->createElement(
        "text","name","","size=\"48\" 
        $g_text_readonly"
);
$form->addGroup( $supplier3, "form_supplier3", "");

//仕入先ダイアログ用ダミーhidden
$form->addElement("hidden", "hdn_dummy");


//販売管理
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup( $sale_manage, "form_sale_manage", ""); 

//在庫管理
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup( $stock_manage, "form_stock_manage", ""); 

//在庫限り品
$form->addElement('checkbox', 'form_stock_only', '', '');

//発注点
$form->addElement(
        "text","form_order_point","","size=\"11\" maxLength=\"9\" 
        style=\"text-align: right; $g_form_style\"
        $g_form_option"
);

//発注単位数
$form->addElement(
        "text","form_order_unit","","size=\"11\" maxLength=\"4\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
);

//リードタイム
$form->addElement(
        "text","form_lead","","size=\"11\" maxLength=\"2\" style=\"$g_form_style\"
        "." $g_form_option"
);

//品名変更
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更可","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更不可","2");
$form->addGroup( $name_change, "form_name_change", "");

//課税区分
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "課税","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "非課税","3");
$form->addGroup( $tax_div, "form_tax_div", "");

//ロイヤリティ
$royalty[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$royalty[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup( $royalty, "form_royalty", ""); 

//備考
$form->addElement(
        "text","form_note","",'size="70" maxLength="30" 
        '." $g_form_option"
);

//ボタン
$form->addElement(
    "button","new_button","登録画面",
    $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);
$form->addElement(
    "button","change_button","変更・一覧",
    "onClick=\"javascript:Referer('1-1-220.php')\""
);

/****************************/
//ルール作成(QuickForm)
/****************************/
//■商品コード
//●必須チェック
$form->addRule( 
        "form_goods_cd", "商品コードは8文字の半角数字です。",
        "required"
);

//●数字チェック
$form->addRule(
        "form_goods_cd", "商品コードは8文字の半角数字です。",
        "regex", "/^[0-9]+$/"
);

//■商品名
//●必須チェック
$form->addRule(
        "form_goods_name", "商品名は1文字以上30文字以下です。",
        "required"
);
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_goods_name", "商品名 にスペースのみの登録はできません。", "no_sp_name");

$form->addRule(
        "form_goods_cname", "略記は1文字以上7文字以下です。",
        "required"
);
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_goods_cname", "略記 にスペースのみの登録はできません。", "no_sp_name");


//■Ｍ区分
//●必須チェック
$form->addRule('form_g_goods', "Ｍ区分は必須項目です。","required"
);
//■管理区分
//●必須チェック
$form->addRule('form_product', "管理区分は必須項目です。","required"
);
//■商品分類
//●必須チェック
$form->addRule('form_g_product', "商品分類は必須項目です。","required"
);
//■入数
//●数字チェック
$form->addRule(
        "form_in_num", "入数は半角数字のみです。",
        "regex", "/^[0-9]+$/"
);

//■発注点
//●数字チェック
$form->addRule(
        "form_order_point", "発注点は半角数字のみです。",
        "regex", "/^[0-9]+$/"
);

//■発注単位数
//●数字チェック
$form->addRule(
        "form_order_unit", "発注単位数は半角数字のみです。",
        "regex", "/^[0-9]+$/"
);

//■リードタイム
//●数字チェック
$form->addRule(
        "form_lead", "リードタイムは半角数字のみです。",
        "regex", "/^[0-9]+$/"
);
if($_POST["form_entry_button"] == "登　録"){
    /****************************/
    //POST取得
    /****************************/
    $state          = $_POST["form_state"];                 //状態
    $goods_cd       = $_POST["form_goods_cd"];              //商品コード
    $goods_name     = $_POST["form_goods_name"];            //商品名
    $goods_cname    = $_POST["form_goods_cname"];           //略称
    $attri_div      = $_POST["form_attri_div"];             //属性区分
    $g_goods_id     = $_POST["form_g_goods"];               //Ｍ区分
    $product_id     = $_POST["form_product"];               //管理区分
	$g_product_id   = $_POST["form_g_product"];             //商品分類
    $unit           = $_POST["form_unit"];                  //単位
    $in_num         = $_POST["form_in_num"];                //入数
    $supplier_cd1   = $_POST["form_supplier"]["cd1"];       //仕入先1コード1
    $supplier_cd2   = $_POST["form_supplier"]["cd2"];       //仕入先1コード2
    $supplier_name  = $_POST["form_supplier"]["name"];      //仕入先1名
    $supplier2_cd1  = $_POST["form_supplier2"]["cd1"];      //仕入先2コード1
    $supplier2_cd2  = $_POST["form_supplier2"]["cd2"];      //仕入先2コード2
    $supplier2_name = $_POST["form_supplier2"]["name"];     //仕入先2名
    $supplier3_cd1  = $_POST["form_supplier3"]["cd1"];      //仕入先3コード1
    $supplier3_cd2  = $_POST["form_supplier3"]["cd2"];      //仕入先3コード2
    $supplier_name3 = $_POST["form_supplier3"]["name"];     //仕入先3名
    $sale_manage    = $_POST["form_sale_manage"];           //販売管理
    $stock_manage   = $_POST["form_stock_manage"];          //在庫管理
    $stock_only     = $_POST["form_stock_only"];            //在庫限り品
    $order_point    = $_POST["form_order_point"];           //発注点
    $order_unit     = $_POST["form_order_unit"];            //発注単位数
    $lead           = $_POST["form_lead"];                  //リードタイム（日）
    $name_change    = $_POST["form_name_change"];           //品名変更
    $tax_div        = $_POST["form_tax_div"];               //課税区分
    $royalty        = $_POST["form_royalty"];               //ロイヤリティ（有無）
    $note           = $_POST["form_note"];                  //備考
    $url            = $_POST["form_url"];                   //URL
    $mark_div       = $_POST["form_mark_div"];              //マーク
    $accept_flg     = $_POST["form_accept"];
    $rental_flg     = $_POST["form_rental"];                //RtoR
	$serial_flg     = $_POST["form_serial"];                //シリアル管理

    //●コード体系チェック
    if($goods_cd != null && (strlen($goods_cd) >= 8) && substr($goods_cd, 0, 1) != 0){
        $form->setElementError("form_goods_cd","商品コードの上１桁は「０」です。");
    }

    //URLチェック
    if((!ereg("^.+\.html$|htm$|jpg$|jpeg$", $url) || strstr($url,'/')) && $url != null){
        $form->setElementError("form_url","ファイル名の拡張子はhtml,htm,jpg,jpeg としてください。");
    }

    //■仕入先1
    //●必須チェック
    if(($_POST["form_supplier"]["cd1"] != NULL || $_POST["form_supplier"]["cd2"] != NULL) && $_POST["form_supplier"]["name"] == NULL){
        $form->setElementError("form_supplier","正しい仕入先コードを入力して下さい。");
    }
    
    //■仕入先2
    //●必須チェック
    if(($_POST["form_supplier2"]["cd1"] != NULL || $_POST["form_supplier2"]["cd2"] != NULL) && $_POST["form_supplier2"]["name"] == NULL){
        $form->setElementError("form_supplier2","正しい仕入先2コードを入力して下さい。");
    }

    //■仕入先3
    //●必須チェック
    if(($_POST["form_supplier3"]["cd1"] != NULL || $_POST["form_supplier3"]["cd2"] != NULL) && $_POST["form_supplier3"]["name"] == NULL){
        $form->setElementError("form_supplier3","正しい仕入先3コードを入力して下さい。");
    }

    /***************************/
    //商品コード整形
    /***************************/
    $goods_cd = str_pad($goods_cd, 8, 0, STR_PAD_LEFT);

    /****************************/
    //商品コード空きチェック
    /****************************/
    $goods_cd_sql  = " SELECT";
    $goods_cd_sql .= "     goods_cd";
    $goods_cd_sql .= " FROM";
    $goods_cd_sql .= "     t_goods";
    $goods_cd_sql .= " WHERE";
    $goods_cd_sql .= "     shop_id = $shop_id";
    $goods_cd_sql .= "     AND";
    $goods_cd_sql .= "     goods_cd = '$goods_cd'";
    $goods_cd_sql .= " ;";

    $result = Db_Query($conn, $goods_cd_sql);
    $goods_cd_res = @pg_fetch_result($result, 0,0);

    if($goods_cd_res != null && $get_flg != true){
        $form->setElementError("form_goods_cd","既に使用されている 商品コード です。");
    }elseif($goods_cd_res != null && $get_flg == true && $get_data[0] != $goods_cd_res){
        $form->setElementError("form_goods_name","既に使用されている 商品コード です。");
    }

    /****************************/
    //要素検証
    /****************************/
    if($form->validate()){
 
        /***************************/
        //必須データ作成
        /***************************/
        $make_goods_flg = 0;                                    //製造品フラグ
        $public_flg = 1;                                        //共有フラグ
        $compose_flg = 0;                                       //構成品フラグ

        /****************************/
        //nullに置き換え
        /****************************/
        if($order_point == null){
            $order_point = "null";
        }

        /****************************/
        //商品登録
        /****************************/
        //登録・更新判定
        if($get_flg == true){
            //商品マスタ
            Db_Query($conn,"BEGIN;");

            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods";
            $goods_sql .= " SET";
            $goods_sql .= "     state = '$state',";
            $goods_sql .= "     goods_cd = '$goods_cd',";
            $goods_sql .= "     goods_name = '$goods_name',";
            $goods_sql .= "     goods_cname = '$goods_cname',";
            $goods_sql .= "     attri_div = '$attri_div',";
            $goods_sql .= "     product_id = $product_id,";
			$goods_sql .= "     g_product_id = $g_product_id,";
            $goods_sql .= "     g_goods_id = $g_goods_id,";
            $goods_sql .= "     unit = '$unit',";
            $goods_sql .= "     tax_div = '$tax_div',";
            $goods_sql .= "     name_change = '$name_change',";
            $goods_sql .= "     sale_manage = '$sale_manage',";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     stock_manage = '$stock_manage',";
            $goods_sql .= "     stock_only = '$stock_only',";
            $goods_sql .= "     royalty = '$royalty',";
            $goods_sql .= "     url = '$url',";
            $goods_sql .= "     mark_div = '$mark_div',";
            $goods_sql .= "     in_num = '$in_num', ";
            $goods_sql .= "     accept_flg = '$accept_flg',";
            $goods_sql .= "     rental_flg = '$rental_flg',";
			$goods_sql .= "     serial_flg = '$serial_flg'";
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //ショップ別商品情報テーブル
            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods_info";
            $goods_sql .= " SET";
            $goods_sql .= "     goods_id = $get_goods_id,";
            $goods_sql .= "     order_point = $order_point,";
            $goods_sql .= "     order_unit = '$order_unit',";
            $goods_sql .= "     lead = '$lead',";
            $goods_sql .= "     note = '$note',";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     stock_manage = '$stock_manage',";

            //仕入先が指定されていた場合
            if($supplier_cd1 != null && $supplier_cd2 != null){
                $goods_sql .= "     supplier_id = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 ),";
            }else{
                $goods_sql .= "     supplier_id = null,";
            }
            //仕入先2が指定されていた場合
            if($supplier2_cd1 != null && $supplier2_cd2 != null){        
                $goods_sql .= "     supplier_id2 = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier2_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier2_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 ),";
            }else{
                $goods_sql .= "     supplier_id2 = null,";
            }
            //仕入先が指定されていた場合
            if($supplier3_cd1 != null && $supplier3_cd2 != null){
                $goods_sql .= "     supplier_id3 = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= "                     shop_id = $shop_id";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier3_cd1'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd2 = '$supplier3_cd2'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '3'";
                $goods_sql .= "                 )";
            }else{
                $goods_sql .= "     supplier_id3 = null";
            }
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= "     AND";
            $goods_sql .= "     shop_id = $shop_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
            }

            $work_div = '2';

            //商品マスタの変更を契約マスタ、予定データに反映
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }

        //新規登録
        }else{
            //商品マスタ
            Db_Query($conn, "BEGIN;");            

            $goods_sql  = " INSERT INTO t_goods (";
            $goods_sql .= "     goods_id,";
            $goods_sql .= "     goods_cd,";
            $goods_sql .= "     goods_name,";
            $goods_sql .= "     goods_cname,";
            $goods_sql .= "     attri_div,";
            $goods_sql .= "     product_id,";
			$goods_sql .= "     g_product_id,";
            $goods_sql .= "     g_goods_id,";
            $goods_sql .= "     unit,";
            $goods_sql .= "     tax_div,";
            $goods_sql .= "     name_change,";
            $goods_sql .= "     sale_manage,";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     stock_manage,";
            $goods_sql .= "     stock_only,";
            $goods_sql .= "     royalty,";
            $goods_sql .= "     make_goods_flg,";
            $goods_sql .= "     public_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     state,";
            $goods_sql .= "     url,";
            $goods_sql .= "     mark_div, ";
            $goods_sql .= "     in_num, ";
            $goods_sql .= "     accept_flg,";
            $goods_sql .= "     rental_flg,";
			$goods_sql .= "     serial_flg";
            $goods_sql .= " )VALUES (";
            $goods_sql .= "     (SELECT COALESCE(MAX(goods_id), 0)+1 FROM t_goods),";
            $goods_sql .= "     '$goods_cd',";
            $goods_sql .= "     '$goods_name',";
            $goods_sql .= "     '$goods_cname',";
            $goods_sql .= "     '$attri_div',";
            $goods_sql .= "     '$product_id',";
			$goods_sql .= "     '$g_product_id',";
            $goods_sql .= "     '$g_goods_id',";
            $goods_sql .= "     '$unit',";
            $goods_sql .= "     '$tax_div',";
            $goods_sql .= "     '$name_change',";
            $goods_sql .= "     '$sale_manage',";
            #2009-10-06 hashimoto-y
            #$goods_sql .= "     '$stock_manage',";
            $goods_sql .= "     '$stock_only',";
            $goods_sql .= "     '$royalty',";
            $goods_sql .= "     '$make_goods_flg',";
            $goods_sql .= "     '$public_flg',";
            $goods_sql .= "     $shop_id,";
            $goods_sql .= "     '$state',";
            $goods_sql .= "     '$url',";
            $goods_sql .= "     '$mark_div',";
            $goods_sql .= "     '$in_num',";
            $goods_sql .= "     '$accept_flg',";
            $goods_sql .= "     '$rental_flg',";
			$goods_sql .= "     '$serial_flg'";
            $goods_sql .= ");";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //ショップ別商品情報テーブル
            $goods_sql  = " INSERT INTO t_goods_info (";
            $goods_sql .= "     goods_id,";
            $goods_sql .= "     order_point,";
            $goods_sql .= "     order_unit,";
            $goods_sql .= "     lead,";
            $goods_sql .= "     note,";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     stock_manage,";
            $goods_sql .= "     supplier_id,";
            $goods_sql .= "     compose_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     head_fc_flg,";
            $goods_sql .= "     supplier_id2,";
            $goods_sql .= "     supplier_id3";
            $goods_sql .= ") VALUES (";
            $goods_sql .= "     (SELECT";
            $goods_sql .= "         goods_id";
            $goods_sql .= "     FROM";
            $goods_sql .= "         t_goods";
            $goods_sql .= "     WHERE";
            $goods_sql .= "         shop_id = $shop_id";
            $goods_sql .= "     AND";
            $goods_sql .= "         goods_cd = '$goods_cd'";
            $goods_sql .= "     ),";
            $goods_sql .= "     $order_point,";
            $goods_sql .= "     '$order_unit',";
            $goods_sql .= "     '$lead',";
            $goods_sql .= "     '$note',";
            #2009-10-06 hashimoto-y
            $goods_sql .= "     '$stock_manage',";

            //仕入先が指定されていた場合
            if($supplier_cd1 != null && $supplier_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            $goods_sql .= "    '$compose_flg',";
            $goods_sql .= "    $shop_id,";
            $goods_sql .= "    't',";
            //仕入先が指定されていた場合
            if($supplier2_cd1 != null && $supplier2_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier2_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier2_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            //仕入先が指定されていた場合
            if($supplier3_cd1 != null && $supplier3_cd2 != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= "        shop_id = $shop_id";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier3_cd1'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd2 = '$supplier3_cd2'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '3'";
                $goods_sql .= "    )";
            }else{
                $goods_sql .= "null";
            }
            $goods_sql .= ");"; 

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

        $work_div = '1';

        }





        $result = Log_Save( $conn, "goods", $work_div, $goods_cd, $goods_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //クエリ実行
        Db_Query($conn, "COMMIT");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    /****************************/
    //GETデータ作成
    /****************************/
    $goods_id_sql  = "SELECT";
    $goods_id_sql .= "   goods_id";
    $goods_id_sql .= " FROM";
    $goods_id_sql .= "   t_goods";
    $goods_id_sql .= " WHERE";
    $goods_id_sql .= "  goods_cd = '$goods_cd'";
    $goods_id_sql .= "  AND";
    $goods_id_sql .= "  shop_id = $shop_id";
    $goods_id_sql .= ";";

    $result = Db_Query($conn, $goods_id_sql);

    $get_goods_id = pg_fetch_result($result, 0);

    //遷移先判定
/*
    if($get_flg == true){
        $target = "./1-1-221.php";
    }else{
*/
        $target = "./1-1-222.php?goods_id=".$get_goods_id;
//    }
    
    if($no_change_flg == 't'){
        $form->addElement("button","form_back_button","戻　る","onClick=\"location.href='./1-1-220.php'\"");
    }else{
        $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"javascript:Referer('$target')\"");
        $form->addElement("button","form_back_button","戻　る","onClick=\"location.href='./1-1-221.php?goods_id=$get_goods_id'\"");
    }

    $form->addElement("static","form_client_link","","仕入先1");
    $form->addElement("static","form_client_link2","","仕入先2");
    $form->addElement("static","form_client_link3","","仕入先3");

    $form->freeze();
}else{
    $form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled");
    $form->addElement(
        "button","form_show_dialog_button","登録済一覧確認",
        "onClick='javascript:showModelessDialog(\"../dialog/1-0-210-1.php\",window,\"status:false;dialogWidth:540px;dialogHeight:500px;edge:sunken;\")'
    ");
    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./1-1-221.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","次　へ","disabled");
    }
    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./1-1-221.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","前　へ","disabled");
    }
    //仕入先
    $form->addElement(
        "link","form_client_link","","#","仕入先1",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier[cd1]','form_supplier[cd2]','form_supplier[name]','hdn_dummy'),500,450);\""
    );
    //仕入先2
    $form->addElement(
        "link","form_client_link2","","#","仕入先2",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier2[cd]', 'form_supplier2[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier2[cd1]','form_supplier2[cd2]','form_supplier2[name]','hdn_dummy'),500,450);\""
    );
    //仕入先3
    $form->addElement(
        "link","form_client_link3","","#","仕入先3",
        //"onClick=\"return Open_SubWin('../dialog/1-0-208.php', Array('form_supplier3[cd]', 'form_supplier3[name]'), 500, 450);\""
        "onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_supplier3[cd1]','form_supplier3[cd2]','form_supplier3[name]','hdn_dummy'),500,450);\""
    );
}

$form->addElement(
        "button","form_set_price_button","単価設定",
        "onClick='javascript:location.href = \"./1-1-222.php?goods_id=$get_goods_id\"'
");

if($get_flg == true && $album_url != null){
    $form->addElement(
        "link","form_album_link","","#",
        "商品アルバム",
        "onClick=\"window.open('".ALBUM_DIR.$album_url."');\""
    );
}else{
    $form->addElement(
        "static","form_album_link","","商品アルバム"
    );
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
//$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= "     public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     shop_id = $shop_id";
$goods_sql .= " ;";

$result = Db_Query($conn,$goods_sql);
//全件数取得(ヘッダー)
$t_count = pg_fetch_result($result,0,0);

$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= "     public_flg = 't'";
$goods_sql .= "     AND";
$goods_sql .= "     shop_id = $shop_id";
$goods_sql .= "     AND";
$goods_sql .= "     compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     state IN (1,3)";
$goods_sql .= " ;";

$result = Db_Query($conn,$goods_sql);
//全件数取得(ヘッダー)
$dealing_count = pg_fetch_result($result,0,0);

$page_title .= "(有効".$dealing_count."件/全".$t_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "　".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}

$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'           => "$html_header",
	//'page_menu'             => "$page_menu",
	'page_header'           => "$page_header",
	'html_footer'           => "$html_footer",
    'code_value'            => "$code_value",
    'next_id'               => "$next_id",
    'back_id'               => "$back_id",
    'url'                   => ALBAM_DIR,
    'auth_r_msg'            => "$auth_r_msg",
    'sale_day'              => "$max_sale_day",
    'buy_day'               => "$max_buy_day"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_POST);


?>
