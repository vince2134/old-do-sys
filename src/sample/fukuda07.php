<?php

/**************************************************/
// ������� Smarty
/**************************************************/
// �Ķ�����ե��������
require_once("ENV_local.php");
// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
// DB��³����
$db_con = Db_Connect();


/**************************************************/
// ������� ����
/**************************************************/
// ���
$src_path = "/usr/local/apache2/htdocs/amenity";

// �������
$search_path["src"]["head"]["sale"]             = null;
$search_path["src"]["head"]["buy"]              = null;
$search_path["src"]["head"]["stock"]            = null;
$search_path["src"]["head"]["renew"]            = null;
$search_path["src"]["head"]["analysis"]         = null;
$search_path["src"]["head"]["system"]           = null;
$search_path["src"]["head"]["dialog"]           = null;
$search_path["src"]["franchise"]["sale"]        = null;
$search_path["src"]["franchise"]["buy"]         = null;
$search_path["src"]["franchise"]["stock"]       = null;
$search_path["src"]["franchise"]["renew"]       = null;
$search_path["src"]["franchise"]["analysis"]    = null;
$search_path["src"]["franchise"]["system"]      = null;
$search_path["src"]["franchise"]["dialog"]      = null;
$search_path["function"]                        = null;
$search_path["js"]                              = null;
$search_path["cron"]                            = null;
$search_path["include"]                         = null;
$search_path["config"]                          = null;
$search_path["css"]                             = null;

// ���������ꥹ��
// �⥸�塼����
$cutout_mod = array(
    "old",
    "bak",
    "org",
    "ENV_local",
    "test",
    "sample",
);
// �ؿ���ؤ���
$cutout_fnc = array(
    ".old",
    ".bak",
    "OLD",
);

// ���顼��å�������
$ary_err_msg = array(
    // �ե�����̤���򥨥顼1
    "no_select_src" => array(
        "�ե���������򤷤Ƥ���������",
        "�ե���������򤷤Ƥ���������",
        "�ե���������򤷤Ƥ���������",
        "�ä��硢�ե��������򤷤󤵤��䡣",
        "Ⱦǯ���äƤ�",
    ),
    // �ե�����̤���򥨥顼2
    "no_select_tpl" => array(
        "�ƥ�ץ졼�ȤΤʤ��ե����뤬���򤵤�Ƥ��ޤ���",
        "�ƥ�ץ졼�ȤΤʤ��ե����뤬���򤵤�Ƥ��ޤ���",
        "�ƥ�ץ�ʤ��衣",
    ),
    // ���������򥨥顼
    "no_random" => array(
        "����Ϥʤ��",
        "�Ĥޤ�͡�",
    ),
);

// �ܥ���disabled����
$quick_btn_disabled     = ($_POST["form_quick"] != null || $_POST["form_commit"] != null) ? "disabled" : "";
$back_btn_disabled      = ($_POST["form_quick"] == null) ? "disabled" : "";
$commit_btn_disabled    = ($_POST["form_quick"] == null) ? "disabled" : "";

// �ǥե������
$def_data["form_src_tpl"] = "2";
$form->setDefaults($def_data);


/**************************************************/
// �ؿ�
/**************************************************/
// �������NULL�Ԥ����
function Unnull_Array($ary){
    foreach ($ary as $key => $value){
        ($value != null) ? $ary_unnull[] = $value : null;
    }
    return $ary_unnull;
}

// �����ꥹ�Ȥ˥ޥå�����Ԥ����
function Cutout_Array($ary, $cutout){
    foreach ($ary as $ary_key => $ary_value){
        $cut_flg = false;
        foreach ($cutout as $cut_key => $cut_value){
            if (strstr($ary_value, $cut_value) && $cut_flg != true){
                $cut_flg = true;
                break;
            }
        }
        if ($cut_flg == true){
            break;
        }
        $ary_cut[] = $ary_value;
    }
    return $ary_cut;
}

// �ե�����ѥ��򸵤˥ƥ�ץ�ѥ������
function Make_Tpl_Path($ary){
    foreach ($ary as $key => $value){
        $file_name = substr(strrchr($value, "/"), 1);
        $ary_tpl_path[] = str_replace($file_name, "templates/$file_name.tpl", $value);
    }
    return $ary_tpl_path;
}

// �ե�����ѥ��򸵤˥ǥ�ѥ������
function Make_Demo_Path($ary){
    foreach ($ary as $key => $value){
//        $ary_demo_path[] = str_replace("/amenity/", "/demo/amenity/", $value);
        $ary_demo_path[] = str_replace("/amenity/", "/fukuda/amenity013101/", $value);
    }
    return $ary_demo_path;
}

// �ե�����ѥ�����ե�����̾�����֤ä�ȴ��
function Clip_File_Name($ary){
    foreach ($ary as $key => $value){
        $ary_file_name[] = substr(strrchr($value, "/"), 1);
    }
    return $ary_file_name;
}


/**************************************************/
// �ե�����ѥ�����
/**************************************************/
foreach ($search_path as $key1 => $value1){
    // �⥸�塼��
    if (is_array($value1)){
        // ������FC�ǥ롼��
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                // ��ʬ�ǥ롼��
                foreach ($value2 as $key3 => $value3){
                    // �ѥ��������ޥ��
                    $cmd[$key1][$key2][$key3] = "ls -l $src_path/$key1/$key2/$key3/*.php | awk '{print $9}'";
                    // ���ޥ�ɼ¹�
                    $src_file_path[$key1][$key2][$key3] = explode("\n", shell_exec($cmd[$key1][$key2][$key3]));
                    // NULL�Ԥ����
                    $src_file_path[$key1][$key2][$key3] = Unnull_Array($src_file_path[$key1][$key2][$key3]);
                    // �����ꥹ�Ȥ˥ޥå�����Ԥ����
                    $src_file_path[$key1][$key2][$key3] = Cutout_Array($src_file_path[$key1][$key2][$key3], $cutout_mod);
                    // �ƥ�ץ�ѥ�����
                    $src_file_path_tpl[$key1][$key2][$key3] = Make_Tpl_Path($src_file_path[$key1][$key2][$key3]);
                    // �ǥ�ѥ�����
                    $dst_file_path[$key1][$key2][$key3] = Make_Demo_Path($src_file_path[$key1][$key2][$key3]);
                    // �ǥ�ƥ�ץ�ѥ�����
                    $dst_file_path_tpl[$key1][$key2][$key3] = Make_Tpl_Path($dst_file_path[$key1][$key2][$key3]);
                }
            }
        }
    // �ؿ���ؤ�
    }else{
        // �ѥ��������ޥ��
        $cmd[$key1] = "ls -l $src_path/$key1/*.* | awk '{print $9}'";
        // ���ޥ�ɼ¹�
        $src_file_path[$key1] = explode("\n", shell_exec($cmd[$key1]));
        // NULL�Ԥ����
        $src_file_path[$key1] = Unnull_Array($src_file_path[$key1]);
        // �����ꥹ�Ȥ˥ޥå�����Ԥ����
        $src_file_path[$key1] = Cutout_Array($src_file_path[$key1], $cutout_fnc);
        // �ǥ�ѥ�����
        $dst_file_path[$key1] = Make_Demo_Path($src_file_path[$key1]);
    }
}


/**************************************************/
// ����λ�ܥ��󲡲����ν���
/**************************************************/
if ($_POST["form_quick"] != null){

    // �������ǥ롼��
    foreach ($search_path as $key1 => $value1){
        // �⥸�塼��
        if (is_array($value1)){
            // ������FC�ǥ롼��
            foreach ($value1 as $key2 => $value2){
                if (is_array($value2)){
                    // ��ʬ�ǥ롼��
                    foreach ($value2 as $key3 => $value3){
                        // ���쥯�ȥܥå��������򤬤�����
                        if ($_POST["form_".$key2."_".$key3] != null){
                            // �����������쥯�ȥܥå����ǥ롼��
                            foreach ($_POST["form_".$key2."_".$key3] as $post_key => $post_value){
                                // �������򥢥åפ�����
                                if ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2"){
                                // ���򤵤줿/���åפ���ͽ��� �ե�����ѥ����ѿ�������
                                    $select_src_file[] = $src_file_path[$key1][$key2][$key3][$post_value];
                                    $upload_dst_file[] = $dst_file_path[$key1][$key2][$key3][$post_value];
                                }
                                // �ƥ�ץ�򥢥åפ�����
                                if ($_POST["form_src_tpl"] == "3"){
                                    // ���򤵤줿/���åפ���ͽ��� �ե�����ѥ����ѿ�������
                                    $select_src_file_tpl[] = $src_file_path_tpl[$key1][$key2][$key3][$post_value];
                                    $upload_dst_file_tpl[] = $dst_file_path_tpl[$key1][$key2][$key3][$post_value];
                                }
                            }
                        }
                    }
                }
            }
        // �ؿ���ؤ�
        }else{
            // ���쥯�ȥܥå��������򤬤���ܥ������򥢥åפ�����
            if ($_POST["form_".$key1] != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
                // �����������쥯�ȥܥå����ǥ롼��
                foreach ($_POST["form_".$key1] as $post_key => $post_value){
                    // ���򤵤줿/���åפ���ͽ��� �ե�����ѥ����ѿ�������
                    $select_src_file[] = $src_file_path[$key1][$post_value];
                    $upload_dst_file[] = $dst_file_path[$key1][$post_value];
                }
            }
        }
    }

    /* ���顼�����å� */
    // ����̵�����ʥե�����ѥ��ѿ�����������Ƥ��ʤ�����
    if ($select_src_file == null && $select_src_file_tpl == null){
        $no_select_err_msg = $ary_err_msg["no_select_src"][array_rand($ary_err_msg["no_select_src"])];
        $err_flg = true;
    }

    /* ���顼�����å� */
    // �����२�顼
    if ($_POST["form_src_tpl"] == "4" && $err_flg != true){
        $no_random_err_msg = $ary_err_msg["no_random"][array_rand($ary_err_msg["no_random"])];
        $err_flg = true;
    }

    // ���顼��������λ�ܥ����enabled������
    $quick_btn_disabled     = ($err_flg == true) ? "" : "disabled";
    // ��뤹��ܥ���disabled����
    $back_btn_disabled      = ($err_flg == true) ? "disabled" : "";
    // ���åפ���ܥ���disabled����
    $commit_btn_disabled    = ($err_flg == true) ? "disabled" : "";

    // ���򤵤줿/���åפ���ͽ��� �ե�����ѥ���hidden�˥��å�
    if ($select_src_file != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
        foreach ($select_src_file as $key => $value){
            $hdn_set["src_file_path[$key]"] = $value;
        }
    }
    if ($upload_dst_file != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
        foreach ($upload_dst_file as $key => $value){
            $hdn_set["dst_file_path[$key]"] = $value;
        }
    }
    if ($select_src_file_tpl != null && $_POST["form_src_tpl"] == "3"){
        foreach ($select_src_file_tpl as $key => $value){
            $hdn_set["src_file_path_tpl[$key]"] = $value;
        }
    }
    if ($upload_dst_file_tpl != null && $_POST["form_src_tpl"] == "3"){
        foreach ($upload_dst_file_tpl as $key => $value){
            $hdn_set["dst_file_path_tpl[$key]"] = $value;
        }
    }
    $form->setConstants($hdn_set);


}


/**************************************************/
// ���åפ���ܥ��󲡲����ν���
/**************************************************/
if ($_POST["form_commit"] != null){

    // POST���줿�ե�����ѥ����饳�ޥ�ɺ���
    if ($_POST["src_file_path"] != null){
        foreach ($_POST["src_file_path"] as $key => $value){
            $upload_cmd[] = "cp -fp ".$value." ".$_POST["dst_file_path"][$key];
        }
    }
    if ($_POST["src_file_path_tpl"] != null){
        foreach ($_POST["src_file_path_tpl"] as $key => $value){
            $upload_cmd[] = "cp -fp ".$value." ".$_POST["dst_file_path_tpl"][$key];
        }
    }

    // ���ޥ�ɼ¹�
    foreach ($upload_cmd as $key => $value){
        // ���������׸塢���ޥ�ɼ¹�
        $result = shell_exec(escapeshellcmd($value));
print_array($result);

    }
print_array($upload_cmd);
//print_array($result);
        

}


/**************************************************/
// �ե��������
/**************************************************/
// �������ǥ롼��
foreach ($search_path as $key1 => $value1){
    if (is_array($value1)){
        // ������FC�ǥ롼��
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                // ��ʬ�ǥ롼��
                foreach ($value2 as $key3 => $value3){
                    $select_value = "";
                    $select_value = Clip_File_Name($src_file_path[$key1][$key2][$key3]);
                    $option = "multiple size=\"15\" style=\"width: 120px;\"";
                    $commit_freeze[] = $form->addElement("select", "form_".$key2."_".$key3, "", $select_value, $option);
                    $form->addElement("hidden", "hdn_select[$key1][$key2][$key3]", "", $select_value, $option);
                }
            }
        }
    }else{
        $select_value = "";
        $select_value = Clip_File_Name($src_file_path[$key1]);
        $option = "multiple size=\"10\" style=\"width: 120px;\"";
        $commit_freeze[] = $form->addElement("select", "form_".$key1, "", $select_value, $option);
        $form->addElement("hidden", "hdn_select[$key1]", "", $select_value, $option);
    }
}

// �ƥ�ץ������å�
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�������ȥƥ�ץ�", "1");
$radio[] =& $form->createElement("radio", null, null, "���䤤�䡢����������", "2");
$radio[] =& $form->createElement("radio", null, null, "�ष��ƥ�ץ����", "3");
$radio[] =& $form->createElement("radio", null, null, "���㤢�����ޤ�����", "4");
$commit_freeze[] = $form->addGroup($radio, "form_src_tpl", "", "<br>");

// �Ȥꤢ��������ǥܥ���
$form->addElement("submit", "form_quick", "����λ", $quick_btn_disabled);

// ���ܥ���
$form->addElement("button", "form_back", "������", $back_btn_disabled." onClick=\"history.back();\"");

// ���åפ����ܥ���
$form->addElement("submit", "form_commit", "���åפ���", $commit_btn_disabled);

// �ǽ餫����ľ���ܥ���
$form->addELement("button", "form_clear", "�ǽ�����", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// hidden ���åפ��븵�ե�����
if ($select_src_file != null){
    foreach ($select_src_file as $key => $value){
        $form->addElement("hidden", "src_file_path[$key]", "", "");
    }
}

// hidden ���åפ�����ե�����
if ($upload_dst_file != null){
    foreach ($upload_dst_file as $key => $value){
        $form->addElement("hidden", "dst_file_path[$key]", "", "");
    }
}

// hidden ���åפ��븵�ե����� �ƥ�ץ�
if ($select_src_file_tpl != null){
    foreach ($select_src_file_tpl as $key => $value){
        $form->addElement("hidden", "src_file_path_tpl[$key]", "", "");
    }
}

// hidden ���åפ�����ե����� �ƥ�ץ�
if ($upload_dst_file_tpl != null){
    foreach ($upload_dst_file_tpl as $key => $value){
        $form->addElement("hidden", "dst_file_path_tpl[$key]", "", "");
    }
}

// ����λ�ܥ��󲡲��ܥ��顼̵����
if (($_POST["form_quick"] != null || $_POST["form_commit"]) && $err_flg != true){
    // �ե꡼������
    $commit_freeze_form = $form->addGroup($commit_freeze, "commit_freeze", "");
    $commit_freeze_form->freeze();
}


/**************************************************/
// html����
/**************************************************/
$html  = "";
$html  = "<table border=\"0\" style=\"font-size: 11px;\">\n";
$html .= "  <tr valign=\"top\">\n";
foreach ($search_path as $key1 => $value1){
    if (is_array($value1)){
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                foreach ($value2 as $key3 => $value3){
$html .= "      <td style=\"padding-right: 5px; padding-bottom: 10px;\">\n";
$html .= "          <b>".$key2."/".$key3."</b><br>\n";
$html .=            $form->_elements[$form->_elementIndex["form_".$key2."_".$key3]]->toHtml()."\n";
$html .= "      </td>\n";
                }
            }
$html .= "  </tr>\n";
$html .= "  <tr valign=\"top\">\n";
        }
    }else{
$html .= "      <td>\n";
$html .= "          <b>".$key1."</b><br>\n";
$html .=            $form->_elements[$form->_elementIndex["form_".$key1]]->toHtml()."\n";
$html .= "      </td>\n";
    }
}
$html .= "  </tr>\n";
$html .= "</table>\n";


/**************************************************/
// Smarty
/**************************************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);
// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());
// ����¾���ѿ���assign
$smarty->assign("html", $html);
$smarty->assign("err", array(
    "no_random_err_msg"     => $no_random_err_msg,
    "no_select_err_msg"     => $no_select_err_msg,
));
// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
