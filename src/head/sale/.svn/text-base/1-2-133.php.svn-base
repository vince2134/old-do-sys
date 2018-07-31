<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/01/15      xx_xxx      kajioka-h   オフライン解約のときに変更ボタンをつけた件の変更
 *  2009/10/13                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
*/

$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$rental_id  = $_GET["rental_id"];    //レンタルID
//NULL判定
Get_Id_Check2($rental_id);

$disp_stat  = $_GET["disp_stat"];    //レンタル状況
$online_flg = $_GET["online_flg"];   //オンラインフラグ
$edit_flg   = $_GET["edit_flg"];     //変更フラグ
$shop_id    = $_SESSION["client_id"];

//ボタン名判定
if($rental_id != NULL && $disp_stat != 1){
	//変更画面
	$form->addElement("button","input_btn","変更画面へ","onClick=\"location.href='".HEAD_DIR."sale/1-2-132.php?rental_id=$rental_id'\"");
}else{
	//登録画面
	$form->addElement("button","input_btn","登録画面へ","onClick=\"location.href='".HEAD_DIR."sale/1-2-132.php'\"");
}
//一覧画面
if ($edit_flg == "1" || $disp_stat != "1"){
    $form->addElement("button","disp_btn","一覧画面へ","onClick=\"location.href='".HEAD_DIR."sale/1-2-130.php?search=1'\"");
}else{
    $form->addElement("button","disp_btn","一覧画面へ","onClick=\"location.href='".HEAD_DIR."sale/1-2-130.php'\"");
}

//オフラインの新規申請・オンラインの新規申請か判定
if($disp_stat == 1 || ($disp_stat == 6 && $_GET["sinsei_msg"] != true)){
	//受注入力
	$form->addElement("button","aord_btn","初回出荷分を登録","onClick=\"SubMenu2('".HEAD_DIR."sale/1-2-101.php');\"");
}

//不正判定
Get_ID_Check3($rental_id);

/****************************/
//受注入力に渡すPOST情報作成
/****************************/
//ヘッダー情報
$sql  = "SELECT ";
$sql .= "    t_rental_h.shop_cd1,";           //ショップCD1 0
$sql .= "    t_rental_h.shop_cd2,";           //ショップCD2 1
$sql .= "    t_rental_h.apply_day, ";         //レンタル申込日 2
$sql .= "    t_rental_h.forward_day,";        //レンタル出荷日 3
$sql .= "    t_rental_h.shop_id,";            //ショップID 4
$sql .= "    t_client.coax, ";                //丸め区分 5
$sql .= "    t_rental_h.h_staff_id ";         //本部担当者ID 6
$sql .= "FROM ";
$sql .= "    t_rental_h ";
$sql .= "    INNER JOIN t_client ON t_client.client_id = t_rental_h.shop_id ";
$sql .= "WHERE ";
$sql .= "    t_rental_h.rental_id = $rental_id;";
$result = Db_Query($db_con, $sql);
//GETデータ判定
Get_Id_Check($result);
$ren_h_data = Get_Data($result,2);

//本部情報取得
$sql  = "SELECT ";
$sql .= "    ware_id ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = (SELECT client_id FROM t_client WHERE client_div = 0);";
$result = Db_Query($db_con, $sql); 
$ware_id = pg_fetch_result($result, 0,0);

$con_data["form_client"]["cd1"]   = $ren_h_data[0][0];  //ショップCD1
$con_data["form_client"]["cd2"]   = $ren_h_data[0][1];  //ショップCD2
$con_data["form_ware_select"]     = $ware_id;           //基本出荷倉庫

$forward_day_array = explode('-',$ren_h_data[0][2]);
$con_data["form_ord_day"]["y"] = $forward_day_array[0]; //受注日
$con_data["form_ord_day"]["m"] = $forward_day_array[1];   
$con_data["form_ord_day"]["d"] = $forward_day_array[2];   

$rental_day_array = explode('-',$ren_h_data[0][3]);

$con_data["form_hope_day"]["y"] = $rental_day_array[0];  //希望納期
$con_data["form_hope_day"]["m"] = $rental_day_array[1];   
$con_data["form_hope_day"]["d"] = $rental_day_array[2];   

$con_data["form_arr_day"]["y"] = $rental_day_array[0];  //出荷日
$con_data["form_arr_day"]["m"] = $rental_day_array[1];   
$con_data["form_arr_day"]["d"] = $rental_day_array[2];   

$client_id = $ren_h_data[0][4];  //得意先ID
$coax      = $ren_h_data[0][5];  //丸め区分

$con_data["form_staff_select"] = $ren_h_data[0][6];

$con_data["client_search_flg"] = true;  //得意先リンク押下判定フラグ

/****************************/
//データ復元
/****************************/
$sql  = "SELECT ";
$sql .= "    goods_cd,";               //商品CD 
$sql .= "    num ";                    //数量 
$sql .= "FROM ";
$sql .= "    t_rental_d ";
$sql .= "WHERE ";
$sql .= "    rental_id = $rental_id ";
$sql .= "ORDER BY line;";
$result = Db_Query($db_con, $sql);
$ren_d_data = Get_Data($result,2);

//重複した商品は合わせる
for($i=0;$i<count($ren_d_data);$i++){
	$ren_data[$ren_d_data[$i][0]] = $ren_data[$ren_d_data[$i][0]] + $ren_d_data[$i][1];
}

//データ復元
$i=0;
while($data_num = each($ren_data)){
	$num = $data_num[0];

    $designated_date = 7;  //出荷可能数取得

	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";

    $sql .= "   t_goods.goods_cd,\n";
    $sql .= "   t_goods.goods_name,\n";
    #2009-10-13 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.rstock_num,0) - COALESCE(t_allowance_io.allowance_io_num,0) \n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.rstock_num,0) - COALESCE(t_allowance_io.allowance_io_num,0) \n";

	$sql .= " END AS allowance_total,\n";
    #2009-10-13 hashimoto-y
	#$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN\n";
	$sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN\n";

    $sql .= "   COALESCE(t_stock.stock_num,0)\n"; 
    $sql .= "   + COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0)) END AS stock_total,\n";
    $sql .= "   initial_cost.r_price AS initial_price,\n";
	$sql .= "   sale_price.r_price AS sale_price,\n";
	$sql .= "   t_goods.tax_div \n";
    $sql .= " FROM\n";
    $sql .= "   t_goods \n";
	$sql .= "   INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id\n";

	$sql .= "   LEFT JOIN  (SELECT * FROM t_price WHERE rank_cd = '6') AS initial_cost ON t_goods.goods_id = initial_cost.goods_id\n";
	//$sql .= "   INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id\n";

    $sql .= "   LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "       FROM\n";
    $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "       WHERE\n";
    $sql .= "            t_stock.shop_id = $shop_id\n";
    $sql .= "       AND\n";
    $sql .= "            t_ware.count_flg = 't'\n";
    $sql .= "       GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock ON t_goods.goods_id = t_stock.goods_id\n";

    $sql .= "   LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "   AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
    $sql .= "   AND\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "   AND\n";
    $sql .= "       t_stock_hand.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   AND\n";
	$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id\n";

    #2009-10-13 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $sql .= " WHERE \n";
    $sql .= "       t_goods.goods_cd = '".$num."'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.public_flg = 't' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.accept_flg = '1' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.state IN (1,3) \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.compose_flg = 'f' \n";
    #2009-10-13 hashimoto-y
    $sql .= " AND\n";
    $sql .= "       t_goods_info.shop_id = $shop_id\n";


    //$sql .= " AND\n"; 
    //$sql .= "       initial_cost.rank_cd = '6' \n";
    $sql .= " AND \n";
    $sql .= "       sale_price.rank_cd = \n";
    $sql .= "       (SELECT \n";
    $sql .= "           rank_cd \n";
    $sql .= "       FROM \n";
    $sql .= "           t_client \n";
    $sql .= "       WHERE \n";
    $sql .= "           client_id = $client_id)\n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
	$goods_data = Get_Data($result,2);

	$con_data["hdn_goods_id"][$i]         = $goods_data[0][0];   //商品ID
	$con_data["hdn_name_change"][$i]      = $goods_data[0][1];   //品名変更フラグ
	$con_data["hdn_stock_manage"][$i]     = $goods_data[0][2];   //在庫管理
	$con_data["form_goods_cd"][$i]        = $goods_data[0][3];   //商品CD
	$con_data["form_goods_name"][$i]      = $goods_data[0][4];   //商品名
	$con_data["form_sale_num"][$i]        = $ren_data[$num];     //受注数
	$con_data["form_stock_num"][$i]       = $goods_data[0][5];   //実棚数
	$con_data["hdn_stock_num"][$i]        = $goods_data[0][5];   //実棚数（hidden）
	$con_data["form_rorder_num"][$i]      = $goods_data[0][6];   //発注済数
	$con_data["form_rstock_num"][$i]      = $goods_data[0][7];   //引当数
	$con_data["form_designated_num"][$i]  = $goods_data[0][8];   //出荷可能数

	//原価単価を整数部と少数部に分ける
    $cost_price = explode('.', $goods_data[0][9]);
	$con_data["form_cost_price"][$i]["i"] = ($cost_price[0] != null)? $cost_price[0] : '0';  //原価単価
	$con_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

	//$cost_price = explode('.', $goods_data[0][9]);
	//$con_data["form_cost_price"][$i]["i"] = 9999;  //原価単価
	//$con_data["form_cost_price"][$i]["d"] = 9999;     


	//売上単価を整数部と少数部に分ける
/*
    $sale_price = explode('.', $goods_data[0][10]);
	$con_data["form_sale_price"][$i]["i"] = $sale_price[0];  //売上単価
	$con_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
*/
	$con_data["form_sale_price"][$i]["i"] = '0';  //売上単価
	$con_data["form_sale_price"][$i]["d"] = '00';

	if($ren_data[$num] != null){
		//原価金額計算
        $cost_amount = bcmul($goods_data[0][9], $ren_data[$num],2);
        $cost_amount = Coax_Col($coax, $cost_amount);
		//売上金額計算
        //$sale_amount = bcmul($goods_data[0][10], $ren_data[$num],2);
        //$sale_amount = Coax_Col($coax, $sale_amount);
		//受注数が入力されていた場合は、再計算
		$con_data["form_cost_amount"][$i]     = number_format($cost_amount);
		//$con_data["form_sale_amount"][$i]     = number_format($sale_amount);
		$con_data["form_sale_amount"][$i] = 0;
	}
	$con_data["hdn_tax_div"][$i]          = $goods_data[0][11]; //課税区分
	$i++;
}

//表示行数
$con_data["max_row"] = count($ren_data);

//レンタル遷移判定フラグ
$con_data["rental_flg"] = true;

/****************************/
//部品作成
/****************************/
$form->addElement("hidden","form_client[cd1]");      //ショップCD1
$form->addElement("hidden","form_client[cd2]");      //ショップCD2
$form->addElement("hidden","form_ware_select");      //基本出荷倉庫

$form->addElement("hidden","form_ord_day[y]","");    //受注日
$form->addElement("hidden","form_ord_day[m]","");
$form->addElement("hidden","form_ord_day[d]","");

$form->addElement("hidden","form_hope_day[y]","");    //希望納期
$form->addElement("hidden","form_hope_day[m]","");
$form->addElement("hidden","form_hope_day[d]","");

$form->addElement("hidden","form_arr_day[y]","");    //出荷日
$form->addElement("hidden","form_arr_day[m]","");
$form->addElement("hidden","form_arr_day[d]","");

$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "rental_flg");          //レンタル遷移判定フラグ
$form->addElement("hidden", "client_search_flg");   //得意先コード入力フラグ

$form->addElement("hidden","form_staff_select");    //本部担当者

for($i=0;$i<count($ren_data);$i++){

	//原価単価
	$form->addElement("hidden","form_cost_price[$i][i]","");
	$form->addElement("hidden","form_cost_price[$i][d]","");
	//原価合計
	$form->addElement("hidden","form_cost_amount[$i]","");
	//売上単価
	$form->addElement("hidden","form_sale_price[$i][i]","");
	$form->addElement("hidden","form_sale_price[$i][d]","");
	//売上合計
	$form->addElement("hidden","form_sale_amount[$i]","");
	//商品ID
    $form->addElement("hidden","hdn_goods_id[$i]");
	//商品CD
	$form->addElement("hidden","form_goods_cd[$i]","");
	//商品名
	$form->addElement("hidden","form_goods_name[$i]","");
	//受注数
	$form->addElement("hidden","form_sale_num[$i]","");
	//実棚数
	$form->addElement("hidden","form_stock_num[$i]","");
	//発注済数
	$form->addElement("hidden","form_rorder_num[$i]","");
	//引当数
	$form->addElement("hidden","form_rstock_num[$i]","");
	//出荷可能数
	$form->addElement("hidden","form_designated_num[$i]","");
    //課税区分
    $form->addElement("hidden","hdn_tax_div[$i]");
	//品名変更フラグ
    $form->addElement("hidden","hdn_name_change[$i]");
	//在庫管理
    $form->addElement("hidden","hdn_stock_manage[$i]");
	//実棚数
	$form->addElement("hidden","hdn_stock_num[$i]");

}
/****************************/
//ＰＯＳＴ情報変更
/****************************/
$form->setConstants($con_data);

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
$page_menu = Create_Menu_h('sale','2');
/****************************/
//画面ヘッダー作成
/****************************/
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
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
