<?php
/**
 *
 * ����ѤΥե���������
 *
 * �ƽи�
 * ��2-2-201�ʼ����ɼȯ�ԡ�
 * ��2-2-118��ͽ������ɼ��
 *
 */
/*
 *  �ѹ�����
 *  ����            ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/15      suzuki      ��μ�����value���ɲ�
 *  2007/06/04      kajioka-h   ������λ��ͤ���ä�����JS�����ɲä��ޤ���
 */

/**************************************************
���
**************************************************/
//FC��ľ��Ƚ��
if($group_kind == 2){
	//ľ��

	//��԰�������å��ܥå���
	$form_daiko = NULL;
	//�ܵ�̾����Ƚ��
	if($client_id != NULL){
        //$daiko_js = "onClick=\"javascript:tegaki_daiko_checked(); Mult_double_All('$coax',false,'$daiko_coax'); \"";
        $daiko_js = "onClick=\"javascript:tegaki_daiko_checked(); Act_Request_Rate('$coax',false,'$daiko_coax'); \"";
		//javascript�¹ԥե��������
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "���ҽ�󡡡���", "1", $daiko_js);
		//$form_daiko[] =& $form->createElement("radio", NULL, NULL, "����饤�����", "2", $daiko_js);
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "���ե饤�����", "3", $daiko_js);
	}else{
		//javascript�ʤ��ե��������
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "���ҽ�󡡡���", "1");
		//$form_daiko[] =& $form->createElement("radio", NULL, NULL, "����饤�����", "2");
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "���ե饤�����", "3");
	}
	$form->addGroup($form_daiko, "daiko_check", "");

	//�����
	//$form->addElement("text","form_daiko_price","",'size="8" maxLength="10"'.$g_form_option." style='text-align:right; ime-mode:disabled;' onKeyup=\"Mult_double4('form_goods_num1','form_sale_price','form_sale_amount','form_trade_price','form_trade_amount','form_issiki','$coax','$daiko_coax');\"");

    //�������ʬ
    //$act_div_js = "onClick=\"t_price_readonly(this.value); Mult_double4('form_goods_num1','form_sale_price','form_sale_amount','form_trade_price','form_trade_amount','form_issiki','$coax','$daiko_coax'); \"";
    $act_div_js = "onClick=\"t_price_readonly('$coax',this.value,'$daiko_coax');\"";

    $act_div_ary1[] =& $form->createElement("radio",NULL,NULL, "ȯ�����롧�����","2", $act_div_js);
    $form->addGroup($act_div_ary1, "act_div[]", "������");

    $act_div_ary2[] =& $form->createElement("radio",NULL,NULL, "ȯ�����롧����","3", $act_div_js);
    $form->addGroup($act_div_ary2, "act_div[]", "������");

    $act_div_ary3[] =& $form->createElement("radio",NULL,NULL, "ȯ�����ʤ�","1", $act_div_js);
    $form->addGroup($act_div_ary3, "act_div[]", "������");

    //������ե�����
    //$form->addElement("text","act_request_price","��",'class="money_num" size="7" maxLength="6"'.$g_form_option);
    $form->addElement("text","act_request_price","��",'class="money_num" size="7" maxLength="6"'.$g_form_option);
    //$form->addElement("text","act_request_rate" ,"��",'class="num"       size="7" maxLength="3"'.$g_form_option);
    $form->addElement("text","act_request_rate" ,"��",'class="num"       size="7" maxLength="3"'.$g_form_option.
        "onKeyup=\"Act_Request_Rate('$coax',false,'$daiko_coax');\""
    );


	//������ ��FC�˥�����
	$form_daiko = NULL;
	$form_daiko[] =& $form->createElement(
		        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('daiko_search_flg','#','true','form_daiko[cd2]')\" onkeyup=\"changeText(this.form,'form_daiko[cd1]','form_daiko[cd2]',6)\"".$g_form_option."\""
		        );

	$form_daiko[] =& $form->createElement(
		        "static","","","-"
		        );
	$form_daiko[] =& $form->createElement(
		        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('daiko_search_flg','#','true')\"".$g_form_option."\""
		        );
	$form_daiko[] =& $form->createElement(
	    "text","name","",
	    "size=\"34\" $g_text_readonly"
	);
	$form->addGroup( $form_daiko, "form_daiko", "");

	//��������
	$form->addElement("link","form_daiko_link","�����","./2-2-201.php","�����","
	    onClick=\"return Open_SubWin('../../franchise/dialog/2-0-251.php',Array('form_daiko[cd1]','form_daiko[cd2]','form_daiko[name]', 'daiko_search_flg'),500,450,5,'daiko');\""
	);

	//�����谸����
	$form->addElement("textarea","form_daiko_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);


    $form->addElement("hidden", "hdn_daiko_id");        //���ID
    $form->addElement("hidden", "hdn_daiko_coax");      //��ԤΤޤ���ʬ
    $form->addElement("hidden", "daiko_search_flg");    //��ԥ������ե饰


}


?>