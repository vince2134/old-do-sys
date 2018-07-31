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
//本部
$list_head[0] = array("250","表示 入力","R");
$list_head[1] = array("250","本部","L");
$list_head[2] = array("235","売上管理","L");
$list_head[3] = array("220","受注取引","L");
$list_head[4] = array("205","予定データ作成","L");
$list_head[5] = array("205","受注入力(オフライン)","L");
$list_head[6] = array("205","出荷予定入力","L");
$list_head[7] = array("205","FC別受注残一覧","L");
$list_head[8] = array("205","商品別受注残一覧","L");
$list_head[9] = array("205","FC別受注・売上確定一覧","L");
$list_head[10] = array("205","商品別受注・売上確定一覧","L");
$list_head[11] = array("220","売上取引","L");
$list_head[12] = array("205","売上入力","L");
$list_head[13] = array("205","売上伝票一括出力","L");
$list_head[14] = array("205","売上一覧","L");
$list_head[15] = array("205","売上・請求確定一覧","L");
$list_head[16] = array("235","仕入管理","L");
$list_head[17] = array("220","発注取引","L");
$list_head[18] = array("205","発注予定一覧","L");
$list_head[19] = array("205","発注入力","L");
$list_head[20] = array("205","発注一覧","L");
$list_head[21] = array("220","仕入取引","L");
$list_head[22] = array("205","仕入入力","L");
$list_head[23] = array("205","仕入一覧","L");
$list_head[24] = array("205","仕入・更新済一覧","L");
//FC
$list_fc[0] = array("250","表示 入力","R");
$list_fc[1] = array("250","FC","L");
$list_fc[2] = array("235","売上管理","L");
$list_fc[3] = array("220","予定取引","L");
$list_fc[4] = array("205","担当者別月間予定表","L");
$list_fc[5] = array("205","部署別週間予定表","L");
$list_fc[6] = array("205","予定データ作成","L");
$list_fc[7] = array("205","配送コース順確認","L");
$list_fc[8] = array("205","予定データ一覧","L");
$list_fc[9] = array("205","予定データ一括訂正","L");
$list_fc[10] = array("205","商品出荷確認","L");
$list_fc[11] = array("205","集計日報","L");
$list_fc[12] = array("205","売上伝票出力","L");
$list_fc[13] = array("220","売上取引","L");
$list_fc[14] = array("205","手書伝票作成","L");
$list_fc[15] = array("205","売上伝票訂正","L");
$list_fc[16] = array("205","売上伝票確定","L");
$list_fc[17] = array("205","保留伝票一覧","L");
$list_fc[18] = array("205","確定伝票一覧","L");
$list_fc[19] = array("205","預け商品一覧","L");
$list_fc[20] = array("205","工事明細一覧","L");
$list_fc[21] = array("205","売上・更新済一覧","L");

//チェック値(HEAD)
//表示
$list_check[0] = "○";
$list_check[1] = "○";
$list_check[2] = "○";
$list_check[3] = "○";
$list_check[4] = "○";
$list_check[5] = "○";
$list_check[6] = "○";
$list_check[7] = "";
$list_check[8] = "○";
$list_check[9] = "○";
$list_check[10] = "○";
$list_check[11] = "○";
$list_check[12] = "";
$list_check[13] = "";
$list_check[14] = "○";
$list_check[15] = "×";
$list_check[16] = "○";
$list_check[17] = "";
$list_check[18] = "○";
$list_check[19] = "×";
$list_check[20] = "○";
//入力
$list_check2[0] = "○";
$list_check2[1] = "○";
$list_check2[2] = "×";
$list_check2[3] = "○";
$list_check2[4] = "×";
$list_check2[5] = "○";
$list_check2[6] = "○";
$list_check2[7] = "";
$list_check2[8] = "○";
$list_check2[9] = "○";
$list_check2[10] = "○";
$list_check2[11] = "○";
$list_check2[12] = "";
$list_check2[13] = "";
$list_check2[14] = "○";
$list_check2[15] = "×";
$list_check2[16] = "○";
$list_check2[17] = "";
$list_check2[18] = "○";
$list_check2[19] = "×";
$list_check2[20] = "×";

//チェック値(FC)
//表示
$list_check3[0] = "○";
$list_check3[1] = "○";
$list_check3[2] = "○";
$list_check3[3] = "○";
$list_check3[4] = "○";
$list_check3[5] = "○";
$list_check3[6] = "○";
$list_check3[7] = "○";
$list_check3[8] = "○";
$list_check3[9] = "";
$list_check3[10] = "○";
$list_check3[11] = "○";
$list_check3[12] = "○";
$list_check3[13] = "○";
$list_check3[14] = "○";
$list_check3[15] = "×";
$list_check3[16] = "○";
$list_check3[17] = "○";

//入力
$list_check4[0] = "○";
$list_check4[1] = "○";
$list_check4[2] = "×";
$list_check4[3] = "○";
$list_check4[4] = "×";
$list_check4[5] = "○";
$list_check4[6] = "○";
$list_check4[7] = "○";
$list_check4[8] = "○";
$list_check4[9] = "";
$list_check4[10] = "×";
$list_check4[11] = "○";
$list_check4[12] = "○";
$list_check4[13] = "○";
$list_check4[14] = "○";
$list_check4[15] = "×";
$list_check4[16] = "○";
$list_check4[17] = "○";


//***********************************************

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$date = date("印刷時刻　Y年m月d日　H：i");

//ヘッダー表示
Header_user($pdf,$left_margin,$top_margin,$title,$staff_name,"",$shop_name,$date,$page_count,$page_size);

//項目表示(HEAD)
$pdf->SetXY($left_margin, $top_margin+45);
for($i=0;$i<count($list_head);$i++)
{
	//表示・入力表示
	if($i==0){
		$pdf->SetFillColor(85,85,85);
		$pdf->SetTextColor(255,255,255); 
		$pdf->Cell($list_head[$i][0], 14, $list_head[$i][1], '1', '2', $list_head[$i][2],'1');
		$pdf->SetTextColor(0,0,0); 
	//本部表示
	}else if($i==1){
		$pdf->SetFillColor(176,176,240);
		$pdf->Cell($list_head[$i][0], 14, $list_head[$i][1], 'LRT', '2', $list_head[$i][2],'1');
	//メインメニュー表示
	}else if($i==2 || $i==16){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(176,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(192,192,240);
		$pdf->Cell($list_head[$i][0], 14, $list_head[$i][1], 'LRT', '2', $list_head[$i][2],'1');
	//サブメニュー表示
	}else if($i==3 || $i==11 || $i==17 || $i==21){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(176,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(192,192,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(224,224,240);
		$pdf->Cell($list_head[$i][0], 14, $list_head[$i][1], 'LRT', '2', $list_head[$i][2],'1');
	//画面名表示
	}else{
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin, $posY);
		$pdf->SetFillColor(176,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(192,192,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(224,224,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->Cell($list_head[$i][0], 14, $list_head[$i][1], 'LR', '2', $list_head[$i][2]);
	}
}

//項目表示(FC)
for($i=0;$i<count($list_fc);$i++)
{
	//表示・入力表示
	if($i==0){
		$pdf->SetFillColor(85,85,85);
		$pdf->SetTextColor(255,255,255); 
		$pdf->SetXY($left_margin+264,$top_margin+45);
		$pdf->Cell($list_fc[$i][0], 14, $list_fc[$i][1], '1', '2', $list_fc[$i][2],'1');
		$pdf->SetTextColor(0,0,0); 
	//FC表示
	}else if($i==1){
		$pdf->SetFillColor(239,176,240);
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin+264,$posY);
		$pdf->Cell($list_fc[$i][0], 14, $list_fc[$i][1], 'LRT', '2', $list_fc[$i][2],'1');
	//メインメニュー表示
	}else if($i==2){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin+264, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell($list_fc[$i][0], 14, $list_fc[$i][1], 'LRT', '2', $list_fc[$i][2],'1');
	//サブメニュー表示
	}else if($i==3 || $i==13){
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin+264, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell($list_fc[$i][0], 14, $list_fc[$i][1], 'LRT', '2', $list_fc[$i][2],'1');
	//画面名表示
	}else{
		$posY = $pdf->GetY();
		$pdf->SetXY($left_margin+264, $posY);
		$pdf->SetFillColor(239,176,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(239,199,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->SetFillColor(236,218,240);
		$pdf->Cell('15', 14, '', 'LR', '0', 'C','1');
		$pdf->Cell($list_fc[$i][0], 14, $list_fc[$i][1], 'LR', '2', $list_fc[$i][2]);
	}
}

//チェック表示(HEAD)
$pdf->SetXY($left_margin, $top_margin+101);
for($i=0;$i<count($list_check);$i++)
{
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin+206, $posY);
	$pdf->Cell('20', 14, $list_check[$i], '', '0', 'C');
	$pdf->Cell('23', 14, $list_check2[$i], '', '2', 'C');
}

//チェック表示(FC)
$pdf->SetXY($left_margin+470, $top_margin+101);
for($i=0;$i<count($list_check3);$i++)
{
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin+470, $posY);
	$pdf->Cell('20', 14, $list_check3[$i], '', '0', 'C');
	$pdf->Cell('23', 14, $list_check4[$i], '', '2', 'C');
}

//枠描画(HEAD)
//売上管理
$pdf->Line($left_margin+45,$top_margin+101,$left_margin+250,$top_margin+101);
$pdf->Line($left_margin+45,$top_margin+213,$left_margin+250,$top_margin+213);
//仕入管理
$pdf->Line($left_margin+45,$top_margin+297,$left_margin+250,$top_margin+297);
$pdf->Line($left_margin+45,$top_margin+353,$left_margin+250,$top_margin+353);
$pdf->Line($left_margin,$top_margin+395,$left_margin+250,$top_margin+395);

//枠描画(FC)
//売上管理
$pdf->Line($left_margin+309,$top_margin+101,$left_margin+514,$top_margin+101);
$pdf->Line($left_margin+309,$top_margin+241,$left_margin+514,$top_margin+241);
$pdf->Line($left_margin+264,$top_margin+353,$left_margin+514,$top_margin+353);



$pdf->Output();

?>
