<?php
/*単価設定*/

/******************************
 *  変更履歴
 *      ・（2006-11-17）ROLLBACKした後に、エラー内容をログに出力 <suzuki>
 *      ・（2007-06-25）単価の変更を契約マスタ、予定データに反映するように修正<watanabe-k>
 *
*******************************/

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数

//DBに接続
$conn = Db_Connect();

//開始
$today = date("Y-m-d H:i:s");
error_log("$today 商品単価改定開始 \n",3,LOG_FILE);

//エラー変数初期化
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/**************************/
//更新するデータを抽出
/**************************/
$today = date("Y-m-d");

$price_sql .= " SELECT";
$price_sql .= "     t_rprice.price_id,";
$price_sql .= "     t_rprice.rprice,";
$price_sql .= "     t_price.goods_id, ";
$price_sql .= "     t_price.rank_cd, ";
$price_sql .= "     t_price.shop_id ";
$price_sql .= " FROM";
$price_sql .= "     t_rprice";
$price_sql .= "         INNER JOIN ";
$price_sql .= "     t_price ";
$price_sql .= "     ON t_rprice.price_id = t_price.price_id ";
$price_sql .= " WHERE";
$price_sql .= "     t_rprice.rprice_flg = 'f'";
$price_sql .= "     AND";
$price_sql .= "     t_rprice.price_cday <= '$today'";
$price_sql .= ";";

$res = Db_Query($conn, $price_sql);
$price_num = pg_num_rows($res);

/**************************/
//更新
/**************************/
if($price_num > 0){
    Db_Query($conn,"BEGIN");

    for($i = 0; $i < $price_num; $i++){
        $price_data[$i] = pg_fetch_array($res, $i, PGSQL_NUM);

        $update_sql  = " UPDATE";
        $update_sql .= "    t_price";
        $update_sql .= " SET";
        $update_sql .= "    r_price = ".$price_data[$i][1]."";
        $update_sql .= " WHERE";
        $update_sql .= "    price_id = ".$price_data[$i][0]."";
        $update_sql .= " ;";
        $update_sql .= " UPDATE";
        $update_sql .= "    t_rprice";
        $update_sql .= " SET";
        $update_sql .= "    rprice_flg = 't'";
        $update_sql .= " WHERE";
        $update_sql .= "    price_id = ".$price_data[$i][0]."";
        $update_sql .= "    AND";
        $update_sql .= "    rprice_flg = 'f'";
        $update_sql .= ";";  
	    $result = Db_Query($conn, $update_sql);

		if($result === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 単価テーブルの商品単価改定失敗 \n単価ID: ".$price_data[$i][0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

        //単価の変更を契約マスタと予定データに反映
        //標準売価OR営業原価の場合
        if($price_data[$i][3] === '4'){

            //GROUPKINDを抽出
            $sql  = "SELECT";
            $sql .= "   group_kind ";
            $sql .= "FROM ";
            $sql .= "   t_client ";
            $sql .= "       INNER JOIN ";
            $sql .= "   t_rank ";
            $sql .= "   ON t_client.rank_cd = t_rank.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "   t_client.client_id = ".$price_data[$i][4]." ";
            $sql .= ";"; 

            $result = Db_Query($conn, $sql);
            $group_kind = pg_fetch_result($result, 0,0);

            $_SESSION["group_kind"] = $group_kind;          //種別  
            $_SESSION["client_id"]  = $price_data[$i][4];   //得意先ID

//            $result2 = Mst_Sync_Goods($conn,$price_data[$i][2],"price", "sale");
        }elseif($price_data[$i][3] === '2'){

            //GROUPKINDを抽出
            $sql  = "SELECT";
            $sql .= "   group_kind ";
            $sql .= "FROM ";
            $sql .= "   t_client ";
            $sql .= "       INNER JOIN ";
            $sql .= "   t_rank ";
            $sql .= "   ON t_client.rank_cd = t_rank.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "   t_client.client_id = ".$price_data[$i][4]." ";
            $sql .= ";"; 

            $result = Db_Query($conn, $sql);
            $group_kind = pg_fetch_result($result, 0,0);

            $_SESSION["group_kind"] = $group_kind;          //種別  
            $_SESSION["client_id"]  = $price_data[$i][4];   //得意先ID

//            $result2 = Mst_Sync_Goods($conn,$price_data[$i][2],"price", "buy");
        }

		if($result2 === false){
			//エラー判定
			if($error_msg == NULL){
				//既に異常が発生していなければエラー表示
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."行目 契約マスタと予定データの単価改定失敗 \n単価ID: ".$price_data[$i][0]." \n";
			}
		}
	}

/*
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }else{
        shell_exec("echo NOTCE $today >> /home/postgres/cron.log");
    }

    Db_Query($conn,"COMMIT");
*/
}

//正常判定
if($error_msg == NULL){
	//正常

	Db_Query($conn,"COMMIT");
	$today = date("Y-m-d H:i:s");
	//FILEに出力
	error_log("$today 商品単価改定完了 \n\n",3,LOG_FILE);
}else{
	//異常
	Db_Query($conn, "ROLLBACK");

	//FILEにエラー出力
	$estr = NULL;
	for($i=0;$i<count($error_msg);$i++){
		error_log($error_msg[$i],3,LOG_FILE);
		$e_contents .= $error_msg[$i];
	}
	//メールでエラー通知
	Error_send_mail($g_error_mail,$g_error_add,"商品単価改定処理で異常発生",$e_contents);
}

/*
else{
    shell_exec("echo There is not a record to fall under $today. >> /home/postgres/cron.log ");
}
*/
?>
