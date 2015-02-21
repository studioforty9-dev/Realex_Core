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
abstract class Realex_Core_Model_Remote_Request_Element extends DOMElement
{
    protected $_data = array();
    protected $_attributes = array();

    protected $_customer = null;
    protected $_payment = null;
    protected $_order = null;

    public function __construct($name, $value){
        parent::__construct($name, $value);
    }

    public function buildXml(){
        foreach($this->getAttributes() as $key => $value){
            $this->setAttribute($key, $value);
        }

        foreach($this->getData() as $key => $value){
            if(is_array($value)){
                $node = new DOMElement($key, $value['value']);
                $this->appendChild($node);
                foreach($value['attributes'] as $attName => $attValue){
                    $node->setAttribute($attName, $attValue);
                }
            }else{
                $this->appendChild(new DOMElement($key, $value));
            }
        }
    }

    public function setData($data){
        $this->_data = $data;
    }

    public function getData(){
        return $this->_data;
    }

    public function getAttributes(){
        return $this->_attributes;
    }

    public function setCustomer($customer)
    {
        $this->_customer = $customer;
    }

    public function setPayment($payment)
    {
        $this->_payment = $payment;
    }

    public function setOrder($order)
    {
        $this->_order = $order;
    }
}