<?php
/**
 * Realex_Core extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Realex
 * @package    Realex_Core
 * @copyright  Copyright (c) 2015 StudioForty9
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Realex
 * @package    Realex_Core
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Realex_Core_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCcExpiryDate($payment)
    {
        return sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), 2));
    }

    public function getCcType($payment)
    {
        switch($payment->getCcType()){
            case 'VI':
            case 'VD':
                return 'visa';
            case 'MC':
                return 'mc';
            case 'AE':
                return 'amex';
            case 'SS':
                return 'switch';
            case 'LA':
                return 'laser';
            case 'DI':
                return 'diners';
            default:
                return '';
        }
    }

    public function log($data){
        if(Mage::getStoreConfig('realex/log/enabled')){
            Mage::log($data, null, 'realex.log', true);
        }
    }

    public function getDateFromTimestamp($timestamp){
        $year = substr($timestamp, 0, 4);
        $month = substr($timestamp, 4, 2);
        $day = substr($timestamp, 6, 2);
        $hour = substr($timestamp, 8, 2);
        $minutes = substr($timestamp, 10, 2);
        $seconds = substr($timestamp, 12, 2);
        $date = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minutes . ':' . $seconds;
        Mage::log($date);
        return strtotime($date);
    }
}