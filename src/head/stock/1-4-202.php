<?php
/**
 *
 * 棚卸調査表
 *
 *
 *
 *
 *
 *
 *
 *   !! 本部・FC画面ともに同じソース内容です !!
 *   !! 変更する場合は片方をいじって他方にコピってください !!
 *
 *
 *
 *
 *
 *
 *
 *
 * @author      
 * @version     
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/03      xx-xxx      kajioka-h   商品名を略称から正式（22だけ）に変更
 *                  xx-xxx      kajioka-h   備考の10行ごとの線をなくした
 *                  xx-xxx      kajioka-h   5行ごとにグレーで塗った
 *                  xx-xxx      kajioka-h   商品がなくても、ページの枠をつけた
 *  2007/05/11      xx-xxx      kajioka-h   棚卸入力で追加入力した商品は表示しないように変更
 *  2007/06/22      xx-xxx      kajioka-h   右上の3番目の「棚卸実施者」→「棚卸承認者」、4番目の「棚卸実施者」→「棚卸入力者」
 *                  xx-xxx      kajioka-h   「棚卸実施者」等のセルに日付入力用のななめ線を入れた
 */

//環境設定ファイル
require_once("ENV_local.php");
require(FPDF_DIR);

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

//ヘッダー表示関数
//引数（PDFオブジェクト・マージン・タイトル・左上/右上/左下/右下のヘッダ項目・ページ数・項目名）
function Header_stock($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list){

	$pdf->SetFont(GOTHIC, '', 11);

	//タイトル
	$pdf->SetXY(10,5);
	$pdf->Cell(400, 5, $title, '0', '1', 'C');

	/******************セル**********************/

	$pdf->SetXY(222,10);
	$pdf->Cell(23,5,"棚卸実施者",'LTR','2','C');
	$pdf->Cell(23,18,"",'LRB');
	$pdf->Line(224,15.5,243,15.5);  //「棚卸実施者」の下の線
    $pdf->Line(227, 21, 230, 17);   //日付入力用のななめ線

	$pdf->SetXY(252,10);
	$pdf->Cell(23,5,"棚卸実施者",'LTR','2','C');
	$pdf->Cell(23,18,"",'LRB');
	$pdf->Line(254,15.5,273,15.5);
    $pdf->Line(257, 21, 260, 17);

	$pdf->SetXY(282,10);
	$pdf->Cell(23,5,"棚卸承認者",'LTR','2','C');
	$pdf->Cell(23,18,"",'LRB');
	$pdf->Line(284,15.5,303,15.5);
    $pdf->Line(287, 21, 290, 17);

	$pdf->SetXY(312,10);
	$pdf->Cell(23,5,"棚卸入力者",'LTR','2','C');
	$pdf->Cell(23,18,"",'LRB');
	$pdf->Line(314,15.5,333,15.5);
    $pdf->Line(317, 21, 320, 17);

	/*******************************************/
	
	//調査表番号・倉庫名
	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin+5, $posY+5);
	$pdf->Cell(196, 5,"", '0', '2', 'R');
	$pdf->Cell(15, 5,"調査表番号 : ".$left_top, '0', '2', 'L');
	$pdf->Cell(15, 5,"倉庫名 : ".$left_bottom, '0', '2', 'L');

	//項目表示
	for($i=0;$i<count($list)-1;$i++)
	{
		$pdf->Cell($list[$i][0], 5, $list[$i][1], '1', '0', $list[$i][2]);
	}
	$pdf->Cell($list[$i][0], 5, $list[$i][1], '1', '2', $list[$i][2]);
	
	//ページ・印刷時刻・在庫予定
	$pdf->SetXY($left_margin+215, $posY+5);
	$pdf->Cell(196, 5,$page_count."ページ", '0', '2', 'R');
	$pdf->Cell(196, 5,$right_top, '0', '2', 'R');
	$pdf->Cell(196, 5,"棚卸日 : ".$right_bottom, '0', '2', 'R');

	for($i=0;$i<count($list)-1;$i++)
	{
		$pdf->Cell($list[$i][0], 5, $list[$i][1], '1', '0', $list[$i][2]);
	}
	$pdf->Cell($list[$i][0], 5, $list[$i][1], '1', '2', $list[$i][2]);

}

//*******************入力箇所*********************

//余白
$left_margin = 2.5;
$top_margin = 2;

//ページサイズ
//A3
$pdf=new MBFPDF('P','mm','a3w');

//タイトル
$title = "棚卸調査表";
$page_count = "0";      //ページ数 
$page_rcount = "0";     //改行行数計算数 

//項目名・幅・align
$list[0] = array("12","No","C");
$list[1] = array("22","商品コード","C");
$list[2] = array("88","商品名","C");
$list[3] = array("21.5","帳簿数","C");
$list[4] = array("21.5","実棚数","C");
$list[5] = array("30","備考","C");

//align(データ)
$data_align[0] = "R";
$data_align[1] = "L";
$data_align[2] = "L";
$data_align[3] = "R";
$data_align[4] = "R";

//倉庫取得SQL
/*
$sql_house  = "SELECT DISTINCT ";
$sql_house .= "    t_ware.ware_id,";             //倉庫ID
$sql_house .= "    t_invent.expected_day,";      //棚卸作成日
$sql_house .= "    t_invent.invent_no ";         //調査番号
$sql_house .= "FROM ";
$sql_house .= "    t_invent ";
$sql_house .= "    INNER JOIN t_ware ON t_ware.ware_id = t_invent.ware_id ";
$sql_house .= "WHERE ";
//倉庫を指定しているか
if($_GET["ware_id"] != NULL){
    $sql_house .= "    t_invent.ware_id = ".$_GET["ware_id"];
    $sql_house .= "    AND ";
}
$sql_house .= "    t_invent.invent_no = '".$_GET["invent_no"]."'";
$sql_house .= "    AND ";
$sql_house .= "    t_invent.renew_flg = 'f' ";
$sql_house .= "    AND ";
$sql_house .= "    t_invent.shop_id = ".$_SESSION["client_id"].";";
*/
$sql_house  = "SELECT DISTINCT ";
$sql_house .= "    ware_id, ";          //倉庫ID
$sql_house .= "    expected_day, ";     //棚卸作成日
$sql_house .= "    invent_no ";         //調査番号
$sql_house .= "FROM ";
$sql_house .= "    t_invent ";
$sql_house .= "WHERE ";
//倉庫を指定しているか
if($_GET["ware_id"] != NULL){
    $sql_house .= "    ware_id = ".(int)$_GET["ware_id"]." ";
    $sql_house .= "    AND ";
}
$sql_house .= "    invent_no = '".$_GET["invent_no"]."' ";
$sql_house .= "    AND ";
$sql_house .= "    renew_flg = 'f' ";
$sql_house .= "    AND ";
$sql_house .= "    shop_id = ".$_SESSION["client_id"]." ";
$sql_house .= ";";

//ページ最大表示数
$page_max = 100;

//備考の色
$pdf->SetFillColor(230, 230, 230);

//GET情報が不正か
if($_GET["invent_no"] == NULL){
    print "<font color=\"red\"><b><li>発行する棚卸調査表番号がありません。</b></font>";
    exit;
}

//***********************************************

//DB接続
//$db_con = Db_Connect("amenity");
$db_con = Db_Connect();

$result_house = Db_Query($db_con,$sql_house);
$date = date("印刷時刻　Y年m月d日　H：i");
$pdf->AddMBFont(GOTHIC ,'SJIS');

//倉庫が存在する間出力
while($house_list = pg_fetch_array($result_house)){
	//データ取得SQL
/*
	$sql  = "SELECT ";
    $sql .= "    t_goods.goods_cd,";        //商品コード
    $sql .= "    t_goods.goods_cname,";     //商品名
    $sql .= "    t_contents.stock_num,";    //帳簿数
    $sql .= "    t_ware.ware_name ";        //倉庫名
    $sql .= "FROM ";
    $sql .= "    t_contents"; 
    $sql .= "    INNER JOIN t_invent ON t_contents.invent_id = t_invent.invent_id";
    $sql .= "    INNER JOIN t_ware ON t_ware.ware_id = t_invent.ware_id ";
    $sql .= "    INNER JOIN t_goods ON t_contents.goods_id = t_goods.goods_id ";
    $sql .= "WHERE ";
    $sql .= "    t_ware.ware_id = '".$house_list[0]."' ";
	$sql .= "ORDER BY ";
	$sql .= "    t_goods.goods_cd;";
	$result = Db_Query($db_con,$sql);
*/
    $sql  = "SELECT ";
    $sql .= "    t_contents.goods_cd, ";        //商品コード
    //$sql .= "    t_contents.goods_cname, ";     //商品名（略称）
    $sql .= "    SUBSTRING(t_contents.goods_name, 1, 22), ";    //商品名（正式名称の22文字だけ）
    $sql .= "    t_contents.stock_num, ";       //帳簿数
    $sql .= "    t_invent.ware_name ";          //倉庫名
    $sql .= "FROM ";
    $sql .= "    t_contents ";
    $sql .= "    INNER JOIN t_invent ON t_invent.invent_id = t_contents.invent_id ";
    $sql .= "WHERE ";
    $sql .= "    t_invent.ware_id = '".$house_list[0]."' ";
    $sql .= "    AND ";
    $sql .= "    invent_no = '".$_GET["invent_no"]."' ";
    $sql .= "    AND ";
    $sql .= "    t_contents.add_flg = false ";
    $sql .= "ORDER BY ";
    $sql .= "    t_contents.g_product_cd, ";
    $sql .= "    t_contents.goods_cd ";
    $sql .= ";";
    $result = Db_Query($db_con,$sql);

    if(pg_num_rows($result) == 0){
        print "<font color=\"red\"><b><li>発行する棚卸調査表番号がありません。</b></font>";
        exit;
    }

	//日付取得・形式変更
	$stock_date = $house_list[1];
	$year = substr($stock_date,0,4);
	$month = substr($stock_date,5,2);
	$day = substr($stock_date,8,2);
	$stock_date = $year."年".$month."月".$day."日";

	//調査表番号取得
	$invent_num = $house_list[2];

	$pdf->SetFont(GOTHIC, '', 11);
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	//ＤＢの値を表示
	//行数・ページ数・改行数・次のページ表示数・左右の位置変更数・比較値、初期化
	$count = 0;
	$page_count++;
	$page_rcount++;
	$page_next = $page_max;
	$change_xy = $page_max - ($page_max / 2);
	$goods = "";
	$invent = "";
	//備考欄を１０行ごとに表示する為、現在の行数を保持
	$row_count = 0;

    //1つの倉庫にいくつ商品があるか行数所得
    $goods_row_count = pg_num_rows($result);
    //1つの倉庫の全表示行数取得
    $max_goods_row_count = (ceil($goods_row_count / $page_max)) * $page_max;

	//倉庫ごとに出力
	//while($data_list = pg_fetch_array($result)){
	for($i=0;$i<$max_goods_row_count;$i++){
        if($i<$goods_row_count){
            $data_list = pg_fetch_array($result, $i);
        }else{
            $data_list = array();
        }
		$row_count++;
		//倉庫の最大行数取得
		$row = pg_num_rows($result);

        //塗潰し判定
        if((ceil($row_count / 5) % 2) == 0){
            $fill_color = 1;
        }else{
            $fill_color = 0;
        }

		$count++;
		/**********************ヘッダー処理**************************/
		//一行目の場合、ヘッダ出力
		if($count == 1){

			//倉庫名取得
			$house = $data_list[3];
			//ヘッダー表示
			Header_stock($pdf,$left_margin,$top_margin,$title,$invent_num,$date,$house,$stock_date,$page_count,$list);
		}
	/************************************************************/


	//*******************改ページ処理*****************************

		//行番号がページ最大表示数になった場合、改ページする
		if($page_next+1 == $count){
			$pdf->AddPage();
			$page_count++;
			$page_rcount++;
			//ヘッダー表示
			Header_stock($pdf,$left_margin,$top_margin,$title,$invent_num,$date,$house,$stock_date,$page_count,$list);

			//次の最大表示数
			$page_next = $page_max * $page_rcount;
			$change_xy = ($page_max * $page_rcount) - ($page_max / 2);
			$space_flg = true;
			$space_flg2 = true;
		}

	//********************データ表示位置****************************

		$pdf->SetFont(GOTHIC, '', 11);
		$posY = $pdf->GetY();
		//データの左右判定
		if($count <= $change_xy){
			$pdf->SetXY($left_margin+5, $posY);
		}else{
			if($count == $change_xy + 1){
				$pdf->SetXY($left_margin+215, $top_margin+38);
				//値の省略判定フラグ
				$space_flg = true;
				$space_flg2 = true;
			}else{
				$pdf->SetXY($left_margin+215, $posY);
			}
		}

	//************************データ表示***************************
		//行番号
		$pdf->Cell($list[0][0], 5, "$count", '1', '0', $data_align[0], $fill_color);
		for($x=1;$x<=3;$x++){
			//表示値
			$contents = "";
			//表示line		
			$line = "";

			//商品コード以外は数値判定
			if(is_numeric($data_list[$x-1]) && $x != 1){
				$data_list[$x-1] = number_format($data_list[$x-1]);
			}
			$contents = $data_list[$x-1];
			$line = '1';
			$pdf->Cell($list[$x][0], 5, $contents, $line, '0', $data_align[$x], $fill_color);
		}
		//実棚数はデータを表示しない
		$pdf->Cell($list[$x-1][0], 5, '', $line, '0', $data_align[$x-1], $fill_color);
		$x++;

		//備考
        //1行目のときは上と左右の線
		if(($row_count % ($page_max / 2)) == 1){
			$pdf->Cell($list[$x][0], 5, '', 'LRT', '2', 'C');
        //最終行は下と左右の線
		}elseif(($row_count % ($page_max / 2)) == 0){
			$pdf->Cell($list[$x][0], 5, '', 'LRB', '2', 'C');
        //それ以外は左右のみ
		}else{
			$pdf->Cell($list[$x][0], 5, '', 'LR', '2', 'C');
		}
	}
	$page_rcount = 0;  
	//*************************************************************

}

$pdf->Output();


?>
