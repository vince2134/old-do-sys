<?php
/******************************
 *  変更履歴
 *      ・ 2006/07/26 商品マスタの構成変更に伴う抽出条件の修正＜watanabe-k＞
 *      ・ 2006/12/01 丸め区分を東陽に変更＜suzuki＞
 *      ・ 2007/04/06 営業原価のデフォルト値は空白でなく、商品マスタの営業金額とするように修正<morita-d>
 *      ・ 2007/04/06 契約状態の表示を追加<morita-d>
 *      ・ 2007/04/24 契約発効日、修正発効日は本日より前をエラーとするように変更<morita-d>
 *      ・ 2007-06-05 伝票の作成は、「得意先単位」でなく「契約単位」で実施するように修正<morita-d>
 *      ・ 2007-06-09 予定データが重複して作成される場合は警告を表示するように修正<morita-d>
******************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-11-10      01-014      suzuki      サービスのみ伝票の仕入金額を代行入力時に営業金額をいれるように修正
 *  2007/06/28      xx-xxx      kajioka-h   商品マスタ同期フラグを登録可能に
 *  2007/07/04      B0702-069   kajioka-h   受託時に構成品の原価が表示されないバグ修正
 *                  B0702-070   kajioka-h   POSTすると代行区分が初期画面表示状態にもどるバグ修正
 *  2007/07/06      B0702-071   kajioka-h   備考に改行を登録すると、表示時に</ br>が付いて表示されるバグ修正
 *                  xx-xxx      kajioka-h   青メッセージを「単価」→「営業原価」に変更
 *  2007/07/23      B0702-074   kajioka-h   受託先宛備考のサニタイジング漏れ修正
 *  2007/08/01      保守作業57  kajioka-h   売上率が空だと巡回担当者が登録できない（エラーになる）のを修正
 *  2009/09/22                  hashimoto-y 値引き商品を赤字表示に変更
 */

$page_title = "代行契約マスタ";
require_once("ENV_local.php");                    //環境設定ファイル 
require_once(INCLUDE_DIR."error_msg_list.inc");   //エラーメッセージ
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数

//DBに接続
$db_con = Db_Connect();

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/
$client_id   = $_GET["client_id"];      //得意先
$get_con_id  = $_GET["contract_id"];    //契約情報ID
$client_h_id = $_SESSION["client_id"];  //ログインユーザID
$rank_cd     = $_SESSION["fc_rank_cd"]; //顧客区分コード
$staff_id    = $_SESSION["staff_id"];   //ログイン者ID

//直リンクで遷移してきた場合には、TOPに飛ばす
if(count($_GET) == 0){
	$jump = NULL;
	Get_ID_Check2($jump);
}

//得意先IDをhiddenにより保持する
if($_GET["client_id"] != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

//契約情報IDをhiddenにより保持する
if($_GET["contract_id"] != NULL){
	$con_data2["hdn_con_id"] = $get_con_id;
}else{
	$get_con_id = $_POST["hdn_con_id"];
}

//不正判定
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);

/****************************/
//不正値判定関数
/****************************/
Injustice_check($db_con,"trust",$get_con_id,$client_h_id);
Injustice_check($db_con,"trust_client",$get_con_id,$client_id);



//****************************
//得意先情報取得
//****************************
//東陽のclient_idを取得（各ショップの得意先マスタに自動で登録されるやつ）
$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
$result = Db_Query($db_con, $sql);
$toyo_id = pg_fetch_result($result, 0, 0);
//丸め区分取得
$sql  = "SELECT ";
$sql .= "   t_client.coax ";    
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $toyo_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);
$coax = $data_list[0][0];        //丸め区分（商品）




/****************************/
//初期設定
/****************************/
//契約マスタ
$sql  = "SELECT ";
$sql .= "    t_contract.trust_line,";      //行No0
$sql .= "    t_contract.route,";           //順路1
$sql .= "    t_staff1.staff_id,";          //担当者1 2
$sql .= "    t_staff1.sale_rate,";         //売上率1 3
$sql .= "    t_staff2.staff_id,";          //担当者2 4
$sql .= "    t_staff2.sale_rate,";         //売上率2 5
$sql .= "    t_staff3.staff_id,";          //担当者3 6
$sql .= "    t_staff3.sale_rate,";         //売上率3 7
$sql .= "    t_staff4.staff_id,";          //担当者4 8
$sql .= "    t_staff4.sale_rate,";         //売上率4 9
$sql .= "    t_contract.round_div,";       //巡回区分10
$sql .= "    t_contract.cycle,";           //周期11
$sql .= "    t_contract.cycle_unit,";      //周期単位12
$sql .= "    t_contract.cale_week,";       //週名13
$sql .= "    t_contract.abcd_week,";       //ABCD週14
$sql .= "    t_contract.rday,";            //指定日15
$sql .= "    t_contract.week_rday,";       //指定曜日16
$sql .= "    t_contract.stand_day,";       //基準日17
$sql .= "    t_contract.act_trust_day,";   //受託日18
$sql .= "    t_contract.trust_note, ";     //備考19
$sql .= "    t_contract.last_day,";        //変則最終日20

$sql .= "    t_contract.contract_div,";    //契約区分21
$sql .= "    t_contract.trust_id,";        //受託先ID22
$sql .= "    t_contract.act_request_rate,";//代行依頼料23
$sql .= "    t_contract.trust_ahead_note,";//受託先宛備考24
$sql .= "    t_contract.act_goods_id,";    //代行料の商品ID25
$sql .= "    t_goods.goods_cd,";           //代行料の商品CD26
$sql .= "    t_goods.goods_cname, ";       //代行料の商品名27
$sql .= "    t_contract.update_day, ";     //修正有効日28
$sql .= "    t_contract.contract_eday,";   //契約終了日29
$sql .= "    t_contract.state, ";           //契約状態30
$sql .= "    t_contract.act_div,";          //代行依頼料31
$sql .= "    t_contract.act_request_price,";//代行依頼料32
$sql .= "    t_contract.request_state, ";    //代行依頼状況33
$sql .= "    t_contract.trust_sale_amount ";    //代行依頼状況34

$sql .= "FROM ";                
$sql .= "    t_contract ";

$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_contract.act_goods_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '0'";
$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '1'";
$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '2'";
$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '3'";
$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id ";

$sql .= "WHERE ";
$sql .= "    t_contract.contract_id = $get_con_id;";

$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
//$data_list = Get_Data($result);
$data_list = Get_Data($result, "5");

//行No.初期値判定
if($data_list[0][0] == NULL){
	//契約の行No.からMAX+1をフォームにセット
	$sql  = "SELECT ";
	$sql .= "    COALESCE(MAX(trust_line), 0)+1 ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    trust_id = $client_h_id;";
	$result = Db_Query($db_con, $sql);
	$line_data = Get_Data($result);
	$con_data["form_line"] = $line_data[0][0];
}else{
	$con_data["form_line"] = $data_list[0][0];   //受託先の行
}

//■代行料
//固定額
if($data_list[0][31] == "2"){
	$daiko_price = Minus_Numformat($data_list[0][34])."円<br>(固定額)";

//％
}elseif($data_list[0][31] == "3"){
	$daiko_price = Minus_Numformat($data_list[0][34])."円<br>(".$data_list[0][23]."%)";

//発生しない
}else{
	$daiko_price = "無し";
}

//順路が指定されていた場合に形式変更
if($data_list[0][1] != NULL){
	$data_list[0][1]                   = str_pad($data_list[0][1], 4, 0, STR_POS_LEFT); //順路
	$con_data["form_route_load"][1]    = substr($data_list[0][1],0,2);  
	$con_data["form_route_load"][2]    = substr($data_list[0][1],2,2);
} 

$con_data["form_c_staff_id1"]        = $data_list[0][2];  //担当者１
$con_data["form_sale_rate1"]         = ($data_list[0][3] != null)? $data_list[0][3] : '100';  //売上率１
$con_data["form_c_staff_id2"]        = $data_list[0][4];  //担当者２
$con_data["form_sale_rate2"]         = $data_list[0][5];  //売上率２
$con_data["form_c_staff_id3"]        = $data_list[0][6];  //担当者３
$con_data["form_sale_rate3"]         = $data_list[0][7];  //売上率３
$con_data["form_c_staff_id4"]        = $data_list[0][8];  //担当者４
$con_data["form_sale_rate4"]         = $data_list[0][9];  //売上率４
$con_data["form_round_div1[]"]       = $data_list[0][10]; //巡回区分
$round_div_db                        = $data_list[0][10]; //巡回区分

$contract_day                        = $data_list[0][18]; //受託日
$con_data["form_note"]               = $data_list[0][19]; //備考

$daiko_id                            = $data_list[0][22];  //受託先ID
$daiko_note                          = nl2br(htmlspecialchars($data_list[0][24]));    //受託先宛備考
//$daiko_price                         = $data_list[0][23];  //代行依頼料
$state                               = $data_list[0][30];  //代行依頼料
$request_state                       = $data_list[0][33];  //代行依頼料

if($state == "1"){
	$state_val = "取引中";
}else{
	$state_val = "解約・休止中";
}

//$con_data["daiko_check"]            = $data_list[0][21];    //契約区分
//$con_data["hdn_daiko_id"]           = $data_list[0][22];  
//$con_data["form_daiko_price"]       = $data_list[0][23];    //代行依頼料
//$con_data["form_daiko_note"]        = $data_list[0][24];    //受託先宛備考
//$con_data["hdn_act_goods_id"]       = $data_list[0][25];    //代行料の商品ID
//$con_data["form_act_goods_cd"]      = $data_list[0][26];    //代行料の商品CD
//$con_data["form_act_goods_name"]    = $data_list[0][27];    //代行料の商品名


//巡回区分判定 
if($data_list[0][10] == 1){
	//巡回１
	$con_data["form_abcd_week1"]      = $data_list[0][14];  //週名（ABCD）
	$con_data["form_week_rday1"]      = $data_list[0][16];  //指定曜日

}else if($data_list[0][10] == 2){
	//巡回２
	$con_data["form_rday2"]           = $data_list[0][15];  //指定日

}else if($data_list[0][10] == 3){
	//巡回３
	$con_data["form_cale_week3"]      = $data_list[0][13];  //週名（１〜４）
	$con_data["form_week_rday3"]      = $data_list[0][16];  //指定曜日

}else if($data_list[0][10] == 4){
	//巡回４
	$con_data["form_cale_week4"]      = $data_list[0][11];  //周期
	//曜日形式変更
	switch($data_list[0][16]){
		case '1':
			$data_list[0][16] = '月';
			break;
		case '2':
			$data_list[0][16] = '火';
			break;
		case '3':
			$data_list[0][16] = '水';
			break;
		case '4':
			$data_list[0][16] = '木';
			break;
		case '5':
			$data_list[0][16] = '金';
			break;
		case '6':
			$data_list[0][16] = '土';
			break;
		case '7':
			$data_list[0][16] = '日';
			break;
	}
	$con_data["form_week_rday4"]      = $data_list[0][16];  //指定曜日

}else if($data_list[0][10] == 5){
	//巡回５
	$con_data["form_cale_month5"]     = $data_list[0][11];  //周期
	$con_data["form_week_rday5"]      = $data_list[0][15];  //指定日

}else if($data_list[0][10] == 6){
	//巡回６
	$con_data["form_cale_month6"]     = $data_list[0][11];  //周期
	$con_data["form_cale_week6"]      = $data_list[0][13];  //週名（１〜４）
	$con_data["form_week_rday6"]      = $data_list[0][16];  //指定曜日

//}else if($data_list[0][10] == 7 && $c_check != true){
}else if($data_list[0][10] == 7){
	//巡回７(＊変則日画面から遷移してきたときは、入力値を優先する為以下の処理は行わない)
	
	$sql  = "SELECT ";
	$sql .= "    round_day ";                //巡回日
	$sql .= "FROM ";
	$sql .= "    t_round ";
	$sql .= "WHERE ";
	$sql .= "    contract_id = $get_con_id;";
	$result = Db_Query($db_con, $sql);
	$round_data = Get_Data($result);
	//登録された巡回日分hiddenを作成し、値を復元
	for($i=0;$i<count($round_data);$i++){
		$year = (int) substr($round_data[$i][0],0,4);
		$month = (int) substr($round_data[$i][0],5,2);
		$day = (int) substr($round_data[$i][0],8,2);
		
		$input_date = "check_".$year."-".$month."-".$day;
		//値を復元する為に変則日のチェックをhiddenで作成
		$form->addElement("hidden","$input_date","");
		//値のセット
		$con_data["$input_date"] = 1;
	}

	$last_day = $data_list[0][20];  //巡回日の最終日

}



$stand_ymd = explode('-',$data_list[0][17]);             //基準日
$con_data["form_stand_day"]["y"] = $stand_ymd[0];
$con_data["form_stand_day"]["m"] = $stand_ymd[1];
$con_data["form_stand_day"]["d"] = $stand_ymd[2];

//$update_day = $data_list[0][28];
$update_ymd = explode('-',$data_list[0][28]);                  //修正有効日
$con_data["form_update_day"]["y"] = $update_ymd[0];
$con_data["form_update_day"]["m"] = $update_ymd[1];
$con_data["form_update_day"]["d"] = $update_ymd[2];

//$contract_eday = $data_list[0][29];
$contract_ymd = explode('-',$data_list[0][29]);                  //契約終了日
$con_data["form_contract_eday"]["y"] = $contract_ymd[0];
$con_data["form_contract_eday"]["m"] = $contract_ymd[1];
$con_data["form_contract_eday"]["d"] = $contract_ymd[2];


/****************************/
//契約内容テーブル
/****************************/
$sql  = "SELECT ";
$sql .= "    t_con_info.line,";                  //行数0
$sql .= "    t_con_info.divide, ";               //販売区分1
$sql .= "    t_con_info.serv_pflg,";             //サービス印字フラグ2
$sql .= "    t_con_info.serv_id,";               //サービスID3

$sql .= "    t_con_info.goods_pflg,";            //アイテム印字フラグ4
$sql .= "    t_con_info.goods_id,";              //アイテムID5
$sql .= "    t_item.goods_cd,";                  //アイテムCD6
$sql .= "    t_item.name_change,";               //アイテム品名変更7
$sql .= "    t_con_info.goods_name,";            //アイテム名（略称）8
$sql .= "    t_con_info.num,";                   //アイテム数9

$sql .= "    t_con_info.set_flg,";               //一式フラグ10
$sql .= "    t_con_info.trust_cost_price,";     //営業原価11
$sql .= "    t_con_info.sale_price,";            //売上単価12
//$sql .= "    t_con_info.trust_trade_amount,";    //営業金額13   
$sql .= "    t_con_info.trust_cost_amount,";    //営業金額13   
$sql .= "    t_con_info.sale_amount,";           //売上金額14  

$sql .= "    t_con_info.rgoods_id,";             //本体ID15
$sql .= "    t_body.goods_cd,";                  //本体CD16
$sql .= "    t_body.name_change,";               //本体品名変更17
$sql .= "    t_con_info.rgoods_name,";           //本体名18
$sql .= "    t_con_info.rgoods_num,";            //本体数19

$sql .= "    t_con_info.egoods_id,";             //消耗品ID20
$sql .= "    t_expend.goods_cd,";                //消耗品CD21
$sql .= "    t_expend.name_change,";             //消耗品品名変更22
$sql .= "    t_con_info.egoods_name,";           //消耗品名23
$sql .= "    t_con_info.egoods_num,";            //消耗品数24

$sql .= "    t_con_info.account_price,";         //口座単価25
$sql .= "    t_con_info.account_rate, ";         //口座率26
$sql .= "    t_con_info.con_info_id, ";          //契約内容ID27
$sql .= "    t_con_info.official_goods_name, ";  //アイテム名（正式）28
$sql .= "    t_con_info.trust_mst_sync_flg, ";    //（受託先用）マスタ同期フラグ29

#2009-09-22 hashimoto-y
$sql .= "    t_item.discount_flg ";                  //値引きフラグ30

$sql .= "FROM ";
$sql .= "    t_con_info ";
$sql .= "    LEFT JOIN t_goods AS t_item ON t_item.goods_id = t_con_info.goods_id ";
$sql .= "    LEFT JOIN t_goods AS t_body ON t_body.goods_id = t_con_info.rgoods_id ";
$sql .= "    LEFT JOIN t_goods AS t_expend ON t_expend.goods_id = t_con_info.egoods_id ";

$sql .= "WHERE ";
$sql .= "    contract_id = $get_con_id; ";
$result = Db_Query($db_con, $sql);
$sub_data = Get_Data($result);

//入力商品行数
$input_row = NULL;
$input_row2 = NULL;

$break_part_flg = false;       //内訳データ存在判定フラグ

//契約IDに該当するデータが存在するか
for($s=0;$s<count($sub_data);$s++){
	$search_line = $sub_data[$s][0];   //復元する行
	$input_row[] = $search_line;       //更新する行

	//口座区分の初期値に設定しない行配列
	$aprice_array[] = $search_line;

	//$con_data["form_divide"][$search_line]                = $sub_data[$s][1];   //販売区分
	$form_divide[$search_line]                = $sub_data[$s][1];   //販売区分


	//チェック付けるか判定
	if($sub_data[$s][2] == 't'){
		$print_flg[1][$search_line]   = "○";    //サービス印字フラグ

	}else{
		$print_flg[1][$search_line]   = "×";
	}
	$con_data["form_serv"][$search_line]                  = $sub_data[$s][3];    //サービス

	//チェック付けるか判定
	if($sub_data[$s][4] == 't'){
		$print_flg[2][$search_line]   = "○";    //アイテム伝票印字フラグ
	}else{
		$print_flg[2][$search_line]   = "×";
	}
	
	$con_data["hdn_goods_id1"][$search_line]              = $sub_data[$s][5];    //アイテムID
	$goods_cd[1][$search_line]                            = $sub_data[$s][6];    //アイテムCD
	$goods_name[1][$search_line]                          = $sub_data[$s][8];    //アイテム名（略称）
	$official_goods_name[$search_line]                    = $sub_data[$s][28];   //アイテム名（正式）
	$con_data["form_goods_num1"][$search_line]            = $sub_data[$s][9];    //アイテム数


	//チェック付けるか判定
	if($sub_data[$s][10] == 't'){
		$con_data2["form_issiki"][$search_line]       = "一式";                   //一式フラグ
		//$issiki[$search_line]       = "一式";                   //一式フラグ
	}

	//改行判定
	if($sub_data[$s][9] != NULL && $sub_data[$s][10] == 't'){
		//数量と一式の場合は、間に改行をいれる
		$br_flg = 'true';
	}

	//受託前の営業単価は商品マスタを参照
	if($request_state == "1"){
		//営業原価
		$cost_price = Get_Goods_Price($db_con,$sub_data[$s][5]);
		$c_price = explode('.', $cost_price);                                //売上単価
		$con_data["form_trade_price"][$search_line]["1"] = $c_price[0];  
		$con_data["form_trade_price"][$search_line]["2"] = $c_price[1];
	
		$c_price = bcmul($cost_price, $sub_data[$s][9],2);
		$c_price = Coax_Col($coax, $c_price);
		$con_data["form_trade_amount"][$search_line]  = number_format($c_price);  //営業金額

	//受託済の場合は登録済データを表示
	}else{
		$cost_price = explode('.', $sub_data[$s][11]);                                //営業原価
		$con_data["form_trade_price"][$search_line]["1"] = $cost_price[0];  
		$con_data["form_trade_price"][$search_line]["2"] = $cost_price[1];  
		//$con_data["form_trade_price"][$search_line]["2"] = ($cost_price[1] != null)? $cost_price[1] : ($cost_price[0] != null)? '00' : '';    
		//営業金額指定判定
		if($sub_data[$s][13] != NULL){
			$con_data["form_trade_amount"][$search_line]    = number_format($sub_data[$s][13]);  //営業金額
		}

	}

	//売上単価	
	$sale_price_db = explode('.', $sub_data[$s][12]);                            
	$sale_price_int           = number_format($sale_price_db[0]);  
	$sale_price_decimal       = ($sale_price_db[1] != null)? $sale_price_db[1] : '00';	
	$sale_price[$search_line] = $sale_price_int.".".$sale_price_decimal;

	//売上金額
	$sale_amount[$search_line]     = number_format($sub_data[$s][14]);

	$con_data["hdn_goods_id2"][$search_line]              = $sub_data[$s][15];    //本体ID
	$goods_cd[2][$search_line]             = $sub_data[$s][16];    //本体CD
	$goods_name[2][$search_line]           = $sub_data[$s][18];    //本体名
	$goods_num[2][$search_line]            = $sub_data[$s][19];    //本体数


	$con_data["hdn_goods_id3"][$search_line]              = $sub_data[$s][20];    //消耗品ID
	$goods_cd[3][$search_line]             = $sub_data[$s][21];    //消耗品CD
	$goods_name[3][$search_line]           = $sub_data[$s][23];    //消耗品名
	$goods_num[3][$search_line]            = $sub_data[$s][24];    //消耗品数

	$mst_sync_data["mst_sync_flg"][$search_line] = ($sub_data[$s][29] == "t") ? "1" : "";   //（受託先）マスタ同期フラグ

    #2009-09-22 hashimoto-y
    $con_data["hdn_discount_flg"][$search_line]           = $sub_data[$s][30];    //値引きフラグ

}
$form->setDefaults($con_data);

/****************************/
//得意先情報取得
/****************************/
//東陽のclient_idを取得（各ショップの得意先マスタに自動で登録されるやつ）
$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
$result = Db_Query($db_con, $sql);
$toyo_id = pg_fetch_result($result, 0, 0);
//丸め区分取得
$sql  = "SELECT ";
$sql .= "   t_client.coax ";    
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $toyo_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);
$coax = $data_list[0][0];        //丸め区分（商品）

//得意先の情報を抽出
$sql  = "SELECT";
$sql .= "   t_client.client_cname,";
$sql .= "   t_client.intro_ac_name,";
$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
$sql .= "   t_client.trade_id,";
$sql .= "   t_client.tax_franct,";
$sql .= "   t_client.client_cd1, ";
$sql .= "   t_client.client_cd2,";
$sql .= "   t_client.d_staff_id1,";
$sql .= "   t_client.d_staff_id2,";
$sql .= "   t_client.d_staff_id3 ";
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= "   LEFT JOIN t_client_info ON t_client.client_id = t_client_info.client_id ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $client_id";
$sql .= ";";

$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
$data_list = Get_Data($result);

$cname           = $data_list[0][0];        //顧客名
//$ac_name         = $data_list[0][1];        //紹介口座先
$client_cd       = $data_list[0][2];        //得意先CD
$trade_id        = $data_list[0][3];        //取引コード
$tax_franct      = $data_list[0][4];        //消費税（端数区分）
$client_cd1      = $data_list[0][5];        //得意先CD1
$client_cd2      = $data_list[0][6];        //得意先CD2
$staff1          = $data_list[0][7];        //巡回担当者１
$staff2          = $data_list[0][8];        //巡回担当者２
$staff3          = $data_list[0][9];       //巡回担当者３
//$form_client = $client_cd1."-".$client_cd2." ".htmlspecialchars($cname); //得意先名
$form_client = $client_cd1."-".$client_cd2." ".$cname; //得意先名

//POST情報変更
//$con_data2["hdn_coax"]            = $coax;
$con_data2["client_search_flg"]   = "";
//$con_data2["form_client"]["cd1"]  = $client_cd1;
//$con_data2["form_client"]["cd2"]  = $client_cd2;
//$con_data2["form_client"]["name"] = $cname;


/****************************/
//取引区分が無い場合エラー表示（後でこの処理は削除）
/****************************/
if($trade_id == NULL){
	$trade_error_flg = true;
}


//変則日画面から遷移 or 得意先選択後に画面更新
if( $c_check == true || $_POST[renew_flg] == "1" ){

	//基準日
	$y_day = str_pad($_POST["form_stand_day"]["y"],4,0,STR_PAD_LEFT);
	$m_day = str_pad($_POST["form_stand_day"]["m"],2,0,STR_PAD_LEFT);
	$d_day = str_pad($_POST["form_stand_day"]["d"],2,0,STR_PAD_LEFT);
	$stand_day = $y_day."-".$m_day."-".$d_day;    //作業基準日

	//修正有効日を結合
	if($_POST["form_update_day"]["y"] !="" && $_POST["form_update_day"]["m"]!="" && $_POST["form_update_day"]["d"]!="" ){
		$update_ymd[0] = str_pad($_POST["form_update_day"]["y"],4,0,STR_PAD_LEFT);
		$update_ymd[1] = str_pad($_POST["form_update_day"]["m"],2,0,STR_PAD_LEFT);
		$update_ymd[2] = str_pad($_POST["form_update_day"]["d"],2,0,STR_PAD_LEFT);
		$update_day = $update_ymd[0]."-".$update_ymd[1]."-".$update_ymd[2]; 
	}

	//契約終了日を結合
	if($_POST["form_contract_eday"]["y"] !="" && $_POST["form_contract_eday"]["m"]!="" && $_POST["form_contract_eday"]["d"]!="" ){
		$contract_ymd[0] = str_pad($_POST["form_contract_eday"]["y"],4,0,STR_PAD_LEFT);
		$contract_ymd[1] = str_pad($_POST["form_contract_eday"]["m"],2,0,STR_PAD_LEFT);
		$contract_ymd[2] = str_pad($_POST["form_contract_eday"]["d"],2,0,STR_PAD_LEFT);
		$contract_eday = $contract_ymd[0]."-".$contract_ymd[1]."-".$contract_ymd[2];
	}

}

/****************************/
//クリアボタン押下処理
/****************************/
if($_POST["clear_flg"] == true){
	//商品欄を全て初期化
	for($c=1;$c<=5;$c++){
		$con_data2["form_trade_price"][$c]["1"] = "";
		$con_data2["form_trade_price"][$c]["2"] = "";
		$con_data2["form_trade_amount"][$c]     = "";

        $con_data2["mst_sync_flg"][$c]          = "";
	}
	
	$post_flg2 = true;                //口座区分を、初期化するフラグ
	$con_data2["clear_flg"] = "";    //クリアボタン押下フラグ
}

/****************************/
//POSTデータ取得
/****************************/
$line  = $_POST["form_line"];            //行No

$trade_amount = NULL;                    //営業金額初期化
//$sale_amount = NULL;                     //売上金額初期化

//5行分取得
for($s=1;$s<=5;$s++){

	//$divide[$s]  = $_POST["form_divide"][$s];        //販売区分
	$serv_id[$s] = $_POST["form_serv"][$s];          //サービスID

	$set_flg[$s] = $_POST["form_issiki"][$s];        //一式フラグ1
	if($set_flg[$s] == NULL){
		$set_flg[$s] = 'false';
	}else{
		$set_flg[$s] = 'true';
	}

	//営業原価
	$t_price1 = $_POST["form_trade_price"][$s][1]; 
	$t_price2 = $_POST["form_trade_price"][$s][2];
	$trade_price[$s] = $t_price1.".".$t_price2;

	//売上単価
	//$s_price1 = $_POST["form_sale_price"][$s][1]; 
	//$s_price2 = $_POST["form_sale_price"][$s][2]; 
	//$sale_price[$s] = $s_price1.".".$s_price2;

	//金額計算処理判定
	if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] != null){
	//一式○　数量○の場合、営業金額は、単価×数量。売上金額は、単価×１
		//営業金額
		$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//売上金額
		//$sale_amount[$s] = bcmul($sale_price[$s], 1,2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	
	//一式○　数量×の場合、単価×１
	}else if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] == null){
		//営業金額
		$trade_amount[$s] = bcmul($trade_price[$s], 1,2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//売上金額
		//$sale_amount[$s] = bcmul($sale_price[$s], 1,2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	
	//一式×　数量○の場合、単価×数量
	}else if($set_flg[$s] == 'false' && $_POST["form_goods_num1"][$s] != null){
		//営業金額
		$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//売上金額
		//$sale_amount[$s] = bcmul($sale_price[$s], $_POST["form_goods_num1"][$s],2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	}

	$trust_trade_amount = $trust_trade_amount+$trade_amount[$s];


    //マスタ同期フラグ
    $trust_mst_sync_flg[$s] = ($_POST["mst_sync_flg"][$s] != null) ? "true" : "false";
    $mst_sync_data2[$s]     = ($_POST["mst_sync_flg"][$s] != null) ? "1" : "";

}

$route  = $_POST["form_route_load"][1];      //順路
$route .= $_POST["form_route_load"][2];

//巡回担当チーム
$staff_check = NULL;                            //重複判定配列
$staff_rate = NULL;                             //売上率登録用配列

$staff1         = $_POST["form_c_staff_id1"];   //巡回担当１
$staff_check[0] = $staff1;
$rate1          = $_POST["form_sale_rate1"];    //売上率１
$staff_rate[0]  = $rate1;

$staff2 = $_POST["form_c_staff_id2"];           //巡回担当２
//入力値がある場合に重複判定配列に代入
if($staff2 != NULL){
	$staff_check[1] = $staff2;
}
$rate2 = $_POST["form_sale_rate2"];             //売上率２
$staff_rate[1] = $rate2;

$staff3 = $_POST["form_c_staff_id3"];           //巡回担当３
//入力値がある場合に重複判定配列に代入
if($staff3 != NULL){
	$staff_check[2] = $staff3;
}
$rate3 = $_POST["form_sale_rate3"];          //売上率３
$staff_rate[2] = $rate3;

$staff4 = $_POST["form_c_staff_id4"];        //巡回担当４
//入力値がある場合に重複判定配列に代入
if($staff4 != NULL){
	$staff_check[3] = $staff4;
}
$rate4 = $_POST["form_sale_rate4"];          //売上率４
$staff_rate[3] = $rate4;

$note = $_POST["form_note"];                 //備考


//巡回日データ取得
//顧客先が変更された場合、初期化する為に復元しない
$round_div = $_POST["form_round_div1"][0][0];     //巡回区分

//巡回区分判定 
if($round_div == 1){
	//巡回１
	$abcd_week = $_POST["form_abcd_week1"];       //週名（ABCD）
	$week_rday = $_POST["form_week_rday1"];       //指定曜日

}else if($round_div == 2){
	//巡回２
	$rday = $_POST["form_rday2"];                 //指定日

}else if($round_div == 3){
	//巡回３
	$cale_week = $_POST["form_cale_week3"];       //週名（１〜４）
	$week_rday = $_POST["form_week_rday3"];       //指定曜日

}else if($round_div == 4){
	//巡回４
	$cycle_unit = "W";    //周期単位
	$cycle      = $_POST["form_cale_week4"];      //周期
	$week_rday  = $_POST["form_week_rday4"];      //指定曜日
	//曜日形式変更
	switch($week_rday){
		case '月':
			$week_rday = 1;
			break;
		case '火':
			$week_rday = 2;
			break;
		case '水':
			$week_rday = 3;
			break;
		case '木':
			$week_rday = 4;
			break;
		case '金':
			$week_rday = 5;
			break;
		case '土':
			$week_rday = 6;
			break;
		case '日':
			$week_rday = 7;
			break;
	}

}else if($round_div == 5){
	//巡回５
	$cycle_unit = "M";   //周期単位
	$cycle      = $_POST["form_cale_month5"];     //周期
	$rday       = $_POST["form_week_rday5"];      //指定日

}else if($round_div == 6){
	//巡回６
	$cycle_unit = "M";   //周期単位
	$cycle      = $_POST["form_cale_month6"];     //周期
	$cale_week  = $_POST["form_cale_week6"];      //週名（１〜４）
	$week_rday  = $_POST["form_week_rday6"];      //指定曜日

}


//5行分取得
for($s=1;$s<=5;$s++){
	//★契約アイテム
	$goods_item_id[$s] = $_POST["hdn_goods_id1"][$s];                   //商品ID
	//指定判定
	if($goods_item_id[$s] != NULL){

		//$goods_item_name[$s] = $_POST["form_goods_name1"][$s];          //商品名
		//$goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //数量
		//$goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //伝票印字フラグ
		if($goods_item_flg[$s] == NULL){
			$goods_item_flg[$s] = 'false';
		}else{
			$goods_item_flg[$s] = 'true';
		}

		$sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$s].";";
		$result = Db_Query($db_con, $sql);
		$goods_item_com[$s] = pg_fetch_result($result,0,0);          //構成品フラグ

		//構成品判定
		if($goods_item_com[$s] == 'f'){
			//構成品では無い場合、納品フラグをfalse
			$goods_item_deli[$s] = 'false';
		}else{
			//各構成品の商品情報取得
			$sql  = "SELECT ";
			$sql .= "    parts_goods_id ";                       //構成品ID
			$sql .= "FROM ";
			$sql .= "    t_compose ";
			$sql .= "WHERE ";
			$sql .= "    goods_id = ".$goods_item_id[$s].";";
			$result = Db_Query($db_con, $sql);
			$item_parts[$s] = Get_Data($result);

			//各構成品の数量取得
			for($i=0;$i<count($item_parts[$s]);$i++){
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_name,";
				$sql .= "    t_goods.goods_cname,";
				$sql .= "    t_compose.count ";
				$sql .= "FROM ";
				$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
				$sql .= "WHERE ";
				$sql .= "    t_compose.goods_id = ".$goods_item_id[$s]." ";
				$sql .= "AND ";
				$sql .= "    t_compose.parts_goods_id = ".$item_parts[$s][$i][0].";";
				$result = Db_Query($db_con, $sql);
				$item_parts_name[$s][$i] = pg_fetch_result($result,0,0);    //商品名
				$item_parts_cname[$s][$i] = pg_fetch_result($result,0,1);   //略称
				$parts_num = pg_fetch_result($result,0,2);                  //構成品に対する数量
				$item_parts_num[$s][$i] = $parts_num * $goods_item_num[$s]; //数量
			}
		}
	}
}

/****************************/
//部品定義
/****************************/
//「フォーカスで色変更」＋「半角英数右寄せ」
$form_option_num = $g_form_option." style=\"ime-mode:disabled;text-align:right;\"";

//受託料
$form->addElement("static","form_daiko_price","受託料","$daiko_price");

//契約状態
$form->addElement("static","state","契約状態","$state_val");

//顧客名
$form->addElement("static","form_client","顧客名","$form_client");

//受託日
$form->addElement("static","form_contract_day","受託日","$contract_day");

//受託先宛備考
$form->addElement("static","form_daiko_note","受託先宛備考","$daiko_note");


//NO
$form->addElement("text","form_line","テキストフォーム",'size="3" maxLength="3" '.$form_option_num);

//巡回担当
$form_c_staff_id = Select_Get($db_con,'round_staff_m');
$form->addElement('select', 'form_c_staff_id1', 'セレクトボックス', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id2', 'セレクトボックス', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id3', 'セレクトボックス', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id4', 'セレクトボックス', $form_c_staff_id, $g_form_option_select);


//売上
$form->addElement("text","form_sale_rate1","テキストフォーム",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate2","テキストフォーム",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate3","テキストフォーム",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate4","テキストフォーム",'size="3" maxLength="3"'.$form_option_num);

//順路
$form_route[] =& $form->createElement("text","1","テキストフォーム",'style="ime-mode:disabled;" size="1" maxLength="2" onkeyup="changeText(this.form,\'form_route_load[1]\',\'form_route_load[2]\',2)" '.$g_form_option);
$form_route[] =& $form->createElement("text","2","テキストフォーム",'style="ime-mode:disabled;" size="1" maxLength="2" '.$g_form_option);
$form->addGroup( $form_route,"form_route_load","form_route_load","-");

//備考
$form->addElement("textarea","form_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);

//画面更新フラグ
$form->addElement("hidden","renew_flg","1"); 

//代行画面フラグ（変則日ウインドウで遷移先を制御するために使用）
$form->addElement("hidden","daiko_page_flg","1"); 

$num = 5;
#2009-09-22 hashimoto-y
for($i = 0; $i < $num; $i++){
    $form->addElement("hidden","hdn_discount_flg[$i]");
}



/**************************************************
巡回商品
**************************************************/
$num = 5;
$type = $g_form_option;
$array_divide = Select_Get($db_con, "divide_con");
for ($i=1; $i<=$num; $i++){


    #2009-09-22 hashimoto-y
    //値引商品を選択した場合には赤字に変更
    $font_color = "";

    if($con_data["hdn_discount_flg"][$i] === 't'){
        $font_color = "color: red; ";
    //$set_goods_dataが空でPOSTが有る場合は商品コードの変更はされていない
    }elseif( $con_data["form_goods_cd"][$i] == "" && $_POST["hdn_discount_flg"][$i] === 't'
    ){
        $font_color = "color: red; ";

    }else{
        $font_color = "color: #000000; ";
    }


	//販売区分
	$divide_value = $form_divide[$i];
	$form->addElement('static', "form_divide[".$i."]", "", $array_divide[$divide_value]);
	
	//サービス
	$array_serv = Select_Get($db_con, "serv_con");
	$freeze_data2 = $form->addElement('select', "form_serv[".$i."]", "", $array_serv, $g_form_option_select);
	$freeze_data2->freeze();

	//一式
	//$form->addElement('static', "form_issiki[".$i."]", "", $array_divide[$divide_value]);
	$freeze_data2 = $form->addElement( "text","form_issiki[".$i."]" ,"" ,"");
	$freeze_data2->freeze();


	for($s=1;$s<=3;$s++){

		//伝票印字
		$form->addElement("static","form_print_flg".$s."[$i]","商品名",$print_flg[$s][$i]);

		//商品コード      
		$form->addElement("static","form_goods_cd".$s."[$i]","商品コード",$goods_cd[$s][$i]);
		//商品名
		$form->addElement("static","form_goods_name".$s."[$i]","商品名（略称）",$goods_name[$s][$i]);
		$form->addElement("static","official_goods_name"."[$i]","商品名（正式）",$official_goods_name[$i]);

		//商品数（アイテムの場合）
		if($s == "1"){
			$form->addElement(
		        "text","form_goods_num".$s."[$i]","",
		        " size=\"3\" maxLength=\"3\" class=\"money_num\" 
			    style=\"$font_color 
				border : #ffffff 1px solid; 
				background-color: #ffffff; 
				text-align: right\" readonly'"
		    );

		//消耗品・本体商品の場合
		}else{
			$form->addElement("static","form_goods_num".$s."[$i]","数量",$goods_num[$s][$i]);
		}

		//商品ID
		$form->addElement("hidden","hdn_goods_id".$s."[$i]");
		//品名変更フラグ
		//$form->addElement("hidden","hdn_name_change".$s."[$i]");

	}

	//営業原価
	$form_cost_price[$i][] =& $form->createElement(
	        "text","1","",
	        "size=\"9\" maxLength=\"8\"
	        class=\"money\"
	        onKeyup=\"Mult2('form_goods_num1[$i]','form_trade_price[$i][1]','form_trade_price[$i][2]','form_trade_amount[$i]','form_issiki[$i]','$coax',false);\"
	        style=\"$font_color $g_form_style;text-align: right; $style\"
	        $type"
	    );
	    $form_cost_price[$i][] =& $form->createElement(
	        "text","2","","size=\"1\" maxLength=\"2\" 
	        onKeyup=\"Mult2('form_goods_num1[$i]','form_trade_price[$i][1]','form_trade_price[$i][2]','form_trade_amount[$i]','form_issiki[$i]','$coax',true);\"
	        style=\"$font_color $g_form_style;text-align: left; $style\"
	        $type"
	    );
    $form->addGroup( $form_cost_price[$i], "form_trade_price[$i]", "",".");

	//原価合計額
    $form->addElement(
        "text","form_trade_amount[$i]","",
        "size=\"17\" maxLength=\"10\" 
        style=\"$font_color 
        border : #ffffff 1px solid; 
        background-color: #ffffff; 
        text-align: right\" readonly'"
    );

	//売上単価
	$form->addElement('static', "form_sale_price[".$i."]", "", $sale_price[$i] );

	//売上合計額
	$form->addElement('static', "form_sale_amount[".$i."]", "", $sale_amount[$i]);

    //マスタとの同期
    $form->addElement("checkbox", "mst_sync_flg[".$i."]");

}
$freeze_list = $form->addGroup($freeze_data,"freeze_list", "");
$freeze_list->freeze();

/**************************************************
巡回日
**************************************************/
//セレクトボックス用
//ABCD週
$array_abcd_week = array(
	"" => "",
	"1" => "A　(4週間隔)",
	"2" => "B　(4週間隔)",
	"3" => "C　(4週間隔)",
	"4" => "D　(4週間隔)",
	"5" => "A , C　(2週間隔)",
	"6" => "B , D　(2週間隔)",
	"21" => "A　(8週間隔)",
	"22" => "B　(8週間隔)",
	"23" => "C　(8週間隔)",
	"24" => "D　(8週間隔)",
	
);

//普通の週
$array_week = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4"
);

//○週間周期
$array_while_week = array(
	""   => "",
	"1"  => "1",
	"2"  => "2",
	"3"  => "3",
	"4"  => "4",
	"5"  => "5",
	"6"  => "6",
	"7"  => "7",
	"8"  => "8",
	"9"  => "9",
	"12" => "12",
	"18" => "18",
	"24" => "24"
);

//52週間周期
$array_while_week2[""] = "";
for($w=1;$w<=52;$w++){
	$array_while_week2["$w"] = $w;
}

//1〜29日＋月末
$array_week_interval[0] = "";
for($i=1;$i<29;$i++){
	$array_week_interval[$i] = $i;
}
$array_week_interval[30] = '月末';


//曜日
$array_week_rday = array(
	"" => "",
	"1" => "月",
	"2" => "火",
	"3" => "水",
	"4" => "木",
	"5" => "金",
	"6" => "土",
	"7" => "日"
);


$need_mark = "<b><font color=\"#ff0000\">※</font></b>";
$readonly = "style=\"border : #ffffff 1px solid; background-color: #ffffff;\" readonly";

//javascript(日付に合わせて曜日を表示する)
$option =" onkeyup=\"date_week(this.form,'form_update_day[y]','form_update_day[m]','form_update_day[d]','form_week_rday4')\"";
$option.=" onClick=\"date_week(this.form,'form_update_day[y]','form_update_day[m]','form_update_day[d]','form_week_rday4')\"";

//契約発効日
Addelement_Date($form,"form_stand_day","契約発効日<b>　</b>","-","y","m","d","$readonly");
//修正発効日
Addelement_Date($form,"form_update_day","修正発効日".$need_mark,"-","y","m","d","$option");

//契約終了日
Addelement_Date($form,"form_contract_eday","契約終了日<b>　</b>","-");

//巡回日(1)
$form->addElement('select', 'form_abcd_week1', 'セレクトボックス', $array_abcd_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday1', 'セレクトボックス', $array_week_rday, $g_form_option_select);

//巡回日(2)
$form->addElement('select', 'form_rday2', 'セレクトボックス', $array_week_interval, $g_form_option_select);

//巡回日(3)
$form->addElement('select', 'form_cale_week3', 'セレクトボックス', $array_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday3', 'セレクトボックス', $array_week_rday, $g_form_option_select);

//巡回日(4)
$form->addElement('select', 'form_cale_week4', 'セレクトボックス', $array_while_week2, $g_form_option_select);
$form->addElement("text","form_week_rday4","テキストフォーム",'size="1" maxLength="2" class="Textbox_readonly" readonly');

//巡回日(5)
$form->addElement('select', 'form_cale_month5', 'セレクトボックス', $array_while_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday5', 'セレクトボックス', $array_week_interval, $g_form_option_select);

//巡回日(6)
$form->addElement('select', 'form_cale_month6', 'セレクトボックス', $array_while_week, $g_form_option_select);
$form->addElement('select', 'form_cale_week6', 'セレクトボックス', $array_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday6', 'セレクトボックス', $array_week_rday, $g_form_option_select);

//巡回日(7)
$form->addElement(
    "link","form_irr_day","","#","変則日",
	"onClick=\"javascript:return Submit_Page2('./2-1-105.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id'); \""
);


//巡回日ラジオボタン
for($i=0;$i<7;++$i){
	$form_round_div1 = "";
	$r_value = $i+1;
	$form_round_div1[] =& $form->createElement("radio", NULL,NULL, "($r_value)", $r_value,"onClick=\"return Check_read('$r_value');\"");
	$form->addGroup($form_round_div1, "form_round_div1[]");
}

/****************************/
//変則日データ取得
/****************************/
$date_array = NULL;
//POSTデータ取得処理
$year  = date("Y");
$month = date("m");

for($i=0;$i<28;$i++){
	//月の日数取得
	$now = mktime(0, 0, 0, $month+$i,1,$year);
	$num = date("t",$now);

	//2年分データ取得
	for($s=1;$s<=$num;$s++){
		$now = mktime(0, 0, 0, $month+$i,$s,$year);
		$syear  = (int) date("Y",$now);
		$smonth = (int) date("n",$now);
		$sday   = (int) date("d",$now);
		$input_date = "check_".$syear."-".$smonth."-".$sday;

		//チェックされた日付だけを取得
		if($_POST["$input_date"] != NULL){
			$smonth = str_pad($smonth,2, 0, STR_POS_LEFT);
			$sday = str_pad($sday,2, 0, STR_POS_LEFT);
			$date_array[] = $syear."-".$smonth."-".$sday;
			
			//値を復元する為に変則日のチェックをhiddenで作成
			$form->addElement("hidden","$input_date","");
			//POSTの最終日を優先するフラグ
			$last_flg = true;
		}
	}
}
//画面にチェックを付けた最後の日を表示
if($last_flg == true){
	$last_day = $date_array[count($date_array)-1];
}

$form->addElement("button","entry_button","登　録","onClick=\"return Dialogue_2('登録します。','2-1-240.php?client_id=$client_id',true,'entry_flg');\" $disabled");
$form->addElement("button","form_back","戻　る","onClick=\"location.href='./2-1-239.php'\"");
$form->addElement("button","clear_button","クリア","onClick=\"insert_row('clear_flg');\"");

$form->addElement("hidden", "entry_flg");           //登録ボタン押下フラグ    
$form->addElement("hidden", "hdn_con_id");          //契約情報ID
$form->addElement("hidden", "hdn_client_id");       //得意先
$form->addElement("hidden", "clear_flg");           //クリア判定フラグ
$form->addElement("hidden", "duplicat_ok");         //重複伝票OK

//以下は画面に表示しない（エラー表示のために作成）
$form->addElement("text","sale_rate_sum","");
$form->addElement("text","staff_uniq","");
//$form->addElement("text","goods_enter","");
$form->addElement("text","hensoku_err","");


/****************************/
//契約マスタ登録
/****************************/
if($_POST["entry_flg"] == true){

	/****************************/
	//エラーチェック(addRule)
	/****************************/
	//巡回担当（メイン）
	$form->addRule('form_c_staff_id1',$h_mess[8],'required');
	$form->addRule('form_sale_rate1',$h_mess[8],'required');
	
	//サブ１
	//●担当者と売上率が両方入力されているか
	if($staff2 == NULL && $rate2 != NULL){
		$form->addRule('form_c_staff_id2',$h_mess[9],'required');
	}
	if($staff2 != NULL && $rate2 == NULL && ((int)$rate1 + (int)$rate3 + (int)$rate4) != 100){
		$form->addRule('form_sale_rate2',$h_mess[9],'required');
	}
	
	//サブ２
	//●担当者と売上率が両方入力されているか
	if($staff3 == NULL && $rate3 != NULL){
		$form->addRule('form_c_staff_id3',$h_mess[10],'required');
	}
	if($staff3 != NULL && $rate3 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate4) != 100){
		$form->addRule('form_sale_rate3',$h_mess[10],'required');
	}
	
	//サブ３
	//●担当者と売上率が両方入力されているか
	if($staff4 == NULL && $rate4 != NULL){
		$form->addRule('form_c_staff_id4',$h_mess[11],'required');
	}
	if($staff4 != NULL && $rate4 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate3) != 100){
		$form->addRule('form_sale_rate4',$h_mess[11],'required');
	}
	
	//順路(必須＋半角英数)
	$form->addGroupRule("form_route_load", $h_mess[18],"required");
	$form->addGroupRule("form_route_load", $h_mess[18],"numeric");
	
	for($n=0;$n<count($input_row);$n++){
	
		//営業原価(必須＋半角英数)
		$form->addGroupRule("form_trade_price[$input_row[$n]]", $d_mess[5][$input_row[$n]], "required");
		$form->addGroupRule("form_trade_price[$input_row[$n]]", $d_mess[5][$input_row[$n]], "numeric");
	
		/*
		$form->addGroupRule("form_trade_price[$input_row[$n]]", array(
			'1' => array(
		            array($d_mess[5][$input_row[$n]], 'required'),
					array($d_mess[5][$input_row[$n]], 'numeric')
		    ),      
		    '2' => array(
		            array($d_mess[5][$input_row[$n]],'required'),
					array($d_mess[5][$input_row[$n]], 'numeric')
		    ),             
		));
		*/
	
	}
	
	//備考
	//●文字数チェック
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
	$form->addRule("form_note",$h_mess[23],"mb_maxlength","100");
	
	$form->registerRule("check_date","function","Check_Date");
	//$form->addGroupRule("form_stand_day", $h_mess[20],  "required", $_POST["form_stand_day"]);      //巡回基準日
	//$form->addRule("form_stand_day", $h_mess[20],  "check_date", $_POST["form_stand_day"]);         //巡回基準日
	$form->addGroupRule("form_update_day", $h_mess[52],  "required", $_POST["form_update_day"]);      //修正有発効日
	$form->addRule("form_update_day", $h_mess[52],  "check_date", $_POST["form_update_day"]);       //修正有発効日
	$form->addRule("form_contract_eday", $h_mess[53],  "check_date", $_POST["form_contract_eday"]); //契約終了日
	
	//巡回区分エラー判定 
	if($round_div == 1){
		//巡回１
		$form->addRule('form_abcd_week1',$h_mess[19],'required');
		$form->addRule('form_week_rday1',$h_mess[19],'required');
	
	}else if($round_div == 2){
		//巡回２
		$form->addRule('form_rday2',$h_mess[19],'required');
	
	}else if($round_div == 3){
		//巡回３
		$form->addRule('form_cale_week3',$h_mess[19],'required');
		$form->addRule('form_week_rday3',$h_mess[19],'required');
	
	}else if($round_div == 4){
		//巡回４
		$form->addRule('form_cale_week4',$h_mess[19],'required');
	
	}else if($round_div == 5){
		//巡回５
		$form->addRule('form_cale_month5',$h_mess[19],'required');
		$form->addRule('form_week_rday5',$h_mess[19],'required');
	
	}else if($round_div == 6){
		//巡回６
		$form->addRule('form_cale_month6',$h_mess[19],'required');
		$form->addRule('form_cale_week6',$h_mess[19],'required');
		$form->addRule('form_week_rday6',$h_mess[19],'required');
	
	}else if($round_div == 7){
		//巡回７

		//変則日にチェックが付いているか判定
		if($last_day == NULL){
			$form->setElementError("hensoku_err",$h_mess[24]);
		}

		//契約終了日以降に変則日があるとエラー
		if(($contract_eday < $last_day) && ($contract_eday != NULL)){
			$form->setElementError("hensoku_err",$h_mess[59]);
		}
	
	}

	
	//契約終了日が本日より前はエラー
	if(($contract_eday < $g_today) && ($contract_eday != NULL)){
		$form->setElementError("form_contract_eday",$h_mess[66]);
	}
	
	//巡回区分が２か５の場合、指定日の必須判定
	if($rday == 0 && ($round_div == 2 || $round_div == 5)){
		$form->setElementError("form_rday2",$h_mess[19]);
	}
	
	//修正発効日が本日より前はエラー
	if ($update_day < $g_today){
		$form->setElementError("form_update_day",$h_mess[64]);
	}

	/****************************/
	//エラーチェック(PHP)
	/****************************/
	//$error_flg = false;            //エラー判定フラグ

	//◇巡回担当者
	//売上率の合計が100%か判定
	//入力された売上率の合計が100％か判定
	if(($rate1 + (int)$rate2 + (int)$rate3 + (int)$rate4) != 100){
		$form->setElementError("sale_rate_sum",$h_mess[16]);
	}

	//巡回担当者の重複チェック
	$cnum1 = count($staff_check);
	$staff_check2 = array_unique($staff_check);
	$cnum2 = count($staff_check2);

	//要素数が違う場合、重複値が存在した
	if($cnum1 != $cnum2){
		$form->setElementError("staff_uniq",$h_mess[17]);
	}

	//売上率が０以上の数値か判定
	for($s=0;$s<5;$s++){
		$ecount = 12 + $s;
		//入力値がある場合に数値判定
		if(!ereg("^[0-9]+$",$staff_rate[$s]) && $staff_rate[$s] != NULL){
			$form->setElementError("form_sale_rate".($s+1),$h_mess[$ecount]);
		}
	}

	//順路
	//●文字数チェック
	//●数値チェック
	if(!ereg("^[0-9]{4}$",$route)){
		$form->setElementError("form_route_load","$h_mess[18]");
	}

	//◇行No.
	//数値判定
	if(ereg("^[0-9]+$",$line) && $line > 0){
		//数値(0を除く)

		//・重複チェック
		//入力したコードがマスタに存在するかチェック
		$sql  = "SELECT ";
		$sql .= "    trust_line ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "WHERE ";
		$sql .= "    trust_line = $line ";
		$sql .= "AND ";
		$sql .= "    trust_id = $client_h_id ";
		$sql .= "AND NOT ";
		$sql .= "    contract_id = $get_con_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql);
		$row_count = pg_num_rows($result);
		if($row_count != 0){
			$form->setElementError("form_line",$h_mess[7]);
		}
	}else{
		//NULL判定
		if($line == NULL){
			//NULL
			$form->setElementError("form_line",$h_mess[5]);
		}else{
			//数値以外or０行
			$form->setElementError("form_line",$h_mess[6]);
		}
	}

	//内訳エラー判定
	for($n=0;$n<count($input_row);$n++){
		/*
		for($b=0;$b<count($input_row2[$input_row[$n]]);$b++){
			//◇営業原価
			//・必須入力
			//・数値判定
			if(($bt_price1[$input_row[$n]][$input_row2[$input_row[$n]][$b]] == NULL && $bt_price2[$input_row[$n]][$input_row2[$input_row[$n]][$b]] == NULL) || !ereg("^[0-9]+\.[0-9]+$",$break_trade_price[$input_row[$n]][$input_row2[$input_row[$n]][$b]])){
				$error_msg6[$input_row[$n]][$input_row2[$input_row[$n]][$b]] = $b_mess[0][$input_row[$n]][$input_row2[$input_row[$n]][$b]];
				$error_flg = true;        //エラー表示
			}
		}
		*/
		
		//◇営業原価
		//・数値判定
		if(!ereg("^[0-9]+\.[0-9]+$",$trade_price[$input_row[$n]])){
			$form->setElementError("form_trade_price[$input_row[$n]]",$d_mess[5][$input_row[$n]]);
		}
	}

	$con_data2["entry_flg"] = "";    //登録ボタン押下フラグ初期化


	//$validate_result = $form->validate();

	//変更の場合は「修正発効日」と「巡回日」の整合性をチェックする
	if ( ($form->getElementError("form_update_day") == NULL)){
		$error_mesg = Round_Check($db_con,$update_ymd[0],$update_ymd[1],$update_ymd[2],$round_div,$abcd_week,$cale_week,$week_rday,$rday);

		if ($error_mesg != NULL){ 
			$form->setElementError("form_update_day","修正発行日は".$error_mesg);
		}
	}

	//エラーの場合はこれ以降の表示処理を行なわない
	//if($form->validate() && $error_flg == false){
	//if($validate_result && $error_flg == false){
	if( $form->validate() ){

		Db_Query($db_con, "BEGIN");
		//本日の日付取得
		$con_today = date("Y-m-d");

		$work_div = 2; //変更
		$contract_id = $get_con_id; //契約ID

		/****************************/
		//契約マスタ更新
		/****************************/
		$sql  = "UPDATE t_contract SET ";
		$sql .= "    trust_line = $line,";
		$sql .= "    route = $route,";
		$sql .= "    act_trust_day = '$con_today',";
		$sql .= "    trust_note = '$note',";
		$sql .= "    round_div = '$round_div',";
		$sql .= "    cycle = '$cycle',";
		$sql .= "    cycle_unit = '$cycle_unit',";
		$sql .= "    cale_week = '$cale_week',";
		$sql .= "    abcd_week = '$abcd_week',";
		$sql .= "    rday = '$rday',";
		$sql .= "    week_rday = '$week_rday',";
		$sql .= "    trust_trade_amount = $trust_trade_amount,";


		//最終巡回日が設定されているか
		if($last_day != NULL){
			$sql .= "    last_day = '$last_day',";
		}else{
			$sql .= "    last_day = NULL,";
		}
		if($update_day != NULL){
			$sql .= "    update_day = '$update_day', ";        //修正有効日
		}else{
			$sql .= "    update_day = NULL, ";                 //修正有効日
		}
		if($contract_eday != NULL){
			$sql .= "    contract_eday = '$contract_eday', ";  //契約終了日
		}else{
			$sql .= "    contract_eday = NULL, ";              //契約終了日
		}	
		$sql .= "    request_state = '2' ";
		$sql .= " WHERE ";
		$sql .= "    contract_id = $contract_id;";

		$result = Db_Query($db_con, $sql);
		if($result === false){
			Db_Query($db_con, "ROLLBACK");
			exit;
		}
		
		//代行元ID取得
		$sql  = "SELECT ";
		$sql .= "    shop_id ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "WHERE ";
		$sql .= "    contract_id = $contract_id;";
		$result = Db_Query($db_con, $sql);
		$shop_data = Get_Data($result);
		$shop_id = $shop_data[0][0];

		/****************************/
		//巡回日計算処理
		/****************************/
		/*
		$cal_array = Cal_range($db_con,$shop_id);
		
		$cal_end_day = $cal_array[1];    //カレンダー終了日
		$start_day   = $cal_array[0];    //対象開始期間
		$end_day     = $cal_array[1];    //対象終了期間
		$cal_peri    = $cal_array[2];    //カレンダー表示期間

		$stand_day = $update_day;  //「修正発効日」を基準とする

		//修正発効日がカレンダー開始日より後の場合、修正発効日から伝票を発行する。
		if ( ($start_day < $update_day) && ($update_day != NULL) ){
			$start_day = $update_day;
		}

		//「契約終了日がカレンダー終了日より前」　かつ　「NULLでない」　の場合は、契約終了日をカレンダー終了日とする。
		if ( ($contract_eday < $end_day) && ($contract_eday != NULL) ){
			$end_day = $contract_eday;
		}
		*/

		//伝票の作成に必要な日付を取得
		$cal_date = Cal_Span($db_con,$shop_id,$state,"変更",$stand_day,$update_day,$contract_eday);
		$stand_day   = $cal_date[0];    //契約発効日（基準日）		
		$start_day   = $cal_date[1];    //伝票作成開始日
		$end_day     = $cal_date[2];    //伝票作成終了日

		//変則日以外は、巡回日の計算処理
		if($round_div != 7){
			$date_array = NULL;
			$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day);
		}

		//****************************
		//予定伝票の重複作成チェック
		//****************************
		if(!empty($date_array)){

			//巡回日ごとに重複をチェックする
			foreach($date_array AS $key => $date){
				$duplicat = Get_Aord_Duplicat($db_con,$contract_id,$date); 

				//重複がない場合
				if ($duplicat === false) {

				//重複がある場合
				} else {
					$duplicat_mesg .= $duplicat;
					$commit_flg = false; //コミットしない
				}

			}
		}


		//print_array($date_array);
		/****************************/
		//巡回日テーブル登録（一度削除した後で登録）
		/****************************/
		Delete_ConRound($db_con,$contract_id); 

		//変則日の場合は、巡回日テーブル登録後に変則最終日をUPDATE
		if($round_div == 7){
			//巡回日テーブル登録
			Regist_ConRound($db_con,$contract_id,$date_array,NULL);

			$update_columns           = NULL; //初期化
			$update_columns[last_day] = $last_day;

			//SQLインジェクション対策
			$update_columns = pg_convert($db_con,'t_contract',$update_columns);	

			//UPDATE条件
			$where[contract_id] = $contract_id;
			$where              = pg_convert($db_con,'t_contract',$where);

			//変則最終日をUPDATE
			Db_Update($db_con, t_contract, $update_columns, $where);

		//変則日以外の場合
		}else{
			//巡回日テーブル登録
			Regist_ConRound($db_con,$contract_id,$date_array,$end_day);
		}

		/****************************/
		//巡回担当者テーブル登録（一度削除した後で登録）
		/****************************/
		Delete_ConStaff($db_con,$contract_id);
		Regist_ConStaff($db_con,$contract_id,$staff_check,$staff_rate);

		/****************************/
		//契約内容更新
		/****************************/
		for($s=0;$s<count($input_row);$s++){                           
			$sql  = "UPDATE t_con_info SET ";
			$sql .= "    trust_cost_price  = ".$trade_price[$input_row[$s]].",";       //営業原価
			$sql .= "    trust_cost_amount = ".$trade_amount[$input_row[$s]].", ";      //営業金額
            $sql .= "    trust_mst_sync_flg = ".$trust_mst_sync_flg[$input_row[$s]];    //（受託先用）マスタ同期フラグ
			$sql .= " WHERE ";
			$sql .= "    line = ".$input_row[$s];
			$sql .= " AND ";
			$sql .= "    contract_id = $get_con_id;";

			$result = Db_Query($db_con, $sql);
			if($result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}
		}

		//契約マスタの値をログに書き込む
		//（データコード：得意先CD-行No.  名称：得意先名-契約＋行No.）
		$cname = addslashes($cname);  //「'」が含まれる可能性があるため処理実行
		$result = Log_Save($db_con,'contract',$work_div,$client_cd."-".$line,$cname."-契約".$line);
		//ログ登録時にエラーになった場合
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
		
		//伝票の合計金額を計算し、アップデートする
		Update_Amount_Act($db_con, $contract_id, "contract");
		/****************************/
		//受注データ登録関数＆受払テーブルに登録関数     
		/****************************/
		//Aorder_Query($db_con,$shop_id,$client_id,$start_day,$end_day,$client_h_id);
		Regist_Aord_Contract($db_con,$shop_id,$contract_id,$start_day,$end_day,$client_h_id);

		//Db_Query($db_con, "COMMIT;");                                                     
		//header("Location: ./2-1-239.php");                                                             


		//****************************
		//コミット処理
		//****************************
		//「予定データの重複なし」または「予定データの重複OK」
		if (($commit_flg !== false) || ($_POST[duplicat_ok] == "1")){
		//if (($commit_flg !== false)){
			Db_Query($db_con, "COMMIT;");                                                     
			header("Location: ./2-1-239.php");                                                             

		//予定データが重複作成される場合
		}else{
			Db_Query($db_con, "ROLLBACK;");
			$form->setConstants(array(duplicat_ok=>"1"));
		}



	}                                                                 
}                                                                                        


//巡回区分ラジオ
if($_POST["form_round_div1"][0][0] == null){
    $round_div = $round_div_db;
}else{
    $round_div = $_POST["form_round_div1"][0][0];
    $con_data2["form_round_div1[]"] = $round_div;
}
$form_load = "onLoad=\"Check_read('$round_div');\"";


/****************************/
//POST情報の値を変更
/****************************/
$form->setConstants($con_data2);

//非同期チェックボックス
if($_POST["form_stand_day"] == null){
    $form->setConstants($mst_sync_data);
}else{
    $form->setConstants($mst_sync_data2);
}


#2009-09-22 hashimoto-y
$num = 5;
$toSmarty_discount_flg = array();
for ($i=1; $i<=$num; $i++){
    $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
    #echo "hdn_discount_flg:" .$hdn_discount_flg ."<br>";
    if($hdn_discount_flg === 't' ||
       $trade_sale_select[0] == '13' || $trade_sale_select[0] == '14' || $trade_sale_select[0] == '63' || $trade_sale_select[0] == '64'
    ){
        $toSmarty_discount_flg[$i] = 't';
    }else{
        $toSmarty_discount_flg[$i] = 'f';

    }
}

/****************************/
//javascript
/****************************/
$java_sheet = Js_Keiyaku();

//フォームループ数
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//エラーループ数1
//$error_loop_num1 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//エラーループ数2
//$error_loop_num2 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//エラーループ数3
//$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");

/****************************/
//全件数取得
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     t_client.client_id ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_contract.trust_id = ".$_SESSION["client_id"]." ";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";
$client_sql .= "     AND";
$client_sql .= "     t_contract.contract_div = '2'";

//ヘッダーに表示させる全件数
$count_res = Db_Query($db_con, $client_sql.";");
$total_count = pg_num_rows($count_res);

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
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);
//$smarty->assign('error_loop_num1',$error_loop_num1);
//$smarty->assign('error_loop_num2',$error_loop_num2);
//$smarty->assign('error_loop_num3',$error_loop_num3);
//$smarty->assign('error_msg4',$error_msg4);
//$smarty->assign('error_msg5',$error_msg5);
//$smarty->assign('error_msg6',$error_msg6);
//$smarty->assign('error_msg7',$error_msg7);
//$smarty->assign('error_msg8',$error_msg8);
//$smarty->assign('error_msg9',$error_msg9);
//$smarty->assign('error_msg10',$error_msg10);

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'     => "$html_header",
	'page_menu'       => "$page_menu",
	'page_header'     => "$page_header",
	'java_sheet'      => "$java_sheet",
	'html_footer'     => "$html_footer",
	'flg'             => "$flg",
	'last_day'        => "$last_day",
	//'error_msg'       => "$error_msg",
	//'error_msg2'      => "$error_msg2",
	//'error_msg3'      => "$error_msg3",
	'ac_name'         => "$ac_name",
	'return_flg'      => "$return_flg",
	'get_flg'         => "$get_flg",
	'client_id'       => "$client_id",
	'trade_error_flg' => "$trade_error_flg",
	'auth_r_msg'      => "$auth_r_msg",
	'br_flg'          => "$br_flg",
	'form_load'       => "$form_load",
	'duplicat_mesg'   => "$duplicat_mesg",
));


#2009-09-22 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));


//print_array($_POST);


/**
 * 概要  商品の価格を取得する 
 *
 * 説明  
 *
 * @param resource  $db_con       DB接続リソース
 * @param string    $goods_id     テーブル名
 * @param array     $rank_cd      顧客区分
 * @param array     $retrun_type  戻値の形式
 *
 * @return int                    商品単価
 *
 */
function Get_Goods_Price($db_con,$goods_id,$rank_cd=2,$retrun_type="1"){

	if($goods_id == NULL ){
		$price = "0.00";
	}else{
		$sql ="
            SELECT 
                t_price.r_price, 
                t_goods.compose_flg 

            FROM 
                t_goods
                LEFT JOIN t_price ON t_goods.goods_id = t_price.goods_id
                    AND t_price.shop_id    = $_SESSION[client_id]
                    AND t_price.rank_cd    = '$rank_cd'

            WHERE 
                t_goods.goods_id = $goods_id
";

		$result = Db_Query($db_con, $sql);

        //普通の商品
        if(pg_fetch_result($result, 0, "compose_flg") == "f"){
            $price = @pg_fetch_result($result, 0, 0);

        //構成品
        }else{
            $tmp = Compose_price($db_con, $_SESSION["client_id"], $goods_id);

            switch($rank_cd){
                case "2":
                    $price = $tmp[0];
                    break;
                case "4":
                    $price = $tmp[1];
                    break;
                case "3":
                    $price = $tmp[2];
                    break;
                default:
                    $price = "0.00";
            }

            $price = number_format($price, 2, ".", "");

        }

	}

	//整数と小数を分ける
	if($retrun_type != "1"){
		$price = explode('.', $price);
	}
	return $price;

}


?>
