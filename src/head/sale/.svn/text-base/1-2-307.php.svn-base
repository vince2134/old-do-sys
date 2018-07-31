<?php

/*
* 履歴：
* 　日付　　　　B票No.　　　　担当者　　　内容　
* 　2006/11/29  scl-0030　　　watanabe-k　親子関係有で、明細請求書を指定しているのに、合計請求書のみが表示されるバグの修正
* 　2007/04/26          　　　morita-d  　「親子なし」かつ「個別明細」で2ページ目以降は合計金額を表示しないように修正
* 　2007/06/16          　　　watanabe-k　請求書を発行していない場合はエラー表示
*
*/

require_once("ENV_local.php");
require(FPDF_DIR);
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc")));


//DB接続
$db_con = Db_Connect();

//権限チェック
$auth       = Auth_Check($db_con);

/*
if ($_POST["claim_issue"]=="") {
	echo "請求書を指定して下さい。";
	exit;
}
*/

//基準点
$xx = 10;
$yy = 15;
//$cellyy = 60; //合計金額セル基準点Y
//$tabyy  = 83; //データセル基準点Y

//縦書き、mm基準、A4サイズ
$pdf=new MBFPDF('P','mm','A4');

//フォント設定
$pdf->AddMBFont(GOTHIC,'SJIS');
$pdf->AddMBfont(PGOTHIC,'SJIS');
$pdf->AddMBfont(MINCHO,'SJIS');
$pdf->AddMBfont(PMINCHO,'SJIS');
$pdf->Open();

//改ページ設定
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('MS-Gothic','',7);
//$pdf->SetTitle(mb_convert_encoding("請求書", "utf-8", "EUC-JP"));
//$pdf->SetSubject("請求書");

//$_POST["claim_issue"] = NULL;
//$_POST["claim_issue"][] = 19; //通常
//$_POST["claim_issue"][] = "f"; //親子
//$_POST["claim_issue"][] = 63; //親子(合計)
//$_POST["claim_issue"][] = 22; //親子(合計)
//$_POST["claim_issue"][] = 72; //親子(合計)
//print_array ($_POST["claim_issue"]);


//再発行ボタン押下
if($_POST["hdn_button"] == "再発行"){
    $claim_issue = $_POST["re_claim_issue"];
}else{
    $claim_issue = $_POST["claim_issue"];
}

//前発行ボタン押下
if($_POST["hdn_button"] == "前発行"){
    $max_j = 1; //控えのみを発行するため、ループ回数を１回にする。
}else{
    $max_j = 2;
}


//フォーマット
$bill_format = $_POST["format"];

//選択されていない場合はとりあえず意味のない配列作成する
//foreachでのエラーを防ぐため
if(!is_array($claim_issue)){
    $claim_issue[] = 'f';
}

/****************************/
//POSTされた請求IDを取得
/****************************/
//foreach($_POST["claim_issue"] AS $bill_id){

//請求書を発行していない数
$cnt = 0;
foreach($claim_issue AS $key => $bill_id){
	
	//請求書IDがfの場合は処理しない
	if($bill_id != "f"){

		//請求書の出力パターンを取得
		$pattern = Chk_Claim_Pattern($db_con,$bill_id, $bill_format[$key]);
		//$pattern = 3;

		//請求書データ取得
		$bill_data[$bill_id][head] = Get_Claim_Header($db_con,$bill_id);
		$bill_data[$bill_id][data] = Get_Claim_Data($db_con,$bill_id,$pattern);
		//print_array($bill_data,head);
		//print_array($bill[data],data);

		for ($j = 0; $j < $max_j; $j++){
			$bill[head] = $bill_data[$bill_id][head];
			$bill[data] = $bill_data[$bill_id][data];
			if ($j == "0") $hikae_flg = "t";
			if ($j == "1") $hikae_flg = "f";

			/****************************/
			//「親子関係なし」かつ「明細」
			/****************************/
			if ($pattern == "1") {
					
				$page = 1;
				while (count($bill[data][0])) {
					//ページ作成
					$pdf->AddPage();

					//ヘッダ部分表示
					Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,2,$page,$xx,$yy);
		
					//合計金額表示
					Write_Claim_Total($pdf,$bill[head][0],$hikae_flg,NULL,NULL,$page);
		
					//明細データ表示
					$bill[data][0] = Write_Claim_Data_M($pdf,$bill[data][0],$hikae_flg,"","",$db_con);
		
					//フッターを表示（取引銀行部分）
					Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
					$page++;
				}
			/****************************/
			//「親子関係なし」かつ「合計」
			/****************************/
			} elseif ($pattern == "2") {
				//ページ作成
				$pdf->AddPage();
	
				//ヘッダ部分表示
				Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,0,1,$xx,$yy);
	
				//合計金額表示
				Write_Claim_Total($pdf,$bill[head][0],$hikae_flg);
				
				//フッターを表示（取引銀行部分）
				Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
			/****************************/
			//「親子関係あり」かつ「明細」
			/****************************/
			} elseif ($pattern == "3") {
				//ページ作成
				$pdf->AddPage();
	
				//ヘッダ部分表示
				Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,2,1,$xx,$yy);
	
				//合計金額表示
				Write_Claim_Total($pdf,$bill[head][0],$hikae_flg);
	
				//フッターを表示（取引銀行部分）
				Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
	
				if (0) {
					echo "<pre>";
					print_r($bill_data);
					echo "</pre>";
				}
				
				$page = 2;
				//「親＋子」の数分の繰り返し
                foreach ($bill[head] AS $key => $var) {
				//for ($i=1; $i< count($bill[head]); $i++){

					while (count($bill[data][$key])) {

						//ページ作成
						$pdf->AddPage();

						//ヘッダ部分表示
						Write_Claim_Header($pdf,$bill[head][$key],$hikae_flg,1,$page,$xx,$yy);
						
						//合計金額を表示
						Write_Claim_Total($pdf,$bill[head][$key],$hikae_flg);
				
						//明細データ表示（表示しきれなかったデータを戻り値として取得）
						$bill[data][$key] = Write_Claim_Data_M($pdf,$bill[data][$key],$hikae_flg, "","", $db_con);

						//フッターを表示（取引銀行部分）
						Write_Claim_Footer($pdf,$bill[head][$key],$hikae_flg);	
						$page++;
					}
				}
			/****************************/
			//「親子関係あり」かつ「合計」
			/****************************/
			} elseif ($pattern == "4") {
			
				$bill[data] = $bill[head];  //請求書データ
				unset($bill[data][0]);      //全得意先合計は表示しないので削除
				
				$page = 1;
				while (count($bill[data])) {
					//ページ作成
					$pdf->AddPage();

					//ヘッダ部分表示
					Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,0,$page,$xx,$yy);
		
					//合計金額表示
					Write_Claim_Total($pdf,$bill[head][0],$hikae_flg,NULL,NULL,$page);
		
					//合計データ表示
					//Write_Claim_Data_G($pdf,$bill_id,$db_con);
//					$bill[data] = Write_Claim_Data_G($pdf,$bill[data],$hikae_flg);
    				$bill[data] = Write_Claim_Data_G($pdf,$bill[data],$hikae_flg,"","",$bill[head][0]);	

					//フッターを表示（取引銀行部分）
					Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
					$page++;
				}

            /****************************/
            //明細請求書
            /****************************/
            } elseif ($pattern == "5") {

                //表示形式にデータを修正
                $page_data = Make_Bill_Data($bill, $db_con);

                foreach($page_data AS $page => $var){
                    //ページ作成
                    $pdf->AddPage();

                    //ヘッダ部分表示
                    Write_Claim_Header($pdf,$var["head"],$hikae_flg,2,$page,$xx,$yy);

                    //合計金額表示
                    Write_Claim_Total($pdf,$var["head"],$hikae_flg,NULL,NULL,$page);

                    //データ表示
                    Write_Claim_Data_MG($pdf,$var,$hikae_flg, "","",$bill[head][0]);

                    //フッターを表示（取引銀行部分）
                    Write_Claim_Footer($pdf,$var["head"],$hikae_flg);
                }
			}
		}
	}else{
        $cnt++;
    }
}

//請求書を選択していない場合
if(count($claim_issue) == $cnt){
    echo "<b><font color=\"#ff0000\"><li>請求書を指定して下さい。</li></font></b>";
    exit;
}else{

    //控発行の場合は日付を残さない
    if($_POST["hdn_button"] == "前発行"){
    }else{
        //発行者を登録
        Update_Claim_Data ($db_con, $_POST["claim_issue"]);	
    }

    //$pdf->Error($pdf);
    //PDFの出力
    $pdf->Output();
}
?>
