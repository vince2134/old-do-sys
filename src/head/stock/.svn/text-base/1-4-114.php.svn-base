<?php
/******************************
 *変更履歴
 *  （2006-07-29）前在庫を表示するように変更<watanabe-k>
 *   (2006-10-12) 略称を表示するように変更<watanabe-k>
 *
 *
 *
 *
*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/22      11-009      ふ          GET値(goods_id)が不正な場合の処理追加
 *  2006/11/22      11-010      ふ          GET値(ware_id)が不正な場合の処理追加
 *  2006/11/22      11-011~013  ふ          GET値(start)が不正な場合の処理追加
 *  2006/11/22      11-014~016  ふ          GET値(end)が不正な場合の処理追加
 *  2009/10/12                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *   
 */

$page_title = "在庫受払明細";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id      = $_SESSION["client_id"];   //ショップID 
$get_goods_id = $_GET["goods_id"];        //商品ID
$get_ware_id  = $_GET["ware_id"];         //倉庫ID
$start        = $_GET["start"];           //取扱開始日
$end          = $_GET["end"];             //取扱終了日
$trans_flg    = $_GET["trans_flg"];       //発注点警告・出荷予定一覧・在庫照会から遷移してきたか判定

/*** GETデータの正当性チェック ***/
if ($get_goods_id != null && Get_Id_Check_Db($db_con, $get_goods_id, "goods_id", "t_goods", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}
if ($get_ware_id != null && Get_Id_Check_Db($db_con, $get_ware_id, "ware_id", "t_ware", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}
if ($start != null && !ereg("^([0-9]{4})[-]([01]?[0-9])[-]([0123]?[0-9])$", $start)){
    header("Location: ../top.php");
}elseif ($start != null && ereg("^([0-9]{4})[-]([01]?[0-9])[-]([0123]?[0-9])$", $start)){
    (!checkdate(substr($start, 5, 2), substr($start, 8, 2), substr($start, 0, 4))) ? header("Location: ../top.php") : null;
}
if ($end != null && !ereg("^([0-9]{4})[-]([01]?[0-9])[-]([0123]?[0-9])$", $end)){
    header("Location: ../top.php");
}elseif ($end != null && ereg("^([0-9]{4})[-]([01]?[0-9])[-]([0123]?[0-9])$", $end)){
    (!checkdate(substr($end, 5, 2), substr($end, 8, 2), substr($end, 0, 4))) ? header("Location: ../top.php") : null;
}

/****************************/
//部品定義
/****************************/
//取扱開始日
$form->addElement("static","form_start","","");
//取扱終了日
$form->addElement("static","form_end","","");

//商品名
$form->addElement("static","form_goods_name","","");
//倉庫名
$form->addElement("static","form_ware_name","","");
//前在庫
$form->addElement("static","form_renew_num","","");

//戻る
//遷移元判定
if($trans_flg == '1'){
	//発注点警告
	$form->addElement("button","return_btn","戻　る","onClick=\"javascript:location.href='1-4-105.php?goods_id=".$get_goods_id."&start=".$start."&end=".$end."&trans_flg=".$trans_flg."'\"");
}else if($trans_flg == '2'){
	//出荷予定一覧
	$form->addElement("button","return_btn","戻　る","onClick=\"javascript:location.href='1-4-105.php?ware_id=".$get_ware_id."&start=".$start."&end=".$end."&trans_flg=".$trans_flg."'\"");
}else if($trans_flg == '3'){
	//在庫照会
	$form->addElement("button","return_btn","戻　る","onClick=\"javascript:location.href='1-4-105.php?ware_id=".$get_ware_id."&goods_id=".$get_goods_id."&start=".$start."&end=".$end."&trans_flg=".$trans_flg."'\"");
}else{
	//受払照会
	$form->addElement("button","return_btn","戻　る","onClick=\"javascript:location.href='1-4-105.php'\"");
}
/****************************/
//ヘッダー情報取得
/****************************/
//商品名取得SQL
//GETデータ判定
Get_Id_Check2($get_goods_id);
$sql  = "SELECT goods_name FROM t_goods WHERE goods_id = $get_goods_id;";
$result = Db_Query($db_con,$sql);
$goods_data = Get_Data($result);
$goods_name = $goods_data[0][0];
//倉庫名取得SQL
//GETデータ判定
Get_Id_Check2($get_ware_id);
$sql  = "SELECT ware_name FROM t_ware WHERE ware_id = $get_ware_id;";
$result = Db_Query($db_con,$sql);
$ware_data = Get_Data($result);
$ware_name = $ware_data[0][0];

/****************************/
//前回月次更新前の在庫数を取得
/****************************/
/*
//月次更新のデータを抽出
$sql  = "SELECT \n";
$sql .= "   MAX(close_day) AS renew_date\n";
$sql .= " FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= " WHERE \n";
$sql .= "   renew_div = '2'\n";
$sql .= "   AND \n";
$sql .= "   shop_id = $shop_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$renew_day = pg_fetch_result($result, 0,0);     //月次更新日

//日時更新が未実施の場合
if($renew_day == null){
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(";
    $sql .= "       SUM( num * CASE io_div\n";
    $sql .= "           WHEN '1' THEN 1\n";
    $sql .= "           WHEN '2' THEN -1\n";
    $sql .= "       END\n";
    $sql .= "       )\n";
    $sql .= "   ,0) AS renew_num \n";
    $sql .= "FROM\n";
    $sql .= "   t_stock_hand \n";
    $sql .= "WHERE \n";
    $sql .= "   work_div = '6' \n";
    $sql .= "   AND \n";
    $sql .= "   adjust_reason = '1' \n";
    $sql .= "   AND \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "   AND \n";
    $sql .= "   goods_id = $get_goods_id\n";
    $sql .= "   AND \n";
    $sql .= "   ware_id = $get_ware_id\n";
    $sql .= "GROUP BY ware_id, goods_id\n";
    $sql .= ";";
}else{

    $date = date('Y-m-d');

    $sql  = "SELECT\n";
    $sql .= "   COALESCE(stock_total,0) AS renew_num \n";
    $sql .= "FROM\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.ware_id,\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       t_stock.stock_num\n";
    $sql .= "           - COALESCE(t_stock1_io.stock1_io_data, 0)\n";
    $sql .= "           - COALESCE(t_stock2_io.stock2_io_data, 0)\n";
    $sql .= "       AS stock_total\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       (SELECT\n";
    $sql .= "           ware_id,\n";
    $sql .= "           goods_id,\n";
    $sql .= "           SUM(num * CASE io_div\n";
    $sql .= "               WHEN 1 THEN 1\n";
    $sql .= "               WHEN 2 THEN -1\n";
    $sql .= "           END \n";
    $sql .= "           ) AS stock1_io_data \n";
    $sql .= "       FROM\n";
    $sql .= "           t_stock_hand\n";
    $sql .= "       WHERE\n";
    $sql .= "           work_div <> 1\n";
    $sql .= "           AND\n";
    $sql .= "           work_div <> 3\n";
    $sql .= "           AND\n";
    $sql .= "           shop_id = 1\n";
    $sql .= "           AND\n";
    $sql .= "           '$renew_day' < work_day\n";
    $sql .= "           AND\n";
    $sql .= "           work_day <= '$date'\n";
    $sql .= "       GROUP BY ware_id, goods_id\n";
    $sql .= "       ) AS t_stock1_io\n";
    $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock.ware_id = t_stock1_io.ware_id\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       (SELECT\n";
    $sql .= "           ware_id,\n";
    $sql .= "           goods_id,\n";
    $sql .= "           SUM(num * CASE io_div\n";
    $sql .= "               WHEN 1 THEN 1\n";
    $sql .= "               WHEN 2 THEN -1\n";
    $sql .= "           END\n";
    $sql .= "           ) AS stock2_io_data\n";
    $sql .= "       FROM\n";
    $sql .= "           t_stock_hand\n";
    $sql .= "       WHERE\n";
    $sql .= "           work_div = 3\n";
    $sql .= "           AND\n";
    $sql .= "           shop_id = $shop_id\n";
    $sql .= "           AND\n";
    $sql .= "           '$renew_day' <=work_day\n";
    $sql .= "           AND\n";
    $sql .= "           work_day < '$date'\n";
    $sql .= "       GROUP BY  ware_id,  goods_id\n";
    $sql .= "       ) AS t_stock2_io\n";
    $sql .= "       ON t_stock.goods_id = t_stock2_io.goods_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_stock.ware_id = t_stock2_io.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock.shop_id = $shop_id\n";
    $sql .= "   ) AS t_stock_total\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods\n";
    $sql .= "   ON t_goods.goods_id = t_stock_total.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_ware\n";
    $sql .= "   ON t_stock_total.ware_id = t_ware.ware_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_goods.stock_manage = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.compose_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.goods_id = $get_goods_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_ware.ware_id = $get_ware_id\n";
    $sql .= ";";
}

$result      = Db_Query($db_con, $sql,1);
$renew_total = pg_fetch_result($result,0,0);

$def_data["form_renew_num"]  = $renew_total;
*/
$def_data["form_goods_name"] = $goods_name;
$def_data["form_ware_name"]  = $ware_name;
$def_data["form_start"]      = $start;
$def_data["form_end"]        = $end;
                         
$form->setDefaults($def_data);

/****************************/
//ページ数情報取得
/****************************/
$page_count  = $_POST["f_page1"];       //現在のページ数
if($page_count == NULL){
	$offset = 0;
}else{
	$offset = $page_count * 100 - 100;
}

/****************************/
//本部受払データ取得SQL
/****************************/
$sql .= "SELECT \n";
$sql .= "    t_stock_hand.slip_no, \n";
$sql .= "    t_stock_hand.work_day, \n";
$sql .= "    CASE t_stock_hand.work_div \n";             
$sql .= "        WHEN '2' THEN '売上' \n";
$sql .= "        WHEN '4' THEN '仕入' \n";
$sql .= "        WHEN '5' THEN '移動' \n";
$sql .= "        WHEN '6' THEN '調整' \n";
$sql .= "        WHEN '7' THEN '組立' \n";
$sql .= "    END, \n";
$sql .= "    t_stock_hand.io_div, \n";
$sql .= "    t_stock_hand.num, \n";
//$sql .= "    t_client.client_name \n";
//$sql .= "    t_client.client_cname \n";
$sql .= "    t_stock_hand.client_cname \n";
$sql .= "FROM \n";
$sql .= "    t_stock_hand \n";
$sql .= "       LEFT JOIN\n";
$sql .= "    t_client \n";
$sql .= "    ON t_client.client_id = t_stock_hand.client_id \n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_ware\n";
$sql .= "    ON t_ware.ware_id = t_stock_hand.ware_id \n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods\n";
$sql .= "    ON t_goods.goods_id = t_stock_hand.goods_id \n";
#2009-10-12 hashimoto-y
$sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

$sql .= "WHERE \n";
#2009-10-12 hashimoto-y
#$sql .= "    t_goods.stock_manage = '1' \n";
$sql .= "    t_goods_info.stock_manage = '1' \n";
$sql .= "    AND \n";
$sql .= "    t_goods_info.shop_id = $shop_id ";

$sql .= "    AND \n";
$sql .= "    t_stock_hand.goods_id = $get_goods_id \n";
$sql .= "    AND \n";
$sql .= "    t_stock_hand.ware_id = $get_ware_id \n";
$sql .= "    AND \n";
$sql .= "    t_stock_hand.shop_id = $shop_id \n";
//取扱日時が指定されているか
if($start != NULL){
	$sql .= "    AND\n ";
	$sql .= "        work_day >= '$start'\n ";
}
if($end != NULL){
	$sql .= "    AND\n ";
	$sql .= "        work_day <= '$end'\n ";
}
$sql .= "AND \n";
$sql .= "    work_div NOT IN ('1','3')\n ";
$sql .= "ORDER BY \n";
$sql .= "    t_stock_hand.work_day DESC, t_stock_hand.work_div, t_stock_hand.slip_no ";
//$sql .= "    t_stock_hand.work_day DESC\n ";



$result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;");
$page_data = Get_Data($result);

for($x=0;$x<count($page_data);$x++){
	for($j=0;$j<count($page_data[$x]);$j++){
		//入庫・出庫の形式変更
		if($j==4){
			$page_data[$x][$j] = number_format($page_data[$x][$j]);
		}
	}
}

/****************************/
//入庫・出庫数の総合計計算
/****************************/
$result = Db_Query($db_con,$sql.";");
$count_data = Get_Data($result);
$in_count  = 0;    //入庫数合計
$out_count = 0;    //出庫数合計
for($x=0;$x<count($count_data);$x++){
	for($j=0;$j<count($count_data[$x]);$j++){
		//入庫数・出庫数の合計計算
		if($count_data[$x][3] == '1'){
			//入庫
			if($j==4){
				$in_count = $in_count + $count_data[$x][$j];
			}
		}else{
			//出庫
			if($j==4){
				$out_count = $out_count + $count_data[$x][$j];
			}
		}
	}
}
$in_count  = number_format($in_count);
$out_count = number_format($out_count);

//全件数
$total_count = pg_num_rows($result);

//表示範囲指定
$range = "100";

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
$page_menu = Create_Menu_h('stock','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


/****************************/
//ページ作成
/****************************/
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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'in_count'      => "$in_count",
	'out_count'     => "$out_count",
    'renew_total'   => "$renew_total",
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
