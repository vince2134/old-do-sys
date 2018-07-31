<?php

class Analysis_ABC{

    public $abc_array;         //£Á£Â£Ã
    public $disp_data;        //É½¼¨¥Ç¡¼¥¿

    /**
    * £Á£Â£ÃÊ¬ÀÏ¥¯¥é¥¹¥³¥ó¥¹¥È¥é¥¯¥¿
    * £Á£Â£Ã¤ÎÈæÎ¨¤òÀßÄê
    *
    *
    * ÊÑ¹¹ÍúÎò
    * 2007-11-18   watanabe-k    ¿·µ¬ºîÀ®
    *
    */
    function __construct(){
        // ABCÈæÎ¨
        $this->abc_array = array("A" => 70, "B" => 90, "C" => 100);
    }


    /**
    * £Á£Â£ÃÊ¬ÀÏ ½¸·×ÍÑ´Ø¿ô(²¾¡Ë
    *
    * ÊÑ¹¹ÍúÎò<br>
    * 2007-11-16   aizawa-m    ¿·µ¬ºîÀ®<br>
    * 2007-11-24   aizawa-m    ¶èÊ¬¤ÎÇØ·Ê¿§¤ò¡¢disp_data["bgcolor"]¤È¤·¤ÆÄÉ²Ã<br>
    * 2007-11-24   aizawa-m    Çä¾å¶â³Û¹ç·×¤¬0¤Î¾ì¹ç¤Ï¡¢¹½À®Èæ¡¦ÎßÀÑ¶â³Û¡¦ÎßÀÑ¹½À®Èæ¤Î½èÍý¤ò¤·¤Ê¤¤¤è¤¦IFÊ¬¤ÎÄÉ²Ã<br>
    * 2007-12-02   aizawa-m    ABC¤Û¤²¤Ô¤èÍÑ¤ËforÊ¸¤Î¥ë¡¼¥×²ó¿ô¤ò»ØÄê¤Ç¤­¤ë¤è¤¦ÊÑ¹¹(°ú¿ôÄÉ²Ã)<br>
    *
    * ¢¨Ãí°Õ<br>
    * ¡ÖÉ½¼¨ÂÐ¾Ý¡×¤Î¡Ö¶â³Û0°Ê³°¡×¤Ï¡¢¥¯¥¨¥ê¤Ç½èÍý¤¹¤ë
    *
    * @param   $start       int       ¥ë¡¼¥×¤Î³«»ÏÍ×ÁÇÈÖ¹æ
    * @param   $end         int       ¥ë¡¼¥×¤Î½ªÎ»Í×ÁÇÈÖ¹æ
    *
    */
    function Set_ABC_Data ($start=NULL, $end=NULL) {
/*
        »²¹ÍURL: http://www.atmarkit.co.jp/aig/04biz/abcanalysis.html
*/

        $sum_sale = $this->sum_sale;

        //½é´ü²½
        $a_span = 0;
        $b_span = 0;
        $c_span = 0;
        $accumulated_sale   = 0;
        $accumulated_rate   = 0;
        $sale_rate_2decimal = 0;

#    print_array($this->disp_data);
#    exit;

        // 2007-12-02 aizawa-m  ÄÉ²Ã
        //-- °ú¿ô¤¬»ØÄê¤·¤Æ¤Ê¤¤¾ì¹ç
        if ($start == NULL) {
            // ½é¤á¤«¤é
            $start  = 0;
        }
        if ($end == NULL)  {
            // ºÇ½ªÍ×ÁÇÈÖ¹æ
            $end = count($this->disp_data) - 1;
        }

        // 2007-12-02 aizawa-m  ÊÑ¹¹
        // foreach¤«¤éfor¤Ø
        //foreach($this->disp_data AS $i => $val) {
        for ($i = $start; $i <= $end; $i++) {

            // ¥ì¥³¡¼¥É¤òÊÑ¿ô¤Ë
            $val    = $this->disp_data[$i];

            if($val["cd"] == null){
                continue;
            }

            //------------------------//
            // ABCÊ¬ÀÏ¥Ç¡¼¥¿¤Î»»½Ð
            //------------------------//

            // 2007-11-24_aizawa-m ÄÉ²Ã
            //-- Çä¾å¶â³Û¤Î¹ç·×¤¬0°Ê³°¤Î¾ì¹ç(³ä¤ê»»¤ÇÊ¬Êì¤¬0¤À¤ÈWarning¤¬½Ð¤ë¡Ë
            if ( $sum_sale != 0 ) {

                // ¶â³Û¤òÊÑ¿ô¤ËÂåÆþ
                $sale       = $val["net_amount"];

                //-- ¹½À®Èæ¤Î·×»»
                //  ¾¯¿ôÂè2°Ì¤òround¤¹¤ë¤È»Í¼Î¸ÞÆþ¤µ¤ì¤Ê¤¤¾ì¹ç¤¬¤¢¤ë¤Î¤Ç¡¢À°¿ôÃÍ¤ËÊÑ´¹¤·round¤¹¤ë
                // ¤½¤Î¤¿¤á¤µ¤é¤Ë100¤ò¤«¤±¤Æ¤¤¤ë
                $sale_rate  = round( ($sale / $sum_sale)*100*100);

                // $sale_rate / 100 ¤ò¹Ô¤Ã¤¿¾ì¹ç¡¢¾¯¿ôÂè£²°Ì¤òround¤·¤¿·ë²Ì¤¬É½¼¨¤µ¤ì¤Æ¤·¤Þ¤¦¤¿¤á
                //number_format¤ò¹Ô¤¦
                //php5¤«¤é»²¾ÈÅÏ¤·¤µ¤ì¤Æ¤¤¤ë¤¿¤á
                $sale_rate_2decimal = number_format( $sale_rate /100 ,2 ,"." ,"" );

                //-- ÎßÀÑ¶â³Û
                $accumulated_sale += $sale;

                //-- ÎßÀÑ¹½À®Èæ
                $accumulated_rate = number_format(($accumulated_rate + $sale_rate_2decimal) ,2 ,"." ,"" );
            }

            //³Æ¶èÊ¬Ëè¤Î·ï¿ô¤È²èÌÌ¤ËÉ½¼¨¤¹¤ë¶èÊ¬¤òÀßÄê
            //-- ¶èÊ¬È½Äê
            if ( $accumulated_rate < $this->abc_array["A"] ) {
                //A¤Î°ì¹ÔÌÜ
                if($a_span == 0){
                    $this->disp_data[$i]["rank"] = "A";
                    $this->disp_data[$i]["rank_rate"] = "¡Ê0%¡Á" .$this->abc_array["A"] . "%¡Ë";
                    $a_span = &$this->disp_data[$i]["span"];
                    // ¶èÊ¬¤ÎÇØ·Ê¿§¤òÊÑ¹¹¤¹¤ë 2007-11-24_aizawa-m
                    $this->disp_data[$i]["bgcolor"] = "#a8d3ff";
                }
                ++$a_span;
            }elseif ( $accumulated_rate < $this->abc_array["B"] ) {
                //£Â¤Î°ì¹ÔÌ¾
                if($b_span == 0){
                    $this->disp_data[$i]["rank"] = "B";
                    $b_span = &$this->disp_data[$i]["span"];
                    $this->disp_data[$i]["rank_rate"] = "¡Ê" . $this->abc_array["A"] . "%¡Á" .$this->abc_array["B"] . "%¡Ë";
                    // ¶èÊ¬¤ÎÇØ·Ê¿§¤òÊÑ¹¹¤¹¤ë 2007-11-24_aizawa-m
                    $this->disp_data[$i]["bgcolor"] = "#ffffa8";
                }
                ++$b_span;
            }else {
                //£Ã¤Î°ì¹ÔÌÜ
                if($c_span == 0){
                    $this->disp_data[$i]["rank"] = "C";
                    $c_span = &$this->disp_data[$i]["span"];
                    $this->disp_data[$i]["rank_rate"] = "¡Ê" . $this->abc_array["B"] ."%¡Á" . $this->abc_array["C"] ."%¡Ë";
                    // ¶èÊ¬¤ÎÇØ·Ê¿§¤òÊÑ¹¹¤¹¤ë 2007-11-24_aizawa-m
                    $this->disp_data[$i]["bgcolor"] = "#ffa8d3";
                }
                ++$c_span;
            }

            //-----------------------//
            // ÇÛÎó¤Ë³ÊÇ¼
            //-----------------------//
            $this->disp_data[$i]["sale_rate"]        = $sale_rate_2decimal;
            //ÎßÀÑ¶â³Û
            $this->disp_data[$i]["accumulated_sale"] = $accumulated_sale;
            //ÎßÀÑ¹½À®Èæ
            $this->disp_data[$i]["accumulated_rate"] = $accumulated_rate;
        }
    }


    //--------------- ºîÀ®Ãæ-------------------//
    /**
     * ³µÍ× ABCÍÑ ½¸·×´Ø¿ôÍÑ¤Ë¥ê¥½¡¼¥¹¤òÇÛÎó¤ËÆþ¤ìÂØ¤¨¤ë´Ø¿ô
     *
     * ¢¨Ãí°Õ¡Ê²¾¡Ë
     * ­¡¥¯¥¨¥ê¤Ç¤Ï¡¢²¿¤«¤Î¥³¡¼¥É¤ò"cd"¡¢Ì¾Á°¤ò"name"¡Ä¤È¤·¤Æ¡¢¶â³Û¤ò"sale"¤Ç¼èÆÀ
     * ­¢Çä¾å¶â³Û¤Î¹ß½ç¤Ë¥ê¥½¡¼¥¹¤ò¼èÆÀ
     * ­£³ä¹ç¤â¥¯¥¨¥ê¤Ç¤È¤Ã¤Æ¤¯¤ë
     *
     * ÊÑ¹¹ÍúÎò
     * 2007-11-16   aizawa-m    ¿·µ¬ºîÀ®
     * 2007-11-18   watanabe-k  ¥ë¡¼¥×Ëè¤Ë¥ê¥½¡¼¥¹¤Ë¥¢¥¯¥»¥¹¤·¤Ê¤¤¤è¤¦¤Ë¡¢
     *                          pg_fetch_all¤ò»ÈÍÑ
     *
     */
    function Result_Change_Array($result) {

        //¥Ç¡¼¥¿·ï¿ô
        $count = pg_num_rows($result);

        //¥Ç¡¼¥¿·ï¿ô£°¤Î¾ì¹ç
        if($count === 0){
            //½¸·×ÂÐ¾Ý¥Ç¡¼¥¿
            $this->disp_data   = array();
            //Çä¾å¹ç·×¶â³Û
            $this->sum_sale    = 0;
            //É½¼¨·ï¿ô
            $this->disp_data[] = 0;
        }else{
            //½¸·×ÂÐ¾Ý¥Ç¡¼¥¿
            $this->disp_data = pg_fetch_all($result);

            //¹ç·×¶â³Û¤È½ç°Ì¤òÀßÄê
            $no = 0;
            foreach($this->disp_data AS $key => $val){
                ++$no;
                $this->disp_data[$key]["no"] = $no;
                $sum_sale += $val["net_amount"];

            }
            //É½¼¨·ï¿ô
            $this->disp_data[$key+1]["count"] = $count;
            $this->sum_sale = $sum_sale;
            $this->disp_data[$key+1]["sum_sale"] = $sum_sale;
        }

#    print_array($this);
#    exit;
    }
}



/**
 * ³µÍ×     ¥¯¥é¥¹¤ò·Ñ¾µ
 */
class Analysis_Hogepiyo_ABC extends Analysis_ABC {

    /**
     * ³µÍ×     ¤Û¤²¤Ô¤èÍÑ¥ª¡¼¥Ð¥é¥¤¥É - ¥ê¥½¡¼¥¹¤«¤éÉ½¼¨ÍÑ¥Ç¡¼¥¿¤òºîÀ®¤¹¤ë
     */
    function Result_Change_Array($result) {

        // ÊÑ¿ôÄêµÁ
        $count      = pg_num_rows($result);     // ¥Ç¡¼¥¿·ï¿ô
        $loop_last  = $count - 1;               // ¥Ç¡¼¥¿ºÇ½ª¹ÔÈÖ¹æ


        // ¥Ç¡¼¥¿·ï¿ô£°¤Î¾ì¹ç
        if ($count === 0) {

            //½¸·×ÂÐ¾Ý¥Ç¡¼¥¿
            $this->disp_data   = array();

            //Çä¾å¹ç·×¶â³Û
            $this->sum_sale    = 0;

            //É½¼¨·ï¿ô
            $this->disp_data[] = 0;

        // ¥Ç¡¼¥¿¤¬Â¸ºß¤¹¤ë¾ì¹ç
        }else{

            // ÊÑ¿ôÄêµÁ
            $hoge_no = 0;   // ¤Û¤²No.
            $piyo_no = 0;   // ¤Ô¤èNo.¡Ê½ç°Ì¡Ë
            $j       = 0;   // ¹ÔÈÖ¹æ¡ÊÅÓÃæ¤Ë¾®·×¤ò¶´¤à¤¿¤á¡¢¤³¤ì¤Ç¹Ô¤ò´ÉÍý¤¹¤ë¡Ë

            // ½¸·×ÂÐ¾Ý¥Ç¡¼¥¿¼èÆÀ
            $ary_all_data = pg_fetch_all($result);

            // ¥Ç¡¼¥¿¹Ô¿ô¤Ç¥ë¡¼¥×
            foreach ($ary_all_data as $i => $val) {

                ///// ÊÑ¿ôÄêµÁ
                {
                    // Á°²ó»²¾È¹Ô¤Î¤Û¤²¥³¡¼¥É¤òÊÑ¿ô¤Ë
                    $prev_hoge_cd   = $ary_all_data[$i - 1]["cd"];
                    // ¸½ºß»²¾È¹Ô¤Î¤Û¤²¥³¡¼¥É¤òÊÑ¿ô¤Ë
                    $this_hoge_cd   = $val["cd"];
                    // ¼¡²ó»²¾È¹Ô¤Î¤Û¤²¥³¡¼¥É¤òÊÑ¿ô¤Ë
                    $next_hoge_cd   = $ary_all_data[$i + 1]["cd"];

                    // ¸½ºß¤ÎÇä¾å¶â³Û¤òÊÑ¿ô¤Ë
                    $sale           = $val["net_amount"];
                    // Çä¾å¶â³Û¹ç·×¤ò²Ã»»¡Ê¹ç·×ÍÑ¡Ë
                    $sum_sale_all  += $sale;
                    $sum_sale_hoge += $sale;

                    // ¤Û¤²rowspan¤ò¥¤¥ó¥¯¥ê¥á¥ó¥È
                    $hoge_rowspan++;
                }

                ///// ¥ª¥Ö¥¸¥§¥¯¥È¤ØÃÍ¤ò³ÊÇ¼
                {
                    // ¾®·×¤ò²ÃÌ£¤·¤¿¹ÔÈÖ¹æ¤Ë¸½ºß»²¾È¤ÎÃÍ¤ò³ÊÇ¼¤¹¤ë
                    $this->disp_data[$j]            = $val;

                    // ¤Ô¤èNo.¡Ê½ç°Ì¡Ë¤òÀßÄê
                    $this->disp_data[$j]["piyo_no"] = ++$piyo_no;

                    // ¤Ô¤è¹Ô¿§¤ÎÈ½ÃÇÍÑ¡Ê´ñ¿ô1, ¶ö¿ô2¡Ë
                    $this->disp_data[$j]["sub_flg"] = ($this->disp_data[$j]["piyo_no"] % 2 != 0) ? "1" : "2";
                }

                ///// ¿·¤·¤¤¤Û¤²¤Ë¤Ê¤Ã¤¿¾ì¹ç
                // £±¹ÔÌÜ¤Þ¤¿¤Ï
                // ¸½ºß»²¾È¹Ô¤Î¤Û¤² != Á°²ó»²¾È¹Ô¤Î¤Û¤²
                if ($i == 0 || ($this_hoge_cd != $prev_hoge_cd)) {

                    // ¤Û¤²No.¤òÀßÄê
                    $this->disp_data[$j]["hoge_no"] = ++$hoge_no;

                    // ¤Ô¤è1¹ÔÌÜ¤Î³«»ÏID¤òÊÝ»ý
                    $start          = $j;

                    // ¤Û¤²¤ÎÇä¾å³Û¤ò½é´ü²½¡Ê¸½ºß»²¾È¤ÎÇä¾å³Û¡Ë
                    $sum_sale_hoge  = $sale;

                    // ¤Û¤²rowspan¤ò½é´ü²½(1)
                    $hoge_rowspan   = 1;

                }

                ///// º£¤Î¤Û¤²¤¬½ª¤ï¤ë¾ì¹ç
                // ºÇ½ª¹Ô¤Þ¤¿¤Ï
                // ¸½ºß»²¾È¹Ô¤Î¤Û¤² != ¼¡²ó»²¾È¹Ô¤Î¤Û¤²
                if ($i == $loop_last || ($this_hoge_cd != $next_hoge_cd)) {

                    // ¾®·×¤ò¥ª¥Ö¥¸¥§¥¯¥È¤Ë³ÊÇ¼
                    $this->sum_sale = $sum_sale_hoge;

                    // ¤Ô¤è1¹ÔÌÜ($start)¤«¤é¤Ô¤èºÇ½ª¹Ô($j)¤Þ¤Ç¤ÎABC¶èÊ¬¤òºîÀ®
                    $this->Set_ABC_Data($start, $j);

                    // ¤Ô¤èNo.¤ò½é´ü²½
                    $piyo_no = 0;

                    ///// ¾®·×¹Ô
                    {
                        // ¾®·×ÍÑ¤Ë¹ÔÈÖ¹æ¥«¥¦¥ó¥¿¤ò¥¤¥ó¥¯¥ê¥á¥ó¥È
                        $j++;

                        // ¾®·×¥Õ¥é¥°¤òtrue¤Ë
                        $this->disp_data[$j]["sub_flg"]                 = "true";

                        // ¤Û¤²ËèÇä¾å¶â³Û¡Ê¾®·×¡Ë
                        $this->disp_data[$j]["accumulated_sale_hoge"]   = $sum_sale_hoge;

                        // ¤Ô¤è1¹ÔÌÜ¤Ë¤Û¤²rowspan¤ò³ÊÇ¼
                        $this->disp_data[$start]["hoge_rowspan"]        = $hoge_rowspan + 1;
                    }

                }

                // ¹ÔÈÖ¹æ¥«¥¦¥ó¥¿¤ò¥¤¥ó¥¯¥ê¥á¥ó¥È
                $j++;

            } // foreach END

            ///// ¹ç·×¹Ô
            {
                // Çä¾å¶â³Û¹ç·×
                $this->disp_data[$j]["sum_sale"]    = $sum_sale_all;

                // Å¹ÊÞ¿ô
                $this->disp_data[$j]["count"]       = $hoge_no;
            }

        }

#    print_array($this);
#    exit;
    }


}


?>
