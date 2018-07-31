<?php
require_once("ENV_local.php");
require_once(FPDF_DIR);
require_once(INCLUDE_DIR."2-2-307.php.inc");

$c_pattern_id = $_POST['pattern_select'];
if($c_pattern_id  == null){
    print "<font color=red><li>パターンを選択してください。</font>";
    exit;
}

$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);


//print_r($_POST);

//sql設定
$sql ="SELECT ";
$sql .="    c_memo1,";  //請求書コメント1
$sql .="    c_memo2,";  //請求書コメント2
$sql .="    c_memo3,";  //請求書コメント3
$sql .="    c_memo4,";  //請求書コメント4
$sql .="    c_fsize1,"; //請求書コメント1（文字サイズ）
$sql .="    c_fsize2,"; //請求書コメント2（文字サイズ）
$sql .="    c_fsize3,"; //請求書コメント3（文字サイズ）
$sql .="    c_fsize4,"; //請求書コメント4（文字サイズ）
$sql .="    c_memo5,";  //請求書コメント5
$sql .="    c_memo6,";  //請求書コメント6
$sql .="    c_memo7,";  //請求書コメント7
$sql .="    c_memo8,";  //請求書コメント8
$sql .="    c_memo9,";  //請求書コメント9
$sql .="    c_memo10,"; //請求書コメント10
$sql .="    c_memo11,"; //請求書コメント11
$sql .="    c_memo12,"; //請求書コメント12
$sql .="    c_memo13 "; //請求書コメント13
$sql .="FROM ";
$sql .="    t_claim_sheet "; //請求書設定テーブル
$sql .="WHERE ";
$sql .="    c_pattern_id = ".$c_pattern_id;  //印字パターンIDで検索
$sql .=";";

$rs = Db_Query($db_con,$sql);
$data = pg_fetch_array($rs,0);

//基準点
$xx = 10;
//$yy = 3;
$yy = 15;

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


//１ページの行数
$keta = 30;

/*
//社名配列設定
$bill = array($deta['c_memo1'],
            $deta['c_memo2'],
            $deta['c_memo3'],
            $deta['c_memo4']
        );

//社名欄のフォントサイズ設定
$c_fsize = array($deta['c_fsize1'],
                $deta['c_fsize2'],
                $deta['c_fsize3'],
                $deta['c_fsize4']
            );

//銀行名・メッセージ配列設定
$bank = array($deta['c_memo5'],
            $deta['c_memo6'],
            $deta['c_memo7'],
            $deta['c_memo8'],
            $deta['c_memo9'],
            $deta['c_memo10'],
            $deta['c_memo11'],
            $deta['c_memo12'],
            $deta['c_memo13']
        );
*/


//ページ作成

//PDF出力
$page=1;
for($i = 0; $i < 2; $i++){
    $pdf->AddPage();

    if($i == 0){
        $hikae_flg = 't';
    }else{
        $hikae_flg = 'f';
    }

    //ヘッダ部分表示
    Write_Claim_Header($pdf,$data,$hikae_flg,2,"",$xx,$yy);

    //合計金額表示
    Write_Claim_Total($pdf,$data,$hikae_flg,NULL,NULL,"");

    //明細データ表示
    Write_Claim_Data_M($pdf,array(null),$hikae_flg);

    //フッターを表示（取引銀行部分）
    Write_Claim_Footer($pdf,$data,$hikae_flg);

}

$pdf->Output();

?>

