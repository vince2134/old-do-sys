<?php
require("../../fpdf/mbfpdf.php");
//日本語が正常にPDF出力できる
$GLOBALS['EUC2SJIS'] = true;

// fpdfクラスのインスタンスを生成します
$pdf=new MBFPDF();

//フォント設定
$pdf->AddMBFont(GOTHIC,'SJIS');
$pdf->AddMBfont(PGOTHIC,'SJIS');
$pdf->AddMBfont(MINCHO,'SJIS');
$pdf->AddMBfont(PMINCHO,'SJIS');

// pdf ファイルを新規作成します
$pdf->Open();

// fpdfに新規ページ（１ページ目）を作成します
//$pdf->AddPage();

//配列設定
$bill = array("株式会社  ア メ ニ テ ィ",
              "代表取締役　山 　戸 　里 　志",
              "〒221-0863 横 浜 市 神 奈 川 区 羽 沢 町 685",
              "ＴＥＬ 045-371-7676   ＦＡＸ 045-371-7717");

$array=array(
       array("000107-0005","株式会社エフテム　浪漫茶房あんだんて＊＊＊＊＊＊＊","5000","250","5250"),
       array("000107-0005","株式会社エフテム　創作料理あんだんて＊＊＊＊＊＊＊","5000","250","5250") );

$bank = array("取引銀行",
              "みずほ銀行　横浜西口支店　　　　当座預金　0119440",
              "東京三菱銀行　新横浜支店　　　　当座預金　0026954",
              "商工中金　横浜西口支店　　　　　当座預金　1008871",
              "西日本シティ銀行　本店　営業部　当座預金　0026954",
              "みずほ銀行　横浜駅前支店　　　　当座預金　0029343",
              "横浜銀行　西谷支店　　　　　　　当座預金　100961",
              "横浜信用金庫　西谷支店　　　　　当座預金　000514",
              "※　振り込み手数料は誠に申し訳ございませんが、貴社にてご負担下さるようにお願い致します。");

//ページ数
$page = 2;

//青と緑を繰り返す
for($col=0;$col<2;$col++){
    
    //ページ数
    for($p=0;$p<$page;$p++){
        $pdf->AddPage();
        //改ページ設定
        $pdf->SetAutoPageBreak(false);

        //基準点
        $sx = 10;
        $sy = 10;

        /* ココからヘッダと思われる部分 */
        //お客様のコード、住所、会社名
        $pdf->SetFont('MS-Gothic','',8);
        $pdf->SetXY($sx,$sy);
        //1ページの場合
        if($col% 2 == 0){
            $pdf->SetTextColor(77,66,177);                          //フォントを青に設定
        //2ページの場合
        }else{
            $pdf->SetTextColor(18,133,25);                          //フォントを緑に設定
        }
        $pdf->Write(8,"お客様コード");
        $pdf->SetTextColor(0,0,0);                                  //フォントを黒に設定
        $pdf->Write(8,"000107-0000");
        $pdf->SetFont('','',10);
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(77,66,177);                          //フォントを青に設定
        //2ページの場合
        }else{
            $pdf->SetTextColor(18,133,25);                          //フォントを緑に設定
        }
        $pdf->SetFont('MS-Gothic','',7);                            //フォントサイズを7に指定する
        $pdf->Write(6,"\n〒");
        $pdf->SetTextColor(0,0,0);                                 //フォントを黒に設定
        $pdf->Write(6,"108-0072\n");
        $pdf->Write(0,"　神奈川県横浜市神奈川区＊＊＊＊＊＊＊＊＊＊＊＊＊＊\n");
        $pdf->Write(6,"　鶴屋町2-16-4＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊\n");
        $pdf->Write(0,"　＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊\n");
        $pdf->SetFont('MS-Gothic','',9);                            //フォントサイズを9に指定する
 //       $moji="日立＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊";
        $moji="";
        //第二行文字入っている場合
        if($moji != null){
            $pdf->Write(22,"  株式会社エフテム＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊\n");
            $pdf->SetXY($sx+3,$sy+32);
            $pdf->Write(0,  $moji."　御中");
        //第二行文字空白の場合
        }else{
            $pdf->Write(24,"  株式会社エフテム＊＊＊＊＊＊＊＊＊＊＊＊＊＊　御中");
        }

        //中央の"請求書"表示
        $pdf->SetFont('','B',18);                                   //太字、18ポイントに設定
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(77,66,177);                         //フォントを青に設定
        //2ページの場合
        }else{
             $pdf->SetTextColor(18,133,25);                        //フォントを緑に設定
        }
        $pdf->SetXY(0,$sy);
        $pdf->Cell(209.97,16,"請 求 書",0,1,"C");                  //横幅いっぱいのセルに中央揃え
        $pdf->SetLineWidth(0.1);                                   //ラインの太さを0.1mmに設定
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetDrawColor(77,66,177);                         //線の色を青に設定する
        //2ページの場合
        }else{
            $pdf->SetDrawColor(18,133,25);                         //線の色を緑に設定する
        }

        $pdf->Line($sx+81,$sy+12,$sx+108,$sy+12);                  //ライン表示
        $pdf->Line($sx+81,$sy+12.5,$sx+108,$sy+12.5);              //0.5mmあけてもう一本表示
        $pdf->SetLineWidth(0.2);

        //中央の青字だけ表示
        $pdf->SetFontSize(8);                                      //フォントサイズを8ポイントに設定
        $pdf->SetXY(0,$sy+20);
        $pdf->Cell(209.97,8,"　　年　　月　　日　締切",0,1,"C");   //横幅いっぱいのセルに中央揃え

        //"請求番号"を表示
        $pdf->SetXY($sx+165,$sy);
        $pdf->Write(8,"請求番号　");
        //番号を表示
        $pdf->SetTextColor(0,0,0);                                  //フォントを黒に設定
        $pdf->SetXY(0,$sy);
        $num=$p+1;
        $pdf->Cell(204,8,"00022225-$num",0,1,"R");                     //横幅いっぱいのセルに右揃え
    
        //中央の黒字の日付部分表示
        $pdf->SetXY(0,$sy+20);
        $pdf->Cell(209.97,8,"06　　04　　30　　　　",0,1,"C");        //中央揃え
        //会社ロゴ表示
        $pdf->Image("../../image/company-rogo_clear.png",145,19,30);

        //会社名表示
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(77,66,177);                         //フォントを青に設定
        //2ページの場合
        }else{
            $pdf->SetTextColor(0,177,0);                           //フォントを緑に設定
        }
        $pdf->SetFont('','B','12');                                //フォントを太字・12ポイントに設定
        $pdf->SetXY(0,$sy+17);
        $pdf->Cell(204,12,$bill[0],0,1,"R");                       //右揃え

        //代表名表示                         
        $pdf->SetFont('MS-PMincho','',9);                          //フォントをMS−P明朝体、9ポイントに設定
        $pdf->SetXY(0,$sy+25);
        $pdf->Cell(203,9,$bill[1],0,1,"R");                        //右揃え
        $pdf->SetFont('MS-PGothic','',6);                          //フォントをMS-Pゴシック体、6ポイントに設定
        //住所、電話番号表示
        $pdf->SetXY(0,$sy+30.5);
        $pdf->Cell(203,6,$bill[2],0,1,"R");                        //右揃え
        $pdf->SetXY(0,$sy+34);
        $pdf->Cell(203,6,$bill[3],0,1,"R");                        //右揃え

        //請求文表示
        $pdf->SetFontSize(8);                                      //フォントを8ポイントに設定
        $pdf->SetXY(0,$sy+43);
        $pdf->Cell(203,8,"下記の通り御請求申し上げます。",0,1,"R");//右揃え
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(77,66,177);                         //フォントを青に設定
        //2ページの場合
        }else{
            $pdf->SetTextColor(0,177,0);                           //フォントを緑に設定
        }
        $pdf->SetFontSize(9);                                      //フォントを9ポイントに設定
        $cellname = array("前回御請求額","今回御購入金額","繰越残高額","今回御買上額","今回消費税額","税込御買上額","今回御請求額","5月御支払額");
        //請求額欄の表示
        for($i=0;$i<8;$i++){
            $op = 0;//スペースがない
            if($i<6){
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(204,230,255);                //塗りつぶしの色を設定（薄い水色）
                //2ページの場合
                }else{
                    $pdf->SetFillColor(198,246,195);                //塗りつぶしび色を薄い緑に設定
                }  
                $pdf->SetDrawColor(0,0,0);                          //線の色を黒に設定
            }else{
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(77,66,177);                  //塗りつぶしの色を設定（青）
                //2ページの場合 
                }else{         
                    $pdf->SetFillColor(18,133,25);                  //塗りつぶしの色を設定（緑）
                }
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetDrawColor(77,66,177);                  //線の色を青に設定
                //2ページの場合
                }else{
                    $pdf->SetDrawColor(18,133,25);                  //線の色を青に設定
                }
                $pdf->SetTextColor(255,255,255);                    //フォントを白に設定
            }
            if($i == 7){
                $op = 1;                                            //スペースが1
            }
            $pdf->RoundedRect($sx+($i*24)+$op,$sy+50,24,5,2,'DF','12');//上の角が丸いセルを描画
            $pdf->SetXY($sx+($i*24)+$op,$sy+50.5);                  //セル位置の微調整
            $pdf->Cell(24,5,$cellname[$i],0,1,'C');                 //中央表示//中央表示
            $pdf->SetFillcolor(255,255,255);                        //塗りつぶしの色を設定（白）
            $pdf->RoundedRect($sx+($i*24)+$op,$sy+55,24,10,2,'',34);//下が丸い長方形を描画
        }
        //１つめ金額
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($sx,$sy+55);
        $pdf->Cell(24,10,"10,500",0,1,"R");
        //２つめ金額
        $pdf->SetXY($sx+24,$sy+55);
        $pdf->Cell(24,10,"10,500",0,1,"R");
        //３つめ金額
        $pdf->SetXY($sx+48,$sy+55);
        $pdf->Cell(24,10,"0",0,1,"R");
        //４つめ金額
        $pdf->SetXY($sx+72,$sy+55);
        $pdf->Cell(24,10,"10,000",0,1,"R");
        //５つめ金額
        $pdf->SetXY($sx+96,$sy+55);
        $pdf->Cell(24,10,"500",0,1,"R");
        //６つめ金額
        $pdf->SetXY($sx+120,$sy+55);
        $pdf->Cell(24,10,"10,500",0,1,"R");
        //７つめ金額
        $pdf->SetXY($sx+144,$sy+55);
        $pdf->Cell(24,10,"11,000",0,1,"R");
        //８つめ金額
        $pdf->SetXY($sx+169,$sy+55);
        $pdf->Cell(24,10,"11,000",0,1,"R");

        $pdf->SetTextColor(180);                                        //フォントを灰色に設定
        $pdf->SetXY($sx+2,$sy+66);
        $pdf->Cell(150,5,"今回分割請求額 　0　　　　分割残高 　0　　　　調整額　 0　　　　前受金　0",0);

        /*　ココまでがヘッダーと思われる部分　*/

        //基準点
        $x=$sx;
        $y=$sy+72;

        //得意先セル
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetFillColor(170,210,255);                            //セルの背景を青に設定する
        }else{
        //2ページの場合
        $pdf->SetFillColor(198,246,195);                            //セルの背景を緑に設定する
        }
        $pdf->SetFont(PGOTHIC,'',8);
        $pdf->SetXY($x,$y);
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetDrawColor(0,0,153);                                //枠線を青に設定する
        //2ページの場合
        }else{
            $pdf->SetDrawColor(18,133,25);                              //枠線を緑に設定する
        }
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(0,0,153);                                //フォントを青に設定する
        //2ページの場合
        }else{
            $pdf->SetTextColor(18,133,25);                              //フォントを緑に設定する
        }
        $pdf->Cell(133,5,"得意先",1,"0","C",1);
        
        //今回御買上額セル
        $pdf->SetXY($x+133,$y);
        $pdf->Cell(20,5,"今回御買上額",1,"0","C",1);
      
        //今回消費税額セル
        $pdf->SetXY($x+153,$y);
        $pdf->Cell(20,5,"今回御消費税額",1,"0","C",1);
   
        //税込御買上額セル
        $pdf->SetXY($x+173,$y);
        $pdf->Cell(20,5,"税込御買上額",1,"0","C",1);

        //請求書の明細表を作る    
        for($i=0;$i<24;$i++){
            //行は偶数の場合
            if($i%2==0){
                $pdf->SetFillColor(255,255,255);                        //セルの背景色を白に設定する
                //セルの作成
                $pdf->SetTextColor(0,0,0);                              //フォント黒をに設定
                $pdf->SetXY($x,$y+5);
                if($array[$i][0] != null){
                    $pdf->MultiCell(133,3.5,$array[$i][0]."\n".$array[$i][1],1,"L",1);
                }else{
                $pdf->Cell(133,7,"",1,0,"L",1);
                }
                $pdf->SetXY($x+133,$y+5);
                $pdf->Cell(20,7,$array[$i][2],1,"0","R",1);
                $pdf->SetXY($x+153,$y+5);
                $pdf->Cell(20,7,$array[$i][3],1,"0","R",1);
                $pdf->SetXY($x+173,$y+5);
                $pdf->Cell(20,7,$array[$i][4],1,"0","R",1);

                //行は奇数の場合
                }else{
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(220,235,255);                    //セルの背景色を薄い水色に設定する
                    //2ページの場合
                }else{
                    $pdf->SetFillColor(220,250,220);                    //セルの背景色を薄い緑に設定する
                }    
                $pdf->SetXY($x,$y+5);
                if($array[$i][0] != null){
                    $pdf->MultiCell(133,3.5,$array[$i][0]."\n".$array[$i][1],1,"L",1);
                }else{
                    $pdf->Cell(133,7,"",1,0,"L",1);
                }
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(230,240,255);                    //セルの背景色を薄い水色に設定する
                //2ページの場合
                }else{
                    $pdf->SetFillColor(230,255,230);                    //セルの背景色を薄い水色に設定する
                }
                $pdf->SetXY($x+133,$y+5);
                $pdf->Cell(20,7,$array[$i][2],1,"0","R",1);
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(220,235,255);                    //セルの背景色を薄い水色に設定する
                //2ページの場合
                }else{
                    $pdf->SetFillColor(220,250,220);                    //セルの背景色を薄い緑に設定する
                }
                $pdf->SetXY($x+153,$y+5);
                $pdf->Cell(20,7,$array[$i][3],1,"0","R",1);
                //1ページの場合
                if($col%2 == 0){
                    $pdf->SetFillColor(230,240,255);                    //セルの背景色を薄い水色に設定する
                //2ページの場合
                }else{
                    $pdf->SetFillColor(230,255,230);                    //セルの背景色を薄い水色に設定する
                }
                $pdf->SetXY($x+173,$y+5);
                $pdf->Cell(20,7,$array[$i][4],1,"0","R",1);
            }
         
            $y=$y+7;
        }

        //基準点
        $x1=$sx;
        $y1=$sy+248;
        //取引銀行セル
        $pdf->SetFont(PGOTHIC,'',5);
        $pdf->SetXY($x1,$y1);
        //1ページの場合
        if($col%2 == 0){
            $pdf->SetTextColor(0,0,153);                                //フォントを青に設定する
        //2ページの場合
        }else{
            $pdf->SetTextColor(18,133,25);                              //フォントを緑に設定する
        }
        $pdf->Write(3,$bank[0]);
        $pdf->SetXY($x1+9,$y1);
        $pdf->Write(3,$bank[1]);
        $pdf->SetXY($x1+9,$y1+3);
        $pdf->Write(3,$bank[2]);
        $pdf->SetXY($x1+9,$y1+6);
        $pdf->Write(3,$bank[3]);
        $pdf->SetXY($x1+9,$y1+9);
        $pdf->Write(3,$bank[4]);
        $pdf->SetXY($x1+78,$y1);
        $pdf->Write(3,$bank[5]);
        $pdf->SetXY($x1+78,$y1+3);
        $pdf->Write(3,$bank[6]);
        $pdf->SetXY($x1+78,$y1+6);
        $pdf->Write(3,$bank[7]);
        $pdf->SetFont(PGOTHIC,'',7);
        $pdf->SetXY($x1+9,$y1+12);
        $pdf->Write(5,$bank[8]);

        //印
        //1ページを場合
        if($col%2 == 0){
            $pdf->SetFillColor(220,235,255);                            //セルの背景色を薄い水色に設定する
        //2ページの場合
        }else{
            $pdf->SetFillColor(198,246,195);                            //セルの背景色を薄い緑に設定する
        }
        $pdf->SetDrawColor(0,0,0);//線の色を黒に設定
        $pdf->RoundedRect($x1+151,$y1,4,15,1.5,'DF',14);                  //角の丸いセルを描画
        $pdf->SetXY($x1+151,$y1);
        $pdf->multiCell(4,2.2," 担\n当\n者",0,'C');
        $pdf->RoundedRect($x1+155,$y1,25,15,1.5,'',23);
        $pdf->RoundedRect($x1+180,$y1,15,4,1.5,'DF',12);                  //角の丸いセルを描画
        $pdf->SetXY($x1+180,$y1);                           
        $pdf->Cell(15,4,"印",0,0,'C');             
        $pdf->RoundedRect($x1+180,$y1+4,15,11,1.5,'',34);

    }
}
$pdf->Output();
?>


