<?php

//���å��������å�
function Session_Check_h(){

    global $page_title;

	session_start();

	// staff_id������shop_id ��̵����Х���������̤����ܤ�����
	if($_SESSION[staff_id] == "" || $_SESSION[h_client_id] == ""){
		header("Location: " .LOGIN_PAGE);
		exit();
	}

    $_SESSION["client_id"]  = $_SESSION["h_client_id"];
	$_SESSION["shop_name"]  = $_SESSION["h_shop_name"];
    $_SESSION["group_kind"] = $_SESSION["h_group_kind"];
    $_SESSION["rank_cd"]    = $_SESSION["h_rank_cd"];
	$_SESSION["staff_flg"]  = $_SESSION["h_staff_flg"];

	#2008-06-14 url���ѹ��ˤ���ɲ�
#	$_SESSION['url']  = $_SERVER['REQUEST_URI'];

    unset($_SESSION["branch_id"]);


    //������Ϥ�
    //aoyama-n 2009-08-31 /tmp�ʲ��ϰ�����֥����������ʤ��ե�����Ϻ������Ƥ��ޤ�����/var���ѹ�
    #error_log($_SERVER["REMOTE_ADDR"]."����".date('Y-m-d H:i:s')."�ۡ�".$_SESSION["shop_name"]."��".$_SESSION["staff_id"]."��".$_SESSION["staff_name"]." ��".$_SERVER["PHP_SELF"]."��".$page_title."\n", 3, "/tmp/pankuzu.txt");
    error_log($_SERVER["REMOTE_ADDR"]."����".date('Y-m-d H:i:s')."�ۡ�".$_SESSION["shop_name"]."��".$_SESSION["staff_id"]."��".$_SESSION["staff_name"]." ��".$_SERVER["PHP_SELF"]."��".$page_title."\n", 3, "/var/log/pankuzu.txt");
}

function Session_Check_fc(){

    global $page_title;

	session_start();

	// staff_id������shop_id ��̵����Х���������̤����ܤ�����
	if($_SESSION[staff_id] == "" || $_SESSION[fc_client_id] == ""){
		header("Location: " .LOGIN_PAGE);
		exit();
	}

    $_SESSION["client_id"]  = $_SESSION["fc_client_id"];
	$_SESSION["shop_name"]  = $_SESSION["fc_shop_name"];
    $_SESSION["group_kind"] = $_SESSION["fc_group_kind"];
    $_SESSION["rank_cd"]    = $_SESSION["fc_rank_cd"];
	$_SESSION["staff_flg"]  = $_SESSION["fc_staff_flg"];
    $_SESSION["branch_id"]  = $_SESSION["fc_branch_id"];

	#2008-06-14 url���ѹ��ˤ���ɲ�
#	$_SESSION['url']  = $_SERVER['REQUEST_URI'];

    //������Ϥ�
    //aoyama-n 2009-08-31 /tmp�ʲ��ϰ�����֥����������ʤ��ե�����Ϻ������Ƥ��ޤ�����/var���ѹ�
    #error_log($_SERVER["REMOTE_ADDR"]."����".date('Y-m-d H:i:s')."�ۡ�".$_SESSION["shop_name"]."��".$_SESSION["staff_id"]."��".$_SESSION["staff_name"]." ��".$_SERVER["PHP_SELF"]."��".$page_title."\n", 3, "/tmp/pankuzu.txt");
    error_log($_SERVER["REMOTE_ADDR"]."����".date('Y-m-d H:i:s')."�ۡ�".$_SESSION["shop_name"]."��".$_SESSION["staff_id"]."��".$_SESSION["staff_name"]." ��".$_SERVER["PHP_SELF"]."��".$page_title."\n", 3, "/var/log/pankuzu.txt");
}



?>