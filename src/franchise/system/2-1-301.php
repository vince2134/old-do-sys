<?php
/******************************
 *�ѹ�����
 *  �Ұ�����Ͽ����������ɲá�20060831��kaji
 *  ��������ɽ�������ѹ��������ɲá�20061103��suzuki
 *  ľ��Ʊ�Τϥ�������ɽ�����֤�ͭ����褦���ѹ���20061127��suzuki
 *
******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-09      ban_0106    suzuki      ���դ򥼥����
 *  2007/04/05      B0702-034   kajioka-h   ��̾1��ɬ�ܥ����å�������Ƥ����Τ���
 *  2007/09/27                  watanabe-k  ���������ˤ�̤������դΤ����ϲ�ǽ�Ȥ�������å����ɲ�
 *  2009/12/25                  aoyama-n    �������Ψ�ȸ�������Ψ��ɽ��������������Ψ����Ͽ�Ǥ���褦���ѹ�
 *  2010/01/10                  aoyama-n    ������Ψ����ΰ٤μ����إå��ξ����ǳ۹��������ɲ�
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 * 
*/

$page_title = "���ҥץ��ե�����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//SESSION����
/****************************/
$client_id  = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/****************************/
//�����(radio)
/****************************/
$def_fdata = array(
    "form_claim_num"    => "1",
    "form_coax" => "1",
    "from_fraction_div" => "1",
    "form_cal_peri"     => "1",
);
$form->setDefaults($def_fdata);

//�Ұ��Υѥ�
$path_shain = FC_DIR."system/2-1-301-3.php?shop_id=".$client_id;

//hidden�ξ����ͤ����ä���������
if($_POST["before_state"] != NULL){
	$before_state = $_POST["before_state"];
}

/****************************/
//���ɽ������
/****************************/
$select_sql  = "SELECT \n";
$select_sql .= "    t_client.client_cd1,\n";                  //����åץ����ɣ� 0
$select_sql .= "    t_client.client_cd2,\n";                  //����åץ����ɣ� 1
$select_sql .= "    t_client.shop_name,\n";                   //��̾ 2
$select_sql .= "    t_client.shop_name2,\n";                  //��̾2 3
$select_sql .= "    t_client.shop_read,\n";                   //��̾(�եꥬ��) 4
$select_sql .= "    t_client.shop_read2,\n";                  //��̾2(�եꥬ��) 5
$select_sql .= "    t_client.client_name,\n";                 //����å�̾ 6
$select_sql .= "    t_client.client_read,\n";                 //����å�̾(�եꥬ��) 7
$select_sql .= "    t_client.represe,\n";                     //��ɽ���� 8
$select_sql .= "    t_client.rep_name,\n";                    //��ɽ�Ի�̾ 9
$select_sql .= "    t_client.rep_htel,\n";                    //��ɽ�Է��� 10
$select_sql .= "    t_client.post_no1,\n";                    //͹���ֹ� 11
$select_sql .= "    t_client.post_no2,\n";                    //͹���ֹ� 12
$select_sql .= "    t_client.address1,\n";                    //����1 13
$select_sql .= "    t_client.address2,\n";                    //����2 14
$select_sql .= "    t_client.address3,\n";                    //����3 15
$select_sql .= "    t_client.address_read,\n";                //����(�եꥬ��) 16
$select_sql .= "    t_client.capital,\n";                     //���ܶ� 17
$select_sql .= "    t_client.tel,\n";                         //TEL 18
$select_sql .= "    t_client.fax,\n";                         //FAX 19
$select_sql .= "    t_client.email,\n";                       //Email 20
$select_sql .= "    t_client.url,\n";                         //URL 21
$select_sql .= "    t_client.direct_tel,\n";                  //ľ��TEL 22
#2009-12-25 aoyama-n
#$select_sql .= "    t_client.tax_rate_n,\n";                  //���߾�����Ψ 23
#$select_sql .= "    t_client.tax_rate_c,\n";                  //������Ψ 24
#$select_sql .= "    t_client.tax_rate_cday,\n";               //��Ψ������ 25
$select_sql .= "    NULL,\n";                                 //���߾�����Ψ 23
$select_sql .= "    NULL,\n";                                 //������Ψ 24
$select_sql .= "    NULL,\n";                                 //��Ψ������ 25
$select_sql .= "    t_client.my_close_day,\n";                //�������� 26
$select_sql .= "    t_client.my_pay_m,\n";                    //��ʧ��(��) 27
$select_sql .= "    t_client.my_pay_d,\n";                    //��ʧ��(��) 28
$select_sql .= "    t_client.cutoff_month,\n";                //�軻�� 29
$select_sql .= "    t_client.cutoff_day,\n";                  //�軻�� 30
$select_sql .= "    t_client.claim_set,\n";                   //������ֹ����� 31
$select_sql .= "    t_client.regist_day,\n";                  //ˡ���е��� 32
$select_sql .= "    '',\n";                                   //�ܼҡ��ټҶ�ʬ 33(�ܼһټҶ�ʬ�����Ϻ�����뤬�������ѹ��򾯤ʤ����뤿��˶������)
$select_sql .= "    t_client.establish_day,\n";               //�϶��� 34
$select_sql .= "    t_client.area_id,\n";                     //�϶� 35
$select_sql .= "    t_client.ware_id,\n";                     //���ܽв��Ҹ� 36
$select_sql .= "    t_client.charger_name,\n";                //Ϣ��ô���Ի�̾ 37
$select_sql .= "    t_client.charger,\n";                     //Ϣ��ô������ 38
$select_sql .= "    t_client.cha_htel,\n";                    //Ϣ��ô���Է��� 39
$select_sql .= "    t_client.my_coax, \n";                    //��۴ݤ��ʬ 40
$select_sql .= "    t_client.my_tax_franct, \n";              //������ü����ʬ 41
$select_sql .= "    t_client.cal_peri, \n";                   //��������ɽ������ 42
$select_sql .= "    t_client.pay_m, \n";                      //�������ʷ�� 43
$select_sql .= "    t_client.pay_d, ";                      //������������ 44
$select_sql .= "    t_client2.close_day, \n";                 // ����˥ƥ��Ȥμ��������45
$select_sql .= "    t_client2.pay_m, \n";                     // ����˥ƥ��Ȥμ����ʧ�46
#2009-12-25 aoyama-n
#$select_sql .= "    t_client2.pay_d \n";                      // ����˥ƥ��Ȥμ����ʧ����47
$select_sql .= "    t_client2.pay_d, \n";                      // ����˥ƥ��Ȥμ����ʧ����47
$select_sql .= "    t_client.tax_rate_old, \n";                //�������Ψ
$select_sql .= "    t_client.tax_rate_now, \n";                //��������Ψ
$select_sql .= "    t_client.tax_change_day_now, \n";          //����Ψ������
$select_sql .= "    t_client.tax_rate_new, \n";                //��������Ψ
$select_sql .= "    t_client.tax_change_day_new \n";           //����Ψ������
$select_sql .= " FROM\n";
$select_sql .= "    t_client, \n";
//$select_sql .= "    INNER JOIN \n";
$select_sql .= " (SELECT close_day, pay_m, pay_d, shop_id FROM t_client WHERE head_flg = 't' AND \n";
$select_sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") \n" : " shop_id = $client_id \n";
$select_sql .= ") AS t_client2 \n";
///$select_sql .= "    ON t_client.client_id = t_client2.shop_id \n";
$select_sql .= " WHERE\n";
//$select_sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $client_id ";
$select_sql .= " t_client.client_id = $client_id \n";
$select_sql .= ";\n";

//������ȯ��
$result = Db_Query($db_con, $select_sql);

//Get_Id_Check($result);
//�ǡ�������
$head_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

//�����������
$select_sql = "SELECT ";
$select_sql .= "    stand_day";
$select_sql .= " FROM";
$select_sql .= "    t_stand;";
//������ȯ��
$result = Db_Query($db_con, $select_sql);

//�ǡ�������
$stand_row = @pg_num_rows($result);
$abcd_data = @pg_fetch_array ($result, 0, PGSQL_NUM);

//����ͥǡ���
$defa_data["form_shop_cd"]["cd1"]         = $head_data[0];         //����åץ�����1
$defa_data["form_shop_cd"]["cd2"]         = $head_data[1];         //����åץ�����2
$defa_data["form_comp_name"]              = $head_data[2];         //��̾
$defa_data["form_comp_name2"]             = $head_data[3];         //��̾2
$defa_data["form_comp_read"]              = $head_data[4];         //��̾(�եꥬ��)
$defa_data["form_comp_read2"]             = $head_data[5];         //��̾2(�եꥬ��)
$defa_data["form_cname"]                  = $head_data[6];         //����å�̾
$defa_data["form_cread"]                  = $head_data[7];         //����å�̾(�եꥬ��)
$defa_data["form_represe"]                = $head_data[8];         //��ɽ����
$defa_data["form_rep_name"]               = $head_data[9];         //��ɽ�Ի�̾
$defa_data["form_represent_cell"]         = $head_data[10];        //��ɽ�Է���
$defa_data["form_post_no"]["no1"]         = $head_data[11];        //͹���ֹ�
$defa_data["form_post_no"]["no2"]         = $head_data[12];        //͹���ֹ�
$defa_data["form_address1"]               = $head_data[13];        //����1
$defa_data["form_address2"]               = $head_data[14];        //����2
$defa_data["form_address3"]               = $head_data[15];        //����3
$defa_data["form_address_read"]           = $head_data[16];        //����(�եꥬ��)
$defa_data["form_capital_money"]          = $head_data[17];        //���ܶ�
$defa_data["form_tel"]                    = $head_data[18];        //TEL
$defa_data["form_fax"]                    = $head_data[19];        //FAX
$defa_data["form_email"]                  = $head_data[20];        //Email
$defa_data["form_url"]                    = $head_data[21];        //URL
$defa_data["form_direct_tel"]             = $head_data[22];        //ľ��TEL
$defa_data["form_tax_now"]                = $head_data[23];        //���߾�����Ψ
#2009-12-25 aoyama-n
#$defa_data["form_tax"]                    = $head_data[24];        //������Ψ
#$rate_day[y] = substr($head_data[25],0,4);
#$rate_day[m] = substr($head_data[25],5,2);
#$rate_day[d] = substr($head_data[25],8,2);
#$defa_data["form_tax_rate_day"]["y"]      = $rate_day[y];          //��Ψ������(ǯ)
#$defa_data["form_tax_rate_day"]["m"]      = $rate_day[m];          //��Ψ������(��)
#$defa_data["form_tax_rate_day"]["d"]      = $rate_day[d];          //��Ψ������(��)
$defa_data["form_close_day"]              = $head_data[45];        //����
$defa_data["form_pay_month"]              = $head_data[46];        //��ʧ��(��)
$defa_data["form_pay_day"]                = $head_data[47];        //��ʧ��(��)
$defa_data["form_my_close_day"]           = $head_data[26];        //��������

//��ʧ��¸��Ƚ��
if($head_data[27] != NULL && $head_data[28] != NULL){
    //��ʧ���ʡ����ҡˤ򥻥å�
    $defa_data["form_my_pay_month"]       = $head_data[27];        //���һ�ʧ��(��)
    $defa_data["form_my_pay_day"]         = $head_data[28];        //���һ�ʧ��(��)
}else{
    //��ʧ�������ꤵ��Ƥ��ʤ����ϡ��ƣåޥ����ν������򥻥å�
    $defa_data["form_my_pay_month"]       = $head_data[43];        //������(��)
    $defa_data["form_my_pay_day"]         = $head_data[44];        //������(��)
}
$defa_data["form_cutoff_month"]           = $head_data[29];        //�軻��
$defa_data["form_cutoff_day"]             = $head_data[30];        //�軻��
//������ֹ����꤬¸�ߤ��뤫Ƚ��
if($head_data[31] != NULL){
    $defa_data["form_claim_num"]              = $head_data[31];        //������ֹ�����
}
$corpo_day[y] = substr($head_data[32],0,4);
$corpo_day[m] = substr($head_data[32],5,2);
$corpo_day[d] = substr($head_data[32],8,2);
$defa_data["form_corpo_day"]["y"]         = $corpo_day[y];         //ˡ���е���(ǯ)
$defa_data["form_corpo_day"]["m"]         = $corpo_day[m];         //ˡ���е���(��)
$defa_data["form_corpo_day"]["d"]         = $corpo_day[d];         //ˡ���е���(��)
//$attach_gid                               = $head_data[33];
$establish_day[y] = substr($head_data[34],0,4);
$establish_day[m] = substr($head_data[34],5,2);
$establish_day[d] = substr($head_data[34],8,2);
$defa_data["form_establish_day"]["y"]     = $establish_day[y];     //�϶���(ǯ)
$defa_data["form_establish_day"]["m"]     = $establish_day[m];     //�϶���(��)
$defa_data["form_establish_day"]["d"]     = $establish_day[d];     //�϶���(��)
$defa_data["form_area"]                  = $head_data[35];         //�϶�
//$defa_data["form_ware"]                  = $head_data[36];         //���ܽв��Ҹ�
$defa_data["form_contact_name"]          = $head_data[37];         //Ϣ��ô���Ի�̾
$defa_data["form_contact_position"]      = $head_data[38];         //Ϣ��ô������
$defa_data["form_contact_cell"]          = $head_data[39];         //Ϣ��ô���Է���
//��۴ݤ��ʬ��¸�ߤ��뤫Ƚ��
if($head_data[40] != NULL){
    $defa_data["form_coax"]              = $head_data[40];         //��۴ݤ��ʬ
}
//������ü����ʬ��¸�ߤ��뤫Ƚ��
if($head_data[41] != NULL){
    $defa_data["from_fraction_div"]          = $head_data[41];         //������ü����ʬ
}

//��������ɽ�����֤�¸�ߤ��뤫Ƚ��
if($head_data[42] != NULL){
    $defa_data["form_cal_peri"]          = $head_data[42];         //��������ɽ������
}

$before_state                            = $head_data[42];         //���ɽ���ξ��֤�hidden�˥��å�
$defa_data["before_state"]               = $head_data[42];         

#2009-12-25 aoyama-n
$defa_data["form_tax_rate_old"]           = $head_data[48];         //�������Ψ
$defa_data["form_tax_rate_now"]           = $head_data[49];         //��������Ψ
$change_day_now[y] = substr($head_data[50],0,4);
$change_day_now[m] = substr($head_data[50],5,2);
$change_day_now[d] = substr($head_data[50],8,2);
$defa_data["form_tax_change_day_now"]["y"] = $change_day_now[y];    //����Ψ������
$defa_data["form_tax_change_day_now"]["m"] = $change_day_now[m];    //����Ψ������
$defa_data["form_tax_change_day_now"]["d"] = $change_day_now[d];    //����Ψ������
$defa_data["form_tax_rate_new"]           = $head_data[51];         //��������Ψ
$change_day_new[y] = substr($head_data[52],0,4);
$change_day_new[m] = substr($head_data[52],5,2);
$change_day_new[d] = substr($head_data[52],8,2);
$defa_data["form_tax_change_day_new"]["y"] = $change_day_new[y];    //����Ψ������
$defa_data["form_tax_change_day_new"]["m"] = $change_day_new[m];    //����Ψ������
$defa_data["form_tax_change_day_new"]["d"] = $change_day_new[d];    //����Ψ������

$abcd_day[y] = substr($abcd_data[0],0,4);
$abcd_day[m] = substr($abcd_data[0],5,2);
$abcd_day[d] = substr($abcd_data[0],8,2);
$defa_data["form_abcd_day"]["y"]          = $abcd_day[y];          //ABCD�������(ǯ)
$defa_data["form_abcd_day"]["m"]          = $abcd_day[m];          //ABCD�������(��)
$defa_data["form_abcd_day"]["d"]          = $abcd_day[d];          //ABCD�������(��)

//���������                                         
$form->setDefaults($defa_data);

/*
//FC���롼�ץ����ɼ���
if($attach_gid != null){
    $select_sql = "SELECT ";
    $select_sql .= "    shop_gcd";
    $select_sql .= " FROM";
    $select_sql .= "    t_shop_gr";
    $select_sql .= " WHERE";
    $select_sql .= "    shop_gid = $attach_gid";
    $select_sql .= ";";
    //������ȯ��
    $result = Db_Query($db_con, $select_sql);
    //�ǡ�������
    $attach_gid = @pg_fetch_result ($result, 0);
}
*/

/****************************/
//�ե���������
/****************************/
//����åץ�����
$form_shop_cd[] =& $form->createElement(
        "text","cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        $g_form_option"
        );
$form_shop_cd[] =& $form->createElement(
        "static","","","-"
        );
$form_shop_cd[] =& $form->createElement(
        "text","cd2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        $g_form_option"
        );
$anytime_freeze[] = $form->addGroup( $form_shop_cd, "form_shop_cd", "form_shop_cd");

//��̾
$form->addElement(
        "text","form_comp_name","�ƥ����ȥե�����","size=\"46\" maxLength=\"25\" 
        $g_form_option"
        );

//��̾2
$form->addElement(
        "text","form_comp_name2","�ƥ����ȥե�����","size=\"46\" maxLength=\"25\" 
        $g_form_option"
        );

//��̾(�եꥬ��)
$form->addElement(
        "text","form_comp_read","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//��̾2(�եꥬ��)
$form->addElement(
        "text","form_comp_read2","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//����å�̾
$anytime_freeze[] = $form->addElement(
        "text","form_cname","�ƥ����ȥե�����","size=\"46\" maxLength=\"25\" 
        $g_form_option"
        );

//����å�̾�ʥեꥬ�ʡ�
$anytime_freeze[] = $form->addElement(
        "text","form_cread","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//��ɽ����
$form->addElement(
        "text","form_represe","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//��ɽ�Ի�̾
$form->addElement(
        "text","form_rep_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
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

//�϶�
$where  = " where ";
$where .= " shop_id = (SELECT shop_id FROM t_client WHERE client_div = '0') ";
$select_ary = Select_Get($db_con,'area',$where);
$anytime_freeze[] = $form->addElement('select', 'form_area',"", $select_ary,$g_form_option_select);

//͹���ֹ�
$form_post[] =& $form->createElement(
        "text","no1","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post_no[no1]','form_post_no[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        $g_form_option"
        );
$form->addGroup( $form_post, "form_post_no", "form_post_no");

//���ܶ�
$form->addElement(
        "text","form_capital_money","",
        "class=\"money\" size=\"11\" maxLength=\"9\" style=\"$g_form_style;text-align: right\"
        ".$g_form_option.""
        );

//����1
$form->addElement(

        "text","form_address1","�ƥ����ȥե�����","size=\"46\" maxLength=\"25\" 
        $g_form_option"
        );

//����2
$form->addElement(
        "text","form_address2","�ƥ����ȥե�����","size=\"46\" maxLength=\"25\" 
        $g_form_option"
        );

//����3
$form->addElement(
        "text","form_address3","�ƥ����ȥե�����","size=\"46\" maxLength=\"30\" 
        $g_form_option"
        );

//����2(�եꥬ��)
$form->addElement(
        "text","form_address_read","�ƥ����ȥե�����","size=\"46\" maxLength=\"50\" 
        $g_form_option"
        );

//TEL
$form->addElement(
        "text","form_tel","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
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

#2009-12-25 aoyama-n
/*
//������Ψ(����)
$form->addElement(
        "text","form_tax_now","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" 
         style=\"text-align: center; border : #ffffff; background-color: #ffffff;\" readonly"
         );

//������Ψ
$form->addElement(
        "text","form_tax","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" 
        $g_form_option 
         style=\"$g_form_style;text-align: right\"");
*/


//�϶���
/*
$form_establish_day[] =& $form->createElement(
        "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_establish_day[y]','form_establish_day[m]',4)\" 
        $g_form_option"
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","m","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_establish_day[m]','form_establish_day[d]',2)\" 
        ".$g_form_option."\""
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","d","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        ".$g_form_option."\""
        );
$form->addGroup( $form_establish_day,"form_establish_day","form_establish_day");
*/
Addelement_Date($form,"form_establish_day","�϶���","-");


//ˡ���е���
/*
$form_corpo_day[] =& $form->createElement(
        "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_corpo_day[y]','form_corpo_day[m]',4)\" 
        ".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","m","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_corpo_day[m]','form_corpo_day[d]',2)\" 
        ".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","d","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        ".$g_form_option."\""
        );
$form->addGroup( $form_corpo_day,"form_corpo_day","form_corpo_day");
*/
Addelement_Date($form,"form_corpo_day","ˡ���е���","-");


//Ϣ��ô���Ի�̾
$form->addElement(
        "text","form_contact_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//Ϣ��ô������
$form->addElement(
        "text","form_contact_position","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//Ϣ��ô���Է���
$form->addElement(
        "text","form_contact_cell","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" 
        $g_form_option"
        );

//��Ψ������
#2009-12-25
/*
$form_tax_rate_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_tax_rate_day[y]','form_tax_rate_day[m]',4)\" 
        ".$g_form_option."\""
        );
$form_tax_rate_day[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_rate_day[] =& $form->createElement(
        "text","m","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_tax_rate_day[m]','form_tax_rate_day[d]',2)\" 
        ".$g_form_option."\""
        );
$form_tax_rate_day[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_rate_day[] =& $form->createElement(
        "text","d","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        ".$g_form_option."\""
        );
$form->addGroup( $form_tax_rate_day,"form_tax_rate_day","");
*/

//�������Ψ
$form->addElement(
        "text","form_tax_rate_old","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\"
         style=\"text-align: center; border : #ffffff; background-color: #ffffff;$g_form_style\" readonly"
         );

//��������Ψ
$form->addElement(
        "text","form_tax_rate_now","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\"
         style=\"text-align: center; border : #ffffff; background-color: #ffffff; color: blue; font-weight: bold;$g_form_style\" readonly"
         );

//����Ψ������
$form_tax_change_day_now[] =& $form->createElement(
        "text","y","","size=\"5\" maxLength=\"4\"
         style=\"text-align: center; border : #ffffff; background-color: #ffffff; color: blue; font-weight: bold;$g_form_style\" readonly"
         );
$form_tax_change_day_now[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_change_day_now[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\"
         style=\"text-align: center; border : #ffffff; background-color: #ffffff; color: blue; font-weight: bold;$g_form_style\" readonly"
        );
$form_tax_change_day_now[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_change_day_now[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\"
         style=\"text-align: center; border : #ffffff; background-color: #ffffff; color: blue; font-weight: bold;$g_form_style\" readonly"
        );
$form->addGroup( $form_tax_change_day_now,"form_tax_change_day_now","");


//��������Ψ����ե饰
$form->addElement("checkbox", "form_tax_setup_flg", "", "");

//��������Ψ
$form->addElement(
        "text","form_tax_rate_new","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\"
        $g_form_option
        style=\"text-align: right;$g_form_style\"");

//����Ψ������
$form_tax_change_day_new[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_tax_change_day_new[y]','form_tax_change_day_new[m]',4)\"
        ".$g_form_option."\""
        );
$form_tax_change_day_new[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_change_day_new[] =& $form->createElement(
        "text","m","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_tax_change_day_new[m]','form_tax_change_day_new[d]',2)\"
        ".$g_form_option."\""
        );
$form_tax_change_day_new[] =& $form->createElement(
        "static","","","-"
        );
$form_tax_change_day_new[] =& $form->createElement(
        "text","d","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        ".$g_form_option."\""
        );
$form->addGroup( $form_tax_change_day_new,"form_tax_change_day_new","");


//��������
$close_day = Select_Get($db_con, "close" );
$anytime_freeze[] = $form->addElement('select', 'form_close_day', '���쥯�ȥܥå���', $close_day, "onchange=\"window.focus();\"");

//��ʧ��
//��
$select_month[null] = null;
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "����";
    }elseif($i == 1){
        $select_month[1] = "���";
    }else{
        $select_month[$i] = $i."�����";
    }
}
$anytime_freeze[] = $form->addElement("select", "form_pay_month", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

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
$anytime_freeze[] = $form->addElement("select", "form_pay_day", "���쥯�ȥܥå���", $select_day, $g_form_option_select);

//��������
$my_close_day = Select_Get($db_con, "close" );
$form->addElement('select', 'form_my_close_day', '���쥯�ȥܥå���', $my_close_day, "onchange=\"window.focus();\"");

//��ʧ��
//��
$select_month[null] = null;
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "����";
    }elseif($i == 1){
        $select_month[1] = "���";
    }else{
        $select_month[$i] = $i."�����";
    }
}
$form->addElement("select", "form_my_pay_month", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

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
$form->addElement("select", "form_my_pay_day", "���쥯�ȥܥå���", $select_day, $g_form_option_select);

//�軻��
$form->addElement(
        "text","form_cutoff_month","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;text-align: right\"
        ".$g_form_option."\""
        );

//�軻��
$form->addElement(
        "text","form_cutoff_day","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;text-align: right\"
        ".$g_form_option."\""
        );

//ABCD�������
$form_abcd_day[] =& $form->createElement(
        "static","y","","-"
        );
/*$form_abcd_day[] =& $form->createElement(
        "static","","","-"
        );*/
$form_abcd_day[] =& $form->createElement(
        "static","m","","-"
        );
/*$form_abcd_day[] =& $form->createElement(
        "static","","","-"
        );*/
$form_abcd_day[] =& $form->createElement(
        "static","d","","-"
        );
$form->addGroup( $form_abcd_day,"form_abcd_day","","-");

//������ֹ�����
$form_claim_num[] =& $form->createElement(
        "radio",NULL,NULL, "�̾�","1"
        );
$form_claim_num[] =& $form->createElement(
        "radio",NULL,NULL, "ǯ���̡�","2"
        );
$form_claim_num[] =& $form->createElement(
        "radio",NULL,NULL, "����","3"
        );
$form->addGroup($form_claim_num, "form_claim_num", "������ֹ�����");

//�ޤ���ʬ
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ڼ�","1"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ͼθ���","2"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ھ�","3"
         );
$form->addGroup($form_coax, "form_coax", "�ޤ���ʬ");

//ü����ʬ
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ڼ�","1"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ͼθ���","2"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ھ�","3"
         );
$form->addGroup($from_fraction_div, "from_fraction_div", "ü����ʬ");

//��������ɽ������
$form_cal_peri[] =& $form->createElement(
         "radio",NULL,NULL, "1����","1"
         );
$form_cal_peri[] =& $form->createElement(
         "radio",NULL,NULL, "2����","2"
         );
$form_cal_peri[] =& $form->createElement(
         "radio",NULL,NULL, "3����","3"
         );
$form->addGroup( $form_cal_peri,"form_cal_peri","��������ɽ������");

//���ܽв��Ҹ�
//$select_value = Select_Get($db_con,'ware');
//$form->addElement('select', 'form_ware', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//��ư���ϥܥ���
$button[] = $form->createElement(
        "button","input_button","��ư����","onClick=\"javascript:Button_Submit_1('input_button_flg','#','true')\""
        ); 

//��Ͽ�ܥ���
$button[] = $form->createElement(
        "submit","entry_button","�С�Ͽ",
        "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled"
);

//�Ұ����ѹ��ܥ���
$button[] = $form->createElement(
        "button","change_stamp","�Ұ����ѹ�","onClick=\"location.href('2-1-301-2.php')\" $disabled"
        );

//�Ұ��κ���ܥ���
$button[] = $form->createElement(
        "submit","delete_stamp","�Ұ��κ��","onClick=\"javascript:return dialogue5('�Ұ��������ޤ���','#')\" $disabled"
        );

$form->addGroup($button, "button", "");

//hidden
$form->addElement("hidden","input_button_flg");
$form->addElement("hidden", "before_state");  //���ɽ�����ξ�����

/***************************/
//Freeze
/***************************/
$anytime_freeze_form = $form->addGroup($anytime_freeze, "anytime_freeze", "");
$anytime_freeze_form->freeze();

/***************************/
//�롼�������QuickForm��
/***************************/
//����̾
//��ɬ�ܥ����å�
$form->addRule("form_comp_name", "��̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_comp_name", "��̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//������å�̾
//��ɬ�ܥ����å�
$form->addRule("form_cname", "����å�̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");

//����ɽ�Ի�̾
//��ɬ�ܥ����å�
$form->addRule("form_rep_name", "��ɽ�Ի�̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//��͹���ֹ�
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
//��ʸ���������å�
$form->addGroupRule('form_post_no', array(
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
$form->addRule("form_area", "�϶�����򤷤Ʋ�������","required");

//��TEL
//��ɬ�ܥ����å�
$form->addRule("form_tel", "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "required");

#2009-12-25 aoyama-n
//��������Ψ
//��Ⱦ�ѿ��������å�
//$form->addRule("form_tax", "������Ψ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");
#$form->addRule("form_tax", "������Ψ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//����Ψ������
//��Ⱦ�ѿ��������å�
#$form->addGroupRule('form_tax_rate_day', array(
#        'y' => array(
#                array('��Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
#        ),
#        'm' => array(
#                array('��Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
#        ),
#        'd' => array(
#                array('��Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
#        ),
#));

//����������
//��ɬ�ܥ����å�
$form->addRule("form_my_close_day", "�������������򤷤Ƥ���������","required");

//����ʧ���ʷ��
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_my_pay_month", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_my_pay_month", "��ʧ���ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//����ʧ��������
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_my_pay_day", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_my_pay_day", "��ʧ�������ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//���軻��
//��Ⱦ�ѿ��������å�
$form->addRule("form_cutoff_month", "�軻���Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//���軻��
//��Ⱦ�ѿ��������å�
$form->addRule("form_cutoff_day", "�軻����Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//�����ܶ�
//��Ⱦ�ѿ��������å�
//$form->addRule("form_capital_money", "���ܶ��Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");
$form->addRule("form_capital_money", "���ܶ��Ⱦ�ѿ����ΤߤǤ���","regex", '/^[0-9]+$/');

//���軻��
//��Ⱦ�ѿ��������å�
$form->addRule("form_cutoff_day", "�軻����Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//���϶���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_establish_day', array(
        'y' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//��ˡ���е���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_corpo_day', array(
        'y' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//�����ܽв��Ҹ�
//��ɬ�ܥ����å�
//$form->addRule("form_ware", "���ܽв��Ҹˤ����򤷤Ƥ���������","required");

/****************************/
//��Ͽ�ܥ��󲡲�
/****************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){
    /****************************/
    //POST����
    /****************************/
    $head_cd1         = $_POST["anytime_freeze"]["form_shop_cd"]["cd1"];          //����åץ�����1
    $head_cd2         = $_POST["anytime_freeze"]["form_shop_cd"]["cd2"];          //����åץ�����2
    $comp_name        = $_POST["form_comp_name"];               //��̾
    $comp_name_read   = $_POST["form_comp_read"];               //��̾(�եꥬ��)
    $comp_name2       = $_POST["form_comp_name2"];              //��̾2
    $comp_name_read2  = $_POST["form_comp_read2"];              //��̾2(�եꥬ��)
    $cname            = $_POST["form_cname"];                   //����å�̾
    $cread            = $_POST["form_cread"];                   //����å�̾(�եꥬ��)
    $represe          = $_POST["form_represe"];                 //��ɽ����
    $rep_name         = $_POST["form_rep_name"];                //��ɽ�Ի�̾
    $rep_htel         = $_POST["form_represent_cell"];          //��ɽ�Է���
    $post_no1         = $_POST["form_post_no"]["no1"];          //͹���ֹ�
    $post_no2         = $_POST["form_post_no"]["no2"];          //͹���ֹ�
    $address1         = $_POST["form_address1"];                //����1
    $address2         = $_POST["form_address2"];                //����2
    $address3         = $_POST["form_address3"];                //����3
    $address_read     = $_POST["form_address_read"];            //����(�եꥬ��)
    $capital_money    = $_POST["form_capital_money"];           //���ܶ�
    $tel              = $_POST["form_tel"];                     //TEL
    $fax              = $_POST["form_fax"];                     //FAX
    $email            = $_POST["form_email"];                   //Email
    $url              = $_POST["form_url"];                     //URL
    $direct_tel       = $_POST["form_direct_tel"];              //ľ��TEL
    #2009-12-25 aoyama-n
    $tax_setup_flg    = $_POST["form_tax_setup_flg"];           //��������Ψ����ե饰
    #$tax              = $_POST["form_tax"];                     //������Ψ
    $tax_rate_new     = $_POST["form_tax_rate_new"];            //��������Ψ

    #2009-12-25 aoyama-n
    #$rate_day         = str_pad($_POST["form_tax_rate_day"]["y"],4,0,STR_PAD_LEFT);       //��Ψ������(ǯ)
    #$rate_day        .= "-";
    #$rate_day        .= str_pad($_POST["form_tax_rate_day"]["m"],2,0,STR_PAD_LEFT);       //��Ψ������(��)
    #$rate_day        .= "-";
    #$rate_day        .= str_pad($_POST["form_tax_rate_day"]["d"],2,0,STR_PAD_LEFT);       //��Ψ������(��)
    $tax_change_day_new  = str_pad($_POST["form_tax_change_day_new"]["y"],4,0,STR_PAD_LEFT);  //����Ψ������(ǯ)
    $tax_change_day_new .= "-";
    $tax_change_day_new .= str_pad($_POST["form_tax_change_day_new"]["m"],2,0,STR_PAD_LEFT);  //����Ψ������(��)
    $tax_change_day_new .= "-";
    $tax_change_day_new .= str_pad($_POST["form_tax_change_day_new"]["d"],2,0,STR_PAD_LEFT);  //����Ψ������(��)

    $my_close_day     = $_POST["form_my_close_day"];            //��������
    $my_pay_month     = $_POST["form_my_pay_month"];            //���һ�ʧ��(��)
    $my_pay_day       = $_POST["form_my_pay_day"];              //���һ�ʧ��(��)
    $cutoff_month     = $_POST["form_cutoff_month"];            //�軻��
    $cutoff_day       = $_POST["form_cutoff_day"];              //�軻��
    
    $claim_num        = $_POST["form_claim_num"];               //������ֹ�����
    $coax             = $_POST["form_coax"];                    //��۴ݤ��ʬ
    $franct           = $_POST["from_fraction_div"];            //������ü����ʬ
    $area             = $_POST["form_area"];                    //�϶�
    //$ware             = $_POST["form_ware"];                    //���ܽв��Ҹ�
    $contact_name     = $_POST["form_contact_name"];            //Ϣ��ô���Ի�̾
    $contact_position = $_POST["form_contact_position"];        //Ϣ��ô������
    $contact_cell     = $_POST["form_contact_cell"];            //Ϣ��ô���Է���

    $establish_day    = str_pad($_POST["form_establish_day"]["y"],4,0,STR_PAD_LEFT);      //�϶���(ǯ)
    $establish_day   .= "-";
    $establish_day   .= str_pad($_POST["form_establish_day"]["m"],2,0,STR_PAD_LEFT);      //�϶���(��)
    $establish_day   .= "-";
    $establish_day   .= str_pad($_POST["form_establish_day"]["d"],2,0,STR_PAD_LEFT);      //�϶���(��)

    $corpo_day        = str_pad($_POST["form_corpo_day"]["y"],4,0,STR_PAD_LEFT);          //ˡ���е���(ǯ)
    $corpo_day       .= "-";
    $corpo_day       .= str_pad($_POST["form_corpo_day"]["m"],2,0,STR_PAD_LEFT);          //ˡ���е���(��)
    $corpo_day       .= "-";
    $corpo_day       .= str_pad($_POST["form_corpo_day"]["d"],2,0,STR_PAD_LEFT);          //ˡ���е���(��)

    $cal_peri         = $_POST["form_cal_peri"];                //��������ɽ������


    /***************************/
    //�����
    /***************************/
    //����åץ����ɣ�
    $head_cd1 = str_pad($head_cd1, 6, 0, STR_POS_LEFT);

    //����åץ����ɣ�
    $head_cd2 = str_pad($head_cd2, 4, 0, STR_POS_LEFT);

    /***************************/
    //�롼�������PHP��
    /***************************/
    // ľ�Ĥξ��ϥ����å����ʤ�
    if ($group_kind != "2"){
        //����åץ�����
        if($head_cd1 != null && $head_cd2 != null){
            $head_cd_sql  = "SELECT";
            $head_cd_sql  .= " client_id FROM t_client";
            $head_cd_sql  .= " WHERE";
            $head_cd_sql  .= " client_cd1 = '$head_cd1'";
            $head_cd_sql  .= " AND";
            $head_cd_sql  .= " '$head_data[0]' != '$head_cd1'";
            $head_cd_sql  .= " AND";
            $head_cd_sql  .= " client_cd2 = '$head_cd2'";
            $head_cd_sql  .= " AND";
            $head_cd_sql  .= " '$head_data[1]' != '$head_cd2'";
            $head_cd_sql  .= ";";
            $select_shop = Db_Query($db_con, $head_cd_sql);
            $select_shop = pg_num_rows($select_shop);
            if($select_shop != 0){
                $head_cd_err = "���Ϥ��줿����åץ����ɤϻ�����Ǥ���";
                $err_flg = true;
            }
        }
    }
    
    //��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
        $tel_err = "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    //��FAX
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$fax) && $fax != null){
        $fax_err = "FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    //��Email
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

    //��ľ��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$direct_tel) && $direct_tel != ""){
        $d_tel_err = "ľ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    //��Ϣ��ô���Է���
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$contact_cell) && $contact_cell != ""){
        $contact_cell_err = "Ϣ��ô���Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    //���϶���
    //�����դ������������å�
    $eday_y = (int)$_POST["form_establish_day"]["y"];
    $eday_m = (int)$_POST["form_establish_day"]["m"];
    $eday_d = (int)$_POST["form_establish_day"]["d"];
    
    if($eday_m != null || $eday_d != null || $eday_y != null){
        $eday_flg = true;
    }
    $check_e_day = checkdate($eday_m,$eday_d,$eday_y);
    if($check_e_day == false && $eday_flg == true){
        $eday_err = "�϶��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    
    //��ˡ���е���
    //�����դ������������å�
    $cday_y = (int)$_POST["form_corpo_day"]["y"];
    $cday_m = (int)$_POST["form_corpo_day"]["m"];
    $cday_d = (int)$_POST["form_corpo_day"]["d"];
    
    if($cday_m != null || $cday_d != null || $cday_y != null){
        $cday_flg = true;
    }
    $check_c_day = checkdate($cday_m,$cday_d,$cday_y);
    if($check_c_day == false && $cday_flg == true){
        $cday_err = "ˡ���е��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    
    //����Ψ������
    #2009-12-25 aoyama-n
    //�����դ������������å�
    #$rday_y = (int)$_POST["form_tax_rate_day"]["y"];
    #$rday_m = (int)$_POST["form_tax_rate_day"]["m"];
    #$rday_d = (int)$_POST["form_tax_rate_day"]["d"];

    #if($rday_m != null || $rday_d != null || $rday_y != null){
    #    $rday_flg = true;
    #}
    #$check_r_day = checkdate($rday_m,$rday_d,$rday_y);
    #if($check_r_day == false && $rday_flg == true){
    #    $rday_err = "��Ψ�����������դ������ǤϤ���ޤ���";
    #    $err_flg = true;
    //̤������դ������å�
    #}elseif(date("Ymd",mktime(0,0,0,$rday_m, $rday_d, $rday_y)) <= date("Ymd")){
    #    $rday_err = "��Ψ��������̤������դ���ꤷ�Ʋ�������";
    #    $err_flg = true;
    #}

    #2009-12-25 aoyama-n
    #��������Ψ�����ꤹ��˥����å���������
    if($tax_setup_flg == 1){

        //��������Ψ
        //��ɬ�ܥ����å�
        $form->addRule("form_tax_rate_new", "��������Ψ��Ⱦ�ѿ����ΤߤǤ���","required");
        //��Ⱦ�ѿ��������å�
        $form->addRule("form_tax_rate_new", "��������Ψ��Ⱦ�ѿ����ΤߤǤ���", "regex", '/^[0-9]+$/');

        //����Ψ������
        //��Ⱦ�ѿ��������å�
        $form->addGroupRule('form_tax_change_day_new', array(
                'y' => array(
                        array('����Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
                ),
                'm' => array(
                        array('����Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
                ),
                'd' => array(
                       array('����Ψ�����������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
                ),
        ));

        //�����դ������������å�
        $rday_y = (int)$_POST["form_tax_change_day_new"]["y"];
        $rday_m = (int)$_POST["form_tax_change_day_new"]["m"];
        $rday_d = (int)$_POST["form_tax_change_day_new"]["d"];

        if($rday_m != null || $rday_d != null || $rday_y != null){
            //�����������å�
            $check_r_day = checkdate($rday_m,$rday_d,$rday_y);
            if($check_r_day == false){
                $rday_err = "����Ψ�����������դ������ǤϤ���ޤ���";
                $err_flg = true;
            //̤������ե����å�
            }elseif(date("Ymd", mktime(0,0,0,$rday_m, $rday_d, $rday_y)) <= date("Ymd")){
                $rday_err = "����Ψ��������̤������դ���ꤷ�Ʋ�������";
                $err_flg = true;
            }
        }else{
            $rday_err = "����Ψ�����������դ������ǤϤ���ޤ���";
            $err_flg = true;
        }
    #��������Ψ�����ꤹ��˥����å���̵�����
    }else{
        #��������Ψ�򿷤������ꤹ����
        if($defa_data["form_tax_rate_new"]         == null &&

           #2010-05-31 hashimoto-y �Х�����
           #($_POST["form_tax_change_day_new"]      != null ||
            #$_POST["form_tax_change_day_new"]["y"] != null ||
            ($_POST["form_tax_change_day_new"]["y"] != null ||
            $_POST["form_tax_change_day_new"]["m"] != null ||
            $_POST["form_tax_change_day_new"]["d"] != null)){
           $rday_err = "��������Ψ�����ꤹ����ϡ������å��ܥå����˥����å�������Ƥ���������";
           $err_flg = true;
        }
    }

	//����������ɽ������
    //������ϰϤμ����ֹ椬�դ��Ƥ�����ɼ�Ϥʤ���Ƚ��
	if($before_state > $cal_peri){
		//��������ɽ������
		$cal_day = 31 * ($cal_peri+1);

		//�оݴ��֡ʳ��ϡ˼���
		$day_y = date("Y");            
		$day_m = date("m");
		$day_d = date("d");
		$end = mktime(0, 0, 0, $day_m,$day_d+$cal_day,$day_y);
		$end_day = date("Y-m-d",$end);

		//�����ֹ椬�����Ƥ��ʤ���ɼ�Τߺ��
		$sql  = "SELECT "; 
		$sql .= "   t_aorder_h.aord_id ";
		$sql .= "FROM ";
		$sql .= "    t_aorder_h ";
		$sql .= "   INNER JOIN t_aorder_d ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
		$sql .= "WHERE ";
		//ľ��Ƚ��
		if($group_kind == 2){
			//ľ��
			$sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") ";
		}else{
			//FC
			$sql .= "   t_aorder_h.shop_id = $client_id ";
		}
		$sql .= " AND ";
		$sql .= "   t_aorder_d.contract_id IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "   t_aorder_h.ord_no IS NOT NULL ";
		$sql .= "AND ";
		$sql .= "   t_aorder_h.ord_time >= '$end_day';";
		$result = Db_Query($db_con,$sql);
	    $check_num = pg_num_rows($result);
        if($check_num != 0){
			$cal_err = "�����˺�������ͽ��ǡ����ˡ������ֹ椬�����Ƥ���ǡ�����¸�ߤ��ޤ���";
        	$err_flg = true;
		}
	}
}

if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){

    //��Ͽ��λ��å�����
    $fin_msg = "��Ͽ���ޤ�����";

    Db_Query($db_con, "BEGIN;");
    
    $update_sql  = "UPDATE \n";
    $update_sql .= "    t_client\n";
    $update_sql .= " SET\n";
    $update_sql .= "    client_cd1 = '$head_cd1',\n";
    $update_sql .= "    client_cd2 = '$head_cd2',\n";
    $update_sql .= "    shop_name = '$comp_name',\n";
    $update_sql .= "    shop_read = '$comp_name_read',\n";
    $update_sql .= "    shop_name2 = '$comp_name2',\n";
    $update_sql .= "    shop_read2 = '$comp_name_read2',\n";
    $update_sql .= "    client_name = '$cname',\n";
    $update_sql .= "    client_read = '$cread',\n";
    $update_sql .= "    represe = '$represe',\n";
    #2009-12-25 aoyama-n
    #$update_sql .= "    tax_rate_c = '$tax',\n";  
    #2009-12-25 aoyama-n
    #if($rate_day == "0000-00-00"){
    #    $update_sql .= "    tax_rate_cday = null,\n"; 
    #}else{
    #    $update_sql .= "    tax_rate_cday = '$rate_day',\n";  
    #}
    #�ֿ�������Ψ�����ꤹ��פ˥����å���������Τ߽�����Ԥ�
    if($tax_setup_flg == 1){
        $update_sql .= "    tax_rate_new = '$tax_rate_new',";
        $update_sql .= "    tax_change_day_new = '$tax_change_day_new',";
    }
    $update_sql .= "    cutoff_month = '$cutoff_month',\n";   
    $update_sql .= "    cutoff_day = '$cutoff_day',\n";   
    $update_sql .= "    rep_name = '$rep_name',\n";
    $update_sql .= "    rep_htel = '$rep_htel',\n";
    $update_sql .= "    post_no1 = '$post_no1',\n";
    $update_sql .= "    post_no2 = '$post_no2',\n";
    $update_sql .= "    address1 = '$address1',\n";
    $update_sql .= "    address2 = '$address2',\n";
    $update_sql .= "    address3 = '$address3',\n";
    $update_sql .= "    address_read = '$address_read',\n";
    $update_sql .= "    capital = '$capital_money',\n";
    $update_sql .= "    tel = '$tel',\n";
    $update_sql .= "    fax = '$fax',\n";
    $update_sql .= "    area_id = '$area',\n";
    $update_sql .= "    email = '$email',\n";
    $update_sql .= "    url = '$url',\n";
    $update_sql .= "    direct_tel = '$direct_tel',\n";
    $update_sql .= "    my_close_day = '$my_close_day',\n";
    if($establish_day == "0000-00-00"){
        $update_sql .= "    establish_day = null,\n"; 
    }else{
        $update_sql .= "    establish_day = '$establish_day',\n";
    }
    $update_sql .= "    my_pay_m = '$my_pay_month',\n";
    $update_sql .= "    my_pay_d = '$my_pay_day',\n";
    if($corpo_day == "0000-00-00"){
        $update_sql .= "    regist_day = null,\n";    
    }else{
        $update_sql .= "    regist_day = '$corpo_day',\n";
    }
    $update_sql .= "    charger_name = '$contact_name',\n";
    $update_sql .= "    charger = '$contact_position',\n";
    $update_sql .= "    cha_htel = '$contact_cell',\n";
    //$update_sql .= "    ware_id = '$ware',\n";
    $update_sql .= "    claim_set = '$claim_num',\n";
    $update_sql .= "    my_coax = '$coax',\n";
    $update_sql .= "    my_tax_franct = '$franct',\n";
    $update_sql .= "    cal_peri = '$cal_peri' \n";
    $update_sql .= " WHERE \n";
    $update_sql .= "    client_id = $client_id\n";
    $update_sql .= ";\n";

    $result = Db_Query($db_con, $update_sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
    //�����������������˻Ĥ�
    $result = Log_Save( $db_con, "client", "2", $head_cd1."-".$head_cd2, $comp_name);
    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
  
	//ľ��Ƚ��
	if($group_kind == 2){
		//ľ�Ĥʤ�¾��ľ�ĤΥ�������ɽ�����֤��ѹ��������֤˹�碌��
		$sql  = "UPDATE ";
		$sql .= "    t_client ";
		$sql .= "SET ";
		$sql .= "    cal_peri = '$cal_peri' ";
		$sql .= "WHERE ";
		$sql .= "    client_id IN (".Rank_Sql().");";
		$result = Db_Query($db_con, $sql);
	    if($result === false){
	        Db_Query($db_con, "ROLLBACK;");
	        exit;
	    }
	}

	//��������ɽ�����֤��ѹ�����긺�ä���Ƚ��
	if($before_state > $cal_peri){
		$cal_peri_num = $before_state - $cal_peri;
		$cal_peri_num = $cal_peri_num * -1;
		//ľ��Ƚ��
		if($group_kind == 2){
			//ľ��

			//�������ѹ����ֹ���SQL
			$sql  = "UPDATE t_client SET cal_peri_num = $cal_peri_num WHERE client_id IN (".Rank_Sql().");";
		}else{
			//FC

			//�������ѹ����ֹ���SQL
			$sql  = "UPDATE t_client SET cal_peri_num = $cal_peri_num WHERE client_id = $client_id;";
		}
		$result = Db_Query($db_con, $sql);
	    if($result === false){
	        Db_Query($db_con, "ROLLBACK;");
	        exit;
	    }
	}
  
	//��������ɽ�����֤��ѹ��������������Ƚ��
	if($before_state < $cal_peri){
		$cal_peri_num = $cal_peri - $before_state;
		//ľ��Ƚ��
		if($group_kind == 2){
			//ľ��

			//�������ѹ����ֹ���SQL
			$sql  = "UPDATE t_client SET cal_peri_num = $cal_peri_num WHERE client_id IN (".Rank_Sql().");";
		}else{
			//FC

			//�������ѹ����ֹ���SQL
			$sql  = "UPDATE t_client SET cal_peri_num = $cal_peri_num WHERE client_id = $client_id;";
		}
		$result = Db_Query($db_con, $sql);
	    if($result === false){
	        Db_Query($db_con, "ROLLBACK;");
	        exit;
	    }
	}

    #2010-01-10 aoyama-n
    #------------------------------------------
    #��������Ψ�����ꤹ��˥����å���������Τ߽�����Ԥ�
    if($tax_setup_flg == 1){
        #�����ǳۥ��饹�����󥹥�������
        $tax_amount_obj = new TaxAmount();

        #�����ǳ۹����оݤμ���ID�����(��������Ψ�������ʹߤμ����ǡ���)
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.aord_id ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "WHERE ";
        $sql .= "    t_aorder_h.ord_time >= '".$tax_change_day_new."' ";
        $sql .= "AND ";
        $sql .= "    t_aorder_h.shop_id = $client_id;";
        $result = Db_Query($db_con, $sql);
        $aord_id_list = Get_Data($result);

        for($i=0; $i<count($aord_id_list); $i++){
            #�����إå��ξ����ǳ۷׻�
            $tax_amount = $tax_amount_obj->getAorderTaxAmount($tax_rate_new, $aord_id_list[$i][0]);

            #�����إå��ξ����ǳ۹���
            $sql  = "UPDATE t_aorder_h SET ";
            $sql .= "    tax_amount = ".$tax_amount;
            $sql .= "WHERE ";
            $sql .= "    aord_id = ".$aord_id_list[$i][0].";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
	            Db_Query($db_con, "ROLLBACK;");
	            exit;
            }
        }
    }
    #------------------------------------------

    Db_Query($db_con, "COMMIT;");
}
/****************************/
//��ư���ϥܥ��󲡲�
/****************************/
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post_no"]["no1"];             //͹���ֹ棱
    $post2     = $_POST["form_post_no"]["no2"];             //͹���ֹ棲
    $post_value = Post_Get($post1,$post2,$db_con);
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"] = "";
    //͹���ֹ椫�鼫ư����
    $cons_data["form_post_no"]["no1"] = $_POST["form_post_no"]["no1"];
    $cons_data["form_post_no"]["no2"] = $_POST["form_post_no"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);
}
/****************************/
//�Ұ��������
/****************************/
if($_POST["button"]["delete_stamp"] == "�Ұ��κ��"){

    $shain_file = COMPANY_SEAL_DIR.$client_id.".jpg";

    // �ե�����¸��Ƚ��
    if(file_exists($shain_file)){
        // �ե�������
        $res = unlink($shain_file);
        header("Location: ".$_SERVER[PHP_SELF]." ");
    }
}


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
$page_menu = Create_Menu_f('system','3');
/****************************/
//���̥إå�������
/****************************/
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
    'head_cd_err'   => "$head_cd_err",
    'tel_err'       => "$tel_err",
    'fax_err'       => "$fax_err",
    'cday_err'      => "$cday_err",
    'eday_err'      => "$eday_err",
	'cal_err'       => "$cal_err",
    'rday_err'      => "$rday_err",
    'attach_gid'    => "$attach_gid",
    'email_err'     => "$email_err",
    'url_err'       => "$url_err",
    'd_tel_err'     => "$d_tel_err",
    'contact_cell_err' => "$contact_cell_err",
    'fin_msg'       => "$fin_msg",
    'path_shain'    => "$path_shain",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>