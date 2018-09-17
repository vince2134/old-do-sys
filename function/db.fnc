<?php

//�ǡ����١�������³��Ԥ�
function Db_Connect($db_name=""){

    //��³DB��̵������  ������DB����³
    if($db_name == "" ){
        $db_con  = pg_connect(DB_INFO);
    //����ʳ��ξ��ϡ�����DB����³
    }else{
        #$db_name = "amenity_test_demo";
        #$db_con  = pg_connect("host=127.0.0.1 port=5432 dbname=$db_name");
        $db_con  = pg_connect("host=210.196.79.249 port=5432 dbname=$db_name");
    }

    if (!$db_con){
        echo "�ǡ����١����Ȥ���³�˼��Ԥ��ޤ�����";
        exit;
    }

    return $db_con;
}


//SQL��¹Ԥ���
function Db_Query($db_con, $sql, $debug=""){

	$result = @pg_query($db_con,$sql);

	//SQL�¹Ԥ˼��Ԥ������ϡ���ư�ǥǥХå���Ԥ�
	if($result == ""){

        $duplicate_err = "duplicate";

		// SQLʸ�ȥ��顼��å�������ɽ��
        //UNIQUE����ǤϤ����줿���ϥ��顼ɽ�����ʤ�
        if(!strstr(pg_last_error(), $duplicate_err)){
		    echo "$sql <br />";
		    echo  pg_last_error ();
		    echo "<hr>";
        }

		return false;

	//�ǥХå��ե饰��1�ξ��ϡ��ǥХå�������Ԥ�
	}else if($debug === 1){

		echo "$sql <br />";
		echo  pg_last_error ();
		echo "<hr>";
	}
/*
*/	
	return $result;
}

//DB�Ȥ���³�����Ǥ���
function Db_Disconnect($db_con){

	$pg_close = pg_close($db_con);

	if (!$db_con){
		echo "�ǡ����١����Ȥ����Ǥ˼��Ԥ��ޤ�����";
		exit;
	}

}

/**
 * ����  �ơ��֥������ǡ�������Ͽ���� 
 *
 * ����
 *
 * @param resource  $db_con       DB��³�꥽����
 * @param string    $table_name   �ơ��֥�̾
 * @param array     $data         ��Ͽ�ǡ���
 *
 * @return resource               ��������DB�꥽���������Ի���false
 *
 */
function Db_Insert($db_con, $table_name, $data, $debug_flg=NULL){
    //��������
    $count = 0;
    foreach($data AS $column => $value){

        //�ǽ�ʳ��ϥ���ޤ��դ��Ʒ��
        if ($count != "0"){
            $columns .= ","."$column";
            $values  .= ","."$value";
        } else {
            $columns = "$column";
            $values  = "$value";
        } 

        $count++;
    }

    //INSERT
    $sql = "INSERT INTO $table_name ($columns) VALUES($values);";
    $result = Db_Query($db_con, $sql,$debug_flg);  
    return $result;
}


/**
 * ����  �ơ��֥�򹹿����� 
 *
 * ����
 *
 * @param resource  $db_con       DB��³�꥽����
 * @param string    $table_name   �ơ��֥�̾
 * @param array     $data         �����ǡ���
 * @param array     $where        �������
 *
 * @return resource               ��������DB�꥽���������Ի���false
 *
 */
function Db_Update($db_con, $table_name, $data, $where, $debug_flg=NULL){

    //�оݹ�������
    $count = 0;
    foreach($data AS $column => $value){

        //�ǽ�ʳ��ϥ���ޤ��դ��Ʒ��
        if ($count != "0"){
            $columns .= ","."$column = $value";
        } else {
            $columns  = "$column = $value";
        } 

        $count++;
    }

    //���ʸ����
    $count = 0;
    foreach($where AS $column => $value){

        //�ǽ�ʳ��ϥ���ޤ��դ��Ʒ��
        if ($count != "0"){
            $w_columns .= "AND   $column = $value";
        } else {
            $w_columns  = "WHERE $column = $value";
        } 

        $count++;
    }

    //UPDATE��郎̵�����ϥ��顼
    if($w_columns == NULL || $w_columns == ""){
        return false;
    }

    //UPDATE
    $sql = "UPDATE $table_name SET $columns $w_columns;";
    $result = Db_Query($db_con, $sql,$debug_flg);  
    return $result;

}


?>
