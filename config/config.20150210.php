<?php
#=======================================#
# �Ķ�����ե�����                      #
#=======================================#


/****************************
�����ƥ��Ϣ
****************************/
//��������ʸ��������
$g_src_charset        = "EUC-JP";
//�С���������
$g_sys_version        = "Revision 1.6.0";

/****************************
DB��Ϣ
****************************/
$g_db_host = "127.0.0.1";   //localhost
$g_db_name = "amenity_demo_new";
//$g_db_port = "5432";
$g_db_port = "5433";

/****************************
HTML��Ϣ
****************************/
$g_html_charset       = "EUC-JP";
$g_html_title         = "�ǥ�";
$g_html_bgcolor       = "#FFFF66";
$g_html_font          = "";
$g_html_font_size     = "18";
$g_html_font_color    = "";
$g_text_readonly      = "readonly";

/****************************
JAVASCRIPT��Ϣ
****************************/
//$g_form_option = "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\""; //�ƥ�����������
//$g_form_option_select = "onChange =\"window.focus();\""; //���쥯�ȥܥå�����
    
$g_form_option          = "onKeyDown=\"chgKeycode();\" onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\""; //�ƥ�����������
$g_form_option_area     = "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"";                             //�ƥ����ȥ��ꥢ������
$g_form_option_select   = "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();\"";                      //���쥯�ȥܥå�����
$g_form_style           = "ime-mode: disabled;";                                                            //IME�ξ��֤�Ⱦ�ѱѿ����ˤ���
$g_button_color         = "style=\"background-color:#FDFD88; font-weight:bold;\"";                          //button�ο�

/****************************
PATH��Ϣ
****************************/
//���Ѥ��Ƥ��ʤ�
$g_top_page       = PATH ."src/index.php";

//�֥饦����������ѽ����褦�˥ڡ����򥭥�å��夹��
// private�����ꤹ�뤳�� ���ǽ�ǡ����ξ�硢�ץ���������å��夹�뤳�Ȥϵ���
session_cache_limiter('private, must-revalidate');

//���å���󳫻�
session_start();

/****************************
mail
****************************/
//���顼���Τ��밸��
$g_error_add = "amano@xyn.jp";
//$g_error_add = "morita-d@bhsk.co.jp,suzuki-t@bhsk.co.jp";
//$g_error_add = "suzuki-t@bhsk.co.jp";

//���� ON/OFF
$g_error_mail = true;

/****************************
���ƥʥ����إե饰
*****************************/
$g_mente_mode = false;          //������Ǥ���
#$g_mente_mode = true;         //������Ǥ��ʤ�

?>
