<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2007/02/06　      　　　　watanabe-k　発注先　⇒　発注元
 */

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);
//*******************入力箇所*********************

//余白
$left_margin = 20;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 555;

//A4
$pdf=new MBFPDF('P','pt','A4');

//タイトル
$title = "受注納期一覧表";
$page_count = "1";

//項目名・幅・align
//$list[0] = array("30","No","C");
$list[0] = array("20","No","C");
//$list[1] = array("50","発注日時","C");
$list[1] = array("70","発注日時","C");
$list[2] = array("50","希望納期","C");
//$list[3] = array("125","発注先","C");
$list[3] = array("125","ショップ名","C");
$list[4] = array("250","商品","C");
//$list[5] = array("50","数量","C");
$list[5] = array("40","数量","C");


//align(データ)
$data_align[0] = "R";
$data_align[1] = "C";
$data_align[2] = "C";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "R";


//データ取得SQL
$sql  = " SELECT ";
$sql .= "    t_order_h.ord_id,";
$sql .= "    to_char(t_order_h.ord_time, 'yyyy-mm-dd hh24:mi'),";
$sql .= "    t_order_h.hope_day,";
//$sql .= "    t_client.client_name,";
//$sql .= "    t_order_h.client_cname,";
$sql .= "    t_order_h.my_client_cname, ";
$sql .= "    t_order_d.goods_name,";
$sql .= "    t_order_d.num";
$sql .= " FROM ";
$sql .= "    t_order_d,";
$sql .= "    t_order_h";
$sql .= "    INNER JOIN ";
$sql .= "    (SELECT ";
$sql .= "    client_id,";
$sql .= "    client_cname";
$sql .= "    FROM";
$sql .= "    t_client";
$sql .= "    ) AS t_client";
$sql .= "    ON t_order_h.shop_id = t_client.client_id";
$sql .= " WHERE";
$sql .= "    t_order_h.ord_stat = 1";
$sql .= "    AND";
$sql .= "    t_order_h.ord_id = t_order_d.ord_id";
$sql .= " ORDER BY t_order_h.ord_time;";

//ページ最大表示数
$page_max = 50;

//***********************************************

//DB接続
$db_con = Db_Connect();

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,"","","","",$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・ページ数・次のページ表示数・比較値を初期化
$count = 0;
$page_next = $page_max;
$goods = "";
$ord_id = "";

$result = Db_Query($db_con,$sql);

while($data_list = pg_fetch_array($result)){
	$count++;

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"","","","",$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
	}

	//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

	//******************省略判定処理***********************************

	//値が変わった場合、日付表示
	if($ord_id != $data_list[0]){
		$space_flg = true;
		$ord_id = $data_list[0];
	}

	//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<6;$x++){
		//表示値
		$contents = "";
		//表示line		
		$line = "";

		//一行目か小計の後の場合は、省略しない。
		if($x==1){
			if($space_flg == true){
				$contents = $data_list[$x];
				$pdf->Cell($list[$x][0], 14, $contents, '1', '0', $data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, "", '1', '0', $data_align[$x]);
			}
		}else if($x==2){
			if($space_flg == true){
				$contents = $data_list[$x];
				$pdf->Cell($list[$x][0], 14, $contents, '1', '0', $data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, "", '1', '0', $data_align[$x]);
			}
		}else if($x==3){
			if($space_flg == true){
				$contents = $data_list[$x];
				$pdf->Cell($list[$x][0], 14, $contents, '1', '0', $data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, "", '1', '0', $data_align[$x]);
			}
		}else if($x==4){
			$contents = $data_list[$x];
			$pdf->Cell($list[$x][0], 14, $contents, '1', '0', $data_align[$x]);
		}else if($x==5){
			$contents = number_format($data_list[$x]);
			$pdf->Cell($list[$x][0], 14, $contents, '1', '2', $data_align[$x]);
		}
	}
	//件数を足す
	$space_flg = false;
	$data_list[$x-1] = number_format($data_list[$x-1]);
	$row_count++;

}

$pdf->Output();

?>
