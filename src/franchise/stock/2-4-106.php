<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/22      11-021      ふ          表示データのサニタイズされすぎを修正
 *  2006/11/22      11-006      ふ          データの表示順を修正
 *
 *
 */

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id      = $_SESSION["client_id"]; 

$goods_cd   = $_POST["form_goods_cd"];              //商品コード
$goods_name = $_POST["form_goods_cname"];            //商品名
$ware_id    = $_POST["form_ware"];                  //倉庫ID
if($_POST["form_hand_day"]["sy"] != NULL){
	$hand_day_s = $_POST["form_hand_day"]["sy"]."年".$_POST["form_hand_day"]["sm"]."月".$_POST["form_hand_day"]["sd"]."日"; //取扱開始日
}
if($_POST["form_hand_day"]["ey"] != NULL){
	$hand_day_e = $_POST["form_hand_day"]["ey"]."年".$_POST["form_hand_day"]["em"]."月".$_POST["form_hand_day"]["ed"]."日"; //取扱終了日
}
//SQL条件用の取扱日
$hand_day_s2 = $_POST["form_hand_day"]["sy"]."-".$_POST["form_hand_day"]["sm"]."-".$_POST["form_hand_day"]["sd"]; 
$hand_day_e2 = $_POST["form_hand_day"]["ey"]."-".$_POST["form_hand_day"]["em"]."-".$_POST["form_hand_day"]["ed"]; 

/****************************/
//エラーチェック(PHP)
/****************************/
//◇取扱開始日
//・日付妥当性チェック
if($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null){
    $day_y = (int)$_POST["form_hand_day"]["sy"];
    $day_m = (int)$_POST["form_hand_day"]["sm"];
    $day_d = (int)$_POST["form_hand_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
		print "<font color=\"red\"><b><li>取扱期間 の日付は妥当ではありません。</b></font>";
	    exit;
    }
}

//◇取扱終了日
//・日付妥当性チェック
/*
if($_POST["form_hand_day"]["ey"] != null || $_POST["form_hand_day"]["em"] != null || $_POST["form_hand_day"]["ed"] != null){
    $day_y = (int)$_POST["form_hand_day"]["ey"];
    $day_m = (int)$_POST["form_hand_day"]["em"];
    $day_d = (int)$_POST["form_hand_day"]["ed"];
    if(!checkdate($day_m,$day_d,$day_y)){
		print "<font color=\"red\"><b><li>取扱期間 の日付は妥当ではありません。</b></font>";
	    exit;
    }
}
*/
if ($_POST["form_hand_day"]["ey"] == null || $_POST["form_hand_day"]["em"] == null || $_POST["form_hand_day"]["ed"] == null){
    // 「年月日全てがNULL」ではない場合
    if (!($_POST["form_hand_day"]["ey"] == null && $_POST["form_hand_day"]["em"] == null && $_POST["form_hand_day"]["ed"] == null)){ 
        print "<font color=\"red\"><b><li>取扱期間 の検索には「年」「月」「日」は全て必須入力です。</b></font>";
        exit;   
    }
}else{
    if (!ereg("^[0-9]+$", $_POST["form_hand_day"]["ey"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["em"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["ed"])){
        print "<font color=\"red\"><b><li>取扱期間 が妥当ではありません。</b></font>";
        exit;   
    }
    if(!checkdate((int)$_POST["form_hand_day"]["em"], (int)$_POST["form_hand_day"]["ed"], (int)$_POST["form_hand_day"]["ey"])){
        print "<font color=\"red\"><b><li>取扱期間 が妥当ではありません。</b></font>";
        exit;   
    }
}

//◇商品コード
//・半角数字チェック
if($goods_cd != null && !ereg("^[0-9]+$", $goods_cd)){
    print "<font color=\"red\"><b><li>商品コード は半角数字のみです。</b></font>";
	exit;
}

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
$title = "受払明細一覧表";
$page_count = 1; 

//取扱期間の表示形式変更
if($hand_day_s == NULL && $hand_day_e == NULL){
    $time = "取扱期間：指定なし";
}else{
	$time = "取扱期間：$hand_day_s 〜 $hand_day_e";
}

//項目名・幅・align
$list[0] = array("30","NO","C");
$list[1] = array("110","倉庫","C");
$list[2] = array("300","商品名","C");
$list[3] = array("80","取扱日","C");
$list[4] = array("80","取引区分","C");
$list[5] = array("80","伝票番号","C");
$list[6] = array("190","受払先","C");
$list[7] = array("80","入庫数","C");
$list[8] = array("80","出庫数","C");
$list[9] = array("80","単位","C");

//*********************************//
//データ項目入力箇所
//*********************************//
//倉庫計・総合計
$list_sub[0] = array("30","","R");
$list_sub[1] = array("110","倉庫計：","L");
$list_sub[2] = array("110","総合計：","L");
$list_sub[3] = array("300","","R");
$list_sub[4] = array("80","","L");
$list_sub[5] = array("80","","R");
$list_sub[6] = array("80","","R");
$list_sub[7] = array("190","","L");
$list_sub[8] = array("80","","R");
$list_sub[9] = array("80","","R");
$list_sub[10] = array("80","","C");

//商品計
$list_sub2[0] = array("30","","R");
$list_sub2[1] = array("110","","C");
$list_sub2[2] = array("300","商品計：","L");
$list_sub2[3] = array("80","","R");
$list_sub2[4] = array("80","","L");
$list_sub2[5] = array("80","","R");
$list_sub2[6] = array("190","","L");
$list_sub2[7] = array("80","","R");
$list_sub2[8] = array("80","","R");
$list_sub2[9] = array("80","","C");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "C";
$data_align[4] = "C";
$data_align[5] = "L";
$data_align[6] = "L";
$data_align[7] = "R";
$data_align[8] = "R";
$data_align[9] = "L";

//***********************
//出力データ取得SQL入力箇所
//***********************
//DB接続
$db_con = Db_Connect();

$sql .= "SELECT ";
$sql .= "    t_ware.ware_name,";
$sql .= "    t_goods.goods_name,";
$sql .= "    t_stock_hand.work_day,";
$sql .= "    CASE t_stock_hand.work_div";             
$sql .= "        WHEN '2' THEN '売上'";
$sql .= "        WHEN '4' THEN '仕入'";
$sql .= "        WHEN '5' THEN '移動'";
$sql .= "        WHEN '6' THEN '調整'";
$sql .= "        WHEN '7' THEN '組立'";
$sql .= "    END,";
$sql .= "    t_stock_hand.slip_no,";
$sql .= "    t_client.client_name,";
$sql .= "    t_stock_hand.io_div,";
$sql .= "    t_stock_hand.num,";
$sql .= "    t_goods.unit ";
$sql .= "FROM ";
$sql .= "    t_stock_hand ";
$sql .= "    LEFT JOIN t_client ON t_client.client_id = t_stock_hand.client_id ";
$sql .= "    INNER JOIN t_ware ON t_ware.ware_id = t_stock_hand.ware_id ";
$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_stock_hand.goods_id ";
$sql .= "    LEFT JOIN t_g_product ON t_goods.goods_id = t_g_product.g_product_id ";
$sql .= "WHERE ";
$sql .= "    t_goods.stock_manage = '1' ";
$sql .= "AND ";
$sql .= "    t_stock_hand.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    work_div NOT IN ('1','3') ";
//取扱日時が指定されているか
if($_POST["form_hand_day"]["sy"] != NULL){
	$sql .= "    AND ";
	$sql .= "        t_stock_hand.work_day >= '$hand_day_s2' ";
}
if($_POST["form_hand_day"]["ey"] != NULL){
	$sql .= "    AND ";
	$sql .= "        t_stock_hand.work_day <= '$hand_day_e2' ";
}
//倉庫IDが指定された場合
if($ware_id != null){
    $sql .= "   AND ";
    $sql .= "   t_ware.ware_id = $ware_id ";
}
//商品コードが指定された場合
if($goods_cd != null){
    $sql .= "   AND ";
    $sql .= "   t_goods.goods_cd LIKE '$goods_cd%' ";
}
//商品名が指定された場合
if($goods_name != null){
    $sql .= "   AND";
    $sql .= "   t_goods.goods_name LIKE '%$goods_name%' ";
}
$sql .= "ORDER BY ";
$sql .= "    t_g_product.g_product_cd, t_goods.goods_cd, t_stock_hand.work_day DESC, t_stock_hand.work_div, t_stock_hand.slip_no ";
$result = Db_Query($db_con, $sql);
$data_num = pg_num_rows($result);
$data_list = Get_Data($result, 2);

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

$count = 0;                 //行数
$page_next = $page_max;     //次のページ表示数
$page_back = 0;             //前のページ表示数
$ware = "";                 //倉庫の重複値
$goods = "";                //商品の重複値
$in_count = 0;              //入庫数の合計
$out_count = 0;             //出庫数の合計
$in_total = 0;              //入庫数の全合計
$out_total = 0;             //出庫数の全合計

for($c=0;$c<$data_num;$c++){
	$count++;

	//***********************
	//改ページ処理
	//***********************
	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が商品計の場合、倉庫名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

	//***********************
	//商品計処理
	//***********************
	//値が変わった場合、商品計表示
	if($goods != $data_list[$c][1]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(220,220,220);
			//値の省略判定フラグ
			$space_flg2 = true;
			for($x=0;$x<count($list_sub2)-1;$x++){
				//商品計行番号
				if($x==0){
					$pdf->SetFont(GOTHIC, '', 8);
					$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
					$pdf->SetFont(GOTHIC, 'B', 8);
				//倉庫名
				}else if($x==1){
					//改ページした後の一行目が、商品計の場合、倉庫名表示
					if($page_back == $count){
						$pdf->SetFont(GOTHIC, '', 8);
						$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 8);
						//倉庫を表示させた場合は、データの倉庫を省略
						$goods_flg = true;
					}else if($page_next == $count){
						$pdf->SetFont(GOTHIC, '', 8);
						$pdf->Cell($list_sub2[$x][0], 14, '', 'LBR', '0','L','');
						$pdf->SetFont(GOTHIC, 'B', 8);
						$goods_flg = false;
					}else{
						$pdf->Cell($list_sub2[$x][0], 14, "", 'LR', '0','R','');
					}
				//商品計名
				}else if($x==2){
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
				//入庫数
				}else if($x==7){
					$in_count = number_format($in_count);
					$pdf->Cell($list_sub2[$x][0], 14, $in_count, '1', '0',$list_sub2[$x][2],'1');
				//出庫数
				}else if($x==8){
					$out_count = number_format($out_count);
					$pdf->Cell($list_sub2[$x][0], 14, $out_count, '1', '0',$list_sub2[$x][2],'1');
				}else{
					$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
				}
			}
			//スペースの幅分セル表示
			$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '2',$list_sub2[$x][2],'1');

			$in_count = 0;
			$out_count = 0;
			$count++;
		}
		$goods = $data_list[$c][1];
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);

	//***********************
	//改ページ処理
	//***********************
	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が商品計の場合、倉庫名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 8);

	//***********************
	//倉庫計処理
	//***********************
	//値が変わった場合、倉庫計表示
	if($ware != $data_list[$c][0]){
		//一行目は、値をセットするだけ
		if($count != 1){
			$pdf->SetFillColor(180,180,180);
			//値の省略判定フラグ
			$space_flg = true;
			$goods_flg = false;
			for($x=0;$x<count($list_sub)-1;$x++){
				//倉庫計行番号
				if($x==0){
					$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
				//倉庫計名
				}else if($x==1){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
				//入庫数
				}else if($x==7){
					$in_sub = number_format($in_sub);
					$pdf->Cell($list_sub[$x][0], 14, $in_sub, '1', '0',$list_sub[$x][2],'1');
				//出庫数
				}else if($x==8){
					$out_sub = number_format($out_sub);
					$pdf->Cell($list_sub[$x][0], 14, $out_sub, '1', '0',$list_sub[$x][2],'1');
				}else if($x!=2){
					$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
				}
			}
			//スペースの幅分セル表示
			$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');
		
			$in_sub  = 0;
			$out_sub = 0;
			$count++;
		}
		$ware = $data_list[$c][0];
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

	//***********************
	//改ページ処理
	//***********************
	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();
		$page_count++;
		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//改ページした最初の行が商品計の場合、倉庫名を表示させる為に、前のページの表示数を代入
		$page_back = $page_next+1;
		//次の最大表示数
		$page_next = $page_max * $page_count;
		$space_flg = true;
		$space_flg2 = true;
	}

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, '', 8);

	//***********************
	//データ表示処理
	//***********************
	//行番号
	$pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
	//最初は行番号を表示する為、ポインタは一から始める
	for($x=1;$x<count($data_list[$c])+1;$x++){
		//表示値
		$contents = "";
		//表示line
		$line = "";

		//倉庫名の省略判定
		//商品計に倉庫を表示させていない。かつ、一行目か小計の後の場合は、省略しない。
		if($x==1 && $goods_flg == false && ($count == 1 || $space_flg == true)){
			//セル結合判定
			//ページの最大表示数か
			$contents = $data_list[$c][$x-1];
			if($page_next == $count){
				$line = 'LRBT';
			}else{
				$line = 'LR';
			}
			//商品計に表示させる倉庫名を代入
			$customer = $data_list[$c][$x-1];
			//倉庫名を省略する
			$space_flg = false;
			$goods_flg = false;
		//商品計に倉庫を表示、または、既に倉庫を表示させたか
		}else if($x==1){
			//ページの最大表示数か
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
			$customer = $data_list[$c][$x-1];
		//一行目か商品計の後以外は値の省略
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
		//既に商品名を表示している。
		}else if($x==2){
			$contents = '';
			if($page_next == $count){
				$line = 'LBR';
			}else{
				$line = 'LR';
			}
		//入出庫区分
		}else if($x==7){
			$in_put_flg = NULL;
			$out_put_flg = NULL;
			//入庫・出庫判定
			if($data_list[$c][$x-1] == '1'){
				//入庫
				$in_put_flg = true;
			}else{
				//出庫
				$out_put_flg = true;
			}
		//入庫数・出庫数
		}else if($x==8){
			//入庫数・出庫数計算判定
			if($in_put_flg == true){
				//入庫数計算
				$in_count = $in_count + $data_list[$c][$x-1];    //商品計値
				$in_sub   = $in_sub + $data_list[$c][$x-1];      //倉庫計値
				$in_total = $in_total + $data_list[$c][$x-1];    //総合計値
			}else if($out_put_flg == true){
				//出庫数計算
				$out_count = $out_count + $data_list[$c][$x-1];  //商品計値
				$out_sub   = $out_sub + $data_list[$c][$x-1];    //倉庫計値
				$out_total = $out_total + $data_list[$c][$x-1];  //総合計値
			}
			$data_list[$c][$x-1] = number_format($data_list[$c][$x-1]);
			$contents = $data_list[$c][$x-1];
			$line = '1';
		}else{
			$contents = $data_list[$c][$x-1];
			$line = '1';
		}
		//入出庫区分以外表示
		if($x != 7){
			//単位を表示した後は、改行
			if($x==9){
				$pdf->Cell($list[$x][0], 14, $contents, $line, '2', $data_align[9]);
			//入庫・出庫数はデータに対して二行ある為、それぞれ表示
			}else if($x==8){
				if($in_put_flg == true){
					$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[7]);
					$pdf->Cell($list[$x+1][0], 14, "", $line, '0', $data_align[8]);
				}else if($out_put_flg == true){
					$pdf->Cell($list[$x][0], 14, "", $line, '0', $data_align[7]);
					$pdf->Cell($list[$x+1][0], 14, $contents, $line, '0', $data_align[8]);
				}
			}else{
				$pdf->Cell($list[$x][0], 14, $contents, $line, '0', $data_align[$x]);
			}
		}
	}
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(220,220,220);
$count++;

//***********************
//改ページ処理
//***********************
//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//改ページした最初の行が商品計の場合、倉庫名表示させる為に、前のページの表示数を代入
	$page_back = $page_next+1;
	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//商品計処理
//***********************
$pdf->SetFillColor(220,220,220);
//値の省略判定フラグ
$space_flg2 = true;
for($x=0;$x<count($list_sub2)-1;$x++){
	//商品計行番号
	if($x==0){
		$pdf->SetFont(GOTHIC, '', 8);
		$pdf->Cell($list_sub2[$x][0], 14, "$count", '1', '0',$list_sub2[$x][2]);
		$pdf->SetFont(GOTHIC, 'B', 8);
	//倉庫名
	}else if($x==1){
		//改ページした後の一行目が、商品計の場合、倉庫名表示
		if($page_back == $count){
			$pdf->SetFont(GOTHIC, '', 8);
			$pdf->Cell($list_sub2[$x][0], 14, $customer, 'LR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 8);
			//倉庫を表示させた場合は、データの倉庫を省略
			$goods_flg = true;
		}else if($page_next == $count){
			$pdf->SetFont(GOTHIC, '', 8);
			$pdf->Cell($list_sub2[$x][0], 14, '', 'LBR', '0','L','');
			$pdf->SetFont(GOTHIC, 'B', 8);
			$goods_flg = false;
		}else{
			$pdf->Cell($list_sub2[$x][0], 14, "", 'LR', '0','R','');
		}
	//商品計名
	}else if($x==2){
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
	//入庫数
	}else if($x==7){
		$in_count = number_format($in_count);
		$pdf->Cell($list_sub2[$x][0], 14, $in_count, '1', '0',$list_sub2[$x][2],'1');
	//出庫数
	}else if($x==8){
		$out_count = number_format($out_count);
		$pdf->Cell($list_sub2[$x][0], 14, $out_count, '1', '0',$list_sub2[$x][2],'1');
	}else{
		$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '0',$list_sub2[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub2[$x][0], 14, $list_sub2[$x][1], '1', '2',$list_sub2[$x][2],'1');

$in_count = 0;
$out_count = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(180,180,180);
$count++;

//***********************
//改ページ処理
//***********************	
//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//改ページした最初の行が商品計の場合、倉庫名表示させる為に、前のページの表示数を代入
	$page_back = $page_next+1;
	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//最終倉庫計処理
//***********************	
$pdf->SetFillColor(180,180,180);
//値の省略判定フラグ
$space_flg = true;
$goods_flg = false;
for($x=0;$x<count($list_sub)-1;$x++){
	//倉庫計行番号
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//倉庫計名
	}else if($x==1){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	//入庫数
	}else if($x==8){
		$in_sub = number_format($in_sub);
		$pdf->Cell($list_sub[$x][0], 14, $in_sub, '1', '0',$list_sub[$x][2],'1');
	//出庫数
	}else if($x==9){
		$out_sub = number_format($out_sub);
		$pdf->Cell($list_sub[$x][0], 14, $out_sub, '1', '0',$list_sub[$x][2],'1');
	}else if($x!=2){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');

$in_sub  = 0;
$out_sub = 0;

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFillColor(145,145,145);
$count++;

//***********************
//改ページ処理
//***********************	
//行番号がページ最大表示数になった場合、改ページする
if($page_next+1 == $count){
	$pdf->AddPage();
	$page_count++;
	//ヘッダー表示
	Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

	//改ページした最初の行が商品計の場合、倉庫名表示させる為に、前のページの表示数を代入
	$page_back = $page_next+1;
	//次の最大表示数
	$page_next = $page_max * $page_count;
	$space_flg = true;
	$space_flg2 = true;
}

$posY = $pdf->GetY();
$pdf->SetXY($left_margin, $posY);
$pdf->SetFont(GOTHIC, 'B', 8);

//***********************
//総合計処理
//***********************	
$pdf->SetFillColor(145,145,145);
//値の省略判定フラグ
$space_flg = true;
$goods_flg = false;
for($x=0;$x<count($list_sub)-1;$x++){
	//倉庫計行番号
	if($x==0){
		$pdf->Cell($list_sub[$x][0], 14, "$count", '1', '0',$list_sub[$x][2],'1');
	//総合計名
	}else if($x==2){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	//入庫数
	}else if($x==8){
		$in_total = number_format($in_total);
		$pdf->Cell($list_sub[$x][0], 14, $in_total, '1', '0',$list_sub[$x][2],'1');
	//出庫数
	}else if($x==9){
		$out_total = number_format($out_total);
		$pdf->Cell($list_sub[$x][0], 14, $out_total, '1', '0',$list_sub[$x][2],'1');
	}else if($x!=1){
		$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '0',$list_sub[$x][2],'1');
	}
}
//スペースの幅分セル表示
$pdf->Cell($list_sub[$x][0], 14, $list_sub[$x][1], '1', '2',$list_sub[$x][2],'1');

$in_sub  = 0;
$out_sub = 0;
$count++;

//出力
$pdf->Output();

?>
