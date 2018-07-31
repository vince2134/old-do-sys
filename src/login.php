<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/09) ���å��������ѹ�
 * 1.1.0 (2006/03/21) �����åռ��̤�ʬ���ѹ�
 * 1.1.1 (2006/04/13) �ܼҡ��ټҶ�ʬ�ɲ�
 * 1.2.0 (2006/07/06) shop_gid��ʤ���(kaji)
 * 1.5.0 (2010/06/14) ̾��Do.sys2007��Do.sys2010���ѹ� Line21,299�ʾ�����
 *
 * @version     1.5.0 (2010/06/14)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-02-20                  watanabe-k  ���å����˻�ŹID���ɲ�
 */


$page_title="Do.sys2010 ������";

// �Ķ�����ե������ɤ߹���
require_once("ENV_local.php");

// ���å������˴�����
session_start();
session_unset();
session_destroy();
session_start();

$login_id=$_POST["login_id"]; //���ϥ桼��̾
$password=$_POST["password"]; //���ϥѥ����

$error_mes ="<br><br>"; //���顼��å����������

//���ƻ���Ƚ��
if($g_mente_mode === true){
    $disabled = "disabled";
    $warning  = "���������ƥʥ󥹺����Τ��������Ǥ��ޤ���";
}

//������ܥ��󤬲����줿��
if($_POST[submit]=="������"){
    //DB��³
    $db_con = Db_Connect();
    //�桼���������SQL
    $sql  = "SELECT ";
    $sql .= "   t_login.password, ";           //������ơ��֥�.�ѥ����
    $sql .= "   t_staff.staff_id";

    $sql .= " FROM ";
    $sql .= "   t_login,";                     //������
    $sql .= "   t_staff, ";                    //�����å�
    $sql .= "   t_attach ";                   //��°�ޥ���

    $sql .= " WHERE ";
    $sql .= "   t_login.login_id = '$login_id' ";
    $sql .= "   AND";
    $sql .= "   t_login.staff_id = t_staff.staff_id";
    $sql .= "   AND";
    $sql .= "   t_staff.staff_id = t_attach.staff_id";
    $sql .= "   AND\n";
    $sql .= "   t_staff.state = '�߿���'\n";
    $sql .= ";";

    //�桼���������
    $result      = Db_Query($db_con,$sql);
    $db_password = @pg_fetch_result ($result, 0, "password"); //DB����¸���줿�ѥ����
    $staff_id    = @pg_fetch_result ($result, 0, "staff_id"); 

    //�ѥ�������(���פ������)
    if (crypt($password,$db_password) == $db_password){

        $sql  = "SELECT\n";
        $sql .= "   t_staff.staff_id,\n";
        $sql .= "   t_staff.staff_name,\n";         
        $sql .= "   t_attach.sys_flg,\n";
        $sql .= "   t_attach.h_staff_flg,\n";
        $sql .= "   t_client.client_id,\n";
        $sql .= "   t_client.client_name,\n";
        $sql .= "   t_client.client_cname,\n";             
        $sql .= "   t_client.shop_name,\n";          
        $sql .= "   t_rank.group_kind,\n";
        $sql .= "   t_client.rank_cd,\n";
        $sql .= "   t_client.shop_div,\n";
        $sql .= "   t_part.branch_id \n";
        $sql .= " FROM\n";
        $sql .= "   t_staff\n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_attach\n";
        $sql .= "   ON t_staff.staff_id = t_attach.staff_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_client\n";
        $sql .= "   ON t_attach.shop_id = t_client.client_id \n";
        $sql .= "       INNER JOIN \n";   
        $sql .= "   t_rank\n";
        $sql .= "   ON t_client.rank_cd = t_rank.rank_cd \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "   t_part \n";
        $sql .="    ON t_attach.part_id = t_part.part_id \n";
        $sql .= " WHERE\n";
        $sql .= "   t_staff.staff_id = $staff_id\n";
        $sql .= "   ORDER BY t_attach.h_staff_flg DESC\n";
        $sql .= ";\n";

        $result = Db_Query($db_con,$sql);

        $data_num = pg_num_rows($result);
        //���إե饰��F�ξ��
        if($data_num == 1){
            $staff_id       = @pg_fetch_result ($result, 0, "staff_id");      //�����å�ID
            $staff_name     = @pg_fetch_result ($result, 0, "staff_name");    //�����å�̾
            $client_id      = @pg_fetch_result ($result, 0, "client_id");     //�����ID
            $client_name    = @pg_fetch_result ($result, 0, "client_name");   //�����̾
            $client_cname   = @pg_fetch_result ($result, 0, "client_cname");  //�����̾(ά��)
            $shop_name      = @pg_fetch_result ($result, 0, "shop_name");     //����å�̾
            $h_staff_flg    = @pg_fetch_result ($result, 0, "h_staff_flg");   //���������åեե饰
            $sys_flg        = @pg_fetch_result ($result, 0, "sys_flg");       //�����ƥ����إե饰
            $group_kind     = @pg_fetch_result ($result, 0, "group_kind");    //���롼�׼���
            $rank_cd        = @pg_fetch_result ($result, 0, "rank_cd");       //FC��ʬ������
            $shop_div       = @pg_fetch_result ($result, 0, "shop_div");      //�ܼҡ��ټҶ�ʬ
            $branch_id      = @pg_fetch_result ($result, 0, "branch_id");     //��ŹID

            $_SESSION["sys_flg"]      = $sys_flg;
            $_SESSION["staff_id"]     = $staff_id;
            $_SESSION["staff_name"]   = $staff_name;
            $_SESSION["shop_div"]     = $shop_div;

            //������Ԥ�FC�ξ��
            if($h_staff_flg == 'f'){
                $_SESSION["fc_client_id"]    = $client_id;
                $_SESSION["fc_client_name"]  = $client_name;
                $_SESSION["fc_client_cname"] = $client_cname;
                $_SESSION["fc_staff_flg"]    = $h_staff_flg;
                $_SESSION["fc_shop_name"]    = $shop_name;
                $_SESSION["fc_rank_cd"]      = $rank_cd;
                $_SESSION["fc_group_kind"]   = $group_kind;
                $_SESSION["fc_branch_id"]    = $branch_id;

                //FC�����å�
                $fc_head_flg = "fc";
/*
            //������Ԥ������ξ��
            }elseif($h_staff_flg == 't'){
                $_SESSION["h_client_id"]   = $client_id;
                $_SESSION["h_staff_flg"]   = $h_staff_flg;
                $_SESSION["h_shop_name"]   = $shop_name;
                $_SESSION["h_rank_cd"]     = $rank_cd;
                $_SESSION["h_group_kind"]  = $group_kind;
                //���������å�
                $fc_head_flg = "head";
*/
            }
        //���إե饰��T�ξ��
        }elseif($data_num == 2){

            for($i = 0; $i < $data_num; $i++){
                $ary_staff_id[$i]       = @pg_fetch_result ($result, $i, "staff_id");     //�����å�ID
                $ary_staff_name[$i]     = @pg_fetch_result ($result, $i, "staff_name");   //�����å�̾
                $ary_sys_flg[$i]        = @pg_fetch_result ($result, $i, "sys_flg");      //�����ƥ����إե饰
                $ary_h_staff_flg[$i]    = @pg_fetch_result ($result, $i, "h_staff_flg");  //���������åեե饰
                $ary_client_id[$i]      = @pg_fetch_result ($result, $i, "client_id");    //�����ID
                $ary_client_name[$i]    = @pg_fetch_result ($result, $i, "client_name");  //�����̾
                $ary_client_cname[$i]   = @pg_fetch_result ($result, $i, "client_cname"); //�����̾(ά��)
                $ary_shop_name[$i]      = @pg_fetch_result ($result, $i, "shop_name");    //����å�̾
                $ary_group_kind[$i]     = @pg_fetch_result ($result, $i, "group_kind");   //���롼�׼���
                $ary_rank_cd[$i]        = @pg_fetch_result ($result, $i, "rank_cd");      //FC��ʬ������
                $ary_shop_div[$i]       = @pg_fetch_result ($result, $i, "shop_div");     //�ܼҡ��ټҶ�ʬ
                $ary_branch_id[$i]      = @pg_fetch_result ($result, $i, "branch_id");    //��ŹID
            }

            //������FC����
            $_SESSION["staff_id"]       = $ary_staff_id[0];
            $_SESSION["sys_flg"]        = $ary_sys_flg[0]; 
            $_SESSION["staff_name"]     = $ary_staff_name[0];
            $_SESSION["shop_div"]       = $ary_shop_div[0];
            //���������å�
            $fc_head_flg = "head";

            //����
            $_SESSION["h_client_id"]    = $ary_client_id[0];
            $_SESSION["h_staff_flg"]    = $ary_h_staff_flg[0];
            $_SESSION["h_shop_name"]    = $ary_shop_name[0];
            $_SESSION["h_rank_cd"]      = $ary_rank_cd[0];
            $_SESSION["h_group_kind"]   = $ary_group_kind[0];
    
            //FC
            $_SESSION["fc_client_id"]    = $ary_client_id[1];
            $_SESSION["fc_client_name"]  = $ary_client_name[1];
            $_SESSION["fc_client_cname"] = $ary_client_cname[1];
            $_SESSION["fc_staff_flg"]    = $ary_h_staff_flg[1];
            $_SESSION["fc_shop_name"]    = $ary_shop_name[1];
            $_SESSION["fc_rank_cd"]      = $ary_rank_cd[1];
            $_SESSION["fc_group_kind"]   = $ary_group_kind[1];
            $_SESSION["fc_branch_id"]    = $ary_branch_id[1];
        }
    
        //�ǥ�Ķ��ǥ桼���Υ����������Ǥ��Ф�����
        $pwd = shell_exec("pwd");
        $demo_flg = (strpos($pwd, "demo") !== false)? true : false;

        if($demo_flg === true){
            shell_exec("date >> /tmp/demo_login.txt");
        }
        //�����桼���ξ��
        if($fc_head_flg == "head"){
            if($demo_flg === true){
                shell_exec("echo �����å�ID��".$ary_staff_id[0].", �����å�̾��".$ary_staff_name[0]." >> /tmp/demo_login.txt");
            }
            header("Location:" .TOP_PAGE_H); //top.php������
        //FC�桼���ξ��
        }elseif($fc_head_flg == "fc"){
            if($demo_flg === true){
                shell_exec("echo �����å�ID��".$staff_id.",�������å�̾��".$staff_name." >> /tmp/demo_login.txt");
            }
            header("Location:" .TOP_PAGE_F); //top.php������
        }
        
        exit;

    //�ѥ�������(���פ��ʤ����)
    }else{
        $error_mes  = "<font color=red><b>";
        $error_mes .= "�֥�����ID�� �⤷���� �֥ѥ���ɡ� ������������ޤ���<br>";
        $error_mes .= "�⤦�������Ϥ�ľ���Ƥ���������<br>";
        $error_mes .= "</b></font>";
    }

    //DB����
    Db_Disconnect($db_con);

}



/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header("$page_title");

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();


//HTML****************************************/


$sys_title = IMAGE_DIR ."sys_title.gif";
$login = IMAGE_DIR ."login.gif";
$company_rogo = IMAGE_DIR ."company_rogo.gif";

echo <<<PRINT_HTML_SRC

$html_header 

<style type='text/css'>
</style>

<body onLoad="document.login.login_id.focus()">

<table border="0" width="100%" height="100%">
<tr>
  <td valign="middle" align="center">
    <table  align="center" valign="middle" border="0">
     <tr>
     <td align="center"><b><font color="red">$warning</font></b></td>
     </tr>
     <tr>
      <td VALIGN="middle">
      <form enctype="multipart/form-data" name="login" action="$_SERVER[PHP_SELF]" method="post">
      <center>

      <img src="$sys_title">
      <br>
      <table border="0" width="470" height="190" style="background: url($login)" no-repeat><tr><td>
      <table border="0" align="center">
      <tr>
        <td><font color="#FFFFFF">������ID</font></td>
        <td><input type="text" name="login_id" value="" maxlength="15" style="width:140px; height=20; ime-mode: disabled;" $g_form_option></td>
      </tr>

      <tr>
        <td><font color="#FFFFFF">�ѥ����</font></td>
        <td><input type="password" name="password" value="" maxlength="15" style="width:140px; height=20; ime-mode: disabled;" $g_form_option></td>
      </tr>

      <tr>
        <td colspan="2" align="right"><input type="submit" name="submit" value="������" $disabled></td>
      </tr>
      </table>
      </td></tr></table>

      <div>$error_mes</div>
      <div>Amenity Network Do.system 2010<br></div>
      <div>$g_sys_version<br><br><br></div>
      <div><img src=$company_rogo></div>
      </center>
      </form>
    </td>
  </tr>
<!--
  <tr>
    <td align="center">
        <b><font color="red">��</font>���ƥʥ󥹤Τ���<font size="5" color="red">12:00��13:00��20:00��21:00</font>�δ֤ϡ������ӥ�����ߤ�����ĺ���ޤ���
    </td>
  </tr>
  <tr>
    <td>
    <b>�����ؤ򤪤����������ޤ����������ϤΤۤɡ���������ꤤ�������ޤ���</b></td>
    </td>
  </tr>
-->
  </table>

  </td>
</tr>
</table>

</body>
</html>

PRINT_HTML_SRC;

?>
