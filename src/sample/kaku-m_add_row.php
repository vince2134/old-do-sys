<?php
$page_title = "支払練習";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB接続
$db_con = Db_Connect();

//print_array($_POST);
/****************************/
//外部変数取得
/****************************/
session_start();
$shop_id    = $_SESSION["client_id"];
$staff_id  = $_SESSION["staff_id"];
//仮
$shop_id = 1;
/****************************/
//初期設定
/****************************/
//表示行数
if(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 10;
}
//削除行数
$del_history[] = null;

/****************************/
//行数追加
/****************************/
if($_POST["add_row_flg"]== 'true'){
    //最大行に、＋１する
    $max_row = $_POST["max_row"]+1;
    //行数追加フラグをクリア
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//行削除処理
/****************************/
if(isset($_POST["del_row"])){

    //削除リストを取得
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。
    $del_history = explode(",", $del_row);
}
//print_r($del_history);
//print_r($_POST);

/***************************/
//初期値設定
/***************************/
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

/****************************o
//仕入先コード入力
/****************************/
if($_POST["layer"] != null || $_POST["layer_flg"] == "true"){

    $l_num = $_POST["layer"];
    $supplier_cd    = $_POST["f_layer$l_num"];

    /****************************/
    //sql作成
    /****************************/
    $supplier_sql  = " SELECT";
    $supplier_sql .= "     t_client.client_cd1,";       //仕入先コード
    $supplier_sql .= "     t_client.client_name,";      //仕入先名
    $supplier_sql .= "     t_client.bank_name,";        //銀行名
    $supplier_sql .= "     t_client.client_id";         //仕入先ID
    $supplier_sql .= " FROM";
    $supplier_sql .= "     t_client";
    //仕入先コード
    $supplier_cd1_sql  = " WHERE t_client.client_cd1 = '$supplier_cd' AND client_div = '2' AND shop_id = $shop_id";

    $supplier_sql .= $supplier_cd1_sql;

    $count_res = Db_Query($db_con,$supplier_sql.";");
    $get_row = pg_num_rows($count_res);
    if($get_row > 0){
    //検索結果がある場合は、仕入先名・銀行名をセット
        $get_data = pg_fetch_array($count_res);
        $c_name['t_layer'.$l_num] = $get_data['client_name'];       //仕入先名
        $c_name['form_bank_'.$l_num] = $get_data['bank_name'];      //銀行名
        $c_name['h_layer_id'][$l_num] = $get_data['client_id'];     //仕入先ID
    }else{
    //０件の場合はクリア
        $c_name['t_layer'.$l_num] = "";
        $c_name['form_bank_'.$l_num] = "";
        $c_name['h_layer_id'][$l_num] = "";
    }
    $form->setConstants($c_name);
}

/****************************/
//フォーム作成（固定）
/****************************/

// 支払予定一覧
$form->addElement("button", "pay_button", "支払予定一覧", "onClick=\"javascript:Referer('1-3-301.php')\"");

// 入力・変更
$form->addElement("button", "new_button", "入力・変更", "style=color:#ff0000 onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);

// 照会
$form->addElement("button", "change_button", "照　会", "onClick=\"javascript:Referer('1-3-303.php')\"");

//hidden
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden","layer");                //取引先
$form->addElement("hidden","layer_flg");            //取引先入力フラグ

/*****************************/
//フォーム作成（変動）
/*****************************/
//行番号カウンタ
$row_num = 1;

for($i = 0; $i < $max_row; $i++){

    //削除行判定
    if(!in_array("$i", $del_history)){
        //削除履歴
        $del_data = $del_row.",".$i;

        // 支払日
        $ary_element[0] = array($text3_1, $text3_3, $text3_5, $text3_7, $text3_9);
        $ary_element[1] = array("1", "3", "5", "7" ,"9","11","13","15","17");
        $ary_element[0][$i][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" $g_form_option onkeyup=\"changeText3(this.form,".$i.")\" onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\"  $g_form_option onkeyup=\"changeText4(this.form,".$i.")\" onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\"  $g_form_option onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $form->addGroup($ary_element[0][$i], "f_date_a".$i,"");

        // 取引区分
        $select_value = Select_Get($db_con, "trade_payout");
        $form->addElement("select", "trade_payout_".$i, "", $select_value, $g_form_option_select);
    
        // 銀行
        $form->addElement("text","form_bank_".$i, "", "size=\"20\" maxLength=\"20\" value=\"\" $g_form_option"); 

        // 仕入先
        $form->addElement("text","f_layer".$i, "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\"onChange=Button_Submit_1('layer','#','$i') $g_form_option");
        $form->addElement("text", "t_layer".$i, "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

        // 支払金額
        $form->addElement("text", "pay_mon_".$i, "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

        // 手数料
        $form->addElement("text", "pay_fee_".$i, "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

        // 備考
        $form->addElement("text", "f_mark_".$i, "", "size=\"34\" maxLength=\"20\" $g_form_option");

        // 支払ボタン
        $form->addElement("submit", "money4", "支　払", "onClick=\"Dialogue('支払います。','#')\"");

        //削除
        if($row_num == $max_row-$del_num){
            $form->addElement(
                "link","form_del_row".$i,"","#",
                "削除",
                "TABINDEX=-1
                onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1);return false;\""
            );
             //最終行以外を削除する場合、削除する行と同じNOの行に合わせる
        }else{
            $form->addElement(
                "link","form_del_row".$i,"","#",
                "削除",
                "TABINDEX=-1
                onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num);return false;\""
            );
        }
        
        //仕入先ID
        $form->addElement("hidden","h_layer_id[$i]");


        /****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //仕入先
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["f_layer".$i]]->toHtml();
        $html .=        "（<a href=\"#\" onClick=\"return Open_SubWin_2('../head/dialog/1-0-208.php',Array('f_layer$i','t_layer$i','layer_flg'),500,450,5,$shop_id,$i,$row_num);\">検索</a>）\n<br>\n";
        $html .=        $form->_elements[$form->_elementIndex["t_layer".$i]]->toHtml();
        $html .=    "</td>\n";


        //支払日
        $html .=    "<td align=\"left\">\n";
        $html .=    $form->_elements[$form->_elementIndex["f_date_a".$i]]->toHtml();
        $html .=    "</td>\n";

        //取引区分
        $html .=    "<td align=\"left\">\n";
        $trade_payout = array("","1","2","3","4","5","6");
        $html .=        $form->_elements[$form->_elementIndex["trade_payout_".$i]]->toHtml();
        $html .=    "</td>\n";

        //銀行
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_bank_".$i]]->toHtml();
        $html .=    "</td>\n";

        //支払い金額
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["pay_mon_".$i]]->toHtml();
        $html .=    "</td>\n";

        //手数料
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["pay_fee_".$i]]->toHtml();
        $html .=    "</td>\n";

        //備考
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["f_mark_".$i]]->toHtml();
        $html .=    "</td>\n";

        //削除
        $html .=    "<td align=\"center\">\n";
        $html .= $form->_elements[$form->_elementIndex["form_del_row".$i]]->toHtml();
        $html .=    "</td>\n";

        $html .= "</tr>\n";

        //行番号を＋１
        $row_num = $row_num+1;
    }
}

/****************************/
//仕入ボタン押下処理
/****************************/
$input_chk_flg = "true";
$l_id_cnt = 0;                                  //仕入先コードが空白な行数
//支払ボタンが押された場合
if($_POST['money4']=="支　払"){

    //日次更新日（最大）抽出sql作成
    $renewday_sql = "SELECT ";
    $renewday_sql .= "  max(renew_day) ";       //日次更新日のMAX値
    $renewday_sql .= "FROM ";
    $renewday_sql .= "  t_payout_h ";
    $renewday_sql .= "WHERE ";
    $renewday_sql .= "  shop_id = $shop_id";
    $renewday_sql .= ";";

    $day_res = Db_Query($db_con,$renewday_sql);
    $renewday = pg_fetch_array($day_res);
    $day_max = $renewday['max'];
    $day_max = "2006-08-02";
    $l_id = $_POST['h_layer_id'];               //仕入先IDを取得
        
     $max_row = $_POST["max_row"];              //最大行数取得
    //現在の最大桁数繰り返し
    for($j=0;$j<$max_row;$j++){
        //IDが空白な行を数える
        if($l_id[$j] == ""){
            $l_id_cnt++;
        }else{
            $input_id[] = $j;                   //仕入先の入力されている行番号
            
        }
    }
//print_r($l_id);
print_r($input_id);
    //空白な行数と、最大桁数が同じ場合
    if($l_id_cnt == $max_row){
        $input_chk_flg = "false";
        $input_err = "仕入先が正しくありません。";
    }else{
        //入力されている行の分繰り返し
        foreach($input_id as $var){
            $input_year[$var] = $_POST['f_date_a'.$var]['y_input'];     //年取得
            $input_month[$var] = $_POST['f_date_a'.$var]['m_input'];    //月取得
            $input_day[$var] = $_POST['f_date_a'.$var]['d_input'];      //日取得
            $input_trade[$var] = $_POST['trade_payout_'.$var];          //取引区分取得
            $input_bank[$var] = $_POST['form_bank_'.$var];              //振込銀行取得
            $input_paymon[$var] = $_POST['pay_mon_'.$var];              //支払金額取得
            $input_payfee[$var] = $_POST['pay_fee_'.$var];              //手数料取得
            $inpu_mark[$var] = $_POST['f_mark_'.$var];                  //備考取得
            $input_date[$var] = date('Y-m-d',mktime(0,0,0,$input_month[$var],$input_day[$var],$input_year[$var]));      //日付の正規化

            //エラーチェック

            //年・月・日が空でない
            if(($input_year[$var] !="" && $input_month[$var] != "" && $input_day[$var] != "") &&
            //半角数値で入力されている
            (ereg("^([0-9]{4})$",$input_year[$var]) && ereg("^[01]?[0-9]$",$input_month[$var]) && ereg("^[0123]?[0-9]$",$input_day[$var])) &&
            //日付が妥当
            (checkdate($input_month[$var], $input_day[$var], $input_year[$var])) &&
            //日次更新日＜　支払日　＜＝今日
            ($day_max < $input_date[$var] && $input_date[$var] <= date('Y-m-d',time()))
            ){
            }else{
                $input_chk_flg = "false";
                $date_err = "支払日の日付は最終日次更新日から本日まで入力可能です。";
            }
            //取引区分が空白でない
            if($input_trade[$var] == ""){
                $input_chk_flg = "false";
                $trade_err = "取引区分は必須入力です。";
            }
            //支払金額が空白でなく、１〜９桁の数値
            if($input_paymon[$var] != "" && ereg("[0-9]{1,9}",$input_paymon[$var])){
            }else{
                $input_chk_flg = "false";
                $paymon_err = "支払金額は半角数字で入力してください。";
            }
            //手数料が、空白か、１〜９桁の数値
            if($input_payfee[$var] == "" || ereg("[0-9]{1,9}",$input_payfee[$var])){
            }else{
                $input_chk_flg = "false";
                $payfee_err = "手数料は半角数字で入力してください。";
            }
        }
    }
    //エラーチェックが全てtrueならば
    if($input_chk_flg == "true"){
        //入力されている行の分繰り返し
        foreach($input_id as $var){
            $g_num = $l_id[$var];
            $g_day = $input_date[$var];
            $gather_id[$g_num][$g_day][] = $var;
        }
print_array($gather_id);
        //仕入番号抽出sql作成
        $pay_no_sql = "SELECT ";
        $pay_no_sql .= "    MAX(pay_no) ";
        $pay_no_sql .= "FROM ";
        $pay_no_sql .= "    t_payout_h ";
        $pay_no_sql .= "WHERE ";
        $pay_no_sql .= "    shop_id = $shop_id";
        $pay_no_sql .= ";";

        $pay_res = Db_Query($db_con,$pay_no_sql);
        $pay_data = pg_fetch_array($pay_res);
        $pay_no_max = $pay_data['max'];                     //仕入番号取得
        $pay_no_max += 1;                                   
        $pay_no_max = str_pad($pay_no_max,8,"0",STR_PAD_LEFT);//８桁に０詰め

        //支払登録sql作成
        $pay_ragist_sql = "INSERT INTO ";
        $pay_ragist_sql .= "    t_payout_h ";
        $pay_ragist_sql .= "(";
        $pay_ragist_sql .= "    pay_id,";           //支払ID
        $pay_ragist_sql .= "    pay_no,";           //支払番号
        $pay_ragist_sql .= "    pay_day,";          //支払日
        $pay_ragist_sql .= "    client_id,";        //仕入先ID
        $pay_ragist_sql .= "    client_name,";      //仕入先名
        $pay_ragist_sql .= "    client_name2,";     //仕入先名２
        $pay_ragist_sql .= "    client_cname,";     //仕入先名（略称）
        $pay_ragist_sql .= "    client_cd1,";       //仕入先コード
        $pay_ragist_sql .= "    e_staff_id,";       //入力者ID
        $pay_ragist_sql .= "    e_staff_name,";     //入力社名
        $pay_ragist_sql .= "    staff_id,";         //担当者ID
        $pay_ragist_sql .= "    staff_name,";       //担当者名
        $pay_ragist_sql .= "    input_day,";        //入力日
        $pay_ragist_sql .= "    shop_id";           //取引先ID
        $pay_ragist_sql .= ")";
        $pay_ragist_sql .= "VALUES (";
        $pay_ragist_sql .= "    ";

    }
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
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[pay_button]]->toHtml();
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
    'input_err'              => "$input_err",
    'date_err'              => "$date_err",
    'trade_err'             => "$trade_err",
    'paymon_err'            => "$paymon_err",
    'payfee_err'            => "$payfee_err",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
