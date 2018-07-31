<?php
require('../../fpdf/mbfpdf.php');

//基準点
$xx = 10;
$yy = 10;

//縦書き、mm基準、A4サイズ
$pdf=new MBFPDF('P','mm','A4');

//フォント設定
$pdf->AddMBFont(GOTHIC,'SJIS');
$pdf->AddMBfont(PGOTHIC,'SJIS');
$pdf->AddMBfont(MINCHO,'SJIS');
$pdf->AddMBfont(PMINCHO,'SJIS');
$pdf->Open();

//配列設定
$bill = array("","","","","","","","","","","","","");

//表示する桁数設定
$keta = 35;

//ページ数
$maxpage = 2;

//青と緑をセットで繰り返す
for($k=0;$k<2;$k++){
//ページ作成
$pdf->AddPage();

//改ページ設定
$pdf->SetAutoPageBreak(false);

//ページ数
for($j=0;$j<$maxpage;$j++){

/* ココからヘッダと思われる部分 */
//お客様のコード、住所、会社名
$pdf->SetFont('MS-Gothic','',8);
$pdf->SetXY($xx,$yy);
if($k % 2 == 0){//１枚目の青い請求書の場合}//１枚目の青い請求書の場合
    $pdf->SetTextColor(77,66,177);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
$pdf->Write(8,"お客様コード");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(8,"");
$pdf->SetFontSize(10);
if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetTextColor(77,66,177);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
$pdf->Write(7,"\n〒");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(7,"\n");
$pdf->SetX($xx+2);
$pdf->Cell(40,5,"",0,2);
$pdf->Cell(40,5,"");
$pdf->SetX($xx+7);
$pdf->SetFontSize(12);
$pdf->Cell(45,20,"　　　　　　　　　　御中");

//中央の"請求書"表示
$pdf->SetFont('','B',18);//太字、18ポイントに設定
if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetTextColor(77,66,177);//フォントを青に設定
}else{//２枚目の緑の場合
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
$pdf->SetXY(0,$yy);
$pdf->Cell(209.97,16,"請 求 書",0,1,"C");//横幅いっぱいのセルに中央揃え
$pdf->SetLineWidth(0.1);//ラインの太さを0.1mmに設定
if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetDrawColor(77,66,177);//線の色を青に設定
}else{//２枚目の緑
    $pdf->SetDrawColor(18,133,25);//線の色を緑に設定
}
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
$pdf->Cell(204,8,"",0,1,"R");//横幅いっぱいのセルに右揃え

//中央の黒字の日付部分表示
$pdf->SetXY(0,$yy+20);
$pdf->Cell(209.97,8,"  　　  　　  　　　　",0,1,"C");//中央揃え

//会社ロゴ表示
$pdf->Image("../../image/company-rogo_clear.png",$xx+140,$yy+9,25);
if($k % 2 != 0){
    //社印表示
    $pdf->Image("../../image/shain.png",$xx+165,$yy+17,20);
}
//会社名表示
if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetTextColor(77,66,177);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
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
$pdf->SetXY(0,$yy+42);
$pdf->Cell(203,8,"下記の通り御請求申し上げます",0,1,"R");//右揃え

//得意先コード表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->SetXY($xx,$yy+42);
$pdf->Cell(100,8,"             　　　　　　　　　　　様分",0,1,"R");//左揃え

if($k % 2  ==0){//１枚目の青い請求書の場合
    $pdf->SetTextColor(0,0,135);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
$pdf->SetFontSize(9);//フォントを9ポイントに設定
$cellname = array("前回御請求額","今回御購入金額","繰越残高額","今回御買上額","今回消費税額","税込御買上額","今回御請求額","5月御支払額");
//請求額欄の表示
for($i=0;$i<8;$i++){
    $op = 0;
    if($i<6){
        if($k % 2  ==0){//１枚目の青い請求書の場合{
            $pdf->SetFillColor(204,230,255);//塗りつぶしの色を設定（薄い水色）
            $pdf->SetDrawColor(0,0,0);//線の色を黒に設定
        }else{//２枚目の緑
            $pdf->SetFillColor(198,246,195);//塗りつぶしの色を設定（薄い緑色）
            }
    }else{
        if($k % 2  ==0){//１枚目の青い請求書の場合{
            $pdf->SetFillColor(77,66,177);//塗りつぶしの色を設定（青)
            $pdf->SetDrawColor(77,66,177);//線の色を青に設定
        }else{//２枚目の緑
            $pdf->SetFillColor(18,133,25);//塗りつぶしの色を設定（緑）
        }
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

/*　ココからテーブル　*/
//テーブルのヘッダ部表示
$pdf->SetDrawColor(0,0,0);//線の色を黒に設定
if($k % 2  ==0){//１枚目の青い請求書の場合{
    $pdf->SetFillColor(204,230,255);//塗りつぶしの色を設定（薄い水色）
    $pdf->SetTextColor(0,0,135);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetFillColor(198,246,195);//塗りつぶしの色を設定（薄い水色）
    $pdf->SetTextColor(18,133,25);//フォントを青に設定
}
$pdf->RoundedRect($xx,$yy+73,18,8,2.5,'DF',1);//左上が丸いセル
$pdf->SetXY($xx,$yy+73);//↑の隣に位置指定
$pdf->Cell(16,8,"月　日",0,0,'C');//月日セル
$pdf->Cell(15,8,"伝票番号",1,0,'C',1);//伝票番号セル
$pdf->MultiCell(9,4,"取引\n区分",1,"C",1);//区分セル
$pdf->SetXY($xx+40,$yy+73);//↑の隣に位置指定
$pdf->Cell(80,8,"商　　品　　名",1,0,'C',1);//商品名セル
$pdf->Cell(12,8,"数　量",1,0,'C',1);//数量セル
$pdf->Cell(10,8,"単位",1,0,'C',1);//単位セル
$pdf->Cell(16,8,"単　価",1,0,'C',1);//単価セル
$pdf->Cell(12,8,"金　額",1,0,'C',1);//金額セル
$pdf->Cell(10,8,"税区分",1,0,'C',1);//税区分セル
$pdf->RoundedRect($xx+180,$yy+73,13,8,2.5,'DF',2);//右上が丸いセル
$pdf->Cell(13,8,"入　金",0,0,'C');//入金セル

$pdf->SetXY($xx,$yy+81);//下の行に位置指定
$celco = 0;//塗りつぶしの色　0:白　1:水色

$tabxx = $xx;//テーブルの左端
$tabyy = $yy+81;//テーブルの上端
//下のforでテーブルの枠を表示
for($i=0;$i<$keta;$i++){//$keta回繰り返し
    if($celco ==0){//色変数が0の場合
        $pdf->SetFillColor(255,255,255);//白に塗りつぶし
        $celco=1;//次は水色
    }else{
        if($k % 2  ==0){//１枚目の青い請求書の場合
            $pdf->SetFillColor(232,240,255);//薄い水色に塗りつぶし
        }else{//２枚目の緑
            $pdf->SetFillColor(230,255,230);//薄い緑色に塗りつぶし
        }
        $celco=0;//次は白
    }
    if($i==$keta-1){//最後の行は端のセルを丸くする
        $pdf->RoundedRect($xx,$tabyy,16,5,2.5,'DF',4);//月日
        $pdf->SetXY($xx+16,$tabyy);
        $pdf->Cell(15,5,"",1,0,'C',1);//伝票番号
        $pdf->Cell(9,5,"",1,0,"C",1);//取引区分
        $pdf->Cell(80,5,"",1,0,'C',1);//商品名
        $pdf->Cell(12,5,"",1,0,'C',1);//数量
        $pdf->Cell(10,5,"",1,0,'C',1);//単位
        $pdf->Cell(16,5,"",1,0,'C',1);//単価
        $pdf->Cell(12,5,"",1,0,'C',1);//金額
        $pdf->Cell(10,5,"",1,0,'C',1);//税区分
        $pdf->RoundedRect($xx+180,$tabyy,13,5,2.5,'DF',3);//入金
    }else{
        $pdf->Cell(16,5,"",1,0,'C',1);//月日
        $pdf->Cell(15,5,"",1,0,'C',1);//伝票番号
        $pdf->Cell(9,5,"",1,0,"C",1);//取引区分
        $pdf->Cell(80,5,"",1,0,'C',1);//商品名
        $pdf->Cell(12,5,"",1,0,'C',1);//数量
        $pdf->Cell(10,5,"",1,0,'C',1);//単位
        $pdf->Cell(16,5,"",1,0,'C',1);//単価
        $pdf->Cell(12,5,"",1,0,'C',1);//金額
        $pdf->Cell(10,5,"",1,0,'C',1);//税区分
        $pdf->Cell(13,5,"",1,0,'C',1);//入金
    }
    //点線を設定
    $pdf->SetDash(0.5,0.5);
    //数量セルの点線
    $pdf->Line(134,$tabyy,134,$tabyy+5);
    $pdf->Line(138,$tabyy,138,$tabyy+5);
    //単価セルの点線
    $pdf->Line(157,$tabyy,157,$tabyy+5);
    $pdf->Line(161,$tabyy,161,$tabyy+5);
    //金額セルの点線
    $pdf->Line(172,$tabyy,172,$tabyy+5);
    $pdf->Line(176,$tabyy,176,$tabyy+5);
    //入金セルの点線
    $pdf->Line(194.5,$tabyy,194.5,$tabyy+5);
    $pdf->Line(199,$tabyy,199,$tabyy+5);

    //点線を解除
    $pdf->SetDash();
    //単価セルの直線
    $pdf->Line(165,$tabyy,165,$tabyy+5);

    $tabyy += 5;//行の高さを足す
    $pdf->SetXY($tabxx,$tabyy);//次の行へ位置を設定
}
/*　ココまでがテーブル　*/


/*　ココからフッタと思われる部分　*/
$pdf->SetXY($xx,$tabyy+2);
$pdf->SetFontSize(6);
if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetTextColor(77,66,177);//フォントを青に設定
}else{//２枚目の緑
    $pdf->SetTextColor(18,133,25);//フォントを緑に設定
}
$pdf->Write(3,"取引銀行　");
$pdf->SetXY($xx+11,$tabyy+10);
$pdf->Cell(75,3,$bill[4],0);
$pdf->Cell(35,3,$bill[5]);
$pdf->SetXY($xx+11,$tabyy+13);
$pdf->Cell(75,3,$bill[6],0);
$pdf->Cell(35,3,$bill[7]);
$pdf->SetXY($xx+11,$tabyy+16);
$pdf->Cell(75,3,$bill[8],0);
$pdf->Cell(35,3,$bill[9]);
$pdf->SetXY($xx+11,$tabyy+19);
$pdf->Cell(75,3,$bill[10],0);
$pdf->Cell(35,3,$bill[11]);
$pdf->SetXY($xx+11,$tabyy+22);
$pdf->SetFontSize(8);
$pdf->Cell(150,6,$bill[12]);

if($k % 2 == 0){//１枚目の青い請求書の場合
    $pdf->SetFillColor(204,230,255);
}else{//２枚目の緑
    $pdf->SetFillColor(198,246,195);
}
$pdf->RoundedRect($xx+150-1,$tabyy+2,4,15,1.5,'DF',14);
$pdf->SetXY($xx+150-1,$tabyy+3);
$pdf->MultiCell(4,2.5,"担\n当\n者",0,'C');
$pdf->RoundedRect($xx+150+4-1,$tabyy+2,25,15,1.5,'',23);
$pdf->RoundedRect($xx+150+4+25-1,$tabyy+2,15,4,1.5,'DF',12);
$pdf->SetXY($xx+150+4+25-1,$tabyy+2);
$pdf->Cell(15,4,"印",0,0,'C');
$pdf->RoundedRect($xx+150+4+25-1,$tabyy+2+4,15,11,1.5,'',34);
/*　ココまでがフッタと思われる部分　*/
}
}

//一行を表示させるメソッド
//月日、伝票番号、取引区分、商品名、商品名表示位置、数量、単位、単価、金額、税区分、入金、行番号
function RecWrite($md,$num,$kub,$name,$lrc,$amo,$unit,$uprice,$price,$zkub,$reci,$gyo,$pdf){
    $colyy = 91+($gyo-1)*5;//テーブルの最上部から計算（一行5mm）
    $pdf->SetXY(10,$colyy);//位置設定
    $pdf->Cell(16,5,$md,0,0,'C');//月日
    $pdf->Cell(15,5,$num,0,0,'C');//伝票番号
    $pdf->Cell(9,5,$kub,0,0,'C');//取引区分
    $pdf->Cell(80,5,$name,0,0,$lrc);//商品名
    $pdf->Cell(12,5,$amo,0,0,'R');//数量
    $pdf->Cell(10,5,$unit,0,0,'C');//単位
    $pdf->Cell(14,5,$uprice,0,0,'R');//単価
    $pdf->Cell(14,5,$price,0,0,'R');//金額
    $pdf->Cell(10,5,$zkub,0,0,'C');//税区分
    $pdf->Cell(13,5,$reci,0,0,'R');//入金
}


$pdf->Output();
?>
