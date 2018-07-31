<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);
//*******************入力箇所*********************

//余白
$left_margin = 60;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 8;
//ページサイズ
$page_size = 495;

//A4
$pdf=new MBFPDF('P','pt','A4');

//タイトル
$title = "仕入先元帳";
$page_count = "1"; 

//項目名・幅・align
$list[0] = array("45","日付","C");
$list[1] = array("50","伝票番号","C");
$list[2] = array("50","取引区分","C");
$list[3] = array("100","商品名","C");
$list[4] = array("50","数量","C");
$list[5] = array("50","単価","C");
$list[6] = array("50","金額","C");
$list[7] = array("50","支払金額","C");
$list[8] = array("50","買掛残高","C");

//月計・請求先計名
$list_sub[0] = array("100","月計","R");
$list_sub[1] = array("100","月税","R");
$list_sub[2] = array("100","仕入先計","R");

//align(データ)
$data_align[0] = "C";
$data_align[1] = "L";
$data_align[2] = "C";
$data_align[3] = "L";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "R";

//データ取得SQL(日付・伝票番号・取引区分・商品名・数量・単価・金額・支払金額)
$sql = "select date,slip,invent,goods,num1,num2,num3,num4 from t_client;";

//仕入先名・仕入先コード取得SQL
$sql_client = "SELECT DISTINCT client_name,client_code FROM t_client;";

//ページ最大表示数
$page_max = 50;

//***********************************************

$code = "仕入先コード：";
$name = "仕入先名：";

//DB接続
$db_con = Db_Connect("amenity_test");
$result = Db_Query($db_con,$sql_client);

// 権限チェック
$auth       = Auth_Check($db_con);

//仕入先名取得
$name .= pg_fetch_result($result,0,0);
//仕入先コード取得
$code .= pg_fetch_result($result,0,1);

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//仮の時刻
$time = "取引期間：2005年04月01日〜2005年04月31日";

$date = date("印刷時刻　Y年m月d日　H：i");

//バインダー用の穴表示
$pdf->SetFont(GOTHIC, '', 20);
$pdf->SetXY(23,301);
$pdf->Cell('30', 14, '○', '', '0', 'C');
$pdf->SetXY(23,525);
$pdf->Cell('30', 14, '○', '', '0', 'C');

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・月計・月税・仕入先計・比較値、初期化
$count = 0;
$page_next = $page_max;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$date_day = "";
$date_day2 = "";

$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//バインダー用の穴表示
		$pdf->SetFont(GOTHIC, '', 20);
		$pdf->SetXY(23,301);
		$pdf->Cell('30', 14, '○', '', '0', 'C');
		$pdf->SetXY(23,525);
		$pdf->Cell('30', 14, '○', '', '0', 'C');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************日付省略判定***********************************

	//日が変わった場合、日付表示
	if($date_day2 != $data_list[0]){
		//一行目は、値をセットするだけ
		if($count != 1){
			//値の省略判定フラグ
			$space_flg = true;
		}
		$date_day2 = $data_list[0];
	}

//******************月計・月税処理***********************************

	//年月が変わった場合、月計表示
	if($date_day != substr($data_list[0],0,7)){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//値の省略判定フラグ
			$space_flg = true;

			//何月かを取得し、月計と一緒に表示
			$month = substr($date_day,5,2);
			//一桁の場合には、0を取る
			if($month <= 9){
				$month = substr($month,1,1);
			}

			for($x=0;$x<8;$x++){
				//月計行番号
				if($x==3){
					$pdf->Cell($list_sub[0][0], 14, $month.$list_sub[0][1], '1', '0',$list_sub[0][2],'1');
				//月計値
				}else{
					//数値判定
					if(is_numeric($data_sub[$x])){
						//月計値を請求先計値に足していく
						$data_total[$x] = $data_total[$x] + $data_sub[$x];
						$data_sub[$x] = number_format($data_sub[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
				}
			}
			//月計値を請求先計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
			//月計、初期化
			$data_sub = array();
			$count++;

			/****************************************************************/

			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(180,180,180);
			/****************************************************************/

			//月税
			for($x=0;$x<8;$x++){
				//月税行番号
				if($x==3){
					$pdf->Cell($list_sub[1][0], 14, $month.$list_sub[1][1], '1', '0',$list_sub[1][2],'1');
				//月税の入金金額は０を表示させない
				}else if($x==7){
					$pdf->Cell($list[$x][0], 14, '', '1', '0','R','1');
				//月税値
				}else{
					//数値判定
					if(is_numeric($data_sub2[$x])){
						//月税値を請求先計値に足していく
						$data_total[$x] = $data_total[$x] + $data_sub2[$x];
						$data_sub2[$x] = number_format($data_sub2[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			//月税には売掛残高はない
			$pdf->Cell($list[$x][0], 14, '', '1', '2','R','1');
			//月税、初期化
			$data_sub2 = array();
			$count++;
		}
		//年月を取得し、次の年月と比較
		$date_day = substr($data_list[0],0,7);
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//バインダー用の穴表示
		$pdf->SetFont(GOTHIC, '', 20);
		$pdf->SetXY(23,301);
		$pdf->Cell('30', 14, '○', '', '0', 'C');
		$pdf->SetXY(23,525);
		$pdf->Cell('30', 14, '○', '', '0', 'C');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

//************************データ表示***************************

	for($x=0;$x<8;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		if($x==0 && $count == 1 || $space_flg == true){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$x];
			//形式変更(例、05-03-10)
			$year = substr($contents,2,2);
			$month = substr($contents,5,2);
			$day = substr($contents,8,2);
			$contents = $year."-".$month."-".$day;
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//日付を省略する
			$space_flg = false;
		//既に月計名を表示させたか
		}else if($x==0){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//金額か支払金額表示
		}else if($x==6 || $x==7){
			//月税と月計の計算を分ける
			if($data_list[3] == "消費税"){
				//値を月税に足していく
				$data_sub2[$x] = $data_sub2[$x] + $data_list[$x];
			}else{
				//値を月計に足していく
				$data_sub[$x] = $data_sub[$x] + $data_list[$x];
			}
			$data_result = number_format($data_list[$x]);
			$contents = $data_result;
			$line = '1';
		//現金・振込支払の場合は、伝票番号を非表示
		}else if($x==1 && ($data_list[2] == "41" || $data_list[2] == "42")){
			$contents = '';
			$line = '1';
		}else{
			if(is_numeric($data_list[$x]) && $x!=1){
				$data_list[$x] = number_format($data_list[$x]);
			}
			$contents = $data_list[$x];
			$line = '1';
		}
		//消費税は右寄せ
		if($contents == "消費税"){
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', 'R');
		//買掛残高以外は０を表示しない
		}else if($contents == '0'){
			$pdf->Cell($list[$x][0], 14, '', $line, '0', $data_align[$x]);
		}else{
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
	}
	//取引区分が支払の場合、伝票ごとの支払計算を行う
	if($data_list[2] == "41" || $data_list[2] == "42"){
		//買掛残高−支払金額
		$data_sub[$x] = $data_sub[$x] - $data_list[7];
	}else{
		//買掛残高(商品ごとの金額をプラスしていく)
		$data_sub[$x] = $data_sub[$x] + $data_list[6];
	}
	$data_result = number_format($data_sub[$x]);
	$pdf->Cell($list[$x][0], 14, $data_result, '1', '2', $data_align[$x]);
}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//バインダー用の穴表示
		$pdf->SetFont(GOTHIC, '', 20);
		$pdf->SetXY(23,301);
		$pdf->Cell('30', 14, '○', '', '0', 'C');
		$pdf->SetXY(23,525);
		$pdf->Cell('30', 14, '○', '', '0', 'C');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************最終月計処理***********************************
	
//何月かを取得し、月計と一緒に表示
$month = substr($date_day,5,2);
//一桁の場合には、0を取る
if($month <= 9){
	$month = substr($month,1,1);
}

for($x=0;$x<8;$x++){
	//月計行番号
	if($x==3){
		$pdf->Cell($list_sub[0][0], 14, $month.$list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	//月計値
	}else{
		//数値判定
		if(is_numeric($data_sub[$x])){
			//月計値を請求先計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub[$x];
			$data_sub[$x] = number_format($data_sub[$x]);
		}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
//月計値を請求先計値に足していく
$data_total[$x] = $data_total[$x] + $data_sub[$x];
$data_sub[$x] = number_format($data_sub[$x]);
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//月計、初期化
$data_sub = array();
$count++;

/****************************************************************/

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//バインダー用の穴表示
		$pdf->SetFont(GOTHIC, '', 20);
		$pdf->SetXY(23,301);
		$pdf->Cell('30', 14, '○', '', '0', 'C');
		$pdf->SetXY(23,525);
		$pdf->Cell('30', 14, '○', '', '0', 'C');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

/****************最終月税処理*****************************/

//月税
for($x=0;$x<8;$x++){
	//月税行番号
	if($x==3){
		$pdf->Cell($list_sub[1][0], 14, $month.$list_sub[1][1], '1', '0',$list_sub[1][2],'1');
	//月税の支払金額は０を表示させない
	}else if($x==7){
		$pdf->Cell($list[$x][0], 14, '', '1', '0','R','1');
	//月税値
	}else{
		//数値判定
		if(is_numeric($data_sub2[$x])){
			//月税値を仕入先計値に足していく
			$data_total[$x] = $data_total[$x] + $data_sub2[$x];
			$data_sub2[$x] = number_format($data_sub2[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
//月税には買掛残高はない
$pdf->Cell($list[$x][0], 14, '', '1', '2','R','1');
//月税、初期化
$data_sub2 = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		
		//バインダー用の穴表示
		$pdf->SetFont(GOTHIC, '', 20);
		$pdf->SetXY(23,301);
		$pdf->Cell('30', 14, '○', '', '0', 'C');
		$pdf->SetXY(23,525);
		$pdf->Cell('30', 14, '○', '', '0', 'C');

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$code,$date,$name,$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//*************************仕入先計処理*******************************

for($x=0;$x<8;$x++){
	//月計行番号
	if($x==3){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	//担当者計値
	}else{
		//仕入先計値
		//数値判定
		if(is_numeric($data_total[$x])){
			//形式変更
			$data_total[$x] = number_format($data_total[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
	}
}
//形式変更
$data_total[$x] = number_format($data_total[$x]);

$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');
//****************************************************************

$pdf->Output();

?>
