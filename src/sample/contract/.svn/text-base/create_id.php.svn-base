<?php
//契約データをもとに受注データ作成


//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");
Db_Query($db_con, "LOCK TABLE t_aorder_h IN EXCLUSIVE MODE;");

//カレンダー表示期間取得
$cal_array = Cal_range($db_con,93);
$start_day = $cal_array[0];   //対象開始期間
$end_day = $cal_array[1];     //対象終了期間
$cal_peri = $cal_array[2];    //カレンダー表示期間

//契約ID
$sql  = "SELECT ";
$sql .= "    t_con1.contract_id ";
$sql .= "FROM ";
$sql .= "    (";
$sql .= "        SELECT ";
$sql .= "            contract_id   ";
$sql .= "        FROM ";
$sql .= "            t_contract  ";
$sql .= "            INNER JOIN ( ";
$sql .= "            SELECT ";
$sql .= "                client_id,";
$sql .= "                count(contract_id)   ";
$sql .= "            FROM ";
$sql .= "                t_contract ";
$sql .= "            WHERE ";
$sql .= "                client_id IN(    ";
$sql .= "                SELECT  ";
$sql .= "                    client_id      ";
$sql .= "                FROM";
$sql .= "                    t_client ";
$sql .= "                    INNER JOIN  ";
$sql .= "                    (";
$sql .= "                        SELECT ";
$sql .= "                            SUBSTR(data_cd,1,6)AS client_cd1,";
$sql .= "                            SUBSTR(data_cd,8,4)AS client_cd2 ";
$sql .= "                        FROM ";
$sql .= "                            t_mst_log ";
$sql .= "                        WHERE ";
$sql .= "                            mst_name = '契約マスタ' ";
$sql .= "                        AND ";
$sql .= "                            work_time > '2006-11-14 20:00:00'";
$sql .= "                    )AS t_mst";
$sql .= "                    ON ";
$sql .= "                        t_mst.client_cd1 = t_client.client_cd1 ";
$sql .= "                    AND ";
$sql .= "                        t_mst.client_cd2 = t_client.client_cd2";
$sql .= "                    AND ";
$sql .= "                        t_client.client_div = '1'  ";  
$sql .= "                    AND ";
$sql .= "                        t_client.shop_id = 93";
$sql .= "                ) ";
$sql .= "            GROUP BY";
$sql .= "                client_id,shop_id  ";
$sql .= "            HAVING  ";
$sql .= "                count(contract_id) = 1";
$sql .= "            )AS t_con_id ";
$sql .= "            ON ";
$sql .= "            t_con_id.client_id = t_contract.client_id";
$sql .= "    )AS t_con1 ";
$sql .= "    LEFT JOIN ";
$sql .= "    (";
$sql .= "    SELECT DISTINCT  ";
$sql .= "        t_less.contract_id  ";
$sql .= "    FROM  ";
$sql .= "        (";
$sql .= "        SELECT ";
$sql .= "            contract_id   ";
$sql .= "        FROM ";
$sql .= "            t_contract  ";
$sql .= "            INNER JOIN ( ";
$sql .= "            SELECT ";
$sql .= "                client_id,";
$sql .= "                count(contract_id)   ";
$sql .= "            FROM ";
$sql .= "                t_contract ";
$sql .= "            WHERE ";
$sql .= "                client_id IN(    ";
$sql .= "                SELECT  ";
$sql .= "                    client_id      ";
$sql .= "                FROM";
$sql .= "                    t_client ";
$sql .= "                    INNER JOIN  ";
$sql .= "                    (";
$sql .= "                        SELECT ";
$sql .= "                            SUBSTR(data_cd,1,6)AS client_cd1,";
$sql .= "                            SUBSTR(data_cd,8,4)AS client_cd2 ";
$sql .= "                        FROM ";
$sql .= "                            t_mst_log ";
$sql .= "                        WHERE ";
$sql .= "                            mst_name = '契約マスタ' ";
$sql .= "                        AND ";
$sql .= "                            work_time > '2006-11-14 20:00:00'";
$sql .= "                    )AS t_mst";
$sql .= "                    ON ";
$sql .= "                        t_mst.client_cd1 = t_client.client_cd1 ";
$sql .= "                    AND ";
$sql .= "                        t_mst.client_cd2 = t_client.client_cd2";
$sql .= "                    AND ";
$sql .= "                        t_client.client_div = '1'    ";
$sql .= "                    AND ";
$sql .= "                        t_client.shop_id = 93";
$sql .= "                ) ";
$sql .= "            GROUP BY";
$sql .= "                client_id,shop_id  ";
$sql .= "            HAVING  ";
$sql .= "                count(contract_id) = 1";
$sql .= "            )AS t_con_id ";
$sql .= "            ON ";
$sql .= "            t_con_id.client_id = t_contract.client_id";
$sql .= "        )AS t_less ";
$sql .= "        INNER JOIN ";
$sql .= "        (";
$sql .= "        SELECT ";
$sql .= "            t_aorder_d.contract_id ";
$sql .= "        FROM ";
$sql .= "            t_aorder_h ";
$sql .= "            INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "        WHERE ";
$sql .= "            t_aorder_h.ord_time >= '2006-11-16' ";
$sql .= "        AND  ";
$sql .= "            t_aorder_h.change_flg = 't' ";
$sql .= "        )AS t_aord ";
$sql .= "        ON t_less.contract_id = t_aord.contract_id ";
$sql .= "    )AS t_con2";
$sql .= "    ON t_con1.contract_id = t_con2.contract_id ";
$sql .= "WHERE ";
$sql .= "    t_con2.contract_id IS NULL;";
$con_result = Db_Query($db_con,$sql); 
while($con_list = pg_fetch_array($con_result)){
	$contract_id = $con_list[0];

	//ファイルにログを書込み(得意先ID)
	$fp = fopen("check.txt","a");
	fputs($fp,$contract_id."\n");
	fclose($fp);
}
Db_Query($db_con, "COMMIT;");


/****************************/
//対象期間計算(本日〜月末＋カレンダー表示期間+1の日数)関数
/****************************/

 /**
 * 対象期間計算
 *
 * 変更履歴
 * 1.0.0 (2006/06/05) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/06/05)
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $shop_id        ショップID
 * @param               boolean     $range          １ヶ月を31日として計算するか識別
 *
 * @return              array       $cal_array[0]   対象開始期間
 *                                  $cal_array[1]   対象終了期間
 *                                  $cal_array[2]   カレンダー表示期間
 */

function Cal_range($db_con,$shop_id){

	$sql  = "SELECT ";
	$sql .= "    cal_peri ";           //カレンダー表示期間
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $shop_id;";
	$result = Db_Query($db_con, $sql);
	$cal_peri = pg_fetch_result($result,0,0);

	//月を３１日として、カレンダー表示期間分の日数を計算し、本日からその日数を足したのが範囲

	//カレンダー表示日数
	$cal_day = 31 * ($cal_peri+1);

	//対象期間（開始）取得
	$day_y = date("Y");            
	$day_m = date("m");
	$day_d = date("d");
	$start_day = $day_y."-".$day_m."-".$day_d;

	//対象期間（終了）取得
	$end = mktime(0, 0, 0, $day_m,$day_d+$cal_day,$day_y);
	$end_day = date("Y-m-d",$end);

	$cal_array[0] = "2006-11-15";
	$cal_array[1] = $end_day;
	$cal_array[2] = $cal_peri+1;

	return $cal_array;
}

/****************************/
//受注データ登録関数
/****************************/
 /**
 * 受注データ登録
 *
 * 変更履歴
 * 1.0.0 (2006/06/05) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/06/05)
 *
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               int         $shop_id        ショップID
 * @param               int         $contract_id    契約ID
 * @param               string      $start_day      契約データ作成開始日
 * @param               string      $end_day        契約データ作成終了日
 * @param               int         $trust_id       受託先ID
 *
 */

function Aorder_Query($db_con,$shop_id,$contract_id,$start_day,$end_day,$trust_id=NULL){

	/****************************/
	//外部変数取得
	/****************************/
	//$staff_id    = $_SESSION["staff_id"];     //ログイン者ID
	$staff_id    = 8;
	//$staff_name  = addslashes($_SESSION["staff_name"]);   //ログイン者名
	$staff_name  = addslashes("小松芳夫");

	/****************************/
	//得意先ID取得
	/****************************/
	$sql  = "SELECT ";
	$sql .= "    client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql); 
	$client_list = Get_Data($result);
	$client_id = $client_list[0][0];

	/****************************/
	//得意先コード入力処理
	/****************************/
	//得意先の情報を抽出
	$sql  = "SELECT";
	$sql .= "   t_client.coax, ";
	$sql .= "   t_client.client_cname,";
	$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
	$sql .= "   t_client.trade_id,";
	$sql .= "   t_client.tax_franct,";
	$sql .= "   t_client.slip_out, ";
	$sql .= "   t_client.intro_ac_price,";          
	$sql .= "   t_client.intro_ac_rate ";           
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql); 
	Get_Id_Check($result);
	$data_list = Get_Data($result,3);

	$coax            = $data_list[0][0];        //丸め区分（商品）
	$cname           = $data_list[0][1];        //顧客名
	$client_cd       = $data_list[0][2];        //得意先CD
	$trade_id        = $data_list[0][3];        //取引コード
	$tax_franct      = $data_list[0][4];        //消費税（端数区分）
	$slip_out        = $data_list[0][5];        //伝票形式
	$client_ac_price = $data_list[0][6];        //紹介口座金額
	$client_ac_rate  = $data_list[0][7];        //紹介口座率

	//取引先情報取得
	$sql  = "SELECT";
	$sql .= "   t_client.client_cname,";            //紹介口座先名
	$sql .= "   t_client_info.intro_account_id,";   //紹介口座ID
	$sql .= "   t_client_info.cclient_shop ";       //担当支店ID
	$sql .= " FROM";
	$sql .= "   t_client_info ";
	$sql .= "   LEFT JOIN t_client ON t_client.client_id = t_client_info.intro_account_id ";
	$sql .= " WHERE";
	$sql .= "   t_client_info.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$info_list = Get_Data($result,3);

	$ac_name         = $info_list[0][0];        //紹介口座先
	$client_ac_id    = $info_list[0][1];        //紹介口座ID
	$cshop_id        = $info_list[0][2];        //担当支店ID

	/****************************/
	//ログインユーザ情報取得処理
	/****************************/
	//代行判定
	if($trust_id != NULL){
		//代行

		//担当支店の情報を抽出
		$sql  = "SELECT";
		$sql .= "   t_client.tax_rate_n ";
		$sql .= " FROM";
		$sql .= "   t_client ";
		$sql .= " WHERE";
		$sql .= "   client_id = $cshop_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		Get_Id_Check($result);
		$data_list = Get_Data($result,3);
		$tax_num        = $data_list[0][0];        //消費税(現在)

		//代行の情報を抽出
		$sql  = "SELECT";
		$sql .= "   t_ware.ware_name,";
		$sql .= "   t_ware.ware_id,";
		$sql .= "   t_client.rank_cd ";
		$sql .= " FROM";
		$sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
		$sql .= " WHERE";
		$sql .= "   client_id = $trust_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		Get_Id_Check($result);
		$act_data_list = Get_Data($result,3);

		$ware_name      = $act_data_list[0][0];        //商品出荷倉庫名
		$ware_id        = $act_data_list[0][1];        //出荷倉庫ID
		$rank_cd        = $act_data_list[0][2];        //顧客区分CD

	}else{
		//直営orFC

		//担当支店の情報を抽出
		$sql  = "SELECT";
		$sql .= "   t_ware.ware_name,";
		$sql .= "   t_ware.ware_id,";
		$sql .= "   t_client.tax_rate_n,";
		$sql .= "   t_client.rank_cd ";
		$sql .= " FROM";
		$sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
		$sql .= " WHERE";
		$sql .= "   client_id = $cshop_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		Get_Id_Check($result);
		$data_list = Get_Data($result,3);

		$ware_name      = $data_list[0][0];        //商品出荷倉庫名
		$ware_id        = $data_list[0][1];        //出荷倉庫ID
		$tax_num        = $data_list[0][2];        //消費税(現在)
		$rank_cd        = $data_list[0][3];        //顧客区分CD
	}

	/****************************/
	//契約から起こした受注ヘッダ削除処理
	/****************************/
	//契約から起こした受注ID取得
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.aord_id ";
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.ord_no IS NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_time >= '$start_day' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_time <= '$end_day' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql);
	$aord_list = Get_Data($result,3);

	for($a=0;$a<count($aord_list);$a++){
		//対象の受注ヘッダを削除
		$sql  = "DELETE FROM ";
		$sql .= "    t_aorder_h ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = ".$aord_list[$a][0].";";
		$result = Db_Query($db_con, $sql);
		if($result === false){
			//手動
			Db_Query($db_con, "ROLLBACK");
		    exit;
		}
	}

	/****************************/
	//契約データ取得処理
	/****************************/

	$sql  = "SELECT ";
	$sql .= "    t_round.round_day,";              //巡回日 0
	$sql .= "    t_contract.route,";               //順路 1
	$sql .= "    t_con_aod.line,";                 //行No. 2
	$sql .= "    t_contract.contract_id,";         //契約情報ID 3
	$sql .= "    t_con_aod.divide,";               //販売区分コード 4
	$sql .= "    t_con_aod.serv_id,";              //サービスID 5
	$sql .= "    CASE t_con_aod.serv_pflg ";       //サービス印字フラグ 6
	$sql .= "         WHEN 't' THEN 'true'";
	$sql .= "         WHEN 'f' THEN 'false'";
	$sql .= "    END,";
	$sql .= "    CASE t_con_aod.set_flg ";         //一式フラグ 7
	$sql .= "         WHEN 't' THEN 'true'";
	$sql .= "         WHEN 'f' THEN 'false'";
	$sql .= "    END,";
	$sql .= "    CASE t_con_aod.goods_pflg ";      //アイテム印字フラグ 8
	$sql .= "         WHEN 't' THEN 'true'";
	$sql .= "         WHEN 'f' THEN 'false'";
	$sql .= "    END,";       
	$sql .= "    t_con_aod.goods_id,";             //アイテム商品ID 9
	$sql .= "    t_con_aod.goods_name,";           //アイテム名 10
	$sql .= "    t_con_aod.num,";                  //アイテム数 11
	$sql .= "    t_con_aod.tax_div,";              //アイテムの課税区分 12
	$sql .= "    t_con_aod.r_price,";              //アイテムの仕入単価 13
	$sql .= "    t_con_aod.trade_price,";          //営業原価 14
	$sql .= "    t_con_aod.sale_price,";           //売上単価 15
	$sql .= "    t_con_aod.trade_amount,";         //営業金額 16
	$sql .= "    t_con_aod.sale_amount,";          //売上金額 17
	$sql .= "    t_con_aod.rgoods_id,";            //本体商品ID 18
	$sql .= "    t_con_aod.rgoods_name, ";         //本体名 19
	$sql .= "    t_con_aod.rgoods_num,";           //本体数 20
   	$sql .= "    t_con_aod.egoods_id,";            //消耗品ID 21
	$sql .= "    t_con_aod.egoods_name,";          //消耗品名 22
	$sql .= "    t_con_aod.egoods_num,";           //消耗品数 23

	$sql .= "    t_staff1.staff_id,";              //メイン１ 24
	$sql .= "    t_staff1.sale_rate,";             //売上率 25
	$sql .= "    t_staff2.staff_id,";              //サブ２ 26
	$sql .= "    t_staff2.sale_rate,";             //売上率 27
	$sql .= "    t_staff3.staff_id,";              //サブ３ 28
	$sql .= "    t_staff3.sale_rate,";             //売上率 29
	$sql .= "    t_staff4.staff_id,";              //サブ４ 30
	$sql .= "    t_staff4.sale_rate, ";            //売上率 31
	
	$sql .= "    t_con_aod.con_info_id, ";         //契約内容ID 32
	$sql .= "    t_contract.client_id,";           //得意先ID 33
	$sql .= "    t_con_aod.account_price,";        //口座単価 34
	$sql .= "    t_con_aod.account_rate, ";        //口座率 35

	$sql .= "    t_contract.contract_div,";        //契約区分 36
	$sql .= "    t_contract.trust_id, ";           //代行ID 37
	$sql .= "    t_contract.act_request_rate, ";   //代行依頼料 38

	$sql .= "    t_con_aod.trust_trade_price,";    //営業原価(受託) 39
	$sql .= "    t_con_aod.trust_trade_amount, ";  //営業金額(受託) 40

	$sql .= "    t_contract.intro_ac_price,";      //紹介口座単価 41
	$sql .= "    t_contract.intro_ac_rate,  ";     //紹介口座率 42

	$sql .= "    t_contract.claim_id,";            //請求先ID 43
	$sql .= "    t_contract.claim_div,  ";         //請求先区分 44

	$sql .= "    t_contract.round_div,";                //巡回区分45
	$sql .= "    t_contract.cycle,";                    //周期46
	$sql .= "    t_contract.cycle_unit,";               //周期単位47
	$sql .= "    CASE t_contract.cale_week ";           //週名(1-4)48
	$sql .= "        WHEN '1' THEN ' 第1'";
	$sql .= "        WHEN '2' THEN ' 第2'";
	$sql .= "        WHEN '3' THEN ' 第3'";
	$sql .= "        WHEN '4' THEN ' 第4'";
	$sql .= "    END,";
	$sql .= "    CASE t_contract.abcd_week ";           //週名(ABCD)49
	$sql .= "        WHEN '1' THEN 'A(4週間隔)週'";
	$sql .= "        WHEN '2' THEN 'B(4週間隔)週'";
	$sql .= "        WHEN '3' THEN 'C(4週間隔)週'";
	$sql .= "        WHEN '4' THEN 'D(4週間隔)週'";
	$sql .= "        WHEN '5' THEN 'A,C(2週間隔)週'";
	$sql .= "        WHEN '6' THEN 'B,D(2週間隔)週'";
	$sql .= "        WHEN '21' THEN 'A(8週間隔)週'";
	$sql .= "        WHEN '22' THEN 'B(8週間隔)週'";
	$sql .= "        WHEN '23' THEN 'C(8週間隔)週'";
	$sql .= "        WHEN '24' THEN 'D(8週間隔)週'";
	$sql .= "    END,";
	$sql .= "    t_contract.rday, ";                    //指定日50
	$sql .= "    CASE t_contract.week_rday ";           //指定曜日51
	$sql .= "        WHEN '1' THEN ' 月曜'";
	$sql .= "        WHEN '2' THEN ' 火曜'";
	$sql .= "        WHEN '3' THEN ' 水曜'";
	$sql .= "        WHEN '4' THEN ' 木曜'";
	$sql .= "        WHEN '5' THEN ' 金曜'";
	$sql .= "        WHEN '6' THEN ' 土曜'";
	$sql .= "        WHEN '7' THEN ' 日曜'";
	$sql .= "    END,";
	$sql .= "    t_contract.stand_day,";                //作業基準日52
	$sql .= "    t_contract.last_day ";                 //最終巡回日53

	$sql .= "FROM ";
	$sql .= "    (SELECT ";
	$sql .= "        t_con_info.con_info_id,";
	$sql .= "        t_con_info.contract_id,";
	$sql .= "        t_con_info.line,";
	$sql .= "        t_con_info.divide,";
	$sql .= "        t_con_info.serv_pflg,";
	$sql .= "        t_con_info.serv_id,";
	$sql .= "        t_con_info.set_flg,";
    $sql .= "        t_con_info.goods_pflg,";
	$sql .= "        t_con_info.goods_id,";
	$sql .= "        t_con_info.goods_name,"; 
	$sql .= "        t_con_info.num,";
	$sql .= "        t_con_info.rgoods_id,";
	$sql .= "        t_con_info.rgoods_name,"; 
	$sql .= "        t_con_info.rgoods_num,";
	$sql .= "        t_con_info.egoods_id,";
	$sql .= "        t_con_info.egoods_name,"; 
	$sql .= "        t_con_info.egoods_num,";
	$sql .= "        t_con_info.sale_price,";
	$sql .= "        t_con_info.sale_amount,";
	$sql .= "        t_con_info.trade_price,";
	$sql .= "        t_con_info.trade_amount,";
	$sql .= "        t_con_info.account_price,";
	$sql .= "        t_con_info.account_rate,";
	$sql .= "        t_price.r_price,";
	$sql .= "        t_goods.tax_div,";
	$sql .= "        t_con_info.trust_trade_price,";
	$sql .= "        t_con_info.trust_trade_amount ";
	$sql .= "    FROM "; 
	$sql .= "        t_con_info "; 
	$sql .= "        LEFT JOIN t_price ON t_con_info.goods_id = t_price.goods_id AND t_price.rank_cd = '$rank_cd'";
	$sql .= "        LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id ";
	$sql .= "    )AS t_con_aod ";

	$sql .= "    INNER JOIN t_contract ON t_contract.contract_id = t_con_aod.contract_id ";
	$sql .= "    INNER JOIN t_round ON t_contract.contract_id = t_round.contract_id ";

	$sql .= "    LEFT JOIN t_serv ON t_serv.serv_id = t_con_aod.serv_id ";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_con_staff.contract_id,";
	$sql .= "             t_con_staff.staff_id,";
	$sql .= "             t_con_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_con_staff ";
	$sql .= "         WHERE ";
	$sql .= "             t_con_staff.staff_div = '0'";
	$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id ";
	 
	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_con_staff.contract_id,";
	$sql .= "             t_con_staff.staff_id,";
	$sql .= "             t_con_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_con_staff ";
	$sql .= "         WHERE ";
	$sql .= "             t_con_staff.staff_div = '1'";
	$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id ";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_con_staff.contract_id,";
	$sql .= "             t_con_staff.staff_id,";
	$sql .= "             t_con_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_con_staff ";
	$sql .= "         WHERE ";
	$sql .= "             t_con_staff.staff_div = '2'";
	$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id ";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_con_staff.contract_id,";
	$sql .= "             t_con_staff.staff_id,";
	$sql .= "             t_con_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_con_staff ";
	$sql .= "         WHERE ";
	$sql .= "             t_con_staff.staff_div = '3'";
	$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id ";

	$sql .= "WHERE ";
	$sql .= "    t_contract.contract_id = $contract_id ";
	$sql .= "AND ";
	$sql .= "    t_round.round_day >= '$start_day' ";
	$sql .= "AND ";
	$sql .= "    t_round.round_day <= '$end_day' ";
	$sql .= "AND ";
	$sql .= "    t_contract.request_state = '2' ";
	$sql .= "ORDER BY ";

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/16　0152　　　　　suzuki-t　　行番号割当て処理を修正
 *
 */
	$sql .= "    t_contract.contract_id,";


	$sql .= "    t_round.round_day,";
	$sql .= "    t_contract.route,";
	$sql .= "    t_con_aod.line;"; 

	$result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result,3);

	/****************************/
	//受注ヘッダー登録処理
	/****************************/
	$update_id = NULL;    //ヘッダーの金額を更新する受注ID配列
	for($i=0;$i<count($data_list);$i++){

		//既に登録した受注ヘッダーか判定SQL
		$sql  = "SELECT ";
		$sql .= "    t_aorder_h.aord_id, ";
		$sql .= "    t_aorder_h.confirm_flg, ";
		$sql .= "    t_aorder_h.trust_confirm_flg, ";
		$sql .= "    t_aorder_h.ord_no ";
		$sql .= "FROM ";
		$sql .= "    t_aorder_h ";
		$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_aorder_staff.staff_id,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '0'";
		$sql .= "        )AS t_staff1 ON t_staff1.aord_id = t_aorder_h.aord_id ";
		 
		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_aorder_staff.staff_id,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '1'";
		$sql .= "        )AS t_staff2 ON t_staff2.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_aorder_staff.staff_id,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '2'";
		$sql .= "        )AS t_staff3 ON t_staff3.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_aorder_staff.staff_id,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '3'";
		$sql .= "        )AS t_staff4 ON t_staff4.aord_id = t_aorder_h.aord_id ";

		$sql .= "WHERE ";
		$sql .= "    t_aorder_d.contract_id = ".$data_list[$i][3];
		$sql .= " AND ";
		$sql .= "    t_aorder_h.client_id = ".$data_list[$i][33];
		$sql .= " AND ";
		$sql .= "    t_aorder_h.shop_id = $cshop_id ";
		$sql .= " AND ";
		$sql .= "    t_aorder_h.ord_time = '".$data_list[$i][0]."'";
		//オフライン代行の場合は、順路条件なし
		if($data_list[$i][36] != '3'){
			$sql .= " AND ";
			$sql .= "    t_aorder_h.route = ".$data_list[$i][1];
		}
		$sql .= " AND ";
		//担当者１が指定されているか
		if($data_list[$i][24] != NULL){
			//指定あり
			$sql .= "    t_staff1.staff_id = ".$data_list[$i][24];
		}else{
			//指定なし
			$sql .= "    t_staff1.staff_id IS NULL";
		}
		$sql .= " AND ";
		//売上率１が指定されているか
		if($data_list[$i][25] != NULL){
			//指定あり
			$sql .= "    t_staff1.sale_rate = ".$data_list[$i][25]." ";
		}else{
			//指定なし
			$sql .= "    t_staff1.sale_rate IS NULL";
		}
		$sql .= " AND ";
		//担当者２が指定されているか
		if($data_list[$i][26] != NULL){
			//指定あり
			$sql .= "    t_staff2.staff_id = ".$data_list[$i][26];
		}else{
			//指定なし
			$sql .= "    t_staff2.staff_id IS NULL";
		}
		$sql .= " AND ";
		//売上率２が指定されているか
		if($data_list[$i][27] != NULL){
			//指定あり
			$sql .= "    t_staff2.sale_rate = ".$data_list[$i][27]." ";
		}else{
			//指定なし
			$sql .= "    t_staff2.sale_rate IS NULL";
		}
		$sql .= " AND ";
		//担当者3が指定されているか
		if($data_list[$i][28] != NULL){
			//指定あり
			$sql .= "    t_staff3.staff_id = ".$data_list[$i][28];
		}else{
			//指定なし
			$sql .= "    t_staff3.staff_id IS NULL";
		}
		$sql .= " AND ";
		//売上率３が指定されているか
		if($data_list[$i][29] != NULL){
			//指定あり
			$sql .= "    t_staff3.sale_rate = ".$data_list[$i][29]." ";
		}else{
			//指定なし
			$sql .= "    t_staff3.sale_rate IS NULL";
		}
		$sql .= " AND ";
		//担当者4が指定されているか
		if($data_list[$i][30] != NULL){
			//指定あり
			$sql .= "    t_staff4.staff_id = ".$data_list[$i][30];
		}else{
			//指定なし
			$sql .= "    t_staff4.staff_id IS NULL";
		}
		$sql .= " AND ";
		//売上率４が指定されているか
		if($data_list[$i][31] != NULL){
			//指定あり
			$sql .= "    t_staff4.sale_rate = ".$data_list[$i][31]." ";
		}else{
			//指定なし
			$sql .= "    t_staff4.sale_rate IS NULL";
		}

		$result = Db_Query($db_con, $sql.";");
		$h_data_list = NULL;
		$h_data_list = Get_Data($result,3);

		$aord_id       = $h_data_list[0][0];     //受注ID
		$confirm_flg   = $h_data_list[0][1];     //確定フラグ
		$t_confirm_flg = $h_data_list[0][2];     //確定フラグ(受託先)
		$aord_no       = $h_data_list[0][3];     //受注番号

		//巡回担当者登録配列
		$staff_check = NULL;
		$staff_check[] = $data_list[$i][24];  //メイン１
		$staff_check[] = $data_list[$i][26];  //サブ２
		$staff_check[] = $data_list[$i][28];  //サブ３
		$staff_check[] = $data_list[$i][30];  //サブ４

		//売上率登録配列
		$staff_rate = NULL;
		$staff_rate[] = $data_list[$i][25];   //売上率１
		$staff_rate[] = $data_list[$i][27];   //売上率２
		$staff_rate[] = $data_list[$i][29];   //売上率３
		$staff_rate[] = $data_list[$i][31];   //売上率４
	
		//受注ヘッダが存在しないかつ受注番号がなければ、登録処理
		if($aord_id == NULL && $aord_no == NULL){

			//新規ヘッダー登録

			//受注ID取得
			$microtime = NULL;
			$microtime = explode(" ",microtime());
			$aord_id   = $microtime[1].substr("$microtime[0]", 2, 5);

			//履歴用カラムデータ取得
			$sql  = "SELECT ";
			$sql .= "    t_client.client_name,";    
			$sql .= "    t_client.client_name2,";
			$sql .= "    t_client.client_cname,";
			$sql .= "    t_client.client_cd1,";
			$sql .= "    t_client.client_cd2 ";
			$sql .= "FROM ";
			$sql .= "    t_client ";
			$sql .= "WHERE ";
			$sql .= "    t_client.client_id = $client_id;";
			$result = Db_Query($db_con, $sql);
			$hist_data = Get_Data($result,3);

			//代行指定判定
			$hist_data2 = NULL;
			if($data_list[$i][37] != null){
				$sql  = "SELECT ";
				$sql .= "    t_client.client_cname, ";  
				$sql .= "    t_client.client_cd1,";
				$sql .= "    t_client.client_cd2 ";
				$sql .= "FROM ";
				$sql .= "    t_client ";
				$sql .= "WHERE ";
				$sql .= "    t_client.client_id = ".$data_list[$i][37].";";
				$result = Db_Query($db_con, $sql);
				$hist_data2 = Get_Data($result,3);
			}

			//受注ヘッダー登録SQL
			$sql  = "INSERT INTO t_aorder_h (\n";
			$sql .= "    aord_id,\n";            //受注ID
			$sql .= "    ord_time,\n";           //受注日
			$sql .= "    client_id,\n";          //得意先ID
			$sql .= "    trade_id,\n";           //取引区分コード
			$sql .= "    hope_day,\n";           //希望納期
			$sql .= "    arrival_day,\n";        //出荷予定日
			$sql .= "    route,\n";              //順路
			$sql .= "    ware_id,\n";            //倉庫ID
			$sql .= "    ps_stat,\n";            //処理状況
			$sql .= "    shop_id,\n";            //取引先ID
			$sql .= "    slip_out,\n";           //伝票形式
			$sql .= "    intro_ac_name,\n";      //紹介口座名
			$sql .= "    intro_account_id,\n";   //紹介口座ID
			$sql .= "    contract_div,\n";       //契約区分
			$sql .= "    act_id, \n";            //代行ID
			$sql .= "    act_request_rate, \n";  //代行依頼料
			$sql .= "    intro_ac_price, \n";    //口座単価(得意先)
			$sql .= "    intro_ac_rate, \n";     //口座率(得意先)
			$sql .= "    client_name,\n";        //得意先名
			$sql .= "    client_name2,\n";       //得意先名２
			$sql .= "    client_cname,\n";       //略称
			$sql .= "    client_cd1,\n";         //得意先コード
			$sql .= "    client_cd2,\n";         //得意先コード２
			$sql .= "    ware_name,\n";          //出荷倉庫名
			$sql .= "    act_name, \n";          //代行先名
			$sql .= "    claim_id, \n";          //請求先ID
			$sql .= "    claim_div, \n";         //請求区分
			$sql .= "    round_form, \n";        //巡回形式
			$sql .= "    act_cd1,\n";            //代行先コード
			$sql .= "    act_cd2, \n";           //代行先コード２
			$sql .= "    ord_staff_id, \n";      //オペレータID
			$sql .= "    ord_staff_name \n";     //オペレータ名

			$sql .= ")VALUES(\n";
			$sql .= "    $aord_id,\n";   
			$sql .= "    '".$data_list[$i][0]."',\n";
			$sql .= "    $client_id,\n";
			//代行判定
			if($trust_id != NULL){
				//代行は掛売上
				$sql .= "    '11',\n";
			}else{
				//得意先の取引区分
				$sql .= "    '$trade_id',\n";
			}
			$sql .= "    '".$data_list[$i][0]."',\n";
			$sql .= "    '".$data_list[$i][0]."',\n";
			//順路指定判定
			if($data_list[$i][1] != NULL){
				$sql .= "    ".$data_list[$i][1].",\n";
			}else{
				$sql .= "    NULL,\n";
			}
			//オフライン代行の場合は、出荷倉庫IDなし
			if($data_list[$i][36] != '3'){
				$sql .= "    $ware_id,\n";
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '1',\n";                      //未処理
			$sql .= "    $cshop_id,\n";
			$sql .= "    '$slip_out',\n";
			$sql .= "    '$ac_name',\n";
			//紹介口座存在判定
			if($client_ac_id != NULL){
				$sql .= "    $client_ac_id,\n";
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$data_list[$i][36]."',\n";
			//代行先ID指定判定
			if($data_list[$i][37] != NULL){
				$sql .= "    ".$data_list[$i][37].",\n";
			}else{
				$sql .= "    NULL,\n";
			}
			//代行依頼料指定判定
			if($data_list[$i][38] != NULL){
				$sql .= "    '".$data_list[$i][38]."',\n";
			}else{
				$sql .= "    NULL,\n";
			}
			//口座単価(得意先)指定判定
			if($client_ac_price != NULL){
				$sql .= "    ".$client_ac_price.",\n";
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$client_ac_rate."',\n";

			$sql .= "    '".$hist_data[0][0]."',\n";
			$sql .= "    '".$hist_data[0][1]."',\n";
			$sql .= "    '".$hist_data[0][2]."',\n";
			$sql .= "    '".$hist_data[0][3]."',\n";
			$sql .= "    '".$hist_data[0][4]."',\n";
			//オフライン代行の場合は、出荷倉庫名なし
			if($data_list[$i][36] != '3'){
				$sql .= "    '$ware_name',\n";
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$hist_data2[0][0]."',\n";

			$sql .= "    ".$data_list[$i][43].",\n";
			$sql .= "    '".$data_list[$i][44]."',\n";
			
			//巡回形式処理
			$round_data = NULL;
			if($data_list[$i][45] == "1"){
				//巡回１
				$round_data = $data_list[$i][49].$data_list[$i][51];
			}else if($data_list[$i][45] == "2"){
				//巡回２
				$date_data = substr($data_list[$i][52],0,7);

				if($data_list[$i][50] == "30"){
					$round_data = "毎月 月末 (".$date_data.")";
				}else{
					$round_data = "毎月 ".$data_list[$i][50]."日 (".$date_data.")";
				}
			}else if($data_list[$i][45] == "3"){
				//巡回３
				$date_data = substr($data_list[$i][52],0,7);

				$round_data = "毎月".$data_list[$i][48].$data_list[$i][51]."(".$date_data.")";
			}else if($data_list[$i][45] == "4"){
				//巡回４
				$round_data = $data_list[$i][46]."週間周期の".$data_list[$i][51]."(".$data_list[$i][52].")";
			}else if($data_list[$i][45] == "5"){
				//巡回５
				$date_data = substr($data_list[$i][52],0,7);
				if($data_list[$i][50] == "30"){
					$round_data = $data_list[$i][46]."ヶ月周期の 月末 (".$date_data.")";
				}else{
					$round_data = $data_list[$i][46]."ヶ月周期の ".$data_list[$i][50]."日 (".$date_data.")";
				}
			}else if($data_list[$i][45] == "6"){
				//巡回６
				$date_data = substr($data_list[$i][52],0,7);

				$round_data = $data_list[$i][46]."ヶ月周期の ".$data_list[$i][48].$data_list[$i][51]."(".$date_data.")";
			}else if($data_list[$i][45] == "7"){
				//巡回７
				$round_data = "変則日(最終日:".$data_list[$i][53].")";
			}

			$sql .= "    '".$round_data."',\n";
			$sql .= "    '".$hist_data2[0][1]."',\n";
			$sql .= "    '".$hist_data2[0][2]."',\n";
			//セッション存在判定
			if($staff_id != NULL){
				$sql .= "     $staff_id,\n";
			}else{
				//CRON
				$sql .= "     NULL,\n";
			}
			$sql .= "     '$staff_name'); \n";

			$result = Db_Query($db_con, $sql);
            if($result == false){
				Db_Query($db_con, "ROLLBACK");
			    exit;
            }

			/****************************/
			//巡回担当者テーブル登録
			/****************************/
			for($c=0;$c<=3;$c++){
				//スタッフが指定されているか判定
				if($staff_check[$c] != NULL){
					//履歴用
					$sql = "SELECT staff_name FROM t_staff WHERE staff_id = ".$staff_check[$c].";";
					$result = Db_Query($db_con, $sql);
					$staff_data = Get_Data($result,3);

					$sql  = "INSERT INTO t_aorder_staff( ";
					$sql .= "    aord_id,";
					$sql .= "    staff_div,";
					$sql .= "    staff_id,";
					$sql .= "    sale_rate, ";
					$sql .= "    staff_name ";
					//$sql .= "    course_id ";
					$sql .= "    )VALUES(";
					$sql .= "    $aord_id,";                          //受注ID
					$sql .= "    '$c',";                              //巡回担当者識別
					$sql .= "    ".$staff_check[$c].",";              //巡回担当者ID
					//売上率指定判定
					if($staff_rate[$c] != NULL){
						$sql .= "    ".$staff_rate[$c].",";           //売上率
					}else{
						$sql .= "    NULL,";
					}
					$sql .= "    '".$staff_data[0][0]."'";            //担当者名
					$sql .= ");";
					$result = Db_Query($db_con, $sql);
					if($result === false){
						Db_Query($db_con, "ROLLBACK");
					    exit;
					}
				}
			}
		}

		//受注番号ない受注のみ登録
		if($aord_no == NULL){
			/****************************/                                                   
			//受注データー登録処理                                                           
			/****************************/
			//受注データID取得
			$microtime2 = NULL;
			$microtime2 = explode(" ",microtime());
			$aord_d_id   = $microtime2[1].substr("$microtime2[0]", 2, 5); 

			//サービス指定判定
			$serv_data = NULL;
			if($data_list[$i][5] != NULL){
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_serv.serv_name,"; 
				$sql .= "    t_serv.serv_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_serv ";
				$sql .= "WHERE ";
				$sql .= "    t_serv.serv_id = ".$data_list[$i][5].";";
				$result = Db_Query($db_con, $sql);
				$serv_data = Get_Data($result,3);
			}

			//商品指定判定
			$item_data = NULL;
			if($data_list[$i][9] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd, ";
				$sql .= "    t_goods.compose_flg, ";
				$sql .= "    t_goods.public_flg  ";
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$data_list[$i][9].";";
				$result = Db_Query($db_con, $sql);
				$item_data = Get_Data($result,3);

				//構成品判定
				if($item_data[0][1] == 't'){
					//構成品親の在庫単価取得
					$price_array = NULL;
					//代行判定
					if($trust_id != NULL){
						//オンライン代行
						$price_array = Compose_price($db_con,$trust_id,$data_list[$i][9]);
					}else{
						//自社巡回・オフライン代行
						$price_array = Compose_price($db_con,$cshop_id,$data_list[$i][9]);
					}
					$buy_price = $price_array[2];
				}else{
					//顧客区分CD取得
					$sql  = "SELECT ";
					$sql .= "    t_rank.group_kind, ";  //グループ種別
					$sql .= "    t_rank.rank_cd ";      //顧客区分CD
					$sql .= "FROM ";
					$sql .= "    t_client ";
					$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
					$sql .= "WHERE ";
					$sql .= "    t_client.client_id = $cshop_id;";
					$r_result = Db_Query($db_con,$sql);
					$group_kind = pg_fetch_result($r_result,0,0);
					$rank_code  = pg_fetch_result($r_result,0,1);

					//アイテムの在庫単価取得
					$sql  = "SELECT ";
					$sql .= "   t_price.r_price ";
					$sql .= " FROM";
    				$sql .= "   t_goods INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id ";
					$sql .= " WHERE ";
					$sql .= "    t_goods.goods_id = ".$data_list[$i][9];
					$sql .= " AND";
    				$sql .= "    t_goods.accept_flg = '1' ";
					$sql .= " AND";
				    //直営判定
					if($group_kind == '2'){
						//直営
					    $sql .= "    t_price.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code') \n";
					}else{
						//FC
						//代行判定
						if($trust_id != NULL){
					    	$sql .= "    t_price.shop_id = $trust_id  \n";
						}else{
							$sql .= "    t_price.shop_id = $cshop_id  \n";
						}
					}
					$sql .= " AND ";
					//本部判定
					if($item_data[0][2] == 't'){
						//本部商品
						$sql .= "    t_goods.public_flg = 't' ";
					}else{
						//自社商品
						$sql .= "    t_goods.public_flg = 'f' ";
					}
					$sql .= " AND";
				    $sql .= "    t_price.rank_cd = '3';";
					$result = Db_Query($db_con, $sql);
					$buy_data = Get_Data($result,3);
					$buy_price = $buy_data[0][0];
				}
			}

			//本体商品指定判定
			$body_data = NULL;
			if($data_list[$i][18] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$data_list[$i][18].";";
				$result = Db_Query($db_con, $sql);
				$body_data = Get_Data($result,3);
			}

			//消耗品指定判定
			$egoods_data = NULL;
			if($data_list[$i][21] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$data_list[$i][21].";";
				$result = Db_Query($db_con, $sql);
				$egoods_data = Get_Data($result,3);
			}

			$sql  = "INSERT INTO t_aorder_d (\n";
			$sql .= "    aord_d_id,\n";            //受注データID
			$sql .= "    aord_id,\n";              //受注ID
			$sql .= "    line,\n";                 //行
			$sql .= "    sale_div_cd,\n";          //販売区分コード
			$sql .= "    serv_print_flg,\n";       //サービス印字フラグ
			$sql .= "    serv_id,\n";              //サービスID
			$sql .= "    set_flg,\n";              //一式フラグ
			$sql .= "    goods_print_flg,\n";      //アイテム印字フラグ
			$sql .= "    goods_id,\n";             //アイテム商品ID
			$sql .= "    goods_name,\n";           //アイテム名
			$sql .= "    num,\n";                  //アイテム数
			$sql .= "    tax_div,\n";              //課税区分
			$sql .= "    buy_price,\n";            //仕入単価
			$sql .= "    cost_price,\n";           //営業原価
			$sql .= "    sale_price,\n";           //売上単価
			$sql .= "    buy_amount,\n";           //仕入金額
			$sql .= "    cost_amount,\n";          //営業金額
			$sql .= "    sale_amount,\n";          //売上金額
			$sql .= "    rgoods_id,\n";            //本体商品ID
			$sql .= "    rgoods_name,\n";          //本体商品名
			$sql .= "    rgoods_num,\n";           //本体数
			$sql .= "    egoods_id,\n";            //消耗品ID
			$sql .= "    egoods_name,\n";          //消耗品名
			$sql .= "    egoods_num,\n";           //消耗品数
			$sql .= "    contract_id,\n";          //契約情報ID
			$sql .= "    account_price,\n";        //口座単価
			$sql .= "    account_rate,\n";         //口座率
			$sql .= "    trust_trade_price,\n";    //営業原価(受託)
			$sql .= "    trust_trade_amount, \n";  //営業金額(受託)

			//履歴用
			$sql .= "    serv_name, \n";           //サービス名
			$sql .= "    serv_cd, \n";             //サービスCD
			$sql .= "    goods_cd, \n";            //アイテムCD
			$sql .= "    rgoods_cd, \n";           //本体CD
			$sql .= "    egoods_cd \n";            //消耗品CD

			$sql .= ")VALUES(\n";
			$sql .= "    $aord_d_id,\n";
			$sql .= "    $aord_id,\n";
			$sql .= "    ".$data_list[$i][2].",\n";                                                 
			$sql .= "    '".$data_list[$i][4]."',\n";                                     
			$sql .= "    '".$data_list[$i][6]."',\n";
			//サービスID
			if($data_list[$i][5] != NULL){                                     
				$sql .= "    ".$data_list[$i][5].",\n";
			}else{
				$sql .= "    NULL,\n";
			}                                       
			$sql .= "    '".$data_list[$i][7]."',\n";                                     
			$sql .= "    '".$data_list[$i][8]."',\n";
			//アイテム商品ID
			if($data_list[$i][9] != NULL){                                     
				$sql .= "    ".$data_list[$i][9].",\n";  
			}else{
				$sql .= "    NULL,\n";
			}                                     
			$sql .= "    '".$data_list[$i][10]."',\n";  
			//アイテム数
			if($data_list[$i][11] != NULL){                                   
				$sql .= "    ".$data_list[$i][11].",\n"; 
			}else{
				$sql .= "    NULL,\n";
			}
			//課税区分判定
			if($data_list[$i][12] == NULL){
				//アイテムの課税区分が無い場合は、サービスの課税区分を登録
				$serv_sql  = "SELECT tax_div FROM t_serv WHERE serv_id = ".$data_list[$i][5].";\n";
				$result = Db_Query($db_con, $serv_sql);
				$serv_tax_div = pg_fetch_result($result,0,0);
				$sql .= "    '$serv_tax_div',\n";

				//受託先判定
				if($trust_id != NULL){
					//仕入単価には営業原価(受託先)を登録
					$sql .= "    ".$data_list[$i][39].",\n"; 
				}else{
					//仕入単価には営業原価を登録
					$sql .= "    ".$data_list[$i][14].",\n"; 
				} 
			}else{
				//アイテムの課税区分
				$sql .= "    '".$data_list[$i][12]."',\n";
				//仕入単価指定判定
				if($buy_price != NULL){
					$sql .= "    ".$buy_price.",\n";    
				}else{
					$sql .= "    NULL,\n";
				}
			}                                                                              
			$sql .= "    ".$data_list[$i][14].",\n";                                       
			$sql .= "    ".$data_list[$i][15].",\n";                                       
	                                                 
			//仕入金額判定
			if($buy_price != NULL){
				//仕入金額計算処理
				$buy_amount = bcmul($buy_price,$data_list[$i][11],2);
			    $buy_amount = Coax_Col($coax, $buy_amount);                                    
				$sql .= "    $buy_amount,\n";  
			}else{
				//アイテム商品指定判定
				if($data_list[$i][9] != NULL){
					//アイテムはあるが在庫単価がない
 
					//仕入金額には0を登録                                   
					$sql .= "    0,\n";
				}else{

					//受託先判定
					if($trust_id != NULL){
						//サービスのみは、営業金額(受託先)を入れる
						$sql .= "    ".$data_list[$i][40].",\n";
					}else{
						//サービスのみは、営業金額を入れる
						$sql .= "    ".$data_list[$i][16].",\n";
					}  
				}  
			}

			$sql .= "    ".$data_list[$i][16].",\n";   
			$sql .= "    ".$data_list[$i][17].",\n";   
			//本体商品ID
			if($data_list[$i][18] != NULL){                                    
				$sql .= "    ".$data_list[$i][18].",\n";  
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$data_list[$i][19]."',\n";  
			//本体数
			if($data_list[$i][20] != NULL){                                   
				$sql .= "    ".$data_list[$i][20].",\n";  
			}else{
				$sql .= "    NULL,\n";
			}                                     

			//消耗品ID
			if($data_list[$i][21] != NULL){                                    
				$sql .= "    ".$data_list[$i][21].",\n";  
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$data_list[$i][22]."',\n";  
			//消耗品数
			if($data_list[$i][23] != NULL){                                   
				$sql .= "    ".$data_list[$i][23].",\n";  
			}else{
				$sql .= "    NULL,\n";
			}                                     
			$sql .= "    ".$data_list[$i][3].",\n";
			//口座単価 
			if($data_list[$i][34] != NULL){  
				$sql .= "    ".$data_list[$i][34].",\n";
			}else{
				$sql .= "    NULL,\n";
			}   
			$sql .= "    '".$data_list[$i][35]."', \n"; 

			//営業(受託)存在判定
			if($data_list[$i][39] != NULL){
				$sql .= "    ".$data_list[$i][39].",\n"; 
				$sql .= "    ".$data_list[$i][40].",\n"; 
			}else{
				$sql .= "    NULL,\n"; 
				$sql .= "    NULL,\n"; 
			}
			
			//履歴用
			$sql .= "    '".$serv_data[0][0]."', \n"; 
			$sql .= "    '".$serv_data[0][1]."', \n"; 
			$sql .= "    '".$item_data[0][0]."', \n"; 
			$sql .= "    '".$body_data[0][0]."', \n"; 
			$sql .= "    '".$egoods_data[0][0]."'); \n"; 

			$result = Db_Query($db_con, $sql);
	        if($result == false){
				Db_Query($db_con, "ROLLBACK");
			    exit;
	        }

			/****************************/
			//内訳テーブル登録
			/****************************/
			for($d=1;$d<=5;$d++){
				//内訳テーブルに登録されているか判定SQL
				$sql  = "SELECT ";
				$sql .= "    goods_id,";
				$sql .= "    goods_name,";
				$sql .= "    num,";
				$sql .= "    trade_price,";
				$sql .= "    trade_amount,";
				$sql .= "    sale_price,";
				$sql .= "    sale_amount,";
				$sql .= "    trust_trade_price,";
				$sql .= "    trust_trade_amount ";
				$sql .= "FROM ";
				$sql .= "    t_con_detail ";
				$sql .= "WHERE ";
				$sql .= "    con_info_id = ".$data_list[$i][32];
				$sql .= " AND ";
				$sql .= "    line = $d;";
				$result = Db_Query($db_con, $sql);
				$detail_list = Get_Data($result,3);	

				//契約内容ID存在判定
				if($detail_list[0][0] != NULL){

					//履歴用カラムデータ取得
					$sql  = "SELECT ";
					$sql .= "    t_goods.goods_cd ";    
					$sql .= "FROM ";
					$sql .= "    t_goods ";
					$sql .= "WHERE ";
					$sql .= "    t_goods.goods_id = ".$detail_list[0][0].";";
					$result = Db_Query($db_con, $sql);
					$detail_data = Get_Data($result,3);

					$sql  = "INSERT INTO t_aorder_detail( ";
					$sql .= "    aord_d_id,";
					$sql .= "    line,";
					$sql .= "    goods_id,";
					$sql .= "    goods_name,";
					$sql .= "    num,";
					$sql .= "    trade_price,";
					$sql .= "    trade_amount,";
					$sql .= "    sale_price,";
					$sql .= "    sale_amount,";
					$sql .= "    trust_trade_price,";
					$sql .= "    trust_trade_amount,";
					$sql .= "    goods_cd ";
					$sql .= "    )VALUES(";
					$sql .= "    $aord_d_id,";                      //受注データID
					$sql .= "    $d,";
					$sql .= "    ".$detail_list[0][0].",";          //商品ID
					$sql .= "    '".$detail_list[0][1]."',";        //商品名
					$sql .= "    ".$detail_list[0][2].",";          //数量
					$sql .= "    ".$detail_list[0][3].",";          //営業原価
					$sql .= "    ".$detail_list[0][4].",";          //営業金額
					$sql .= "    ".$detail_list[0][5].",";          //売上単価
					$sql .= "    ".$detail_list[0][6].",";          //売上金額
					//営業(受託)存在判定
					if($detail_list[0][7] != NULL){
						$sql .= "    ".$detail_list[0][7].",";      //営業原価(受託先)
						$sql .= "    ".$detail_list[0][8].",";      //営業金額(受託先)
					}else{
						$sql .= "    NULL,"; 
						$sql .= "    NULL,"; 
					}
					$sql .= "    '".$detail_data[0][0]."'";         //商品CD
					$sql .= ");";
					$result = Db_Query($db_con, $sql);
					if($result === false){
						Db_Query($db_con, "ROLLBACK");
					    exit;
					}
				}
			}

			/****************************/
			//出庫品・受払テーブル登録
			/****************************/
			//契約内容IDのデータ全て取得
			$sql  = "SELECT ";
			$sql .= "    goods_id,";
			$sql .= "    goods_name,";
			$sql .= "    num ";
			$sql .= "FROM ";
			$sql .= "    t_con_ship ";
			$sql .= "WHERE ";
			$sql .= "    con_info_id = ".$data_list[$i][32].";";
			$result = Db_Query($db_con, $sql);
			$ship_list = Get_Data($result,3);	

			for($d=0;$d<count($ship_list);$d++){

				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$ship_list[$d][0].";";
				$result = Db_Query($db_con, $sql);
				$ship_data = Get_Data($result,3);

				$sql  = "INSERT INTO t_aorder_ship( ";
				$sql .= "    aord_d_id,";
				$sql .= "    goods_id,";
				$sql .= "    goods_name,";
				$sql .= "    num,";
				$sql .= "    goods_cd ";
				$sql .= "    )VALUES(";
				$sql .= "    $aord_d_id,";                     //受注データID
				$sql .= "    ".$ship_list[$d][0].",";          //商品ID
				$sql .= "    '".$ship_list[$d][1]."',";        //商品名
				$sql .= "    ".$ship_list[$d][2].",";          //数量
				$sql .= "    '".$ship_data[0][0]."'";          //商品CD
				$sql .= ");";
				$result = Db_Query($db_con, $sql);
				if($result === false){
					Db_Query($db_con, "ROLLBACK");
				    exit;
				}

				//通常・オンライン代行のみ受払登録
				if($data_list[$i][36] != '3'){
					/****************************/                                                   
					//受払テーブルに登録関数                                                     
					/****************************/
					$result = Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship_list[$d][0],$ship_list[$d][2],'keiyaku',$data_list[$i][37]);
				}
			}

			//受注ヘッダーに原価金額・売上金額・消費税額を登録する受注ID取得
			$update_id[] = $aord_id; 
		}                                              
	}                                                                                
      
	/****************************/                                                   
	//受注ヘッダー（原価金額・売上金額・消費税額）登録処理                                                           
	/****************************/
	for($j=0;$j<count($update_id);$j++){

		//受注データ取得
	    $sql  = "SELECT ";
		$sql .= "    tax_div,";            //課税区分0
		$sql .= "    cost_amount,";        //営業金額1
		$sql .= "    sale_amount,";        //売上金額2
		$sql .= "    trust_trade_amount,"; //営業金額(受託先)3
		$sql .= "    account_price,";      //口座単価4
		$sql .= "    account_rate ";       //口座率5
		$sql .= "FROM ";
		$sql .= "    t_aorder_d ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = ".$update_id[$j].";";
		$result = Db_Query($db_con, $sql);
		$m_data = Get_Data($result,3);

		/*
		 * 履歴：
		 * 　日付　　　　B票No.　　担当者　　　内容　
		 * 　2006/11/01　01-010　　suzuki-t　 紹介料の計算に紹介者ではなく得意先のの丸め区分を使っていたのを修正
		 *
		*/
		//紹介者の丸め区分を取得
		if($client_ac_id != null){
		    $sql  = "SELECT ";
		    $sql .= "    coax  ";       //丸め区分
		    $sql .= "FROM ";
		    $sql .= "    t_client ";
		    $sql .= "WHERE ";
		    $sql .= "    client_id = $client_ac_id;";
		    $result = Db_Query($db_con, $sql);
		    $intro_account_coax = pg_fetch_result($result,0,0);  //紹介者の丸め区分     
		}

		//ヘッダーに掛かるデータの金額を取得
		//合計金額の計算に使用する配列を初期化
		$tax_div = NULL;
		$cost_data = NULL;
		$sale_data = NULL;
		$trust_data = NULL;
		$intro_amount = NULL;

		for($c=0;$c<count($m_data);$c++){
			$tax_div[$c]    = $m_data[$c][0];
			$cost_data[$c]  = $m_data[$c][1];
			$sale_data[$c]  = $m_data[$c][2];
			
			//営業金額指定判定
			if($m_data[$c][3] != NULL){
				$trust_data[$c] = $m_data[$c][3];
			}

			//紹介料計算処理
			if($m_data[$c][4] != NULL){
				//口座単価
				$intro_amount = bcadd($intro_amount,$m_data[$c][4]); 
			}else if($m_data[$c][5] != NULL && $m_data[$c][5] > 0){
				//口座率
				$rate_money = bcmul($m_data[$c][2],bcdiv($m_data[$c][5],100,2),2);
				$rate_money = Coax_Col($intro_account_coax,$rate_money);
				$intro_amount = bcadd($intro_amount,$rate_money); 
			}
		}

		//営業金額の合計処理
		$total_money = Total_Amount($cost_data, $tax_div,$coax,$tax_franct,$tax_num,$client_id,$db_con);
		$cost_money  = $total_money[0];

		//営業金額（受託先）の合計処理
		if($trust_data != NULL){
			$total_money  = Total_Amount($trust_data, $tax_div,$coax,$tax_franct,$tax_num,$client_id,$db_con);
			$trust_money  = $total_money[0];
		}

		//売上金額・消費税額の合計処理
		$total_money = Total_Amount($sale_data, $tax_div,$coax,$tax_franct,$tax_num,$client_id,$db_con);
		$sale_money  = $total_money[0];
		$sale_tax    = $total_money[1];
    
		//得意先紹介料指定判定
		if($client_ac_price != NULL || ($client_ac_rate != NULL && $client_ac_rate > 0)){
			$intro_amount = NULL;

			//紹介料計算処理
			if($client_ac_price != NULL){
				//口座単価
				$intro_amount = $client_ac_price; 
			}else if($client_ac_rate != NULL && $client_ac_rate > 0){
				//口座率
				$rate_money = bcmul($sale_money,bcdiv($client_ac_rate,100,2),2);
				$rate_money = Coax_Col($intro_account_coax,$rate_money);
				$intro_amount = $rate_money; 
			}
		}

		$sql  = "UPDATE t_aorder_h SET ";
		$sql .= "    cost_amount = $cost_money,";        //営業金額
		$sql .= "    net_amount = $sale_money,";         //売上金額
		$sql .= "    tax_amount = $sale_tax,";           //消費税
		//営業金額指定判定
		if($trust_money != NULL){
			$sql .= "    trust_cost_amount = $trust_money, "; //営業金額(税抜)
		}else{
			$sql .= "    trust_cost_amount = NULL, ";         //営業金額(税抜)
		}
		//紹介料指定判定
		if($intro_amount != NULL){
			$sql .= "    intro_amount = $intro_amount ";     //紹介料
		}else{
			$sql .= "    intro_amount = NULL ";              //紹介料
		}
		$sql .= "WHERE ";
		$sql .= "    aord_id = ".$update_id[$j].";";
		
		$result = Db_Query($db_con, $sql);
	    if($result == false){
			Db_Query($db_con, "ROLLBACK");
		    exit;
	    }
	}
}


 /**
 * 受払テーブル登録
 *
 * 変更履歴
 * (2006/06/05) 新規作成(suzuki-t)
 * (2006/10/13) 略称を追加(suzuki-t)
 * (2006/10/17) 出荷倉庫抽出変更(suzuki-t)
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $cshop_id       担当支店ID
 * @param               string      $client_id      得意先ID
 * @param               string      $aord_id        受払テーブルに登録する受注ID
 * @param               string      $aord_d_id      受払テーブルに登録する受注データID
 * @param               string      $goods_id       受払テーブルに登録する商品ID
 * @param               string      $goods_num      受払テーブルに登録する数量
 * @param               string      $ware_flg       受払テーブルに登録する倉庫識別
 * @param               string      $act_id         受払テーブルに登録する代行ID
 *
 *
 *
 */

function Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$goods_id,$goods_num,$ware_flg,$act_id=NULL){

	/****************************/
	//外部変数取得
	/****************************/
	//$staff_id    = $_SESSION["staff_id"];   //ログイン者ID
	$staff_id    = 8;

	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.client_cname ";    //略称
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.aord_id = $aord_id;";
	$result = Db_Query($db_con, $sql);
	$cleint_list = Get_Data($result,3);

	//倉庫ID判定
	if($ware_flg == 'reason'){
		//予定データ訂正から登録

		/****************************/
		//受注情報取得
		/****************************/
		$sql  = "SELECT";
		$sql .= "   ware_id ";
		$sql .= " FROM";
		$sql .= "   t_aorder_h ";
		$sql .= " WHERE";

		/*
		 * 履歴：
		 * 　日付　　　　B票No.　　　　担当者　　　内容　
		 * 　2006/10/17　0185　　　　　suzuki-t　　出荷倉庫を抽出する条件に受注ID追加
		 *
		 */
		$sql .= "   aord_id = $aord_id ";
		$sql .= " AND ";


		//代行判定
		if($act_id != NULL){
			//代行
			$sql .= "   shop_id = $act_id";
		}else{
			//直営
			$sql .= "   shop_id = $cshop_id";
		}
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		Get_Id_Check($result);
		$data_list = Get_Data($result);
		$ware_id        = $data_list[0][0];        //出荷倉庫ID
	}else{
		//契約登録から登録

		/****************************/
		//ログインユーザ情報取得処理
		/****************************/
		//得意先の情報を抽出
		$sql  = "SELECT";
		$sql .= "   t_ware.ware_id ";
		$sql .= " FROM";
		$sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
		$sql .= " WHERE";
		//代行判定
		if($act_id != NULL){
			//代行
			$sql .= "   client_id = $act_id";
		}else{
			//直営
			$sql .= "   client_id = $cshop_id";
		}
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		Get_Id_Check($result);
		$data_list = Get_Data($result);
		$ware_id        = $data_list[0][0];        //出荷倉庫ID
	}

	/****************************/                                                   
	//受払テーブルに登録                                                     
	/****************************/
	//受払に登録するデータ取得
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.ord_time ";    //巡回日
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.aord_id = $aord_id;";
	$result = Db_Query($db_con, $sql);
	$stock_data = Get_Data($result);

	$sql  = " INSERT INTO t_stock_hand (";
	$sql .= "    goods_id,";
	$sql .= "    enter_day,";
	$sql .= "    work_day,";   
	$sql .= "    work_div,";
	$sql .= "    client_id,";
	$sql .= "    client_cname,";
	$sql .= "    ware_id,";
	$sql .= "    io_div,";
	$sql .= "    num,";
	$sql .= "    aord_d_id,";
	$sql .= "    staff_id,";
	$sql .= "    shop_id";
	$sql .= ")VALUES(";
	$sql .= "    $goods_id,";
	$sql .= "    NOW(),";
	$sql .= "    '".$stock_data[0][0]."',";
	$sql .= "    '1',";
	$sql .= "    $client_id,";
	$sql .= "    '".$cleint_list[0][0]."',";
	$sql .= "    $ware_id,";
	$sql .= "    '2',";
	$sql .= "    $goods_num,";
	$sql .= "    $aord_d_id,";
	//CRON判定
	if($staff_id != NULL){
		//作業者
		$sql .= "    $staff_id,";
	}else{
		//CRONの場合は、作業者指定なし
		$sql .= "    NULL,";
	}
	//代行判定
	if($act_id != NULL){
		//代行
		$sql .= "    $act_id";
	}else{
		//担当支店のショップID
		$sql .= "    $cshop_id";
	}
	$sql .= ");";

	$result = Db_Query($db_con, $sql);
	if($result == false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}
}

/****************************/
//構成品の単価取得関数
/****************************/

 /**
 * 構成品の単価取得
 *
 * 変更履歴
 * 1.0.0 (2006/10/06) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/10/06)
 *
 * @param               string      $db_con           DBオブジェクト
 * @param               string      $client_h_id      ショップID
 * @param               string      $goods_id         構成品親ID

 *
 * @return              array       $price_array[0]   営業原価
 *                                  $price_array[1]   売上単価
 *                                  $price_array[2]   在庫単価
 *
 *                      子に単価が設定されていなかったら、falseを返す
 */

function Compose_price($db_con,$client_h_id,$goods_id){

	//構成品の子の商品情報取得
	$sql  = "SELECT ";
	$sql .= "    parts_goods_id ";                       //構成品ID
	$sql .= "FROM ";
	$sql .= "    t_compose ";
	$sql .= "WHERE ";
	$sql .= "    goods_id = $goods_id;";
	$result = Db_Query($db_con, $sql);
	$goods_parts = Get_Data($result);

	//顧客区分CD取得
	$sql  = "SELECT ";
	$sql .= "    t_rank.group_kind, ";  //グループ種別
	$sql .= "    t_rank.rank_cd ";      //顧客区分CD
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
	$sql .= "WHERE ";
	$sql .= "    t_client.client_id = $client_h_id;";
	$r_result = Db_Query($db_con,$sql);
	$group_kind = pg_fetch_result($r_result,0,0);
	$rank_code  = pg_fetch_result($r_result,0,1);

	//各構成品の単価取得
	$com_c_price = 0;     //構成品親の営業原価
	$com_s_price = 0;     //構成品親の売上単価
	$com_b_price = 0;     //構成品親の在庫単価

	for($i=0;$i<count($goods_parts);$i++){
		$sql  = " SELECT ";
		$sql .= "     t_compose.count,";                       //数量
		$sql .= "     initial_cost.r_price AS initial_price,"; //営業単価
		$sql .= "     sale_price.r_price AS sale_price, ";     //売上単価
		$sql .= "     buy_price.r_price AS buy_price  ";       //在庫単価
		                 
		$sql .= " FROM";
		$sql .= "     t_compose ";

		$sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
		$sql .= "     INNER JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
		$sql .= "     INNER JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";
		$sql .= "     INNER JOIN t_price AS buy_price ON t_goods.goods_id = buy_price.goods_id ";

		$sql .= " WHERE";
		$sql .= "     t_compose.goods_id = $goods_id ";
		$sql .= " AND ";
		$sql .= "     t_compose.parts_goods_id = ".$goods_parts[$i][0];
		$sql .= " AND ";
		$sql .= "     initial_cost.rank_cd = '2' ";
		$sql .= " AND ";
		$sql .= "     sale_price.rank_cd = '4' ";
		$sql .= " AND ";
		$sql .= "     buy_price.rank_cd = '3' ";
		$sql .= " AND ";
		//直営判定
		if($group_kind == "2"){
			//直営
			$sql .= "     buy_price.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code') ";
			$sql .= " AND ";
	        $sql .= "     initial_cost.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code') ";
	    }else{
			//FC
			$sql .= "     buy_price.shop_id = $client_h_id  \n";
			$sql .= " AND ";
	        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
	    }
		$sql .= " AND  \n";
		//直営判定
		if($group_kind == "2"){
			//直営
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code')); \n";
		}else{
			//FC
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id); \n";
		}
		$result = Db_Query($db_con, $sql);
		$com_data = Get_Data($result);

		//構成品の子に単価が設定されていないか判定
		if($com_data == NULL){
			return false;   
		}

		//構成品親の営業単価計算配列に追加(子の数量×子の営業原価)
		$com_cp_amount = bcmul($com_data[0][0],$com_data[0][1],2);
	    $com_cp_amount = Coax_Col($coax, $com_cp_amount);
		$com_c_price = $com_c_price + $com_cp_amount;
		//構成品親の売上単価計算配列に追加(子の数量×子の売上単価)
		$com_sp_amount = bcmul($com_data[0][0],$com_data[0][2],2);
	    $com_sp_amount = Coax_Col($coax, $com_sp_amount);
		$com_s_price = $com_s_price + $com_sp_amount;
		//構成品親の在庫単価計算配列に追加(子の数量×子の在庫単価)
		$com_bp_amount = bcmul($com_data[0][0],$com_data[0][3],2);
	    $com_bp_amount = Coax_Col($coax, $com_bp_amount);
		$com_b_price = $com_b_price + $com_bp_amount;
	}

	$price_array[0] = $com_c_price;  //親の営業原価
	$price_array[1] = $com_s_price;  //親の売上単価
	$price_array[2] = $com_b_price;  //親の在庫単価

	return $price_array;
}

?>
