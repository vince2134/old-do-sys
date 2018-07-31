<?php
$page_title = "得意先登録";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DBに接続
$conn = Db_Connect();
/****************************/
//初期値設定(radio)
/****************************/
$def_data["form_work"] = 11;
$def_data["form_slip_out"] = 1;
$def_data["form_claim_out"] = 1;
$def_data["form_coax"] = 1;
$def_data["form_tax_io"] = 1;
$def_data["form_tax_div"] = 1;
$def_data["form_tax_franct"] = 1;

$form->setDefaults($def_data);
/****************************/
//新規判別
/****************************/
$shop_id  = $_SESSION[shop_id];
$shop_gid = $_SESSION[shop_gid];
$shop_aid = $_SESSION[shop_aid];
$staff_id = $_SESSION[staff_id];
if(isset($_GET["client_id"])){
    $get_client_id = $_GET["client_id"];
    $new_flg = false;
}else{
    $new_flg = true;
}

/****************************/
//初期設定（GETがある場合）
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT    t_client.client_cd1,";
    $select_sql .= "    t_client.client_cd2,";
    $select_sql .= "    t_client.state,";
    $select_sql .= "    t_client.client_name,";
    $select_sql .= "    t_client.client_read,";
    $select_sql .= "    t_client.client_cname,";
    $select_sql .= "    t_client.post_no1,";
    $select_sql .= "    t_client.post_no2,";
    $select_sql .= "    t_client.address1,";
    $select_sql .= "    t_client.address2,";
    $select_sql .= "    t_client.address_read,";
    $select_sql .= "    t_client.area_id,";
    $select_sql .= "    t_client.tel,";
    $select_sql .= "    t_client.fax,";
    $select_sql .= "    t_client.rep_name,";
    $select_sql .= "    t_client.charger1,";
    $select_sql .= "    t_client.charger2,";
    $select_sql .= "    t_client.charger3,";
    $select_sql .= "    t_client.charger4,";
    $select_sql .= "    t_client.charger5,";
    $select_sql .= "    t_client.trade_stime1,";
    $select_sql .= "    t_client.trade_etime1,";
    $select_sql .= "    t_client.trade_stime2,";
    $select_sql .= "    t_client.trade_etime2,";
    $select_sql .= "    t_client.holiday,";
    $select_sql .= "    t_client.btype_id,";
    $select_sql .= "    t_client.b_struct,";
    $select_sql .= "    t_client_claim.client_cd1,";
    $select_sql .= "    t_client_claim.client_cd2,";
    $select_sql .= "    t_client_claim.client_name,";
    $select_sql .= "    t_client_intro_act.client_cd1,";
    $select_sql .= "    t_client_intro_act.client_name,";
    $select_sql .= "    t_client.account_price,";
    $select_sql .= "    t_client.account_rate,";
    $select_sql .= "    t_client.cshop_id,";
    $select_sql .= "    t_client.c_staff_id1,";
    $select_sql .= "    t_client.c_staff_id2,";
    $select_sql .= "    t_client.d_staff_id1,";
    $select_sql .= "    t_client.d_staff_id2,";
    $select_sql .= "    t_client.d_staff_id3,";
    $select_sql .= "    t_client.col_terms,";
    $select_sql .= "    t_client.credit_limit,";
    $select_sql .= "    t_client.capital,";
    $select_sql .= "    t_client.work_cd,";
    $select_sql .= "    t_client.close_day,";
    $select_sql .= "    t_client.pay_m,";
    $select_sql .= "    t_client.pay_d,";
    $select_sql .= "    t_client.pay_way,";
    $select_sql .= "    t_client.bank_id,";
    $select_sql .= "    t_client.pay_name,";
    $select_sql .= "    t_client.account_name,";
    $select_sql .= "    t_client.cont_s_day,";
    $select_sql .= "    t_client.cont_e_day,";
    $select_sql .= "    t_client.cont_peri,";
    $select_sql .= "    t_client.cont_r_day,";
    $select_sql .= "    t_client.slip_out,";
    $select_sql .= "    t_client.deliver_note,";
    $select_sql .= "    t_client.claim_out,";
    $select_sql .= "    t_client.coax,";
    $select_sql .= "    t_client.tax_io,";
    $select_sql .= "    t_client.tax_div,";
    $select_sql .= "    t_client.tax_franct,";
    $select_sql .= "    t_client.note";
    $select_sql .= " FROM";
    $select_sql .= "    t_claim,";
    $select_sql .= "    t_client AS t_client_claim,";
    $select_sql .= "    t_client";
    $select_sql .= "        LEFT JOIN";
    $select_sql .= "    (SELECT";
    $select_sql .= "         t_intro_act.intro_account_id,";
    $select_sql .= "         t_intro_act.client_id,";
    $select_sql .= "         t_client.client_cd1,";
    $select_sql .= "         t_client.client_name";
    $select_sql .= "    FROM";
    $select_sql .= "         t_intro_act,";
    $select_sql .= "         t_client";
    $select_sql .= "    WHERE";
    $select_sql .= "         t_client.client_id  = t_intro_act.intro_account_id";
    $select_sql .= "    ) AS t_client_intro_act";
    $select_sql .= "        ON t_client.client_id = t_client_intro_act.client_id";
    $select_sql .= " WHERE";
    $select_sql .= "    t_client.client_id = $_GET[client_id]";
    $select_sql .= "    and";
    $select_sql .= "    t_client.client_id = t_claim.client_id";
    $select_sql .= "    and";
    $select_sql .= "    t_claim.claim_id = t_client_claim.client_id";
    $select_sql .= ";";
    //クエリ発行
    $result = Db_Query($conn, $select_sql);
    //データ取得
    $client_data = pg_fetch_array ($result, 0, PGSQL_NUM);
    //初期値データ
    $defa_data["form_client"]["cd1"]          = $client_data[0];         //得意先コード１
    $defa_data["form_client"]["cd2"]          = $client_data[1];         //得意先コード２
    if($client_data[2] == 1){
  	   $defa_data["form_state"]               = 1;                       //取引中
    }
    $defa_data["form_client_name"]            = $client_data[3];         //得意先名
    $defa_data["form_client_read"]            = $client_data[4];         //得意先名(フリガナ)
    $defa_data["form_client_cname"]           = $client_data[5];         //略称
    $defa_data["form_post"]["no1"]            = $client_data[6];         //郵便番号１
    $defa_data["form_post"]["no2"]            = $client_data[7];         //郵便番号２
    $defa_data["form_address1"]               = $client_data[8];         //住所１
    $defa_data["form_address2"]               = $client_data[9];         //住所２
    $defa_data["form_address_read"]           = $client_data[10];        //住所(フリガナ)
    $defa_data["form_area_id"]                = $client_data[11];        //地区
    $defa_data["form_tel"]                    = $client_data[12];        //TEL
    $defa_data["form_fax"]                    = $client_data[13];        //FAX
    $defa_data["form_rep_name"]               = $client_data[14];        //代表者氏名
    $defa_data["form_charger1"]               = $client_data[15];        //ご担当者１
    $defa_data["form_charger2"]               = $client_data[16];        //ご担当者２
    $defa_data["form_charger3"]               = $client_data[17];        //ご担当者３
    $defa_data["form_charger4"]               = $client_data[18];        //ご担当者４
    $defa_data["form_charger5"]               = $client_data[19];        //ご担当者５
    $trade_stime1[1] = substr($client_data[20],0,2);
    $trade_stime1[2] = substr($client_data[20],3,2);
    $trade_etime1[1] = substr($client_data[21],0,2);
    $trade_etime1[2] = substr($client_data[21],3,2);
    $trade_stime2[1] = substr($client_data[22],0,2);
    $trade_stime2[2] = substr($client_data[22],3,2);
    $trade_etime2[1] = substr($client_data[23],0,2);
    $trade_etime2[2] = substr($client_data[23],3,2);
    $defa_data["form_trade_stime1"]["h"]      = $trade_stime1[1];        //営業時間(午前開始時間)
    $defa_data["form_trade_stime1"]["m"]      = $trade_stime1[2];        //営業時間(午前開始時間)
    $defa_data["form_trade_etime1"]["h"]      = $trade_etime1[1];        //営業時間(午前終了時間)
    $defa_data["form_trade_etime1"]["m"]      = $trade_etime1[2];        //営業時間(午前終了時間)
    $defa_data["form_trade_stime2"]["h"]      = $trade_stime2[1];        //営業時間()
    $defa_data["form_trade_stime2"]["m"]      = $trade_stime2[2];        //営業時間()
    $defa_data["form_trade_etime2"]["h"]      = $trade_etime2[1];        //営業時間()
    $defa_data["form_trade_etime2"]["m"]      = $trade_etime2[2];        //営業時間()
    $defa_data["form_holiday"]                = $client_data[24];        //休日
    $defa_data["form_btype"]                  = $client_data[25];        //業種
    $defa_data["form_b_struct"]               = $client_data[26];        //業態
    $defa_data["form_claim"]["cd1"]           = $client_data[27];        //請求先コード１
    $defa_data["form_claim"]["cd2"]           = $client_data[28];        //請求先コード２
    $defa_data["form_claim"]["name"]          = $client_data[29];        //請求先名
    $defa_data["form_intro_act"]["cd"]        = $client_data[30];        //紹介口座先コード
    $defa_data["form_intro_act"]["name"]      = $client_data[31];        //紹介口座先名
    if($client_data[32] != null){
		$defa_data["form_account"]["1"] = 1;
    	$check_which = 1;
  		$defa_data["form_account"]["price"]       = $client_data[32];        //口座料
    }
    if($client_data[33] != null){
		$defa_data["form_account"]["2"] = 1;
    	$check_which = 2;
    	$defa_data["form_account"]["rate"]        = $client_data[33];        //口座料(率)
    }
    $defa_data["form_cshop"]                  = $client_data[34];        //担当支店
    $defa_data["form_c_staff_id1"]            = $client_data[35];        //契約担当１
    $defa_data["form_c_staff_id2"]            = $client_data[36];        //契約担当２
    $defa_data["form_d_staff_id1"]            = $client_data[37];        //巡回担当１
    $defa_data["form_d_staff_id2"]            = $client_data[38];        //巡回担当２
    $defa_data["form_d_staff_id3"]            = $client_data[39];        //巡回担当３
    $defa_data["form_col_terms"]              = $client_data[40];        //回収条件
    $defa_data["form_cledit_limit"]           = $client_data[41];        //与信限度
    $defa_data["form_capital"]                = $client_data[42];        //資本金
    $defa_data["form_work"]                   = $client_data[43];        //取引区分
    $defa_data["form_close"]                  = $client_data[44];        //締日
    $defa_data["form_pay_m"]                  = $client_data[45];        //支払日(月) 
    $defa_data["form_pay_d"]                  = $client_data[46];        //支払日(日)
    $defa_data["form_pay_way"]                = $client_data[47];        //支払方法
    $defa_data["form_bank"]                   = $client_data[48];        //振込銀行
    $defa_data["form_pay_name"]               = $client_data[49];        //振込名義
    $defa_data["form_account_name"]           = $client_data[50];        //口座名義
    $cont_s_day[y] = substr($client_data[51],0,4);
    $cont_s_day[m] = substr($client_data[51],5,2);
    $cont_s_day[d] = substr($client_data[51],8,2);
    $cont_e_day[y] = substr($client_data[52],0,4);
    $cont_e_day[m] = substr($client_data[52],5,2);
    $cont_e_day[d] = substr($client_data[52],8,2);
    $cont_r_day[y] = substr($client_data[54],0,4);
    $cont_r_day[m] = substr($client_data[54],5,2);
    $cont_r_day[d] = substr($client_data[54],8,2);
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];          //契約年月日(年)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];          //契約年月日(月)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];          //契約年月日(日)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];          //契約終了日(年)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];          //契約終了日(月)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];          //契約終了日(日)
    $defa_data["form_cont_peri"]              = $client_data[53];        //契約期間
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];          //契約更新日(年)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];          //契約更新日(月)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];          //契約更新日(日)
    
    $defa_data["form_slip_out"]               = $client_data[55];        //伝票発行
    $defa_data["form_deliver_note"]           = $client_data[56];        //納品書コメント
    $defa_data["form_claim_out"]              = $client_data[57];        //請求書発行
    $defa_data["form_coax"]                   = $client_data[58];        //金額
    $defa_data["form_tax_io"]                 = $client_data[59];        //消費税(課税区分)
    $defa_data["form_tax_io"]                 = $client_data[60];        //消費税(課税単位)
    $defa_data["form_tax_io"]                 = $client_data[61];        //消費税(端数区分)
    $defa_data["form_note"]                   = $client_data[62];        //設備情報等・その他
    
    //初期値設定
    $form->setDefaults($defa_data);
}


/***************************/
//フォーム作成
/***************************/
//得意先コード
$form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$form_client[] =& $form->createElement(
        "text","cd2","",'size="4" maxLength="4"'." $g_form_option"
        );
$form->addGroup( $form_client, "form_client", "");

//取引中
$form->addElement(
        'checkbox', 'form_state', '', ''
        );

//得意先名
$form->addElement(
        "text","form_client_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//得意先名（フリガナ）
$form->addElement(
        "text","form_client_read","",'size="34" maxLength="30"'." $g_form_option"
        );

//略称
$form->addElement(
        "text","form_client_cname","",'size="34" maxLength="10"'." $g_form_option"
        );

//郵便番号
$form_post[] =& $form->createElement(
        "text","no1","","size=\"3\" maxLength=\"3\" onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","",'size="4" maxLength="4"'." $g_form_option"
        );
$form->addGroup( $form_post, "form_post", "");

//住所１
$form->addElement(
        "text","form_address1","",'size="34" maxLength="15"'." $g_form_option"
        );

//住所２
$form->addElement(
        "text","form_address2","",'size="34" maxLength="15"'." $g_form_option"
        );

//住所(フリガナ)
$form->addElement(
        "text","form_address_read","",'size="51" maxLength="55"'." $g_form_option"
        );
        
//郵便番号
//自動入力ボタンが押下された場合
if($_POST["input_button_flg"]==true){
	$post1     = $_POST["form_post"]["no1"];             //得意先コード１
	$post2     = $_POST["form_post"]["no2"];             //得意先コード２
	$post_value = Post_Get($post1,$post2,$conn);
    //郵便番号フラグをクリア
    $cons_data["input_button"] = "";
	//郵便番号から自動入力
	$cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
	$cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
	$cons_data["form_address_read"] = $post_value[0];
	$cons_data["form_address1"] = $post_value[1];
	$cons_data["form_address2"] = $post_value[2];

	$form->setConstants($cons_data);
}

//地区
$select_ary = Select_Get($conn,'area');
$form->addElement('select', 'form_area_id',"", $select_ary,$g_form_option_select);

//TEL
$form->addElement(
        "text","form_tel","",'size="15" maxLength="12"'." $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","",'size="15" maxLength="12"'." $g_form_option"
        );

//代表者
$form->addElement(
        "text","form_rep_name","",'size="22" maxLength="10"'." $g_form_option"
        );

//ご担当者1
$form->addElement(
        "text","form_charger1","",'size="22" maxLength="10"'." $g_form_option"
        );

//ご担当者2
$form->addElement(
        "text","form_charger2","",'size="22" maxLength="10"'." $g_form_option"
        );

//ご担当者3
$form->addElement(
        "text","form_charger3","",'size="22" maxLength="10"'." $g_form_option"
        );

//ご担当者4
$form->addElement(
        "text","form_charger4","",'size="22" maxLength="10"'." $g_form_option"
        );

//ご担当者5
$form->addElement(
        "text","form_charger5","",'size="22" maxLength="10"'." $g_form_option"
        );

//営業時間
//午前開始時間
$form_stime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime1[h]','form_trade_stime1[m]',2)\"".$g_form_option."\""
        );
$form_stime1[] =& $form->createElement(
        "static","","","："
        );
$form_stime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime1[m]','form_trade_etime1[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime1,"form_trade_stime1","");

//午前終了時間
$form_etime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime1[h]','form_trade_etime1[m]',2)\"".$g_form_option."\""
        );
$form_etime1[] =& $form->createElement(
        "static","","","："
        );
$form_etime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime1[m]','form_trade_stime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_etime1,"form_trade_etime1","");

//午後開始時間
$form_stime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime2[h]','form_trade_stime2[m]',2)\"".$g_form_option."\""
        );
$form_stime2[] =& $form->createElement(
        "static","","","："
        );
$form_stime2[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime2[m]','form_trade_etime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime2,"form_trade_stime2","");

//午後終了時間
$form_etime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime2[h]','form_trade_etime2[m]',2)\"".$g_form_option."\""
        );
$form_etime2[] =& $form->createElement(
        "static","","","："
        );
$form_etime2[] =& $form->createElement(
        "text","m","",'size="2" maxLength="2"'." $g_form_option"
        );
$form->addGroup( $form_etime2,"form_trade_etime2","");

//休日
$form->addElement(
        "text","form_holiday","",'size="22" maxLength="10"'." $g_form_option"
        );
//業種
$select_ary = Select_Get($conn,'btype');
$form->addElement('select', 'form_btype',"", $select_ary,$g_form_option_select);

//業態
$form->addElement(
        "text","form_b_struct","",'size="22" maxLength="10"'." $g_form_option"
        );

//請求先
$form_claim[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" 
        onkeyup=\"changeText(this.form,'form_claim[cd1]','form_claim[cd2]',6)\"\"
        onkeyup=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]')\"".$g_form_option."\""
        );
$form_claim[] =& $form->createElement(
        "static","","","-"
        );
$form_claim[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" 
        onKeyUp=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]')\"".$g_form_option."\"" 
        );
$form_claim[] =& $form->createElement(
        "text","name","",'size="34" 
        style="color : #000000; 
        border : #ffffff 1px solid; 
        background-color: #ffffff;" 
        readonly'
        );
$form->addGroup( $form_claim, "form_claim", "");

//紹介口座先
$form_intro_act[] =& $form->createElement(
        "text","cd","","size=\"7\" maxLength=\"6\" 
        onKeyUp=\"javascript:client(this,'form_intro_act[name]')\" 
        onFocus=\"onForm(this)\" 
        onBlur=\"blurForm(this)\""
        );
$form_intro_act[] =& $form->createElement(
        "text","name","",'size="34" 
        style="color : #000000;
         border : #ffffff 1px solid;
         background-color: #ffffff;"
         readonly'
        );
$form->addGroup( $form_intro_act, "form_intro_act", "");

//口座料(口座名義ごと)
$form_account[] =& $form->createElement( 
        "checkbox","1" ,"" ,"" ," 
        onClick='return Check_Button2(1);'"
        );
$form_account[] =& $form->createElement(
        "static","　","","売上の"
        );
$form_account[] =& $form->createElement(
        "text","price","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );
$form_account[] =& $form->createElement(
        "static","","","円　　　　"
        );
$form_account[] =& $form->createElement( 
        "checkbox","2" ,"" ,"" ," 
        onClick='return Check_Button2(2);'"
        );
$form_account[] =& $form->createElement(
        "static","","","売上の"
        );
$form_account[] =& $form->createElement(
        "text","rate","",'size="3" maxLength="3" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"');
$form_account[] =& $form->createElement(
        "static","","","％"
        );
$form->addGroup( $form_account, "form_account", "");

//担当支店
$where  = " WHERE";
$where .= "     t_shop.shop_gid = 1 ";
$where .= "     AND";
$where .= "     t_shop.shop_cd1 = t_client.client_cd1";
$where .= "     AND";
$where .= "     t_shop.shop_cd2 = t_client.client_cd2";
$where .= "     AND";
$where .= "     t_client.client_div = 1";
$where .= "     AND";
$where .= "     t_client.shop_gid = 1";


$select_ary = Select_Get($conn,'cshop', $where);
$form->addElement('select', 'form_cshop',"", $select_ary, $g_form_option_select );

//契約担当1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id1',"", $select_ary, $g_form_option_select );

//契約担当2
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id2',"", $select_ary, $g_form_option_select );

//巡回担当者1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id1',"", $select_ary, $g_form_option_select );

//巡回担当者2
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id2',"", $select_ary, $g_form_option_select );

//巡回担当者3
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id3',"", $select_ary, $g_form_option_select );

//回収条件
$form->addElement(
        "text","form_col_terms","",'size="34" maxLength="50"'." $g_form_option"
        );

//与信限度
$form->addElement(
        "text","form_cledit_limit","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//資本金
$form->addElement(
        "text","form_capital","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//取引区分
$form_work[] =& $form->createElement( "radio",NULL,NULL, "掛売上","11");
$form_work[] =& $form->createElement( "radio",NULL,NULL, "現金売上","61");
$form->addGroup($form_work, "form_work", "");

//締日
//$form_close_day = array(
$form_close_day[0] = "";
for($i=1;$i<31;$i++){
	$form_close_day[$i]  = $i."日";
}
$form_close_day[31] = "月末";
$form_close_day[91] = "現金";
$form_close_day[99] = "随時締日";

$form->addElement("select", "form_close", "締日", $form_close_day);
//支払日
//月
$form->addElement(
        "text","form_pay_m","",'size="2" maxLength="2" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );
//日
$form->addElement(
        "text","form_pay_d","",'size="2" maxLength="2" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//支払い方法
$form->addElement(
        "text","form_pay_way","",'size="15" maxLength="7"'." $g_form_option"
        );

//振込銀行
$select_ary = Select_Get($conn,'bank');
$form->addElement('select', 'form_bank',"", $select_ary,$g_form_option_select);

//振込名義
$form->addElement(
        "text","form_pay_name","",'size="34" maxLength="50"'." $g_form_option"
        );

//口座名義
$form->addElement(
        "text","form_account_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//契約年月日
$form_cont_s_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_s_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_s_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_cont_s_day,"form_cont_s_day","");

//契約終了日
$form_cont_e_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" 
        style=\"color : #000000; 
        border : #ffffff 1px solid; 
        background-color: #ffffff;\" 
        readonly"
        );
$form_cont_e_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_e_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
        style=\"color : #000000; 
        border : #ffffff 1px solid; 
        background-color: #ffffff;\" 
        readonly"
        );
$form_cont_e_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_e_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" 
        style=\"color : #000000; 
        border : #ffffff 1px solid; 
        background-color: #ffffff;\" 
        readonly"
        );
$form->addGroup( $form_cont_e_day,"form_cont_e_day","");

//契約期間
$form->addElement(
        "text","form_cont_peri","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\" $g_form_option
        style=\"text-align: right\""
        );

//契約更新日
$form_cont_r_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_cont_r_day,"form_cont_r_day","");

//伝票発行
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "有","1");
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "無","2");
$form->addGroup($form_slip_out, "form_slip_out", "");

//納品書コメント
$form->addElement(
        "textarea","form_deliver_note","",' rows="5" cols="75"'." $g_form_option"
        );

//請求書発行
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "明細請求書","1");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "合計請求書","2");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "出力しない","3");
$form->addGroup($form_claim_out, "form_claim_out", "");

//金額
//丸め区分
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "切捨","1");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "四捨五入","2");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "切上","3");
$form->addGroup($form_coax, "form_coax", "");

//消費税
//課税区分
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "非課税","3");
$form->addGroup($form_tax_io, "form_tax_io", "");
//課税単位
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "締日単位","1");
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "伝票単位","2");
$form->addGroup($form_tax_div, "form_tax_div", "");
//端数区分
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "切捨","1");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "四捨五入","2");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "切上","3");
$form->addGroup($form_tax_franct, "form_tax_franct", "");

//設備情報等・その他
$form->addElement(
        "textarea","form_note","",' rows="3" cols="75"'." $g_form_option"
        );

//ボタン
//変更・一覧
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('1-1-113.php')\"");
//登録(ヘッダ)
$form->addElement("button","new_button","登　録","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
        "button","input_button","自動入力","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true')\""
        ); 
$button[] = $form->createElement(
        "submit","entry_button","登　録",
        "onClick=\"javascript:return Dialogue('登録します。','#')\""
);
$button[] = $form->createElement(
        "button","back_button","戻　る",
        "onClick='javascript:location.href = \"./1-1-113.php\"'
        ");
$button[] = $form->createElement(
        "button","res_button","実　績",
        "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-106.php?client_id=$_GET[client_id]','_blank','width=480,height=600')\""
        );
$form->addGroup($button, "button", "");
//hidden
$form->addElement("hidden", "input_button_flg");
/****************************/
//ルール作成
/****************************/
//■得意先コード
//●必須チェック
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('得意先コードは半角数字のみです。', 'required')
        ),      
        'cd2' => array(
                array('得意先コードは半角数字のみです。','required')
        ),      
));

//●半角数字チェック
$form->addGroupRule('form_client', array(
        'cd' => array(
                array('得意先コードは半角数字のみです。', 'numeric')
        ),      
        'name' => array(
                array('得意先コードは半角数字のみです。','numeric')
        ),      
));

//■得意先名
//●必須チェック
$form->addRule("form_client_name", "得意先名は1文字以上15文字以下です。","required");

//■略称
//●必須チェック
$form->addRule("form_client_cname", "略称は1文字以上15文字以下です。","required");

//■郵便番号
//●必須チェック
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', 'required')
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。','required')
        ),
));
//●半角数字チェック
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', 'numeric')
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。','numeric')
        ),
));
//●文字数チェック
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(4,4))
        ),
));


//■住所１
//●必須チェック
$form->addRule("form_address1", "住所１は1文字以上15文字以下です。","required");

//■地区
//●必須チェック
$form->addRule("form_area_id", "地区を選択して下さい。","required");

//■TEL
//●必須チェック
$form->addRule(form_tel, "TELは半角数字と「-」の13桁以内です。", "required");
//■FAX
//●必須チェック
$form->addRule(form_fax, "FAXは半角数字と「-」の13桁以内です。", "required");

//■代表者氏名
//●必須チェック
$form->addRule("form_rep_name", "代表者氏名は1文字以上10文字以下です。","required");

//■営業時間
//■午前開始時間
//●半角数字チェック
$form->addGroupRule('form_trade_stime1', array(
        'h' => array(
                array('営業時間は半角数字のみです。', 'numeric')
        ),
        'm' => array(
                array('営業時間は半角数字のみです。','numeric')
        ),
));

//■午前終了時間
//●半角数字チェック
$form->addGroupRule('form_trade_etime1', array(
        'h' => array(
                array('営業時間は半角数字のみです。', 'numeric')
        ),
        'm' => array(
                array('営業時間は半角数字のみです。','numeric')
        ),
));

//■午後開始時間
//●半角数字チェック
$form->addGroupRule('form_trade_stime2', array(
        'h' => array(
                array('営業時間は半角数字のみです。', 'numeric')
        ),
        'm' => array(
                array('営業時間は半角数字のみです。','numeric')
        ),
));

//■午後終了時間
//●半角数字チェック
$form->addGroupRule('form_trade_etime2', array(
        'h' => array(
                array('営業時間は半角数字のみです。', 'numeric')
        ),
        'm' => array(
                array('営業時間は半角数字のみです。','numeric')
        ),
));
//■口座料
//●半角数字チェック
$form->addGroupRule('form_account', array(
        'price' => array(
                array('口座料は半角数字のみです。', 'numeric')
        ),
        'rate' => array(
                array('口座料は半角数字のみです。','numeric')
        ),
));

//■担当支店
//●入力チェック
$form->addRule("form_cshop", "担当支店を選択して下さい。","required");

//■与信限度
//●半角数字チェック
$form->addRule("form_cledit_limit", "与信限度は半角数字のみです。", "numeric");

//■資本金
//●半角数字チェック
$form->addRule("form_capital", "資本金は半角数字のみです。", "numeric");

//■支払日（月）
//●半角数字チェック
$form->addRule("form_pay_m", "支払日（月）は半角数字のみです。", "required");
$form->addRule("form_pay_m", "支払日（月）は半角数字のみです。", "numeric");

//■支払日（日）
//●半角数字チェック
$form->addRule("form_pay_d", "支払日（日）は半角数字のみです。", "required");
$form->addRule("form_pay_d", "支払日（日）は半角数字のみです。", "numeric");


//■契約年月日
//●半角数字チェック
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(
                array('契約年月日の日付は妥当ではありません。', 'numeric')
        ),
        'm' => array(
                array('契約年月日の日付は妥当ではありません。','numeric')
        ),
        'd' => array(
                array('契約年月日の日付は妥当ではありません。','numeric')
        ),
));
//■契約終了日
//●半角数字チェック
$form->addGroupRule('form_cont_e_day', array(
        'y' => array(
                array('契約終了日の日付は妥当ではありません。', 'numeric')
        ),
        'm' => array(
                array('契約終了日の日付は妥当ではありません。','numeric')
        ),
        'd' => array(
                array('契約年月日の日付は妥当ではありません。','numeric')
        ),
));
//■契約更新日
//●半角数字チェック
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(
                array('契約更新日の日付は妥当ではありません。', 'numeric')
        ),
        'm' => array(
                array('契約更新日の日付は妥当ではありません。','numeric')
        ),
        'd' => array(
                array('契約更新日の日付は妥当ではありません。','numeric')
        ),
));


//■納品書コメント
//●半角数字チェック
$form->addRule("form_deliver_note", "納品書コメントは50文字以内です。", "rangelength",array(0,50));

//■契約期間
//●半角数字チェック
$form->addRule("form_cont_peri", "契約期間は半角数字のみです。", "numeric");
/***************************/
//ルール作成（PHP）
/***************************/
if($_POST["button"]["entry_button"] == "登　録"){
    /****************************/
    //POST取得
    /****************************/
    $client_cd1     = $_POST["form_client"]["cd1"];             //得意先コード１
    $client_cd2     = $_POST["form_client"]["cd2"];             //得意先コード２
    $state          = $_POST["form_state"];                     //状態
    $client_name    = $_POST["form_client_name"];               //得意先名
    $client_read    = $_POST["form_client_read"];               //得意先名（フリガナ）
    $client_cname   = $_POST["form_client_cname"];              //略称
    $post_no1       = $_POST["form_post"]["no1"];               //郵便番号１
    $post_no2       = $_POST["form_post"]["no2"];               //郵便番号２
    $address1       = $_POST["form_address1"];                  //住所１
    $address2       = $_POST["form_address2"];                  //住所２
    $address_read   = $_POST["form_address_read"];              //住所１（フリガナ）
    $area_id        = $_POST["form_area_id"];                   //地区コード
    $tel            = $_POST["form_tel"];                       //TEL
    $fax            = $_POST["form_fax"];                       //FAX
    $rep_name       = $_POST["form_rep_name"];                  //代表者氏名
    $charger1       = $_POST["form_charger1"];                  //ご担当者１
    $charger2       = $_POST["form_charger2"];                  //ご担当者２
    $charger3       = $_POST["form_charger3"];                  //ご担当者３
    $charger4       = $_POST["form_charger4"];                  //ご担当者４
    $charger5       = $_POST["form_charger5"];                  //ご担当者５
    $trade_stime1   = $_POST["form_trade_stime1"]["h"];         //営業時間（午前開始）
    $trade_stime1  .= ":"; 
    $trade_stime1  .= $_POST["form_trade_stime1"]["m"];
    $trade_etime1   = $_POST["form_trade_etime1"]["h"];         //営業時間（午前終了）
    $trade_etime1  .= ":"; 
    $trade_etime1  .= $_POST["form_trade_etime1"]["m"];
    $trade_stime2   = $_POST["form_trade_stime2"]["h"];         //営業時間（午後開始）
    $trade_stime2  .= ":"; 
    $trade_stime2  .= $_POST["form_trade_stime2"]["m"];
    $trade_etime2   = $_POST["form_trade_etime2"]["h"];         //営業時間（午後終了）
    $trade_etime2  .= ":"; 
    $trade_etime2  .= $_POST["form_trade_etime2"]["m"];
    $holiday        = $_POST["form_holiday"];                   //休日
    $btype          = $_POST["form_btype"];                     //業種コード
    $b_struct       = $_POST["form_b_struct"];                  //業態
    $claim_cd1      = $_POST["form_claim"]["cd1"];              //請求先コード１
    $claim_cd2      = $_POST["form_claim"]["cd2"];              //請求先コード２
    $claim_name     = $_POST["form_claim"]["name"];             //請求先名
    $intro_act_cd   = $_POST["form_intro_act"]["cd"];           //紹介口座先コード
    $intro_act_name = $_POST["form_intro_act"]["name"];         //紹介口座先名
    $price_check    = $_POST["form_account"]["1"];
    $account_price  = $_POST["form_account"]["price"];          //口座料
    $rate_check     = $_POST["form_account"]["2"];
    $account_rate   = $_POST["form_account"]["rate"];           //口座率
    $cshop_id       = $_POST["form_cshop"];                     //担当支店
    $c_staff_id1    = $_POST["form_c_staff_id1"];               //契約担当１
    $c_staff_id2    = $_POST["form_c_staff_id2"];               //契約担当２
    $d_staff_id1    = $_POST["form_d_staff_id1"];               //巡回担当１
    $d_staff_id2    = $_POST["form_d_staff_id2"];               //巡回担当２
    $d_staff_id3    = $_POST["form_d_staff_id3"];               //巡回担当３
    $col_terms      = $_POST["form_col_terms"];                 //回収条件
    $cledit_limit   = $_POST["form_cledit_limit"];              //与信限度
    $capital        = $_POST["form_capital"];                   //資本金
    $work_cd        = $_POST["form_work"];                      //取引区分
    $close_day_cd   = $_POST["form_close"];                     //締日
    $pay_m          = $_POST["form_pay_m"];                     //支払日（月）
    $pay_d          = $_POST["form_pay_d"];                     //支払日（日）
    $pay_way        = $_POST["form_pay_way"];                   //支払方法
    $bank_enter_cd  = $_POST["form_bank"];                      //銀行呼出コード
    $pay_name       = $_POST["form_pay_name"];                  //振込名義
    $account_name   = $_POST["form_account_name"];              //口座名義
    $cont_s_day      = $_POST["form_cont_s_day"]["y"];            //契約開始日
    $cont_s_day     .= $_POST["form_cont_s_day"]["m"];
    $cont_s_day     .= $_POST["form_cont_s_day"]["d"];
    $cont_e_day      = $_POST["form_cont_e_day"]["y"];            //契約終了日
    $cont_e_day     .= $_POST["form_cont_e_day"]["m"];
    $cont_e_day     .= $_POST["form_cont_e_day"]["d"];
    $cont_peri      = $_POST["form_cont_peri"];                 //契約期間
    $cont_r_day      = $_POST["form_cont_r_day"]["y"];            //契約更新日
    $cont_r_day     .= $_POST["form_cont_r_day"]["m"];
    $cont_r_day     .= $_POST["form_cont_r_day"]["d"];
    $slip_out       = $_POST["form_slip_out"];                  //伝票発行
    $deliver_note   = $_POST["form_deliver_note"];              //納品書コメント
    $claim_out      = $_POST["form_claim_out"];                 //請求書発行
    $coax           = $_POST["form_coax"];                      //金額：丸め区分
    $tax_io         = $_POST["form_tax_io"];                    //消費税：課税区分
    $tax_div        = $_POST["form_tax_div"];                   //消費税：課税単位
    $tax_franct     = $_POST["form_tax_franct"];                //消費税：端数区分
    $note           = $_POST["form_note"];                      //設備情報等・その他
	/****************************/
	//口座料チェックボックス判別
	/****************************/
	if($price_check == 1){
	    $check_which = 1;
	}else if($rate_check == 1){
	    $check_which = 2;
	}else{
		$check_which = 0;
	}
    //０埋め
    //得意先コード１
    $client_cd1_len = strlen('$client_cd1');
    for($i=$client_cd1_len;$i<6;$i++){
		$zero1 .= '0';
    }
    $client_cd1 = $zero1.$client_cd1;
    //０埋め
    //得意先コード２
    $client_cd2_len = strlen('$client_cd2');
    for($i=$client_cd2_len;$i<4;$i++){
		$zero2 .= '0';
    }
    $client_cd2 = $zero2.$client_cd2;
    if($client_cd1 != null && $client_cd2 != null){
	    $client_cd_sql  = "SELECT";
	    $client_cd_sql  .= " client_id FROM t_client";
	    $client_cd_sql  .= " WHERE";
	    $client_cd_sql  .= " client_cd1 = '$client_cd1'";
	    $client_cd_sql  .= " AND";
	    $client_cd_sql  .= " '$client_data[0]' != '$client_cd1'";
	    $client_cd_sql  .= " AND";
	    $client_cd_sql  .= " client_cd2 = '$client_cd2'";
	    $client_cd_sql  .= " AND";
	    $client_cd_sql  .= " '$client_data[1]' != '$client_cd2'";
        $client_cd_sql  .= "  AND";
        $client_cd_sql  .= "  client_div = '1'";
	    $client_cd_sql  .= ";";
		$select_client = Db_Query($conn, $client_cd_sql);
		$select_client = pg_num_rows($select_client);
		if($select_client != 0){
			$client_cd_err = "入力された得意先コードは使用中です。";
	  		$err_flg = true;
		}
	}
	
	//●正規表現
	if(!ereg("^[0-9]+-[0-9]+-[0-9]+$", $tel)){
		$tel_err = "TELは半角数字と「-」の13桁以内です。";
	  	$err_flg = true;
	}
	//●正規表現
	if(!ereg("^[0-9]+-[0-9]+-[0-9]+$", $fax)){
		$tel_err = "FAXは半角数字と「-」の13桁以内です。";
	  	$err_flg = true;
	}
	
	//■締日
	//●必須チェック
	if($_POST["form_close"] == 0){
	    $close_err = "締日を選択して下さい。";
  		$err_flg = true;
	}
	
    //■請求先
    //●入力チェック
    if($_POST["form_claim"]["cd1"] != null && $_POST["form_claim"]["name"] == null || $_POST["form_claim"]["cd2"] != null && $_POST["form_claim"]["name"] == null){
        $claim_err = "正しい請求先コードを入力して下さい。";
  		$err_flg = true;
    }

    //■紹介口座先
    //●入力チェック
    if($_POST["form_intro_act"]["cd"] != null && $_POST["form_intro_act"]["name"] == null){
        $intro_act_err = "正しい紹介口座先コードを入力して下さい。";
  		$err_flg = true;
    }
    
	//■契約年月日・契約更新日
	//●日付の妥当性チェック
	$sday_y = (int)$_POST["form_cont_s_day"]["y"];
	$sday_m = (int)$_POST["form_cont_s_day"]["m"];
	$sday_d = (int)$_POST["form_cont_s_day"]["d"];
	$rday_y = (int)$_POST["form_cont_r_day"]["y"];
	$rday_m = (int)$_POST["form_cont_r_day"]["m"];
	$rday_d = (int)$_POST["form_cont_r_day"]["d"];

	$cont_s_day = checkdate($sday_m,$sday_d,$sday_y);
	if($sday_m != null || $sday_d != null || $sday_y != null){
		$sday_flg = true;
	}
	if($cont_s_day == false && $sday_flg == true){
		$sday_err = "契約年月日の日付は妥当ではありません。";
	  	$err_flg = true;
	}
	$cont_r_day = checkdate($rday_m,$rday_d,$rday_y);
	if($rday_m != null || $rday_d != null || $rday_y != null){
		$rday_flg = true;
	}
	if($cont_r_day == false && $rday_flg == true){
		$rday_err = "契約更新日の日付は妥当ではありません。";
	  	$err_flg = true;
	}

	//●契約更新日が契約年月日よりも前でないかチェック
	if($cont_s_day >= $cont_r_day && $cont_s_day != null && $cont_r_day != null){
		$sday_rday_err = "契約更新日の日付は妥当ではありません。";
	  	$err_flg = true;
	}
}
/****************************/
//検証
/****************************/
if($_POST["button"]["entry_button"] == "登　録" && $form->validate() && $err_flg != true ){
    /******************************/
    //DB登録情報
    /******************************/
    $create_day = date("Y-m-d");
    /******************************/
    //登録処理
    /******************************/
    if($new_flg == true){
   		Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                        //得意先ID
        $insert_sql .= "    client_cd1,";                       //得意先コード
        $insert_sql .= "    client_cd2,";                       //支店コード
        $insert_sql .= "    shop_gid,";                         //FCグループID
        $insert_sql .= "    shop_id,";                          //ショップID
        $insert_sql .= "    shop_aid,";                         //ショップ識別ID
        $insert_sql .= "    create_day,";                       //作成日
        $insert_sql .= "    state,";                            //状態
        $insert_sql .= "    client_name,";                      //得意先名
        $insert_sql .= "    client_read,";                      //得意先名（フリガナ）
        $insert_sql .= "    client_cname,";                     //略称
        $insert_sql .= "    post_no1,";                         //郵便番号１
        $insert_sql .= "    post_no2,";                         //郵便番号２
        $insert_sql .= "    address1,";                         //住所１
        $insert_sql .= "    address2,";                         //住所２
        $insert_sql .= "    address_read,";                     //住所（フリガナ）
        $insert_sql .= "    area_id,";                          //地区ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //代表者氏名
        $insert_sql .= "    c_staff_id1,";                         //契約担当１
        $insert_sql .= "    c_staff_id2,";                         //契約担当２
        $insert_sql .= "    d_staff_id1,";                         //巡回担当１
        $insert_sql .= "    d_staff_id2,";                         //巡回担当２
        $insert_sql .= "    d_staff_id3,";                         //巡回担当３
        $insert_sql .= "    charger1,";                         //ご担当者１
        $insert_sql .= "    charger2,";                         //ご担当者２
        $insert_sql .= "    charger3,";                         //ご担当者３
        $insert_sql .= "    charger4,";                         //ご担当者４
        $insert_sql .= "    charger5,";                         //ご担当者５
        $insert_sql .= "    trade_stime1,";                     //営業時間（午前開始）
        $insert_sql .= "    trade_etime1,";                     //営業時間（午前終了）
        $insert_sql .= "    trade_stime2,";                     //営業時間（午後開始）
        $insert_sql .= "    trade_etime2,";                     //営業時間（午後終了）
        $insert_sql .= "    btype_id,";                         //業種ID
        $insert_sql .= "    b_struct,";                         //業態
        $insert_sql .= "    holiday,";                          //休日
        $insert_sql .= "    close_day,";                        //締日
        $insert_sql .= "    work_cd,";                          //取引区分
        $insert_sql .= "    pay_m,";                            //支払日（月）
        $insert_sql .= "    pay_d,";                            //支払日（日）
        $insert_sql .= "    pay_way,";                          //支払方法
        $insert_sql .= "    account_name,";                     //口座名義
        $insert_sql .= "    pay_name,";                         //振込名義
        $insert_sql .= "    bank_id,";                          //銀行ID
        $insert_sql .= "    slip_out,";                         //伝票出力
        $insert_sql .= "    deliver_note,";                     //納品書コメント
        $insert_sql .= "    claim_out,";                        //請求書出力
        $insert_sql .= "    coax,";                             //金額：丸め区分
        $insert_sql .= "    tax_io,";                           //消費税：課税区分
        $insert_sql .= "    tax_div,";                          //消費税：課税単位
        $insert_sql .= "    tax_franct,";                       //消費税：端数区分
        $insert_sql .= "    cont_s_day,";                        //契約開始日
        $insert_sql .= "    cont_e_day,";                        //契約終了日
        $insert_sql .= "    cont_peri,";                        //契約期間
        $insert_sql .= "    cont_r_day,";                        //契約更新日
        $insert_sql .= "    col_terms,";                        //回収条件
        $insert_sql .= "    credit_limit,";                     //与信限度
        $insert_sql .= "    capital,";                          //資本金
        $insert_sql .= "    note,";                             //設備情報等/その他
        $insert_sql .= "    client_div,";                       //得意先区分
        $insert_sql .= "    cshop_id";                          //担当支店ID
        //口座料・口座率判別
        if($price_check == 1){
            $insert_sql .= "    ,account_price";                 //口座料
        }else if($rate_check == 1){
            $insert_sql .= "    ,account_rate";                  //口座率
        }
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd1',";                    //得意先コード
        $insert_sql .= "    '$client_cd2',";                    //支店コード
        $insert_sql .= "    $shop_gid,";                        //FCグループID
        $insert_sql .= "    $shop_id,";                         //ショップID
        $insert_sql .= "    $shop_aid,";                        //ショップ識別ID
		if($create_day == ""){
		   		$create_day = "    null"; 
		}
        $insert_sql .= "    '$create_day',";                    //作成日
        if($state == null){
			$state = 2;
		}
        $insert_sql .= "    '$state',";                         //状態
        $insert_sql .= "    '$client_name',";                   //得意先名
        $insert_sql .= "    '$client_read',";                   //得意先（フリガナ）
        $insert_sql .= "    '$client_cname',";                  //略称
        $insert_sql .= "    '$post_no1',";                      //郵便番号１
        $insert_sql .= "    '$post_no2',";                      //郵便番号２
        $insert_sql .= "    '$address1',";                      //住所１
        $insert_sql .= "    '$address2',";                      //住所２
        $insert_sql .= "    '$address_read',";                  //住所（フリガナ）
        $insert_sql .= "    $area_id,";                         //地区ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$rep_name',";                      //代表者氏名
        if($c_staff_id1 == ""){
		   		$c_staff_id1 = "    null"; 
		}
		if($c_staff_id2 == ""){
		   		$c_staff_id2 = "    null"; 
		}
		if($d_staff_id1 == ""){
		   		$d_staff_id1 = "    null";
		}
		if($d_staff_id2 == ""){
		   		$d_staff_id2 = "    null";
		}
		if($d_staff_id3 == ""){
		   		$d_staff_id3 = "    null";
		}
        $insert_sql .= "    $c_staff_id1,";                    //契約担当１
        $insert_sql .= "    $c_staff_id2,";                    //契約担当２
        $insert_sql .= "    $d_staff_id1,";                    //巡回担当１
        $insert_sql .= "    $d_staff_id2,";                    //巡回担当２
        $insert_sql .= "    $d_staff_id3,";                    //巡回担当３
        $insert_sql .= "    '$charger1',";                     //ご担当者１
        $insert_sql .= "    '$charger2',";                     //ご担当者２
        $insert_sql .= "    '$charger3',";                     //ご担当者３
        $insert_sql .= "    '$charger4',";                     //ご担当者４
        $insert_sql .= "    '$charger5',";                     //ご担当者５
        if($trade_stime1 == ":"){
	   		$insert_sql .= "    null,";
		}else{
        	$insert_sql .= "    '$trade_stime1',";             //営業時間（午前開始）
		}
		if($trade_etime1 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_etime1',";             //営業時間（午前終了）
		}
		if($trade_stime2 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_stime2',";             //営業時間（午後開始）
		}
		if($trade_etime2 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_etime2',";             //営業時間（午後終了）
		}
		if($btype == ""){
		        $btype = "    null"; 
		}
        $insert_sql .= "    $btype,";                           //業種ID
        $insert_sql .= "    '$b_struct',";                      //業態
        $insert_sql .= "    '$holiday',";                       //休日
        $insert_sql .= "    '$close_day_cd',";                  //締日
        $insert_sql .= "    '$work_cd',";                       //取引区分
		if($pay_m == ""){
		   		$pay_m = "    null"; 
		}
        $insert_sql .= "    '$pay_m',";                         //支払日（月）
		if($pay_d == ""){
		   		$pay_d = "    null"; 
		}
        $insert_sql .= "    '$pay_d',";                         //支払日（日）
        $insert_sql .= "    '$pay_way',";                       //支払い方法
        $insert_sql .= "    '$account_name',";                  //口座名義
        $insert_sql .= "    '$pay_name',";                      //振込名義
		if($bank_id == ""){
		        $bank_id = "    null"; 
		}
        $insert_sql .= "    $bank_id,";                         //銀行
        $insert_sql .= "    '$slip_out',";                      //伝票出力
        $insert_sql .= "    '$deliver_note',";                  //納品書コメント
        $insert_sql .= "    '$claim_out',";                     //請求書出力
        $insert_sql .= "    '$coax',";                          //金額：丸め区分
        $insert_sql .= "    '$tax_io',";                        //消費税：課税区分
        $insert_sql .= "    '$tax_div',";                       //消費税：課税単位
        $insert_sql .= "    '$tax_franct',";                    //消費税：端数単位
		if($cont_s_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_s_day',";                 //契約開始日
		}
		if($cont_e_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_e_day',";                 //契約終了日
		}
		if($cont_peri == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_peri',";                 //契約期間
		}
		if($cont_r_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_r_day',";                 //契約更新日
		}
        $insert_sql .= "    '$col_terms',";                     //回収条件
        $insert_sql .= "    '$cledit_limit',";                  //与信限度
        $insert_sql .= "    '$capital',";                       //資本金
        $insert_sql .= "    '$note',";                          //設備情報等/その他
        $insert_sql .= "    '1',";                              //得意先区分
	    $insert_sql .= "    $cshop_id";                         //ショップ識別ID
        //口座料・口座率判別
        if($price_check == 1){
            $insert_sql .= "    ,$account_price";               //口座料
        }else if($rate_check == 1){
            $insert_sql .= "    ,$account_rate";                //口座料(率)
        }
        $insert_sql .= ");";
        
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        
        //■請求先
        //●入力時
        if($claim_cd1 != null && $claim_cd2 != null && $claim_name != null){
            $insert_sql = " INSERT INTO t_claim (";
            $insert_sql .= "    client_id,";
            $insert_sql .= "    claim_id";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$claim_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$claim_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    )";
            $insert_sql .= ");";
	    	$result = Db_Query($conn, $insert_sql);
        }else if($claim_cd1 == null && $claim_cd2 == null && $claim_name == null){
            $insert_sql = " INSERT INTO t_claim (";
            $insert_sql .= "    client_id,";
            $insert_sql .= "    claim_id";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    )";
            $insert_sql .= ");";
	    	$result = Db_Query($conn, $insert_sql);
        }
	    if($result === false){
	        Db_Query($conn, "ROLLBACK;");
	        exit;
	    }

        //■紹介口座先
        //●入力時
        if($intro_act_cd != null &&$intro_act_name != null){
            $insert_sql = " INSERT INTO t_intro_act (";
            $insert_sql .= "    client_id,";				
            $insert_sql .= "    intro_account_id";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_gid = $shop_gid";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$intro_act_cd'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '2'";
            $insert_sql .= "    )";
            $insert_sql .= ");";
	   		$result = Db_Query($conn, $insert_sql);
        }
        
	    if($result === false){
	        Db_Query($conn, "ROLLBACK;");
	        exit;
	    }
    /******************************/
	//更新処理
    /******************************/
    }else if($new_flg == false){
		//得意先マスタ
	   	Db_Query($conn, "BEGIN;");
		$update_sql = "UPDATE";
		$update_sql .= "	t_client";
		$update_sql .= " SET";
		$update_sql .= "    client_cd1 = '$client_cd1',";
		$update_sql .= "    client_cd2 = '$client_cd2',";
		$update_sql .= "    state = '$state',";
		$update_sql .= "    client_name = '$client_name',";
		$update_sql .= "    client_read = '$client_read',";
		$update_sql .= "    client_cname = '$client_cname',";
		$update_sql .= "    post_no1 = '$post_no1',";
		$update_sql .= "    post_no2 = '$post_no2',";
		$update_sql .= "    address1 = '$address1',";
		$update_sql .= "    address2 = '$address2',";
		$update_sql .= "    address_read = '$address_read',";
		$update_sql .= "    area_id = $area_id,";
		$update_sql .= "    tel = '$tel',";
		$update_sql .= "    fax = '$fax',";
		$update_sql .= "    rep_name = '$rep_name',";
		if($c_staff_id1 == ""){
			$c_staff_id1 = null;
		}
		if($c_staff_id2 == ""){
			$c_staff_id2 = null;
		}
		if($d_staff_id1 == ""){
			$d_staff_id1 = null;
		}
		if($d_staff_id2 == ""){
			$d_staff_id2 = null;
		}
		if($d_staff_id3 == ""){
			$d_staff_id3 = null;
		}
		$update_sql .= "    charger1 = '$charger1',";
		$update_sql .= "    charger2 = '$charger2',";
		$update_sql .= "    charger3 = '$charger3',";
		$update_sql .= "    charger4 = '$charger4',";
		$update_sql .= "    charger5 = '$charger5',";
		
		if($trade_stime1 == ":"){
		$update_sql .= "		trade_stime1 = null,";
		}else{
		$update_sql .= "	    trade_stime1 = '$trade_stime1',";
		}
		if($trade_etime1 == ":"){
		$update_sql .= "		trade_etime1 = null,";
		}else{
		$update_sql .= "	    trade_etime1 = '$trade_etime1',";
		}
		if($trade_stime2 == ":"){
		$update_sql .= "		trade_stime2 = null,";
		}else{
		$update_sql .= "	    trade_stime2 = '$trade_stime2',";
		}
		if($trade_etime2 == ":"){
		$update_sql .= "		trade_etime2 = null,";
		}else{
		$update_sql .= "	    trade_etime2 = '$trade_etime2',";
		}
		$update_sql .= "    holiday = '$holiday',";
		if($btype == ""){
			$update_sql .= "    btype_id = null,";
		}else{
			$update_sql .= "    btype_id = $btype,";
		}
		$update_sql .= "    b_struct = '$b_struct',";
		if($price_check == 1){
			$update_sql .= "    	account_price = $account_price,";
			$update_sql .= "    	account_rate = null,";
		}else if($rate_check == 1){
			$update_sql .= "    	account_rate = $account_rate,";
			$update_sql .= "    	account_price = null,";
		}else{
			$update_sql .= "    	account_price = null,";
			$update_sql .= "    	account_rate = null,";
		}
		$update_sql .= "    cshop_id = $cshop_id,";
		if($c_staff_id1 == ""){
			$update_sql .= "	c_staff_id1 = null,";
		}else{
			$update_sql .= "    c_staff_id1 = $c_staff_id1,";
		}
		if($c_staff_id2 == ""){
			$update_sql .= "	c_staff_id2 = null,";
		}else{
			$update_sql .= "    c_staff_id2 = $c_staff_id2,";
		}
		if($d_staff_id1 == ""){
			$update_sql .= "	d_staff_id1 = null,";
		}else{
			$update_sql .= "    d_staff_id1 = $d_staff_id1,";
		}
		if($d_staff_id2 == ""){
			$update_sql .= "	d_staff_id2 = null,";
		}else{
			$update_sql .= "    d_staff_id2 = $d_staff_id2,";
		}
		if($d_staff_id3 == ""){
			$update_sql .= "	d_staff_id3 = null,";
		}else{
			$update_sql .= "    d_staff_id3 = $d_staff_id3,";
		}
		$update_sql .= "    col_terms = '$col_terms',";
		$update_sql .= "    credit_limit = '$cledit_limit',";
		$update_sql .= "    capital = '$capital',";
		$update_sql .= "    work_cd = '$work_cd',";
		$update_sql .= "    close_day = '$close_day_cd',";
		if($pay_m == ""){
		$update_sql .= "	   	pay_m = '',";
		}else{
		$update_sql .= "    	pay_m = '$pay_m',";
		}
		if($pay_d == ""){
		$update_sql .= "	   	pay_d = '',";
		}else{
		$update_sql .= "    	pay_d = '$pay_d',";
		}
		$update_sql .= "    pay_way = '$pay_way',";
		if($bank_id == ""){
			$update_sql .= "	   	bank_id = null,";
		}else{
			$update_sql .= "    	bank_id = $bank_id,";
		}
		$update_sql .= "    pay_name = '$pay_way',";
		$update_sql .= "    account_name = '$account_name',";
		if($cont_s_day == ""){
		$update_sql .= "		cont_s_day = null,";
		}else{
		$update_sql .= "	    cont_s_day = '$cont_s_day',";
		}
		if($cont_e_day == ""){
		$update_sql .= "		cont_e_day = null,";
		}else{
		$update_sql .= "	    cont_e_day = '$cont_e_day',";
		}
		if($cont_peri == ""){
		$update_sql .= "		cont_peri = '',";
		}else{
		$update_sql .= "	    cont_peri = '$cont_peri',";
		}
		if($cont_r_day == ""){
		$update_sql .= "		cont_r_day = null,";
		}else{
		$update_sql .= "	    cont_r_day = '$cont_r_day',";
		}
		$update_sql .= "    slip_out = '$slip_out',";
		$update_sql .= "    deliver_note = '$deliver_note',";
		$update_sql .= "    claim_out = '$claim_out',";
		$update_sql .= "    coax = '$coax',";
		$update_sql .= "    tax_io = '$tax_io',";
		$update_sql .= "    tax_div = '$tax_div',";
		$update_sql .= "    tax_franct = '$tax_franct',";
		$update_sql .= "    note = '$note'";
		$update_sql .= " WHERE";
		$update_sql .= "    client_id = $_GET[client_id]";
		$update_sql .= ";";
	    $result = Db_Query($conn, $update_sql);
	    if($result === false){
	        Db_Query($conn, "ROLLBACK;");
	        exit;
	    }
		//紹介口座先マスタ
	    $update_sql = " UPDATE t_intro_act";
	    $update_sql .= " SET";
	    $update_sql .= "    intro_account_id = (SELECT";
	    $update_sql .= "        client_id";
	    $update_sql .= "    FROM";
	    $update_sql .= "        t_client";
	    $update_sql .= "    WHERE";
	    $update_sql .= "        shop_gid = $shop_gid";
	    $update_sql .= "        AND";
	    $update_sql .= "        client_cd1 = '$intro_act_cd'";
	    $update_sql .= "        AND";
	    $update_sql .= "        client_div = '2'";
		$update_sql .= "	) ";
		$update_sql .= "WHERE ";
		$update_sql .= "client_id = $_GET[client_id]";
		$update_sql .= ";";
	    $result = Db_Query($conn, $update_sql);
	    if($result === false){
	        Db_Query($conn, "ROLLBACK;");
	        exit;
	    }
		//請求先マスタ
	    if($claim_cd1 != null && $claim_cd2 != null && $claim_name != null){
		    $update_sql = " UPDATE  t_claim ";
		    $update_sql .= "SET ";
		    $update_sql .= "    claim_id = (SELECT";
		    $update_sql .= "        client_id";
		    $update_sql .= "    FROM";
		    $update_sql .= "        t_client";
		    $update_sql .= "    WHERE";
		    $update_sql .= "        shop_gid = $shop_gid";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_cd1 = '$claim_cd1'";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_cd2 = '$claim_cd2'";
		    $update_sql .= "        AND";
			$update_sql .= "    	client_id = $_GET[client_id]";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_div = '1'";
		    $update_sql .= "	) ";
		    $update_sql .= "WHERE ";
		    $update_sql .= "client_id = $_GET[client_id]";
		    $update_sql .= ";";
	    	$result = Db_Query($conn, $update_sql);
		    if($result === false){
		        Db_Query($conn, "ROLLBACK;");
		        exit;
		    }
	    }else if($claim_cd1 == null && $claim_cd2 == null && $claim_name == null){
		    $update_sql = " UPDATE  t_claim ";
		    $update_sql .= "SET ";
		    $update_sql .= "    claim_id = (SELECT";
		    $update_sql .= "        client_id";
		    $update_sql .= "    FROM";
		    $update_sql .= "        t_client";
		    $update_sql .= "    WHERE";
		    $update_sql .= "        shop_gid = $shop_gid";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_cd1 = '$client_cd1'";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_cd2 = '$client_cd2'";
		    $update_sql .= "        AND";
			$update_sql .= "    	client_id = $_GET[client_id]";
		    $update_sql .= "        AND";
		    $update_sql .= "        client_div = '1'";
		    $update_sql .= "	) ";
		    $update_sql .= "WHERE ";
		    $update_sql .= "client_id = $_GET[client_id]";
		    $update_sql .= ";";
	    	$result = Db_Query($conn, $update_sql);
		    if($result === false){
		        Db_Query($conn, "ROLLBACK;");
		        exit;
		    }
	    }
		//更新履歴テーブル
        $update_sql  = " INSERT INTO t_renew (";
        $update_sql .= "    client_id,";                        //得意先ID
        $update_sql .= "    staff_id,";                         //スタッフID
        $update_sql .= "    renew_time";                        //現在のtimestamp
        $update_sql .= " )VALUES(";
        $update_sql .= "    (SELECT";
        $update_sql .= "        client_id";
        $update_sql .= "    FROM";
        $update_sql .= "        t_client";
        $update_sql .= "    WHERE";
        $update_sql .= "        shop_gid = $shop_gid";
        $update_sql .= "        AND";
        $update_sql .= "        client_cd1 = '$client_cd1'";
        $update_sql .= "        AND";
        $update_sql .= "        client_cd2 = '$client_cd2'";
        $update_sql .= "        AND";
        $update_sql .= "        client_div = '1'";
        $update_sql .= "    ),";
	    $update_sql .= "	$staff_id,";
	    $update_sql .= "	NOW()";
	    $update_sql .= ");";
	    
	    $result = Db_Query($conn, $update_sql);
	    if($result === false){
	        Db_Query($conn, "ROLLBACK;");
	        exit;
	    }
	}
    Db_Query($conn, "COMMIT;");
    header("Location: ./1-1-113.php");
}


/***************************/
//Code_value
/***************************/
//請求先
$where_sql = "    WHERE";
$where_sql .= "        shop_gid = $shop_gid";
$where_sql .= "        AND";
$where_sql .= "        client_div = '1'";
$code_value = Code_Value("t_client",$conn,"$where_sql",1);
$where_sql = "    WHERE";
$where_sql .= "        shop_gid = $shop_gid";
$where_sql .= "        AND";
$where_sql .= "        client_div = '2'";
$code_value .= Code_Value("t_client",$conn,"$where_sql",2);



/****************************契約終了日取得*************************/

$contract = "function Contract(me){\n";
$contract .= "	var TERM = \"form_cont_peri\";\n";
$contract .= "	var SY = \"form_cont_s_day[y]\";\n";
$contract .= "	var SM = \"form_cont_s_day[m]\";\n";
$contract .= "	var SD = \"form_cont_s_day[d]\";\n";
$contract .= "	var EY = \"form_cont_e_day[y]\";\n";
$contract .= "	var EM = \"form_cont_e_day[m]\";\n";
$contract .= "	var ED = \"form_cont_e_day[d]\";\n";
$contract .= "	var RY = \"form_cont_r_day[y]\";\n";
$contract .= "	var RM = \"form_cont_r_day[m]\";\n";
$contract .= "	var RD = \"form_cont_r_day[d]\";\n";
$contract .= "	var s_year = parseInt(me.elements[SY].value);\n";
$contract .= "	var r_year = parseInt(me.elements[RY].value);\n";
$contract .= "	var term = me.elements[TERM].value;\n";
$contract .= "	len_sy = me.elements[SY].value.length;\n";
$contract .= "	len_sm = me.elements[SM].value.length;\n";
$contract .= "	len_sd = me.elements[SD].value.length;\n";
$contract .= "	len_ry = me.elements[RY].value.length;\n";
$contract .= "	len_rm = me.elements[RM].value.length;\n";
$contract .= "	len_rd = me.elements[RD].value.length;\n";
$contract .= "	if(me.elements[RM].value == '02' && me.elements[RD].value == '29' && term != \"\" && len_ry == 4 && len_rm == 2 && len_rd == 2){\n";
$contract .= "		var term = parseInt(term);\n";
$contract .= "		me.elements[EY].value = r_year+term;\n";
$contract .= "		me.elements[EM].value = \"03\";\n";
$contract .= "		me.elements[ED].value = \"01\";\n";
$contract .= "	}else if(term != \"\" && len_ry == 4 && len_rm == 2 && len_rd == 2){\n";
$contract .= "		var term = parseInt(term);\n";
$contract .= "		me.elements[EY].value = r_year+term;\n";
$contract .= "		me.elements[EM].value = me.elements[RM].value;\n";
$contract .= "		me.elements[ED].value = me.elements[RD].value;\n";
$contract .= "	}else if(me.elements[SM].value == '02' && me.elements[SD].value == '29' && term != \"\" && len_sy == 4 && len_sm == 2 && len_sd == 2){\n";
$contract .= "		var term = parseInt(term);\n";
$contract .= "		me.elements[EY].value = s_year+term;\n";
$contract .= "		me.elements[EM].value = \"03\";\n";
$contract .= "		me.elements[ED].value = \"01\";\n";
$contract .= "	}else if(term != \"\" && len_sy == 4 && len_sm == 2 && len_sd == 2){\n";
$contract .= "		var term = parseInt(term);\n";
$contract .= "		me.elements[EY].value = s_year+term;\n";
$contract .= "		me.elements[EM].value = me.elements[SM].value;\n";
$contract .= "		me.elements[ED].value = me.elements[SD].value;\n";
$contract .= "	}else{\n";
$contract .= "		me.elements[EY].value = \"\";\n";
$contract .= "		me.elements[EM].value = \"\";\n";
$contract .= "		me.elements[ED].value = \"\";\n";
$contract .= "	}\n";
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
//画面ヘッダー作成
/****************************/

/****************************/
//全件数取得
/****************************/
$client_sql  = " SELECT";
$client_sql .= "     *";
$client_sql .= " FROM";
$client_sql .= "     t_client,";
$client_sql .= "     t_area";
$client_sql .= " WHERE";
$client_sql .= "     t_client.area_id = t_area.area_id";
$client_sql .= "     AND";
$client_sql .= "     t_client.shop_gid = $shop_gid";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = 1";

//ヘッダーに表示させる全件数
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_num_rows($count_res);

$page_title .= "　（全".$total_count."件）";
$page_title .= "　　　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'claim_err'     => "$claim_err",
    'intro_act_err' => "$intro_act_err",
    'close_err'     => "$close_err",
    'c_staff_err'   => "$c_staff_err",
    'sday_err'      => "$sday_err",
    'rday_err'      => "$rday_err",
    'sday_rday_err' => "$sday_rday_err",
    'code_value'    => "$code_value",
    'check_which'   => "$check_which",
    'client_cd_err' => "$client_cd_err",
    'contract' => "$contract",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

