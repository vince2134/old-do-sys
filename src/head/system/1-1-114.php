<?php

// 環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

require('../../../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P','pt','a4');

$pdf->AddMBFont(GOTHIC ,'SJIS');

$pdf->SetAutoPageBreak(false);

$pdf->AddPage();

//お客様カード作成年月日
$card[0] = "2005";//年
$card[1] = "4";//月
$card[2] = "28";//日

$top[0] = "";//営担欄
$top[1] = "";//営管欄
$top[2] = "";//業務欄
$top[3] = "";//巡回欄

//得意先欄
$customer[0] = "";//納品先名フリガナ
$customer[1] = "";//納品先名
$customer[2] = "";//郵便番号
$customer[3] = "";//住所フリガナ
$customer[4] = "";//住所
$customer[5] = "";//TEL
$customer[6] = "";//FAX

$representative[0] = "";//代表者
$charge[0] = "";//得意先ご担当
$charge[1] = "";//得意先ご担当
$charge[2] = "";//得意先ご担当
$charge[3] = "";//得意先ご担当
$charge[4] = "";//得意先ご担当


//営業時間1行目
$business[0] = "10";//時(始)
$business[1] = "00";//分(始)
$business[2] = "10";//時(終)
$business[3] = "00";//分(終)
//営業時間2行目
$business[4] = "14";//時(始)
$business[5] = "00";//分(始)
$business[6] = "14";//時(終)
$business[7] = "00";//分(終)
$business[8] = "●その他";//業種
$business[9] = "";//業態
$holiday = "";//休日欄


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

$payment[0] = "掛売";//締日(上)
$payment[1] = "30日";//締日(下)
$payment[2] = "翌々月";//支払日(左)
$payment[3] = "30日";//支払日(右)
$payment[4] = "振込";//支払方法
$payment[5] = "";//振込名義

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

//背景色
$pdf->SetFillColor(180,180,180);

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
$left_margin = 8;
//太線
$posY = $pdf->GetY();
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetLineWidth(0.8);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(97, 49,'お客様カード', '1', '1', 'C');
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+338, $posY+15);
$pdf->Cell(200, 49,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(500, 217,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+289);
$pdf->Cell(500, 218,'', '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+512);
$pdf->Cell(500, 184,'', '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 10.5);
//TOP
$pdf->SetLineWidth(0.2);
$pdf->SetXY($left_margin+155, $posY+15);
$pdf->Cell(150, 15,'お客様カード作成年月日', '1', '1', 'C','1');
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
$pdf->Cell(40, 15,'契担1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+378, $posY+15);
$pdf->Cell(40, 15,'契担2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+418, $posY+15);
$pdf->Cell(40, 15,'巡回1', '1', '1', 'C','1');
$pdf->SetXY($left_margin+458, $posY+15);
$pdf->Cell(40, 15,'巡回2', '1', '1', 'C','1');
$pdf->SetXY($left_margin+498, $posY+15);
$pdf->Cell(40, 15,'巡回3', '1', '1', 'C','1');
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

//得意先データ
$pdf->SetXY($left_margin+38, $posY+69);
$pdf->Cell(46, 104,'得意先', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+69);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+134, $posY+69);
$pdf->Cell(404, 12.5,$customer[0], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+81.5);
$pdf->Cell(50, 24.5,'納品先名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+81.5);
$pdf->Cell(404, 24.5,$customer[1], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+106);
$pdf->Cell(50, 15,'郵便番号', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+106);
$pdf->Cell(404, 15,$customer[2], '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+121);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+121);
$pdf->Cell(404, 12.5,$customer[3], '1', '1', 'L');
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+84, $posY+133.5);
$pdf->Cell(50, 24.5,'住　　所', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+133.5);
$pdf->Cell(404, 24.5,$customer[4], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+158);
$pdf->Cell(50, 15,'Ｔ Ｅ Ｌ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+158);
$pdf->Cell(114, 15,$customer[5], '1', '1', 'L');
$pdf->SetXY($left_margin+248, $posY+158);
$pdf->Cell(47, 15,'Ｆ Ａ Ｘ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+295, $posY+158);
$pdf->Cell(243, 15,$customer[6], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+173);
$pdf->Cell(46, 14.5,'代 表 者', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+173);
$pdf->Cell(454, 14.5,$representative[0], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+187.5);
$pdf->Cell(46, 14.5,'ご担当１', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+187.5);
$pdf->Cell(454, 14.5,$charge[0], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+202);
$pdf->Cell(46, 14.5,'ご担当２', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+202);
$pdf->Cell(454, 14.5,$charge[1], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+216.5);
$pdf->Cell(46, 14.5,'ご担当３', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+216.5);
$pdf->Cell(454, 14.5,$charge[2], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+231);
$pdf->Cell(46, 14.5,'ご担当４', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+231);
$pdf->Cell(454, 14.5,$charge[3], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+245.5);
$pdf->Cell(46, 14.5,'ご担当５', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+245.5);
$pdf->Cell(454, 14.5,$charge[4], '1', '1', 'L');
$pdf->SetXY($left_margin+38, $posY+260);
$pdf->Cell(46, 26,'営業時間', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+260);
$pdf->Cell(39, 13,$business[0], '1', '1', 'C');
$pdf->SetXY($left_margin+123, $posY+260);
$pdf->Cell(20, 13,'：', '1', '1', 'C');
$pdf->SetXY($left_margin+143, $posY+260);
$pdf->Cell(39, 13,$business[1], '1', '1', 'C');
$pdf->SetXY($left_margin+182, $posY+260);
$pdf->Cell(20, 13,'〜', '1', '1', 'C');
$pdf->SetXY($left_margin+202, $posY+260);
$pdf->Cell(39, 13,$business[2], '1', '1', 'C');
$pdf->SetXY($left_margin+241, $posY+260);
$pdf->Cell(20, 13,'：', '1', '1', 'C');
$pdf->SetXY($left_margin+261, $posY+260);
$pdf->Cell(39, 13,$business[3], '1', '1', 'C');
$pdf->SetXY($left_margin+300, $posY+260);
$pdf->Cell(29.5, 26,'休日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+329.5, $posY+260);
$pdf->Cell(60, 26,$holiday, '1', '1', 'C');
$pdf->SetXY($left_margin+389.5, $posY+260);
$pdf->Cell(48.5, 13,'業種', '1', '1', 'C','1');
$pdf->SetXY($left_margin+438, $posY+260);
$pdf->Cell(100, 13,$business[8], '1', '1', 'L');
$pdf->SetXY($left_margin+84, $posY+273);
$pdf->Cell(39, 13,$business[4], '1', '1', 'C');
$pdf->SetXY($left_margin+123, $posY+273);
$pdf->Cell(20, 13,'：', '1', '1', 'C');
$pdf->SetXY($left_margin+143, $posY+273);
$pdf->Cell(39, 13,$business[5], '1', '1', 'C');
$pdf->SetXY($left_margin+182, $posY+273);
$pdf->Cell(20, 13,'〜', '1', '1', 'C');
$pdf->SetXY($left_margin+202, $posY+273);
$pdf->Cell(39, 13,$business[6], '1', '1', 'C');
$pdf->SetXY($left_margin+241, $posY+273);
$pdf->Cell(20, 13,'：', '1', '1', 'C');
$pdf->SetXY($left_margin+261, $posY+273);
$pdf->Cell(39, 13,$business[7], '1', '1', 'C');
$pdf->SetXY($left_margin+389.5, $posY+273);
$pdf->Cell(48.5, 13,'業態', '1', '1', 'C','1');
$pdf->SetXY($left_margin+438, $posY+273);
$pdf->Cell(100, 13,$business[9], '1', '1', 'L');

//請求先データ
$pdf->SetXY($left_margin+38, $posY+289);
$pdf->Cell(46, 104,'請求先', '1', '1', 'C','1');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+289);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+289);
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->Cell(404, 12.5,$claim[1], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+301.5);
$pdf->Cell(50, 24.5,'請求先名', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+301.5);
$pdf->Cell(404, 24.5,$claim[2], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+326);
$pdf->Cell(50, 15,'郵便番号', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+326);
$pdf->Cell(404, 15,$claim[0], '1', '1', 'C');
$pdf->SetFont(GOTHIC,'', 8);
$pdf->SetXY($left_margin+84, $posY+341);
$pdf->Cell(50, 12.5,'フ リ ガ ナ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+341);
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->Cell(404, 12.5,$claim[3], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+353.5);
$pdf->Cell(50, 24.5,'住　　所', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+353.5);
$pdf->Cell(404, 24.5,$claim[4], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+378);
$pdf->Cell(50, 15,'Ｔ Ｅ Ｌ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+134, $posY+378);
$pdf->Cell(114, 15,$claim[5], '1', '1', 'C');
$pdf->SetXY($left_margin+248, $posY+378);
$pdf->Cell(47, 15,'Ｆ Ａ Ｘ', '1', '1', 'C','1');
$pdf->SetXY($left_margin+295, $posY+378);
$pdf->Cell(243, 15,$claim[6], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+393);
$pdf->Cell(46, 12.5,'代 表 者', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+393);
$pdf->Cell(454, 12.5,$representative[1], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+405.5);
$pdf->Cell(46, 12.5,'ご担当１', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+405.5);
$pdf->Cell(454, 12.5,$charge[5], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+418);
$pdf->Cell(46, 12.5,'ご担当２', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+418);
$pdf->Cell(454, 12.5,$charge[6], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+430.5);
$pdf->Cell(46, 12.5,'ご担当３', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+430.5);
$pdf->Cell(454, 12.5,$charge[7], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+443);
$pdf->Cell(46, 12.5,'ご担当４', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+443);
$pdf->Cell(454, 12.5,$charge[8], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+455.5);
$pdf->Cell(46, 12.5,'ご担当５', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+455.5);
$pdf->Cell(454, 12.5,$charge[9], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+468);
$pdf->Cell(46, 12.5,'締日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+84, $posY+468);
$pdf->Cell(100, 12.5,'支払日', '1', '1', 'C','1');
$pdf->SetXY($left_margin+184, $posY+468);
$pdf->Cell(50, 12.5,'支払方法', '1', '1', 'C','1');
$pdf->SetXY($left_margin+234, $posY+468);
$pdf->Cell(304, 12.5,'振込名義', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+480.5);
$pdf->Cell(46, 13,$payment[0], '1', '1', 'C');
$pdf->SetXY($left_margin+38, $posY+493.5);
$pdf->Cell(46, 13,$payment[1], '1', '1', 'C');
$pdf->SetXY($left_margin+84, $posY+480.5);
$pdf->Cell(50, 26,$payment[2], '1', '1', 'C');
$pdf->SetXY($left_margin+134, $posY+480.5);
$pdf->Cell(50, 26,$payment[3], '1', '1', 'C');
$pdf->SetXY($left_margin+184, $posY+480.5);
$pdf->Cell(50, 26,$payment[4], '1', '1', 'C');
$pdf->SetXY($left_margin+234, $posY+480.5);
$pdf->Cell(304, 26,$payment[5], '1', '1', 'C');

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
$pdf->SetXY($left_margin+318.2, $posY+696);
$pdf->Cell(30.8, 16.5,'内税合計', '1', '1', 'C','1');
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
$pdf->Cell(30.8, 16.5,'合 計', '1', '1', 'C','1');
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

$pdf->AddPage();
//ページ右側
$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+38, $posY+15);
$pdf->Cell(500, 13,'設備情報等・その他', '1', '1', 'C','1');

$pdf->SetFont(GOTHIC,'', 10.5);
$pdf->SetXY($left_margin+38, $posY+40);
$pdf->Cell(500, 13,'内容', '1', '1', 'C','1');
$pdf->SetXY($left_margin+38, $posY+53);
$pdf->Cell(500, 712,'', '1', '1', 'C');

$pdf->Output();


?>
