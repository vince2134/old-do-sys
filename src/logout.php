<?php
$page_title="��������";

// �Ķ�����ե������ɤ߹���
require_once("ENV_local.php");

// ���å������˴�����
session_start();
session_unset();
session_destroy();

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header("$page_title");

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

//HTML****************************************/

echo "

$html_header

<body>
<style type='text/css'>
table{
    color: #ffffff;
}
a{
    color: #ffffff;
}
</style>

<!---------------------- ���̥����ȥ�ơ��֥� --------------------->

<table border='0' width='90%' height='90%' align='center'>
<tr><td valign='middle' align='center'>

   <table border='0' width='480' height='350'>
    <tr bgcolor='#213B82' align='center' valign='middle'>
     <td>
        <font size='5'><b>����˥������Ȥ��ޤ���</b></font><br><br><br>
        <img src='".IMAGE_DIR."do_amenity3.gif'><br><br><br>
		<a href='".LOGIN_PAGE."'>�⤦���٥����󤹤����<br>�����򥯥�å����Ƥ�������</a>
     </td>
    </tr>
   </table>

</td></tr></table>

$html_footer
";
?>
