<?php

require_once "HTML/QuickForm.php";
//$_POST[f_hidden]="�ݥ��Ƚ񤭴���";

$_POST[f_hidden]="�ݥ��Ƚ񤭴���";



//HTML_QuickForm������
$form =& new HTML_QuickForm( "test_form","POST","",null,null,true);



//�᡼�륢�ɥ쥹
$form->addElement( "hidden", "f_hidden", "");



    //���������åȥܥ��������
    $botton[] =& $form->createElement("submit","send","��ǧ���̤�");
    $botton[] =& $form->createElement("reset","clear","�ꥻ�å�");
    $form->addGroup( $botton, "btn", "");

print_r($_POST);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<!--��-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <title>PEAR HTML_QuickForm</title>

</head>
<body>
<?php $form->display(); ?>
</body>
</html>
