<?php
//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

$conn = Db_Connect();

/************************************************/
//外部変数取得箇所
/************************************************/
$shop_aid       = $_SESSION["shop_aid"];
$shop_gid       = $_SESSION["shop_gid"];

$slip_no        = $_POST["form_slip_no"];
$order_no       = $_POST["form_ord_no"];
$buy_sday["y"]  = $_POST["form_buy_day"]["start_y"];
$buy_sday["m"]  = $_POST["form_buy_day"]["start_m"];
$buy_sday["d"]  = $_POST["form_buy_day"]["start_d"];
$buy_eday["y"]  = $_POST["form_buy_day"]["end_y"];
$buy_eday["m"]  = $_POST["form_buy_day"]["end_m"];
$buy_eday["d"]  = $_POST["form_buy_day"]["end_d"];
$client_cd      = $_POST["form_buy_cd"];
$client_name    = $_POST["form_buy_name"];
$buy_samount    = $_POST["form_buy_amount"]["start"];
$buy_eamount    = $_POST["form_buy_amount"]["end"];

$renew          = $_POST["form_renew"];

//*********************************//
//エラーチェック入力箇所
//*********************************//


//*********************************//
//帳票の構成入力箇所
//*********************************//
//余白
$left_margin = 40;
$top_margin = 40;

//ヘッダーのフォントサイズ
$font_size = 9;
//ページサイズ
$page_size = 1110;

//A3
$pdf=new MBFPDF('L','pt','A3');

//ページ最大表示数
$page_max = 50;

//*********************************//
//ヘッダ項目入力箇所
//*********************************//
//タイトル
$title = "仕入一覧表";
$page_count = 1; 

if($_POST["form_renew"] == "2"){
    $renew_flg = true;
}elseif($_POST["form_renew"] == "3"){
    $renew_flg = false;
}

//ヘッダに表示する時刻作成
$time = "仕入日：";

if($buy_sday["y"] != null){
    $time .= $buy_sday["y"]."年".$buy_sday["m"]."月".$buy_sday["d"]."日";
}else{
    $sql  = "SELECT";
    $sql .= "   MIN(buy_day)";
    $sql .= " FROM";
    $sql .= "   t_buy_h";
    $sql .= " WHERE";
    $sql .= "   shop_aid = $shop_aid";
    $sql .= ";";

    $result = Db_Query($conn, $sql);    
    $buy_day = pg_fetch_result($result,0,0);

    $buy_day = explode("-",$buy_day);

    $time .= $buy_day[0]."年".$buy_day[1]."月".$buy_day[2]."日";
}

$time .= "〜";

if($buy_eday["y"] != null){
    $time .= $buy_eday["y"]."年".$buy_eday["m"]."月".$buy_eday["d"]."日";
}else{
    $sql  = "SELECT";
    $sql .= "   MAX(buy_day)";
    $sql .= " FROM";
    $sql .= "   t_buy_h";
    $sql .= " WHERE";
    $sql .= "   shop_aid = $shop_aid";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $buy_day = pg_fetch_result($result,0,0);

    $buy_day = explode("-",$buy_day);

    $time .= $buy_day[0]."年".$buy_day[1]."月".$buy_day[2]."日";
}

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("130","仕入先","C");
$list[2] = array("40","伝票番号","C");
$list[3] = array("60","取引区分","C");
$list[4] = array("50","仕入日","C");
$list[5] = array("245","商品名","C");
$list[6] = array("70","仕入数","C");
$list[7] = array("30","課税区分","C");
$list[8] = array("70","仕入単価","C");
$list[9] = array("70","仕入金額","C");
$list[10] = array("100","仕入倉庫","C");
$list[11] = array("40","発注番号","C");
$list[12] = array("175","備考","C");

//*********************************//
//データ項目入力箇所
//*********************************//
//仕入先計・総合計（消費税/税込計）
$list_sub[0] = array("30","","R");
$list_sub[1] = array("200","仕入先計：","L");
$list_sub[2] = array("200","総合計：","L");
$list_sub[3] = array("70","","R");
$list_sub[4] = array("70","　　消費税：","L");
$list_sub[5] = array("70","","R");
$list_sub[6] = array("70","　　税込計：","L");
$list_sub[7] = array("70","","R");
$list_sub[8] = array("530","","C");

//伝票計（消費税/税込計）
$list_sub2[0] = array("30","","R");
$list_sub2[1] = array("130","","C");
$list_sub2[2] = array("70","伝票計：","L");
$list_sub2[3] = array("70","","R");
$list_sub2[4] = array("70","　　消費税：","L");
$list_sub2[5] = array("70","","R");
$list_sub2[6] = array("70","　　税込計：","L");
$list_sub2[7] = array("70","","R");
$list_sub2[8] = array("530","","C");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "C";
$data_align[5] = "L";
$data_align[6] = "R";
$data_align[7] = "C";
$data_align[8] = "R";
$data_align[9] = "R";
$data_align[10] = "L";
$data_align[11] = "L";
$data_align[12] = "L";

//***********************
//出力データ取得箇所
//***********************
if($renew == '1' || $renew == '2'){
    $sql  = "SELECT";
    $sql .= "   t_buy_h.client_name,";
    $sql .= "   t_buy_h.buy_no,";
	$sql .= "   CASE t_buy_h.trade_id";            
    $sql .= "       WHEN '21' THEN '掛仕入'";
    $sql .= "       WHEN '22' THEN '掛仕入(-)'";
	$sql .= "       WHEN '23' THEN '掛返品'";
    $sql .= "       WHEN '24' THEN '掛値引'";
    $sql .= "       WHEN '71' THEN '現金仕入'";
	$sql .= "       WHEN '72' THEN '現金仕入(-)'";
	$sql .= "       WHEN '73' THEN '現金返品'";
    $sql .= "       WHEN '74' THEN '現金値引'";
    $sql .= "   END,";
    $sql .= "   t_buy_h.buy_day,";
    $sql .= "   t_buy_d.goods_name,";
    $sql .= "   t_buy_d.num,";
	$sql .= "   CASE t_buy_d.tax_div";
    $sql .= "       WHEN '1' THEN '外税'";
    $sql .= "       WHEN '2' THEN '内税'";
    $sql .= "       WHEN '3' THEN '非課税'";
    $sql .= "   END,";
    $sql .= "   t_buy_d.buy_price,";
    $sql .= "   t_buy_d.buy_amount,";
    $sql .= "   t_buy_h.ware_name,";
    $sql .= "   t_order_h.ord_no,";
	$sql .= "   t_buy_h.note,";
	$sql .= "   t_buy_h.client_id,";
	$sql .= "   t_buy_d.tax_amount";
    $sql .= " FROM";
    $sql .= "   t_buy_h LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id";
    $sql .= "   LEFT JOIN"; 
    $sql .= "   (SELECT";
    $sql .= "   buy_id, ";
    $sql .= "   goods_name,";
    $sql .= "   SUM(num) AS num,";
	$sql .= "   tax_div,";
    $sql .= "   buy_price,";
    $sql .= "   SUM(buy_amount) AS buy_amount,";
    $sql .= "   SUM(tax_amount) AS tax_amount";
    $sql .= "   FROM ";
    $sql .= "   t_buy_d ";
    $sql .= "   GROUP BY buy_id, goods_name, tax_div,buy_price ";
    $sql .= "   )AS t_buy_d ";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id";
    $sql .= " WHERE ";
    $sql .= "   t_buy_h.shop_aid = $shop_aid";
    //伝票番号が指定された場合
    if($buy_no != null){
        $sql .= "   AND";
        $sql .= "   t_buy_h.buy_cd LIKE '$buy_no%'";
    }
    //発注番号が指定された場合
    if($order_no != null){
        $sql .= "   AND ";
        $sql .= "   t_order_h.ord_no LIKE '$order_no%'";
    }
    //仕入開始日が指定された場合
    if($buy_sdat["y"] != null){
        $sql .= "   AND ";
        $sql .= "   '".$buy_sday["y"]."-".$buy_sday["m"]."-".$buy_sday["d"]."' <= t_buy_h.buy_day";
    }
    //仕入終了日が指定された場合
    if($buy_eday["y"] != null){
        $sql .= "   AND";
        $sql .= "   t_buy_h.buy_day <= '".$buy_sday["y"]."-".$buy_sday["m"]."-".$buy_sday["d"]."'";
    }
    //仕入先コードが指定された場合
    if($client_cd != null){
        $sql .= "   AND ";
        $sql .= "   t_buy_h.client_cd1 LIKE '$client_cd%'";
    }
    //仕入先名が指定された場合
    if($client_name != null){
        $sql .= "   AND";
        $sql .= "   t_buy_h.client_name LIKE '%$client_name%'";
    }
    //仕入金額が指定された場合
    if($buy_samount != null){
        $sql .= "   AND";
        $sql .= "   $buy_samount <= t_buy_d.buy_amount";
    }
    //仕入金額が指定された場合
    if($buy_eamount != null){
        $sql .= "   AND";
        $sql .= "   t_buy_d.buy_amount <= $eamount";
    }
    $sql .= "   AND";
    $sql .= "   t_buy_h.renew_flg = 't'";
}
if($renew == '1'){
    $sql .= " UNION ALL";
}

if($renew == '1' || $renew == '3'){
    $sql .= " SELECT ";   
    $sql .= "   t_client.client_name,";
    $sql .= "   t_buy_h.buy_no, ";
    $sql .= "   CASE t_buy_h.trade_id";            
    $sql .= "       WHEN '21' THEN '掛仕入'";
    $sql .= "       WHEN '22' THEN '掛仕入(-)'";
	$sql .= "       WHEN '23' THEN '掛返品'";
    $sql .= "       WHEN '24' THEN '掛値引'";
    $sql .= "       WHEN '71' THEN '現金仕入'";
	$sql .= "       WHEN '72' THEN '現金仕入(-)'";
	$sql .= "       WHEN '73' THEN '現金返品'";
    $sql .= "       WHEN '74' THEN '現金値引'";
    $sql .= "   END,";
    $sql .= "   t_buy_h.buy_day,";
    $sql .= "   t_buy_d.goods_name,";
    $sql .= "   t_buy_d.num,";
	$sql .= "   CASE t_buy_d.tax_div";
    $sql .= "       WHEN '1' THEN '外税'";
    $sql .= "       WHEN '2' THEN '内税'";
    $sql .= "       WHEN '3' THEN '非課税'";
    $sql .= "   END,";
    $sql .= "   t_buy_d.buy_price,";
    $sql .= "   t_buy_d.buy_amount,";
    $sql .= "   t_ware.ware_name,";
    $sql .= "   t_order_h.ord_no,";
	$sql .= "   t_buy_h.note,";
	$sql .= "   t_buy_h.client_id,";
	$sql .= "   t_buy_d.tax_amount";
    $sql .= " FROM";
    $sql .= "   t_buy_h LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id";
    $sql .= "   LEFT JOIN"; 
    $sql .= "   (SELECT";
    $sql .= "   buy_id,";
    $sql .= "   goods_name,";
    $sql .= "   SUM(num) AS num,";
	$sql .= "   tax_div,";
    $sql .= "   SUM(buy_amount) AS buy_amount,";
    $sql .= "   SUM(tax_amount) AS tax_amount,";
    $sql .= "   buy_price";
    $sql .= "   FROM";
    $sql .= "   t_buy_d";
    $sql .= "   GROUP BY buy_id, goods_name, tax_div,buy_price ";
    $sql .= "   )AS t_buy_d ";
    $sql .= "   ON t_buy_h.buy_id = t_buy_d.buy_id";
    $sql .= "   INNER JOIN t_client ON t_buy_h.client_id = t_client.client_id";
    $sql .= "   INNER JOIN t_ware ON t_buy_h.ware_id = t_ware.ware_id";
    $sql .= " WHERE";
    $sql .= "   t_buy_h.shop_aid = $shop_aid";
    if($buy_no != null){
        $sql .= "   AND ";
        $sql .= "   t_buy_h.buy_cd LIKE '$buy_no%'";
    }
    if($order_no != null){
        $sql .= "   AND ";
        $sql .= "   t_order_h.ord_no LIKE '$order_no%'";
    }
    if($buy_sday["y"] != null){
        $sql .= "   AND ";
        $sql .= "   '".$buy_sday["y"]."-".$buy_sday["m"]."-".$buy_sday["d"]."' <= t_buy_h.buy_day";
    }
    if($buy_eday["y"] != null){
        $sql .= "   AND ";
        $sql .= "   t_buy_h.buy_day <= '".$buy_sday["y"]."-".$buy_sday["m"]."-".$buy_sday["d"]."'";
    }
    if($client_cd != null){
        $sql .= "   AND ";
        $sql .= "   t_client.client_cd1 LIKE '$client_cd%' ";
    }
    if($client_name != null){
        $sql .= "   AND ";
        $sql .= "   t_client.client_name LIKE '%$client_name%'";
    }
    if($buy_samount != null){
        $sql .= "   AND ";
        $sql .= "   $buy_samount <= t_buy_d.buy_amount";
    }
    if($buy_eamount != null){
        $sql .= "   AND ";
        $sql .= "   t_buy_d.buy_amount <= $buy_eamount";
    }
    $sql .= "   AND ";
    $sql .= "   t_buy_h.renew_flg = 'f'";
    $sql .= " ORDER BY buy_no DESC ";
}

$sql .= ";";
$result = Db_Query($conn, $sql);

$data_num = pg_num_rows($result);
$data_list = Get_Data($result);

//***********************
//出力処理
//***********************
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->SetFont(GOTHIC, '', 8);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$date = date("印刷時刻　Y年m月d日　H:i");

//ヘッダー表示
Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

//ＤＢの値を表示
//行数・次のページ表示数・前のページ表示数・伝票計・仕入先計・合計・比較値・消費税・税込金額、初期化
$count = 0;
$page_next = $page_max;
$page_back = 0;
$data_sub = array();
$data_sub2 = array();
$data_total = array();
$person = "";
$slip = "";
$money_tax = 0;
$money = 0;
$money_tax2 = 0;
$money2 = 0;

for($c=0;$c<$data_num;$c++){
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************伝票計処理***********************************

	//値が変わった場合、伝票計表示
	if($slip != $data_list[$c][1]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//値の省略判定フラグ
			$space_flg2 = true;
			for($x=0;$x<8;$x++){
				//伝票計行番号
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 8);
					$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
					$pdf->SetFont(GOTHIC, 'B', 8);
				//スペースの幅分セル表示
				}else if($x==1){
					//改ページした後の一行目が、伝票計の場合、仕入先名表示
					if($page_back == $count){
						$pdf->SetFont(GOTHIC, '', 8);
						$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 8);
						//仕入先を表示させた場合は、データの仕入先を省略
						$slip_flg = true;
					}else{
						$pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
						$slip_flg = false;
					}
				//伝票計名
				}else if($x==2){
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
				//伝票計値
				}else if($x==3){
					$money2 = $data_sub2[9];
					$data_sub2[9] = number_format($data_sub2[9],2);
					$pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
				//消費税名
				}else if($x==4){
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
				//消費税値
				}else if($x==5){
					$money_tax2 = $tax_sub2[14];
					$tax_sub2[14] = number_format($tax_sub2[14],2);
					$pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
				//税込計名
				}else if($x==6){
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
				//税込計値
				}else if($x==7){
					$money_sum = bcadd($money_tax2,$money2,2);
					$money_sum = number_format($money_sum,2);
					$pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
				}
			}
			//スペースの幅分セル表示
			$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TBR', '2',$list_sub2[$x][2],'1');
			//伝票計・消費税・税込計、初期化
			$data_sub2 = array();
			$money_tax2 = 0;
			$money2 = 0;
			$money_sum = 0;
			$count++;
		}
		$slip = $data_list[$c][1];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************仕入先計処理***********************************

	//値が変わった場合、仕入先計表示
	if($person != $data_list[$c][12]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(180,180,180);
			//値の省略判定フラグ
			$space_flg = true;
			for($x=0;$x<8;$x++){
				//小計行番号
				if($x==0){
					$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
				//仕入先計名
				}else if($x==1){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
				//仕入先計値
				}else if($x==3){
					//仕入先計を合計値に足していく
					$data_total[2] = bcadd($data_total[2],$data_sub[9],2);
					$money = $data_sub[9];
					$data_sub[9] = number_format($data_sub[9],2);
					$pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
				//消費税名
				}else if($x==4){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
				//消費税値
				}else if($x==5){
					//消費税値を合計値に足していく
					$tax_total[4] = bcadd($tax_total[4],$tax_sub[14],2);
					$money_tax = $tax_sub[14];
					$tax_sub[14] = number_format($tax_sub[14],2);
					$pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
				//税込計名
				}else if($x==6){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
				//税込計値
				}else if($x==7){
					$money_sum = bcadd($money_tax,$money,2);
					$money_sum = number_format($money_sum,2);
					$pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
				}
			}
			//スペースの幅分セル表示
			$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');
			//仕入先計・消費税・税込計、初期化
			$data_sub = array();
			$money_tax = 0;
			$money = 0;
			$money_sum = 0;
			$count++;
		}
		$person = $data_list[$c][12];
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

	//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

//************************データ表示***************************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	for($x=1;$x<15;$x++){
		//表示値
		$contents = "";
		//表示line
		$line = "";

		//仕入先名の省略判定
		//伝票計に仕入先を表示させていない。かつ、一行目か小計の後の場合は、省略しない。
		if($x==1 && $slip_flg == false && ($count == 1 || $space_flg == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$c][$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//伝票計に表示させる仕入先名を代入
			$customer = $data_list[$c][$x-1];
			//仕入先名を省略する
			$space_flg = false;
		//伝票計に仕入先を表示、または、既に仕入先を表示させたか
		}else if($x==1){
			//ページの最大表示数か
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
			$customer = $data_list[$c][$x-1];
		//一行目か伝票計の後以外は値の省略
		}else if($x==2 && ($count == 1 || $space_flg2 == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$c][$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LRT';
			}
			//省略する
			$space_flg2 = false;
		//既に伝票番号を表示している。
		}else if($x==2){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//仕入金額計算
		}else if($x==9){
			//値を伝票計に足していく
			$data_sub2[$x] = bcadd($data_sub2[$x],$data_list[$c][$x-1],2);
			//値を仕入先計に足していく
			$data_sub[$x] = bcadd($data_sub[$x],$data_list[$c][$x-1],2);
			$data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
			$contents = $data_list[$c][$x-1];
			$line = '1';
		//消費税計算
		}else if($x==14){
			//値を伝票計に足していく
			$tax_sub2[$x] = bcadd($tax_sub2[$x],$data_list[$c][$x-1],2);
			//値を仕入先計に足していく
			$tax_sub[$x] = bcadd($tax_sub[$x],$data_list[$c][$x-1],2);
			$data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
		}else{
			//発注番号は数値に変更しない
			if(is_numeric($data_list[$c][$x-1]) && $x!=11 && $x != 6){
				$data_list[$c][$x-1] = number_format($data_list[$c][$x-1],2);
			}
			$contents = $data_list[$c][$x-1];
			$line = '1';
		}
		//仕入先IDと消費税以外表示
		if($x != 13 && $x != 14){
			//備考
			if($x==12){
				$pdf->Cell($list[$x][0], 14, $contents, $line, '2', $data_align[$x]);
			}else{
				$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
			}
		}
	}
}
//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(220,220,220);
	$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//******************最終伝票計処理***********************************
	
for($x=0;$x<8;$x++){
	//伝票計行番号
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 8);
		$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
		$pdf->SetFont(GOTHIC, 'B', 8);
	//スペースの幅分セル表示
	}else if($x==1){
		//改ページした後の一行目が、伝票計の場合、仕入先名表示
		if($page_back == $count){
			$pdf->SetFont(GOTHIC, '', 8);
			$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 8);
			//仕入先を表示させた場合は、データの仕入先を省略
			$slip_flg = true;
		}else{
			$pdf->Cell($list_sub2[$x][0], 14, $data_sub2[$x], 'LR', '0','R','');
			$slip_flg = false;
		}
	//伝票計名
	}else if($x==2){
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TLB', '0',$list_sub2[$x][2],'1');
	//伝票計値
	}else if($x==3){
		$money2 = $data_sub2[9];
		$data_sub2[9] = number_format($data_sub2[9],2);
		$pdf->Cell($list_sub2[$x][0], 14, $data_sub2[9], 'TB', '0',$list_sub2[$x][2],'1');
	//消費税名
	}else if($x==4){
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
	//消費税値
	}else if($x==5){
		$money_tax2 = $tax_sub2[14];
		$tax_sub2[14] = number_format($tax_sub2[14],2);
		$pdf->Cell($list_sub2[$x][0], 14, $tax_sub2[14], 'TB', '0',$list_sub2[$x][2],'1');
	//税込計名
	}else if($x==6){
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TB', '0',$list_sub2[$x][2],'1');
	//税込計値
	}else if($x==7){
		$money_sum = bcadd($money_tax2,$money2,2);
		$money_sum = number_format($money_sum,2);
		$pdf->Cell($list_sub2[$x][0], 14, $money_sum, 'TB', '0',$list_sub2[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], 'TBR', '2',$list_sub2[$x][2],'1');
//伝票計・消費税・税込計、初期化
$data_sub2 = array();
$money_tax2 = 0;
$money2 = 0;
$money_sum = 0;
$count++;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//****************最終仕入先計処理*******************************

for($x=0;$x<8;$x++){
	//小計行番号
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//仕入先計名
	}else if($x==1){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBL', '0',$list_sub[$x][2],'1');
	//仕入先計値
	}else if($x==3){
		//仕入先計を合計値に足していく
		$data_total[2] = bcadd($data_total[2],$data_sub[9],2);
		$money = $data_sub[9];
		$data_sub[9] = number_format($data_sub[9],2);
		$pdf->Cell($list_sub[$x][0], 14, $data_sub[9], 'TB', '0',$list_sub[$x][2],'1');
	//消費税名
	}else if($x==4){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
	//消費税値
	}else if($x==5){
		//消費税値を合計値に足していく
		$tax_total[4] = bcadd($tax_total[4],$tax_sub[14],2);
		$money_tax = $tax_sub[14];
		$tax_sub[14] = number_format($tax_sub[14],2);
		$pdf->Cell($list_sub[$x][0], 14, $money_tax, 'TB', '0',$list_sub[$x][2],'1');
	//税込計名
	}else if($x==6){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
	//税込計値
	}else if($x==7){
		$money_sum = bcadd($money_tax,$money,2);
		$money_sum = number_format($money_sum,2);
		$pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');
//仕入先計・消費税・税込計、初期化
$data_sub = array();
$money_tax = 0;
$money = 0;
$money_sum = 0;
$count++;

//*************************************************************

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が伝票計の場合、仕入先名表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

//*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

//*************************合計処理*******************************

for($x=0;$x<8;$x++){
	//合計行番号
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//総合計名
	}else if($x==2){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'LTB', '0',$list_sub[$x][2],'1');
	//総合計値
	}else if($x==3){
		$money = $data_total[2];
		$data_total[2] = number_format($data_total[2],2);
		$pdf->Cell($list_sub[$x][0], 14, $data_total[2], 'TB', '0',$list_sub[$x][2],'1');
	//消費税名
	}else if($x==4){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
	//消費税値
	}else if($x==5){
		$money_tax = $tax_total[4];
		$tax_total[4] = number_format($tax_total[4],2);
		$pdf->Cell($list_sub[$x][0], 14, $tax_total[4], 'TB', '0',$list_sub[$x][2],'1');
	//税込計名
	}else if($x==6){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TB', '0',$list_sub[$x][2],'1');
	//税込計値
	}else if($x==7){
		$money_sum = bcadd($money_tax,$money,2);
		$money_sum = number_format($money_sum,2);
		$pdf->Cell($list_sub[$x][0], 14, $money_sum, 'TB', '0',$list_sub[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], 'TBR', '2',$list_sub[$x][2],'1');
//****************************************************************

$pdf->Output();

?>
