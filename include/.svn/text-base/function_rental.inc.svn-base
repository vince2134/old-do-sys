<?php

//商品のレンタル原価を返します。
function Get_Goods_RentalCost($db_con,$goods_id){

	$sql = "
	SELECT
		t_price.r_price 
	FROM t_price 
	WHERE    t_price.goods_id = $goods_id  
		AND    t_price.shop_id  = 1  
		AND    t_price.rank_cd  = '6'  
	";

	$result = Db_Query($db_con, $sql);
	$price  = @pg_fetch_result($result,0,0);

	return $price;

}


//商品コードからレンタル原価を表示するためのJSを作成します。
function Create_Js_Rcost($db_con){

	$sql = "
	SELECT
		t_goods.goods_cd,
		t_price.r_price 
	FROM
		t_goods 
	INNER JOIN t_price ON 
		t_goods.goods_id = t_price.goods_id
	WHERE    t_price.shop_id = 1  
		AND    t_price.rank_cd = '6'  
		AND    t_goods.accept_flg = '1'  
		AND    t_goods.rental_flg = 't'
	";

	$result = Db_Query($db_con, $sql);
	$goods_data = Get_Data($result,3);

	//件数
	$count = count($goods_data);

	for($g=0;$g<$count;$g++){
		$goods_cd = $goods_data[$g][0]; //商品コード
		$cost     = $goods_data[$g][1]; //レンタル原価

		$data .= "    data['$goods_cd']='$cost' \n";
	}


	$js = "
	function goods_rcost(cd){
		data = new Array($count);
		$data

		if(data[cd] == undefined){
			data[cd] = '';
		}
		return data[cd];
	}
	";

	return $js;

}







 /**
 * レンタル登録画面表示形式判定
 *
 * 変更履歴
 * 1.0.0 (2006/09/06) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/09/06)
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $rental_id      レンタルID   
 *
 * @return              string      $disp_stat[0]   レンタル登録画面識別フラグ
 *                                  1:レンタルID無し(初期登録)
 *                                  2:契約済・解約済
 *                                  3:解約申請
 *                                  4:解約予定
 *                                  5:取消済
 *                                  6:新規申請中
 *
 *                                  $disp_stat[1]   オンラインフラグ
 *                                  
 */

function Rental_display($db_con,$rental_id=false){

	//レンタルID指定判定
	if($rental_id != false){
		//レンタル状況に応じた画面表示

		//レンタル状況・オンラインフラグ取得
		$sql  = "SELECT ";
		$sql .= "    t_rental_d.rental_stat,";
		$sql .= "    t_rental_h.online_flg ";
		$sql .= "FROM ";
		$sql .= "    t_rental_d ";
		$sql .= "    INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id ";
		$sql .= "WHERE ";
		$sql .= "    t_rental_h.rental_id = $rental_id;";
		$result = Db_Query($db_con, $sql);
		//GETデータ判定
		Get_Id_Check($result);

		while($stat_num = pg_fetch_array($result)){
			//レンタル状況配列作成
			$stat = $stat_num[0];
			$stat_array[] = $stat;

			//オンラインフラグ
			$disp_stat[1] = $stat_num[1];
		}
		
		//画面形式判定
		if(in_array("21",$stat_array)){
			//解約申請
			$disp_stat[0] = 3;
		}else if(in_array("22",$stat_array)){
			//解約予定
			$disp_stat[0] = 4;
		}else if(in_array("10",$stat_array) || in_array("20",$stat_array)){
			//契約済・解約済
			$disp_stat[0] = 2;
		}else if(in_array("0",$stat_array)){
			//取消済
			$disp_stat[0] = 5;
		}else if(in_array("11",$stat_array)){
			//新規申請中
			$disp_stat[0] = 6;
		}

		//オフラインの場合
		if($disp_stat[1] == "f"){
			$disp_stat[0] = 2;		
		}
		
	}else{
		//レンタルID無し
		$disp_stat[0] = 1;
		//オフライン
		$disp_stat[1] = 'f';
	}

	return $disp_stat;
}


 /**
 * レンタル登録(本部)クエリ実行関数
 *
 * 変更履歴
 * 1.0.0 (2006/09/11) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/09/11)
 *
 * @param               object      $db_con         DBオブジェクト
 * @param               string      $rental_id      レンタルID   
 * @param               boolean     $disp_flg       実行画面識別フラグ
 *                                  1:レンタル登録(解約申請) 
 *                                  2:レンタル登録(契約済・解約済のオフライン)
 *                                  3:CRON 
 *
 * @return              boolean     成功：true
 *                                  失敗：false
 *
 *                                  
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/15      10-006      suzuki      数量より解約数が少なかった場合、契約済データ作成
 *  2006/11/15      10-024      suzuki      解約済・解約予定の金額を更新
*/

function Rental_sql($db_con,$rental_id,$disp_flg=3){

	$today = date("Y-m-d");  //本日の日付

	$sql  = "SELECT ";
	$sql .= "    rental_d_id,";            //レンタルデータID 0
	$sql .= "    line,";                   //行 1
	$sql .= "    goods_id,";               //商品ID 2
	$sql .= "    goods_cd,";               //商品CD 3
	//$sql .= "    g_product_name,";         //商品分類名 4
	//$sql .= "    official_goods_name,";    //商品名(正式) 5
	//$sql .= "    goods_name,";             //略称 6
	$sql .= "    g_product_id,";           //商品分類名 4
	$sql .= "    '',";                     //商品名(正式) 5
	$sql .= "    goods_cname,";            //略称 6
	$sql .= "    num,";                    //数量 7
	$sql .= "    COALESCE(rental_price, 0),";           //レンタル単価 8
	$sql .= "    COALESCE(rental_amount, 0),";          //レンタル金額 9
	//$sql .= "    rental_price,";           //レンタル単価 8
	//$sql .= "    rental_amount,";          //レンタル金額 9
	$sql .= "    user_price,";             //ユーザ単価 10
	$sql .= "    user_amount,";            //ユーザ金額 11
	$sql .= "    serial_no,";              //シリアル番号 12
	$sql .= "    serial_flg,";             //シリアル管理フラグ 13
	$sql .= "    rental_stat,";            //レンタル状況 14
	$sql .= "    calcel_exec,";            //解約実施 15
	$sql .= "    renew_num,";              //解約数 16
	$sql .= "    calcel_day,";             //解約日 17
	$sql .= "    exec_day, ";               //実施日 18
	$sql .= "    shop_price,";             //ショップ単価 19
	$sql .= "    shop_amount ";            //ショップ金額 20
	$sql .= "FROM ";
	$sql .= "    t_rental_d ";
	$sql .= "WHERE ";
	//画面実行判定
	if($disp_flg == 3){
		//CRON
		$sql .= "    rental_stat = '22' ";  //解約予定
		$sql .= "AND ";
		$sql .= "    exec_day = '$today' ";
	}else if($disp_flg == 1){
		//レンタル登録画面(解約申請)
		$sql .= "    rental_stat = '21' ";  //解約申請
	}else if($disp_flg == 2){
		//レンタル登録画面(契約済・解約済でオフライン)
		$sql .= "    rental_stat = '10' ";  //契約済
	}else if($disp_flg == 4){
		//FCオフラインでの解約

		$sql .= "( ";
		$sql .= "    (rental_stat = '22' AND exec_day = '$today' )";  //解約予定
		$sql .= "OR ";
		$sql .= "    (rental_stat = '21')";  //解約申請
		$sql .= ") ";
	}
	$sql .= "AND ";   
	$sql .= "    (calcel_exec = '2' OR calcel_exec = '3') "; 
	$sql .= "AND ";  
	$sql .= "    rental_id = $rental_id;"; 
	$result = Db_Query($db_con, $sql);
	$ren_data = Get_Data($result,3);

	//レンタルデータ登録
	for($i = 0; $i < count($ren_data); $i++){

		//即解約データで数量より解約数が少ない or 解約実施日が本日のデータで数量より解約数が少ない か判定
		//if($ren_data[$i][7] > $ren_data[$i][16] && ($ren_data[$i][15] == 2 || ($ren_data[$i][15] == 3 && $disp_flg == 3))){

		//数量より解約数が少ないか判定 
		if($ren_data[$i][7] > $ren_data[$i][16]){

			//解約しない分をデータに登録
			$sql  = "INSERT INTO t_rental_d (";
			$sql .= "    rental_d_id,";            //レンタルデータID
			$sql .= "    rental_id,";              //レンタルID
			$sql .= "    line,";                   //行
			$sql .= "    goods_id,";               //商品ID
			$sql .= "    goods_cd,";               //商品CD
			//$sql .= "    g_product_name,";         //商品分類名
			//$sql .= "    official_goods_name,";    //商品名(正式)
			//$sql .= "    goods_name,";             //略称
			$sql .= "    g_product_id,";           //商品分類名
			$sql .= "    goods_cname,";            //略称
			$sql .= "    num,";                    //数量
			$sql .= "    serial_no,";              //シリアル番号
			$sql .= "    serial_flg,";             //シリアル管理フラグ
			$sql .= "    rental_price,";           //レンタル単価
			$sql .= "    rental_amount,";          //レンタル金額
			$sql .= "    user_price,";             //ユーザ単価
			$sql .= "    user_amount,";            //ユーザ金額
			$sql .= "    shop_price,";             //ショップ単価
			$sql .= "    shop_amount,";            //ショップ金額
			$sql .= "    rental_stat,";            //レンタル状況
			$sql .= "    calcel_exec, ";           //解約実施
			$sql .= "    calcel_id ";              //解約ID
			$sql .= ")VALUES(";
			$sql .= "    (SELECT COALESCE(MAX(rental_d_id), 0)+1 FROM t_rental_d),";  
			$sql .= "    $rental_id,";
			$sql .= "    (SELECT COALESCE(MAX(line),0)+1 FROM t_rental_d WHERE rental_id = $rental_id),";  
			$sql .= "    ".$ren_data[$i][2].",";
			$sql .= "    '".$ren_data[$i][3]."',";
			$sql .= "    '".$ren_data[$i][4]."',";
			//$sql .= "    '".$ren_data[$i][5]."',";
			$sql .= "    '".$ren_data[$i][6]."',";
			$sql .= "    ".($ren_data[$i][7] - $ren_data[$i][16]).","; //数量 - 解約数
			//シリアル番号指定判定
			if($ren_data[$i][12] != NULL){
				$sql .= "    '".$ren_data[$i][12]."',";
			}else{
				$sql .= "    NULL,";
			}
			$sql .= "    '".$ren_data[$i][13]."',";
			$sql .= "    ".$ren_data[$i][8].",";
			$sql .= "    ".($ren_data[$i][8] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //レンタル単価×(数量 - 解約数)
			$sql .= "    ".$ren_data[$i][10].",";
			$sql .= "    ".($ren_data[$i][10] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //ユーザ単価×(数量 - 解約数)
			$sql .= "    ".$ren_data[$i][19].",";
			$sql .= "    ".($ren_data[$i][19] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //ショップ単価×(数量 - 解約数)
			$sql .= "    '10',";
			$sql .= "    '1',";
			$sql .= "    ".$ren_data[$i][0];
			$sql .= ");";

			$result = Db_Query($db_con, $sql);

			if($result == false){
				return false;
			}
		}

		//解約するデータ更新
		$sql  = "UPDATE t_rental_d SET ";
		$sql .= "    num = ".$ren_data[$i][16].",";
		$sql .= "    rental_amount = ".($ren_data[$i][8] * $ren_data[$i][16]).",";
		$sql .= "    user_amount = ".($ren_data[$i][10] * $ren_data[$i][16]).",";
		$sql .= "    shop_amount = ".($ren_data[$i][19] * $ren_data[$i][16]).",";

		//解約実施判定
		if(($ren_data[$i][15] == 2) || ($disp_flg == 3 && $ren_data[$i][15] == 3)){
			//即解約orCRON実行の解約予定
			$sql .= "    rental_stat = '20',";    //解約済
			$sql .= "    calcel_exec = '4',";     //解約完了
			$sql .= "    renew_num = NULL,";      //解約数
			$sql .= "    calcel_day = '$today' "; //解約日を本日に設定
		}else if($ren_data[$i][15] == 3 && $disp_flg != 3){
			//解約日に解約
			$sql .= "    rental_stat = '22',";    //解約予定
			$sql .= "    permit_flg = 't' ";      //解約承認フラグ
		}
		$sql .= "WHERE ";
		$sql .= "    rental_d_id = ".$ren_data[$i][0].";";
		$result = Db_Query($db_con, $sql);

		if($result == false){
			return false;
		}
	}

	return true;
}

//レンタルデータを削除します。
function Delete_Rental_D($db_con,$rental_id){
	//レンタルデータを削除
	$sql  = "DELETE FROM";
	$sql .= "    t_rental_d";
	$sql .= " WHERE";
	$sql .= "    rental_id = $rental_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql);
	if($result == false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}
}


//商品分類、正式名、略称、シリアル管理フラグを返す
function Get_Goods_Info($db_con,$goods_id){
	//商品分類・正式名称取得
	$sql  = "SELECT ";
	$sql .= "    t_g_product.g_product_name,";
	$sql .= "    (t_g_product.g_product_name || '　' || t_goods.goods_name) AS official_goods_name, ";
	$sql .= "    t_goods.goods_name,";
	$sql .= "    t_goods.serial_flg, ";
	$sql .= "    t_goods.goods_cname ";
	$sql .= "FROM ";
	$sql .= "    t_g_product ";
	$sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
	$sql .= "WHERE ";
	$sql .= "    t_goods.goods_id = ".$goods_id.";";
	$result = Db_Query($db_con, $sql);
	$data = pg_fetch_array($result);
	
	//print_array($data);
	return $data;
}

//商品分類ID、商品分類名を返す
function Get_G_Product_Info($db_con,$g_product_id){
	$sql  = "SELECT ";
	$sql .= "    t_g_product.g_product_id,";
	$sql .= "    t_g_product.g_product_name ";
	$sql .= "FROM ";
	$sql .= "    t_g_product ";
	$sql .= "WHERE ";
	$sql .= "    t_g_product.g_product_id = ".$g_product_id.";";
	$result = Db_Query($db_con, $sql);
	$data = pg_fetch_array($result);
	
	return $data;
}


 /**
 * レンタルJS作成
 *
 * 変更履歴
 * 1.0.0 (2006/09/06) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/09/06)
 *
 * @param               string      $db_con         DBオブジェクト
 *
 * @return              string      $java_sheet     商品情報取得JS
 *                                  
 *                                  
 */

function Create_JS_Rental($db_con){

	//レンタル単価取得
	$sql  = "SELECT\n";
	$sql .= "   t_goods.goods_id,\n";
	$sql .= "   t_goods.goods_cd,\n";
	//$sql .= "   t_g_product.g_product_name || '　' || t_goods.goods_name,\n";
	$sql .= "   t_goods.goods_cname,\n";
	$sql .= "   t_price.r_price, \n";
	$sql .= "   t_goods.g_product_id, \n";
	$sql .= "   t_goods.name_change \n";
	$sql .= " FROM\n";
	$sql .= "   t_goods \n";
	$sql .= "   INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
	$sql .= "   INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id\n";
	$sql .= " WHERE \n";
	$sql .= "   t_price.shop_id = 1 ";
	$sql .= " AND ";
	$sql .= "   t_price.rank_cd = '5' ";
	$sql .= " AND ";
	$sql .= "   t_goods.accept_flg = '1' ";
	$sql .= " AND ";
	$sql .= "   t_goods.rental_flg = 't' ";
	$sql .= " AND ";
	$sql .= "   t_goods.state = 1 ";
	$sql .= ";\n";
	$result = Db_Query($db_con, $sql);
	$goods_data = Get_Data($result,3);

	//TPLに商品データ取得JSを記述
	$java_sheet  = "function goods_display(id,cd,name,price1,price2,row,sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax,cost_coax){ \n";
	$java_sheet .= "	data = new Array(".count($goods_data)."); \n";
	for($g=0;$g<count($goods_data);$g++){
		//data[商品CD] = array(商品ID,商品CD,商品名,レンタル単価)
		$java_sheet .= "	data['".$goods_data[$g][1]."'] = new Array(".$goods_data[$g][0].",".$goods_data[$g][1].",'".$goods_data[$g][2]."','".$goods_data[$g][3]."','".$goods_data[$g][4]."','".$goods_data[$g][5]."'); \n";
	}


if ($_SESSION[group_kind] == "1") {
	$cost = " (goods_rcost(code))";
} else {
	$cost = "data[code][3]";
}

$java_sheet  .= <<<GOODS

	var goods_id   = id+"["+row+"]";         //商品ID
	var cd_name    = cd+"["+row+"]";         //商品コード
	var g_name     = name+"["+row+"]";       //商品名
	var r_price_i  = price1+"["+row+"][i]";  //レンタル単価
	var r_price_d  = price1+"["+row+"][d]"; 
	var u_price_i  = price2+"["+row+"][i]";  //ユーザ単価
	var u_price_d  = price2+"["+row+"][d]"; 
	var u_price_d  = price2+"["+row+"][d]"; 
	var g_product_id  = "form_g_product_id["+row+"]"; 
	var change_flg  = "form_g_product_id["+row+"]"; 

	//商品コード存在判定
	var code = document.dateForm.elements[cd_name].value;
	if(data[code] != undefined){
		//該当するデータを各フォームに代入
		document.dateForm.elements[goods_id].value     = data[code][0];
		document.dateForm.elements[g_name].value       = data[code][2];
		document.dateForm.elements[g_product_id].value = data[code][4];

		if(data[code][5] == "1"){
			document.forms[0].elements[g_name].readOnly = false;		
		}else{
			document.forms[0].elements[g_name].readOnly = true;		
		}


		//文字列分割
		var price_array = data[code][3].split("."); //レンタル単価
		var cost_array = $cost.split("."); //レンタル原価
		if(cost_array[0] == undefined) cost_array[0]='';
		if(cost_array[1] == undefined) cost_array[1]='';
		
		document.dateForm.elements[r_price_i].value = cost_array[0];
		document.dateForm.elements[r_price_d].value = cost_array[1];
		document.dateForm.elements[u_price_i].value = price_array[0];
		document.dateForm.elements[u_price_d].value = price_array[1];

		//金額計算JS
		Mult_double_ren(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax,true,cost_coax);
    }else{
		//該当データが無い場合はNULL
		document.dateForm.elements[goods_id].value    = "";
		document.dateForm.elements[cd_name].value     = "";
		document.dateForm.elements[g_name].value      = "";
		document.dateForm.elements[sale_num].value    = "";
		document.dateForm.elements[r_price_i].value   = "";
		document.dateForm.elements[r_price_d].value   = "";
		document.dateForm.elements[u_price_i].value   = "";
		document.dateForm.elements[u_price_d].value   = "";
		document.dateForm.elements[cost_amount].value = "";
		document.dateForm.elements[sale_amount].value = "";
	}
	
	return true;
}


//レンタル出荷日のフォーカス時に現在の日付を表示し、請求月にはその翌月を表示させる
function Forward_today(which,me,form_y,form_m,form_d,claim_y,claim_m){
	if (document.all || document.getElementById){
		which.style.backgroundColor="#FDFD66"
	}
	today   = new Date();
	Year    = today.getYear();
	Month   = today.getMonth()+1;
	Day     = today.getDate();

	var nextday = new Date(Year,Month,Day);
	today.setDate (today.getMonth () + 1); // 一ヶ月後に設定
	CYear       = nextday.getYear();
	CMonth      = nextday.getMonth()+1;

	var Y = form_y;
	var M = form_m;
	var D = form_d;
	//レンタル出荷日入力判定
	if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
		//レンタル出荷日に本日の日付表示
		me.elements[Y].value = Year;
		me.elements[M].value = Month;
		me.elements[D].value = Day;
		//一桁なら0を付ける
		if(me.elements[M].value <= 9){
				me.elements[M].value = "0" + Month;
		}
		if(me.elements[D].value <= 9){
				me.elements[D].value = "0" + Day;
		}
		//請求月に翌月の日付表示
		me.elements[claim_y].value = CYear;
		me.elements[claim_m].value = CMonth;
		//一桁なら0を付ける
		if(me.elements[claim_m].value <= 9){
				me.elements[claim_m].value = "0" + CMonth;
		}
	}
}

//レンタル出荷日のフォーカス移動
//次にその値の翌月の値を請求月に表示
function Rental_claim(me,name,next,length,for_y,for_m,claim_y,claim_m){
	var F1 = name;
	var F2 = next;
	
	var nextday = new Date(me.elements[for_y].value,me.elements[for_m].value,1);
	nextday.setDate (today.getMonth () + 1); // 一ヶ月後に設定
	CYear       = nextday.getYear();
	CMonth      = nextday.getMonth()+1;

	//請求月に翌月の日付表示
	me.elements[claim_y].value = CYear;
	me.elements[claim_m].value = CMonth;
	//一桁なら0を付ける
	if(me.elements[claim_m].value <= 9){
			me.elements[claim_m].value = "0" + CMonth;
	}


	len = me.elements[F1].value.length;
	if(length==len){
		me.elements[F2].focus();
	}
}

//フォーカス時に、翌日の日付を表示する
function onForm_nextday(which,me,form_y,form_m,form_d){
	if (document.all || document.getElementById){
		which.style.backgroundColor="#FDFD66"
	}
	today       = new Date();
    today.setDate (today.getDate () + 1); // 1日後に設定

	Year    = today.getYear();
	Month   = today.getMonth()+1;
	Day     = today.getDate();
	var Y = form_y;
	var M = form_m;
	var D = form_d;
	//既に入力されているか
	if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
		me.elements[Y].value = Year;
		me.elements[M].value = Month;
		me.elements[D].value = Day;
		//一桁なら0を付ける
		if(me.elements[M].value <= 9){
				me.elements[M].value = "0" + Month;
		}
		if(me.elements[D].value <= 9){
				me.elements[D].value = "0" + Day;
		}
	}
}


GOODS;

	return $java_sheet;
}

?>