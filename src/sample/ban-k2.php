<?php
require("../../fpdf/mbfpdf.php");

class PDF extends MBFPDF
{
    function DashedRect($x1,$y1,$x2,$y2,$width=1,$nb=15)
    {
        $this->SetLineWidth($width);
        $longueur=abs($x1-$x2);
        $hauteur=abs($y1-$y2);
        if($longueur>$hauteur) {
            $Pointilles=($longueur/$nb)/2; // length of dashes
        }
        else {
            $Pointilles=($hauteur/$nb)/2;
        }
        for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$y1,$j+1,$y1); // upper dashes
                    $this->Line($j,$y2,$j+1,$y2); // lower dashes
                }
            }
        }
        for($i=$y1;$i<=$y2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($y2-1)) {
                    $this->Line($x1,$j,$x1,$j+1); // left dashes
                    $this->Line($x2,$j,$x2,$j+1); // right dashes
                }
            }
        }
    }
}

//日本語が正常にPDF出力できる
$GLOBALS['EUC2SJIS'] = true;

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

//合計請求書
$pdf->SetFillColor(255,255,255);//セル背景の色は白に設定する
$pdf->setfont(PGOTHIC,"B",9);
$pdf->SetLineWidth(0.5);//枠線の太さを0.5mmに設定
$pdf->RoundedRect(5,5,30,5,2.8,"DF");//丸い角のセルを作る
$pdf->SetXY(11,5);
$pdf->Write(5,"合計請求書");

//基準点を設定
$xx=10;
$yy=15;

//配列設定
$bill = array("株式会社  ア メ ニ テ ィ","代表取締役　山 　戸 　里 　志","〒221-0863 横 浜 市 神
奈 川 区 羽 沢 町 685","ＴＥＬ 045-371-7676   ＦＡＸ 045-371-7717");

/* ココからヘッダと思われる部分 */
$pdf->SetDrawColor(255,0,0);
$pdf->DashedRect($xx,$yy,$xx+42,$yy+30,2);
//お客様のコード、住所、会社名
$pdf->SetFont('MS-Gothic','',8);
$pdf->SetXY($xx,$yy);
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->Write(8,"お客様コード");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(8,"000023-0000");
$pdf->SetFont('','',10);
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->Write(10,"\n〒");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(10,"108-0072\n");
$pdf->Write(0,"  東京都港区白金1-15-25\n");
$pdf->Write(16,"  株式会社美掃舎　御中");

//中央の"請求書"表示
$pdf->SetFont('','B',18);//太字、18ポイントに設定
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->SetXY(0,$yy);
$pdf->Cell(209.97,16,"請 求 書",0,1,"C");//横幅いっぱいのセルに中央揃え
$pdf->SetLineWidth(0.1);//ラインの太さを0.1mmに設定
$pdf->SetDrawColor(77,66,177);//線の色を青に設定
$pdf->Line($xx+81,$yy+12,$xx+108,$yy+12);//ライン表示
$pdf->Line($xx+81,$yy+12.5,$xx+108,$yy+12.5);//0.5mmあけてもう一本表示
$pdf->SetLineWidth(0.2);

//中央の青字だけ表示
$pdf->SetFontSize(8);//フォントサイズを8ポイントに設定
$pdf->SetXY(0,$yy+20);
$pdf->Cell(209.97,8,"　　年　　月　　日　締切",0,1,"C");//横幅いっぱいのセルに中央揃え

//"請求番号"を表示
$pdf->SetXY($xx+165,$yy);
$pdf->Write(8,"請求番号　");
//番号を表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->SetXY(0,$yy);
$pdf->Cell(204,8,"00022225-1",0,1,"R");//横幅いっぱいのセルに右揃え

//中央の黒字の日付部分表示
$pdf->SetXY(0,$yy+20);
$pdf->Cell(209.97,8,"06　　04　　30　　　　",0,1,"C");//中央揃え
//会社ロゴ表示
$pdf->Image("../../image/company-rogo_clear.png",145,19,30);

//会社名表示
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->SetFont('','B','12');//フォントを太字・12ポイントに設定
$pdf->SetXY(0,$yy+17);
$pdf->Cell(204,12,$bill[0],0,1,"R");//右揃え

//代表名表示
$pdf->SetFont('MS-PMincho','',9);//フォントをMS−P明朝体、9ポイントに設定
$pdf->SetXY(0,$yy+25);
$pdf->Cell(203,9,$bill[1],0,1,"R");//右揃え
$pdf->SetFont('MS-PGothic','',6);//フォントをMS-Pゴシック体、6ポイントに設定
//住所、電話番号表示
$pdf->SetXY(0,$yy+30.5);
$pdf->Cell(203,6,$bill[2],0,1,"R");//右揃え
$pdf->SetXY(0,$yy+34);
$pdf->Cell(203,6,$bill[3],0,1,"R");//右揃え

//請求文表示
$pdf->SetFontSize(8);//フォントを8ポイントに設定
$pdf->SetXY(0,$yy+43);
$pdf->Cell(203,8,"下記の通り御請求申し上げます",0,1,"R");//右揃え

//得意先コード表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->SetXY($xx,$yy+43);
$pdf->Cell(100,8,"000023-0000  株式会社美掃舎　様分",0,1,"L");//左揃え

$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->SetFontSize(9);//フォントを9ポイントに設定
$cellname = array("前回御請求額","今回御購入金額","繰越残高額","今回御買上額","今回消費税額","税込御買上額","今回御請求額","5月御支払額");
//請求額欄の表示
for($i=0;$i<8;$i++){
    $op = 0;
    if($i<6){
        $pdf->SetFillColor(204,230,255);//塗りつぶしの色を設定（薄い水色）
        $pdf->SetDrawColor(0,0,0);//線の色を黒に設定
    }else{
        $pdf->SetFillColor(77,66,177);//塗りつぶしの色を設定（青）
        $pdf->SetDrawColor(77,66,177);//線の色を青に設定
        $pdf->SetTextColor(255,255,255);//フォントを白に設定
    }
    if($i == 7){
        $op = 1;
    }
    $pdf->RoundedRect($xx+($i*24)+$op,$yy+50,24,5,2,'DF','12');//上の角が丸いセルを描画
    $pdf->SetXY($xx+($i*24)+$op,$yy+50.5);//セル位置の微調整
    $pdf->Cell(24,5,$cellname[$i],0,1,'C');//中央表示//中央表示
    $pdf->SetFillcolor(255,255,255);//塗りつぶしの色を設定（白）
    $pdf->RoundedRect($xx+($i*24)+$op,$yy+55,24,10,2,'',34);//下が丸い長方形を描画
}

$pdf->SetTextColor(180);//フォントを灰色に設定
$pdf->SetXY($xx+2,$yy+66);
$pdf->Cell(150,5,"今回分割請求額 　0　　　　分割残高 　0　　　　調整額　 0　　　　前受金　0",0);

/*　ココまでがヘッダーと思われる部分　*/
$pdf->Output();
