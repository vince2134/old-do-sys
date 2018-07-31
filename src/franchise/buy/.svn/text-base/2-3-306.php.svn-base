<?php
require('../../../fpdf/mbfpdf.php');

//*******************入力箇所*********************

//余白
$left_margin = 40;
$top_margin = 40;

//ページサイズ
//A3
$pdf=new MBFPDF('L','pt','A3');

//タイトル
$title = "支払一覧表";
$page_count = "1ページ"; 

//仮の時刻
$time = "支払期間：2005年04月01日〜2005年04月31日";
//***********************************************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 9);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");
//*******************入力箇所*********************

//A3の横幅は、1110
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $title, '0', '1', 'C');
$pdf->SetXY($left_margin,$top_margin);
$pdf->Cell(1110, 14, $page_count, '0', '1', 'R');
$pdf->SetX($left_margin,$top_margin+14);
$pdf->Cell(1110, 14, $date, '0', '1', 'R');
$pdf->SetXY($left_margin,$top_margin+28);
$pdf->Cell(1110, 14, $time, '0', '2', 'R');

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("120","取引区分","C");
$list[2] = array("120","銀行","C");
$list[3] = array("80","支払番号","C");
$list[4] = array("170","仕入先","C");
$list[5] = array("80","支払日","C");
$list[6] = array("80","支払金額","C");
$list[7] = array("80","手数料","C");
$list[8] = array("80","手形期日","C");
$list[9] = array("60","券面番号","C");
$list[10] = array("210","備考","C");

for($i=1;$i<52;$i++){
	$data_list[$i] = array("$i","振込支払","東京三菱","00010001","仕入先1","2005-04-01","20,000","1,050","2005-0405","1000","");
if($i==50){
$data_list[$i] = array("$i","総合計","980,000","49件");
}
}
//align(データ)
$data_align[0] = "R";
$data_align[1] = "C";
$data_align[2] = "L";
$data_align[3] = "L";
$data_align[4] = "L";
$data_align[5] = "C";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "C";
$data_align[9] = "L";
$data_align[10] = "L";
//***********************************************

//項目表示
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
for($i=0;$i<count($list)-1;$i++)
{
	$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
}
$pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

//データ表示
for($j=1;$j<count($data_list);$j++)
{
	//背景色変更フラグ
	$color_flg = false;
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	if($j == 50){
		$pdf->SetFillColor(213,213,213);
		$color_flg = true;
	}
	for($x=0;$x<10;$x++)
	{
		if($color_flg == true){
			if($x==1 || $x==2 || $x==4 || $x==6){
				$pdf->Cell($list[$x][0], 14, $data_list[$j][$x], '1', '0','L','1');
			}else{
				$pdf->Cell($list[$x][0], 14, $data_list[$j][$x], '1', '0','R','1');
			}
		}else{
			$pdf->Cell($list[$x][0], 14, $data_list[$j][$x], '1', '0', $data_align[$x]);
		}
	}
	if($color_flg == true){
		$pdf->Cell($list[$x][0], 14, $data_list[$j][$x], '1', '2', $data_align[$x],'1');
	}else{
		$pdf->Cell($list[$x][0], 14, $data_list[$j][$x], '1', '2', $data_align[$x]);
	}
}
$pdf->Output();

?>
