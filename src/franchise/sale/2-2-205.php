<?php
/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * 一括入金リリース時に
 * 売掛残高抽出関数に
 * 一括入金の処理追加が必要です
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!/

/********************
 * 売上伝票
 *
 *
 * 変更履歴
 *    2006/07/19 (kaji)
 *      ・PDFをブラウザで開かないように。ファイル名を売上伝票＋日付で出力するように。
 *    2006/08/19 (kaji)
 *      ・手書伝票、自動で売上などで受注テーブルがないことがあるので売上確定後のSQLを変更
 *    2006/08/24 (kaji)
 *      ・伝票出力フラグ（slip_flg）をtrueにする処理を追加
 *    2006/09/02 (kaji) すずきに消されたため、再度
 *      ・自社プロフィールで登録した社印を表示
 *      ・得意先に伝票パターンが登録されていない場合にメッセージを表示して終了する
 *    2006/10/05 (kaji) 表示をいくつか変更
 *      ・取引区分を「掛」「現」
 *      ・ルートに担当者名
 *      ・取引区分が現金の場合は締日を表示しない
 *      ・印紙貼りスペースの大きさを大きく
 *    2006-10-30 ・サニタイジングを行わないように修正<suzuki>
 *    2006-11-01 ・納品書・領収書の備考欄に設定した値が表示されるように修正<suzuki>
 *               ・社印の位置変更<suzuki>
 *    2006-12-04 ・商品分類名・正式名称の抽出SQLを変更(suzuki-t)
 *
 ********************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/10      02-046      suzuki      担当者・委託先選択時に前月・翌月ボタン押すと、カレンダー表示期間を表示
 *
 *  2006-12-10      03-059      suzuki      取引区分が値引・返品のとき、金額をマイナス表示
 *                  03-060
 *  2007-02-02                  watanabe-k  ロゴの位置を変更
 *  2007/02/06      B0702-001   kajioka-h   売上が存在するかチェック追加
 *  2007/03/19                  watanabe-k  請求書を渡さない場合はオレンジで表示
 *  2007/04/02                  watanabe-k  複写できるように変更
 *  2007/04/05                  watanabe-k  出荷案内書を出力できるように修正
 *  2007/04/12      xx-xxx      kajioka-h   オンライン代行で報告中の伝票は出力しないようになっていたのをできるように変更
 *                  xx-xxx      kajioka-h   現金取引の伝票で、得意先に売掛残高があった場合に表示する未集金額をアメニティロゴの右に移動
 *  2007/04/13      要望20-4    kajioka-h   売掛残高で一括入金に対応
 *  2007/04/14                  morita-d    予定伝票発行から遷移した場合の、受注ID取得方法を変更
 *  2007/05/02                  morita-d    オフライン代行のお買上伝票は、ルートに代行先名を表示するように変更
 *  2007/05/14                  watanabe-k  集計日報から伝票発行できるように修正
 *  2007/06/10                  watanabe-k  直送先が選択されていた場合のみ出荷案内書を出力するように修正 
 *  2007/06/16                  watanabe-k　伝票印字しないのチェックを追加 
 *  2007/07/03                  watanabe-k　摘要欄に得意先名を表示 
 *  2007/07/05                  watanabe-k　個別コメントを納品書と領収書にも反映するように修正 
 *  2007/07/09                  watanabe-k　締日単位の得意先の場合は消費税、税込金額を表示しない。 
 *  2007/08/09                  watanabe-k　得意先名がクリアされないバグの修正 
 *  2009/09/16                  aoyama-n 　 値引商品及び取引区分が値引・返品の場合は赤字で表示
 *  2009/09/16                  aoyama-n 　 取引区分の表記変更（掛・現⇒掛・掛返・掛引・現・現返・現引）
 *  2009/09/21                  watanabe-k  伝票再発行時の処理を追加
 */

require_once("ENV_local.php");

//売掛残高取得関数
require_once(INCLUDE_DIR."function_monthly_renew.inc");


require(FPDF_DIR);
$pdf=new MBFPDF('P','pp','a4');
$pdf->SetProtection(array('print', 'copy'));
$pdf->AddMBFont(GOTHIC ,'SJIS');
$pdf->AddMBFont(MINCHO ,'SJIS');
$pdf->SetAutoPageBreak(false);

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$client_id  = $_SESSION[client_id];
$output_id_array = $_POST["output_id_array"];  //受注ID配列

if($_POST["sale_republish_flg"] == "true"){
    $check_num_array = $_POST["form_republish_check"];  //伝票チェック
}else{
    $check_num_array = $_POST["form_slip_check"];  //伝票チェック
}

$more_slip = $_POST["form_more_slip"];    //出荷案内書チェック
/****************************/
// 関数
/****************************/
// 前回の月次更新締日取得関数
function Monthly_Renew_Day($db_con){

    /*
        $conn           DB接続関数
    */

    // 最終更新日取得
    $sql  = "SELECT \n";
    $sql .= "   MAX(close_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_sys_renew \n";
    $sql .= "WHERE \n";
    $sql .= "   renew_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $renew_day = pg_fetch_result($res, 0);
    if ($renew_day != null){
        $ary_renew_day = explode("-", $renew_day);
        $renew_day = date("Y-m-d", mktime(0, 0, 0, $ary_renew_day[1] , $ary_renew_day[2], $ary_renew_day[0]));
    }else{
        // 更新が行われていない場合はシステム開始日を代入
        $renew_day = START_DAY;
    }

    // 日付を返す
    return $renew_day;

}


/****************************/
//受注ID取得処理
/****************************/
//伝票にチェックがある場合に行う
if($check_num_array != NULL){
    $aord_array = NULL;    //伝票出力受注ID配列
    while($check_num = each($check_num_array)){
        //この添字の受注IDを使用する
        $check = $check_num[0];
		if($check_num[1] == 1){
        	$aord_array[] = $output_id_array[$check];
//            $more_check_array[] = $more_slip[$check];
		}
    }
}

//予定伝票発行からきた場合（IDの取得方法が異なる）
if($_POST[src_module] == "予定伝票発行"){
    $aord_array = NULL;    //伝票出力受注ID配列

    if($_POST["hdn_button"] == "再発行"){
        $check_array = $_POST["form_re_slip_check"];  //伝票チェック
    }else{
        $check_array = $_POST["form_slip_check"];  //伝票チェック
    }
    
    foreach($check_array AS $key => $val){
        if($val != "f"){
            $aord_array[] = $val;
        }
    }
//集計日報からの遷移
}elseif($_POST[src_module] == "集計日報" || $_POST[src_module] == "代行集計表"){
    $aord_array = null;

    if($_POST["form_hdn_submit"] == "再発行"){
        $target = $_POST["form_reslip_check"];
    }else{
        $target = $_POST["form_slip_check"];
    }

    //伝票番号が選択されている場合
    if(count($target) > 0){

        foreach($target AS $key => $val){
            if($val != 'f'){
                $exp_aord_ary = explode(',',$val);
                foreach($exp_aord_ary AS $keys => $vals){
                    $aord_array[] = $vals;
                }
            }
        }
    }
}

//伝票枚数が０の場合はエラー画面
if(count($aord_array) == 0){
    //インスタンス生成
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "閉じる", "OnClick=\"window.close()\"");

    $page_title = "売上伝票";

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
        'message'       => "伝票を選択して下さい。",
    ));

    //テンプレートへ値を渡す
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
    exit;
}

/****************************/
//伝票パターンが登録されているか
/****************************/
$sql = "SELECT COUNT(s_pattern_id) FROM t_slip_sheet WHERE shop_id = $client_id;";
$result = Db_Query($db_con,$sql);

if(pg_fetch_result($result, 0, 0) == 0){
    print "<font color=\"red\"><b>";
    print "売上伝票の発行元が登録されていません。<br>";
    print "売上伝票設定で発行元を登録してください。";
    print "</b></font>";
    exit;
}

/****************************/
//得意先に伝票パターンが設定されているか
/****************************/
for($s=0;$s<count($aord_array);$s++){

    //伝票が削除されていないかチェック
    $sql  = "SELECT aord_id FROM t_aorder_h WHERE aord_id = ".$aord_array[$s]." \n";
    $sql .= "UNION \n";
    $sql .= "SELECT sale_id FROM t_sale_h WHERE sale_id = ".$aord_array[$s]." \n";
    $sql .= ";";
    $result = Db_Query($db_con,$sql);
    if(pg_num_rows($result) == 0){
        print "<font color=\"red\"><b>";
        print "指定した売上伝票は削除された可能性があります。<br>";
        print "再度売上伝票を指定してください。";
        print "</b></font>";
        exit;
    }

    //得意先に設定された伝票パターンを取得
    $sql  = "SELECT \n";
    $sql .= "    s_pattern_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id IN \n";
    $sql .= "        ( \n";
    $sql .= "            (SELECT client_id FROM t_sale_h WHERE sale_id = ".$aord_array[$s].") \n";
    $sql .= "        UNION \n";
    $sql .= "            (SELECT client_id FROM t_aorder_h WHERE aord_id = ".$aord_array[$s].") \n";
    $sql .= "        ) \n";
    $sql .= ";\n";

    $result = Db_Query($db_con,$sql);

    if(pg_fetch_result($result, 0, 0) == ""){
        print "<font color=\"red\"><b>";
        print "売上伝票の発行元が設定されていない得意先があります。<br>";
        print "得意先マスタで発行元を設定してください。";
        print "</b></font>";
        exit;
    }
}


//受注ID分伝票表示
for($s=0;$s<count($aord_array);$s++){

    //2006/08/24 (kaji) 伝票出力フラグ（slip_flg）をtrueにする処理を追加
    $sql = "UPDATE t_aorder_h SET slip_flg = true, slip_out_day=NOW() WHERE aord_id = ".$aord_array[$s]." AND slip_out_day IS NULL;";
    $result = Db_Query($db_con,$sql);
    $sql = "UPDATE t_sale_h SET slip_flg = true, slip_out_day=NOW() WHERE sale_id = ".$aord_array[$s]." AND slip_out_day IS NULL;";
    $result = Db_Query($db_con,$sql);

    $pdf->AddPage();

    /****************************/
    //受注・売上取得SQL
    /****************************/
    //受注ヘッダ 
    $sql  = "SELECT ";
    $sql .= "    t_aorder_h.client_cd1,";       // 0
    $sql .= "    t_aorder_h.client_cd2,";       // 1
    $sql .= "    t_aorder_h.client_name,";      // 2
    $sql .= "    t_aorder_h.client_name2,";     // 3
    $sql .= "    CASE t_aorder_h.trade_id ";    // 4
    //2006/10/05 (kaji) 取引区分を「掛」「現」に変更
    //$sql .= "     WHEN '11' THEN '掛売上' ";
    //$sql .= "     WHEN '61' THEN '現金売上' ";
    $sql .= "     WHEN '11' THEN '掛' ";
    $sql .= "     WHEN '61' THEN '現' ";
    $sql .= "    END,";
    $sql .= "    t_aorder_h.ord_time,";         // 5
    $sql .= "    t_client.close_day, ";         // 6
    $sql .= "    t_client.tel,";                // 7
    $sql .= "    t_aorder_h.net_amount,";       // 8
    $sql .= "    t_aorder_h.tax_amount,";       // 9
    $sql .= "    t_aorder_d.line,";             //10
    $sql .= "    t_aorder_d.goods_cd,";         //11
    $sql .= "    t_aorder_d.serv_name,";        //12
    //$sql .= "    t_aorder_d.g_product_name || ' ' || t_aorder_d.official_goods_name,"; 
    $sql .= "    t_aorder_d.official_goods_name,";  //13
    $sql .= "    t_aorder_d.goods_name,";       //14
    $sql .= "    t_aorder_d.num,";              //15
    $sql .= "    t_aorder_d.sale_price,";       //16
    $sql .= "    t_aorder_d.sale_amount,";      //17
    $sql .= "    t_aorder_h.ord_no,";           //18
    $sql .= "    t_aorder_d.serv_print_flg,";   //19
    $sql .= "    t_aorder_d.goods_print_flg,";  //20
    $sql .= "    t_aorder_d.set_flg, ";         //21
    $sql .= "    t_g_goods.g_goods_name, ";     //22
    $sql .= "    t_aorder_d.rgoods_name,";      //23
    $sql .= "    t_aorder_h.client_id, ";       //24
    $sql .= "    '(' || t_aorder_d.rgoods_num || ')', ";     //25 本体数量
    $sql .= "    t_client.compellation, ";      //26
    //2006/10/05 (kaji) ルートに表示する用の巡回担当者（メイン）取得
    $sql .= "    t_aorder_staff.staff_name, ";  //27

    //郵便番号、住所
    $sql .= "    '',";      //28
    $sql .= "    '',";      //29
    $sql .= "    '',";      //30
    $sql .= "    '',";      //31
    $sql .= "    '',";      //32
    $sql .= "    '',";      //33
    
    //代行情報
    $sql .= "    t_aorder_h.contract_div,";     //34
    $sql .= "    t_aorder_h.act_id,";           //35
    $sql .= "    t_aorder_h.act_name, ";        //36

    //直送先情報
    $sql .= "    t_aorder_h.direct_id, ";       //37
    $sql .= "    t_direct.direct_cd, ";         //38
    $sql .= "    t_aorder_h.direct_name, ";     //39
    $sql .= "    t_aorder_h.direct_name2, ";    //40
    $sql .= "    t_aorder_h.direct_cname, ";    //41
    $sql .= "    t_direct.post_no1 AS d_post_no1, ";    //42
    $sql .= "    t_direct.post_no2 AS d_post_no2, ";    //43
    $sql .= "    t_direct.address1 AS d_address1, ";    //44
    $sql .= "    t_direct.address2 AS d_address2, ";    //45
    $sql .= "    t_direct.address3 AS d_address3, ";    //46
    $sql .= "    t_direct.tel AS d_tel, ";      //47
    $sql .= "    t_direct.fax AS d_fax, ";       //48

    $sql .= "    t_client.client_slip1, ";      //49
    $sql .= "    t_client.client_slip2, ";      //50
    //aoyama-n 2009-09-16
    #$sql .= "    t_client.tax_div ";            //51　課税単位（１：締日単位　２：伝票単位）
    $sql .= "    t_client.tax_div, ";            //51　課税単位（１：締日単位　２：伝票単位）
    $sql .= "    t_goods.discount_flg ";         //52　値引フラグ


    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
    $sql .= "    INNER JOIN t_client ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "    LEFT JOIN t_direct ON t_aorder_h.direct_id = t_direct.direct_id ";
    $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
    $sql .= "    LEFT JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id ";
    $sql .= "    LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id ";
    $sql .= "        AND t_aorder_staff.staff_div = '0' ";
    $sql .= "WHERE ";
    //$sql .= "    t_aorder_h.ps_stat = '1' ";
    //$sql .= "AND ";
    $sql .= "    t_aorder_h.confirm_flg = 'f' ";
    $sql .= "AND ";
    $sql .= "    t_aorder_h.aord_id = ".$aord_array[$s];

    $sql .= " UNION ";

    //売上ヘッダ 
    $sql .= "SELECT ";
    $sql .= "    t_sale_h.client_cd1,";      //得意先CD1 0
    $sql .= "    t_sale_h.client_cd2,";      //得意先CD2 1
    $sql .= "    t_sale_h.client_name,";     //得意先名1 2
    $sql .= "    t_sale_h.client_name2,";    //得意先名2 3
    $sql .= "    CASE t_sale_h.trade_id ";   //取引区分  4
    //2006/10/05 (kaji) 取引区分を「掛」「現」に変更
    //$sql .= "     WHEN '11' THEN '掛売上' ";
    //$sql .= "     WHEN '13' THEN '掛返品' ";
    //$sql .= "     WHEN '14' THEN '掛値引' ";
    //$sql .= "     WHEN '61' THEN '現金売上' ";
    //$sql .= "     WHEN '63' THEN '現金返品' ";
    //$sql .= "     WHEN '64' THEN '現金値引' ";
    $sql .= "     WHEN '11' THEN '掛' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '13' THEN '掛' ";
    $sql .= "     WHEN '13' THEN '掛返' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '14' THEN '掛' ";
    $sql .= "     WHEN '14' THEN '掛引' ";
    $sql .= "     WHEN '15' THEN '掛' ";
    $sql .= "     WHEN '61' THEN '現' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '63' THEN '現' ";
    $sql .= "     WHEN '63' THEN '現返' ";
    //aoyama-n 2009-09-16
    #$sql .= "     WHEN '64' THEN '現' ";
    $sql .= "     WHEN '64' THEN '現引' ";
    $sql .= "    END,";
    $sql .= "    t_sale_h.sale_day,";        //売上日 5
    $sql .= "    t_client.close_day, ";      //締日   6
    $sql .= "    t_client.tel,";             //電話番号 7

    //$sql .= "    t_sale_h.net_amount,";      //売上金額合計 8
	$sql .= "    t_sale_h.net_amount \n";
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    //$sql .= "    t_sale_h.tax_amount,";      //消費税額 9
	$sql .= "    t_sale_h.tax_amount \n";         
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_d.line,";            //行 10
    $sql .= "    t_sale_d.goods_cd,";        //商品CD 11
    $sql .= "    t_sale_d.serv_name,";       //サービス名 12
    //$sql .= "    t_sale_d.g_product_name || ' ' || t_sale_d.official_goods_name,"; //正式名称(商品分類・商品名)
    $sql .= "    t_sale_d.official_goods_name,"; //正式名称(商品分類・商品名) 13
    $sql .= "    t_sale_d.goods_name,";      //略称 14
    $sql .= "    t_sale_d.num,";             //数量 15

    $sql .= "    t_sale_d.sale_price ";      //売上単価 16
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_d.sale_amount ";     //売上金額 17
	$sql .= "    * ";
	$sql .= "    CASE t_sale_h.trade_id";
	$sql .= "        WHEN 13 THEN -1";
	$sql .= "        WHEN 63 THEN -1";
	$sql .= "        WHEN 14 THEN -1";
	$sql .= "        WHEN 64 THEN -1";
	$sql .= "        ELSE 1";
	$sql .= "    END, ";

    $sql .= "    t_sale_h.sale_no,";         //売上番号 18
    $sql .= "    t_sale_d.serv_print_flg,";  //サービス印字 19
    $sql .= "    t_sale_d.goods_print_flg,"; //アイテム印字 20
    $sql .= "    t_sale_d.set_flg, ";        //一式フラグ 21
    $sql .= "    t_g_goods.g_goods_name,";   //Ｍ区分 22
    $sql .= "    t_sale_d.rgoods_name,";     //本体名 23
    $sql .= "    t_sale_h.client_id,";       //得意先ID 24
    $sql .= "    '(' || t_sale_d.rgoods_num || ')', ";     //本体数量 25
    $sql .= "    t_client.compellation, ";  //26
    //2006/10/05 (kaji) ルートに表示する用の巡回担当者（メイン）取得
    $sql .= "    t_sale_staff.staff_name, ";//27
    //郵便番号、住所
    $sql .= "    t_sale_h.c_post_no1,";     //28
    $sql .= "    t_sale_h.c_post_no2,";     //29
    $sql .= "    t_sale_h.c_address1,";     //30
    $sql .= "    t_sale_h.c_address2,";     //31
    $sql .= "    t_sale_h.c_address3, ";    //32
    $sql .= "    t_sale_d.unit, ";          //単位 33
    //代行情報
    $sql .= "    t_sale_h.contract_div,";   //34
    $sql .= "    t_sale_h.act_id,";         //35
    $sql .= "    t_sale_h.act_cname, ";     //36

    //直送先情報
    $sql .= "    t_sale_h.direct_id, ";     //37
    $sql .= "    t_sale_h.direct_cd, ";     //38
    $sql .= "    t_sale_h.direct_name, ";   //39
    $sql .= "    t_sale_h.direct_name2, ";  //40
    $sql .= "    t_sale_h.direct_cname, ";  //41
    $sql .= "    t_sale_h.d_post_no1, ";    //42
    $sql .= "    t_sale_h.d_post_no2, ";    //43
    $sql .= "    t_sale_h.d_address1, ";    //44
    $sql .= "    t_sale_h.d_address2, ";    //45
    $sql .= "    t_sale_h.d_address3, ";    //46
    $sql .= "    t_sale_h.d_tel, ";  //47
    $sql .= "    t_sale_h.d_fax,  ";  //48

    $sql .= "    t_client.client_slip1, ";      //49
    $sql .= "    t_client.client_slip2,  ";      //50
    //aoyama-n 2009-09-16
    #$sql .= "    t_client.tax_div ";            //51　課税単位（１：締日単位　２：伝票単位）
    $sql .= "    t_client.tax_div, ";            //51　課税単位（１：締日単位　２：伝票単位）
    $sql .= "    t_goods.discount_flg ";         //52　値引フラグ
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id ";
    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_sale_d.goods_id ";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
    $sql .= "    LEFT JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id ";
    $sql .= "    LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "        AND t_sale_staff.staff_div = '0' ";
    $sql .= "WHERE ";
    //(2006/08/19) kaji 手書伝票、自動で売上などで受注テーブルがないことがあるので以下コメントアウト
    //$sql .= "    t_sale_h.aord_id IS NOT NULL ";
    //$sql .= "AND ";
    $sql .= "    t_sale_h.sale_id = ".$aord_array[$s];

    $sql .= " ORDER BY ";
    $sql .= "    6,11;";

    $result = Db_Query($db_con,$sql);
    $data_list = Get_Data($result,2);


    // 前回の月次更新締日から本日までの売掛残高を取得
    $ar_balance_this    = Get_Balance($db_con, "sale", $data_list[0][24]);


    /****************************/
    //DB値設定
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_client.s_pattern_id, ";      //パターン
    $sql .= "    t_client.deliver_effect, ";    //コメントフラグ
    $sql .= "    t_client.deliver_note, ";      //コメント
    $sql .= "    t_client_info.cclient_shop ";  //担当支店ID
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id ";
    $sql .= "WHERE ";
    $sql .= "    t_client.client_id = ".$data_list[0][24]." ";
    $sql .= "; ";

    $result = Db_Query($db_con,$sql);
    $client_memo = Get_Data($result,2);

    $sql  = "SELECT ";
    $sql .= "    s_memo1, ";        //売上伝票コメント1 0
    $sql .= "    s_memo2, ";        //売上伝票コメント2 1
    $sql .= "    s_memo3, ";        //売上伝票コメント3 2
    $sql .= "    s_memo4, ";        //売上伝票コメント4 3
    $sql .= "    s_memo5, ";        //売上伝票コメント5 4
    $sql .= "    s_fsize1,";        //コメント1フォントサイズ 5
    $sql .= "    s_fsize2,";        //コメント2フォントサイズ 6
    $sql .= "    s_fsize3,";        //コメント3フォントサイズ 7
    $sql .= "    s_fsize4,";        //コメント4フォントサイズ 8
    $sql .= "    s_fsize5,";        //コメント5フォントサイズ 9
    $sql .= "    s_memo6, ";        //売上伝票コメント6 10
    $sql .= "    s_memo7, ";        //売上伝票コメント7 11 
    $sql .= "    s_memo8, ";        //売上伝票コメント8 12
    $sql .= "    s_memo9, ";        //売上伝票コメント9 13
    $sql .= "    bill_send_flg, ";  //請求書渡すフラグ 14
    $sql .= "    s_pattern_no ";    //パターンNO
    $sql .= "FROM ";
    $sql .= "    t_slip_sheet ";
    $sql .= "WHERE ";
    $sql .= "    s_pattern_id = ".$client_memo[0][0].";";
    $result = Db_Query($db_con,$sql);
    //DBの値を配列に保存
    $s_memo = Get_Data($result,2);

    //コメント欄優先判定（3:全体コメント有効はそのままtable参照）
    if($client_memo[0][1] == '1'){
        //コメント無効は、空を表示
        $s_memo[0][10] = NULL;
        $s_memo[0][12] = NULL;
        $s_memo[0][13] = NULL;
    }else if($client_memo[0][1] == '2'){
        //取引先に設定したコメント
        $s_memo[0][10] = $client_memo[0][2];
        $s_memo[0][12] = $client_memo[0][2];
        $s_memo[0][13] = $client_memo[0][2];
    }

    //請求書を渡すときが緑、渡さないときは、グレー
    //                                      じゃなくてオレンジ
    $bill_flg = $s_memo[0][14];

    //$photo = 'shain.png';   //社印のファイル名
    $photo = COMPANY_SEAL_DIR.$client_memo[0][3].".jpg";    //社印のファイル名（得意先の担当支店の）
    $photo_exists = file_exists($photo);                    //社印が存在するかフラグ

    
    /****************************/
    //ヘッダー値取得
    /****************************/
    $code = $data_list[0][0]."-".$data_list[0][1];     //お客様コードNo

    //伝票印字する場合
    if($data_list[0][49] != '1'){
        $client_name1 = $data_list[0][2];                  //得意先名1
    }else{
        $client_name1 = null;
    }

    //伝票印字する場合
    if($data_list[0][50] != '1'){
        $client_name2 = $data_list[0][3];                  //得意先名2
    }else{
        $client_name2 = null;
    }

    //敬称判定
    if($data_list[0][26] == 1){
        //御中
        $compell      = "御中";
    }else{
        //様
        $compell      = "様";
    }
    //敬称結合判定
    if($client_name2 != NULL){
        $client_name2 .= "　".$compell;
    }else{
        $client_name1 .= "　".$compell;
    }

    $trade_name   = $data_list[0][4];                  //取引区分
    $today        = $data_list[0][5];                  //配送日
    $close_day    = $data_list[0][6];                  //締日

    //2006/10/05 (kaji) 締日は掛の場合だけ（現金の場合は表示しない）
    //aoyama-n 2009-09-16
    #if($trade_name == "掛"){
    if($trade_name == "掛" || $trade_name == '掛返' || $trade_name == '掛引'){
        //日付形式変更
        if($close_day == "29"){
            //月末
            $close_day = "月末";
        }else{
            //１〜２８日
            $close_day = $close_day."日";
        }
    } else {
        $close_day = "";
    }

    $tel          = $data_list[0][7];                  //電話番号
    $slip         = $data_list[0][18];                 //伝票番号

    $route        = $data_list[0][27];                 //ルート（巡回担当者名（メイン））

    //お買上伝票のルート名
    //オフライン代行伝票の場合
    if($data_list[0][34] == "3"){
        $route_kaiage        = $data_list[0][36];                 //委託先名

    //通常orオンライン代行の場合
    }else{
        $route_kaiage        = $route;                 //ルート（巡回担当者名（メイン））
    }


    $sale_amount  = $data_list[0][8];            //売上金額合計
    //伝票に消費税を表示するフラグ
    $tax_disp_flg            = ($data_list[0][51] == '2')? true : false;
    if($tax_disp_flg === false){
        $tax_amount   = null;                       //消費税額
        $intax_amount = null;
        $tax_message1 = "-";
        $tax_message2 = "締日一括";
    }else{
        $tax_amount   = $data_list[0][9];        //消費税額
        $tax_message1 = null;
        $tax_message2 = null;
    }
    $intax_amount = $sale_amount + $tax_amount ;


    /****************************/
    //直送先情報
    /****************************/
    unset($direct);
    //直送先が選択されていた場合
    if($data_list[0][37] != null){

        //出荷案内書出力フラグをtrueにする
        $more_check_array[$s] = true;

        //直送先の情報をセット
        $direct["cd"]       = $data_list[0][38];

        $direct["name"]     = $data_list[0][39];
        $direct["name2"]    = $data_list[0][40];

        if($direct["name2"] != null){
            $direct["name2"] = $direct["name2"]."　御中";
        }else{
            $direct["name"]  = $direct["name"]."　御中";
        }

        $direct["cname"]    = $data_list[0][41];
        $direct["post_no1"] = $data_list[0][42];
        $direct["post_no2"] = $data_list[0][43];
        $direct["address1"] = $data_list[0][44];
        $direct["address2"] = $data_list[0][45];
        $direct["address3"] = $data_list[0][46];
        $direct["tel"]      = $data_list[0][47];
        $direct["fax"]      = $data_list[0][48];
        $direct["client_name"]  = $client_name1."　御中";
    }

    /****************************/
    //改ページ件数計算
    /****************************/
    $data_count = pg_num_rows($result);
    $page_count = $data_count / 5;
    $page_count = floor($page_count);
    $page_count2 = $data_count % 5;
    if($page_count2 != 0){
        $page_count++;
    }
    //各ヘッダの商品データ分表示
    for($page=1, $p=0 ;$page<=$page_count;$page++, $p++){
        //枝番を０埋め
        $branch_no = str_pad($page, 2, "0", STR_PAD_LEFT);
        $branch_no = "-".$branch_no;       //伝票番号

        //一ページ目は、既にヘッダ部分で作成しているから、ページを追加しない
        if($page != 1){
            $pdf->AddPage();
        }

        /****************************/
        //お買い上げ伝票描画処理
        /****************************/
        $left_margin=50;
        $posY=16;
        //線の太さ
        $pdf->SetLineWidth(0.8);
        //線の色
        $pdf->SetDrawColor(80,80,80);
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 7);
        //背景色
        $pdf->SetFillColor(221,221,221);
        //左上角丸(上)
        $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
        //テキストの色
        $pdf->SetTextColor(80,80,80); 
        //背景色
        $pdf->SetFillColor(255);
        //左上角丸(下)
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+15, $posY);
        $pdf->Cell(100, 8,"お客様コード　$code", '', '1', 'L','0');
        $pdf->SetXY($left_margin+490, $posY);
        $pdf->Cell(100, 8,"伝票番号　".$slip.$branch_no, '', '1', 'R','0');
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+10, $posY+10);
        $pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');
        //線の太さ
        $pdf->SetLineWidth(0.2);
        //テキストの色
        $pdf->SetTextColor(0,0,0); 
        //フォント設定
        $pdf->SetFont(GOTHIC,'B', 8);
        $pdf->SetXY($left_margin+10, $posY+23);
        $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
        $pdf->SetXY($left_margin+10, $posY+34);
        $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
        //背景色
        $pdf->SetFillColor(221,221,221);
        //テキストの色
        $pdf->SetTextColor(80,80,80); 

        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+45);
        $pdf->Cell(260, 12,'', '1', '0', 'C','0');
        $pdf->SetXY($left_margin+10.4, $posY+45);
        $pdf->Cell(22, 12,'取区', '0', '0', 'C','1');
        $pdf->Cell(52, 12,'配送年月日', '0', '0', 'C','1');
        $pdf->Cell(90, 12,'ルート', '0', '0', 'C','1');
        $pdf->Cell(25, 12,'締日', '0', '0', 'C','1');
        $pdf->Cell(70, 12,'電　話　番　号', '0', '0', 'C','1');
        
        //テキストの色
        $pdf->SetTextColor(0,0,0);
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+10.4, $posY+57);
        $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
        $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
        $pdf->Cell(90, 17.5, $route_kaiage, 'R', '0', 'L','0');
        $pdf->Cell(25, 17.5,$close_day, 'LR', '0', 'C','0');
        $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');

        //テキストの色
        $pdf->SetTextColor(80,80,80); 
        $pdf->SetFont(GOTHIC,'B', 11);
        $pdf->SetXY($left_margin+273, $posY+10);
        $pdf->Cell(110, 12,'お 買 上 伝 票 '.$s_memo[0][15].'', 'B', '1', 'C','0');

        //線の太さ
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont(GOTHIC,'', 6.5);
        $pdf->SetXY($left_margin+285, $posY+35);
        $pdf->Cell(10, 10,'受', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+285, $posY+47.5);
        $pdf->Cell(10, 10,'領', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+285, $posY+60);
        $pdf->Cell(10, 10,'印', '0', '1', 'C','0');

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);
        //線の太さ
        $pdf->SetLineWidth(0.2);
        //テキストの色
        $pdf->SetTextColor(0,0,0); 
        $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
        $pdf->SetXY($left_margin+415, $posY+11);
        $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
        $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
        $pdf->SetXY($left_margin+465, $posY+11);
        $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

        $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
        $pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
        $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
        $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
        $pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
        $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

        $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
        $pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
        $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(80,80,80);
        $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

        //テキストの色
        $pdf->SetTextColor(255); 
        //線の太さ
        $pdf->SetLineWidth(0.2);
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+80);
        $pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+50, $posY+80);
        $pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+306, $posY+80);
        $pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+338, $posY+80);
        $pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+390, $posY+80);
        $pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+80);
        $pdf->Cell(66, 10,'備　　　　　考', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+518, $posY+80);
        $pdf->Cell(66.7, 10,'預　　　　け', '0', '1', 'C','0');

        //テキストの色
        $pdf->SetTextColor(0,0,0); 

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

        //フォント設定
        $pdf->SetFont(GOTHIC,'', 7);
        //線の太さ
        $pdf->SetLineWidth(0.2);

        //商品データ行数描画
        $height = array('90','111','132','153','174');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //値引商品及び取引区分が値引・返品の場合は赤字で表示
            if($data_list[$x][52] === 't' || 
               $trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            //最後の行か判定
            if($x==($page*5)-1){
                //商品コード
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                }
                //サービス/アイテム名
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //名称判定
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //サービス・アイテム名(略称)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //サービス名のみ
                    $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //アイテム名のみ(正式名称)
                    $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                }

                //数量
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * 履歴：
                 *  日付            B票No.      担当者      内容
                 *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
				 *	2009/06/18		改修No.39	aizawa-m	5行目：数量の"一式"の出力を右寄りに変更
                 *
                 */
                //数量指定判定
                if($data_list[$x][21] == 't'){
                    //数量があるかつ、一式にチェックがある場合
					//-- 2009/06/18 改修No.39 "C"→"R"へ変更 
                    $pdf->Cell(32, 21,'一式', '1', '1', 'R','0');
                    //$pdf->Cell(32, 21,'一式', '1', '1', 'C','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //数量があるかつ一式にチェックがない
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                }

                //単価
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //単価指定判定
                if($data_list[$x][16] != NULL){
                    //形式変更
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                }

                //金額
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //金額指定判定
                if($data_list[$x][17] != NULL){
                    //形式変更
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                }

                //備考
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                //預け
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], "T",'L','0');


            }else{
                //商品コード
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                }
                //サービス/アイテム名
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //名称判定
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //サービス・アイテム名(略称)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //サービス名のみ
                    $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //アイテム名のみ(正式名称)
                    $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                }

                //数量
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * 履歴：
                 *  日付            B票No.      担当者      内容
                 *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
                 *
                 */
                //数量指定判定
                if($data_list[$x][21] == 't'){
                    //数量があるかつ、一式にチェックがある場合
                    $pdf->Cell(32, 21,'一式', 'LRT', '1', 'R','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //数量があるかつ一式にチェックがない
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                }

                //単価
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //単価指定判定
                if($data_list[$x][16] != NULL){
                    //形式変更
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                }

                //金額
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //金額指定判定
                if($data_list[$x][17] != NULL){
                    //形式変更
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                }

                //備考
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                //預け
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
            }
            $h++;
        }

        //aoyama-n 2009-09-16
        //合計欄のテキストの色
        if($trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引' ||
           $intax_amount < 0 ){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0);
        }

        //線の太さ
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+452, $posY+195, 66, 57, 5, 'FD',34);
        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+452, $posY+195);
        $pdf->Cell(66, 19,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+214);
        $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+233);
        $pdf->Cell(66, 19,'', 'T', '1', 'C','0');


        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
        //線の太さ
        $pdf->SetLineWidth(0.2);

        //税抜金額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+195);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //消費税額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+214);
        if($page==$page_count){

            if($tax_disp_flg === true){
                $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
            } 
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //合計金額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+233);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', '0', '1', 'R','0');
        }
        //テキストの色
        $pdf->SetTextColor(80,80,80); 
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6.5);
        $pdf->SetXY($left_margin+357, $posY+195);
        $pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+357, $posY+214);
        $pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+357, $posY+233);
        $pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

        //線の太さ
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

        //テキストの色
        $pdf->SetTextColor(0,0,0);

        //コメント
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+16, $posY+210);
        $pdf->MultiCell(254, 9,$s_memo[0][10], '0', '1', 'L','0');

        //テキストの色
        $pdf->SetTextColor(80,80,80); 

        //背景色
        $pdf->SetFillColor(221,221,221);
        $pdf->RoundedRect($left_margin+280, $posY+205,  56, 10, 3, 'FD',12);
        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+280, $posY+205);
        $pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

        $pdf->SetDrawColor(255);
        $pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+340, $posY+254);
        $pdf->Cell(250, 10,'毎度ありがとうございます。上記の通り納品致しますので御査収下さい。', '0', '1', 'R','0');

        $pdf->SetLineWidth(0.2);
        $pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
        $pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
        $pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
        $pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
        $pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
        $pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

        //線の色
        $pdf->SetDrawColor(42,42,42);
        $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
        $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

        $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
        $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
        $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
        $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

        // 未集金表示
        //aoyama-n 2009-09-16
        #if ($trade_name == "現" && $ar_balance_this != 0 && $ar_balance_this != null){
        if (($trade_name == '現' || $trade_name == '現返' || $trade_name == '現引') && 
            $ar_balance_this != 0 && $ar_balance_this != null){
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+50, $posY+265);
            $pdf->Cell(0, 10, number_format($ar_balance_this).'円が未集金となっております。', '0', '1', 'L','0');
        }

        //ロゴ
        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);

        $posY=325;
        
        //領収書表示判定
        //if($trade_name == '現金売上' || $trade_name == '現金返品' || $trade_name == '現金値引'){
        //aoyama-n 2009-09-16
        #if($trade_name == '現'){
        if($trade_name == '現' || $trade_name == '現返' || $trade_name == '現引'){
            /****************************/
            //領収書伝票描画処理
            /****************************/
            //線の太さ
            $pdf->SetLineWidth(0.8);
            //線の色
            $pdf->SetDrawColor(29,0,120);
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 9);
            //背景色
            $pdf->SetFillColor(200,230,255);
            //左上角丸(上)
            $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
            //テキストの色
            $pdf->SetTextColor(61,50,180); 
            //背景色
            $pdf->SetFillColor(255);

            //フォント設定
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+15, $posY);
            $pdf->Cell(100, 8,"お客様コード　$code", '', '1', 'L','0');
            $pdf->SetXY($left_margin+490, $posY);
            $pdf->Cell(100, 8,"伝票番号　".$slip.$branch_no, '', '1', 'R','0');

            //左上角丸(下)
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
            $pdf->SetXY($left_margin+10, $posY+10);
            $pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');
            //線の太さ
            $pdf->SetLineWidth(0.2);
            //テキストの色
            $pdf->SetTextColor(0,0,0); 
            //フォント設定
            $pdf->SetFont(GOTHIC,'B', 8);
            $pdf->SetXY($left_margin+10, $posY+23);
            $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
            $pdf->SetXY($left_margin+10, $posY+34);
            $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
            //テキストの色
            $pdf->SetTextColor(61,50,180); 
            //背景色
            $pdf->SetFillColor(200,230,255);
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+45);
            $pdf->Cell(260, 12,'', '1', '0', 'C','0');
            $pdf->SetXY($left_margin+10.4, $posY+45);
            $pdf->Cell(22, 12,'取区', '0', '0', 'C','1');
            $pdf->Cell(52, 12,'配送年月日', '0', '0', 'C','1');
            $pdf->Cell(90, 12,'ルート', '0', '0', 'C','1');
            $pdf->Cell(25, 12,'締日', '0', '0', 'C','1');
            $pdf->Cell(70, 12,'電　話　番　号', '0', '0', 'C','1');

            if($photo_exists){
                $pdf->Image($photo,$left_margin+455, $posY+25,52);
            }

            //テキストの色
            $pdf->SetTextColor(0,0,0); 
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+10.4, $posY+57);
            $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
            $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
            $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
            $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
            $pdf->Cell(74.4, 17.5,$tel, '0', '0', 'L','0');

            //テキストの色
            $pdf->SetTextColor(61,50,180); 
            $pdf->SetFont(GOTHIC,'B', 11);
            $pdf->SetXY($left_margin+273, $posY+10);
            $pdf->Cell(90, 12,'領　　収　　書', 'B', '1', 'C','0');


            $pdf->SetFont(GOTHIC,'', 8);
            $pdf->SetXY($left_margin+544, $posY+217);
            $pdf->Cell(10, 10,'印', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+544, $posY+250);
            $pdf->Cell(10, 10,'紙', '0', '1', 'C','0');

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont(GOTHIC,'B', 12);
            //テキストの色
            $pdf->SetTextColor(0,0,0); 
            $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
            $pdf->SetXY($left_margin+415, $posY+11);
            $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
            $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
            $pdf->SetXY($left_margin+465, $posY+11);
            $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

            $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
            $pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
            $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
            $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
            $pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
            $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

            $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
            $pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
            $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(29,0,120);
            $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

            //テキストの色
            $pdf->SetTextColor(255); 
            //線の太さ
            $pdf->SetLineWidth(0.2);
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+80);
            $pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+50, $posY+80);
            $pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+306, $posY+80);
            $pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+338, $posY+80);
            $pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+390, $posY+80);
            $pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+80);
            $pdf->Cell(66, 10,'備　　　　　考', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+518, $posY+80);
            $pdf->Cell(66.7, 10,'預　　　　け', '0', '1', 'C','0');

            //テキストの色
            $pdf->SetTextColor(0,0,0); 

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            //背景色
            $pdf->SetFillColor(200,230,255);
            $pdf->SetFont(GOTHIC,'', 7);

            //商品データ行数描画
            $height = array('90','111','132','153','174');
            $h=0;
            for($x=0+(($page-1)*5);$x<($page*5);$x++){

                //aoyama-n 2009-09-16
                //値引商品及び取引区分が値引・返品の場合は赤字で表示
                if($data_list[$x][52] === 't' || 
                   $trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引'){
                    $pdf->SetTextColor(255,0,16);
                }else{
                    $pdf->SetTextColor(0,0,0);
                }

                //最後の行か判定
                if($x==($page*5)-1){
                    //商品コード
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                    }
                    //サービス/アイテム名
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //名称判定
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //サービス・アイテム名(略称)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //サービス名のみ
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //アイテム名のみ(正式名称)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //数量
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    //数量指定判定
                    /*
                     * 履歴：
                     *  日付            B票No.      担当者      内容
                     *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
				 	 *	2009/06/18		改修No.39	aizawa-m	5行目：数量の"一式"の出力を右寄りに変更
                     *
                     */
                    if($data_list[$x][21] == 't'){
                        //数量があるかつ、一式にチェックがある場合
						//-- 2009/06/18 改修No.39 "C"→"R"へ変更 
                        $pdf->Cell(32, 21,number_format('一式'), '1', '1', 'R','0');
                        //$pdf->Cell(32, 21,'一式', '1', '1', 'C','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //数量があるかつ一式にチェックがない
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                    }

                    //単価
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //単価指定判定
                    if($data_list[$x][16] != NULL){
                        //形式変更
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                    }

                    //金額
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //金額指定判定
                    if($data_list[$x][17] != NULL){
                        //形式変更
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                    }

                    //備考
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                    //預け
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');


                }else{
                    //商品コード
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                    }
                    //サービス/アイテム名
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //名称判定
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //サービス・アイテム名(略称)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //サービス名のみ
                        $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //アイテム名のみ(正式名称)
                        $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                    }

                    //数量
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * 履歴：
                     *  日付            B票No.      担当者      内容
                     *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
                     *
                     */
                    //数量指定判定
                    if($data_list[$x][21] == 't'){
                        //数量があるかつ、一式にチェックがある場合
                        $pdf->Cell(32, 21,'一式', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //数量があるかつ一式にチェックがない
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }

                    //単価
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //単価指定判定
                    if($data_list[$x][16] != NULL){
                        //形式変更
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                    }

                    //金額
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //金額指定判定
                    if($data_list[$x][17] != NULL){
                        //形式変更
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                    }

                    //備考
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                    //預け
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
                }
                $h++;
            }

            //aoyama-n 2009-09-16
            //合計欄のテキストの色
            if($trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引' ||
               $intax_amount < 0 ){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0); 
            }

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+452, $posY+195,55, 57, 5, 'FD',34);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+452, $posY+195);
            $pdf->Cell(54.7, 19,'', '1', '2', 'C','0');
            $pdf->Cell(54.7, 19,$tax_message2, '1', '2', 'C','0');
            $pdf->Cell(54.7, 19,'', '', '1', 'C','0');

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
            //線の太さ
            $pdf->SetLineWidth(0.2);

            //税抜金額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+195);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //消費税額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+214);
            if($page==$page_count){
                if($tax_disp_flg === true){
                    $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
                }else{
                    $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
                } 
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //合計金額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+233);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', '0', '1', 'R','0');
            }
            //テキストの色
            $pdf->SetTextColor(61,50,180); 
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6.5);
            $pdf->SetXY($left_margin+357, $posY+195);
            $pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+357, $posY+214);
            $pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+357, $posY+233);
            $pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

            //線の太さ
            $pdf->SetLineWidth(0.8);
            $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

            //テキストの色
            $pdf->SetTextColor(0,0,0); 

			/*
			 * 履歴：
			 * 　日付　　　　B票No.　　　　担当者　　　内容　
			 * 　2006/11/01　02-033　　　　suzuki-t　　納品書・領収書の備考欄に設定した値が表示されるように修正
			 *
			*/
            //コメント
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+16, $posY+210);
            $pdf->MultiCell(254, 9,$s_memo[0][13], '0', '1', 'L','0');

            //テキストの色
            $pdf->SetTextColor(61,50,180); 

            //背景色
            $pdf->SetFillColor(200,230,255);
            $pdf->RoundedRect($left_margin+280, $posY+205, 56, 10, 3, 'FD',12);
            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+280, $posY+205);
            $pdf->Cell(56, 10,'領　収　印', '0', '1', 'C','0');
            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

            $pdf->SetDrawColor(255);
            $pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+337, $posY+254);
            $pdf->Cell(150, 10,'※領収印の無き物は', '0', '1', 'L','0');
            $pdf->SetXY($left_margin+353, $posY+265);
            $pdf->Cell(150, 10,'無効と致します。', '0', '1', 'L','0');

            $pdf->SetLineWidth(0.2);
            $pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
            $pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
            $pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
            $pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
            $pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
            $pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

            //線の色
            $pdf->SetDrawColor(42,42,42);
            $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
            $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

            $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
            $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
            $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
            $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

            //ロゴ
            $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);

            //印紙の枠描画
            $pdf->SetLineWidth(0.1);
            $left_margin = 548;
            $posY = 505;
            for($i=14;$i<86;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+20, $left_margin+$i+0.5, $posY+20);
            }
            for($i=20;$i<96;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }
            for($i=14;$i<86;$i=$i+1.2){
                $pdf->Line($left_margin+$i, $posY+96, $left_margin+$i+0.5, $posY+96);
            }
            $left_margin = 621;
            for($i=20;$i<96;$i=$i+1.2){
                $pdf->Line($left_margin+13, $posY+$i, $left_margin+13, $posY+$i+0.5);
            }   

        }else{

            /****************************/
            //請求書伝票描画処理
            /****************************/
            //線の太さ
            $pdf->SetLineWidth(0.8);

            //請求書を渡すときが緑、渡さないときは、グレー
            if($bill_flg == 't'){
                //渡す
                //線の色
                $line_color = array(46,140,46);
                //背景色
                $bg_color   = array(198,246,195);
            }else{
                //渡さない

/*
                //線の色
                $line_color = array(80,80,80);
                //背景色
                $bg_color   = array(221,221,221);
*/
                //線の色
                $line_color = array(255,153,0);
                //背景色
                $bg_color   = array(255,255,204);

            }

            $pdf->SetDrawColor($line_color[0],$line_color[1],$line_color[2]);
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            //フォント設定
            $pdf->SetFont(GOTHIC,'', 9);
            
            //左上角丸(上)
            $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);

                //テキストの色
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //背景色
            $pdf->SetFillColor(255);

            //フォント設定
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+15, $posY);
            $pdf->Cell(100, 8,"お客様コード　$code", '', '1', 'L','0');
            $pdf->SetXY($left_margin+490, $posY);
            $pdf->Cell(100, 8,"伝票番号　".$slip.$branch_no, '', '1', 'R','0');

            //左上角丸(下)
            $pdf->SetFont(GOTHIC,'', 9);
            $pdf->RoundedRect($left_margin+10, $posY+22, 260,53, 5, 'FD',34);
            $pdf->SetXY($left_margin+10, $posY+10);
            $pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');
            //線の太さ
            $pdf->SetLineWidth(0.2);
            //テキストの色
            $pdf->SetTextColor(0,0,0);
            //フォント設定
            $pdf->SetFont(GOTHIC,'B', 8);
            $pdf->SetXY($left_margin+10, $posY+23);
            $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
            $pdf->SetXY($left_margin+10, $posY+34);
            $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');

            //背景色
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            //テキストの色
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+45);
            $pdf->Cell(260, 12,'', '1', '0', 'C','0');
            $pdf->SetXY($left_margin+10.4, $posY+45);
            $pdf->Cell(22, 12,'取区', '0', '0', 'C','1');
            $pdf->Cell(52, 12,'配送年月日', '0', '0', 'C','1');
            $pdf->Cell(90, 12,'ルート', '0', '0', 'C','1');
            $pdf->Cell(25, 12,'締日', '0', '0', 'C','1');
            $pdf->Cell(70, 12,'電　話　番　号', '0', '0', 'C','1');

            if($photo_exists){
                $pdf->Image($photo,$left_margin+455, $posY+25,52);
            }

            //テキストの色
            $pdf->SetTextColor(0,0,0); 
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 7);
            $pdf->SetXY($left_margin+10.4, $posY+57);
            $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
            $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
            $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
            $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
            $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');
            
            //テキストの色
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            $pdf->SetFont(GOTHIC,'B', 11);
            $pdf->SetXY($left_margin+273, $posY+10);
            $pdf->Cell(90, 12,'請　　求　　書', 'B', '1', 'C','0');
            //線の太さ
            $pdf->SetLineWidth(0.8);
            $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont(GOTHIC,'', 6.5);
            $pdf->SetXY($left_margin+285, $posY+35);
            $pdf->Cell(10, 10,'受', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+285, $posY+47.5);
            $pdf->Cell(10, 10,'領', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+285, $posY+60);
            $pdf->Cell(10, 10,'印', '0', '1', 'C','0');

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetFont(GOTHIC,'B', 12);

            //テキストの色
            //$pdf->SetTextColor(80,80,80);
            $pdf->SetTextColor(0,0,0);

            $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
            $pdf->SetXY($left_margin+415, $posY+11);
            $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
            $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
            $pdf->SetXY($left_margin+465, $posY+11);
            $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

            $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
            $pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
            $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
            $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
            $pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
            $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

            $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
            $pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
            $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

            //線の太さ
            $pdf->SetLineWidth(0.8);

            //背景色
            $pdf->SetFillColor($line_color[0],$line_color[1],$line_color[2]);
            //線の色
            $pdf->SetDrawColor($line_color[0],$line_color[1],$line_color[2]);
            $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

            //テキストの色
            $pdf->SetTextColor(255); 

            //線の太さ
            $pdf->SetLineWidth(0.2);
            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6);
            $pdf->SetXY($left_margin+10, $posY+80);
            $pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+50, $posY+80);
            $pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+306, $posY+80);
            $pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+338, $posY+80);
            $pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+390, $posY+80);
            $pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+80);
            $pdf->Cell(66, 10,'備　　　　考', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+518, $posY+80);
            $pdf->Cell(66.7, 10,'預　　　　け', '0', '1', 'C','0');

            //テキストの色
            $pdf->SetTextColor(0,0,0);

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

            //線の太さ
            $pdf->SetLineWidth(0.2);

            //背景色
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            $pdf->SetFont(GOTHIC,'', 7);

            //商品データ行数描画
            $height = array('90','111','132','153','174');
            $h=0;
            for($x=0+(($page-1)*5);$x<($page*5);$x++){

                //aoyama-n 2009-09-16
                //値引商品及び取引区分が値引・返品の場合は赤字で表示
                if($data_list[$x][52] === 't' || 
                   $trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引'){
                    $pdf->SetTextColor(255,0,16);
                }else{
                    $pdf->SetTextColor(0,0,0);
                }

                //最後の行か判定
                if($x==($page*5)-1){
                    //商品コード
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                    }
                    //サービス/アイテム名
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //名称判定
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //サービス・アイテム名(略称)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //サービス名のみ
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //アイテム名のみ(正式名称)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //数量
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * 履歴：
                     *  日付            B票No.      担当者      内容
                     *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
				 	 *	2009/06/18		改修No.39	aizawa-m	5行目：数量の"一式"の出力を右寄りに変更
                     *
                     */
                    //数量指定判定
                    if($data_list[$x][21] == 't'){
                        //数量があるかつ、一式にチェックがある場合
						//-- 2009/06/18 改修No.39 "C"→"R"へ変更 
                        $pdf->Cell(32, 21,'一式', '1', '1', 'R','0');
                        //$pdf->Cell(32, 21,'一式', '1', '1', 'C','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //数量があるかつ一式にチェックがない
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                    }

                    //単価
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //単価指定判定
                    if($data_list[$x][16] != NULL){
                        //形式変更
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                    }

                    //金額
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //金額指定判定
                    if($data_list[$x][17] != NULL){
                        //形式変更
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                    }

                    //備考
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                    //預け
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');

                }else{
                    //商品コード
                    $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                    }else{
                        $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                    }
                    //サービス/アイテム名
                    $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                    //名称判定
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //サービス・アイテム名(略称)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //サービス名のみ
                        $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //アイテム名のみ(正式名称)
                        $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                    }

                    //数量
                    $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                    /*
                     * 履歴：
                     *  日付            B票No.      担当者      内容
                     *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
                     *
                     */
                    //数量指定判定
                    if($data_list[$x][21] == 't'){
                        //数量があるかつ、一式にチェックがある場合
                        $pdf->Cell(32, 21,'一式', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //数量があるかつ一式にチェックがない
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }

                    //単価
                    $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                    //単価指定判定
                    if($data_list[$x][16] != NULL){
                        //形式変更
                        $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                    }

                    //金額
                    $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                    //金額指定判定
                    if($data_list[$x][17] != NULL){
                        //形式変更
                        $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                    }

                    //備考
                    $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                    $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                    //預け
                    $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                    $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                    $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
                }
                $h++;
            }

            //aoyama-n 2009-09-16
            //合計欄のテキストの色
            if($trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引' ||
               $intax_amount < 0 ){
                $pdf->SetTextColor(255,0,16); 
            }else{
                $pdf->SetTextColor(0,0,0); 
            }

            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+452, $posY+195,66, 57, 5, 'FD',34);
            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+452, $posY+195);
            $pdf->Cell(66, 19,'', '1', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+214);
            $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
            $pdf->SetXY($left_margin+452, $posY+233);
            $pdf->Cell(66, 19,'', '', '1', 'C','0');


            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
            //線の太さ
            $pdf->SetLineWidth(0.2);

            //税抜金額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+195);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //消費税額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+214);
            if($page==$page_count){
                if($tax_disp_flg === true){
                    $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
                }else{
                    $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
                } 
            }else{
                $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
            }

            //合計金額
            //伝票が複数枚ある場合、最後のページに合計金額表示
            $pdf->SetXY($left_margin+390, $posY+233);
            if($page==$page_count){
                $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'', '0', '1', 'R','0');
            }

            //テキストの色
            $pdf->SetTextColor($line_color[0],$line_color[1],$line_color[2]);

            //フォント設定
            $pdf->SetFont(GOTHIC,'', 6.5);
            $pdf->SetXY($left_margin+357, $posY+195);
            $pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+357, $posY+214);
            $pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
            $pdf->SetXY($left_margin+357, $posY+233);
            $pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');

            $pdf->SetLineWidth(0.8);
            $pdf->SetFont(GOTHIC,'', 6.5);
            $pdf->SetXY($left_margin+11, $posY+200);
            $pdf->MultiCell(254, 9,$s_memo[0][11], '0', '1', 'L','0');

            //背景色
            $pdf->SetFillColor($bg_color[0],$bg_color[1],$bg_color[2]);

            $pdf->RoundedRect($left_margin+280,$posY+205 , 56, 10, 3, 'FD',12);
            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+280, $posY+205);
            $pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
            //線の太さ
            $pdf->SetLineWidth(0.8);
            //背景色
            $pdf->SetFillColor(255);
            $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

            $pdf->SetDrawColor(255);
            $pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

            //線の太さ
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+305, $posY+254);
            $pdf->Cell(230, 10,'毎度ありがとうございます。上記の通り請求致します。', '0', '1', 'R','0');

            $pdf->SetLineWidth(0.2);
            $pdf->Line($left_margin+50,$posY+81,$left_margin+50,$posY+89);
            $pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
            $pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
            $pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
            $pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
            $pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);
                
            //線の色
            $pdf->SetDrawColor($line_color[0], $line_color[1], $line_color[2]);
            $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
            $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);

            // 未集金表示
            //aoyama-n 2009-09-16
            #if ($trade_name == "現" && $ar_balance_this != 0 && $ar_balance_this != null){
            if (($trade_name == '現' || $trade_name == '現返' || $trade_name == '現引') && 
                $ar_balance_this != 0 && $ar_balance_this != null){
                $pdf->SetLineWidth(0.2);
                $pdf->SetXY($left_margin+50, $posY+265);
                $pdf->Cell(0, 10, number_format($ar_balance_this).'円が未集金となっております。', '0', '1', 'L','0');
            }

            //ロゴ
            $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);
            $pdf->Line($left_margin+32.4,$posY+45,$left_margin+32.4,$posY+75);
            $pdf->Line($left_margin+84.4,$posY+45,$left_margin+84.4,$posY+75);
            $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
            $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);
        }

        /****************************/
        //納品書伝票描画処理
        /****************************/
        $left_margin=50;
        $posY=635;

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //線の色
        $pdf->SetDrawColor(17,136,255);
        //背景色
        $pdf->SetFillColor(170,212,255);
        //左上角丸(上)
        $pdf->RoundedRect($left_margin+10, $posY+10, 260, 12, 5, 'FD',12);
        //テキストの色
        $pdf->SetTextColor(17,136,255);
        //背景色
        $pdf->SetFillColor(255);
        
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+15, $posY);
        $pdf->Cell(100, 8,"お客様コード　$code", '', '1', 'L','0');
        $pdf->SetXY($left_margin+490, $posY);
        $pdf->Cell(100, 8,"伝票番号　".$slip.$branch_no, '', '1', 'R','0');

        //左上角丸(下)
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 9);
        $pdf->RoundedRect($left_margin+10, $posY+22, 260, 53, 5, 'FD',34);
        $pdf->SetXY($left_margin+10, $posY+10);
        $pdf->Cell(260, 12,'御　　得　　意　　先　　名', 'B', '1', 'C','0');

        //線の太さ
        $pdf->SetLineWidth(0.2);
        //テキストの色
        $pdf->SetTextColor(0,0,0);
        //フォント設定
        $pdf->SetFont(GOTHIC,'B', 8);
        $pdf->SetXY($left_margin+10, $posY+23);
        $pdf->Cell(240, 9,$client_name1, '0', '1', 'L','0');
        $pdf->SetXY($left_margin+10, $posY+34);
        $pdf->Cell(240, 9,$client_name2, '0', '1', 'L','0');
        //テキストの色
        $pdf->SetTextColor(17,136,255);
        //背景色
        $pdf->SetFillColor(170,212,255);

        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+45);
        $pdf->Cell(260, 12,'', '1', '0', 'C','0');
        $pdf->SetXY($left_margin+10.4, $posY+45);
        $pdf->Cell(22, 12,'取区', '0', '0', 'C','1');
        $pdf->Cell(52, 12,'配送年月日', '0', '0', 'C','1');
        $pdf->Cell(90, 12,'ルート', '0', '0', 'C','1');
        $pdf->Cell(25, 12,'締日', '0', '0', 'C','1');
        $pdf->Cell(70, 12,'電　話　番　号', '0', '0', 'C','1');

        if($photo_exists){
            $pdf->Image($photo,$left_margin+455, $posY+25,52);
        }
        //テキストの色
        $pdf->SetTextColor(0,0,0); 
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 7);
        $pdf->SetXY($left_margin+10.4, $posY+57);
        $pdf->Cell(22, 17.5,$trade_name, 'R', '0', 'C','0');
        $pdf->Cell(52, 17.5,$today, 'R', '0', 'C','0');
        $pdf->Cell(90, 17.5, $route, 'R', '0', 'L','0');
        $pdf->Cell(25, 17.5,$close_day, 'C', '0', 'C','0');
        $pdf->Cell(70.4, 17.5,$tel, '0', '0', 'L','0');
        
        //テキストの色
        $pdf->SetTextColor(17,136,255);

        $pdf->SetFont(GOTHIC,'B', 11);
        $pdf->SetXY($left_margin+273, $posY+10);
        $pdf->Cell(90, 12,'納　　品　　書', 'B', '1', 'C','0');
        //線の太さ
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+285, $posY+30, 10, 45, 3, 'FD',14);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont(GOTHIC,'', 6.5);
        $pdf->SetXY($left_margin+285, $posY+35);
        $pdf->Cell(10, 10,'受', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+285, $posY+47.5);
        $pdf->Cell(10, 10,'領', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+285, $posY+60);
        $pdf->Cell(10, 10,'印', '0', '1', 'C','0');

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+295, $posY+30, 65, 45, 3, 'FD',23);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont(GOTHIC,'B', 12);

        //テキストの色
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
        $pdf->SetXY($left_margin+415, $posY+11);
        $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
        $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
        $pdf->SetXY($left_margin+465, $posY+11);
        $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

        $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
        $pdf->SetXY($left_margin+415, $posY+13+$s_memo[0][6]);
        $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
        $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
        $pdf->SetXY($left_margin+465, $posY+13+$s_memo[0][6]);
        $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

        $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
        $pdf->SetXY($left_margin+387, $posY+18+$s_memo[0][6]+$s_memo[0][8]);
        $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');


        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(17,136,255);
        $pdf->RoundedRect($left_margin+10, $posY+80, 575, 10, 5, 'FD',12);

        //テキストの色
        $pdf->SetTextColor(255); 
        //線の太さ
        $pdf->SetLineWidth(0.2);
        
        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+10, $posY+80);
        $pdf->Cell(40, 10,'商品コード', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+50, $posY+80);
        $pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+306, $posY+80);
        $pdf->Cell(32, 10,'数　　量', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+338, $posY+80);
        $pdf->Cell(52, 10,'単　　価', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+390, $posY+80);
        $pdf->Cell(62, 10,'金　　額', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+80);
        $pdf->Cell(66, 10,'備　　　　　考', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+518, $posY+80);
        $pdf->Cell(66.7, 10,'預　　　　け', '0', '1', 'C','0');

        //テキストの色
        $pdf->SetTextColor(0,0,0);

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+10, $posY+90, 575, 105, 5, 'FD',34);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        //背景色
        $pdf->SetFillColor(170,212,255);
        $pdf->SetFont(GOTHIC,'', 7);

        //商品データ行数描画
        $height = array('90','111','132','153','174');
        $h=0;
        for($x=0+(($page-1)*5);$x<($page*5);$x++){

            //aoyama-n 2009-09-16
            //値引商品及び取引区分が値引・返品の場合は赤字で表示
            if($data_list[$x][52] === 't' || 
               $trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引'){
                $pdf->SetTextColor(255,0,16);
            }else{
                $pdf->SetTextColor(0,0,0);
            }

            //最後の行か判定
            if($x==($page*5)-1){
                //商品コード
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'T', '1', 'L','0');  
                }
                //サービス/アイテム名
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //名称判定
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //サービス・アイテム名(略称)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //サービス名のみ
                    $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //アイテム名のみ(正式名称)
                    $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                }

                //数量
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * 履歴：
                 *  日付            B票No.      担当者      内容
                 *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
				 *	2009/06/18		改修No.39	aizawa-m	5行目：数量の"一式"の出力を右寄りに変更
                 *
                 */
                //数量指定判定
                if($data_list[$x][21] == 't'){
                    //数量があるかつ、一式にチェックがある場合
					//-- 2009/06/18 改修No.39 "C"→"R"へ変更
                    $pdf->Cell(32, 21,'一式', '1', '1', 'R','0');
                    //$pdf->Cell(32, 21,'一式', '1', '1', 'C','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //数量があるかつ一式にチェックがない
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), '1', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(32, 21,'', '1', '1', 'C','0');                              
                }

                //単価
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //単価指定判定
                if($data_list[$x][16] != NULL){
                    //形式変更
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LTB', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(54, 21,'', 'LTB', '1', 'R','0');
                }

                //金額
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //金額指定判定
                if($data_list[$x][17] != NULL){
                    //形式変更
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), '1', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(62, 21,'', '1', '1', 'R','0');
                }

                //備考
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', '1', '1', 'C','0');

                //預け
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'T','L','0');

            }else{
                //商品コード
                $pdf->SetXY($left_margin+10, $posY+$height[$h]);
                if ($data_list[$x][20] == 't'){
                    $pdf->Cell(40, 21,$data_list[$x][11], 'LRT', '1', 'L','0');  
                }else{
                    $pdf->Cell(40, 21,'', 'LRT', '1', 'L','0');  
                }
                //サービス/アイテム名
                $pdf->SetXY($left_margin+50, $posY+$height[$h]);
                //名称判定
                if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                    //サービス・アイテム名(略称)
                    $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                    //サービス名のみ
                    $pdf->Cell(256, 21,$data_list[$x][12], 'LRT', '1', 'L','0');
                }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                    //アイテム名のみ(正式名称)
                    $pdf->Cell(256, 21,$data_list[$x][13], 'LRT', '1', 'L','0');
                }else{
                    //NULL
                    $pdf->Cell(256, 21,'', 'LRT', '1', 'L','0');
                }

                //数量
                $pdf->SetXY($left_margin+306, $posY+$height[$h]);
                /*
                 * 履歴：
                 *  日付            B票No.      担当者      内容
                 *  2006/11/09      02-059      kajioka-h   一式あり、数量なしの場合に数量欄に「一式」と表示するように変更
                 *
                 */
                //数量指定判定
                if($data_list[$x][21] == 't'){
                    //数量があるかつ、一式にチェックがある場合
                    $pdf->Cell(32, 21,'一式', 'LRT', '1', 'R','0');
                }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                    //数量があるかつ一式にチェックがない
                    $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                }

                //単価
                $pdf->SetXY($left_margin+338, $posY+$height[$h]);
                //単価指定判定
                if($data_list[$x][16] != NULL){
                    //形式変更
                    $pdf->Cell(54, 21,number_format($data_list[$x][16],2), 'LT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(54, 21,'', 'LT', '1', 'R','0');
                }

                //金額
                $pdf->SetXY($left_margin+390, $posY+$height[$h]);
                //金額指定判定
                if($data_list[$x][17] != NULL){
                    //形式変更
                    $pdf->Cell(62, 21,number_format($data_list[$x][17]), 'LRT', '1', 'R','0');
                }else{
                    //空表示
                    $pdf->Cell(62, 21,'', 'LRT', '1', 'R','0');
                }

                //備考
                $pdf->SetXY($left_margin+452, $posY+$height[$h]);
                $pdf->Cell(66, 21,'', 'LRT', '1', 'C','0');

                //預け
                $pdf->SetXY($left_margin+518, $posY+$height[$h]);
                $data_list[$x][25] = str_pad($data_list[$x][25],15,' ',STR_POS_LEFT);
                $pdf->MultiCell(66.7,10,$data_list[$x][23]."\n".$data_list[$x][25], 'LRT','L','0');
            }
            $h++;
        }

        //aoyama-n 2009-09-16
        //合計欄のテキストの色
        if($trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引' ||
           $intax_amount < 0 ){
            $pdf->SetTextColor(255,0,16);
        }else{
            $pdf->SetTextColor(0,0,0); 
        }

        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+452, $posY+195,66, 57, 5, 'FD',34);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+452, $posY+195);
        $pdf->Cell(66, 19,'', '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+214);
        $pdf->Cell(66, 19,$tax_message2, '1', '1', 'C','0');
        $pdf->SetXY($left_margin+452, $posY+233);
        $pdf->Cell(66, 19,'', '', '1', 'C','0');


        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+390, $posY+195, 62, 57, 5, 'FD',34);
        //線の太さ
        $pdf->SetLineWidth(0.2);

        //税抜金額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+195);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($sale_amount), 'B', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //消費税額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+214);
        if($page==$page_count){
            if($tax_disp_flg === true){
                $pdf->Cell(62, 19,My_number_format($tax_amount), 'B', '1', 'R','0');
            }else{
                $pdf->Cell(62, 19,'-', 'B', '1', 'C','0');
            } 
        }else{
            $pdf->Cell(62, 19,'', 'B', '1', 'R','0');
        }

        //合計金額
        //伝票が複数枚ある場合、最後のページに合計金額表示
        $pdf->SetXY($left_margin+390, $posY+233);
        if($page==$page_count){
            $pdf->Cell(62, 19,number_format($intax_amount), '0', '1', 'R','0');
        }else{
            $pdf->Cell(62, 19,'', '0', '1', 'R','0');
        }

        //テキストの色
        $pdf->SetTextColor(17,136,255);

        //フォント設定
        $pdf->SetFont(GOTHIC,'', 6.5);
        $pdf->SetXY($left_margin+357, $posY+195);
        $pdf->Cell(30, 19,'小　計', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+357, $posY+214);
        $pdf->Cell(30, 19,'消費税', '0', '1', 'C','0');
        $pdf->SetXY($left_margin+357, $posY+233);
        $pdf->Cell(30, 19,'合　計', '0', '1', 'C','0');


        //線の太さ
        $pdf->SetLineWidth(0.8);
        $pdf->RoundedRect($left_margin+10, $posY+205, 260, 58, 5, 'FD',1234);

        //テキストの色
        $pdf->SetTextColor(0,0,0);


		/*
		 * 履歴：
		 * 　日付　　　　B票No.　　　　担当者　　　内容　
		 * 　2006/11/01　02-033　　　　suzuki-t　　納品書・領収書の備考欄に設定した値が表示されるように修正
		 *
		*/
        //コメント
        $pdf->SetFont(GOTHIC,'', 6);
        $pdf->SetXY($left_margin+16, $posY+210);
        $pdf->MultiCell(254, 9,$s_memo[0][12], '0', '1', 'L','0');

        //テキストの色
        $pdf->SetTextColor(17,136,255);

        //背景色
        $pdf->SetFillColor(170,212,255);
        $pdf->RoundedRect($left_margin+280, $posY+205, 56, 10, 3, 'FD',12);
        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+280, $posY+205);
        $pdf->Cell(56, 10,'担 当 者 名', '0', '1', 'C','0');
        //線の太さ
        $pdf->SetLineWidth(0.8);
        //背景色
        $pdf->SetFillColor(255);
        $pdf->RoundedRect($left_margin+280, $posY+215, 56, 48, 3, 'FD',34);

        $pdf->SetDrawColor(255);
        $pdf->Line($left_margin+10.81,$posY+22,$left_margin+269.17,$posY+22);

        //線の太さ
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($left_margin+340, $posY+254);
        $pdf->Cell(250, 10,'毎度ありがとうございます。上記の通り納品致しますので御査収下さい。', '0', '1', 'R','0');

        $pdf->SetLineWidth(0.2);
        $pdf->Line($left_margin+50, $posY+81,$left_margin+50,$posY+89);
        $pdf->Line($left_margin+306,$posY+81,$left_margin+306,$posY+89);
        $pdf->Line($left_margin+338,$posY+81,$left_margin+338,$posY+89);
        $pdf->Line($left_margin+390,$posY+81,$left_margin+390,$posY+89);
        $pdf->Line($left_margin+452,$posY+81,$left_margin+452,$posY+89);
        $pdf->Line($left_margin+518,$posY+81,$left_margin+518,$posY+89);

        //線の色
        $pdf->SetDrawColor(17,136,255);
        $pdf->Line($left_margin+10.81,$posY+45,$left_margin+269.17,$posY+45);
        $pdf->Line($left_margin+10.81,$posY+57,$left_margin+269.17,$posY+57);
        $pdf->Line($left_margin+32.4, $posY+45,$left_margin+32.4,$posY+75);
        $pdf->Line($left_margin+84.4, $posY+45,$left_margin+84.4,$posY+75);
        $pdf->Line($left_margin+174.4,$posY+45,$left_margin+174.4,$posY+75);
        $pdf->Line($left_margin+199.4,$posY+45,$left_margin+199.4,$posY+75);

        // 未集金表示
        //aoyama-n 2009-09-16
        #if ($trade_name == "現" && $ar_balance_this != 0 && $ar_balance_this != null){
        if (($trade_name == '現' || $trade_name == '現返' || $trade_name == '現引') && 
            $ar_balance_this != 0 && $ar_balance_this != null){
            $pdf->SetLineWidth(0.2);
            $pdf->SetXY($left_margin+50, $posY+265);
            $pdf->Cell(0, 10, number_format($ar_balance_this).'円が未集金となっております。', '0', '1', 'L','0');
        }

        //ロゴ
        $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+265,45,15);


        //出荷案内書
        if($more_check_array[$s] === true){
            $pdf->AddPage();

            //Y座標
            $ary_posY = array(11, 315, 625);

            //伝票名
            $slip_name = array("出　荷　案　内　書",
                                "出　荷　案　内　書（控）", 
                                "出　荷　指　示　書");

            //線の色
            $line_color = null;
            $line_color = array(array(238,0,14),
                                array(153,102,0),
                                array(129,53,255)
                            );

            //テキストの色
            $text_color = null;
            $text_color = array(array(255,0,16),
                                array(153,102,0),
                                array(129,53,255)
                            );

            //背景色
            $bg_color   = null;
            $bg_color   = array(array(255,204,207),
                                array(240,230,140),
                                array(238,227,255)
                            );

            for($i = 0; $i < 3; $i++){

                $left_margin=50;
                $posY= $ary_posY[$i];

                /****************************/
                //商品出荷案内書
                /****************************/
                //線の太さ
                $pdf->SetLineWidth(0.2);
                //線の色
                $pdf->SetDrawColor($line_color[$i][0],$line_color[$i][1],$line_color[$i][2]);
                //フォント設定
                $pdf->SetFont(GOTHIC,'', 9);
                //テキストの色
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);
                //背景色
                $pdf->SetFillColor($bg_color[$i][0],$bg_color[$i][1],$bg_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+10, $posY+10);
                $pdf->Cell(60, 12,'直送先コードNo.', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+70, $posY+10);
                $pdf->Cell(100, 12,$direct["cd"], '0', '1', 'L','0');

                //テキストの色
                $pdf->SetTextColor(0,0,0);

                //郵便番号
                $pdf->SetFont(GOTHIC,'', 9.5);
                $pdf->SetXY($left_margin+10, $posY+25);
                $pdf->Cell(15, 12,'〒', '0', '1', 'L','0');
                $pdf->SetXY($left_margin+25, $posY+25);
                $pdf->Cell(50, 12,$direct["post_no1"]."-".$direct["post_no2"], '0', '1', 'L','0');

                //住所・社名
                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+15, $posY+38);
                $pdf->Cell(50, 12,$direct["address1"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+15, $posY+50);
                $pdf->Cell(50, 12,$direct["address2"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+15, $posY+62);
                $pdf->Cell(50, 12,$direct["address3"], '0', '1', 'L','0');
                $pdf->SetFont(GOTHIC,'', 11);
                $pdf->SetXY($left_margin+20, $posY+77);
                $pdf->Cell(50, 12,$direct["name"], '0', '1', 'L','0');
                $pdf->SetXY($left_margin+20, $posY+92);
                $pdf->Cell(50, 12,$direct["name2"], '0', '1', 'L','0');

                //テキストの色
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 10);
                $pdf->SetXY($left_margin+214, $posY+5);
                $pdf->Cell(160, 15,$slip_name[$i], '1', '1', 'C','1');

                $pdf->SetFont(GOTHIC,'', 8);

                $sale_day = explode("-", $data_list[$p][5]);
                $pdf->SetXY($left_margin+392, $posY+7);
                $pdf->Cell(20, 12,$sale_day[0], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+412, $posY+7);
                $pdf->Cell(12, 12,'年', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+424, $posY+7);
                $pdf->Cell(12, 12,$sale_day[1], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+436, $posY+7);
                $pdf->Cell(12, 12,'月', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+448, $posY+7);
                $pdf->Cell(12, 12,$sale_day[2], '0', '1', 'C','0');
                $pdf->SetXY($left_margin+460, $posY+7);
                $pdf->Cell(12, 12,'日', '0', '1', 'C','0');
                $pdf->SetXY($left_margin+487, $posY+7);
                $pdf->Cell(33, 12,'伝票No.', '0', '1', 'R','0');
                $pdf->SetXY($left_margin+520, $posY+7);
                $pdf->Cell(50, 12,$slip.$branch_no, '0', '1', 'L','0');

                if($photo_exists){
                     $pdf->Image($photo,$left_margin+455, $posY+30,52);
                }

                //テキストの色
                //線の太さ
                $pdf->SetLineWidth(0.2);
                $pdf->SetFont(GOTHIC,'B', 12);
                //テキストの色
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont(GOTHIC,'B', $s_memo[0][5]);
                $pdf->SetXY($left_margin+415, $posY+19);
                $pdf->Cell(45, 15,$s_memo[0][0], '0', '1', 'L','0');
                $pdf->SetFont(GOTHIC,'B', $s_memo[0][6]);
                $pdf->SetXY($left_margin+465, $posY+19);
                $pdf->Cell(45, 15,$s_memo[0][1], '0', '1', 'L','0');

                $pdf->SetFont(MINCHO,'B', $s_memo[0][7]);
                $pdf->SetXY($left_margin+415, $posY+21+$s_memo[0][6]);
                $pdf->Cell(37,15,$s_memo[0][2], '0','1', 'L','0');
                $pdf->SetFont(MINCHO,'B', $s_memo[0][8]);
                $pdf->SetXY($left_margin+465, $posY+21+$s_memo[0][6]);
                $pdf->Cell(37,15,$s_memo[0][3], '0','1', 'L','0');

                $pdf->SetFont(GOTHIC,'', $s_memo[0][9]);
                $pdf->SetXY($left_margin+387, $posY+22+$s_memo[0][6]+$s_memo[0][8]);
                $pdf->MultiCell(254, 10,$s_memo[0][4], '0', '1', 'L','0');

                //テキストの色
                $pdf->SetTextColor($text_color[$i][0], $text_color[$i][1], $text_color[$i][2]);

                $pdf->SetFont(GOTHIC,'', 8);
                $pdf->SetXY($left_margin+332, $posY+90);
                $pdf->Cell(40, 12,'担当者 : ', '0', '1', 'C','0');

               //テキストの色
                $pdf->SetTextColor(0,0,0);

                $pdf->SetFont(GOTHIC,'', 10);
                $pdf->SetXY($left_margin+367, $posY+90);
                $pdf->Cell(188, 12,$route, 'B', '1', 'L','0');

                //テキストの色
                $pdf->SetTextColor($text_color[$i][0], $text_color[$i][1], $text_color[$i][2]); 
                $pdf->SetFont(GOTHIC,'', 7);
                $pdf->SetXY($left_margin+376, $posY+109);
                $pdf->Cell(150, 10,'毎度ありがとうございます。下記の通り出荷致しました。', '0', '1', 'R','0');

                //線の太さ
                $pdf->SetLineWidth(0.8);
                $pdf->RoundedRect($left_margin+10, $posY+120, 575, 115, 5, 'FD',1234);

                //フォント設定
                $pdf->SetLineWidth(0.2);
                $pdf->RoundedRect($left_margin+10, $posY+120, 575, 10, 5, 'FD',12);
                $pdf->SetXY($left_margin+10, $posY+120);
                $pdf->Cell(40, 10,'商品コード', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+50, $posY+120);
                $pdf->Cell(256, 10,'サ ー ビ ス　/　ア イ テ ム 名', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+306, $posY+120);
                $pdf->Cell(32, 10,'数　　量', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+338, $posY+120);
                $pdf->Cell(30, 10,'単　位', 'R', '1', 'C','0');
                $pdf->SetXY($left_margin+367, $posY+120);
                $pdf->Cell(220, 10,'備　　　　　　考', '0', '1', 'C','0');

                //テキストの色
                $pdf->SetTextColor(0,0,0);

                //背景色
                $pdf->SetFillColor(255);
                $pdf->RoundedRect($left_margin+10, $posY+130, 575, 105, 5, 'FD',34);
                $pdf->SetFont(GOTHIC,'', 8);
                //線の太さ
                $pdf->SetLineWidth(0.2);

                //商品データ行数描画
                $height = array('130','151','172','193','214');

                for($x=0+(($page-1)*5);$x<($page*5);$x++){

                    //aoyama-n 2009-09-16
                    //値引商品及び取引区分が値引・返品の場合は赤字で表示
                    if($data_list[$x][52] === 't' || 
                       $trade_name == '掛返' || $trade_name == '掛引' || $trade_name == '現返' || $trade_name == '現引'){
                        $pdf->SetTextColor(255,0,16);
                    }else{
                        $pdf->SetTextColor(0,0,0);
                    }

                    //商品コード
                    $pdf->SetXY($left_margin+10, $posY+$height[$x]);
                    if ($data_list[$x][20] == 't'){
                        $pdf->Cell(40, 21,$data_list[$x][11], 'T', '1', 'L','0');
                    }else{
                        $pdf->Cell(40, 21,'', 'T', '1', 'L','0');
                    }

                    //サービス/アイテム名
                    $pdf->SetXY($left_margin+50, $posY+$height[$x]);
                    //名称判定
                    if($data_list[$x][19] == 't' && $data_list[$x][20] == 't'){
                        //サービス・アイテム名(略称)
                        $pdf->Cell(256, 21,$data_list[$x][12]."/".$data_list[$x][14], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 't' && $data_list[$x][20] == 'f'){
                        //サービス名のみ
                        $pdf->Cell(256, 21,$data_list[$x][12], '1', '1', 'L','0');
                    }else if($data_list[$x][19] == 'f' && $data_list[$x][20] == 't'){
                        //アイテム名のみ(正式名称)
                        $pdf->Cell(256, 21,$data_list[$x][13], '1', '1', 'L','0');
                    }else{
                        //NULL
                        $pdf->Cell(256, 21,'', '1', '1', 'L','0');
                    }

                    //数量
                    $pdf->SetXY($left_margin+306, $posY+$height[$x]);
                    //数量指定判定
                    if($data_list[$x][21] == 't'){
                        //数量があるかつ、一式にチェックがある場合
                        $pdf->Cell(32, 21,'一式', 'LRT', '1', 'R','0');
                    }else if($data_list[$x][15] != NULL && $data_list[$x][21] == 'f'){
                        //数量があるかつ一式にチェックがない
                        $pdf->Cell(32, 21,number_format($data_list[$x][15]), 'LRT', '1', 'R','0');
                    }else{
                        //空表示
                        $pdf->Cell(32, 21,'', 'LRT', '1', 'R','0');                              
                    }
 
                    //単位
                    $pdf->SetXY($left_margin+338, $posY+$height[$x]);
                    $pdf->Cell(30, 21,$data_list[$x][33], '1', '1', 'C','0');
                }

                $pdf->SetFont(GOTHIC,'', 8);

                $pdf->SetXY($left_margin+47, $posY+247);

                //テキストの色
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);

                $pdf->Cell(40, 12,'摘 要', '0', '1', 'L','0');
                $pdf->SetTextColor(0,0,0);
                $pdf->SetXY($left_margin+75, $posY+247);
                $pdf->Cell(40, 12,$direct["client_name"], '0', '1', 'L','0');
                $pdf->SetTextColor($text_color[$i][0],$text_color[$i][1],$text_color[$i][2]);
                $pdf->Line($left_margin+78,$posY+259,$left_margin+255,$posY+259);

                $pdf->SetXY($left_margin+525, $posY+238);
                $pdf->Cell(33, 28,'', '1', '1', 'C','0');
                $pdf->SetXY($left_margin+558, $posY+238);
                $pdf->Cell(33, 28,'', '1', '1', 'C','0');

                //ロゴ
                $pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $posY+270,45,15);
            }
        }
    }
}

//$pdf->Output();
$pdf->Output(mb_convert_encoding("売上伝票".date("Ymd").".pdf", "SJIS", "EUC"),"D");
?>
