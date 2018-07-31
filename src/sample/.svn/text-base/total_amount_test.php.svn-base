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
    //ÆÀ°ÕÀè¤Î²ÝÀÇ¶èÊ¬¤òÃê½Ð
    $sql  = "SELECT";
    $sql .= "   c_tax_div ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $c_tax_div = pg_fetch_result($result, 0,0);    //¾ÃÈñÀÇÎ¨
    $rate = bcdiv($tax_rate, 100, 2);    //¾ÃÈñÀÇÎ¨ÀÇ¡¡¡Ü¡¡£±
    $in_rate = bcadd($rate,1,2);    //ÅÁÉ¼¹ç·×¤òµá¤á¤ë¾ì¹ç

    if(is_array($price_data) === true){
        //¾¦ÉÊ¿ô¥ë¡¼¥×
        for($i = 0; $i < count($price_data); $i++){
            $buy_amount = str_replace(',','',$price_data[$i]);            //²ÝÀÇ¶èÊ¬¤ò·è¤á¤ë
            if($c_tax_div == '1' && $tax_div[$i] == '1'){
                $tax_div[$i] = '1';
            //³°ÀÇ
            }elseif($c_tax_div == '2' && $tax_div[$i] == '1'){
                $tax_div[$i] = '2';
            //ÆâÀÇ
            }elseif($tax_div[$i] == '3'){
                $tax_div[$i] = '3';
            //Èó²ÝÀÇ
            }

            //ÇÛÎó¤ÎÃæ¿È¤¬NULL¤Î¾ì¹ç¤Ï¡¢½èÍý¤ò¹Ô¤ï¤Ê¤¤
            if($buy_amount != null){
                //²ÝÀÇ¶èÊ¬¤´¤È¤Ë¾¦ÉÊ¤Î¹ç·×¤òµá¤á¤ë
                //³°ÀÇ¤Î¾ì¹ç
                if($tax_div[$i] == '1'){
                    $outside_buy_amount     = bcadd($outside_buy_amount,$buy_amount);                //ÆâÀÇ¤Î¾ì¹ç
                }elseif($tax_div[$i] == '2'){
                    $inside_amount          = bcadd($inside_amount, $buy_amount);
                }elseif($tax_div[$i] == '3'){
                    $exemption_buy_amount   = bcadd($exemption_buy_amount, $buy_amount);
                }
            }
        }

        //¾ÃÈñÀÇ¤òµá¤á¤ë
        //³°ÀÇ
        if($outside_buy_amount != 0){
            $outside_tax_amount   = bcmul($outside_buy_amount, $rate,2);                    //¾ÃÈñÀÇ³Û¡Ê´Ý¤áÁ°¡Ë
            $outside_tax_amount   = Coax_Col2($tax_franct, $outside_tax_amount);             //¾ÃÈñÀÇ³Û¡Ê´Ý¤á¸å¡Ë
        }       

        //ÆâÀÇ          if($inside_amount != 0){
            $in_rate              = bcmul($in_rate,100);
            $inside_tax_amount    = bcdiv($inside_amount, $in_rate,2);
            $inside_tax_amount    = bcmul($inside_tax_amount, $tax_rate,2);
            $inside_tax_amount    = Coax_Col2($tax_franct, $inside_tax_amount);
            $inside_buy_amount    = bcsub($inside_amount, $inside_tax_amount);
        }


        //ÀÇÈ´¤­¶â³Û¹ç·×
        $buy_amount_all     = $outside_buy_amount + $inside_buy_amount + $exemption_buy_amount;
        //¾ÃÈñÀÇ¹ç·×
        $tax_amount_all     = $outside_tax_amount + $inside_tax_amount;
        //ÀÇ¹þ¤ß¶â³Û¹ç·×
        $total_amount       = $buy_amount_all + $tax_amount_all;

/*
                //¾ÃÈñÀÇ¤ò»»½Ð
                //³°ÀÇ
                if($tax_div[$i] == '1'){
                    $tax_amount = bcmul($buy_amount,$rate,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                //ÆâÀÇ
                }elseif($tax_div[$i] == '2'){
                    $tax_amount = bcdiv($buy_amount, $in_rate,2);
                    $tax_amount = bcsub($buy_amount, $tax_amount,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                    $buy_amount = bcsub($buy_amount, $tax_amount);

                //Èó²ÝÀÇ
                }elseif($tax_div[$i] == '3'){
                    $tax_amount = 0;
                }

                //¾ÃÈñÀÇ¹ç·×
                $tax_amount_all = bcadd($tax_amount_all, $tax_amount);

                //»ÅÆþ¶â³Û¹ç·×¡ÊÀÇÈ´¡Ë
                $buy_amount_all = bcadd($buy_amount_all, $buy_amount);

                //»ÅÆþ¶â³Û¹ç·×¡ÊÀÇ¹þ¡Ë
                $total_amount = bcadd($buy_amount_all, $tax_amount_all);
                $total_amount_all = bcadd($total_amount_all, $total_amount);
            }
        }
*/
    //¹ÔÃ±°Ì¤Î¹ç·×¤òµá¤á¤ë¾ì¹ç
    }else{
        if($tax_div == null){
            $tax_div == '1';
        }

        //²ÝÀÇ¶èÊ¬¤ò·è¤á¤ë
        if($c_tax_div == '1' && $tax_div == '1'){
            $tax_div = '1';             //³°ÀÇ
        }elseif($c_tax_div == '2' && $tax_div == '1'){
            $tax_div = '2';             //ÆâÀÇ
        }elseif($tax_div == '3'){
            $tax_div = '3';             //Èó²ÝÀÇ
        }

        //¶â³Û
        $buy_amount = str_replace(',','',$price_data);

        //¾ÃÈñÀÇ
        //³°ÀÇ
        if($tax_div[$i] == '1'){
            $tax_amount = bcmul($buy_amount,$rate,2);
            $tax_amount = Coax_Col2($tax_franct, $tax_amount);
        //ÆâÀÇ
        //Àè¤Ë¾ÃÈñÀÇ³Û¤òµá¤á¡¢¹ç·×¶â³Û¤«¤é¾ÃÈñÀÇ³Û¤ò°ú¤¤¤¿¤â¤Î¤òÀÇÈ´¤­¶â³Û¤È¤¹¤ë¡£
        }elseif($tax_div[$i] == '2'){
            $tax_amount = bcdiv($buy_amount, $in_rate,2);
            $tax_amount = bcsub($buy_amount, $tax_amount,2);
            $tax_amount = Coax_Col2($tax_franct, $tax_amount);
            $buy_amount = bcsub($buy_amount, $tax_amount);
        //Èó²ÝÀÇ
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
