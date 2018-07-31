<?php

// 環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);

require('../../../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P','pt','a3w');

$pdf->AddMBFont(GOTHIC ,'SJIS');

$pdf->SetAutoPageBreak(false);

$pdf->AddPage();

//背景色
$pdf->SetFillColor(180,180,180);
//登録カード作成年月日
$card[0] = "2005";//年
$card[1] = "4";//月
$card[2] = "28";//日

$top[0] = "";//SV欄
$top[1] = "";//担当１欄
$top[2] = "";//担当２欄
$top[3] = "";//担当３欄
$top[4] = "";//担当４欄

//得意先欄
$customer1 = "";//Sコード
$customer2 = "";//FC・取引先区分
$customer3 = "";//状態
$customer4 = "";//ショップ名フリガナ
$customer5 = "";//ショップ名
$customer6 = "";//社名フリガナ
$customer7 = "";//社名
$customer8 = "";//郵便番号
$customer9 = "";//住所フリガナ
$customer10 = "";//住所
$customer11 = "";//TEL
$customer12 = "";//FAX
$customer13 = "";//代表者役職
$customer14 = "";//代表者
$customer15 = "";//代表携帯
$customer16 = "";//連絡担当者
$customer17 = "";//担当氏名
$customer18 = "";//担当携帯
$customer19 = "";//保証人１
$customer20 = "";//保証人１住所
$customer21 = "";//保証人２
$customer22 = "";//保証人２住所
$customer23 = "";//営業拠点
$customer24 = "";//休日
$customer25 = "";//商圏
$customer26 = "";//加盟金
$customer27 = "";//保証金
$customer28 = "";//ﾛｲﾔﾘﾃｨ

$payment[0] = "30日";//締日
$payment[1] = "翌々月";//支払日(左)
$payment[2] = "30日";//支払日(右)
$payment[3] = "振込";//支払方法
$payment[4] = "";//振込名義


$representative[0] = "";//代表者
$charge[0] = "";//得意先ご担当
$charge[1] = "";//得意先ご担当
$charge[2] = "";//得意先ご担当
$charge[3] = "";//得意先ご担当
$charge[4] = "";//得意先ご担当

//請求先欄
$claim[0] = "";//郵便番号
$claim[1] = "";//請求先フリガナ
$claim[2] = "";//請求先名
$claim[3] = "";//住所フリガナ
$claim[4] = "";//住所
$claim[5] = "";//TEL
$claim[6] = "";//FAX

$representative[1] = "";//代表者
$charge[5] = "";//請求先ご担当
$charge[6] = "";//請求先ご担当
$charge[7] = "";//請求先ご担当
$charge[8] = "";//請求先ご担当
$charge[9] = "";//請求先ご担当

$start[0] = "2005";//開始日(年)
$start[1] = "4";//開始日(月)
$start[2] = "28";//開始日(日)

$renewal[0] = "";//更新1行目(年)
$renewal[1] = "";//更新1行目(月)
$renewal[2] = "";//更新1行目(日)
$renewal[3] = "";//更新者名1行目
$renewal[4] = "";//更新2行目(年)
$renewal[5] = "";//更新2行目(月)
$renewal[6] = "";//更新2行目(日)
$renewal[7] = "";//更新者名2行目
$renewal[8] = "";//更新3行目(年)
$renewal[9] = "";//更新3行目(月)
$renewal[10] = "";//更新3行目(日)
$renewal[11] = "";//更新者名3行目

$contract1 = "";//契約会社名
$contract2 = "";//契約代表者名
$contract3 = "";//契約年月日
$contract4 = "";//契約期間


//データ取得SQL
//$sql_select = "";

$data[0] = array("31","C");//周期
$data[1] = array("39","C");//周期単位
$data[2] = array("23.5","C");//週名
$data[3] = array("23","C");//曜日・日
$data[4] = array("163.5","L");//サービス・製品
$data[5] = array("31","R");//数量
$data[6] = array("36","R");//単価
$data[7] = array("44","R");//金額
$data[8] = array("109","L");//備考

//align(データ)
$data_align[0] = "C";
$data_align[1] = "C";
$data_align[2] = "C";
$data_align[3] = "C";
$data_align[4] = "L";
$data_align[5] = "R";
$data_align[6] = "R";
$data_align[7] = "R";
$data_align[8] = "L";


$year1 = "2005";
$month1 = "09";
$day1 = "28";
$year2 = "2005";
$month2 = "10";
$renew1 = "アメニティ　太郎";
$day2 = "01";
$year3 = "2005";
$month3 = "10";
$day3 = "15";
$renew2 = "アメニティ　次郎";
$year4 = "2005";
$month4 = "10";
$day4 = "24";
$renew3 = "アメニティ　三郎";

//太線
$posY = $pdf->GetY();
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetLineWidth(0.8);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(97, 49,'登録カード', '1', '1', 'C');
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(200, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(500, 326,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+400);
$pdf->Cell(500, 108,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(500, 184,'', '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+650, $posY+15);
$pdf->Cell(500, 13,'取得資格・得意分野', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+28);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+650, $posY+269.5);
$pdf->Cell(500, 13,'特約', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+282.5);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+650, $posY+524);
$pdf->Cell(500, 13,'その他', '1', '1', 'C','1');
$pdf->SetXY($left_margin+650, $posY+537);
$pdf->Cell(500, 225,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318, $posY+696);
$pdf->Cell(111, 49.5,'', '1', '1', 'C');

//TOP
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 15,'登録カード作成年月日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+170, $posY+30);
$pdf->Cell(30, 34, $card[0], '0', '1', 'R');
$pdf->SetXY($left_margin+200, $posY+30);
$pdf->Cell(15, 34,'年', '0', '1', 'L');
$pdf->SetXY($left_margin+215, $posY+30);
$pdf->Cell(20, 34, $card[1], '0', '1', 'R');
$pdf->SetXY($left_margin+235, $posY+30);
$pdf->Cell(15, 34,'月', '0', '1', 'L');
$pdf->SetXY($left_margin+250, $posY+30);
$pdf->Cell(20, 34, $card[2], '0', '1', 'R');
$pdf->SetXY($left_margin+270, $posY+30);
$pdf->Cell(15, 34,'日', '0', '1', 'L');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(40, 15,'SV', '1', '1', 'C','1');
$pdf->SetXY($left_margin+378, $posY+15);
$pdf->Cell(40, 15,'担当1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+15);
$pdf->Cell(40, 15,'担当2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+458, $posY+15);
$pdf->Cell(40, 15,'担当3', '1', '1', 'C','1');
$pdf->SetXY($left_margin+498, $posY+15);
$pdf->Cell(40, 15,'担当4', '1', '1', 'C','1');
$pdf->SetXY($left_margin+338, $posY+30);
$pdf->Cell(40, 34,$top[0], '1', '1', 'C');
$pdf->SetXY($left_margin+378, $posY+30);
$pdf->Cell(40, 34,$top[1], '1', '1', 'C');
$pdf->SetXY($left_margin+418, $posY+30);
$pdf->Cell(40, 34,$top[2], '1', '1', 'C');
$pdf->SetXY($left_margin+458, $posY+30);
$pdf->Cell(40, 34,$top[3], '1', '1', 'C');
$pdf->SetXY($left_margin+498, $posY+30);
$pdf->Cell(40, 34,$top[4], '1', '1', 'C');

$pdf->SetFont(GOTHIC, '', 9);
//得意先データ
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(46, 156,'ショップ名', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+69);
$pdf->Cell(50, 15,'S コード', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+69);
$pdf->Cell(101, 15,$customer1, '1', '1', 'C');
$pdf->SetXY($left_margin+235, $posY+69);
$pdf->Cell(50, 15,'FC・取引先区分', '1', '1', 'C','1');
$pdf->SetXY($left_margin+285, $posY+69);
$pdf->Cell(101, 15,$customer2, '1', '1', 'C');
$pdf->SetXY($left_margin+386, $posY+69);
$pdf->Cell(50, 15,'状態', '1', '1', 'C','1');
$pdf->SetXY($left_margin+436, $posY+69);
$pdf->Cell(102, 15,$customer3, '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+84);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+84);
$pdf->Cell(404, 12.5,$customer4, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+96.5);
$pdf->Cell(50, 24.5,'ショップ名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+96.5);
$pdf->Cell(404, 24.5,$customer5, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+121);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+121);
$pdf->Cell(404, 12.5,$customer6, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+133.5);
$pdf->Cell(50, 24.5,'社　　　名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+133.5);
$pdf->Cell(404, 24.5,$customer7, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+158);
$pdf->Cell(50, 15,'郵便番号', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+158);
$pdf->Cell(404, 15,$customer8, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+84, $posY+173);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+173);
$pdf->Cell(404, 12.5,$customer9, '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+84, $posY+185.5);
$pdf->Cell(50, 24.5,'住　　　所', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+185.5);
$pdf->Cell(404, 24.5,$customer10, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+210);
$pdf->Cell(50, 15,'Ｔ　Ｅ　Ｌ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+210);
$pdf->Cell(101, 15,$customer11, '1', '1', 'L');
$pdf->SetXY($left_margin+235, $posY+210);
$pdf->Cell(50, 15,'Ｆ　Ａ　Ｘ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+285, $posY+210);
$pdf->Cell(253, 15,$customer12, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+225);
$pdf->Cell(46, 15,'代表者役職', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+225);
$pdf->Cell(121,15,$customer13, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+225);
$pdf->Cell(46, 15,'代　表　者', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+225);
$pdf->Cell(121,15,$customer14, '1', '1', 'L');
$pdf->SetXY($left_margin+372, $posY+225);
$pdf->Cell(46, 15,'代表携帯', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+225);
$pdf->Cell(120,15,$customer15, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+240);
$pdf->Cell(46, 15,'連絡担当者', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+240);
$pdf->Cell(121,15,$customer16, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+240);
$pdf->Cell(46, 15,'担当氏名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+240);
$pdf->Cell(121,15,$customer17, '1', '1', 'L');
$pdf->SetXY($left_margin+372, $posY+240);
$pdf->Cell(46, 15,'担当携帯', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+240);
$pdf->Cell(120,15,$customer18, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+255);
$pdf->Cell(46, 15,'保証人１', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+255);
$pdf->Cell(121,15,$customer19, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+255);
$pdf->Cell(46, 15,'住　　所', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+255);
$pdf->Cell(287,15,$customer20, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+270);
$pdf->Cell(46, 15,'保証人２', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+270);
$pdf->Cell(121,15,$customer21, '1', '1', 'L');
$pdf->SetXY($left_margin+205, $posY+270);
$pdf->Cell(46, 15,'住　　所', '1', '1', 'C','1');
$pdf->SetXY($left_margin+251, $posY+270);
$pdf->Cell(287,15,$customer22, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+285);
$pdf->Cell(46, 15,'営業拠点', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+285);
$pdf->Cell(287,15,$customer23, '1', '1', 'L');
$pdf->SetXY($left_margin+371, $posY+285);
$pdf->Cell(46, 15,'休　　日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+417, $posY+285);
$pdf->Cell(121,15,$customer24, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+300);
$pdf->Cell(46, 15,'商　　圏', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+300);
$pdf->Cell(454,15,$customer25, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+315);
$pdf->Cell(46, 15,'加盟金', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+315);
$pdf->Cell(454,15,$customer26, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+330);
$pdf->Cell(46, 15,'保証金', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+330);
$pdf->Cell(454,15,$customer27, '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+345);
$pdf->Cell(46, 15,'ﾛｲﾔﾘﾃｨ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+345);
$pdf->Cell(454,15,$customer28, '1', '1', 'L');

$pdf->SetXY($left_margin+38, $posY+360);
$pdf->Cell(46, 15,'締日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+360);
$pdf->Cell(100, 15,'支払日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+184, $posY+360);
$pdf->Cell(50, 15,'支払方法', '1', '1', 'C','1');
$pdf->SetXY($left_margin+234, $posY+360);
$pdf->Cell(304, 15,'振込名義', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+375);
$pdf->Cell(46, 20,$payment[0], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+375);
$pdf->Cell(50, 20,$payment[1], '1', '1', 'C');
$pdf->SetXY($left_margin+134, $posY+375);
$pdf->Cell(50, 20,$payment[2], '1', '1', 'C');
$pdf->SetXY($left_margin+184, $posY+375);
$pdf->Cell(50, 20,$payment[3], '1', '1', 'C');
$pdf->SetXY($left_margin+234, $posY+375);
$pdf->Cell(304, 20,$payment[4], '1', '1', 'C');

$pdf->SetXY($left_margin+38, $posY+400);
$pdf->Cell(46, 108,'契約', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+400);
$pdf->Cell(50, 27,'契約会社名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+400);
$pdf->Cell(404, 27,$contract1, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+427);
$pdf->Cell(50, 27,'契約代表名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+427);
$pdf->Cell(404, 27,$contract2, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+454);
$pdf->Cell(50, 27,'契約年月日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+454);
$pdf->Cell(404, 27,$contract3, '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+481);
$pdf->Cell(50, 27,'契約期間', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+481);
$pdf->Cell(404, 27,$contract4, '1', '1', 'L');

//データ詳細
$pdf->SetFont(GOTHIC,'', 9);
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(31, 24,'周期', '1', '1', 'C','1');
$pdf->SetXY($left_margin+69.2, $posY+512);
$pdf->Cell(39, 24,'', '1', '1', 'C');
$pdf->SetXY($left_margin+69.2, $posY+512.2);
$pdf->Cell(39, 11.8,'周期単位', '0', '1', 'C','1');
$pdf->SetXY($left_margin+69.2, $posY+524);
$pdf->Cell(39, 11.8,'(W・M)', '0', '1', 'C','1');
$pdf->SetXY($left_margin+108, $posY+512);
$pdf->Cell(23.5, 24,'週名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+131.7, $posY+512);
$pdf->Cell(23, 24,'', '1', '1', 'C');
$pdf->SetXY($left_margin+131.7, $posY+512.2);
$pdf->Cell(23, 11.8,'曜日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+131.7, $posY+524);
$pdf->Cell(23, 11.8,'日', '0', '1', 'C','1');
$pdf->SetXY($left_margin+154.5, $posY+512);
$pdf->Cell(163.5, 24,'サービス／製品', '1', '1', 'C','1');
$pdf->SetXY($left_margin+318, $posY+512);
$pdf->Cell(31, 24,'数 量', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+512);
$pdf->Cell(36, 24,'単 価', '1', '1', 'C','1');
$pdf->SetXY($left_margin+385, $posY+512);
$pdf->Cell(44, 24,'金　額', '1', '1', 'C','1');
$pdf->SetXY($left_margin+429, $posY+512);
$pdf->Cell(109, 24,'備 考', '1', '1', 'C','1');

$pdf->SetXY(10, 28.5);
$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->Line($left_margin+38,$posY+552,$left_margin+538,$posY+552);
$pdf->Line($left_margin+38,$posY+568,$left_margin+538,$posY+568);
$pdf->Line($left_margin+38,$posY+584,$left_margin+538,$posY+584);
$pdf->Line($left_margin+38,$posY+600,$left_margin+538,$posY+600);
$pdf->Line($left_margin+38,$posY+616,$left_margin+538,$posY+616);
$pdf->Line($left_margin+38,$posY+632,$left_margin+538,$posY+632);
$pdf->Line($left_margin+38,$posY+648,$left_margin+538,$posY+648);
$pdf->Line($left_margin+38,$posY+664,$left_margin+538,$posY+664);
$pdf->Line($left_margin+38,$posY+680,$left_margin+538,$posY+680);
$pdf->Line($left_margin+69,$posY+536,$left_margin+69,$posY+696);
$pdf->Line($left_margin+108,$posY+536,$left_margin+108,$posY+696);
$pdf->Line($left_margin+131.5,$posY+536,$left_margin+131.5,$posY+696);
$pdf->Line($left_margin+154.5,$posY+536,$left_margin+154.5,$posY+696);
$pdf->Line($left_margin+318,$posY+536,$left_margin+318,$posY+696);
$pdf->Line($left_margin+349,$posY+536,$left_margin+349,$posY+696);
$pdf->Line($left_margin+385,$posY+536,$left_margin+385,$posY+696);
$pdf->Line($left_margin+429,$posY+536,$left_margin+429,$posY+696);
$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+318.2, $posY+696.3);
$pdf->Cell(30.8, 16.2,'内税合計', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+696);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+696);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318.2, $posY+712.5);
$pdf->Cell(30.8, 16.5,'外税合計', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+712.5);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+712.5);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+318.2, $posY+729);
$pdf->Cell(30.8, 16.1,'合 計', '1', '1', 'C','1');
$pdf->SetXY($left_margin+349, $posY+729);
$pdf->Cell(36, 16.5,'', '1', '1', 'C');
$pdf->SetXY($left_margin+385, $posY+729);
$pdf->Cell(44, 16.5,'', '1', '1', 'C');

$pdf->SetFont(GOTHIC,'', 9);
//BOTTOM
$pdf->Line($left_margin+38,$posY+712.5,$left_margin+170,$posY+712.5);
$pdf->Line($left_margin+38,$posY+729,$left_margin+310,$posY+729);
$pdf->Line($left_margin+38,$posY+745.5,$left_margin+310,$posY+745.5);
$pdf->Line($left_margin+38,$posY+762,$left_margin+310,$posY+762);

$pdf->SetXY($left_margin+38, $posY+696);
$pdf->Cell(22, 16.5,'開始日', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+696);
$pdf->Cell(35, 16.5,$year1, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+696);
$pdf->Cell(10, 16.5,'年', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+696);
$pdf->Cell(20, 16.5,$month1, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+696);
$pdf->Cell(10, 16.5,'月', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+696);
$pdf->Cell(20, 16.5,$day1, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+696);
$pdf->Cell(10, 16.5,'日', '0', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+712.5);
$pdf->Cell(22, 16.5,'更新日', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+712.5);
$pdf->Cell(35, 16.5,$year2, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+712.5);
$pdf->Cell(10, 16.5,'年', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+712.5);
$pdf->Cell(20, 16.5,$month2, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+712.5);
$pdf->Cell(10, 16.5,'月', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+712.5);
$pdf->Cell(20, 16.5,$day2, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+712.5);
$pdf->Cell(10, 16.5,'日', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+712.5);
$pdf->Cell(30, 16.5,'更新者', '0', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+712.5);
$pdf->Cell(41, 16.5,$renew1, '0', '1', 'R');
$pdf->SetXY($left_margin+38, $posY+729);
$pdf->Cell(22, 16.5,'更新日', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+729);
$pdf->Cell(35, 16.5,$year3, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+729);
$pdf->Cell(10, 16.5,'年', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+729);
$pdf->Cell(20, 16.5,$month3, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+729);
$pdf->Cell(10, 16.5,'月', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+729);
$pdf->Cell(20, 16.5,$day3, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+729);
$pdf->Cell(10, 16.5,'日', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+729);
$pdf->Cell(22, 16.5,'更新者', '0', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+729);
$pdf->Cell(41, 16.5,$renew2, '0', '1', 'R');
$pdf->SetXY($left_margin+38, $posY+745.5);
$pdf->Cell(22, 16.5,'更新日', '0', '1', 'L');
$pdf->SetXY($left_margin+60, $posY+745.5);
$pdf->Cell(35, 16.5,$year4, '0', '1', 'R');
$pdf->SetXY($left_margin+95, $posY+745.5);
$pdf->Cell(10, 16.5,'年', '0', '1', 'L');
$pdf->SetXY($left_margin+105, $posY+745.5);
$pdf->Cell(20, 16.5,$month4, '0', '1', 'R');
$pdf->SetXY($left_margin+125, $posY+745.5);
$pdf->Cell(10, 16.5,'月', '0', '1', 'L');
$pdf->SetXY($left_margin+135, $posY+745.5);
$pdf->Cell(20, 16.5,$day4, '0', '1', 'R');
$pdf->SetXY($left_margin+155, $posY+745.5);
$pdf->Cell(10, 16.5,'日', '0', '1', 'L');
$pdf->SetXY($left_margin+175, $posY+745.5);
$pdf->Cell(30, 16.5,'更新者', '', '1', 'L');
$pdf->SetXY($left_margin+255, $posY+745.5);
$pdf->Cell(41, 16.5,$renew3, '0', '1', 'R');


$pdf->SetFont(GOTHIC,'', 7);
$pdf->SetXY($left_margin+349, $posY+754);
$pdf->Cell(80, 8,'書式作成2005年08月30日', '0', '1', 'C');
$pdf->Output();


?>
