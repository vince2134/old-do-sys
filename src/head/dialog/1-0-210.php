<?php

/*************************
 * 変更履歴
 *  ・（2006-11-28）サニタイジング処理追加<suzuki>
 *  ・2007-05-31  rental の場合、商品分類IDを返すように変更<morita-d>
 *  ・2007-06-06  商品分類名のサニタイジング処理を追加<morita-d>
 *
 *
**************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/03      B0702-030   kajioka-h   case '4'（在庫移動入力）で無効商品が見えるバグ修正
 *                  B0702-031   kajioka-h   case '4'（在庫移動入力）で未承認商品が見えるバグ修正
 *  2009/10/08                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 */

session_start();

$page_title = "商品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$db_con = Db_Connect();

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];

//SQL識別番号
$display = $_GET['display'];
//倉庫ID or 棚卸調査ID or 仕入先ID
$select_id = $_GET['select_id'];
//ショップ識別ID
$shop_aid = $_GET['shop_aid'];

//ページ数
$f_page1   = $_POST[f_page1];

//更新フラグ
$renew_flg = $_POST[renew_flg];


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

if($_GET['shop_aid'] != NULL){
    $set_id_data["hdn_shop_aid"] = $shop_aid;
    $form->setConstants($set_id_data);
}else{
    $shop_aid = $_POST["hdn_shop_aid"];
}

/****************************/
// フォームパーツ定義
/****************************/
// 商品コード
$form->addElement("text", "form_goods_cd", "商品コード", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// 商品名
$form->addElement("text", "form_goods_name", "商品名", "size=\"34\" maxLength=\"30\" $g_form_option");

// 略称
$form->addElement("text", "form_goods_cname", "略称", "size=\"22\" maxLength=\"10\" $g_form_option");

// 管理区分
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product", "管理区分", $select_value, $g_form_option_select);

// Ｍ区分
$select_value = Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods", "Ｍ区分", $select_value, $g_form_option_select);

//商品分類
$select_value = Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "商品分類", $select_value, $g_form_option_select);

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// 閉じるボタン
$form->addElement("button", "form_close_button", "閉じる", "onClick=\"window.close()\"");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");
$form->addElement("hidden","hdn_shop_aid","","");
$form->addElement("hidden","renew_flg","1"); //画面更新フラグ

/****************************/
//検索条件取得
/****************************/

//WHERE文追加
$goods_cd    = $_POST["form_goods_cd"];
$goods_name  = $_POST["form_goods_name"];
$goods_cname = $_POST["form_goods_cname"];
$product     = $_POST["form_product"];
$g_goods     = $_POST["form_g_goods"];
$g_product   = $_POST["form_g_product"];

//商品コード指定
if($goods_cd != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_cd LIKE '$goods_cd%'";
}
//商品名指定
if($goods_name != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_name LIKE '%$goods_name%'";
}
//略称指定
if($goods_cname != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.goods_cname LIKE '%$goods_cname%'";
}
//管理区分指定
if($product != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.product_id = $product";
}
//Ｍ区分指定
if($g_goods != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.g_goods_id = $g_goods";
}
//商品分類
if($g_product != null){
    $where_sql .= "     AND";
    $where_sql .= "     t_goods.g_product_id = $g_product";
}

$sort_sql  = " ORDER BY goods_cd";
$sort_sql .= ";";


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
$page_header = Create_Header($page_title);

/******************************/
//表示ボタン押下処理
/*****************************/
//行データ識別
if ($renew_flg == "1"){
//if ($form->isSubmitted()){
	switch ($display){
	    case '1':    
	        //1-4-108.php 在庫調整入力
	        //戻り値、商品コード・商品名・現在庫数・引当数・単位
	
	        //条件無しSQL作成
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //商品コード
	        $goods_sql .= "     t_goods.goods_name,";                //商品名
	        $goods_sql .= "     t_goods.goods_cname,";               //略称
	        $goods_sql .= "     t_product.product_name,";            //管理区分
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //Ｍ区分
	        $goods_sql .= "     CASE t_goods.attri_div";             //属性区分
	        $goods_sql .= "         WHEN '1' THEN '製品'";
	        $goods_sql .= "         WHEN '2' THEN '部品'";
	        $goods_sql .= "         WHEN '3' THEN '部材'";
	        $goods_sql .= "         WHEN '4' THEN 'その他'";
	        $goods_sql .= "     END,";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_goods.unit,";                      //単位
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_goods.goods_id,";                   //商品ID
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM";
	        $goods_sql .= "    t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "     t_goods.stock_manage = '1'";
	        $goods_sql .= "     t_goods_info.stock_manage = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) ";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods_info.shop_id = $shop_id ";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES); 
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES); 
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES); 
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."',".$shop_aid;         
	        }
	
	        break;
	    case '2':
	        //1-4-204.php 棚卸入力
	/*
	 * 履歴：
	 *  日付            B票No.      担当者      内容
	 *  -----------------------------------------------------------
	 *  2006/12/07      12-008      kajioka-h   在庫管理しない、未承認、商品を表示しないように
	 */
	        //戻り値、商品コード・商品名・単位・在庫単価・帳簿数
	        
	        //条件無しSQL作成
	        //06-05-08 SQL変更（kajioka-h）
	        $goods_sql  = "SELECT ";
	        $goods_sql .= "    t_goods.goods_cd, ";
	        $goods_sql .= "    t_goods.goods_name, ";
	        $goods_sql .= "    t_goods.goods_cname, ";
	        $goods_sql .= "    t_product.product_name, ";
	        $goods_sql .= "    t_g_goods.g_goods_name, ";
	        $goods_sql .= "    CASE ";
	        $goods_sql .= "        t_goods.attri_div ";
	        $goods_sql .= "            WHEN '1' THEN '製品' ";
	        $goods_sql .= "            WHEN '2' THEN '部品' ";
	        $goods_sql .= "            WHEN '3' THEN '部材' ";
	        $goods_sql .= "            WHEN '4' THEN 'その他' ";
	        $goods_sql .= "    END, ";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM ";
	        $goods_sql .= "     t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE ";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "        t_goods.stock_manage = '1' ";
	        $goods_sql .= "        t_goods_info.stock_manage = '1'";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.accept_flg = '1' ";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.state IN ('1', '3') ";
	        $goods_sql .= "    AND ";
	        $goods_sql .= "        t_goods.shop_id = '1'";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    AND";
	        $goods_sql .= "    t_goods_info.shop_id = $shop_id ";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."','".$shop_aid."'";
	        }
	
	        break;
	    case '3':
	        //1-3-201.php 仕入入力
	        //戻り値、商品コード・商品名・現在庫数・発注数・仕入済数・仕入単価
	        //t_goods t_stock t_price 
	        break;
	    case 'true':
	        //1-4-107.php 在庫移動入力
	        //戻り値、商品コード・商品名・単位
	
	        //条件無しSQL作成
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //商品コード
	        $goods_sql .= "     t_goods.goods_name,";                //商品名
	        $goods_sql .= "     t_goods.goods_cname,";               //略称
	        $goods_sql .= "     t_product.product_name,";            //管理区分
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //Ｍ区分
	        $goods_sql .= "     CASE t_goods.attri_div";             //属性区分
	        $goods_sql .= "         WHEN '1' THEN '製品'";
	        $goods_sql .= "         WHEN '2' THEN '部品'";
	        $goods_sql .= "         WHEN '3' THEN '部材'";
	        $goods_sql .= "         WHEN '4' THEN 'その他'";
	        $goods_sql .= "     END,";
	        $goods_sql .= "     t_goods.unit, ";                       //単位
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_goods";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
            #2009-10-08 hashimoto-y
	        #$goods_sql .= "     t_goods.stock_manage = '1' ";
	        $goods_sql .= "     t_goods_info.stock_manage = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.state IN ('1', '3') ";
            #2009-10-08 hashimoto-y
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods_info.shop_id = $shop_id ";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][6] = htmlspecialchars($row[$i][6],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            //$return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."','".$row[$i][6]."'";
	            $return_data[$i] = "'".$row[$i][0]."','".$shop_aid."'";
	        }
	        break;
	    case '5':
	        //1-3-102.php 発注入力
	        //戻り値、商品コード
	
	        //条件無しSQL作成
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //商品コード
	        $goods_sql .= "     t_goods.goods_name,";                //商品名
	        $goods_sql .= "     t_goods.goods_cname,";               //略称
	        $goods_sql .= "     t_product.product_name,";            //管理区分
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //Ｍ区分
	        $goods_sql .= "     CASE t_goods.attri_div";             //属性区分
	        $goods_sql .= "         WHEN '1' THEN '製品'";           
	        $goods_sql .= "         WHEN '2' THEN '部品'";           
	        $goods_sql .= "         WHEN '3' THEN '部材'";           
	        $goods_sql .= "         WHEN '4' THEN 'その他'";         
	        $goods_sql .= "     END, ";                               
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_price";
	        $goods_sql .= "    INNER JOIN t_goods ON t_price.goods_id = t_goods.goods_id";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_price.shop_id = $shop_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_price.rank_cd = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.state <> '2'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.accept_flg = '1'";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.compose_flg = 'f'";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	            $return_data[] = "'".$row[$i][0]."',".$shop_aid;
	        }
	        break;
	    case "7":
	        //1-4-109.php 商品組立
	        //戻り値、商品コード・商品名
	
	        //条件無しSQL作成
	        $goods_sql  = "SELECT\n";
	        $goods_sql .= " t_goods.goods_cd,\n";
	        $goods_sql .= " t_goods.goods_name,\n";
	        $goods_sql .= " t_goods.goods_cname,\n";
	        $goods_sql .= " t_product.product_name,\n";
	        $goods_sql .= " t_g_goods.g_goods_name,\n";
	        $goods_sql .= " CASE t_goods.attri_div\n";
	        $goods_sql .= "     WHEN '1' THEN '製品'\n";
	        $goods_sql .= "     WHEN '2' THEN '部品'\n";
	        $goods_sql .= "     WHEN '3' THEN '部材'\n";
	        $goods_sql .= "     WHEN '4' THEN 'その他'\n";
	        $goods_sql .= " END,\n";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM\n";
	        $goods_sql .= "    t_goods \n";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE\n";
	        $goods_sql .= "    t_goods.shop_id = 1\n";
	        $goods_sql .= " AND\n";
	        $goods_sql .= "    t_goods.make_goods_flg = 't'\n";
	        $goods_sql .= " AND\n";
	        $goods_sql .= "    t_goods.no_change_flg = 'f'\n";
	        
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            $return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."'";
	        }
	        break;
	    case 'rental':    
	
	        //1-2-132.php レンタルTOレンタル
	        //戻り値、商品コード
	
	        //条件無しSQL作成
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //商品コード
	        $goods_sql .= "     t_goods.goods_name,";                //商品名
	        $goods_sql .= "     t_goods.goods_cname,";               //略称
	        $goods_sql .= "     t_product.product_name,";            //管理区分
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //Ｍ区分
	        $goods_sql .= "     CASE t_goods.attri_div";             //属性区分
	        $goods_sql .= "         WHEN '1' THEN '製品'";           
	        $goods_sql .= "         WHEN '2' THEN '部品'";           
	        $goods_sql .= "         WHEN '3' THEN '部材'";           
	        $goods_sql .= "         WHEN '4' THEN 'その他'";         
	        $goods_sql .= "     END, ";
	        $goods_sql .= "   t_goods.goods_id,";                    //商品ID
	        $goods_sql .= "   t_price.r_price, ";                    //レンタル単価
	        //$goods_sql .= "   t_g_product.g_product_name || '　' || t_goods.goods_name, "; //商品分類名　商品名
	        $goods_sql .= "   t_goods.goods_name, "; //商品分類名　商品名
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name, ";
	        $goods_sql .= "     t_g_product.g_product_id ";
	                               
	        $goods_sql .= " FROM";
	        $goods_sql .= "   t_goods ";
	
	        $goods_sql .= "   INNER JOIN  t_price ON t_goods.goods_id = t_price.goods_id";
	        $goods_sql .= "   INNER JOIN  t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id";
	        $goods_sql .= "   INNER JOIN  t_product ON t_goods.product_id = t_product.product_id";
	        $goods_sql .= "   INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
	
	        $goods_sql .= " WHERE";
	        $goods_sql .= "   t_price.shop_id = 1 ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_price.rank_cd = '5' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.accept_flg = '1' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.rental_flg = 't' ";
	        $goods_sql .= " AND ";
	        $goods_sql .= "   t_goods.state = 1 ";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	
	            $row[$i][8] = addslashes($row[$i][8]);
	            $row[$i][8] = htmlspecialchars($row[$i][8],ENT_QUOTES);
	            $row[$i][12] = addslashes($row[$i][12]);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	
	            //返り値（商品ID,商品CD,商品名,レンタル単価）
	            $price = explode('.',$row[$i][7]);
              $return_data[$i] = "'".$row[$i][6]."','".$row[$i][0]."','".$row[$i][8]."','"
             .$price[0]."','".$price[1]."','".$price[0]."','".$price[1]."','".$row[$i][12]."'";
	
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	
	       }
	        break;
	    default:
	        //戻り値、商品コード・商品名
	
	        //条件無しSQL作成
	/*
	        $goods_sql  = " SELECT";
	        $goods_sql .= "     t_goods.goods_cd,";                  //商品コード
	        $goods_sql .= "     t_goods.goods_name,";                //商品名
	        $goods_sql .= "     t_goods.goods_cname,";               //略称
	        $goods_sql .= "     t_product.product_name,";            //管理区分
	        $goods_sql .= "     t_g_goods.g_goods_name,";            //Ｍ区分
	        $goods_sql .= "     CASE t_goods.attri_div";             //属性区分
	        $goods_sql .= "         WHEN '1' THEN '製品'";
	        $goods_sql .= "         WHEN '2' THEN '部品'";
	        $goods_sql .= "         WHEN '3' THEN '部材'";
	        $goods_sql .= "         WHEN '4' THEN 'その他'";
	        $goods_sql .= "     END";
	        $goods_sql .= " FROM";
	        $goods_sql .= "     t_goods,";
	        $goods_sql .= "     t_g_goods,";
	        $goods_sql .= "     t_product";
	        $goods_sql .= " WHERE";
	        $goods_sql .= "     t_goods.product_id = t_product.product_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.g_goods_id = t_g_goods.g_goods_id";
	        $goods_sql .= "     AND";
	        $goods_sql .= "     t_goods.public_flg = 't' ";
	*/
	        $goods_sql  = "SELECT\n";
	        $goods_sql .= " t_goods.goods_cd,\n";
	        $goods_sql .= " t_goods.goods_name,\n";
	        $goods_sql .= " t_goods.goods_cname,\n";
	        $goods_sql .= " t_product.product_name,\n";
	        $goods_sql .= " t_g_goods.g_goods_name,\n";
	        $goods_sql .= " CASE t_goods.attri_div\n";
	        $goods_sql .= "     WHEN '1' THEN '製品'\n";
	        $goods_sql .= "     WHEN '2' THEN '部品'\n";
	        $goods_sql .= "     WHEN '3' THEN '部材'\n";
	        $goods_sql .= "     WHEN '4' THEN 'その他'\n";
	        $goods_sql .= " END,\n";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     '',";
	        $goods_sql .= "     t_g_product.g_product_name ";
	        $goods_sql .= " FROM\n";
	        $goods_sql .= "    t_goods \n";
	        $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
	        $goods_sql .= "    INNER JOIN t_g_goods   ON t_goods.g_goods_id   = t_g_goods.g_goods_id \n";
	        $goods_sql .= "    INNER JOIN t_product   ON t_goods.product_id   = t_product.product_id \n";
	        $goods_sql .= " WHERE\n";
	        $goods_sql .= "    t_goods.public_flg = 't'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.accept_flg = '1'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.compose_flg = 'f'\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.state IN (1,3)\n";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    t_goods.no_change_flg = 'f'";
	        $goods_sql .= "    AND\n";
	        $goods_sql .= "    goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) ";
	
	        //WHERE文追加
	        $goods_sql .= $where_sql;
	        //ソート文追加
	        $goods_sql .= $sort_sql;
	
	        $result = Db_Query($db_con, $goods_sql);
	        //件数取得
	        $total_count = pg_num_rows($result);
	        //戻り値作成
	        for($i = 0; $i < $total_count; $i++){
	            $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
	            $single = addslashes($row[$i][1]);
	            $return_data[$i] = "'".$row[$i][0]."','".htmlspecialchars($single)."'";
	            $row[$i][1] = htmlspecialchars($row[$i][1],ENT_QUOTES);
	            $row[$i][2] = htmlspecialchars($row[$i][2],ENT_QUOTES);
	            $row[$i][3] = htmlspecialchars($row[$i][3],ENT_QUOTES);
	            $row[$i][4] = htmlspecialchars($row[$i][4],ENT_QUOTES);
	            $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
	        }	
	}
}


/****************************/
// ページ作成処理
/****************************/

//一覧表示処理
//if ($form->isSubmitted()){
if ($renew_flg == "1"){

	$range = 100; //1ページあたりの表示件数

	//現在のページ数をチェックする
	$page_info = Check_Page($total_count, $range, $f_page1);
	$page      = $page_info[0]; //現在のページ数
	$page_snum = $page_info[1]; //表示開始件数
	$page_enum = $page_info[2]; //表示終了件数

	//ページプルダウン表示判定
	if($page == 1){
		//ページ数が１ならページプルダウンを非表示
		$page = NULL;
	}

	//ページ作成
	$html_page  = Html_Page($total_count,$page,1,$range);
	$html_page2 = Html_Page($total_count,$page,2,$range);

}

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'    => "$html_header",
    'page_menu'      => "$page_menu",
    'page_header'    => "$page_header",
    'html_footer'    => "$html_footer",
    'total_count'   => "$total_count",
    'html_page'      => "$html_page",
    'html_page2'     => "$html_page2",
    'page_snum'      => "$page_snum",
    'page_enum'      => "$page_enum",

));

$smarty->assign('page_data', $row);
$smarty->assign('return_data', $return_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
