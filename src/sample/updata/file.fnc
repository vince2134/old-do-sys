<?php

//�ե�����򥢥åץ��ɤ���
# $form_name    : HTML�Υե�����̾
# $up_dir_name  : ������¦�Ǥ���¸�ǥ��쥯�ȥ�
# $up_file_name : ������¦�Ǥ���¸�ե�����̾
# �����        : ���� true, ���� false
function File_Upload ($form_name, $up_dir_name, $up_file_name){

    $file_path_f = $up_dir_name .$up_file_name;   //������¦�Ǥ���¸��
    $file_tmp    = $_FILES[$form_name][tmp_name]; //�ǡ���
    $file_name   = $_FILES[$form_name][name];     //̾��
    $file_type   = $_FILES[$form_name][type];     //������
    $file_size   = $_FILES[$form_name][size];     //������

    $error=""; //���顼Ƚ���ѿ�

    // ��magic_quotes_gpc = On�פΤȤ��� ��\�׽���
    if (get_magic_quotes_gpc()) {
        $file_name  = stripslashes($file_name);
    }

    //���åץ��ɥե������ǧ
    if(!is_uploaded_file($file_tmp)){
        $error .= "���åץ��ɤ��줿�ե����뤬���Ĥ���ޤ���<hr>";
    }

    //�ե����륵���������å�1
    if ($file_size==0){
        $error .= "<b>�ե����륵������0�Ǥ�</b><hr>";
    }

    //�ե����륵���������å�2
    if($file_size>=8000000){
        $error .= "<b>�ե����륵������8M��Ķ���Ƥ��ޤ���</b><hr>";
    }

    //�ե����륿���ץ����å�
    #if(!ereg ("^image","$file_type")){
    #    $error .= "�����ե�����ǤϤ���ޤ���<hr>";
    #}

    //�ե�����̾�����å�
    if(ereg ("([\\/:*?\"<>|])","$file_name")){
        $error .= "\\ / : * ? \" < > |  �ϥե�����̾�Ȥ�����Ŭ�ڤǤ���<hr>";
    }

    //���顼���ʤ���Х��åץ��ɽ�������
    if($error == ""){
        move_uploaded_file ($file_tmp, "$file_path_f");
        chmod ($file_path_f, 0644);
        return true;

    //���顼��������
    }else{
        echo $error;
        return false;
    }

    return true;

}

//�ե������ʸ�������ɤ��Ѵ�����
function File_Mb_Convert ($filename, $str_from="SJIS", $str_to="EUC-JP")
{

    //�ե��������Ȥ��ѿ��س�Ǽ����
    $fd = fopen ($filename, "r");
	flock  ($fd, LOCK_EX);
    $contents = fread ($fd, filesize ($filename));
    fclose ($fd);

    //ʸ�������ɤ��Ѵ�
    $contents = mb_convert_encoding ($contents, $str_to, $str_from);
    $fd = fopen ($filename, "w+");
    //�񤭹���
	flock  ($fd, LOCK_EX);
    fwrite ($fd, $contents);
    fclose ($fd);
}

?>
