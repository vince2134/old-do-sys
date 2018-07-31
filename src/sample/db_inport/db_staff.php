<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//DB接続
$db_con = Db_Connect("amenity_060315");

    $fp = fopen("./t_staff.csv","r");

    Db_Query($db_con, "BEGIN");


    $num = 1;
    while($insert_data = fgetcsv($fp, "1000", ",") ){
        
        for($i = 0; $i < count($insert_data); $i++){
            if($insert_data[$i] == '\N'){
                $insert_data[$i] = '' ;
            }
        //    $insert_data[$i] = trim(pg_escape_string($insert_data[$i]));
        }
print "今".$num."人目です<br>";

        /*******************************/
        //スタッフマスタ
        /*******************************/

        $sql  = "INSERT INTO t_staff (";
        $sql .= "   staff_id,";
        $sql .= "   staff_cd1,";
        $sql .= "   staff_cd2,";
        $sql .= "   charge_cd,";
        $sql .= "   staff_name,";
        $sql .= "   staff_read,";
        $sql .= "   staff_ascii,";
        $sql .= "   sex,";
        if($insert_data[8] != null){
            $sql .= "   birth_day,";
        }
        $sql .= "   state,";
        if($insert_data[10] != null){
            $sql .= "   join_day,";
        }
        if($insert_data[11] != null){
            $sql .= "   retire_day,";
        }
        $sql .= "   employ_type,";
        $sql .= "   position,";
        $sql .= "   job_type,";
        $sql .= "   study,";
        $sql .= "   toilet_license,";
        $sql .= "   license,";
        $sql .= "   note,";
        $sql .= "   photo,";
        $sql .= "   change_flg";
        $sql .= ")VALUES(";
        $sql .= "   '$insert_data[0]',";
        $sql .= "   '$insert_data[1]',";
        $sql .= "   '$insert_data[2]',";
        $sql .= "   $insert_data[3],";
        $sql .= "   '$insert_data[4]',";
        $sql .= "   '$insert_data[5]',";
        $sql .= "   '$insert_data[6]',";
        $sql .= "   '$insert_data[7]',";
        if($insert_data[8] != null){
            $sql .= "   '$insert_data[8]',";
        }
        $sql .= "   '$insert_data[9]',";
        if($insert_data[10] != null){
            $sql .= "   '$insert_data[10]',";
        }
        if($insert_data[11] != null){
            $sql .= "   '$insert_data[11]',";
        }
        $sql .= "   '$insert_data[12]',";
        $sql .= "   '$insert_data[15]',";
        $sql .= "   '$insert_data[16]',";
        $sql .= "   '$insert_data[17]',";
        $sql .= "   '$insert_data[18]',";
        $sql .= "   '$insert_data[19]',";
        $sql .= "   '$insert_data[20]',";
        $sql .= "   '$insert_data[21]',";
        $sql .= "   '$insert_data[23]'";
        $sql .= ");";
 
        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        //ログインマスタ
        $sql  = "INSERT INTO t_login(";
        $sql .= "   staff_id,";
        $sql .= "   login_id,";
        $sql .= "   password";
        $sql .= ")VALUES(";
        $sql .= "   $insert_data[0],";
        $sql .= "   'head$insert_data[0]',";
        $sql .= "   ''";
        $sql .= ");";


        $result = Db_Query($db_con, $sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        $client_id[0] = 1;      //本部  
        $client_id[1] = 93;     //東洋

        $h_staff_flg[0] = 't';
        $h_staff_flg[1] = 'f';


        for($i = 0; $i < 2; $i++){
            $sql  = "INSERT INTO t_attach (";
            $sql .= "   staff_id,";
            $sql .= "   client_id,";
            $sql .= "   h_staff_flg,";
            $sql .= "   sys_flg";
            $sql .= ")VALUES(";
            $sql .= "   $insert_data[0],";
            $sql .= "   $client_id[$i],";
            $sql .= "   '$h_staff_flg[$i]',";
            $sql .= "   'f'";
            $sql .= ");";
        
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
        $num = $num+1;

    }
    Db_Query($db_con, "COMMIT;");


?>
