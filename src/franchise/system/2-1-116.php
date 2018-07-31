<?php
/****************************
 * 変更履歴
 *  　・(2006-07-27)商品マスタの構成変更に伴い、抽出条件を変更＜watanabe-k＞
 *  　・(2006-09-11) 売上伝票（訂正）から来るように変更＜kaji＞
 *  　・(2006-10-27) 内訳画面の戻るボタン押下処理変更＜suzuki＞
 *   (2006/11/16) (suzuki)
 *     ・構成品の子に単価が設定されていなかったら表示しないように修正
 *    ・ (2006/12/01) 代行伝票の営業原価は委託先の丸めを使用(suzuki)
 *
 *
*****************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-14      0060        suzuki      代行伝票登録時に、内訳の営業原価計算処理追加
*/

//$page_title = "契約マスタ";
//環境設定ファイル
require_once("ENV_local.php");

//DBに接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//外部変数取得
/****************************/
$client_id   = $_GET["client_id"];      //得意先
$flg         = $_GET["flg"];            //追加・更新判別フラグ
$get_con_id  = $_GET["contract_id"];    //契約情報ID
$row         = $_GET["break_row"];      //契約登録の行番号
$client_h_id = $_SESSION["client_id"];  //ログインユーザID
$rank_cd     = $_SESSION["fc_rank_cd"]; //顧客区分コード
$staff_id    = $_SESSION["staff_id"];   //ログイン者ID
$group_kind  = $_SESSION["group_kind"]; //グループ種別

//得意先IDをhiddenにより保持する
if($_GET["client_id"] != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

//追加・更新判別フラグをhiddenにより保持する
if($_GET["flg"] != NULL){
	$con_data2["hdn_flg"] = $flg;
}else{
	$flg = $_POST["hdn_flg"];
}

//契約情報IDをhiddenにより保持する
if($_GET["contract_id"] != NULL){
	$con_data2["hdn_con_id"] = $get_con_id;
}else{
	$get_con_id = $_POST["hdn_con_id"];
}

//契約登録の行番号をhiddenにより保持する
if($_GET["break_row"] != NULL){
	$con_data2["hdn_row"] = $row;
}else{
	$row = $_POST["hdn_row"];
}

//不正判定
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);

/****************************/
//ダイアログ表示処理
/****************************/
$get_con_id2  = $_GET["select_id"];     //概要から渡したID1
$get_info_id  = $_GET["select_id2"];    //概要から渡したID2
$get_id3      = $_GET["select_id3"];    //概要から渡したID3

if($get_id3 == "sale"){
    $page_title = "予定データ明細";
}elseif($get_id3 == "sale_h"){
    $page_title = "売上伝票";
}else{
    $page_title = "契約マスタ";
}

//遷移元判定
if($get_info_id != NULL){
	//契約概要からダイアログ表示

	//ＧＥＴ情報不正判定
	Get_ID_Check2($get_con_id2);
	Get_ID_Check2($get_info_id);

	//契約・受注判定
	if($get_id3 == "sale" || $get_id3 == "sale_h"){

		/****************************/
		//受注データテーブル
		/****************************/
		if($get_id3 == "sale"){
			//FC側の代行伝票表示判定
			$sql  = "SELECT ";
			$sql .= "    act_id ";
			$sql .= "FROM ";
			$sql .= "    t_aorder_h ";
			$sql .= "WHERE ";
			$sql .= "    aord_id = $get_info_id;";
			$result = Db_Query($db_con, $sql);
			$check_data = Get_Data($result);

			$sql  = "SELECT ";
			$sql .= "    t_aorder_d.line,";           //行数
			$sql .= "    t_aorder_d.serv_id,";        //サービスID
			$sql .= "    t_goods.goods_cd,";          //商品CD
			$sql .= "    t_aorder_d.goods_name,";     //略称
			$sql .= "    t_aorder_d.num, ";           //アイテム数
			//FC側の代行伝票表示判定
			if($check_data[0][0] != NULL && $group_kind == 3){
				//ＦＣ側の代行伝票
				$sql .= "    t_aorder_d.trust_trade_price,";    //営業原価(受託先) 
			}else{
				//通常伝票・オフライン代行伝票・直営側のオンライン代行伝票
				$sql .= "    t_aorder_d.cost_price,";           //営業原価
			}
			$sql .= "    t_aorder_d.sale_price,";     //売上単価
			//FC側の代行伝票表示判定
			if($check_data[0][0] != NULL && $group_kind == 3){
				//ＦＣ側の代行伝票
				$sql .= "    t_aorder_d.trust_trade_amount,";    //営業金額(受託先) 
			}else{
				//通常伝票・オフライン代行伝票・直営側のオンライン代行伝票
				$sql .= "    t_aorder_d.cost_amount,";           //営業金額
			}
			$sql .= "    t_aorder_d.sale_amount ";    //売上金額
			$sql .= "FROM ";
			$sql .= "    t_aorder_d ";
			$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    aord_d_id = $get_con_id2;";
		}else{
			$sql  = "SELECT ";
			$sql .= "    t_sale_d.line,";           //行数
			$sql .= "    t_sale_d.serv_id,";        //サービスID
			$sql .= "    t_goods.goods_cd,";          //商品CD
			$sql .= "    t_sale_d.goods_name,";     //略称
			$sql .= "    t_sale_d.num, ";           //アイテム数
			$sql .= "    t_sale_d.cost_price,";    //営業原価
			$sql .= "    t_sale_d.sale_price,";     //売上単価
			$sql .= "    t_sale_d.cost_amount,";   //営業金額
			$sql .= "    t_sale_d.sale_amount ";    //売上金額
			$sql .= "FROM ";
			$sql .= "    t_sale_d ";
			$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_sale_d.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    sale_d_id = $get_con_id2;";
		}
		$result = Db_Query($db_con, $sql);
		$info_data = Get_Data($result);

		$row = $info_data[0][0];        //受注データの行番号
		
		$serv_id = $info_data[0][1];    //サービスID
		//サービスが指定されているか判定
		if($serv_id != NULL){
			$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
			$result = Db_Query($db_con, $sql); 
			$data_list = Get_Data($result);
			$serv_name = $data_list[0][0];
		}

		$main_goods_cd = $info_data[0][2];     //アイテムCD
	 	$main_goods_name = $info_data[0][3];   //アイテム名
		$main_goods_num = number_format($info_data[0][4]);    //アイテム数

		//営業単価
		$th_price = explode('.', $info_data[0][5]);
		if($th_price[1] == null){
		    $th_price[1] = '00';
		}
		$main_trade_price = $th_price[0].".".$th_price[1];
		$main_trade_price = number_format($main_trade_price,2);

		//売上単価
		$sh_price = explode('.', $info_data[0][6]);
		if($sh_price[1] == null){
		    $sh_price[1] = '00';
		}
		$main_sale_price = $sh_price[0].".".$sh_price[1];
		$main_sale_price = number_format($main_sale_price,2);

		//営業金額
		$main_trade_amount = number_format($info_data[0][7]);
		//売上金額
		$main_sale_amount = number_format($info_data[0][8]);
		
		/****************************/
		//内訳テーブル
		/****************************/
		if($get_id3 == "sale"){
			$sql  = "SELECT ";
			$sql .= "    t_aorder_detail.line,";          //行
			$sql .= "    t_aorder_detail.goods_id,";      //商品ID
			$sql .= "    t_goods.goods_cd,";              //商品CD
			$sql .= "    t_goods.name_change,";           //品名変更
			$sql .= "    t_aorder_detail.goods_name,";    //略称
			$sql .= "    t_aorder_detail.num,";           //数量
			//FC側の代行伝票表示判定
			if($check_data[0][0] != NULL && $group_kind == 3){
				//ＦＣ側の代行伝票
				$sql .= "    t_aorder_detail.trust_trade_price,"; //営業原価(受託先) 
			}else{
				//通常伝票・オフライン代行伝票・直営側のオンライン代行伝票
				$sql .= "    t_aorder_detail.trade_price,";       //営業原価
			}
			$sql .= "    t_aorder_detail.sale_price,";    //売上単価
			//FC側の代行伝票表示判定
			if($check_data[0][0] != NULL && $group_kind == 3){
				//ＦＣ側の代行伝票
				$sql .= "    t_aorder_detail.trust_trade_amount,"; //営業金額(受託先) 
			}else{
				//通常伝票・オフライン代行伝票・直営側のオンライン代行伝票
				$sql .= "    t_aorder_detail.trade_amount,";       //営業金額  
			} 
			$sql .= "    t_aorder_detail.sale_amount ";   //売上金額
			$sql .= "FROM ";
			$sql .= "    t_aorder_detail ";
			$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_aorder_detail.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    t_aorder_detail.aord_d_id = $get_con_id2;";  
		}else{
			$sql  = "SELECT ";
			$sql .= "    t_sale_detail.line,";          //行
			$sql .= "    t_sale_detail.goods_id,";      //商品ID
			$sql .= "    t_goods.goods_cd,";              //商品CD
			$sql .= "    t_goods.name_change,";           //品名変更
			$sql .= "    t_sale_detail.goods_name,";    //略称
			$sql .= "    t_sale_detail.num,";           //数量
			$sql .= "    t_sale_detail.trade_price,";   //営業原価
			$sql .= "    t_sale_detail.sale_price,";    //売上単価
			$sql .= "    t_sale_detail.trade_amount,";  //営業金額   
			$sql .= "    t_sale_detail.sale_amount ";   //売上金額
			$sql .= "FROM ";
			$sql .= "    t_sale_detail ";
			$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_sale_detail.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    t_sale_detail.sale_d_id = $get_con_id2;";
		}
		$result = Db_Query($db_con, $sql);
		$detail_data = Get_Data($result,2);

		//受注データIDに該当するデータが存在するか
		for($d=0;$d<count($detail_data);$d++){
			$search_line2 = $detail_data[$d][0];                                  //復元する行
			$con_data["hdn_bgoods_id"][$row][$search_line2]      = $detail_data[$d][1]; //商品ID
			$con_data["break_goods_cd"][$row][$search_line2]     = $detail_data[$d][2]; //商品CD
			$con_data["hdn_bname_change"][$row][$search_line2]   = $detail_data[$d][3]; //品名変更
			$con_data["break_goods_name"][$row][$search_line2]   = $detail_data[$d][4]; //略称
			$con_data["break_goods_num"][$row][$search_line2]    = number_format($detail_data[$d][5]); //数量

			$t_price = explode('.', $detail_data[$d][6]);
			$con_data["break_trade_price"][$row][$search_line2]["1"] = number_format($t_price[0]);     //営業原価
			$con_data["break_trade_price"][$row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : '00';     

			$s_price = explode('.', $detail_data[$d][7]);
			$con_data["break_sale_price"][$row][$search_line2]["1"] = number_format($s_price[0]);     //売上単価
			$con_data["break_sale_price"][$row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

			$con_data["break_trade_amount"][$row][$search_line2] = number_format($detail_data[$d][8]); //営業金額
			$con_data["break_sale_amount"][$row][$search_line2]  = number_format($detail_data[$d][9]); //売上金額
		}

		$form->setDefaults($con_data);
		$form->freeze();
	}else{
		/****************************/
		//契約内容テーブル
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_con_info.line,";           //行数
		$sql .= "    t_con_info.serv_id,";        //サービスID
		$sql .= "    t_goods.goods_cd,";          //商品CD
		$sql .= "    t_con_info.goods_name,";     //略称
		$sql .= "    t_con_info.num, ";           //アイテム数
		$sql .= "    t_con_info.trade_price,";    //営業原価
		$sql .= "    t_con_info.sale_price,";     //売上単価
		$sql .= "    t_con_info.trade_amount,";   //営業金額
		$sql .= "    t_con_info.sale_amount ";    //売上金額
		$sql .= "FROM ";
		$sql .= "    t_con_info ";
		$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_con_info.goods_id ";
		$sql .= "WHERE ";
		$sql .= "    con_info_id = $get_info_id;";
		$result = Db_Query($db_con, $sql);
		$info_data = Get_Data($result);

		$row = $info_data[0][0];        //契約登録の行番号
		
		$serv_id = $info_data[0][1];    //サービスID
		//サービスが指定されているか判定
		if($serv_id != NULL){
			$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
			$result = Db_Query($db_con, $sql); 
			$data_list = Get_Data($result);
			$serv_name = $data_list[0][0];
		}

		$main_goods_cd = $info_data[0][2];     //アイテムCD
	 	$main_goods_name = $info_data[0][3];   //アイテム名
		$main_goods_num = number_format($info_data[0][4]);    //アイテム数

		//営業単価
		$th_price = explode('.', $info_data[0][5]);
		if($th_price[1] == null){
		    $th_price[1] = '00';
		}
		$main_trade_price = $th_price[0].".".$th_price[1];
		$main_trade_price = number_format($main_trade_price,2);

		//売上単価
		$sh_price = explode('.', $info_data[0][6]);
		if($sh_price[1] == null){
		    $sh_price[1] = '00';
		}
		$main_sale_price = $sh_price[0].".".$sh_price[1];
		$main_sale_price = number_format($main_sale_price,2);

		//営業金額
		$main_trade_amount = number_format($info_data[0][7]);
		//売上金額
		$main_sale_amount = number_format($info_data[0][8]);
		
		/****************************/
		//内訳テーブル
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_con_detail.line,";          //行
		$sql .= "    t_con_detail.goods_id,";      //商品ID
		$sql .= "    t_goods.goods_cd,";           //商品CD
		$sql .= "    t_goods.name_change,";        //品名変更
		$sql .= "    t_con_detail.goods_name,";    //略称
		$sql .= "    t_con_detail.num,";           //数量
		$sql .= "    t_con_detail.trade_price,";   //営業原価
		$sql .= "    t_con_detail.sale_price,";    //売上単価
		$sql .= "    t_con_detail.trade_amount,";  //営業金額   
		$sql .= "    t_con_detail.sale_amount ";   //売上金額
		$sql .= "FROM ";
		$sql .= "    t_con_detail ";
		$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_con_detail.goods_id ";
		$sql .= "WHERE ";
		$sql .= "    t_con_detail.con_info_id = $get_info_id;";  
		$result = Db_Query($db_con, $sql);
		$detail_data = Get_Data($result,2);

		//契約内容IDに該当するデータが存在するか
		for($d=0;$d<count($detail_data);$d++){
			$search_line2 = $detail_data[$d][0];                                  //復元する行
			$con_data["hdn_bgoods_id"][$row][$search_line2]      = $detail_data[$d][1]; //商品ID
			$con_data["break_goods_cd"][$row][$search_line2]     = $detail_data[$d][2]; //商品CD
			$con_data["hdn_bname_change"][$row][$search_line2]   = $detail_data[$d][3]; //品名変更
			$con_data["break_goods_name"][$row][$search_line2]   = $detail_data[$d][4]; //略称
			$con_data["break_goods_num"][$row][$search_line2]    = number_format($detail_data[$d][5]); //数量

			$t_price = explode('.', $detail_data[$d][6]);
			$con_data["break_trade_price"][$row][$search_line2]["1"] = number_format($t_price[0]);     //営業原価
			$con_data["break_trade_price"][$row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : '00';     

			$s_price = explode('.', $detail_data[$d][7]);
			$con_data["break_sale_price"][$row][$search_line2]["1"] = number_format($s_price[0]);     //売上単価
			$con_data["break_sale_price"][$row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

			$con_data["break_trade_amount"][$row][$search_line2] = number_format($detail_data[$d][8]); //営業金額
			$con_data["break_sale_amount"][$row][$search_line2]  = number_format($detail_data[$d][9]); //売上金額
		}

		//代行依頼チェックボックス
		$form->addElement('hidden',"daiko_check", "");

		$form->setDefaults($con_data);
		$form->freeze();
	}

}else{
	//契約登録から遷移

	//ＧＥＴ情報不正判定
	Get_ID_Check2($client_id);
	Get_ID_Check2($flg);
	Get_ID_Check2($row);

	/****************************/
	//hiddenで契約登録の部品定義
	/****************************/
	require_once(INCLUDE_DIR."keiyaku_hidden.inc");

	/****************************/
	//hiddenで変則日の部品定義
	/****************************/
	$date_array = NULL;
	//POSTデータ取得処理
	$year  = date("Y");
	$month = date("m");

	for($i=0;$i<28;$i++){
		//月の日数取得
		$now = mktime(0, 0, 0, $month+$i,1,$year);
		$num = date("t",$now);

		//１年１１ヶ月分データ取得
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
			}
		}
	}

	/****************************/
	//POST情報取得
	/****************************/
	//サービス
	$serv_id = $_POST["form_serv"][$row];
	//サービスが指定されているか判定
	if($serv_id != NULL){
		$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result);
		$serv_name = $data_list[0][0];
	}

	//アイテム
	$main_goods_cd = $_POST["form_goods_cd1"][$row];
	$main_goods_name = stripslashes($_POST["form_goods_name1"][$row]);
	//数量形式判定
	if($_POST["form_goods_num1"][$row] != NULL){
		$main_goods_num = number_format($_POST["form_goods_num1"][$row]);
	}

	//金額
	//営業単価形式変更判定
	if($_POST["form_trade_price"][$row][1] != NULL){
		$trade_1 = number_format($_POST["form_trade_price"][$row][1]);
		$trade_2 = ($_POST["form_trade_price"][$row][2] != null)? $_POST["form_trade_price"][$row][2] : '00';
		$main_trade_price = $trade_1.".".$trade_2;
	}
	//売上単価形式変更判定
	if($_POST["form_sale_price"][$row][1] != NULL){
		$sale_1 = number_format($_POST["form_sale_price"][$row][1]);
		$sale_2 = ($_POST["form_sale_price"][$row][2] != null)? $_POST["form_sale_price"][$row][2] : '00';
		$main_sale_price = $sale_1.".".$sale_2;
	}
	//営業金額形式変更判定
	$main_trade_amount = $_POST["form_trade_amount"][$row];

	//売上金額形式変更判定
	$main_sale_amount = $_POST["form_sale_amount"][$row];

	//内訳戻るボタンをhiddenにより保持する
	if($_POST["return_btn"] == NULL){
		//変更前の内訳データをhiddenにセット
		for($d=1;$d<=5;$d++){
			//オンライン・オフライン代行判定
			if(($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3) && $_POST["hdn_bgoods_id"][$row][$d] != NULL){
				//代行依頼料（売上単価×代行依頼料率）
				$com_s_price = $_POST["break_sale_price"][$row][$d]["1"].".".$_POST["break_sale_price"][$row][$d]["2"];
				$daiko_money = bcmul($com_s_price,bcdiv($_POST["form_daiko_price"],100,2),2);

			    $eigyo_money = explode('.',$daiko_money);

				$def_data["break_trade_price"][$row][$d]["1"] = $eigyo_money[0];

				if($eigyo_money[1] != NULL){
					$def_data["break_trade_price"][$row][$d]["2"] = $eigyo_money[1];
				}else{
					$def_data["break_trade_price"][$row][$d]["2"] = '00';
				}

				//金額計算処理判定
				if($_POST["break_goods_num"][$row][$d] != null){
					//営業金額計算
			        $cost_amount = bcmul($daiko_money, $_POST["break_goods_num"][$row][$d],2);
			        $cost_amount = Coax_Col($coax, $cost_amount);
				}
				$def_data["break_trade_amount"][$row][$d]    = number_format($cost_amount);
			}

			$def_data["return_bgoods_id"][$row][$d]        = $_POST["hdn_bgoods_id"][$row][$d];
			$def_data["return_bname_change"][$row][$d]     = $_POST["hdn_bname_change"][$row][$d];
			$def_data["return_goods_cd"][$row][$d]         = $_POST["break_goods_cd"][$row][$d];
			$def_data["return_goods_name"][$row][$d]       = $_POST["break_goods_name"][$row][$d];
			$def_data["return_goods_num"][$row][$d]        = $_POST["break_goods_num"][$row][$d];
			$def_data["return_trade_price"][$row][$d]["1"] = $_POST["break_trade_price"][$row][$d]["1"];
			$def_data["return_trade_price"][$row][$d]["2"] = $_POST["break_trade_price"][$row][$d]["2"];
			$def_data["return_trade_amount"][$row][$d]     = $_POST["break_trade_amount"][$row][$d];
			$def_data["return_sale_price"][$row][$d]["1"]  = $_POST["break_sale_price"][$row][$d]["1"];
			$def_data["return_sale_price"][$row][$d]["2"]  = $_POST["break_sale_price"][$row][$d]["2"];
			$def_data["return_sale_amount"][$row][$d]      = $_POST["break_sale_amount"][$row][$d];
		}
		$def_data["return_btn"] = true;
		$form->setConstants($def_data);
	}

	/****************************/
	//得意先情報取得
	/****************************/
	//得意先の情報を抽出
	$sql  = "SELECT";
	$sql .= "   t_client.coax ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   client_id = $client_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql); 
	Get_Id_Check($result);
	$data_list = Get_Data($result);
	$coax           = $data_list[0][0];        //丸め区分（商品）

	//POST情報変更
	$con_data2["hdn_coax"]            = $coax;

	/****************************/
	//全件数取得
	/****************************/
	$client_sql  = " SELECT ";
	$client_sql .= "     DISTINCT(t_client.client_id) ";
	$client_sql .= " FROM";
	$client_sql .= "     t_client ";
	$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
	$client_sql .= " WHERE";
	if($_SESSION["group_kind"] == '2'){
	    $client_sql .= "    t_client.shop_id IN (".Rank_Sql().")";
	}else{
	    $client_sql .= "    t_client.shop_id = $client_h_id";
	}
	$client_sql .= "     AND";
	$client_sql .= "     t_client.client_div = '1'";

	//ヘッダーに表示させる全件数
	$count_res = Db_Query($db_con, $client_sql.";");
	$total_count = pg_num_rows($count_res);

	/****************************/
	//商品コード入力
	/****************************/
	if($_POST["goods_search_row"] != null){
		
		//商品データを取得する行
		$search_row = $_POST["goods_search_row"];

		//通常商品・構成品の子取得SQL
		$sql  = " SELECT";
		$sql .= "     t_goods.goods_id,";                      //商品ID
		$sql .= "     t_goods.name_change,";                   //品名変更フラグ
		$sql .= "     t_goods.goods_cd,";                      //商品コード
		$sql .= "     t_goods.goods_cname,";                   //略称
		$sql .= "     initial_cost.r_price AS initial_price,"; //営業単価
		$sql .= "     sale_price.r_price AS sale_price, ";     //売上単価
		$sql .= "     t_goods.compose_flg ";                   //構成品フラグ
		                 
		$sql .= " FROM";
		$sql .= "     t_goods ";

		$sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
		$sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

		$sql .= " WHERE";
		$sql .= "     t_goods.goods_cd = '".$_POST["break_goods_cd"][$row][$search_row]."' ";
		$sql .= " AND ";
		$sql .= "     t_goods.compose_flg = 'f' ";
		$sql .= " AND ";
		$sql .= "     initial_cost.rank_cd = '2' ";
		$sql .= " AND ";
		$sql .= "     sale_price.rank_cd = '4'";
		$sql .= " AND ";
//watanabe-k
        $sql .= "     t_goods.accept_flg = '1'";
        $sql .= " AND ";
        //直製判定
        if($_SESSION[group_kind] == '2'){
            //直営
            $sql .= "     t_goods.state IN (1,3)";
        }else{
            //FC
            $sql .= "     t_goods.state = 1";
        }

        $sql .= " AND\n";

		//直営判定
		if($_SESSION[group_kind] == "2"){
			//直営
	        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
	    }else{
			//FC
	        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
	    }
		$sql .= " AND  \n";
		//直営判定
		if($_SESSION[group_kind] == "2"){
			//直営
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")) \n";
		}else{
			//FC
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id) \n";
		}

		//オンライン・オフライン代行判定
		if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
			$sql .= "AND \n";
			$sql .= "    public_flg = 't' \n";
		}

		$sql .= "UNION ";
		//構成品の親取得SQL
		$sql .= " SELECT";
		$sql .= "     t_goods.goods_id,";                      //商品ID
		$sql .= "     t_goods.name_change,";                   //品名変更フラグ
		$sql .= "     t_goods.goods_cd,";                      //商品コード
		$sql .= "     t_goods.goods_cname,";                   //商品名
		$sql .= "     NULL,";
		$sql .= "     NULL,";
		$sql .= "     t_goods.compose_flg ";                   //構成品フラグ
		$sql .= " FROM";
		$sql .= "     t_goods ";
		$sql .= " WHERE";
		$sql .= "     t_goods.goods_cd = '".$_POST["break_goods_cd"][$row][$search_row]."' ";
		$sql .= " AND ";
		$sql .= "     t_goods.compose_flg = 't' ";
//watanabe-k変更
        $sql .= " AND";
        $sql .= "     t_goods.accept_flg = '1' ";
        $sql .= " AND";

        //直営判定
        if($_SESSION[group_kind] == "2"){
            //直営
            $sql .= " t_goods.state IN (1,3) ";
        }else{
            //FC
            $sql .= " t_goods.state = 1 ";
        }

		//オンライン・オフライン代行判定
		if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
			$sql .= "AND \n";
			$sql .= "    public_flg = 't' \n";
		}

		$result = Db_Query($db_con, $sql.";");

	    $data_num = pg_num_rows($result);
		//データが存在した場合、フォームにデータを表示
		if($data_num == 1){
	    	$goods_data = pg_fetch_array($result);

			$con_data2["hdn_bgoods_id"][$row][$search_row]         = $goods_data[0];   //商品ID

			$con_data2["hdn_bname_change"][$row][$search_row]      = $goods_data[1];   //品名変更フラグ
			$hdn_bname_change[$row][$search_row]                   = $goods_data[1];   //POSTする前に商品名の変更不可判定を行なう為

			$con_data2["break_goods_cd"][$row][$search_row]        = $goods_data[2];   //商品CD
			$con_data2["break_goods_name"][$row][$search_row]      = $goods_data[3];   //略称

			//構成品判定
			if($goods_data[6] == 'f'){
				//構成品ではない

				//原価単価を整数部と少数部に分ける
				$com_c_price = $goods_data[4];
		        $c_price = explode('.', $goods_data[4]);
				$con_data2["break_trade_price"][$row][$search_row]["1"] = $c_price[0];  //営業単価
				$con_data2["break_trade_price"][$row][$search_row]["2"] = ($c_price[1] != null)? $c_price[1] : '00';     

				//売上単価を整数部と少数部に分ける
				$com_s_price = $goods_data[5];
		        $s_price = explode('.', $goods_data[5]);
				$con_data2["break_sale_price"][$row][$search_row]["1"] = $s_price[0];  //売上単価
				$con_data2["break_sale_price"][$row][$search_row]["2"] = ($s_price[1] != null)? $s_price[1] : '00';

				//金額計算処理判定
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//営業金額計算
		            $cost_amount = bcmul($goods_data[4], $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
					//売上金額計算
		            $sale_amount = bcmul($goods_data[5], $_POST["break_goods_num"][$row][$search_row],2);
		            $sale_amount = Coax_Col($coax, $sale_amount);
				
					$con_data2["break_trade_amount"][$row][$search_row]    = number_format($cost_amount);
					$con_data2["break_sale_amount"][$row][$search_row]     = number_format($sale_amount);
				}
			}else{
				//構成品

				//構成品の子の商品情報取得
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                       //構成品ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = ".$goods_data[0].";";
				$result = Db_Query($db_con, $sql);
				$goods_parts = Get_Data($result);

				//各構成品の単価取得
				$com_c_price = 0;     //構成品親の営業原価
				$com_s_price = 0;     //構成品親の売上単価

				for($i=0;$i<count($goods_parts);$i++){
					$sql  = " SELECT ";
					$sql .= "     t_compose.count,";                       //数量
					$sql .= "     initial_cost.r_price AS initial_price,"; //営業単価
					$sql .= "     sale_price.r_price AS sale_price  ";     //売上単価
					                 
					$sql .= " FROM";
					$sql .= "     t_compose ";

					$sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
					$sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

					$sql .= " WHERE";
					$sql .= "     t_compose.goods_id = ".$goods_data[0];
					$sql .= " AND ";
					$sql .= "     t_compose.parts_goods_id = ".$goods_parts[$i][0];
					$sql .= " AND ";
					$sql .= "     initial_cost.rank_cd = '2' ";
					$sql .= " AND ";
					$sql .= "     sale_price.rank_cd = '4'";
					$sql .= " AND ";
					//直営判定
					if($_SESSION[group_kind] == "2"){
						//直営
				        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
				    }else{
						//FC
				        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
				    }
					$sql .= " AND  \n";
					//直営判定
					if($_SESSION[group_kind] == "2"){
						//直営
						$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")); \n";
					}else{
						//FC
						$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id); \n";
					}
					$result = Db_Query($db_con, $sql);
					$com_data = Get_Data($result);
					//構成品の子に単価が設定されていないか判定
					if($com_data == NULL){
						$reset_goods_flg = true;   //入力された商品情報をクリア
					}
	
					//構成品親の営業単価計算配列に追加(子の数量×子の営業原価)
					$com_cp_amount = bcmul($com_data[0][0],$com_data[0][1],2);
		            $com_cp_amount = Coax_Col($coax, $com_cp_amount);
					$com_c_price = $com_c_price + $com_cp_amount;
					//構成品親の売上単価計算配列に追加(子の数量×子の売上単価)
					$com_sp_amount = bcmul($com_data[0][0],$com_data[0][2],2);
		            $com_sp_amount = Coax_Col($coax, $com_sp_amount);
					$com_s_price = $com_s_price + $com_sp_amount;
				}

				//原価単価を整数部と少数部に分ける
		        $cost_price = explode('.', $com_c_price);
				$con_data2["break_trade_price"][$row][$search_row]["1"] = $cost_price[0];  //営業単価
				$con_data2["break_trade_price"][$row][$search_row]["2"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

				//売上単価を整数部と少数部に分ける
		        $sale_price = explode('.', $com_s_price);
				$con_data2["break_sale_price"][$row][$search_row]["1"] = $sale_price[0];  //売上単価
				$con_data2["break_sale_price"][$row][$search_row]["2"] = ($sale_price[1] != null)? $sale_price[1] : '00';

				//金額計算処理判定
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//営業金額計算
		            $cost_amount = bcmul($com_c_price, $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
					//売上金額計算
		            $sale_amount = bcmul($com_s_price, $_POST["break_goods_num"][$row][$search_row],2);
		            $sale_amount = Coax_Col($coax, $sale_amount);
				}
			}

			//オンライン・オフライン代行判定
			if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){

				//代行依頼料（売上料×代行依頼料率）
				$daiko_money = bcmul($com_s_price,bcdiv($_POST["form_daiko_price"],100,2),2);

			    $eigyo_money = explode('.',$daiko_money);

				$con_data2["break_trade_price"][$row][$search_row]["1"] = $eigyo_money[0];

				if($eigyo_money[1] != NULL){
					$con_data2["break_trade_price"][$row][$search_row]["2"] = $eigyo_money[1];
				}else{
					$con_data2["break_trade_price"][$row][$search_row]["2"] = '00';
				}

				//金額計算処理判定
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//営業金額計算
		            $cost_amount = bcmul($daiko_money, $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
				}
			}
			$con_data2["break_trade_amount"][$row][$search_row]    = number_format($cost_amount);
			$con_data2["break_sale_amount"][$row][$search_row]     = number_format($sale_amount);

			//構成品の子に単価が設定されていないとき、商品情報クリア
			if($reset_goods_flg == true){
				//データが無い場合は、初期化
				$con_data2["hdn_bgoods_id"][$row][$search_row]         = "";
				$con_data2["hdn_bname_change"][$row][$search_row]      = "";
				$con_data2["break_goods_cd"][$row][$search_row]        = "";
				$con_data2["break_goods_name"][$row][$search_row]      = "";
		        $con_data2["break_goods_num"][$row][$search_row]       = "";
				$con_data2["break_trade_price"][$row][$search_row]["1"] = "";
				$con_data2["break_trade_price"][$row][$search_row]["2"] = "";
				$con_data2["break_trade_amount"][$row][$search_row]     = "";
				$con_data2["break_sale_price"][$row][$search_row]["1"] = "";
				$con_data2["break_sale_price"][$row][$search_row]["2"] = "";
				$con_data2["break_sale_amount"][$row][$search_row]     = "";
			}
		}else{
			//データが無い場合は、初期化
			$con_data2["hdn_bgoods_id"][$row][$search_row]         = "";
			$con_data2["hdn_bname_change"][$row][$search_row]      = "";
			$con_data2["break_goods_cd"][$row][$search_row]        = "";
			$con_data2["break_goods_name"][$row][$search_row]      = "";
	        $con_data2["break_goods_num"][$row][$search_row]       = "";
			$con_data2["break_trade_price"][$row][$search_row]["1"] = "";
			$con_data2["break_trade_price"][$row][$search_row]["2"] = "";
			$con_data2["break_trade_amount"][$row][$search_row]     = "";
			$con_data2["break_sale_price"][$row][$search_row]["1"] = "";
			$con_data2["break_sale_price"][$row][$search_row]["2"] = "";
			$con_data2["break_sale_amount"][$row][$search_row]     = "";
		}
		$con_data2["goods_search_row"]                  = "";

	}

	/****************************/
	//クリアボタン押下処理
	/****************************/
	if($_POST["clear_flg"] == true){
		//商品欄を全て初期化
		for($c=1;$c<=5;$c++){
			for($f=1;$f<=3;$f++){
				$con_data2["hdn_bgoods_id"][$row][$c]        = "";
				$con_data2["hdn_bname_change"][$row][$c]     = "";
				$con_data2["break_goods_cd"][$row][$c]       = "";
				$con_data2["break_goods_name"][$row][$c]     = "";
		        $con_data2["break_goods_num"][$row][$c]      = "";
			}
			$con_data2["break_trade_price"][$row][$c]["1"] = "";
			$con_data2["break_trade_price"][$row][$c]["2"] = "";
			$con_data2["break_trade_amount"][$row][$c]     = "";
			$con_data2["break_sale_price"][$row][$c]["1"]  = "";
			$con_data2["break_sale_price"][$row][$c]["2"]  = "";
			$con_data2["break_sale_amount"][$row][$c]      = "";
		}

		$con_data2["clear_flg"] = "";    //クリアボタン押下フラグ
	}
}
/****************************/
//部品定義
/****************************/
//契約登録の行数分
$type = $g_form_option;
for($i=1;$i<=5;$i++){
	//内訳を設定する行か判定
	if($row == $i){
		//設定行

		//内訳の行数分
		for($j=1;$j<=5;$j++){

			//商品コード      
			$form->addElement(
			    "text","break_goods_cd[$i][$j]","","size=\"10\" maxLength=\"8\"
			    style=\"$g_form_style;$style\" $type
				onChange=\"goods_search_1(this.form, 'break_goods_cd[$i][$j]', 'goods_search_row', $j)\""
			);
				
			//商品名
			//変更不可判定
			if($_POST["hdn_bname_change"][$i][$j] == '2' || $hdn_bname_change[$i][$j] == '2'){
				//不可
			    $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" $g_text_readonly" 
			    );
			}else{
				//可
			    $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" maxLength=\"20\" 
			        style=\"$style\" $type"
			    );
			}

			//FC・直営判定
			if($group_kind == 2){
				//直営
			    $form->addElement(
					"link","form_search[$i][$j]","","#","検索",
					"onClick=\"return Open_SubWin_Plan('../dialog/2-0-210.php', Array('break_goods_cd[$i][$j]','goods_search_row'), 500, 450,6,$client_h_id,$j,".$_POST["daiko_check"].");\""
				);
			}else{
				//FC
			    $form->addElement(
					"link","form_search[$i][$j]","","#","検索",
					"onClick=\"return Open_SubWin_Plan('../dialog/2-0-210.php', Array('break_goods_cd[$i][$j]','goods_search_row'), 500, 450,6,$client_h_id,$j);\""
				);
			}

			//FC・直営判定
			if($group_kind == 2){
				//直営
				//商品数
				$form->addElement(
			       "text","break_goods_num[$i][$j]","",
			       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
			       onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
			        style=\"$g_form_style;$style\" $type"
			    );
			}else{
				//FC
				//商品数
				$form->addElement(
			       "text","break_goods_num[$i][$j]","",
			       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
			       onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
			        style=\"$g_form_style;$style\" $type"
			    );
			}

			//商品ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]");
			//品名変更フラグ
			$form->addElement("hidden","hdn_bname_change[$i][$j]");

			//FC・直営判定
			if($group_kind == 2){
				//直営
			
				//代行の場合は、読み取りなので背景を黄色にしない
				if($_POST["daiko_check"] != 1){
					$type = NULL;
				}

				//営業原価
				$form_cost_price = NULL;
				$form_cost_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_cost_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true,$i,true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_cost_price[$i], "break_trade_price[$i][$j]", "",".");

				//営業原価以外は契約区分によってフォームが変わらない
				$type = $g_form_option;

				//原価合計額
			    $form->addElement(
			        "text","break_trade_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );

				//売上単価
				$form_sale_price = NULL;
				$form_sale_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_sale_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true,$i,true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");

				//売上合計額
				$form->addElement(
			        "text","break_sale_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );
			}else{
				//FC

				//営業原価
				$form_cost_price = NULL;
				$form_cost_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_cost_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_cost_price[$i], "break_trade_price[$i][$j]", "",".");

				//原価合計額
			    $form->addElement(
			        "text","break_trade_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );

				//売上単価
				$form_sale_price = NULL;
				$form_sale_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_sale_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");

				//売上合計額
				$form->addElement(
			        "text","break_sale_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );
			}

			/*
			 * 履歴：
			 * 　日付　　　　B票No.　　　　担当者　　　内容　
			 * 　2006/10/27　01-001　　　　suzuki-t　　内訳画面の戻るボタン押下処理変更
			 *
			*/
			//商品コード
			$form->addElement("hidden","return_goods_cd[$i][$j]","");

			//商品名
			$form->addElement("hidden","return_goods_name[$i][$j]","");
			//商品数
			$form->addElement("hidden","return_goods_num[$i][$j]","");
			//商品ID
			$form->addElement("hidden","return_bgoods_id[$i][$j]","");
			//品名変更フラグ
			$form->addElement("hidden","return_bname_change[$i][$j]","");

			//営業原価
			$form->addElement("hidden","return_trade_price[$i][$j][1]","");
			$form->addElement("hidden","return_trade_price[$i][$j][2]","");
			//原価合計
			$form->addElement("hidden","return_trade_amount[$i][$j]","");
			//売上単価
			$form->addElement("hidden","return_sale_price[$i][$j][1]","");
			$form->addElement("hidden","return_sale_price[$i][$j][2]","");
			//売上合計
			$form->addElement("hidden","return_sale_amount[$i][$j]","");

		}
	}else{
		//内訳を設定する行以外はhiddenとして定義

		//内訳登録の行数分
		for($j=1;$j<=5;$j++){
			//商品コード
			$form->addElement("hidden","break_goods_cd[$i][$j]","");

			//商品名
			$form->addElement("hidden","break_goods_name[$i][$j]","");
			//商品数
			$form->addElement("hidden","break_goods_num[$i][$j]","");
			//商品ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]","");
			//品名変更フラグ
			$form->addElement("hidden","hdn_bname_change[$i][$j]","");

			//営業原価
			$form->addElement("hidden","break_trade_price[$i][$j][1]","");
			$form->addElement("hidden","break_trade_price[$i][$j][2]","");
			//原価合計
			$form->addElement("hidden","break_trade_amount[$i][$j]","");
			//売上単価
			$form->addElement("hidden","break_sale_price[$i][$j][1]","");
			$form->addElement("hidden","break_sale_price[$i][$j][2]","");
			//売上合計
			$form->addElement("hidden","break_sale_amount[$i][$j]","");
		}
	}
}

//遷移元判定
if($get_info_id != NULL){
	//契約概要からダイアログ表示
	$form->addElement("button","close_button","閉じる","onClick=\"window.close()\"");
}else{
	//契約登録から遷移
	$form->addElement("hidden", "hdn_row");       //契約登録の行番号    

	$form->addElement("hidden", "return_btn");    //初期表示の内訳情報をセットするフラグ

	//設定
	$form->addElement("submit","set","設　定",
	   "onClick=\"return Dialogue('設定します。','./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id');\""
	);
	//クリア
	$form->addElement("button","clear_button","クリア","onClick=\"insert_row('clear_flg');\"");
	//戻る
	$form->addElement("button","form_back","戻　る","onClick=\"SubMenu2('./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id')\"");
	//変更・一覧
	$form->addElement("button","change_button","変更・一覧","onClick=\"location.href='2-1-111.php'\"");
	//一括訂正(ヘッダー)
	$form->addElement("button","all_button","一括訂正","onClick=\"location.href='2-1-114.php'\"");
	//登録(ヘッダー)
	$form->addElement("button","new_button","登　録","style=color:red onClick=\"location.href='2-1-104.php?flg=add'\"");
}

//フォームループ数
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//営業原価読み取り関数
//オンライン・オフライン代行判定
if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
	$form_load = "onLoad=\"daiko_checked($row);\"";
}

//代行用
$java_sheet  = <<<DAIKO

//代行依頼チェックボックス
function daiko_checked(row){
	//代行依頼判定
	if(document.dateForm.daiko_check.value != 1){
		//オンライン代行・オフライン代行

		//営業原価
		document.dateForm.elements["break_trade_price["+row+"][1][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][1][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][2][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][2][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][3][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][3][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][4][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][4][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][5][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][5][2]"].readOnly = true;

	}else{
		//通常

		//営業原価
		document.dateForm.elements["break_trade_price["+row+"][1][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][1][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][2][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][2][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][3][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][3][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][4][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][4][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][5][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][5][2]"].readOnly = false;

	}
	
	return true;

}

//商品ダイアログ関数
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,head_flg)
{
	//ダイアログが指定されている場合は、倉庫ID or 棚卸調査ID が必要
	if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

		//契約区分が通常以外は、本部の商品だけを表示
		if(head_flg != 1){
			//オンライン・オフライン代行
			rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
		}else{
			//通常
			rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
		}

		if(typeof(rtnarr) != "undefined"){
			for(i=0;i<arr.length;i++){
				dateForm.elements[arr[i]].value=rtnarr[i];
			}
		}

		var next = '#';
        document.dateForm.action=next;
		document.dateForm.submit();

	}

	return false;
}

DAIKO;

/****************************/
//POST情報の値を変更
/****************************/
$form->setConstants($con_data2);

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
//契約登録から遷移してきた場合に表示
if($get_info_id == NULL){
	$page_title .= "(全".$total_count."件)";
	$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
	$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
	$page_title .= "　".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'       => "$html_header",
	'page_menu'         => "$page_menu",
	'page_header'       => "$page_header",
	'html_footer'       => "$html_footer",
	'java_sheet'        => "$java_sheet",
	'flg'               => "$flg",
	'get_flg'           => "$get_flg",
	'client_id'         => "$client_id",
	'serv_name'         => "$serv_name",
	'main_goods_name'   => "$main_goods_name",
	'main_goods_cd'     => "$main_goods_cd",
	'main_goods_num'    => "$main_goods_num",
	'main_trade_price'  => "$main_trade_price",
	'main_sale_price'   => "$main_sale_price",
	'main_trade_amount' => "$main_trade_amount",
	'main_sale_amount'  => "$main_sale_amount",
	'row'               => "$row",
	'get_info_id'       => "$get_info_id",
	'form_load'         => "$form_load",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
