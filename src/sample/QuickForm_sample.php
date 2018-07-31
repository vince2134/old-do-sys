<?php

require_once "HTML/QuickForm.php";

//HTML_QuickForm���֥�����������
$form =& new HTML_QuickForm( "test_form","POST","",null,null,true);
$form->addElement("header", "title", "�إå��������ȥ�");

//�˥å��͡���
$form->addElement("text","nick_name","�˥å��͡��ࡧ",'size="40"');

//����
$sex[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$sex[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$form->addGroup( $sex, "sex", "���̡�");

//ǯ��
$age[] =& $form->createElement( "radio",NULL,NULL,"10��","1");
$age[] =& $form->createElement( "radio",NULL,NULL,"20��","2");
$age[] =& $form->createElement( "radio",NULL,NULL,"30��","3");
$age[] =& $form->createElement( "radio",NULL,NULL,"40��","4");
$age[] =& $form->createElement( "radio",NULL,NULL,"50��","5");
$age[] =& $form->createElement( "radio",NULL,NULL,"60��ʾ�", "6");
$form->addGroup( $age, "age", "ǯ��");

//����
$job[] =& $form->createElement( "radio",NULL,NULL,"����","1");
$job[] =& $form->createElement( "radio",NULL,NULL,"���","2");
$job[] =& $form->createElement( "radio",NULL,NULL,"���Ķ�", "3");
$job[] =& $form->createElement( "radio",NULL,NULL,"����","4");
$job[] =& $form->createElement( "radio",NULL,NULL,"�ե꡼����", "5");
$job[] =& $form->createElement( "radio",NULL,NULL,"̵��","6");
$form->addGroup( $job,"job","���ȡ�");

//��ƻ�ܸ�
$ken_arr = array(
 toukyou => "���",
 oosaka  => "���",
 fukuoka => "ʡ��",
);
$form->addElement('select', 'ken', '��ƻ�ܸ�', $ken_arr);

//�᡼�륢�ɥ쥹
$form->addElement( "text", "mail_address", "�᡼�륢�ɥ쥹��",array('size'=>40));

//���٥᡼���ɥ쥹
$form->addElement( "text", "mail_address2", "�᡼�륢�ɥ쥹��ǧ��",array('size'=>40));

//�����Ǥ�trim�ե��륿����Ŭ��
$form->applyFilter('__ALL__','trim');


//�ǥե�����ͤ�����
$def = array(
    "nick_name"     => "�˥å��͡���",
    "sex"     => "1",
    "age"     => "2",
    "job"     => "2",
    "ken"     => "oosaka",
);
$form->setDefaults($def);
        

//��ʸ�������å�
$form->addRule( "nick_name", "�˥å��͡�������Ϥ��Ʋ�������", "required", NULL, "client");
$form->addRule( "sex", "���̤����򤵤�Ƥ��ޤ���","required", NULL, "client");
$form->addRule( "age", "ǯ�����򤵤�Ƥ��ޤ���","required", NULL, "client");
$form->addRule( "job", "���Ȥ����򤵤�Ƥ��ޤ���","required", NULL, "client");
$form->addRule( "ken", "��ƻ�ܸ������򤵤�Ƥ��ޤ���","required", NULL, "client");
$form->addRule( "mail_address", "�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������", "required", NULL, "client");
$form->addRule( "mail_address2", "�᡼�륢�ɥ쥹��ǧ�����Ϥ��Ʋ�������", "required", NULL, "client");


//�ޥ���Х��Ȥ�ʸ���������å����ɲ�
$form->registerRule("mb_maxlength","function","mb_maxlength_hoge");
function mb_maxlength_hoge( $val1, $val2, $val3 ) {
  if ( mb_strlen( $val2, "EUC-JP") <= $val3 ) return true;
  return false;
} 

//���ƥ����å�
$form->addRule( "nick_name", "�˥å��͡�������Ѥ�1����10ʸ���ޤǤǤ���",  "mb_maxlength","10");
$form->addRule( "mail_address", "�᡼�륢�ɥ쥹��Ⱦ�Ѥ�1����50ʸ���ޤǤǤ���", "rangelength", array(1,50),"client");
$form->addRule( "mail_address2", "�᡼�륢�ɥ쥹��Ⱦ�Ѥ�1����50ʸ���ޤǤǤ���", "rangelength", array(1,50),"client");
$form->addRule( "mail_address", "�᡼�륢�ɥ쥹�Ȥ������������ϤǤ���", "email", NULL, "client");
$form->addRule( "mail_address2", "�᡼�륢�ɥ쥹�Ȥ������������ϤǤ���", "email", NULL, "client");
$form->addRule( array("mail_address","mail_address2"),"�᡼�륢�ɥ쥹�ȥ᡼�륢�ɥ쥹��ǧ�����פ��ޤ���","compare", NULL, "client");

//���顼��å����������ܸ�������ѹ�
$form->setRequiredNote('
�ʢ��ˤ��������ˤ��٤Ʋ����塢��ǧ���̤ؤȤ��ʤ߲�������(<font color="#ff0000">*ɬ�ܹ���</font>)');
$form->setJsWarnings("�ʲ������ϥ��顼������ޤ���\n","\n���١����Ϲ��ܤ��ǧ���Ʋ�����");

//����
if($form->validate()){
    $form->freeze();
    $botton =& $form->addElement("link","back","","$_SERVER[PHP_SELF]","��Ͽ���̤����");

}else{
    //���������åȥܥ��������
    $botton[] =& $form->createElement("submit","send","��ǧ���̤�");
    $botton[] =& $form->createElement("reset","clear","�ꥻ�å�");
    $form->addGroup( $botton, "btn", "");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <title>PEAR HTML_QuickForm</title>

</head>
<body>
<?php 
$form->display(); 
print_r($_POST)
?>
</body>
</html>
