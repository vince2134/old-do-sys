<?php
    
require_once("ENV_local.php");

$db_con = Db_Connect();

$price_data[0]  = 350;
$tax_div[0]     = 1;
$coax           = 1;
$tax_franct     = 1;
$tax_rate       = 5;
$client_id      = 3680;

$data = Total_Amount2($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con);  

print_array($data);


function Total_Amount2($price_data, $tax_div, $coax="1", $tax_franct="1", $tax_rate="5", $client_id, $db_con){
    //������β��Ƕ�ʬ�����
    $sql  = "SELECT";
    $sql .= "   c_tax_div ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $c_tax_div = pg_fetch_result($result, 0,0);    //������Ψ
    $rate = bcdiv($tax_rate, 100, 2);    //������Ψ�ǡ��ܡ���
    $in_rate = bcadd($rate,1,2);    //��ɼ��פ������

    if(is_array($price_data) === true){
        //���ʿ��롼��
        for($i = 0; $i < count($price_data); $i++){
            $buy_amount = str_replace(',','',$price_data[$i]);            //���Ƕ�ʬ�����
            if($c_tax_div == '1' && $tax_div[$i] == '1'){
                $tax_div[$i] = '1';
            //����
            }elseif($c_tax_div == '2' && $tax_div[$i] == '1'){
                $tax_div[$i] = '2';
            //����
            }elseif($tax_div[$i] == '3'){
                $tax_div[$i] = '3';
            //�����
            }

            //�������Ȥ�NULL�ξ��ϡ�������Ԥ�ʤ�
            if($buy_amount != null){
                //���Ƕ�ʬ���Ȥ˾��ʤι�פ����
                //���Ǥξ��
                if($tax_div[$i] == '1'){
                    $outside_buy_amount     = bcadd($outside_buy_amount,$buy_amount);                //���Ǥξ��
                }elseif($tax_div[$i] == '2'){
                    $inside_amount          = bcadd($inside_amount, $buy_amount);
                }elseif($tax_div[$i] == '3'){
                    $exemption_buy_amount   = bcadd($exemption_buy_amount, $buy_amount);
                }
            }
        }

        //�����Ǥ����
        //����
        if($outside_buy_amount != 0){
            $outside_tax_amount   = bcmul($outside_buy_amount, $rate,2);                    //�����ǳۡʴݤ�����
            $outside_tax_amount   = Coax_Col2($tax_franct, $outside_tax_amount);             //�����ǳۡʴݤ���
        }       

        //����          if($inside_amount != 0){
            $in_rate              = bcmul($in_rate,100);
            $inside_tax_amount    = bcdiv($inside_amount, $in_rate,2);
            $inside_tax_amount    = bcmul($inside_tax_amount, $tax_rate,2);
            $inside_tax_amount    = Coax_Col2($tax_franct, $inside_tax_amount);
            $inside_buy_amount    = bcsub($inside_amount, $inside_tax_amount);
        }


        //��ȴ����۹��
        $buy_amount_all     = $outside_buy_amount + $inside_buy_amount + $exemption_buy_amount;
        //�����ǹ��
        $tax_amount_all     = $outside_tax_amount + $inside_tax_amount;
        //�ǹ��߶�۹��
        $total_amount       = $buy_amount_all + $tax_amount_all;

/*
                //�����Ǥ򻻽�
                //����
                if($tax_div[$i] == '1'){
                    $tax_amount = bcmul($buy_amount,$rate,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                //����
                }elseif($tax_div[$i] == '2'){
                    $tax_amount = bcdiv($buy_amount, $in_rate,2);
                    $tax_amount = bcsub($buy_amount, $tax_amount,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                    $buy_amount = bcsub($buy_amount, $tax_amount);

                //�����
                }elseif($tax_div[$i] == '3'){
                    $tax_amount = 0;
                }

                //�����ǹ��
                $tax_amount_all = bcadd($tax_amount_all, $tax_amount);

                //������۹�ס���ȴ��
                $buy_amount_all = bcadd($buy_amount_all, $buy_amount);

                //������۹�ס��ǹ���
                $total_amount = bcadd($buy_amount_all, $tax_amount_all);
                $total_amount_all = bcadd($total_amount_all, $total_amount);
            }
        }
*/
    //��ñ�̤ι�פ������
    }else{
        if($tax_div == null){
            $tax_div == '1';
        }

        //���Ƕ�ʬ�����
        if($c_tax_div == '1' && $tax_div == '1'){
            $tax_div = '1';             //����
        }elseif($c_tax_div == '2' && $tax_div == '1'){
            $tax_div = '2';             //����
        }elseif($tax_div == '3'){
            $tax_div = '3';             //�����
        }

        //���
        $buy_amount = str_replace(',','',$price_data);

        //������
        //����
        if($tax_div[$i] == '1'){
            $tax_amount = bcmul($buy_amount,$rate,2);
            $tax_amount = Coax_Col2($tax_franct, $tax_amount);
        //����
        //��˾����ǳۤ��ᡢ��׶�ۤ�������ǳۤ��������Τ���ȴ����ۤȤ��롣
        }elseif($tax_div[$i] == '2'){
            $tax_amount = bcdiv($buy_amount, $in_rate,2);
            $tax_amount = bcsub($buy_amount, $tax_amount,2);
            $tax_amount = Coax_Col2($tax_franct, $tax_amount);
            $buy_amount = bcsub($buy_amount, $tax_amount);
        //�����
        }elseif($tax_div[$i] == '3'){
            $tax_amount = 0;
        }

        $buy_amount_all = $buy_amount;
        $tax_amount_all = $tax_amount;

        $total_amount = bcadd($buy_amount, $tax_amount);
    }

    $data = array($buy_amount_all, $tax_amount_all, $total_amount);
    return $data;
}

function Coax_Col2($coax, $price){
    if($coax == '1'){
        $price = floor($price);
    }elseif($coax == '2'){
        $price = round($price);
    }elseif($coax == '3'){
        $price = ceil($price);
    }

    return $price;
}



?>
