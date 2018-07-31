<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-060　　　　watanabe-k　サニタイズ処理を無効
 * 　2006/11/11　06-061　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-062　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-064　　　　watanabe-k　GETチェック追加
 * 　2007/07/06　      　　　　watanabe-k　ショップ名に本部が表示されているバグの修正
 *
 */


//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth = Auth_Check($conn);

/****************************/
//外部変数取得
/****************************/
$order_id = $_GET["ord_id"];
Get_Id_Check3($order_id);
Get_Id_Check2($order_id);

$client_id = $_SESSION["client_id"];


/****************************/
//発注書出力フラグ更新
/****************************/
$sql  = "SELECT";
$sql .= "   count(*)";
$sql .= " FROM";
$sql .= "   t_order_h";
$sql .= " WHERE";
$sql .= "   ord_id = $order_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$ord_num = pg_num_rows($result);

Db_Query($conn, "BEGIN;");

if($ord_num != 0){
    $sql  = "UPDATE";
    $sql .= "   t_order_h";
    $sql .= " SET";
    $sql .= "   ord_sheet_flg = 't'";
    $sql .= " WHERE";
    $sql .= "   ord_id = $order_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    if($result === false){
        $result = Db_Query($conn, "ROLLBACK;");
        exit;
    }
}

Db_Query($conn, "COMMIT;");

/****************************/
//DB値設定
/****************************/
$sql  = "SELECT ";
$sql .= "o_memo1, ";		//FAX
$sql .= "o_memo2, ";		//TEL
$sql .= "o_memo3, ";		//注文書コメント3
$sql .= "o_memo4, ";		//注文書コメント4
$sql .= "o_memo5, ";		//注文書コメント5
$sql .= "o_memo6, ";		//注文書コメント6
$sql .= "o_memo7, ";		//注文書コメント7
$sql .= "o_memo8 ";			//注文書コメント8
$sql .= "FROM ";
$sql .= "t_h_ledger_sheet;";
$result = Db_Query($conn,$sql);

//DBの値を配列に保存
$o_memo = Get_Data($result);
/***************************/
//発注ヘッダ
/***************************/
$sql  = "SELECT\n";
//$sql .= "   t_client.client_name,\n";
$sql .= "   t_order_h.my_client_name,\n";
//$sql .= "   t_staff.staff_name,\n";
$sql .= "   t_order_h.c_staff_name,\n";
$sql .= "   t_order_h.note_your,\n";
$sql .= "   t_order_h.hope_day,\n";
$sql .= "   CASE t_order_h.green_flg\n";
$sql .= "       WHEN true  THEN '有'\n";
$sql .= "       WHEN false THEN '無'\n";
$sql .= "   END,\n";
$sql .= "   t_order_h.note_my, \n";
$sql .= "   t_order_h.direct_name \n";
$sql .= " FROM\n";
$sql .= "   t_order_h,\n";
$sql .= "   t_staff,\n";
$sql .= "   t_client\n";
$sql .= " WHERE\n";
$sql .= "   t_order_h.shop_id = $client_id\n";
$sql .= "   AND\n";
$sql .= "   t_order_h.shop_id = t_client.client_id\n";
$sql .= "   AND\n";
$sql .= "   t_order_h.c_staff_id = t_staff.staff_id\n";
$sql .= "   AND\n";
$sql .= "   t_order_h.ord_id = $order_id\n";
$sql .= "   AND\n";
$sql .= "   t_order_h.ord_stat IS NOT NULL\n";
$sql .= ";";
$result = Db_Query($conn,$sql);
Get_Id_Check($result);
$ord_h_data = Get_Data($result,2);

$shop_name  = stripslashes($ord_h_data[0][0]);
$staff_name = stripslashes($ord_h_data[0][1]);
$note_your  = str_replace("\n","",pg_fetch_result($result,0,2));
$note_my    = str_replace("\n","",pg_fetch_result($result,0,5));
$hope_day   = $ord_h_data[0][3];
$green_flg  = $ord_h_data[0][4];
$direct_name= $ord_h_data[0][6];

//希望納期
if($hope_day != "" ){
    $hope_date = explode("-",$hope_day);
    $hope_date["0"] = $hope_date["0"] - 1988;
}else{
    $hope_date = array("　","　","　");
}
/*******************************/
//発注データ
/*******************************/
$sql  = " SELECT";
//$sql .= "   t_goods.goods_name,";
$sql .= "   t_order_d.goods_name,";
$sql .= "   t_order_d.num,";
$sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd') ";  //発注日
$sql .= " FROM";
$sql .= "   t_order_h,";
$sql .= "   t_order_d";
//$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   t_order_h.ord_id = $order_id";
$sql .= "   AND";
$sql .= "   t_order_h.ord_id = t_order_d.ord_id";
$sql .= "   AND";
$sql .= "   t_order_h.shop_id = $client_id";
//$sql .= "   AND";
//$sql .= "   t_order_d.goods_id = t_goods.goods_id";
//$sql .= " ORDER BY t_goods.goods_cd";
$sql .= " ORDER BY t_order_d.line;";
$sql .= ";";

$result = Db_Query($conn,$sql);
$order_d_data = Get_Data($result,2);

$order_data_num = count($order_d_data);

$page_num = ceil($order_data_num / 15);

$order_day[y] = substr($order_d_data[0][2],0,4);
$order_day[y] = $order_day[y] - 1988;
$order_day[m] = substr($order_d_data[0][2],5,2);
$order_day[d] = substr($order_d_data[0][2],8,2);

/*****************************/
//その他
/****************************/
//作成日
/*
$year   = date("Y");
$year   = $year - 1989 ;
$monty  = date("m");
$day    = date("d");

/*********************************************/

$pdf=new MBFPDF('P','mm','A4');

$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(PGOTHIC,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->AddMBFont(PMINCHO,'SJIS');
$pdf->AddMBFont(KOZMIN ,'SJIS');
$pdf->SetFont(GOTHIC, 'B', 11);
$pdf->SetAutoPageBreak(false);

//変数登録
$make_day = "平成　".$order_day[y]." 年 ".$order_day[m]." 月 ".$order_day[d]." 日";
$shop_name = $shop_name;
$tantou_name = $staff_name;
$communication_main = $note_your." \n ";
$communication_sub = $note_my." \n ";
$goods_slip_no = "01234";
$goods_ed = "○";
$goods_plan = "×";
$order_no = "56789";
$hope_day = "平成　　".$hope_date[0]."年　".$hope_date[1]."月　".$hope_date[2]."日";
$green = $green_flg;
$order_count = $order_data_num;
$transport = "";
$out_plan = "平成　　　年　　月　　日";
$in_plan = "平成　　　年　　月　　日";
$published = "";
$answer = "";
$cost_conf = "";
$packing = "";
$cost_post = "";
$out_day = "　　　年　　月　　日";

for($page = 1; $page <= $page_num; $page++){
$pdf->AddPage();
    //表示箇所の設定 ------------------------------------------------
    //背景色
    $pdf->SetFillColor(210,210,210);
    //$pdf->SetXY(71.5, 14);
    $pdf->SetXY(71.5, 11);
    $pdf->SetFont(GOTHIC, 'B','20');
    $pdf->Cell(71.5,10,'商 品 注 文 書','0','1','C');

    $pdf->Image(IMAGE_DIR."company-rogo.PNG",161.5,12,35,10);

    $pdf->SetFont(GOTHIC, '','10');
    $pdf->SetXY(150, 5);
    $pdf->Cell(71.5,10,$page.'/'.$page_num.'ページ','0','1','C');

    $pdf->SetFont(GOTHIC, 'B','11');
    $pdf->SetXY(146.5, 27);
    $pdf->Cell(50,7,$make_day,'0','1','R');

    $pdf->SetXY(101.5,35.5);
    $pdf->Cell(60,5,"ショップ名",'0','1','C');

    $pdf->SetXY(161.5,35.5);
    $pdf->Cell(35,5,"ご担当者名",'0','1','C');

    $pdf->SetXY(101.5,40);
    $pdf->SetFont(GOTHIC, 'B','9');
    $pdf->Cell(60,10,$shop_name,'0','1','C');

    $pdf->SetXY(161.5,40);
    $pdf->SetFont(GOTHIC, 'B','9');
    $pdf->Cell(35,10,$tantou_name,'0','1','C');

    /////$pdf->SetXY(11.5, 31); // 12
    $pdf->SetXY(11.5, 19);
    $pdf->SetFont(GOTHIC, 'B','16');
    $pdf->Cell(63,7,'アメニティ本部宛','0','1','L');

    /////$pdf->SetXY(11.5, 39); // 12
    $pdf->SetXY(11.5, 27);
    $pdf->SetFont(GOTHIC, 'B','14');
    $pdf->Cell(75,6,'ご注文専用ＦＡＸ:'.$o_memo[0][0],'0','1','L');

    $pdf->SetFont(GOTHIC, 'B','11');

    /////$pdf->SetXY(11.5, 45); // 12
    $pdf->SetXY(11.5, 33);
    $pdf->Cell(35,7,'TEL:'.$o_memo[0][1],'0','1','L');

    // 直送先
    $pdf->Rect(11.5,40,88,10);
    $pdf->SetXY(11.5, 39.5);
    $pdf->SetFont(GOTHIC, 'B','10');
    $pdf->Cell(35,7,'直送先','0','1','L');
    $pdf->SetXY(11.5, 44);
    $pdf->SetFont(GOTHIC, 'B','9');
    $pdf->Cell(35,7,"$direct_name",'0','1','L');

    $pdf->SetLineWidth(0.2);
    //$pdf->RoundedRect(100, 28, 95, 15, 2, '');
    $pdf->Rect(101.5,35,95,15);
    $pdf->Line(101.5,40,196.5,40);
    $pdf->Line(161.5,35,161.5,50);
    $pdf->Rect(11.5,52,106.5,22);
    //$pdf->Line(115,45,115,67);
//    $pdf->Rect(11.5,76,105,107);
//    $pdf->Line(21.5,76,21.5,183);
    $pdf->Rect(11.5,185,185,10);
    $pdf->Rect(11.5,228,185,20);
    $pdf->Rect(11.5,251,185,15);

    $pdf->Rect(104,52,92.5,22);

    $pdf->SetXY(104.5, 52.2);
    $pdf->Cell(92,21.6,'','LR','2','L','1');
    $pdf->SetXY(11.5, 52);
    $pdf->SetFont(GOTHIC, 'B','10');
    $pdf->Cell(92.5,8,'','0','2','L');
    $pdf->SetXY(11.5, 54);
    $pdf->Cell(92.5,2,'通信欄(加盟店⇒本部)','0','2','L');
    $pdf->SetFont(GOTHIC, '','10');
    $pdf->SetXY(11.5, 58);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(11.5, 62);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(11.5, 66);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(11.5, 70);
    $pdf->Cell(92.5,2,'','0','2','L');

    $pdf->SetXY(104, 52);
    $pdf->SetFont(GOTHIC, 'B','10');
    $pdf->Cell(92.5,8,'','0','1','L');
    $pdf->SetXY(105.5, 54);
    $pdf->Cell(92.5,2,'通信欄(本部⇒加盟店)','0','1','L');
    $pdf->SetFont(GOTHIC, '','10');
    $pdf->SetXY(104, 58);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(104, 62);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(104, 66);
    $pdf->Cell(92.5,2,'','0','2','L');
    $pdf->SetXY(104, 70);
    $pdf->Cell(92.5,2,'','0','2','L');

    $pdf->SetXY(11.5, 60);
    $pdf->MultiCell(92.5,5,"$communication_main",'0','1','L');

    $pdf->SetXY(105.5, 60);
    $pdf->MultiCell(92.5,5,"$communication_sub",'0','1','L');

    $pdf->SetXY(11.5, 76);
    $pdf->Cell(10,7,'件数','1','1','C');

    $pdf->SetXY(21.5, 76);
    $pdf->Cell(70,7,'商品名','1','1','C');

    $pdf->SetXY(91.5, 76);
    $pdf->Cell(25,7,'数量','1','1','C');

    $pdf->SetXY(116.5, 76);
    $pdf->Cell(25,7,'伝票No','1','1','C','1');

    $pdf->SetXY(141.5, 76);
    $pdf->Cell(15,7,'出荷完','1','1','C','1');

    $pdf->SetXY(156.5, 76);
    $pdf->Cell(15,7,'出荷予','1','1','C','1');

    $pdf->SetXY(171.5, 76);
    $pdf->Cell(25,7,'受注No','1','1','C','1');

    //商品欄
    $a = 0;
    for($i=0+(($page-1)*15); $i< 15*$page; $i++){

	    $i_count = $i+1;
	    $j = $a*6.6+83;

	    $pdf->SetXY(11.5, $j);
	    $pdf->Cell(10,6.6,"$i_count",'1','0','C');
        $pdf->SetFont(GOTHIC, '','6.5');
	    $pdf->Cell(70,6.6,$order_d_data[$i][0],'1','0','L');
        $pdf->SetFont(GOTHIC, '','10');
	    $pdf->Cell(25,6.6,$order_d_data[$i][1],'1','0','R');
	    $pdf->Cell(25,6.6,'','1','0','C');
	    $pdf->Cell(15,6.6,'','1','0','C');
	    $pdf->Cell(15,6.6,'','1','0','C');
	    $pdf->Cell(25,6.6,'','1','0','C');
        $a = $a+1;
    }
    $pdf->SetXY(11.5, 185);
    $pdf->Cell(18,10,'希望納期','1','1','C');

    $pdf->SetXY(29.5, 185);
    $pdf->Cell(48,10,$hope_day,'1','1','C');

    $pdf->SetXY(77.5, 185.5);
    $pdf->Cell(24,5,"グリーン",'0','1','C');

    $pdf->SetXY(77.5, 190);
    $pdf->Cell(24,5,"指定業者名",'0','1','C');

    $pdf->SetXY(101.5, 185);
    $pdf->Cell(53,10,"$green",'1','1','C');

    $pdf->SetXY(154.5, 185);
    $pdf->Cell(18,10,"発注件数",'1','1','C');

    $pdf->SetXY(172.5, 185);
    $pdf->Cell(19,10,"$order_count",'0','1','C');

    $pdf->SetXY(191.5, 185);
    $pdf->Cell(5,10,"件",'0','1','C');

    $pdf->SetFont('','','8.5');

    $pdf->SetXY(11.5,196);
    $pdf->Cell(185,4,$o_memo[0][3],'0','1','L');
    $pdf->SetX(11.5);
    $pdf->Cell(185,4,$o_memo[0][4],'0','1','L');
    $pdf->SetX(11.5);
    $pdf->Cell(185,4,$o_memo[0][5],'0','1','L');
    $pdf->SetX(11.5);
    $pdf->Cell(185,4,$o_memo[0][6],'0','1','L');
    $pdf->SetX(11.5);
    $pdf->Cell(185,4,$o_memo[0][7],'0','1','L');
    $pdf->SetX(11.5);
    $pdf->Cell(185,4,$o_memo[0][8],'0','1','L');


    $pdf->SetFont(GOTHIC,'B','11');

    $j = 0;
    For($i=11.5;$i<91.5;){
	    $j = $i+2;
	    $pdf->Line($i,224.5,$j,224.5);
	    $i = $j + 1;
    }
    $j = 0;
    For($i=116.5;$i<196.5;){
	    $j = $i+2;
	    $pdf->Line($i,224.5,$j,224.5);
	    $i = $j + 1;
    }

    $pdf->SetXY(11.5,221);
    $pdf->Cell(185,7,"本部記入欄",'0','1','C');

    $pdf->SetXY(11.5,228);
    $pdf->Cell(18,10,"運送会社",'0','1','C');

    $pdf->SetXY(29.5,228);
    $pdf->Cell(73,20,"$transport",'1','1','C','1');

    $pdf->SetXY(102.5,228);
    $pdf->Cell(17,10,"出荷予定",'1','1','C');
    $pdf->SetXY(119.5,228);
    $pdf->Cell(77,10,"$out_plan",'1','1','C','1');

    $pdf->SetXY(102.5,238);
    $pdf->Cell(17,10,"着荷予定",'1','1','C');
    $pdf->SetXY(119.5,238);
    $pdf->Cell(77,10,"$in_plan",'1','1','C','1');



    $pdf->SetXY(10.5,254);
    $pdf->Cell(15,4.5,"伝　票",'0','2','C');
    $pdf->Cell(15,4.5,"発　行",'0','2','C');

    $pdf->SetXY(24.5,251);
    $pdf->Cell(24,15,"$published",'1','1','C','1');

    $pdf->SetXY(47.5,254);
    $pdf->Cell(15,4.5,"納　期",'0','2','C');
    $pdf->Cell(15,4.5,"返　信",'0','2','C');

    $pdf->SetXY(61.5,251);
    $pdf->Cell(24,15,"$answer",'1','1','C','1');

    $pdf->SetXY(84.5,252);
    $pdf->Cell(15,4.5,"売　上",'0','2','C');
    $pdf->Cell(15,4.5,"伝　票",'0','2','C');
    $pdf->Cell(15,4.5,"確　認",'0','2','C');

    $pdf->SetXY(98.5,251);
    $pdf->Cell(24,15,"$cost_conf",'1','1','C','1');

    $pdf->SetXY(121.5,254);
    $pdf->Cell(15,4.5,"商　品",'0','2','C');
    $pdf->Cell(15,4.5,"梱　包",'0','2','C');

    $pdf->SetXY(135.5,251);
    $pdf->Cell(24,15,"$packing",'1','1','C','1');

    $pdf->SetXY(158.5,254);
    $pdf->Cell(15,4.5,"梱　包",'0','2','C');
    $pdf->Cell(15,4.5,"確　認",'0','2','C');

    $pdf->SetXY(172.5,251);
    $pdf->Cell(24,15,"$cost_post",'1','1','C','1');



    $pdf->SetXY(11.5,271);
    $pdf->Cell(15,7,"特記",'0','1','L');


    $pdf->SetFont(GOTHIC,'BU','11');
    $pdf->SetXY(116.5,278);
    $pdf->Cell(80,5,"出荷年月日　　　".$out_day,'0','2','R');

}
// --------------------------------------------------------------

$pdf->Output();

?>
