<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/16) ��°�ޥ������ɲ�(suzuki-t)
 * 1.1.0 (2006/03/21) ���������ν���(suzuki-t)
 * 1.1.1 (2006/05/08) �����ե�����ɽ���ܥ����ɲá�watanabe-k��
 * 
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.0.0 (2006/03/16)
*/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/12/14��ssl-0068������watanabe-k�������ե������ɽ���ܥ��󲡲�����JS���顼��ɽ�������Х��ν���
 * ��2007/02/16         ����   watanabe-k���������˻�Ź���ɲ�
 * ��2010/05/13  Rev.1.5 ��    hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
 * ��2010/09/04  Rev.1.6 ��    aoyama-n    ���ɽ���˺߿���Υ����åդ����ɽ������褦���ѹ�
 *
 */





$page_title = "�����åեޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];

/****************************/
//�ǥե����������
/****************************/
$def_date = array(
    "form_output_type"    => "1",
    "form_state"          => "�߿���",
    "form_toilet_license" => "4"
);
$form->setDefaults($def_date);

/****************************/
//�������
/****************************/
//��Ͽ
$form->addElement("button","new_button","��Ͽ����","onClick=\"javascript:Referer('2-1-108.php')\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//ɽ��
$form->addElement("submit","show_button","ɽ����");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//�����ե�����ɽ���ܥ���
$form->addElement("submit","form_search_button","�����ե������ɽ��",
                  "onClick=\"javascript:Button_Submit_1('search_button_flg', './2-1-107.php', 'true')\"");

//���Ϸ���
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio, "form_output_type", "���Ϸ���");
//�߿�����
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "�߿���","�߿���");
$radio[] =& $form->createElement( "radio",NULL,NULL, "�࿦","�࿦");
$radio[] =& $form->createElement( "radio",NULL,NULL, "�ٶ�","�ٶ�");
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","����");
$form->addGroup($radio, "form_state", "�߿�");
//�ȥ����ʿ��ǻ�
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","4");
$radio[] =& $form->createElement( "radio",NULL,NULL, "����ȥ�����ǻ�","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "����ȥ�����ǻ�","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "̵","3");
$form->addGroup($radio, "form_toilet_license", "�ȥ�����ǻ��");

//����åץ�����
$text[] =& $form->createElement("text","cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");
//�����åե�����
$text = "";
$text[] =& $form->createElement("text","cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_staff_cd[cd1]','form_staff_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text, "form_staff_cd", "form_staff_cd");

//����å�̾
$form->addElement("text","form_client_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//�����å�̾
$form->addElement("text","form_staff_name","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");
//ô���ԥ�����
$form->addElement("text","form_charge_cd","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//�������
$form->addElement("text","form_license","�ƥ����ȥե�����","size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
//��
$form->addElement("text","form_position","�ƥ����ȥե�����","size=\"15\" maxLength=\"7\" ".$g_form_option."\"");
//��°����
//$select_value = Select_Get($db_con,'part');
//$form->addElement('select', 'form_part', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
$obj_bank_select->setOptions(Make_Ary_Branch($db_con));

//����
$select_value="";
$select_value = array(
    ""         =>  "",
    "�Ķ�"     =>  "�Ķ�",
    "�����ӥ�" =>  "�����ӥ�",
    "��̳"     =>  "��̳",
    "����¾"   =>  "����¾"
);
$form->addElement('select', 'form_job_type', '���쥯�ȥܥå���', $select_value,$g_form_option_select);


//hidden
$form->addElement("hidden", "search_button_flg");


/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
#2010-09-04 aoyama-n
#if($_POST["show_button"]=="ɽ����"){


    /******************************/
    //�إå�����ɽ�������������
    /*****************************/
    /** �����åեޥ�������SQL���� **/
    $sql = "SELECT  \n";
    $sql .= " t_client_union.client_cd1, \n";    //����åץ�����1
    $sql .= " t_client_union.client_cd2, \n";    //����åץ�����2
    $sql .= " t_client_union.client_name, \n";   //����å�̾
    $sql .= " charge_cd, \n";                    //ô���ԥ�����
    $sql .= " t_staff.staff_id,  \n";            //�����å�ID
    $sql .= " staff_cd1,  \n";                   //�����åե����ɣ�
    $sql .= " staff_cd2,  \n";                   //�����åե����ɣ�
    $sql .= " staff_name,  \n";                  //�����å�̾
    $sql .= " t_part.part_name,  \n";            //����̾
    $sql .= " position,  \n";                    //��
    $sql .= " job_type,  \n";                    //����
    $sql .= " state,  \n";                       //�߿�����
    $sql .= " CASE t_staff.toilet_license \n";   //�ȥ�����ǻλ��
    $sql .= "     WHEN '1' THEN '����ȥ�����ǻ�' \n";
    $sql .= "     WHEN '2' THEN '����ȥ�����ǻ�' \n";
    $sql .= "     WHEN '3' THEN '̵' \n";
    $sql .= " END, \n";
    $sql .= " t_staff.license,  \n";              //�������
    $sql .= " t_branch.branch_name \n";
    $sql .= "FROM  \n";
    $sql .= " (SELECT  \n";
    $sql .= "   client_id, \n";
    //$sql .= "   attach_gid, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_name \n";
    $sql .= " FROM  \n";
    $sql .= "   t_client  \n";
    $sql .= " WHERE  \n";
    $sql .= "   client_div = '3' \n";
    $sql .= " )  \n";
    $sql .= "AS t_client_union \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_attach  \n";
    $sql .= " ON t_client_union.client_id = t_attach.shop_id \n";
    $sql .= "   INNER JOIN  \n";
    $sql .= " t_part  \n";
    $sql .= " ON t_attach.part_id = t_part.part_id  \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_branch \n";
    $sql .= " ON t_part.branch_id= t_branch.branch_id \n";
    $sql .= "   INNER JOIN \n";
    $sql .= " t_staff ON t_staff.staff_id = t_attach.staff_id  \n";
    $sql .= "WHERE  \n";
    //$sql .= " t_attach.shop_id = t_client_union.client_id  \n";
    //$sql .= "AND  \n";
    //ľ��Ƚ��
    if($_SESSION[group_kind] == '2'){
    	//ľ��
    	$sql .= "    t_attach.shop_id IN(".Rank_Sql().") \n";
    }else{ 
    	//�ƣ�
    	$sql .= "    t_attach.shop_id = $shop_id  \n";
    }

    #2010-05-12 hashimoto-y
    #//���ɽ�������߿���Υ����åդΤ�ɽ��
    #if($_POST["search_button_flg"]!=true && $_POST["show_button"]!="ɽ����"){
    #    $sql .= "AND state = '�߿���' ";
    #    $cons_data["search_button_flg"] = "";
    #    $form->setConstants($cons_data);
    #}

    #2010-09-04 aoyama-n
    //���ɽ�������߿���Υ����åդΤ�ɽ��
    if($_POST["search_button_flg"]!=true && $_POST["show_button"]!="ɽ����"){
        $sql .= "AND state = '�߿���' ";
        $cons_data["search_button_flg"] = "";
        $form->setConstants($cons_data);
        $display_flg = true;
    }

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
#2010-09-04 aoyama-n
if($_POST["show_button"]=="ɽ����"){

    $output_type = $_POST["form_output_type"];        //���Ϸ���
    $state       = $_POST["form_state"];              //�߿�����
    $job_type    = $_POST["form_job_type"];           //����
    $client_cd1    = $_POST["form_client_cd"]["cd1"]; //����åץ����ɣ�
    $client_cd2    = $_POST["form_client_cd"]["cd2"]; //����åץ����ɣ�
    $staff_cd1   = $_POST["form_staff_cd"]["cd1"];    //�����åե����ɣ�
    $staff_cd2   = $_POST["form_staff_cd"]["cd2"];    //�����åե����ɣ�
    $client_name   = $_POST["form_client_name"];          //����å�̾
    $staff_name  = $_POST["form_staff_name"];         //�����å�̾
    $charge_cd   = $_POST["form_charge_cd"];          //ô���ԥ�����
    $license     = $_POST["form_license"];            //�������
    $position    = $_POST["form_position"];           //��
    $branch      = $_POST["form_part"][0];            //��Ź
    $part        = $_POST["form_part"][1];            //����̾
    $toilet      = $_POST["form_toilet_license"];     //�ȥ�����ǻλ��

    //CSV������Ƚ��
    if($output_type == 1 || $output_type == null){
        //����ɽ������
		
        /** ������ **/
        //����åץ����ɣ������̵ͭ
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //����åץ����ɣ������̵ͭ
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //����å�̾�����̵ͭ
        if($client_name != null){
            $sql .= "AND t_client_union.client_name  LIKE '%$client_name%' ";
        }
        //�����åե����ɣ������̵ͭ
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //�����åե����ɣ������̵ͭ
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //�����å�̾�����̵ͭ
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }
        //ô���ԥ����ɻ����̵ͭ
        if($charge_cd != null){
			//00��000���ͤϰ��ΰ١�ʸ������������Ƚ��
			$str = str_pad($charge_cd, 4, 'A', STR_POS_LEFT);
			if($str == 'A000'){
				$sql .= "AND charge_cd BETWEEN 0 AND 9 ";
			}else if($str == 'AA00'){
				$sql .= "AND charge_cd BETWEEN 0 AND 99 ";
			}else if($str == 'AAA0'){
				$sql .= "AND charge_cd BETWEEN 0 AND 999 ";
			}else{
				if(ereg("^[0-9]{1,4}$",$charge_cd)){
					$sql .= "AND charge_cd = $charge_cd ";
				}else{
					$sql .= "AND charge_cd LIKE '$charge_cd%' ";
				}
			}
        }
        //����̾�����̵ͭ
        if($part != null){
            $sql .= "AND t_part.part_id = $part ";
        }
        //�򿦻����̵ͭ
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //��Ź�����̵ͭ
        if($branch != null){
            $sql .= "AND t_branch.branch_id = $branch ";
        }
        //��������̵ͭ
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //�߿����̻����̵ͭ
        if($state!='����'){
            $sql .= "AND state = '$state' ";
        }
        //�ȥ�����ǻλ�ʻ����̵ͭ
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //������ʻ����̵ͭ
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
    
    }else{
        //CSVɽ������

        /** CSV����SQL **/
        $sql = "SELECT ";
		$sql .= " charge_cd,";                    //ô���ԥ�����
        $sql .= " staff_cd1, ";                   //�����åե����ɣ�
        $sql .= " staff_cd2, ";                   //�����åե����ɣ�
        $sql .= " staff_name, ";                  //�����å�̾
        $sql .= " staff_read, ";                  //�����å�̾(�եꥬ��)
        $sql .= " staff_ascii, ";                 //�����å�̾(���޻�)
        $sql .= " sex, ";                         //����
        $sql .= " birth_day, ";                   //��ǯ����
        $sql .= " state, ";                       //�߿�����
        $sql .= " join_day, ";                    //����ǯ����
        $sql .= " retire_day, ";                  //�࿦��
        $sql .= " employ_type , ";                //���ѷ���
        $sql .= " t_part.part_cd, ";              //���𥳡���
        $sql .= " t_part.part_name, ";            //��°����̾
        $sql .= " t_attach.section, ";            //��°����ʲݡ�
        $sql .= " position, ";                    //��
        $sql .= " job_type, ";                    //����
        $sql .= " study, ";                       //��������
        $sql .= " toilet_license, ";              //�ȥ�����ǻλ��
        $sql .= " t_staff.license, ";             //�������
        $sql .= " t_staff.note, ";                //����
        $sql .= " t_ware.ware_cd, ";              //ô���Ҹ˥�����
        $sql .= " t_ware.ware_name, ";            //ô���Ҹ�̾
        $sql .= " change_flg, ";                  //�ѹ��Բ�ǽ�ե饰
        $sql .= " t_branch.branch_cd, ";
        $sql .= " t_branch.branch_name ";
        $sql .= "FROM ";
        $sql .= " (SELECT ";
		$sql .= "   client_id,";
//		$sql .= "   attach_gid,";
		$sql .= "   client_cd1,";
		$sql .= "   client_cd2,";
		$sql .= "   client_name";
		$sql .= " FROM ";
		$sql .= "   t_client ";
		$sql .= " WHERE ";
		$sql .= "   client_div = '3'";
		$sql .= " ) ";
        $sql .= "AS t_client_union,";
        $sql .= " t_attach ";

        $sql .= " LEFT JOIN ";
		$sql .= "     t_part ";
		$sql .= " ON t_attach.part_id = t_part.part_id ";

        $sql .= " LEFT JOIN ";
        $sql .= "    t_branch ";
        $sql .= " ON t_part.branch_id = t_branch.branch_id ";


        $sql .= " LEFT JOIN ";
        $sql .= "     t_ware ";
		$sql .= " ON t_attach.ware_id = t_ware.ware_id ";

		$sql .= " INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
        $sql .= "WHERE ";
        $sql .= " t_attach.shop_id = t_client_union.client_id ";
        $sql .= "AND ";
        //ľ��Ƚ��
		if($_SESSION[group_kind] == '2'){
			//ľ��
			$sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
		}else{ 
			//�ƣ�
			$sql .= "    t_attach.shop_id = $shop_id ";
		}

        /** ������ **/
        //����åץ����ɣ������̵ͭ
        if($client_cd1 != null){
            $sql .= "AND t_client_union.client_cd1 LIKE '$client_cd1%' ";
        }
        //����åץ����ɣ������̵ͭ
        if($client_cd2 != null){
            $sql .= "AND t_client_union.client_cd2 LIKE '$client_cd2%' ";
        }
        //����å�̾�����̵ͭ
        if($client_name != null){
            $sql .= "AND t_client_union.client_name LIKE '%$client_name%' ";
        }
        //�����åե����ɣ������̵ͭ
        if($staff_cd1 != null){
            $sql .= "AND staff_cd1 LIKE '$staff_cd1%' ";
        }
        //�����åե����ɣ������̵ͭ
        if($staff_cd2 != null){
            $sql .= "AND staff_cd2 LIKE '$staff_cd2%' ";
        }
        //�����å�̾�����̵ͭ
        if($staff_name != null){
            $sql .= "AND staff_name LIKE '%$staff_name%' ";
        }
        //ô���ԥ����ɻ����̵ͭ
        if($charge_cd != null){
			//00��000���ͤϰ��ΰ١�ʸ������������Ƚ��
			$str = str_pad($charge_cd, 4, 'A', STR_POS_LEFT);
			if($str == 'A000'){
				$sql .= "AND charge_cd BETWEEN 0 AND 9 ";
			}else if($str == 'AA00'){
				$sql .= "AND charge_cd BETWEEN 0 AND 99 ";
			}else if($str == 'AAA0'){
				$sql .= "AND charge_cd BETWEEN 0 AND 999 ";
			}else{
				if(ereg("^[0-9]{1,4}$",$charge_cd)){
					$sql .= "AND charge_cd = $charge_cd ";
				}else{
					$sql .= "AND charge_cd LIKE '$charge_cd%' ";
				}
			}
        }
        //����̾�����̵ͭ
        if($part != null){
             $sql .= "AND t_part.part_id = $part ";
        }
        //�򿦻����̵ͭ
        if($position != null){
            $sql .= "AND position LIKE '%$position%' ";
        }
        //��������̵ͭ
        if($job_type != null){
            $sql .= "AND job_type = '$job_type' ";
        }
        //�߿����̻����̵ͭ
        if($state!='����'){
            $sql .= "AND state = '$state' ";
        }
        //�ȥ�����ǻλ�ʻ����̵ͭ
        if($toilet!='4'){
            $sql .= "AND t_staff.toilet_license = '$toilet' ";
        }
        //������ʻ����̵ͭ
        if($license != null){
            $sql .= "AND t_staff.license LIKE '%$license%' ";
        }
        $sql .= " ORDER BY ";
        $sql .= "charge_cd;";

        $result = Db_Query($db_con,$sql);

        //CSV�ǡ�������
        $i=0;
        while($data_list = pg_fetch_array($result)){

			$staff_data[$i][0]  = str_pad($data_list[0], 4, "0", STR_PAD_LEFT);     //ô���ԥ�����
            $staff_data[$i][1]  = str_pad($data_list[1], 6, "0", STR_PAD_LEFT)."-".str_pad($data_list[2], 4, "0", STR_PAD_LEFT);  //�����åե�����
            $staff_data[$i][2]  = $data_list[3];                    //�����å�\̾
            $staff_data[$i][3]  = $data_list[4];                    //�����å�̾(�եꥬ��)
            $staff_data[$i][4]  = $data_list[5];                    //�����å�̾(���޻�)
            //����Ƚ���1:�� 2:����
            if($data_list[6]==1){
                $staff_data[$i][5]  = "��";
            }else{
                $staff_data[$i][5]  = "��";
            }                    
            $staff_data[$i][6]  = $data_list[7];                    //��ǯ����
            $staff_data[$i][7]  = $data_list[8];                    //�߿�����
            $staff_data[$i][8]  = $data_list[9];                    //����ǯ����
            $staff_data[$i][9]  = $data_list[10];                   //�࿦��
            $staff_data[$i][10] = $data_list[11];                   //���ѷ���
            $staff_data[$i][11] = $data_list[branch_cd];                   //���ѷ���
            $staff_data[$i][12] = $data_list[branch_name];                   //���ѷ���
            $staff_data[$i][13] = $data_list[12];                   //��°���𥳡���
            $staff_data[$i][14] = $data_list[13];                   //��°����̾
            $staff_data[$i][15] = $data_list[14];                   //��°����ʲݡ�
            $staff_data[$i][16] = $data_list[15];                   //��
            $staff_data[$i][17] = $data_list[16];                   //����
            $staff_data[$i][18] = $data_list[17];                   //��������
            //�ȥ�����ǻλ��Ƚ��(1:���� 2:���� 3:̵)
            if($data_list[18]=='1'){
                $staff_data[$i][19] = "����ȥ�����ǻ�";    
            }else if($data_list[18]=='2'){
                $staff_data[$i][19] = "����ȥ�����ǻ�";    
            }else{
                $staff_data[$i][19] = "̵";    
            }
            $staff_data[$i][20] = $data_list[19];                    //�������
            $staff_data[$i][21] = $data_list[20];                    //����
            $staff_data[$i][22] = $data_list[21];                    //ô���Ҹ˥�����
            $staff_data[$i][23] = $data_list[22];                    //ô���Ҹ�̾
            //�ѹ��Բ�ǽ�ե饰Ƚ��(t:�ѹ��Բ� f:�ѹ���)
            if($data_list[23]==true){
                $staff_data[$i][24] = "�ѹ��Բ�";
            }else{
                $staff_data[$i][24] = "�ѹ���";
            }
            $i++;
        }

        //CSV�ե�����̾
        $csv_file_name = "�����åեޥ���".date("Ymd").".csv";
        //CSV�إå�����
        $csv_header = array(
			"ô���ԥ�����",
            "�����åե�����", 
            "�����å�̾",
            "�����å�̾(�եꥬ��)",
            "�����å�̾(���޻�)",
            "����",
            "��ǯ����",
            "�߿�����",
            "����ǯ����",
            "�࿦��", 
            "���ѷ���",
            "��Ź������",
            "��Ź̾",
            "��°���𥳡���",
            "��°����̾",
            "��°����ʲݡ�",
            "��",
            "����",
            "��������",
            "�ȥ�����ǻλ��",
            "�������",
            "����",
            "ô���Ҹ˥�����",
            "ô���Ҹ�̾",
            "�ѹ��Բ�ǽ�ե饰"
        );
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv_Staff($staff_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
    }

#2010-09-04 aoyama-n
$display_flg = true;
}

    $result = Db_Query($db_con,$sql." ORDER BY t_client_union.client_cd1, t_client_union.client_cd2, charge_cd;");
    //���������(�ǡ���)
    $total_count = pg_num_rows($result);

    //�ԥǡ������ʤ����
    $row = Get_Data($result,$output_type);
    //ô���ԥ����ɤ�0��᤹��
    for($i=0;$i<count($row);$i++){
        $row[$i][3] = str_pad($row[$i][3], 4, 0, STR_POS_LEFT);
    }

    //��ʣ����
    for($i = 0; $i < count($row); $i++){
        for($j = 0; $j < count($row); $j++){
            if($i != $j && $row[$i][0] == $row[$j][0] && $row[$i][1] == $row[$j][1]){
                $row[$j][0] = null;
                $row[$j][1] = null;
                $row[$j][2] = null;
            }
        }
    }

    //tr��bgcolor����
    for($i = 0; $i < count($row); $i++){
        if($i == 0){
            $tr[$i] = "Result1";
        }elseif($row[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{
            if($tr[$i-1] == "Result1"){
                $tr[$i] = "Result2";
            }else{
                $tr[$i] = "Result1";
            }
        }
    }


#2010-09-04 aoyama-n
#2010-05-12 hashimoto-y
#$display_flg = true;
#}

/******************************/
// CSV�����ؿ��ʥ����åեޥ����ѡ�
/*****************************/
function Make_Csv_Staff($row ,$header){

    //�쥳���ɤ�̵�����ϡ�CSV�ǡ�����NULL��ɽ��������
    if(count($row)==0){
        $row[] = array("","");
    }

    // ����˥إå��Ԥ��ɲ�
    $count = array_unshift($row, $header);

    // ���� 
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
            $row[$i][$j] = str_replace("\r\n", "��", $row[$i][$j]);
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }       
        // ����򥫥�޶��ڤ�Ƿ��
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // ���󥳡��ǥ���
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}


/******************************/
//�إå�����ɽ�������������
/*****************************/
/** �����åեޥ�������SQL���� **/
$sql  = "SELECT ";
$sql .= "    count(staff_id) ";                    //�����å�ID
$sql .= "FROM ";
$sql .= "    t_attach ";
$sql .= "WHERE ";
$sql .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".(Rank_Sql()).") " : " shop_id = $shop_id ";
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
if ($_SESSION["group_kind"] != "2"){
    $page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
    $page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
}
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
    'total_count'    => "$total_count",
    'display_flg'    => "$display_flg",
));
$smarty->assign('tr',$tr);

$smarty->assign('row',$row);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
