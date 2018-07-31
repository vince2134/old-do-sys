<?php
/*************************
 * 変更履歴
 *  ・2006/08/03  case3のsqlを作成<watanabe-k>
 *    2006/10/18  case7のsqlを変更<suzuki-t>
 *  ・2006/11/11  case6・7のsqlを変更<suzuki-t>
 *  ・2006/11/16  case6・7　構成品の子に単価が設定されていない商品は表示しない<suzuki-t>
 *  ・2006-11-28  サニタイジング処理追加<suzuki>
 *  ・2007-05-31  rental の場合、商品分類IDを返すように変更<morita-d>
 *  ・2007-06-06  商品分類名のサニタイジング処理を追加<morita-d>
 *
 *
**************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-10      03-081      suzuki      代行伝票の際には、状態が有効の商品のみ使用可
 *  2007/04/02      B0702-021   kajioka-h   case 'true'（在庫移動入力）でFCで直営のみ有効商品が見えるバグ修正
 *                  B0702-022   kajioka-h   case 'true'（在庫移動入力）で未承認商品が見えるバグ修正
 *                  B0702-025   kajioka-h   case 'true'（在庫移動入力）で在庫管理しない商品が見えるバグ修正
 *                  B0702-027   kajioka-h   case '1'（在庫調整入力）で未承認商品が見えるバグ修正
 *  2007/08/02                  watanabe-k  case '5 '顧客区分コードが特殊の場合のみ本部商品とFC商品が選べるように修正
 *  2009/10/09                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *
*/
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
//session_start();
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$rank_cd    = $_SESSION["rank_cd"];

//SQL識別番号
$display   = $_GET['display'];
//倉庫ID or 棚卸調査ID or 仕入先ID
$select_id = $_GET['select_id'];
//ショップ識別ID
$shop_aid  = $_GET['shop_aid'];
//本部識別フラグ
$head_flg  = $_GET['head_flg'];

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

if($_GET['head_flg'] != NULL){
    $set_id_data["hdn_head_flg"] = $head_flg;
    $form->setConstants($set_id_data);
}else{
    $head_flg = $_POST["hdn_head_flg"];
}
/****************************/
//フォーム作成
/***************************/

//商品コード
$form->addElement("text","form_goods_cd","テキストフォーム","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");

//商品名
$form->addElement("text","form_goods_name","テキストフォーム",'size="34" maxLength="30" onFocus="onForm(this)" onBlur="blurForm(this)"');

//略称
$form->addElement("text","form_goods_cname","テキストフォーム",'size="22" maxLength="10" onFocus="onForm(this)" onBlur="blurForm(this)"');

//管理区分
$select_value = Select_Get($db_con,'product');
$form->addElement('select', 'form_product','セレクトボックス', $select_value,$g_form_option_select);

//Ｍ区分
$select_value = Select_Get($db_con,'g_goods');
$form->addElement('select', 'form_g_goods','セレクトボックス', $select_value,$g_form_option_select);

//商品分類
$select_value = Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "商品分類", $select_value, $g_form_option_select);

//ボタン
$form->addElement("submit","form_show_button","表　示");
$form->addElement("button","form_close_button","閉じる","onClick=\"window.close()\"");

//GETの値を保持する
$form->addElement("hidden","hdn_display","","");
$form->addElement("hidden","hdn_select_id","","");
$form->addElement("hidden","hdn_shop_aid","","");
$form->addElement("hidden","hdn_head_flg","","");
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

    switch ($display){
        case '1':    
            //2-4-108.php 在庫調整入力
            //戻り値、商品コード・商品名・現在庫数・引当数・単位・現在庫数・引当数
    
            //条件無しSQL作成
            $goods_sql  = " SELECT";
            $goods_sql .= "     t_goods.goods_cd,";                 //商品コード
            $goods_sql .= "     t_goods.goods_name,";               //商品名
            $goods_sql .= "     t_goods.goods_cname,";              //略称
            $goods_sql .= "     t_product.product_name,";           //管理区分
            $goods_sql .= "     t_g_goods.g_goods_name,";           //Ｍ区分
            $goods_sql .= "     CASE t_goods.attri_div";            //属性区分
            $goods_sql .= "         WHEN '1' THEN '製品'";
            $goods_sql .= "         WHEN '2' THEN '部品'";
            $goods_sql .= "         WHEN '3' THEN '部材'";
            $goods_sql .= "         WHEN '4' THEN 'その他'";
            $goods_sql .= "     END,";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_goods.unit,";                     //単位
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_goods.goods_id,";
            $goods_sql .= "     t_g_product.g_product_name";
            $goods_sql .= " FROM";
            $goods_sql .= "     t_goods";
            $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $goods_sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $goods_sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            #2009-10-09 hashimoto-y
            $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

            $goods_sql .= " WHERE";
            #2009-10-09 hashimoto-y
            #$goods_sql .= "     t_goods.stock_manage = '1'";
            $goods_sql .= "     t_goods_info.stock_manage = '1'";
            $goods_sql .= "     AND \n";
            $goods_sql .= "     t_goods.accept_flg = '1' \n";
            if($group_kind == "2"){
                //$goods_sql .= "     AND \n";
                //$goods_sql .= "     t_goods.state IN ('1', '3') \n";
                $goods_sql .= "";
            }else{
                $goods_sql .= "     AND \n";
                //$goods_sql .= "     t_goods.state = '1' \n";
                $goods_sql .= "     t_goods.state IN ('1', '2') \n";
            }
    
            $goods_sql .= "     AND\n";
            $goods_sql .= "     (t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1')";
            $goods_sql .= "     OR\n";
            $goods_sql .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '$rank_cd' AND ";
            $goods_sql .= "     shop_id = $shop_id";
            $goods_sql .= "     ))\n";
            #2009-10-09 hashimoto-y
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
                $row[$i][1]  = htmlspecialchars($row[$i][1],ENT_QUOTES);
                $row[$i][2]  = htmlspecialchars($row[$i][2],ENT_QUOTES);
                $row[$i][3]  = htmlspecialchars($row[$i][3],ENT_QUOTES);
                $row[$i][4]  = htmlspecialchars($row[$i][4],ENT_QUOTES);
                $row[$i][5]  = htmlspecialchars($row[$i][5],ENT_QUOTES);
                $row[$i][6]  = htmlspecialchars($row[$i][6],ENT_QUOTES);
                $row[$i][7]  = htmlspecialchars($row[$i][7],ENT_QUOTES);
                $row[$i][8]  = htmlspecialchars($row[$i][8],ENT_QUOTES);
                $row[$i][9]  = htmlspecialchars($row[$i][9],ENT_QUOTES);
                $row[$i][10] = htmlspecialchars($row[$i][10],ENT_QUOTES);
                $row[$i][12] = htmlspecialchars($row[$i][12],ENT_QUOTES);
                $return_data[$i] = "'".$row[$i][0]."',".$shop_aid;
            }
            break;
        case '2':
    /*
     * 履歴：
     *  日付            B票No.      担当者      内容
     *  -----------------------------------------------------------
     *  2006/12/07      12-008      kajioka-h   在庫管理しない、未承認、商品を表示しないように
     */
            //2-4-204.php 棚卸入力
            //戻り値、商品コード・商品名・単位・在庫単価・帳簿数
            
            //条件無しSQL作成
            $goods_sql  = "SELECT \n";
            $goods_sql .= "    t_goods.goods_cd, \n";                   //商品コード
            $goods_sql .= "    t_goods.goods_name, \n";                 //商品名
            $goods_sql .= "    t_goods.goods_cname, \n";                //略称
            $goods_sql .= "    t_product.product_name, \n";             //管理区分
            $goods_sql .= "    t_g_goods.g_goods_name, \n";             //Ｍ区分
            $goods_sql .= "    CASE t_goods.attri_div \n";              //属性区分
            $goods_sql .= "        WHEN '1' THEN '製品' \n";
            $goods_sql .= "        WHEN '2' THEN '部品' \n";
            $goods_sql .= "        WHEN '3' THEN '部材' \n";
            $goods_sql .= "        WHEN '4' THEN 'その他' \n";
            $goods_sql .= "    END, \n";
            $goods_sql .= "    t_goods.unit, \n";                       //単位
            $goods_sql .= "    t_price.r_price, \n";                    //在庫単価
            //$goods_sql .= "    t_contents.stock_num \n";                //帳簿数
            $goods_sql .= "    NULL, \n";                //帳簿数
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_g_product.g_product_name ";
    
            $goods_sql .= "FROM \n";
            $goods_sql .= "    t_goods \n";
            $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $goods_sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";
            if($group_kind == "2"){
                $goods_sql .= "        AND t_goods_info.shop_id IN (".Rank_Sql().") \n";
            }else{
                $goods_sql .= "        AND t_goods_info.shop_id = $shop_id \n";
            }
            $goods_sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $goods_sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $goods_sql .= "    INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id \n";
            $goods_sql .= "        AND t_price.rank_cd = '3' \n";

            //$goods_sql .= "    t_contents \n";
            $goods_sql .= "WHERE \n";
    /*
            $goods_sql .= "    t_goods.goods_id = t_goods_info.goods_id \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_goods.product_id = t_product.product_id \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_goods.goods_id = t_price.goods_id \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_goods.goods_id = t_contents.goods_id \n";
            $goods_sql .= "    AND \n";
    */
            #2009-10-09 hashimoto-y
            #$goods_sql .= "    t_goods.stock_manage = '1' \n";
            $goods_sql .= "     t_goods_info.stock_manage = '1'";

            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_goods.accept_flg = '1' \n";
            $goods_sql .= "    AND \n";
            if($group_kind == "2"){
                $goods_sql .= "    t_goods.state IN ('1', '3') \n";
                $goods_sql .= "    AND \n";
                $goods_sql .= "    t_price.shop_id IN (".Rank_Sql().") \n";
            }else{
                $goods_sql .= "    t_goods.state = '1' \n";
                $goods_sql .= "    AND \n";
                $goods_sql .= "    t_price.shop_id = $shop_id \n";
            }

    /*
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_price.rank_cd = '3' \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= "    t_contents.invent_id = $select_id \n";
            $goods_sql .= "    AND \n";
            $goods_sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
            $goods_sql .= "     AND";
            $goods_sql .= "     t_goods_info.head_fc_flg = 'f' ";
    */
    
            //WHERE文追加
            $goods_sql .= $where_sql;
            //ソート文追加
            $goods_sql .= $sort_sql;
    
            $result = Db_Query($db_con, $goods_sql);
            //件数取得
            $total_count = pg_num_rows($result);
    
            for($i = 0; $i < $total_count; $i++){
                $row[] = @pg_fetch_array ($result, $i, PGSQL_NUM);
                $row[$i][1]  = htmlspecialchars($row[$i][1],ENT_QUOTES);
                $row[$i][2]  = htmlspecialchars($row[$i][2],ENT_QUOTES);
                $row[$i][3]  = htmlspecialchars($row[$i][3],ENT_QUOTES);
                $row[$i][4]  = htmlspecialchars($row[$i][4],ENT_QUOTES);
                $row[$i][12]  = htmlspecialchars($row[$i][12],ENT_QUOTES);
            }
    
            for($i = 0; $i < $total_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    //商品コード
                    if($j==0){
                        $return = "'".$row[$i][$j]."'";
    /*
                    //商品名は'が入力される可能性がある為
                    }else if($j==1){
                        $single = addslashes($row[$i][$j]);
                        $return = $return.",'".$single."'";
                    }
                    //単位・帳簿数
                    if($j==6 || $j==8){
                        $return = $return.",'".$row[$i][$j]."'";
                    //在庫単価
                    }else if($j==7){
                        $num = explode(".", $row[$i][$j]);
                        $return = $return.",'".$num[0]."','".$num[1]."'";
                    }else{
                        //$row[$i][$j] = htmlspecialchars($row[$i][$j],ENT_QUOTES);
                        $row[$i][$j] = $row[$i][$j];
    */
                    }
                    $return .= ",$shop_aid";
                }
                $return_data[] = $return;
            }
    
            break;
        case 'true':
            //2-3-201.php 仕入入力は case '5'
            //戻り値、商品コード・商品名・現在庫数・発注数・仕入済数・仕入単価・発注残
            //t_goods t_stock t_stock_hand t_ware t_order_d t_buy_d t_price
            //本部との違い、FC区分コード・仕入先が本部なら、共有フラグがt  FCならFCグループ  FCの仕入先だけが、一覧に本部とFCがある
            //条件無しSQL作成
    
            //case3を新規作成
            //在庫移動入力で使用
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
            $goods_sql .= "     INNER JOIN t_goods     ON t_price.goods_id   = t_goods.goods_id";
            $goods_sql .= "     INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $goods_sql .= "     INNER JOIN t_g_goods   ON t_goods.g_goods_id = t_g_goods.g_goods_id";
            $goods_sql .= "     INNER JOIN t_product   ON t_goods.product_id = t_product.product_id";
            #2009-10-09 hashimoto-y
            $goods_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
    
            $goods_sql .= " WHERE ";
            $goods_sql .= "     t_price.rank_cd = ";
            $goods_sql .= ($head_flg == "t") ? " '$_SESSION[rank_cd]' " : " '1' ";
            $goods_sql .= ($head_flg == "f") ? "AND t_price.shop_id = $_SESSION[client_id] " : null;
            $goods_sql .= "AND t_price.r_price IS NOT NULL ";
            $goods_sql .= "AND t_goods.compose_flg = 'f' ";

            #2009-10-09 hashimoto-y
            #$goods_sql .= "AND t_goods.stock_manage = '1' ";
            $goods_sql .= "AND t_goods_info.stock_manage = '1'";

            $goods_sql .= "AND t_goods.accept_flg = '1' ";
            //直営は「有効」と「直営のみ有効」の商品
            if($group_kind == 2){
                $goods_sql .= "AND t_goods.state IN ('1', '3') \n";
            //FCは「有効」商品のみ
            }else{
                $goods_sql .= "AND t_goods.state = '1' \n";
            }

            #2009-10-09 hashimoto-y
            $goods_sql .= "     AND";
            $goods_sql .= "     t_goods_info.shop_id = $shop_id ";


            //WHERE文追加
            $goods_sql .= $where_sql;
            //ソート文追加
            $goods_sql .= $sort_sql;
    
            $result = Db_Query($db_con, $goods_sql);        //件数取得
            $total_count = pg_num_rows($result);
    
            for($i = 0; $i < $total_count; $i++){
                $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
                $row[$i][1] = htmlspecialchars($row[$i][1]);
                $row[$i][2] = htmlspecialchars($row[$i][2]);
                $row[$i][3] = htmlspecialchars($row[$i][3]);
                $row[$i][4] = htmlspecialchars($row[$i][4]);
                $row[$i][12] = htmlspecialchars($row[$i][12]);
                $return_data[$i] = "'".$row[$i][0]."',".$shop_aid;
            }
    
            break;
        case '5':
            //2-3-102.php 発注入力
            //戻り値、商品コード
    
            //$select_id = 92; //仕入先本部
            //本部フラグ取得SQL
            $head_sql  = " SELECT";
            $head_sql .= "     head_flg, ";
            $head_sql .= "     client_div";
            $head_sql .= " FROM";
            $head_sql .= "     t_client";
            $head_sql .= " WHERE";
            $head_sql .= "     client_id = $select_id;";
            $result = Db_Query($db_con, $head_sql);
            $head_flg   = pg_fetch_result($result,0,0);
            $client_div = pg_fetch_result($result,0,1);
    
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
            $goods_sql .= "     INNER JOIN t_goods     ON t_price.goods_id   = t_goods.goods_id";
            $goods_sql .= "     INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $goods_sql .= "     INNER JOIN t_g_goods   ON t_goods.g_goods_id = t_g_goods.g_goods_id";
            $goods_sql .= "     INNER JOIN t_product   ON t_goods.product_id = t_product.product_id";
    
            $goods_sql .= " WHERE ";

            if($_SESSION["rank_cd"] == "0055"){
                $goods_sql .= "     CASE t_goods.public_flg";
                $goods_sql .= "         WHEN 't' THEN t_price.rank_cd = '$rank_cd' ";
                $goods_sql .= "         WHEN 'f' THEN t_price.rank_cd = '1' AND t_price.shop_id = $shop_id ";
                $goods_sql .= "     END ";
            }else{
                $goods_sql .= "     t_price.rank_cd = ";
                $goods_sql .= ($head_flg == "t" || $client_div == '3') ? " '$_SESSION[rank_cd]' " : " '1' ";
                $goods_sql .= ($head_flg == "f" && $client_div == '2') ? "AND t_price.shop_id = $_SESSION[client_id] " : null;
            }

            $goods_sql .= "AND t_price.r_price IS NOT NULL ";
            $goods_sql .= "AND t_goods.state       <> 2 ";
            $goods_sql .= "AND t_goods.accept_flg  = '1' ";
            $goods_sql .= "AND t_goods.compose_flg = 'f' ";
           
            //WHERE文追加
            $goods_sql .= $where_sql;
            //ソート文追加
            $goods_sql .= $sort_sql;
    
            $result = Db_Query($db_con, $goods_sql);
            //件数取得
            $total_count = pg_num_rows($result);
            for($i = 0; $i < $total_count; $i++){
                $row[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
                $row[$i][1] = htmlspecialchars($row[$i][1]);
                $row[$i][2] = htmlspecialchars($row[$i][2]);
                $row[$i][3] = htmlspecialchars($row[$i][3]);
                $row[$i][4] = htmlspecialchars($row[$i][4]);
                $row[$i][12] = htmlspecialchars($row[$i][12]);
    
                $return_data[$i] = "'".$row[$i][0]."',".$shop_aid;
            }
    
            break;
        case '6':    //アイテム・消耗品
        case '7':    //本体商品
    
            //2-1-104.php 契約マスタ
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
            $goods_sql .= "     t_goods.goods_id, ";                 //商品ID
            $goods_sql .= "     t_goods.compose_flg, ";               //構成品フラグ
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_g_product.g_product_name ";
                                   
            $goods_sql .= " FROM\n";
            $goods_sql .= "   t_goods \n";

            $goods_sql .= "     INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            //$goods_sql .= "   INNER JOIN  t_price ON t_goods.goods_id = t_price.goods_id\n";
            $goods_sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id \n\n";
            $goods_sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n\n";
    
            $goods_sql .= "     INNER JOIN  t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id\n";
            $goods_sql .= "     INNER JOIN  t_product ON t_goods.product_id = t_product.product_id\n";
    
            $goods_sql .= " WHERE\n";
            //$goods_sql .= ($group_kind == "2") ? " t_price.shop_id IN (".Rank_Sql().") " : " t_price.shop_id = $select_id \n";
    
            //直営判定
            if($group_kind == "2"){
                //直営
                $goods_sql .= "     initial_cost.shop_id IN (".Rank_Sql().") \n";
            }else{
                //FC
                $goods_sql .= "     initial_cost.shop_id = $select_id  \n\n";
            }
            $goods_sql .= " AND  \n\n";
            //直営判定
            if($group_kind == "2"){
                //直営
            $goods_sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")) \n\n";
            }else{
                //FC
            $goods_sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $select_id) \n\n";
            }
    
            //本体商品の場合は、構成品を表示させない
            if($display == '7'){
                $goods_sql .= " AND \n";
                $goods_sql .= "       t_goods.compose_flg = 'f' \n";
            }
            //$goods_sql .= " AND ";
            //$goods_sql .= "       t_price.rank_cd = '2' ";
            $goods_sql .= " AND  \n";
            $goods_sql .= "     initial_cost.rank_cd = '2'  \n";
            $goods_sql .= " AND  \n";
            $goods_sql .= "     sale_price.rank_cd = '4' \n";
            //契約区分がオンライン・オフライン代行の場合は、本部商品だけを表示
            if($head_flg == 'true'){
                $goods_sql .= " AND";
                $goods_sql .= "       t_goods.public_flg = 't' ";
            }
            $goods_sql .= " AND ";
            $goods_sql .= " t_goods.accept_flg = '1'";
            $goods_sql .= " AND ";
            $goods_sql .= ($group_kind == "2" && $head_flg != 'true') ? " t_goods.state IN (1,3) " : " t_goods.state = 1 ";
    
            //WHERE文追加
            $goods_sql .= $where_sql;
    
    /*
     * 履歴：
     * 　日付　　　　B票No.　　　　担当者　　　内容　
     * 　2006/10/18　0185　　　　　suzuki-t　　本体商品は構成品を非表示に変更
     *
     */
    
            //アイテム・消耗品判定
            if($display == '6'){
                $goods_sql .= " UNION ";
                $goods_sql .= " SELECT";
                $goods_sql .= "     t_goods.goods_cd,";
                $goods_sql .= "     t_goods.goods_name,";
                $goods_sql .= "     t_goods.goods_cname,";
                $goods_sql .= "     '',";
                $goods_sql .= "     '',";
                $goods_sql .= "     '',";
                $goods_sql .= "     t_goods.goods_id, ";
                $goods_sql .= "     t_goods.compose_flg, ";                              
                $goods_sql .= "     '',";
                $goods_sql .= "     '',";
                $goods_sql .= "     '',";
                $goods_sql .= "     '',";
                $goods_sql .= "     ''";
    
                $goods_sql .= " FROM";
                $goods_sql .= "     t_goods";
                $goods_sql .= " WHERE";
                $goods_sql .= "     t_goods.compose_flg = 't'";
    
                //商品コード指定
                if($goods_cd != null){
                    $goods_sql .= "     AND";
                    $goods_sql .= "     t_goods.goods_cd LIKE '$goods_cd%'";
                }
                //商品名指定
                if($goods_name != null){
                    $goods_sql .= "     AND";
                    $goods_sql .= "     t_goods.goods_name LIKE '%$goods_name%'";
                }
                //略称指定
                if($goods_cname != null){
                    $goods_sql .= "     AND";
                    $goods_sql .= "     t_goods.goods_cname LIKE '%$goods_cname%'";
                }
                //商品分類
                if($g_product != null){
                    $goods_sql .= "     AND";
                    $goods_sql .= "     t_goods.g_product_id = $g_product";
                }
            }
    
            //ソート文追加
            $goods_sql .= $sort_sql;

            $result = Db_Query($db_con, $goods_sql);
            //件数取得
            $total_count = pg_num_rows($result);
    
            $null_num = 0;  //表示しない構成品を考慮するための調整数
            for($i = 0; $i < $total_count; $i++){
                $row[$i-$null_num] = @pg_fetch_array ($result, $i, PGSQL_NUM);
    
                //構成品判定
                if($row[$i-$null_num][7] == 't'){
                    //構成品
    
                    //構成品の子の商品情報取得
                    $sql  = "SELECT ";
                    $sql .= "    parts_goods_id ";                       //構成品ID
                    $sql .= "FROM ";
                    $sql .= "    t_compose ";
                    $sql .= "WHERE ";
                    $sql .= "    goods_id = ".$row[$i-$null_num][6].";";
                    $result_p = Db_Query($db_con, $sql);
                    $goods_parts = Get_Data($result_p);
    
                    $reset_goods_flg = false;   //表示する
                    for($j=0;$j<count($goods_parts);$j++){
                        $sql  = " SELECT ";
                        $sql .= "     t_compose.count,";                       //数量
                        $sql .= "     initial_cost.r_price AS initial_price,"; //営業単価
                        $sql .= "     sale_price.r_price AS sale_price, ";     //売上単価
                        $sql .= "     buy_price.r_price AS buy_price  ";       //仕入単価
                                         
                        $sql .= " FROM";
                        $sql .= "     t_compose ";
    
                        $sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                        $sql .= "     INNER JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
                        $sql .= "     INNER JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";
                        $sql .= "     INNER JOIN t_price AS buy_price ON t_goods.goods_id = buy_price.goods_id";
    
                        $sql .= " WHERE";
                        $sql .= "     t_compose.goods_id = ".$row[$i-$null_num][6];
                        $sql .= " AND ";
                        $sql .= "     t_compose.parts_goods_id = ".$goods_parts[$j][0];
                        $sql .= " AND ";
                        $sql .= "     initial_cost.rank_cd = '2' ";
                        $sql .= " AND ";
                        $sql .= "     sale_price.rank_cd = '4'";
                        $sql .= " AND ";
                        $sql .= "     buy_price.rank_cd = '2' ";
                        $sql .= " AND ";
                        //直営判定
                        if($_SESSION[group_kind] == "2"){
                            //直営
                            $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
                        }else{
                            //FC
                            $sql .= "     initial_cost.shop_id = $select_id  \n";
                        }
                        $sql .= " AND  \n";
                        //直営判定
                        if($_SESSION[group_kind] == "2"){
                            //直営
                        $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")); \n";
                        }else{
                            //FC
                        $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $select_id); \n";
                        }
                        $result_s = Db_Query($db_con, $sql);
                        $com_data = Get_Data($result_s);
                        //構成品の子に単価が設定されていないか判定
                        if($com_data == NULL){
                            $reset_goods_flg = true;   //該当データの表示する行にNULLを代入
                        }
                    }
                }
    
                $row[$i-$null_num][1] = htmlspecialchars($row[$i-$null_num][1]);
                $row[$i-$null_num][2] = htmlspecialchars($row[$i-$null_num][2]);
                $row[$i-$null_num][3] = htmlspecialchars($row[$i-$null_num][3]);
                $row[$i-$null_num][4] = htmlspecialchars($row[$i-$null_num][4]);
                $row[$i-$null_num][12] = htmlspecialchars($row[$i-$null_num][12]);
    
                $return_data[$i-$null_num] = "'".$row[$i-$null_num][0]."',".$shop_aid;
    
                //表示しない構成品の行にNULLを代入
                if($reset_goods_flg == true){
                    $null_num++;
                }
           }
            $total_count = $total_count - $null_num;
            break;

        case 'rental':    
            //2-1-141.php レンタルTOレンタル
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
            $goods_sql .= "   t_g_product.g_product_name || '　' || t_goods.goods_name, "; //商品分類名　商品名
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_g_product.g_product_name, ";
	          $goods_sql .= "     t_g_product.g_product_id ";
                                   
            $goods_sql .= " FROM";
            $goods_sql .= "    t_goods ";

            $goods_sql .= "    INNER JOIN  t_price ON t_goods.goods_id = t_price.goods_id";
            $goods_sql .= "    INNER JOIN  t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id";
            $goods_sql .= "    INNER JOIN  t_product ON t_goods.product_id = t_product.product_id";
            $goods_sql .= "    INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
    
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
                $row[$i][8] = htmlspecialchars($row[$i][8]);
                $row[$i][12] = addslashes($row[$i][12]);
                $row[$i][12] = htmlspecialchars($row[$i][12]);
    
                //返り値（商品ID,商品CD,商品名,レンタル単価）
                $price = explode('.',$row[$i][7]);
                $return_data[$i] = "'".$row[$i][6]."','".$row[$i][0]."','".$row[$i][8]."','"
                  .$price[0]."','".$price[1]."','".$price[0]."','".$price[1]."','".$row[$i][12]."'";
    
                $row[$i][1] = htmlspecialchars($row[$i][1]);
                $row[$i][2] = htmlspecialchars($row[$i][2]);
                $row[$i][3] = htmlspecialchars($row[$i][3]);
                $row[$i][4] = htmlspecialchars($row[$i][4]);
    
           }
            break;
        default:
            //戻り値、商品コード・商品名
    
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
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     '',";
            $goods_sql .= "     t_g_product.g_product_name ";
    
            $goods_sql .= " FROM";

            $goods_sql .= "     t_goods ";
            $goods_sql .= "    INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $goods_sql .= "    INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
            $goods_sql .= "    INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
            $goods_sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";

            $goods_sql .= " WHERE";
            $goods_sql .= "     t_goods_info.shop_id = $shop_id ";
            $goods_sql .= "     AND";
            $goods_sql .= "     t_goods_info.head_fc_flg = 'f' ";
    
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
                $single = addslashes($row[$i][2]);
                $return_data[] = "'".$row[$i][0]."','".htmlspecialchars($single)."'";
    
                $row[$i][1] = htmlspecialchars($row[$i][1]);
                $row[$i][2] = htmlspecialchars($row[$i][2]);
                $row[$i][3] = htmlspecialchars($row[$i][3]);
                $row[$i][4] = htmlspecialchars($row[$i][4]);
                $row[$i][12] = htmlspecialchars($row[$i][12]);
    
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
    'total_count'    => "$total_count",
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
