<?php

/****************************/
// 契約、予定あたりで使用する関数郡
/****************************/
 /**
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-11-07                  suzuki      巡回区分が4・5・6の巡回日計算処理変更(suzuki-t)
 *  2006-11-07                  suzuki      基準日の月が一桁で入力されても伝票を作成するように修正(suzuki-t)
 *  2007-01-19                  morita-d    全巡回サイクルに基準日の月が一桁で入力されても伝票を作成するように修正
 *  2007-03-23                  morita-d    Aorder_Query,Stock_hand_Queryで使用する倉庫を基本倉庫でなく、担当者1の拠点倉庫に修正
 *  2007-04-09                  morita-d    引数の$cal_periは使用されていないためデフォルトNULLに変更
 *  2007-04-28                  morita-d    Aorder_Query：オンライン代行からオフライン代行に変更すると以前の伝票が削除されずに残る不具合を修正
 *  2007-05-23                  morita-d    Aorder_Query：現金の代行伝票を作成可能に修正
 *  2007-07-02                  fukuda      Get_Round_Day：カレンダー表示期間を元にした終了日を無視して
 *                                                         $e_dayで指定した日までの巡回日を作成できるよう修正（専用の引数追加）
 *  2007/08/29                  kajioka-h   Create_Js：代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じにする
 *  2009/12/24                  aoyama-n    税率をTaxRateクラスから取得 
 *
 *
 */


 /**
 *
 * カレンダー表示期間を考慮した巡回日を計算します。
 *
 * 変更履歴
 * 1.0.0 (2006/05/22) 新規作成(suzuki-t)
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $cycle          周期
 * @param               string      $cale_week      週名（1〜4）
 * @param               string      $abcd_week      週名（ABCD）
 * @param               string      $rday           指定日
 * @param               string      $week_rday      指定曜日
 * @param               string      $stand_day      基準日
 * @param               string      $round_div      巡回区分
 * @param               string      $start          対象開始期間
 * @param               string      $end            対象終了期間
 * @param               string      $cal_peri       カレンダー表示期間　⇒　この変数は使用されていません。
 *
 * @return              array       $date_array
 *
 */
function Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start,$end,$cal_peri=NULL){

    //巡回日計算処理判定
    switch($round_div){
        //巡回日１    
        case '1':

			//巡回基準日
			$sql  = "SELECT stand_day FROM t_stand;";
			$result = Db_Query($db_con, $sql); 
			$r_stand_day = pg_fetch_result($result,0,0);   
			$day_by = substr($r_stand_day,0,4);
			$day_bm = substr($r_stand_day,5,2);
			$day_bd = substr($r_stand_day,8,2);

			//本日 or 対象終了期間の日付
			$day_y = substr($start,0,4);
			$day_m = substr($start,5,2);
			$day_d = substr($start,8,2);

			//本日が何週の何日か取得処理
			$base_date = Basic_date($day_by,$day_bm,$day_bd,$day_y,$day_m,$day_d);
			
			//ABCD週の形式変更
			switch($abcd_week){
				case 5:
					//AC週の場合、基準をA週にする
					$abcd_week = 1;
					//２週間隔
					$num = 2;
					break;
				case 6:
					//BD週の場合、基準をB週にする
					$abcd_week = 2;
					//２週間隔
					$num = 2;
					break;
				case 21:
					//A週(8週間隔)
					$abcd_week = 1;
					//８週間隔
					$num = 8;
					break;
				case 22:
					//B週(8週間隔)
					$abcd_week = 2;
					//８週間隔
					$num = 8;
					break;
				case 23:
					//C週(8週間隔)
					$abcd_week = 3;
					//８週間隔
					$num = 8;
					break;
				case 24:
					//D週(8週間隔)
					$abcd_week = 4;
					//８週間隔
					$num = 8;
					break;
				default:
					//ABCD週
					//４週間隔
					$num = 4;
			}

			//曜日のvalue値変更(1:日2:月3:火4:水5:木6:金7:土)
			switch($week_rday){
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
					//日曜以外
					$week_rday++;
					break;
				case 7:
					//日曜
					$week_rday = 1;
					break;
			}

			//8週間隔の場合
			if($num == 8){

				//巡回基準日判定
				switch($abcd_week){
					case 1:
						//A週
						$now = mktime(0, 0, 0,$day_bm,$day_bd+($week_rday - 1),$day_by);
						break;
					case 2:
						//B週
						$now = mktime(0, 0, 0,$day_bm,$day_bd+7+($week_rday - 1),$day_by);
						break;
					case 3:
						//C週
						$now = mktime(0, 0, 0,$day_bm,$day_bd+14+($week_rday - 1),$day_by);
						break;
					case 4:
						//D週
						$now = mktime(0, 0, 0,$day_bm,$day_bd+21+($week_rday - 1),$day_by);
						break;
				}
				$day_y = date("Y",$now);            
				$day_m = date("m",$now);
				$day_d = date("d",$now);
				
				$day_num = 56; //８周期の日数

				//直近の巡回日取得
				$now = mktime(0, 0, 0, $day_m,$day_d+$day_num,$day_y);
				$round_day = date("Y-m-d",$now);
				//対象開始期間になるまで、８週間隔づつ足す
				while($start." 00:00" > $round_day." 00:00"){
					$day_num = $day_num + 56;
					$now = mktime(0, 0, 0, $day_m,$day_d+$day_num,$day_y);
					$round_day = date("Y-m-d",$now);
				}
				//対象期間内なら巡回日配列に追加
				if($round_day." 00:00" <= $end." 00:00"){
					$date_array[] = $round_day;
				}

			//４週間隔・２週間隔の場合
			}else{
			
				//直近の巡回日計算処理
				$day_num = ($abcd_week - $base_date[0])*7 + ($week_rday - $base_date[1]);
				//値がマイナスの場合、(7日×週間隔)を足す
				while($day_num < 0){
					$day_num = $day_num + (7 * $num);
				}

				//直近の巡回日
				$now = mktime(0, 0, 0, $day_m,$day_d+$day_num,$day_y);
				$round_day = date("Y-m-d",$now);
				//対象期間内なら巡回日配列に追加
				//if(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){
				if(($start <= $round_day) && ($round_day <= $end)){
					$date_array[] = $round_day;
				}
			}

			//周期の日数の間隔計算
			$num = $num * 7;
			//カレンダー表示期間の間表示
			$count = 0;

			//巡回日が対象期間内の間、巡回日配列に追加
			while(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){

				$count = $num + $count;
				$now = mktime(0, 0, 0, $day_m,$day_d+$day_num+$count,$day_y);
				$round_day = date("Y-m-d",$now);
				//表示期間を過ぎたらループを抜ける
				if(($round_day." 00:00" <= $end." 00:00")){

						$date_array[] = $round_day;

				}else{
					break;
				}
			}

            break;
        //巡回日２    
        case '2':

			//基準日が対象終了期間より前の場合に、巡回日作成処理実行
			if($stand_day <= $end){
				//巡回日開始判定
				if($stand_day <= $start){
					//対象開始期間の日付を巡回日開始に設定
					$day_y = str_pad(substr($start,0,4),4,0,STR_PAD_LEFT);
					$day_m = str_pad(substr($start,5,2),2,0,STR_PAD_LEFT);
				}else{
					//基準日の日付を巡回日開始に設定
					$day_y = str_pad(substr($stand_day,0,4),4,0,STR_PAD_LEFT);
					$day_m = str_pad(substr($stand_day,5,2),2,0,STR_PAD_LEFT);
				}

				//月末判定
				if($rday != 30 && $rday != 29){
					//1〜28日
					$now = mktime(0, 0, 0, $day_m,$rday,$day_y);
				}else{
					//月末
					$time = mktime(0, 0, 0, $day_m,1,$day_y);
					$num = date("t",$time);
					$now = mktime(0, 0, 0, $day_m,$num,$day_y);
				}
				$round_day = date("Y-m-d",$now);
				$i = 1;

				//今月の巡回日が、対象開始期間より前の場合は、次の巡回日を再計算
				if($round_day < $start){
					//月末判定
				if($rday != 30 && $rday != 29){
						//1〜28日
						$now = mktime(0, 0, 0, $day_m+$i,$rday,$day_y);
					}else{
						//月末
						$time = mktime(0, 0, 0, $day_m+$i,1,$day_y);
						$num = date("t",$time);
						$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					}
					$round_day = date("Y-m-d",$now);
					$i++;
				}

				//巡回日が対象期間内の間、巡回日配列に追加
				while(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){
					$date_array[] = $round_day;

					//月末判定
				if($rday != 30 && $rday != 29){
						//1〜28日
						$now = mktime(0, 0, 0, $day_m+$i,$rday,$day_y);
					}else{
						//月末
						$time = mktime(0, 0, 0, $day_m+$i,1,$day_y);
						$num = date("t",$time);
						$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					}
					$round_day = date("Y-m-d",$now);
					$i++;
				}
			}

            break;
        //巡回日３    
        case '3':
			//基準日が対象終了期間より前の場合に、巡回日作成処理実行
			if($stand_day <= $end){
				//巡回日開始判定
				if($stand_day <= $start){
					//対象開始期間の日付を巡回日開始に設定
					$day_y = str_pad(substr($start,0,4),4,0,STR_PAD_LEFT);
					$day_m = str_pad(substr($start,5,2),2,0,STR_PAD_LEFT);
				}else{
					//基準日の日付を巡回日開始に設定
					$day_y = str_pad(substr($stand_day,0,4),4,0,STR_PAD_LEFT);
					$day_m = str_pad(substr($stand_day,5,2),2,0,STR_PAD_LEFT);
				}

				//巡回日計算
				$num = Day_Get($day_y,$day_m,$cale_week,$week_rday);   
				$now = mktime(0, 0, 0, $day_m,$num,$day_y);
				$round_day = date("Y-m-d",$now);
				$i = 1;

				//今月の巡回日が、対象開始期間より前の場合は、次の巡回日を再計算
				if($round_day < $start){
					$num = Day_Get($day_y,$day_m+$i,$cale_week,$week_rday);   
					$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					$round_day = date("Y-m-d",$now);
					$i++;
				}

				//巡回日が対象期間内の間、巡回日配列に追加
				while(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){
					$date_array[] = $round_day;

					$num = Day_Get($day_y,$day_m+$i,$cale_week,$week_rday);   
					$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					$round_day = date("Y-m-d",$now);
					$i++;
				}
			}
 
            break;
        //巡回日４    
        case '4':
			//基準日が対象終了期間より前の場合に、巡回日作成処理実行
			if($stand_day <= $end){
				//基準日の日付を巡回日開始に設定
				$day_y = str_pad(substr($stand_day,0,4),4,0,STR_PAD_LEFT);
				$day_m = str_pad(substr($stand_day,5,2),2,0,STR_PAD_LEFT);
				$day_d = str_pad(substr($stand_day,8,2),2,0,STR_PAD_LEFT);

				$now = mktime(0, 0, 0, $day_m,$day_d,$day_y);
				$round_day = date("Y-m-d",$now);

				//基準日が対象期間の開始以後なら、巡回日に追加
				if($start." 00:00" <= $round_day." 00:00"){
					$date_array[] = $round_day;
				}

				//周期の日数の間隔計算
				$num = $cycle * 7;

				//カレンダー表示期間の間表示
				$count = 0;
				while($round_day." 00:00" <= $end." 00:00"){
					$count = $num + $count;
					$now = mktime(0, 0, 0, $day_m,$day_d+$count,$day_y);
					$round_day = date("Y-m-d",$now);
					//表示期間を過ぎたらループを抜ける
					if($round_day." 00:00" <= $end." 00:00"){
						//対象期間の開始以後の、巡回日だけ追加
						if($start." 00:00" <= $round_day." 00:00"){
							$date_array[] = $round_day;
						}
					}else{
						break;
					}
				}
			}

            break;
        //巡回日５    
        case '5':
			//基準日が対象終了期間より前の場合に、巡回日作成処理実行
			if($stand_day <= $end){
				//基準日の日付を巡回日開始に設定
				$day_y = str_pad(substr($stand_day,0,4),4,0,STR_PAD_LEFT);
				$day_m = str_pad(substr($stand_day,5,2),2,0,STR_PAD_LEFT);

				//基準月の巡回日登録
				//月末判定
				if($rday != 30 && $rday != 29){
					//1〜28日
					$now = mktime(0, 0, 0, $day_m,$rday,$day_y);
				}else{
					//月末
					$time = mktime(0, 0, 0, $day_m,1,$day_y);
					$num = date("t",$time);
					$now = mktime(0, 0, 0, $day_m,$num,$day_y);
				}
				$round_day = date("Y-m-d",$now);
				//基準日が対象期間の開始以後なら、巡回日に追加
				if($start." 00:00" <= $round_day." 00:00"){
					$date_array[] = $round_day;
				}

				//次の周期の巡回日計算
				$i = $cycle;
				//月末判定
				if($rday != 30 && $rday != 29){
					//1〜28日
					$now = mktime(0, 0, 0, $day_m+$i,$rday,$day_y);
				}else{
					//月末
					$time = mktime(0, 0, 0, $day_m+$i,1,$day_y);
					$num = date("t",$time);
					$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
				}
				$round_day = date("Y-m-d",$now);

				while($round_day." 00:00" <= $end." 00:00"){
					//巡回日が対象期間内の間、巡回日配列に追加
					if(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){
						$date_array[] = $round_day;
					}
					$i=$i+$cycle;

					//月末判定
				if($rday != 30 && $rday != 29){
						//1〜28日
						$now = mktime(0, 0, 0, $day_m+$i,$rday,$day_y);
					}else{
						//月末
						$time = mktime(0, 0, 0, $day_m+$i,1,$day_y);
						$num = date("t",$time);
						$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					}
					$round_day = date("Y-m-d",$now);
				}
  			}

            break;        
		//巡回日６    
        case '6': 
			//基準日が対象終了期間より前の場合に、巡回日作成処理実行
			if($stand_day <= $end){
				//基準日の日付を巡回日開始に設定
				$day_y = str_pad(substr($stand_day,0,4),4,0,STR_PAD_LEFT);
				$day_m = str_pad(substr($stand_day,5,2),2,0,STR_PAD_LEFT);

				//基準月の巡回日登録
				$num = Day_Get($day_y,$day_m,$cale_week,$week_rday);   
				$now = mktime(0, 0, 0, $day_m,$num,$day_y);
				$round_day = date("Y-m-d",$now);
				//基準日が対象期間の開始以後なら、巡回日に追加
				if($start." 00:00" <= $round_day." 00:00"){
					$date_array[] = $round_day;
				}

				//次の周期の巡回日計算
				$i = $cycle;
				$num = Day_Get($day_y,$day_m+$i,$cale_week,$week_rday);   
				$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
				$round_day = date("Y-m-d",$now);

				//巡回日が対象期間内の間、巡回日配列に追加
				while($round_day." 00:00" <= $end." 00:00"){
					//巡回日が対象期間内の間、巡回日配列に追加
					if(($start." 00:00" <= $round_day." 00:00") && ($round_day." 00:00" <= $end." 00:00")){
						$date_array[] = $round_day;
					}
					$i=$i+$cycle;

					$num = Day_Get($day_y,$day_m+$i,$cale_week,$week_rday);   
					$now = mktime(0, 0, 0, $day_m+$i,$num,$day_y);
					$round_day = date("Y-m-d",$now);
				}
   			}

            break; 
        //巡回日７    
        case '7':    
            break;
    }
    return $date_array;
}

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

function Cal_range($db_con,$shop_id,$range=false){

	$sql  = "SELECT ";
	$sql .= "    cal_peri ";           //カレンダー表示期間
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $shop_id;";
	$result = Db_Query($db_con, $sql);
	$cal_peri = pg_fetch_result($result,0,0);

	//カレンダー表示範囲計算判定
	if($range == true){
		//今月からカレンダー表示数が範囲

		//対象期間（開始）取得
		$day_y = date("Y");            
		$day_m = date("m");
		$day_d = date("d");
		$start_day = $day_y."-".$day_m."-".$day_d;

		//対象期間（終了）取得
        $end_day  = date("Y-m-", mktime(0, 0, 0, $day_m + $cal_peri,1,$day_y));
        $end_day .= date("t", mktime(0, 0, 0, $day_m + $cal_peri,1,$day_y));

	}else{
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

	}

	$cal_array[0] = $start_day;
	$cal_array[1] = $end_day;
	$cal_array[2] = $cal_peri+1;
	$cal_array[3] = $cal_day;

	return $cal_array;
}

 /**
 * コースID取得関数
 *
 * 変更履歴
 * 1.0.0 (2006/08/30) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/08/30)
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $contract_id    契約情報ID
 * @param               string      $staff_id       巡回担当者ID
 * @param               string      $shop_id        ショップID
 *
 * @return              string      $course_data[0]      コースID
 *                      string      $course_data[1]      コース名
 */

function Course_Id_Get($db_con,$contract_id,$staff_id,$shop_id){

	//契約情報取得
	$sql  = "SELECT ";
	$sql .= "    round_div,";   //巡回区分
	$sql .= "    abcd_week,";   //週名(ABCD)
	$sql .= "    cale_week,";   //週名(1-4)
	$sql .= "    week_rday,";   //指定曜日
	$sql .= "    rday ";        //指定日
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql);
	$con_data = Get_Data($result);

	//コースID取得
	$sql  = "SELECT ";
	$sql .= "    course_id,";       //コースID
	$sql .= "    course_name,";     //コース名
	$sql .= "    round_div ";       //巡回区分
	$sql .= "FROM ";
	$sql .= "    t_course ";
	$sql .= "WHERE ";
	$sql .= "    staff_id = $staff_id ";
	$sql .= "AND ";
	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    shop_id IN (".Rank_Sql().") ";
	}else{
	    $sql .= "    shop_id = $shop_id ";
	}

	$sql .= " AND ";
	if($con_data[0][0] != NULL){
		$sql .= "    round_div = '".$con_data[0][0]."'";
	}else{
		$sql .= "    round_div IS NULL ";
	}
	$sql .= " AND ";
	if($con_data[0][1] != NULL){
		$sql .= "    abcd_week = '".$con_data[0][1]."'";
	}else{
		$sql .= "    abcd_week IS NULL ";
	}
	$sql .= " AND ";
	if($con_data[0][2] != NULL){
		$sql .= "    cale_week = '".$con_data[0][2]."'";
	}else{
		$sql .= "    cale_week IS NULL ";
	}
	$sql .= " AND ";
	if($con_data[0][3] != NULL){
		$sql .= "    week_rday = '".$con_data[0][3]."'";
	}else{
		$sql .= "    week_rday IS NULL ";
	}
	$sql .= " AND ";
	if($con_data[0][4] != NULL){
		$sql .= "    rday = ".$con_data[0][4].";";
	}else{
		$sql .= "    rday IS NULL;";
	}
	$result = Db_Query($db_con, $sql);
	$count = pg_num_rows($result);
	if($count != 0){
		$course_data[0] = pg_fetch_result($result,0,0);
		$course_data[1] = pg_fetch_result($result,0,1);
		$course_data[2] = pg_fetch_result($result,0,2);
		//コース名が無い場合は、名前に「未設定」を設定
		if($course_data[1] == NULL){
			$course_data[1] = "未設定";
		}
	}else{
		//該当するデータが無い場合は、「未設定」を設定
		$course_data[1] = "未設定";
	}

	return $course_data;
}


//ある得意先の全契約を対象に予定データを作成する
function Regist_Aord_Client($db_con,$shop_id,$client_id,$start_day,$end_day,$trust_id=NULL,$cron_flg=NULL){

	//対象の受注ヘッダを削除
	$sql  = "SELECT contract_id FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $client_id ";
	$sql .= "AND ";
	$sql .= "    state = '1' "; //取引中の契約
	$sql .= "ORDER BY line ";
	$result = Db_Query($db_con, $sql);

	while($con_info = pg_fetch_array($result)){
		$contract_id = $con_info[contract_id];
		
		//契約ごとに予定データを作成する
		$return = Regist_Aord_Contract($db_con,$shop_id,$contract_id,$start_day,$end_day,$trust_id,$cron_flg);
		if($return === false){
			return false;
		}

	}

	return true;

}



//ある得意先の1契約を対象に予定データを作成する
//【注】$trust_id がある場合は代行でなく「オンライン代行」と判定される
function Regist_Aord_Contract($db_con,$shop_id,$contract_id,$start_day,$end_day,$trust_id=NULL,$cron_flg=NULL){

	/****************************/
	//外部変数取得
	/****************************/
	$staff_id    = $_SESSION["staff_id"];     //ログイン者ID
	$staff_name  = $_SESSION["staff_name"];   //ログイン者名

	/****************************/
	//得意先情報取得
	/****************************/
	//■契約情報取得
	$contract_info = Get_Contract_Info($db_con,$contract_id);
	$client_id        = $contract_info[client_id];      //得意先ID
	$shop_id          = $contract_info[shop_id];        //ショップID
	$tmp_trust_id     = $contract_info[trust_id];       //代行先
	$contract_div     = $contract_info[contract_div];   //契約区分

	//■得意先情報取得
	$client_info = Get_Client_Info($db_con,$client_id);
	$coax            = $client_info[coax];             //丸め区分（商品）
	$client_name     = $client_info[client_name];      //顧客名1
	$client_name2    = $client_info[client_name2];     //顧客名2
	$client_cname    = $client_info[client_cname];     //顧客名（略称）
	$client_cd       = $client_info[client_cd];        //得意先CD
	$client_cd1      = $client_info[client_cd1];       //得意先CD1
	$client_cd2      = $client_info[client_cd2];       //得意先CD2
	$trade_id        = $client_info[trade_id];         //取引コード
	$tax_franct      = $client_info[tax_franct];       //消費税（端数区分）
	$slip_out        = $client_info[slip_out];         //伝票形式

	//■紹介口座先情報取得
	$intro_info = Get_Intro_Info($db_con,$client_id);
	$ac_name            = $intro_info[client_cname];      //紹介口座先
	$client_ac_id       = $intro_info[intro_account_id];  //紹介口座ID
	$cshop_id           = $intro_info[cclient_shop];      //担当支店ID
	$intro_ac_cd1       = $intro_info[client_cd1];        //紹介口座先コード1
	$intro_ac_cd2       = $intro_info[client_cd2];        //紹介口座先コード2
	$intro_account_coax = $intro_info[coax];              //紹介口座先丸め区分

	//■担当支店の情報を抽出
	$cshop_info = Get_Client_Info($db_con,$cshop_id);
    #2009-12-24 aoyama-n
	#$tax_num    = $cshop_info[tax_rate_n];        //消費税(現在)
	$rank_cd    = $cshop_info[rank_cd];           //顧客区分CD

	//代行の場合
	if($contract_div == "2" || $contract_div == "3"){
		//■代行先情報取得
		$act_info = Get_Client_Info($db_con,$tmp_trust_id);
		$act_cname   = $act_info[client_cname];        //代行先名（略称）
		$act_cd1     = $act_info[client_cd1];          //代行先コード1
		$act_cd2     = $act_info[client_cd2];          //代行先コード2
	}

	//オンライン代行の場合は代行先情報を取得（rank_cdを上書き）
	if($contrat_div == "2"){
		$rank_cd     = $act_info[rank_cd];             //代行先の顧客区分CD
	}
	
	/****************************/
	//未付番の受注ヘッダ削除
	/****************************/
	//契約から起こした受注ID取得
	$sub_sql  = "SELECT ";
	$sub_sql .= "    t_aorder_h.aord_id ";
	$sub_sql .= "FROM ";
	$sub_sql .= "    t_aorder_h ";
	$sub_sql .= "WHERE ";
	$sub_sql .= "    t_aorder_h.contract_id = $contract_id ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_h.ord_no IS NULL ";
	$sub_sql .= "AND ";

	//オンライン代行の場合
	if($trust_id != NULL){
		//受託先IDを見るようにする
		$sub_sql .= "    t_aorder_h.act_id = $trust_id  \n";
		$sub_sql .= "AND ";
		$sub_sql .= "    t_aorder_h.contract_div = '2' ";

	//通常・オフライン代行
	}else{
		$sub_sql .= "    t_aorder_h.shop_id = $shop_id  \n";
	}
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_h.ord_time >= '$start_day' ";

	//対象の受注ヘッダを削除
	$sql  = "DELETE FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id IN ($sub_sql);";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		return false;
	}

	/****************************/
	//契約データ取得処理
	/****************************/
	$con_info = Get_Contract_Detail($db_con,$contract_id,$shop_id,$trust_id,$rank_cd,$start_day,$end_day);
	//print_array($con_info);

	//0件の場合
	if($con_info === false){
		return true;
	}
	$count = count($con_info); 
	//****************************
	//受注ヘッダ登録処理
	//****************************
	$update_id = NULL;    //ヘッダーの金額を更新する受注ID配列
	//契約商品分ループ
	for($i=0;$i<$count;$i++){
		$intro_ac_div   = $con_info[$i]["intro_ac_div"];
		$intro_ac_price = $con_info[$i]["intro_ac_price"];
		$intro_ac_rate  = $con_info[$i]["intro_ac_rate"];
		$act_div        = $con_info[$i]["act_div"];
		$act_price      = $con_info[$i]["act_request_price"];
		$act_rate       = $con_info[$i]["act_request_rate"];
		$staff_id1      = $con_info[$i]["staff_id1"]; //担当者メイン
		$round_data     = Convert_Round_Day($db_con, $con_info[$i]);
		$contract_div   = $con_info[$i]["contract_div"];

		//巡回担当者登録配列
		$staff_check = NULL;
		$staff_check[] = $con_info[$i]["staff_id1"];  //メイン１
		$staff_check[] = $con_info[$i]["staff_id2"];  //サブ２
		$staff_check[] = $con_info[$i]["staff_id3"];  //サブ３
		$staff_check[] = $con_info[$i]["staff_id4"];  //サブ４

		//売上率登録配列
		$staff_rate = NULL;
		$staff_rate[] = $con_info[$i]["sale_rate1"];   //売上率１
		$staff_rate[] = $con_info[$i]["sale_rate2"];   //売上率２
		$staff_rate[] = $con_info[$i]["sale_rate3"];   //売上率３
		$staff_rate[] = $con_info[$i]["sale_rate4"];   //売上率４

		//■前受相殺の有無をチェックする
		if($con_info[$i]["advance_flg"] == "2"){
			$advance_flg_h = true;
		}

		//■拠点倉庫を取得
		if($staff_id1 != NULL){
			//担当者1の拠点倉庫ID
			$ware_id   = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $staff_id1));

			//担当者1の拠点倉庫名
			$sql       = "SELECT ware_name FROM t_ware WHERE ware_id = $ware_id ";
			$result    = Db_Query($db_con, $sql);
			$ware_name = @pg_fetch_result($result,0,0);

		//オフライン代行の場合
		}else{
			$ware_id   = NULL;
			$ware_name = NULL;
		}

		//新規受注ヘッダを作成すべきか判別する
		//（巡回日、契約IDが同じ場合は新規で作成しない。）
		$chk_aord = Chk_Aord_H($db_con,$cshop_id,$con_info[$i]);
		$aord_id       = $chk_aord["aord_id"];           //受注ID
		$confirm_flg   = $chk_aord["confirm_flg"];       //確定フラグ
		$t_confirm_flg = $chk_aord["trust_confirm_flg"]; //確定フラグ(受託先)
		$aord_no       = $chk_aord["ord_no"];            //受注番号

		//****************************
		//受注ヘッダー登録処理
		//****************************
		//受注ヘッダが存在しないかつ受注番号がなければ、登録処理
		if($aord_id == NULL && $aord_no == NULL){
			$aord_id   = Get_Pkey();

		//■前受相殺がある場合は取引区分を「売掛」に変更する
		if( $advance_flg_h === true){
			$trade_id = 11;
		}

			$aord_h_column = array(
				aord_id           => "$aord_id",
				ord_time          => $con_info[$i]["round_day"],
				client_id         => "$client_id",
				trade_id          => "$trade_id",
				hope_day          => $con_info[$i]["round_day"],
				arrival_day       => $con_info[$i]["round_day"],
				route             => $con_info[$i]["route"],
				ware_id           => $ware_id,
				ps_stat           => 1,
				shop_id           => $cshop_id,
				slip_out          => $slip_out,
				intro_ac_name     => $ac_name,
				intro_account_id  => $client_ac_id,
				contract_div      => $contract_div,
				act_id            => $con_info[$i]["trust_id"],
				act_request_rate  => $con_info[$i]["act_request_rate"],
				intro_ac_price    => $con_info[$i]["intro_ac_price"],
				intro_ac_rate     => $con_info[$i]["intro_ac_rate"],
				client_name       => $client_name,
				client_name2      => $client_name2,
				client_cname      => $client_cname,
				client_cd1        => $client_cd1,
				client_cd2        => $client_cd2,
				ware_name         => $ware_name,
				act_name          => $act_cname,
				claim_id          => $con_info[$i]["claim_id"],
				claim_div         => $con_info[$i]["claim_div"],
				round_form        => $round_data,
				act_cd1           => $act_cd1,
				act_cd2           => $act_cd2,
				ord_staff_id      => $staff_id,
				ord_staff_name    => $staff_name,
				intro_ac_div      => $intro_ac_div,
				intro_ac_cd1      => $intro_ac_cd1,
				intro_ac_cd2      => $intro_ac_cd2,
				act_div           => $act_div,
				act_request_price => $act_price,
				contract_id       => $con_info[$i]["contract_id"],
				pre_ord_time      => $con_info[$i]["round_day"],
			);

			//SQLインジェクション対策
			$aord_h_column = pg_convert($db_con,"t_aorder_h",$aord_h_column);
			//print_array($aord_h_column);

			$return = Db_Insert($db_con, "t_aorder_h", $aord_h_column);
			if($result === false){
				return false;
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
					$staff_data = Get_Data($result,2);

					$aord_staff_column = array(
						aord_id    => $aord_id,
						staff_div  => $c,
						staff_id   => $staff_check[$c],
						sale_rate  => $staff_rate[$c],
						staff_name => $staff_data[0][0],
					);
					$aord_staff_column = pg_convert($db_con,"t_aorder_staff",$aord_staff_column);//SQLインジェクション対策

					$return = Db_Insert($db_con, "t_aorder_staff", $aord_staff_column);
					if($result === false){
						return false;
					}
				}
			}
		}


		/****************************/                                                   
		//受注データ登録処理                                                           
		/****************************/
		//受注番号ない受注のみ登録
		if($aord_no == NULL){
			$aord_d_id   = Get_Pkey();

			$serv_data = NULL;
			//■サービス
			//サービスが入力された場合
			if($con_info[$i][serv_id] != NULL){
				//サービス情報を取得
				$sql  = "SELECT ";
				$sql .= "    t_serv.serv_name,"; 
				$sql .= "    t_serv.serv_cd, ";    
				$sql .= "    t_serv.tax_div ";    
				$sql .= "FROM ";
				$sql .= "    t_serv ";
				$sql .= "WHERE ";
				$sql .= "    t_serv.serv_id = ".$con_info[$i][serv_id].";";
				$result = Db_Query($db_con, $sql);
				$serv_data  = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			}

			//■商品
			//商品指定判定
			$item_data = NULL;
			if($con_info[$i][goods_id] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd, ";
				$sql .= "    t_goods.compose_flg, ";
				$sql .= "    t_goods.public_flg, ";
				$sql .= "    t_g_product.g_product_name,";
				$sql .= "    t_goods.goods_name ";
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$con_info[$i][goods_id].";";
				$result = Db_Query($db_con, $sql);
				$item_data = Get_Data($result,3);

				//■構成品
				//構成品判定
				if($item_data[0][1] == 't'){
					//構成品親の在庫単価取得
					$price_array = NULL;
					//代行判定
					if($trust_id != NULL){
						//オンライン代行
						$price_array = Compose_price($db_con,$trust_id,$con_info[$i][goods_id]);
					}else{
						//自社巡回・オフライン代行
						$price_array = Compose_price($db_con,$cshop_id,$con_info[$i][goods_id]);
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
					$sql .= "    t_goods.goods_id = ".$con_info[$i][goods_id];
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

			//■本体商品
			//本体商品指定判定
			$body_data = NULL;
			if($con_info[$i][rgoods_id] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$con_info[$i][rgoods_id].";";
				$result = Db_Query($db_con, $sql);
				$body_data = Get_Data($result,3);
			}

			//■消耗品
			//消耗品指定判定
			$egoods_data = NULL;
			if($con_info[$i][egoods_id] != NULL){ 
				//履歴用カラムデータ取得
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_cd ";    
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "WHERE ";
				$sql .= "    t_goods.goods_id = ".$con_info[$i][egoods_id].";";
				$result = Db_Query($db_con, $sql);
				$egoods_data = Get_Data($result,3);
			}

			//■課税区分・仕入単価
			//課税区分がない場合（アイテム無しの場合）
			if($con_info[$i][tax_div] == NULL){
				$regist_tax_div = $serv_data[tax_div]; //サービスの課税区分を登録

				//受託先判定
				if($trust_id != NULL){
					//仕入単価には営業原価(受託先)を登録
					$regist_buy_price = $con_info[$i][trust_cost_price]; 
				}else{
					//仕入単価には営業原価を登録
					$regist_buy_price = $con_info[$i][trade_price]; 
				} 

			//課税区分がある場合（アイテムありの場合）
			}else{
				$regist_tax_div   = $con_info[$i][tax_div]; //アイテムの課税区分
				$regist_buy_price = $buy_price;             //仕入単価
			}

			//■仕入金額
			//仕入単価あり（アイテムの場合）
			if ($buy_price !== NULL){
				//仕入金額計算処理
				$buy_amount = bcmul($buy_price,$con_info[$i][num],2);
				$buy_amount = Coax_Col($coax, $buy_amount);                                    

			//アイテムはあるが在庫単価がないは仕入金額を0 （このif文は通らないのでは？）
			}elseif ($con_info[$i][goods_id] != NULL){
					$buy_amount = 0;

			//サービスのみ
			}else{
				//受託でない
				if($trust_id != NULL){
					$buy_amount = $con_info[$i][trust_cost_amount];//サービスのみは、営業金額(受託先)を入れる

				//受託の場合
				}else{
					$buy_amount = $con_info[$i][trade_amount]; //サービスのみは、営業金額を入れる
				}  
			}  

			$aord_d_column = array(
				aord_d_id             => $aord_d_id,
				aord_id               => $aord_id,
				line                  => $con_info[$i]["line"],
				sale_div_cd           => $con_info[$i]["divide"],
				serv_print_flg        => $con_info[$i]["serv_pflg"],
				serv_id               => $con_info[$i]["serv_id"],
				set_flg               => $con_info[$i]["set_flg"],
				goods_print_flg       => $con_info[$i]["goods_pflg"],
				goods_id              => $con_info[$i]["goods_id"],
				goods_name            => $con_info[$i]["goods_name"],
				
				num                   => $con_info[$i]["num"],
				tax_div               => $regist_tax_div,
				buy_price             => $regist_buy_price,
				cost_price            => $con_info[$i]["trade_price"],
				sale_price            => $con_info[$i]["sale_price"],
				buy_amount            => $buy_amount,
				cost_amount           => $con_info[$i]["trade_amount"],
				sale_amount           => $con_info[$i]["sale_amount"],
				rgoods_id             => $con_info[$i]["rgoods_id"],
				rgoods_name           => $con_info[$i]["rgoods_name"],
				
				rgoods_num            => $con_info[$i]["rgoods_num"],
				egoods_id             => $con_info[$i]["egoods_id"],
				egoods_name           => $con_info[$i]["egoods_name"],
				egoods_num            => $con_info[$i]["egoods_num"],
				contract_id           => $con_info[$i]["contract_id"],
				account_price         => $con_info[$i]["account_price"],
				account_rate          => $con_info[$i]["account_rate"],
				trust_cost_price      => $con_info[$i]["trust_cost_price"],
				trust_cost_amount     => $con_info[$i]["trust_cost_amount"],
				serv_name             => $serv_data["serv_name"],
				serv_cd               => $serv_data["serv_cd"],
				goods_cd              => $item_data[0][0],
				rgoods_cd             => $body_data[0][0],
				egoods_cd             => $egoods_data[0][0],
				g_product_name        => $item_data[0][3],
				official_goods_name   => $con_info[$i]["official_goods_name"],
				mst_sync_flg          => $con_info[$i]["mst_sync_flg"],
				trust_mst_sync_flg    => $con_info[$i]["trust_mst_sync_flg"],
				advance_flg           => $con_info[$i]["advance_flg"],
				advance_offset_amount => $con_info[$i]["advance_offset_amount"],
			);
			//SQLインジェクション対策
			$aord_d_column = pg_convert($db_con,"t_aorder_d",$aord_d_column);
	
			//print_array($aord_d_column);
			$return = Db_Insert($db_con, "t_aorder_d", $aord_d_column);
			if($result === false){
				return false;
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
			$sql .= "    con_info_id = ".$con_info[$i][con_info_id].";";
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
					return false;
				}
	
				//通常・オンライン代行のみ受払登録
				if($con_info[$i][contract_div] != '3'){
					/****************************/
					//受払テーブルに登録関数
					/****************************/
					$result = Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship_list[$d][0],$ship_list[$d][2],'keiyaku',$con_info[$i][trust_id]);
					if($result === false){
						return false;
					}
				}
			}

			//受注ヘッダーに原価金額・売上金額・消費税額を登録する受注ID取得
			$update_id[] = $aord_id; 
		}
	}


	//****************************
	//受注ヘッダ金額アップデート
	//****************************
	if( 0 < count($update_id) ){
	    $update_id = array_unique($update_id);
		foreach($update_id AS $key => $id){

			//受注データ取得
			$sql  = "SELECT ";
			$sql .= "    tax_div,";            //課税区分0
			$sql .= "    cost_amount,";        //営業金額1
			$sql .= "    sale_amount,";        //売上金額2
			$sql .= "    '',";                 //営業金額(受託先)3
			$sql .= "    account_price,";      //口座単価4
			$sql .= "    account_rate ";       //口座率5
			$sql .= "FROM ";
			$sql .= "    t_aorder_d ";
			$sql .= "WHERE ";
			$sql .= "    aord_id = ".$id.";";
			$result = Db_Query($db_con, $sql);
			$m_data = Get_Data($result,3);
	
			//ヘッダーに掛かるデータの金額を取得
			//合計金額の計算に使用する配列を初期化
			$tax_div      = NULL;
			$cost_data    = NULL;
			$sale_data    = NULL;
			$trust_data   = NULL;
			$intro_amount = NULL;

            #2009-12-24 aoyama-n
            //受注日取得
            $sql  = "SELECT ";
            $sql .= "    ord_time ";
            $sql .= "FROM ";
            $sql .= "    t_aorder_h ";
            $sql .= "WHERE ";
            $sql .= "    aord_id = ".$id.";";
            $result = Db_Query($db_con, $sql);
            $ord_time = pg_fetch_result($result,0,0);

            #2009-12-24 aoyama-n
            //税率クラス　インスタンス生成
            $tax_rate_obj = new TaxRate($cshop_id);
            $tax_rate_obj->setTaxRateDay($ord_time);
            $tax_num = $tax_rate_obj->getClientTaxRate($client_id);
	
			//****************************                                                   
			//紹介口座料算出（商品単位）                                                      
			//****************************
			for($c=0;$c<count($m_data);$c++){
				$tax_div[$c]    = $m_data[$c][0];
				$cost_data[$c]  = $m_data[$c][1];
				$sale_data[$c]  = $m_data[$c][2];
				
				//営業金額指定判定
				if($m_data[$c][3] != NULL){
					$trust_data[$c] = $m_data[$c][3];
				}
	
				if($intro_ac_div == "4"){
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
	
			//****************************                                                   
			//紹介口座料算出（得意先単位）                                                      
			//****************************
			//紹介口座料が売上％の場合
			if($intro_ac_div == "3"){
				$rate_money = bcmul($sale_money,bcdiv($intro_ac_rate,100,2),2);
				$rate_money = Coax_Col($intro_account_coax,$rate_money);
				$intro_amount = $rate_money; 
	
			//紹介口座料が固定額の場合
			}else if($intro_ac_div == "2"){
				$intro_amount = $intro_ac_price; 
	
			//紹介口座料なしの場合
			}else if($intro_ac_div == "1"){
				$intro_amount = NULL;
			}
	
			$aord_h_column = array(
				cost_amount       => $cost_amount,  //営業金額
				net_amount        => $sale_money,   //売上金額
				tax_amount        => $sale_tax,     //消費税
				trust_cost_amount => $trust_money,  //営業金額(税抜)
				intro_amount      => $intro_amount, //紹介料
			);
	
			//SQLインジェクション対策
			$aord_h_column = pg_convert($db_con,"t_aorder_h",$aord_h_column);
					
			//UPDATE条件
			$where[aord_id] = $id;
			$where          = pg_convert($db_con,"t_aorder_h",$where);
	
			//金額アップデート
			$result = Db_Update($db_con, t_aorder_h, $aord_h_column, $where);
			if($result === false){
				return false;
			}
	
			//代行料をアップデート
			Update_Act_Amount($db_con, $id,"aord");
			//echo $id."<br>";
	
		}
	}
	return $update_id;

}

//巡回形式を文字列に変換する
function Convert_Round_Day($db_con, $data_list){

	$round_div = $data_list["round_div"];
	$cycle     = $data_list["cycle"];
	$cale_week = $data_list["cale_week"];
	$abcd_week = $data_list["abcd_week"];
	$rday      = $data_list["rday"];
	$week_rday = $data_list["week_rday"];
	$stand_day = $data_list["stand_day"];
	$last_day  = $data_list["last_day"];
	//巡回形式処理
	$round_data = NULL;
	if($round_div == "1"){
		//巡回１
		$round_data = $abcd_week.$week_rday;
		
	}else if($round_div == "2"){
		//巡回２
		$date_data = substr($stand_day,0,7);

		if($rday == "30"){
			$round_data = "毎月 月末 (".$date_data.")";
		}else{
			$round_data = "毎月 ".$rday."日 (".$date_data.")";
		}
	}else if($round_div == "3"){
		//巡回３
		$date_data = substr($stand_day,0,7);

		$round_data = "毎月".$cale_week.$week_rday."(".$date_data.")";
	}else if($round_div == "4"){
		//巡回４
		$round_data = $cycle."週間周期の".$week_rday."(".$stand_day.")";
	}else if($round_div == "5"){
		//巡回５
		$date_data = substr($stand_day,0,7);
		if($rday == "30"){
			$round_data = $cycle."ヶ月周期の 月末 (".$date_data.")";
		}else{
			$round_data = $cycle."ヶ月周期の ".$rday."日 (".$date_data.")";
		}
	}else if($round_div == "6"){
		//巡回６
		$date_data = substr($stand_day,0,7);

		$round_data = $cycle."ヶ月周期の ".$cale_week.$week_rday."(".$date_data.")";
	}else if($round_div == "7"){
		//巡回７
		$round_data = "変則日(最終日:".$last_day.")";
	}

	return $round_data;
}




//受注ヘッダをチェックする
function Chk_Aord_H($db_con,$cshop_id,$data_list){

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
	//$sql .= "    t_aorder_d.contract_id = ".$data_list[contract_id];
	$sql .= "    t_aorder_h.contract_id = ".$data_list[contract_id];
	$sql .= " AND ";
	$sql .= "    t_aorder_h.client_id = ".$data_list[client_id];
	$sql .= " AND ";
	$sql .= "    t_aorder_h.shop_id = $cshop_id ";
	$sql .= " AND ";
	$sql .= "    t_aorder_h.ord_time = '".$data_list[round_day]."'";
	$sql .= " AND ";
	$sql .= "    t_aorder_h.change_flg = 'f'";

/*
	//オフライン代行の場合は、順路条件なし
	if($data_list[contract_div] != '3'){
		$sql .= " AND ";
		$sql .= "    t_aorder_h.route = ".$data_list[route];
	}
	$sql .= " AND ";
	//担当者１が指定されているか
	if($data_list[staff_id1] != NULL){
		//指定あり
		$sql .= "    t_staff1.staff_id = ".$data_list[staff_id1];
	}else{
		//指定なし
		$sql .= "    t_staff1.staff_id IS NULL";
	}
	$sql .= " AND ";
	//売上率１が指定されているか
	if($data_list[sale_rate1] != NULL){
		//指定あり
		$sql .= "    t_staff1.sale_rate = ".$data_list[sale_rate1]." ";
	}else{
		//指定なし
		$sql .= "    t_staff1.sale_rate IS NULL";
	}
	$sql .= " AND ";
	//担当者２が指定されているか
	if($data_list[staff_id2] != NULL){
		//指定あり
		$sql .= "    t_staff2.staff_id = ".$data_list[staff_id2];
	}else{
		//指定なし
		$sql .= "    t_staff2.staff_id IS NULL";
	}
	$sql .= " AND ";
	//売上率２が指定されているか
	if($data_list[sale_rate2] != NULL){
		//指定あり
		$sql .= "    t_staff2.sale_rate = ".$data_list[sale_rate2]." ";
	}else{
		//指定なし
		$sql .= "    t_staff2.sale_rate IS NULL";
	}
	$sql .= " AND ";
	//担当者3が指定されているか
	if($data_list[staff_id3] != NULL){
		//指定あり
		$sql .= "    t_staff3.staff_id = ".$data_list[staff_id3];
	}else{
		//指定なし
		$sql .= "    t_staff3.staff_id IS NULL";
	}
	$sql .= " AND ";
	//売上率３が指定されているか
	if($data_list[sale_rate3] != NULL){
		//指定あり
		$sql .= "    t_staff3.sale_rate = ".$data_list[sale_rate3]." ";
	}else{
		//指定なし
		$sql .= "    t_staff3.sale_rate IS NULL";
	}
	$sql .= " AND ";
	//担当者4が指定されているか
	if($data_list[staff_id4] != NULL){
		//指定あり
		$sql .= "    t_staff4.staff_id = ".$data_list[staff_id4];
	}else{
		//指定なし
		$sql .= "    t_staff4.staff_id IS NULL";
	}
	$sql .= " AND ";
	//売上率４が指定されているか
	if($data_list[sale_rate4] != NULL){
		//指定あり
		$sql .= "    t_staff4.sale_rate = ".$data_list[sale_rate4]." ";
	}else{
		//指定なし
		$sql .= "    t_staff4.sale_rate IS NULL";
	}
*/
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$info   = pg_fetch_array($result, NULL, PGSQL_ASSOC);

	//print_array($info);
	return $info;
}



//契約データ取得処理
function Get_Contract_Detail($db_con,$contract_id,$shop_id,$trust_id,$rank_cd,$start_day,$end_day){

	$sql  = "SELECT  \n";
	$sql .= "    t_round.round_day, \n";              //巡回日 0
	$sql .= "    t_contract.route, \n";               //順路 1
	$sql .= "    t_con_aod.line, \n";                 //行No. 2
	$sql .= "    t_contract.contract_id, \n";         //契約情報ID 3
	$sql .= "    t_con_aod.divide, \n";               //販売区分コード 4
	$sql .= "    t_con_aod.serv_id, \n";              //サービスID 5
	$sql .= "    CASE t_con_aod.serv_pflg  \n";       //サービス印字フラグ 6
	$sql .= "         WHEN 't' THEN 'true' \n";
	$sql .= "         WHEN 'f' THEN 'false' \n";
	$sql .= "    END AS serv_pflg, \n";
	$sql .= "    CASE t_con_aod.set_flg  \n";         //一式フラグ 7
	$sql .= "         WHEN 't' THEN 'true' \n";
	$sql .= "         WHEN 'f' THEN 'false' \n";
	$sql .= "    END AS set_flg, \n";
	$sql .= "    CASE t_con_aod.goods_pflg  \n";      //アイテム印字フラグ 8
	$sql .= "         WHEN 't' THEN 'true' \n";
	$sql .= "         WHEN 'f' THEN 'false' \n";
	$sql .= "    END AS goods_pflg, \n";       
	$sql .= "    t_con_aod.goods_id, \n";             //アイテム商品ID 9
	$sql .= "    t_con_aod.goods_name, \n";           //アイテム名 10
	$sql .= "    t_con_aod.num, \n";                  //アイテム数 11
	$sql .= "    t_con_aod.tax_div, \n";              //アイテムの課税区分 12
	$sql .= "    t_con_aod.r_price, \n";              //アイテムの仕入単価 13
	$sql .= "    t_con_aod.trade_price, \n";          //営業原価 14
	$sql .= "    t_con_aod.sale_price, \n";           //売上単価 15
	$sql .= "    t_con_aod.trade_amount, \n";         //営業金額 16
	$sql .= "    t_con_aod.sale_amount, \n";          //売上金額 17
	$sql .= "    t_con_aod.rgoods_id, \n";            //本体商品ID 18
	$sql .= "    t_con_aod.rgoods_name,  \n";         //本体名 19
	$sql .= "    t_con_aod.rgoods_num, \n";           //本体数 20
	$sql .= "    t_con_aod.egoods_id, \n";            //消耗品ID 21
	$sql .= "    t_con_aod.egoods_name, \n";          //消耗品名 22
	$sql .= "    t_con_aod.egoods_num, \n";           //消耗品数 23

	$sql .= "    t_staff1.staff_id AS staff_id1, \n";              //メイン１ 24
	$sql .= "    t_staff1.sale_rate AS sale_rate1, \n";             //売上率 25
	$sql .= "    t_staff2.staff_id AS staff_id2, \n";              //サブ２ 26
	$sql .= "    t_staff2.sale_rate AS sale_rate2, \n";             //売上率 27
	$sql .= "    t_staff3.staff_id AS staff_id3, \n";              //サブ３ 28
	$sql .= "    t_staff3.sale_rate AS sale_rate3, \n";             //売上率 29
	$sql .= "    t_staff4.staff_id AS staff_id4, \n";              //サブ４ 30
	$sql .= "    t_staff4.sale_rate AS sale_rate4,  \n";            //売上率 31
		
	$sql .= "    t_con_aod.con_info_id,  \n";         //契約内容ID 32
	$sql .= "    t_contract.client_id, \n";           //得意先ID 33
	$sql .= "    t_con_aod.account_price, \n";        //口座単価 34
	$sql .= "    t_con_aod.account_rate,  \n";        //口座率 35

	$sql .= "    t_contract.contract_div, \n";        //契約区分 36
	$sql .= "    t_contract.trust_id,  \n";           //代行ID 37
	$sql .= "    t_contract.act_request_rate,  \n";   //代行依頼料 38
	//$sql .= "    t_con_aod.trust_trade_price, \n";    //営業原価(受託) 39
	//$sql .= "    t_con_aod.trust_trade_amount,  \n";  //営業金額(受託) 40
	$sql .= "    t_con_aod.trust_cost_price, \n";     //営業原価(受託) 39
	$sql .= "    t_con_aod.trust_cost_amount,  \n";   //営業金額(受託) 40

	$sql .= "    t_contract.intro_ac_price, \n";      //紹介口座単価 41
	$sql .= "    t_contract.intro_ac_rate,   \n";     //紹介口座率 42
	$sql .= "    t_contract.claim_id, \n";            //請求先ID 43
	$sql .= "    t_contract.claim_div,   \n";         //請求先区分 44

	$sql .= "    t_contract.round_div, \n";           //巡回区分45
	$sql .= "    t_contract.cycle, \n";               //周期46
	$sql .= "    t_contract.cycle_unit, \n";          //周期単位47
	$sql .= "    CASE t_contract.cale_week  \n";      //週名(1-4)48
	$sql .= "        WHEN '1' THEN ' 第1' \n";
	$sql .= "        WHEN '2' THEN ' 第2' \n";
	$sql .= "        WHEN '3' THEN ' 第3' \n";
	$sql .= "        WHEN '4' THEN ' 第4' \n";
	$sql .= "    END AS cale_week, \n";
	$sql .= "    CASE t_contract.abcd_week  \n";                //週名(ABCD)49
	$sql .= "        WHEN '1' THEN 'A(4週間隔)週' \n";
	$sql .= "        WHEN '2' THEN 'B(4週間隔)週' \n";
	$sql .= "        WHEN '3' THEN 'C(4週間隔)週' \n";
	$sql .= "        WHEN '4' THEN 'D(4週間隔)週' \n";
	$sql .= "        WHEN '5' THEN 'A,C(2週間隔)週' \n";
	$sql .= "        WHEN '6' THEN 'B,D(2週間隔)週' \n";
	$sql .= "        WHEN '21' THEN 'A(8週間隔)週' \n";
	$sql .= "        WHEN '22' THEN 'B(8週間隔)週' \n";
	$sql .= "        WHEN '23' THEN 'C(8週間隔)週' \n";
	$sql .= "        WHEN '24' THEN 'D(8週間隔)週' \n";
	$sql .= "    END AS abcd_week, \n";
	$sql .= "    t_contract.rday,  \n";                         //指定日50
	$sql .= "    CASE t_contract.week_rday  \n";                //指定曜日51
	$sql .= "        WHEN '1' THEN ' 月曜' \n";
	$sql .= "        WHEN '2' THEN ' 火曜' \n";
	$sql .= "        WHEN '3' THEN ' 水曜' \n";
	$sql .= "        WHEN '4' THEN ' 木曜' \n";
	$sql .= "        WHEN '5' THEN ' 金曜' \n";
	$sql .= "        WHEN '6' THEN ' 土曜' \n";
	$sql .= "        WHEN '7' THEN ' 日曜' \n";
	$sql .= "    END AS week_rday, \n";
	$sql .= "    t_contract.stand_day, \n";                     //作業基準日52
	$sql .= "    t_contract.last_day,  \n";                     //最終巡回日53
	$sql .= "    t_con_aod.official_goods_name,  \n";           //商品名（正式名）54
	$sql .= "    t_contract.intro_ac_div,  \n";                 //紹介口座料区分 55
	$sql .= "    t_contract.act_div,  \n";                      //代行料区分 56
	$sql .= "    t_contract.act_request_price,  \n";             //代行依頼料 57
	$sql .= "    t_con_aod.mst_sync_flg, \n";                   //商品マスタ同期フラグ
	$sql .= "    t_con_aod.trust_mst_sync_flg, \n";             //（受託先用）商品マスタ同期フラグ
	$sql .= "    t_con_aod.advance_flg, \n";                    //前受相殺フラグ
	$sql .= "    t_con_aod.advance_offset_amount  \n";          //前受相殺額
	$sql .= "FROM  \n";
	$sql .= "    (SELECT  \n";
	$sql .= "        t_con_info.con_info_id, \n";
	$sql .= "        t_con_info.contract_id, \n";
	$sql .= "        t_con_info.line, \n";
	$sql .= "        t_con_info.divide, \n";
	$sql .= "        t_con_info.serv_pflg, \n";
	$sql .= "        t_con_info.serv_id, \n";
	$sql .= "        t_con_info.set_flg, \n";
	$sql .= "        t_con_info.goods_pflg, \n";
	$sql .= "        t_con_info.goods_id, \n";
	$sql .= "        t_con_info.goods_name, \n"; 
	$sql .= "        t_con_info.num, \n";
	$sql .= "        t_con_info.rgoods_id, \n";
	$sql .= "        t_con_info.rgoods_name, \n"; 
	$sql .= "        t_con_info.rgoods_num, \n";
	$sql .= "        t_con_info.egoods_id, \n";
	$sql .= "        t_con_info.egoods_name, \n"; 
	$sql .= "        t_con_info.egoods_num, \n";
	$sql .= "        t_con_info.sale_price, \n";
	$sql .= "        t_con_info.sale_amount, \n";
	$sql .= "        t_con_info.trade_price, \n";
	$sql .= "        t_con_info.trade_amount, \n";
	$sql .= "        t_con_info.account_price, \n";
	$sql .= "        t_con_info.account_rate, \n";
	$sql .= "        t_price.r_price, \n";
	$sql .= "        t_goods.tax_div, \n";
	//$sql .= "        t_con_info.trust_trade_price, \n";
	//$sql .= "        t_con_info.trust_trade_amount,  \n";
	$sql .= "        t_con_info.official_goods_name,  \n";
	$sql .= "        t_con_info.trust_cost_price,  \n";
	$sql .= "        t_con_info.trust_cost_amount,  \n";
	$sql .= "        t_con_info.trust_sale_price,  \n";
	$sql .= "        t_con_info.trust_sale_amount,  \n";
	$sql .= "        t_con_info.mst_sync_flg,  \n";
	$sql .= "        t_con_info.trust_mst_sync_flg,  \n";
	$sql .= "        t_con_info.advance_flg,  \n";
	$sql .= "        t_con_info.advance_offset_amount  \n";
	$sql .= "    FROM  \n"; 
	$sql .= "        t_con_info  \n"; 
	$sql .= "        LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id  \n";
	$sql .= "        LEFT JOIN t_price ON t_con_info.goods_id = t_price.goods_id AND t_price.rank_cd = '$rank_cd' \n";
	$sql .= "    )AS t_con_aod  \n";

	$sql .= "    INNER JOIN t_contract ON t_contract.contract_id = t_con_aod.contract_id  \n";
	$sql .= "    INNER JOIN t_round ON t_contract.contract_id = t_round.contract_id  \n";

	$sql .= "    LEFT JOIN t_serv ON t_serv.serv_id = t_con_aod.serv_id  \n";

	$sql .= "    LEFT JOIN  \n";
	$sql .= "        (SELECT  \n";
	$sql .= "             t_con_staff.contract_id, \n";
	$sql .= "             t_con_staff.staff_id, \n";
	$sql .= "             t_con_staff.sale_rate  \n";
	$sql .= "         FROM  \n";
	$sql .= "             t_con_staff  \n";
	$sql .= "         WHERE  \n";
	$sql .= "             t_con_staff.staff_div = '0' \n";
	$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id  \n";
	 
	$sql .= "    LEFT JOIN  \n";
	$sql .= "        (SELECT  \n";
	$sql .= "             t_con_staff.contract_id, \n";
	$sql .= "             t_con_staff.staff_id, \n";
	$sql .= "             t_con_staff.sale_rate  \n";
	$sql .= "         FROM  \n";
	$sql .= "             t_con_staff  \n";
	$sql .= "         WHERE  \n";
	$sql .= "             t_con_staff.staff_div = '1' \n";
	$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id  \n";

	$sql .= "    LEFT JOIN  \n";
	$sql .= "        (SELECT  \n";
	$sql .= "             t_con_staff.contract_id, \n";
	$sql .= "             t_con_staff.staff_id, \n";
	$sql .= "             t_con_staff.sale_rate  \n";
	$sql .= "         FROM  \n";
	$sql .= "             t_con_staff  \n";
	$sql .= "         WHERE  \n";
	$sql .= "             t_con_staff.staff_div = '2' \n";
	$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id  \n";

	$sql .= "    LEFT JOIN  \n";
	$sql .= "        (SELECT  \n";
	$sql .= "             t_con_staff.contract_id, \n";
	$sql .= "             t_con_staff.staff_id, \n";
	$sql .= "             t_con_staff.sale_rate  \n";
	$sql .= "         FROM  \n";
	$sql .= "             t_con_staff  \n";
	$sql .= "         WHERE  \n";
	$sql .= "             t_con_staff.staff_div = '3' \n";
	$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id  \n";

	$sql .= "WHERE  \n";
	$sql .= "    t_contract.contract_id = $contract_id  \n";
	$sql .= "AND  \n";
	//受託先判定
	if($trust_id != NULL){
		//オンライン代行の場合は、受託先IDを見るようにする
		$sql .= "    t_contract.trust_id = $trust_id  \n";
		$sql .= "AND  \n";
		$sql .= "    t_contract.contract_div = '2'  \n";
	}else{
		//通常
		$sql .= "    t_contract.shop_id = $shop_id  \n \n";
		$sql .= "AND  \n";
		$sql .= "    t_contract.contract_div IN('1','3')  \n";
	}
	$sql .= "AND  \n";
	$sql .= "    t_round.round_day >= '$start_day'  \n";
	$sql .= "AND  \n";
	$sql .= "    t_round.round_day <= '$end_day'  \n";
	$sql .= "AND  \n";
	$sql .= "    t_contract.request_state = '2'  \n";
	$sql .= "ORDER BY  \n";
	$sql .= "    t_contract.contract_id, \n";
	$sql .= "    t_round.round_day, \n";
	$sql .= "    t_contract.route, \n";
	$sql .= "    t_con_aod.line; \n"; 
	$result = Db_Query($db_con, $sql);
	$info   = pg_fetch_all($result);
	
	//print_array($info);
	return $info;
}

function Get_Contract_Info($db_con,$contract_id){

	//得意先の情報を抽出
	$sql  = "SELECT";
	$sql .= "   * ";
	$sql .= " FROM";
	$sql .= "   t_contract ";
	$sql .= " WHERE";
	$sql .= "   t_contract.contract_id = $contract_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$info   = pg_fetch_array($result, NULL, PGSQL_ASSOC);

	return $info;
}



//得意先の情報を取得
function Get_Client_Info($db_con,$client_id){

	//得意先の情報を抽出
	$sql  = "SELECT";
	$sql .= "   t_client.coax, ";
	$sql .= "   t_client.client_name,";
	$sql .= "   t_client.client_name2,";
	$sql .= "   t_client.client_cname,";
	$sql .= "   t_client.client_cd1,";
	$sql .= "   t_client.client_cd2,";
	$sql .= "   (t_client.client_cd1 || '-' || t_client.client_cd2) AS client_cd,";
	$sql .= "   t_client.trade_id,";
	$sql .= "   t_client.tax_franct,";
	$sql .= "   t_client.slip_out, ";
    #2009-12-24 aoyama-n
	#$sql .= "   t_client.tax_rate_n, ";
	$sql .= "   t_client.rank_cd ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$info   = pg_fetch_array($result, NULL, PGSQL_ASSOC);

	//print_array($info);
	return $info;
}

//紹介口座先の情報を取得
function Get_Intro_Info($db_con,$client_id){

	$sql  = "SELECT";
	$sql .= "   t_client.client_cname,";            //紹介口座先名
	$sql .= "   t_client_info.intro_account_id,";   //紹介口座ID
	$sql .= "   t_client_info.cclient_shop, ";      //担当支店ID
	$sql .= "   t_client.client_cd1, ";             //紹介口座先コード1
	$sql .= "   t_client.client_cd2, ";             //紹介口座先コード2
	$sql .= "   t_client.coax ";                    //丸め区分
	$sql .= " FROM";
	$sql .= "   t_client_info ";
	$sql .= "   LEFT JOIN t_client ON t_client.client_id = t_client_info.intro_account_id ";
	$sql .= " WHERE";
	$sql .= "   t_client_info.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);
	$info   = pg_fetch_array($result, NULL, PGSQL_ASSOC);

	//print_array($info);
	return $info;
}


/****************************/
//受注データ登録関数
/****************************/
 /**
 * 受注データ登録
 *
 * 変更履歴
 * 1.0.0 (2006/06/05) 新規作成(suzuki-t)
 * 1.0.1 (2006/12/04) 商品分類名・正式名称の抽出SQLを変更(suzuki-t)
 * 1.0.2 (2007/04/11) $start_day 以降の受注ヘッダは一度削除するように修正(morita-d)
 * 
 * @version     1.0.1 (2006/12/04)
 *
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-11-10      01-014      suzuki      サービスのみ伝票の仕入金額を代行入力時に営業金額(受託先)をいれるように修正
 *  2006-12-10      03-090      suzuki      商品ＣＤ抽出条件修正
 *
 * @param               string      $db_con         DBオブジェクト
 * @param               string      $shop_id        ショップID
 * @param               string      $client_id      得意先ID
 * @param               string      $start_day      契約データ作成開始日
 * @param               string      $end_day        契約データ作成終了日
 * @param               string      $trust_id       受託先ID
 * @param               string      $cron_flg       CRON実行判定
 *
 */

function Aorder_Query($db_con,$shop_id,$client_id,$start_day,$end_day,$trust_id=NULL,$cron_flg=NULL){

	/****************************/
	//外部変数取得
	/****************************/
	$staff_id    = $_SESSION["staff_id"];     //ログイン者ID
	$staff_name  = addslashes($_SESSION["staff_name"]);   //ログイン者名

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
	$sql .= "   t_client.slip_out ";
	//$sql .= "   t_client.intro_ac_price,";          
	//$sql .= "   t_client.intro_ac_rate ";           
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
	//$client_ac_price = $data_list[0][6];        //紹介口座金額
	//$client_ac_rate  = $data_list[0][7];        //紹介口座率

	//取引先情報取得
	$sql  = "SELECT";
	$sql .= "   t_client.client_cname,";            //紹介口座先名
	$sql .= "   t_client_info.intro_account_id,";   //紹介口座ID
	$sql .= "   t_client_info.cclient_shop, ";       //担当支店ID
	$sql .= "   t_client.client_cd1, ";       //紹介口座先コード1
	$sql .= "   t_client.client_cd2 ";       //紹介口座先コード2
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
	$intro_ac_cd1    = $info_list[0][3];        //紹介口座先コード1
	$intro_ac_cd2    = $info_list[0][4];        //紹介口座先コード2

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

		//$ware_name      = $act_data_list[0][0];        //商品出荷倉庫名
		//$ware_id        = $act_data_list[0][1];        //出荷倉庫ID
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

		//$ware_name      = $data_list[0][0];        //商品出荷倉庫名
		//$ware_id        = $data_list[0][1];        //出荷倉庫ID
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
	$sql .= "    t_aorder_h.client_id = $client_id ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_no IS NULL ";
	$sql .= "AND ";
	//受託先判定
	if($trust_id != NULL){
		//オンライン代行の場合は、受託先IDを見るようにする
		$sql .= "    t_aorder_h.act_id = $trust_id  \n";
		$sql .= "AND ";
		$sql .= "    t_aorder_h.contract_div = '2' ";

	//通常・
	}else{
		//通常
/*
		//直営判定
		if($_SESSION["group_kind"] == '2'){
			//直営
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
			//FC
		    $sql .= "    t_aorder_h.shop_id = $cshop_id  \n";
		}
*/
		$sql .= "    t_aorder_h.shop_id = $shop_id  \n";
		//$sql .= "AND ";
		//$sql .= "    t_aorder_h.contract_div IN('1','3') ";
	}
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_time >= '$start_day' ";

	//if($cron_flg != NULL){
		//$sql .= "AND ";
		//$sql .= "    t_aorder_h.ord_time <= '$end_day' ";
	//}
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL;";
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
			//CRON判定
			if($cron_flg == true){
				//CRON
				return false;
			}else{
				//手動
				Db_Query($db_con, "ROLLBACK");
		    	exit;
			}
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

	//$sql .= "    t_con_aod.trust_trade_price,";    //営業原価(受託) 39
	//$sql .= "    t_con_aod.trust_trade_amount, ";  //営業金額(受託) 40
	$sql .= "    t_con_aod.trust_cost_price,";    //営業原価(受託) 39
	$sql .= "    t_con_aod.trust_cost_amount, ";  //営業金額(受託) 40

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
	$sql .= "    t_contract.last_day, ";                 //最終巡回日53
	$sql .= "    t_con_aod.official_goods_name, ";                 //商品名（正式名）54
	$sql .= "    t_contract.intro_ac_div, ";                 //紹介口座料区分 55
	$sql .= "    t_contract.act_div, ";                 //代行料区分 56
	$sql .= "    t_contract.act_request_price ";      //代行依頼料 57
	//$sql .= "    t_con_aod.trust_cost_price, ";        //（委託先）原価単価54
	//$sql .= "    t_con_aod.trust_cost_amount, ";       //（委託先）原価金額54
	//$sql .= "    t_con_aod.trust_sale_price, ";        //（委託先）売上単価54
	//$sql .= "    t_con_aod.trust_sale_amount ";       //（委託先）売上金額54

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
	//$sql .= "        t_con_info.trust_trade_price,";
	//$sql .= "        t_con_info.trust_trade_amount, ";
	$sql .= "        t_con_info.official_goods_name, ";
	$sql .= "        t_con_info.trust_cost_price, ";
	$sql .= "        t_con_info.trust_cost_amount, ";
	$sql .= "        t_con_info.trust_sale_price, ";
	$sql .= "        t_con_info.trust_sale_amount ";
	$sql .= "    FROM "; 
	$sql .= "        t_con_info "; 
	$sql .= "        LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id ";
	$sql .= "        LEFT JOIN t_price ON t_con_info.goods_id = t_price.goods_id AND t_price.rank_cd = '$rank_cd'";
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
	$sql .= "    t_contract.client_id = $client_id ";
	$sql .= "AND ";
	//受託先判定
	if($trust_id != NULL){
		//オンライン代行の場合は、受託先IDを見るようにする
		$sql .= "    t_contract.trust_id = $trust_id ";
		$sql .= "AND ";
		$sql .= "    t_contract.contract_div = '2' ";
	}else{
		//通常
		$sql .= "    t_contract.shop_id = $shop_id  \n";
		$sql .= "AND ";
		$sql .= "    t_contract.contract_div IN('1','3') ";
	}
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


	//****************************
	//受注ヘッダー登録処理
	//****************************
	$update_id = NULL;    //ヘッダーの金額を更新する受注ID配列
	for($i=0;$i<count($data_list);$i++){

		$intro_ac_div   = $data_list[$i][55];
		$intro_ac_price = $data_list[$i][41];
		$intro_ac_rate  = $data_list[$i][42];
		$act_div        = $data_list[$i][56];
		$act_price      = $data_list[$i][57];
		$act_rate       = $data_list[$i][38];


		//■拠点倉庫を取得
		$staff_id1 = $data_list[$i][24];
		if($staff_id1 != NULL){
		
			//担当者1の拠点倉庫ID
			$ware_id   = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $staff_id1));

			//担当者1の拠点倉庫名
			$sql       = "SELECT ware_name FROM t_ware WHERE ware_id = $ware_id ";
			$result    = Db_Query($db_con, $sql);
			$ware_name = @pg_fetch_result($result,0,0);

		//オフライン代行の場合
		}else{
			$ware_id   = NULL;
			$ware_name = NULL;
		}


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
			$sql .= "    ord_staff_name, \n";     //オペレータ名
			$sql .= "    intro_ac_div, \n";     //紹介口座料区分
			$sql .= "    intro_ac_cd1, \n";     //紹介口座先コード1
			$sql .= "    intro_ac_cd2, \n";     //紹介口座先コード2
			$sql .= "    act_div, \n";          //代行料区分
			$sql .= "    act_request_price \n"; //代行料（固定額）

			$sql .= ")VALUES(\n";
			$sql .= "    $aord_id,\n";   
			$sql .= "    '".$data_list[$i][0]."',\n";
			$sql .= "    $client_id,\n";
			$sql .= "    '$trade_id',\n";

/*
			//代行判定
			if($trust_id != NULL || $data_list[$i][36] == '3'){
				//代行は掛売上
				$sql .= "    '11',\n";
			}else{
				//得意先の取引区分
				$sql .= "    '$trade_id',\n";
			}
*/
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
			if($act_rate != NULL){
				$sql .= "    '".$act_rate."',\n";
			}else{
				$sql .= "    NULL,\n";
			}
			//口座単価(得意先)指定判定
			if($intro_ac_price != NULL){
				$sql .= "    ".$intro_ac_price.",\n";
			}else{
				$sql .= "    NULL,\n";
			}
			$sql .= "    '".$intro_ac_rate."',\n";

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
			$sql .= "     '$staff_name', \n";
			$sql .= "     '$intro_ac_div', \n";
			$sql .= "     '$intro_ac_cd1', \n";
			$sql .= "     '$intro_ac_cd2', \n";
			$sql .= "     '$act_div', \n";
			if($act_price != NULL){
				$sql .= "     '$act_price' \n";
			}else{
				$sql .= "     NULL\n";
			}

			$sql .= "     ); \n";

			$result = Db_Query($db_con, $sql);
			if($result == false){
				//CRON判定
				if($cron_flg == true){
					//CRON
					return false;
				}else{
					//手動
					Db_Query($db_con, "ROLLBACK");
			    	exit;
				}
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

					//コースID取得関数
					//$course_data = Course_Id_Get($db_con,$data_list[$i][3],$staff_check[$c],$shop_id);

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
					    //CRON判定
						if($cron_flg == true){
							//CRON
							return false;
						}else{
							//手動
							Db_Query($db_con, "ROLLBACK");
					    	exit;
						}
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
				$sql .= "    t_goods.public_flg, ";
				$sql .= "    t_g_product.g_product_name,";
				$sql .= "    t_goods.goods_name ";
				$sql .= "FROM ";
				$sql .= "    t_goods ";
				$sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
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
			//$sql .= "    trust_trade_price,\n";    //営業原価(受託)
			//$sql .= "    trust_trade_amount, \n";  //営業金額(受託)
			$sql .= "    trust_cost_price,\n";    //営業原価(受託)
			$sql .= "    trust_cost_amount, \n";  //営業金額(受託)

			//履歴用
			$sql .= "    serv_name, \n";           //サービス名
			$sql .= "    serv_cd, \n";             //サービスCD
			$sql .= "    goods_cd, \n";            //アイテムCD
			$sql .= "    rgoods_cd, \n";           //本体CD
			$sql .= "    egoods_cd, \n";           //消耗品CD
			$sql .= "    g_product_name, \n";      //商品分類名
			$sql .= "    official_goods_name \n";  //正式名称

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
				if($buy_price !== NULL){
					$sql .= "    ".$buy_price.",\n";    
				}else{
					$sql .= "    NULL,\n";
				}
			}                                                                              
			$sql .= "    ".$data_list[$i][14].",\n";                                       
			$sql .= "    ".$data_list[$i][15].",\n";                                       
	                                                 
			//仕入金額判定
			if($buy_price !== NULL){
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
			$sql .= "    '".$egoods_data[0][0]."', \n";
			$sql .= "    '".$item_data[0][3]."', \n";
			$sql .= "    '".$data_list[$i][54]."'); \n"; 

			$result = Db_Query($db_con, $sql);
	        if($result == false){
	            //CRON判定
				if($cron_flg == true){
					//CRON
					return false;
				}else{
					//手動
					Db_Query($db_con, "ROLLBACK");
			    	exit;
				}
	        }

			/****************************/
			//内訳テーブル登録
			/****************************/
			/*
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
					    //CRON判定
						if($cron_flg == true){
							//CRON
							return false;
						}else{
							//手動
							Db_Query($db_con, "ROLLBACK");
					    	exit;
						}
					}
				}
			}
			*/
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
				    //CRON判定
					if($cron_flg == true){
						//CRON
						return false;
					}else{
						//手動
						Db_Query($db_con, "ROLLBACK");
				    	exit;
					}
				}

				//通常・オンライン代行のみ受払登録
				if($data_list[$i][36] != '3'){
					/****************************/                                                   
					//受払テーブルに登録関数                                                     
					/****************************/
					$result = Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship_list[$d][0],$ship_list[$d][2],'keiyaku',$data_list[$i][37]);
					if($result === false){
						return false;
					}
				}
			}

			//受注ヘッダーに原価金額・売上金額・消費税額を登録する受注ID取得
			$update_id[] = $aord_id; 
		}                                              
	}                                                                                


	/****************************/                                                   
	//受注ヘッダー（原価金額・売上金額・消費税額）登録処理 
	//⇒ 配列 $update_id は重複があり無駄な処理が多い                                                   
	/****************************/
	for($j=0;$j<count($update_id);$j++){
/*
		//受注ヘッダ取得
		$sql  = "SELECT ";
		$sql .= "    intro_ac_price,";     //口座単価(得意先)
		$sql .= "    intro_ac_rate ";      //口座率(得意先)
		$sql .= "FROM ";
		$sql .= "    t_aorder_h ";
		$sql .= "WHERE ";
		$sql .= "    aord_id = ".$update_id[$j].";";
		$result = Db_Query($db_con, $sql);
		$intro_data = Get_Data($result,3);
*/
		//受注データ取得
	    $sql  = "SELECT ";
		$sql .= "    tax_div,";            //課税区分0
		$sql .= "    cost_amount,";        //営業金額1
		$sql .= "    sale_amount,";        //売上金額2
		$sql .= "    '',"; //営業金額(受託先)3
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

			//****************************                                                   
			//紹介口座料算出（商品単位）                                                      
			//****************************
			if($intro_ac_div == "4"){
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

		//****************************                                                   
		//紹介口座料算出（得意先単位）                                                      
		//****************************

		//紹介口座料が売上％の場合
		if($intro_ac_div == "3"){
			$rate_money = bcmul($sale_money,bcdiv($intro_ac_rate,100,2),2);
			$rate_money = Coax_Col($intro_account_coax,$rate_money);
			$intro_amount = $rate_money; 

		//紹介口座料が固定額の場合
		}else if($intro_ac_div == "2"){
			$intro_amount = $intro_ac_price; 

		//紹介口座料なしの場合
		}else if($intro_ac_div == "1"){
			$intro_amount = NULL;
		}

		/*
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
		*/


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
			//CRON判定
			if($cron_flg == true){
				//CRON
				return false;
			}else{
				//手動
				Db_Query($db_con, "ROLLBACK");
				exit;
			}
		}	
	}
	
	//配列の要素がある場合
	if(count($update_id) > 0){
	
		$update_id = array_unique($update_id);
		foreach($update_id AS $key => $id){
			//代行料をアップデート
			Update_Act_Amount($db_con, $id,"aord");
			//echo $id."<br>";
		}
	}
	
	return true;
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
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/03/28      要望21他    kajioka-h   予定データ訂正で、対象の予定データが商品予定出荷済かどうかで引当する倉庫を変えるように変更
 */

function Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$goods_id,$goods_num,$ware_flg,$act_id=NULL){

	/****************************/
	//外部変数取得
	/****************************/
	$staff_id    = $_SESSION["staff_id"];   //ログイン者ID

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

        //商品予定出荷フラグ取得
        $sql = "SELECT move_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
		$result = Db_Query($db_con, $sql); 

        //商品予定出荷済みなら担当者倉庫に引当
        if(pg_fetch_result($result, 0, "move_flg") == "t"){

            //巡回担当者（メイン）から担当倉庫ID抽出
            $sql  = "SELECT \n";
            $sql .= "    t_attach.ware_id \n";
            $sql .= "FROM \n";
            $sql .= "    t_aorder_h \n";
            $sql .= "    INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
            $sql .= "        AND t_aorder_staff.staff_div = '0' \n";
            $sql .= "    INNER JOIN t_attach ON t_aorder_staff.staff_id = t_attach.staff_id \n";
            $sql .= "        AND t_attach.h_staff_flg = false \n";
            $sql .= "WHERE \n";
            $sql .= "    t_aorder_h.aord_id = $aord_id \n";
            $sql .= ";";
		    $result = Db_Query($db_con, $sql); 

            $ware_id = pg_fetch_result($result, 0, 0);  //担当倉庫ID

        //商品予定出荷してなければ、受注ヘッダの出荷倉庫ID抽出
        }else{

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
		        /*
    		     * 履歴：
    	    	 * 　日付　　　　B票No.　　　　担当者　　　内容　
	    	     * 　2007/02/05　要件26-1　　　kajioka-h　 他に使ってないようなので、代行伝票の場合に数量を変更できるように変更のために変えました
	        	 */
			    //代行
    			//$sql .= "   shop_id = $act_id";
	    		$sql .= "   act_id = $act_id";
		    }else{
    			//直営
	    		$sql .= "   shop_id = $cshop_id";
		    }
    		$sql .= ";";
	    	$result = Db_Query($db_con, $sql); 
		    Get_Id_Check($result);
    		$data_list = Get_Data($result);
	    	$ware_id        = $data_list[0][0];        //出荷倉庫ID
        }

	}else{
		//契約登録から登録
		
		//拠点倉庫取得
		$sql  = "SELECT";
		$sql .= "   ware_id ";
		$sql .= " FROM";
		$sql .= "   t_aorder_h ";
		$sql .= " WHERE";
		$sql .= "   aord_id = $aord_id ";
		$sql .= " AND ";
		$sql .= "   shop_id = $cshop_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql); 
		$ware_id = pg_fetch_result($result,0,0);

		/****************************/
		//ログインユーザ情報取得処理
		/****************************/
		/*
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
		*/
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
	    //CRON判定
		if($staff_id == NULL){
			//CRON
			return false;
		}else{
			//手動
			Db_Query($db_con, "ROLLBACK");
			exit;
		}
	}
	
	return true;
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


/****************************/
//値の整合性判定関数
/****************************/

 /**
 * 値の整合性判定
 *
 * 変更履歴
 * 1.0.0 (2006/10/07) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/10/07)
 *
 * @param               string      $db_con           DBオブジェクト
 * @param               string      $table            対象table
 * @param               string      $object1          対象値1
 * @param               string      $object2          対象値2
 * @param               string      $object3          対象値3
 *
 *
 * @return              boolean     true    正常
 *                                  false   不正
 *                                  
 */

function Injustice_check($db_con,$table,$object1,$object2,$object3 = NULL){
	//不正判定SQL
	switch($table){
		case "contract":
			//契約マスタ
			$sql  = "SELECT contract_id FROM t_contract WHERE contract_id = $object1 AND shop_id = $object2;";
			break;
		case "trust":
			//契約マスタ(代行)
			$sql  = "SELECT contract_id FROM t_contract WHERE contract_id = $object1 AND trust_id = $object2;";
			break;
		case "trust_client":
			//契約マスタ(代行)の得意先
			$sql  = "SELECT contract_id FROM t_contract WHERE contract_id = $object1 AND client_id = $object2;";
			break;
		case "goods":
			//商品マスタ
			$sql  = "SELECT goods_id FROM t_goods WHERE goods_id = $object1 AND goods_cd = '$object2';";
			break;
		case "client":
			//得意先マスタ
			$sql  = "SELECT client_id FROM t_client WHERE client_id = $object1 AND client_cd1 = '$object2' AND client_cd2 = '$object3';";
			break;
		case "aorder":
			//受注ヘッダ
			$sql  = "SELECT aord_id FROM t_aorder_h WHERE aord_id = $object1 AND shop_id = $object2;";
			break;
		case "a_trust":
			//受注ヘッダ(代行)
			$sql  = "SELECT aord_id FROM t_aorder_h WHERE aord_id = $object1 AND act_id = $object2;";
			break;
		case "h_goods":
			//商品マスタ(本部商品かつ状態が有効)
			$sql  = "SELECT goods_id FROM t_goods WHERE goods_id = $object1 AND goods_cd = '$object2' AND public_flg = 't' AND state = '1';";
			break;
		case "sale":
			//売上ヘッダ
			$sql  = "SELECT sale_id FROM t_sale_h WHERE sale_id = $object1 AND shop_id = $object2;";
			break;
		case "sale_cup":
			//割賦売上
			$sql  = "SELECT sale_id FROM t_sale_h WHERE sale_id = $object1 AND shop_id = $object2 AND trade_id = 15;";
			break;
	}
	$result = Db_Query($db_con, $sql);
	$count = pg_num_rows($result);

	//レコードが無ければ不正
	if($count == 0){
		//画面判定
		if($table == "client" || $table == "goods" || $table == "h_goods"){
			//得意先・商品
			return false;
		}else{
			//契約・代行・受注・受注(代行)・売上
			Header("Location: ../top.php"); 
		}
	}

	return true;
}

/**
 * 概要 契約マスタ登録画面で指定行をクリアする
 *
 * 説明
 *
 * @param object    $form    HTML_QuickFormオブジェクト
 * @param array     $line    クリア行
 *
 */

function Clear_Line_Data($form,$line){

	//入力クリアするフォーム名
		for($f=1;$f<=3;$f++){
			$data["form_print_flg".$f][$line]      = "";
			$data["hdn_goods_id".$f][$line]        = "";
			$data["hdn_name_change".$f][$line]     = "";
			$data["form_goods_cd".$f][$line]       = "";
			$data["form_goods_name".$f][$line]     = "";
			$data["form_goods_num".$f][$line]      = "";
		}
		$data["form_serv"][$line]             = "";
		$data["form_divide"][$line]           = "";
		$data["form_issiki"][$line]           = "";
		$data["form_trade_price"][$line]["1"] = "";
		$data["form_trade_price"][$line]["2"] = "";
		$data["form_trade_amount"][$line]     = "";
		$data["form_sale_price"][$line]["1"]  = "";
		$data["form_sale_price"][$line]["2"]  = "";
		$data["form_sale_amount"][$line]      = "";
		$data["form_account_price"][$line]    = "";
		$data["form_account_rate"][$line]     = "";
		$data["form_aprice_div"][$line]       = "1";
		$data["official_goods_name"][$line]   = "";
		$data["mst_sync_flg"][$line]          = "";
		$data["form_ad_offset_radio"][$line]  = "1";
		$data["form_ad_offset_amount"][$line] = "";

        //aoyama-n 2009-09-24
		$data["hdn_discount_flg"][$line] = "";

		/*
		for($j=1;$j<=5;$j++){
			$data["break_goods_cd"][$line][$j] = "";
			$data["break_goods_name"][$line][$j] = "";
			$data["break_goods_num"][$line][$j] = "";
			$data["hdn_bgoods_id"][$line][$j] = "";
			$data["hdn_bname_change"][$line][$j] = "";
			$data["break_trade_price"][$line][$j][1] = "";
			$data["break_trade_price"][$line][$j][2] = "";
			$data["break_trade_amount"][$line][$j] = "";
			$data["break_sale_price"][$line][$j][1] = "";
			$data["break_sale_price"][$line][$j][2] = "";
			$data["break_sale_amount"][$line][$j] = "";
		}
		*/
	$data["clear_line"] = "";    //クリア行

	$form->setConstants($data);
	
}




/**
 * 概要 自社契約または代行契約の件数を返します。
 *
 * 説明 
 *
 * @return string          契約件数
 */
function Kiyaku_Data_Count($db_con,$div){

	$shop_id   = $_SESSION["client_id"];  //ショップID
	
	$sql  = " SELECT ";
	$sql .= "     DISTINCT(t_client.client_id) ";
	$sql .= " FROM";
	$sql .= "     t_client ";
	$sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
	$sql .= " WHERE";

	//自社の契約件数
	if ($div == "1") {

		if($_SESSION["group_kind"] == '2'){
			$sql .= "    t_client.shop_id IN (".Rank_Sql().")";
		}else{
			$sql .= "    t_client.shop_id = $shop_id";
		}

		$sql .= "     AND";
		$sql .= "     t_client.client_div = '1'";

	//代行契約件数
	}elseif ($div == "2") {
		$sql .= "     t_contract.trust_id = $shop_id";
		$sql .= "     AND";
		$sql .= "     t_client.client_div = '1'";
		$sql .= "     AND";
		$sql .= "     t_contract.contract_div = '2'";
	}

	//ヘッダーに表示させる全件数
	$count_res = Db_Query($db_con, $sql.";");
	$total_count = pg_num_rows($count_res);

	return $total_count;
}

/**
 * 概要　契約を削除する
 *
 * 説明 
 *
 * @param object    $db_con  DBコネクション
 * @param integer   $bill_id 請求ヘッダID
 *
 */
function Delete_Contract($db_con, $get_con_id){

	//削除する受注ID取得
	$sql  = "SELECT DISTINCT ";
	$sql .= "    t_aorder_h.aord_id ";
	$sql .= "FROM ";
	$sql .= "    t_aorder_d ";
	$sql .= "    INNER JOIN t_aorder_h ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.ord_no IS NULL ";
	$sql .= "AND "; 
	$sql .= "    t_aorder_d.contract_id = $get_con_id;";
	$result = Db_Query($db_con, $sql);       
	$delete_id = Get_Data($result);
                                                                                      
	Db_Query($db_con, "BEGIN");                                                          

	$count = count($delete_id);
	for($x=0;$x<$count;$x++){
		$sql  = "DELETE FROM t_aorder_h WHERE aord_id = ".$delete_id[$x][0].";";                   
		$result = Db_Query($db_con, $sql);                                                   
		if($result === false){                                                               
			Db_Query($db_con, "ROLLBACK");                                                   
			exit;
		}
	}
                                                                                     
	$sql  = "DELETE FROM t_contract WHERE contract_id = $get_con_id;";                   
	$result = Db_Query($db_con, $sql);                                                   
		if($result === false){                                                               
			Db_Query($db_con, "ROLLBACK");                                                   
			exit;
		}

}


/**
 * 概要　契約の巡回日を登録します。
 *
 * 説明　
 *
 */
function Regist_ConRound($db_con,$contract_id,$date_array,$end_day=NULL){

	//echo "end_day:".$end_day."<hr>";

	$count = count($date_array);
	for($s=0;$s<$count;$s++){

		//「終了日以前の日付」または「終了日なし」の場合は巡回日登録
		if ( ($date_array[$s] <= $end_day) || $end_day===NULL){
			//echo $date_array[$s]." OK<br>";

			//登録
			$sql  = "INSERT INTO t_round( ";
			$sql .= "    contract_id,";
			$sql .= "    round_day ";
			$sql .= "    )VALUES(";
			$sql .= "    $contract_id,";
			$sql .= "    '".$date_array[$s]."' ";
			$sql .= "    );";
	
			$result = Db_Query($db_con, $sql);
			if($result === false){
				Db_Query($db_con, "ROLLBACK");
				exit;
			}

			$last_day = $date_array[$s];

		}else{
			//echo $date_array[$s]." NG<br>";
		}

	}

	return $last_day;

}

/**
 * 概要　契約の巡回日を削除します。
 *
 * 説明　
 *
 */
function Delete_ConRound($db_con,$contract_id){

	$sql  = "DELETE FROM t_round WHERE contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

}


/**
 * 概要　契約の巡回担当者を登録します。
 *
 * 説明　
 *
 */
function Regist_ConStaff_old($db_con,$contract_id,$no,$staff_check,$staff_rate){

	if($staff_rate == NULL){
		$staff_rate = "NULL";
	}

	$sql  = "INSERT INTO t_con_staff( ";
	$sql .= "    contract_id,";
	$sql .= "    staff_div,";
	$sql .= "    staff_id,";
	$sql .= "    sale_rate ";
	$sql .= "    )VALUES(";
	$sql .= "    $contract_id,";                      //契約情報ID
	$sql .= "    '$no',";                              //巡回担当者識別
	$sql .= "    ".$staff_check.",";              //巡回担当者ID
	$sql .= "    ".$staff_rate." ";          //売上率
	$sql .= ");";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}
}
function Regist_ConStaff($db_con,$contract_id,$staff_check,$staff_rate){

	for($i=0;$i<=3;$i++){
		//スタッフが指定されているか判定
		if($staff_rate[$i] == NULL){
			$staff_rate[$i] = "NULL";
		}

		if($staff_check[$i] != NULL){

			$sql  = "INSERT INTO t_con_staff( ";
			$sql .= "    contract_id,";
			$sql .= "    staff_div,";
			$sql .= "    staff_id,";
			$sql .= "    sale_rate ";
			$sql .= "    )VALUES(";
			$sql .= "    $contract_id,";                      //契約情報ID
			$sql .= "    '$i',";                              //巡回担当者識別
			$sql .= "    ".$staff_check[$i].",";              //巡回担当者ID
			$sql .= "    ".$staff_rate[$i]." ";          //売上率
			$sql .= ");";
			$result = Db_Query($db_con, $sql);

		}
	}




	if($result === false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}
}
/**
 * 概要　契約の巡回担当者を削除します。
 *
 * 説明　
 *
 */
function Delete_ConStaff($db_con,$contract_id){

	$sql  = "DELETE FROM t_con_staff WHERE contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}

}


/**
 * 概要　契約の巡回商品を削除します。
 *
 * 説明　
 *
 */
function Delete_ConInfo($db_con,$contract_id){

	$sql  = "DELETE FROM t_con_info WHERE contract_id = $contract_id;";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

/**
 * 概要　契約の出庫品を登録します。
 *
 * 説明　
 *
 */
function Regist_ConShip($db_con,$con_info_id,$goods_id,$goods_name,$goods_num){

	$sql  = "INSERT INTO t_con_ship( ";
	$sql .= "    con_info_id,";
	$sql .= "    goods_id,";
	$sql .= "    goods_name,";
	$sql .= "    num ";
	$sql .= "    )VALUES(";
	$sql .= "    $con_info_id,";                   //契約内容ID
	$sql .= "    $goods_id,";                          //商品ID
	$sql .= "    '$goods_name',"; //商品名
	$sql .= "    $goods_num";       //数量
	$sql .= "    );";		
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

}


/**
 * 概要　契約の内訳・出庫品を登録します。
 *
 * 説明　
 *
 * @param object    $db_con       DBコネクション
 * @param int       $contract_id  契約ID
 * @param array     $value        アイテム、消耗品、構成品名の情報
 */
function Regist_ConShipDetail($db_con,$contract_id,$value){

	$divide             = $value[0];  //販売区分
	$goods_item_com     = $value[1];  //構成品フラグ（アイテム）
	$goods_item_id      = $value[2];  //アイテムID
	$goods_item_name    = $value[3];  //アイテム名
	$goods_item_num     = $value[4];  //アイテム数
	$goods_expend_com   = $value[5];  //構成品フラグ（消耗品）
	$goods_expend_id    = $value[6];  //消耗品ID
	$goods_expend_name  = $value[7];  //消耗品名
	$goods_expend_num   = $value[8];  //消耗品数
	$item_parts         = $value[9];  //構成品ID（アイテム）
	$item_parts_cname   = $value[10]; //構成品名（アイテム）
	$item_parts_num     = $value[11]; //構成数（アイテム）
	$expend_parts       = $value[12]; //構成品ID（消耗品）
	$expend_parts_cname = $value[13]; //構成品名（消耗品）
	$expend_parts_num   = $value[14]; //構成数（消耗品）

	for($s=1;$s<=5;$s++){
		$goods_ship_id = NULL;      //出庫品登録配列

		//契約内容ID取得SQL
		$sql  = "SELECT ";
		$sql .= "    con_info_id ";
		$sql .= "FROM ";
		$sql .= "    t_con_info ";
		$sql .= "WHERE ";
		$sql .= "    contract_id = $contract_id ";
		$sql .= "AND ";
		$sql .= "    line = $s;";
		$result = Db_Query($db_con, $sql);
		$row_num = pg_num_rows($result);

		//契約内容ID存在判定
		if($row_num == 1){
			$con_info_id = pg_fetch_result($result,0,0);    //契約内容ID

			$divide_flg = false;                            //出庫品テーブル登録判定フラグ
			//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
			if($divide[$s] == '03' || $divide[$s] == '04'){
				$divide_flg = true;
			}

			/****************************/
			//内訳テーブル登録
			/****************************/
			/*
			for($d=1;$d<=5;$d++){
				//内訳商品IDが指定されているか判定
				if($break_goods_id[$s][$d] != NULL){
					$sql  = "INSERT INTO t_con_detail( ";
					$sql .= "    con_info_id,";
					$sql .= "    line,";
					$sql .= "    goods_id,";
					$sql .= "    goods_name,";
					$sql .= "    num,";
					$sql .= "    trade_price,";
					$sql .= "    trade_amount,";
					$sql .= "    sale_price,";
					$sql .= "    sale_amount ";
					$sql .= "    )VALUES(";
					$sql .= "    $con_info_id,";                    //契約内容ID
					$sql .= "    $d,";
					$sql .= "    ".$break_goods_id[$s][$d].",";     //商品ID
					$sql .= "    '".$break_goods_name[$s][$d]."',"; //商品名
					$sql .= "    ".$break_goods_num[$s][$d].",";    //数量
					$sql .= "    ".$break_trade_price[$s][$d].",";  //営業原価
					$sql .= "    ".$break_trade_amount[$s][$d].","; //営業金額
					$sql .= "    ".$break_sale_price[$s][$d].",";   //売上単価
					$sql .= "    ".$break_sale_amount[$s][$d];      //売上金額
					$sql .= ");";
					$result = Db_Query($db_con, $sql);
					if($result === false){
					    Db_Query($db_con, "ROLLBACK");
					    exit;
					}

					//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
					if($divide_flg == false){
						//構成品判定
						if($break_goods_com[$s][$d] == 't'){
							//構成品の場合、その子の商品を出庫品登録配列に追加
							for($p=0;$p<count($break_parts[$s][$d]);$p++){
								//同じ商品か判定。
								if($goods_ship_id[$break_parts[$s][$d][$p][0]] == NULL){
									//新規の商品

									//出庫品登録配列
									//配列[商品ID][0] = 略称
									//配列[商品ID][1] = 数量
									$goods_ship_id[$break_parts[$s][$d][$p][0]][0] = $break_parts_name[$s][$d][$p];
									$goods_ship_id[$break_parts[$s][$d][$p][0]][1] = $break_parts_num[$s][$d][$p];
								}else{
									//同じ商品の場合は数量を足す

									//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
										$goods_ship_id[$break_parts[$s][$d][$p][0]][1] = $goods_ship_id[$break_parts[$s][$d][$p][0]][1] + $break_parts_num[$s][$d][$p];
								}
							}
						}else{
							//通常商品

							//同じ商品か判定。
							if($goods_ship_id[$break_goods_id[$s][$d]] == NULL){
								//新規の商品

								//出庫品登録配列
								//配列[商品ID][0] = 略称
								//配列[商品ID][1] = 数量
								$goods_ship_id[$break_goods_id[$s][$d]][0] = $break_goods_name[$s][$d];
								$goods_ship_id[$break_goods_id[$s][$d]][1] = $break_goods_num[$s][$d];
							}else{
								//同じ商品の場合は数量を足す

								//出庫品登録配列(配列[商品ID] = 現在の数量 + 数量)
								$goods_ship_id[$break_goods_id[$s][$d]][1] = $goods_ship_id[$break_goods_id[$s][$d]][1] + $break_goods_num[$s][$d];
							}
						}
					}
				}	
			}
			*/

			/****************************/
			//出庫品テーブル登録
			/****************************/

			//販売区分が、リースorレンタルの場合、出庫品テーブルには登録しない
			if($divide_flg == false){

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

						Regist_ConShip($db_con,$con_info_id,$ship,$goods_ship_id[$ship][0],$goods_ship_id[$ship][1]);

					}
				}
			}
		}
	}

}



/**
 * 概要　契約に関連した受注を削除します。
 *
 * 説明　
 *
 * @param object    $db_con    DBコネクション
 * @param integer   $client_id 得意先ID
 * @param string    $start_day 対象期間（開始日）
 * @param string    $end_day   対象期間（終了日）
 * @param integer   $trust_id  受託先ID
 *
 */
function Delete_Aorder($db_con,$client_id,$start_day,$end_day,$contract_id){

	//契約から起こした受注ID取得
	$sub_sql  = "SELECT ";
	$sub_sql .= "    t_aorder_h.aord_id ";
	$sub_sql .= "FROM ";
	$sub_sql .= "    t_aorder_h ";
	$sub_sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
	$sub_sql .= "WHERE ";
	$sub_sql .= "    t_aorder_h.client_id = $client_id ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_h.ord_no IS NULL ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_d.contract_id = $contract_id ";
	//$sub_sql .= "    t_aorder_h.act_id = $trust_id ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_h.ord_time >= '$start_day' ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_h.ord_time <= '$end_day' ";
	$sub_sql .= "AND ";
	$sub_sql .= "    t_aorder_d.contract_id IS NOT NULL";
	


	//対象の受注ヘッダを削除
	$sql  = "DELETE FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id IN ($sub_sql);";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}


	/*
	//契約から起こした受注ID取得
	$sql  = "SELECT ";
	$sql .= "    t_aorder_h.aord_id ";
	$sql .= "FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
	$sql .= "WHERE ";
	$sql .= "    t_aorder_h.client_id = $client_id ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_no IS NULL ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.act_id = $trust_id ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_time >= '$start_day' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_h.ord_time <= '$end_day' ";
	$sql .= "AND ";
	$sql .= "    t_aorder_d.contract_id IS NOT NULL;";
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
		    Db_Query($db_con, "ROLLBACK");
		    exit;
		}
	}
	*/

}



function Round_Check($db_con,$yy,$mm,$dd,$round_div,$abcd_week_id,$cale_week,$week_rday,$rday){

	$mesg = NULL;

	//巡回基準日
	$sql       = "SELECT stand_day FROM t_stand;";
	$result    = Db_Query($db_con, $sql);
	$stand_day = pg_fetch_result($result,0,0);
	$day_by    = substr($stand_day,0,4);
	$day_bm    = substr($stand_day,5,2);
	$day_bd    = substr($stand_day,8,2);
	
	//修正発効日（$yy-$mm-$dd）が何週の何日か取得処理
	$base_date    = Basic_date($day_by, $day_bm, $day_bd, $yy, $mm, $dd);
	$base_abcd_id = $base_date[0]; // A〜D
	$base_day_id  = $base_date[1]; //（1:日〜7:土）

	$week[1] = "日";
	$week[2] = "月";
	$week[3] = "火";
	$week[4] = "水";
	$week[5] = "木";
	$week[6] = "金";
	$week[7] = "土";
	#$base_week = $week[$base_day_id];//修正発効日（$yy-$mm-$dd）の曜日
    #2009-09-11 hashimoto-y
	$base_week = $week[($week_rday + 1)];//修正発効日（$yy-$mm-$dd）の曜日

	$abcd[1]  = "A";
	$abcd[2]  = "B";
	$abcd[3]  = "C";
	$abcd[4]  = "D";
	$abcd[5]  = "AC";
	$abcd[6]  = "BD";
	$abcd[21] = "A";
	$abcd[22] = "B";
	$abcd[23] = "C";
	$abcd[24] = "D";
	$abcd_week     = $abcd[$abcd_week_id];//巡回サイクル（$yy-$mm-$dd）のABCD週
	$base_abcd     = $abcd[$base_abcd_id];//修正発効日（$yy-$mm-$dd）のABCD週
	
  $base_week_id  = date("N", mktime(0, 0, 0, $mm, $dd, $yy)); //修正発効日（$yy-$mm-$dd）の曜日（1:月〜7:日）
  $base_date_num = date("t", mktime(0, 0, 0, $mm, $dd, $yy)); //修正発効日（$yy-$mm-$dd）の月の日数

	//巡回サイクルが1の場合は「ABCD週」と「曜日」をチェック
	if ($round_div=="1") {
		
		/*
		//ABCD週が一致しない場合
		if ( strpos($abcd_week, $base_abcd) === false ){
			$mesg = "「$yy-$mm-$dd"."」は$base_abcd"."週 $base_week"."曜日 です。";

		//曜日が一致しない場合
		}elseif ($base_week_id != $week_rday){
			$mesg = "「$yy-$mm-$dd"."」は$base_abcd"."週 $base_week"."曜日 です。";
		}
		*/

	//巡回サイクルが2か5の場合は「日付」をチェック
	//} elseif ($round_div=="2" || $round_div=="5") {
	} elseif ($round_div=="5") {

		//月末の場合
		if ($rday == "30") {
			//月末の日付が一致しない場合
			if ($base_date_num != $dd) {
				//$mesg = "「$yy-$mm-$dd"."」は月末ではありません。";
				$mesg = "巡回と同じ「月末」を入力して下さい。";
			}
		
		//月末でない場合は「日付」をチェック
		} elseif ($dd != $rday) {
			$mesg = "巡回と同じ「".$rday."日」を入力して下さい。";
		}

	//巡回サイクルが6の場合は「曜日」と「第何週」をチェック
	//} elseif ($round_div=="3" || $round_div=="6") {
	} elseif ($round_div=="6") {


		//「曜日」をチェックし、正しければ「第何週」かをチェック
		if ($base_week_id == $week_rday){
		
			$base_week_num = (int)($dd/7); //商（第何週）
			$residue = (int)($dd%7);  //余り
			
			//余りがある場合は翌週を+1する
			if ($residue != "0") {
			  $base_week_num ++;
			}

			if ($cale_week != $base_week_num) {
				//$mesg = "「$yy-$mm-$dd"."」は第$base_week_num $base_week"."曜日です。";
				$mesg = "巡回と同じ「第".$cale_week.$base_week."曜日」を入力して下さい。（$yy-$mm-$dd"."は 第".$base_week_num.$base_week."曜日）";
			}

		}else{
            #2009-09-11 hashimoto-y
			//$mesg = "「$yy-$mm-$dd"."」は $base_week"."曜日です。";
			#$mesg = "巡回と同じ「第".$cale_week.$base_week."曜日」を入力して下さい。";
			$mesg = "巡回と同じ「第".$cale_week.$base_week."曜日」を入力して下さい。";
			
		}

	//巡回サイクルが4か7の場合はチェックなし
	} elseif ($round_div=="4" || $round_div=="7") {

	}

	return $mesg;

}


/**
 * 概要　契約マスタの行NO.の初期値を取得します。
 *
 * 説明　
 *
 * @param object    $db_con    DBコネクション
 * @param integer   $client_id 得意先ID
 *
 * @return integer           行No.の初期値
 *
 */
function Get_Init_Con_Line($db_con,$client_id){

	//契約の行No.からMAX+1をフォームにセット
	$sql  = "SELECT ";
	$sql .= "    COALESCE(MAX(line), 0)+1 ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $client_id;";
	$result    = Db_Query($db_con, $sql);
	$line      = pg_fetch_result($result,0,0);

	//行NOが1000か判定
	if($line == 1000){
		//1000なら999セット
		$line = 999;
	}

	return $line;

}

/**
 * 概要　契約マスタの行NO.の初期値を取得します。
 *
 * 説明　
 *
 * @param object    $db_con    DBコネクション
 * @param integer   $client_id 得意先ID
 *
 * @return integer           行No.の初期値
 *
 */
function Get_Init_Contract_Day($db_con,$client_id){

	//契約日
	//契約日に得意先の契約開始日をセット
	$sql = "
		SELECT 
		LPAD(DATE_PART('year' ,cont_sday ),4,0) AS y,
		LPAD(DATE_PART('month',cont_sday ),2,0) AS m,
		LPAD(DATE_PART('day'  ,cont_sday ),2,0) AS d
		FROM t_client 
		WHERE client_id = $client_id; 
	";
	$result = Db_Query($db_con, $sql);
	$data = pg_fetch_array($result,0);

	return $data;
}

/**
 * 概要　契約マスタの行NO.の初期値を取得します。
 *
 * 説明　
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $contract_id 契約ID
 *
 * @return integer               巡回最終日
 *
 */
function Get_Max_ConRound($db_con,$contract_id){

	//契約日
	//契約日に得意先の契約開始日をセット
	$sql = "
		SELECT 
		MAX(round_day) 
		FROM t_round 
		WHERE contract_id = $contract_id; 
	";
	$result   = Db_Query($db_con, $sql);
	$last_day = pg_fetch_result($result,0,0);

	return $last_day;
}


//「契約状態」「契約発効日」「修正有効日」「契約終了日」 を考慮した伝票の作成期間を取得
function Cal_Span($db_con,$client_h_id,$state,$init_type,$stand_day,$update_day,$contract_eday){

	//カレンダーの表示期間を取得
	$cal_array = Cal_range($db_con,$client_h_id);
	$start_day   = $cal_array[0];    //カレンダー開始日（伝票作成開始日）（本日の日付）
	$cal_end_day = $cal_array[1];    //カレンダー終了日
	$cal_peri    = $cal_array[2];    //カレンダー表示期間
	$end_day     = $cal_array[1];    //伝票作成終了日

	//■予定データ作成開始日の決定
	//「新規」か「複写」の場合は「契約発効日」を考慮する
	if($init_type == "新規" || $init_type == "複写"){

		//基準日がカレンダー開始日より後の場合、基準日から伝票を作成する
		if ( ($start_day < $stand_day) && ($stand_day != NULL) ){
			$start_day = $stand_day;
		}

    //変更の場合
	}else{
		$stand_day = $update_day;  //「修正発効日」を基準とする

		//修正発効日がカレンダー開始日より後の場合、修正発効日から伝票を発行する。
		if ( ($start_day < $update_day) && ($update_day != NULL) ){
			$start_day = $update_day;
		}

	}

	//「契約終了日がカレンダー終了日より前」　かつ　「NULLでない」　の場合は、契約終了日をカレンダー終了日とする。
	if ( ($contract_eday < $end_day) && ($contract_eday != NULL) ){
		$end_day = $contract_eday;
	}

	//状態が「解約・取引中」の場合
	if ( $state == "2" ){
		$end_day = date("Y-m-d",mktime(0,0,0,date(m),date(d)-1,date(Y))); //前日を終了日とする
	}

	$date[0] = $stand_day;
	$date[1] = $start_day;
	$date[2] = $end_day;
	$date[3] = $cal_peri;
	$date[4] = $cal_end_day;

	return $date;

}

/**
 * 概要  カレンダー表示期間内の巡回日を計算します。
 *
 * 説明  ・変則日の契約は巡回日を計算する必要はありません。
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $contract_id 契約ID
 * @param string    $s_day       巡回開始日
 * @param string    $e_day       巡回終了日
 * @param string    $eternity_flg   カレンダー表示期間を元にした終了日を無視して$e_dayで指定した日までの巡回日を作成するフラグ
 *
 * @return array           巡回日
 *
 */
function Get_Round_Day($db_con,$contract_id,$s_day=NULL,$e_day=NULL, $eternity_flg = null){

	//契約情報取得
	$sql  = "SELECT ";
	$sql .= "    shop_id, ";
	$sql .= "    state,";
	$sql .= "    round_div,";
	$sql .= "    cycle,";
	$sql .= "    cale_week,";
	$sql .= "    abcd_week,";
	$sql .= "    rday,";
	$sql .= "    week_rday,";
	$sql .= "    stand_day, ";
	$sql .= "    update_day, ";
	$sql .= "    contract_eday ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "     contract_id = $contract_id ";
	$result     = Db_Query($db_con, $sql); 
	$con_data   = pg_fetch_array($result);
	
	$shop_id       = $con_data[shop_id];       //ショップID
	$state         = $con_data[state];         //契約状態
	$round_div     = $con_data[round_div];     //巡回区分
	$cycle         = $con_data[cycle];         //周期
	$cale_week     = $con_data[cale_week];     //週名（１〜４）
	$abcd_week     = $con_data[abcd_week];     //週名（ＡＢＣＤ）
	$rday          = $con_data[rday];          //指定日
	$week_rday     = $con_data[week_rday];     //指定曜日
	$stand_day     = $con_data[stand_day];     //作業基準日
	$update_day    = $con_data[update_day];    //修正有効日
	$contract_eday = $con_data[contract_eday]; //契約終了日

	if($update_day == NULL ){
		$init_type = "新規";
	}else{
		$init_type = "";
	}

	//カレンダー表示期間を元に「契約状態」「契約発効日」「修正有効日」「契約終了日」 を考慮した伝票の作成期間を算出
	$cal_date = Cal_Span($db_con,$shop_id,$state,$init_type,$stand_day,$update_day,$contract_eday);
	$stand_day   = $cal_date[0];    //契約発効日（基準日）
	$start_day   = $cal_date[1];    //伝票作成開始日
	$end_day     = $cal_date[2];    //伝票作成終了日

	//開始日が指摘された場合、開始日を変更
	if(($s_day != NULL) && $start_day < $s_day){
		$start_day = $s_day;
	}

    // カレンダー表示期間を元にした終了日を無視して$e_dayで指定した日までの巡回日を作成するフラグがtrueの場合
    if ($eternity_flg === true){

        $end_day = ($e_day != null) ? $e_day : $end_day;

    }else{

    	//終了日が指摘された場合、終了日を変更
	    if(($e_day != NULL) && $e_day < $end_day){
		    $end_day   = $e_day;
	    }

    }

	//$start_day〜$end_dayまでの巡回日を算出
	$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day);

	//print_array($date_array);
	return $date_array;

}


/**
 * 概要  代行伝票の代行先情報を取得します。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 * @param string    $type        「contract」または「aord」
 *
 * @return array                 代行先情報
 *
 */
function Get_Act_Info($db_con, $data_id, $type){
	//契約を基に代行情報を取得する
	if($type == "contract"){
		$sql = "
			SELECT client_id,trust_id AS act_id,act_div,act_request_rate,act_request_price, contract_div,shop_id
			FROM t_contract
			WHERE contract_id = $data_id
		";	
	
	//予定を基に代行情報を取得する
	}elseif($type == "aord"){
		$sql = "
			SELECT client_id,act_id,act_div,act_request_rate,act_request_price, contract_div,shop_id
			FROM t_aorder_h
			WHERE aord_id = $data_id
		";
	}
	$result   = Db_Query($db_con, $sql);
	$act_data = pg_fetch_array($result,0,PGSQL_ASSOC);

	//代行料（％）以外は代行料を0％とする
	if($act_data[act_div] != "3"){
		$act_data[act_request_rate] = 0;
	}	

	//代行でない場合（代行IDがNULL）
	if($act_data[act_id] == NULL){
		$act_data = false;
	}else{	
		//■代行先の端数・丸めを取得
		$act_tax                  = Get_Tax_div($db_con,$act_data[act_id]);
		$act_data[act_coax]       = $act_tax[0]; //丸め
		$act_data[act_tax_franct] = $act_tax[1]; //端数処理
        #2009-12-24 aoyama-n
		#$act_data[act_tax_num]    = Get_Tax_Rate($db_con,$act_data[act_id]);   //代行先の消費税率を取得
		$act_data[act_tax_num]    = NULL;   //代行先の消費税率を取得


		//■委託先の端数・丸めを取得
		$tax                      = Get_Tax_div($db_con,$act_data[shop_id]);
		$act_data[coax]           = $tax[0]; //丸め
		$act_data[tax_franct]     = $tax[1]; //端数処理
        #2009-12-24 aoyama-n
		#$act_data[tax_num]        = Get_Tax_Rate($db_con,$act_data[shop_id]);   //委託先の消費税率を取得
		$act_data[tax_num]        = NULL;   //委託先の消費税率を取得


		//東陽のclient_idを取得（各ショップの得意先マスタに自動で登録される）
		$sql                     = "SELECT client_id FROM t_client WHERE shop_id = ".$act_data[act_id]." AND act_flg = true;";
		$result                  = Db_Query($db_con, $sql);	
		$act_data[act_client_id] = pg_fetch_result($result, 0, 0); //代行先からみた委託先（東陽）

		//■得意先東陽の丸め
		$tax                       = Get_Tax_div($db_con,$act_data[act_client_id]);
		$act_data[toyo_coax]       = $tax[0]; //丸め
		$act_data[toyo_tax_franct] = $tax[1]; //端数処理


	}

	//echo "act_id :".$act_data[act_id]."<hr>";
	//echo "shop_id:".$act_data[shop_id]."<hr>";
	
	return $act_data;
}


/**
 * 概要　伝票の金額をアップデートします
 *
 * 説明　
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 * @param string    $type        「contract」または「aord」
 *
 * @return void
 *
 */
function Update_Act_Amount($db_con, $data_id, $type){

	//仕入単価を登録
	if($type == "aord"){
		Update_Buy_Price($db_con, $data_id);     //仕入単価
		Update_Buy_Price_Act($db_con, $data_id); //（受託先用）仕入単価
	}

	//仕入金額、営業金額、売上金額を登録
	$amount     = Update_Amount($db_con, $data_id, $type);     
	$amount_act = Update_Amount_Act($db_con, $data_id, $type); //（受託先用）

	$return[amount]    = $amount;
	$return[amount_act]= $amount_act;
	return $return;

}


/**
 * 概要　伝票の「仕入金額」「営業金額」「売上金額」をアップデートします。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 * @param string    $type        「contract」または「aord」
 *
 * @return void
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/08/20                  kajioka-h   代行伝票の仕入単価、営業原価が受託先の丸め、端数区分を使っていないバグ修正
 *  2009/12/24                  aoyama-n    税率をTaxRateクラスから取得
 *
 */
function Update_Amount($db_con, $data_id, $type){

	//契約を基に商品情報を取得
	if($type == "contract"){

		//単価・数量を取得
		$sql = "
			SELECT 
				t_contract.shop_id,
				t_contract.client_id,
				t_con_info.con_info_id AS id,
				t_con_info.goods_id,
				t_con_info.set_flg,
				0                      AS b_price,
				t_con_info.trade_price AS c_price,
				t_con_info.sale_price  AS s_price,
				COALESCE(t_con_info.num, 1) AS num,
				CASE
					WHEN t_con_info.goods_id IS NULL THEN t_serv.tax_div
					ELSE t_goods.tax_div
				END AS tax_div
			FROM t_con_info
			INNER JOIN t_contract ON t_con_info.contract_id = t_contract.contract_id
			LEFT JOIN t_serv  ON t_con_info.serv_id  = t_serv.serv_id
			LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id
			WHERE t_con_info.contract_id = $data_id
		";

	//受注を基に商品情報を取得
	}elseif($type == "aord"){

		//単価・数量を取得
		$sql = "
			SELECT 
				t_aorder_h.shop_id,
				t_aorder_h.client_id,
				t_aorder_d.aord_d_id AS id,
				t_aorder_d.goods_id,
				t_aorder_d.set_flg,
				t_aorder_d.buy_price  AS b_price,
				t_aorder_d.cost_price AS c_price,
				t_aorder_d.sale_price AS s_price,
				COALESCE(t_aorder_d.num, 1) AS num,
				CASE
					WHEN t_aorder_d.goods_id IS NULL THEN t_serv.tax_div
					ELSE t_goods.tax_div
				END AS tax_div,
				t_aorder_d.advance_flg,
				t_aorder_d.advance_offset_amount
			FROM t_aorder_d
			INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id
			LEFT JOIN t_serv  ON t_aorder_d.serv_id  = t_serv.serv_id
			LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id
			WHERE t_aorder_d.aord_id = $data_id
		";
	}
	
	$result = Db_Query($db_con, $sql);
	$data   = pg_fetch_all($result);
	
	//****************************/
	//データ金額アップデート
	//****************************/
	foreach( $data as $key => $val){

		if($key == "0"){
			$shop_id   = $val["shop_id"];
			$client_id = $val["client_id"];

			//得意先の「丸め」「端数」を取得
			$tax        = Get_Tax_div($db_con,$client_id);
			$coax       = $tax[0]; //丸め
			$tax_franct = $tax[1]; //端数処理
            #2009-12-24 aoyama-n
			#$tax_num    = Get_Tax_Rate($db_con,$shop_id);   //自社の消費税率を取得

		}

		//代行情報取得
		$act_data   = Get_Act_Info($db_con, $data_id, $type);  //代行料の情報を取得

		//代行でない場合、営業原価、仕入単価は得意先の丸め区分、端数区分で処理
		if($act_data === false){
			$c_coax = $coax;
            $c_tax_franct = $tax_franct;

            $act_id = $client_id;           //act_idという名の得意先ID（下でヘッダの金額計算に使う）

		//代行の場合、営業原価、仕入単価は代行先の丸め区分、端数区分で処理
		}else{
			$c_coax = $act_data["act_coax"];
            $c_tax_franct = $act_data["act_tax_franct"];

            $act_id = $act_data["act_id"];  //代行先ID

		}
		
		//仕入金額
		$b_amount = bcmul($val["b_price"], $val["num"], 2); //単価×数量（丸め前）
		$b_amount = Coax_Col($c_coax, $b_amount);        //単価×数量（丸め済）

		//営業金額
		$c_amount = bcmul($val["c_price"], $val["num"], 2); //単価×数量（丸め前）
		$c_amount = Coax_Col($c_coax, $c_amount);      //単価×数量（丸め済）

		//売上金額
		if($val["set_flg"] == "t"){
			$val["num"] = 1;
		}
		$s_amount = bcmul($val["s_price"], $val["num"], 2); //単価×数量（丸め前）
		$s_amount = Coax_Col($coax, $s_amount);        //単価×数量（丸め済）


		//ヘッダの金額算出に利用
		$b_price[] = $b_amount;
		$c_price[] = $c_amount;
		$s_price[] = $s_amount;
		$tax_div[] = $val["tax_div"];

		//前受金がある場合（全行なしなら受注ヘッダにNULLを挿入するため）
		if($val["advance_flg"] == "2"){
			$advance_flg_h = true;
		}

		//前受金
		$ad_offset_tamount = $ad_offset_tamount + $val["advance_offset_amount"];


		//契約データの金額を修正
		if($type == "contract"){

			//$columns[trust_buy_amount]  = $b_amount;
			$columns["trade_amount"] = $c_amount;
			$columns["sale_amount"]  = $s_amount;
			$columns = pg_convert($db_con, 't_con_info', $columns); //SQLインジェクション対策
			$where["con_info_id"] = $val["id"];
	
			//データ修正
			$return = Db_Update($db_con, 't_con_info', $columns, $where);

		//受注データの金額を修正
		}elseif($type == "aord"){

			$columns["buy_amount"]  = $b_amount;
			$columns["cost_amount"] = $c_amount;
			$columns["sale_amount"] = $s_amount;
			$columns = pg_convert($db_con, 't_aorder_d', $columns); //SQLインジェクション対策
			$where["aord_d_id"] = $val["id"];
	
			//データ修正
			$return = Db_Update($db_con, 't_aorder_d', $columns, $where);
	
		}
	}

	$columns = NULL;
	$where = NULL;
	//****************************/
	//ヘッダ金額アップデート
	//****************************/
    #2009-12-24 aoyama-n
    #------------------------------------------------------
    //税率改定日と比較する日付を取得
    if($type == "contract"){
        //登録日(当日)
        $ord_time = date("Y-m-d");
    }elseif($type == "aord"){
        //受注日
        $sql  = "SELECT ";
        $sql .= "    ord_time ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "WHERE ";
        $sql .= "    aord_id = ".$data_id.";";
        $result = Db_Query($db_con, $sql);
        $ord_time = pg_fetch_result($result,0,0);
    }
    //税率クラス　インスタンス生成
    $tax_rate_obj = new TaxRate($shop_id);
    $tax_rate_obj->setTaxRateDay($ord_time);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);
    #------------------------------------------------------

	if($type == "contract"){
		//ヘッダテーブルの「仕入金額」を取得
		//$b_amount_h     = Total_Amount($b_price, $tax_div, $coax,$tax_franct, "0", $client_id,$db_con);
		//$columns[trust_buy_amount] = $b_amount_h[0];
	
		//ヘッダテーブルの「営業金額」
		//$c_amount_h     = Total_Amount($c_price, $tax_div, $c_coax,$tax_franct, $tax_num, $client_id,$db_con);
		$c_amount_h     = Total_Amount($c_price, $tax_div, $c_coax, $c_tax_franct, $tax_num, $act_id, $db_con);
		$columns["trade_amount"] = $c_amount_h[0];

		//ヘッダテーブルの「売上金額」
		$s_amount_h     = Total_Amount($s_price, $tax_div, $coax,$tax_franct, $tax_num, $client_id,$db_con);
		$columns["sale_amount"] = $s_amount_h[0];
		//$columns[tax_amount] = $s_amount_h[1];

		//アップデート実施
		$where["contract_id"] = $data_id;
		$return             = Db_Update($db_con, 't_contract', $columns, $where);

	}elseif($type == "aord"){
		//ヘッダテーブルの「仕入金額」
		//$b_amount_h     = Total_Amount($b_price, $tax_div, $coax,$tax_franct, "0", $client_id,$db_con);
		//$columns[buy_amount] = $b_amount_h[0];
	
		//ヘッダテーブルの「営業金額」
        #2009-12-24 aoyama-n
		#$c_amount_h     = Total_Amount($c_price, $tax_div, $c_coax,$tax_franct, $tax_num, $client_id,$db_con);
		$c_amount_h     = Total_Amount($c_price, $tax_div, $c_coax,$c_tax_franct, $tax_num, $client_id,$db_con);
		$columns["cost_amount"] = $c_amount_h[0];

		//ヘッダテーブルの「売上金額」
		$s_amount_h     = Total_Amount($s_price, $tax_div, $coax,$tax_franct, $tax_num, $client_id,$db_con);
		$columns["net_amount"] = $s_amount_h[0];
		$columns["tax_amount"] = $s_amount_h[1];

		//ヘッダテーブルの「前受相殺合計額」
		//前受相殺がある場合
		if($advance_flg_h === true){
			$columns["advance_offset_totalamount"] = $ad_offset_tamount;
		}

		//アップデート実施
		$where["aord_id"] = $data_id;
		$return         = Db_Update($db_con, 't_aorder_h', $columns, $where);
	}

	$amount["cost"] = $c_amount_h;
	$amount["sale"] = $s_amount_h;
	return $amount;

}


/**
 * 概要　伝票の「（受託先）仕入金額」「（受託先）営業金額」「（受託先）売上金額」をアップデートします。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 * @param string    $type        「contract」または「aord」
 *
 * @return void
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/09/12                  kajioka-h   受注ヘッダの（受託先用）消費税額は「業務代行料」の課税区分を使って計算するように変更
 *  2007/09/21                  kajioka-h   受注ヘッダの（受託先用）消費税額は消費税率は受託先、丸め・端数区分・課税区分は委託先のを使うように変更
 *  2008/01/18                  kajioka-h   代行料区分が固定額の場合、契約マスタの営業金額、受注ヘッダの原価金額（税抜）には代行料（固定額）を登録するように修正
 *  2009/12/24                  aoyama-n    税率をTaxRateクラスから取得
 *
 */
function Update_Amount_Act($db_con, $data_id, $type){

	//代行情報取得
	$act_data   = Get_Act_Info($db_con, $data_id, $type);  //代行料の情報を取得

	//代行でない場合
	if($act_data === false){
		return true;
	}
	$contract_div   = $act_data["contract_div"];        //契約区分
	$act_div        = $act_data["act_div"];             //代行料区分
	$act_rate       = $act_data["act_request_rate"];    //代行料（％）
	$act_price      = $act_data["act_request_price"];   //代行料（固定額）

	//■委託先
	$shop_id        = $act_data["shop_id"];             //委託先
	$client_id      = $act_data["client_id"];           //委託先からみた得意先
	$coax           = $act_data["coax"];                //委託先の丸め
	$tax_franct     = $act_data["tax_franct"];          //委託先の端数処理
    #2009-12-24 aoyama-n
	#$tax_num        = $act_data["tax_num"];             //委託先の消費税率

	//■代行先
	$act_id         = $act_data["act_id"];              //代行先
	$act_client_id  = $act_data["act_client_id"];       //代行先からみた委託先（東陽）
	$act_coax       = $act_data["act_coax"];            //代行先の丸め
	$act_tax_franct = $act_data["act_tax_franct"];      //代行先の端数処理
    #2009-12-24 aoyama-n
	#$act_tax_num    = $act_data["act_tax_num"];         //代行先の消費税率

	//■得意先東陽
	$toyo_coax       = $act_data["toyo_coax"];          //得意先東陽の丸め
	$toyo_tax_franct = $act_data["toyo_tax_franct"];    //得意先東陽の端数処理


	//オンライン代行の場合　得意先東陽で処理する
	//if($contract_div == "2"){
        #2009-12-24 aoyama-n
		#$act_coax       = $toyo_coax;            //委託先の丸め
		#$act_tax_franct = $toyo_tax_franct;      //委託先の端数処理
		//$act_tax_num    = $act_tax_num;          //代行先の消費税率

	//オフライン代行の場合　代行先
	//}else{
		//$act_coax       = $act_coax;             //代行先の丸め
		//$act_tax_franct = $act_tax_franct;       //代行先の端数処理
		//$act_tax_num    = $tax_num;              //委託先の消費税率
	//}
	

	//契約を基に商品情報を取得
	if($type == "contract"){	
		//単価・数量を取得
		$sql = "
			SELECT 
				t_contract.trust_id AS act_id,
				t_contract.contract_div,
				t_con_info.con_info_id AS id,
				t_con_info.goods_id,
				t_con_info.set_flg,
				0                           AS b_price,
				t_con_info.trust_cost_price AS c_price,
				t_con_info.sale_price       AS s_price,
				COALESCE(t_con_info.num, 1) AS num,
				CASE
					WHEN t_con_info.goods_id IS NULL THEN t_serv.tax_div
					ELSE t_goods.tax_div
				END AS tax_div
			FROM t_con_info
			INNER JOIN t_contract ON t_con_info.contract_id = t_contract.contract_id
			LEFT JOIN t_serv  ON t_con_info.serv_id  = t_serv.serv_id
			LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id
			WHERE t_con_info.contract_id = $data_id
		";

	//受注を基に商品情報を取得
	}elseif($type == "aord"){
		//単価・数量を取得
		$sql = "
			SELECT 
				t_aorder_h.act_id AS act_id,
				t_aorder_h.contract_div,
				t_aorder_d.aord_d_id AS id,
				t_aorder_d.goods_id,
				t_aorder_d.set_flg,
				t_aorder_d.trust_buy_price  AS b_price,
				t_aorder_d.trust_cost_price AS c_price,
				t_aorder_d.sale_price       AS s_price,
				COALESCE(t_aorder_d.num, 1) AS num,
				CASE
					WHEN t_aorder_d.goods_id IS NULL THEN t_serv.tax_div
					ELSE t_goods.tax_div
				END AS tax_div
			FROM t_aorder_d
			INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id
			LEFT JOIN t_serv  ON t_aorder_d.serv_id  = t_serv.serv_id
			LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id
			WHERE t_aorder_d.aord_id = $data_id
		";
	}
	$result = Db_Query($db_con, $sql);
	$data   = pg_fetch_all($result);


    //（受託先）消費税額再計算用に、商品「業務代行料」の課税区分を取得
    $sql = "SELECT tax_div FROM t_goods WHERE goods_cd = '09999901';";
    $result = Db_Query($db_con, $sql);
    $act_goods_tax_div = pg_fetch_result($result, 0, 0);


	//****************************/
	//データ金額アップデート
	//****************************/
	foreach($data as $key => $val){
		//仕入金額
		$b_amount = bcmul($val["b_price"], $val["num"], 2); //単価×数量（丸め前）
		$b_amount = Coax_Col($act_coax, $b_amount);         //単価×数量（丸め済）

		//営業金額
		$c_amount = bcmul($val["c_price"], $val["num"], 2); //単価×数量（丸め前）
		$c_amount = Coax_Col($act_coax, $c_amount);         //単価×数量（丸め済）

		//売上金額(代行料)
		$price    = bcdiv((bcmul($val["s_price"], $act_rate, 2)), 100, 2);  //単価
		if($val["set_flg"] == "t"){
			$val["num"] = 1;
		}
		$s_amount_tmp   = bcmul($price, $val["num"], 2);        //単価×数量（丸め前）
        #2009-12-24 aoyama-n
		#$s_amount       = Coax_Col($coax, $s_amount_tmp);       //単価×数量（丸め済）（原価金額）
		#$t_s_amount     = Coax_Col($toyo_coax, $s_amount_tmp);  //単価×数量（丸め済）（受託先用売上金額）
		$s_amount       = Coax_Col($act_coax, $s_amount_tmp);       //単価×数量（丸め済）（原価金額）
		$t_s_amount     = Coax_Col($act_coax, $s_amount_tmp);  //単価×数量（丸め済）（受託先用売上金額）

		//ヘッダの金額算出に利用
		$b_price[] = $b_amount;
		$c_price[] = $c_amount;
		$s_price[] = $s_amount;
		$t_s_price[] = $t_s_amount;
		$tax_div[] = $val["tax_div"];
		$act_tax_div[] = $act_goods_tax_div;

		//契約データの金額を修正
		if($type == "contract"){
            //代行料固定額以外の場合
            if($act_div != "2"){
    			$columns["trade_price"] = $price;
    			$columns["trade_amount"] = $s_amount;
            }

			$columns["trust_sale_price"] = $price;
			//$columns[trust_buy_amount]  = $b_amount;
			$columns["trust_cost_amount"] = $c_amount;
			$columns["trust_sale_amount"] = $t_s_amount;
			$columns = pg_convert($db_con, 't_con_info', $columns); //SQLインジェクション対策
			$where["con_info_id"] = $val["id"];
			//データ修正
			$return = Db_Update($db_con, 't_con_info', $columns, $where);

		//受注データの金額を修正
		}elseif($type == "aord"){
            if($act_div != "2"){
    			$columns["cost_price"]  = $price;
	    		$columns["cost_amount"] = $s_amount;
            }

			$columns["trust_sale_price"]  = $price;
			$columns["trust_buy_amount"]  = $b_amount;
			$columns["trust_cost_amount"] = $c_amount;
			$columns["trust_sale_amount"] = $t_s_amount;
			$columns = pg_convert($db_con, 't_aorder_d', $columns); //SQLインジェクション対策
			$where["aord_d_id"] = $val["id"];
			//データ修正
			$return = Db_Update($db_con, 't_aorder_d', $columns, $where);

		}
	}


	$columns = NULL;
	$where = NULL;
	//****************************/
	//ヘッダ金額アップデート
	//****************************/

    #2009-12-24 aoyama-n
    #------------------------------------------------------
    //税率改定日と比較する日付を取得
    if($type == "contract"){
        //登録日(当日)
        $ord_time = date("Y-m-d");
    }elseif($type == "aord"){
        //受注日
        $sql  = "SELECT ";
        $sql .= "    ord_time ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "WHERE ";
        $sql .= "    aord_id = ".$data_id.";";
        $result = Db_Query($db_con, $sql);
        $ord_time = pg_fetch_result($result,0,0);
    }
    //自社の消費税率
    $tax_rate_obj = new TaxRate($shop_id);
    $tax_rate_obj->setTaxRateDay($ord_time);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    //代行先の消費税率
    $act_tax_rate_obj = new TaxRate($act_id);
    $act_tax_rate_obj->setTaxRateDay($ord_time);
    $act_tax_num = $act_tax_rate_obj->getClientTaxRate($act_id);
    #------------------------------------------------------

	if($type == "contract"){
		//ヘッダテーブルの「仕入金額」を取得
		//$b_amount_h     = Total_Amount($b_price, $tax_div, $coax,$tax_franct, "0", $client_id,$db_con);
		//$columns[trust_buy_amount] = $b_amount_h[0];
	
		//ヘッダテーブルの「（受託先用）営業金額」をアップデート
        #2009-12-24 aoyama-n
		#$c_amount_h     = Total_Amount($c_price, $tax_div, $act_coax, $act_tax_franct, $tax_num, $act_client_id, $db_con);
		$c_amount_h     = Total_Amount($c_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
		$columns["trust_trade_amount"] = $c_amount_h[0];

		//ヘッダテーブルの営業金額
		//代行料区分が固定額の場合、代行料（固定額）を営業金額に登録
		if($act_div == "2"){
			$columns["trade_amount"] = $act_price;
		//それ以外は計算したやつ
		}else{
            #2009-12-24 aoyama-n
			#$s_amount_h     = Total_Amount($s_price, $tax_div, $act_coax, $act_tax_franct, $tax_num, $client_id, $db_con);
			$s_amount_h     = Total_Amount($s_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
			$columns["trade_amount"] = $s_amount_h[0];
		}

		//ヘッダテーブルの「（受託先用）売上金額」をアップデート
        #2009-12-24 aoyama-n
		#$t_s_amount_h   = Total_Amount($t_s_price, $tax_div, $toyo_coax, $toyo_tax_franct, $act_tax_num, $shop_id, $db_con);
		$t_s_amount_h   = Total_Amount($t_s_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
		$columns["trust_sale_amount"] = $t_s_amount_h[0];


		//アップデート実施
		$where["contract_id"] = $data_id;
		$return             = Db_Update($db_con, 't_contract', $columns, $where);

	}elseif($type == "aord"){
		//ヘッダテーブルの「仕入金額」を取得
		//$b_amount_h     = Total_Amount($b_price, $tax_div, $coax,$tax_franct, "0", $client_id,$db_con);
		//$columns[buy_amount] = $b_amount_h[0];
	
		//ヘッダテーブルの「（受託先用）営業金額」をアップデート
        #2009-12-24 aoyama-n
		#$c_amount_h     = Total_Amount($c_price, $tax_div, $act_coax, $act_tax_franct, $tax_num, $act_client_id, $db_con);
		$c_amount_h     = Total_Amount($c_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
		$columns["trust_cost_amount"] = $c_amount_h[0];

		//ヘッダテーブルの「営業金額」をアップデート
		//代行料区分が固定額の場合、代行料（固定額）を営業金額に登録
		if($act_div == "2"){
			$columns["cost_amount"] = $act_price;
		//それ以外は計算したやつ
		}else{
            #2009-12-24 aoyama-n
			#$s_amount_h     = Total_Amount($s_price, $act_tax_div, $coax, $tax_franct, $act_tax_num, $client_id, $db_con);
			$s_amount_h     = Total_Amount($s_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
			$columns["cost_amount"] = $s_amount_h[0];
		}

		//ヘッダテーブルの「売上金額」をアップデート
		//代行料（固定額）の場合
		if($act_div == "2"){
			//$tax_div = 1;//課税
			$act_tax_div = $act_goods_tax_div;  //業務代行料の課税区分
			$s_price = $act_price;
		}
        //（受託先用）売上金額（税抜）、（受託先用）消費税額は、受託先から見た売上金額を入れる
        //（消費税率は受託先、丸め・端数区分・課税区分は委託先のを使う）
        #2009-12-24 aoyama-n
		#$s_amount_h     = Total_Amount($t_s_price, $act_tax_div, $toyo_coax, $toyo_tax_franct, $act_tax_num, $shop_id, $db_con);
		$s_amount_h     = Total_Amount($t_s_price, $act_tax_div, $act_coax, $act_tax_franct, $act_tax_num, $act_id, $db_con);
		$columns["trust_net_amount"] = $s_amount_h[0];
		$columns["trust_tax_amount"] = $s_amount_h[1];

		//アップデート実施
		$where["aord_id"] = $data_id;
		$return           = Db_Update($db_con, 't_aorder_h', $columns, $where);
	}


	$amount["cost"] = $c_amount_h;
	$amount["sale"] = $s_amount_h;
	return $amount;

}



/**
 * 概要　受注伝票の「仕入単価」をアップデートします。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 *
 * @return void
 *
 */
function Update_Buy_Price($db_con, $data_id){

	//ショップID取得
	$sql = "SELECT t_aorder_h.shop_id FROM t_aorder_h WHERE aord_id = $data_id";
	$result  = Db_Query($db_con, $sql);
	$shop_id = pg_fetch_result($result, 0, 0);

	//サービスのみの場合は営業単価を登録
	$sql = "
		SELECT 
			t_aorder_d.aord_d_id AS id,
			t_aorder_d.goods_id,
			t_goods.compose_flg,
			CASE
				WHEN t_aorder_d.goods_id IS NULL THEN t_aorder_d.cost_price
				ELSE t_price.r_price
			END AS b_price
		FROM t_aorder_d
		LEFT JOIN t_serv  ON t_aorder_d.serv_id  = t_serv.serv_id
		LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id
		LEFT JOIN t_price ON t_goods.goods_id = t_price.goods_id AND t_price.rank_cd = 3 AND t_price.shop_id = $shop_id
		WHERE aord_id = $data_id
	";

	$result = Db_Query($db_con, $sql);
	$data   = pg_fetch_all($result);

	//データテーブルの金額をアップデートする
	foreach($data as $key => $val){
		//構成品の場合
		if($val["compose_flg"] == "t"){
			$com_price = Get_Compose_Price($db_con, $val["goods_id"], $shop_id);
			$columns["buy_price"] = $com_price["b_price"];
		}else{
			$columns["buy_price"] = $val["b_price"];
		}
		$columns = pg_convert($db_con, 't_aorder_d', $columns); //SQLインジェクション対策
		$where["aord_d_id"] = $val["id"];

		//データ修正
		$return = Db_Update($db_con, 't_aorder_d', $columns, $where);
	}

}

/**
 * 概要　受注伝票の「（受託先）仕入単価」をアップデートします。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     伝票ID
 *
 * @return void
 *
 */
function Update_Buy_Price_Act($db_con, $data_id){

	//代行先ID取得
	$sql      = "SELECT act_id, contract_div FROM t_aorder_h WHERE aord_id = $data_id";
	$result   = Db_Query($db_con, $sql);

	$act_data = pg_fetch_array($result,0,PGSQL_ASSOC);
	$shop_id  = $act_data["act_id"];

	//オンライン代行以外は処理しない
	if($act_data["contract_div"] != "2"){
		return false;
	}

	//サービスのみの場合は営業単価を登録
	$sql = "
		SELECT 
			t_aorder_d.aord_d_id AS id,
			t_aorder_d.goods_id,
			t_goods.compose_flg,
			CASE
				WHEN t_aorder_d.goods_id IS NULL THEN t_aorder_d.trust_cost_price
				ELSE t_price.r_price
			END AS b_price
		FROM t_aorder_d
		LEFT JOIN t_serv  ON t_aorder_d.serv_id  = t_serv.serv_id
		LEFT JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id
		LEFT JOIN t_price ON t_goods.goods_id = t_price.goods_id AND t_price.rank_cd = 3 AND t_price.shop_id = $shop_id
		WHERE aord_id = $data_id
	";
	$result = Db_Query($db_con, $sql);
	$data   = pg_fetch_all($result);

	//データテーブルの金額をアップデートする
	foreach( $data as $key => $val){

		//構成品の場合
		if($val["compose_flg"] == "t"){
			$com_price = Get_Compose_Price($db_con, $val["goods_id"], $shop_id);    //構成品の単価取得
			$columns["trust_buy_price"] = $com_price["b_price"];
		}else{
			$columns["trust_buy_price"] = $val["b_price"];
		}

		$columns = pg_convert($db_con, 't_aorder_d', $columns); //SQLインジェクション対策
		$where["aord_d_id"] = $val["id"];

		//データ修正
		$return = Db_Update($db_con, 't_aorder_d', $columns, $where);
	}

}

/**
 * 概要　構成品の「仕入単価」「営業単価」「売上単価」を取得します。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $data_id     商品ID
 * @param integer   $shop_id     ショップID
 *
 * @return array                 単価
 *
 */
function Get_Compose_Price($db_con,$goods_id,$shop_id){

    //子の商品のデータを抽出
    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_price.r_price,\n";
    $sql .= "    t_price2.r_price AS price,\n";
    $sql .= "    t_price3.r_price AS price2,\n";
    $sql .= "    t_goods.count\n";
    $sql .= " FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        t_goods.goods_id,\n";
    $sql .= "        t_goods.goods_cd,\n";
    $sql .= "        t_goods.goods_name,\n";
    $sql .= "        t_compose.count\n";
    $sql .= "     FROM\n";
    $sql .= "        t_goods\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_compose\n";
    $sql .= "        ON t_goods.goods_id = t_compose.parts_goods_id\n";
    $sql .= "     WHERE\n";
    $sql .= "        t_compose.goods_id = $goods_id\n";
    $sql .= "    ) AS t_goods\n";
    $sql .= "        LEFT JOIN\n";
//仕入単価
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = (SELECT rank_cd FROM t_client WHERE client_id = $shop_id)\n";
    $sql .= "    ) AS t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        LEFT JOIN\n";
//標準単価
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '4'\n";
    $sql .= "    ) AS t_price2\n";
    $sql .= "    ON t_goods.goods_id = t_price2.goods_id\n";
    $sql .= "        LEFT JOIN\n";
//営業単価
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '2'\n";
    $sql .= "        AND\n";
    $sql .= " shop_id = $shop_id ";
    $sql .= "    ) AS t_price3\n";
    $sql .= "    ON t_goods.goods_id = t_price3.goods_id\n";
    $sql .= " ;\n";

    $result = Db_Query($db_con, $sql);
    $parts_num = pg_num_rows($result);
    for($i = 0; $i < $parts_num; $i++){
        $set_parts_goods_data[$i] = pg_fetch_array($result, $i);
    }

    //セットする配列作成
    for($i = 0; $i < $parts_num; $i++){
        //単価
        //標準
        $price = bcmul($set_parts_goods_data[$i]["price"],$set_parts_goods_data[$i]["count"],2);

        //営業
        $price2 = bcmul($set_parts_goods_data[$i]["price2"],$set_parts_goods_data[$i]["count"],2);        
        $buy_total = bcmul($set_parts_goods_data[$i]["r_price"],$set_parts_goods_data[$i]["count"],2);

        //付加
        $buy_amount1 = bcadd($buy_amount1, $buy_total,2);
        //標準売価
        $buy_amount2 = bcadd($buy_amount2, $price,2);
        //営業
        $buy_amount3 = bcadd($buy_amount3, $price2,2); 
    }

	$r_data[b_price] =  $buy_amount1;
	$r_data[s_price] =  $buy_amount2;
	$r_data[c_price] =  $buy_amount3;

	return $r_data;

}


//予定伝票の重複作成をチェックする
function Get_Aord_Duplicat($db_con,$contract_id,$date){
	$sql  = "SELECT ";
	$sql .= " aord_id, ";
	$sql .= " ord_no, ";
	$sql .= " ord_time ";
	$sql .= " FROM t_aorder_h";
	$sql .= " WHERE contract_id = $contract_id";
	$sql .= " AND pre_ord_time = '$date'";
	$sql .= " AND change_flg = 't' ";
	$sql .= " AND ord_no IS NOT NULL";
	$sql .= " ORDER BY ord_time";
	$result = Db_Query($db_con, $sql);

	//重複データ分ループ処理
	while($data = pg_fetch_assoc($result)){
		//■エラーメッセージのリンクバージョン
		//$link = "<a href=\"../sale/2-2-107.php?aord_id=".$data["aord_id"]."\">".$data["ord_no"]."</a>";
		//$mesg_d   .= "・伝票番号：".$link."　巡回日：".$data["ord_time"]."<br>";
		$mesg_d   .= "・伝票番号：".$data["ord_no"]."　巡回日：".$data["ord_time"]."<br>";
		//$max_date  = $data["ord_time"];

		$err_flg   = true;
	}

	//重複データが無い場合
	if(!$err_flg){
		$chk_result = false; //falseを返す
		
	//重複データが有る場合はエラーメッセージを返す
	}else{
		$max_date = Mkdate($date); //翌日を取得
		$mesg_h  = "<font color=\"#ff00ff\">[警告]<br>";
		$mesg_h .= "■". $date ." に以下と同じ内容の予定データが作成されようとしています。<br>";
		$mesg_f .= "<br>問題なければ、そのまま「登録」ボタンを押して下さい。";
		$mesg_f .= "<br>問題があれば、「修正発効日」を ".$max_date." 以降に変更して「登録」ボタンを押して下さい。<p>";
		$mesg_f .= "</font>";

		$chk_result = $mesg_h.$mesg_d.$mesg_f;
	}
	
	return $chk_result;
}



/**
 * 概要　契約・受注の「商品コード・商品名・単価」を商品マスタを同じ値に変更します。
 *
 * 説明 
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $goods_id    商品ID
 * @param string    $kind        変更対象
 *
 * @return boolean  処理結果
 *
 */
function Mst_Sync_Goods($db_con,$goods_id,$kind,$price_name=NULL){

	//■商品コード、商品名を同期させる
	if($kind == "name"){
		$exec_result = Mst_Sync_Goods_Name($db_con,$goods_id);
		if($exec_result === false){
			return $exec_result;
		}

	//■商品単価を同期させる
	}elseif ($kind == "price"){

		//****************************/
		//通常商品（構成品でない）の単価修正
		//****************************/
		$exec_result = Mst_Sync_Goods_Price($db_con,$goods_id,$price_name);
		if($exec_result === false){
			return $exec_result;
		}

		//****************************/
		//構成品の単価修正（$goods_idが構成物となっているもの）
		//****************************/
		//$goods_idで構成された、親の構成品を抽出する
		$sql = "SELECT goods_id from t_compose WHERE parts_goods_id = $goods_id";
		$result = Db_Query($db_con, $sql);
		
		//構成品の数だけ処理する
		while ($data = pg_fetch_assoc($result)){
			$c_goods_id = $data["goods_id"]; //構成品コード

			$exec_result = Mst_Sync_Goods_Price($db_con,$c_goods_id,$price_name);
			if($exec_result === false){
				return $exec_result;
			}

		}

    // ■商品分類名を同期
    }elseif ($kind == "g_name"){

        // 変数代入
        $g_product_id = $goods_id;

        // 処理実行
        $exec_result = Mst_Sync_G_Product_Name($db_con, $g_product_id);

        // クエリエラーがあった場合はここで結果を返す
        if($exec_result === false){
            return $exec_result;
        }

    }

	return true;

}

/**
 * 概要　契約・受注の「単価」を商品マスタを同じ値に変更します。
 *
 * 説明 
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $goods_id    商品ID
 *
 * @return boolean  処理結果
 *
 */
function Mst_Sync_Goods_Price($db_con,$goods_id, $price_name=NULL){

	$group_kind = $_SESSION["group_kind"]; //
	$shop_id    = $_SESSION["client_id"];  //ショップID

	//構成品かチェック
	$sql      = "SELECT compose_flg, public_flg FROM t_goods WHERE goods_id = $goods_id ;";
	$result   = Db_Query($db_con, $sql);
	$goods_data = pg_fetch_assoc($result);

	//構成品の場合は構成品の単価を取得
	if($goods_data["compose_flg"] == "t"){
		$compose_price = Get_Compose_Price($db_con,$goods_id,$shop_id);
		//$compose_price[s_price];//標準売価
		//$compose_price[c_price];//営業原価

		//本部の場合は標準売価をセットする
		if($group_kind == "1"){
			$com_price = $compose_price["s_price"];

		//FCの場合は営業原価をセットする
		}else{
			$com_price = $compose_price["c_price"];
		}
	}
	
	//「構成品でない」または「単価がない」場合
	if($goods_data["compose_flg"] == "f" || $com_price == ""){
		$com_price = "0";
	}

	//対象データ取得SQL（契約マスタ用）
	$con_sql = "
		SELECT 
		t_con_info.contract_id,
		t_con_info.con_info_id,
		t_con_info.goods_id,
		t_goods.goods_name,
		COALESCE(t_price.r_price, $com_price) AS r_price                --構成品は単価が無いため単価には$com_priceを使用
		--t_price.r_price
		FROM t_goods
		INNER JOIN t_con_info ON t_goods.goods_id = t_con_info.goods_id
		INNER JOIN t_contract ON t_con_info.contract_id = t_contract.contract_id
		LEFT  JOIN t_price ON t_goods.goods_id = t_price.goods_id       --構成品は単価が無いためLEFT JOIN に変更
		--INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id
		WHERE t_goods.goods_id = $goods_id
		--AND t_contract.act_div != '2'        --代行料固定額以外
		--AND t_contract.contract_div = '1'        --通常契約
	";

	//対象データ取得SQL（受注データ用）
	$aord_sql = "
		SELECT 
		t_aorder_d.aord_id,
		t_aorder_d.aord_d_id,
		t_aorder_d.goods_id,
		t_goods.goods_name,
		COALESCE(t_price.r_price, $com_price) AS r_price                  --構成品は単価が無いため単価には$com_priceを使用
		--t_price.r_price
		FROM t_goods
		LEFT  JOIN t_price ON t_goods.goods_id = t_price.goods_id         --構成品は単価が無いためLEFT JOIN に変更
		--INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id
		INNER JOIN t_aorder_d ON t_goods.goods_id = t_aorder_d.goods_id 
		INNER JOIN t_aorder_h  ON t_aorder_d.aord_id = t_aorder_h.aord_id 
		WHERE t_goods.goods_id = $goods_id
		AND t_aorder_h.ord_no IS NULL            --未付番
		--AND t_aorder_h.act_div != '2'        --代行料固定額以外
		--AND t_aorder_h.contract_div = '1'        --通常契約
		--AND t_aorder_h.contract_id IS NOT NULL   --予定伝票（契約IDが登録されているもの）
	";
	
	//FCが営業原価を変更した場合、契約と受注の営業単価をアップデート
	if($group_kind != "1" && $price_name != "sale"){
		//代行（固定額）はアップデートしない。　⇒個別の営業原価を算出できないため

		//****************************/
		//契約マスタの営業金額をアップデートする
		//****************************/
		//■対象データ取得
		$sub_sql = $con_sql."
		    AND t_contract.act_div != '2'        --代行料固定額以外
		    AND t_con_info.mst_sync_flg = 'f' 
			AND t_contract.shop_id = $shop_id        --自社の伝票
			--AND t_price.shop_id = $shop_id
			--AND t_price.rank_cd = '2'                --営業原価
			AND (t_price.shop_id = $shop_id OR t_price.shop_id IS NULL)     --構成品は単価が無いためNULLの条件追加
			AND (t_price.rank_cd = '2' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
		";
		$sub_result = Db_Query($db_con, $sub_sql); //金額の再計算用

		//■営業原価変更
		$sql = "
			UPDATE t_con_info SET
			trade_price          = t_data.r_price
			FROM (".$sub_sql.") AS t_data
			WHERE t_con_info.con_info_id = t_data.con_info_id
		";
		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}

		//■原価金額の再計算
		while($con_info = pg_fetch_assoc($sub_result)){

			$contract_id = $con_info["contract_id"];

			//処理済みでない場合（contract_idは重複があるためこのようなチェックを実施）
			if($end_flg[$contract_id] != 't'){
				Update_Act_Amount($db_con, $contract_id, "contract"); //金額の再計算実施
				$end_flg[$contract_id] = "t";//処理済みフラグ
			}
		}
		$end_flg = NULL;

		//****************************/
		//受注データの営業金額をアップデートする
		//****************************/
		//■対象データ取得
		$sub_sql = $aord_sql."
		    AND t_aorder_h.act_div != '2'        --代行料固定額以外
            AND t_aorder_d.mst_sync_flg = 'f' 
			AND t_aorder_h.shop_id = $shop_id        --自社の伝票
			AND (t_price.shop_id = $shop_id OR t_price.shop_id IS NULL)     --構成品は単価が無いためNULLの条件追加
			AND (t_price.rank_cd = '2' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
			--AND t_price.shop_id = $shop_id
		";
		$sub_result = Db_Query($db_con, $sub_sql);

		//■原価単価変更
		$sql = "
			UPDATE t_aorder_d SET
			cost_price = t_data.r_price
			FROM (".$sub_sql.") AS t_data
			WHERE t_aorder_d.aord_d_id = t_data.aord_d_id
		";
		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}

		//■原価金額の再計算
		while($aord_info = pg_fetch_assoc($sub_result)){
			$aord_id = $aord_info["aord_id"];

			//処理済みでない場合（contract_idは重複があるためこのようなチェックを実施）
			if($end_flg[$aord_id] != 't'){
				Update_Act_Amount($db_con, $aord_id, "aord"); //金額の再計算実施
				$end_flg[$aord_id] = "t";//処理済みフラグ
			}
		}
		$end_flg = NULL;


        //■FCの場合、オンライン代行の（受託先用）営業原価変更
        if($group_kind == "3"){
            //■対象データ取得
            $sub_sql = $con_sql."
		        AND t_con_info.trust_mst_sync_flg = 'f' 
                AND t_contract.trust_id = $shop_id          --代行伝票
                AND t_contract.contract_div = '2'           --オンライン代行
                --AND t_price.shop_id = $shop_id
                --AND t_price.rank_cd = '2'                 --営業原価
                AND (t_price.shop_id = $shop_id OR t_price.shop_id IS NULL)     --構成品は単価が無いためNULLの条件追加
                AND (t_price.rank_cd = '2' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
            ";
            $sub_result = Db_Query($db_con, $sub_sql);  //金額の再計算用

            //■（受託先用）営業原価変更
            $sql = "
                UPDATE t_con_info SET
                trust_cost_price    = t_data.r_price
                FROM (".$sub_sql.") AS t_data
                WHERE t_con_info.con_info_id = t_data.con_info_id
            ";
            $result = Db_Query($db_con, $sql);
            if(!$result){
                Db_Query($db_con, "ROLLBACK;");
                return false;
            }

            //■（受託先用）原価金額の再計算
            while($con_info = pg_fetch_assoc($sub_result)){

                $contract_id = $con_info["contract_id"];

                //処理済みでない場合（contract_idは重複があるためこのようなチェックを実施）
                if($end_flg[$contract_id] != 't'){
                    Update_Act_Amount($db_con, $contract_id, "contract");   //金額の再計算実施
                    $end_flg[$contract_id] = "t";                           //処理済みフラグ
                }
            }
            $end_flg = NULL;


            //受注データの（受託先用）営業金額をアップデートする
            //■対象データ取得
            $sub_sql = $aord_sql."
                AND t_aorder_d.trust_mst_sync_flg = 'f' 
                AND t_aorder_h.act_id = $shop_id                --自分が代行先の伝票
                AND t_aorder_h.contract_div = '2'               --オンライン代行
                AND (t_price.shop_id = $shop_id OR t_price.shop_id IS NULL)     --構成品は単価が無いためNULLの条件追加
                AND (t_price.rank_cd = '2' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
                --AND t_price.shop_id = $shop_id
            ";
            $sub_result = Db_Query($db_con, $sub_sql);

            //■（受託先用）原価単価変更
            $sql = "
                UPDATE t_aorder_d SET
                trust_cost_price = t_data.r_price
                FROM (".$sub_sql.") AS t_data
                WHERE t_aorder_d.aord_d_id = t_data.aord_d_id
            ";
            $result = Db_Query($db_con, $sql);
            if(!$result){
                Db_Query($db_con, "ROLLBACK");
                return false;
            }

            //■原価金額の再計算
            while($aord_info = pg_fetch_assoc($sub_result)){
                $aord_id = $aord_info["aord_id"];

                //処理済みでない場合（contract_idは重複があるためこのようなチェックを実施）
                if($end_flg[$aord_id] != 't'){
                    Update_Act_Amount($db_con, $aord_id, "aord"); //金額の再計算実施
                    $end_flg[$aord_id] = "t";//処理済みフラグ
                }
            }
            $end_flg = NULL;

        }//オンライン代行の（受託先用）原価金額更新おわり

	}//本部以外が営業原価を変更した、営業原価をアップデートおわり


	//本部、または自社商品の場合、売上単価をアップデート
	if(($group_kind == "1" || $goods_data["public_flg"] == "f") && $price_name != "buy"){
		//****************************/
		//契約マスタの売上金額をアップデート（各ショップ分）
		//****************************/
		//■対象データ取得
		$sub_sql = $con_sql."
		    AND t_con_info.mst_sync_flg = 'f' 
			AND (t_price.rank_cd = '4' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
			--AND t_price.rank_cd = '4'
		";
		$sub_result = Db_Query($db_con, $sub_sql);

		//■売上単価変更
		$sql = "
			UPDATE t_con_info SET
			sale_price          = t_data.r_price
			FROM (".$sub_sql.") AS t_data
			WHERE t_con_info.con_info_id = t_data.con_info_id
		";
		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}

		//■売上金額の再計算
		while($con_info = pg_fetch_assoc($sub_result)){
			$contract_id = $con_info["contract_id"];
			
			//重複処理でない場合（contract_idは商品数分の重複があるため）
			if($end_flg[$contract_id] != 't'){
				Update_Act_Amount($db_con, $contract_id, "contract"); //金額の再計算実施
				$end_flg[$contract_id] = "t";//処理済みフラグ
			}
		}
		$end_flg = NULL;

		//****************************/
		//受注データの売上金額をアップデート（各ショップ分）
		//****************************/
		//■対象データ取得
		$sub_sql = $aord_sql."
            AND t_aorder_d.mst_sync_flg = 'f' 
			AND (t_price.rank_cd = '4' OR t_price.rank_cd IS NULL)          --構成品は単価が無いためNULLの条件追加
			--AND t_price.rank_cd = '4'
		";
		$sub_result = Db_Query($db_con, $sub_sql);

		//■売上単価変更
		$sql = "
			UPDATE t_aorder_d SET
			sale_price          = t_data.r_price
			FROM (".$sub_sql.") AS t_data
			WHERE t_aorder_d.aord_d_id = t_data.aord_d_id
		";
		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}

		//■売上金額の再計算
		while($aord_info = pg_fetch_assoc($sub_result)){
			$aord_id = $aord_info["aord_id"];
			
			//処理済みでない場合（contract_idは重複があるためこのようなチェックを実施）
			if($end_flg[$aord_id] != 't'){
				Update_Act_Amount($db_con, $aord_id, "aord"); //金額の再計算実施
				$end_flg[$aord_id] = "t";//処理済みフラグ
			}
		}
		$end_flg = NULL;
	}


	return true;

}


/**
 * 概要     契約・受注の商品分類を商品分類マスタと同期
 *
 * 説明
 *
 * @param object    $db_con         DBコネクション
 * @param integer   $g_product_id   商品分類ID
 *
 * @return boolean  処理結果
 *
 */
function Mst_Sync_G_Product_Name($db_con, $g_product_id){

    // SESSION値を変数にセット
    $group_kind = $_SESSION["group_kind"];
    $shop_id    = $_SESSION["client_id"];

    /****************************/
    // 契約データ更新処理
    /****************************/
    // 更新に必要なデータを取得
    $sql  = "       SELECT \n";
    $sql .= "           t_con_info.con_info_id, \n";                                                        // 契約内容ID
    $sql .= "           t_g_product.g_product_name || ' ' || t_goods.goods_name AS official_goods_name \n"; // 商品正式名
    $sql .= "       FROM \n";
    $sql .= "           t_contract \n";
    $sql .= "           INNER JOIN t_con_info   ON  t_contract.contract_id = t_con_info.contract_id \n";
    if ($group_kind != "1"){
    $sql .= "                                   AND t_contract.shop_id = $shop_id \n";                      // 自社契約（本部以外）
    }
    $sql .= "                                   AND t_con_info.mst_sync_flg = 'f' \n";                      // 非同期フラグfalse
    $sql .= "           INNER JOIN t_goods      ON  t_con_info.goods_id = t_goods.goods_id \n";
    $sql .= "                                   AND t_goods.shop_id = $shop_id \n";                         // 自社商品
    $sql .= "           INNER JOIN t_g_product  ON  t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "                                   AND t_g_product.g_product_id = $g_product_id \n";           // 該当商品分類
    $sql .= "                                   AND t_g_product.shop_id = $shop_id \n";                     // 自社商品分類
    $src_sql = $sql;

    // 上記データを元に契約データを更新
    // 更新対象：商品正式名
    $sql  = "UPDATE \n";
    $sql .= "   t_con_info \n";
    $sql .= "SET \n";
    $sql .= "   official_goods_name = t_src.official_goods_name \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .=         $src_sql;
    $sql .= "   ) \n";
    $sql .= "   AS t_src \n";
    $sql .= "WHERE \n";
    $sql .= "   t_con_info.con_info_id = t_src.con_info_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // エラー時はロールバック
    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        return false;
    }

    /****************************/
    // 受注データ更新処理
    /****************************/
    // 更新に必要なデータを取得
    $sql  = "       SELECT \n";
    $sql .= "           t_aorder_d.aord_d_id, \n";                                                          // 受注データID
    $sql .= "           t_g_product.g_product_name, \n";                                                    // 商品分類名
    $sql .= "           t_g_product.g_product_name || ' ' || t_goods.goods_name AS official_goods_name \n"; // 商品正式名
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_h \n";
    $sql .= "           INNER JOIN t_aorder_d   ON  t_aorder_h.aord_id = t_aorder_d.aord_id \n";
    if ($group_kind != "1"){
    $sql .= "                                   AND t_aorder_h.shop_id = $shop_id \n";                      // 自社伝票（本部以外）
    }
    $sql .= "                                   AND t_aorder_h.ord_no IS NULL \n";                          // 未付番伝票
    $sql .= "                                   AND t_aorder_d.mst_sync_flg = 'f' \n";                      // 非同期フラグfalse
    $sql .= "           INNER JOIN t_goods      ON  t_aorder_d.goods_id = t_goods.goods_id \n";
    $sql .= "                                   AND t_goods.shop_id = $shop_id \n";                         // 自社商品
    $sql .= "           INNER JOIN t_g_product  ON  t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "                                   AND t_g_product.g_product_id = $g_product_id \n";           // 該当商品分類
    $sql .= "                                   AND t_g_product.shop_id = $shop_id \n";                     // 自社商品分類
    $src_sql = $sql;

    // 上記データを元に受注データを更新
    // 更新対象：商品分類名、商品正式名
    $sql  = "UPDATE \n";
    $sql .= "   t_aorder_d \n";
    $sql .= "SET \n";
    $sql .= "   g_product_name      = t_src.g_product_name, \n";
    $sql .= "   official_goods_name = t_src.official_goods_name \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .=         $src_sql;
    $sql .= "   ) \n";
    $sql .= "   AS t_src \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_d.aord_d_id = t_src.aord_d_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // エラー時はロールバック
    if ($res === false){
        Db_Query($db_con, "ROLLBACK;");
        return false;
    }

    // ここまでこれたらtrueを返す
    return true;

}

/**
 * 概要　契約・受注の「商品コード・商品名」を商品マスタを同じ値に変更します。
 *
 * 説明 
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $goods_id    商品ID
 *
 * @return boolean  処理結果
 *
 */
function Mst_Sync_Goods_Name($db_con,$goods_id){
	
	$group_kind = $_SESSION["group_kind"]; //
	$shop_id    = $_SESSION["client_id"];  //ショップID


	//対象カラム
	$column[] = "goods";
	$column[] = "rgoods";
	$column[] = "egoods";

	foreach($column AS $key => $goods_column){

		//****************************/
		//契約データアップデート
		//****************************/
		//■対象契約データIDと商品マスタの名称を取得
		$sub_sql = "
			SELECT 
			t_con_info.con_info_id,
			t_goods.goods_cd,
			t_goods.goods_cname,
            t_con_info.".$goods_column."_id,
			t_g_product.g_product_name,
			COALESCE((t_g_product.g_product_name || ' ' ||t_goods.goods_name),t_goods.goods_name )AS official_goods_name
			--t_g_product.g_product_name || ' ' ||t_goods.goods_name AS official_goods_name
			FROM t_contract 
			INNER JOIN t_con_info  ON t_contract.contract_id = t_con_info.contract_id 
			INNER JOIN t_goods     ON t_con_info.".$goods_column."_id = t_goods.goods_id 
			LEFT  JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id   --構成品は単価が無いためLEFT JOIN に変更
			--INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id
			WHERE t_con_info.".$goods_column."_id = $goods_id 
			AND t_con_info.mst_sync_flg = 'f' 
			AND t_goods.shop_id = $shop_id                --自社商品
		";

		if($goods_column == "goods"){
			$sql = "
				UPDATE t_con_info SET
				goods_name          = t_data.goods_cname,
				official_goods_name = t_data.official_goods_name
				FROM (".$sub_sql.") AS t_data
				WHERE t_con_info.con_info_id = t_data.con_info_id
			";
		}else{
			$sql = "
				UPDATE t_con_info SET
				".$goods_column."_name          = t_data.goods_cname
				FROM (".$sub_sql.") AS t_data
				WHERE t_con_info.con_info_id = t_data.con_info_id
			";
		}

		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}
	
		//****************************/
		//契約出庫品テーブルアップデート
		//****************************/
        //アイテムと消耗品の場合
        if($goods_column == "goods" || $goods_column == "egoods"){
            $sql = "
                    UPDATE t_con_ship SET
                    goods_name = t_data.goods_cname
                    FROM (".$sub_sql.") AS t_data
                    WHERE t_con_ship.con_info_id = t_data.con_info_id
                    AND t_con_ship.goods_id = t_data.".$goods_column."_id
            ";
            $result = Db_Query($db_con, $sql);
            if(!$result){
                Db_Query($db_con, "ROLLBACK;");
                return false;
            }
        }

		//****************************/
		//受注データアップデート
		//****************************/
		//■対象受注データIDと商品マスタの名称を取得
		$sub_sql = "
			SELECT
            t_aorder_d.".$goods_column."_id,  
			t_aorder_d.aord_d_id,
			t_goods.goods_cd,
			t_goods.goods_cname,
			t_g_product.g_product_name,
			COALESCE((t_g_product.g_product_name || ' ' ||t_goods.goods_name),t_goods.goods_name )AS official_goods_name
			--t_g_product.g_product_name || ' ' ||t_goods.goods_name AS official_goods_name
			FROM t_aorder_h 
			INNER JOIN t_aorder_d  ON t_aorder_h.aord_id = t_aorder_d.aord_id 
			INNER JOIN t_goods     ON t_aorder_d.".$goods_column."_id = t_goods.goods_id 
			LEFT  JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id   --構成品は単価が無いためLEFT JOIN に変更
			--INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id
			WHERE t_aorder_d.".$goods_column."_id = $goods_id 
			AND t_aorder_d.mst_sync_flg = 'f' 
			AND t_goods.shop_id = $shop_id           --自社商品
			--AND t_aorder_h.shop_id = $shop_id      --本部はショップの伝票も変更するためこの条件は不要
			AND t_aorder_h.ord_no IS NULL            --未付番
			--AND t_aorder_h.contract_id IS NOT NULL   --予定伝票（契約IDが登録されているもの）
		";
		
		if($goods_column == "goods"){
			$sql = "
				UPDATE t_aorder_d SET
				goods_cd            = t_data.goods_cd,
				g_product_name      = t_data.g_product_name,
				goods_name          = t_data.goods_cname,
				official_goods_name = t_data.official_goods_name
				FROM (".$sub_sql.") AS t_data
				WHERE t_aorder_d.aord_d_id = t_data.aord_d_id
			";
		}else{
			$sql = "
				UPDATE t_aorder_d SET
				".$goods_column."_cd            = t_data.goods_cd,
				".$goods_column."_name          = t_data.goods_cname
				FROM (".$sub_sql.") AS t_data
				WHERE t_aorder_d.aord_d_id = t_data.aord_d_id
			";
		}
		
		$result = Db_Query($db_con, $sql);
		if(!$result){
			Db_Query($db_con, "ROLLBACK");
			return false;
		}

		//****************************/
		//出庫品テーブルアップデート
		//****************************/
        //アイテムと消耗品の場合
        if($goods_column == "goods" || $goods_column == "egoods"){
            $sql = "
                    UPDATE t_aorder_ship SET
                    goods_cd   = t_data.goods_cd,
                    goods_name = t_data.goods_cname
                    FROM (".$sub_sql.") AS t_data
                    WHERE t_aorder_ship.aord_d_id = t_data.aord_d_id
                    AND t_aorder_ship.goods_id = t_data.".$goods_column."_id
            ";

            $result = Db_Query($db_con, $sql);
            if(!$result){
                Db_Query($db_con, "ROLLBACK;");
                return false;
            }
        }
	}
	return true;
}


//指定日の○日後を取得する（yyyy-mm-dd形式）
function Mkdate($date,$num=1){
	$day  = explode("-",$date);
	$date = date('Y-m-d', mktime(0, 0, 0, $day[1], $day[2]+$num, $day[0]));
	
	return $date;
}


/**
 * 概要 巡回日のラジオボタンに応じてフォームを有効無効を切替えます。
 *
 * 説明
 *
 * @return string          javascript
 */
function Js_Keiyaku(){

	$group_kind  = $_SESSION["group_kind"]; //グループ種別

	/****************************/
	//javascript
	/****************************/
	//一式にチェックを付けた場合、金額計算処理
	$java_sheet  .= "function Set_num(row,coax,daiko_coax) {\n";
	
	/*
	//FC・直営判定
	if($group_kind == 2){
		//直営は、代行料を考慮した計算
	$java_sheet  .= "    Mult_double3('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false,row,'',daiko_coax);\n";
	}else{
	*/

	//ＦＣは、普通の一式の計算
	$java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false);\n";
	//}
	$java_sheet  .= " }\n\n";
	
	//巡回日１
	$java_sheet  .= "function Check_round1() {\n";
	$java_sheet  .= "    var str1  = \"form_abcd_week1\";\n";
	$java_sheet  .= "    var str2  = \"form_week_rday1\";\n";
	$java_sheet  .= "    document.dateForm.elements[str1].disabled = true;\n";
	$java_sheet  .= "    document.dateForm.elements[str1].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "    document.dateForm.elements[str2].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str2].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "}\n\n";
	
	//巡回日２
	$java_sheet  .= "function Check_round2() {\n";
	$java_sheet  .= "    var str5  = \"form_rday2\";\n";
	$java_sheet  .= "    document.dateForm.elements[str5].disabled = true;\n";
	$java_sheet  .= "    document.dateForm.elements[str5].style.backgroundColor = \"white\";\n"; 
	$java_sheet  .= "}\n\n";
	
	//巡回日３
	$java_sheet  .= "function Check_round3() {\n";
	$java_sheet  .= "    var str8  = \"form_cale_week3\";\n";
	$java_sheet  .= "    var str9  = \"form_week_rday3\";\n";
	$java_sheet  .= "    document.dateForm.elements[str8].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str8].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "    document.dateForm.elements[str9].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str9].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "}\n\n";
	
	//巡回日４
	$java_sheet  .= "function Check_round4() {\n";
	$java_sheet  .= "    var str13  = \"form_cale_week4\";\n";
	$java_sheet  .= "    var str14 = \"form_week_rday4\";\n";
	$java_sheet  .= "    document.dateForm.elements[str13].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str13].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "    document.dateForm.elements[str14].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str14].style.backgroundColor = \"gainsboro\";\n";
	$java_sheet  .= "}\n\n";
	
	//巡回日５
	$java_sheet  .= "function Check_round5() {\n";
	$java_sheet  .= "    var str17 = \"form_cale_month5\";\n";
	$java_sheet  .= "    var str18 = \"form_week_rday5\";\n";
	$java_sheet  .= "    document.dateForm.elements[str17].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str17].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "    document.dateForm.elements[str18].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str18].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "}\n\n";
	
	//巡回日６
	$java_sheet  .= "function Check_round6() {\n";
	$java_sheet  .= "    var str21 = \"form_cale_month6\";\n";
	$java_sheet  .= "    var str22 = \"form_cale_week6\";\n";
	$java_sheet  .= "    var str23 = \"form_week_rday6\";\n";
	$java_sheet  .= "    document.dateForm.elements[str21].disabled = true;\n";
	$java_sheet  .= "    document.dateForm.elements[str21].style.backgroundColor = \"white\";\n"; 
	$java_sheet  .= "    document.dateForm.elements[str22].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str22].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "    document.dateForm.elements[str23].disabled = true;\n"; 
	$java_sheet  .= "    document.dateForm.elements[str23].style.backgroundColor = \"white\";\n";
	$java_sheet  .= "}\n\n";
	
	//チェックをつけるとテキストボックスに入力できる(一式)
	$java_sheet  .= "function Check_read(num) {\n";
	$java_sheet  .= "    var str1  = \"form_abcd_week1\";\n";
	$java_sheet  .= "    var str2  = \"form_week_rday1\";\n";
	$java_sheet  .= "    var str5  = \"form_rday2\";\n";
	$java_sheet  .= "    var str8  = \"form_cale_week3\";\n";
	$java_sheet  .= "    var str9  = \"form_week_rday3\";\n";
	$java_sheet  .= "    var str13  = \"form_cale_week4\";\n";
	$java_sheet  .= "    var str14 = \"form_week_rday4\";\n";
	$java_sheet  .= "    var str17 = \"form_cale_month5\";\n";
	$java_sheet  .= "    var str18 = \"form_week_rday5\";\n";
	$java_sheet  .= "    var str21 = \"form_cale_month6\";\n";
	$java_sheet  .= "    var str22 = \"form_cale_week6\";\n";
	$java_sheet  .= "    var str23 = \"form_week_rday6\";\n";
	$java_sheet  .= "    var str24 = \"form_irr_day\";\n";
	$java_sheet  .= "    var sday_y = \"form_stand_day[y]\";\n";
	$java_sheet  .= "    var sday_m = \"form_stand_day[m]\";\n";
	$java_sheet  .= "    var sday_d = \"form_stand_day[d]\";\n";
	$java_sheet  .= "             Check_round1();\n"; //（１）
	$java_sheet  .= "             Check_round2();\n"; //（２）
	$java_sheet  .= "             Check_round3();\n"; //（３）
	$java_sheet  .= "             Check_round4();\n"; //（４）
	$java_sheet  .= "             Check_round5();\n"; //（５）
	$java_sheet  .= "             Check_round6();\n"; //（６）
	
	$java_sheet  .= "    switch (num){\n"; 
								 //巡回１
	$java_sheet  .= "            case '1':\n";
	$java_sheet  .= "             document.dateForm.elements[str1].disabled = false;\n";
	$java_sheet  .= "             document.dateForm.elements[str1].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             document.dateForm.elements[str2].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str2].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             break;\n";
	 
								 //巡回２ 
	$java_sheet  .= "            case '2':\n";
	$java_sheet  .= "             document.dateForm.elements[str5].disabled = false;\n";
	$java_sheet  .= "             document.dateForm.elements[str5].style.backgroundColor = \"#FDFD66\";\n"; 
	$java_sheet  .= "             break;\n";
	 
								 //巡回３ 
	$java_sheet  .= "            case '3':\n";
	$java_sheet  .= "             document.dateForm.elements[str8].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str8].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             document.dateForm.elements[str9].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str9].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             break;\n"; 
	
								 //巡回４ 
	$java_sheet  .= "            case '4':\n";
	$java_sheet  .= "             document.dateForm.elements[str13].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str13].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             document.dateForm.elements[str14].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str14].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             break;\n"; 
	
								 //巡回５ 
	$java_sheet  .= "            case '5':\n";
	$java_sheet  .= "             document.dateForm.elements[str17].disabled = false;\n";
	$java_sheet  .= "             document.dateForm.elements[str17].style.backgroundColor = \"#FDFD66\";\n"; 
	$java_sheet  .= "             document.dateForm.elements[str18].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str18].style.backgroundColor = \"#FDFD66\";\n";               
	$java_sheet  .= "             break;\n"; 
	
								//巡回６ 
	$java_sheet  .= "            case '6':\n";
	$java_sheet  .= "             document.dateForm.elements[str21].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str21].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             document.dateForm.elements[str22].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str22].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             document.dateForm.elements[str23].disabled = false;\n"; 
	$java_sheet  .= "             document.dateForm.elements[str23].style.backgroundColor = \"#FDFD66\";\n";
	$java_sheet  .= "             break;\n";
	  
								//巡回７
	$java_sheet  .= "            case '7':\n";
	$java_sheet  .= "            break;\n";  
	$java_sheet  .= "    }\n";       
	
	//直営判定
	if($group_kind == 2){
		//代行依頼チェックボックス
		$java_sheet  .= "    daiko_checked();\n";
	}
	
	$java_sheet  .= "    return true;\n";
	
	$java_sheet  .= "}\n\n";
	
	//代行用
	$java_sheet  .= <<<DAIKO
	
	//代行依頼チェックボックス
	function daiko_checked(){
		//代行依頼判定
		if(!document.dateForm.daiko_check[0].checked){
			//オンライン代行・オフライン代行
	/*
			//代行商品
			document.dateForm.elements["form_act_goods_cd"].disabled = false;
			document.dateForm.elements["form_act_goods_name"].disabled = false;
			document.dateForm.elements["form_act_goods_cd"].style.backgroundColor = "white";
			document.dateForm.elements["form_act_goods_name"].style.backgroundColor = "white";
	*/
			//代行料
			//document.dateForm.elements["form_daiko_price"].disabled = false;
			//document.dateForm.elements["form_daiko_price"].style.backgroundColor = "white";
			//document.dateForm.elements["act_request_price"].disabled = false;
			//document.dateForm.elements["act_request_price"].style.backgroundColor = "white";


			//委託先
			document.dateForm.elements["form_daiko[cd1]"].disabled = false;
			document.dateForm.elements["form_daiko[cd2]"].disabled = false;
			document.dateForm.elements["form_daiko[name]"].disabled = false;
			document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "white";
			document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "white";
			document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "white";
	
			//巡回担当
			document.dateForm.elements["form_c_staff_id1"].disabled = true;
			document.dateForm.elements["form_c_staff_id2"].disabled = true;
			document.dateForm.elements["form_c_staff_id3"].disabled = true;
			document.dateForm.elements["form_c_staff_id4"].disabled = true;
	
			//売上率
			document.dateForm.elements["form_sale_rate1"].disabled = true;
			document.dateForm.elements["form_sale_rate2"].disabled = true;
			document.dateForm.elements["form_sale_rate3"].disabled = true;
			document.dateForm.elements["form_sale_rate4"].disabled = true;
			document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "gainsboro";
	
			//順路
			document.dateForm.elements["form_route_load[1]"].disabled = true;
			document.dateForm.elements["form_route_load[2]"].disabled = true;
			document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "gainsboro";
	
			//委託先宛備考
			document.dateForm.elements["form_daiko_note"].disabled = false;
			document.dateForm.elements["form_daiko_note"].style.backgroundColor = "white";
	
			//営業原価
	/*
			document.dateForm.elements["form_trade_price[1][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[1][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][2]"].readOnly = true;
	*/

		}else{
			//通常
	/*
			//代行商品
			document.dateForm.elements["form_act_goods_cd"].disabled = true;
			document.dateForm.elements["form_act_goods_name"].disabled = true;
			document.dateForm.elements["form_act_goods_cd"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_act_goods_name"].style.backgroundColor = "gainsboro";
	*/
			//代行料
			//document.dateForm.elements["form_daiko_price"].disabled = true;
			//document.dateForm.elements["form_daiko_price"].style.backgroundColor = "gainsboro";
			//document.dateForm.elements["act_request_price"].disabled = true;
			//document.dateForm.elements["act_request_price"].style.backgroundColor = "gainsboro";

			//委託先
			document.dateForm.elements["form_daiko[cd1]"].disabled = true;
			document.dateForm.elements["form_daiko[cd2]"].disabled = true;
			document.dateForm.elements["form_daiko[name]"].disabled = true;
			document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "gainsboro";
			document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "gainsboro";
	
			//巡回担当
			document.dateForm.elements["form_c_staff_id1"].disabled = false;
			document.dateForm.elements["form_c_staff_id2"].disabled = false;
			document.dateForm.elements["form_c_staff_id3"].disabled = false;
			document.dateForm.elements["form_c_staff_id4"].disabled = false;
	
			//売上率
			document.dateForm.elements["form_sale_rate1"].disabled = false;
			document.dateForm.elements["form_sale_rate2"].disabled = false;
			document.dateForm.elements["form_sale_rate3"].disabled = false;
			document.dateForm.elements["form_sale_rate4"].disabled = false;
			document.dateForm.elements["form_sale_rate1"].style.backgroundColor = "white";
			document.dateForm.elements["form_sale_rate2"].style.backgroundColor = "white";
			document.dateForm.elements["form_sale_rate3"].style.backgroundColor = "white";
			document.dateForm.elements["form_sale_rate4"].style.backgroundColor = "white";
	
			//順路
			document.dateForm.elements["form_route_load[1]"].disabled = false;
			document.dateForm.elements["form_route_load[2]"].disabled = false;
			document.dateForm.elements["form_route_load[1]"].style.backgroundColor = "white";
			document.dateForm.elements["form_route_load[2]"].style.backgroundColor = "white";
	
			//委託先宛備考
			document.dateForm.elements["form_daiko_note"].disabled = true;
			document.dateForm.elements["form_daiko_note"].style.backgroundColor = "gainsboro";
	
			//営業原価
			document.dateForm.elements["form_trade_price[1][1]"].readOnly = false;
			document.dateForm.elements["form_trade_price[1][2]"].readOnly = false;
			document.dateForm.elements["form_trade_price[2][1]"].readOnly = false;
			document.dateForm.elements["form_trade_price[2][2]"].readOnly = false;
			document.dateForm.elements["form_trade_price[3][1]"].readOnly = false;
			document.dateForm.elements["form_trade_price[3][2]"].readOnly = false;
			document.dateForm.elements["form_trade_price[4][1]"].readOnly = false;
			document.dateForm.elements["form_trade_price[4][2]"].readOnly = false;
			document.dateForm.elements["form_trade_price[5][1]"].readOnly = false;
			document.dateForm.elements["form_trade_price[5][2]"].readOnly = false;
	
		}
		
		return true;
	
	}
DAIKO;

	$java_sheet  .= <<<JS_DATA

	function Clear_Line_Data(clear_line) {
		if (confirm(clear_line+"行目の入力をクリアします。\\nよろしいですか？")==true) {
			document.forms[0].action="#";
			document.forms[0].clear_line.value=clear_line;
			document.forms[0].submit();
		}
	}

	//前受金相殺フラグ
	function ad_offset_radio_disable(line)
	{
		if(line == undefined){
			var min = 1;
			var max = 5;
		}else{
			var min = line;
			var max = line;
		}
	
	
		for(i=min; i<=max; i++){
	
			check = document.dateForm.elements["form_ad_offset_radio[" + i + "]"][0].checked;
	
			//なし
			if(check){
				document.dateForm.elements["form_ad_offset_amount[" + i + "]"].disabled = true;
				document.dateForm.elements["form_ad_offset_amount[" + i + "]"].style.backgroundColor = "gainsboro";
	
			//あり
			}else{
				document.dateForm.elements["form_ad_offset_amount[" + i + "]"].disabled = false;
				document.dateForm.elements["form_ad_offset_amount[" + i + "]"].style.backgroundColor = "white";
			}
		}
	
		return true;
	}

JS_DATA;
	return $java_sheet;

}



function Create_Js($type="daiko"){

	//代行伝票作成用JS
	$java_sheet_inc = <<<DAIKO_INC
		//営業原価をreadonlyとする
		function t_price_readonly(coax, f_obj, daiko_coax){
		
		    //発生する（％）の場合
		    if(f_obj == "3"){
		        var stat = true;
		    }else{
		        var stat = false;
		    }
		
		    //営業原価
		    for (var i = 1; i <= 5; i ++) {
		        price_i = "form_trade_price["+ i +"][1]";
		        price_d = "form_trade_price["+ i +"][2]";
		
		        document.forms[0].elements[price_i].readOnly = stat;
		        document.forms[0].elements[price_d].readOnly = stat;

                Mult_double_All(coax, false, daiko_coax, i);
		    }
		
/*
		    if(f_obj == "3"){
		        Mult_double4(
		            "form_goods_num1",
		            "form_sale_price",
		            "form_sale_amount",
		            "form_trade_price",
		            "form_trade_amount",
		            "form_issiki",
		            coax,
		            daiko_coax
		        );
		    }
*/
		}
		
		
		//営業金額と売上金額を計算する
		function Mult_double_All(coax, place, daiko_coax, line){
		
		    //act_id=document.forms[0].hdn_daiko_id.value;
		    num=document.forms[0].daiko_check.length;
		
		    //代行区分のvalue値取得
		    for (i=0;i<num;i++) {
		        flag=document.forms[0].daiko_check[i].checked;
		        if (flag){
		            r_value=document.forms[0].daiko_check[i].value;
		        }
		    }
		
		
		    //代行委託料区分のvalue値取得
		    num = document.forms[0].elements["act_div[]"].length;
		    for (i=0;i<num;i++) {
		        flag = document.forms[0].elements["act_div[]"][i].checked;
		        if (flag){
		            act_div = document.forms[0].elements["act_div[]"][i].value;
		        }
		    }
		
		
		    if(line == undefined){
		        var min = 1;
		        var max = 5;
		    }else{
		        var min = line;
		        var max = line;
		    }
		
		
            //代行のとき
		    if(r_value != "1"){
    		    for (var i = min; i <= max; i ++) {
    		        //売上（％）のとき、原価を売上の％にして代行先の丸めで丸める
        		    if(act_div == "3"){
	    	            Mult_double3(
		                    "form_goods_num1["+ i +"]",
		                    "form_sale_price["+ i +"][1]",
		                    "form_sale_price["+ i +"][2]",
		                    "form_sale_amount["+ i +"]",
		                    "form_trade_price["+ i +"][1]",
    		                "form_trade_price["+ i +"][2]",
	    	                "form_trade_amount["+ i +"]",
		                    "form_issiki["+ i +"]",
		                    coax,
		                    place,
		                    i,
    		                false,
	    	                daiko_coax
		                );

		            //売上（％）じゃないとき、入力された単価で丸める
                    }else{
                        //原価
                        Mult2(
		                    "form_goods_num1["+ i +"]",
		                    "form_trade_price["+ i +"][1]",
    		                "form_trade_price["+ i +"][2]",
	    	                "form_trade_amount["+ i +"]",
		                    "form_issiki["+ i +"]",
	    	                daiko_coax,
		                    place
		                );

                        //売上
                        Mult2(
		                    "form_goods_num1["+ i +"]",
		                    "form_sale_price["+ i +"][1]",
    		                "form_sale_price["+ i +"][2]",
	    	                "form_sale_amount["+ i +"]",
		                    "form_issiki["+ i +"]",
	    	                coax,
		                    place,
                            "sale"
		                );
                    }
		        }
		
            //自社巡回の場合
		    }else{
                //得意先の丸めで丸める
		        for (var i = min; i <= max; i ++){
		            Mult_double2(
		                "form_goods_num1["+ i +"]",
		                "form_sale_price["+ i +"][1]",
		                "form_sale_price["+ i +"][2]",
		                "form_sale_amount["+ i +"]",
		                "form_trade_price["+ i +"][1]",
		                "form_trade_price["+ i +"][2]",
		                "form_trade_amount["+ i +"]",
		                "form_issiki["+ i +"]",
		                coax,
		                place
		            );
		        }
		    }
		}
		
		
		//代行料区分が売上（％）なら原価を計算
		function Act_Request_Rate(coax, place, daiko_coax, line){
		
		    Mult_double_All(coax, place, daiko_coax, line);

		}
DAIKO_INC;

	return $java_sheet_inc;
}

?>
