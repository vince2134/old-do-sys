<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/02/05      要件26-1    kajioka-h   代行伝票の場合に数量を変更できるように変更
 *                                          （出庫品テーブル、受払の登録処理をplan_data_sql_stock_hand.incに移動）
 *  2007/06/20      B0702-063   kajioka-h   報告済のオンライン代行は引当てないように修正
 */

/****************************/
//出庫品テーブル登録
/****************************/

//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
if($divide[$s] != '03' && $divide[$s] != '04'){

	//構成品・サービスだけの契約か判定
	if($goods_item_com[$s] != 't' && $goods_item_id[$s] != NULL){
		//アイテムが入力されている契約

		//同じ商品か判定。
		if($goods_ship_id[$goods_item_id[$s]] == NULL){
			//新規の商品

			//出庫品登録配列
			//配列[商品ID][0] = 略称
			//配列[商品ID][1] = 数量
			$goods_ship_id[$goods_item_id[$s]][0] = $goods_item_name[$s];
			$goods_ship_id[$goods_item_id[$s]][1] = $goods_item_num[$s];
		}else{
			//同じ商品の場合は数量を足す

			//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
			$goods_ship_id[$goods_item_id[$s]][1] = $goods_ship_id[$goods_item_id[$s]][1] + $goods_item_num[$s];
		}
	}else{
		//商品が構成品の場合、構成品の子だけを登録

		for($d=0;$d<count($item_parts[$s]);$d++){
			//同じ商品か判定。
			if($goods_ship_id[$item_parts[$s][$d][0]] == NULL){
				//新規の商品

				//出庫品登録配列
				//配列[商品ID][0] = 略称
				//配列[商品ID][1] = 数量
				$goods_ship_id[$item_parts[$s][$d][0]][0] = $item_parts_cname[$s][$d];
				$goods_ship_id[$item_parts[$s][$d][0]][1] = $item_parts_num[$s][$d];
			}else{
				//同じ商品の場合は数量を足す

				//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
				$goods_ship_id[$item_parts[$s][$d][0]][1] = $goods_ship_id[$item_parts[$s][$d][0]][1] + $item_parts_num[$s][$d];
			}
		}
	}
//print_array($goods_ship_id);

	//構成品・サービスだけの契約か判定
	if($goods_expend_com[$s] != 't' && $goods_expend_id[$s] != NULL){
		//消耗品が入力されている契約

		//同じ商品か判定。
		if($goods_ship_id[$goods_expend_id[$s]] == NULL){
			//新規の商品

			//出庫品登録配列
			//配列[商品ID][0] = 略称
			//配列[商品ID][1] = 数量
			$goods_ship_id[$goods_expend_id[$s]][0] = $goods_expend_name[$s];
			$goods_ship_id[$goods_expend_id[$s]][1] = $goods_expend_num[$s];
		}else{
			//同じ商品の場合は数量を足す

			//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
			$goods_ship_id[$goods_expend_id[$s]][1] = $goods_ship_id[$goods_expend_id[$s]][1] + $goods_expend_num[$s];
		}
	}else{
		//商品が構成品の場合、構成品の子だけを登録

		for($d=0;$d<count($expend_parts[$s]);$d++){
			//同じ商品か判定。
			if($goods_ship_id[$expend_parts[$s][$d][0]] == NULL){
				//新規の商品

				//出庫品登録配列
				//配列[商品ID][0] = 略称
				//配列[商品ID][1] = 数量
				$goods_ship_id[$expend_parts[$s][$d][0]][0] = $expend_parts_cname[$s][$d];
				$goods_ship_id[$expend_parts[$s][$d][0]][1] = $expend_parts_num[$s][$d];
			}else{
				//同じ商品の場合は数量を足す

				//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
				$goods_ship_id[$expend_parts[$s][$d][0]][1] = $goods_ship_id[$expend_parts[$s][$d][0]][1] + $expend_parts_num[$s][$d];
			}
		}
	}

	//サービスだけの契約以外は、用意した配列データを登録
	if($goods_ship_id != NULL){
		//出庫品登録SQL
		while($goods_ship_num = each($goods_ship_id)){
			//添え字の商品ID取得
			$ship = $goods_ship_num[0];

			//履歴用カラムデータ取得
			$sql  = "SELECT ";
			$sql .= "    t_goods.goods_cd ";
			$sql .= "FROM ";
			$sql .= "    t_goods ";
			$sql .= "WHERE ";
			$sql .= "    t_goods.goods_id = $ship;";
			$result = Db_Query($db_con, $sql);
			$ship_data = Get_Data($result,5);

			$sql  = "INSERT INTO t_aorder_ship( ";
			$sql .= "    aord_d_id,";
			$sql .= "    goods_id,";
			$sql .= "    goods_name,";
			$sql .= "    num, ";
			$sql .= "    goods_cd ";
			$sql .= "    )VALUES(";
			if($contract_div == "1"){
				$sql .= "    $aord_d_id,";                 //受注データID
			}else{
				$sql .= "    (SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $aord_id AND line = $s), ";
			}
			$sql .= "    $ship,";                          //商品ID
			$sql .= "    '".$goods_ship_id[$ship][0]."',"; //商品名
			$sql .= "    ".$goods_ship_id[$ship][1].",";   //数量
			$sql .= "    '".$ship_data[0][0]."'";          //商品CD
			$sql .= "    );";		
			$result = Db_Query($db_con, $sql);
			if($result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}


			//--------------------------//
			//受払テーブルに登録関数
			//--------------------------//
			//自社巡回の場合はショップIDで登録
			if($contract_div == "1"){
				Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship,$goods_ship_id[$ship][1],'reason');
            //オンライン代行の場合は代行者IDで登録（報告されていないもののみ）
            }elseif($contract_div == "2" && $trust_confirm_flg == "f"){
				Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship,$goods_ship_id[$ship][1],'reason', $act_id);
			}
		}
	}
}
//出庫品登録配列初期化
$goods_ship_id = NULL;

?>
