<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2010/09/04                  aoyama-n    ������̾������Ϥ���褦���ѹ�
 *  2010/09/04                  aoyama-n    �����ե饰��Ƚ�ꤹ��褦���ѹ�
 *  2010/09/04                  aoyama-n    �ɾΤ���Ϥ���褦���ѹ�
*/



//��٥��ɽ������ǡ��������
function Get_Label_Data ($db_con, $shop_id){

    //ʣ���Υ���åס�������ˤ����򤵤�Ƥ�����
    if(is_array($shop_id)){
        $in_shop_id = implode(',', $shop_id);
        $in_shop_id = str_replace("f", "null", $in_shop_id);
    //��ĤΥ���åס�������ˤ����򤵤�Ƥ�����
    }else{
        $in_shop_id = $shop_id;
    }


    #2010-09-04 aoyama-n
    /*
    $sql = "
            SELECT
                post_no1 || '-' || post_no2 AS post_no,
                address1,
                address2,
                address3,
                client_name,
                client_name2,
                shop_name,
                tel,
                bill_address_font
            FROM
                t_client 
            WHERE
                client_id IN (".$in_shop_id.")
            ORDER BY
                client_cd1,
                client_cd2 
        ";
    */
    $sql = "
            SELECT
                post_no1 || '-' || post_no2 AS post_no,
                address1,
                address2,
                address3,
                client_name,
                client_name2,
                shop_name,
                tel,
                bill_address_font,
                client_slip1,
                client_slip2,
                CASE compellation
                    WHEN 1 THEN '����'
                    WHEN 2 THEN '��'
                END AS compellation
            FROM
                t_client 
            WHERE
                client_id IN (".$in_shop_id.")
            ORDER BY
                client_cd1,
                client_cd2 
        ";

    $result = Db_Query($db_con, $sql);
    
    //�ǡ������
    if(pg_num_rows($result) == 0){
        return false;
    }

    $data = pg_fetch_all($result);

    return $data;
}


function Make_Label_Pdf ($pdf, $label_data){

    /*********************************************/
    $pdf->AddMBFont(GOTHIC ,'SJIS');$pdf->AddMBFont(PGOTHIC,'SJIS');
    $pdf->AddMBFont(MINCHO ,'SJIS');
    $pdf->AddMBFont(PMINCHO,'SJIS');
    $pdf->AddMBFont(KOZMIN ,'SJIS');
    $pdf->SetFont(GOTHIC, 'B', 7);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    /**********************�ǡ�������***************************/
    $width = array("18","215","413");
    $line_height = array("62","181","300","420","540","659");
    $height = array("14","24","34","44","54","64","74");

    //���ߤ����ֹ�
    $j = 0;
    //���ߤι��ֹ�
    $h = 0;
    //���ߤΥ�٥��
    $i = 0;

    for($s = 0; $s < count($label_data); $s++){

        #2010-05-07 hashimoto-y
        #2010-05-11
        #���ɲä�̵���ʤä��Τǥ����ȥ�����
        #if($_GET["label_font"] == "s"){ 
        #    $pdf->SetFontSize(7);
        #}elseif($_GET["label_font"] == "b"){
        #    $pdf->SetFontSize(9);
        #}

        #2010-05-11 hashimoto-y
        if($label_data[$s]["bill_address_font"] == "t"){ 
            $pdf->SetFontSize(9);
        }else{
            $pdf->SetFontSize(7);
        }

        /**************���ڡ���*****************/
        if($i == 18){ 
            $pdf->AddPage();
        
            //�����
            $j = 0; 
            $h = 0; 
            $i = 0; 
        }
        /***************************************/


        /***********���ιԤ˥ݥ���Ȱ�ư********/
        if($i == 3*($h+1)){
            $j = 0; 
            $h++;   
        }
        /***************************************/

        //͹���ֹ�
        $pdf->SetXY($width[$j]-5,$line_height[$h]+$height[0]);
        $pdf->Cell(20,5,$label_data[$s]["post_no"],'0','1','L');

        //���꣱
        $pdf->SetXY($width[$j],$line_height[$h]+$height[1]);
        $pdf->Cell(80,5,$label_data[$s]["address1"],'0','1','L');

        //���ꣲ
        $pdf->SetXY($width[$j],$line_height[$h]+$height[2]);
        $pdf->Cell(80,5,$label_data[$s]["address2"],'0','1','L');

        //����3
        $pdf->SetXY($width[$j],$line_height[$h]+$height[3]);
        $pdf->Cell(80,5,$label_data[$s]["address3"],'0','1','L');

        //�����ξ��
        if($_SESSION["group_kind"] == "1"){
            //��̾
            $pdf->SetXY($width[$j],$line_height[$h]+$height[4]);
            #2010-09-04 aoyama-n
            #$pdf->Cell(80,5,trim($label_data[$s]["shop_name"])." ����",'0','1','L');
            $pdf->Cell(80,5,trim($label_data[$s]["shop_name"])." ".$label_data[$s]["compellation"],'0','1','L');
            //����å�̾
            $pdf->SetXY($width[$j],$line_height[$h]+$height[5]);
            $pdf->Cell(80,5,"(".trim($label_data[$s]["client_name"]).")",'0','1','L');
        //����åפξ��
        }else{
            #2010-09-04 aoyama-n
            if($label_data[$s]["client_name2"] != "" && $label_data[$s]["client_slip2"] != "1"){
                $compellation1 = "";
                $compellation2 = $label_data[$s]["compellation"];
            }elseif($label_data[$s]["client_name"] != "" && $label_data[$s]["client_slip1"] != "1"){
                $compellation1 = $label_data[$s]["compellation"];
                $compellation2 = "";
            }else{
                $compellation1 = "";
                $compellation2 = "";
            }

            if($label_data[$s]["client_slip1"] != "1"){
                //������̾��
                $pdf->SetXY($width[$j],$line_height[$h]+$height[4]);
                $pdf->Cell(80,5,trim($label_data[$s]["client_name"])." ".$compellation1,'0','1','L');
            } 
            if($label_data[$s]["client_slip2"] != "1"){
                //������̾��
                $pdf->SetXY($width[$j],$line_height[$h]+$height[5]);
                #$pdf->Cell(80,5,trim($label_data[$s]["client_name"])." ����",'0','1','L');
                $pdf->Cell(80,5,trim($label_data[$s]["client_name2"])." ".$compellation2,'0','1','L');
            }
        }

        //tel
        $pdf->SetXY($width[$j],$line_height[$h]+$height[6]);
        $pdf->Cell(80,5,$label_data[$s]["tel"]."",'0','1','L');

        $i++;
        $j++;
    }

    $pdf->Output();
}

?>