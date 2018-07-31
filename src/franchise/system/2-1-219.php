<?php
/************************************
// �ѹ�����
//  (04/20)
//  ���ꣳ��ľ���裲����Ͽ�����ɲ�(watanabe-k)
//  (08/22)
//  ���åץǡ��Ȼ���shop_id�ξ�������watanabe-k��
/***********************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/25��0103�������� watanabe-k�� GET�����å��ɲ�
 * ��2006/11/25��0102�������� watanabe-k�� ľ����̾�˶�������å��ɲ�
*  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */


$page_title = "ľ����ޥ���";

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
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$direct_id     = $_GET["direct_id"];
//$direct_permit = $_SESSION["direct_permit"]; //ľ����

/****************************/
//�ǥե����������
/****************************/
//��Ͽ���ѹ�Ƚ��
if($direct_id != null){

    Get_Id_Check3($direct_id);

    /** �ѹ��ǡ�������SQL **/
    $sql = "SELECT ";
    $sql .= "direct_cd,";                //ľ���襳����
    $sql .= "direct_name,";              //ľ����̾
    $sql .= "direct_cname,";             //ά��
    $sql .= "t_direct.post_no1,";        //͹���ֹ�1
    $sql .= "t_direct.post_no2,";        //͹���ֹ�2
    $sql .= "t_direct.address1,";        //����1
    $sql .= "t_direct.address2,";        //����2
    $sql .= "t_direct.address3,";        //����3
    $sql .= "t_direct.tel,";             //TEL
    $sql .= "t_direct.fax,";             //FAX
    $sql .= "t_direct.note,";            //����
    $sql .= "t_client.client_cd1,";      //������CD
    $sql .= "t_client.client_cd2,";      //��ŹCD
    $sql .= "t_client.client_name,";     //������̾
    $sql .= "direct_name2 ";             //ľ����̾��
    $sql .= "FROM ";
    $sql .= "t_direct ";
    $sql .= "LEFT JOIN ";
    $sql .= "t_client ";
    $sql .= "ON ";
    $sql .= "t_direct.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "t_direct.direct_id = $direct_id;";
    
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ��
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //�ե�������ͤ�����
    $def_fdata["form_direct_cd"]                      =    $data_list[0];     //ľ���襳����
    $def_fdata["form_direct_name"]                    =    $data_list[1];     //ľ����̾
    $def_fdata["form_direct_name2"]                   =    $data_list[14];    //ľ����̾2
    $def_fdata["form_direct_cname"]                   =    $data_list[2];     //ά��
    $def_fdata["form_post"]["form_post_no1"]          =    $data_list[3];     //͹���ֹ�1
    $def_fdata["form_post"]["form_post_no2"]          =    $data_list[4];     //͹���ֹ�2
    $def_fdata["form_address1"]                       =    $data_list[5];     //����1
    $def_fdata["form_address2"]                       =    $data_list[6];     //����2
    $def_fdata["form_address3"]                       =    $data_list[7];     //����3
    $def_fdata["form_tel"]                            =    $data_list[8];     //TEL
    $def_fdata["form_fax"]                            =    $data_list[9];     //FAX
    $def_fdata["form_note"]                           =    $data_list[10];     //����
    $def_fdata["form_client"]["form_client_cd1"]      =    $data_list[11];    //������CD
    $def_fdata["form_client"]["form_client_cd2"]      =    $data_list[12];    //��ŹCD
    $def_fdata["form_client"]["form_client_name"]     =    $data_list[13];    //������̾

    $form->setDefaults($def_fdata);
    $id_data = Make_Get_Id($db_con, "direct", $data_list[0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

}
/****************************/
//�������
/****************************/
//ľ���襳����
$form->addElement("text","form_direct_cd","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//ľ����̾
$form->addElement("text","form_direct_name","�ƥ����ȥե�����","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//ľ����̾2
$form->addElement("text","form_direct_name2","�ƥ����ȥե�����","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//ά��
$form->addElement("text","form_direct_cname","�ƥ����ȥե�����","size=\"44\" maxLength=\"20\"".$g_form_option."\"");

//͹���ֹ�
$text[] =& $form->createElement("text","form_post_no1","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post[form_post_no1]','form_post[form_post_no2]',3)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","form_post_no2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $text, "form_post", "form_post");

//���꣱
$form->addElement("text","form_address1","�ƥ����ȥե�����","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//���ꣲ
$form->addElement("text","form_address2","�ƥ����ȥե�����","size=\"44\" maxLength=\"25\"".$g_form_option."\"");
//����3
$form->addElement("text","form_address3","�ƥ����ȥե�����","size=\"44\" maxLength=\"30\"".$g_form_option."\"");
//TEL
$form->addElement("text","form_tel","�ƥ����ȥե�����","size=\"44\" maxLength=\"30\" style=\"$g_form_style\"".$g_form_option."\"");
//FAX
$form->addElement("text","form_fax","�ƥ����ȥե�����","size=\"44\" maxLength=\"30\" style=\"$g_form_style\" ".$g_form_option."\"");

//������
$text = "";
$text[] =& $form->createElement("text","form_client_cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onKeyUp=\"javascript:client1('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]');changeText(this.form,'form_client[form_client_cd1]','form_client[form_client_cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","form_client_cd2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onKeyUp=\"javascript:client1('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]')\"".$g_form_option."\"");
$text[] =& $form->createElement("text","form_client_name","�ƥ����ȥե�����","size=\"34\"$g_text_readonly");
$form->addGroup( $text, "form_client", "form_client");

//����
$form->addElement("text","form_note","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\"".$g_form_option."\"");

//������¤����뤫
//����ܥ���
//$form->addElement("button","del_button","���","style=\"color: #ff0000;\" onClick=\"javascript:Dialogue_2('������ޤ���', '#', 'true', 'del_button_flg')\" $disabled");
//$form->addElement("hidden","del_button_flg","","");

//if($direct_permit != 'n' && $direct_permit != ''){
	//�ѹ�������
	$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('2-1-218.php')\"");
	//��Ͽ(�إå�)
	$form->addElement("button","new_button","��Ͽ����",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//}
//������ޥ�������
$code_value .= Code_Value("t_client",$db_con,"",1);

//��ư���ϥܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "input_button_flg");

/****************************/
//���顼�����å�(AddRule)
/****************************/

//��ľ���襳����
//��ɬ�ܥ����å�
$form->addRule('form_direct_cd','ľ���襳���ɤ�Ⱦ�ѿ����ΤߤǤ���','required');
//��ʸ��������å�
$form->addRule('form_direct_cd','ľ���襳���ɤ�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/");

//��ľ����̾
//��ɬ�ܥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule('form_direct_name','ľ����̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���','required');
$form->addRule('form_direct_name','ľ����̾�˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���','no_sp_name');

//��ά��
//��ɬ�ܥ����å�
$form->addRule('form_direct_cname','ά�Τ�1ʸ���ʾ�10ʸ���ʲ��Ǥ���','required');

//��͹���ֹ�
//��ɬ�ܥ����å�
//��ʸ���������å�
//��ʸ��������å�
$form->addGroupRule('form_post', array(
    'form_post_no1' => array(
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','required'),
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','rangelength',array(3,3)),
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���',"regex", "/^[0-9]+$/")
    ),
    'form_post_no2' => array(
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','required'),
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','rangelength',array(4,4)),
        array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���',"regex", "/^[0-9]+$/"),
    )
));

//������1
//��ɬ�ܥ����å�
$form->addRule('form_address1','���꣱��1ʸ���ʾ�15ʸ���ʲ��Ǥ���','required');

//��TEL
//��ʸ��������å�
$form->addRule("form_tel", "TEL��Ⱦ�ѿ����ȡ�-�פΤ�13��Ǥ���", "regex", "/^[0-9-]+$/");

//��FAX
//��ʸ��������å�
$form->addRule("form_fax", "FAX��Ⱦ�ѿ����ȡ�-�פΤ�13��Ǥ���", "regex", "/^[0-9-]+$/");


/******************************/
//��ư���ϥܥ��󲡲�����
/*****************************/
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["form_post_no1"];               //͹���ֹ棱
    $post2     = $_POST["form_post"]["form_post_no2"];               //͹���ֹ棲
    //͹���ֹ椫���ͼ���
    $post_value = Post_Get($post1,$post2,$db_con);
    $cons_data["form_post"]["form_post_no1"]     = $post1;
    $cons_data["form_post"]["form_post_no2"]     = $post2;
    $cons_data["form_address1"]                  = $post_value[1];   //����1
    $cons_data["form_address2"]                  = $post_value[2];   //����2
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"]               = "";
    $form->setConstants($cons_data);
}

/******************************/
//��Ͽ�ܥ��󲡲�����
/*****************************/
if($_POST["entry_button"] == "�С�Ͽ"){
    $direct_cd         = $_POST["form_direct_cd"];                 //ľ���襳����
    $direct_name     = $_POST["form_direct_name"];                 //ľ����̾
    $direct_cname     = $_POST["form_direct_cname"];               //ά��
    $post1             = $_POST["form_post"]["form_post_no1"];     //͹���ֹ�1
    $post2             = $_POST["form_post"]["form_post_no2"];     //͹���ֹ�2
    $add1             = $_POST["form_address1"];                   //����1
    $add2             = $_POST["form_address2"];                   //����2
    $add3             = $_POST["form_address3"];                   //����3
    $tel             = $_POST["form_tel"];                         //TEL
    $fax             = $_POST["form_fax"];                         //FAX
    $note             = $_POST["form_note"];                       //����
    $client_cd1     = $_POST["form_client"]["form_client_cd1"];    //������CD
    $client_cd2     = $_POST["form_client"]["form_client_cd2"];    //��ŹCD
    $client_name     = $_POST["form_client"]["form_client_name"];  //������̾
    $direct_name2     = $_POST["form_direct_name2"];                 //ľ����̾

    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //���顼Ƚ�̥ե饰
    $err_flg = false;

    //��ľ���襳����
    //����ʣ�����å�
    if($direct_cd != null){
        //ľ���襳���ɤˣ�������
        $direct_cd = str_pad($direct_cd, 4, 0, STR_POS_LEFT);
        //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "direct_cd ";                //ľ���襳����
        $sql .= "FROM ";
        $sql .= "t_direct ";
        $sql .= "WHERE ";
        $sql .= "direct_cd = '$direct_cd' ";
        $sql .= "AND ";
        $sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";

        //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($direct_id != null){
            $sql .= " AND NOT ";
            $sql .= "direct_id = '$direct_id'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form_direct_cd_error = "���˻��Ѥ���Ƥ��� ľ���襳���� �Ǥ���";
              $err_flg = true;
        }
    }

    //��������
    //�������ͥ����å�
    if(($client_cd1 != null && $client_name == null) || ($client_cd2 != null && $client_name == null) || ($client_cd1 != null && $client_cd2 != null && $client_name == null)){
        $form_client_error = "�����������襳���ɤ����Ϥ��Ʋ�������";
          $err_flg = true;
    }

    //���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
    if($form->validate() && $err_flg == false){
        Db_Query($db_con, "BEGIN;");
 
        //��Ͽ���ѹ�Ƚ��
        if($direct_id != null){
            //��ȶ�ʬ�Ϲ���
            $work_div = '2';

            $sql  = "UPDATE ";
            $sql .= "t_direct ";
            $sql .= "SET ";
            $sql .= "direct_cd = '$direct_cd',";
            $sql .= "direct_name = '$direct_name',";
            $sql .= "direct_name2 = '$direct_name2',";
            $sql .= "direct_cname = '$direct_cname',";
            $sql .= "post_no1 = '$post1',";
            $sql .= "post_no2 = '$post2',";
            $sql .= "address1 = '$add1',";
            $sql .= "address2 = '$add2',";
            $sql .= "address3 = '$add3',";
            $sql .= "tel = '$tel',";
            $sql .= "fax = '$fax',";
            $sql .= "note = '$note',";
            //�����������Ƚ��
            if($client_cd1 != null && $client_cd2 != null){
                $sql .= "client_id = ";
                $sql .= "(SELECT ";
                $sql .= "client_id ";
                $sql .= "FROM ";
                $sql .= "t_client ";
                $sql .= "WHERE ";
			    $sql .= "shop_id = $shop_id ";
	            $sql .= "AND ";
	            $sql .= "client_div = '1' ";
			    $sql .= "AND ";
                $sql .= "client_cd1 = '$client_cd1' ";
                $sql .= "AND ";
                $sql .= "client_cd2 = '$client_cd2') ";
            }else{
                $sql .= "client_id = null ";
            }
            $sql .= "WHERE ";
//            $sql .= "t_direct.shop_id = $shop_id ";
//            $sql .= "AND ";
            $sql .= "t_direct.direct_id = $direct_id;";
        }else{
            //��ȶ�ʬ����Ͽ
            $work_div = '1';

            $sql  = "INSERT INTO t_direct (";
            $sql .= "   direct_id,";            //ľ����ID
            $sql .= "   direct_cd,";            //ľ����CD
            $sql .= "   direct_name,";          //ľ����̾
            $sql .= "   direct_name2,";         //ľ����̾��
            $sql .= "   direct_cname,";         //ά��
            $sql .= "   post_no1,";             //͹���ֹ棱
            $sql .= "   post_no2,";             //͹���ֹ棲
            $sql .= "   address1,";             //���꣱
            $sql .= "   address2,";             //���ꣲ
            $sql .= "   address3,";             //���ꣳ
            $sql .= "   tel,";                  //�����ֹ�
            $sql .= "   fax,";                  //FAX
            $sql .= "   note,";                 //����
            $sql .= "   client_id,";            //������ID
            $sql .= "   shop_id";               //FC���롼��ID
            $sql .= " )VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(direct_id), 0)+1 FROM t_direct),";     //ľ����ID
            $sql .= "'$direct_cd',";            //ľ����CD
            $sql .= "'$direct_name',";          //ľ����̾
            $sql .= "'$direct_name2',";         //ľ����̾��
            $sql .= "'$direct_cname',";         //ά��
            $sql .= "'$post1',";                //͹���ֹ棱
            $sql .= "'$post2',";                //͹���ֹ棲
            $sql .= "'$add1',";                 //���꣱
            $sql .= "'$add2',";                 //���ꣲ
            $sql .= "'$add3',";                 //���ꣳ
            $sql .= "'$tel',";                  //�����ֹ�
            $sql .= "'$fax',";                  //FAX
            $sql .= "'$note',";                 //����
            //�����������Ƚ��
            if($client_cd1 != null && $client_cd2 != null){
                $sql .= "(SELECT ";
                $sql .= "client_id ";
                $sql .= "FROM ";
                $sql .= "t_client ";
                $sql .= "WHERE ";
                $sql .= "shop_id = $shop_id ";
                $sql .= "AND ";
                $sql .= "client_div = '1' ";
                $sql .= "AND ";
                $sql .= "client_cd1 = '$client_cd1' ";
                $sql .= "AND ";
                $sql .= "client_cd2 = '$client_cd2'),";
            }else{
                $sql .= "null,";
            }
            $sql .= "$shop_id";
            $sql .= ");";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //ľ����ޥ������ͤ���˽񤭹���
        $result = Log_Save($db_con,'direct',$work_div,$direct_cd,$direct_name);
        //����Ͽ���˥��顼�ˤʤä����
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;
    }
}

/************************************/
//����ܥ��󲡲�����
/***********************************/
/*
if($_POST["del_button_flg"] == true){
    Db_Query($db_con, "BEGIN");
    $sql  = "DELETE FROM t_direct";
    $sql .= " WHERE direct_id = $direct_id ;";
    $result = Db_Query($db_con, $sql);

    if($result === false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }

    Db_Query($db_con, "COMMIT");
    header("Location: 2-1-218.php");
}
*/
//��Ͽ��ǧ���̤ξ��ϡ��ʲ��Υܥ������ɽ��
if($freeze_flg != true){
	//���إܥ���
	if($next_id != null){
	    $form->addElement("button","next_button","������","onClick=\"location.href='./2-1-219.php?direct_id=$next_id'\"");
	}else{
	    $form->addElement("button","next_button","������","disabled");
	}
	//���إܥ���
	if($back_id != null){
	    $form->addElement("button","back_button","������","onClick=\"location.href='./2-1-219.php?direct_id=$back_id'\"");
	}else{
	    $form->addElement("button","back_button","������","disabled");
	}
    $form->addElement(
            "submit","entry_button","�С�Ͽ",
            "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled"
    );

	//��ư����
	$form->addElement("button","input_button","��ư����","onClick=\"javascript:Button_Submit('input_button_flg','#','true')\"");
	//������
	$form->addElement("link","form_claim_link","","#","������","onClick=\"return Open_SubWin('../dialog/2-0-250.php',Array('form_client[form_client_cd1]','form_client[form_client_cd2]','form_client[form_client_name]'),500,450);\"");

    // ������Ͽ���ˤϽ��Ϥ��ʤ�
    if ($direct_id != null){
        // ���ܥ���
        $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='./2-1-218.php'\"");
    }

}else{

    // ���ܥ����������ID����
    // ������Ͽ��
    if ($direct_id == null){
        $sql    = "SELECT MAX(direct_id) FROM t_direct WHERE shop_id = $shop_id;\n";
        $res    = Db_Query($db_con, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // �ѹ���
    }else{  
        $get_id = $direct_id;
    }

	//��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
	//���
	$form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?direct_id=$get_id'\"");
	//OK
	$form->addElement("button","comp_button","O ��K","onClick=\"location.href='./2-1-219.php'\"");
    $form->addElement("static","form_claim_link","","������");
    $form->freeze();
}

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** ľ����ޥ�������SQL���� **/
$sql = "SELECT ";
$sql .= "COUNT(direct_id) ";                //ľ����ID
$sql .= "FROM ";
$sql .= "t_direct ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " t_direct.shop_id IN (".Rank_Sql().") " : " t_direct.shop_id = $shop_id ";
$result = Db_Query($db_con,$sql.";");
//���������(�إå���)
$total_count_h = pg_fetch_result($result,0,0);

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
$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count_h."��)";
//if($direct_permit != 'n' && $direct_permit != ''){
	$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
	$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//}
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'                  => "$html_header",
    'page_menu'                    => "$page_menu",
    'page_header'                  => "$page_header",
    'html_footer'                  => "$html_footer",
    'code_value'                   => "$code_value",
    'form_direct_cd_error'         => "$form_direct_cd_error",
    'form_client_error'            => "$form_client_error",
	'direct_id'                    => "$direct_id",
    "freeze_flg"                    => "$freeze_flg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
