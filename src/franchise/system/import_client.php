<?php
/******************************/
// DB��Ͽ����
/******************************/
// �Ķ�����ե�����
require_once("ENV_local.php");
function replaceText($str){
    $arr = array(
	"\x87\x40" => '(1)',
	"\x87\x41" => '(2)',
	"\x87\x42" => '(3)',
	"\x87\x43" => '(4)',
	"\x87\x44" => '(5)',
	"\x87\x45" => '(6)',
	"\x87\x46" => '(7)',
	"\x87\x47" => '(8)',
	"\x87\x48" => '(9)',
	"\x87\x49" => '(10)',
	"\x87\x4a" => '(11)',
	"\x87\x4b" => '(12)',
	"\x87\x4c" => '(13)',
	"\x87\x4d" => '(14)',
	"\x87\x4e" => '(15)',
	"\x87\x4f" => '(16)',
	"\x87\x50" => '(17)',
	"\x87\x51" => '(18)',
	"\x87\x52" => '(19)',
	"\x87\x53" => '(20)',
	"\x87\x54" => 'I',
	"\x87\x55" => 'II',
	"\x87\x56" => 'III',
	"\x87\x57" => 'IV',
	"\x87\x58" => 'V',
	"\x87\x59" => 'VI',
	"\x87\x5a" => 'VII',
	"\x87\x5b" => 'VIII',
	"\x87\x5c" => 'IX',
	"\x87\x5d" => 'X',
	"\x87\x5f" => '�Ў�',
	"\x87\x60" => '����',
	"\x87\x61" => '���ݎ�',
	"\x87\x62" => '�Ҏ��Ď�',
	"\x87\x63" => '���ގ׎�',
	"\x87\x64" => '�Ď�',
	"\x87\x65" => '������',
	"\x87\x66" => '�͎�������',
	"\x87\x67" => '�؎��Ď�',
	"\x87\x68" => '�܎���',
	"\x87\x69" => '���ێ؎�',
	"\x87\x6a" => '�Ďގ�',
	"\x87\x6b" => '���ݎ�',
	"\x87\x6c" => '�ʎߎ����ݎ�',
	"\x87\x6d" => '�Ў؎ʎގ���',
	"\x87\x6e" => '�͎ߎ�����',
	"\x87\x6f" => 'mm',
	"\x87\x70" => 'cm',
	"\x87\x71" => 'km',
	"\x87\x72" => 'mg',
	"\x87\x73" => 'kg',
	"\x87\x74" => 'cc',
	"\x87\x75" => 'm2',
	"\x87\x7e" => 'ʿ��',
	"\x87\x80" => '��',
	"\x87\x81" => '��',
	"\x87\x82" => 'No.',
	"\x87\x83" => 'K.K.',
	"\x87\x84" => 'TEL',
	"\x87\x85" => '�ʾ��',
	"\x87\x86" => '�����',
	"\x87\x87" => '�ʲ���',
	"\x87\x88" => '�ʺ���',
	"\x87\x89" => '�ʱ���',
	"\x87\x8a" => '�ʳ���',
	"\x87\x8b" => '��ͭ��',
	"\x87\x8c" => '�����',
	"\x87\x8d" => '����',
	"\x87\x8e" => '����',
	"\x87\x8f" => '����',
	"\x87\x90" => '��',
	"\x87\x91" => '��',
	"\x87\x92" => '��',  
	"\x87\x93" => 'c��',
	"\x87\x94" => '��',
	"\x87\x95" => '��',
	"\x87\x96" => '��',
	"\x87\x97" => '��',
	"\x87\x98" => '��',
	"\x87\x99" => '��',
	"\x87\x9a" => '��',
	"\x87\x9b" => '��',
	"\x87\x9c" => '��',
);
mb_convert_variables("Shift_Jis", "EUC-JP", $arr);
    return str_replace(array_keys($arr), array_values($arr), $str);
}

function removeSpace($str) {
	$arr = array(
		' ' => '',
		'��' => '');
	return str_replace(array_keys($arr), array_values($arr), $str);
}

// DB��³����
$conn = Db_Connect();
$create_day = date("Y-m-d");
/******************************/
// ��Ͽ����
/******************************/
$filepath =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client.csv';
$logfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client.log';
$errfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client_err.log';
$buffer = file_get_contents($filepath);
$buffer = mb_convert_encoding(replaceText($buffer), "eucJP-win", "SJIS-win");
//$buffer = mb_convert_encoding(replaceText($buffer), "eucJP", "SJIS");
$fp = tmpfile();
fwrite($fp, $buffer);
rewind($fp);

$i=0;
while (($line = fgetcsv($fp)) !== FALSE) {
    if($i == 0){
        // �����ȥ��
        $header = $line;
        $i++;
        continue;
    }
    $records[] = $line;

    $i++;
}

fclose($fp);
$arr_state = array(1=>'�����', 2=>'����');
$arr_area = array(1173=>'���ԻԳ�', 1174=>'���Ի���', 1175=>'���츩', 1176=>'�����');
$arr_btype = array(71=>'����¾');
$arr_trade_id = array(11=>'�����',21=>'�ݻ���',61=>'�������');
$arr_pay_m = array(0=>'Ʊ��', 1=>'���');
$arr_pay_d = array(29=>'����');
$arr_pay_way = array('1' => '��ư����', '2' => '����', '3' => 'ˬ�佸��', '4' => '���','5' => '����¾');
$record_count = 0;

for ($i=0; $i<count($records); $i++){
	//if (100 < $i) break;
	$d = $records[$i];
	$client_cd1 = $d[1];    // �����襳����
	$client_cd2 = $d[2];    // ��Ź������
	$shop_id = 173;         // FCID ����client_id
	$state = array_search($d[3], $arr_state);         // ����
	$client_name = mb_substr(removeSpace($d[4]), 0, 25, "euc-jp");   // ������̾
	$client_read = mb_substr(removeSpace($d[6]), 0, 50, "euc-jp");   // ������ʥեꥬ�ʡ�
	$client_name2 = mb_substr(removeSpace($d[5]), 0, 25, "euc-jp");  // ������̾2
	$client_read2 = mb_substr(removeSpace($d[7]), 0, 50, "euc-jp");  // ������2�ʥեꥬ�ʡ�
	$client_cname = mb_substr(removeSpace($d[8]), 0, 20, "euc-jp");  // ά��
	$post_no1 = $d[9];      // ͹���ֹ棱
	$post_no2 = $d[10];     // ͹���ֹ棲
	$address1 = mb_substr(removeSpace($d[11]), 0, 25, "euc-jp");     // ���꣱
	$address2 = mb_substr(removeSpace($d[12]), 0, 25, "euc-jp");     // ���ꣲ
	$address3 = '';         // ���ꣳ
	$address_read = mb_substr(removeSpace($d[13]), 0, 50, "euc-jp"); // ����ʥեꥬ�ʡ�
	$area_id = intval(array_search($d[14], $arr_area));      // �϶�ID
	$tel = $d[15];          // TEL
	$fax = $d[16];          // FAX
	$rep_name = $d[17];     // ��ɽ�Ի�̾
	$c_staff_id1 = '';      // ����ô����
	$c_staff_id2 = '';      // ����ô����
	$charger1 = $d[18];     // ��ô���ԣ�
	$charger2 = $d[19];     // ��ô���ԣ�
	$charger3 = $d[20];     // ��ô���ԣ�
	$charger_part1 = '';    // ��ô��������
	$charger_part2 = '';    // ��ô��������
	$charger_part3 = '';    // ��ô��������
	$charger_represe1 = ''; // ��ô�����򿦣�
	$charger_represe2 = ''; // ��ô�����򿦣�
	$charger_represe3 = ''; // ��ô�����򿦣�
	$charger_note = '';     // ��ô��������
	$trade_stime1 = ":";    // �ĶȻ��֡ʸ������ϡ�
	$trade_etime1 = ":";    // �ĶȻ��֡ʸ�����λ��
	$trade_stime2 = ":";    // �ĶȻ��֡ʸ�峫�ϡ�
	$trade_etime2 = ":";    // �ĶȻ��֡ʸ�彪λ��
	$btype = array_search($d[32], $arr_btype);       // �ȼ�ID
	$holiday = '';          // ����
	$close_day_cd = array_search($d[45], $arr_pay_d); // ����
	if (!$close_day_cd) $close_day_cd = str_replace("��", "", $d[45]);
	$trade_id = array_search($d[44], $arr_trade_id);     // �����ʬ
	$pay_m = array_search($d[46], $arr_pay_m);       // �������ʷ��
	$pay_d = array_search($d[47], $arr_pay_d);       // ������������
	if (!$pay_d) $pay_d = str_replace("��", "", $d[47]);
	$pay_way = array_search($d[48], $arr_pay_way);      // ��ʧ����ˡ
	$account_name = '';     // ����̾��
	$pay_name = '';         // ����̾��
	$bank_enter_cd = '';    // ���
	$slip_out = 2;     // ��ɼ����
	$deliver_note = '';     // Ǽ�ʽ񥳥���
	$claim_out = 1;    // ��������
	$coax = 2;         // ��ۡ��ݤ��ʬ
	$tax_div = 2;      // �����ǡ�����ñ��
	$tax_franct = 2;   // �����ǡ�ü��ñ��
	$cont_s_day = "--";     // ���󳫻���
	$cont_e_day = "--";     // ����λ��
	$cont_peri = "";        // �������
	$cont_r_day = "--";     // ���󹹿���
	$col_terms = '';        // ������
	$cledit_limit = '';     // Ϳ������
	$capital = '';          // ���ܶ�
	$note = $d[68];         // ����������/����¾
	$email = '';            // Email
	$url = '';              // URL
	$represent_cell = '';   // ��ɽ�Է���
	$direct_tel = '';       // ľ��TEL
	$bstruct = '';          // ����
	$inst ==  '';           // ����
	$establish_day = "--";  // �϶���
	$record = '';           // �������
	$important = '';        // ���׻���
	$trans_account = '';    // �����������̾
	$bank_fc = '';          // ���/��Ź̾
	$account_num = '';      // �����ֹ�
	$round_start = "--";    // ��󳫻���
	$deliver_radio = '';    // Ǽ�ʽ񥳥���(����
	$claim_send = 1;   // ���������
	$cname_read = '';       // ά��(�եꥬ��)
	$represe = '';          // ��ɽ����
	$company_name = '';     // �Ʋ��̾
	$company_tel = '';      // �Ʋ��TEL
	$company_address = '';  // �Ʋ�ҽ���
	$bank_div = '';
	$claim_note = '';
	$client_slip1 = '';
	$client_slip2 = '';
	$parent_establish_day = '--';  // �Ʋ���϶���
	$parent_rep_name = '';   // �Ʋ����ɽ��̾
	$compellation = '';      // �Ʋ����ɽ��̾
	$s_pattern_id = 'null';
	$c_pattern_id = 'null';
	$c_tax_div = 'null';
	$charge_branch_id = 'null';
	$parents_flg = 'false';
	$bill_address_font = 'false';
	// ������ޥ�������Ͽ
	//Db_Query($conn, "BEGIN;");
	$insert_sql  = " INSERT INTO t_client (";
	$insert_sql .= "    client_id,";                                        // ������ID
	$insert_sql .= "    client_cd1,";                                       // �����襳����
	$insert_sql .= "    client_cd2,";                                       // ��Ź������
	$insert_sql .= "    shop_id,";                                          // FCID
	$insert_sql .= "    create_day,";                                       // ������
	$insert_sql .= "    state,";                                            // ����
	$insert_sql .= "    client_name,";                                      // ������̾
	$insert_sql .= "    client_read,";                                      // ������̾�ʥեꥬ�ʡ�
	$insert_sql .= "    client_name2,";                                     // ������̾2
	$insert_sql .= "    client_read2,";                                     // ������̾2�ʥեꥬ�ʡ�
	$insert_sql .= "    client_cname,";                                     // ά��
	$insert_sql .= "    post_no1,";                                         // ͹���ֹ棱
	$insert_sql .= "    post_no2,";                                         // ͹���ֹ棲
	$insert_sql .= "    address1,";                                         // ���꣱
	$insert_sql .= "    address2,";                                         // ���ꣲ
	$insert_sql .= "    address3,";                                         // ���ꣳ
	$insert_sql .= "    address_read,";                                     // ����ʥեꥬ�ʡ�
	$insert_sql .= "    area_id,";                                          // �϶�ID
	$insert_sql .= "    tel,";                                              // tel
	$insert_sql .= "    fax,";                                              // fax
	$insert_sql .= "    rep_name,";                                         // ��ɽ�Ի�̾
	$insert_sql .= "    c_staff_id1,";                                      // ����ô����
	$insert_sql .= "    c_staff_id2,";                                      // ����ô����
	$insert_sql .= "    charger1,";                                         // ��ô���ԣ�
	$insert_sql .= "    charger2,";                                         // ��ô���ԣ�
	$insert_sql .= "    charger3,";                                         // ��ô���ԣ�
	$insert_sql .= "    charger_part1,";                                    // ��ô��������
	$insert_sql .= "    charger_part2,";                                    // ��ô��������
	$insert_sql .= "    charger_part3,";                                    // ��ô��������
	$insert_sql .= "    charger_represe1,";                                 // ��ô��������
	$insert_sql .= "    charger_represe2,";                                 // ��ô��������
	$insert_sql .= "    charger_represe3,";                                 // ��ô��������
	$insert_sql .= "    charger_note,";                                     // ��ô��������
	$insert_sql .= "    trade_stime1,";                                     // �ĶȻ��֡ʸ������ϡ�
	$insert_sql .= "    trade_etime1,";                                     // �ĶȻ��֡ʸ�����λ��
	$insert_sql .= "    trade_stime2,";                                     // �ĶȻ��֡ʸ�峫�ϡ�
	$insert_sql .= "    trade_etime2,";                                     // �ĶȻ��֡ʸ�彪λ��
	$insert_sql .= "    sbtype_id,";                                        // �ȼ�ID
	$insert_sql .= "    holiday,";                                          // ����
	$insert_sql .= "    close_day,";                                        // ����
	$insert_sql .= "    trade_id,";                                          // �����ʬ
	$insert_sql .= "    pay_m,";                                            // �������ʷ��
	$insert_sql .= "    pay_d,";                                            // ������������
	$insert_sql .= "    pay_way,";                                          // ������ˡ
	$insert_sql .= "    account_name,";                                     // ����̾��
	$insert_sql .= "    pay_name,";                                         // ����̾��
	$insert_sql .= "    account_id,";                                       //�����ֹ�ID
	$insert_sql .= "    slip_out,";                                         // ��ɼ����
	$insert_sql .= "    deliver_note,";                                     // Ǽ�ʽ񥳥���
	$insert_sql .= "    claim_out,";                                        // ��������
	$insert_sql .= "    coax,";                                             // ��ۡ��ݤ��ʬ
	$insert_sql .= "    tax_div,";                                          // �����ǡ�����ñ��
	$insert_sql .= "    tax_franct,";                                       // �����ǡ�ü����ʬ
	$insert_sql .= "    cont_sday,";                                        // ���󳫻���
	$insert_sql .= "    cont_eday,";                                        // ����λ��
	$insert_sql .= "    cont_peri,";                                        // �������
	$insert_sql .= "    cont_rday,";                                        // ���󹹿���
	$insert_sql .= "    col_terms,";                                        // ������
	$insert_sql .= "    credit_limit,";                                     // Ϳ������
	$insert_sql .= "    capital,";                                          // ���ܶ�
	$insert_sql .= "    note,";                                             // ����������/����¾
	$insert_sql .= "    client_div,";                                       // �������ʬ
	$insert_sql .= "    email,";                                            // Email
	$insert_sql .= "    url,";                                              // URL
	$insert_sql .= "    rep_htel,";                                         // ��ɽ�Է���
	$insert_sql .= "    direct_tel,";                                       // ľ��TEL
	$insert_sql .= "    b_struct,";                                         // ����
	$insert_sql .= "    inst_id,";                                          // ����
	$insert_sql .= "    establish_day,";                                    // �϶���
	$insert_sql .= "    deal_history,";                                     // �������
	$insert_sql .= "    importance,";                                       // ���׻���
	$insert_sql .= "    intro_ac_name,";                                    // �����������̾
	$insert_sql .= "    intro_bank,";                                       // ���/��Ź̾
	$insert_sql .= "    intro_ac_num,";                                     // �����ֹ�
	$insert_sql .= "    round_day,";                                        // ��󳫻���
	$insert_sql .= "    deliver_effect,";                                   // Ǽ�ʽ񥳥���(����)
	$insert_sql .= "    claim_send,";                                       // ���������
	$insert_sql .= "    client_cread,";                                     // ά��(�եꥬ��)
	$insert_sql .= "    represe,";                                          // ��ɽ����
	$insert_sql .= "    shop_name,";
	$insert_sql .= "    shop_div,";
	$insert_sql .= "    royalty_rate,";
	$insert_sql .= "    company_name,";                                     // �Ʋ��̾
	$insert_sql .= "    company_tel,";                                      // �Ʋ��TEL
	$insert_sql .= "    company_address,";                                  // �Ʋ�ҽ���
	$insert_sql .= "    bank_div,";                                         // ��Լ������ô��ʬ
	$insert_sql .= "    claim_note,";                                       // ����񥳥���
	$insert_sql .= "    client_slip1,";                                     // �����裱��ɼ����
	$insert_sql .= "    client_slip2,";                                     // �����裲��ɼ����
	$insert_sql .= "    parent_establish_day,";                             // �Ʋ���϶���
	$insert_sql .= "    parent_rep_name,";
	$insert_sql .= "    compellation,";                                     // �ɾ�
	$insert_sql .= "    s_pattern_id, ";                                    //�����ɼȯ�ԥѥ�����
	$insert_sql .= "    c_pattern_id, ";                                    //�����ȯ�ԥѥ�����
	$insert_sql .= "    c_tax_div,";                                         //���Ƕ�ʬi
	$insert_sql .= "    charge_branch_id,";                                         //ô����Ź
	$insert_sql .= "    parents_flg, ";                                     //�ƻҥե饰
	$insert_sql .= "    bill_address_font ";                                //�������ե����
	$insert_sql .= " )VALUES(";
	$insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
	$insert_sql .= "    '$client_cd1',";                                    // �����襳����
	$insert_sql .= "    '$client_cd2',";                                    // ��Ź������
	$insert_sql .= "    $shop_id,";                                         // FCID
	$insert_sql .= "    NOW(),";                                            // ������
	$insert_sql .= "    '$state',";                                         // ����
	$insert_sql .= "    '$client_name',";                                   // ������̾
	$insert_sql .= "    '$client_read',";                                   // ������ʥեꥬ�ʡ�
	$insert_sql .= "    '$client_name2',";                                  // ������̾2
	$insert_sql .= "    '$client_read2',";                                  // ������2�ʥեꥬ�ʡ�
	$insert_sql .= "    '$client_cname',";                                  // ά��
	$insert_sql .= "    '$post_no1',";                                      // ͹���ֹ棱
	$insert_sql .= "    '$post_no2',";                                      // ͹���ֹ棲
	$insert_sql .= "    '$address1',";                                      // ���꣱
	$insert_sql .= "    '$address2',";                                      // ���ꣲ
	$insert_sql .= "    '$address3',";                                      // ���ꣳ
	$insert_sql .= "    '$address_read',";                                  // ����ʥեꥬ�ʡ�
	$insert_sql .= "    $area_id,";                                         // �϶�ID
	$insert_sql .= "    '$tel',";                                           // TEL
	$insert_sql .= "    '$fax',";                                           // FAX
	$insert_sql .= "    '$rep_name',";                                      // ��ɽ�Ի�̾
	$insert_sql .= ($c_staff_id1 == "") ? " null, " : "$c_staff_id1, ";     // ����ô����
	$insert_sql .= ($c_staff_id2 == "") ? " null, " : "$c_staff_id2, ";     // ����ô����
	$insert_sql .= "    '$charger1',";                                      // ��ô���ԣ�
	$insert_sql .= "    '$charger2',";                                      // ��ô���ԣ�
	$insert_sql .= "    '$charger3',";                                      // ��ô���ԣ�
	$insert_sql .= "    '$charger_part1',";                                 // ��ô��������
	$insert_sql .= "    '$charger_part2',";                                 // ��ô��������
	$insert_sql .= "    '$charger_part3',";                                 // ��ô��������
	$insert_sql .= "    '$charger_represe1',";                              // ��ô�����򿦣�
	$insert_sql .= "    '$charger_represe2',";                              // ��ô�����򿦣�
	$insert_sql .= "    '$charger_represe3',";                              // ��ô�����򿦣�
	$insert_sql .= "    '$charger_note',";                                  // ��ô��������
	$insert_sql .= ($trade_stime1 == ":") ? " null, " : " '$trade_stime1', ";   // �ĶȻ��֡ʸ������ϡ�
	$insert_sql .= ($trade_etime1 == ":") ? " null, " : " '$trade_etime1', ";   // �ĶȻ��֡ʸ�����λ��
	$insert_sql .= ($trade_stime2 == ":") ? " null, " : " '$trade_stime2', ";   // �ĶȻ��֡ʸ�峫�ϡ�
	$insert_sql .= ($trade_etime2 == ":") ? " null, " : " '$trade_etime2', ";   // �ĶȻ��֡ʸ�彪λ��
	$insert_sql .= ($btype == "") ? " null, " : " $btype, ";                // �ȼ�ID
	$insert_sql .= "    '$holiday',";                                       // ����
	$insert_sql .= "    '$close_day_cd',";                                  // ����
	$insert_sql .= "    '$trade_id',";                                      // �����ʬ
	$insert_sql .= ($pay_m == "") ? " null, " : " $pay_m, ";                // �������ʷ��
	$insert_sql .= ($pay_d == "") ? " null, " : " $pay_d, ";                // ������������
	$insert_sql .= "    '$pay_way',";                                       // ��ʧ����ˡ
	$insert_sql .= "    '$account_name',";                                  // ����̾��
	$insert_sql .= "    '$pay_name',";                                      // ����̾��
	$insert_sql .= ($bank_enter_cd == "") ? " null, " : " $bank_enter_cd, ";// ���
	$insert_sql .= "    '$slip_out',";                                      // ��ɼ����
	$insert_sql .= "    '$deliver_note',";                                  // Ǽ�ʽ񥳥���
	$insert_sql .= "    '$claim_out',";                                     // ��������
	$insert_sql .= "    '$coax',";                                          // ��ۡ��ݤ��ʬ
	$insert_sql .= "    '$tax_div',";                                       // �����ǡ�����ñ��
	$insert_sql .= "    '$tax_franct',";                                    // �����ǡ�ü��ñ��
	$insert_sql .= ($cont_s_day == "--") ? " null, " : " '$cont_s_day', ";  // ���󳫻���
	$insert_sql .= ($cont_e_day == "--") ? " null, " : " '$cont_e_day', ";  // ����λ��
	$insert_sql .= ($cont_peri == "") ? " null, " : " '$cont_peri', ";      // �������
	$insert_sql .= ($cont_r_day == "--") ? " null, " : " '$cont_r_day', ";  // ���󹹿���
	$insert_sql .= "    '$col_terms',";                                     // ������
	$insert_sql .= "    '$cledit_limit',";                                  // Ϳ������
	$insert_sql .= "    '$capital',";                                       // ���ܶ�
	$insert_sql .= "    '$note',";                                          // ����������/����¾
	$insert_sql .= "    '1',";                                              // �������ʬ
	$insert_sql .= "    '$email',";                                         // Email
	$insert_sql .= "    '$url',";                                           // URL
	$insert_sql .= "    '$represent_cell',";                                // ��ɽ�Է���
	$insert_sql .= "    '$direct_tel',";                                    // ľ��TEL
	$insert_sql .= ($bstruct == "") ? " null, " : " '$bstruct', ";          // ����
	$insert_sql .= ($inst == "") ? " null, " : " $inst, ";                  // ����
	$insert_sql .= ($establish_day == "--") ? " null, " : " '$establish_day', ";    // �϶���
	$insert_sql .= "    '$record',";                                        // �������
	$insert_sql .= "    '$important',";                                     // ���׻���
	$insert_sql .= "    '$trans_account',";                                 // �����������̾
	$insert_sql .= "    '$bank_fc',";                                       // ���/��Ź̾
	$insert_sql .= "    '$account_num',";                                   // �����ֹ�
	$insert_sql .= ($round_start == "--") ? " null, " : " '$round_start', ";// ��󳫻���
	$insert_sql .= "    '$deliver_radio',";                                 // Ǽ�ʽ񥳥���(����
	$insert_sql .= "    '$claim_send',";                                    // ���������
	$insert_sql .= "    '$cname_read',";                                    // ά��(�եꥬ��)
	$insert_sql .= "    '$represe',";                                       // ��ɽ����
	$insert_sql .= "    '',";
	$insert_sql .= "    '',";
	$insert_sql .= "    '',";
	$insert_sql .= "    '$company_name',";                                  // �Ʋ��̾
	$insert_sql .= "    '$company_tel',";                                   // �Ʋ��TEL
	$insert_sql .= "    '$company_address',";                               // �Ʋ�ҽ���
	$insert_sql .= "    '$bank_div',";
	$insert_sql .= "    '$claim_note',";
	$insert_sql .= "    '$client_slip1',";
	$insert_sql .= "    '$client_slip2',";
	$insert_sql .= ($parent_establish_day != '--') ? " '$parent_establish_day', " : " null, ";  // �Ʋ���϶���
	$insert_sql .= "    '$parent_rep_name',";                               // �Ʋ����ɽ��̾
	$insert_sql .= "    '$compellation',";                                   // �Ʋ����ɽ��̾
	$insert_sql .= "    $s_pattern_id,";
	$insert_sql .= "    $c_pattern_id,";
	$insert_sql .= "    $c_tax_div,";
	$insert_sql .= "    $charge_branch_id,";
	$insert_sql .= "    $parents_flg, \n";
	$insert_sql .= "    $bill_address_font \n";
	$insert_sql .= ");";
	$result = Db_Query($conn, $insert_sql);
	if($result === false){
		$err = "$record_count $client_id $client_cd1\n $insert_sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
		continue;
	    //Db_Query($conn, "ROLLBACK;");
	    //exit;
	}

	//��Ͽ�����������������ID�����
	$sql  = "SELECT";
	$sql .= "   client_id ";
	$sql .= "FROM";
	$sql .= "   t_client ";
	$sql .= "WHERE";
	$sql .= "   client_div = '1'";
	$sql .= "   AND";
	$sql .= "   shop_id = $shop_id";
	$sql .= "   AND";
	$sql .= "   client_cd1 = '$client_cd1'";
	$sql .= "   AND";
	$sql .= "   client_cd2 = '$client_cd2'";
	$sql .= ";";
	
	$result = Db_Query($conn, $sql);
	$client_id = pg_fetch_result($result, 0,0);
	
	// ��������
	$sql  = "INSERT INTO t_claim(";
	$sql .= "   client_id,";
	$sql .= "   claim_id,";
	$sql .= "   claim_div, ";
	$sql .= "   month1_flg,";
	$sql .= "   month2_flg,";
	$sql .= "   month3_flg,";
	$sql .= "   month4_flg,";
	$sql .= "   month5_flg,";
	$sql .= "   month6_flg,";
	$sql .= "   month7_flg,";
	$sql .= "   month8_flg,";
	$sql .= "   month9_flg,";
	$sql .= "   month10_flg,";
	$sql .= "   month11_flg,";
	$sql .= "   month12_flg ";
	$sql .= ")VALUES(";
	$sql .= "   $client_id,";
	// �������裱���ϻ�
	if($claim_flg == true){
	    $sql .= "   (SELECT";
	    $sql .= "       client_id";
	    $sql .= "   FROM";
	    $sql .= "       t_client";
	    $sql .= "   WHERE";
	    $sql .= "       client_div = '1'";
	    $sql .= "       AND";
	    //$sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = '$claim_cd1'";
	    $sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
	    $sql .= "       AND";
	    $sql .= "       client_cd1 = '$claim_cd1'";
	    $sql .= "       AND";
	    $sql .= "       client_cd2 = '$claim_cd2'";
	    $sql .= "   ),";
	// �������裱̤���ϻ�
	}else{
	    $sql .= "   $client_id,";
	}
	$sql .= "   '1', ";
	$sql .= ($claim1_monthly_check[0]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[1]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[2]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[3]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[4]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[5]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[6]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[7]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[8]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[9]  == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[10] == '1')?  " 't'," : " 'f',";
	$sql .= ($claim1_monthly_check[11] == '1')?  " 't' " : " 'f' ";
	
	$sql .= ");";
	
	
	$result = Db_Query($conn, $sql);
	if($result === false){
		$err = "$record_count $client_id $client_cd1\n $sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
	    //Db_Query($conn, "ROLLBACK;");
	    //exit;
	}
	$record_count++;
	$msg = "$record_count $client_id $client_cd1 inserted OK.\n";
	file_put_contents($logfile, $msg, FILE_APPEND | LOCK_EX);
	print "$msg<br />";

}
	print "$record_count records were inserted.<br />";
?>

