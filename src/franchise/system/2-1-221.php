<?php
/**************************
変更履歴
    ・URLを登録するように変更(200/05/23)
    ・略記を7文字に変更(2006/08/01)
    ・変更後の遷移先を新規商品マスタ登録画面に変更（2006/08/21）
	(2006/11/30)シリアル管理表示欄追加
***************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0090    suzuki      変更時にログに商品名を登録するように修正
 *  2006-12-08      ban_0098    kaji        全件数に本部無効商品が含まれていたのを含まないように変更
 *  2007-06-26                  watanabe-k  商品マスタの変更を契約マスタに反映するように修正
 *  2009-09-21                  watanabe-k  入数のmaxlengthを5に変更
 *  2009-10-08                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *  2015/05/01                  amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 *
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
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
session_start();
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$get_goods_id = $_GET["goods_id"];      //GETした商品ID

/****************************/
//初期値設定
/****************************/
$defa_data["form_state"] = 1;
$defa_data["form_rental"] = "f";
$defa_data["form_serial"] = "f";
$form->setDefaults($defa_data);


//GETがある場合
if($_GET["goods_id"] != null){
    Get_Id_Check3($_GET["goods_id"]);

    $get_flg = true;                                            //GETフラグ

    $sql  = " SELECT";
    $sql .= "   t_goods.goods_cd,";                             //商品コード
    $sql .= "   t_goods.goods_name,";                           //商品名
    $sql .= "   t_goods.goods_cname,";                          //略称
    $sql .= "   t_goods.attri_div,";                            //属性区分
    $sql .= "   CASE t_goods.attri_div";                        //属性区分名
    $sql .= "       WHEN '1' THEN '製品'";
    $sql .= "       WHEN '2' THEN '部品'";
    $sql .= "       WHEN '3' THEN '管理'";
    $sql .= "       WHEN '4' THEN '道具・他'";
    $sql .= "   END,";
    $sql .= "   t_g_goods.g_goods_id,";                         //Ｍ区分ID
    $sql .= "   t_g_goods.g_goods_name,";                       //Ｍ区分名
    $sql .= "   t_product.product_id,";                         //管理区分ID
    $sql .= "   t_product.product_name,";                       //管理区分名
    $sql .= "   t_goods.unit,";                                 //単位
    $sql .= "   t_goods.in_num,";                               //入数
    $sql .= "   t_client.client_cd1,";                          //仕入先コード
    $sql .= "   t_client.client_name,";                         //仕入先名
    $sql .= "   t_goods.sale_manage,";                          //販売管理
    $sql .= "   CASE t_goods.sale_manage";                      //販売管理名
    $sql .= "       WHEN '1' THEN '有'";
    $sql .= "       WHEN '2' THEN '無'";
    $sql .= "   END,";
    #2009-10-08 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";                         //在庫管理
    #$sql .= "   CASE t_goods.stock_manage";                     //在庫管理名
    $sql .= "   t_goods_info.stock_manage,";                         //在庫管理
    $sql .= "   CASE t_goods_info.stock_manage";                     //在庫管理名
    $sql .= "       WHEN '1' THEN '有'";
    $sql .= "       WHEN '2' THEN '無'";
    $sql .= "   END,";
    $sql .= "   t_goods.stock_only,";                           //在庫限り品
    $sql .= "   CASE t_goods.stock_only";                       //在庫限り品名
    $sql .= "       WHEN '1' THEN '在庫限り品'";
    $sql .= "       WHEN '0' THEN ''";
    $sql .= "   END,";
    $sql .= "   t_goods_info.order_point,";                     //発注点
    $sql .= "   t_goods_info.order_unit, ";                     //発注単位数
    $sql .= "   t_goods_info.lead,";                            //リードタイム（日）
    $sql .= "   t_goods.name_change,";                          //品名変更
    $sql .= "   CASE t_goods.name_change";                      //品名変更名
    $sql .= "       WHEN '1' THEN '変更可'";
    $sql .= "       WHEN '2' THEN '変更不可'";
    $sql .= "   END,";
    $sql .= "   t_goods.tax_div,";                              //課税区分
    $sql .= "   CASE t_goods.tax_div";                          //課税区分名
//    $sql .= "       WHEN '1' THEN '外税'";
    $sql .= "       WHEN '1' THEN '課税'";
    $sql .= "       WHEN '2' THEN '内税'";
    $sql .= "       WHEN '3' THEN '非課税'";
    $sql .= "   END,";
    $sql .= "   t_goods_info.note, ";                           //備考
    $sql .= "   t_goods.public_flg, ";                           //共有フラグ
    $sql .= "   t_goods.state, ";                                //状態
    $sql .= "   t_goods.url,";
    $sql .= "   t_goods.mark_div,";                            //マーク
    $sql .= "   CASE t_goods.mark_div";                        //マーク
    $sql .= "       WHEN '1' THEN '汎用'";
    $sql .= "       WHEN '2' THEN 'ＧＭ'";
    $sql .= "       WHEN '3' THEN 'ＥＣ'";
    $sql .= "       WHEN '4' THEN 'Ｇ適'";
    $sql .= "       WHEN '5' THEN '劇物'";
    $sql .= "   END,";
	$sql .= "   t_g_product.g_product_id,";                     //商品分類ID
	$sql .= "   t_g_product.g_product_name, ";                  //商品分類名
    $sql .= "   t_goods.rental_flg,";                           //レンタル
	$sql .= "   t_goods.serial_flg";                            //シリアル管理
    $sql .= " FROM";
    $sql .= "   t_goods,";                                      //商品マスタ
    $sql .= "   t_g_goods,";                                    //Ｍ区分マスタ
    $sql .= "   t_product,";                                    //管理区分マスタ
	$sql .= "   t_g_product,";                                  //商品分類マスタ
    $sql .= "   t_goods_info";                                  //ショップ別商品情報テーブル
    $sql .= " LEFT JOIN";
    $sql .= "   t_client";                                      //得意先マスタ
    $sql .= " ON t_goods_info.supplier_id = t_client.client_id";
    $sql .= " WHERE";
    $sql .= "   t_goods.goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.g_goods_id = t_g_goods.g_goods_id";
    $sql .= "   AND";
    $sql .= "   t_goods.product_id = t_product.product_id";
	$sql .= "   AND";
    $sql .= "   t_goods.g_product_id = t_g_product.g_product_id";
    $sql .= "   AND";
    $sql .= "   t_goods.goods_id = t_goods_info.goods_id";
    $sql .= "   AND";
    $sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
    $sql .= "   AND";
    //$sql .= ($group_kind == "2") ? " t_goods.state IN (1,3) " : " t_goods.state = 1";
    if($group_kind == "2"){
        $sql .= "     (t_goods.state IN ('1', '3') OR (t_goods.state = '2' AND t_goods.shop_id IN (".Rank_Sql()."))) \n";
    }else{
        $sql .= "     (t_goods.state = '1' OR (t_goods.state = '2' AND t_goods.shop_id = $shop_id)) \n";
    }
    $sql .= " ;";

    //クエリ発行
    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    //データ取得
    $get_goods_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

    //本部商品判定
    if($get_goods_data[27] == 't')
    {
		//仕入先
		$where_sql  = " WHERE";
		$where_sql .= "  client_div = '2'";
		$where_sql .= "  AND";
		$where_sql .= "  head_flg = 'f'";
		$where_sql .= "  AND";
        $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

		$code_value = Code_Value("t_client",$conn,"$where_sql",2);
        $head_flg = true;                                       //本部商品判定フラグ
        $type = "static";
        $read = "style=\"color : #525552; border : #ffffff 1px solid;background-color: #ffffff;\" readonly";

        // 一覧で選択された商品が本部商品の場合
        $sql  = "SELECT ";
        $sql .= "   client_id, ";
        $sql .= "   client_cd1, ";
        $sql .= "   client_name ";
        $sql .= "FROM ";
        $sql .= "   t_client ";
        $sql .= "WHERE ";
        $sql .= "   head_flg = 't' ";
        $sql .= "   AND shop_id = $shop_id ";
        $sql .= ";";
        $res  = Db_Query($conn, $sql);
        $head_item = pg_fetch_array($res, 0, PGSQL_ASSOC);

        $head_item_form["form_supplier"]["cd"]      = $head_item["client_cd1"];
        $head_item_form["form_supplier"]["name"]    = $head_item["client_name"];

    }else{
		//仕入先
		$where_sql  = " WHERE";
		$where_sql .= "  client_div = '2'";
		$where_sql .= "  AND";
        $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

		$code_value = Code_Value("t_client",$conn,"$where_sql",2);
        $type = "text";
        $read = $g_form_oprion;
    }

    //初期値データ
    $def_data["form_goods_cd"]          = $get_goods_data[0];         //商品コード
    $def_data["form_goods_name"]        = ($head_flg != true) ? $get_goods_data[1]
                                                              : htmlspecialchars($get_goods_data[1]);         //商品名
    $def_data["form_goods_cname"]       = ($head_flg != true) ? $get_goods_data[2]
                                                              : htmlspecialchars($get_goods_data[2]);         //略称  
    $def_data["form_attri_div"]         = $get_goods_data[3];         //属性区分
    $def_data["form_attri_name"]        = $get_goods_data[4];         //属性区分名
    $def_data["form_g_goods_id"]        = $get_goods_data[5];         //Ｍ区分ID
    $def_data["form_g_goods_name"]      = ($head_flg != true) ? $get_goods_data[6]
                                                              : htmlspecialchars($get_goods_data[6]);         //Ｍ区分名
    $def_data["form_product_id"]        = $get_goods_data[7];         //管理区分ID
    $def_data["form_product_name"]      = ($head_flg != true) ? $get_goods_data[8]
                                                              : htmlspecialchars($get_goods_data[8]);         //管理区分名
    $def_data["form_unit"]              = ($head_flg != true) ? $get_goods_data[9]
                                                              : htmlspecialchars($get_goods_data[9]);         //単位  
    $def_data["form_sale_manage"]       = $get_goods_data[13];        //販売管理
    $def_data["form_sale_manage_name"]  = $get_goods_data[14];        //販売管理名
    $def_data["form_stock_manage"]      = $get_goods_data[15];        //在庫管理
    $def_data["form_stock_manage_name"] = $get_goods_data[16];        //在庫管理名
    $def_data["form_stock_only"]        = $get_goods_data[17];        //在庫限り品
    $def_data["form_stock_only_name"]   = $get_goods_data[18];        //在庫限り品名
    $def_data["form_name_change"]       = $get_goods_data[22];        //品名変更
    $def_data["form_name_change_name"]  = $get_goods_data[23];        //品名変更名
    $def_data["form_tax_div"]           = $get_goods_data[24];        //課税区分
    $def_data["form_tax_div_name"]      = $get_goods_data[25];        //課税区分名
    $def_data["form_in_num"]            = $get_goods_data[10];        //入数  
    //本部商品の場合
    if ($get_goods_data[27] == 't'){
        $def_data["form_supplier"]["cd"]    = $head_item["client_cd1"];     // 仕入先コード
        $def_data["form_supplier"]["name"]  = htmlspecialchars($head_item["client_name"]);    // 仕入先名
    }else{
        $def_data["form_supplier"]["cd"]    = $get_goods_data[11];          //仕入先コード
        $def_data["form_supplier"]["name"]  = $get_goods_data[12];          //仕入先名
    }
    $def_data["form_order_point"]       = $get_goods_data[19];        //発注点
    $def_data["form_order_unit"]        = $get_goods_data[20];        //発注単位数
    $def_data["form_lead"]              = $get_goods_data[21];        //リードタイム（日）
    $def_data["form_note"]              = $get_goods_data[26];        //備考  
    $def_data["form_state"]             = $get_goods_data[28];        //状態
    $def_data["form_url"]               = ($head_flg != true) ? $get_goods_data[29]
                                                              : htmlspecialchars($get_goods_data[29]);        //url
    $def_data["form_mark_div"]          = $get_goods_data[30];        //マーク
    $def_data["form_mark_name"]         = $get_goods_data[31];        //マーク名
	$def_data["form_g_product_id"]      = $get_goods_data[32];        //商品分類ID
	$def_data["form_g_product_name"]    = ($head_flg != true) ? $get_goods_data[33]
                                                              : htmlspecialchars($get_goods_data[33]);        //商品分類名
    $def_data["form_rental"]            = $get_goods_data[34];        //レンタル
	$def_data["form_serial"]            = $get_goods_data[35];        //シリアル管理

    $album_url                          = addslashes($get_goods_data[29]);        //URL

    //初期値設定
    $form->setDefaults($def_data);

    $id_data = Make_Get_Id($conn, "goods", $get_goods_data[0], '2');
    $next_id = $id_data[0]; 
    $back_id = $id_data[1];

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
    $def_data["form_sale_manage"]   = 1;                        //販売管理
    $def_data["form_stock_manage"]  = 1;                        //在庫管理
    $def_data["form_name_change"]   = 1;                        //品名変更
    $def_data["form_tax_div"]       = 1;                        //課税区分
    $def_data["form_mark_div"]      = 1;                        //課税区分
    //初期値設定
    $form->setDefaults($def_data);

    $type = "text";
}

/****************************/
//フォーム作成
/****************************/
if($head_flg != true){
    //状態
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効","1");
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "無効","2");
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
}else{
    //状態
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "有効","1");
	$form_state[] =& $form->createElement( "radio",NULL,NULL, "無効","2");
	$form->addGroup($form_state, "form_state", "");

    //レンタル
	$form_rental[] =& $form->createElement( "radio",NULL,NULL, "あり","t");
	$form_rental[] =& $form->createElement( "radio",NULL,NULL, "なし","f");
	$form->addGroup($form_rental, "form_rental", "");

	//シリアル
	$form_serial[] =& $form->createElement("radio",NULL,NULL,"あり","t");
	$form_serial[] =& $form->createElement("radio",NULL,NULL,"なし","f");
	$form->addGroup($form_serial,"form_serial", "");

    $form->freeze(form_state);
	$form->freeze(form_rental);
	$form->freeze(form_serial);
}
//商品コード
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        $read"
);

//商品名
$form->addElement(
        $type,"form_goods_name","","size=\"70\" maxLength=\"30\"
         $g_form_option"
);

//略称
$form->addElement(
        $type,"form_goods_cname","","size=\"15\" maxLength=\"7\"
        $g_form_option"
);


if($_GET["goods_id"] == null){
	//仕入先
	$where_sql  = " WHERE";
	$where_sql .= "  client_div = '2'";
	$where_sql .= "  AND";
    $where_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

	$code_value = Code_Value("t_client",$conn,"$where_sql",2);
}
//属性区分
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "製品","1");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "部品","2");
$attri_div[] =& $form->createElement( "radio",NULL,NULL, "管理","3");
$attri_div[] =& $form->createElement("radio",NULL,NULL, "道具・他","4");
$attri_div[] =& $form->createElement("radio",NULL,NULL, "保険","5");
$form->addGroup( $attri_div, "form_attri_div", "属性区分");
$form->addElement($type,"form_attri_name","","size\"34\" maxLength=\"10\"
        $form_option"
);

//マーク
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "汎用","1");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "ＧＭ","2");
$mark_div[] =& $form->createElement( "radio",NULL,NULL, "ＥＣ","3");
$mark_div[] =& $form->createElement("radio",NULL,NULL, "Ｇ適","4");
$mark_div[] =& $form->createElement("radio",NULL,NULL, "劇物","5");
$form->addGroup( $mark_div, "form_mark_div", "属性区分");
$form->addElement($type,"form_mark_name","","size\"34\" maxLength=\"10\"
        $form_option"
);

//Ｍ区分
$g_goods_ary = Select_Get($conn, 'g_goods');
$form->addElement('select', 'form_g_goods_id',"", $g_goods_ary, $g_form_option_select);
$form->addElement($type,"form_g_goods_name","","size=\"25\"
                $g_form_option"
);

//管理区分
$product_ary = Select_Get($conn, 'product');
$form->addElement('select', 'form_product_id',"", $product_ary, $g_form_option_select);
$form->addElement($type,"form_product_name","","size=\"25\"
                $g_form_option"
);

//商品分類
$g_product_ary = Select_Get($conn, 'g_product');
$form->addElement('select', 'form_g_product_id',"", $g_product_ary);
$form->addElement($type,"form_g_product_name","","size=\"25\"
                $g_form_option"
);

//単位
$form->addElement(
        $type,"form_unit","","size=\"11\" maxLength=\"5\" 
        $g_form_option"
);

//入数
$head_freeze = $form->addElement(
        "text","form_in_num","","size=\"11\" maxLength=\"5\" style=\"text-align: right;$g_form_style\"
        $g_form_option"
);
($head_flg == true) ? $head_freeze->freeze() : null;    // 本部商品はフリーズ


$supplier[] =& $form->createElement("text","cd","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" 
        onKeyUp=\"javascript:client(this,'form_supplier[name]')\" $g_form_option");
$supplier[] =& $form->createElement("text","name","","size=\"48\" $g_text_readonly");
$head_item_form = $form->addGroup( $supplier, "form_supplier", "");

//販売管理
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$sale_manage[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup( $sale_manage, "form_sale_manage", "");
$form->addElement($type,"form_sale_manage_name","","size=\"4\" maxLength=\"4\""
);

//在庫管理
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$stock_manage[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup( $stock_manage, "form_stock_manage", "");
$form->addElement($type,"form_stock_manage_name","",""
);


//在庫限り品
$form->addElement('checkbox', 'form_stock_only', '', '');
$form->addElement($type,"form_stock_only_name","",""
);

//発注点
$form->addElement(
        "text","form_order_point","","size=\"11\" maxLength=\"9\" 
        $g_form_option 
        style=\"text-align: right;$g_form_style\""
);

//発注単位数
$form->addElement(
        "text","form_order_unit","","size=\"11\" maxLength=\"4\" 
        $g_form_option 
        style=\"text-align: right;$g_form_style\""
);

//リードタイム
$form->addElement(
        "text","form_lead","","size=\"11\" maxLength=\"2\" style=\"$g_form_style\" 
        $g_form_option"
);

//品名変更
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更可","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "変更不可","2");
$form->addGroup( $name_change, "form_name_change", "");
$form->addElement($type,"form_name_change_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//課税区分
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "課税","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "非課税","3");
$form->addGroup( $tax_div, "form_tax_div", "");
$form->addElement($type,"form_tax_div_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//備考
$form->addElement(
        "text","form_note","","size=\"70\" maxLength=\"30\" 
        $g_form_option"
);

//ボタン
$form->addElement(
    "button","new_button","登録画面",
    $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);
$form->addElement(
    "button","change_button","変更・一覧",
    "onClick=\"javascript:Referer('2-1-220.php')\""
);
//$form->addElement(
//    "button","form_set_price_button","単価設定",
//    "onClick='javascript:location.href = \"2-1-222.php?goods_id=$get_goods_id\"'
//");

/****************************/
//ルール作成(QuickForm)
/****************************/
if($head_flg != true){
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

    //●桁チェック
    $form->addRule(
        'form_goods_cd', '商品コードは8文字の半角数字です。', 
        'rangelength', array(8, 8)
    );

    //■商品名
    //●必須チェック
    $form->addRule(
        "form_goods_name", "商品名は１文字以上30文字以下です。",
        'required');
    // 全角/半角スペースのみチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_name", "商品名 にスペースのみの登録はできません。", "no_sp_name");

    //■略称
    //●必須チェック
    $form->addRule(
        "form_goods_cname","略称は1文字以上7文字以下です。",
        'required');
    $form->addRule("form_goods_cname", "略称 にスペースのみの登録はできません。", "no_sp_name");

    //■Ｍ区分
    //●必須チェック
    $form->addRule(
        "form_g_goods_id", "Ｍ区分は必須項目です。",
        "required");

    //■管理区分
    //●必須チェック
    $form->addRule(
        "form_product_id", "管理区分は必須項目です。",
        "required");

	//■商品分類
	//●必須チェック
	$form->addRule('form_g_product_id', "商品分類は必須項目です。","required"
	);

}

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
        "regex", "/^[0-9]+$/");
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
/*****************************/
//ルール作成（PHP）
/****************************/
if($_POST["form_entry_button"] == "登　録" ){

    /****************************/
    //POST取得
    /****************************/
    $state          = $_POST["form_state"];                 //状態
    $goods_cd       = $_POST["form_goods_cd"];              //商品CD
    $goods_name     = $_POST["form_goods_name"];            //商品名
    $goods_cname    = $_POST["form_goods_cname"];           //略称
    $attri_div      = $_POST["form_attri_div"];             //属性区分
    $g_goods_id     = $_POST["form_g_goods_id"];            //Ｍ区分ID
    $product_id     = $_POST["form_product_id"];            //管理区分ID
	$g_product_id   = $_POST["form_g_product_id"];          //商品分類
    $unit           = $_POST["form_unit"];                  //単位  
    $in_num         = $_POST["form_in_num"];                //入数  
    $supplier_cd    = $_POST["form_supplier"]["cd"];        //仕入先コード
    $supplier_name  = $_POST["form_supplier"]["name"];      //仕入先コード
    $sale_manage    = $_POST["form_sale_manage"];           //販売管理
    $stock_manage   = $_POST["form_stock_manage"];          //在庫管理
    $stock_only     = $_POST["form_stock_only"];            //在庫限り品
    $order_point    = $_POST["form_order_point"];           //発注点
    $order_unit     = $_POST["form_order_unit"];            //発注単位数
    $lead           = $_POST["form_lead"];                  //リードタイム（日）
    $name_change    = $_POST["form_name_change"];           //品名変更
    $tax_div        = $_POST["form_tax_div"];               //課税区分
    $note           = $_POST["form_note"];                  //備考  
    $url            = $_POST["form_url"];                   //URL
    $mark_div       = $_POST["form_mark_div"];               //マーク

    //■仕入先
    //●必須チェック
    if($supplier_cd != null && $supplier_name == null){
        $form->setElementError("form_supplier", "正しい仕入先コードを入力して下さい。");
    }

    //URLチェック
    if(!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null){
        $form->setElementError("form_url","正しいURLを入力して下さい。");
    }

    if($head_flg != true){
        //●コード体系チェック
        if($goods_cd != null && (strlen($goods_cd) >= 8) && 
            substr($goods_cd, 0, 1) == 0){
            $form->setElementError("form_goods_cd","商品コードの上１桁は「０」以外です。");
        }

        //●商品コード空きチェック
        $goods_cd_sql  = " SELECT";
        $goods_cd_sql .= "     goods_cd";
        $goods_cd_sql .= " FROM";
        $goods_cd_sql .= "     t_goods";
        $goods_cd_sql .= " WHERE";
        $goods_cd_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $goods_cd_sql .= "     AND";
        $goods_cd_sql .= "     goods_cd = '$goods_cd'";
        $goods_cd_sql .= " ;";

        $result = Db_Query($conn, $goods_cd_sql) or die("クエリエラー");
        $goods_cd_res = @pg_fetch_result($result, 0,0);

        if($goods_cd_res != null && $get_flg != true){
            $form->setElementError("form_goods_cd","既に使用されている商品コードです。");
        }elseif($goods_cd_res != null && $get_flg == true && $get_goods_data[0] != $goods_cd_res){
            $form->setElementError("form_goods_cd","既に使用されている商品コードです。");
        }
    }

    /***************************/
    //検証
    /***************************/
    if($form->validate()){
 
        /***************************/
        //必須データ作成
        /***************************/
        $make_goods_flg = 0;                                    //製造品フラグ
        $public_flg     = 0;                                    //共有フラグ
        $compose_flg    = 0;                                    //構成品フラグ
        $head_fc_flg  = 0;                                    //本部識別フラグ

        /****************************/
        //nullに置き換え
        /****************************/
        if($order_point == null){
            $order_point = "null"; 
        }

        /****************************/
        //商品登録
        /****************************/
        //変更＆本部商品でない。

        Db_Query($conn, "BEGIN;");

        if($get_flg == true && $head_flg != true){
            //商品マスタ
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
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     stock_manage = '$stock_manage',";
            $goods_sql .= "     stock_only = '$stock_only',";
            $goods_sql .= "     url = '$url',";
            $goods_sql .= "     mark_div = '$mark_div', ";
            $goods_sql .= "     in_num = '$in_num' ";
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //商品マスタの変更を契約マスタに反映する
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }
        }

        //変更    
        if($get_flg == true){
            //ショップ別商品情報テーブル
            $goods_sql  = " UPDATE";
            $goods_sql .= "     t_goods_info";
            $goods_sql .= " SET";
            $goods_sql .= "     goods_id = $get_goods_id,";
            $goods_sql .= "     order_point = $order_point,";
            $goods_sql .= "     order_unit = '$order_unit',";
            $goods_sql .= "     lead = '$lead',";
            $goods_sql .= "     note = '$note',";
            #2009-10-08 hashimoto-y
            $goods_sql .= "     stock_manage = '$stock_manage',";

            //仕入先が指定されていた場合
            if($supplier_cd != null){
                $goods_sql .= "     supplier_id = (";
                $goods_sql .= "                 SELECT";
                $goods_sql .= "                     client_id";
                $goods_sql .= "                 FROM";
                $goods_sql .= "                     t_client";
                $goods_sql .= "                 WHERE";
                $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_cd1 = '$supplier_cd'";
                $goods_sql .= "                     AND";
                $goods_sql .= "                     client_div = '2'";
                $goods_sql .= "                 )";
            }else{
                $goods_sql .= "     supplier_id = null";
            }
            $goods_sql .= " WHERE";
            $goods_sql .= "     goods_id = $get_goods_id";
            $goods_sql .= "     AND";
            $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
            $goods_sql .= ";";

            $result = Db_Query($conn, $goods_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

			$sql  = "SELECT ";
			$sql .= "    goods_name ";
			$sql .= "FROM ";
			$sql .= "    t_goods ";
			$sql .= "WHERE ";
			$sql .= "    goods_id = $get_goods_id;";
			$result = Db_Query($conn, $sql); 
			$data_list = Get_Data($result,3);
			$goods_name = $data_list[0][0];

            $work_div = '2';


        }
    
        //新規登録
        if($get_flg != true){        
            //商品マスタ
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
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     stock_manage,";
            $goods_sql .= "     stock_only,";
            $goods_sql .= "     make_goods_flg,";
            $goods_sql .= "     public_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     state,";
            $goods_sql .= "     url,";
            $goods_sql .= "     mark_div, ";
            $goods_sql .= "     in_num,";
            $goods_sql .= "     accept_flg";
            $goods_sql .= " )VALUES (";
            $goods_sql .= "     (SELECT COALESCE(MAX(goods_id), 0)+1 FROM t_goods),";
            $goods_sql .= "     '$goods_cd',";
            $goods_sql .= "     '$goods_name',";
            $goods_sql .= "     '$goods_cname',";
            $goods_sql .= "     '$attri_div',";
            $goods_sql .= "     $product_id,";
			$goods_sql .= "     $g_product_id,";
            $goods_sql .= "     $g_goods_id,";
            $goods_sql .= "     '$unit',";
            $goods_sql .= "     '$tax_div',";
            $goods_sql .= "     '$name_change',";
            $goods_sql .= "     '$sale_manage',";
            #2009-10-08 hashimoto-y
            #$goods_sql .= "     '$stock_manage',";
            $goods_sql .= "     '$stock_only',";
            $goods_sql .= "     '$make_goods_flg',";
            $goods_sql .= "     '$public_flg',";
            $goods_sql .= "     $shop_id,";
            $goods_sql .= "     '$state',";
            $goods_sql .= "     '$url',";
            $goods_sql .= "     '$mark_div', ";
            $goods_sql .= "     '$in_num',";
            $goods_sql .= "     '1'";
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
            #2009-10-08 hashimoto-y
            $goods_sql .= "     stock_manage,";
            $goods_sql .= "     supplier_id,";
            $goods_sql .= "     compose_flg,";
            $goods_sql .= "     shop_id,";
            $goods_sql .= "     head_fc_flg";
            $goods_sql .= ") VALUES (";
            $goods_sql .= "     (SELECT";
            $goods_sql .= "         goods_id";
            $goods_sql .= "     FROM";
            $goods_sql .= "         t_goods";
            $goods_sql .= "     WHERE";
            $goods_sql .= "         goods_cd = '$goods_cd'";
            $goods_sql .= "         AND";
            $goods_sql .= "         shop_id = $shop_id";
            $goods_sql .= "     ),";
            $goods_sql .= "     $order_point,";
            $goods_sql .= "     '$order_unit',";
            $goods_sql .= "     '$lead',";
            $goods_sql .= "     '$note',";
            #2009-10-08 hashimoto-y
            $goods_sql .= "     '$stock_manage',";

            //仕入先が指定されていた場合
            if($supplier_cd != null){
                $goods_sql .= "     (";
                $goods_sql .= "      SELECT";
                $goods_sql .= "        client_id";
                $goods_sql .= "      FROM";
                $goods_sql .= "        t_client";
                $goods_sql .= "      WHERE";
                $goods_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_cd1 = '$supplier_cd'";
                $goods_sql .= "        AND";
                $goods_sql .= "        client_div = '2'";
                $goods_sql .= "    ),";
            }else{
                $goods_sql .= "null,";
            }
            $goods_sql .= "    '$compose_flg',";
            $goods_sql .= "    $shop_id,";
            $goods_sql .= "    '$head_fc_flg'";
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
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

// 選択された商品が本部商品の場合
if($get_goods_data[27] == 't'){
    // 商品コードフォームをフリーズ
    $head_item_form->freeze();
    // 仕入先リンクをスタティックに
    $form->addElement("static","form_client_link","","仕入先");
}


if($freeze_flg == true){
//    if($get_flg != true){
        /****************************/
        //GETデータ作成
        /****************************/
        $goods_id_sql  = "SELECT";
        $goods_id_sql .= "   goods_id";
        $goods_id_sql .= " FROM";
        $goods_id_sql .= "   t_goods";
        $goods_id_sql .= " WHERE";
        $goods_id_sql .= "  goods_cd = '$goods_cd'";
        $goods_id_sql .= "  AND (";
        $goods_id_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $goods_id_sql .= "  OR\n";
        $goods_id_sql .= "  public_flg ='t'\n";
        $goods_id_sql .= "  )";
        $goods_id_sql .= ";"; 

        $result = Db_Query($conn, $goods_id_sql);

        $get_goods_id = pg_fetch_result($result, 0);
//    }

    //遷移先判定
//    if($get_flg == true){
        $target = "./2-1-222.php?goods_id=".$get_goods_id;
//    }else{
//        $target = "./2-1-221.php";
//    }

    $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"javascript:location.href='$target'\"");
    $form->addElement("button","form_back_button","戻　る","onClick=\"location.href='./2-1-221.php?goods_id=$get_goods_id'\"");

    $form->addElement("static","form_client_link","","仕入先");
    $form->freeze();
    
}else{
    $form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled");
    $form->addElement(
        "button","form_show_dialog_button","登録済一覧確認",
        "onClick='javascript:showModelessDialog(\"../dialog/2-0-210-1.php\",window,\"status:false;dialogWidth:540px;dialogHeight:500px;edge:sunken;\")'
    ");
    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./2-1-221.php?goods_id=$next_id'\"");
    }else{  
        $form->addElement("button","next_button","次　へ","disabled");
    }
    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./2-1-221.php?goods_id=$back_id'\"");
    }else{  
        $form->addElement("button","back_button","前　へ","disabled");
    }
    if($get_goods_data[27] == 't'){
        //仕入先
        $form->addElement(
            "link","form_client_link","","#","仕入先",
            "onClick=\"return Open_SubWin('../dialog/2-0-208.php?head_flg=true', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
        );
       }else{
        //仕入先
   	    $form->addElement(
            "link","form_client_link","","#","仕入先",
            "onClick=\"return Open_SubWin('../dialog/2-0-208.php?head_flg=false', Array('form_supplier[cd]', 'form_supplier[name]'), 500, 450);\""
   	    );
    }
}
$form->addElement(
    "button","form_set_price_button","単価設定",
    "onClick='javascript:location.href = \"2-1-222.php?goods_id=$get_goods_id\"'
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
//$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(t_goods_info.goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods_info,";
$goods_sql .= "     t_goods";
$goods_sql .= " WHERE";
$goods_sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
$goods_sql .= " AND";
$goods_sql .= "     t_goods_info.goods_id = t_goods.goods_id";
$goods_sql .= " AND";
$goods_sql .= "     t_goods.accept_flg = '1'";
$goods_sql .= " AND";
$goods_sql .= "     t_goods.compose_flg = 'f'";
$goods_sql .= " AND";
$goods_sql .= "    (";
$goods_sql .= ($group_kind == "2") ? "     t_goods.state IN ('1', '3')" : "     t_goods.state = '1'";
$goods_sql .= "    OR";
$goods_sql .= "        (t_goods.state = '2' AND ";
$goods_sql .= ($group_kind == "2") ? "t_goods.shop_id IN (".Rank_Sql().")) " : " t_goods.shop_id = $shop_id) ";
$goods_sql .= "    )";
$goods_sql .= " AND ";
$goods_sql .= " length(t_goods.goods_cd) = 8";
$goods_sql .= " ;";


$result = Db_Query($conn,$goods_sql);
//全件数取得(ヘッダー)
$t_count = pg_fetch_result($result,0,0);

$goods_sql  = " SELECT";
$goods_sql .= "     COUNT(t_goods_info.goods_id)";
$goods_sql .= " FROM";
$goods_sql .= "     t_goods,";
$goods_sql .= "     t_goods_info";
$goods_sql .= " WHERE";
$goods_sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods_info.goods_id = t_goods.goods_id";
$goods_sql .= "     AND";
$goods_sql .= ($group_kind == "2") ? " t_goods.state IN (1,3)" : " t_goods.state = 1";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.compose_flg = 'f'";
$goods_sql .= "     AND";
$goods_sql .= "     t_goods.accept_flg = '1'";
$goods_sql .= " AND ";
$goods_sql .= " length(t_goods.goods_cd) = 8";
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
	'page_menu'             => "$page_menu",
	'page_header'           => "$page_header",
	'html_footer'           => "$html_footer",
    'head_flg'              => "$head_flg",
    'code_value'            => "$code_value",
    'buy_day'               => "$max_buy_day",
    'sale_day'              => "$max_sale_day",
	'get_goods_id'          => "$get_goods_id"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
