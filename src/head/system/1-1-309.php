<?php
/********************
 * 売上伝票プレビュー
 *
 *
 * 変更履歴
 *    2006/09/02 (kaji) 
 *      ・FCの売上伝票からプレビュー用にした
 *
 ********************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/25　0104　　      watanabe-k  メモに御買上伝票のメモが表示されているバグの修正
 *
 */

require_once("ENV_local.php");
require(FPDF_DIR);
$pdf=new MBFPDF('P','pp','a4');
$pdf->SetProtection(array('print', 'copy'));
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->SetAutoPageBreak(false);

//DB接続
$db_con = Db_Connect();

/****************************/
//外部変数取得
/****************************/
if($_POST[pattern_select] == null){
    print "<font color=\"red\"><b><li>パターンを選択してください。</b></font>";
    exit;
}
//print_array($_POST);

$shop_id = $_SESSION["client_id"];

$sql  = "SELECT ";
$sql .= "    s_memo1, ";        //売上伝票コメント1
$sql .= "    s_memo2, ";        //売上伝票コメント2
$sql .= "    s_memo3, ";        //売上伝票コメント3
$sql .= "    s_memo4, ";        //売上伝票コメント4
$sql .= "    s_memo5, ";        //売上伝票コメント5
$sql .= "    s_fsize1,";        //コメント1フォントサイズ
$sql .= "    s_fsize2,";        //コメント2フォントサイズ
$sql .= "    s_fsize3,";        //コメント3フォントサイズ
$sql .= "    s_fsize4,";        //コメント4フォントサイズ
$sql .= "    s_fsize5,";        //コメント5フォントサイズ
$sql .= "    s_memo6, ";        //売上伝票コメント6
$sql .= "    s_memo7, ";        //売上伝票コメント7
$sql .= "    s_memo8, ";        //売上伝票コメント8
$sql .= "    s_memo9, ";        //売上伝票コメント9
$sql .= "    bill_send_flg ";   //請求書渡すフラグ
$sql .= "FROM ";
$sql .= "    t_slip_sheet ";
$sql .= "WHERE ";
$sql .= "    s_pattern_id = ".$_POST["pattern_select"]." ";
$sql .= "    AND ";
$sql .= "    shop_id = $shop_id ";
$sql .= ";";

$result = Db_Query($db_con,$sql);
//DBの値を配列に保存
$s_memo = Get_Data($result,2);

//請求書を渡すときが緑、渡さないときは、グレー
$bill_flg = $s_memo[0][14];

$photo = COMPANY_SEAL_DIR.$shop_id.".jpg";      //社印のファイル名（得意先の担当支店の）
$photo_exists = file_exists($photo);            //社印が存在するかフラグ


$pdf->AddPage();


/****************************/
//お買い上げ伝票描画処理
/****************************/
$left_margin=50;
$posY=20;
//線の太さ
$pdf->SetLineWidth(0.8);
//線の色
$pdf->SetDrawColor(80,80,80);
//フォント設定
$pdf->SetFont(GOTHIC,'', 7);
//背景色
$pdf->SetFillColor(221,221,221);
//左上角丸(上)
$pdf->RoundedRect(60, 30, 260, 12, 5, 'FD',12);
//テキストの色
$pdf->SetTextColor(80,80,80); 
//背景色
$pdf->SetFillColor(255);
//左上角丸(下)
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"お客様コード　", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"伝票番号　           ", '', '1', 'R','0');
//フォント設定
$pdf->SetFont(GOTHIC,'', 9);
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.2);
//背景色
$pdf->SetFillColor(221,221,221);
//テキストの色
$pdf->SetTextColor(80,80,80); 
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'取引区分', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'配 送 年 月 日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'ルート', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'締日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'電　　話　　番　　号', '0', '1', 'C','1');

//テキストの色
$pdf->SetTextColor(80,80,80); 
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'お 買 上 伝 票', 'B', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 50, 10, 45, 3, 'FD',14);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'受', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'領', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'印', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 50, 65, 45, 3, 'FD',23);
//線の太さ
$pdf->SetLineWidth(0.2);
//テキストの色
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(80,80,80);
$pdf->RoundedRect(60, 100, 575, 10, 5, 'FD',12);

//テキストの色
$pdf->SetTextColor(255); 
//線の太さ
$pdf->SetLineWidth(0.2);
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'預　　　　　け', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'備　　　　考', '0', '1', 'C','0');

//テキストの色
$pdf->SetTextColor(0,0,0); 

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 110, 575, 105, 5, 'FD',4);

//フォント設定
$pdf->SetFont(GOTHIC,'', 7);
//線の太さ
$pdf->SetLineWidth(0.2);

//商品データ行数描画
$height = array('90','111','132','153','174');
for($x=0,$h=0;$x<5;$x++,$h++){
    //最後の行か判定
    if($x==5-1){
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}

//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(568, 215, 67, 57, 5, 'FD',34);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', 'T', '1', 'C','0');


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 215, 62, 57, 5, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);

//税抜金額
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//消費税額
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//合計金額
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//テキストの色
$pdf->SetTextColor(80,80,80); 
//フォント設定
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 225, 260, 58, 5, 'FD',1234);

//テキストの色
$pdf->SetTextColor(0,0,0);

//コメント
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][10], '0', '1', 'L','0');

//テキストの色
$pdf->SetTextColor(80,80,80);

//背景色
$pdf->SetFillColor(221,221,221);
$pdf->RoundedRect(330, 225, 56, 10, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 235, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+340, $posY+254);
$pdf->Cell(250, 10,'毎度ありがとうございます。上記の通り納品致しますので御査収下さい。', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//線の色
$pdf->SetDrawColor(42,42,42);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



/****************************/
//請求書伝票描画処理
/****************************/
$posY=325;
//線の太さ
$pdf->SetLineWidth(0.8);

//線の色
$pdf->SetDrawColor(46,140,46);
//背景色
$pdf->SetFillColor(198,246,195);

//フォント設定
$pdf->SetFont(GOTHIC,'', 9);

//左上角丸(上)
$pdf->RoundedRect(60, 335, 260, 12, 5, 'FD',12);

//テキストの色
$pdf->SetTextColor(46,140,46);

//背景色
$pdf->SetFillColor(255);

//フォント設定
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"お客様コード　", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"伝票番号　           ", '', '1', 'R','0');

//フォント設定
$pdf->SetFont(GOTHIC,'', 9);
//左上角丸(下)
$pdf->RoundedRect(60, 347, 260,53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');

//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->SetFillColor(198,246,195);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'取引区分', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'配 送 年 月 日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'ルート', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'締日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'電　　話　　番　　号', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'請　　求　　書', 'B', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 355, 10, 45, 3, 'FD',14);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'受', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'領', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'印', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 355, 65, 45, 3, 'FD',23);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'B', 12);

//テキストの色
$pdf->SetTextColor(80,80,80);

$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//線の太さ
$pdf->SetLineWidth(0.8);

//背景色
$pdf->SetFillColor(46,140,46);
//線の色
$pdf->SetDrawColor(46,140,46);
$pdf->RoundedRect(60, 405, 575, 10, 5, 'FD',12);

//テキストの色
$pdf->SetTextColor(255); 

//線の太さ
$pdf->SetLineWidth(0.2);
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'預　　　　　け', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'備　　　　考', '0', '1', 'C','0');

//テキストの色
$pdf->SetTextColor(0,0,0);

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 415, 575, 105, 5, 'FD',4);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 7);

//商品データ行数描画
$height = array('90','111','132','153','174');

for($x=0,$h=0;$x<5;$x++,$h++){
    //最後の行か判定
    if($x==5-1){
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 520,67, 57, 5, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 520, 62, 57, 5, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);

//税抜金額
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//消費税額
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//合計金額
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//フォント設定
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetTextColor(46,140,46);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

$pdf->SetLineWidth(0.8);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+11, $posY+200);
$pdf->MultiCell(254, 9,$s_memo[0][11], '0', '1', 'L','0');

//背景色
$pdf->SetFillColor(198,246,195);

$pdf->RoundedRect(330, 530, 56, 10, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 540, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+305, $posY+254);
$pdf->Cell(230, 10,'毎度ありがとうございます。上記の通り請求致します。', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//線の色
$pdf->SetDrawColor(14,104,20);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



/****************************/
//納品書伝票描画処理
/****************************/
$posY=630;
$left_margin=50;

//線の太さ
$pdf->SetLineWidth(0.8);
//線の色
$pdf->SetDrawColor(17,136,255);
//背景色
$pdf->SetFillColor(170,212,255);
//左上角丸(上)
$pdf->RoundedRect(60, 640, 260, 12, 5, 'FD',12);
//テキストの色
$pdf->SetTextColor(17,136,255);
//背景色
$pdf->SetFillColor(255);

//フォント設定
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"お客様コード　", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"伝票番号　           ", '', '1', 'R','0');

//左上角丸(下)
//フォント設定
$pdf->SetFont(GOTHIC,'', 9);
$pdf->RoundedRect(60, 652, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.2);
//テキストの色
$pdf->SetTextColor(17,136,255);
//背景色
$pdf->SetFillColor(170,212,255);
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'取引区分', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'配 送 年 月 日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'ルート', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'締日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'電　　話　　番　　号', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'納　　品　　書', 'B', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(335, 660, 10, 45, 3, 'FD',14);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+285, $posY+35);
$pdf->Cell(10, 10,'受', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+47.5);
$pdf->Cell(10, 10,'領', '0', '1', 'C','0');
$pdf->SetXY($left_margin+285, $posY+60);
$pdf->Cell(10, 10,'印', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(345, 660, 65, 45, 3, 'FD',23);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetFont(GOTHIC,'B', 12);

//テキストの色
$pdf->SetTextColor(0,0,0);

$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(17,136,255);
$pdf->RoundedRect(60, 710, 575, 10, 5, 'FD',12);

//テキストの色
$pdf->SetTextColor(255); 
//線の太さ
$pdf->SetLineWidth(0.2);

//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'預　　　　　け', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'備　　　　考', '0', '1', 'C','0');

//テキストの色
$pdf->SetTextColor(0,0,0);

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 720, 575, 105, 5, 'FD',4);

//線の太さ
$pdf->SetLineWidth(0.2);
//背景色
$pdf->SetFillColor(170,212,255);
$pdf->SetFont(GOTHIC,'', 7);

//商品データ行数描画
$height = array('90','111','132','153','174');
for($x=0,$h=0;$x<5;$x++,$h++){
    //最後の行か判定
    if($x==5-1){
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 825,67, 57, 5, 'FD',34);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 825, 62, 57, 5, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);

//税抜金額
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//消費税額
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//合計金額
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//テキストの色
$pdf->SetTextColor(17,136,255);

//フォント設定
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');


//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 835, 260, 58, 5, 'FD',1234);

//テキストの色
$pdf->SetTextColor(0,0,0);

//コメント
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][12], '0', '1', 'L','0');

//テキストの色
$pdf->SetTextColor(17,136,255);

//背景色
$pdf->SetFillColor(170,212,255);
$pdf->RoundedRect(330, 835, 56, 10, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 845, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+340, $posY+254);
$pdf->Cell(250, 10,'毎度ありがとうございます。上記の通り納品致しますので御査収下さい。', '0', '1', 'R','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//線の色
$pdf->SetDrawColor(17,136,255);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);



//改ページ
$pdf->AddPage();


/****************************/
//領収書伝票描画処理
/****************************/
$posY=20;
//線の太さ
$pdf->SetLineWidth(0.8);
//線の色
$pdf->SetDrawColor(29,0,120);
//背景色
$pdf->SetFillColor(200,230,255);
//左上角丸(上)
$pdf->RoundedRect(60, 30, 260, 12, 5, 'FD',12);
//テキストの色
$pdf->SetTextColor(61,50,180); 
//背景色
$pdf->SetFillColor(255);

//フォント設定
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+15, $posY);
$pdf->Cell(100, 8,"お客様コード　", '', '1', 'L','0');
$pdf->SetXY($left_margin+490, $posY);
$pdf->Cell(100, 8,"伝票番号　           ", '', '1', 'R','0');

$pdf->SetFont(GOTHIC,'', 9);
//左上角丸(下)
$pdf->RoundedRect(60, 42, 260, 53, 5, 'FD',34);
$pdf->SetXY($left_margin+10, $posY+10);
$pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.2);
//テキストの色
$pdf->SetTextColor(61,50,180); 
//背景色
$pdf->SetFillColor(200,230,255);
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+45);
$pdf->Cell(260, 12,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+10.4, $posY+45);
$pdf->Cell(34, 12,'取引区分', '0', '1', 'C','1');
$pdf->SetXY($left_margin+44, $posY+45);
$pdf->Cell(63, 12,'配 送 年 月 日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+107, $posY+45);
$pdf->Cell(34, 12,'ルート', '0', '1', 'C','1');
$pdf->SetXY($left_margin+141, $posY+45);
$pdf->Cell(22, 12,'締日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+163, $posY+45);
$pdf->Cell(106.4, 12,'電　　話　　番　　号', '0', '1', 'C','1');

if($photo_exists){
    $pdf->Image($photo,$left_margin+510, $posY+25,52);
}

//テキストの色
$pdf->SetTextColor(61,50,180); 
$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin+365, $posY+7,45,15);
$pdf->SetFont(GOTHIC,'B', 11);
$pdf->SetXY($left_margin+273, $posY+10);
$pdf->Cell(90, 12,'領　　収　　書', 'B', '1', 'C','0');


$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+480.5, $posY+217);
$pdf->Cell(10, 10,'印', '0', '1', 'C','0');
$pdf->SetXY($left_margin+480.5, $posY+240);
$pdf->Cell(10, 10,'紙', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.2);
//テキストの色
$pdf->SetTextColor(0,0,0); 
$pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
$pdf->SetXY($left_margin+415, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
$pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
$pdf->SetXY($left_margin+465, $posY+11);
$pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

$pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
$pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
$pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
$pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
$pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

$pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
$pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
$pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(29,0,120);
$pdf->RoundedRect(60, 100, 575, 10, 5, 'FD',12);

//テキストの色
$pdf->SetTextColor(255); 
//線の太さ
$pdf->SetLineWidth(0.2);
//フォント設定
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+10, $posY+80);
$pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
$pdf->SetXY($left_margin+50, $posY+80);
$pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
$pdf->SetXY($left_margin+306, $posY+80);
$pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
$pdf->SetXY($left_margin+338, $posY+80);
$pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
$pdf->SetXY($left_margin+390, $posY+80);
$pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
$pdf->SetXY($left_margin+452, $posY+80);
$pdf->Cell(66, 10,'預　　　　　け', '0', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+80);
$pdf->Cell(66.7, 10,'備　　　　考', '0', '1', 'C','0');

//テキストの色
$pdf->SetTextColor(0,0,0); 

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(60, 110, 575, 105, 5, 'FD',4);

//線の太さ
$pdf->SetLineWidth(0.2);
//背景色
$pdf->SetFillColor(200,230,255);
$pdf->SetFont(GOTHIC,'', 7);

//商品データ行数描画
$height = array('90','111','132','153','174');

for($x=0,$h=0;$x<5;$x++,$h++){
    //最後の行か判定
    if($x==5-1){
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', '1', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', '1', '1', 'C','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', '1', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', '1', '1', 'C','0');

    }else{
        //商品コード
        $pdf->SetXY($left_margin+10, $posY+$height[$h]);
        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');

        //サービス/アイテム名
        $pdf->SetXY($left_margin+50, $posY+$height[$h]);
        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');

        //数量
        $pdf->SetXY($left_margin+306, $posY+$height[$h]);
        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');

        //単価
        $pdf->SetXY($left_margin+338, $posY+$height[$h]);
        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');

        //金額
        $pdf->SetXY($left_margin+390, $posY+$height[$h]);
        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');

        //預け
        $pdf->SetXY($left_margin+452, $posY+$height[$h]);
        $pdf->MultiCell(66,10,'', 'LRT','L','0');

        //備考
        $pdf->SetXY($left_margin+518, $posY+$height[$h]);
        $pdf->Cell(66.7, 21,'', 'LRT', '1', 'C','0');
    }
}


//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(568, 215, 67, 57, 5, 'FD',34);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+518, $posY+195);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+214);
$pdf->Cell(66.7, 19,'', '1', '1', 'C','0');
$pdf->SetXY($left_margin+518, $posY+233);
$pdf->Cell(66.7, 19,'', '', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(440, 215, 62, 57, 5, 'FD',34);
//線の太さ
$pdf->SetLineWidth(0.2);

//税抜金額
$pdf->SetXY($left_margin+390, $posY+195);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//消費税額
$pdf->SetXY($left_margin+390, $posY+214);
$pdf->Cell(62, 19,'', 'B', '1', 'R','0');

//合計金額
$pdf->SetXY($left_margin+390, $posY+233);
$pdf->Cell(62, 19,'', '0', '1', 'R','0');

//テキストの色
$pdf->SetTextColor(61,50,180); 
//フォント設定
$pdf->SetFont(GOTHIC,'', 6.5);
$pdf->SetXY($left_margin+357, $posY+195);
$pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+214);
$pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
$pdf->SetXY($left_margin+357, $posY+233);
$pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

//線の太さ
$pdf->SetLineWidth(0.8);
$pdf->RoundedRect(60, 225, 260, 58, 5, 'FD',1234);

//テキストの色
$pdf->SetTextColor(0,0,0); 

//コメント
$pdf->SetFont(GOTHIC,'', 6);
$pdf->SetXY($left_margin+16, $posY+210);
$pdf->MultiCell(254, 9,$s_memo[0][13], '0', '1', 'L','0');
//テキストの色
$pdf->SetTextColor(61,50,180); 

//背景色
$pdf->SetFillColor(200,230,255);
$pdf->RoundedRect(330, 225, 56, 10, 3, 'FD',12);
//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+280, $posY+205);
$pdf->Cell(56, 10,'領　収　印', '0', '1', 'C','0');
//線の太さ
$pdf->SetLineWidth(0.8);
//背景色
$pdf->SetFillColor(255);
$pdf->RoundedRect(330, 235, 56, 48, 3, 'FD',34);

$pdf->SetDrawColor(255);
$pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

//線の太さ
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+337, $posY+254);
$pdf->Cell(150, 10,'※領収印の無き物は', '0', '1', 'L','0');
$pdf->SetXY($left_margin+353, $posY+265);
$pdf->Cell(150, 10,'無効と致します。', '0', '1', 'L','0');

$pdf->SetLineWidth(0.2);
$pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
$pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
$pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
$pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
$pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
$pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

//線の色
$pdf->SetDrawColor(42,42,42);
$pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
$pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

$pdf->Line($left_margin+44.4,$posY+45,$left_margin+44.4,$posY+75);
$pdf->Line($left_margin+107,$posY+45,$left_margin+107,$posY+75);
$pdf->Line($left_margin+141,$posY+45,$left_margin+141,$posY+75);
$pdf->Line($left_margin+162,$posY+45,$left_margin+162,$posY+75);

            //印紙の枠描画
            $pdf->SetLineWidth(0.1);
            $left_margin = 495;
            $posY = 205;
            for($i=14;$i<66;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+20, $left_margin+$i+0.5, $posY+20);
            }
            for($i=20;$i<76;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }
            for($i=14;$i<66;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+77, $left_margin+$i+0.5, $posY+77);
            }
            $left_margin = 549;
            for($i=20;$i<76;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }   


$pdf->Output();
//$pdf->Output(mb_convert_encoding("売上伝票".date("Ymd").".pdf", "SJIS", "EUC"),"D");
?>
