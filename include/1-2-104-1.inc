<?php



           $insert_sql = " INSERT INTO t_stock_hand(";
           $insert_sql .= "    goods_id,";
           $insert_sql .= "    enter_day,";
           $insert_sql .= "    work_day,";
           $insert_sql .= "    work_div,";
           $insert_sql .= "    client_id,";
           $insert_sql .= "    ware_id,";
           $insert_sql .= "    io_div,";
           $insert_sql .= "    num,";
           $insert_sql .= "    slip_no,";
           $insert_sql .= "    aord_d_id,";
           $insert_sql .= "    shop_id,";
           $insert_sql .= "    staff_id";
           $insert_sql .= " )values(";
           if($fw_goods_id == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $fw_goods_id,";
           }
           $insert_sql .= "    NOW(),";
           if($ord_day == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    '$ord_day',";
           }
           $insert_sql .= "    '1',";
           if($client_id == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $client_id,";
           }
           if($ware_id == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $ware_id,";
           }
           $insert_sql .= "    '2',";
           if($forward_num[$i] == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $num,";
           }
           $insert_sql .= "    '$order_no',";
           if($aorder_d_id == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $aorder_d_id,";
           }
           if($client_id == ""){
               $insert_sql .= "    null,";
           }else{
               $insert_sql .= "    $client_id,";
           }
           if($staff_id == ""){
               $insert_sql .= "    null";
           }else{
               $insert_sql .= "    $staff_id";
           }
           $insert_sql .= " );";
           $result = Db_Query($db_con, $insert_sql);
           if($result === false){
               Db_Query($db_con, "ROLLBACK;");

               exit;
           }




?>
