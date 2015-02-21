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
class Realex_Core_Model_Remote_Request extends DOMDocument
{
    protected $_request = null;
    protected $_type = null;
    protected $_attributes = array();
    protected $_children = array();
    protected $_data = array();
    protected $_comments = array();

    protected $_client = null;
    protected $_endpoint = null;
    protected $_config = array();

    public function __construct()
    {
        parent::__construct();

        $this->_request = $this->createElement('request');
        $this->appendChild($this->_request);

        $this->version = '1.0';
        $this->encoding = 'UTF-8';

        $this->_attributes['type'] = $this->_type;
        //$date = new Zend_Date();
        //$this->_attributes['timestamp'] = $date->toString('YmdHms');
        $this->_attributes['timestamp'] = date('YmdHis');

        $this->_getAccountDetails();

        $this->_children['comments'] = Mage::getModel('realex_core/remote_request_comments');
    }

    public function buildXml()
    {
        $this->_addAttributes();
        $this->_addTopLevelNodes();
        $this->_addChildNodes();
        Mage::dispatchEvent('realex_remote_request_build', array('request' => $this));
        return $this->saveXML();
    }

    public function send()
    {
        $client = $this->_getClient();
        $client->resetParameters();
        $client->setMethod('POST');

        $xml = $this->buildXml();
        Mage::helper('realex_core')->log($xml);
        $client->setRawData($xml, 'text/xml');

        $i = 0;
        do {
            $success = true;
            $i++;
            try {
                $response = $client->request('POST');
            } catch (Zend_Http_Client_Exception $e) {
                $success = false;
            }
        } while (!$success && $i < 5);

        if(!$response){
            Mage::throwException('No response');
        }

        Mage::dispatchEvent('realex_remote_response_receipt', array('request' => $this));

        Mage::helper('realex_core')->log($response->getBody());

        return $response->getBody();
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function setChildren($children)
    {
        $this->_children = $children;
    }

    public function getChildren()
    {
        return $this->_children;
    }

    protected function _getClient()
    {
        if(!$this->_client){
            $this->_client = new Varien_Http_Client($this->_endpoint, array('timeout' => 30));
        }

        return $this->_client;
    }

    protected function _getHash($fields, $secret){
        $tmp = implode($fields, '.');
        $sha1hash = sha1($tmp);
        $tmp = "$sha1hash.$secret";
        return sha1($tmp);
    }

    protected function _addAttributes()
    {
        foreach ($this->_attributes as $key => $value) {
            $this->_request->setAttribute($key, $value);
        }
    }

    protected function _addTopLevelNodes()
    {
        foreach ($this->getData() as $key => $value) {
            if (is_array($value)) {
                $node = new DOMElement($key, $value['value']);
                $this->_request->appendChild($node);
                foreach ($value['attributes'] as $attName => $attValue) {
                    $node->setAttribute($attName, $attValue);
                }
            } else {
                $this->_request->appendChild(new DOMElement($key, $value));
            }
        }
    }

    protected function _addChildNodes()
    {
        foreach($this->_children as $child){
            $this->_request->appendChild($child);
            $child->buildXml();
        }
    }

    protected function _getAccountDetails(){
        $storeId = Mage::app()->getStore()->getId();
        if(Mage::getStoreConfig('realex/test/enabled', $storeId)){
            $this->_config = Mage::getStoreConfig('realex/test', $storeId);
        }else{
            $this->_config = Mage::getStoreConfig('realex/account', $storeId);
        }

        $this->_data = array(
            'merchantid' => $this->_config['merchantid'],
            'account' => $this->_config['account']
        );
    }
}