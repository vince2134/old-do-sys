<?php
require('../../fpdf/mbfpdf.php');

//角が丸い四角を作るメソッドを実装・・・？
class PDF extends MBFPDF
{
    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
    function SetDash($black=false,$white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
}

//基準点
$xx = 10;
$yy = 10;

//縦書き、mm基準、A4サイズ
$pdf=new PDF('P','mm','A4');

//フォント設定
$pdf->AddMBFont(GOTHIC,'SJIS');
$pdf->AddMBfont(PGOTHIC,'SJIS');
$pdf->AddMBfont(MINCHO,'SJIS');
$pdf->AddMBfont(PMINCHO,'SJIS');
$pdf->Open();
//ページ作成
$pdf->AddPage();

//配列設定
$bill = array("株式会社  ア メ ニ テ ィ",
            "代表取締役　山 　戸 　里 　志",
            "〒221-0863 横 浜 市 神 奈 川 区 羽 沢 町 685",
            "ＴＥＬ 045-371-7676   ＦＡＸ 045-371-7717",
            "みずほ銀行　横浜西口支店　　　　　当座預金　0119440",
            "みずほ銀行　横浜駅前支店　　　　　当座預金　0029343",
            "東京三菱銀行　新横浜支店　　　　　当座預金　0026954",
            "横浜銀行　西谷支店　　　　　 　　 当座預金　100961",
            "商工中金　横浜西口支店　　 　 　　当座預金　1008871",
            "横浜信用金庫　西谷支店　　　　　  当座預金　000514",
            "西日本シティ銀行　本店　営業部　　当座預金　1858967",
            "",
            "※　振込み手数料は誠に申し訳ございませんが、貴社にて御負担下さるようお願い致します。
");

/* ココからヘッダと思われる部分 */
//お客様のコード、住所、会社名
$pdf->SetFont('MS-Gothic','',8);
$pdf->SetXY($xx,$yy);
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->Write(8,"お客様コード");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(8,"000000-0000");
$pdf->SetFontSize(10);
$pdf->SetTextColor(77,66,177);//フォントを青に設定
$pdf->Write(10,"\n〒");
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->Write(10,"***-****\n");
$pdf->SetX($xx+2);
$pdf->Write(0,"住所\n");
$pdf->SetX($xx+5);
$pdf->SetFontSize(11);
$pdf->Write(16,"株式会社○○　御中");

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
$pdf->Image("../../image/company-rogo_clear.png",$xx+140,$yy+9,30);

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
$pdf->SetXY(0,$yy+42);
$pdf->Cell(203,8,"下記の通り御請求申し上げます",0,1,"R");//右揃え

//得意先コード表示
$pdf->SetTextColor(0,0,0);//フォントを黒に設定
$pdf->SetXY($xx,$yy+42);
$pdf->Cell(100,8,"000000-0000  株式会社○○　様分",0,1,"L");//左揃え

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

/*　ココからテーブル　*/
//テーブルのヘッダ部表示
$pdf->SetDrawColor(0,0,0);//線の色を黒に設定
$pdf->SetFillColor(204,230,255);//塗りつぶしの色を設定（薄い水色）
$pdf->SetTextColor(0,0,135);//フォントを青に設定
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
for($i=0;$i<17;$i++){//とりあえず１７回繰り返し
    if($celco==0){//色変数が0の場合
        $pdf->SetFillColor(255,255,255);//白に塗りつぶし
        $celco=1;//次は水色
    }else{
        $pdf->SetFillColor(235,240,255);//水色に塗りつぶし
        $celco=0;//次は白
    }

    $pdf->Cell(16,6,"",1,0,'C',1);//月日
    $pdf->Cell(15,6,"",1,0,'C',1);//伝票番号
    $pdf->Cell(9,6,"",1,0,"C",1);//取引区分
    $pdf->Cell(80,6,"",1,0,'C',1);//商品名
    $pdf->Cell(12,6,"",1,0,'C',1);//数量
    $pdf->Cell(10,6,"",1,0,'C',1);//単位
    $pdf->Cell(16,6,"",1,0,'C',1);//単価
    $pdf->Cell(12,6,"",1,0,'C',1);//金額
    $pdf->Cell(10,6,"",1,0,'C',1);//税区分
    $pdf->Cell(13,6,"",1,0,'C',1);//入金

    //点線を設定
    $pdf->SetDash(0.5,0.5);
    //数量セルの点線
    $pdf->Line(134,$tabyy,134,$tabyy+6);
    $pdf->Line(138,$tabyy,138,$tabyy+6);
    //単価セルの点線
    $pdf->Line(157,$tabyy,157,$tabyy+6);
    $pdf->Line(161,$tabyy,161,$tabyy+6);
    //金額セルの点線
    $pdf->Line(172,$tabyy,172,$tabyy+6);
    $pdf->Line(176,$tabyy,176,$tabyy+6);
    //入金セルの点線
    $pdf->Line(194.5,$tabyy,194.5,$tabyy+6);
    $pdf->Line(199,$tabyy,199,$tabyy+6);

    //点線を解除
    $pdf->SetDash();
    $pdf->SetLineWidth(0.3);
    //単価セルの直線
    $pdf->Line(165,$tabyy,165,$tabyy+6);
    $pdf->SetLineWidth(0.2);

    $tabyy += 6;//行の高さを足す
    $pdf->SetXY($tabxx,$tabyy);//次の行へ位置を設定
}
//最後の、端が丸い行を表示
if($celco==0){//色変数が0の場合
    $pdf->SetFillColor(255,255,255);//白に塗りつぶし
}else{
    $pdf->SetFillColor(235,240,255);//水色に塗りつぶし
}
$pdf->RoundedRect($xx,$tabyy,16,6,2.5,'DF',4);//月日
$pdf->SetXY($xx+16,$tabyy);
$pdf->Cell(15,6,"",1,0,'C',1);//伝票番号
$pdf->Cell(9,6,"",1,0,"C",1);//取引区分
$pdf->Cell(80,6,"",1,0,'C',1);//商品名
$pdf->Cell(12,6,"",1,0,'C',1);//数量
$pdf->Cell(10,6,"",1,0,'C',1);//単位
$pdf->Cell(16,6,"",1,0,'C',1);//単価
$pdf->Cell(12,6,"",1,0,'C',1);//金額
$pdf->Cell(10,6,"",1,0,'C',1);//税区分
$pdf->RoundedRect($xx+180,$tabyy,13,6,2.5,'DF',3);//入金

//点線を設定
$pdf->SetDash(0.5,0.5);
//数量セルの点線
$pdf->Line(134,$tabyy,134,$tabyy+6);
$pdf->Line(138,$tabyy,138,$tabyy+6);
//単価セルの点線
$pdf->Line(157,$tabyy,157,$tabyy+6);
$pdf->Line(161,$tabyy,161,$tabyy+6);
//金額セルの点線
$pdf->Line(172,$tabyy,172,$tabyy+6);
$pdf->Line(176,$tabyy,176,$tabyy+6);
//入金セルの点線
$pdf->Line(194.5,$tabyy,194.5,$tabyy+6);
$pdf->Line(199,$tabyy,199,$tabyy+6);

//点線を解除
$pdf->SetDash();
$pdf->SetLineWidth(0.3);
//単価セルの直線
$pdf->Line(165,$tabyy,165,$tabyy+6);
$pdf->SetLineWidth(0.2);
//ココまでがテーブル枠組み

//一行を表示させるメソッド
//月日、伝票番号、取引区分、商品名、商品名表示位置、数量、単位、単価、金額、税区分、入金、行番号
function RecWrite($md,$num,$kub,$name,$lrc,$amo,$unit,$uprice,$price,$zkub,$reci,$gyo,$pdf){
    $colyy = 91+($gyo-1)*6;//テーブルの最上部から計算（一行6mm）
    $pdf->SetXY(10,$colyy);//位置設定
    $pdf->Cell(16,6,$md,0,0,'C');//月日
    $pdf->Cell(15,6,$num,0,0,'C');//伝票番号
    $pdf->Cell(9,6,$kub,0,0,'C');//取引区分
    $pdf->Cell(80,6,$name,0,0,$lrc);//商品名
    $pdf->Cell(12,6,$amo,0,0,'R');//数量
    $pdf->Cell(10,6,$unit,0,0,'C');//単位
    $pdf->Cell(14,6,$uprice,0,0,'R');//単価
    $pdf->Cell(14,6,$price,0,0,'R');//金額
    $pdf->Cell(10,6,$zkub,0,0,'C');//税区分
    $pdf->Cell(13,6,$reci,0,0,'R');//入金
}

/*　ココまでがテーブル　*/


/*　ココからフッタと思われる部分　*/
$pdf->SetXY($xx,$tabyy+10);
$pdf->SetTextColor(77,66,177);
$pdf->SetFontSize(6);
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

$pdf->SetFillColor(204,230,255);
$pdf->RoundedRect($xx+150-1,$tabyy+10,4,15,1.5,'DF',14);
$pdf->SetXY($xx+150-1,$tabyy+11);
$pdf->MultiCell(4,2.5,"担\n当\n者",0,'C');
$pdf->RoundedRect($xx+150+4-1,$tabyy+10,25,15,1.5,'',23);
$pdf->RoundedRect($xx+150+4+25-1,$tabyy+10,15,4,1.5,'DF',12);
$pdf->SetXY($xx+150+4+25-1,$tabyy+10);
$pdf->Cell(15,4,"印",0,0,'C');
$pdf->RoundedRect($xx+150+4+25-1,$tabyy+10+4,15,11,1.5,'',34);
/*　ココまでがフッタと思われる部分　*/


$pdf->Output();
?>
