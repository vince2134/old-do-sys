<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);
//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "棚卸差異明細一覧表";
$page_count = "0"; 

//項目名・幅・align
$list[0] = array("40","NO","C");
$list[1] = array("140","Ｍ区分","C");
$list[2] = array("310","商品名","C");
$list[3] = array("100","帳簿数","C");
$list[4] = array("100","実棚数","C");
$list[5] = array("100","棚卸差異数","C");
$list[6] = array("120","棚卸実施者","C");
$list[7] = array("200","差異原因","C");

//倉庫計・Ｍ区分名
$list_sub[0] = array("140","倉庫計","L");
$list_sub[1] = array("140","総合計","L");
$list_sub[2] = array("140","Ｍ区分計","L");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "R";
$data_align[6] = "L";
$data_align[7] = "L";

//ページ最大表示数
$page_max = 50;

//日付・調査表番号、取得SQL
$sql_house = "SELECT DISTINCT warehouse,stock_date,invent_num FROM t_diff;";

//***********************************************

//DB接続
$db_con = Db_Connect("amenity_test");

$result_house = Db_Query($db_con,$sql_house);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//倉庫が存在する間出力
while($house_list = pg_fetch_array($result_house)){

	//データ取得SQL(Ｍ区分・商品名・帳簿数・実棚数・棚卸差異数・棚卸実施者・差異原因)
	$sql = "SELECT goods,goods_name,num1,num2,num3,";
	$sql .= "person,note ";
	$sql .= "FROM t_diff ";
	$sql .= "WHERE warehouse = '".$house_list[0]."';";

	//倉庫名取得
	$warehouse = "倉庫名: ".$house_list[0];

	//日付取得
	$house_date = $house_list[1];

	//調査表番号取得
	$invent_num = "調査表番号 : ".$house_list[2];

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//ＤＢの値を表示
	//行数・ページ数・次のページ表示数・倉庫計・Ｍ区分計・総合計・比較値、初期化
	$count = 0;
	$page_count++;
	$page_next = $page_max;
	$data_sub = array();
	$data_sub2 = array();
	$data_total = array();
	$goods = "";

	//データ出力
	$result = Db_Query($db_con,$sql);
	while($data_list = pg_fetch_array($result)){
		$count++;

		/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($count == 1){
			//現在の時刻取得
			$date = date("印刷時刻　Y年m月d日　H：i");
			//形式変更
			$year = substr($house_date,0,4);
			$month = substr($house_date,5,2);
			$day = substr($house_date,8,2);
			$house_date = "在庫棚卸予定 : ".$year."年".$month."月".$day."日";

			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);
		}

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();
			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//******************Ｍ区分計処理***********************************

		//値が変わった場合、Ｍ区分計表示
		if($goods != $data_list[0]){
			//一行目は、値をセットするだけ
			if($count != 1){
				$pdf->SetFillColor(220,220,220);
				//値の省略判定フラグ
				$space_flg2 = true;
				for($x=0;$x<7;$x++){
					//行番号
					if($x==0){
						$pdf->SetFont(GOTHIC, '', 9);
						$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
						$pdf->SetFont(GOTHIC, 'B', 9);
					//Ｍ区分計名
					}else if($x==1){
						$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
					}else{
					//Ｍ区分計値
						//数値判定
						if(is_numeric($data_sub2[$x])){
							//Ｍ区分計を計算
							$data_sub2[$x] = number_format($data_sub2[$x]);
						}
						$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
					}
				}
				//差異原因
				$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
				//Ｍ区分初期化
				$data_sub2 = array();
				$count++;
			}
			$goods = $data_list[0];
		}


		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();
			//ヘッダー表示
			Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

		//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

		//************************データ表示***************************
		//行番号
		$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
		for($x=1;$x<7;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			//一行目かＭ区分計の後以外は値の省略
			if($x==1 && ($count == 1 || $space_flg2 == true)){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x-1];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				//省略する
				$space_flg2 = false;
			//既に小計名を表示させたか
			}else if($x==1){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			}else{
				if(is_numeric($data_list[$x-1])){
					//値をＭ区分計に足していく
					$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
					//値を倉庫計に足していく
					$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
					$data_list[$x-1] = number_format($data_list[$x-1]);
				}
				$contents = $data_list[$x-1];
				$line = '1';
			}
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		//差異原因
		$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);
	}
	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(220,220,220);
	$count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************最終Ｍ区分計処理***********************************

	for($x=0;$x<7;$x++){				
		if($x==0){
			$pdf->SetFont(GOTHIC, '', 9);
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
			$pdf->SetFont(GOTHIC, 'B', 9);
		//Ｍ区分計名
		}else if($x==1){
			$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
		}else{
		//Ｍ区分計値
			//数値判定
			if(is_numeric($data_sub2[$x])){
				//Ｍ区分計を計算
				$data_sub2[$x] = number_format($data_sub2[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
	//Ｍ区分初期化
	$data_sub2 = array();

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(180,180,180);
	$count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************最終倉庫計処理***********************************
		
	for($x=0;$x<7;$x++){	
		if($x==0){
			$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
		//倉庫計名
		}else if($x==1){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		}else{
		//倉庫計値
			//数値判定
			if(is_numeric($data_sub[$x])){
				$data_sub[$x] = number_format($data_sub[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//倉庫初期化
	$data_sub = array();

	//*************************************************************
}

//*************************全倉庫計処理*******************************

//全倉庫計取得SQL
$sql = "SELECT goods,goods_name,sum(num1),sum(num2),";
$sql .= "sum(num3),person,note ";
$sql .= "FROM t_diff ";
$sql .= "GROUP BY goods,goods_name,person,note ";
$sql .= "ORDER BY goods ASC;";

$result = Db_Query($db_con,$sql);

//倉庫名取得
$warehouse = "倉庫名: 全倉庫計";

$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・倉庫計・Ｍ区分計・総合計・比較値、初期化
$count = 0;
$page_count++;
//改ページ計算用のページ数
$page_count2 = 1;
$page_next = $page_max;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$goods = "";

//データ出力
$result = Db_Query($db_con,$sql);
while($data_list = pg_fetch_array($result)){
	$count++;

	/**********************ヘッダー処理**************************/
	//一行目の場合、ヘッダ出力
	if($count == 1){

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);
	}

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$page_count2++;
		$pdf->AddPage();
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count2;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************Ｍ区分計処理***********************************

	//値が変わった場合、Ｍ区分計表示
	if($goods != $data_list[0]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//値の省略判定フラグ
			$space_flg2 = true;
			for($x=0;$x<7;$x++){
				//行番号
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 9);
					$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
					$pdf->SetFont(GOTHIC, 'B', 9);
				//Ｍ区分計名
				}else if($x==1){
					$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
				}else{
				//Ｍ区分計値
					//数値判定
					if(is_numeric($data_sub2[$x])){
						//Ｍ区分計を計算
						$data_sub2[$x] = number_format($data_sub2[$x]);
					}
					$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
				}
			}
			//差異原因
			$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
			//Ｍ区分初期化
			$data_sub2 = array();
			$count++;
		}
		$goods = $data_list[0];
	}


	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$page_count2++;
		$pdf->AddPage();
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count2;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<7;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		//一行目かＭ区分計の後以外は値の省略
		if($x==1 && ($count == 1 || $space_flg2 == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//省略する
			$space_flg2 = false;
		//既に小計名を表示させたか
		}else if($x==1){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		}else{
			if(is_numeric($data_list[$x-1])){
				//値をＭ区分計に足していく
				$data_sub2[$x] = $data_sub2[$x] + $data_list[$x-1];
				//値を倉庫計に足していく
				$data_sub[$x] = $data_sub[$x] + $data_list[$x-1];
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
		}
		$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
	}
	//差異原因
	$pdf->Cell($list[$x][0], 14, $data_list[$x-1], '1', '2', $data_align[$x]);
}
//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(220,220,220);
$count++;

//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$page_count++;
	$page_count2++;
	$pdf->AddPage();
	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count2;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終Ｍ区分計処理***********************************

for($x=0;$x<7;$x++){				
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x]);
		$pdf->SetFont(GOTHIC, 'B', 9);
	//Ｍ区分計名
	}else if($x==1){
		$pdf->Cell($list_sub[2][0], 14, $list_sub[2][1], '1', '0',$list_sub[2][2],'1');
	}else{
	//Ｍ区分計値
		//数値判定
		if(is_numeric($data_sub2[$x])){
			//Ｍ区分計を計算
			$data_sub2[$x] = number_format($data_sub2[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub2[$x], '1', '2','R','1');
//Ｍ区分初期化
$data_sub2 = array();

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************改ページ処理*****************************

//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$page_count++;
	$page_count2++;
	$pdf->AddPage();
	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,$warehouse,$date,$invent_num,$house_date,$page_count,$list,$font_size,$page_size);

	//次の最大表示数
	$page_next = $page_max * $page_count2;
	$space_flg = true;
}

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 9);

//******************最終倉庫計処理***********************************
	
for($x=0;$x<7;$x++){	
	if($x==0){
		$pdf->Cell($list[$x][0], 14, "$count", '1', '0',$data_align[$x],'1');
	//倉庫計名
	}else if($x==1){
		$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
	}else{
	//倉庫計値
		//数値判定
		if(is_numeric($data_sub[$x])){
			$data_sub[$x] = number_format($data_sub[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
	}
}
$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
//倉庫初期化
$data_sub = array();

//*************************************************************

$pdf->Output();

?>
