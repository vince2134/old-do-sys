<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/27　04-011　　　　watanabe-ｋ １０日締の請求書に対して8月2日で随時請求を行い、8月10で請求更新を行うとデータがありませんとなり、更新不可。 *   2006-12-09  ban_0111      suzuki      日付をゼロ埋め            
 *
 */

$page_title = "請求更新処理";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

$db_con = Db_Connect();


/*****************************/
// 権限関連処理
/*****************************/
// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
//外部変数を抽出
/*****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$staff_name = $_SESSION["staff_name"];

/****************************/
// フォームパーツ定義
/****************************/
// 実行ボタン
$form->addElement("submit", "form_add_button", "実　行", "onClick=\"javascript:return Dialogue('実行します。','$_SEVER[PHP_SELF]')\" $disabled");

//請求更新日
$sql  = "SELECT";
$sql .= "   DISTINCT substr(close_day, 9, 2)";
$sql .= " FROM";
$sql .= "   t_bill";
$sql .= " WHERE";
$sql .= "   last_update_flg = 'f'";
$sql .= "   AND";
$sql .= "   fix_flg = 't'";
$sql .= "   AND";
$sql .= "   shop_id = $shop_id";
$sql .= ";"; 

$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
$select_value[] = null; 
for($i = 0; $i < $num; $i++){
    $client_close_day[] = pg_fetch_result($result, $i,0);
}

@asort($client_close_day);
$client_close_day = @array_values($client_close_day);

for($i = 0; $i < $num; $i++){
    if($client_close_day[$i] < 29 && $client_close_day[$i] != ''){ 
        $select_value[$client_close_day[$i]] = (int)$client_close_day[$i]."日";
    }elseif($client_close_day[$i] != '' && $client_close_day[$i] >= 29){ 
        $select_value[$client_close_day[$i]] = "月末"; 
    }
}
$form_claim_day1[] =& $form->createElement(
    "text", "y", "", "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\" 
    onkeyup=\"changeText(this.form,'form_claim_day1[y]','form_claim_day1[m]',4)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day1[y]','form_claim_day1[m]')\"
    onBlur=\"blurForm(this)\""
);
$form_claim_day1[] =& $form->createElement(
        "static","","","年"
        );      
$form_claim_day1[] =& $form->createElement(
    "text", "m", "", "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\"  
    onkeyup=\"changeText(this.form,'form_claim_day1[m]','form_claim_day1[d]',4)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day1[y]','form_claim_day1[m]')\"
    onBlur=\"blurForm(this)\"");
$form_claim_day1[] =& $form->createElement(
        "static","","","月"
        );      
$form_claim_day1[] =& $form->createElement("select", "d", "", $select_value);
$form->addGroup( $form_claim_day1, "form_claim_day1", "請求締日","");

/****************************/
//処理判定
/****************************/
//実行ボタンが押下された場合
$add_button_flg = ($_POST["form_add_button"] == "実　行")? true : false;    //実行ボタン押下フラグ

/****************************/
//実行ボタン押下処理
/****************************/
if($add_button_flg == true){

    /****************************/
    //POST
    /****************************/
    //請求更新日
    $claim_day_y = $_POST["form_claim_day1"]["y"];   //年
    $claim_day_m = $_POST["form_claim_day1"]["m"];   //月
    $claim_day_d = $_POST["form_claim_day1"]["d"];   //日

    /****************************/
    //チェック
    /****************************/
    //請求更新日
    $err_message = "請求更新日の日付は妥当ではありません。";

    //入力チェック

    $form->addGroupRule('form_claim_day1', array(
            'y' => array(
                    array($err_message, 'required'),
                    array($err_message, 'numeric')
            ),      
            'm' => array(
                    array($err_message,'required'),
                    array($err_message,'numeric')
            ),      
            'd' => array(array
                        ($err_message,'required'),
            )       
    ));

    //日付の妥当性チェック
    if(!checkdate((int)$claim_day_m, (int)$claim_day_d, (int)$claim_day_y)){
        $form->setElementError("form_claim_day1",$err_message);
    }

    //未来の日付チェック
    $claim_day_y = str_pad($claim_day_y,4,"0", STR_PAD_LEFT);
    $claim_day_m = str_pad($claim_day_m,2,"0", STR_PAD_LEFT);
    $claim_day_d = str_pad($claim_day_d,2,"0", STR_PAD_LEFT);
    $claim_day = $claim_day_y."-".$claim_day_m."-".$claim_day_d;
    if($claim_day > date("Y-m-d")){
        $form->setElementError("form_claim_day1",$err_message);
    }

    //締日に月末を指定している場合妥当な日付を抽出
    if($claim_day_d == 29){
        $last_day = date("t", mktime(0,0,0,$claim_day_m,1,$claim_day_y));
        $claim_day = $claim_day_y."-".$claim_day_m."-".$last_day;
    }

    /****************************/
    //値検証
    /****************************/
    if($form->validate()){
        $validate_flg = true; 
    }else{
        $validate_flg = false;
    }
}

//検証チェックフラグがtrueの場合のみ処理実行
if($validate_flg == true){

    Db_Query($db_con, "BEGIN;");
    /****************************/
    //請求更新の対象となる請求先の情報を抽出
    /****************************/
    $sql  = "SELECT\n";
    $sql .= "   claim_id, \n";
    $sql .= "   bill_id \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill \n";
    $sql .= "WHERE\n";
    $sql .= "   shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   close_day = '$claim_day'\n";
    $sql .= "   AND\n";
    $sql .= "   fix_flg = 't'\n";
    $sql .= "   AND\n";
    $sql .= "   last_update_flg = 'f' \n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $target_count = @pg_num_rows($result);
    $bill_data     = pg_fetch_all($result);

    //更新対象となるデータがない場合には処理を中止
    if($target_count == 0){
        $no_target_err = "更新対象となるデータがありません。";
        $err_flg = true;
    }

    if($err_flg != true){
        /****************************/
        //請求データのチェック
        /****************************/
        $sql  = "SELECT\n";
        $sql .= "   COUNT(claim_id) \n";
        $sql .= "FROM\n";
        $sql .= "   t_bill\n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $shop_id\n";
        $sql .= "   AND\n";
        $sql .= "   close_day = '$claim_day'\n";
        $sql .= "   AND\n";
        $sql .= "   fix_flg = 'f'\n";
        $sql .= "   AND\n";
        $sql .= "   last_update_flg = 'f' \n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        $unconf_count = pg_fetch_result($result,0 ,0);

        //更新対象となる請求データで未確定のデータがある場合には全ての処理終了後、メッセージを表示
        if($unconf_count > 0){
            $unconf_warning = "未確定のデータがありました。";
        }

        /*****************************/
        //請求更新フラグを「t」に更新する（請求更新の対象となる複数レコード更新）      
        /*****************************/
        $sql  = "UPDATE\n";
        $sql .= "   t_bill \n";
        $sql .= "SET\n";
        $sql .= "   last_update_flg = 't',\n";
        $sql .= "   last_update_day = CURRENT_TIMESTAMP \n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $shop_id\n";
        $sql .= "   AND\n";
        $sql .= "   close_day = '$claim_day'\n";
        $sql .= "   AND\n";
        $sql .= "   fix_flg = 't' \n";
        $sql .= "   AND\n";
        $sql .= "   last_update_flg = 'f' \n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /******************************/
        //請求更新履歴を登録
        /******************************/
        foreach($bill_data AS $key => $var){
            $sql  = "INSERT INTO t_sys_renew( \n";
            $sql .= "   renew_id,\n";
            $sql .= "   renew_div,\n";
            $sql .= "   renew_time,\n";
            $sql .= "   operation_staff_name,\n";
            $sql .= "   close_day,\n";
            $sql .= "   claim_id,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(renew_id), 0)+1 FROM t_sys_renew),\n";
            $sql .= "   '3',\n";
            $sql .= "   CURRENT_TIMESTAMP,\n";
            $sql .= "   '".addslashes($staff_name)."',\n";
            $sql .= "   '$claim_day',\n";
            $sql .= "   ".$var[claim_id].",\n";
            $sql .= "   $shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //請求更新履歴テーブルに登録
            $sql  = "INSERT INTO t_bill_renew( \n";
            $sql .= "   bill_renew_id,\n";
            $sql .= "   close_day,\n";
            $sql .= "   shop_id,\n";
            $sql .= "   claim_id, \n";
            $sql .= "   bill_id \n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(bill_renew_id), 0)+1 FROM t_bill_renew),\n";
            $sql .= "   '$claim_day',\n";
            $sql .= "   $shop_id,\n";
            $sql .= "   ".$var[claim_id].",\n";
            $sql .= "   ".$var[bill_id]."\n";
            $sql .= ");\n";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }

        //更新完了フラグ
        $update_message = "更新しました。";
    }
    Db_Query($db_con, "COMMIT;");
}         

/****************************/
//一覧データ作成
/****************************/
$sql  = "SELECT \n";
$sql .= "    distinct \n";
$sql .= "    close_day, \n";
$sql .= "    to_char(renew_time,'yyyy-mm-dd') ||'　'||to_char(renew_time, 'hh24:mi'), \n";
$sql .= "    operation_staff_name \n";
$sql .= "FROM \n";
$sql .= "    t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "    shop_id = $shop_id \n";
$sql .= "    AND\n";
$sql .= "    renew_div = '3'\n";
$sql .= "ORDER BY close_day DESC \n";
$sql .= "LIMIT 30 \n";
$sql .= ";\n";

$result = Db_Query($db_con, $sql);
$page_data = Get_Data($result);

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
$page_menu = Create_Menu_f('renew','1');

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
    'no_target_err' => "$no_target_err",
    'unconf_warning'=> "$unconf_warning",
    'update_message'=> "$update_message",
));
$smarty->assign('page_data', $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
