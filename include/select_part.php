<?php
for($x=1;$x<=10;$x++){
    //����
    $select_value = Select_Get($db_con, 'part');
    $form->addElement("select", 'form_part_'.$x, "", $select_value, $g_form_option_select);

    //�Ҹ�
    $select_value = Select_Get($db_con, 'ware');
    $form->addElement("select", 'form_ware_'.$x, "", $select_value, $g_form_option_select);

    //�ȼ�
    $select_value = Select_Get($db_con, 'btype');
    $form->addElement("select", 'form_btype_'.$x, "", $select_value, $g_form_option_select);

    //���
    $select_value = Select_Get($db_con, 'bank');
    $form->addElement("select", 'form_bank_'.$x, "", $select_value, $g_form_option_select);

    //ô����
    $select_value = Select_Get($db_con, 'staff');
    $form->addElement("select", 'form_staff_'.$x, "", $select_value, $g_form_option_select);

    //���ʶ�ʬ
    $select_value = Select_Get($db_con, 'product');
    $form->addElement("select", 'form_product_'.$x, "", $select_value, $g_form_option_select);

    //�Ͷ�ʬ
    $select_value = Select_Get($db_con, 'g_goods');
    $form->addElement("select", 'form_g_goods_'.$x, "", $select_value, $g_form_option_select);

    //�϶�
    $select_value = Select_Get($db_con, 'area');
    $form->addElement("select", 'form_area_'.$x, "", $select_value, $g_form_option_select);

    //ľ����
    $select_value = Select_Get($db_con, 'direct');
    $form->addElement("select", 'form_direct_'.$x, "", $select_value, $g_form_option_select);

    //������
    $select_value = Select_Get($db_con, 'compose','WHERE t_goods.goods_id = t_compose.goods_id');
    $form->addElement("select", 'form_compose_'.$x, "", $select_value, $g_form_option_select);

    //�����ȼ�
    $select_value = Select_Get($db_con, 'trans');
    $form->addElement("select", 'form_trans_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(����)
    $select_value = Select_Get($db_con, 'trade_aord');
    $form->addElement("select", 'trade_aord_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(���)
    $select_value = Select_Get($db_con, 'trade_sale');
    $form->addElement("select", 'trade_sale_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(����)
    $select_value = Select_Get($db_con, 'trade_payin');
    $form->addElement("select", 'trade_payin_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(ȯ��)
    $select_value = Select_Get($db_con, 'trade_ord');
    $form->addElement("select", 'trade_ord_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(����)
    $select_value = Select_Get($db_con, 'trade_buy');
    $form->addElement("select", 'trade_buy_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ(��ʧ)
    $select_value = Select_Get($db_con, 'trade_payout');
    $form->addElement("select", 'trade_payout_'.$x, "", $select_value, $g_form_option_select);

    //�����ӥ�
    $select_value = Select_Get($db_con, 'serv');
    $form->addElement("select", 'form_serv_'.$x, "", $select_value, $g_form_option_select);

    //�ܵҶ�ʬ
    $select_value = Select_Get($db_con, 'rank');
    $form->addElement("select", 'form_rank_'.$x, "", $select_value, $g_form_option_select);

    //���ʥ��롼��
    $select_value = Select_Get($db_con, 'goods_gr');
    $form->addElement("select", 'form_goods_gr_'.$x, "", $select_value, $g_form_option_select);
    
    //���롼��
    $select_value = Select_Get($db_con, 'shop_gr');
    $form->addElement("select", 'form_shop_gr_'.$x, "", $select_value, $g_form_option_select);

    //��¤��
    $select_value = Select_Get($db_con, 'make_goods','WHERE t_goods.goods_id = t_make_goods.goods_id');
    $form->addElement("select", 'form_make_goods_'.$x, "", $select_value, $g_form_option_select);

    //������
    $select_value = Select_Get($db_con, 'course');
    $form->addElement("select", 'form_course_'.$x, "", $select_value, $g_form_option_select);

    //��Ź&�оݵ���
    $select_value = Select_Get($db_con, 'cshop');
    $form->addElement("select", 'form_cshop_'.$x, "", $select_value, $g_form_option_select);

    //����
    $select_value = Select_Get($db_con, 'close');
    $form->addElement("select", 'form_close_'.$x, "", $select_value, $g_form_option_select);

    //�����ʬ
    $select_value = Select_Get($db_con, 'divide');
    $form->addElement("select", 'form_divide_'.$x, "", $select_value, $g_form_option_select);
}
?>
