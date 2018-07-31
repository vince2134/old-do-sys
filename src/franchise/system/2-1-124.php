<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

//ヘッダー表示関数
//引数（PDFオブジェクト・マージン・タイトル・左上/右上/左下/右下のヘッダ項目・ページ数・ページサイズ）
function Header_user($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$page_size){

	$pdf->SetFont(GOTHIC, '', 9);
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $title, '0', '1', 'C');
	$pdf->SetXY($left_margin,$top_margin);
	$pdf->Cell($page_size, 14, $page_count."ページ", '0', '2', 'R');
	$pdf->SetX($left_margin);
	$pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
	$pdf->SetXY($left_margin,$top_margin+14);
	$pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
	$pdf->SetXY($left_margin,$top_margin+28);
	$pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

	//セル
	$pdf->SetXY($left_margin+320,$top_margin);
	$pdf->Cell(40,10,"確認欄",'LTR','2','C');
	$pdf->Cell(40,25,"",'LRB');
	$pdf->Line($left_margin+320,$top_margin+10,$left_margin+360,$top_margin+10);

}

//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ページサイズ
$page_size = 515;

//A4
$pdf=new MBFPDF('P','pt','A4');

//タイトル
$title = "ユーザ権限設定";
//ページ数
$page_count = "1";

//スタッフ名（仮）
$staff_name = "スタッフ名: ";
$staff_name .= "デモユーザ";
//ショップ名（仮）
$shop_name = "ショップ名: ";
$shop_name .= "株式会社アメニティ";

//項目名・幅・align

//FC
$list[0] = array("250","表示 入力","R");
$list[1] = array("250","FC","L");
$list[2] = array("235","売上管理","L");
$list[3] = array("220","予定取引","L");
$list[4] = array("205","担当者別月間予定表","L");
$list[5] = array("205","部署別週間予定表","L");
$list[6] = array("205","予定データ作成","L");
$list[7] = array("205","配送コース順確認","L");
$list[8] = array("205","予定データ一覧","L");
$list[9] = array("205","予定データ一括訂正","L");
$list[10] = array("205","商品出荷確認","L");
$list[11] = array("205","集計日報","L");
$list[12] = array("205","売上伝票出力","L");
$list[13] = array("220","売上取引","L");
$list[14] = array("205","手書伝票作成","L");
$list[15] = array("205","売上伝票訂正","L");
$list[16] = array("205","売上伝票確定","L");
$list[17] = array("205","保留伝票一覧","L");
$list[18] = array("205","確定伝票一覧","L");
$list[19] = array("205","預け商品一覧","L");
$list[20] = array("205","工事明細一覧","L");
$list[21] = array("205","売上・更新済一覧","L");

//チェック値(FC)
//表示
$list_check[0] = "○";
$list_check[1] = "○";
$list_check[2] = "○";
$list_check[3] = "○";
$list_check[4] = "○";
$list_check[5] = "○";
$list_check[6] = "○";
$list_check[7] = "○";
$list_check[8] = "○";
$list_check[9] = "";
$list_check[10] = "○";
$list_check[11] = "○";
$list_check[12] = "○";
$list_check[13] = "○";
$list_check[14] = "○";
$list_check[15] = "×";
$list_check[16] = "○";
$list_check[17] = "○";

//入力
$list_check2[0] = "○";
$list_check2[1] = "○";
$list_check2[2] = "×";
$list_check2[3] = "○";
$list_check2[4] = "×";
$list_check2[5] = "○";
$list_check2[6] = "○";
$list_check2[7] = "○";
$list_check2[8] = "○";
$list_check2[9] = "";
$list_check2[10] = "×";
$list_check2[11] = "○";
$list_check2[12] = "○";
$list_check2[13] = "○";
$list_check2[14] = "○";
$list_check2[15] = "×";
$list_check2[16] = "○";
$list_check2[17] = "○";


//***********************************************

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("印刷時刻　Y年m月d日　H：i");

//ヘッダー表示
Header_user($pdf,$left_margin,$top_margin,$title,$staff_name,"",$shop_name,$date,$page_count,$page_size);

//項目表示(FC)
for($i=0;$i<count($list);$i++)
{
	//表示・入力表示
	if($i==0){
		$pdf->SetFillColor(85,85,85);
		$pdf->SetTextColor(255,255,255); 
		$pdf->SetXY($left_margin,$top_margin+45);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2],'1');
		$pdf->SetTextColor(0,0,0); 
	//FC表示
	}else if($i==1){
		$pdf->SetFillColor(239,176,240);
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin,$posY);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//メインメニュー表示
	}else if($i==2){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//サブメニュー表示
	}else if($i==3 || $i==13){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LRT', '2', $list[$i][2],'1');
	//画面名表示
	}else{
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->Cell($list[$i][0], 14, $list[$i][1], 'LR', '2', $list[$i][2]);
	}
}

//チェック表示(FC)
$pdf->SetXY($left_margin, $top_margin+101);
for($i=0;$i<count($list_check);$i++)
{
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin+206, $posY);
	$pdf->Cell('20', 14, $list_check[$i], '', '0', 'C');
	$pdf->Cell('23', 14, $list_check2[$i], '', '2', 'C');
}

//枠描画(FC)
//売上管理
$pdf->Line($left_margin+45,$top_margin+101,$left_margin+250,$top_margin+101);
$pdf->Line($left_margin+45,$top_margin+241,$left_margin+250,$top_margin+241);
$pdf->Line($left_margin,$top_margin+353,$left_margin+250,$top_margin+353);



$pdf->Output();

?>
