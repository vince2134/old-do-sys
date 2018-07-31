<?php
$page_title = "��������Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DB����³
$conn = Db_Connect();
/****************************/
//���������(radio)
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
//����Ƚ��
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
//��������GET���������
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
    //������ȯ��
    $result = Db_Query($conn, $select_sql);
    //�ǡ�������
    $client_data = pg_fetch_array ($result, 0, PGSQL_NUM);
    //����ͥǡ���
    $defa_data["form_client"]["cd1"]          = $client_data[0];         //�����襳���ɣ�
    $defa_data["form_client"]["cd2"]          = $client_data[1];         //�����襳���ɣ�
    if($client_data[2] == 1){
  	   $defa_data["form_state"]               = 1;                       //�����
    }
    $defa_data["form_client_name"]            = $client_data[3];         //������̾
    $defa_data["form_client_read"]            = $client_data[4];         //������̾(�եꥬ��)
    $defa_data["form_client_cname"]           = $client_data[5];         //ά��
    $defa_data["form_post"]["no1"]            = $client_data[6];         //͹���ֹ棱
    $defa_data["form_post"]["no2"]            = $client_data[7];         //͹���ֹ棲
    $defa_data["form_address1"]               = $client_data[8];         //���꣱
    $defa_data["form_address2"]               = $client_data[9];         //���ꣲ
    $defa_data["form_address_read"]           = $client_data[10];        //����(�եꥬ��)
    $defa_data["form_area_id"]                = $client_data[11];        //�϶�
    $defa_data["form_tel"]                    = $client_data[12];        //TEL
    $defa_data["form_fax"]                    = $client_data[13];        //FAX
    $defa_data["form_rep_name"]               = $client_data[14];        //��ɽ�Ի�̾
    $defa_data["form_charger1"]               = $client_data[15];        //��ô���ԣ�
    $defa_data["form_charger2"]               = $client_data[16];        //��ô���ԣ�
    $defa_data["form_charger3"]               = $client_data[17];        //��ô���ԣ�
    $defa_data["form_charger4"]               = $client_data[18];        //��ô���ԣ�
    $defa_data["form_charger5"]               = $client_data[19];        //��ô���ԣ�
    $trade_stime1[1] = substr($client_data[20],0,2);
    $trade_stime1[2] = substr($client_data[20],3,2);
    $trade_etime1[1] = substr($client_data[21],0,2);
    $trade_etime1[2] = substr($client_data[21],3,2);
    $trade_stime2[1] = substr($client_data[22],0,2);
    $trade_stime2[2] = substr($client_data[22],3,2);
    $trade_etime2[1] = substr($client_data[23],0,2);
    $trade_etime2[2] = substr($client_data[23],3,2);
    $defa_data["form_trade_stime1"]["h"]      = $trade_stime1[1];        //�ĶȻ���(�������ϻ���)
    $defa_data["form_trade_stime1"]["m"]      = $trade_stime1[2];        //�ĶȻ���(�������ϻ���)
    $defa_data["form_trade_etime1"]["h"]      = $trade_etime1[1];        //�ĶȻ���(������λ����)
    $defa_data["form_trade_etime1"]["m"]      = $trade_etime1[2];        //�ĶȻ���(������λ����)
    $defa_data["form_trade_stime2"]["h"]      = $trade_stime2[1];        //�ĶȻ���()
    $defa_data["form_trade_stime2"]["m"]      = $trade_stime2[2];        //�ĶȻ���()
    $defa_data["form_trade_etime2"]["h"]      = $trade_etime2[1];        //�ĶȻ���()
    $defa_data["form_trade_etime2"]["m"]      = $trade_etime2[2];        //�ĶȻ���()
    $defa_data["form_holiday"]                = $client_data[24];        //����
    $defa_data["form_btype"]                  = $client_data[25];        //�ȼ�
    $defa_data["form_b_struct"]               = $client_data[26];        //����
    $defa_data["form_claim"]["cd1"]           = $client_data[27];        //�����襳���ɣ�
    $defa_data["form_claim"]["cd2"]           = $client_data[28];        //�����襳���ɣ�
    $defa_data["form_claim"]["name"]          = $client_data[29];        //������̾
    $defa_data["form_intro_act"]["cd"]        = $client_data[30];        //�Ҳ�����襳����
    $defa_data["form_intro_act"]["name"]      = $client_data[31];        //�Ҳ������̾
    if($client_data[32] != null){
		$defa_data["form_account"]["1"] = 1;
    	$check_which = 1;
  		$defa_data["form_account"]["price"]       = $client_data[32];        //������
    }
    if($client_data[33] != null){
		$defa_data["form_account"]["2"] = 1;
    	$check_which = 2;
    	$defa_data["form_account"]["rate"]        = $client_data[33];        //������(Ψ)
    }
    $defa_data["form_cshop"]                  = $client_data[34];        //ô����Ź
    $defa_data["form_c_staff_id1"]            = $client_data[35];        //����ô����
    $defa_data["form_c_staff_id2"]            = $client_data[36];        //����ô����
    $defa_data["form_d_staff_id1"]            = $client_data[37];        //���ô����
    $defa_data["form_d_staff_id2"]            = $client_data[38];        //���ô����
    $defa_data["form_d_staff_id3"]            = $client_data[39];        //���ô����
    $defa_data["form_col_terms"]              = $client_data[40];        //������
    $defa_data["form_cledit_limit"]           = $client_data[41];        //Ϳ������
    $defa_data["form_capital"]                = $client_data[42];        //���ܶ�
    $defa_data["form_work"]                   = $client_data[43];        //�����ʬ
    $defa_data["form_close"]                  = $client_data[44];        //����
    $defa_data["form_pay_m"]                  = $client_data[45];        //��ʧ��(��) 
    $defa_data["form_pay_d"]                  = $client_data[46];        //��ʧ��(��)
    $defa_data["form_pay_way"]                = $client_data[47];        //��ʧ��ˡ
    $defa_data["form_bank"]                   = $client_data[48];        //�������
    $defa_data["form_pay_name"]               = $client_data[49];        //����̾��
    $defa_data["form_account_name"]           = $client_data[50];        //����̾��
    $cont_s_day[y] = substr($client_data[51],0,4);
    $cont_s_day[m] = substr($client_data[51],5,2);
    $cont_s_day[d] = substr($client_data[51],8,2);
    $cont_e_day[y] = substr($client_data[52],0,4);
    $cont_e_day[m] = substr($client_data[52],5,2);
    $cont_e_day[d] = substr($client_data[52],8,2);
    $cont_r_day[y] = substr($client_data[54],0,4);
    $cont_r_day[m] = substr($client_data[54],5,2);
    $cont_r_day[d] = substr($client_data[54],8,2);
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];          //����ǯ����(ǯ)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];          //����ǯ����(��)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];          //����ǯ����(��)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];          //����λ��(ǯ)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];          //����λ��(��)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];          //����λ��(��)
    $defa_data["form_cont_peri"]              = $client_data[53];        //�������
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];          //���󹹿���(ǯ)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];          //���󹹿���(��)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];          //���󹹿���(��)
    
    $defa_data["form_slip_out"]               = $client_data[55];        //��ɼȯ��
    $defa_data["form_deliver_note"]           = $client_data[56];        //Ǽ�ʽ񥳥���
    $defa_data["form_claim_out"]              = $client_data[57];        //�����ȯ��
    $defa_data["form_coax"]                   = $client_data[58];        //���
    $defa_data["form_tax_io"]                 = $client_data[59];        //������(���Ƕ�ʬ)
    $defa_data["form_tax_io"]                 = $client_data[60];        //������(����ñ��)
    $defa_data["form_tax_io"]                 = $client_data[61];        //������(ü����ʬ)
    $defa_data["form_note"]                   = $client_data[62];        //����������������¾
    
    //���������
    $form->setDefaults($defa_data);
}


/***************************/
//�ե��������
/***************************/
//�����襳����
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

//�����
$form->addElement(
        'checkbox', 'form_state', '', ''
        );

//������̾
$form->addElement(
        "text","form_client_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//������̾�ʥեꥬ�ʡ�
$form->addElement(
        "text","form_client_read","",'size="34" maxLength="30"'." $g_form_option"
        );

//ά��
$form->addElement(
        "text","form_client_cname","",'size="34" maxLength="10"'." $g_form_option"
        );

//͹���ֹ�
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

//���꣱
$form->addElement(
        "text","form_address1","",'size="34" maxLength="15"'." $g_form_option"
        );

//���ꣲ
$form->addElement(
        "text","form_address2","",'size="34" maxLength="15"'." $g_form_option"
        );

//����(�եꥬ��)
$form->addElement(
        "text","form_address_read","",'size="51" maxLength="55"'." $g_form_option"
        );
        
//͹���ֹ�
//��ư���ϥܥ��󤬲������줿���
if($_POST["input_button_flg"]==true){
	$post1     = $_POST["form_post"]["no1"];             //�����襳���ɣ�
	$post2     = $_POST["form_post"]["no2"];             //�����襳���ɣ�
	$post_value = Post_Get($post1,$post2,$conn);
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button"] = "";
	//͹���ֹ椫�鼫ư����
	$cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
	$cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
	$cons_data["form_address_read"] = $post_value[0];
	$cons_data["form_address1"] = $post_value[1];
	$cons_data["form_address2"] = $post_value[2];

	$form->setConstants($cons_data);
}

//�϶�
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

//��ɽ��
$form->addElement(
        "text","form_rep_name","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ô����1
$form->addElement(
        "text","form_charger1","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ô����2
$form->addElement(
        "text","form_charger2","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ô����3
$form->addElement(
        "text","form_charger3","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ô����4
$form->addElement(
        "text","form_charger4","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ô����5
$form->addElement(
        "text","form_charger5","",'size="22" maxLength="10"'." $g_form_option"
        );

//�ĶȻ���
//�������ϻ���
$form_stime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime1[h]','form_trade_stime1[m]',2)\"".$g_form_option."\""
        );
$form_stime1[] =& $form->createElement(
        "static","","","��"
        );
$form_stime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime1[m]','form_trade_etime1[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime1,"form_trade_stime1","");

//������λ����
$form_etime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime1[h]','form_trade_etime1[m]',2)\"".$g_form_option."\""
        );
$form_etime1[] =& $form->createElement(
        "static","","","��"
        );
$form_etime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime1[m]','form_trade_stime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_etime1,"form_trade_etime1","");

//��峫�ϻ���
$form_stime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime2[h]','form_trade_stime2[m]',2)\"".$g_form_option."\""
        );
$form_stime2[] =& $form->createElement(
        "static","","","��"
        );
$form_stime2[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_stime2[m]','form_trade_etime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime2,"form_trade_stime2","");

//��彪λ����
$form_etime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" 
         onkeyup=\"changeText(this.form,'form_trade_etime2[h]','form_trade_etime2[m]',2)\"".$g_form_option."\""
        );
$form_etime2[] =& $form->createElement(
        "static","","","��"
        );
$form_etime2[] =& $form->createElement(
        "text","m","",'size="2" maxLength="2"'." $g_form_option"
        );
$form->addGroup( $form_etime2,"form_trade_etime2","");

//����
$form->addElement(
        "text","form_holiday","",'size="22" maxLength="10"'." $g_form_option"
        );
//�ȼ�
$select_ary = Select_Get($conn,'btype');
$form->addElement('select', 'form_btype',"", $select_ary,$g_form_option_select);

//����
$form->addElement(
        "text","form_b_struct","",'size="22" maxLength="10"'." $g_form_option"
        );

//������
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

//�Ҳ������
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

//������(����̾������)
$form_account[] =& $form->createElement( 
        "checkbox","1" ,"" ,"" ," 
        onClick='return Check_Button2(1);'"
        );
$form_account[] =& $form->createElement(
        "static","��","","����"
        );
$form_account[] =& $form->createElement(
        "text","price","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );
$form_account[] =& $form->createElement(
        "static","","","�ߡ�������"
        );
$form_account[] =& $form->createElement( 
        "checkbox","2" ,"" ,"" ," 
        onClick='return Check_Button2(2);'"
        );
$form_account[] =& $form->createElement(
        "static","","","����"
        );
$form_account[] =& $form->createElement(
        "text","rate","",'size="3" maxLength="3" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"');
$form_account[] =& $form->createElement(
        "static","","","��"
        );
$form->addGroup( $form_account, "form_account", "");

//ô����Ź
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

//����ô��1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id1',"", $select_ary, $g_form_option_select );

//����ô��2
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_c_staff_id2',"", $select_ary, $g_form_option_select );

//���ô����1
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id1',"", $select_ary, $g_form_option_select );

//���ô����2
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id2',"", $select_ary, $g_form_option_select );

//���ô����3
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_d_staff_id3',"", $select_ary, $g_form_option_select );

//������
$form->addElement(
        "text","form_col_terms","",'size="34" maxLength="50"'." $g_form_option"
        );

//Ϳ������
$form->addElement(
        "text","form_cledit_limit","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//���ܶ�
$form->addElement(
        "text","form_capital","",'size="11" maxLength="9" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//�����ʬ
$form_work[] =& $form->createElement( "radio",NULL,NULL, "�����","11");
$form_work[] =& $form->createElement( "radio",NULL,NULL, "�������","61");
$form->addGroup($form_work, "form_work", "");

//����
//$form_close_day = array(
$form_close_day[0] = "";
for($i=1;$i<31;$i++){
	$form_close_day[$i]  = $i."��";
}
$form_close_day[31] = "����";
$form_close_day[91] = "����";
$form_close_day[99] = "�������";

$form->addElement("select", "form_close", "����", $form_close_day);
//��ʧ��
//��
$form->addElement(
        "text","form_pay_m","",'size="2" maxLength="2" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );
//��
$form->addElement(
        "text","form_pay_d","",'size="2" maxLength="2" 
        onFocus="onForm(this)" 
        onBlur="blurForm(this)" 
        style="text-align: right"'
        );

//��ʧ����ˡ
$form->addElement(
        "text","form_pay_way","",'size="15" maxLength="7"'." $g_form_option"
        );

//�������
$select_ary = Select_Get($conn,'bank');
$form->addElement('select', 'form_bank',"", $select_ary,$g_form_option_select);

//����̾��
$form->addElement(
        "text","form_pay_name","",'size="34" maxLength="50"'." $g_form_option"
        );

//����̾��
$form->addElement(
        "text","form_account_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//����ǯ����
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

//����λ��
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

//�������
$form->addElement(
        "text","form_cont_peri","","size=\"2\" maxLength=\"2\" 
        onkeyup=\"Contract(this.form)\" $g_form_option
        style=\"text-align: right\""
        );

//���󹹿���
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

//��ɼȯ��
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup($form_slip_out, "form_slip_out", "");

//Ǽ�ʽ񥳥���
$form->addElement(
        "textarea","form_deliver_note","",' rows="5" cols="75"'." $g_form_option"
        );

//�����ȯ��
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "���������","1");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "��������","2");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "���Ϥ��ʤ�","3");
$form->addGroup($form_claim_out, "form_claim_out", "");

//���
//�ݤ��ʬ
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_coax, "form_coax", "");

//������
//���Ƕ�ʬ
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$form_tax_io[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup($form_tax_io, "form_tax_io", "");
//����ñ��
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����ñ��","1");
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "��ɼñ��","2");
$form->addGroup($form_tax_div, "form_tax_div", "");
//ü����ʬ
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_tax_franct, "form_tax_franct", "");

//����������������¾
$form->addElement(
        "textarea","form_note","",' rows="3" cols="75"'." $g_form_option"
        );

//�ܥ���
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('1-1-113.php')\"");
//��Ͽ(�إå�)
$form->addElement("button","new_button","�С�Ͽ","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$button[] = $form->createElement(
        "button","input_button","��ư����","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true')\""
        ); 
$button[] = $form->createElement(
        "submit","entry_button","�С�Ͽ",
        "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#')\""
);
$button[] = $form->createElement(
        "button","back_button","�ᡡ��",
        "onClick='javascript:location.href = \"./1-1-113.php\"'
        ");
$button[] = $form->createElement(
        "button","res_button","�¡���",
        "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-106.php?client_id=$_GET[client_id]','_blank','width=480,height=600')\""
        );
$form->addGroup($button, "button", "");
//hidden
$form->addElement("hidden", "input_button_flg");
/****************************/
//�롼�����
/****************************/
//�������襳����
//��ɬ�ܥ����å�
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', 'required')
        ),      
        'cd2' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���','required')
        ),      
));

//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_client', array(
        'cd' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),      
        'name' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),      
));

//��������̾
//��ɬ�ܥ����å�
$form->addRule("form_client_name", "������̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//��ά��
//��ɬ�ܥ����å�
$form->addRule("form_client_cname", "ά�Τ�1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//��͹���ֹ�
//��ɬ�ܥ����å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'required')
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���','required')
        ),
));
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'numeric')
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���','numeric')
        ),
));
//��ʸ���������å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(4,4))
        ),
));


//�����꣱
//��ɬ�ܥ����å�
$form->addRule("form_address1", "���꣱��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//���϶�
//��ɬ�ܥ����å�
$form->addRule("form_area_id", "�϶�����򤷤Ʋ�������","required");

//��TEL
//��ɬ�ܥ����å�
$form->addRule(form_tel, "TEL��Ⱦ�ѿ����ȡ�-�פ�13�����Ǥ���", "required");
//��FAX
//��ɬ�ܥ����å�
$form->addRule(form_fax, "FAX��Ⱦ�ѿ����ȡ�-�פ�13�����Ǥ���", "required");

//����ɽ�Ի�̾
//��ɬ�ܥ����å�
$form->addRule("form_rep_name", "��ɽ�Ի�̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");

//���ĶȻ���
//���������ϻ���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime1', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),
));

//��������λ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime1', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),
));

//����峫�ϻ���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime2', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),
));

//����彪λ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime2', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),
));
//��������
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_account', array(
        'price' => array(
                array('��������Ⱦ�ѿ����ΤߤǤ���', 'numeric')
        ),
        'rate' => array(
                array('��������Ⱦ�ѿ����ΤߤǤ���','numeric')
        ),
));

//��ô����Ź
//�����ϥ����å�
$form->addRule("form_cshop", "ô����Ź�����򤷤Ʋ�������","required");

//��Ϳ������
//��Ⱦ�ѿ��������å�
$form->addRule("form_cledit_limit", "Ϳ�����٤�Ⱦ�ѿ����ΤߤǤ���", "numeric");

//�����ܶ�
//��Ⱦ�ѿ��������å�
$form->addRule("form_capital", "���ܶ��Ⱦ�ѿ����ΤߤǤ���", "numeric");

//����ʧ���ʷ��
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_m", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_m", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "numeric");

//����ʧ��������
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_d", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_d", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "numeric");


//������ǯ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���','numeric')
        ),
        'd' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���','numeric')
        ),
));
//������λ��
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_e_day', array(
        'y' => array(
                array('����λ�������դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('����λ�������դ������ǤϤ���ޤ���','numeric')
        ),
        'd' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���','numeric')
        ),
));
//�����󹹿���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���', 'numeric')
        ),
        'm' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���','numeric')
        ),
        'd' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���','numeric')
        ),
));


//��Ǽ�ʽ񥳥���
//��Ⱦ�ѿ��������å�
$form->addRule("form_deliver_note", "Ǽ�ʽ񥳥��Ȥ�50ʸ������Ǥ���", "rangelength",array(0,50));

//���������
//��Ⱦ�ѿ��������å�
$form->addRule("form_cont_peri", "������֤�Ⱦ�ѿ����ΤߤǤ���", "numeric");
/***************************/
//�롼�������PHP��
/***************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){
    /****************************/
    //POST����
    /****************************/
    $client_cd1     = $_POST["form_client"]["cd1"];             //�����襳���ɣ�
    $client_cd2     = $_POST["form_client"]["cd2"];             //�����襳���ɣ�
    $state          = $_POST["form_state"];                     //����
    $client_name    = $_POST["form_client_name"];               //������̾
    $client_read    = $_POST["form_client_read"];               //������̾�ʥեꥬ�ʡ�
    $client_cname   = $_POST["form_client_cname"];              //ά��
    $post_no1       = $_POST["form_post"]["no1"];               //͹���ֹ棱
    $post_no2       = $_POST["form_post"]["no2"];               //͹���ֹ棲
    $address1       = $_POST["form_address1"];                  //���꣱
    $address2       = $_POST["form_address2"];                  //���ꣲ
    $address_read   = $_POST["form_address_read"];              //���꣱�ʥեꥬ�ʡ�
    $area_id        = $_POST["form_area_id"];                   //�϶襳����
    $tel            = $_POST["form_tel"];                       //TEL
    $fax            = $_POST["form_fax"];                       //FAX
    $rep_name       = $_POST["form_rep_name"];                  //��ɽ�Ի�̾
    $charger1       = $_POST["form_charger1"];                  //��ô���ԣ�
    $charger2       = $_POST["form_charger2"];                  //��ô���ԣ�
    $charger3       = $_POST["form_charger3"];                  //��ô���ԣ�
    $charger4       = $_POST["form_charger4"];                  //��ô���ԣ�
    $charger5       = $_POST["form_charger5"];                  //��ô���ԣ�
    $trade_stime1   = $_POST["form_trade_stime1"]["h"];         //�ĶȻ��֡ʸ������ϡ�
    $trade_stime1  .= ":"; 
    $trade_stime1  .= $_POST["form_trade_stime1"]["m"];
    $trade_etime1   = $_POST["form_trade_etime1"]["h"];         //�ĶȻ��֡ʸ�����λ��
    $trade_etime1  .= ":"; 
    $trade_etime1  .= $_POST["form_trade_etime1"]["m"];
    $trade_stime2   = $_POST["form_trade_stime2"]["h"];         //�ĶȻ��֡ʸ�峫�ϡ�
    $trade_stime2  .= ":"; 
    $trade_stime2  .= $_POST["form_trade_stime2"]["m"];
    $trade_etime2   = $_POST["form_trade_etime2"]["h"];         //�ĶȻ��֡ʸ�彪λ��
    $trade_etime2  .= ":"; 
    $trade_etime2  .= $_POST["form_trade_etime2"]["m"];
    $holiday        = $_POST["form_holiday"];                   //����
    $btype          = $_POST["form_btype"];                     //�ȼ拾����
    $b_struct       = $_POST["form_b_struct"];                  //����
    $claim_cd1      = $_POST["form_claim"]["cd1"];              //�����襳���ɣ�
    $claim_cd2      = $_POST["form_claim"]["cd2"];              //�����襳���ɣ�
    $claim_name     = $_POST["form_claim"]["name"];             //������̾
    $intro_act_cd   = $_POST["form_intro_act"]["cd"];           //�Ҳ�����襳����
    $intro_act_name = $_POST["form_intro_act"]["name"];         //�Ҳ������̾
    $price_check    = $_POST["form_account"]["1"];
    $account_price  = $_POST["form_account"]["price"];          //������
    $rate_check     = $_POST["form_account"]["2"];
    $account_rate   = $_POST["form_account"]["rate"];           //����Ψ
    $cshop_id       = $_POST["form_cshop"];                     //ô����Ź
    $c_staff_id1    = $_POST["form_c_staff_id1"];               //����ô����
    $c_staff_id2    = $_POST["form_c_staff_id2"];               //����ô����
    $d_staff_id1    = $_POST["form_d_staff_id1"];               //���ô����
    $d_staff_id2    = $_POST["form_d_staff_id2"];               //���ô����
    $d_staff_id3    = $_POST["form_d_staff_id3"];               //���ô����
    $col_terms      = $_POST["form_col_terms"];                 //������
    $cledit_limit   = $_POST["form_cledit_limit"];              //Ϳ������
    $capital        = $_POST["form_capital"];                   //���ܶ�
    $work_cd        = $_POST["form_work"];                      //�����ʬ
    $close_day_cd   = $_POST["form_close"];                     //����
    $pay_m          = $_POST["form_pay_m"];                     //��ʧ���ʷ��
    $pay_d          = $_POST["form_pay_d"];                     //��ʧ��������
    $pay_way        = $_POST["form_pay_way"];                   //��ʧ��ˡ
    $bank_enter_cd  = $_POST["form_bank"];                      //��ԸƽХ�����
    $pay_name       = $_POST["form_pay_name"];                  //����̾��
    $account_name   = $_POST["form_account_name"];              //����̾��
    $cont_s_day      = $_POST["form_cont_s_day"]["y"];            //���󳫻���
    $cont_s_day     .= $_POST["form_cont_s_day"]["m"];
    $cont_s_day     .= $_POST["form_cont_s_day"]["d"];
    $cont_e_day      = $_POST["form_cont_e_day"]["y"];            //����λ��
    $cont_e_day     .= $_POST["form_cont_e_day"]["m"];
    $cont_e_day     .= $_POST["form_cont_e_day"]["d"];
    $cont_peri      = $_POST["form_cont_peri"];                 //�������
    $cont_r_day      = $_POST["form_cont_r_day"]["y"];            //���󹹿���
    $cont_r_day     .= $_POST["form_cont_r_day"]["m"];
    $cont_r_day     .= $_POST["form_cont_r_day"]["d"];
    $slip_out       = $_POST["form_slip_out"];                  //��ɼȯ��
    $deliver_note   = $_POST["form_deliver_note"];              //Ǽ�ʽ񥳥���
    $claim_out      = $_POST["form_claim_out"];                 //�����ȯ��
    $coax           = $_POST["form_coax"];                      //��ۡ��ݤ��ʬ
    $tax_io         = $_POST["form_tax_io"];                    //�����ǡ����Ƕ�ʬ
    $tax_div        = $_POST["form_tax_div"];                   //�����ǡ�����ñ��
    $tax_franct     = $_POST["form_tax_franct"];                //�����ǡ�ü����ʬ
    $note           = $_POST["form_note"];                      //����������������¾
	/****************************/
	//�����������å��ܥå���Ƚ��
	/****************************/
	if($price_check == 1){
	    $check_which = 1;
	}else if($rate_check == 1){
	    $check_which = 2;
	}else{
		$check_which = 0;
	}
    //�����
    //�����襳���ɣ�
    $client_cd1_len = strlen('$client_cd1');
    for($i=$client_cd1_len;$i<6;$i++){
		$zero1 .= '0';
    }
    $client_cd1 = $zero1.$client_cd1;
    //�����
    //�����襳���ɣ�
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
			$client_cd_err = "���Ϥ��줿�����襳���ɤϻ�����Ǥ���";
	  		$err_flg = true;
		}
	}
	
	//������ɽ��
	if(!ereg("^[0-9]+-[0-9]+-[0-9]+$", $tel)){
		$tel_err = "TEL��Ⱦ�ѿ����ȡ�-�פ�13�����Ǥ���";
	  	$err_flg = true;
	}
	//������ɽ��
	if(!ereg("^[0-9]+-[0-9]+-[0-9]+$", $fax)){
		$tel_err = "FAX��Ⱦ�ѿ����ȡ�-�פ�13�����Ǥ���";
	  	$err_flg = true;
	}
	
	//������
	//��ɬ�ܥ����å�
	if($_POST["form_close"] == 0){
	    $close_err = "���������򤷤Ʋ�������";
  		$err_flg = true;
	}
	
    //��������
    //�����ϥ����å�
    if($_POST["form_claim"]["cd1"] != null && $_POST["form_claim"]["name"] == null || $_POST["form_claim"]["cd2"] != null && $_POST["form_claim"]["name"] == null){
        $claim_err = "�����������襳���ɤ����Ϥ��Ʋ�������";
  		$err_flg = true;
    }

    //���Ҳ������
    //�����ϥ����å�
    if($_POST["form_intro_act"]["cd"] != null && $_POST["form_intro_act"]["name"] == null){
        $intro_act_err = "�������Ҳ�����襳���ɤ����Ϥ��Ʋ�������";
  		$err_flg = true;
    }
    
	//������ǯ���������󹹿���
	//�����դ������������å�
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
		$sday_err = "����ǯ���������դ������ǤϤ���ޤ���";
	  	$err_flg = true;
	}
	$cont_r_day = checkdate($rday_m,$rday_d,$rday_y);
	if($rday_m != null || $rday_d != null || $rday_y != null){
		$rday_flg = true;
	}
	if($cont_r_day == false && $rday_flg == true){
		$rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
	  	$err_flg = true;
	}

	//�����󹹿���������ǯ�����������Ǥʤ��������å�
	if($cont_s_day >= $cont_r_day && $cont_s_day != null && $cont_r_day != null){
		$sday_rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
	  	$err_flg = true;
	}
}
/****************************/
//����
/****************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){
    /******************************/
    //DB��Ͽ����
    /******************************/
    $create_day = date("Y-m-d");
    /******************************/
    //��Ͽ����
    /******************************/
    if($new_flg == true){
   		Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                        //������ID
        $insert_sql .= "    client_cd1,";                       //�����襳����
        $insert_sql .= "    client_cd2,";                       //��Ź������
        $insert_sql .= "    shop_gid,";                         //FC���롼��ID
        $insert_sql .= "    shop_id,";                          //����å�ID
        $insert_sql .= "    shop_aid,";                         //����å׼���ID
        $insert_sql .= "    create_day,";                       //������
        $insert_sql .= "    state,";                            //����
        $insert_sql .= "    client_name,";                      //������̾
        $insert_sql .= "    client_read,";                      //������̾�ʥեꥬ�ʡ�
        $insert_sql .= "    client_cname,";                     //ά��
        $insert_sql .= "    post_no1,";                         //͹���ֹ棱
        $insert_sql .= "    post_no2,";                         //͹���ֹ棲
        $insert_sql .= "    address1,";                         //���꣱
        $insert_sql .= "    address2,";                         //���ꣲ
        $insert_sql .= "    address_read,";                     //����ʥեꥬ�ʡ�
        $insert_sql .= "    area_id,";                          //�϶�ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //��ɽ�Ի�̾
        $insert_sql .= "    c_staff_id1,";                         //����ô����
        $insert_sql .= "    c_staff_id2,";                         //����ô����
        $insert_sql .= "    d_staff_id1,";                         //���ô����
        $insert_sql .= "    d_staff_id2,";                         //���ô����
        $insert_sql .= "    d_staff_id3,";                         //���ô����
        $insert_sql .= "    charger1,";                         //��ô���ԣ�
        $insert_sql .= "    charger2,";                         //��ô���ԣ�
        $insert_sql .= "    charger3,";                         //��ô���ԣ�
        $insert_sql .= "    charger4,";                         //��ô���ԣ�
        $insert_sql .= "    charger5,";                         //��ô���ԣ�
        $insert_sql .= "    trade_stime1,";                     //�ĶȻ��֡ʸ������ϡ�
        $insert_sql .= "    trade_etime1,";                     //�ĶȻ��֡ʸ�����λ��
        $insert_sql .= "    trade_stime2,";                     //�ĶȻ��֡ʸ�峫�ϡ�
        $insert_sql .= "    trade_etime2,";                     //�ĶȻ��֡ʸ�彪λ��
        $insert_sql .= "    btype_id,";                         //�ȼ�ID
        $insert_sql .= "    b_struct,";                         //����
        $insert_sql .= "    holiday,";                          //����
        $insert_sql .= "    close_day,";                        //����
        $insert_sql .= "    work_cd,";                          //�����ʬ
        $insert_sql .= "    pay_m,";                            //��ʧ���ʷ��
        $insert_sql .= "    pay_d,";                            //��ʧ��������
        $insert_sql .= "    pay_way,";                          //��ʧ��ˡ
        $insert_sql .= "    account_name,";                     //����̾��
        $insert_sql .= "    pay_name,";                         //����̾��
        $insert_sql .= "    bank_id,";                          //���ID
        $insert_sql .= "    slip_out,";                         //��ɼ����
        $insert_sql .= "    deliver_note,";                     //Ǽ�ʽ񥳥���
        $insert_sql .= "    claim_out,";                        //��������
        $insert_sql .= "    coax,";                             //��ۡ��ݤ��ʬ
        $insert_sql .= "    tax_io,";                           //�����ǡ����Ƕ�ʬ
        $insert_sql .= "    tax_div,";                          //�����ǡ�����ñ��
        $insert_sql .= "    tax_franct,";                       //�����ǡ�ü����ʬ
        $insert_sql .= "    cont_s_day,";                        //���󳫻���
        $insert_sql .= "    cont_e_day,";                        //����λ��
        $insert_sql .= "    cont_peri,";                        //�������
        $insert_sql .= "    cont_r_day,";                        //���󹹿���
        $insert_sql .= "    col_terms,";                        //������
        $insert_sql .= "    credit_limit,";                     //Ϳ������
        $insert_sql .= "    capital,";                          //���ܶ�
        $insert_sql .= "    note,";                             //����������/����¾
        $insert_sql .= "    client_div,";                       //�������ʬ
        $insert_sql .= "    cshop_id";                          //ô����ŹID
        //������������ΨȽ��
        if($price_check == 1){
            $insert_sql .= "    ,account_price";                 //������
        }else if($rate_check == 1){
            $insert_sql .= "    ,account_rate";                  //����Ψ
        }
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd1',";                    //�����襳����
        $insert_sql .= "    '$client_cd2',";                    //��Ź������
        $insert_sql .= "    $shop_gid,";                        //FC���롼��ID
        $insert_sql .= "    $shop_id,";                         //����å�ID
        $insert_sql .= "    $shop_aid,";                        //����å׼���ID
		if($create_day == ""){
		   		$create_day = "    null"; 
		}
        $insert_sql .= "    '$create_day',";                    //������
        if($state == null){
			$state = 2;
		}
        $insert_sql .= "    '$state',";                         //����
        $insert_sql .= "    '$client_name',";                   //������̾
        $insert_sql .= "    '$client_read',";                   //������ʥեꥬ�ʡ�
        $insert_sql .= "    '$client_cname',";                  //ά��
        $insert_sql .= "    '$post_no1',";                      //͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                      //͹���ֹ棲
        $insert_sql .= "    '$address1',";                      //���꣱
        $insert_sql .= "    '$address2',";                      //���ꣲ
        $insert_sql .= "    '$address_read',";                  //����ʥեꥬ�ʡ�
        $insert_sql .= "    $area_id,";                         //�϶�ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$rep_name',";                      //��ɽ�Ի�̾
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
        $insert_sql .= "    $c_staff_id1,";                    //����ô����
        $insert_sql .= "    $c_staff_id2,";                    //����ô����
        $insert_sql .= "    $d_staff_id1,";                    //���ô����
        $insert_sql .= "    $d_staff_id2,";                    //���ô����
        $insert_sql .= "    $d_staff_id3,";                    //���ô����
        $insert_sql .= "    '$charger1',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger2',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger3',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger4',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger5',";                     //��ô���ԣ�
        if($trade_stime1 == ":"){
	   		$insert_sql .= "    null,";
		}else{
        	$insert_sql .= "    '$trade_stime1',";             //�ĶȻ��֡ʸ������ϡ�
		}
		if($trade_etime1 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_etime1',";             //�ĶȻ��֡ʸ�����λ��
		}
		if($trade_stime2 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_stime2',";             //�ĶȻ��֡ʸ�峫�ϡ�
		}
		if($trade_etime2 == ":"){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$trade_etime2',";             //�ĶȻ��֡ʸ�彪λ��
		}
		if($btype == ""){
		        $btype = "    null"; 
		}
        $insert_sql .= "    $btype,";                           //�ȼ�ID
        $insert_sql .= "    '$b_struct',";                      //����
        $insert_sql .= "    '$holiday',";                       //����
        $insert_sql .= "    '$close_day_cd',";                  //����
        $insert_sql .= "    '$work_cd',";                       //�����ʬ
		if($pay_m == ""){
		   		$pay_m = "    null"; 
		}
        $insert_sql .= "    '$pay_m',";                         //��ʧ���ʷ��
		if($pay_d == ""){
		   		$pay_d = "    null"; 
		}
        $insert_sql .= "    '$pay_d',";                         //��ʧ��������
        $insert_sql .= "    '$pay_way',";                       //��ʧ����ˡ
        $insert_sql .= "    '$account_name',";                  //����̾��
        $insert_sql .= "    '$pay_name',";                      //����̾��
		if($bank_id == ""){
		        $bank_id = "    null"; 
		}
        $insert_sql .= "    $bank_id,";                         //���
        $insert_sql .= "    '$slip_out',";                      //��ɼ����
        $insert_sql .= "    '$deliver_note',";                  //Ǽ�ʽ񥳥���
        $insert_sql .= "    '$claim_out',";                     //��������
        $insert_sql .= "    '$coax',";                          //��ۡ��ݤ��ʬ
        $insert_sql .= "    '$tax_io',";                        //�����ǡ����Ƕ�ʬ
        $insert_sql .= "    '$tax_div',";                       //�����ǡ�����ñ��
        $insert_sql .= "    '$tax_franct',";                    //�����ǡ�ü��ñ��
		if($cont_s_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_s_day',";                 //���󳫻���
		}
		if($cont_e_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_e_day',";                 //����λ��
		}
		if($cont_peri == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_peri',";                 //�������
		}
		if($cont_r_day == ""){
	   		$insert_sql .= "    null,";
		}else{
	        $insert_sql .= "    '$cont_r_day',";                 //���󹹿���
		}
        $insert_sql .= "    '$col_terms',";                     //������
        $insert_sql .= "    '$cledit_limit',";                  //Ϳ������
        $insert_sql .= "    '$capital',";                       //���ܶ�
        $insert_sql .= "    '$note',";                          //����������/����¾
        $insert_sql .= "    '1',";                              //�������ʬ
	    $insert_sql .= "    $cshop_id";                         //����å׼���ID
        //������������ΨȽ��
        if($price_check == 1){
            $insert_sql .= "    ,$account_price";               //������
        }else if($rate_check == 1){
            $insert_sql .= "    ,$account_rate";                //������(Ψ)
        }
        $insert_sql .= ");";
        
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        
        //��������
        //�����ϻ�
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

        //���Ҳ������
        //�����ϻ�
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
	//��������
    /******************************/
    }else if($new_flg == false){
		//������ޥ���
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
		//�Ҳ������ޥ���
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
		//������ޥ���
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
		//��������ơ��֥�
        $update_sql  = " INSERT INTO t_renew (";
        $update_sql .= "    client_id,";                        //������ID
        $update_sql .= "    staff_id,";                         //�����å�ID
        $update_sql .= "    renew_time";                        //���ߤ�timestamp
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
//������
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



/****************************����λ������*************************/

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
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/

/****************************/
//���������
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

//�إå�����ɽ�������������
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_num_rows($count_res);

$page_title .= "������".$total_count."���";
$page_title .= "������".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
//����¾���ѿ���assign
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

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

