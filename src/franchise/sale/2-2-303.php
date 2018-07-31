<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/24　04-007　　　　watanabe-k　翌月の請求更新を行なうと、同じデータが2つ表示される。
 *                                         さらに翌月の請求更新を行なうと、同じデータが3つ表示されるバグの修正
 *
 * 　2007/04/24　      　　　　morita-d  　・列の幅を一箇所で設定できるように修正
 *                                         ・「今回の御支払額」を表示項目に追加
 *                                         ・4桁までの行NOが枠線にかからないように修正
 *   2007/06/20                watanabe-k  ・請求書発行紹介の検索に対応
 */

$page_title = "請求一覧表";

//環境設定ファイル
require_once("ENV_local.php");

//請求関連で使用する関数ファイル
require_once(INCLUDE_DIR."seikyu.inc");

require_once(INCLUDE_DIR."common_quickform.inc");

//現モジュール内のみで使用する関数ファイル
require_once(INCLUDE_DIR.(basename($_SERVER["PHP_SELF"].".inc")));

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST");

//DB接続
$db_con = Db_Connect();

//処理開始時間
$s_time = microtime();


/****************************/
// 権限チェック
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
//変数名の置き換え（以後$_POSTは使用しない）
/****************************/
// ユーザ入力
if ($_POST["renew_flg"] == "1"){

    $display_num        = $_POST["form_display_num"];
    $output_type        = $_POST["form_output_type"];
    $client_branch      = $_POST["form_client_branch"];
    $attach_branch      = $_POST["form_attach_branch"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $client_name        = $_POST["form_client"]["name"];
    $round_staff_cd     = $_POST["form_round_staff"]["cd"];
    $round_staff_select = $_POST["form_round_staff"]["select"];
    $part               = $_POST["form_part"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $amount_this_s      = $_POST["form_amount_this"]["s"];
    $amount_this_e      = $_POST["form_amount_this"]["e"];
    $close_day_sy       = $_POST["form_close_day"]["sy"];
    $close_day_sm       = $_POST["form_close_day"]["sm"];
    $close_day_sd       = $_POST["form_close_day"]["sd"];
    $close_day_ey       = $_POST["form_close_day"]["ey"];
    $close_day_em       = $_POST["form_close_day"]["em"];
    $close_day_ed       = $_POST["form_close_day"]["ed"];
    $collect_day_sy     = $_POST["form_collect_day"]["sy"];
    $collect_day_sm     = $_POST["form_collect_day"]["sm"];
    $collect_day_sd     = $_POST["form_collect_day"]["sd"];
    $collect_day_ey     = $_POST["form_collect_day"]["ey"];
    $collect_day_em     = $_POST["form_collect_day"]["em"];
    $collect_day_ed     = $_POST["form_collect_day"]["ed"];
    $claim_cd1          = $_POST["form_claim"]["cd1"];
    $claim_cd2          = $_POST["form_claim"]["cd2"];
    $claim_name         = $_POST["form_claim"]["name"];
    $issue              = $_POST["form_issue"];
    $claim_send         = $_POST["form_cliam_send"];
    $last_update        = $_POST["form_last_update"];
    $bill_no_s          = $_POST["form_bill_no"]["s"];
    $bill_no_e          = $_POST["form_bill_no"]["e"];

    $where              = $_POST; 
    $claim_fix          = $_POST["claim_fix"];
    $claim_renew        = $_POST["claim_renew"];
    $claim_cancel       = $_POST["claim_cancel"];
    $branch_id          = $_POST["form_branch_id"];
 
    //その他
    $f_page1            = $_POST["f_page1"];
    $hyouji_button      = $_POST["hyouji_button"];
    $fix_button         = $_POST["fix_button"];
    $renew_button       = $_POST["renew_button"];
    $cancel_button      = $_POST["cancel_button"];
    $bill_id            = $_POST["bill_id"];
    $link_action        = $_POST["link_action"];
    $renew_flg          = $_POST["renew_flg"];

    $post_flg           = true; 

}


/*********************************/
// チェック用hidden作成
/*********************************/
/* 共通フォーム */
Search_Form_Claim($db_con, $form, $ary_form_list);

/* モジュール別フォーム */
// 請求書発行
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未発行", "2");
$obj[]  =&  $form->createElement("radio", null, null, "発行済", "3");
$form->addGroup($obj, "form_issue", "", " ");

// 請求書送付
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",         "1");
$obj[]  =&  $form->createElement("radio", null, null, "郵送",         "2");
$obj[]  =&  $form->createElement("radio", null, null, "メール",       "3");
$obj[]  =&  $form->createElement("radio", null, null, "WEB",          "5");
$obj[]  =&  $form->createElement("radio", null, null, "郵送・メール", "4");
$form->addGroup($obj, "form_claim_send", "", " ");

// 請求更新
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "全て",   "1");
$obj[]  =&  $form->createElement("radio", null, null, "未実施", "2");
$obj[]  =&  $form->createElement("radio", null, null, "実施済", "3");
$form->addGroup($obj, "form_last_update", "", " ");

// 請求番号
Addelement_Slip_Range($form, "form_bill_no", "請求番号");

// 表示ボタン
$form->addElement("text", "hyouji_button", "表　示");


/****************************/
// エラーチェック
/****************************/
/****************************/
// ラジオボタン不正値POSTチェック
/****************************/
$err_chk_radio = array(
    array($display_num,  "2"),      // 表示件数
    array($output_type,  "2"),      // 出力形式
    array($issue,        "3"),      // 請求書発行
    array($claim_send,   "5"),      // 請求書送付
    array($claim_update, "3"),      // 請求更新
);

foreach ($err_chk_radio as $key => $value){
    if (!("1" <= $value[0] || $value[0] <= $value[1])){
        print "不正な値が入力されました。(".($key+1).")<br>";
        exit;
    }
}

// 日付POSTデータの0埋め
$_POST["form_close_day"]    = Str_Pad_Date($_POST["form_close_day"]);
$_POST["form_collect_day"]  = Str_Pad_Date($_POST["form_collect_day"]);

/****************************/
// エラーチェック
/****************************/
// ■巡回担当者
$err_msg = "巡回担当者 は数値のみ入力可能です。";
Err_Chk_Num($form, "form_round_staff", $err_msg);

// ■請求額
$err_msg = "請求額 は数値のみ入力可能です。";
Err_Chk_Int($form, "form_amount_this", $err_msg);

// ■請求締日
//$err_msg = "請求締日 の日付が妥当ではありません。";
//Err_Chk_Date($form, "form_close_day", $err_msg);

// ■請求締日
$err_msg = "請求締日 の日付が妥当ではありません。";
// 文字列チェック
if (    
    ($_POST["form_close_day"]["y"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["y"])) ||
    ($_POST["form_close_day"]["m"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["m"]))
){
    $form->setElementError("form_close_day", $err_msg);
}else   
// 妥当性チェック
if ($_POST["form_close_day"]["m"] != null && ($_POST["form_close_day"]["m"] < 1 || $_POST["form_close_day"]["m"] > 12)){ 
    $form->setElementError("form_close_day", $err_msg);
}




// ■回収予定日
$err_msg = "回収予定日 の日付が妥当ではありません。";
Err_Chk_Date($form, "form_collect_day", $err_msg);

/****************************/
// エラーチェック結果集計
/****************************/
// チェック適用
$form->validate();
// 結果をフラグに
$err_flg = (count($form->_errors) > 0) ? true : false;

$post_flg = ($err_flg != true) ? true : false;


/****************************/
// 一覧表示処理
/****************************/
if ($post_flg == true && $err_flg != true){

    //該当件数取得
    $total_count = Get_Claim_Data($db_con, $where, "", "", "count");

    //現在のページ数をチェックする
    $page_info = Check_Page($total_count, $total_count, $f_page1);
    $page      = $page_info[0]; //現在のページ数
    $page_snum = $page_info[1]; //表示開始件数
    $page_enum = $page_info[2]; //表示終了件数

    //ページ作成
    $data_list  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);

    require(FPDF_DIR);

    //*******************入力箇所*********************

    //余白
    $left_margin = 40;
    $top_margin = 40;

    //ヘッダーのフォントサイズ
    $font_size = 9;
    //ページサイズ
    $page_size = 1110;

    //A3
    $pdf=new MBFPDF('L','pt','A3');

    //タイトル
    $title = "請求一覧表";
    $page_count = "1"; 

    //横幅
    $width[0]  = "25";
    $width[1]  = "45";
    $width[2]  = "55";
    $width[3]  = "300";
    $width[4]  = "55";
    $width[5]  = "70";
    $width[6]  = "70";
    $width[7]  = "70";
    $width[8]  = "70";
    $width[9]  = "70";
    $width[10] = "70";
    $width[11] = "70";
    $width[12] = "70";
    $width[13] = "70";


    //幅・項目名・align
    $list[0]  = array($width[0], "NO","C");
    $list[1]  = array($width[1], "請求番号","C");
    $list[2]  = array($width[2], "請求日","C");
    $list[3]  = array($width[3], "請求先","C");
    $list[4]  = array($width[4], "回収予定日","C");
    $list[5]  = array($width[5], BILL_AMOUNT_LAST,"C");
    $list[6]  = array($width[6], PAYIN_AMOUNT,"C");
    $list[7]  = array($width[7], TUNE_AMOUNT,"C");
    $list[8]  = array($width[8], REST_AMOUNT,"C");
    $list[9]  = array($width[9], SALE_AMOUNT,"C");
    $list[10] = array($width[10],TAX_AMOUNT,"C");
    $list[11] = array($width[11],INTAX_AMOUNT,"C");
    $list[12] = array($width[12],BILL_AMOUNT_THIS,"C");
    $list[13] = array($width[13],PAYMENT_THIS,"C");
//    $list[5] = array("150","巡回担当","C");

    //合計名
    $list_sub[0] = array("50","合計","L");

    //align(データ)⇒この配列は使用されていない(2007/04/27:morita-d)
    $data_align[0] = "R";
    $data_align[1] = "L";
    $data_align[2] = "C";
    $data_align[3] = "L";
    $data_align[4] = "C";
    $data_align[5] = "R";
    $data_align[6] = "R";
    $data_align[7] = "R";
    $data_align[8] = "R";
    $data_align[9] = "R";
    $data_align[10] = "R";
    $data_align[11] = "R";
    $data_align[12] = "R";
//    $data_align[5] = "L";

    //ページ最大表示数
    $page_max = 50;

		//列数
    $td_count = count($list);

    //仮の時刻
    if($close_day_s[y] != null && $close_day_e[y] != null){
        $time = "請求期間：$close_day_s[y]年$close_day_s[m]月$close_day_s[d]日〜$close_day_e[y]年$close_day_e[m]月$close_day_e[d]日";
    }elseif($close_day_s[y] != null){
        $time = "請求期間：$close_day_s[y]年$close_day_s[m]月$close_day_s[d]日〜";
    }elseif($close_day_e[y] != null){
        $time = "請求期間：〜$close_day_e[y]年$close_day_e[m]月$close_day_e[d]日";
    }else{
        $time = "請求期間：　指定無し";
    }
    //***********************************************

    //DB接続
//    $result = Db_Query($db_con,$sql);

    $pdf->AddMBFont(GOTHIC ,'SJIS');
    $pdf->SetFont(GOTHIC, '', 9);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    $date = date("印刷時刻　Y年m月d日　H:i");

    //ヘッダー表示
    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

    //ＤＢの値を表示
    //行数・ページ数・次のページ表示数・小計・合計・比較値・件数、初期化
    $count = 0;
    $page_count++;
    $page_next = $page_max;
    $data_total = array();
    $shop = "";
    $shop_count = 0;

//    while($data_list = pg_fetch_array($result)){
      for($i = 0; $i < count($data_list); $i++){
        $count++;
        //*******************改ページ処理*****************************

	    //行番号がページ最大表示数になった場合、改ページする
	    if($page_next+1 == $count){
		    $pdf->AddPage();

		    //ヘッダー表示
		    Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		    //次の最大表示数
		    $page_next = $page_max * $page_count;
		    $page_count++;
	    }

        //************************請求先件数***************************
/*
	    //請求先が変更した場合、件数を＋１
	    if($data_list[$i][3] != $shop){
		    $shop_count++;
	    $shop = $data_list[$i][slip_no];
	    }
*/
        //*************************************************************

	    $posY = $pdf->GetY();
	    $pdf->SetXY($left_margin, $posY);
	    $pdf->SetFont(GOTHIC, '', 9);

        //************************データ表示***************************
	    //行番号
//	    $pdf->Cell($list[0][0], 14, "$count", '1', '0', $data_align[0]);
/*
	    for($x=1;$x<14;$x++){
		    $line = '1';
            if($x < 6){
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '0', 'L');
            }elseif($x < 13){
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '0', 'R');
            }else{
		        $pdf->Cell($list[$x][0], 14, $data_list[$i][$x-1], 1, '2', 'R');
            }
	    }
*/
        $number = $i+1;
        $pdf->Cell($width[0],  14, "$number", 1, '0', 'R');
        $pdf->Cell($width[1],  14, $data_list[$i][0],  1, '0', 'L');
        $pdf->Cell($width[2],  14, $data_list[$i][1],  1, '0', 'C');
        $pdf->Cell($width[3],  14, $data_list[$i][14]."-".$data_list[$i][15]."　".$data_list[$i][2], 1, '0', 'L');
        $pdf->Cell($width[4],  14, $data_list[$i][3],  1, '0', 'C');
        $pdf->Cell($width[5],  14, $data_list[$i][5],  1, '0', 'R');
        $pdf->Cell($width[6],  14, $data_list[$i][6],  1, '0', 'R');
        $pdf->Cell($width[7],  14, $data_list[$i][7],  1, '0', 'R');
        $pdf->Cell($width[8],  14, $data_list[$i][8],  1, '0', 'R');
        $pdf->Cell($width[9],  14, $data_list[$i][9],  1, '0', 'R');
        $pdf->Cell($width[10], 14, $data_list[$i][10], 1, '0', 'R');
        $pdf->Cell($width[11], 14, $data_list[$i][11], 1, '0', 'R');
        $pdf->Cell($width[12], 14, $data_list[$i][12], 1, '0', 'R');
        $pdf->Cell($width[13], 14, $data_list[$i][13], 1, '2', 'R');

    }
    //*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFillColor(213,213,213);
	$count++;

    //*******************改ページ処理*****************************

	//行番号がページ最大表示数になった場合、改ページする
	if($page_next+1 == $count){
		$pdf->AddPage();

		//ヘッダー表示
		Header_disp($pdf,$left_margin,$top_margin,$title,"",$date,"",$time,$page_count,$list,$font_size,$page_size);

		//次の最大表示数
		$page_next = $page_max * $page_count;
		$page_count++;
	}

    //*************************************************************

	$posY = $pdf->GetY();
	$pdf->SetXY($left_margin, $posY);
	$pdf->SetFont(GOTHIC, 'B', 9);

    //*************************合計処理*******************************
    for($x=0; $x<$td_count; $x++){
    //for($x=0;$x<13;$x++){
	    //合計行番号
	    if($x==0){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //合計名
	    }else if($x==1){
		    $pdf->Cell($width[$x], 14, $list_sub[0][1], '1', '0','R','1');
	    }else if($x==2){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //件数
	    }else if($x==3){
		    $pdf->Cell($width[$x], 14, $data_list[0][sum][no]."社", '1', '0','R','1');
	    }else if($x==4){
		    $pdf->Cell($width[$x], 14, "", '1', '0','R','1');
	    //件数
	    }else if($x > 4) {
		    //合計値
		    $pdf->Cell($width[$x], 14, number_format($data_list[0][sum][$x]), '1', '0','R','1');
	    }
    }
    //****************************************************************

    $pdf->Output();
    exit;
//エラーの場合はテンプレートに表示
}else{
    /****************************/
    //HTMLヘッダ
    /****************************/
    $html_header = Html_Header($page_title);

    /****************************/
    //HTMLフッタ
    /****************************/
    $html_footer = Html_Footer();


    /****************************/
    //テンプレートへの処理
    /****************************/
    // Render関連の設定
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form関連の変数をassign
    $smarty->assign('form',$renderer->toArray());

    //エラーをassign
    $errors = $form->_errors;
    $smarty->assign('errors', $errors);

    //検索結果
    $smarty->assign('claim_data', $claim_data);

    //その他の変数をassign
    $smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    "auth_r_msg"  => "$auth_r_msg"
    ));

    //テンプレートへ値を渡す
    $smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));
}


































?>
