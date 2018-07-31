<?php
/*
 * ���� �ơ��֥�Υ����ȥ����ǯ��ˤ��������ؿ�
 *      
 * �ѹ�����
 *  2007-10-04  aizawa-m        ��������
 *  2007-10-07  aizawa-m        �����˽��״��֤��ɲ�
 *
 *  @param:     $start_y        ����ǯ
 *              $start_m        ���Ϸ�
 *              $period         ���״���
 *
 *  @return:    $disp_head      ɽ�Υإå�(�����ȥ�)����
 */
function Get_Header_YM ( $start_y , $start_m , $period ) {

    //12����ʬ��������� 
    for ( $i=0 ; $i<$period ; $i++ ) {
         //���դν񼰤��Ѥ���
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        //ǯ�������ʥơ��֥�إå���)
        $date           = substr($this_date, 0, 7);
        $year           = substr($this_date, 0, 4);
        $month          = substr($this_date, 5, 2);
        $disp_head[$i]  = $year."ǯ".$month."��";

    }
    //�����
    return $disp_head;
}

?>
