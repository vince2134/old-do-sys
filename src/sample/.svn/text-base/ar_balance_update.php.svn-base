<?php
$page_title = "売掛残高登録・変更ページ";
require_once("ENV_local.php");
$db_con = Db_Connect();
$form =& new HTML_QuickForm("dateForm","POST","$_SERVER[PHP_SELF]");
$disabled   = ($auth[0] == "r") ? "disabled" : null;
/**************************/
//フォーム作成
/**************************/
$form->addElement("text","form_shop_id","","style='$g_form_style' maxlength=6 size=6 $g_form_option");
$form->addElement("text","form_client_id","","style='$g_form_style' maxlength=6 size=6 $g_form_option");
$date[] =& $form->createElement("text","year","","size=4 maxlength=4 style='$g_form_style' $g_form_option");
$date[] =& $form->createElement("static","","","-");
$date[] =& $form->createElement("text","month","","size=2 maxlength=2 style='$g_form_style' $g_form_option");
$date[] =& $form->createElement("static","","","-");
$date[] =& $form->createElement("text","day","","size=2 maxlength=2 style='$g_form_style' $g_form_option");
$form->addGroup($date,"form_monthly_close_day_this","form_monthly_close_day_this");
$form->addElement("text","form_ar_balance","","style='$g_form_style' maxlength=20 size=20 $g_form_option");
$form->addElement("text","form_staff_name","","maxlength=20 size=20 $g_form_option");
$form->addElement("checkbox","form_bill_chk");
$form->addElement("submit","update_btn","確　認");
$form->addElement("button","reset","リセット","onclick=\"javascript:location.href('$_SERVER[PHP_SELF]')\" ");
$form->addElement("hidden","check_flg",null);
$form->addElement("hidden","day_flg",null);

//print_array($_POST);
//ボタン押下
if($_POST['update_btn'] != "" || $_POST['exe_btn'] != ""){
Db_Query($db_con,"BEGIN;");

    //POSTを取得
    $year = $_POST['form_monthly_close_day_this']['year'];     //年
    $month = $_POST['form_monthly_close_day_this']['month'];    //月
    $day = $_POST['form_monthly_close_day_this']['day'];      //日
    $client_id = $_POST['form_client_id'];               //クライアントID
    $ar_balance = $_POST['form_ar_balance'];             //売掛残高
    $shop_id = $_POST['form_shop_id'];                   //ショップID
    $input_flg = true;                              //入力値チェックフラグ
    $staff_name = $_POST['form_staff_name'];        //スタッフ名
    $check_flg = $_POST['check_flg'];               //チェックフラグ

    //日付チェック
    //全部入力されているか
    if($year == "" || $month == "" || $day == ""){
        $day_flg = null;
    //正しい日付か
    }elseif(checkdate($month,$day,$year)){
        $day_flg = true;
        $monthly_close_day_this = $year."-".$month."-".$day;
    //正しくない
    }else{
        $day_flg = false;
    }

//print $day_flg;
    //クライアントIDが入力されているか
    if($client_id == ""){
        $input_flg = false;
    }

    //買掛残高が入力されていて、数値かどうか
    if($ar_balance =="" && is_numeric($ar_balance) != true){
        $input_flg = false;
    }

    //入力値が正しく、日付が空か正しい場合
    if($input_flg && ($day_flg == null||$day_flg == true)){
        //請求が起こってるか検索するsql
        $bill_sql  = "SELECT ";
        $bill_sql .= "  * ";
        $bill_sql .= "FROM ";
        $bill_sql .= "  t_bill ";
        $bill_sql .= "WHERE ";
        $bill_sql .= " claim_id = $client_id ";
        $bill_sql .= ";";

        $d_bill_sql  = "SELECT ";
        $d_bill_sql .= "  * ";
        $d_bill_sql .= "FROM ";
        $d_bill_sql .= "  t_bill_d ";
        $d_bill_sql .= "LEFT JOIN t_bill ";
        $d_bill_sql .= "ON t_bill_d.bill_id = t_bill.bill_id ";
        $d_bill_sql .= "WHERE ";
        $d_bill_sql .= " client_id = $client_id ";
        $d_bill_sql .= " AND t_bill.first_set_flg = 'f'";
        $d_bill_sql .= ";";

        $res = Db_Query($db_con,$bill_sql);
        $cnt = pg_num_rows($res);
        $res = Db_Query($db_con,$d_bill_sql);
        $cnt2 = pg_num_rows($res);
        
        if($cnt > 0 || $cnt2 > 0){
            $err_msg =  "※請求済みです！";
        }else{
            //請求が起きてなければ、登録か変更か検索するsqlを発行
            $search_sql  = "SELECT ";
            $search_sql .= "    * ";
            $search_sql .= "FROM ";
            $search_sql .= "   t_first_ar_balance ";
            $search_sql .= "WHERE ";
            $search_sql .= "   client_id = $client_id ";
            $search_sql .= ";";

            $search_sql2  = "SELECT ";
            $search_sql2 .= "   * ";
            $search_sql2 .= "FROM ";
            $search_sql2 .= "   t_ar_balance ";
            $search_sql2 .= "WHERE ";
            $search_sql2 .= "   client_id = $client_id";
            $search_sql2 .= ";";

            $res = Db_Query($db_con,$search_sql);
            $cnt = pg_num_rows($res);
            $res = Db_Query($db_con,$search_sql2);
            $cnt2 = pg_num_rows($res);
            
            if($cnt > 0 && $cnt2 > 0){
                //更新の場合は、前回の金額を表示するために保持しておく
                $befor = pg_fetch_array($res,0);
                $bef = $befor['ar_balance_this'];
                $form->addElement("submit","exe_btn","更　新");
                $set_data['check_flg'] = true;
                $set_data['day_flg'] = $day_flg;
                $form->setConstants($set_data);
                $btn_push = "売掛残高を変更します。".number_format($bef)." → ".number_format($ar_balance);
                
            }else{
                $btn_push = "売掛残高を新規登録します。";
                $set_data['check_flg']=true;
                $set_data['day_flg'] = $day_flg;
                $form->setConstants($set_data);
                $form->addElement("submit","exe_btn","新　規");
            }
            //更新ボタン押下、入力値チェックがＯＫの場合
            if($_POST['exe_btn'] == "更　新" && $_POST['check_flg']==true){
                //初期売掛残高テーブル更新sql
                $sql_f  = "UPDATE ";
                $sql_f .= "   t_first_ar_balance ";
                $sql_f .= "SET ";
                $sql_f .= "   ar_balance = $ar_balance ";
                $sql_f .= "WHERE ";
                $sql_f .= "   client_id = $client_id ";
                $sql_f .= ";";
    
                $sql_ar  = "UPDATE ";
                $sql_ar .= "    t_ar_balance ";
                $sql_ar .= "SET ";
                $sql_ar .= "    ar_balance_this = $ar_balance ";
                if($day_flg == true){
                    $sql_ar .= "    ,monthly_close_day_this = '$monthly_close_day_this' ";
                }
                $sql_ar .= "WHERE ";
                $sql_ar .= "    client_id = $client_id ";
                $sql_ar .= ";";
                $res = Db_Query($db_con,$sql_f);
                if($res === false){
                    Db_Query($db_con,"ROLLBACK;");
                    print "エラー１".$sql_f;
                    exit;
                }
                $res = Db_Query($db_con,$sql_ar);
                if($res === false){
                    Db_Query($db_con,"ROLLBACK;");
                    print "エラー２".$sql_ar;
                    exit;
                }
                    $ar_fin_msg =  "売掛残高初期設定のＵＰＤＡＴＥ完了！";
                    $exit_flg = true;
            //新規ボタン押下、入力値チェック・日付チェックともにＯＫの場合
            }elseif($_POST['exe_btn']=="新　規" && $_POST['check_flg']==true && $day_flg==true){
                //初期売掛残高テーブル追加sql
                $sql  = "INSERT INTO t_first_ar_balance (";
                $sql .= "   ar_balance,";
                $sql .= "   client_id,";
                $sql .= "   shop_id";
                $sql .= ") VALUES (";
                $sql .= "   $ar_balance,";
                $sql .= "   $client_id,";
                $sql .= "   $shop_id";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                //得意先の情報を取得
                $sql  = "
                    SELECT
                        t_client.close_day,
                        t_client.pay_m,
                        t_client.pay_d,
                        t_client.client_cd1,
                        t_client.client_cd2,
                        t_client.client_name AS client_name1,
                        t_client.client_name2,
                        t_client.client_cname,
                        t_staff1.staff_name AS staff1_name,
                        t_staff2.staff_name AS staff2_name,
                        t_client.c_tax_div,
                        t_client.tax_franct,
                        t_client.coax,
                        t_client.tax_div
                    FROM
                        t_client
                        LEFT JOIN t_staff AS t_staff1 ON t_client.sv_staff_id = t_staff1.staff_id
                        LEFT JOIN t_staff AS t_staff2 ON t_client.b_staff_id1 = t_staff2.staff_id
                    WHERE
                        t_client.client_id = $client_id
                    ;
                ";
    
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                $client_data = pg_fetch_array($result);
    
                foreach ($client_data as $key => $value){
                    $client_data[$key] = addslashes($value);
                }
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
                        '".START_DAY."',
                        '$monthly_close_day_this',
                        '".$client_data["close_day"]."',
                        '".$client_data["pay_m"]."',
                        '".$client_data["pay_d"]."',
                        $client_id,
                        '".$client_data["client_cd1"]."',
                        '".$client_data["client_cd2"]."',
                        '".$client_data["client_name1"]."',
                        '".$client_data["client_name2"]."',
                        '".$client_data["client_cname"]."',
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        $ar_balance,
                        '".$client_data["staff1_name"]."',
                        '".$client_data["staff2_name"]."',
                        0,
                        0,
                        $shop_id,
                         (SELECT tax_rate_n FROM t_client WHERE client_id = $shop_id),
                        '".$client_data["c_tax_div"]."',
                        '".$client_data["tax_franct"]."',
                        '".$client_data["coax"]."',
                        '".$client_data["tax_div"]."'
                    );
                ";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                $ar_fin_msg =  "売掛残高のINSERT完了！";
                $exit_flg = true;
            }
            //請求初期設定にチェックがついていて、売掛設定が完了している
            if($_POST['form_bill_chk'] == true && $exit_flg == true){
                //スタッフ名・売掛残高が空白でない場合
                if($staff_name != "" && $ar_balance != "" ){
                    //二重登録をチェック
                    $sql  = "SELECT";
                    $sql .= "   COUNT(t_bill_d.bill_d_id) \n";
                    $sql .= "FROM\n";
                    $sql .= "   t_bill\n";
                    $sql .= "       INNER JOIN\n";
                    $sql .= "   t_bill_d\n";
                    $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id\n";
                    $sql .= "WHERE\n";
                    $sql .= "   t_bill.first_set_flg = 't'\n";
                    $sql .= "   AND\n";
                    $sql .= "   t_bill.shop_id = $shop_id\n";
                    $sql .= "   AND\n";
                    $sql .= "   t_bill_d.client_id = $client_id\n";

                    $result = Db_Query($db_con, $sql);
                    $add_count = pg_fetch_result($result,0,0);
                    //登録済みの場合は変更
                    if($add_count > 0){
                        $sql  = "UPDATE ";
                        $sql .= "  t_bill_d  ";
                        $sql .= "SET ";
                        $sql .= "   bill_amount_this = $ar_balance ";
                        $sql .= "WHERE ";
                        $sql .= "   bill_id = (";
                        $sql .= "        select t_bill_d.bill_id from t_bill ";
                        $sql .= "       inner join t_bill_d on t_bill.bill_id = t_bill_d.bill_id ";
                        $sql .= "       where t_bill.first_set_flg = 't' and t_bill.shop_id = $shop_id and ";
                        $sql .= "       t_bill_d.client_id = $client_id)";
                        $bill_fin_msg =  "<br>\n請求残高初期設定をUPDATE！";
                        $res = Db_Query($db_con,$sql);
                        if($res === false){
                            Db_Query($db_con,"ROLLBACK");
                            print "UPDATE ERR";
                            exit;
                        }
                    //未登録の場合は新規
                    }elseif($day_flg == true){
                        //請求書番号抽出
                        $sql  = "SELECT";
                        $sql .= "   MAX(bill_no)\n";
                        $sql .= "FROM";
                        $sql .= "   t_bill\n";
                        $sql .= "WHERE\n";
                        $sql .= "   first_set_flg = 't'\n";
                        $sql .= "   AND\n";
                        $sql .= "   shop_id = $shop_id\n";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $max_no = pg_fetch_result($result,0,0)+1;
                        //抽出した連番を8桁になるように左側を0埋めする
                        $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);

                        $sql  = "INSERT INTO t_bill(";
                        $sql .= "   bill_id,";              //請求ID
                        $sql .= "   bill_no,";              //請求書番号
                        $sql .= "   fix_flg,";              //確定フラグ
                        $sql .= "   last_update_flg,";      //更新フラグ
                        $sql .= "   last_update_day,";      //更新実施日
                        $sql .= "   create_staff_name,";    //請求でデータ作成日
                        $sql .= "   fix_day,";              //確定日
                        $sql .= "   shop_id,";              //取引先ID
                        $sql .= "   first_set_flg";         //残高設定フラグ
                        $sql .= ")VALUES(";
                        $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),";
                        $sql .= "   '$claim_sheet_no',";
                        $sql .= "   't',";
                        $sql .= "   't',";
                        $sql .= "   NOW(),";
                        $sql .= "   '$staff_name',";
                        $sql .= "   NOW(),";
                        $sql .= "   $shop_id,";
                        $sql .= "   't'";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            $err_message = pg_last_error();
                            $err_format = "t_bill_bill_no_key";
                            Db_Query($db_con, "ROLLBACK");

                            //請求NOが重複した場合
                            if(strstr($err_message,$err_format) !== false){
                                print "同時に請求残高を行ったため、登録できませんでした。再度設定
してください。";
                                $duplicate_err = true;
                                break;
                            }else{
                                exit;
                            }
                        }
                        //請求データに登録
                        $sql  = "INSERT INTO t_bill_d(";
                        $sql .= "   bill_d_id,";
                        $sql .= "   bill_id,";
                        $sql .= "   bill_close_day_this,";
                        $sql .= "   client_id,";
                        $sql .= "   claim_div,";
                        $sql .= "   bill_amount_this";
                        $sql .= ")VALUES(";
                        $sql .= "    (SELECT COALESCE(MAX(bill_d_id),0)+1 FROM t_bill_d),";
                        $sql .= "   (SELECT";
                        $sql .= "       bill_id";
                        $sql .= "   FROM";
                        $sql .= "       t_bill";
                        $sql .= "   WHERE";
                        $sql.= "       shop_id = $shop_id";
                        $sql .= "       AND";
                        $sql .= "       bill_no = '$claim_sheet_no'";
                        $sql .= "       AND";
                        $sql .= "       first_set_flg = 't'";
                        $sql .= "   ),";
                        $sql .= "   '".$monthly_close_day_this."',";
                        $sql .= "    $client_id,";
                        $sql .= "   '1',";
                        $sql .= "   $ar_balance";
                        $sql .= ");";

                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            print "INSERT ERR";
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                        $bill_fin_msg =  "<br>\n請求残高初期設定をINSERT！";
                    }
                }else{
                    $err_msg =  "※請求残高の入力項目が足りてません";
                }
            }
        }
    }else{
    $err_msg = "※入力してください。";
    }
if($exit_flg == true){
    $set_data['form_shop_id'] = "";
    $set_data['form_client_id'] = "";
    $set_data['form_monthly_close_day_this']['year'] = "";
    $set_data['form_monthly_close_day_this']['month'] = "";
    $set_data['form_monthly_close_day_this']['day'] = "";
    $set_data['form_ar_balance'] = "";
    $set_data['form_staff_name'] = "";
    $set_data['form_bill_chk'] = "";
    $set_data['check_flg'] = "";
    $form->setConstants($set_data);

}
Db_Query($db_con,"COMMIT;");
}
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
$page_menu = Create_Menu_h('buy','3');

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
        'html_header'               => "$html_header",
    'html'                      => "$html",
    'exit_flg'          => "$exit_flg",
    'btn_push'          => "$btn_push",
    'err_msg'           => "$err_msg",
    'ar_fin_msg'        => "$ar_fin_msg",
    'bill_fin_msg'      => "$bill_fin_msg",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));
$smarty->assign('ary_data',$ary);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>


