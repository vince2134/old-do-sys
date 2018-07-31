<?php

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

//ヘッダー表示関数
//引数（PDFオブジェクト・マージン・タイトル・左上/右上/左下/右下のヘッダ項目・ページ数・項目名）
function Header_rental($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list){

	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell(762, 14, $title, '0', '1', 'C');
	$pdf->SetFont(GOTHIC, 'B', 14);
	$pdf->SetXY($left_margin,$top_margin+15);
	$pdf->Cell(762, 25, $left_top."　御中", '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+15);
	$pdf->Cell(762, 25, $right_top, '0', '1', 'R');
	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetXY($left_margin,$top_margin+40);
	$pdf->Cell(762, 16, $left_bottom, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+40);
	$pdf->Cell(762, 16, $page_count."ページ", '0', '1', 'R');
	$pdf->SetFont(GOTHIC, 'B', 9);

	//項目表示
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	for($i=0;$i<count($list)-1;$i++)
	{
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
	}
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}

//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ページサイズ
//A4
$pdf=new MBFPDF('L','pt','a4');

//タイトル
$title = "レンタル料一覧";
$page_count = "1"; 
$right = "株式会社　アメニティ";

//日付（仮）
$date = "2005年11月分";

//項目名・幅・align
$list[0] = array("145","レンタル先","C");
$list[1] = array("282","商品名","C");
$list[2] = array("65","レンタル料","C");
$list[3] = array("55","レンタル数","C");
$list[4] = array("65","レンタル額","C");
$list[5] = array("150","備考","C");

//小計・合計名
$list_sub[0] = array("145","小計","L");
$list_sub[1] = array("145","合計","L");

//align(データ)
$data_align[0] = "L";
$data_align[1] = "L";
$data_align[2] = "R";
$data_align[3] = "R";
$data_align[4] = "R";
$data_align[5] = "L";

//ショップ取得SQL
$sql_shop = "SELECT DISTINCT shop_id FROM t_rental;";

//ページ最大表示数
$page_max = 32;

//***********************************************

//DB接続
$db_con = Db_Connect("amenity");

$result_shop = Db_Query($db_con,$sql_shop);

$pdf->AddMBFont(GOTHIC ,'SJIS');

//ショップが存在する間出力
while($shop_list = pg_fetch_array($result_shop)){

	//データ取得SQL

	//レンタル料取得SQL(レンタル先・商品名・レンタル料・レンタル数・レンタル額・備考・レンタルID)
	$sql = "SELECT rental_client,t_goods.goods_name,rental_price,";
	$sql .= "rental_num,rental_amount,note,t_shop.shop_name ";
	$sql .= "FROM t_goods,t_rental,t_shop ";
	$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
	$sql .= "AND t_shop.shop_id = t_rental.shop_id ";
	$sql .= "AND t_rental.shop_id = ".$shop_list[0];
	$sql .= " ORDER BY rental_client ASC;";

	$result = Db_Query($db_con,$sql);

	$pdf->SetFont(GOTHIC, 'B', 12);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//ＤＢの値を表示
	//行数・ページ数・次のページ表示数・小計・合計・比較値、初期化
	$count = 0;
	$page_count = 1;
	$page_next = $page_max;
	$data_sub = array();
	$data_total = array();
	$goods = "";

	while($data_list = pg_fetch_array($result)){
		$count++;
	/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($count == 1){
			//ショップ名取得
			$shop = $data_list[6];
			//ヘッダー表示
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);
		}
	/************************************************************/


	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $count){
			$page_count++;
			$pdf->AddPage();

			//ヘッダー表示
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, 'B', 9);

	//******************小計処理***********************************

		//値が変わった場合、小計表示
		if($goods != $data_list[0]){
			//一行目は、値をセットするだけ
			if($count != 1){
				$pdf->SetFillColor(213,213,213);
				//値の省略判定フラグ
				$space_flg = true;
				for($x=0;$x<5;$x++){
					//小計名
					if($x==0){
						$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
					}else{
					//小計値
						//数値判定
						if(is_numeric($data_sub[$x])){
							//小計値を合計値に足していく
							$data_total[$x] = $data_total[$x] + $data_sub[$x];
							$data_sub[$x] = number_format($data_sub[$x]);
						}
						$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
					}
				}
				$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
				//小計初期化
				$data_sub = array();
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
			Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

			//次の最大表示数
			$page_next = $page_max * $page_count;
			$space_flg = true;
		}

	//*************************************************************

		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFont(GOTHIC, '', 9);

	//************************データ表示***************************

		for($x=0;$x<5;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			if($x==0 && $count == 1 || $space_flg == true){
				//セル結合判定
				//ページの最大表示数か
				$contents = $data_list[$x];
				if($page_next == $count){
					$line = 'LRBT';
				}else{
					$line = 'LRT';
				}
				$space_flg = false;
			}else if($x==0){
				$contents = '';
				if($page_next == $count){
					$line = 'LBR';
				}else{
					$line = 'LR';
				}
			}else{
				if(is_numeric($data_list[$x])){
					//値を小計に足していく
					$data_sub[$x] = $data_sub[$x] + $data_list[$x];
					$data_list[$x] = number_format($data_list[$x]);
				}
				$contents = $data_list[$x];
				$line = '1';
			}
			$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
		}
		$pdf->Cell($list[$x][0], 14, $data_list[$x], '1', '2', $data_align[$x]);
	}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();

		//ヘッダー表示
		Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//******************最終小計処理***********************************
		
	for($x=0;$x<5;$x++){
		//小計名
		if($x==0){
			$pdf->Cell($list_sub[0][0], 14, $list_sub[0][1], '1', '0',$list_sub[0][2],'1');
		}else{
		//小計値
			//数値判定
			if(is_numeric($data_sub[$x])){
				//小計値を合計値に足していく
				$data_total[$x] = $data_total[$x] + $data_sub[$x];
				$data_sub[$x] = number_format($data_sub[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_sub[$x], '1', '2','R','1');
	//小計初期化
	$data_sub = array();

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(145,145,145);
	$count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$page_count++;
		$pdf->AddPage();

		//ヘッダー表示
		Header_rental($pdf,$left_margin,$top_margin,$title,$shop,$right,$date,"",$page_count,$list);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

	//*************************合計処理*******************************

	for($x=0;$x<5;$x++){
		//合計名
		if($x==0){
			$pdf->Cell($list_sub[1][0], 14, $list_sub[1][1], '1', '0',$list_sub[1][2],'1');
		}else{
		//合計値
			if(is_numeric($data_total[$x])){
				$data_total[$x] = number_format($data_total[$x]);
			}
			$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '0','R','1');
		}
	}
	$pdf->Cell($list[$x][0], 14, $data_total[$x], '1', '2','R','1');

	//****************************************************************

}

$pdf->Output();

?>
