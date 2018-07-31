<?php
$page_title = "仕入先マスタ";
/***********************************/
//変更履歴
//  （2006/03/16）
//  ・SQL変更
//　・shop_idをclient_idに変更
//　・カラム追加
//   (2006/08/29)
//  ・集金日と締め日の妥当性チェック追加
//  2006/11/13  0033    kaku-m  TEL・FAX番号のチェックを統一して関数で行うように修正。
/***********************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/25　0092　　　　 watanabe-k　GETを書き換えれば、本部でFCの情報をみることができてしまう。
 * 　2006/11/25　0093　　　　 watanabe-k　GETに文字列を渡すとクエリエラーが表示される。
 * 　2006/11/25　0095　　　　 watanabe-k　仕入先名を半角OR全角スペースのみで登録できる
 *   2006-12-08  ban_0079     suzuki      ログに残すマスタ名を変更
 *   2007-01-24  仕様変更     watanabe-k  ボタンの色変更
 *   2007-02-22               watanabe-k  不要機能の削除
 *   2016/01/20                amano  Dialogue, Button_Submit_1 関数でボタン名が送られない IE11 バグ対応    
 * */

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//初期値設定(radio)
/****************************/
$def_data["form_state"] = 1;
$def_data["form_coax"] = 1;
$def_data["form_tax_div"] = 2;
$def_data["form_tax_franct"] = 1;
$def_data["form_c_tax_div"] = 1;

$form->setDefaults($def_data);
/****************************/
//新規判別
/****************************/
$shop_id = $_SESSION[client_id];
$staff_id = $_SESSION[staff_id];
if(isset($_GET["client_id"])){
    $get_client_id = $_GET["client_id"];
    Get_Id_Check3($get_client_id);
    $new_flg = false;
}else{
    $new_flg = true;
}

/****************************/
//初期設定（GETがある場合）
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT ";
    $select_sql .= "    client_cd1,";       //仕入先CD
    $select_sql .= "    state,";            //状態
    $select_sql .= "    client_name,";      //得意先名
    $select_sql .= "    client_cname,";     //略称
    $select_sql .= "    post_no1,";         //郵便番号１
    $select_sql .= "    post_no2,";         //郵便番号２
    $select_sql .= "    address1,";         //住所１
    $select_sql .= "    address2,";         //住所２
    $select_sql .= "    area_id,";          //地区
    $select_sql .= "    tel,";              //電話番号
    $select_sql .= "    fax,";              //FAX番号
    $select_sql .= "    rep_name,";         //代表者名
    $select_sql .= "    c_staff_id1,";      //仕入先担当
    $select_sql .= "    charger1,";         //担当者
    $select_sql .= "    c_part_name,";      //ご担当先部署
    $select_sql .= "    sbtype_id,";        //業種
    $select_sql .= "    col_terms,";        //支払条件
    $select_sql .= "    establish_day,";    //創業日
    $select_sql .= "    capital,";          //資本金
    $select_sql .= "    close_day,";        //締日
//    $select_sql .= "    pay_m,";            //支払日(月)
//    $select_sql .= "    pay_d,";            //支払日(日)
    $select_sql .= "    payout_m,";            //支払日(月)
    $select_sql .= "    payout_d,";            //支払日(日)
    $select_sql .= "    '',";               //口座番号
    $select_sql .= "    '',";               //口座名義
    $select_sql .= "    bank_name,";        //振込銀行
    $select_sql .= "    cont_sday,";        //契約開始日
    $select_sql .= "    coax,";             //金額(丸め区分)
    $select_sql .= "    tax_div,";          //消費税(課税単位)
    $select_sql .= "    tax_franct,";       //消費税(端数)
    $select_sql .= "    note,";             //備考
    $select_sql .= "    client_read,";      //仕入先名(フリガナ)
    $select_sql .= "    address_read,";     //住所(フリガナ)
    $select_sql .= "    email,";            //Email
    $select_sql .= "    url,";              //URL
    $select_sql .= "    represe,";          //代表者役職
    $select_sql .= "    rep_htel,";         //代表者携帯
    $select_sql .= "    direct_tel,";       //直通TEL
    $select_sql .= "    b_struct,";         //業態ID
    $select_sql .= "    inst_id,";          //施設ID
    $select_sql .= "    trade_id,";         //取引区分コード
    $select_sql .= "    holiday,";          //休日
    $select_sql .= "    deal_history,";     //取引履歴
    $select_sql .= "    importance,";       //重要事項
    $select_sql .= "    client_cread,";     //略称(フリガナ)
    $select_sql .= "    address3,";
    $select_sql .= "    b_bank_name,";      
//    $select_sql .= "    attach_gid";      //FCグループ
    $select_sql .= "    client_name2,";     //仕入先名2
    $select_sql .= "    client_read2, ";    //仕入先名2(フリガナ)
    $select_sql .= "    c_tax_div";
    $select_sql .= " FROM";
    $select_sql .= "    t_client";
    $select_sql .= " WHERE";
    $select_sql .= "    client_id = $_GET[client_id]";
    $select_sql .= " AND";
    $select_sql .= "    client_div = '2'";
    $select_sql .= "    AND\n";
    $select_sql .= "    shop_id = $shop_id\n";
    $select_sql .= ";";
    //クエリ発行
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    //データ取得
    $client_data = pg_fetch_array ($result, 0);
    //初期値データ
    $defa_data["form_client_cd"]              = $client_data[0];         //仕入先コード
    $defa_data["form_state"]                  = $client_data[1];         //状態
    $defa_data["form_client_name"]            = $client_data[2];         //得意先名
    $defa_data["form_client_cname"]           = $client_data[3];         //略称
    $defa_data["form_post"]["no1"]            = $client_data[4];         //郵便番号１
    $defa_data["form_post"]["no2"]            = $client_data[5];         //郵便番号２
    $defa_data["form_address1"]               = $client_data[6];         //住所１
    $defa_data["form_address2"]               = $client_data[7];         //住所２
    $defa_data["form_area_id"]                = $client_data[8];         //地区
    $defa_data["form_tel"]                    = $client_data[9];         //TEL
    $defa_data["form_fax"]                    = $client_data[10];        //FAX
    $defa_data["form_rep_name"]               = $client_data[11];        //代表者氏名
    $defa_data["form_staff_id"]               = $client_data[12];        //契約担当
    $defa_data["form_charger"]                = $client_data[13];        //ご担当者
    $defa_data["form_part"]                   = $client_data[14];        //担当先部署
    $defa_data["form_btype"]                  = $client_data[15];        //業種
    $defa_data["form_pay_terms"]              = $client_data[16];        //支払条件
    $form_start[y] = substr($client_data[17],0,4);
    $form_start[m] = substr($client_data[17],5,2);
    $form_start[d] = substr($client_data[17],8,2);
    $defa_data["form_start"]["y"]             = $form_start[y];          //創業日(年)
    $defa_data["form_start"]["m"]             = $form_start[m];          //創業日(月)
    $defa_data["form_start"]["d"]             = $form_start[d];          //創業日(日)
    $defa_data["form_capital"]                = $client_data[18];        //資本金
    $defa_data["form_close"]                  = $client_data[19];        //締日
    $defa_data["form_pay_m"]                  = $client_data[20];        //支払日(月) 
    $defa_data["form_pay_d"]                  = $client_data[21];        //支払日(日)
    $defa_data["form_intro_ac_num"]           = $client_data[22];        //口座番号
    $defa_data["form_account_name"]           = $client_data[23];        //口座名義
    $defa_data["form_bank"]                   = $client_data[24];        //振込銀行
    $trans_s_day[y] = substr($client_data[25],0,4);
    $trans_s_day[m] = substr($client_data[25],5,2);
    $trans_s_day[d] = substr($client_data[25],8,2);
    $defa_data["form_trans_s_day"]["y"]       = $trans_s_day[y];         //取引開始日(年)
    $defa_data["form_trans_s_day"]["m"]       = $trans_s_day[m];         //取引開始日(月)
    $defa_data["form_trans_s_day"]["d"]       = $trans_s_day[d];         //取引開始日(日)
    $defa_data["form_coax"]                   = $client_data[26];        //金額
    $defa_data["form_tax_div"]                = $client_data[27];        //消費税(課税単位)
    $defa_data["form_tax_franct"]             = $client_data[28];        //消費税(端数区分)
    $defa_data["form_note"]                   = $client_data[29];        //備考
    $defa_data["form_client_read"]            = $client_data[30];        //仕入先名(フリガナ)
    $defa_data["form_address_read"]           = $client_data[31];        //住所(フリガナ)
    $defa_data["form_email"]                  = $client_data[32];        //Email
    $defa_data["form_url"]                    = $client_data[33];        //URL
    $defa_data["form_represent_position"]     = $client_data[34];        //代表者役職
    $defa_data["form_represent_cell"]         = $client_data[35];        //代表者携帯
    $defa_data["form_direct_tel"]             = $client_data[36];        //直通TEL
    $defa_data["form_bstruct"]                = $client_data[37];        //業態ID
    $defa_data["form_inst"]                   = $client_data[38];        //施設ID
    $defa_data["trade_ord"]                  = $client_data[39];        //取引区分コード
    $defa_data["form_holiday"]                = $client_data[40];        //休日
    $defa_data["form_record"]                 = $client_data[41];        //取引履歴
    $defa_data["form_important"]              = $client_data[42];        //重要事項
    $defa_data["form_cname_read"]             = $client_data[43];        //略称(フリガナ)
    $defa_data["form_address3"]               = $client_data[44];        //
    $defa_data["form_b_bank_name"]            = $client_data[45];        //
    $defa_data["form_client_name2"]           = $client_data[46];        //仕入先名2
    $defa_data["form_client_read2"]           = $client_data[47];        //仕入先名2(フリガナ)
//    $defa_data["form_shop_gr_1"]              = $client_data[44];        //FCグループ
    //初期値設定
    $defa_data["form_c_tax_div"]              = $client_data["c_tax_div"];

    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "supplier", $client_data[0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];
}

/***************************/
//フォーム作成
/***************************/

//地区
$select_ary = Select_Get($conn,'area');
$form->addElement('select', 'form_area_id',"", $select_ary,$g_form_option_select);

//業種
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_sbtype.sbtype_id,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       t_lbtype.lbtype_id,";
$sql .= "       t_lbtype.lbtype_cd,";
$sql .= "       t_lbtype.lbtype_name";
$sql .= "   FROM";
$sql .= "       t_lbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_lbtype";
$sql .= "       INNER JOIN";
$sql .= "   (SELECT";
$sql .= "       t_sbtype.sbtype_id,";
$sql .= "       t_sbtype.lbtype_id,";
$sql .= "       t_sbtype.sbtype_cd,";
$sql .= "       t_sbtype.sbtype_name";
$sql .= "   FROM";
$sql .= "       t_sbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_sbtype";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

while($data_list = @pg_fetch_array($result)){
    if($max_len < mb_strwidth($data_list[1])){
        $max_len = mb_strwidth($data_list[1]);
    }
}

$select_value2[""] = "";
$result = Db_Query($conn, $sql);
while($data_list = @pg_fetch_array($result)){
    $space = "";
    for($i = 0; $i< $max_len; $i++){
        if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                $data_list[1] = $data_list[1]."　";
        }
    }
    $select_value2[$data_list[2]] = $data_list[0]." ： ".$data_list[1]."　　 ".$data_list[3]." ： ".$data_list[4];
//  $select_value[$data_list[2]] = $data_list[0].$data_list[3]." 【".$data_list[1]."】".$data_list[4];
}

$form->addElement('select', 'form_btype',"", $select_value2,$g_form_option_select);

//施設
$sql  = "SELECT";
$sql .= "   inst_id,";
$sql .= "   inst_cd,";
$sql .= "   inst_name";
$sql .= " FROM";
$sql .= "   t_inst";
$sql .= " WHERE";
$sql .= "   accept_flg = '1'";
$sql .= " ORDER BY inst_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

$select_value3[""] = "";
while($data_list = @pg_fetch_array($result)){
    $select_value3[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement('select', 'form_inst',"", $select_value3,$g_form_option_select);

//業態
$sql  = "SELECT";
$sql .= "   bstruct_id,";
$sql .= "   bstruct_cd,";
$sql .= "   bstruct_name";
$sql .= " FROM";
$sql .= "   t_bstruct";
$sql .= " WHERE";
$sql .= "   accept_flg = '1'";
$sql .= " ORDER BY bstruct_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

$select_value4[""] = "";
while($data_list = @pg_fetch_array($result)){
    $select_value4[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement('select', 'form_bstruct',"", $select_value4,$g_form_option_select);

//FCグループ
/*
$select_value1 = Select_Get($conn,'shop_gr');
$form->addElement('select', 'form_shop_gr_1', 'セレクトボックス', $select_value1,$g_form_option_select);
*/

//仕入先コード
$form->addElement(
        "text","form_client_cd","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"".$g_form_option."\""
        );

//状態
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "取引中","1");
$text[] =& $form->createElement( "radio",NULL,NULL, "休止中","2");
$text[] =& $form->createElement( "radio",NULL,NULL, "解約","3");
$form->addGroup($text, "form_state", "");

//仕入先名
$form->addElement(
        "text","form_client_name","",'size="44" maxLength="25"'." $g_form_option"
        );

//仕入先名(フリガナ)
$form->addElement(
        "text","form_client_read","テキストフォーム","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//仕入先名2
$form->addElement(
        "text","form_client_name2","",'size="44" maxLength="25"'." $g_form_option"
        );

//仕入先名2(フリガナ)
$form->addElement(
        "text","form_client_read2","テキストフォーム","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//略称
$form->addElement(
        "text","form_client_cname","",'size="44" maxLength="20"'." $g_form_option"
        );

//略称（フリガナ）
$form->addElement(
        "text","form_cname_read","",'size="46" maxLength="40"'." $g_form_option"
        );

//郵便番号
$form_post[] =& $form->createElement(
        "text","no1","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option"
        );
$form->addGroup( $form_post, "form_post", "");

//住所１
$form->addElement(
        "text","form_address1","",'size="44" maxLength="25"'." $g_form_option"
        );

//住所２
$form->addElement(
        "text","form_address2","",'size="46" maxLength="25"'." $g_form_option"
        );

//住所３
$form->addElement(
        "text","form_address3","","size=\"44\" maxLength=\"30\"$g_form_option"
        );

//住所(フリガナ)
$form->addElement(
        "text","form_address_read","テキストフォーム","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//郵便番号
//自動入力ボタンが押下された場合
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //郵便番号１
    $post2     = $_POST["form_post"]["no2"];             //郵便番号２
    $post_value = Post_Get($post1,$post2,$conn);
    //郵便番号フラグをクリア
    $cons_data["input_button_flg"] = "";
    //郵便番号から自動入力
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);
}

//創業日
$start[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_start[y]','form_start[m]',4)\" 
        ".$g_form_option."\"");
$start[] =& $form->createElement("static","","","-");
$start[] =& $form->createElement("text","m","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_start[m]','form_start[d]',2)\"  onchange=\"Contract(this.form)\"
        ".$g_form_option."\"");
$start[] =& $form->createElement("static","","","-");
$start[] =& $form->createElement("text","d","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\""." $g_form_option");
$form->addGroup( $start,"form_start","form_start");

//資本金
$form->addElement(
        "text","form_capital","","class=\"money\" size=\"11\" maxLength=\"9\" 
        style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
        );

//TEL
$form->addElement(
        "text","form_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option"
        );

//Email
$form->addElement(
        "text","form_email","","size=\"34\" maxLength=\"60\" style=\"$g_form_style\""." $g_form_option"
        );

//URL
$form->addElement(
        "text","form_url","テキストフォーム","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//仕入先代表者
$form->addElement(
        "text","form_rep_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//代表者役職
$form->addElement(
        "text","form_represent_position","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//直通TEL
$form->addElement(
        "text","form_direct_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option"
        );

//代表者携帯
$form->addElement(
        "text","form_represent_cell","テキストフォーム","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//仕入先担当者
$form->addElement(
        "text","form_charger","",'size="34" maxLength="15"'." $g_form_option"
        );

//仕入先部署
$form->addElement(
        "text","form_part","",'size="22" maxLength="10"'." $g_form_option"
        );

//休日
$form->addElement(
        "text","form_holiday","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//取引区分
$select_value6 = Select_Get($conn,'trade_ord');
$form->addElement('select', 'trade_ord', 'セレクトボックス', $select_value6,
    "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();pay_way()\"");

//締日
$select_value7 = Select_Get($conn,'close');
$form->addElement('select', 'form_close', 'セレクトボックス', $select_value7,$g_form_option_select);

//支払日
//月
$select_month[null] = null; 
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[$i] = "当月";
    }elseif($i == 1){
        $select_month[$i] = "翌月";
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
$form->addElement("select", "form_pay_d", "セレクトボックス", $select_day, $g_form_option_select);
/*
//月
$form->addElement(
        "text","form_pay_m","","size=\"2\" maxLength=\"2\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
        );
//日
$form->addElement(
        "text","form_pay_d","","size=\"2\" maxLength=\"2\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
        );
*/
//銀行
//$ary_bank = Select_Get($conn,'bank');
//$form->addElement('select', 'form_bank', '',$ary_bank,$g_form_option_select);
$form->addElement('text', 'form_bank', '', "size=\"95\" maxLength=\"40\" $g_form_option");

//支店名
$form->addElement("text", "form_b_bank_name", "","size=\"47\" maxlength=\"20\" $g_form_option");

//口座番号
$form->addElement(
        "text","form_intro_ac_num","","size=\"34\" maxLength=\"15\" $g_form_option"
        );

//口座名義
$form->addElement(
        "text","form_account_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//取引開始日
$form_trans_s_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_trans_s_day[y]','form_trans_s_day[m]',4)\" 
        ".$g_form_option."\""
        );
$form_trans_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_trans_s_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_trans_s_day[m]','form_trans_s_day[d]',2)\"  onchange=\"Contract(this.form)\"
        ".$g_form_option."\""
        );
$form_trans_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_trans_s_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm(this)\" ".$g_form_option."\""
        );
$form->addGroup( $form_trans_s_day,"form_trans_s_day","");

//契約担当
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_staff_id',"", $select_ary, $g_form_option_select );

//金額
//丸め区分
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "切捨","1");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "四捨五入","2");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "切上","3");
$form->addGroup($form_coax, "form_coax", "");

//消費税
//課税単位
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "伝票単位","2");
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "締日単位","1");
$form->addGroup($form_tax_div, "form_tax_div", "");
//端数区分
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "切捨","1");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "四捨五入","2");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "切上","3");
$form->addGroup($form_tax_franct, "form_tax_franct", "");

//課税単位
$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$form->addGroup($form_c_tax_div, "form_c_tax_div", "");

//支払条件
$form->addElement(
        "text","form_pay_terms","",'size="34" maxLength="50"'." $g_form_option"
        );

//備考
$form->addElement(
        "textarea","form_note","",' rows="3" cols="75"'." $g_form_option_area"
        );

//取引履歴
$form->addElement(
        "textarea","form_record","",' rows="3" cols="75"'." $g_form_option_area"
        );

//重要事項
$form->addElement(
        "textarea","form_important","",' rows="3" cols="75"'." $g_form_option_area"
        );

//hidden
$form->addElement("hidden", "input_button_flg");
$form->addElement("hidden", "ok_button_flg");

/****************************/
//ルール作成
/****************************/
$form->registerRule("telfax","function","Chk_Telfax");
//■FCグループ
//●必須チェック
//$form->addRule("form_shop_gr_1", "FCグループを選択してください。","required");

//■仕入先コード
//●必須チェック
$form->addRule("form_client_cd", "仕入先CDは半角数字のみです。","required");

//●半角数字チェック
$form->addRule("form_client_cd", "仕入先CDは半角数字のみです。","regex", "/^[0-9]+$/");

//■仕入先名
//●必須チェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_client_name", "仕入先名は1文字以上25文字以下です。","required");
$form->addRule("form_client_name", "仕入先名にスペースのみの登録はできません。","no_sp_name");

//■略称
//●必須チェック
$form->addRule("form_client_cname", "略称は1文字以上20文字以下です。","required");
$form->addRule("form_client_cname", "略称にスペースのみの登録はできません。","no_sp_name");

//■郵便番号
//●必須チェック
//●半角数字チェック
//●文字数チェック
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', 'required'),
                array('郵便番号は半角数字のみ7桁です。', "regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。','required'),
                array('郵便番号は半角数字のみ7桁です。',"regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(4,4))
        ),
));

//■住所１
//●必須チェック
$form->addRule("form_address1", "住所１は1文字以上25文字以下です。","required");

//■地区
//●必須チェック
$form->addRule("form_area_id", "地区を選択して下さい。","required");

//■取引区分コード
//●必須チェック
$form->addRule("trade_ord", "取引区分コードを選択して下さい。","required");

//■TEL
//●必須チェック
//●半角数字チェック
$form->addRule(form_tel, "TELは半角数字と｢-｣のみ30桁以内です。", "required");
$form->addRule("form_tel","TELは半角数字と｢-｣のみ30桁以内です。", "telfax");

//■業種
//●必須チェック
$form->addRule("form_btype", "業種を選択して下さい。","required");

//■資本金
//●半角数字チェック
//$form->addRule("form_capital", "資本金は半角数字のみです。", "regex", "/^[0-9]+$/");
$form->addRule("form_capital", "資本金は半角数字のみです。", "regex", '/^[0-9]+$/');

//■支払日（月）
//●半角数字チェック
$form->addRule("form_pay_m", "支払日（月）は半角数字のみです。", "required");
$form->addRule("form_pay_m", "支払日（月）は半角数字のみです。", "regex", "/^[0-9]+$/");

//■支払日（日）
//●半角数字チェック
$form->addRule("form_pay_d", "支払日（日）は半角数字のみです。", "required");
$form->addRule("form_pay_d", "支払日（日）は半角数字のみです。", "regex", "/^[0-9]+$/");

//■創業日
//●半角数字チェック
$form->addGroupRule('form_start', array(
        'y' => array(
                array('創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('創業日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('創業日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));


//■取引開始日
//●半角数字チェック
$form->addGroupRule('form_trans_s_day', array(
        'y' => array(
                array('取引開始日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('取引開始日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('取引開始日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));

/***************************/
//ルール作成（PHP）
/***************************/
if($_POST["button"]["entry_button"] == "登　録"){
    /****************************/
    //POST取得
    /****************************/
//    $shop_gr        = $_POST["form_shop_gr_1"];                 //FCグループ
    $client_cd      = $_POST["form_client_cd"];                 //仕入先コード
    $state          = $_POST["form_state"];                     //状態
    $client_name    = $_POST["form_client_name"];               //仕入先名
    $client_name2   = $_POST["form_client_name2"];              //仕入先名2
    $client_cname   = $_POST["form_client_cname"];              //略称
    $post_no1       = $_POST["form_post"]["no1"];               //郵便番号１
    $post_no2       = $_POST["form_post"]["no2"];               //郵便番号２
    $address1       = $_POST["form_address1"];                  //住所１
    $address2       = $_POST["form_address2"];                  //住所２
    $address3       = $_POST["form_address3"];                  //住所３
    $area_id        = $_POST["form_area_id"];                   //地区コード
    $btype          = $_POST["form_btype"];                     //業種コード
    $start_day      = $_POST["form_start"]["y"];                //創業日(年)
    //０埋め
    $_POST["form_start"]["m"] = str_pad($_POST["form_start"]["m"], 2, 0, STR_POS_LEFT);
    $start_day     .= $_POST["form_start"]["m"];                //創業日(月)
    $_POST["form_start"]["d"] = str_pad($_POST["form_start"]["d"], 2, 0, STR_POS_LEFT);
    $start_day     .= $_POST["form_start"]["d"];                //創業日(日)
    $capital        = $_POST["form_capital"];                   //資本金
    $tel            = $_POST["form_tel"];                       //TEL
    $fax            = $_POST["form_fax"];                       //FAX
    $rep_name       = $_POST["form_rep_name"];                  //仕入先代表者
    $charger        = $_POST["form_charger"];                   //仕入先担当者
    $part           = $_POST["form_part"];                      //仕入先部署
    $close_day_cd   = $_POST["form_close"];                     //締日
    $pay_m          = $_POST["form_pay_m"];                     //支払日（月）
    $pay_d          = $_POST["form_pay_d"];                     //支払日（日）
    $bank_enter_cd  = $_POST["form_bank"];                      //振込銀行
    $b_bank_name    = $_POST["form_b_bank_name"];               //支店名
    $intro_ac_num   = $_POST["form_intro_ac_num"];              //口座番号
    $account_name   = $_POST["form_account_name"];              //口座名義
    $trans_s_day    = $_POST["form_trans_s_day"]["y"];          //取引開始日
    //０埋め
    $_POST["form_trans_s_day"]["m"] = str_pad($_POST["form_trans_s_day"]["m"], 2, 0, STR_POS_LEFT);
    $trans_s_day   .= $_POST["form_trans_s_day"]["m"];
    $_POST["form_trans_s_day"]["d"] = str_pad($_POST["form_trans_s_day"]["d"], 2, 0, STR_POS_LEFT);
    $trans_s_day   .= $_POST["form_trans_s_day"]["d"];
    $c_staff_id     = $_POST["form_staff_id"];                  //契約担当１
    $coax           = $_POST["form_coax"];                      //金額：丸め区分
    $tax_div        = $_POST["form_tax_div"];                   //消費税：課税単位
    $tax_franct     = $_POST["form_tax_franct"];                //消費税：端数区分
    $pay_terms      = $_POST["form_pay_terms"];                 //支払条件
    $note           = $_POST["form_note"];                      //設備情報等・その他
    $client_read    = $_POST["form_client_read"];               //仕入先名(フリガナ)
    $client_read2   = $_POST["form_client_read2"];              //仕入先名2(フリガナ)
    $client_cread   = $_POST["form_cname_read"];                //略称(フリガナ)
    $address_read   = $_POST["form_address_read"];              //住所(フリガナ)
    $email          = $_POST["form_email"];                     //Email
    $url            = $_POST["form_url"];                       //URL
    $rep_position   = $_POST["form_represent_position"];        //代表者役職
    $rep_cell       = $_POST["form_represent_cell"];            //代表者携帯
    $direct_tel     = $_POST["form_direct_tel"];                //直通TEL
    $bstruct        = $_POST["form_bstruct"];                   //業態ID
    $inst           = $_POST["form_inst"];                      //施設ID
    $trade_ord     = $_POST["trade_ord"];                     //取引区分コード
    $holiday        = $_POST["form_holiday"];                   //休日
    $record         = $_POST["form_record"];                    //取引履歴
    $importance     = $_POST["form_important"];                 //重要事項
    $c_tax_div      = $_POST["form_c_tax_div"];                 //課税区分

    /***************************/
    //０埋め
    /***************************/
    $client_cd = str_pad($client_cd, 6, 0, STR_POS_LEFT);

    if($client_cd != null && $client_data[0] != $client_cd){
        $client_cd_sql   = "SELECT";
        $client_cd_sql  .= "    client_id FROM t_client";
        $client_cd_sql  .= " WHERE";
        $client_cd_sql  .= "    client_cd1 = '$client_cd'";
        $client_cd_sql  .= "    AND";
        $client_cd_sql  .= "    client_div = '2'";
        $client_cd_sql  .= "    AND";
        $client_cd_sql  .= "    shop_id = $shop_id";
        $client_cd_sql  .= ";";
        $select_client = Db_Query($conn, $client_cd_sql);
        $select_client = pg_num_rows($select_client);
        if($select_client > 0){
            $client_cd_err = "入力された仕入先コードは使用中です。";
            $err_flg = true;
        }
    }
    
    //■TEL
    //●半角数字と「-」以外はエラー
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
        $tel_err = "TELは半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }
*/

    //■FAX
    //●半角数字と「-」以外はエラー
    $form->addRule("form_fax","FAXは半角数字と｢-｣のみ30桁以内です。","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$fax) && $fax != null){
        $fax_err = "FAXは半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }
*/

    //Email
    if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Emailが妥当ではありません。";
        $err_flg = true;
    }

    //■URL
    //●入力チェック
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "正しいURLを入力して下さい。";
        $err_flg = true;
    }

//■代表者氏名
//●必須チェック
$form->addRule("form_rep_name", "代表者氏名は1文字以上15文字以下です。","required");

    //■直通TEL
    //●半角数字と「-」以外はエラー
    $form->addRule("form_direct_tel","直通TELは半角数字と｢-｣のみ30桁以内です。","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$direct_tel) && $direct_tel != ""){
        $d_tel_err = "直通TELは半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }
*/

    //■代表者携帯
    //●半角数字と「-」以外はエラー
    $form->addRule("form_represent_cell","代表者携帯は半角数字と｢-｣のみ30桁以内です。","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$rep_cell) && $rep_cell != ""){
        $rep_cell_err = "代表者携帯は半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }
*/

    //■創業日
    //●日付の妥当性チェック
    $start_y = (int)$_POST["form_start"]["y"];
    $start_m = (int)$_POST["form_start"]["m"];
    $start_d = (int)$_POST["form_start"]["d"];

    if($start_m != null || $start_d != null || $start_y != null){
        $start_flg = true;
    }
    $check_start_day = checkdate($start_m,$start_d,$start_y);
    if($check_start_day == false && $start_flg == true){
        $start_err = "創業日の日付は妥当ではありません。";
        $err_flg = true;
    }
    
    //■締日
    //●必須チェック
    if($_POST["form_close"] == 0){
        $close_err = "締日を選択して下さい。";
        $err_flg = true;
    }

    //支払日が当月で、締日より日付が小さい場合
    if($_POST["form_pay_m"] == 0 && ($_POST["form_close"] >= $_POST["form_pay_d"])){
        $close_err = "支払日（月）で当月を選択した場合は締日より小さい支払日（日）を選択して下さい。";
        $err_flg = true;
    }

    //■取引開始日
    //●日付の妥当性チェック
    $sday_y = (int)$_POST["form_trans_s_day"]["y"];
    $sday_m = (int)$_POST["form_trans_s_day"]["m"];
    $sday_d = (int)$_POST["form_trans_s_day"]["d"];

    if($sday_m != null || $sday_d != null || $sday_y != null){
        $sday_flg = true;
    }
    $check_s_day = checkdate($sday_m,$sday_d,$sday_y);
    if($check_s_day == false && $sday_flg == true){
        $sday_err = "取引開始日の日付は妥当ではありません。";
        $err_flg = true;
    }
}
/****************************/
//検証
/****************************/
if($_POST["button"]["entry_button"] == "登　録" && $form->validate() && $err_flg != true ){

    /******************************/
    //登録処理
    /******************************/
    if($new_flg == true){
        Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                        //仕入先ID
        $insert_sql .= "    client_cd1,";                       //仕入先コード
        $insert_sql .= "    client_cd2,";                       //仕入先コード
        $insert_sql .= "    shop_id,";                          //FCグループID
        $insert_sql .= "    create_day,";                       //作成日
        $insert_sql .= "    state,";                            //状態
        $insert_sql .= "    client_name,";                      //仕入先名
        $insert_sql .= "    client_cname,";                     //略称
        $insert_sql .= "    post_no1,";                         //郵便番号１
        $insert_sql .= "    post_no2,";                         //郵便番号２
        $insert_sql .= "    address1,";                         //住所１
        $insert_sql .= "    address2,";                         //住所２
        $insert_sql .= "    address3,";                         //住所3
        $insert_sql .= "    area_id,";                          //地区ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //代表者氏名
        $insert_sql .= "    c_staff_id1,";                      //契約担当
        $insert_sql .= "    charger1,";                         //ご担当者
        $insert_sql .= "    c_part_name,";                      //ご担当先部署
        $insert_sql .= "    sbtype_id,";                         //業種ID
        $insert_sql .= "    establish_day,";                    //創業日
        $insert_sql .= "    close_day,";                        //締日
//        $insert_sql .= "    pay_m,";                            //支払日（月）
//        $insert_sql .= "    pay_d,";                            //支払日（日）
        $insert_sql .= "    payout_m,";                            //支払日（月）
        $insert_sql .= "    payout_d,";                            //支払日（日）
        $insert_sql .= "    account_name,";                     //口座名義
        $insert_sql .= "    intro_ac_num,";                         //口座番号
        $insert_sql .= "    bank_name,";                          //銀行ID
        $insert_sql .= "    b_bank_name,";                 //支店名
        $insert_sql .= "    coax,";                             //金額：丸め区分
        $insert_sql .= "    tax_div,";                          //消費税：課税単位
        $insert_sql .= "    tax_franct,";                       //消費税：端数区分
        $insert_sql .= "    cont_sday,";                        //取引開始日
        $insert_sql .= "    col_terms,";                        //支払条件
        $insert_sql .= "    capital,";                          //資本金
        $insert_sql .= "    note,";                             //備考
        $insert_sql .= "    client_div,";                       //得意先区分
        $insert_sql .= "    client_read,";                      //仕入先名(フリガナ)
        $insert_sql .= "    client_cread,";                     //略称(フリガナ)
        $insert_sql .= "    address_read,";                     //住所(フリガナ)
        $insert_sql .= "    email,";                            //Email
        $insert_sql .= "    url,";                              //URL
        $insert_sql .= "    represe,";                          //代表者役職
        $insert_sql .= "    rep_htel,";                         //代表者携帯
        $insert_sql .= "    direct_tel,";                       //直通TEL
        $insert_sql .= "    b_struct,";                         //業態ID
        $insert_sql .= "    inst_id,";                          //施設ID
        $insert_sql .= "    trade_id,";                         //取引区分コード
        $insert_sql .= "    holiday,";                          //休日
        $insert_sql .= "    deal_history,";                     //取引履歴
        $insert_sql .= "    importance,";                       //重要事項
//        $insert_sql .= "    attach_gid,";                       //FCグループ
        $insert_sql .= "    shop_name,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    royalty_rate,";
        $insert_sql .= "    tax_rate_n,";
        $insert_sql .= "    client_name2,";                     //仕入先名2
        $insert_sql .= "    client_read2, ";                     //仕入先名2(フリガナ)
        $insert_sql .= "    c_tax_div";
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd',";                    //仕入先コード
        $insert_sql .= "    '0000',";                          //支店コード
        $insert_sql .= "    $shop_id,";                        //FCグループID
        if($create_day == ""){
                $create_day = "    null"; 
        }
        $insert_sql .= "    NOW(),";                            //作成日
        if($state == null){
            $state = 2;
        }
        $insert_sql .= "    '$state',";                         //状態
        $insert_sql .= "    '$client_name',";                   //仕入先名
        $insert_sql .= "    '$client_cname',";                  //略称
        $insert_sql .= "    '$post_no1',";                      //郵便番号１
        $insert_sql .= "    '$post_no2',";                      //郵便番号２
        $insert_sql .= "    '$address1',";                      //住所１
        $insert_sql .= "    '$address2',";                      //住所２
        $insert_sql .= "    '$address3',";                      //住所3
        $insert_sql .= "    $area_id,";                         //地区ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$rep_name',";                      //代表者氏名
        if($c_staff_id == ""){
                $c_staff_id = "    null"; 
        }
        $insert_sql .= "    $c_staff_id,";                      //契約担当
        $insert_sql .= "    '$charger',";                       //ご担当者
        $insert_sql .= "    '$part',";                          //ご担当先部署
        $insert_sql .= "    $btype,";                           //業種ID
        if($start_day == "0000"){                               //創業日
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$start_day',";
        }
        $insert_sql .= "    '$close_day_cd',";                  //締日
        if($pay_m == ""){
                $pay_m = "    null"; 
        }
        $insert_sql .= "    '$pay_m',";                         //支払日（月）
        if($pay_d == ""){
                $pay_d = "    null"; 
        }
        $insert_sql .= "    '$pay_d',";                         //支払日（日）
        $insert_sql .= "    '$account_name',";                  //口座名義
        $insert_sql .= "    '$intro_ac_num',";                      //口座番号
        $insert_sql .= "    '$bank_enter_cd',";                   //銀行
        $insert_sql .= "    '$b_bank_name',";                     //支店名
        $insert_sql .= "    '$coax',";                          //金額：丸め区分
        $insert_sql .= "    '$tax_div',";                       //消費税：課税単位
        $insert_sql .= "    '$tax_franct',";                    //消費税：端数単位
        if($trans_s_day == "0000"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trans_s_day',";               //取引開始日
        }
        $insert_sql .= "    '$pay_terms',";                     //支払条件
        $insert_sql .= "    '$capital',";                       //資本金
        $insert_sql .= "    '$note',";                          //備考
        $insert_sql .= "    '2',";                              //得意先区分
        $insert_sql .= "    '$client_read',";                   //仕入先名(フリガナ)
        $insert_sql .= "    '$client_cread',";                  //略称(フリガナ)
        $insert_sql .= "    '$address_read',";                  //住所(フリガナ)
        $insert_sql .= "    '$email',";                         //Email
        $insert_sql .= "    '$url',";                           //URL
        $insert_sql .= "    '$rep_position',";                  //代表者役職
        $insert_sql .= "    '$rep_cell',";                      //代表者携帯
        $insert_sql .= "    '$direct_tel',";                    //直通TEL
        if($bstruct == ""){                                     //業態ID
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    $bstruct,";
        }
        if($inst == ""){                                        //施設ID
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    $inst,";
        }
        $insert_sql .= "    $trade_ord,";                      //取引区分コード
        $insert_sql .= "    '$holiday',";                       //休日
        $insert_sql .= "    '$record',";                        //取引履歴
        $insert_sql .= "    '$importance',";                    //重要事項
//        $insert_sql .= "    $shop_gr,";                         //FCグループ
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    (SELECT";                           //消費税率(現在)
        $insert_sql .= "        tax_rate_n";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    shop_id = $shop_id";
        $insert_sql .= "    AND";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ), ";
        $insert_sql .= "    '$client_name2',";                   //仕入先名2
        $insert_sql .= "    '$client_read2',";                   //仕入先名2(フリガナ)
        $insert_sql .= "    $c_tax_div";
        $insert_sql .= ");";
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //登録した情報をログに残す
        $result = Log_Save( $conn, "supplier", "1", $client_cd, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

    /******************************/
    //更新処理
    /******************************/
    }else if($new_flg == false){
        //仕入先マスタ
        Db_Query($conn, "BEGIN;");
        $update_sql = "UPDATE";
        $update_sql .= "    t_client";
        $update_sql .= " SET";
        $update_sql .= "    client_cd1 = '$client_cd',";        //仕入先コード
        $update_sql .= "    state= '$state',";                  //状態
        $update_sql .= "    client_name = '$client_name',";     //仕入先名
        $update_sql .= "    client_name2 = '$client_name2',";   //仕入先名2
        $update_sql .= "    client_cname = '$client_cname',";   //略称
        $update_sql .= "    post_no1 = '$post_no1',";           //郵便番号１
        $update_sql .= "    post_no2 = '$post_no2',";           //郵便番号２
        $update_sql .= "    address1 = '$address1',";           //住所１
        $update_sql .= "    address2 = '$address2',";           //住所２
        $update_sql .= "    address3 = '$address3',";           //住所3
        $update_sql .= "    area_id = $area_id,";               //地区ID
        $update_sql .= "    tel = '$tel',";                     //tel
        $update_sql .= "    fax = '$fax',";                     //fax
        $update_sql .= "    rep_name = '$rep_name',";           //代表者氏名
        if($c_staff_id == ""){                                  //契約担当
            $update_sql .= "    c_staff_id1 = null,";
        }else{
            $update_sql .= "    c_staff_id1 = $c_staff_id,";
        }
        $update_sql .= "    charger1 = '$charger',";           //ご担当者
        $update_sql .= "    c_part_name = '$part',";            //ご担当先部署
        $update_sql .= "    sbtype_id = $btype,";                //業種ID
        $update_sql .= "    col_terms = '$pay_terms',";         //支払条件
        if($start_day == "0000"){                                   //創業日
            $update_sql .= "    establish_day = null,";
        }else{
            $update_sql .= "    establish_day = '$start_day',";
        }
        $update_sql .= "    capital = '$capital',";             //資本金
        $update_sql .= "    close_day = '$close_day_cd',";      //締日
        if($pay_m == ""){                                       //支払日（月）
//            $update_sql .= "    pay_m = '',";
            $update_sql .= "    payout_m = '',";
        }else{
//            $update_sql .= "    pay_m = '$pay_m',";
            $update_sql .= "    payout_m = '$pay_m',";
        }
        if($pay_d == ""){                                       //支払日（日）
//            $update_sql .= "    pay_d = '',";
            $update_sql .= "    payout_d = '',";
        }else{
//            $update_sql .= "    pay_d = '$pay_d',";
            $update_sql .= "    payout_d = '$pay_d',";
        }
        $update_sql .= "    intro_ac_num = '$intro_ac_num',";   //口座番号
        $update_sql .= "    account_name = '$account_name',";   //口座名義
        $update_sql .= "    bank_name = '$bank_enter_cd',";
        $update_sql .= "    b_bank_name = '$b_bank_name',";     //銀行名
        if($trans_s_day == "0000"){                             //取引開始日
            $update_sql .= "    cont_sday = null,";
        }else{
            $update_sql .= "    cont_sday = '$trans_s_day',";
        }
        $update_sql .= "    coax = '$coax',";                   //金額：丸め区分
        $update_sql .= "    tax_div = '$tax_div',";             //消費税：課税単位
        $update_sql .= "    tax_franct = '$tax_franct',";       //消費税：端数区分
        $update_sql .= "    note = '$note',";                   //備考
        $update_sql .= "    client_read = '$client_read',";     //仕入先名(フリガナ)
        $update_sql .= "    client_read2 = '$client_read2',";   //仕入先名2(フリガナ)
        $update_sql .= "    client_cread = '$client_cread',";   //略称(フリガナ)
        $update_sql .= "    address_read = '$address_read',";   //住所(フリガナ)
        $update_sql .= "    email = '$email',";                 //Email
        $update_sql .= "    url = '$url',";                     //URL
        $update_sql .= "    represe = '$rep_position',";        //代表者役職
        $update_sql .= "    rep_htel = '$rep_cell',";           //代表者携帯
        $update_sql .= "    direct_tel = '$direct_tel',";       //直通TEL
        if($bstruct == ""){                                     //業態ID
            $update_sql .= "    b_struct = null,";
        }else{
            $update_sql .= "    b_struct = $bstruct,";
        }
        if($inst == ""){                                        //施設ID
            $update_sql .= "    inst_id = null,";
        }else{
            $update_sql .= "    inst_id = $inst,";
        }
        if($trade_ord == ""){                                  //取引区分コード
            $update_sql .= "    trade_id = null,";
        }else{
            $update_sql .= "    trade_id = $trade_ord,";
        }
        $update_sql .= "    holiday = '$holiday',";             //休日
        $update_sql .= "    deal_history = '$record',";         //取引履歴
        $update_sql .= "    importance = '$importance',";       //重要事項
/*        if($shop_gr == ""){                                     //FCグループ
            $update_sql .= "    attach_gid = null";
        }else{
            $update_sql .= "    attach_gid = $shop_gr";
        }
*/
        $update_sql .= "    c_tax_div = $c_tax_div";
        $update_sql .= " WHERE ";
        $update_sql .= "    client_id = $_GET[client_id]";
        $update_sql .= ";";
        $result = Db_Query($conn, $update_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //変更した情報をログに残す
        $result = Log_Save( $conn, "supplier", "2", $client_cd, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
        
    }
    Db_Query($conn, "COMMIT;");
    $complete_flg = true;
    $form->freeze();
}

if($_POST["ok_button_flg"]==true){
    header("Location: ./1-1-216.php");
}

//ボタン
//変更・一覧
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('1-1-215.php')\"");

//登録(ヘッダ)
//$form->addElement("button","new_button","登録画面","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","登録画面",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//DBに登録後のフォームを作成
if($complete_flg == true){
    $button[] = $form->createElement(
            "button","back_button","戻　る",
            "onClick='javascript:history.back()'
            ");
    //ＯＫ
    $button[] = $form->addElement(
            "button","ok_button","Ｏ　Ｋ","onClick=\"javascript:Button_Submit_1('ok_button_flg', '#', 'true', this)\""
            );
}else{

    //DBに登録前のフォームを作成
    $button[] = $form->createElement(
            "button","input_button","自動入力","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""
            ); 

    $button[] = $form->createElement(
            "submit","entry_button","登　録",
            "onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled"
            );
    $button[] = $form->createElement(
            "button","back_button","戻　る",
            "onClick='javascript:location.href = \"./1-1-215.php\"'
            ");
/*
    $button[] = $form->createElement(
            "button","res_button","実　績",
            "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-217.php?client_id=$_GET[client_id]','_blank','width=480,height=600')\""
            );
*/
    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./1-1-216.php?client_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","次　へ","disabled");
    }
    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./1-1-216.php?client_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","前　へ","disabled");
    }
}
$form->addGroup($button, "button", "");


$contract = "function Contract(me){\n";
$contract .= "  var STM = \"form_start[m]\";\n";
$contract .= "  var STD = \"form_start[d]\";\n";
$contract .= "  var SM = \"form_trans_s_day[m]\";\n";
$contract .= "  var SD = \"form_trans_s_day[d]\";\n";
$contract .= "  len_stm = me.elements[STM].value.length;\n";
$contract .= "  len_std = me.elements[STD].value.length;\n";
$contract .= "  len_sm = me.elements[SM].value.length;\n";
$contract .= "  len_sd = me.elements[SD].value.length;\n";
$contract .= "  if(len_stm == 1){\n";
$contract .= "      me.elements[STM].value = '0'+me.elements[STM].value;\n";
$contract .= "  }\n";
$contract .= "  if(len_std == 1){\n";
$contract .= "      me.elements[STD].value = '0'+me.elements[STD].value;\n";
$contract .= "  }\n";
$contract .= "  if(len_sm == 1){\n";
$contract .= "      me.elements[SM].value = '0'+me.elements[SM].value;\n";
$contract .= "  }\n";
$contract .= "  if(len_sd == 1){\n";
$contract .= "      me.elements[SD].value = '0'+me.elements[SD].value;\n";
$contract .= "  }\n";
$contract .= "}\n";

//支払日
$contract .= "function pay_way(){\n";
$contract .= "  if(document.dateForm.trade_ord.value=='71'){\n";
$contract .= "      document.dateForm.form_close.value='29';\n";
$contract .= "  }\n";
$contract .= "}\n";

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
$page_menu = Create_Menu_h('system','1');

/****************************/
//全件数取得
/****************************/
$count_sql  = " SELECT";
$count_sql .= "     COUNT(client_id)";
$count_sql .= " FROM";
$count_sql .= "     t_client";
$count_sql .= " WHERE";
$count_sql .= "     t_client.shop_id = $shop_id";
$count_sql .= "     AND";
$count_sql .= "     t_client.client_div = 2";
$count_sql .= ";";

//ヘッダーに表示させる全件数
$total_count_sql = $count_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
    'close_err'     => "$close_err",
    'sday_err'      => "$sday_err",
    'start_err'     => "$start_err",
    'tel_err'       => "$tel_err",
    'fax_err'       => "$fax_err",
    'code_value'    => "$code_value",
    'client_cd_err' => "$client_cd_err",
    'contract'      => "$contract",
    'email_err'     => "$email_err",
    'url_err'       => "$url_err",
    'd_tel_err'     => "$d_tel_err",
    'rep_cell_err'  => "$rep_cell_err",
    'next_id'       => "$next_id",
    'back_id'       => "$back_id",
    'auth_r_msg'    => "$auth_r_msg"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
