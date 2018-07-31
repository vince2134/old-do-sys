<?php
require("../../fpdf/mbfpdf.php");
$GLOBALS['EUC2SJIS'] = true;//日本語が正常にPDF出力できる

// fpdfクラスのインスタンスを生成します
$pdf=new MBFPDF();

//フォント設定
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(PGOTHIC,'SJIS');
//$pdf->AddMiBFont(MINCHO ,'SJIS');
$pdf->AddMBFont(PMINCHO,'SJIS');
$pdf->AddMBFont(KOZMIN ,'SJIS');

// pdf ファイルを新規作成します
$pdf->Open();

// fpdfに新規ページ（１ページ目）を作成します
$pdf->AddPage();

//基準点
$x2=10;
$y2=10;

//お客様コード
$pdf->SetFont(PGOTHIC,'',8);
$pdf->SetTextColor(0,0,153);//フォントを青に設定する
$pdf->SetXY($x2,$y2);
$pdf->Write(5,"お客様コード");

//コード番号
$pdf->SetTextColor(0,0,0);//フォントを黒に設定する
$pdf->SetXY($x2+18,$y2);
$pdf->Write(5,"000107-0000");

//〒
$pdf->SetFont(PGOTHIC,'',10);
$pdf->SetTextColor(0,0,153);//フォントを青に設定する
$pdf->SetXY($x2,$y2+6);
$pdf->Write(5,"〒");

//〒番号
$pdf->SetTextColor(0,0,0);//フォントを黒に設定する
$pdf->SetXY($x2+3,$y2+6);
$pdf->Write(5,"221-0835");

//場所
$pdf->SetXY($x2,$y2+10);
$pdf->Write(5,"神奈川県横浜市神奈川区");
$pdf->SetXY($x2,$y2+14);
$pdf->Write(5,"鶴屋町2-16-4");

//会社名
$pdf->SetXY($x2,$y2+22);
$pdf->Write(5,"株式会社エフテム　御中");

//請求書
$pdf->SetFont(PGOTHIC,'B',14);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->SetXY(0,$y2);
$pdf->Cell(209.97,16,"請 求 書",0,1,"C");//横幅いっぱいのセルに中央揃い
$pdf->SetLineWidth(0.2);//線の太さを0.2mmに設定
$pdf->SetDrawColor(0,0,153);//線の色を青に設定
$pdf->Line($x2+83,$y2+11,$x2+106,$y2+11);//線を表示
$pdf->Line($x2+83,$y2+11.6,$x2+106,$y2+11.6);

//年月日表示
$pdf->SetFont(PGOTHIC,'',10);
$pdf->SetXY(0,$y2+18);
$pdf->Cell(209.97,8,"　　年　　月　　日　締切",0,1,"C");//横幅いっぱいのセルに中央揃い

//日付部分表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定する
$pdf->SetXY(0,$y2+18);
$pdf->Cell(209.97,8,"06　　04　　30　　　　",0,1,"C");//中央揃い

//請求番号
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->SetXY($x2+153,$y2);
$pdf->Write(8,"請求番号　");

//番号を表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定する
$pdf->SetXY($x2+168,$y2);
$pdf->Write(8,"00022225-1",0,1,"R");

//アメニティマーク表示
$pdf->Image("../../image/company-rogo_clear.png",$x2+133,$y2+10,26);

//会社名
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->SetFont(PGOTHIC,'B',11);
$pdf->SetXY($x2+133,$y2+14);
$pdf->Write(15,"株式会社　ア　メ　ニ　テ　ィ");

//社長名
$pdf->SetFont(PGOTHIC,'',9);
$pdf->SetXY($x2+135,$y2+22);
$pdf->Write(8,"代表取締役　山　戸　里　志");

//会社場所
$pdf->SetFont(PGOTHIC,'',6);
$pdf->SetXY($x2+140,$y2+26);
$pdf->Write(6,"〒221-0863 横 浜 市 神 奈 川 区 羽 沢 町 685");

//電話番号
$pdf->SetXY($x2+140,$y2+29);
$pdf->Write(6,"ＴＥＬ 045-371-7676　ＦＡＸ 045-371-7717");

//請求項目
$pdf->SetFont(PGOTHIC,'',9);
$pdf->SetXY($x2+136,$y2+38);
$pdf->Write(8,"下記の通りに御請申し上げます。");

//前回御請求額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2,$y2+46.5);
$pdf->Cell(23,5,"前回御請求額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2,$y2+51);
$pdf->Cell(23,10,"10,500",0,1,"R");

//今回御入金額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2+23,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+23,$y2+46.5);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->Cell(23,5,"今回御入金額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+23,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+23,$y2+51);
$pdf->Cell(23,10,"10,500",0,1,"R");

//繰越残高額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2+46,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+46,$y2+46.5);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->Cell(23,5,"繰越残高額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+46,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+46,$y2+51);
$pdf->Cell(23,10,"0",0,1,"R");

//今回御買上額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2+69,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+69,$y2+46.5);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->Cell(23,5,"今回御買上額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+69,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+69,$y2+51);
$pdf->Cell(23,10,"10,000",0,1,"R");

//今回消費税額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2+92,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+92,$y2+46.5);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->Cell(23,5,"今回消費税額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+92,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+92,$y2+51);
$pdf->Cell(23,10,"500",0,1,"R");

//税込御買上額
$pdf->SetFillColor(220,235,255);//セルの背景は薄水色を設定する
$pdf->SetDrawColor(0,0,0);//枠線の色を黒に設定
$pdf->RoundedRect($x2+115,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+115,$y2+46.5);
$pdf->SetTextColor(0,0,153);//フォントを青に設定
$pdf->Cell(23,5,"税込御買上額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+115,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+115,$y2+51);
$pdf->Cell(23,10,"10,500",0,1,"R");

//今回御請求額
$pdf->SetFillColor(0,0,153);//セルの背景は青に設定する
$pdf->SetDrawColor(0,0,153);//枠線の色を青に設定
$pdf->SetTextColor(255,255,255);//フォントを白に設定
$pdf->RoundedRect($x2+138,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+138,$y2+46.5);
$pdf->Cell(23,5,"今回御請求額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+138,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+138,$y2+51);
$pdf->Cell(23,10,"10,000",0,1,"R");

//5月御支払額
$pdf->SetFillColor(0,0,153);//セルの背景は青に設定する
$pdf->SetDrawColor(0,0,153);//枠線の色を青に設定
$pdf->SetTextColor(255,255,255);//フォントを白に設定
$pdf->RoundedRect($x2+161,$y2+46,23,5,2,'DF','12');//角の丸いセルを描画
$pdf->SetXY($x2+161,$y2+46.5);
$pdf->Cell(23,5,"5月御支払額",0,1,'C');
$pdf->SetFillcolor(255,255,255);
$pdf->RoundedRect($x2+161,$y2+51,23,10,2,'',34);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY($x2+161,$y2+51);
$pdf->Cell(23,10,"10,000",0,1,"R");

//灰色の文字列部分
$pdf->SetFont(PGOTHIC,'',9);
$pdf->SetTextColor(160);//フォントを灰色に設定する
$pdf->SetXY($x2+2,$y2+61);
$pdf->Write(8,"今回分割請求額　0　　　　　　　　　　分割残高　0　　　　　　　　　　調整額　0");

//基準点
$x=10;
$y=79;

//得意先セル
$pdf->SetFillColor(175,210,255);//セルの背景を青に設定する
$pdf->SetFont(PGOTHIC,'',8);
$pdf->SetXY($x,$y);
$pdf->SetDrawColor(0,0,153);//枠線を青に設定する
$pdf->SetLineWidth(0.2);//線の太さを0.2mmに設定
$pdf->SetTextColor(0,0,153);//フォントを青に設定する
$pdf->Cell(125,5,"得意先",1,"0","C",1);

//今回御買上額セル
$pdf->SetXY($x+125,$y);
$pdf->Cell(20,5,"今回御買上額",1,"0","C",1);

//今回消費税額セル
$pdf->SetXY($x+145,$y);
$pdf->Cell(20,5,"今回消費税額",1,"0","C",1);

//税込御買上額セル
$pdf->SetXY($x+165,$y);
$pdf->Cell(20,5,"税込御買上額",1,"0","C",1);

//得意先セル1
$pdf->SetXY($x,$y+5);
$pdf->SetFillColor(255,255,255);//セルの背景色を白に設定する
$pdf->SetFont(PGOTHIC,'',8);
$pdf->SetTextColor(0,0,0);//フォントを黒に設定する
$pdf->MultiCell(125,3.5,"000107-0005\n株式会社エフテム　浪漫茶房あんだんて",1,"L",1);

//今回御買上額セル1
$pdf->SetXY($x+125,$y+5);
$pdf->Cell(20,7,"5,000",1,"0","R",1);

//今回消費税額セル1
$pdf->SetXY($x+145,$y+5);
$pdf->Cell(20,7,"250",1,"0","R",1);

//税込御買上額セル1
$pdf->SetXY($x+165,$y+5);
$pdf->Cell(20,7,"5,250",1,"0","R",1);

//得意先セル2
$pdf->SetXY($x,$y+12);
$pdf->SetFillColor(220,235,255);//セルの背景色を薄い水色に設定する
$pdf->MultiCell(125,3.5,"000107-0005\n株式会社エフテム　創作料理あんだんて",1,"L",1);

//今回御買上額セル2
$pdf->SetXY($x+125,$y+12);
$pdf->SetFillColor(230,240,255);//セルの背景色を薄い水色に設定する
$pdf->Cell(20,7,"5,000",1,"0","R",1);

//今回消費税額セル1
$pdf->SetXY($x+145,$y+12);
$pdf->SetFillColor(220,235,255); //セルの背景色を薄い水色に設定する
$pdf->Cell(20,7,"250",1,"0","R",1);

//税込御買上額セル2
$pdf->SetXY($x+165,$y+12);
$pdf->SetFillColor(230,240,255);//セルの背景色を薄い水色に設定する
$pdf->Cell(20,7,"5,250",1,"0","R",1);

for($i=1;$i<=5;$i++){
    //得意先セル3
    $pdf->SetXY($x,$y+19);
    $pdf->SetFillColor(255,255,255);//セルの背景色を白に設定する
    $pdf->MultiCell(125,7,"",1,"L",1);
    
    //今回御買上額セル3
    $pdf->SetXY($x+125,$y+19);
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //今回御消費税額セル3
    $pdf->SetXY($x+145,$y+19);
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //税込御買上額セル3
    $pdf->SetXY($x+165,$y+19);
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //得意先セル4
    $pdf->SetXY($x,$y+26);
    $pdf->SetFillColor(220,235,255); //セルの背景色を薄い水色に設定する
    $pdf->MultiCell(125,7,"",1,"L",1);
    
    //今回御買上額セル4
    $pdf->SetXY($x+125,$y+26);
    $pdf->SetFillColor(230,240,255);//セルの背景色を薄い水色に設定する
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //今回御消費税額セル4
    $pdf->SetXY($x+145,$y+26);
    $pdf->SetFillColor(220,235,255);//セルの背景色を薄い水色に設定する
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //税込御買上額セル4
    $pdf->SetXY($x+165,$y+26);
    $pdf->SetFillColor(230,240,255);//セルの背景色を薄い水色に設定する
    $pdf->Cell(20,7,"",1,"0","R",1);
    
    //税込御買上額セル4
    $pdf->SetXY($x+165,$y+26);
    $pdf->SetFillColor(230,240,255);//セルの背景色を薄い水色に設定する
    $pdf->Cell(20,7,"",1,"0","R",1);
    if($y=$y+14){
    }
}

//取引銀行セル
//基準点
$x1=10;
$y1=172;
$pdf->SetFont(PGOTHIC,'',5);
$pdf->SetXY($x1,$y1);
$pdf->SetTextColor(0,0,153);//フォントを青に設定する
$pdf->Write(3,"取引銀行");

//みずほ銀行セル
$pdf->SetXY($x1+9,$y1);
$pdf->Write(3,"みずほ銀行　横浜西口支店　　　　当座預金　0119440");

//東京三菱銀行セル
$pdf->SetXY($x1+9,$y1+3);
$pdf->Write(3,"東京三菱銀行　新横浜支店　　　　当座預金　0026954");

//商工中金セル
$pdf->SetXY($x1+9,$y1+6);
$pdf->Write(3,"商工中金　横浜西口支店　　　　　当座預金　1008871");

//西日本シティ銀行セル
$pdf->SetXY($x1+9,$y1+9);
$pdf->Write(3,"西日本シティ銀行　本店　営業部　当座預金　0026954");

//"みずほ銀行セル
$pdf->SetXY($x1+78,$y1);
$pdf->Write(3,"みずほ銀行　横浜駅前支店　　　　当座預金　0029343");

//横浜銀行セル
$pdf->SetXY($x1+78,$y1+3);
$pdf->Write(3,"横浜銀行　西谷支店　　　　　　　当座預金　100961");

//横浜信用金庫セル
$pdf->SetXY($x1+78,$y1+6);
$pdf->Write(3,"横浜信用金庫　西谷支店　　　　　当座預金　000514");

//※セル
$pdf->SetFont(PGOTHIC,'',7);
$pdf->SetXY($x1+9,$y1+12);
$pdf->Write(5,"※　振り込み手数料は誠に申し訳ございませんが、貴社にてご負担下さるようにお願い致します。");

//担当者セル
$pdf->SetFillColor(220,235,255);//セルの背景色を薄い水色に設定する
$pdf->SetDrawColor(0,0,0);//線の色を黒に設定
$pdf->SetLineWidth(0.1);//線の太さを0.1mmに設定
$pdf->RoundedRect($x1+143,$y1,4,14,2,'DF',14);//角の丸いセルを描画
$pdf->SetXY($x1+143,$y1);
$pdf->multiCell(4,2," 担\n当\n者",0,1,'C');
$pdf->SetFillColor(255,255,255);//セルの背景色を白に設定する
$pdf->RoundedRect($x1+147,$y1,24,14,2,'',23);

//印セル
$pdf->SetFillColor(220,235,255);//セルの背景色を薄い水色に設定する
$pdf->RoundedRect($x1+171,$y1,14,3,2,'DF',12);//角の丸いセルを描画
$pdf->SetXY($x1+171,$y1);
$pdf->Cell(14,3,"印",0,1,'C');
$pdf->SetFillColor(255,255,255);//セルの背景色を白に設定する
$pdf->RoundedRect($x1+171,$y1+3,14,11,2,'',34);

$pdf->Output();
?>





