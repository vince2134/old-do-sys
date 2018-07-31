<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);
$pdf=new MBFPDF('P','pp','a4');
$pdf->SetProtection(array('print', 'copy'));
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$client_id  = $_SESSION[client_id];

/****************************/
//DB値設定
/****************************/
/*
$sql  = "SELECT ";
$sql .= "c_memo1, ";		//請求書コメント1
$sql .= "c_memo2, ";		//請求書コメント2
$sql .= "c_memo3, ";		//請求書コメント3
$sql .= "c_memo4, ";		//請求書コメント4
$sql .= "c_memo5, ";		//請求書コメント5
$sql .= "c_memo6, ";		//請求書コメント6
$sql .= "c_memo7, ";		//請求書コメント7
$sql .= "c_memo8, ";		//請求書コメント8
$sql .= "c_memo9, ";		//請求書コメント9
$sql .= "c_memo10, ";		//請求書コメント10
$sql .= "c_memo11, ";		//請求書コメント11
$sql .= "c_memo12, ";		//請求書コメント12
$sql .= "c_memo13 ";		//請求書コメント13
$sql .= "FROM ";
$sql .= "t_ledger_sheet ";
$sql .= "WHERE ";
$sql .= "client_id = $client_id;";
$result = Db_Query($db_con,$sql);

//DBの値を配列に保存
$c_memo = Get_Data($result);
*/

$which = "details";//明細請求書(details)か合計請求書のどっちを出力するか
$company2 = "　";//納品先
/*
//御得意先情報
$code = "004059-0001";//お客様コードNo
$code1 = "00000001";//請求番号
$page = "  1";
$post = "235-0016";//郵便番号
$address1 = "横浜市磯子区磯子１−２−１０";//住所１行目
$address2 = "システムプラザ磯子二号館二階";//住所２行目
$company = "(株)バブコック日立";//会社名
$company2 = "バブ日立ソフト株式会社";//納品先

$date_y = "05";//年
$date_m = "11";//月
$date_d = "22";//日

$money1 = "12,600";
$money2 = "6,300";
$money3 = "6,300";
$money4 = "6,000";
$money5 = "300";
$money6 = "6,300";
$money7 = "100,000";
if($which == "details"){
	$sheet = "1/5";
}else{
	$sheet = "5";
}

//一覧
//データ
$data_list[1] = array("","","","前回御請求額","","","","12600","","");
$data_list[2] = array("2005-08-25","","入金","入金(振込)","","","","","","5985");
$data_list[3] = array("","","","入金(手数料)","","","","","","315");
$data_list[4] = array("2005-09-01","","売掛","ムッシュNo.1","2","個","250000","5000","","");
$data_list[5] = array("","","","ボンボアレンタル","1","台","30000","300","","");
$data_list[6] = array("","","","ボンアートレンタル","1","","70000","700","","");
$data_list[7] = array("","","","単�競▲襯�リ電池　２入","2","個","000","0","","");
$data_list[8] = array("","","","消費税額","","","","300","","");
$data_list[9] = array("","","","売上合計金額","","","","6000","","");
$data_list[10] = array("","","","消費税合計金額","","","","300","","");
$data_list[11] = array("","","","入金合計金額","","","","","","6300");
$data_list[12] = array("","","","今回御請求額","","","","12600","","");
*/
//幅
$list = array("50","40","25","235","40","30","50","40","30","40");
//align
$data_align = array("C","L","C","L","R","L","R","R","L","R");


$left_margin = 45;
$posY = 20;

//線のa太さ
$pdf->SetLineWidth(0.2);
//線の色
$pdf->SetDrawColor(29,0,120);
//フォント設定
$pdf->SetFont(GOTHIC,'', 9);
//テキストの色
$pdf->SetTextColor(61,1,255); 
//背景色
$pdf->SetFillColor(200,230,255);

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+423, $posY+26,70,22);

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+380, $posY);
$pdf->Cell(60, 12,'お客様コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+440, $posY);
$pdf->Cell(100, 12,$code, '0', '1', 'L','0');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+510, $posY);
$pdf->Cell(60, 12,'請求番号　　', '0', '1', 'C','0');
$pdf->SetXY($left_margin+552, $posY);
$pdf->Cell(100, 12,$code1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+574, $posY+10);
$pdf->Cell(18, 12,$page, '0', '1', 'L','0');


$pdf->SetFont(GOTHIC,'', 12);
$pdf->SetXY($left_margin+257, $posY+2);
$pdf->Cell(70, 15,'請　求　書', 'B', '1', 'C');
$pdf->Line($left_margin+257,$posY+19,$left_margin+327,$posY+19);

$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+5, $posY+25);
$pdf->Cell(15, 12,'〒', '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+25);
$pdf->Cell(50, 12,$post, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+42);
$pdf->Cell(155, 12,$address1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+60);
$pdf->Cell(155, 12,$address2, '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+30, $posY+79);
$pdf->Cell(195, 14,$company, '0', '1', 'C','0');

if($company2!=null){
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+5, $posY+99.5);
$pdf->Cell(20, 14,"納品先", '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+30, $posY+100);
$pdf->Cell(195, 14,$company2, '0', '1', 'C','0');
}

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+240, $posY+54);
$pdf->Cell(12, 12,$date_y, '0', '1', 'C','0');
$pdf->SetXY($left_margin+252, $posY+54);
$pdf->Cell(12, 12,'年', '0', '1', 'C','0');
$pdf->SetXY($left_margin+264, $posY+54);
$pdf->Cell(12, 12,$date_m, '0', '1', 'C','0');
$pdf->SetXY($left_margin+276, $posY+54);
$pdf->Cell(12, 12,'月', '0', '1', 'C','0');
$pdf->SetXY($left_margin+288, $posY+54);
$pdf->Cell(12, 12,$date_d, '0', '1', 'C','0');
$pdf->SetXY($left_margin+300, $posY+54);
$pdf->Cell(12, 12,'日', '0', '1', 'C','0');
$pdf->SetXY($left_margin+320, $posY+54);
$pdf->Cell(20, 12,'締 切', '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'', 13);
$pdf->SetXY($left_margin+230, $posY+80);
$pdf->Cell(12, 12,御中, '0', '1', 'C','0');
$posY = 40;
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+420, $posY+34);
$pdf->Cell(37, 12,$c_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(MINCHO,'B', 9);
$pdf->SetXY($left_margin+427, $posY+52);
$pdf->Cell(37,12,$c_memo[0][1], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+440, $posY+67);
$pdf->Cell(174,8,$c_memo[0][2], '0','1', 'L','0');

$pdf->SetXY($left_margin+440, $posY+77);
$pdf->Cell(174,8,$c_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+332, $posY+90);
$pdf->Cell(100, 10,'下記の通り御請求申し上げます。', '0', '1', 'R','0');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->RoundedRect(55, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(120, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(185, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(250, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(315, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(380, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(445, 150, 60, 15, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(50,50,200);
$pdf->RoundedRect(565, 150, 70, 15, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+10, $posY+113);
$pdf->Cell(65, 10,'前回御請求額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+75, $posY+113);
$pdf->Cell(65, 10,'今回御入金額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+140, $posY+113);
$pdf->Cell(65, 10,'繰越残高額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+205, $posY+113);
$pdf->Cell(65, 10,'今回御買上額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+270, $posY+113);
$pdf->Cell(65, 10,'今回消費税額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+335, $posY+113);
$pdf->Cell(65, 10,'税込御買上額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+400, $posY+113);
$pdf->Cell(60, 10,'枚数', '0', '1', 'C','0');
//テキストの色
$pdf->SetTextColor(255); 
$pdf->SetXY($left_margin+520, $posY+113);
$pdf->Cell(70, 10,'今回御請求額', '0', '1', 'C','0');
//テキストの色
$pdf->SetTextColor(61,1,255); 
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(55, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(120, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(185, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(250, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(315, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(380, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(445, 165, 60, 25, 3, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(565, 165, 70, 25, 3, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+10, $posY+125);
$pdf->Cell(65, 25,$money1, '0', '1', 'R','0');
$pdf->SetXY($left_margin+75, $posY+125);
$pdf->Cell(65, 25,$money2, '0', '1', 'R','0');
$pdf->SetXY($left_margin+140, $posY+125);
$pdf->Cell(65, 25,$money3, '0', '1', 'R','0');
$pdf->SetXY($left_margin+205, $posY+125);
$pdf->Cell(65, 25,$money4, '0', '1', 'R','0');
$pdf->SetXY($left_margin+270, $posY+125);
$pdf->Cell(65, 25,$money5, '0', '1', 'R','0');
$pdf->SetXY($left_margin+335, $posY+125);
$pdf->Cell(65, 25,$money6, '0', '1', 'R','0');
$pdf->SetXY($left_margin+400, $posY+125);
$pdf->Cell(60, 25,$sheet, '0', '1', 'R','0');
$pdf->SetXY($left_margin+520, $posY+125);
$pdf->Cell(70, 25,$money7, '0', '1', 'R','0');


if($which == "details"){
//背景色
$pdf->SetFillColor(200,230,255);
$pdf->RoundedRect(55, 200, 580, 20, 5, 'FD',12);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 7.5);
$pdf->SetXY($left_margin+10, $posY+160);
$pdf->Cell(50, 20,'月　日', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+60, $posY+160);
$pdf->Cell(40, 20,'伝票番号', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+100, $posY+160);
$pdf->Cell(25, 10,'取引', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+100, $posY+170);
$pdf->Cell(25, 10,'区分', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+125, $posY+160);
$pdf->Cell(235, 20,'商　　　　品　　　　名', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+360, $posY+160);
$pdf->Cell(40, 20,'数　量', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+400, $posY+160);
$pdf->Cell(30, 20,'単位', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+430, $posY+160);
$pdf->Cell(50, 20,'単　価', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+480, $posY+160);
$pdf->Cell(40, 20,'金　額', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+520, $posY+160);
$pdf->Cell(30, 20,'税区分', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+550, $posY+160);
$pdf->Cell(40, 20,'入　金', '0', '1', 'C','0');

$pdf->SetFont(GOTHIC,'', 7);
$left_margin = 55;
$pdf->SetFillColor(232,240,255);
$count = 42;

//データ表示
for($i=1;$i<=$count;$i++)
{
	if($i==$count && $i%2 == 0){
		$posY = $pdf->GetY();
		$pdf->RoundedRect(55, $posY, 580, 15, 5, 'FD',34);
	}
	$pdf->SetX($left_margin);
	for($x=0;$x<10;$x++)
	{
		if($i!=$count){
			if($i%2 != 0){
				if($x==9){
					$pdf->Cell($list[9], 15, $data_list[$i][9], '1', '1', $data_align[9]);
				}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x]);
				}else{
					$data_align[3]="L";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x]);
				}
			}else{
				if($x==9){
					$pdf->Cell($list[9], 15, $data_list[$i][9], '1', '1', $data_align[9],'1');
				}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x],'1');
				}else{
						$data_align[3]="L";
						$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x],'1');
				}
			}
		}else if($i%2 != 0){
			$posY = $pdf->GetY();
			$pdf->RoundedRect(55, $posY, 580, 15, 5, '',34);
			if($x==9){
				$pdf->Cell($list[9], 15, $data_list[$i][9], 'L', '1', $data_align[9]);
			}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'R', '0', $data_align[$x]);
			}else if($x==0){
				$data_align[3]="L";
				$pdf->Cell($list[0], 15, $data_list[$i][0], '0', '0', $data_align[0]);
			}else{
				$data_align[3]="L";
				$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'L', '0', $data_align[$x]);
			}
		}else{
			if($x==9){
				$pdf->Cell($list[9], 15, $data_list[$i][9], 'L', '1', $data_align[9]);
			}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'R', '0', $data_align[$x]);
			}else if($x==0){
				$data_align[3]="L";
				$pdf->Cell($list[0], 15, $data_list[$i][0], '0', '0', $data_align[0]);
			}else{
				$data_align[3]="L";
				$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'L', '0', $data_align[$x]);
			}
		}
	}
}

$pdf->SetLineWidth(0.1);
$posY = 220;
$pdf->Line($left_margin+459.1, $posY, $left_margin+459.1, $posY+$count*14.98);
$pdf->SetLineWidth(0.05);
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+363.7, $posY+$i, $left_margin+363.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+375.3, $posY+$i, $left_margin+375.3, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+436, $posY+$i, $left_margin+436, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+447.6, $posY+$i, $left_margin+447.6, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+483.7, $posY+$i, $left_margin+483.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+495.3, $posY+$i, $left_margin+495.3, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+553.7, $posY+$i, $left_margin+553.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+565.3, $posY+$i, $left_margin+565.3, $posY+$i+0.6);
}
}


$left_margin = 45;
$posY = $pdf->GetY();

//背景色
$pdf->SetFillColor(200,230,255);
$pdf->RoundedRect(515, $posY+5, 10, 40, 3, 'FD',14);
$pdf->RoundedRect(595, $posY+5, 40, 10, 3, 'FD',12);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(525, $posY+5, 70, 40, 3, 'FD',23);
$pdf->RoundedRect(595, $posY+15, 40, 30, 3, 'FD',34);

$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+470, $posY+8);
$pdf->Cell(10, 10,'担', '0', '1', 'C','0');
$pdf->SetXY($left_margin+470, $posY+20);
$pdf->Cell(10, 10,'当', '0', '1', 'C','0');
$pdf->SetXY($left_margin+470, $posY+32);
$pdf->Cell(10, 10,'者', '0', '1', 'C','0');
$pdf->SetXY($left_margin+550, $posY+5);
$pdf->Cell(40, 10,'印', '0', '1', 'C','0');
$left_margin = 24;
$pdf->SetFont(GOTHIC,'', 5);
$pdf->SetXY($left_margin+31, $posY+4);
$pdf->Cell(25, 8,'取引銀行', '0', '1', 'C','0');
$pdf->SetXY($left_margin+56, $posY+4);
$pdf->Cell(115, 8,$c_memo[0][4], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+4);
$pdf->Cell(115, 8,$c_memo[0][5], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+12);
$pdf->Cell(115, 8,$c_memo[0][6], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+12);
$pdf->Cell(115, 8,$c_memo[0][7], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+20);
$pdf->Cell(115, 8,$c_memo[0][8], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+20);
$pdf->Cell(115, 8,$c_memo[0][9], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+28);
$pdf->Cell(115, 8,$c_memo[0][10], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+28);
$pdf->Cell(115, 8,$c_memo[0][11], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+56, $posY+39);
$pdf->Cell(210, 8,$c_memo[0][12], '0', '1', 'L','0');

$pdf->AddPage();

$which = "details";//明細請求書(details)か合計請求書のどっちを出力するか
$company2 = "　";//納品先
/*
//御得意先情報
$code = "004059-0001";//お客様コードNo
$code1 = "00000001";//請求番号
$page = "  1";
$post = "235-0016";//郵便番号
$address1 = "横浜市磯子区磯子１−２−１０";//住所１行目
$address2 = "システムプラザ磯子二号館二階";//住所２行目
$company = "(株)バブコック日立";//会社名
$company2 = "バブ日立ソフト株式会社";//納品先

$date_y = "05";//年
$date_m = "11";//月
$date_d = "22";//日

$money1 = "12,600";
$money2 = "6,300";
$money3 = "6,300";
$money4 = "6,000";
$money5 = "300";
$money6 = "6,300";
$money7 = "100,000";
if($which == "details"){
	$sheet = "1/5";
}else{
	$sheet = "5";
}

//一覧
//データ
$data_list[1] = array("","","","前回御請求額","","","","12600","","");
$data_list[2] = array("2005-08-25","","入金","入金(振込)","","","","","","5985");
$data_list[3] = array("","","","入金(手数料)","","","","","","315");
$data_list[4] = array("2005-09-01","","売掛","ムッシュNo.1","2","個","250000","5000","","");
$data_list[5] = array("","","","ボンボアレンタル","1","台","30000","300","","");
$data_list[6] = array("","","","ボンアートレンタル","1","","70000","700","","");
$data_list[7] = array("","","","単�競▲襯�リ電池　２入","2","個","000","0","","");
$data_list[8] = array("","","","消費税額","","","","300","","");
$data_list[9] = array("","","","売上合計金額","","","","6000","","");
$data_list[10] = array("","","","消費税合計金額","","","","300","","");
$data_list[11] = array("","","","入金合計金額","","","","","","6300");
$data_list[12] = array("","","","今回御請求額","","","","12600","","");
*/
//幅
$list = array("50","40","25","235","40","30","50","40","30","40");
//align
$data_align = array("C","L","C","L","R","L","R","R","L","R");


$left_margin = 45;
$posY = 20;

//線の太さ
$pdf->SetLineWidth(0.2);
//線の色
$pdf->SetDrawColor(14,104,20);
//フォント設定
$pdf->SetFont(GOTHIC,'', 9);
//テキストの色
$pdf->SetTextColor(18,133,25); 
//背景色
$pdf->SetFillColor(198,246,195);

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+423, $posY+26,70,22);

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+380, $posY);
$pdf->Cell(60, 12,'お客様コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+440, $posY);
$pdf->Cell(100, 12,$code, '0', '1', 'L','0');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+510, $posY);
$pdf->Cell(60, 12,'請求番号　　', '0', '1', 'C','0');
$pdf->SetXY($left_margin+552, $posY);
$pdf->Cell(100, 12,$code1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+574, $posY+10);
$pdf->Cell(18, 12,$page, '0', '1', 'L','0');


$pdf->SetFont(GOTHIC,'', 12);
$pdf->SetXY($left_margin+257, $posY+2);
$pdf->Cell(70, 15,'請　求　書', 'B', '1', 'C');
$pdf->Line($left_margin+257,$posY+19,$left_margin+327,$posY+19);

$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+5, $posY+25);
$pdf->Cell(15, 12,'〒', '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+25);
$pdf->Cell(50, 12,$post, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+42);
$pdf->Cell(155, 12,$address1, '0', '1', 'L','0');
$pdf->SetXY($left_margin+20, $posY+60);
$pdf->Cell(155, 12,$address2, '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+30, $posY+79);
$pdf->Cell(195, 14,$company, '0', '1', 'C','0');

if($company2!=null){
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+5, $posY+99.5);
$pdf->Cell(20, 14,"納品先", '0', '1', 'C','0');
$pdf->SetFont(GOTHIC,'', 11);
$pdf->SetXY($left_margin+30, $posY+100);
$pdf->Cell(195, 14,$company2, '0', '1', 'C','0');
}

$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+240, $posY+54);
$pdf->Cell(12, 12,$date_y, '0', '1', 'C','0');
$pdf->SetXY($left_margin+252, $posY+54);
$pdf->Cell(12, 12,'年', '0', '1', 'C','0');
$pdf->SetXY($left_margin+264, $posY+54);
$pdf->Cell(12, 12,$date_m, '0', '1', 'C','0');
$pdf->SetXY($left_margin+276, $posY+54);
$pdf->Cell(12, 12,'月', '0', '1', 'C','0');
$pdf->SetXY($left_margin+288, $posY+54);
$pdf->Cell(12, 12,$date_d, '0', '1', 'C','0');
$pdf->SetXY($left_margin+300, $posY+54);
$pdf->Cell(12, 12,'日', '0', '1', 'C','0');
$pdf->SetXY($left_margin+320, $posY+54);
$pdf->Cell(20, 12,'締 切', '0', '1', 'C','0');
$pdf->Image(IMAGE_DIR.'shain.png',$left_margin+500, $posY+40,60);
$pdf->SetFont(GOTHIC,'', 13);
$pdf->SetXY($left_margin+230, $posY+80);
$pdf->Cell(12, 12,御中, '0', '1', 'C','0');
$posY = 40;
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+420, $posY+34);
$pdf->Cell(37, 12,$c_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(MINCHO,'B', 9);
$pdf->SetXY($left_margin+427, $posY+52);
$pdf->Cell(37,12,$c_memo[0][1], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+440, $posY+67);
$pdf->Cell(174,8,$c_memo[0][2], '0','1', 'L','0');

$pdf->SetXY($left_margin+440, $posY+77);
$pdf->Cell(174,8,$c_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+332, $posY+90);
$pdf->Cell(100, 10,'下記の通り御請求申し上げます。', '0', '1', 'R','0');

$pdf->SetFont(GOTHIC,'', 8);
$pdf->RoundedRect(55, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(120, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(185, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(250, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(315, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(380, 150, 65, 15, 3, 'FD',12);
$pdf->RoundedRect(445, 150, 60, 15, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(18,133,25); 
$pdf->RoundedRect(565, 150, 70, 15, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+10, $posY+113);
$pdf->Cell(65, 10,'前回御請求額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+75, $posY+113);
$pdf->Cell(65, 10,'今回御入金額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+140, $posY+113);
$pdf->Cell(65, 10,'繰越残高額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+205, $posY+113);
$pdf->Cell(65, 10,'今回御買上額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+270, $posY+113);
$pdf->Cell(65, 10,'今回消費税額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+335, $posY+113);
$pdf->Cell(65, 10,'税込御買上額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+400, $posY+113);
$pdf->Cell(60, 10,'枚数', '0', '1', 'C','0');
//テキストの色
$pdf->SetTextColor(255); 
$pdf->SetXY($left_margin+520, $posY+113);
$pdf->Cell(70, 10,'今回御請求額', '0', '1', 'C','0');
//テキストの色
$pdf->SetTextColor(18,133,25); 
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(55, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(120, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(185, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(250, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(315, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(380, 165, 65, 25, 3, 'FD',34);
$pdf->RoundedRect(445, 165, 60, 25, 3, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(565, 165, 70, 25, 3, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+10, $posY+125);
$pdf->Cell(65, 25,$money1, '0', '1', 'R','0');
$pdf->SetXY($left_margin+75, $posY+125);
$pdf->Cell(65, 25,$money2, '0', '1', 'R','0');
$pdf->SetXY($left_margin+140, $posY+125);
$pdf->Cell(65, 25,$money3, '0', '1', 'R','0');
$pdf->SetXY($left_margin+205, $posY+125);
$pdf->Cell(65, 25,$money4, '0', '1', 'R','0');
$pdf->SetXY($left_margin+270, $posY+125);
$pdf->Cell(65, 25,$money5, '0', '1', 'R','0');
$pdf->SetXY($left_margin+335, $posY+125);
$pdf->Cell(65, 25,$money6, '0', '1', 'R','0');
$pdf->SetXY($left_margin+400, $posY+125);
$pdf->Cell(60, 25,$sheet, '0', '1', 'R','0');
$pdf->SetXY($left_margin+520, $posY+125);
$pdf->Cell(70, 25,$money7, '0', '1', 'R','0');


if($which == "details"){
//背景色
$pdf->SetFillColor(198,246,195);
$pdf->RoundedRect(55, 200, 580, 20, 5, 'FD',12);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 7.5);
$pdf->SetXY($left_margin+10, $posY+160);
$pdf->Cell(50, 20,'月　日', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+60, $posY+160);
$pdf->Cell(40, 20,'伝票番号', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+100, $posY+160);
$pdf->Cell(25, 10,'取引', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+100, $posY+170);
$pdf->Cell(25, 10,'区分', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+125, $posY+160);
$pdf->Cell(235, 20,'商　　　　品　　　　名', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+360, $posY+160);
$pdf->Cell(40, 20,'数　量', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+400, $posY+160);
$pdf->Cell(30, 20,'単位', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+430, $posY+160);
$pdf->Cell(50, 20,'単　価', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+480, $posY+160);
$pdf->Cell(40, 20,'金　額', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+520, $posY+160);
$pdf->Cell(30, 20,'税区分', 'R', '1', 'C','0');
$pdf->SetXY($left_margin+550, $posY+160);
$pdf->Cell(40, 20,'入　金', '0', '1', 'C','0');

$pdf->SetFont(GOTHIC,'', 7);
$left_margin = 55;
$pdf->SetFillColor(230,255,230);
$count = 42;

//データ表示
for($i=1;$i<=$count;$i++)
{
	if($i==$count && $i%2 == 0){
		$posY = $pdf->GetY();
		$pdf->RoundedRect(55, $posY, 580, 15, 5, 'FD',34);
	}
	$pdf->SetX($left_margin);
	for($x=0;$x<10;$x++)
	{
		if($i!=$count){
			if($i%2 != 0){
				if($x==9){
					$pdf->Cell($list[9], 15, $data_list[$i][9], '1', '1', $data_align[9]);
				}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x]);
				}else{
					$data_align[3]="L";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x]);
				}
			}else{
				if($x==9){
					$pdf->Cell($list[9], 15, $data_list[$i][9], '1', '1', $data_align[9],'1');
				}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x],'1');
				}else{
						$data_align[3]="L";
						$pdf->Cell($list[$x], 15, $data_list[$i][$x], '1', '0', $data_align[$x],'1');
				}
			}
		}else if($i%2 != 0){
			$posY = $pdf->GetY();
			$pdf->RoundedRect(55, $posY, 580, 15, 5, '',34);
			if($x==9){
				$pdf->Cell($list[9], 15, $data_list[$i][9], 'L', '1', $data_align[9]);
			}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'R', '0', $data_align[$x]);
			}else if($x==0){
				$data_align[3]="L";
				$pdf->Cell($list[0], 15, $data_list[$i][0], '0', '0', $data_align[0]);
			}else{
				$data_align[3]="L";
				$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'L', '0', $data_align[$x]);
			}
		}else{
			if($x==9){
				$pdf->Cell($list[9], 15, $data_list[$i][9], 'L', '1', $data_align[9]);
			}else if($x==3 && $data_list[$i][3]=="前回御請求額" || $data_list[$i][3]=="消費税額" || $data_list[$i][3]=="売上合計金額" || $data_list[$i][3]=="消費税合計金額" || $data_list[$i][3]=="入金合計金額" || $data_list[$i][3]=="今回御請求額"){
					$data_align[3]="R";
					$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'R', '0', $data_align[$x]);
			}else if($x==0){
				$data_align[3]="L";
				$pdf->Cell($list[0], 15, $data_list[$i][0], '0', '0', $data_align[0]);
			}else{
				$data_align[3]="L";
				$pdf->Cell($list[$x], 15, $data_list[$i][$x], 'L', '0', $data_align[$x]);
			}
		}
	}
}

$pdf->SetLineWidth(0.1);
$posY = 220;
$pdf->Line($left_margin+459.1, $posY, $left_margin+459.1, $posY+$count*14.98);
$pdf->SetLineWidth(0.05);
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+363.7, $posY+$i, $left_margin+363.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+375.3, $posY+$i, $left_margin+375.3, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+436, $posY+$i, $left_margin+436, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+447.6, $posY+$i, $left_margin+447.6, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+483.7, $posY+$i, $left_margin+483.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+495.3, $posY+$i, $left_margin+495.3, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+553.7, $posY+$i, $left_margin+553.7, $posY+$i+0.6);
}
for($i=0;$i<$count*14.98;$i=$i+2){
    $pdf->Line($left_margin+565.3, $posY+$i, $left_margin+565.3, $posY+$i+0.6);
}
}


$left_margin = 45;
$posY = $pdf->GetY();

//背景色
$pdf->SetFillColor(198,246,195);
$pdf->RoundedRect(515, $posY+5, 10, 40, 3, 'FD',14);
$pdf->RoundedRect(595, $posY+5, 40, 10, 3, 'FD',12);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(525, $posY+5, 70, 40, 3, 'FD',23);
$pdf->RoundedRect(595, $posY+15, 40, 30, 3, 'FD',34);

$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+470, $posY+8);
$pdf->Cell(10, 10,'担', '0', '1', 'C','0');
$pdf->SetXY($left_margin+470, $posY+20);
$pdf->Cell(10, 10,'当', '0', '1', 'C','0');
$pdf->SetXY($left_margin+470, $posY+32);
$pdf->Cell(10, 10,'者', '0', '1', 'C','0');
$pdf->SetXY($left_margin+550, $posY+5);
$pdf->Cell(40, 10,'印', '0', '1', 'C','0');
$left_margin = 24;
$pdf->SetFont(GOTHIC,'', 5);
$pdf->SetXY($left_margin+31, $posY+4);
$pdf->Cell(25, 8,'取引銀行', '0', '1', 'C','0');
$pdf->SetXY($left_margin+56, $posY+4);
$pdf->Cell(115, 8,$c_memo[0][4], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+4);
$pdf->Cell(115, 8,$c_memo[0][5], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+12);
$pdf->Cell(115, 8,$c_memo[0][6], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+12);
$pdf->Cell(115, 8,$c_memo[0][7], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+20);
$pdf->Cell(115, 8,$c_memo[0][8], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+20);
$pdf->Cell(115, 8,$c_memo[0][9], '0', '1', 'L','0');
$pdf->SetXY($left_margin+56, $posY+28);
$pdf->Cell(115, 8,$c_memo[0][10], '0', '1', 'L','0');
$pdf->SetXY($left_margin+286, $posY+28);
$pdf->Cell(115, 8,$c_memo[0][11], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+56, $posY+39);
$pdf->Cell(210, 8,$c_memo[0][12], '0', '1', 'L','0');

$pdf->Output();
?>
