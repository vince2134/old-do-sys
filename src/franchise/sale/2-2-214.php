<?php
/************************************/
// 割賦売上入力
//
//変更履歴
//  日時更新後の売上データ抽出SQLを変更（2006/06/16　watanabe-k）
//
//  仕入の方からコピーして売上用に（2006/08/24 kaji）
//
//  回収日を今回締日以降の回収日に（2006/09/16 kaji）
//  分割回数は2回以上に
//
//  支払日のセレクトボックスが「0ヵ月後」となっていたのをなくす（2006/09/16 kaji）
//
//  （2006/10/26 kaji）
//    ・支払日は仕入入力で入力された仕入日を基準に
//
//  （2006/11/27 koji）
//    ・支払日は仕入入力で入力された仕入日＋集金日を基準に
//
/************************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-010      kajioka-h   登録直前に取引区分が変更されていないか確認する処理を追加
 *                  03-012      kajioka-h   登録直前に請求日が変更されていないか確認する処理を追加
 *  2006-12-12      03-061      suzuki      登録直前に得意先が変更されていないか確認する処理を追加
 *  2006-12-14      03-062      kajioka-h   登録直前に日次更新されていないか確認する処理を追加
 *  2007-01-17      仕様変更    watanabe-k  分割回数を２〜６０までに変更
 *
 */

//$page_title = "売上照会";
$page_title = "割賦売上入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$sale_id      = $_GET["sale_id"];           //売上ID
Get_Id_Check2($sale_id);
Get_Id_Check3($sale_id);
$division_flg = ($_GET["division_flg"] == "true") ? true : false;      //入力識別フラグ
$change_flg = $_GET["change_flg"];

/****************************/
//初期表示データ取得（売上SQL）
/****************************/
$sql  = "SELECT \n";
$sql .= "    t_sale_h.sale_no, \n";
$sql .= "    t_sale_h.sale_day, \n";
$sql .= "    t_sale_h.claim_day, \n";
$sql .= "    t_trade.trade_name, \n";
$sql .= "    t_sale_h.client_cd1, \n";
$sql .= "    t_sale_h.client_cd2, \n";
$sql .= "    t_sale_h.client_cname, \n";
$sql .= "    t_sale_h.direct_cd, \n";
$sql .= "    t_sale_h.direct_cname, \n";
$sql .= "    t_sale_h.trans_cname, \n";
$sql .= "    t_sale_h.green_flg, \n";
$sql .= "    t_sale_h.ware_name, \n";
$sql .= "    t_sale_staff.staff_name, \n";
$sql .= "    t_sale_h.net_amount, \n";
$sql .= "    t_sale_h.tax_amount, \n";
$sql .= "    t_sale_h.note, \n";
$sql .= "    t_sale_h.renew_flg, \n";
$sql .= "    t_sale_h.client_id \n";
$sql .= "FROM \n";
$sql .= "    t_sale_h \n";
$sql .= "    INNER JOIN t_trade ON t_sale_h.trade_id = t_trade.trade_id \n";
$sql .= "    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
$sql .= "        AND t_sale_staff.staff_div = '0' \n";
$sql .= "WHERE \n";
if($_SESSION["group_kind"] == "2"){
    $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") \n";
}else{
    $sql .= "    t_sale_h.shop_id = $shop_id \n";
}
$sql .= "    AND \n";
$sql .= "    t_sale_h.sale_id = $sale_id \n";
$sql .= ";\n";
//echo "初期表示売上ヘッダSQL：<br>$sql<br>";

$result = Db_Query($db_con, $sql);

//GETデータ判定
Get_Id_Check($result);
$h_data_list = Get_Data($result);


//売上ヘッダー表示
$def_fdata["form_sale_no"]          = $h_data_list[0][0];   //伝票番号

//日付生成
$form_sale_day = explode('-',$h_data_list[0][1]);
$def_fdata["form_sale_day"]["y"]    = $form_sale_day[0];    //売上日(年)
$def_fdata["form_sale_day"]["m"]    = $form_sale_day[1];    //売上日(月)
$def_fdata["form_sale_day"]["d"]    = $form_sale_day[2];    //売上日(日)

$form->addElement("hidden", "hdn_claim_day");
$def_fdata["hdn_claim_day"]         = $h_data_list[0][2];
$claim_day                          = $h_data_list[0][2];
$form_claim_day = explode('-',$h_data_list[0][2]);
$def_fdata["form_claim_day"]["y"]   = $form_claim_day[0];   //請求日(年)
$def_fdata["form_claim_day"]["m"]   = $form_claim_day[1];   //請求日(月)
$def_fdata["form_claim_day"]["d"]   = $form_claim_day[2];   //請求日(日)

$def_fdata["form_trade_sale"]       = $h_data_list[0][3];   //取引区分
$trade_name                         = $h_data_list[0][3];   //取引区分

$def_fdata["form_client"]["cd1"]    = $h_data_list[0][4];   //得意先CD1
$def_fdata["form_client"]["cd2"]    = $h_data_list[0][5];   //得意先CD2
$def_fdata["form_client"]["name"]   = $h_data_list[0][6];   //得意先名（略称）

//$def_fdata["form_direct_cd"]      = $h_data_list[0][7];   //直送先コード
$def_fdata["form_direct_name"]      = $h_data_list[0][8];   //直送先

$def_fdata["form_trans_name"]       = $h_data_list[0][9];   //運送業者
//グリーン指定判定
if($h_data_list[0][10] == 't'){
    $def_fdata["form_trans_check"]  = "グリーン指定あり　";
}

$def_fdata["form_ware_name"]        = $h_data_list[0][11];  //倉庫
$def_fdata["form_cstaff_name"]      = $h_data_list[0][12];  //売上担当者

$def_fdata["form_sale_total"]       = number_format($h_data_list[0][13]);   //売上金額（税抜）
$def_fdata["form_sale_tax"]         = number_format($h_data_list[0][14]);   //消費税
$total_money = $h_data_list[0][13] + $h_data_list[0][14];   //税込金額
$def_fdata["form_sale_money"]       = number_format($total_money);

$def_fdata["form_note"]             = $h_data_list[0][15];  //備考

$def_fdata["hdn_renew_flg"]         = $h_data_list[0][16];  //日次更新フラグ
$division_flg = ($h_data_list[0][16] == "t") ? "true" : $division_flg;

//回収日（毎月）
$sql = "SELECT pay_d, pay_m FROM t_client WHERE client_id = ".$h_data_list[0][17].";";
$result = Db_Query($db_con,$sql);
$form->setConstants(array("form_pay_d"=>(int)pg_fetch_result($result, 0, 0)));
$form->setConstants(array("hdn_form_pay_m"=>(int)pg_fetch_result($result, 0, 1)));

//得意先
$def_fdata["hdn_client_id"] = $h_data_list[0][17];
$client_id                  = $h_data_list[0][17];

$form->setDefaults($def_fdata);

//入力された請求日を基準にする
$yy = (int)$form_claim_day[0];
$mm = (int)$form_claim_day[1];


//分割設定ボタン押下時に日次更新されていた場合エラー
if($h_data_list[0][16] == "t" && isset($_POST["add_button"])){
    $renew_msg = "日次更新されているため、割賦売上入力できません。";
}


/****************************/
// 分割設定確認のみの場合
/****************************/
if ($division_flg == "true"){

    // 該当仕入IDの分割データを取得
    $sql = "SELECT collect_day, collect_amount FROM t_installment_sales WHERE sale_id = $sale_id ORDER BY collect_day;";
    $res = Db_Query($db_con, $sql);
    $i = 0;
    while ($ary_res = @pg_fetch_array($res, $i, PGSQL_ASSOC)){
        $ary_division_data[$i]["pay_day"] = $ary_res["collect_day"];
        $ary_division_data[$i]["split_pay_amount"] = $ary_res["collect_amount"];
        $i++;
    }

    for ($i=0; $i<count($ary_division_data); $i++){
        $form->addElement("static", "form_pay_date[$i]", "");
        $form->addElement("static", "form_pay_amount[$i]", "");
        $division_data["form_pay_date[$i]"]     = $ary_division_data[$i]["pay_day"];
        $division_data["form_pay_amount[$i]"]   = number_format($ary_division_data[$i]["split_pay_amount"]);
    }
        $form->setConstants($division_data);

/****************************/
// 分割設定を行う・未設定の場合
/****************************/
}else{
    /****************************/
    // 分割設定ボタン押下時　前処理
    /****************************/
    if ($_POST["hdn_division_submit"] == "t"){

        /*** 分割設定エラーチェック ***/

        // エラーフラグ格納先作成
        $ary_division_err_flg = array();

        // 支払日
        if ($_POST["form_pay_m"] == null || $_POST["form_pay_d"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "回収日は必須です。";
        }

        // 分割回数
        if ($_POST["form_division_num"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "分割回数は必須です。";
        }

        // エラーチェック結果集計
        $division_err_flg = (in_array(true, $ary_division_err_flg)) ? true : false;

        // 分割設定フラグ格納
        $division_set_flg = ($division_err_flg === false) ? true : false;

        // 分割設定内容をhiddenにSET
        if ($division_set_flg == true){
            $hdn_set["hdn_pay_m"]           = $_POST["form_pay_m"];
            $hdn_set["hdn_pay_d"]           = $_POST["form_pay_d"];
            $hdn_set["hdn_division_num"]    = $_POST["form_division_num"];
            $form->setConstants($hdn_set);
        }

        // hiddenにSETされた分割設定ボタン押下情報を削除
        $hdn_del["hdn_division_submit"] = "";
        $form->setConstants($hdn_del);

    }

    /****************************/
    // 分割支払登録ボタン押下時　前処理
    /****************************/
    if (isset($_POST["add_button"])){

        // （分割支払登録ボタンが表示されている＝分割設定内容に問題なしなので）分割設定フラグONを格納
        $division_set_flg = true;

        // （分割設定ボタン押下時に）hiddenにSETした分割設定内容を変数へ代入
        $hdn_pay_m           = $_POST["hdn_pay_m"];
        $hdn_pay_d           = $_POST["hdn_pay_d"];
        $hdn_division_num    = $_POST["hdn_division_num"];

        // さらにフォームへSET（表示用）
        $division_set["form_pay_m"]         = $_POST["hdn_pay_m"];
        $division_set["form_pay_d"]         = $_POST["hdn_pay_d"];
        $division_set["form_division_num"]  = $_POST["hdn_division_num"];
        $form->setConstants($division_set);

    }


    /****************************/
    // 分割設定処理
    /****************************/
    // 分割設定フラグが真の場合
    if ($division_set_flg === true){

        // 分割設定前処理
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // 支払日（月）

//        $pay_m          = $pay_m + $_POST["hdn_form_pay_m"];

        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // 支払日（日）
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // 分割回数
        $total_money    = str_replace(",", "", $total_money);   // 税込金額（カンマ抜き）
        //$yy             = date("Y");
        //$mm             = date("m");

        // 税込金額÷分割回数の商
        $division_quotient_price    = bcdiv($total_money, $division_num);
        // 税込金額÷分割回数の余り
        $division_franct_price      = bcmod($total_money, $division_num);
        // 2回目以降の支払金額
        $second_over_price          = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
        // 1回目の支払金額
        $first_price                = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;
        // 金額が分割回数で割り切れる場合
        if ($division_franct_price == "0"){
            $first_price = $second_over_price = $division_quotient_price;
        }

        // 分割回数分ループ
        for ($i=0; $i<$division_num; $i++){

            // 分割支払日作成
            $date_y     = date("Y", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $date_m     = date("m", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $mktime_m   = ($pay_d == "29") ? $mm + $pay_m + $i + 1 : $mm + $pay_m + $i;
            $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
            $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $yy));

            // 分割支払日を配列にSET
            $division_date[]    = "$date_y-$date_m-$date_d";

            // 分割支払金額を配列にSET
            $division_price[]   = ($i == 0) ? $first_price : $second_over_price;

            // 分割支払日フォーム作成
            $form_pay_date = null;
            $form_pay_date[] = &$form->createElement("static", "y", "", "");
            $form_pay_date[] = &$form->createElement("static", "m", "", "");
            $form_pay_date[] = &$form->createElement("static", "d", "", "");
            $form->addGroup($form_pay_date, "form_pay_date[$i]", "", "-");

            // 分割支払金額フォーム作成
            $form->addElement("text", "form_split_pay_amount[$i]", "", "class=\"money\" size=\"11\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

            // 分割支払金額をセット
            $set_data["form_split_pay_amount"][$i] = ($i == 0) ? $first_price : $second_over_price;

            // 分割支払日をセット
            $set_data["form_pay_date"][$i]["y"] = $date_y;
            $set_data["form_pay_date"][$i]["m"] = $date_m;
            $set_data["form_pay_date"][$i]["d"] = $date_d;

            // 分割支払金額、分割支払日データをSET（分割支払登録ボタン押下時はフォームデータを引き継ぐ）
            isset($_POST["add_button"]) ? $form->setDefaults($set_data) : $form->setConstants($set_data);

        }

    }

    /****************************/
    // 分割請求登録ボタン押下処理
    /****************************/
    if (isset($_POST["add_button"])){

        /****************************/
        // エラーチェック
        /****************************/
        /* 合計金額チェック */
        // 分割支払金額
        $sum_err_flg = ($total_money != array_sum($_POST["form_split_pay_amount"])) ? true : false;
        if ($sum_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額の合計が不正です。");
        }

        /* 半角数字チェック */
        // 分割支払金額
        for ($i=0; $i<$division_num; $i++){
            $ary_numeric_err_flg[] = (ereg("^[0-9]+$", $_POST["form_split_pay_amount"][$i])) ? false : true;
        }
        if (in_array(true, $ary_numeric_err_flg)){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額は半角数字のみです。");
        }
    
        /* 必須項目チェック */
        // 分割支払金額
        $required_err_flg = (in_array(null, $_POST["form_split_pay_amount"])) ? true : false;
        if ($required_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額は必須です。");
        }

        /* 取引区分チェック */
        $trade_err_flg = ($trade_name != "割賦売上") ? true : false;
        if ($trade_err_flg == true){
            $form->setElementError("form_trade_sale", "伝票が変更されているため、割賦売上入力できません。");
        }

        /* 請求日チェック */
        $claim_day_err_flg = ($claim_day != $_POST["hdn_claim_day"]) ? true : false;
        if ($claim_day_err_flg == true){
            $form->setElementError("form_claim_day", "請求日が変更されています。再度分割設定してください。");
        }

		/* 得意先変更判定 */
        $client_id_err_flg = ($client_id != $_POST["hdn_client_id"]) ? true : false;
        if ($client_id_err_flg == true){
            $client_msg = "得意先が変更されているため、割賦売上入力できません。";
        }

		/* 日次更新変更判定 */
		$sql  = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $sale_id;";
		$result = Db_Query($db_con, $sql);
		$renew_data = Get_Data($result);
		if($renew_data[0][0] == "t"){
            $renew_msg = "日次更新されているため、割賦売上入力できません。";
        }

        // エラーチェック結果集計
        $err_flg = ($sum_err_flg == true || in_array(true, $ary_numeric_err_flg) || $required_err_flg == true || $trade_err_flg == true || $claim_day_err_flg == true || $client_id_err_flg == true || $renew_data[0][0] == "t" || $renew_msg != null) ? true : false;

        // バリデーーート
        $form->validate();

        /****************************/
        // DB処理
        /****************************/
        // エラーが無ければ
        if ($err_flg == false){

            // フリーザ
            $form->freeze();

            // トランザクション開始
            Db_Query($db_con, "BEGIN;");

            // 更新状況フラグの定義
            $db_err_flg = array();

            /* 売上ヘッダテーブル更新処理(UPDATE) */
            $sql = "UPDATE t_sale_h SET total_split_num = $division_num WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦支払テーブル更新処理(DELETE) */
            $sql = "DELETE from t_installment_sales WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦支払テーブル更新処理(INSERT) */
            for ($i=0; $i<$division_num; $i++){
/*
                $sql  = "INSERT INTO t_amortization (";
                $sql .= "    amortization_id,";
                $sql .= "    buy_id,";
                $sql .= "    pay_day,";
                $sql .= "    split_pay_amount";
                $sql .= ") VALUES (";
                $sql .= "    (SELECT COALESCE(MAX(amortization_id), 0)+1 FROM t_amortization),";
                $sql .= "    $sale_id,";
                $sql .= "    '$division_date[$i]',";
                $sql .= $_POST["form_split_pay_amount"][$i];
                $sql .= ");";
*/
                $sql  = "INSERT INTO \n";
                $sql .= "    t_installment_sales \n";
                $sql .= "( \n";
                $sql .= "    installment_sales_id, \n";
                $sql .= "    sale_id, \n";
                $sql .= "    collect_day, \n";
                $sql .= "    collect_amount \n";
                $sql .= ") VALUES ( \n";
                $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
                $sql .= "    $sale_id, \n";
                $sql .= "    '$division_date[$i]', \n";
                $sql .= "    ".$_POST["form_split_pay_amount"][$i]." \n";
                $sql .= ");\n";

                $res  = Db_Query($db_con, $sql);

                // 更新失敗時ロールバック
                if ($res == false){
                    Db_Query($db_con, "ROLLBACK;");
                    $db_err_flg[] = true;
                    exit;
                }
            }

            // SQLエラーが無い場合
            if (!in_array(true, $db_err_flg)){

                // コメットさん
                Db_Query($db_con, "COMMIT;");

                // 分割支払登録フラグにTRUEをSET
                $division_comp_flg = true;

                // 画面表示用にナンバーフォーマットした分割支払金額をセット
                if (isset($_POST["add_button"])){
                    for ($i=0; $i<count($_POST["form_split_pay_amount"]); $i++){
                        $number_format_data["form_split_pay_amount"][$i] = number_format($_POST["form_split_pay_amount"][$i]);
                    }
                }
                $form->setConstants($number_format_data);
            }

        }

    }

}



/****************************/
//部品定義
/****************************/
//売上計上日
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//請求日
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//伝票番号
$form->addElement("static","form_sale_no","","");

//得意先名
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//グリーン指定
$form->addElement("static","form_trans_check","","");
//運送業者名
$form->addElement("static","form_trans_name","","");
//直送先名
$form->addElement("static","form_direct_name","","");
//出荷倉庫
$form->addElement("static","form_ware_name","","");
//取引区分
$form->addElement("static","form_trade_sale","","");
//売上担当者
$form->addElement("static","form_cstaff_name","","");
//備考
$form->addElement("static","form_note","","");

//排他エラーの場合は表示しない
if($trade_err_flg != true && $claim_day_err_flg != true && $client_id_err_flg != true && $renew_data[0][0] != "t"){
	//伝票発行
	$form->addElement("submit","add_button","分割請求登録","$disabled");
}

//伝票発行ID
$form->addElement("hidden", "order_sheet_id");

//集金日
$form->addElement("hidden", "hdn_form_pay_m");

//得意先
$form->addElement("hidden", "hdn_client_id");

// OKボタン
$form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"location.href='".Make_Rtn_Page("sale")."'\"");


//遷移元チェック
//売上入力画面
//戻る
if ($_GET["division_flg"] == "true"){
    $form->addElement("button", "return_button", "戻　る", "onClick=\"history.back()\"");
}else{
    $form->addElement("button","return_button","戻　る","onClick=\"location.href='./2-2-201.php?sale_id=$sale_id&done_flg=true&change_flg=$change_flg&installment_flg=15'\"");
}


//売上金額合計
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"8\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//分割回数
$select_value[null] = null;
/*
$select_value[2]    = "2回";
$select_value[3]    = "3回";
$select_value[6]    = "6回";
$select_value[12]   = "12回";
$select_value[24]   = "24回";
$select_value[36]   = "36回";
$select_value[48]   = "48回";
$select_value[60]   = "60回";
*/

for($i = 2; $i <= 60; $i++ ){
    $select_value[$i] = $i."回";
}

$form->addElement(
        "select","form_division_num", "",
        $select_value
);
$form->addElement("hidden","hdn_division_select");

//請求日
//月
$select_month[null] = null; 
//for($i = 1; $i <= 12; $i++){

for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "当月"; 
    }elseif($i == 1){

 //   if($i == 1){
        $select_month[1] = "翌月"; 
    }else{  
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_pay_m", "セレクトボックス", $select_month, $g_form_option_select);

//日
for($i = 0; $i <= 29; $i++){
    if($i == 29){ 
        $select_day[$i] = '月末'; 
    }elseif($i == 0){
        $select_day[null] = null; 
    }else{  
        $select_day[$i] = $i."日";
    }
}
$freeze_pay_d = $form->addElement("select", "form_pay_d", "セレクトボックス", $select_day, $g_form_option_select);
$freeze_pay_d->freeze();

//排他エラーの場合は表示しない
if($trade_err_flg != true && $claim_day_err_flg != true && $client_id_err_flg != true && $renew_data[0][0] != "t"){
	$form->addElement(
	        "button", "form_conf_button", "分割設定",
	        //"onClick=\"Button_Submit('hdn_division_select','#', 't');\""
	        "onClick=\"Button_Submit('hdn_division_submit','#', 't');\" $disabled"
	);
}

// hidden
$form->addElement("hidden", "hdn_division_submit", "");
$form->addElement("hidden", "hdn_pay_m", "");
$form->addElement("hidden", "hdn_pay_d", "");
$form->addElement("hidden", "hdn_division_num", "");


/*
print_array($_POST);
*/


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
//$page_menu = Create_Menu_h('sale','2');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    "division_set_flg"      => $division_set_flg,
    "division_err_flg"      => $division_err_flg,
    "ary_division_err_msg"  => $ary_division_err_msg,
    "division_comp_flg"     => $division_comp_flg,
    "division_flg"          => $division_flg,
    "freeze_flg"            => "$freeze_flg",
//    'aord_id'       => "$aord_id",
//    'input_flg'     => "$input_flg",
//    'order_sheet'   => "$order_sheet",
	'client_msg'    => "$client_msg",
	'renew_msg'     => "$renew_msg",
    'freeze_flg'    => "$freeze_flg",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
