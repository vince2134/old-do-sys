<?php
/**
 * TaxRate.php
 *
 * Copyright (c) 2009, Bab Hitachi Soft Co.,Ltd 
 * All rights reserved.
 *
 */

/**
 * TaxRate Class
 *
 * @author Yukio Hashimoto <hashimoto-y@bhsk.co.jp>
 *
 */
class TaxRate
{

    public $date          = null;
    public $shop_id       = null;
    public $shop_tax_rate = null;

    /**
     * Constructor 
     *
     * @param int $shop_id The shop identification
     *
     * @access public
     *
     * @return void
     */
    public function __construct($shop_id)
    {

        $this->shop_id = $shop_id;

    }

    /**
     * Sets the value of the TaxRate's day 
     *
     * @param string $date taxrate date
     *
     * @access public
     *
     * @return void
     */
    public function setTaxRateDay($date)
    {
        //�׾������������ʤ���硢����ͤ��������դ�����
        $y = date("Y");
        $m = date("m");
        $d = date("d");

        $date_pattern = "/(\d{4})-(\d{2}|\d)-(\d{2}|\d)/";
        if (preg_match($date_pattern, $date, $match)) {
            if (@checkdate($match[2], $match[3], $match[1])) {
                $y = $match[1];
                $m = $match[2];
                $d = $match[3];
            }
        }

        $this->date = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

        $this->setOwnShopTaxRate();

    }

    /**
     * Gets the value of the TaxRate's day 
     *
     * @access public
     *
     * @return string
     */
    public function getTaxRateDay()
    {

        return $this->date;

    }


    /**
     * Sets an tax rate of the own shop
     *
     * @access public
     *
     * @return void
     */
    public function setOwnShopTaxRate()
    {
        $db_con = Db_Connect();

        //���Ҥξ�������������
        $sql  = "SELECT \n";
        $sql .= "    tax_rate_old, \n";
        $sql .= "    tax_rate_now, \n";
        $sql .= "    tax_change_day_now, \n";
        $sql .= "    tax_rate_new, \n";
        $sql .= "    tax_change_day_new \n";
        $sql .= "FROM \n";
        $sql .= "    t_client \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $this->shop_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $tax_rate_old       = pg_fetch_result($result, 0, 0);       //�������Ψ
        $tax_rate_now       = pg_fetch_result($result, 0, 1);       //��������Ψ
        $tax_change_day_now = pg_fetch_result($result, 0, 2);       //����Ψ������
        $tax_rate_new       = pg_fetch_result($result, 0, 3);       //��������Ψ
        $tax_change_day_new = pg_fetch_result($result, 0, 4);       //����Ψ������

        //����Ψ����������������դϵ������Ψ
        //��������Ψ�����������Ǥʤ�����������Ψ�ʸ�����դϿ�������Ψ
        //�嵭�ʳ��ϸ�������Ψ
        if ($this->date < $tax_change_day_now) {

            $this->shop_tax_rate = (int)$tax_rate_old;

        } elseif ($tax_change_day_new != null 
               && $this->date >= $tax_change_day_new) {

            $this->shop_tax_rate = (int)$tax_rate_new;

        } else {

            $this->shop_tax_rate = (int)$tax_rate_now;

        }

    }

    /**
     * Returns an tax rate of the own shop
     *
     * @access public
     *
     * @return int
     */
    public function getOwnShopTaxRate()
    {

        return $this->shop_tax_rate;

    }

    /**
     * Returns an tax rate of the client
     *
     * @param int $client_id The client identification
     *
     * @access public
     *
     * @return int
     */
    public function getClientTaxRate($client_id)
    {
        $this->getOwnShopTaxRate();

        $db_con = Db_Connect();

        //�����β��Ƕ�ʬ�����
        $sql  = "SELECT \n";
        $sql .= "    c_tax_div \n";
        $sql .= "FROM \n";
        $sql .= "    t_client \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $client_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $tax_div = pg_fetch_result($result, 0, 0);

        //���Ƕ�ʬ3������ǡˤμ����Ͼ�����Ψ0
        if ($tax_div == "3") {
            return 0;
        } else {
            return $this->shop_tax_rate;
        }

    }

}


?>