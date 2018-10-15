<?php
/**
 *
 * 月次更新処理
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
 * 1.0.0 (2006/09/09) 新規作成
 * 1.1.0 (2006/09/14) 
 *   ・月次売掛残高、月次買掛残高のテーブル変更に伴いSQL変更
 * 1.1.1 (2006/09/16) 
 *   ・仕入先の支払日を以下のように変更
 *       t_client.pay_m → t_client.payout_m
 *       t_client.pay_d → t_client.payout_d
 * 1.2.0 (2006/10/19) 
 *   ・途中で取引先が追加されて初期残高設定された場合に更新日がかぶるため、
 *     月次更新の対象となる取引先の抽出条件を変更
 *   ・月次更新の対象期間に棚卸更新の終わっていない棚卸がないかチェック追加
 * 1.2.1 (2006/10/31) 
 *   ・対象となる得意先、または仕入先が0件の場合にクエリエラーとなってしまうのを修正
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.2.2 (2007-01-29)
 *
 */
/*
 * 履歴：
 *   日付        B票No.        担当者      内容
 *  -----------------------------------------------------------
 *   2007-01-09  0042          kajioka-h   FC画面で月次売掛残高テーブルに残す担当者を契約担当1〜2に修正
 *   2007-01-10  xx-xxx        kajioka-h   本部がFCから仕入れるのに対応
 *   2007/01/29  xx-xxx        kajioka-h   月次買掛残高テーブルに取引先区分を残すように変更
 *   2007/03/07  その他-22     kajioka-h   ロイヤリティ、一括消費税の処理を追加
 *                             kajioka-h   未更新の請求があった場合にエラーメッセージを表示
 *   2007/03/19  xx-xxx        kajioka-h   日次更新チェックを売上は売上計上日、仕入は入荷日だけをチェックするように変更
 *   2007/05-03  0014          kajioka-h   「0007-03」で月次更新するバグ修正
 *   2007/05/09  B0702-056     kajioka-h   調整額の符号が間違っているバグ修正
 *   2007/05/28  B0702-058     kajioka-h   本部の場合、同じclient_idで売りも買いもするので、ロイヤリティ・一括消費税の区別がつかないバグ修正
 *   2007/06/06                watanabe-k  仕入締処理を行なっていない場合はエラーを表示するように修正
 *   2007/05/27  xx-xxx        kajioka-h   上のチェックを仕入締更新が行われていない場合にエラーとするように変更
 *  2007-07-12                  fukuda      「支払締」を「仕入締」に変更
 *  2007-07-13                  fukuda      「支払更新」を「仕入締更新」に変更
 *  2007-11-12                 watanabe-k  仕入の日時更新チェックをarrival_dayでなくbuy_dayを使用するように修正
 *   2010/01/05                aoyama-n    税率をTaxRateクラスから取得
 */

$page_title = "月次更新処理";

//環境設定ファイルenv setting file
require_once("ENV_local.php");

//SQL生成関数 SQL function creation
require_once(INCLUDE_DIR."function_monthly_renew.inc");


// DB接続設定 set up database connection
$db_con = Db_Connect();

// HTML_QuickFormを作成 create HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


/*****************************/
// 権限関連処理 auth related setting
/*****************************/
// 権限チェック authorization setting
$auth       = Auth_Check($db_con);
// ボタンDisabled button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// 外部変数取得 acquire external variable
/****************************/
$shop_id = $_SESSION["client_id"];
//$staff_id = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
$group_kind = $_SESSION["group_kind"];


/****************************/
// 設定 setting
/****************************/
$list_row_num = 12;     //画面に表示する月次更新履歴の数（12ヶ月分）number of monthly updates to display (12 months)
$client_div = ($group_kind == "1") ? "3" : "1";         //取引先区分（本部画面は「3（得意先はFC）」、FC画面は「1（普通の得意先）」）trade classification (for HQ, 3 is for FC and then for FC, 1 is a normal customer 
$hf_div_msg = ($client_div == "3") ? "本部" : "自社";   //締日が設定されてないエラーメッセージに使う use for error message when date is not set

$renew_flg = true;  //日次更新済のもの（売上とか）だけが対象（月次更新ではあたりまえ）only for data that are daily updated (like sales). (for monthly update this happens always)

#2010-01-05 aoyama-n
//税率クラス　インスタンス生成 tax rate class. create instace
$tax_rate_obj = new TaxRate($shop_id);

/****************************/
// フォームパーツ定義 define form parts
/****************************/
// 今回更新年月 month and year to be updated
// 更新日 current date
$renew_date = null;
$renew_date[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" $g_form_option style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_renew_day[y]','form_renew_day[m]',4);\"");
$renew_date[] =& $form->createElement("static", "", "", "-");
$renew_date[] =& $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" $g_form_option style=\"$g_form_style\"");
$form_renew_day = $form->addGroup($renew_date, "form_renew_day", "");

// 実行ボタン execute button
$form->addElement("submit", "jikkou", "実　行", "onClick=\"javascript: return Dialogue('実行します。','#')\" $disabled");


/****************************/
//更新年月初期表示 update date initial display 
/****************************/
//前回の月次更新日を取得 acquire the previous monthly update date
$sql  = "SELECT \n";
$sql .= "    close_day \n";
$sql .= "FROM \n";
$sql .= "    t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "    shop_id = ".$shop_id." \n";
$sql .= "    AND \n";
$sql .= "    renew_div = '2' \n";
$sql .= "ORDER BY \n";
$sql .= "    close_day DESC \n";
$sql .= "LIMIT 1 \n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);
if(pg_num_rows($result) == 1){
    $close_day = pg_fetch_result($result, 0, "close_day");
}else{
    $close_day = null;
}

//初回月次更新時 when it is the first time to monthly update
if($close_day == null){

    //一番古い日付を取得 acquire the oldest date
    $sql  = "SELECT \n";
    $sql .= "    LEAST( \n";
    $sql .= "        (SELECT MIN(sale_day) FROM t_sale_h WHERE shop_id = $shop_id), \n";
    $sql .= "        (SELECT MIN(pay_day) FROM t_payin_h WHERE shop_id = $shop_id), \n";
    $sql .= "        (SELECT MIN(buy_day) FROM t_buy_h WHERE shop_id = $shop_id), \n";
    $sql .= "        (SELECT MIN(pay_day) FROM t_payout_h WHERE shop_id = $shop_id) \n";
    $sql .= "    ) \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $least_day = pg_fetch_result($result, 0, 0);

    //nullじゃない（データが存在する）場合、いつが更新年月か算出 if it is not a null (meaning there is data), compute when the update year/month is.
    if($least_day != null){

        //自社締日を取得 acquire the closing date
        $sql = "SELECT my_close_day FROM t_client WHERE client_id = $shop_id;";
        $result = Db_Query($db_con, $sql);
        $my_close_day = pg_fetch_result($result, 0, 0);     //自社締日 closing date

        //一番古い日付の年月日を取得 acquire the oldest date
        $least_day_y = substr($least_day, 0, 4);
        $least_day_m = substr($least_day, 5, 2);
        $least_day_d = substr($least_day, 8, 2);

        //自社締日が月末じゃない、締日の方が小さい場合は翌月が締日になる if the closing date is not at the end of the month, and if the closing date is smaller then next month will be the closing date.
        if($my_close_day != "29" && $least_day_d > $my_close_day){
            $least_day_m++;
        }

        $str_def_day = date("Y-m", mktime(0, 0, 0, $least_day_m, 1, $least_day_y));
        $arr_def_day = explode("-", $str_def_day);

        $def_data["form_renew_day"]["y"] = $arr_def_day[0]; //初期表示更新年 display of update year when it's the first update
        $def_data["form_renew_day"]["m"] = $arr_def_day[1]; //初期表示更新月 display of update month when it's the first update

    }else{
        $def_data["form_renew_day"]["y"] = "";  //初期表示更新年 display of update year when it's the first update
        $def_data["form_renew_day"]["m"] = "";  //初期表示更新月 display of update month when it's the first update
    }

}else{
    $close_day_y = substr($close_day, 0, 4);
    $close_day_m = substr($close_day, 5, 2);

    $str_def_day = date("Y-m", mktime(0, 0, 0, $close_day_m +1, 1, $close_day_y));
    $arr_def_day = explode("-", $str_def_day);

    $def_data["form_renew_day"]["y"] = $arr_def_day[0]; //初期表示更新年 display of update year when it's the first update
    $def_data["form_renew_day"]["m"] = $arr_def_day[1]; //初期表示更新月 display of update month when it's the first update
}

$form->setDefaults($def_data);


/****************************/
//実行ボタン押下 press execution button
/****************************/
if($_POST["jikkou"] != null){

    //エラーフラグ初期化 initialize error flag
    $renew_err_flg = false;


    //入力された年月の必須、数値チェック check if the value inputted in the date is valid. Also do required field check
    $form->addGroupRule('form_renew_day', array(
            'y' => array(
                    array('更新年月 の日付は必須入力です。', 'required'),
                    array('更新年月 の日付は半角数値のみです。', "regex", '/^[0-9]+$/')
            ),
            'm' => array(
                    array('更新年月 の日付は必須入力です。', 'required'),
                    array('更新年月 の日付は半角数値のみです。', "regex", '/^[0-9]+$/')
            )
    ));
    //妥当性チェック check the validity
    if($_POST["form_renew_day"]["y"] != null && $_POST["form_renew_day"]["m"] != null){
        $renew_day_y = (int)$_POST["form_renew_day"]["y"];
        $renew_day_m = (int)$_POST["form_renew_day"]["m"];
        if(!checkdate($renew_day_m, 1, $renew_day_y)){
            $form->setElementError("form_renew_day","更新年月 の日付は妥当ではありません。");
        }
    }

    //バリデート validate
    $renew_err_flg = ($form->validate()) ? false : true ;

    //自社締日を取得 acquire the closing date of the company
    if($renew_err_flg == false){
        $sql = "SELECT my_close_day FROM t_client WHERE client_id = $shop_id;";
        $result = Db_Query($db_con, $sql);
        $my_close_day = pg_fetch_result($result, 0, 0);     //自社締日 closing date of the company 

        //自社締日が設定されていない場合エラー error if the closing date is not being set
        if($my_close_day == null){
            $form_input_err_msg = "自社の締日が設定されていません。<br>".$hf_div_msg."プロフィールで締日を設定してください。";
            $renew_err_flg = true;
        }
    }


    $post_close_day_y = str_pad($_POST["form_renew_day"]["y"], 4, "0", STR_PAD_LEFT);   //整形済ユーザ入力年 year inputted by user which is formatted
    $post_close_day_m = str_pad($_POST["form_renew_day"]["m"], 2, "0", STR_PAD_LEFT);   //整形済ユーザ入力月 monthinputted by user which is formatted

    if($renew_err_flg == false){
        $this_month_close_day  = $post_close_day_y."-".$post_close_day_m."-";   //今月の締日 closing date for the current month
        $this_month_close_day .= str_pad($my_close_day, 2, "0", STR_PAD_LEFT);  //今月の締日 closing date for the current month

        //現在の日付が更新年月の締日を過ぎているか does the current date past the closing day
        if($this_month_close_day >= $g_today){
            $form_input_err_msg = "指定された更新年月はまだ締日を過ぎていません。";
            $renew_err_flg = true;
        }

        //システム開始日を過ぎているか is it past the date the system started
        $start_day_err_msg = Sys_Start_Date_Chk($post_close_day_y, $post_close_day_m, $my_close_day, "更新年月");
        $renew_err_flg = ($start_day_err_msg != null) ? true : $renew_err_flg;

    }


    //エラーがなければ入力された更新年月が過去、未来で正しいのかチェック if there is no error, check if the update date inputted is correct for both the past and the future
    if($renew_err_flg == false){

        //前回の月次更新日を取得 acquire the previous monthly udpate date
        $sql  = "SELECT \n";
        $sql .= "    close_day \n";
        $sql .= "FROM \n";
        $sql .= "    t_sys_renew \n";
        $sql .= "WHERE \n";
        $sql .= "    shop_id = ".$shop_id." \n";
        $sql .= "    AND \n";
        $sql .= "    renew_div = '2' \n";
        $sql .= "ORDER BY \n";
        $sql .= "    close_day DESC \n";
        $sql .= "LIMIT 1 \n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        //前回月次がない（初回月次更新時）は「config.php」の「START_DAY」をセット if its the first monthy update, then set the config.php of START_DAY
        if(pg_num_rows($result) == 0){

            //自社締日が月末（29）ならユーザ入力の年月の最終日を求める if the closing day of the company is end of the month (29), then get the last day of the month the user inputted
            if($my_close_day == "29"){
                $post_close_day_d = date("t", mktime(0, 0, 0, $post_close_day_m, 1, $post_close_day_y));
            }else{
                $post_close_day_d = str_pad($my_close_day, 2, "0", STR_PAD_LEFT);
            }

            $user_close_day = $post_close_day_y."-".$post_close_day_m."-".$post_close_day_d;     //ユーザ入力年月の締める日付 the closing date of the year/month the user inputted

            //一番古い日付を取得 acquire the oldest date
            $sql  = "SELECT \n";
            $sql .= "    LEAST( \n";
            $sql .= "        (SELECT MIN(sale_day) FROM t_sale_h WHERE shop_id = $shop_id AND sale_day <= '$user_close_day'), \n";
            $sql .= "        (SELECT MIN(pay_day) FROM t_payin_h WHERE shop_id = $shop_id AND pay_day <= '$user_close_day'), \n";
            $sql .= "        (SELECT MIN(buy_day) FROM t_buy_h WHERE shop_id = $shop_id AND buy_day <= '$user_close_day'), \n";
            $sql .= "        (SELECT MIN(pay_day) FROM t_payout_h WHERE shop_id = $shop_id AND pay_day <= '$user_close_day') \n";
            $sql .= "    ) \n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            $least_day = pg_fetch_result($result, 0, 0);

            if($least_day == null){
                $form_input_err_msg = "更新年月以前に月次更新するデータが存在しません。";
                $renew_err_flg = true;
            }else{
                //データが存在する場合、一番古い日付は何年何月の月次更新なのか算出 If the data exists, compute for when the oldest date (y/m) of monthly update is 
                $least_day_y = substr($least_day, 0, 4);
                $least_day_m = substr($least_day, 5, 2);
                $least_day_d = substr($least_day, 8, 2);

                //自社締日が月末（29）でなく、一番古い日付の日が締日より大きい場合は、来月が月次更新しないといけない月 A month where the monthly update should be next month wherein the closing date of the company is not the end of the month, and the day of the oldest date is larger,
                if($my_close_day != "29" && $least_day_d > $my_close_day){
                    $least_day_m++;
                }
                $least_day_ym = date("Y-m", mktime(0, 0, 0, $least_day_m, 1, $least_day_y));

                //月次更新しないといけない年月とユーザ入力の年月が同じならおｋ if the date when the monthly update should happen is the same with the date the user inputted then Ok.
                if($least_day_ym != ($post_close_day_y."-".$post_close_day_m)){
                    $next_close_day = explode("-", $least_day_ym);
                    $form_input_err_msg = $next_close_day[0]."年".(int)$next_close_day[1]."月の月次更新が実施されていません。";
                    $renew_err_flg = true;
                }

            }
            //データがない場合はSTART_DAYを入れておく Put it in START_DAY if there is no data
            $close_day = START_DAY;

        //月次更新が既に実施されている場合 if monthly update is already completed 
        }else{
            $close_day = pg_fetch_result($result, 0, "close_day");  //前回の月次更新日 the date of the previous monthly update


            /* 入力された日付が月次更新してもいいかチェック */ check if the date inputted can be monthly updated
            //前回更新年月とユーザ入力年月の1ヶ月前を比較してイコールならおｋ if the date of the previous monthly update date and the date the user inputted is the same then goods.

            $close_day_y    = substr($close_day, 0, 4); //前回更新年 year of the previous udpate
            $close_day_m    = substr($close_day, 5, 2); //前回更新月 month of the previous update
            $close_day_ym   = substr($close_day, 0, 7); //前回更新年月 date of the previous update

            $post_close_day_ym = date("Y-m", mktime(0, 0, 0, $post_close_day_m -1, 1, $post_close_day_y));  //ユーザ入力年月- date the user inputted1

            if($close_day_ym != $post_close_day_ym){
                //違う場合は、実施済の年月か、未来の年月かチェック if they are different, check if the it's an updated date or a not updated date.

                $unix_close_day         = mktime(0, 0, 0, $close_day_m+1, 1, $close_day_y);
                $unix_post_close_day    = mktime(0, 0, 0, $post_close_day_m, 1, $post_close_day_y);

                if($unix_close_day >= $unix_post_close_day){
                    //月次更新済の年月が指定された、もしくはずっと以前の年月が指定された場合 if the already updated date or date way before the already updated date is inputted
                    $form_input_err_msg = "更新年月に月次更新済の年月が指定されています。";
                }else{
                    //未来の年月が指定された場合はどの年月の月次更新がされていないか表示 If the future date is inputted then display what month in the future is not yet udpated
                    $next_close_day = date("Y-n", mktime(0, 0, 0, $close_day_m +1, 1, $close_day_y));
                    $next_close_day = explode("-", $next_close_day);
                    $form_input_err_msg = $next_close_day[0]."年".$next_close_day[1]."月の月次更新が実施されていません。";
                }
                $renew_err_flg = true;

            }

        }

    }//月次更新年月チェック処理おわり End of monthly update check process


    //今回締日 Closing day 
    $next_close_day = $post_close_day_y."-".$post_close_day_m."-";
    if($my_close_day == "29"){
        $post_close_day_d = date("t", mktime(0, 0, 0, $post_close_day_m, 1, $post_close_day_y));
    }else{
        $post_close_day_d = $my_close_day;
    }
    $next_close_day .= str_pad($post_close_day_d, 2, "0", STR_PAD_LEFT);


    //日次更新してないデータがないかチェック check if the data is done with daily update
    if($renew_err_flg == false){

        //売上データチェック check sales data
        $sql  = "SELECT \n";
        $sql .= "    COUNT(sale_id) \n";
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";
        $sql .= "WHERE \n";
        //$sql .= "    ( \n";
        $sql .= "        (sale_day > '$close_day' AND sale_day <= '$next_close_day') \n";
        //$sql .= "        OR \n";
        //$sql .= "        (claim_day > '$close_day' AND claim_day <= '$next_close_day') \n";
        //$sql .= "    ) \n";
        $sql .= "    AND \n";
        $sql .= "    shop_id = $shop_id \n";
        $sql .= "    AND \n";
        $sql .= "    renew_flg = false\n";
        $sql .= ";";
//print_array($sql, "日次更新未実施チェック売上:");

        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, 0) !== "0"){
            $renew_day_sale_err_msg = "日次更新のされていない売上があります。";
            $renew_err_flg = true;
        }


        //仕入データチェック check the purchase data
        $sql  = "SELECT \n";
        $sql .= "    COUNT(buy_id) \n";
        $sql .= "FROM \n";
        $sql .= "    t_buy_h \n";
        $sql .= "WHERE \n";
        //$sql .= "    ( \n";
        //$sql .= "        (buy_day > '$close_day' AND buy_day <= '$next_close_day') \n";
        //$sql .= "        OR \n";
//        $sql .= "        (arrival_day > '$close_day' AND arrival_day <= '$next_close_day') \n";
        $sql .= "        (buy_day > '$close_day' AND buy_day <= '$next_close_day') \n";
        //$sql .= "    ) \n";
        $sql .= "    AND \n";
        $sql .= "    shop_id = $shop_id \n";
        $sql .= "    AND \n";
        $sql .= "    renew_flg = false\n";
        $sql .= ";";
//print_array($sql, "日次更新未実施チェック仕入:");

        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, 0) !== "0"){
            $renew_day_buy_err_msg = "日次更新のされていない仕入があります。";
            $renew_err_flg = true;
        }


        //入金データチェック check the deposit data
        $sql  = "SELECT \n";
        $sql .= "    COUNT(pay_id) \n";
        $sql .= "FROM \n";
        $sql .= "    t_payin_h \n";
        $sql .= "WHERE \n";
        $sql .= "    (pay_day > '$close_day' AND pay_day <= '$next_close_day') \n";
        $sql .= "    AND \n";
        $sql .= "    shop_id = $shop_id \n";
        $sql .= "    AND \n";
        $sql .= "    renew_flg = false\n";
        $sql .= ";";
//print_array($sql, "日次更新未実施チェック入金:");

        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, 0) !== "0"){
            $renew_day_payin_err_msg = "日次更新のされていない入金があります。";
            $renew_err_flg = true;
        }


        //支払データチェック check the payment data
        $sql  = "SELECT \n";
        $sql .= "    COUNT(pay_id) \n";
        $sql .= "FROM \n";
        $sql .= "    t_payout_h \n";
        $sql .= "WHERE \n";
        $sql .= "    (pay_day > '$close_day' AND pay_day <= '$next_close_day') \n";
        $sql .= "    AND \n";
        $sql .= "    shop_id = $shop_id \n";
        $sql .= "    AND \n";
        $sql .= "    renew_flg = false\n";
        $sql .= ";";
//print_array($sql, "日次更新未実施チェック支払:");

        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, 0) !== "0"){
            $renew_day_payout_err_msg = "日次更新のされていない支払があります。";
            $renew_err_flg = true;
        }

    }


    //これまでエラーがなければ棚卸更新、請求更新、仕入締更新のチェック If there is no error, check the inventory update processing, invoice update, and purchase closing update.
    if($renew_err_flg == false){

        //棚卸更新の終わっていない棚卸がないかチェック check if there are inventories that are not yet finished with inventory update
        $sql  = "SELECT COUNT(invent_id) \n";
        $sql .= "FROM t_invent \n";
        $sql .= "WHERE expected_day <= '$next_close_day' \n";
        $sql .= "AND renew_flg = false \n";
        $sql .= "AND shop_id = $shop_id \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        if(pg_fetch_result($result, 0, 0) !== "0"){
            $invent_err_msg = "棚卸更新のされていない棚卸があります。";
            $renew_err_flg = true;
        }


        //請求更新の終わっていない請求がないかチェック check if there are invoice that are not yet finished with invoice update
        $sql  = "SELECT bill_no \n";
        $sql .= "FROM t_bill \n";
        $sql .= "WHERE shop_id = $shop_id \n";
        $sql .= "    AND last_update_flg = false \n";
        $sql .= "    AND close_day > '$close_day' \n";
        $sql .= "    AND close_day <= '$next_close_day' \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $count = pg_num_rows($result);
        if($count != 0){
            for($i=0, $bill_err_msg = "以下の請求番号は請求更新されていません。<br>　　";$i<$count;$i++){
                $bill_err_msg .= pg_fetch_result($result, $i, "bill_no");
                $bill_err_msg .= (($i+1) % 10 == 0) ? "<br>　　" : " ";
            }
            $renew_err_flg = true;
        }

/*
        //締を終えていない仕入先がないかチェック check if there are purchases that are not yet closed
        $sql  = "SELECT \n";
        $sql .= "   t_client.close_day, \n";
        $sql .= "   COUNT(t_payment_make_history.close_day) AS close_day_count \n";
        $sql .= "FROM \n";
        $sql .= "   (SELECT \n";
        $sql .= "       '".$post_close_day_y."-".$post_close_day_m."-' || \n";
        $sql .= "       CASE \n";
        $sql .= "           WHEN t_client.close_day = '29' THEN \n";
        $sql .= "               SUBSTR(TO_DATE('".$post_close_day_y."-".$post_close_day_m."-' || 01, 'YYYY-MM-DD') \n";
        $sql .= "               + interval '1 month' - interval '1 day', 9, 2) \n";
        $sql .= "           ELSE lpad(t_client.close_day, '2', '0') \n";
        $sql .= "       END AS close_day \n";
        $sql .= "   FROM \n";
        $sql .= "       t_client \n";
        $sql .= "   WHERE \n";
        $sql .= ($group_kind == "1") ? "       client_div = '3' \n" : "       client_div = '2' \n";
        $sql .= "       AND \n";
        $sql .= "       shop_id = $shop_id \n";
        $sql .= "   ) AS t_client \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "   t_payment_make_history \n";
        $sql .= "   ON t_client.close_day = t_payment_make_history.payment_close_day \n";
        $sql .= "   AND \n";
        $sql .= "   t_payment_make_history.shop_id = $shop_id \n";
        $sql .= "GROUP BY \n";
        $sql .= "   t_client.close_day \n";
        $sql .= "ORDER BY \n";
        $sql .= "   t_client.close_day \n";
        $sql .= "; \n"; 

        $result = Db_Query($db_con, $sql);
        $payment_data = pg_fetch_all($result);

        foreach($payment_data AS $key => $val){
            //仕入締を行なっていない場合
            if($val["close_day_count"] == 0){

                //締処理が必要なリスト
                if($un_payment_list == null){
                    $un_payment_list  = $val["close_day"];
                }else{
                    $un_payment_list .= ", ".$val["close_day"];
                }

                $payment_err_flg = true;
            }
        }

        if($payment_err_flg === true){
            $payment_err_msg = $un_payment_list." で仕入締処理が行なわれていません。";
            $renew_err_flg   = true;
        }
*/

        //仕入締更新を行っていないかチェック check if the the purchase closing update is done
        $sql  = "SELECT \n";
        //$sql .= "    DISTINCT payment_close_day \n";
        $sql .= "    payment_close_day, \n";
        $sql .= "    client_cd1, \n";
        $sql .= "    client_cd2, \n";
        $sql .= "    client_cname \n";
        $sql .= "FROM \n";
        $sql .= "    t_schedule_payment \n";
        $sql .= "WHERE \n";
        //$sql .= "    payment_close_day > '$close_day' \n";
        //$sql .= "    AND \n";
        $sql .= "    payment_close_day <= '$next_close_day' \n";
        $sql .= "    AND \n";
        $sql .= "    last_update_flg = false \n";
        $sql .= "    AND \n";
        $sql .= "    first_set_flg = false \n";
        $sql .= "    AND \n";
        $sql .= "    shop_id = $shop_id \n";
        $sql .= "ORDER BY \n";
        $sql .= "    payment_close_day, \n";
        $sql .= "    client_cd1, \n";
        $sql .= "    client_cd2 \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $count = pg_num_rows($result);
        if($count != 0){
            for($i=0, $payment_close_day_tmp=null, $payment_err_msg=""; $i<$count; $i++){
                if($payment_close_day_tmp != pg_fetch_result($result, $i, "payment_close_day")){
                    $payment_close_day_tmp = pg_fetch_result($result, $i, "payment_close_day");

                    $payment_err_msg .= ($payment_err_msg != null) ? "<br>" : null;
                    $payment_err_msg .= pg_fetch_result($result, $i, "payment_close_day");
                    $payment_err_msg .= " 日締の以下の";
                    $payment_err_msg .= ($group_kind == "1") ? "取引先" : "仕入先";
                    $payment_err_msg .= "は仕入締更新されていません。";
                }

                $payment_err_msg .= "<br>　　";
                $payment_err_msg .= pg_fetch_result($result, $i, "client_cd1");
                if($group_kind == "1"){
                    $payment_err_msg .= "-";
                    $payment_err_msg .= pg_fetch_result($result, $i, "client_cd2");
                }
                $payment_err_msg .= " ";
                $payment_err_msg .= pg_fetch_result($result, $i, "client_cname");

            }
            $renew_err_flg = true;
        }


    }//棚卸更新、請求更新、仕入締更新のチェックおわり end of inventory, invoice, and purchase closing update check


    //エラーがなければ、こっからホントの月次更新処理が始まるよ If there is no error, this is the start of the monthly update process
    Db_Query($db_con,"BEGIN;");

    //自社の消費税率を取得
    #2010-01-05 aoyama-n
    #$sql = "SELECT tax_rate_n FROM t_client WHERE client_id = $shop_id;";
    #$result = Db_Query($db_con, $sql);
    #$tax_rate_n = (pg_num_rows($result) == 1) ? pg_fetch_result($result, 0, "tax_rate_n") : "";

    //売掛残高額を算出して登録 compute the receivable balance and register it 
    if($renew_err_flg == false){

        //前回締日以降から今回締日までの売掛残高などを計算 compute things like receivable balance starting from the previous closing day up to the current closing day
        $sql  = "
            SELECT 
                COALESCE(t_ar_balance_last.monthly_close_day_last, '".START_DAY."') AS monthly_close_day_last, 
                t_client.close_day, 
                t_client.pay_m, 
                t_client.pay_d, 
                t_all_client.client_id, 
                t_client.client_cd1, 
                t_client.client_cd2, 
                t_client.client_name AS client_name1, 
                t_client.client_name2, 
                t_client.client_cname, 
                COALESCE(t_ar_balance_last.ar_balance_last, 0) AS ar_balance_last, 
                COALESCE(t_payin_amount.payin_amount, 0) AS pay_amount, 
                COALESCE(t_payin_amount.tune_amount, 0) AS tune_amount, 
                ( COALESCE(t_ar_balance_last.ar_balance_last, 0) 
                  - COALESCE(t_payin_amount.payin_amount, 0) 
                  - COALESCE(t_payin_amount.tune_amount, 0) 
                ) AS rest_amount, 
                ( COALESCE(t_sale_amount.net_sale_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                ) AS net_sale_amount, 
                ( COALESCE(t_sale_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS tax_amount, 
                ( COALESCE(t_sale_amount.net_sale_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                  + COALESCE(t_sale_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS intax_sale_amount, 
                ( COALESCE(t_ar_balance_last.ar_balance_last, 0) 
                  - COALESCE(t_payin_amount.payin_amount, 0) 
                  - COALESCE(t_payin_amount.tune_amount, 0) 
                  + COALESCE(t_sale_amount.net_sale_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                  + COALESCE(t_sale_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS ar_balance_this, 
        ";
        //本部画面ではFC取引先マスタのSV、窓口担当1を担当者カラムに登録 In HQ, register in contact person field, the contact person 1 found in the SV row of master setting -> FC business partner
        if($group_kind == "1"){
            $sql .= "
                (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.sv_staff_id) AS staff1_name, 
                (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.b_staff_id1) AS staff2_name, 
            ";
        //FC画面では得意先マスタの契約担当1、契約担当2を担当者カラムに登録 In FC, register the contract assignee 1 and 2 found in the maseter setting->customer to the contact person input filed
        }else{
            $sql .= "
                (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id1) AS staff1_name, 
                (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id2) AS staff2_name, 
            ";
        }
        $sql .= "
                COALESCE(t_installment_balance.installment_receivable_balance, 0) AS installment_receivable_balance, 
                COALESCE(t_installment_sales.installment_sales_amount, 0) AS installment_sales_amount, 
                t_client.c_tax_div, 
                t_client.tax_franct, 
                t_client.coax, 
                t_client.tax_div 

            FROM 
        ";
        //締日以前に売上、入金、月次更新（売掛残高初期設定）のあった得意先IDを全て抽出 extract all the customer ID who had sales, deposit, or monthly update (accounts receivable balance initial setting) before the closing day.
        $sql .= "
                ( 
        ";
        $sql .= Monthly_All_Client_Sql($shop_id, "sale", $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_all_client 

                INNER JOIN t_client ON t_all_client.client_id = t_client.client_id 

        ";

        //前回月次更新時の月次更新日、売掛残高を抽出 extract the date when the previous monthly update was executed, and the accounts receivable balance.
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Balance_Last_Sql($shop_id, "sale");
        $sql .= "
                ) AS t_ar_balance_last ON t_all_client.client_id = t_ar_balance_last.client_id 

        ";

        //前回締日から今回締日までの売上額（税抜）、消費税額を抽出 extract the sales (no tax) and the tax amount. starting from the previous closing day up to the current closing day.
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Sale_Amount_Sql($shop_id, $close_day, $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_sale_amount ON t_all_client.client_id = t_sale_amount.client_id

        ";

        //前回締日から今回締日までの入金額（除調整額）、調整額を抽出 extract the deposited amount (not yet adjusted) and the adjusting amount starting from the previous closing day up to current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Payin_Amount_Sql($shop_id, $close_day, $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_payin_amount ON t_all_client.client_id = t_payin_amount.client_id 

        ";

        //今回締日までの全割賦売上のうち、今回締日以降の未回収額 the amount not yet collected in the installement sales from the current closing day to the future.
        $sql .= "
                LEFT JOIN 
                ( 
                    SELECT 
                        t_sale_h.client_id, 
                        SUM(t_installment_sales.collect_amount) AS installment_receivable_balance 
                    FROM 
                        t_sale_h 
                        INNER JOIN t_installment_sales ON t_sale_h.sale_id = t_installment_sales.sale_id 
                    WHERE 
                        t_sale_h.shop_id = $shop_id 
                        AND 
                        t_sale_h.trade_id = 15 
                        AND 
                        t_sale_h.sale_day <= '$next_close_day' 
                        AND 
                        t_installment_sales.collect_day > '$next_close_day' 
                    GROUP BY 
                        t_sale_h.client_id 
                ) AS t_installment_balance ON t_all_client.client_id = t_installment_balance.client_id 

        ";
        //前回締日から今回締日までの割賦売上額（税込）を抽出 extract the installement sales (with tax) starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
                    SELECT 
                        client_id, 
                        SUM(net_amount + tax_amount) AS installment_sales_amount 
                    FROM 
                        t_sale_h 
                    WHERE 
                        shop_id = $shop_id 
                        AND 
                        trade_id = 15 
                        AND 
                        sale_day > '$close_day' 
                        AND 
                        sale_day <= '$next_close_day' 
                    GROUP BY 
                        client_id 
                ) AS t_installment_sales ON t_all_client.client_id = t_installment_sales.client_id 

        ";

        //前回締日から今回締日までのロイヤリティ額とその消費税額を抽出 extract the royalty and its tax amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Lump_Amount_Sql($shop_id, $close_day, $next_close_day, "1", "sale");
        $sql .= "
                ) AS t_royalty ON t_all_client.client_id = t_royalty.client_id 

        ";

        //前回締日から今回締日までの一括消費税額を抽出 extract the total tax amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Lump_Amount_Sql($shop_id, $close_day, $next_close_day, "2", "sale");
        $sql .= "
                ) AS t_adjust_tax ON t_all_client.client_id = t_adjust_tax.client_id 

        ";

        $sql .= "
            ORDER BY 
                t_all_client.client_id 

            ;
        ";
//print_array($sql, "売掛集計SQL：");

        $result = Db_Query($db_con, $sql); 
        //$ar_balance = Get_Data($result, 2);
        $ar_balance = pg_fetch_all($result);
//print_array($ar_balance);


        //得意先数分、月次売掛残高テーブルに書き込む write as many times as there are customers in the monthly update table 
        //$count = count($ar_balance);
        $count = pg_num_rows($result);

        for($i=0;$i<$count;$i++){

            #2010-01-05 aoyama-n
            //消費税率取得 acquire the tax rate
            $tax_rate_obj->setTaxRateDay($next_close_day);
            $tax_rate_n = $tax_rate_obj->getClientTaxRate($ar_balance[$i]["client_id"]);

            $sql  = "
                INSERT INTO 
                    t_ar_balance 
                ( 
                    ar_balance_id, 
                    monthly_close_day_last, 
                    monthly_close_day_this, 
                    close_day, 
                    pay_m, 
                    pay_d, 
                    client_id, 
                    client_cd1, 
                    client_cd2, 
                    client_name1, 
                    client_name2, 
                    client_cname, 
                    ar_balance_last, 
                    pay_amount, 
                    tune_amount, 
                    rest_amount, 
                    net_sale_amount, 
                    tax_amount, 
                    intax_sale_amount, 
                    ar_balance_this, 
                    staff1_name, 
                    staff2_name, 
                    installment_receivable_balance, 
                    installment_sales_amount, 
                    shop_id, 
                    tax_rate_n, 
                    c_tax_div, 
                    tax_franct, 
                    coax, 
                    tax_div 
                ) VALUES ( 
                    (SELECT COALESCE(MAX(ar_balance_id), 0)+1 FROM t_ar_balance), 
                    '".$ar_balance[$i]["monthly_close_day_last"]."', 
                    '".$next_close_day."', 
                    '".$ar_balance[$i]["close_day"]."', 
                    '".$ar_balance[$i]["pay_m"]."', 
                    '".$ar_balance[$i]["pay_d"]."', 
                    ".$ar_balance[$i]["client_id"].", 
                    '".$ar_balance[$i]["client_cd1"]."', 
                    '".$ar_balance[$i]["client_cd2"]."', 
                    '".addslashes($ar_balance[$i]["client_name1"])."', 
                    '".addslashes($ar_balance[$i]["client_name2"])."', 
                    '".addslashes($ar_balance[$i]["client_cname"])."', 
                    ".$ar_balance[$i]["ar_balance_last"].", 
                    ".$ar_balance[$i]["pay_amount"].", 
                    ".$ar_balance[$i]["tune_amount"].", 
                    ".$ar_balance[$i]["rest_amount"].", 
                    ".$ar_balance[$i]["net_sale_amount"].", 
                    ".$ar_balance[$i]["tax_amount"].", 
                    ".$ar_balance[$i]["intax_sale_amount"].", 
                    ".$ar_balance[$i]["ar_balance_this"].", 
                    '".addslashes($ar_balance[$i]["staff1_name"])."', 
                    '".addslashes($ar_balance[$i]["staff2_name"])."', 
                    ".$ar_balance[$i]["installment_receivable_balance"].", 
                    ".$ar_balance[$i]["installment_sales_amount"].", 
                    ".$shop_id.", 
                    '".$tax_rate_n."', 
                    '".$ar_balance[$i]["c_tax_div"]."', 
                    '".$ar_balance[$i]["tax_franct"]."', 
                    '".$ar_balance[$i]["coax"]."', 
                    '".$ar_balance[$i]["tax_div"]."' 
                );
            ";

//print_array($sql, "売掛残高テーブル登録SQL：");

            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con,"ROLLBACK;");
                $form_input_err_msg = "月次更新に失敗しました。<br>他のユーザが月次更新を行っていないか確認の上、再度実行してください。";
                $renew_err_flg = true;
                break;
            }
        }
    }

    //買掛残高額を算出して登録 compute the account (payabale) balance default setting 
    if($renew_err_flg == false){

        //前回締日以降から今回締日までの買掛残高などを計算 extract the total account payable balance starting from the previous closing day up to the current closing day
        $sql  = "
            SELECT 
                COALESCE(t_ap_balance_last.monthly_close_day_last, '".START_DAY."') AS monthly_close_day_last, 
                t_client.close_day, 
                t_client.payout_m, 
                t_client.payout_d, 
                t_all_client.client_id, 
                t_client.client_cd1, 
                t_client.client_cd2, 
                t_client.client_name AS client_name1, 
                t_client.client_name2, 
                t_client.client_cname, 
                COALESCE(t_ap_balance_last.ap_balance_last, 0) AS ap_balance_last, 
                COALESCE(t_payout_amount.payout_amount, 0) AS pay_amount, 
                COALESCE(t_payout_amount.tune_amount, 0) AS une_amount, 
                ( COALESCE(t_ap_balance_last.ap_balance_last, 0) 
                  - COALESCE(t_payout_amount.payout_amount, 0) 
                  - COALESCE(t_payout_amount.tune_amount, 0) 
                ) AS rest_amount, 
                ( COALESCE(t_buy_amount.net_buy_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                ) AS net_buy_amount, 
                ( COALESCE(t_buy_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS tax_amount, 
                ( COALESCE(t_buy_amount.net_buy_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                  + COALESCE(t_buy_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS intax_buy_amount, 
                ( COALESCE(t_ap_balance_last.ap_balance_last, 0) 
                  - COALESCE(t_payout_amount.payout_amount, 0) 
                  - COALESCE(t_payout_amount.tune_amount, 0) 
                  + COALESCE(t_buy_amount.net_buy_amount, 0) 
                  + COALESCE(t_royalty.royalty_price, 0) 
                  + COALESCE(t_buy_amount.tax_amount, 0) 
                  + COALESCE(t_royalty.royalty_tax, 0) 
                  + COALESCE(t_adjust_tax.adjust_tax, 0) 
                ) AS ap_balance_this, 
                CASE t_client.client_div 
                    WHEN '2' 
                    THEN (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id1) 
                    ELSE (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.sv_staff_id) 
                END AS staff1_name, 
                COALESCE(t_amortization_trade_balance.amortization_trade_balance, 0) AS amortization_trade_balance, 
                COALESCE(t_amortization_buy.amortization_amount, 0) AS amortization_amount, 
                t_client.c_tax_div, 
                t_client.tax_franct, 
                t_client.coax, 
                t_client.tax_div, 
                t_client.client_div 

            FROM 
        ";
        //締日以前に仕入、支払、月次更新（買掛残高初期設定）のあった仕入先IDを全て抽出 extract all supplier (client) ID which had a purchase, payment, or monthly update (account (payable) balance initial setting before the closing day
        $sql .= "
                ( 
        ";
        $sql .= Monthly_All_Client_Sql($shop_id, "buy", $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_all_client 
                INNER JOIN t_client ON t_all_client.client_id = t_client.client_id 
        ";

        //前回月次更新時の月次更新日、買掛残高を抽出 extract the date when the previous monthly update was executed, as well as the account payable balance
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Balance_Last_Sql($shop_id, "buy");
        $sql .= "
                ) AS t_ap_balance_last ON t_all_client.client_id = t_ap_balance_last.client_id 
        ";

        //前回締日から今回締日までの仕入額（税抜）、消費税額を抽出 extract the purchase amount (tax excluded) and the tax amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Buy_Amount_Sql($shop_id, $close_day, $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_buy_amount ON t_all_client.client_id = t_buy_amount.client_id
        ";

        //前回締日から今回締日までの支払額（除調整額）、調整額を抽出 extract the payment amount (not yet adjusted) and the adjustment amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Payout_Amount_Sql($shop_id, $close_day, $next_close_day, $renew_flg);
        $sql .= "
                ) AS t_payout_amount ON t_all_client.client_id = t_payout_amount.client_id 
        ";

        //今回締日までの全割賦仕入のうち、今回締日以降の未回収額 the amount not yet collected in the installement supply(purchase) starting from the current closing day into the future
        $sql .= "
                LEFT JOIN 
                ( 
                    SELECT 
                        t_buy_h.client_id, 
                        SUM(t_amortization.split_pay_amount) AS amortization_trade_balance 
                    FROM 
                        t_buy_h 
                        INNER JOIN t_amortization ON t_buy_h.buy_id = t_amortization.buy_id 
                    WHERE 
                        t_buy_h.shop_id = $shop_id 
                        AND 
                        t_buy_h.trade_id = 25 
                        AND 
                        t_buy_h.buy_day <= '$next_close_day' 
                        AND 
                        t_amortization.pay_day > '$next_close_day' 
                    GROUP BY 
                        t_buy_h.client_id 
                ) AS t_amortization_trade_balance ON t_all_client.client_id = t_amortization_trade_balance.client_id 
        ";

        //前回締日から今回締日までの割賦仕入額（税込）を抽出 extract the installement purchase amount (with tax) starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
                    SELECT 
                        client_id, 
                        SUM(net_amount + tax_amount) AS amortization_amount 
                    FROM 
                        t_buy_h 
                    WHERE 
                        shop_id = $shop_id 
                        AND 
                        trade_id = 25 
                        AND 
                        buy_day > '$close_day' 
                        AND 
                        buy_day <= '$next_close_day' 
                    GROUP BY 
                        client_id 
                ) AS t_amortization_buy ON t_all_client.client_id = t_amortization_buy.client_id 

        ";

        //前回締日から今回締日までのロイヤリティ額とその消費税額を抽出 extract the royalty and its tax amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Lump_Amount_Sql($shop_id, $close_day, $next_close_day, "1", "buy");
        $sql .= "
                ) AS t_royalty ON t_all_client.client_id = t_royalty.client_id 

        ";

        //前回締日から今回締日までの一括消費税額を抽出 extract the total tax amount starting from the previous closing day up to the current closing day
        $sql .= "
                LEFT JOIN 
                ( 
        ";
        $sql .= Monthly_Lump_Amount_Sql($shop_id, $close_day, $next_close_day, "2", "buy");
        $sql .= "
                ) AS t_adjust_tax ON t_all_client.client_id = t_adjust_tax.client_id 

        ";

        $sql .= "
            ORDER BY 
                t_all_client.client_id 
            ;
        ";
//print_array($sql, "買掛集計SQL：");

        $result = Db_Query($db_con, $sql); 
        //$ap_balance = Get_Data($result, 2);
        $ap_balance = pg_fetch_all($result);
//print_array($ap_balance);


        //仕入先数分、月次買掛残高テーブルに書き込む
        //$count = count($ap_balance);
        $count = pg_num_rows($result);
        for($i=0;$i<$count;$i++){

            #2010-01-05 aoyama-n
            //消費税率取得
            $tax_rate_obj->setTaxRateDay($next_close_day);
            $tax_rate_n = $tax_rate_obj->getClientTaxRate($ap_balance[$i]["client_id"]);

            $sql  = "
                INSERT INTO 
                    t_ap_balance 
                ( 
                    ap_balance_id, 
                    monthly_close_day_last, 
                    monthly_close_day_this, 
                    close_day, 
                    payout_m, 
                    payout_d, 
                    client_id, 
                    client_cd1, 
                    client_cd2, 
                    client_name1, 
                    client_name2, 
                    client_cname, 
                    ap_balance_last, 
                    pay_amount, 
                    tune_amount, 
                    rest_amount, 
                    net_buy_amount, 
                    tax_amount, 
                    intax_buy_amount, 
                    ap_balance_this, 
                    staff1_name, 
                    amortization_trade_balance, 
                    amortization_amount, 
                    shop_id, 
                    tax_rate_n, 
                    c_tax_div, 
                    tax_franct, 
                    coax, 
                    tax_div, 
                    client_div 
                ) VALUES ( 
                    (SELECT COALESCE(MAX(ap_balance_id), 0)+1 FROM t_ap_balance), 
                    '".$ap_balance[$i]["monthly_close_day_last"]."', 
                    '".$next_close_day."', 
                    '".$ap_balance[$i]["close_day"]."', 
                    '".$ap_balance[$i]["payout_m"]."', 
                    '".$ap_balance[$i]["payout_d"]."', 
                    ".$ap_balance[$i]["client_id"].", 
                    '".$ap_balance[$i]["client_cd1"]."', 
                    '".$ap_balance[$i]["client_cd2"]."', 
                    '".addslashes($ap_balance[$i]["client_name1"])."', 
                    '".addslashes($ap_balance[$i]["client_name2"])."', 
                    '".addslashes($ap_balance[$i]["client_cname"])."', 
                    ".$ap_balance[$i]["ap_balance_last"].", 
                    ".$ap_balance[$i]["pay_amount"].", 
                    ".$ap_balance[$i]["tune_amount"].", 
                    ".$ap_balance[$i]["rest_amount"].", 
                    ".$ap_balance[$i]["net_buy_amount"].", 
                    ".$ap_balance[$i]["tax_amount"].", 
                    ".$ap_balance[$i]["intax_buy_amount"].", 
                    ".$ap_balance[$i]["ap_balance_this"].", 
                    '".addslashes($ap_balance[$i]["staff1_name"])."', 
                    ".$ap_balance[$i]["amortization_trade_balance"].", 
                    ".$ap_balance[$i]["amortization_amount"].", 
                    ".$shop_id.", 
                    '".$tax_rate_n."', 
                    '".$ap_balance[$i]["c_tax_div"]."', 
                    '".$ap_balance[$i]["tax_franct"]."', 
                    '".$ap_balance[$i]["coax"]."', 
                    '".$ap_balance[$i]["tax_div"]."', 
                    '".$ap_balance[$i]["client_div"]."' 
                );
            ";

//print_array($sql, "買掛残高テーブル登録SQL：");

            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con,"ROLLBACK;");
                $form_input_err_msg = "月次更新に失敗しました。<br>他のユーザが月次更新を行っていないか確認の上、再度実行してください。";
                $renew_err_flg = true;
                break;
            }
        }
    }


    //最後に更新処理履歴テーブルに登録 lastly, registeer it in the update process history table
    if($renew_err_flg == false){

        $sql  = "INSERT INTO \n";
        $sql .= "    t_sys_renew \n";
        $sql .= "( \n";
        $sql .= "    renew_id, \n";
        $sql .= "    renew_div, \n";
        $sql .= "    renew_time, \n";
        $sql .= "    close_day, \n";
        $sql .= "    shop_id, \n";
        $sql .= "    operation_staff_name \n";
        $sql .= ") VALUES ( \n";
        $sql .= "    (SELECT COALESCE(MAX(renew_id), 0)+1 FROM t_sys_renew), \n";
        $sql .= "    '2', \n";
        $sql .= "    CURRENT_TIMESTAMP, \n";
        $sql .= "    '$next_close_day', \n";
        $sql .= "    $shop_id, \n";
        $sql .= "    '".addslashes($staff_name)."' \n";
        $sql .= ");";

        $result = Db_Query($db_con, $sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            $form_input_err_msg = "他のユーザが同時に更新処理を行ったため、月次更新に失敗しました。もう一度実行して下さい。";
            $renew_err_flg = true;
        }

    }

    //エラーなく終了すればコメットさん if the process ends with no error then commit
    if($renew_err_flg == false){
        Db_Query($db_con,"COMMIT;");
        $complete_msg = "月次更新処理が完了しました。";
    }

}



/****************************/
//画面表示のテーブル取得 acquire the screen display's table
/****************************/

$sql  = "SELECT \n";
$sql .= "    SUBSTR(close_day, 1, 7) AS close_ym, \n";
$sql .= "    SUBSTR(close_day, 9, 2) AS close_d, \n";
$sql .= "    SUBSTR(renew_time, 1, 19) AS renew_time \n";
$sql .= "FROM \n";
$sql .= "    t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "    shop_id = ".$shop_id." \n";
$sql .= "    AND renew_div = '2' \n";
$sql .= "ORDER BY \n";
$sql .= "    close_day DESC \n";
$sql .= "LIMIT $list_row_num \n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
if(pg_num_rows($result) !== 0){
    $rec_data = Get_Data($result);
    for($i=0;$i<count($rec_data);$i++){
        $rec_data[$i][1] = ($rec_data[$i][1] >= "29") ? "月末" : (int)$rec_data[$i][1]."日";
    }
}



/****************************/
//HTMLヘッダ HTML header
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title,"amenity.js", "global.css", "", "ie8");

/****************************/
//HTMLフッタ HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
//$page_menu = Create_Menu_h('renew','1');

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_header = Create_Header($page_title);


//print_array($_POST);


// Render関連の設定 render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variables
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'renew_err_flg' => "$renew_err_flg",
    'form_input_err_msg'    => "$form_input_err_msg",
    'start_day_err_msg'     => "$start_day_err_msg",
    'complete_msg'  => "$complete_msg",
    'renew_day_sale_err_msg'    => "$renew_day_sale_err_msg",
    'renew_day_buy_err_msg'     => "$renew_day_buy_err_msg",
    'renew_day_payin_err_msg'   => "$renew_day_payin_err_msg",
    'renew_day_payout_err_msg'  => "$renew_day_payout_err_msg",
    'invent_err_msg'    => "$invent_err_msg",
    'bill_err_msg'  => $bill_err_msg,
    'payment_err_msg' => "$payment_err_msg",
));

// 一覧用レコードデータをテンプレートへ渡す pass the record data for the list to template
$smarty->assign("rec_data", $rec_data);


//テンプレートへ値を渡す pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
