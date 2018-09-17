<?php
$page_title = "請求明細";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//外部変数を抽出
/****************************/
$shop_id = $_SESSION["client_id"];
$staff_name = $_SESSION["staff_name"];
$get_client_id = $_GET["client_id"];                //得意先ＩＤ
$get_bill_id   = $_GET["claim_id"];                 //請求書ＩＤ

Get_Id_Check2($get_bill_id);
/****************************/
//確定処理
/****************************/
if($_POST["form_add_button"] == "請求確定"){
    $bill_id = $_POST["claim_issue"][0];

    //対象となる請求ヘッダのデータをアップデート

    Db_Query($db_con, "BEGIN;");

    $sql  = "UPDATE";
    $sql .= "   t_bill \n";
    $sql .= "SET\n";
    $sql .= "   fix_flg = 't',\n";
    $sql .= "   fix_staff_name = '$staff_name',\n";
    $sql .= "   fix_day = NOW() \n";
    $sql .= "WHERE\n";
    $sql .= "   bill_id = $bill_id\n";
    $sql .= ";\n"; 

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    Db_Query($db_con, "COMMIT;");

    $fix_message = "確定しました。";
}


/****************************/
//親子関係があるかチェックする
/****************************/
$sql  = "SELECT\n";
$sql .= "   COUNT(t_bill_d.bill_d_id) \n";
$sql .= "FROM\n";
$sql .= "   t_bill_d \n";
$sql .= "WHERE\n";
$sql .= "   t_bill_d.bill_id = $get_bill_id \n";
$sql .= "GROUP BY t_bill_d.bill_id\n";
$sql .= ";\n";   

$result = Db_Query($db_con, $sql);
Get_Id_Check($result);
$child_count = pg_fetch_result($result,0,0);

//請求データIDが１の場合親子でないフラグを立てる
$unparent_child_flg = ($child_count == 1)? true : false;

/****************************/
//遷移元判定
/****************************/
//請求照会から遷移してきた場合はtrue
$get_client_flg = ($get_client_id != null)? true : false;

/****************************/
//鑑部分のデータを抽出
/****************************/
$sql  = "SELECT\n";        

//請求照会から遷移してきた場合      
if($get_client_flg == true){
    $sql .= "    t_bill.bill_no,\n";                    //請求番号
    $sql .= "    t_bill_d.bill_close_day_this,\n";      //請求締日
    $sql .= "    t_bill.collect_day,\n";                //回収予定日
    $sql .= "    t_bill.claim_id,\n";                   //請求先ID
    $sql .= "    t_bill.claim_cd1,\n";                  //請求先コード1
    $sql .= "    t_bill.claim_cd2,\n";                  //請求先コード2
    $sql .= "    t_bill.claim_cname,\n";                //請求先名（略称）
    $sql .= "    t_bill.bill_format,\n";                //請求書書式設定
    $sql .= "    t_bill.issue_staff_name,\n";           //発行者名
    $sql .= "    t_bill.fix_staff_name,\n";             //確定者名
    $sql .= "    t_bill.tax_div\n";                     //課税単位
//請求書一括発効から遷移してきた場合
}else{
    $sql .= "    t_bill.bill_no,\n";                    //請求番号
    $sql .= "    t_bill_d.bill_close_day_this,\n";      //請求締日
    $sql .= "    t_bill.collect_day,\n";                //回収予定日
    $sql .= "    t_bill.claim_id,\n";                   //請求先ID
    $sql .= "    t_bill.claim_cd1,\n";                  //請求先コード1
    $sql .= "    t_bill.claim_cd2,\n";                  //請求先コード2
    $sql .= "    t_bill.claim_cname,\n";                //請求先名（略称）
    $sql .= "    t_bill.bill_format,\n";                //請求書書式設定
    $sql .= "    t_bill.issue_staff_name,\n";           //発行者名
    $sql .= "    t_bill.fix_staff_name,\n";             //確定者名
    $sql .= "    t_bill.tax_div,\n";                    //課税単位
    $sql .= "    t_bill_d.bill_amount_last,\n";         //前回請求額
    $sql .= "    t_bill_d.pay_amount,\n";               //今回入金額
    $sql .= "    t_bill_d.tune_amount,\n";              //調整額
    $sql .= "    t_bill_d.rest_amount,\n";              //繰越残高額
    $sql .= "    t_bill_d.sale_amount,\n";              //今回買上額
    $sql .= "    t_bill_d.tax_amount,\n";               //今回消費税額
    $sql .= "    t_bill_d.intax_amount,\n";             //税込買上額
    $sql .= "    t_bill_d.split_bill_amount,\n";        //分割請求額
    $sql .= "    t_bill_d.split_bill_rest_amount,\n";   //分割請求残高
    $sql .= "    t_bill_d.bill_amount_this,\n";         //今回請求額
    $sql .= "    t_bill_d.payment_this\n";              //今回支払額
}
$sql .= "FROM\n";
$sql .= "    t_bill INNER JOIN t_bill_d\n";
$sql .= "    ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "WHERE\n";
$sql .= "    t_bill.bill_id = $get_bill_id\n";
$sql .= "    AND\n";
$sql .= "    t_bill_d.bill_data_div = '0'\n";
$sql .= "    AND\n";
$sql .= "    t_bill.shop_id = $shop_id\n";
$sql .= ";\n";   

$result = Db_Query($db_con, $sql);
Get_Id_Check($result);
$head_data = pg_fetch_array($result);

/****************************/
//得意先データ抽出
/****************************/
$sql  = "SELECT";
$sql .= "   t_bill_d.client_id,\n";                     //得意先ID
$sql .= "   t_bill_d.client_cd1,\n";                    //得意先CD１
$sql .= "   t_bill_d.client_cd2,\n";                    //得意先CD２
$sql .= "   t_bill_d.client_cname,\n";                  //得意先名（略称）
$sql .= "   t_bill_d.bill_close_day_last,\n";           //請求締日（前回）
$sql .= "   t_bill_d.bill_close_day_this,\n";           //請求締日
$sql .= "   t_bill_d.claim_div,\n";                     //請求区分
$sql .= "   t_bill_d.bill_amount_last,\n";              //前回請求額
$sql .= "   t_bill_d.sale_amount,\n";                   //今回買上額
$sql .= "   t_bill_d.tax_amount,\n";                    //今回消費税額
$sql .= "   t_bill_d.pay_amount,\n";                    //今回入金額
$sql .= "   t_bill_d.bill_amount_this \n";              //今回請求額
$sql .= "FROM\n"; 
$sql .= "   t_bill_d \n";
$sql .= "WHERE\n";
$sql .= "   bill_id = $get_bill_id\n";
$sql .= "   AND\n";
//請求照会から遷移してきた場合      
if($get_client_flg == true){
    $sql .= "   t_bill_d.client_id = $get_client_id\n";
}else{
//    $sql .= "   t_bill_d.client_id IS NOT NULL \n";
    if($unparent_child_flg == true){
        $sql .= "   t_bill_d.bill_data_div = 0 \n";
    }else{
        $sql .= "   t_bill_d.bill_data_div != 0\n";
    }
}
$sql .= "ORDER BY t_bill_d.client_cd1, t_bill_d.client_cd2";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);
Get_Id_Check($result);
$client_data = pg_fetch_all($result);

/****************************/
//得意先明細データ抽出
/****************************/
//売上伝票データ（掛売上・掛返品・掛値引・割賦売上）
$sql  = "SELECT\n";
$sql .= "   t_sale_h.sale_day AS  trading_day,\n";
$sql .= "   t_sale_h.sale_no  AS slip_no,\n";
$sql .= "   t_trade.trade_name,\n";
$sql .= "   t_trade.trade_id,\n";
$sql .= "   v_sale_d.formal_name,\n";
$sql .= "   v_sale_d.quantity,\n";
$sql .= "   v_sale_d.unit,\n";
$sql .= "   v_sale_d.sale_price,\n";
$sql .= "   v_sale_d.sale_amount,\n";
$sql .= "   CASE v_sale_d.tax_div\n";
$sql .= "       WHEN '1' THEN '課税'\n";
$sql .= "       ELSE '非課税'\n";
$sql .= "   END AS tax_div,\n";                         //課税区分
$sql .= "   NULL AS pay_amount,\n";
$sql .= "   v_sale_d.line, \n";
$sql .= "   '1' AS position \n";
$sql .= "FROM\n";
$sql .= "   t_sale_h\n";
$sql .= "       INNER JOIN\n";
$sql .= "   v_sale_d \n";
$sql .= "   ON t_sale_h.sale_id = v_sale_d.sale_id\n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_trade\n";
$sql .= "   ON t_sale_h.trade_id = t_trade.trade_id\n";
$sql .= "WHERE  \n";
$sql .= "   t_sale_h.client_id = $1\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_div = $2\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_day > $3\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_day <= $4\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.trade_id IN (11,13,14,15)\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.renew_flg = 't'\n";

//親子関係がない場合
if($unparent_child_flg == true){
    //入金伝票データを抽出
    $sql .= "UNION ALL  \n";
    $sql .= "SELECT \n";
    $sql .= "   t_payin_h.pay_day  AS trading_day,\n";
    $sql .= "   t_payin_h.pay_no AS slip_no,\n";
    $sql .= "   t_trade.trade_name,\n";
    $sql .= "   t_trade.trade_id,\n";
    $sql .= "   CASE t_trade.trade_id\n";
    $sql .= "       WHEN '31' THEN '入金（現金）'\n";
    $sql .= "       WHEN '32' THEN '入金（振込）'\n";
    $sql .= "       WHEN '33' THEN '入金（手形）'\n";
    $sql .= "       WHEN '34' THEN '相殺'\n";
    $sql .= "       WHEN '35' THEN '手数料'\n";
    $sql .= "       WHEN '36' THEN '入金（その他）'\n";
    $sql .= "       WHEN '37' THEN 'スイット相殺'\n";
    $sql .= "       WHEN '38' THEN '調整'\n";
    $sql .= "   END AS formal_name,\n";
    $sql .= "   NULL,\n";
    $sql .= "   NULL,\n";
    $sql .= "   NULL,\n";
    $sql .= "   NULL,\n";
    $sql .= "   NULL,\n";
    $sql .= "   t_payin_d.amount AS pay_amount,\n";
    $sql .= "   NULL,\n";
    $sql .= "   '1' AS position \n";
    $sql .= "FROM\n";
    $sql .= "   t_payin_h\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_payin_d\n";
    $sql .= "   ON t_payin_h.pay_id = t_payin_d.pay_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_trade\n";
    $sql .= "   ON t_payin_d.trade_id = t_trade.trade_id\n";
    $sql .= "WHERE\n";
    $sql .= "   t_payin_h.client_id = $1\n";
    $sql .= "   AND\n";
    $sql .= "   t_payin_h.claim_div = $2\n";
    $sql .= "   AND \n";
    $sql .= "   t_payin_h.pay_day > $3\n";
    $sql .= "   AND \n";
    $sql .= "   t_payin_h.pay_day <= $4\n";
    $sql .= "   AND \n";
    $sql .= "   t_payin_h.sale_id IS NULL\n";
    $sql .= "   AND \n";
    $sql .= "   t_payin_h.renew_flg = 't'\n";
}

//売上伝票単位の消費税
$sql .= "UNION ALL  \n";
$sql .= "SELECT \n";
$sql .= "   t_sale_h.sale_day AS  trading_day,\n";
$sql .= "   t_sale_h.sale_no  AS slip_no,\n";
$sql .= "   t_trade.trade_name,\n";
$sql .= "   t_trade.trade_id,\n";
$sql .= "   '消費税金額' AS formal_name,\n";
$sql .= "   NULL,\n";
$sql .= "   NULL,\n";
$sql .= "   NULL,\n";
$sql .= "   t_sale_h.tax_amount AS sale_price,\n";
$sql .= "   NULL,\n";
$sql .= "   NULL,\n";
$sql .= "   MAX(v_sale_d.line) + 1,\n";
$sql .= "   '2' AS position \n";
$sql .= "FROM   \n";
$sql .= "   t_sale_h\n";
$sql .= "       INNER JOIN\n";
$sql .= "   v_sale_d \n";
$sql .= "   ON t_sale_h.sale_id = v_sale_d.sale_id\n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_trade\n";
$sql .= "   ON t_sale_h.trade_id = t_trade.trade_id\n";
$sql .= "WHERE  \n";
$sql .= "   t_sale_h.client_id = $1\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_div = $2\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_day > $3\n";
$sql .= "   AND \n";
$sql .= "   t_sale_h.claim_day <= $4\n";
//請求ヘッダの課税単位が伝票単位の場合
if($head_data["tax_div"] == '1'){
    $sql .= "   AND \n";
    $sql .= "   t_sale_h.trade_id IN (11,13,14,15) \n";
}else{
    $sql .= "   AND \n";
    $sql .= "   ( t_sale_h.trade_id = 15 OR v_sale_d.goods_cd = '09999903' )\n";
}
$sql .= "   AND \n";
$sql .= "   t_sale_h.renew_flg = 't'\n";
$sql .= "GROUP BY\n";
$sql .= "   t_sale_h.sale_day,\n";
$sql .= "   t_sale_h.sale_no,\n";
$sql .= "   t_trade.trade_name,\n";
$sql .= "   t_trade.trade_id,\n";
$sql .= "   t_sale_h.tax_amount \n";
$sql .= "ORDER BY\n";
$sql .= "   trading_day,\n";
$sql .= "   slip_no,\n";
$sql .= "   trade_id    \n";
$sql .= ";\n";

$sql = "PREPARE get_client_data(int,varchar,date,date) AS $sql ";
Db_Query($db_con, $sql);

//抽出した得意先分ループ
foreach($client_data as $i => $var){

    $sql  = "EXECUTE get_client_data(\n";
    $sql .= "   ".$client_data[$i][client_id].",\n";
    $sql .= "   '".$client_data[$i][claim_div]."',\n";
    $sql .= "   '".$client_data[$i][bill_close_day_last]."',\n";
    $sql .= "   '".$client_data[$i][bill_close_day_this]."'\n";
    $sql .= ");\n";

    $result = Db_Query($db_con, $sql);
    $bill_d_data[$i] = pg_fetch_all($result);
print_array($bill_d_data[$i]);
    foreach($client_data[$i] as $key => $data){
        $client_data[$i][$k] = htmlspecialchars($data);
    }

    if(is_array($bill_d_data[$i])){
        foreach($bill_d_data[$i] as $j => $value){ 
            foreach($value as $s => $vars){
                //単価をナンバーフォーマット
                if($s == "sale_price"){
                    $bill_d_data[$i][$j][$s] = My_number_format(htmlspecialchars($vars),2);
                }elseif($s == "pay_amount" || $s == "sale_amount"){
                    $bill_d_data[$i][$j][$s] = My_number_format(htmlspecialchars($vars));
                }else{
                    $bill_d_data[$i][$j][$s] = htmlspecialchars($vars);
                }

                //消費税の場合は要らないデータを削除
                if($s == "position" &&  $vars == "2"){
                    $bill_d_data[$i][$j]["trading_day"] = null;
                    $bill_d_data[$i][$j]["slip_no"]     = null;
                    $bill_d_data[$i][$j]["trade_name"]     = null;
                }
            }
        }
    }
}

/****************************/
// フォームパーツ定義
/****************************/
// 請求確定
$form->addElement("submit", "form_add_button", "請求確定", "onClick=\"javascript:return Dialogue('確定します。','#')\"");

// 請求書発行
$form->addElement("button", "form_slipout_button", "請求書発行", "onClick=\"javascript:Post_book_vote('1-2-307.php');\"");

//遷移先判定
if($get_client_flg == true){
    $page = "1-2-306.php";
}else{
    $page = "1-2-302.php";
}

$form->addElement("button", "modoru", "戻　る", "onClick=\"javascript:location.href='$page'\"");

//請求IDhidden
$form->addElement("hidden","claim_issue[0]");
$form->addElement("hidden","client_id");
$set_data["client_id"]      = $get_client_id;
$set_data["claim_issue"][0] = $get_bill_id;
$form->setDefaults($set_data);

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
$page_menu = Create_Menu_f('sale','3');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$smarty->register_modifier("number_format","number_format");
$smarty->register_modifier("stripslashes","stripslashes");
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
    'fix_message'   => "$fix_message",
    'unparent_child_flg' => "$unparent_child_flg",
));

$smarty->assign('claim_data', $head_data);
$smarty->assign('client_data', $client_data);
$smarty->assign('bill_d_data', $bill_d_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
