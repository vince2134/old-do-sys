<?php
$page_title = "������ޥ���";
/***********************************/
//�ѹ�����
//  ��2006/03/16��
//  ��SQL�ѹ�
//����shop_id��client_id���ѹ�
//����������ɲ�
//   (2006/08/29)
//  �����������������������������å��ɲ�
//  2006/11/13  0033    kaku-m  TEL��FAX�ֹ�Υ����å������줷�ƴؿ��ǹԤ��褦�˽�����
/***********************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/25��0092�������� watanabe-k��GET��񤭴�����С�������FC�ξ����ߤ뤳�Ȥ��Ǥ��Ƥ��ޤ���
 * ��2006/11/25��0093�������� watanabe-k��GET��ʸ������Ϥ��ȥ����ꥨ�顼��ɽ������롣
 * ��2006/11/25��0095�������� watanabe-k��������̾��Ⱦ��OR���ѥ��ڡ����Τߤ���Ͽ�Ǥ���
 *   2006-12-08  ban_0079     suzuki      ���˻Ĥ��ޥ���̾���ѹ�
 *   2007-01-24  �����ѹ�     watanabe-k  �ܥ���ο��ѹ�
 *   2007-02-22               watanabe-k  ���׵�ǽ�κ��
 *   2016/01/20                amano  Dialogue, Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�    
 * */

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//���������(radio)
/****************************/
$def_data["form_state"] = 1;
$def_data["form_coax"] = 1;
$def_data["form_tax_div"] = 2;
$def_data["form_tax_franct"] = 1;
$def_data["form_c_tax_div"] = 1;

$form->setDefaults($def_data);
/****************************/
//����Ƚ��
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
//��������GET���������
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT ";
    $select_sql .= "    client_cd1,";       //������CD
    $select_sql .= "    state,";            //����
    $select_sql .= "    client_name,";      //������̾
    $select_sql .= "    client_cname,";     //ά��
    $select_sql .= "    post_no1,";         //͹���ֹ棱
    $select_sql .= "    post_no2,";         //͹���ֹ棲
    $select_sql .= "    address1,";         //���꣱
    $select_sql .= "    address2,";         //���ꣲ
    $select_sql .= "    area_id,";          //�϶�
    $select_sql .= "    tel,";              //�����ֹ�
    $select_sql .= "    fax,";              //FAX�ֹ�
    $select_sql .= "    rep_name,";         //��ɽ��̾
    $select_sql .= "    c_staff_id1,";      //������ô��
    $select_sql .= "    charger1,";         //ô����
    $select_sql .= "    c_part_name,";      //��ô��������
    $select_sql .= "    sbtype_id,";        //�ȼ�
    $select_sql .= "    col_terms,";        //��ʧ���
    $select_sql .= "    establish_day,";    //�϶���
    $select_sql .= "    capital,";          //���ܶ�
    $select_sql .= "    close_day,";        //����
//    $select_sql .= "    pay_m,";            //��ʧ��(��)
//    $select_sql .= "    pay_d,";            //��ʧ��(��)
    $select_sql .= "    payout_m,";            //��ʧ��(��)
    $select_sql .= "    payout_d,";            //��ʧ��(��)
    $select_sql .= "    '',";               //�����ֹ�
    $select_sql .= "    '',";               //����̾��
    $select_sql .= "    bank_name,";        //�������
    $select_sql .= "    cont_sday,";        //���󳫻���
    $select_sql .= "    coax,";             //���(�ݤ��ʬ)
    $select_sql .= "    tax_div,";          //������(����ñ��)
    $select_sql .= "    tax_franct,";       //������(ü��)
    $select_sql .= "    note,";             //����
    $select_sql .= "    client_read,";      //������̾(�եꥬ��)
    $select_sql .= "    address_read,";     //����(�եꥬ��)
    $select_sql .= "    email,";            //Email
    $select_sql .= "    url,";              //URL
    $select_sql .= "    represe,";          //��ɽ����
    $select_sql .= "    rep_htel,";         //��ɽ�Է���
    $select_sql .= "    direct_tel,";       //ľ��TEL
    $select_sql .= "    b_struct,";         //����ID
    $select_sql .= "    inst_id,";          //����ID
    $select_sql .= "    trade_id,";         //�����ʬ������
    $select_sql .= "    holiday,";          //����
    $select_sql .= "    deal_history,";     //�������
    $select_sql .= "    importance,";       //���׻���
    $select_sql .= "    client_cread,";     //ά��(�եꥬ��)
    $select_sql .= "    address3,";
    $select_sql .= "    b_bank_name,";      
//    $select_sql .= "    attach_gid";      //FC���롼��
    $select_sql .= "    client_name2,";     //������̾2
    $select_sql .= "    client_read2, ";    //������̾2(�եꥬ��)
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
    //������ȯ��
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    //�ǡ�������
    $client_data = pg_fetch_array ($result, 0);
    //����ͥǡ���
    $defa_data["form_client_cd"]              = $client_data[0];         //�����襳����
    $defa_data["form_state"]                  = $client_data[1];         //����
    $defa_data["form_client_name"]            = $client_data[2];         //������̾
    $defa_data["form_client_cname"]           = $client_data[3];         //ά��
    $defa_data["form_post"]["no1"]            = $client_data[4];         //͹���ֹ棱
    $defa_data["form_post"]["no2"]            = $client_data[5];         //͹���ֹ棲
    $defa_data["form_address1"]               = $client_data[6];         //���꣱
    $defa_data["form_address2"]               = $client_data[7];         //���ꣲ
    $defa_data["form_area_id"]                = $client_data[8];         //�϶�
    $defa_data["form_tel"]                    = $client_data[9];         //TEL
    $defa_data["form_fax"]                    = $client_data[10];        //FAX
    $defa_data["form_rep_name"]               = $client_data[11];        //��ɽ�Ի�̾
    $defa_data["form_staff_id"]               = $client_data[12];        //����ô��
    $defa_data["form_charger"]                = $client_data[13];        //��ô����
    $defa_data["form_part"]                   = $client_data[14];        //ô��������
    $defa_data["form_btype"]                  = $client_data[15];        //�ȼ�
    $defa_data["form_pay_terms"]              = $client_data[16];        //��ʧ���
    $form_start[y] = substr($client_data[17],0,4);
    $form_start[m] = substr($client_data[17],5,2);
    $form_start[d] = substr($client_data[17],8,2);
    $defa_data["form_start"]["y"]             = $form_start[y];          //�϶���(ǯ)
    $defa_data["form_start"]["m"]             = $form_start[m];          //�϶���(��)
    $defa_data["form_start"]["d"]             = $form_start[d];          //�϶���(��)
    $defa_data["form_capital"]                = $client_data[18];        //���ܶ�
    $defa_data["form_close"]                  = $client_data[19];        //����
    $defa_data["form_pay_m"]                  = $client_data[20];        //��ʧ��(��) 
    $defa_data["form_pay_d"]                  = $client_data[21];        //��ʧ��(��)
    $defa_data["form_intro_ac_num"]           = $client_data[22];        //�����ֹ�
    $defa_data["form_account_name"]           = $client_data[23];        //����̾��
    $defa_data["form_bank"]                   = $client_data[24];        //�������
    $trans_s_day[y] = substr($client_data[25],0,4);
    $trans_s_day[m] = substr($client_data[25],5,2);
    $trans_s_day[d] = substr($client_data[25],8,2);
    $defa_data["form_trans_s_day"]["y"]       = $trans_s_day[y];         //���������(ǯ)
    $defa_data["form_trans_s_day"]["m"]       = $trans_s_day[m];         //���������(��)
    $defa_data["form_trans_s_day"]["d"]       = $trans_s_day[d];         //���������(��)
    $defa_data["form_coax"]                   = $client_data[26];        //���
    $defa_data["form_tax_div"]                = $client_data[27];        //������(����ñ��)
    $defa_data["form_tax_franct"]             = $client_data[28];        //������(ü����ʬ)
    $defa_data["form_note"]                   = $client_data[29];        //����
    $defa_data["form_client_read"]            = $client_data[30];        //������̾(�եꥬ��)
    $defa_data["form_address_read"]           = $client_data[31];        //����(�եꥬ��)
    $defa_data["form_email"]                  = $client_data[32];        //Email
    $defa_data["form_url"]                    = $client_data[33];        //URL
    $defa_data["form_represent_position"]     = $client_data[34];        //��ɽ����
    $defa_data["form_represent_cell"]         = $client_data[35];        //��ɽ�Է���
    $defa_data["form_direct_tel"]             = $client_data[36];        //ľ��TEL
    $defa_data["form_bstruct"]                = $client_data[37];        //����ID
    $defa_data["form_inst"]                   = $client_data[38];        //����ID
    $defa_data["trade_ord"]                  = $client_data[39];        //�����ʬ������
    $defa_data["form_holiday"]                = $client_data[40];        //����
    $defa_data["form_record"]                 = $client_data[41];        //�������
    $defa_data["form_important"]              = $client_data[42];        //���׻���
    $defa_data["form_cname_read"]             = $client_data[43];        //ά��(�եꥬ��)
    $defa_data["form_address3"]               = $client_data[44];        //
    $defa_data["form_b_bank_name"]            = $client_data[45];        //
    $defa_data["form_client_name2"]           = $client_data[46];        //������̾2
    $defa_data["form_client_read2"]           = $client_data[47];        //������̾2(�եꥬ��)
//    $defa_data["form_shop_gr_1"]              = $client_data[44];        //FC���롼��
    //���������
    $defa_data["form_c_tax_div"]              = $client_data["c_tax_div"];

    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "supplier", $client_data[0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];
}

/***************************/
//�ե��������
/***************************/

//�϶�
$select_ary = Select_Get($conn,'area');
$form->addElement('select', 'form_area_id',"", $select_ary,$g_form_option_select);

//�ȼ�
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
                $data_list[1] = $data_list[1]."��";
        }
    }
    $select_value2[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
//  $select_value[$data_list[2]] = $data_list[0].$data_list[3]." ��".$data_list[1]."��".$data_list[4];
}

$form->addElement('select', 'form_btype',"", $select_value2,$g_form_option_select);

//����
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
    $select_value3[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_inst',"", $select_value3,$g_form_option_select);

//����
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
    $select_value4[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_bstruct',"", $select_value4,$g_form_option_select);

//FC���롼��
/*
$select_value1 = Select_Get($conn,'shop_gr');
$form->addElement('select', 'form_shop_gr_1', '���쥯�ȥܥå���', $select_value1,$g_form_option_select);
*/

//�����襳����
$form->addElement(
        "text","form_client_cd","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"".$g_form_option."\""
        );

//����
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$text[] =& $form->createElement( "radio",NULL,NULL, "�ٻ���","2");
$text[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$form->addGroup($text, "form_state", "");

//������̾
$form->addElement(
        "text","form_client_name","",'size="44" maxLength="25"'." $g_form_option"
        );

//������̾(�եꥬ��)
$form->addElement(
        "text","form_client_read","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//������̾2
$form->addElement(
        "text","form_client_name2","",'size="44" maxLength="25"'." $g_form_option"
        );

//������̾2(�եꥬ��)
$form->addElement(
        "text","form_client_read2","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//ά��
$form->addElement(
        "text","form_client_cname","",'size="44" maxLength="20"'." $g_form_option"
        );

//ά�Ρʥեꥬ�ʡ�
$form->addElement(
        "text","form_cname_read","",'size="46" maxLength="40"'." $g_form_option"
        );

//͹���ֹ�
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

//���꣱
$form->addElement(
        "text","form_address1","",'size="44" maxLength="25"'." $g_form_option"
        );

//���ꣲ
$form->addElement(
        "text","form_address2","",'size="46" maxLength="25"'." $g_form_option"
        );

//���ꣳ
$form->addElement(
        "text","form_address3","","size=\"44\" maxLength=\"30\"$g_form_option"
        );

//����(�եꥬ��)
$form->addElement(
        "text","form_address_read","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//͹���ֹ�
//��ư���ϥܥ��󤬲������줿���
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //͹���ֹ棱
    $post2     = $_POST["form_post"]["no2"];             //͹���ֹ棲
    $post_value = Post_Get($post1,$post2,$conn);
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"] = "";
    //͹���ֹ椫�鼫ư����
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);
}

//�϶���
$start[] =& $form->createElement("text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_start[y]','form_start[m]',4)\" 
        ".$g_form_option."\"");
$start[] =& $form->createElement("static","","","-");
$start[] =& $form->createElement("text","m","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_start[m]','form_start[d]',2)\"  onchange=\"Contract(this.form)\"
        ".$g_form_option."\"");
$start[] =& $form->createElement("static","","","-");
$start[] =& $form->createElement("text","d","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\""." $g_form_option");
$form->addGroup( $start,"form_start","form_start");

//���ܶ�
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
        "text","form_url","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//��������ɽ��
$form->addElement(
        "text","form_rep_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//��ɽ����
$form->addElement(
        "text","form_represent_position","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//ľ��TEL
$form->addElement(
        "text","form_direct_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option"
        );

//��ɽ�Է���
$form->addElement(
        "text","form_represent_cell","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//������ô����
$form->addElement(
        "text","form_charger","",'size="34" maxLength="15"'." $g_form_option"
        );

//����������
$form->addElement(
        "text","form_part","",'size="22" maxLength="10"'." $g_form_option"
        );

//����
$form->addElement(
        "text","form_holiday","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//�����ʬ
$select_value6 = Select_Get($conn,'trade_ord');
$form->addElement('select', 'trade_ord', '���쥯�ȥܥå���', $select_value6,
    "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();pay_way()\"");

//����
$select_value7 = Select_Get($conn,'close');
$form->addElement('select', 'form_close', '���쥯�ȥܥå���', $select_value7,$g_form_option_select);

//��ʧ��
//��
$select_month[null] = null; 
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[$i] = "����";
    }elseif($i == 1){
        $select_month[$i] = "���";
    }else{
        $select_month[$i] = $i."�����";
    }
}
$form->addElement("select", "form_pay_m", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

//��
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '����';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."��";
    }
}
$form->addElement("select", "form_pay_d", "���쥯�ȥܥå���", $select_day, $g_form_option_select);
/*
//��
$form->addElement(
        "text","form_pay_m","","size=\"2\" maxLength=\"2\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
        );
//��
$form->addElement(
        "text","form_pay_d","","size=\"2\" maxLength=\"2\" style=\"text-align: right;$g_form_style\"
        "." $g_form_option"
        );
*/
//���
//$ary_bank = Select_Get($conn,'bank');
//$form->addElement('select', 'form_bank', '',$ary_bank,$g_form_option_select);
$form->addElement('text', 'form_bank', '', "size=\"95\" maxLength=\"40\" $g_form_option");

//��Ź̾
$form->addElement("text", "form_b_bank_name", "","size=\"47\" maxlength=\"20\" $g_form_option");

//�����ֹ�
$form->addElement(
        "text","form_intro_ac_num","","size=\"34\" maxLength=\"15\" $g_form_option"
        );

//����̾��
$form->addElement(
        "text","form_account_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//���������
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

//����ô��
$select_ary = Select_Get($conn,'staff');
$form->addElement('select', 'form_staff_id',"", $select_ary, $g_form_option_select );

//���
//�ݤ��ʬ
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_coax, "form_coax", "");

//������
//����ñ��
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "��ɼñ��","2");
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����ñ��","1");
$form->addGroup($form_tax_div, "form_tax_div", "");
//ü����ʬ
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_tax_franct, "form_tax_franct", "");

//����ñ��
$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$form->addGroup($form_c_tax_div, "form_c_tax_div", "");

//��ʧ���
$form->addElement(
        "text","form_pay_terms","",'size="34" maxLength="50"'." $g_form_option"
        );

//����
$form->addElement(
        "textarea","form_note","",' rows="3" cols="75"'." $g_form_option_area"
        );

//�������
$form->addElement(
        "textarea","form_record","",' rows="3" cols="75"'." $g_form_option_area"
        );

//���׻���
$form->addElement(
        "textarea","form_important","",' rows="3" cols="75"'." $g_form_option_area"
        );

//hidden
$form->addElement("hidden", "input_button_flg");
$form->addElement("hidden", "ok_button_flg");

/****************************/
//�롼�����
/****************************/
$form->registerRule("telfax","function","Chk_Telfax");
//��FC���롼��
//��ɬ�ܥ����å�
//$form->addRule("form_shop_gr_1", "FC���롼�פ����򤷤Ƥ���������","required");

//�������襳����
//��ɬ�ܥ����å�
$form->addRule("form_client_cd", "������CD��Ⱦ�ѿ����ΤߤǤ���","required");

//��Ⱦ�ѿ��������å�
$form->addRule("form_client_cd", "������CD��Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//��������̾
//��ɬ�ܥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_client_name", "������̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");
$form->addRule("form_client_name", "������̾�˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���","no_sp_name");

//��ά��
//��ɬ�ܥ����å�
$form->addRule("form_client_cname", "ά�Τ�1ʸ���ʾ�20ʸ���ʲ��Ǥ���","required");
$form->addRule("form_client_cname", "ά�Τ˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���","no_sp_name");

//��͹���ֹ�
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
//��ʸ���������å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���','required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���',"regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(4,4))
        ),
));

//�����꣱
//��ɬ�ܥ����å�
$form->addRule("form_address1", "���꣱��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");

//���϶�
//��ɬ�ܥ����å�
$form->addRule("form_area_id", "�϶�����򤷤Ʋ�������","required");

//�������ʬ������
//��ɬ�ܥ����å�
$form->addRule("trade_ord", "�����ʬ�����ɤ����򤷤Ʋ�������","required");

//��TEL
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule(form_tel, "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "required");
$form->addRule("form_tel","TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "telfax");

//���ȼ�
//��ɬ�ܥ����å�
$form->addRule("form_btype", "�ȼ�����򤷤Ʋ�������","required");

//�����ܶ�
//��Ⱦ�ѿ��������å�
//$form->addRule("form_capital", "���ܶ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");
$form->addRule("form_capital", "���ܶ��Ⱦ�ѿ����ΤߤǤ���", "regex", '/^[0-9]+$/');

//����ʧ���ʷ��
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_m", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_m", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//����ʧ��������
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_d", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_d", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//���϶���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_start', array(
        'y' => array(
                array('�϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));


//�����������
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trans_s_day', array(
        'y' => array(
                array('��������������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('��������������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('��������������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

/***************************/
//�롼�������PHP��
/***************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){
    /****************************/
    //POST����
    /****************************/
//    $shop_gr        = $_POST["form_shop_gr_1"];                 //FC���롼��
    $client_cd      = $_POST["form_client_cd"];                 //�����襳����
    $state          = $_POST["form_state"];                     //����
    $client_name    = $_POST["form_client_name"];               //������̾
    $client_name2   = $_POST["form_client_name2"];              //������̾2
    $client_cname   = $_POST["form_client_cname"];              //ά��
    $post_no1       = $_POST["form_post"]["no1"];               //͹���ֹ棱
    $post_no2       = $_POST["form_post"]["no2"];               //͹���ֹ棲
    $address1       = $_POST["form_address1"];                  //���꣱
    $address2       = $_POST["form_address2"];                  //���ꣲ
    $address3       = $_POST["form_address3"];                  //���ꣳ
    $area_id        = $_POST["form_area_id"];                   //�϶襳����
    $btype          = $_POST["form_btype"];                     //�ȼ拾����
    $start_day      = $_POST["form_start"]["y"];                //�϶���(ǯ)
    //�����
    $_POST["form_start"]["m"] = str_pad($_POST["form_start"]["m"], 2, 0, STR_POS_LEFT);
    $start_day     .= $_POST["form_start"]["m"];                //�϶���(��)
    $_POST["form_start"]["d"] = str_pad($_POST["form_start"]["d"], 2, 0, STR_POS_LEFT);
    $start_day     .= $_POST["form_start"]["d"];                //�϶���(��)
    $capital        = $_POST["form_capital"];                   //���ܶ�
    $tel            = $_POST["form_tel"];                       //TEL
    $fax            = $_POST["form_fax"];                       //FAX
    $rep_name       = $_POST["form_rep_name"];                  //��������ɽ��
    $charger        = $_POST["form_charger"];                   //������ô����
    $part           = $_POST["form_part"];                      //����������
    $close_day_cd   = $_POST["form_close"];                     //����
    $pay_m          = $_POST["form_pay_m"];                     //��ʧ���ʷ��
    $pay_d          = $_POST["form_pay_d"];                     //��ʧ��������
    $bank_enter_cd  = $_POST["form_bank"];                      //�������
    $b_bank_name    = $_POST["form_b_bank_name"];               //��Ź̾
    $intro_ac_num   = $_POST["form_intro_ac_num"];              //�����ֹ�
    $account_name   = $_POST["form_account_name"];              //����̾��
    $trans_s_day    = $_POST["form_trans_s_day"]["y"];          //���������
    //�����
    $_POST["form_trans_s_day"]["m"] = str_pad($_POST["form_trans_s_day"]["m"], 2, 0, STR_POS_LEFT);
    $trans_s_day   .= $_POST["form_trans_s_day"]["m"];
    $_POST["form_trans_s_day"]["d"] = str_pad($_POST["form_trans_s_day"]["d"], 2, 0, STR_POS_LEFT);
    $trans_s_day   .= $_POST["form_trans_s_day"]["d"];
    $c_staff_id     = $_POST["form_staff_id"];                  //����ô����
    $coax           = $_POST["form_coax"];                      //��ۡ��ݤ��ʬ
    $tax_div        = $_POST["form_tax_div"];                   //�����ǡ�����ñ��
    $tax_franct     = $_POST["form_tax_franct"];                //�����ǡ�ü����ʬ
    $pay_terms      = $_POST["form_pay_terms"];                 //��ʧ���
    $note           = $_POST["form_note"];                      //����������������¾
    $client_read    = $_POST["form_client_read"];               //������̾(�եꥬ��)
    $client_read2   = $_POST["form_client_read2"];              //������̾2(�եꥬ��)
    $client_cread   = $_POST["form_cname_read"];                //ά��(�եꥬ��)
    $address_read   = $_POST["form_address_read"];              //����(�եꥬ��)
    $email          = $_POST["form_email"];                     //Email
    $url            = $_POST["form_url"];                       //URL
    $rep_position   = $_POST["form_represent_position"];        //��ɽ����
    $rep_cell       = $_POST["form_represent_cell"];            //��ɽ�Է���
    $direct_tel     = $_POST["form_direct_tel"];                //ľ��TEL
    $bstruct        = $_POST["form_bstruct"];                   //����ID
    $inst           = $_POST["form_inst"];                      //����ID
    $trade_ord     = $_POST["trade_ord"];                     //�����ʬ������
    $holiday        = $_POST["form_holiday"];                   //����
    $record         = $_POST["form_record"];                    //�������
    $importance     = $_POST["form_important"];                 //���׻���
    $c_tax_div      = $_POST["form_c_tax_div"];                 //���Ƕ�ʬ

    /***************************/
    //�����
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
            $client_cd_err = "���Ϥ��줿�����襳���ɤϻ�����Ǥ���";
            $err_flg = true;
        }
    }
    
    //��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
        $tel_err = "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //��FAX
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_fax","FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$fax) && $fax != null){
        $fax_err = "FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //Email
    if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Email�������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //��URL
    //�����ϥ����å�
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "������URL�����Ϥ��Ʋ�������";
        $err_flg = true;
    }

//����ɽ�Ի�̾
//��ɬ�ܥ����å�
$form->addRule("form_rep_name", "��ɽ�Ի�̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

    //��ľ��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_direct_tel","ľ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$direct_tel) && $direct_tel != ""){
        $d_tel_err = "ľ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //����ɽ�Է���
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_represent_cell","��ɽ�Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$rep_cell) && $rep_cell != ""){
        $rep_cell_err = "��ɽ�Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //���϶���
    //�����դ������������å�
    $start_y = (int)$_POST["form_start"]["y"];
    $start_m = (int)$_POST["form_start"]["m"];
    $start_d = (int)$_POST["form_start"]["d"];

    if($start_m != null || $start_d != null || $start_y != null){
        $start_flg = true;
    }
    $check_start_day = checkdate($start_m,$start_d,$start_y);
    if($check_start_day == false && $start_flg == true){
        $start_err = "�϶��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    
    //������
    //��ɬ�ܥ����å�
    if($_POST["form_close"] == 0){
        $close_err = "���������򤷤Ʋ�������";
        $err_flg = true;
    }

    //��ʧ��������ǡ�����������դ����������
    if($_POST["form_pay_m"] == 0 && ($_POST["form_close"] >= $_POST["form_pay_d"])){
        $close_err = "��ʧ���ʷ�ˤ���������򤷤�����������꾮������ʧ�������ˤ����򤷤Ʋ�������";
        $err_flg = true;
    }

    //�����������
    //�����դ������������å�
    $sday_y = (int)$_POST["form_trans_s_day"]["y"];
    $sday_m = (int)$_POST["form_trans_s_day"]["m"];
    $sday_d = (int)$_POST["form_trans_s_day"]["d"];

    if($sday_m != null || $sday_d != null || $sday_y != null){
        $sday_flg = true;
    }
    $check_s_day = checkdate($sday_m,$sday_d,$sday_y);
    if($check_s_day == false && $sday_flg == true){
        $sday_err = "��������������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
}
/****************************/
//����
/****************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){

    /******************************/
    //��Ͽ����
    /******************************/
    if($new_flg == true){
        Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                        //������ID
        $insert_sql .= "    client_cd1,";                       //�����襳����
        $insert_sql .= "    client_cd2,";                       //�����襳����
        $insert_sql .= "    shop_id,";                          //FC���롼��ID
        $insert_sql .= "    create_day,";                       //������
        $insert_sql .= "    state,";                            //����
        $insert_sql .= "    client_name,";                      //������̾
        $insert_sql .= "    client_cname,";                     //ά��
        $insert_sql .= "    post_no1,";                         //͹���ֹ棱
        $insert_sql .= "    post_no2,";                         //͹���ֹ棲
        $insert_sql .= "    address1,";                         //���꣱
        $insert_sql .= "    address2,";                         //���ꣲ
        $insert_sql .= "    address3,";                         //����3
        $insert_sql .= "    area_id,";                          //�϶�ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //��ɽ�Ի�̾
        $insert_sql .= "    c_staff_id1,";                      //����ô��
        $insert_sql .= "    charger1,";                         //��ô����
        $insert_sql .= "    c_part_name,";                      //��ô��������
        $insert_sql .= "    sbtype_id,";                         //�ȼ�ID
        $insert_sql .= "    establish_day,";                    //�϶���
        $insert_sql .= "    close_day,";                        //����
//        $insert_sql .= "    pay_m,";                            //��ʧ���ʷ��
//        $insert_sql .= "    pay_d,";                            //��ʧ��������
        $insert_sql .= "    payout_m,";                            //��ʧ���ʷ��
        $insert_sql .= "    payout_d,";                            //��ʧ��������
        $insert_sql .= "    account_name,";                     //����̾��
        $insert_sql .= "    intro_ac_num,";                         //�����ֹ�
        $insert_sql .= "    bank_name,";                          //���ID
        $insert_sql .= "    b_bank_name,";                 //��Ź̾
        $insert_sql .= "    coax,";                             //��ۡ��ݤ��ʬ
        $insert_sql .= "    tax_div,";                          //�����ǡ�����ñ��
        $insert_sql .= "    tax_franct,";                       //�����ǡ�ü����ʬ
        $insert_sql .= "    cont_sday,";                        //���������
        $insert_sql .= "    col_terms,";                        //��ʧ���
        $insert_sql .= "    capital,";                          //���ܶ�
        $insert_sql .= "    note,";                             //����
        $insert_sql .= "    client_div,";                       //�������ʬ
        $insert_sql .= "    client_read,";                      //������̾(�եꥬ��)
        $insert_sql .= "    client_cread,";                     //ά��(�եꥬ��)
        $insert_sql .= "    address_read,";                     //����(�եꥬ��)
        $insert_sql .= "    email,";                            //Email
        $insert_sql .= "    url,";                              //URL
        $insert_sql .= "    represe,";                          //��ɽ����
        $insert_sql .= "    rep_htel,";                         //��ɽ�Է���
        $insert_sql .= "    direct_tel,";                       //ľ��TEL
        $insert_sql .= "    b_struct,";                         //����ID
        $insert_sql .= "    inst_id,";                          //����ID
        $insert_sql .= "    trade_id,";                         //�����ʬ������
        $insert_sql .= "    holiday,";                          //����
        $insert_sql .= "    deal_history,";                     //�������
        $insert_sql .= "    importance,";                       //���׻���
//        $insert_sql .= "    attach_gid,";                       //FC���롼��
        $insert_sql .= "    shop_name,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    royalty_rate,";
        $insert_sql .= "    tax_rate_n,";
        $insert_sql .= "    client_name2,";                     //������̾2
        $insert_sql .= "    client_read2, ";                     //������̾2(�եꥬ��)
        $insert_sql .= "    c_tax_div";
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd',";                    //�����襳����
        $insert_sql .= "    '0000',";                          //��Ź������
        $insert_sql .= "    $shop_id,";                        //FC���롼��ID
        if($create_day == ""){
                $create_day = "    null"; 
        }
        $insert_sql .= "    NOW(),";                            //������
        if($state == null){
            $state = 2;
        }
        $insert_sql .= "    '$state',";                         //����
        $insert_sql .= "    '$client_name',";                   //������̾
        $insert_sql .= "    '$client_cname',";                  //ά��
        $insert_sql .= "    '$post_no1',";                      //͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                      //͹���ֹ棲
        $insert_sql .= "    '$address1',";                      //���꣱
        $insert_sql .= "    '$address2',";                      //���ꣲ
        $insert_sql .= "    '$address3',";                      //����3
        $insert_sql .= "    $area_id,";                         //�϶�ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$rep_name',";                      //��ɽ�Ի�̾
        if($c_staff_id == ""){
                $c_staff_id = "    null"; 
        }
        $insert_sql .= "    $c_staff_id,";                      //����ô��
        $insert_sql .= "    '$charger',";                       //��ô����
        $insert_sql .= "    '$part',";                          //��ô��������
        $insert_sql .= "    $btype,";                           //�ȼ�ID
        if($start_day == "0000"){                               //�϶���
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$start_day',";
        }
        $insert_sql .= "    '$close_day_cd',";                  //����
        if($pay_m == ""){
                $pay_m = "    null"; 
        }
        $insert_sql .= "    '$pay_m',";                         //��ʧ���ʷ��
        if($pay_d == ""){
                $pay_d = "    null"; 
        }
        $insert_sql .= "    '$pay_d',";                         //��ʧ��������
        $insert_sql .= "    '$account_name',";                  //����̾��
        $insert_sql .= "    '$intro_ac_num',";                      //�����ֹ�
        $insert_sql .= "    '$bank_enter_cd',";                   //���
        $insert_sql .= "    '$b_bank_name',";                     //��Ź̾
        $insert_sql .= "    '$coax',";                          //��ۡ��ݤ��ʬ
        $insert_sql .= "    '$tax_div',";                       //�����ǡ�����ñ��
        $insert_sql .= "    '$tax_franct',";                    //�����ǡ�ü��ñ��
        if($trans_s_day == "0000"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trans_s_day',";               //���������
        }
        $insert_sql .= "    '$pay_terms',";                     //��ʧ���
        $insert_sql .= "    '$capital',";                       //���ܶ�
        $insert_sql .= "    '$note',";                          //����
        $insert_sql .= "    '2',";                              //�������ʬ
        $insert_sql .= "    '$client_read',";                   //������̾(�եꥬ��)
        $insert_sql .= "    '$client_cread',";                  //ά��(�եꥬ��)
        $insert_sql .= "    '$address_read',";                  //����(�եꥬ��)
        $insert_sql .= "    '$email',";                         //Email
        $insert_sql .= "    '$url',";                           //URL
        $insert_sql .= "    '$rep_position',";                  //��ɽ����
        $insert_sql .= "    '$rep_cell',";                      //��ɽ�Է���
        $insert_sql .= "    '$direct_tel',";                    //ľ��TEL
        if($bstruct == ""){                                     //����ID
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    $bstruct,";
        }
        if($inst == ""){                                        //����ID
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    $inst,";
        }
        $insert_sql .= "    $trade_ord,";                      //�����ʬ������
        $insert_sql .= "    '$holiday',";                       //����
        $insert_sql .= "    '$record',";                        //�������
        $insert_sql .= "    '$importance',";                    //���׻���
//        $insert_sql .= "    $shop_gr,";                         //FC���롼��
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    (SELECT";                           //������Ψ(����)
        $insert_sql .= "        tax_rate_n";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    shop_id = $shop_id";
        $insert_sql .= "    AND";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ), ";
        $insert_sql .= "    '$client_name2',";                   //������̾2
        $insert_sql .= "    '$client_read2',";                   //������̾2(�եꥬ��)
        $insert_sql .= "    $c_tax_div";
        $insert_sql .= ");";
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //��Ͽ�����������˻Ĥ�
        $result = Log_Save( $conn, "supplier", "1", $client_cd, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

    /******************************/
    //��������
    /******************************/
    }else if($new_flg == false){
        //������ޥ���
        Db_Query($conn, "BEGIN;");
        $update_sql = "UPDATE";
        $update_sql .= "    t_client";
        $update_sql .= " SET";
        $update_sql .= "    client_cd1 = '$client_cd',";        //�����襳����
        $update_sql .= "    state= '$state',";                  //����
        $update_sql .= "    client_name = '$client_name',";     //������̾
        $update_sql .= "    client_name2 = '$client_name2',";   //������̾2
        $update_sql .= "    client_cname = '$client_cname',";   //ά��
        $update_sql .= "    post_no1 = '$post_no1',";           //͹���ֹ棱
        $update_sql .= "    post_no2 = '$post_no2',";           //͹���ֹ棲
        $update_sql .= "    address1 = '$address1',";           //���꣱
        $update_sql .= "    address2 = '$address2',";           //���ꣲ
        $update_sql .= "    address3 = '$address3',";           //����3
        $update_sql .= "    area_id = $area_id,";               //�϶�ID
        $update_sql .= "    tel = '$tel',";                     //tel
        $update_sql .= "    fax = '$fax',";                     //fax
        $update_sql .= "    rep_name = '$rep_name',";           //��ɽ�Ի�̾
        if($c_staff_id == ""){                                  //����ô��
            $update_sql .= "    c_staff_id1 = null,";
        }else{
            $update_sql .= "    c_staff_id1 = $c_staff_id,";
        }
        $update_sql .= "    charger1 = '$charger',";           //��ô����
        $update_sql .= "    c_part_name = '$part',";            //��ô��������
        $update_sql .= "    sbtype_id = $btype,";                //�ȼ�ID
        $update_sql .= "    col_terms = '$pay_terms',";         //��ʧ���
        if($start_day == "0000"){                                   //�϶���
            $update_sql .= "    establish_day = null,";
        }else{
            $update_sql .= "    establish_day = '$start_day',";
        }
        $update_sql .= "    capital = '$capital',";             //���ܶ�
        $update_sql .= "    close_day = '$close_day_cd',";      //����
        if($pay_m == ""){                                       //��ʧ���ʷ��
//            $update_sql .= "    pay_m = '',";
            $update_sql .= "    payout_m = '',";
        }else{
//            $update_sql .= "    pay_m = '$pay_m',";
            $update_sql .= "    payout_m = '$pay_m',";
        }
        if($pay_d == ""){                                       //��ʧ��������
//            $update_sql .= "    pay_d = '',";
            $update_sql .= "    payout_d = '',";
        }else{
//            $update_sql .= "    pay_d = '$pay_d',";
            $update_sql .= "    payout_d = '$pay_d',";
        }
        $update_sql .= "    intro_ac_num = '$intro_ac_num',";   //�����ֹ�
        $update_sql .= "    account_name = '$account_name',";   //����̾��
        $update_sql .= "    bank_name = '$bank_enter_cd',";
        $update_sql .= "    b_bank_name = '$b_bank_name',";     //���̾
        if($trans_s_day == "0000"){                             //���������
            $update_sql .= "    cont_sday = null,";
        }else{
            $update_sql .= "    cont_sday = '$trans_s_day',";
        }
        $update_sql .= "    coax = '$coax',";                   //��ۡ��ݤ��ʬ
        $update_sql .= "    tax_div = '$tax_div',";             //�����ǡ�����ñ��
        $update_sql .= "    tax_franct = '$tax_franct',";       //�����ǡ�ü����ʬ
        $update_sql .= "    note = '$note',";                   //����
        $update_sql .= "    client_read = '$client_read',";     //������̾(�եꥬ��)
        $update_sql .= "    client_read2 = '$client_read2',";   //������̾2(�եꥬ��)
        $update_sql .= "    client_cread = '$client_cread',";   //ά��(�եꥬ��)
        $update_sql .= "    address_read = '$address_read',";   //����(�եꥬ��)
        $update_sql .= "    email = '$email',";                 //Email
        $update_sql .= "    url = '$url',";                     //URL
        $update_sql .= "    represe = '$rep_position',";        //��ɽ����
        $update_sql .= "    rep_htel = '$rep_cell',";           //��ɽ�Է���
        $update_sql .= "    direct_tel = '$direct_tel',";       //ľ��TEL
        if($bstruct == ""){                                     //����ID
            $update_sql .= "    b_struct = null,";
        }else{
            $update_sql .= "    b_struct = $bstruct,";
        }
        if($inst == ""){                                        //����ID
            $update_sql .= "    inst_id = null,";
        }else{
            $update_sql .= "    inst_id = $inst,";
        }
        if($trade_ord == ""){                                  //�����ʬ������
            $update_sql .= "    trade_id = null,";
        }else{
            $update_sql .= "    trade_id = $trade_ord,";
        }
        $update_sql .= "    holiday = '$holiday',";             //����
        $update_sql .= "    deal_history = '$record',";         //�������
        $update_sql .= "    importance = '$importance',";       //���׻���
/*        if($shop_gr == ""){                                     //FC���롼��
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
        //�ѹ������������˻Ĥ�
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

//�ܥ���
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('1-1-215.php')\"");

//��Ͽ(�إå�)
//$form->addElement("button","new_button","��Ͽ����","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","��Ͽ����",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//DB����Ͽ��Υե���������
if($complete_flg == true){
    $button[] = $form->createElement(
            "button","back_button","�ᡡ��",
            "onClick='javascript:history.back()'
            ");
    //�ϣ�
    $button[] = $form->addElement(
            "button","ok_button","�ϡ���","onClick=\"javascript:Button_Submit_1('ok_button_flg', '#', 'true', this)\""
            );
}else{

    //DB����Ͽ���Υե���������
    $button[] = $form->createElement(
            "button","input_button","��ư����","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""
            ); 

    $button[] = $form->createElement(
            "submit","entry_button","�С�Ͽ",
            "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled"
            );
    $button[] = $form->createElement(
            "button","back_button","�ᡡ��",
            "onClick='javascript:location.href = \"./1-1-215.php\"'
            ");
/*
    $button[] = $form->createElement(
            "button","res_button","�¡���",
            "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-217.php?client_id=$_GET[client_id]','_blank','width=480,height=600')\""
            );
*/
    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-216.php?client_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }
    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-216.php?client_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
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

//��ʧ��
$contract .= "function pay_way(){\n";
$contract .= "  if(document.dateForm.trade_ord.value=='71'){\n";
$contract .= "      document.dateForm.form_close.value='29';\n";
$contract .= "  }\n";
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
//���������
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

//�إå�����ɽ�������������
$total_count_sql = $count_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
