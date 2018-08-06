<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0082    suzuki      ��Ͽ���ѹ��Υ�����Ĥ��褦�˽���
 *  2007-04-24                  watanabe-k  �����ֹ�η�����å���6�夫7��˽���
 *  2007-05-09                  kaku-m      csv����̾�ν���
 *  2010-04-28      Rev.1.5���� hashimoto-y ��ɽ����ǽ���ɲ�
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 *
*/

$page_title = "��ԥޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
 $auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
 $auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
 $disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$update_flg = $_POST["update_flg"];
$update_id  = $_POST["update_id"];

/* GET����ID�������������å� */
$where  = " b_bank_id IN (SELECT b_bank_id FROM t_b_bank WHERE bank_id IN (SELECT bank_id FROM t_bank WHERE ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
$where .= ")) ";
if ($_GET["account_id"] != null && Get_Id_Check_Db($db_con, $_GET["account_id"], "account_id", "t_account", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
// �ե�������������
/****************************/
$def_fdata["form_deposit_kind"] = "1";
$form->setDefaults($def_fdata);


/****************************/
// �ե�����ѡ������
/****************************/
// ��ԡ���Ź
$sql  = "SELECT ";
$sql .= "   t_bank.bank_id, ";
$sql .= "   t_bank.bank_cd, ";
$sql .= "   t_bank.bank_name, ";
$sql .= "   t_b_bank.b_bank_id, ";
$sql .= "   t_b_bank.b_bank_cd, ";
$sql .= "   t_b_bank.b_bank_name ";
$sql .= "FROM ";
$sql .= "   t_bank ";
$sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $shop_id ";
$sql .= "ORDER BY ";
$sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
// hierselect���������
$ary_hier1[null] = null;
$ary_hier2       = null;
if ($num > 0){
    for ($i=0; $i<$num; $i++){
        // �ǡ��������ʥ쥳�������
        $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
        // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
        $hier1_id = $data_list[$i]["bank_id"];
        $hier2_id = $data_list[$i]["b_bank_id"];
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
            // ��1����
            $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]."��".$data_list[$i]["bank_name"];
        }
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ�
        // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
            // ��2���إ��쥯�ȥ����ƥ�κǽ��NULL�������
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                $ary_hier2[$hier1_id][null] = null;
            }
            // ��2����
            $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]."��".$data_list[$i]["b_bank_name"];
        }   
    }
    // 1�Ĥ�����ˤޤȤ��
    $ary_hier_item = array($ary_hier1, $ary_hier2);
}
$html = "</td></tr><tr><td class=\"Title_Purple\"><b>��Ź̾<font color=\"#ff0000\">��</font></b></td><td class=\"Value\">";
$obj_genre_select = &$form->addElement("hierselect", "form_bank_b_bank", "", "", $html);
$obj_genre_select->setOptions($ary_hier_item);

// �¶����
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "����", "1");
$radio[] =& $form->createElement("radio", null, null, "����", "2");
$form->addGroup($radio, "form_deposit_kind", "");

// �����ֹ�
$form->addElement("text", "form_account_no", "", "size=\"8\" maxlength=\"7\" style=\"$g_form_style\" $g_form_option");

// ����̾
$form->addElement("text", "form_account_identifier", "", "size=\"50\" maxlength=\"40\" $g_form_option");

// ����̾��
$form->addElement("text", "form_account_holder", "", "size=\"50\" maxlength=\"40\" $g_form_option");

#2010-04-28 hashimoto-y
$form->addElement('checkbox', 'form_nondisp_flg', '', '');

// ����
$form->addElement("text", "form_note", "", "size=\"34\" maxlength=\"30\" $g_form_option");

// ��Ͽ
$form->addElement("submit", "form_entry_btn", "�С�Ͽ", "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");

// ���ꥢ
$form->addElement("button", "form_clear_btn", "���ꥢ", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// CSV����
$form->addElement("button", "form_csv_btn", "CSV����", "onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

// �إå����ܥ���
$form->addElement("button", "bank_button", "�����Ͽ����", "onClick=\"javascript:Referer('2-1-207.php')\"");
$form->addElement("button", "bank_mine_button", "��Ź��Ͽ����", "onClick=\"javascript:Referer('2-1-208.php')\"");
$form->addElement("button", "bank_account_button", "������Ͽ����", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// hidden
$form->addElement("hidden", "hdn_bank_select_flg", null, null); // �������ե饰
$form->addElement("hidden", "update_flg", null, null);          // ������󥯲���Ƚ��ե饰
$form->addElement("hidden", "update_id", null, null);           // �����о�ID
$form->addElement("hidden", "csv_button_flg", null, null);      // CSV���ϥܥ��󲡲��ե饰


/****************************/
// CSV���ϥܥ��󲡲�����
/****************************/
// CSV���ϥܥ��󤬲������줿���
if ($_POST["csv_button_flg"] == true){

    // CSV�ѥǡ�������SQL
    $sql  = "SELECT ";
    $sql .= "   t_bank.bank_cd, ";
    $sql .= "   t_bank.bank_name, ";
    $sql .= "   t_bank.bank_cname, ";
    $sql .= "   t_b_bank.b_bank_cd, ";
    $sql .= "   t_b_bank.b_bank_name, ";
    $sql .= "   CASE t_account.deposit_kind ";
    $sql .= "       WHEN '1' THEN '����' ";
    $sql .= "       WHEN '2' THEN '����' ";
    $sql .= "   END, ";
    $sql .= "   t_account.account_no, ";
    $sql .= "   t_account.account_identifier, ";
    $sql .= "   t_account.account_holder, ";
    #2010-04-28 hashimoto-y
    $sql .= "   CASE t_account.nondisp_flg";
    $sql .= "   WHEN true  THEN '��'";
    $sql .= "   WHEN false THEN ''";
    $sql .= "   END,";

    $sql .= "   t_account.note ";
    $sql .= "FROM ";
    $sql .= "   t_account ";
    $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // CSV�ѥǡ�������
    $i = 0;
    while ($data_list = pg_fetch_array($res)){
        $account_data[$i][0] = $data_list[0];
        $account_data[$i][1] = $data_list[1];
        $account_data[$i][2] = $data_list[2];
        $account_data[$i][3] = $data_list[3];
        $account_data[$i][4] = $data_list[4];
        $account_data[$i][5] = $data_list[5];
        $account_data[$i][6] = $data_list[6];
        $account_data[$i][7] = $data_list[7];
        $account_data[$i][8] = $data_list[8];
        #2010-04-28 hashimoto-y
        #$account_data[$i][9] = $data_list[9];
        $account_data[$i][9] = $data_list[9];
        $account_data[$i][10] = $data_list[10];
        $i++;
    }

    // CSV�ܥ��󲡲��ե饰�򥯥ꥢ
    $clear_flg["csv_button_flg"] = "";
    $form->setConstants($clear_flg);

    // CSV�ե�����̾
    $csv_file_name = "���¥ޥ���".date("Ymd").".csv";

    // CSV�إå�����
    $csv_header = array(
        "��ԥ�����",
        "���̾",
        "���̾��ά�Ρ�",
        "��Ź������",
        "��Ź̾",
        "�¶����",
        "�����ֹ�",
        "����̾",
        "����̾��",
        #2010-04-28 hashimoto-y
        "��ɽ��",
        "����",
    );

    // CSV�ե��������
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($account_data, $csv_header);

    // ����
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;

    // ��λ
    exit;
}


/****************************/
// �ѹ����Υե������䴰
/****************************/
// �ѹ���󥯤���������Ƥ�����
if($_GET["account_id"] != null && $_POST["form_entry_btn"] == null){

    // GET�����ѹ��о�ID���ѿ�������
    $update_id = $_GET["account_id"];

    $sql  = "SELECT ";
    $sql .= "   t_bank.bank_id, ";
    $sql .= "   t_b_bank.b_bank_id, ";
    $sql .= "   t_account.deposit_kind, ";
    $sql .= "   t_account.account_no, ";
    $sql .= "   t_account.account_identifier, ";
    $sql .= "   t_account.account_holder, ";

    #2010-04-28 hashimoto-y
    $sql .= "   t_account.nondisp_flg,";

    $sql .= "   t_account.note ";
    $sql .= "FROM ";
    $sql .= "   t_account ";
    $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "WHERE ";
    $sql .= "   t_account.account_id = $update_id ";
    $sql .= "AND ";
    $sql .= ($group_kind == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    // GET�ǡ���Ƚ��
    Get_Id_Check($res);
    $data_list = pg_fetch_array($res, 0);

    // �ե�������ͤ�����
    $def_fdata["form_bank_b_bank"][0]       = $data_list[0];
    $def_fdata["form_bank_b_bank"][1]       = $data_list[1];
    $def_fdata["form_deposit_kind"]         = $data_list[2];
    $def_fdata["form_account_no"]           = $data_list[3];
    $def_fdata["form_account_identifier"]   = $data_list[4];
    $def_fdata["form_account_holder"]       = $data_list[5];
    #2010-04-28 hashimoto-y
    #$def_fdata["form_note"]                 = $data_list[6];
    $def_fdata["form_nondisp_flg"]          = ($data_list[6] == 't')? 1 : 0;
    $def_fdata["form_note"]                 = $data_list[7];
    $def_fdata["update_flg"]                = true; 
    $def_fdata["update_id"]                 = $update_id; 
    $form->setConstants($def_fdata);

}


/****************************/
// ���顼�����å�(AddRule)
/****************************/
// �����̾����Ź̾
// ɬ�ܥ����å�
$err_msg = "���̾ �� ��Ź̾ ��ɬ�ܤǤ���";
$form->addGroupRule("form_bank_b_bank", array(
    "0" => array(array($err_msg, "required")),      
    "1" => array(array($err_msg, "required")),
));

// �������ֹ�
// ɬ�ܥ����å�
$form->addRule("form_account_no", "�����ֹ� ��ɬ�ܹ��ܤǤ���", "required");
// ���ͥ����å�
$form->addRule("form_account_no", "�����ֹ� ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

// ������̾
// ɬ�ܥ����å�
$form->addRule("form_account_identifier", "����̾ ��ɬ�ܹ��ܤǤ���", "required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_account_identifier", "����̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

// ������̾��
// ɬ�ܥ����å�
$form->addRule("form_account_holder", "����̾�� ��ɬ�ܹ��ܤǤ���", "required");
$form->addRule("form_account_holder", "����̾�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");


/****************************/
// ��Ͽ�ܥ��󲡲����ν���
/****************************/
if($_POST["form_entry_btn"] == "�С�Ͽ"){

    // validate
    $form->validate();

    /*** ��̽��� ***/
    // ���顼�Τ���ե�����Υե�����̾���Ǽ���뤿�����������
    $ary_rule_err_forms = array();
    // ���顼�Τ���ե�����Υե�����̾������˳�Ǽ
    foreach ($form as $key1 => $value1){
        if ($key1 == "_errors"){
            foreach ($value1 as $key2 => $value2){
                $ary_rule_err_forms[] = $key2;
            }       
        }       
    }

    // POST�ǡ������ѿ��˥��å�
    $post_bank_id               = $_POST["form_bank_b_bank"][0];
    $post_b_bank_id             = $_POST["form_bank_b_bank"][1];
    $post_deposit_kind          = $_POST["form_deposit_kind"];
    $post_account_no            = $_POST["form_account_no"];
    $post_account_identifier    = $_POST["form_account_identifier"];
    $post_account_holder        = $_POST["form_account_holder"];

    #2010-04-28 hashimoto-y
    $nondisp_flg                = ($_POST["form_nondisp_flg"] == '1')? 't' : 'f';

    $post_note                  = $_POST["form_note"];
    $update_flg                 = $_POST["update_flg"];
    $update_id                  = $_POST["update_id"];

    /****************************/
    // ���顼�����å�(PHP)
    /****************************/
    // �������ֹ�
    // ����ʣ�����å�
    if(!in_array("form_bank_b_bank", $ary_rule_err_forms) &&
       !in_array("form_account_no", $ary_rule_err_forms))
    {

        // 0���
//        $post_account_no = str_pad($post_account_no, 7, 0, STR_POS_LEFT);

        // ���Ϥ��������ֹ椬�ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "   t_account.account_no "; 
        $sql .= "FROM ";
        $sql .= "   t_account ";
        $sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
        $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
        $sql .= "WHERE ";
        $sql .= "   t_b_bank.b_bank_id = $post_b_bank_id ";
        $sql .= "AND ";
        $sql .= "   t_account.account_no = '$post_account_no' ";
        $sql .= "AND ";
        $sql .= ($group_kind == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $shop_id ";
        // �ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($update_id != null){
            $sql .= "AND NOT ";
            $sql .= "   t_account.account_id = '$update_id'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_account_no", "���˻��Ѥ���Ƥ��� �����ֹ� �Ǥ���");
        }
    }

    // ���顼�κݤˤϡ���Ͽ������Ԥ�ʤ�
    if($form->validate()){
        
        Db_Query($db_con, "BEGIN;");

        // ��������Ͽ��Ƚ��
        if($update_id != null){
            // ��ȶ�ʬ�Ϲ���
            $work_div = '2';
            // �ѹ���λ��å�����
            $comp_msg = "�ѹ����ޤ�����";

            $sql  = "UPDATE ";
            $sql .= "   t_account ";
            $sql .= "SET ";
            $sql .= "   b_bank_id = $post_b_bank_id, ";
            $sql .= "   deposit_kind = '$post_deposit_kind', ";
            $sql .= "   account_no = '$post_account_no', ";
            $sql .= "   account_identifier = '$post_account_identifier', ";
            $sql .= "   account_holder = '$post_account_holder', ";
            #2010-04-28 hashimoto-y
            $sql .= "   nondisp_flg = '$nondisp_flg',";
            $sql .= "   note = '$post_note' ";
            $sql .= "WHERE ";
            $sql .= "   t_account.account_id = $update_id ";
            $sql .= ";";
        }else{
            // ��ȶ�ʬ����Ͽ
            $work_div = '1';
            // ��Ͽ��λ��å�����
            $comp_msg = "��Ͽ���ޤ�����";

            $sql  = "INSERT INTO t_account ";
            $sql .= "(";
            $sql .= "   account_id, ";
            $sql .= "   b_bank_id, ";
            $sql .= "   deposit_kind, ";
            $sql .= "   account_no, ";
            $sql .= "   account_identifier, ";
            $sql .= "   account_holder, ";
            #2010-04-28 hashimoto-y
            $sql .= "   nondisp_flg,";
            $sql .= "   note ";
            $sql .= ") ";
            $sql .= "VALUES ";
            $sql .= "( ";
            $sql .= "   (SELECT COALESCE(MAX(account_id), 0)+1 FROM t_account), ";
            $sql .= "   $post_b_bank_id, ";
            $sql .= "   '$post_deposit_kind', ";
            $sql .= "   '$post_account_no', ";
            $sql .= "   '$post_account_identifier', ";
            $sql .= "   '$post_account_holder', ";
            #2010-04-28 hashimoto-y
            $sql .= "   '$nondisp_flg',";
            $sql .= "   '$post_note' ";
            $sql .= ") ";
            $sql .= ";";
        }

        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }

        // ��ԥޥ������ͤ�����˽񤭹���
        $result = Log_Save($db_con, "account", $work_div, $post_account_no,$post_account_identifier);
        // ������Ͽ���˥��顼�ˤʤä����
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }

        Db_Query($db_con, "COMMIT;");

        // �ե�������ͤ�����
        $def_fdata["form_bank_b_bank"][0]       = "";
        $def_fdata["form_bank_b_bank"][1]       = "";
        $def_fdata["form_deposit_kind"]         = "1"; // def��
        $def_fdata["form_account_no"]           = "";
        $def_fdata["form_account_identifier"]   = "";
        $def_fdata["form_account_holder"]       = "";
        #2010-04-28 hashimoto-y
        $def_fdata["form_nondisp_flg"]          = "";
        $def_fdata["form_note"]                 = "";
        $def_fdata["update_flg"]                = "";
        $def_fdata["update_id"]                 = "";
        $form->setConstants($def_fdata);
    }
}

/****************************/
// �إå�����ɽ�������������
/****************************/
/** ��ԥޥ�������SQL���� **/
$sql  = "SELECT ";
$sql .= "   t_bank.bank_cd, ";
$sql .= "   t_bank.bank_name, ";
$sql .= "   t_bank.bank_cname, ";
$sql .= "   t_b_bank.b_bank_cd, ";
$sql .= "   t_b_bank.b_bank_name, ";
$sql .= "   t_account.account_id, ";
$sql .= "   CASE t_account.deposit_kind ";
$sql .= "       WHEN '1' THEN '����' ";
$sql .= "       WHEN '2' THEN '����' ";
$sql .= "   END, ";
$sql .= "   t_account.account_no, ";
$sql .= "   t_account.account_identifier, ";
$sql .= "   t_account.account_holder, ";
#2010-04-28 hashimoto-y
$sql .= "   CASE t_account.nondisp_flg";
$sql .= "   WHEN true  THEN '��'";
$sql .= "   WHEN false THEN ''";
$sql .= "   END,";

$sql .= "   t_account.note ";
$sql .= "FROM ";
$sql .= "   t_account ";
$sql .= "   LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
$sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $shop_id ";
$sql .= "ORDER BY ";
$sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);

// ����������ʥإå��ؤη��ɽ���ѡ�
$total_count = pg_num_rows($res);

// �ԥǡ������ʤ����
$row = Get_Data($res);

// Ʊ���ͤ�³������null�������ʶ�ԡ���Ź�ξ���Τߡ�
for ($i=0; $i<$total_count; $i++){
    for ($j=0; $j<$total_count; $j++){
        if ($i != $j && $row[$i][0] == $row[$j][0]){
            $row[$j][0] = null;
            $row[$j][1] = null;
            $row[$j][2] = null;
            if ($row[$i][3] == $row[$j][3]){
                $row[$j][3] = null;
                $row[$j][4] = null;
            }
        }
    }
}

// �Կ�css����
for ($i=0; $i<$total_count; $i++){
    if($row[$i][0] == null){
        $tr[$i] = $tr[$i-1];
    }else{  
        $tr[$i] = ($tr[$i-1] == "Result1") ? "Result2" :  "Result1";
    }
}


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
$page_menu = Create_Menu_f("system", "1");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_mine_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_account_button]]->toHtml();

$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "total_count"   => "$total_count",
    "comp_msg"      => "$comp_msg",
    "auth_r_msg"    => "$auth_r_msg",
));
$smarty->assign('row',$row);
$smarty->assign('tr',$tr);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>