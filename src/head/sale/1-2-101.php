<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/29) 実棚数ダイアログのバグを修正(suzuki-t)
 * 1.0.1 (2006/03/29) 引当数が正しく表示されないバグを修正(suzuki-t)
 * 1.0.2 (2006/03/29) 伝票番号の０埋めのバグを修正(suzuki-t)
 * 1.0.3 (2006/03/29) 発注済数のバグを修正(suzuki-t)
 * (2006/07/26) 商品の抽出条件変更(watanabe-k)
 * (2006/07/31) 消費税計算方法変更(watanabe-k)
 * (2006/09/13) レンタル登録から遷移した場合に、レンタル情報を復元するように変更(suzuki-t)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/30      08-021      ふ          得意先名を略称表示に変更
 *  2006/10/30      08-060      ふ          得意先リンク（得意先一覧ダイアログ）に直営ショップが出力されていないバグを修正
 *  2006/10/31      08-012      watanabe-k  チェック完了処理中に別画面で受注を削除された場合にTOP画面に戻るバグの修正
 *  2006/10/31      08-022      watanabe-k  オフライン受注変更時、商品変更や商品追加ができないバグの修正
 *  2006/10/31      08-023      watanabe-k  入力チェック時商品名が途中から途切れるバグの修正 
 *  2006/11/01      08-014      watanabe-k  排他制御を行っていないバグの修正 
 *  2006/11/03      08-062      watanabe-k  得意先コードをNULLで登録するとクエリエラーが表示されるバグの修正
 *  2006/11/03      08-083      watanabe-k  Getチェック追加
 *  2006/11/03      08-084      watanabe-k  08-085と同じ
 *  2006/11/03      08-085      watanabe-k  Getチェック追加
 *  2006/11/03      08-086      watanabe-k  Getチェック追加
 *  2006/11/09      08-138      suzuki      受注伝票から得意先情報を取得
 *  2006/11/09      08-139      suzuki      運送業者・直送先の略称を登録
 *  2006/11/09      08-127      watanabe-k  出荷予定日、希望納期をNULLにして登録が可能なバグの修正
 *  2006/11/27      scl_0027    watanabe-k  在庫管理しない商品の出荷予定数が表示されているバグの修正
 *  2006/11/29      scl_××    suzuki      変更時に入力チェックフラグを初期化
 *  2006/11/29      scl_202-3-1 suzuki      レンタルから遷移してきた場合に、レンタルの本部担当者を初期表示選択
 *  2006/12/13      0056        suzuki      変更時に受注担当者欄にオペレータを表示していたのを修正
 *  2006/11/07                  watanabe-k  チェック完了処理を削除し、登録時にはかならずチェック完了状態になるように変更 
 *  2007/01/25                  watanabe-k  ボタンの色変更 
 *  2007/02/28                  morita-d    商品名は正式名称を表示するように変更 
 *  2007/03/13                  watanabe-k  取引区分に選択したFCのものを表示するように修正
 *  2007/05/14                  watanabe-k  商品名の登録カラムをofficial_goods_name に修正
 *  2007/05/14                  watanabe-k  請求先IDを残すように修正
 *  2007/05/17                  watanabe-k  直送先プルダウンを当幅に変更
 *  2007/09/20                  watanabe-k  実棚数のサブウィンドウが正しく表示されないバグの修正
 *  2009/10/01 		rev.1.2		kajioka-h	分納機能追加
 *  2009/10/09 		rev.1.3		kajioka-h	直送先テキスト入力・ダイアログ化
 *  		 		rev.1.3		kajioka-h	ショップごとに商品の在庫管理フラグを持つ変更対応
 *   2009/12/21                 aoyama-n    税率をTaxRateクラスから取得
 *   2016/01/22                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応
 */
$page_title = "受注入力(オフライン)";

//環境設定ファイル Environment set up file
require_once("ENV_local.php");

//HTML_QuickFormを作成 Create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//$form =& new HTML_QuickForm("dateForm", "POST", "#");

//DB接続 Connect to DB
$db_con = Db_Connect();

// 権限チェック authority check
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ message for no input/edit authority
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled Button Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// 再遷移先をSESSIONにセット Set the redirect page to SESSION
/*****************************/
// GET、POSTが無い場合 if there  is no GET POST
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("aord");
}


/****************************/
//外部変数取得 acquire the external variable
/****************************/
$shop_id     = $_SESSION["client_id"];
$rank_cd     = $_SESSION["rank_cd"];
$o_staff_id  = $_SESSION["staff_id"];
$aord_id     = $_GET["aord_id"];
//$check_flg   = $_GET["check_flg"];      //受注照会判定フラグ  order inquiry deecision flag
$rental_flg  = $_POST["rental_flg"];    //レンタル情報復元フラグ rental information restoration flag

//受注IDをhiddenにより保持する store the order ID by making it hidden
Get_Id_Check3($_GET["aord_id"]);
if($_GET["aord_id"] != NULL){
	$set_id_data["hdn_aord_id"] = $aord_id;
	$form->setConstants($set_id_data);
}else{
	$aord_id = $_POST["hdn_aord_id"];
}

//受注照会判定フラグをhiddenにより保持する store the order inquiry decision flag by making it hidden

/**********************************************************

if($_GET["check_flg"] != NULL){
	$set_flg_data["hdn_check_flg"] = $check_flg;
	$form->setConstants($set_flg_data);
}else{
	$check_flg = $_POST["hdn_check_flg"];
}

***********************************************************/

//得意先が指定されているか is the customer assigned
if($_POST["hdn_client_id"] == null){
	$warning = "得意先を選択して下さい。";
}else{
	$warning = null;
	$client_id    = $_POST["hdn_client_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    $client_name  = $_POST["form_client"]["name"];
	$hdn_goods_id = $_POST["hdn_goods_id"];
	$stock_num    = $_POST["hdn_stock_num"];
}

//持ちまわる値を取得 acquire value
$hdn_name_change = $_POST["hdn_name_change"];
$hdn_stock_manage = $_POST["hdn_stock_manage"];

/****************************/
//初期設定 initial setting
/****************************/

#2009-12-21 aoyama-n
//税率クラス　インスタンス生成 tax rate create an instance
$tax_rate_obj = new TaxRate($shop_id);

//変更処理判定 edit process decision
if($aord_id != NULL && $client_id == NULL && $_POST[complete_flg] != true){

	//受注ヘッダ取得SQL SQL that aquire order header
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.ord_no,";
	$sql .= "    t_aorder_h.ord_time,";
	$sql .= "    t_aorder_h.hope_day,";
	$sql .= "    t_aorder_h.arrival_day,";
	$sql .= "    t_aorder_h.green_flg,";
	$sql .= "    t_aorder_h.trans_id,";
	$sql .= "    t_aorder_h.client_id,";
	//$sql .= "    t_client.client_cd1,";
	//$sql .= "    t_client.client_cd2,";
	//$sql .= "    t_client.client_cname,";
	$sql .= "    t_aorder_h.client_cd1,";
	$sql .= "    t_aorder_h.client_cd2,";
	$sql .= "    t_aorder_h.client_cname,";
	$sql .= "    t_aorder_h.direct_id,";
	$sql .= "    t_aorder_h.ware_id,";
	$sql .= "    t_aorder_h.trade_id,";
	$sql .= "    t_aorder_h.c_staff_id,";
	$sql .= "    t_aorder_h.note_your,";
	$sql .= "    t_aorder_h.note_my ";

	//rev.1.3 直送先テキスト化 transform direct destination to text
	$sql .= ",";
	$sql .= "    t_direct.direct_cd, ";			//直送先CD direct destional CD
	$sql .= "    t_aorder_h.direct_cname, ";	//直送先略称 direct destination abbreviation
	$sql .= "    t_direct_claim.client_cname AS direct_claim ";	//直送先請求先 direct destination billing destination


	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	//$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	//rev.1.3 直送先テキスト化 transform direct destination to text
	$sql .= "    LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
	$sql .= "    LEFT JOIN t_client AS t_direct_claim ON t_direct.client_id = t_direct_claim.client_id ";

	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.aord_id = $aord_id ";
	$sql .= "    AND ";
    $sql .= "    t_aorder_h.ps_stat = '1'";
    $sql .= "    AND ";
    $sql .= "    t_aorder_h.fc_ord_id IS NULL ";

/*******************************************************

    if($check_flg == "true"){
        $sql .= "AND ";
        $sql .= "t_aorder_h.check_flg = 'f'";
    }

********************************************************/

    $sql .= ";";

	$result = Db_Query($db_con,$sql);
	//GETデータ判定 GET data decision
	Get_Id_Check($result);
	$h_data_list = Get_Data($result,2);

	//受注データ取得SQL SQL that acquire order data
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";		//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "   t_aorder_d.goods_cd,\n";
//    $sql .= "   t_aorder_d.goods_name,\n";
    $sql .= "   t_aorder_d.official_goods_name,\n";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_stock.stock_num,0)\n";
    $sql .= "   END AS rack_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_stock_io.order_num,0)\n";
    $sql .= "   END AS on_order_num,";
    //$sql .= "   CASE t_goods.stock_manage\n";
    $sql .= "   CASE t_goods_info.stock_manage\n";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "       WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) \n";
//    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) \n";
	$sql .= "   END AS allowance_total, \n";
    $sql .= "   COALESCE(t_stock.stock_num,0) \n"; 
    $sql .= "       + COALESCE(t_stock_io.order_num,0) \n";
//    $sql .= "       - (COALESCE(t_stock.rstock_num,0) \n";
    $sql .= "       - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total, \n";
    $sql .= "   t_aorder_d.num, \n";
	$sql .= "   t_aorder_d.tax_div, \n";
	$sql .= "   t_aorder_d.cost_price, \n";
	$sql .= "   t_aorder_d.sale_price, \n";
	$sql .= "   t_aorder_d.cost_amount, \n";
    #2009-09-29 hashimoto-y
	#$sql .= "   t_aorder_d.sale_amount  \n";
	$sql .= "   t_aorder_d.sale_amount,  \n";
    $sql .= "   t_goods.discount_flg \n";
    $sql .= " FROM \n";
	$sql .= "   t_aorder_d \n";

	$sql .= "       INNER JOIN\n";
    $sql .= "   t_aorder_h\n";
    $sql .= "   ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";

    $sql .= "       INNER JOIN\n";
    $sql .= "   t_goods\n";
    $sql .= "   ON t_aorder_d.goods_id = t_goods.goods_id \n";

    $sql .= "       LEFT JOIN\n";

    //在庫数 stock count
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock.goods_id,\n";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    //$sql .= "       t_stock.shop_id =  ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock.shop_id =  ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "   GROUP BY t_stock.goods_id\n";
    $sql .= "   )AS t_stock\n";
    $sql .= "   ON t_aorder_d.goods_id = t_stock.goods_id";

    $sql .= "       LEFT JOIN\n";

    //発注残数 remaining ordered goods but not yet delviered
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 3\n";
    $sql .= "       AND\n";
    //$sql .= "       t_stock_hand.shop_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//    $sql .= "       AND\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_aorder_d.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //引当数 count of stocks that are ordered already
    $sql .= "   (SELECT\n";
    $sql .= "       t_stock_hand.goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_ware\n";
    $sql .= "       ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_stock_hand.work_div = 1\n";
    $sql .= "       AND\n";
    //$sql .= "       t_stock_hand.shop_id = ".$h_data_list[0][6]."\n";
    $sql .= "       t_stock_hand.shop_id = ".$shop_id."\n";
    $sql .= "       AND\n";
    $sql .= "       t_ware.count_flg = 't'\n";
    $sql .= "       AND\n";
//	$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + 7)\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io\n";
    $sql .= "   ON t_aorder_d.goods_id = t_allowance_io.goods_id \n";

	$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop

    $sql .= " WHERE \n";
    $sql .= "       t_aorder_d.aord_id = $aord_id \n";
    $sql .= "       AND \n";
    $sql .= "       t_aorder_h.shop_id = $shop_id \n";

	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "       AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

	$sql .= " ORDER BY t_aorder_d.line;";

    $result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result,2);

	//得意先の情報を抽出 extract the information of the customer
    $sql  = "SELECT";
	$sql .= "   client_id,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   shop_id";
//    $sql .= "   attach_gid ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = ".$h_data_list[0][6];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
	$client_list = Get_Data($result,2);

	/****************************/
	//フォームに値を復元 restore the value to form
	/****************************/
	$sale_money = NULL;                        //商品の売上金額 sales of the particular product
    $tax_div    = NULL;                        //課税区分 taxation classification

	//ヘッダー復元 restore header
	$update_goods_data["form_order_no"]                = $h_data_list[0][0];  //受注番号 order number

	//受注日を年月日に分ける separate the order date into year month and day 
	$ex_ord_day = explode('-',$h_data_list[0][1]);
	$update_goods_data["form_ord_day"]["y"]            = $ex_ord_day[0];   //受注日 order data
	$update_goods_data["form_ord_day"]["m"]            = $ex_ord_day[1];   
	$update_goods_data["form_ord_day"]["d"]            = $ex_ord_day[2];   

	//希望納期を年月日に分ける separate the desired delivery date into year month and day
	$ex_hope_day = explode('-',$h_data_list[0][2]);
	$update_goods_data["form_hope_day"]["y"]           = $ex_hope_day[0];  //希望納期 desired delivery date
	$update_goods_data["form_hope_day"]["m"]           = $ex_hope_day[1];   
	$update_goods_data["form_hope_day"]["d"]           = $ex_hope_day[2];   

	//入荷予定日を年月日に分ける separate the scheduled delivery date by year month and day
	$ex_arr_day = explode('-',$h_data_list[0][3]);
	$update_goods_data["form_arr_day"]["y"]            = $ex_arr_day[0];   //入荷予定日 scheduled delovery date
	$update_goods_data["form_arr_day"]["m"]            = $ex_arr_day[1];   
	$update_goods_data["form_arr_day"]["d"]            = $ex_arr_day[2];   

	//チェックを付けるか判定 decide if it will be checked or not
    if($h_data_list[0][4]=='t'){
        $update_goods_data["form_trans_check"]         = $h_data_list[0][4];  //グリーン指定 green destination
    }

	$update_goods_data["form_trans_select"]            = $h_data_list[0][5];  //運送業者 carrier
	$update_goods_data["form_client"]["cd1"]           = $h_data_list[0][7];  //得意先コード１ customer code 1 
	$update_goods_data["form_client"]["cd2"]           = $h_data_list[0][8];  //得意先コード２ customer code 1
	$update_goods_data["form_client"]["name"]          = $h_data_list[0][9];  //得意先名 customer name
	$update_goods_data["form_direct_select"]           = $h_data_list[0][10]; //直送先 direct destination
	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
	$update_goods_data["form_direct_text"]["cd"]       = $h_data_list[0][16]; //直送先CD direct destination CD
	$update_goods_data["form_direct_text"]["name"]     = $h_data_list[0][17]; //直送先略称 direct destination abbreviation
	$update_goods_data["form_direct_text"]["claim"]    = $h_data_list[0][18]; //直送先請求先 direct destination billing destination

	$update_goods_data["form_ware_select"]             = $h_data_list[0][11]; //倉庫 warehouse
	$update_goods_data["trade_aord_select"]            = $h_data_list[0][12]; //取引区分 trade classifcation
	$update_goods_data["form_staff_select"]            = $h_data_list[0][13]; //担当者 assigned staff 
	$update_goods_data["form_note_client"]             = $h_data_list[0][14]; //通信欄（得意先） communication field (addressed to customer)
	$update_goods_data["form_note_head"]               = $h_data_list[0][15]; //通信欄（本部）communication column (HQ)

	//データ復元 restore data
	for($i=0;$i<count($data_list);$i++){
	    $update_goods_data["hdn_goods_id"][$i]         = $data_list[$i][0];   //商品ID product ID
		$hdn_goods_id[$i]                              = $data_list[$i][0];   //POSTする前に商品IDを総在庫数で使用する為 For the reason that product ID will be used in the total inventory count before POST

		$update_goods_data["hdn_name_change"][$i]      = $data_list[$i][1];   //品名変更フラグ product name change flag
		$hdn_name_change[$i]                           = $data_list[$i][1];   //POSTする前に商品名の変更不可判定を行なう為 For the reason that product name will be checked if it is non-editable before POST


		$update_goods_data["hdn_stock_manage"][$i]     = $data_list[$i][2];   //在庫管理 inventory control
		$hdn_stock_manage[$i]                          = $data_list[$i][2];   //POSTする前に実棚数の在庫管理判定を行なう為 For the reason that actual shelf number will be decided in inventory control before POST

		$update_goods_data["form_goods_cd"][$i]        = $data_list[$i][3];   //商品CD product CD
		$update_goods_data["form_goods_name"][$i]      = $data_list[$i][4];   //商品名 product Name

		$update_goods_data["form_stock_num"][$i]       = number_format($data_list[$i][5]);   //実棚数 actual shelf number
		$update_goods_data["hdn_stock_num"][$i]        = number_format($data_list[$i][5]);   //実棚数（hidden）actual shelf number (hidden)
		$stock_num[$i]                                 = number_format($data_list[$i][5]);   //実棚数(リンクの値) actual shelf number (link's value)

        if($hdn_stock_manage[$i] != 2){
		    $update_goods_data["form_rorder_num"][$i]      = $data_list[$i][6];   //発注済数 purchase ordered number
		    $update_goods_data["form_rstock_num"][$i]      = $data_list[$i][7];   //引当数 number of product resereved for order
		    $update_goods_data["form_designated_num"][$i]  = $data_list[$i][8];   //出荷可能数 deliverable number of inventory 
        }
		$update_goods_data["form_sale_num"][$i]        = $data_list[$i][9];   //受注数 number of sales order
		$update_goods_data["hdn_tax_div"][$i]          = $data_list[$i][10];  //課税区分 taxation classification

	    //原価単価を整数部と少数部に分ける separate the decimal from integer for the product cost
        $cost_price = explode('.', $data_list[$i][11]);
		$update_goods_data["form_cost_price"][$i]["i"] = $cost_price[0];  //原価単価 product cost per unit
		$update_goods_data["form_cost_price"][$i]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     
		$update_goods_data["form_cost_amount"][$i]     = number_format($data_list[$i][13]);  //原価金額 cost price

		//売上単価を整数部と少数部に分ける separate the decimal from integer for the sales price per unit
        $sale_price = explode('.', $data_list[$i][12]);
		$update_goods_data["form_sale_price"][$i]["i"] = $sale_price[0];  //売上単価 sales price per unit
		$update_goods_data["form_sale_price"][$i]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';
		$update_goods_data["form_sale_amount"][$i]     = number_format($data_list[$i][14]);  //売上金額 sales price

		$sale_money[]                                  = $data_list[$i][14];  //売上金額合計 total sales price
        $tax_div[]                                     = $data_list[$i][10];  //課税区分 taxation classification

        #2009-09-29 hashimoto-y
        $update_goods_data["hdn_discount_flg"][$i]     = $data_list[$i][15];  //値引きフラグ discount flag
    }

	//得意先情報復元 restore customer information
	$client_id      = $client_list[0][0];        //得意先ID customer ID
	$coax           = $client_list[0][1];        //丸め区分（金額） round up/down classification (amount)
    $tax_franct     = $client_list[0][2];        //端数区分（消費税）  round up/down classification (consumption tax)
//    $attach_gid     = $client_list[0][3];        //所属グループ belonged group
	$warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
//    $update_goods_data["attach_gid"]          = $attach_gid;

	//現在の消費税率 current consumption tax rate
    #2009-12-21 aoyama-n
	#$sql  = "SELECT ";
	#$sql .= "    tax_rate_n ";
	#$sql .= "FROM ";
	#$sql .= "    t_client ";
	#$sql .= "WHERE ";
	#$sql .= "    client_id = $shop_id;";
	#$result = Db_Query($db_con, $sql); 
	#$tax_num = pg_fetch_result($result, 0,0);
 
    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($h_data_list[0][1]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

	$sale_money = number_format($total_money[0]);
	$tax_money  = number_format($total_money[1]);
	$st_money   = number_format($total_money[2]);

	//フォームに値セット set the value to the form
	$update_goods_data["form_sale_total"]      = $sale_money;
	$update_goods_data["form_sale_tax"]        = $tax_money;
	$update_goods_data["form_sale_money"]      = $st_money;
	$update_goods_data["sum_button_flg"]       = "";
	$update_goods_data["form_designated_date"] = 7; //出荷可能数 possible number of delivery

    $form->setConstants($update_goods_data);

	//表示行数 displayed number of row 
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
		//受注データの数 number of sales order data
	    $max_row = count($data_list);
	}

	//rev.1.2 通常オフライン受注変更判定フラグ decision flag for editing a normall offline order
	$edit_flg = "true";

}else{
	//自動採番の受注番号取得 acquire sales order number that will be auto filled
	$sql  = "SELECT";
	$sql .= "   MAX(ord_no)";
	$sql .= " FROM";
	$sql .= "   t_aorder_h";
	$sql .= " WHERE";
	$sql .= "   shop_id = $shop_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$order_no = pg_fetch_result($result, 0 ,0);
	$order_no = $order_no +1;
	$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

	$def_data["form_order_no"] = $order_no;

	//出荷可能数 deliverable numer of units of stock
	$def_data["form_designated_date"] = 7;
	//担当者 assigned staff
	$def_data["form_staff_select"] = $o_staff_id;
	//取引区分 trade classification
	$def_data["trade_aord_select"] = 11;

    $def_data["form_ord_day"]["y"] = date('Y');
    $def_data["form_ord_day"]["m"] = date('m');
    $def_data["form_ord_day"]["d"] = date('d');

    $def_data["form_hope_day"]["y"] = date('Y', mktime(0,0,0,date('m'), date('d')+2, date('Y')));
    $def_data["form_hope_day"]["m"] = date('m', mktime(0,0,0,date('m'), date('d')+2, date('Y')));
    $def_data["form_hope_day"]["d"] = date('d', mktime(0,0,0,date('m'), date('d')+2, date('Y')));

    $def_data["form_arr_day"]["y"] = date('Y', mktime(0,0,0,date('m'), date('d')+1, date('Y')));
    $def_data["form_arr_day"]["m"] = date('m', mktime(0,0,0,date('m'), date('d')+1, date('Y')));
    $def_data["form_arr_day"]["d"] = date('d', mktime(0,0,0,date('m'), date('d')+1, date('Y')));

    $sql  = "SELECT";
    $sql .= "   ware_id ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = 1";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $def_ware_id = pg_fetch_result($result, 0,0);

    $def_data["form_ware_select"] = $def_ware_id;

	$form->setDefaults($def_data);

	//表示行数 number of rows to display
	if($_POST["max_row"] != NULL){
	    $max_row = $_POST["max_row"];
	}else{
	    $max_row = 5;
	}

	//rev.1.2 通常オフライン受注変更判定フラグ decision flag for editing a normall offline order
	$edit_flg = $_POST["hdn_edit_flg"];

}

//rev.1.2 通常オフライン受注変更判定フラグをhiddenにセット set decision flag for editing a normall offline order to hidden
$form->setConstants(array("hdn_edit_flg" => $edit_flg));

//初期表示位置変更 change the initial view position 
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//削除行数 deleted row number
$del_history[] = NULL; 
/****************************/
//行数追加処理 process for adding rows
/****************************/
if($_POST["add_row_flg"]==true){
/*
	if($_POST["max_row"] == NULL){
		//初期値はPOSTが無い為、since initial value doesnt have POST
		$max_row = 5;
	}else{
*/
		//最大行に、＋１する +1 to max row number
    	$max_row = $_POST["max_row"]+5;
//	}

    //行数追加フラグをクリア clear the row addition flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
/****************************/
//行削除処理 row deletion process
/****************************/
if($_POST["del_row"] != ""){

    //削除リストを取得 acquire the deleted list
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。turn the deletion history into array
    $del_history = explode(",", $del_row);
    //削除した行数 number of deleted rows
    $del_num     = count($del_history)-1;
}

//***************************/
//最大行数をhiddenにセット set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

//***************************/
//グリーン指定チェック処理 green designation check process
/****************************/
//チェックの場合は、運送業者のプルダウンの値を変更する if there is a check, then change the value of the carrier's dropdown
if($_POST["trans_check_flg"] == true){
	$where  = " WHERE ";
	$where .= "    shop_id = $shop_id";
	$where .= " AND";
	$where .= "    green_trans = 't'";

	//初期化 initialization
    $trans_data["trans_check_flg"]   = "";
	$form->setConstants($trans_data);
}else{
	$where = "";
}

/****************************/
//部品作成 create component
/****************************/

//受注番号 sales order number
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #585858; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);
 
//出荷可能数 sales order number
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right;$g_form_style\"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true', this)\"
    "
);

//受注日 sales order date
$form_ord_day[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[y]','form_ord_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ord_day[m]','form_ord_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_ord_day[y]','form_ord_day[m]','form_ord_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_ord_day,"form_ord_day","form_ord_day");

//希望納期 desired delivery date
$form_hope_day[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[y]','form_hope_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hope_day[m]','form_hope_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form_hope_day[] =& $form->createElement("static","","","-");
$form_hope_day[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_hope_day,"form_hope_day","form_hope_day");

//入荷予定日 desired delivery date
$form_arr_day[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[y]','form_arr_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_arr_day[m]','form_arr_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form_arr_day[] =& $form->createElement("static","","","-");
$form_arr_day[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'form_arr_day[y]','form_arr_day[m]','form_arr_day[d]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_arr_day,"form_arr_day","form_arr_day");

//得意先コード customer code
$freeze = $form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
if($_GET[aord_id] != null){
    $freeze->freeze();
}
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$freeze = $form_client[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true', this)\"".$g_form_option."\""
        );
if($_GET[aord_id] != null){
    $freeze->freeze();
}
$form_client[] =& $form->createElement("text","name","テキストフォーム","size=\"34\" $g_text_readonly");
$form->addGroup( $form_client, "form_client", "");

//売上金額合計 total sales amount
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"$g_form_style;color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計) tax amount (total)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計) sales amount (with consumption tax)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//通信欄（得意先宛） communication field  (addressed to customer)
$form->addElement("textarea","form_note_client","テキストフォーム",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');
//通信欄（本部宛）communication field (HQ)
$form->addElement("textarea","form_note_head","テキストフォーム",' rows="2" cols="75" onFocus="onForm(this)" onBlur="blurForm(this)"');

//グリーン指定 Green designation
$form->addElement('checkbox', 'form_trans_check', 'グリーン指定', '<b>グリーン指定</b>　',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");
//運送業者 carrier
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', 'セレクトボックス', $select_value,$g_form_option_select);

//直送先 direct destination
//$select_value = Select_Get($db_con,'direct');
//$form->addElement('select', 'form_direct_select', 'セレクトボックス', $select_value,"class=\"Tohaba\"".$g_form_option_select);
//rev.1.3 テキスト入力へ変更 change to text input
$form_direct[] = $form->createElement(
    "text","cd","","size=\"4\" maxLength=\"4\"
     style=\"$g_form_style\"
     onChange=\"javascript:Button_Submit('hdn_direct_search_flg','#','true', this)\"
     $g_form_option"
);
$form_direct[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly");
$form_direct[] = $form->createElement(
    "text","claim","",
    "size=\"34\" $g_text_readonly");
$form->addGroup($form_direct, "form_direct_text", "");

//倉庫 warehouse
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_ware_select', 'セレクトボックス', $select_value,$g_form_option_select);
//取引区分 trade classification
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'trade_aord_select', 'セレクトボックス', $select_value,$g_form_option_select);
//担当者 assigned staff
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', 'セレクトボックス', $select_value,$g_form_option_select);

//受注 sales order
//$form->addElement("submit","order","受　注","onClick=\"javascript:Dialogue('受注します。','#')\"");
//1.0.4 (2006/03/29) kaji 確認ダイアログのキャンセルボタン押下時でも登録されてしまうバグ対策

//チェック完了 done with checking
//$form->addElement("button","complete","チェック完了","onClick=\"javascript:Dialogue_2('チェックを完了します。','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg')\"");
//1.0.4 (2006/03/29) kaji 確認ダイアログのキャンセルボタン押下時でも登録されてしまうバグ対策


// ヘッダ部リンクボタン header link button
$ary_h_btn_list = array("照会・変更" => "./1-2-105.php", "入　力" => $_SERVER["PHP_SELF"], "受注残一覧" => "./1-2-106.php");
Make_H_Link_Btn($form, $ary_h_btn_list);

//hidden
$form->addElement("hidden", "hdn_client_id");       //得意先ID customer ID
$form->addElement("hidden", "hdn_aord_id");         //受注ID sales order ID
//$form->addElement("hidden", "attach_gid");          //所属グループID belonged group ID
$form->addElement("hidden", "client_search_flg");   //得意先コード入力フラグ customer code input flag
$form->addElement("hidden", "hdn_coax");            //丸め区分 round up/down
$form->addElement("hidden", "hdn_tax_franct");      //端数区分 round up/down
$form->addElement("hidden", "del_row");             //削除行 deleted row
$form->addElement("hidden", "add_row_flg");         //追加行フラグ add row flag
$form->addElement("hidden", "max_row");             //最大行数 max row number
$form->addElement("hidden", "goods_search_row");    //商品コード入力行 input field for product code
$form->addElement("hidden", "sum_button_flg");      //合計ボタン押下フラグ total button pressed flag
$form->addElement("hidden", "complete_flg");        //チェック完了ボタン押下フラグ flag when confirm/complete button is pressed
$form->addElement("hidden", "trans_check_flg");     //グリーン指定チェックフラグ flag for green designatin check box
$form->addElement("hidden", "recomp_flg");          //出荷可能数フラグ deliverable stock count flag
$form->addElement("hidden", "hdn_check_flg");         //受注照会判定フラグ sales order inquiry deicision flag
$form->addElement("hidden", "forward_num_flg");		//出荷回数選択フラグ rev.1.2 number of deliveries selection flag
$form->addElement("hidden", "hdn_edit_flg");		//通常オフライン受注変更判定フラグ rev.1.2 decision flag for editing a normall offline order
$form->addElement("hidden", "hdn_direct_search_flg");	//直送先コード入力フラグ rev.1.3 Direct destination code input flag
$form->addElement("hidden", "form_direct_select");	//直送先ID rev.1.3 direct destination ID
#2009-09-26 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}

/****************************/
//得意先コード入力処理 customer code input process
/****************************/
if($_POST["client_search_flg"] == true){

    $client_cd1         = $_POST["form_client"]["cd1"];       //得意先コード1 customer code 1
	$client_cd2         = $_POST["form_client"]["cd2"];       //得意先コード2 customer code 2

    //得意先の情報を抽出 extract the information of customer 
    $sql  = "SELECT";
    $sql .= "   client_id,";
//    $sql .= "   client_name,";
    $sql .= "   client_cname,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
	$sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '3' ";
    $sql .= "   AND";
    $sql .= "   state = '1' ";
    $sql .= "   AND";
    $sql .= "   shop_id = '$shop_id'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);

	//該当データがある there is a corresponding data
	if($num == 1){
		$client_id      = pg_fetch_result($result, 0,0);        //得意先ID customer id 
//        $attach_gid     = pg_fetch_result($result, 0,0);        //所属グループID group Id where the custoemr belongs
        $client_name    = pg_fetch_result($result, 0,1);        //得意先名 cstomer name
        $coax           = pg_fetch_result($result, 0,2);        //丸め区分（商品） round up/down (producT)
        $tax_franct     = pg_fetch_result($result, 0,3);        //端数区分（消費税）round/up/down (product)

        //取得したデータをフォームにセット set the acquired data to form
		$warning = null;
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
//        $client_data["attach_gid"]          = $attach_gid;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        $client_data["trade_aord_select"]   = pg_fetch_result($result, 0, 4);
	}else{
		$warning = "得意先を選択して下さい。";
		$client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
//        $client_data["attach_gid"]          = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
	}

	//レンタルから遷移してきた場合は初期化しない do not initialize if it was transitioned from rental
	if($rental_flg == NULL){
		//前に入力された値を初期化 initialize the value that was inputted previously
		for($i = 0; $i < $max_row; $i++){

			$client_data["hdn_goods_id"][$i]           = "";
			
			$client_data["hdn_tax_div"][$i]            = "";
			$client_data["form_goods_cd"][$i]          = "";
			$client_data["form_goods_name"][$i]        = "";
			$client_data["form_stock_num"][$i]         = "";
			$client_data["hdn_stock_num"][$i]          = "";
			$client_data["form_rorder_num"][$i]        = "";
			$client_data["form_rstock_num"][$i]        = "";
			$client_data["form_designated_num"][$i]    = "";
			$client_data["form_sale_num"][$i]          = "";
			$client_data["form_cost_price"]["$i"]["i"] = "";
			$client_data["form_cost_price"]["$i"]["d"] = "";
			$client_data["form_cost_amount"][$i]       = "";
			$client_data["form_sale_price"]["$i"]["i"] = "";
			$client_data["form_sale_price"]["$i"]["d"] = "";
			$client_data["form_sale_amount"][$i]       = "";
			//rev.1.2 分納対応分を追加 add what will be for the by batch delivery
			$client_data["form_forward_times"][$i]     = "0";
			$_POST["form_forward_times"][$i]				= 0;
			$client_data["form_forward_day"][$i][0]["y"]	= "";
			$client_data["form_forward_day"][$i][0]["m"]	= "";
			$client_data["form_forward_day"][$i][0]["d"]	= "";
			$client_data["form_forward_num"][$i][0]			= "";

		}

		$stock_num                          = "";
		$hdn_goods_id                       = "";
		$client_data["del_row"]             = "";
		$client_data["max_row"]             = 5;
		$client_data["form_sale_total"]     = "";
		$client_data["form_sale_tax"]       = "";
		$client_data["form_sale_money"]     = "";
		$post_flg                           = true;
		$max_row = 5;

	//rev.1.2 分納対応したため、レンタルの数量を出荷数へ入れる since it was a by batch delivery, put the number of rented units of product to the deliverable number of units of product
	}else{
		for($i = 0; $i < $max_row; $i++){
			$client_data["form_forward_num"][$i][0] = $_POST["form_sale_num"][$i];

		}

	}

	$form->setConstants($client_data);

    //削除行数 number of deleted rows
    unset($del_history);
    $del_history[] = NULL;
//}

/****************************/
//合計ボタン押下処理 process when the total button is pressed
/****************************/
}elseif(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["order"] == "受注確認画面へ" )&& $client_id != null){
	//削除リストを取得 acquire the deleted list
    $del_row = $_POST["del_row"];
    //削除履歴を配列にする。 turn the deletion history to array
    $del_history = explode(",", $del_row);

	$sale_data  = $_POST["form_sale_amount"];  //売上金額 total sales 
	$sale_money = NULL;                        //商品の売上金額 sales of a product
    $tax_div    = NULL;                        //課税区分 tax classification

	//売上金額の合計値計算 compute for the total amount of the sales
    for($i=0;$i<$max_row;$i++){
		if($sale_data[$i] != "" && !in_array("$i", $del_history)){
			$sale_money[] = $sale_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
		}
    }
	
	//現在の消費税率 current consumption tax
    #2009-12-21 aoyama-n
	#$sql  = "SELECT ";
	#$sql .= "    tax_rate_n ";
	#$sql .= "FROM ";
	#$sql .= "    t_client ";
	#$sql .= "WHERE ";
	#$sql .= "    client_id = $shop_id;";
	#$result = Db_Query($db_con, $sql); 
	#$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_ord_day"]["y"]."-".$_POST["form_ord_day"]["m"]."-".$_POST["form_ord_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

	$sale_money = number_format($total_money[0]);
	$tax_money  = number_format($total_money[1]);
	$st_money   = number_format($total_money[2]);

	if($_POST["sum_button_flg"] == true){
		//初期表示位置変更 change the initial display position
		$height = $max_row * 100;
		$form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
	}

	//フォームに値セット set the value to form
	$money_data["form_sale_total"]   = $sale_money;
	$money_data["form_sale_tax"]     = $tax_money;
	$money_data["form_sale_money"]   = $st_money;
	$money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}

/****************************/
//出荷可能数入力 input the deliverable number of units of product
/****************************/
if($_POST["recomp_flg"] == true){
    //出荷可能数 deliverable number of units of product
    $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    //数字以外が入力されている場合 when other than numbers are inputted
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//    $attach_gid   = $_POST["attach_gid"];     //得意先の所属グループ group which the customer belongs to
	$ary_goods_id = $_POST["hdn_goods_id"];   //入力した商品ID product ID inputted

	//入力された商品の個数を再計算する recompute the number of inputted product
	for($i = 0; $i < count($ary_goods_id); $i++){
		//商品存在判定 decide whether the product exists
		if($ary_goods_id[$i] != NULL){
			//再計算SQL recomputation SQL
			$sql  = "SELECT";
		    $sql .= "   t_goods.goods_id,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
			//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
		    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//            $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) ";
			$sql .= " END AS allowance_total,";
			//$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN";
			$sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
		    $sql .= "   COALESCE(t_stock.stock_num,0)"; 
		    $sql .= "   + COALESCE(t_stock_io.order_num,0)";
//		    $sql .= "   - (COALESCE(t_stock.rstock_num,0)";
		    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) END AS stock_total ";
		    $sql .= " FROM";
		    $sql .= "   t_goods ";

			$sql .= "   INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
			$sql .= "   INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

		    $sql .= "   LEFT JOIN";

            //在庫数 inventory count
		    $sql .= "   (SELECT";
		    $sql .= "       t_stock.goods_id,";
		    $sql .= "       SUM(t_stock.stock_num)AS stock_num,";
		    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num";
		    $sql .= "       FROM";
		    $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id";
		    $sql .= "       WHERE";
		    $sql .= "            t_stock.shop_id =  $shop_id";
		    $sql .= "       AND";
		    $sql .= "            t_ware.count_flg = 't'";
		    $sql .= "       GROUP BY t_stock.goods_id";
		    $sql .= "   )AS t_stock ON t_goods.goods_id = t_stock.goods_id";

		    $sql .= "   LEFT JOIN";

            //発注済数 number of purchase orders ordered
		    $sql .= "   (SELECT";
		    $sql .= "       t_stock_hand.goods_id,";
		    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num";
		    $sql .= "   FROM";
		    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
		    $sql .= "   WHERE";
		    $sql .= "       t_stock_hand.work_div = 3";
		    $sql .= "   AND";
		    $sql .= "       t_stock_hand.shop_id = $shop_id";
		    $sql .= "   AND";
		    $sql .= "       t_ware.count_flg = 't'";
		    $sql .= "   AND";
//		    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day";
//		    $sql .= "   AND";
			$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)";
		    $sql .= "   GROUP BY t_stock_hand.goods_id";
		    $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id";

		    $sql .= "   LEFT JOIN";

            //引当数 number of reserved products for orders
		    $sql .= "   (SELECT";
		    $sql .= "       t_stock_hand.goods_id,";
		    $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num";
		    $sql .= "   FROM";
		    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
		    $sql .= "   WHERE";
		    $sql .= "       t_stock_hand.work_div = 1";
		    $sql .= "   AND";
		    $sql .= "       t_stock_hand.shop_id = $shop_id";
		    $sql .= "   AND";
		    $sql .= "       t_ware.count_flg = 't'";
		    $sql .= "   AND";
//			$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)";
			$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)";
		    $sql .= "   GROUP BY t_stock_hand.goods_id";
		    $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id";

			$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop

		    $sql .= " WHERE ";
		    $sql .= "       t_goods.goods_id = $ary_goods_id[$i]";
		    $sql .= " AND ";
		    $sql .= "       t_goods.public_flg = 't' ";
		    $sql .= " AND ";
		    $sql .= "       initial_cost.rank_cd = '1' ";

			//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
		    $sql .= " AND ";
		    $sql .= "       t_goods_info.shop_id = $shop_id ";

		    $sql .= ";";

		    $result = Db_Query($db_con, $sql);

		    $goods_data = pg_fetch_array($result);

			$set_designated_data["hdn_goods_id"][$i]         = $goods_data[0];   //商品ID product ID 
			$hdn_goods_id[$search_row]                       = $goods_data[0];   //POSTする前に商品IDを総在庫数で使用する為 for the reason that the product ID will be used for the total stock count before POST
			$set_designated_data["form_stock_num"][$i]       = $goods_data[1];   //実棚数 actual shelf number
			$set_designated_data["hdn_stock_num"][$i]        = $goods_data[1];   //実棚数（hidden）actual shelf number (hidden)
			$stock_num[$i]                                   = $goods_data[1];   //実棚数(リンクの値) actual shelf number (linl's value)
			$set_designated_data["form_rorder_num"][$i]      = $goods_data[2];   //発注済数 number of purchase orders made
			$set_designated_data["form_rstock_num"][$i]      = $goods_data[3];   //引当数 number of products reserved for orders
			$set_designated_data["form_designated_num"][$i]  = $goods_data[4];   //出荷可能数 deliverable number of units of products 
		}
	}

	//出荷可能数入力フラグに空白をセット set blank in the input deliverable number of units of product flag
    $set_designated_data["recomp_flg"] = "";
    $form->setConstants($set_designated_data);
}

/****************************/
//商品コード入力 input product code
/****************************/
if($_POST["goods_search_row"] != null){

	//商品データを取得する行 row for acquiring
 the product data
    $search_row = $_POST["goods_search_row"];

	//出荷可能数取得 acquire the deliverable number of units of product
	$designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }

//   $attach_gid   = $_POST["attach_gid"];     //得意先の所属グループ the group where the customer belongs
	$sql  = "SELECT\n";
    $sql .= "   t_goods.goods_id,\n";
    $sql .= "   t_goods.name_change,\n";
    //$sql .= "   t_goods.stock_manage,\n";
    $sql .= "   t_goods_info.stock_manage,\n";	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "   t_goods.goods_cd,\n";
    //$sql .= "   t_goods.goods_name,\n";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //正式名 official name
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
//    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) \n";
    $sql .= " END AS allowance_total,\n";
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN\n";
    $sql .= "   COALESCE(t_stock.stock_num,0)\n"; 
    $sql .= "   + COALESCE(t_stock_io.order_num,0)\n";
//    $sql .= "   - (COALESCE(t_stock.rstock_num,0)\n";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) END AS stock_total,\n";
    $sql .= "   initial_cost.r_price AS initial_price,\n";
    $sql .= "   sale_price.r_price AS sale_price,\n";
    $sql .= "   t_goods.tax_div, \n";
	//rev.1.2 値引商品フラグ discounted product flag 
    $sql .= "   t_goods.discount_flg \n";
    $sql .= " FROM\n";
    $sql .= "   t_goods \n";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";

    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS initial_cost\n";
    $sql .= "   ON t_goods.goods_id = initial_cost.goods_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //在庫数 stock number 
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

    //発注済数 number of purchase orders ordered
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
//    $sql .= "       CURRENT_DATE <= t_stock_hand.work_day\n";
//    $sql .= "   AND\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id\n";

    $sql .= "   LEFT JOIN\n";

    //引当数 number of reserved units of product for order
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
//	$sql .= "       t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
	$sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $sql .= "   GROUP BY t_stock_hand.goods_id\n";
    $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id\n";

	$sql .= "    INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";    //rev.1.3 ショップごとに在庫管理フラグ

    $sql .= " WHERE \n";
    $sql .= "       t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."'\n";
    $sql .= " AND \n";
    $sql .= "       t_goods.public_flg = 't' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.accept_flg = '1' \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.state IN (1,3) \n";
    $sql .= " AND \n";
    $sql .= "       t_goods.compose_flg = 'f' \n";
    $sql .= " AND\n"; 
    $sql .= "       initial_cost.rank_cd = '1' \n";
    $sql .= " AND \n";
    $sql .= "       sale_price.rank_cd = \n";
    $sql .= "       (SELECT \n";
    $sql .= "           rank_cd \n";
    $sql .= "       FROM \n";
    $sql .= "           t_client \n";
    $sql .= "       WHERE \n";
    $sql .= "           client_id = $client_id)\n";

	//rev.1.3 ショップごとに在庫管理フラグ inventory control flag per shop
    $sql .= " AND \n";
    $sql .= "       t_goods_info.shop_id = $shop_id \n";

    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);
	//データが存在した場合、フォームにデータを表示
	if($data_num == 1){
    	$goods_data = pg_fetch_array($result);

		$set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //商品ID product ID
		$hdn_goods_id[$search_row]                           = $goods_data[0];   //POSTする前に商品IDを総在庫数で使用する為 For the reason that product ID will be used in the total inventory count before POST

		$set_goods_data["hdn_name_change"][$search_row]      = $goods_data[1];   //品名変更フラグ product name change flag
		$hdn_name_change[$search_row]                        = $goods_data[1];   //POSTする前に商品名の変更不可判定を行なう為 For the reason that product name will be checked if it is non-editable or not before POST
		
		$set_goods_data["hdn_stock_manage"][$search_row]     = $goods_data[2];   //在庫管理 inventory control
		$hdn_stock_manage[$search_row]                       = $goods_data[2];   //POSTする前に実棚数の在庫管理判定を行なう為 For the reason that actual shelf number will be decided in inventory control before POST

		$set_goods_data["form_goods_cd"][$search_row]        = $goods_data[3];   //商品CD Product CD
		$set_goods_data["form_goods_name"][$search_row]      = $goods_data[4];   //商品名 Prodcut Name

		$set_goods_data["form_stock_num"][$search_row]       = number_format($goods_data[5]);   //実棚数 actual shelf number
		$set_goods_data["hdn_stock_num"][$search_row]        = number_format($goods_data[5]);   //実棚数（hidden） （hidden）actual shelf number (hidden)
		$stock_num[$search_row]                              = number_format($goods_data[5]);   //実棚数(リンクの値) actual shelf number (link's value)

		$set_goods_data["form_rorder_num"][$search_row]      = $goods_data[6];   //発注済数 purchase orders ordered number
		$set_goods_data["form_rstock_num"][$search_row]      = $goods_data[7];   //引当数 reserved quantity of products for sales order

		$set_goods_data["form_designated_num"][$search_row]  = $goods_data[8];   //出荷可能数 deliverable number of stocks

		//原価単価を整数部と少数部に分ける separate the decimal from integer for the product cost
        $cost_price = explode('.', $goods_data[9]);
		$set_goods_data["form_cost_price"][$search_row]["i"] = $cost_price[0];  //原価単価 product cost per unit
		$set_goods_data["form_cost_price"][$search_row]["d"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

		//売上単価を整数部と少数部に分ける separate the decimal from integer for the sales price per unit
        $sale_price = explode('.', $goods_data[10]);
		$set_goods_data["form_sale_price"][$search_row]["i"] = $sale_price[0];  //売上単価 sales price per unit
		$set_goods_data["form_sale_price"][$search_row]["d"] = ($sale_price[1] != null)? $sale_price[1] : '00';

		//rev.1.2 出荷数と受注数の判定（金額計算）decide the number of sales order and number of products to be shipped 
		$cost_amount = null;
		$sale_amount = null;
		//変更は受注数から金額計算 for editing, compute the amount from the number of sales order
		if($edit_flg == "true"){
			if($_POST["form_sale_num"][$search_row] != null){
            	$cost_amount = bcmul($goods_data[9], $_POST["form_sale_num"][$search_row],2);
            	$sale_amount = bcmul($goods_data[10], $_POST["form_sale_num"][$search_row],2);
			}
		//新規登録・レンタルは出荷数の合計から金額計算 for new registration・rental, compute the amount from the total number of shipped product
		}else{
			if(in_array(!"", $_POST["form_forward_num"][$search_row])){
	            $cost_amount = bcmul($goods_data[9], array_sum($_POST["form_forward_num"][$search_row]), 2);
            	$sale_amount = bcmul($goods_data[10], array_sum($_POST["form_forward_num"][$search_row]), 2);
			}
		}
		//受注数が入力されていた（上の処理を通った）場合は、再計算 if the number of sales orders are being inputted (after going through the processes above), then recompute.
		if($cost_amount != null && $sale_amount != null){
			//原価金額計算 compute the cost price
            $cost_amount = Coax_Col($coax, $cost_amount);
			//売上金額計算 compute the sales 
            $sale_amount = Coax_Col($coax, $sale_amount);
			$set_goods_data["form_cost_amount"][$search_row] = number_format($cost_amount);
			$set_goods_data["form_sale_amount"][$search_row] = number_format($sale_amount);
		}

		$set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[11]; //課税区分 tax classification
		//rev.1.2 値引商品フラグ discounted product flag
		$set_goods_data["hdn_discount_flg"][$search_row]     = $goods_data[12];
	}else{
		//データが無い場合は、初期化 initialize when there is no data 
		$no_goods_flg                                        = true;     //該当する商品が無ければデータを表示しない do not display data if there is no corresponding product
		$set_goods_data["hdn_goods_id"][$search_row]         = "";
		$set_goods_data["hdn_name_change"][$search_row]      = "";
		$set_goods_data["hdn_stock_manage"][$search_row]     = "";
//		$set_goods_data["form_goods_cd"][$search_row]        = "";
		$set_goods_data["form_goods_name"][$search_row]      = "";
		$set_goods_data["form_stock_num"][$search_row]       = "";
		$set_goods_data["hdn_stock_num"][$search_row]        = "";
		$set_goods_data["form_rorder_num"][$search_row]      = "";
		$set_goods_data["form_rstock_num"][$search_row]      = "";
        $set_goods_data["form_sale_num"][$search_row]        = "";
		$set_goods_data["form_designated_num"][$search_row]  = "";
		$set_goods_data["form_cost_price"][$search_row]["i"] = "";
		$set_goods_data["form_cost_price"][$search_row]["d"] = "";
		$set_goods_data["form_cost_amount"][$search_row]     = "";
		$set_goods_data["form_sale_price"][$search_row]["i"] = "";
		$set_goods_data["form_sale_price"][$search_row]["d"] = "";
		$set_goods_data["form_sale_amount"][$search_row]     = "";
		$set_goods_data["hdn_tax_div"][$search_row]          = "";
		$set_goods_data["hdn_discount_flg"][$search_row]     = "";	//rev.1.2 値引商品フラグ discounted product flag
 	}
	$set_goods_data["goods_search_row"]                  = "";
	$form->setConstants($set_goods_data);

	//初期表示位置変更 edit initial display position
	$height = $search_row * 100;
	$form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";

}


//--------------------------//
// rev.1.3 直送先入力処理 direct destination input process
//--------------------------//
//直送先検索フラグがtureの場合 when the direct destination flag is true
if($_POST["hdn_direct_search_flg"] == "true"){
    $direct_cd = $_POST["form_direct_text"]["cd"];

    //指定された直送先の情報を抽出 extract the info for the assigned direct destination
    $sql  = "SELECT \n";
    $sql .= "    direct_id, \n";            //直送先ID direct destination ID
    $sql .= "    direct_cd, \n";            //直送先コード direct destination code
    $sql .= "    direct_name, \n";          //直送先名 direct destination name
    $sql .= "    direct_cname, \n";         //略称 abbreviation
    $sql .= "    t_client.client_cname \n"; //請求先 billing address
    $sql .= "FROM \n";
    $sql .= "    t_direct \n";
    $sql .= "    LEFT JOIN t_client ON t_direct.client_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_direct.shop_id = $shop_id \n";
    $sql .= "    AND \n";
    $sql .= "    t_direct.direct_cd = '$direct_cd' \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $get_direct_data_count = pg_num_rows($result);
    $get_direct_data       = pg_fetch_array($result);

    //該当する直送先があった場合のみ処理開始 only start the process when there is a corrsesponding direct destination
    if($get_direct_data_count > 0){
        //抽出した直送先の情報をセット set the info of the extracted direct destination
        $set_data = NULL;
        $set_data["form_direct_select"]         = $get_direct_data["direct_id"];    //直送先ID direct destination ID
        $set_data["form_direct_text"]["name"]   = $get_direct_data["direct_cname"]; //直送先名略称 direct destination name abbreviation
        $set_data["form_direct_text"]["claim"]  = $get_direct_data["client_cname"]; //請求先 billing destination

    //該当するデータがなかった場合は、既に入力データを全て初期化 initialize all input data if there is no corresponding data
    }else{
        $set_data = NULL;
        $set_data["form_direct_select"]         = "";   //直送先ID direct destination ID
        $set_data["form_direct_text"]["cd"]     = "";   //直送先コード direct destination code
        $set_data["form_direct_text"]["name"]   = "";   //直送先名略称 direct destination abbreviation
        $set_data["form_direct_text"]["claim"]  = "";   //請求先 billing address
    }

    //直送先検索フラグを初期化 initialize the direct destination search flag
    $set_data["hdn_direct_search_flg"]          = "";

	$form->setConstants($set_data);

}


/****************************/
//エラーチェック(addRule) error check (addRule)
/****************************/
//得意先 customer
//必須チェック required fields
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('正しい得意先コードを入力してください。', 'required')
        ),      
		'cd2' => array(
                array('正しい得意先コードを入力してください。', 'required')
        ),      
        'name' => array(
                array('正しい得意先コードを入力してください。','required')
        )       
));

//出荷可能数 deliverable number of units of product
$form->addRule("form_designated_date","発注済数と引当数を考慮する日数は半角数値のみです。","regex", '/^[0-9]+$/');

//受注日 sales order
//●必須チェック required field 
//●半角数字チェック check for halfwidth number
$form->addGroupRule('form_ord_day', array(
        'y' => array(
                array('受注日 の日付は妥当ではありません。', 'required'),
				array('受注日 の日付は妥当ではありません。', 'numeric')
        ),      
        'm' => array(
                array('受注日 の日付は妥当ではありません。','required'),
				array('受注日 の日付は妥当ではありません。', 'numeric')
        ),       
        'd' => array(
                array('受注日 の日付は妥当ではありません。','required'),
				array('受注日 の日付は妥当ではありません。', 'numeric')
        )       
));

//希望納期 desired delivery date
//●半角数字チェック check if halfwidth number
$form->addGroupRule('form_hope_day', array(
        'y' => array(
                array('希望納期 の日付は妥当ではありません。', 'numeric')
        ),
        'm' => array(
                array('希望納期 の日付は妥当ではありません。','numeric')
        ),
        'd' => array(
                array('希望納期 の日付は妥当ではありません。','numeric')
        ),
));

//入荷予定日 scheduled delivery date
//●半角数字チェック check if halfwidth number
$form->addGroupRule('form_arr_day', array(
        'y' => array(
                array('出荷予定日 の日付は妥当ではありません。', 'numeric')
        ),
        'm' => array(
                array('出荷予定日 の日付は妥当ではありません。', 'numeric')
        ),
        'd' => array(
                array('出荷予定日 の日付は妥当ではありません。', 'numeric')
        ),
));

//グリーン指定した場合は、運送業者は必須 If green designation is checked then carrier is a required field
if($_POST["form_trans_check"] != NULL){
	//運送業者 carrier
	//●必須チェック required field
	$form->addRule('form_trans_select','運送業者を選択してください。','required');
}

//出荷倉庫 shipping/oubound warehouse
//●必須チェック required field
$form->addRule("form_ware_select","出荷倉庫を選択してください。","required");

//取引区分 trade classification
//●必須チェック required field
$form->addRule("trade_aord_select","取引区分を選択してください。","required");

//担当者 assigned staff
//●必須チェック required field
$form->addRule("form_staff_select","担当者を選択してください。","required");


//通信欄（得意先宛）communication field (Customer)
//●文字数チェック check the string number
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_client","通信欄（得意先宛）は50文字以内です。","mb_maxlength","50");


//通信欄（本部宛）communication field (HQ)
//●文字数チェック check the string number
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_head","通信欄（本部宛）は50文字以内です。","mb_maxlength","50");

/****************************/
//受注ボタン押下処理 sales order pressed process
/****************************/
if($_POST["order"] == "受注確認画面へ" || $_POST["comp_button"] == "受注OK"){
	//ヘッダー情報
	$ord_no               = $_POST["form_order_no"];           //受注番号 sales order number
	$designated_date      = $_POST["form_designated_date"];    //出荷可能数 deliverable number of units of products
	$ord_day_y            = $_POST["form_ord_day"]["y"];       //受注日 sles oreder received date
	$ord_day_m            = $_POST["form_ord_day"]["m"];            
	$ord_day_d            = $_POST["form_ord_day"]["d"];            
	$hope_day_y           = $_POST["form_hope_day"]["y"];      //希望納期 desired delivery date
	$hope_day_m           = $_POST["form_hope_day"]["m"];           
	$hope_day_d           = $_POST["form_hope_day"]["d"];           
	$arr_day_y            = $_POST["form_arr_day"]["y"];       //入荷予定日 scheduled delivery date
	$arr_day_m            = $_POST["form_arr_day"]["m"];            
	$arr_day_d            = $_POST["form_arr_day"]["d"];            
	$client_cd1           = $_POST["form_client"]["cd1"];      //得意先CD1 customer CD1
	$client_cd2           = $_POST["form_client"]["cd2"];      //得意先CD2 customer CD2
	$client_name          = $_POST["form_client"]["name"];     //得意先名 customer name
	$note_client          = $_POST["form_note_client"];        //通信欄（得意先）communication field (customer)
	$note_head            = $_POST["form_note_head"];          //通信欄（本部）communication (HQ)
	$trans_check          = $_POST["form_trans_check"];        //グリーン指定 Green designation
	$trans_id             = $_POST["form_trans_select"];       //運送業者 carrier
	$direct_id            = $_POST["form_direct_select"];      //直送先 direct destination
	$ware_id              = $_POST["form_ware_select"];        //倉庫 warehouse
	$trade_aord           = $_POST["trade_aord_select"];       //取引区分 trade classification
	$c_staff_id           = $_POST["form_staff_select"];	   //担当者 assigned staff

	/****************************/
    //エラーチェック(PHP) error check (PHP)
    /****************************/
	$error_flg = false;                                         //エラー判定フラグ error flag

	//rev.1.2 新規登録（分納時）か変更（非分納）の判定フラグ（Row_Data_Check2関数用）decision flag (for Row_Data_Check2 function) for new registration (for batch shipment) or edit (not by batch)
	$check_type = ($edit_flg == "true") ? "aord" : "aord_offline";

    #2009-09-26 hashimoto-y
    $check_ary = array(
                    $_POST[hdn_goods_id],                           //商品ID Product ID
                    $_POST[form_goods_cd],                          //商品コード Product code
                    $_POST[form_goods_name],                        //商品名 Product Name
                    $_POST[form_sale_num],                          //受注数 number of sales order
                    $_POST[form_cost_price],                        //原価単価 cost price per unit of product
                    $_POST[form_sale_price],                        //売上単価 sales price per unit of product
                    $_POST[form_cost_amount],                       //原価金額 total cost price
                    $_POST[form_sale_amount],                       //売上金額 sales price 
                    $_POST[hdn_tax_div],                            //課税区分 tax classification
                    $del_history,                                   //削除履歴 deletion history
                    $max_row,                                       //最大行数 max row number
                    $check_type,                                    //受注売上区分 rev.1.2 sales classification 
                    $db_con,                                        //DBコネクション DB connection
                    "",
                    "",
                    $_POST[hdn_discount_flg]                        //値引フラグ discounted flag
                );      

    $check_data = Row_Data_Check2($check_ary);

    //エラーがあった場合 if there is an error
    if($check_data[0] === true){

        //商品未選択エラー product unselected error
        $goods_error0 = $check_data[1];

        //商品コード不正 product invalid code
        $goods_error1 = $check_data[2];

        //受注数、原価単価、売上単価入力チェック input check for number of received order, cost price, sales price per unit  
        $goods_error2 = $check_data[3];

        //受注数半角エラー sales order  
        $goods_error3 = $check_data[4];

        //原価単価半角エラー cost price unit for error for not being halfwidth
        $goods_error4 = $check_data[5];

        //売上単価半角エラー sales price per unit error for not being halfwidth
        $goods_error5 = $check_data[6];

        $error_flg = true;
    //エラーが無かった場合 if there is no error 
    }else{  
        $goods_id         = $check_data[1][goods_id];       //商品ID Product ID
        $goods_cd         = $check_data[1][goods_cd];       //商品名 Product Name
        $goods_name       = $check_data[1][goods_name];     //商品名 Product Name
        $sale_num         = $check_data[1][sale_num];       //受注数 number of units of product being ordered
        $c_price          = $check_data[1][cost_price];     //原価単価（整数部） cost price per unit of product (integer)
		$s_price          = $check_data[1][sale_price];     //売上単価（整数部）sales price per unit (integer)
        $tax_div          = $check_data[1][tax_div];        //課税区分 tax classification
        $cost_amount      = $check_data[1][cost_amount];    //原価金額 cost price
		$sale_amount      = $check_data[1][sale_amount];    //売上金額 sales price
        $def_line         = $check_data[1][def_line];       //行番号 row number
    }

    //商品チェック product check
    //商品重複チェック product duplication check
    //商品重複チェック product duplication check
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //既にチェック済みの商品の場合はｽｷｯﾌﾟ skip the products that are already checked
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //チェック対象となる商品 products that will be checked
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //商品が同じ場合 if the products are the same
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //チェック済み商品 products already checked 

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "商品コード：".$err_goods_cd."の商品が複数選択されています。(".$mst_line.$duplicate_line."行目)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

	//◇受注日 date for receiving the order
    //・文字種チェック check the string type
    if($ord_day_y != null && $ord_day_m != null && $ord_day_d != null){
        $ord_day_y = (int)$ord_day_y;
        $ord_day_m = (int)$ord_day_m;
        $ord_day_d = (int)$ord_day_d;
        if(!checkdate($ord_day_m,$ord_day_d,$ord_day_y)){
			$form->setElementError("form_ord_day","受注日 の日付は妥当ではありません。");
        }else{
            $err_msge = Sys_Start_Date_Chk($ord_day_y, $ord_day_m, $ord_day_d, "受注日");
            if($err_msge != null){
                $form->setElementError("form_ord_day","$err_msge"); 
            }
        }
    }

	//希望納期 desired delivery date
    if($hope_day_y != null || $hope_day_m != null || $hope_day_d != null){
        $hope_day_y = (int)$hope_day_y;
        $hope_day_m = (int)$hope_day_m;
        $hope_day_d = (int)$hope_day_d;
        if(!checkdate($hope_day_m,$hope_day_d,$hope_day_y)){
            $form->setElementError("form_hope_day","希望納期 の日付は妥当ではありません。");
        }else{
            $err_msge = Sys_Start_Date_Chk($hope_day_y, $hope_day_m, $hope_day_d, "希望納期");
            if($err_msge != null){
                $form->setElementError("form_hope_day","$err_msge"); 
            }
        }
    }

    //◇入荷予定日 planned delivery date
    //・文字種チェック check the string type
    if($arr_day_y != null || $arr_day_m != null || $arr_day_d != null){
        $arr_day_y = (int)$arr_day_y;
        $arr_day_m = (int)$arr_day_m;
        $arr_day_d = (int)$arr_day_d;
        if(!checkdate($arr_day_m,$arr_day_d,$arr_day_y)){
            $form->setElementError("form_arr_day","出荷予定日 の日付は妥当ではありません。");
        }else{
            $err_msge = Sys_Start_Date_Chk($arr_day_y, $arr_day_m, $arr_day_d, "出荷予定日");
            if($err_msge != null){
                $form->setElementError("form_arr_day","$err_msge"); 
            }

            $arr_day_y = str_pad($arr_day_y, 4, "0", STR_PAD_LEFT);
            $arr_day_m = str_pad($arr_day_m, 2, "0", STR_PAD_LEFT);
            $arr_day_d = str_pad($arr_day_d, 2, "0", STR_PAD_LEFT);
            $arr_day_ymd = $arr_day_y.$arr_day_m.$arr_day_d;

            $ord_day_y = str_pad($ord_day_y, 4, "0", STR_PAD_LEFT);
            $ord_day_m = str_pad($ord_day_m, 2, "0", STR_PAD_LEFT);
            $ord_day_d = str_pad($ord_day_d, 2, "0", STR_PAD_LEFT);
            $ord_day_ymd = $ord_day_y.$ord_day_m.$ord_day_d;

            if($arr_day_ymd < $ord_day_ymd){
                $form->setElementError("form_arr_day","出荷予定日は受注日以降の日付を指定してください。");
            }
        }
    }


	//rev.1.2 エラーチェック（出荷回数、分納時出荷予定日、出荷数）error check (number of shipment, scheduled dates for batchdelivery, number of units to be shipped)
	if($edit_flg != "true"){
	    //商品毎に出荷予定日に空が一つの場合はデフォルトの日付を入力する input the default date if the scheduled delivery date has 1 blank per product
    	for($i = 0; $i< $_POST["max_row"]; $i++){
			//商品IDのない行はチェックしない do not check the rows with no product ID
			if($_POST["hdn_goods_id"][$i] == ""){
				continue;
			}

	        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
    	        $arv_yy = $_POST["form_forward_day"][$i][$j]["y"];
        	    $arv_mm = $_POST["form_forward_day"][$i][$j]["m"];
            	$arv_dd = $_POST["form_forward_day"][$i][$j]["d"];
	            $arv_ymd = $arv_yy.$arv_mm.$arv_dd;

    	        if($arv_ymd == null){
        	        $null_row[] = $j;
            	}
	        }

    	    //空白がひつの場合 when there is only one blank
        	if(count($null_row) == 1){
    	    	//ヘッダ部の出荷予定日が空じゃない場合 if the header part of the scheduled delivery date is not blank 
        		if($arr_day_y != null && $arr_day_m != null && $arr_day_d != null){
	            	$row = $null_row[0];
		            $_POST["form_forward_day"][$i][$row]["y"] = $arr_day_y;
    		        $_POST["form_forward_day"][$i][$row]["m"] = $arr_day_m;
        		    $_POST["form_forward_day"][$i][$row]["d"] = $arr_day_d;

				//ヘッダ、データとも出荷予定日が空だとエラー error if the scheduled delivery date both for header and data is blank
				}else{
	        	    $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
    	        	$error_flg = true;
	    	        break;
				}

	        //空白が二つ以上の場合 if there are two or more blanks
    	    }elseif(count($null_row) > 1){
        	    $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
            	$error_flg = true;
	            break;
    	    }
        	$null_row = null;
	    }

	    //■出荷予定日 scheduled delivery date
    	//商品数（種類）ループ loop through the number of products (type)
	    for($i=0;$i<$_POST["max_row"];$i++){
			//商品IDのない行はチェックしない do not check the row with no product ID
			if($_POST["hdn_goods_id"][$i] == ""){
				continue;
			}

	        //出荷回数を配列に保持 store the number of shipment in array
    	    $array_count[$i] = $_POST["form_forward_times"][$i];
        	//出荷回数ループ loop through the number of shipment
	        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){

    	        //日付がNULLでなければ0埋め If dates is not null then fill with 0s
        	    if($_POST["form_forward_day"][$i][$j]["y"] != NULL){
            	    $_POST["form_forward_day"][$i][$j]["y"] = str_pad($_POST["form_forward_day"][$i][$j]["y"], 4, 0, STR_PAD_LEFT);
	            }
    	        if($_POST["form_forward_day"][$i][$j]["m"] != NULL){
        	        $_POST["form_forward_day"][$i][$j]["m"] = str_pad($_POST["form_forward_day"][$i][$j]["m"], 2, 0, STR_PAD_LEFT);
            	}
	            if($_POST["form_forward_day"][$i][$j]["d"] != NULL){
    	            $_POST["form_forward_day"][$i][$j]["d"] = str_pad($_POST["form_forward_day"][$i][$j]["d"], 2, 0, STR_PAD_LEFT);
        	    }

	            //出荷予定日 （$yy $mm $dd のNULLチェックは日付の妥当性を確認するため行なわない）scheduled delivery date (No NULL check for $yy $mm $dd since date will be validated)
    	        $yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	    $mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	$dd  = $_POST["form_forward_day"][$i][$j]["d"];
	            $ymd = $yy.$mm.$dd;

    	        //出荷予定日がNULLでない場合 if the scheduled date is not NULL
        	    if($ymd != NULL){

	                //日付が妥当な場合 if the date is valid
    	            if(checkdate((int)$mm, (int)$dd, (int)$yy)){  //キャストで0をNULLに変換 convert 0 to NULL using cast

	                    //出荷予定日が半角数字ではない場合 if the scheduled delivery date is not half width number 
    	                if(!ereg("^[0-9]+$", $yy) || !ereg("^[0-9]+$", $mm) || !ereg("^[0-9]+$", $dd)){
        	                $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
            	            $error_flg = true;
                	    }

	                    //出荷予定日が重複する場合 when the scheduled delivery date duplicates
    	                if($all_ymd_goods[$i][$ymd] == "1"){
        	                $forward_day_err = "同一の商品で分納出荷予定日が重複しています。";
            	            $error_flg = true;
                	    }else{
	                        $all_ymd_goods[$i][$ymd] = 1; //商品($i)の出荷日にフラグを立てる flag the scheduled delivery date of product ($i)
    	                }

        	            //出荷予定日が受注日以前の場合 if the scheduled delivery date is before the sales order received date
            	        if($error_flg == true && $ymd < $aord_ymd){
                	        $forward_day_err = "分納出荷予定日は受注日以降の日付を設定して下さい。";
                    	    $error_flg = true;
	                    }

    	                $err_msge = Sys_Start_Date_Chk($yy, $mm, $dd, "分納出荷予定日");
        	            if($err_msge != null){
            	        $forward_day_err = $err_msge;
                	        $error_flg = true;
                    	}

	                //日付が妥当でない場合 if the date is not valid
    	            }else{
        	            $forward_day_err = "分納出荷予定日の日付は妥当ではありません。";
            	        $error_flg = true;
                	}
	            }

    	        //■出荷数チェック check the number of products to be shipped
        	    //●必須チェック required field
            	if($_POST["form_forward_num"][$i][$j] == null || !ereg("^[0-9]+$", $_POST["form_forward_num"][$i][$j]) || $_POST["form_forward_num"][$i][$j] == 0){
                	$forward_num_err = "出荷数は半角数値のみです。";
	                $error_flg = true;
    	        }
        	}

			//出荷回数を確認画面用に+1した値をテキストボックスに入れる input the number of shipment +1 in the textbox for the confirmation screen
			$form->setConstants(array("form_forward_times_text[$i]" => $_POST["form_forward_times"][$i] + 1));

		}
    }


	//エラーの場合はこれ以降の表示処理を行なわない if error occurs then do not proceed furthermore
    if($form->validate() && $error_flg == false){

		//登録判定 decide registration 
		if($_POST["comp_button"] == "受注OK"){
			//現在の消費税率 current consumption tax rate
            #2009-12-21 aoyama-n
			#$sql  = "SELECT ";
			#$sql .= "    tax_rate_n ";
			#$sql .= "FROM ";
			#$sql .= "    t_client ";
			#$sql .= "WHERE ";
			#$sql .= "    client_id = $shop_id;";
			#$result = Db_Query($db_con, $sql); 
			#$tax_num = pg_fetch_result($result, 0,0);

            #2009-12-21 aoyama-n
            $tax_rate_obj->setTaxRateDay($ord_day_y."-".$ord_day_m."-".$ord_day_d);
            $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

			//日付の形式変更 change the date format
			$ord_day  = $ord_day_y."-".$ord_day_m."-".$ord_day_d;
			if($hope_day_y != null){
				$hope_day = $hope_day_y."-".$hope_day_m."-".$hope_day_d;
			}
			if($arr_day_y != null){
				$arr_day  = $arr_day_y."-".$arr_day_m."-".$arr_day_d;
			}

			//rev.1.2 登録と変更で処理を分けた separated the process between registration and edit
			//変更時 when editing
			if($edit_flg == "true"){

				$total_money = Total_Amount($cost_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$cost_money  = $total_money[0];
				$total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);
				$sale_money  = $total_money[0];
				$sale_tax    = $total_money[1];

			//新規登録時 when newly registering
			}else{

				//分納時は出荷予定日ごとに受注を登録する if it's a by batch delivery, register the sales order per scheduled delivery date 
				//商品数（種類）ループ loop throught the number of types of product 
				for($i=0;$i<$_POST["max_row"];$i++){
					//商品IDのない行はチェックしない do not check the row that has no product ID
					if($_POST["hdn_goods_id"][$i] == ""){
						continue;
					}

					//出荷回数ループ loop through the number of shipment
					for($j=0; $j<=$_POST["form_forward_times"][$i]; $j++){
	                    //出荷予定日 scheduled shipment date
    	                $f_yy  = $_POST["form_forward_day"][$i][$j]["y"];
        	            $f_mm  = $_POST["form_forward_day"][$i][$j]["m"];
            	        $f_dd  = $_POST["form_forward_day"][$i][$j]["d"];
                	    $f_ymd = $f_yy.$f_mm.$f_dd;
                    	$all_ymd[] = $f_yy.$f_mm.$f_dd; //全出荷予定日 all scheduled shipment date 

						//変数名変更 change the name of the variable
	                    $goods_id     = $_POST["hdn_goods_id"][$i];				//商品ID Product ID
    	                $forward_num  = $_POST["form_forward_num"][$i][$j];		//出荷数 number of shipment

	                    //■受注ヘッダ用 For received order header
						$post_cost_price = $_POST["form_cost_price"][$i]["i"].".".$_POST["form_cost_price"][$i]["d"];
    	                $data_h[$f_ymd]["原価金額"][] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//原価金額(伝票計算出に利用) total cost price (used for computation in voucher)
						$post_sale_price = $_POST["form_sale_price"][$i]["i"].".".$_POST["form_sale_price"][$i]["d"];
        	            $data_h[$f_ymd]["売上金額"][] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//売上金額(伝票計算出に利用) total sales price (used fir computation in voucher)
            	        $data_h[$f_ymd]["課税区分"][] = $_POST["hdn_tax_div"][$i];

	                    //■受注データ用 For received order data
    	                $data_d[$f_ymd]["good_id"][]                   	 = $goods_id;                           		//商品ID product ID
        	            $data_d[$f_ymd]["line"][]                      	 = $i;                                 			//行数 number of rows
            	        $data_d[$f_ymd][$goods_id."-".$i]["goods_name"]	 = addslashes($_POST["form_goods_name"][$i]);	//商品名 product name
                	    $data_d[$f_ymd][$goods_id."-".$i]["num"]       	 = $forward_num;                        		//出荷数 number of shipment
                    	$data_d[$f_ymd][$goods_id."-".$i]["cost_price"]  = $post_cost_price;               				//原価単価 cost per unit 
	                    $data_d[$f_ymd][$goods_id."-".$i]["sale_price"]  = $post_sale_price;							//売上単価 sales per unit
    	                $data_d[$f_ymd][$goods_id."-".$i]["cost_amount"] = Coax_Col($coax, bcmul($post_cost_price, $forward_num, 1));	//原価金額（商品合計） total sales 
        	            $data_d[$f_ymd][$goods_id."-".$i]["sale_amount"] = Coax_Col($coax, bcmul($post_sale_price, $forward_num, 1));	//売上金額（商品合計）sales total (total products)
            	        $data_d[$f_ymd][$goods_id."-".$i]["tax_div"]     = $_POST["hdn_tax_div"][$i];               	//課税区分 tax classification

					}
				}
			}

			//受注ヘッダ・受注データ　登録・更新SQL sales order header, sales order data, registration, SQL update
			Db_Query($db_con, "BEGIN");

			//変更処理判定 decision for edit process
			if($aord_id != NULL){
                //受注変更前に、受注データの存在の有無を確認するcheck if a sales order data exist before editing
                $sql  = "SELECT";
                $sql .= "   COUNT(aord_id) ";
                $sql .= "FROM";
                $sql .= "   t_aorder_h ";
                $sql .= "WHERE";
                $sql .= "   aord_id = $aord_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                $del_count = pg_fetch_result($result, 0,0);

                if($del_count == 0){
                    Db_Query($db_con, "ROLLBACK;");
                    header("Location: ./1-2-108.php?add_del_flg='t'");
                    exit;    
                }

				//受注ヘッダー変更 edit the sales order data
				$sql  = "UPDATE t_aorder_h SET ";
				$sql .= "    ord_no = '$ord_no',";
				$sql .= "    ord_time = '$ord_day',";
				$sql .= "    client_id = $client_id,";
				//直送先が指定されているか is direct destination assigned
				if($direct_id != null){
					$sql .= "    direct_id = $direct_id,";
				}else{
					$sql .= "    direct_id = NULL,";
				}
				$sql .= "    trade_id = '$trade_aord',";
				//運送業者が指定されているか is the carrier assigned
				if($trans_id != null){
					$sql .= "    trans_id = $trans_id,";
				}else{
					$sql .= "    trans_id = NULL,";
				}
				//チェック値をbooleanに変更 change the checked value to booloean
	            if($trans_check==1){
	                $sql .= "green_flg = true,";    
	            }else{
	                $sql .= "green_flg = false,";    
	            }
				//希望納期が指定されているか is the desired delivery date assigned
				if($hope_day != null){
					$sql .= "    hope_day = '$hope_day',";
				}else{
					$sql .= "    hope_day = null,";
                } 
				if($arr_day != null){
					$sql .= "    arrival_day = '$arr_day',";
				}else{
					$sql .= "    arrival_day = null,";
                } 
				$sql .= "    note_my = '$note_head',";
				$sql .= "    note_your = '$note_client',";
				$sql .= "    cost_amount = $cost_money,";    
				$sql .= "    net_amount = $sale_money,";    
	            $sql .= "    tax_amount = $sale_tax,";    
				$sql .= "    c_staff_id = $c_staff_id,";
				$sql .= "    ware_id = $ware_id,";
				$sql .= "    ord_staff_id = $o_staff_id, ";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= ($direct_id != null) ? " direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), " : " direct_name = NULL, ";
                $sql .= ($direct_id != null) ? " direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), " : " direct_name2 = NULL, ";
                $sql .= ($direct_id != null) ? " direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), " : " direct_cname = NULL, ";
                $sql .= ($trans_id != NULL) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : " trans_name = NULL, ";
                $sql .= ($trans_id != NULL) ? " trans_cname = (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : " trans_cname = NULL, ";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                $sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
                $sql .= "    ord_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id), ";
                $sql .= "    change_day = CURRENT_TIMESTAMP ";

/***********************************************
				$sql .= "    check_flg = false,";
				$sql .= "    check_staff_id = NULL, ";
			    $sql .= "    check_user_name = NULL ";
************************************************/

				$sql .= "WHERE ";
	            $sql .= "    aord_id = $aord_id;";

				$result = Db_Query($db_con,$sql);
	            if($result == false){
	                Db_Query($db_con,"ROLLBACK;");
	                exit;
	            }

				//受注データを削除 delete the sales order 
	            $sql  = "DELETE FROM";
	            $sql .= "    t_aorder_d";
	            $sql .= " WHERE";
	            $sql .= "    aord_id = $aord_id";
	            $sql .= ";";

	            $result = Db_Query($db_con, $sql );
	            if($result == false){
	                Db_Query($db_con, "ROLLBACK");
	                exit;
	            }

				//rev.1.2 受注データ登録用に伝票番号を保持 store the voucher number for sales order registration
				$array_ord_no[$ord_day] = $ord_no;	//非分納時は出荷予定日が必須ではないので、受注日で配列を作る create an array with sales order date if its not a batch delivery since scheduled delivery date is not required

			//新規登録 new registration
			}else{

				//rev.1.2 
				//出荷予定日から重複を削除する delete the duplication fo scheduled delivery date
	            $all_ymd_uniq = array_unique($all_ymd);
                asort($all_ymd_uniq);

	            //出荷予定日(重複削除済)の数だけ受注ヘッダを登録する register sales order header as many as scheduled delivery dates are
    	        //while($fw_day = array_shift($all_ymd_uniq)){
				foreach($all_ymd_uniq as $fw_day){
        	        //伝票番号 voucher/slip number
            	    $order_no_pad = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

	                //■原価合計(税込)を求める compute for the total cost (with tax)
    	            $cost_money = array_sum($data_h["$fw_day"]["原価金額"]); //DBにカラムなし no column in DB

        	        //■売上合計(税込)を　売上合計（税抜）と　消費税に分ける separate the total sales to total sales (without tax) and tax
            	    $total_amount = Total_Amount($data_h["$fw_day"]["売上金額"], $data_h["$fw_day"]["課税区分"], $coax,$tax_franct,$tax_num, $client_id, $db_con);
	                $sale_money = $total_amount[0]; //売上合計 total sales
    	            $sale_tax = $total_amount[1]; //消費税 tax


					//受注ヘッダー登録 register the sales order header
					$sql  = "INSERT INTO t_aorder_h (";
					$sql .= "    aord_id,";
					$sql .= "    ord_no,";
					$sql .= "    ord_time,";
					$sql .= "    client_id,";
					//直送先が指定されているか is the direct destination assigned?
					if($direct_id != null){
						$sql .= "    direct_id,";
					}
					$sql .= "    trade_id,";
					//運送業者が指定されているか is the carrier assigned?
					if($trans_id != null){
						$sql .= "    trans_id,";
					}
					//グリーン指定が指定されているか is the green designation assigned?
					if($trans_check != null){
						$sql .= "    green_flg,";
					}
					//希望納期が指定されているか is the desired delivery date assigned?
					if($hope_day != null){
						$sql .= "    hope_day,";
					}
					//入荷予定日が指定されているか is the scheduled delivery date assigned?
					//if($arr_day != null){
						$sql .= "    arrival_day,";
					//}
					$sql .= "    note_my,";
					$sql .= "    note_your,";
					$sql .= "    cost_amount,";   
					$sql .= "    net_amount,";                  
		            $sql .= "    tax_amount,";              
					$sql .= "    c_staff_id,";
					$sql .= "    ware_id,";
					$sql .= "    ord_staff_id,";
					$sql .= "    ps_stat,";
					$sql .= "    shop_id, ";
	                $sql .= "    client_cd1, ";
	                $sql .= "    client_cd2, ";
	                $sql .= "    client_name, ";
	                $sql .= "    client_name2, ";
	                $sql .= "    client_cname, ";
	                $sql .= ($direct_id != null) ? " direct_name, " : null;
	                $sql .= ($direct_id != null) ? " direct_name2, " : null;
	                $sql .= ($direct_id != null) ? " direct_cname, " : null;
	                $sql .= ($trans_id != null) ? " trans_name, " : null;
	                $sql .= ($trans_id != null) ? " trans_cname, " : null;
	                $sql .= "    ware_name, ";
	                $sql .= "    c_staff_name, ";
	                $sql .= "    ord_staff_name, ";
	                $sql .= "    check_flg, ";
	                $sql .= "    claim_id, ";
	                $sql .= "    claim_div ";
					$sql .= ")VALUES(";
					$sql .= "    (SELECT COALESCE(MAX(aord_id), 0)+1 FROM t_aorder_h),";         
					$sql .= "    '$order_no_pad',";          
		            $sql .= "    '$ord_day',";
					$sql .= "    $client_id,";
					//直送先が指定されているか is the direct destination filled
					if($direct_id != null){
						$sql .= "    $direct_id,";
					}
					$sql .= "    '$trade_aord',";
					//運送業者が指定されているか Is the carrier filled
					if($trans_id != null){
						$sql .= "    $trans_id,";
					}
					//グリーン指定が指定されているか is the green designation filled
					if($trans_check != null){
			            if($trans_check==1){
			                $sql .= "true,";    
			            }else{
			                $sql .= "false,";    
			            }
					}
					//希望納期が指定されているか is the  desired delivery date filled
					if($hope_day != null){
		            	$sql .= "    '$hope_day',";
					}
					//入荷予定日が指定されているか Is scheduled delivery date filled?
					//if($arr_day != null){  
		            	//$sql .= "    '$arr_day',";
		            	$sql .= "    '$fw_day',";
					//}
					$sql .= "    '$note_head',"; 
		            $sql .= "    '$note_client',";
					$sql .= "    $cost_money,";   
					$sql .= "    $sale_money,";                  
		            $sql .= "    $sale_tax,";        
		            $sql .= "    $c_staff_id,";
		            $sql .= "    $ware_id,";           
		            $sql .= "    $o_staff_id,";
					//処理状況 Process status
					$sql .= "    '1',";
					$sql .= "    $shop_id, ";
	                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
	                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
	                $sql .= ($direct_id != null) ? " (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), " : null;
	                $sql .= ($direct_id != null) ? " (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), " : null;
					$sql .= ($direct_id != null) ? " (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), " : null;
	                $sql .= ($trans_id != null) ? " (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), " : null;
	                $sql .= ($trans_id != null) ? " (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), " : null;
	                $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
	                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id), ";
	                $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id), ";
	                $sql .= "    't',";
	                $sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '1'), ";
	                $sql .= "    '1' ";
	                $sql .= ");";


					$result = Db_Query($db_con, $sql);
					//同時実行制御処理 restriction process for simultaenous execution
					if($result == false){
		                $err_message = pg_last_error();
		                $err_format = "t_aorder_h_ord_no_key";

		                Db_Query($db_con, "ROLLBACK");

		                //受注番号が重複した場合            when the sales order number are duplicated
		                if(strstr($err_message,$err_format) != false){
		                    $error = "同時に受注を行ったため、受注番号が重複しました。もう一度受注をして下さい。";
		
		                    //再度受注番号を取得する acquire again the sales order number
		                    $sql  = "SELECT ";
		                    $sql .= "   MAX(ord_no)";
		                    $sql .= " FROM";
		                    $sql .= "   t_aorder_h";
		                    $sql .= " WHERE";
		                    $sql .= "   shop_id = $shop_id";
		                    $sql .= ";";

		                    $result = Db_Query($db_con, $sql);
		                    $ord_no = pg_fetch_result($result, 0 ,0);
		                    $ord_no = $ord_no +1;
		                    $ord_no = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

		                    $err_data["form_order_no"] = $ord_no;
		                    $form->setConstants($err_data);

		                    $duplicate_flg = true;

							break;	//rev.1.2 出荷予定日のループを抜ける get out from the scheduled shipment date loop

		                }else{
		                    exit;
		                }
		            }else{

						//受注データ登録用に伝票番号を保持 store the voucher number for sales order data registration
						$array_ord_no[$fw_day] = $order_no_pad;
						//rev.1.2 伝票番号 voucher number
						(int)$ord_no ++;

					}

				}//rev.1.2 出荷予定日ループ終わり finish with the scheduled delivery date loop
			}

	        if($duplicate_flg != true){
			    //受注データ登録 register the sales order data

                //出荷予定日（非分納時は受注日）でループ loop with scheduled shipment date (if its not by batch shipment then use the sales order date here)
                foreach($array_ord_no as $fw_day => $ord_no){

                    //$line = 0;

                    //新規登録（分納時）は出荷予定日ごとに new registration (for batch delivery) will be per scheduled delivery date
					if($edit_flg != "true"){

                        //配列を初期化 initialize the arrays
                        $goods_id       = array();
                        $tax_div        = array();
                        $sale_num       = array();
                        $c_price        = array();
                        $s_price        = array();
                        $cost_amount    = array();
                        $sale_amount    = array();
                        $goods_name     = array();

                        //$fw_day に出荷商品分ループ処理 shipping products loop process to $fw_day
                        while($fw_goods_id = array_shift($data_d[$fw_day]["good_id"])){

                            //出荷商品の入力行 input row for shipping products
                            $fw_goods_line = array_shift($data_d[$fw_day]["line"]);

                            $goods_id[]     = $fw_goods_id;                                                     //商品ID Product ID
                            $tax_div[]      = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["tax_div"];     //課税区分 tax classification
                            $sale_num_tmp   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["num"];
                            $sale_num[]     = $sale_num_tmp;                                                    //出荷数 number of products to be shipped  
                            $c_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["cost_price"];
                            $c_price[]      = $c_price_tmp;                                                     //原価単価 cost price per unit
                            $s_price_tmp    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["sale_price"];
                            $s_price[]      = $s_price_tmp;                                                     //売上単価 sales per unit

                            $c_amount       = bcmul($sale_num_tmp, $c_price_tmp, 1);
                            $cost_amount[]  = Coax_Col($coax, $c_amount);                                       //原価金額 cost price
                            $s_amount       = bcmul($sale_num_tmp, $s_price_tmp, 1);
                            $sale_amount[]  = Coax_Col($coax, $s_amount);                                       //売上金額 total sales 
                            $goods_name[]   = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line]["goods_name"];	//商品名 product name

                        }
                    }


		            for($i = 0; $i < count($goods_id); $i++){
		                //行 row
		                $line = $i + 1;

		                $sql  = "INSERT INTO t_aorder_d (\n";
		                $sql .= "    aord_d_id,\n";
		                $sql .= "    aord_id,\n";
		                $sql .= "    line,\n";
		                $sql .= "    goods_id,\n";
//		                $sql .= "    goods_name,\n";
		                $sql .= "    official_goods_name,\n";
		                $sql .= "    num,\n";
		                $sql .= "    tax_div,\n";
		                $sql .= "    cost_price,\n";
		                $sql .= "    cost_amount,\n";
					    $sql .= "    sale_price,\n";
		                $sql .= "    sale_amount,\n";
	                    $sql .= "    goods_cd \n";
//					    $sql .= "    tax_amount";
		                $sql .= ")VALUES(\n";
		                $sql .= "    (SELECT COALESCE(MAX(aord_d_id), 0)+1 FROM t_aorder_d),\n";  
		                $sql .= "    (SELECT\n";
		                $sql .= "         aord_id\n";
		                $sql .= "     FROM\n";
		                $sql .= "        t_aorder_h\n";
		                $sql .= "     WHERE\n";
		                $sql .= "        ord_no = '$ord_no'\n";
		                $sql .= "        AND\n";
		                $sql .= "        shop_id = $shop_id\n";
		                $sql .= "    ),\n";
		                $sql .= "    '$line',\n";
		                $sql .= "    $goods_id[$i],\n";
		                $sql .= "    '$goods_name[$i]',\n"; 
		                $sql .= "    '$sale_num[$i]',\n";
		                $sql .= "    '$tax_div[$i]',\n";
		                $sql .= "    $c_price[$i],\n";
		                $sql .= "    $cost_amount[$i],\n";
					    $sql .= "    $s_price[$i],\n";
		                $sql .= "    $sale_amount[$i],\n";
	                    $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]) \n";
//					    $sql .= "    $t_price";
		                $sql .= ");\n";

		                $result = Db_Query($db_con, $sql);

		                if($result == false){
		                    Db_Query($db_con, "ROLLBACK");
		                    exit;
		                }
				    }

				    for($i = 0; $i < count($goods_id); $i++){
		                $line = $i + 1;
//いかなる場合も在庫受け払いテーブルに登録する in any case register it to the inventory store balance
//		                if($stock_manage_flg[$i] == '1'){
		                    //受け払いテーブルに登録 register it to the inventory store balance
		                    $sql  = " INSERT INTO t_stock_hand (";
		                    $sql .= "    goods_id,";
		                    $sql .= "    enter_day,";
		                    $sql .= "    work_day,";
		                    $sql .= "    work_div,";
		                    $sql .= "    client_id,";
		                    $sql .= "    ware_id,";
		                    $sql .= "    io_div,";
		                    $sql .= "    num,";
		                    $sql .= "    slip_no,";
		                    $sql .= "    aord_d_id,";
		                    $sql .= "    staff_id,";
		                    $sql .= "    shop_id,";
	                        $sql .= "    client_cname";
		                    $sql .= ")VALUES(";
		                    $sql .= "    $goods_id[$i],";
		                    $sql .= "    NOW(),";
		                    $sql .= "    '$ord_day',";
		                    $sql .= "    '1',";
		                    $sql .= "    $client_id,";
		                    $sql .= "    $ware_id,";
		                    $sql .= "    '2',";
		                    $sql .= "    $sale_num[$i],";
		                    $sql .= "    '$ord_no',";
		                    $sql .= "    (SELECT";
		                    $sql .= "        aord_d_id";
		                    $sql .= "    FROM";
		                    $sql .= "        t_aorder_d";
		                    $sql .= "    WHERE";
		                    $sql .= "        line = $line";
		                    $sql .= "        AND";
		                    $sql .= "        aord_id = (SELECT";
		                    $sql .= "                    aord_id";
		                    $sql .= "                 FROM";
		                    $sql .= "                    t_aorder_h";
		                    $sql .= "                 WHERE";
		                    $sql .= "                    ord_no = '$ord_no'";
		                    $sql .= "                    AND";
		                    $sql .= "                    shop_id = $shop_id";
		                    $sql .= "                )";
		                    $sql .= "    ),";
		                    $sql .= "    $o_staff_id,";
		                    $sql .= "    $shop_id,";
	                        $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
		                    $sql .= ");";

		                    $result = Db_Query($db_con, $sql);
		                    if($result == false){
		                        Db_Query($db_con, "ROLLBACK");
		                        exit;
		                    }
//		                }
		            }

				}//re.1.2 出荷予定日ごとループ終わり finish loop per scheduled delivery date

	    		//新規登録の場合は、GET情報が無い為、GET情報作成 Create a GET information if it's a new registration
		    	if($aord_id == null){
					//rev.1.2 分納時は複数受注ができるため because multiple orders are possible with batch delivery
					$all_ord_no = "";
					foreach($array_ord_no as $ord_no){
						$all_ord_no .= "'".$ord_no."'";
						$all_ord_no .= ", ";
					}
					$all_ord_no = substr($all_ord_no, 0, strlen($all_ord_no) - 2);	//最後の", "が余計なので取る take out the "," in the last part

			    	//受注確認に渡す受注ID取得 acquire the sales order ID that will be pass to order confirmation
		            $sql  = "SELECT ";
	    	        $sql .= "    aord_id ";
		            $sql .= "FROM ";
		            $sql .= "    t_aorder_h ";
		            $sql .= "WHERE ";
	    	        //$sql .= "    ord_no = '$ord_no'";
	    	        $sql .= "    ord_no IN ($all_ord_no)";	//rev.1.2
		            $sql .= "AND ";
		            $sql .= "    shop_id = $shop_id;";
		            $result = Db_Query($db_con, $sql);
	    	        //$aord_id = pg_fetch_result($result,0,0);
					//rev.1.2
					$count_ord_no = pg_num_rows($result);
					for($i=0, $aord_id = ""; $i<$count_ord_no; $i++){
		    	        $aord_id .= pg_fetch_result($result, $i, 0);
						$aord_id .= "&";
					}
					$aord_id = substr($aord_id, 0, strlen($aord_id) - 1);	//最後の"&"が余計なので取る take out the "&" in the last part
		    	}
	            Db_Query($db_con, "COMMIT");
	            header("Location: ./1-2-108.php?aord_id=$aord_id&input_flg=true");
	        }
		}else{
			//登録確認画面を表示フラグ flag for display of registration confirmation screen
			$comp_flg = true;
		}
	}
}

/****************************/
//チェック完了ボタン押下処理 process when check button is pressed
/****************************/
/*******************************************************************
if($_POST["complete_flg"] == true && $aord_id != NULL){
	Db_Query($db_con, "BEGIN");

    /*******************************/
    //受注が存在するか確認 check if a sales order exist 
    /*******************************/
/*******************************************************************
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) ";
    $sql .= "FROM";
    $sql .= "   t_aorder_h ";
    $sql .= "WHERE";
    $sql .= "   aord_id = $aord_id";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
    if($update_check_flg === false){ 
        header("Location: ./1-2-108.php?aord_del_flg=true");
        exit;   
    } 

	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "    check_flg = true,";
	$sql .= "    check_staff_id = $o_staff_id, ";
    $sql .= "    check_user_name = (SELECT staff_name FROM t_staff WHERE staff_id = $o_staff_id)";
	$sql .= "WHERE ";
	$sql .= "    aord_id = $aord_id;";
	$result = Db_Query($db_con, $sql);

    if($result == false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
	Db_Query($db_con, "COMMIT");
	header("Location: ./1-2-105.php");
}
*************************************************************************/

/****************************/
//部品作成（可変）create component (variable)
/****************************/
//行番号カウンタ row number counter
$row_num = 1;

//出荷回数セレクトボックス用 rev.1.2 for number of shipment selection box
$select_page_arr = array(1,2,3,4,5,6,7,8,9,10);


//得意先が選択されていない場合はフォーム非表示 do not display the form if the customer is not selected 
/************************************************************************
if($warning != null || $comp_flg == true || $check_flg == true){
*************************************************************************/
if($warning != null || $comp_flg == true){
    #2009-09-26 hashimoto-y
	#$style = "color: #000000; border: #ffffff 1px solid; background-color: #ffffff";
	$style = "border: #ffffff 1px solid; background-color: #ffffff";
    $type = "readonly";
}else{
    $type = $g_form_option;
}
for($i = 0; $i < $max_row; $i++){
    //表示行判定 determine the displayable row
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

		//rev.1.2 値引商品か判定（以下全てのフォームに追加）determine if its a discounted product (include in all forms hereon)
		$hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

		if($hdn_discount_flg == "t"){
			$font_color = "color: red; ";	//値引商品の場合はフォントを赤にする turn the font color to red for discounted products
		}else{
			$font_color = "color: #000000; ";
		}

        //商品コード product code
        $form->addElement(
            "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\" 
             style=\"$style $g_form_style $font_color\" $type tabindex=\"-1\" 
            onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
        );

		//商品名 product name
		//変更不可判定 determine if its editable or not
		//if(($_POST["hdn_name_change"][$i] == '2' || $hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
/**********************************************************************
		if(($hdn_name_change[$i] == '2') && $comp_flg != true && $check_flg != true){
**********************************************************************/
		if(($hdn_name_change[$i] == '2') && $comp_flg != true){
			//不可 not editable
            $form->addElement(
                "text","form_goods_name[$i]","",
                #2009-09-26 hashimoto-y
                #"size=\"60\" $g_text_readonly" 
                "size=\"60\" style=\"$font_color\" $g_text_readonly" 
            );
        }else{
			//可 editable
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"60\" maxLength=\"41\" 
                style=\"$font_color $style \" $type"
            );
        }

        //実棚数 actual shelf number
		//在庫管理判定 determine inventory control 
		//if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '1' || $hdn_stock_manage[$i] == '1')){
		if($no_goods_flg!=true && ($hdn_stock_manage[$i] == '1')){
			//得意先が変わったので初期化 initialize cos the customer changed
			if($post_flg == true){
				$form->addElement("static","form_stock_num[$i]","#","","");
			}else{

				//有 yes
				//POSTする前のとき以外は、hiddenの値を使用する(実棚数) *レンタル遷移時にもhiddenの値を使用 use the value of hidden for actual shelf number as well as for transition from rental excep before POST
				if($_POST["hdn_stock_num"][$i] != NULL && ($_POST["hdn_stock_num"][$i] == $stock_num[$i] || $rental_flg == true)){
					$hdn_num = $_POST["hdn_stock_num"][$i];
				}else{
					$hdn_num = $stock_num[$i];
				}

				//POSTする前のとき以外は、hiddenの値を使用する(商品ID)
				if($_POST["hdn_goods_id"][$i] != NULL && $_POST["hdn_goods_id"][$i] == $hdn_goods_id[$i]){
					$hdn_id = $_POST["hdn_goods_id"][$i];

/*
                }elseif($_POST["hdn_goods_id"][$i] != NULL){
                    $hdn_id = $_POST["hdn_goods_id"][$i];
*/
				}else{
					$hdn_id = $hdn_goods_id[$i];
				}

				$form->addElement("link","form_stock_num[$i]","","#","$hdn_num","onClick=\"Open_mlessDialmg_g('1-2-107.php',$hdn_id,$client_id,300,160);\"");
			}
		//}else if($no_goods_flg!=true && ($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2')){
		}else if($no_goods_flg!=true && ($hdn_stock_manage[$i] == '2')){
			//無 none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_stock_num[$i]","#","-","");
	        $form->addElement(
	            "text","form_stock_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
            $form->setConstants(array("form_stock_num[$i]" => "-"));
		}else{
	        $form->addElement(
	            "text","form_stock_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
		}

        //発注済数 number of fulfilled orders
		//在庫管理判定 inventory control decision
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//無 none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_rorder_num[$i]","#","-","");
	        $form->addElement(
	            "text","form_rorder_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
            $form->setConstants(array("form_rorder_num[$i]" => "-"));
		}else{
	        $form->addElement(
	            "text","form_rorder_num[$i]","",
	            "class=\"money\" size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
		}

        //引当数 number of reserved units of product
		//在庫管理判定 inventory control decision
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//無 none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_rstock_num[$i]","#","-","");
	        $form->addElement("text","form_rstock_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
            $form->setConstants(array("form_rstock_num[$i]" => "-"));
		}else{
	        $form->addElement("text","form_rstock_num[$i]","",
	            "class=\"money\" size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
		}

        //出荷可能数 number of products that can be shipped
		//if($_POST["hdn_stock_manage"][$i] == '2' || $hdn_stock_manage[$i] == '2'){
		if($hdn_stock_manage[$i] == '2'){
			//無 none
            #2009-09-26 hashimoto-y
			#$form->addElement("static","form_designated_num[$i]","#","-","");
	        $form->addElement("text","form_designated_num[$i]","",
	            "size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
            $form->setConstants(array("form_designated_num[$i]" => "-"));
		}else{
	        $form->addElement("text","form_designated_num[$i]","",
	            "class=\"money\" size=\"11\" maxLength=\"9\" 
	            style=\"$font_color 
	            border : #ffffff 1px solid; 
	            background-color: #ffffff; 
	            text-align: right\" readonly'"
	        );
		}

        //受注数 number of sales order
		// rev.1.2 変更画面のみ表示 only display edit screen
		if($edit_flg == "true"){
	        $form->addElement(
    	        "text","form_sale_num[$i]","",
        	    "class=\"money\" size=\"11\" maxLength=\"5\" 
            	onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"
	            style=\"text-align: right; $style $g_form_style $font_color\" $type "
    	    );
		}

		//rev.1.2 変更時の金額計算JS computation of amount when edited
		if($edit_flg == "true"){
			$mult_js = "onKeyup=\"Mult_double('hdn_goods_id[$i]','form_sale_num[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','$coax');\"";
		//分納時の金額計算JS computation when it's a batch shipment
		}else{
			$mult_js = "onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"";
		}

        //原価単価 cost per unit
        $form_cost_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
			$mult_js
            style=\"text-align: right; $style $g_form_style $font_color\"
            $type"
        );
        $form_cost_price[$i][] =& $form->createElement("static","","",".");
        $form_cost_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
			$mult_js
            style=\"text-align: left; $style $g_form_style $font_color\"
            $type"
        );
        $form->addGroup( $form_cost_price[$i], "form_cost_price[$i]", "");

        //原価金額 total cost
        $form->addElement(
            "text","form_cost_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );
        
		//売上単価 sales per unit
        $form_sale_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\"
            class=\"money\"
			$mult_js
            style=\"text-align: right; $style $g_form_style $font_color\"
            $type"
        );
        $form_sale_price[$i][] =& $form->createElement("static","","",".");
        $form_sale_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
			$mult_js
            style=\"text-align: left; $style $g_form_style $font_color\"
            $type"
        );
        $form->addGroup( $form_sale_price[$i], "form_sale_price[$i]", "");

        //売上金額 total sales
        $form->addElement(
            "text","form_sale_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );


		//rev.1.2（出荷回数、分納時出荷回数、出荷数） (number of shipment, number of shipment when it is a batch shipment, number of shipped products
		//JavaScriptを入力画面、確認画面で切り替える change the input screen and confirmation screen with JS
		if($type != "readonly"){
        	$form_fd_focus = "onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','y','m','d','form_ord_day','y','m','d')\"";
			$form_fn_option = $g_form_option;
		}else{
			$form_fd_focus = $type;
			$form_fn_option = "";
		}

		//出荷回数 number of shipment
		//確認画面ではhidden＋テキストフォームにする make it hidden+text form in confirmation screen
		if($type != "readonly"){
			$form->addElement(
					'select', 'form_forward_times['.$i.']', "出荷回数", $select_page_arr,
					"onChange=\"javascript:Button_Submit('forward_num_flg','#','true', this)\" style=\"$font_color\""
					);
		}else{
			$form->addElement("hidden","form_forward_times[$i]");
	        $form->addElement('text', 'form_forward_times_text['.$i.']', "出荷回数", "size=\"3\" style=\"text-align: right; $style $g_form_style; $font_color\" $type");
		}

		//分納時出荷予定日 scheduled deliver date for batch shipment
        $form_forward_day = "";
        $form_forward_day[] =& $form->createElement(
                "text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$style $g_form_style; $font_color\"
                onkeyup=\"changeText(this.form,'form_forward_day[$i][0][y]','form_forward_day[$i][0][m]',4)\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form_forward_day[] =& $form->createElement(
                "text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$style $g_form_style; $font_color\"
                onkeyup=\"changeText(this.form,'form_forward_day[$i][0][m]','form_forward_day[$i][0][d]',2)\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form_forward_day[] =& $form->createElement(
                "text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$style $g_form_style; $font_color\"
                $form_fd_focus
                onBlur=\"blurForm(this)\"
				"
                );
        $form->addGroup( $form_forward_day,"form_forward_day[".$i."][0]","form_forward_day","-");

        //出荷数 number of shipping products
        $form->addElement(
                "text","form_forward_num[".$i."][0]","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\"
            	onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                style=\"$font_color $g_form_style;text-align: right; $style \"
                \".$form_fn_option.\"
				$type"
                );

		//出荷回数を変更した場合 when the number of shipment has been edited
        if($_POST["forward_num_flg"] == true){
            $forward_number = $_POST["form_forward_times"][$i];
            for($j=1;$j<=$forward_number;$j++){
                //出荷予定日 scheduled shipment date
                $form_forward_day = "";
                $form_fd_focus = ($type != "readonly") ? "onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','y','m','d','form_ord_day','y','m','d')\"" : "";
                $form_forward_day[] =& $form->createElement(
                        "text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$font_color $style $g_form_style\"
                        onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][y]','form_forward_day[$i][$j][m]',4)\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form_forward_day[] =& $form->createElement(
                        "text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$font_color $style $g_form_style\"
                        onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][m]','form_forward_day[$i][$j][d]',2)\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form_forward_day[] =& $form->createElement(
                        "text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$font_color $style $g_form_style\"
						$form_fd_focus
                        onBlur=\"blurForm(this)\"
						"
                        );
                $form->addGroup( $form_forward_day,"form_forward_day[".$i."][".$j."]","form_forward_day","-");

                //出荷数 number of shipping products
                $form->addElement(
                        "text","form_forward_num[".$i."][".$j."]","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\"
            			onKeyup=\"Mult_double_h_aord_off('hdn_goods_id[$i]','form_sale_price[$i][i]','form_sale_price[$i][d]','form_sale_amount[$i]','form_cost_price[$i][i]','form_cost_price[$i][d]','form_cost_amount[$i]','form_forward_times[$i]','form_forward_num[$i]','$coax');\"
                        style=\"$g_form_style;text-align: right; $style $font_color\"
                        \".$form_fn_option.\"
						$type"
                );
            }
        }



		//登録確認画面の場合は非表示 do not diplay if it is a registration confirmation screen.
/*************************************************************
		if($comp_flg != true && $check_flg != true){
**************************************************************/
		if($comp_flg != true){

	        //検索リンク search link
	        $form->addElement(
	            "link","form_search[$i]","","#","検索",
	            "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,$client_id,$i,$row_num);\""
	        );

	        //削除リンク deletion link
	        //最終行を削除する場合、削除した後の最終行に合わせる if the last row will be deleted, then match it with the new last row
	        if($row_num == $max_row-$del_num){
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>削除</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1. this);return false;\""
	            );
	        //最終行以外を削除する場合、削除する行と同じNOの行に合わせる if rows other than the last row will be deleted, match with the same row number being deleted
	        }else{
	            $form->addElement(
	                "link","form_del_row[$i]","",
	                "#","<font color='#FEFEFE'>削除</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num, this);return false;\""
	            );
	        }
		}

		//商品ID product ID
        $form->addElement("hidden","hdn_goods_id[$i]");
        //課税区分 tax class
        $form->addElement("hidden", "hdn_tax_div[$i]");
		//品名変更フラグ edit product name flag
        $form->addElement("hidden","hdn_name_change[$i]");
		//在庫管理 inventory control
        $form->addElement("hidden","hdn_stock_manage[$i]");
		//実棚数 actual shelf number
		$form->addElement("hidden","hdn_stock_num[$i]");
		//rev.1.2 値引判定フラグ discounted decision flag
        #2009-09-26 hashimoto-y
		#$form->addElement("hidden","hdn_discount_flg[$i]");


        /****************************/
        //表示用HTML作成 create an HTML for display
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
/***************************************************************
		if($warning == null && $comp_flg != true && $check_flg != true){
****************************************************************/
		if($warning == null && $comp_flg != true){
        	$html .=    "（";
        	$html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
        	$html .=    "）";
		}
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>";
		$html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_rstock_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_designated_num[$i]"]]->toHtml();
        $html .= "  </td>";
		// rev.1.2 変更画面 edit screen
		if($edit_flg == "true"){
	        $html .=    "<td align=\"right\">";
    	    $html .=        $form->_elements[$form->_elementIndex["form_sale_num[$i]"]]->toHtml();
        	$html .=    "</td>";
		}
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_cost_price[$i]"]]->toHtml();
		$html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_sale_price[$i]"]]->toHtml();
        $html .=    "</td>";

        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_cost_amount[$i]"]]->toHtml();
		$html .=    "<br>";
		$html .=        $form->_elements[$form->_elementIndex["form_sale_amount[$i]"]]->toHtml();
        $html .=    "</td>";

		//rev.1.2 分納時（出荷回数、分納時出荷回数、出荷数）when batch shipment (number of shipment, number of shipment when it's a batch delivery, number of shipping prod)
		if($edit_flg != "true"){
	        $html .=    "<td align=\"center\">";
    	    $html .=        $form->_elements[$form->_elementIndex["form_forward_times[$i]"]]->toHtml();
			if($type == "readonly"){
    	    	$html .=        $form->_elements[$form->_elementIndex["form_forward_times_text[$i]"]]->toHtml();
			}
        	$html .=    "</td>\n";
	        $html .=    "<td align=\"center\">";
			for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
        		$html .=        $form->_elements[$form->_elementIndex["form_forward_day[$i][$j]"]]->toHtml();
				$html .= "<br>\n";
			}
    	    $html .=    "</td>\n";
        	$html .=    "<td align=\"center\">";
			for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
    	    	$html .=        $form->_elements[$form->_elementIndex["form_forward_num[$i][$j]"]]->toHtml();
				$html .= "<br>\n";
			}
		}
        $html .=    "</td>\n";

/*****************************************************************
		if($warning == null && $comp_flg != true && $check_flg != true){
******************************************************************/
		if($warning == null && $comp_flg != true){
        	$html .= "  <td class=\"Title_Add\" align=\"center\">";
        	$html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
        	$html .= "  </td>";
		}
        $html .= "</tr>";

        //行番号を＋１ +1 to row number
        $row_num = $row_num+1;
    }
}

//登録確認画面では、以下のボタンを表示しない do not show the buttons below in the registration confirmation screen
/****************************************************************
if($comp_flg != true && $check_flg != true){
****************************************************************/
if($comp_flg != true){

    //button
    $form->addElement("submit","order","受注確認画面へ", $disabled);
    $form->addElement("button","form_back_button","戻　る","onClick=\"javascript:history.back()\"");

    //合計 total
	$form->addElement("button","form_sum_button","合　計","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true', this)\"");

	//行追加ボタン add row button
	$form->addElement("button","add_row_link","行追加","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true', this)\"");

}else{
    //登録確認画面では以下のボタンを表示 show the buttons below in the registration confirmation screen
    //戻る back
    $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
    
	//チェック完了ボタン check done button
	$form->addElement("button","complete","チェック完了","onClick=\"return Dialogue_2('チェックを完了します。','".HEAD_DIR."sale/1-2-101.php?aord_id=".$aord_id."','true','complete_flg', this);\" $disabled");

    //OK
    $form->addElement("submit","comp_button","受注OK", $disabled);
    
    $form->freeze();
}


//rev.1.2 出荷数合計 * 単価の JavaScript JS for number of shipped product * price per unit
$java_sheet = <<< JS

function Mult_double_h_aord_off(goods_id,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,forward_times,forward_num,coax){

    var GI  = goods_id;

    var PI  = s_price_i;
    var PD  = s_price_d;
    var SA  = sale_amount;

    var PI2 = c_price_i;
    var PD2 = c_price_d;
    var SA2 = cost_amount;

    var FT  = forward_times;
    var FN  = forward_num;

    //hiddenの商品IDがあるか is there a product ID hidden
    if(document.dateForm.elements[GI].value != ""){

        //数字ではない場合は処理を行なわない if not number dont processs
        var str  = document.dateForm.elements[PI].value;
        var str2 = document.dateForm.elements[PD].value;
        if(isNaN(document.dateForm.elements[PI].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD].value) == false && str2.search(/.*\..*/i) == -1){

            //出荷数を合計 total the shipped no of product
            times = document.dateForm.elements[FT].value
            forward_sum = 0;
            for(var i=0; i<=times; i++){
                forward_sum += (document.dateForm.elements[FN+"["+i+"]"].value - 0);
            }

            //計算１ computation 1
            document.dateForm.elements[SA].value = forward_sum * (eval(Number(document.dateForm.elements[PI].value+"."+document.dateForm.elements[PD].value)));

            //切捨ての場合 when rounding down
            if(coax == '1'){
                document.dateForm.elements[SA].value = Math.floor(document.dateForm.elements[SA].value);
            //四捨五入の場合 when rounding up/down
            }else if(coax == '2'){
                document.dateForm.elements[SA].value = Math.round(document.dateForm.elements[SA].value);
            //切上げの場合 when rounding up
            }else if(coax == '3'){
                document.dateForm.elements[SA].value = Math.ceil(document.dateForm.elements[SA].value);
            }

            //数字ではない場合 or 数量が小数の場合 は空を返す return blank if its not a number or if the number is a decimal
            var str = forward_sum + "";
            if(isNaN(document.dateForm.elements[SA].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA].value = "";
            }
            document.dateForm.elements[SA].value = trimFixed(document.dateForm.elements[SA].value);
            document.dateForm.elements[SA].value = myFormatNumber(document.dateForm.elements[SA].value);
        }else{
            document.dateForm.elements[SA].value = "";
        }

        //数字ではない場合は処理を行なわない dont process if not number
        var str  = document.dateForm.elements[PI2].value;
        var str2 = document.dateForm.elements[PD2].value;
        if(isNaN(document.dateForm.elements[PI2].value) == false && str.search(/.*\..*/i) == -1 && isNaN(document.dateForm.elements[PD2].value) == false && str2.search(/.*\..*/i) == -1){
            //計算２ computation 2 
            document.dateForm.elements[SA2].value = forward_sum * (eval(Number(document.dateForm.elements[PI2].value+"."+document.dateForm.elements[PD2].value)));

            //切捨ての場合 when rounding off
            if(coax == '1'){
                document.dateForm.elements[SA2].value = Math.floor(document.dateForm.elements[SA2].value);
            //四捨五入の場合 when roundung up or down
            }else if(coax == '2'){
                document.dateForm.elements[SA2].value = Math.round(document.dateForm.elements[SA2].value);
            //切上げの場合 when rounding up
            }else if(coax == '3'){
                document.dateForm.elements[SA2].value = Math.ceil(document.dateForm.elements[SA2].value);
            }

            //数字ではない場合 or 数量が小数の場合 は空を返す return blank if its not a number or if the number is a decimal
            var str = forward_sum + "";
            if(isNaN(document.dateForm.elements[SA2].value) == true || str.search(/.*\..*/i) != -1){
                document.dateForm.elements[SA2].value = "";
            }

            document.dateForm.elements[SA2].value = trimFixed(document.dateForm.elements[SA2].value);
            document.dateForm.elements[SA2].value = myFormatNumber(document.dateForm.elements[SA2].value);
        }else{
            document.dateForm.elements[SA2].value = "";
        }
        return true;
    }else{
        return false;
    }
}

JS;


//print_array($_POST);
/****************************/
//HTMLヘッダ header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('sale','1');
/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variable
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'warning'       => "$warning",
	'html'          => "$html",
	'aord_id'       => "$aord_id",
    'duplicate_err' => "$error",
	'form_potision' => "$form_potision",
	'comp_flg'      => "$comp_flg",
	'check_flg'     => "$check_flg",
    'auth_r_msg'    => "$auth_r_msg",

	'edit_flg'      => "$edit_flg",
    'forward_day_err'   => "$forward_day_err",
    'forward_num_err'   => "$forward_num_err",
	'html_js'       => "$java_sheet",

));

$smarty->assign('goods_error0',$goods_error0);
$smarty->assign('goods_error1',$goods_error1);
$smarty->assign('goods_error2',$goods_error2);
$smarty->assign('goods_error3',$goods_error3);
$smarty->assign('goods_error4',$goods_error4);
$smarty->assign('goods_error5',$goods_error5);
$smarty->assign('duplicate_goods_err', $duplicate_goods_err);


//テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
