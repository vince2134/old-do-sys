<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

//ヘッダー表示関数
//引数（PDFオブジェクト・マージン・タイトル・右上/右下のヘッダ項目・ページ数）
function Header_route($pdf,$left_margin,$top_margin,$title,$right_top,$right_bottom,$page_count){

	$pdf->SetFont(GOTHIC, '', 8);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(1110, 14, $title, '0', '1', 'C');
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(1110, 14, $page_count."ページ", '0', '1', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell(1110, 14, $right_top, '0', '1', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell(1110, 14, $right_bottom."　現在", '0', '2', 'R');

}


//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ページサイズ
//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "担当者別ルート予定表";
$page_count = "1"; 

//項目名・幅・align
$list[0] = array("50","2005年11月","C");
$list[1] = array("345","","C");
$list[2] = array("85","コース名","C");
$list[3] = array("70","コメント","C");
$list[4] = array("70","予定値","C");
$list[5] = array("70","実績値","C");
$list[6] = array("50","差額","C");
$list[7] = array("20","件数","C");
$list[8] = array("50","売上額","C");
$list[9] = array("20","件数","C");
$list[10] = array("50","売上額","C");

//合計名
$list_sub[0] = array("50","合計","L");

//align・幅(データ)
$data_align[0] = array("50","R");
$data_align[1] = array("85","L");
$data_align[2] = array("70","L");
$data_align[3] = array("20","R");
$data_align[4] = array("50","R");
$data_align[5] = array("20","R");
$data_align[6] = array("50","R");
$data_align[7] = array("50","R");

//現在の日付取得SQL
$sql_stock = "SELECT DISTINCT stock_date FROM t_person;";

//担当者取得
$sql_person = "SELECT DISTINCT person FROM t_person;";

//DB接続
$db_con = Db_Connect("amenity_test");

//日付取得
$result = Db_Query($db_con,$sql_stock);
$time = pg_fetch_result($result,0,0);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("印刷時刻　Y年m月d日　H：i");
//日付取得・形式変更
$year = substr($time,0,4);
$month = substr($time,5,2);
$time = $year."年".$month."月";

//****************日付計算処理************************

$wstr = array('日', '月', '火', '水', '木', '金', '土');
//年月指定
$now = mktime(0, 0, 0, $month, 1, $year);
//月の日数
$dnum = date("t", $now);
//月の日数分
for ($i = 1; $i <= $dnum; $i++) {
	$x = $i - 1;
    $t = mktime(0, 0, 0, $month, $i, $year);
    $w = date("w", $t);

	//月の曜日取得
    $day_count[$x] = $i."日"."(".$wstr[$w].")";
	//土日判定用変数
	$holiday[$x] = $wstr[$w];
}

//****************************************************

//ヘッダー表示
Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

//担当者取得
$result_person = Db_Query($db_con,$sql_person);

//担当者人数・小計・合計、初期化
$person_count = 0;
$data_sub = array();
$data_total = array();

//担当者が存在する間出力
while($person_list = pg_fetch_array($result_person)){
	
	//*******************改ページ処理*****************************

	//担当者を一ページに３人表示したら、改ページする
	if($person_count == 3){
		
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

		//担当者人数を初期化
		$person_count = 0;
	}

	//*************************************************************


	/**********************項目処理**************************/
	
	//項目表示位置
	switch($person_count){
		//一人目
	    case 0:
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin, $posY);
				$X = $left_margin+205;
				$Y = $top_margin+72;
				//二人目以降は、日付は無し
				$num = 0;
	      		break;
		//二人目
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+42);
				$X = $left_margin+562.5;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
		//三人目
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+42);
				$X = $left_margin+920;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
	    default:
  	}

	//項目表示
	for($i=$num;$i<count($list);$i++){
		if($i == 0){
			$pdf->Cell($list[$i][0], 45, $time, '1', '0', $list[$i][2]);
		}
		if($i == 1){
			$pdf->Cell($list[$i][0], 15, $person_list[0], '1', '2', $list[$i][2]);
		}
		if($i == 2 || $i == 3 || $i == 6){
			$pdf->Cell($list[$i][0], 30, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 4 || $i == 5){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 7){
			$pdf->SetXY($X,$Y);
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 8 || $i == 9 || $i == 10){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}	
	}

	//*************************************************************	

	//データ取得SQL(No,担当者,コース名,コメント,差額,件数,売上額,件数,売上額)
	$sql = "SELECT stock_date,course,talk,num1,num2,num3,num4,num5 FROM t_person WHERE person = '".$person_list[0]."';";
	$result = Db_Query($db_con,$sql);
	
	//************************データ表示***************************

	//曜日の添え字番号
	$day_num = 0;
	//値存在フラグ
	$day_flg = false;

	//項目表示位置
	switch($person_count){
	    case 0:
				$pdf->SetXY($left_margin,$top_margin+87);
				$X2 = $left_margin;
				//二人目以降は、日付データは表示しない
				$num2 = 0;
	      		break;
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+87);
				$X2 = $left_margin+407.5;
				$num2 = 1;
	      		break;
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+87);
				$X2 = $left_margin+765;
				$num2 = 1;
	      		break;
	    default:
  	}

	//担当者出力
	for($d=1;$d<=count($day_count);$d++){
		//値が存在する場合だけ読み込む
		if($day_flg == false){
			$data_list = pg_fetch_array($result);
		}
		$posY = $pdf->GetY();
		$pdf->SetXY($X2, $posY);

		//土日だけ色変更
		if($holiday[$day_num] == "日"){
			$pdf->SetFillColor(255,224,224);
		}else if($holiday[$day_num] == "土"){
			$pdf->SetFillColor(204,234,255);
		}else{
			$pdf->SetFillColor(255,255,255);
		}

		//日付比較変数
		if($d <= 9){
			$day_check = $year."-".$month."-0".$d;
		}else{
			$day_check = $year."-".$month."-".$d;
		}
		//予定が存在するか
		if($data_list[0] != $day_check){
			//空白のセル
			$pdf->Cell($data_align[0][0], 14, $day_count[$day_num], '1', '0', $data_align[0][1],'1');
			for($j=1;$j<7;$j++){
				$pdf->Cell($data_align[$j][0], 14, '', '1', '0', $data_align[$j][1],'1');
			}
			$pdf->Cell($data_align[$j][0], 14, '', '1', '2', $data_align[$j][1],'1');
			//次の行に、今読み込んだ行を出力
			$day_flg = true;
		}else{
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[$j][0], 14, $day_count[$day_num], '1', '0', $data_align[$j][1],'1');				}else{
					//数値判定
					if(is_numeric($data_list[$j])){
						//小計値に足していく
						$data_sub[$j] = $data_sub[$j] + $data_list[$j];
						$data_list[$j] = number_format($data_list[$j]);
					}
					$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '0', $data_align[$j][1],'1');
				}
			}
			$data_sub[$j] = $data_sub[$j] + $data_list[$j];
			$data_list[$j] = number_format($data_list[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '2', $data_align[$j][1],'1');
			//値をまた読み込むようにする
			$day_flg = false;
		}
		$day_num++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($X2, $posY);
	$pdf->SetFillColor(213,213,213);

	//**************************小計表示***************************

	for($j=$num2;$j<7;$j++){
		//合計名
		if($j==0){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		}else{
			//数値判定
			if(is_numeric($data_sub[$j])){
				//小計値を合計値に足していく
				$data_total[$j] = $data_total[$j] + $data_sub[$j];
				$data_sub[$j] = number_format($data_sub[$j]);
			}
			$pdf->Cell($data_align[$j][0], 14, $data_sub[$j], '1', '0', $data_align[$j][1],'1');
		}
	}
	$data_total[$j] = $data_total[$j] + $data_sub[$j];
	$data_sub[$j] = number_format($data_sub[$j]);
	$pdf->Cell($data_align[$j][0], 14, $data_sub[$j], '1', '2', $data_align[$j][1],'1');

	//小計、初期化
	$data_sub = array();

	//*************************************************************

	//担当者人数を足す
	$person_count++;
}

//**************************合計処理***************************

//項目名・幅・align
$list[1] = array("210","合計","C");
$list[4] = array("80","予定値","C");
$list[5] = array("80","実績値","C");
$list[6] = array("50","差額","C");
$list[7] = array("30","件数","C");
$list[8] = array("50","売上額","C");
$list[9] = array("30","件数","C");
$list[10] = array("50","売上額","C");

//align・幅(データ)
$data_align[2] = array("80","L");
$data_align[3] = array("30","R");
$data_align[4] = array("50","R");
$data_align[5] = array("30","R");
$data_align[6] = array("50","R");
$data_align[7] = array("50","R");

	//*******************改ページ処理*****************************

	//担当者を一ページに３人表示したら、改ページする
	if($person_count == 3){
		
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_route($pdf,$left_margin,$top_margin,$title,$date,$time,$page_count);

		//担当者人数を初期化
		$person_count = 0;
	}

	//*************************************************************


	/**********************項目処理**************************/
	
	//項目表示位置
	switch($person_count){
		//一人目
	    case 0:
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin, $posY);
				$X = $left_margin+205;
				$Y = $top_margin+72;
				$num = 0;
	      		break;
		//二人目
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+42);
				$X = $left_margin+407.5;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
		//三人目
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+42);
				$X = $left_margin+920;
				$Y = $top_margin+72;
				$num = 1;
	      		break;
	    default:
  	}

	//項目表示
	for($i=$num;$i<count($list);$i++){
		if($i == 0){
			$pdf->Cell($list[$i][0], 45, $time, '1', '0', $list[$i][2]);
		}
		if($i == 1){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '2', $list[$i][2]);
		}
		if($i == 6){
			$pdf->Cell($list[$i][0], 30, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 4 || $i == 5){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 7){
			$pdf->SetXY($X,$Y);
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}
		if($i == 8 || $i == 9 || $i == 10){
			$pdf->Cell($list[$i][0], 15, $list[$i][1], '1', '0', $list[$i][2]);
		}	
	}

	//*************************************************************	


	//************************データ表示***************************

	//曜日の添え字番号
	$day_num = 0;
	//値存在フラグ
	$day_flg = false;

	//項目表示位置
	switch($person_count){
	    case 0:
				$pdf->SetXY($left_margin,$top_margin+87);
				$X2 = $left_margin;
				$num2 = 0;
	      		break;
	    case 1:
				$pdf->SetXY($left_margin+407.5,$top_margin+87);
				$X2 = $left_margin+407.5;
				$num2 = 3;
	      		break;
		case 2:
				$pdf->SetXY($left_margin+765,$top_margin+87);
				$X2 = $left_margin+765;
				$num2 = 3;
	      		break;
	    default:
  	}

	//担当者出力
	for($d=1;$d<=count($day_count);$d++){
		//値が存在する場合だけ読み込む
		if($day_flg == false){
			$data_list = pg_fetch_array($result);
		}
		$posY = $pdf->GetY();
		$pdf->SetXY($X2, $posY);

		//土日だけ色変更
		if($holiday[$day_num] == "日"){
			$pdf->SetFillColor(255,224,224);
		}else if($holiday[$day_num] == "土"){
			$pdf->SetFillColor(204,234,255);
		}else{
			$pdf->SetFillColor(255,255,255);
		}

		//日付比較変数
		if($d <= 9){
			$day_check = $year."-".$month."-0".$d;
		}else{
			$day_check = $year."-".$month."-".$d;
		}
		//予定が存在するか
		if($data_list[0] != $day_check){
			//空白のセル
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[0][0], 14, $day_count[$day_num], '1', '0', $data_align[0][1],'1');			//コース名・コメントは表示しない
				}else if($j==3 || $j==4 || $j==5 || $j==6){
					$pdf->Cell($data_align[$j][0], 14, '', '1', '0', $data_align[$j][1],'1');
				}
			}
			$pdf->Cell($data_align[$j][0], 14, '', '1', '2', $data_align[$j][1],'1');
			//次の行に、今読み込んだ行を出力
			$day_flg = true;
		}else{
			for($j=$num2;$j<7;$j++){
				if($j==0){
					$pdf->Cell($data_align[$j][0], 14, $day_count[$day_num], '1', '0', $data_align[$j][1],'1');				}else if($j==3 || $j==4 || $j==5 || $j==6){
					//数値判定
					if(is_numeric($data_list[$j])){
						//小計値に足していく
						$data_sub[$j] = $data_sub[$j] + $data_list[$j];
						$data_list[$j] = number_format($data_list[$j]);
					}
					$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '0', $data_align[$j][1],'1');
				}
			}
			$data_sub[$j] = $data_sub[$j] + $data_list[$j];
			$data_list[$j] = number_format($data_list[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_list[$j], '1', '2', $data_align[$j][1],'1');
			//値をまた読み込むようにする
			$day_flg = false;
		}
		$day_num++;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($X2, $posY);
	$pdf->SetFillColor(213,213,213);

	//**************************合計表示***************************

	for($j=$num2;$j<7;$j++){
		//合計名
		if($j==0){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
			//コース名・コメントは表示しない
		}else if($j==3 || $j==4 || $j==5 || $j==6){
			$data_total[$j] = number_format($data_total[$j]);
			$pdf->Cell($data_align[$j][0], 14, $data_total[$j], '1', '0', $data_align[$j][1],'1');
		}
	}
	$data_total[$j] = number_format($data_total[$j]);
	$pdf->Cell($data_align[$j][0], 14, $data_total[$j], '1', '2', $data_align[$j][1],'1');

//*************************************************************

$pdf->Output();

?>
