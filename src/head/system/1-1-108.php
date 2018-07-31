<?php

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

$staff_id = $_GET[staff_id];

// staff_idの正当性チェック
if ($_GET["staff_id"] != null && Get_Id_Check_Db($db_con, $_GET["staff_id"], "staff_id", "t_staff", "num") != true){
    $valid_flg = true;
}elseif ($_GET["staff_id"] == null){
    $valid_flg = true;
}
if ($valid_flg == true){
    print "<span style=\"color: #ff0000; font-weight: bold; line-height: 130%; font-size: 14px;\">";
    print "<li>存在しないスタッフです</li>";
    print "</span><br>";
}
// 日付の正当性チェック
if ($_GET["y"] != null || $_GET["m"] != null || $_GET["d"] != null){
    $date_y = (int)$_GET["y"];
    $date_m = (int)$_GET["m"];
    $date_d = (int)$_GET["d"];
    $date_err_flg = !checkdate($date_m, $date_d, $date_y) ? true : false;
}else{
    $date_y = date("Y");
    $date_m = date("m");
    $date_d = date("d");
}
if ($date_err_flg == true){
    print "<span style=\"color: #ff0000; font-weight: bold; line-height: 130%; font-size: 14px;\">";
    print "<li>発行日が正しくありません</li>";
    print "</span><br>";
}

///// ここから下はGETのチェックに合格した時だけ！
if ($valid_flg == false && $date_err_flg == false){

$sql  = "SELECT ";
$sql .= " t_staff.staff_cd1, ";                   //スタッフコード１
$sql .= " t_staff.staff_cd2, ";                   //スタッフコード２
$sql .= " t_client.shop_name, ";                  //ショップ名
$sql .= " t_staff.staff_name, ";                  //スタッフ名
$sql .= " t_staff.staff_ascii, ";                 //スタッフ名(ローマ字)
$sql .= " t_client.client_name, ";                //社名
$sql .= " t_client.address1, ";                   //住所１
$sql .= " t_client.address2, ";                   //住所２
$sql .= " t_client.tel, ";                        //電話番号
$sql .= " t_staff.photo ";                        //写真
$sql .= "FROM ";
$sql .= " t_client, ";
$sql .= " t_staff ";
$sql .= "LEFT JOIN ";
$sql .= " t_login ";
$sql .= "ON ";
$sql .= " t_staff.staff_id = t_login.staff_id ";
$sql .= "WHERE ";
$sql .= " t_staff.staff_id = $staff_id;";
$result = Db_Query($db_con,$sql);

$label_out = pg_fetch_array($result);
/*********************************************/

$pdf=new MBFPDF('P','pt','a4');
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(PGOTHIC,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->AddMBFont(PMINCHO,'SJIS');
$pdf->AddMBFont(KOZMIN ,'SJIS');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

//余白指定
$left_margin = 40;
$top_margin = 40;

//枠指定
$pdf->SetXY($left_margin,$top_margin);
$pdf->Rect($left_margin,$top_margin,220,150.5);

$pdf->SetFont(GOTHIC, 'B', 6);

//ID
$pdf->SetXY($left_margin+162,$top_margin+7.5);
$pdf->Cell(38,8,"ＩＤ：$label_out[0]-$label_out[1]",'0','1','L');

//発行日
$pdf->SetXY($left_margin+150,$top_margin+15);
$pdf->Cell(38,8,$date_y."年 ".$date_m."月 ".$date_d."日発行",'0','1','L');

//ショップ名
$pdf->SetFont(GOTHIC, 'B', 7.5);
$pdf->SetXY($left_margin+106,$top_margin+33);
$pdf->Cell(85,8,"アメニティネットワーク加盟店",'0','1','L');
$pdf->SetFont(GOTHIC, 'B', 9);
$pdf->SetXY($left_margin+106,$top_margin+43);
$pdf->Cell(110,16,$label_out[2],'0','1','R');

//名前
$pdf->SetFont(GOTHIC, 'B', 14);
$pdf->SetXY($left_margin+103,$top_margin+70);
$pdf->Cell(90,16,$label_out[3],'0','1','C');

//ローマ字
$pdf->SetFont(GOTHIC, 'B', 9);
$pdf->SetXY($left_margin+103,$top_margin+90);
$pdf->Cell(90,16,$label_out[4],'0','1','C');

//上記の者
$pdf->SetFont(GOTHIC, '', 6.5);
$pdf->SetXY($left_margin+108,$top_margin+106);
$pdf->Cell(85,16,"上記の者をアメニティネットワークの",'0','1','C');
$pdf->SetXY($left_margin+101,$top_margin+113);
$pdf->Cell(85,16,"メンバーであることを証明する。",'0','1','C');

//tel
$pdf->SetFont(GOTHIC, '', 6);
$pdf->SetXY($left_margin+145,$top_margin+135);
$pdf->Cell(85,16,"tel：".$label_out[8],'0','1','C');

//色
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(204,255,255);
$pdf->SetFillColor(204,255,255);
$pdf->SetXY($left_margin+0.5,$top_margin+0.5);
$pdf->Cell($left_margin+25.5,$top_margin+109.5,"",'0','1','L','1');
$pdf->Line(100,144,257,144);

//ロゴ
$pdf->Image(IMAGE_DIR.'company-rogo_clear.png',$left_margin+7, $top_margin+2,80,26);

//AMENITY
$pdf->SetFont(GOTHIC, '', 7);
$pdf->SetXY($left_margin+13,$top_margin+25);
$pdf->Cell(85,16,"AMENITY NETWORK",'0','1','L');
$pdf->SetXY($left_margin+4,$top_margin+34);
$pdf->Cell(76.3,16,"ID CARD",'0','1','C');
if($label_out[9] != null){
	//写真
	$pdf->SetFillColor(255,255,255);
	$pdf->Image('../../../data/photo/'.$label_out[9],$left_margin+15.37, $top_margin+50,62,65);
	$pdf->Image(IMAGE_DIR.'fframe.png',$left_margin+15.37, $top_margin+50,62,65);
}
//住所
$pdf->SetFont(GOTHIC, '', 6);
$pdf->SetXY($left_margin+4,$top_margin+125);
$pdf->Cell(85,16,$label_out[5],'0','1','L');
$pdf->SetXY($left_margin+9,$top_margin+134);
$pdf->Cell(85,16,$label_out[6].$label_out[7],'0','1','L');

$pdf->Output();

}

?>
