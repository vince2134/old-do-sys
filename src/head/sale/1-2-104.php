<?php
/********************
 * 出荷予定入力
 *
 *
 * 変更履歴
 *    2006/07/11 (kaji)
 *      ・出荷予定日に半角チェックを追加
 *    2006/07/31 (watanabe-k)
 *      ・消費税の計算を変更
 *    2006/08/07(watanabe-k)
 *      ・FC発注番号が発注時のものと違う値が表示されているバグを修正 
 *    2006/08/08(watanabe-k)
 *      ・FC発注時の単価を表示するように変更
 *      ・FC発注時の単価とマスタ単価が異なる場合はバックの色を赤く表示するよう変更
 *    2006/08/10(watanabe-k)
 *      ・履歴用カラムの登録処理を追加
 ********************/
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/30　08-008　　　　watanabe-k  出荷予定入力中に該当発注データを取り消し、出荷予定入力を完了すると受注伝票が作成されているバグの修正
 * 　2006/10/30　08-026　　　　watanabe-k  得意先コードが表示されていないバグの修正
 * 　2006/10/30　08-027　　　　watanabe-k  通信欄本部宛で改行が有効になっていないバグの修正。
 * 　2006/10/30　08-028　　　　watanabe-k  出荷予定入力画面で、受注日より前の日付で出荷予定日が入力された際、チェックの挙動がおかしいバグの修正
 * 　2006/10/31　08-029　　　　watanabe-k  出荷予定日にa06-10-25を入力した場合のエラーメッセージが妥当ではないバグの修正
 * 　2006/10/31　08-030　　　　watanabe-k  分納出荷予定日に106-10-26を入力した場合のエラーメッセージが妥当ではないバグの修正
 * 　2006/10/31　08-031　　　　watanabe-k  出荷予定確認画面で、出荷回数、出荷数が中央ぞろえに表示されているバグの修正
 * 　2006/11/03　      　　　　watanabe-k  グリーン指定行者を選択した際に、運送業者が必須入力にならないバグの修正
 * 　2006/11/03　08-063　　　　watanabe-k  得意先名のサニタイズができていないバグの修正
 * 　2006/11/03　08-064　　　　watanabe-k  通信欄（本部宛）のサニタイズができていないバグの修正
 * 　2006/11/03　08-075　　　　watanabe-k  Getチェック追加
 * 　2006/11/03　08-076　　　　watanabe-k  Getチェック追加
 * 　2006/11/03　08-077　　　　watanabe-k  Getチェック追加
 * 　2006/11/09　08-123　　　　suzuki      通信欄に正しく改行が表示されるように修正
 * 　2006/11/09　08-140　　　　suzuki      直送先・運送業者の略称を登録
 * 　2006/11/09　08-144　　　　suzuki      グリーン指定のチェックボックスが復元されるように修正
 * 　2006/11/09　08-124　　　　watanabe-k  分納時、正しい分納出荷予定日を入力し出荷予定日をNULLで登録するとシステム開始日用のエラーメッセージが表示される          
 * 　2006/11/09　08-149　　　　watanabe-k  通信欄（得意先宛）の文字数チェックが行われないバグの修正      
 * 　2006/11/29　scl_104-2[本部]　suzuki   商品名と商品CDの対応がとれるように修正          
 * 　2006/12/01　　            watanabe-k  金額計算に任意精度計算関数を使用するように修正          
 * 　2006/12/20　　            watanabe-k  同時に受注を行った場合にＴＯＰ画面へ遷移するバグの修正         
 * 　2007/01/07　　            watanabe-k  原価単価を2回ナンバーフォーマットしていたのを1度に修正         
 * 　2007/02/07　　            watanabe-k  画面タイトルを変更         
 *   2007/03/01                  morita-d    商品名は正式名称を表示するように変更 
 *   2007/03/08                 fukuda-s    DB登録時、商品名がサニタイズされた状態で登録される不具合の修正
 *   2007/03/13                watanabe-k  取引区分をデフォルトで選択するように変更
 *   2007/05/14                watanabe-k  請求先を残すように修正
 *   2007/07/17                kajioka-h   実棚数、発注済数が2回number_formatしていたのを修正
 *   2007/07/18                kajioka-h   受注数を赤くする判定でnumber_format済みの数値で引き算していたのを修正
 *                                         その他、テンプレート側でhtmlspecialchars、number_formatしないように変更
 *   2007/07/20                watanabe-k  出荷数０で登録できないように修正
 *   2007/07/31                watanabe-k  7月31日のとき出荷予定日が7月1日になるバグの修正
 *   2009/10/13                hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *   2009/12/21                aoyama-n    税率をTaxRateクラスから取得
 *   2010/01/20                aoyama-n    受注日に0埋めされていない日付を入力すると受注ヘッダのINSERT文でSQLエラーとなるバグ修正
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応
 */

$page_title = "出荷予定日返信入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//SESSION情報取得
/****************************/
$s_client_id = $_SESSION[client_id];
$staff_id = $_SESSION[staff_id];
//$s_shop_gid = $_SESSION[shop_gid];

/****************************/
//新規判別
/****************************/
Get_Id_Check3($_GET["ord_id"]);
$g_ord_id = $_GET["ord_id"];

Get_Id_Check2($g_ord_id);

if(isset($_GET["ord_id"])){
    $new_flg = false;
}else{
    $new_flg = true;
}

/****************************/
//処理判別
/****************************/
if($_POST["button"]["entry"] == "登録／返信確認画面へ" || $_POST["button"]["alert_ok"] == "警告を無視して登録" || $_POST["comp_button"] == "登録／返信OK"){
    $add_button_flg = true;


    /*******************************/
    //受注入力前に登録済みかチェック
    /*******************************/
/*
    $sql  = "SELECT\n";
    $sql .= "   COUNT(ord_id) \n";
    $sql .= "FROM"; 
    $sql .= "   t_order_h \n";
    $sql .= "WHERE\n";
    $sql .= "   ord_stat = '2'\n";
    $sql .= "   AND\n";
    $sql .= "   ord_id = $g_ord_id\n";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
    if($update_check_flg === false){ 

        /*******************************/
        //受注入力前に発注データの存在をチェック
        /*******************************/
/*
        $sql  = "SELECT\n";
        $sql .= "   COUNT(ord_id) \n";
        $sql .= "FROM"; 
        $sql .= "   t_order_h \n";
        $sql .= "WHERE\n";
        $sql .= "   ord_stat = '1'\n";
        $sql .= "   AND\n";
        $sql .= "   ord_id = $g_ord_id\n";
        $sql .= ";"; 

        $result = Db_Query($db_con, $sql);
        $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
        if($update_check_flg === false){ 
            header("Location: ./1-2-108.php?del_flg=true");
            exit;
        }       
    }else{
        header("Location: ../top.php");
        exit;
    } 
*/ 

    /*********************************/
    //受注データ登録前に発注ステータスの確認を行う
    /*********************************/
    $sql  = "SELECT \n";
    $sql .= "   ord_stat \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $g_ord_id\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $ord_stat = pg_fetch_result($result, 0,0);

    //登録前に発注が取り消されていた場合
    if($ord_stat == '3'){
        header("Location: ./1-2-108.php?del_flg=true");
        exit;
    //受注が既に完了している場合
    }elseif($ord_stat == '2'){
        header("Location: ./1-2-108.php?add_flg=true");
        exit;
    }

}else{
    $add_button_flg = false;
}


/****************************/
//デフォルト値設定
/****************************/
//基本出荷倉庫を抽出
$sql  = "SELECT";
$sql .= "   ware_id ";
$sql .= "FROM";
$sql .= "   t_client ";
$sql .= "WHERE";
$sql .= "   client_id = $s_client_id";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$def_ware_id = pg_fetch_result($result, 0,0);

$def_fdata = array(
    "form_designated_date"        => '7',
    "form_trade_select"           => "11",
    "form_staff_select"           => $staff_id,
    "form_def_day[year]"          => date('Y', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_def_day[month]"         => date('m', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_def_day[day]"           => date('d', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_ord_day[year]"          => date('Y'),
    "form_ord_day[month]"         => date('m'),
    "form_ord_day[day]"           => date('d'),
    "form_ware_select"            => $def_ware_id,
);
$form->setDefaults($def_fdata);

/****************************/
//初期表示処理
/****************************/

#2009-12-21 aoyama-n
//税率クラス　インスタンス生成
$tax_rate_obj = new TaxRate($s_client_id);

//自動採番の発注番号取得
$select_sql = " SELECT";
$select_sql .= "     COALESCE( CAST(MAX(ord_no) AS int)+1,1)";
$select_sql .= "  FROM";
$select_sql .= "    t_aorder_h";
$select_sql .= "  WHERE";
$select_sql .= "    shop_id = $s_client_id";
$select_sql .= ";";
$result = Db_Query($db_con, $select_sql);
$auto_order_no = pg_fetch_result($result, 0 ,0);
if($result === false){
    Db_Query($db_con, "ROLLBACK;");
    exit;
}
$auto_order_no = str_pad($auto_order_no, 8, 0, STR_PAD_LEFT);

$defa_data["form_order_no"] = $auto_order_no;

//***************************/
//グリーン指定チェック処理
/****************************/
//チェックの場合は、運送業者のプルダウンの値を変更する
if($_POST["trans_check_flg"] == true){
    $where  = " WHERE ";
//    $where .= "    shop_gid = $shop_gid";
    $where .= "    shop_id = $s_client_id";
    $where .= " AND";
    $where .= "    green_trans = 't'";

    //初期化
    $trans_data["trans_check_flg"]   = "";
    $form->setConstants($trans_data);
}else{
    $where = "";
}


if($new_flg == false){

    //発注ヘッダ情報抽出
    $select_sql  = "SELECT \n";
    $select_sql .= "    t_order_h.hope_day,\n";
    $select_sql .= "    t_order_h.green_flg,\n";
    $select_sql .= "    t_order_h.client_id,\n";
    $select_sql .= "    t_client.client_cname,\n";
    $select_sql .= "    t_order_h.direct_id,\n";
    $select_sql .= "    t_direct.direct_cname,\n";
    $select_sql .= "    t_order_h.note_your, \n";
    $select_sql .= "    t_order_h.shop_id, \n";
//    $select_sql .= "    t_order_h.shop_id \n";
    $select_sql .= "    t_order_h.ord_no, \n";
    $select_sql .= "    t_client.coax, \n";
    $select_sql .= "    t_order_h.enter_day, \n";
    $select_sql .= "    t_client.client_cd1, \n";
    $select_sql .= "    t_client.client_cd2, \n";
    $select_sql .= "    t_order_h.net_amount, \n";
    $select_sql .= "    t_order_h.tax_amount, \n";
    $select_sql .= "    t_client.trade_id ";
    $select_sql .= "FROM\n";
    $select_sql .= "    t_order_h \n";
    $select_sql .= "    INNER JOIN \n";
    $select_sql .= "    (SELECT \n";
    $select_sql .= "        t_client.client_id,\n";
    $select_sql .= "        t_client.client_cd1,\n";
    $select_sql .= "        t_client.client_cd2,\n";
    $select_sql .= "        t_client.client_cname,\n";
    $select_sql .="         t_client.trade_id, ";
    $select_sql .= "        t_client.coax\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_client\n";
    $select_sql .= "    )AS t_client\n";
    $select_sql .= "    ON t_order_h.shop_id = t_client.client_id\n";
    $select_sql .= "    LEFT JOIN  t_direct\n";
    $select_sql .= "    ON t_order_h.direct_id = t_direct.direct_id \n";
    $select_sql .= "WHERE\n";
    $select_sql .= "    t_order_h.ord_id = $g_ord_id\n";
    $select_sql .= "    AND\n";
    $select_sql .= "    t_order_h.ord_stat IS NOT NULL\n";
    $select_sql .= "    AND\n";
    $select_sql .= "    t_order_h.ord_stat = '1'\n";
    $select_sql .= ";\n";

    //クエリ発行
    $result = Db_Query($db_con, $select_sql);

    Get_Id_Check($result);

    //データ取得
    //$order_h_data = @pg_fetch_array ($result, 0);
    $order_h_data = Get_Data($result,1);

    $hope_day           = $order_h_data[0][0];         //希望納期

	//初期表示のみ復元
	if(count($_POST) == 0){
		//チェック付けるか判定
		if($order_h_data[0][1] == 't'){
			$con_data["form_trans_check"]  = $order_h_data[0][1];  //グリーン指定あり
			$form->setConstants($con_data);
		}
	}
/*
    if($order_h_data[1] == 't'){
        $defa_data["form_trans_check"]  = '1';      //グリーン指定
    }else{
        $defa_data["form_trans_check"]  = '0';      //グリーン指定
    }
*/
//print_array($_POST);

    $client_id          = $order_h_data[0][2];         //発注テーブルでの得意先ID
    $aord_client_id     = $order_h_data[0][7];         //受注としての得意先ID
    $client_name        = $order_h_data[0][3];         //得意先名
    $direct_id          = $order_h_data[0][4];         //直送先ID
    $direct_name        = $order_h_data[0][5];         //直送先名
    $note_my            = $order_h_data[0][6];         //通信欄（本部宛）
    $def_note_my        = $order_h_data[0][6];         //通信欄（本部宛）
    $fc_ord_id          = str_pad($order_h_data[0][8], 8, 0, STR_PAD_LEFT); //FC発注番号
    $coax               = $order_h_data[0][9];         //金額まるめ区分
    $client_cd          = $order_h_data[0][11]." - ".$order_h_data[0][12];
    
    $defa_data["form_sale_total"]   = number_format($order_h_data[0][13]);
    $defa_data["form_sale_tax"]     = number_format($order_h_data[0][14]);
    $defa_data["form_sale_money"]   = number_format($order_h_data[0][13] + $order_h_data[0][14]);
    $defa_data["hdn_ord_enter_day"] = $order_h_data["10"];   //登録日
    $defa_data["form_trade_select"] = $order_h_data[0]["15"];

    $form->setDefaults($defa_data);
/*
    $select_sql  = "SELECT\n";
    $select_sql .= "     t_goods.goods_id,\n";
//    $select_sql .= "     t_goods.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_name,\n";
    $select_sql .= "     t_order_d.num,\n";
    $select_sql .= "     t_cost_price.cost_price,\n";
    $select_sql .= "     t_sale_price.sale_price,\n";
    $select_sql .= "     t_order_d.num * t_cost_price.cost_price AS cost_amount,\n";
    $select_sql .= "     t_order_d.num * t_sale_price.sale_price AS sale_amount,\n";
    $select_sql .= "     t_goods.tax_div,\n";
    $select_sql .= "     t_order_d.buy_price\n";
    $select_sql .= " FROM\n";
    $select_sql .= "     t_order_d\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     t_goods ON t_order_d.goods_id = t_goods.goods_id\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS cost_price\n";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_price\n";
    $select_sql .= "     WHERE\n";
//    $select_sql .= "         shop_gid = 1\n";
    $select_sql .= "         shop_id = 1\n";
    $select_sql .= "         AND\n";
    $select_sql .= "         t_price.rank_cd = '1'\n";
    $select_sql .= "    ) AS t_cost_price\n";
    $select_sql .= "     ON t_order_d.goods_id = t_cost_price.goods_id\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS sale_price\n ";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_client\n";
//    $select_sql .= "            INNER JOIN\n";
//    $select_sql .= "         t_shop_gr ON t_client.shop_gid = t_shop_gr.shop_gid\n";
//    $select_sql .= "            INNER JOIN\n";
//    $select_sql .= "         t_price ON t_shop_gr.rank_cd = t_price.rank_cd\n";
//    $select_sql .= "         WHERE t_client.client_id = $client_id AND t_price.shop_gid = 1";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "         t_price ON t_client.rank_cd = t_price.rank_cd\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_client.client_id = $aord_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_price.shop_id = 1";
    $select_sql .= "    ) AS t_sale_price\n";
    $select_sql .= "    ON t_order_d.goods_id = t_sale_price.goods_id\n";
    $select_sql .= " WHERE\n";
    $select_sql .= "     t_order_d.ord_id = $g_ord_id\n";
    $select_sql .= " ORDER BY t_order_d.line\n";
    $select_sql .= ";\n";
*/


    $designated_date = ($_POST["form_designated_date"] != NULL)? $_POST["form_designated_date"] : 7;

    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 7;
    }

    $select_sql  = "SELECT\n";
    $select_sql .= "     t_goods.goods_id,\n";
    $select_sql .= "     t_order_d.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_name,\n";
    $select_sql .= "     t_order_d.num,\n";
    $select_sql .= "     t_cost_price.cost_price,\n";
    $select_sql .= "     t_sale_price.sale_price,\n";
    $select_sql .= "     t_order_d.num * t_cost_price.cost_price AS cost_amount,\n";
    $select_sql .= "     t_order_d.num * t_sale_price.sale_price AS sale_amount,\n";
    $select_sql .= "     t_goods.tax_div,\n";
    $select_sql .= "     t_order_d.buy_price, \n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock.stock_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS rack_num,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock_io.order_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS on_order_num,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_allowance_io.allowance_io_num, 0) AS TEXT)\n";
//    $select_sql .= "     - COALESCE(t_allowance_io.allowance_io_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS allowance_total,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock.stock_num, 0)\n";
    $select_sql .= "                         + COALESCE(t_stock_io.order_num,0)\n";
//    $select_sql .= "                         - (COALESCE(t_stock.rstock_num, 0)\n";
    $select_sql .= "                         - COALESCE(t_allowance_io.allowance_io_num, 0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS stock_total, ";
    $select_sql .= "     t_order_d.line ";
    $select_sql .= " FROM\n";
    $select_sql .= "     t_order_d\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     t_goods ON t_order_d.goods_id = t_goods.goods_id\n";
    $select_sql .= "        INNER JOIN\n";

    //原価単価
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS cost_price\n";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_price\n";
    $select_sql .= "     WHERE\n";
    $select_sql .= "         shop_id = 1\n";
    $select_sql .= "         AND\n";
    $select_sql .= "         t_price.rank_cd = '1'\n";
    $select_sql .= "    ) AS t_cost_price\n";
    $select_sql .= "     ON t_order_d.goods_id = t_cost_price.goods_id\n";
    $select_sql .= "        INNER JOIN\n";

    //売上単価
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS sale_price\n ";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_client\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "         t_price ON t_client.rank_cd = t_price.rank_cd\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_client.client_id = $aord_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_price.shop_id = 1";
    $select_sql .= "    ) AS t_sale_price\n";
    $select_sql .= "    ON t_order_d.goods_id = t_sale_price.goods_id\n";
    $select_sql .= "        LEFT JOIN\n";

    //在庫数
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock.goods_id,\n";
    $select_sql .= "        SUM(t_stock.stock_num) AS stock_num,\n";
    $select_sql .= "        SUM(t_stock.rstock_num) AS rstock_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "    GROUP BY t_stock.goods_id\n";
    $select_sql .= "    ) AS t_stock\n";
    $select_sql .= "    ON t_order_d.goods_id = t_stock.goods_id\n";

    $select_sql .= "        LEFT JOIN\n";

    //発注済数
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock_hand.goods_id,\n";
    $select_sql .= "        SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock_hand\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock_hand.work_div = 3\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "        AND\n";
//    $select_sql .= "        CURRENT_DATE <= t_stock_hand.work_day\n";
//    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "    GROUP BY t_stock_hand.goods_id\n";
    $select_sql .= "    ) AS t_stock_io\n";
    $select_sql .= "    ON t_order_d.goods_id = t_stock_io.goods_id\n";

    $select_sql .= "        LEFT JOIN\n";

    //引当数
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock_hand.goods_id,\n";
    $select_sql .= "        SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock_hand\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock_hand.work_div = 1\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "        AND\n";
//    $select_sql .= "        t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "        t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "    GROUP BY t_stock_hand.goods_id\n";
    $select_sql .= "    ) AS t_allowance_io\n";
    $select_sql .= "    ON t_order_d.goods_id = t_allowance_io.goods_id\n";
    #2009-10-13 hashimoto-y
    $select_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $select_sql .= " WHERE\n";
    $select_sql .= "     t_order_d.ord_id = $g_ord_id\n";
    #2009-10-13 hashimoto-y
    $select_sql .= "     AND\n";
    $select_sql .= "     t_goods_info.shop_id = 1\n";

    $select_sql .= " ORDER BY t_order_d.line\n";
    $select_sql .= ";\n";

    //クエリ発行
    $result = Db_Query($db_con, $select_sql);

    $num = pg_num_rows($result);
    $order_d_data = Get_Data($result, 2);


    for($i=0;$i<$num;$i++){
        $goods_id[$i]           = $order_d_data[$i][0];         //商品ID
        $aord_num[$i]           = $order_d_data[$i][3];         //受注数

        $cost_price[$i]         = $order_d_data[$i][4];         //原価単価
        $sale_price[$i]         = $order_d_data[$i][5];         //売上単価

        $cost_amount[$i]        = bcmul($cost_price[$i], $aord_num[$i], 2); // 原価金額
        $cost_amount[$i]        = Coax_Col($coax, $cost_amount[$i]);
        $order_d_data[$i][6]    = $cost_amount[$i];

        $sale_amount[$i]        = bcmul($sale_price[$i], $aord_num[$i], 2); // 売上金額
        $sale_amount[$i]        = Coax_Col($coax, $sale_amount[$i]);
        $order_d_data[$i][7]    = $sale_amount[$i];

//        $cost_amount[$i]        = $order_d_data[$i][6];         //原価金額
//        $sale_amount[$i]        = $order_d_data[$i][7];         //売上金額

        $tax_div[$i]            = $order_d_data[$i][8];         //課税区分

        $buy_price[$i]          = $order_d_data[$i][9];         //FC発注単価
        $buy_amount[$i]         = bcmul($buy_price[$i], $aord_num[$i], 2);  //FC発注金額
        $buy_amount[$i]         = Coax_Col($coax, $buy_amount[$i]);

        //後から処理を変更したため、代入の順番が気持ち悪くなってしまった！！
        $order_d_data[$i][14]   = $order_d_data[$i][12];
        $order_d_data[$i][15]   = $order_d_data[$i][13];
        $order_d_data[$i][12]   = $order_d_data[$i][10];
        $order_d_data[$i][13]   = $order_d_data[$i][11];

        $order_d_data[$i][10]   = $buy_amount[$i];

        //FC発注単価とマスタ単価を比べる
        //異なる場合は、フラグを立てる
        $order_d_data[$i][11] = ($sale_amount[$i] != $buy_amount[$i])? true : false;

        $def_data["form_forward_num"][$i][0] = $aord_num[$i];   //出荷数
    }
    $form->setDefaults($def_data);
/*
    if($_POST["forward_ware_flg"] == true){
        //在庫数抽出
        $select_sql  = "SELECT\n";
        $select_sql .= "    t_order_d.goods_id,\n";
        $select_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
        $select_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) - COALESCE(t_allowance.allowance_num,0) END AS stock_total \n";
        $select_sql .= "FROM \n";
        $select_sql .= "    t_order_d INNER JOIN t_goods\n";
        $select_sql .= "    ON t_order_d.goods_id = t_goods.goods_id\n";
        $select_sql .= "    LEFT JOIN t_stock\n";
        $select_sql .= "    ON t_order_d.goods_id = t_stock.goods_id\n";
        $select_sql .= "    LEFT JOIN\n";
        $select_sql .= "    (SELECT \n";
        $select_sql .= "    goods_id,\n";
        $select_sql .= "    ware_id,\n";
        $select_sql .= "    SUM(num * CASE io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS allowance_num\n";
        $select_sql .= "    FROM t_stock_hand \n";
        $select_sql .= "    WHERE work_div = 1\n";
        $select_sql .= "    AND client_id =  $s_client_id\n";
        if($_POST[form_ware_select] == ""){
            $select_sql .= "    AND ware_id = null\n";
        }else{
            $select_sql .= "    AND ware_id = $_POST[form_ware_select]\n";
        }
        $select_sql .= "    AND work_day <= (CURRENT_DATE + 7)\n";
        $select_sql .= "    GROUP BY goods_id,ware_id\n";
        $select_sql .= "    ) AS t_allowance\n";
        $select_sql .= "    ON t_order_d.goods_id = t_allowance.goods_id \n";
        $select_sql .= "WHERE \n";
        $select_sql .= "    t_order_d.ord_id = $g_ord_id \n";
        $select_sql .= "AND \n";
        $select_sql .= "    t_stock.shop_id = $s_client_id \n";
        $select_sql .= "AND \n";
        if($_POST[form_ware_select] == ""){
            $select_sql .= "    t_stock.ware_id = null \n";
        }else{
            $select_sql .= "    t_stock.ware_id = $_POST[form_ware_select] \n";
        }
        $select_sql .= "ORDER BY t_order_d.line \n";
        $select_sql .= ";\n";

        //クエリ発行
        $result = pg_query($db_con, $select_sql);
        $st_num = pg_num_rows($result);
        $stock_data = Get_Data($result);

        //実在庫数･引当可能数がnullの場合0を代入
        for($i = 0;$i < $num;$i++){
            for($j = 0;$j <= $st_num;$j++){
                if($stock_data[$j][0] != $order_d_data[$i][0]){
                    $order_d_data[$i][12] = '0';
                    $order_d_data[$i][13] = '0';
                }else{
                    $order_d_data[$i][12] = $stock_data[$j][1];
                    $order_d_data[$i][13] = $stock_data[$j][2];
                    break;
                }
            }
        }
    }
*/
}

/****************************/
//部品定義
/****************************/
//発注番号
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #000000; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//出荷回数
$select_page_arr = array(1,2,3,4,5,6,7,8,9,10);
for($i=0;$i<$num;$i++){

    //出荷回数
    $form->addElement('select', 'form_forward_times['.$i.']', "出荷回数", $select_page_arr,"onChange=\"javascript:Button_Submit('forward_num_flg','#','true', this)\"");

    //出荷予定日
    $form_forward_day = "";
    $form_forward_day[] =& $form->createElement(
            "text","year","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
            onkeyup=\"changeText(this.form,'form_forward_day[$i][0][year]','form_forward_day[$i][0][month]',4)\" 
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form_forward_day[] =& $form->createElement(
            "text","month","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
            onkeyup=\"changeText(this.form,'form_forward_day[$i][0][month]','form_forward_day[$i][0][day]',2)\" 
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form_forward_day[] =& $form->createElement(
            "text","day","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form->addGroup( $form_forward_day,"form_forward_day[".$i."][0]","form_forward_day","-");

    //出荷数
    $form->addElement(
            "text","form_forward_num[".$i."][0]","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\" 
            style=\"$g_form_style;text-align: right\"
            \".$g_form_option.\""
            );
    //●必須チェック
    $form->addRule("form_forward_num[".$i."][0]", "出荷数は半角数値のみです。","required");
    $form->addRule("form_forward_num[".$i."][0]", "出荷数は半角数値のみです。","numeric");

    if($_POST["forward_num_flg"] == true){
        $forward_number = $_POST["form_forward_times"][$i];
        for($j=1;$j<=$forward_number;$j++){
            //出荷予定日
            $form_forward_day = "";
            $form_forward_day[] =& $form->createElement(
                    "text","year","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
                    onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][year]','form_forward_day[$i][$j][month]',4)\" 
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form_forward_day[] =& $form->createElement(
                    "text","month","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
                    onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][month]','form_forward_day[$i][$j][day]',2)\" 
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form_forward_day[] =& $form->createElement(
                    "text","day","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form->addGroup( $form_forward_day,"form_forward_day[".$i."][".$j."]","form_forward_day","-");

            //出荷数
            $form->addElement(
                    "text","form_forward_num[".$i."][".$j."]","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\" 
                    style=\"$g_form_style;text-align: right\"
                    \".$g_form_option.\""
            );
            /*
            //■出荷予定日
            //●半角数字チェック
            $form->addGroupRule("form_forward_day[".$i."][0]", array(
                    'year' => array(
                            array('出荷予定日は半角数値のみです。', 'required'),
                            array('出荷予定日は半角数値のみです。', 'numeric')
                    ),
                    'month' => array(
                            array('出荷予定日は半角数値のみです。', 'required'),
                            array('出荷予定日は半角数値のみです。', 'numeric')
                    ),
                    'day' => array(
                            array('出荷予定日は半角数値のみです。', 'required'),
                            array('出荷予定日は半角数値のみです。', 'numeric')
                    ),
            ));
            //■出荷数
            //●必須チェック
            $form->addRule("form_forward_num[".$i."][0]", "出荷数は半角数値のみです。","required");
            $form->addRule("form_forward_num[".$i."][0]", "出荷数は半角数値のみです。","numeric");
            */
        }
    }
}

//出荷予定日（一括指定用）
$form_def_day[] =& $form->createElement(
        "text","year","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_def_day[year]','form_def_day[month]',4)\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form_def_day[] =& $form->createElement(
        "text","month","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_def_day[month]','form_def_day[day]',2)\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form_def_day[] =& $form->createElement(
        "text","day","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form->addGroup( $form_def_day,"form_def_day","form_def_day","-");

//受注日
$form_ord_day[] =& $form->createElement(
        "text","year","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_ord_day[year]','form_ord_day[month]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form_ord_day[] =& $form->createElement(
        "text","month","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_ord_day[month]','form_ord_day[day]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form_ord_day[] =& $form->createElement(
        "text","day","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form->addGroup( $form_ord_day,"form_ord_day","form_ord_day","-");

//グリーン指定
$form->addElement('checkbox', 'form_trans_check', 'グリーン指定', '<b>グリーン指定</b>　',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");

//通信欄（得意先宛）
$form->addElement("textarea","form_note_your","テキストフォーム","rows=\"2\" cols=\"75\" \".$g_form_option_area.\" ");

//運送業者
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', 'セレクトボックス', $select_value,$g_form_option_select);

//倉庫
$select_value = Select_Get($db_con,'ware');
//$form->addElement('select', 'form_ware_select', 'セレクトボックス', $select_value,"onChange=\"javascript:Button_Submit('forward_ware_flg','#','true')\"");
$form->addElement('select', 'form_ware_select', 'セレクトボックス', $select_value);

//取引区分
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'form_trade_select', 'セレクトボックス', $select_value,$g_form_option_select);

//担当者
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', 'セレクトボックス', $select_value,$g_form_option_select);

//出荷可能数
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right;$g_form_style\"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true', this)\"
    "
);

//売上金額合計
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #000000; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//hidden
$form->addElement("hidden","forward_ware_flg");    //出荷倉庫選択
$form->addElement("hidden","forward_num_flg");     //出荷回数選択
$form->addElement("hidden", "trans_check_flg");    //グリーン指定チェックフラグ
$form->addElement("hidden", "first_page_flg", "t");    //初期表示フラグ
$form->addElement("hidden", "recomp_flg");          //出荷可能数フラグ

/****************************/
//エラーチェック(QuickForm)
/****************************/
//■受注日
//●必須チェック
$form->addGroupRule('form_ord_day', array(
        'year' => array(
                array('正しい受注日を入力してください。', 'required'),
                array('正しい受注日を入力してください。', 'numeric')
        ),
        'month' => array(
                array('正しい受注日を入力してください。', 'required'),
                array('正しい受注日を入力してください。', 'numeric')
        ),
        'day' => array(
                array('正しい受注日を入力してください。', 'required'),
                array('正しい受注日を入力してください。', 'numeric')
        ),
));

//出荷予定日
//半角チェック
$form->addGroupRule('form_def_day', array(
        'year' => array(
                array('正しい出荷予定日を入力してください。', 'numeric')
        ),
        'month' => array(
                array('正しい出荷予定日を入力してください。', 'numeric')
        ),
        'day' => array(
                array('正しい出荷予定日を入力してください。', 'numeric')
        ),
));
//■出荷倉庫
//●必須チェック
$form->addRule("form_ware_select", "出荷倉庫を選択して下さい。","required");

//■取引区分
//●必須チェック
$form->addRule("form_trade_select", "取引区分を選択して下さい。","required");

//■担当者
//●必須チェック
$form->addRule("form_staff_select", "担当者を選択して下さい。","required");

//通信欄   //●文字数チェック
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_your","通信欄（得意先宛）は50文字以内です。","mb_maxlength","50");

/********************************/
//合計金額・消費税・伝票合計取得
/********************************/

//得意先の情報を抽出
$sql  = "SELECT";
$sql .= "   t_client.coax,";
$sql .= "   t_client.tax_franct";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= "   INNER JOIN t_order_h ON t_order_h.client_id = t_client.client_id";
$sql .= " WHERE";
$sql .= "    t_order_h.ord_id = $g_ord_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$client_list = Get_Data($result);

//得意先情報復元
$coax           = $client_list[0][0];        //丸め区分（金額）
$tax_franct     = $client_list[0][1];        //端数区分（消費税）

//現在の消費税率
#2009-12-21 aoyama-n
#$sql  = "SELECT ";
#$sql .= "    tax_rate_n ";
#$sql .= "FROM ";
#$sql .= "    t_client ";
#$sql .= "WHERE ";
#$sql .= "    client_id = $_SESSION[h_client_id];";
#$result = Db_Query($db_con, $sql); 
#$tax_num = pg_fetch_result($result, 0,0);    //現在の消費税

#2009-12-21 aoyama-n
$tax_rate_obj->setTaxRateDay($_POST["form_ord_day"]["year"]."-".$_POST["form_ord_day"]["month"]."-".$_POST["form_ord_day"]["day"]);
$tax_num = $tax_rate_obj->getClientTaxRate($aord_client_id);
$total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

$sale_money = number_format($total_money[0]);
$tax_money  = number_format($total_money[1]);
$st_money   = number_format($total_money[2]);

/*
    //フォームに値セット
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $form->setConstants($money_data);
*/

//登録処理
if($_POST["button"]["entry"] == "登録／返信確認画面へ" || $_POST["button"]["alert_ok"] == "警告を無視して登録" || $_POST["comp_button"] == "登録／返信OK"){


    $ord_no          = $_POST["form_order_no"];              //発注番号
    #2010-01-20 aoyama-n
    #潜在バグ　0埋めされていない日付を入力すると受注ヘッダのINSERT文でSQLエラーとなる
    #$ord_day         = $_POST["form_ord_day"]["year"];       //受注日
    #$ord_day        .= $_POST["form_ord_day"]["month"];
    #$ord_day        .= $_POST["form_ord_day"]["day"];
    $ord_day         = $_POST["form_ord_day"]["year"]."-";       //受注日
    $ord_day        .= $_POST["form_ord_day"]["month"]."-";
    $ord_day        .= $_POST["form_ord_day"]["day"];
    $def_day         = $_POST["form_def_day"]["year"];       //出荷予定日
    $def_day        .= $_POST["form_def_day"]["monty"];
    $def_day        .= $_POST["form_def_day"]["day"];
    $green           = $_POST["form_trans_check"];           //グリーン指定
    $note_your       = $_POST["form_note_your"];             //通信欄（自社宛）
    $trans_id        = $_POST["form_trans_select"];          //運送業者
    $ware_id         = $_POST["form_ware_select"];           //倉庫
    $trade_id        = $_POST["form_trade_select"];          //取引区分
    $c_staff_id      = $_POST["form_staff_select"];          //担当者
    $post_flg = true;

    /********************************/
    //エラーチェック
    /********************************/
    //運送業者
    if($green == '1'){
        $form->addRule("form_trans_select","運送業者を選択して下さい。","required");
    }

    //■受注日
    $aord_yy  =  str_pad($_POST["form_ord_day"]["year"], 4, 0, STR_PAD_LEFT);
    $aord_mm  =  str_pad($_POST["form_ord_day"]["month"], 2, 0, STR_PAD_LEFT);
    $aord_dd  =  str_pad($_POST["form_ord_day"]["day"], 2, 0, STR_PAD_LEFT);
    $aord_ymd = $aord_yy.$aord_mm.$aord_dd;

    if(!checkdate((int)$aord_mm, (int)$aord_dd, (int)$aord_yy)){
        $form_ord_day_err = "受注日の日付は妥当ではありません。";
        $err_flg = true;
    }else{
        $err_msge = Sys_Start_Date_Chk($aord_yy, $aord_mm, $aord_dd, "受注日");
        if($err_msge != null){
            $form_ord_day_err = $err_msge;
            $defd_err = true;
            $err_flg = true;
        }
    }

    //■出荷予定日
//    $defd_yy = str_pad($_POST["form_def_day"]["year"], 4, 0, STR_PAD_LEFT);
//    $defd_mm = str_pad($_POST["form_def_day"]["month"], 2, 0, STR_PAD_LEFT);
//    $defd_dd = str_pad($_POST["form_def_day"]["day"], 2, 0, STR_PAD_LEFT);
    $defd_yy = $_POST["form_def_day"]["year"];
    $defd_mm = $_POST["form_def_day"]["month"];
    $defd_dd = $_POST["form_def_day"]["day"];
    $defd    = $defd_yy.$defd_mm.$defd_dd;

    if((!checkdate((int)$defd_mm, (int)$defd_dd, (int)$defd_yy)) && ($defd_yy != null || $defd_mm != null || $defd_dd != null)){
        $form_def_day_err = "出荷予定日の日付は妥当ではありません。";
        $defd_err = true;
        $err_flg = true;
    }elseif($defd_yy != null || $defd_mm != null || $defd_dd != null){

        //■受注日と出荷予定日を比べる
        $aord_yy = str_pad($aord_yy, '4', '0', STR_PAD_LEFT);
        $aord_mm = str_pad($aord_mm, '2', '0', STR_PAD_LEFT);
        $aord_dd = str_pad($aord_dd, '2', '0', STR_PAD_LEFT);

        $aord_ymd = $aord_yy.$aord_mm.$aord_dd;

        $defd_yy = str_pad($defd_yy, '4', '0', STR_PAD_LEFT);
        $defd_mm = str_pad($defd_mm, '2', '0', STR_PAD_LEFT);
        $defd_dd = str_pad($defd_dd, '2', '0', STR_PAD_LEFT);

        $defd = $defd_yy.$defd_mm.$defd_dd;
    
        if($aord_ymd > $defd){
            $form_def_day_err = "出荷予定日は受注日以降の日付を指定してください。";
            $defd_err = true;
            $err_flg = true;
        }

        $err_msge = Sys_Start_Date_Chk($defd_yy, $defd_mm, $defd_dd, "出荷予定日");
        if($err_msge != null){
            $form_def_day_err = $err_msge;
            $defd_err = true;
            $err_flg = true;
        }
    }

    //商品毎に出荷予定日に空が一つの場合はデフォルトの日付を入力する
    for($i = 0; $i< $num; $i++){
        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
            $arv_yy = $_POST["form_forward_day"][$i][$j]["year"];
            $arv_mm = $_POST["form_forward_day"][$i][$j]["month"];
            $arv_dd = $_POST["form_forward_day"][$i][$j]["day"];
            $arv_ymd = $arv_yy.$arv_mm.$arv_dd;

            if($arv_ymd == null){
                $null_row[] = $j;
            }
        }

        //空白がひつの場合
        if(count($null_row) == 1 && $defd_err != true){
            $row = $null_row[0];
            $_POST["form_forward_day"][$i][$row]["year"] = $defd_yy;
            $_POST["form_forward_day"][$i][$row]["month"] = $defd_mm;
            $_POST["form_forward_day"][$i][$row]["day"] = $defd_dd;

        //空白が二つ以上の場合
        }elseif(count($null_row) > 1){
            $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
            $err_flg = true;
            break;
        }
        $null_row = null;
    }

    //■出荷予定日
    //商品数（種類）ループ
    for($i=0;$i<$num;$i++){
        //出荷回数を配列に保持
        $array_count[$i] = $_POST["form_forward_times"][$i];
        //出荷回数ループ
        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){

            //日付がNULLでなければ0埋め
            if($_POST["form_forward_day"][$i][$j]["year"] != NULL){
                $_POST["form_forward_day"][$i][$j]["year"] = str_pad($_POST["form_forward_day"][$i][$j]["year"], 4, 0, STR_PAD_LEFT);
            }
            if($_POST["form_forward_day"][$i][$j]["month"] != NULL){
                $_POST["form_forward_day"][$i][$j]["month"] = str_pad($_POST["form_forward_day"][$i][$j]["month"], 2, 0, STR_PAD_LEFT);
            }
            if($_POST["form_forward_day"][$i][$j]["day"] != NULL){
                $_POST["form_forward_day"][$i][$j]["day"] = str_pad($_POST["form_forward_day"][$i][$j]["day"], 2, 0, STR_PAD_LEFT);
            }

            //出荷予定日 （$yy $mm $dd のNULLチェックは日付の妥当性を確認するため行なわない）
            $yy  = $_POST["form_forward_day"][$i][$j]["year"];
            $mm  = $_POST["form_forward_day"][$i][$j]["month"];
            $dd  = $_POST["form_forward_day"][$i][$j]["day"];
            $ymd = $yy.$mm.$dd;

            //出荷予定日がNULLでない場合
            if($ymd != NULL){

                //日付が妥当な場合
                if(checkdate((int)$mm, (int)$dd, (int)$yy)){  //キャストで0をNULLに変換

                    //出荷予定日が半角数字ではない場合
                    if(!ereg("^[0-9]+$", $yy) || !ereg("^[0-9]+$", $mm) || !ereg("^[0-9]+$", $dd)){
                        $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
                        $err_flg = true;
                    }

                    //出荷予定日が重複する場合
                    if($all_ymd_goods[$i][$ymd] == "1"){
                        $forward_day_err = "同一の商品で分納出荷予定日が重複しています。";
                        $err_flg = true;
                    }else{
                        $all_ymd_goods[$i][$ymd] = 1; //商品($i)の出荷日にフラグを立てる
                    }

                    //出荷予定日が受注日以前の場合
                    if($err_flg == true && $ymd < $aord_ymd){
                        $forward_day_err = "分納出荷予定日は受注日以降の日付を設定して下さい。";
                        $err_flg = true;
                    }

                    $err_msge = Sys_Start_Date_Chk($yy, $mm, $dd, "分納出荷予定日");
                    if($err_msge != null){
                    $forward_day_err = $err_msge;
                        $err_flg = true;
                    }

                //日付が妥当でない場合
                }else{
                    $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
                    $err_flg = true;
                }
            }

            //■出荷数チェック
            //●必須チェック
            if($_POST["form_forward_num"][$i][$j] == null || !ereg("^[0-9]+$", $_POST["form_forward_num"][$i][$j]) || $_POST["form_forward_num"][$i][$j] == 0){
                $forward_num_err = "出荷数は半角数値のみです。";
                $err_flg = true;

            //出荷数が入力されている場合
            }else{
                //入力された出荷数合計
                $enter_num[$i] = $enter_num[$i]+$_POST["form_forward_num"][$i][$j];
            }
        }

        //通常の登録の場合は総出荷数をチェックする
        if( $_POST["button"]["entry"] == "登録／返信確認画面へ"){
            //出荷数をチェックする
            if($aord_num[$i] < $enter_num[$i]){
                $gyou_no = $i+1;
                $alert_message .= "　No.$gyou_no 商品の総出荷数が受注数を超えています。<br>";
                $alert_flg = true;
            }else if ($enter_num[$i] < $aord_num[$i]){
                $gyou_no = $i+1;
                $alert_message .= "　No.$gyou_no 商品の総出荷数が受注数を満たしていません。<br>";
                $alert_flg = true;
            }

            //fc発注単価とマスタ単価が異なる場合は警告を表示
            if($order_d_data[$i][11] == true){
                $price_warning .= " No.".($i+1)." 商品のFC発注時金額と売上金額が異なっています。<br>";
            }
        }
    }
    /********************************/
    //登録処理
    /********************************/
    //入力エラーが無い場合
    if($post_flg == true && $err_flg != true){ 
        $insert_flg = true;
        $alert_output = true; //エラーが無い場合は警告を表示
    }    

    //入力エラーが無い　かつ　警告が無い　場合は登録処理を開始
    if($insert_flg == true && $alert_flg != true && $form->validate()){ 
        //日付を結合
        $defd_ymd = $defd_yy."-".$defd_mm."-".$defd_dd;
        //登録判定
        if($_POST["comp_button"] == "登録／返信OK"){
            /********************************/
            //受注の登録に必要なデータを作成
            /********************************/
            //空白データはNULL（文字列）に置き換える
            if($trans_id == "") $trans_id = "NULL";
            if($ware_id == "") $ware_id = "NULL";
            if($direct_id == "") $direct_id = "NULL";

            //商品数（種類）ループ
            for($i=0;$i<$num;$i++){
                $forward_times[$i] = $_POST["form_forward_times"][$i];   //出荷回数

                //出荷回数ループ
                for($j=0;$j<=$forward_times[$i];$j++){

                    //出荷予定日
                    $f_yy  = $_POST["form_forward_day"][$i][$j]["year"];
                    $f_mm  = $_POST["form_forward_day"][$i][$j]["month"];
                    $f_dd  = $_POST["form_forward_day"][$i][$j]["day"];
                    $f_ymd = $f_yy.$f_mm.$f_dd;
                    $all_ymd[] = $f_yy.$f_mm.$f_dd; //全出荷予定日

                    //変数名変更
                    $goods_id     = $order_d_data[$i][0];                         //商品ID
                    $forward_num  = $_POST["form_forward_num"][$i][$j];           //出荷数

                    //■受注ヘッダ用
                    $data_h[$f_ymd]["原価金額"][] = $order_d_data[$i][4] * $forward_num; //原価金額(伝票計算出に利用)
                    $data_h[$f_ymd]["売上金額"][] = $order_d_data[$i][9] * $forward_num; //売上金額(伝票計算出に利用)
                    $data_h[$f_ymd]["課税区分"][] = $order_d_data[$i][8];

                    //■受注データ用
                    $data_d[$f_ymd]["good_id"][]                   = $goods_id;                           //商品ID
                    $data_d[$f_ymd]["line"][]                      = $i;                                  //行数
                    $data_d[$f_ymd][$goods_id."-".$i][goods_name]  = addslashes($order_d_data[$i][2]);    //商品名
                    $data_d[$f_ymd][$goods_id."-".$i][num]         = $forward_num;                        //出荷数
                    $data_d[$f_ymd][$goods_id."-".$i][cost_price]  = $order_d_data[$i][4];                //原価単価
                    $data_d[$f_ymd][$goods_id."-".$i][sale_price]  = $order_d_data[$i][9];                //FC発注単価
                    $data_d[$f_ymd][$goods_id."-".$i][cost_amount] = $order_d_data[$i][4] * $forward_num; //原価金額（商品合計）
                    $data_d[$f_ymd][$goods_id."-".$i][sale_amount] = $order_d_data[$i][9] * $forward_num; //FC発注金額（商品合計）
                    $data_d[$f_ymd][$goods_id."-".$i][tax_div]     = $order_d_data[$i][8];                //課税区分

                }
            }
            Db_Query($db_con, "BEGIN;");

            //出荷予定日から重複を削除する
            $all_ymd_uniq = array_unique($all_ymd);
            asort($all_ymd_uniq);
            //print_array($all_ymd_uniq);

            /********************************/
            //受注ヘッダ登録
            /********************************/
            //二重に登録できなくするために、一度Getした発注IDに元ずくデータを削除する
            $sql  = "DELETE FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "WHERE \n";
            $sql .= "   fc_ord_id = $g_ord_id\n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, $sql);
                exit;
            }

            //出荷予定日(重複削除済)の数だけ受注ヘッダを登録する
            while($fw_day = array_shift($all_ymd_uniq)){
                //伝票番号
                //$order_no ++; //MAX+1
//                $order_no_pad = str_pad($auto_order_no, 8, 0, STR_PAD_LEFT);
                $order_no_pad = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

                //■原価合計(税込)を求める
                $cost_amount_h = array_sum($data_h["$fw_day"]["原価金額"]); //DBにカラムなし

                //■売上合計(税込)を　売上合計（税抜）と　消費税に分ける
                $total_amount = Total_Amount($data_h["$fw_day"]["売上金額"], $data_h["$fw_day"]["課税区分"], $coax,$tax_franct,$tax_num, $client_id, $db_con);
                $net_amount_h = $total_amount[0]; //売上合計
                $tax_amount_h = $total_amount[1]; //消費税

                //受注ヘッダテーブル登録
                $insert_sql  = " INSERT INTO t_aorder_h (\n";
                $insert_sql .= "    aord_id,\n";
                $insert_sql .= "    ord_no,\n";
                $insert_sql .= "    fc_ord_id,\n";
                $insert_sql .= "    ord_time,\n";
                $insert_sql .= "    client_id,\n";
                $insert_sql .= "    direct_id,\n";
                $insert_sql .= "    trade_id,\n";
                $insert_sql .= "    green_flg,\n";
                $insert_sql .= "    trans_id,\n";
                $insert_sql .= "    hope_day,\n";
                if($defd_ymd != "--"){
                //if($defd_ymd != null || $defd_ymd != "00000000"){
                    $insert_sql .= "    def_arrival_day,\n";
                }
                $insert_sql .= "    arrival_day,\n";
                $insert_sql .= "    note_my,\n";
                $insert_sql .= "    note_your,\n";
                $insert_sql .= "    ware_id,\n";
                $insert_sql .= "    ord_staff_id,\n";
                $insert_sql .= "    ps_stat,\n";
                $insert_sql .= "    c_staff_id,\n";
                $insert_sql .= "    cost_amount,\n";
                $insert_sql .= "    net_amount,\n";
                $insert_sql .= "    tax_amount,\n";
                $insert_sql .= "    shop_id,\n";
//              $insert_sql .= "    shop_gid";
//履歴用
                $insert_sql .= "    client_name,\n";
                $insert_sql .= "    client_name2,\n";
                $insert_sql .= "    client_cname,\n";
                $insert_sql .= "    client_cd1,\n";
                $insert_sql .= "    client_cd2,\n";
                $insert_sql .= "    direct_name,\n";
                $insert_sql .= "    direct_name2,\n";
                $insert_sql .= "    direct_cname,\n";
                $insert_sql .= "    trans_name,\n";
                $insert_sql .= "    trans_cname,\n";
                $insert_sql .= "    ware_name,\n";
                $insert_sql .= "    c_staff_name,\n";
                $insert_sql .= "    ord_staff_name, \n";    
                $insert_sql .= "    claim_id, \n";
                $insert_sql .= "    claim_div \n";
                $insert_sql .= " )values(\n";
                $insert_sql .= "    (SELECT COALESCE(MAX(aord_id), 0)+1 FROM t_aorder_h),\n";
                $insert_sql .= "    '$order_no_pad',\n";
                $insert_sql .= "    $g_ord_id,\n";
                $insert_sql .= "    '$ord_day',\n";
                $insert_sql .= "    $aord_client_id,\n";
                $insert_sql .= "    $direct_id,\n";
                $insert_sql .= "    '$trade_id',\n";
                if($green == "1"){
                    $insert_sql .= "    't',\n";
                }else{
                    $insert_sql .= "    'f',\n";
                }
                $insert_sql .= "    $trans_id,\n";
                if($hope_day == NULL){
                    $insert_sql .= "    NULL,\n";
                }else{
                    $insert_sql .= "    '$hope_day',\n";
                }
                if($defd_ymd != "--"){
                //if($defd_ymd != null || $defd_ymd != "00000000"){
                    $insert_sql .= "    '$defd_ymd',\n";
                }
                $insert_sql .= "    '$fw_day',\n";
//                $insert_sql .= "    '$def_note_my',\n";
                $insert_sql .= "    (SELECT note_your FROM t_order_h WHERE ord_id = $g_ord_id), \n";
                $insert_sql .= "    '$note_your',\n";
                $insert_sql .= "    $ware_id,\n";
                $insert_sql .= "    $staff_id,\n";
                $insert_sql .= "    '1',\n";
                $insert_sql .= "    $c_staff_id,\n";
                $insert_sql .= "    $cost_amount_h,\n";
                $insert_sql .= "    $net_amount_h,\n";
                $insert_sql .= "    $tax_amount_h,\n";
                $insert_sql .= "    $s_client_id,\n";
                $insert_sql .= "    (SELECT client_name FROM t_client WHERE client_id = $aord_client_id), \n";  //得意先名履歴用
                $insert_sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $aord_client_id), \n"; //得意先名２履歴用
                $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $aord_client_id), \n"; //略称履歴用
                $insert_sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $aord_client_id), \n";   //得意先コード１履歴用
                $insert_sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $aord_client_id), \n";   //得意先コード２履歴用
                $insert_sql .= "    (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id),\n";        //直送先名履歴用
                $insert_sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), \n";      //直送先名２履歴用
                $insert_sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), \n";      //直送先(略称)履歴用
                $insert_sql .= "    (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), \n";           //運送業者履歴用
                $insert_sql .= "    (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), \n";          //運送業者(略称)履歴用
                $insert_sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";               //倉庫ID履歴用
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id),\n";          //受注担当者履歴用
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id),\n";             //発注担当者履歴用
                $insert_sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $aord_client_id AND claim_div = '1'), \n"; //請求先ID
                $insert_sql .= "    '1' \n";                                                                    //請求先区分
//                $insert_sql .= "    $s_shop_gid";
                $insert_sql .= " );\n";

                $result = Db_Query($db_con, $insert_sql);
/*
                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
*/
                //発注番号が重複した場合は再度採番しなおす
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_h_ord_no_key";

                    Db_Query($db_con, "ROLLBACK;");
                    if(strstr($err_message, $err_format) != false){
                        $error = "同時に受注を行ったため、受注NOが重複しました。もう一度受注をして下さい。";

                        //再度発注NOを取得する
                        $sql  = "SELECT ";
                        $sql .= "   MAX(ord_no)";
                        $sql .= " FROM";
                        $sql .= "   t_aorder_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $s_client_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $order_no = pg_fetch_result($result, 0 ,0);
                        $order_no = $order_no +1;
                        $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                        $set_data["form_order_no"] = $order_no;

                        $form->setConstants($set_data);

                        $duplicate_flg = true;
                        break;
                    }else{
                        exit;
                    }
                }

                //伝票番号
//                (int)$auto_order_no ++;
                (int)$ord_no ++;

                /********************************/
                //受注データ登録
                /********************************/
                $line = 0;
                //$fw_day に出荷商品分ループ処理
                while( $fw_goods_id = array_shift($data_d[$fw_day]["good_id"])){

                    //出荷商品の入力行
                    $fw_goods_line = array_shift($data_d[$fw_day]["line"]);

                    //受注番号が重複した場合は以下の処理は実行しない
                    if($duplicate_flg == true){
                        break;
                    }

                    $tax_div       = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][tax_div];     //課税区分
                    $num           = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][num];         //出荷数
                    $cost_price    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][cost_price];  //原価単価
                    $sale_price    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][sale_price];  //売上単価
                    //print_array ($data_d);

//金額計算の際に精度関数がしようされていない
/*
                    $cost_amount   = $num * $cost_price;                          //原価金額
                    $sale_amount   = $num * $sale_price;                          //売上金額
*/
                    $cost_amount   = bcmul($num, $cost_price, 1);
                    $cost_amount   = Coax_Col($coax, $cost_amount);
                    $sale_amount   = bcmul($num, $sale_price, 1);
                    $sale_amount   = Coax_Col($coax, $sale_amount);
                    $goods_name    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][goods_name];  //商品名
                    $line++;       //行数

                    //消費税
    //                $tax = Total_Amount($sale_price, $tax_div,$coax,$tax_franct,$tax_num);
                    #echo $tax[1]."<br>"; //消費税

                   //受注データテーブル登録
                   $insert_sql  = " INSERT INTO t_aorder_d (";
                   $insert_sql .= "    aord_d_id,";
                   $insert_sql .= "    aord_id,";
                   $insert_sql .= "    line,";
                   $insert_sql .= "    sale_div_cd,";
                   $insert_sql .= "    goods_id,";
                   $insert_sql .= "    official_goods_name,";
                   $insert_sql .= "    num,";
                   $insert_sql .= "    tax_div,";
                   $insert_sql .= "    cost_price,";
                   $insert_sql .= "    sale_price,";
                   $insert_sql .= "    cost_amount,";
                   $insert_sql .= "    sale_amount, ";
                   $insert_sql .= "    goods_cd ";
    //               $insert_sql .= "    tax_amount";
                   $insert_sql .= " )VALUES(";
                   $insert_sql .= "    (SELECT COALESCE(MAX(aord_d_id), 0)+1 FROM t_aorder_d),";
                   $insert_sql .= "    (SELECT aord_id FROM t_aorder_h WHERE fc_ord_id = '$g_ord_id' AND arrival_day = '$fw_day'),";
                   $insert_sql .= "    $line,";
                   $insert_sql .= "    '02',";
                   $insert_sql .= "    $fw_goods_id,";
                   $insert_sql .= "    '$goods_name',";
                   //$insert_sql .= "    (SELECT goods_name FROM t_order_d WHERE ord_id = $g_ord_id AND line = $line),";
                   $insert_sql .= "    $num,";
                   $insert_sql .= "    $tax_div,";
                   $insert_sql .= "    $cost_price,";
                   $insert_sql .= "    $sale_price,";
                   $insert_sql .= "    $cost_amount,";
                   $insert_sql .= "    $sale_amount, ";
                   $insert_sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $fw_goods_id) ";
    //               $insert_sql .= "    $tax[1]";
                   $insert_sql .= " );";
                   $result = Db_Query($db_con, $insert_sql);
                   //$result = Db_Query($db_con, $insert_sql,1);

                   if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }
                    //受注データID取得 
                   $select_sql = " SELECT";
                   $select_sql .= "    t_aorder_d.aord_d_id";
                   $select_sql .= " FROM";
                   $select_sql .= "    t_aorder_h,";
                   $select_sql .= "    t_aorder_d";
                   $select_sql .= " WHERE";
                   $select_sql .= "    t_aorder_h.aord_id = t_aorder_d.aord_id";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_h.fc_ord_id = $g_ord_id";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_h.arrival_day = '$fw_day'";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_d.goods_id = $fw_goods_id";
                   $select_sql .= " ;";
                   $result = Db_Query($db_con, $select_sql);
                   $aord_d_id = @pg_fetch_result($result, 0 ,0);
 
                  if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }

                   //在庫受払テーブルにINSERT
                   $insert_sql = " INSERT INTO t_stock_hand(";
                   $insert_sql .= "    goods_id,";
                   $insert_sql .= "    enter_day,";
                   $insert_sql .= "    work_day,";
                   $insert_sql .= "    work_div,";
                   $insert_sql .= "    client_id,";
                   $insert_sql .= "    ware_id,";
                   $insert_sql .= "    io_div,";
                   $insert_sql .= "    num,";
                   $insert_sql .= "    slip_no,";
                   $insert_sql .= "    aord_d_id,";
                   $insert_sql .= "    shop_id,";
                   $insert_sql .= "    staff_id,";
                   $insert_sql .= "    client_cname";
                   $insert_sql .= " )values(";
                   $insert_sql .= "    $fw_goods_id,";
                   $insert_sql .= "    NOW(),";
                   $insert_sql .= "    '$ord_day',";
                   $insert_sql .= "    '1',";
                   $insert_sql .= "    $aord_client_id,";
                   $insert_sql .= "    $ware_id,";
                   $insert_sql .= "    '2',";
                   $insert_sql .= "    $num,";
                   $insert_sql .= "    '$order_no_pad',";
                   $insert_sql .= "    $aord_d_id,";
                   $insert_sql .= "    $s_client_id,";
                   $insert_sql .= "    $staff_id,";
                   $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $aord_client_id)";
                   $insert_sql .= " );";
                   $result = Db_Query($db_con, $insert_sql);
                   if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }
                }
            }

            if($duplicate_flg != true){
                //発注ヘッダテーブル更新
                $update_sql = " UPDATE t_order_h";
                $update_sql .= " SET ";
                $update_sql .= "    arrival_day = ";
                $update_sql .= " (SELECT";
                $update_sql .= "    MIN(arrival_day)";
                $update_sql .= "  FROM";
                $update_sql .= "    t_aorder_h";
                $update_sql .= "  WHERE";
                $update_sql .= "    fc_ord_id = $g_ord_id";
                $update_sql .= " ),";
                $update_sql .= "    ord_stat = '2', ";
                $update_sql .= "    trans_id = $trans_id ";
                $update_sql .= " WHERE ";
                $update_sql .= "    ord_id = '$g_ord_id'";
                $update_sql .= ";";
                $result = Db_Query($db_con, $update_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                Db_Query($db_con, "COMMIT;");
                header("Location: ./1-2-108.php?fc_ord_id=$g_ord_id");
            }
        }else{
            //登録確認画面を表示フラグ
            $comp_flg = true;
        }
    }
}

//登録確認画面では、以下のボタンを表示しない
if($comp_flg != true){

    $button[] = $form->createElement("submit","entry","登録／返信確認画面へ","$disabled");
    $button[] = $form->createElement(
            "submit","alert_ok","警告を無視して登録","onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled"
            );
    if($_GET["return_flg"] == 1){
        $button[] = $form->createElement(
            "button","back","戻　る","onClick=\"location.href='./1-2-102.php?search=1'\""
            );
    }elseif($_GET["retrun_flg"] == 2){
        $button[] = $form->createElement(
            "button","back","戻　る","onClick=\"location.href='./1-2-105.php?search=1'\""
            );
    }

    $form->addGroup($button, "button", "");

}else{
    //登録確認画面では以下のボタンを表示
    //戻る
    $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
    
    //OK
    $form->addElement("submit","comp_button","登録／返信OK","$disabled");
    
    $form->freeze();
}

//各行の出荷数分の要素の配列定義
for($x=0;$x<count($array_count);$x++){
    for($j=0;$j<=$array_count[$x];$j++){
        $disp_count[$x][$j] = "a";
    }
}

//ナンバーフォーマット等
for($i = 0; $i < count($order_d_data); $i++){
    $order_d_data[$i][2]  = htmlspecialchars($order_d_data[$i][2]);

    //受注数が実棚数より多い場合、数字を赤くする
    if($order_d_data[$i][12] < $order_d_data[$i][3]){
        $tmp  = "<font color=\"red\">";
        $tmp .= (string)number_format($order_d_data[$i][3]);
        $tmp .= "</font>";
    }else{
        $tmp  = number_format($order_d_data[$i][3]);
    }
    $order_d_data[$i][3] = $tmp;

    $order_d_data[$i][4]  = number_format($order_d_data[$i][4],2);
//    $order_d_data[$i][4]  = number_format($order_d_data[$i][4],2);
    $order_d_data[$i][5]  = number_format($order_d_data[$i][5],2);
    $order_d_data[$i][6]  = number_format($order_d_data[$i][6]);
    $order_d_data[$i][7]  = number_format($order_d_data[$i][7]);
    $order_d_data[$i][9]  = number_format($order_d_data[$i][9],2);
    $order_d_data[$i][10] = number_format($order_d_data[$i][10]);
    $order_d_data[$i][12] = My_number_format($order_d_data[$i][12]);
    $order_d_data[$i][13] = My_number_format($order_d_data[$i][13]);
    $order_d_data[$i][14] = number_format($order_d_data[$i][14]);
    $order_d_data[$i][15] = number_format($order_d_data[$i][15]);
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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('row',$order_d_data);
$smarty->assign('stock',$stock_data);
$smarty->assign('num',$select_page_arr);
$smarty->assign('disp_count',$disp_count);

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'fc_ord_id'         => "$fc_ord_id",
    'hope_day'          => "$hope_day",
    'green'             => "$green",
    'client_name'       => "$client_name",
    'direct_name'       => "$direct_name",
    'note_my'           => "$note_my",
    'forward_num'       => "$forward_num",
    'num'               => "$num",
    'form_ord_day_err'  => "$form_ord_day_err",
    'forward_day_err'   => "$forward_day_err",
    'forward_num_err'   => "$forward_num_err",
    'alert_message'     => "$alert_message",
    'alert_output'      => "$alert_output",
    'form_def_day_err'  => "$form_def_day_err",
    'comp_flg'          => "$comp_flg",
    'error'             => "$error",
    'price_warning'     => "$price_warning",
    'client_cd'         => "$client_cd",
));
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

/*
print "<pre>";
print_r($_POST);
print "</pre>";
*/
?>
