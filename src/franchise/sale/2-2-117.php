<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　 担当者　　　内容　
 * 2007-03-22               watanabe-k  削除伝票を表示しない
 * 2007-03-23               watanabe-k  契約マスタと同じソートをするように修正 
 * 2007-05-14               watanabe-k  発行日を残すように修正 
 * 2007-05-22               watanabe-k  タイトルを変更 
 * 2007-05-22               watanabe-k  15伝票を表示する場合に2ページ目に空の代行集計表が表示されるバグの修正 
 * 2007-05-23               watanabe-k  集計日報IDを登録するように修正 
 * 2007-07-31               watanabe-k  用紙に入りきらないためマージンンを修正 
 * 2007-09-18               watanabe-k  伝票発行は得意先マスタを参照するように修正 
 * 2008-05-31               watanabe-k  出庫品リストには受注データテーブルの商品を表示するように修正 
 * 2008-07-19				watanabe-k  アイテムと消耗品を別々に抽出するように修正
 */

require_once("ENV_local.php");
require_once(INCLUDE_DIR."daily_slip.inc"); //集計日報用関数

$db_con = Db_Connect();

// 権限チェック
//$auth       = Auth_Check($db_con);


/****************************/
//セッションチェック
/****************************/

if($_SESSION["group_kind"] != "2"){
    header("Location: ".FC_DIR."top.php");
}

/***************************/
//外部変数取得
/***************************/
//セッション
$shop_id        = $_SESSION["client_id"];           //取引先ID

//POST
$button_value   = $_POST["form_hdn_submit"];        //ボタンvalue

//付番前発行
if($button_value == "付番前発行"){
    $aord_id    = $_POST["form_preslip_out"];           //受注ID
    $button     = "1";
//集計日報発行
}elseif($button_value == "集計日報発行"){
    $aord_id    = $_POST["form_unslip_out"];
    $button     = "2";
//再発行
}elseif($button_value == "　再　発　行　"){
    $aord_id    = $_POST["form_slip_out"];
    $button     = "3";
}

/*********************************/
//対象データ抽出
/*********************************/
//データを代行業者ごとに纏める
$act_data = Make_Client_Data ($aord_id, $db_con);

//一つも選択されていない場合
if($act_data === false){
    $check_err = "伝票を選択して下さい。";
    Show_Template($check_err, $smarty);
}else{
    $act_data_count = count($act_data);     
}

//伝票が日報発行のタイミングで削除されていた場合
if($act_data_count == 0){
    $check_err = "該当の伝票が削除されています。";
    Show_Template($check_err, $smarty);
}

/*********************************/
//ボタン押下イベント処理
/*********************************/
//集計日報ボタン押下処理
//受注番号発効
if($button == "2"){
    $act_data = Set_Aord_No ($act_data, $db_con);

    //エラーの場合
    if($act_data === false){
        $duplicate_err = "集計日報の印刷が同時に行なわれたため、<br>伝票番号の付番に失敗しました。";
        Show_Template($duplicate_err, $smarty);
    }

//再発行ボタン押下処理
}elseif($button == "3"){
    //再発行前に伝票が追加された場合エラーメッセージ表示
    foreach($act_data AS $key => $var){
        if(in_array(null, $act_data[$key]["head"])){
            $check_err = "伝票が新たに追加されたため、再度付番して下さい。";
            Show_Template($check_err, $smarty);
        }
    }
}

/*********************************/
//初期設定
/*********************************/
//巡回基準日を抽出
$sql  = "SELECT ";
$sql .= "   stand_day ";
$sql .= "FROM\n";
$sql .= "   t_stand";
$sql .= ";";

$day_res = Db_Query($db_con, $sql);
$stand_day = explode("-", pg_fetch_result($day_res, 0,0));

$max_row     = 15;  //表の行数
$max_line    = 5;   //商品の列数
$top_margin  = 40;
$left_margin = 60;

/*********************************/
//表示処理
/*********************************/
//データ整形
$page_data = Make_Show_Data ($act_data, $db_con, $max_row, $max_line);

require(FPDF_DIR);
//PDF出力
Make_Pdf($page_data, $top_margin, $left_margin, $max_row, $max_line);

/*********************************/
//関数
/*********************************/
//PDF出力
function Make_Pdf ($page_data, $top_margin, $left_margin, $max_row, $max_line){

    //表示行数
    $page_line = 15;

    //タイトル
	$title = "◇　代 行 期 間 集 計 表　◇";

    //項目名・幅・align
    $list[0] = array("70","予　定　日","C");
    $list[1] = array("40","伝票No.","C");
    $list[2] = array("140","得　意　先","C");
    $list[3] = array("130","商　　　　品","C");
    $list[4] = array("130","商　　　　品","C");
    $list[5] = array("130","商　　　　品","C");
    $list[6] = array("130","商　　　　品","C");
    $list[7] = array("130","商　　　　品","C");
    $list[8] = array("70","消　費　税","C");
    $list[9] = array("140","売　上　合　計　額","C");

	$goods_width = array("0","180","360","540","720");

	//ページサイズ
	//A3
	$pdf=new MBFPDF('L','pt','A3');
	$pdf->AddMBFont(GOTHIC ,'SJIS');
	$pdf->SetAutoPageBreak(false);

	//帳票出力  
	for($i = 0; $i < $page_data["page"]; $i++){

        $act_id = $page_data[$i]["act_id"];
		
	    $pdf->AddPage();
	    ///////////////////////////ページ数/////////////////////////////////
		$pdf->SetFont(GOTHIC, '', 10);
		//A3の横幅は、1110
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(30,20);
		$pdf->Cell(1110, 12, ($i+1)."/".$page_data["page"], '0', '1', 'R');

		////////////////////////////タイトル////////////////////////////////

		$pdf->SetFont(GOTHIC, '', 20);
		//A3の横幅は、1110
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY($left_margin,$top_margin);
		$pdf->Cell(1110, 20, $title, '0', '1', 'C');

		///////////////////////////タイトルの横のセル//////////////////////////////
		//線の太さ
		$pdf->SetLineWidth(1);
		//線の色
		$pdf->SetDrawColor(150,150,255);
		$pdf->SetFont(GOTHIC, '', 10);

		$pdf->SetXY($left_margin+700,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"管理者",'LTB','2','C','1');
		$pdf->Cell(50,40,"",'LB');

		$pdf->SetXY($left_margin+750,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"入　力",'TB','2','C','1');
		$pdf->Cell(50,40,"",'B');

		$pdf->SetXY($left_margin+800,$top_margin);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(50,11,"担当者",'TRB','2','C','1');
		$pdf->Cell(50,40,"",'RB');

		$pdf->SetDrawColor(150,155,255);
		$pdf->Line($left_margin+749.5,$top_margin+1,$left_margin+749.5,$top_margin+10);
		$pdf->Line($left_margin+799.5,$top_margin+1,$left_margin+799.5,$top_margin+10);

		$pdf->SetLineWidth(0.5);
		$pdf->SetDrawColor(150,150,255);
		$pdf->Line($left_margin+749.5,$top_margin+11.5,$left_margin+749.5,$top_margin+55);
		$pdf->Line($left_margin+799.5,$top_margin+11.5,$left_margin+799.5,$top_margin+55);

        /***************その横のセル*****************/

        $pdf->SetLineWidth(1);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetXY($left_margin+900,$top_margin-7);
        $pdf->Cell(160,15,"　　　　　　年　　月　　日",'0','0','C','1');

        $pdf->SetXY($left_margin+900,$top_margin+9);
        $pdf->Cell(50,40,"ルート",'LTR','2','C','1');
        $pdf->SetXY($left_margin+950,$top_margin+9);
        $pdf->Cell(160,20,"代行業者 ： ".$page_data["id".$act_id]["act_cd"],'LTR','0','L','1');
        $pdf->SetXY($left_margin+950,$top_margin+29);
        $pdf->Cell(160,20,$page_data["id".$act_id]["act_name"],'LR','0','L','1');

        $pdf->SetXY($left_margin+900,$top_margin+35);

        $pdf->SetLineWidth(0.5);
        $pdf->SetDrawColor(150,150,255);

		////////////////////////////項目///////////////////////////////////////
		$pdf->SetLineWidth(1);
		//テキストの色
		$pdf->SetTextColor(0,0,0); 

		//項目表示
		$pdf->SetXY($left_margin,$top_margin+50);
		$pdf->SetFillColor(255,255,255);
		for($m = 0; $m < count($list); $m++){
            if($m == 9){
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell($list[$m][0], 15, $list[$m][1], '1', '2', $list[$m][2],'1');
                $pdf->SetFillColor(255,255,255);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell('70', 15, '現　金', '1', '0', 'C','1');
                $pdf->Cell('70', 15, '売　掛', '1', '0', 'C','1');
            }else{
			    $pdf->Cell($list[$m][0], 30, $list[$m][1], '1', '0', $list[$m][2],'1');
            }
		}

		/////////////////////////////データ////////////////////////////////////
		//データ表示
		$pdf->SetFont(GOTHIC, '', 9);
		$pdf->SetDrawColor(150,150,255);          //線の色
		$pdf->SetXY($left_margin,$top_margin+80);
		$pdf->SetLineWidth(0.5);

		//表の行数分表示
		for($c=0; $c < $page_line; $c++){
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
		    $pdf->SetTextColor(0,0,0);                //フォントの色

            //---------------------------------------------------------
            //１行目
            //---------------------------------------------------------
			//予定日の空白部分を表示
			$pdf->Cell("70", 12, "", "LTR", '0','C','1');

			//伝票番号セルの空白部分を表示
			$pdf->Cell("40", 12, "", "LTR", '0','C','1');

	        //得意先名を表示
	        $pdf->Cell("100", 12, $page_data[$i][$c]["client_cd"] , "LTB", "0", "L","1");
		    $pdf->SetTextColor(255,0,0);                //フォントの色
	        $pdf->Cell("40", 12, $page_data[$i][$c]["slip_out"] , "TBR", "0", "R","1");
		    $pdf->SetTextColor(0,0,0);                //フォントの色

	        //商品名を表示
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(80, 12, $page_data[$i][$c]["goods_name"][$j],                   'LT', '0','L','1');
			    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$c]["sale_price"][$j]), 'TR', '0','R','1');
            }

	        //消費税を表示
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	        //売上合計金額を表示
	        $pdf->Cell(70, 12, "", '1', '0', 'R', '1');
	        $pdf->Cell(70, 12, "", '1', '2', 'R', '1');

            //---------------------------------------------------------
            //２行目
            //---------------------------------------------------------
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(255,255,255);      //背景色

			//予定日の空白部分を表示
			$pdf->Cell("70", 12, $page_data[$i][$c]["ord_time"], "LR", '0','C','1');

	        //伝票番号を表示
			$pdf->Cell(40 , 12, $page_data[$i][$c]["ord_no"], 'LR', '0','C','1');

			//修正欄の上の空白セルを表示
			$pdf->Cell(140, 12, $page_data[$i][$c]["client_cname"], '1', '0','L','1');

	        //数量単価を表示
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$c]["num"][$j])  ,       '1', '0','R','1');
			    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$c]["sale_amount"][$j]), '1', '0','R','1');
            }

	        //消費税下の空白を表示
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["tax_amount"]), '1', '0', 'R', '1');

	        //売上合計金額を表示
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["net_amount1"]), '1', '0', 'R', '1');
	        $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$c]["net_amount2"]), '1', '2', 'R', '1');

            //---------------------------------------------------------
            //３行目
            //---------------------------------------------------------
			$posY = $pdf->GetY();
			$pdf->SetXY($left_margin, $posY);
			$pdf->SetFillColor(255,255,255);      //背景色

			//予定日の空白部分を表示
			$pdf->Cell("70", 12, "", "LBR", '0','C','1');

			//伝票番号セルの空白部分を表示
			$pdf->Cell(40 , 12, "", 'LBR', '0','C','1');

			//修正欄を表示
			$pdf->Cell(140, 12, $page_data[$i][$c]["client_cname2"], '1', '0','L','1');

	        //数量単価の項目を表示
            for($j = 0; $j < $max_line; $j++){
			    $pdf->Cell(50 , 12, "", '1', '0','C','1');
			    $pdf->Cell(80 , 12, "", '1', '0','C','1');
            }

	        //消費税下の空白を表示
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	        //売上合計金額を表示
	        $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');
	        $pdf->Cell(70 , 12, "", '1', '2', 'C', '1');
        }

        /********************商品・数量*********************/
        $cnt = 0;
        for($x=0;$x<4;$x++){
            $pdf->SetXY($left_margin+$goods_width[$x],$top_margin+635);
            $pdf->Cell(120,12,"商　　品",'1','0','C','1');
            $pdf->Cell(50,12,"数　　量",'1','2','C','1');

            for($c=0;$c<8;$c++){
                $posY = $pdf->GetY();
                $pdf->SetXY($left_margin+$goods_width[$x], $posY);
                $pdf->Cell(120,12,$page_data[$i]["goods_data"][$cnt]["goods_name"],'1','0','C','1');
                $pdf->Cell(50,12,My_Number_Format($page_data[$i]["goods_data"][$cnt]["sum"]),'1','2','R','1');
                $cnt++;
            }
        }

        /*******************合計****************************/
        //ページ合計
        $pdf->SetFont(GOTHIC, '', 11);
        $pdf->SetXY($left_margin+820,$top_margin+620);
        $pdf->Cell(80,26,"頁　　計",'1','0','C','1');

        $pdf->Cell(70,13,"",'1','0','R','1');
        if($page_data[$i]["last_flg"] != true){
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["net_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["net_amount2"])  ,'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+633);
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["tax_amount"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["intax_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data[$i]["intax_amount2"])  ,'1','0','R','1');
        }else{ 
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+633);
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
        }

        //代行先合計
        $pdf->SetXY($left_margin+820, $top_margin+646);
        $pdf->SetFillColor(180,180,180);      //背景色
        $pdf->Cell(80,26,"合　　計",'1','0','C','1');
        $pdf->Cell(70,13,""                                    ,'1','0','0','1');


        if($page_data[$i]["last_flg"] == true){
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["net_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["net_amount2"])  ,'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+659);
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["tax_amount"])      ,'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["intax_amount1"]),'1','0','R','1');
            $pdf->Cell(70,13,My_Number_format($page_data["id".$act_id]["intax_amount2"])  ,'1','0','R','1');
        }else{
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->SetXY($left_margin+900,$top_margin+659);
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
            $pdf->Cell(70,13,"",'1','0','R','1');
        }

        $pdf->SetXY($left_margin,$posY+100);
		$pdf->SetFillColor(255,255,255);      //背景色
        $pdf->SetXY($left_margin,$top_margin+750);
        $pdf->Cell(160,15,"印刷日　　".date('Y')."年　".date('m')."月　".date('d')."日",'0','0','L','1');
		$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_marginx+70, $top_margin);
	}

	$pdf->Output();
}

//得意先単位で代行データを纏める
function Make_Client_Data ($aord_id, $db_con){

    $count = count($aord_id);

    if($count == 0){
        return false;
    }
 
    //一覧画面でのチェックボックスの数分ループ
    foreach($aord_id AS $key => $var){
        //チェックされていない場合はf
        if($var != 'f'){
            //アンシリアライズ
            $target_aord_id = unserialize(urldecode(stripslashes($var)));

            //巡回配送日ごとのデータ
            $sql  = "SELECT \n";
            $sql .= "   t_aorder_h.ord_no,\n";
            $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
            $sql .= "   t_aorder_h.client_cname, \n";

            //--■商品が無い場合は、サービス名を表示する
            $sql .= "   (CASE \n";
            $sql .= "       WHEN t_aorder_d.goods_name IS NULL THEN t_aorder_d.serv_name \n";
            $sql .= "       WHEN t_aorder_d.goods_name = '' THEN t_aorder_d.serv_name \n";
            $sql .= "   ELSE t_aorder_d.goods_name \n";
            $sql .= "   END) AS goods_name, \n";
            $sql .= "   t_aorder_d.num, \n";
            $sql .= "   t_aorder_d.sale_price, \n";
            $sql .= "   t_client.trade_id, \n";
            $sql .= "   t_aorder_h.net_amount, \n";
            $sql .= "   t_aorder_h.tax_amount, \n";
            $sql .= "   t_aorder_d.sale_amount, \n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   act_id, \n";
            $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";
            $sql .= "   act_name, \n";
            $sql .= "   ord_time, \n";
//            $sql .= "   CASE t_aorder_h.slip_out ";
            $sql .= "   CASE t_client.slip_out ";
            $sql .= "       WHEN '1' THEN '' ";
            $sql .= "       WHEN '2' THEN '指' ";
            $sql .= "   END AS slip_out ";
            $sql .= "FROM\n";
            $sql .= "    t_aorder_h\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "    t_aorder_d\n";
            $sql .= "    ON t_aorder_d.aord_id = t_aorder_h.aord_id\n";
            $sql .= "       INNER JOIN ";
            $sql .= "    t_client ";
            $sql .= "    ON t_aorder_h.client_id = t_client.client_id ";
            $sql .= "WHERE\n";
            $sql .= "    t_aorder_h.aord_id IN (".implode(',',$target_aord_id).") \n";
            $sql .= "    AND\n";
            $sql .= "    t_aorder_h.del_flg = false \n";

            $sql .= "ORDER BY\n";
            $sql .= "   t_aorder_h.client_cd1,\n";
            $sql .= "   t_aorder_h.client_cd2,\n";
            $sql .= "   ord_time,\n";
            $sql .= "   t_aorder_h.aord_id, \n";
            $sql .= "   t_aorder_d.line \n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            $day_client_data = pg_fetch_all($result);
            $day_slip_count  = pg_num_rows($result);

            for($j = 0; $j < $day_slip_count; $j++){
                $act_id  = $day_client_data[$j]["act_id"];
                $aord_id = $day_client_data[$j]["aord_id"];

                //代行データ
                $client_data[$act_id]["act_id"]         = $day_client_data[$j]["act_id"];
                $client_data[$act_id]["act_cd"]         = $day_client_data[$j]["act_cd"];
                $client_data[$act_id]["act_name"]       = $day_client_data[$j]["act_name"];

                //ヘッダ
                $client_data[$act_id]["head"][$aord_id]["ord_time"]     = $day_client_data[$j]["ord_time"];
                $client_data[$act_id]["head"][$aord_id]["aord_id"]      = $day_client_data[$j]["aord_id"];
                $client_data[$act_id]["head"][$aord_id]["ord_no"]       = $day_client_data[$j]["ord_no"];
                $client_data[$act_id]["head"][$aord_id]["client_cd"]    = $day_client_data[$j]["client_cd"];
                $client_data[$act_id]["head"][$aord_id]["client_cname"] = $day_client_data[$j]["client_cname"];
                $client_data[$act_id]["head"][$aord_id]["trade_id"]     = $day_client_data[$j]["trade_id"];
                $client_data[$act_id]["head"][$aord_id]["net_amount"]   = $day_client_data[$j]["net_amount"];
                $client_data[$act_id]["head"][$aord_id]["tax_amount"]   = $day_client_data[$j]["tax_amount"];
                $client_data[$act_id]["head"][$aord_id]["slip_out"]     = $day_client_data[$j]["slip_out"];

                //データ
                $client_data[$act_id][$aord_id]["goods_name"][]         = $day_client_data[$j]["goods_name"];
                $client_data[$act_id][$aord_id]["num"][]                = $day_client_data[$j]["num"];
                $client_data[$act_id][$aord_id]["sale_price"][]         = $day_client_data[$j]["sale_price"];
                $client_data[$act_id][$aord_id]["sale_amount"][]        = $day_client_data[$j]["sale_amount"];
            }

        }else{
            $f++;
            continue;
        }
    }

    //一つも選択されていない場合
    if($f == $count){
        return false;
    }

    return $client_data;
}

//受注番号採番
function Set_Aord_No($act_data, $db_con){
    Db_Query($db_con, "BEGIN;");

    //代行先の件数分ループ
    foreach($act_data AS $key => $var){

        //集計日報IDを抽出
        $max_id = Get_Daily_Slip_Id($db_con);

        //IDの取得に失敗した場合
        if($max_id === false){ 
            return false;
        }       


        //伝票枚数分ループ
        foreach($act_data[$key]["head"] AS $keys => $var2){

            //伝票に採番する
            if($act_data[$key]["head"][$keys]["ord_no"] == null){

                //受注番号を抽出
                $sql  = "SELECT";
                $sql .= "   MAX(ord_no) ";
                $sql .= "FROM";
                $sql .= "   t_aorder_no_serial";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);

                $order_no = pg_fetch_result($result, 0 ,0);
                $order_no = $order_no +1;
                $act_data[$key]["head"][$keys]["ord_no"] = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                //受注番号登録処理
                $sql  = "INSERT INTO t_aorder_no_serial (\n";
                $sql .= "   ord_no\n";
                $sql .= ")VALUES(\n";
                $sql .= "   '".$act_data[$key]["head"][$keys]["ord_no"]."'\n";
                $sql .= ");\n";

                $result = Db_Query($db_con, $sql);

                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_no_serial_pkey";
                    $err_flg = true;
                    Db_Query($db_con, "ROLLBACK;");

                    if(strstr($err_message, $err_format) != false){
                        return false;
                    }else{
                        exit;
                    }
                }

                //伝票番号に＋１した値を登録
                $sql  = "UPDATE ";
                $sql .= "   t_aorder_h ";
                $sql .= "SET";
                $sql .= "   ord_no = '".$act_data[$key]["head"][$keys]["ord_no"]."', \n";
                $sql .= "   daily_slip_out_day = NOW(), ";
                $sql .= "   daily_slip_id = $max_id "; 
                $sql .= "WHERE\n";
                $sql .= "   aord_id = ".$keys."\n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);

                //同じ伝票で同時に採番処理が実行された場合エラー
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_h_ord_no_key";
                    $err_flg = true;
                    Db_Query($db_con, "ROLLBACK;");

                    if(strstr($err_message, $err_format) != false){
                        return false;
                    }else{
                        exit;
                    }
                }
            //既に採番済みの場合はｽｷｯﾌﾟ
            }else{
                continue;
            }
        }
    }
    Db_Query($db_con, "COMMIT;");

    return $act_data;
}

//商品情報抽出
function Make_Goods_Data ($act_data, $db_con){

	//--消耗品
	$sql  = "(SELECT  ";
    $sql .= " t_aorder_d.egoods_name AS goods_name, ";
    $sql .= "  sum(t_aorder_ship.num) AS sum ";
    $sql .= "FROM ";
    $sql .= "  t_aorder_d ";
    $sql .= "      INNER JOIN ";
    $sql .= "  t_aorder_ship ";
    $sql .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
    $sql .= "  AND t_aorder_d.aord_id IN (".implode(",",$act_data).") ";
    $sql .= "  AND t_aorder_d.egoods_id = t_aorder_ship.goods_id ";
    $sql .= "GROUP BY ";
    $sql .= "  t_aorder_ship.goods_cd, ";
    $sql .= "  t_aorder_d.egoods_name ";
    $sql .= "ORDER BY ";
    $sql .= "  t_aorder_ship.goods_cd  ";
    $sql .= ") ";
    $sql .= "UNION  ";
	//--アイテム
    $sql .= "(SELECT  ";
    $sql .= "  t_aorder_d.goods_name, ";
    $sql .= "  sum(t_aorder_ship.num) AS sum ";
    $sql .= "FROM ";
    $sql .= "  t_aorder_d ";
    $sql .= "      INNER JOIN ";
    $sql .= "  t_aorder_ship ";
    $sql .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
    $sql .= "  AND t_aorder_d.aord_id IN (".implode(",",$act_data).") ";
    $sql .= "  AND t_aorder_d.goods_id = t_aorder_ship.goods_id ";
    $sql .= "GROUP BY ";
    $sql .= "  t_aorder_ship.goods_cd, ";
    $sql .= "  t_aorder_d.goods_name ";
    $sql .= "ORDER BY ";
    $sql .= "  t_aorder_ship.goods_cd ";
    $sql .= ") ";


    $result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) > 0){
        $goods_data = pg_fetch_all($result);
    }

    return $goods_data;

}

//表示形式に作り変える                       //行          //列
function Make_Show_Data ($act_data, $db_con, $max_slip, $max_line){


    //初期値
    $page = 0;          //ページ数
    $row  = 0;          //行数
    $line = 0;
    $slip_num = 0;      //伝票数

    $max_row = $max_slip * 3;

    $first = true;
    //代行先分ループ
    foreach($act_data AS $key => $var){

        //代行先が変わった場合
        if($act_id != $act_data[$key]["act_id"] && $first != true){

            //最後のページ
            //合計金額の表示を判別  
            $page_data[$page]["last_flg"] = true;

            $renew_page_flg = true;
        }

        $first = false;

        //改ページフラグがtrue
        if($renew_page_flg == true){

            //代行先の出庫品
            $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

            $page++;            //改ページ
            $row = 0;           //行数クリア
            $slip_num = 0;      //伝票数

            //ページ合計をクリア
            $act_net_amount1 = 0;
            $act_intax_amount1 = 0;
            $act_net_amount2 = 0;
            $act_intax_amount2 = 0;
            $act_tax_amount  = 0;

            $renew_page_flg = false;

            $act_id = $act_data[$key]["act_id"];    //代行ID
            $page_data[$page]["act_id"] = $act_id;  //代行ID
        }

        $act_id = $act_data[$key]["act_id"];        //代行ID
        $page_data[$page]["act_id"] = $act_id;      //代行ID

        $page_data["id".$act_id]["act_cd"]   = $act_data[$key]["act_cd"];    //代行コード

        $page_data["id".$act_id]["act_name"] = $act_data[$key]["act_name"];  //代行名


        //得意先名が15文字以上の場合は2段に分ける
        if(mb_strlen($act_data[$key]["act_name"]) > 15){
            $page_data["id".$act_id]["act_name"]     = mb_substr($act_data[$key]["act_name"],0,15);
            $page_data["id".$act_id]["act_name2"]    = mb_substr($act_data[$key]["act_name"],15);
        }else{
            $page_data["id".$act_id]["act_name"]     = $act_data[$key]["act_name"];     //得意先名
        }

        //金額データクリア
        $act_net_amount   = null;
        $act_tax_amount   = null;

        //伝票枚数分ループ
        foreach($act_data[$key]["head"] AS $key2 => $var2){

            //フラグ初期化
            $renew_row_flg = false;

            //改ページフラグがtrue
            if($renew_page_flg == true){
                //ページごとの出庫品
                $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

                $page++;        //改ページ
                $row = 0;       //行数クリア
                $slip_num = 0;  //伝票数クリア

                //ページ合計をクリア
                $act_net_amount1 = 0;
                $act_intax_amount1 = 0;
                $act_net_amount2 = 0;
                $act_intax_amount2 = 0;
                $act_tax_amount  = 0;

                $renew_page_flg = false;
                $act_id = $act_data[$key]["act_id"];    //代行ID
                $page_data[$page]["act_id"] = $act_id;    //代行ID
            }

            //伝票データ
            $page_data[$page][$slip_num]["ord_no"]        = $act_data[$key]["head"][$key2]["ord_no"];       //伝票番号
            $page_data[$page][$slip_num]["aord_id"]       = $act_data[$key]["head"][$key2]["aord_id"];      //受注ID
            $arod_id[$page][] = $page_data[$page][$slip_num]["aord_id"]; 
            $ord_time                                     = $act_data[$key]["head"][$key2]["ord_time"];     //配送日
            $page_data[$page][$slip_num]["ord_time"]      = Get_Basic_Date($stand_day, $ord_time);          //配送日
            $page_data[$page][$slip_num]["client_cd"]     = $act_data[$key]["head"][$key2]["client_cd"];    //得意先コード
            $page_data[$page][$slip_num]["client_cname"]  = $act_data[$key]["head"][$key2]["client_cname"]; //得意先名
            $page_data[$page][$slip_num]["slip_out"]      = $act_data[$key]["head"][$key2]["slip_out"];     //伝票発行形式

            //得意先名が15文字以上の場合は2段に分ける
            if(mb_strlen($act_data[$key]["head"][$key2]["client_cname"]) > 15){
                $page_data[$page][$slip_num]["client_cname"]     = mb_substr($act_data[$key]["head"][$key2]["client_cname"],0,15);
                $page_data[$page][$slip_num]["client_cname2"]    = mb_substr($act_data[$key]["head"][$key2]["client_cname"],15);
            }else{
                $page_data[$page][$slip_num]["client_cname"]     = $act_data[$key]["head"][$key2]["client_cname"];     //得意先名
            }

            $page_data[$page][$slip_num]["trade_id"]      = $act_data[$key]["head"][$key2]["trade_id"];     //取引区分

            $page_data[$page][$slip_num]["tax_amount"]    = $act_data[$key]["head"][$key2]["tax_amount"];   //消費税額

            //現金の場合
            if($page_data[$page][$slip_num]["trade_id"] == "61"){
                $page_data[$page][$slip_num]["net_amount1"]    = $act_data[$key]["head"][$key2]["net_amount"];   //売上金額（税抜）
                $page_data[$page][$slip_num]["intax_amount1"]  = $page_data[$page][$slip_num]["net_amount1"] + $page_data[$page][$slip_num]["tax_amount"];   //売上金額（税込）
            //掛
            }else{
                $page_data[$page][$slip_num]["net_amount2"]    = $act_data[$key]["head"][$key2]["net_amount"];   //売上金額（税抜）
                $page_data[$page][$slip_num]["intax_amount2"]  = $page_data[$page][$slip_num]["net_amount2"] + $page_data[$page][$slip_num]["tax_amount"];   //売上金額（税込）
            }            

            //ページ合計
            $act_net_amount1    += $page_data[$page][$slip_num]["net_amount1"];       //現金合計(税抜)
            $page_data[$page]["net_amount1"] = $act_net_amount1;                        

            $act_intax_amount1  += $page_data[$page][$slip_num]["intax_amount1"];   //現金合計(税込)
            $page_data[$page]["intax_amount1"] = $act_intax_amount1;                        

            $act_net_amount2    += $page_data[$page][$slip_num]["net_amount2"];       //掛合計(税抜)
            $page_data[$page]["net_amount2"] = $act_net_amount2;

            $act_intax_amount2  += $page_data[$page][$slip_num]["intax_amount2"];   //現金合計(税込)
            $page_data[$page]["intax_amount2"] = $act_intax_amount2;                        

            $act_tax_amount     += $page_data[$page][$slip_num]["tax_amount"];        //消費税合計
            $page_data[$page]["tax_amount"] = $act_tax_amount;

            //代行先合計
            $page_data["id".$act_id]["net_amount1"]     +=  $page_data[$page][$slip_num]["net_amount1"]; 
            $page_data["id".$act_id]["intax_amount1"]   +=  $page_data[$page][$slip_num]["intax_amount1"];
            $page_data["id".$act_id]["net_amount2"]     +=  $page_data[$page][$slip_num]["net_amount2"];
            $page_data["id".$act_id]["intax_amount2"]   +=  $page_data[$page][$slip_num]["intax_amount2"];
            $page_data["id".$act_id]["tax_amount"]      +=  $page_data[$page][$slip_num]["tax_amount"];

            //商品分ループ
            $goods_num = count($act_data[$key][$key2]["goods_name"]);
            for($j = 0; $j < $goods_num; $j++){
                //改行フラグがtrue
                if($renew_row_flg === true){
                    $row+=3;      //改行
                    $slip_num++;  //伝票数

                    //改ページフラグ
                    $renew_page_flg = ($row >= $max_row)? true : false;

                    //改ページフラグがtrue
                    if($renew_page_flg === true){

                        //ページごとの出庫品
                        $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);

                        $page++;         //改ページ
                        $row = 0;        //行数クリア
                        $slip_num = 0;   //伝票数クリア

                        //ページ合計をクリア
                        $act_net_amount1 = 0;
                        $act_intax_amount1 = 0;
                        $act_net_amount2 = 0;
                        $act_intax_amount2 = 0;
                        $act_tax_amount  = 0;

                        $act_id = $act_data[$key]["act_id"];    //代行ID
                        $page_data[$page]["act_id"] = $act_id;  //代行ID
                    }

                    $line = 0;      //列数クリア
                    $renew_row_flg  = false;
                    $renew_page_flg = false;
                }

                //商品データ
                $page_data[$page][$slip_num]["goods_name"][$line]    = $act_data[$key][$key2]["goods_name"][$j];    //商品名 
                $page_data[$page][$slip_num]["num"][$line]           = $act_data[$key][$key2]["num"][$j];           //数量
                $page_data[$page][$slip_num]["sale_price"][$line]    = $act_data[$key][$key2]["sale_price"][$j];    //単価 
                $page_data[$page][$slip_num]["sale_amount"][$line]   = $act_data[$key][$key2]["sale_amount"][$j];   //金額 

                $line++;    //列移動

                //改行フラグ
                $renew_row_flg = ($line == $max_line)? true : false;
            }

            $line = 0;   //列数クリア
            $slip_num++; //伝票数
            $row+=3;     //改行

            //改ページフラグ
            $renew_page_flg = ($row >= $max_row)? true : false;
        }

        //ページごとの出庫品
        $page_data[$page]["goods_data"] = Make_Goods_Data ($arod_id[$page], $db_con);
        $page_data[$page]["last_flg"] = true;

        //改ページフラグがtrue
        if($renew_page_flg === true  && count($act_data[next]) != 0){

            $page++;                    //改ページ
            $row = 0;                   //行数クリア
            $slip_num = 0;              //伝票数クリア
            $renew_page_flg = false;
        }

        $row++;           //改行
        $slip_num++;     //伝票数

        //改ページフラグ
        $renew_page_flg = ($row >= $max_row)? true : false;
    }

    //ページ数
    $page++;
    $page_data["page"] = $page;


    return $page_data;
}

//基準日
function Get_Basic_Date($stand_day, $send_day){

    //配送日を分割
    $all_send_day = explode("-", $send_day);

    //配送日の曜日を抽出
    $send_day_w   = date('w', mktime(0,0,0,$all_send_day[1], $all_send_day[2], $all_send_day[0]));

    if($send_day_w == '0'){
        $week_w = "日";
    }elseif($send_day_w == '1'){
        $week_w = "月";
    }elseif($send_day_w == '2'){
        $week_w = "火";
    }elseif($send_day_w == '3'){
        $week_w = "水";
    }elseif($send_day_w == '4'){
        $week_w = "木";
    }elseif($send_day_w == '5'){
        $week_w = "金";
    }elseif($send_day_w == '6'){
        $week_w = "土";
    }

    $basic_date_res = Basic_date($stand_day[0],$stand_day[1],$stand_day[2],$all_send_day[0],$all_send_day[1],$all_send_day[2]);

    if($basic_date_res[0] == '1'){
        $week = "A";
    }elseif($basic_date_res[0] == '2'){
        $week = "B";
    }elseif($basic_date_res[0] == '3'){
        $week = "C";
    }elseif($basic_date_res[0] == '4'){
        $week = "D";
    }

    $res = $all_send_day[0]."年".$all_send_day[1]."月".$all_send_day[2]."日";

    return $res;
}

function Show_Template ($message, $smarty){
    //インスタンス生成
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "閉じる", "OnClick=\"window.close()\"");

    $page_title = "代行集計表";

    //////////////////////////////
    //HTMLヘッダ
    //////////////////////////////
    $html_header = Html_Header($page_title);

    //////////////////////////////
    //HTMLフッタ
    //////////////////////////////
    $html_footer = Html_Footer();

    // Render関連の設定
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form関連の変数をassign
    $smarty->assign('form',$renderer->toArray());

    //その他の変数をassign
    $smarty->assign('var',array(
        'html_header'   => "$html_header",
        'html_footer'   => "$html_footer",
        'message'       => "$message",
    ));

    //テンプレートへ値を渡す
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
    exit;
}
?>
