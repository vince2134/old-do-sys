<?php
/**
 * 集計日報（PDF）
 *
 *
 * 変更履歴
 *    2006/09/06 (kaji)
 *      ・削除伝票は付番の対象にしない
 *    2006/10/04 (kaji)
 *      ・直営以外はFC用の番号付番テーブルから伝票番号取得
 *    2006/11/02 (suzuki)
 *      ・既に削除された伝票の場合、エラー表示
 *
 */

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/12/16　scl-0088　　  watanabe-k　FCで代行伝票には採番処理が実行されないように修正
 * 　2007/01/25　        　　  watanabe-k　伝票を15枚表示するように修正
 * 　2007/01/25　        　　  watanabe-k　持参商品を8行4列に修正
 * 　2007/01/25　        　　  watanabe-k　印刷日を右下に表示
 * 　2007/01/25　        　　  watanabe-k　左側にファイリングスペースを表示
 * 　2007/01/26　        　　  ふ        　再印刷ボタン作成分岐が逆っぽかったのを修正
 * 　2007/01/30　        　　  watanabe-k　発行形式の選択機能の追加により修正
 * 　2007/02/07　       　　　 watanabe-k　直営以外の場合で代行伝票の場合抽出条件から漏れていたバグの修正
 * 　2007/03/12　       　　　 watanabe-k  合計表示を変更
 * 　2007/03/19　       　　　 watanabe-k  得意先名を2段に表示 
 * 　2007/03/22　       　　　 watanabe-k  削除伝票を表示しないように修正 
 * 　2007/03/23　       　　　 watanabe-k  契約マスタと同じソート 
 * 　2007/04/24　       　　　 watanabe-k  代行の金額を抽出するカラムを変更 
 * 　2007/05/03　       　　　 watanabe-k  順路でソート
 * 　2007/05/11　       　　　 watanabe-k  空の集計日報が出るように修正 
 * 　2007/05/14　       　　　 watanabe-k  発行日を残すように修正 
 * 　2007/05/15　       　　　 watanabe-k  発行IDを残すように表示 
 * 　2007/07/31　       　　　 watanabe-k  用紙に入りきらないためマージンを修正 
 * 　2007/09/18　       　　　 watanabe-k  伝票発行形式は受注ヘッダではなく得意先マスタを参照するように修正 
 * 　2008/05/31　       　　　 watanabe-k  出庫品リストに表示する商品は受注データを参照するように修正 
 * 　2008/07/19　       　　　 watanabe-k  アイテムと消耗品を別々に抽出するように修正
 */



require_once("ENV_local.php");
require_once(INCLUDE_DIR."daily_slip.inc"); //集計日報用関数

$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/***************************/
//外部変数取得
/***************************/
//セッション
$shop_id            = $_SESSION["client_id"];           //取引先ID
$group_kind         = $_SESSION["group_kind"];          //グループ種別

//POST
$send_day           = $_POST["hdn_send_day"];           //配送日
$staff_id           = $_POST["hdn_staff_id"];           //スタッフID1
$act_flg            = $_POST["hdn_act_flg"];            //代行区分
$daily_slip_id      = $_POST["hdn_daily_slip_id"];      //集計日報ID
$imp_slip_id        = $_POST["hdn_imp_slip_id"];      //集計日報ID
$button_value       = $_POST["form_hdn_submit"];      //ボタンvalue

//プレビュー出力フラグ
$no_data_flg        = ($_GET["format"] == "true")? true : false;

/***************************/
//エラーチェック
/***************************/
//集計日報一覧側で一つもチェックされていない場合はエラー
if($button_value == '集計日報発行'){
    $slipout_check      = $_POST["form_slipout_check"];

}elseif($button_value == '　再　発　行　'){
    $slipout_check      = $_POST["form_reslipout_check"];

}elseif($button_value == '付番前発行'){
    $slipout_check   = $_POST["form_preslipout_check"];
}

if(count($slipout_check) == 0 && $no_data_flg === false){
    $check_err = "伝票を選択して下さい。";
    $err_flg = true;
}

/***************************/
//受注番号発効
/***************************/
Db_Query($db_con, "BEGIN;");

$slipout_check_key  = @array_keys($slipout_check);      //集計日報印刷チェック
$re_print_flg = false;                                  //再印刷ボタン非表示フラグ

for($i = 0; $i < count($slipout_check); $i++){
    //選択された配送日の伝票に伝票番号を採番する
    //キーとなる受注IDを抽出

	//代行伝票
    if($act_flg[$slipout_check_key[$i]] == '○' && $group_kind == '2'){
        $sql  = "SELECT\n";
        $sql .= "   aord_id,\n";
        $sql .= "   ord_no, \n";
        $sql .= "   '', \n";
        $sql .= "   daily_slip_id ";
        $sql .= "FROM\n";
        $sql .= "    t_aorder_h\n";
        $sql .= "WHERE\n";
        $sql .= "   aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";
        $sql .= "   AND ";
        $sql .= "    del_flg = false \n";

        $sql .= "ORDER BY\n";
        $sql .= "    route,\n";
        $sql .= "    client_cd1,\n";
        $sql .= "    client_cd2, \n";
        $sql .= "    aord_id \n";

        $sql .= ";\n";

	//通常伝票
    }else{
        $sql  = "SELECT\n";
        $sql .= "   t_aorder_h.aord_id, \n";
        $sql .= "   t_aorder_h.ord_no, \n";
        $sql .= "   t_aorder_h.contract_div, \n";
        $sql .= "   daily_slip_id ";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_aorder_staff\n";
        $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]." \n";

        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON t_aorder_staff.staff_id = t_staff.staff_id\n";

        $sql .= "WHERE\n";

        $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].") ";

        $sql .= "   AND ";
        $sql .= "   del_flg = false ";

        //FC側で代行伝票に番号は振らない。
        $sql .= "    AND \n";
        $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().")" : " (shop_id = $shop_id OR act_id = $shop_id)\n";

        $sql .= "ORDER BY\n";
        $sql .= "   t_aorder_h.route,\n";
        $sql .= "   t_aorder_h.client_cd1,\n";
        $sql .= "   t_aorder_h.client_cd2, \n";
        $sql .= "   t_aorder_h.aord_id \n";
        $sql .= ";\n";
    }
    $res = Db_Query($db_con, $sql);
    $res_num = pg_num_rows($res);

	/*
	* 履歴：
	* 　日付　　　　B票No.　　　　担当者　　　内容　
	* 　2006/11/02　02-006　　　　suzuki-t　  削除された伝票の際にエラー表示
	*/
	//既に削除された伝票か判定
	if($res_num == 0){
	    $check_err = "該当の伝票が削除されています。";
	    $err_flg = true;
		Db_Query($db_con, "ROLLBACK;");
		$re_print_flg = true;//再印刷ボタン非表示フラグ
		break;
	}

    //集計日報発行ボタンが押下された場合のみ伝票番号を付番
    if($button_value == '集計日報発行'){

        //集計日報IDを抽出
        $max_id = Get_Daily_Slip_Id($db_con);

        //IDの取得に失敗した場合
        if($max_id === false){
            $err_flg = true;
            $duplicate_err = "集計日報の印刷が同時に行なわれたため、<br>伝票番号の付番に失敗しました。";
            $duplicate_flg = true;
        }

        for($j = 0; $j < $res_num; $j++){

            $aord_id = pg_fetch_result($res, $j,0);
            $aord_no = pg_fetch_result($res, $j,1);
            $contract_div = @pg_fetch_result($res, $j,2);

            //代行の場合は伝票番の付晩を行なわない
            if($group_kind != "2" && $contract_div == "2"){
                //PDFデータ抽出時にしよう
                $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
                continue;
            //伝票番号がない場合処理開始
            }elseif($aord_no == null){

                //PDFデータ抽出時にしよう
                $daily_slip_id[$slipout_check_key[$i]] = $max_id;

                //直営の場合
                //受注番号を抽出
                if($group_kind == '2'){
                    $sql  = "SELECT";
                    $sql .= "   MAX(ord_no) ";
                    $sql .= "FROM";
                    $sql .= "   t_aorder_no_serial";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);

                    $order_no = pg_fetch_result($result, 0 ,0);
                    $order_no = $order_no +1;
                    $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                    //受注番号登録処理
                    $sql  = "INSERT INTO t_aorder_no_serial (\n";
                    $sql .= "   ord_no\n";
                    $sql .= ")VALUES(\n";
                    $sql .= "   '$order_no'\n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);

                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_no_serial_pkey";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "集計日報の印刷が同時に行なわれたため、<br>伝票番号の付番に失敗しました。";
                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }
                //直営以外の場合は受注ヘッダから番号取得
                //ではなく、FC受注番号付番テーブルから番号取得(kaji)
                }else{
                    $sql  = "SELECT \n";
                    $sql .= "   MAX(ord_no) \n";
                    $sql .= "FROM \n";
                    $sql .= "   t_aorder_no_serial_fc \n";
                    $sql .= "WHERE \n";
                    $sql .= "   shop_id = $shop_id \n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);

                    $order_no = pg_fetch_result($result, 0 ,0);
                    $order_no = $order_no +1;
                    $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                    //受注番号登録処理
                    $sql  = "INSERT INTO t_aorder_no_serial_fc ( \n";
                    $sql .= "    ord_no, \n";
                    $sql .= "    shop_id \n";
                    $sql .= ") VALUES ( \n";
                    $sql .= "   '$order_no', \n";
                    $sql .= "    $shop_id \n";
                    $sql .= ");\n";

                    $result = Db_Query($db_con, $sql);

                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_no_serial_fc_pkey";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "集計日報の印刷が同時に行なわれたため、<br>伝票番号の付番に失敗しました。";
                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }
                }

                if($duplicate_flg != true){
                    //伝票番号に＋１した値を登録
                    $sql  = "UPDATE ";
                    $sql .= "   t_aorder_h ";
                    $sql .= "SET";
                    $sql .= "   ord_no = '$order_no', \n";
                    $sql .= "   daily_slip_out_day = NOW(), ";
                    $sql .= "   daily_slip_id = $max_id ";
                    $sql .= "WHERE\n";
                    $sql .= "   aord_id = $aord_id\n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    //同じ伝票で同時に採番処理が実行された場合エラー
                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_aorder_h_ord_no_key";
                        $err_flg = true;
                        Db_Query($db_con, "ROLLBACK;");

                        if(strstr($err_message, $err_format) != false){
                            $duplicate_err = "集計日報の印刷が同時に行なわれたため、<br>伝票番号の付番に失敗しました。";
                        }else{
                            exit;
                        }
                    }
                }
            }else{
                //PDFデータ抽出時にしよう
                $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
            }
        }
    //再発行ボタンが押下された場合
    }elseif($button_value == '　再　発　行　'){
        //再発行前に伝票が追加された場合エラーメッセージ表示
        for($j = 0; $j < $res_num; $j++){
            $aord_no = pg_fetch_result($res, $j,1);
            if($aord_no == null){
                $check_err = "伝票が新たに追加されたため、再度付番して下さい。";
	            $err_flg = true;
		        Db_Query($db_con, "ROLLBACK;");
		        $re_print_flg = true;           //再印刷ボタン非表示フラグ
                break;
            }
        }
    }else{
        for($j = 0; $j < $res_num; $j++){
            
            //PDFデータ抽出時にしよう
            $daily_slip_id[$slipout_check_key[$i]] = @pg_fetch_result($res, $j,3);
        }
    }
}
Db_Query($db_con, "COMMIT;");

//エラーフラグがtrueの場合
//（伝票番号が重複した場合
//対象となる集計日報が選択されていなかった場合）
//対象の伝票が削除された場合）
if($err_flg == true && $no_data_flg === false){
    //インスタンス生成
    $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

    $form->addElement("button","form_close_button", "閉じる", "OnClick=\"window.close()\"");
    //チェックした値を残す
    for($i = 0; $i < count($slipout_check); $i++){
        $form->addElement("hidden", "form_slipout_check[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_send_day[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_staff_id[$slipout_check_key[$i]]");
        $form->addElement("hidden", "hdn_act_flg[$slipout_check_key[$i]]");

        $set_data["form_slipout_check"][$slipout_check_key[$i]] = '1';
        $set_data["hdn_send_day"][$slipout_check_key[$i]] = $send_day[$slipout_check_key[$i]];
        $set_data["hdn_staff_id"][$slipout_check_key[$i]] = $staff_id[$slipout_check_key[$i]];
        $set_data["hdn_act_flg"][$slipout_check_key[$i]]  = $act_flg[$slipout_check_key[$i]];
    }
    $form->setConstants($set_data);

    /****************************/
    //HTMLヘッダ
    /****************************/
    $html_header = Html_Header($page_title);

    /****************************/
    //HTMLフッタ
    /****************************/
    $html_footer = Html_Footer();

    /****************************/
    //画面ヘッダー作成
    /****************************/
    // Render関連の設定
    $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
    $form->accept($renderer);

    //form関連の変数をassign
    $smarty->assign('form',$renderer->toArray());

    //その他の変数をassign
    $smarty->assign('var',array(
        'html_header'   => "$html_header",
        'html_footer'   => "$html_footer",
        'check_err'     => "$check_err",
        'duplicate_err' => "$duplicate_err",
    ));

    //テンプレートへ値を渡す
    $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
//エラーがない場合は帳票出力処理開始
}else{
    require(FPDF_DIR);

	//*******************入力箇所*********************
    if($no_data_flg === true){
        $roup_max = 1;
    }else{
        $roup_max = count($slipout_check);
    }        

    for($i = 0; $i < $roup_max; $i++){

        if($no_data_flg === false){

		    //表示用SQL作成
            //代行の場合
            if($act_flg[$slipout_check_key[$i]] == '○' && $group_kind == '2'){
                //代行先名と、日報NO抽出
                $sql  = "SELECT \n";
                $sql .= "   client_cname, \n";
                $sql .= "   client_cd1 || '-' || client_cd2 ";
                $sql .= "FROM \n";
                $sql .= "   t_client \n";
                $sql .= "WHERE \n";
                $sql .= "   client_id = ".$staff_id[$slipout_check_key[$i]]."\n";
                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);
                $header[$i][0] = "代行業者　：".pg_fetch_result($result,0,1);       //代行業者コード
                $header[$i][1] = pg_fetch_result($result,0,0);                      //代行業者名
                $header[$i][2] = $send_day[$slipout_check_key[$i]];
                $header[$i][3] = true;                                              //代行判別フラグ

                //集計日報用のデータを抽出
                $sql  = "SELECT \n";
                $sql .= "   t_aorder_h.ord_no,\n";
                $sql .= "   t_aorder_h.route, \n";
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
//                $sql .= "   t_aorder_h.trade_id, \n";
                $sql .= "   t_client.trade_id, \n";
                $sql .= "   t_aorder_h.net_amount, \n";
                $sql .= "   t_aorder_d.sale_amount,\n";                 //追加


                $sql .= "   t_aorder_h.tax_amount, \n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.tax_div, \n";
                $sql .= "   t_aorder_h.contract_div, \n";
//                $sql .= "   CASE t_aorder_h.slip_out \n";
                $sql .= "   CASE t_client.slip_out \n";
                $sql .= "       WHEN '1' THEN '' \n";
                $sql .= "       WHEN '2' THEN '指' \n";
                $sql .= "   END AS slip_out \n";

                $sql .= "FROM\n";
                $sql .= "    t_aorder_h\n";
                $sql .= "       INNER JOIN\n";
                $sql .= "    t_aorder_d\n";
                $sql .= "    ON t_aorder_d.aord_id = t_aorder_h.aord_id\n"; 
                $sql .= "       INNER JOIN\n";
                $sql .= "    t_client ";
                $sql .= "    ON t_aorder_h.client_id = t_client.client_id \n";
                $sql .= "WHERE\n";

/*
                $sql .= "    t_aorder_h.ord_time = '".$send_day[$slipout_check_key[$i]]."' \n";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.act_id = ".$staff_id[$slipout_check_key[$i]]." \n";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.del_flg = false \n";    //(2006/09/06) (kaji) 削除伝票は一覧に表示しない


                if($daily_slip_id[$slipout_check_key[$i]] != null){
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id = ".$daily_slip_id[$slipout_check_key[$i]]." ";
                }else{
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id IS NULL ";
                }
*/
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";

                $sql .= "ORDER BY\n";
                $sql .= "   t_aorder_h.route,\n";
                $sql .= "   t_aorder_h.client_cd1,\n";
                $sql .= "   t_aorder_h.client_cd2,\n";
                $sql .= "   ord_time,\n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.line \n";


                $sql .= ";\n";

            }else{
            //巡回担当者名と、日報NOを抽出
                $sql  = "SELECT\n";
                $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
                $sql .= "        ||\n";
                $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          // --日報No.
                $sql .= "   t_staff.staff_name,\n";                                             //--巡回担当者
                $sql .= "   LPAD( CAST(t_staff.charge_cd AS text), 4, '0') AS charge_cd\n";     //--スタッフコード（0埋め）
                $sql .= "FROM\n";
                $sql .= "   t_aorder_h\n";
                $sql .= "       INNER JOIN\n";
                $sql .= "   t_aorder_staff\n";
                $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
                $sql .= "   AND t_aorder_staff.staff_div = 0\n";                                //--メイン担当者
                $sql .= "       INNER JOIN\n";
                $sql .= "   t_staff ON  t_staff.staff_id = t_aorder_staff.staff_id\n";
                $sql .= "WHERE\n";


/*
                $sql .= "   t_aorder_h.ord_time = '".$send_day[$slipout_check_key[$i]]."'\n";
                $sql .= "   AND\n";
                $sql .= "   t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]."\n";

                //集計日報ID
                if($daily_slip_id[$slipout_check_key[$i]] != null){
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id = ".$daily_slip_id[$slipout_check_key[$i]]." ";
                }else{
                    $sql .= "    AND";
                    $sql .= "    daily_slip_id IS NULL ";
                }
*/
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";

                $sql .= ";\n";

                $result = Db_Query($db_con, $sql);
                $slip_no[$i] = pg_fetch_result($result, 0,0);       //日報NO

                $header[$i][0]  = "巡回担当者：".pg_fetch_Result($result, 0,2);         //巡回担当者コード
                $header[$i][1]  = pg_fetch_result($result, 0,1);                        //巡回担当者名
                $header[$i][2]  = $send_day[$slipout_check_key[$i]];                    //予定日
                $header[$i][3]  = false;                                                //代行判別フラグ

                //集計日報用のデータを抽出
                $sql  = "SELECT \n"; 
                $sql .= "   t_aorder_h.ord_no, \n";
                $sql .= "   t_aorder_h.route, \n";
                $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";
                $sql .= "   t_aorder_h.client_cname, \n";
                $sql .= "   (CASE \n";
                $sql .= "       WHEN t_aorder_d.goods_name IS NULL THEN t_aorder_d.serv_name \n";
                $sql .= "       WHEN t_aorder_d.goods_name = '' THEN t_aorder_d.serv_name \n";
                $sql .= "   ELSE t_aorder_d.goods_name \n";
                $sql .= "   END) AS goods_name, \n";
                $sql .= "   t_aorder_d.num, \n";
                $sql .= "   t_aorder_h.trade_id, \n";

                //直営の場合
                if($group_kind == "2"){
                    $sql .= "   t_aorder_d.sale_price, \n";
                    $sql .= "   t_aorder_h.net_amount, \n";
                    $sql .= "   t_aorder_d.sale_amount, \n";            //追加
                    $sql .= "   t_aorder_h.tax_amount, \n";
                }else{
                    //直営以外の場合
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_d.trust_cost_price ";
                    $sql .= "       ELSE t_aorder_d.sale_price ";
                    $sql .= "   END AS sale_price, \n";
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_d.trust_cost_amount ";
                    $sql .= "       ELSE t_aorder_d.sale_amount \n";
                    $sql .= "   END AS sale_amount, \n"; 
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_h.trust_net_amount ";
                    $sql .= "       ELSE t_aorder_h.net_amount \n";
                    $sql .= "   END AS net_amount, \n";
                    $sql .= "   CASE contract_div ";
                    $sql .= "       WHEN '2' THEN t_aorder_h.trust_tax_amount ";
                    $sql .= "       ELSE t_aorder_h.tax_amount ";
                    $sql .= "   END AS tax_amount, \n";
                }

                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.tax_div, \n";
                $sql .= "   t_aorder_h.contract_div, \n";
//                $sql .= "   CASE t_aorder_h.slip_out \n";
                $sql .= "   CASE t_client.slip_out \n";
                $sql .= "       WHEN '1' THEN '' \n";
                $sql .= "       WHEN '2' THEN '指' \n";
                $sql .= "   END AS slip_out \n";
                $sql .= "FROM\n";
                $sql .= "   t_aorder_h \n";
                $sql .= "       INNER JOIN \n";
                $sql .= "   t_aorder_d \n";
                $sql .= "   ON t_aorder_d.aord_id = t_aorder_h.aord_id \n";
                $sql .= "       INNER JOIN \n";
                $sql .= "   t_aorder_staff \n";
                $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
                $sql .= "   AND t_aorder_staff.staff_div = 0 \n";
                $sql .= "   AND t_aorder_staff.staff_id = ".$staff_id[$slipout_check_key[$i]]." \n";

                $sql .= "       INNER JOIN\n";
                $sql .= "   t_staff\n";
                $sql .= "   ON t_aorder_staff.staff_id = t_staff.staff_id\n";

                $sql .= "       INNER JOIN \n";
                $sql .= "   t_client \n";
                $sql .= "   ON t_aorder_h.client_id = t_client.client_id \n";


                $sql .= "WHERE\n";
                $sql .= "   t_aorder_h.aord_id IN (".$imp_slip_id[$slipout_check_key[$i]].")";
                $sql .= "    AND\n";
                $sql .= "    t_aorder_h.del_flg = false \n";

                $sql .= "ORDER BY \n";
                $sql .= "   t_aorder_h.route, \n";
                $sql .= "   t_aorder_h.client_cd1, \n";
                $sql .= "   t_aorder_h.client_cd2, \n";
                $sql .= "   t_staff.charge_cd,\n";
                $sql .= "   t_aorder_h.ord_time, \n";
                $sql .= "   t_aorder_h.aord_id, \n";
                $sql .= "   t_aorder_d.line \n";
                $sql .= ";\n";
            }

            $result   = Db_Query($db_con, $sql);
            $data_num = pg_num_rows($result);

            //伝票枚数分ループ        
            for($j = 0; $j < $data_num; $j++){
                $db_data[$j] = @pg_fetch_array($result, $j);
                //抽出したデータを伝票ごとに纏める
                //if($db_data[$j]["ord_no"] != $db_data[$j-1]["ord_no"] || $j == 0){
                if($db_data[$j]["aord_id"] != $db_data[$j-1]["aord_id"] || $j == 0){
                    $slip_data[$i][$j]["no"]             = $db_data[$j]["ord_no"];           //伝票番号
                    $slip_data[$i][$j]["client_cd"]      = $db_data[$j]["client_cd"];        //得意先コード

                    //得意先名が15文字以上の場合は2段に分ける
                    if(mb_strlen($db_data[$j]["client_cname"]) > 15){
                        $slip_data[$i][$j]["client"]     = mb_substr($db_data[$j]["client_cname"],0,15);
                        $slip_data[$i][$j]["client2"]    = mb_substr($db_data[$j]["client_cname"],15);
                    }else{
                        $slip_data[$i][$j]["client"]     = $db_data[$j]["client_cname"];     //得意先名
                    }

                    $slip_data[$i][$j]["trade"]          = $db_data[$j]["trade_id"];         //取引区分
                    $slip_data[$i][$j]["slip_out"]       = $db_data[$j]["slip_out"];         //伝票発行

                    $slip_data[$i][$j]["contract_div"]   = $contract_div = $db_data[$j]["contract_div"];     //契約区分
                    $net_amount = $db_data[$j]["net_amount"];

                    //掛の場合
                    if($db_data[$j]["trade_id"] < 20 ){
                        $slip_data[$i][$j]["net_ins"]    = $net_amount;   //金額（掛）
                    //現金の場合
                    }else{
                        $slip_data[$i][$j]["net_money"]  = $net_amount;   //金額（現金）
                    }

                    $slip_data[$i][$j]["tax"]            = $db_data[$j]["tax_amount"];       //消費税
                    $slip_data[$i][$j]["ord_id"]         = $db_data[$j]["aord_id"];           //伝票番号

                    //キーとなる値(行番号)
                    $mst = $j;
                }

                //一伝票の商品が５個を超えた場合
                if(count($slip_data[$i][$mst]["goods"]) >= 5){
                    $mst = $mst+1;
                    $slip_data[$i][$mst]["no"]           = "";                              //伝票番号
                    $slip_data[$i][$mst]["client_cd"]    = "";                              //得意先コード
                    $slip_data[$i][$mst]["client"]       = "";                              //得意先名
                    $slip_data[$i][$mst]["client2"]      = "";                              //得意先名
                    $slip_data[$i][$mst]["trade"]        = "";                              //取引区分
                    $slip_data[$i][$mst]["net_ins"]      = "";                              //金額
                    $slip_data[$i][$mst]["net_money"]    = "";                              //金額
                    $slip_data[$i][$mst]["tax"]          = "";                              //消費税
                    $slip_data[$i][$mst]["ord_id"]       = "";                              //伝票ID
                    $slip_data[$i][$mst]["contract_div"] = "";                              //契約区分
//                $slip_data[$i][$mst]["goods"][]      = $db_data[$j]["goods_name"];      //商品名
                    $slip_data[$i][$mst]["num"][]        = $db_data[$j]["num"];             //数量
    
                    $slip_data[$i][$mst]["price"][]      = $db_data[$j]["sale_price"];      //単価
                    $slip_data[$i][$mst]["sale_amount"][]= $db_data[$j]["sale_amount"];     //金額
                    $slip_data[$i][$mst]["tax_div"][]    = $db_data[$j]["tax_div"];         //課税区分
                
                }else{
                    $slip_data[$i][$mst]["goods"][]      = $db_data[$j]["goods_name"];      //商品名
                    $slip_data[$i][$mst]["num"][]        = $db_data[$j]["num"];             //数量
                    $slip_data[$i][$mst]["price"][]      = $db_data[$j]["sale_price"];      //単価
                    $slip_data[$i][$mst]["sale_amount"][]= $db_data[$j]["sale_amount"];     //金額

                    $slip_data[$i][$mst]["tax_div"][]    = $db_data[$j]["tax_div"];         //課税区分
                }
            }

            //配列の添え字を0から連番にする。
            $slip_data[$i] = @array_values($slip_data[$i]);
            $count = 0;     //商品数カウンタ
            for($j = 0; $j < count($slip_data[$i]); $j++){

                if($slip_data[$i][$j]["no"] != ""){
                    $count  = count($slip_data[$i][$j]["goods"]);
                    //伝票番号を記憶
                    $err_no = $slip_data[$i][$j]["no"];
                }else{
                    $count = $count+ count($slip_data[$i][$j]["goods"]);
                }
            }

            //上記で作成した、伝票単位のデータを、出力する形式に編集
            //商品数
            $count = 0;
            //ページ数
            $page = 0;

            //行数
            $s = 0;

            for($j = 0; $j < count($slip_data[$i]); $j++){
                //商品数を数える
                $count = $count + count($slip_data[$i][$j]["goods"]);

                //商品数が70を超える場合
                //　OR
                //行数が１４を超える場合ページ分け
                if(($j%15*($page+1) == 0) && $j != 0){
                    $page = $page + 1;  //ページ数を＋１
                    $s = 0;             //行数を初期化
                }

                $page_data[$i][$page][$s] = $slip_data[$i][$j];
    
                //ページ合計
                $page_ins_amount[$i][$page]   = $page_ins_amount[$i][$page]  + $page_data[$i][$page][$s]["net_ins"];
                $page_money_amount[$i][$page] = $page_money_amount[$i][$page]  + $page_data[$i][$page][$s]["net_money"];

                //現金税込合計
                if($page_data[$i][$page][$s]["net_ins"] != null){
                    $page_ins_tax_amount[$i][$page]   = $page_ins_tax_amount[$i][$page] + $page_data[$i][$page][$s]["net_ins"] + $page_data[$i][$page][$s]["tax"];
                //売上金額税込合計
                }elseif($page_data[$i][$page][$s]["net_money"] != null){
                    $page_money_tax_amount[$i][$page] = $page_money_tax_amount[$i][$page] + $page_data[$i][$page][$s]["net_money"] + $page_data[$i][$page][$s]["tax"];
                }
            
                $page_tax_amount[$i][$page]   = $page_tax_amount[$i][$page]  + $page_data[$i][$page][$s]["tax"];

                //集計日報合計
                $total_ins_amount[$i]         = $total_ins_amount[$i]   + $page_data[$i][$page][$s]["net_ins"];
                $total_money_amount[$i]       = $total_money_amount[$i] + $page_data[$i][$page][$s]["net_money"];
                $total_tax_amount[$i]         = $total_tax_amount[$i]   + $page_data[$i][$page][$s]["tax"];
            
                //現金税込合計
                if($page_data[$i][$page][$s]["net_ins"] != null){
                    $total_ins_tax_amount[$i]     = $total_ins_tax_amount[$i] + $page_data[$i][$page][$s]["net_ins"] + $page_data[$i][$page][$s]["tax"];
                //売上金額税込合計
                }elseif($page_data[$i][$page][$s]["net_money"] != null){
                    $total_money_tax_amount[$i]   = $total_money_tax_amount[$i] + $page_data[$i][$page][$s]["net_money"] + $page_data[$i][$page][$s]["tax"];
                }
                //行数を＋１
                $s = $s + 1;
            }

            //商品数の合計を求める
            //ページ数分ループ
            for($j = 0; $j < count($page_data[$i]); $j++){
                $in_aord_id = null;
                //行数分ループ
                for($r = 0; $r < count($page_data[$i][$j]); $r++){
                    //伝票番号表示行の場合
                    if($page_data[$i][$j][$r]["ord_id"]){
                        $in_aord_id[] = $page_data[$i][$j][$r]["ord_id"];
                    }
                }
                $ary_in_aord_id = implode(",", $in_aord_id);
 
                //商品合計SQL
				//--消耗品抽出用
                $sql2  = "(SELECT  ";
                $sql2 .= " t_aorder_d.egoods_name AS goods_name, ";
                $sql2 .= "  sum(t_aorder_ship.num) AS sum ";
                $sql2 .= "FROM ";
                $sql2 .= "  t_aorder_d ";
                $sql2 .= "      INNER JOIN ";
                $sql2 .= "  t_aorder_ship ";
                $sql2 .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
                $sql2 .= "  AND t_aorder_d.aord_id IN ($ary_in_aord_id) ";
                $sql2 .= "  AND t_aorder_d.egoods_id = t_aorder_ship.goods_id ";
                $sql2 .= "GROUP BY ";
                $sql2 .= "  t_aorder_ship.goods_cd, ";
                $sql2 .= "  t_aorder_d.egoods_name ";
                $sql2 .= "ORDER BY ";
                $sql2 .= "  t_aorder_ship.goods_cd  ";
                $sql2 .= ") ";
                $sql2 .= "UNION  ";
				//--アイテム抽出用
                $sql2 .= "(SELECT  ";
                $sql2 .= "  t_aorder_d.goods_name, ";
                $sql2 .= "  sum(t_aorder_ship.num) AS sum ";
                $sql2 .= "FROM ";
                $sql2 .= "  t_aorder_d ";
                $sql2 .= "      INNER JOIN ";
                $sql2 .= "  t_aorder_ship ";
                $sql2 .= "  ON t_aorder_d.aord_d_id = t_aorder_ship.aord_d_id  ";
                $sql2 .= "  AND t_aorder_d.aord_id IN ($ary_in_aord_id) ";
                $sql2 .= "  AND t_aorder_d.goods_id = t_aorder_ship.goods_id ";
                $sql2 .= "GROUP BY ";
                $sql2 .= "  t_aorder_ship.goods_cd, ";
                $sql2 .= "  t_aorder_d.goods_name ";
                $sql2 .= "ORDER BY ";
                $sql2 .= "  t_aorder_ship.goods_cd ";
                $sql2 .= ") ";

#print_array($sql2); 

                $sum_res = Db_Query($db_con, $sql2);
                $sum_goods_num = pg_num_rows($sum_res);

            //一つの表に表示するのは12商品まなので、１２商品ずつに配列に纏める
                $cell = 0;
                for($l = 0; $l < $sum_goods_num; $l++){
                    $sum_goods_data = pg_fetch_array($sum_res, $l);
//print_array($sum_goods_data);
//                if($l%12 == 0 && $l != 0){
                    if($l%8 == 0 && $l != 0){
                        $cell = $cell+1;
                    }

                    $goods_data[$i][$j][$cell]["name"][] = $sum_goods_data["goods_name"];
                    $goods_data[$i][$j][$cell]["num"][]  = $sum_goods_data["sum"];
                }
            }

            //巡回基準日を抽出
            $sql  = "SELECT ";
            $sql .= "   stand_day ";
            $sql .= "FROM\n";
            $sql .= "   t_stand";
            $sql .= ";";

            $day_res = Db_Query($db_con, $sql);
//    $stand_day = explode("-", pg_fetch_result($result, 0,0));
            $stand_day = explode("-", pg_fetch_result($day_res, 0,0));

            //配送日を分割
            $all_send_day[$i] = explode("-", $send_day[$slipout_check_key[$i]]);     

            //配送日の曜日を抽出
            $send_day_w[$i]   = date('w', mktime(0,0,0,$all_send_day[$i][1], $all_send_day[$i][2], $all_send_day[$i][0]));

            if($send_day_w[$i] == '0'){
                $week_w[$i] = "日";
            }elseif($send_day_w[$i] == '1'){        
                $week_w[$i] = "月";
            }elseif($send_day_w[$i] == '2'){
                $week_w[$i] = "火";
            }elseif($send_day_w[$i] == '3'){
                $week_w[$i] = "水";
            }elseif($send_day_w[$i] == '4'){
                $week_w[$i] = "木";
            }elseif($send_day_w[$i] == '5'){
                $week_w[$i] = "金";
            }elseif($send_day_w[$i] == '6'){
                $week_w[$i] = "土";
            }

            $Basic_date_res[$i] = Basic_date($stand_day[0],$stand_day[1],$stand_day[2],$all_send_day[$i][0],$all_send_day[$i][1],$all_send_day[$i][2]);

            if($Basic_date_res[$i][0] == '1'){
                $week[$i] = "A";
            }elseif($Basic_date_res[$i][0] == '2'){
                $week[$i] = "B";
            }elseif($Basic_date_res[$i][0] == '3'){
                $week[$i] = "C";
            }elseif($Basic_date_res[$i][0] == '4'){
                $week[$i] = "D";
            }
        }
    }
//デバッグ表示
//    print_array($goods_array);
//    print_array($goods_data);
//    print_array($slip_no);
//    print_array($header);


    //エラーフラグがtureの場合処理終了
    if($err_flg == true && $no_data_flg === false){
        //インスタンス生成
        $form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

        $form->addElement("submit","form_renew_button", "再印刷","");
        $form->addElement("button","form_close_button", "閉じる", "OnClick=\"window.close()\"");

        //チェックした値を残す
        for($i = 0; $i < count($slipout_check); $i++){
            $form->addElement("hidden", "form_slipout_check[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_send_day[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_staff_id[$slipout_check_key[$i]]");
            $form->addElement("hidden", "hdn_act_flg[$slipout_check_key[$i]]");

            $set_data["form_slipout_check"][$slipout_check_key[$i]] = '1';
            $set_data["hdn_send_day"][$slipout_check_key[$i]] = $send_day[$slipout_check_key[$i]];
            $set_data["hdn_staff_id"][$slipout_check_key[$i]] = $stff_id[$slipout_check_key[$i]];
            $set_data["hdn_act_flg"][$slipout_check_key[$i]]  = $act_flg[$slipout_check_key[$i]];
        }

        $form->setConstants($set_data);

        /****************************/
        //HTMLヘッダ
        /****************************/
        $html_header = Html_Header($page_title);

        /****************************/
        //HTMLフッタ
        /****************************/
        $html_footer = Html_Footer();

        /****************************/
        //画面ヘッダー作成
        /****************************/
        // Render関連の設定
        $renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
        $form->accept($renderer);

        //form関連の変数をassign
        $smarty->assign('form',$renderer->toArray());

        //その他の変数をassign
        $smarty->assign('var',array(
            'html_header'   => "$html_header",
            'html_footer'   => "$html_footer",
            'duplicate_err' => "「伝票番号".$err_no."」の持参商品が71種類以上のため表示できません。",
        ));

        //テンプレートへ値を渡す
        $smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

    //ＰＤＦ作成
    }else{
	    //作成日
	    $yy = date('Y');
	    $mm = date('m');
	    $dd = date('d');

		//タイトル
		$title = "◇　集　計　日　報　◇";

		//項目名・幅・align
		$list[0] = array("40","伝票No.","C");
		$list[1] = array("140","得　意　先","C");
		$list[2] = array("130","商　　　　品","C");
		$list[3] = array("130","商　　　　品","C");
		$list[4] = array("130","商　　　　品","C");
		$list[5] = array("130","商　　　　品","C");
		$list[6] = array("130","商　　　　品","C");
		$list[7] = array("70","消　費　税","C");
		$list[8] = array("140","売　上　合　計　額","C");
		$list[9] = array("70","売　上　外","C");

	    $goods_width = array("0","180","360","540","720");

		//ページサイズ
		//A3
		$pdf=new MBFPDF('L','pt','A3');
		$pdf->AddMBFont(GOTHIC ,'SJIS');
		$pdf->SetAutoPageBreak(false);

	    //帳票出力  
	    for($i = 0; $i < $roup_max; $i++){
		
	        //ページ数分ループ
            if($no_data_flg === true){
                $roup_max2 = 1;
            }else{
                $roup_max2 = count($page_data[$i]);
            } 
	        for($j = 0; $j < $roup_max2; $j++){
		
	            $pdf->AddPage();
	    	    //余白
			    $left_margin = 60;
			    $top_margin = 40;
	            /******************ページ数************************/
			    $pdf->SetFont(GOTHIC, '', 10);
			    //A3の横幅は、1110
			    $pdf->SetTextColor(0,0,0);
			    $pdf->SetXY(30,20);
			    $pdf->Cell(1110, 12, ($j+1)."/".$roup_max2, '0', '1', 'R');

				$pdf->Image(IMAGE_DIR.'company-rogo.PNG',$left_margin, $top_margin);
			    /*******************タイトル***********************/

			    $pdf->SetFont(GOTHIC, '', 20);
			    //A3の横幅は、1110
			    $pdf->SetTextColor(0,0,0);
			    $pdf->SetXY($left_margin,$top_margin);
			    $pdf->Cell(1110, 20, $title, '0', '1', 'C');

			    /***************タイトルの横のセル*****************/
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
			    $pdf->Cell(160,15,"　　　　　　年　　月　　日　　　日報No.".$slip_no[$i],'0','0','C','1');

			    $pdf->SetXY($left_margin+900,$top_margin+5);
			    $pdf->Cell(50,30,"ルート",'LTR','2','C','1');
                //代行の場合
                if($header[$i][3] === true){
			        $pdf->SetFillColor(180,180,180);
                }
			    $pdf->SetXY($left_margin+950,$top_margin+5);
			    $pdf->Cell(160,15,$header[$i][0],'LTR','0','L','1');
			    $pdf->SetXY($left_margin+950,$top_margin+20);
			    $pdf->Cell(160,15,$header[$i][1],'LR','0','L','1');
			    $pdf->SetFillColor(255,255,255);
			    $pdf->SetXY($left_margin+900,$top_margin+35);
			    $pdf->Cell(50,15,"予定日",'LB','2','C','1');
			    $pdf->SetXY($left_margin+950,$top_margin+35);
			    $pdf->Cell(160,15,"　".$all_send_day[$i][0]."年　".$all_send_day[$i][1]."月　".$all_send_day[$i][2]."日　".$week[$i]."週　".$week_w[$i]."曜",'BR','0','C','1');

			    $pdf->SetLineWidth(0.5);
			    $pdf->SetDrawColor(150,150,255);
			    $pdf->Line($left_margin+950,$top_margin+20,$left_margin+950,$top_margin+55);
			    $pdf->Line($left_margin+900,$top_margin+35,$left_margin+1110,$top_margin+35);

			    /*****************項目****************************/

			    $pdf->SetLineWidth(1);
			    //テキストの色
			    $pdf->SetTextColor(0,0,0); 

			    //項目表示
			    $pdf->SetXY($left_margin,$top_margin+50);
			    $pdf->SetFillColor(255,255,255);
			    for($m=0;$m<count($list)-1;$m++){
				    $pdf->SetFont(GOTHIC, '', 11);
				    if($m == 8){
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
				$pdf->SetXY($left_margin+1040, $top_margin+50);
				$pdf->Cell($list[$m][0], 15, $list[$m][1], 'LRT', '2', $list[$m][2],'1');
				$pdf->SetXY($left_margin+1040, $top_margin+65);
				$pdf->Cell('70', 15, '入　金　額', 'LRB', '0', 'C','1');

				$pdf->SetDrawColor(150,150,255);
				$pdf->Line($left_margin+40  ,$top_margin+51,$left_margin+40,$top_margin+80);
				$pdf->Line($left_margin+180 ,$top_margin+51,$left_margin+180,$top_margin+80);
				$pdf->Line($left_margin+310 ,$top_margin+51,$left_margin+310,$top_margin+80);
				$pdf->Line($left_margin+440 ,$top_margin+51,$left_margin+440,$top_margin+80);
				$pdf->Line($left_margin+570 ,$top_margin+51,$left_margin+570,$top_margin+80);
				$pdf->Line($left_margin+700 ,$top_margin+51,$left_margin+700,$top_margin+80);
				$pdf->Line($left_margin+830 ,$top_margin+51,$left_margin+830,$top_margin+80);
				$pdf->Line($left_margin+900 ,$top_margin+65,$left_margin+900,$top_margin+80);
				$pdf->Line($left_margin+970 ,$top_margin+66,$left_margin+970,$top_margin+80);
				$pdf->Line($left_margin+1040,$top_margin+65,$left_margin+1040,$top_margin+80);

				/*****************データ****************************/
				//データ表示
				$pdf->SetFont(GOTHIC, '', 9);
				$pdf->SetDrawColor(150,150,255);          //線の色
				$pdf->SetXY($left_margin,$top_margin+80);
				$pdf->SetTextColor(0,0,0);                //フォントの色
				$pdf->SetLineWidth(0.5);

				//表の行数分表示
//				for($c=0;$c<13;$c++){
				for($c=0;$c<15;$c++){
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //背景色
	//--
					//伝票番号セルの空白部分を表示
					$pdf->Cell("40", 12, "", "LTR", '0','C','1');

	                //得意先名を表示
	                $pdf->Cell("100", 12, $page_data[$i][$j][$c]["client_cd"], "LTB", "0", "L","1");
				    $pdf->SetTextColor(255,0,0);                //フォントの色
	                $pdf->Cell("40", 12, $page_data[$i][$j][$c]["slip_out"], "TBR", "0", "R","1");

				    $pdf->SetTextColor(0,0,0);                //フォントの色

	                //商品名を表示
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][0],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][0]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][1],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][1]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][2],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][2]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][3],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][3]), 'TR', '0','R','1');
					$pdf->Cell(80, 12, $page_data[$i][$j][$c]["goods"][4],                   'LT', '0','L','1');
				    $pdf->Cell(50, 12, My_Number_Format($page_data[$i][$j][$c]["price"][4]), 'TR', '0','R','1');

	                //消費税を表示
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //売上合計金額を表示
	                $pdf->Cell(140, 12, "", '1', '0', 'R', '1');

	                //入金額
	                $pdf->Cell(70 , 12, "", 'LR', '2', 'C', '1');

	//--
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //背景色

	                //伝票番号を表示
					$pdf->Cell(40 , 12, $page_data[$i][$j][$c]["no"], 'R', '0','C','1');

					//修正欄の上の空白セルを表示
					$pdf->Cell(140, 12, $page_data[$i][$j][$c]["client"], '1', '0','L','1');

	                //数量単価を表示
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][0])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][0]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][1])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][1]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][2])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][2]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][3])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][3]), '1', '0','R','1');
					$pdf->Cell(50 , 12, My_Number_Format($page_data[$i][$j][$c]["num"][4])  ,       '1', '0','R','1');
				    $pdf->Cell(80 , 12, My_Number_Format($page_data[$i][$j][$c]["sale_amount"][4]), '1', '0','R','1');

	                //消費税下の空白を表示
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["tax"]), '1', '0', 'R', '1');

	                //売上合計金額を表示
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["net_money"]), '1', '0', 'R', '1');
	                $pdf->Cell(70 , 12, My_Number_Format($page_data[$i][$j][$c]["net_ins"]),   '1', '0', 'R', '1');

	                //入金額を表示
	                $pdf->Cell(70 , 12, "", 'LR', '2', 'C', '1');

	//--
					$posY = $pdf->GetY();
					$pdf->SetXY($left_margin, $posY);
					$pdf->SetFillColor(255,255,255);      //背景色

					//伝票番号セルの空白部分を表示
					$pdf->Cell(40 , 12, "", 'LR', '0','C','1');

					//修正欄を表示
					$pdf->Cell(140, 12, $page_data[$i][$j][$c]["client2"], '1', '0','L','1');

	                //数量単価の項目を表示
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');
					$pdf->Cell(50 , 12, "", '1', '0','C','1');
					$pdf->Cell(80 , 12, "", '1', '0','C','1');

	                //消費税下の空白を表示
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //売上合計金額を表示
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');
	                $pdf->Cell(70 , 12, "", '1', '0', 'C', '1');

	                //入金額
	                $pdf->Cell(70 , 12, "", '1', '2', 'C', '1');
				}
				$pdf->Line($left_margin,$top_margin+80,$left_margin+1110,$top_margin+80);

				//太線
				$pdf->SetLineWidth(1);
				$line_width = $top_margin+80;
				for($c=1;$c<=15;$c++){
					$num = $c - 1;
					$pdf->Line($left_margin,$line_width+(36*$num),$left_margin,$line_width+36*$c);
					$pdf->Line($left_margin+180, $line_width+(36*$num),$left_margin+180,$line_width+36*$c);
					$pdf->Line($left_margin+830, $line_width+(36*$num),$left_margin+830,$line_width+36*$c);
					$pdf->Line($left_margin+900, $line_width+(36*$num),$left_margin+900,$line_width+36*$c);
					$pdf->Line($left_margin+1040,$line_width+(36*$num),$left_margin+1040,$line_width+36*$c);
					$pdf->Line($left_margin+1110,$line_width+(36*$num),$left_margin+1110,$line_width+36*$c);

					$pdf->Line($left_margin,$line_width+36*$c,$left_margin+1110,$line_width+36*$c);
				}

				/********************商品・数量*********************/
				for($x=0;$x<4;$x++){
					$pdf->SetXY($left_margin+$goods_width[$x],$top_margin+635);
					$pdf->Cell(120,12,"商　　品",'1','0','C','1');
					$pdf->Cell(50,12,"数　　量",'1','2','C','1');
					for($c=0;$c<8;$c++){
						$posY = $pdf->GetY();
						$pdf->SetXY($left_margin+$goods_width[$x], $posY);
						$pdf->Cell(120,12,$goods_data[$i][$j][$x]["name"][$c],'1','0','C','1');
						$pdf->Cell(50,12,My_Number_Format($goods_data[$i][$j][$x]["num"][$c]),'1','2','R','1');
					}
				}
				/*******************合計****************************/
				$pdf->SetFont(GOTHIC, '', 11);
				$pdf->SetXY($left_margin+750,$top_margin+620);
				$pdf->Cell(80,26,"頁　　計",'1','0','C','1');


                //一枚しかない場合
                if(count($page_data[$i]) == 1){
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','C','1');
				    $pdf->SetXY($left_margin+830,$top_margin+633);
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                           ,'1','1','C','1');
                }else{
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_money_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_ins_amount[$i][$j])  ,'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','C','1');
				    $pdf->SetXY($left_margin+830,$top_margin+633);
				    $pdf->Cell(70,13,My_Number_format($page_tax_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_money_tax_amount[$i][$j]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($page_ins_tax_amount[$i][$j])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                           ,'1','1','C','1');
                }
				$posY = $pdf->GetY();
				$pdf->SetXY($left_margin+750, $posY);
				$pdf->SetFillColor(180,180,180);      //背景色
				$pdf->Cell(80,26,"合　　計",'1','0','C','1');

                if($j == count($page_data[$i])-1){
				    $pdf->Cell(70,13,""                                    ,'1','0','0','1');
				    $pdf->Cell(70,13,My_Number_format($total_money_amount[$i]),'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($total_ins_amount[$i])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                    ,'1','0','C','1');

				    $pdf->SetXY($left_margin+830,$posY+13);
                    $pdf->Cell(70,13,My_Number_format($total_tax_amount[$i])      ,'1','0','R','1');
				    $pdf->Cell(70,13,My_Number_format($total_money_tax_amount[$i]),'1','0','R','1');
    			    $pdf->Cell(70,13,My_Number_format($total_ins_tax_amount[$i])  ,'1','0','R','1');
				    $pdf->Cell(70,13,""                                        ,'1','1','C','1');
				    $pdf->SetXY($left_margin,$posY+100);
                }else{
				    $pdf->Cell(70,13,""                                    ,'1','0','0','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                    ,'1','0','C','1');

				    $pdf->SetXY($left_margin+830,$posY+13);
                    $pdf->Cell(70,13,"", '1','0','R','1');
				    $pdf->Cell(70,13,"",'1','0','R','1');
    			    $pdf->Cell(70,13,"",'1','0','R','1');
				    $pdf->Cell(70,13,""                                        ,'1','1','C','1');
				    $pdf->SetXY($left_margin,$posY+100);

                }
				$pdf->SetFillColor(255,255,255);      //背景色
			    $pdf->Cell(160,15,"印刷日　　".$yy."年　".$mm."月　".$dd."日",'0','0','R','1');

				//太線
				$pdf->SetLineWidth(1);

				$pdf->Line($left_margin+750 ,$top_margin+620.5,$left_margin+750,$top_margin+672.5);
				$pdf->Line($left_margin+830 ,$top_margin+620.5,$left_margin+830,$top_margin+672.5);
				$pdf->Line($left_margin+900 ,$top_margin+620.5,$left_margin+900,$top_margin+672.5);
				$pdf->Line($left_margin+1040,$top_margin+620.5,$left_margin+1040,$top_margin+672.5);
				$pdf->Line($left_margin+1110,$top_margin+620.5,$left_margin+1110,$top_margin+672.5);

				$pdf->Line($left_margin+750 ,$top_margin+646.5,$left_margin+1110,$top_margin+646.5);
				$pdf->Line($left_margin+750 ,$top_margin+672.5,$left_margin+1110,$top_margin+672.5);


			}
	    }
		$pdf->Output();
		//$pdf->Output(mb_convert_encoding("集計日報".date("Ymd").".pdf", "SJIS", "EUC"),"D");
	}
}

//受託先で集計日報を出す場合に消費税を計算する関数
function Aord_Tax_Amount($db_con, $sale_amount, $tax_div){


    //消費税率を抽出
    $sql = "SELECT 
                tax_rate_n 
            FROM
                t_client 
            WHERE
                client_id = ".$_SESSION["client_id"]."
            ;
        ";
    $result = Db_Query($db_con, $sql);
    $tax_rate = pg_fetch_result($result, 0, 0);

    //東陽の丸め区分、端数区分を抽出
    $sql = "SELECT 
                client_id, 
                coax, 
                tax_franct 
            FROM 
                t_client 
            WHERE 
                shop_id = ".$_SESSION["client_id"]." 
                AND 
                act_flg = true
            ;";
    
    $result = Db_Query($db_con, $sql);
    $toyo_data = pg_fetch_array($result, 0);

    $total_amount = Total_Amount($sale_amount, $tax_div, $toyo_data["coax"], $toyo_data["tax_franct"], $tax_rate, $toyo_data["client_id"], $db_con);


    return $total_amount[1];
}

?>
