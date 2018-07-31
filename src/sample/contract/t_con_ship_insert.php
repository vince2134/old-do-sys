<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

//巡回日テーブル削除
$sql  = "DELETE FROM t_con_ship;";
$result = Db_Query($db_con, $sql);
if($result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

/****************************/
//出庫品テーブル登録
/****************************/
//契約内容ID取得SQL
$sql  = "SELECT ";
$sql .= "    t_con_info.con_info_id, ";    //契約内容ID
$sql .= "    t_con_info.divide,";          //販売区分
$sql .= "    t_con_info.goods_id,";        //商品ID
$sql .= "    t_com.compose_flg,";          //構成品フラグ
$sql .= "    t_con_info.goods_name,";      //商品名
$sql .= "    t_con_info.num,";             //数量
$sql .= "    t_con_info.egoods_id,";       //消耗品ID
$sql .= "    t_com2.compose_flg,";         //構成品フラグ
$sql .= "    t_con_info.egoods_name,";     //消耗品名
$sql .= "    t_con_info.egoods_num ";      //数量
$sql .= "FROM ";
$sql .= "    t_con_info ";
$sql .= "    LEFT JOIN t_goods AS t_com ON t_com.goods_id = t_con_info.goods_id ";
$sql .= "    LEFT JOIN t_goods AS t_com2 ON t_com2.goods_id = t_con_info.egoods_id ";
$sql .= "WHERE ";
$sql .= "    (t_con_info.goods_id IS NOT NULL OR t_con_info.egoods_id IS NOT NULL);";
$ship_result = Db_Query($db_con, $sql);
while($ship_list = pg_fetch_array($ship_result)){
	
	$con_info_id   = $ship_list[0];      //契約内容ID
	$divide        = $ship_list[1];      //販売区分
	$goods_id      = $ship_list[2];      //商品ID
	$compose_flg   = $ship_list[3];      //構成品フラグ
	$goods_name    = $ship_list[4];      //商品名
	$num           = $ship_list[5];      //数量
	$egoods_id     = $ship_list[6];      //消耗品ID
	$compose_flg2  = $ship_list[7];      //構成品フラグ
    $egoods_name   = $ship_list[8];      //消耗品名
    $egoods_num    = $ship_list[9];      //数量

	$goods_ship_id = NULL;               //出庫品登録配列
	$divide_flg    = false;              //出庫品テーブル登録判定フラグ

	//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
	if($divide == '03' || $divide == '04'){
		$divide_flg = true;
	}

	//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
	if($divide_flg == false){

		//アイテムID存在判定
		if($goods_id != NULL){
			//構成品判定
			if($compose_flg != 't'){
				//アイテムが入力されている契約
		
				//同じ商品か判定。
				if($goods_ship_id[$goods_id] == NULL){
					//新規の商品

					//出庫品登録配列
					//配列[商品ID][0] = 略称
					//配列[商品ID][1] = 数量
					$goods_ship_id[$goods_id][0] = $goods_name;
					$goods_ship_id[$goods_id][1] = $num;
				}else{
					//同じ商品の場合は数量を足す

					//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
					$goods_ship_id[$goods_id][1] = $goods_ship_id[$goods_id][1] + $num;
				}
			}else{
				//商品が構成品の場合、構成品の子だけを登録

				//各構成品の商品情報取得
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                       //構成品ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = $goods_id;";
				$result = Db_Query($db_con, $sql);
				$item_parts = Get_Data($result);

				//各構成品の数量取得
				for($i=0;$i<count($item_parts);$i++){
					$sql  = "SELECT ";
					$sql .= "    t_goods.goods_name,";
					$sql .= "    t_goods.goods_cname,";
					$sql .= "    t_compose.count ";
					$sql .= "FROM ";
					$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "WHERE ";
					$sql .= "    t_compose.goods_id = $goods_id ";
					$sql .= " AND ";
					$sql .= "    t_compose.parts_goods_id = ".$item_parts[$i][0].";";
					$result = Db_Query($db_con, $sql);
					$item_parts_name[$i] = pg_fetch_result($result,0,0);    //商品名
					$item_parts_cname[$i] = pg_fetch_result($result,0,1);   //略称
					$parts_num = pg_fetch_result($result,0,2);              //構成品に対する数量
					$item_parts_num[$i] = $parts_num * $num;                //数量
				}

				for($d=0;$d<count($item_parts);$d++){
					//同じ商品か判定。
					if($goods_ship_id[$item_parts[$d][0]] == NULL){
						//新規の商品

						//出庫品登録配列
						//配列[商品ID][0] = 略称
						//配列[商品ID][1] = 数量
						$goods_ship_id[$item_parts[$d][0]][0] = $item_parts_cname[$d];
						$goods_ship_id[$item_parts[$d][0]][1] = $item_parts_num[$d];
					}else{
						//同じ商品の場合は数量を足す

						//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
						$goods_ship_id[$item_parts[$d][0]][1] = $goods_ship_id[$item_parts[$d][0]][1] + $item_parts_num[$d];
					}
				}
			}
		}

		//消耗品ID存在判定
		if($egoods_id != NULL){
			//構成品判定
			if($compose_flg2 != 't'){
				//消耗品が入力されている契約
		
				//同じ商品か判定。
				if($goods_ship_id[$egoods_id] == NULL){
					//新規の商品

					//出庫品登録配列
					//配列[商品ID][0] = 略称
					//配列[商品ID][1] = 数量
					$goods_ship_id[$egoods_id][0] = $egoods_name;
					$goods_ship_id[$egoods_id][1] = $egoods_num;
				}else{
					//同じ商品の場合は数量を足す

					//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
					$goods_ship_id[$egoods_id][1] = $goods_ship_id[$egoods_id][1] + $expend_num;
				}
			}else{
				//商品が構成品の場合、構成品の子だけを登録

				//各構成品の商品情報取得
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                 //構成品ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = $egoods_id;";
				$result = Db_Query($db_con, $sql);
				$expend_parts = Get_Data($result);

				//各構成品の数量取得
				for($i=0;$i<count($expend_parts);$i++){
					$sql  = "SELECT ";
					$sql .= "    t_goods.goods_name,";
					$sql .= "    t_goods.goods_cname,";
					$sql .= "    t_compose.count ";
					$sql .= "FROM ";
					$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "WHERE ";
					$sql .= "    t_compose.goods_id = $egoods_id";
					$sql .= " AND ";
					$sql .= "    t_compose.parts_goods_id = ".$expend_parts[$i][0].";";
					$result = Db_Query($db_con, $sql);

					$expend_parts_name[$i] = pg_fetch_result($result,0,0);      //商品名
					$expend_parts_cname[$i] = pg_fetch_result($result,0,1);     //略称
					$parts_num = pg_fetch_result($result,0,2);                  //構成品に対する数量
					$expend_parts_num[$i] = $parts_num * $egoods_num;           //数量
				}

				for($d=0;$d<count($expend_parts);$d++){
					//同じ商品か判定。
					if($goods_ship_id[$expend_parts[$d][0]] == NULL){
						//新規の商品

						//出庫品登録配列
						//配列[商品ID][0] = 略称
						//配列[商品ID][1] = 数量
						$goods_ship_id[$expend_parts[$d][0]][0] = $expend_parts_cname[$d];
						$goods_ship_id[$expend_parts[$d][0]][1] = $expend_parts_num[$d];
					}else{
						//同じ商品の場合は数量を足す

						//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
						$goods_ship_id[$expend_parts[$d][0]][1] = $goods_ship_id[$expend_parts[$d][0]][1] + $expend_parts_num[$d];
					}
				}
			}
		}

		//出庫品登録SQL
		while($goods_ship_num = each($goods_ship_id)){
			//添え字の商品ID取得
			$ship = $goods_ship_num[0];
		
			$sql  = "INSERT INTO t_con_ship( ";
			$sql .= "    con_info_id,";
			$sql .= "    goods_id,";
			$sql .= "    goods_name,";
			$sql .= "    num ";
			$sql .= "    )VALUES(";
			$sql .= "    $con_info_id,";                   //契約内容ID
			$sql .= "    $ship,";                          //商品ID
			$sql .= "    '".$goods_ship_id[$ship][0]."',"; //商品名
			$sql .= "    ".$goods_ship_id[$ship][1];       //数量
			$sql .= "    );";

			$in_result = Db_Query($db_con, $sql);
			if($in_result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}

		}
	}
}

Db_Query($db_con, "COMMIT;");
print "出庫品テーブル作成完了"
?>
